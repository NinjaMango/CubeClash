<?php 
require_once("config.php");
logRequest(10);
?>
<!DOCTYPE html>
    <html>
    <head>
        <?php htmlhead("Finding Match"); ?>
    </head>
    <body>
        <h1>Finding Match For: <?php echo $_SESSION["username"] ?></h1>
        <h4> <a href = "home.php">Cancel</a> </h4>
        <?php heartbeat(2) ?>
    </body>
</html>
