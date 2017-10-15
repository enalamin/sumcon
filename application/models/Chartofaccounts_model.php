<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Chartofaccounts_model extends CI_Model
{
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
		$this->db->query("SET time_zone='+6:00'");
    }

    function get_groups()
    {
      $sql = "select * from accounts_group order by group_name";
      $query = $this->db->query($sql);

      return $query->result_array();
    }

    function get_subgroups($groupId)
    {
      $sql = "select * from accounts_sub_group where group_id=? order by sub_group_name";
      $query = $this->db->query($sql,array($groupId));

      return $query->result_array();
    }


    function get_chartofaccounts($accountsHeadId=NULL)
    {
        if($accountsHeadId==NULL){
            $sql = "SELECT * FROM `chart_of_accounts` INNER JOIN accounts_group USING(group_id) INNER JOIN accounts_sub_group USING(sub_group_id) WHERE 1 order by accounts_group.group_id,accounts_sub_group.sub_group_id asc";
            $query = $this->db->query($sql);
        }else {
            $sql = "SELECT * FROM `chart_of_accounts` INNER JOIN accounts_group USING(group_id) INNER JOIN accounts_sub_group USING(sub_group_id) WHERE accounts_head_id=? order by accounts_group.group_id,accounts_sub_group.sub_group_id,accounts_head_id asc";
            $query = $this->db->query($sql,array($accountsHeadId));
        }

        return $query->result_array();
    }

    function create_chartofaccounts($data)
    {
        return $this->db->insert('chart_of_accounts', $data);
        //return $this->db->insert_id();
    }

    function update_chartofaccounts($accountsHeadId,$dataArray)
    {
        return $this->db
            ->where('accounts_head_id',$accountsHeadId)
            ->update('chart_of_accounts', $dataArray );

    }

}
?>
