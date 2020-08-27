<?php
$lastTwist = "";
$lastAxis = "";
$scramble = "";
$moves = ["L", "R", "U", "D", "F", "B"];
$suffixes = ["", "'", "2"];

for ($j = 0; $j < 20; $j++){
    $createdMove = false;
    $move = random_int(0, 5);
    while (!$createdMove){
        if ($lastTwist == $move || $lastAxis == floor($move/2)){
            $move = random_int(0, 5);
        } else {
            $createdMove = true;
        }
    }
    $scramble = $scramble . $moves[$move] . $suffixes[random_int(0, 2)] . " ";
    $lastTwist = $move;
    $lastAxis = floor($move/2);
}
echo $scramble;
?>