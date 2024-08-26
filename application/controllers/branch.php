<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Branch extends CI_Controller
{
    public $user;
    function  __construct(){
        parent::__construct();
        $this->user =   unserialize($this->session->userdata('users'));
        $this->qc = $this->queryconstant;
        $this->load->model('usermanager');
        $this->load->model('regionmanager');
        $this->load->model('branchmanager');
        $this->load->model('commonmanager');
        $this->load->model('companymanager');
        $this->um  = $this->usermanager;
        $this->rm  = $this->regionmanager;
        $this->bm = $this->branchmanager;
        $this->cmn = $this->commonmanager;
        $this->cmm = $this->commonmanager;
        $this->cm = $this->companymanager;
        $this->qc = $this->queryconstant;
        session_start();
        $this->um->checkLoginSession();
        $this->load->library('paginator');
    }


/*START FUNCTIONS FOR BRANCHES ADD/EDIT LIST */
    function index(){  
        $regionId = '';
        $companyId = '';
        $where  = '';
        
        if($this->user->role_code == 'sadmin'){
           $companyId  =  $this->session->userdata('session_company_id');
        } else if(in_array($this->user->role_code, array('cadmin','cuser'))){
            $companyId  =  $this->user->company_id;
        } else{
            $where = 'WHERE u.user_id = '.$this->user->user_id;
        }

        // ------------Start filter query-----------
        if($this->input->post())
        {
            if($this->input->post('search_region_id')){
                $regionId = $this->input->post('search_region_id');
               
            }    
            if($this->input->post('search_company_id')){
                $companyId = $this->input->post('search_company_id');
                
            }    
        }
        
        if(isset($regionId) && !empty($regionId)){
            if(empty($where))
            {   $where = $where.' WHERE r.region_id = '.$regionId; }
            else
            {   $where = $where.' and r.region_id = '.$regionId; }
        }
        
        if(isset($companyId) && !empty($companyId)){
            if(empty($where))
            {   $where = $where.' WHERE r.company_id = '.$companyId; }
            else
            {   $where = $where.' and r.company_id = '.$companyId; }
        }
        
        // ------------End filter query-----------


        $cur_page = $this->input->post('page') ? $this->input->post('page') : 1;
        $perPage  = $this->config->item('perPage');
        $vars['perPage']   = $perPage;
        $vars['page']      = $cur_page;
        $offset = ($cur_page*$perPage)-$perPage;
        $count  = $this->bm->getAllBranchPageList($where,$this->user->role_code,$offset,$perPage,true);
        $vars['total_record']   = $count;
        $pages  = new paginator($count, $perPage, $cur_page);
        $vars['pagination'] = $pages;

        $branchData        = $this->bm->getAllBranchPageList($where,$this->user->role_code,$offset,$perPage,false);
        $vars['regionDropDown'] = $this->rm->getAllRegionList($companyId,$this->user->user_id,$this->user->role_code);
        $vars['companyDropDown'] = $this->cm->getAllCompanyList($companyId,$this->user->user_id,$this->user->role_code);
        
        $vars['branchData']= $branchData;
        $vars['f_region_id']= $regionId;
        $vars['f_company_id']= $companyId;
        $vars['title']      = 'Branch List';
        $vars['contentView']= 'branch_list';
        $vars['mainTab']    = "company";
        $this->load->view('inner_template', $vars);
    }
    
    
    function addEditBranch()
    {
        $head = 'Add';
        $branch_name = '';
        $branchId   = '';
        $regionId   = '';
        $createdbyId = $this->user->user_id;
        $address    = '';
        $zipcode    = '';
        $city       = '';
        $contact_number = '';
        $email      = '';
        $is_published = '';
        $system_id = '';
        $reg_company_id = '';
        $branchId   = base64_decode($this->uri->segment(3));
        $companyId  = $this->user->company_id;
        if(isset($branchId)&&!empty($branchId))
        {
            $head = 'Edit';
            $branchData = $this->bm->getBranchDetailsByBId($branchId);
            $reg_company_id = $branchData->company_id;
            $regionId   = $branchData->region_id;
            $createdbyId     = $branchData->user_id;
            $branch_name = $branchData->branch_name;
            $address    = $branchData->address;
            $zipcode    = $branchData->zipcode;
            $system_id    = $branchData->system_id;
            $city       = $branchData->city;
            $contact_number = $branchData->contact_number;
            $email      = $branchData->email_id;
            $is_published = $branchData->is_published;
        }

        if($this->input->post())
        {
            if($this->input->post('region_area')){
                $regionId    =   trim($this->input->post('region_area'));
            }
            if($this->input->post('branch_name')){
                $branch_name    =   trim($this->input->post('branch_name'));
            }
            if($this->input->post('system_id')){
                $system_id    =   trim($this->input->post('system_id'));
            }
            if($this->input->post('address')){
                $address        =   trim($this->input->post('address'));
            }
            if($this->input->post('city')){
                $city           =   trim($this->input->post('city'));
            }
            if($this->input->post('email')){
                $email          =   trim($this->input->post('email'));
            }
            if($this->input->post('contact_number')){
                $contact_number =   trim($this->input->post('contact_number'));
            }
            if($this->input->post('zipcode')){
                $zipcode    =   trim($this->input->post('zipcode'));
            }
            
            if($this->_validation_branch() == TRUE){
                $dataArr    = array('region_id' => $regionId,
                                'user_id'       => $createdbyId,
                                'branch_name'	=> $branch_name,
                                'address'       => $address,
                                'zipcode'       => $zipcode,
                                'city'          => $city,
                                'contact_number'=> $contact_number,
                                'email_id'      => $email,
                                'system_id'      => $system_id,
                                'is_published'  => $is_published
                );
                if(isset($branchId) && !empty($branchId)){
                        log_message('info', 'Update Branch data : '.print_r($dataArr,true));
                        $condition  = array('branch_id'    => $branchId);
                        $this->cmn->update($dataArr,$condition,'branch');
                        $this->session->set_flashdata('successMessage', 'Branch updated successfully.');
                        //redirect("project/addEditProject/".base64_encode($projectId));
                        redirect("branch");
                }else{
                        log_message('info', 'Insert Branch data : '.print_r($dataArr,true));
                        $this->cmn->insert($dataArr,'branch');
                        $this->session->set_flashdata('successMessage', 'Branch added successfully.');
                        redirect("branch");
                }
            }
        }

        $vars['region_area']    = $regionId;

        $companyId  = '';
        if($this->user->role_code == 'sadmin'||$this->user->role_code == 'cadmin'||$this->user->role_code == 'cuser'){
             $companyId            = $this->session->userdata('session_company_id');
             $condition = 'WHERE cust.company_id = '.$companyId;
        }
        $vars['company_name']   = $this->cm->getAllCompanyList();
        $vars['region_areas']   = $this->rm->getAllRegionList($companyId,$this->user->user_id,$this->user->role_code);
        
        
        $vars['reg_company_id'] = $companyId;
        //$vars['user_name']      = $userId;
        $vars['branch_name']    = $branch_name;
        $vars['user_names']     = $this->um->getAllUserList($companyId);

        $vars['address']        = $address;
        $vars['zipcode']        = $zipcode;
        $vars['city']           = $city;
        $vars['system_id']           = $system_id;
        $vars['contact_number'] = $contact_number;
        $vars['email']          = $email;
        $vars['title']          = $head.' Branch';
        $vars['pageHeading']    = $head.' Branch';
        $vars['contentView']    = 'add_edit_branch';
        $vars['mainTab']    = "company";
        $this->load->view('inner_template', $vars);
    }

    function _validation_branch(){
        $this->form_validation->set_rules('region_area','Region area','trim|required');
        $this->form_validation->set_rules('branch_name', 'Branch name','trim|required');
        $this->form_validation->set_rules('city','City','trim|required|alpha_space');
        $this->form_validation->set_rules('address', 'Address','trim|required');
        $this->form_validation->set_rules('contact_number','Contact Number','trim|required|numeric');
        $this->form_validation->set_rules('email','Email','trim|required|valid_email');        
        $this->form_validation->set_rules('zipcode','ZipCode','trim');
        $this->form_validation->set_error_delimiters('<span class="error">','</span>');
        return $this->form_validation->run();
    }
/*END FUNCTIONS FOR BRANCHES ADD/EDIT LIST */
}