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
        <li>MEMBER</li>
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
            <h2>Member</h2>
            <form action="" method="post">
              <div>
                <p>&nbsp;</p>
                <table align="center">
                  <?	$row = getSingleRow("SELECT * FROM IUSERS Where UIDS=".$_SESSION['UIDS']); ?>
                  <tr class="labelF">
                    <td align="right" class="labelF">ชื่อ :</td>
                    <td class="labelF"><input name="id" type="hidden" id="id" value="<?=$id?>">
                      <?
            echo $row['NAME'];
			?></td>
                  </tr>
                  <tr>
                    <td align="right" class="labelF">Username :</td>
                    <td class="labelF"><?
            echo $row['USERNAME'];
			?></td>
                  </tr>
                  <tr>
                    <td align="right" class="labelF">เพศ :</td>
                    <td class="labelF"><?
            echo $row['GENDER'];
			?></td>
                  </tr>
                  <tr>
                    <td align="right" class="labelF">วันเกิด :</td>
                    <td class="labelF"><?
            echo $row['BIRTHDATE'];
			?></td>
                  </tr>
                  <tr>
                    <td height="36" align="right" valign="middle" class="labelF">E-mail :</td>
                    <td height="36" valign="middle" class="labelF"><?
            echo $row['EMAIL'];
			?></td>
                  </tr>
                </table>
              </div>
              <footer>
                <center>
                  <input type="button" class="button_addmore" onclick="showProfile('member/edit_profile.php')" value="Edit Profile">
                  <input type="button" class="button_addmore" onclick="showProfile('member/change_pass.php')" value="Change Password">
                </center>
              </footer>
            </form>
            <p>&nbsp;</p>
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
	function showProfile(url) {
		$.fancybox.open({
					href : url,
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
						window.location.reload();
					}
		});
	}

</script>
</body>
</html>
