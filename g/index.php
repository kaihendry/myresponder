<?php
include("../config.php");
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

<input required name=ic placeholder="IC" value="<?php echo htmlspecialchars ($_GET['ic'], ENT_QUOTES); ?>">
<input required name=name placeholder="Name" value="<?php echo htmlspecialchars ($_GET['name'], ENT_QUOTES); ?>">
<input required name=tel type=tel placeholder="Mobile number" value="<?php echo htmlspecialchars ($_GET['tel'], ENT_QUOTES); ?>">

<input type=submit value="Clock in">
</form>
<p>Registered responders:
<?php echo count(glob("r/*.json")); ?>
</p>

</body>
</html>
