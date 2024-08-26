<script>siteUrl = '<?php echo site_url();?>';</script>
<!-- PAGE TITLE -->
<!--<div class="page-title">                    
    <h2><a  href="<?php echo site_url();?>"><span class="fa fa-arrow-circle-o-left"></span></a> Dashboard</h2>
</div>-->
<!-- END PAGE TITLE -->
<style>
#dashboard tr:hover {
	background-color: #ccc;
}

#dashboard td:hover {
	cursor: pointer;
}
</style>
<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">
	<form class="form-horizontal" action="" method="POST" id="dashboard_form">
		<!-- START MANY COLUMNS  -->
		<div class="row">
			<div class="col-md-12">
				<!-- 
        <div class="survepanel clearfix">
        	<div class="col-md-2">
        		<div class="tile tile-danger">
         			<p>Visits</p> 7            
        		</div>
            </div>
             
            <div class="col-md-2">
             	<div class="tile tile-success">
            		<p>DeltaViolations</p>   3                 
              	</div>
            </div>
            
            <div class="col-md-2">
            	<div class="tile tile-warning">
               		<p>Kms</p>  1458                
              	</div>
            </div>
            
            <div class="col-md-2">
            	<div class="tile tile-info">
             		<p>SiteSurveys</p> 25                
              	</div>
            </div>
            
            <div class="col-md-2">
            	<div class="tile tile-default">
              		<p>Guard Attendance</p>950                 
              	</div>
            </div>

            <div class="col-md-2">
            	<div class="tile tile-primary">
              		<p>Guards Late</p>70                
              	</div>
            </div>	
        </div>  
        -->

				<div class="panel panel-default">
							<div id="mapdiv" class="mappanel clearfix" style="height: 300px;"></div>
				
				</div>
			</div>
		</div>
		<!-- END MANY COLUMNS  -->

	</form>
	<!-- END PAGE CONTENT WRAPPER -->
</div>




<script src="//maps.googleapis.com/maps/api/js?v=3"></script>
<script type="text/javascript">
var location_data = [];
<?php if(!empty($stepResponse)){
    for($i=0;$i<count($stepResponse);$i++){
?>
    var obj = new google.maps.LatLng('<?php  echo $stepResponse[$i]->end_location->lat; ?>', '<?php  echo $stepResponse[$i]->end_location->lng; ?>');
    location_data.push(obj);
        
        
        
        
        
<?php    }
} ?>
function initMap() {
  var map = new google.maps.Map(document.getElementById('mapdiv'), {
    zoom: 3,
    center: {lat: 0, lng: 0},
    mapTypeId: google.maps.MapTypeId.ROADMAP
  });
console.log(location_data);

  var flightPlanCoordinates = [
    {lat: 37.772, lng: -122.214},
    {lat: 21.291, lng: -157.821},
    {lat: -18.142, lng: 178.431},
    {lat: -27.467, lng: 153.027}
  ];
  var flightPath = new google.maps.Polyline({
    path: location_data,
    geodesic: true,
    strokeColor: '#FF0000',
    strokeOpacity: 1.0,
    strokeWeight: 2
  });
  // Marker for start point 
  createMarker(dirdis.getMap(), legs[0].start_location, '', "Start Point<br>" + legs[0].start_address, 'A');
  // marker for End Point 
  createMarker(dirdis.getMap(), legs[legs.length - 1].end_location, '', "End Point <br>" + legs[legs.length - 1].end_address, 'B');
                                
  flightPath.setMap(map);
}

function createMarker(map, latlng, label, html, color) {
    var contentString = '<b>' + label + '</b><br>' + html;
    var marker = new google.maps.Marker({
        position: latlng,
        map: map,
        shadow: iconShadow,
        icon: getMarkerImage(color),
        shape: iconShape,
        title: label,
        zIndex: Math.round(latlng.lat() * -100000) << 5
    });
    marker.myname = label;

    google.maps.event.addListener(marker, 'click', function() {
        infowindow.setContent(contentString);
        infowindow.open(map, marker);
    });

    return marker;
}

function getMarkerImage(color){
    if(color == 'green'){
        return siteimage;
    }
}
google.maps.event.addDomListener(window, 'load', initMap);
</script>
