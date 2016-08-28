<?php

require '/srv/vendor/autoload.php';
use Aws\Ses\SesClient;

function sesMail($to, $subject, $message) {

$fromAdr = getenv("FROM");

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
	'ReplyToAddresses' => [getenv("M_EMAIL")],
	'ReturnPath' => $fromAdr,
	'Source' => $fromAdr,
]);

return $result['MessageId'];

}

?>
