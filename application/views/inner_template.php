<?php 
$userDetailsbySession   = unserialize($this->session->userdata('users'));
$vars['tasks']    = explode(',', $userDetailsbySession->user_tasks); 
$vars['user_name']  = $userDetailsbySession->name;
$vars['user_role']  = $userDetailsbySession->role_name;
$vars['mainTab']    = isset($mainTab)?$mainTab:'';
$user_role  = $userDetailsbySession->role_name;

?>
<!DOCTYPE html>
<html lang="en">
    <head>        
    	<?php include_once("analyticstracking.php") ?>
        <base href="<?php echo site_url('company');?>" />
        <!-- META SECTION -->
        <title><?php echo $title; ?></title>            
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        
      <!--  <link rel="icon" href="favicon.ico" type="image/x-icon" /> -->
        <!-- END META SECTION -->
        
        <!-- CSS INCLUDE -->        
        <link rel="stylesheet" type="text/css" id="theme" href="<?php echo site_url('css/theme-default.css');?>"/>
        <!-- EOF CSS INCLUDE -->    
        <script>
        var companyDropdownOption = '';
        var designationDropdown = ''; 
        var reasonDropdown = '';
        var documnetsDropdownOption = '';
        </script>
    </head>
    <body>
        <!-- START PAGE CONTAINER -->        
        <div class="page-container <?php if($this->session->flashdata('firstTimeLogin')){ echo 'page-navigation-toggled'; } ?> ">
            <?php $this->load->view('sidebar',$vars)?>
            
            <!-- PAGE CONTENT -->
            <div class="page-content">
                
                <!-- START X-NAVIGATION VERTICAL -->
                <ul class="x-navigation x-navigation-horizontal x-navigation-panel">
                  <!-- TOGGLE NAVIGATION -->
                    <li class="xn-icon-button">
                        <a href="javascript:void('');" class="x-navigation-minimize"><span class="fa fa-dedent"></span></a>
                    </li>
                    <!-- END TOGGLE NAVIGATION -->
                   <!-- POWER OFF -->
                   <?php if($userDetailsbySession->role_code == 'sadmin'){
                       
                            $companySessionData =  $this->cm->getAllCompanyList();
                                                        //print_r($companySessionData);
                       ?>
                  <li style="margin-top:5px;">                  
                        <form role="form">
                            <select class="form-control select" name="scompany_id" id="scompany_id" onchange="changeCompanyInSession('<?php echo site_url(); ?>')">    
                                <option value="">Select Company</option>
                     <?php
                        $sComapanyId = $this->session->userdata('session_company_id');
                            for($i=0;$i<count($companySessionData);$i++)
                            { ?>
                                <option value="<?php echo $companySessionData[$i]->company_id;?>"
                                <?php if($companySessionData[$i]->company_id == $sComapanyId)
                                { echo 'selected="selected"';} 
                                ?>
                                >
                                <?php echo $companySessionData[$i]->company_name; ?>
                                </option>                                                                    
                                <?php 
                            } ?>
                         </select>                         
                        </form>                        
                    </li>
                   <?php } ?>
                    <li class="xn-icon-button pull-right last">
                        <a href="<?php echo site_url('user/logout');?>" title="Logout"><span class="fa fa-power-off"></span></a>                    </li> 
                     <li class="small-logo n pull-right last">
                         <?php 
                         $session_company_logo = $this->session->userdata('session_company_logo');
                        if(isset($session_company_logo)&&!empty($session_company_logo)){ ?>
                        <img src="<?php echo $this->session->userdata('session_company_logo');?>" alt="<?php echo $companySessionData[$i]->company_name; ?>" title="<?php echo $companySessionData[$i]->company_name; ?> logo" />
                        <?php } ?>
                     </li>
                    
                    <!-- END POWER OFF -->                    
                </ul>
                <!-- END X-NAVIGATION VERTICAL -->                     
                
                <!-- PAGE CONTENT WRAPPER -->
                 <?php $this->load->view($contentView,$vars); ?>
                <!-- END PAGE CONTENT WRAPPER -->                                
            </div>            
            <!-- END PAGE CONTENT -->
        </div>
        <!-- END PAGE CONTAINER -->



           <!-- START SCRIPTS -->
        <!-- START PLUGINS -->
        <script type="text/javascript" src="<?php echo site_url('js/plugins/jquery/jquery.min.js'); ?>"></script>
        <script type="text/javascript" src="<?php echo site_url('js/plugins/jquery/jquery-ui.min.js'); ?>"></script>
        <script type="text/javascript" src="<?php echo site_url('js/plugins/bootstrap/bootstrap.min.js'); ?>"></script>        
        <!-- END PLUGINS -->

        <!-- START THIS PAGE PLUGINS-->        
           
        <script type='text/javascript' src='<?php echo site_url('js/plugins/icheck/icheck.min.js'); ?>'></script>        
        <script type='text/javascript' src='<?php echo site_url('js/plugins/bootstrap/bootstrap-datepicker.js'); ?>'></script>   
        
        <script type="text/javascript" src="<?php echo site_url('js/plugins/bootstrap/bootstrap-timepicker.min.js'); ?>"></script>             
        <script type="text/javascript" src="<?php echo site_url('js/plugins/daterangepicker/daterangepicker.js'); ?>"></script>
        
        <!-- END THIS PAGE PLUGINS-->        

        <!-- START TEMPLATE -->
        <script type="text/javascript" src="<?php echo site_url('js/actions.js'); ?>"></script>
        <script type="text/javascript" src="<?php echo site_url('js/custom.js'); ?>"></script>        
        <!-- END TEMPLATE -->
    <!-- END SCRIPTS -->       

    
    <footer>Powered by <a href = "http://www.6degreesit.com" target="_blank">6DegreesIT</a></footer>
    </body>
</html>