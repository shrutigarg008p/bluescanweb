<?php
class Regionmanager extends CI_Model{
    function __construct(){
        // Call the Model constructor
        parent::__construct();
    }

/*START MODEL FUNCTIONS FOR REGION LIST GET ADD EDIT*/

    function getAllRegionList($companyId='',$user_id='',$role=''){
        $sql = '';
         $param = array();
        if(in_array($role, array('cadmin','cuser','sadmin'))){
            $sql = $this->qc->queryGetAllRegiondropdown; 
            $sql    = str_replace('LIMIT ?, ?',' WHERE r.company_id = ?  LIMIT ?, ? ', $sql);
            $param = array($companyId);
        }else if($role == 'RM'){
            $sql  = $this->qc->queryGetAllRegionList;
            $sql    = str_replace('LIMIT ?, ?',' WHERE u.user_id = ?  LIMIT ?, ? ', $sql);
            $param = array($user_id);
        }else if($role == 'BM'){
            $sql  = $this->qc->queryGetAllRegionLisForBranchSession;
            $sql    = str_replace('LIMIT ?, ?',' WHERE u.user_id = ?  LIMIT ?, ? ', $sql);
            $param = array($user_id);
        }else{
            $sql  = $this->qc->queryGetAllRegiondropdown;
            $sql    = str_replace('LIMIT ?, ?','', $sql);
            
        }
       
       
        $this->db->trans_start();
        $sql = str_replace('LIMIT ?, ?','', $sql);
        $query=$this->db->query($sql, $param);
        $this->cmm->print_log('Model:Regionmanager:getAllRegionList','Query => '.$this->db->last_query());
       //echo $this->db->last_query();die;
        $result=array();
        if($query->num_rows() > 0){
            $result=$query->result();
            $this->cmm->print_log('Model:Regionmanager:getAllRegionList','Result => '.print_r($result,true));
        }
        $this->db->trans_complete();        
        return $result;
    }

    function getAllRegionPageList($where,$role,$offset,$perPage,$countFlag=false){
        
        if(in_array($role, array('cadmin','cuser','sadmin'))){
            $sql  = $this->qc->queryGetAllRegionListForCompany;
        }else if(in_array($role, array('RM'))){
            $sql  = $this->qc->queryGetAllRegionList;
        } 
        
        
        
        $where = $where.' ORDER BY r.region_id DESC';        
        $sql    = str_replace(' LIMIT ?, ?',$where.' LIMIT ?, ? ', $sql);
        $this->db->trans_start();
        if($countFlag){
            $sql    = str_replace('LIMIT ?, ?','', $sql);
            $query = $this->db->query($sql,array());
            $result = $query->num_rows();
        }else{
            $result = array();
            $query = $this->db->query($sql,array($offset,$perPage));            
            if($query->num_rows() > 0){
                    $result = $query->result();
            }
        }
        $this->db->trans_complete();
        return $result;
    }

    function getRegionDetailsByRegId($regId)
    {
        $this->db->trans_start();
        $query=$this->db->query($this->qc->queryGetRegionDetailsByRegId, array($regId));
        $result=array();
        if($query->num_rows() > 0)
        {
            $result=$query->row();
        }        
        $this->db->trans_complete();
        return $result;
    }
    
    function getAllRegionDropdownByRegionIds($regIds){
        $this->db->trans_start();
        $query=$this->db->query($this->qc->queryGetAllRegionDropdownByRegionIds, array($regId));
        $this->cmm->print_log('Model:Regionmanager:getAllRegionDropdownByRegionIds','Query => '.$this->db->last_query());
        $result=array();
        if($query->num_rows() > 0){
            $result=$query->result();
            $this->cmm->print_log('Model:Regionmanager:getAllRegionDropdownByRegionIds','Result => '.print_r($result,true));
        }        
        $this->db->trans_complete();
        return $result;
    }
    
    
/*END MODEL FUNCTIONS FOR REGION LIST GET ADD EDIT*/

}