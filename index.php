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
        if(isset($_GET['changed']))
          echo("<div class=\"alert alert-info\">\nAccount details changed successfully!\n</div>");
        else if(isset($_GET['nerror']))
          echo("<div class=\"alert alert-error\">\nPlease enter all the details asked before you can continue!\n</div>");
      ?>

<?php
include('menu.php');
?>
	<div class="row-fluid" id="main-content">
		<div class="span2"></div>
		<div class="span5"> 
			<h2 align="center"><small>Search for a ride</small></h2>
			<hr>
      		<br/>
			<form id="search">
       		    <input type="text" name="from" placeholder="Source" required/><br/>
    	    	<input type="text" name="to" placeholder="Destination"  required/><br/>
    	    	Time Range for hoping in your ride: <br/>
    	    	Start Time:
	      			<div id="uptimepicker" class="input-append date">
				      <input type="text" name="uptime"></input>
				      <span class="add-on">
				        <i data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
				      </span>
				    </div> <br/>
            End Time:
              <div id="downtimepicker" class="input-append date">
              <input type="text" name="downtime"></input>
              <span class="add-on">
                <i data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
              </span>
            </div>
				   <br/>
    	    	<label class="checkbox inline">
    				<input type="checkbox" id="inlineCheckbox1" value="Taxi"> Taxi
   				 </label>
   				 <label class="checkbox inline">
   					 <input type="checkbox" id="inlineCheckbox2" value="Car"> Car
   				 </label>
   				 <label class="checkbox inline">
    				<input type="checkbox" id="inlineCheckbox3" value="Auto"> Auto Rickshaw
   				 </label>
   				 <br/>
   				 <br/>
    			<input class="btn" type="submit" name="submit" value="Search"/>
      		</form>
      
		</div>
		<div class="span5">
			<h2 align="center"><small>Latest Car Pools</small></h2>
			<?php
						$today = date("Y-m-d H:i:s");
						$query="SELECT `from` , `to` , `uptime` , `vehicle`, `downtime` from offers where uptime > '".$today."'";
						$result = mysql_query($query);
						if(mysql_num_rows($result)==0){
		          	    	echo("<p align='center'>No Upcoming car pools are scheduled currently :( </p>\n");
		          	  
								
							}
		          	  	else {
							echo '<table id="upcominglist" class="table table-hover">
								<thead><tr> <th>Vehicle Type</th> <th> From </th> <th> To </th> <th> Time Range </th></tr></thead>
								<tbody>';
									
							while($row = mysql_fetch_array($result)) {
								echo "<tr><td>".$row['vehicle']."</td><td>".$row['from']."</td><td>".$row['to']."</td><td>".$row['uptime']."-".$row['downtime']."</td></tr>";
							}
						}
					?>
					</tbody>
			</table>
		</div>
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
    <script type="text/javascript" src="js/datetimepicker.js"></script>
    <script type="text/javascript">
      $('#uptimepicker').datetimepicker({
        format: 'yyyy-MM-dd hh:mm:ss',
      });
      $('#downtimepicker').datetimepicker({
        format: 'yyyy-MM-dd hh:mm:ss',
      });
    </script>
</body></html>