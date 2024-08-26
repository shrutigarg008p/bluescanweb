<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Region extends CI_Controller
{
    public $user;
    function  __construct(){
        parent::__construct();
        $this->user =   unserialize($this->session->userdata('users'));
        $this->qc = $this->queryconstant;
        $this->load->model('usermanager');
        $this->load->model('companymanager');
        $this->load->model('commonmanager');
        $this->load->model('regionmanager');
        $this->um  = $this->usermanager;
        $this->cm  = $this->companymanager;
        $this->cmm = $this->commonmanager;
        $this->rm  = $this->regionmanager;
        $this->qc  = $this->queryconstant;
        session_start();
        $this->um->checkLoginSession();
        $this->load->library('paginator');
    }

    

/*START FUNCTIONS FOR REGION ADD/EDIT LIST */
    function index(){
        $user_id  = $this->user->user_id;
        $companyId = $this->user->company_id;
        $where  = '';
        if(in_array($this->user->role_code, array('sadmin'))){
            $companyId  =  $this->session->userdata('session_company_id');
            $where = 'WHERE c.company_id = '.$companyId;
        }else if(in_array($this->user->role_code, array('cadmin','cuser'))){
            $where = 'WHERE c.company_id = '.$companyId;
        }else if(in_array($this->user->role_code, array('RM'))){
            $where = 'WHERE u.user_id = '.$user_id ;
        }        
        $cur_page = $this->input->post('page') ? $this->input->post('page') : 1;
        $perPage  = $this->config->item('perPage');
        $vars['perPage']   = $perPage;
        $vars['page']      = $cur_page;
        $offset = ($cur_page*$perPage)-$perPage;
        $count  = $this->rm->getAllRegionPageList($where,$this->user->role_code,$offset,$perPage,true);
        $vars['total_record']   = $count;
        $pages  = new paginator($count, $perPage, $cur_page);
        $vars['pagination'] = $pages;

        $regionData         =   $this->rm->getAllRegionPageList($where,$this->user->role_code,$offset,$perPage,false);
        /*$vars['companyData']=   $this->cm->getAllCompanyList();
        $vars['userData']   =   $this->um->getAllUserList();*/
        $vars['regionData'] =   $regionData;
        $vars['title']      =   'Region List';
        $vars['contentView']=   'region_list';      
        $vars['mainTab']    = "company";
        $this->load->view('inner_template', $vars);
    }
    
    function addEditRegion()
    {
        //''
        $head = 'Add';
        $regionId   = '';
        $companyId  = '';
        $userId     = '';
        $address    = '';
        $zipcode    = '';
        $city       = '';
        $contact_number = '';
        $email      = '';
        $enteredby  = '';
        $region_name = '';
        $system_id = '';
        $is_published = 1;
        $regionId   = base64_decode($this->uri->segment(3));
        
        if(in_array($this->user->role_code, array('sadmin','cadmin','cuser'))){
            $companyId  = $this->session->userdata('session_company_id');

        }
        if(isset($regionId)&&!empty($regionId))
        {
            $head = 'Edit';
            $regionData = $this->rm->getRegionDetailsByRegId($regionId);
            //$companyData   = $this->cm->getCompanyDetailsByCompId($companyId);
            $companyId  = $regionData->company_id;
            $userId     = $regionData->user_id;
            $address    = $regionData->address;
            $zipcode    = $regionData->zipcode;
            $city       = $regionData->city;
            $contact_number = $regionData->contact_number;
            $email      = $regionData->email_id;
            $region_name = $regionData->region_name;
            $is_published = $regionData->is_published;
            $system_id = $regionData->system_id;
        }
        
        if($this->input->post())
        {
            if($this->input->post('company_name')){
                $companyId  =   trim($this->input->post('company_name'));
            }
            /*
            if($this->input->post('user_name')){
                $userId     =   trim($this->input->post('user_name'));
            } */
            if($this->input->post('address')){
                $address    =   trim($this->input->post('address'));
            }
            if($this->input->post('city')){
                $city       =   trim($this->input->post('city'));
            }
            if($this->input->post('email')){
                $email      =   trim($this->input->post('email'));
            }
            if($this->input->post('system_id')){
                $system_id      =   trim($this->input->post('system_id'));
            }
            if($this->input->post('contact_number')){
                $contact_number =   trim($this->input->post('contact_number'));
            }
            if($this->input->post('zipcode')){
                $zipcode    =   trim($this->input->post('zipcode'));
            }
            if($this->input->post('region_name')){
                $region_name    =   trim($this->input->post('region_name'));
            }
            
            if($this->_validation_region() == TRUE){
                $dataArr    = array(
                                'company_id'    => $companyId,
                                'user_id'       => $this->user->user_id,
                                'address'       => $address,
                                'zipcode'       => $zipcode,
                                'city'          => $city,
                                'contact_number'=> $contact_number,
                                'email_id'      => $email,
                                'is_published'  => $is_published,
                                'system_id'  => $system_id,
                                'region_name'   => $region_name
                );
                if(isset($regionId) && !empty($regionId)){
                        log_message('info', 'Update Region data : '.print_r($dataArr,true));
                        $condition  = array('region_id' => $regionId);
                        $this->cmm->update($dataArr,$condition,'region');
                        $this->session->set_flashdata('successMessage', 'Region updated successfully.');
                        redirect("region");
                }else{
                        log_message('info', 'Insert Region data : '.print_r($dataArr,true));
                        $this->cmm->insert($dataArr,'region');
                        $this->session->set_flashdata('successMessage', 'Region added successfully.');
                        redirect("region");
                }
            }
        }
        //$vars['licenseData'] = $this->cm->getAllCompanyLicenseList($companyId);
        $vars['company_id']     = $companyId;
        $vars['company_ids']    = $this->cm->getAllCompanyList();
        $vars['user_id']        = $userId;
        $vars['user_ids']       = $this->um->getAllUserList();
        $vars['address']        = $address;
        $vars['city']           = $city;        
        $vars['email']          = $email;                
        $vars['contact_number'] = $contact_number;        
        $vars['zipcode']        = $zipcode;
        $vars['region_name']    = $region_name;
        $vars['system_id']    = $system_id;
        $vars['title']          = $head.' Region';
        $vars['pageHeading']    = $head.' Region';
        $vars['contentView']    = 'add_edit_region';
        $vars['mainTab']    = "company";
        $this->load->view('inner_template', $vars);
    }

    function _validation_region(){
         if(!in_array($this->user->role_code, array('sadmin','cadmin','cuser'))){
            $this->form_validation->set_rules('company_name','Company Name','trim|required');
         }
       // $this->form_validation->set_rules('user_name','User Name','trim|required');
        $this->form_validation->set_rules('address', 'Address','trim|required');
        //$this->form_validation->set_rules('system_id', 'System Id','trim|required');
        $this->form_validation->set_rules('region_name', 'Region Name','trim|required');
        $this->form_validation->set_rules('city','City','trim|required|alpha_space');                
        $this->form_validation->set_rules('contact_number','Contact Number','trim|required|numeric');
        $this->form_validation->set_rules('email','Email','trim|required|valid_email');
        $this->form_validation->set_rules('zipcode','ZipCode','trim');
        $this->form_validation->set_error_delimiters('<span class="error">','</span>');
        return $this->form_validation->run();
    }

/*END FUNCTIONS FOR COMPANIES ADD/EDIT LIST */
}