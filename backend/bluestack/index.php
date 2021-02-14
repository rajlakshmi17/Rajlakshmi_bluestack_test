<?php
$url='http://127.0.0.1:3000/vedio_list';
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
<!DOCTYPE html>
<html>
<head>
<style>
#videolist {
  font-family: Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

#videolist td, #videolist th {
  border: 1px solid #ddd;
  padding: 8px;
}

#videolist tr:nth-child(even){background-color: #f2f2f2;}

#videolist tr:hover {background-color: #ddd;}

#videolist th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
  /*background-color:black;
  //color: white;*/
}
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
<div>
	<input type="text" id="url" name="url" placeholder="Example:https://www.youtube.com/watch?v=hGf8rOwFzvo">
	<button onclick="get_video_data();">Get Video details</button>
</div>
<table id="videolist">
<thead>
	<tr>
		<th>Id</th>
		<th>Title</th>
		<th>Url</th>
		<th>Views</th>
		<th>Likes</th>
		<th>Dislikes</th>
		<th>Action</th>
	</tr>
</thead>
<tbody>
<?php foreach($outputs as $data) {
?>
	<tr>
		<td><?=$data['id']?></td>
	    <td><?=$data['title']?></td>
	    <td><a href="<?=$data['url']?>"><?=$data['title']?></a></td>
	    <td><?=$data['view_count']?></td>
	    <td><?=$data['likes_count']?></td>
	    <td><?=$data['dislikes_count']?></td>
	    <td><a href="details.php?id=<?=$data['id']?>"><i class="fa fa-eye"></i></a></td>
	</tr>
<?php } ?>
</tbody>
  
</table>

</body>
</html>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript">
	function get_video_data()
	{
		var url = document.getElementById("url").value;  
		$.ajax({
          type: "GET",
          url:'get_vedio_data.php?video_url='+url,
          async: true,
          dataType: "json",
          success: function( data ) {
            if(data['status']==1)
          	{
          		alert(data['message']);
           		location.reload();
          	}
          	else
          	{
           		alert("error found!")

          	}

          }
      });
	}
</script>
