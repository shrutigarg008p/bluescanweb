
<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">


<form action="" method="post" name="list_form" id="list_form">
  <input type="hidden" name="page" value="<?php if(isset($page)) {  echo $page; } else {  echo 1; }  ?>" id="page" />
    <!-- START MANY COLUMNS  -->
    <div class="row">
        <div class="col-md-12">
        <div class="page-title">
                    <h2>Region List <?php if(in_array('add_region', $tasks)){ ?> 
                    <a  href="<?php echo site_url('region/addEditRegion'); ?>" class="btn btn-primary" style="float:right;">Add Region</a></h2>
                    
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
                                    <th>Company Name</th>
                                    <th>Region Name</th>
                                    <th>Address</th>
                                    <th>Email</th>
                                    <th>Contact Number</th>
                                    <th>System Id</th>
                                    <th>Created By</th>
                                    <th width="12%">Actions</th>                                    
                                </tr>
                            </thead>
                            <tbody>
                                <?php   if(count($regionData)>0){
                                            for($i=0;$i<count($regionData);$i++){                                    
                                            ?>
                                                <tr>
                                                    <td><?php echo $regionData[$i]->company_name; ?></td>
                                                    <td><?php echo $regionData[$i]->region_name; ?></td>
                                                    <td><?php echo $regionData[$i]->address;
                                                              echo $regionData[$i]->city?'<br/>'.$regionData[$i]->city:'';
                                                              echo $regionData[$i]->zipcode?'<br/>'.$regionData[$i]->zipcode:''; ?>
                                                    </td>
                                                    <td><?php echo $regionData[$i]->email_id; ?></td>
                                                    <td><?php echo $regionData[$i]->contact_number; ?></td> 
                                                    <td><?php echo $regionData[$i]->system_id; ?></td> 
                                                    <td><?php echo $regionData[$i]->user_name; ?></td>
                                                    <?php if(in_array('edit_region', $tasks) || in_array('update_region_status', $tasks)){ ?> 
                                                    <td> 
                                                        <?php if(in_array('edit_region', $tasks)){ ?> 
                                                        <a title="Edit" class="btn btn-danger btn-condensed" href="<?php echo site_url('region/addEditRegion/'. base64_encode($regionData[$i]->region_id)); ?>" ><span class="fa fa-pencil"></span></a>
                                                        <?php } ?>
                                                        
                                                        <?php if(in_array('update_region_status', $tasks)){ ?> 
                                                        <?php if($regionData[$i]->is_published){ ?>
                                                        <a title="Click to Deactivate" id="comp<?php echo $regionData[$i]->region_id ; ?>" data-box="#mb-update-status"  class="mb-control btn btn-danger btn-condensed" href="javascript:void(0);" onclick="showPublishedStatusBoxRegion('<?php echo site_url(); ?>','<?php echo $regionData[$i]->region_id ; ?>',1,'<?php echo $regionData[$i]->city; ?>');" ><span class="fa fa-check"></span></a>
                                                        <?php }else{ ?>
                                                        <a title="Click to Activate" id="comp<?php echo $regionData[$i]->region_id ; ?>" data-box="#mb-update-status" class="mb-control btn btn-danger btn-condensed" href="javascript:void(0);" onclick="showPublishedStatusBoxRegion('<?php echo site_url(); ?>','<?php echo $regionData[$i]->region_id ; ?>',0,'<?php echo $regionData[$i]->city; ?>');" ><span class="fa fa-times"></span></a>
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
