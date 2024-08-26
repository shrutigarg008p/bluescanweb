<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">
    <form action="" method="post" name="list_form" id="list_form">
        <input type="hidden" name="page" value="<?php if(isset($page)) {  echo $page; } else {  echo 1; }  ?>" id="page" />

    <!-- START MANY COLUMNS  -->
    <div class="row">
        <div class="col-md-12">


          

            <div class="page-title">
                <div class="col-md-6" style="padding:0;">
                    <h2>Branch List</h2>
                    
                </div>
                     <!-- Start branch filter by company --><div class="col-md-5"><div class="form-group">
                                    <div class="col-md-10">
                                     <div class="input-group">
                                        <select class="form-control select" name="search_region_id" id="search_region_id" style="margin-top:0;">
                                            <option value="">Select Region Name</option>
                                            <?php
                                                for($i=0;$i<count($regionDropDown);$i++)
                                                { ?>
                                                    <option value="<?php echo $regionDropDown[$i]->region_id;?>"
                                                    <?php if($regionDropDown[$i]->region_id == $f_region_id)
                                                    { echo 'selected="selected"';} 
                                                    ?>
                                                    >
                                                    <?php echo $regionDropDown[$i]->region_name; ?>
                                                    </option>                                                                    
                                                    <?php 
                                                } ?>
                                        </select>
                                    </div>
                                </div>
                               
                                <div class="col-md-2">
                                    <div class="input-group">
                                        <button class="btn btn-primary pull-right" style="margin-top:4px;">Filter</button>                                                        
                                    </div>
                                </div>
                            </div></div><!-- End branch filter by company -->
                    <?php if(in_array('add_branch', $tasks)){ ?>        
                    <a  href="<?php echo site_url('branch/addEditBranch'); ?>" class="btn btn-primary" style="float:right; padding:4px 10px; margin-top:4px;">Add Branch</a>
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
                                    <th>Region Name</th>
                                    <th>Branch Name</th>
                                    <th>Address</th>                                    
                                    <th>Email</th>
                                    <th>System Id</th>
                                    <th>Contact Number</th>
                                    <?php if(in_array('edit_branch', $tasks) || in_array('update_branch_status', $tasks)){ ?> 
                                    <th width="12%">Actions</th>                                    
                                    <?php } ?>

                                </tr>
                            </thead>
                            <tbody>
                                <?php if(count($branchData)>0){
                                        for($i=0;$i<count($branchData);$i++){
                                    
                                    ?>
                                <tr>
                                    <td><?php echo $branchData[$i]->reg_add; ?></td>
                                    <td><?php echo $branchData[$i]->branch_name; ?></td>
                                    <td><?php echo $branchData[$i]->address; 
                                              echo $branchData[$i]->city?'<br/>'.$branchData[$i]->city:'';
                                              echo $branchData[$i]->zipcode?'<br/>'.$branchData[$i]->zipcode:'';
                                    ?></td>                                    
                                    <td><?php echo $branchData[$i]->email_id; ?></td>
                                    <td><?php echo $branchData[$i]->system_id; ?></td>
                                    <td><?php echo $branchData[$i]->contact_number; ?></td>
                                    <?php if(in_array('edit_branch', $tasks)){ ?> 
                                    <td>  
                                        <?php if(in_array('edit_branch', $tasks) || in_array('update_branch_status', $tasks)){ ?> 
                                        <a title="Edit" class="btn btn-danger btn-condensed" href="<?php echo site_url('branch/addEditBranch/'. base64_encode($branchData[$i]->branch_id)); ?>" ><span class="fa fa-pencil"></span></a>
                                        <?php } ?>
                                            
                                        <?php if(in_array('update_branch_status', $tasks)){ ?> 
                                        <?php if($branchData[$i]->is_published){ ?>
                                        <a title="Click to Deactivate" id="comp<?php echo $branchData[$i]->branch_id ; ?>" data-box="#mb-update-status"  class="mb-control btn btn-danger btn-condensed" href="javascript:void(0);" onclick="showPublishedStatusBranch('<?php echo site_url(); ?>','<?php echo $branchData[$i]->branch_id ; ?>',1,'<?php echo $branchData[$i]->city ; ?>');" ><span class="fa fa-check"></span></a>
                                        <?php }else{ ?>
                                        <a title="Click to Activate" id="comp<?php echo $branchData[$i]->branch_id ; ?>" data-box="#mb-update-status" class="mb-control btn btn-danger btn-condensed" href="javascript:void(0);" onclick="showPublishedStatusBranch('<?php echo site_url(); ?>','<?php echo $branchData[$i]->branch_id ; ?>',0,'<?php echo $branchData[$i]->city ; ?>');" ><span class="fa fa-times"></span></a>
                                        <?php } ?>
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
