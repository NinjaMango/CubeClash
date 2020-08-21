<?php require_once("config.php")?>
<!DOCTYPE html>
    <html>
    <head>
        <?php htmlhead("Log In"); ?>
    </head>

    <body>
        <!-- create login form -->
        <form id = "login" action = "validateUser.php" method = "POST" onsubmit = "return validate();" autocomplete = "on">
                <h2>Log In| <a href = "signup.php"   class = "inactive"> Sign Up</a></h2>
                <label>Username/Email</label>
                <input type = "text" name = "username" id = "username"> <br>
                <label>Password</label>
                <input type = "password" name = "password" id = "password"> <br>
                <input type="hidden" id="signup" name="validateType" value="login">
                <input type="hidden" id="signup" name="email" value="none">
                <input type = "submit">
                <!-- ERROR MESSAGE AREA OF DOOOOOOM -->
                <h3 id = "errormsg">
                    <?php 
                    if (isset($_SESSION["error"]) && $_SESSION["error"] != "") {
                        echo $_SESSION["error"]; 
                    }
                    ?>
                </h3>

        </form>

        <!-- validation script -->
        <script>
        function validate(){
            var username = document.getElementById("username");
            var email = document.getElementById("email");
            var password = document.getElementById("password");
            var confirm = document.getElementById("confirm");
            var signup = document.getElementById("signup");

            var valid = true;
    

            

            //check for password length over 32 and below 8
            if (password.value.length < 5 || password.value.length > 32){
                document.getElementById("errormsg").innerHTML = "Passwords must be between 5 and 32 characters long.";
                valid = false;
            }

            //check for non empty fields
            if (username.value == "" || password.value == ""){
                document.getElementById("errormsg").innerHTML = "All fields must be filled.";
                valid = false;
           }
           
            //seems legit
            if(valid){
                signup.action = "validateUser.php";
                signup.method = "POST";
                signup.submit();
            } else {
                return false;
            }
            
        }
        </script>
    </body>

</html>