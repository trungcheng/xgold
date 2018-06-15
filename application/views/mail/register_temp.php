<!DOCTYPE html>
<html>
<head>
  	<meta charset="utf-8" />
  	<title>Verify the registration | Xgold</title>
  	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
</head>
<body>
	Hi <b><?= $topMsg ?>!</b>
	<br /><br />
	Welcome to XGOLD system!
	<br /><br />
	<?= $bodyMsg ?><br />
	<span>Please click to link on the bottom to confirm your registration!</span>
	<br />
	<br />
	<a href="<?= $verificationLink ?>"><?= $verificationLink ?></a>
	<br />
	<br />
	-----------------------
	<br />
	<?= $thanksMsg ?><br />
	<b>XGOLD Team.</b>
</body>
</html>