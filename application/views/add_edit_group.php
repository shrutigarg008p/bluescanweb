
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
                        <h2><a  href="<?php echo site_url('question/questionGroupList/'.$this->uri->segment(3));?>" class="btn btn-primary"><span class="fa fa-arrow-circle-o-left"></span>Back</a>
                        <?php echo $pageHeading.' ('.$companyName.')' ; ?>
                            </h2>

</div>   <div class="panel panel-default">
                         
                         
                                
                                   <div class="panel-body">                                                                        
                                    
                                    <div class="row">
                                        
                                        <div class="col-md-6">
                                            
                                            <div class="form-group">
                                                
                                                <label class="col-md-3 control-label">Group Name <span class="error">*</span></label>
                                                <div class="col-md-9">                                            
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" name="group_name" id="group_name" value="<?php echo set_value('group_name', $group_name); ?>" />
                                                    </div>     
                                                    <?php echo form_error('group_name');?>
                                                </div>
                                            </div>
                                            
                                            
                                            <?php if(!empty($questionData)){ ?>
                                            
                                            <?php } ?>
                                         
                                        </div>


                                        <div class="col-md-6">
                                            
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Description</label>
                                                <div class="col-md-9">                                            
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" name="description" id="description" value="<?php echo set_value('description', $description); ?>" />
                                                    </div>     
                                                    <?php echo form_error('description');?>
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>

                                </div>
                                
                                   <div class="panel-footer">
                                    <button class="btn btn-primary pull-left">Submit</button>
                                </div>       
                                
                               
                            </div>
                                
                                <div class="panel panel-default">
                                <?php if(!empty($questionData)&& $groupId!=''){ ?>
                                <div class="panel-heading">
                                    <h3 class="panel-title"><strong>Add Question</strong></h3>
                                </div>
                                   <div class="panel-body">                                                                        
                                    
                                        
                                        <div class="col-md-8">
                                
                                       
                                           <div class="form-group">
                                               <label class="col-md-3 control-label">Questions</label>
                                               <div class="col-md-6">                                                                                            
                                                   <select class="form-control select" name="question" id="question"  >
                                                      <?php if(count($questionData)>0){ ?>
                                                       <option value="" >Select Question</option>
                                                        <?php        for($i=0;$i<count($questionData);$i++){ ?>
                                                       <option value="<?php echo $questionData[$i]->question_id;?>"  ><?php echo $questionData[$i]->question;?></option>
                                                        <?php } ?>
                                                      <?php  } ?>
                                                    </select>
                                               </div>
                                               <a title="Add Question" class="btn btn-danger btn-condensed" href="javascript:void(0);" onclick="addQuestioniInGroup('<?php echo site_url(); ?>','<?php echo $groupId; ?>');" ><span class="fa fa-plus"></span></a>

                                           </div>
                                       
                                        </div>
                                   </div>
                                    <?php } ?>
                                    
                                    <div class="panel-body panel-body-table" id="ques_group_div" <?php if(empty($groupQuestionData)){ ?>style="display: none;"<?php } ?>>
                    
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped table-actions" id="group-ques-id">
                                            <thead>
                                                <tr>
                                                    <th>Question</th>
                                                    <th width="12%">Action</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                    for($i=0;$i<count($groupQuestionData);$i++){ ?>
                                                     <tr id="ques-grp-<?php echo $groupQuestionData[$i]->question_group_id; ?>" ><td><?php echo $groupQuestionData[$i]->question; ?></td><td><a title="Delete"  data-box="#mb-update-status" class="mb-control btn btn-danger btn-condensed" href="javascript:void(0);" onclick="showGroupQuestionStatusBox('<?php echo site_url(); ?>','<?php echo $groupQuestionData[$i]->question_group_id; ?>');" ><span class="fa fa-times"></span></a></td></tr>
                                                <?php }
                                                 ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    </div> 
                                     
                                </div>
                                
                                
                                
                                
                                
                                
                                
                                
                            </form>
                            
                        </div>
                    </div>                    
                    
                </div>
                <!-- END PAGE CONTENT WRAPPER -->  
                
                
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