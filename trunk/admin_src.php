<?
if (!isset($_SESSION)) {
  session_start();
}
include 'FoodFunction.php';
if ( !(authenAdmin()) ) {
	header ("Location: login.php?relog=1&msg=Permission denied. Please login with admin user.&ref=".$_SERVER['PHP_SELF']);
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Food Cooking</title>
    <link rel="stylesheet" type="text/css" href="core/css/jquery-ui-1.10.3.css">
    <script src="core/js/jquery-1.9.1.js"></script>
    <script src="core/js/jquery-ui-1.10.3.js"></script>
    <link rel="stylesheet" href="/resources/demos/style.css" />
<script>
$(function() {
	$( "#tabs" ).tabs({
		hide: { effect: "scale", duration: 800 },
		show: { effect: "scale", duration: 800 },
		beforeLoad: function( event, ui ) {
			var path = $(ui.tab).find("a").attr('href');
			path = "admin/"+path+"/index.php"
			 $('#tabs-2').attr('src', path);
		}

	});
});
</script>
</head>
<body> 
    <div id="tabs">
        <ul>
        <? $a = array("Users", "Food", "Shop", "Ingredient","Tools","Use","contain","have","Favorite","Comment","FoodType"); 
        
        for ($i =0 ;$i < count($a);$i++){
        ?>
        <li><a href="<? echo $a[$i]?>"><? echo $a[$i]?></a></li>
        <? } ?>
        </ul>
        <iframe id="tabs-2" width="100%" height="550" frameborder="0" marginheight="0" marginwidth="0" hspace="0" vspace="0"></iframe>
        </div>
    </div>
</body>
</html>