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
					<div class="panel-heading">
						<div class="searchpanel">
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
								<tr>
									<!-- <td width="25%">
                                    <select class="form-control select" id="company_name" name="company_name" onchange="getRegionList('<?php echo site_url(); ?>');" >
                                     <option value="" selected="selected">Select Client</option>  
                                     <?php if(count($getAllcompanyDropdown)>0){ ?>
                                         <?php for($i=0;$i<count($getAllcompanyDropdown);$i++){?>
                                            <option value="<?php echo $getAllcompanyDropdown[$i]->company_id; ?>" <?php if($getAllcompanyDropdown[$i]->company_id == $company_id){ echo 'selected="selected"';} ?> ><?php echo $getAllcompanyDropdown[$i]->company_name; ?></option>

                                         <?php } ?>
                                     <?php } ?>
                                    </select>
                                </td> -->
                                                                    <?php if(in_array($this->user->role_code, array('cadmin','cuser','sadmin','RM'))){ ?>
									<td width="15%"><select class="form-control select"
										id="region_area" name="region_id"
										onchange="getBranchList('<?php echo site_url(); ?>');">
											<option value="" selected="selected">Select Region</option>
											<?php if(count($getAllRegionDropdown)>0){ ?>
											<?php for($i=0;$i<count($getAllRegionDropdown);$i++){?>
											<option
												value="<?php echo $getAllRegionDropdown[$i]->region_id; ?>"
												<?php if($getAllRegionDropdown[$i]->region_id == $region_id){ echo 'selected="selected"';} ?>>
												<?php echo $getAllRegionDropdown[$i]->region_name; ?>
											</option>
											<?php } ?>
											<?php } ?>
									</select>
									</td>
                                             <?php }  ?>
                                             <?php if(in_array($this->user->role_code, array('cadmin','cuser','sadmin','RM','BM','FO'))){ ?>
									<td width="15%"><select class="form-control select"
										id="branch_id" name="branch_id"
										onchange="getSiteList('<?php echo site_url(); ?>');">
											<option value="" selected="selected">Select Branch</option>
											<?php if(count($getAllBranchDropdown)>0){ ?>
											<?php for($i=0;$i<count($getAllBranchDropdown);$i++){?>
											<option
												value="<?php echo $getAllBranchDropdown[$i]->branch_id; ?>"
												<?php if($getAllBranchDropdown[$i]->branch_id == $branch_id){ echo 'selected="selected"';} ?>>
												<?php echo $getAllBranchDropdown[$i]->branch_name; ?>
											</option>
											<?php } ?>
											<?php } ?>
									</select>
									</td>
                                                                        <?php }  ?>
									<td width="15%"><select class="form-control select"
										id="site_id" name="site_id"
										onchange="getFieldOfiicer('<?php echo site_url(); ?>');">
											<option value="" selected="selected">Select Site</option>
											<?php if(count($getAllSiteDropdown)>0){ ?>
											<?php for($i=0;$i<count($getAllSiteDropdown);$i++){?>
											<option
												value="<?php echo $getAllSiteDropdown[$i]->site_id; ?>"
												<?php if($getAllSiteDropdown[$i]->site_id == $site_id){ echo 'selected="selected"';} ?>>
												<?php echo $getAllSiteDropdown[$i]->site_title; ?>
											</option>
											<?php } ?>
											<?php } ?>
									</select>
									</td>

									<td width="15%"><select class="form-control select"
										id="officer_id" name="officer_id">
											<option value="" selected="selected">Select Field Officer</option>
											<?php if(count($fieldOfficerData)>0)
											{
												for($i=0;$i<count($fieldOfficerData);$i++)
                                    {?>
											<option value="<?php echo $fieldOfficerData[$i]->user_id; ?>"
											<?php if($fieldOfficerData[$i]->user_id == $officer_id){ echo 'selected="selected"';} ?>>
												<?php echo $fieldOfficerData[$i]->first_name.' '.$fieldOfficerData[$i]->last_name; ?>
											</option>
											<?php
                                    }
                                }?>
									</select>
									</td>

									<td width="15%">
										<div class="input-group" style="float: left;">
											<input placeholder="Date" type="text"
												class="form-control datepicker" id="start_date"
												name="start_date" value="<?php echo $start_date; ?>"
												/>
										</div> <!--  <div class="input-group"  >
                                            <input placeholder="End Date" type="text" class="form-control datepicker" id="end_date" name="end_date" value="<?php echo $end_date; ?>" onchange="daterangefrom();"/>
                                        </div> -->
									</td>
									<td width="10%">
										<button class="btn btn-primary pull-left">Go</button>
									</td>
									<td width="10%"><input type="button" id="showBtn"
										class="btn btn-primary pull-left" value="Show Map"
										style="display: none;"
										onclick="javascript:$('#mapdiv').show('slow');$('#hideBtn').show();$('#showBtn').hide();$('.dashboardlist').css('height','300');">
										<input type="button" id="hideBtn"
										class="btn btn-primary pull-left" value="Hide Map"
										onclick="javascript:$('#mapdiv').hide('slow');$('#hideBtn').hide();$('#showBtn').show();$('.dashboardlist').css('height','500');">
									</td>
								</tr>
								<tr>

								</tr>
								<tr>

								</tr>
							</table>
						</div>
					</div>

					<!-- <div id="sec_app_map" class="mappanel clearfix" style="height: 400px;"><img src="<?php echo site_url();?>assets/images/map2.jpg" width="100%" /></div> -->

					<div id="mapdiv" class="mappanel clearfix" style="height: 300px;"></div>
					<div class="panel-body panel-body-table">
						<div class="table-responsive dashboardlist">
							<table class="table table-bordered table-striped table-actions"
								id="dashboard">
								<thead>

									<tr>
										<th width="20%">Field Officer</th>
										<th width="8%">Date</th>
										<th width="8%">Time</th>
										<!-- <th width="8%">Type</th> -->
										<th width="20%">Site</th>
										<th width="10%">Survey Response</th>
										<th width="10%">Difference</th>
										<th width="7%">Distance to</th>
										<th width="7%">Action</th>
									</tr>
								</thead>

								<tbody>
									<?php 
								// echo '<pre>';print_r($inspInstData);
									$totalkms = 0;
									if(count($inspInstData)>0)
									{
										for($i=0;$i<count($inspInstData);$i++)
                     				{
                                                    if($inspInstData[$i]->site_id != '' || $inspInstData[$i]->custom == 1){
                                                ?>
									<tr id="<?php echo $inspInstData[$i]->site_visiting_id;?>">
									<?php echo $inspInstData[$i]  ?>
										<td style=""><img
											alt="<?php echo $inspInstData[$i]->fo_name; ?>"
											class="userpic"
											src="<?php echo site_url();?>uploads/thumb_path/<?php echo $img = empty($inspInstData[$i]->image)?'default.jpg':$inspInstData[$i]->image;?>">
											<?php echo $inspInstData[$i]->fo_name; ?>
										<input type="hidden" name="link_<?php echo $inspInstData[$i]->site_visiting_id;?>" id="link_<?php echo $inspInstData[$i]->site_visiting_id;?>" value="<?php echo $inspInstData[$i]->map_link;?>">
                                                                                <input type="hidden" name="site_latlong_<?php echo $inspInstData[$i]->site_visiting_id;?>" id="site_latlong_<?php echo $inspInstData[$i]->site_visiting_id;?>" value="<?php echo $inspInstData[$i]->site_lat.','.$inspInstData[$i]->site_long;?>"></td>
										<td><?php echo date('Y-m-d',  strtotime($inspInstData[$i]->visiting_time)); ?>
										</td>
										<td><?php echo date('H:i:s',strtotime($inspInstData[$i]->visiting_time)); ?>
										</td>
										<!-- <td><?php if($inspInstData[$i]->custom == 1){ echo 'Custom'; }else if($inspInstData[$i]->guard_id){ echo 'Guard'; } else{ echo 'Site';} ?></td> -->
										<td><?php if($inspInstData[$i]->custom != 1){ 
											echo $inspInstData[$i]->site_title;
										}else { echo '<a target="_blank" href="https://www.google.com/maps/place/'.$inspInstData[$i]->latitude.','.$inspInstData[$i]->longitude.'">Get Location</a>';
} ?>
										</td>
                                                                                <td>
                                                                                    <?php if($inspInstData[$i]->custom == 1){ 
                                                                                                 ?>
                                                                                    <a href="<?php echo site_url('guard/survey/'.base64_encode($inspInstData[$i]->site_visiting_id)); ?>" title="<?php echo $inspInstData[$i]->description; ?>" alt="<?php echo $inspInstData[$i]->description; ?>">
                                                                                                        <?php echo substr($inspInstData[$i]->description,0,20); ?>
                                                                                                    </a>
                                                                                               <?php 
                                                                                        
                                                                                        
                                                                                        ?>
                                                                                    <?php }else{ ?>
                                                                                    <a href="<?php echo site_url('guard/survey/'.base64_encode($inspInstData[$i]->site_visiting_id)); ?>">
                                                                                        <?php echo (empty($inspInstData[$i]->total_answer)?'0':$inspInstData[$i]->total_answer).'/'.(empty($inspInstData[$i]->total_question)?'0':$inspInstData[$i]->total_question); ?>
                                                                                    </a>
                                                                                    <?php } ?>
										</td>
										<td
										<?php 
                                                                                $delta = floatval($inspInstData[$i]->delta)/1000;
                                                                               // echo $delta;
                                                                                if($delta <= $inspInstData[$i]->delta_threshold_start){ echo 'style="color:#059A28 !important;"'; }
										elseif ($delta >$inspInstData[$i]->delta_threshold_start && $delta < $inspInstData[$i]->delta_threshold_end) { echo 'style="color:#FFA400 !important;"'; }
                                                                                else{ echo 'style="color:#FF0000 !important;"'; } ?>>
											<?php echo round($inspInstData[$i]->delta).'m'; ?>
										</td>
                                                                                <td id="distance_<?php echo $inspInstData[$i]->site_visiting_id ; ?>"><a
											href="<?php echo $this->config->item('gMapDrivingDirectionUrl').$inspInstData[$i]->map_link; ?>"
											target="_blank"><?php echo $inspInstData[$i]->distance_to.'km'; ?>
										</a> <?php $totalkms+= $inspInstData[$i]->distance_to; ?></td>
										<td id="is_approved_div_<?php echo $inspInstData[$i]->site_visiting_id;?>">
                                                                                    <?php if($inspInstData[$i]->custom == 1 && empty($inspInstData[$i]->verified_by) && empty($inspInstData[$i]->rejected_by)){?>
                                                                                        <a title="Click to Approve" id="approve_<?php echo $inspInstData[$i]->site_visiting_id ; ?>" data-box="#mb-update-status" class="mb-control btn btn-danger btn-condensed" href="javascript:void(0);" onclick="showApproveSiteVisiting('<?php echo site_url(); ?>','<?php echo $inspInstData[$i]->site_visiting_id ; ?>',1);" ><span class="fa fa-check"></span></a>
                                                                                        <a title="Click to Reject" id="disapprove_<?php echo $inspInstData[$i]->site_visiting_id ; ?>" data-box="#mb-update-status" class="mb-control btn btn-danger btn-condensed" href="javascript:void(0);" onclick="showApproveSiteVisiting('<?php echo site_url(); ?>','<?php echo $inspInstData[$i]->site_visiting_id ; ?>',0);" ><span class="fa fa-times"></span></a>
                                                                                              <?php }else{echo "&nbsp;";
											}?></td>
									</tr>


									<?php
                                                    }
                     				}

                     				?>
									<tr>
										<td colspan="6" align="right"><strong>Total</strong></td>
										<td><strong><?php echo $totalkms.' KMs'; ?> </strong></td>
									</tr>
									<?php
									}
                     			else{ ?>
									<tr>
										<td colspan="8">No Records!</td>
									</tr>
									<?php
                            	}
                            	?>
                            	
								</tbody>
							</table>
						</div>
					</div>

					<?php if($this->session->flashdata('successMessage')){?>
					<div class="alert alert-success">
						<button type="button" class="close" data-dismiss="alert">
							<span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
						</button>
						<strong><?php echo $this->session->flashdata('successMessage'); ?>
						</strong>
					</div>
					<?php } ?>
					<div class="panel-body panel-body-table"></div>
				</div>
			</div>
		</div>
		<!-- END MANY COLUMNS  -->

	</form>
	<!-- END PAGE CONTENT WRAPPER -->
