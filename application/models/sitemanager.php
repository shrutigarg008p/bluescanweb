<?php
class SiteManager extends CI_Model{

    function getAllSiteListDropdown($branch_id = '',$companyId='',$user_id='',$role=''){
        $where = '';
        $param = array();
        if($branch_id != ''){
             $param[] = $branch_id;
             $where   .= 'WHERE s.branch_id = ? ';
        }
        if($companyId != '' && $branch_id == ''){
            $param[] = $companyId;
             $where   .= ' WHERE c.company_id = ? ';
        }else if($companyId != ''){
             $param[] = $companyId;
             $where   .= ' AND com.company_id = ? ';
        }
        
        if($role == 'RM' && $user_id !=''){
            $sql  = $this->qc->queryGetAllSiteListForRegionManager;
            $sql    = str_replace('#WHERE#',' WHERE u.user_id = ? ', $sql);
            $sql    = str_replace('ORDER BY s.site_id DESC LIMIT ?, ?','GROUP BY s.site_id ORDER BY s.site_title DESC', $sql);
            $param = array($user_id);
        }else if($role == 'BM' && $user_id !=''){
            $sql  = $this->qc->queryGetAllSiteListForBranchManager;
            $sql    = str_replace('#WHERE#',' WHERE u.user_id = ? ', $sql);
            $sql    = str_replace('ORDER BY s.site_id DESC LIMIT ?, ?','GROUP BY s.site_id ORDER BY s.site_title DESC', $sql);
            $param = array($user_id);
        }else{
            $sql  = $this->qc->queryGetAllSiteList;
             $sql    = str_replace('#WHERE#',$where, $sql);
             $sql    = str_replace('ORDER BY s.site_id DESC LIMIT ?, ?','GROUP BY s.site_id ORDER BY s.site_title DESC', $sql);
        }
        
        $this->db->trans_start();
        $query=$this->db->query($sql, $param);
       // echo $this->db->last_query();die;
        $this->cmm->print_log('Model:sitemanager:getAllSiteListDropdown','Query => '.$this->db->last_query());
        $result=array();
        if($query->num_rows() > 0){
            $result=$query->result();
            $this->cmm->print_log('Model:sitemanager:getAllSiteListDropdown','Query Response => '.print_r($result,true));
        }
        $this->db->trans_complete();
        return $result;
    }
    
    function getAllSiteDetailsBySiteIdQR($site_id,$qr_code){
        $result = array();
        $this->db->trans_start();
        $query = $this->db->query($this->qc->queryGetAllSiteDetailsBySiteIdQR,array($site_id,$qr_code));
        $this->cmm->print_log('Model:sitemanager:getAllSiteDetailsBySiteIdQR','Query => '.$this->db->last_query());
        if($query->num_rows()>0){
            $result =  $query->row();
            $this->cmm->print_log('Model:sitemanager:getAllSiteDetailsBySiteIdQR','Query Response => '.print_r($result,true));
        }
        $this->db->trans_complete();
        return $result;
    }
    
    function getAllSiteDetailsBySiteId($site_id){
        $result = array();
        $this->db->trans_start();
        $query = $this->db->query($this->qc->queryGetAllSiteDetailsBySiteId,array($site_id));
        $this->cmm->print_log('Model:sitemanager:getAllSiteDetailsBySiteId','Query => '.$this->db->last_query());
       // echo $this->db->last_query();die;
        if($query->num_rows()>0){
                $result =  $query->row();
                $this->cmm->print_log('Model:sitemanager:getAllSiteDetailsBySiteId','Query Response => '.print_r($result,true));
        }
        $this->db->trans_complete();
        return $result;
    }
    
    function getThresholdvaluesBySiteId($site_id,$datetime,$date){
        
        $result = array();
        $this->db->trans_start();
        $query = $this->db->query($this->qc->queryGetThresholdvaluesBySiteId,array($date,$datetime,$site_id));
        $this->cmm->print_log('Model:sitemanager:queryGetThresholdvaluesBySiteId','Query => '.$this->db->last_query());
       // echo $this->db->last_query();die;
        if($query->num_rows()>0){
                $result =  $query->row();
                $this->cmm->print_log('Model:sitemanager:queryGetThresholdvaluesBySiteId','Query Response => '.print_r($result,true));
        }
        $this->db->trans_complete();
        return $result;
    }
    
