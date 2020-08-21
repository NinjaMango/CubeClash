<?php
    //get 2nd element of exploded img info sent and decode it
    $img = base64_decode(explode(',', $_REQUEST["img"])[1]);
    $filepath = "matches/match" . $_REQUEST["match"] . "/" . $_REQUEST["user"];
    $frame = $_REQUEST["frame"];
    while (strlen($frame) <= 5){
        $frame = "0" . $frame;
    }
    //create img file and write to it
    if (!file_exists($filepath)){
        mkdir($filepath, 0777, true);
    }
    echo $filepath . "/frame" . $frame . ".png";
    $file = fopen($filepath . "/frame" . $frame . ".png", "w.");
    fwrite($file, $img);
    fclose($file);
?>