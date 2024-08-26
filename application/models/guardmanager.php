<?php
class Guardmanager extends CI_Model{
    function __construct(){
        // Call the Model constructor
        parent::__construct();
    }
    
    function getAllGuardPageList($companyId='',$offset,$perPage,$countFlag=false){
        $sql  = $this->qc->queryGetAllGuardList;
        $param = array();
        $where = '';
        if($companyId != ''){
            $where  = $where.'WHERE c.company_id = ?';
            $param  = array($companyId,$offset,$perPage);
        }else{
            $param  = array($offset,$perPage);
        }
        $where  = $where.'ORDER BY g.guard_id DESC LIMIT ?, ?';
        $sql    = str_replace('LIMIT ?, ?', $where, $sql);
        $this->db->trans_start();
        if($countFlag){
            $sql    = str_replace('LIMIT ?, ?','', $sql);
            $query = $this->db->query($sql,$param);
           // echo $this->db->last_query();die;
            $result = $query->num_rows();
        }else{
            $result = array();
            $query = $this->db->query($sql,$param);
           //echo $this->db->last_query();die;
            if($query->num_rows() > 0){
                    $result = $query->result();
            }
        }
        $this->db->trans_complete();
        return $result;
    }

    function getAllGuardList($companyId=''){
        $param = array();
        $sql  = $this->qc->queryGetAllGuardList;
        $this->db->trans_start();
        if($companyId!=''){
            $sql    = str_replace('#WHERE#',' WHERE c.company_id = ? ', $sql);
            $param[]  = $companyId;
        }
        $sql    = str_replace('LIMIT ?, ?','', $sql);
        $query = $this->db->query($sql,$param);            
        $result = array();
        if($query->num_rows() > 0){
                $result = $query->result();
        }
        $this->db->trans_complete();
        return $result;
    }

    function getGuardDocByGuardId($guard_sid, $docid){
        $sql=$this->qc->queryGetGuardDocByGuardId;
        $this->db->trans_start();
        $result = array();        
        $query = $this->db->query($sql,array($guard_sid, $docid));
        if($query->num_rows() > 0){
                $result = $query->result();
        }
        $this->db->trans_complete();
        return $result;
    }   
    
    
    function getGuardDataBySiteId($siteId){
        $result = array();
        $siteUrl    = site_url($this->config->item('user_images_thumb_path'));
        if($siteId){
            $sql  = $this->qc->queryGetGuardDataBySiteId;
            $this->db->trans_start();
            $sql    = str_replace('LIMIT ?, ?','', $sql);
            $query = $this->db->query($sql,array($siteUrl,$siteId));            
            $this->cmm->print_log('Model:guardmanager:getGuardDataBySiteId','Query => '.$this->db->last_query());
            $this->cmm->print_log('Model:guardmanager:getGuardDataBySiteId','Query Response => '.print_r($query,true));
            if($query->num_rows() > 0){
                    $result = $query->result();
            }
            $this->db->trans_complete();
        }
        return $result;
    }
    
    function getGuardDataByQrcode($guardId,$type=false,$company_id=''){
        $result = array();
        $param = array();
        $siteUrl    = site_url($this->config->item('user_images_thumb_path'));
        $companyImgPath    = site_url($this->config->item('company_images_thumb_path'));
        $folderImageUrl = site_url('img');
        $param[] =  $folderImageUrl;
        $param[] =  $folderImageUrl;
        $param[] =  $folderImageUrl;
        $param[] =  $folderImageUrl;
        $param[] =  $folderImageUrl;
        $param[] =  $folderImageUrl;
        $param[] =  $folderImageUrl;
        $param[] =  $folderImageUrl;
        $param[] =  $folderImageUrl;
        $param[] =  $folderImageUrl;
        $param[] =  $siteUrl;
        $param[] =  $companyImgPath;
        if($guardId!=''){
            $sql  = $this->qc->queryGetGuardDataByQrcode;
            if($company_id!=''){
                 $sql    = str_replace('WHERE u.qr_code = ?','WHERE u.qr_code = ? AND u.company_id = ?',$sql);
                 
            }
            if($type){
                $sql    = str_replace('WHERE u.qr_code = ?','WHERE e.employee_id = ?',$sql);
                
            }
            $param[] =  $guardId;
            $param[] =  $company_id;
            $this->db->trans_start();
            $query = $this->db->query($sql,$param);            
            $this->cmm->print_log('Model:guardmanager:getGuardDataByQrcode','Query => '.$this->db->last_query());
            //echo $this->db->last_query();die;
            $this->cmm->print_log('Model:guardmanager:getGuardDataByQrcode','Query Response => '.print_r($query,true));
            if($query->num_rows() > 0){
                    $result = $query->row();
            }
            $this->db->trans_complete();
        }
         return $result;
    }

