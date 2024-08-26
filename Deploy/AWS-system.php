<?php
$config['test'] = 1; 
$config['import_error_message']['100']  = "User has session expired!";

// content for admin for FO inspection
$config['email_content_for_admin_FO_inspection']   = 'Hi,<br/><br/> ##firstname## ##lastname## has been inspected the site and scan the QR code successfully ! The site name is ##address##  which is located in ##sitename## in ##city##<br/><br/><br/>Thanks & Regards<br/>BlueScan Team<br/>';

// content for customer when FO inspection his site
$config['email_content_for_customer_FO_inspection']   = 'Hi ##customername##,<br/><br/>Field Officer ##firstname## ##lastname## has inspect the site and scan the QR code successfully ! The site name is ##sitename##  which is located in ##address##. <br/><br/> Question And Answer Record:- <br/><br/> ##questionsanswer## <br/><br/><br/>Thanks & Regards<br/>BlueScan Team<br/>';

//number of records per page
$config['perPage'] = 10;

/*******-------------------------   Servcice Messages   ------------------------*******/
$config['exclude_service_header_check'] = array("login");

$config['response_format']          = 'json'; // json / xml
$config['print_overall_log']        = true; // true / false / 0 / 1
$config['print_service_log']        = array('login');
$config['print_log_type']           = 1; // 0 = print , 1 Write
$config['track_time_log']           = 1; // 0 = No , 1 Yes
$config['track_service_time_log']   = array(); // name of function not param parameter;
        

$config['service_responce_message']['101']  = "Incorrect Request";
$config['service_responce_message']['102']  = "Incorrect Header";
$config['service_responce_message']['103']  = "You have logged in from another device";
$config['service_responce_message']['104']  = "Incorrect UserId";
$config['service_responce_message']['105']  = "Username field cannot empty";
$config['service_responce_message']['106']  = "Password field cannot empty";
$config['service_responce_message']['107']  = "Incorrect User Name or Password";
$config['service_responce_message']['108']  = "No Record Found";
$config['service_responce_message']['109']  = "Record Inserted Successfully";
$config['service_responce_message']['110']  = "Your now Successfully logout";
$config['service_responce_message']['111']  = "Please send valid userId";
$config['service_responce_message']['112']  = "Please send all required parameter";
$config['service_responce_message']['113']  = "post_caption field can not empty";
$config['service_responce_message']['114']  = "image field can not empty";
$config['service_responce_message']['115']  = "apnstoken field cannot empty";
$config['service_responce_message']['116']  = "User Id is missing";
$config['service_responce_message']['117']  = "Site Id is missing";
$config['service_responce_message']['118']  = "Datetime is missing";
$config['service_responce_message']['119']  = "QR Code is missing";
$config['service_responce_message']['120']  = "Guard Id is missing";
$config['service_responce_message']['121']  = "Question Data is missing";
$config['service_responce_message']['122']  = "Latitude is missing";
$config['service_responce_message']['123']  = "Longitude Data is missing";
$config['service_responce_message']['124']  = "Question Answer Data is missing";
$config['service_responce_message']['125']      = "Question are not for this site";
$config['service_responce_message']['126']      = "Please respond to the madatory questions.";
$config['service_responce_message']['127']      = "Question are not set for this guard";
$config['service_responce_message']['128']  = "Description Data is missing";
$config['service_responce_message']['129']  = "Inspection Type Data is missing";
$config['service_responce_message']['130']  = "Attendance Mode is missing";
$config['service_responce_message']['131']  = 'Invalid QR Code Request';
$config['service_responce_message']['132']  = 'Guard Image is missing';
$config['service_responce_message']['133']  = 'Site visit id is missing';
$config['service_responce_message']['134']      = 'Invalid QR Code';
$config['service_responce_message']['135']  = "Your account is disabled.";
$config['service_responce_message']['136']  = "Rating is missing";
$config['service_responce_message']['137']  = "Comment is missing";

$config['service_responce_message']['138']  = "Discipline Rating is missing";
$config['service_responce_message']['139']  = "Punctuality Rating is missing";
$config['service_responce_message']['140']  = "Fitness Rating is missing";
$config['service_responce_message']['141']  = "Cleverness Rating is missing";
$config['service_responce_message']['142']  = "Cleanliness Rating is missing";
$config['service_responce_message']['143']  = "Designation Data is missing";


