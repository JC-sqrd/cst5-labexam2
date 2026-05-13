<?php 

if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['logout'])){
    session_unset();
    session_destroy();
    header("Location: index.php");
    exit();
}