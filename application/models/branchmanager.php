<?php
class Branchmanager extends CI_Model{
    function __construct(){
        // Call the Model constructor
        parent::__construct();
    }


    function getAllBranchList($regionId='',$companyId='',$userId='',$user_role='')
    {   $sql = $this->qc->queryGetAllBranchList;

        $param = array();
        if($regionId != ''){
             $sql    = str_replace('LIMIT ?, ?','WHERE r.region_id = ? LIMIT ?, ?', $sql);
             $param[] = $regionId;
        }
        if($regionId == '' && $companyId != ''){
             $sql    = str_replace('LIMIT ?, ?','WHERE r.company_id = ? LIMIT ?, ?', $sql);
             //$param = array($companyId);
             $param[] = $companyId;
        }else if($companyId != ''){
            $sql    = str_replace('LIMIT ?, ?','AND r.company_id = ? LIMIT ?, ?', $sql);
             //$param = array($companyId);
             $param[] = $companyId;
        }
       // print_r($param);die;
        if($user_role == 'RM'){
            $sql  = $this->qc->queryGetAllBranchListForRegionManager;
            $sql    = str_replace('LIMIT ?, ?',' WHERE u.user_id = ?  LIMIT ?, ? ', $sql);
            $param = array($userId);
        }else if($user_role == 'BM'){
            $sql  = $this->qc->queryGetAllBranchListForBranchManager;
            $sql    = str_replace('LIMIT ?, ?',' WHERE u.user_id = ?  LIMIT ?, ? ', $sql);
            $param = array($userId);
        }
        $this->db->trans_start();
        $sql    = str_replace('LIMIT ?, ?','', $sql);
        $query = $this->db->query($sql, $param);
        $this->cmm->print_log('Model:Branchmanager:getAllBranchList','Query => '.$this->db->last_query());
        //echo $this->db->last_query();die;
        $result = array();
        if($query->num_rows() > 0){
            $result=$query->result();
            $this->cmm->print_log('Model:Branchmanager:getAllBranchList','result => '.  print_r($result,true));
        }
        $this->db->trans_complete();
        return $result;
    }

    function getAllBranchPageList($where,$role_code,$offset,$perPage,$countFlag=false){
        if($role_code == 'RM'){
            $sql = $this->qc->queryGetAllBranchListForRegionManager;
        }else if($role_code == 'BM'){
            $sql=$this->qc->queryGetAllBranchListForBranchManager;
        }else{
            $sql=$this->qc->queryGetAllBranchList;
        }
        
        $where = $where.' ORDER BY b.branch_id DESC';
        $sql    = str_replace('LIMIT ?, ?',$where.' LIMIT ?, ?', $sql);
        $this->db->trans_start();
        if($countFlag){
            $sql    = str_replace('LIMIT ?, ?','', $sql);
            $query  = $this->db->query($sql, array());
            $result = $query->num_rows();
        }else{
            $result = array();
            $query  = $this->db->query($sql,array($offset,$perPage));
            //echo $this->db->last_query();die;
            if($query->num_rows){
                $result = $query->result();
            }
        }
        $this->db->trans_complete();
        return $result;        
    }

    function getBranchDetailsByBId($branchId)
    {
        $this->db->trans_start();
        $query = $this->db->query($this->qc->queryGetBranchDetailsByBId, array($branchId));
        $result = array();
        if($query->num_rows() > 0){
                $result = $query->row();
        }
        $this->db->trans_complete();
        return $result;
    }
    
    function getAllBranchesSiteByRegionIds($regionId)
    {
        $sql = $this->qc->queryGetAllBranchesSiteByRegionIds;
        $sql = str_replace('#WHERE#', "WHERE b.region_id IN (".$regionId.")", $sql);
        $this->db->trans_start();
        $query = $this->db->query($sql, array());
        $this->cmm->print_log('Model:sitemanager:getAllBranchesSiteByRegionIds','Query => '.$this->db->last_query());
        $result = array();
        if($query->num_rows() > 0){
            $result = $query->row();
            $this->cmm->print_log('Model:branchmanager:getAllBranchesSiteByRegionIds','Query => '.print_r($result,true));
        }
        $this->db->trans_complete();
        return $result;
    }
    
    function getAllBranchDropdown($companyId,$is_published = 0){
        $sql = $this->qc->queryGetAllBranchDropdown;
        $param  = array();
        $this->db->trans_start();
        $where  = '';
        if($companyId){
            $param[]  = $companyId;
            $where .= ' c.company_id = ? ';
        }
        if($where != '' && $is_published!=''){
            $where .= ' AND ';
        }
         if($is_published!=0){
            $param[]  = $is_published;
             $where .= ' is_published = ? ';
        }
         if($where != ''){
            $where = ' WHERE '.$where;
        }
        $sql    = str_replace('#WHERE#',$where, $sql);
        $result=array();
        $query  = $this->db->query($sql,$param);
        //echo $this->db->last_query();die;
        if($query->num_rows){
            $result = $query->result();
        }
        $this->db->trans_complete();
        return $result;        
    }


    /*END MODEL FUNCTIONS FOR COMPANY LIST GET ADD EDIT*/    
}