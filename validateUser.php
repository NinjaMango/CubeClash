<?php
    require_once("config.php");

    //get user info 
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $validateType = $_POST['validateType'];
    if ($validateType == "login"){
        $email = $username;
    }
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $userFound = false;
    $verified = 0;
    $_SESSION["error"] = "";
    $validated = true;

    //check for special characters in username
    if ($username != filter_var($username, FILTER_SANITIZE_STRING)){
        $_SESSION["error"] = "Names may only contain letters and numbers.";
        header("Location: " . $validateType . ".php");
        $validated = false;
    }

    //check if info is set
    if ($username == "" || $password == "" || $email == ""){
        $validated = false;
    }
    //loop through usernames
    $usernames = $conn->query("SELECT * FROM users");
    for($j = 0; $j < $usernames->num_rows; $j++){
        $usernames->data_seek($j);
        //if row's username matches the one we have, check validate type
        if ($username == $usernames->fetch_assoc()["username"]){
            //if signing up, return that username is taken and redirect to signup page
            if ($validateType == "signup"){
                $_SESSION["error"] = "This username is already taken. Please try another.";
                header("Location: signup.php");
                $usernames->close();
                $validated = false;
                $userFound = true;
            }
            //if logging in, check password
            if ($validateType == "login"){
                $usernames->data_seek($j);
                //if correct, redirect to home and store username, otherwise, redirect to loginpage with incorrect username / password
                if (password_verify($password, $usernames->fetch_assoc()["password"])){
                    header("Location: home.php");
                    $_SESSION["username"]  = $username;
                    $userFound = true;
                } else {
                    $_SESSION["error"] = "Invalid username/password.";
                    header("Location: login.php");
                    $usernames->close();
                    $userFound = true;
                }
            
            }
        }
    }

    //loop through emails
    $emails = $conn->query("SELECT * FROM users");
    for($j = 0; $j < $emails->num_rows; $j++){
        $emails->data_seek($j);
        //if row's email matches username's email, check signup method.
        if ($email == $emails->fetch_assoc()["email"]){

            //if signup mode, return error message and redirect to signup page
            if ($validateType == "signup"){
                $_SESSION["error"] = "This email is being used. Forgot Password?";
                header("Location: signup.php");
                $emails->close();
                $validated = false;
                $userFound = true;
            }
            //if login mode, check if password matches. if yes, redirect to home page. else, redirect to login page and return error mesage.
            if ($validateType == "login"){
                $emails->data_seek($j);
                if (password_verify($password, $emails->fetch_assoc()["password"])){
                    header("Location: home.php");
                    $emails->data_seek($j);
                    $_SESSION["username"] = $emails->fetch_assoc()["username"];
                    $userFound = true;
                } else {
                    $_SESSION["error"] = "Invalid email/password.";
                    header("Location: login.php");
                    $emails->close();
                    $userFound = true;
                }
            
            }
        }

    }

    //add new user to database and add verification hash and stats
    if ($validated && $validateType == "signup"){
        $insert = $conn->query("INSERT INTO users VALUES" . "('userid','$username','$hash', '$email', CURRENT_TIMESTAMP(), CURRENT_TIMESTAMP(), '1', '1000', '0')");
        if (!$insert) echo ($conn->connect_error);
          //redirect to session
        header("Location: /home.php");
        $_SESSION["username"] = $username;
        $_SESSION["id"] = $id;
    }
    if (!$userFound && $validateType == "login"){
        $_SESSION["error"] = "Invalid username/password.";
        header("Location: login.php");
        
    }
      

    $conn->close();
    $usernames->close();
    $emails->close();
?>