</div>
<?php
/*echo '<pre>';
 print_r($inspInstData);
echo '</pre>';
die();*/
?>



<!-- MESSAGE BOX-->
<div class="message-box animated fadeIn" data-sound="alert" id="mb-update-status">
    <div class="mb-container">
        <div class="mb-middle">
            <div class="mb-title" id='published-title'></div>
            <div class="mb-content">
                <p id='update-msg-publish'>Do you really want to approve?</p>        
                
                 <div class="form-group" id="display_reason" style="display:none;">
                     <label class="col-md-4 control-label" >Reason for rejection</label>
                    <div class="col-md-8">                                                                                            
                        <select tabindex="1" class="form-control select" name="reason" id="reason"  >
                            <?php if(count($reasonArr)>0)
                                { ?><option value="" >Select Reason</option>
                                <?php
                                for($i=0;$i<count($reasonArr);$i++)
                                { ?>
                                    <option value="<?php echo $reasonArr[$i];?>" >
                                        <?php echo $reasonArr[$i];?>
                                    </option>

                                <?php 
                                } ?>
                                <?php
                            } ?>                                                        
                         </select>
                    </div>                                                
                </div>
            </div>
            <div class="mb-footer">
                <div class="pull-right">
                    <a id="publish-yes" href="javascript:void(0);" class="btn btn-success btn-lg">Yes</a>
                    <button class="btn btn-default btn-lg mb-control-close">No</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END MESSAGE BOX-->



