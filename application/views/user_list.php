<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">
    <form action="" method="post" name="list_form" id="list_form">
        <input type="hidden" name="page" value="<?php if(isset($page)) {  echo $page; } else {  echo 1; }  ?>" id="page" />

    <!-- START MANY COLUMNS  -->
    <div class="row">
        <div class="col-md-12">


         
<div class="page-title">
              <div class="row-minus">
                <div class="col-md-3">
                <h2>Employees List</h2>
                <?php if(in_array('add_user', $tasks)){ ?> 
              </div>
              <div class="col-md-9">
                <div class="form-group top-input-box">
                    
                            <select class="form-control select" name="search_role_id" id="search_role_id">
                                <option value="">Select Employee Role</option>
                                <?php
                                    for($i=0;$i<count($roleDropDown);$i++)
                                    { 
                                        if($roleDropDown[$i]->role_id > 1){ ?>
                                        <option value="<?php echo $roleDropDown[$i]->role_id;?>"
                                        <?php if($roleDropDown[$i]->role_id == $f_user_role)
                                        { echo 'selected="selected"';} 
                                        ?>
                                        >
                                        <?php echo $roleDropDown[$i]->role_name; ?>
                                        </option>                                                                    
                                        <?php 
                                        }
                                    } ?>
                            </select>
               
                            <input class="form-control" placeholder="Employee Id" type="text"  name="emp_comp_id" value="<?php echo $emp_comp_id; ?>" /> 
                       
                            <button class="btn btn-primary">Filter</button>                                                        
               <a  href="<?php echo site_url('user/addEditUsers'); ?>" class="btn btn-primary" style="float:right;">Add New Employee</a>
                <?php } ?>
                </div>
                </div></div>
                
            <div class="panel panel-default">
                   <!-- Start searching filter -->

        

        <!-- End searching filter -->

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
                                    <th width="5%">Picture</th>                                    
                                    <th width="15%">Name/ID</th>                               
                                    <th width="15%">Address</th>
                                    <th width="20%">Email</th>
                                    <th>Contact Number</th>
                                    <th>System Id</th>
                                    <th>Role</th>
                                    <th>Status</th>
                                    <th style="text-align: center;">QR</th>
                                    <?php if(in_array('edit_user', $tasks) || in_array('update_user_status', $tasks)){ ?>    
                                    <th width="8%">Actions</th>                                    
                                    <?php } ?>
                                </tr>
                            </thead>
                            <tbody>                                    
                                <?php if(count($userData)>0){
                                    
                                    
     //print_r($userData);die;
                                    
                                    
                                        for($i=0;$i<count($userData);$i++){
                                    
                                    ?>
                                <tr>                                    
                                    <td style="text-align: center;">
                                        <?php $img = (empty($userData[$i]->img_url)?'default.jpg':$userData[$i]->img_url); ?>
                                        <img src="<?php echo 'uploads/thumb_path/'.$img; ?>" height="50" width="50" />
                                    </td>
                                    <td
                                        <?php if($userData[$i]->user_id == $loggedUserId)
                                        { echo 'style="color:#059A28 !important;"'; } ?>
                                     >
                                            <?php echo $userData[$i]->first_name.' '.$userData[$i]->last_name;
                                            if($userData[$i]->company_employee_id != ''){ echo ' / '.$userData[$i]->company_employee_id; }
                                          if($userData[$i]->user_id == $loggedUserId)
                                            { echo '<br/>'.'(Logged in)'; } ?>
                                    </td>

                                    <td ><?php echo $userData[$i]->l_address;                                               

                                              echo $userData[$i]->l_zip?'<br/>'.$userData[$i]->l_zip:''; ?>
                                    </td>
                                    <td><?php echo $userData[$i]->email; ?></td>     
                                    
                                    <td><?php echo $userData[$i]->mobile; ?></td>
                                    <td><?php echo $userData[$i]->system_id; ?></td>
                                    <td><?php echo $userData[$i]->role_name; ?></td> 
                                     <td><?php echo $employeeStatusArr[$userData[$i]->status-1]; ?></td> 
                                    <td style="text-align: center;">
                                        <?php
                                        if(file_exists('uploads/guard/IMG_'.$userData[$i]->qr_code)){ ?>
                                        <a href="javascript:void(0);" onclick="window.open('<?php echo site_url('user/getUserDetails/'.base64_encode($userData[$i]->user_id)); ?>', '', 'width=500, height=500');" >
                                            <img width="50" height="50" src="<?php echo site_url('uploads/guard/IMG_'.$userData[$i]->qr_code); ?>" />
                                        </a></br>
                                        <?php } ?>
                                        <?php { echo $userData[$i]->qr_code; } ?><!-- Added by PC to make sure QR code always shows even with image option-->
                                    </td> 
                                      <td style="text-align: center;">
                                    <?php if(in_array('edit_user', $tasks) || in_array('update_user_status', $tasks)){ ?>

                                   
                                     <?php if(in_array('edit_user', $tasks) && $login_user_role <= $userData[$i]->role_order){ ?>                                          
                                         <a title="Edit" class="btn btn-danger btn-condensed" href="<?php echo site_url('user/addEditUsers/'. base64_encode($userData[$i]->user_id)); ?>" ><span class="fa fa-pencil"></span></a>                                         
                                         <!--<a  data-box="#mb-update-status"  class="mb-control btn btn-danger btn-condensed" href="javascript:void(0);" onclick="downloadEmployeePDF('<?php echo site_url(''); ?>','<?php echo $userData[$i]->user_id ; ?>','<?php echo $userData[$i]->first_name ; ?>');" ><span class="fa fa-cloud-download"></span></a>-->
                                     <?php } ?>    
                                    <!--         
                                    
                                     <?php if(in_array('update_user_status', $tasks)){ ?>      
                                        <?php if($userData[$i]->status){ ?>
                                         <a title="Click to Deactivate" id="comp<?php echo $userData[$i]->user_id ; ?>" data-box="#mb-update-status"  class="mb-control btn btn-danger btn-condensed" href="javascript:void(0);" onclick="showPublishedStatusBoxUser('<?php echo site_url(''); ?>','<?php echo $userData[$i]->user_id ; ?>',1,'<?php echo $userData[$i]->first_name ; ?>');" ><span class="fa fa-check"></span></a>
                                         <?php }else{ ?>
                                         <a title="Click to Activate" id="comp<?php echo $userData[$i]->user_id ; ?>" data-box="#mb-update-status" class="mb-control btn btn-danger btn-condensed" href="javascript:void(0);" onclick="showPublishedStatusBoxUser('<?php echo site_url(''); ?>','<?php echo $userData[$i]->user_id ; ?>',0,'<?php echo $userData[$i]->first_name ; ?>');" ><span class="fa fa-times"></span></a>
                                         <?php } ?>
                                    <?php } ?> -->
                                     
                                    <?php } ?>
                                   <a title="Download PDF" class="btn btn-danger btn-condensed" href="<?php echo site_url('user/downloadUserDataPdf/'.base64_encode($userData[$i]->user_id)); ?>"  ><span class="fa fa-cloud-download"></span></a>

                                  <a title="View Employee Card"  class="btn btn-danger btn-condensed" onclick="window.open('<?php echo site_url('user/card/'.base64_encode($userData[$i]->user_id)); ?>', '', 'width=600, height=600');" ><span class="fa fa-eye"></span></a>
                                  </td>
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
    <!-- END MANY COLUMNS   -->
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
