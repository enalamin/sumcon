<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends CI_Model
{
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
		$this->db->query("SET time_zone='+6:00'");
    }

    
    function get_user($userId=NULL)
    {
        if($userId==NULL){
            $sql = "select tbl_user.*,tbl_location.location_name from tbl_user "
                    . " inner join  tbl_location using(location_id) where 1";
            $query = $this->db->query($sql);
        }else {
            $sql = "select * from tbl_user where 1 and id=?";
            $query = $this->db->query($sql,array($userId));
        }
        
        return $query->result_array();
    }
    
    function usermenuidlist($userId){
        $sql = "select menu_id  from tbl_user_menu where 1 and user_id=?";
        $query = $this->db->query($sql,array($userId));
		return $query->result_array();
    }
            
    function get_userList($userType=NULL)
    {
        if($userType==NULL){
            $sql = "select tbl_user.*,tbl_location.location_name from tbl_user "
                    . " inner join  tbl_location using(location_id) where 1";
            $query = $this->db->query($sql);
        }else {
            $sql = "select * from tbl_user where 1 and user_type=?";
            $query = $this->db->query($sql,array($userType));
        }
        
        return $query->result_array();
    }
    
    function create_user($data)
    {        
        return $this->db->insert('tbl_user', $data);
        //return $this->db->insert_id();
    }

    function update_user($userId,$dataArray)
    {
        return $this->db
            ->where('id',$userId)
            ->update('tbl_user', $dataArray );

    }
	
    function deleteusermenu($userId)
    {
        $sql = "delete  from tbl_user_menu where 1 and user_id=?";
        $query = $this->db->query($sql,array($userId));
        
    }
	
    function usermenu($data)
    {
        return $this->db->insert_batch('tbl_user_menu', $data);
        //return $this->db->insert_id();
    }
	
	
}
?>