<script src="//maps.googleapis.com/maps/api/js?v=3&amp;sensor=false"></script>
<script type="text/javascript">
var location_data = [];
var site_location_data = [];
var map ='';
var siteimage = "<?php echo site_url('img/icon_green.png') ?>";
var customimage = "<?php echo site_url('img/icon_blue.png') ?>";
<?php 
$counterLabel   = count($inspInstData);
    if(count($inspInstData)>0)
    {
        for($i=0;$i<count($inspInstData);$i++)
        {
            $content = '';
            if($inspInstData[$i]->site_title){
                $content =  '<br/><b>Site</b> - '.$inspInstData[$i]->site_title;
            }
            if($inspInstData[$i]->visiting_time){
                $content .=  '<br/><b>Date</b> - '.$inspInstData[$i]->visiting_time;
            }
            if($inspInstData[$i]->total_answer||$inspInstData[$i]->total_question){
                $content .=  '<br/><b>Survey Response</b> - '.$inspInstData[$i]->total_answer.'/'.$inspInstData[$i]->total_question;
            }
            if($inspInstData[$i]->delta){
                $content .=  '<br/><b>Delta</b> - '.$inspInstData[$i]->delta;
            }
            if($inspInstData[$i]->distance_to){
                $content .=  '<br/><b>Distance To</b> - '.$inspInstData[$i]->distance_to;
            }
            if(empty($officer_id))
            {
            	$label = "";
            }else{
		$marker = $i+1;
            	$label = (string)$marker;
                $counterLabel = $counterLabel-1;
                $label = (string)$counterLabel;
            }
            $imageType = '';
            if($inspInstData[$i]->custom == 1){
                $imageType = site_url('img/icon_blue.png');
            }
            
            if($inspInstData[$i]->site_id>0){
                $sitecontent ='';
                if($inspInstData[$i]->site_title){
                    $sitecontent =  '<b>Site</b> - '.$inspInstData[$i]->site_title;
                }
                if($inspInstData[$i]->site_add){
                    $sitecontent .=  '<br/><b>Address</b> - '.$inspInstData[$i]->site_add;
                }
                if($inspInstData[$i]->city){
                    $sitecontent .=  '<br/><b>City</b> - '.$inspInstData[$i]->city;
                }
                if($inspInstData[$i]->zipcode){
                    $sitecontent .=  '<br/><b>Pin Code</b> - '.$inspInstData[$i]->zipcode;
                }
           
            
            
            ?>
             var myObj1  = { 
                    name: '<?php echo $inspInstData[$i]->site_title; ?>',
	            content: '<?php echo $sitecontent; ?>',
	            latlng: new google.maps.LatLng('<?php  echo $inspInstData[$i]->site_lat; ?>', '<?php  echo $inspInstData[$i]->site_long; ?>'),
                    label : '<?php echo $label;?>',
                    instype:'<?php echo $inspInstData[$i]->custom; ?>'
            
             }
            site_location_data.push(myObj1);
            <?php 
            }
            ?>
                
                
                
           // alert('<?php echo addslashes($content); ?>');    
            
        <?php if($inspInstData[$i]->site_id >0 || $inspInstData[$i]->custom == 1){ ?>
            var myObj  = { 
                    name: '<?php echo $inspInstData[$i]->site_title; ?>',
	            content: '<?php echo $content; ?>',
	            latlng: new google.maps.LatLng('<?php  echo $inspInstData[$i]->latitude; ?>', '<?php  echo $inspInstData[$i]->longitude; ?>'),
	            label : '<?php echo $label;?>',
                    image : '<?php echo $imageType; ?>',
                    instype:'<?php echo $inspInstData[$i]->custom; ?>'
            }
            //console.log(myObj);
            location_data.push(myObj);
        <?php } ?>
             
            
        <?php
        }
    }?>
        
       function map_initialize() {   
           map = new google.maps.Map(document.getElementById("mapdiv"), {
                center: new google.maps.LatLng(0, 0),
                zoom: 0,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            });
            for (var i = 0; i < location_data.length; i++) {
                var infowindow = new google.maps.InfoWindow();
                var marker =  new google.maps.Marker({
                    position: location_data[i].latlng,
                    map: map,
                    content:location_data[i].content,
                    title: location_data[i].name,
                    label: location_data[i].label,
                    icon:location_data[i].image
                });

                google.maps.event.addListener(marker, 'click', function() {
                    infowindow.setContent('<div id="content">'+this.content +'</div>');
                    infowindow.open(map, this);
                 });
            }
           
            //console.log('length'+site_location_data.length);
            for (var i = 0; i < site_location_data.length; i++) {
                var infowindow = new google.maps.InfoWindow();
                var marker =  new google.maps.Marker({
                    position: site_location_data[i].latlng,
                    map: map,
                    content:site_location_data[i].content,
                    title: site_location_data[i].name,
                    label: site_location_data[i].label,
                    icon:siteimage,
                });

                google.maps.event.addListener(marker, 'click', function() {
                    infowindow.setContent('<div id="content">'+this.content +'</div>');
                    infowindow.open(map, this);
                 });
            }
            
            
            if(location_data.length > site_location_data.length){
                var latlngbounds = new google.maps.LatLngBounds();
                for (var i = 0; i < location_data.length; i++) {
                    latlngbounds.extend(location_data[i].latlng);
                }
                map.fitBounds(latlngbounds);
            }else{
                var sitelatlngbounds = new google.maps.LatLngBounds();
                for (var i = 0; i < site_location_data.length; i++) {
                    sitelatlngbounds.extend(site_location_data[i].latlng);
                }
                map.fitBounds(sitelatlngbounds);
            }
            
            
               
            
        }
        google.maps.event.addDomListener(window, 'load', map_initialize);
        
