<?
if (!isset($_SESSION)) {
  session_start();
}
if (is_numeric($_GET['lat']) && $_GET['lat']!=0 && is_numeric($_GET['lng']) && $_GET['lng']!=0 )
{
	$_SESSION['lat'] = $_GET['lat'];
	$_SESSION['lng'] = $_GET['lng'];
}

?>