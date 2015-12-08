<?php
session_start();
if ($_SESSION["ic"]) {
	// If there is an existing session, do not bother to login
	$url = 'http://' . $_SERVER['HTTP_HOST'];
	header('Location: ' . $url . "/clockin.php");
	die();
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Responders</title>
<meta name=viewport content="width=device-width, initial-scale=1">
<link href="/style.css" rel="stylesheet">
<script src=main.js></script>
</head>
<body>

<form action=/clockin.php method=GET autocomplete=on>

<input required name=ic placeholder="IC">
<input required name=name placeholder="Name">
<input required name=tel type=tel placeholder="Mobile number">
<input type=submit value="Clock in">
</form>
<p>Responders on duty:
<?php echo count(glob("r/*.json")); ?>
</p>

</body>
</html>
