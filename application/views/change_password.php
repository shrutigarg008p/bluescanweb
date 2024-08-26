    <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">
                
                    <div class="row">
                        <div class="col-md-12">
                     
                            <form class="form-horizontal" action="" method="POST" >
                            <div class="page-title">
                                <h2><?php echo $pageHeading; ?></h2>
                            </div>
                            
                            <div class="panel panel-default">
                                
                                   <div class="panel-body">                                                                        
                                    
                                       
                    <?php if($this->session->flashdata('successMessage')){?>
                    <div class="alert alert-success" >
                        <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <strong><?php echo $this->session->flashdata('successMessage'); ?></strong> 
                    </div>
                    <?php } ?>  
                                       
                                       
                                       
                                    <div class="row">
                                        
                                        <div class="col-md-12">
                                            
                                            <div class="form-group col-md-12">
                                                <label class="col-md-2 control-label">Old Password <span class="error">*</span></label>
                                                <div class="col-md-5">                                            
                                                    <div class="input-group">
                                                        <input type="password" class="form-control" name="old_password" id="old_password" value="<?php echo set_value('old_password', $old_password); ?>" />
                                                    </div>
                                                    <?php echo form_error('old_password');?>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label class="col-md-2 control-label">New Password <span class="error">*</span></label>
                                                <div class="col-md-5">                                            
                                                    <div class="input-group">
                                                        <input type="password" class="form-control" name="new_password" id="new_password" value="<?php echo set_value('new_password', $new_password); ?>" />
                                                    </div>
                                                    <?php echo form_error('new_password');?>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label class="col-md-2 control-label">Confirm Password <span class="error">*</span></label>
                                                <div class="col-md-5">                                            
                                                    <div class="input-group">
                                                        <input type="password" class="form-control" name="confirm_password" id="confirm_password" value="<?php echo set_value('confirm_password', $confirm_password); ?>" />
                                                    </div>
                                                    <?php echo form_error('confirm_password');?>
                                                </div>
                                            </div>
                                            </div> 
                                        </div>
                                        <div class="col-md-6">
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
               