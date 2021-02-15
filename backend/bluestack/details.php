<?php
$id= $_GET['id'];
$url='http://127.0.0.1:3000/vedio_list/'.$id;
$ch = curl_init($url);
$header[] = 'Content-type: application/json';
$header[] = 'Accept: application/json';
curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
$results = curl_exec($ch);
if(curl_errno($ch))
{
print curl_error($ch);
}

else
{
  curl_close($ch);
}
$outputs = json_decode( preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $results), true );
//print_r($outputs);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800&display=swap" rel="stylesheet">
    <style>
        .list-formate {
            margin: 40px 70px;
            border: 1px solid gray;
        }
        
        .d-inline {
            font-size: 16px;
            padding: 8px 20px;
        }
        
        img.img-thumbnail {
            height: 100px;
            width: 100px;
        }
        
        .user-detail {
            margin: 20px 16px;
        }
        .margin-top-left {
            font-size: 26px;
            margin: 41px 70px 0;
        }

        a {
            text-decoration: none;
        }
    </style>
</head>

<body>
    <div class="margin-top-left"><a href="index.php">Back</a></div>
    <div class="list-formate">
        <div class="user-detail">
            <img class="img-thumbnail" src="<?=$outputs['0']['thumbnail']?>" alt="thumbnail">
            <div><span><b>Video Thumbnail</span></b></div>
        </div>
        
        <div class="d-inline">
            <span><b>Video Id:</b> </span><span><?=$outputs['0']['video_id']?></span>
        </div>
        <div class="d-inline">
            <span><b>Video Title:</b> </span><span><?=$outputs['0']['title']?></span>
        </div>
        <div class="d-inline">
            <span><b>Video Url:</b> </span><span><a href="<?=$outputs['0']['url']?>"><?=$outputs['0']['url']?></a></span>
        </div>
       
        <div class="d-inline">
            <span><b>View Count:</b> </span><span><?=$outputs['0']['view_count']?></span>
        </div>
        <div class="d-inline">
            <span><b>Likes Count:</b> </span><span><?=$outputs['0']['likes_count']?></span>
        </div>
        <div class="d-inline">
            <span><b>Dislikes Count:</b> </span><span><?=$outputs['0']['dislikes_count']?></span>
        </div>
        <div class="d-inline">
            <span><b>Descripition</b> </span><span><?=$outputs['0']['description']?></span>
        </div>
        <div class="user-detail">
            <img class="img-thumbnail" src="<?=$outputs['0']['channel_thumbnail']?>" alt="thumbnail">
            <div><span><b>Channel Thumbnail</span></b></div>
        </div>
         <div class="d-inline">
            <span><b>Channel Title:</b> </span><span><?=$outputs['0']['channel_title']?></span>
        </div>
        <div class="d-inline">
            <span><b>Channel Description:</b> </span><span><?=$outputs['0']['channel_desc']?></span>
        </div>
        <div class="d-inline">
            <span><b>Channel Subscriber:</b> </span><span><?=$outputs['0']['channel_subscriber']?></span>
        </div>
    </div>

</body>

</html>
