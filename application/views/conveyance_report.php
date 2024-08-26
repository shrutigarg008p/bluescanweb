<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">


<form action="" method="post" name="list_form" id="list_form">
 
  
    <!-- START MANY COLUMNS  -->
    <div class="row">
        <div class="col-md-12">
        <div class="page-title">
            <h2>Conveyance Report</h2>                   
        </div>
            <div class="panel panel-default">
				
				<div class="panel-heading">
            	<div class="searchpanel">
              	

                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <!-- <td width="25%">
                                    <select class="form-control select" id="company_name" name="company_name" onchange="getRegionList('<?php echo site_url(); ?>');" >
                                     <option value="" selected="selected">Select Client</option>  
                                     <?php if(count($getAllcompanyDropdown)>0){ ?>
                                         <?php for($i=0;$i<count($getAllcompanyDropdown);$i++){?>
                                            <option value="<?php echo $getAllcompanyDropdown[$i]->company_id; ?>" <?php if($getAllcompanyDropdown[$i]->company_id == $company_id){ echo 'selected="selected"';} ?> ><?php echo $getAllcompanyDropdown[$i]->company_name; ?></option>

                                         <?php } ?>
                                     <?php } ?>
                                    </select>
                                </td> -->
                 <?php if($roleCode == 'sadmin' || $roleCode == 'cadmin' || $roleCode == 'cuser' || $roleCode == 'RM'){ ?>    
                  <td width="15%"><select class="form-control select"
                    id="region_area" name="region_id"
                    onchange="getBranchList('<?php echo site_url(); ?>');">
                      <option value="" selected="selected">Select Region</option>
                      <?php if(count($getAllRegionDropdown)>0){ ?>
                      <?php for($i=0;$i<count($getAllRegionDropdown);$i++){?>
                      <option
                        value="<?php echo $getAllRegionDropdown[$i]->region_id; ?>"
                        <?php if($getAllRegionDropdown[$i]->region_id == $region_id){ echo 'selected="selected"';} ?>>
                        <?php echo $getAllRegionDropdown[$i]->region_name; ?>
                      </option>
                      <?php } ?>
                      <?php } ?>
                  </select>
                  </td>
                 <?php } ?>
                  <?php if($roleCode == 'sadmin' || $roleCode == 'cadmin' || $roleCode == 'cuser' || $roleCode == 'RM' || $roleCode == 'BM'){ ?> 
                  <td width="15%"><select class="form-control select"
                    id="branch_id" name="branch_id"
                    onchange="getSiteList('<?php echo site_url(); ?>');">
                      <option value="" selected="selected">Select Branch</option>
                      <?php if(count($getAllBranchDropdown)>0){ ?>
                      <?php for($i=0;$i<count($getAllBranchDropdown);$i++){?>
                      <option
                        value="<?php echo $getAllBranchDropdown[$i]->branch_id; ?>"
                        <?php if($getAllBranchDropdown[$i]->branch_id == $branch_id){ echo 'selected="selected"';} ?>>
                        <?php echo $getAllBranchDropdown[$i]->branch_name; ?>
                      </option>
                      <?php } ?>
                      <?php } ?>
                  </select>
                  </td>
                  <?php } ?>
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
                    <div class="input-group" style="float: left;">
                      <input placeholder="Date" type="text"
                        class="form-control datepicker" id="start_date"
                        name="start_date" value="<?php echo $start_date; ?>"
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
                    <th width="10%">Site</th>
                    <th width="10%">Survey Response</th>
                    <th width="10%">Difference</th>
                    <th width="10%">Distance to</th>                    
                  </tr>
                </thead>

                <tbody>
                  <?php
                  $totalkms = 0;
                  if(count($inspInstData)>0)
                  {
                    for($i=0;$i<count($inspInstData);$i++)
                            {
                        
                         if($inspInstData[$i]->site_id != '' || $inspInstData[$i]->custom == 1){
                        
                        ?>
                  <tr id="<?php echo $inspInstData[$i]->site_visiting_id;?>">
                  
                    <td><?php echo $inspInstData[$i]->fo_name; ?>
                    <input type="hidden" name="link_<?php echo $inspInstData[$i]->site_visiting_id;?>" id="link_<?php echo $inspInstData[$i]->site_visiting_id;?>" value="<?php echo $inspInstData[$i]->map_link;?>"> </td>
                    <td><?php echo date('Y-m-d',  strtotime($inspInstData[$i]->visiting_time)); ?>
                    </td>
                    <td><?php echo date('H:i:s',strtotime($inspInstData[$i]->visiting_time)); ?>
                    </td>
                    <!-- <td><?php if($inspInstData[$i]->custom == 1){ echo 'Custom'; }else if($inspInstData[$i]->guard_id){ echo 'Guard'; } else{ echo 'Site';} ?></td> -->
                    <td><?php echo $inspInstData[$i]->site_title; ?></td>
                    <td><a href="<?php echo site_url('guard/survey/'.base64_encode($inspInstData[$i]->site_visiting_id)); ?>"><?php echo (empty($inspInstData[$i]->total_answer)?'0':$inspInstData[$i]->total_answer).'/'.(empty($inspInstData[$i]->total_question)?'0':$inspInstData[$i]->total_question); ?></a>
                    </td>
                    <td><?php echo round($inspInstData[$i]->delta).'m'; ?></td>
                    <td><?php echo $inspInstData[$i]->distance_to.'km';
                        $totalkms+= $inspInstData[$i]->distance_to; ?>
                    </td>                    
                  </tr><?php
                         }
                         }
                     ?>
                  <tr>
                    <td colspan="6" align="right"><strong>Total</strong></td>
                    <td><strong><?php echo $totalkms.' KMs'; ?> </strong></td>
                  </tr>
                  <?php
                  }
                          else{ ?>
                  <tr>
                    <td colspan="8">No Records!</td>
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


<!-- END PAGE CONTENT WRAPPER -->                                    
</div>      


