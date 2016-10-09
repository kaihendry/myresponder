<?php
session_start();

// If you know the IC you can log that person out
if (isset($_GET["ic"])) {
	$_SESSION["ic"] =  preg_replace("/[^0-9]/", "", $_GET["ic"]);
}

if(empty($_SESSION["ic"])) { die("Invalid IC"); }

$id = $_SESSION["ic"];
// Record directory
$rdir = "r/$id";
// Current punch card
$p = "r/$id.json";

if (file_exists($p)) {
	$json = json_decode(file_get_contents($p), true);
	$json["outtime"] = time();
	$json["sout"] = $_SERVER;
	file_put_contents($rdir . "/" . $json["outtime"] .  ".json", json_encode($json, JSON_PRETTY_PRINT));
	unlink($p);
} else {
	die ("You weren't registered!");
}

// Unset all of the session variables.
$uri_args = $_SESSION;
$_SESSION = array();

if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

if (session_destroy()) {
	$url = '//' . $_SERVER['HTTP_HOST'];
	header("Location: $url?" . http_build_query($uri_args));
}
?>
