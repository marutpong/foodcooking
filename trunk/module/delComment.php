<?
if (!isset($_SESSION)) {
  session_start();
}
	if( !empty($_SESSION['UIDS']) && !empty($_SESSION['USERNAME']) && !empty($_POST['stime']) && !empty($_POST['foodid']) ){
		include('../FoodFunction.php');
		$strSQL = "DELETE FROM ICOMMENTS ";
		$strSQL .= "WHERE UIDS = '".$_SESSION['UIDS']."' ";
		$strSQL .= "AND FID = '".$_POST['foodid']."' "; 
		$strSQL .= "AND TO_TIMESTAMP (STIME) = TO_TIMESTAMP ('".$_POST['stime']."', 'DD Mon YYYY HH24:MI:SS.FF', ' NLS_DATE_LANGUAGE=THAI')";
		//echo $strSQL;
		if(myExe($strSQL)){
			echo "Complete";
			//echo '<meta http-equiv="refresh" content="0;url='.$_POST['ref'].'#'.$_SESSION['UIDS'].'">';
		} else {
			echo "InComplete";
		}
	}
?>