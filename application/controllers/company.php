<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Company extends CI_Controller
{
    public $user;
    function  __construct(){
        parent::__construct();
        $this->user =	unserialize($this->session->userdata('users'));
        $this->tasks =	unserialize($this->session->userdata('tasks'));
        $this->qc = $this->queryconstant;
        $this->load->model('usermanager');
        $this->load->model('companymanager');
        $this->load->model('commonmanager');
        $this->um  = $this->usermanager;
        $this->cm = $this->companymanager;
        $this->cmn = $this->commonmanager;
        $this->qc = $this->queryconstant;
        session_start();
        $this->um->checkLoginSession();
        $this->cmn->checkSetSessionForRoleBasedSecurity();
        $this->load->library('paginator');
        
    }

    

/*START FUNCTIONS FOR COMPANIES ADD/EDIT LIST */
    function index(){  
        $where  = '';
        $companyId  = $this->session->userdata('session_company_id');
        if($this->user->role_code == 'cadmin' || $this->user->role_code == 'cuser' || ($this->user->role_code == 'sadmin' && $companyId != '') ){
           
            if(isset($companyId) && !empty($companyId)){
                $where  = ' WHERE c.company_id = '.$companyId.' ';
            }
        }
        $cur_page = $this->input->post('page') ? $this->input->post('page') : 1;
        $perPage  = $this->config->item('perPage');
        $vars['perPage']   = $perPage;
        $vars['page']      = $cur_page;
        $offset = ($cur_page*$perPage)-$perPage;
        $count  = $this->cm->getAllCompanyPageList($where,$offset,$perPage,true);
        $vars['total_record']   = $count;
        $pages  = new paginator($count, $perPage, $cur_page);
        $vars['pagination'] = $pages;
              
        $companyData        = $this->cm->getAllCompanyPageList($where,$offset,$perPage,false);
        $vars['companyData']= $companyData;
        $vars['mainTab']    = "company";
        $vars['title']      = 'Company List';
        $vars['contentView']= 'company_list';
        $this->load->view('inner_template', $vars);
    }
    
    function addEditCompany()
    {
        $head = 'Add';
        $companyId  = '';
        $companyName= '';
        $address    = '';
        $city       = '';
        $country    = '';
        $state      = '';
        $email      = '';
        $website    = '';
        $contact_person	= '';
        $contact_number = '';
        $liecense_code  = '';
        $zipcode        = '';
        $is_published   = 1;
        $companyId  = base64_decode($this->uri->segment(3));
        $validFrom  = '';
        $validTo   = '';
        $threshold_value1 = '';
        $threshold_value2 = '';
        $image_url  = '';
        $error  = '';
        if(isset($companyId)&&!empty($companyId))
        {
            $head = 'Edit';
            $companyData    = $this->cm->getCompanyDetailsByCompId($companyId);
            //print_r($companyData);
            $companyName    = $companyData->company_name;
            $address        = $companyData->address;
            $city           = $companyData->city;
            $country        = $companyData->country;
            $state          = $companyData->state;
            $email          = $companyData->email_id;
            $website        = $companyData->website;
            $contact_person = $companyData->contact_person;
            $contact_number = $companyData->contact_number;
            $liecense_code  = $companyData->license_code;
            $zipcode        = $companyData->zipcode;
            $is_published   = $companyData->is_published;
            $validFrom      = $companyData->valid_from;
            $image_url      = $companyData->company_logo_url;
            $validTo   = $companyData->valid_to;
            $threshold_value1 = $companyData->delta_threshold_start;
             $threshold_value2 = $companyData->delta_threshold_end;
        }
        if($this->input->post())
        {
            if($this->input->post('company_name')){
                $companyName    =	trim($this->input->post('company_name'));
            }
            if($this->input->post('address')){
                $address	=	trim($this->input->post('address'));
            }
            if($this->input->post('city')){
                $city           =	trim($this->input->post('city'));
            }
            if($this->input->post('country')){
                $country	=	trim($this->input->post('country'));
            }
            if($this->input->post('state')){
                $state          =	trim($this->input->post('state'));
            }
            if($this->input->post('email')){
                $email      	=	trim($this->input->post('email'));
            }
            if($this->input->post('website')){
                $website	=	trim($this->input->post('website'));
            }
            if($this->input->post('contact_person')){
                $contact_person	=	trim($this->input->post('contact_person'));
            }
            if($this->input->post('contact_number')){
                    $contact_number	=	trim($this->input->post('contact_number'));
            }
            if($this->input->post('license_code')){
                    $liecense_code	=	trim($this->input->post('license_code'));
            }
            if($this->input->post('zipcode')){
                    $zipcode	=	trim($this->input->post('zipcode'));
            }
            if($this->input->post('threshold_value1')){
                $threshold_value1 = $this->input->post('threshold_value1');
            }
             if($this->input->post('threshold_value2')){
                $threshold_value2 = $this->input->post('threshold_value2');
            }
            
            if($this->_validation_company($companyId) == TRUE){
                $error = '';
                if(!empty($_FILES['img_upload']['name'])){                    
                    $message = '';
                    $file_name = '';
                    $config = $this->config->item('company_images');
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
                       // print_r($upload_data);die;
                        $dest   = $this->config->item('company_profile_images').$file_name;
                        $config =  $this->config->item('company_images_thumb');
                        $thumbDest  =   $this->config->item('company_images_thumb_path');
                        if($file_name){
                             $config['source_image']  = $dest;
                             $this->load->library('image_lib',$config);
                             $this->image_lib->initialize($config);

                             if (!$this->image_lib->resize()){
                                echo $error = $this->upload->display_errors();                                 
                             }else{
                                 $message = "Image uploaded sucessfully!";
                             }
                         }
                        $old_image_url  = $image_url;
                        $image_url = $upload_data['file_name'];
                        if(isset($image_url)&&!empty($image_url)){
                            if(isset($old_image_url)&&!empty($old_image_url)){
                                unlink($thumbDest.$old_image_url);
                                 unlink($dest. $old_image_url);
                            }
                           
                        }
                        
                        if(isset($image_url)&&!empty($image_url)){
                            $companyLogoUrl = $this->config->item('company_profile_images');
                            $this->session->set_userdata('session_company_logo', site_url($companyLogoUrl.'/'.$image_url));
                        }
                    } 
                    
                }
                
                
                if($error == ''){ 
                    $dataArr	= array('company_name'   => $companyName,
                                    'address'		     => $address,
                                    'city'               => $city,
                                    'country'		     => $country,
                                    'state'              => $state,
                                    'email_id'           => $email,
                                    'website'            => $website,
                                    'contact_person' 	 => $contact_person,
                                    'contact_number' 	 => $contact_number,
                                    'zipcode'            => $zipcode,
                                    'is_published'       => $is_published,
                                    'delta_threshold_start' => $threshold_value1,
                                    'delta_threshold_end'   => $threshold_value2,
                                    'company_logo_url'  => $image_url
                    );
                    
                   //    print_r($dataArr);die;
                    
                    if(isset($companyId) && !empty($companyId)){

                            log_message('info', 'Update Company data : '.print_r($dataArr,true));
                            $condition	= array('company_id'	=> $companyId);
                            $this->cmn->update($dataArr,$condition,'company');
                            $this->session->set_flashdata('successMessage', 'Company updated successfully.');
                            //redirect("project/addEditProject/".base64_encode($projectId));
                            redirect("company");
                    }else{
                            $dataArr['license_code_id'] = $liecense_code;
                            log_message('info', 'Insert Company data : '.print_r($dataArr,true));
                            $this->cmn->insert($dataArr,'company');
                            $this->session->set_flashdata('successMessage', 'Company added successfully.');
                            redirect("company");
                    }
                }
            }
        }
        
        $vars['error_message']  = $error;
        $vars['companyId']      = $companyId;
        $vars['licenseData']  = $this->cm->getAllCompanyLicenseList();
        $vars['companyName']  = $companyName;
        $vars['address']      = $address;
        $vars['city']         = $city;
        $vars['country']      = $country;
        $vars['state']        = $state;
        $vars['email']        = $email;
        $vars['website']      = $website;
        $vars['contact_person']  = $contact_person;
        $vars['contact_number']  = $contact_number;
        $vars['liecense_code']   = $liecense_code;
        $vars['zipcode']      = $zipcode;
        $vars['valid_from']      = $validFrom;
        $vars['valid_to']      = $validTo;
        $vars['threshold_value1'] = $threshold_value1;
        $vars['threshold_value2'] = $threshold_value2;
        $vars['image_url']  = $image_url;

        $vars['mainTab']    = "company";
        $vars['title']        = $head.' Company';
        $vars['pageHeading']  = $head.' Company';
        $vars['contentView']  = 'add_edit_company';
        $this->load->view('inner_template', $vars);        
    }
    
    
    function _validation_company($companyId){
        $this->form_validation->set_rules('company_name','Company Name','trim|required');
        $this->form_validation->set_rules('address', 'Address','trim|required');
        $this->form_validation->set_rules('city','City','trim|required|alpha_space');
        $this->form_validation->set_rules('state','State','trim|required');
        $this->form_validation->set_rules('country','Country','trim|required|alpha_space');
        $this->form_validation->set_rules('contact_person','Contact Person','trim|required');
        $this->form_validation->set_rules('contact_number','Contact Number','trim|required|numeric');
        $this->form_validation->set_rules('email','Email','trim|required|valid_email');
        if(empty($companyId)){
            $this->form_validation->set_rules('license_code','Liecense Code','trim|required');
        }
        $this->form_validation->set_rules('threshold_value1','Delta Start Limit','trim|required|is_natural_no_zero|callback_compareDelta');
        $this->form_validation->set_rules('threshold_value2','Delta End Limit','trim|required|is_natural_no_zero');
        $this->form_validation->set_rules('website','Website','trim');
        $this->form_validation->set_rules('zipcode','ZipCode','trim');
        $this->form_validation->set_error_delimiters('<span class="error">','</span>');        
        return $this->form_validation->run();
    }
    
    function compareDelta($str) {
        $startlimit = $this->input->post('threshold_value1');  
        $endlimit = $this->input->post('threshold_value2');  
       
        if($endlimit > $startlimit)
          return True;
        else {
          $this->form_validation->set_message('compareDelta', '%s should be greater than Delta Start Limit.');
          return False;
        }
    }
    
