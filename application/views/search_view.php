

<!DOCTYPE html>
<html>
<head>

<title>Smart Vehicle Parts Fitment System</title>

<link rel="stylesheet"
href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</head>

<body>

<div class="container mt-5">

<h3 class="text-center mb-4">
Smart Vehicle Parts Fitment System
</h3>

<div class="input-group mb-4">

<input type="text"
id="search"
class="form-control"
placeholder="Search product">

<button class="btn btn-primary"
id="searchBtn">
Search
</button>

</div>

<table class="table table-bordered">

<thead class="table-dark">

<tr>
<th>#</th>
<th>Product</th>
<th>Part No</th>
<th>Category</th>
<th>Fitment</th>
</tr>

</thead>

<tbody id="result"></tbody>

</table>

<div class="text-center">

<button id="loadMoreBtn"
class="btn btn-success"
style="display:none;">
Load More
</button>

</div>

</div>

<script>

let limit=10;
let offset=0;
let keyword="";
let counter=1;

function searchData(reset=false){

$.ajax({

url:"http://localhost/News/api/product_api/search_products",

type:"GET",

headers:{
"Authorization":"Bearer AZ123TOKEN"
},

dataType:"json",

data:{
keyword:keyword,
limit:limit,
offset:offset
},

success:function(res){

if(reset){
$('#result').html('');
counter=1;
offset=0;
}

if(Array.isArray(res) && res.length>0){

res.forEach(function(row){

$('#result').append(`

<tr>

<td>${counter++}</td>
<td>${row.product}</td>
<td>${row.product_code}</td>
<td>${row.category}</td>

<td>
<span class="view-fitment"
data-id="${row.product_id}"
style="color:blue;cursor:pointer;">
View Fitment
</span>
</td>

</tr>

<tr class="fitment-row"
id="fitment_${row.product_id}"
style="display:none;">
<td colspan="5"></td>
</tr>

`);

});

offset+=limit;

$('#loadMoreBtn').show();

}else{

if(offset===0){

$('#result').html(`<tr>
<td colspan="5">No Results</td>
</tr>`);

}

$('#loadMoreBtn').hide();

}

}

});

}

$('#searchBtn').click(function(){

keyword=$('#search').val().trim();

searchData(true);

});

$('#search').keypress(function(e){

if(e.which==13){

keyword=$('#search').val().trim();

searchData(true);

}

});

$('#loadMoreBtn').click(function(){

searchData(false);

});

$(document).on('click','.view-fitment',function(){

let id=$(this).data('id');
let row=$("#fitment_"+id);

if(row.is(':visible')){
row.hide();
return;
}

$.ajax({

url:"http://localhost/News/api/product_api/get_fitment",

type:"GET",

headers:{
"Authorization":"Bearer AZ123TOKEN"
},

dataType:"json",

data:{product_id:id},

success:function(res){

let html=`
<table class="table table-sm table-bordered">
<tr>
<th>Make</th>
<th>Model</th>
<th>Variant</th>
<th>Year</th>
</tr>
`;

if(Array.isArray(res) && res.length>0){

res.forEach(function(f){

html+=`
<tr>
<td>${f.brand_name}</td>
<td>${f.model_name}</td>
<td>${f.variant_name}</td>
<td>${f.st_year}</td>
</tr>
`;

});

}else{

html+=`
<tr>
<td colspan="4">No Fitment Data</td>
</tr>
`;

}

html+="</table>";

row.find('td').html(html);

row.show();

}

});

});

</script>

</body>
</html>