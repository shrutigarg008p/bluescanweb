
<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">
    <form action="" method="post" name="list_form" id="list_form">
        <input type="hidden" name="page" value="<?php if(isset($page)) {  echo $page; } else {  echo 1; }  ?>" id="page" />

    <!-- START MANY COLUMNS  -->
    <div class="row">
        <div class="col-md-12">
        <div class="page-title">

<h2><a  href="<?php echo site_url('company');?>" class="btn btn-primary"><span class="fa fa-arrow-circle-o-left"></span>Back</a>
  <?php echo $title; ?> (<?php echo $company_name; ?>)
</h2>
 
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
                                    <th>Employee</th>
                                    <th>Designation</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Reason</th>    
                                    <?php if(in_array('experience_verification', $tasks)){ ?> 
                                    <th width="12%">Actions</th>
                                    <?php } ?>

                                </tr>
                            </thead>
                            <tbody>
                                <?php if(count($companyData)>0){
                                        for($i=0;$i<count($companyData);$i++){
                                    
                                    ?>
                                <tr>                                    
                                     <td><?php echo $companyData[$i]->name; ?></td>            
                                    <td><?php echo $companyData[$i]->designation; ?></td>
                                    <td><?php echo date('Y-m-d',  strtotime($companyData[$i]->start_date));  ?></td>
                                    <td><?php echo date('Y-m-d',  strtotime($companyData[$i]->end_date));  ?></td>
                                    <td><?php echo $companyData[$i]->leaving_reason; ?></td>      
                                     <?php if(in_array('experience_verification', $tasks)){ ?> 
                                     <td>  
                                        <?php if(in_array('experience_verification', $tasks)){ ?>      
                                        <?php if($companyData[$i]->verified_by){ echo $companyData[$i]->verified_name; ?>
                                         <?php }else{ ?>
                                         <a title="Click to Verify" id="ee<?php echo $companyData[$i]->employee_experience_id ; ?>" data-box="#mb-update-status" class="mb-control btn btn-danger btn-condensed" href="javascript:void(0);" onclick="verifyStatusEmployeeExp('<?php echo site_url(); ?>','<?php echo $companyData[$i]->employee_experience_id ; ?>');" ><span class="fa fa-check"></span></a>
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
