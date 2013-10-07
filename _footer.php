<?
$foodversion = 132;
?>
<link rel="stylesheet" type="text/css" href="core/css/box.css"/>
<section class="footer-top">
      <div class="footer-inner">
        <figure class="f-column">
          <h4 class="title3">Recent Comments</h4>
          <ul class="post-list" id="theComment">
            <?
				
			include('connectDB.php');
			$strSQL = "SELECT * FROM 	(Select * from ICOMMENTS C JOIN IFOODS F ON C.FID=F.FID JOIN IUSERS U ON C.UIDS=U.UIDS ORDER BY C.STIME DESC) WHERE ROWNUM  <= 3";
			//echo $strSQL;
			$objParse = oci_parse($objConnect, $strSQL);
			$objExecute = oci_execute($objParse, OCI_DEFAULT);
			$searchOB = array();
			while ($row = oci_fetch_array($objParse, OCI_BOTH)) {
		?>
            <li class="c-icon">
              <p><?=$row['NAME']?> : <?=$row['MESSAGE']?></p>
              <div class="row">
    	           <em class="post-date"> <? echo str_replace('.000000', '',$row['STIME'])?></em><br>
                   <em class="mycomments">in : <a href="foodDetail.php?foodid=<?=$row['FID']?>" style="color:white;"><?=$row['FOODNAME']?></a></em>
              </div>
            </li>
            <? } ?>
          </ul>
          <script>
	if(typeof(EventSource)!=="undefined")
	  {
	  var source3=new EventSource("module/newcomment_flush.php");
	  source3.onmessage=function(event)
		{
		  document.getElementById("theComment").innerHTML=event.data;
		//alert(event.data);
		};
	  }
	else
	  {
	  //document.getElementById("result").innerHTML="Sorry, your browser does not support server-sent events...";
	  }
	</script>
        </figure>
        <figure class="f-column">
          <h4 class="title3">Sponsors</h4>
          <img src="core/images/sponsor/IronChef.jpg" width="240" height="180" alt="" class="boxD"/>
          <img src="core/images/sponsor/naauan.jpeg" width="179" height="180" alt=""  class="boxD"/>
          <img src="core/images/sponsor/cp.jpg" width="177" height="180" alt=""  class="boxD"/>
        </figure>
      </div>
    </section>
  </section>
  <!-- footer -->
  <footer id="footer">
    <div class="copy-right">
      <p>Copyright © 2013 Food Cooking</p>
    </div>
    <ul class="social-list">
      <li class="rss"><a href="#">Rss</a></li>
      <li class="fb"><a href="#">Facebook</a></li>
      <li class="twitter"><a href="#">Twitter</a></li>
      <li class="social-icon"><a href="#">Social-icon</a></li>
      <li class="flicker"><a href="#">Flicker</a></li>
    </ul>
  </footer>
  
  <?
  /*
  $url = 'http://foodcooking.googlecode.com/svn/trunk/admin/version.php'; 
  $curl = curl_init(); 
	curl_setopt($curl, CURLOPT_URL, $url); 
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); 
	$data = curl_exec($curl); 
	curl_close($curl); //decoding request 
	if ($data!="98"){
		//echo   '<script type="text/javascript"> alert("แหม่ๆ ยังไม่ Update SVN เลย ไป Update ก่อนนะครับ"); </script>';
	}
	*/
  ?>
<script>
var alertflag = false;
if(typeof(EventSource)!=="undefined")
  {
  var source=new EventSource("module/flusher.php");
  source.onmessage=function(event)
    {
		//alert(event.data)
		if (event.data=="null" && !alertflag){
			alertflag = true;
			if(confirm('เห้ย ไปต่อ Server ก่อน,ถ้าอยู่หอก้อ VPN ก่อนนนนนนเน่อ')) {
				window.location.reload();
				alertflag = false;
			} else alertflag = false;
		} else if (event.data!="<?=$foodversion?>" && !alertflag){
			alertflag = true;
			if(confirm('แหม่ๆ ยังไม่ Update SVN เลย ไป Update ก่อนนะครับ')) {
				window.location.reload();
				alertflag = false;
			} else alertflag = false;
		}
		
    	//document.getElementById("result").innerHTML+=event.data + "<br>";
    };
  }
else
  {
  //document.getElementById("result").innerHTML="Sorry, your browser does not support server-sent events...";
  }
</script>
