<?php
session_start();
include 'db_connection.php';

if (isset($_POST['delete_user'])) {

    $usr_id = $_POST['usr_id'];

    // Soft delete: update status_id to 0
    $sql = "UPDATE users SET usr_status = 0 WHERE usr_id = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $usr_id);

    if ($stmt->execute()) {
        $_SESSION['msg'] = "User deleted successfully.";
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
?>

// // soft delete
// <?php
// session_start();
// include 'db_connection.php';

// if (isset($_POST['delete_user'])) {
//     $usr_id = $_POST['usr_id'];

//     // Soft delete: set status_id = 0
//     $sql = "UPDATE users SET status_id = 0 WHERE usr_id = ?";
//     $stmt = $conn->prepare($sql);
//     $stmt->bind_param("i", $usr_id);

//     if ($stmt->execute()) {
//         $_SESSION['msg'] = "User deleted successfully.";
//     } else {
//         $_SESSION['msg'] = "Error deleting user: " . $conn->error;
//     }

//     $stmt->close();
//     $conn->close();

//     header("Location: dashboard.php");
//     exit();
// } else {
//     header("Location: dashboard.php");
//     exit();
// }