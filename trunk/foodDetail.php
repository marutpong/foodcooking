<?
if (!isset($_SESSION)) {
  session_start();
}
include 'FoodFunction.php';
$editable=false;
if(!empty($_GET['foodid']) && is_numeric($_GET['foodid'])){
	$strSQL = " Select FID,FOODNAME,PICTURE,VIEWS,METHOD,UIDS,TYPEID,TYPEID,TYPENAME,NAME from IFOODS NATURAL JOIN IUSERS NATURAL JOIN IFOODTYPE WHERE FID = ".$_GET['foodid'];
	//echo $strSQL;
	$row = getSingleRow($strSQL);
	if ($row){
		$qstrSQL = "UPDATE IFOODS SET VIEWS = ".($row['VIEWS']+1)." WHERE FID = ".$row['FID'];
		//echo $qstrSQL;
		$qobjParse = oci_parse($objConnect, $qstrSQL);
		$qobjExecute = oci_execute($qobjParse);
	}
	$strSQLlike = "SELECT COUNT(FID) as \"LIKE\" FROM IFAVORITE WHERE FID = ".$_GET['foodid'];
	//echo $strSQLlike;
	$rowlike = getSingleRow($strSQLlike);
}

	if ( ( isset($_SESSION['UIDS']) && isset($_SESSION['USERNAME']) )
		&& (
			( authenIdUser() && ($_SESSION['UIDS']==$row['UIDS']))
			|| authenAdmin() )
		) {
		$editable = true;
		}
?>
<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!-->
<html lang="en">
<!--<![endif]-->
<head>
<!-- Basic Page Needs -->
<meta charset="utf-8">
<title>Food Cooking <? if($row) { echo $row['FOODNAME']; } ?></title>
<meta name="description" content>
<meta name="author" content>
<!-- CSS Style -->
<link rel="stylesheet" href="css/style.css" type="text/css" media="all">
<!-- Short Codes Style -->
<link rel="stylesheet" href="css/shortcode.css" type="text/css" media="all">
<!-- Start Java CSS -->
<link rel="stylesheet" href="css/javascri.css" type="text/css" media="all">
<!-- Color Schemes CSS -->
<link rel="stylesheet" href="css/colors-scheme.css" type="text/css" media="all">
<!--[if lt IE 9]>
      <script src="js/html5.js"></script>
