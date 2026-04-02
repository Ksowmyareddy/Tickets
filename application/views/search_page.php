
<!DOCTYPE html>
<html>

<head>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<style>

table{
border-collapse:collapse;
width:100%;
}

td,th{
border:1px solid black;
padding:5px;
}

#result{
max-height:400px;
overflow:auto;
}

</style>

</head>

<body>

<h2>Search</h2>

<input id="search" style="width:400px">

<button onclick="doSearch()">Search</button>

<div id="result"></div>

<button onclick="loadMore()">Load More</button>

<script>

var offset=0;
var last="";

function doSearch()
{

offset=0;

last=$("#search").val();

$.post(
"index.php/api/search",
{search:last},
function(data){

var d=JSON.parse(data);

table(d);

});

}


function loadMore()
{

offset+=10;

$.post(
"index.php/api/loadmore",
{search:last,offset:offset},
function(data){

var d=JSON.parse(data);

append(d);

});

}


function table(data)
{

var h="<table>";

h+="<tr>";

for(var k in data[0])
h+="<th>"+k+"</th>";

h+="</tr>";

for(var i=0;i<data.length;i++)
{

h+="<tr>";

for(var k in data[i])
h+="<td>"+data[i][k]+"</td>";

h+="</tr>";

}

h+="</table>";

$("#result").html(h);

}


function append(data)
{

var h="";

for(var i=0;i<data.length;i++)
{

h+="<tr>";

for(var k in data[i])
h+="<td>"+data[i][k]+"</td>";

h+="</tr>";

}

$("#result table").append(h);

}


$("#search").keypress(function(e){

if(e.which==13)
doSearch();

});

</script>

</body>
</html>