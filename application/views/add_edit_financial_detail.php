
        <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">
                
                    <div class="row">
                        <div class="col-md-12">                     
                            <form class="form-horizontal" action="" method="POST">
                            <div class="page-title">                            
                                    <h2><a  href="<?php echo site_url('branch');?>" class="btn btn-primary"><span class="fa fa-arrow-circle-o-left"></span>Back</a>
                                    <?php echo $pageHeading; ?></h2>
                            </div>
                            <div class="page-tabs">                    
                                <?php                     
                                $userId = base64_decode($this->uri->segment(3));                    
                                if($userId!='')
                                {
                                ?>                        
                                    <a href="<?php echo ($userId!='') ? 'user/addEditUsers/'.$this->uri->segment(3) : 'javascript:void(0)';?>">Bio-Data</a>
                                    <a href="<?php echo ($userId!='') ? 'user/skills/'.$this->uri->segment(3) : 'javascript:void(0)';?>">Skills/Education/Experience</a>
                                    <a href="#third-tab" class="active">Financial/Banking Detail</a>                                    
                                    <a href="<?php echo ($userId!='') ? 'user/documents/'.$this->uri->segment(3) : 'javascript:void(0)';?>">Documents</a>
                                <?php
                                }
                                ?>    
                            </div>
                            <?php if($this->session->flashdata('successMessage')){?>
                            <div class="alert alert-success" >
                                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                <strong><?php echo $this->session->flashdata('successMessage'); ?></strong> 
                            </div>
                            <?php } ?>
                            <div class="panel panel-default page-tabs-item active" id="third-tab">                                
                                   <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4 control-label">Bank Name</label>
                                                <div class="col-md-8">  
                                                    <div class="input-group">
                                                        <input tabindex="1" type="text" class="form-control" name="bank_name" id="bank_name" value="<?php if(isset($bank_name) && !empty($bank_name)){ echo set_value('bank_name', $bank_name); }else{ echo set_value('bank_name'); } ?>" />
                                                    </div>
                                                    <?php echo form_error('bank_name');?>
                                                </div>                                                
                                            </div>                                           
                                            
                                            <div class="form-group">                                                
                                                <label class="col-md-4 control-label">IFSC</label>
                                                <div class="col-md-8">                                            
                                                    <div class="input-group">
                                                        <input tabindex="3 type="text" class="form-control" name="ifsc_code" id="ifsc_code" value="<?php if(isset($ifsc_code) && !empty($ifsc_code)){ echo set_value('ifsc_code', $ifsc_code); }else{ echo set_value('ifsc_code'); } ?>" />
                                                    </div>     
                                                    <?php echo form_error('ifsc_code');?>
                                                </div>
                                            </div>                                    

                                            <div class="form-group">
                                                <label class="col-md-4 control-label">PF Account number</label>
                                                <div class="col-md-8">                                            
                                                    <div class="input-group">
                                                        <input tabindex="5" type="text" class="form-control" name="pf_account_number" id="pf_account_number" value="<?php if(isset($pf_account_number) && !empty($pf_account_number)){ echo set_value('pf_account_number', $pf_account_number); }else{ echo set_value('pf_account_number'); } ?>" />
                                                    </div>
                                                    <?php echo form_error('pf_account_number');?>
                                                </div>
                                            </div>  
                                            
                                            <div class="form-group">
                                                <label class="col-md-4 control-label">ESIC Smart Card No</label>
                                                <div class="col-md-8">                                            
                                                    <div class="input-group">
                                                        <input tabindex="7" type="text" class="form-control" name="esic_smart_card_number" id="esic_smart_card_number" value="<?php if(isset($esic_smart_card_number) && !empty($esic_smart_card_number)){ echo set_value('esic_smart_card_number', $esic_smart_card_number); }else{ echo set_value('esic_smart_card_number'); } ?>" />
                                                    </div>
                                                    <?php echo form_error('esic_smart_card_number');?>  
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4 control-label">Branch</label>
                                                <div class="col-md-8"> 
                                                    <div class="input-group">
                                                        <input tabindex="2" type="text" class="form-control" name="branch_name" id="branch_name" value="<?php if(isset($bank_name) && !empty($branch_name)){ echo set_value('branch_name', $branch_name); }else{ echo set_value('branch_name'); } ?>" />
                                                    </div>
                                                    <?php echo form_error('branch_name');?>
                                                </div>                                                
                                            </div>

                                            <div class="form-group">                                                
                                                <label class="col-md-4 control-label">Account No</label>
                                                <div class="col-md-8">                                            
                                                    <div class="input-group">                                                        
                                                        <input tabindex="4" type="text" class="form-control" name="account_number" id="account_number" value="<?php if(isset($account_number) && !empty($account_number)){ echo set_value('account_number', $account_number); }else{ echo set_value('account_number'); } ?>" />
                                                    </div>     
                                                    <?php echo form_error('account_number');?>
                                                </div>
                                            </div>                                    
                                            
                                            <div class="form-group">
                                                <label class="col-md-4 control-label">ESIC Account No</label>
                                                <div class="col-md-8">                                            
                                                    <div class="input-group">
                                                        <input tabindex="6" type="text" class="form-control" name="esic_account_number" id="esic_account_number" value="<?php if(isset($esic_account_number) && !empty($esic_account_number)){ echo set_value('esic_account_number', $esic_account_number); }else{ echo set_value('esic_account_number'); } ?>" />
                                                    </div>     
                                                    <?php echo form_error('esic_account_number');?>
                                                </div>
                                            </div> 
                                            <div class="form-group">
                                                <label class="col-md-4 control-label">Aadhar Card No</label>
                                                <div class="col-md-8">                                            
                                                    <div class="input-group">
                                                        <input tabindex="8" type="text" class="form-control" name="aadhar_card_no" id="aadhar_card_no" value="<?php if(isset($aadhar_card_no) && !empty($aadhar_card_no)){ echo set_value('aadhar_card_no', $aadhar_card_no); }else{ echo set_value('aadhar_card_no'); } ?>" />
                                                    </div>     
                                                    <?php echo form_error('aadhar_card_no');?>
                                                </div>
                                            </div> 
                                            
                                        </div>
                                        
                                    </div>

                                </div>
                                <div class="panel-footer">
                                    <button tabindex="9" class="btn btn-primary pull-left">Submit</button>
                                </div>
                            </div>
                            </form>
                            
                        </div>
                    </div>                    
                    
                </div>
                <!-- END PAGE CONTENT WRAPPER -->  