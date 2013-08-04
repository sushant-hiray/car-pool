<?php
/*
 * The landing page that lists all the problem
 */
	require_once('functions.php');
	if(!loggedin())
		header("Location: login.php");
	else
		include('header.php');
		connectdb();
?>
<div class="container">
	<?php
        if(isset($_GET['share']))
          echo("<div class=\"alert alert-info\">\nYour Ride was succesfully added! You can edit it from your profile\n</div>");
        else if(isset($_GET['nerror']))
          echo("<div class=\"alert alert-error\">\nPlease enter all the details asked before you can continue!\n</div>");
      ?>

<?php
include('menu.php');
?>
<div class="row-fluid" id="main-content">
		<div class="span1"></div>
        <div class="span10">
<?php
    require_once('functions.php');
        connectdb();
        $userId = getUserid();
        //$userId ="1"; 
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
                $slno = $row["slno"];
                echo '<td>'. $carPoolRow["from"] . '=>'. $carPoolRow["to"] . '</td>';   
                $status = $row["status"];
                echo '<td>Feedback</td>';
                if($status != ""){ 
                    echo '<td>'.$status.'/5<td>';
                }
                else{
?>
                       <td> 

                     <div class="btn-group">
                                <button id ="fartDropDown" class="btn dropdown-toggle" data-toggle="dropdown">Rating <span class="caret"></span></button>
                                <ul class="dropdown-menu">
                                  <li><a href="#">1</a></li>
                                  <li><a href="#">2</a></li>
                                  <li><a href="#">3</a></li>
                                  <li><a href="#">4</a></li>
                                  <li><a href="#">5</a></li>
                                </ul>
                      </div><!-- /btn-group -->
 <?php
                        $funcAgrsRate = '"RateRequest('.$slno.')"';
                        echo '<button class="btn"  onclick='.$funcAgrsRate.'>Submit</button> ';
                        echo '</td>';
                }
        echo '</tr>';     
       }
        else if($type=="3"){
            $query = 'SELECT * from offers WHERE id="'.$row["cid"].'";';
            $result1 = mysql_query($query) or die("error!!");
            $carPoolRow = mysql_fetch_array($result1); 
            $status = $row["status"];
            $cid = $row["cid"];
            $slno = $row["slno"];
            $sender=$row["sender"];
            echo '<td>'. $carPoolRow["from"] . '=>'. $carPoolRow["to"] . '</td>';   
            echo '<td>Request Status</td>';
            if($status=="Approved"){
                echo '<td>Approved, Enjoy the Ride</td>';
            }
            else if($status=="Declined"){
                echo '<td>Declined, :-(</td>';
            }
            else{
                echo 'alert("Some crap piece of shit")';
            }

        }
        else if($type=="4"){
            $query = 'SELECT * from offers WHERE id="'.$row["cid"].'";';
            $result1 = mysql_query($query) or die("error!!");
            $carPoolRow = mysql_fetch_array($result1); 
            $status = $row["status"];
            $cid = $row["cid"];
            $slno = $row["slno"];
            $sender=$row["sender"];
            echo '<td>'. $carPoolRow["from"] . '=>'. $carPoolRow["to"] . '</td>';   
            echo '<td>Request Status</td>';
            echo '<td>Still pending with the rider, Please Come again later</td>';

        }   
 }   
?>
    </tbody>
    </table>
        
</div>
		<div class="span1"></div>
</div>

</div>
<div id="push"></div>
    </div> <!-- /wrap -->
    <div id="footer">
      <div class="container">
        <p class="muted credit">Built with love by <a href="about.php">@sushant @ashish @nilesh.</a></p>
      </div>
    </div>

    <!-- javascript files
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="http://code.jquery.com/jquery-latest.js"></script>
    <script src="js/bootstrap.min.js"></script>
        <script>
         $(".dropdown-menu li a").click(function(){
                var selText = $(this).text();
                $('#fartDropDown').html(selText);
        
         });
        
        function RateRequest(slno){ 
            $rating =    $('#fartDropDown').html();    
            $.post("updateDBNotifications.php", { type: "2", serialNo: slno, rating: $rating })
            .done(function(data) {
            //alert("Data Loaded: " + data);
             location.reload();
            }); // alert($rating);

        }




       function ApproveRequest(slno,stat){
             if(stat=="0"){
           
            $.post("updateDBNotifications.php", { type: "1", serialNo: slno, stat: "Declined" })
            .done(function(data) {
            //alert("Data Loaded: " + data);
             location.reload();
            });     
            } 
            else if(stat=="1"){
              $.post("updateDBNotifications.php", { type: "1", serialNo: slno, stat: "Approved" })
            .done(function(data) {
            //alert("Data Loaded: " + data);
             location.reload();
            });     
            }
            else{
                alert("Random error , stat doesnot match");
            }
    }

      $('.dropdown-toggle').dropdown();
    </script>    
   </body></html> 
</body>
</html>
