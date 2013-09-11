<?php
include 'connectDB.php';
//Get Collum Name
$qstrSQL = " Select COLUMN_NAME from user_tab_columns where table_name='$table'";
$qobjParse = oci_parse($objConnect, $qstrSQL);
$qobjExecute = oci_execute($qobjParse, OCI_DEFAULT);
$qcolumn = array();
while ($row = oci_fetch_array($qobjParse, OCI_BOTH)) {
	$qcolumn[] = $row['COLUMN_NAME'];
}
//$qcolumn = array_intersect($qcolumn, array("PASSWORD"));// Show Only
$qcolumn = array_diff($qcolumn,array("PASSWORD"));//Not display
//	print_r($qcolumn);
$dfSortname = $qcolumn[0];//id

$page = isset($_POST['page']) ? $_POST['page'] : 1;
$rp = isset($_POST['rp']) ? $_POST['rp'] : 10;
$sortname = isset($_POST['sortname']) ? $_POST['sortname'] : $dfSortname;
$sortorder = isset($_POST['sortorder']) ? $_POST['sortorder'] : 'desc';
$query = isset($_POST['query']) ? $_POST['query'] : false;
$qtype = isset($_POST['qtype']) ? $_POST['qtype'] : false;

$usingSQL = true;

$page = $_POST['page'];
$rp = $_POST['rp'];
$sortname = $_POST['sortname'];
$sortorder = $_POST['sortorder'];

if (!$sortname) $sortname = $dfSortname;
if (!$sortorder) $sortorder = 'desc';

$sort = "ORDER BY $sortname $sortorder";

if (!$page) $page = 1;
if (!$rp) $rp = 10;

$start = (($page-1) * $rp);

$where = '';
//$query = $_GET['q'];
//$qtype = $_GET['t'];
if ($query) $where = " WHERE $qtype LIKE '%".mysql_real_escape_string($query)."%' ";

$paging = "WHERE ROWNUM <= ".($start+$rp);
$strSQL = "SELECT * FROM $table $where";
$objParse = oci_parse($objConnect, $strSQL);
oci_execute($objParse, OCI_DEFAULT);
$total = oci_fetch_all($objParse, $Result);
//$strSQL = "SELECT * FROM $table $where $paging $sort";
$strSQL = "
	SELECT * FROM 
		( SELECT x.* , ROWNUM r FROM 
		   ( SELECT * FROM $table $where $sort) x
		 $paging )
	WHERE r > $start
";
//echo $strSQL;
	$objParse = oci_parse($objConnect, $strSQL);
    $objExecute = oci_execute($objParse, OCI_DEFAULT);
	$rows = array();
    while ($row = oci_fetch_array($objParse, OCI_BOTH)) {
		$rows[] = $row;
}
// Diasplay as XML
header("Content-type: text/xml");
$xml = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
$xml .= "<rows>";
$xml .= "<page>$page</page>";
$xml .= "<total>$total</total>";
foreach($rows as $row){
	$xml .= "<row id='".$row[$qcolumn[0]]."'>";
	foreach ($qcolumn as $qc){
		$xml .= "<cell><![CDATA[".$row[$qc]."]]>$qcolumn[$i]</cell>";
	}
	$xml .= "</row>";
}
$xml .= "</rows>";
echo $xml;
/*
//Display as JSON
header("Content-type: application/json");
$jsonData = array('page'=>$page,'total'=>$total,'rows'=>array());
foreach($rows AS $row){
	//If cell's elements have named keys, they must match column names
	//Only cell's with named keys and matching columns are order independent.
	$entry = array('IID'=>$row['IID'],
		'cell'=>array(
			'IID'=>$row['IID'],
			'NAME'=>$row['NAME'],
			'QUANTITY'=>$row['QUANTITY'],
			'UNIT'=>$row['UNIT']		),
	);
	$jsonData['rows'][] = $entry;
}
echo json_encode($jsonData);
*/