<![endif]-->
<link rel="stylesheet" type="text/css" href="core/css/mystyle.css">
<script src="core/js/jquery-1.9.1.js"></script>
<script src="core/js/jquery-2.0.0.min.js"></script>
<? if ($editable) { ?>
<script type="text/javascript">
	function editFood() {
		$.fancybox.open({
					href : 'admin/food/edit.php?confirm=1&ids=<? if($row) { echo $row['FID']; } ?>',
					type : 'iframe',
					width  : 550,
					height : 600,
					fitToView   : false,
					autoSize    : false,
					padding: 5,
					openEffect : 'elastic',
					openSpeed  : 150,
					closeEffect : 'elastic',
					closeSpeed  : 150,
					afterClose : function() {
						window.location.reload();
					}
		});
	}
	
		function delFood() {
			if (confirm('Do you want to delete <?=$row['FOODNAME']; ?> ? ')){
				$.fancybox.open({
							href : 'admin/food/delete.php?confirm=1&ids=<? if($row) { echo $row['FID']; } ?>',
							type : 'iframe',
							width  : 550,
							height : 600,
							fitToView   : false,
							autoSize    : true,
							padding: 5,
							openEffect : 'elastic',
							openSpeed  : 150,
							closeEffect : 'elastic',
							closeSpeed  : 150,
							afterClose : function() {
								 window.location="menu.php";
		//						window.location.reload();
							}
				});
			}
	}
	</script>
<? } ?>
</head>
<body id="def">
<div class="wrapper"> 
  <!-- header -->
  <header id="header">
    <div class="main-holder">
      <h1 id="logo"><a href="index.php"></a></h1>
      <nav class="nav">
        <? include('_navbar.php'); ?>
      </nav>
    </div>
  </header>
  <div class="sloganwrapper">
    <div class="main-holder ">
      <ul class="breadcrumb">
        <li><a href="index.php">HOME</a></li>
        <li><a href="menu.php">ALL FOOD </a></li>
        <li>
          <? if($row) { echo $row['FOODNAME']; } ?>
        </li>
      </ul>
    </div>
  </div>
  <!-- Content -->
  <section class="main-content"> <span class="top-bg"></span>
    <div class="holder-container">
      <section class="grid-holder">
        <section class="grid w-padd">
          <figure class="column forth-col">
            <? include('_side.php'); ?>
          </figure>
          <figure class="column c-one-half">
          	<?
				if($row) {
			?>
          
            <h2><? echo $row['FOODNAME']; 
			?><? if ($editable) { ?> 
            <a href="javascript:editFood();"><img src="core/images/_myedit.png" alt="Edit Food" name="im_edit" width="31" height="31" id="im_edit">edit</a>
			<a href="javascript:delFood();"><img src="core/images/_mydelete.png" alt="Delete Food" name="im_del" width="31" height="31" id="im_del">delete</a>
			<? } ?>
            </h2>
              <ul class="b-top-links">
              <li class="author-name">by
                <?=$row['NAME']?>
              </li>
              <li class="pic-icon">
                <?=$row['TYPENAME']?>
              </li>
              <li class="catagory">
                <?=$row['VIEWS']?>
                views</li>
            </ul>
            <div id="likeBox">
<?
$likesrc = "core/images/like.png";
if (hasLiked($row['FID'])){
	$likesrc = "core/images/like2.png";
}
?>
<form action="module/like_submit.php" method="post">
<input name="foodid" type="hidden" value="<? echo $row['FID'];?>" />
<input name="ref" type="hidden" value="<?=$_SERVER['REQUEST_URI']?>" />
<table>
  <tr>
    <td><input type="image" src="<?=$likesrc?>" name="im_edit" width="32" height="32"/></td>
    <td id="theLike"><?=numberOfLike($row['FID'])?>
      </td>
     <td>
      likes</td>
  </tr>
</table>
</form>
<script>
  var source2=new EventSource("module/like_flush.php?foodid=<? echo $_GET['foodid'];?>");
  source2.onmessage=function(event)
    {
	  document.getElementById("theLike").innerHTML=event.data;
//		alert(event.data);
    };
</script>

            
                  
            </div>
          <div style="background-image:url('<? echo picture_url($row['PICTURE']); ?>');height:400px;width:650px;" class="myfoodpic"></div>           
            <section class="grid-holder">
              <section class="grid">
                <figure class="column three-col">
                  <h2>Ingredients</h2>
                  <ul class="normal-list">
                  <? 
				  	$strSQL = "Select * from ICONTAIN NATURAL JOIN IINGREDIENT WHERE FID = ".$row['FID'];
						$objParse = oci_parse($objConnect, $strSQL);
						$objExecute = oci_execute($objParse, OCI_DEFAULT);
					while ($rowIngre = oci_fetch_array($objParse, OCI_BOTH)){
				  ?>
                    <li><? echo $rowIngre['INNAME']; ?> <? echo $rowIngre['QUANTITY']; ?> <? echo $rowIngre['UNIT']; ?></li>
                   <? } ?> 
                   
                  </ul>
                </figure>
                
                <? if (isset($_SESSION["RESULT"][$row['FID']]['LACK'])){ ?>
                <figure class="column three-col">
                  <h2>Lack Ingredients</h2>
                  <ul class="normal-list">
				<? foreach ($_SESSION["RESULT"][$row['FID']]['LACK'] as $result) { ?>
                    <li><? echo $result['INNAME']; ?> <? echo $result['QUANTITY']; ?> <? echo $result['UNIT']; ?></li>
                 <? } ?>
                  </ul>
                </figure>
                <? } ?>
                <figure class="column three-col">
                  <h2>Tools</h2>
                  <ul class="normal-list">
                  <? 
				  	$strSQL = "Select * from IUSE NATURAL JOIN ITOOLS WHERE FID = ".$row['FID'];
						$objParse = oci_parse($objConnect, $strSQL);
						$objExecute = oci_execute($objParse, OCI_DEFAULT);
					while ($rowIngre = oci_fetch_array($objParse, OCI_BOTH)){
				  ?>
                    <li><? echo $rowIngre['TOOLNAME']; ?> </li>
                   <? } ?> 
                   
                  </ul>
                </figure>
              </section>
            </section>
            <h2>Method</h2>
           		<p> <?
                // Provides: <body text='black'>
				echo $bodytag = str_replace('\"', '"', $row['METHOD']);
				
				?>
           		</p>
            <br>
            <h2><? $numComment = numberOfComment($row['FID']);
			if ($numComment) { echo '<span id="numCom">'.$numComment.'</span> COMMENTS'; }
			else {
				echo 'Not has Comments, Let\'s the 1st Comment.';
			}
			
			?> </h2>
            <article class="blog-post"><br>
                  <? 
				  	$strSQL = "Select * FROM ICOMMENTS NATURAL JOIN IUSERS WHERE FID = ".$row['FID']."ORDER BY STIME";
					$objParse = oci_parse($objConnect, $strSQL);
					$objExecute = oci_execute($objParse, OCI_DEFAULT);
					while ($rowCom = oci_fetch_array($objParse, OCI_BOTH)){
				  ?><a name="<?=$rowCom['UIDS']?>"></a>
              <div class="post-holder">

				<aside class="post-det" style="margin-left:30px;">
                
                  <h4 style="margin-bottom:10px;margin-top:0;"><? if ($rowCom['UIDS']!=NULL){ echo $rowCom['NAME'];} else { echo 'Guest';}?> says:</h4>
                  <?=$rowCom['MESSAGE']?><br><br>
                  <div class="row">
    	           <em class="post-date"> <? echo str_replace('.000000', '',$rowCom['STIME'])?></em>
                   <? if ($_SESSION["UIDS"]==$rowCom['UIDS']){ ?>
                   <em class="price"><img  class="remove" onClick="removeOb(this,'<?=$rowCom['FID']?>','<?=$rowCom['STIME']?>')" src="core/css/images/close.png" alt="Remove this row" width="16" height="16"></em><? }?>
              </div>
                </aside>
              </div>
              <? } ?>
              <? if (authenIdUser()) { ?>
              <form action="module/addComment.php" method="post" class="r-contact-box">
                <ul class="comm-list contact">
                  <li>
                    <label>Comment</label>
                    <textarea name="comments" cols="5" rows="10" class="comm-area" required></textarea>
                  </li>
                  <li>
                    <input class="bannerbtn sumitbtn" type="submit" value="Submit">
                    <input type="hidden" name="foodid" id="foodid" value="<?=$row['FID']?>">
                    <input type="hidden" name="ref" id="ref" value="<?=$_SERVER['REQUEST_URI']?>">
                  </li>
                </ul>
              </form>
              <? } else {?>
           	  <h4>Login for comment.</h4>
              <? } ?>
            </article>
            <? } else { ?>
            	<p>
                <div class="alert error hideit" >
                  <p>Error. Not found the food.</p>
                  <span class="close"></span>
              </div>
            <? } ?>
          </figure>
        </section>
      </section>
    </div>
    <? include '_footer.php' ?>
