<!-- Sign In Screen -->
<?php
// Initialize the session
error_reporting(E_ALL);
ini_set("display_errors", 1);

// Include config file
require_once "config.php";

// Initialize the session
session_start();
//print_r ($_SESSION);
$session_id = $_SESSION["id"];

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

function fill_depart($mysqli)
{
  // code...
  $output = '';

  $sql = "SELECT * FROM HR";
  $result = mysqli_query($mysqli, $sql);

  $output .= '<center><table style= "width:100%">
              <tr class="tblrow" id="headers">
                          <th>ID</th>
                          <th>NAME</th>
                          <th>SALARY</th>
                          <th>PROFESSION</th>
              </tr>';

  while ($row = mysqli_fetch_array($result)) {
    $output .= '<tr><td> '. $row['id'] . '</td>
                <td>' . $row['name'] . '</td>
                <td>' . $row['salary'] . '</td>
                <td>' . $row['profession'] . '</td></tr>';

  }
  $output .= '</table></center>';
  return $output;
}

//echo $_SESSION['id'];
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
    <link href="../css/index.css" rel="stylesheet">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  </head>
  <body data-spy="scroll" data-target=".fixed-top">


<div class= "login-card">
      <div class="box">

      <div class="title"><b>Welcome <?php echo $_SESSION['name']; ?></b></b>
      </div>
      <a href="signout.php" class = "signup-btn" style="">Signout</a><br><br><br><br>
            <label for="course" style="font-size: 20px;"><b>Department Dropdown</b></label><br><br>
                    <select name="department" id="department" style=" margin-bottom: 20px; width: 500px; padding: 5px 35px 5px 5px; font-size: 24px; height: 50px; -webkit-appearance: none; -moz-appearance: none; appearance: none; background: url(https://raw.githubusercontent.com/Akanksha1212/UniConnectWT/main/images/drop-down-arrow.png) 96% / 5% no-repeat #f1f1f1; color: dark grey;">
                      <option value="" selected="selected">Select whose details to be shown &nbsp &nbsp &nbsp</option>
                      <option value="HR">HR</option>
                      <option value="Manager">Manager</option>
                      <option value="Sales">Sales</option>
                      <option value="All">All</option>
                    </select><br><br>
              <div class="table" id= "show_dept">
              </div>
   </div>
 </div>

 <script type="text/javascript">
 $(document).ready(function(){
     $('#department').change(function () {
       var dept_id = $(this).val();
       $.ajax({
         url: "load_data.php",
         method: "POST",
         data:{dept_id:dept_id},
         success:function(data){
           $('#show_dept').html(data);
           }
         });

       });
 });
 </script>
 </body>
 </html>
