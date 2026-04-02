
<!DOCTYPE html>
<html>
<head>
<title>Login</title>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/style.css">
</head>
<body>

<div class="card">
<h2>Login</h2>

<form method="post" action="<?= base_url('auth/login')?>">

<input type="text" name="username" placeholder="Username" required>
<input type="password" name="password" placeholder="Password" required>

<button type="submit" class="main-btn">Login</button>
</form>

<a href="<?= base_url('auth/register')?>">Create Account</a>
</div>

</body>
</html>