<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bank_model extends CI_Model
{
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
		    $this->db->query("SET time_zone='+6:00'");
    }


    function get_bank($bankId=NULL)
    {
        if($bankId==NULL){
            $sql = "select * from tbl_bank where 1";
            $query = $this->db->query($sql);
        }else {
            $sql = "select * from tbl_bank where 1 and bank_id=?";
            $query = $this->db->query($sql,array($bankId));
        }

        return $query->result_array();
    }

    function get_bank_account($accountNo=NULL)
    {
        if($accountNo==NULL){
            $sql = "select tbl_bank_account.*,tbl_bank.bank_name from tbl_bank_account inner join tbl_bank using(bank_id) where 1";
            $query = $this->db->query($sql);
        }else {
            $sql = "select tbl_bank_account.*,tbl_bank.bank_name from tbl_bank_account inner join tbl_bank using(bank_id) where 1 and account_no=?";
            $query = $this->db->query($sql,array($accountNo));
        }

        return $query->result_array();
    }

    function get_bank_accounts($bankId=NULL)
    {
        $sql = "select tbl_bank_account.*,tbl_bank.bank_name from tbl_bank_account inner join tbl_bank using(bank_id) where 1 and bank_id=?";
        $query = $this->db->query($sql,array($bankId));
        return $query->result_array();
    }

	  function create_bank($data)
    {
        return $this->db->insert('tbl_bank', $data);
    }

    function create_bank_account($data)
    {
        return $this->db->insert('tbl_bank_account', $data);
    }


    function create_bank_deposit($data)
    {
        return $this->db->insert('tbl_bank_deposit', $data);
    }

    function get_all_cheque($status = NULL)
    {
        $sql="SELECT
                tbl_client.*,tbl_collection.*,tbl_bank.*
              FROM
                `tbl_client` inner join tbl_collection using(client_id)
				left join tbl_bank on tbl_bank.bank_id=tbl_collection.bank_id
              WHERE 1
				and collection_type = 'cheque'
				and tbl_collection.status='1'
                ".($status!=NULL? " and tbl_collection.cheque_status='".$status."'" :"")."
               ";

        $query = $this->db->query($sql);
        return $query->result_array();
    }

    function get_cheque_collections($clientId=NULL,$status,$fromDate=NULL,$toDate=NULL)
    {
        $sql="SELECT
                tbl_client.*,tbl_collection.*,tbl_bank.*
              FROM
                `tbl_client` inner join tbl_collection using(client_id)
				left join tbl_bank on tbl_bank.bank_id=tbl_collection.bank_id
              WHERE 1
				and collection_type = 'cheque'
				and tbl_collection.status='1'
                 ".($clientId?" and tbl_client.client_id='".$clientId."'":"")."
                ".($status!='all'? " and tbl_collection.cheque_status='".$status."'" :"")."
                ".($fromDate!=NULL || $toDate!=NULL ? " and tbl_collection.collection_date between '".$fromDate."' and '".$toDate."'" :"")."
               ";

        $query = $this->db->query($sql);
        return $query->result_array();
    }

    function get_deposited_cheque($collectionId)
    {
      $sql = "SELECT * FROM `tbl_bank_deposit` INNER JOIN tbl_collection USING(collection_id) WHERE collection_id=?";
      $query = $this->db->query($sql,array($collectionId));
      return $query->result_array();
    }

    function get_cheque_bounce_id($collectionId)
    {
        $this->db->select('deposit_id');
        $this->db->from('tbl_bank_deposit');
        $this->db->where('deposit_status','bounce');
        $this->db->where('collection_id',$collectionId);
        if($this->db->get()->row())
            return 1;
        else
            return 0;    
        
        
    }

    function update_deposit($depositId,$dataArray)
    {
        return $this->db
            ->where('deposit_id',$depositId)
            ->update('tbl_bank_deposit', $dataArray );

    }

}
?>
