        <!-- PAGE CONTENT WRAPPER -->                
        <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>        
                <div class="page-title">
                                    <h2><a  href="<?php echo site_url('user/users');?>" class="btn btn-primary"><span class="fa fa-arrow-circle-o-left"></span>Back</a>
                                    <?php echo $pageHeading; ?></h2>
                </div>
                <div class="page-tabs">                    
                    <?php                     
                    $userId = base64_decode($this->uri->segment(3));                    
                    if($userId!='')
                    {
                    ?>                        
                        <a href="<?php echo ($userId!='') ? 'user/addEditUsers/'.$this->uri->segment(3) : 'javascript:void(0)';?>">Bio-Data</a>
                        <a href="#second-tab" class="active">Skills/Education/Experience</a>
                        <a href="<?php echo ($userId!='') ? 'user/financial/'.$this->uri->segment(3) : 'javascript:void(0)';?>">Financial/Banking Detail</a>
                        <a href="<?php echo ($userId!='') ? 'user/documents/'.$this->uri->segment(3) : 'javascript:void(0)';?>">Documents</a>
                    <?php
                    }
                    ?>    
                </div>
                <div class="page-content-wrap page-tabs-item active" id="second-tab">                
                    <div class="row">
                        <div class="col-md-12">
                            <?php if($this->session->flashdata('successMessage')){?>
                            <div class="alert alert-success" >
                                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                <strong><?php echo $this->session->flashdata('successMessage'); ?></strong> 
                            </div>
                            <?php } ?>
                            <form class="form-horizontal" action="" method="POST" id="skillform" >
                            <div class="panel panel-default">
                                
                                <div class="panel-body panel-body-table">                                    
                                    <div class="row">                                        
                                        <div class="col-md-12">                                            
                                            <div class="panel-heading">                                                                                               
                                                <span class="label label-warning label-form">Work Experience</span>
                                                <a title="Add Work Experience" href="javascript:void(0);" class="btn btn-success btn-condensed" onclick="addMoreExperience('<?php echo site_url(); ?>');"><i class="fa fa-plus"></i></a>
                                            </div>
                                            <div  class="panel-body panel-body-table">
                                                <div class="table-responsive">
                                                    <table id="experience_table" class="table table-bordered table-striped table-actions">
                                                        <thead>
                                                            <tr>
                                                                <th>Company Name</th>
                                                                <th>Designation</th>
                                                                <th>From</th>
                                                                <th>To</th>
                                                                <th>Salary Drawn</th>
                                                                <th>Leaving Reason</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        <?php                                                        
                                                        for($j=0;$j<$experience_count;$j++)
                                                        {
                                                            $veryfy = 0;
                                                            if(isset($experience_data[$j]->verified_by) && !empty($experience_data[$j]->verified_by)){
                                                                $veryfy = 1;
                                                            }
                                                            if(isset($exp_num[$j]) && !empty($exp_num[$j]) || $postFlag == ''){
                                                            ?>
                                                            <tr id="exp_row_<?php echo $j+1; ?>">
                                                                <td class="text-center">
                                                                    <input type="hidden" value="<?php echo set_value('exp_num['.$j.']',($j+1));  ?>" name="exp_num[<?php echo $j;  ?>]" id="exp_num_<?php echo $j+1;  ?>"  />
                                                                    <input type="hidden" value="<?php echo set_value('exp_verify_num['.$j.']',($veryfy));  ?>" name="exp_verify_num[<?php echo $j;  ?>]" id="exp_verify_num<?php echo $j+1;  ?>" />
                                                                    <select tabindex="6" class="form-control required_company" name="company_name[<?php echo $j; ?>]" id="company_name<?php echo $j+1; ?>" <?php if(isset($experience_data[$j]->verified_by)&&!empty($experience_data[$j]->verified_by)){ echo 'disabled="disabled"';} ?> >                                                            
                                                                        <?php if(count($company_names)>0)
                                                                        { ?><option value="" >Select Company Name</option>
                                                                        <?php
                                                                        for($i=0;$i<count($company_names);$i++)
                                                                        { ?>
                                                                            <option value="<?php echo $company_names[$i]->company_id;?>"
                                                                                <?php if(($company_names[$i]->company_id == $experience_data[$j]->company_id) || ($exp_company_name[$j] == $company_names[$i]->company_id))
                                                                                    { echo 'selected="selected"';} 
                                                                                ?> >
                                                                                <?php echo $company_names[$i]->company_name;?>
                                                                            </option>                                                                    
                                                                        <?php 
                                                                        } ?>
                                                                        <?php
                                                                    } ?>
                                                                    </select>
                                                                    <?php echo form_error('company_name['.$j.']'); ?>
                                                                </td>
                                                                <td>                                                                    
                                                                    <select tabindex="7" class="form-control required_designation" name="experience_des[<?php echo $j; ?>]" id="experience_des<?php echo $j+1; ?>" <?php if(isset($experience_data[$j]->verified_by)&&!empty($experience_data[$j]->verified_by)){ echo 'disabled="disabled"';} ?>>
                                                                        <?php if(count($experience_designation)>0)
                                                                        { ?><option value="" >Select Designation</option>
                                                                        <?php
                                                                        for($i=0;$i<count($experience_designation);$i++)
                                                                        { ?>
                                                                            <option value="<?php echo $experience_designation[$i];?>"                                                                                    
                                                                                <?php if(($experience_designation[$i] == $experience_data[$j]->designation) || ($experience_designation[$i] == $exp_designation[$j]))
                                                                                { echo 'selected="selected"'; } 
                                                                                ?>
                                                                               >
                                                                                <?php echo $experience_designation[$i];?>
                                                                            </option>                                                                    
                                                                        <?php 
                                                                        } ?>
                                                                        <?php
                                                                    } ?>
                                                                    </select>        
                                                                    <?php echo form_error('experience_des['.$j.']');?>
                                                                </td>
                                                                <td>
                                                                    <input tabindex="8" type="text" class="form-control  required_fromdate datepicker" id="start_date<?php echo $j+1; ?>" name="fromdate[<?php echo $j; ?>]" value="<?php if(isset($experience_data[$j]->start_date) && $experience_data[$j]->start_date !='0000-00-00 00:00:00'){ echo set_value('fromdate['.$j.']', date('Y-m-d',strtotime($experience_data[$j]->start_date))); }else { echo set_value('fromdate['.$j.']'); } ?>" onchange="daterangeto(<?php echo $j+1; ?>);" <?php if(isset($experience_data[$j]->verified_by)&&!empty($experience_data[$j]->verified_by)){ echo 'disabled="disabled"';} ?> data-date-end-date="0d" />
                                                                    <?php echo form_error('fromdate['.$j.']');?>
                                                                </td>
                                                                <td>
                                                                    <input tabindex="9" type="text" class="form-control required_todate datepicker" id="end_date<?php echo $j+1; ?>" name="todate[<?php echo $j; ?>]" value="<?php if( isset($experience_data[$j]->end_date) && $experience_data[$j]->end_date !='0000-00-00 00:00:00'){ echo set_value('todate['.$j.']', date('Y-m-d',strtotime($experience_data[$j]->end_date))); }else { echo set_value('todate['.$j.']'); } ?>"  onchange="daterangefrom(<?php echo $j+1; ?>);"<?php if(isset($experience_data[$j]->verified_by)&&!empty($experience_data[$j]->verified_by)){ echo 'disabled="disabled"';} ?> data-date-end-date="0d" />
                                                                    <?php echo form_error('todate['.$j.']');?>
                                                                </td>
                                                                <td>
                                                                    <input tabindex="10" type="text" class="form-control required_salary" id="salary_drawn<?php echo $j+1; ?>" name="salary_drawn[<?php echo $j; ?>]"  value="<?php if( isset($experience_data[$j]->salary_drawn) && $experience_data[$j]->salary_drawn !='0' || $experience_data[$j]->salary_drawn != 0){ echo set_value('salary_drawn['.$j.']', $experience_data[$j]->salary_drawn); } else { echo set_value('salary_drawn['.$j.']'); } ?>" <?php if(isset($experience_data[$j]->verified_by)&&!empty($experience_data[$j]->verified_by)){ echo 'disabled="disabled"';} ?>/>
                                                                    <?php echo form_error('salary_drawn['.$j.']');?>
                                                                </td>
                                                                <td>                                                                    
                                                                    <select tabindex="6" class="form-control required_reason" id="reason_for_leaving<?php echo $j+1; ?>" name="reason_for_leaving[<?php echo $j; ?>]" <?php if(isset($experience_data[$j]->verified_by)&&!empty($experience_data[$j]->verified_by)){ echo 'disabled="disabled"';} ?> >
                                                                        <?php if(count($leaving_reason)>0)
                                                                        { ?><option value="" >Select Leaving Reason</option>
                                                                        <?php
                                                                        for($i=0;$i<count($leaving_reason);$i++)
                                                                        { ?>
                                                                            <option value="<?php echo $leaving_reason[$i];?>"
                                                                                <?php if(($leaving_reason[$i] == $experience_data[$j]->leaving_reason) || ($exp_leaving_reason[$j] == $leaving_reason[$i]))
                                                                                { echo 'selected="selected"'; } 
                                                                                ?>
                                                                                    >
                                                                                <?php echo $leaving_reason[$i];?>
                                                                            </option>                                                                    
                                                                        <?php 
                                                                        } ?>
                                                                        <?php
                                                                    } ?>
                                                                    </select>
                                                                    <?php echo form_error('reason_for_leaving['.$j.']');?>
                                                                </td>
                                                                <td>                                                                    
                                                                    <a title="Remove" href="javascript:void(0);" class="btn btn-success btn-condensed" onclick="removeExperience('<?php echo site_url(); ?>',<?php echo $j+1; ?>,'<?php if(isset($experience_data[$j]->employee_experience_id)&&!empty($experience_data[$j]->employee_experience_id)){ echo $experience_data[$j]->employee_experience_id; } ?>');"><i class="fa fa-times"></i></a>
                                                                </td>
                                                            </tr>
                                                        <?php }
                                                        }  
                                                        
                                                        if($experience_count == 0){
                                                            echo '<tr id="no_exp"><td colspan="7">No Experience!</td></tr>';
                                                            
                                                        }
                                                        
                                                        
                                                        ?>
                                                        
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>                               
                                
                                
                                <div class="panel-body panel-body-table">                                    
                                    <div class="row">                                        
                                        <div class="col-md-12">                                            
                                            <div class="panel-heading">                                                                                               
                                                <span class="label label-info label-form">Skills</span>
                                                <a title="Add Skill" href="javascript:void(0);" class="btn btn-success btn-condensed" onclick="addMoreSkills('<?php echo site_url(); ?>');"><i class="fa fa-plus"></i></a>
                                            </div>
                                            <div  class="panel-body panel-body-table">
                                                <div class="table-responsive">
                                                    <table id="skill_table" class="table table-bordered table-striped table-actions">
                                                        <thead>
                                                            <tr>
                                                                <th>Select Skill</th>                                                       
                                                                <th width="10%">Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        <?php
                                                        
                                                                                                                   
                                                        for($j=0;$j<$skill_count;$j++)
                                                        {
                                                             if(isset($skill_num[$j]) && !empty($skill_num[$j]) || $postFlag == ''){
                                                            ?>
                                                            <tr id="skill_row_<?php echo $j+1; ?>">
                                                                <td class="text-center">
                                                                    <input type="hidden" value="<?php echo set_value('skill_num['.$j.']',($j+1));  ?>" name="skill_num[<?php echo $j;  ?>]" id="skill_num_<?php echo $j+1;  ?>" />
                                                                    <select tabindex="6" class="form-control" name="skill_name[<?php echo $j; ?>]" id="skill_name<?php echo $j+1; ?>">                                                            
                                                                        <?php if(count($employeeSkillTypes)>0)
                                                                        { ?><option value="" >Select Skill</option>
                                                                        <?php
                                                                        for($i=0;$i<count($employeeSkillTypes);$i++)
                                                                        { ?>
                                                                            <option value="<?php echo $employeeSkillTypes[$i]->skill_id;?>"
                                                                                <?php if($employeeSkillTypes[$i]->skill_id == $skill_data[$j])
                                                                                    { echo 'selected="selected"';} 
                                                                                ?> >
                                                                                <?php echo $employeeSkillTypes[$i]->skill_name;?>
                                                                            </option>                                                                    
                                                                        <?php 
                                                                        } ?>
                                                                        <?php
                                                                    } ?>
                                                                    </select>                                                                    
                                                                    <?php echo '<span style="float:left;">'.form_error('skill_name['.$j.']').'</span>';?>
                                                                </td>                                                               
                                                                <td>                                                                    
                                                                    <a  title="Remove" href="javascript:void(0);" class="btn btn-success btn-condensed" onclick="removeSkills('<?php echo site_url(); ?>',<?php echo $j+1; ?>,'<?php if(isset($employee_skill_data[$j])&&!empty($employee_skill_data[$j])){ echo $employee_skill_data[$j]; }; ?>');"><i class="fa fa-times"></i></a>
                                                                </td>
                                                            </tr>
                                                        <?php }
                                                        }
                                                        
                                                        if($skill_count == 0){
                                                            echo '<tr id="no_skill"><td colspan="2">No Skill!</td></tr>';
                                                            
                                                        }
                                                        
                                                        
                                                        
                                                        ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                
                                <div class="panel-body">
                                 <div class="panel-heading" style="margin-bottom:10px;">
                                    <span class="label label-success label-form">Education</span>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6    ">
                                            <div class="form-group">
                                                <label class="col-md-5 control-label">Educational Qualification<span class="error">*</span></label>
                                                <div class="col-md-7">                                            
                                                    <div class="input-group">                                                        
                                                        <select tabindex="6" class="form-control" name="education_qualification[]" id="education_qualification" multiple="multiple">
                                                        <?php           
                                                        if(count($education_qualification)>0)
                                                        {
                                                            for($i=0;$i<count($education_qualification);$i++)
                                                            { ?>                                                                
                                                                <option value="<?php echo $education_qualification[$i]->qualification_id; ?>"
                                                                   <?php
                                                                        for($k=0;$k<count($qualification);$k++)
                                                                        {
                                                                            if($qualification[$k] == $education_qualification[$i]->qualification_id)
                                                                            { echo 'selected="selected"';}
                                                                        }
                                                                    ?> 
                                                                >
                                                                    <?php echo $education_qualification[$i]->qualification_name; ?>
                                                                </option> 
                                                              <?php
                                                            }
                                                        }
                                                        else
                                                        {?>
                                                            <option value=''>Records are not available...!</option>
                                                         <?php   
                                                        }
                                                        ?>
                                                        </select>
                                                    </div>     
                                                    <?php echo form_error('education_qualification');?>
                                                </div>
                                            </div>
                                        </div>
                                       
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-5 control-label">Technical Qualification<span class="error">*</span></label>
                                                <div class="col-md-7">                                            
                                                    <div class="input-group">
                                                        <select tabindex="6" class="form-control" name="technical_qualification[]" id="technical_qualification" multiple="multiple">
                                                        <?php           
                                                        if(count($technical_qualification)>0)
                                                        {
                                                            for($i=0;$i<count($technical_qualification);$i++)
                                                            { ?>                                                                
                                                                <option value="<?php echo $technical_qualification[$i]->qualification_id; ?>"
                                                                <?php
                                                                        for($k=0;$k<count($qualification);$k++)
                                                                        {
                                                                            if($qualification[$k] == $technical_qualification[$i]->qualification_id)
                                                                            { echo 'selected="selected"';}
                                                                        }
                                                                    ?> 
                                                                 >
                                                                    <?php echo $technical_qualification[$i]->qualification_name; ?>
                                                                </option> 
                                                              <?php
                                                            }
                                                        }
                                                        else
                                                        {?>
                                                            <option value=''>Records are not available...!</option>
                                                         <?php   
                                                        }
                                                        ?>
                                                        </select>
                                                    </div>     
                                                    <?php echo form_error('technical_qualification');?>
                                                </div>
                                            </div> 
                                        </div>
                                    </div>
                                </div>
                                
                                
                                <div class="panel-body panel-body-table">                                    
                                    <div class="row">                                        
                                        <div class="col-md-12">                                            
                                            <div class="panel-heading">                                                                                               
                                                <span class="label label-success label-form">Languages Known</span>
                                                <a title="Add Language" href="javascript:void(0);" class="btn btn-success btn-condensed" onclick="addLanguage('<?php echo site_url(); ?>');"><i class="fa fa-plus"></i></a>
                                            </div>
                                            <div  class="panel-body panel-body-table">
                                                <div class="table-responsive">
                                                    <table id="languages_table" class="table table-bordered table-striped table-actions">
                                                        <thead>
                                                            <tr>
                                                                <th>Languages</th>
                                                                <th width="10%">Read</th>
                                                                <th width="10%">Write</th>
                                                                <th width="10%">Speak</th>
                                                                <th width="10%">Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        <?php 
                                                            for($j=0;$j<$language_count;$j++){  
                                                                  if(isset($lang_num[$j]) && !empty($lang_num[$j]) || $postFlag == ''){
                                                                
                                                                
                                                                ?>
                                                            <tr id="language_row_<?php echo $j+1; ?>">
                                                                    <td class="text-center">
                                                                    <input type="hidden" value="<?php echo set_value('lang_num['.$j.']',($j+1));  ?>" name="lang_num[<?php echo $j;  ?>]" id="lang_num<?php echo $j+1;  ?>" />
                                                                    <select tabindex="6" class="form-control" name="languages[<?php echo $j; ?>]" id="languages<?php echo $j+1; ?>" onChange="addNewLanguage('<?php echo site_url(); ?>','<?php echo $j+1; ?>');">
                                                                        <?php           
                                                                        if(count($languages)>0)
                                                                        {
                                                                            ?><option value="" >Select Language</option><?php 
                                                                            for($i=0;$i<count($languages);$i++)
                                                                            { ?>                                                                
                                                                                <option value="<?php echo $languages[$i]->language_id; ?>"
                                                                                     <?php
                                                                                        if(($languages[$i]->language_id == $emp_language[$j]->language_id) || ($emp_language_name[$j] == $languages[$i]->language_id))
                                                                                        { echo 'selected="selected"';} 
                                                                                ?>     
                                                                                    >
                                                                                    <?php echo $languages[$i]->language_name; ?>
                                                                                </option> 
                                                                              <?php
                                                                            } ?>
                                                                                <option value="AOL"> Add Other Language</option> <?php
                                                                        }
                                                                        else
                                                                        {?>
                                                                            <option value=''>Records are not available...!</option>
                                                                         <?php   
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                    <?php echo '<span style="float:left;">'.form_error('languages['.$j.']').'</span>'; ?>    
                                                                </td>
                                                                <td><input tabindex="3" class="form-control" type="checkbox" name="language<?php echo $j; ?>[]" value="1" <?php if(($emp_language[$j]->read=='1') || (in_array(1,$emp_proffeciency[$j]))){  echo "Checked='true'";  }?>/></td>
                                                                <td><input tabindex="4" class="form-control" type="checkbox" name="language<?php echo $j; ?>[]" value="2" <?php if(($emp_language[$j]->write=='1') ||(in_array(2,$emp_proffeciency[$j]))){  echo "Checked='true'";  } ?>/></td>
                                                                <td><input tabindex="5" class="form-control" type="checkbox" name="language<?php echo $j; ?>[]" value="3" <?php if(($emp_language[$j]->speak=='1') || (in_array(3,$emp_proffeciency[$j]))){  echo "Checked='true'";  } ?>/></td>
                                                                <td>                                                                    
                                                                    <a  title="Remove"  href="javascript:void(0);" class="btn btn-success btn-condensed" onclick="removeLanguage('<?php echo site_url();?>',<?php echo $j+1; ?>,'<?php echo $emp_language[$j]->employee_language_id;  ?>');"><i class="fa fa-times"></i></a>
                                                                </td>
                                                            </tr>   
                                                                  <?php }
                                                                } 
                                                                
                                                                if($language_count == 0){
                                                                      echo '<tr id="no_language"><td colspan="5">No language!</td></tr>';
                                                                }
                                                            ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>                                
                                
                                <div class="panel-body">
                                <div class="panel-heading">
                                    <span class="label label-info label-form">References</span>
                                </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label>Reference 1</label>
                                            <div class="form-group">
                                                <label class="col-md-4 control-label">Name</label>
                                                <div class="col-md-8">                                            
                                                    <div class="input-group">                                                        
                                                        <input tabindex="12" type="text" class="form-control" name="ref_name_one" id="ref_name_one" value="<?php echo set_value('ref_name_one', $ref_name_one); ?>"/>
                                                    </div>     
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-4 control-label">Address</label>
                                                <div class="col-md-8">                                            
                                                    <div class="input-group">                                                        
                                                        <input tabindex="13" type="text" class="form-control" name="ref_address_one" id="ref_address_one" value="<?php echo set_value('ref_add_one', $ref_add_one); ?>"/>
                                                    </div>     
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label class="col-md-4 control-label">Designation</label>
                                                <div class="col-md-8">                                            
                                                    <div class="input-group">                                                        
                                                        <input tabindex="14" type="text" class="form-control" name="ref_post_one" id="ref_post_one" value="<?php echo set_value('ref_post_one', $ref_post_one); ?>"/>
                                                    </div>     
                                                </div>
                                            </div>
                                        </div>           
                                        
                                        <div class="col-md-6">
                                            <label>Reference 2</label>
                                            <div class="form-group">
                                                <label class="col-md-4 control-label">Name</label>
                                                <div class="col-md-8">                                            
                                                    <div class="input-group">                                                        
                                                        <input tabindex="15" type="text" class="form-control" name="ref_name_two" id="ref_name_two" value="<?php echo set_value('ref_name_two', $ref_name_two); ?>"/>
                                                    </div>                                                         
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-4 control-label">Address</label>
                                                <div class="col-md-8">                                            
                                                    <div class="input-group">                                                        
                                                        <input tabindex="16" type="text" class="form-control" name="ref_address_two" id="ref_address_two" value="<?php echo set_value('ref_add_two', $ref_add_two); ?>"/>
                                                    </div>                                                         
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label class="col-md-4 control-label">Designation</label>
                                                <div class="col-md-8">                                            
                                                    <div class="input-group">                                                        
                                                        <input tabindex="17" type="text" class="form-control" name="ref_post_two" id="ref_post_two" value="<?php echo set_value('ref_post_two', $ref_post_two); ?>"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="panel-footer">
                                    <input type="hidden" value="<?php echo $skill_count; ?>" name="skill_count" id="skill_count" />
                                    <input type="hidden" value="<?php echo $experience_count; ?>" name="exp_count" id="exp_count" />
                                    <input type="hidden" value="<?php echo $language_count; ?>" name="language_count" id="language_count" />
                                    <button tabindex="18" class="btn btn-primary pull-left" >Submit</button>
                                </div>
                            </div>
                            </form>
                        </div>
                    </div>
                
                </div>

                <!-- END PAGE CONTENT WRAPPER -->  
                
                
          <!-- MESSAGE BOX-->
        <div class="message-box animated fadeIn" data-sound="alert" id="mb-update-status">
            <div class="mb-container">
                <div class="mb-middle">
                    <div class="mb-title" id='published-title'></div>
                    <div class="mb-content" style="margin-bottom:10px;">
                        <p id='update-msg-publish' class='mb-title' style='margin-bottom:20px;'>Do you really want to add new language?</p>        

                         <div class="form-group" id="display_remark" >
                             <label class="col-md-3 control-label" >New Language</label>
                            <div class="col-md-8">                                                                                            
                                <input type="text" tabindex="1" class="form-control" name="new_language_name" id="new_language_name"/>
                                 <div class="error" id="other_language" style="float: left;display: none;">Please enter the language name.</div>
                            </div>   
                            
                        </div>
                    </div>
                    <div class="mb-footer">
                        <div class="pull-right">
                            <a id="publish-yes" href="javascript:void(0);" class="btn btn-success btn-lg">Yes</a>
                            <button id="publish-no" class="btn btn-default btn-lg mb-control-close">No</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END MESSAGE BOX-->
<script>

<?php if(count($company_names)>0){ ?>
        companyDropdownOption += '<option value="" >Select Company Name</option>';
        <?php   for($i=0;$i<count($company_names);$i++){ ?>
                    companyDropdownOption += '<option value="<?php echo $company_names[$i]->company_id;?>"><?php echo addslashes($company_names[$i]->company_name); ?></option>';                                                                    
        <?php   } ?>
<?php    } ?> 
 
<?php if(count($experience_designation)>0){ ?>
            designationDropdown +=  '<option value="" >Select Designation</option>';
            <?php   for($i=0;$i<count($experience_designation);$i++){ ?>
                    designationDropdown +=  '<option value="<?php echo $experience_designation[$i];?>"><?php echo addslashes($experience_designation[$i]);?></option>';                                                                    
 <?php   } ?>
<?php    } ?>

<?php if(count($leaving_reason)>0){ ?>
            reasonDropdown += '<option value="" >Select Leaving Reason</option>';
    <?php for($i=0;$i<count($leaving_reason);$i++){ ?>
        reasonDropdown += '<option value="<?php echo $leaving_reason[$i];?>" ><?php echo addslashes($leaving_reason[$i]);?></option>';                                                                    
    <?php } } ?>
var skillDropdownOption = '';
<?php if(count($employeeSkillTypes)>0){ ?>
    skillDropdownOption += '<option value="" >Select Skill</option>';
    <?php   for($i=0;$i<count($employeeSkillTypes);$i++){ ?>
                skillDropdownOption += '<option value="<?php echo $employeeSkillTypes[$i]->skill_id;?>"  ><?php echo $employeeSkillTypes[$i]->skill_name;?></option>';                                                                    
    <?php   }
        } ?>
var languageDropdownOption = '';
<?php if(count($languages)>0){ ?>
    languageDropdownOption += '<option value="" >Select Language</option>';
    <?php   for($i=0;$i<count($languages);$i++){ ?>
                languageDropdownOption += '<option value="<?php echo $languages[$i]->language_id;?>"  ><?php echo $languages[$i]->language_name;?></option>';                                                                    
    <?php   } ?>
            languageDropdownOption += '<option value="AOL"> Add Other Language</option>'; 
    <?php   }else{ ?>
            languageDropdownOption += '<option value=''>Records are not available...!</option>';
    <?php } ?>    
</script>