<?
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');

  $url = 'http://foodcooking.googlecode.com/svn/trunk/admin/version.php'; 
  $curl = curl_init(); 
	curl_setopt($curl, CURLOPT_URL, $url); 
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); 
	$data = curl_exec($curl); 
	curl_close($curl); //decoding request 
    
$time = date('r');
echo "data: {$data}\n\n";
flush();
?>
