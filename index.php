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
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
<link rel="stylesheet" href="css/calendar.css" media="all">
<!-- Basic Page Needs -->
<meta charset="utf-8">
<title>Home</title>
<meta name="description" content>
<meta name="author" content>
<!-- CSS Style -->
<link rel="stylesheet" href="css/style.css" type="text/css" media="all">
<!-- Slider Style -->
<link rel="stylesheet" href="css/slider.css" type="text/css" media="all">
<!-- Short Codes Style -->
<link rel="stylesheet" href="css/shortcode.css" type="text/css" media="all">
<!-- Start Java CSS -->
<link rel="stylesheet" href="css/javascri.css" type="text/css" media="all">
<!-- Video Gallery CSS -->
<link rel="stylesheet" href="css/galleria.classic.css" type="text/css" media="all">
<!-- Color Schemes CSS -->
<link rel="stylesheet" href="css/colors-scheme.css" type="text/css" media="all">
<!--[if lt IE 9]>
      <script src="js/html5.js"></script>
<![endif]-->
<script src="../../foodcooking/core/js/jquery-1.9.1.js"></script>
<script src="../../foodcooking/core/js/jquery-2.0.0.min.js"></script>
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
  <div id="homeContent">
    <div id="featured">
      <div class="gallery" >
        <div class="site"> <img src="images/banner01.jpg" alt=""> </div>
        <div class="site"> <img src="images/banner02.jpg" alt=""> </div>
        <div class="site"> <img src="images/banner03.jpg" alt=""> </div>
      </div>
      <div class="pagination stopClickPropagation"> <a href="#" class="left"><img src="images/arrow_le.png" alt=""></a>
        <div class="pages" ></div>
        <a href="#" class="right"><img src="images/arrow_ri.png" alt=""></a> </div>
    </div>
  </div>
  <div class="main-holder">
    <div class="bannercon">
      <h2>คุณเคยเจอปัญหามั้ย?<br>
        เวลามีวัตถุดิบอยู่<br>
        แล้วไม่รู้จะปรุงเมนูไหนดี</h2>
      <p>เรามีวิธีช่วยคุณในการหารายการอาหารที่ใกล้เคียงกับวัตถุดิบที่คุณมี</p>
      <a href="search.php" class="bannerbtn">ค้นหาแบบพิเศษ</a> </div>
  </div>
  <div class="sloganwrapper">
    <div class="main-holder banner-bottom">
      <blockquote>"Your awesome company slogan goes right over here, we have the best food around"<br>
        <span>unc elementum lacus in gravida pellentesque urna dolor eleifend felis eleifend</span> </blockquote>
    </div>
  </div>
  <!-- Content -->
  <section class="main-content">
  <span class="top-bg"></span>
  <div class="holder-container">
    <section class="grid-holder">
      <section class="grid w-padd">
        <figure class="column forth-col">
        <? include('_side.php'); ?>
        </figure>
        <figure class="column c-one-half">
          <article class="blog-main"> <strong class="title">Duis sed tortor a leo ullamcorper fringilla!</strong>
            <ul class="b-top-links">
              <li class="author-name">by Jason</li>
              <li class="pic-icon">Section</li>
              <li class="c-icon">12</li>
            </ul>
            <img src="images/image08.jpg" class="blog-img2" alt="">
            <p>Rhoncus quis, varius sed velit. Mauris quis nunc eu nunc molestie egestas et sit amet odio. Morbi lacinia velit in nibh sodales sed pharetra sem feugiat. Vivamus ut cursus augue. Integer sit amet arcu lorem, at egestas tellus. Phasellus tellus orci, congue at tristique at, mattis ut arcu. Donec dictum eros eu felis laoreet egestas. Nullam adipiscing nibh id felis lacinia a iaculis nisi vestibulum. Ut sit amet urna enim, at accumsan quam. Nunc dui elit, hendrerit quis convallis sit amet, dapibus in metus. Ut dolor est, blandit a auctor vitae, accumsan id eros.</p>
          </article>
          <article class="blog-main"> <strong class="title">Duis sed tortor a leo ullamcorper fringilla!</strong>
            <ul class="b-top-links">
              <li class="author-name">by Jason</li>
              <li class="pic-icon">Section</li>
              <li class="c-icon">12</li>
            </ul>
            <img src="images/image08.jpg" class="blog-img2" alt="">
            <p>Rhoncus quis, varius sed velit. Mauris quis nunc eu nunc molestie egestas et sit amet odio. Morbi lacinia velit in nibh sodales sed pharetra sem feugiat. Vivamus ut cursus augue. Integer sit amet arcu lorem, at egestas tellus. Phasellus tellus orci, congue at tristique at, mattis ut arcu. Donec dictum eros eu felis laoreet egestas. Nullam adipiscing nibh id felis lacinia a iaculis nisi vestibulum. Ut sit amet urna enim, at accumsan quam. Nunc dui elit, hendrerit quis convallis sit amet, dapibus in metus. Ut dolor est, blandit a auctor vitae, accumsan id eros.</p>
          </article>
          <ul class="pager">
            <li class="p-title">Page 1 of 3</li>
            <li><a href="#">1</a></li>
            <li><a href="#">2</a></li>
            <li><a href="#">3</a></li>
            <li><a href="#"> > </a></li>
          </ul>
        </figure>
      </section>
    </section>
  </div>
  <div class="holder-container">
    <section class="grid-holder">
      <section class="grid">
        <figure class="column three-col">
          <h2>Reservations</h2>
          <div id="calendar"></div>
          <em class="event-det">Wednesday, May 16th at 21:00 for party of 2</em> <a href="seat-reserve.html" class="bannerbtn">Reserve Table</a> </figure>
        <figure class="column three-col">
          <h2>Special</h2>
          <ul class="special-list">
            <li> <img src="images/image01.jpg" width="60" height="60" alt="">
              <div class="img-det"> <strong class="title">Item Name</strong>
                <p>A little description <br>
                  will go here.</p>
                <em class="price">17,95</em> </div>
            </li>
            <li class="even"> <img src="images/image02.jpg" width="60" height="60" alt="">
              <div class="img-det"> <strong class="title">Item Name</strong>
                <p>A little description <br>
                  will go here.</p>
                <em class="price">13,95</em> </div>
            </li>
            <li> <img src="images/image03.jpg" width="60" height="60" alt="">
              <div class="img-det"> <strong class="title">Item Name</strong>
                <p>A little description <br>
                  will go here.</p>
                <em class="price">21,95</em> </div>
            </li>
            <li class="even"> <img src="images/image04.jpg" width="60" height="60" alt="">
              <div class="img-det"> <strong class="title">Item Name</strong>
                <p>A little description <br>
                  will go here.</p>
                <em class="price">19,95</em> </div>
            </li>
          </ul>
          <a href="menu.php" class="c-link">View our complete menu</a> </figure>
        <figure class="column three-col">
          <h2>Location</h2>
          <div class="location"> 21 M.M Alam Road, Gluberg.</div>
          <div class="map"><img src="images/map.jpg" alt=""></div>
          <div class="bisnesshour">
            <div class="bisnessleft">Business
              Hours</div>
            <div class="bisnessright"><strong>MON - FRI:</strong> &nbsp; <span class="time"> 9AM to 10PM</span><br>
              <strong>SAT & SUN:</strong> &nbsp; <span class="time">9AM to 10PM</span></div>
          </div>
        </figure>
      </section>
    </section>
  </div>
  <div class="holder-container last">
    <section class="grid-holder">
      <section class="grid">
        <figure class="column three-col">
          <article>
            <h2>Special of the Month</h2>
            <img src="images/image05.jpg" class="offer-img" alt="">
            <div class="img-det offer"> <strong class="title">Item Name</strong>
              <p>Nullam mi turpis, ultricies eu mattis vel, tincidunt vitae velit. Nullam quis ante sapien. Praesent sollicitudin volutpat fringilla.</p>
              <em class="price">17,95</em> </div>
          </article>
        </figure>
        <figure class="column three-col">
          <h2>Our Staff</h2>
          <ul class="special-list">
            <li> <img src="images/image20.jpg" width="60" height="60" alt="">
              <div class="img-det"> <strong class="title2">Aron Stone</strong>
                <p>Owner </p>
              </div>
              <a href="#" class="det-link">Detail</a> </li>
            <li class="even"> <img src="images/image19.jpg" width="60" height="60" alt="">
              <div class="img-det"> <strong class="title2">Mile Arton</strong>
                <p>Head Chef</p>
              </div>
              <a href="#" class="det-link">Detail</a> </li>
            <li> <img src="images/image16.jpg" width="18" height="60" alt="">
              <div class="img-det"> <strong class="title2">JENA Wolf</strong>
                <p>Head Chef</p>
              </div>
              <a href="#" class="det-link">Detail</a> </li>
          </ul>
          <a href="our-team.html" class="c-link">meet the rest of the team</a> </figure>
        <figure class="column three-col">
          <h2>Events Gallery</h2>
          <ul class="special-list">
            <li><img src="images/image01.jpg" alt="" width="60" height="60" >
              <div class="img-det"> <em>21-04-2012</em> <strong class="title">a news item</strong>
                <p>equipment, tips</p>
              </div>
              <a href="#" class="det-link">Detail</a> </li>
            <li class="even"><img src="images/image02.jpg" width="60" height="60" alt="">
              <div class="img-det"> <em>21-04-2012</em> <strong class="title">a news item</strong>
                <p>equipment, tips</p>
              </div>
              <a href="#" class="det-link">Detail</a> </li>
            <li><img src="images/image03.jpg" width="60" height="60" alt="">
              <div class="img-det"> <em>21-04-2012</em> <strong class="title">a news item</strong>
                <p>equipment, tips</p>
              </div>
              <a href="#" class="det-link">Detail</a> </li>
          </ul>
          <a href="blog.html" class="c-link">more entries on our blog</a> </figure>
      </section>
    </section>
  </div>
  <div class="holder-container last">
    <section class="grid-holder">
      <section class="grid">
        <figure class="column forth-fourth-col">
          <h2>Upcoming special offer's</h2>
        </figure>
        <br class="clearfix">
        <figure class="column three-col">
          <ul class="special-list2">
            <li> <a href="#" class="active">BBQ am Outdoorgrill</a> </li>
            <li> <a href="#">Spring special sushi</a> </li>
            <li> <a href="#">Sesamie delicious</a> </li>
            <li> <a href="#">Soup + Menu = $10.00</a> </li>
          </ul>
        </figure>
        <figure class="column three-fourth-col">
          <article class="box-1"> <img src="images/image39.jpg" width="194" height="160" alt="" class="team-img margin">
            <div class="box-inner">
              <h3>BBQ am Outdoorgrill </h3>
              <ul class="b-top-links box-list">
                <li class="cape"><a href="#">Cape venue</a></li>
                <li class="cal"><a href="#">21-02-2012</a></li>
                <li class="time-date"><a href="#">12:00 am t0 3:00 pm</a></li>
              </ul>
              <p>Just as the soul fills the body, so God fills the world. Just as the soul bears the body. Just as the soul sees but is not seen, so God sees but is not seen. Just as the soul feeds the body, so God gives food to the world.</p>
            </div>
          </article>
        </figure>
      </section>
    </section>
  </div>
  <? include '_footer.php' ?>
