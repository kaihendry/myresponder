<?php
session_start();
require_once("../config.php");

function e( $text ){ return htmlspecialchars( $text, ENT_QUOTES, 'UTF-8' ); }
function je( $obj ){ return json_encode($obj, JSON_PRETTY_PRINT); }
// Malaysian numbers
function my_number( $n ){ return (substr($n, 0, 1) == 0) ? "6$n" : $n; }

function alert($id) {
	global $URL;
	global $HOST;
	global $ADMIN_EMAIL;
	$ts = time();
	echo "<h3>Time now: " . date("c") . "</h3>";
	if (! file_exists("../m/arm/$id")) {
	echo "<p>Your alert was un-armed. No guards were alerted. <a href=mailto:$ADMIN_EMAIL>Email admin to ask to be ARMED, which sends SMSes out to all responders/guards on duty.</a></p>";
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
		$url = $URL . "&from=MYRESP&callback=https://h.$HOST/report/&status-report-req=1&type=unicode&to=" . my_number($g["tel"]) .
			"&text=" . urlencode("⚠" . $_SESSION["address"] . " tel:" . $_SESSION["tel"] . " " . $_SESSION["name"] . " at " . date("c", $ts));
		curl_setopt($ch, CURLOPT_URL, $url);

		// We need both home owner and guard to be armed to get the SMS
		if (file_exists("../m/arm/$id") && file_exists("../m/arm/" . $g["ic"])) {
			echo "<li>Alerting " . $g["name"] . " on <a href=\"tel:" . $g["tel"] . "\">" . $g["tel"] . "</a></li>";
			$result=json_decode(curl_exec($ch), true);
		} else {
			echo "<li><s>UNARMED: Not alerting " . $g["name"] . " on <a href=\"tel:" . $g["tel"] . "\">" . $g["tel"] . "</a></s></li>";
			unset($result);
		}
		$info = curl_getinfo($ch);

		// Nasty crap to remove api secret
		$p = parse_url($info["url"], PHP_URL_QUERY);
		parse_str($p, $query_params);
		unset($query_params["api_secret"]);
		$info["url"] = $query_params;

		$errinfo = curl_error($ch);
		array_push($guards, array("result" => $result, "info" => $info, "error" => $errinfo, "name" => $g["name"], "ic" => $g["ic"]));
	}
	echo "</ul>";

	curl_close($ch);
	file_put_contents($alog, je(array("ts" => $ts, "guards" => $guards, "raiser" => $_SESSION)));
	$headers = "Reply-To: $HOST MyResponder <$ADMIN_EMAIL>";
	if (empty($result)) {
	mail($_SESSION["email"] . ",$ADMIN_EMAIL", "UNARMED Alert triggered for " . $_SESSION["name"], "Telephone number: " . $_SESSION["tel"] . "\nAlert details: https://h.$HOST/adisplay/?j=/$alog", $headers);
	} else {
	mail($_SESSION["email"] . ",$ADMIN_EMAIL", "ARMED Alert triggered for " . $_SESSION["name"], "Telephone number: " . $_SESSION["tel"] . "\nAlert details: https://h.$HOST/adisplay/?j=/$alog", $headers);
	}

	// Now mute until management lift it
	@unlink ("../m/arm/$id");
	}

if (isset($_GET["ic"])) {
	$_SESSION["ic"] =  preg_replace("/[^0-9]/", "", $_GET["ic"]);
	$_SESSION["name"] = substr($_GET["name"], 0, 64);
	$_SESSION["email"] = filter_var($_GET["email"], FILTER_SANITIZE_EMAIL);
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
		'email'=> $_SESSION["email"],
		'tel'=> $_SESSION["tel"]);
	$url = 'https://' . $_SERVER['HTTP_HOST'] . "/alert.php?" . http_build_query($data);
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
	}
}

if (file_exists($p)) {
		alert($id);
} else {
	echo "<p>Registering your alert with management.  
		Please save this link to your home screen if you haven't done already by <a href=\"//d.$HOST/\" target=\"_blank\">following these instuctions</a>.</p>";
	// Clock in
	$ci = $_SESSION;
	$ci["intime"] = time();
	// Save server info (might be useful)
	$ci["sin"] = $_SERVER;
	file_put_contents($p, je($ci));
	// TODO: Mail management WRT new registration that needs to be armed
}

?>

<dl>
    <dt>Name</dt>
    <dd><?php echo $_SESSION["name"];?></dd>
    <dt>Email</dt>
    <dd><?php echo $_SESSION["email"];?></dd>
    <dt>Address</dt>
    <dd><?php echo $_SESSION["address"];?></dd>
    <dt>Telephone</dt>
    <dd><?php echo $_SESSION["tel"];?></dd>
</dl>

<p><a href=/logout.php>Change details</a></p>
<p><a href=mailto:<?=$ADMIN_EMAIL;?>>Email admin</a></p>

<h3>Alert history</h3>
<ol>
<?php

function countresults($a) {
	$count = 0;
	foreach ($a["guards"] as $g) {
		if(! empty($g["result"])){
			$count++;
		}
	}
	return $count;
}

$history = glob("r/$id/alert/*.json");
rsort($history);
foreach ($history as $alog) {
	$a = json_decode(file_get_contents($alog), true);
	$c = countresults($a);
	echo "<li " . (($c == 0) ? "class=muted" : "") . "><a href=$alog>" . date("c", basename($alog, ".json")) . "</a> $c responder(s) notified</li>\n";
}
?>
</ol>
<p><a href="https://github.com/kaihendry/myresponder">Source code</a></p>
</body>
</html>
