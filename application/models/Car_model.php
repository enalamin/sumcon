<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Car_model extends CI_Model
{
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
		    $this->db->query("SET time_zone='+6:00'");
    }


    function get_car($carId=NULL)
    {
        if($carId==NULL){
            $sql = "select * from tbl_car where 1";
            $query = $this->db->query($sql);
        }else {
            $sql = "select * from tbl_car where 1 and car_id=?";
            $query = $this->db->query($sql,array($carId));
        }

        return $query->result_array();
    }

    function create_car($data)
    {
        return $this->db->insert('tbl_car', $data);
    }



}
?>
