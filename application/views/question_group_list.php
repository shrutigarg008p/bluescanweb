<div class="page-content-wrap">

<form action="" method="post" name="list_form" id="list_form">
  <input type="hidden" name="page" value="<?php if(isset($page)) {  echo $page; } else {  echo 1; }  ?>" id="page" />
    <!-- START MANY COLUMNS  -->
    <div class="row">
        <div class="col-md-12">
            
            <div class="panel panel-default">
                
            </div>
            <div class="page-title">
<h2><a  href="<?php echo site_url('company');?>" class="btn btn-primary"><span class="fa fa-arrow-circle-o-left"></span>Back</a>
 Question Group List (<?php echo $companyName; ?>)
</h2>
 <?php if(in_array('add_group', $tasks)){ ?> 
                    <a  href="<?php echo site_url('question/addEditQuestionGroup/'.base64_encode($companyId)); ?>" class="btn btn-primary" style="float:right;">Add New Question Group</a>
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
                                    <th>Group Name</th>
                                    <th>Description</th>
                                    <?php if(in_array('edit_group', $tasks)||in_array('update_group_status', $tasks)){ ?> 
                                    <th width="12%">Actions</th>                                    
                                    <?php } ?>

                                </tr>
                            </thead>
                            <tbody>
                                <?php if(count($questionData)>0){
                                        for($i=0;$i<count($questionData);$i++){
                                    
                                    ?>
                                <tr>
                                    <td><?php echo $questionData[$i]->group_name; ?></td>     
                                     <td><?php echo $questionData[$i]->description; ?></td> 
                                    <?php if(in_array('edit_group', $tasks)||in_array('update_group_status', $tasks)){ ?> 
                                    <td>
                                       <?php if(in_array('edit_group', $tasks)||in_array('update_group_status', $tasks)){ ?>  
                                       <a title="Edit" class="btn btn-danger btn-condensed" href="<?php echo site_url('question/addEditQuestionGroup/'. base64_encode($questionData[$i]->company_id).'/'. base64_encode($questionData[$i]->group_id)); ?>" ><span class="fa fa-pencil"></span></a>
                                       <?php } ?>
                                       
                                       <?php if(in_array('update_group_status', $tasks)){ ?> 
                                        <?php if($questionData[$i]->is_published){ ?>
                                         <a title="Click to Deactivate" id="group<?php echo $questionData[$i]->group_id ; ?>" data-box="#mb-update-status"  class="mb-control btn btn-danger btn-condensed" href="javascript:void(0);" onclick="showGroupStatusBox('<?php echo site_url(); ?>','<?php echo $questionData[$i]->group_id ; ?>',1,'<?php echo $questionData[$i]->group_name ; ?>');" ><span class="fa fa-check"></span></a>
                                         <?php }else{ ?>
                                         <a title="Click to Activate" id="group<?php echo $questionData[$i]->group_id ; ?>" data-box="#mb-update-status" class="mb-control btn btn-danger btn-condensed" href="javascript:void(0);" onclick="showGroupStatusBox('<?php echo site_url(); ?>','<?php echo $questionData[$i]->group_id ; ?>',0,'<?php echo $questionData[$i]->group_name ; ?>');" ><span class="fa fa-times"></span></a>
                                         <?php } ?>
                                       <?php } ?>
                                    </td>
                                   <?php } ?>
                                </tr>
                                <?php 
                                        }
                                    }else{ ?>
                                <tr ><td colspan="3">No Records!</td></tr>
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
 