/*---------------------------------------------------------------------------------------*/

$config['questionTypeArray']  = array('1' => 'text',
                            '2' => 'select',
                            '3' => 'image',
                            '4' => 'radio');

$config['qr_code_site_prifix']  = 'S';
$config['qr_code_guard_prifix'] = 'G';

$config['image_path']  = './uploads/inspectionImage/';

$config['user_images'] = array(
                'upload_path'   => './uploads/user_img/',
                'allowed_types' => 'jpeg|png|jpg',
                'max_size'      => 250,
                'max_width'     => '1024',
                'max_height'    => '768',
                'file_name'     => 'user_img_'.date('dmYHis')
                );  

$config['user_profile_images'] = 'uploads/user_img/';

$config['user_images_thumb'] = array(
                'image_library' => 'gd2',
                'create_thumb'   => TRUE,
                'thumb_marker' => '',
                'maintain_ratio'      => TRUE,
                'width'     => 100,
                'height'    => 100,
                'new_image' =>  'uploads/thumb_path/'
                ); 

$config['company_profile_images'] = 'uploads/company_img/';

$config['company_images'] = array(
                'upload_path'   => './uploads/company_img/',
                'allowed_types' => 'jpeg|png|jpg',
                'max_size'      => 250,
                'file_name'     => 'com_img_'.date('dmYHis')
                ); 
$config['company_images_thumb'] = array(
                'image_library' => 'gd2',
                'create_thumb'   => TRUE,
                'thumb_marker' => '',
                'maintain_ratio'      => TRUE,
                'width'     => 44,
                'height'    => 50,
                'new_image' =>  'uploads/company_img/company_thumb_img/'
                ); 
$config['company_images_thumb_path'] = 'uploads/company_img/company_thumb_img/';

$config['user_images_thumb_path'] = 'uploads/thumb_path/';

/******************google map distance calculation **************/
$config['gMapDirectionMaxKmsUrl'] = 'https://maps.googleapis.com/maps/api/directions/';

$config['gMapDrivingDirectionUrl'] = 'https://www.google.co.in/maps/dir/';

$config['gMapDirectionMatrixUrl'] = 'https://maps.googleapis.com/maps/api/distancematrix/';
$config['gMapDirectionMatrixKey'] = 'AIzaSyAFHPcmZPIgTh_fgfthIRi1j0x4YAOVzs4';
$config['gMapMode'] = 'driving';
$config['units']    = 'metric';
$config['output']   = 'json';

/*
 * https://developers.google.com/maps/documentation/distance-matrix/intro#travel_modes
 * units=metric (default) returns distances in kilometers and meters.
 * units=imperial returns distances in miles and feet.
 * 
 */ 
/******************************************************************/

/**** default latitude logitude for map ********/
$config['default_latitude']   = '28.403846';
$config['default_longitude']   = '77.040571';
/**********************************************/

/***************** Reason of rejection *************************/
$config['reasonArr']    = array('reason1','reason2','reason3');
/***************************************************************/


/***************** Reason of leaving job *************************/
$config['leavingReasonArr']    = array('Amicable','Terminated by Employer','Personality conflict','Better Salary','Better Working Envoirment');
/***************************************************************/ 

/***************** Reason of leaving job *************************/
$config['experienceDesignationArr']    = array('Gunman','Guard','Driver','Field Officer','Clerk');
/***************************************************************/ 

/***************** Employee status *************************/
$config['employeeStatusArr']    = array('Active','Inactive','Under Review','Blacklist');
/***************************************************************/

/******************************* SMTP Setting *************************************/
/******************************************
1=SMTP
2=SEND MAIL
3=PHP MAIL
*******************************************/
$config['email_send_by']=1;
$config['protocol']='smtp';
$config['email_send_by']=1;
$config['protocol']='smtp';
$config['smtp_host']='smtp.sendgrid.net';
$config['smtp_port']='587';
$config['smtp_user']='p.chitalkar@6degreesit.com';
$config['smtp_pass']='Southwest1940';
$config['from_name']= "Bluescan Admin";
$config['from_email']= "support@bluescan.com";
/***************************************************************/

$config['web_version'] = '1.0.13';