//-------------------------------------------------------------------------

var directionsService;
var stepDisplay;
var position;
var stops_new;
var marker = [];
var polyline = [];
var poly2 = [];
var poly = null;
var startLocation = [];
var endLocation = [];
var timerHandle = [];
var stops_data = '';
var a, z, b;
var add;
var speed = 0.000005,wait = 1;
var infowindow = null;
infowindow = new google.maps.InfoWindow();
var myPano;
var panoClient;
var nextPanoId;
var directionsDisplay = [];
directionsDisplay[0] = new window.google.maps.DirectionsRenderer({
    suppressMarkers: true
});
directionsDisplay[1] = new window.google.maps.DirectionsRenderer({
    suppressMarkers: true
});
var mapOptions = {
   // center: new google.maps.LatLng(42.5584308, -70.8597732),
    zoom: 3,
    mapTypeId: google.maps.MapTypeId.ROADMAP
};

function Tour_startUp(stops) {
    //  alert('first'+stops.length);     
    if (!window.tour) window.tour = {
        updateStops: function(newStops) {
            stops = newStops;
        },
        // map: google map object
        // directionsDisplay: google directionsDisplay object (comes in empty)
        loadMap: function(map, dirdis) {
            var myOptions = {
                zoom: 15,
                mapTypeId: window.google.maps.MapTypeId.ROADMAP
            };
            map.setOptions(myOptions);
            dirdis.setMap(map);
        },
        fitBounds: function(stops_data, map) {
            var bounds = new window.google.maps.LatLngBounds();

            // extend bounds for each record 
            for (var x in stops_data) {
                var myLatlng = new window.google.maps.LatLng(stops_data[x].Geometry.Latitude, stops_data[x].Geometry.Longitude);
                bounds.extend(myLatlng);
            }
            map.fitBounds(bounds);
        },
        calcRoute: function(stops_new, directionsService, dirdis) {
            var batches = [];
            var itemsPerBatch = 10; // google API max = 10 - 1 start, 1 stop, and 8 waypoints
            var itemsCounter = 0;
            if(stops_new)
            {
            	var wayptsExist = stops_new.length > 0;
            }else
            {
            	var wayptsExist = 0;
            }
            var time = [];
            while (wayptsExist) {
                var subBatch = [];
                var subitemsCounter = 0;
                for (var j = itemsCounter; j < stops_new.length; j++) {
                    subitemsCounter++;
                    subBatch.push({
                        location: new window.google.maps.LatLng(stops_new[j].Geometry.Latitude, stops_new[j].Geometry.Longitude),
                        stopover: true

                    });
                    //time.push(stops[j].Geometry.Time);
                    if (subitemsCounter == itemsPerBatch)
                        break;
                }

                itemsCounter += subitemsCounter;
                batches.push(subBatch);
                wayptsExist = itemsCounter < stops_new.length;
                // If it runs again there are still points. Minus 1 before continuing to
                // start up with end of previous tour leg
                itemsCounter--;
            }

            // now we should have a 2 dimensional array with a list of a list of waypoints
            var combinedResults;
            var unsortedResults = [{}]; // to hold the counter and the results themselves as they come back, to later sort
            var directionsResultsReturned = 0;

            for (var k = 0; k < batches.length; k++) {
                var lastIndex = batches[k].length - 1;
                var start = batches[k][0].location;
                var end = batches[k][lastIndex].location;

                // trim first and last entry from array
                var waypts = [];
                waypts = batches[k];
                waypts.splice(0, 1);
                waypts.splice(waypts.length - 1, 1);

                var request = {
                    origin: start,
                    destination: end,
                    waypoints: waypts,
                    travelMode: window.google.maps.TravelMode.WALKING
                };
                //  alert('start'+start);
                //  alert('end'+end);

                (function(kk) {
                    directionsService.route(request, function(result, status) {
                        if (status == window.google.maps.DirectionsStatus.OK) {
                            //fx(result.routes[0]);

                            polyline[0] = new google.maps.Polyline({
                                path: [],
                                strokeColor: '#FFFF00',
                                strokeWeight: 3
                            });

                            poly2[0] = new google.maps.Polyline({
                                path: [],
                                strokeColor: '#FFFF00',
                                strokeWeight: 3
                            });

                            var unsortedResult = {
                                order: kk,
                                result: result
                            };
                            unsortedResults.push(unsortedResult);

                            directionsResultsReturned++;

                            if (directionsResultsReturned == batches.length) // we've received all the results. put to map
                            {
                                // sort the returned values into their correct order
                                unsortedResults.sort(function(a, b) {
                                    return parseFloat(a.order) - parseFloat(b.order);
                                });
                                var count = 0;
                                for (var key in unsortedResults) {
                                    if (unsortedResults[key].result != null) {
                                        if (unsortedResults.hasOwnProperty(key)) {
                                            if (count == 0) // first results. new up the combinedResults object
                                                combinedResults = unsortedResults[key].result;
                                            else {
                                                // only building up legs, overview_path, and bounds in my consolidated object. This is not a complete
                                                // directionResults object, but enough to draw a path on the map, which is all I need
                                                combinedResults.routes[0].legs = combinedResults.routes[0].legs.concat(unsortedResults[key].result.routes[0].legs);
                                                combinedResults.routes[0].overview_path = combinedResults.routes[0].overview_path.concat(unsortedResults[key].result.routes[0].overview_path);

                                                combinedResults.routes[0].bounds = combinedResults.routes[0].bounds.extend(unsortedResults[key].result.routes[0].bounds.getNorthEast());
                                                combinedResults.routes[0].bounds = combinedResults.routes[0].bounds.extend(unsortedResults[key].result.routes[0].bounds.getSouthWest());
                                            }
                                            count++;
                                        }
                                    }
                                }
                                dirdis.setDirections(combinedResults);
                                var legs = combinedResults.routes[0].legs;
                                var path = combinedResults.routes[0].overview_path;
                                //alert(path.length);
                                //alert(legs.length);
                                //setRoutes(legs[0].start_location,legs[legs.length-1].end_location);

                                for (var i = 0; i < legs.length; i++) {
                                    var markerletter = "A".charCodeAt(0);
                                    markerletter += i;
                                    markerletter = String.fromCharCode(markerletter);
                                    if (i == 0) {
                                        //marker[0] = createMarker2(legs[i].start_location,"start",legs[i].start_address,"green");
                                    }
                                    var steps = legs[i].steps;
                                    //  alert('arrival time : '+legs[i].arrival_time.text);
                                    //  var duration = steps.duration_in_traffic;
                                    // alert(duration.text);
                                    for (j = 0; j < steps.length; j++) {
                                        var nextSegment = steps[j].path;
                                        for (k = 0; k < nextSegment.length; k++) {
                                            polyline[0].getPath().push(nextSegment[k]);
                                            //bounds.extend(nextSegment[k]);
                                        }
                                    }
                                    //  createMarker(directionsDisplay.getMap(),legs[i].start_location,"marker"+i,"some text for marker "+i+"<br>"+legs[i].start_address,markerletter);   
                                }
                                // Marker for start point 
                                createMarker(dirdis.getMap(), legs[0].start_location, '', "Start Point<br>" + legs[0].start_address, 'A');

                                var i = legs.length;
                                var markerletter = "A".charCodeAt(0);
                                markerletter += i;
                                markerletter = String.fromCharCode(markerletter);

                                // marker for End Point 
                                createMarker(dirdis.getMap(), legs[legs.length - 1].end_location, '', "End Point <br>" + legs[legs.length - 1].end_address, 'B');
                                polyline[0].setMap(map);
                                //startAnimation(0);  
                            }
                        }
                    });
                })(k);
            }
        }
    };
}




