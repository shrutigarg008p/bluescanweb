
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
                                   <h2><a  href="<?php echo site_url('region');?>" class="btn btn-primary"><span class="fa fa-arrow-circle-o-left"></span>Back</a> 
                                   <?php echo $pageHeading; ?></h2>                                    
                                </div>
                            <div class="panel panel-default">
                                
                                   <div class="panel-body">                                                                        
                                    
                                    <div class="row">
                                        
                                        <div class="col-md-6">
                                            
                                            <div class="form-group">
                                                <label class="col-md-4 control-label">Company Name <span class="error">*</span></label>
                                                <div class="col-md-8">                                            
                                                    <div class="input-group">
                                                        <select tabindex="1" class="form-control select" name="company_name" id="company_name" <?php if(in_array($this->user->role_code, array('sadmin','cadmin','cuser'))){ echo 'disabled="disabled"'; } ?>>                                                            
                                                            <?php if(count($company_ids)>0)
                                                            { ?><option value="" >Select Company Name</option>
                                                            <?php
                                                            for($i=0;$i<count($company_ids);$i++)
                                                            { ?>
                                                                <option value="<?php echo $company_ids[$i]->company_id;?>"
                                                                    <?php if($company_ids[$i]->company_id == $company_id)
                                                                        { echo 'selected="selected"';} 
                                                                    ?> >
                                                                    <?php echo $company_ids[$i]->company_name;?>
                                                                </option>
                                                                    
                                                            <?php 
                                                            } ?>
                                                            <?php
                                                        } ?>
                                                        </select>
                                                    </div>
                                                    <?php echo form_error('company_name');?>
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label class="col-md-4 control-label">Reigon Address <span class="error">*</span></label>
                                                <div class="col-md-8">                                            
                                                    <div class="input-group">
                                                        <input tabindex="3" type="text" class="form-control" name="address" id="address" value="<?php echo set_value('address', $address); ?>" />
                                                    </div>     
                                                    <?php echo form_error('address');?>
                                                </div>
                                            </div>                                
                                                                                        
                                            <div class="form-group">
                                                <label class="col-md-4 control-label">City <span class="error">*</span></label>
                                                <div class="col-md-8">                                            
                                                    <div class="input-group">
                                                        <input tabindex="5" type="text" class="form-control" name="city" id="city" value="<?php echo set_value('city', $city); ?>" />
                                                    </div>
                                                    <?php echo form_error('city');?>
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label class="col-md-4 control-label">Email <span class="error">*</span></label>
                                                <div class="col-md-8">                                            
                                                    <div class="input-group">
                                                        <input tabindex="7" type="text" class="form-control" name="email" id="email" value="<?php echo set_value('email', $email); ?>" />
                                                    </div>
                                                    <?php echo form_error('email');?>
                                                </div>
                                            </div>                                            
                                            
                                        </div>



                                        <div class="col-md-6">
                                        <!--    
                                            <div class="form-group">
                                                <label class="col-md-4 control-label">Created By</label>
                                                <div class="col-md-8">                                            
                                                    <div class="input-group">
                                                        <select class="form-control select" name="user_name" id="user_name">
                                                            <?php if(count($user_ids)>0){ ?>
                                                                <option value=''>Select User List</option>
                                                                <?php
                                                                for($i=0;$i<count($user_ids);$i++)
                                                                {
                                                                 ?>
                                                                    <option value="<?php echo $user_ids[$i]->user_id; ?>"
                                                                        <?php if($user_ids[$i]->user_id == $user_id)
                                                                        { echo 'selected="selected"';}
                                                                        ?> >
                                                                        <?php echo $user_ids[$i]->first_name.' '.$user_ids[$i]->last_name; ?>
                                                                    </option>
                                                                    <?php
                                                                }                                                            
                                                            } ?>
                                                        </select>
                                                    </div>
                                                    <?php echo form_error('user_name');?>
                                                </div>
                                            </div>
                                       -->                                                 
                                            <div class="form-group">
                                                <label class="col-md-4 control-label">Region Name <span class="error">*</span></label>
                                                <div class="col-md-8">                                            
                                                    <div class="input-group">
                                                        <input tabindex="2" type="text" class="form-control" name="region_name" id="region_name" value="<?php echo set_value('region_name', $region_name); ?>" />
                                                    </div>       
                                                    <?php echo form_error('region_name');?>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-4 control-label">Contact Number <span class="error">*</span></label>
                                                <div class="col-md-8">                                            
                                                    <div class="input-group">
                                                        <input tabindex="4" type="text" class="form-control" name="contact_number" id="contact_number" value="<?php echo set_value('contact_number', $contact_number); ?>" />
                                                    </div>       
                                                    <?php echo form_error('contact_number');?>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-4 control-label">Zipcode</label>
                                                <div class="col-md-8">                                            
                                                    <div class="input-group">
                                                        <input tabindex="6" type="text" class="form-control" name="zipcode" id="zipcode" value="<?php echo set_value('zipcode', $zipcode); ?>" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-4 control-label">System Id</label>
                                                <div class="col-md-8">                                            
                                                    <div class="input-group">
                                                        <input tabindex="8" type="text" class="form-control" name="system_id" id="system_id" value="<?php echo set_value('system_id', $system_id); ?>" />
                                                    </div>       
                                                    <?php echo form_error('system_id');?>
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