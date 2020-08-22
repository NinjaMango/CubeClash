<?php
require_once("config.php");
//check if userid and pageid exists
if (null !== $_REQUEST["userid"] && null !== $_REQUEST["pageid"]){
    $userid = $_REQUEST["userid"];
    $pageid = $_REQUEST["pageid"];
    //insert/update user's heartbeat (userid, timestamp, pageid into db)
    $updateBeat = $conn->query("UPDATE `users` SET `lastseen`=NOW(), `pageid`='$pageid' WHERE `userid`='$userid'");
    

}
//check for users that have gone offline
$checkOffline = $conn->query("UPDATE `users` SET `pageid`='0' WHERE `lastseen` <= NOW() - INTERVAL 5 SECOND");


?>