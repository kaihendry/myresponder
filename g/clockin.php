<?php
session_start();
require("common.php");
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Punched in <?php echo session_id();?></title>
<meta name=viewport content="width=device-width, initial-scale=1">
<link href="/style.css" rel="stylesheet">
</head>
<body>
<?php
if (isset($_GET["ic"])) {
	$_SESSION["ic"] =  preg_replace("/[^0-9]/", "", $_GET["ic"]);
	$_SESSION["name"] = substr($_GET["name"], 0, 64);
	$_SESSION["tel"] = preg_replace("/[^0-9]/", "", $_GET["tel"]);
}

if(! is_numeric($_SESSION["ic"])) { session_destroy(); die("Invalid IC"); }
if(! is_numeric($_SESSION["tel"])) { session_destroy(); die("Invalid telephone"); }

$id = $_SESSION["ic"];
// Record directory
$rdir = "r/$id";
// Current punch card
$p = "r/$id.json";

if (empty($_SESSION["ic"])) {
	die("<a href=/>Click Here to Login</a>");
}

if (! file_exists($rdir)) {
	if (!mkdir($rdir, 0777, true)) {
		die('Failed to create dir ' . $rdir);
	} else {
		echo '<h1>Welcome ' . e($_SESSION["name"]) . '</h1>';
	}
}

if (file_exists($p)) {
	echo "<p>On call</p>";
	echo "<p>" . display($p) . "</p>";
} else {
	echo "<p>Putting you on call</p>";
	// Clock in
	$ci = $_SESSION;
	$ci["intime"] = time();
	// Save server info (might be useful)
	$ci["sin"] = $_SERVER;
	file_put_contents($p, json_encode($ci, JSON_PRETTY_PRINT));
	echo "<p>" . display($p) . "</p>";
}

?>

<h1><a href=/clockout.php>Clock out</a></h1>

<h3>Previous sessions</h3>
<ul>
<?php
foreach (glob($rdir . "/*.json") as $shifts) {
	echo "<li>" . display($shifts) . "</li>";
}
?>
</ul>
</body>
</html>
