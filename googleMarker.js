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
         $query = "SELECT * from cities where city_name = 'Mumbai' or city_name='Delhi'";
		 $result = mysql_query($query);
?>
<?php 
                while($row = mysql_fetch_array($result)){
                    //echo '<option value="' . $row["city_name"]. '"> ' . $row["city_name"].'</option>';
                    
                    echo ' var name ="'. $row["city_name"].'"; var address = ""; var type = "";';
                    echo 'var point = new google.maps.LatLng(parseFloat("'.$row["latitude"].'"),parseFloat("'.$row["longitude"].'"));';
                    echo 'var html = "<b>" + name + "</b> " + address;';
?>

                    var icon = customIcons[type] || {};
                    var marker = new google.maps.Marker({
                        map: map,
                        position: point,
                        icon: icon.icon,
                        shadow: icon.shadow
                     });
                    bindInfoWindow(marker, map, infoWindow, html);
                    waypts =[];
                     waypts.push({
                         location:"Kathmandu, Central Region, Nepal",
                         stopover:true
                     });
                    
                     waypts.push({
                         location:"Ahmedabad, Gujrat",
                         stopover:true
                     });
        
                    calcRoute("Mumbai", "Delhi", waypts);
 <?php    
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


  </script>

