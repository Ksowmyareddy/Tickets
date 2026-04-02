<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!DOCTYPE html>
<html>
<head>

<title>Welcome</title>

<style>

body{
font-family:Arial;
margin:40px;
}

/* ICON */

#aiWidgetButton{
position:fixed;
bottom:20px;
right:20px;
width:60px;
height:60px;
background:#0d6efd;
border-radius:50%;
display:flex;
align-items:center;
justify-content:center;
cursor:pointer;
z-index:9999;
}

#aiWidgetButton img{
width:35px;
}

/* POPUP */

#aiSearchPanel{
position:fixed;
bottom:90px;
right:20px;
width:420px;
height:520px;
background:white;
display:none;
box-shadow:0 10px 25px rgba(0,0,0,.3);
z-index:9998;
border-radius:10px;
overflow:hidden;
}

</style>

</head>
<body>


<h2>Welcome Page</h2>

<p>Main page content here</p>


<!-- ICON -->

<div id="aiWidgetButton"
onclick="toggleSearchPanel()">

<img src="<?= base_url('assets/images/logo.png') ?>">

</div>


<!-- POPUP -->

<div id="aiSearchPanel">

<iframe
id="searchFrame"
src="http://localhost/News/SmartSearch"
style="width:100%;
height:100%;
border:none;">
</iframe>

</div>



<script>

function toggleSearchPanel(){

var panel =
document.getElementById("aiSearchPanel");

if(panel.style.display=="block"){

panel.style.display="none";

}else{

panel.style.display="block";

}

}

</script>


</body>
</html>