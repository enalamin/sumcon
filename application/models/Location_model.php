<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Location_model extends CI_Model
{
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
		$this->db->query("SET time_zone='+6:00'");
    }

    
    
    function getLocations($locationId=NULL)
    {
        $sql = "select * from tbl_location where 1 ".($locationId!=NULL?" and location_id='".$locationId."'":"")."";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    
    function createLocation($data)
    {
        return $this->db->insert('tbl_location', $data);
        
    }
}
?>