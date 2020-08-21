<?php

function htmlhead($title){
    echo "<title>" . $title . " | Cube Clash</title> \n";
    echo "        <style> @import 'style.css' </style> \n";
}

$conn = new mysqli("localhost", "root", "", "cubeclash");
session_start();
?>