    function getGuardAttendListByGId($where,$offset,$perPage,$countFlag=false){
        $sql  = $this->qc->queryGetGuardAttendListByGId;
        if(isset($where) && !empty($where)){
            $sql = str_replace('#WHERE#', ' AND '.$where, $sql);
        }
        
        $this->db->trans_start();        
        if($countFlag){
            $result = 0;
            $sql    = str_replace('LIMIT ?, ?','', $sql);
            $query = $this->db->query($sql,array());
           // echo $this->db->last_query();die;
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
    
    function getGuardAttendanceList($where){
        $sql  = $this->qc->queryGetGuardAttendanceList;
        if(isset($where) && !empty($where)){
            $sql = str_replace('#WHERE#', ' WHERE '.$where, $sql);
        }
        $this->db->trans_start();       
        $result = array();
        $query = $this->db->query($sql,array());
      //echo $this->db->last_query();die;
        if($query->num_rows() > 0){
                $result = $query->result();
        }
        $this->db->trans_complete();
        return $result;
        
    }

    function getAllDocTypeList() {
        $this->db->trans_start();
        $query = $this->db->query($this->qc->queryGetAllDocTypeList);
        $result = array();
        if($query->num_rows() > 0){
                $result = $query->result();
        }
        $this->db->trans_complete();
        return $result;
    }

    function getAllSkill() {
        $this->db->trans_start();
        $query = $this->db->query($this->qc->queryGetAllSkill);
        $result = array();
        if($query->num_rows() > 0){
                $result = $query->result();
        }
        $this->db->trans_complete();
        return $result;
    }
    
    function getUserLatLongDataBySiteVisitingIdMin($user_id,$date,$site_visiting_id){
        $result = array();
        $latLong= array();
        $this->db->trans_start();
        $query = $this->db->query($this->qc->queryGetUserLatLongDataBySiteVisitingIdMin,array($user_id,$date,$site_visiting_id));        
        $this->cmm->print_log('Model:sitemanager:$queryGetUserLatLongDataBySiteVisitingIdMin','Query => '.$this->db->last_query());
        
        //echo $this->db->last_query();die;
        if($query->num_rows()>0){
            $result =  $query->row();
            $this->cmm->print_log('Model:sitemanager:$queryGetUserLatLongDataBySiteVisitingIdMin','Query Response => '.print_r($result,true));
            if(!empty($result)){
                $latLong[] =  $result->latitude;
                $latLong[] =  $result->longitude;
            }
        }
        $this->db->trans_complete();
        return $latLong;
    }
    
    function getUserLatLongDataBySiteVisitingIdMax($user_id,$date,$site_visiting_id){
        $result = array();
        $latLong= array();
        $this->db->trans_start();
        $query = $this->db->query($this->qc->queryGetUserLatLongDataBySiteVisitingIdMax,array($user_id,$date,$site_visiting_id));        
        $this->cmm->print_log('Model:sitemanager:$queryGetUserLatLongDataBySiteVisitingIdMax','Query => '.$this->db->last_query());
        
        //echo $this->db->last_query();die;
        if($query->num_rows()>0){
            $result =  $query->row();
            $this->cmm->print_log('Model:sitemanager:$queryGetUserLatLongDataBySiteVisitingIdMax','Query Response => '.print_r($result,true));
            if(!empty($result)){
                $latLong[] =  $result->latitude;
                $latLong[] =  $result->longitude;
                $latLong[] =  $result->site_visiting_id;
            }
        }
        $this->db->trans_complete();
        return $latLong;
    }
    
    function getUserLatLongData($user_id,$date){
        $result = array();
        $latLong = array();
        $this->db->trans_start();
        $query = $this->db->query($this->qc->queryGetUserLatLongData,array($user_id,$date));        
        $this->cmm->print_log('Model:sitemanager:queryGetUserLatLongData','Query => '.$this->db->last_query());
        
        //echo $this->db->last_query();die;
        if($query->num_rows()>0){
            $result =  $query->row();
            $this->cmm->print_log('Model:sitemanager:queryGetUserLatLongData','Query Response => '.print_r($result,true));
            if(!empty($result)){
                $latLong[] =  $result->latitude;
                $latLong[] =  $result->longitude;
            }
        }
        $this->db->trans_complete();
        return $latLong;
    }

    function getSurveyData($siteVisitingId)
    {
        $result = array();
        $this->db->trans_start();        
        $sql    =   $this->qc->queryGetSurveyData;
        $query  =   $this->db->query($sql,array($siteVisitingId));
        if($query->num_rows>0)
        {
            $result = $query->result();            
        }
        $this->db->trans_complete();
        return $result;
    }
    
    function getGuardSurveyData($siteVisitingId){
        
        $result = array();
        $this->db->trans_start();        
        $sql    =   $this->qc->queryGetGuardSurveyData;
        $query  =   $this->db->query($sql,array($siteVisitingId));
       // echo $this->db->last_query();die;
        if($query->num_rows>0)
        {
            $result = $query->result();            
        }
        $this->db->trans_complete();
        return $result;
    }
}