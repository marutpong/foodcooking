<?
if (!isset($_SESSION)) {
  session_start();
}
include 'FoodFunction.php';
?>
<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!-->
<html lang="en">
<!--<![endif]-->
<head>
<link rel="stylesheet" href="css/calendar.css" media="all">
<!-- Basic Page Needs -->
<meta charset="utf-8">
<title>Register</title>
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
<script src="../../foodcooking/core/js/jquery-1.9.1.js"></script>
<script src="../../foodcooking/core/js/jquery-2.0.0.min.js"></script>
  <link href="core/css/mystyle.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="core/css/tooltipster/reset.css">
    <link rel="stylesheet" type="text/css" href="core/css/tooltipster/style.css">
    <link rel="stylesheet" type="text/css" href="core/css/tooltipster/tooltipster.css">
    
<script type="text/javascript" charset="UTF-8">
var checkUser = 1;
$(document).ready(function() {
		$("#birthdate").datepicker({
			changeMonth: true,
			changeYear: true,
			maxDate: "+0D",
			dateFormat: 'dd/mm/yy'
		});
$('input').tooltipster({ 
        trigger: 'custom', // default is 'hover' which is no good here
        onlyOne: true,    // allow multiple tips to be open at a time
        position: 'right'  // display the tips to the right of the element
    });
$( "#addUser" ).validate({
	rules: {
		username: {
			required: true,
			remote: {
				url: "admin/users/chkuser.php",
				type: "get",
				data: {
					username: function() {
						return $( "#username" ).val();
					}
				}
			}
		},
		email: {
			required: true,
			remote: {
				url: "admin/users/chkemail.php",
				type: "get",
				data: {
					email: function() {
						return $( "#email" ).val();
					}
				}
			}
		}
	},
	messages: {
	//name: "Please specify your name",
		username: {
		//required: "We need your email address to contact you",
		remote: "This Username already used."
		},
		email: {
		//required: "We need your email address to contact you",
		remote: "This E-mail already used."
		}
	},
		 errorPlacement: function (error, element) {
            $(element).tooltipster('update', $(error).text());
            $(element).tooltipster('show');
        },
        success: function (label, element) {
            // $(element).tooltipster('hide'); // normal validate behavior
            $(element).tooltipster('update', 'accepted'); // as per OP
        }
});
	});
</script>
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
          <li><a href="about.php">About Us</a>
            <ul>
              <li><a href="our-team.html">Our Team</a></li>
              <li><a href="author.html">author</a></li>
              <li><a href="services.html">Services</a></li>
              <li><a href="contact.html">contact us</a></li>
            </ul>
          </li>
          <li><a href="menu.php">our menu</a>
          	<ul>
            	<li><a href="recepie-detail-page.html">Recepie Detail Page</a></li>
            </ul>
          </li>
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
        <li>Register</li>
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
            <h2>Register</h2>
            <div style="width:400" align="center" >
            
            <?
if (isset($_POST['name']) && isset($_POST['username']) && isset($_POST['password']) && isset($_POST['gender']) && isset($_POST['birthdate']) && isset($_POST['email']) && $_POST['confirm']==1){
	include 'connectDB.php';
	$name = $_POST['name'];
	$username = $_POST['username'];
	$password = sha1($_POST['password']);
	$gender = $_POST['gender'];
	$birthdate = $_POST['birthdate'];
	$email = $_POST['email'];
	$count = 0;
	$num = count($_POST['name']);
	$total = 0;
		$sql = "select * from iusers where name = '$username'";
		$strSQL = $sql;
		$objParse = oci_parse($objConnect, $strSQL);
        $objExecute = oci_execute($objParse, OCI_DEFAULT);
		$total = oci_fetch_all($objParse, $Result);
	//echo $total;
	//for ($i=0;$i<$num;$i++){
		if ($total == 0){	
			$sql = "INSERT INTO IUSERS (NAME, username, password, gender, birthdate, email, USER_LEVEL) VALUES ('$name','$username','$password','$gender',to_date('" .$birthdate. "','dd/mm/yyyy'),'$email',2)";
			$strSQL = $sql;
			//echo $sql;
			$objParse = oci_parse($objConnect , $strSQL);
			$objExecute = oci_execute($objParse, OCI_DEFAULT);
			if($objExecute){
				oci_commit($objConnect);
				$count++;
			}
		}
	//}
	echo '<br><br><br><center><div class="textC1">';
	if($objExecute && $total==0){
		sendmail($email,"Register www.foodcooking.com","Register is complete");
?>

            <div class="alert success hideit">
              <p>Register Succesful.</p>
              <span class="close"></span></div>
<?		
	} else {
		$msgError = "Unsuccessful, some input are incorect.";
?>
<?
	}

	echo '</div></center>';
} else {
	if (isset($msgError)){
?>
            <div class="alert error hideit" >
              <p><?=$msgError?></p>
              <span class="close"></span></div>
              <? }?>
<form action="" method="post" id="addUser">
                  <table width="400" align="center" id="dynamic_tb">
                    <tr class="labelF">
                      <td width="150" height="36" align="right" valign="middle" class="labelF">ชื่อ :</td>
                      <td width="250" height="36" valign="middle" class="labelF"><input name="name" type="text"  required class="input" id="name" tabindex="1" placeholder="Name" <? $mystyle = 'style="width: 200px"'; ?>></td>
                    </tr>
                    <tr>
                      <td width="150" height="36" align="right" valign="middle" class="labelF">Username :</td>
                      <td width="250" height="36" valign="middle" class="labelF"><input name="username" type="text"  required class="input" id="username" tabindex="2"></td>
                    </tr>
                    <tr>
                      <td width="150" height="36" align="right" valign="middle" class="labelF">Password :</td>
                      <td width="250" height="36" valign="middle" class="labelF"><input name="password" type="password" required class="input" id="password" tabindex="2"></td>
                    </tr>
                    <tr>
                      <td width="150" height="36" align="right" valign="middle" class="labelF">เพศ :</td>
                      <td width="250" height="36" valign="middle" class="labelF">
                        <div class="switch switch-blue">
                          <input type="radio" class="switch-input" name="gender" value="MALE" id="week4" checked>
                          <label for="week4" class="switch-label switch-label-off">Male</label>
                          <input type="radio" class="switch-input" name="gender" value="FEMALE" id="month4">
                          <label for="month4" class="switch-label switch-label-on">Female</label>
                      <span class="switch-selection"></span> </div></td>
                    </tr>
                    <tr>
                      <td width="150" height="36" align="right" valign="middle" class="labelF">วันเกิด :</td>
                      <td width="250" height="36" valign="middle" class="labelF"><input name="birthdate" type="text" required class="input" id="birthdate" tabindex="2"></td>
                    </tr>
                    <tr>
                      <td width="150" height="36" align="right" valign="middle" class="labelF">E-mail :</td>
                      <td width="250" height="36" valign="middle" class="labelF"><input name="email" type="email"  required class="input" id="email" tabindex="2"></td>
                    </tr>
                  </table>
                  <p>
                    <input name="confirm" type="hidden" value="1">
                    <br>
                    <center>
                      <input type="submit" class="button_sub" value="สมัครสมาชิก" tabindex="4">
                    </center>
                  </p>
              </form>
              <? } ?>
            </div>
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
<script type="text/javascript" src="js/focus.js"></script><!-- text field clear & celander Seting-->

<script type="text/javascript" src="core/fancyapps/lib/jquery.mousewheel-3.0.6.pack.js"></script>
<script type="text/javascript" src="core/fancyapps/source/jquery.fancybox.pack.js"></script>
</body>
</html>
