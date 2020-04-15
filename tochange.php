<html>
<body>

<?php
	include ('session.php');
	
#	$query = "SELECT Price FROM medicine WHERE M_ID=$mid";
#	$result  = mysqli_query($db, $query) or die (mysqli_error($db));
	
	extract($_GET);
	$file=file_get_contents("seats.json");
	$jason=json_decode($file,true);
	
	if($value=="AMT"){
		if($jason["amt"]>=0){
			$jason["amt"]=$jason["amt"]+$amt;
			$newstring=json_encode($jason);
			file_put_contents("seats.json", $newstring);
		}
	}
	//fclose($file);
	$file=file_get_contents("seats.json");
	$jason=json_decode($file,true);
	echo $jason["amt"];
	sleep(3);
?>
</body>
</html>