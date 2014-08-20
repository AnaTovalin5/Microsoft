<?php
    session_start();
    
    require_once('classes/class.login.php');
    $obj = new login();
    $obj->username = $_POST["username"];
    $obj->mypassword = $_POST["mypassword"];
    
    $obj -> connectDB();
    if ($obj -> emptyFields()) {
        if ($obj -> checkUsername()) {
            $obj ->passwordCheck() ;
        }
     }
?>
