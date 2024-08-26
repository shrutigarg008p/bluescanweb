<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Site Details - <?php echo $siteDetails->site_title; ?></title>
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
        <td align="right" valign="top" width="100"><b>Site Title</b></td>
        <td width="40" align="center" valign="top" >:</td>
        <td align="left"><?php echo $siteDetails->site_title; ?></td>
    </tr>
    <tr>
        <td align="right" valign="top"><b>Company</b></td>
        <td width="40" align="center" valign="top">:</td>
        <td align="left"><?php echo $siteDetails->company_name; ?></td>
    </tr>
   <!-- <tr>
        <td align="right" valign="top"><b>Customer</b></td>
        <td width="40" align="center" valign="top">:</td>
        <td align="left"><?php echo $siteDetails->customer_name; ?></td>
    </tr> -->
    <?php   $saddress =   //address,city,state,country,zipcode
            $saddress = $siteDetails->address;
            $saddress .= isset($siteDetails->city) && !empty($siteDetails->city)?', '.$siteDetails->city:'';
            $saddress .= isset($siteDetails->state) && !empty($siteDetails->state)?', '.$siteDetails->state:'';
            $saddress .= isset($siteDetails->zipcode) && !empty($siteDetails->zipcode)?', '.$siteDetails->zipcode:'';
            $saddress .= isset($siteDetails->country) && !empty($siteDetails->country)?', '.$siteDetails->country:'';
            if(trim($saddress) != ''){ ?>
    <tr>
        <td align="right" valign="top"><b>Site Address</b></td>
        <td width="40" align="center" valign="top">:</td>
        <td align="left"><?php echo $saddress; ?></td>
    </tr>
            <?php } ?>
    <!--
    <tr>
        <td align="right" valign="top"><b>Contact</b></td>
        <td width="40" align="center" valign="top">:</td>
        <td align="left"><?php echo $siteDetails->contact_person.', '.$siteDetails->contact_number; ?></td>
    </tr>
    -->
    <tr>
        <td colspan="3" style="text-align: center; border-bottom:none;">
            <img width="330px" height="330px" src="<?php echo site_url('uploads/site/SITEIMG_'.$siteDetails->qr_code); ?>" />
        </td>
    </tr>
</table>
</div>
<div style="text-align:center;font-size: 14px;padding: 10px 0;text-align: center;">Powered by <a href="http://www.bluescan.me/" target="_blank">BlueScan.me</a></div>
</div>
</body>
</html>