<?php
if (!isset($_SESSION)) {
  session_start();
}
$_SESSION['UIDS']=NULL;
$_SESSION['USERNAME']=NULL;
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