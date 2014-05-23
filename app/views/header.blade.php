<!DOCTYPE html>
<html>
<head>
	<title>Look! I'm CRUDding</title>
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css">
	<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
	{{ HTML::script('js/vendor/dropzone.js') }}
	{{ HTML::style('css/basic.css') }}
	
	<script>
		$(function(){

			var dropzoneId = "#my-awesome-dropzone";

			var dz = new Dropzone(dropzoneId,{ 
				createImageThumbnails: false,
				url: "/postImages",
				method: "post",
				success: function(file, response){
					// console.log("success");
					// for(var key in file){
					// 	console.log("succ "+key+"\t"+file[key]);
					// }

					var imageId = JSON.parse(response).id;
					var filename = JSON.parse(response).path;

					console.log(imageId);

					dz.removeFile(file);

					TLCreateImage(imageId, filename);
					
					return true;
				},
				error: function(file, errorMessage){
					console.log("Post error: "+errorMessage);
				}
				
			});

		});

		function TLCreateImage(imageId, filename){

			var dropzoneId = "#my-awesome-dropzone";

			var newElement = jQuery('<div/>',{
				id: 'data-'+imageId,
				class: 'dz-preview dz-file-preview'

			});
			newElement.html("<div class=\"dz-details\">\n <input type=\"text\" style=\"display:none;\" name=\"image[]\" value=\""+imageId+"\">  <img src=\"/images/"+filename+"\">\n <div class=\"dz-error-mark\"><a href=\"javascript:TLRemoveImage("+imageId+");\">✘</a></div>\n   </div> ");
			newElement.appendTo(dropzoneId);


		}

		function TLRemoveImage(imageId){
			var ele = document.getElementById("data-"+imageId);
			ele.parentNode.removeChild(ele);
		}
	</script>
</head>
<body>
<div class="container">

<nav class="navbar navbar-inverse">
	<div class="navbar-header">
		<a class="navbar-brand" href="{{ URL::to('shops') }}">shop Alert</a>
	</div>
	<ul class="nav navbar-nav">
		<li><a href="{{ URL::to('/createUser') }}">ユーザ新規</a></li>
		<li><a href="{{ URL::to('/privatePage') }}">private page</a></li>
		<li><a href="{{ URL::to('/logout') }}">ログアウト</a></li>
	</ul>
</nav>