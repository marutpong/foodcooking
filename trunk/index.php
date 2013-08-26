<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8" />
<title>Food Cooking</title>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<link rel="stylesheet" href="/resources/demos/style.css" />
<script>
$(function() {
$( "#tabs" ).tabs({
	collapsible: true
}
);
});
</script>
</head>
<body>
<div id="tabs" style="height:630px;background:#333;">
    <ul>
    <? $a = array("Users", "Food", "Shop", "Ingredient","Tools","Use","contain"); 
    
    for ($i =0 ;$i < count($a);$i++){
    ?>
    <li><a href="#tabs-<? echo ($i+1) ?>"><? echo $a[$i]?></a></li>
    <? } ?>
    </ul>

	<? for ($i =0 ;$i < count($a);$i++){ ?>
    <div id="tabs-<? echo ($i+1) ?>" >
    <iframe src="<? echo $a[$i]?>" width="100%" height="550" frameborder="0" marginheight="0" marginwidth="0" hspace="0" vspace="0"></iframe>
    </div>
    <? } ?>
</div>
</body>
</html>