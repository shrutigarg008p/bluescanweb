
<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">
    <form action="" method="post" name="list_form" id="list_form">
        <input type="hidden" name="page" value="<?php if(isset($page)) {  echo $page; } else {  echo 1; }  ?>" id="page" />

    <!-- START MANY COLUMNS  -->
    <div class="row">
        <div class="col-md-12">
        <div  class="page-title">
                    <h2><a  href="<?php echo site_url('site/siteList/'.base64_encode($customerId)); ?>" class="btn btn-primary"><span class="fa fa-arrow-circle-o-left"></span>Back</a>
                    <a  href="<?php echo site_url('site/addEditGuardSite/'. base64_encode($siteId)); ?>" class="btn btn-primary" style="float:right;">Add Guard at Site</a>
                    </strong> Guard Site List</h2>
                    
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
                                    <th>Guard Name</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th width="12%">Actions</th>                                    
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(count($guardSiteData)>0){
                                        for($i=0;$i<count($guardSiteData);$i++){
                                    
                                    ?>
                                <tr>
                                    <td><?php echo $guardSiteData[$i]->guard_name; ?></td>                                    
                                    <td><?php echo $guardSiteData[$i]->start_date; ?></td>
                                    <td><?php echo $guardSiteData[$i]->end_date; ?></td>                                                                        
                                    <td>                                       
                                        <a title="Edit" class="btn btn-danger btn-condensed" href="<?php echo site_url('site/addEditGuardSite/'.base64_encode($siteId).'/'.base64_encode($guardSiteData[$i]->employee_site_id)); ?>" ><span class="fa fa-pencil"></span></a>                                        
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
                        <p id='update-msg-publish'>Are you sure you want to Active ?</p>                    
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
