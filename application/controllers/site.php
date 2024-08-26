
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Site extends CI_Controller
{
    public $um;
    public $cm;
    public $cmm;
    public $qc;
    public $sm;
    public $cust;
    public $bm;
    public $ques;
    public $user;
    public $rm;
            
    function  __construct(){
        parent::__construct();
        $this->qc = $this->queryconstant;
        $this->load->model('usermanager');
        $this->load->model('commonmanager');
        $this->load->model('companymanager');
        $this->load->model('sitemanager');
        $this->load->model('customermanager');
        $this->load->model('guardmanager');
        $this->load->model('branchmanager');
        $this->load->model('questionmanager');
        $this->load->model('regionmanager');
        $this->um  = $this->usermanager;
        $this->cmm = $this->commonmanager;
        $this->qc  = $this->queryconstant;
        $this->sm  = $this->sitemanager;
        $this->cust= $this->customermanager;
        $this->gd= $this->guardmanager;
        $this->bm = $this->branchmanager;
        $this->ques = $this->questionmanager;
        $this->cm = $this->companymanager;
        $this->rm =  $this->regionmanager;
        $this->user =   unserialize($this->session->userdata('users'));
        $this->response_message = $this->config->item('service_responce_message');
        session_start();
        
    }
    
    function index(){
        redirect('site/siteList');
    }
    
    function siteList(){

        $this->um->checkLoginSession();
        
        $userId  = $this->user->user_id;
        $where = '';
        $search_comp_site_id = '';
        
        if($this->user->role_code == 'sadmin'){
            $companyId   =  $this->session->userdata('session_company_id');
            $where = 'WHERE com.company_id = '.$companyId;
        }else if(in_array($this->user->role_code, array('cadmin','cuser'))){
            $companyId  =  $this->user->company_id;
            $where = 'WHERE com.company_id = '.$companyId;
        }else if(in_array($this->user->role_code, array('RM','BM','FO'))){
            $where = 'WHERE u.user_id = '.$userId;
        }
        
        // ------------Start filter query-----------
        if($this->input->post())
        {
            //print_r($_POST);die;
            if($this->input->post('search_comp_site_id'))
            {
                $search_comp_site_id = $this->input->post('search_comp_site_id');
                if(empty($where))
                {   $where = $where." WHERE s.company_site_id LIKE '%".$search_comp_site_id."%'"; }
                else
                {   $where = $where." and s.company_site_id LIKE '%".$search_comp_site_id."%'"; }
                
            }    
        }
      // echo $where;die;
        // ------------End filter query-----------        

        
        $customerId = '';
        if($this->uri->segment(3)){
            $customerId= base64_decode($this->uri->segment(3));
        }
        
        $this->load->library('paginator');
        $cur_page = $this->input->post('page') ? $this->input->post('page') : 1; 
        $perPage  = $this->config->item('perPage');
        $vars['perPage']   = $perPage;
        $vars['page']      = $cur_page;
        $offset = ($cur_page*$perPage)-$perPage;
        $count  = $this->sm->getAllSiteList($where,$this->user->role_code,$offset,$perPage,true);
        $vars['total_record']   = $count;
        $pages  = new paginator($count, $perPage, $cur_page);
        $vars['pagination'] = $pages;
        //$vars['siteData']= $customerId?$this->sm->getAllSiteList($customerId,$offset,$perPage,false):$this->sm->getAllSitePageList($offset,$perPage,false);
        $vars['siteData'] = $this->sm->getAllSiteList($where,$this->user->role_code,$offset,$perPage,false);
        $vars['customerId'] = $customerId;   
        $vars['search_comp_site_id']    = $search_comp_site_id;
        $vars['title']      = 'Site List';
        $vars['contentView']= 'site_list';
        $vars['mainTab']    = "customer";
        $this->load->view('inner_template', $vars);
    }
    
    
    function addEditSite(){
        $this->um->checkLoginSession();
        $head = 'Add';
        $branchId   = '';
        $customerId = '';
        $latlongArr = array();
        $groupId   = '';
        $address    = '';
        $zipcode    = '';
        $state    = '';
        $country    = '';
        $latitude    = '';
        $longitude   = '';
        $city       = '';
        $contact_person = '';
        $contact_number = '';
        $email      = '';
        $is_published = 1;
        $site_name = '';
        $regionId   = '';
        $shiftStartTime1   = '';
        $shiftStartTime2   = '';
        $shiftStartTime3   = '';
        $system_id   = '';
        $shiftThresholdTime1   = '';
        $shiftThresholdTime2   = '';
        $shiftThresholdTime3   = '';
        $site_comp_id   = '';
        $customerId= base64_decode($this->uri->segment(3));
        $siteId   = base64_decode($this->uri->segment(4));

        if(isset($siteId)&&!empty($siteId))
        {
            $head = 'Edit';
            $siteData = $this->sm->getAllSiteDetailsBySiteId($siteId);
            $siteGrpData    = $this->sm->getSiteGroupBySiteId($siteId);
            if(!empty($siteGrpData)){
                 $groupId   = $siteGrpData->group_id;
            }
            $regionId     = $siteData->region_id;  
            $customerId   = $siteData->customer_id;
            $branchId     = $siteData->branch_id;
            $address    = $siteData->address;
            $latitude   = $siteData->latitude;
            $longitude  = $siteData->longitude;
            $zipcode    = $siteData->zipcode;
            $city       = $siteData->city;
            $state      = $siteData->state;
            $country    = $siteData->country;
            $contact_number = $siteData->contact_number;
            $contact_person = $siteData->contact_person;
            $email      = $siteData->email_id; 
            $is_published = $siteData->is_published;
            $site_name  =  $siteData->site_title;
            $shiftStartTime1   = $siteData->first_shift_start_time;
            $shiftStartTime2   = $siteData->second_shift_start_time;
            $shiftStartTime3   = $siteData->third_shift_start_time;
            $shiftThresholdTime1   = $siteData->first_shift_threshold_time;
            $shiftThresholdTime2   = $siteData->second_shift_threshold_time;
            $shiftThresholdTime3   = $siteData->third_shift_threshold_time;
            $system_id   = $siteData->system_id;
            $site_comp_id   = $siteData->company_site_id;
        }
        //print_r($_POST);

        if($this->input->post())
        {
            if($this->input->post('region_id')){
                $regionId = trim($this->input->post('region_id'));
            }
            if($this->input->post('branch_id')){
                $branchId    =   trim($this->input->post('branch_id'));
            }
            if($this->input->post('group_id')){
                $groupId    =   trim($this->input->post('group_id'));
            }
            if($this->input->post('address')){
                $address           =   trim($this->input->post('address'));
            }
            if($this->input->post('city')){
                $city           =   trim($this->input->post('city'));
            }            
            if($this->input->post('email')){
                $email          =   trim($this->input->post('email'));
            }
            if($this->input->post('latitude')){
                $latitude   =   trim($this->input->post('latitude'));
            }
            if($this->input->post('system_id')){
                $system_id   =   trim($this->input->post('system_id'));
            }
            if($this->input->post('longitude')){
                $longitude   =   trim($this->input->post('longitude'));
            }
            if($this->input->post('contact_person')){
                $contact_person =   trim($this->input->post('contact_person'));
            }
            if($this->input->post('contact_number')){
                $contact_number =   trim($this->input->post('contact_number'));
            }
            if($this->input->post('zipcode')){
                $zipcode    =   trim($this->input->post('zipcode'));
            }
            if($this->input->post('state')){
                $state    =   trim($this->input->post('state'));
            }
            if($this->input->post('country')){
                $country    =   trim($this->input->post('country'));
            }
            if($this->input->post('site_name')){
                $site_name  =   trim($this->input->post('site_name'));
            }
            if($this->input->post('customer_id')){
                $customerId  =   trim($this->input->post('customer_id'));
            }
            
            if($this->input->post('shift_start_time1')){
                $shiftStartTime1   = $this->input->post('shift_start_time1');
            }
            if($this->input->post('shift_start_time2')){
                $shiftStartTime2   = $this->input->post('shift_start_time2');
            }
            if($this->input->post('shift_start_time3')){
                $shiftStartTime3   = $this->input->post('shift_start_time3');
            }
            
            if($this->input->post('shift_threshold_time1')){
                $shiftThresholdTime1   = $this->input->post('shift_threshold_time1');
            }
            if($this->input->post('shift_threshold_time2')){
                $shiftThresholdTime2   = $this->input->post('shift_threshold_time2');
            }
            if($this->input->post('shift_threshold_time3')){
                $shiftThresholdTime3   = $this->input->post('shift_threshold_time3');
            }
            if($this->input->post('shift_threshold_time3')){
                $site_comp_id   = $this->input->post('site_comp_id');
            }
             
            if($this->_validation_site($siteId) == TRUE){
               
                $testAdress = trim($address.' '.$zipcode.' '.$city.' '.$state.' '.$country);
                if($testAdress != ''){
                    $latlongArr = $this->cmm->getLatLongByAddress($testAdress);
                    $latitude    = 0;
                    $longitude   = 0;
                    if(!empty($latlongArr)){
                         $latitude    = $latlongArr[0];
                         $longitude   = $latlongArr[1];
                    }
                }
              
                $dataArr    = array('branch_id' => $branchId,
                                'site_title'    => $site_name,
                                'customer_id'   => $customerId,
                                'address'       => $address,
                                'zipcode'       => $zipcode,
                                'city'          => $city,
                                'country'       => $country,
                                'state'         => $state,
                                'contact_number'=> $contact_number,
                                'contact_person'=> $contact_person,
                                'email_id'      => $email,
                                'is_published'  => $is_published,
                                'latitude'      => $latitude,
                                'system_id'      => $system_id,
                                'longitude'     => $longitude,
                                'first_shift_start_time'    => date('H:i:s',  strtotime($shiftStartTime1)),
                                'second_shift_start_time'   => date('H:i:s',  strtotime($shiftStartTime2)),
                                'third_shift_start_time'    => date('H:i:s',  strtotime($shiftStartTime3)),
                                'first_shift_threshold_time'   => date('H:i:s',  strtotime($shiftThresholdTime1)),
                                'second_shift_threshold_time'  => date('H:i:s',  strtotime($shiftThresholdTime2)),
                                'third_shift_threshold_time'   => date('H:i:s',  strtotime($shiftThresholdTime3)),
                                'company_site_id'              => $site_comp_id
                );
                
                //print_r($dataArr);die;
                
                if(isset($siteId) && !empty($siteId)){
                        log_message('info', 'Update Site data : '.print_r($dataArr,true));
                        $condition  = array('site_id'    => $siteId);
                        $this->cmm->update($dataArr,$condition,'site');
                        $this->cmm->delete($condition,'site_group');
                        $this->cmm->insert(array('group_id' => $groupId, 'site_id' => $siteId),'site_group');
                        $this->session->set_flashdata('successMessage', 'Site updated successfully.');
                        //redirect("project/addEditProject/".base64_encode($projectId));
                        redirect("site/siteList");
                }else{
                        log_message('info', 'Insert Site data : '.print_r($dataArr,true));
                        $siteId = $this->cmm->insert($dataArr,'site');
                        
                        $qrCode     = $this->config->item('qr_code_site_prifix').$siteId;
                        $fileName   = $this->cmm->getBarcode($qrCode,'SITEIMG_'.$qrCode,'./uploads/site/');
                     
                        $condition  = array('site_id'    => $siteId);
                        $this->cmm->update(array('qr_code'=>$qrCode),$condition,'site');
                        
                        $this->cmm->insert(array('group_id' => $groupId, 'site_id' => $siteId),'site_group');
                        $this->session->set_flashdata('successMessage', 'Site added successfully.');
                        redirect("site/siteList");
                }
            }
        }
        //$customerData   = $this->cust->getCustomerDetailsByCustomerId($customerId);
        $vars['customerName']     = 'BH';
        $condition  = '';
        $companyId  = '';
        if($this->user->role_code == 'sadmin'||$this->user->role_code == 'cadmin'||$this->user->role_code == 'cuser'){
             $companyId            = $this->session->userdata('session_company_id');
             $condition = 'WHERE cust.company_id = '.$companyId;
        }
        //echo $companyId;die;
        //$companyId                = $customerData->company_id;
        $vars['site_comp_id']          = $site_comp_id;
        $vars['groupId']          = $groupId;
        $vars['regionId']          = $regionId;
        //$vars['companyData']    = $this->cm->getAllCompanyList();
        $vars['customerData']   = $this->cust->getAllCustomerDropdown(0,$condition);
       // $this->rm->getAllRegionList($companyId,$this->user->user_id,$this->user->role_code);
        $vars['regionData']         = $this->rm->getAllRegionList($companyId,$this->user->user_id,$this->user->role_code);
        $vars['branchData']         = $this->bm->getAllBranchList($regionId,$companyId,$this->user->user_id,$this->user->role_code); 
        $vars['questionGroupData']  = $this->ques->getAllGroupDropdownByCompanyId($companyId);
        $vars['branchId']       = $branchId;
        $vars['customerId']     = $customerId;
        $vars['address']        = $address;
        $vars['zipcode']        = $zipcode;
        $vars['city']           = $city;
        $vars['country']        = $country;
        $vars['state']          = $state;
        $vars['latitude']       = $latitude;
        $vars['longitude']      = $longitude;
        $vars['contact_number'] = $contact_number;
        $vars['contact_person'] = $contact_person;
        $vars['system_id'] = $system_id;
        $vars['email']          = $email;
        $vars['site_name']      = $site_name;
        $vars['shift_start_time1']  = $shiftStartTime1;
        $vars['shift_start_time2']  = $shiftStartTime2;
        $vars['shift_start_time3']  = $shiftStartTime3;
        $vars['shift_threshold_time1']  = $shiftThresholdTime1;
        $vars['shift_threshold_time2']  = $shiftThresholdTime2;
        $vars['shift_threshold_time3']  = $shiftThresholdTime3;
        $vars['title']          = $head.' Site';
        $vars['pageHeading']    = $head.' Site';
        $vars['contentView']    = 'add_edit_site';
        $vars['mainTab']    = "customer";
        //print_r($vars);die;
        $this->load->view('inner_template', $vars);
    }
    
    
    function _validation_site($siteId){
        $this->form_validation->set_rules('site_name','Site Name','trim|required');
        $this->form_validation->set_rules('branch_id','Branch','trim|required');
        $this->form_validation->set_rules('region_id','Region','trim|required');
        $this->form_validation->set_rules('customer_id','Customer','trim|required');
        $this->form_validation->set_rules('group_id', 'Group','trim|required');
        $this->form_validation->set_rules('city','City','trim|required|alpha_space');
        $this->form_validation->set_rules('state','State','trim|required');
        $this->form_validation->set_rules('country','Country','trim|required');
        $this->form_validation->set_rules('address', 'Address','trim|required');
        //$this->form_validation->set_rules('latitude','Latitude','trim|required');
        //$this->form_validation->set_rules('longitude', 'Longitude','trim|required');
        
        $this->form_validation->set_rules('shift_start_time1','1st Shift Start Time','trim|required|callback_timeValidation');
        $this->form_validation->set_rules('shift_threshold_time1','1st Shift Margin Time','trim|required|callback_timeValidation');
        $this->form_validation->set_rules('shift_start_time2','2st Shift Start Time','trim|required|callback_timeValidation');
        $this->form_validation->set_rules('shift_threshold_time2','2st Shift Margin Time','trim|required|callback_timeValidation');
        $this->form_validation->set_rules('shift_start_time3','3st Shift Start Time','trim|required|callback_timeValidation');
        $this->form_validation->set_rules('shift_threshold_time3','3st Shift Margin Time','trim|required|callback_timeValidation');
        
        
        $this->form_validation->set_rules('contact_person','Contact Person','trim|required');
        $this->form_validation->set_rules('contact_number','Contact Number','trim|required|numeric');
        $this->form_validation->set_rules('email','Email','trim|required|valid_email');        
        $this->form_validation->set_rules('zipcode','ZipCode','trim');
        $this->form_validation->set_rules('site_comp_id','Site Id','trim|required|callback_siteid_check['.$siteId.']');
        $this->form_validation->set_error_delimiters('<span class="error">','</span>');
        return $this->form_validation->run();
    }
    
    function siteid_check($str,$siteId){
        if($this->sm->checkSiteidId($str,$siteId)){
            $this->form_validation->set_message('siteid_check', "The %s field must contain a unique value.");
            return FALSE;
        }else{
            return TRUE;
        }
    }
    
    function timeValidation($str){
        if($str == '00:00:00'){
            $this->form_validation->set_message('timeValidation', 'Invalid time');
            return FALSE;
        }else{
            return TRUE;
        }
    }
    /*        
    function getAllInspectionDetailsByQrCode($request){
        if(!isset($request['qr_code']) || trim($request['qr_code'])=='')
        {
                $this->response = array('responseCode'=>119,'responseData'=>$this->response_message['119']);
                $this->cmm->print_log('getAllInspectionDetailsByQrCode','Missing Response => '.json_encode($this->response));
                return $this->response;
        }
        $this->benchmark->mark('api_code_start');
        $siteData   = $this->sm->getSiteDataByQrcode($request['qr_code']);
        if(!empty($siteData)){
        }
        
        $siteData           = $this->sm->getAllInspectionDetailsByQrCode($request['qr_code']);
        
        $siteQuestionData   = $this->sm->getAllSiteQuestionBySiteId($request['site_id']);
        $this->cmm->print_log('getAllSiteDetailsBySiteIdQR','Data for Response => '.json_encode($siteData));
        $this->cmm->print_log('getAllSiteQuestionBySiteId','Data for Response => '.json_encode($siteQuestionData));
        $this->benchmark->mark('api_code_end');
        $this->cmm->print_time_log('getAllSiteDetailsBySiteIdQR','api_code_start','api_code_end');
        $this->cmm->print_time_log('getAllSiteQuestionBySiteId','api_code_start','api_code_end');
        $output = array('siteData'=>$siteData,'siteQuestionData'=>$siteQuestionData);
        $this->response = array('responseCode'=>100,'responseData'=>$this->cmm->object_to_array($output));
        $this->cmm->print_log('getAllSiteDetailsBySiteIdQR','Request Response => '.json_encode($this->response));
        return $this->response;

    } */



    //GUARD SITE FUNCTIONS START HERE
    function guardSite(){   
        $this->um->checkLoginSession();
        $siteId     = base64_decode($this->uri->segment(3));
        $customerId     = base64_decode($this->uri->segment(4));
        $this->load->library('paginator');
        $cur_page   = $this->input->post('page') ? $this->input->post('page') : 1; 
        $perPage    = $this->config->item('perPage');
        $vars['perPage']   = $perPage;
        $vars['page']      = $cur_page;
        $offset     = ($cur_page*$perPage)-$perPage;
        $count      = $this->sm->getAllGuardPageSiteList($siteId,$offset,$perPage,true);
        $vars['total_record']   = $count;
        $pages      = new paginator($count, $perPage, $cur_page);
        $vars['pagination']     = $pages;
        
        $vars['guardSiteData']  = $this->sm->getAllGuardPageSiteList($siteId,$offset,$perPage,false);
        
        $vars['siteId']         = $siteId;
        $vars['customerId']     = $customerId;
        $vars['title']          = 'Guard Site';
        $vars['contentView']    = 'guard_site_list';
        $vars['mainTab']    = "customer";
        $this->load->view('inner_template', $vars);
    }

    function addEditGuardSite(){
        $this->um->checkLoginSession();
        $head = 'Add';
        
        $companyId = isset($this->user->company_id)?$this->user->company_id:'';
        if($this->user->role_code == 'sadmin'){
            $companyId  = $this->session->userdata('session_company_id');
        }

        $guardSiteId    = '';
        $siteId         = '';
        $guardId        = '';
        $start_date     = '';
        $start_time     = '';
        $end_date       = '';
        $end_time     = '';
        $created_date   = '';
        $siteId         = base64_decode($this->uri->segment(3)); 
        $guardSiteId    = base64_decode($this->uri->segment(4));

        if(isset($guardSiteId)&&!empty($guardSiteId))
        {
            $head = 'Edit';            
            $guardData  = $this->sm->getGuardSiteDataByGuardSiteId($guardSiteId);                        
            $guardId = $guardData->employee_id;
            $datetime = new DateTime($guardData->start_date);
            $start_date = $datetime->format('Y-m-d');
            $start_time = $datetime->format('H:i:s');
            $datetime = new DateTime($guardData->end_date);
            $end_date   = $datetime->format('Y-m-d');
            $end_time   = $datetime->format('H:i:s');
        }

        if($this->input->post())
        {
            if($this->input->post('guard_name')){
                $guardId    =   trim($this->input->post('guard_name'));
            }
            if($this->input->post('start_date')){
                $start_date =   trim($this->input->post('start_date'));
            }
            if($this->input->post('start_time')){
                $start_time  =   trim($this->input->post('start_time'));
            }
            if($this->input->post('end_date')){
                $end_date  =   trim($this->input->post('end_date'));
            }
            if($this->input->post('end_time')){
                $end_time  =   trim($this->input->post('end_time'));
            }            

            
            if($this->_validation_guardSite() == TRUE){
                $dataArr    = array('site_id'   => $siteId,
                                'employee_id'      => $guardId,                                
                                'start_date'    => $start_date.' '.$start_time,                                
                                'end_date'      => $end_date.' '.$end_time,
                                'created_date'  => date('Y-m-d H:i:s')                             
                );
                if(isset($guardSiteId) && !empty($guardSiteId)){
                        log_message('info', 'Update Guard Site data : '.print_r($dataArr,true));
                        $condition  = array('employee_site_id'    => $guardSiteId);
                        $this->cmm->update($dataArr,$condition,'employee_site');
                        $this->session->set_flashdata('successMessage', 'Guard Site updated successfully.');
                        redirect("site/guardSite/".base64_encode($siteId));
                }else{
                        log_message('info', 'Insert Guard Site data : '.print_r($dataArr,true));
                        $this->cmm->insert($dataArr,'employee_site');
                        $this->session->set_flashdata('successMessage', 'Guard Site added successfully.');                        
                        redirect("site/guardSite/".base64_encode($siteId));
                }
            }
        }
        
        //$vars['guard_ids']   =   $companyId;
        $vars['guard_ids']   =   $this->gd->getAllGuardList($companyId);
        $vars['site_id']     =   $siteId;
        $vars['guard_id']    =   $guardId;
        $vars['start_date']  =   $start_date;
        $vars['start_time']  =   $start_time;
        $vars['end_date']    =   $end_date;        
        $vars['end_time']    =   $end_time;
        $vars['title']        = $head.' Guard Site';
        $vars['pageHeading']  = $head.' Guard Site';
        $vars['contentView']  = 'add_edit_guard_site';
        $this->load->view('inner_template', $vars);       

    }


    function _validation_guardSite(){
        $this->form_validation->set_rules('guard_name','Guard Name','trim|required');
        $this->form_validation->set_rules('start_date','Start Date','trim|required');
        $this->form_validation->set_rules('end_date','End Date','trim|required');                
        $this->form_validation->set_error_delimiters('<span class="error">','</span>');
        return $this->form_validation->run();
    }
   
    function getSiteOrGuardDetailsByQRCode($request,$token){
        if(!isset($request['qr_code']) || trim($request['qr_code'])==''){
            $this->response = array('responseCode'=>119,'responseData'=>$this->response_message['119']);
            $this->cmm->print_log('getSiteOrGuardDetailsByQRCode','Missing Response => '.json_encode($this->response));
            return $this->response;
        }
        
        if(!isset($request['datetime'])&& empty($request['datetime'])){
           $this->response  = array('responseCode'=>118,'responseData'=>$this->response_message['118']);
           $this->cmm->print_log('getSiteOrGuardDetailsByQRCode','Missing Response => '.json_encode($this->response));  
           return $this->response;
        }
        
        if(!isset($request['latitude'])&& empty($request['latitude'])){
            $this->response  = array('responseCode'=>122,'responseData'=>$this->response_message['122']);
            $this->cmm->print_log('getSiteOrGuardDetailsByQRCode','Missing Response => '.json_encode($this->response));  
            return $this->response;
        }
        if(!isset($request['longitude'])&& empty($request['longitude'])){
            $this->response  = array('responseCode'=>123,'responseData'=>$this->response_message['123']);
            $this->cmm->print_log('getSiteOrGuardDetailsByQRCode','Missing Response => '.json_encode($this->response));  
            return $this->response;
        }
        if(!isset($request['attendance_mode'])&& empty($request['attendance_mode'])){
            $this->response  = array('responseCode'=>130,'responseData'=>$this->response_message['130']);
            $this->cmm->print_log('getSiteOrGuardDetailsByQRCode','Missing Response => '.json_encode($this->response));  
            return $this->response;
        }
        
        $this->benchmark->mark('api_code_start');
        $attendance_mode    = $request['attendance_mode'];
        $user_info  = $this->um->getUserByUserToken($token);
        $dateTime   = date('Y-m-d H:i:s',  strtotime($request['datetime']));
        $siteData   = $this->sm->getSiteDataByQrcode($request['qr_code'],$user_info->company_id);
        //echo "<pre>";print_r($siteData);die;
        $this->cmm->print_log('getSiteDataByQrcode','Data for Response => '.json_encode($siteData));
        
        if(strtolower($attendance_mode) == strtolower('off')){
            /** START Check Day start or not of field officer , if no then make an entry in site_visiting else leave it **/ 
            $result = $this->sm->checkFOStartDay($dateTime,$user_info->user_id); 
            //echo "<pre>";print_r($result);die;
            if(count($result) == 0){
                $sdateTime   = date('Y-m-d H:i:s',  (strtotime($dateTime)-1)); //1 sec minus for start day
                $data   = array( 
                         'latitude'       => $user_info->latitude,
                         'longitude'      => $user_info->longitude,
                         'user_id'        => $user_info->user_id,
                         'visiting_time'  => $sdateTime
                  );
                $this->cmm->insert($data,'site_visiting');
                $this->cmm->print_log('insert site_visiting','START Check Day start for Insert site visiting Data for Response => '.json_encode($data));
            }
            /** END **/
            $siteVisitingId = 0;
            if(!empty($siteData)){
                $siteId = $siteData->site_id;
                $questionData   = $this->ques->getQuestionDataBySiteId($siteId);
                //echo "<pre>";print_r($questionData);die;
                $this->cmm->print_log('getQuestionDataBySiteId','Data for Response => '.json_encode($questionData));
                $guardListData  = $this->gd->getGuardDataBySiteId($siteId);
                //echo "<pre>";print_r($guardListData);die;
                $this->cmm->print_log('getGuardDataBySiteId','Data for Response => '.json_encode($guardListData));
                $output = array('siteData'=>$siteData,'questionData'=>$questionData,'guardList'=>$guardListData);
                $distanceTo = 0;
                $delta  = 0;
                //echo "<pre>";print_r($output);die;
                /** START calculate latlong for distanceTo that is distance between last latlong and current latlong  **/ 
                $getLatLongData = $this->gd->getUserLatLongData($user_info->user_id,$dateTime);
                $lat    = 0;
                $long   = 0;
                if(count($getLatLongData)>0){
                    $lat    = $getLatLongData[0];
                    $long   = $getLatLongData[1];  
                }
                $distanceTo = $this->cmm->maxDistanceBetTwoLatLongTestNewVersion($lat,$long,$request['latitude'],$request['longitude']);
                /** END **/ 
                /** START calculate latlong for distanceTo that is distance between last latlong and current latlong  **/ 
                $siteDetails    = $this->sm->getAllSiteDetailsBySiteId($siteId);
                $siteLat = 0;
                if($siteDetails->latitude){
                    $siteLat = $siteDetails->latitude;
                }
                $sitelong = 0;
                if($siteDetails->longitude){
                    $sitelong = $siteDetails->longitude;
                }
                $delta      = $this->cmm->distanceBetTwoLatLongUsingFormula($siteLat,$sitelong,$request['latitude'],$request['longitude'],'M');
                /** END **/ 
                
                $data   = array( 
                    'site_id'        => $siteId,
                    'latitude'       => $request['latitude'],
                    'longitude'      => $request['longitude'],
                    'user_id'        => $user_info->user_id,
                    'visiting_time'  => $dateTime,
                    'delta'          => $delta,
                    'distance_to'    => $distanceTo
                );
            }else{
                $guardData   = $this->gd->getGuardDataByQrcode($request['qr_code'],false,$user_info->company_id);
                $questionData   = array();
                if(!empty($guardData)){
                    $guardId = $guardData->employee_id;
                    //get guard question data
                    //$questionData   = $this->ques->getQuestionDataByGuardId($guardId);
                    $questionData   = $this->ques->getGuardQuestionData();
                    $this->cmm->print_log('getQuestionDataBySiteId','Data for Response => '.json_encode($questionData));
                    $output = array('guardData'=>$guardData,'questionData'=>$questionData);
                    $data   = array( 
                        'employee_id'    => $guardId,
                        'latitude'       => $request['latitude'],
                        'longitude'      => $request['longitude'],
                        'user_id'        => $user_info->user_id,
                        'visiting_time'  => $dateTime
                    );
                }else{
                    $this->response  = array('responseCode'=>131,'responseData'=>$this->response_message['131']);
                    $this->cmm->print_log('getSiteOrGuardDetailsByQRCode','Invalid QR Code Request Response => '.json_encode($this->response));  
                    return $this->response;
                }
            }
            $siteVisitingId = $this->cmm->insert($data,'site_visiting');
            $output['site_visiting_id'] = $siteVisitingId;
            $this->cmm->print_log('insert site_visiting','Insert site_visiting Data for Response => '.json_encode($data));
        }else{
            $guardData   = $this->gd->getGuardDataByQrcode($request['qr_code'],false,$user_info->company_id);
            $questionData   = array();
            if(!empty($guardData)){
                $guardId = $guardData->employee_id;
                $questionData   = $this->ques->getGuardQuestionData();
                $this->cmm->print_log('getQuestionDataBySiteId','Data for Response => '.json_encode($questionData));
                $output = array('guardData'=>$guardData,'questionData'=>$questionData);
            }else{
                $this->response  = array('responseCode'=>131,'responseData'=>$this->response_message['131']);
                $this->cmm->print_log('getSiteOrGuardDetailsByQRCode','Invalid QR Code Request Response => '.json_encode($this->response));  
                return $this->response;
            }
        }
        $this->benchmark->mark('api_code_start');
        $this->response = array('responseCode'=>100,'responseData'=>$this->cmm->object_to_array($output));
        $this->cmm->print_log('getSiteOrGuardDetailsByQRCode','Request Response => '.json_encode($this->response));
        $this->cmm->print_time_log('getSiteOrGuardDetailsByQRCode','api_code_start','api_code_end');
        return $this->response;
    }
    
    function getSiteDataByQRCode($request,$token){
        if(!isset($request['qr_code']) || trim($request['qr_code'])==''){
            $this->response = array('responseCode'=>119,'responseData'=>$this->response_message['119']);
            $this->cmm->print_log('getSiteDataByQRCode','Missing Response => '.json_encode($this->response));
            return $this->response;
        }
        $user_info  = $this->um->getUserByUserToken($token);
        $this->benchmark->mark('api_code_start');
        $siteData   = $this->sm->getSiteDataByQrcode($request['qr_code'],$user_info->company_id);
        if(empty($siteData)){
            $this->response = array('responseCode'=>131,'responseData'=>$this->response_message['131']);
            $this->cmm->print_log('getSiteDataByQRCode','Missing Response => '.json_encode($this->response));
            return $this->response;
        }
        $this->cmm->print_log('getSiteDataByQRCode','Data for Response => '.json_encode($siteData));
        $output = array('siteData'=>$siteData);
        $this->benchmark->mark('api_code_start');
        $this->response = array('responseCode'=>100,'responseData'=>$this->cmm->object_to_array($output));
        $this->cmm->print_log('getSiteDataByQRCode','Request Response => '.json_encode($this->response));
        $this->cmm->print_time_log('getSiteDataByQRCode','api_code_start','api_code_end');
        return $this->response;
    }
    
    function getSiteListByUserId($request,$token){
        if(!isset($request['user_id']) || trim($request['user_id'])==''){
            $this->response = array('responseCode'=>116,'responseData'=>$this->response_message['116']);
            $this->cmm->print_log('getSiteDataBySiteId','Missing Response => '.json_encode($this->response));
            return $this->response;
        }
        $this->benchmark->mark('api_code_start');
        $siteData   = $this->sm->getSiteListByUserId($request['user_id']);
        $this->cmm->print_log('getSiteListByUserId','Data for Response => '.json_encode($siteData));
        $output = array('siteListData'=>$siteData);
        $this->benchmark->mark('api_code_start');
        $this->response = array('responseCode'=>100,'responseData'=>$this->cmm->object_to_array($output));
        $this->cmm->print_log('getSiteListByUserId','Request Response => '.json_encode($this->response));
        $this->cmm->print_time_log('getSiteListByUserId','api_code_start','api_code_end');
        return $this->response;
    }
    
    function getSiteDetails(){
        $siteId = base64_decode($this->uri->segment(3));
        $vars['siteDetails']  = $this->sm->getAllSiteDetailsBySiteId($siteId);
        //print_r($vars['siteDetails']);die;
       // print_r($vars['siteDetails']);die;
        $this->load->view('site_details_qr_code', $vars);       
    }
    
    function saveSiteInspection($request,$token){
            /** START required validation **/
            if(!isset($request['site_id'])&& empty($request['site_id'])){
                $this->response  = array('responseCode'=>117,'responseData'=>$this->response_message['117']);
                $this->cmm->print_log('saveSiteInspection','Missing Response => '.json_encode($this->response));  
                return $this->response;
            }
            if(!isset($request['lat'])&& empty($request['lat'])){
                $this->response  = array('responseCode'=>122,'responseData'=>$this->response_message['122']);
                $this->cmm->print_log('saveSiteInspection','Missing Response => '.json_encode($this->response));  
                return $this->response;
            }
            if(!isset($request['long'])&& empty($request['long'])){
                $this->response  = array('responseCode'=>123,'responseData'=>$this->response_message['123']);
                $this->cmm->print_log('saveSiteInspection','Missing Response => '.json_encode($this->response));  
                return $this->response;
            }
            
          
            if(!isset($request['questionAnsArr'])||empty($request['questionAnsArr'])){
                $this->response  = array('responseCode'=>124,'responseData'=>$this->response_message['124']);
                $this->cmm->print_log('saveSiteInspection','Missing Response => '.json_encode($this->response));  
                return $this->response;
            }else{
                $requestQuestData   = json_decode($request['questionAnsArr']);
                //print_r($requestQuestData);die;
                $questionData = $this->ques->getQuestionDataBySiteId($request['site_id']);
                $quesArr    = array();
                $requiredQuesArr    = array();
                if(!empty($questionData)){
                    for($j=0;$j<count($questionData);$j++){
                        $quesArr[]  = $questionData[$j]->question_id;
                        if($questionData[$j]->is_mandatory == 1){
                            $requiredQuesArr[] = $questionData[$j]->question_id;
                        }
                    }
                }
              
                $questionExist      = 0;
                $requestQuesArray   = array();
                for($i=0;$i<count($requestQuestData);$i++){
                    $tempArray  = $requestQuestData[$i];
                    $requestQuesArray[] = $tempArray->questionId;
                    $requestAnsArray[$tempArray->questionId] = $tempArray->answer;
                    if(!in_array(intval($tempArray->questionId),$quesArr)){
                        $questionExist++;
                    }
                }
                if($questionExist>0){
                    $this->response  = array('responseCode'=>125,'responseData'=>$this->response_message['125']);
                    $this->cmm->print_log('saveSiteInspection','Question are not for this site => '.json_encode($this->response));  
                    return $this->response;
                }
                
                $requiredCnt      = 0;
                if(count($requestQuesArray)>count($requiredQuesArr)){
                    for($i=0;$i<count($requiredQuesArr);$i++){
                        if(!in_array(intval($requiredQuesArr[$i]),$requestQuesArray)){
                            $requiredCnt++;
                        }
                    }
                }else{
                    for($i=0;$i<count($requestQuesArray);$i++){
                        if(!in_array(intval($requestQuesArray[$i]),$requiredQuesArr)){
                            $requiredCnt++;
                        }
                    }
                }
                
                if($requiredCnt>0){
                    $this->response  = array('responseCode'=>126,'responseData'=>$this->response_message['126']);
                    $this->cmm->print_log('saveSiteInspection','Required Question => '.json_encode($this->response));  
                    return $this->response;
                }
            }
            /** END **/ 
            
            $comment = '';
            if(isset($request['comment']) && !empty($request['comment'])){
                $comment = $request['comment'];
            }
            
            $this->benchmark->mark('api_code_start');
            
            $user_info  = $this->um->getUserByUserToken($token);
            $dateTime   = date('Y-m-d H:i:s');
            
            /** START Check Day start or not of field officer , if no then make an entry in site_visiting else leave it **/ 
            $result = $this->sm->checkFOStartDay($dateTime,$user_info->user_id); 
            if(count($result) == 0){
                $sdateTime   = date('Y-m-d H:i:s',  (strtotime($dateTime)-1)); //1 sec minus for start day
                $data   = array( 
                         'latitude'       => $user_info->latitude,
                         'longitude'      => $user_info->longitude,
                         'user_id'        => $user_info->user_id,
                         'visiting_time'  => $sdateTime
                  );
                $this->cmm->insert($data,'site_visiting');
                $this->cmm->print_log('insert site_visiting','Insert site visiting Data for Response => '.json_encode($data));
            }
            /** END **/ 
            
            
            /** START calculate latlong for distanceTo that is distance between last latlong and current latlong  **/ 
            $getLatLongData = $this->gd->getUserLatLongData($user_info->user_id,$dateTime);
            $lat    = 0;
            $long   = 0;
            if(count($getLatLongData)>0){
                $lat    = $getLatLongData[0];
                $long   = $getLatLongData[1];  
            }
            $distanceTo = $this->cmm->maxDistanceBetTwoLatLongTestNewVersion($lat,$long,$request['lat'],$request['long']);
            /** END **/ 


            /** START calculate latlong for distanceTo that is distance between last latlong and current latlong  **/ 
            $siteDetails    = $this->sm->getAllSiteDetailsBySiteId($request['site_id']);
            $siteLat = 0;
            if($siteDetails->latitude){
                $siteLat = $siteDetails->latitude;
            }
            $sitelong = 0;
            if($siteDetails->longitude){
                $sitelong = $siteDetails->longitude;
            }
            $delta      = $this->cmm->distanceBetTwoLatLongUsingFormula($siteLat,$sitelong,$request['lat'],$request['long'],'M');
            /** END **/ 

            /** START An entry for site visiting **/
            $data   = array( 
                       'site_id'        => $request['site_id'],
                       'latitude'       => $request['lat'],
                       'longitude'      => $request['long'],
                       'user_id'        => $user_info->user_id,
                       'visiting_time'  => $dateTime,
                       'delta'          => $delta,
                       'distance_to'    => $distanceTo,
                       'comment'       => $comment
                );
            $siteVisitingId = $this->cmm->insert($data,'site_visiting');
            $this->cmm->print_log('insert site_visiting','Insert site_visiting Data for Response => '.json_encode($data));
            /** END **/ 
            
            /** START entry for during site inspection save the Question ans details**/
            if($siteVisitingId){
                for($j=0;$j<count($questionData);$j++){
                    if(in_array($questionData[$j]->question_id,$requestQuesArray)){
                       $answer  = $requestAnsArray[$questionData[$j]->question_id];
                       if($questionData[$j]->question_type == 'image'){
                           $answer = $this->cmm->saveAsImageBase64($requestAnsArray[$questionData[$j]->question_id]);
                       }
                       $quesAnsData    = array('question_id'        => $questionData[$j]->question_id,
                                                'question_text'     => $questionData[$j]->question,
                                                'answer'            =>  $answer,
                                                'inserted_date'     => $dateTime,
                                                'site_visiting_id' => $siteVisitingId);
                       $this->cmm->insert($quesAnsData,'site_question_answer');
                       $this->cmm->print_log('saveSiteInspection','Insert site inspection Data  => '.json_encode($quesAnsData));
                    }
                }
            }
            /** END **/ 
            
            $this->benchmark->mark('api_code_end');
            $this->response = array('responseCode'=>100,'responseData'=>true);
            $this->cmm->print_log('saveSiteInspection','Service responce => '.json_encode($this->response));
            $this->cmm->print_time_log('saveSiteInspection','api_code_start','api_code_end');
            return $this->response;
    }
    
    
    function saveSiteGuardInspection($request,$token){

        /** START required validation **/
        if(!isset($request['type'])&& empty($request['type'])){
           $this->response  = array('responseCode'=>129,'responseData'=>$this->response_message['129']);
           $this->cmm->print_log('saveSiteGuardInspection','Missing Response => '.json_encode($this->response));  
           return $this->response;
        }
        
        
        if(!isset($request['datetime'])&& empty($request['datetime'])){
           $this->response  = array('responseCode'=>118,'responseData'=>$this->response_message['118']);
           $this->cmm->print_log('saveSiteGuardInspection','Missing Response => '.json_encode($this->response));  
           return $this->response;
        }
        
        if(!isset($request['id'])&& empty($request['id'])){
            if($request['type'] == 'site'){
                $this->response  = array('responseCode'=>117,'responseData'=>$this->response_message['117']);
            }else{
                $this->response  = array('responseCode'=>120,'responseData'=>$this->response_message['120']);
            }
            $this->cmm->print_log('saveSiteGuardInspection','Missing Response => '.json_encode($this->response));  
            return $this->response;
        }
        
       /* if(!isset($request['site_visiting_id'])&& empty($request['site_visiting_id'])){
            $this->response  = array('responseCode'=>133,'responseData'=>$this->response_message['133']);
            $this->cmm->print_log('saveSiteGuardInspection','Missing Response => '.json_encode($this->response));  
            return $this->response;
        }*/

        if(!isset($request['lat'])&& empty($request['lat'])){
            $this->response  = array('responseCode'=>122,'responseData'=>$this->response_message['122']);
            $this->cmm->print_log('saveSiteGuardInspection','Missing Response => '.json_encode($this->response));  
            return $this->response;
        }

        if(!isset($request['long'])&& empty($request['long'])){
            $this->response  = array('responseCode'=>123,'responseData'=>$this->response_message['123']);
            $this->cmm->print_log('saveSiteGuardInspection','Missing Response => '.json_encode($this->response));  
            return $this->response;
        }

        
        if(!isset($request['questionAnsArr'])||empty($request['questionAnsArr'])){
            $this->response  = array('responseCode'=>124,'responseData'=>$this->response_message['124']);
            $this->cmm->print_log('saveSiteGuardInspection','Missing Response => '.json_encode($this->response));  
            return $this->response;
        }else{
            $requestQuestData   = json_decode($request['questionAnsArr']);
             $this->cmm->print_log('questionAnsArr json decode','Question ans => '.  print_r($requestQuestData,true));
            $type = $request['type'];
            if($type == 'site'){
                $questionData = $this->ques->getQuestionDataBySiteId($request['id']);
                $this->cmm->print_log('getQuestionDataBySiteId','site question data $questionData => '.  print_r($questionData,true));

            }else{
                $questionData = $this->ques->getGuardQuestionData();
                $this->cmm->print_log('getGuardQuestionData','guard question data => '. print_r($questionData,true));

            }
           // print_r($requestQuestData);
            $quesArr    = array();
            $requiredQuesArr    = array();
            if(!empty($questionData)){
                for($j=0;$j<count($questionData);$j++){
                    $quesArr[]  = $questionData[$j]->question_id;
                    if($questionData[$j]->is_mandatory == 1){
                        $requiredQuesArr[] = $questionData[$j]->question_id;
                    }
                }
            }
            $this->cmm->print_log('$requiredQuesArr','madetory questions => '. print_r($requiredQuesArr,true));
             $this->cmm->print_log('$requestQuestData','$requestQuestData questions => '. print_r($requestQuestData,true));
            //print_r($requiredQuesArr);die;
            $questionExist      = 0;
            $requestQuesArray  = array();
            $requestAnsByQues   = array();
            for($i=0;$i<count($requestQuestData);$i++){
                $tempArray  = $requestQuestData[$i];
                $requestQuesArray[] = $tempArray->questionId;
                $requestAnsArray[$i][$tempArray->questionId] = $tempArray->answer;
                $requestAnsByQues[$tempArray->questionId] = $tempArray->answer;
                $this->cmm->print_log('$tempArray->questionId','request question => '.$tempArray->questionId);
                $this->cmm->print_log('$tempArray->answer','request answer => '.$tempArray->answer);
                $this->cmm->print_log('$questionExist','check question madetory or not => '.in_array($tempArray->questionId,$requiredQuesArr));
                if(!in_array(intval($tempArray->questionId),$quesArr)){
                    $questionExist++;
                }
            }
            $this->cmm->print_log('$questionExist','exist question array => '.$questionExist);
            if($questionExist>0){
                $this->response  = array('responseCode'=>127,'responseData'=>$this->response_message['127']);
                $this->cmm->print_log('saveSiteGuardInspection','Question are not for this '.$type.' => '.json_encode($this->response));  
                return $this->response;
            }

            $requiredCnt      = 0;
            if(count($requestQuesArray)>count($requiredQuesArr)){
                for($i=0;$i<count($requiredQuesArr);$i++){
                    $q = intval($requiredQuesArr[$i]);
                    $this->cmm->print_log('$q','if '.$type.' => '.$q);  
                    if(!in_array(intval($requiredQuesArr[$i]),$requestQuesArray)){
                        $requiredCnt++;
                    }else if(empty($requestAnsByQues[$q])){
                         $requiredCnt++;
                    }
                    
                }
             }else{
                for($i=0;$i<count($requestQuesArray);$i++){
                    $q = intval($requestQuesArray[$i]);
                    $this->cmm->print_log('$q','else '.$type.' => '.$q);  
                    if(!in_array(intval($requestQuesArray[$i]),$requiredQuesArr)){
                        $requiredCnt++;
                    }else if(empty($requestAnsByQues[$q])){
                        $requiredCnt++;
                    }
                }
             }
            if($requiredCnt>0){
                $this->response  = array('responseCode'=>126,'responseData'=>$this->response_message['126']);
                $this->cmm->print_log('saveSiteGuardInspection','Required Question => '.json_encode($this->response));  
                return $this->response;
            }
        }
        /** END **/ 
        
        $this->benchmark->mark('api_code_start');
        $user_info = $this->um->getUserByUserToken($token);
        $dateTime   = date('Y-m-d H:i:s',strtotime($request['datetime']));
        if($request['site_visiting_id']==""||$request['site_visiting_id']=="null"||empty($request['site_visiting_id'])||$request['site_visiting_id']==NULL){
            /** START Check Day start or not of field officer , if no then make an entry in site_visiting else leave it **/ 
            $result = $this->sm->checkFOStartDay($dateTime,$user_info->user_id); 
            if(count($result) == 0){
                $sdateTime   = date('Y-m-d H:i:s',  (strtotime($dateTime)-1)); //1 sec minus for start day
                $data   = array( 
                         'latitude'       => $user_info->latitude,
                         'longitude'      => $user_info->longitude,
                         'user_id'        => $user_info->user_id,
                         'visiting_time'  => $sdateTime
                  );
                $this->cmm->insert($data,'site_visiting');
                $this->cmm->print_log('insert site_visiting','START Check Day start for Insert site visiting Data for Response => '.json_encode($data));
            }
            /** END **/
            
            if($request['type'] == 'site'){
                $siteId = $request['id'];
                $distanceTo = 0;
                $delta  = 0;
                
                /** START calculate latlong for distanceTo that is distance between last latlong and current latlong  **/ 
                $getLatLongData = $this->gd->getUserLatLongData($user_info->user_id,$dateTime);
                $lat    = 0;
                $long   = 0;
                if(count($getLatLongData)>0){
                    $lat    = $getLatLongData[0];
                    $long   = $getLatLongData[1];  
                }
                $distanceTo = $this->cmm->maxDistanceBetTwoLatLongTestNewVersion($lat,$long,$request['lat'],$request['long']);
                /** END **/ 

                /** START calculate latlong for distanceTo that is distance between last latlong and current latlong  **/ 
                $siteDetails    = $this->sm->getAllSiteDetailsBySiteId($siteId);
                $siteLat = 0;
                if($siteDetails->latitude){
                    $siteLat = $siteDetails->latitude;
                }
                $sitelong = 0;
                if($siteDetails->longitude){
                    $sitelong = $siteDetails->longitude;
                }
                $delta      = $this->cmm->distanceBetTwoLatLongUsingFormula($siteLat,$sitelong,$request['lat'],$request['long'],'M');
                /** END **/ 
                
                $data   = array( 
                    'site_id'        => $siteId,
                    'latitude'       => $request['lat'],
                    'longitude'      => $request['long'],
                    'user_id'        => $user_info->user_id,
                    'visiting_time'  => $dateTime,
                    'delta'          => $delta,
                    'distance_to'    => $distanceTo
                );
            }else{
                $guardId = $request['id'];
                $data   = array( 
                    'employee_id'    => $guardId,
                    'latitude'       => $request['lat'],
                    'longitude'      => $request['long'],
                    'user_id'        => $user_info->user_id,
                    'visiting_time'  => $dateTime
                );
            }
            $siteVisitingId = $this->cmm->insert($data,'site_visiting');
            $this->cmm->print_log('insert site_visiting','Insert site_visiting Data for Response => '.json_encode($data));
            
        }else{
            $siteVisitingId = $request['site_visiting_id'];
        }       
        
            
        $comment = '';
        if(isset($request['comment']) && !empty($request['comment'])){
            $comment = $request['comment'];
        }
                        
            
        /** START entry for during inspection save the Question ans details**/
        if($siteVisitingId)
        {
           // echo $siteVisitingId;die;
           // print_r($requestQuesArray);
           // print_r($quesArr);die;


        /***************** Multiple image with QuesAns Data (New Function)*********************/

            for($j=0;$j<count($requestQuesArray);$j++){
                $key = array_search($requestQuesArray[$j],$quesArr);
                if(in_array($requestQuesArray[$j],$quesArr)){
                   $answer  = $requestAnsArray[$j][$questionData[$key]->question_id];
                    if(trim($answer)!='')
                    {
                        if($questionData[$key]->question_type == 'image')
                        {
                            for($i=0;$i<count($questionData[$key]->question_type == 'image');$i++){
                              $imageUrl = $this->cmm->saveAsImageBase64($requestAnsArray[$j][$questionData[$key]->question_id]);
                                if($imageUrl){

                                 $fileData    = array('question_id' => $questionData[$key]->question_id,
                                                         'question_text' => $questionData[$key]->question,
                                                         'answer'        =>  $imageUrl,
                                                         'inserted_date' => $dateTime,
                                                         'site_visiting_id' => $siteVisitingId);
                                
                                $this->cmm->insert($fileData,'site_question_answer');
                                $this->cmm->print_log('saveSiteGuardInspection','Insert guard question_answer Data  => '.json_encode($fileData));
                                }                        
                            }                            
                        }                        
                        elseif($questionData[$key]->question_type != 'image')
                        {
                                $quesAnsData    = array('question_id' => $questionData[$key]->question_id,
                                                         'question_text' => $questionData[$key]->question,
                                                         'answer'        =>  $answer,
                                                         'inserted_date' => $dateTime,
                                                         'site_visiting_id' => $siteVisitingId);
                                // print_r($quesAnsData);die;
                                $this->cmm->insert($quesAnsData,'site_question_answer');
                                $this->cmm->print_log('saveSiteGuardInspection','Insert guard question_answer Data  => '.json_encode($quesAnsData));
                        }

                    }
                    
                }
            }

        /***************** Multiple image with QuesAns Data (OLD Function)*********************/

           /* for($j=0;$j<count($requestQuesArray);$j++){
                $key = array_search($requestQuesArray[$j],$quesArr);
                if(in_array($requestQuesArray[$j],$quesArr)){
                   $answer  = $requestAnsArray[$j][$questionData[$key]->question_id];
                   if(trim($answer)!=''){
                        if($questionData[$key]->question_type == 'image'){
                            $answer = $this->cmm->saveAsImageBase64($requestAnsArray[$j][$questionData[$key]->question_id]);
                        } 
                        $quesAnsData    = array('question_id' => $questionData[$key]->question_id,
                                                 'question_text' => $questionData[$key]->question,
                                                 'answer'        =>  $answer,
                                                 'inserted_date' => $dateTime,
                                                 'site_visiting_id' => $siteVisitingId);
                        // print_r($quesAnsData);die;
                        $this->cmm->insert($quesAnsData,'site_question_answer');
                        $this->cmm->print_log('saveSiteGuardInspection','Insert guard question_answer Data  => '.json_encode($quesAnsData));
                    }
                    
                }
            }  
           */

            if(isset($request['imagesDataArr'])||!empty($request['imagesDataArr'])){
                $imagesDataArr  = json_decode($request['imagesDataArr']);
                for($i=0;$i<count($imagesDataArr);$i++){
                    $imageUrl   = $this->cmm->saveAsImageBase64($imagesDataArr[$i]);
                    if($imageUrl){
                    $fileDataNew    = array('site_visiting_id' => $siteVisitingId,'file_path' => $imageUrl);
                        $this->cmm->insert($fileDataNew,'inspection_images');
                        $this->cmm->print_log('saveSiteGuardInspection','Insert guard images Data  => '.json_encode($fileDataNew));
                    }                        
                }
            }
        }


        /** END **/ 

        /*sending mail to admin */

        $user_info = $this->um->getUserByUserToken($token);
        if(isset($request['id']) && !empty($request['id']))
        {
         $siteId = $request['id'];
         $site_name_detail_for_Admin=$this->sm->getsiteName($siteId);
         $site_name_detail_for_cust=$this->sm->getsiteNameForCustomer($siteId);
        }
        // print_r($site_name);die;
        
         $company_id=$user_info->company_id;
         $admin_emails=$this->sm->getCompanyAdminEmailIdsByFo($company_id);

              /* get question-answer based on last site-visited-id */
        
         $quesAnsArray =$this->sm->getQuestionAnsForClientEmail($siteVisitingId);         

         $htmltemplate = '<table style="font-family: arial, sans-serif; border-collapse: collapse; width: 100%;">
                  <thead>
                      <tr>
                          <th style="border: 1px solid #dddddd; text-align: left; padding: 8px;">Question</th>
                          <th style="border: 1px solid #dddddd; text-align: left; padding: 8px;">Answer</th>                          

                      </tr>
                  </thead>   
                  <tbody>';                 
           

            foreach($quesAnsArray as $key => $row)
            {

                 $htmltemplate.= '<tr>';                       
                        
                    if (!empty($row->answer)) 
                    {
                        if ($row->question_text!='Take Photo') {
                            $answerbycus = $row->answer;
                        }
                    }
                    else
                    {

                            $answerbycus = "--";
                    }

                 $htmltemplate.= '<td style="border: 1px solid #dddddd; text-align: left; padding: 8px;">'.$row->question_text.'</td>';

                    if ($row->question_text=='Take Photo') 
                    {
                        $answerbycus= base_url().$this->config->item("image_path").$row->answer;

                 $htmltemplate.= '<td style="border: 1px solid #dddddd; text-align: left; padding: 30px;"><img style="display:block;" width="100%" height="100%" src='.$answerbycus.'></td>'; 

                    }else{

                 $htmltemplate.= '<td style="border: 1px solid #dddddd; text-align: left; padding: 8px;">'.$answerbycus.'</td>'; 
                      }                    
                                   
                 $htmltemplate .= '</tr>';
            } 

            $htmltemplate.='</tbody></table>';

         
         /*********************** email send to admins***************************/

         if(!empty($site_name_detail_for_Admin))
         {
             $subject='Inspection successfully' ; 
             $content = $this->config->item('email_content_for_admin_FO_inspection');
             $content=str_replace(array('##firstname##','##lastname##','##sitename##','##address##'),array($user_info->first_name,$user_info->last_name,$site_name_detail_for_Admin->site_title,$site_name_detail_for_Admin->address),$content);
             $to_email       = $admin_emails;
             $sentFlag       = $this->cmm->sendMail($to_email,$subject,$content);
         }         

             /******************* email send to cusotomer *********************/

         // if(isset($sentFlag) && $sentFlag==1 && $site_name->customer_email !='')
         // {
         //    $content = $this->config->item('email_content_for_customer_FO_inspection');
         //    $content=str_replace(array('##customername##','##firstname##','##lastname##','##sitename##','##address##'),array($site_name->first_name,$user_info->first_name,$user_info->last_name,$site_name->site_title,$site_name->address),$content);
         //    $to_email       = $site_name->customer_email;
         //    $sentFlag       = $this->cmm->sendMail($to_email,$subject,$content);
         // }

         if(isset($sentFlag) && $sentFlag==1 && $site_name_detail_for_cust->customer_email !='')
         {
            $content = $this->config->item('email_content_for_customer_FO_inspection');
            $content=str_replace(array('##customername##','##firstname##','##lastname##','##sitename##','##address##','##questionsanswer##'),array($site_name_detail_for_cust->first_name,$user_info->first_name,$user_info->last_name,$site_name_detail_for_cust->site_title,$site_name_detail_for_cust->address,$htmltemplate),$content);     
                $to_email       = $site_name_detail_for_cust->customer_email;
                $sentFlag       = $this->cmm->sendMail($to_email,$subject,$content);        
         }        
         

        /* end */
        $this->benchmark->mark('api_code_end');
        $this->response = array('responseCode'=>100,'responseData'=>true);
        $this->cmm->print_log('saveSiteGuardInspection','Service responce => '.json_encode($this->response));
        $this->cmm->print_time_log('saveSiteGuardInspection','api_code_start','api_code_end');
        return $this->response;
    }
    
    
    function saveCustomInspection($request,$token){
            /** START required validation **/
            if(!isset($request['datetime'])&& empty($request['datetime'])){
               $this->response  = array('responseCode'=>118,'responseData'=>$this->response_message['118']);
               $this->cmm->print_log('saveSiteInspection','Missing Response => '.json_encode($this->response));  
               return $this->response;
            }
            if(!isset($request['lat'])&& empty($request['lat'])){
                $this->response  = array('responseCode'=>122,'responseData'=>$this->response_message['122']);
                $this->cmm->print_log('saveSiteInspection','Missing Response => '.json_encode($this->response));  
                return $this->response;
            }
            if(!isset($request['long'])&& empty($request['long'])){
                $this->response  = array('responseCode'=>123,'responseData'=>$this->response_message['123']);
                $this->cmm->print_log('saveSiteInspection','Missing Response => '.json_encode($this->response));  
                return $this->response;
            }
            if(!isset($request['description'])&& empty($request['description'])){
                $this->response  = array('responseCode'=>128,'responseData'=>$this->response_message['128']);
                $this->cmm->print_log('saveSiteInspection','Missing Response => '.json_encode($this->response));  
                return $this->response;
            }
            
            $this->benchmark->mark('api_code_start');
            
            $user_info  = $this->um->getUserByUserToken($token);
            $dateTime   = date('Y-m-d H:i:s' ,strtotime($request['datetime']));
            //print_r($user_info);
            /** START Check Day start or not of field officer , if no then make an entry in site_visiting else leave it **/ 
            $result = $this->sm->checkFOStartDay($dateTime,$user_info->user_id); 
            //print_r($result);
            if(count($result) == 0){
                $sdateTime   = date('Y-m-d H:i:s',  (strtotime($dateTime)-1)); //1 sec minus for start day
                $data   = array( 
                         'latitude'       => $user_info->latitude,
                         'longitude'      => $user_info->longitude,
                         'user_id'        => $user_info->user_id,
                         'visiting_time'  => $sdateTime
                  );
                // print_r($data);die;
                $this->cmm->insert($data,'site_visiting');
                $this->cmm->print_log('insert site_visiting','Insert site visiting Data for Response => '.json_encode($data));
            }
            /** END **/ 
            
            
            /** START calculate latlong for distanceTo that is distance between last latlong and current latlong  **/ 
            $getLatLongData = $this->gd->getUserLatLongData($user_info->user_id,$dateTime);
            $lat    = 0;
            $long   = 0;
            if(count($getLatLongData)>0){
                $lat    = $getLatLongData[0];
                $long   = $getLatLongData[1];  
            }
            $distanceTo = $this->cmm->maxDistanceBetTwoLatLongTestNewVersion($lat,$long,$request['lat'],$request['long']);
            /** END **/ 

            /** START An entry for site visiting **/
             $data   = array( 
                    'latitude'       => $request['lat'],
                    'longitude'      => $request['long'],
                    'user_id'        => $user_info->user_id,
                    'visiting_time'  => $dateTime,
                    'description'    => $request['description'],
                    'custom'         => 1,
                    'distance_to'    => $distanceTo
             );
            $siteVisitingId = $this->cmm->insert($data,'site_visiting');
            $this->cmm->print_log('insert site_visiting','Insert site_visiting Data for Response => '.json_encode($data));
            /** END **/ 
            
            $this->benchmark->mark('api_code_end');
            
            $this->response = array('responseCode'=>100,'responseData'=>true);
            $this->cmm->print_log('saveCustomInspection','Service responce => '.json_encode($this->response));
            $this->cmm->print_time_log('saveCustomInspection','api_code_start','api_code_end');
            return $this->response;
    }
    
    function approveVisit()
    {
        $response = array('message'=>'Request Failed','status'=>'0');
        if(isset($_REQUEST['site_visit_id']) && !empty($_REQUEST['site_visit_id']))
        {
            $userInfo = $this->um->getUserSession();
            if($userInfo)
            {
                    $dataArr =array('verified_by'=>$userInfo->user_id);
                    $condition = array("site_visiting_id"=>trim($_REQUEST['site_visit_id']));
                    $this->cmm->update($dataArr,$condition,'site_visiting');
                    $response = array('message'=>'','status'=>'1');
            }
        }
        echo json_encode($response);
    }
    
    function disapproveVisit(){
        $response = array('message'=>'Request Failed','status'=>'0');
        if(isset($_REQUEST['site_visit_id']) && !empty($_REQUEST['site_visit_id']))
        {
            $reason = $_REQUEST['reason'];
            $dateTime   = $_REQUEST['date'];
            $userInfo = $this->um->getUserSession();
            if($userInfo)
            {
                    $dataArr =array('rejected_by'=>$userInfo->user_id,'rejected_reason'=>$reason);
                    $condition = array("site_visiting_id"=>trim($_REQUEST['site_visit_id']));
                    $this->cmm->update($dataArr,$condition,'site_visiting');
                    $getLatLongDataMin  = $this->gd->getUserLatLongDataBySiteVisitingIdMin($userInfo->user_id,$dateTime,$_REQUEST['site_visit_id']);
                    $getLatLongDataMax  = $this->gd->getUserLatLongDataBySiteVisitingIdMax($userInfo->user_id,$dateTime,$_REQUEST['site_visit_id']);
                    $lat1    = 0;
                    $long1   = 0;
                    $lat2    = 0;
                    $long2   = 0;
                    
                    if(count($getLatLongDataMin)>0){
                        $lat1    = $getLatLongDataMin[0];
                        $long1   = $getLatLongDataMin[1];  
                    }
                    $distanceTo = 0;
                    $max_site_visit_id = '';
                    if(count($getLatLongDataMax)>0){
                        $lat2    = $getLatLongDataMax[0];
                        $long2   = $getLatLongDataMax[1]; 
                        $distanceTo = $this->cmm->maxDistanceBetTwoLatLongTestNewVersion($lat1,$long1,$lat2,$long2);
                        $dataArr    = array('distance_to' => $distanceTo);
                        $condition = array('site_visiting_id'=>$getLatLongDataMax[2]);
                        $max_site_visit_id = $getLatLongDataMax[2];
                    }
                    $this->cmm->update($dataArr,$condition,'site_visiting');
                    
                    $response = array('message'=>'','status'=>'1','distanceTo'=>$distanceTo, 'max_site_visit_id'=>$max_site_visit_id);
            }
        }
        echo json_encode($response);
    }
    
    function getVisitRoute()
    {
        $response = array('message'=>'Request Failed','status'=>'0');
        if(isset($_REQUEST['site_visit_id']) && !empty($_REQUEST['site_visit_id']))
        {
            $userInfo = $this->um->getUserSession();
            if($userInfo)
            {
                $dataArr =array('verified_by'=>$userInfo->user_id);
                $condition = array("site_visiting_id"=>trim($_REQUEST['site_visit_id']));
                //$this->cmm->update($dataArr,$condition,'site_visiting');
                $response = array('message'=>'','status'=>'1');
            }
        }
        echo json_encode($response);
    }
    
    function testing(){
        $imageContent   = file_get_contents('http://localhost/security_app/uploads/thumb_path/user_img_02092015202402.jpeg');
        echo base64_encode($imageContent);die;
    }
    
    function testDistance()
    {
        $lat1 =$_REQUEST['lat1'];
        $lon1=$_REQUEST['long1'];
        $lat2=$_REQUEST['lat2'];
        $lon2=$_REQUEST['long2'];
        print_r($this->cmm->distanceBetTwoLatLongTest($lat1,$lon1,$lat2,$lon2));
    }


    function testnewapi()
    {
        $greaterD = 0;
        $delta  = $this->cmm->maxDistanceBetTwoLatLongTestNewVersion('22.761466','75.9056083','22.761467','75.9056084');
        //echo '<pre>'; print_r($delta);                '22.7186925', '75.8875472'
        echo $delta;        
    }

    function getAllCompanyData($request,$token){
            $user_info=$this->um->getUserByUserToken($token);
            $this->benchmark->mark('api_code_start');
            $siteData   = $this->sm->getSiteListByUserId($user_info->user_id);
            $this->cmm->print_log('getSiteListByUserId','Data for Response => '.json_encode($siteData));            
            $siteDataResponse = array();
            for($i=0;$i<count($siteData);$i++){
                $siteQuestionData   = $this->ques->getQuestionDataBySiteId($siteData[$i]->site_id);
                $this->cmm->print_log('getQuestionDataBySiteId','Data for Response => '.json_encode($siteQuestionData));
                $guardListData  = $this->gd->getGuardDataBySiteId($siteData[$i]->site_id);
                $this->cmm->print_log('getGuardDataBySiteId','Data for Response => '.json_encode($guardListData));
                $siteDataResponse[] = array('siteData'=>$siteData[$i],'questionData'=>$siteQuestionData,'guardList'=>$guardListData);
            }
            $gQuestionData   = $this->ques->getGuardQuestionData();
            $guardListData   = $this->um->getGuardDataByCompanyId($user_info->company_id);
            $this->cmm->print_log('getGuardListByCompanyId','Data for Response => '.json_encode($guardListData));
            for($i=0;$i<count($guardListData);$i++){
                 $guardDataResponse[$i] = array('guardData'=>$guardListData[$i]);
            }
            $output = array('siteList'=>$siteDataResponse, 'guardList'=>$guardDataResponse,'guardQuestionData'=>$gQuestionData);
            $this->benchmark->mark('api_code_start');
            $this->response = array('responseCode'=>100,'responseData'=>$this->cmm->object_to_array($output));
            $this->cmm->print_log('getSiteListByUserId','Request Response => '.json_encode($this->response));
            $this->cmm->print_time_log('getSiteListByUserId','api_code_start','api_code_end');
            return $this->response;
        }
        
        function test(){
            //22.716406375  75.884968068    22.7151646  75.8862708  315

            echo $this->cmm->distanceBetTwoLatLongUsingFormula('22.716406375','75.884968068','22.7151646','75.8862708','m');
        }
        
}