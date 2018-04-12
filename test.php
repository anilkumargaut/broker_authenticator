<?php
define("oauth_consumer_key","your consumer key");
define("oauth_consumer_Secret_key","your consumer secret key");
define("oauth_consumer_Secret_token","your consumer secret token");
$date = date("Y/m/d");
$timestamp = strtotime($date);
$Nonce = md5(rand());
$oauth_signature = base64_encode(hash_hmac('sha1', oauth_consumer_Secret_key, oauth_consumer_Secret_token, true));



$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://etws.etrade.com/oauth/request_token",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_HTTPHEADER => array(
    "authorization: OAuth realm: ",
    "oauth_callback: oob",
    "oauth_consumer_key:".oauth_consumer_key,
    "oauth_nonce:".$Nonce,
    "oauth_signature:".$oauth_signature,
    "oauth_signature_method: HMAC-SHA1",
    "oauth_timestamp:".$timestamp
    ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

	if ($err) {
	  echo "cURL Error #:" . $err;
	} else {
	  echo "<pre>";
	  print_r($response);
	}
