<link rel="stylesheet" type="text/css" href="css/boxstyle.css">
<link rel="stylesheet" type="text/css" href="core/css/mystyle.css"/>
<link rel="stylesheet" type="text/css" href="core/fancyapps/source/jquery.fancybox.css" media="screen" />
<script type="text/javascript" src="core/js/jquery.min-1.8.3.js"></script>
<script type="text/javascript" src="core/fancyapps/lib/jquery.mousewheel-3.0.6.pack.js"></script>
<script type="text/javascript" src="core/fancyapps/source/jquery.fancybox.pack.js"></script>
<script type="text/javascript">
	function addFood() {
		$.fancybox.open({
					href : 'admin/food/addMul.php',
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
	function showProfile() {
		$.fancybox.open({
					href : 'member/show_profile.php',
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
<?
		if ( !(isset($_SESSION['UIDS']) && isset($_SESSION['USERNAME']) && authenIdUser($_SESSION['UIDS'],$_SESSION['USERNAME']) ) ) { ?>
<div class="form1" style="float:none">
  <div class="formtitle">Login</div>
  <form action="login.php" method="post">
    <div class="form_login">
      <input name="username" type="text" class="logUsername" id="username" placeholder="Username" >
      <input type="password" name="password" placeholder="Password" class="logPassword" >
      <br>
      <br>
      <a href="forgetPassword.php">Forgot password.</a> <br>
      <br>
    </div>
    <div class="buttons">
      <input class="orangebutton" type="submit" value="Login" />
      <a href="register.php">
      <button class="greybutton" type="button">Register</button>
    </a> </div>
  </form>
</div>
<? } else { ?>
<div class="form1">
  <div class="formtitle">User</div>
  <p><br>
    Welcome :
    <?=$_SESSION["NAME"]?></p>
  <ul>
    <li><a onclick="showProfile()">ข้อมูลส่วนตัว</a></li>
    <li>
      <a onclick="addFood()">เพิ่มอาหาร</a>
    </li>
  </ul>
  <div class="buttons"> <a href="logout.php">
    <button class="orangebutton" >Logout</button>
  </a> </div>
</div>
<? } /*?>
<div class="form1">
  <div class="formtitle">Search</div>
  <br>
  ข้อมูลส่วนตัว<br>
   <div onclick="register()">เพิ่มอาหาร</div>

  <div class="buttons">
    <input class="greybutton" type="submit" value="Logout" onclick="register()" />
  </div>
</div>
<? */
	if ($_SESSION['USER_LEVEL']==1) {
?>
<div class="form1">
  <div class="formtitle">Admin</div>
  <ul>
    <li><a href="admin.php">Manage</a><br>
    </li>
  </ul>

</div>
<?	} ?>
