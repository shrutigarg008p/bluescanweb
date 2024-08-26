<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Guard extends CI_Controller
{
    public $um;
    public $cm;
    public $cmm;
    public $qc;
    public $sm;
    public $gd;
    
    function  __construct(){
        parent::__construct();
        $this->user =	unserialize($this->session->userdata('users'));
        $this->qc = $this->queryconstant;
        $this->load->library('upload');
        $this->load->model('usermanager');
        $this->load->model('companymanager');
        $this->load->model('commonmanager');
        $this->load->model('sitemanager');
        $this->load->model('guardmanager');
        $this->load->model('questionmanager');
        $this->um  = $this->usermanager;
        $this->cm  = $this->companymanager;
        $this->cmm = $this->commonmanager;
        $this->qc  = $this->queryconstant;
        $this->sm  = $this->sitemanager;
        $this->gd  = $this->guardmanager;
         $this->ques = $this->questionmanager;
         $this->response_message = $this->config->item('service_responce_message');
        //session_start();
        //
        $this->load->library('paginator');
    }
    
    function index()
    {
        $this->um->checkLoginSession();
        $companyId = '';
        if($this->user->role_code != 'sadmin'){
            $companyId  = $this->user->company_id;
        }
        
        $cur_page = $this->input->post('page') ? $this->input->post('page') : 1;
        $perPage  = $this->config->item('perPage');
        $vars['perPage']   = $perPage;
        $vars['page']      = $cur_page;
        $offset = ($cur_page*$perPage)-$perPage;
        $count  = $this->gd->getAllGuardPageList('',$offset,$perPage,true);
        $vars['total_record']   = $count;
        $pages  = new paginator($count, $perPage, $cur_page);
        $vars['pagination'] = $pages;        
              
        $guardData        = $this->gd->getAllGuardPageList('',$offset,$perPage,false);
        $vars['guardData']= $guardData;
        $vars['title']      = 'Guard List';
        $vars['contentView']= 'guard_list';
        $vars['mainTab']    = "company";
        $this->load->view('inner_template', $vars);
    }


    function getGuradDataByGuardId($request){
        if(!isset($request['guard_id']) || trim($request['guard_id'])==''){
                $this->response = array('responseCode'=>120,'responseData'=>$this->response_message['120']);
                $this->cmm->print_log('getGuradDetailByGuardIdQR','Missing Response => '.json_encode($this->response));
                return $this->response;
        }
        $this->benchmark->mark('api_code_start');
        $guardData  = $this->gd->getGuardDataByQrcode($request['guard_id'],true,$companyId);
        $this->cmm->print_log('getGuradDataByGuardId','Data for Response => '.json_encode($guardData));
        $questionData = array();
        if(!empty($guardData)){
            $guardId = $guardData->guard_id;
            //get guard question data
            $questionData   = $this->ques->getQuestionDataByGuardId($guardId);
            $this->cmm->print_log('getQuestionDataBySiteId','Data for Response => '.json_encode($questionData));

        }
        $this->benchmark->mark('api_code_end');
        $output = array('guardData'=>$guardData,'questionData'=>$questionData);
        $this->cmm->print_time_log('getGuradDataByGuardId','api_code_start','api_code_end');
        $this->response = array('responseCode'=>100,'responseData'=>$this->cmm->object_to_array($output));
        $this->cmm->print_log('getGuradDataByGuardId','Request Response => '.json_encode($this->response));
        return $this->response;
    }
    
    function saveGuardAttendanceAndImage($request,$token){
        if(!isset($request['guard_id']) || trim($request['guard_id'])==''){
                $this->response = array('responseCode'=>120,'responseData'=>$this->response_message['120']);
                $this->cmm->print_log('saveGuardAttendanceAndImage','Missing Response => '.json_encode($this->response));
                return $this->response;
        }
        if(!isset($request['site_id'])&& empty($request['site_id'])){
                $this->response  = array('responseCode'=>117,'responseData'=>$this->response_message['117']);
                $this->cmm->print_log('saveSiteInspection','Missing Response => '.json_encode($this->response));  
                return $this->response;
            }
        if(!isset($request['datetime'])&& empty($request['datetime'])){
            $this->response  = array('responseCode'=>118,'responseData'=>$this->response_message['118']);
            $this->cmm->print_log('saveGuardAttendanceAndImage','Missing Response => '.json_encode($this->response));  
            return $this->response;
        }
        if(!isset($request['latitude'])&& empty($request['latitude'])){
            $this->response  = array('responseCode'=>122,'responseData'=>$this->response_message['122']);
            $this->cmm->print_log('saveGuardAttendanceAndImage','Missing Response => '.json_encode($this->response));  
            return $this->response;
        }
        if(!isset($request['longitude'])&& empty($request['longitude'])){
            $this->response  = array('responseCode'=>123,'responseData'=>$this->response_message['123']);
            $this->cmm->print_log('saveGuardAttendanceAndImage','Missing Response => '.json_encode($this->response));  
            return $this->response;
        }
        if(!isset($request['designation'])&& empty($request['designation'])){
            $this->response  = array('responseCode'=>143,'responseData'=>$this->response_message['143']);
            //$this->cmm->print_log('saveGuardAttendanceAndImage','Missing Response => '.json_encode($this->response));  
            return $this->response;
        }
        if(!isset($request['image'])&& empty($request['image'])){
            $this->response  = array('responseCode'=>132,'responseData'=>$this->response_message['132']);
            $this->cmm->print_log('saveGuardAttendanceAndImage','Missing Response => '.json_encode($this->response));  
            return $this->response;
        }
        //$role_data=$this->cmm->getRoleByRoleCode($request['role_code']);
        //echo "<pre>";print_r($role_data);die;
        $this->benchmark->mark('api_code_start');
        $siteDetails= $this->sm->getAllSiteDetailsBySiteId($request['site_id']);
        //print_r($siteDetails);die;
        $dateTime   = date('Y-m-d H:i:s' ,strtotime($request['datetime']));
        $siteArrivalTime = '00:00:00';
        $reuqstdate = date('Y-m-d' ,strtotime($request['datetime']));
        $siteThresholdValue = $this->sm->getThresholdvaluesBySiteId($request['site_id'],$dateTime,$reuqstdate);
        if(count($siteThresholdValue) > 0){
            $siteArrivalTime = $siteThresholdValue->threshold_time;
        }
        
       /* $threeshold1    = date('Y-m-d').' '.$siteDetails->first_shift_threshold_time;
        $threeshold2    = date('Y-m-d').' '.$siteDetails->second_shift_threshold_time;
        $threeshold3    = date('Y-m-d').' '.$siteDetails->third_shift_threshold_time;
        if((strtotime($dateTime) < strtotime($threeshold1)) || ((strtotime($dateTime)>=strtotime($threeshold1)) && (strtotime($dateTime)<strtotime($threeshold2)))){
            $siteArrivalTime    = date('H:i:s',  strtotime($threeshold1));
        }else if(((strtotime($dateTime)>=strtotime($threeshold2)) && (strtotime($dateTime)<strtotime($threeshold3)))){
            $siteArrivalTime    = date('H:i:s',  strtotime($threeshold2));
        }else if((strtotime($dateTime)>=strtotime($threeshold3))){
            $siteArrivalTime    = date('H:i:s',  strtotime($threeshold3));
        }
        */
        $photo_url = $this->cmm->saveAsImageBase64($request['image']);
        $user_info = $this->um->getUserByUserToken($token);
        $data   = array('employee_id'       => $request['guard_id'],
                        'site_id'           => $request['site_id'],
                        'attendance_date'   => $dateTime,
                        'latitude'          => $request['latitude'],
                        'longitude'         => $request['longitude'],
                        'designation'         => $request['designation'],
                        'recorded_by'       => $user_info->user_id,
                        'time_in'           => date('H:i:s',strtotime($dateTime)),
                        'photo_url'         => $photo_url,
                        'site_arrival_time' => $siteArrivalTime
                    );
        $this->cmm->insert($data,'employee_attendance');
        $this->cmm->print_log('insert guard_attendance','Insert Attendense Data for Response => '.json_encode($data));

        $this->benchmark->mark('api_code_end');
        $this->cmm->print_time_log('saveGuardAttendanceAndImage','api_code_start','api_code_end');
        $this->response = array('responseCode'=>100,'responseData'=>true);
        $this->cmm->print_log('saveGuardAttendanceAndImage','Request Response => '.json_encode($this->response));
        return $this->response;
    }
            
    function addEditGuard()
    {
        $this->um->checkLoginSession();
        $head = 'Add';
        $guardId    = '';
        $companyId  = '';
        $doctypeId  = '';        
        $first_name = '';
        $last_name  = '';
        $phone      = '';
        $mobile     = '';
        $address    = '';
        $zip        = '';                
        $post       = '';        
        $technical_qualification  = '';
        $language_known   = array();
        $language_known_vals = '';
        $experience = '';
        $skills     = '';
        $created_by = '';
        $status     = 1;
        $guardId    = base64_decode($this->uri->segment(3));
        $companyId  = $this->user->company_id;
        if(isset($guardId)&&!empty($guardId))
        {
            $head = 'Edit';
            $guardData   = $this->gd->getGuardDataByGuardId($guardId); 
            $companyId  = $guardData->company_id;
            $first_name = $guardData->first_name;
            $last_name  = $guardData->last_name;
            $phone      = $guardData->phone;
            $mobile     = $guardData->mobile;
            $address    = $guardData->address;
            $zip        = $guardData->zip;
            $post       = $guardData->post;
            $technical_qualification  = $guardData->technical_qualification;
            $language_known_vals = $guardData->language_known;
            //$experience = $guardData->experience;
            $status     = $guardData->status;            
        }
        
        if($this->input->post())
        {
            if($this->input->post('skill')){
                $skills    =  $this->input->post('skill');
            }
            if($this->input->post('experience')){
                $experience    =  $this->input->post('experience');                
            }
            if($this->input->post('company_name')){
                $companyId    =   trim($this->input->post('company_name'));
            }
            if($this->input->post('first_name')){
                $first_name   =   trim($this->input->post('first_name'));
            }
            if($this->input->post('last_name')){
                $last_name    =   trim($this->input->post('last_name'));
            }
            if($this->input->post('phone')){
                $phone        =   trim($this->input->post('phone'));
            }
            if($this->input->post('mobile')){
                $mobile          =   trim($this->input->post('mobile'));
            }
            if($this->input->post('address')){
                $address    =   trim($this->input->post('address'));
            }
            if($this->input->post('post')){
                $post    =   trim($this->input->post('post'));
            }
            if($this->input->post('language_known')){
                $language_known =   $this->input->post('language_known');                                
            }
            if($this->input->post('zipcode')){
                $zip    =   trim($this->input->post('zipcode'));
            }
            if($this->input->post('technical_qualification')){
                $technical_qualification =   trim($this->input->post('technical_qualification'));
            }
            /*if($this->input->post('experience')){
                $experience  =   trim($this->input->post('experience'));
            } */           
            if($this->input->post('document_type')){
               $doctypeId  =   trim($this->input->post('document_type'));
            }
            if(isset($language_known) && !empty($language_known))
            {
                $language_known_vals = "";
                foreach ($language_known as $value){
                    $language_known_vals = $language_known_vals.$value.",";
                }
                $language_known_vals = rtrim($language_known_vals, ",");
            }
            if($this->_validation_guard() == TRUE){

                if(!empty($_FILES['guard_upload_files']['name'][0]))
                {
                    $url_names = $this->doupload();
                }
                
                $dataArr    = array('company_id'  => $companyId,
                                'first_name'      => $first_name,
                                'last_name'       => $last_name,
                                'address'         => $address,
                                'phone'           => $phone,
                                'mobile'          => $mobile,
                                'zip'             => $zip,
                                'language_known'  => $language_known_vals,
                                'technical_qualification'    => $technical_qualification,
                                'post'            => $post,                                
                                //'experience'      => $experience,
                                'status'          => $status,
                                'created_date'    => date('Y-m-d H:i:s')
                            );

                if(isset($guardId) && !empty($guardId)){
                        log_message('info', 'Update Guard data : '.print_r($dataArr,true));
                        $condition  = array('guard_id'    => $guardId);
                        $this->cmm->update($dataArr,$condition,'guard');

                        if(!empty($url_names))
                        {      
                            $guardDocUrl = $this->gd->getGuardDocByGuardId($guardId,$doctypeId);
                            for($i=0;$i<count($guardDocUrl);$i++)
                            {                                
                                unlink("uploads/guard_docs/" . $guardDocUrl[$i]->document_url);
                            }                      

                            $dataArr = array('guard_id' => $guardId,
                                   'document_type_id'  => $doctypeId                                                                    
                                 );
                            log_message('info', 'Delete Documents data : '.print_r($dataArr,true));
                            $this->cmm->delete($dataArr,'guard_document');

                            foreach ($url_names as $value)
                            {
                                $dataArr = array('guard_id' => $guardId,
                                    'document_type_id'      => $doctypeId,                                
                                    'document_url'          => $value
                                    );                                
                                log_message('info', 'Insert Documents data : '.print_r($dataArr,true));
                                $this->cmm->insert($dataArr,'guard_document');
                            }                            
                        }

                        if(!empty($skills))
                        {
                            $dataArr = array('guard_id' => $guardId);
                            log_message('info', 'Delete Guard Skills data : '.print_r($dataArr,true));
                            $this->cmm->delete($dataArr,'guard_skill');

                            for($i=0;$i<count($skills);$i++)
                            {
                                $dataArr = array('guard_id' => $guardId,
                                    'skill_id'          => $skills[$i],                                
                                    'skill_experience'  => $experience[$i]
                                    );                                                                
                                log_message('info', 'Insert Guard Skill data : '.print_r($dataArr,true));
                                $this->cmm->insert($dataArr,'guard_skill');
                            }                            
                        }

                        $this->session->set_flashdata('successMessage', 'Guard updated successfully.');
                        redirect("guard");
                }else{

                        log_message('info', 'Insert Guard data : '.print_r($dataArr,true));
                        $guardId = $this->cmm->insert($dataArr,'guard');
                        
                        $qrCode     = $this->config->item('qr_code_guard_prifix').$guardId;
                        $fileName   = $this->cmm->getBarcode($qrCode,'GUARDIMG_'.$qrCode,'./uploads/guard/');
                        
                     
                        $condition  = array('guard_id'    => $guardId);
                        $this->cmm->update(array('qr_code'=>$qrCode),$condition,'guard'); 
                        
                        if(!empty($url_names))
                        {
                            foreach ($url_names as $value)
                            {
                                $dataArr = array('guard_id' => $guardId,
                                    'document_type_id'      => $doctypeId,                                
                                    'document_url'          => $value
                                    );                                
                                log_message('info', 'Insert Documents data : '.print_r($dataArr,true));
                                $this->cmm->insert($dataArr,'guard_document');
                            }
                        }

                        if(!empty($skills))
                        {
                            for($i=0;$i<count($skills);$i++)
                            {
                                $dataArr = array('guard_id' => $guardId,
                                    'skill_id'          => $skills[$i],                                
                                    'skill_experience'  => $experience[$i]
                                    );                                                                
                                log_message('info', 'Insert Guard Skill data : '.print_r($dataArr,true));
                                $this->cmm->insert($dataArr,'guard_skill');
                            }                            
                        }                        
                        $this->session->set_flashdata('successMessage', 'Guard added successfully.');                        
                        redirect("guard");
                }
            }
        }
        //$vars['licenseData'] = $this->cm->getAllCompanyLicenseList($companyId);        
        
        $vars['company_ids']  =   $this->cm->getAllCompanyList();
        $vars['company_id']   =   $companyId;
        $vars['doc_type_id']  =   $doctypeId;
        $vars['doc_type_ids'] =   $this->gd->getAllDocTypeList();
        $vars['skillData']    =   $this->gd->getAllSkill();
        $vars['first_name']   =   $first_name;
        $vars['last_name']    =   $last_name;
        $vars['phone']        =   $phone;
        $vars['mobile']       =   $mobile;
        $vars['address']      =   $address;        
        $vars['zip']          =   $zip;
        $vars['post']         =   $post;
        $vars['technical_qualification']   =   $technical_qualification;                
        $language_known       = explode(',', $language_known_vals);
        $vars['language_known']   =   $language_known;
        //$vars['experience']   =   $experience;        
        $vars['title']        = $head.' Guard';
        $vars['pageHeading']  = $head.' Guard';
        $vars['contentView']  = 'add_edit_guard';
        $vars['mainTab']    = "company";
        $this->load->view('inner_template', $vars);        
    }


    function doupload()
    {
        //$pathtype = ($type==1)?'guard_img':'guard_docs';
        $number_of_files = sizeof($_FILES['guard_upload_files']['tmp_name']);    
        $files = $_FILES['guard_upload_files'];
        $errors = array();
        for($i=0;$i<$number_of_files;$i++)
        {
            if($_FILES['guard_upload_files']['error'][$i] != 0)
            $errors[$i][] = 'Couldn\'t upload file '.$_FILES['guard_upload_files']['name'][$i];
        }
        if(sizeof($errors)==0)
        {            
            $returnfilename = array();
            $newfile='';
            $this->load->library('upload');
            $config['upload_path'] = './uploads/guard_docs';
            $config['allowed_types'] = '*';
      
            for ($i = 0; $i < $number_of_files; $i++)
            {                
                $_FILES['guard_upload_files']['name'] = 'guard_doc_'.date('dmYHis').$i;
                $_FILES['guard_upload_files']['type'] = $files['type'][$i];
                $_FILES['guard_upload_files']['tmp_name'] = $files['tmp_name'][$i];
                $_FILES['guard_upload_files']['error'] = $files['error'][$i];
                $_FILES['guard_upload_files']['size'] = $files['size'][$i];
                $this->upload->initialize($config);
                if ($this->upload->do_upload('guard_upload_files'))
                {
                    $data['uploads'][$i] = $this->upload->data();
                    $newfile = $data['uploads'][$i]['file_name'];                    
                    array_push($returnfilename, $newfile);
                }
                else
                {
                    $data['upload_errors'][$i] = $this->upload->display_errors();
                }
            }
        }
        else
        {
            print_r($errors);
        }
        return $returnfilename;
    }
    
    function _validation_file(){
        $this->form_validation->set_rules('document_type','Document Type','trim|required');     
        $this->form_validation->set_error_delimiters('<span class="error">','</span>');
        return $this->form_validation->run();
    }
    
    function _validation_guard(){
        $this->form_validation->set_rules('company_name','Company Name','trim|required');
        $this->form_validation->set_rules('first_name','First Name','trim|required');
        $this->form_validation->set_rules('last_name','Last Name','trim|required');        
        $this->form_validation->set_rules('mobile','Mobile Number','trim|required|numeric');
        $this->form_validation->set_rules('address', 'Address','trim|required');        
        $this->form_validation->set_rules('post', 'Post','trim|required');
        if(!empty($_FILES['guard_upload_files']['name'][0]))
        {
            $this->form_validation->set_rules('document_type','Document Type','trim|required');
        }        
        //$this->form_validation->set_rules('technical_qualification', 'Technical qualification','trim|required');
        //$this->form_validation->set_rules('language_known', 'Languages known','trim|required');                
        //$this->form_validation->set_rules('experience','Experience','trim');
        //$this->form_validation->set_rules('zipcode','ZipCode','trim');
        $this->form_validation->set_error_delimiters('<span class="error">','</span>');
        return $this->form_validation->run();
    }

    function lateAttendance()
    {          
        $this->um->checkLoginSession();        
        $companyId = isset($this->user->company_id)?$this->user->company_id:'';
        $regionIds = isset($this->user->region_ids)?$this->user->region_ids:'';
        $branchIds = isset($this->user->branch_ids)?$this->user->branch_ids:'';
        $siteIds   = isset($this->user->site_ids)?$this->user->site_ids:'';
        if($this->user->role_code == 'sadmin'){
            $companyId  = $this->session->userdata('session_company_id');
            $companyData = $this->cm->getAllRegionBranchSiteDataByCompanyIds($companyId);
            $regionIds = $companyData->region_ids;
            $branchIds = $companyData->branch_ids;
            $siteIds   = $companyData->site_ids;
        }
        
        $where = '';
        if($companyId!=''){
            $where .= ' u.company_id = '.$companyId;
        }
        
        if($siteIds!=''){
            $where .= ' AND ea.site_id IN ('.$siteIds.') ';
        }
        $site_id    = ''; 
        $guard_id   = ''; 
        $filterDate = ''; 
        if($this->input->post()){
            if($this->input->post('site_id')){
                $site_id    = $this->input->post('site_id');
            }
            if($this->input->post('guard_id')){
                $guard_id    = $this->input->post('guard_id');
            }
            if($this->input->post('filterDate')){
                $filterDate    = $this->input->post('filterDate');
            }
        }
        
        if($site_id){
            $where .= ' AND ea.site_id = '.$site_id;
        }
        
        if($guard_id){
            $where .= ' AND ea.employee_id = '.$guard_id;
        }
        
        if($filterDate ){
            $where .= ' AND Date(ea.attendance_date) = Date('."'".$filterDate."'".')' ;
        }
        
        $cur_page = $this->input->post('page') ? $this->input->post('page') : 1; 
        $perPage  = $this->config->item('perPage');
        $vars['perPage']   = $perPage;
        $vars['page']      = $cur_page;
        $offset = ($cur_page*$perPage)-$perPage;
        $count  = $this->gd->getGuardAttendListByGId($where,$offset,$perPage,true);
        $vars['total_record']   = $count;
        $pages  = new paginator($count, $perPage, $cur_page);
        $vars['pagination'] = $pages;
        $vars['guardAttData'] = $this->gd->getGuardAttendListByGId($where,$offset,$perPage,false);
        
        $vars['guardData']          = $this->gd->getAllGuardList($companyId);
        $vars['getAllSiteDropdown'] = $this->sm->getAllSiteListDropdown('',$companyId,$this->user->user_id,$this->user->role_code);
        $vars['site_id']    = $site_id;
        $vars['guard_id']    = $guard_id;
        $vars['filterDate'] = $filterDate;
        $vars['mainTab']    = 'Attendance';
        $vars['title']      = 'Late Attendance';
        $vars['contentView']= 'late_attendance_list';
        $this->load->view('inner_template', $vars);
    }
    
    function guardAttendance(){
        $this->um->checkLoginSession();
        $filterType = 2;
        $companyId = isset($this->user->company_id)?$this->user->company_id:'';
        $regionIds = isset($this->user->region_ids)?$this->user->region_ids:'';
        $branchIds = isset($this->user->branch_ids)?$this->user->branch_ids:'';
        $siteIds   = isset($this->user->site_ids)?$this->user->site_ids:'';
        if($this->user->role_code == 'sadmin'){
            $companyId  = $this->session->userdata('session_company_id');
            $companyData = $this->cm->getAllRegionBranchSiteDataByCompanyIds($companyId);
            $regionIds = $companyData->region_ids;
            $branchIds = $companyData->branch_ids;
            $siteIds   = $companyData->site_ids;
        }
         
        $where = '';
        if($siteIds!=''){
            $where = ' ea.site_id IN ('.$siteIds.') ';
        }else
        {
           $where =' 1'; 
        }

        
        $filter_year = date('Y');
        $filter_month = date('m');
        $filterDate = date('Y-m-d'); 
        if($this->input->post()){
            if($this->input->post('filterDate')){
                $filterDate    = $this->input->post('filterDate');
            }
            if($this->input->post('filterType')){
                $filterType     = $this->input->post('filterType');
            }
            if($this->input->post('filter_month')){
                $filter_month     = $this->input->post('filter_month');
            }
            if($this->input->post('filter_year')){
                $filter_year     = $this->input->post('filter_year');
            }
        }
        
        if($filterDate!='')
        {
            if($filterType == 1)
            {
                $where .= ' AND Date(ea.attendance_date) = Date('."'".$filterDate."'".')' ;
            }
            if($filterType == 2)
            {
                $filterDate = $filter_year.'-'.$filter_month.'-'.date('d');
                $filterDate = date('Y-m-d',  strtotime($filterDate));
                $where .= ' AND MONTH(ea.attendance_date) = MONTH('."'".$filterDate."'".')' ;
            }
        }

       
        $dateArr = array();
        
       
        $vars['guardAttData'] = $this->gd->getGuardAttendanceList($where);
        //echo "<pre>";print_r($vars['guardAttData']);die;
        $vars['filterDate'] = $filterDate;
        $vars['filterType'] = $filterType;
        $vars['filter_month'] = $filter_month;
        $vars['filter_year'] = $filter_year;
        $vars['dateArr']    = $dateArr;
        $vars['mainTab']    = 'Attendance';
        $vars['title']      = 'Guard Attendance';
        $vars['contentView']= 'guard_attend_list';
        $this->load->view('inner_template', $vars);
    }
    
    
    function getGuardDetails(){
        $guardId = base64_decode($this->uri->segment(3));
        $vars['guardDetails']  =  $this->gd->getGuardDataByGuardId($guardId);  
        //print_r($vars['siteDetails']);die;
       // print_r($vars['siteDetails']);die;
        $this->load->view('guard_detail_qr_code', $vars);       
    }
    
    
    function saveGuardInspection($request,$token){
        /** START required validation **/
            if(!isset($request['guard_id'])&& empty($request['guard_id'])){
                $this->response  = array('responseCode'=>120,'responseData'=>$this->response_message['120']);
                $this->cmm->print_log('saveGuardInspection','Missing Response => '.json_encode($this->response));  
                return $this->response;
            }
            if(!isset($request['lat'])&& empty($request['lat'])){
                $this->response  = array('responseCode'=>122,'responseData'=>$this->response_message['122']);
                $this->cmm->print_log('saveGuardInspection','Missing Response => '.json_encode($this->response));  
                return $this->response;
            }
            if(!isset($request['long'])&& empty($request['long'])){
                $this->response  = array('responseCode'=>123,'responseData'=>$this->response_message['123']);
                $this->cmm->print_log('saveGuardInspection','Missing Response => '.json_encode($this->response));  
                return $this->response;
            }
            
          
            if(!isset($request['questionAnsArr'])||empty($request['questionAnsArr'])){
                $this->response  = array('responseCode'=>124,'responseData'=>$this->response_message['124']);
                $this->cmm->print_log('saveGuardInspection','Missing Response => '.json_encode($this->response));  
                return $this->response;
            }else{
                $requestQuestData   = json_decode($request['questionAnsArr']);
                $questionData = $this->ques->getGuardQuestionData();
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
                //print_r($requiredQuesArr);die;
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
                    $this->response  = array('responseCode'=>127,'responseData'=>$this->response_message['127']);
                    $this->cmm->print_log('saveGuardInspection','Question are not for this Guard => '.json_encode($this->response));  
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
                    $this->cmm->print_log('saveGuardInspection','Required Question => '.json_encode($this->response));  
                    return $this->response;
                }
            }
            /** END **/ 
            
            $comment = '';
            if(isset($request['comment']) && !empty($request['comment'])){
                $comment = $request['comment'];
            }
            
            $this->benchmark->mark('api_code_start');
            $user_info = $this->um->getUserByUserToken($token);
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
            
            /** START An entry for site visiting **/
            $data   = array( 
                       'guard_id'       => $request['guard_id'],
                       'latitude'       => $request['lat'],
                       'longitude'      => $request['long'],
                       'user_id'        => $user_info->user_id,
                       'visiting_time'  => $dateTime,
                       'comment'        => $comment
                );
            $siteVisitingId = $this->cmm->insert($data,'site_visiting');
            $this->cmm->print_log('insert site_visiting','Insert site_visiting Data for Response => '.json_encode($data));
            /** END **/ 
            
            /** START entry for during guard inspection save the Question ans details**/
            if($siteVisitingId){
                for($j=0;$j<count($questionData);$j++){
                    if(in_array($questionData[$j]->question_id,$requestQuesArray)){
                       $answer  = $requestAnsArray[$questionData[$j]->question_id];
                       if($questionData[$j]->question_type == 'image'){
                           $answer = $this->cmm->saveAsImageBase64($requestAnsArray[$questionData[$j]->question_id]);
                       } 
                       $quesAnsData    = array('question_id' => $questionData[$j]->question_id,
                                                'question_text' => $questionData[$j]->question,
                                                'answer'        =>  $answer,
                                                'inserted_date' => $dateTime,
                                                'site_visiting_id' => $siteVisitingId);
                       $this->cmm->insert($quesAnsData,'site_question_answer');
                       $this->cmm->print_log('saveGuardInspection','Insert guard question_answer Data  => '.json_encode($quesAnsData));
                    }
                }
                if(isset($request['imagesDataArr'])||!empty($request['imagesDataArr'])){
                    $imagesDataArr  = json_decode($request['imagesDataArr']);
                    for($i=0;$i<count($imagesDataArr);$i++){
                        $imageUrl   = $this->cmm->saveAsImageBase64($imagesDataArr[$i]);
                        if($imageUrl){
                            $fileData    = array('site_visiting_id' => $siteVisitingId,'file_path' => $imageUrl);
                            $this->cmm->insert($fileData,'inspection_images');
                            $this->cmm->print_log('saveGuardInspection','Insert guard images Data  => '.json_encode($fileData));
                        }                        
                    }
                }
            }
            /** END **/ 
            
            
            $this->benchmark->mark('api_code_end');
            $this->response = array('responseCode'=>100,'responseData'=>true);
            $this->cmm->print_log('saveGuardInspection','Service responce => '.json_encode($this->response));
            $this->cmm->print_time_log('saveGuardInspection','api_code_start','api_code_end');
            return $this->response;
    }

    function survey()
    {
       // echo base64_encode(35);die;
        $siteVisitingId = '';
        $siteVisitingId = base64_decode($this->uri->segment(3));
        $vars['surveyData'] = $this->gd->getSurveyData($siteVisitingId);
        $vars['title']      = 'Survey Response';
        $vars['contentView']= 'survey_response';
        $this->load->view('inner_template', $vars);
    }
    
    function guardSurvey(){
        $siteVisitingId = '';
        $siteVisitingId = base64_decode($this->uri->segment(3));
        $vars['surveyData'] = $this->gd->getGuardSurveyData($siteVisitingId);
        $vars['title']      = 'Survey Response';
        $vars['contentView']= 'guard_survey_response';
        $this->load->view('inner_template', $vars);
    }
            
    
    function markVerifyGuard()
    {
    	$response = array('message'=>'Request Failed','status'=>'0');
    	if(isset($_REQUEST['attendanceId']) && !empty($_REQUEST['attendanceId']))
    	{
            $userInfo = $this->um->getUserSession();
            if($userInfo)
            {
                    $dataArr =array('verified_by'=>$userInfo->user_id, 'remark'=>$_REQUEST['remark']);
                    $condition = array("employee_attendance_id"=>trim($_REQUEST['attendanceId']));
                    $this->cmm->update($dataArr,$condition,'employee_attendance');
                    $response = array('message'=>'','status'=>'1');
            }
    	}
    	echo json_encode($response);
    }
    
    
    function renderGuradProfileByGuardId($request){
        if(!isset($request['guard_id']) || trim($request['guard_id'])==''){
                $this->response = array('responseCode'=>120,'responseData'=>$this->response_message['120']);
                $this->cmm->print_log('renderGuradProfileByGuardId','Missing Response => '.json_encode($this->response));
                return $this->response;
        }
        $this->benchmark->mark('api_code_start');
        $employee_id    = $request['guard_id'];
        $guardData      = $this->gd->getGuardDataByQrcode($employee_id,true);
        $this->cmm->print_log('renderGuradProfileByGuardId','getGuardDataByQrcode Data for Response => '.json_encode($guardData));
        $qualificationData  = $this->um->getQualificationByEmployeeId($employee_id);         
        $this->cmm->print_log('renderGuradProfileByGuardId','getQualificationByEmployeeId Data for Response => '.json_encode($qualificationData));
        $skillData          = $this->um->getSkillDetailByEmployeeId($employee_id);
        $this->cmm->print_log('renderGuradProfileByGuardId','getSkillDetailByEmployeeId Data for Response => '.json_encode($skillData));
        $experienceData     = $this->um->getExperienceDetailByEmployeeId($employee_id);
        $this->cmm->print_log('renderGuradProfileByGuardId','getExperienceDetailByEmployeeId Data for Response => '.json_encode($experienceData));
        $reviewData         = $this->um->getReviewDataByEmployeeId($employee_id);
        $this->cmm->print_log('renderGuradProfileByGuardId','getReviewDataByEmployeeId Data for Response => '.json_encode($reviewData));
        $ratingData         = $this->um->getRatingDataByEmployeeId($employee_id);
        $this->cmm->print_log('renderGuradProfileByGuardId','getRatingDataByEmployeeId Data for Response => '.json_encode($ratingData));
        $numberOfReviews = count($reviewData);
        
        $avgRating  = $this->um->getAvgReviewRatingByEmployeeId($employee_id);
        
        $this->cmm->print_log('numberOfReviews','numberOfReviews Data for Response => '.$numberOfReviews);
        $this->benchmark->mark('api_code_end');
        $output = array('guardData'=>$guardData,
                        'qualificationData'=>$qualificationData,
                        'skillData'=>$skillData,
                        'experienceData'=>$experienceData,
                        'reviewData' => $reviewData,
                        'ratingData' => $ratingData,
                        'numberOfReviews'   => $numberOfReviews,
                        'avgRating' => $avgRating);
        //print_r($output);
        $this->cmm->print_time_log('renderGuradProfileByGuardId','api_code_start','api_code_end');
        $this->response = array('responseCode'=>100,'responseData'=>$this->cmm->object_to_array($output));
        $this->cmm->print_log('renderGuradProfileByGuardId','Request Response => '.json_encode($this->response));
        return $this->response;
    }
    
    function saveGuardReview($request,$token){
        if(!isset($request['guard_id']) || trim($request['guard_id'])==''){
                $this->response = array('responseCode'=>120,'responseData'=>$this->response_message['120']);
                $this->cmm->print_log('saveGuardReview','Missing Response => '.json_encode($this->response));
                return $this->response;
        }
        if(!isset($request['user_id']) || trim($request['user_id'])==''){
                $this->response = array('responseCode'=>116,'responseData'=>$this->response_message['116']);
                $this->cmm->print_log('saveGuardReview','Missing Response => '.json_encode($this->response));
                return $this->response;
        }
        if(!isset($request['comment']) || trim($request['comment'])==''){
                $this->response = array('responseCode'=>137,'responseData'=>$this->response_message['137']);
                $this->cmm->print_log('saveGuardReview','Missing Response => '.json_encode($this->response));
                return $this->response;
        }
        if(!isset($request['rating']) || trim($request['rating'])==''){
                $this->response = array('responseCode'=>136,'responseData'=>$this->response_message['136']);
                $this->cmm->print_log('saveGuardReview','Missing Response => '.json_encode($this->response));
                return $this->response;
        }
        if(!isset($request['review_date']) || trim($request['review_date'])==''){
                $this->response = array('responseCode'=>118,'responseData'=>$this->response_message['118']);
                $this->cmm->print_log('saveGuardReview','Missing Response => '.json_encode($this->response));
                return $this->response;
        }
        $this->benchmark->mark('api_code_start');
        $reviewData = array('employee_id'  => $request['guard_id'],
                            'review_by'  => $request['user_id'],
                            'review_text'  => $request['comment'],
                            'rating'  => $request['rating'],
                            'review_date'  => date('Y-m-d H:i:s',  strtotime($request['review_date']))
                    );
        $this->cmm->print_log('saveGuardReview','review insert Data Array => '.json_encode($reviewData));
        $reviewId = $this->cmm->insert($reviewData,'review');
        $this->cmm->print_log('saveGuardReview','Inserted review id for Response => '.$reviewId);
           
        $this->response = array('responseCode'=>100,'responseData'=>true);
        $this->cmm->print_log('saveGuardReview','Request Response => '.json_encode($this->response));
        return $this->response;
    }
    
    
     function saveGuardRating($request,$token){
        if(!isset($request['guard_id']) || trim($request['guard_id'])==''){
                $this->response = array('responseCode'=>120,'responseData'=>$this->response_message['120']);
                $this->cmm->print_log('saveGuardRating','Missing Response => '.json_encode($this->response));
                return $this->response;
        }
        if(!isset($request['user_id']) || trim($request['user_id'])==''){
                $this->response = array('responseCode'=>116,'responseData'=>$this->response_message['116']);
                $this->cmm->print_log('saveGuardRating','Missing Response => '.json_encode($this->response));
                return $this->response;
        }
        if(!isset($request['discipline_rating']) || trim($request['discipline_rating'])==''){
                $this->response = array('responseCode'=>138,'responseData'=>$this->response_message['138']);
                $this->cmm->print_log('saveGuardRating','Missing Response => '.json_encode($this->response));
                return $this->response;
        }
        if(!isset($request['punctuality_rating']) || trim($request['punctuality_rating'])==''){
                $this->response = array('responseCode'=>139,'responseData'=>$this->response_message['139']);
                $this->cmm->print_log('saveGuardRating','Missing Response => '.json_encode($this->response));
                return $this->response;
        }
        if(!isset($request['fitness_rating']) || trim($request['fitness_rating'])==''){
                $this->response = array('responseCode'=>140,'responseData'=>$this->response_message['140']);
                $this->cmm->print_log('saveGuardRating','Missing Response => '.json_encode($this->response));
                return $this->response;
        }
        if(!isset($request['cleverness_rating']) || trim($request['cleverness_rating'])==''){
                $this->response = array('responseCode'=>141,'responseData'=>$this->response_message['141']);
                $this->cmm->print_log('saveGuardRating','Missing Response => '.json_encode($this->response));
                return $this->response;
        }
        if(!isset($request['cleanliness_rating']) || trim($request['cleanliness_rating'])==''){
                $this->response = array('responseCode'=>142,'responseData'=>$this->response_message['142']);
                $this->cmm->print_log('saveGuardRating','Missing Response => '.json_encode($this->response));
                return $this->response;
        }
        $this->benchmark->mark('api_code_start');
        $data = array('employee_id'         => $request['guard_id'],
                            'rating_by'     => $request['user_id'],
                            'discipline'    => $request['discipline_rating'],
                            'punctuality'   => $request['punctuality_rating'],
                            'fitness'       => $request['fitness_rating'],
                            'cleverness'    => $request['cleverness_rating'],
                            'cleanliness'   => $request['cleanliness_rating']
                    );
        $this->cmm->print_log('saveGuardRating','employee_rating insert Data Array => '.json_encode($data));
        $reviewId = $this->cmm->insert($data,'employee_rating');
        $this->cmm->print_log('saveGuardRating','Inserted employee rating id for Response => '.$reviewId);
           
        $this->response = array('responseCode'=>100,'responseData'=>true);
        $this->cmm->print_log('saveGuardRating','Request Response => '.json_encode($this->response));
        return $this->response;
    }
    
    
}