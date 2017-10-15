<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Client_model extends CI_Model
{
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
		$this->db->query("SET time_zone='+6:00'");
    }

    
    function get_client($clientId=NULL)
    {
        if($clientId==NULL){
            $sql = "select * from tbl_client where 1";
            $query = $this->db->query($sql);
        }else {
            $sql = "select * from tbl_client where 1 and client_id=?";
            $query = $this->db->query($sql,array($clientId));
        }
        
        return $query->result_array();
    }
    
    function create_client($data)
    {
        return $this->db->insert('tbl_client', $data);
        
    }
	
	function update_client($clientId,$dataArray)
    {
        return $this->db
                ->where('client_id',$clientId)
                ->update('tbl_client', $dataArray );
        
    }
}
?>