<?php 

session_start();

// initializing variables
$username = "";
$email    = "";
$designation="";
$errors = array(); 

// connect to the database
$db = mysqli_connect("localhost","root","","chef");
// REGISTER USER
if(isset($_POST['reg_user']))
{
  // receive all input values from the form
  $username = mysqli_real_escape_string($db, $_POST['username']);
  $email = mysqli_real_escape_string($db, $_POST['email']);
  $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
  $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);
  $designation = mysqli_real_escape_string($db, $_POST['designation']);

  // form validation: ensure that the form is correctly filled ...
  // by adding (array_push()) corresponding error unto $errors array
  if (empty($username)) { array_push($errors, "Username is required"); }
  if (empty($email)) { array_push($errors, "Email is required"); }
  if (empty($designation)) { array_push($errors, "Designation Field is required"); }
  if (empty($password_1)) { array_push($errors, "Password is required"); }
  if ($password_1 != $password_2) {
	array_push($errors, "The two passwords do not match");
  }

  // first check the database to make sure 
  // a user does not already exist with the same username and/or email
  $user_check_query = "SELECT * FROM users WHERE username='$username' OR email='$email' LIMIT 1";
  $result = mysqli_query($db, $user_check_query);
  $user = mysqli_fetch_assoc($result);
  
  if ($user) { // if user exists
    if ($user['username'] === $username) {
      array_push($errors, "Username already exists");
    }

    if ($user['email'] === $email) {
      array_push($errors, "email already exists");
    }
  }

  // Finally, register user if there are no errors in the form
  if (count($errors) == 0) {
  	$password = md5($password_1);//encrypt the password before saving in the database

  	$query = "INSERT INTO users (username, email, designation,password ) 
  			  VALUES('$username', '$email', '$designation','$password')";
  	mysqli_query($db, $query);
  	$_SESSION['username'] = $username;
  	$_SESSION['success'] = "You are now logged in";
    header("location:bill.html");
  }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title> Registering </title>
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
   margin-top:10%;
      margin-left:auto;
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
      width:100px;
      height:100px;
      border-radius: 50%;
      margin:0 auto;
    }
    </style>
      <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link href="css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection"/>
  <link href="css/style1.css" type="text/css" rel="stylesheet" media="screen,projection"/>
 
</head>
<body>
<div class="container">
<div class="login-div">
      <div class="row" style="height:200px;">
        <div class="logo" style="margin-left:110px;"><img src="img/TextLogo.png"></div>
      </div>
      <div class="row center-align">
        <h5> Register </h5>
        <h6> For your Hotel User Account</h6>
      </div>
  <form method="post" action="register.php">
  	<?php include('errors.php'); ?>
  	<div class="input-field col s12">
  	  <label>Username</label>
  	  <input type="text" name="username" value="<?php echo $username; ?>">
  	</div>
  	<div class="input-field col s12">
  	  <label>Email</label>
  	  <input type="email" name="email" value="<?php echo $email; ?>">
  	</div>
  	<div class="input-field col s12">
  	  <label>Password</label>
  	  <input type="password" name="password_1">
  	</div>
  	<div class="input-field col s12">
  	  <label>Confirm password</label>
  	  <input type="password" name="password_2">
      </div>
      <div class="input-field col s12">
  	  <label> Destination</label>
  	  <input type="text" name="designation" value="<?php echo $designation; ?>">
  	</div>
  	<div class="input-group">
  	  <button type="submit" class="waves-effect waves-light btn" name="reg_user">Register</button>
  	</div>
  	<p>
  		Already a member? <a href="login.php">Sign in</a>
  	</p>
  </form>
  
</body>
</html>