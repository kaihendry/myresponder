<?php
session_start();
require_once("../config.php");

function e( $text ){ return htmlspecialchars( $text, ENT_QUOTES, 'UTF-8' ); }
function je( $obj ){ return json_encode($obj, JSON_PRETTY_PRINT); }
function my_number( $n ){ return (substr($n, 0, 1) == 0) ? "6$n" : $n; }

function alert($id) {
	global $URL;
	$ts = time();
	echo "<h3>Time now: " . date("c") . "</h3>";
	if (file_exists("muted/$id")) {
	echo "<p>Your alert was un-armed. No guards were alerted. Please contact management.</p>";
		} else {
	echo "<p>Raising alert to all responders on duty:</p>";
	}
	$alog = "r/$id/alert/" . $ts . ".json";
	@mkdir(dirname($alog), 0777, true);

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	echo "<ul>";
	$guards = array();
	foreach (glob("../g/r/*.json") as $gj) {
		$g = json_decode(file_get_contents($gj), true);
		// https://docs.nexmo.com/api-ref/sms-api/request
		$url = $URL . "&from=MYRESP&callback=http://h.uptown.dabase.com/report/&status-report-req=1&type=unicode&to=" . my_number($g["tel"]) .
			"&text=" . urlencode("⚠" . $_SESSION["address"] . " tel:" . $_SESSION["tel"] . " " . $_SESSION["name"] . " at " . date("c", $ts));
		curl_setopt($ch, CURLOPT_URL, $url);
		if (file_exists("muted/$id")) {
		echo "<li><s>Alerting " . $g["name"] . " on <a href=\"tel:" . $g["tel"] . "\">" . $g["tel"] . "</a></s></li>";
		} else {
		echo "<li>Alerting " . $g["name"] . " on <a href=\"tel:" . $g["tel"] . "\">" . $g["tel"] . "</a></li>";
		$result=json_decode(curl_exec($ch), true);
		}
		$info = curl_getinfo($ch);

		// Nasty crap to remove api secret
		$p = parse_url($info["url"], PHP_URL_QUERY);
		parse_str($p, $query_params);
		unset($query_params["api_secret"]);
		$info["url"] = $query_params;

		$errinfo = curl_error($ch);
		array_push($guards, array("result" => $result, "info" => $info, "error" => $errinfo));
	}
	echo "</ul>";

	curl_close($ch);
	file_put_contents($alog, je(array("guards" => $guards, "raiser" => $_SESSION)));

	// Now mute until management lift it
	touch ("muted/$id");
	}

if (isset($_GET["ic"])) {
	$_SESSION["ic"] =  preg_replace("/[^0-9]/", "", $_GET["ic"]);
	$_SESSION["name"] = substr($_GET["name"], 0, 64);
	$_SESSION["address"] = substr($_GET["address"], 0, 64);
	$_SESSION["tel"] = preg_replace("/[^0-9]/", "", $_GET["tel"]);
}

if(! is_numeric($_SESSION["ic"])) { session_destroy(); die("Invalid IC"); }
if(empty($_SESSION["address"])) { session_destroy(); die("Invalid Address"); }
if(! is_numeric($_SESSION["tel"])) { session_destroy(); die("Invalid telephone"); }

if (empty($_GET["ic"])) { // We need to ensure we are always a GET request to ensure URL for Adding to home screen is good
	$data = array('ic'=> $_SESSION["ic"],
		'name'=> $_SESSION["name"],
		'address'=> $_SESSION["address"],
		'tel'=> $_SESSION["tel"]);
	$url = 'http://' . $_SERVER['HTTP_HOST'] . "/alert.php?" . http_build_query($data);
	header('Location: ' . $url);
}

$id = $_SESSION["ic"];
// Record directory, to track when they change details on logout (kinda pointless?)
$rdir = "r/$id";
// Current active alert
$p = "r/$id.json";

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Alert for <?php echo $_SESSION["name"]; ?></title>
<meta name=viewport content="width=device-width, initial-scale=1">
<link href="/style.css" rel="stylesheet">
<meta name="mobile-web-app-capable" content="yes">
<link rel="icon" sizes="180x180" href="/apple-touch-icon.png">
</head>
<body>
<?php

if (! file_exists($rdir)) {
	if (!mkdir($rdir, 0777, true)) {
		die('Failed to create dir ' . $rdir);
	} else {
		// First seen
		echo '<h1>Welcome ' . e($_SESSION["name"]) . '</h1>';
		touch ("muted/$id");
	}
}

if (file_exists($p)) {
		alert($id);
} else {
	echo "<p>Registering your alert with management. Please save this link to your home screen if you haven't done already.</p>";
	// Clock in
	$ci = $_SESSION;
	$ci["intime"] = time();
	// Save server info (might be useful)
	$ci["sin"] = $_SERVER;
	file_put_contents($p, je($ci));
	// TODO: Mail management WRT new registration that needs to be un-muted
}

?>

<dl>
    <dt>Name</dt>
    <dd><?php echo $_SESSION["name"];?></dd>
    <dt>Address</dt>
    <dd><?php echo $_SESSION["address"];?></dd>
    <dt>Telephone</dt>
    <dd><?php echo $_SESSION["tel"];?></dd>
</dl>

<p><a href=/logout.php>Change details</a></p>

<h3>Alert history</h3>
<ol>
<?php
$history = glob("r/$id/alert/*.json");
rsort($history);
foreach ($history as $alog) {
	$a = json_decode(file_get_contents($alog), true);
	echo "<li " . (empty($a["guards"][0]["result"]) ? "class=muted" : "") . "><a href=$alog>" . date("c", basename($alog, ".json")) . "</a></li>\n";
}
?>
</ol>
</body>
</html>
