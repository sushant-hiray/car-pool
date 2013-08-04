<?php
require_once('functions.php');
connectdb();
                 
$userid = $_POST["uid"];
$from = $_POST["from"];
$to = $_POST["to"];
$cid = $_POST["cid"];
$query = 'SELECT * FROM offers where id="'.$cid.'"';
$result = mysql_query($query) or die("error!!!".mysql_error()) ;
$row = mysql_fetch_array($result);
$timestamp= date("Y-m-d H:i:s");

$sender = $row["uid"];
//pooler waiting for approval from owner

$query = 'INSERT INTO notifications (sender, receiver, type ,cid, timestamp) VALUES("'.$userid. '","'. $userid .'","4","'. $cid . '","' . $timestamp .'")';  

$result = mysql_query($query) or die("error23!")  ;

//sent for appoval to car owner
$query = 'INSERT INTO notifications (sender, receiver, type ,cid, timestamp) VALUES("'.$userid. '","'. $sender .'","1","'. $cid . '","' . $timestamp .'")';  

$result = mysql_query($query) or die("error!45!")  ;
header("Location: index.php?success=1");



?>

