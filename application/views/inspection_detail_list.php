
<!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">
                    <form action="" class="form-horizontal" method="post" name="list_form" id="list_form">                        
                    <div class="row">
                        <div class="col-md-12">                            
                          <div class="page-title">
                                    <h2><a  href="<?php echo site_url('inspection/inspectionList'); ?>" class="btn btn-primary"><span class="fa fa-arrow-circle-o-left"></span>Back</a>
                                    Inspection Detail</h2>
                                </div>  
                            <div class="panel panel-default">
                                

                                <div class="panel-body">                                                                                                            
                                    <div class="form-group">
                                        <label class="col-md-2 col-xs-12 control-label">Site Name:</label>
                                        <div class="col-md-4 col-xs-12">                                                                                        
                                            <label class="control-label"><?php echo $inspectData->city; ?></label>
                                        </div>
                                   
                                        <label class="col-md-2 col-xs-12 control-label">Field Officer Name:</label>
                                        <div class="col-md-3 col-xs-12">                                                                                        
                                            <label class="control-label"><?php echo $inspectData->officer; ?></label>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="col-md-2 col-xs-12 control-label">Guard Name:</label>
                                        <div class="col-md-4 col-xs-12">                                                                           
                                                     
                                            <label class="control-label"><?php echo $inspectData->guard_name; ?></label>
                                        </div>
                                   
                                        <label class="col-md-2 col-xs-12 control-label">Site Address:</label>
                                        <div class="col-md-4 col-xs-12">                                                                                        
                                            <label class="control-label"><?php echo $inspectData->address; ?></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                          
                        </div>
                    </div>                    
                    </form>
                </div>
                <!-- END PAGE CONTENT WRAPPER -->  




<!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">
                    <form action="" class="form-horizontal" method="post" name="list_form" id="list_form">                        
                    <div class="row">
                        <div class="col-md-12">                            
                            
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><strong>Question</strong> Answers Detail</h3>
                                </div>

                                <div class="panel-body"> 
                                
                                 <span class="quedate">   <?php 

                                        if(count($questionData)>0)
                                        {
                                            for($i=0;$i<count($questionData);$i++)
                                            {   
                                                $currentrecdate=date('Y-m-d',strtotime($questionData[$i]->askdate));
                                                $j=($i==0)?0:($i-1);
                                                $prevrecdate=date('Y-m-d',strtotime($questionData[$j]->askdate));

                                                if(($currentrecdate<>$prevrecdate)|| $i==0)
                                                {   echo $currentrecdate; }

                                                ?></span>                                                
                                                <div class="form-group clearfix">
                                                    <label class="col-md-3 col-xs-12 control-label">Question:</label>
                                                    <div class="col-md-9 col-xs-12">                                                                                        
                                                        <label class="control-label"><?php echo $questionData[$i]->question;  ?></label>
                                                    </div>

                                                    <label class="col-md-3 col-xs-12 control-label">Answer:</label>
                                                    <div class="col-md-9 col-xs-12">                                                                                        
                                                        <label class="control-label"><?php echo $answer=empty($questionData[$i]->answer)?'Pending':$questionData[$i]->answer;  ?></label>
                                                    </div>
                                                </div>
                                                <hr>
                                                <?php
                                            }
                                        }
                                        else
                                        {
                                            echo "No Records!";
                                        }
                                     ?>  
                                    
                                </div> <P>&nbsp;</P>
                            </div>
                          
                        </div>
                    </div>                    
                    </form>
                </div>
                <!-- END PAGE CONTENT WRAPPER -->  