/*END FUNCTIONS FOR COMPANIES ADD/EDIT LIST */
/*START FUNCTIONS FOR COMPANY OFFICES ADD/EDIT LIST */

    function company_office_list()
    {
        $companyId  = base64_decode($this->uri->segment(3));
        $cur_page = $this->input->post('page') ? $this->input->post('page') : 1; 
        $perPage  = $this->config->item('perPage');
        $vars['perPage']   = $perPage;
        $vars['page']      = $cur_page;
        $offset = ($cur_page*$perPage)-$perPage;
        $count  = $this->cm->getAllCompanyOfficeListById($companyId,$offset,$perPage,true);
        $vars['total_record']   = $count;
        $pages  = new paginator($count, $perPage, $cur_page);
        $vars['pagination'] = $pages;
        
        $vars['companyData']   = $this->cm->getAllCompanyOfficeListById($companyId,$offset,$perPage,false);        
        $vars['companyId']     = $companyId;        
        $vars['title']         = 'Company Office List';
        $vars['company_name']  = $this->cm->getCompanyDetailsByCompId($companyId)->company_name;
        $vars['contentView']   = 'company_office_list';
        $this->load->view('inner_template', $vars);
    }

    function addEditCompanyOffice()
    {       
        $head               = 'Add';
        $companyId          = '';
        $companyName        = '';
        $office_id          = '';
        $office_address     = '';
        $office_zipcode     = '';
        $office_city        = '';
        $office_contact_number = '';
        $office_contact_person = '';
        $office_email       = '';
        $is_published        = 1;
        $companyId          = base64_decode($this->uri->segment(3));
        $companyName        = $this->cm->getCompanyDetailsByCompId($companyId)->company_name;
        $office_id          = base64_decode($this->uri->segment(4));

        if(isset($office_id)&&!empty($office_id))
        {
            $head = 'Edit';
            $companyData   = $this->cm->getCompanyOfficeDetailsByOfficeId($office_id);            
            $office_address        = $companyData->address;
            $office_city           = $companyData->city;
            $office_email          = $companyData->email_id;            
            $office_contact_person = $companyData->contact_person;
            $office_contact_number = $companyData->contact_number;            
            $office_zipcode        = $companyData->zipcode;
            $is_published          = $companyData->is_published;
        }

        
        if($this->input->post())
        {            
            if($this->input->post('office_address')){
                $office_address    =   trim($this->input->post('office_address'));
            }
            if($this->input->post('office_city')){
                $office_city           =   trim($this->input->post('office_city'));
            }            
            if($this->input->post('office_email')){
                $office_email          =   trim($this->input->post('office_email'));
            }
            if($this->input->post('office_contact_person')){
                $office_contact_person =   trim($this->input->post('office_contact_person'));
            }
            if($this->input->post('office_contact_number')){
                    $office_contact_number =   trim($this->input->post('office_contact_number'));
            }
            if($this->input->post('office_zipcode')){
                    $office_zipcode    =   trim($this->input->post('office_zipcode'));
            }
            if($this->_validation_company_office() == TRUE){
                $dataArr    = array('company_id'    => $companyId,
                                'address'           => $office_address,
                                'city'              => $office_city,
                                'email_id'          => $office_email,
                                'contact_person'    => $office_contact_person,
                                'contact_number'    => $office_contact_number,
                                'zipcode'           => $office_zipcode,
                                'is_published'      => $is_published
                );
                if(isset($office_id) && !empty($office_id))
                {
                        log_message('info', 'Update Company Office data : '.print_r($dataArr,true));
                        $condition  = array('company_office_id'    => $office_id);
                        $this->cmn->update($dataArr,$condition,'company_office');
                        $this->session->set_flashdata('successMessage', 'Company Office updated successfully.');
                        $companyId = base64_encode($companyId);
                        $office_id = base64_encode($office_id);
                        redirect("company/company_office_list/$companyId/$office_id");
                }
                else
                {
                        log_message('info', 'Insert Company data : '.print_r($dataArr,true));
                        $this->cmn->insert($dataArr,'company_office');
                        $this->session->set_flashdata('successMessage', 'Company office added successfully.');
                        $companyId=base64_encode($companyId);
                        redirect("company/company_office_list/$companyId");
                }
            }
        }               
        
        $vars['company_name']  = $companyName;
        $vars['office_address']  = $office_address;
        $vars['office_city']  = $office_city;        
        $vars['office_email']  = $office_email;        
        $vars['office_contact_person']  = $office_contact_person;
        $vars['office_contact_number']  = $office_contact_number;        
        $vars['office_zipcode']  = $office_zipcode;
        $vars['title']      = $head.' Company Office';
        $vars['pageHeading']= $head.' Company Office';
        $vars['contentView']= 'add_edit_company_office';
        $this->load->view('inner_template', $vars);
    }
    
    function _validation_company_office(){
        $this->form_validation->set_rules('office_address', 'Address','trim|required');
        $this->form_validation->set_rules('office_city','City','trim|required|alpha');
        $this->form_validation->set_rules('office_zipcode','ZipCode','trim');
        $this->form_validation->set_rules('office_email','Email','trim|required|valid_email');
        $this->form_validation->set_rules('office_contact_person','Contact Person','trim|required');
        $this->form_validation->set_rules('office_contact_number','Contact Number','trim|required');        
        $this->form_validation->set_error_delimiters('<span class="error">','</span>');
        return $this->form_validation->run();
    }
    

    function manageCompany(){
        $companyId = base64_decode($this->uri->segment(3));
        if($this->cmn->checkSetSessionForRoleBasedSecurity($companyId)){
            redirect('user/dashboard');
        }
    }    
    
    
    function employeeExperienceList(){
        $companyId  = base64_decode($this->uri->segment(3));
        $cur_page = $this->input->post('page') ? $this->input->post('page') : 1; 
        $perPage  = $this->config->item('perPage');
        $vars['perPage']   = $perPage;
        $vars['page']      = $cur_page;
        $offset = ($cur_page*$perPage)-$perPage;
        $count  = $this->cm->getAllEmployeeExperienceListById($companyId,$offset,$perPage,true);
        $vars['total_record']   = $count;
        $pages  = new paginator($count, $perPage, $cur_page);
        $vars['pagination'] = $pages;
        
        $vars['companyData']   = $this->cm->getAllEmployeeExperienceListById($companyId,$offset,$perPage,false);        
        $vars['companyId']     = $companyId;        
        $vars['title']         = 'Employee Experience List';
        $vars['company_name']  = $this->cm->getCompanyDetailsByCompId($companyId)->company_name;
        $vars['contentView']   = 'company_employee_experience';
        $this->load->view('inner_template', $vars);
    }

/*END FUNCTIONS FOR COMPANY OFFICES ADD/EDIT LIST*/

}