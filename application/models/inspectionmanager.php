<?php
class Inspectionmanager extends CI_Model{
    function __construct(){
        // Call the Model constructor
        parent::__construct();
    }
    
    function getAllInspectionList($offset,$perPage,$countFlag=false){
        $sql=$this->qc->queryGetAllInspectionList;
        $this->db->trans_start();
        if($countFlag){
            $sql    = str_replace('LIMIT ?, ?','', $sql);
            $query  = $this->db->query($sql, array());
            $result = $query->num_rows();
        }else{
            $result = array();
            $query  = $this->db->query($sql,array($offset,$perPage));
            if($query->num_rows){
                $result = $query->result();
            }
        }
        $this->db->trans_complete();
        return $result;        
    }


    function getAllInspectionListWithFilter($userIds, $guardIds, $offset, $perPage, $countFlag=false){        
        $con = '';
        $where = 'ORDER BY ins.created_by ASC LIMIT ?, ?';
        $passingEle = array();
        if(!empty($userIds))
        {
           $con = $con.' WHERE ins.created_by = ?';
           array_push($passingEle, $userIds);           
        }
        if(!empty($guardIds))
        {
           $con = $con.(empty($con)?' WHERE ins.guard_id = ?':'AND ins.guard_id = ?');
           array_push($passingEle, $guardIds);
        }        
        $sql=$this->qc->queryGetAllInspectionList;
        $sql = str_replace($where, $con.$where, $sql);
        $this->db->trans_start();
        if($countFlag){
            $sql    = str_replace('LIMIT ?, ?','', $sql);
            $query  = $this->db->query($sql, $passingEle);
            $result = $query->num_rows();
        }else{
            $result = array();
            array_push($passingEle, $offset);
            array_push($passingEle, $perPage);
            $query  = $this->db->query($sql, $passingEle);
            if($query->num_rows){
                $result = $query->result();
            }
        }
        $this->db->trans_complete();
        return $result;           
    }
    

    function getInspectionDataById($inspectionId){
        $this->db->trans_start();
        $query = $this->db->query($this->qc->queryGetInspectionDataById, array($inspectionId));
        $result = array();
        if($query->num_rows() > 0){
                $result = $query->row();
        }
        $this->db->trans_complete();
        return $result;
    }

    function getInspectionQuestionDataById($siteId){
        $this->db->trans_start();
        $query = $this->db->query($this->qc->queryGetInspectionQuestionDataById, $siteId);
        $result = array();
        if($query->num_rows() > 0){
                $result = $query->result();
        }
        $this->db->trans_complete();
        return $result;
    }
        
    function getConvayenceReport($where='', $offset, $perPage, $countFlag=false){        
        $sql=$this->qc->queryGetConvayenceReport;
        if(isset($where) && !empty($where)){
           $where   = 'WHERE '.$where;
           $sql = str_replace('ORDER BY sv.visiting_time DESC', $where.' ORDER BY sv.visiting_time DESC ', $sql);
        }
        $this->db->trans_start();
        if($countFlag){
            $sql    = str_replace('LIMIT ?, ?','', $sql);
            $query = $this->db->query($sql,array());
            $result = $query->num_rows();
        }else{
            $result = array();
            $query = $this->db->query($sql,array($offset,$perPage));
            //echo $this->db->last_query();die;
            if($query->num_rows() > 0){
                    $result = $query->result();
            }
        }
        $this->db->trans_complete();
        return $result;
    }

    function getGildConveyanceReport($filtedBy,$date,$typeId)
    {
        $sql    = $this->qc->queryGetDrillDownConveyanceReport;
        $where  = '';
        if($filtedBy == 'company'){
            $where = ($typeId!='')?' AND c.company_id IN ('.$typeId.') ':'';
            $sql = str_replace('GROUP BY s.site_id', 'GROUP BY c.company_id', $sql);  }
        elseif ($filtedBy == 'region'){
            $where = ($typeId!='')?' AND r.region_id IN ('.$typeId.') ':'';
            $sql = str_replace('GROUP BY s.site_id', 'GROUP BY r.region_id', $sql);  }
        elseif ($filtedBy == 'branch'){
            $where = ($typeId!='')?' AND b.branch_id IN ('.$typeId.') ':'';
            $sql = str_replace('GROUP BY s.site_id', 'GROUP BY b.branch_id', $sql);  }  
        
            
        if($date != ''){
            $sql = str_replace('month(sv.visiting_time)=month(NOW())', 'DATE(sv.visiting_time) = ?', $sql);            
        }  
        if($where != ''){
             $sql = str_replace('#WHERE#', $where, $sql);         
        }
        // print_r($sql);die;
        $this->db->trans_start();        
        $query = $this->db->query($sql,array($date));
        $this->cmm->print_log('Model:Inspectionmanager:getGildConveyanceReport','Query => '.$this->db->last_query());
        $result = array();
        if($query->num_rows() > 0){
            $result = $query->result();
            $this->cmm->print_log('Model:Inspectionmanager:getGildConveyanceReport','result => '.print_r($result,true));
        }
        $this->db->trans_complete();
        return $result;   
    }
    
   
    function getGuardInspectionList($where,$offset,$perPage,$countFlag=false){ 
        $sql  = $this->qc->queryGetGuardInspectionList;
        $con  = '';
        $search = '#WHERE#';
        $passingarray = array();        
        $sql = str_replace($search, $where, $sql);
        $this->db->trans_start();
        if($countFlag){
            $result = 0;
            $sql    = str_replace('LIMIT ?, ?','', $sql);
            $query = $this->db->query($sql,array());
            $this->cmm->print_log('Model:inspectionmanager:getGuardInspectionList','Query => '.$this->db->last_query());
            $result = $query->num_rows();
            $this->cmm->print_log('Model:inspectionmanager:getGuardInspectionList','number of rows => '.$result);
        }else{
            $result = array();
            $query = $this->db->query($sql,array($offset,$perPage));
            $this->cmm->print_log('Model:inspectionmanager:getGuardInspectionList','Query => '.$this->db->last_query());
            $result = $query->result();
            $this->cmm->print_log('Model:inspectionmanager:getGuardInspectionList','Result => '.print_r($result,true));
            
            //echo $this->db->last_query();die;
        }
        //echo $this->db->last_query();
        
        $this->db->trans_complete();
        return $result;
    }
    
    function getRejectedInspectionsByFilter($where=''){ 
        $sql  = $this->qc->queryGetRejectedInspectionsByFilter;
        $con  = '';
        $search = '#WHERE#';
        $passingarray = array();        
        $sql = str_replace($search,$where, $sql);
        $this->db->trans_start();
        $query = $this->db->query($sql, $passingarray);
        //echo $this->db->last_query();die;
        
        $this->cmm->print_log('Model:Inspectionmanager:queryGetRejectedInspectionsByFilter','Query => '.$this->db->last_query());
        $result = array();
        if($query->num_rows() > 0){
                $result = $query->result();
                $this->cmm->print_log('Model:Inspectionmanager:queryGetRejectedInspectionsByFilter','Query => '.print_r($result,true));
        }
        $this->db->trans_complete();
        return $result;
    }
    
}