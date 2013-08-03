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
			<h2 align="center"><small>Share your ride</small></h2>
			<hr>
      		<br/>
			<form method="post" action="update.php" >
				<input type="hidden" name="action" value="shareride" />
				<input type="hidden" id="total" name="totalRequests" value=0 />
       		    <input type="text" id="From" name="from" data-provide="typeahead" class="typeahead" placeholder="Source" required/><br/>
       		    <div class="inputs">
                     </div>
    	    	<input type="text" id="To" name="to" data-provide="typeahead" class="typeahead" placeholder="Destination"  required/><br/>
    	    	<div class="btn-group">
                    <button class="btn" id ="add">Add Via Routes</button>
                    <button class="btn" id="remove">Delete Via</button>
                    <button class="btn" id="reset">Reset Via </button>
                    <button class="btn" id="CheckOnMap" onclick="RefreshMap()">Refresh Map</button>
         </div>
		
		<br/><br/>
    	    	Start Time of your ride:
	      			<div id="uptimepicker" class="input-append date">
				      <input type="text" name="uptime" required></input>
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

    <script type="text/javascript">
    //<![CDATA[

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