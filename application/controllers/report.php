<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Report extends CI_Controller
{
    public $um;
    public $cmm;
    public $qc;
    public $sm;
    public $ins;
    public $user = '';
    public $cm;
    
    function  __construct(){
        parent::__construct();
         $this->user =	unserialize($this->session->userdata('users'));
        $this->load->dbutil();
        $this->load->helper('file');
        $this->load->helper('download');

        $this->load->library('paginator');

        $this->qc = $this->queryconstant;
        $this->load->model('usermanager');
        $this->load->model('commonmanager');
        $this->load->model('guardmanager');
        $this->load->model('inspectionmanager');
        $this->load->model('sitemanager');
        $this->load->model('regionmanager');
        $this->load->model('branchmanager');
        $this->bm  = $this->branchmanager;
        $this->rm  = $this->regionmanager;
        $this->um   = $this->usermanager;
        $this->cmm  = $this->commonmanager;
        $this->gm  = $this->guardmanager;
        $this->qc   = $this->queryconstant;
        $this->ins  = $this->inspectionmanager;
        $this->sm  = $this->sitemanager;
        $this->user =  unserialize($this->session->userdata('users'));
        $this->load->model('companymanager');
        $this->cm  = $this->companymanager;
        $this->um->checkLoginSession();
    }

    function index(){  

        $this->um->checkLoginSession();
        $companyId  = '';
        $where      = '';
        $csv        = false;
        $start_date = '';//date('Y-m-d');
        $end_date   = '';
        $regionId   = '';
        $branchId   = '';
        $site_id    = '';
        $officer_id = '';   
        
        if($this->uri->segment(3)){
            $condition  = base64_decode($this->uri->segment(3));
            $condArr    = explode('_', $condition);
            if($this->user->role_code == 'sadmin' || $this->user->role_code == 'cuser' || $this->user->role_code == 'cadmin'){
                $companyId  = isset($condArr[0])?$condArr[0]:'';
                $regionId   = isset($condArr[1])?$condArr[1]:'';
                $branchId   = isset($condArr[2])?$condArr[2]:'';
                $site_id    = isset($condArr[3])?$condArr[3]:'';
            }else if($this->user->role_code == 'RM'){
                $regionId   = isset($condArr[0])?$condArr[0]:'';
                $branchId   = isset($condArr[1])?$condArr[1]:'';
                $site_id    = isset($condArr[2])?$condArr[2]:'';
            }else if($this->user->role_code == 'BM'){
                $branchId   = isset($condArr[0])?$condArr[0]:'';
                $site_id    = isset($condArr[1])?$condArr[1]:'';
                
            }else {
                $site_id    = isset($condArr[0])?$condArr[0]:'';
                
            }
            
        }

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
        // echo '<pre>';print_r($branchIds);die;
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
            if($this->input->post('download_csv')){
                $csv = true;
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
         // echo '<pre>';print_r($vars);die;
        if($csv){            
            $this->down_csv($vars['inspInstData'],'site');                          //Download CSV file
        }          
        $vars['getAllcompanyDropdown']  = $this->cm->getAllCompanyList($companyId,$this->user->user_id,$this->user->role_code);
        $vars['getAllRegionDropdown']   = $this->rm->getAllRegionList($companyId,$this->user->user_id,$this->user->role_code);                
        $vars['getAllBranchDropdown']   = $this->bm->getAllBranchList($regionId,$companyId,$this->user->user_id,$this->user->role_code);;
        $vars['getAllSiteDropdown']     = $this->sm->getAllSiteListDropdown($branchId,$companyId,$this->user->user_id,$this->user->role_code);

        $vars['company_id']  = $companyId;
        $vars['region_id']  = $regionId;
        $vars['branch_id']  = $branchId;
        $vars['site_id']  = $site_id;
        
        $vars['fieldOfficerData'] = $this->um->getAllFieldOfficers($siteIds,$companyId,$this->user->user_id,$this->user->role_code);

        $vars['start_date'] = $start_date;
        $vars['end_date']   = $end_date;
        $vars['site_id']    = $site_id;
        $vars['officer_id'] = $officer_id;
        $vars['roleCode']   = $this->user->role_code;

        $vars['title']      = 'Conveyance Report';
        $vars['contentView']= 'conveyance_report';
        $this->load->view('inner_template', $vars);
        
        /*        

        $cur_page = $this->input->post('page') ? $this->input->post('page') : 1; 
        $perPage  = $this->config->item('perPage');
        $vars['perPage']   = $perPage;
        $vars['page']      = $cur_page;        
        $offset = ($cur_page*$perPage)-$perPage;        
        $count  = $this->ins->getConvayenceReport($where,$offset,$perPage,true);        
        if($csv)
        {
            $vars['conveyaceReport']  = $this->ins->getConvayenceReport($where,0,$count,false);
            $this->down_csv($vars['conveyaceReport']);                          //Download CSV file
        }
        $vars['total_record']   = $count;
        $pages  = new paginator($count, $perPage, $cur_page);
        $vars['pagination'] = $pages;  */           
       
    } 

    function down_csv($row,$extra='')
    {
        if($extra == 'guard'){
           $field_array=array('Field Officer','Date','Time','Guard','Survey Response');
        }else if($extra == 'site'){
            $field_array=array('Field Officer','Date','Time','Site','Survey Response','Difference','Distance to');
        }else{
             $field_array=array('Field Officer','Date','Time','location','Survey Response','Reason','Rejected by','Distance to');
        }
        $totalkms = 0;
        $field_array=implode(",",$field_array);
        $field_array.="\n";        
        for($i=0;$i<count($row);$i++)
        {
            $field_array .='"'.$row[$i]->fo_name.'",';
            $field_array .='"'.date('Y-m-d',  strtotime($row[$i]->visiting_time)).'",';
            $field_array .='"'.date('H:i:s',strtotime($row[$i]->visiting_time)).'",';
            if($extra == 'guard'){
                $field_array .='"'.$row[$i]->guard_name.'",';
            }else if($extra == 'site'){
                $field_array .='"'.$row[$i]->site_title.'",';
            }else{
                 $field_array .='"https://www.google.com/maps/place/'.$row[$i]->latitude.','.$row[$i]->longitude.'",';
            }
            
            $field_array .='"'.(empty($row[$i]->total_answer)?'0':$row[$i]->total_answer).' out of '.(empty($row[$i]->total_question)?'0':$row[$i]->total_question).'",';
            if($extra=='site'){
                $field_array .='"'.$row[$i]->delta.'",';
                $field_array .='"'.$row[$i]->distance_to.'",';            
                $field_array .="\n";
                $totalkms+= $row[$i]->distance_to;
            }else if($extra == 'guard'){
                $field_array .="\n";
            }else{
                $field_array .='"'.$row[$i]->rejected_reason.'",';
                $field_array .='"'.$row[$i]->rejected_by_name.'",';
                $field_array .='"'.$row[$i]->distance_to.'",';            
                $field_array .="\n";
                $totalkms+= $row[$i]->distance_to;
            }
        }
        if($extra=='site'){
        $field_array .="\n";
        $field_array .='"Total",'.','.','.','.','.','.'"'.round($totalkms,3).'"';
        }
        if($extra=='rejection'){
        $field_array .="\n";
        $field_array .='"Total",'.','.','.','.','.','.','.'"'.round($totalkms,3).'"';
        }
        if($extra=='site'){
            $filename = "Conveyance_Detail_".date('Y_m_d').".csv";
        } else if($extra == 'guard') {
            $filename = "Guard_Inspection_Detail".date('Y_m_d').".csv";
        }else{
            $filename = "Rejected_Inspection_Detail".date('Y_m_d').".csv";
        }
        
        header('Content-type: application/csv');
        header('Content-Disposition: attachment; filename='.$filename);        
        echo $field_array;
        exit;
    }

    function drillDownReport() {
        $start_date = '';
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
        
        
        if($this->input->post()){            
            if($this->input->post('start_date')) {
                $start_date = trim($this->input->post('start_date'));
            }
        }  
           
        $companyReportData = array();     
        $vars['reportDataByCompany'] = $this->ins->getGildConveyanceReport('company',$start_date,$companyId);        
        $vars['reportDataByRegion']  = $this->ins->getGildConveyanceReport('region',$start_date,$regionIds);
        $vars['reportDataByBranch']  = $this->ins->getGildConveyanceReport('branch',$start_date,$branchIds);
        $vars['reportDataBySite']    = $this->ins->getGildConveyanceReport('site',$start_date,$siteIds);

        if($this->user->role_code=='FO')
        {
            $reportDataBySite    = $this->ins->getGildConveyanceReport('site',$start_date,$siteIds);
            $Fo_data=array();
            foreach ($reportDataBySite as $key => $value)
            {
                if($companyId==$value->company_id)
                {
                    $Fo_data[]=$value;
                }
            }
              $vars['reportDataBySite']=$Fo_data;  
        }else
        {
          $vars['reportDataBySite']    = $this->ins->getGildConveyanceReport('site',$start_date,$siteIds);  
        }
        

        $vars['start_date'] = $start_date;
        $vars['roleCode']   = $this->user->role_code;
        $vars['title']      = 'Drill-Down Report';
        $vars['pagetitle']  = 'Drill-Down Report';
        $vars['contentView']= 'company_report';
        $this->load->view('inner_template', $vars);
    }
    
    function rejectedInspectionReport(){
        $this->um->checkLoginSession();
        $companyId  = '';
        $where      = '';
        $csv        = false;
        $start_date = '';//date('Y-m-d');
        $end_date   = '';
        $regionId   = '';
        $branchId   = '';
        $site_id    = '';
        $officer_id = '';   
        
        if($this->uri->segment(3)){
            $condition  = base64_decode($this->uri->segment(3));
            $condArr    = explode('_', $condition);
            if($this->user->role_code == 'sadmin' || $this->user->role_code == 'cuser' || $this->user->role_code == 'cadmin'){
                $companyId  = isset($condArr[0])?$condArr[0]:'';
                $regionId   = isset($condArr[1])?$condArr[1]:'';
                $branchId   = isset($condArr[2])?$condArr[2]:'';
                $site_id    = isset($condArr[3])?$condArr[3]:'';
            }else if($this->user->role_code == 'RM'){
                $regionId   = isset($condArr[0])?$condArr[0]:'';
                $branchId   = isset($condArr[1])?$condArr[1]:'';
                $site_id    = isset($condArr[2])?$condArr[2]:'';
            }else if($this->user->role_code == 'BM'){
                $branchId   = isset($condArr[0])?$condArr[0]:'';
                $site_id    = isset($condArr[1])?$condArr[1]:'';
                
            }else {
                $site_id    = isset($condArr[0])?$condArr[0]:'';
                
            }
            
        }
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
            if($this->input->post('download_csv')){
                $csv = true;
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
 
        $vars['inspInstData'] = $this->ins->getRejectedInspectionsByFilter($where);  
        
        if($csv){            
            $this->down_csv($vars['inspInstData'],'rejection');                          //Download CSV file
        }          
        $vars['company_id']  = $companyId;
        $vars['region_id']  = $regionId;
        $vars['branch_id']  = $branchId;
        $vars['site_id']  = $site_id;
        
        $vars['fieldOfficerData'] = $this->um->getAllFieldOfficers($siteIds,$companyId,$this->user->user_id,$this->user->role_code);

        $vars['start_date'] = $start_date;
        $vars['end_date']   = $end_date;
        $vars['site_id']    = $site_id;
        $vars['officer_id'] = $officer_id;
        $vars['roleCode']   = $this->user->role_code;

        $vars['title']      = 'Rejected Inspections';
        $vars['contentView']= 'rejected_inspections';
        $this->load->view('inner_template', $vars);
    }
    
    function guardIspectionReport(){
        $this->um->checkLoginSession();
        $companyId  = '';
        $where      = '';
        $csv        = false;
        $start_date = '';//date('Y-m-d');
        $end_date   = '';
        $officer_id = ''; 
        $guard_id   = ''; 
        
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
        if($companyId != ''){
            $where .= ' AND u.company_id = '.$companyId.' ';
        }
        
       if($this->input->post()){            
            if($this->input->post('start_date')){
                $start_date     =   trim($this->input->post('start_date'));
            }
            if($this->input->post('end_date')){
                $end_date       =   trim($this->input->post('end_date'));
            }
           if($this->input->post('officer_id')){
                $officer_id     =   trim($this->input->post('officer_id'));
            }           
            if($this->input->post('guard_id')){
                $guard_id   = trim($this->input->post('guard_id'));
            }
            if($this->input->post('download_csv')){
                $csv = true;
            }  
        }
        
        if(!empty($start_date)){
            $where .= ' AND DATE(sv.visiting_time) >= DATE('."'".$start_date."'".')';            
        }
        if(!empty($end_date)){
            $where .= ' AND DATE(sv.visiting_time) <= DATE('."'".$end_date."'".')';
        }
        if(!empty($officer_id)){
            $where .= ' AND sv.user_id = '.$officer_id.' ';            
        }   
        if(!empty($guard_id)){
            $where .= ' AND sv.employee_id = '.$guard_id.' ';            
        } 
      
        
        
        $cur_page = $this->input->post('page') ? $this->input->post('page') : 1;
        $perPage  = $this->config->item('perPage');
        $vars['perPage']   = $perPage;
        $vars['page']      = $cur_page;
        $offset = ($cur_page*$perPage)-$perPage;
        $count = $this->ins->getGuardInspectionList($where,$offset,$perPage,true);  
        $vars['total_record']   = $count;
        $pages  = new paginator($count, $perPage, $cur_page);
        $vars['pagination'] = $pages;
        $vars['inspInstData'] = $this->ins->getGuardInspectionList($where,$offset,$perPage,false); 
      // print_r($vars['inspInstData']);
        if($csv){            
            $this->down_csv($vars['inspInstData'],'guard');//Download CSV file
        }          
        $vars['fieldOfficerData']   = $this->um->getAllFieldOfficers($siteIds,$companyId,$this->user->user_id,$this->user->role_code);
        $vars['guardData']          = $this->gm->getAllGuardList($companyId);

        $vars['start_date'] = $start_date;
        $vars['end_date']   = $end_date;
        $vars['guard_id']   = $guard_id;
        $vars['officer_id'] = $officer_id;

        $vars['title']      = 'FO Guard Inspection Report';
        $vars['pagetitle']  = 'FO Guard Inspection Report';
        $vars['contentView']= 'guard_inspection_report';
        $this->load->view('inner_template', $vars);
        
    }
}
 