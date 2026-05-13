<?php
session_start();
include 'db_connection.php';

if (isset($_POST['update_user'])) {

    $usr_id    = (int)$_POST['usr_id'];
    $usr_name  = $_POST['usr_name'];
    $usr_fname = $_POST['usr_fname'];
    $usr_mname = $_POST['usr_mname'];
    $usr_phone = $_POST['usr_phone'];
    $usr_dob   = !empty($_POST['usr_dob']) ? $_POST['usr_dob'] : null;

    // 1) Get current image (so we keep it if no new upload)
    $current_image = null;
    $getSql = "SELECT usr_image FROM users WHERE usr_id = ?"; //So if the user does not upload a new image, you can keep the existing one.
                                                              // Also used so you can delete the old image when a new one is uploaded.
    if ($getStmt = $conn->prepare($getSql)) {
        $getStmt->bind_param("i", $usr_id);
        $getStmt->execute();
        $res = $getStmt->get_result();
        if ($row = $res->fetch_assoc()) {
            $current_image = $row['usr_image'];
        }
        $getStmt->close();
    }

    $usr_image = $current_image; // default: keep old

    // 2) Handle upload if there is a new file
    if (isset($_FILES['usr_image']) && $_FILES['usr_image']['error'] === UPLOAD_ERR_OK) { //exists only when your form has:enctype="multipart/form-data"    a file input named usr_image

        $tmpName  = $_FILES['usr_image']['tmp_name'];
        $fileSize = $_FILES['usr_image']['size'];

        // Validate it's a real image
        $imgInfo = @getimagesize($tmpName);
        if ($imgInfo === false) {
            $_SESSION['msg'] = "Invalid file. Please upload an image.";
            header("Location: dashboard.php");
            exit();
        }

        // Allowed extensions
        $allowedExt = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $ext = strtolower(pathinfo($_FILES['usr_image']['name'], PATHINFO_EXTENSION));

        if (!in_array($ext, $allowedExt)) {
            $_SESSION['msg'] = "Invalid image type. Allowed: JPG, JPEG, PNG, GIF, WEBP.";
            header("Location: dashboard.php");
            exit();
        }

        // Optional: size limit (2MB)
        if ($fileSize > 2 * 1024 * 1024) {
            $_SESSION['msg'] = "Image too large. Max size is 2MB.";
            header("Location: dashboard.php");
            exit();
        }

        // Ensure upload folder exists
        $uploadDir = __DIR__ . "/uploads/";
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        // Create unique filename
        $newFileName = "user_" . $usr_id . "_" . time() . "." . $ext; //Creates a unique filename:

        if (!move_uploaded_file($tmpName, $uploadDir . $newFileName)) {  //PHP uploads files into a temporary location first.move_uploaded_file() is the proper safe way to store it permanently.
            $_SESSION['msg'] = "Failed to upload image.";
            header("Location: dashboard.php");
            exit();
        }

        // Optional: delete old image file (if exists)
        if (!empty($current_image) && file_exists($uploadDir . $current_image)) {
            @unlink($uploadDir . $current_image);  //Prevents your uploads folder from filling up with unused old images.The @ hides warnings if deletion fails.
        }

        $usr_image = $newFileName;
    }

    // 3) Update user including usr_image
    $sql = "UPDATE users 
            SET usr_name = ?, usr_fname = ?, usr_mname = ?, usr_phone = ?, usr_dob = ?, usr_image = ?
            WHERE usr_id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssi", $usr_name, $usr_fname, $usr_mname, $usr_phone, $usr_dob, $usr_image, $usr_id);

    if ($stmt->execute()) {
        $_SESSION['msg'] = "User updated successfully.";
    } else {
        $_SESSION['msg'] = "Error updating user: " . $conn->error;
    }

    $stmt->close();
    $conn->close();

    header("Location: dashboard.php");
    exit();

} else {
    header("Location: dashboard.php");
    exit();
}