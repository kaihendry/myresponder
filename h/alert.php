<?php
session_start();

function e( $text ){ return htmlspecialchars( $text, ENT_QUOTES, 'UTF-8' ); }
function je( $obj ){ return json_encode($obj, JSON_PRETTY_PRINT); }

function alert($id) {
	$ts = time();
	$alog = "r/$id/alert/" . $ts . ".json";
	@mkdir(dirname($alog), 0777, true);

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	echo "<ul>";
	$guards = array();
	foreach (glob("../g/r/*.json") as $gj) {
		$g = json_decode(file_get_contents($gj), true);
		echo "<li>Alerting " . $g["name"] . " on <a href=\"tel:" . $g["tel"] . "\">" . $g["tel"] . "</a></li>";
		$url = "http://feedback.dabase.com/mail.php?api_key=6adec75d&api_secret=$alog&from=MYRESP&to=" . $g["tel"] .
			"&text=" . urlencode("RESPOND: " . $_SESSION["address"] . " " . $_SESSION["name"] . " tel:" . $_SESSION["tel"] . " at " . date("c", $ts));
		curl_setopt($ch, CURLOPT_URL, $url);
		$result=curl_exec($ch);
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
	file_put_contents($alog, je(array("guards" => $guards)));
	echo "<h1>Alerted $alog</h1>";

	// Now mute until management lift it
	// touch ("muted/$id");
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
	if (file_exists("muted/$id")) {
		// Add to home screen code goes here
		// https://developers.google.com/web/updates/2015/03/increasing-engagement-with-app-install-banners-in-chrome-for-android?hl=en
		// http://cubiq.org/add-to-home-screen
		echo "<p>Your alert is muted until management approve. Please save this link to your home screen.</p>";
	} else {
		// ALERT ALERT ALERT ALERT ALERT
		echo "<p>Raising alert to all guards on duty:</p>";
		alert($id);
	}
} else {
	echo "<p>Registering your alert with management</p>";
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
	echo "<li><a href=$alog>" . date("r", basename($alog, ".json")) . "</a></li>";
}
?>
</ol>
</body>
</html>
