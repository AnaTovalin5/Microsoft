<?php
require_once 'class.extensions.php';

class login extends Core {
    public $id;
    public $username;
    public $mypassword;
    
    public function login() {
        $this->id = "";
        $this->username = "";
        $this->mypassword = "";
    }
    
    public function findUsername() {
            $query = "SELECT username FROM password WHERE username='$this->username'";
            $result = mysql_query($query) or die(mysql_error());
            $row = mysql_fetch_array($result);
            return $row;
        }
        
        public function checkUsername() {
            $row = $this->findUsername();
            
            if ($row["username"] !== $this->username) {
                $_SESSION["errorWrong"] = "error";
                header('location: login.php');
            } else {
                   return TRUE;   
            }
        }
        
        public function emptyFields() {
            if ($_POST['username'] == "" || $_POST['mypassword'] == "") {
                $_SESSION["errorGone"]="error";
                header('location:login.php');
            }  else {
                 return TRUE;
            }
        }
        
        public function findPassword() {
            $saltquery = "SELECT salt FROM password WHERE username='$this->username'";
            $saltresult = mysql_query($saltquery) or die("no saltresult");
            $salt = mysql_fetch_array($saltresult) or die("no salt");
            $this->hash = crypt($this->mypassword,$salt["salt"]);
            $passwordresult = mysql_query("SELECT password FROM password WHERE username ='$this->username'") or die("password query no worky");
            $row = mysql_fetch_array($passwordresult) or die("die");
            $this->row = $row["password"];
           // die("hash: ".$this->hash."<br> row: ".$this->row." <br>salt: ".$salt["salt"]);
        }
        
        public function findNames() {
            $idquery = "SELECT id FROM password WHERE username = '$this->username'";
            $idresult = mysql_query($idquery) or redirect();
            $idresource = mysql_fetch_array($idresult);
            $this->id= $idresource["id"];
//            $_SESSION["id"] = $this->id;
        }


        public function passwordCheck() {
            $this->findPassword();
            //$this->findNames();
                                    
            if ($this->hash == $this->row) {
                    $this->online();
                    $_SESSION["id"] = $this->username;
                    header('location: online.php');
                } else {
                   $_SESSION["loginError"] = "error";
                    header('location: login.php');
               }
            }
            
        public function online() {
            $this->findNames();
            $yes = "yes";
            $quest = "UPDATE people SET online = '$yes' WHERE id = '$this->id'";
            mysql_query($quest) or die(mysql_error());       
        }
        
        public function offline() {
            $this->findNames();
            $no = "no";
            $quest = "UPDATE people SET online = '$no' WHERE id  = '$this->id'";
            mysql_query($quest) or die(mysql_error());
        }
    }
?>
