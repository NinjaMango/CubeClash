
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
            echo "  userid = " . $_SESSION["userid"] . "; \n";
            echo "          username = \"" . $_SESSION["username"] . "\"; \n";
            $matchid = $_GET["matchid"];
            $getMatchInfo = $conn->query("SELECT * FROM `matches` WHERE `matchid`='$matchid'");
            $matchInfo = $getMatchInfo->fetch_row();
            $opponentid = "";
            $opponentRating = "";
            $opponentName = "";
            $scramble = $matchInfo[8];
            $frame = "";
            echo "          matchid = " . $matchInfo[0] . "; \n";;
            if ($matchInfo[1] == $userid){
                $opponentid = $matchInfo[2];
                $opponentRating = $matchInfo[4];
                $frame = $matchInfo[5];
            } else {
                $opponentid = $matchInfo[1];
                $opponentRating = $matchInfo[3];
                $frame = $matchInfo[6];
            }
            $getOpponentName = $conn->query("SELECT `username` FROM `users` WHERE `userid`='$opponentid'");
            $getOpponentName->data_seek(0);
            $opponentName = $getOpponentName->fetch_assoc()["username"];
            echo "          opponentid = " . $opponentid . "; \n";
            echo "          opponentRating = " . $opponentRating . "; \n";;
            echo "          opponentName = \"" . $opponentName . "\"; \n";;
            echo "          //hey! are you trying to cheat? well congrats, you did. I'm too lazy to encode this.\n";
            echo "          scramble = \"" . $scramble . "\"; \n";;
            echo "          frame = " . $frame . "; \n";;
        ?>
        </script>

        <!-- display opponent info and video -->
        <h1 id="opponentname">Opponent: <?php echo $opponentName . " " . $opponentRating . "🏆";?></h1>
        <img id = "opponentvideo" src = "">
        <script>
            function opponentVideo() {
                var opponentVideo = new XMLHttpRequest();
                opponentVideo.open("GET", "opponentVideo.php?matchid=<?php echo $matchid; ?>&opponentid=<?php echo $opponentid; ?>");
                opponentVideo.send();
                opponentVideo.onload = function(){
                    if (opponentVideo.readyState === 4) {
                        if (opponentVideo.status === 200) {
                            console.log("opponentVideo.php?matchid=<?php echo $matchid; ?>&opponentid=<?php echo $opponentid; ?>");
                            document.getElementById("opponentvideo").src = opponentVideo.responseText;
                        }
                    } 
                }
            }
        </script>

        <!-- game status -->
        <h1 id="status"></h1>

        <button id = "solved" onclick="solveCube()">Solved Cube</button>


        <!-- display yourself and send image to server -->
        <video  style = "display:none" id= "usercamera" controls autoplay></video>
        <canvas id = "userdisplay" width = 320 height = 240></canvas>
        <script>
            //get video and canvas elements
            usercamera = document.getElementById("usercamera");
            userdisplay = document.getElementById("userdisplay");
            ctx = userdisplay.getContext("2d");
            constraints = {
                video: true
            };

            //stream the video
            navigator.mediaDevices.getUserMedia(constraints)
                .then((stream) => {
                    usercamera.srcObject = stream;
                })
            
            function sendImage(){
                //draw image on client screen
                ctx.drawImage(usercamera, 0, 0, userdisplay.width, userdisplay.height);
                //send image to server
                var sendImage = new XMLHttpRequest();
                sendImage.open("POST", "processImage.php", true);
                sendImage.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                sendImage.onload = function () {
                    if (sendImage.readyState === 4) {
                        if (sendImage.status === 200) {
                            console.log(sendImage.responseText);
                        }
                    }
                };
                frame += 1;
                sendImage.send("matchid=" + matchid + "&userid=" + userid + "&frame=" + frame + "&img=" + userdisplay.toDataURL())
            }
        </script>

        
        <!-- solve cube button -->
        <script>
            function solveCube() {
                var solved = new XMLHttpRequest();
                solved.open("GET", "endGame.php?matchid=<?php echo $matchid;?>&userid=<?php echo $userid; ?>&opponentid=<?php echo $opponentid;?>");
                solved.send();
                
            }
        </script>
        
        <!-- get game status -->
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
           sendImage();
           opponentVideo();
        }, 50);


        </script>
        <?php heartbeat(3) ?>
    </body>
</html>
