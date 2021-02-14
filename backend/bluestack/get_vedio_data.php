<?php
$url='http://127.0.0.1:3000/vedio_fetch';
$video_url= $_GET['video_url'];
$data =   array ('video_url'=> $video_url);
$data_json = json_encode($data); //die;
$ch = curl_init($url);
$header[] = 'Content-type: application/json';
$header[] = 'Accept: application/json';
curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS,$data_json);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
$results = curl_exec($ch);
//print_r($results);
if(curl_errno($ch))
{
  print curl_error($ch);
}
  
else
{
  curl_close($ch);
}
$output = json_decode( preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $results), true );
//$jdatas['status'] = 1; 
//echo json_encode($jdatas);
?>