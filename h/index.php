<?php
session_start();
if ($_SESSION["address"]) {
	// If there is an existing session, do not bother to login
	$url = 'http://' . $_SERVER['HTTP_HOST'];
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
<script src=main.js></script>
</head>
<body>

<form action=/alert.php method=GET autocomplete=on>

<!-- https://en.wikipedia.org/wiki/Malaysian_identity_card -->
<input required name=ic placeholder="IC">

<input required name=name placeholder="Name">
<input required name=address placeholder="Address">
<input required name=tel type=tel placeholder="Mobile number">

<input type=submit value="Register">

</form>

<p><a href=https://github.com/kaihendry/clockin>MIT licensed source code</a></p>
</body>
</html>
