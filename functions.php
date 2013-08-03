<?php
/*
 * Common functions used throughout Codejudge
 */
session_start();

// connects to the database
function connectdb() {
  include('dbinfo.php');
  $con=mysql_connect($host,$user,$password);
  if (!$con) {
		die('Could not connect to mysql: ' . mysql_error());
	}
  mysql_select_db($database) or die('Error connecting to database. '. mysql_error());
}

// generates a random number.
function randomNum($length){
  $rangeMin = pow(36, $length-1);
  $rangeMax = pow(36, $length)-1;
  $base10Rand = mt_rand($rangeMin, $rangeMax);
  $newRand = base_convert($base10Rand, 10, 36);
  return $newRand;
}

// checks if any user is logged in
function loggedin() {
  return isset($_SESSION['username']);
}
?>