    function getAllSiteQuestionBySiteId($site_id){
        $result = array();
        $this->db->trans_start();
        $query = $this->db->query($this->qc->queryGetAllSiteQuestionBySiteId,array($site_id));
        $this->cmm->print_log('Model:sitemanager:getAllSiteQuestionBySiteId','Query => '.$this->db->last_query());
        $this->cmm->print_log('Model:sitemanager:getAllSiteQuestionBySiteId','Query Response => '.print_r($query,true));
        if($query->num_rows()>0){
                $result =  $query->result();
        }
        $this->db->trans_complete();
        return $result;
    }
    
    function getAllSiteList($where,$role,$offset,$perPage,$countFlag=false){
        if(in_array($role, array('cadmin','cuser','sadmin'))){
            $sql  = $this->qc->queryGetAllSiteListByCompanyId;
        }else if($role == 'RM'){
             $sql  = $this->qc->queryGetAllSiteListForRegionManager;
        }else if($role == 'BM'){
            $sql  = $this->qc->queryGetAllSiteListForBranchManager;
        }else if($role == 'FO'){
            $sql  = $this->qc->queryGetAllSiteListForFo;
        }
        $sql  = str_replace('#WHERE#',$where, $sql);
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
    
    function getSiteGroupBySiteId($siteId){
        $result = array();
        $this->db->trans_start();
        $query = $this->db->query($this->qc->queryGetSiteGroupBySiteId,array($siteId));
       // echo $this->db->last_query();die;
        if($query->num_rows()>0){
                $result =  $query->row();
        }
        $this->db->trans_complete();
        return $result;
    }
    
    function getSiteDataByQrcode($qrcode,$companyId=''){
        $result = array();
        $companyImgPath    = site_url($this->config->item('company_images_thumb_path'));
        if($qrcode){
            $sql = $this->qc->queryGetSiteDataByQrcode;
            if($companyId!=''){
                $sql = str_replace('WHERE s.qr_code = ?', 'WHERE s.qr_code = ? AND c.company_id = ? ', $sql);
            }
            $result = array();
            $this->db->trans_start();
            $query = $this->db->query($sql,array($companyImgPath,$qrcode,$companyId));
            $this->cmm->print_log('Model:sitemanager:getSiteDataByQrcode','Query => '.$this->db->last_query());
            //echo $this->db->last_query();die;
           
            if($query->num_rows()>0){
                    $result =  $query->row();
                     $this->cmm->print_log('Model:sitemanager:getSiteDataByQrcode','result Response => '.print_r($result,true));
            }
            $this->db->trans_complete();
        }
        return $result;
       // echo $this->db->last_query();die;
    }

    //START MODEL FUNCTIONS FOR GUARD SITE LIST
    function getAllGuardPageSiteList($guardSiteId,$offset,$perPage,$countFlag=false)
    {
        $sql  = $this->qc->queryGetAllGuardSiteList;
        $sql  = str_replace('LIMIT ?, ?',' ORDER BY employee_site_id DESC LIMIT ?, ?', $sql);
        $this->db->trans_start();
        if($countFlag){
            $sql    = str_replace('LIMIT ?, ?','', $sql);
            $query = $this->db->query($sql,array($guardSiteId));
            $result = $query->num_rows();
        }else{
            $result = array();
            $query = $this->db->query($sql,array($guardSiteId,$offset,$perPage));
            //echo $this->db->last_query();die;
            if($query->num_rows() > 0){
                    $result = $query->result();
            }
        }
        $this->db->trans_complete();
        return $result;
    }

    function getGuardSiteDataByGuardSiteId($guardsiteid)
    {
        $result = array();
        $this->db->trans_start();
        $query = $this->db->query($this->qc->queryGetGuardSiteDataByGuardSiteId,array($guardsiteid));        
        if($query->num_rows()>0){
                $result =  $query->row();
        }
        $this->db->trans_complete();
        return $result;
    }
    
    function getSiteListByUserId($userId){
        $companyImgPath    = site_url($this->config->item('company_images_thumb_path'));
        $result = array();
        $this->db->trans_start();
        $query = $this->db->query($this->qc->queryGetSiteListByUserId,array($companyImgPath,$userId));        
        $this->cmm->print_log('Model:sitemanager:getSiteListByUserId','Query => '.$this->db->last_query());
        $this->cmm->print_log('Model:sitemanager:getSiteListByUserId','Query Response => '.print_r($query,true));
        //echo $this->db->last_query();die;
        if($query->num_rows()>0){
                $result =  $query->result();
        }
        $this->db->trans_complete();
        return $result;
    }
    
    
    function getAllSiteByBranchIds($branchIds){
        $sql = $this->qc->queryGetAllSiteByBranchIds;
        $sql = str_replace('#WHERE#', "WHERE s.branch_id IN (".$branchIds.")", $sql);
        $result = array();
        $this->db->trans_start();
        $query = $this->db->query($sql,array());        
       //echo $this->db->last_query();die;
        $this->cmm->print_log('Model:sitemanager:getAllSiteByBranchIds','Query => '.$this->db->last_query());
        //echo $this->db->last_query();die;
        if($query->num_rows()>0){
                $result =  $query->row();
                $this->cmm->print_log('Model:sitemanager:getAllSiteByBranchIds','Query Response => '.print_r($result,true));

        }
        $this->db->trans_complete();
        return $result;
    }
    

    function getAllClientSiteData()
    {
        $this->db->trans_start();
        $query = $this->db->query($this->qc->queryGetAllClientSiteData);
        $result = array();
        if($query->num_rows() > 0){
                $result = $query->result();
        }
        $this->db->trans_complete();
        return $result;
    }
    
    function getLastLatLong($user_id,$date){
        $result = array();
        $latLong = array();
        $this->db->trans_start();
        $query = $this->db->query($this->qc->queryGetLastLatLong,array($user_id,$date));        
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
    
    function checkFOStartDay($date,$user_id){
        $result = array();
        $this->db->trans_start();
        $query = $this->db->query($this->qc->queryCheckFOStartDay,array($user_id,$date));        
        $this->cmm->print_log('Model:sitemanager:queryCheckFOStartDay','Query => '.$this->db->last_query());
        
        //echo $this->db->last_query();die;
        if($query->num_rows()>0){
            $result =  $query->result();
            $this->cmm->print_log('Model:sitemanager:queryCheckFOStartDay','Query Response => '.print_r($result,true));
        }
        $this->db->trans_complete();
        return $result;
    }
    
    
    function checkSiteidId($customSiteId,$siteID){
        $sql = $this->qc->queryCheckSiteidId;
        $this->db->trans_start();
        if($siteID){
           $sql .= ' AND site_id != ? '; 
        }
        $query = $this->db->query($sql, array($customSiteId,$siteID));
        $this->cmm->print_log('Model:sitemanager:queryCheckSiteidId','Query => '.$this->db->last_query());
        $result = false;
        if($query->num_rows() > 0){
                $result = true;
                //print_r($result);die;
                $this->cmm->print_log('Model:sitemanager:queryCheckSiteidId','Query Response => '.print_r($result,true));
        }
        $this->db->trans_complete();
        return $result;
    }

    function getCompanyAdminEmailIdsByFo($company_id)
    {
        $this->db->trans_start();
        $query = $this->db->query($this->qc->querygetCompanyAdminEmailIdsByFo,array($company_id));
        $result = array();
        $email=array();
        if($query->num_rows() > 0){
            $result = $query->result_array();
              foreach ($result as $key => $value)
              {
                $email[]=$value['email'];
              }

        }
        $this->db->trans_complete();
        return $email;
    }
    function getsiteName($siteId)
    {
        $this->db->trans_start();
        $query = $this->db->query($this->qc->querygetsiteNameScanByFO,array($siteId));
        $result = array();
        $email=array();
        if($query->num_rows() > 0){
            $result = $query->row();

        }
        $this->db->trans_complete();
        return $result;
    }

    function getsiteNameForCustomer($siteId)
    {
        $this->db->trans_start();
        $query = $this->db->query($this->qc->querygetsiteNameScanByFOForCustmer,array($siteId));
        $result = array();
        $email=array();
        if($query->num_rows() > 0){
            $result = $query->row();

        }
        $this->db->trans_complete();
        return $result;
    }

    function getQuestionAnsForClientEmail($site_visiting_id)
    {
        $this->db->trans_start();
        $query = $this->db->query($this->qc->querygetQuestionAnsForClientEmail,array($site_visiting_id));
        $result = array();       
        if($query->num_rows() > 0){

            $result = $query->result();
        }
        $this->db->trans_complete();        
        return $result;
    }
    
    

}