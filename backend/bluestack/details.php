<?php
/*require 'db_con.php';
$id= $_GET['id'];
$query = $db->query("SELECT id,title,url,view_count,likes_count,dislikes_count,description,thumbnail,channel_title,channel_desc,channel_thumbnail,channel_subscriber from video where id=$id" );
$rows =array();
if($query)
{
	while($row = $query->fetch_array())
	{
		$rows[] = $row;
	}
}
print_r($rows);*/
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
//print_r($results); die;
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
<html>
<body>
	<div class="dt">
		<div>
			<span>
				<b>Id:</b>
			</span>
			<span>
				<?=$outputs['0']['video_id']?>
			</span>
	    </div>
	    <div>
			<span>
				<b>Title:</b>
			</span>
			<span>
				<?=$outputs['0']['title']?>
			</span>
	    </div>
	    <div>
			<span>
				<b>Url:</b>
			</span>
			<span>
				<a href="<?=$outputs['0']['url']?>"><?=$outputs['0']['title']?></a>
			</span>
	    </div>
	    <div>
			<span>
				<b>Description:</b>
			</span>
			<span>
				<?=$outputs['0']['description']?>
			</span>
	    </div>
	    <div>
			<span>
				<b>Thumbnail:</b>
			</span>
			<span>
				<img src="<?=$outputs['0']['thumbnail']?>" style=""></img>
			</span>
	    </div>
	    <div>
			<span>
				<b>View Count:</b>
			</span>
			<span>
				<?=$outputs['0']['view_count']?>
			</span>
	    </div>
	    <div>
			<span>
				<b>Likes Count:</b>
			</span>
			<span>
				<?=$outputs['0']['likes_count']?>
			</span>
	    </div>
	    <div>
			<span>
				<b>Dislikes Count:</b>
			</span>
			<span>
				<?=$outputs['0']['dislikes_count']?>
			</span>
	    </div>
	</div>
</body>
</html>
<style>
img {
  border: 1px solid #ddd;
  border-radius: 4px;
  padding: 5px;
  width: 50px;
}
.dt
{
    margin: auto;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    /*position: absolute;*/
    width: 600;
    height: 100px;
    
}
</style>