</div>
<!-- Start JavaScript --> 
<script type="text/javascript" src="js/slider.js"></script><!-- Main Slider --> 
<script type="text/javascript" src="js/sourtin-jquery.js"></script><!-- sourtin Slider --> 
<script type="text/javascript" src="js/jquery-u.js"></script><!-- jQuery Ui --> 
<script type="text/javascript" src="js/ddsmooth.js"></script><!-- Nav Menu ddsmoothmenu --> 
<script type="text/javascript" src="js/jquery03.js"></script><!-- Sliding Text and Icon Menu Style  --> 
<script type="text/javascript" src="js/colortip.js"></script><!-- Colortip Tooltip Plugin  --> 
<script type="text/javascript" src="js/tytabs00.js"></script><!-- jQuery Plugin tytabs  --> 
<script type="text/javascript" src="js/jquery04.js"></script><!-- jQuery Prettyphoto  --> 
<script type="text/javascript" src="js/jquery06.js"></script><!-- UItoTop plugin  --> 
<script type="text/javascript" src="js/custom00.js"></script><!-- Custom Js file for javascript in html --> 
<script type="text/javascript" src="js/focus.js"></script><!-- text field clear & celander Seting--> 

<script type="text/javascript" src="core/fancyapps/lib/jquery.mousewheel-3.0.6.pack.js"></script>
<script type="text/javascript" src="core/fancyapps/source/jquery.fancybox.pack.js"></script>


</body>
</html>
