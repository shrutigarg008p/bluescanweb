
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
                                    <h2><a  href="<?php echo site_url('branch');?>" class="btn btn-primary"><span class="fa fa-arrow-circle-o-left"></span>Back</a>
                                    <?php echo $pageHeading; ?></h2>
                                </div>
                            <div class="panel panel-default">
                                
                                   <div class="panel-body">                                                                        
                                    
                                    <div class="row">
                                        
                                        <div class="col-md-6">

                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Company<span class="error">*</span></label>
                                                <div class="col-md-9">                                                                                            
                                                    <select tabindex="1" class="form-control select" name="company_name" id="company_name" onchange="getRegionList('<?php echo site_url(); ?>');" <?php if($this->session->userdata('session_company_id')){ echo ' disabled="disabled "'; } ?>>
                                                        <?php if(count($company_name)>0)
                                                            { ?><option value="" >Select Company</option>
                                                            <?php
                                                            for($i=0;$i<count($company_name);$i++)
                                                            { ?>
                                                                <option value="<?php echo $company_name[$i]->company_id;?>"
                                                                    <?php if($company_name[$i]->company_id == $reg_company_id)
                                                                        { echo 'selected="selected"';} 
                                                                    ?> >
                                                                    <?php echo $company_name[$i]->company_name;//.'/ '.$region_areas[$i]->address.', '.$region_areas[$i]->city;?>
                                                                </option>                                                                    
                                                            <?php 
                                                            } ?>
                                                            <?php
                                                        } ?>                                                        
                                                     </select>
                                                    <?php echo form_error('company_name');?>
                                                </div>                                                
                                            </div>


                                            <div class="form-group">                                                
                                                <label class="col-md-3 control-label">Branch Name <span class="error">*</span></label>
                                                <div class="col-md-9">                                            
                                                    <div class="input-group">                                                        
                                                        <input tabindex="3" type="text" class="form-control" name="branch_name" id="branch_name" value="<?php echo set_value('branch_name', $branch_name); ?>" />
                                                    </div>     
                                                    <?php echo form_error('branch_name');?>
                                                </div>
                                            </div>                                            

                                            <div class="form-group">
                                                <label class="col-md-3 control-label">City <span class="error">*</span></label>
                                                <div class="col-md-9">                                            
                                                    <div class="input-group">
                                                        <input tabindex="5" type="text" class="form-control" name="city" id="city" value="<?php echo set_value('city', $city); ?>" />
                                                    </div>
                                                    <?php echo form_error('city');?>
                                                </div>
                                            </div>                                            

                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Phone <span class="error">*</span></label>
                                                <div class="col-md-9">                                            
                                                    <div class="input-group">
                                                        <input tabindex="7" type="text" class="form-control" name="contact_number" id="contact_number" value="<?php echo set_value('contact_number', $contact_number); ?>" />
                                                    </div>     
                                                    <?php echo form_error('contact_number');?>
                                                </div>
                                            </div>        
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">System Id</label>
                                                <div class="col-md-9">                                            
                                                    <div class="input-group">
                                                        <input tabindex="9" type="text" class="form-control" name="system_id" id="system_id" value="<?php echo set_value('system_id', $system_id); ?>" />
                                                    </div>
                                                </div>
                                            </div>
                                                                                                                    
                                        </div>


                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Region<span class="error">*</span></label>
                                                <div class="col-md-9">                                                                                            
                                                    <select tabindex="2" class="form-control select" name="region_area" id="region_area"  >
                                                        <?php if(count($region_areas)>0)
                                                            { ?><option value="" >Select Region</option>
                                                            <?php
                                                            for($i=0;$i<count($region_areas);$i++)
                                                            { ?>
                                                                <option value="<?php echo $region_areas[$i]->region_id;?>"
                                                                    <?php if($region_areas[$i]->region_id == $region_area)
                                                                        { echo 'selected="selected"';} 
                                                                    ?> >
                                                                    <?php echo $region_areas[$i]->region_name;//.'/ '.$region_areas[$i]->address.', '.$region_areas[$i]->city;?>
                                                                </option>
                                                                    
                                                            <?php 
                                                            } ?>
                                                            <?php
                                                        } ?>                                                        
                                                     </select>
                                                    <?php echo form_error('region_area');?>
                                                </div>                                                
                                            </div>


                                            <div class="form-group">                                                
                                                <label class="col-md-3 control-label">Address <span class="error">*</span></label>
                                                <div class="col-md-9">                                            
                                                    <div class="input-group">
                                                        <input tabindex="4" type="text" class="form-control" name="address" id="address" value="<?php echo set_value('address', $address); ?>" />
                                                    </div>     
                                                    <?php echo form_error('address');?>
                                                </div>
                                            </div>                                            
                                            
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Zipcode</label>
                                                <div class="col-md-9">                                            
                                                    <div class="input-group">
                                                        <input tabindex="6" type="text" class="form-control" name="zipcode" id="zipcode" value="<?php echo set_value('zipcode', $zipcode); ?>" />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Email <span class="error">*</span></label>
                                                <div class="col-md-9">                                            
                                                    <div class="input-group">
                                                        <input tabindex="8" type="text" class="form-control" name="email" id="email" value="<?php echo set_value('email', $email); ?>" />
                                                    </div>
                                                    <?php echo form_error('email');?>  
                                                </div>
                                            </div>
                                           
                                        </div>
                                        
                                    </div>

                                </div>
                               <div class="panel-footer">
                                    <button class="btn btn-primary pull-left">Submit</button>
                                </div>
                            </div>
                            </form>
                            
                        </div>
                    </div>                    
                    
                </div>
                <!-- END PAGE CONTENT WRAPPER -->  