<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Common extends CI_Controller
{
    public $user;
    function  __construct(){
        parent::__construct();
        $this->user =	unserialize($this->session->userdata('users'));
        $this->qc = $this->queryconstant;
        $this->load->model('usermanager');
        $this->load->model('companymanager');
        $this->load->model('commonmanager');
        $this->load->model('questionmanager');
        $this->load->model('regionmanager');
        $this->load->model('branchmanager');
        $this->load->model('sitemanager');
        $this->um  = $this->usermanager;
        $this->cm = $this->companymanager;
        $this->rm = $this->regionmanager;
        $this->cmn = $this->commonmanager;
        $this->cmm = $this->commonmanager;
        $this->bm = $this->branchmanager;
        $this->sm = $this->sitemanager;
        $this->qc = $this->queryconstant;
        $this->que = $this->questionmanager;
        session_start();
        $this->error_message=$this->config->item('import_error_message');
    }
    
    function setSiteStatus(){
        $responseArray   = array();
        if($this->cmn->checkLoginSessionAjax()){
            $siteId = $this->input->post('site');
            $status     = $this->input->post('status');
            if($siteId){
                if($status == 1){
                    $dataArr    = array('is_published' => 0);
                }else{
                    $dataArr    = array('is_published' => 1);
                }
                $condition	= array('site_id'	=> $siteId);
                $this->cmn->update($dataArr,$condition,'site');
                $responseArray['success']	= 1;
               
            }else{
                $responseArray['success']	= 0;
            }
            $responseArray['status'] = 1;
        }else{
            $responseArray['status'] = 0;
            $responseArray['msg'] = $this->error_message['100'];
        }
        echo json_encode($responseArray);
    }
    
    function getFieldOfiicer(){
          $responseArray   = array();
        if($this->cmn->checkLoginSessionAjax()){
            $siteId = $this->input->post('site');
            if($siteId){
                $fieldOfficerData   = $this->um->getAllFieldOfficers($siteId);
                $responseArray['fieldOfficerData']   = $fieldOfficerData;
                $responseArray['success']   = 1;
            }else{
                $responseArray['success']   = 0;
            }
            $responseArray['status'] = 1;
        }else{
            $responseArray['status'] = 0;
            $responseArray['msg'] = $this->error_message['100'];
        }
        echo json_encode($responseArray);
    }
    
    function getRegionList(){
        $responseArray   = array();
        if($this->cmn->checkLoginSessionAjax()){
            $companyId = $this->input->post('company');
            if($companyId){
                $regionData   = $this->rm->getAllRegionList($companyId);
                $responseArray['regionData']   = $regionData;
                $responseArray['success']   = 1;
            }else{
                $responseArray['success']   = 0;
            }
            $responseArray['status'] = 1;
        }else{
            $responseArray['status'] = 0;
            $responseArray['msg'] = $this->error_message['100'];
        }
        echo json_encode($responseArray);
    }
    
    function getBranchList(){
        $responseArray   = array();
        if($this->cmn->checkLoginSessionAjax()){
            $regionId = $this->input->post('region');
            if($regionId){
                if( $this->user->role_code){
                    
                }
                $companyId = '';
                if(in_array($this->user->role_code, array('cadmin','cuser','sadmin'))){
                    $companyId = $this->session->userdata('session_company_id');
                }
                
                $branchData   = $this->bm->getAllBranchList($regionId,$companyId,$this->user->user_id,$this->user->role_code);
                
                $responseArray['branchData']   = $branchData;
                //print_r($branchData);
                $responseArray['success']   = 1;
            }else{
                $responseArray['success']   = 0;
            }
            $responseArray['status'] = 1;
        }else{
            $responseArray['status'] = 0;
            $responseArray['msg'] = $this->error_message['100'];
        }
        echo json_encode($responseArray);
    }
    
    function getSiteList(){
        $responseArray   = array();
        if($this->cmn->checkLoginSessionAjax()){
            $branchId = $this->input->post('branch');
            if($branchId){
                $companyId = '';
                if(in_array($this->user->role_code, array('cadmin','cuser','sadmin'))){
                    $companyId = $this->session->userdata('session_company_id');
                }
                
                $siteData   = $this->sm->getAllSiteListDropdown($branchId,'','','');
                $responseArray['siteData']   = $siteData;
                //print_r($branchData);
                $responseArray['success']   = 1;
            }else{
                $responseArray['success']   = 0;
            }
            $responseArray['status'] = 1;
        }else{
            $responseArray['status'] = 0;
            $responseArray['msg'] = $this->error_message['100'];
        }
        echo json_encode($responseArray);
    }
    
    function getSiteListByCompanyId(){
        $responseArray   = array();
        if($this->cmn->checkLoginSessionAjax()){
            $companyId = $this->input->post('company');
            if($companyId){
                $siteData   = $this->sm->getAllSiteListDropdown('',$companyId,'','');
                $responseArray['siteData']   = $siteData;
                //print_r($branchData);
                $responseArray['success']   = 1;
            }else{
                $responseArray['success']   = 0;
            }
            $responseArray['status'] = 1;
        }else{
            $responseArray['status'] = 0;
            $responseArray['msg'] = $this->error_message['100'];
        }
        echo json_encode($responseArray);
    }
            
    function setQuestionStatus(){
        $responseArray   = array();
        if($this->cmn->checkLoginSessionAjax()){
            $questionId = $this->input->post('question');
            $status     = $this->input->post('status');
            if($questionId){
                if($status == 1){
                    $dataArr    = array('is_published' => 0);
                     $responseArray['questionStatus']	= 0;
                }else{
                    $dataArr    = array('is_published' => 1);
                     $responseArray['questionStatus']	= 1;
                }
                $condition	= array('question_id'	=> $questionId);
                $this->cmn->update($dataArr,$condition,'question');
                $responseArray['success']	= 1;
               
            }else{
                $responseArray['success']	= 0;
            }
            $responseArray['status'] = 1;
        }else{
            $responseArray['status'] = 0;
            $responseArray['msg'] = $this->error_message['100'];
        }
        echo json_encode($responseArray);
    }
    
    
    function setCompanyStatus(){
        $responseArray   = array();
        if($this->cmn->checkLoginSessionAjax()){
            $companyId = $this->input->post('company');
            $status     = $this->input->post('status');
            if($companyId){
                if($status == 1){
                    $dataArr    = array('is_published' => 0);
                     $responseArray['companyStatus']	= 0;
                }else{
                    $dataArr    = array('is_published' => 1);
                     $responseArray['companyStatus']	= 1;
                }
                $condition	= array('company_id'	=> $companyId);
                $this->cmn->update($dataArr,$condition,'company');
                $responseArray['success']	= 1;
               
            }else{
                $responseArray['success']	= 0;
            }
            $responseArray['status'] = 1;
        }else{
            $responseArray['status'] = 0;
            $responseArray['msg'] = $this->error_message['100'];
        }
        echo json_encode($responseArray);
    }
    
    function setQuestioniInGroup(){
        $responseArray   = array();
        if($this->cmn->checkLoginSessionAjax()){
            $questionId = $this->input->post('question');
            $groupId     = $this->input->post('group');
            if($questionId&&$groupId){
               if($this->que->checkQuestionExistanceIngroup($groupId,$questionId)) 
               { 
                   $dataArr    = array('question_id' => $questionId, 'group_id' => $groupId);
                    $insertId   = $this->cmn->insert($dataArr,'question_group');
                    if($insertId>0){
                        $quesData   = $this->que->getQuestionIdDetailsByQuestionIdId($questionId);
                        $responseArray['ques_name'] = $quesData->question;
                    }
                    $responseArray['success']	= 1;
                    $responseArray['questionGroupId']	= $groupId;
               }else{
                   $responseArray['success']	= 2;
               }
            }else{
                $responseArray['success']	= 0;
            }
            $responseArray['status'] = 1;
        }else{
            $responseArray['status'] = 0;
            $responseArray['msg'] = $this->error_message['100'];
        }
        echo json_encode($responseArray);
    }
    
    
    function setCustomerStatus(){
        $responseArray   = array();
        if($this->cmn->checkLoginSessionAjax()){
            $customerId = $this->input->post('customer');
            $status     = $this->input->post('status');
            if($customerId){
                if($status == 1){
                    $dataArr    = array('status' => 0);
                     $responseArray['customerStatus']	= 0;
                }else{
                    $dataArr    = array('status' => 1);
                     $responseArray['customerStatus']	= 1;
                }
                $condition	= array('customer_id'	=> $customerId);
                $this->cmn->update($dataArr,$condition,'customer');
                $responseArray['success']	= 1;
               
            }else{
                $responseArray['success']	= 0;
            }
            $responseArray['status'] = 1;
        }else{
            $responseArray['status'] = 0;
            $responseArray['msg'] = $this->error_message['100'];
        }
        echo json_encode($responseArray);
    }
    
    function setGroupStatus(){
        $responseArray   = array();
        if($this->cmn->checkLoginSessionAjax()){
            $groupId = $this->input->post('group');
            $status     = $this->input->post('status');
            if($groupId){
                if($status == 1){
                    $dataArr    = array('is_published' => 0);
                     $responseArray['groupStatus']    = 0;
                }else{
                    $dataArr    = array('is_published' => 1);
                     $responseArray['groupStatus']    = 1;
                }
                $condition  = array('group_id'    => $groupId);
                $this->cmn->update($dataArr,$condition,'group');
                $responseArray['success']   = 1;
               
            }else{
                $responseArray['success']   = 0;
            }
            $responseArray['status'] = 1;
        }else{
            $responseArray['status'] = 0;
            $responseArray['msg'] = $this->error_message['100'];
        }
        echo json_encode($responseArray);
    }

    function deleteQuestionGroupStatus(){
        $responseArray   = array();
        if($this->cmn->checkLoginSessionAjax()){
            $groupId = $this->input->post('group');
            if($groupId){
                     
                $condition  = array('question_group_id'    => $groupId);
                $this->cmn->delete($condition,'question_group');
                $responseArray['success']   = 1;
               
            }else{
                $responseArray['success']   = 0;
            }
            $responseArray['status'] = 1;
        }else{
            $responseArray['status'] = 0;
            $responseArray['msg'] = $this->error_message['100'];
        }
        echo json_encode($responseArray);
    }
            
    function removeExperience(){
        $responseArray   = array();
        if($this->cmn->checkLoginSessionAjax()){
            $expid = $this->input->post('expid');
            if($expid){
                     
                $condition  = array('employee_experience_id'    => $expid);
                $this->cmn->delete($condition,'employee_experience');
                $responseArray['success']   = 1;
               
            }else{
                $responseArray['success']   = 0;
            }
            $responseArray['status'] = 1;
        }else{
            $responseArray['status'] = 0;
            $responseArray['msg'] = $this->error_message['100'];
        }
        echo json_encode($responseArray);
    }
    
    function verifyCompanyExperience(){
        $responseArray   = array();
        if($this->cmn->checkLoginSessionAjax()){
            $expid = $this->input->post('expid');
            if($expid){
                $dataArr    = array('verified_by' => $this->user->user_id);
                $condition  = array('employee_experience_id'    => $expid);
                $this->cmn->update($dataArr,$condition,'employee_experience');
                $responseArray['success']   = 1;
               
            }else{
                $responseArray['success']   = 0;
            }
            $responseArray['status'] = 1;
        }else{
            $responseArray['status'] = 0;
            $responseArray['msg'] = $this->error_message['100'];
        }
        echo json_encode($responseArray);
    }
    
    
    function removeEmployeeDocuments(){
        $responseArray   = array();
        if($this->cmn->checkLoginSessionAjax()){
            $docid = $this->input->post('docid');
            if($docid){
                     
                $condition  = array('employee_document_id'    => $docid);
                $this->cmn->delete($condition,'employee_document');
                $responseArray['success']   = 1;
               
            }else{
                $responseArray['success']   = 0;
            }
            $responseArray['status'] = 1;
        }else{
            $responseArray['status'] = 0;
            $responseArray['msg'] = $this->error_message['100'];
        }
        echo json_encode($responseArray);
    }
    
    function removeSkills(){
        $responseArray   = array();
        if($this->cmn->checkLoginSessionAjax()){
            $skillid = $this->input->post('skillid');
            if($skillid){
                     
                $condition  = array('employee_skill_id'    => $skillid);
                $this->cmn->delete($condition,'employee_skill');
                $responseArray['success']   = 1;
               
            }else{
                $responseArray['success']   = 0;
            }
            $responseArray['status'] = 1;
        }else{
            $responseArray['status'] = 0;
            $responseArray['msg'] = $this->error_message['100'];
        }
        echo json_encode($responseArray);
    }
    
    function removeEmpLanguage(){
        $responseArray   = array();
        if($this->cmn->checkLoginSessionAjax()){
            $langid = $this->input->post('langid');
            if($langid){
                     
                $condition  = array('employee_language_id'    => $langid);
                $this->cmn->delete($condition,'employee_language');
                $responseArray['success']   = 1;
               
            }else{
                $responseArray['success']   = 0;
            }
            $responseArray['status'] = 1;
        }else{
            $responseArray['status'] = 0;
            $responseArray['msg'] = $this->error_message['100'];
        }
        echo json_encode($responseArray);
    }
    
    function setOfficeStatus(){
        $responseArray   = array();
        if($this->cmn->checkLoginSessionAjax()){
            $officeId = $this->input->post('office');
            $status     = $this->input->post('status');
            if($officeId){
                if($status == 1){
                    $dataArr    = array('is_published' => 0);
                     $responseArray['companyStatus']    = 0;
                }else{
                    $dataArr    = array('is_published' => 1);
                     $responseArray['companyStatus']    = 1;
                }
                $condition  = array('company_office_id'    => $officeId);
                $this->cmn->update($dataArr,$condition,'company_office');
                $responseArray['success']   = 1;
               
            }else{
                $responseArray['success']   = 0;
            }
            $responseArray['status'] = 1;
        }else{
            $responseArray['status'] = 0;
            $responseArray['msg'] = $this->error_message['100'];
        }
        echo json_encode($responseArray);
    }

    function setUserStatus(){
        $responseArray   = array();
        if($this->cmn->checkLoginSessionAjax()){
            $companyId = $this->input->post('user');
            $status     = $this->input->post('status');
            if($companyId){
                if($status == 1){
                    $dataArr    = array('status' => 0);
                     $responseArray['companyStatus']    = 0;
                }else{
                    $dataArr    = array('status' => 1);
                     $responseArray['companyStatus']    = 1;
                }
                $condition  = array('user_id'    => $companyId);
                $this->cmn->update($dataArr,$condition,'user');
                $responseArray['success']   = 1;
               
            }else{
                $responseArray['success']   = 0;
            }
            $responseArray['status'] = 1;
        }else{
            $responseArray['status'] = 0;
            $responseArray['msg'] = $this->error_message['100'];
        }
        echo json_encode($responseArray);
    }

    function setRegionStatus(){
        $responseArray   = array();
        if($this->cmn->checkLoginSessionAjax()){
            $regionId = $this->input->post('regionid');
            $status     = $this->input->post('status');
            if($regionId){
                if($status == 1){
                    $dataArr    = array('is_published' => 0);
                     $responseArray['regionStatus']    = 0;
                }else{
                    $dataArr    = array('is_published' => 1);
                     $responseArray['regionStatus']    = 1;
                }
                $condition  = array('region_id'    => $regionId);
                $this->cmn->update($dataArr,$condition,'region');
                $responseArray['success']   = 1;
               
            }else{
                $responseArray['success']   = 0;
            }
            $responseArray['status'] = 1;
        }else{
            $responseArray['status'] = 0;
            $responseArray['msg'] = $this->error_message['100'];
        }
        echo json_encode($responseArray);
    }

    function setBranchStatus(){
        $responseArray   = array();
        if($this->cmn->checkLoginSessionAjax()){
            $branchId = $this->input->post('branch');
            $status     = $this->input->post('status');
            if($branchId){
                if($status == 1){
                    $dataArr    = array('is_published' => 0);
                     $responseArray['branchStatus']    = 0;
                }else{
                    $dataArr    = array('is_published' => 1);
                     $responseArray['branchStatus']    = 1;
                }
                $condition  = array('branch_id'    => $branchId);
                $this->cmn->update($dataArr,$condition,'branch');
                $responseArray['success']   = 1;
               
            }else{
                $responseArray['success']   = 0;
            }
            $responseArray['status'] = 1;
        }else{
            $responseArray['status'] = 0;
            $responseArray['msg'] = $this->error_message['100'];
        }
        echo json_encode($responseArray);
    }

    function setGuardStatus(){
        $responseArray   = array();
        if($this->cmn->checkLoginSessionAjax()){
            $guardId = $this->input->post('guard');
            $status     = $this->input->post('status');
            if($guardId){
                if($status == 1){
                    $dataArr    = array('status' => 0);
                     $responseArray['guardStatus']   = 0;
                }else{
                    $dataArr    = array('status' => 1);
                     $responseArray['guardStatus']   = 1;
                }
                $condition  = array('guard_id'   => $guardId);
                $this->cmn->update($dataArr,$condition,'guard');
                $responseArray['success']   = 1;
               
            }else{
                $responseArray['success']   = 0;
            }
            $responseArray['status'] = 1;
        }else{
            $responseArray['status'] = 0;
            $responseArray['msg'] = $this->error_message['100'];
        }
        echo json_encode($responseArray);
    }
    
    function setCompanySession(){
        $responseArray   = array();
        if($this->cmn->checkLoginSessionAjax()){
            $companyId = $this->input->post('company');
            $companyData    = $this->cm->getCompanyDetailsByCompId($companyId);
            //print_r($companyData);
            $this->session->set_userdata('session_company_id', intval($companyId));
            $this->session->unset_userdata('session_company_logo');
            $companyLogoUrl = $this->config->item('company_profile_images');
            if(isset($companyData->company_logo_url)&&!empty($companyData->company_logo_url)){
                $this->session->set_userdata('session_company_logo', site_url($companyLogoUrl.'/'.$companyData->company_logo_url));
            }
            $responseArray['success']   = 1;
            $responseArray['status'] = 1;
        }else{
            $responseArray['status'] = 0;
            $responseArray['msg'] = $this->error_message['100'];
        }
        echo json_encode($responseArray);
    }
    
    function addNewLanguage()
    {
        $response = array('message'=>'Request Failed','status'=>'0');
    	if(isset($_REQUEST['new_language_name']))
    	{
            $userInfo = $this->um->getUserSession();
            if($userInfo)
            {
                    $dataArr =array('language_name'=>$_REQUEST['new_language_name']);
                    $insertedLanguage = $this->cmm->insert($dataArr,'languages');
                    $response = array('message'=>'','status'=>'1','languageId'=>$insertedLanguage);
            }
    	}
    	echo json_encode($response);
    }
    
    function getLatLongForSiteByAddress(){
        $responseArray   = array();
        if($this->cmn->checkLoginSessionAjax()){
            $country    = $this->input->post('country');
            $city       = $this->input->post('city');
            $state      = $this->input->post('state');
            $zip        = $this->input->post('zip');
            $address    = $this->input->post('address');
            $testAdress = trim($address.' '.$zip.' '.$city.' '.$state.' '.$country);
            //echo $testAdress;die;
            if($testAdress != ''){
                $latlongArr = $this->cmm->getLatLongByAddress($testAdress);
                $lat    = 0;
                $long   = 0;
                if(!empty($latlongArr)){
                     $lat    = $latlongArr[0];
                     $long   = $latlongArr[1];
                }
            }
            $responseArray['lat']       = $lat;
            $responseArray['long']      = $long;
            $responseArray['status']    = 1;
        }else{
            $responseArray['status']    = 0;
            $responseArray['msg']       = $this->error_message['100'];
        }
        echo json_encode($responseArray);
    }
    
    function drawPolyline(){
         if($this->cmn->checkLoginSessionAjax()){
            $origin     = $this->input->post('origin');
            $destination= $this->input->post('destination');
            
            $url     = $this->config->item('gMapDirectionMaxKmsUrl');
            $url    .= $this->config->item('output').'?';
            $url    .= 'origin='.$origin;
            $url    .= '&destination='.$destination;
            $url    .= '&alternatives=true&units=metric';            
            
            $response   = file_get_contents($url);
            $distanceArr    = array();              
            $distanceData   = array();
            $stepsArray     = array();
            $response       = json_decode($response);
            $stepResponse   = array();
            $startLocation  = array();
            $endLoctaion    = array();
            $startAddress   = array();
            $endAddress     = array();
            if(!empty($response)){
                if($response->status == 'OK'){
                    for($i=0;$i<count($response->routes);$i++)
                    {   
                        $distanceArr = explode(' ', $response->routes[$i]->legs[0]->distance->text);  
                        $greaterD = '';
                        if(count($distanceArr) == 2)
                        {
                            if($distanceArr[1] == 'm'){                                
                                $distance =(floatval($distanceArr[0])/1000);                                                          
                                $greaterD = floatval($distance);
                            }elseif($distanceArr[1] == 'km'){                                
                                $greaterD = floatval($distanceArr[0]);
                            }else{                                
                                $distance =(floatval($distanceArr[0])/0.62137);
                                $greaterD = floatval($distance);
                            }

                        }   
                        $distanceData[$i]   = $greaterD;
                        $stepsArray[$i]     = $response->routes[$i]->legs[0]->steps;
                        $startLocation[$i]  = $response->routes[$i]->legs[0]->start_location;
                        $endLoctaion[$i]    = $response->routes[$i]->legs[0]->end_location;
                        $startAddress[$i]   = $response->routes[$i]->legs[0]->start_address;
                        $endAddress[$i]     = $response->routes[$i]->legs[0]->end_address;
                    }
                }
            }
            if(count($distanceData)>0){
                $key            = array_search(max($distanceData),$distanceData) ;
                $stepResponse   = $stepsArray[$key];
                $startLocRes    = $startLocation[$key];
                $endLocRes      = $endLoctaion[$key];
                $startAddRes    = $startAddress[$key];
                $endAddRes      = $endAddress[$key];
            } 
            //print_r($startLocRes);
            //print_r($endLocRes);
            $responseArray['status']        = 1;
            $responseArray['steps']         = $stepResponse;
            $responseArray['start_loaction1']= $startLocRes;
            $responseArray['end_location1']  = $endLocRes;
            $responseArray['start_address']= $startAddRes;
            $responseArray['end_address']  = $endAddRes;
        }else{
            $responseArray['status']    = 0;
            $responseArray['msg']       = $this->error_message['100'];
        }
        echo json_encode($responseArray);
            
    }
    
}