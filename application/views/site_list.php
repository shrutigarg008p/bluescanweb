

<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">
    <form action="" method="post" name="list_form" id="list_form">
        <input type="hidden" name="page" value="<?php if(isset($page)) {  echo $page; } else {  echo 1; }  ?>" id="page" />

    <!-- START MANY COLUMNS  -->
    <div class="row">
        <div class="col-md-12">
            <div class="page-title">
                    <h2>Site List  
                    <?php if(in_array('add_site', $tasks)){ ?> <a  href="<?php echo site_url('site/addEditSite/'.base64_encode($customerId)); ?>" class="btn btn-primary" style="float:right;">Add New Site</a>
                    <?php } ?></h2>
            <div class="row-minus">        
            
                <div class="form-group">
                    <div class="col-md-5">
                        <div class="input-group">
                            <input class="form-control" placeholder="Site Id" type="text"  name="search_comp_site_id" value="<?php echo $search_comp_site_id; ?>" /> 
                        </div>
                    </div>
                   
                    <div class="col-md-4">
                        <div class="input-group">
                            <button class="btn btn-primary pull-right">Filter</button>                                                        
                        </div>
                    </div>
                </div>
             
            </div>
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
                                    <th style="text-align: center;">QR Code</th>
                                    <th>Site Code</th>
                                    <th>Site Name / Id</th>
                                    <th>Branch</th>                                    
                                    <th>Customer</th>
                                    <th>Address</th>                                    
                                    <th>Email</th>
                                    <th>System Id</th>
                                    <th>Contact Person</th>
                                    <th>Contact No</th>
                                    <?php if(in_array('edit_site', $tasks) || in_array('update_site_status', $tasks)||in_array('site_guard_assignment', $tasks)){ ?>     
                                    <th width="12%">Actions</th>                                    
                                    <?php } ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(count($siteData)>0){
                                        for($i=0;$i<count($siteData);$i++){
                                    
                                    ?>
                                <tr>
                                    <td style="text-align: center;"><a href="javascript:void(0);" onclick="window.open('<?php echo site_url('site/getSiteDetails/'.base64_encode($siteData[$i]->site_id)); ?>', '', 'width=500, height=500');" >
                                            <img width="70px" height="70px" src="<?php echo site_url('uploads/site/SITEIMG_'.$siteData[$i]->qr_code); ?>" />
                                        </a>
                                    </td>
                                    <td style="text-align: center;"><?php echo $siteData[$i]->qr_code; ?></td>
                                    <td><?php echo $siteData[$i]->site_title; if($siteData[$i]->company_site_id!=''){ echo ' / '.$siteData[$i]->company_site_id; } ?></td>
                                    <td><?php echo $siteData[$i]->branch_name; ?></td>
                                    <td><?php echo $siteData[$i]->customer_name; ?></td>
                                    <td><?php echo $siteData[$i]->address; 
                                              echo $siteData[$i]->city?'<br/>'.$siteData[$i]->city:'';
                                              echo $siteData[$i]->zipcode?'<br/>'.$siteData[$i]->zipcode:'';
                                    ?></td>                                    
                                    <td><?php echo $siteData[$i]->email_id; ?></td>
                                    <td><?php echo $siteData[$i]->system_id; ?></td>
                                    <td><?php echo $siteData[$i]->contact_person; ?></td>
                                    <td><?php echo $siteData[$i]->contact_number; ?></td>
                                    <?php if(in_array('edit_site', $tasks) || in_array('update_site_status', $tasks)||in_array('site_guard_assignment', $tasks)){ ?>
                                    <td>              
                                        <?php if(in_array('edit_site', $tasks)){ ?>     
                                        <a title="Edit" class="btn btn-danger btn-condensed" href="<?php echo site_url('site/addEditSite/'. base64_encode($siteData[$i]->customer_id).'/'. base64_encode($siteData[$i]->site_id)); ?>" ><span class="fa fa-pencil"></span></a>
                                        <?php } ?>
                                        
                                        <?php if(in_array('site_guard_assignment', $tasks)){ ?>     
                                        <a title="Guard Site" class="btn btn-danger btn-condensed" href="<?php echo site_url('site/guardSite/'.base64_encode($siteData[$i]->site_id).'/'.base64_encode($siteData[$i]->customer_id)); ?>" ><span class="fa fa-picture-o"></span></a>
                                        <?php } ?>
                                        
                                        <?php if(in_array('update_site_status', $tasks)){ ?>   
                                        <?php if($siteData[$i]->is_published){ ?>
                                        <a title="Click to Deactivate" id="site<?php echo $siteData[$i]->branch_id ; ?>" data-box="#mb-update-status"  class="mb-control btn btn-danger btn-condensed" href="javascript:void(0);" onclick="showPublishedStatusSite('<?php echo site_url(); ?>','<?php echo $siteData[$i]->site_id ; ?>',1);" ><span class="fa fa-check"></span></a>
                                        <?php }else{ ?>
                                        <a title="Click to Activate" id="site<?php echo $siteData[$i]->branch_id ; ?>" data-box="#mb-update-status" class="mb-control btn btn-danger btn-condensed" href="javascript:void(0);" onclick="showPublishedStatusSite('<?php echo site_url(); ?>','<?php echo $siteData[$i]->site_id ; ?>',0);" ><span class="fa fa-times"></span></a>
                                        <?php } ?>
                                         <?php } ?>
                                    
                                    </td>
                                     <?php } ?>
                                </tr>
                                <?php 
                                        }
                                    }else{ ?>
                                <tr ><td colspan="7">No Records!</td></tr>
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
