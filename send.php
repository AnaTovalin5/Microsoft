<?php
             //connect to server
            mysql_connect('localhost','root', '') or die(mysql_error());
            //select database
            mysql_select_db("microsoft") or die(mysql_error());
            require_once 'class.onlineClass.php';
session_start();

//$id = $_SESSION['id'];
//$fquery = "SELECT * FROM friends WHERE friendid = '$id' OR id = '$id'";
//$friends = mysql_query($fquery) or die(mysql_error());
//
//$w = "WHERE ";
//$b = mysql_num_rows($friends);
// while($row = mysql_fetch_array($friends)){
//    if($row['friendid'] == $id){
//           $friendid = $row['id'];
//       }
//       else{
//           $friendid = $row['friendid'];
//       }
//     if($b > 1){
//         $w = $w."friends.id = ".$friendid." OR people.id = ".$friendid." OR ";
//     }
//     else{
//         $w = $w."friends.id = ".$friendid." OR people.id = ".$friendid;
//     }
//     $b--;
// }
$query = "SELECT *
                 FROM people
                 WHERE people.online = 'yes'";
$result = mysql_query($query) or die(mysql_error());
$rows = mysql_num_rows($result);

$online = array();

for($i = 0; $i < $rows; $i++){
    $row2 = mysql_fetch_array($result);
            $online[$i] = new onlineClass($row2['id'], $row2['online'], $row2['username']);
 }
echo json_encode($online);
?>
