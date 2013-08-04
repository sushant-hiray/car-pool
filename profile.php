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
		<div class="span5"></div>
		<div class="span5">
			<?php if(isset($_GET['id'])){
				$query="SELECT * from users where uid=".$_GET['id'];
				$res=mysql_query($query);
				$fetch=mysql_fetch_array($res);
				$name=$fetch['name'];
				$email=$fetch['email'];
				$gender=$fetch['gender'];
				$contact=$fetch['contactno'];
				$desc=$fetch['description'];
				$credits=$fetch['credits'];
				$id=$_GET['id'];
				if($gender=="M")$sex="Male";
				else $sex="Female";

				$badge="Newbie in town";
				$rank="SELECT uid from users ORDER BY credits DESC";
				$resul=mysql_query($rank);
				$num=mysql_num_rows($resul);
				$top=$num/3;
				$middle=$top * 2;
				$i=1;
				while($row=mysql_fetch_array($resul)){
					if($row['uid']==$id){
						if($i<=$top){
							$badge="Trusted Car Pooler";
						}
						else if($i<=$middle){
							$badge="Budding Car Pooler";
						}
						else{
							$badge="Newbie in town";
						}
					}
					$i++;
				}
				echo "<p>Name: &nbsp; <strong>".$name." </strong></p>";
				echo "<p>Email Id: &nbsp; <strong>".$email."</strong></p>";
				echo "<p>Gender: &nbsp; <strong>".$sex." </strong></p>";
				echo "<p>Contact: &nbsp; <strong>".$contact."</strong></p>";
				echo "<p>Description: &nbsp; <strong>".$desc."</strong></p>";
				echo "<p>Carbon Credits: &nbsp;<strong>".$credits." </strong></p>"; 
				echo "<p>Badge:<span class='label label-success'> &nbsp;".$badge."</span></p>";

			}
			else{
				$email=$_SESSION['username'];
				$query="SELECT * from users where email='".$email."'";
				$uid=getUserid();
				$res=mysql_query($query);
				$fetch=mysql_fetch_array($res);
				$name=$fetch['name'];
				$email=$fetch['email'];
				$gender=$fetch['gender'];
				$contact=$fetch['contactno'];
				$desc=$fetch['description'];
				$credits=$fetch['credits'];
				$badge="Newbie in town";
				$rank="SELECT * from users ORDER BY credits DESC";
				$resul=mysql_query($rank);
				$num=mysql_num_rows($resul);
				$top=$num/3;
				$middle=$top * 2;
				$i=1;
				while($row=mysql_fetch_array($resul)){
					if($row['uid']==$uid){
						if($i<=$top){
							$badge="Trusted Car Pooler";
						}
						else if($i<=$middle){
							$badge="Budding Car Pooler";
						}
						else{
							$badge="Newbie in town";
						}
					}
					$i++;
				}
				if($gender=="M")$sex="Male";
				else $sex="Female";
				echo "<p>Name: &nbsp; <strong>".$name." </strong></p>";
				echo "<p>Email Id: &nbsp; <strong>".$email."</strong></p>";
				echo "<p>Gender: &nbsp; <strong>".$sex." </strong></p>";
				echo "<p>Contact: &nbsp; <strong>".$contact."</strong></p>";
				echo "<p>Description: &nbsp; <strong>".$desc."</strong></p>";
				echo "<p>Carbon Credits: &nbsp;<strong>".$credits." </strong></p>"; 
				echo "<p>Badge:<span class='label label-success'> &nbsp;".$badge."</span></p>";



			}


			?>
			

		</div>
		<div class="span2"></div>
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
   </body></html> 
