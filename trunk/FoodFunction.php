<?php
function myExe($strSQL){
	include 'connectDB.php'; 
	$objParse = oci_parse($objConnect , $strSQL);
	$objExecute = oci_execute($objParse);   	
	return $objExecute;  
}

function getIngeIdByName($inname){
	include 'connectDB.php'; 
	$strSQL = "SELECT * FROM IINGREDIENT WHERE INNAME = '$inname'";
	$objParse = oci_parse($objConnect, $strSQL);
	$objExecute = oci_execute($objParse, OCI_DEFAULT);
	$row = oci_fetch_array($objParse, OCI_BOTH);		
	return $row['IID'];
}

function getTypeIdByName($typename){
	include 'connectDB.php'; 
	$strSQL = "SELECT * FROM IFOODTYPE WHERE TYPENAME = '$typename'";
	$objParse = oci_parse($objConnect , $strSQL);
	$objExecute = oci_execute($objParse);   
	$row = oci_fetch_array($objParse, OCI_BOTH);	
	return $row['TYPEID'];
}

function getToolIdByName($name){
	include 'connectDB.php'; 
	$strSQL = "SELECT * FROM ITOOLS WHERE TOOLNAME = '$name'";
	$objParse = oci_parse($objConnect, $strSQL);
	$objExecute = oci_execute($objParse, OCI_DEFAULT);
	$row = oci_fetch_array($objParse, OCI_BOTH);	   	
	return $row['TID'];   	
}
function getFoodIdByName($name){
	include 'connectDB.php'; 
	$strSQL = "SELECT * FROM IFOODS WHERE FOODNAME = '$name'";
	$objParse = oci_parse($objConnect, $strSQL);
	$objExecute = oci_execute($objParse, OCI_DEFAULT);
	$row = oci_fetch_array($objParse, OCI_BOTH);	   	
	return $row['FID'];   	
}

function insertIngredient($inname, $unit){
	$strSQL = "INSERT INTO IINGREDIENT (INNAME, UNIT) VALUES ('$inname','$unit')";
	return(myExe($strSQL));
}

function insertTool($name){
	$strSQL = "INSERT INTO ITOOLS (TOOLNAME) VALUES ('$name')";
	return(myExe($strSQL));
}

function insertFoodType($name,$des){
	$strSQL = "INSERT INTO IFOODTYPE (TYPENAME, DESCRIPTION) VALUES ('$name','$des')";
	return(myExe($strSQL));
}

function insertContain($fid,$iid,$quantity){
	$strSQL = "INSERT INTO ICONTAIN (FID, IID, QUANTITY) VALUES ('$fid','$iid','$quantity')";
	return(myExe($strSQL));
}
function insertUse($fid,$tid){
	$strSQL = "INSERT INTO IUSE (FID, TID) VALUES ('$fid','$tid')";
	return(myExe($strSQL));
}
function insertFood($name,$picture,$method,$views,$owner,$foodtypeID){
	$strSQL = "INSERT INTO IFOODS (FOODNAME, PICTURE, METHOD, VIEWS, UIDS, TYPEID) VALUES ('$name','$picture','$method','$views','$owner','$foodtypeID')";
	return(myExe($strSQL));
}
function optionIngredient($id){
	include 'connectDB.php';
	$strSQL = "SELECT * FROM IINGREDIENT ORDER BY INNAME";
	$objParse = oci_parse($objConnect, $strSQL);
	$objExecute = oci_execute($objParse, OCI_DEFAULT);
	$rows="";
	while ($row = oci_fetch_array($objParse, OCI_BOTH)) {
		$selected = "";
		if (!empty($id) && ($row['IID']==$id) ){
			$selected = "selected";
		}
		$rows.= '<option value="'.$row['IID'].'" '.$selected.' >'.$row['INNAME'].'</option>';
	}
	return($rows);
}
function optionTool($id){
	include 'connectDB.php';
	$strSQL = "SELECT * FROM ITOOLS ORDER BY TOOLNAME";
	$objParse = oci_parse($objConnect, $strSQL);
	$objExecute = oci_execute($objParse, OCI_DEFAULT);
	$rows="";
	while ($row = oci_fetch_array($objParse, OCI_BOTH)) {
		$selected = "";
		if (!empty($id) && ($row['TID']==$id) ){
			$selected = "selected";
		}
		$rows.= '<option value="'.$row['TID'].'" '.$selected.' >'.$row['TOOLNAME'].'</option>';
	}
	return($rows);
}
function optionUser($id){
	include 'connectDB.php';
	$strSQL = "SELECT * FROM IUSERS ORDER BY NAME";
	$objParse = oci_parse($objConnect, $strSQL);
	$objExecute = oci_execute($objParse, OCI_DEFAULT);
	$rows="";
	while ($row = oci_fetch_array($objParse, OCI_BOTH)) {
		$selected = "";
		if (!empty($id) && ($row['UIDS']==$id) ){
			$selected = "selected";
		}
		$rows.= '<option value="'.$row['UIDS'].'" '.$selected.' >'.$row['NAME'].'</option>';
	}
	return($rows);
}
function optionFoodType($id){
	include 'connectDB.php';
	$strSQL = "SELECT * FROM IFOODTYPE ORDER BY TYPENAME";
	$objParse = oci_parse($objConnect, $strSQL);
	$objExecute = oci_execute($objParse, OCI_DEFAULT);
	$rows="";
	while ($row = oci_fetch_array($objParse, OCI_BOTH)) {
		$selected = "";
		if (!empty($id) && ($row['TYPEID']==$id) ){
			$selected = "selected";
		}
		$rows.= '<option value="'.$row['TYPEID'].'" '.$selected.' >'.$row['TYPENAME'].'</option>';
	}
	return($rows);
}
?>