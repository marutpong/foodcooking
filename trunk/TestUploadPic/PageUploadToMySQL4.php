<html>
<head>
<title>ThaiCreate.Com Tutorial</title>
</head>
<body>
<?
	$objConnect = mysql_connect("localhost","root","root") or die("Error Connect to Database");
	$objDB = mysql_select_db("mydatabase");
	$strSQL = "SELECT * FROM files WHERE FilesID = '".$_GET["FilesID"]."' ";
	$objQuery = mysql_query($strSQL) or die ("Error Query [".$strSQL."]");
	$objResult = mysql_fetch_array($objQuery);
?>
	<form name="form1" method="post" action="PageUploadToMySQL5.php?FilesID=<?=$_GET["FilesID"];?>" enctype="multipart/form-data">
	Edit Picture :<br>
	Name : <input type="text" name="txtName" value="<?=$objResult["Name"];?>"><br>
	<img src="myfile/<?=$objResult["FilesName"];?>"><br>
	Picture : <input type="file" name="filUpload"><br>
	<input type="hidden" name="hdnOldFile" value="<?=$objResult["FilesName"];?>">
	<input name="btnSubmit" type="submit" value="Submit">
	</form>
</body>
</html>