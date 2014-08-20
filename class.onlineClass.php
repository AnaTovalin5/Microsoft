<?php
    class onlineClass{
        public $id;
        public $online;
        public $username;
        public function __construct($id, $online, $username) {
            $this->id = $id;
            $this->online = $online;
            $this->username = $username;
        }
    }
?>
