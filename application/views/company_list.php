
<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">
    <form action="" method="post" name="list_form" id="list_form">
        <input type="hidden" name="page" value="<?php if(isset($page)) { echo $page; } else {  echo 1; }  ?>" id="page" />

    <!-- START MANY COLUMNS  -->
    <div class="row">
        <div class="col-md-12">
       <div class="page-title">
                    <h2>Company List  <?php if(in_array('add_company', $tasks)){ ?> 
                    <a  href="<?php echo site_url('company/addEditCompany'); ?>" class="btn btn-primary" style="float:right;">Add Company</a></h2>
                   
                    <?php } ?>
</div>     <div class="panel panel-default">

                
                <?php if($this->session->flashdata('successMessage')){?>
                    <div class="alert alert-success" >
                        <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <strong><?php echo $this->session->flashdata('successMessage'); ?></strong> 
                    </div>
                    <?php } ?>
                <div class="panel-body panel-body-table">
                    
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-actions">
                            <thead>
                                <tr>
                                    <th width="17%">Company Name</th>
                                 
                                    <th width="17%" height="10%">Email</th>
                                    <th width="26%">Address</th>
                                    <th width="10%">Contact No.</th>
                                    <th width="12%">Contact Person</th>
                                    <!--<th width="14%">License Code</th>-->
                                    <?php if(in_array('question_list', $tasks) || in_array('question_group_list', $tasks)|| in_array('company_office_list', $tasks) || in_array('edit_company', $tasks) || in_array('update_company_status', $tasks)){ ?>

                                    <th width="18%">Actions</th>                                  

                                    <?php } ?>

                                </tr>
                            </thead>
                            <tbody>
                                <?php if(count($companyData)>0){
                                        for($i=0;$i<count($companyData);$i++){
                                    
                                    ?>
                                <tr>
                                    <td><?php echo $companyData[$i]->company_name; ?></td>            
                                     <td class="email"><?php echo $companyData[$i]->email_id; ?></td>            
                                    <td><?php echo $companyData[$i]->address; 
                                              echo $companyData[$i]->city?', '.$companyData[$i]->city:' ';
                                              echo $companyData[$i]->state?', '.$companyData[$i]->state:' ';
                                              echo $companyData[$i]->country?', '.$companyData[$i]->country:'';
                                              echo $companyData[$i]->zipcode?', '.$companyData[$i]->zipcode:'';
                                    ?></td>
                                    <td><?php echo $companyData[$i]->contact_number; ?></td>
                                    <td><?php echo $companyData[$i]->contact_person; ?></td>
                                    <!--<td><?php echo $companyData[$i]->license_code; ?></td>-->
                                    <?php if(in_array('question_list', $tasks) || in_array('question_group_list', $tasks)|| in_array('company_office_list', $tasks) || in_array('edit_company', $tasks) || in_array('update_company_status', $tasks) || in_array('manage_company', $tasks)|| in_array('company_employee_experience_list', $tasks)){ ?>
                                     <td>
                                        <?php if(in_array('question_list', $tasks)){ ?>  
                                        <a title="Company Question" class="btn btn-danger btn-condensed" href="<?php echo site_url('question/questionList/'. base64_encode($companyData[$i]->company_id)); ?>" ><span class="fa fa-question"></span></a>
                                        <?php } ?>
                                            
                                        <?php if(in_array('question_group_list', $tasks)){ ?> 
                                        <a title="Company Question group" class="btn btn-danger btn-condensed" href="<?php echo site_url('question/questionGroupList/'. base64_encode($companyData[$i]->company_id)); ?>" ><span class="fa fa-book"></span></a>
                                        <?php } ?>
                                        
                                        <?php if(in_array('company_office_list', $tasks)){ ?> 
                                        <a title="Company Offices List" class="btn btn-danger btn-condensed" href="<?php echo site_url('company/company_office_list/'. base64_encode($companyData[$i]->company_id)); ?>" ><span class="fa fa-briefcase"></span></a>
                                        <?php } ?>
                                        
                                        <?php if(in_array('edit_company', $tasks)){ ?>  
                                        <a title="Edit" class="btn btn-danger btn-condensed" href="<?php echo site_url('company/addEditCompany/'. base64_encode($companyData[$i]->company_id)); ?>" ><span class="fa fa-pencil"></span></a>
                                        <?php } ?>
                                       <?php if(in_array('update_company_status', $tasks)){ ?> 
                                         <?php if($companyData[$i]->is_published){ ?>
                                         <a title="Click to Deactivate" id="comp<?php echo $companyData[$i]->company_id ; ?>" data-box="#mb-update-status"  class="mb-control btn btn-danger btn-condensed" href="javascript:void(0);" onclick="showPublishedStatusBox('<?php echo site_url(); ?>','<?php echo $companyData[$i]->company_id ; ?>',1,'<?php echo addslashes($companyData[$i]->company_name); ?>');" ><span class="fa fa-check"></span></a>
                                         <?php }else{ ?>
                                         <a title="Click to Activate" id="comp<?php echo $companyData[$i]->company_id ; ?>" data-box="#mb-update-status" class="mb-control btn btn-danger btn-condensed" href="javascript:void(0);" onclick="showPublishedStatusBox('<?php echo site_url(); ?>','<?php echo $companyData[$i]->company_id ; ?>',0,'<?php echo addslashes($companyData[$i]->company_name); ?>');" ><span class="fa fa-times"></span></a>
                                         <?php } ?>
                                         <?php } ?>
                                         
                                        <?php if(in_array('manage_company', $tasks)){ ?>  
                                         <a title="Manage Company" class="btn btn-danger btn-condensed" href="<?php echo site_url('company/manageCompany/'. base64_encode($companyData[$i]->company_id)); ?>" target="_blank" ><span class="fa fa-cog"></span></a>
                                        <?php } ?>
                                         
                                         <?php if(in_array('company_employee_experience_list', $tasks)){ ?>
                                         <a title="Company Employee Experience Verification" class="btn btn-danger btn-condensed" href="<?php echo site_url('company/employeeExperienceList/'. base64_encode($companyData[$i]->company_id)); ?>" target="_blank" ><span class="fa fa-users"></span></a>
                                        <?php } ?>
                                     </td>
                                     <?php } ?>
                                </tr>
                                <?php 
                                        }
                                    }else{ ?>
                                <tr ><td colspan="6">No Records!</td></tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END MANY COLUMNS  -->
</form>

    <?php if($total_record > $perPage){ ?>
    <ul class="pagination pagination-sm pull-right push-down-20 push-up-20">
        <li><?php echo $pagination->get_links();?></li>
    </ul>
    <?php } ?>
<!-- END PAGE CONTENT WRAPPER -->                                    
</div>      


<!-- MESSAGE BOX-->
        <div class="message-box animated fadeIn" data-sound="alert" id="mb-update-status">
            <div class="mb-container">
                <div class="mb-middle">
                    <div class="mb-title" id='published-title'></div>
                    <div class="mb-content">
                        <p id='update-msg-publish'>Are you sure you want to Activate ?</p>                    
                    </div>
                    <div class="mb-footer">
                        <div class="pull-right">
                            <a id="publish-yes" href="javascript:void(0);" class="btn btn-success btn-lg">Yes</a>
                            <button class="btn btn-default btn-lg mb-control-close">No</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END MESSAGE BOX-->
