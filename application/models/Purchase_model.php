<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Purchase_model extends CI_Model
{
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
		  $this->db->query("SET time_zone='+6:00'");
      $this->db->query("SET sql_mode = ''");
    }


    function getInvoiceList()
    {
        $sql = "SELECT
                    tbl_purchase_invoice.invoice_id,tbl_purchase_invoice.status,party_id,client_name,invoice_no,invoice_date,client_contact_no,net_total,purchase_type
                FROM
                    tbl_purchase_invoice
                    inner join tbl_client on tbl_client.client_id=tbl_purchase_invoice.party_id
                WHERE 1
                    and tbl_purchase_invoice.status=1
                ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

	function getdatewisepurchase($partyId=0,$fromDate=NULL,$toDate=NULL)
	{
		$sql = "SELECT
                    tbl_purchase_invoice.invoice_id,tbl_purchase_invoice.status,party_id,client_name,invoice_no,invoice_date,client_contact_no,net_total,purchase_type
                FROM
                    tbl_purchase_invoice
                      inner join tbl_client on tbl_client.client_id=tbl_purchase_invoice.party_id
                WHERE 1
                    and tbl_purchase_invoice.status=1
					".($partyId>0?" and party_id='".$partyId."'":"")."
                    ".($fromDate!=NULL && $toDate!==NULL?" and invoice_date between '".$fromDate."' and '".$toDate."'" : " and invoice_date = curdate()")."
				order by tbl_purchase_invoice.invoice_id
                ";
        $query = $this->db->query($sql);
        return $query->result_array();
	}

    function getUnapproveInvoiceList()
    {
        $sql = "SELECT
                    tbl_purchase_invoice.invoice_id,tbl_purchase_invoice.status,party_id,client_name,invoice_no,invoice_date,client_contact_no,net_total,purchase_type
                FROM
                    tbl_purchase_invoice
                    inner join tbl_client on tbl_client.client_id=tbl_purchase_invoice.party_id
                WHERE 1
                    and tbl_purchase_invoice.status=0
                ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    function getInvoice($invoiceNo)
    {
        $sql = "SELECT
                    tbl_purchase_invoice.invoice_id,party_id,location_id,client_name,client_office_address, client_contact_no, client_email,invoice_no,invoice_date,net_total,tbl_product.product_id,product_name,product_description,quantity,product_unit,unit_price,(quantity*unit_price) as itemtotal,purchase_type
                FROM
                    tbl_purchase_invoice
                    inner join tbl_purchase_invoice_details using(invoice_id)
                    inner join tbl_client on tbl_client.client_id = tbl_purchase_invoice.party_id
                    inner join tbl_product using(product_id)
                WHERE 1
                    and tbl_purchase_invoice.invoice_id=?";
        $query = $this->db->query($sql,array($invoiceNo));
        return $query->result_array();
    }

	function productwisepurchase($fromDate, $toDate, $productId=0, $partyId=0)
    {
        $sql = "SELECT
                    tbl_purchase_invoice.invoice_id,party_id,client_name,client_office_address, client_contact_no, client_email,invoice_no,invoice_date,tbl_product.product_id,product_name,product_description,quantity,product_unit,unit_price,(quantity*unit_price) as itemtotal,purchase_type
                FROM
                    tbl_purchase_invoice
                    inner join tbl_purchase_invoice_details using(invoice_id)
                    inner join tbl_client on tbl_client.client_id = tbl_purchase_invoice.party_id
                    inner join tbl_product using(product_id)
                WHERE 1
                    and invoice_date between '".$fromDate."' and '".$toDate."'
					".($productId>0? " and tbl_product.product_id='".$productId."'":"")."
					".($partyId>0? " and tbl_party.party_id='".$partyId."'":"")."
                order by
					invoice_date,product_description asc";

        $query = $this->db->query($sql);
        return $query->result_array();
    }

    function get_orderNumber()
    {
        $this->db->select('max(order_number)+1 as orderno');
        $this->db->from('tbl_purchase_order');
        return $this->db->get()->row()->orderno;

    }

    function create_purchase_order($data)
    {
        return $this->db->insert_batch('tbl_purchase_order', $data);

    }

    function getReceiveNumber()
    {
        $this->db->select('concat("SBPR",(ifnull(max(substr(receive_number,5)),160000)+1)) as receiveno');
        $this->db->from('tbl_product_receive');
        return $this->db->get()->row()->receiveno;

    }

    function get_approved_receiveList()
    {
        $sql = "SELECT
                    party_id,client_name,receive_number,receive_date,client_contact_no,sum(quantity) as receive_total,receive_status
                FROM
                    tbl_product_receive
                    inner join tbl_client on tbl_client.client_id = tbl_product_receive.party_id
                WHERE 1
                    and receive_status=1
                GROUP BY
                    receive_number
                ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    function get_unapproved_receiveList()
    {
        $sql = "SELECT
                    party_id,client_name,receive_number,receive_date,client_contact_no,sum(quantity) as receive_total,receive_status
                FROM
                    tbl_product_receive
                    inner join tbl_client on tbl_client.client_id = tbl_product_receive.party_id
                WHERE 1
                    and receive_status=0
                GROUP BY
                    receive_number
                ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    function getProductsReceive($receiveNumber)
    {
        $sql = "SELECT
                    *
                FROM
                    tbl_product_receive
                    inner join tbl_client on tbl_client.client_id = tbl_product_receive.party_id
                    inner join tbl_product using(product_id)
                WHERE 1
                    and tbl_product_receive.receive_number='".$receiveNumber."'";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    function create_product_receive($data)
    {
        return $this->db->insert_batch('tbl_product_receive', $data);
    }

    function getinvoiceNumber()
    {
         $this->db->select('concat("SBPR",(ifnull(max(substr(invoice_no,5)),160000)+1)) as invoice_no');
        $this->db->from('tbl_purchase_invoice');
        return $this->db->get()->row()->invoice_no;

    }

    function create_invoice_id($data)
    {
        $this->db->insert('tbl_purchase_invoice', $data);
        return $this->db->insert_id();
    }

    function approve_purchase_receive($receiveNumber)
    {
        $this->db->set('receive_status',1);
        $this->db->set('approved_by',$this->session->userdata('username'));
        $this->db->set('approved_date',date('Y-m-d'));
        $this->db->where('receive_number',$receiveNumber);
        return $this->db->update('tbl_product_receive');
    }

    function approve_purchase_invoice($invoiceId)
    {
        $this->db->set('status',1);
        $this->db->set('approved_by',$this->session->userdata('username'));
        $this->db->set('approved_date',date('Y-m-d'));
        $this->db->where('invoice_id',$invoiceId);
        return $this->db->update('tbl_purchase_invoice');
    }

    function create_invoice_details($data,$receiveNumber)
    {
        $this->db->set('receive_status',2);
        $this->db->set('invoice_created_by',$this->session->userdata('username'));
        $this->db->where('receive_number',$receiveNumber);
        $this->db->update('tbl_product_receive');

        return $this->db->insert_batch('tbl_purchase_invoice_details', $data);

    }

    function createPay($data)
    {
        return $this->db->insert('tbl_payment', $data);
    }

    function getPayments($status = NULL)
    {
        $sql="  SELECT
                    *
                FROM
                    `tbl_client`
                    inner join tbl_payment on tbl_client.client_id=tbl_payment.party_id
                WHERE
                    1
                    ".($status!=NULL?" and tbl_payment.status='".$status."'":"")."
                ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    function getPayment($payId)
    {
        $sql="  SELECT
                    *
                FROM
                    `tbl_client`
                    inner join tbl_payment on tbl_client.client_id=tbl_payment.party_id
                WHERE
                    1
                    and payment_id=?
                ";
        $query = $this->db->query($sql,array($payId));
        return $query->result_array();
    }

    function approvePayment($paymentId)
    {
        $this->db->set('status',1);
        $this->db->set('approved_by',$this->session->userdata('username'));
        $this->db->set('approved_date',date('Y-m-d'));
        $this->db->where('payment_id',$paymentId);

        return $this->db->update('tbl_payment');
    }

	function paymentlist($partyId=0,$fromDate=NULL,$toDate=NULL,$paymentType=NULL)
	{
		$sql = "SELECT
                    payment_date ,remarks,client_name,pay_type,pay_amount
                FROM
                    tbl_payment
					inner join tbl_client on tbl_client.client_id=tbl_payment.party_id
                where
                    1
                    and status=1
                    ".($paymentType?" and pay_type='".$paymentType."'":"")."
                    ".($partyId>0?" and party_id='".$partyId."'":"")."
                    ".($fromDate!=NULL && $toDate!==NULL?" and payment_date between '".$fromDate."' and '".$toDate."'" : "")."
                order by
                    payment_date,client_name";

		$query = $this->db->query($sql);
        return $query->result_array();
	}

	function partyTotalBill($partyId,$dateUpto)
    {
        $this->db->select('ifnull(sum(net_total),0) as totalInvoice');
        $this->db->from('tbl_purchase_invoice');
        $this->db->where("status",1);
        $this->db->where("party_id",$partyId);
        $this->db->where("invoice_date < ",$dateUpto);

        return $this->db->get()->row()->totalInvoice;
    }

    function partyTotalPay($partyId,$dateUpto)
    {
        $this->db->select('ifnull(sum(pay_amount),0) as totlaPayment');
        $this->db->from('tbl_payment');
        $this->db->where("status",1);
        $this->db->where("party_id",$partyId);
        $this->db->where("payment_date < ",$dateUpto);
        return $this->db->get()->row()->totlaPayment;

    }

	function partysummery()
	{
		$sql = "SELECT
					party_id, client_name, '0' AS opening_balance, sum(net_total) as invoicetotal, payments.payamount
				FROM
					tbl_purchase_invoice
					inner join tbl_client on tbl_client.client_id=tbl_purchase_invoice.party_id
					left join (select party_id,sum(pay_amount) as payamount from tbl_payment where status=1 group by party_id) as payments on tbl_purchase_invoice.party_id=payments.party_id

				WHERE 1
				GROUP BY party_id";
		$query = $this->db->query($sql);
        return $query->result_array();
	}

	function transections($clientId=0,$fromDate='',$toDate='')
    {
        $sql = "SELECT
                    invoice_date as transection_date,'Purchase' as transectionType,invoice_no as transectionNumber,net_total as purchase_amount,'' as pay_amount,'1' as sortorder
                FROM
                    tbl_purchase_invoice
                where
                    status =1
                    and party_id='".$clientId."'
                    and invoice_date between '".$fromDate."' and '".$toDate."'
                union all
                SELECT 
                    cost_date as transection_date,costing_head as transectionType,lc_no as transectionNumber,tbl_lc_costing.amount as purchase_amount,'' as pay_amount,'2' as sortorder 
                FROM 
                    tbl_lc
                    INNER JOIN  tbl_lc_costing USING ( lc_id ) 
                WHERE 
                    costing_head =  'Under Invoice'
                    and tbl_lc.supplier_id='".$clientId."'
                    and tbl_lc_costing.cost_date between '".$fromDate."' and '".$toDate."'
                union all
                SELECT
                    payment_date as transection_date,'Payment' as transectionType,'' as transectionNumber,'' as purchase_amount,pay_amount,'3' as sortorder
                FROM
                    tbl_payment
                where
                    1
                    and status=1
                    and party_id='".$clientId."'
                    and payment_date between '".$fromDate."' and '".$toDate."'
                order by
                    transection_date,sortorder";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
}
?>
