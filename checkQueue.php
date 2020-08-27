<?php
require_once("config.php");
$userid = $_REQUEST["userid"];
$conn->query("LOCK TABLES `matchqueue`, `matches` WRITE");
$getRating = $conn->query("SELECT `rating` FROM `users` WHERE `userid`='$userid'");
$getRating->data_seek(0);
$userRating = $getRating->fetch_assoc()["rating"];
//check if you have been placed in a match
$inMatch = $conn->query("SELECT `matchid` FROM `matches` WHERE `state` < 4 AND (`user1id` = '$userid' OR `user2id` = '$userid')");
if ($inMatch->num_rows == 1){
    //if placed in match, redirect to match
    $inMatch->data_seek(0);
    $matchid = $inMatch->fetch_assoc()["matchid"];
    echo "match:$matchid";
} else if ($inMatch->num_rows == 0){
    //look for potential matches, if rating within threshold, put in match, prioritize those who've waited longest
    $searchQueue = $conn->query("SELECT matchqueue.userid, users.rating FROM matchqueue, users WHERE users.userid=matchqueue.userid ORDER BY matchqueue.jointime");
    for ($j = 0; $j < $searchQueue->num_rows; $j++){
        $searchQueue->data_seek($j);
        $opponentid = $searchQueue->fetch_assoc()["userid"];
        if ($opponentid != $userid){
            $searchQueue->data_seek($j);
            $threshold = 100;
            $opponentRating = $searchQueue->fetch_assoc()["rating"];
            if (abs($opponentRating - $userRating) <= $threshold){
                require_once("getScramble.php");
                $conn->query("DELETE FROM `matchqueue` WHERE `userid` = '$userid' OR `userid` = '$opponentid'");
                $conn->query("INSERT INTO `matches` VALUES ('matchid', '$userid', '$opponentid', '$userRating', '$opponentRating', '', '$scramble', '0', NOW(), NULL)");
                echo "Creating Match";
            }
        }
    }
}
$conn->query("UNLOCK TABLES");

?>