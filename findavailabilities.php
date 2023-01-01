<?php

extract($_GET);
$currentDate = date('Y-m-d');

if ($date <= $currentDate) {
die("client side verification by passed");
}

require('connection.php');


