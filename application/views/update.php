
<!DOCTYPE html>
<html>
<head>
<title>Update Profile</title>

<link rel="stylesheet" href="<?= base_url('assets/style.css');?>">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</head>
<body>

<div class="card">
<h2>Update Profile</h2>

<form method="post" action="<?= base_url('auth/update')?>" enctype="multipart/form-data">

<input type="hidden" name="id" value="<?= $user->id ?>">
<label>Full Name</label>

<input type="text" name="fullname" value="<?= $user->fullname ?>" required>
<label>Phone no:</label>
<input type="text" name="contact" value="<?= $user->contact ?>" required>
<label>Date of Birth</label>
<input type="date" name="dob" value="<?= $user->dob ?>" required>
<label>Email</label>
<input type="email" name="email" value="<?= $user->email ?>" required>
<label>Address</label>
<textarea name="address"><?= $user->address ?></textarea>
<label>Country</label>
<select name="country" id="country" required>
<option value="">Select Country</option>
<?php foreach($countries as $c): ?>
<option value="<?= $c->country_id ?>"
<?= $c->country_id==$user->country_id?'selected':'' ?>>
<?= $c->country ?>
</option>
<?php endforeach; ?>
</select>

<div class="row">
<label>State</label>
<select name="state" id="state" required>
<option value="<?= $user->state_id ?>"><?= $user->state ?></option>
</select>
<button type="button" class="small-btn" id="addStateBtn">+</button>
</div>

<div class="row">
<label>City</label>
<select name="city" id="city" required>
<option value="<?= $user->city_id ?>"><?= $user->city ?></option>
</select>
<button type="button" class="small-btn" id="addCityBtn">+</button>
</div>
<label>Profile Image</label>
<input type="file" name="image">

<button type="submit" class="main-btn">Update</button>

</form>

<a href="<?= base_url('auth/profile')?>">Back to Profile</a>
</div>
<script>
$(function(){

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

$('#addStateBtn').click(function(){
    var state=prompt("Enter New State Name:");
    var country_id=$('#country').val();
    if(state && country_id){
        $.post("<?= base_url('add-state')?>",
        {state:state,country_id:country_id},
        function(){ $('#country').trigger('change'); });
    }
});

$('#addCityBtn').click(function(){
    var city=prompt("Enter New City Name:");
    var state_id=$('#state').val();
    if(city && state_id){
        $.post("<?= base_url('add-city')?>",
        {city:city,state_id:state_id},
        function(){ $('#state').trigger('change'); });
    }
});

});
</script>
</body>
</html>