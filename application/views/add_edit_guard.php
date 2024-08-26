
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
                            <form class="form-horizontal" action="" method="POST" enctype="multipart/form-data">
                            
                           <div class="page-title">
                                    <h2><a  href="<?php echo site_url('guard');?>" class="btn btn-primary"><span class="fa fa-arrow-circle-o-left"></span>Back</a>
                                    <?php echo $pageHeading; ?></h2>
                                </div> 
                            
                            <div class="panel panel-default">
                                
                                   <div class="panel-body">                                                                        
                                    <p class="badge badge-success"><span class="fa fa-user"></span> <strong>Bio Information</strong></p>
                                    <div class="row">
                                        <div class="col-md-6">

                                            <div class="form-group">
                                                <label class="col-md-5 control-label">Company Name  <span class="error">*</span></label>
                                                <div class="col-md-7">                                            
                                                    <div class="input-group">
                                                        <select tabindex="1" class="form-control select" name="company_name" id="company_name" >
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
                                                <label class="col-md-5 control-label">First Name  <span class="error">*</span></label>
                                                <div class="col-md-7">                                            
                                                    <div class="input-group">
                                                        <input tabindex="2"  type="text" class="form-control" name="first_name" id="first_name" value="<?php echo set_value('first_name', $first_name); ?>" />
                                                    </div>
                                                    <?php echo form_error('first_name');?>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-5 control-label">Address<span class="error">*</span></label>
                                                <div class="col-md-7">                                            
                                                    <div class="input-group">
                                                        <input tabindex="4"  type="text" class="form-control" name="address" id="address" value="<?php echo set_value('address', $address); ?>" />
                                                    </div>
                                                    <?php echo form_error('address');?>
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label class="col-md-5 control-label">Mobile <span class="error">*</span></label>
                                                <div class="col-md-7">                                            
                                                    <div class="input-group">
                                                        <input tabindex="6"  type="text" class="form-control" name="mobile" id="mobile" value="<?php echo set_value('mobile', $mobile); ?>" />
                                                    </div>    
                                                    <?php echo form_error('mobile');?>
                                                </div>                                                
                                            </div>                                            
                                        </div>

                                        <div class="col-md-6" style="margin-top: 50px;">
                                            <div class="form-group">
                                                <label class="col-md-5 control-label">Last Name  <span class="error">*</span></label>
                                                <div class="col-md-7">                                            
                                                    <div class="input-group">
                                                        <input tabindex="3"  type="text" class="form-control" name="last_name" id="last_name" value="<?php echo set_value('last_name', $last_name); ?>" />
                                                    </div>     
                                                    <?php echo form_error('last_name');?>
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label class="col-md-5 control-label">Zipcode</label>
                                                <div class="col-md-7">                                            
                                                    <div class="input-group">
                                                        <input tabindex="5"  type="text" class="form-control" name="zipcode" id="zipcode" value="<?php echo set_value('zip', $zip); ?>" />
                                                    </div>
                                                </div>
                                            </div>
                                                                                         
                                            <div class="form-group">
                                                <label class="col-md-5 control-label">Phone<span class="error"></span></label>
                                                <div class="col-md-7">                                            
                                                    <div class="input-group">
                                                        <input tabindex="7"  type="text" class="form-control" name="phone" id="phone" value="<?php echo set_value('phone', $phone); ?>" />
                                                    </div>                                                    
                                                </div>
                                            </div>

                                        </div>                                        
                                    </div>

                                    <p class="badge badge-warning"  style="margin-top:20px;"><span class="fa fa-pencil"></span> <strong>Qualifications</strong></p>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-5 control-label">Language Known</label>
                                                <div class="col-md-7">                                            
                                                    <div class="input-group">
                                                        <!--<input type="text" class="form-control" name="language_known" id="language_known" value="<?php echo set_value('language_known', $language_known); ?>" />-->
                                                        <label>Hindi<input tabindex="9"  type="checkbox" class="form-control" name="language_known[]" id="language_known" value="Hindi" <?php if(in_array("Hindi", $language_known)){  echo "Checked='true'";  } ?> /></label>
                                                        <label>English<input tabindex="10" type="checkbox" class="form-control" name="language_known[]" id="language_known" value="English" <?php if(in_array("English", $language_known)){  echo "Checked='true'";  } ?> /></label>
                                                        <label>Other<input tabindex="11" type="checkbox" class="form-control" name="language_known[]" id="language_known"  value="Other" <?php if(in_array("Other", $language_known)){  echo "Checked='true'";  } ?> /></label>
                                                    </div>                                                    
                                                </div>
                                            </div>

                                            <!--<div class="form-group">
                                                <label class="col-md-5 control-label">Experience</label>
                                                <div class="col-md-7">                                            
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" name="experience" id="experience" value="<?php echo set_value('experience', $experience); ?>" />                                                        
                                                    </div>                                                           
                                                </div>
                                            </div>-->
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-5 control-label">Post  <span class="error">*</span></label>
                                                <div class="col-md-7">                                            
                                                    <div class="input-group">
                                                        <input tabindex="12"  type="text" class="form-control" name="post" id="post" value="<?php echo set_value('post', $post); ?>" />
                                                    </div>
                                                    <?php echo form_error('post');?>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-5 control-label">Technical Qualification</label>
                                                <div class="col-md-7">                                            
                                                    <div class="input-group">
                                                        <input tabindex="13" type="text" class="form-control" name="technical_qualification" id="technical_qualification" value="<?php echo set_value('technical_qualification', $technical_qualification); ?>" />
                                                    </div>       
                                                    <?php echo form_error('technical_qualification');?>
                                                </div>
                                            </div>
                                        <!--<div class="form-group">
                                                <label class="col-md-5 control-label">Upload Files</label>
                                                <div class="col-md-7">                                            
                                                    <div class="input-group">                                                        
                                                        <input type="file" class="form-control" size="20" name="guard_upload_files[]" id="guard_upload_files" value="" multiple/>
                                                    </div>                                                           
                                                </div>
                                            </div>-->
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-body">      
                                    <div class="row">   
                                        <table id="skill_table" >
                                            <tr class="col-md-12">
                                                <td class="col-md-6">                                                    
                                                    <div class="form-group">                                                            
                                                        <select class="form-control select" name="skill[]" >
                                                                <?php if(count($skillData)>0)
                                                                { ?><option value="" >Select Skill</option>
                                                                <?php
                                                                for($i=0;$i<count($skillData);$i++)
                                                                { ?>
                                                                    <option value="<?php echo $skillData[$i]->skill_id;?>"
                                                                        <?php /*if($skillData[$i]->skill_id == $skill_id)
                                                                            { echo 'selected="selected"';} */
                                                                        ?> >
                                                                        <?php echo $skillData[$i]->skill_name;?>
                                                                    </option>
                                                                <?php 
                                                                } ?>
                                                                <?php
                                                            } ?>
                                                        </select>
                                                    </div>                                                    
                                                </td>
                                                <td class="col-md-6">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" name="experience[]"  value="" />
                                                    </div>
                                                </td>
                                            </tr>
                                        </table> 
                                        <a href="javascript:void(0);"  onclick="addMoreSkills();"><i class="fa fa-plus"></i>Add More Skills</a>
                                    </div>
                                </div>    
                                <div class="panel-body">      
                                    <div class="row">                                        
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="col-md-5 control-label">Document Type</label>
                                                <div class="col-md-7">                                            
                                                    <div class="input-group">                                                        
                                                        <select class="form-control select" name="document_type" id="document_type" >
                                                        <?php if(count($doc_type_ids)>0)
                                                        { ?><option value="" >Select Document Type</option>
                                                          <?php
                                                            for($i=0;$i<count($doc_type_ids);$i++)
                                                            { ?>
                                                                <option value="<?php echo $doc_type_ids[$i]->document_type_id;?>"
                                                                    <?php if($doc_type_ids[$i]->document_type_id == $doc_type_id)
                                                                        { echo 'selected="selected"';} 
                                                                    ?> >
                                                                    <?php echo $doc_type_ids[$i]->document_type;?>
                                                                </option>
                                                                    
                                                            <?php 
                                                            } ?>
                                                            <?php
                                                        } ?>
                                                        </select>
                                                    </div>                                                           
                                                    <?php echo form_error('document_type');?>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-4">                                           
                                            <div class="form-group">
                                                <label class="col-md-5 control-label">Doc Content</label>
                                                <div class="col-md-7">                                            
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" name="document_content[]" id="document_content" value="" />
                                                    </div>                                                           
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">                                            
                                                <div class="col-md-7">                                            
                                                    <div class="input-group">
                                                        <input type="file" class="form-control" size="20" name="guard_upload_files[]" id="guard_upload_files" value="" multiple/>                                                       
                                                    </div>                                                           
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

                           <!-- <form action="#" method="post" id="theForm">

                                    <fieldset id="start">
                                
                                </fieldset>                                
                                <label id="aElement" onclick="addInput('this','theForm','10');">Add more fields</label>
                               
                                
                            </form>-->
                            
                        </div>
                    </div>
                </div>
                <!-- END PAGE CONTENT WRAPPER -->  
               