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
		<div class="span3"></div>
		<div class="span6"> 
			<?php 
			$query="SELECT * from users ORDER BY credits DESC";
			$result=mysql_query($query);
			echo '<table id="userlist" class="table table-hover">
								<thead><tr> <th>Id </th><th>Name</th> <th> Carbon Credits </th></thead>
								<tbody>';
			while($row=mysql_fetch_array($result)){
				echo '<tr><td>'.$row['uid'].'<td>'.$row['name'].'</td><td>'.$row['credits'].'</td></tr>';
			}

			?>
			</tbody>
			</table>
		</div>
		<div class="span3"></div>
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
    $('td:nth-child(1),th:nth-child(1)').hide();
      $('#userlist').find('tr').click( function(){
  var row = $(this).find('td:first').text();
  window.location.href = "profile.php?uid="+row;
});
      </script>
</body></html>