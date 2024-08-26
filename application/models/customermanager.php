<?php
class Customermanager extends CI_Model{
    function __construct(){
        // Call the Model constructor
        parent::__construct();
    }
    
    function getAllCustomerList($where,$offset,$perPage,$countFlag=false){
        $sql  = $this->qc->queryGetAllCustomerList;
        if($where != ''){
            $sql    = str_replace('ORDER BY cust.customer_id DESC',$where.' ORDER BY cust.customer_id DESC', $sql);
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
    
    function getCustomerDetailsByCustomerId($customerId){
        $this->db->trans_start();
        $query = $this->db->query($this->qc->queryGetCustomerDetailsByCustomerId, array($customerId));
        $result = array();
        if($query->num_rows() > 0){
                $result = $query->row();
        }
        $this->db->trans_complete();
        return $result;
    }
    
    
    function getAllCustomerDropdown($is_deleted = 0,$where=''){
        $sql=$this->qc->queryGetAllCustomerDropdown;
        $this->db->trans_start();
        
        $condition  = '';
        if($where!=''){
           $condition  = $where;
           if($is_deleted){
               $condition  .= 'AND';
           }
        }else if($is_deleted){
           $condition  .= 'WHERE ';
        }
        
        if($is_deleted){
            $condition  = ' is_deleted = 1';
        }
        $sql    = str_replace('#WHERE#', $condition, $sql);
        
        $query  = $this->db->query($sql,array());
        //echo $this->db->last_query();die;
        $result = array();
        if($query->num_rows){
            $result = $query->result();
        }
        $this->db->trans_complete();
        return $result;        
    }
    
}