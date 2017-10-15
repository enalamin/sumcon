<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Transfer_model extends CI_Model
{
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
		$this->db->query("SET time_zone='+6:00'");
    }
    function getTransferNumber()
    {
        $this->db->select('concat("SBPT",(ifnull(max(substr(transfer_number,5)),160000)+1)) as transferno');
        $this->db->from('tbl_stock_transfer');
        return $this->db->get()->row()->transferno;        
    }
    
    function createStockTransfer($data)
    {
        return $this->db->insert_batch('tbl_stock_transfer', $data);        
    }
    
    function getTransferList($status=NULL)
    {
        $sql = "SELECT 
                    st.transfer_number,st.transfer_date,fl.location_name as fromlocation,st.location_from,st.location_to,tl.location_name as tolocation,sum(st.quantity) as totalqty,st.status,st.entry_by 
                FROM 
                    tbl_stock_transfer as st 
                    left join tbl_location as fl on st.location_from=fl.location_id 
                    left join tbl_location as tl on st.location_to=tl.location_id 
                WHERE 1 
                    ".($status!=NULL?" and st.status='".$status."'":"")."
                group by 
                    st.transfer_number
                order by 
                    st.transfer_number desc
                ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    
    function getTransfer($transferNumber)
    {
        $sql = "SELECT 
                    st.*,tbl_product.*,fl.location_name as fromlocation,tl.location_name as tolocation
                FROM 
                    tbl_stock_transfer as st 
                    inner join tbl_product using(product_id)
                    left join tbl_location as fl on st.location_from=fl.location_id 
                    left join tbl_location as tl on st.location_to=tl.location_id 
                WHERE 
                    st.transfer_number=?                
                ";
        $query = $this->db->query($sql,array($transferNumber));
        return $query->result_array();
    }
    
    function updateStatus($transferNumber,$dataArray)
    {
        if($dataArray['status']==1){
            $sql = "insert into tbl_stock_out(stock_out_type,referrence_number,stock_out_date,product_id,quantity,rate,location_id,entry_by) SELECT 'stock Transfer' as outtype,transfer_number,curdate() as outdate, product_id,`quantity`,product_rate,`location_from`,? FROM `tbl_stock_transfer` inner join tbl_product using (product_id) where transfer_number = ?";
        }elseif ($dataArray['status']==2) {
            $sql = "insert into tbl_stock_receive(stock_receive_type,referrence_number,stock_receive_date,product_id,quantity,rate,location_id,entry_by) SELECT 'stock Transfer' as outtype,transfer_number,curdate() as outdate, product_id,`quantity`,product_rate,`location_to`,? FROM `tbl_stock_transfer` inner join tbl_product using (product_id) where tbl_stock_transfer.status =1 and transfer_number = ? ";
        }
        
        $query = $this->db->query($sql,array($this->session->userdata('username'),$transferNumber));
        return $this->db
                ->where('transfer_number',$transferNumber)
                ->update('tbl_stock_transfer', $dataArray );        
    }
    
}
?>
