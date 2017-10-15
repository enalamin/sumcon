<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Employee_model extends CI_Model
{
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
		    $this->db->query("SET time_zone='+6:00'");
    }

    function get_employee($employeeId=NULL)
    {
        if($employeeId==NULL){
            $sql = "select tbl_employee.*,tbl_client.client_name from tbl_employee inner join tbl_client using(client_id) where 1 and client_id=118";
            $query = $this->db->query($sql);
        }else {
            $sql = "select tbl_employee.*,tbl_client.client_name from tbl_employee inner join tbl_client using(client_id) where 1 and employee_id=?";
            $query = $this->db->query($sql,array($employeeId));
        }

        return $query->result_array();
    }

    function get_company_employee($companyId)
    {
        $sql = "select tbl_employee.*,tbl_client.client_name from tbl_employee inner join tbl_client using(client_id) where 1 and client_id=?";
        $query = $this->db->query($sql,array($companyId));
        return $query->result_array();
    }

	function create_employee($data)
    {
        return $this->db->insert('tbl_employee', $data);
    }

}
?>
