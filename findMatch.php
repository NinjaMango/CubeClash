<?php 
require_once("config.php");
logRequest(2);
?>
<!DOCTYPE html>
    <html>
    <head>
        <?php htmlhead("Match"); ?>
    </head>
    <body>
        <h1>Finding Match For: <?php echo $_SESSION["username"] ?></h1>
        <h4> <a href = "leaveQueue.php">Cancel</a> </h4>

        <!-- find opponent script -->
        <script>
            //join waiting queue
            var joinQueue = new XMLHttpRequest();
            joinQueue.open("GET", "http://localhost/joinQueue.php?userid=<?php echo $_SESSION["userid"]; ?>")
            joinQueue.send();
            console.log("Joining queue...");
            joinQueue.onload = function(){
                    if (joinQueue.status != 200){
                        console.log("Error " + joinQueue.status + ": " + joinQueue.statusText);
                    } else {
                        console.log(joinQueue.responseText);
                    }
                }

            //check if found match
            setInterval(() => {
                var checkQueue = new XMLHttpRequest();
                checkQueue.open("GET", "http://localhost/checkQueue.php?userid=<?php echo $_SESSION["userid"]; ?>")
                //console.log("Checking for match...");
                checkQueue.onload = function(){
                    if (checkQueue.status != 200){
                        console.log("Error " + checkQueue.status + ": " + checkQueue.statusText);
                    } else {
                        console.log(checkQueue.responseText);
                        if (checkQueue.responseText[0] == "m"){
                            window.location.replace("match.php?matchid=" + checkQueue.responseText.split(":")[1] );
                        }
                    }
                }
                checkQueue.send();


            }, 500);
            
        </script>

        <?php heartbeat(2) ?>
    </body>
</html>
