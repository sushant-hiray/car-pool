<?php

require_once('functions.php');
connectdb();
$type = $_POST["type"];
$slno = $_POST["serialNo"];
if($type=="1"){
    $query = 'SELECT * from notifications WHERE slno="'.$slno.'"';
    $result = mysql_query($query) or die("error!!!");
    $stat = $_POST["stat"];
    $row = mysql_fetch_array($result);

    $sender = $row["sender"]; 
    $receiver= $row["receiver"];
    $newType=3;
    $newStatus=$stat;
    $cid=$row["cid"];
    $timeStamp=date('m/d/Y h:i:s a', time());

        $query = 'UPDATE notifications SET status="' .$stat. '" WHERE slno="' .$slno. '"';
        
        $result = mysql_query($query) or die("error!!!");
        
        $query = 'INSERT INTO notifications(sender,receiver,type,cid,timestamp,status) VALUES ("'.$receiver.'","'.$sender.'","'.$newType.'","'.$cid.'","'.$timeStamp.'","'.$newStatus.'")'; 
        
        $result = mysql_query($query) or die("error!!!");

        if($stat=="Approved"){
        
            $query = 'SELECT people from offers WHERE id="'.$cid.'"';
            $result = mysql_query($query) or die("error!!!");
            
            $row = mysql_fetch_array($result);

            $noOfPeople = (int)$row["people"]-1;

            
            $query = 'UPDATE offers SET people ="' .$noOfPeople .'" WHERE id="' .$cid. '"';
            $result = mysql_query($query) or die("error!!!");
        
        }
        
    }

     // change the parameter in notification table
    // create one more notification
    // update offers

    echo "YO man!";
?>

