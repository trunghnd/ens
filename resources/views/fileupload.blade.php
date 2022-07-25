<?php

?>

<!DOCTYPE html>
<html>
<head>


<meta name="csrf-token" content="{{ csrf_token() }}">


	<title>Dropzone</title>

<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.8.0/min/dropzone.min.js" integrity="sha512-OrzfT4DZdVn0D1+jawpCOnNLYTdv2KJKeuPgjSn5vjD2ew59jXgSDItHrC4WYLfqxxONojMKc9Rl6s12GZKkiw==" crossorigin="anonymous"></script>



</head>
<body>



<form action="/file-upload"
      class="dropzone"
      id="my-awesome-dropzone"></form>

<input id="huhh" type="file"/>


<div class="btn" onclick="formAction()">Launch</div>

<img id="yourImgTag" src="" />

<style>

.btn{
	display: inline-block;
	padding: 10px 20px;
	background: grey;
	color: white;
	border-radius: 4px;
	margin: 20px;
	cursor: pointer;
}	


</style>

<script>

function formAction(){


uploadStuff();



/*	

	var file = document.getElementById("huhh").files[0].name;

	console.log(file);


	var input = document.getElementById("huhh");
var fReader = new FileReader();
fReader.readAsDataURL(input.files[0]);

fReader.onloadend = function(event){
	console.log("load End");

    var img = document.getElementById("yourImgTag");
    img.src = event.target.result;



}

*/



}	


function uploadStuff(){


var input = document.getElementById("huhh");
var fReader = new FileReader();
fReader.readAsDataURL(input.files[0]);

fReader.onloadend = function(event){
	console.log("load End");

    //var img = document.getElementById("yourImgTag");

    b64 = event.target.result;

    sendStuff(b64);

};


}//uploadStuff


function sendStuff(b64){


var data = {"b64": b64,
			"test": "test data"};


var ready = true;


console.log(data);



	var myHeaders = new Headers();
myHeaders.append("Content-Type", "application/json");
myHeaders.append("Cookie", "__cfduid=d5b8b2ca1d78fcac8e552f6acb7a612851607928577; __cfruid=173f7d7a5c81607954f6c6da5416e580900ba024-1608020193");
myHeaders.append("X-CSRF-TOKEN", "{{ csrf_token() }}");



var requestOptions = {
  method: 'POST',
  headers: myHeaders,
  body: JSON.stringify(data),
  redirect: 'follow'
};


fetch("{{URL::to('/')}}/api/hsfiles", requestOptions)
  .then(response => response.json())
  .then(result => fileResult(result))
  .catch(error => console.log('error', error));
	


}//sendstuff





function fileResult(result){


  console.log("Server Message Follows");

  console.log(result);


}





</script>


</body>
</html>

