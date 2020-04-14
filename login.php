<?php
session_start();
if (isset($_POST['inputusername1']) and isset($_POST['inputpassword1'])) {
    $username = $_POST['inputusername1'];
    $pass = $_POST['inputpassword1'];

    $host = "localhost";
    $dbusername = "root";
    $dbpassword = "";
    $dbname = "pharma";
    // Create connection
    $conn = new mysqli($host, $dbusername, $dbpassword, $dbname);

    $query = "SELECT * FROM `login` WHERE username='$username' and pass='$pass'";
    $result = mysql_query($query) or die(mysql_error());
    $count = mysql_num_rows($result);
    if ($count == 1) {
        $_SESSION['username'] = $username;
        header('Location: http://localhost/webtech2/home.html');
    } else {
        $msg = "Wrong credentials";
    }
}

if (isset($msg) & !empty($msg)) {
    echo $msg;
}
?>