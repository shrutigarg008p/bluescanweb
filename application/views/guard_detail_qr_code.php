<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Employee Details - <?php echo $guardDetails->first_name.' '.$guardDetails->last_name; ?></title>
<link href="<?php echo site_url('css/theme-default.css'); ?>" rel="stylesheet" />
</head>

<body style="margin:0; background:#fff;">

<div class="qrcode_window">
<div class="qrcode-popup">
   <?php    $session_company_logo = $this->session->userdata('session_company_logo'); 
        if(isset($session_company_logo)&&!empty($session_company_logo)){ ?>
       <img src="<?php echo $this->session->userdata('session_company_logo'); ?>" alt="Bluescan" title="Bluescan logo" width="230" />
        <?php }else{ ?>     
        <img src="<?php echo site_url('assets/images/webfinallogo1.png'); ?>" alt="Bluescan" title="Bluescan logo" width="230" />
        <?php } ?>
<table >
    <tr>
        <td align="right" valign="top" width="137"><b>Name</b></td>
        <td width="40" align="center" valign="top">:</td>
        <td align="left"><?php echo $guardDetails->first_name.' '.$guardDetails->last_name; ?></td>
    </tr>
    <?php
    $laddress = $guardDetails->l_address;
    $laddress .= isset($guardDetails->l_city) && !empty($guardDetails->l_city)?', '.$guardDetails->l_city:'';
    $laddress .= isset($guardDetails->l_state) && !empty($guardDetails->l_state)?', '.$guardDetails->l_state:'';
    $laddress .= isset($guardDetails->l_zip) && !empty($guardDetails->l_zip)?', '.$guardDetails->l_zip:'';
    if(trim($laddress) != ''){
    ?>
    <tr>
        <td align="right" valign="top" ><b>Local Address</b></td>
        <td width="40" align="center" valign="top">:</td>
        <td align="left"><?php echo trim($laddress); ?></td>
    </tr>
    <?php }
    $paddress = $guardDetails->p_address;
    $paddress .= isset($guardDetails->p_city) && !empty($guardDetails->p_city)?', '.$guardDetails->p_city:'';
    $paddress .= isset($guardDetails->p_state) && !empty($guardDetails->p_state)?', '.$guardDetails->p_state:'';
    $paddress .= isset($guardDetails->p_zip) && !empty($guardDetails->p_zip)?', '.$guardDetails->p_zip:'';
    if(trim($paddress) != ''){
    ?>
    
    <tr>
        <td align="right" valign="top"><b>Permanent Address</b></td>
        <td width="40" align="center" valign="top">:</td>
        <td align="left"><?php echo trim($paddress); ?></td>
    </tr>
    <?php } 
    if($guardDetails->mobile != ''){
    ?>
    <tr>
        <td align="right" valign="top"><b>Mobile</b></td>
        <td width="40" align="center" valign="top">:</td>
        <td align="left"><?php echo $guardDetails->mobile; ?></td>
    </tr>
    <?php } ?>
    <tr>
        <td colspan="3" style="text-align: center; border-bottom:none;">
            <img width="300px" height="300px" src="<?php echo site_url('uploads/guard/IMG_'.$guardDetails->qr_code); ?>" />
        </td>
    </tr>
</table>
</div>
<div style="text-align:center;font-size: 14px;padding: 10px 0 0;text-align: center;">Powered by <a href="http://www.bluescan.me/" target="_blank">BlueScan.me</a></div>
</div>
</body>
</html>
