<?
if (!isset($_SESSION)) {
  session_start();
}
include 'FoodFunction.php';
if ( !authenIdUser() ) {
	header ("Location: login.php?ref=".$_SERVER['PHP_SELF']);
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
<title>Favorite Fods</title>
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
        <li><a href="member.php">MEMBER</a></li>
        <li>USER COMMENTS</li>
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
            <h2>User Comments</h2>
            
            <article class="blog-post"><br>
                  <? 
				  	$strSQL = "Select * FROM ICOMMENTS C JOIN IFOODS F ON (C.FID=F.FID) WHERE C.UIDS = ".$_SESSION['UIDS'];
					$objParse = oci_parse($objConnect, $strSQL);
					$objExecute = oci_execute($objParse, OCI_DEFAULT);
					while ($rowCom = oci_fetch_array($objParse, OCI_BOTH)){
				  ?><a name="<?=$rowCom['UIDS']?>"></a>
              <div class="post-holder">
                <div class="post-img"> <a href="foodDetail.php?foodid=<?=$rowCom['FID']?>#<?=$_SESSION['UIDS']?>" ><img src="<? echo picture_url("_".$rowCom['PICTURE']); ?>" alt=""> </a></div>
                <aside class="post-det" style="">
                  <h4 style="margin-bottom:10px;margin-top:0;">
                    <a href="foodDetail.php?foodid=<?=$rowCom['FID']?>#<?=$_SESSION['UIDS']?>" ><?=$rowCom['FOODNAME']?></a>
                    :</h4>
                  <p>
                    <?=$rowCom['MESSAGE']?>
                  </p><br>
                  <div class="row">
    	           <em class="post-date"> <? echo str_replace('.000000', '',$rowCom['STIME'])?></em>
              </div>
                <span class="post-arrow"></span>
                <em class="price"><img  class="remove" onClick="removeOb(this,'<?=$rowCom['FID']?>','<?=$rowCom['STIME']?>')" src="core/css/images/close.png" alt="Remove this row" width="16" height="16"></em></aside>
              </div>
<? } ?>
             
            </article>
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
<script type="text/javascript" src="js/jquery06.js"></script><!-- UItoTop plugin  --> 
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
		} else {
			alert('Deleted unsuccessful.');
		}
	});


	//$(e).parent().parent().remove();
};


</script>
</script>
</body>
</html>
