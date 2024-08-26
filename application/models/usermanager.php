<?php
class Usermanager extends CI_Model{
    function __construct(){
        // Call the Model constructor
        parent::__construct();
    }
    
    function checkUserLogin($username,$password){
        $this->db->trans_start();
        $query = $this->db->query($this->qc->queryGetUserByUsernamePassword, array($username,$password));
        //echo $this->db->last_query();die;
        $this->cmm->print_log('Model:usermanager:checkUserLogin','Query => '.$this->db->last_query());
        $result = array();
        if($query->num_rows() > 0){
                $result = $query->row();
                //print_r($result);die;
                $this->cmm->print_log('Model:usermanager:checkUserLogin','Query Response => '.print_r($result,true));
        }
        $this->db->trans_complete();
        return $result;
    }
    
    function getUserByEmail($email){
        $this->db->trans_start();
        $query = $this->db->query($this->qc->queryGetUserByEmail, array($email));
        //echo $this->db->last_query();die;
        $this->cmm->print_log('Model:usermanager:queryGetUserByEmail','Query => '.$this->db->last_query());
        $result = array();
        if($query->num_rows() > 0){
                $result = $query->row();
                //print_r($result);die;
                $this->cmm->print_log('Model:usermanager:queryGetUserByEmail','Query Response => '.print_r($result,true));
        }
        $this->db->trans_complete();
        return $result;
    }
    
    function checkEmailForForgotPassword($email){
        $this->db->trans_start();
        $query = $this->db->query($this->qc->queryCheckEmailForForgotPassword, array($email));
        //echo $this->db->last_query();die;
        $this->cmm->print_log('Model:usermanager:checkEmailForForgotPassword','Query => '.$this->db->last_query());
        $result = false;
        if($query->num_rows() > 0){
                $result = true;
                //print_r($result);die;
                $this->cmm->print_log('Model:usermanager:checkEmailForForgotPassword','Query Response => '.print_r($result,true));
        }
        $this->db->trans_complete();
        return $result;
    }
    
    
    function checkLoginSession(){
        $sessionData=$this->getUserSession();
        if(empty($sessionData) || $sessionData==''){
                redirect('user/login');
                die();
        }
        return true;
    }

    function getUserSession(){
        $sessionData= $this->session->userdata('users');
        if(!empty($sessionData)){
                return  unserialize($sessionData);
        }
    }
    
    function getUserByUsernameAndPassword($username,$password){
        $result = array();
        $this->db->trans_start();
        $query = $this->db->query($this->qc->queryGetUserByUsernamePassword, array($username,md5($password)));
        //echo $this->db->last_query();die;
        if($query->num_rows() > 0){
            $result = $query->row();
            $this->db->trans_complete();
            /*if(!empty($result)){
                if(isset($result->guard_id) && !empty($result->guard_id)){
                    $result = $this->gd->getGuardDataByGuardId($result->guard_id);
                }
            }
             */
        }else{
             $this->db->trans_complete();
        }
        return $result;
    }
    
    
        
    function updateUserSessionByUserId($user_id,$session_token,$apns_token){
        $this->db->trans_start();
        $query = $this->db->query($this->qc->quertUpdateUserSessionByUserId, array($session_token,$apns_token,$user_id));
        $this->db->trans_complete();
    }
    
    function getUserByUserToken($sessionToken){
        $result = array();
        $this->db->trans_start();
        $query = $this->db->query($this->qc->queryGetUserByUserToken,array($sessionToken));
        if($query->num_rows() > 0){
                $result = $query->row();
        }
        $this->db->trans_complete();
        return $result;
    }
    
    function logoutUserMobile($userId){
        $this->db->trans_start();
        $this->db->where('user_id',$userId);
        $this->db->update('user', array('session_token'=>''));
        $this->db->trans_complete();
    }


/*START MODEL FUNCTIONS FOR USERS LIST GET ADD EDIT*/
    function getAllUserList($companyId='')
    {   
        $param = array();
        $sql = $this->qc->queryGetAllUserList;
        $where  = ' ';
        $limit  = ' ';
        if($companyId != ''){
        	$where  = ' WHERE u.company_id = ? ';
        	//$sql = str_replace('GROUP BY ur.user_id LIMIT ?, ? ','WHERE company_id = ? GROUP BY ur.user_id LIMIT ?, ? ', $sql);
            $param = array($companyId);
        }
        $this->db->trans_start();
        //$sql = str_replace('LIMIT ?, ?','', $sql);
        $sql = str_replace(array('##WHERE##','##LIMIT##'),array($where,$limit), $sql);
        $query = $this->db->query($sql, $param);
        $result = array();
        if($query->num_rows() > 0){
                $result = $query->result();
        }
        $this->db->trans_complete();
        return $result;
    }

