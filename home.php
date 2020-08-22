<?php 
require_once("config.php");
logRequest(10);
?>
<!DOCTYPE html>
    <html>
    <head>
        <?php htmlhead("Home"); ?>
    </head>
    <body>
        <h1>Logged in as: <?php echo $_SESSION["username"] ?></h1>
        <h4> <a href = "findMatch.php">Find Match</a> </h4>
        <?php heartbeat(1)?>
    </body>
</html>
