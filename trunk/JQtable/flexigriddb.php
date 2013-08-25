<?php

header("Content-type:text/x-json; charset=UTF-8");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);

        include 'connectdb.php';



$page = $_POST['page'];
$rp = $_POST['rp'];
$sortname = $_POST['sortname'];
$sortorder = $_POST['sortorder'];
$where = '';
if($_POST['qtype']=='LID') {
	if(!ctype_alnum($_POST["query"])) {$where ='';$a=1;}
	else{
	 
	 if(!ctype_digit($_POST["query"])) {$where ='';$a=0;}
	 else $where ="WHERE LID = ".$_POST['query'];}
}

else if($_POST['qtype']=='POSITION') {
	 
	 if($_POST['query']==''){$where ='';$a=1;}
	 else{
	 if(!ctype_alnum($_POST["query"])) {$where ='';$a=0;}
	 else $where ="WHERE POSITION LIKE '%".$_POST['query']."%'";}
}


if (!$page)
    $page = 1;

if (!$sortname)
    $sortname = 'LID';
if (!$sortorder)
    $sortorder = 'asc';

if ($sortorder == 'desc')
    $sortorder == 'asc';
else
    $sortorder == 'desc';

if (!$rp)
    $rp = 10;

$start = (($page-1) * $rp);

$strSQL = "SELECT LID,POSITION,ADDRESS FROM LOCATION ".$where." ORDER BY LID ";
$objParse = oci_parse($objConnect, $strSQL);
oci_execute($objParse, OCI_DEFAULT);

$total = oci_fetch_all($objParse, $Result);

if ($total != 0) {

    $strSQL = "SELECT LID,POSITION,ADDRESS
FROM ( SELECT LID,POSITION,ADDRESS
FROM
( SELECT LID,POSITION,ADDRESS , ROWNUM r
  FROM
  ( SELECT LID,POSITION,ADDRESS FROM LOCATION  
        ".$where." ORDER BY LID ASC
    
  )
  WHERE ROWNUM <= " . ($start + $rp) . "
)
WHERE r >= " . ($start + 1) . ") ORDER BY ".$sortname." ".$sortorder."";



    $objParse = oci_parse($objConnect, $strSQL);
    $objExecute = oci_execute($objParse, OCI_DEFAULT);

    $data['page'] = intval($page); // 
    $data['total'] = intval($total); //
    while ($row = oci_fetch_array($objParse, OCI_BOTH)) {
        

        $rows[] = array(
            "id" => $row['LID'],
            "cell" => array(
                $row['LID']
                , $row['POSITION']
                , $row['ADDRESS']
            )
        );
    }
    $data['rows'] = $rows;
} else {
    $page = 0;
    $total = 0;
    $rows[] = array(
        "id" => '1',
        "cell" => array(
            '1'
            , '1'
        )
    );
    $data['page'] = intval($page); // 
    $data['total'] = intval($total);
    $data['rows'] = $rows;
}
echo json_encode($data);


exit;
?>