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
    $timeStamp = date("Y-m-d H:i:s");

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
           
            $query = 'SELECT * from offers WHERE id="'.$cid.'"';
            $result = mysql_query($query) or die("error!!!");
                   
            $row = mysql_fetch_array($result);
        
            $source = $row["from"];
            $dest = $row["to"];
            
             $query = 'SELECT * from cities WHERE city_name="'.$source.'"';
                 
            $result = mysql_query($query) or die("error!!!");
                   
            $row = mysql_fetch_array($result);
            
            $sourceLat= $row["latitude"];
            $sourceLon =$row["longitude"];
            
            $query = 'SELECT * from cities WHERE city_name="'.$dest.'"';
                 
            $result = mysql_query($query) or die("error!");
                   
            $row = mysql_fetch_array($result);
            
            $destLat= $row["latitude"]; 
            $destLon =$row["longitude"];

            $distance = sqrt(pow(((float)$destLat -(float)$sourceLat) , 2)+ pow(((float)$destLon -(float)$sourceLon) , 2)); 
             
            $query = 'SELECT credits from users WHERE uid="'.$sender.'"';
            
            $result = mysql_query($query) or die("error!!!");
            $row = mysql_fetch_array($result);

            $senderCredits = (float)($distance) + (float)($row["credits"]);
            $query = 'UPDATE users SET credits="' .$senderCredits .'" WHERE uid="' .$sender. '"';
            $result = mysql_query($query) or die("error!!!3");

            /*************************/

            $query = 'SELECT credits from users WHERE uid="'.$receiver.'"';
            
            $result = mysql_query($query) or die("error!!!1");
            $row = mysql_fetch_array($result);

            $receiverCredits = (float)($distance) + (float)($row["credits"]);

            $query = 'UPDATE users SET credits ="' .$receiverCredits .'" WHERE uid="' .$receiver. '"';
            $result = mysql_query($query) or die("error!!!2");
            

        }
        
}

else if($type=="2"){


     // change the parameter in notification table
    // create one more notification
    // update offers
    $query = 'SELECT * from notifications WHERE slno="'.$slno.'"';
    $result = mysql_query($query) or die("error!!!");
    $comment = $_POST["rating"];
    $row = mysql_fetch_array($result);
    $receiver = $row["receiver"];
    $cid = $row["cid"];
    
        $query = 'INSERT INTO comments(sender,comment,cid) VALUES ("'.$receiver.'","'.$comment.'","'.$cid.'")';
        $result = mysql_query($query) or die("error!!!");
    
        $query = 'DELETE FROM notifications WHERE slno="'.$slno.'"'; 
        $result = mysql_query($query) or die("error!!!");
    echo "YO man!";
}
?>

