        <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">
                
                    <div class="row">
                        <div class="col-md-12">
                     <?php if($this->session->flashdata('successMessage')){?>
                    <div class="alert alert-success" >
                        <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <strong><?php echo $this->session->flashdata('successMessage'); ?></strong> 
                    </div>
                    <?php } ?>
                            <form class="form-horizontal" action="" method="POST">
                        <div class="page-title">
                            <h2><a  href="<?php echo site_url('site/siteList/'.base64_encode($customerId));?>" class="btn btn-primary"><span class="fa fa-arrow-circle-o-left"></span>Back</a>
                            <?php echo $pageHeading; ?>
                            </h2>
                        </div>
                            <div class="panel panel-default">
                                
                                   <div class="panel-body">                                                                        
                                    
                                    <div class="row">
                                        
                                        <div class="col-md-6">
                                            
                                            <div class="form-group">
                                                <label class="col-md-4 control-label">Region<span class="error">*</span></label>
                                                <div class="col-md-8">                                                                                            
                                                    <select tabindex="1" class="form-control select" name="region_id" id="region_area" onchange="getBranchList('<?php echo site_url(); ?>');"  >
                                                        <?php if(count($regionData)>0)
                                                            { ?><option value="" >Select Region</option>
                                                            <?php
                                                            for($i=0;$i<count($regionData);$i++)
                                                            { ?>
                                                                <option value="<?php echo $regionData[$i]->region_id;?>"
                                                                    <?php if($regionData[$i]->region_id == $regionId)
                                                                        { echo 'selected="selected"';} 
                                                                    ?> >
                                                                    <?php echo $regionData[$i]->region_name;?>
                                                                </option>
                                                                    
                                                            <?php 
                                                            } ?>
                                                            <?php
                                                        } ?>                                                        
                                                     </select>
                                                    <?php echo form_error('region_id');?>
                                                </div>                                                
                                            </div>
                                            
                                        <div class="form-group">
                                          <label class="col-md-4 control-label">Customer<span class="error">*</span></label>
                                          <div class="col-md-8"> 
                                            <select tabindex="3" class="form-control select" id="customer_id" name="customer_id"  >
                                                <option value="" selected="selected">Select Customer</option>  
                                                <?php if(count($customerData)>0){ ?>
                                                    <?php for($i=0;$i<count($customerData);$i++){?>
                                                       <option value="<?php echo $customerData[$i]->customer_id; ?>" <?php if($customerData[$i]->customer_id == $customerId){ echo 'selected="selected"';} ?> ><?php echo $customerData[$i]->first_name.' '.$customerData[$i]->last_name; ?></option>

                                                    <?php } ?>
                                                <?php } ?>
                                            </select>
                                              <?php echo form_error('customer_id');?>
                                           </div>                                                
                                        </div>
                                            
                                            
                                            <div class="form-group">
                                                <label class="col-md-4 control-label">Site Name <span class="error">*</span></label>
                                                <div class="col-md-8">                                            
                                                    <div class="input-group">
                                                        <input tabindex="5" type="text" class="form-control" name="site_name" id="site_name" value="<?php echo set_value('site_name', $site_name); ?>" />
                                                    </div>     
                                                    <?php echo form_error('site_name');?>
                                                </div>
                                            </div>
                                            
                                         
                                            
                                            
                                            
                                            
                                            <div class="form-group">
                                                <label class="col-md-4 control-label">1st Shift Start Time<span class="error">*</span></label>
                                                <div class="col-md-8">                                            
                                                    <div class="input-group">
                                                        <div class="input-group bootstrap-timepicker">
                                                            <input tabindex="7" type="text" name="shift_start_time1" id="shift_start_time1" class="form-control timepicker" value="<?php echo set_value('shift_start_time1', $shift_start_time1); ?>" />
                                                            <span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>
                                                        </div>
                                                    </div>
                                                    <?php echo form_error('shift_start_time1');?>
                                                </div>
                                            </div>
                                            
                                             <div class="form-group">
                                                <label class="col-md-4 control-label">2nd Shift Start Time<span class="error">*</span></label>
                                                <div class="col-md-8">                                            
                                                    <div class="input-group">
                                                        <div class="input-group bootstrap-timepicker">
                                                            <input tabindex="9" type="text" name="shift_start_time2" id="shift_start_time2" class="form-control timepicker" value="<?php echo set_value('shift_start_time2', $shift_start_time2); ?>" />
                                                            <span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>
                                                        </div>
                                                    </div>
                                                    <?php echo form_error('shift_start_time2');?>
                                                </div>
                                            </div>
                                            
                                             <div class="form-group">
                                                <label class="col-md-4 control-label">3rd Shift Start Time<span class="error">*</span></label>
                                                <div class="col-md-8">                                            
                                                    <div class="input-group">
                                                        <div class="input-group bootstrap-timepicker">
                                                            <input tabindex="11" type="text" name="shift_start_time3" id="shift_start_time3" class="form-control timepicker" value="<?php echo set_value('shift_start_time3', $shift_start_time3); ?>" />
                                                            <span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>
                                                        </div>
                                                    </div>
                                                    <?php echo form_error('shift_start_time3');?>
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label class="col-md-4 control-label">Contact Person  <span class="error">*</span></label>
                                                <div class="col-md-8">                                            
                                                    <div class="input-group">
                                                        <input tabindex="13" type="text" class="form-control" name="contact_person" id="contact_person" value="<?php echo set_value('contact_person', $contact_person); ?>" />
                                                    </div>
                                                    <?php echo form_error('contact_person');?>
                                                </div>
                                            </div>

                                           
                                            
                                            
                                            <div class="form-group">
                                                <label class="col-md-4 control-label">Address  <span class="error">*</span></label>
                                                <div class="col-md-8">                                            
                                                    <div class="input-group">
                                                        <input tabindex="15" type="text" class="form-control" name="address" id="address" value="<?php echo set_value('address', $address); ?>" />
                                                    </div>     
                                                    <?php echo form_error('address');?>
                                                </div>
                                            </div>
                                            
                                             <div class="form-group">
                                                <label class="col-md-4 control-label">City <span class="error">*</span></label>
                                                <div class="col-md-8">                                            
                                                    <div class="input-group">
                                                        <input tabindex="17" type="text" class="form-control" name="city" id="city" value="<?php echo set_value('city', $city); ?>" />
                                                    </div>
                                                    <?php echo form_error('city');?>
                                                </div>
                                            </div>
                                            
                                            
                                            <div class="form-group">
                                                <label class="col-md-4 control-label">Country <span class="error">*</span></label>
                                                <div class="col-md-8">                                            
                                                    <div class="input-group">
                                                        <input tabindex="19" type="text" class="form-control" name="country" id="country" value="<?php echo set_value('country', $country); ?>" />
                                                    </div>
                                                    <?php echo form_error('country');?>
                                                </div>
                                            </div>
                                            
                                             <div class="form-group">
                                                 <div class="col-md-8" style="float: right;">                                            
                                                    <div class="input-group">
                                                        <a id="location_btn"  class="btn btn-primary pull-left" href="javascript:void(0)"  title="Show Address in Map" >Show Address in Map</a>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                             <div class="form-group">
                                                <label class="col-md-4 control-label">Site ID <span class="error">*</span></label>
                                                <div class="col-md-8">                                            
                                                    <div class="input-group">
                                                        <input tabindex="20" type="text" class="form-control" name="site_comp_id" id="site_comp_id" value="<?php echo set_value('site_comp_id', $site_comp_id); ?>" />
                                                    </div>       
                                                    <?php echo form_error('site_comp_id');?>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-4 control-label">System Id</label>
                                                <div class="col-md-8">                                            
                                                    <div class="input-group">
                                                        <input tabindex="21" type="text" class="form-control" name="system_id" id="system_id" value="<?php echo set_value('system_id', $system_id); ?>" />
                                                    </div>       
                                                    <?php echo form_error('system_id');?>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            
                                            <div class="form-group">
                                                <label class="col-md-4 control-label">Branch Name  <span class="error">*</span></label>
                                                <div class="col-md-8">                                                                                            
                                                    <select tabindex="2" class="form-control select" name="branch_id" id="branch_id"  >
                                                        <?php if(count($branchData)>0)
                                                            { ?><option value="" >Select Branch</option>
                                                            <?php
                                                            for($i=0;$i<count($branchData);$i++)
                                                            { ?>
                                                                <option value="<?php echo $branchData[$i]->branch_id;?>"
                                                                    <?php if($branchData[$i]->branch_id == $branchId)
                                                                        { echo 'selected="selected"';} 
                                                                    ?> >
                                                                    <?php echo $branchData[$i]->branch_name;?>
                                                                </option>
                                                                    
                                                            <?php 
                                                            } ?>
                                                            <?php
                                                        } ?>                                                        
                                                     </select>
                                                    <?php echo form_error('branch_id');?>
                                                </div>                                                
                                            </div>
                                        
                                            <div class="form-group">
                                                <label class="col-md-4 control-label">Question Group  <span class="error">*</span></label>
                                                <div class="col-md-8">                                                                                            
                                                    <select tabindex="4" class="form-control select" name="group_id" id="group_id"  >                                                        
                                                        <?php if(count($questionGroupData)>0)
                                                            { ?><option value="" >Select Group</option>
                                                            <?php
                                                            for($i=0;$i<count($questionGroupData);$i++)
                                                            { ?>
                                                                <option value="<?php echo $questionGroupData[$i]->group_id;?>"
                                                                    <?php if($questionGroupData[$i]->group_id == $groupId)
                                                                        { echo 'selected="selected"';} 
                                                                    ?> >
                                                                    <?php echo $questionGroupData[$i]->group_name;?>
                                                                </option>
                                                                    
                                                            <?php 
                                                            } ?>
                                                            <?php
                                                        } ?>
                                                     </select>
                                                    <?php echo form_error('group_id');?>
                                                </div>                                                
                                            </div>


                                           
                                             <div class="form-group">
                                                <label class="col-md-4 control-label">Email  <span class="error">*</span></label>
                                                <div class="col-md-8">                                            
                                                    <div class="input-group">
                                                        <input tabindex="6" type="text" class="form-control" name="email" id="email" value="<?php echo set_value('email', $email); ?>" />
                                                    </div>
                                                    <?php echo form_error('email');?>
                                                </div>
                                            </div>
                                           
                                            
                                             <div class="form-group">
                                                <label class="col-md-4 control-label" style="padding-left: 5px;">1st Shift Margin Time<span class="error">*</span></label>
                                                <div class="col-md-8">                                            
                                                    <div class="input-group">
                                                        <div class="input-group bootstrap-timepicker">
                                                            <input tabindex="8" type="text" name="shift_threshold_time1" id="shift_threshold_time1" class="form-control timepicker" value="<?php echo set_value('shift_threshold_time1', $shift_threshold_time1); ?>" />
                                                            <span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>
                                                        </div>
                                                    </div>
                                                    <?php echo form_error('shift_threshold_time1');?>
                                                </div>
                                            </div>
                                            
                                             <div class="form-group">
                                                <label class="col-md-4 control-label" style="padding-left: 0px;">2nd Shift Margin Time<span class="error">*</span></label>
                                                <div class="col-md-8">                                            
                                                    <div class="input-group">
                                                        <div class="input-group bootstrap-timepicker">
                                                            <input tabindex="10" type="text" name="shift_threshold_time2" id="shift_threeshold_time2" class="form-control timepicker" value="<?php echo set_value('shift_threshold_time2', $shift_threshold_time2); ?>" />
                                                            <span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>
                                                        </div>
                                                    </div>
                                                    <?php echo form_error('shift_threshold_time2');?>
                                                </div>
                                            </div>
                                            
                                             <div class="form-group">
                                                <label class="col-md-4 control-label" style="padding-left: 0px;" >3rd Shift Margin Time<span class="error">*</span></label>
                                                <div class="col-md-8">                                            
                                                    <div class="input-group">
                                                        <div class="input-group bootstrap-timepicker">
                                                            <input tabindex="12" type="text" name="shift_threshold_time3" id="shift_threshold_time3" class="form-control timepicker" value="<?php echo set_value('shift_threshold_time3', $shift_threshold_time3); ?>" />
                                                            <span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>
                                                        </div>
                                                    </div>
                                                    <?php echo form_error('shift_threshold_time3');?>
                                                </div>
                                            </div>
                                            
                                             <div class="form-group">
                                                <label class="col-md-4 control-label">Contact Number <span class="error">*</span></label>
                                                <div class="col-md-8">                                            
                                                    <div class="input-group">
                                                        <input tabindex="14" type="text" class="form-control" name="contact_number" id="contact_number" value="<?php echo set_value('contact_number', $contact_number); ?>" />
                                                    </div>     
                                                    <?php echo form_error('contact_number');?>
                                                </div>
                                            </div>
                                           
                                             <div class="form-group">
                                                <label class="col-md-4 control-label">Pin Code</label>
                                                <div class="col-md-8">                                            
                                                    <div class="input-group">
                                                        <input tabindex="16" type="text" class="form-control" name="zipcode" id="zipcode" value="<?php echo set_value('zipcode', $zipcode); ?>" />
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label class="col-md-4 control-label">State <span class="error">*</span></label>
                                                <div class="col-md-8">                                            
                                                    <div class="input-group">
                                                        <input tabindex="18" type="text" class="form-control" name="state" id="state" value="<?php echo set_value('state', $state); ?>" />
                                                    </div>     
                                                    <?php echo form_error('state');?>
                                                </div>
                                            </div>
                                            
                                            
                                             <div class="form-group" >
                                                <div class="col-md-8" id="locationmap" style="float: right;width: 75%; height: 200px;"> 
                                                </div>
                                            </div>
                                           
                                        </div>
                                        
                                    </div>

                                </div>
                               <div class="panel-footer">
                                   <input type="hidden" class="form-control" name="url" id="url" value="<?php echo site_url(); ?>"/>
                                    <input type="hidden" class="form-control" name="latitude" id="latitude" value="<?php echo set_value('latitude', $latitude); ?>"/>
                                    <input type="hidden" class="form-control" name="longitude" id="longitude" value="<?php echo set_value('longitude', $longitude); ?>"/>
                                    <button tabindex="22" class="btn btn-primary pull-left">Submit</button>
                                </div>
                            </div>
                            </form>
                            
                        </div>
                    </div>                    
                    
                </div>
                <!-- END PAGE CONTENT WRAPPER -->  
