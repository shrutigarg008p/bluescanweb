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
                                <h2><a  href="<?php echo site_url('company/company_office_list/'.$this->uri->segment(3));?>" class="btn btn-primary"><span class="fa fa-arrow-circle-o-left"></span>Back</a>
                                    <?php echo $pageHeading.' ('.$company_name.')'; ?>
                                </h2>
                            </div>
                            
                            <div class="panel panel-default">
                                
                                   <div class="panel-body">                                                                        
                                    
                                    <div class="row">
                                        
                                        <div class="col-md-6">
                                            
                                            <div class="form-group">
                                                <label class="col-md-4 control-label">Contact Person <span class="error">*</span></label>
                                                <div class="col-md-8">                                            
                                                    <div class="input-group">
                                                        <input tabindex="1" type="text" class="form-control" name="office_contact_person" id="office_contact_person" value="<?php echo set_value('office_contact_person', $office_contact_person); ?>" />
                                                    </div>
                                                    <?php echo form_error('office_contact_person');?>
                                                </div>
                                            </div>  
                                            
                                            <div class="form-group">
                                                <label class="col-md-4 control-label">Address <span class="error">*</span></label>
                                                <div class="col-md-8">                                            
                                                    <div class="input-group">
                                                        <input tabindex="3" type="text" class="form-control" name="office_address" id="office_address" value="<?php echo set_value('office_address', $office_address); ?>" />
                                                    </div>     
                                                    <?php echo form_error('office_address');?>
                                                </div>
                                            </div>

                                            
                                            <div class="form-group">
                                                <label class="col-md-4 control-label">Zipcode</label>
                                                <div class="col-md-8">                                            
                                                    <div class="input-group">
                                                        <input tabindex="5" type="text" class="form-control" name="office_zipcode" id="office_zipcode" value="<?php echo set_value('office_zipcode', $office_zipcode); ?>" />
                                                    </div>
                                                </div>
                                            </div>

                                           
                                            
                                                                                  
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4 control-label">Email <span class="error">*</span></label>
                                                <div class="col-md-8">                                            
                                                    <div class="input-group">
                                                        <input tabindex="2" type="text" class="form-control" name="office_email" id="office_email" value="<?php echo set_value('office_email', $office_email); ?>" />
                                                    </div>
                                                    <?php echo form_error('office_email');?>
                                                </div>
                                            </div>


                                             <div class="form-group">
                                                <label class="col-md-4 control-label">City <span class="error">*</span></label>
                                                <div class="col-md-8">                                            
                                                    <div class="input-group">
                                                        <input tabindex="4" type="text" class="form-control" name="office_city" id="office_city" value="<?php echo set_value('office_city', $office_city); ?>" />
                                                    </div>
                                                    <?php echo form_error('office_city');?>
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label class="col-md-4 control-label">Contact Number <span class="error">*</span></label>
                                                <div class="col-md-8">                                            
                                                    <div class="input-group">
                                                        <input tabindex="6" type="text" class="form-control" name="office_contact_number" id="office_contact_number" value="<?php echo set_value('office_contact_number', $office_contact_number); ?>" />
                                                    </div>       
                                                    <?php echo form_error('office_contact_number');?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                               <div class="panel-footer">
                                    <button tabindex="7" class="btn btn-primary pull-left">Submit</button>
                                </div>
                            </div>
                            </form>
                            
                        </div>
                    </div>                    
                    
                </div>
                <!-- END PAGE CONTENT WRAPPER -->  