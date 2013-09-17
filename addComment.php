<?
if (!isset($_SESSION)) {
  session_start();
}
	if( !empty($_SESSION['UIDS']) && !empty($_SESSION['USERNAME']) && !empty($_POST['comments']) && !empty($_POST['foodid']) ){
		include('FoodFunction.php');
		$strSQL = "INSERT INTO ICOMMENTS (UIDS, FID, MESSAGE,STIME) VALUES ('".$_SESSION['UIDS']."','".$_POST['foodid']."','".$_POST['comments']."', SYSDATE)";
		if(myExe($strSQL)){
			echo "Complete";
			echo '<meta http-equiv="refresh" content="0;url='.$_POST['ref'].'">';
		} else {
			echo "InComplete";
		}
	}
?>