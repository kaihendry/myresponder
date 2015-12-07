<?php
session_start();
if ($_SESSION["ic"]) {
	// If there is an existing session, do not bother to login
	$url = 'http://' . $_SERVER['HTTP_HOST'];
	header('Location: ' . $url . "/clockin.php");
	die();
}
require("common.php");
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Punch in <?php echo session_id();?></title>
<meta name=viewport content="width=device-width, initial-scale=1">
<link href="/style.css" rel="stylesheet">
<script src=main.js></script>
</head>
<body>

<form action=/clockin.php method=GET autocomplete=on>

<!-- https://en.wikipedia.org/wiki/Malaysian_identity_card -->
<input required name=ic placeholder="IC">

<input required name=name placeholder="Name">
<input required name=tel type=tel placeholder="Mobile number">

<input type=submit value="Clock in">

</form>

<h3>Clocked in users</h3>
<ol>
<?php
foreach (glob("r/*.json") as $responder) {
	echo "<li>" . display($responder) . "</li>";
}
?>
</ol>

<!-- PHP SESSIONS
<?php
foreach (glob(session_save_path() . "/*") as $activesession) {
	echo "<li>" . basename($activesession) . "</li>\n";
}
?>
-->

<p>Total shifts: <?php echo `find -mindepth 3  -name '*.json' | wc -l`;?></p>

<p><a href=https://github.com/kaihendry/clockin>MIT licensed source code</a></p>
</body>
</html>
