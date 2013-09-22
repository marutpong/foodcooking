<?
if (!isset($_SESSION)) {
  session_start();
}
include '../FoodFunction.php';
?>
<?
$likesrc = "../core/images/like.png";
if (hasLiked()){
	$likesrc = "../core/images/like2.png";
}
?>
<form action="like_submit.php">
<input name="foodid" type="hidden" value="<? echo $_GET['foodid'];?>" />
<input name="ref" type="hidden" value="<?=$_SERVER['REQUEST_URI']?>" />
<table>
  <tr>
    <td><input type="image" src="<?=$likesrc?>" name="im_edit" width="32" height="32"/></td>
    <td id="theLike">0
      </td>
     <td>
      likes</td>
  </tr>
</table>
</form>
<script>
	if(typeof(EventSource)!=="undefined")
  {
  var source2=new EventSource("like_flush.php?foodid=<? echo $_GET['foodid'];?>");
  source2.onmessage=function(event)
    {
	  document.getElementById("theLike").innerHTML=event.data;
//		alert(event.data);
    };
  }
else
  {
  //document.getElementById("result").innerHTML="Sorry, your browser does not support server-sent events...";
  }
</script>
