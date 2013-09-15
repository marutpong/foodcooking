<?
include ('../FoodFunction.php');


if ($imname = uploadImage("files/",$_FILES["file"])){
	?>
	<img src="files/<?=$imname;?>" /><img src="files/_<?=$imname;?>" />
    <?
}
echo $imname;
?>
