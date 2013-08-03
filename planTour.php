    <!DOCTYPE html>
    <html>
    <head>
    <title>Bootstrap 101 Template</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
    <script src="http://code.jquery.com/jquery.js"></script>
	<script src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=false"></script>
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
 <?php
	     require_once('functions.php');
		 connectdb();
        /* $query = "SELECT * from cities where city_name = 'Mumbai' or city_name='Delhi'";
		 $result = mysql_query($query);
        */
?>
/*
<?php 
                while($row = mysql_fetch_array($result)){
                    //echo '<option value="' . $row["city_name"]. '"> ' . $row["city_name"].'</option>';
                    
                    echo ' var name ="'. $row["city_name"].'"; var address = ""; var type = "";';
                    echo 'var point = new google.maps.LatLng(parseFloat("'.$row["latitude"].'"),parseFloat("'.$row["longitude"].'"));';
                    echo 'var html = "<b>" + name + "</b> " + address;';
    
?>
<?php    
                }
?>
 */   
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


  </script>

    </head>
    <body onload="load()">
    <div class="container-fluid">
        <div class="row-fluid">
            <div class="span6">
                <h1>Plan a Tour!</h1>

                <form method="post" action="save_comment.php">
            <?php
                require_once('functions.php');
                    connectdb();
                    $query = "SELECT city_name from cities";
                    $result = mysql_query($query);
            ?>
                                
    <?php 
                    echo '<input type="text" name="From" data-provide="typeahead" placeholder="Origin" id="From" class="typeahead">';
                    echo "<script>var city = new Array();";
                    while($row = mysql_fetch_array($result)){
                        //echo '<option value="' . $row["city_name"]. '"> ' . $row["city_name"].'</option>';
                        echo 'city.push("' . $row["city_name"]. '");';
                    }
                    echo "</script>"
            ?> 

                        <div class="inputs">
                     </div>
                    <div><input type="text" data-provide="typeahead" class="typeahead" name="To"  id="To" placeholder="Destination" value=""/></div>
                         <input type="hidden" id="total" name="totalRequests" value=1 >
                       <input class="btn" type="submit" name="SUBMIT" value="Submit">
                        
                  </form>
                    <div class="btn-group">
                    <button class="btn" id ="add">Add Hop</button>
                    <button class="btn" id="remove">Delete Hop</button>
                    <button class="btn" id="reset">Reset Hop(Sorry Rahega!)</button>
                    <button class="btn" id="CheckOnMap" onclick="RefreshMap()">Refresh</button>
                    </div>
            </div>
            <div class="span6">
                <div id="map" style="width: 600px; height: 400px"></div>
            </div>
        </div>
    </div>


     <script>
		$(document).ready(function(){
	            $(".typeahead").typeahead({source : city});	
	            i = $('.inputs').size();	
				var nameName = "dyanmic" + i;	
				$('#add').click(function() {
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
		</body>
    </html>
