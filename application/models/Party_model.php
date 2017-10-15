<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Party_model extends CI_Model
{
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
		$this->db->query("SET time_zone='+6:00'");
    }

    
    function get_party($partyId=NULL)
    {
		if($partyId==NULL){
			$sql = "select * from tbl_party where 1";
			$query = $this->db->query($sql);
		}else {
			$sql = "select * from tbl_party where 1 and party_id=?";
			$query = $this->db->query($sql,array($partyId));
		}
        
        return $query->result_array();
    }
    
    function create_party($data)
    {
        return $this->db->insert('tbl_party', $data);
        
    }
	
	function update_party($partyId,$dataArray)
    {
        return $this->db
                ->where('party_id',$partyId)
                ->update('tbl_party', $dataArray );
        
    }
}
?>