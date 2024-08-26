<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $title; ?> - <?php echo $bioData->first_name.' '.$bioData->last_name ; ?></title>
<link type="text/css" href="<?php echo site_url('css/style.css'); ?>" rel="stylesheet"/>
</head>
<body style="margin:0; padding:0;">
<div class="profile-main">
  <header class="profile-header">
    <div class="profile-content">
        <div class="profile-toogle"><a href="<?php echo site_url('user/users'); ?>" ><span></span></a></div>
      <div class="profile-heading">Profile</div>
      <!--<div class="setting-menu"><a href="<?php// echo site_url('user/users'); ?>" ><span></span></a></div>-->
      <div class="clr"></div>
    </div>
  </header>
  <div class="sub-header">
    <div class="profile-content">
      <div class="sub-head-left">
          <h2><?php echo ucwords($bioData->first_name.' '.$bioData->last_name) ; ?></h2>
          <p><span><b>Current Employer</b></span>: <?php echo ucfirst($bioData->company_name); ?></p>
        <p><span><b>Native</b></span>: <?php echo ucfirst($bioData->l_city).', '.ucwords($bioData->l_state); ?> &nbsp;&nbsp;&nbsp; <span><b>Language Known</b></span>: <?php echo ucwords($bioData->language_known); ?> </p>
      </div>
      <div class="sub-head-right">
        <div class="star-ratting"> <img src="<?php echo site_url('assets/images/star-pic.jpg'); ?>" alt="" /><span>27 Reviews</span> </div>
      </div>
      <div class="clr"></div>
    </div>
  </div>
  <div class="profile-main-content">
   <div class="profile-content">
   <table class="rating-table">
   <tr>
   <td>Discipline</td>
   <td><img src="<?php echo site_url('assets/images/star-rating-five.jpg'); ?>" alt="" /></td>
   <td>2.5</td>
  
   <td rowspan="5">
        <?php if(isset($bioData->img_url)&&!empty($bioData->img_url)){ ?>
       <img src="<?php echo site_url('uploads/user_img/'.$bioData->img_url); ?>" alt="" width="250" class="profile-persion" />
    <?php } ?>
   </td>
  
   </tr>
   <tr>
   <td>Punctuality</td>
   <td><img src="<?php echo site_url('assets/images/star-rating-five.jpg'); ?>" alt="" /></td>
   <td>2.5</td>
   </tr>
      <tr>
   <td>Fitness</td>
   <td><img src="<?php echo site_url('assets/images/star-rating-five.jpg'); ?>" alt="" /></td>
   <td>2.5</td>
   </tr>
      <tr>
   <td>Cleverness</td>
   <td><img src="<?php echo site_url('assets/images/star-rating-five.jpg'); ?>" alt="" /></td>
   <td>2.5</td>
   </tr>
      <tr>
   <td>Cleanliness</td>
   <td><img src="<?php echo site_url('assets/images/star-rating-five.jpg'); ?>" alt="" /></td>
   <td>2.5</td>
   </tr>
   </table>
   <table class="identy">
   <tr>
   <td><img src="<?php echo site_url('assets/images/verified-1.jpg'); ?>" alt="" width="150" /></td>
   <td><img src="<?php echo site_url('assets/images/verified-2.jpg'); ?>" alt="" width="150" /></td>
   <td><img src="<?php echo site_url('assets/images/verified-2.jpg'); ?>" alt="" width="150" /></td>
   <td><img src="<?php echo site_url('assets/images/verified-4.jpg'); ?>" alt="" width="150" /></td>
   <td><img src="<?php echo site_url('assets/images/verified-5.jpg'); ?>" alt="" width="150" /></td>
   </tr>
   </table>
   <table class="summary" cellpadding="0" cellspacing="0">
   <thead>
   <tr class="summary-heading"><td>Employment Summary</td><td align="right"><img src="<?php echo site_url('assets/images/profile-arrow.jpg'); ?>" alt="" width="15" /></td></tr>
   </thead>
   <tbody>
       <?php if(count($experienceData)>0){ 
                for($i=0;$i<count($experienceData);$i++){
           ?>
   <tr>
   <td><?php echo $experienceData[$i]->company_name; ?></td><td><?php echo $experienceData[$i]->exp_duration_year; ?> Years</td>
   </tr>
       <?php } }else{ ?>
       <td colspan="2">No Employment Summary!</td>
     <?php  } ?>
   </tbody>
   
   </table>
       
   <table class="reviews" cellpadding="0" cellspacing="0">
   <thead>
    <tr class="summary-heading"><td>Employment Reviews</td><td align="right"><img  style="float:none;" src="<?php echo site_url('assets/images/profile-arrow.jpg'); ?>" alt="" width="15" /></td></tr>
   </thead>
   <tbody>
   <tr>
   <td valign="middle"><p><img src="<?php echo site_url('assets/images/employ-review-pic.jpg'); ?>" alt="" width="80" />Yash Chobe<br /><img src="<?php echo site_url('assets/images/star-rating-five.jpg'); ?>" width="200" alt="" /></p></td>
   <td align="right">Feb 21.2014 12:30PM<br /><a href="#">11 of 12 people found this review helpful</a></td>
   </tr>
      <tr>
   <td colspan="2">Lorem ipusm dolor site amet, consecteture adipiscing elit. Praesent eu Pulvinar ante, ac auctor ipusm. integer facilisis arcu libre...</td>
   </tr>
   </tbody>
   </table> 
   </div>
  </div>
  
  <footer class="profile-footer"><a href="#"><img src="<?php echo site_url('assets/images/f.png'); ?>" alt=""  /></a><a href="#"><img src="<?php echo site_url('assets/images/t.png'); ?>" alt=""  /></a><a href="#"><img src="<?php echo site_url('assets/images/g.png'); ?>" alt=""  /></a><a href="#"><img src="<?php echo site_url('assets/images/in.png'); ?>" alt=""  /></a></footer>
  
</div>
</body>
</html>
