<?php
/*
 * The landing page that lists all the problem
 */
	require_once('functions.php');
	if(!loggedin())
		header("Location: login.php");
	else
		connectdb();

?>

<?php
/*
 * Header for user pages
 */
?>

<!DOCTYPE html>
<html lang="en"><head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <title>Car Pool </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- styles -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/common.css" rel="stylesheet">
    <link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/css/bootstrap-combined.no-icons.min.css" rel="stylesheet">
    <link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" media="screen"
     href="css/datetimepicker.css">

    <!-- fav and touch icons -->
    <link rel="shortcut icon" href="http://twitter.github.com/bootstrap/assets/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="http://twitter.github.com/bootstrap/assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="http://twitter.github.com/bootstrap/assets/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="http://twitter.github.com/bootstrap/assets/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="http://twitter.github.com/bootstrap/assets/ico/apple-touch-icon-57-precomposed.png">
  </head>

  <body onload="load()">
<!-- Part 1: Wrap all page content here -->
    <div id="wrap">

      <!-- Fixed navbar -->
      <div class="container-fluid">
        <header class="row-fluid">
          
          <div class="span2">
            <img src="img/logo.jpg" width="120" class="img-polaroid">
          </div>
          
          <div class="span10">
              <div class="row-fluid">
                <div class="span10">
                  <h3 align="center">Car Pooling</h3>
                </div>
                <div class="span2">
                    <a class="btn btn-info" href="index.php" role="button">CarPool Home</a>
                </div>
              </div>
        </div> 
        </header> 
      </div> 

      <!-- Begin page content -->

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
			<h2 align="center"><small>Ride Information</small></h2>
			<hr>
      <br/>
      <?php 
      if(isset($_GET['id'])){
        $id=$_GET['id'];
        $query="SELECT * FROM offers WHERE id=".$id;
        $result=mysql_query($query);
        if(mysql_num_rows($result)==0){
            echo("<p align='center'>Looks like you have entered an URL you shouldn't have!Please go back to previous page</p>\n");
          }
        else{
          $row=mysql_fetch_array($result);
          $uid=$row['uid'];
          $from=$row['from'];
          $to=$row['to'];
          $uptime=$row['uptime'];
          $vacancy=$row['people'];
          $price=$row['price'];
          $ferry=$row['vehicle'];
          $desc=$row['description'];
          $cid=$row['id'];
          
      ?>
<form method="post" action="addCarShare.php">
  Rider: <a href="<?php echo "profile.php?id=".$uid;?>" > <?php echo getName($uid); ?></a> <br/>
  Starting Time of Ride: <?php echo $uptime ?> <br/>
  Rider's Source: <?php echo $from; ?> <br/>
  Rider's Destination: <?php echo $to; ?> <br/>
  Available vacancy: <?php echo $vacancy; ?> <br/>
  Price per person: INR <?php echo $price; ?> <br/>
  Type of vehicle: <?php echo $ferry; ?> <br/>
  Brief Description of the car pool: <?php echo $desc; ?> <br/>
  <br/>
  <?php 
  $time = date("Y-m-d H:i:s");
  if($uptime > $time){ ?><h2> <small>Request for this car</small></h2>
    <input type="hidden" id="formfrom" name="from" />
    <input type="hidden" id="formto" name="to" />
    <input type="hidden" name="uid" value=<?php echo getUserid(); ?> />
    <input type="hidden" name="cid" value=<?php echo $cid; ?> />
      <div class="btn-group">
                <button id="from" class="btn dropdown-toggle" data-toggle="dropdown">From <span class="caret"></span></button>
                <ul class="dropdown-menu from">
                  <?php

                  $q="SELECT place from route WHERE cid=".$cid;
                  $re=mysql_query($q) or dir(mysql_error());
                  while($row=mysql_fetch_array($re)){
                    echo "<li><a href='#'>".$row['place']."</a></li>";
                  }

                   ?>
                </ul>
      </div><!-- /btn-group -->
      <div class="btn-group">
                <button id="to" class="btn dropdown-toggle" data-toggle="dropdown">To <span class="caret"></span></button>
                <ul class="dropdown-menu to">
                   <?php

                  $q="SELECT place from route WHERE cid=".$cid;
                  $re=mysql_query($q) or dir(mysql_error());
                  while($row=mysql_fetch_array($re)){
                    echo "<li><a href='#'>".$row['place']."</a></li>";
                  }

                   ?>
                </ul>
      </div><!-- /btn-group --> <br/>
      Number of seats to be booked: <select>

      <?php 
      
      for($i=1;$i<=$vacancy;$i++){
        echo "<option>".$i."</option>";
      }

      ?>
    </select>
    <input class="btn" type="submit" name="submit" value="Request"/>
</form>
          <?php } 
        
        else{
          echo"<h3><small> The carpool has been archived, you can get to know more about this carpool by contacting the rider </small></p>";
        }
        
      }
      }
      else{
echo("<p align='center'>Looks like you have entered an URL you shouldn't have!Please go back to previous page</p>\n");
      }?>





      
		</div>
		<div class="span5" id="map" style="width: 400px; height: 400px">
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
    <script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=false"></script>
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

    <?php
    $p="SELECT "


    ?>

    <script type="text/javascript">
    //<![CDATA[
    $(".from li a").click(function(){

              $("#from").html($(this).text()+"&nbsp<span class='caret'></span>");
              $("#formfrom").val($(this).text());


           });

    $(".to li a").click(function(){

              $("#to").html($(this).text()+"&nbsp<span class='caret'></span>");
              $("#formto").val($(this).text());


           });

    var customIcons = {
      restaurant: {
        icon: 'http://labs.google.com/ridefinder/images/mm_20_blue.png',
        shadow: 'http://labs.google.com/ridefinder/images/mm_20_shadow.png'
      },
      bar: {
        icon: 'http://labs.google.com/ridefinder/images/mm_20_red.png',
        shadow: 'http://labs.google.com/ridefinder/images/mm_20_shadow.png'
      }
    };
    
    var dummy="hello";
    var directionDisplay;
    var directionsService = new google.maps.DirectionsService();

    function load() {
      var map = new google.maps.Map(document.getElementById("map"), {
        center: new google.maps.LatLng(23.6145, 72.3418),
        zoom: 6,
        mapTypeId: 'roadmap'
      });
      directionsDisplay = new google.maps.DirectionsRenderer();
      directionsDisplay.setMap(map);
      var infoWindow = new google.maps.InfoWindow;

      <?php
            if(isset($_GET['id'])){
                echo "var RouteData=new Array();";
                  $q="SELECT place from route WHERE cid=".$_GET['id'];
                  $re=mysql_query($q) or dir(mysql_error());
                  while($row=mysql_fetch_array($re)){

                  

                    echo 'RouteData.push({location:"' . $row["place"]. '",stopover:true});';
                  }

                  $w="SELECT * FROM offers WHERE id=".$_GET['id'];
                $r=mysql_query($w);
                $row=mysql_fetch_array($r);
          
          $from=$row['from'];
          $to=$row['to'];
          echo "calcRoute('".$from."','".$to."',RouteData);";

                }

                   ?>
    }

    function calcRoute(start, end, waypts) {
        var request = {
            origin:start, 
            destination:end,
            waypoints: waypts,
            optimizeWaypoints: true,
            travelMode: google.maps.DirectionsTravelMode.DRIVING
        };
        directionsService.route(request, function(response, status) {
          if (status == google.maps.DirectionsStatus.OK) {
            directionsDisplay.setDirections(response);
          }
        });
  }

    function bindInfoWindow(marker, map, infoWindow, html) {
      google.maps.event.addListener(marker, 'click', function() {
        infoWindow.setContent(html);
        infoWindow.open(map, marker);
      });
    }

    function downloadUrl(url, callback) {
      var request = window.ActiveXObject ?
          new ActiveXObject('Microsoft.XMLHTTP') :
          new XMLHttpRequest;

      request.onreadystatechange = function() {
        if (request.readyState == 4) {
          request.onreadystatechange = doNothing;
          callback(request, request.status);
        }
      };

      request.open('GET', url, true);
      request.send(null);
    }

    function doNothing() {}

    			i = $('.inputs').size();	
					
				$('#add').click(function() {
					var nameName = "dynamic" + i;
						$('<div><input type="text"data-provide="typeahead"   class="field" placeholder="Hop " +"' +i+'" name="'+ nameName+'"   value="" /></div>').fadeIn('slow').appendTo('.inputs');
                        
                        $(".field").typeahead({source : city});
                        i++;
						var fields= Number($("#total").val())+Number(1);
						$("#total").val(fields);
                        
						
				});
				
				$('#remove').click(function() {
				if(i > 1) {
						$('.field:last').remove();
						var fields= Number($("#total").val())-Number(1);
						i--;
				}
				});
				
				$('#reset').click(function() {
				while(i >= 1) {
						$('.field:last').remove();
						var fields= Number($("#total").val())-Number(1);
						i--;
				}
				});
				

        function RefreshMap(){
                waypts =[];
                var start = $('#From').val();
                var end = $('#To').val();
                divs = $('.inputs');
                //alert(start);
                $('.field').each(function(){
                    waypts.push({
                    location:this.value,
                     stopover:true
                     });
              

                });
                    
                calcRoute(start, end, waypts);
 
        }

  </script>
</body></html>