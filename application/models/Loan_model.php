<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Loan_model extends CI_Model
{
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
		$this->db->query("SET time_zone='+6:00'");
    }

    function getLoanGivenNumber()
    {
        $this->db->select('concat("SBLG",(ifnull(max(substr(loan_number,5)),160000)+1)) as loanno');
        $this->db->from('tbl_loan_given');
        return $this->db->get()->row()->loanno;

    }

    function createLoanGiven($data)
    {
        return $this->db->insert_batch('tbl_loan_given', $data);
    }

    function getLoanGivenList($status=NULL)
    {
        $sql = "SELECT
                    loan_number,loan_given_date,client_name,sum(quantity) as totalqty,tbl_loan_given.status,tbl_loan_given.entry_by
                FROM
                    tbl_loan_given
                    inner join tbl_client using (client_id)
                WHERE 1
                    ".($status!=NULL?" and tbl_loan_given.status='".$status."'":"")."
                group by
                    loan_number
                ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    function getLoanGiven($loanNumber)
    {
        $sql = "SELECT
                    tbl_loan_given.*,
                    tbl_client.client_id,tbl_client.client_name,client_contact_no,client_email,client_office_address,client_delivery_address,
                    product_description,tbl_location.location_name
                FROM
                    tbl_loan_given
                    inner join tbl_client using (client_id)
                    inner join tbl_product using(product_id)
                    left join tbl_location using(location_id)
                WHERE
                    loan_number=?

                ";
        $query = $this->db->query($sql,array($loanNumber));
        return $query->result_array();
    }

	function productloangiven($fromDate, $toDate, $productId=0, $customerId=0)
    {
        $sql = "SELECT
                    client_id,client_name,client_office_address, client_delivery_address, client_contact_no, client_email,loan_number,loan_given_date,tbl_product.product_id,product_name,product_description,quantity,package,remarks
                FROM
                    tbl_loan_given
                    inner join tbl_client using (client_id)
                    inner join tbl_product using(product_id)
                WHERE
                    loan_given_date between '".$fromDate."' and '".$toDate."'
					".($productId>0? " and tbl_product.product_id='".$productId."'":"")."
					".($customerId>0? " and tbl_client.client_id='".$customerId."'":"")."
                order by
					loan_given_date,product_description asc

                ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    function updateGivenStatus($loanNumber,$dataArray)
    {
        if($dataArray['status']==1){
            $sql = "insert into tbl_stock_out(stock_out_type,referrence_number,stock_out_date,product_id,quantity,rate,location_id,entry_by) SELECT 'Loan Given' as outtype,loan_number,curdate() as outdate, product_id,`quantity`,product_rate,location_id,? FROM `tbl_loan_given` inner join tbl_product using (product_id) where tbl_loan_given.status=0 and loan_number = ?";

        $query = $this->db->query($sql,array($this->session->userdata('username'),$loanNumber));
        return $this->db
                ->where('loan_number',$loanNumber)
                ->update('tbl_loan_given', $dataArray );
        }

    }

    function getLoanTakenNumber()
    {
        $this->db->select('concat("SBLT",(ifnull(max(substr(loan_number,5)),160000)+1)) as loanno');
        $this->db->from('tbl_loan_taken');
        return $this->db->get()->row()->loanno;

    }

    function createLoanTaken($data)
    {
        return $this->db->insert_batch('tbl_loan_taken', $data);
    }

    function getLoanTakenList($status=NULL)
    {
        $sql = "SELECT
                    loan_number,loan_taken_date,client_name,sum(quantity) as totalqty,tbl_loan_taken.status,tbl_loan_taken.entry_by
                FROM
                    tbl_loan_taken
                    inner join tbl_client using (client_id)
                WHERE 1
                    ".($status!=NULL?" and tbl_loan_taken.status='".$status."'":"")."
                group by
                    loan_number
                ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    function getLoanTaken($loanNumber)
    {
        $sql = "SELECT
                    *
                FROM
                    tbl_loan_taken
                    inner join tbl_client using (client_id)
                    inner join tbl_product using(product_id)
                WHERE
                    loan_number=?

                ";
        $query = $this->db->query($sql,array($loanNumber));
        return $query->result_array();
    }

	function productloanreceive($fromDate, $toDate, $productId=0, $customerId=0)
    {
        $sql = "SELECT
                    client_id,client_name,client_office_address, client_delivery_address, client_contact_no, client_email,loan_number,loan_taken_date,tbl_product.product_id,product_name,product_description,quantity,package,remarks
                FROM
                    tbl_loan_taken
                    inner join tbl_client using (client_id)
                    inner join tbl_product using(product_id)
                WHERE
                    loan_taken_date between '".$fromDate."' and '".$toDate."'
					".($productId>0? " and tbl_product.product_id='".$productId."'":"")."
					".($customerId>0? " and tbl_client.client_id='".$customerId."'":"")."
                order by
					loan_taken_date,product_description asc

                ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }


    function updateTakenStatus($loanNumber,$dataArray)
    {
        if($dataArray['status']==1){
             $sql = "insert into tbl_stock_receive(stock_receive_type,referrence_number,stock_receive_date,product_id,quantity,rate,location_id,entry_by) SELECT 'Loan Taken' as outtype,loan_number,curdate() as outdate, product_id,`quantity`,product_rate,location_id,? FROM `tbl_loan_taken` inner join tbl_product using (product_id) where tbl_loan_taken.status = 0 and loan_number = ? ";

        $query = $this->db->query($sql,array($this->session->userdata('username'),$loanNumber));
        return $this->db
                ->where('loan_number',$loanNumber)
                ->update('tbl_loan_taken', $dataArray );
        }

    }

	function productwiseloantransection($productId,$clientId,$fromDate=NULL,$toDate=NULL)
	{
		$sql ="select
					tbl_product.product_id,product_description,client_name,trn_date,trn_type,referrence_number,quantity,rate,location_name,trn_state
				from
					tbl_product
					left join ( SELECT
									stock_receive_date as trn_date, stock_receive_type as trn_type , referrence_number, tbl_stock_receive.product_id, tbl_stock_receive.quantity, tbl_stock_receive.rate, tbl_stock_receive.location_id, 'in' as trn_state,tbl_loan_taken.client_id
								FROM
									tbl_stock_receive
									inner join tbl_loan_taken on tbl_loan_taken.loan_number=tbl_stock_receive.referrence_number and tbl_stock_receive.product_id= tbl_loan_taken.product_id
								WHERE 1
									and stock_receive_type='Loan Taken'
                                    ".($clientId>0? "and tbl_loan_taken.client_id = '".$clientId."'":"")."
								union all
								SELECT
									stock_out_date as trn_date,stock_out_type as trn_type, referrence_number, tbl_stock_out.product_id, tbl_stock_out.quantity, tbl_stock_out.rate, tbl_stock_out.location_id, 'out' as trn_state, tbl_loan_given.client_id
								FROM
									tbl_stock_out
									inner join tbl_loan_given on tbl_loan_given.loan_number=tbl_stock_out.referrence_number and tbl_stock_out.product_id= tbl_loan_given.product_id
								WHERE 1
									and stock_out_type='Loan Given'
                                    ".($clientId>0? "and tbl_loan_given.client_id = '".$clientId."'":"")."
							) as transection using (product_id)
					left join tbl_location using (location_id)
                    left join tbl_client using (client_id)
				where
					tbl_product.product_id = '".$productId."'
					".($fromDate!=NULL && $toDate!==NULL?" and trn_date between '".$fromDate."' and '".$toDate."'" : "")."
				order by trn_date,product_description,trn_type,referrence_number,trn_state";
		$query = $this->db->query($sql);
        return $query->result_array();
	}

	function productloanopeningbalance($productId,$clientId,$tillDate)
	{
		$sql ="select
					tbl_product.product_id,(ifnull(outqty,0)-ifnull(receiveqty,0)) as openingbalance
				from
					tbl_product
					left join ( SELECT
									tbl_loan_taken.product_id, sum(tbl_stock_receive.quantity) as receiveqty
								FROM
									tbl_stock_receive
									inner join tbl_loan_taken on tbl_loan_taken.loan_number=tbl_stock_receive.referrence_number and tbl_stock_receive.product_id= tbl_loan_taken.product_id
								WHERE 1
									and stock_receive_type='Loan Taken'
									".($clientId>0? "and tbl_loan_taken.client_id = '".$clientId."'":"")."
									and tbl_loan_taken.product_id = '".$productId."' and stock_receive_date < '".$tillDate."' ) as receive using(product_id)
					left join (	SELECT
									tbl_stock_out.product_id, sum(tbl_stock_out.quantity) as outqty
								FROM
									tbl_stock_out
									inner join tbl_loan_given on tbl_loan_given.loan_number=tbl_stock_out.referrence_number and tbl_stock_out.product_id= tbl_loan_given.product_id
								WHERE 1
									and stock_out_type='Loan Given'
									".($clientId>0? "and tbl_loan_given.client_id = '".$clientId."'":"")."
									and tbl_stock_out.product_id = '".$productId."' and stock_out_date < '".$tillDate."' ) as stockout using(product_id)

					where
						tbl_product.product_id = '".$productId."'
					";
		$query = $this->db->query($sql);
        return $query->result_array();
	}

	function productloanbalance($productId,$clientId,$tillDate)
	{
		$sql ="select
					tbl_product.product_id,tbl_product.product_description,client_name,sum(ifnull(outqty,0)-ifnull(receiveqty,0)) as balance
				from
					tbl_product
					inner join ( SELECT
									tbl_stock_receive.product_id,tbl_loan_taken.client_id,sum(tbl_stock_receive.quantity) as receiveqty, '0' as outqty
								FROM
									tbl_stock_receive
									inner join tbl_loan_taken on tbl_loan_taken.loan_number=tbl_stock_receive.referrence_number and tbl_stock_receive.product_id= tbl_loan_taken.product_id
								WHERE 1
									and stock_receive_type='Loan Taken'
									".($clientId>0? "and tbl_loan_taken.client_id = '".$clientId."'":"")."
									".($productId>0? "and tbl_loan_taken.product_id = '".$productId."'":"")."
									and stock_receive_date <= '".$tillDate."'
								group by
									tbl_stock_receive.product_id,tbl_loan_taken.client_id
								union all
								SELECT
									tbl_stock_out.product_id,tbl_loan_given.client_id,'0' as receiveqty,  sum(tbl_stock_out.quantity) as outqty
								FROM
									tbl_stock_out
									inner join tbl_loan_given on tbl_loan_given.loan_number=tbl_stock_out.referrence_number and tbl_stock_out.product_id= tbl_loan_given.product_id
								WHERE 1
									and stock_out_type='Loan Given'
									".($clientId>0? "and tbl_loan_given.client_id = '".$clientId."'":"")."
									".($productId>0? "and tbl_stock_out.product_id = '".$productId."'":"")."
									and stock_out_date <= '".$tillDate."'
								group by
									tbl_stock_out.product_id,tbl_loan_given.client_id) as stocktransections using(product_id)
						left join tbl_client using (client_id)
					group by
						tbl_product.product_id,stocktransections.client_id
					Order by client_name,product_description

					";

		$query = $this->db->query($sql);
        return $query->result_array();
	}

    function loanbalance($productId,$tillDate)
    {
        $sql ="select
                    tbl_product.product_id,tbl_product.product_description,sum(ifnull(outqty,0)-ifnull(receiveqty,0)) as balance
                from
                    tbl_product
                    inner join ( SELECT
                                    tbl_stock_receive.product_id,sum(tbl_stock_receive.quantity) as receiveqty, '0' as outqty
                                FROM
                                    tbl_stock_receive
                                    inner join tbl_loan_taken on tbl_loan_taken.loan_number=tbl_stock_receive.referrence_number and tbl_stock_receive.product_id= tbl_loan_taken.product_id
                                WHERE 1
                                    and stock_receive_type='Loan Taken'
                                    and tbl_loan_taken.product_id = '".$productId."'
                                    and stock_receive_date <= '".$tillDate."'
                                group by
                                    tbl_stock_receive.product_id
                                union all
                                SELECT
                                    tbl_stock_out.product_id,'0' as receiveqty,  sum(tbl_stock_out.quantity) as outqty
                                FROM
                                    tbl_stock_out
                                    inner join tbl_loan_given on tbl_loan_given.loan_number=tbl_stock_out.referrence_number and tbl_stock_out.product_id= tbl_loan_given.product_id
                                WHERE 1
                                    and stock_out_type='Loan Given'
                                    and tbl_stock_out.product_id = '".$productId."'
                                    and stock_out_date <= '".$tillDate."'
                                group by
                                    tbl_stock_out.product_id) as stocktransections using(product_id)
                    group by
                        tbl_product.product_id
                    ";

        $query = $this->db->query($sql);
        return $query->result_array();
    }
}
?>