<script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
<script>
    var markersArray = [];
    var geocoder = new google.maps.Geocoder();

    function addressIncompanent(address_components) {
            var result = {};
            for (var i = address_components.length - 1; i >= 0; i--) {
                var component = address_components[i];
                if (component.types.indexOf("postal_code") >= 0) {
                    result.postalCode = component.long_name;
                } else if (component.types.indexOf("street_number") >= 0) {
                    result.streetNumber = component.long_name;
                } else if (component.types.indexOf("route") >= 0) {
                    result.streetName = component.long_name;
                } else if (component.types.indexOf("locality") >= 0) {
                    result.city = component.long_name;
                } else if (component.types.indexOf("sublocality") >= 0) {
                    result.district = component.long_name;
                } else if (component.types.indexOf("administrative_area_level_1") >= 0) {
                    result.stateOrProvince = component.long_name;
                } else if (component.types.indexOf("country") >= 0) {
                    result.country = component.long_name;
                }
            }
            result.addressLine1 = [ result.streetNumber, result.streetName ].join(" ").trim();
            result.addressLine2 = "";
            return result;
        }



    function geocodePosition(pos) { //console.log(pos);
	  geocoder.geocode({
	    latLng: pos
	  }, function(responses) {
	    if (responses && responses.length > 0) {
                adressObj = addressIncompanent(responses[0].address_components);
		console.log(adressObj);
	      updateMarkerAddress(adressObj);
	    } else {
	      updateMarkerAddress('Cannot determine address at this location.');
	    }
	  });
	}
	
    function deleteOverlays(){
            if (markersArray) {
                for (i in markersArray) {
                    markersArray[i].setMap(null);
                }
                    markersArray.length = 0;
            }
    }
    function placeMarker(location) {
        // first remove all markers if there are any
        deleteOverlays();

        var marker = new google.maps.Marker({
            position: location,
            map: v_map,
            draggable:true,
        });

        // add marker in markers array
        markersArray.push(marker);
        markerEvents(marker);
        //map.setCenter(location);
    }
    
    function markerEvents(marker)
    {
            google.maps.event.addListener(marker, 'dragend', function(event) {
                    placeMarker(event.latLng);
                    updateMarkerPosition(event.latLng);
                    geocodePosition(event.latLng);
            });
    }
    
    function updateMarkerPosition(latLng) {
	  var data = [latLng.lat(),latLng.lng()].join(', ');
	  document.getElementById('latitude').value = latLng.lat();
	  document.getElementById('longitude').value = latLng.lng();
	}

    function updateMarkerAddress(adressObj) {
        var address = '';
        if(adressObj.addressLine1 != null){
             address += adressObj.addressLine1+' ';
        }
        if(adressObj.addressLine2 != null){
             address += adressObj.addressLine2+' ';
        }
        if(adressObj.streetName != null){
             address += adressObj.addressLine2+' ';
        }
        if(adressObj.district != null ){
             address += adressObj.district+' ';
        }
        if(adressObj.city != null ){
             address += adressObj.city+' ';
        }
       $('#address').val($.trim(address));
        $('#city').val(adressObj.city);
        $('#state').val(adressObj.stateOrProvince);
        $('#zipcode').val(adressObj.postalCode);
        $('#country').val(adressObj.country);
    }
    function location_map_initialize() {
	var myLatlng = new google.maps.LatLng($('#latitude').val(),$('#longitude').val()); // Add the coordinates
	var mapOptions = {
		zoom: 13, // The initial zoom level when your map loads (0-20)
		center: myLatlng, // Centre the Map to our coordinates variable
		mapTypeId: google.maps.MapTypeId.ROADMAP, // Set the type of Map
	  }
	v_map = new google.maps.Map(document.getElementById('locationmap'), mapOptions); // Render our map within the empty div
	
	var marker = new google.maps.Marker({ // Set the marker
		position: myLatlng, // Position marker to coordinates
		map: v_map, // assign the market to our map variable
		draggable:true
	});
	
 	markersArray.push(marker);  

 	markerEvents(marker);     
}
    location_map_initialize();
