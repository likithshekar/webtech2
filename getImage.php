<?php
	header("Content-type:image/jpg");
	if ($_POST["id"] == 0){
		$fname = "img/image1.jpg";
	}
	else if ($_POST["id"] == 1){
		$fname = "img/image2.jpg";
	}
	else if ($_POST["id"] == 2){
		$fname = "img/image3.jpg";
	}
	else if ($_POST["id"] == 3){
		$fname = "img/image4.jpg";
	}
	else if ($_POST["id"] == 4){
		$fname = "img/image5.jpg";
	}
	else if ($_POST["id"] == 5){
		$fname = "img/image6.jpg";
	}
	else if ($_POST["id"] == 6){
		$fname = "img/image7.jpg";
	}
	else if ($_POST["id"] == 7){
		$fname = "img/image8.jpg";
	}
	else if ($_POST["id"] == 8){
		$fname = "img/image9.jpg";
	}
	else {
		$fname = "img/image10.jpg";
	}
    $file = fopen($fname,"rb");
    $size = filesize($fname);
    $media = fread($file,$size);
	fclose($file);
    echo $media;
?>
