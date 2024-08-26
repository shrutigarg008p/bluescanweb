                 <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">
                    
                    <div class="row">
                        <div class="col-md-12">
                            
                            <div class="panel panel-default">
                                <div class="panel-body">                            
                                    <?php
                                    if(count($surveyData)>0)
                                    { ?>

                                    <h2>Survey Response <strong> ID#<?php echo $surveyData[0]->svid; ?></strong></h2>
                                       <!--<div class="push-down-10 pull-right">
                                        <button class="btn btn-default"><span class="fa fa-print"></span> Print</button>                                        
                                    </div>-->
                                    <!-- INVOICE -->                                    
                                    <div class="invoice">
                                        <div class="row">
                                            <?php 
                                            if(!empty($surveyData[0]->sitename))
                                            {?>
                                                <table class="table table-bordered table-striped table-actions">
                                                <thead>
                                                <tr><th><strong>Site</strong></th><th><strong>Field Officer</strong></th></tr>
                                                </thead>
                                                <tbody><tbody><tr><td>
                                                <table><tbody><tr><td><strong>Name</strong></td><td width="20" align="center">:</td><td><?php echo $surveyData[0]->sitename; ?>
                                                </td></tr>
                                                <tr><td><strong>Address</strong></td><td width="20" align="center">:</td><td><?php  echo (!empty($surveyData[0]->s_address)?'<p>'.$surveyData[0]->s_address.'</p>':''); ?></td></tr>
                                                </tbody></table>
                                                </td><td><table><tbody><tr><td><strong>Name</strong></td><td  width="20" align="center">:</td><td><?php echo $surveyData[0]->username; ?></td></tr><tr><td><strong>Address</strong></td><td width="20" align="center">:</td><td><?php  echo (!empty($surveyData[0]->uadd)?''.$surveyData[0]->uadd.'':''); ?></td></tr></tbody></table></td></tr></tbody></tbody>
                                                </table>
                                                
                                                    
                                            <?php                                                                                                
                                            }else if($surveyData[0]->custom == 1){ ?>
                                                
                                                        <h3>Custom Inspection</h4>
                                                    
                                           <?php }
                                            if(!empty($surveyData[0]->username))
                                            {?>
                                                
                                            <?php                                                
                                            }
                                            ?>

                                            <!--<div class="col-md-4">
                                                <div class="invoice-address">
                                                    <h5>Invoice</h5>
                                                    <table class="table table-striped">
                                                        <tr>
                                                            <td width="200">Invoice Number:</td><td class="text-right">#Y14-152</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Invoice Date:</td><td class="text-right">23/11/2015</td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong>Total:</strong></td><td class="text-right"><strong>$2,697.64</strong></td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>-->
                                        </div>
                                        
                                    
                                <?php if($surveyData[0]->custom == 1){ ?>
                                    <div class="row-minus">                                            
                                            <div class="col-md-12">
                                                <h3>Description</h3></th>
                                                <p><?php echo $surveyData[0]->description; ?></p>
                                            </div>
                                        </div>
                                    
                               <?php  }else{?>        
                                        <div class="">
                                            <table class="table table-bordered table-striped table-actions">
                                            <thead>
                                                <tr>
                                                    <th><h3 style="margin:0;">Survey Details</h3></th>
                                                    <th class="text-center"><h3 style="margin:0;">Status</h3></th>
                                                </tr></thead>
                                                 <?php
                                                 $status = '';                                                 
                                                 $answerCount = 0;   
                                                 $path = $this->config->item('image_path');
                                                for($i=0;$i<count($surveyData);$i++)
                                                {   
                                                    $status = '';
                                                    $status=(empty($surveyData[$i]->answer)?'Not attempted':'Attempted');
                                                    $answerCount += ($status=='Attempted'?1:0);
                                                    ?>
                                                    <tr>
                                                        <td>
                                                            <strong>Question: <?php echo $surveyData[$i]->question; ?></strong>                                                            
                                                            <p>Answer: <?php 


                                                                                     if($surveyData[$i]->question_type == 'image'){
                                                                                        echo '<img src="'.site_url($path.$surveyData[$i]->answer).'" />';
                                                                                    }else{
                                                                                        echo $surveyData[$i]->answer; 
                                                                                    }


                                                                                //$path   = $path.'uploads/inspectionImage/';
                                                            ?></p>
                                                        </td>                                                    
                                                        <td class="text-center" <?php echo ($status=='Attempted'? 'style="color:#059A28 !important;"' : 'style="color:#FF0000 !important;"'); ?> > <?php echo $status; ?></td>
                                                    </tr><?php
                                                }
                                                ?>
                                            </table>
                                        </div>

                                                                        
                                        <div class="row">                                            
                                            
                                                <table class="table table-striped">
                                                    <tr>
                                                        <th colspan="2" style="background-color:#3fbae4;"><h3 style="color:#fff; margin:0;">Summary</h3></th>
                                                    </tr>
                                                    <tr>
                                                        <td width="200"><strong>Total Questions:</strong></td><td class="text-right"><?php echo $i; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Attempted Questions:</strong></td><td class="text-right"><?php echo $answerCount; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Unanswered Questions:</strong></td><td class="text-right"><?php echo ($i-$answerCount); ?></td>
                                                    </tr>
                                                    <tr class="total">
                                                        <td>Report:</td>
                                                        <td class="text-right">
                                                            <?php echo (($i-$answerCount)==0?'Complete':'Incomplete'); ?>
                                                        </td>
                                                    </tr>
                                                </table>                                                
                                            
                                        </div>      
                                <?php } ?>
                                        
                                    </div>
                                    <?php
                                    }
                                    else
                                    {
                                        echo "Records not available...!";
                                    }
                                    ?>
                                    <!-- END INVOICE -->

                                </div>
                            </div>
                    
                        </div>
                    </div>

                </div>
                <!-- END PAGE CONTENT WRAPPER -->     


