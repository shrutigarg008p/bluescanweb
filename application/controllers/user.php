<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class User extends CI_Controller
{
	public $user;
        public $cmm;
        public $cm;
        public $rm;
        public $bm;
        public $sm;
         public $cust;
        public $response='';
        public $tasks='';
	function  __construct(){
            parent::__construct();
            $this->user =	unserialize($this->session->userdata('users'));
            //echo "<pre>";print_r($this->user);die;
            $this->tasks =	unserialize($this->session->userdata('tasks'));
            $this->qc = $this->queryconstant;
            $this->load->model('usermanager');
            $this->um  = $this->usermanager;
            $this->load->model('branchmanager');
            $this->bm  = $this->branchmanager;
            $this->load->model('sitemanager');
            $this->sm  = $this->sitemanager;
            $this->load->model('companymanager');
            $this->cm  = $this->companymanager;
            $this->load->model('regionmanager');
            $this->rm  = $this->regionmanager;
            $this->load->model('customermanager');
            $this->cust  = $this->customermanager;
            $this->load->model('commonmanager');
            $this->cmm  = $this->commonmanager;
            $this->response_message = $this->config->item('service_responce_message'); 
            session_start();
            //$this->um->checkLoginSession();
            $this->load->library('paginator');
	}
	function index(){
           // print_r($this->session->all_userdata());
            log_message('info', "user session data".  print_r($this->user,true));
            if(!empty($this->user)){
                //$this->session->keep_flashdata('firstTimeLogin');die;
                if($this->uri->segment(3) == 1){
                 $this->session->set_flashdata('firstTimeLogin','firsttime');
                }
                if($this->user->role_code == 'sadmin'){  
                    
                    redirect('company');
                }else{
                    redirect('user/dashboard');
                }

            }            
            $vars['title'] = 'Login';
            $this->load->view('login', $vars);
	}
	
	function logout() {
		if($this->session->userdata('users')){
                    $this->session->sess_destroy();
                    $this->db->close();
		}
		redirect('user/login');
		die();
	}
	
	function login(){
		if(empty($this->user)){
                    if($this->_submit_validate() === FALSE) {
                        //echo 'login if';die;
                        $this->index();
                        log_message('info', "login if if condition");
                        return ;
                    }else{
                        log_message('info', "login if else condition");
                        redirect('user/index/1');
                    }
		}else{
                    //echo 'login else if';die;
                     log_message('info', "login  else condition");
                    redirect('user/dashboard');
		}
	}
	
	function _submit_validate(){
		$this->form_validation->set_rules('username', 'Username','trim|required|callback_authenticate_check');
		$this->form_validation->set_rules('password', 'Password','trim|required');
                 $this->form_validation->set_error_delimiters('<label class="loginerror">', '</label>');        
		return $this->form_validation->run();
	}
	
	function authenticate_check(){
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		$users = $this->um->checkUserLogin($username,md5($password));
                log_message('info', "Method Name : authenticate_check, Log Message :". print_r($users,true));
              // echo '<pre>';  print_r($users);die;
		if(!empty($users)){
                    if(($users->user_id > 0 && $users->status == 1 && $users->company_status == 1 )||($users->user_id > 0 && $users->status == 1 && $users->code == 'sadmin')){
                        $userData  = new stdClass();
                        $userData->user_id   = $users->user_id;
                        $userData->email     = $users->email;
                        $userData->name      = $users->name;
                        $userData->role_id   = $users->role_id;
                        $userData->user_tasks= $users->user_tasks;
                        $userData->company_id= $users->company_id;
                       
                        $userData->role_code = $users->code;
                        $userData->role_name = $users->role_name;
                        $userData->role_order = $users->role_order;
                        
                        $userData->region_ids = '';
                        $userData->branch_ids = '';
                        $userData->site_ids  = $users->site_ids;
                        if($userData->role_code == 'cadmin' || $userData->role_code == 'cuser'){
                            $companyData = $this->cm->getAllRegionBranchSiteDataByCompanyIds($users->company_id);
                            if(count($companyData)>0){
                                $userData->region_ids = $companyData->region_ids;
                                $userData->branch_ids = $companyData->branch_ids;
                                $userData->site_ids  = $companyData->site_ids;
                            }
                        }else if($userData->role_code == 'RM'){
                            $branchData = $this->bm->getAllBranchesSiteByRegionIds($users->region_ids);
                            $userData->region_ids = $users->region_ids;
                            if(count($branchData)>0){
                                $userData->branch_ids = $branchData->branch_ids;
                                $userData->site_ids   = $branchData->site_ids;
                            }
                        }else if($userData->role_code == 'BM'){
                            $userData->branch_ids = $users->branch_ids;
                            $siteData = $this->sm->getAllSiteByBranchIds($users->branch_ids);
                             if(count($siteData)>0){
                                $userData->site_ids   = $siteData->site_ids;
                            }
                        }
                        //print_r($users);die;
                        $this->session->set_userdata('session_company_id', $users->company_id);
                        if(isset($users->company_logo_url)&&!empty($users->company_logo_url)){
                            $companyLogoUrl = $this->config->item('company_profile_images');
                            $this->session->set_userdata('session_company_logo', site_url($companyLogoUrl.'/'.$users->company_logo_url));
                        }
                       // echo '<pre>'; print_r($users);
                       // echo '<pre>'; print_r($userData);die;
                        $this->session->set_userdata('users',serialize($userData));
                        $this->session->set_userdata('tasks',serialize(explode(',', $userData->user_tasks)));
                        $this->user = unserialize($this->session->userdata('users'));
                        log_message('info', "authenticate_check TRUE"); 
                        return TRUE;
                        
                    }
                    else{
                        $this->form_validation->set_message('authenticate_check','Your account is disabled.');
                        return FALSE;
                    }
		}
		else{
                    $this->form_validation->set_message('authenticate_check','Invalid login. Please try again.');
                    return FALSE;
		}
	}


    function dashboard(){
        $this->um->checkLoginSession();
        $companyId  = '';
        $start_date     = date('Y-m-d');
        $end_date       = '';
        $regionId       = '';
        $branchId       = '';
        $site_id        = '';
        $officer_id     = '';  
        $companyId = isset($this->user->company_id)?$this->user->company_id:'';
        $regionIds = isset($this->user->region_ids)?trim($this->user->region_ids,','):'';
        $branchIds = isset($this->user->branch_ids)?trim($this->user->branch_ids,','):'';
        $siteIds   = isset($this->user->site_ids)?trim($this->user->site_ids,','):'';
        if($this->user->role_code == 'sadmin'){
            $companyId  = $this->session->userdata('session_company_id');
            $companyData = $this->cm->getAllRegionBranchSiteDataByCompanyIds($companyId);
            $regionIds = trim($companyData->region_ids,',');
            $branchIds = trim($companyData->branch_ids,',');
            $siteIds   = trim($companyData->site_ids,',');
        }
        
        $where = '';
        if($companyId != ''){
            $where .= ' AND u.company_id = '.$companyId.' ';
        }
        $condition = array();
        if($regionIds != ''){
            $condition[] = '  ur.region_id IN ('.$regionIds.') ';
        }
        
        if($branchIds != ''){
            $condition[] = ' ur.branch_id IN ('.$branchIds.') ';
        }
        
        if($siteIds != ''){
             $condition[] = '  ur.site_id IN ('.$siteIds.') ';
        }
        $cond = '';
        $cond = implode(' OR ', $condition);
        if($cond != ''){
            $where .= ' AND ('.$cond.') ';
        }
        
        
        if($this->input->post()){            
            if($this->input->post('start_date')){
                $start_date     =   trim($this->input->post('start_date'));
            }
            if($this->input->post('end_date')){
                $end_date       =   trim($this->input->post('end_date'));
            }
            if($this->input->post('site_id')){
                $site_id        =   trim($this->input->post('site_id'));
            }
            if($this->input->post('officer_id')){
                $officer_id     =   trim($this->input->post('officer_id'));
            }           
            if($this->input->post('region_id')){
                $regionId   = trim($this->input->post('region_id'));
            }
            if($this->input->post('branch_id')){
                $branchId   = trim($this->input->post('branch_id'));
            }
        }
        
        if(!empty($start_date)){
            $where .= ' AND DATE(sv.visiting_time) = DATE('."'".$start_date."'".')';            
        }
        if(!empty($end_date)){
            $where .= ' AND DATE(sv.visiting_time) <= DATE('."'".$end_date."'".')';
        }
        if(!empty($site_id)){
            $where .= ' AND sv.site_id = '.$site_id.' ';                            
        }
        if(!empty($officer_id)){
            $where .= ' AND sv.user_id = '.$officer_id.' ';            
        }   
        if(!empty($branchId)){
            $where .= ' AND b.branch_id = '.$branchId.' ';            
        }
        if(!empty($regionId)){
             $where .= ' AND r.region_id = '.$regionId.' ';            
        } 
 
        $vars['inspInstData'] = $this->um->getInspInstDataByFilter($where);
        $vars['reasonArr'] = $this->config->item('reasonArr');
        
        $vars['getAllcompanyDropdown']  = $this->cm->getAllCompanyList($companyId,$this->user->user_id,$this->user->role_code);
        
        $vars['getAllRegionDropdown']   = $this->rm->getAllRegionList($companyId,$this->user->user_id,$this->user->role_code);
        $vars['getAllBranchDropdown']   = $this->bm->getAllBranchList($regionId,$companyId,$this->user->user_id,$this->user->role_code);
        $vars['getAllSiteDropdown']     = $this->sm->getAllSiteListDropdown($branchId,$companyId,$this->user->user_id,$this->user->role_code);
       
        
        $vars['company_id']  = $companyId;
        $vars['region_id']  = $regionId;
        $vars['branch_id']  = $branchId;
        $vars['site_id']  = $site_id;
        
        $vars['fieldOfficerData'] = $this->um->getAllFieldOfficers($siteIds,$companyId,$this->user->user_id,$this->user->role_code);///fieldOfficerId';        

        $vars['start_date'] = $start_date;
        $vars['end_date']   = $end_date;
        $vars['site_id']    = $site_id;
        $vars['officer_id'] = $officer_id;

        $vars['title']      = 'Dashboard';
        $vars['contentView']= 'dashboard';
        $this->load->view('inner_template', $vars);
    }

        /*START FUNCTIONS FOR USER ADD/EDIT LIST */

    function users()
    {
       //print_r($this->user);die;
        $this->um->checkLoginSession();
        //$this->cmm->checkSetSessionForRoleBasedSecurity();
        $f_user_role = '';
        $emp_comp_id = '';
        $login_user_role  = $this->user->role_order;
        $userId  = $this->user->user_id;
        $where = '';
        
        if($this->user->role_code == 'sadmin'){
            $companyId  =  $this->session->userdata('session_company_id');
        }else{
            $companyId = $this->user->company_id;
        }
        $condition = array();
        if($this->user->role_code == 'sadmin' || $this->user->role_code == 'cadmin' || $this->user->role_code == 'cuser'){
          $condition[] = ' u.company_id = '.$companyId;  
        }
        if($this->user->role_code == 'RM'){
            if(!empty($this->user->region_ids)){
                $condition[] = '  ur.region_id IN ('.$this->user->region_ids.') ';
            }
            if(!empty($this->user->branch_ids)){
                 $condition[] = '  ur.branch_id IN ('.$this->user->branch_ids.') ';
            }
            if(!empty($this->user->site_ids)){
                 $condition[] = '  ur.site_id IN ('.$this->user->site_ids.') ';
            }
        }
        if($this->user->role_code == 'BM'){
            if(!empty($this->user->branch_ids)){
                 $condition[] = '  ur.branch_id IN ('.$this->user->branch_ids.') ';
            }
            if(!empty($this->user->site_ids)){
                 $condition[] = '  ur.site_id IN ('.$this->user->site_ids.') ';
            }
        }
        
        if($this->user->role_code == 'FO'){
            if(!empty($this->user->site_ids)){
                 $condition[] = '  ur.site_id IN ('.$this->user->site_ids.') ';
            }
        }
        
        if($this->user->role_code == 'RM'||$this->user->role_code == 'BM'||$this->user->role_code == 'FO'){
            $condition[] = ' u.company_id = '.$companyId; 
        }
        
        if(count($condition)>0){
            $where = implode(' OR ', $condition);
        }
        
        if($where != ''){
             $where = ' WHERE ( '.$where.' )';
        }
        
         
        
        // ------------Start filter query-----------
        if($this->input->post())
        {
            //print_r($_POST);die;
            if($this->input->post('search_role_id'))
            {
                $f_user_role = $this->input->post('search_role_id');
                if(empty($where))
                {   $where = $where.' WHERE ur.role_id = '.$f_user_role; }
                else
                {   $where = $where.' and ur.role_id = '.$f_user_role; }
                
            }    
            if($this->input->post('emp_comp_id')){
                $emp_comp_id = $this->input->post('emp_comp_id');
                if(empty($where))
                {   $where = $where." WHERE e.company_employee_id LIKE '%".$emp_comp_id."%'"; }
                else
                {   $where = $where." and e.company_employee_id LIKE '%".$emp_comp_id."%'"; }
            }
        }
       // echo $where;die;
        // ------------End filter query-----------        

        $cur_page = $this->input->post('page') ? $this->input->post('page') : 1;
        $perPage  = $this->config->item('perPage');
        $vars['perPage']   = $perPage;
        $vars['page']      = $cur_page;
        $offset = ($cur_page*$perPage)-$perPage;
        $count  = $this->um->getAllUserPageList($where,$offset,$perPage,true);
        $vars['total_record']   = $count;
        $pages  = new paginator($count, $perPage, $cur_page);
        $vars['pagination'] = $pages;
         $vars['employeeStatusArr'] = $this->config->item('employeeStatusArr');
        $userData        = $this->um->getAllUserPageList($where,$offset,$perPage,false);
        //echo "<pre>";print_r($userData);die;
        $vars['roleDropDown']  = $this->um->getAllUserRole();
        $vars['userData'] = $userData;
        $userSession   = $this->um->getUserSession();        
        $vars['loggedUserId'] = $userSession->user_id;
        $vars['f_user_role'] = $f_user_role;
        $vars['emp_comp_id']   = $emp_comp_id;
        $vars['title']      = 'Employee List';        
        $vars['contentView']= 'user_list';
        $vars['login_user_role'] = $login_user_role;
        $this->load->view('inner_template', $vars);
    }

    function addEditUsers()
    {
        //print_r($_POST);die;
        $this->um->checkLoginSession();
        $companyId  = $this->session->userdata('session_company_id');
        if(empty($companyId) || $companyId ==''){
            $companyId  = $this->user->company_id; 
        }
        $head       = 'Add';
        $userId     = '';
        $company_name  = null;
        $regionIds   = array();
        $branchIds   = array();
        $siteIds     = array();        
        $militry_service = 'N';
        $army_number = '';
        $rank       = '';        
        $date_of_retirement = '';
        $first_name = '';
        $last_name  = '';
        $father_name = '';
        $age        = '';
        $system_id        = '';
        $dob        = '';        
        $local_address  = '';
        $local_city  = '';
        $local_state = '';
        $local_pin   = '';
        $permanent_address   = '';
        $permanent_city  = '';
        $permanent_state = '';
        $permanent_pin   = '';
        $email      = '';
        $mobile     = '';      
        $latitude   = '';
        $longitude  = '';
        $newpass    = '';
        $confpass   = '';
        $status     = 1;
        $user_role  = '';
        $user_role_vali  = '';
        $user_role_data='';
        $user_name = '';
        $image_url = '';        
        $userId  = base64_decode($this->uri->segment(3));
        $user_role_id = '';
        $company_id = '';
        $error = '';
        $status     = 1;
        $is_system_user = '';
        $change_pass_flag = 0;
        $emp_comp_id    = '';
        $employeeId = '';
        $bloodGroup = '';
        if(isset($userId)&&!empty($userId))
        {
            $head           = 'Edit';
            $userData       = $this->um->getUserDetailsByUserId($userId);
           // print_r($userData);die;
            $first_name     = $userData->first_name;
            $last_name      = $userData->last_name;
            $father_name    = $userData->father_name;
            $dob            = $userData->dob;
            $age            = $userData->age;
            $local_address  = $userData->l_address;
            $local_city     = $userData->l_city;
            $local_state    = $userData->l_state;
            $local_pin      = $userData->l_zip;
            $permanent_address  = $userData->p_address;
            $permanent_city  = $userData->p_city;
            $permanent_state = $userData->p_state;
            $permanent_pin  = $userData->p_zip;
            $latitude       = $userData->latitude;
            $longitude      = $userData->longitude;
            $mobile         = $userData->mobile;
            $email          = $userData->email;
            $status         = $userData->user_status;
            $image_url      = $userData->img_url;
            $user_role      = $userData->role_code;
            $user_role_id   = $userData->role_id;   
            $system_id   = $userData->system_id;   
            $companyId      = $userData->company_ids;
            $militry_service = $userData->x_service_man;
            $army_number   = $userData->army_number;
            $rank           = $userData->rank;
            $bloodGroup     = $userData->blood_group;
            $date_of_retirement = $userData->date_of_retirement;
            if($userData->region_ids){
                $regionIds = explode(',', $userData->region_ids);
            }
            if($userData->branch_ids){
                $branchIds = explode(',', $userData->branch_ids);
            }
             if($userData->site_ids){
                $siteIds = explode(',', $userData->site_ids);
            }
            if($userData->password != ''){
                $is_system_user = 1;
            }
            $emp_comp_id = $userData->company_employee_id;
            $employeeId = $userData->employee_id;
            
        }
        
        if($this->input->post()){  
           // print_r($_POST);die;
            $is_system_user = $this->input->post('is_system_user');
            if($this->input->post('change_pass_flag')){
                 $change_pass_flag = 1;
            }
            if($this->input->post('first_name')){
                $first_name  =   trim($this->input->post('first_name'));
            }
            if($this->input->post('last_name')){
                $last_name   =   trim($this->input->post('last_name'));
            }
            if($this->input->post('father_name')){
                $father_name   =   trim($this->input->post('father_name'));
            }
            if($this->input->post('local_address')){
                $local_address    =   trim($this->input->post('local_address'));
            }                        
            if($this->input->post('local_state')){
                $local_state    =   trim($this->input->post('local_state'));
            }
            if($this->input->post('local_pin')){
                $local_pin    =   trim($this->input->post('local_pin'));
            }
            if($this->input->post('local_city')){
                $local_city    =   trim($this->input->post('local_city'));
            }
            if($this->input->post('system_id')){
                $system_id    =   trim($this->input->post('system_id'));
            }
            if($this->input->post('permanent_address')){
                $permanent_address    =   trim($this->input->post('permanent_address'));
            }
            if($this->input->post('permanent_state')){
                $permanent_state    =   trim($this->input->post('permanent_state'));
            }
            if($this->input->post('permanent_pin')){
                $permanent_pin    =   trim($this->input->post('permanent_pin'));
            }
            if($this->input->post('permanent_city')){
                $permanent_city    =   trim($this->input->post('permanent_city'));
            }
            if($this->input->post('age')){
                $age    =   trim($this->input->post('age'));
            }                        
            if($this->input->post('dob')){
                $dob    =   date("Y-m-d", strtotime(trim($this->input->post('dob'))));                
            }
            if($this->input->post('email')){
                $email   =   trim($this->input->post('email'));
            }
            if($this->input->post('latitude')){
                $latitude   =   trim($this->input->post('latitude'));
            } 
            if($this->input->post('longitude')){
                $longitude   =   trim($this->input->post('longitude'));
            }
            if($this->input->post('mobile')){
                $mobile =   trim($this->input->post('mobile'));
            }       
            if($this->input->post('emp_comp_id')){
                $emp_comp_id =   trim($this->input->post('emp_comp_id'));
            }       
            if($this->input->post('password')){
                $newpass    =   trim($this->input->post('password'));
            }
            if($this->input->post('conf_pass')){
                $confpass    =   trim($this->input->post('conf_pass'));
            }
            if($this->input->post('user_role')){
                $user_role = $this->input->post('user_role');
                $user_role_data = $this->cmm->getRoleByRoleCode($user_role);
                $user_role_id = $user_role_data->role_id;
            }
            
            if($this->input->post('region_name')){
                $regionIds =   $this->input->post('region_name');                
            }
            
            
            if($this->input->post('blood_group')){
                $bloodGroup = $this->input->post('blood_group');      
            }
            
            if($this->input->post('branch_name')){
                $branchIds =  $this->input->post('branch_name');                
            }
            if($this->input->post('site_name')){
                $siteIds =   $this->input->post('site_name');                
            }
            if($this->input->post('status')){
                $status =   $this->input->post('status');                
            }
            if($this->input->post('militry_service')){
               $militry_service =   $this->input->post('militry_service');
               
               if($this->input->post('army_number')){
                   $army_number =   $this->input->post('army_number');
                }
                if($this->input->post('rank')){
                   $rank =   $this->input->post('rank');
                }
                if($this->input->post('date_of_retirement')){
                   $date_of_retirement =   $this->input->post('date_of_retirement');
                   $date_of_retirement = date('Y-m-d',strtotime($date_of_retirement));
                }                
            }
            else{
               $militry_service = 'N';
               $army_number = '';
               $rank = '';
               $date_of_retirement = '';
            }            
            if($this->_validation_user($head,$militry_service,$userId) == TRUE){                
                
                $error = '';
                if(!empty($_FILES['img_upload']['name'])){                    
                    $message = '';
                    $file_name = '';
                    $config = $this->config->item('user_images');
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);

                    if (!$this->upload->do_upload('img_upload'))
                    {            
                        $message = $this->upload->display_errors();
                        $code = 103;
                       // echo $message;die;
                        $error = $message;
                    }
                    else
                    { 
                        $upload_data = $this->upload->data();
                        $file_name = $upload_data['file_name'];                        
                        if($file_name){
                             $dest   = $this->config->item('user_profile_images').$file_name;
                             $config =  $this->config->item('user_images_thumb');
                             $config['source_image']  = $dest;
                             $this->load->library('image_lib',$config);
                             $this->image_lib->initialize($config);

                             if (!$this->image_lib->resize()){
                                 $error = $this->upload->display_errors();                                 
                             }else{
                                 $message = "Image uploaded sucessfully!";
                             }
                         }
                        $old_image_url  = $image_url;
                        $image_url = $upload_data['file_name'];
                        if(isset($image_url)&&!empty($image_url)){
                            unlink("uploads/user_img/" . $old_image_url);    
                            unlink("uploads/thumb_path/" . $old_image_url);
                        }
                    } 
                    
                }
                
                if($error == ''){                
                    $dataArr    = array('company_id'    => $companyId,
                                    'first_name'        => $first_name,
                                    'last_name'         => $last_name,
                                    'father_name'       => $father_name,
                                    'l_address'         => $local_address,
                                    'l_city'            => $local_city,
                                    'l_state'           => $local_state,
                                    'l_zip'             => $local_pin,
                                    'p_address'         => $permanent_address,
                                    'p_city'            => $permanent_city,
                                    'p_state'           => $permanent_state,
                                    'p_zip'             => $permanent_pin,
                                    'age'               => $age,
                                    'dob'               => $dob,
                                    'email'             => $email,   
                                    'user_name'         => $email,
                                    'mobile'            => $mobile,                                                                    
                                    'status'            => intval($status),
                                    'created_date'      => date('Y-m-d H:i:s'),
                                    'img_url'           => $image_url,
                                    'x_service_man'     => $militry_service,
                                    'army_number'       => $army_number,
                                    'rank'              => $rank,
                                    'date_of_retirement'     => $date_of_retirement
                    );
                    
                    //print_r($dataArr);
                 //   if($user_role ==  'FO'){
                        
                        
                        $testAdress = trim($local_address.' '.$local_pin.' '.$local_city.' '.$local_state);
                        if($testAdress != ''){
                            $latlongArr = $this->cmm->getLatLongByAddress($testAdress);
                            $latitude    = 0;
                            $longitude   = 0;
                            if(!empty($latlongArr)){
                                 $latitude    = $latlongArr[0];
                                 $longitude   = $latlongArr[1];
                            }
                        }
                      
                        
                        $dataArr['latitude']          = $latitude;
                        $dataArr['longitude']         = $longitude;
                    //}
                    if(isset($userId) && !empty($userId)){
                        if($is_system_user == 1){
                            if($change_pass_flag == 1){
                                $dataArr['password']    =  md5($newpass);
                            }
                        }else{
                             $dataArr['password']    =  '';
                        }
                        //print_r($dataArr);die;
                        log_message('info', 'Update User data : '.print_r($dataArr,true));
                        $condition  = array('user_id'    => $userId);
                        $this->cmm->update($dataArr,$condition,'user');
                        
                        if($employeeId!=''){
                            $empdataArr    = array('company_employee_id'   => $emp_comp_id,'blood_group' => $bloodGroup,'system_id'=>$system_id);
                            log_message('info', 'Update Employee data : '.print_r($dataArr,true));
                            $empcondition  = array('employee_id'    => $employeeId);
                            $this->cmm->update($empdataArr,$empcondition,'employee');
                        }
                        
                        $successMsg = 'Employee updated successfully.';
                    }else{
                        if($is_system_user == 1){
                            $dataArr['password']    =  md5($newpass);
                        }
                        $dataArr['created_by']  =  $this->user->user_id;
                        log_message('info', 'Insert User data : '.print_r($dataArr,true));
                        $userId = $this->cmm->insert($dataArr,'user');

                        $dataArr    = array('user_id'   => $userId,                                                                        
                                    'created_by'        => $this->user->user_id,
                                    'created_date'      => date('Y-m-d H:i:s'),
                                    'company_employee_id'   => $emp_comp_id,
                                    'blood_group' => $bloodGroup,
                                    'system_id' => $system_id
                                );
                        log_message('info', 'Insert Employee data : '.print_r($dataArr,true));
                        $this->cmm->insert($dataArr,'employee');
                        $successMsg = 'Employee added successfully.';
                    }
                    if(isset($userId) && !empty($userId)){
                        
                        if($user_role ==  'cadmin'){
                            $qrPrifix = 'CA';
                        }else if($user_role ==  'cuser'){
                            $qrPrifix = 'CU';
                        }else if($user_role ==  'RM'){
                            $qrPrifix = 'RM';
                        }else if($user_role ==  'BM'){
                            $qrPrifix = 'BM';
                        }else if($user_role ==  'FO'){
                            $qrPrifix = 'FO';
                        }else if($user_role ==  'GD'){
                            $qrPrifix = 'G';
                        }
                        $qrCode     = $qrPrifix.$userId;
                        $fileName   = $this->cmm->getBarcode($qrCode,'IMG_'.$qrCode,'./uploads/guard/');
                        
                        $condition  = array('user_id'    => $userId);
                        $this->cmm->update(array('qr_code'=>$qrCode),$condition,'user');
                         if($user_role != '' && (!empty($companyId) || !empty($regionIds) || !empty($branchIds) || !empty($siteIds))){
                                $condition  = array('user_id'    => $userId);
                                $this->cmm->delete($condition,'user_role');
                                if($user_role ==  'cadmin' || $user_role ==  'cuser'){
                                    $dataArrRole = array('user_id' => $userId, 'role_id' => $user_role_id,'company_id'=>$companyId);
                                    $this->cmm->insert($dataArrRole,'user_role');
                                }
                                if($user_role ==  'RM'){
                                    for($i=0;$i<count($regionIds);$i++){
                                        $dataArrRole = array('user_id' => $userId, 'role_id' => $user_role_id,'region_id'=>$regionIds[$i]);
                                        $this->cmm->insert($dataArrRole,'user_role');
                                    }
                                }
                                if($user_role ==  'BM'){
                                    for($i=0;$i<count($branchIds);$i++){
                                        $dataArrRole = array('user_id' => $userId, 'role_id' => $user_role_id,'branch_id'=>$branchIds[$i]);
                                        $this->cmm->insert($dataArrRole,'user_role');
                                    }
                                }
                                if($user_role ==  'FO'){
                                    for($i=0;$i<count($siteIds);$i++){
                                        $dataArrRole = array('user_id' => $userId, 'role_id' => $user_role_id,'site_id'=>$siteIds[$i]);
                                        $this->cmm->insert($dataArrRole,'user_role');
                                    }
                                }
                                if($user_role == 'GD'){                                    
                                    $dataArrRole = array('user_id' => $userId, 'role_id' => $user_role_id);
                                    $this->cmm->insert($dataArrRole,'user_role');
                                }
                            }
                       
                           $this->session->set_flashdata('successMessage', $successMsg);
                           redirect("user/addEditUsers/".base64_encode($userId));
                    }
                }
            }
        }
        $vars['blood_group']    = $bloodGroup;
        $vars['change_pass_flag'] = $change_pass_flag;
        $vars['user_id']      = $userId;
        $vars['is_system_user']      = $is_system_user;
        $vars['status']      = $status;
        $vars['region_ids']   = $this->rm->getAllRegionList($companyId,$this->user->user_id,$this->user->role_code);
        $vars['branch_ids']   = $this->bm->getAllBranchList('',$companyId,$this->user->user_id,$this->user->role_code);
        $vars['site_ids']     = $this->sm->getAllSiteListDropdown('',$companyId,$this->user->user_id,$this->user->role_code);
        $vars['employeeStatusArr'] = $this->config->item('employeeStatusArr');
        $vars['error_message']  = $error;
        $vars['militry_service']    = $militry_service;
        $vars['army_number']    = $army_number;
        $vars['rank']           = $rank;        
        $vars['date_of_retirement'] = $date_of_retirement;
        $vars['company_id']     = $companyId;
        $vars['first_name']     = $first_name;
        $vars['last_name']      = $last_name;
        $vars['father_name']    = $father_name;
        $vars['age']            = $age;
        $vars['dob']            = $dob;        
        $vars['local_address']  = $local_address;
        $vars['local_state']    = $local_state;
        $vars['local_city']     = $local_city;
        $vars['local_pin']      = $local_pin;
        $vars['permanent_address']  = $permanent_address;
        $vars['permanent_state']    = $permanent_state;
        $vars['permanent_city']     = $permanent_city;
        $vars['permanent_pin']      = $permanent_pin;
        $vars['latitude']       = $latitude;
        $vars['longitude']      = $longitude;
        $vars['mobile']         = $mobile;
        $vars['email']          = $email;
        //var_dump($this->user->role_order);die;
        $vars['user_roles']     = $this->um->getAllUserRole($this->user->role_order);
        $vars['user_role_id']   = $user_role;
        $vars['user_role_code'] = $user_role_vali;
        $vars['region_id']      = $regionIds;
        $vars['branch_id']      = $branchIds;
        $vars['site_id']        = $siteIds;
        $vars['newpass']        = $newpass;
        $vars['confpass']       = $confpass;
        $vars['image_url']      = $image_url;
        $vars['system_id']      = $system_id;
        $vars['emp_comp_id']      = $emp_comp_id;
        $vars['title']          = $head.' Employee';
        $vars['pageHeading']    = $head.' Employee';        
        $vars['contentView']    = 'add_edit_users';
        $this->load->view('inner_template', $vars);        
        //print_r($vars);die;
    }
    
    function _validation_user($head,$militry_service,$userId){
        $this->form_validation->set_rules('first_name', 'First Name','trim|required');
        $this->form_validation->set_rules('last_name','Last Name','trim|required');
        //$this->form_validation->set_rules('system_id','System Id','trim|required');
        $this->form_validation->set_rules('local_address', 'local Address','trim|required');

        //$this->form_validation->set_rules('latitude','Latitude','trim|required');
        //$this->form_validation->set_rules('longitude', 'Longitude','trim|required');        
        $this->form_validation->set_rules('mobile','Mobile Number','trim|required|numeric');        
       
        $this->form_validation->set_rules('emp_comp_id','Employee Id','trim|required|callback_employeeid_check['.$userId.']');
        $this->form_validation->set_rules('blood_group','Blood Group','trim|required');
        $this->form_validation->set_rules('age','Age','trim|required|numeric');
        $this->form_validation->set_rules('status','Status','trim|required');
        if($head =='Add'){
            if($this->input->post('is_system_user')){
                $this->form_validation->set_rules('password','New Password','trim|required');
                $this->form_validation->set_rules('conf_pass','Cofirm Password','trim|required|matches[password]'); 
            }
        }else{
             if($this->input->post('change_pass_flag')){
                $this->form_validation->set_rules('password','New Password','trim|required');
                $this->form_validation->set_rules('conf_pass','Cofirm Password','trim|required|matches[password]'); 
            }
        }
        //$this->form_validation->set_rules('company_name', 'Company Name','trim|required');
        $this->form_validation->set_rules('user_role','User Role','trim|required');
        $userRole   =  $this->input->post('user_role');
        if(isset($userRole)&&!empty($userRole)){
            if($userRole == 'RM'){
                 $this->form_validation->set_rules('region_name', 'Region','required'); 
            }
            if($userRole == 'BM'){
                $this->form_validation->set_rules('branch_name', 'Branch','required');  
            }
            if($userRole == 'FO'){
                $this->form_validation->set_rules('site_name', 'Site','required');  
            }
            
            if($userRole != 'GD'){
                if($head =='Add'){ $this->form_validation->set_rules('email','Email','trim|required|valid_email|is_unique[user.email]'); }
            }
            if(($userRole != 'cuser')&&$userRole != 'cadmin'){
                $this->form_validation->set_rules('dob','Date of Birth','trim|required');
            }
        }
        if($militry_service!= 'N')
        {
            $this->form_validation->set_rules('army_number','Army Number','trim|required');
            $this->form_validation->set_rules('rank', 'Rank','trim|required');
            $this->form_validation->set_rules('dob','Date of birth missmatched','trim|required');             
            $this->form_validation->set_rules('date_of_retirement','Date of Retirement','trim|required');
        }
        $this->form_validation->set_error_delimiters('<span class="error">','</span>');
        return $this->form_validation->run();
    }
    
    function employeeid_check($str,$userId){
        if($this->um->checkEmployeeId($str,$userId)){
            $this->form_validation->set_message('employeeid_check', "The %s field must contain a unique value.");
            return FALSE;
        }else{
            return TRUE;
        }
    }

    function skills()
    {
        //print_r($_POST);die;
        $this->um->checkLoginSession();        
        $userId  = base64_decode($this->uri->segment(3));
        if(!empty($userId) && isset($userId))
        {
            $head = 'Update';
            $experienceCount = 0;
            $skillCount = 0;
            $language_count = 0;
            $postFlag                   = '';
            $qualification  = '';
            $employee_skill_data = array();
            $education_qualification = array();
            $technical_qualification = array();
            $skill_name     = array();
            $qualification_name = array();
            $employeeSkillData          = $this->um->getSkillDetailById($userId);
            $employee_id                = $employeeSkillData->employee_id;
            $qualification              = $this->um->getQualificationByEmployeeId($employee_id);             
            
            $skill_ids = $this->um->getSkillDetailByEmployeeId($employee_id); 
            
            for($i=0;$i<count($qualification);$i++)
            {
                $qualification_name[] = $qualification[$i]->qualification_id;
            }
            for($i=0;$i<count($skill_ids);$i++)
            {
                $skill_name[] = $skill_ids[$i]->skill_id;  
                $employee_skill_data[] = $skill_ids[$i]->employee_skill_id;  
            }
            
            $ref_name_one               = $employeeSkillData->ref_name_1;
            $ref_name_two               = $employeeSkillData->ref_name_2;
            $ref_address_one            = $employeeSkillData->ref_add_1;
            $ref_address_two            = $employeeSkillData->ref_add_2;
            $ref_post_one               = $employeeSkillData->ref_des_1;
            $ref_post_two               = $employeeSkillData->ref_des_2;
            $proffeciency =array();
            $vars['emp_language']   = $this->um->getLanguageDetailByEmployeeId($employee_id);   
            if(count($vars['emp_language'])>0){
                $language_count = count($vars['emp_language']);
            }
                          
            $vars['experience_data']= $this->um->getExperienceDetailByEmployeeId($employee_id);
            if(count($vars['experience_data'])>0){
                $experienceCount = count($vars['experience_data']);
            }
            
            if(count($skill_name)>0){
                $skillCount = count($skill_name);
            }
           
            
            
            if($this->input->post())
            {   
               // print_r($_POST);die;
                $postFlag                   = 'post';
                $exp_verify_num             = $this->input->post('exp_verify_num');  
                $exp_num                    = $this->input->post('exp_num');
                $skill_num                  = $this->input->post('skill_num');
                $lang_num                   = $this->input->post('lang_num');
                $company_name               = $this->input->post('company_name');
                $experienceCount            = end($exp_num);
                //echo $experienceCount;
                $start_date                 = $this->input->post('fromdate');
                $end_date                   = $this->input->post('todate');
                $designation                = $this->input->post('experience_des');
                $salary_drawn               = $this->input->post('salary_drawn');
                $leaving_reason             = $this->input->post('reason_for_leaving');
                
                $skill_name                 = $this->input->post('skill_name');
                $skillCount                 = count($skill_name);
                $education_qualification    = $this->input->post('education_qualification');
                $technical_qualification    = $this->input->post('technical_qualification');
                
                if(is_array($education_qualification)&&is_array($education_qualification))
                {
                    $qualification_name = array_merge($education_qualification, $technical_qualification);
                }                
                
                $language_num              = $this->input->post('lang_num');
                $language_name              = $this->input->post('languages');

                $language_count = end($language_num);
               
                if(count($language_num)>0){
                    foreach($language_num as $i){
                       $proffeciency[($i-1)] = $this->input->post('language'.($i-1));
                    }
                }
                //print_r($proffeciency);
                $ref_name_one               = trim($this->input->post('ref_name_one'));
                $ref_name_two               = trim($this->input->post('ref_name_two'));
                $ref_address_one            = trim($this->input->post('ref_address_one'));
                $ref_address_two            = trim($this->input->post('ref_address_two'));
                $ref_post_one               = trim($this->input->post('ref_post_one'));
                $ref_post_two               = trim($this->input->post('ref_post_two'));
            }            
            
            
            if($this->_validation_skills() == TRUE)
            {
                //echo 'validadte';
                $dataArr    = array(
                                    'ref_name_1'    => $ref_name_one,
                                    'ref_add_1'     => $ref_address_one,
                                    'ref_des_1'     => $ref_post_one,
                                    'ref_name_2'    => $ref_name_two,
                                    'ref_add_2'     => $ref_address_two,
                                    'ref_des_2'     => $ref_post_two
                    );

                log_message('info', 'Update Employee data : '.print_r($dataArr,true));
                $condition  = array('user_id'    => $userId);
                $this->cmm->update($dataArr,$condition,'employee');

                log_message('info', 'Delete Employee Experience data : '.print_r($dataArr,true));
                $this->um->deleteExperienceByEmployeeId($employee_id);

                
                
                foreach($exp_num as $key){
                    $eid = $key -1;
                    $dataArr    = array(
                                    'employee_id'   => $employee_id,
                                    'start_date'    => trim($start_date[$eid]),
                                    'end_date'      => trim($end_date[$eid]),
                                    'company_id'    => trim($company_name[$eid]),
                                    'designation'   => trim($designation[$eid]),
                                    'salary_drawn'  => trim($salary_drawn[$eid]),
                                    'leaving_reason' => trim($leaving_reason[$eid])
                    );
                    log_message('info', 'Insert Employee Experience data : '.print_r($dataArr,true));
                    $this->cmm->insert($dataArr,'employee_experience');
                }
                
                
                log_message('info', 'Delete Employee Skill data : '.print_r($dataArr,true));
                $condition  = array('employee_id'    => $employee_id);
                $this->cmm->delete($condition,'employee_skill');
                
                foreach($skill_num as $key)
                {     
                    $i = $key -1;
                    $dataArr    = array(
                                    'employee_id' => $employee_id,
                                    'skill_id'    => $skill_name[$i]
                    );
                    log_message('info', 'Insert Employee Skill data : '.print_r($dataArr,true));
                    $this->cmm->insert($dataArr,'employee_skill');
                }
                
                if(count($education_qualification)>0)
                {
                    $this->um->delQualification($employee_id,0);
                    for($i=0;$i<count($education_qualification);$i++)
                    {   

                        $dataArr    = array(
                                        'employee_id'       => $employee_id,
                                        'qualification_id'  => $education_qualification[$i]
                        );
                        log_message('info', 'Insert Employee Education data : '.print_r($dataArr,true));
                        $this->cmm->insert($dataArr,'employee_qualification');
                    }
                }
                
                if(count($technical_qualification)>0)
                {
                    $this->um->delQualification($employee_id,1);
                    for($i=0;$i<count($technical_qualification);$i++)
                    {                          
                        $dataArr    = array(
                                        'employee_id'       => $employee_id,
                                        'qualification_id'  => $technical_qualification[$i]
                        );
                        log_message('info', 'Insert Technical Education data : '.print_r($dataArr,true));
                        $this->cmm->insert($dataArr,'employee_qualification');
                    }
                }
                
                log_message('info', 'Delete Employee Skill data : '.print_r($dataArr,true));
                $condition  = array('employee_id'    => $employee_id);
                $this->cmm->delete($condition,'employee_language');
                
                foreach($language_num as $k)
                {                    
                    $readVal  = 0;
                    $writeVal = 0;
                    $speakVal = 0;
                    
                    if(in_array(1, $proffeciency[$k-1])){
                         $readVal = 1;
                    }
                    if(in_array(2, $proffeciency[$k-1])){
                         $writeVal = 1;
                    }
                    if(in_array(3, $proffeciency[$k-1])){
                         $speakVal = 1;
                    }
                    $dataArr    = array(
                                    'employee_id' => $employee_id,
                                    'language_id' => $language_name[($k-1)],
                                    'read'        => $readVal,
                                    'write'       => $writeVal,
                                    'speak'       => $speakVal
                    );
                    
                    
                    //print_r($dataArr);
                    
                    log_message('info', 'Insert Employee Language data : '.print_r($dataArr,true));
                    $this->cmm->insert($dataArr,'employee_language');
                }
                $successMsg = 'Employee updated successfully.';                
                $this->session->set_flashdata('successMessage', $successMsg);
                redirect("user/skills/".base64_encode($userId));
            }
           // print_r(validation_errors());
            $vars['company_names']              = $this->cm->getAllCompanyList();            
            $vars['employeeSkillTypes']        = $this->um->getAllSkill();            
            $vars['education_qualification']   = $this->um->getQualificationList(0);            
            $vars['technical_qualification']   = $this->um->getQualificationList(1);
            $vars['languages']      = $this->um->getAllLanguages();                        
            
            $vars['qualification']  = $qualification_name;
            $vars['leaving_reason'] = $this->config->item('leavingReasonArr');
            $vars['experience_designation'] = $this->config->item('experienceDesignationArr');
            
            $vars['lang_num']          = $lang_num;
            $vars['exp_num']            = $exp_num;
            $vars['skill_num']          = $skill_num;
            $vars['exp_company_name']   = $company_name;
            $vars['exp_start_date']     = $start_date;
            $vars['exp_end_date']       = $end_date;
            $vars['exp_designation']    = $designation;
            $vars['exp_salary_drawn']   = $salary_drawn;
            $vars['exp_leaving_reason'] = $leaving_reason;
            $vars['emp_language_name'] = $language_name;
            $vars['emp_proffeciency']  = $proffeciency;
            //print_r($proffeciency);
            
           //print_r($proffeciency);die;
            
            
           // echo validation_errors(); 
           // echo $experienceCount;
            $vars['employee_skill_data']=$employee_skill_data;
            $vars['experience_count'] = $experienceCount;
            $vars['skill_data']     = $skill_name; 
            $vars['skill_count']     = $skillCount;
            $vars['language_count'] = $language_count;
            $vars['postFlag'] = $postFlag;
                    
            $vars['ref_name_one']   = $ref_name_one;    
            $vars['ref_name_two']   = $ref_name_two;
            $vars['ref_add_one']    = $ref_address_one;
            $vars['ref_add_two']    = $ref_address_two;
            $vars['ref_post_one']   = $ref_post_one;
            $vars['ref_post_two']   = $ref_post_two;
            $vars['title']          = $head.' Employee Skills / Education / Experience';
            $vars['pageHeading']    = $head.' Employee  Skills / Education / Experience';
            $vars['contentView']    = 'add_edit_skills';
            $this->load->view('inner_template', $vars);
        }
        else
        {
            redirect('user/users');
        }
    }

    function _validation_skills()
    {        
        $this->form_validation->set_rules('education_qualification','Education Qualification','required');
        $this->form_validation->set_rules('technical_qualification','Technical Qualification','required');
        
        $exp_num = $this->input->post('exp_num');   
        $exp_verify_num = $this->input->post('exp_verify_num');  
        if(count($exp_num)>0){
            
            
            
            foreach($exp_num as $val){
                $id = $val - 1;
               
                if($exp_verify_num[$id] == 0){
                $this->form_validation->set_rules('company_name['.$id.']','Company Name','trim|required');
                $this->form_validation->set_rules('fromdate['.$id.']','Start Date','trim|required|callback_compareDate['.$id.']');
                $this->form_validation->set_rules('todate['.$id.']','End Date','trim|required');
                $this->form_validation->set_rules('experience_des['.$id.']','Designation','trim|required');
                $this->form_validation->set_rules('salary_drawn['.$id.']','Salary Drawn','trim|required');
                $this->form_validation->set_rules('reason_for_leaving['.$id.']','Leaving Reason','trim|required');
                }
            }
        }
       
        $skill_name = $this->input->post('skill_num');   
        if(count($skill_name)>0){
            foreach($skill_name as $i){
                $this->form_validation->set_rules('skill_name['.($i-1).']','Skill','trim|required');
            }
        }
    
        $language_name              = $this->input->post('lang_num');
        if(count($language_name)>0){
            foreach($language_name as $i){
               $this->form_validation->set_rules('languages['.($i-1).']','Languages','trim|required|callback_check_proffeciency['.($i-1).']'); 
            }
        }
        
        
        $this->form_validation->set_error_delimiters('<span class="error">','</span>');
        return $this->form_validation->run();
    }
    
    function compareDate($str,$i) {
        $startDate = $this->input->post('fromdate');  
        $endDate = $this->input->post('todate');  
       
        if (strtotime($endDate[$i]) >= strtotime($startDate[$i]))
          return True;
        else {
          $this->form_validation->set_message('compareDate', '%s should be greater than End Date.');
          return False;
        }
    }
    
    function check_proffeciency($test,$str){
        $language_name  = $this->input->post('language'.$str);
       // print_r($language_name);die();
        if(empty($language_name))
        {
                $this->form_validation->set_message('check_proffeciency', 'Please select at least one option(Read, Write or Speak).');
                return FALSE;
        }
        else
        {
                return TRUE;
        }
    }
    
    function documents()
    {
        $this->um->checkLoginSession();        
        $userId  = base64_decode($this->uri->segment(3));
        $doc_count = 1;
        $messageArray = '';
        if(!empty($userId) && isset($userId))
        {   
            $head = 'Update';  
            $employeeSkillData = $this->um->getSkillDetailById($userId);
            $employeeId        = $employeeSkillData->employee_id;
            $documentType      = array();
            $documentContent   = '';
            $remove_doc        = '';
            $remove_doc_button = '';
            $upload_doc_button = '';            
            $vars['title']          = $head.' Employee Documents';
            $vars['pageHeading']    = $head.' Employee Documents';
            if($this->input->post())
            {         
                $doc_num            = $this->input->post('doc_num');
                $doc_count          = end($doc_num);
                $remove_doc_button  = trim($this->input->post('remove_doc_button'));
                $upload_doc_button  = trim($this->input->post('upload_doc_button'));                
                $documentType       = $this->input->post('document_type');
                $documentContent    = $this->input->post('docdetail');
                $remove_doc         = $this->input->post('remove_doc');                
            }

            if(!empty($remove_doc_button)&&($remove_doc_button=='remove_doc'))
            {
                if($this->_validation_documents($remove_doc_button) == TRUE)
                {
                    foreach($remove_doc as $emp_doc_url)
                    {
                        unlink("uploads/guard_docs/".$emp_doc_url);
                        $dataArr = array('document_url' => $emp_doc_url);
                        log_message('info', 'Delete Documents data : '.print_r($dataArr,true));
                        $this->cmm->delete($dataArr,'employee_document');
                    }
                    $successMsg = 'Employee document removed successfully.';                
                    $this->session->set_flashdata('successMessage', $successMsg);
                    redirect("user/documents/".base64_encode($userId));
                }
            }
            //print_r($_POST);die;
            if(!empty($upload_doc_button)&&($upload_doc_button=='upload_doc'))
            {                
                if($this->_validation_documents($upload_doc_button) == TRUE)
                {
                    if(!empty($_FILES['guard_upload_files']['name']))
                    {
                        $fileUploadResult = $this->doupload();      
                        if(count($fileUploadResult['errorArray']) == 0){                          
                            $i = 0;
                            foreach ($fileUploadResult['fileArray'] as $key=>$value)
                            {                             
                                $dataArr = array(
                                    'employee_id'  => $employeeId,
                                    'document_type_id'  => trim($documentType[$key-1]),
                                    'document_content'  => trim($documentContent[$key-1]),
                                    'document_url' => $value
                                    );   
                                log_message('info', 'Insert Documents data : '.print_r($dataArr,true));
                                $this->cmm->insert($dataArr,'employee_document');
                                $i++;
                            }                            
                            $successMsg = "Employee's document uploaded successfully.";
                            $this->session->set_flashdata('successMessage', $successMsg);
                            redirect("user/documents/".base64_encode($userId));
                        }else{
                           $messageArray   = implode(',',$fileUploadResult['errorArray']);
                        }  
                    }
                }
            }
            $vars['messageArray'] = $messageArray;
            $vars['doc_count']     = $doc_count;
            $vars['doc_type_id']   =   '';
            $vars['verifying_user']  =  $this->user->user_id;
            $vars['document_content']  =  $documentContent;
            $vars['document_type_id']  =  $documentType;
            $vars['doc_type_ids']   =   $this->um->getAllDocTypeList();
            $vars['contentView']    = 'add_edit_document';            
            $vars['employeeDocumentData'] = $this->um->getEmployeeDocByEmployeeId($employeeId);
            $this->load->view('inner_template', $vars);
        }
        else
        {
            redirect('user/users');
        }
    }

    function doupload(){
        $errors = array();
        $returnfilename = array();
        $files = $_FILES['guard_upload_files'];
        $doc_num = $this->input->post('doc_num');
        $this->load->library('upload');
        $config['upload_path'] = './uploads/guard_docs';            
        $config['allowed_types'] = '*';  
        foreach($doc_num as $key){
            $i = $key-1;
            if($files['error'][$i] != 0){
                $errors[$key] = 'Couldn\'t upload file '.$_FILES['guard_upload_files']['name'][$i];
            }
            if(count($error)==0){
                $config['file_name']       = 'emp_doc_'.date('dmYHis').$i;
                $this->upload->initialize($config);
                $_FILES['guard_upload_files']['name']       = $files['name'][$i];
                $_FILES['guard_upload_files']['type']       = $files['type'][$i];
                $_FILES['guard_upload_files']['tmp_name']   = $files['tmp_name'][$i];
                $_FILES['guard_upload_files']['error']      = $files['error'][$i];
                $_FILES['guard_upload_files']['size']       = $files['size'][$i];
                if ($this->upload->do_upload('guard_upload_files')){
                    $data['uploads'][$i] = $this->upload->data();
                    $newfile = $data['uploads'][$i]['file_name']; 
                    $returnfilename[$key]   = $newfile;
                }else{
                    $errors[$key] = $this->upload->display_errors();
                }
            }
        }
        return array('fileArray'    => $returnfilename, 'errorArray'    => array_unique($errors));
    }
    
    
    
