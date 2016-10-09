<?php
session_start();
if ($_SESSION["address"]) {
	// If there is an existing session, do not bother to login
	$url = '//' . $_SERVER['HTTP_HOST'];
	header('Location: ' . $url . "/alert.php");
	die();
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Home owners</title>
<meta name=viewport content="width=device-width, initial-scale=1">
<link href="/style.css" rel="stylesheet">
</head>
<body>

<form action=/alert.php method=GET autocomplete=on>

<!-- https://en.wikipedia.org/wiki/Malaysian_identity_card -->
<input required name=ic placeholder="IC" value="<?php echo htmlspecialchars ($_GET['ic'], ENT_QUOTES); ?>">
<input required name=name placeholder="Name" value="<?php echo htmlspecialchars ($_GET['name'], ENT_QUOTES); ?>">
<input required name=email placeholder="Email" type=email value="<?php echo htmlspecialchars ($_GET['email'], ENT_QUOTES); ?>">
<input required name=address placeholder="Address" value="<?php echo htmlspecialchars ($_GET['address'], ENT_QUOTES); ?>">
<input required name=tel type=tel placeholder="Mobile number" value="<?php echo htmlspecialchars ($_GET['tel'], ENT_QUOTES); ?>">

<input type=submit value="Register">

</form>

<footer><a href=https://github.com/kaihendry/myresponder>MIT licensed source code</a> version <?php echo getenv("COMMIT"); ?> </footer>
</body>
</html>
