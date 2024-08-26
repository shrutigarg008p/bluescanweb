<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">


<form action="" method="post" name="list_form" id="list_form">
  <input type="hidden" name="page" value="<?php if(isset($page)) {  echo $page; } else {  echo 1; }  ?>" id="page" />
  
    <!-- START MANY COLUMNS  -->
    <div class="row">
        <div class="col-md-12">
        <div class="page-title">
            <h2><?php echo $pagetitle; ?></h2>                   
        </div>
            <div class="panel panel-default">
				
	<div class="panel-heading">
            	<div class="searchpanel">
              	

                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
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
                  <td width="15%"><select class="form-control select"
                    id="officer_id" name="officer_id">
                      <option value="" selected="selected">Select Field Officer</option>
                      <?php if(count($fieldOfficerData)>0)
                      {
                        for($i=0;$i<count($fieldOfficerData);$i++)
                                    {?>
                      <option value="<?php echo $fieldOfficerData[$i]->user_id; ?>"
                      <?php if($fieldOfficerData[$i]->user_id == $officer_id){ echo 'selected="selected"';} ?>>
                        <?php echo $fieldOfficerData[$i]->first_name.' '.$fieldOfficerData[$i]->last_name; ?>
                      </option>
                      <?php
                                    }
                                }?>
                  </select>
                  </td>

                  <td width="15%">
                    <div class="input-group" style="width:98%;">
                      <input placeholder="Start Date" type="text"
                        class="form-control datepicker" id="start_date"
                        name="start_date" value="<?php echo $start_date; ?>"
                         />
                    </div> <!--  <div class="input-group"  >
                                            <input placeholder="End Date" type="text" class="form-control datepicker" id="end_date" name="end_date" value="<?php echo $end_date; ?>" onchange="daterangefrom();"/>
                                        </div> -->
                  </td>
                  <td width="15%">
                    <div class="input-group" style="width:98%;" >
                      <input placeholder="End Date" type="text"
                        class="form-control datepicker" id="end_date"
                        name="end_date" value="<?php echo $end_date; ?>"
                        />
                    </div> <!--  <div class="input-group"  >
                                            <input placeholder="End Date" type="text" class="form-control datepicker" id="end_date" name="end_date" value="<?php echo $end_date; ?>" onchange="daterangefrom();"/>
                                        </div> -->
                  </td>
                  <td width="10%">
                    <button class="btn btn-primary pull-left">Go</button>
                  </td>
                  <td width="16%" align="center">              
                    <input class="btn btn-primary" type="submit" name="download_csv" value="CSV"/>
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
                       <table class="table table-bordered table-striped table-actions"
                id="dashboard">
                <thead>

                  <tr>
                    <th width="10%">Field Officer</th>
                    <th width="8%">Date</th>
                    <th width="8%">Time</th>
                    <!-- <th width="8%">Type</th> -->
                    <th width="10%">Guard</th>
                    <th width="10%">Survey Response</th>
                  </tr>
                </thead>

                <tbody>
                  <?php
                  if(count($inspInstData)>0)
                  {
                    for($i=0;$i<count($inspInstData);$i++)
                            {?>
                  <tr id="<?php echo $inspInstData[$i]->site_visiting_id;?>">
                  
                      <td><?php echo $inspInstData[$i]->fo_name; ?></td>
                    <td><?php echo date('Y-m-d',  strtotime($inspInstData[$i]->visiting_time)); ?></td>
                    <td><?php echo date('H:i:s',strtotime($inspInstData[$i]->visiting_time)); ?> </td>
                    <td><?php echo $inspInstData[$i]->guard_name; ?></td>
                    <td><a href="<?php echo site_url('guard/guardSurvey/'.base64_encode($inspInstData[$i]->site_visiting_id)); ?>"><?php echo (empty($inspInstData[$i]->total_answer)?'0':$inspInstData[$i]->total_answer).'/'.(empty($inspInstData[$i]->total_question)?'0':$inspInstData[$i]->total_question); ?></a>
                    </td>
                                       
                  </tr><?php
                         }
                     ?>
                 
                  <?php
                  }
                          else{ ?>
                  <tr>
                    <td colspan="4">No Records!</td>
                  </tr>
                  <?php
                      }
                  ?>
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


