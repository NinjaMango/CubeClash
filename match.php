<!-- User's Camera -->
<p>You</p>
<video  style = "display:none" id= "usercamera" controls autoplay></video>
<canvas id = "canvas" width = 320 height = 240></canvas>
<button id = "finish">Finish</button>
<p id = "test"></p>
<script>
    //get video and canvas elements
    const usercamera = document.getElementById("usercamera");
    const canvas = document.getElementById("canvas");
    const ctx = canvas.getContext("2d");
    const constraints = {
        video: true
    };

    //stream video
    navigator.mediaDevices.getUserMedia(constraints)
        .then((stream) => {
            usercamera.srcObject = stream;
        })
    
    //match info
    const match = <?php echo $_GET["match"];?>;
    const user = <?php echo "'" .  $_GET["userid"] . "'";?>;
    frame = 0;
    //send image to server every 50ms
    var gameLoop = setInterval(function(){sendImage()}, 50);
    function sendImage(){
        //draw image on screen
        ctx.drawImage(usercamera, 0, 0, canvas.width, canvas.height);
        var sendImage = new XMLHttpRequest();
        sendImage.open("POST", "processImage.php", true);
        sendImage.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        sendImage.onload = function () {
            if (sendImage.readyState === 4) {
                if (sendImage.status === 200) {
                    document.getElementById("test").innerHTML = sendImage.responseText;
                }
            }
        };
        sendImage.send("matchid=" + match + "&userid=" + user + "&frame=" + frame + "&img=" + canvas.toDataURL());

        
        
        frame++;
    };

    //stop image stream
    function finishStream(){
        var finishStream = new XMLHttpRequest();
        finishStream.open("POST", "finishStream.php", true);
        finishStream.send("match=" + match + "&user=" + user);
        clearInterval(gameLoop);
    }
    const finish = document.getElementById("finish");
    finish.addEventListener("click", function(){finishStream();})


</script>