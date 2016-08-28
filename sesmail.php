<?php

require '/srv/vendor/autoload.php';
use Aws\Ses\SesClient;

function sesMail($to, $subject, $message) {

if (empty($to)) {
	$to = "hendry@iki.fi";
}

$SesClient = new Aws\Ses\SesClient([
	'version'   =>  'latest',
	'region'    =>  getenv("REGION")
]);

$result = $SesClient->sendEmail([
	'Destination' => [
		'ToAddresses' => [
			$to, getenv("M_EMAIL")
		],
	],
	'Message' => [
		'Body' => [
			'Text' => [
				'Charset' => 'UTF-8',
				'Data' => $message,
			],
		],
		'Subject' => [
			'Charset' => 'UTF-8',
			'Data' => $subject,
		],
	],
	'ReturnPath' => getenv("M_EMAIL"),
	'Source' => getenv("M_EMAIL"),
]);

return $result['MessageId'];

}

?>
