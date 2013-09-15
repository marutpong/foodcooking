<?php
$SAVE_PATH = "files/";
if(!file_exists($SAVE_PATH)) mkdir($SAVE_PATH);
if (isset($_FILES["filUpload"])){
	move_uploaded_file($_FILES["filUpload"]["tmp_name"],$SAVE_PATH.$_FILES["filUpload"]["name"]);
}
?> 