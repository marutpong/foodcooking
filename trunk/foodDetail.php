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
}

	if ( ( isset($_SESSION['UIDS']) && isset($_SESSION['USERNAME']) )
		&& (
			( authenIdUser() && isFoodOwner($_SESSION['UIDS'],$row['FID']))
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
        <ul>
          <li><a href="index.php">Home</a></li>
          <li><a href="about.php">About Us</a></li>
          <li><a href="menu.php">All food</a></li>
          <li><a href="blog_list.html">Blog</a>
            <ul>
              <li><a href="blog_double_sidebar_left.html">Blog Double Sidebar Left</a></li>
              <li><a href="blog.html">Blog List</a></li>
            </ul>
          </li>
          <li><a href="gallery.html">Gallery</a>
            <ul>
              <li><a href="gallery2col.html">Gallery 2 column</a></li>
              <li><a href="gallery3col.html">Gallery 3 column</a></li>
              <li><a href="gallery4col.html">Gallery 4 column</a></li>
              <li><a href="right_content_gallery.html">Right Content Gallery</a></li>
              <li><a href="video_gallery_single.html">Video Gallery</a></li>
            </ul>
          </li>
          <li><a href="#">Features</a>
            <ul>
              <li> <a href="seat-reserve.html">Seat Reserve</a></li>
              <li><a href="short-code.html">Short Codes</a></li>
              <li><a href="404-ErrorPage.html">404 Error Page</a></li>
              <li><a href="careers.html">Careers</a></li>
              <li><a href="faq.html">FAQ</a></li>
              <li><a href="left_nav.html">Left Nav</a></li>
              <li><a href="password_protected.html">Password Protected</a></li>
              <li><a href="password_protected2.html">Password Protected 2</a></li>
              <li><a href="search_result.html">Search Result</a></li>
              <li><a href="testimonials.html">Testimonials</a></li>
            </ul>
          </li>
          <li><a href="slideshow-gallery.html">Slideshow Gallery</a></li>
        </ul>
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
          
            <h2><? echo $row['FOODNAME']; if ($editable) { ?> <a href="javascript:editFood();"><img src="core/images/_myedit.png" alt="Edit Food" name="im_edit" width="31" height="31" id="im_edit">edit</a><? } ?></h2>
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
            <p>
              <? if (file_exists('files/'.$row['PICTURE'])) { ?>
              <img src="files/<? echo $row['PICTURE']; ?>"><?
              } else {?>
              <img src="http://10.10.188.254/group10/files/<? echo $row['PICTURE']; ?>">
             <? } ?></p>
            
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
              </section>
            </section>
            <h2>Mothod</h2>
           		<p> <?
                // Provides: <body text='black'>
				echo $bodytag = str_replace('\"', '"', $row['METHOD']);
				
				?>
           		</p>
            <br>
            <h2><? $numComment = numberOfComment($row['FID']);
			if ($numComment) { echo $numComment.' COMMENTS'; }
			else {
				echo 'Not has Comments, Let\'s the 1st Comment.';
			}
			
			?> </h2>
            <article class="blog-post"><br>
                  <? 
				  	$strSQL = "Select UIDS,FID,MESSAGE,STIME,NAME FROM ICOMMENTS NATURAL JOIN IUSERS WHERE FID = ".$row['FID'];
					$objParse = oci_parse($objConnect, $strSQL);
					$objExecute = oci_execute($objParse, OCI_DEFAULT);
					while ($rowCom = oci_fetch_array($objParse, OCI_BOTH)){
				  ?>
              <div class="post-holder">

				<aside class="post-det">
                  <h4><? if ($rowCom['UIDS']!=NULL){ echo $rowCom['NAME'];} else { echo 'Guest';}?> says:</h4>
                  <?=$rowCom['MESSAGE']?>
                </aside>
              </div>
              <? } ?>
              <? if (authenIdUser()) { ?>
              <form action="addComment.php" method="post" class="r-contact-box">
                <ul class="comm-list contact">
                  <li>
                    <label>Comment<span>(required)</span></label>
                    <textarea name="comments" cols="5" rows="10" class="comm-area" required></textarea>
                  </li>
                  <li>
                    <input class="bannerbtn sumitbtn" type="submit" value="Submit">
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
</body>
</html>
