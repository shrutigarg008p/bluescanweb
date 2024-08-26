
<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">
    <form action="" method="post" name="list_form" id="list_form">
        <input type="hidden" name="page" value="<?php if(isset($page)) {  echo $page; } else {  echo 1; }  ?>" id="page" />

    <!-- START MANY COLUMNS  -->
    <div class="row">
        <div class="col-md-12">
        <div class="page-title">

<h2><a  href="<?php echo site_url('company');?>" class="btn btn-primary"><span class="fa fa-arrow-circle-o-left"></span>Back</a>
  Office List (<?php echo $company_name; ?>)
</h2>
<?php if(in_array('add_office', $tasks)){ ?> 
                    <a  href="<?php echo site_url('company/addEditCompanyOffice/'. base64_encode($companyId)); ?>" class="btn btn-primary" style="float:right;">Add Company Office</a>
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
                                    <th>Email</th>
                                    <th>Address</th>
                                    <th>Contact Number</th>
                                    <th>Contact Person</th>    
                                    <?php if(in_array('edit_company_office', $tasks) || in_array('update_company_office_status', $tasks)){ ?> 
                                    <th width="12%">Actions</th>
                                    <?php } ?>

                                </tr>
                            </thead>
                            <tbody>
                                <?php if(count($companyData)>0){
                                        for($i=0;$i<count($companyData);$i++){
                                    
                                    ?>
                                <tr>                                    
                                     <td><?php echo $companyData[$i]->email_id; ?></td>            
                                    <td><?php echo $companyData[$i]->address; 
                                              echo $companyData[$i]->city?', '.$companyData[$i]->city:'';                                              
                                              echo $companyData[$i]->zipcode?'<br/>'.$companyData[$i]->zipcode:'';
                                    ?></td>
                                    <td><?php echo $companyData[$i]->contact_number; ?></td>
                                    <td><?php echo $companyData[$i]->contact_person; ?></td>      
                                     <?php if(in_array('edit_company_office', $tasks) || in_array('update_company_office_status', $tasks)){ ?> 
                                     <td>  
                                        <?php if(in_array('edit_company_office', $tasks)){ ?>  
                                         <a title="Edit" class="btn btn-danger btn-condensed" href="<?php echo site_url('company/addEditCompanyOffice/'. base64_encode($companyId).'/'.base64_encode($companyData[$i]->company_office_id)); ?>" ><span class="fa fa-pencil"></span></a>
                                        <?php } ?>
                                         
                                        <?php if(in_array('update_company_office_status', $tasks)){ ?>      
                                        <?php if($companyData[$i]->is_published){ ?>
                                         <a title="Click to Deactivate" id="comp<?php echo $companyData[$i]->company_office_id ; ?>" data-box="#mb-update-status"  class="mb-control btn btn-danger btn-condensed" href="javascript:void(0);" onclick="showPublishedStatusBoxOffice('<?php echo site_url(); ?>','<?php echo $companyData[$i]->company_office_id ; ?>','<?php echo base64_encode($companyId); ?>',1,'<?php echo $companyData[$i]->address ; ?>');" ><span class="fa fa-check"></span></a>
                                         <?php }else{ ?>
                                         <a title="Click to Activate" id="comp<?php echo $companyData[$i]->company_office_id ; ?>" data-box="#mb-update-status" class="mb-control btn btn-danger btn-condensed" href="javascript:void(0);" onclick="showPublishedStatusBoxOffice('<?php echo site_url(); ?>','<?php echo $companyData[$i]->company_office_id ; ?>','<?php echo base64_encode($companyId); ?>',0,'<?php echo $companyData[$i]->address ; ?>');" ><span class="fa fa-times"></span></a>
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
