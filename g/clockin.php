<?php
include("../config.php");
session_start();

// http://stackoverflow.com/a/6534559/4534
function getNiceDuration($durationInSeconds) {

  $duration = '';
  $days = floor($durationInSeconds / 86400);
  $durationInSeconds -= $days * 86400;
  $hours = floor($durationInSeconds / 3600);
  $durationInSeconds -= $hours * 3600;
  $minutes = floor($durationInSeconds / 60);
  $seconds = $durationInSeconds - $minutes * 60;

  if($days > 0) {
    $duration .= $days . ' days';
  }
  if($hours > 0) {
    $duration .= ' ' . $hours . ' hours';
  }
  if($minutes > 0) {
    $duration .= ' ' . $minutes . ' minutes';
  }
  if($seconds > 0) {
    $duration .= ' ' . $seconds . ' seconds';
  }
  return $duration;
}

function e( $text ){ return htmlspecialchars( $text, ENT_QUOTES, 'UTF-8' ); }

function display($r) {
	$json = json_decode(file_get_contents($r), true);
	if (isset($json["outtime"])) {
		$ft = date("c", $json["outtime"]);
		return "<a href=$r><time dateTime=$ft>$ft</time> lasting " . getNiceDuration($json["outtime"] - $json["intime"]) . "</a>";
	} else {
		$ft = date("c", $json["intime"]);
		return "<a href=$r>" . e($json["name"]) . " on duty since <time dateTime=$ft>$ft</time> with mobile number " . e($json["tel"]) . "</a>";
	}
}
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

// if($_SESSION["tel"][0] != "0" || $_SESSION["tel"][0] != "6") { session_destroy(); die("Invalid Malaysian telephone"); }

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

<h3>Previous clock outs</h3>
<ul>
<?php
$history = glob($rdir . "/*.json");
rsort($history);
foreach ($history as $shifts) {
	echo "<li>" . display($shifts) . "</li>";
}
?>
</ul>
</body>
</html>
