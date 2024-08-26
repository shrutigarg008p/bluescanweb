<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">
    <form action="" method="post" name="list_form" id="list_form">
        <input type="hidden" name="page" value="<?php if(isset($page)) {  echo $page; } else {  echo 1; }  ?>" id="page" />

    <!-- START MANY COLUMNS  -->
    <div class="row">
        <div class="col-md-12">
        <div class="page-title">
            <h2>Guard List </h2>
                    <?php if(in_array('add_guard', $tasks)){ ?> 
                    <a  href="<?php echo site_url('guard/addEditGuard'); ?>" class="btn btn-primary" style="float:right;">Add Guard</a>
                    <?php } ?>
</div>
            <div class="panel panel-default">

                
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
                                    <th>QR Code</th>
                               <!--     <th>Company Name</th> -->
                                    <th>Guard Name</th>
                                    <th>Address</th>
                                    <th>Mobile/Phone</th>
                                    <th>Post</th>
                                    <?php if(in_array('guard_attendance', $tasks)||in_array('edit_guard', $tasks) || in_array('update_guard_status', $tasks)){ ?> 
                                    <th>Actions</th>
                                    <?php } ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(count($guardData)>0){
                                        for($i=0;$i<count($guardData);$i++){
                                    
                                    ?>
                                <tr>
                                    <td><a href="javascript:void(0);" onclick="window.open('<?php echo site_url('guard/getGuardDetails/'.base64_encode($guardData[$i]->guard_id)); ?>', '', 'width=500, height=500');" >
                                            <img width="80px" height="80px" src="<?php echo site_url('uploads/guard/GUARDIMG_'.$guardData[$i]->qr_code); ?>" />
                                    </a></td>
                               <!--      <td><?php //echo $guardData[$i]->company_name; ?></td> -->
                                    <td><?php echo $guardData[$i]->first_name.' '.$guardData[$i]->last_name; ?></td>                                    
                                    <td><?php echo $guardData[$i]->address; ?></td>
                                    <td><?php echo '(M)'.$guardData[$i]->mobile;
                                              echo $guardData[$i]->phone?'<br/>(P)'.$guardData[$i]->phone:'';
                                    ?></td>                                    
                                    <td><?php echo $guardData[$i]->post; ?></td>
                                    <?php if(in_array('guard_attendance', $tasks)||in_array('edit_guard', $tasks) || in_array('update_guard_status', $tasks)){ ?> 
                                    <td>      
                                        <?php if(in_array('edit_guard', $tasks)){ ?> 
                                        <a title="Edit" class="btn btn-danger btn-condensed" href="<?php echo site_url('guard/addEditGuard/'. base64_encode($guardData[$i]->guard_id)); ?>" ><span class="fa fa-pencil"></span></a>
                                        <?php } ?>
                                        
                                        <?php if(in_array('update_guard_status', $tasks)){ ?> 
                                        <?php if($guardData[$i]->status){ ?>
                                        <a title="Click to Deactivate" id="comp<?php echo $guardData[$i]->guard_id ; ?>" data-box="#mb-update-status"  class="mb-control btn btn-danger btn-condensed" href="javascript:void(0);" onclick="showPublishedStatusGuardBox('<?php echo site_url(); ?>','<?php echo $guardData[$i]->guard_id ; ?>',1,'<?php echo $guardData[$i]->first_name.' '.$guardData[$i]->last_name; ?>');" ><span class="fa fa-check"></span></a>
                                        <?php }else{ ?>
                                        <a title="Click to Activate" id="comp<?php echo $guardData[$i]->guard_id ; ?>" data-box="#mb-update-status" class="mb-control btn btn-danger btn-condensed" href="javascript:void(0);" onclick="showPublishedStatusGuardBox('<?php echo site_url(); ?>','<?php echo $guardData[$i]->guard_id ; ?>',0,'<?php echo $guardData[$i]->first_name.' '.$guardData[$i]->last_name; ?>');" ><span class="fa fa-times"></span></a>                                        
                                        <?php } ?>
                                        <?php }?>
                                        <?php if(in_array('guard_attendance', $tasks)){ ?> 
                                        <a title="Attendance" class="btn btn-danger btn-condensed" href="<?php echo site_url('guard/guardAttend/'. base64_encode($guardData[$i]->guard_id)); ?>" ><span class="fa fa-file-text-o"></span></a>
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
