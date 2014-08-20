<?php
    session_start();
    
    require_once'classes/class.login.php';
    $obj = new login();
    
    $obj->connectDB();
    $obj->offline();
    header('location:login.php');
?>
