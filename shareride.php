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
			<h2 align="center"><small>Share your ride</small></h2>
			<hr>
      		<br/>
			<form method="post" action="update.php" >
				<input type="hidden" name="action" value="shareride" />
       		    <input type="text" name="from" data-provide="typeahead" class="typeahead" placeholder="Source" required/><br/>
    	    	<input type="text" name="to" data-provide="typeahead" class="typeahead" placeholder="Destination"  required/><br/>
    	    	Start Time of your ride:
	      			<div id="uptimepicker" class="input-append date">
				      <input type="text" name="uptime"></input>
				      <span class="add-on">
				        <i data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
				      </span>
				    </div> <br/>
            	Mode of Travel: <br/> <label class="radio inline">
					<input type="radio" name="vehicle" value="car">Car
				</label>
				<label class="radio inline">
					<input type="radio" name="vehicle" value="taxi">Taxi
				</label>
		 		<label class="radio inline">
					<input type="radio" name="vehicle" value="auto">Auto Rickshaw
				</label>
		 		 <br/> <br/>
		 		 <div class="input-append">
					<input type="text" name="time" placeholder="Approx duration of travel" required> </input>
					<span class="add-on">Hrs</span>
				</div>
   				<br/>
   				<input type="text" type="number" name="number" placeholder="Number of vacancies"></input> <br/>
   				<div class="input-prepend">
					<span class="add-on">Rs</span>
					 <input class="span10" id="prependedInput" type="number" name="cost" placeholder="Cost per person" required>
				</div><br/>
   				<br/>
   				<textarea width="500px" rows="3" name="description" placeholder="Any further details which might help people select your ride"></textarea> <br/>
    			<input class="btn" type="submit" name="submit" value="Share"/>
      		</form>
      
		</div>
		<div class="span5">
			<h2 align="center"><small>Latest Car Pools</small></h2>
			<?php
						$today = date("Y-m-d H:i:s");
						$query="SELECT `from` , `to` , `uptime` , `vehicle` from offers where uptime > '".$today."'";
						$result = mysql_query($query);
						if(mysql_num_rows($result)==0){
		          	    	echo("<p align='center'>No Upcoming car pools are scheduled currently :( </p>\n");
		          	  
								
							}
		          	  	else {
							echo '<table id="upcominglist" class="table table-hover">
								<thead><tr> <th>Vehicle Type</th> <th> From </th> <th> To </th> <th>Starting Time</th></tr></thead>
								<tbody>';
									
							while($row = mysql_fetch_array($result)) {
								echo "<tr><td>".$row['vehicle']."</td><td>".$row['from']."</td><td>".$row['to']."</td><td>".$row['uptime']."</td></tr>";
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
    <?php 
    $query = "SELECT city_name from cities";
	$result = mysql_query($query);
	echo "<script>var city = new Array();";
                while($row = mysql_fetch_array($result)){
                    //echo '<option value="' . $row["city_name"]. '"> ' . $row["city_name"].'</option>';
                    echo 'city.push("' . $row["city_name"]. '");';
    }
    echo '$(".typeahead").typeahead({source : city})';
    echo "</script>"

    ?>
</body></html>