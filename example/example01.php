<?php
require '../vendor/autoload.php';
//new instance
$arduino = new Arduino\Serial("com3", 9600);
//start listing the serial port 10 times delay 1 sec
$arduino->listen(10, 1);
//get back the data collected
$data = $arduino->getData();

