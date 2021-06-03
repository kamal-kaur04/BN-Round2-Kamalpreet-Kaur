<!-- Sign In Screen -->
<?php
// Initialize the session
error_reporting(E_ALL);
ini_set("display_errors", 1);
session_start();

// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: index.php");
    exit;
}

// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){

  $username = trim($_POST["emailSi"]);
	$password = trim($_POST["passSi"]);

	if(empty($username_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT ID, username, password FROM LOGIN WHERE username = ?";

        if($stmt = $mysqli->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("s", $param_username);

            // Set parameters
            $param_username = $username;

            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Store result
                $stmt->store_result();

                // Check if username exists, if yes then verify password
                if($stmt->num_rows == 1){
                    // Bind result variables
                    $stmt->bind_result($id, $username, $hashed_password);
                    if($stmt->fetch()){
                        if(password_verify($password, $hashed_password)){
                            // Password is correct, so start a new session
                            session_start();

                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["name"] = $username;

                            // Redirect user to welcome page
                            header("location: index.php");
                        } else{
                            // Display an error message if password is not valid
                            $password_err = "The password you entered is not valid.";
                        }
                    }
                } else{
                    // Display an error message if username doesn't exist
                    $username_err = "No account found with this username.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            $stmt->close();
        }
    }

    // Close connection
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
    <title>Sign In </title>

    <!-- Styles -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:400,400i,600,700,700i&amp;subset=latin-ext" rel="stylesheet">
    <link href="../css/styles.css" rel="stylesheet">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jsSHA/2.0.2/sha.js"></script>
  </head>
  <body data-spy="scroll" data-target=".fixed-top">


<div class= "login-card">
      <div class="box">

      <div class="title"><b>Hello! <br> Sign In to your Account</b></div> <br><br>

      <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" name= "login" id="login">

          <div class="inputBox">
             <span class="help-block" style= "color: red; float:right; font-size:15px;" ><?php echo $username_err; ?></span>
             <input type="text" name="emailSi" id="emailSi" required onkeyup="this.setAttribute('value', this.value);" value="">
             <label>Username (Email)</label>
          </div>

          <div class="inputBox">
            <span class="help-block" style= "color: red; float:right; font-size:15px;"><?php echo $password_err; ?></span>
            <input type="password" name="passSi" id="passSi" required onkeyup="this.setAttribute('value', this.value);" value="">
            <label>Password</label>
          </div>
          <br><br>
          <span style="float: right;">Not Registered Yet?</span><br><br>
          <input type="submit" name="sign-in" value="Sign In"> &nbsp &nbsp &nbsp
          <a href="signup.php" class = "signup-btn" style="">Register</a>
      </form>

   </div>
 </div>

 <!-- Custom Javascript-->
 </body>
 </html>
