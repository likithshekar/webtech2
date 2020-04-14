<?php 
if (isset($_POST['inputusername1']) and isset($_POST['inputpassword1'])){
$name = $_POST['inputusername1'];
$pass = $_POST['inputpassword1'];

$query = "SELECT * FROM `person` WHERE name='$name' and pass='$pass'";
$result = mysql_query($query) or die(mysql_error());
$count = mysql_num_rows($result);
if ($count == 1){
$_SESSION['inputusername1'] = $username;
}else{
echo "Login failed.";
}
}
if (isset($_SESSION['inputusername1'])){
$username = $_SESSION['inputusername1'];
echo "Hello" . $username . "
";
echo "<a href='logout.php'>Logout</a>";}
?>