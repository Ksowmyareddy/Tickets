
<!DOCTYPE html>
<html>
<head>
<title>Profile</title>
<link rel="stylesheet" href="<?= base_url('assets/style.css')?>">
</head>
<body>

<div class="profile-card">
<h2>Welcome <?= $user->fullname ?></h2>

<?php if($user->image): ?>
<img src="<?= base_url('uploads/'.$user->image)?>" class="profile-img">
<?php endif; ?>

<p><b>DOB:</b> <?= format_dob($user->dob) ?></p>
<p><b>Email:</b> <?= $user->email ?></p>
<p><b>Contact:</b> <?= $user->contact ?></p>
<p><b>Country:</b> <?= $user->country ?></p>
<p><b>State:</b> <?= $user->state ?></p>
<p><b>City:</b> <?= $user->city ?></p>

<div class="profile-buttons">
<a href="<?= base_url('auth/edit')?>" class="btn-update">Update</a>
<a href="<?= base_url('auth/logout')?>" class="btn-logout">Logout</a>
</div>

</div>

</body>
</html>