<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Question extends CI_Controller
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
        $this->um  = $this->usermanager;
        $this->cm = $this->companymanager;
        $this->cmn = $this->commonmanager;
        $this->que = $this->questionmanager;
        $this->qc = $this->queryconstant;
        session_start();
        $this->um->checkLoginSession();
        if($this->user->role_code == 'sadmin'){
             $vars['companySessionData'] =  $this->cm->getAllCompanyList();
        }
        $this->load->library('paginator');
    }
    
    function index(){
        redirect('question/questionList');
    }
    
    function questionList(){
        $companyId  = base64_decode($this->uri->segment(3));
        $companyData    = $this->cm->getCompanyDetailsByCompId($companyId);
        $vars['companyId']    = $companyData->company_id;
        $vars['companyName']    = $companyData->company_name;
        $cur_page = $this->input->post('page') ? $this->input->post('page') : 1; 
        $perPage  = $this->config->item('perPage');
        $vars['perPage']   = $perPage;
        $vars['page']      = $cur_page;
        $offset = ($cur_page*$perPage)-$perPage;
        $count  = $this->que->getAllQuestionList($companyId,$offset,$perPage,true);
        $vars['total_record']   = $count;
        $pages  = new paginator($count, $perPage, $cur_page);
        $vars['pagination'] = $pages;
        $vars['questionData']= $this->que->getAllQuestionList($companyId,$offset,$perPage,false);
        $vars['title']      = 'Question List';
        $vars['contentView']= 'question_list';
        
        $this->load->view('inner_template', $vars);
    }
    
    function addEditQuestion(){
        $companyId  = base64_decode($this->uri->segment(3));
        $companyData    = $this->cm->getCompanyDetailsByCompId($companyId);
        $vars['companyName']    = $companyData->company_name;
        $questionId  = base64_decode($this->uri->segment(4));
        $head = 'Add';
        $question       = '';
        $questionType   = '';
        $is_mandatory   = '';
        //$sequence       = '';
        $question_option= '';
        $is_published   = 1;
        $remark    = '';
        if(isset($questionId)&&!empty($questionId)){
            $head = 'Edit';
            $questionData   = $this->que->getQuestionIdDetailsByQuestionIdId($questionId);
            $question       = $questionData->question;
            $questionType   = $questionData->question_type;
            $question_option= $questionData->question_option;
            //$sequence       = $questionData->sequence;
            $is_mandatory   = $questionData->is_mandatory;
            $remark         = $questionData->remark;
            $is_published   = $questionData->is_published;
        }
        
        if($this->input->post())
        {
            if($this->input->post('question')){
                $question    =	trim($this->input->post('question'));
            }
            if($this->input->post('question_type')){
                $questionType	=	trim($this->input->post('question_type'));
            }
            if($this->input->post('remark')){
                $remark           =	trim($this->input->post('remark'));
            }
            if($this->input->post('is_mandatory')){
                $is_mandatory	=	trim($this->input->post('is_mandatory'));
            }
            /*if($this->input->post('sequence')){
                $sequence          =	trim($this->input->post('sequence'));
            }*/
            if($this->input->post('question_option')){
                $question_option   =  trim($this->input->post('question_option'));
            }
            else
            {
                $question_option = null;
            }
            
            
            if($this->_validation_question() == TRUE){
                $dataArr	= array('question'  => $question,
                                'question_type'     => $questionType,
                                'remark'            => $remark,
                                'is_mandatory'      => $is_mandatory,
                               // 'sequence'          => $sequence,
                                'question_option'   => $question_option,
                                'company_id'        => $companyId,
                                'is_published'        => $is_published
                );
                if(isset($questionId) && !empty($questionId)){
                        log_message('info', 'Update Question data : '.print_r($dataArr,true));
                        $condition	= array('question_id'	=> $questionId);
                        $this->cmn->update($dataArr,$condition,'question');
                        $this->session->set_flashdata('successMessage', 'Question updated successfully.');
                        //redirect("project/addEditProject/".base64_encode($projectId));
                        redirect("question/questionList/".base64_encode($companyId));
                }else{
                        log_message('info', 'Insert Question data : '.print_r($dataArr,true));
                        $this->cmn->insert($dataArr,'question');
                        $this->session->set_flashdata('successMessage', 'Question added successfully.');
                        redirect("question/questionList/".base64_encode($companyId));
                }
            }
        }
        
        $vars['questionTypeArray'] = $this->config->item('questionTypeArray');
        $vars['question']       = $question;
        $vars['questionType']   = $questionType;
        $vars['remark']         = $remark;
        $vars['is_mandatory']   = $is_mandatory;
        //$vars['sequence']       = $sequence;
        $vars['question_option']= $question_option;
        $vars['title']      = $head.' Question';
        $vars['pageHeading']= $head.' Question';
        $vars['contentView']= 'add_edit_question';
        $this->load->view('inner_template', $vars);  
    }
    
    
    function _validation_question(){
        $this->form_validation->set_rules('question','Question','trim|required');
        $this->form_validation->set_rules('is_mandatory', 'Is Mandatory','trim|required');
        if($this->input->post('question_type') == '2'){
            $this->form_validation->set_rules('question_option','Question Option','trim|required');
        }
       // $this->form_validation->set_rules('sequence','Sequence','trim|required');
        $this->form_validation->set_rules('question_type','Question Type','trim|required');
        $this->form_validation->set_rules('remark','Remark','trim|required');
        $this->form_validation->set_error_delimiters('<span class="error">','</span>');
        return $this->form_validation->run();
    }
    
    function questionGroupList(){
        $companyId  = base64_decode($this->uri->segment(3));
        $companyData    = $this->cm->getCompanyDetailsByCompId($companyId);
        $vars['companyId']    = $companyData->company_id;
        $vars['companyName']    = $companyData->company_name;
        $cur_page = $this->input->post('page') ? $this->input->post('page') : 1; 
        $perPage  = $this->config->item('perPage');
        $vars['perPage']   = $perPage;
        $vars['page']      = $cur_page;
        $offset = ($cur_page*$perPage)-$perPage;
        $count  = $this->que->getAllQuestionGroupList($companyId,$offset,$perPage,true);
        $vars['total_record']   = $count;
        $pages  = new paginator($count, $perPage, $cur_page);
        $vars['pagination'] = $pages;
        $vars['questionData']= $this->que->getAllQuestionGroupList($companyId,$offset,$perPage,false);
        $vars['title']      = 'Question Group List';
        $vars['contentView']= 'question_group_list';
        $this->load->view('inner_template', $vars);
    }
    
    function addEditQuestionGroup(){
        $companyId  = base64_decode($this->uri->segment(3));
        $companyData    = $this->cm->getCompanyDetailsByCompId($companyId);
        $vars['companyName']    = $companyData->company_name;
        $groupId  = base64_decode($this->uri->segment(4));
        $head = 'Add';
        $questionArrId  = '';
        $groupName      = '';
        $description    = '';
        $is_published   = 1;
        $groupQuestionData  = array();
       if(isset($groupId)&&!empty($groupId)){
            $head = 'Edit';
            $groupData   = $this->que->getGroupDataByGroupId($groupId);
            $groupQuestionData   = $this->que->getGroupQuestByGroupId($groupId);
            $question_ids   = $groupData->group_id;
            $groupName      = $groupData->group_name;
            $description    = $groupData->description;
            $is_published   = $groupData->is_published;
        }
        
        if($this->input->post())
        {
            if($this->input->post('group_name')){
                $groupName    =	trim($this->input->post('group_name'));
            }
            if($this->input->post('description')){
                $description	=	trim($this->input->post('description'));
            }
            
            if($this->_validation_group() == TRUE){
                $dataArr	= array('group_name'=> $groupName,
                                'description'       => $description,
                                'is_published'      => $is_published,
                                'company_id'        => $companyId
                );
                if(isset($groupId) && !empty($groupId)){
                        log_message('info', 'Update Group data : '.print_r($dataArr,true));
                        $condition	= array('group_id'	=> $groupId);
                        $this->cmn->update($dataArr,$condition,'group');
                        $this->session->set_flashdata('successMessage', 'Question Group updated successfully.');
                        //redirect("project/addEditProject/".base64_encode($projectId));
                        redirect("question/addEditQuestionGroup/".base64_encode($companyId).'/'.base64_encode($groupId));
                }else{
                        log_message('info', 'Insert Question Group data : '.print_r($dataArr,true));
                        $groupId = $this->cmn->insert($dataArr,'group');
                        $this->session->set_flashdata('successMessage', 'Question Group added successfully.');
                        redirect("question/addEditQuestionGroup/".base64_encode($companyId).'/'.base64_encode($groupId));
                }
            }
        }
        
        $vars['questionData']   = $this->que->getQuestionByCompanyId($companyId,$groupId);
        $vars['groupQuestionData']   = $groupQuestionData;
        $vars['group_name']     = $groupName;
        $vars['groupId']        = $groupId;
        $vars['description']    = $description;
        $vars['title']      = $head.' Group';
        $vars['pageHeading']= $head.' Group';
        $vars['contentView']= 'add_edit_group';
        $this->load->view('inner_template', $vars);
    }
    
    function _validation_group(){
        $this->form_validation->set_rules('group_name','Group Name','trim|required');
        $this->form_validation->set_error_delimiters('<span class="error">','</span>');
        return $this->form_validation->run();
    }
}