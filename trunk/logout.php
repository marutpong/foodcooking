<?php
if (!isset($_SESSION)) {
  session_start();
}
unset($_SESSION['UIDS']);
unset($_SESSION['USERNAME']);
session_destroy();
if (!empty($_GET['ref'])){
	header( "location: {$_GET['ref']}" );	
}else{
	header("Location: index.php");
}

exit;

?>