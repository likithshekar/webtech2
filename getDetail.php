<?php
	$text = "AAAAA";
	if ($_GET["id"] == 0){
		$text = "Crocin";
	}
	else if ($_GET["id"] == 1){
		$text = "Crocin - Fast Relief";
	}
	else if ($_GET["id"] == 2){
		$text = "Otrivin";
	}
	else if ($_GET["id"] == 3){
		$text = "Nasivion";
	}
	elseif ($_GET["id"] == 4){
		$text = "PAN-D";
	}
	elseif ($_GET["id"] == 5){
		$text = "Rantac";
	}
	elseif ($_GET["id"] == 6){
		$text = "Fluticon - FT";
	}
	elseif ($_GET["id"] == 7){
		$text = "Volini";
	}
	elseif ($_GET["id"] == 8){
		$text = "Volini Cream";
	}
	else {
		$text = "Ketosol - 2%";
	}
    echo $text;
?>
