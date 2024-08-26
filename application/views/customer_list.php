<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">

<form action="" method="post" name="list_form" id="list_form">
  <input type="hidden" name="page" value="<?php if(isset($page)) {  echo $page; } else {  echo 1; }  ?>" id="page" />
    <!-- START MANY COLUMNS  -->
    <div class="row">
        <div class="col-md-12">
            <div class="page-title">
            <div class="row-minus">
                <div class="col-md-3">
                    <h2>Customer List</h2>                    
                </div>

                 <div class="row-minus">        
            
                <div class="form-group">
                    <div class="col-md-3">
                        <div class="input-group">
                            <input class="form-control" placeholder="Search" type="text"  name="search_result" required /> 
                        </div>
                    
                   
                   
                        <div class="input-group pull-left">
                            <button class="btn btn-primary">Filter</button>     
                            <button style="margin-top: 9px;" class="btn btn-default reset" type="reset" value="Reset">Reset</button>                                                  
                        </div>

                       
                   </div>
                </div>
             
            </div>
                </div>
            <!--   <?php if($this->user->role_code != 'sadmin'){ ?> 
               <div class="col-md-3">
                    <div class="input-group">
                        <select class="form-control select" name="company_id" id="company_id">
                            <option value="">Select Company Name</option>
                            <?php
                                for($i=0;$i<count($companyDropDown);$i++)
                                { ?>
                                    <option value="<?php echo $companyDropDown[$i]->company_id;?>"
                                    <?php if($companyDropDown[$i]->company_id == $f_company_id)
                                    { echo 'selected="selected"';} 
                                    ?>
                                    >
                                    <?php echo $companyDropDown[$i]->company_name; ?>
                                    </option>                                                                    
                                    <?php 
                                } ?>
                        </select>
                    </div>
                </div>
               
                <div class="col-md-2">
                    <div class="input-group">
                        <button class="btn btn-primary pull-right">Filter</button>                                                        
                    </div>
                    
                    
                </div>
                <?php } ?> -->
                <?php if(in_array('add_customer', $tasks)){ ?>

                <a  href="<?php echo site_url('customer/addEditCustomer'); ?>" class="btn btn-primary" style="float:right;">Add New Customer</a>
                <?php } ?>                 

            </div>


            <div class="panel panel-default">
                
                
                <?php if($this->session->flashdata('successMessage')){?>
                    <div class="alert alert-success" >
                        <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <strong><?php echo $this->session->flashdata('successMessage'); ?></strong> 
                    </div>
                    <?php } ?>
                <div class="panel-body panel-body-table">


                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-actions">
                            <thead>
                                <tr>
                                    <th>Customer Name</th>
                                    <th>Company Name</th>
                                    <th>Address</th>
                                    <th>E-mail</th>
                                    <!--<th>Billing Contact</th>-->
                                    <th>Primary Contact</th>
                                    <th>System Id</th>
                                    <?php if(in_array('edit_customer', $tasks) || in_array('site_list', $tasks)|| in_array('update_customer_status', $tasks)){ ?>
                                    <th width="12%">Actions</th>
                                     <?php } ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(count($customerData)>0){
                                        for($i=0;$i<count($customerData);$i++){
                                    
                                    ?>
                                <tr>
                                    <td><?php echo $customerData[$i]->customer_name; ?></td>     
                                    <td><?php echo $customerData[$i]->company_name; ?></td>            
                                    <td><?php echo $customerData[$i]->address; 
                                              echo $customerData[$i]->zip?'<br/>'.$customerData[$i]->zip:'';
                                    ?></td>
                                    <td><?php echo $customerData[$i]->email; ?></td>                                    
                                    <!--<td><?php echo $customerData[$i]->billing_contact; ?></td>-->

                                    <td><?php echo $customerData[$i]->relational_contact; ?></td>
                                    <td><?php echo $customerData[$i]->system_id; ?></td>
                                     <?php if(in_array('edit_customer', $tasks) || in_array('site_list', $tasks)|| in_array('update_customer_status', $tasks)){ ?>
                                     <td>
                                         <?php if(in_array('edit_customer', $tasks)){ ?>  
                                         <a title="Edit" class="btn btn-danger btn-condensed" href="<?php echo site_url('customer/addEditCustomer/'. base64_encode($customerData[$i]->customer_id)); ?>" ><span class="fa fa-pencil"></span></a>
                                         <?php } ?>
                                         
                                       

                                        <?php if(in_array('update_customer_status', $tasks)){ ?>  
                                         <?php if($customerData[$i]->status){ ?>
                                         <a title="Click to Deactivate" id="cust<?php echo $customerData[$i]->customer_id ; ?>" data-box="#mb-update-status"  class="mb-control btn btn-danger btn-condensed" href="javascript:void(0);" onclick="showPublishedCusomerBox('<?php echo site_url(); ?>','<?php echo $customerData[$i]->customer_id ; ?>',1,'<?php echo $customerData[$i]->customer_name ; ?>');" ><span class="fa fa-check"></span></a>
                                         <?php }else{ ?>
                                         <a title="Click to Activate" id="cust<?php echo $customerData[$i]->customer_id ; ?>" data-box="#mb-update-status" class="mb-control btn btn-danger btn-condensed" href="javascript:void(0);" onclick="showPublishedCusomerBox('<?php echo site_url(); ?>','<?php echo $customerData[$i]->customer_id ; ?>',0,'<?php echo $customerData[$i]->customer_name ; ?>');" ><span class="fa fa-times"></span></a>
                                         <?php } ?>
                                        <?php } ?>
                                     </td>
                                     <?php } ?>
                                </tr>
                                <?php 
                                        }
                                    }else{ ?>
                                <tr ><td colspan="6">No Records!</td></tr>
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
                        <p id='update-msg-publish'>Are you sure you want to Activate ?</p>                    
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<script type="text/javascript">
    $(document).ready(function(){
        $('.reset').on('click',function(){
            var url="<?php echo site_url();?>";
               window.location.href = url+"customer";
        });
    });
</script>