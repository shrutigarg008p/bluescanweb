
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
                            
                            <?php if(isset($error_message) && !empty($error_message)){ ?>
                            <div class="alert alert-warning" >
                                <button tabindex="4" type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                <strong><?php echo $error_message; ?></strong> 
                            </div>
                            <?php  } ?> 
                            <form class="form-horizontal" action="" method="POST" enctype="multipart/form-data">
                      <div class="page-title">
<h2><a  href="<?php echo site_url('company');?>" class="btn btn-primary"><span class="fa fa-arrow-circle-o-left"></span>Back</a>
<strong><?php echo $pageHeading; ?></strong></h2>  </div> <div class="panel panel-default">
                                
                                   <div class="panel-body">                                                                        
                                    
                                    <div class="row">
                                        
                                        <div class="col-md-6">
                                            
                                            <div class="form-group">
                                                <label class="col-md-4 control-label">Company Name <span class="error">*</span></label>
                                                
                                                <div class="col-md-8">                                            
                                               <div class="input-group">
                                                        <input tabindex="1" type="text" class="form-control " name="company_name" id="company_name" value="<?php echo set_value('company_name', $companyName); ?>" />
                                                    </div>
                                                    <?php echo form_error('company_name');?>
                                                </div>
                                            </div>
                                            
                                            
                                            
                                             <div class="form-group">
                                                <label class="col-md-4 control-label">City <span class="error">*</span></label>
                                                <div class="col-md-8">                                            
                                                    <div class="input-group">
                                                        <input tabindex="3" type="text" class="form-control" name="city" id="city" value="<?php echo set_value('city', $city); ?>" />
                                                    </div>
                                                    <?php echo form_error('city');?>
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label class="col-md-4 control-label">State <span class="error">*</span></label>
                                                <div class="col-md-8">                                            
                                                    <div class="input-group">
                                                        <input tabindex="5" type="text" class="form-control" name="state" id="state" value="<?php echo set_value('state', $state); ?>" />
                                                    </div>    
                                                    <?php echo form_error('state');?>
                                                </div>
                                                
                                            </div>

                                             <div class="form-group">
                                                <label class="col-md-4 control-label">Contact Person <span class="error">*</span></label>
                                                <div class="col-md-8">                                            
                                                    <div class="input-group">
                                                        <input tabindex="7" type="text" class="form-control" name="contact_person" id="contact_person" value="<?php echo set_value('contact_person', $contact_person); ?>" />
                                                    </div>
                                                    <?php echo form_error('contact_person');?>
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label class="col-md-4 control-label">Email <span class="error">*</span></label>
                                                <div class="col-md-8">                                            
                                                    <div class="input-group">
                                                        <input tabindex="9" type="text" class="form-control" name="email" id="email" value="<?php echo set_value('email', $email); ?>" />
                                                    </div>
                                                    <?php echo form_error('email');?>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-4 control-label">Delta Start Limit <span class="error">*</span></label>
                                                <div class="col-md-8">                                            
                                                    <div class="input-group">
                                                        <input tabindex="11" type="text" class="form-control" name="threshold_value1" id="threshold_value1" value="<?php echo set_value('threshold_value1', $threshold_value1); ?>" />
                                                    </div> 
                                                    <?php echo form_error('threshold_value1');?>
                                                </div>
                                            </div> 
                                             <div class="form-group">
                                                <label class="col-md-4 control-label">Company license <?php if($companyId == ''){ ?> <span class="error">*</span> <?php } ?></label>
                                                <div class="col-md-8">  
                                                <?php 
                                                    if($companyId>0){
                                                        echo '<div class="input-group" style="padding-top: 6px;">'.$liecense_code.'</div>';
                                                    }else{ ?>
                                                                                                                                          
                                                    <select tabindex="13" class="form-control select" name="license_code" id="license_code"  >
                                                       <?php if(count($licenseData)>0){ ?>
                                                        <option value="" >Select License</option>
                                                         <?php   for($i=0;$i<count($licenseData);$i++){ ?>
                                                        <option value="<?php echo $licenseData[$i]->company_license_id;?>" <?php if($licenseData[$i]->license_code == $liecense_code){ echo 'selected="selected"';} ?> ><?php echo $licenseData[$i]->license_code;?></option>
                                                                    
                                                         <?php       }
                                                           
                                                           
                                                           ?>
                                                           
                                                           
                                                           
                                                       <?php  } ?>
                                                     </select>
                                                    <?php echo form_error('license_code');?>
                                               
                                                <?php  } ?>
                                                 </div>
                                            </div>
                                             
                                            
                                            
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4 control-label">Address <span class="error">*</span></label>
                                                <div class="col-md-8">                                            
                                                    <div class="input-group">
                                                        <input tabindex="2" type="text" class="form-control" name="address" id="address" value="<?php echo set_value('address', $address); ?>" />
                                                    </div>     
                                                    <?php echo form_error('address');?>
                                                </div>
                                            </div>
                                            
                                            
                                            <div class="form-group">
                                                <label class="col-md-4 control-label">Zipcode</label>
                                                <div class="col-md-8">                                            
                                                    <div class="input-group">
                                                        <input tabindex="4" type="text" class="form-control" name="zipcode" id="zipcode" value="<?php echo set_value('zipcode', $zipcode); ?>" />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-4 control-label">Country <span class="error">*</span></label>
                                                <div class="col-md-8">                                            
                                                    <div class="input-group">
                                                        <input tabindex="6" type="text" class="form-control" name="country" id="country" value="<?php echo set_value('country', $country); ?>" />
                                                    </div>
                                                    <?php echo form_error('country');?>
                                                </div>
                                            </div>
                                                                                       
                                            
                                            <div class="form-group">
                                                <label class="col-md-4 control-label">Contact Number <span class="error">*</span></label>
                                                <div class="col-md-8">                                            
                                                    <div class="input-group">
                                                        <input tabindex="8" type="text" class="form-control" name="contact_number" id="contact_number" value="<?php echo set_value('contact_number', $contact_number); ?>" />
                                                    </div>       
                                                    <?php echo form_error('contact_number');?>
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label class="col-md-4 control-label">Website</label>
                                                <div class="col-md-8">                                            
                                                    <div class="input-group">
                                                        <input tabindex="10" type="text" class="form-control" name="website" id="website" value="<?php echo set_value('website', $website); ?>" />
                                                    </div> 
                                                    
                                                </div>
                                            </div> 
                                             <div class="form-group">
                                                <label class="col-md-4 control-label">Delta End Limit <span class="error">*</span></label>
                                                <div class="col-md-8">                                            
                                                    <div class="input-group">
                                                        <input tabindex="12" type="text" class="form-control" name="threshold_value2" id="threshold_value2" value="<?php echo set_value('threshold_value2', $threshold_value2); ?>" />
                                                    </div> 
                                                    <?php echo form_error('threshold_value2');?>
                                                </div>
                                            </div> 
                                           <?php if(isset($valid_to) && !empty($valid_to)){ ?>
                                             <div class="form-group">
                                                <label class="col-md-4 control-label">Expiry Date</label>
                                                <div class="col-md-8">                                            
                                                    <div class="input-group" style="padding-top: 6px;">
                                                        <?php echo date('Y-m-d',  strtotime($valid_to)); ?>
                                                    </div> 
                                                    
                                                </div>
                                            </div>  
                                            <?php } ?>
                                            
                                            <div class="form-group">
                                                <label class="col-md-4 control-label">Company Logo Image</label>
                                                <div class="col-md-8">                                            
                                                    <div class="input-group">
                                                    	<div class="">
                                                            <?php //$img = (empty($image_url)?'default.jpg':$image_url);
                                                            if(!empty($image_url))
                                                            {?>
                                                                <img src="<?php echo 'uploads/company_img/company_thumb_img/'.$image_url; ?>" height="75" width="75" />
                                                                
                                                            <?php
                                                            }
                                                            ?>     
                                                            </div>
                                                                <div class="col-md-8">                                                                
                                                            <input tabindex="14" type="file" class="fileinput" name="img_upload" id="img_upload" value=""/>
                                                        </div>
                                                    </div> 
                                                  <!--  <small style="display:block; clear:both; margin-left:10px;">(height = 48 & width = 216 in pixel)</small> -->
                                                    <?php echo form_error('img_upload');?>
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>

                                </div>
                               <div class="panel-footer">
                                    <button tabindex="15" class="btn btn-primary pull-left">Submit</button>
                                </div>
                            </div>
                            </form>
                            
                        </div>
                    </div>                    
                    
                </div>
                <!-- END PAGE CONTENT WRAPPER -->  