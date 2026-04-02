<!DOCTYPE html>
<html>
<head>
<title>Location Selector</title>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<style>
body { font-family: Arial; background:#eef2f7; }

.card{
    width:550px;
    margin:50px auto;
    background:white;
    padding:30px;
    border-radius:12px;
    box-shadow:0 10px 25px rgba(0,0,0,0.1);
}

h2{text-align:center;margin-bottom:20px;}

.row{display:flex;gap:10px;margin-top:12px;}

select,input{
    flex:1;
    padding:10px;
    border:1px solid #ccc;
    border-radius:6px;
}

.small-btn{
    padding:10px;
    background:#28a745;
    color:white;
    border:none;
    border-radius:6px;
    cursor:pointer;
}

.small-btn:hover{background:#218838;}

.save-btn{
    margin-top:15px;
    width:100%;
    padding:12px;
    background:#007bff;
    color:white;
    border:none;
    border-radius:6px;
}

.output{
    margin-top:20px;
    background:#f8f9fa;
    padding:15px;
    border-radius:6px;
}
</style>
</head>
<body>

<div class="card">
<h2>Select Location</h2>

<!-- Country -->
<div class="row">
<select id="country">
<option value="">Select Country</option>
<?php foreach($countries as $c): ?>
<option value="<?= $c->country_id ?>"><?= $c->country ?></option>
<?php endforeach; ?>
</select>
</div>

<!-- State -->
<div class="row">
    <select id="state">
        <option value="">Select State</option>
    </select>
    <button type="button" class="small-btn" id="addStateBtn">+ State</button>
</div>

<!-- City -->
<div class="row">
    <select id="city">
        <option value="">Select City</option>
    </select>
    <button type="button" class="small-btn" id="addCityBtn">+ City</button>
</div>

<button class="save-btn" id="saveBtn">Save</button>

<div class="output" id="result"></div>

</div>

<script>
$(function(){

$('#country').change(function(){
    var id=$(this).val();
    $('#state').html('<option>Loading...</option>');
    $.post("<?= base_url('get-states')?>",{country_id:id},function(data){
        var states=JSON.parse(data);
        var html='<option value="">Select State</option>';
        $.each(states,function(i,s){
            html+='<option value="'+s.state_id+'">'+s.state+'</option>';
        });
        $('#state').html(html);
        $('#city').html('<option value="">Select City</option>');
    });
});

$('#state').change(function(){
    var id=$(this).val();
    $('#city').html('<option>Loading...</option>');
    $.post("<?= base_url('get-cities')?>",{state_id:id},function(data){
        var cities=JSON.parse(data);
        var html='<option value="">Select City</option>';
        $.each(cities,function(i,c){
            html+='<option value="'+c.city_id+'">'+c.city+'</option>';
        });
        $('#city').html(html);
    });
});

$('#addStateBtn').click(function(){
    var state=prompt("Enter State Name:");
    var country_id=$('#country').val();

    if(!country_id){
        alert("Please select country first");
        return;
    }

    if(state){
        $.post("<?= base_url('add-state')?>",
        {state:state,country_id:country_id},
        function(res){
            var r=JSON.parse(res);
            alert(r.status=='exists'?'State already exists':'State Added');
            $('#country').trigger('change');
        });
    }
});

$('#addCityBtn').click(function(){
    var city=prompt("Enter City Name:");
    var state_id=$('#state').val();

    if(!state_id){
        alert("Please select state first");
        return;
    }

    if(city){
        $.post("<?= base_url('add-city')?>",
        {city:city,state_id:state_id},
        function(res){
            var r=JSON.parse(res);
            alert(r.status=='exists'?'City already exists':'City Added');
            $('#state').trigger('change');
        });
    }
});

$('#saveBtn').click(function(){
    var country=$('#country option:selected').text();
    var state=$('#state option:selected').text();
    var city=$('#city option:selected').text();

    if(!$('#country').val() || !$('#state').val() || !$('#city').val()){
        alert("Please select all fields");
        return;
    }

    $('#result').html(
        "<b>Saved Location:</b><br>"+
        "Country: "+country+"<br>"+
        "State: "+state+"<br>"+
        "City: "+city
    );
});

});
</script>

</body>
</html>