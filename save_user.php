<?php
session_start();
include 'db_connection.php';

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $user = $_POST['username'];
    $pass = $_POST['password'];
    $dob = $_POST['dob'];
    $contact_no = $_POST['contact_no'];
    $age = $_POST['age'];

    $sql = "SELECT usr_name FROM users WHERE usr_name =?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s",$user);
    $stmt->execute();
    $stmt->store_result();

    if($stmt->num_rows >0){
        echo "<script>alert('Username already taken!'); window.location.href='register.php';</script>";
    }else{
       $hashed_password = password_hash($pass, PASSWORD_DEFAULT);

       $sql ='INSERT INTO users (usr_name,usr_password,
        usr_contact,usr_dob,usr_age) VALUE (?,?,?,?,?)';

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssi", $user,$hashed_password, $contact_no,$dob,$age);

        if($stmt->execute()){
            echo "<script>alert('Registered Successfully! You can Login now.'); window.location.href='index.php';</script>";
        }else{
            echo "<script>alert('Error: Could not Register.);window.location.href='register.php;</script>";
        }
    }
    $stmt->close();
}

$conn->close();