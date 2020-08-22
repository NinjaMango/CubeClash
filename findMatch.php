<?php 
require_once("config.php");
logRequest(2);
?>
<!DOCTYPE html>
    <html>
    <head>
        <?php htmlhead("Finding Match"); ?>
    </head>
    <body>
        <h1>Finding Match For: <?php echo $_SESSION["username"] ?></h1>
        <h4> <a href = "home.php">Cancel</a> </h4>

        <!-- find opponent script -->
        <script>
            var findOpponent = new XMLHttpRequest();
            findOpponent.open("GET", "findOpponent.php?userid=<?php echo $_SESSION["userid"]; ?>")
            findOpponent.send();
        </script>

        <?php heartbeat(2) ?>
    </body>
</html>