var icons = new Array();
icons["red"] = new google.maps.MarkerImage("mapIcons/marker_red.png",
    // This marker is 20 pixels wide by 34 pixels tall.
    new google.maps.Size(20, 34),
    // The origin for this image is 0,0.
    new google.maps.Point(0, 0),
    // The anchor for this image is at 9,34.
    new google.maps.Point(9, 34));

var iconImage = new google.maps.MarkerImage('mapIcons/marker_red.png',
    // This marker is 20 pixels wide by 34 pixels tall.
    new google.maps.Size(20, 34),
    // The origin for this image is 0,0.
    new google.maps.Point(0, 0),
    // The anchor for this image is at 9,34.
    new google.maps.Point(9, 34));

var iconShadow = new google.maps.MarkerImage('http://www.google.com/mapfiles/shadow50.png',
    // The shadow image is larger in the horizontal dimension
    // while the position and offset are the same as for the main image.
    new google.maps.Size(37, 34),
    new google.maps.Point(0, 0),
    new google.maps.Point(9, 34));
	// Shapes define the clickable region of the icon.

	var iconShape = {
    coord: [9, 0, 6, 1, 4, 2, 2, 4, 0, 8, 0, 12, 1, 14, 2, 16, 5, 19, 7, 23, 8, 26, 9, 30, 9, 34, 11, 34, 11, 30, 12, 26, 13, 24, 14, 21, 16, 18, 18, 16, 20, 12, 20, 8, 18, 4, 16, 2, 15, 1, 13, 0],
    type: 'poly'
};


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
     
//-------------------------------------------------------------------------
        function showRoute() {      
            map = new google.maps.Map(document.getElementById("mapdiv"), mapOptions);
            directionsService = new google.maps.DirectionsService();
            Tour_startUp(stops_data[0]);
            window.tour.loadMap(map, directionsDisplay[0]);
   	    window.tour.fitBounds(stops_data[0],map);
            if (stops_data[0].length > 1)
            {
                window.tour.calcRoute(stops_data[0],directionsService, directionsDisplay[0]);
	            Tour_startUp(stops_data[1]);
	            window.tour.loadMap(map, directionsDisplay[1]);
	            window.tour.calcRoute(stops_data[1],directionsService, directionsDisplay[1]);
	            window.tour.fitBounds(stops_data[1],map);
            }       
         }
        
</script>
