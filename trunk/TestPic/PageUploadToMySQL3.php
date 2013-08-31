<html>
<head>
<title>ThaiCreate.Com Tutorial</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head>
<body>
<?
	$objConnect = mysql_connect("localhost","root","root") or die("Error Connect to Database");
	$objDB = mysql_select_db("mydatabase");
	$strSQL = "SELECT * FROM files";
	$objQuery = mysql_query($strSQL) or die ("Error Query [".$strSQL."]");
?>
<table width="340" border="1">
<tr>
<th width="50"> <div align="center">Files ID </div></th>
<th width="150"> <div align="center">Picture</div></th>
<th width="150"> <div align="center">Name</div></th>
<th width="150"> <div align="center">Edit</div></th>
</tr>
<?
	while($objResult = mysql_fetch_array($objQuery))
	{
?>
<tr>
<td><div align="center"><?=$objResult["FilesID"];?></div></td>
<td><center><img src="myfile/<?=$objResult["FilesName"];?>"></center></td>
<td><center><?=$objResult["Name"];?></center></td>
<td><center><a href="PageUploadToMySQL4.php?FilesID=<?=$objResult["FilesID"];?>">Edit</a></center></td>
</tr>
<?
	}
?>
</table>
<?
mysql_close($objConnect);
?>
</body>
</html>