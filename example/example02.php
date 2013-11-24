<?php
require '../vendor/autoload.php';

$arduino = new Arduino\Serial("com3", 9600);
//start listing the serial port with a parse function
$arduino->listen(10, 1, function($data) {
	if($data < 10) {
		return "low";
	}
	else if($data < 50) {
		return "medium";
	}
	else {
		return "high";
	}
});

$data = $arduino->getData();

