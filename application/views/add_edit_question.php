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
                            <form class="form-horizontal" action="" method="POST">
                      <div class="page-title">
                        <h2><a  href="<?php echo site_url('question/questionList/'.$this->uri->segment(3));?>" class="btn btn-primary"><span class="fa fa-arrow-circle-o-left"></span>Back</a>
                        <?php echo $pageHeading.' ('.$companyName.')';  ?>
                        </h2>

</div>      <div class="panel panel-default">
                            
                            
                                
                                   <div class="panel-body">                                                                        
                                    
                                    <div class="row">
                                        
                                        <div class="col-md-6">
                                            
                                            <div class="form-group">
                                                <label class="col-md-4 control-label">Question <span class="error">*</span></label>
                                                <div class="col-md-8">                                            
                                             <div class="input-group">
                                                        <input tabindex="1" type="text" class="form-control" name="question" id="question" value="<?php echo set_value('question', $question); ?>" />
                                                    </div>     
                                                    <?php echo form_error('question');?>
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label class="col-md-4 control-label">Is Mandatory? <span class="error">*</span></label>
                                                <div class="col-md-8">                                            
                                                    <div class="input-group">
                                                        <div class="radio">
                                                        <label>
                                                            <input tabindex="3" type="radio" <?php if($is_mandatory == 1){ echo 'checked="checked"'; } ?>  value="1" id="is_mandatory" name="is_mandatory">
                                                            Yes
                                                        </label>

                                                        <label>
                                                            <input type="radio" <?php if($is_mandatory == 2){ echo 'checked="checked"'; } ?>  value="2" id="is_mandatory" name="is_mandatory">
                                                            No
                                                        </label>
                                                        </div>
                                                        <?php echo form_error('is_mandatory');?>
                                                    </div>    
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label class="col-md-4 control-label">Question Option</label>
                                                <div class="col-md-8">                                            
                                                    <div class="input-group">
                                                        <input tabindex="5" type="text" <?php if($questionType != 'select' && $questionType != 'radio'){ echo 'disabled="disabled"'; } ?> class="form-control" name="question_option" id="question_option" value="<?php echo set_value('question_option', $question_option); ?>" />
                                                    </div>     
                                                    <?php echo form_error('question_option');?>
                                                </div>
                                            </div>
                                         
                                        </div>


                                        <div class="col-md-6">
                                            
                                           <!-- <div class="form-group">
                                                <label class="col-md-4 control-label">Sequence <span class="error">*</span></label>
                                                <div class="col-md-8">                                            
                                                    <div class="input-group">
                                                        <input tabindex="2" type="text" class="form-control" name="sequence" id="sequence" value="<?php echo set_value('sequence', $sequence); ?>" />
                                                    </div>     
                                                    <?php echo form_error('sequence');?>
                                                </div>
                                            </div -->
                                            
                                            <div class="form-group">
                                                <label class="col-md-4 control-label">Question Type <span class="error">*</span></label>
                                                <div class="col-md-8">                                                                                            
                                                    <select tabindex="2" class="form-control select" name="question_type" id="question_type" onchange="enableQuestionOption();"  >
                                                       <?php if(count($questionTypeArray)>0){ ?>
                                                        <option value="" >Select Question Type</option>
                                                         <?php        foreach($questionTypeArray as $key=>$val){ ?>
                                                        <option value="<?php echo $val;?>" <?php if($val == $questionType){ echo 'selected="selected"';} ?> ><?php echo $val;?></option>
                                                                    
                                                         <?php       }
                                                           
                                                           
                                                           ?>
                                                           
                                                           
                                                           
                                                       <?php  } ?>
                                                     </select>
                                                    <?php echo form_error('question_type');?>
                                                </div>
                                                
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-4 control-label">Remark <span class="error">*</span></label>
                                                <div class="col-md-8">                                            
                                                    <div class="input-group">
                                                        <input tabindex="4" type="text" class="form-control" name="remark" id="remark" value="<?php echo set_value('remark', $remark); ?>" />
                                                    </div>   
                                                    <?php echo form_error('remark');?>
                                                </div>
                                            </div>
                                            
                                            
                                           
                                        </div>
                                        
                                    </div>

                                </div>
                               <div class="panel-footer">
                                    <button tabindex="7"  class="btn btn-primary pull-left">Submit</button>
                                </div>
                            </div>
                            </form>
                            
                        </div>
                    </div>                    
                    
                </div>
                <!-- END PAGE CONTENT WRAPPER -->  