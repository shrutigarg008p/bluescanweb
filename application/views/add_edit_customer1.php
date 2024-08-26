<!-- PAGE CONTENT WRAPPER -->

<div class="page-content-wrap">
  <div class="row">
    <div class="col-md-12">
      <?php if($this->session->flashdata('successMessage')){?>
      <div class="alert alert-success" >
        <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <strong><?php echo $this->session->flashdata('successMessage'); ?></strong> </div>
      <?php } ?>
      <form class="form-horizontal" action="" method="POST">
        <div class="page-title">
          <h2><a  href="<?php echo site_url('customer');?>" class="btn btn-primary"><span class="fa fa-arrow-circle-o-left"></span>Back</a>
          <?php echo $pageHeading; ?> </h2>
        </div>
        <div class="panel panel-default">
          <div class="panel-body">
            <div class="row">
              <div class="col-md-6">
             <!--   <div class="form-group">
                  <label class="col-md-4 control-label">Company <span class="error">*</span></label>
                  <div class="col-md-8">
                      <select tabindex="1" class="form-control select" name="company_id" id="company_id" <?php if($this->session->userdata('session_company_id')){ echo 'disabled="disabled"';} ?>  >
                      <?php if(count($companyData)>0){ ?>
                      <option value="" >Select Company</option>
                      <?php        for($i=0;$i<count($companyData);$i++){ ?>
                      <option value="<?php echo $companyData[$i]->company_id;?>" <?php if($companyData[$i]->company_id == $companyId){ echo 'selected="selected"';} ?> ><?php echo $companyData[$i]->company_name;?></option>
                      <?php } ?>
                      <?php  } ?>
                    </select>
                    <?php echo form_error('company_id');?> </div>
                </div> -->
                <div class="form-group">
                  <label class="col-md-4 control-label">Customer Name <span class="error">*</span></label>
                  <div class="col-md-8">
                    <div class="input-group">
                      <input tabindex="1" type="text" class="form-control" name="first_name" id="first_name" value="<?php echo set_value('first_name', $first_name); ?>" />
                    </div>
                    <?php echo form_error('first_name');?> </div>
                </div>    
                <div class="form-group">
                  <label class="col-md-4 control-label">Mobile <span class="error">*</span></label>
                  <div class="col-md-8">
                    <div class="input-group">
                      <input tabindex="3" type="text" class="form-control" name="mobile" id="mobile" value="<?php echo set_value('mobile', $mobile); ?>" />
                    </div>
                    <?php echo form_error('mobile');?> </div>
                </div>                
                <div class="form-group">
                  <label class="col-md-4 control-label">Address <span class="error">*</span></label>
                  <div class="col-md-8">
                    <div class="input-group">
                      <input tabindex="5" type="text" class="form-control" name="address" id="address" value="<?php echo set_value('address', $address); ?>" />
                    </div>
                    <?php echo form_error('address');?> </div>
                </div>
                <div class="form-group">
                  <label class="col-md-4 control-label">System Id<span class="error">*</span></label>
                  <div class="col-md-8">
                    <div class="input-group">
                      <input tabindex="6" type="text" class="form-control" name="system_id" id="system_id" value="<?php echo set_value('system_id', $system_id); ?>" />
                    </div>
                     <?php echo form_error('system_id');?> </div>
                  </div>
                
                <div class="form-group">
                  <label class="col-md-4 control-label">Engagement Date <span class="error">*</span></label>
                  <div class="col-md-8">
                    <div class="input-group">

                      <input tabindex="7" type="text" class="form-control datepicker" name="date_of_engagement" id="date_of_engagement" value="<?php if(isset($date_of_engagement)&&!empty($date_of_engagement)){ echo set_value('date_of_engagement', date('Y-m-d',  strtotime($date_of_engagement)));}else{echo set_value('date_of_engagement');} ?>" />
                    </div>
                    <?php echo form_error('date_of_engagement');?> </div>
                </div>
                <div class="form-group">
                  <label class="col-md-4 control-label">Primary Contact<span class="error">*</span></label>
                  <div class="col-md-8">
                    <div class="input-group">
                      <input tabindex="9" type="text" class="form-control" name="relational_contact" id="relational_contact" value="<?php echo set_value('relational_contact', $relational_contact); ?>" />
                    </div>
                    <?php echo form_error('relational_contact');?> </div>
                </div>
                </div>
                </div>
                <!--<div class="form-group">
                  <label class="col-md-4 control-label">Relational Contact <span class="error">*</span></label>
                  <div class="col-md-8">
                    <div class="input-group">
                      <input tabindex="7" type="text" class="form-control" name="relational_contact" id="relational_contact" value="<?php echo set_value('relational_contact', $relational_contact); ?>" />
                    </div>
                    <?php echo form_error('relational_contact');?> </div>
                </div>
                <div class="form-group">
                  <label class="col-md-4 control-label">Referring Party</label>
                  <div class="col-md-8">
                    <div class="input-group">
                      <input tabindex="9" type="text" class="form-control" name="referring_party" id="referring_party" value="<?php echo set_value('referring_party', $referring_party); ?>" />
                    </div>
                    <?php echo form_error('referring_party');?> </div>

                </div>-->                
              </div>
           
                
                
                
                
                <div class="col-md-6">
                
                <div class="form-group">
                  <label class="col-md-4 control-label">E-mail<span class="error"></span></label>
                  <div class="col-md-8">
                    <div class="input-group">
                      <input tabindex="2" type="text" class="form-control" name="email" id="email" value="<?php echo set_value('email', $email); ?>" />
                    </div>
                    <?php echo form_error('email');?>
                  </div>
                </div>
                <!--  
                <div class="form-group">
                  <label class="col-md-4 control-label">Last Name <span class="error">*</span></label>
                  <div class="col-md-8">
                    <div class="input-group">
                      <input type="text" class="form-control" name="last_name" id="last_name" value="<?php echo set_value('last_name', $last_name); ?>" />
                    </div>
                    <?php echo form_error('last_name');?> </div>
                </div> -->                
                <div class="form-group">
                  <label class="col-md-4 control-label">Phone</label>
                  <div class="col-md-8">
                    <div class="input-group">

                      <input tabindex="4" type="text" class="form-control" name="phone" id="phone" value="<?php echo set_value('phone', $phone); ?>" />
                    </div>
                    <?php echo form_error('phone');?> </div>
                </div>
                <div class="form-group">
                  <label class="col-md-4 control-label">Zip</label>
                  <div class="col-md-8">
                    <div class="input-group">
                      <input tabindex="6" type="text" class="form-control" name="zip" id="zip" value="<?php echo set_value('zip', $zip); ?>" />
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-md-4 control-label">Website<span class="error"></span></label>
                  <div class="col-md-8">
                    <div class="input-group">
                      <input tabindex="8" type="text" class="form-control" name="website" id="website" value="<?php echo set_value('website', $website); ?>" />
                    </div>                    
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-md-4 control-label">Engagement Notes </label>
                  <div class="col-md-8 col-xs-12">
                    <textarea tabindex="10" rows="5" class="form-control " name="engagement_notes" id="engagement_notes"><?php echo set_value('engagement_notes', $engagement_notes); ?></textarea>
                  </div>
                </div>

                <!--<div class="form-group">
                  <label class="col-md-4 control-label">Billing Contact <span class="error">*</span></label>
                  <div class="col-md-8">
                    <div class="input-group">

                      <input tabindex="7" type="text" class="form-control" name="billing_contact" id="billing_contact" value="<?php echo set_value('billing_contact', $billing_contact); ?>" />
                    </div>
                    <?php echo form_error('billing_contact');?> </div>
                </div>-->
                
                <!--<div class="form-group">
                  <label class="col-md-4 control-label">General Notes</label>
                  <div class="col-md-8 col-xs-12">
                    <textarea tabindex="12" rows="5" class="form-control" name="general_notes" id="general_notes"><?php echo set_value('general_notes', $general_notes); ?></textarea>
                  </div>
                </div>-->
              </div>
            </div>
          </div>
          <div class="panel-footer">
            <button tabindex="12" class="btn btn-primary pull-left">Submit</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- END PAGE CONTENT WRAPPER --> 
