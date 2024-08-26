<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $title; ?></title>
<link href="<?php echo site_url('css/new-style.css'); ?>" rel="stylesheet" />
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,400italic,600,600italic,700,700italic,800,800italic|Open+Sans+Condensed:300,300italic,700' rel='stylesheet' type='text/css'>
</head>

<body>
<div class="persion-profile-box">
    <div class="left"><img class="prsn-logo" src="<?php echo site_url('assets/images/persion-logo.png'); ?>" alt="" /><div class="prsn-pic"><?php if($bioData->img_url!=''){ ?><img style="height:241px;width: 240px;" src="<?php echo site_url('uploads/user_img/'.$bioData->img_url); ?>" alt="" /><?php }else{ ?><img src="<?php echo site_url('assets/images/prsn-default.jpg'); ?>" alt="" /><?php } ?><?php if($bioData->blood_group!=''){ ?><span><?php echo $bioData->blood_group; ?><?php } ?></span></div>
<div class="prsn-details">
<h2><?php echo $bioData->first_name.' '.$bioData->last_name; ?></h2>
<span>Ph: <?php echo $bioData->mobile; ?></span>
<span><?php echo $bioData->email; ?></span>
<?php if($bioData->company_logo_url!=''){ ?>
<img style="height:150px;width: 130px;" src="<?php echo  site_url('uploads/company_img/company_thumb_img/'.$bioData->company_logo_url); ?>" />
<?php }else{ ?>
<img style="height:150px;width: 130px;" src="<?php echo  site_url('assets/images/default-2.jpg'); ?>" />
<?php } ?>
</div>
        <div class="qr-code"><img style="height:342px;width: 340px; " src="<?php echo site_url('uploads/guard/IMG_'.$bioData->qr_code); ?>" alt="" /></div>
</div>

</div>
</body>
</html>