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
<? if ( !authenIdUser()) { ?>
<div class="form1" style="float:none">
  <div class="formtitle">Login</div>
  <form action="login.php?ref=<?=$_SERVER['REQUEST_URI']?>" method="post">
    <div class="form_login">
      <input name="username" type="text" class="logUsername" id="username" placeholder="Username" required="required">
      <input type="password" name="password" placeholder="Password" class="logPassword" required="required">
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
    <li><a href="member.php">ข้อมูลส่วนตัว</a></li>
    <li><a href="member_favorite.php">อาหารที่ชอบ</a></li>
    <li><a href="member_comments.php">คอมเม้นท์</a></li>
    <li>
      <a href="javascript:addFood();">เพิ่มอาหาร</a>
    </li>
  </ul>
  <div class="buttons"> <a href="logout.php?ref=<?=$_SERVER['REQUEST_URI']?>">
    <button class="orangebutton" >Logout</button>
  </a> </div>
</div>
<? } ?>
<?
 if (!endsWith($_SERVER['PHP_SELF'],'search.php')){ ?>
<div class="form1" style="float:none">
  <div class="formtitle">Search</div>
  <form action="search.php" method="post">
    <div style="margin-left:15px;"><br />
    <label>ชื่ออาหาร
      <input name="name" type="text"  autofocus="autofocus" class="input" id="name" tabindex="1" autocomplete="on" value="<?=$_POST['name']?>" size="32" style="margin-bottom:15px;" /></label>
	<label>ประเภทอาหาร
      <select class="labelF combobox" id="foodtype" name="foodtype" >
        <option value="" selected="selected"> - ประเภทอาหาร - </option>
        <? echo optionFoodType($_POST['foodtype']);?>
      </select></label>
      <br />
      <br />
    </div>
    <div class="buttons">
      <input name="fsearch" type="hidden" id="fsearch" value="1" />
      <input class="orangebutton" type="submit" value="ค้นหา" />
    </div>
  </form>
</div>
<link rel="stylesheet" type="text/css" href="core/css/jquery-ui.css">
<script src="core/js/jquery-ui-1.10.3.js"></script>
<script src="core/js/combobox.js"></script>
<script type="text/javascript">
	$( ".combobox" ).combobox();
</script>
<? } ?>
<?
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

