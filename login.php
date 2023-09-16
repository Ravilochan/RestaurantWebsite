<?php
session_start();
$errors = array(); 

// connect to the database
$db = mysqli_connect("localhost","root","","chef");


// LOGIN USER
if (isset($_POST['login_user'])) {
  $username = mysqli_real_escape_string($db, $_POST['username']);
  $password = mysqli_real_escape_string($db, $_POST['password']);

  if (empty($username)) {
  	array_push($errors, "Username is required");
  }
  if (empty($password)) {
  	array_push($errors, "Password is required");
  }

 
	$password = md5($password);
  	$query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
  	$results = mysqli_query($db, $query);
  	if (mysqli_num_rows($results) == 1) {
  	  $_SESSION['username'] = $username;
  	  $_SESSION['success'] = "You are now logged in";
  	  header('location:bill.html');
  	}else {
  		array_push($errors, "Wrong username/password combination");
  	}
  }


?>

<!DOCTYPE html>

<head>
    <title>Login </title>
    <!-- Compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link rel="icon" href="images/Logo.png">

    <!-- Compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <style>
    body {

        align-items: center;
        justify-content: center;
    }

    .login-div {
        margin-top: 10%;
        margin-left: auto;
        margin-right: auto;
        /*margin:15% 30%;*/
        max-width: 470px;
        padding: 35px;
        border: 1px solid #ddd;
        border-radius: 8px;


        /* text-align:center;*/
    }

    .logo {
        background-image: url("Logo.png");
        width: 100px;
        height: 100px;
        border-radius: 50%;
        margin: 0 auto;
    }
    </style>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection" />
    <link href="css/style1.css" type="text/css" rel="stylesheet" media="screen,projection" />

</head>
<title>
</title>

<body>
    <div class="container">
        <div class="login-div">
            <div class="row" style="height:200px;">
                <div class="logo" style="margin-left:110px;"><img src="img/TextLogo.png" alt="Logo"></div>
            </div>
            <div class="row center-align">
                <h5>Sign in</h5>
                <h6>Use your Hotel User Account</h6>
            </div>
            <form method="POST" action="login.php">

                <div class="input-field col s12">
                    <input type="text" name="username" class="validate">
                    <label>Username</label>
                </div>

                <div class="input-field col s12">
                    <input type="password" name="password" class="validate">
                    <label>Password</label>
                </div>
                <div class="row">
                    <div class="col s12"><a href="#"><b>Forgot Password ?</b></a></div>
                </div>
                <div class="row">
                    <div class="col s12"> Difficulty in Logging In ? <a href="#"><b>Learn more</b></a></div>
                </div>
                <div class="row"></div>
                <div class="row">
                    <div class="col s6"><a href="register.php">Create account</a></div>
                    <div class="col s6 right-align">
                        <button class="waves-effect waves-light btn" name="login_user" type="submit">Login</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</body>

</html>