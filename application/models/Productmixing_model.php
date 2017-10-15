<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Productmixing_model extends CI_Model
{
    function __construct()
    {
       // Call the Model constructor
        parent::__construct();
		$this->db->query("SET time_zone='+6:00'");
    }

    function getMixingRequisitionNumber()
    {
        $this->db->select('concat("SBPM",(ifnull(max(substr(requisition_number,5)),160000)+1)) as reqsitionno');
        $this->db->from('tbl_product_mixing_requisition');
        return $this->db->get()->row()->reqsitionno;
    }

    function createMixingRequisition($data)
    {
        return $this->db->insert_batch('tbl_product_mixing_requisition', $data);
    }

    function getMixingRequisitionList($status=NULL)
    {
        $sql = "SELECT 
                    tbl_product_mixing_requisition.requisition_number,
                    tbl_product_mixing_requisition.requisition_date,
                    sum(tbl_product_mixing_requisition.quantity) as totalqty,
                    tbl_product_mixing_requisition.status,
                    tbl_product_mixing_requisition.entry_by,
                    for_product.product_description as req_product_desc 
                FROM 
                    tbl_product_mixing_requisition
                    left join tbl_product as for_product on tbl_product_mixing_requisition.req_for_product_id= for_product.product_id
                WHERE 1 
                    ".($status!=NULL?" and tbl_product_mixing_requisition.status='".$status."'":"")."
                group by 
                    requisition_number
                ";

        $query = $this->db->query($sql);
        return $query->result_array();
    }

    function getMixingRequisition($requisitionNumber)
    {
        $sql = "SELECT 
                    tbl_product_mixing_requisition.*,tbl_product.product_description,tbl_product.product_unit,for_product.product_description as req_product_desc,for_product.product_unit as req_product_unit
                FROM 
                    tbl_product_mixing_requisition
                    inner join tbl_product using(product_id)
                    left join tbl_product as for_product on tbl_product_mixing_requisition.req_for_product_id= for_product.product_id
                WHERE 
                    requisition_number=?
                ";
        $query = $this->db->query($sql,array($requisitionNumber));
        return $query->result_array();
    }

	function getConvertedProduct($requisitionNumber)
    {
        $sql = "SELECT 
                    *
                FROM 
                    tbl_stock_receive
                    inner join tbl_product using(product_id)
					inner join tbl_location using (location_id)
                WHERE 
    				stock_receive_type='Product Conversion'
                    and referrence_number=?
                ";

        $query = $this->db->query($sql,array($requisitionNumber));
        return $query->result_array();
    }

    function updateStatus($requisitionNumber,$dataArray)
    {
        return $this->db
                ->where('requisition_number',$requisitionNumber)
                ->update('tbl_product_mixing_requisition', $dataArray );
    }

	function getconversioninfo($fromDate=NULL,$toDate=NULL)
	{

		$sql = "SELECT 
					referrence_number,stock_receive_date,product_description,quantity,rate,req_desc 
				FROM 
					tbl_stock_receive 
					inner join tbl_product using(product_id) 
					inner join (SELECT 
									requisition_number,group_concat(concat(product_description,' -> ',quantity,' ',product_unit) separator '<br />') as req_desc
								FROM 
									tbl_product_mixing_requisition
									inner join tbl_product using(product_id)
								group by 
									requisition_number) as requisition on requisition.requisition_number=referrence_number
				WHERE 
					stock_receive_type='Product Conversion'
					".($fromDate!=NULL && $toDate!==NULL?" and stock_receive_date between '".$fromDate."' and '".$toDate."'" : "")."
				";

		$query = $this->db->query($sql);
        return $query->result_array();
	}

    function getcrecipe($productId)
    {
        $sql = "SELECT 
                    tbl_product_recipe.requir_product_id, 
                    tbl_product.product_description, 
                    tbl_product_recipe.requir_quantity, 
                    tbl_product.product_unit,
                    tbl_product.product_rate
                FROM  
                    tbl_product_recipe 
                    INNER JOIN tbl_product ON tbl_product.product_id = tbl_product_recipe.requir_product_id 
                WHERE 1 
                    and tbl_product_recipe.product_id=?";
        $query = $this->db->query($sql,array($productId));
        return $query->result_array();
    }

}

?>