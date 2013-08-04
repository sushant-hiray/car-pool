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
include('menu.php');
?>
	<div class="row-fluid" id="main-content">
		<div class="span1"></div>
		<div class="span5"> 
			<h2 align="center"><small>Search for a preferred ride</small></h2>
			<hr>
      		<br/>
			<form method="post" action="getride.php">
          <?php if(isset($_POST['action'])){?>
           <input type="hidden" name="action" value="search" />
       		 <input type="text" name="from" value="<?php echo $_POST['from']?>" data-provide="typeahead" class="typeahead" placeholder="Source" required/><br/>
    	    	<input type="text" name="to" value="<?php echo $_POST['to']?>" data-provide="typeahead" class="typeahead" placeholder="Destination"  required/><br/>

    	    	Time Range for hoping in your ride: <br/>
    	    	Start Time:
	      			<div id="uptimepicker" class="input-append date">
				      <input type="text" value="<?php echo $_POST['uptime']?>" name="uptime"></input>
				      <span class="add-on">
				        <i data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
				      </span>
				    </div> <br/>
            End Time:
              <div id="downtimepicker" class="input-append date">
              <input type="text" value="<?php echo $_POST['downtime']?>" name="downtime"></input>
              <span class="add-on">
                <i data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
              </span>
            </div>
				   <br/>
    	    	<label class="checkbox inline">
    				<input type="checkbox" id="inlineCheckbox1" name="taxi" value="Taxi"> Taxi
   				 </label>
   				 <label class="checkbox inline">
   					 <input type="checkbox" id="inlineCheckbox2" name="car" value="Car"> Car
   				 </label>
   				 <label class="checkbox inline">
    				<input type="checkbox" id="inlineCheckbox3" name="auto" value="Auto"> Auto Rickshaw
   				 </label>
   				 <br/>
   				 <br/>
    			<input class="btn" type="submit" name="submit" value="Search"/>
      		</form>
      <?php } else{ ?>
      <input type="hidden" name="action" value="search" />
           <input type="text" name="from"  data-provide="typeahead" class="typeahead" placeholder="Source" required/><br/>
            <input type="text" name="to"  data-provide="typeahead" class="typeahead" placeholder="Destination"  required/><br/>

            Time Range for hoping in your ride: <br/>
            Start Time:
              <div id="uptimepicker" class="input-append date">
              <input type="text"  name="uptime"></input>
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
            <input type="checkbox" id="inlineCheckbox1" name="taxi" value="Taxi"> Taxi
           </label>
           <label class="checkbox inline">
             <input type="checkbox" id="inlineCheckbox2" name="car" value="Car"> Car
           </label>
           <label class="checkbox inline">
            <input type="checkbox" id="inlineCheckbox3" name="auto" value="Auto"> Auto Rickshaw
           </label>
           <br/>
           <br/>
          <input class="btn" type="submit" name="submit" value="Search"/>
          </form>

          <?php } ?>

		</div>
		<div class="span5">
      <h2 align="center"><small>Search Results</small></h2> <hr/>
      <?php if(isset($_POST['action'])){
          $from=$_POST['from'];
          $to=$_POST['to'];
          $uptime=$_POST['uptime'];
          $downtime=$_POST['downtime'];
          $taxi=0;$car=0;$auto=0;
          if(isset($_POST['taxi'])) $taxi=1;
          if(isset($_POST['car'])) $car=1;
          if(isset($_POST['auto'])) $auto=1;

          $query="SELECT r1.cid from route r1 INNER JOIN route r2 ON r1.place='".$from."' AND r2.place='".$to."' AND r1.serialno < r2.serialno AND r1.cid=r2.cid";
          $result=mysql_query($query) or die(mysql_error());

          if(mysql_num_rows($result)==0){
                echo("<p align='center'>No Upcoming car pools match your request :( </p>\n");
              }


          else {
            
            echo '<table id="upcominglist" class="table table-hover">
                <thead><tr><th>Id</th> <th>Vehicle Type</th> <th> From </th> <th> To </th> <th> Starting Time</th><th>Connection Type</th></tr></thead>
                <tbody>';

                $query="SELECT r1.cid from route r1 INNER JOIN route r2 ON r1.place='".$from."' AND r2.place='".$to."' AND r1.serialno < r2.serialno AND r1.cid=r2.cid";
          $result=mysql_query($query) or die(mysql_error());
        
           while($row = mysql_fetch_array($result)){
              $query2="SELECT `id`,`vehicle`,`from`,`to`,`uptime` from offers WHERE id='".$row['cid']."' AND `uptime` >='".$_POST['uptime']."' AND `uptime` <='".$_POST['downtime']."'";
              $res=mysql_query($query2) or die(mysql_error());
              if(mysql_num_rows($res)==0){
              }
              else{
                $result2=mysql_fetch_array($res);
              
              echo "<tr><td>".$result2['id']."</td><td>".$result2['vehicle']."</td><td>".$result2['from']."</td><td>".$result2['to']."</td><td>".$result2['uptime']."</td>";
              if($from==$result2['from'] && $to==$result2['to']){echo "<td>Direct</td></tr>";}
                else{echo "<td>Via</td></tr>";}
             }
          }


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


      $('td:nth-child(1),th:nth-child(1)').hide();
      $('#upcominglist').find('tr').click( function(){
  var row = $(this).find('td:first').text();
  window.location.href = "ride.php?id="+row;
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