<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lc_model extends CI_Model
{
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
		$this->db->query("SET time_zone='+6:00'");
    }


    function get_proforma($lcId=NULL)
    {
        if($lcId==NULL){
            $sql = "select tbl_lc.*,tbl_client.*,tbl_bank.bank_name from tbl_lc inner join tbl_client on tbl_client.client_id=tbl_lc.supplier_id left join tbl_bank using (bank_id) where 1 and tbl_lc.lc_no is null";
            $query = $this->db->query($sql);
        }else {
            $sql = "select 
                        tbl_lc.*,
                        tbl_client.*,
                        tbl_bank.bank_name,
                        sum(tbl_lc_goods.receive_quantity) as totalQty 
                    from 
                        tbl_lc 
                        left join tbl_lc_goods using(lc_id)
                        inner join tbl_client on tbl_client.client_id=tbl_lc.supplier_id 
                        left join tbl_bank using (bank_id) 
                    where 
                        1 and lc_id=?";
            $query = $this->db->query($sql,array($lcId));
        }

        return $query->result_array();
    }

    function get_lc($lcId=NULL)
    {
        if($lcId==NULL){
            $sql = "select tbl_lc.*,tbl_client.*,tbl_bank.bank_name from tbl_lc inner join tbl_client on tbl_client.client_id=tbl_lc.supplier_id left join tbl_bank using (bank_id) where 1 and tbl_lc.lc_no is not null";
            $query = $this->db->query($sql);
        }else {
            $sql = "select tbl_lc.*,tbl_client.*,tbl_bank.bank_name from tbl_lc inner join tbl_client on tbl_client.client_id=tbl_lc.supplier_id left join tbl_bank using (bank_id) where 1 and lc_id=?";
            $query = $this->db->query($sql,array($lcId));
        }

        return $query->result_array();
    }

    function get_lc_batch($lcId=NULL)
    {
        if($lcId==NULL){
            $sql = "select 
                        tbl_lc.*,tbl_client.*,tbl_lc_batch.batch_name,tbl_lc_batch.doc_release_value, tbl_lc_batch.dollar_rate,tbl_lc_batch.status as batch_status 
                    from 
                        tbl_lc 
                        inner join tbl_client on tbl_client.client_id=tbl_lc.supplier_id 
                        inner join tbl_lc_batch using (lc_id)";
            $query = $this->db->query($sql);
        }else {
            $sql = "select tbl_lc.*,tbl_client.*,tbl_bank.bank_name from tbl_lc inner join tbl_client on tbl_client.client_id=tbl_lc.supplier_id left join tbl_bank using (bank_id) where 1 and lc_id=?";
            $query = $this->db->query($sql,array($lcId));
        }

        return $query->result_array();
    }

    function get_lc_batchno($lcId)
    {
        $this->db->select("concat('Batch-',(ifnull(count(lc_id),0)+1)) as batch_no");
        $this->db->from('tbl_lc_batch');
        $this->db->where('lc_id',$lcId);        
        return $this->db->get()->row()->batch_no;
    }

    function get_lc_current_batchno($lcId)
    {
        $sql = "SELECT batch_name FROM tbl_lc_batch WHERE id = (select max(id) from tbl_lc_batch WHERE lc_id=?)";
        $query = $this->db->query($sql,array($lcId));       
        $row= $query->result_array();
        if($row)
            return $row[0]['batch_name'];
        else
            return '';
    }

    function get_lc_batchinof($lcId,$batchName)
    {
         $sql = "select * from tbl_lc_batch where 1 and lc_id=? and batch_name=?";
            $query = $this->db->query($sql,array($lcId,$batchName));
        return $query->result_array();        
    }

    function get_lc_for_receive()
    {
        $sql = "select 
                    tbl_lc.*,
                    tbl_client.*
                from 
                    tbl_lc inner join tbl_client on tbl_client.client_id=tbl_lc.supplier_id 
                    inner join tbl_lc_goods using (lc_id) 
                where 
                    1 
                    and tbl_lc.lc_no is not null 
                    and (tbl_lc_goods.receive_date is NULL or tbl_lc_goods.receive_date = '0000-00-00') 
                group by 
                    tbl_lc.lc_id 
                ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    function get_lc_receive_for_approve()
    {
        $sql = "select 
                    tbl_lc.*,
                    tbl_client.*,
                    tbl_lc_goods_recive.receive_lc_batch,
                    tbl_lc_goods_recive.receive_date,
                    sum(tbl_lc_goods_recive.receive_quantity) as receive_quantity
                from 
                    tbl_lc inner join tbl_client on tbl_client.client_id=tbl_lc.supplier_id 
                    inner join tbl_lc_goods_recive using (lc_id) 
                where 
                    1 
                    and tbl_lc.lc_no is not null 
                    and tbl_lc_goods_recive.receive_by is not null
                    and (tbl_lc_goods_recive.approve_by is null or tbl_lc_goods_recive.approve_by='' or tbl_lc_goods_recive.approve_by='0')
                group by 
                    tbl_lc.lc_id,tbl_lc_goods_recive.receive_lc_batch 
                ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    function approve_lc_receive($lcId,$batchName)
    {
        return $this->db
                ->where('lc_id',$lcId)
                ->where('receive_lc_batch',$batchName)
                ->update('tbl_lc_goods_recive', array('approve_by' => $this->session->userdata('username'), 'approve_date' => date('Y-m-d') ) );
    } 

    function lc_stock_receive($lcId,$productId,$productRate,$batchName)
    {
        $sql = "insert into tbl_stock_receive(stock_receive_type,referrence_number,stock_receive_date,product_id,quantity,rate,location_id,entry_by) SELECT 'LC Goods Receive' as receivetype,lc_no,curdate() as receivedate, product_id,receive_quantity,? ,location_id,? FROM `tbl_lc` inner join tbl_lc_goods_recive using (lc_id) where 1 and tbl_lc.lc_no is not null 
                    and tbl_lc_goods_recive.receive_by is not null and tbl_lc.lc_id=? and tbl_lc_goods_recive.product_id=? and tbl_lc_goods_recive.receive_lc_batch=?";
        return $query = $this->db->query($sql,array($productRate,$this->session->userdata('username'),$lcId,$productId,$batchName));
        
    }

    function get_lc_for_commission()
    {
        $sql = "select 
                    tbl_lc.*,
                    tbl_client.*,
                    tbl_lc_goods.receive_date,
                    sum(tbl_lc_goods.receive_quantity) as receive_quantity
                from 
                    tbl_lc inner join tbl_client on tbl_client.client_id=tbl_lc.supplier_id 
                    inner join tbl_lc_goods using (lc_id) 
                where 
                    1 
                    and tbl_lc.lc_no is not null 
                    and tbl_lc_goods.receive_by is not null
                    and tbl_lc_goods.approve_by is not null
                    and (tbl_lc_goods.commission_percent is null or tbl_lc_goods.commission_percent=0)
                group by 
                    tbl_lc.lc_id 
                ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    function create_lc($data)
    {
        $this->db->insert('tbl_lc', $data);
        return $this->db->insert_id();
    }

    function update_lc($lcId,$dataArray)
    {
        return $this->db
            ->where('lc_id',$lcId)
            ->update('tbl_lc', $dataArray );
    }

    function delete_lc_goods($lcId)
    {
        return $this->db
            ->where('lc_id',$lcId)
            ->delete('tbl_lc_goods');
    }

    function create_lc_goods($data)
    {
        return $this->db->insert_batch('tbl_lc_goods', $data);
    }

    function create_lc_recive_batch($data)
    {
        return $this->db->insert('tbl_lc_batch', $data);
    }

    function update_lc_receive_batch($lcId,$batchName,$dataArray)
    {
         return $this->db
            ->where('lc_id',$lcId)
            ->where('batch_name',$batchName)
            ->update('tbl_lc_batch',$dataArray);
    }

    function create_lc_bill_of_entry($data)
    {
        return $this->db->insert_batch('tbl_lc_bill_of_entry', $data);
    }

    function create_lc_goods_receive($data)
    {
        return $this->db->insert_batch('tbl_lc_goods_recive', $data);
    }

    function create_lc_under_invoice($data)
    {
        return $this->db->insert_batch('tbl_lc_under_invoice', $data);
    }
    
    function create_lc_history($data)
    {
        return $this->db->insert('tbl_lc_history', $data);
    }

    function get_lc_history($lcId)
    {
      $sql="select * from tbl_lc_history where lc_id=?";
      $query = $this->db->query($sql,array($lcId));
      return $query->result_array();
    }

    function create_lc_cost($data)
    {
        return $this->db->insert('tbl_lc_costing', $data);
    }

    function get_lc_costing($lcId)
    {
      $sql="select * from tbl_lc_costing where lc_id=?";
      $query = $this->db->query($sql,array($lcId));
      return $query->result_array();
    }

    function get_lc_costing_summery($lcId,$batchName)
    {
      $sql="select costing_head,sum(amount) as amount,distribution_base from tbl_lc_costing where lc_id=? and receive_lc_batch=? group by costing_head";
      $query = $this->db->query($sql,array($lcId,$batchName));
      return $query->result_array();
    }

    function update_lc_goods($lcId,$productId,$data)
    {
        return $this->db
            ->where("lc_id",$lcId)
            ->where("product_id",$productId)
            ->update('tbl_lc_goods', $data);
    }
    function getgGoodsReceive($lcId,$batchName=NULL)
    {
        if($batchName){
            $sql = "SELECT
                    tbl_lc_goods_recive.*,tbl_product.*,tbl_lc_bill_of_entry.amount as bill_of_entry,tbl_lc_under_invoice.invoice_no,tbl_lc_under_invoice.invoice_date,tbl_lc_under_invoice.dollar_unit_price,tbl_lc_under_invoice.dollar_conversion_rate,tbl_lc_under_invoice.dollar_amount,tbl_lc_under_invoice.invoice_amount
                FROM
                    tbl_lc_goods_recive
                    INNER JOIN tbl_product USING ( product_id ) 
                    LEFT JOIN tbl_lc_bill_of_entry ON ( tbl_lc_bill_of_entry.lc_id = tbl_lc_goods_recive.lc_id AND tbl_lc_bill_of_entry.product_id = tbl_lc_goods_recive.product_id and tbl_lc_goods_recive.receive_lc_batch=tbl_lc_bill_of_entry.receive_lc_batch ) 
                    LEFT JOIN tbl_lc_under_invoice ON ( tbl_lc_under_invoice.lc_id = tbl_lc_goods_recive.lc_id AND tbl_lc_under_invoice.product_id = tbl_lc_goods_recive.product_id and tbl_lc_goods_recive.receive_lc_batch=tbl_lc_under_invoice.receive_lc_batch ) 
                WHERE 1
                    and tbl_lc_goods_recive.lc_id=?
                    and tbl_lc_goods_recive.receive_lc_batch=?";
            $query = $this->db->query($sql,array($lcId,$batchName));
        }
        else {
            $sql = "SELECT
                        tbl_lc_goods.*,tbl_product.*
                    FROM
                        tbl_lc_goods
                        INNER JOIN tbl_product USING ( product_id ) 
                        /*LEFT JOIN tbl_lc_bill_of_entry ON ( tbl_lc_bill_of_entry.lc_id = tbl_lc_goods.lc_id AND tbl_lc_bill_of_entry.product_id = tbl_lc_goods.product_id ) 
                        LEFT JOIN tbl_lc_under_invoice ON ( tbl_lc_under_invoice.lc_id = tbl_lc_goods.lc_id AND tbl_lc_under_invoice.product_id = tbl_lc_goods.product_id ) */
                    WHERE 1
                        and tbl_lc_goods.lc_id=?";
            $query = $this->db->query($sql,array($lcId));
        }
        return $query->result_array();
    }

}
?>
