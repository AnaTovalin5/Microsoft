<?php
    class wallClass
    {
        public function __construct() {
            
        }
        public function makepostbutton($senderid, $receiverid){
            echo "
                           <form method='post' action='post.php' enctype='multipart/form-data'>
                           <table>
                                <input type = 'hidden' name = 'senderid' value = '".$senderid."'>
                                <input type = 'hidden' name = 'receiverid' value = '".$receiverid."'>
                                 <input type = 'hidden' name = 'friendid' value = '".$receiverid."'>
                               <tr>Make a Post:</tr>
                               <tr><td><textarea cols='70' rows='5' name='post' id='createtextarea'></textarea> </td></tr>
                               </table>
                               <input type='submit' name='Submit' value='Update'>
                           </form><br>";
            $_SESSION['friendid'] = $receiverid;
        }
        public function findFriends(){
            $session = $_SESSION['session'];
            $r = $this->runQuery2("SELECT * FROM friends WHERE id = '$session->userid' OR friendid = '$session->userid'");
            return $r;
        }
        public function checkiffriendisyou($row){
            if($row['friendid'] == $_SESSION['session']->userid){
                        $friendid = $row['id'];
                    }
                    else{
                        $friendid = $row['friendid'];
                    }
                    return $friendid;
        }
        public function superResult(){
            $w =$this->superLoop();
            //echo $w; die();
            $superQuery = "SELECT time.Time, profile.id as profid, profile.Fname, profile.Lname, profile.Ppic, profile.Gender, pictures.id as pictid, pictures.picid, pictures.Title, pictures.Photo, friends.id as fid, friends.friendid, wallposts.postid as postid, wallposts.receiverid, wallposts.senderid, wallposts.post as post, wallcomments.postid as compostid, wallcomments.senderid as comsenderid, wallcomments.comment FROM time
                                      LEFT JOIN profile ON profile.Time = time.Time
                                      LEFT JOIN pictures ON pictures.Time = time.Time
                                      LEFT JOIN friends ON friends.Time = time.Time
                                      LEFT JOIN wallposts ON wallposts.Time = time.Time
                                      LEFT JOIN wallcomments ON wallcomments.Time = time.Time
                                      ".$w."
                                       ORDER BY time.Time DESC";
//            echo $superQuery; die();
            $superResult = mysql_query($superQuery) or die(mysql_error());            
            return $superResult;
        }

        public function superLoop(){
           $result = $this->findFriends();
           $w = "WHERE ";
           $i = mysql_num_rows($result);
           $result2 = mysql_num_rows($this->findFriends());
            if($result2 == 0){
               $w = $w."profile.id = ". $_SESSION['session']->userid ." OR pictures.id = ".$_SESSION['session']->userid." OR friends.id = ".$_SESSION['session']->userid." OR wallposts.receiverid = ".$_SESSION['session']->userid." OR wallposts.senderid = ".$_SESSION['session']->userid." OR wallcomments.senderid = ".$_SESSION['session']->userid;
            }
            else{
                while($row = mysql_fetch_array($result)){
                    $friendid = $this->checkiffriendisyou($row);
                    if($i >> 1){
                        $w = $w."profile.id = ". $friendid ." OR pictures.id = ".$friendid." OR friends.id = ".$friendid." OR wallposts.senderid = ".$friendid." OR wallposts.receiverid = ".$friendid." OR wallcomments.senderid = ".$friendid." OR ";
                    }
                    else{
                        $w = $w."profile.id = ". $friendid ." OR pictures.id = ".$friendid." OR friends.id = ".$friendid." OR wallposts.senderid = ".$friendid." OR wallposts.receiverid = ".$friendid." OR profile.id = ". $_SESSION['session']->userid ." OR pictures.id = ".$_SESSION['session']->userid." OR friends.id = ".$_SESSION['session']->userid." OR wallposts.receiverid = ".$_SESSION['session']->userid." OR wallposts.senderid = ".$_SESSION['session']->userid." OR wallcomments.senderid = ".$_SESSION['session']->userid;
                    }
                    $i--;
                }
            }
           return $w;
        }
        public function personif($superRow, $personid, $thing, $thing2, $path, $comment){
            $profile = $this->runQuery4("SELECT * FROM profile WHERE id = '$personid'");
            if($personid == $_SESSION['session']->userid){
                 echo "<div id = 'wallpost'><img src = 'users/".$personid."/profilepictures/".$profile['Ppic']."' height = 55px width = 50px><form method = 'post' action = '".$path."' id = 'nameform'>
                  <input type = 'submit' name = 'submit' value = 'You' id = 'friendname'></form> ".$thing." at ". $superRow['Time']."<br>
                      ".$comment."</div>
             ";
             }
             else{
                 echo "<div id = 'wallpost'><img src = 'users/".$personid."/profilepictures/".$profile['Ppic']."' height = 55px width = 50px><form method = 'post' action = 'other".$path."' id = 'nameform'>
                 <input type = 'hidden' name = 'friendid' value = '".$personid."'>
                  <input type = 'submit' name = 'submit' value ='".$profile['Fname']." ".$profile['Lname']."' id = 'friendname'></form>".$thing2." at ". $superRow['Time']."<br>
                      ".$comment."</div>
                      
             ";
             } 
        }
        public function echoWallstuff($superResult){
            while($superRow = mysql_fetch_array($superResult) or die(mysql_error())){
                
                if(isset($superRow['Gender'])){
                    $personid = $superRow['profid'];
                    $this->personif($superRow, $personid, "updated your profile", "updated their profile", "profile.php", "");      
                }
                
                if(isset($superRow['Title'])){
                    $personid = $superRow['pictid'];
                    $this->personif($superRow, $personid, "added a picture: <br><img src = 'users/".$personid."/pictures/".$superRow['Photo']."' height = '100px' width = '100px'><br>\"".$superRow['Title']."\"<br>", "added a picture: <br><img src = 'users/".$personid."/pictures/".$superRow['Photo']."' height = '100px' width = '100px'><br>\"".$superRow['Title']."\"<br>", "pictures.php", "");
                    $this->echocomments($superRow['picid']);
                    
                }
                
                if(isset($superRow['friendid'])){
                    if($superRow['fid'] == $_SESSION['session']->userid){
                        $personid = $superRow['friendid'];
                         $profile = $this->runQuery4("SELECT * FROM profile WHERE id = '$personid'");
                        $this->personif($superRow, $_SESSION['session']->userid, " added <img src = 'users/".$personid."/profilepictures/".$profile['Ppic']."' height = 55px width = 50px><form method = 'post' action = 'otherprofile.php' id = 'nameform'>
                 <input type = 'hidden' name = 'friendid' value = '".$personid."'>
                  <input type = 'submit' name = 'submit' value ='".$profile['Fname']." ".$profile['Lname']."' id = 'friendname'></form> as a friend", "added you as a friend", "friends.php", "");
                    }
                    else if($superRow['fid'] !=$_SESSION['session']->userid && $superRow['friendid'] != $_SESSION['session']->userid){
                        $person1id = $superRow['fid'];
                        $person2id = $superRow['friendid'];
                        $profile1 = $this->runQuery4("SELECT * FROM profile WHERE id = '$person1id'");
                        $profile2 = $this->runQuery4("SELECT * FROM profile WHERE id = '$person2id'");
                         echo "<div id = 'wallpost'><img src = 'users/".$person1id."/profilepictures/".$profile1['Ppic']."' height = 55px width = 50px><form id = 'nameform' method = 'post' action = 'otherprofile.php'>
                 <input type = 'hidden' name = 'friendid' value = '".$person1id."'>
                  <input type = 'submit' name = 'submit' value ='".$profile1['Fname']." ".$profile1['Lname']."' id = 'friendname'></form>added<img src = 'users/".$person2id."/profilepictures/".$profile2['Ppic']."' height = 55px width = 50px><form id = 'nameform' method = 'post' action = 'otherprofile.php'>
                 <input type = 'hidden' name = 'friendid' value = '".$person2id."'>
                  <input type = 'submit' name = 'submit' value ='".$profile2['Fname']." ".$profile2['Lname']."' id = 'friendname'></form> as a friend at ". $superRow['Time']."
             </div>";
                    }
                    else{
                        $personid = $superRow['fid'];
                        $this->personif($superRow, $personid, " added you as a friend", "added you as a friend", "friends.php", "");
                    }
                    
                }
         /////////////////////////////////////////       
                if(isset($superRow['post'])){
                    $rid = $superRow['receiverid'];
                    $sid = $superRow['senderid'];
                    $uid = $_SESSION['session']->userid;
                    if($rid == $uid){//someone wrote on your wall
                        if($sid != $uid){ //someone else wrote on your wall
                            $personid = $sid;
                               $profile = $this->runQuery4("SELECT * FROM profile WHERE id = '$personid'");
                                echo "<div id = 'wallpost'><img src = 'users/".$personid."/profilepictures/".$profile['Ppic']."' height = 55px width = 50px>
                                    <div>
                                    <form id = 'nameform' method = 'post' action = 'otherprofile.php'>
                                <input type = 'hidden' name = 'friendid' value = '".$personid."'>
                                 <input type = 'submit' name = 'submit' value ='".$profile['Fname']." ".$profile['Lname']."' id = 'friendname'></form></div><div> posted on your wall:<br>\"".$superRow['post']."\"<br>  at ". $superRow['Time']."</div>

                            ";
                                $this->echocomments($superRow['postid']);
                                    $this->addcommentbutton("<input type = 'hidden' name = 'postid' value = '".$superRow['postid']."'>");
                                    echo "</div>";
                        }
                        else if($sid == $uid){//you wrote on your wall
                            $personid = $sid;
                               $profile = $this->runQuery4("SELECT * FROM profile WHERE id = '$personid'");
                                echo "<div id = 'wallpost'><img src = 'users/".$personid."/profilepictures/".$profile['Ppic']."' height = 55px width = 50px><form id = 'nameform' method = 'post' action = 'profile.php'>
                                <input type = 'hidden' name = 'friendid' value = '".$personid."'>
                                 <input type = 'submit' name = 'submit' value ='You' id = 'friendname'></form> posted on your own wall:<br>\"".$superRow['post']."\"<br>  at ". $superRow['Time']."<br>

                            ";
                                $this->echocomments($superRow['postid']);
                                    $this->addcommentbutton("<input type = 'hidden' name = 'postid' value = '".$superRow['postid']."'>");
                                    echo "</div>";
                        }
                    }
                    elseif($rid != $uid){//someone wrote on someone elses wall
                            if($sid != $uid){//someone else wrote on someone elses wall
                                if($sid != $rid){//someone else wrote on a different persons wall
                                    $result = $this->findFriends();
                                    while($row = mysql_fetch_array($result)){
                                        $friendid = $this->checkiffriendisyou($row);
                                        if($sid != $friendid){ //if the sender wasn't your friend
                                            $personid = $sid;
                                            $sprofile = $this->runQuery4("SELECT * FROM profile WHERE id = '$personid'");
                                            $rprofile = $this->runQuery4("SELECT * FROM profile WHERE id = '$rid'");
                                             echo "<div id = 'wallpost'><img src = 'users/".$personid."/profilepictures/".$sprofile['Ppic']."' height = 55px width = 50px><form id = 'nameform' ethod = 'post' action = 'otherprofile.php'>
                                             <input type = 'hidden' name = 'friendid' value = '".$personid."'>
                                              <input type = 'submit' name = 'submit' value ='".$sprofile['Fname']." ".$sprofile['Lname']."' id = 'friendname'></form> posted on <img src = 'users/".$rid."/profilepictures/".$rprofile['Ppic']."' height = 55px width = 50px><form id = 'nameform' method = 'post' action = 'otherprofile.php'>
                                             <input type = 'hidden' name = 'friendid' value = '".$rid."'>
                                              <input type = 'submit' name = 'submit' value ='".$rprofile['Fname']." ".$rprofile['Lname']."' id = 'friendname'></form>'s wall:<br>\"".$superRow['post']."\"<br>  at ". $superRow['Time']."<br>
                                         ";
                                             $this->echocomments($superRow['postid']);
                                    $this->addcommentbutton("<input type = 'hidden' name = 'postid' value = '".$superRow['postid']."'>");
                                    echo "</div>";
                                        }
                                        else if($sid == $friendid){//your friend wrote on someones wall
                                            $personid = $sid;
                                            $sprofile = $this->runQuery4("SELECT * FROM profile WHERE id = '$personid'");
                                            $rprofile = $this->runQuery4("SELECT * FROM profile WHERE id = '$rid'");
                                             echo "<div id = 'wallpost'><img src = 'users/".$personid."/profilepictures/".$sprofile['Ppic']."' height = 55px width = 50px><form id = 'nameform' method = 'post' action = 'otherprofile.php'>
                                             <input type = 'hidden' name = 'friendid' value = '".$personid."'>
                                              <input type = 'submit' name = 'submit' value ='".$sprofile['Fname']." ".$sprofile['Lname']."' id = 'friendname'></form> posted on <img src = 'users/".$rid."/profilepictures/".$rprofile['Ppic']."' height = 55px width = 50px><form id = 'nameform' method = 'post' action = 'otherprofile.php'>
                                             <input type = 'hidden' name = 'friendid' value = '".$rid."'>
                                              <input type = 'submit' name = 'submit' value ='".$rprofile['Fname']." ".$rprofile['Lname']."' id = 'friendname'></form>'s wall:<br>\"".$superRow['post']."\"<br>  at ". $superRow['Time']."<br>
                                         ";
                                             $this->echocomments($superRow['postid']);
                                    $this->addcommentbutton("<input type = 'hidden' name = 'postid' value = '".$superRow['postid']."'>");
                                    echo "</div>";
                                        }
                                    }
                                }
                                else{//someone else wrote on their own wall
                                       $personid = $sid;
                                       $sprofile = $this->runQuery4("SELECT * FROM profile WHERE id = '$personid'");
                                        echo "<div id = 'wallpost'><img src = 'users/".$personid."/profilepictures/".$sprofile['Ppic']."' height = 55px width = 50px><form id = 'nameform' method = 'post' action = 'otherprofile.php'>
                                        <input type = 'hidden' name = 'friendid' value = '".$personid."'>
                                         <input type = 'submit' name = 'submit' value ='".$sprofile['Fname']." ".$sprofile['Lname']."' id = 'friendname'></form> posted on their wall:<br>\"".$superRow['post']."\"<br>  at ". $superRow['Time']."<br>   
                                    ";
                                        $this->echocomments($superRow['postid']);
                                    $this->addcommentbutton("<input type = 'hidden' name = 'postid' value = '".$superRow['postid']."'>");
                                    echo "</div>";
                                }
                            }
                            else if($sid == $uid){//you wrote on someone elses wall
                                $personid = $rid;
                                   $rprofile = $this->runQuery4("SELECT * FROM profile WHERE id = '$personid'");
                                   $sprofile = $this->runQuery4("SELECT * FROM profile WHERE id = '$sid'");
                                    echo "<div id = 'wallpost'><img src = 'users/".$sid."/profilepictures/".$sprofile['Ppic']."' height = 55px width = 50px><form id = 'nameform' method = 'post' action = 'profile.php'>
                                    <input type = 'hidden' name = 'friendid' value = '".$sid."'>
                                     <input type = 'submit' name = 'submit' value ='You' id = 'friendname'></form> posted on <img src = 'users/".$rid."/profilepictures/".$rprofile['Ppic']."' height = 55px width = 50px><form id = 'nameform' method = 'post' action = 'otherprofile.php'>
                                    <input type = 'hidden' name = 'friendid' value = '".$personid."'>
                                     <input type = 'submit' name = 'submit' value ='".$rprofile['Fname']." ".$rprofile['Lname']."' id = 'friendname'></form>'s wall:<br>\"".$superRow['post']."\"<br>  at ". $superRow['Time']."<br>
                                   ";
                                    $this->echocomments($superRow['postid']);
                                    $this->addcommentbutton("<input type = 'hidden' name = 'postid' value = '".$superRow['postid']."'>");
                                    echo "</div>";
                            }
                    }  
                    
                }
            }
        }
        public function superResult2($friendid){
            $superQuery = "SELECT time.Time, profile.id as profid, profile.Fname, profile.Lname, profile.Ppic, profile.Gender, pictures.id as pictid, pictures.picid, pictures.Title, pictures.Photo, friends.id as fid, friends.friendid, wallposts.postid as postid, wallposts.receiverid, wallposts.senderid, wallposts.post, wallcomments.postid as compostid, wallcomments.senderid as comsenderid, wallcomments.comment FROM time
                                      LEFT JOIN profile ON profile.Time = time.Time
                                      LEFT JOIN pictures ON pictures.Time = time.Time
                                      LEFT JOIN friends ON friends.Time = time.Time
                                      LEFT JOIN wallposts ON wallposts.Time = time.Time
                                      LEFT JOIN wallcomments ON wallcomments.time = time.Time
                                      WHERE profile.id = ". $friendid ." OR pictures.id = ".$friendid." OR friends.id = ".$friendid." OR wallposts.receiverid = ".$friendid." OR wallcomments.senderid = ".$friendid."
                                       ORDER BY time.Time DESC";
//            echo $superQuery; die();
            $superResult = mysql_query($superQuery) or die(mysql_error());            
            return $superResult;
        }
        public function otherwallstuff($personid){
            $profile = $this->runQuery4("SELECT * FROM profile WHERE id = '$personid'");
            echo "<center><u><b>".$profile['Fname']."'s Wall:</b></u></center><br>";
        }
    }

?>
