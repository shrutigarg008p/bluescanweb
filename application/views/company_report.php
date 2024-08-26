<!-- PAGE CONTENT WRAPPER -->

<div class="page-content-wrap">
<form action="" method="post" name="list_form" id="list_form">
    <!-- START MANY COLUMNS  -->
    <div class="row">
        <div class="col-md-12">
        <div class="page-title">
            <h2><?php echo "Drill-Down Report"; ?> <div class="col-md-4 pull-right" style="padding-top:5px;"><div class="col-md-10" style="padding:0;"><input placeholder="Select Date" type="text" class="form-control datepicker" id="start_date" name="start_date" value="<?php echo $start_date; ?>"  /></div> <div class="col-md-2"><button class="btn btn-primary pull-left" style="margin:0;">Go</button></div></div></h2>                   
        </div>
            <div class="panel panel-default">				
				    
                
                <div class="panel-body panel-body-table">
                    
                    <div class="table-responsive">
                       <?php if($roleCode == 'sadmin' || $roleCode == 'cuser' || $roleCode == 'cadmin'){ ?>
                        
                         <table class="table table-bordered table-striped table-actions" id="companyrepo">
                            <thead>
                                <tr>
                                    <th width="40%">Company Name</th>
                                    <th >Distance</th>
                                    <th width="20%">Total Sites</th>
                                    <th width="20%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php                             
                                    for($i=0;$i<count($reportDataByCompany);$i++)
                                    {              
                                  ?>
                                <tr>
                                    <td><?php echo $reportDataByCompany[$i]->company_name; ?></td>
                                    <td><?php echo round($reportDataByCompany[$i]->siteConvenc,2).'km'; ?></td>
                                    <td><?php echo $reportDataByCompany[$i]->siteVisit; ?></td>
                                    <td> <a title="Open Region Drilldown"  id="tableopen<?php echo $i; ?>" class="btn btn-success btn-condensed" onclick="tableaccordianopen(<?php echo $i; ?>);"><i class="fa fa-plus"></i></a>                                    

                                        <a title="Close Region Drilldown" style="display:none;" id="tableclose<?php echo $i; ?>" class="btn btn-success btn-condensed" onclick="tableaccordianclose(<?php echo $i; ?>);"><i class="fa fa-minus"></i></a>
                                    <a title="Conveyance Report" class="btn btn-success btn-condensed" href="<?php echo site_url('report/index/'.base64_encode($reportDataByCompany[$i]->company_id)); ?>" ><span class="fa fa-eye"></span></a>
                                    </td>
                                </tr>
                                <tr style="display:none;" id="tablebody<?php echo $i;?>">
                                <td colspan="4">
                                 <table class="table table-bordered table-striped table-actions" >
                                          <thead>
                                              <tr>
                                                  <th width="40%">Region</th>
                                                  <th >Distance</th>
                                                  <th width="20%">Total Sites</th>
                                                  <th>Action </th>
                                              </tr>
                                          </thead>
                                          <tbody>
                                 <?php                             
                              for($j=0;$j<count($reportDataByRegion);$j++)
                              {
                                  if($reportDataByRegion[$j]->company_id == $reportDataByCompany[$i]->company_id)
                                  {
                              ?>
                                
                                <tr>
                                    <td width="40%"><?php echo $reportDataByRegion[$j]->region_name; ?></td>
                                    <td ><?php echo round($reportDataByRegion[$j]->siteConvenc,2).'km'; ?></td>
                                    <td width="20%"><?php echo $reportDataByRegion[$j]->siteVisit; ?></td>
                                    <td>
                                    <a title="Open Branch Drilldown" id="tableopenr<?php echo $i.$j; ?>" class="btn btn-success btn-condensed" onclick="tableaccordianopen('r<?php echo $i.$j; ?>');"><i class="fa fa-plus"></i></a>
                                    <a title="Close Branch Drilldown" style="display:none;" id="tablecloser<?php echo $i.$j; ?>" class="btn btn-success btn-condensed" onclick="tableaccordianclose('r<?php echo $i.$j; ?>');"><i class="fa fa-minus"></i></a>
                                    <a title="Conveyance Report" class="btn btn-success btn-condensed" class="btn btn-success btn-condensed" href="<?php echo site_url('report/index/'.base64_encode($reportDataByCompany[$i]->company_id.'_'.$reportDataByRegion[$j]->region_id)); ?>"><span class="fa fa-eye"></span></a></td>
                                    <!--<th></th>-->
                                </tr>
                                <tr style="display:none;" id="tablebodyr<?php echo $i.$j; ?>">
                                    <td colspan="4">
                                        <table class="table table-bordered table-striped table-actions" >
                                                            <thead style="background-color: #3fbae4;">
                                                                <tr>
                                                                    <th  width="40%">Branch</th>
                                                                    <th>Distance</th>
                                                                    <th  width="20%">Total Sites</th>
                                                                    <th>Action</th>
                                                                  
                                                                </tr>
                                                            </thead>
                                                            <tbody >
                                                                 <?php                             
                                                                for($k=0;$k<count($reportDataByBranch);$k++)
                                                                {
                                                                    if($reportDataByBranch[$k]->region_id == $reportDataByRegion[$j]->region_id)
                                                                    {
                                                                ?>
                                                                <tr>
                                                                    <td><?php echo $reportDataByBranch[$k]->branch_name; ?></td>
                                                                    <td><?php echo round($reportDataByBranch[$k]->siteConvenc,2).'km'; ?></td>
                                                                    <td><?php echo $reportDataByBranch[$k]->siteVisit; ?></td>
                                                                    <td>

                                                                    <a title="Open Site Drilldown"   id="tableopenb<?php echo $i.$j.$k; ?>" class="btn btn-success btn-condensed" onclick="tableaccordianopen('b<?php echo $i.$j.$k; ?>');"><i class="fa fa-plus"></i></a>
                                                                    <a title="Close Site Drilldown"  style="display:none;" id="tablecloseb<?php echo $i.$j.$k; ?>" class="btn btn-success btn-condensed" onclick="tableaccordianclose('b<?php echo $i.$j.$k; ?>');"><i class="fa fa-minus"></i></a>
                                                                    <a title="Conveyance Report" class="btn btn-success btn-condensed"  href="<?php echo site_url('report/index/'.base64_encode($reportDataByCompany[$i]->company_id.'_'.$reportDataByRegion[$j]->region_id.'_'.$reportDataByBranch[$k]->branch_id)); ?>" ><span class="fa fa-eye"></span></a></th>
                                                                    </td>
                                                                    <!--<th></th>-->
                                                                </tr>
                                                                 <tr style="display:none;" id="tablebodyb<?php echo $i.$j.$k; ?>">
                                                                 <td colspan="4">
                                                                    <table class="table table-bordered table-striped table-actions">
                                                                    <thead style="background-color: #3fbae4;">
                                                                        <tr>
                                                                           
                                                                            <th>Site</th>
                                                                            <th >Distance</th>
                                                                             <th >No of Visits</th>
                                                                            <th >Action</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody >
                                                                         <?php                             
                                                                        for($m=0;$m<count($reportDataBySite);$m++)
                                                                        {
                                                                            if($reportDataBySite[$m]->branch_id == $reportDataByBranch[$k]->branch_id)
                                                                            {
                                                                            ?>
                                                                            <tr>
                                                                             
                                                                              <td><?php echo $reportDataBySite[$m]->site_title; ?></td>
                                                                              <td><?php echo round($reportDataBySite[$m]->siteConvenc,2).'km'; ?></td>
                                                                               <td><?php echo $reportDataBySite[$m]->siteVisit; ?></td>
                                                                              <td>
                                                                              <a title="Conveyance Report" class="btn btn-success btn-condensed"  href="<?php echo site_url('report/index/'.base64_encode($reportDataByCompany[$i]->company_id.'_'.$reportDataByRegion[$j]->region_id.'_'.$reportDataByBranch[$k]->branch_id.'_'.$reportDataBySite[$m]->site_id)); ?>"><span class="fa fa-eye"></span></a></th>
                                                                              </td>                                                                      
                                                                            </tr>
                                                                        <?php
                                                                            }
                                                                         }
                                                                        ?>    
                                                                    </tbody>
                                                                    </table>
                                                                </td>
                                                                 </tr>
                                                                 <?php
                                                                    }
                                                                }                                    
                                                                ?> 
                                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                        
                                        
                                        
                                    </td>
                                </tr>
                                
                                
                                  <?php
                                  }
                                  } ?>
                                  </tbody>
                                 </table>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        
                       <?php }elseif ($roleCode == 'RM') {
                            
                        ?> 
                          
                         <table class="table table-bordered table-striped table-actions" >
                                          <thead>
                                              <tr>
                                                  <th width="40%">Region</th>
                                                  <th >Distance</th>
                                                  <th width="20%">Total Sites</th>
                                                  <th>Action </th>
                                              </tr>
                                          </thead>
                                          <tbody>
                                 <?php 
                              for($j=0;$j<count($reportDataByRegion);$j++)
                              {
                              ?>
                                
                                <tr>
                                    <td width="40%"><?php echo $reportDataByRegion[$j]->region_name; ?></td>
                                    <td ><?php echo round($reportDataByRegion[$j]->siteConvenc,2).'km'; ?></td>
                                    <td width="20%"><?php echo $reportDataByRegion[$j]->siteVisit; ?></td>
                                    <td>
                                    <label id="tableopenr<?php echo $j; ?>" class="btn btn-success btn-condensed" onclick="tableaccordianopen('r<?php echo $j; ?>');"><i class="fa fa-plus"></i></label>
                                    <label style="display:none;" id="tablecloser<?php echo $j; ?>" class="btn btn-success btn-condensed" onclick="tableaccordianclose('r<?php echo $j; ?>');"><i class="fa fa-minus"></i></label>
                                    <a class="btn btn-success btn-condensed" class="btn btn-success btn-condensed" href="<?php echo site_url('report/index/'.base64_encode($reportDataByRegion[$j]->region_id)); ?>"><span class="fa fa-eye"></span></a></td>
                                    <!--<th></th>-->
                                </tr>
                                <tr style="display:none;" id="tablebodyr<?php echo $j; ?>">
                                    <td colspan="4">
                                        <table class="table table-bordered table-striped table-actions" >
                                                            <thead style="background-color: #3fbae4;">
                                                                <tr>
                                                                    <th  width="40%">Branch</th>
                                                                    <th>Distance</th>
                                                                    <th  width="20%">Total Sites</th>
                                                                    <th>Action</th>
                                                                  
                                                                </tr>
                                                            </thead>
                                                            <tbody >
                                                                 <?php                             
                                                                for($k=0;$k<count($reportDataByBranch);$k++)
                                                                {
                                                                    if($reportDataByBranch[$k]->region_id == $reportDataByRegion[$j]->region_id)
                                                                    {
                                                                ?>
                                                                <tr>
                                                                    <td><?php echo $reportDataByBranch[$k]->branch_name; ?></td>
                                                                    <td><?php echo round($reportDataByBranch[$k]->siteConvenc,2).'km'; ?></td>
                                                                    <td><?php echo $reportDataByBranch[$k]->siteVisit; ?></td>
                                                                    <td>

                                                                    <label  id="tableopenb<?php echo $j.$k; ?>" class="btn btn-success btn-condensed" onclick="tableaccordianopen('b<?php echo $j.$k; ?>');"><i class="fa fa-plus"></i></label>
                                                                    <label style="display:none;" id="tablecloseb<?php echo $j.$k; ?>" class="btn btn-success btn-condensed" onclick="tableaccordianclose('b<?php echo $j.$k; ?>');"><i class="fa fa-minus"></i></label>
                                                                    <a class="btn btn-success btn-condensed"  href="<?php echo site_url('report/index/'.base64_encode($reportDataByRegion[$j]->region_id.'_'.$reportDataByBranch[$k]->branch_id)); ?>" ><span class="fa fa-eye"></span></a></th>
                                                                    </td>
                                                                    <!--<th></th>-->
                                                                </tr>
                                                                 <tr style="display:none;" id="tablebodyb<?php echo $j.$k; ?>">
                                                                 <td colspan="4">
                                                                    <table class="table table-bordered table-striped table-actions">
                                                                    <thead style="background-color: #3fbae4;">
                                                                        <tr>
                                                                           
                                                                            <th>Site</th>
                                                                            <th >Distance</th>
                                                                             <th >No of Visits </th>
                                                                            <th >Action</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody >
                                                                         <?php                             
                                                                        for($m=0;$m<count($reportDataBySite);$m++)
                                                                        {
                                                                            if($reportDataBySite[$m]->branch_id == $reportDataByBranch[$k]->branch_id)
                                                                            {
                                                                            ?>
                                                                            <tr>
                                                                             
                                                                              <td><?php echo $reportDataBySite[$m]->site_title; ?></td>
                                                                              <td><?php echo round($reportDataBySite[$m]->siteConvenc,2).'km'; ?></td>
                                                                               <td><?php echo $reportDataBySite[$m]->siteVisit; ?></td>
                                                                              <td>
                                                                              <a class="btn btn-success btn-condensed"  href="<?php echo site_url('report/index/'.base64_encode($reportDataByRegion[$j]->region_id.'_'.$reportDataByBranch[$k]->branch_id.'_'.$reportDataBySite[$m]->site_id)); ?>"><span class="fa fa-eye"></span></a></th>
                                                                              </td>                                                                      
                                                                            </tr>
                                                                        <?php
                                                                            }
                                                                         }
                                                                        ?>    
                                                                    </tbody>
                                                                    </table>
                                                                </td>
                                                                 </tr>
                                                                 <?php
                                                                    }
                                                                }                                    
                                                                ?> 
                                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                        
                                        
                                        
                                    </td>
                                </tr>
                                
                                
                                  <?php
                                  } ?>
                                  </tbody>
                                 </table>

                       
                        
                        
                        <?php }elseif ($roleCode == 'BM') {
                            
                         ?> 
                        
                          <table class="table table-bordered table-striped table-actions" >
                                                            <thead style="background-color: #3fbae4;">
                                                                <tr>
                                                                    <th  width="40%">Branch</th>
                                                                    <th>Distance</th>
                                                                    <th  width="20%">Total Sites</th>
                                                                    <th>Action</th>
                                                                  
                                                                </tr>
                                                            </thead>
                                                            <tbody >
                                                                 <?php    
                                                                for($k=0;$k<count($reportDataByBranch);$k++)
                                                                {
                                                                    
                                                                ?>
                                                                <tr>
                                                                    <td><?php echo $reportDataByBranch[$k]->branch_name; ?></td>
                                                                    <td><?php echo round($reportDataByBranch[$k]->siteConvenc,2).'km'; ?></td>
                                                                    <td><?php echo $reportDataByBranch[$k]->siteVisit; ?></td>
                                                                    <td>

                                                                    <label  id="tableopenb<?php echo $k; ?>" class="btn btn-success btn-condensed" onclick="tableaccordianopen('b<?php echo $k; ?>');"><i class="fa fa-plus"></i></label>
                                                                    <label style="display:none;" id="tablecloseb<?php echo $k; ?>" class="btn btn-success btn-condensed" onclick="tableaccordianclose('b<?php echo $k; ?>');"><i class="fa fa-minus"></i></label>
                                                                    <a class="btn btn-success btn-condensed"  href="<?php echo site_url('report/index/'.base64_encode($reportDataByBranch[$k]->branch_id)); ?>" ><span class="fa fa-eye"></span></a></th>
                                                                    </td>
                                                                    <!--<th></th>-->
                                                                </tr>
                                                                 <tr style="display:none;" id="tablebodyb<?php echo $k; ?>">
                                                                 <td colspan="4">
                                                                    <table class="table table-bordered table-striped table-actions">
                                                                    <thead style="background-color: #3fbae4;">
                                                                        <tr>
                                                                           
                                                                            <th>Site</th>
                                                                            <th >Distance</th>
                                                                             <th >No of Visits</th>
                                                                            <th >Action</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody >
                                                                         <?php                             
                                                                        for($m=0;$m<count($reportDataBySite);$m++)
                                                                        {
                                                                            if($reportDataBySite[$m]->branch_id == $reportDataByBranch[$k]->branch_id)
                                                                            {
                                                                            ?>
                                                                            <tr>
                                                                             
                                                                              <td><?php echo $reportDataBySite[$m]->site_title; ?></td>
                                                                              <td><?php echo round($reportDataBySite[$m]->siteConvenc,2).'km'; ?></td>
                                                                               <td><?php echo $reportDataBySite[$m]->siteVisit; ?></td>
                                                                              <td>
                                                                              <a class="btn btn-success btn-condensed"  href="<?php echo site_url('report/index/'.base64_encode($reportDataByBranch[$k]->branch_id.'_'.$reportDataBySite[$m]->site_id)); ?>"><span class="fa fa-eye"></span></a></th>
                                                                              </td>                                                                      
                                                                            </tr>
                                                                        <?php
                                                                            }
                                                                         }
                                                                        ?>    
                                                                    </tbody>
                                                                    </table>
                                                                </td>
                                                                 </tr>
                                                                 <?php
                                                                }                                    
                                                                ?> 
                                                            </tbody>
                                        </table>
                                    

                        
                        <?php }else{ ?>
                           <table class="table table-bordered table-striped table-actions">
                                                                    <thead style="background-color: #3fbae4;">
                                                                        <tr>
                                                                           
                                                                            <th>Site</th>
                                                                            <th >Distance</th>
                                                                             <th >No of Visits </th>
                                                                            <th >Action</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody >
                                                                         <?php                             
                                                                        for($m=0;$m<count($reportDataBySite);$m++)
                                                                        {
                                                                            ?>
                                                                            <tr>
                                                                             
                                                                              <td><?php echo $reportDataBySite[$m]->site_title; ?></td>
                                                                              <td><?php echo round($reportDataBySite[$m]->siteConvenc,2).'km'; ?></td>
                                                                               <td><?php echo $reportDataBySite[$m]->siteVisit; ?></td>
                                                                              <td>
                                                                              <a class="btn btn-success btn-condensed"  href="<?php echo site_url('report/index/'.base64_encode($reportDataBySite[$m]->site_id)); ?>"><span class="fa fa-eye"></span></a></th>
                                                                              </td>                                                                      
                                                                            </tr>
                                                                        <?php
                                                                         }
                                                                        ?>    
                                                                    </tbody>
                                                                    </table> 
                      <?php  } ?> 
                   
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END MANY COLUMNS  -->
</form>

<!-- END PAGE CONTENT WRAPPER -->                                    
</div> 