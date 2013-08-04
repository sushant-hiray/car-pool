<html>
<head>
    <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
    <script src="http://code.jquery.com/jquery.js"></script>
	<script src="js/bootstrap.min.js"></script>
</head> 
<body>   
<?php
    require_once('functions.php');
        connectdb();
        //$userId = getUserid();
        $userId ="2"; 
        $query = 'SELECT * from notifications WHERE receiver="'.$userId.'" ORDER BY timestamp DESC;';
        $result = mysql_query($query) or die("error!!!")  ;
        
?>
        <table class="table table-hover">
            <thead><tr>
            <th>Time</th>
            <th>Car Pool Details</th>
            <th>Notification Type</th>
            <th>Action</th>
            </tr>
            </thead>
            <tbody>
<?php
        while($row = mysql_fetch_array($result)){
            $type = $row["type"];
            echo '<tr>';
            echo '<td>'.$row["timestamp"].'</td>';
            if($type=="1"){
                // Request from sender to apporve his car pool request
                $query = 'SELECT * from offers WHERE id="'.$row["cid"].'";';
                $result1 = mysql_query($query) or die("error!!");
                $carPoolRow = mysql_fetch_array($result1);
                echo '<td>'. $carPoolRow["from"] . '=>'. $carPoolRow["to"] . '</td>';   
                echo '<td>Approve Request</td>';
                $status = $row["status"];
                $cid = $row["cid"];
                $slno = $row["slno"];
                $sender=$row["sender"];
                if($status=="Approved"){ 
                    echo '<td><button class="btn" disabled  >Approved</button><td>';
                }
                else if($status=="Declined"){
                
                    echo '<td><button class="btn" disabled >Declined</button></td>';
                }
                else{
                    $funcAgrsApp = '"ApproveRequest('.$slno.',1)"';
                    $funcAgrsDec = '"ApproveRequest('.$slno.',0)"';
                    echo '<td><button class="btn"  onclick='.$funcAgrsApp.'>Approve</button> 
                        <button onclick='.$funcAgrsDec. 'class="btn" >Decline</button></td>';
                }
                echo '<td></td>';
            }
            else if($type=="2"){
                $query = 'SELECT * from offers WHERE id="'.$row["cid"].'";';
                $result1 = mysql_query($query) or die("error!!");
                $carPoolRow = mysql_fetch_array($result1); 
                echo '<td>'. $carPoolRow["from"] . '=>'. $carPoolRow["to"] . '</td>';   
                $status = $row["status"];
                echo '<td>Feedback</td>';
                if($status != "0"){ 
                    echo '<td>'.$status.'/5<td>';
                }
                else{
                    echo '<td>
                         <a class="btn dropdown-toggle" data-toggle="dropdown" href="#"> 
                            <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu">
                            <!-- dropdown menu links -->
                              <li class="active">hi</li>
                            </ul>
                            </div><button class="btn">Submit</button></td>';
                }
            echo '</tr>';     
        }
    }
?>
    </tbody>
    </table>
    <script>
       function ApproveRequest(slno,stat){
             if(stat=="0"){
           
            $.post("updateDBNotifications.php", { type: "1", serialNo: slno, stat: "Declined" })
            .done(function(data) {
            alert("Data Loaded: " + data);
             location.reload();
            });     
            } 
            else if(stat=="1"){
                // change the parameter in notification table
                // create one more notification
                // update offers
            $.post("updateDBNotifications.php", { type: "1", serialNo: slno, stat: "Approved" })
            .done(function(data) {
            alert("Data Loaded: " + data);
             location.reload();
            });     
            }
            else{
                alert("Random error , stat doesnot match");
            }
    }

    </script>    
</body>
</html>
