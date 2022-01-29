<?php

use Aws\Ses\SesClient;

function sesMail($to, $subject, $message) {

if (empty($to)) {
	$to = "hendry+myresponder@iki.fi";
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

use Aws\Sns\SnsClient;

function sms($number, $message) {

if (empty($number) || empty($message)) {
	return false;
}

$SnsClient = new Aws\Sns\SnsClient([
	'version'   =>  'latest',
	'region'    =>  "ap-southeast-1"
]);

$result = $SnsClient->publish(array(
	'Message'   =>  $message,
	'PhoneNumber'   =>  $number,
	'MessageAttributes' => array(
		'AWS.SNS.SMS.SMSType' => array('StringValue'=>'Transactional','DataType'=>'String'),
		'AWS.SNS.SMS.SenderID' => array('StringValue' => substr(explode('.', getenv('HOST'), 2)[0],0,10), 'DataType' => 'String')
	),
));

return $result['MessageId'];

}

?>
