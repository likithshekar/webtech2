<?php
	$text = "AAAAA";
	if ($_GET["id"] == 0){
		$text = "Nature";
	}
	else if ($_GET["id"] == 1){
		$text = "Hill";
	}
	else if ($_GET["id"] == 2){
		$text = "Lake";
	}
	else if ($_GET["id"] == 3){
		$text = "Sunset";
	}
	elseif ($_GET["id"] == 4){
		$text = "Nature";
	}
    echo $text;
?>
