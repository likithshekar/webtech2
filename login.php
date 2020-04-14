<?php
    session_start();
    if(isset($_POST['inputusername1']) and isset($_POST['inputpassword1']))
    {
        $username = $_POST['inputusername1'];
        $pass = $_POST['inputpassword1'];
        $query = "SELECT * FROM `person` WHERE name='$username' and pass='$pass'";
        $result = mysql_query($query) or die(mysql_error());
        $count = mysql_num_rows($result);
        if ($count == 1){
            $_SESSION['inputusername1'] = $username;
            header('Location: content.php');
        }
        else
        {
            $msg = "Wrong credentials";
        }
    }

    if(isset($msg) & !empty($msg)){
        echo $msg;
    }
 ?>