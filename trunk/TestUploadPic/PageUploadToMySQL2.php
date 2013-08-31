<html>
<head>
<title>ThaiCreate.Com Tutorial</title>
</head>
<body>
<?
	if(copy($_FILES["filUpload"]["tmp_name"],"myfile/".$_FILES["filUpload"]["name"]))
	{
		echo "Copy/Upload Complete<br>";

		//*** Insert Record ***//
		$objConnect = mysql_connect("localhost","root","root") or die("Error Connect to Database");
		$objDB = mysql_select_db("mydatabase");
		$strSQL = "INSERT INTO files ";
		$strSQL .="(Name,FilesName) VALUES ('".$_POST["txtName"]."','".$_FILES["filUpload"]["name"]."')";
		$objQuery = mysql_query($strSQL);		
	}
?>
<a href="PageUploadToMySQL3.php">View files</a>
</body>
</html>