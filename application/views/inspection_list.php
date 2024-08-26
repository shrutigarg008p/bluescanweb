
<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">

<form action="" method="post" name="list_form" id="list_form">
  <input type="hidden" name="page" value="<?php if(isset($page)) {  echo $page; } else {  echo 1; }  ?>" id="page" />
    <!-- START MANY COLUMNS  -->
    <div class="row">
        <div class="col-md-12">
            
           <div class="page-title">              
                <div class="col-md-7 first">    
                    <h2>Inspection List</h2>
                </div>
              <!-- START SEARCH -->                            
                            
                              <div class="col-md-5 last"><div class="form-group">
                                                <div class="col-md-5">
                                                    <div class="input-group">
                                                    <select class="form-control select" name="user_id" id="user_id">
                                                        <option value="">Select Field Officer</option>
                                                        <?php
                                                            for($i=0;$i<count($userDropDown);$i++)
                                                            { ?>
                                                                <option value="<?php echo $userDropDown[$i]->user_id;?>"
                                                                        <?php if($userDropDown[$i]->user_id == $userid)
                                                                        { echo 'selected="selected"';} 
                                                                    ?> 
                                                                >
                                                                    <?php echo $userDropDown[$i]->first_name.' '.$userDropDown[$i]->last_name; ?>
                                                                </option>
                                                                    
                                                            <?php 
                                                            } ?>
                                                    </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-5">
                                                    <div class="input-group">
                                                    <select class="form-control select" name="guard_id" id="guard_id">
                                                        <option value="">Select Guard Name</option>
                                                        <?php
                                                            for($i=0;$i<count($guardDropDown);$i++)
                                                            { ?>
                                                                <option value="<?php echo $guardDropDown[$i]->guard_id;?>"
                                                                        <?php if($guardDropDown[$i]->guard_id == $guardid)
                                                                        { echo 'selected="selected"';} 
                                                                    ?>
                                                                 >
                                                                    <?php echo $guardDropDown[$i]->first_name.' '.$guardDropDown[$i]->last_name; ?>
                                                                </option>                                                                    
                                                            <?php 
                                                            } ?>
                                                    </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="input-group">
                                                        <button class="btn btn-primary pull-right">Filter</button>                                                        
                                                    </div>
                                                </div>
                                            </div></div></div>
             <!-- END SEARCH -->
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
                                    <th>Field Officer</th>
                                    <th>Inspection Date</th>
                                    <th>Site</th>
                                    <th>Guard</th>
                                    <th>Status</th>
                                    <?php if(in_array('inspection_details', $tasks)){ ?>
                                   <th width="12%">Actions</th>                                   
                                   <?php } ?>

                                </tr>
                            </thead>
                            <tbody>
                                <?php if(count($inspectionData)>0){
                                        for($i=0;$i<count($inspectionData);$i++){
                                    
                                    ?>
                                <tr>
                                    <td><?php echo $inspectionData[$i]->officer; ?></td>   
                                    <td><?php echo date('m-d-Y',  strtotime($inspectionData[$i]->created_date)); ?></td>
                                    <td><?php echo $inspectionData[$i]->address; 
                                              echo $inspectionData[$i]->city?'<br/>'.$inspectionData[$i]->city:'';
                                              echo $inspectionData[$i]->zipcode?'<br/>'.$inspectionData[$i]->zipcode:'';
                                    ?></td>     
                                    <td><?php echo $inspectionData[$i]->guard_name; ?></td>            
                                    <td><?php if($inspectionData[$i]->status == 1){ echo 'Pending'; }else if($inspectionData[$i]->status == 1){ echo 'Rejected'; } else if($inspectionData[$i]->status == 1){ echo 'Completed'; }  ?></td>
                                    <?php if(in_array('inspection_details', $tasks)){ ?>
                                    <td>
                                         <a title="Inspection Detail" class="btn btn-danger btn-condensed" href="<?php echo site_url('inspection/inspectionDetail/'. base64_encode($inspectionData[$i]->inspection_instance_id)); ?>" ><span class="fa fa-file-text"></span></a>
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
