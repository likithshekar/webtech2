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
	else{
		$fname = "img/image5.jpg";
	}
    $file = fopen($fname,"rb");
    $size = filesize($fname);
    $media = fread($file,$size);
	fclose($file);
    echo $media;
?>
