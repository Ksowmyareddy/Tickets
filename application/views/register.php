
<!DOCTYPE html>
<html>
<head>
<title>User Registration</title>

<link rel="stylesheet" href="<?= base_url('assets/style.css')?>">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</head>
<body>

<div class="card">
<h2>Create Account</h2>

<form method="post" action="<?= base_url('auth/save')?>" enctype="multipart/form-data">

<!-- FULL NAME -->
<label>Full Name</label>
<input type="text" name="fullname" required>

<!-- USERNAME -->
<label>Username (for Login)</label>
<input type="text" name="username" required>

<!-- PASSWORD -->
<label>Password</label>
<input type="password" name="password" required>

<!-- CONTACT -->
<label>Contact Number</label>
<input type="text" name="contact" required>

<!-- DOB -->
<label>Date of Birth</label>
<input type="date" name="dob" required>

<!-- EMAIL -->
<label>Email</label>
<input type="email" name="email" required>
 
<!-- ADDRESS -->
<label>Address</label>
<textarea name="address" required></textarea>

<!-- COUNTRY -->
<label>Country</label>
<select name="country" id="country" required>
<option value="">Select Country</option>
<?php foreach($countries as $c): ?>
<option value="<?= $c->country_id ?>"><?= $c->country ?></option>
<?php endforeach; ?>
</select>

<!-- STATE -->
<label>State</label>
<div class="row">
<select name="state" id="state" required>
<option value="">Select State</option>
</select>
<button type="button" class="small-btn" id="addStateBtn">+</button>
</div>

<!-- CITY -->
<label>City</label>
<div class="row">
<select name="city" id="city" required>
<option value="">Select City</option>
</select>
<button type="button" class="small-btn" id="addCityBtn">+</button>
</div>

<!-- IMAGE -->
<label>Profile Image</label>
<input type="file" name="image">

<button type="submit" class="main-btn">Register</button>

</form>

<a href="<?= base_url()?>">Already have an account? Login</a>
</div>

<script>

$(function(){

// Load States
$('#country').change(function(){
    var id=$(this).val();

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

// Load Cities
$('#state').change(function(){
    var id=$(this).val();

    $.post("<?= base_url('get-cities')?>",{state_id:id},function(data){

        var cities=JSON.parse(data);
        var html='<option value="">Select City</option>';

        $.each(cities,function(i,c){
            html+='<option value="'+c.city_id+'">'+c.city+'</option>';
        });

        $('#city').html(html);
    });
});

// Add State
$('#addStateBtn').click(function(){

    var state=prompt("Enter New State Name:");
    var country_id=$('#country').val();

    if(!country_id){
        alert("Select Country First");
        return;
    }

    if(state){
        $.post("<?= base_url('add-state')?>",
        {state:state,country_id:country_id},
        function(res){
            alert("State Added");
            $('#country').trigger('change');
        });
    }
});

// Add City
$('#addCityBtn').click(function(){

    var city=prompt("Enter New City Name:");
    var state_id=$('#state').val();

    if(!state_id){
        alert("Select State First");
        return;
    }

    if(city){
        $.post("<?= base_url('add-city')?>",
        {city:city,state_id:state_id},
        function(res){
            alert("City Added");
            $('#state').trigger('change');
        });
    }
});

});

</script>

</body>
</html>