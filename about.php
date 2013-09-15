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
<!-- Basic Page Needs -->
<meta charset="utf-8">
<title>About Us</title>
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
        <ul>
          <li><a href="index.php">Home</a></li>
          <li class="active"><a href="about.php">About Us</a>
          	<ul>
            	<li><a href="our-team.html">Our Team</a></li>
                <li><a href="author.html">author</a></li>
            	<li><a href="services.html">Services</a></li>
                <li><a href="contact.html">contact us</a></li>
            </ul>
          </li>
          <li><a href="menu.html">our menu</a>
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
        <li>ABOUT US</li>
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
            <h2>Our Staff</h2>
            <article class="staff-list">
              <div class="img-box"><img src="images/image20.jpg" alt=""></div>
              <aside class="det-bar">
                <h3>Chalermpong Somdulyawat</h3>
                <em class="title4">Owner</em>
                <p>Pellentesque fermentum lorem at odio gravida consectetur. Fusce id nulla quam, vitae vehicula tellus. Sed et lectus eget ipsum vulputate mollis eu et dolor. Nunc hendrerit sapien eu ante fringilla consectetur. Sed ut diam neque, vel pharetra dui.</p>
                <p>Aenean tempor nunc sit amet dolor porta cursus. Morbi sit amet dolor orci. Donec consequat egestas condimentum. Sed eu libero non velit elementum dapibus vel at urna. Etiam in quam congue lorem varius interdum.</p>
              </aside>
            </article>
            <article class="staff-list">
              <div class="img-box"><img src="images/image16.jpg" alt=""></div>
              <aside class="det-bar">
                <h3>tanaphon</h3>
                <em class="title4">Owner</em>
                <p>Pellentesque fermentum lorem at odio gravida consectetur. Fusce id nulla quam, vitae vehicula tellus. Sed et lectus eget ipsum vulputate mollis eu et dolor. Nunc hendrerit sapien eu ante fringilla consectetur. Sed ut diam neque, vel pharetra dui.</p>
                <p>Aenean tempor nunc sit amet dolor porta cursus. Morbi sit amet dolor orci. Donec consequat egestas condimentum. Sed eu libero non velit elementum dapibus vel at urna. Etiam in quam congue lorem varius interdum.</p>
              </aside>
            </article>
            <article class="staff-list">
              <div class="img-box"><img src="images/image19.jpg" alt=""></div>
              <aside class="det-bar">
                <h3>Panupong Jantapoon</h3>
                <em class="title4">Owner</em>
                <p>Pellentesque fermentum lorem at odio gravida consectetur. Fusce id nulla quam, vitae vehicula tellus. Sed et lectus eget ipsum vulputate mollis eu et dolor. Nunc hendrerit sapien eu ante fringilla consectetur. Sed ut diam neque, vel pharetra dui.</p>
                <p>Aenean tempor nunc sit amet dolor porta cursus. Morbi sit amet dolor orci. Donec consequat egestas condimentum. Sed eu libero non velit elementum dapibus vel at urna. Etiam in quam congue lorem varius interdum.</p>
              </aside>
            </article>
            <article class="staff-list">
              <div class="img-box"><img src="images/image19.jpg" alt=""></div>
              <aside class="det-bar">
                <h3>Phasit Panyaphruek</h3>
                <em class="title4">Owner</em>
                <p>Pellentesque fermentum lorem at odio gravida consectetur. Fusce id nulla quam, vitae vehicula tellus. Sed et lectus eget ipsum vulputate mollis eu et dolor. Nunc hendrerit sapien eu ante fringilla consectetur. Sed ut diam neque, vel pharetra dui.</p>
                <p>Aenean tempor nunc sit amet dolor porta cursus. Morbi sit amet dolor orci. Donec consequat egestas condimentum. Sed eu libero non velit elementum dapibus vel at urna. Etiam in quam congue lorem varius interdum.</p>
              </aside>
            </article>
            <article class="staff-list">
              <div class="img-box"><img src="images/image19.jpg" alt=""></div>
              <aside class="det-bar">
                <h3>Marutpong Chailangka</h3>
                <em class="title4">Owner</em>
                <p>Pellentesque fermentum lorem at odio gravida consectetur. Fusce id nulla quam, vitae vehicula tellus. Sed et lectus eget ipsum vulputate mollis eu et dolor. Nunc hendrerit sapien eu ante fringilla consectetur. Sed ut diam neque, vel pharetra dui.</p>
                <p>Aenean tempor nunc sit amet dolor porta cursus. Morbi sit amet dolor orci. Donec consequat egestas condimentum. Sed eu libero non velit elementum dapibus vel at urna. Etiam in quam congue lorem varius interdum.</p>
              </aside>
            </article>
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
