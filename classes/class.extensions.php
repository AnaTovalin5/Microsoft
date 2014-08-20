<?php
class Core {
        public $id;

        public function Core() {
            $this->id = $_SESSION["id"];
        }
        
        public function connectDB() {
            mysql_connect("localhost", "root","") or die("cannot connect");
            mysql_select_db("microsoft") or die("cannot select DB");
        }
        
//        public function offline() {
//            $no = "no";
//            $quest = "UPDATE people SET online = '$no' WHERE id  = '$this->id'";
//            mysql_query($quest) or die(mysql_error());
//        }
    }
?>
