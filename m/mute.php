<?php

header('Content-Type: application/json');
$path = "../h/muted/";
$id = $_POST["id"];

if (! empty($id) && is_numeric($id)) {
	if (file_exists("$path/$id")) {
		if (! unlink("$path/$id")) {
			http_response_code(400);
		} else {
			echo json_encode(array("unmuted" => $id));
		}
	} else {
		@mkdir($path);
		if (! file_put_contents("$path/$id", $_SERVER['REMOTE_ADDR'])) {
			http_response_code(400);
		} else {
			echo json_encode(array("muted" => $id));
		}
	}
} else {
	http_response_code(400);
	die("id missing");
}

?>