/*var lat     =  $('#latitude').val();
var long    =  $('#longitude').val();
if(!lat){
    lat = '<?php echo $this->config->item('default_latitude'); ?>';
}
if(!long){
    long = '<?php echo $this->config->item('default_longitude'); ?>';
}
    $('#locationmap').locationpicker({
        location: {latitude:  lat, longitude: long},	
        radius: null,
        inputBinding: {
                latitudeInput: $('#latitude'),
                longitudeInput: $('#longitude')      
        },
        enableAutocomplete: true,
        onchanged: function(currentLocation, radius) {
            if(currentLocation.latitude){
                 $('#latitude').val(currentLocation.latitude);
            }
            if(currentLocation.longitude){
                 $('#longitude').val(currentLocation.longitude);
            }
        }	
    });
*/
$( "#location_btn" ).click(function() {
    var url = $('#url').val();
    var country = $('#country').val();
    var city    = $('#city').val();
    var address = $('#address').val();
    var state   = $('#state').val();
    var zipcode = $('#zipcode').val();
      if(country != '' && city != '' && address != '' &&  state != ''){
          var textAddress =  address+' '+zipcode+' '+city+' '+state+' '+country;
          $('#textAddress').val(textAddress);
            $.ajax({
                    type: "POST",
                    url: url + 'common/getLatLongForSiteByAddress', 
                    cache:false,
                    data:{'country':country,'city':city,'address':address,'state':state,'zip':zipcode},
                    dataType: "json",
                    success: function(response){
                            if(response.status == 1){
                                   $('#latitude').val(response.lat);
                                   $('#longitude').val(response.long);
                                   location_map_initialize();
                            }else{
                                    if(response.msg != ''){
                                        $(".message-box").removeClass("open");
                                        return false;
                                    }else{
                                            window.location.href	= url+"user/logout";
                                    }
                            }
                    }
            });
        }else{
            alert('Please enter the address,country,city and address');
        }
});
</script>