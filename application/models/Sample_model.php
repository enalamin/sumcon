<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sample_model extends CI_Model
{
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
		$this->db->query("SET time_zone='+6:00'");
    }

    function getSampleNumber()
    {
        $this->db->select('concat("SBPS",(ifnull(max(substr(sample_number,5)),160000)+1)) as sampleno');
        $this->db->from('tbl_free_sample');
        return $this->db->get()->row()->sampleno;

    }

    function createFreeSample($data)
    {
        return $this->db->insert_batch('tbl_free_sample', $data);

    }

    function getSampleList($status=NULL)
    {
        $sql = "SELECT
                    sample_number,sample_delivery_date,client_name,sum(quantity) as totalqty,tbl_free_sample.status,tbl_free_sample.entry_by,return_date,sum(used_quantity) as totalused,sum(return_quantity) as totalrturn
                FROM
                    tbl_free_sample
                    inner join tbl_client using (client_id)
                WHERE 1
                    ".($status!=NULL?" and tbl_free_sample.status='".$status."'":"")."
                group by
                    sample_number
                ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

	function getdatewiseSample($clientId=0,$fromDate=NULL,$toDate=NULL)
    {
        $sql = "SELECT
                    sample_number,sample_delivery_date,client_name,sum(quantity) as totalqty,tbl_free_sample.status,tbl_free_sample.entry_by
                FROM
                    tbl_free_sample
                    inner join tbl_client using (client_id)
                WHERE 1
                    and tbl_free_sample.status='1'
					".($clientId>0?" and client_id='".$clientId."'":"")."
                    ".($fromDate!=NULL && $toDate!==NULL?" and sample_delivery_date between '".$fromDate."' and '".$toDate."'" : " and sample_delivery_date = curdate()")."
				group by
                    sample_number
				order by
					sample_number
                ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    function getSample($sampleNumber)
    {
        $sql = "SELECT
                    tbl_free_sample.*,
                    tbl_client.client_id,tbl_client.client_name,client_contact_no,client_email,client_office_address,client_delivery_address,
                    product_description,tbl_location.location_name
                FROM
                    tbl_free_sample
                    inner join tbl_client using (client_id)
                    inner join tbl_product using(product_id)
                    left join tbl_location using(location_id)
                WHERE
                    sample_number=?

                ";
        $query = $this->db->query($sql,array($sampleNumber));
        return $query->result_array();
    }

	function productwisesample($fromDate, $toDate, $productId=0, $customerId=0)
    {
        $sql = "SELECT
                    client_id,client_name,client_office_address, client_delivery_address, client_contact_no, client_email,sample_number,sample_delivery_date,tbl_product.product_id,product_name,product_description,quantity,package,remarks
                FROM
                    tbl_free_sample
                    inner join tbl_client using (client_id)
                    inner join tbl_product using(product_id)
                WHERE
                    sample_delivery_date between '".$fromDate."' and '".$toDate."'
					".($productId>0? " and tbl_product.product_id='".$productId."'":"")."
					".($customerId>0? " and tbl_client.client_id='".$customerId."'":"")."
                order by
					sample_delivery_date,product_description asc

                ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    function updateStatus($sampleNumber,$dataArray)
    {
        if($dataArray['status']==1){
            $sql = "insert into tbl_stock_out(stock_out_type,referrence_number,stock_out_date,product_id,quantity,rate,location_id,entry_by) SELECT 'Free Sample' as outtype,sample_number,curdate() as outdate, product_id,`quantity`,product_rate,location_id,? FROM `tbl_free_sample` inner join tbl_product using (product_id) where tbl_free_sample.status=0 and sample_number = ?";
        }
        if($dataArray['status']==3){
            $sql = "insert into tbl_stock_receive(stock_receive_type,referrence_number,stock_receive_date,product_id,quantity,rate,location_id,entry_by) SELECT 'Sample Return' as receivetype,sample_number,curdate() as receivedate, product_id,`return_quantity`,product_rate,location_id,? FROM `tbl_free_sample` inner join tbl_product using (product_id) where tbl_free_sample.status=2 and tbl_free_sample.return_quantity>0 and sample_number = ?";
        }
        $query = $this->db->query($sql,array($this->session->userdata('username'),$sampleNumber));
        return $this->db
                ->where('sample_number',$sampleNumber)
                ->update('tbl_free_sample', $dataArray );


    }

    function sampleReturn($sampleNumber,$productId,$dataArray)
    {
        return $this->db
                ->where('sample_number',$sampleNumber)
                ->where('product_id',$productId)
                ->update('tbl_free_sample', $dataArray );

    }

}
?>