</div>
<!-- Start JavaScript --> 
<script src="core/js/jquery-1.9.1.js"></script>
<script src="core/js/jquery-2.0.0.min.js"></script>

<script type="text/javascript" src="js/jquery-u.js"></script><!-- jQuery Ui -->
<script type="text/javascript" src="js/ddsmooth.js"></script><!-- Nav Menu ddsmoothmenu -->
<script type="text/javascript" src="js/jquery03.js"></script><!-- Sliding Text and Icon Menu Style  -->
<script type="text/javascript" src="js/jquery04.js"></script><!-- jQuery Prettyphoto  -->
<script type="text/javascript" src="js/focus.js"></script><!-- text field clear & celander Seting-->
    
<script type="text/javascript" src="core/fancyapps/lib/jquery.mousewheel-3.0.6.pack.js"></script>
<script type="text/javascript" src="core/fancyapps/source/jquery.fancybox.pack.js"></script>
<script type="text/javascript">
var removeOb = function(e,fid,time) {
	$.post( "module/delComment.php", { foodid: fid, stime: time })
	.done(function( data ) {
		if(data='Complete'){
			var ob = $(e).parent().parent().parent();
				ob.hide('slow', function(){ ob.remove();
			});
			$('#numCom').html($('#numCom').html()-1);
		} else {
			alert('Deleted unsuccessful.');
		}
	});


	//$(e).parent().parent().remove();
};


</script>
</body>
</html>
