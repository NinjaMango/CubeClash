<?php require_once("config.php")?>
<!DOCTYPE html>
    <html>
    <head>
        <?php htmlhead("Sign Up"); ?>
    </head>

    <body>
        <!-- create signup form -->
       <form id = "signup" action = "validateUser.php" method = "POST" onsubmit = "return validate();">
            <h2>Sign Up | <a href = "login.php"   class = "inactive">Log In</a></h2>
            <label>Username</label>
            <input type = "text" name = "username" id = "username"> <br>
            <label>Email</label>
            <input type = "email" name = "email" id = "email"> <br>
            <label>Password</label>
            <input type = "password" name = "password" id = "password"> <br>
            <label>Confirm Password</label>
            <input type = "password" name = "confirm" id = "confirm"> <br>
            <input type="hidden" id="signup" name="validateType" value="signup">
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
    

            
            //check for valid username
            if (!username.value.match(/^[0-9a-zA-Z]+$/)){
                document.getElementById("errormsg").innerHTML = "Usernames may only contain letters and numbers.";
                valid = false;
            }

            //check for username length over 16
            if (username.value.length > 16){
                document.getElementById("errormsg").innerHTML = "Usernames may only be at most 16 characters long.";
                valid = false;
            }

            //check for password length over 32 and below 8
            if (password.value.length < 5 || password.value.length > 32){
                document.getElementById("errormsg").innerHTML = "Passwords must be between 5 and 32 characters long.";
                valid = false;
            }

            if (confirm.value != password.value){
                document.getElementById("errormsg").innerHTML = "Passwords must match.";
                valid = false;
            }

            //check for non empty fields
            if (username.value == "" || email.value == "" || password.value == "" || confirm.value == ""){
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