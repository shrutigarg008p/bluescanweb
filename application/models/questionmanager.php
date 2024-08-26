<?php
class Questionmanager extends CI_Model{
    function __construct(){
        // Call the Model constructor
        parent::__construct();
    }
    
    function getAllQuestionList($companyId,$offset,$perPage,$countFlag=false){
        $sql  = $this->qc->queryGetAllQuestionList;        
        $this->db->trans_start();
        if($countFlag){
            $sql    = str_replace('LIMIT ?, ?','', $sql);
            $query = $this->db->query($sql,array($companyId));
            $result = $query->num_rows();
        }else{
            $result = array();
            $query = $this->db->query($sql,array($companyId,$offset,$perPage));
            //echo $this->db->last_query();die;
            if($query->num_rows() > 0){
                    $result = $query->result();
            }
        }
        $this->db->trans_complete();
        return $result;
    }
    
    function getQuestionByCompanyId($companyId,$groupId){
        $result = array();
        $sql  = $this->qc->queryGetQuestionByCompanyId;
        $this->db->trans_start();
        $sql    = str_replace('LIMIT ?, ?','', $sql);
        $query = $this->db->query($sql,array($companyId,$groupId));
        if($query->num_rows() > 0){
                $result = $query->result();
        }
        $this->db->trans_complete();
        return $result;
    }
    
    function getGroupQuestByGroupId($groupId){
        $result = array();
        $sql  = $this->qc->queryGetGroupQuestByGroupId;
        $sql  = str_replace('LIMIT ?, ?',' ORDER BY ques.question_id DESC LIMIT ?, ?', $sql);
        $this->db->trans_start();
        $query = $this->db->query($sql,array($groupId));
        if($query->num_rows() > 0){
                $result = $query->result();
        }
        $this->db->trans_complete();
        return $result;
    }
    
    function getQuestionIdDetailsByQuestionIdId($questionId){
        $this->db->trans_start();
        $query = $this->db->query($this->qc->queryGetQuestDetailsByQuesIdId, array($questionId));
        $result = array();
        if($query->num_rows() > 0){
                $result = $query->row();
        }
        $this->db->trans_complete();
        return $result;
    }
    
    function getAllQuestionGroupList($companyId,$offset,$perPage,$countFlag=false){
        $sql  = $this->qc->queryGetAllQuestionGroupList;
        $sql  = str_replace('LIMIT ?, ?',' ORDER BY g.group_id DESC LIMIT ?, ?', $sql);
        $this->db->trans_start();
        if($countFlag){
            $sql    = str_replace('LIMIT ?, ?','', $sql);
            $query = $this->db->query($sql,array($companyId));
            $result = $query->num_rows();
        }else{
            $result = array();
            $query = $this->db->query($sql,array($companyId,$offset,$perPage));
            //echo $this->db->last_query();die;
            if($query->num_rows() > 0){
                    $result = $query->result();
            }
        }
        $this->db->trans_complete();
        return $result;
    }
    
    function getAllQuestionGroupDropdown($companyId){
        $this->db->trans_start();
        $query = $this->db->query($this->qc->queryGetAllQuestionGroupDropdown, array($companyId));
        $result = array();
        if($query->num_rows() > 0){
                $result = $query->result();
        }
        $this->db->trans_complete();
        return $result;
    }
    
    function getGroupDataByGroupId($groupId){
        $this->db->trans_start();
        $query = $this->db->query($this->qc->queryGetGroupDataByGroupId, array($groupId));
        $result = array();
        if($query->num_rows() > 0){
                $result = $query->row();
        }
        $this->db->trans_complete();
        return $result;
    }
    
    function getAllGroupDropdownByCompanyId($companyId){
        $this->db->trans_start();
        $query = $this->db->query($this->qc->queryGetAllGroupDropdownByCompanyId, array($companyId));
        $result = array();
        if($query->num_rows() > 0){
                $result = $query->result();
        }
        $this->db->trans_complete();
        return $result;
    }
    
     function checkQuestionExistanceIngroup($groupId,$questionId){
        $this->db->trans_start();
        $query = $this->db->query($this->qc->queryCheckQuestionExistanceIngroup, array($groupId,$questionId));
         $this->cmm->print_log('Model:questionmanager:queryCheckQuestionExistanceIngroup','Query => '.$this->db->last_query());
        $result = false;
        if($query->num_rows() == 0){
                $result = true;
                $this->cmm->print_log('Model:questionmanager:queryCheckQuestionExistanceIngroup','result => '.print_r($query->result(),true));
        }
        $this->db->trans_complete();
        return $result;
    }
    
    function getQuestionDataBySiteId($siteId){
       $result = array();
        if($siteId){
            $this->db->trans_start();
            $query = $this->db->query($this->qc->queryGetQuestionDataBySiteId, array($siteId));
           
            $this->cmm->print_log('Model:questionmanager:getQuestionDataBySiteId','Query Response => '.print_r($query,true));
            if($query->num_rows() > 0){
                    $result = $query->result();
            }
            $this->db->trans_complete();
        }
        return $result;
    }
    
    function getQuestionDataByGuardId($guardId){
        $this->db->trans_start();
        $query = $this->db->query($this->qc->queryGetQuestionDataByGuardId, array($guardId));
        $this->cmm->print_log('Model:questionmanager:getQuestionDataByGuardId','Query => '.$this->db->last_query());
        $this->cmm->print_log('Model:questionmanager:getQuestionDataByGuardId','Query Response => '.print_r($query,true));
        $result = array();
        if($query->num_rows() > 0){
                $result = $query->result();
        }
        $this->db->trans_complete();
        return $result;
    }

    function getGuardQuestionData(){
        $this->db->trans_start();
        $query = $this->db->query($this->qc->queryGetGuardQuestionData, array());
        $this->cmm->print_log('Model:questionmanager:getGuardQuestionData','Query => '.$this->db->last_query());
       //echo $this->db->last_query();
        $result = array();
        if($query->num_rows() > 0){
                $result = $query->result();
                 $this->cmm->print_log('Model:questionmanager:getGuardQuestionData','Query Response => '.print_r($result,true));
        }
        $this->db->trans_complete();
        return $result;
    }
    
    function getQuestionListByCompanyId()
    {        
        $this->db->trans_start();
        $query = $this->db->query($this->qc->queryGetQuestionListByCompanyId, array());
        $this->cmm->print_log('Model:questionmanager:getQuestionListByCompanyId','Query => '.$this->db->last_query());
       //echo $this->db->last_query();
        $result = array();
        if($query->num_rows() > 0){
                $result = $query->result();
                 $this->cmm->print_log('Model:questionmanager:getQuestionListByCompanyId','Query Response => '.print_r($result,true));
        }
        $this->db->trans_complete();
        return $result;
    }
   
}