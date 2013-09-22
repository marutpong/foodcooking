<?
if (!isset($_SESSION)) {
  session_start();
}
include '../FoodFunction.php';
if ( !(authenIdUser()) ) {
	header ("Location: ../login.php?ref=../foodDetail.php?foodid=".$_POST['foodid']);
	thispgaeRedirect();
	break;
}


	if (is_numeric($_POST['foodid']) && hasLiked($_POST['foodid'])){
		$strSQLlike = "DELETE FROM IFAVORITE WHERE FID = ".$_POST['foodid']."AND UIDS = ".$_SESSION['UIDS'];
		myExe($strSQLlike);
	} else if (is_numeric($_POST['foodid'])){
		$strSQLlike = "INSERT INTO IFAVORITE (UIDS, FID) VALUES ('".$_SESSION['UIDS']."','".$_POST['foodid']."')";
		myExe($strSQLlike);
	}
	thispgaeRedirect();
function thispgaeRedirect(){
	if (!empty($_POST['ref'])){
		header ("Location: ".$_POST['ref']);
	} else if (!empty($_POST['foodid'])) {
		header ("Location: ../foodDetail.php?foodid=".$_POST['foodid']);
	} else {
		header ("Location: ../index.php");
	}
}
?>
