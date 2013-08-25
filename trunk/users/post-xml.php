<?php
include 'connectDB.php';

$page = isset($_POST['page']) ? $_POST['page'] : 1;
$rp = isset($_POST['rp']) ? $_POST['rp'] : 10;
$sortname = isset($_POST['sortname']) ? $_POST['sortname'] : 'id';
$sortorder = isset($_POST['sortorder']) ? $_POST['sortorder'] : 'desc';
$query = isset($_POST['query']) ? $_POST['query'] : false;
$qtype = isset($_POST['qtype']) ? $_POST['qtype'] : false;

$usingSQL = true;

$page = $_POST['page'];
$rp = $_POST['rp'];
$sortname = $_POST['sortname'];
$sortorder = $_POST['sortorder'];

if (!$sortname) $sortname = 'id';
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
foreach($rows AS $row){
	$xml .= "<row id='".$row['ID']."'>";
	$xml .= "<cell><![CDATA[".$row['ID']."]]></cell>";
	$xml .= "<cell><![CDATA[".$row['NAME']."]]></cell>";
	$xml .= "<cell><![CDATA[".$row['USERNAME']."]]></cell>";
	$xml .= "<cell><![CDATA[".$row['PASSWORD']."]]></cell>";
	$xml .= "<cell><![CDATA[".$row['GENDER']."]]></cell>";
	$xml .= "<cell><![CDATA[".$row['BIRTHDATE']."]]></cell>";
	$xml .= "<cell><![CDATA[".$row['LATITUDE']."]]></cell>";
	$xml .= "<cell><![CDATA[".$row['LONGITUDE']."]]></cell>";
	$xml .= "</row>";
}
$xml .= "</rows>";
echo $xml;

//Display as JSON
//header("Content-type: application/json");
/*$jsonData = array('page'=>$page,'total'=>$total,'rows'=>array());
foreach($rows AS $row){
	//If cell's elements have named keys, they must match column names
	//Only cell's with named keys and matching columns are order independent.
	$entry = array('IID'=>$row['ID'],
		'cell'=>array(
			'ID'=>$row['ID'],
			'NAME'=>$row['NAME'],
			'USERNAME'=>$row['USERNAME'],
			'PASSWORD'=>$row['PASSWORD']		),
	);
	$jsonData['rows'][] = $entry;
}
echo json_encode($jsonData);
*/