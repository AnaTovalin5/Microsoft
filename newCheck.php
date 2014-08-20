<?php
    session_start();
    
    require_once('classes/class.new.php');
    $obj = new checkNew();
    $obj->username = $_POST["username"];
    $password = $_POST["password"];
    
    $obj -> connectDB();
    
    if($obj -> emptyField($obj->username, $password)) {
       if ($obj -> uniqueUsername()) {
               $obj -> encryptPassword();
               $obj ->insertValues();
//               $obj ->makeDirectory();
               $obj ->loginGo();
       }
    }
?>
