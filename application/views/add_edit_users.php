        <!-- PAGE CONTENT WRAPPER -->                
        <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>        
        <script type="text/javascript" src='http://maps.google.com/maps/api/js?sensor=false&libraries=places'></script>
        <script src="<?php echo site_url(); ?>js/locationpicker.jquery.js"></script>    
        
     
                <div class="page-title">
                <div class="row"><div class="col-md-12">
                    <h2><a  href="<?php echo site_url('user/users');?>" class="btn btn-primary"><span class="fa fa-arrow-circle-o-left"></span>Back</a>
                    <?php echo $pageHeading; ?></h2>
                    </div></div>
                </div>
                <div class="page-tabs">
                <div class="row"><div class="col-md-12">
                    <a href="#first-tab" class="active">Bio-Data</a>
                    <?php                     
                    $userId = base64_decode($this->uri->segment(3));
                    if($userId!='')
                    {
                    ?>
                        <a href="<?php echo ($userId!='') ? 'user/skills/'.$this->uri->segment(3) : 'javascript:void(0)';?>">Skills/Education/Experience</a>
                        <a href="<?php echo ($userId!='') ? 'user/financial/'.$this->uri->segment(3) : 'javascript:void(0)';?>">Financial/Banking Detail</a>
                        <a href="<?php echo ($userId!='') ? 'user/documents/'.$this->uri->segment(3) : 'javascript:void(0)';?>">Documents</a>
                    <?php
                    }
                    ?>   </div></div> 
                </div>                
                
                <div class="page-content-wrap page-tabs-item active" id="first-tab">
                    <form class="form-horizontal" action="" method="POST" enctype="multipart/form-data" id="guardform">
                    <div class="checkbox" style="position:relative; z-index:100; margin-bottom:-35px;">
                        <?php if($this->session->flashdata('successMessage')){?>
                       <div class="alert alert-success" >
                           <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                           <strong><?php echo $this->session->flashdata('successMessage'); ?></strong> 
                       </div>
                       <?php } ?>                           
                        <label style="float:right; padding-right: 20px"><input type="checkbox" name="militry_service" id="militry_service" value="Y" <?php if($militry_service!='N'){ echo "checked='checked'"; } ?> />Military Service Y/N</label>                        
                    </div>                                        
                    <div id="service_panel" class="row" style="display:<?php echo ($militry_service=='N'?'none':'show'); ?>;">                        
                        <div class="col-md-12">
                        <div class="panel-heading">
