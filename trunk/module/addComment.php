<?
if (!isset($_SESSION)) {
  session_start();
}
	if( !empty($_SESSION['UIDS']) && !empty($_SESSION['USERNAME']) && !empty($_POST['comments']) && !empty($_POST['foodid']) ){
		include('../FoodFunction.php');
		$strSQL = "INSERT INTO ICOMMENTS (UIDS, FID, MESSAGE,STIME) VALUES ('".$_SESSION['UIDS']."','".$_POST['foodid']."','".$_POST['comments']."', SYSDATE)";
		if(myExe($strSQL)){
		//	echo "Complete";
			echo '<meta http-equiv="refresh" content="0;url='.$_POST['ref'].'#'.$_SESSION['UIDS'].'">';
		} else {
		//	echo "InComplete";
		}
	}
	if (isset($_POST['ref'])){
		echo '<meta http-equiv="refresh" content="0;url='.$_POST['ref'].'#'.$_SESSION['UIDS'].'">';
	} else {
		echo '<meta http-equiv="refresh" content="0;url=../foodDetail.php?foodid='.$_POST['foodid'].'#'.$_SESSION['UIDS'].'">';
	}
?>