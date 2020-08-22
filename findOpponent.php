<?php
$userid = $_REQUEST["userid"];
$getRating = $conn->query("SELECT `rating` FROM `users` WHERE `userid` = '$userid'");
$getRating->data_seek(0);
$rating = $getRating->fetch_assoc()["rating"];
$findOpponentRating = $conn->query("SELECT `rating`, `userid`, FROM ")

?>
