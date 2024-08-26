<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Inspection extends CI_Controller
{
    public $um;
    public $cmm;
    public $qc;
    public $sm;
    public $ins;
    public $cm;
    public $user;
            
    function  __construct(){
        parent::__construct();
         $this->user =	unserialize($this->session->userdata('users'));
        $this->qc = $this->queryconstant;
        $this->load->model('usermanager');
        $this->load->model('commonmanager');
        $this->load->model('guardmanager');
        $this->load->model('inspectionmanager');
        $this->um   = $this->usermanager;
        $this->cmm  = $this->commonmanager;
        $this->gm  = $this->guardmanager;
        $this->qc   = $this->queryconstant;
        $this->ins  = $this->inspectionmanager;
         $this->load->model('companymanager');
         $this->cm  = $this->companymanager;
    }
    
    function index(){        
        redirect('inspection/inspectionList');
    }
            
    function saveInspectionDetails(){
        if(!isset($request['site_id']) || trim($request['site_id'])==''){
                $this->response = array('responseCode'=>117,'responseData'=>$this->response_message['117']);
                $this->cmm->print_log('saveInspectionDetails','Missing Response => '.json_encode($this->response));
                return $this->response;
        }
        if(!isset($request['guard_id']) || trim($request['guard_id'])==''){
                $this->response = array('responseCode'=>120,'responseData'=>$this->response_message['120']);
                $this->cmm->print_log('saveInspectionDetails','Missing Response => '.json_encode($this->response));
                return $this->response;
        }
        if(!isset($request['user_id']) || trim($request['user_id'])==''){
                $this->response = array('responseCode'=>116,'responseData'=>$this->response_message['116']);
                $this->cmm->print_log('saveInspectionDetails','Missing Response => '.json_encode($this->response));
                return $this->response;
        }
        if(!isset($request['question_data']) || trim($request['question_data'])==''){
                $this->response = array('responseCode'=>121,'responseData'=>$this->response_message['121']);
                $this->cmm->print_log('saveInspectionDetails','Missing Response => '.json_encode($this->response));
                return $this->response;
        }else{
           $questionArr = json_decode($request['question_data']);
           if(!empty($questionArr)){
              
           }
        }
    }
    
    function inspectionList(){
        $userId     = '';
        $guardId    = '';

        $this->um->checkLoginSession();
        $this->load->library('paginator');
        $cur_page = $this->input->post('page') ? $this->input->post('page') : 1;
        $perPage  = $this->config->item('perPage');
        $vars['perPage']   = $perPage;
        $vars['page']      = $cur_page;
        $offset = ($cur_page*$perPage)-$perPage;

        if($this->input->post())
        {
        	if($this->input->post('user_id'))
        	{
        		$userId    =   trim($this->input->post('user_id'));
        	}
        	if($this->input->post('guard_id'))
        	{
        		$guardId   =   trim($this->input->post('guard_id'));
        	}
        }       

        //count        
        $count  = $this->ins->getAllInspectionListWithFilter($userId, $guardId,$offset,$perPage,true);
        $vars['total_record']   = $count;
        $pages  = new paginator($count, $perPage, $cur_page);
        $vars['pagination'] = $pages;             
        
        //query
        $inspectionData    = $this->ins->getAllInspectionListWithFilter($userId,$guardId,$offset,$perPage,false);
        $vars['userid']   = $userId;
        $vars['guardid']  = $guardId;
        $vars['siteData']  = $inspectionData;
        $vars['userData']  = $inspectionData;
        $vars['inspectionData']= $inspectionData;
        $vars['userDropDown']  = $this->um->getAllUserList();
        $vars['guardDropDown'] = $this->gm->getAllGuardList();
        $vars['title']      = 'Inspection List';
        $vars['contentView']= 'inspection_list';
        $this->load->view('inner_template', $vars);        
    }

    function inspectionDetail()
    {
        $instanceId          = base64_decode($this->uri->segment(3));        
        $inspectionData      = $this->ins->getInspectionDataById($instanceId);
        $siteId             = $inspectionData->site_id;
        $vars['questionData'] = $this->ins->getInspectionQuestionDataById($siteId);
        $vars['inspectData'] = $inspectionData;
        $vars['title']       = 'Inspection Detail';
        $vars['contentView'] = 'inspection_detail_list';
        $this->load->view('inner_template', $vars);
    }
}