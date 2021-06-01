<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
require_once "config.php";

$username = "";
$username_error = "";

if($_SERVER["REQUEST_METHOD"] == "POST") {
  	$username = trim($_POST['emailSu']);
  	$password = trim($_POST['passSu']);

  	$sql_u = "SELECT * FROM LOGIN WHERE username='$username'";
  	$res_u = mysqli_query($mysqli, $sql_u);

  	if (mysqli_num_rows($res_u) > 0) {
  	  $username_error = "Username already taken";
  	}

	// Check input errors before inserting in database
    if(empty($username_error)){

        // Prepare an insert statement
        $sql = "INSERT INTO LOGIN (username, password) VALUES (?, ?)";

        if($stmt = $mysqli->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("ss", $param_email, $param_password);

            // Set parameters
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
      	    $param_email = $username;

            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Redirect to login (index) page
                header("location: login.php");
            } else{
                echo "Something went wrong. Please try again later.";
            }

            // Close statement
            $stmt->close();
        }
    }
$mysqli->close();
}
?>


<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Website Title -->
    <title>Sign Up</title>

    <!-- Styles -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:400,400i,600,700,700i&amp;subset=latin-ext" rel="stylesheet">
    <link href="../css/styles.css" rel="stylesheet">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jsSHA/2.0.2/sha.js"></script>
  </head>
  <body data-spy="scroll" data-target=".fixed-top">


<div class= "login-card">
      <div class="box">

      <div class="title"><b>Holla Buddy!! <br> Create your Account</b></div> <br><br>

      <form method="post" onsubmit="return validateForm()" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" name= "login" id="login">
          <div class="inputBox">
             <span class="help-block" style= "color: red; float:right; font-size:15px;" ><?php echo $username_error; ?></span><br>
             <input type="text" name="emailSu" id="emailSu" required onkeyup="this.setAttribute('value', this.value);" value="">
             <label>Username (Email)</label>
          </div>

          <div class="inputBox">
            <input type="password" name="passSu" id="passSu" required onkeyup="this.setAttribute('value', this.value);" value="">
            <label>Password</label>
          </div>
          <span style="float: right;">Already Registered?</span><br><br>
          <input type="submit" name="sign-in" value="Register"> &nbsp &nbsp &nbsp
          <a href="login.php" class = "signup-btn" style="">Sign In</a>
      </form>

   </div>
 </div>

 <!-- Custom Javascript-->
 <script src="../js/validate.js" charset="utf-8"></script>
 </body>
 </html>
