<?php

$server = 'localhost';
$username = 'root';
$password = '';
$database = 'medicine';


$db = mysqli_connect($server, $username, $password, $database)
  or die('<b>Error Connecting to MySQL Server or Else DB Not Found!</b>');


session_start();

$error = "";

if (isset($_SESSION['login_user'])) {
  header("location:welcome.php");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $myusername = mysqli_real_escape_string($db, $_POST['username']);           //Email
  $mypassword = md5(mysqli_real_escape_string($db, $_POST['password']));      //Password
  //The password is hashed using MD5 Hashing

  $sql = "SELECT U_ID FROM user WHERE email = '$myusername' and password = '$mypassword'";
  $result = mysqli_query($db, $sql);
  $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

  $count = mysqli_num_rows($result);

  if ($count == 1) {
    $_SESSION['login_user'] = $myusername;
    $_SESSION['login_id'] = $row['U_ID'];

    header("location: welcome.php");
  }
  else {
    $error = "Your Login Name or Password is invalid";
  }
}
mysqli_close($db);
?>
