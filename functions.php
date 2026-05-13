<?php 

function displayName(){
    echo ($_SESSION['usr_name'] ?? '');
}