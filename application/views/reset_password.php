<!DOCTYPE html>
<html lang="en" class="body-full-height">
    <head>      
    	<?php include_once("analyticstracking.php") ?>  
        <!-- META SECTION -->
        <title>BlueScan.me Web Dashboard</title>            
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        
        <link rel="icon" href="favicon.ico" type="image/x-icon" />
        <!-- END META SECTION -->
        
        <!-- CSS INCLUDE -->        
        <link rel="stylesheet" type="text/css" id="theme" href="<?php echo site_url('css/theme-default.css')?>"/>
        <!-- EOF CSS INCLUDE -->    
    </head>
    <body>
        
        <div class="login-container ">
        
            <div class="login-box animated fadeInDown">
                <div class="login-logo"></div>
                <div class="login-body">
                     <div class="login-title" style="color: #003D7D;">Reset Password</div> 
                     
                     <?php if($this->session->flashdata('successMessage')){?>
                    <div class="alert alert-success" >
                        <strong><?php echo $this->session->flashdata('successMessage'); ?></strong> 
                    </div>
                    <?php } ?>
                     
                     
                    <form action="" class="form-horizontal" method="post">
                    <div class="form-group">
                        <div class="col-md-12">
                            <input type="password" class="form-control" placeholder="New Password"  name="new_password" id="new_password"/>
                            <?php echo form_error('new_password'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">
                            <input type="password" class="form-control" placeholder="Confirm Password" name="confirm_password" id="confirm_password"/>
                            <?php echo form_error('confirm_password'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6 pull-right" >
                            <a href="<?php echo site_url('user/login')?>" class="btn btn-link btn-block" style="color: #003D7D;">Login</a>
                        </div>
                        <div class="col-md-6">
                            <input type="hidden" name="url" value="<?php echo $url; ?>"/>
                            <button class="btn btn-info btn-block">Submit</button>
                        </div>
                    </div>
                    </form>
                </div>
                
                <div class="login-footer">
                    <div class="pull-left">
                       
                    </div>
                    <div class="" style="text-align: center">
                           <footer><span class="footer-version">Version <?php echo $this->config->item('web_version'); ?> </span>Powered by <a href = "http://www.6degreesit.com" target="_blank">6DegreesIT</a></footer>
           
                    </div>
                </div>
                </div>
            
        </div>
        
    </body>
    
</html>






