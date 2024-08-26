<?php
class Companymanager extends CI_Model{
    function __construct(){
        // Call the Model constructor
        parent::__construct();
    }

/*START MODEL FUNCTIONS FOR COMPANY LIST GET ADD EDIT*/    
    function getAllCompanyList($companyId='',$user_id='',$role=''){
        $sql = '';
         $param = array();
        if(in_array($role, array('cadmin','cuser','sadmin'))){
            $sql  = $this->qc->queryGetAllCompanyList;
             $param = array($companyId);
        }else if($role == 'RM'){
            $sql  = $this->qc->queryGetAllCompanyListForRegionSession;
            $param = array($user_id);
        }else if($role == 'BM'){
            $sql  = $this->qc->queryGetAllCompanyListForBranchSession;
            $param = array($user_id);
        }else{
            $sql  = $this->qc->queryGetAllCompanyList;
            
            
        }
        
      //echo $sql;die;
        if($companyId != ''){
           // echo $sql;die;
             $sql    = str_replace('LIMIT ?, ?','WHERE company_id = ? LIMIT ?, ?', $sql);
             $param = array($companyId);
        }
        $sql    = str_replace('LIMIT ?, ?','', $sql);
      // echo $sql;die;
        $this->db->trans_start();
        $query = $this->db->query($sql,$param);       
        //echo $this->db->last_query();die;
        $result = array();
        if($query->num_rows() > 0){
            $result = $query->result();
        }
        $this->db->trans_complete();
       // print_r($result);die;
        return $result;
    }

    function getAllCompanyPageList($where,$offset,$perPage,$countFlag=false){
        $sql  = $this->qc->queryGetAllCompanyList;
        if($where != ''){
            $sql    = str_replace('LIMIT ?, ?',$where.'LIMIT ?, ?', $sql);
        }
        $this->db->trans_start();
        if($countFlag){
            $sql    = str_replace('LIMIT ?, ?','ORDER BY company_id DESC', $sql);
            $query = $this->db->query($sql,array());
            $result = $query->num_rows();
        }else{
            $result = array();
            $sql    = str_replace('LIMIT ?, ?','ORDER BY company_id DESC LIMIT ?, ?', $sql);
            $query = $this->db->query($sql,array($offset,$perPage));
            //echo $this->db->last_query();die;
            if($query->num_rows() > 0){
                    $result = $query->result();
            }
        }
        $this->db->trans_complete();
        return $result;
    }
    
    function getCompanyDetailsByCompId($companyId){
        $this->db->trans_start();
        $query = $this->db->query($this->qc->queryGetCompanyDetailsByCompId, array($companyId));
       // echo $this->db->last_query();die;
        $result = array();
        if($query->num_rows() > 0){
                $result = $query->row();
        }
        $this->db->trans_complete();
        return $result;
    }
    
    function getAllRegionBranchSiteDataByCompanyIds($companyId){
        $sql = $this->qc->queryGetAllRegionBranchSiteDataByCompanyIds;
        $sql = str_replace('#WHERE#', "WHERE r.company_id = ? ", $sql);
        $this->db->trans_start();
        $query = $this->db->query($sql, array($companyId));
        $this->cmm->print_log('Model:companymanager:queryGetAllRegionBranchSiteDataByCompanyIds','Query => '.$this->db->last_query());
       // echo $this->db->last_query();die;
        $result = array();
        if($query->num_rows() > 0){
            $result = $query->row();
            $this->cmm->print_log('Model:companymanager:queryGetAllRegionBranchSiteDataByCompanyIds','result => '.print_r($result,true));
        }
        $this->db->trans_complete();
        return $result;
    }
    
    function getAllCompanyLicenseList($companyId=''){
        $this->db->trans_start();
        $param  = array();
        $sql    = $this->qc->queryGetAllCompanyLicenseList;
       
        if($companyId!=''){
            $param[]    =  $companyId;
            
        }else{
            $sql    = str_replace('WHERE company_id <> ?','', $sql);
        }
        
        
        $query = $this->db->query($sql, $param);
        // echo $this->db->last_query();die;
        $result = array();
        if($query->num_rows() > 0){
                $result = $query->result();
        }
        $this->db->trans_complete();
        return $result;
    }
/*END MODEL FUNCTIONS FOR COMPANY LIST GET ADD EDIT*/   

/*START MODEL FUNCTIONS FOR COMPANY OFFICE LIST GET ADD EDIT*/
    function getAllCompanyOfficeListById($cid,$offset,$perPage,$countFlag=false)
    {   
        $sql  = $this->qc->queryGetAllCompanyOfficeList;
        $sql  = str_replace('LIMIT ?, ?',' ORDER BY company_office_id DESC LIMIT ?, ?', $sql);
        $this->db->trans_start();
        if($countFlag){
            $sql    = str_replace('LIMIT ?, ?','', $sql);
            $query = $this->db->query($sql, array($cid));
            $result = $query->num_rows();
        }else{
            $result = array();
            $query = $this->db->query($sql,array($cid,$offset,$perPage));
            if($query->num_rows() > 0){
                    $result = $query->result();
            }
        }
        $this->db->trans_complete();
        return $result;
    }
    
    function getAllEmployeeExperienceListById($cid,$offset,$perPage,$countFlag=false){
        $sql  = $this->qc->queryGetAllEmployeeExperienceListById;
        $this->db->trans_start();
        if($countFlag){
            $sql    = str_replace('LIMIT ?, ?','', $sql);
            $query = $this->db->query($sql, array($cid));
            $result = $query->num_rows();
        }else{
            $result = array();
            $query = $this->db->query($sql,array($cid,$offset,$perPage));
            if($query->num_rows() > 0){
                    $result = $query->result();
            }
        }
        $this->db->trans_complete();
        return $result;
        
    }

    function getCompanyOfficeDetailsByOfficeId($officeId)
    {
        $this->db->trans_start();
        $query = $this->db->query($this->qc->queryGetCompanyOfficeDetailsByOfficeId, array($officeId));
        $result = array();
        if($query->num_rows() > 0){
                $result = $query->row();
        }
        $this->db->trans_complete();
        return $result;
    }    
/*END MODEL FUNCTIONS FOR COMPANY OFFICE LIST GET ADD EDIT*/
    
}