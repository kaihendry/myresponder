<?php
if (empty($_REQUEST["messageId"])) {
	die("Missing message id");
}
$fn = $_REQUEST["messageId"] . '.json';
if (file_put_contents($fn, json_encode($_REQUEST, JSON_PRETTY_PRINT))) {
	echo "Saved to <a href=$fn>$fn</a>";
} else {
	echo "Not saved to $fn";
}
?>
