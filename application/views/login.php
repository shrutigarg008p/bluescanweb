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
                    
                      <?php if($this->session->flashdata('successMessage')){?>
                    <div class="alert-success login-success col-md-12" >
                        <strong><?php echo $this->session->flashdata('successMessage'); ?></strong> 
                    </div>
                    <?php } ?>
                      <?php if($this->session->flashdata('errorMessage')){?>
                    <div class="alert-warning login-warning col-md-12" >
                        <strong><?php echo $this->session->flashdata('errorMessage'); ?></strong> 
                    </div>
                    <?php } ?>
                    
                    
                    <!-- <div class="login-title"><strong>Welcome</strong>, Please login</div> -->
                    <form action="<?php echo site_url('user/login')?>" class="form-horizontal" method="post">
                    <div class="form-group">
                        <div class="col-md-12">
                            <input type="text" class="form-control" placeholder="Username" name="username" id="username"/>
                            <?php echo form_error('username'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">
                            <input type="password" class="form-control" placeholder="Password" name="password" id="password"/>
                            <?php echo form_error('password'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6 pull-right" >
                            <a href="<?php echo site_url('user/forgotPassword')?>" class="btn btn-link btn-block" style="color: #003D7D;">Forgot your password?</a>
                        </div>
                        <div class="col-md-6">
                            <button class="btn btn-info btn-block">Log In</button>
                        </div>
                    </div>
                    </form>
                </div>
                <div style="text-align: center;margin-top: 12px;padding-left: 10px;float: left;">
                <a href="https://play.google.com/store/apps/details?id=com.sixdegreesit.securityapp&hl=en"><img src="<?php echo site_url('img/download-app02.jpg');?>" border="0"></a>
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






