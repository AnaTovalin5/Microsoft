<?php
   
    require_once('class.extensions.php');

    class checkNew extends Core {
            private $hash;
            private $salt;
            public $username;
            public $id;

            public function checkNew() {
                $this->hash = NULL;
                $this->salt = NULL;
                $this->username = $_POST["username"];
                $this->id = NULL;
            }

            public function emptyField($username, $password) {
               if ($username == "" || $password == "") {
                        $_SESSION["error"] = "error";
                        header('Location: newAccount.php');
               }  else {
                    return TRUE;
               }
            }

            public function findUsername() {
                $query = "SELECT username FROM password WHERE username='$this->username'";
                $result = mysql_query($query) or die(mysql_error());
                $row = mysql_fetch_array($result);
                return $row;
            }

            public function uniqueUsername() {
                $row = $this->findUsername();

                if ($row["username"] == $this->username) {
                    $_SESSION["errorCheck"] = "error";
                     header('location: newAccount.php');
                } else {
                     return TRUE;   
                }
            }
            
            public function encryptPassword() {
                $password = $_POST["password"];
                $stringsplit = str_split("./ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz");
                shuffle($stringsplit);
                $implode = implode($stringsplit);
                $substr = substr($implode, 0,22);
                $this->salt = "$2a$10$".$substr;
                $this->hash = crypt($password, $this->salt);
            }

            public function insertValues() {
                $username = $_POST['username'];
                $online = "yes";

                $query3 = "INSERT INTO password VALUES('', '$username', '$this->hash', '$this->salt')";
                $query4 = "INSERT INTO people VALUES('', '$username', '$online')";
                mysql_query($query3) or die(mysql_error());
                mysql_query($query4) or die("cannot connect");
            }
            
            public function findID() {
                $username = $_POST['username'];
                $query5 = "SELECT id FROM password WHERE username = '$username'";
                $result5 = mysql_query($query5) or die(mysql_error());
                $row = mysql_fetch_array($result5) or die("DEATH!");
                $id = $row['id'];
                $this->id = $id;
            }
            
            public function makeDirectory() {
                $this->findID();
                mkdir("users/".$this->id."/pictures",0777,TRUE);
                mkdir("users/".$this->id."/propics",0777,TRUE);      
           }
           
            public function loginGo() {
//                $_SESSION["id"] = $this->id;
                $_SESSION["id"] = $_POST['username'];
                header('Location: online.php');
            }
    }
?>
