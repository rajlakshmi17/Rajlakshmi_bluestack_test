var http = require("http");
var express = require('express');
var app = express();
var mysql      = require('mysql');
var bodyParser = require('body-parser');
const fs = require('fs')
const youtubedl = require('youtube-dl')
//const fetch = require('node-fetch');
//start mysql connection
var connection = mysql.createConnection({
  host     : 'localhost', //mysql database host name
  user     : 'root', //mysql database user name
  password : '', //mysql database password
  database : 'bluestack' //mysql database name
});

connection.connect(function(err) {
  if (err) throw err
  console.log('You are now connected with mysql database...')
})
//end mysql connection

//start body-parser configuration
app.use( bodyParser.json() );       // to support JSON-encoded bodies
app.use(bodyParser.urlencoded({     // to support URL-encoded bodies
  extended: true
}));
//end body-parser configuration

//create app server
var server = app.listen(3000,  "127.0.0.1", function () {

  var host = server.address().address
  var port = server.address().port

  console.log("Example app listening at http://%s:%s", host, port)

});

//rest api to get all popular videos from YouTube
app.get('/vedio_list', function (req, res) {
   connection.query('select * from video', function (error, results, fields) {
	  if (error) throw error;
	  res.end(JSON.stringify(results));
	});
});
//rest api to get a single video data
app.get('/vedio_list/:id', function (req, res) {
   connection.query('select * from video where Id=?', [req.params.id], function (error, results, fields) {
	  if (error) throw error;
	  res.end(JSON.stringify(results));
	});
});


app.post('/vedio_fetch',(req,res) => {
const url =  req.body.video_url;
const options = ['--username=raj', '--password=hunter2']
youtubedl.getInfo(url,options,function(err, info) {
  if (err) throw err
  //console.log(JSON.stringify(info.thumbnails));
  var count_sql = "SELECT * FROM video where video_id='"+info.id+"'";
  var query = connection.query(count_sql, function(err, result) {
  
      if(result.length==0)
      {
        
        var sql = "INSERT INTO video ( video_id, title, url, description,thumbnail,thumbnails_details,view_count,likes_count,dislikes_count,channel_title) VALUES ('"+info.id+"','"+info.title.replace("'", "")+"','" +url.replace("'", "")+"','"+ info.description.replace("'", "")+"','"+info.thumbnail.replace("'", "")+"','"+JSON.stringify(info.thumbnails)+"','"+info.view_count+"','"+info.like_count+"','"+info.dislike_count+"','"+info.uploader+"')";
        //console.log(sql)
        connection.query(sql, function (err, result) {  
        if (err) throw err;  
          res.send({ message: 'record inserted',status:1 });
        });
      }
      else
      {
        var sql = "update video set title='"+info.title.replace("'", "")+"',url='"+url.replace("'", "")+"',description='"+info.description.replace("'", "")+"',thumbnail='"+info.thumbnail.replace("'", "")+"',thumbnails_details='"+JSON.stringify(info.thumbnails)+"',view_count="+info.view_count+",likes_count="+info.like_count+",dislikes_count="+info.dislike_count+",channel_title='"+info.uploader+"' where video_id='"+info.id+"'";
        connection.query(sql, function (err, result) {  
        if (err) throw err;  
          res.send({ message: 'record updated',status:1 });
        });
      }
      
  });
  

});

});

