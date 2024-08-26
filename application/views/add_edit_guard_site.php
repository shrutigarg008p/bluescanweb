    <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">
                
                    <div class="row">
                        <div class="col-md-12">
                     <?php if($this->session->flashdata('successMessage')){?>
                    <div class="alert alert-success" >
                        <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <strong><?php echo $this->session->flashdata('successMessage'); ?></strong> 
                    </div>
                    <?php } ?>
                            <form class="form-horizontal" action="" method="POST" >
                            <div class="page-title">
                                <h2><a  href="<?php echo site_url('site/guardSite');?>" class="btn btn-primary"><span class="fa fa-arrow-circle-o-left"></span>Back</a>
                                <?php echo $pageHeading; ?>
                                </h2>
                            </div>
                            
                            <div class="panel panel-default">
                                
                                   <div class="panel-body">                                                                        
                                    
                                    <div class="row">
                                        
                                        <div class="col-md-12">
                                            
                                            <div class="form-group col-md-12">
                                                
                                                <label class="col-md-2 control-label">Guard Name <span class="error">*</span></label>
                                                <div class="col-md-5">                                            
                                                    <div class="input-group">
                                                        <select class="form-control select" name="guard_name" id="guard_name" >
                                                        <?php if(count($guard_ids)>0)
                                                        { ?><option value="" >Select Guard Name</option>
                                                          <?php
                                                            for($i=0;$i<count($guard_ids);$i++)
                                                            { ?>
                                                                <option value="<?php echo $guard_ids[$i]->employee_id;?>"
                                                                    <?php if($guard_ids[$i]->employee_id == $guard_id)
                                                                        { echo 'selected="selected"';} 
                                                                    ?> >
                                                                    <?php echo $guard_ids[$i]->first_name.' '.$guard_ids[$i]->last_name;?>
                                                                </option>                                                                    
                                                            <?php 
                                                            } ?>
                                                            <?php
                                                        } ?>
                                                        </select>
                                                    </div>
                                                    <?php echo form_error('guard_name');?>
                                                </div>
                                            </div>
                                            
                                             
                                            <div class="form-group col-md-12">
                                                <label class="col-md-2 control-label">Start Date <span class="error">*</span></label>
                                                <div class="col-md-5">                                            
                                                    <div class="input-group">
                                                    <div class="input-group time-date">
                                                        <input type="text" class="form-control datepicker" name="start_date" id="start_date1" value="<?php echo set_value('start_date', $start_date); ?>" onchange="daterangeto(1);"/>
                                                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                          </div> 
                                          </div>
                                                <?php echo form_error('start_date');?>
                                                </div>  
                                          <div class="col-md-5">           

                                                        
                                                        <div class="input-group bootstrap-timepicker">
                                                            <input type="text" name="start_time" id="start_time" class="form-control timepicker" value="<?php echo set_value('start_time', $start_time); ?>" />
                                                            <span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>
                                                        </div>
                                            </div>
                                                
                                                    </div>
                                                    
                                          
                                        
                                            
                                            <div class="form-group col-md-12">
                                                <label class="col-md-2 control-label">End Date <span class="error">*</span></label>
                                                <div class="col-md-5">                                            
                                                    <div class="input-group ">
                                                    <div class="input-group time-date">
                                                        <input type="text" class="form-control datepicker" name="end_date" id="end_date1" value="<?php echo set_value('end_date', $end_date); ?>" onchange="daterangefrom(1);"/>
                                                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span></div></div>
                                                 <?php echo form_error('end_date');?>
                                                </div>
                                                        <div class="col-md-5"> 

                                                        <div class="input-group bootstrap-timepicker">
                                                            <input type="text" class="form-control timepicker" name="end_time" id="end_time"  value="<?php echo set_value('end_time', $end_time); ?>"  />
                                                            <span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>
                                                        </div>                        
                                                    </div>    
                                                   
                                                </div>
                                            </div> 

                                        </div>


                                        <div class="col-md-6">

                                            
                                        </div>                                        
                                    </div>

                                </div>
                               <div class="panel-footer">
                                    <button class="btn btn-primary pull-left">Submit</button>
                                </div>
                            </div>
                            </form>
                            
                        </div>
                    </div>                    
                    
                </div>
                <!-- END PAGE CONTENT WRAPPER -->  
               