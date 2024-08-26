        <!-- PAGE CONTENT WRAPPER -->                
        <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>        
        <script type="text/javascript" src='http://maps.google.com/maps/api/js?sensor=false&libraries=places'></script>
        <script src="<?php echo site_url(); ?>js/locationpicker.jquery.js"></script>        

                
                <div class="page-title">
                <div class="row"><div class="col-md-12">
                    <h2><a  href="<?php echo site_url('user/users');?>" class="btn btn-primary"><span class="fa fa-arrow-circle-o-left"></span>Back</a>
                    <?php echo $pageHeading; ?></h2></div></div>
                </div>
                <div class="page-tabs">                    
                    <?php                     
                    $userId = base64_decode($this->uri->segment(3));                    
                    if($userId!='')
                    {
                    ?>                        
                        <a href="<?php echo ($userId!='') ? 'user/addEditUsers/'.$this->uri->segment(3) : 'javascript:void(0)';?>">Bio-Data</a>                        
                        <a href="<?php echo ($userId!='') ? 'user/skills/'.$this->uri->segment(3) : 'javascript:void(0)';?>">Skills/Education/Experience</a>
                        <a href="<?php echo ($userId!='') ? 'user/financial/'.$this->uri->segment(3) : 'javascript:void(0)';?>">Financial/Banking Detail</a>
                        <a href="#third-tab" class="active">Documents</a>
                    <?php
                    }
                    ?>    
                </div>                
                <div class="page-content-wrap page-tabs-item active" id="third-tab">
                    <div class="row">
                        <div class="col-md-12">
                            <?php if($this->session->flashdata('successMessage')){?>
                            <div class="alert alert-success" >
                                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                <strong><?php echo $this->session->flashdata('successMessage'); ?></strong> 
                            </div>
                            <?php } ?>
                            
                            
                            
                            
                            <?php if(isset($messageArray) && !empty($messageArray)){?>
                            <div class="alert alert-warning" >
                                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                <strong><?php echo $messageArray; ?></strong> 
                            </div>
                            <?php } ?>
                            
                            
                            
                            
                            <form class="form-horizontal" action="" method="POST" id="documentform" enctype="multipart/form-data">                               
                            <div class="panel panel-default">

                                <div class="panel-body panel-body-table">                                    
                                    <div class="row">                                        
                                        <div class="col-md-12">                                            
                                            <div class="panel-heading">                                                                                               
                                                <span class="label label-success label-form">Upload Document</span>
                                                <a  title="Add Document" href="javascript:void(0);" class="btn btn-success btn-condensed" onclick="addMoreDocuments('<?php echo site_url(); ?>');"><i class="fa fa-plus"></i></a>
                                            </div>                                            
                                            <div  class="panel-body panel-body-table">
                                                <div class="table-responsive">
                                                    <table id="document_table" class="table table-bordered table-striped table-actions">
                                                        <thead>
                                                            <tr>
                                                              
                                                            	<th width="30%">Browse Documents</th>
                                                                <th width="20%">Document Type</th>
                                                                <th width="40%">Document Detail</th>                                                                
                                                                <th width="10%">Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                          <?php                                                             
                                                          if($doc_count>0){
                                                              for($j=0;$j<$doc_count;$j++)
                                                              {
                                                              ?>  
                                                          <tr id="doc_row_<?php echo $j+1; ?>">
                                                                <td class="text-center">
                                                                    <input type="hidden" value="<?php echo $j+1; ?>" name="doc_num[<?php echo $j; ?>]" id="doc_num_<?php echo $j+1; ?>" />
                                                                    <input type="file" class="fileinput" name="guard_upload_files[<?php echo $j; ?>]" id="filename<?php echo $j+1; ?>"/>                                                                        
                                                                    <?php echo form_error('guard_upload_files['.$j.']');?>
                                                                </td>
                                                                <td>
                                                                    <select class="form-control select" name="document_type[<?php echo $j; ?>]" id="document_type<?php echo $j+1; ?>" >
                                                                    <?php if(count($doc_type_ids)>0)
                                                                    { ?><option value="" >Select Document Type</option>
                                                                      <?php
                                                                        for($i=0;$i<count($doc_type_ids);$i++)
                                                                        { ?>
                                                                            <option value="<?php echo $doc_type_ids[$i]->document_type_id;?>"
                                                                                <?php if($doc_type_ids[$i]->document_type_id == $document_type_id[$j])
                                                                                    { echo 'selected="selected"';} 
                                                                                ?> >
                                                                                <?php echo $doc_type_ids[$i]->document_type;?>
                                                                            </option>

                                                                        <?php 
                                                                        } ?>
                                                                        <?php
                                                                    } ?>
                                                                    </select>
                                                                    <?php 
                                                                    echo form_error('document_type['.$j.']'); ?>
                                                                </td>
                                                                <td>
                                                                    <input type="text" class="form-control" id="docdetail<?php echo $j+1; ?>" name="docdetail[<?php echo $j; ?>]" value="<?php echo $document_content[$j]; ?>"/>                                                                    
                                                                    <?php echo form_error('docdetail['.$j.']');?>
                                                                </td>
                                                                <td>                                                                    
                                                                    <a title="Remove" href="javascript:void(0);" class="btn btn-success btn-condensed" onclick="removeDocument(<?php echo $j+1; ?>);"><i class="fa fa-times"></i></a>
                                                                </td>
                                                            </tr>
                                                            <?php
                                                              }
                                                          } ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="panel-footer">
                                     <input type="hidden" value="<?php echo $doc_count; ?>" name="doc_count" id="doc_count" />
                                    <button tabindex="18" name="upload_doc_button" value="upload_doc" class="btn btn-primary pull-left">Upload Item(s)</button>
                                </div>
                            </div>
                            
                            <?php
                            if(!empty($employeeDocumentData) && isset($employeeDocumentData))
                            { ?>
                            <div class="panel panel-default">
                                <div class="panel-body panel-body-table">                                    
                                    <div class="row">                                        
                                        <div class="col-md-12">                                            
                                            <div class="panel-heading">                                                                                               
                                                <span class="label label-warning label-form">Uploaded Documents</span>                                                
                                            </div>
                                            <div  class="panel-body panel-body-table">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered table-striped table-actions">
                                                        <thead>
                                                            <tr>
                                                                <th width="5%">&nbsp;</th>
                                                                <th>Document Type</th>
                                                                <th>Document Detail</th>
                                                                <th width="15%">Status</th>
                                                                <th width="15%">Actions</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                          <?php if(count($employeeDocumentData)>0){
                                                                for($i=0;$i<count($employeeDocumentData);$i++){
                                                            ?>
                                                            <tr>
                                                                <td>                                                                    
                                                                    <input type="checkbox" value="<?php echo $employeeDocumentData[$i]->document_url; ?>" name="remove_doc[]"/>
                                                                </td>
                                                               <td >
                                                                    <?php echo $employeeDocumentData[$i]->document_type; ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $employeeDocumentData[$i]->document_content; ?>
                                                                </td>
                                                                <td>
                                                                    <?php 
                                                                    if($employeeDocumentData[$i]->status == '1')
                                                                    { echo "Verified"; }
                                                                    elseif($employeeDocumentData[$i]->status == '2')
                                                                    { echo "Not verified"; }
                                                                    elseif($employeeDocumentData[$i]->status == '3')
                                                                    { echo "Suspect"; }
                                                                    else
                                                                    { echo "Pending for verify"; }
                                                                    ?>
                                                                </td>
                                                                <td>       
                                                                    <a title="View" href="<?php echo site_url().'uploads/guard_docs/'.$employeeDocumentData[$i]->document_url; ?>" target="blank" class="btn btn-danger btn-condensed"><span class="fa fa-paperclip"></span></a>
                                                                    <?php
                                                                    if($employeeDocumentData[$i]->status == 0){ ?>
                                                                    <a title="Click to Verify" id="docv<?php echo $employeeDocumentData[$i]->employee_document_id ; ?>" data-box="#mb-update-status" class="mb-control btn btn-danger btn-condensed" href="javascript:void(0);" onclick="verifyDocument('<?php echo site_url(); ?>','<?php echo $employeeDocumentData[$i]->employee_document_id; ?>');" ><span class="fa fa-check"></span></a>
                                                                    <?php } ?>
                                                                </td>
                                                            </tr>
                                                            <?php 
                                                                }
                                                            } ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="panel-footer">
                                    <button tabindex="18" name="remove_doc_button" value="remove_doc" class="btn btn-primary pull-left">Remove Item(s)</button>
                                    <?php echo form_error('remove_doc[]');?>
                                </div>
                            </div>
                            <?php
                            }
                            ?>
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
                <div id="published-title" class="mb-title">Do you really want to verify?</div>        
                   <p id="update-msg-publish">Verify Status</p>
                    <div class="col-md-8 verify-list">                                                                                            
                        <span>Verified          <input type="radio" tabindex="1" class="form-control" name="verify_status" value="1" id="verify_status"/></span>
                        <span>Not Satisfactory  <input type="radio" tabindex="2" class="form-control" name="verify_status" value="2" id="verify_status"/></span>
                        <span>Suspect           <input type="radio" tabindex="3" class="form-control" name="verify_status" value="3" id="verify_status"/></span>
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
</div>
<!-- END MESSAGE BOX-->
<script>
<?php if(count($doc_type_ids)>0){ ?>
    documnetsDropdownOption += '<option value="" >Select Document Type</option>';
<?php   for($i=0;$i<count($doc_type_ids);$i++){ ?>
            documnetsDropdownOption += '<option value="<?php echo $doc_type_ids[$i]->document_type_id; ?>"  ><?php echo $doc_type_ids[$i]->document_type;?></option>';                                                                    
<?php   } ?>
<?php } ?>    
</script>