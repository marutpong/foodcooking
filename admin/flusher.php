<?
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');

  $url = 'http://10.10.188.254/group10/version.php'; 
  $curl = curl_init(); 
	curl_setopt($curl, CURLOPT_URL, $url); 
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); 
	$data = curl_exec($curl); 
	$httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
	curl_close($curl); //decoding request 
    $valid=1;
	if($httpCode == 404) {
		$valid=0;
	}
if ($valid==0){ $data = "null"; }
echo "data: {$data}\n\n";
flush();

?>