<span class="label label-success label-form">Military Service Record</span>
</div>
                            
                            <div class="panel panel-default">                           
                                <div class="panel-body">
                                    <div class="row">
                                        
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4 control-label">Military ID Number</label>
                                                <div class="col-md-8">                                            
                                                    <div class="input-group">
                                                        <input tabindex="1" type="text" class="form-control" name="army_number" id="army_number" value="<?php echo set_value('army_number', $army_number); ?>" />
                                                    </div>
                                                    <?php echo form_error('army_number');?>
                                                </div>
                                            </div>                                                                                      
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4 control-label">Rank</label>
                                                <div class="col-md-8">                                            
                                                    <div class="input-group">
                                                        <input tabindex="2" type="text" class="form-control" name="rank" id="rank" value="<?php echo set_value('rank', $rank); ?>" />
                                                    </div>          
                                                    <?php echo form_error('rank');?>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-4 control-label">Date of Retirement</label>
                                                <div class="col-md-8">                                            
                                                    <div class="input-group">
                                                        <input tabindex="3" type="text"  class="form-control datepickerretirement" name="date_of_retirement" id="date_of_retirement" value="<?php if(strtotime($date_of_retirement)!= 0){ echo set_value('date_of_retirement', date('d-m-Y',strtotime($date_of_retirement))); }else{ echo set_value('date_of_retirement'); } ?>"/>
                                                    </div>
                                                    <?php echo form_error('date_of_retirement');?>
                                                </div>
                                            </div>
                                        </div>                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel-heading"><span class="label label-success label-form">Personal Detail(s)</span>
                            </div>
                                                       
                            <div class="panel panel-default">                                
                                   <div class="panel-body">                                                                        
                                        <?php if(isset($error_message) && !empty($error_message)){ ?>
                                        <div class="alert alert-warning" >
                                            <button tabindex="4" type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                            <strong><?php echo $error_message; ?></strong> 
                                        </div>
                                        <?php  } ?> 
                                    
                                       
                                    <div class="row">                                        
                                        <div class="col-md-6">                                            
                                            <div class="form-group">
                                                <label class="col-md-4 control-label">First Name <span class="error">*</span></label>
                                                <div class="col-md-8">                                            
                                                    <div class="input-group">
                                                        <input tabindex="5" type="text" class="form-control" name="first_name" id="first_name" value="<?php echo set_value('first_name', $first_name); ?>" />
                                                    </div>
                                                    <?php echo form_error('first_name');?>
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label class="col-md-4 control-label">Father's Name</label>
                                                <div class="col-md-8">                                            
                                                    <div class="input-group">
                                                        <input tabindex="7" type="text" class="form-control" name="father_name" id="father_name" value="<?php echo set_value('father_name', $father_name); ?>" />
                                                    </div>                                                    
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-4 control-label">Email <?php if($user_role_id!="GD"){ ?> <span id="email_span" class="error">*</span><?php } ?></label>
                                                <div class="col-md-8">                                            
                                                    <div class="input-group">
                                                        <input tabindex="9" type="text" class="form-control" name="email" id="email" value="<?php echo set_value('email', $email); ?>"
                                                        <?php if(!empty($user_id)) { ?> readonly <?php } ?>                                                        
                                                        style="background-color:white; color:grey;" />
                                                    </div>
                                                    <?php echo form_error('email'); ?>
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label class="col-md-4 control-label">Blood Group <span class="error">*</span></label>
                                                <div class="col-md-8">                                            
                                                    <div class="input-group">
                                                        <input tabindex="11" type="text" class="form-control" name="blood_group" id="blood_group" value="<?php echo set_value('blood_group', $blood_group); ?>" />
                                                    </div>       
                                                    <?php echo form_error('blood_group');?>
                                                </div>
                                            </div> 
                                            <div class="form-group">
                                                <label class="col-md-4 control-label">System Id</label>
                                                <div class="col-md-8">                                            
                                                    <div class="input-group">
                                                        <input tabindex="13" type="text" class="form-control" name="system_id" id="system_id" value="<?php echo set_value('system_id', $system_id); ?>" />
                                                    </div>
                                                    <?php echo form_error('system_id');?>
                                                </div>
                                            </div> 
                                        </div>


                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4 control-label">Last Name <span class="error">*</span></label>
                                                <div class="col-md-8">                                            
                                                    <div class="input-group">
                                                        <input tabindex="6" type="text" class="form-control" name="last_name" id="last_name" value="<?php echo set_value('last_name', $last_name); ?>" />
                                                    </div>     
                                                    <?php echo form_error('last_name');?>
                                                </div>
                                            </div>                                            
                                            
                                            <div class="form-group">
                                                <label class="col-md-4 control-label">Date of Birth <?php if(($user_role_id!="cuser")||($user_role_id!="cadmin")) { ?> <span id="dob_span" class="error">*</span> <?php } ?></label>
                                                <div class="col-md-8">                                            
                                                    <div class="input-group">
                                                        <input tabindex="8" type="text" class="form-control datepickerbirth" name="dob" id="dob" value="<?php if(isset($dob) && !empty($dob)){ echo set_value('dob', date("d-m-Y", strtotime($dob))); }else{ echo set_value('dob'); }  ?>" onchange="findage();" />
                                                    </div>
                                                    <?php echo form_error('dob');?>
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label class="col-md-4 control-label">Age<span class="error">*</span></label>
                                                <div class="col-md-8">                                            
                                                    <div class="input-group">
                                                        <input tabindex="10" type="text" class="form-control" name="age" id="age" value="<?php echo set_value('age', $age); ?>" readonly="readonly" style="background-color:white; color:grey;"/>
                                                    </div>
                                                    <?php echo form_error('age');?>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-4 control-label">Employee ID <span class="error">*</span></label>
                                                <div class="col-md-8">                                            
                                                    <div class="input-group">
                                                        <input tabindex="12" type="text" class="form-control" name="emp_comp_id" id="emp_comp_id" value="<?php echo set_value('emp_comp_id', $emp_comp_id); ?>" />
                                                    </div>       
                                                    <?php echo form_error('emp_comp_id');?>
                                                </div>
                                            </div>  
                                        </div>
                                    </div>     
                                                               
                                    <div class ="row" style="margin-top:10px;">
                                        <div class="col-md-12">
                                            <div class="panel panel-default">                                                
                                                <label class="label label-primary heading-leval">Local Address</label>
                                                <div class="panel-body">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="col-md-4 control-label">Local Address<span class="error">*</span></label>
                                                            <div class="col-md-8">                                            
                                                                <div class="input-group">
                                                                    <input tabindex="13" type="text" class="form-control" name="local_address" id="local_address" value="<?php echo set_value('local_address', $local_address); ?>" />
                                                                </div>     
                                                                <?php echo form_error('local_address');?>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-md-4 control-label">City<span class="error">*</span></label>
                                                            <div class="col-md-8">                                            
                                                                <div class="input-group">
                                                                    <input tabindex="14" type="text" class="form-control" name="local_city" id="local_city" value="<?php echo set_value('local_city', $local_city); ?>" />
                                                                </div>     
                                                                <?php echo form_error('local_city');?>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-md-4 control-label">State<span class="error">*</span></label>
                                                            <div class="col-md-8">                                            
                                                                <div class="input-group">
                                                                    <input tabindex="15" type="text" class="form-control" name="local_state" id="local_state" value="<?php echo set_value('local_state', $local_state); ?>" />
                                                                </div>     
                                                                <?php echo form_error('local_state');?>
                                                            </div>
                                                        </div>
                                                         <div class="form-group">
                                                            <label class="col-md-4 control-label">Zipcode<span class="error">*</span></label>
                                                            <div class="col-md-8">                                            
                                                                <div class="input-group">
                                                                    <input tabindex="16" type="text" class="form-control" name="local_pin" id="local_pin" value="<?php echo set_value('local_pin', $local_pin); ?>" />
                                                                </div>     
                                                                <?php echo form_error('local_pin');?>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="col-md-8" style="float: right;">                                            
                                                               <div class="input-group">
                                                                   <a id="location_btn"  class="btn btn-primary pull-left" href="javascript:void(0)"  title="Show Address in Map" >Show Address in Map</a>
                                                               </div>
                                                           </div>
                                                       </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        

                                                       <div id="somecomponent" style="float: right;width: 75%; height: 200px;"></div>
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                       
                                    <div class ="row">
                                        <div class="col-md-12">
                                            <div class="panel panel-default">                                                
                                                <label class="label label-primary heading-leval">Permanent Address</label>
                                                <div class="panel-body">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="col-md-4 control-label">Permanent Address</label>
                                                            <div class="col-md-8">                                            
                                                                <div class="input-group">
                                                                    <input tabindex="17" type="text" class="form-control" name="permanent_address" id="permanent_address" value="<?php echo set_value('permanent_address', $permanent_address); ?>" />
                                                                </div>                                                         
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="col-md-4 control-label">State</label>
                                                            <div class="col-md-8">                                            
                                                                <div class="input-group">
                                                                    <input tabindex="19" type="text" class="form-control" name="permanent_state" id="permanent_state" value="<?php echo set_value('permanent_state', $permanent_state); ?>" />
                                                                </div>     `
                                                                <?php echo form_error('permanent_state');?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="col-md-4 control-label">City</label>
                                                            <div class="col-md-8">                                            
                                                                <div class="input-group">
                                                                    <input tabindex="18" type="text" class="form-control" name="permanent_city" id="permanent_city" value="<?php echo set_value('permanent_city', $permanent_city); ?>" />
                                                                </div>     
                                                                <?php echo form_error('permanent_city');?>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="col-md-4 control-label">Zipcode</label>
                                                            <div class="col-md-8">                                            
                                                                <div class="input-group">
                                                                    <input tabindex="20" type="text" class="form-control" name="permanent_pin" id="permanent_pin" value="<?php echo set_value('permanent_pin', $permanent_pin); ?>" />
                                                                </div>     
                                                                <?php echo form_error('permanent_pin');?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">                                        
                                        <div class="col-md-6"> 
                                             <div class="form-group">
                                                <label class="col-md-4 control-label">Is System User ?</label>
                                                <div class="col-md-8">                                            
                                                    <div class="input-group">
                                                        <input tabindex="21" type="checkbox" class="form-control" name="is_system_user" value="1" id="is_system_user" <?php if(isset($is_system_user)&&!empty($is_system_user)){ echo 'checked="checked"'; }?>  onclick="isSystemUser();"  />
                                                    </div>       
                                                </div>
                                            </div>    
                                                                                    
                                            <div class="form-group" id="pass_div" style="<?php if(($is_system_user == 1 && empty($userId)) || $change_pass_flag == 1){ ?>display: block;<?php }else{ ?>display: none;<?php } ?>">
                                                <label class="col-md-4 control-label">New Password <span class="error">*</span></label>
                                                <div class="col-md-8">                                            
                                                    <div class="input-group">
                                                        <input tabindex="23" type="password" class="form-control" name="password" id="password" value="<?php echo set_value('newpass', $newpass); ?>" />
                                                    </div>       
                                                    <?php echo form_error('password');?>
                                                </div>
                                            </div>
                                          
                                            
                                             <?php
                                                    //if($user_role_id=="FO"){
                                                     ?>   
                                                    <input  type="hidden" class="form-control" name="latitude" id="latitude" value="<?php echo set_value('latitude', $latitude); ?>"/>
                                                    <input  type="hidden" class="form-control" name="longitude" id="longitude" value="<?php echo set_value('longitude', $longitude); ?>"/>
                                            
                                                    
                                            <!--<div id="latitude_div" class="form-group">
                                                <label class="col-md-4 control-label">Latitude<span class="error">*</span></label>
                                                <div class="col-md-8">                                            
                                                    <div class="input-group"> 
                                                        
                                                    </div>
                                                   <a href="http://www.mapcoordinates.net/en" target="_blank">Get latitude & longitude </a> 
                                                    <?php echo form_error('latitude'); ?>
                                                </div>
                                            </div>
                                            
                                            <div id="longitude_div" class="form-group">
                                                <label class="col-md-4 control-label">Longitude<span class="error">*</span></label>
                                                <div class="col-md-8">                                            
                                                    <div class="input-group">
                                                        
                                                    </div>
                                                    <?php echo form_error('longitude'); ?>
                                                </div>
                                            </div> -->
                                            
                                            <?php // }  ?>

                                            <div class="form-group">
                                                <label class="col-md-4 control-label">Profile Image </label>
                                                <div class="col-md-8">                                            
                                                    <div class="input-group">
                                                    	<div class="col-md-4">
                                                            <?php //$img = (empty($image_url)?'default.jpg':$image_url);
                                                            if(!empty($image_url))
                                                            {?>
                                                                <img src="<?php echo 'uploads/thumb_path/'.$image_url; ?>" height="75" width="75" />
                                                                </div>
                                                                <div class="col-md-8" style="padding-top:45px">
                                                            <?php
                                                            }
                                                            ?>                                        				                                                            
                                                            <input tabindex="23" type="file" class="fileinput" name="img_upload" id="img_upload" value=""/>
                                                        </div>
                                                    </div>       
                                                    <?php echo form_error('img_upload');?>
                                                </div>
                                            </div>
                                            
                                           
                                            
                                            
                                            
                                            
                                            
                                            <div class="form-group">
                                                <label class="col-md-4 control-label">Employee Role <span class="error">*</span></label>
                                                <div class="col-md-8">
                                                    <div class="input-group">
                                                        <select tabindex="25" class="form-control select" name="user_role" id="user_role" onchange="enDisWorkArea('<?php echo site_url(); ?>');" >
                                                        <?php if(count($user_roles)>0)
                                                        { ?><option value="">Select User Roles</option>
                                                          <?php
                                                            for($i=0;$i<count($user_roles);$i++)
                                                            { ?>
                                                                <option value="<?php echo $user_roles[$i]->code;?>" 
                                                                    <?php if($user_roles[$i]->code == $user_role_id)
                                                                        { echo 'selected="selected"';} 
                                                                    ?>>
                                                                    <?php echo $user_roles[$i]->role_name ?>
                                                                </option>                                                                    
                                                            <?php 
                                                            } ?>
                                                            <?php
                                                        } ?>
                                                        </select>
                                                     </div>
                                                    <?php echo form_error('user_role');?>
                                                </div>
                                            </div>
                                            
                                                <div class="form-group">
                                                <label class="col-md-4 control-label"><span id="user_role_selection">
                                                <?php
                                                    if($user_role_id=="RM"){
                                                        echo "Region";
                                                    }else if($user_role_id=="BM"){
                                                        echo "Branch";
                                                    }else if($user_role_id=="FO"){
                                                         echo "Site";
                                                    }
                                                    $displayOtherAstrict = 'style="display:none;"';
                                                    if(in_array($user_role_id, array('RM','BM','FO'))){
                                                        $displayOtherAstrict = '';
                                                    }
                                                ?> 
                                                    </span>       
                                               
                                                <span class="error" id="other_astrict" <?php echo $displayOtherAstrict; ?>  >*</span>                                                
                                                </label>
                                                <div class="col-md-8">                                            
                                                    <div class="input-group">                                                                                                                
                                                        <?php $disProp = ($user_role_id=="RM" )?'inline-block':'none'; ?>
                                                        <select size="5" tabindex="26" multiple="multiple" class="form-control select" name="region_name[]" id="region_name" style="display:<?php echo $disProp; ?>;height: 100px;width:100%;">
                                                            <?php if(count($region_ids)>0)
                                                        { ?>
                                                          <?php
                                                            for($i=0;$i<count($region_ids);$i++)
                                                            { ?>
                                                                <option value="<?php echo $region_ids[$i]->region_id;?>"
                                                                    <?php
                                                                    for($j=0;$j<count($region_id);$j++)
                                                                    {
                                                                        if($region_ids[$i]->region_id == $region_id[$j])
                                                                        { echo 'selected="selected"';}     
                                                                    }
                                                                     
                                                                    ?> >
                                                                    <?php echo $region_ids[$i]->region_name;?>
                                                                </option>
                                                                    
                                                            <?php 
                                                            } 
                                                        } ?>
                                                        </select>
                                                        

                                                        <?php $disProp = ($user_role_id=="BM")?'inline-block':'none'; ?>                                                        
                                                        <select  size="5" tabindex="26" multiple="multiple" class="form-control select" name="branch_name[]" id="branch_name" style="display:<?php echo $disProp; ?>;height: 100px;width:100%;">
                                                            <?php if(count($branch_ids)>0)
                                                        { ?>
                                                          <?php
                                                            for($i=0;$i<count($branch_ids);$i++)
                                                            { ?>
                                                                <option value="<?php echo $branch_ids[$i]->branch_id;?>"
                                                                    <?php
                                                                        for($j=0;$j<count($branch_id);$j++)
                                                                        {
                                                                            if($branch_ids[$i]->branch_id == $branch_id[$j])
                                                                            { echo 'selected="selected"';} 
                                                                        }
                                                                    ?> >
                                                                    <?php echo $branch_ids[$i]->region_name.'->'.$branch_ids[$i]->branch_name;?>
                                                                </option>
                                                                    
                                                            <?php 
                                                            } 
                                                        } ?>
                                                        </select>                                                        

                                                            
                                                       <?php $disProp = ($user_role_id=="FO")?'inline-block':'none'; ?>
                                                        <select  size="5" tabindex="26" multiple="multiple" class="form-control select" name="site_name[]" id="site_name" style="display:<?php echo $disProp; ?>;height: 100px;width:100%;">
                                                            <?php if(count($site_ids)>0)
                                                        { ?>
                                                          <?php
                                                            for($i=0;$i<count($site_ids);$i++)
                                                            { ?>
                                                                <option value="<?php echo $site_ids[$i]->site_id;?>"
                                                                    <?php
                                                                        for($j=0;$j<count($site_id);$j++)
                                                                        {
                                                                            if($site_ids[$i]->site_id == $site_id[$j])
                                                                            { echo 'selected="selected"';}
                                                                        }
                                                                    ?> >
                                                                    <?php echo $site_ids[$i]->site_title;?>
                                                                </option>
                                                                    
                                                            <?php 
                                                            } 
                                                        } ?>
                                                        </select>                                                       

                                                    </div>
                                                    
                                                   <?php echo form_error('company_name');?>
                                                    <?php echo form_error('region_name');?>
                                                    <?php echo form_error('branch_name');?>
                                                    <?php echo form_error('site_name');?>
                                                </div>
                                            </div>
                                            
                                         
                                        </div>

                                        <div class="col-md-6">  
                                            <!--<div class="form-group">
                                                <label class="col-md-4 control-label">Zipcode</label>
                                                <div class="col-md-8">                                            
                                                    <div class="input-group">
                                                        <input tabindex="4" type="text" class="form-control" name="zip" id="zip" value="<?php echo set_value('zip', $zip); ?>" />
                                                    </div>
                                                </div>
                                            </div>-->
                                           
                                            <div class="form-group">
                                                <div class="col-md-8" style="float: right;">                                            
                                                   <div class="input-group">
                                                        <?php if($userId >0 && $is_system_user == 1){ ?>
                                                       <a id="change_password_user_link" class="btn btn-primary pull-left" href="javascript:void(0)"  title="Change User Password" onclick="chnagePasswordClick();" >Change User Password</a>&nbsp;
                                                        <?php }else{ echo '&nbsp;';} ?>
                                                   </div>
                                               </div>
                                           </div> 
                                           
                                            <div class="form-group" id="conf_pass_div" style="<?php if(($is_system_user == 1 && empty($userId)) || $change_pass_flag == 1){ ?>display: block;<?php }else{ ?>display: none;<?php } ?>">
                                                <label class="col-md-4 control-label">Confirm Password <span class="error">*</span></label>
                                                <div class="col-md-8">                                            
                                                    <div class="input-group">
                                                        <input tabindex="20" type="password" class="form-control" name="conf_pass" id="conf_pass" value="<?php echo set_value('confpass', $confpass); ?>" />
                                                    </div>       
                                                    <?php echo form_error('conf_pass');?>
                                                </div>
                                            </div>

                                            
                                            
                                            <div class="form-group">
                                                <label class="col-md-4 control-label">Mobile Number <span class="error">*</span></label>
                                                <div class="col-md-8">                                            
                                                    <div class="input-group">
                                                        <input tabindex="22" type="text" class="form-control" name="mobile" id="mobile" value="<?php echo set_value('mobile', $mobile); ?>" />
                                                    </div>       
                                                    <?php echo form_error('mobile');?>
                                                </div>
                                            </div>                                            
                                             <div class="form-group">
                                                <label class="col-md-4 control-label">Status <span class="error">*</span></label>
                                                <div class="col-md-8">
                                                    <div class="input-group">
                                                        <select tabindex="24" class="form-control select" name="status" id="status"  >
                                                        <?php if(count($employeeStatusArr)>0)
                                                        { ?><option value="">Select Status</option>
                                                          <?php
                                                            for($i=0;$i<count($employeeStatusArr);$i++)
                                                            { ?>
                                                                <option value="<?php echo $i+1;?>" 
                                                                    <?php if(intval($i+1) == intval($status))
                                                                        { echo 'selected="selected"';} 
                                                                    ?>>
                                                                    <?php echo $employeeStatusArr[$i]; ?>
                                                                </option>                                                                    
                                                            <?php 
                                                            } ?>
                                                            <?php
                                                        } ?>
                                                        </select>
                                                     </div>
                                                    <?php echo form_error('status');?>
                                                </div>
                                            </div>                                                                               
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-footer">
                                     <input type="hidden" class="form-control" name="url" id="url" value="<?php echo site_url(); ?>"/>
                                     <input type="hidden" class="form-control" name="change_pass_flag" id="change_pass_flag" value="<?php echo set_value('change_pass_flag',$change_pass_flag); ?>"/>
                                    <button tabindex="27" class="btn btn-primary pull-left">Submit</button>
                                </div>
                            </div>                                                       
                        </div>
                    </div>                                        
                    </form>
                </div>                
                
                <!-- END PAGE CONTENT WRAPPER -->  

<script>
/*var lat     =  $('#latitude').val();
var long    =  $('#longitude').val();
if(!lat){
    lat = '<?php echo $this->config->item('default_latitude'); ?>';
}
if(!long){
    long = '<?php echo $this->config->item('default_longitude'); ?>';
}
$('#somecomponent').locationpicker({
    location: {latitude:  lat, longitude: long},	
    radius: null,
    inputBinding: {
            latitudeInput: $('#latitude'),
            longitudeInput: $('#longitude')      
    },
    enableAutocomplete: true,
    onchanged: function(currentLocation, radius, isMarkerDropped) {
        if(currentLocation.latitude){
             $('#latitude').val(currentLocation.latitude);
        }
        if(currentLocation.longitude){
             $('#longitude').val(currentLocation.longitude);
        }
        

    } 
});*/
    </script>
<script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
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
       $('#local_address').val($.trim(address));
        $('#local_city').val(adressObj.city);
        $('#local_state').val(adressObj.stateOrProvince);
        $('#local_pin').val(adressObj.postalCode);
        //$('#country').val(adressObj.country);
    }
    function location_map_initialize() {
	var myLatlng = new google.maps.LatLng($('#latitude').val(),$('#longitude').val()); // Add the coordinates
	var mapOptions = {
		zoom: 13, // The initial zoom level when your map loads (0-20)
		center: myLatlng, // Centre the Map to our coordinates variable
		mapTypeId: google.maps.MapTypeId.ROADMAP, // Set the type of Map
	  }
	v_map = new google.maps.Map(document.getElementById('somecomponent'), mapOptions); // Render our map within the empty div
	
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
    //alert('yes');
    var url = $('#url').val();
    var country = '';
    var city    = $('#local_city').val();
    var address = $('#local_address').val();
    var state   = $('#local_state').val();
    var zipcode = $('#local_pin').val();
      if(city != '' && address != '' &&  state != ''){
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
