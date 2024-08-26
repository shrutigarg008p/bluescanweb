<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">
    <form action="" method="post" name="list_form" id="list_form">
        <input type="hidden" name="page" value="<?php if(isset($page)) {  echo $page; } else {  echo 1; }  ?>" id="page" />

    <!-- START MANY COLUMNS  -->
    <div class="row">
        <div class="col-md-12">
        <div class="page-title">
                    <h2><?php echo $title; ?></h2>                    
                </div>
            <div class="panel panel-default">
                <?php if($this->session->flashdata('successMessage')){?>
                    <div class="alert alert-success" >
                        <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <strong><?php echo $this->session->flashdata('successMessage'); ?></strong> 
                    </div>
                    <?php } ?>
                
                
                <div class="panel-heading">
            	<div class="searchpanel">              	

                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    
                  <td width="15%"><select class="form-control select"
                    id="site_id" name="site_id"
                    onchange="getFieldOfiicer('<?php echo site_url(); ?>');">
                      <option value="" selected="selected">Select Site</option>
                      <?php if(count($getAllSiteDropdown)>0){ ?>
                      <?php for($i=0;$i<count($getAllSiteDropdown);$i++){?>
                      <option
                        value="<?php echo $getAllSiteDropdown[$i]->site_id; ?>"
                        <?php if($getAllSiteDropdown[$i]->site_id == $site_id){ echo 'selected="selected"';} ?>>
                        <?php echo $getAllSiteDropdown[$i]->site_title; ?>
                      </option>
                      <?php } ?>
                      <?php } ?>
                  </select>
                  </td>  
                    
                  <td width="15%"><select class="form-control select"
                    id="guard_id" name="guard_id">
                      <option value="" selected="selected">Select Guard</option>
                      <?php if(count($guardData)>0)
                      {
                        for($i=0;$i<count($guardData);$i++)
                                    {?>
                      <option value="<?php echo $guardData[$i]->employee_id; ?>"
                      <?php if($guardData[$i]->employee_id == $guard_id){ echo 'selected="selected"';} ?>>
                        <?php echo $guardData[$i]->first_name.' '.$guardData[$i]->last_name; ?>
                      </option>
                      <?php
                                    }
                                }?>
                  </select>
                  </td>  
                   <td width="15%">
                    <div class="input-group" style="width:98%;">
                      <input placeholder="Date" type="text"
                        class="form-control datepicker" id="filterDate"
                        name="filterDate" value="<?php echo $filterDate; ?>"
                        />
                    </div> <!--  <div class="input-group"  >
                                            <input placeholder="End Date" type="text" class="form-control datepicker" id="end_date" name="end_date" value="<?php echo $end_date; ?>" onchange="daterangefrom();"/>
                                        </div> -->
                  </td>
                  <td width="10%">
                    <button class="btn btn-primary pull-left">Go</button>
                  </td>
                </tr>
                <tr>

                </tr>
                <tr>

                </tr>
              </table>

              	</div>
           	</div> 
                
                
                
                <div class="panel-body panel-body-table">
                    
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-actions">
                            <thead>
                                <tr>
                                    <th>Guard</th>
                                    <th>Site</th>
                                    <th>Recorded by</th>    
                                    <th>Date</th>
                                    <th>Site Time</th>  
                                    <th>Time In</th>   
                                    <th>Verified By/Remark</th>
                                    <th>Image</th>
                              </tr>
                            </thead>
                            <tbody>
                                <?php if(count($guardAttData)>0){
                                        for($i=0;$i<count($guardAttData);$i++){
                                    ?>
                                <tr>
                                    <td><?php echo $guardAttData[$i]->guard_name; ?></td>
                                    <td><?php echo $guardAttData[$i]->site_title; ?></td>
                                    <td><?php echo $guardAttData[$i]->recorded_name; ?></td>
                                    <td><?php echo date('Y-m-d',strtotime($guardAttData[$i]->attendance_date)); ?></td>
                                    <td><?php echo $guardAttData[$i]->site_arrival_time; ?></td>       
                                    <td><?php echo $guardAttData[$i]->time_in; ?></td>       
                                    <td style="text-align: center;">
                                        <?php if($guardAttData[$i]->verified_by){
                                            echo $guardAttData[$i]->verified_by_name;  if($guardAttData[$i]->remark != ''){ echo '&nbsp;/&nbsp;'.$guardAttData[$i]->remark; }
                                        }else{ ?>
                                        <a title="Click to Verify" id="attendance<?php echo $guardAttData[$i]->employee_attendance_id ; ?>" data-box="#mb-update-status"  class="mb-control btn btn-danger btn-condensed" href="javascript:void(0);" onclick="verifyAttendance('<?php echo site_url(); ?>','<?php echo $guardAttData[$i]->employee_attendance_id; ?>','<?php echo $guardAttData[$i]->verified_by; ?>');" ><span class="fa fa-check"></span></a>
                                        <?php } ?>
                                    </td>
                                    <td><img width="70px" height="70px" src="<?php echo site_url('uploads/inspectionImage/'.$guardAttData[$i]->photo_url); ?>"/></td>

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
                <p id='update-msg-publish'>Do you really want to verify?</p>        
                
                 <div class="form-group" id="display_remark" >
                     <label class="col-md-4 control-label" >Remark</label>
                    <div class="col-md-8">                                                                                            
                        <input type="text" tabindex="1" class="form-control" name="remark" id="remark"/>
                    </div>                                                
                </div>
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