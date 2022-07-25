<?php

//use Request;


$returnArray = array();

$returnArray['huhh'] = "yuhh";


//$postData = $request->post();


echo $bodyContent;

//echo $request->post('test');



/*

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://api.hubapi.com/files/v3/files?hapikey='. config('hubspot.api_key'),
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => array('file'=> new CURLFILE('/C:/Users/gabe/Desktop/116373282_3301974453192719_1983403285633004826_n.jpg'),'fileName' => 'mob-copy.jpg','charsetHunch' => 'UTF-8','options' => '{
    "access":  "PUBLIC_NOT_INDEXABLE",
    "ttl": "P2W",
    "overwrite": false,
    "duplicateValidationStrategy": "NONE",
    "duplicateValidationScope": "EXACT_FOLDER"
}','folderPath' => '/testmigrate222'),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;

*/




/*

echo"starting";

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://api.hubapi.com/files/v3/files?hapikey=' . config('hubspot.api_key'),
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => array('file'=> new CURLFILE('/C:/Users/gabe/Desktop/116373282_3301974453192719_1983403285633004826_n.jpg'),'fileName' => 'mob-copy.jpg','charsetHunch' => 'UTF-8','options' => '{
    "access":  "PUBLIC_NOT_INDEXABLE",
    "ttl": "P2W",
    "overwrite": false,
    "duplicateValidationStrategy": "NONE",
    "duplicateValidationScope": "EXACT_FOLDER"
}','folderPath' => '/testmigrate22222'),
  CURLOPT_HTTPHEADER => array(
    'Cookie: __cfduid=dff559c7e4e50e59fc7a51687fa1812361612831700'
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

echo $response;

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  echo $response;
}

echo'Complete';

*/


/*

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://api.hubapi.com/crm/v3/objects/2-1494682?limit=10&archived=false&hapikey=' . config('hubspot.api_key'),
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
  CURLOPT_HTTPHEADER => array(
    'Cookie: __cfduid=dff559c7e4e50e59fc7a51687fa1812361612831700'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;

*/


?>



