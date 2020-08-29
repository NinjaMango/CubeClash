
<?php 
require_once("config.php");
logRequest(3);
?>
<!DOCTYPE html>
    <html>
    <head>
        <?php htmlhead("Finding Match"); ?>
    </head>
    <body>
        <!-- get all the match info -->
        <script>
        <?php
            $matchid = $_GET["matchid"];
            $getMatchInfo = $conn->query("SELECT * FROM `matches` WHERE `matchid`='$matchid'");
            $matchInfo = $getMatchInfo->fetch_row();
            $opponentid = "";
            $opponentRating = "";
            $opponentName = "";
            $scramble = $matchInfo[6];
            echo "  matchid = " . $matchInfo[0] . "; \n";;
            if ($matchInfo[1] == $userid){
                $opponentid = $matchInfo[2];
                $opponentRating = $matchInfo[4];
            } else {
                $opponentid = $matchInfo[1];
                $opponentRating = $matchInfo[3];
            }
            $getOpponentName = $conn->query("SELECT `username` FROM `users` WHERE `userid`='$opponentid'");
            $getOpponentName->data_seek(0);
            $opponentName = $getOpponentName->fetch_assoc()["username"];
            echo "          opponentid = " . $opponentid . "; \n";
            echo "          opponentRating = " . $opponentRating . "; \n";;
            echo "          opponentName = \"" . $opponentName . "\"; \n";;
            echo "          //hey! are you trying to cheat? well congrats, you did. I'm too lazy to encode this.\n";
            echo "          scramble = \"" . $scramble . "\"; \n";;
        ?>
        </script>

        <!-- display opponent info -->
        <h1 id="opponentname">Opponent: <?php echo $opponentName . " " . $opponentRating . "🏆";?></h1>
        <!-- game status -->
        <h1 id="status"></h1>

        <script>
        function solveCube() {
            var solved = new XMLHttpRequest();
            solved.open("GET", "endGame.php?matchid=<?php echo $matchid;?>&userid=<?php echo $userid; ?>&opponentid=<?php echo $opponentid;?>");
            solved.send();
            solved.onload = function(){
                console.log(solved.responseText);
            }
        }
        </script>
        <button id = "solved" onclick="solveCube()">Solved Cube</button>
        <script>
        function getStatus() {
            var getStatus = new XMLHttpRequest();
            getStatus.open("GET", "gameStatus.php?matchid=<?php echo $matchid;?>");
            getStatus.send();
            getStatus.onload = function(){
                if (getStatus.status == 200){
                    var status = getStatus.responseText.split('|');
                    console.log(status);
                    //pregame
                    if (status[0] == "0"){
                        document.getElementById("status").innerHTML = "Starting in " + status[1] +  "..." ;
                    }
                    //scramble
                    if (status[0] == "1"){
                        document.getElementById("status").innerHTML = "Scramble: " + scramble +  ". Inspection starting in " + status[1] + "...";
                    }
                    //inspection 
                    if (status[0] == "2"){
                        document.getElementById("status").innerHTML = "Inspection: " + status[1];
                    }
                    //solve 
                    if (status[0] == "3"){
                        document.getElementById("status").innerHTML = "Solving: " + status[1];
                    }
                    //solve 
                    if (status[0] == "4"){
                        if (status[1] == <?php echo $_SESSION["userid"]; ?>){
                            document.getElementById("status").innerHTML = "You Win!"; 
                        } else {
                            document.getElementById("status").innerHTML = "You Lose!"; 
                        }
                        setTimeout(() => {
                            window.location.replace("home.php");
                        }, 3000);
                    }
                } 
            }
        }
        var gameLoop = setInterval(() => {
           getStatus(); 
        }, 50);


        </script>
        <?php heartbeat(3) ?>
    </body>
</html>
