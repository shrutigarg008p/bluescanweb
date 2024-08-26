<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Customer extends CI_Controller
{
    public $um;
    public $cm;
    public $cmm;
    public $qc;
    public $sm;
    public $gd;
    public $cust;
    public $user;
    
    function  __construct(){
        parent::__construct();
        $this->qc = $this->queryconstant;
        $this->load->model('usermanager');
        $this->load->model('companymanager');
        $this->load->model('commonmanager');
        $this->load->model('customermanager');
        $this->um  = $this->usermanager;
        $this->cm  = $this->companymanager;
        $this->cmm = $this->commonmanager;
        $this->qc  = $this->queryconstant;
        $this->cust= $this->customermanager;
        $this->user =	unserialize($this->session->userdata('users'));
        session_start();
        $this->um->checkLoginSession();
        $this->cmm->checkSetSessionForRoleBasedSecurity();
        //echo  $this->session->userdata('session_company_id'); die;
        $this->load->library('paginator');
        
    }
    
     function index(){ 
        $companyId  = $this->session->userdata('session_company_id');       
        $where  = '';
        if($this->input->post()){
            if($this->input->post('company_id')){
                $companyId = trim($this->input->post('company_id'));
                $where = $where.' and cust.company_id = '.$companyId;
            }else{
                $companyId  = $this->session->userdata('session_company_id'); 
                $where = $where.' and cust.company_id = '.$companyId;
            }
        }else{
            $where = $where.' WHERE cust.company_id = '.$companyId;
        }

        $search_result = trim($this->input->post('search_result'));
        if (!empty($search_result)) {
            
            $where = $where." WHERE cust.email LIKE '%".$search_result."%' OR cust.first_name LIKE '%".$search_result."%' OR c.company_name LIKE '%".$search_result."%' OR cust.address LIKE '%".$search_result."%'";

               $cur_page = 1;             
        }else{
        $cur_page = $this->input->post('page') ? $this->input->post('page') : 1;         
        }
        
        $perPage  = $this->config->item('perPage');
        $vars['perPage']   = $perPage;
        $vars['page']      = $cur_page;
        $offset = ($cur_page*$perPage)-$perPage;
        
        $count  = $this->cust->getAllCustomerList($where,$offset,$perPage,true);
        $vars['total_record']   = $count;
        $pages  = new paginator($count, $perPage, $cur_page);
        $vars['pagination'] = $pages;

        $customerData        = $this->cust->getAllCustomerList($where,$offset,$perPage,false);       
        $vars['companyDropDown'] = $this->cm->getAllCompanyList($companyId);
        $vars['customerData']= $customerData;
        $vars['f_company_id']= $companyId;
        $vars['title']      = 'Customer List';
        $vars['contentView']= 'customer_list';
        $vars['mainTab']    = "customer";
        $this->load->view('inner_template', $vars);
    }
    
    function addEditCustomer(){
        //''
        $head = 'Add';
        $first_name = '';
       // $last_name  = '';
        $customerId = '';
        $companyId  = '';
        $address    = '';
        $phone      = '';
        $mobile     = '';
        $relational_contact = '';
        $billing_contact    = '';
        $referring_party    = '';
        $general_notes      = '';
        $email      = '';
        $website    = '';
        $engagement_notes   = '';
        $date_of_engagement = '';        
        $created_by         = '';
        $created_date       = '';
        $zip                = '';
        $is_company_notification_send  = '';
        $system_id = '';
        $status                = 1;
        $customerId  = base64_decode($this->uri->segment(3));
        $companyId    = $this->session->userdata('session_company_id');
        if(isset($customerId)&&!empty($customerId))
        {
            // echo 'edit';die;
            $head = 'Edit';
            $customerData   = $this->cust->getCustomerDetailsByCustomerId($customerId);
        //echo "<pre>";print_r($customerData->is_company_notification_send);die;
            $first_name     = $customerData->first_name;
           // $last_name      = $customerData->last_name;
            $companyId      = $customerData->company_id;
            $address        = $customerData->address;
            $phone          = $customerData->phone;
            $mobile         = $customerData->mobile;
            $email          = $customerData->email;
            $website         = $customerData->website;
            $relational_contact = $customerData->relational_contact;
            $billing_contact    = $customerData->billing_contact;
            $referring_party    = $customerData->referring_party;
            $engagement_notes   = $customerData->engagement_notes;
            $date_of_engagement = $customerData->date_of_engagement;
            $general_notes      = $customerData->general_notes;
            $created_by         = $customerData->created_by;
            $created_date       = $customerData->created_date;
            $zip                = $customerData->zip;
            $status             = $customerData->status;
            $system_id             = $customerData->system_id;
            $is_company_notification_send  = $customerData->is_company_notification_send;
        }
        
        if($this->input->post())
        {
            // echo 'post';die;
            if($this->input->post('first_name')){
                $first_name = trim($this->input->post('first_name'));
            }
           /* if($this->input->post('last_name')){
                $last_name  = trim($this->input->post('last_name'));
            } */
            if($this->input->post('company_id')){
                $companyId  = trim($this->input->post('company_id'));
            }
            if($this->input->post('address')){
                $address    = trim($this->input->post('address'));
            }
            if($this->input->post('phone')){
                $phone      = trim($this->input->post('phone'));
            }
            if($this->input->post('mobile')){
                $mobile	    =	trim($this->input->post('mobile'));
            }
            if($this->input->post('email')){
                $email      = trim($this->input->post('email'));
            }
            if($this->input->post('website')){
                $website     =   trim($this->input->post('website'));
            }
            if($this->input->post('zip')){
                $zip        =	trim($this->input->post('zip'));
            }
            
            if($this->input->post('relational_contact')){
                $relational_contact  =	trim($this->input->post('relational_contact'));
            }
            if($this->input->post('billing_contact')){
                $billing_contact = trim($this->input->post('billing_contact'));
            }
            if($this->input->post('referring_party')){
                $referring_party = trim($this->input->post('referring_party'));
            }
            if($this->input->post('engagement_notes')){
                $engagement_notes = trim($this->input->post('engagement_notes'));
            }
            if($this->input->post('date_of_engagement')){
                $date_of_engagement =  trim($this->input->post('date_of_engagement'));
            }
            
            if($this->input->post('general_notes')){
                $general_notes	= trim($this->input->post('general_notes'));
            }
            
            if($this->input->post('created_date')){
                $created_date	= trim($this->input->post('created_date'));
            }

            if($this->input->post('system_id') && !empty($this->input->post('system_id'))){
                $system_id        =   trim($this->input->post('system_id'));
            }else
            {
                 $system_id=0; 
            }

            if($this->input->post('is_company_notification_send')  && !empty($this->input->post('is_company_notification_send'))){
                $is_company_notification_send   = trim($this->input->post('is_company_notification_send'));
            }else
            {
                 $is_company_notification_send=0; 
            }
            
            
           if(empty($customerId)){
                $userSession    = $this->um->getUserSession();
                $created_by   =  $userSession->user_id;
           }
            
              // echo 'post';die;
            
            if($this->_validation_customer() == TRUE){
                // echo 'post';die;
                $dataArr	= array(
                                'first_name'=> $first_name,
                                //'last_name' => $last_name,
                                'company_id'=> $companyId,
                                'address'   => $address,
                                'email'     => $email,
                                'website'   => $website,
                                'phone'     => $phone,
                                'mobile'    => $mobile,
                                'zip'       => $zip ,
                                'system_id'       => $system_id ,
                                'is_company_notification_send' => $is_company_notification_send ,
                                'relational_contact'    => $relational_contact ,
                                'billing_contact'       => $billing_contact ,
                                'referring_party'       => $referring_party,
                                'engagement_notes'      => $engagement_notes ,
                                'date_of_engagement'    => date('Y-m-d',  strtotime($date_of_engagement)),
                                'general_notes'         => $general_notes,
                                'status'                => $status,
                                'created_by'            => $created_by,
                                'created_date'          => $created_date
                );
                if(isset($customerId) && !empty($customerId)){
                     //echo '<pre>';print_r($dataArr);die;
                        log_message('info', 'Update Customer data : '.print_r($dataArr,true));
                        $condition	= array('customer_id'	=> $customerId);
                        $this->cmm->update($dataArr,$condition,'customer');
                        $this->session->set_flashdata('successMessage', 'Customer updated successfully.');
                        //redirect("project/addEditProject/".base64_encode($projectId));
                        redirect("customer");
                }else{
                          // echo '<pre>';print_r($dataArr);die;
                        log_message('info', 'Insert Customer data : '.print_r($dataArr,true));
                        $this->cmm->insert($dataArr,'customer');
                        $this->session->set_flashdata('successMessage', 'Customer added successfully.');
                        redirect("customer");
                }
            }
        }
        
        $vars['companyData'] = $this->cm->getAllCompanyList($companyId);

        $vars['first_name'] = $first_name;
       //$vars['last_name']  = $last_name;
        $vars['companyId']  = $companyId;
        $vars['address']    = $address;
        $vars['email']    = $email;
        $vars['website']    = $website;
        $vars['phone']      = $phone;
        $vars['mobile']     = $mobile;
        $vars['relational_contact'] = $relational_contact;
        $vars['billing_contact']    = $billing_contact;
        $vars['referring_party']    = $referring_party;
        $vars['engagement_notes']   = $engagement_notes;
        $vars['date_of_engagement'] = $date_of_engagement;
        $vars['general_notes']      = $general_notes;
        $vars['created_by']         = $created_by;
        $vars['created_date']       = $created_date;
        $vars['zip']                = $zip;
        $vars['system_id']                = $system_id;
        $vars['is_company_notification_send']  = $is_company_notification_send;
        $vars['title']      = $head.' Customer';
        $vars['pageHeading']= $head.' Customer';
        $vars['mainTab']    = "customer";
        $vars['contentView']= 'add_edit_customer';
        $this->load->view('inner_template', $vars);  
    }
    
    function _validation_customer(){
        if(!$this->session->userdata('session_company_id')){
            $this->form_validation->set_rules('company_id','Company Name','trim|required');
        }
        $this->form_validation->set_rules('first_name','Name','trim|required');
        //$this->form_validation->set_rules('system_id','System Id','trim|required');
       // $this->form_validation->set_rules('last_name','Last Name','trim|required');
        $this->form_validation->set_rules('address', 'Address','trim|required');
        $this->form_validation->set_rules('phone','Phone','trim|numeric');
        $this->form_validation->set_rules('mobile','Mobile','trim|required|numeric');
        $this->form_validation->set_rules('email','Email','trim|valid_email');
        $this->form_validation->set_rules('relational_contact','Primary Contact','trim|required');
        //$this->form_validation->set_rules('referring_party','Referring Party','trim');
        $this->form_validation->set_rules('date_of_engagement','Date of Engagement','trim|required');
        $this->form_validation->set_rules('engagement_notes','Engagement Notes','trim');
        //$this->form_validation->set_rules('general_notes','General Notes','trim');
        $this->form_validation->set_rules('zip','Zip','trim');
        $this->form_validation->set_error_delimiters('<span class="error">','</span>');
        return $this->form_validation->run();
    }
}

