<?php
session_start();

include 'db_connection.php';

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $user = $_POST['username'];
    $pass = $_POST['password'];

    $sql = "SELECT * FROM users WHERE usr_name = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $user);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows >0){
        $row = $result->fetch_assoc();

        if(password_verify($pass, $row['usr_password'] )) {
            $_SESSION['usr_name'] = $user;
            $_SESSION['pass_word'] =  $row['usr_password'];  
              $_SESSION['usr_fname']  = $row['usr_fname'];  
              $_SESSION['usr_phone']  = $row['usr_phone'];  
              $_SESSION['usr_dob']  = $row['usr_dob'];  

            
            header("Location: dashboard.php");
            exit();
        }else{
            echo "<script>alert('Invalid Credentials');</script>";
        }
    }else{
        echo "<script>alert('Invalid Credentials');</script>";
    }
}