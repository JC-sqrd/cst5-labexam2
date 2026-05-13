<?php
session_start();

if(!isset($_SESSION['usr_name'])){
    header('Location: index.php');
    exit();
}