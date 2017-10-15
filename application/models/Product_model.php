<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Product_model extends CI_Model
{
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
		$this->db->query("SET time_zone='+6:00'");
    }

    //get the username & password from tbl_usrs

    function get_category()
    {
        $sql = "select * from tbl_category where 1";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    function get_product($productId = NULL)
    {
        if($productId==NULL){
            $sql = "select * from tbl_product inner join tbl_category on tbl_category.category_id=tbl_product.product_category where 1";
            $query = $this->db->query($sql);
        }else{
            $sql = "select * from tbl_product inner join tbl_category on tbl_category.category_id=tbl_product.product_category where 1 and tbl_product.product_id=?";
            $query = $this->db->query($sql,array($productId));
        }
        return $query->result_array();
    }

    function create_product($data)
    {
        $this->db->insert('tbl_product', $data);
        return $this->db->insert_id();
    }

    function stock_receive($data)
    {
        $this->db->insert('tbl_stock_receive', $data);
        return $this->db->insert_id();
    }

    function stock_receiveall($data)
    {
        return $this->db->insert_batch('tbl_stock_receive', $data);
        //return $this->db->insert_id();
    }

    function update_product($productId,$dataArray)
    {
        return $this->db
                ->where('product_id',$productId)
                ->update('tbl_product', $dataArray );
    }	

    function update_product_rate($data)
    {
        return $this->db->update_batch('tbl_product', $data,'product_id');
    }

    function stock_out($data)
    {
        $this->db->insert('tbl_stock_out', $data);
        return $this->db->insert_id();
    }

    function stock_outall($data)
    {
        return $this->db->insert_batch('tbl_stock_out', $data);
    }

    function stock_out_as_requisition($requisitionNumber)
    {
        $sql = "insert into tbl_stock_out(stock_out_type,referrence_number,stock_out_date,product_id,quantity,rate,location_id,entry_by) SELECT 'Product Mixing' as outtype,requisition_number,curdate() as outdate, product_id,`quantity`,rate,location_id,? FROM tbl_product_mixing_requisition where status= 1 and requisition_number = ?";
        return $this->db->query($sql,array($this->session->userdata('username'),$requisitionNumber));
    }

    function product_recipe($requisitionNumber,$productId,$quantity)
    {
        $this->db->query('delete from tbl_product_recipe WHERE product_id = ?',array($productId));
        $sql = "insert into tbl_product_recipe(product_id,product_qty,requir_product_id,requir_quantity,entry_by,entry_date) SELECT ?,?, product_id,quantity,?,? FROM tbl_product_mixing_requisition where status= 1 and requisition_number = ?";
        return $this->db->query($sql,array($productId,$quantity,$this->session->userdata('username'),date('Y-m-d'),$requisitionNumber));
    }

    function store_summery_query($locationId=0,$fromDate=NULL,$toDate=NULL)
    {
        $sql="select 
                tbl_product.product_id,
                product_description,
				tbl_product.product_rate,
                ifnull(openingreceive,0)-ifnull(openingout,0) as openingbalance,
                ifnull(openingreceiveAmount,0)-ifnull(openingoutAmount,0) as openingbalanceAmount,
				ifnull(openloangiven,0)-ifnull(openloantaken,0) as loanbalance,
				ifnull(openloangivenAmount,0)-ifnull(openloantakenAmount,0) as loanbalanceAmount,
                conversion,transfer,purchase,salesreturn,samplereturn,lc,loantaken,
                conversionAmount,transferAmount,purchaseAmount,salesreturnAmount,samplereturnAmount,lcAmount,loantakenAmount,
                conversionout,transferout,sales,loangiven,freesample,
                conversionoutAmount,transferoutAmount,salesAmount,loangivenAmount,freesampleAmount
            from
                tbl_product
                left join (SELECT 
                                product_id,
                                sum(if(stock_receive_date <  ".($fromDate!=NULL?"'".$fromDate."'" : "curdate() ")." ,quantity,0)) as openingreceive,
                                sum(if(stock_receive_date <  ".($fromDate!=NULL?"'".$fromDate."'" : "curdate() ")." ,quantity*rate,0)) as openingreceiveAmount,
                                sum(if(stock_receive_date ".($fromDate!=NULL && $toDate!==NULL?" between '".$fromDate."' and '".$toDate."'" : ">=curdate() ")." and stock_receive_type='Product Conversion',quantity,0)) as conversion,
                                sum(if(stock_receive_date ".($fromDate!=NULL && $toDate!==NULL?" between '".$fromDate."' and '".$toDate."'" : ">=curdate() ")." and stock_receive_type='Product Conversion',quantity*rate,0)) as conversionAmount,
                                sum(if(stock_receive_date ".($fromDate!=NULL && $toDate!==NULL?" between '".$fromDate."' and '".$toDate."'" : ">=curdate() ")." and stock_receive_type='stock Transfer',quantity,0)) as transfer,
                                sum(if(stock_receive_date ".($fromDate!=NULL && $toDate!==NULL?" between '".$fromDate."' and '".$toDate."'" : ">=curdate() ")." and stock_receive_type='stock Transfer',quantity*rate,0)) as transferAmount,
                                sum(if(stock_receive_date ".($fromDate!=NULL && $toDate!==NULL?" between '".$fromDate."' and '".$toDate."'" : ">=curdate() ")." and stock_receive_type='Purchase Invoice',quantity,0)) as purchase,
                                sum(if(stock_receive_date ".($fromDate!=NULL && $toDate!==NULL?" between '".$fromDate."' and '".$toDate."'" : ">=curdate() ")." and stock_receive_type='Purchase Invoice',quantity*rate,0)) as purchaseAmount,
                                sum(if(stock_receive_date ".($fromDate!=NULL && $toDate!==NULL?" between '".$fromDate."' and '".$toDate."'" : ">=curdate() ")." and stock_receive_type='Sales Return',quantity,0)) as salesreturn,
                                sum(if(stock_receive_date ".($fromDate!=NULL && $toDate!==NULL?" between '".$fromDate."' and '".$toDate."'" : ">=curdate() ")." and stock_receive_type='Sales Return',quantity*rate,0)) as salesreturnAmount,
                                sum(if(stock_receive_date ".($fromDate!=NULL && $toDate!==NULL?" between '".$fromDate."' and '".$toDate."'" : ">=curdate() ")." and stock_receive_type='Sample Return',quantity,0)) as samplereturn,
                                sum(if(stock_receive_date ".($fromDate!=NULL && $toDate!==NULL?" between '".$fromDate."' and '".$toDate."'" : ">=curdate() ")." and stock_receive_type='Sample Return',quantity*rate,0)) as samplereturnAmount,
                                sum(if(stock_receive_date ".($fromDate!=NULL && $toDate!==NULL?" between '".$fromDate."' and '".$toDate."'" : ">=curdate() ")." and stock_receive_type='LC Goods Receive',quantity,0)) as lc,
                                sum(if(stock_receive_date ".($fromDate!=NULL && $toDate!==NULL?" between '".$fromDate."' and '".$toDate."'" : ">=curdate() ")." and stock_receive_type='LC Goods Receive',quantity*rate,0)) as lcAmount,
                                sum(if(stock_receive_date ".($fromDate!=NULL && $toDate!==NULL?" between '".$fromDate."' and '".$toDate."'" : ">=curdate() ")." and stock_receive_type='Loan Taken',quantity,0)) as loantaken,
                                sum(if(stock_receive_date ".($fromDate!=NULL && $toDate!==NULL?" between '".$fromDate."' and '".$toDate."'" : ">=curdate() ")." and stock_receive_type='Loan Taken',quantity*rate,0)) as loantakenAmount,
                                sum(if(stock_receive_date < ".($fromDate!=NULL ? "'".$fromDate."'" : "curdate() ")." and stock_receive_type='Loan Taken',quantity,0)) as openloantaken,					
                                sum(if(stock_receive_date < ".($fromDate!=NULL ? "'".$fromDate."'" : "curdate() ")." and stock_receive_type='Loan Taken',quantity*rate,0)) as openloantakenAmount					
                            FROM 
                                tbl_stock_receive
                            where
                                1
                                ".($locationId==0?"":" and tbl_stock_receive.location_id='".$locationId."'")."
                            group by 
                                product_id
                            ) as receive using (product_id)
                            left join (SELECT 
                                            product_id,
                                            sum(if(stock_out_date < ".($fromDate!=NULL?"'".$fromDate."'" : "curdate() ").",quantity,0)) as openingout,
                                            sum(if(stock_out_date < ".($fromDate!=NULL?"'".$fromDate."'" : "curdate() ").",quantity*rate,0)) as openingoutAmount,
                                            sum(if(stock_out_date ".($fromDate!=NULL && $toDate!==NULL?" between '".$fromDate."' and '".$toDate."'" : ">=curdate() ")." and stock_out_type='Product Mixing',quantity,0)) as conversionout,
                                            sum(if(stock_out_date ".($fromDate!=NULL && $toDate!==NULL?" between '".$fromDate."' and '".$toDate."'" : ">=curdate() ")." and stock_out_type='Product Mixing',quantity*rate,0)) as conversionoutAmount,
                                            sum(if(stock_out_date ".($fromDate!=NULL && $toDate!==NULL?" between '".$fromDate."' and '".$toDate."'" : ">=curdate() ")." and stock_out_type='stock Transfer',quantity,0)) as transferout,
                                            sum(if(stock_out_date ".($fromDate!=NULL && $toDate!==NULL?" between '".$fromDate."' and '".$toDate."'" : ">=curdate() ")." and stock_out_type='stock Transfer',quantity*rate,0)) as transferoutAmount,
                                            sum(if(stock_out_date ".($fromDate!=NULL && $toDate!==NULL?" between '".$fromDate."' and '".$toDate."'" : ">=curdate() ")." and stock_out_type='Sale Delivery',quantity,0)) as sales,
                                            sum(if(stock_out_date ".($fromDate!=NULL && $toDate!==NULL?" between '".$fromDate."' and '".$toDate."'" : ">=curdate() ")." and stock_out_type='Sale Delivery',quantity*rate,0)) as salesAmount,
                                            sum(if(stock_out_date ".($fromDate!=NULL && $toDate!==NULL?" between '".$fromDate."' and '".$toDate."'" : ">=curdate() ")." and stock_out_type='Loan Given',quantity,0)) as loangiven,
                                            sum(if(stock_out_date ".($fromDate!=NULL && $toDate!==NULL?" between '".$fromDate."' and '".$toDate."'" : ">=curdate() ")." and stock_out_type='Loan Given',quantity*rate,0)) as loangivenAmount, 
                                            sum(if(stock_out_date ".($fromDate!=NULL && $toDate!==NULL?" between '".$fromDate."' and '".$toDate."'" : ">=curdate() ")." and stock_out_type='Free Sample',quantity,0)) as freesample,
                                            sum(if(stock_out_date ".($fromDate!=NULL && $toDate!==NULL?" between '".$fromDate."' and '".$toDate."'" : ">=curdate() ")." and stock_out_type='Free Sample',quantity*rate,0)) as freesampleAmount,
                        					sum(if(stock_out_date < ".($fromDate!=NULL ? "'".$fromDate."'" : "curdate() ")." and stock_out_type='Loan Given',quantity,0)) as openloangiven,					
                        					sum(if(stock_out_date < ".($fromDate!=NULL ? "'".$fromDate."'" : "curdate() ")." and stock_out_type='Loan Given',quantity*rate,0)) as openloangivenAmount					
                                        FROM 
                                            tbl_stock_out
                                        where
                                            1
                                            ".($locationId==0?"":" and tbl_stock_out.location_id='".$locationId."'")."
                                        group by 
                                            product_id) as stockout on stockout.product_id=tbl_product.product_id";

					

		$query = $this->db->query($sql);

        return $query->result_array();

    }

	function productwisetransection($productId,$fromDate=NULL,$toDate=NULL)
	{

		$sql ="select 

					tbl_product.product_id,product_description,trn_date,trn_type,referrence_number,quantity,rate,location_name,trn_state 

				from 

					tbl_product 

					left join ( SELECT 

									stock_receive_date as trn_date, stock_receive_type as trn_type , referrence_number, product_id, quantity, rate, location_id, 'in' as trn_state 

								FROM 

									tbl_stock_receive 

								WHERE 1 

								union all 

								SELECT 

									stock_out_date as trn_date,stock_out_type as trn_type, referrence_number, product_id, quantity, rate, location_id, 'out' as trn_state 

								FROM 

									tbl_stock_out 

								WHERE 1

							) as transection using (product_id) 

					left join tbl_location using (location_id)

				where

					tbl_product.product_id = '".$productId."'

					".($fromDate!=NULL && $toDate!==NULL?" and trn_date between '".$fromDate."' and '".$toDate."'" : "")."

				order by trn_date,trn_state,product_description,trn_type,referrence_number";

		$query = $this->db->query($sql);

        return $query->result_array();

	}

	

	function productopeningbalance($productId,$tillDate)
	{

		$sql ="select
					tbl_product.product_id,
                    (ifnull(receiveqty,0)-ifnull(outqty,0)) as openingbalance,
                    (ifnull(receiveAmount,0)-ifnull(outAmount,0)) as openingbalanceAmount
				from 
					tbl_product
					left join ( SELECT 
									 product_id, 
                                     sum(quantity) as receiveqty,
                                     sum(quantity*rate) as receiveAmount
								FROM 
									tbl_stock_receive 
								WHERE 
									product_id = '".$productId."' and stock_receive_date < '".$tillDate."') as receive using(product_id)
					left join (	SELECT 
									 product_id, 
                                     sum(quantity) as outqty,
                                     sum(quantity*rate) as outAmount
	       						FROM 
									tbl_stock_out 
								WHERE 
									product_id = '".$productId."' and stock_out_date < '".$tillDate."') as stockout using(product_id)
                WHERE
                    product_id = '".$productId."'
					";

		$query = $this->db->query($sql);
        return $query->result_array();

	}

    function goodesIntransit($fromDate,$toDate)
    {

        $sql = "SELECT 
                    lc_id,sum(amount) as amount 
                FROM 
                    tbl_lc_history 
                    INNER join tbl_lc_costing using (lc_id) 
                WHERE 
                    status in('Lc Open') and status not in ('Lc Close') 
                    and event_date BETWEEN ? and ? ";

        $query = $this->db->query($sql,array($fromDate,$toDate ));
        return $query->result_array();

    }

    

    function getrate($productId)
    {
        $this->db->select('product_rate');
        $this->db->from('tbl_product');
        $this->db->where("product_id",$productId);
        return $this->db->get()->row()->product_rate;
    }

    

    function totalReceive($productId)
    {
        $this->db->select('ifnull(sum(quantity),0) as totalReceive');
        $this->db->from('tbl_stock_receive');
        $this->db->where("product_id",$productId);
        return $this->db->get()->row()->totalReceive;
    }

    

    function totalOut($productId)
    {
        $this->db->select('ifnull(sum(quantity),0) as totalout');
        $this->db->from('tbl_stock_out');
        $this->db->where("product_id",$productId);
        return $this->db->get()->row()->totalout;
    }

    function getproducttransection($fromDate,$toDate,$clientId=0,$productId=0)
    {
        $sql = "SELECT
                    client_id,product_id,client_name,product_description,
                    sum(if(type='sales',quantity,0)) as sales_quantity,
                    sum(if(type='sales',quantity*rate,0)) as sales_amount,
                    sum(if(type='sample',quantity,0)) as sample_quantity,
                    sum(if(type='sample',quantity*rate,0)) as sample_amount,
                    sum(if(type='loan',quantity,0)) as loan_quantity,
                    sum(if(type='loan',quantity*rate,0)) as loan_amount
                FROM
                (
                    SELECT 
                        client_id,product_id,invoice_date as transection_date,quantity,unit_price as rate, 'sales' as type
                    FROM 
                        tbl_invoice
                        inner join tbl_invoice_details using (invoice_id)
                    WHERE 1
                    union all
                    SELECT 
                        tbl_free_sample.client_id, tbl_free_sample.product_id, sample_delivery_date as transection_date, tbl_free_sample.quantity, tbl_stock_out.rate,  'sample' AS TYPE 
                    FROM 
                        tbl_free_sample 
                        INNER JOIN tbl_stock_out ON tbl_free_sample.sample_number = tbl_stock_out.referrence_number AND tbl_free_sample.product_id = tbl_stock_out.product_id
                    WHERE 1
                    union all
                    SELECT 
                        tbl_loan_given.client_id, tbl_loan_given.product_id, tbl_loan_given.loan_given_date as transection_date, tbl_loan_given.quantity, tbl_stock_out.rate,  'loan' AS TYPE 
                    FROM 
                        tbl_loan_given 
                        INNER JOIN tbl_stock_out ON tbl_loan_given.loan_number = tbl_stock_out.referrence_number AND tbl_loan_given.product_id = tbl_stock_out.product_id
                    WHERE 1
                ) as temp
                inner join tbl_client using (client_id)
                inner join tbl_product using(product_id)
                WHERE
                    transection_date between '".$fromDate."' and '".$toDate."'
                    ".($productId>0? " and tbl_product.product_id='".$productId."'":"")."
                    ".($clientId>0? " and tbl_client.client_id='".$clientId."'":"")."
                GROUP BY 
                    client_id,product_id
                ORDER BY
                    client_name,product_description asc";
            $query = $this->db->query($sql);
            return $query->result_array();
    }    

}





?>