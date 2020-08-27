<?php
require_once("config.php");
//remove user from match queue and redirect to home page
$userid = $_SESSION["userid"];
$conn->query("DELETE FROM `matchqueue` WHERE `userid` = '$userid'");
header("Location: home.php");
?>