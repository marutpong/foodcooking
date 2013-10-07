<html lang="en">
<head>
<title>Simplest jQuery Slideshow</title>
 
<style>
body {font-family:Arial, Helvetica, sans-serif; font-size:12px;}
 
.fadein { 
position:relative; height:332px; width:500px; margin:0 auto;
background: url("slideshow-bg.png") repeat-x scroll left top transparent;
padding: 10px;
 }
.fadein img { position:absolute; left:10px; top:10px; }
</style>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<script>
$(function(){
	$('.fadein img:gt(0)').hide();
	setInterval(function(){$('.fadein :first-child').fadeOut().next('img').fadeIn().end().appendTo('.fadein');}, 3000);
});
</script>
</head>
<body>
<div class="fadein">
<img src="1.jpg" height="200" width="200">
<img src="2.jpg" height="200" width="200">
<img src="3.jpg" height="200" width="200">
<img src="4.jpg" height="200" width="200">
<img src="5.jpg" height="200" width="200">
</div>
</body>
</html>