function valid_file($str,$k){
    $files = $_FILES['guard_upload_files'];
    if (isset($files[name][$k]) && !empty($files[name][$k])){
      return true;
    }else{
      // throw an error because nothing was uploaded
      $this->form_validation->set_message('valid_file', "The File field is required.");
      return false;
    }
}
    
    
    function _validation_documents($document_button)
    {       	
        if($document_button == 'upload_doc'){    
           
            $doc_count = $this->input->post('doc_num');
            foreach($doc_count as $k){
                $this->form_validation->set_rules('document_type['.($k-1).']', 'Document type','trim|required'); 
                //$this->form_validation->set_rules('guard_upload_files['.($k-1).']', 'File','trim|callback_valid_file['.($k-1).']'); 
            }
            
            
            
            
             
            
        }elseif($document_button == 'remove_doc') {
            $this->form_validation->set_message('required', 'Select at least  one document');
            $this->form_validation->set_rules('remove_doc[]', 'Document type','trim|required'); }
        $this->form_validation->set_error_delimiters('<span class="error">','</span>');
        return $this->form_validation->run();
    }
    
    function financial()
    {
        $this->um->checkLoginSession();        
        $userId  = base64_decode($this->uri->segment(3));
        if(!empty($userId) && isset($userId))
        {               
            $employeeSkillData = $this->um->getSkillDetailById($userId);
            $bank_name         = $employeeSkillData->bank_name;
            $aadharCardNo      = $employeeSkillData->aadhar_card_no;
            $branch_name       = $employeeSkillData->branch_name;
            $ifsc_code         = $employeeSkillData->ifsc_code;
            $account_number    = $employeeSkillData->account_number;
            $pf_account_number      = $employeeSkillData->pf_account_number;
            $esic_account_number    = $employeeSkillData->esic_account_number;
            $esic_smart_card_number = $employeeSkillData->esic_smart_card_number;
            if($this->input->post())
            { 
                $bank_name              = trim($this->input->post('bank_name'));
                $branch_name            = trim($this->input->post('branch_name'));
                $ifsc_code              = trim($this->input->post('ifsc_code'));
                $account_number         = trim($this->input->post('account_number'));
                $pf_account_number      = trim($this->input->post('pf_account_number'));
                $esic_account_number    = trim($this->input->post('esic_account_number'));
                $esic_smart_card_number = trim($this->input->post('esic_smart_card_number')); 
                $aadharCardNo          = trim($this->input->post('aadhar_card_no'));
                
            }
            if($this->_validation_financial() == TRUE)
            {  
                $dataArr    = array('bank_name'       => $bank_name,
                                'branch_name'         => $branch_name,
                                'ifsc_code'           => $ifsc_code,
                                'account_number'      => $account_number,
                                'pf_account_number'   => $pf_account_number,
                                'esic_account_number' => $esic_account_number,
                                'esic_smart_card_number' => $esic_smart_card_number,
                                'aadhar_card_no'        => $aadharCardNo
                );
                if(isset($userId) && !empty($userId))
                {
                    log_message('info', 'Update User Financial Detail data : '.print_r($dataArr,true));
                    $condition  = array('user_id'    => $userId);
                    $this->cmm->update($dataArr,$condition,'employee');
                    $successMsg = 'Employee updated financial detail successfully.';                          
                    $this->session->set_flashdata('successMessage', $successMsg);
                }
                
            }
            
            $vars['bank_name']           = $bank_name;
            $vars['branch_name']         = $branch_name;
            $vars['ifsc_code']           = $ifsc_code;
            $vars['account_number']      = $account_number;
            $vars['pf_account_number']   = $pf_account_number;
            $vars['esic_account_number'] = $esic_account_number;
            $vars['esic_smart_card_number'] = $esic_smart_card_number;
            $vars['aadhar_card_no'] = $aadharCardNo;
            
            $vars['pageHeading'] = 'Financial/Banking Detail';
            $vars['title']      = 'Financial Detail';
            $vars['contentView']= 'add_edit_financial_detail';
            $this->load->view('inner_template', $vars);
        }
        else
        {
            redirect('user/users');
        }        
    }
    
    function _validation_financial()
    {
        $this->form_validation->set_rules('bank_name', 'Bank name','trim');
        $this->form_validation->set_rules('branch_name','Branch name','trim');
        $this->form_validation->set_rules('ifsc_code', 'IFSC code','trim');
        $this->form_validation->set_rules('account_number','Account number','trim');
        $this->form_validation->set_rules('pf_account_number', 'PF account number','trim');
        $this->form_validation->set_rules('esic_account_number','ESIC account number','trim');    
        $this->form_validation->set_rules('aadhar_card_no','Aadhar Card Number','trim');    
        $this->form_validation->set_error_delimiters('<span class="error">','</span>');
        return $this->form_validation->run();
    }

    function testing(){
        $distance   = $this->cmm->distanceBetTwoLatLong(22.7195687,75.8577258,23.2599333,77.412615);    
        echo $distance;
    }
    
    function checkSession(){
         log_message('info', "Method Name : start checkSession ");
         $username = 'admin';
		$password = '123456';
		$users = $this->um->checkUserLogin($username,md5($password));
                log_message('info', "Method Name : authenticate_check, Log Message :". print_r($users,true));
                print_r($users);
		if(!empty($users)){
                    if($users->user_id > 0 && $users->status == 1){
                        $userData  = new stdClass();
                        $userData->user_id   = $users->user_id;
                        $userData->email     = $users->email;
                        $userData->name      = $users->name;
                        $userData->role_id   = $users->role_id;
                        $userData->user_tasks= $users->user_tasks;
                        $userData->company_id= $users->company_id;
                        $userData->region_id = $users->region_id;
                        $userData->branch_id = $users->branch_id;
                        $userData->site_id   = $users->site_id;
                        $userData->role_code   = $users->code;
                        $userData->role_name   = $users->role_name;
                        $this->session->set_userdata('session_company_id', $users->company_id);
                        if($userData->role_code == 'sadmin'){
                            $companyData =  $this->cm->getAllCompanyList();
                            //log_message('info', "Method Name : companymanager:getAllCompanyList, Log Message :". print_r($companyData,true));
                           // print_r($companyData);
                           // echo serialize($companyData);
                           // $this->session->set_userdata('sessionCompanyData',serialize($companyData));

                        }
                        $this->session->set_userdata('users',serialize($userData));
                        
                       //print_r($userData->user_tasks);die;
                        $this->session->set_userdata('tasks',serialize(explode(',', $userData->user_tasks)));
                        //log_message('info', "authenticate_check TRUE"); 
                        
                    }
                }
                         log_message('info', "Method Name : stop checkSession ");

    }

    function maplocation()
    {
        $head = 'Map';
        $vars['title']          = $head.' User';
        $vars['pageHeading']    = $head.' User';        
        $vars['contentView']    = 'maplocation';
        $this->load->view('inner_template', $vars);        
    }
    
    function showSession(){
        echo '';
       
    }
    
    function getUserDetails(){
        $userId = base64_decode($this->uri->segment(3));
        $vars['guardDetails']  =  $this->um->getUserDetailsByUserId($userId);  
       //print_r($vars['guardDetails']);die;
       // print_r($vars['siteDetails']);die;
        $this->load->view('guard_detail_qr_code', $vars);    
    }


    function downloadUserData()
    {
        //require_once('libraries/pdf/tcpdf.php');        
        $responseArray   = array();
        if($this->cmm->checkLoginSessionAjax())
        {
            $userId  = $this->input->post('userId');            
            if($userId)
            {                
                $responseArray['success']   = 1;               
            }else
            {
                $responseArray['success']   = 0;
            }
            $responseArray['status'] = 1;
        }else{
            $responseArray['status'] = 0;
            $responseArray['msg'] = $this->error_message['100'];
        }
        echo json_encode($responseArray);
    }
    
    function downloadUserDataPdf()
    {       
        //require_once(site_url().'libraries/pdf/tcpdf.php');
        $userId  = base64_decode($this->uri->segment(3));
        if($userId)
        {
            $this->load->library('pdf/tcpdf');            
            // create new PDF document
            $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

            // set document information
            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetAuthor('Security App');
            $pdf->SetTitle('Employee Detail');
            $pdf->SetSubject('Employee');
            $pdf->SetKeywords('Bio Data, Experience, Skills, Educations/Qualifications, Bank/Financial Details');

            // set default header data
            $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' Employee Details', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
            $pdf->setFooterData(array(0,64,0), array(0,64,128));

            // set header and footer fonts
            $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
            $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));            

            // set margins
            $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
            $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
            $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

            // set auto page breaks
            $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

            
            $pdf->SetFont('dejavusans', '', 10, '', true);
            
            //page first
            $pdf->AddPage();
            $userData       = $this->um->getUserDetailsByUserId($userId);
            $html = '<h1>Bio-Data</h1>';
            if(count($userData)>0)
            {
                //print_r($userData);
                $html .= '<span>Employee Name:-</span>'.'<span style="margin-left:12px;">'.$userData->first_name.' '.$userData->last_name.'<span><br/>';
                $html .= '<span>Father Name  :-</span>'.'<span style="margin-left:12px;">'.$userData->father_name.'<span><br/>';
                $html .= '<span>Date of Birth:-</span>'.'<span style="margin-left:12px;">'.$userData->dob.'<span><br/>';
                $html .= '<span>Age          :-</span>'.'<span style="margin-left:12px;">'.$userData->age.'<span><br/>';
                $html .= '<span>Mobile       :-</span>'.'<span style="margin-left:12px;">'.$userData->mobile.'<span><br/>';
                $html .= '<span>Local Address:-</span>'.'<span style="margin-left:12px;">'.$userData->l_address.', '.$userData->l_city.', '.$userData->l_state.', '.$userData->l_zip.'<span><br/>';
                $html .= '<span>Per Address:-</span>'.'<span style="margin-left:12px;">'.$userData->p_address.', '.$userData->p_city.', '.$userData->p_state.', '.$userData->p_zip.'<span><br/>';                
                $html .= '<span>E-mail:-</span>'.'<span style="margin-left:12px;">'.$userData->email.'<span><br/>';
                $html .= '<span>Army No:-</span>'.'<span style="margin-left:12px;">'.$userData->army_number.'<span><br/>';
                $html .= '<span>Rank       :-</span>'.'<span style="margin-left:12px;">'.$userData->rank.'<span><br/>';
                $date_of_retirement = ($userData->date_of_retirement != '0000-00-00') ?$userData->date_of_retirement:'';
                $html .= '<span>Date of Retirement       :-</span>'.'<span style="margin-left:12px;">'.$date_of_retirement.'<span><br/>';                
            }
            $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);            
            $pdf->lastPage();
            
            //page second            
            $pdf->AddPage();            
            $employeeSkillData  = $this->um->getSkillDetailById($userId);            
            $html = '<h1>Experince/Skills/Education</h1>';
            if(count($employeeSkillData)>0)
            {
                $html .= '<span>Educations:-</span>'.'<span style="margin-left:12px;">'.$employeeSkillData->qualification_id.'<span><br/>';
                $html .= '<span>Qualifications  :-</span>'.'<span style="margin-left:12px;">'.$employeeSkillData->qualification_id.'<span><br/>';
                $html .= '<span>Language Known:-</span>'.'<span style="margin-left:12px;">'.$employeeSkillData->language_known.'<span><br/>';
                $html .= '<span>Ref Name 1          :-</span>'.'<span style="margin-left:12px;">'.$employeeSkillData->ref_name_1.'<span><br/>';
                $html .= '<span>Ref Add 1        :-</span>'.'<span style="margin-left:12px;">'.$employeeSkillData->ref_add_1.'<span><br/>';
                $html .= '<span>Ref Designation 1:-</span>'.'<span style="margin-left:12px;">'.$employeeSkillData->ref_des_1.'<span><br/>';
                $html .= '<span>Ref Name 2:-</span>'.'<span style="margin-left:12px;">'.$employeeSkillData->ref_name_1.'<span><br/>';                
                $html .= '<span>Ref Add 2:-</span>'.'<span style="margin-left:12px;">'.$employeeSkillData->ref_add_1.'<span><br/>';
                $html .= '<span>Ref Designation 2:-</span>'.'<span style="margin-left:12px;">'.$employeeSkillData->ref_des_2.'<span>';                
            }
            $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);            
            $pdf->lastPage();
            
            //page third
            $pdf->AddPage(); 
            $employeeSkillData  = $this->um->getSkillDetailById($userId);
            $html = '<h1>Bank/Financial Details</h1>';
            if(count($employeeSkillData)>0)
            {
                $html .= '<span>Bank Name:-</span>'.'<span style="margin-left:12px;">'.$employeeSkillData->bank_name.'<span><br/>';
                $html .= '<span>Branch  :-</span>'.'<span style="margin-left:12px;">'.$employeeSkillData->branch_name.'<span><br/>';
                $html .= '<span>IFSC Code:-</span>'.'<span style="margin-left:12px;">'.$employeeSkillData->ifsc_code.'<span><br/>';
                $html .= '<span>Account Number:-</span>'.'<span style="margin-left:12px;">'.$employeeSkillData->account_number.'<span><br/>';
                $html .= '<span>PF Account Number:-</span>'.'<span style="margin-left:12px;">'.$employeeSkillData->pf_account_number.'<span><br/>';
                $html .= '<span>ESIC Account Number:-</span>'.'<span style="margin-left:12px;">'.$employeeSkillData->esic_account_number.'<span><br/>';
                $html .= '<span>ESIC Smart Card Number:-</span>'.'<span style="margin-left:12px;">'.$employeeSkillData->esic_smart_card_number.'<span><br/>';
            }
            $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
            $pdf->lastPage();
                    
            //page fourth
            $pdf->AddPage();
            $employee_id = $employeeSkillData->employee_id;
            $documentData = $this->um->getEmployeeDocByEmployeeId($employee_id);            
            $html = '<h1>Document Details</h1>';             
            for($i=0;$i<count($documentData);$i++)
            {
                $html .= $documentData[$i]->document_type.' '.$documentData[$i]->document_content.' '.$documentData[$i]->document_url.'<br/>';
            }               
            $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
            $pdf->lastPage();
            $pdf->Output('Employee_'.$userData->first_name.' '.$userData->last_name.'.pdf', 'D');
        }
    }
    
    function markVerifyDoc()
    {    
        $response = array('message'=>'Request Failed','status'=>'0');      
            
    	if(isset($_REQUEST['verify_status']) && !empty($_REQUEST['documentId']))
    	{
            $userInfo = $this->um->getUserSession();
            //'verified_by'=>$userInfo->user_id, 
            if($userInfo)
            {
                    $dataArr =array('status'=>$_REQUEST['verify_status']);
                    $condition = array("employee_document_id"=>trim($_REQUEST['documentId']));
                    $this->cmm->update($dataArr,$condition,'employee_document');
                    $response = array('message'=>'','status'=>'1');
            }
    	}
    	echo json_encode($response);
    }
    /*END FUNCTIONS FOR USER ADD/EDIT LIST */        
    
    function changePassword(){
        $this->um->checkLoginSession();
        $head = 'Change Password';
        $oldPassword    = '';
        $newPassword    = '';
        $confirmPassword= '';
        if($this->input->post())
        {
            if($this->input->post('old_password')){
                $oldPassword    =   trim($this->input->post('old_password'));
            }
            if($this->input->post('new_password')){
                $newPassword    = $this->input->post('new_password');
            }
            if($this->input->post('confirm_password')){
                $confirmPassword  =   trim($this->input->post('confirm_password'));
            }
            if($this->_validation_change_password() == TRUE){
                $dataArr['password']    =  md5($newPassword);
                $condition  = array('user_id'    => $this->user->user_id);
                $this->cmm->update($dataArr,$condition,'user');
                $this->session->set_flashdata('successMessage', 'Password changed successfully.');
                redirect("user/changePassword/");
            }
        }
        
        //$vars['guard_ids']   =   $companyId;
        $vars['old_password']       =   $oldPassword;
        $vars['new_password']       =   $newPassword;
        $vars['confirm_password']   =   $confirmPassword;
        $vars['title']        = $head;
        $vars['pageHeading']  = $head;
        $vars['contentView']  = 'change_password';
        $this->load->view('inner_template', $vars);       
        
    }
    
    function _validation_change_password(){
        $this->form_validation->set_rules('old_password', 'Old Password','trim|required|callback_checkOldPassword');
        $this->form_validation->set_rules('new_password','New Password','trim|required');
        $this->form_validation->set_rules('confirm_password', 'Confirm Password','trim|required|matches[new_password]');
        $this->form_validation->set_error_delimiters('<span class="error">','</span>');
        return $this->form_validation->run();
    }
    
    function checkOldPassword(){
        $old_password = $this->input->post('old_password');  
        if($this->um->checkOldPassword($this->user->user_id,  md5($old_password)))
          return True;
        else {
          $this->form_validation->set_message('checkOldPassword', 'Invalid old Password.');
          return False;
        }
    }
    
    function forgotPassword(){
        $head   = 'Forgot Password';
        $email   = '';
        if($this->input->post())
        {
            if($this->input->post('email')){
                $email    =   trim($this->input->post('email'));
            }
            if($this->_validation_forgot_password() == TRUE){
                $subject    = 'Bluescan | Reset Password'; 
               
                $userData   = $this->um->getUserByEmail($email); 
                $date=date("Y-m-d H:i:s");
		$encode=  base64_encode(mt_rand(99,1000)."|".$date."|".$userData->user_id."|".$userData->email."|".mt_rand(1000,9999));
                $url        =  site_url('user/resetPassword/'.$encode);
                $content    = "Dear ".$userData->first_name.' '.$userData->last_name.',<br/><br/>';
                $content    .= 'Please follow the below link to change your password -</br><a target="blank" href="'.$url.'">'.$url.'</a><br/><br/>';
                $content    .= 'Thanks & Regards<br/>BlueScan Team<br/><a href="'.site_url().'">'.site_url().'</a>';
                
                $to_email       = $userData->email;
                $sentFlag       = $this->cmm->sendMail($to_email,$subject,$content);
                $updatesArr     = array('encrypted_code' => $encode);
                $condition      = array('user_id' => $userData->user_id);
                $this->cmm->update($updatesArr,$condition,'user');
                $this->session->set_flashdata('successMessage', 'Please check, Link has been sent to your email to reset password.'); 
                redirect("user/forgotPassword/");
            }
        }
        
        $vars['email']       =   $email;
        $vars['title']        = $head;
        $vars['pageHeading']  = $head;
        $vars['contentView']  = 'forgot_password';
        $this->load->view('forgot_password', $vars);       
    }
    
    function _validation_forgot_password(){
        $this->form_validation->set_rules('email', 'Email','trim|required|callback_checkEmailForForgotPassword');
        $this->form_validation->set_error_delimiters('<span class="loginerror">','</span>');
        return $this->form_validation->run();
    }
    
    function checkEmailForForgotPassword(){
        $email = $this->input->post('email');  
        if($this->um->checkEmailForForgotPassword(trim($email)))
          return True;
        else {
          $this->form_validation->set_message('checkEmailForForgotPassword', 'Invalid Email Id. Please try again.');
          return False;
        }
    }
    
    
    function resetPassword(){
        $encode = $this->uri->segment(3);
        if($this->input->post('url')){
            $encode = $this->input->post('url');
        }
        $getData = explode("|",base64_decode($encode));
        $user_id=$getData[2];
        $email_id=$getData[3];
        $user_data  = $this->um->getUserDetailsByUserId($user_id);
        if(trim($user_data->email)!=trim($email_id) || $user_data->encrypted_code != $encode){
            $this->session->set_flashdata('errorMessage', 'Invalid Reset Password URL');                        
            redirect("user/login");
        }
        if($this->input->post()){
            if($this->_submit_reset_validate() === TRUE){
                $updateArr  = array('password' => md5($this->input->post('new_password')),
                                    'encrypted_code'    => '');
                $condition  = array('user_id'   => $user_data->user_id);
                $this->cmm->update($updateArr,$condition,'user');
                $this->session->set_flashdata('successMessage', 'Password reset successfully.');                        
                redirect("user/login");
                   
            }
        }
        $vars['url'] = $encode;  
        $this->load->view('reset_password', $vars);
    }
	
    public function _submit_reset_validate() {
        $this->form_validation->set_rules('new_password', 'Password','trim|required');
        $this->form_validation->set_rules('confirm_password', 'Confirm password','trim|required|matches[confirm_password]');
         $this->form_validation->set_error_delimiters('<span class="loginerror">','</span>');
        return $this->form_validation->run();
    }
    
    function card(){
        $userId = base64_decode($this->uri->segment(3));
        if(isset($userId)&&!empty($userId)){
            $bioData            = $this->um->getUserDetailsByUserId($userId);
            $employee_id        = $bioData->employee_id;
            //print_r($bioData);die;
            $vars['bioData']           = $bioData; 
            $vars['title']     = 'Employee Card'; 
            $this->load->view('employee_card', $vars);
        }
    }
    
    public function profile(){
        $userId = base64_decode($this->uri->segment(3));
        if(isset($userId)&&!empty($userId)){
            $bioData            = $this->um->getUserDetailsByUserId($userId);
            $employee_id        = $bioData->employee_id;
            $qualificationData  = $this->um->getQualificationByEmployeeId($employee_id);         
            $skillData          = $this->um->getSkillDetailByEmployeeId($employee_id);
            $experienceData     = $this->um->getExperienceDetailByEmployeeId($employee_id);
            //print_r($experienceData);die;
            $vars['bioData']           = $bioData; 
            $vars['qualificationData']  = $qualificationData; 
            $vars['skillData']          = $skillData; 
            $vars['experienceData']     = $experienceData; 
            $vars['title']     = 'Employee Profile'; 
            $this->load->view('employee_profile', $vars);
        }
        
    }
}