    function getMultiUserRolls($userId)
    {   
        $this->db->trans_start();
        $query = $this->db->query($this->qc->queryGetMultiUserRolls, array($userId));
        $result = array();
        if($query->num_rows() > 0){
                $result = $query->result();
        }
        $this->db->trans_complete();
        return $result;
    }

    function getAllUserPageList($where,$offset,$perPage,$countFlag=false){
        $param  = array();
       
        $where = $where.' GROUP BY u.user_id ORDER BY u.user_id DESC';
        $sql  = $this->qc->queryGetAllUserPageList;        
        $sql    = str_replace('LIMIT ?, ?', $where.' LIMIT ?, ? ',$sql);
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
    
    function getAllFieldOfficers($site_id='',$company_id='',$user_id='',$role=''){
        
        $param  = array();
        if(isset($site_id) && !empty($site_id)){
            $sql = $this->qc->queryGetAllFieldOfficers;
            $sql = str_replace(" WHERE r.code = 'FO' ", " WHERE r.code = 'FO' AND ur.site_id IN (".$site_id.") ", $sql);
            $param = array($site_id);
        }else if($company_id != ''){
            $sql = $this->qc->queryGetAllFieldOfficersByCompanyId;
            $sql = str_replace("#WHERE#", " WHERE c.company_id = ? ", $sql);
            $param = array($company_id);
        }else{
            $sql = $this->qc->queryGetAllFieldOfficersByCompanyId;
            $sql = str_replace("#WHERE#", " WHERE u.user_id = ? ", $sql);
            $param = array($user_id);
        }
        $this->db->trans_start();
        $query = $this->db->query($sql, $param);
        //echo $this->db->last_query();die;
        $result = array();
        if($query->num_rows() > 0){
                $result = $query->result();
        }
        $this->db->trans_complete();
        return $result;
    }

    function getUserDetailsByUserId($userId)
    {
        $this->db->trans_start();
        $query = $this->db->query($this->qc->queryGetUserDetailsByUserId, array($userId));
        $result = array();
        if($query->num_rows() > 0){
                $result = $query->row();
        }
        $this->db->trans_complete();
        return $result;
    }
    
    function getSkillDetailById($userId)
    {
        $this->db->trans_start();
        $query = $this->db->query($this->qc->queryGetSkillDetailById, array($userId));
        $this->cmm->print_log('Model:Usermanager:getSkillDetailById','Query => '.$this->db->last_query());
        $result = array();
        if($query->num_rows() > 0){
            $result = $query->row();
            $this->cmm->print_log('Model:Usermanager:getSkillDetailById','Query => '.print_r($result,true));
        }
        $this->db->trans_complete();
        return $result;
    }

    function getExperienceDetailByEmployeeId($employeeId)
    {
        //echo 'hello';
        $this->db->trans_start();
        $query = $this->db->query($this->qc->queryGetExperienceDetailByEmployeeId, array($employeeId));
        $this->cmm->print_log('Model:Usermanager:getExperienceDetailByEmployeeId','Query => '.$this->db->last_query());
        //echo $this->db->last_query();die;
        $result = array();
        if($query->num_rows() > 0){
                $result = $query->result();
                $this->cmm->print_log('Model:Usermanager:getExperienceDetailByEmployeeId','Query => '.print_r($result,true));
        }
        $this->db->trans_complete();
        return $result;
    }    
    
    function getReviewDataByEmployeeId($employeeId){
        $siteUrl    = site_url($this->config->item('user_images_thumb_path'));
        $this->db->trans_start();
        $query = $this->db->query($this->qc->queryGetReviewDataByEmployeeId, array($siteUrl,$employeeId));
        $this->cmm->print_log('Model:Usermanager:getReviewDataByEmployeeId','Query => '.$this->db->last_query());
        $result = array();
        if($query->num_rows() > 0){
                $result = $query->result();
                $this->cmm->print_log('Model:Usermanager:getReviewDataByEmployeeId','Query => '.print_r($result,true));
        }
        $this->db->trans_complete();
        return $result;
    }
    
    function getAvgReviewRatingByEmployeeId($employeeId){
        $this->db->trans_start();
        $query = $this->db->query($this->qc->queryGetAvgReviewRatingByEmployeeId, array($employeeId));
        $this->cmm->print_log('Model:Usermanager:getAvgReviewRatingByEmployeeId','Query => '.$this->db->last_query());
        $result = array();
        $avg = 0;
        if($query->num_rows() > 0){
                $result = $query->row();
                $avg = $result->avg_rating!=''?$result->avg_rating:0;
                $this->cmm->print_log('Model:Usermanager:getAvgReviewRatingByEmployeeId','Query => '.print_r($result,true));
        }
        $this->db->trans_complete();
        return $avg;
    }
    
    
    
    function getRatingDataByEmployeeId($employeeId){
        $siteUrl    = site_url($this->config->item('user_images_thumb_path'));
        $this->db->trans_start();
        $query = $this->db->query($this->qc->queryGetRatingDataByEmployeeId, array($siteUrl,$employeeId));
        $this->cmm->print_log('Model:Usermanager:getRatingDataByEmployeeId','Query => '.$this->db->last_query());
        $result = array();
        if($query->num_rows() > 0){
                $result = $query->result();
                $this->cmm->print_log('Model:Usermanager:getRatingDataByEmployeeId','Query => '.print_r($result,true));
        }
        $this->db->trans_complete();
        return $result;
    }
    

    function getGuardDataByCompanyId($companyId)
    {
        $siteUrl    = site_url($this->config->item('user_images_thumb_path'));
        $this->db->trans_start();
        $query = $this->db->query($this->qc->queryGetGuardDataByCompanyId, array($siteUrl,$companyId));
        $this->cmm->print_log('Model:Usermanager:getGuardDataByCompanyId','Query => '.$this->db->last_query());
        $result = array();
        if($query->num_rows() > 0){
            $result = $query->result();
            $this->cmm->print_log('Model:Usermanager:getGuardDataByCompanyId','Query => '.print_r($result,true));
        }
        $this->db->trans_complete();
        return $result;
    }   

    

    function getAllUserRole($order=0){
       // echo $order;
        $this->db->trans_start();
        $query = $this->db->query($this->qc->queryGetAllUserRole, array($order));
        $this->cmm->print_log('Model:Usermanager:getAllUserRole','Query => '.$this->db->last_query());
        //echo $this->db->last_query();die;
        $result = array();
        if($query->num_rows() > 0){
            $result = $query->result();
            $this->cmm->print_log('Model:Usermanager:getAllUserRole','Query => '.print_r($result,true));
        }
        $this->db->trans_complete();
        return $result;
    }

    /*function getLast7InspectionDetails(){
        $this->db->trans_start();
        $query = $this->db->query($this->qc->queryGetLast7InspectionDetails, array());
        $result = array();
        if($query->num_rows() > 0){
                $result = $query->result();
        }
        $this->db->trans_complete();
        return $result;   
    } */       

    function getInspInstDataByFilter($where=''){ 
        $sql  = $this->qc->queryGetInspInstDataByFilter;
        $con  = '';
        $search = '#WHERE#';
        $passingarray = array();        
        $sql = str_replace($search,$where, $sql);
        $this->db->trans_start();
        $query = $this->db->query($sql, $passingarray);
        //echo $this->db->last_query();die;
        
        $this->cmm->print_log('Model:Usermanager:getInspInstDataByFilter','Query => '.$this->db->last_query());
        $result = array();
        if($query->num_rows() > 0){
                $result = $query->result();
                $this->cmm->print_log('Model:Usermanager:getInspInstDataByFilter','Query => '.print_r($result,true));
        }
        $this->db->trans_complete();
        return $result;
    }
    
    function getEmployeeDocByEmployeeId($employeeID){
        $sql=$this->qc->queryGetEmployeeDocByEmployeeId;
        $this->db->trans_start();
        $result = array();        
        $query = $this->db->query($sql,array($employeeID));
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
    
    function getSkillDetailByEmployeeId($employeeID){
        $sql=$this->qc->queryGetSkillDetailByEmployeeId;
        $this->db->trans_start();
        $result = array();        
        $query = $this->db->query($sql,array($employeeID));
        if($query->num_rows() > 0){
                $result = $query->result();
        }
        $this->db->trans_complete();
        return $result;
    }
    
    function getQualificationList($qualificationType){
        $sql=$this->qc->queryGetQualificationList;
        $this->db->trans_start();
        $result = array();        
        $query = $this->db->query($sql,array($qualificationType));
        if($query->num_rows() > 0){
                $result = $query->result();
        }
        $this->db->trans_complete();
        return $result;
    }
    
    function delQualification($employeeId,$isQualification)
    {
        $sql=$this->qc->queryDelQualification;
        $this->db->trans_start();
        $query = $this->db->query($sql,array($employeeId,$isQualification));
        $this->db->trans_complete();
    }
    
    function getQualificationByEmployeeId($employeeId)
    {
        $sql=$this->qc->queryGetQualificationByEmployeeId;
        $this->db->trans_start();
        $result = array();        
        $query = $this->db->query($sql,array($employeeId));
        if($query->num_rows() > 0){
                $result = $query->result();
        }
        $this->db->trans_complete();
        return $result;
    }
    
    
    function deleteExperienceByEmployeeId($employeeId)
    {
        $sql=$this->qc->queryDeleteExperienceByEmployeeId;
        $this->db->trans_start();
        $query = $this->db->query($sql,array($employeeId));
        $this->db->trans_complete();
    }
    
    function getAllLanguages()
    {
        $sql = $this->qc->queryGetAllLanguages;
        $this->db->trans_start();
        $result = array();        
        $query = $this->db->query($sql,array());
        if($query->num_rows() > 0){
                $result = $query->result();
        }
        $this->db->trans_complete();
        return $result;
    }
    
    function getLanguageDetailByEmployeeId($employeeId)
    {
        $sql=$this->qc->queryGetLanguageDetailByEmployeeId;
        $this->db->trans_start();
        $result = array();        
        $query = $this->db->query($sql,array($employeeId));
        //echo $this->db->last_query();die;
        if($query->num_rows() > 0){
                $result = $query->result();
        }
        $this->db->trans_complete();
        return $result;
    }
    
    function checkOldPassword($userid,$password){
        $this->db->trans_start();
        $query = $this->db->query($this->qc->queryGetUserByUserIdPassword, array($userid,$password));
        //echo $this->db->last_query();die;
        $this->cmm->print_log('Model:usermanager:checkOldPassword','Query => '.$this->db->last_query());
        $result = false;
        if($query->num_rows() > 0){
                $result = true;
                //print_r($result);die;
                $this->cmm->print_log('Model:usermanager:checkOldPassword','Query Response => '.print_r($result,true));
        }
        $this->db->trans_complete();
        return $result;
    }
    
    function checkEmployeeId($employeeID,$userId){
        $sql = $this->qc->queryCheckEmployeeId;
        $this->db->trans_start();
        if($userId){
           $sql .= ' AND user_id != ? '; 
        }
        $query = $this->db->query($sql, array($employeeID,$userId));
        //echo $this->db->last_query();die;
        $this->cmm->print_log('Model:usermanager:queryCheckEmployeeId','Query => '.$this->db->last_query());
        $result = false;
        if($query->num_rows() > 0){
                $result = true;
                //print_r($result);die;
                $this->cmm->print_log('Model:usermanager:queryCheckEmployeeId','Query Response => '.print_r($result,true));
        }
        $this->db->trans_complete();
        return $result;
    }


    /*
    function getLast7DaysInspectionDetails(){
        $this->db->trans_start();
        $query = $this->db->query($this->qc->queryGetLast7InspectionDetails, array());
        $result = array();
        if($query->num_rows() > 0){
                $result = $query->result();
        }
       // echo $this->db->last_query();
        $this->db->trans_complete();
        return $result;
    }*/
/*END MODEL FUNCTIONS FOR USERS LIST GET ADD EDIT*/
}