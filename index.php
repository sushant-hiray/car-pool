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
			<br/>
			<br/>
			<p align="center"> Following are the ongoing events. You can enter them to solve the problems: </p>
			<ul class="nav nav-list">
        	<li class="nav-header">ONGOING EVENTS</li>
      </ul>
      <br/>
      <hr>
			<p align="center"> Following are the problems which are available to solve: </p>
			<ul class="nav nav-list">
        <li class="nav-header">AVAILABLE PROBLEMS</li>
 
      </ul>
      <br/>
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
<?php
include('footer.php');
?>