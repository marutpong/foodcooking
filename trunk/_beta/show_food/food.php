<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>show food</title>
</head>
<body>
	<?
		include("../../../connectDB.php");
    	if(isset($_GET['id'])){
			$id=$_GET['id'];
			$strSQL = "select * from IFOODS where FID = $id";
			//echo $strSQL;
			$objParse = oci_parse($objConnect, $strSQL);
			$objExecute = oci_execute($objParse, OCI_DEFAULT);
			$row = oci_fetch_array($objParse, OCI_BOTH);	
			//echo $row['FID'];
		
	?>
    <table width="928" height="136" border="2">
      <tr>
        <td width="145">
			<? echo $row['FOODNAME']; ?>
        </td>
        <td width="765">
            <form>
            	<input type="button" name="like" id="like" value="like">
            </form>
        </td>
      </tr>
      <tr>
        <td><img src="../../Food/files/<? echo $row['PICTURE'] ?>"></td>
        <td>วัตถุดิบ<br>
        	<?
            	$strSQL = "select * from IFOODS f join icontain c on (f.fid=c.fid) join iingredient i on (c.iid=i.iid) where f.FID = $id";
				//echo $strSQL;
				$objParse = oci_parse($objConnect, $strSQL);
				$objExecute = oci_execute($objParse, OCI_DEFAULT);
				$ingredients = array();
				while($ingredient = oci_fetch_array($objParse, OCI_BOTH)){
					$ingredients[]=$ingredient;
					//echo $ingredient['INNAME']."<br>";
				}
				$count = 1;
				foreach($ingredients as $in){
					echo "\t".$count.". ".$in['INNAME']."\t".$in['QUANTITY']."\t".$in['UNIT']."<br>";
					$count++;
				}
			?>
        </td>
      </tr>
    </table>
    วิธีทำ<br>
    <table width="574" height="136">
      <tr>
        <td width="566">
        	
        	<? echo $row['METHOD']; ?>
        </td>
      </tr>
    </table>
    แสดงความคิดเห็น<br>
    <form action="" method="post" enctype="multipart/form-data">
    <table width="574" height="136">
      <tr>
        <td width="566">
        	<textarea name="method" cols="100" rows="5" class="input" required="required" id="method" tabindex="2"></textarea>
        </td>
      </tr>
      <tr>
      	<td align="right">
        	<input type="submit" class="button_sub" value="Post" tabindex="4">
        </td>
      </tr>
    </table>
    </form>
    
    <?
		//$strSQL = "select * from iusers natural join icomments natural join ifoods";
		$strSQL = "select * from iusers join icomments on (iusers.uids=icomments.uids) join ifoods on (icomments.fid=ifoods.fid) order by stime";
		$objParse = oci_parse($objConnect, $strSQL);
		$objExecute = oci_execute($objParse, OCI_DEFAULT);
		$comments = array();
		while($comment = oci_fetch_array($objParse, OCI_BOTH)){
			$comments[]=$comment;
			//echo $ingredient['INNAME']."<br>";
			echo "<div style='width:600'>";
			echo $comment['NAME']." ได้แสดงความคิดเห็นเมื่อ ".$comment['STIME']."<br>";
			echo $comment['MESSAGE'];
			echo "</div>";
		}
    ?>
<? }else echo "hello"; ?>
</body>
</html>