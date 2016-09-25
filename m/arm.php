<?php

header('Content-Type: application/json');
require_once("../config.php");
require_once("../aws-helpers.php");

$path = "arm";
$id = $_POST["id"];

if (! empty($id) && is_numeric($id)) {
	if (file_exists("$path/$id")) {
		if (! unlink("$path/$id")) {
			http_response_code(400);
		} else {
			echo json_encode(array("unarmed" => $id));
		}
	} else {
		@mkdir($path);
		if (file_put_contents("$path/$id", $_SERVER['REMOTE_ADDR'])) {
			if (file_exists("../h/r/$id.json")) {
				$h = json_decode(file_get_contents("../h/r/$id.json"), true);
				// error_log( print_r( $h, true ) );
				if (filter_var($h["email"], FILTER_VALIDATE_EMAIL)) {
					// error_log("Mail home owner " . $h["email"]);
					sesMail($h["email"], "Alert for " . $h["name"] . " ARMED", "Visiting Webpage again will trigger an alarm.");
				}
			}
			echo json_encode(array("armed" => $id));
		} else {
			http_response_code(400);
		}
	}
} else {
	http_response_code(400);
	die("id missing");
}

?>
