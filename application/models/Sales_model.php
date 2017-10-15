

<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Sales_model extends CI_Model
{
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
	    $this->db->query("SET time_zone='+6:00'");
        $this->db->query("SET sql_mode = ''");
    }


    function getInvoiceList($status=NULL)
    {
        $sql = "SELECT
                    tbl_invoice.invoice_id,client_id,client_name,invoice_no,tbl_invoice.status,invoice_date,client_contact_no,net_total ,sum(quantity) as totalqty,sum(delivered_qty) as totaldelivered
                FROM
                    tbl_invoice
                    inner join tbl_client using(client_id)
                    inner join tbl_invoice_details using (invoice_id)
                WHERE 1
                    ".($status!=NULL?" and tbl_invoice.status='".$status."'":"")."
                group by
                    invoice_id
				order by
					tbl_invoice.invoice_id desc
                ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    function getInvoiceListForCommission($clientId='',$invoiceNumber='')
    {
        $sql = "SELECT
                    tbl_invoice.invoice_id,client_id,client_name,invoice_no,tbl_invoice.status,invoice_date,client_contact_no,net_total ,sum(quantity) as totalqty,sum(delivered_qty) as totaldelivered
                FROM
                    tbl_invoice
                    inner join tbl_client using(client_id)
                    inner join tbl_invoice_details using (invoice_id)
                WHERE 1
                    and tbl_invoice.commission_status='0'
                    ".($clientId?"and client_id='".$clientId."'":"")."
                    ".($invoiceNumber?"and invoice_no='".$invoiceNumber."'":"")."
                group by
                    invoice_id
                order by
                    tbl_invoice.invoice_id desc
                ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    function getemployecommissionforapprove()
    {
        $sql ="SELECT 
                    tbl_client.client_name,
                    tbl_client.client_id,
                    'Local' as commission_type,
                    tbl_invoice.invoice_no as refrenceNo,
                    sum(tbl_sales_contact.commission_amount) as commission_amount ,
                    tbl_sales_contact.commission_date
                FROM 
                    tbl_sales_contact
                    inner join tbl_invoice using(invoice_id)
                    inner join tbl_client on tbl_sales_contact.employee_id=tbl_client.client_id
                WHERE 
                    1
                    and tbl_sales_contact.approve_by is null 
                GROUP BY
                    tbl_client.client_id,tbl_invoice.invoice_no
               union all
                SELECT 
                    tbl_client.client_name,
                    tbl_client.client_id,
                    'Import' as commission_type,
                    tbl_lc.lc_no as refrenceNo,
                    sum(tbl_sales_contact.commission_amount) as commission_amount,
                    tbl_sales_contact.commission_date
                FROM 
                    tbl_sales_contact
                    inner join tbl_lc using(lc_id)
                    inner join tbl_client on tbl_sales_contact.employee_id=tbl_client.client_id
                WHERE 
                    1 
                    and tbl_sales_contact.approve_by is null
                GROUP BY
                    tbl_client.client_id,tbl_lc.lc_no
                union all
                SELECT 
                    tbl_client.client_name,
                    tbl_client.client_id,
                    'Import' as commission_type,
                    tbl_sales_contact.pi_no as refrenceNo,
                    sum(tbl_sales_contact.commission_amount) as commission_amount,
                    tbl_sales_contact.commission_date
                FROM 
                    tbl_sales_contact
                    inner join tbl_client on tbl_sales_contact.employee_id=tbl_client.client_id
                WHERE 
                    1 
                    and tbl_sales_contact.approve_by is null
                    and tbl_sales_contact.invoice_id is null and tbl_sales_contact.lc_id is null
                GROUP BY
                    tbl_client.client_id,tbl_sales_contact.pi_no";


        $query = $this->db->query($sql);
        return $query->result_array();
    }

    function getemployecommissions()
    {
        $sql ="SELECT 
                    tbl_client.client_name,
                    tbl_client.client_id,
                    'Local' as commission_type,
                    tbl_invoice.invoice_no as refrenceNo,
                    sum(tbl_sales_contact.commission_amount) as commission_amount ,
                    tbl_sales_contact.commission_date
                FROM 
                    tbl_sales_contact
                    inner join tbl_invoice using(invoice_id)
                    inner join tbl_client on tbl_sales_contact.employee_id=tbl_client.client_id
                WHERE 
                    1
                    
                GROUP BY
                    tbl_client.client_id,tbl_invoice.invoice_no
               union all
                SELECT 
                    tbl_client.client_name,
                    tbl_client.client_id,
                    'Import' as commission_type,
                    tbl_lc.lc_no as refrenceNo,
                    sum(tbl_sales_contact.commission_amount) as commission_amount,
                    tbl_sales_contact.commission_date
                FROM 
                    tbl_sales_contact
                    inner join tbl_lc using(lc_id)
                    inner join tbl_client on tbl_sales_contact.employee_id=tbl_client.client_id
                WHERE 
                    1 
                    
                GROUP BY
                    tbl_client.client_id,tbl_lc.lc_no
                union all
                SELECT 
                    tbl_client.client_name,
                    tbl_client.client_id,
                    'Import' as commission_type,
                    tbl_sales_contact.pi_no as refrenceNo,
                    sum(tbl_sales_contact.commission_amount) as commission_amount,
                    tbl_sales_contact.commission_date
                FROM 
                    tbl_sales_contact
                    inner join tbl_client on tbl_sales_contact.employee_id=tbl_client.client_id
                WHERE 
                    1 
                    
                    and tbl_sales_contact.invoice_id is null and tbl_sales_contact.lc_id is null
                GROUP BY
                    tbl_client.client_id,tbl_sales_contact.pi_no";


        $query = $this->db->query($sql);
        return $query->result_array();
    }

    function getcommission($payeeId,$refrenceNo)
    {
        $sql ="SELECT
                    *
                FROM (
                SELECT 
                    group_concat(id) as contactIds,
                    tbl_client.client_name,
                    tbl_client.client_id,
                    'Invoice # ' as commission_type,
                    tbl_invoice.invoice_no as refrenceNo,
                    sum(tbl_sales_contact.commission_amount) as commission_amount ,
                    tbl_sales_contact.commission_date
                FROM 
                    tbl_sales_contact
                    inner join tbl_invoice using(invoice_id)
                    inner join tbl_client on tbl_sales_contact.employee_id=tbl_client.client_id
                WHERE 
                    1
                    
                GROUP BY
                    tbl_client.client_id,tbl_invoice.invoice_no
               union all
                SELECT 
                    group_concat(id) as contactIds,
                    tbl_client.client_name,
                    tbl_client.client_id,
                    'LC #' as commission_type,
                    tbl_lc.lc_no as refrenceNo,
                    sum(tbl_sales_contact.commission_amount) as commission_amount,
                    tbl_sales_contact.commission_date
                FROM 
                    tbl_sales_contact
                    inner join tbl_lc using(lc_id)
                    inner join tbl_client on tbl_sales_contact.employee_id=tbl_client.client_id
                WHERE 
                    1 
                    
                GROUP BY
                    tbl_client.client_id,tbl_lc.lc_no
                union all
                SELECT 
                    group_concat(id) as contactIds,
                    tbl_client.client_name,
                    tbl_client.client_id,
                    'PI # ' as commission_type,
                    tbl_sales_contact.pi_no as refrenceNo,
                    sum(tbl_sales_contact.commission_amount) as commission_amount,
                    tbl_sales_contact.commission_date
                FROM 
                    tbl_sales_contact
                    inner join tbl_client on tbl_sales_contact.employee_id=tbl_client.client_id
                WHERE 
                    1 
                    
                    and tbl_sales_contact.invoice_id is null and tbl_sales_contact.lc_id is null
                GROUP BY
                    tbl_client.client_id,tbl_sales_contact.pi_no
                    ) as temp
                WHERE 
                    client_id=?
                    and refrenceNo=?";

        $query = $this->db->query($sql,array($payeeId,$refrenceNo));
        return $query->result_array();   
    }

    function get_commission_details($refrenceNo,$payeeId)
    {
        $sql = "SELECT 
                    *
                FROM(
                    SELECT 
                        id as contactIds,
                        payee.client_name as employee_name,
                        payee.client_id as employee_id,
                        payee.client_office_address as address,
                        payee.client_contact_no as contact_no,
                        'Invoice' as commission_type,
                        tbl_invoice.invoice_no as refrenceNo,
                        tbl_invoice.invoice_date as transection_date,
                        tbl_client.client_name,
                        tbl_client.client_office_address,
                        tbl_product.product_description,
                        tbl_sales_contact.product_qty,
                        tbl_sales_contact.sale_value_in_kg,
                        tbl_sales_contact.actual_value_in_kg,
                        tbl_sales_contact.commission_in_kg,
                        tbl_sales_contact.commission_percent,
                        tbl_sales_contact.commission_dollar_amount,
                        tbl_sales_contact.dollar_conversion_rate, 
                        tbl_sales_contact.commission_amount,
                        tbl_sales_contact.commission_date,
                        tbl_sales_contact.entry_by,
                        tbl_sales_contact.approve_by
                    FROM 
                        tbl_sales_contact
                        inner join tbl_invoice using(invoice_id)
                        inner join tbl_product using (product_id)
                        inner join tbl_client as payee on payee.client_id=tbl_sales_contact.employee_id
                        inner join tbl_client on tbl_client.client_id=tbl_sales_contact.party_id
                    WHERE 
                        1
                    union all
                    SELECT 
                        id as contactIds,
                        payee.client_name as employee_name,
                        payee.client_id as employee_id,
                        payee.client_office_address as address,
                        payee.client_contact_no as contact_no,
                        'LC' as commission_type,
                        tbl_lc.lc_no as refrenceNo,
                        tbl_lc.pi_date as transection_date,
                        tbl_client.client_name,
                        tbl_client.client_office_address,
                        tbl_product.product_description,
                        tbl_sales_contact.product_qty,
                        tbl_sales_contact.sale_value_in_kg,
                        tbl_sales_contact.actual_value_in_kg,
                        tbl_sales_contact.commission_in_kg,
                        tbl_sales_contact.commission_percent,
                        tbl_sales_contact.commission_dollar_amount,
                        tbl_sales_contact.dollar_conversion_rate, 
                        tbl_sales_contact.commission_amount,
                        tbl_sales_contact.commission_date,
                        tbl_sales_contact.entry_by,
                        tbl_sales_contact.approve_by
                    FROM 
                        tbl_sales_contact
                        inner join tbl_lc using(lc_id)
                        inner join tbl_product using (product_id)
                        inner join tbl_client as payee on payee.client_id=tbl_sales_contact.employee_id
                        inner join tbl_client on tbl_client.client_id=tbl_sales_contact.party_id
                    WHERE 
                        1 
                        
                    union all
                    SELECT 
                        id as contactIds,
                        payee.client_name as employee_name,
                        payee.client_id as employee_id,
                        payee.client_office_address as address,
                        payee.client_contact_no as contact_no,
                        'PI' as commission_type,
                        tbl_sales_contact.pi_no as refrenceNo,
                        tbl_sales_contact.pi_date as transection_date,
                        tbl_client.client_name,
                        tbl_client.client_office_address,
                        tbl_product.product_description,
                        tbl_sales_contact.product_qty,
                        tbl_sales_contact.sale_value_in_kg,
                        tbl_sales_contact.actual_value_in_kg,
                        tbl_sales_contact.commission_in_kg,
                        tbl_sales_contact.commission_percent,
                        tbl_sales_contact.commission_dollar_amount, 
                        tbl_sales_contact.dollar_conversion_rate, 
                        tbl_sales_contact.commission_amount,
                        tbl_sales_contact.commission_date,
                        tbl_sales_contact.entry_by,
                        tbl_sales_contact.approve_by
                    FROM 
                        tbl_sales_contact
                        inner join tbl_product using (product_id)
                        inner join tbl_client as payee on payee.client_id=tbl_sales_contact.employee_id
                        inner join tbl_client on tbl_client.client_id=tbl_sales_contact.party_id
                    WHERE 
                        1 
                        and tbl_sales_contact.invoice_id is null and tbl_sales_contact.lc_id is null

                    ) as temp
                WHERE
                    refrenceNo = ?
                    and employee_id = ?";
        $query = $this->db->query($sql,array($refrenceNo,$payeeId));
        return $query->result_array();   
    }

    function update_sales_contact($contactIds,$dataArray)
    {
        return $this->db
            ->where_in('id',$contactIds)
            ->update('tbl_sales_contact', $dataArray );
    }

	function getdatewisesales($clientId=0,$fromDate=NULL,$toDate=NULL)
    {
        $sql = "SELECT
                    tbl_invoice.invoice_id,client_id,client_name,invoice_no,tbl_invoice.status,invoice_date,client_contact_no,net_total ,sum(quantity) as totalqty,sum(delivered_qty) as totaldelivered
                FROM
                    tbl_invoice
                    inner join tbl_client using(client_id)
                    inner join tbl_invoice_details using (invoice_id)
                WHERE 1
                    and tbl_invoice.status='1'
		                ".($clientId>0?" and client_id='".$clientId."'":"")."
                    ".($fromDate!=NULL && $toDate!==NULL?" and invoice_date between '".$fromDate."' and '".$toDate."'" : " and invoice_date = curdate()")."
                group by
                    invoice_id
				order by
					tbl_invoice.invoice_id asc
                ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    function getsales($clientId=0,$fromDate=NULL,$toDate=NULL)
    {
        $sql = "SELECT
                    client_id,client_name,invoice_no,client_contact_no,sum(net_total) as netSales ,sum(totalqty) as totalqty
                FROM
                    tbl_invoice
                    inner join tbl_client using(client_id)
                    inner join (select invoice_id,sum(quantity) as totalqty from tbl_invoice_details group by  invoice_id) as tbl_invoice_details using (invoice_id)
                WHERE 1
                    and tbl_invoice.status='1'
		                ".($clientId>0?" and client_id='".$clientId."'":"")."
                    ".($fromDate!=NULL && $toDate!==NULL?" and invoice_date between '".$fromDate."' and '".$toDate."'" : "")."
                group by
                    client_id
                order by
					           client_name asc
                ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    function getUnapprovedInvoiceList()
    {
        $sql = "SELECT
                    tbl_invoice.invoice_id,client_id,client_name,invoice_no,tbl_invoice.status,invoice_date,client_contact_no,net_total ,sum(quantity) as totalqty,sum(delivered_qty) as totaldelivered
                FROM
                    tbl_invoice
                    inner join tbl_client using(client_id)
                    inner join tbl_invoice_details using (invoice_id)

                WHERE 1
                    and tbl_invoice.status=0
                group by
                    invoice_id
                ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    function approveInvoice($invoiceNumber)
    {
        $this->db->set('status',1);
        $this->db->set('approved_by',$this->session->userdata('username'));
        $this->db->set('approved_date',date('Y-m-d'));
        $this->db->where('invoice_id',$invoiceNumber);

        return $this->db->update('tbl_invoice');
    }


    function getDeliveryList()
    {
        $sql = "SELECT *
                FROM
                    `tbl_delivery`
                    inner join tbl_client using(client_id)
                    left join tbl_invoice using (invoice_id)
                WHERE 1
                ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    function getUninvoicedDeliveryList()
    {
        $sql = "SELECT *
                FROM
                    `tbl_delivery`
                    inner join tbl_client using(client_id)
				WHERE 1 and invoice_id=0

                ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    function getClientUninvoicedDeliveryList($clientId)
    {
        $sql = "SELECT *
                FROM
                    `tbl_delivery`
                    inner join tbl_client using(client_id)
				WHERE 1 and invoice_id=0
				and tbl_delivery.client_id=?
                ";
        $query = $this->db->query($sql,array($clientId));
        return $query->result_array();
    }

    function getDelivery($deliveryId)
    {
        $sql = "SELECT
                    tbl_delivery.*,
                    tbl_delivery_details.*,
                    tbl_client.client_id,tbl_client.client_name,client_contact_no,client_email,client_office_address,client_delivery_address,
                    product_description,tbl_location.location_name
                FROM
                    `tbl_delivery`
                    inner join tbl_client using(client_id)
                    /*inner join tbl_invoice using (invoice_id) */
                    inner join tbl_delivery_details using(delivery_id)
                    inner join tbl_product using(product_id)
					left join tbl_location using(location_id)
                WHERE 1
                    and tbl_delivery.delivery_id = '".$deliveryId."'
                ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    function getInvoice($invoiceNo)
    {

        $sql = "SELECT
                    tbl_invoice.invoice_id,
                    client_id,
                    client_name,
                    client_office_address,
                    client_delivery_address,
                    client_contact_no,
                    client_email,
                    invoice_no,
                    invoice_date,
                    net_total,
                    tbl_product.product_id,
                    product_name,
                    product_description,
                    quantity,
                    product_unit,
                    unit_price,(quantity*unit_price) as itemtotal,
                    delivered_qty,
                    tbl_product.product_rate,
                    tbl_invoice.created_by,
                    tbl_invoice.approved_by
                FROM
                    tbl_invoice
                    inner join tbl_invoice_details using(invoice_id)
                    inner join tbl_client using(client_id)
                    inner join tbl_product using(product_id)
                WHERE 1
                    and tbl_invoice.invoice_id='".$invoiceNo."'";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    function productwisesales($fromDate, $toDate, $productId=0, $customerId=0)
    {

        $sql = "SELECT
                    tbl_invoice.invoice_id,client_id,client_name,client_office_address, client_delivery_address, client_contact_no, client_email,invoice_no,invoice_date,tbl_product.product_id,product_name,product_description,quantity,product_unit,unit_price,(quantity*unit_price) as itemtotal,delivered_qty
                FROM
                    tbl_invoice
                    inner join tbl_invoice_details using(invoice_id)
                    inner join tbl_client using(client_id)
                    inner join tbl_product using(product_id)
                WHERE 1
					and invoice_date between '".$fromDate."' and '".$toDate."'
					".($productId>0? " and tbl_product.product_id='".$productId."'":"")."
					".($customerId>0? " and tbl_client.client_id='".$customerId."'":"")."
                order by
					invoice_date,product_description asc";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    function clientTotalBill($clientId,$dateUpto)
    {
        $this->db->select('ifnull(sum(net_total),0) as totalInvoice');
        $this->db->from('tbl_invoice');
        $this->db->where("status",1);
        $this->db->where("client_id",$clientId);
        $this->db->where("invoice_date < ",$dateUpto);

        return $this->db->get()->row()->totalInvoice;
    }



    /*function clientTotalCollection($clientId,$dateUpto)
    {
        $sql = "select 
                sum(collection_amount-net_total) as totlaCollection
               from (SELECT
                      deposit_date as transection_date,concat('Bounce No. ',tbl_collection.checque_no) as transectionType,collection_no as transectionNumber,collection_amount as net_total,'' as collection_amount
                FROM
                      tbl_collection
                      inner join tbl_bank_deposit USING ( collection_id )
                where
                      1
                      and status=1
                      and deposit_status='bounce'
                      and client_id='".$clientId."'
                
                union all
                SELECT 
                    COALESCE( deposit_date, collection_date ) AS transection_date, 
                    IF( deposit_status =  'bounce', 
                        concat(deposit_status,' No. ',tbl_collection.checque_no), 
                        if(collection_type='cheque',
                            CONCAT(  'By ', collection_type,' No. ',tbl_collection.checque_no ),
                            CONCAT(  'By ', collection_type ) 
                            )) AS transectionType, collection_no AS transectionNumber, '0'  AS net_total,  collection_amount  AS collection_amount
                FROM 
                    tbl_collection
                    LEFT JOIN tbl_bank_deposit USING ( collection_id ) 
                where
                      1
                      and status=1
                      and client_id='".$clientId."'
                      
                ) as temp
                where transection_date < '".$dateUpto."'";
         $query = $this->db->query($sql);
        return $query->row()->totlaCollection;

    }
*/
    function clientTotalCollection($clientId,$dateUpto)
    {
        $this->db->select('ifnull(sum(collection_amount),0) as totlaCollection');
        $this->db->from('tbl_collection');
        $this->db->where("status",1);
        $this->db->where("cheque_status","Clear");
        $this->db->where("client_id",$clientId);
        $this->db->where("collection_date < ",$dateUpto);
        return $this->db->get()->row()->totlaCollection;
    }

    function clientTotalCollected($clientId,$dateUpto)
    {
        $this->db->select('ifnull(sum(collection_amount),0) as totlaCollection');
        $this->db->from('tbl_collection');
        $this->db->where("status",1);
        $this->db->where("cheque_status","Collected");
        $this->db->where("client_id",$clientId);
        $this->db->where("collection_date < ",$dateUpto);
        return $this->db->get()->row()->totlaCollection;
    }

    function clientTotalBounce($clientId,$dateUpto)
    {
        $this->db->select('ifnull(sum(collection_amount),0) as totlaCollection');
        $this->db->from('tbl_collection
        inner join tbl_bank_deposit using (collection_id)');
        $this->db->where("status",1);
        $this->db->where("deposit_status","bounce");
        $this->db->where("client_id",$clientId);
        $this->db->where("deposit_date < ",$dateUpto);
        return $this->db->get()->row()->totlaCollection;

    }

	function clientTotalSalesReturn($clientId,$dateUpto)
    {
        $this->db->select('ifnull(sum(quantity*rate),0) as totlasalesreturn');
        $this->db->from('tbl_sales_return');
        $this->db->where("status",1);
        $this->db->where("client_id",$clientId);
        $this->db->where("sales_return_date < ",$dateUpto);
        return $this->db->get()->row()->totlasalesreturn;
    }

    function clientTotalReceivableAdustment($clientId,$dateUpto)
    {
        $this->db->select('ifnull(sum(adjustment_amount),0) as adjustment_amount');
        $this->db->from('tbl_receivable_adjust');
        $this->db->where("client_id",$clientId);
        $this->db->where("adjustment_date < ",$dateUpto);
        return $this->db->get()->row()->adjustment_amount;
    }

    function clientTotalUnderInvoice($clientId,$dateUpto)
    {
        $this->db->select('ifnull(sum(tbl_lc_costing.amount),0) as under_invoice');
        $this->db->from('tbl_lc INNER JOIN tbl_lc_costing USING ( lc_id )');
        $this->db->where("tbl_lc.supplier_id",$clientId);
        $this->db->where("tbl_lc_costing.costing_head",'Under Invoice');
        $this->db->where("tbl_lc_costing.cost_date < ",$dateUpto);
        return $this->db->get()->row()->under_invoice;
    }

    function transections($clientId=0,$fromDate='',$toDate='')
    {
        $sql = "SELECT *
                from 
                    (SELECT
                        invoice_date as transection_date,'Sales' as transectionType,invoice_no as transectionNumber,net_total,'' as collection_amount,'1' as sortorder
                    FROM
                        tbl_invoice
                    where
                        status = 1
                        and client_id='".$clientId."'
                        
                    union all
            				SELECT
                          sales_return_date as transection_date,'Sales Return' as transectionType,sales_return_number as transectionNumber,'' as net_total,sum(quantity*rate) as collection_amount,'3' as sortorder
                    FROM
                          tbl_sales_return
                          inner join tbl_client using (client_id)
                    WHERE
                          tbl_sales_return.status='1'
      					  and client_id='".$clientId."'
                          
                    group by
                          sales_return_number
            		union all
                    SELECT
                          deposit_date as transection_date,concat('Bounce No. ',tbl_collection.checque_no) as transectionType,collection_no as transectionNumber,collection_amount as net_total,'' as collection_amount,'2' as sortorder
                    FROM
                          tbl_collection
                          inner join tbl_bank_deposit USING ( collection_id )
                    where
                          1
                          and status=1
                          and deposit_status='bounce'
                          and client_id='".$clientId."'
                          
                    union all
                    SELECT 
                        COALESCE( if(deposit_status =  'bounce',collection_date,deposit_date), collection_date ) AS transection_date, 
                        IF(collection_type='cheque',
                                CONCAT(  'By ', collection_type,' No. ',tbl_collection.checque_no,if(cheque_status !=  'Clear','[ pending]','') ),
                                CONCAT(  'By ', collection_type ) 
                                ) AS transectionType, collection_no AS transectionNumber, ''  AS net_total,  collection_amount , '4' AS sortorder
                    FROM 
                        tbl_collection
                        LEFT JOIN tbl_bank_deposit USING ( collection_id ) 
                    where
                          1
                          /*and deposit_status='bounce'*/
                          and status=1
                          and client_id='".$clientId."'
                          
                    union all
                    SELECT
                        adjustment_date as transection_date,adjustment_type as trnasectionType,'' as transectionNumber,'' as net_total,adjustment_amount as collection_amount,'5' as sortorder
                    FROM
                        tbl_receivable_adjust
                    WHERE
                        1
                        and client_id='".$clientId."'
                        
                    union all
                    SELECT
                        invoice_date as transection_date,'Purchase' as transectionType,invoice_no as transectionNumber,'' as net_total,net_total as collection_amount,'6' as sortorder
                    FROM
                        tbl_purchase_invoice
                    where
                        status =1
                        and party_id='".$clientId."'
                        
                    union all
                    SELECT 
                        cost_date as transection_date,'Assembly Charge' as transectionType,lc_no as transectionNumber,'' as net_total,tbl_lc_costing.amount as collection_amount,'6' as sortorder 
                    FROM 
                        tbl_lc
                        INNER JOIN  tbl_lc_costing USING ( lc_id ) 
                    WHERE 
                        costing_head =  'Under Invoice'
                        and tbl_lc.supplier_id='".$clientId."'
                        
                    union all
    				SELECT
                        payment_date as transection_date,'Payment' as transectionType,'' as transectionNumber,pay_amount as net_total,'' as collection_amount,'7' as sortorder
                    FROM
                        tbl_payment
                    where
                        1
                        and status=1
                        and party_id='".$clientId."'
                    union all
                    SELECT
                        transection_date,transection_desc as transectionType,'' as transectionNumber,dr_amount as net_total,cr_amount as collection_amount,'7' as sortorder
                    FROM
                        tbl_party_misc_transection
                    where
                        1
                        and party_id='".$clientId."'
                        
                    ) as temp 
                where 
                    transection_date between '".$fromDate."' and '".$toDate."'
                order by
                      transection_date,sortorder";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    function accountopeningabalnce($clientId,$uptodateDate)
    {
        $sql = "SELECT 
                    if(client_type='Debtor',sum(ifnull(net_total,0)-ifnull(collection_amount,0)),sum(ifnull(collection_amount,0)-ifnull(net_total,0))) as opening_balance
                from 
                    (SELECT
                        client_id,invoice_date as transection_date,'Sales' as transectionType,invoice_no as transectionNumber,net_total,'' as collection_amount,'1' as sortorder
                    FROM
                        tbl_invoice
                    where
                        status = 1
                        and client_id='".$clientId."'
                        
                    union all
                    SELECT
                        client_id,sales_return_date as transection_date,'Sales Return' as transectionType,sales_return_number as transectionNumber,'' as net_total,sum(quantity*rate) as collection_amount,'3' as sortorder
                    FROM
                          tbl_sales_return
                          inner join tbl_client using (client_id)
                    WHERE
                          tbl_sales_return.status='1'
                          and client_id='".$clientId."'
                          
                    group by
                          sales_return_number
                    union all
                    SELECT
                          client_id,deposit_date as transection_date,concat('Bounce No. ',tbl_collection.checque_no) as transectionType,collection_no as transectionNumber,collection_amount as net_total,'' as collection_amount,'2' as sortorder
                    FROM
                          tbl_collection
                          inner join tbl_bank_deposit USING ( collection_id )
                    where
                          1
                          and status=1
                          and deposit_status='bounce'
                          and client_id='".$clientId."'
                          
                    union all
                    SELECT 
                        client_id,COALESCE( if(deposit_status =  'bounce',collection_date,deposit_date), collection_date ) AS transection_date, 
                        IF(collection_type='cheque',
                                CONCAT(  'By ', collection_type,' No. ',tbl_collection.checque_no ),
                                CONCAT(  'By ', collection_type ) 
                                ) AS transectionType, collection_no AS transectionNumber, ''  AS net_total,  collection_amount ,  '4' AS sortorder
                    FROM 
                        tbl_collection
                        LEFT JOIN tbl_bank_deposit USING ( collection_id ) 
                    where
                          1
                          /*and deposit_status='bounce'*/
                          and status=1
                          and client_id='".$clientId."'
                          
                    union all
                    SELECT
                        client_id,adjustment_date as transection_date,adjustment_type as trnasectionType,'' as transectionNumber,'' as net_total,adjustment_amount as collection_amount,'5' as sortorder
                    FROM
                        tbl_receivable_adjust
                    WHERE
                        1
                        and client_id='".$clientId."'
                        
                    union all
                    SELECT
                        party_id as client_id,invoice_date as transection_date,'Purchase' as transectionType,invoice_no as transectionNumber,'' as net_total,net_total as collection_amount,'6' as sortorder
                    FROM
                        tbl_purchase_invoice
                    where
                        status =1
                        and party_id='".$clientId."'
                        
                    union all
                    SELECT 
                        tbl_lc.supplier_id as client_id,cost_date as transection_date,'Assembly Charge' as transectionType,lc_no as transectionNumber,'' as net_total,tbl_lc_costing.amount as collection_amount, '6' as sortorder 
                    FROM 
                        tbl_lc
                        INNER JOIN  tbl_lc_costing USING ( lc_id ) 
                    WHERE 
                        costing_head =  'Under Invoice'
                        and tbl_lc.supplier_id='".$clientId."'
                        
                    union all
                    SELECT
                        party_id as client_id,payment_date as transection_date,'Payment' as transectionType,'' as transectionNumber,pay_amount as net_total,'' as collection_amount,'7' as sortorder
                    FROM
                        tbl_payment
                    where
                        1
                        and status=1
                        and party_id='".$clientId."'
                    union all
                    SELECT
                        party_id as client_id,transection_date,transection_desc as transectionType,'' as transectionNumber,dr_amount as net_total,cr_amount as collection_amount,'7' as sortorder
                    FROM
                        tbl_party_misc_transection
                    where
                        1
                        and party_id='".$clientId."'
                    
                    ) as temp inner join tbl_client using(client_id)
                where 
                    transection_date < '".$uptodateDate."'
                ";
        $query = $this->db->query($sql);
        return $query->row()->opening_balance;
    }

    function accountopeningabalnceaccounts($clientId,$uptodateDate)
    {
        $sql = "SELECT 
                    if(client_type='Debtor',sum(ifnull(net_total,0)-ifnull(collection_amount,0)),sum(ifnull(collection_amount,0)-ifnull(net_total,0))) as opening_balance
                from 
                    (SELECT
                        client_id,invoice_date as transection_date,'Sales' as transectionType,invoice_no as transectionNumber,net_total,'' as collection_amount,'1' as sortorder
                    FROM
                        tbl_invoice
                    where
                        status = 1
                        and client_id='".$clientId."'
                        
                    union all
                    SELECT
                        client_id,sales_return_date as transection_date,'Sales Return' as transectionType,sales_return_number as transectionNumber,'' as net_total,sum(quantity*rate) as collection_amount,'3' as sortorder
                    FROM
                          tbl_sales_return
                          inner join tbl_client using (client_id)
                    WHERE
                          tbl_sales_return.status='1'
                          and client_id='".$clientId."'
                          
                    group by
                          sales_return_number
                    /*union all
                    SELECT
                          client_id,deposit_date as transection_date,concat('Bounce No. ',tbl_collection.checque_no) as transectionType,collection_no as transectionNumber,collection_amount as net_total,'' as collection_amount,'2' as sortorder
                    FROM
                          tbl_collection
                          inner join tbl_bank_deposit USING ( collection_id )
                    where
                          1
                          and status=1
                          and deposit_status='bounce'
                          and client_id='".$clientId."'*/
                          
                    union all
                    SELECT 
                        client_id,COALESCE( if(deposit_status =  'bounce',collection_date,deposit_date), collection_date ) AS transection_date, 
                        IF(collection_type='cheque',
                                CONCAT(  'By ', collection_type,' No. ',tbl_collection.checque_no ),
                                CONCAT(  'By ', collection_type ) 
                                ) AS transectionType, collection_no AS transectionNumber, ''  AS net_total,  collection_amount ,  '4' AS sortorder
                    FROM 
                        tbl_collection
                        LEFT JOIN tbl_bank_deposit USING ( collection_id ) 
                    where
                          1
                          /*and deposit_status='bounce'*/
                          and status=1
                          and client_id='".$clientId."'
                          
                    union all
                    SELECT
                        client_id,adjustment_date as transection_date,adjustment_type as trnasectionType,'' as transectionNumber,'' as net_total,adjustment_amount as collection_amount,'5' as sortorder
                    FROM
                        tbl_receivable_adjust
                    WHERE
                        1
                        and client_id='".$clientId."'
                        
                    union all
                    SELECT
                        party_id as client_id,invoice_date as transection_date,'Purchase' as transectionType,invoice_no as transectionNumber,'' as net_total,net_total as collection_amount,'6' as sortorder
                    FROM
                        tbl_purchase_invoice
                    where
                        status =1
                        and party_id='".$clientId."'
                        
                    union all
                    SELECT 
                        tbl_lc.supplier_id as client_id,cost_date as transection_date,'Assembly Charge' as transectionType,lc_no as transectionNumber,'' as net_total,tbl_lc_costing.amount as collection_amount, '6' as sortorder 
                    FROM 
                        tbl_lc
                        INNER JOIN  tbl_lc_costing USING ( lc_id ) 
                    WHERE 
                        costing_head =  'Under Invoice'
                        and tbl_lc.supplier_id='".$clientId."'
                        
                    union all
                    SELECT
                        party_id as client_id,payment_date as transection_date,'Payment' as transectionType,'' as transectionNumber,pay_amount as net_total,'' as collection_amount,'7' as sortorder
                    FROM
                        tbl_payment
                    where
                        1
                        and status=1
                        and party_id='".$clientId."'
                        
                    ) as temp inner join tbl_client using(client_id)
                where 
                    transection_date < '".$uptodateDate."'
                ";
        $query = $this->db->query($sql);
        return $query->row()->opening_balance;
    }

  	function collectionlist($clientId=0,$fromDate=NULL,$toDate=NULL,$colletionType=NULL)
  	{
  		$sql = "SELECT
                      collection_date ,remarks,client_name,collection_type,collection_amount
                  FROM
                      tbl_collection
  	                  inner join tbl_client using (client_id)
                  where
                      1
                      and status=1
                      ".($colletionType?" and collection_type='".$colletionType."'":"")."
                      ".($clientId>0?" and client_id='".$clientId."'":"")."
                      ".($fromDate!=NULL && $toDate!==NULL?" and collection_date between '".$fromDate."' and '".$toDate."'" : " and collection_date = curdate()")."
                  order by
                      collection_date,client_name";
  		$query = $this->db->query($sql);
          return $query->result_array();
  	}

  	function partysummery($clentType='')
  	{
  		$sql = "SELECT
  					tbl_client.client_id, client_name,client_type,client_section, entry_balance AS opening_balance, sum(net_total) as invoicetotal, collections.collection,sales_return.return_amount,sales_discount,source_tax,purchase_amount,pay_amount,under_invoice_amount,misc_transection
  				FROM
  					tbl_client
  					left join tbl_invoice using (client_id)
                    left join (select party_id,sum(net_total) as purchase_amount from tbl_purchase_invoice where status =1  GROUP BY party_id) as purchase on tbl_client.client_id=purchase.party_id
                    left join (select party_id,sum(pay_amount) as pay_amount from tbl_payment where status=1 group by party_id) as payment on tbl_client.client_id=payment.party_id
  					left join (select client_id,sum(collection_amount) as collection from tbl_collection where status=1 group by client_id) as collections using (client_id)
  					left join (select client_id,sum(quantity*rate) as return_amount from tbl_sales_return where status=1 group by client_id) as sales_return using (client_id)
                    left join (select client_id,sum(adjustment_amount) as sales_discount from tbl_receivable_adjust where adjustment_type='Sales Discount' group by client_id) as sales_discount using (client_id)
                    left join (select client_id,sum(adjustment_amount) as source_tax from tbl_receivable_adjust where adjustment_type='Source Tax' group by client_id) as source_tax using (client_id)
                    left join(SELECT tbl_lc.supplier_id, sum(tbl_lc_costing.amount) as under_invoice_amount FROM tbl_lc INNER JOIN tbl_lc_costing USING ( lc_id ) WHERE costing_head =  'Under Invoice' GROUP BY tbl_lc.supplier_id) as under_invoice on  tbl_client.client_id=under_invoice.supplier_id
                    left join(SELECT client_id,sum(ifnull(if(client_type='Debtor',dr_amount-cr_amount,cr_amount-dr_amount),0)) as misc_transection FROM `tbl_party_misc_transection` INNER join tbl_client on client_id=party_id WHERE 1 GROUP by client_id) as misc_transection on misc_transection.client_id=tbl_client.client_id
  				WHERE 1
                    and tbl_client.client_id not in(118)
                    ".($clentType?"and client_type='".$clentType."'":"")."
  				GROUP BY tbl_client.client_id
                order by
                    client_section desc, client_name asc";
  		$query = $this->db->query($sql);
        return $query->result_array();
  	}

    function getInvoiceNumber()
    {
        $this->db->select('concat("SBIN",(ifnull(max(substr(invoice_no,5)),16200)+1)) as invoice_no');
        $this->db->from('tbl_invoice');
        return $this->db->get()->row()->invoice_no;

    }

    function getDeliveryNumber()
    {
        $this->db->select('concat("SBDC",(ifnull(max(substr(challan_no,5)),16201000)+1)) as challan_no');
        $this->db->from('tbl_delivery');
        return $this->db->get()->row()->challan_no;
    }

    function getCollectionNumber()
    {
        $this->db->select('concat("MSB",(ifnull(max(substr(collection_no,4)),1000)+1)) as collection_no');
        $this->db->from('tbl_collection');
        return $this->db->get()->row()->collection_no;
    }

    function getSalesReturnNumber()
    {
        $this->db->select('concat("SRSB",(ifnull(max(substr(sales_return_number,5)),1000)+1)) as sales_return_number');
        $this->db->from('tbl_sales_return');
        return $this->db->get()->row()->sales_return_number;
    }

    function create_invoice_id($data)
    {
        $this->db->insert('tbl_invoice', $data);
        return $this->db->insert_id();
    }

    function create_invoice_details($data)
    {
        return $this->db->insert_batch('tbl_invoice_details', $data);
    }

    function adjustReceivable($data)
    {
        return $this->db->insert('tbl_receivable_adjust',$data);
    }

    function create_delivery_id($data)
    {
        $this->db->insert('tbl_delivery', $data);
        return $this->db->insert_id();
    }

    function delivery_details_create($data)
    {
        return $this->db->insert('tbl_delivery_details', $data);
    }

    function create_delivery_details($data,$invoiceId)
    {
        $this->db->insert('tbl_delivery_details', $data);
        $sql = "update tbl_invoice_details set delivered_qty = delivered_qty+".$data['qty']." where invoice_id='".$invoiceId."' and product_id='".$data['product_id']."'";

        return $this->db->query($sql);
    }

    function create_collection($data)
    {
        return $this->db->insert('tbl_collection', $data);

    }
    function get_collections($status = NULL)
    {
        $sql="SELECT
                tbl_client.client_id, tbl_client.client_name,tbl_collection.collection_id,tbl_collection.collection_no,tbl_collection.collection_date,tbl_collection.collection_type,sum(tbl_collection.collection_amount) as collection_amount,tbl_collection.remarks
              FROM
                `tbl_client` inner join tbl_collection using(client_id)
              WHERE 1
                ".($status!=NULL?" and tbl_collection.status='".$status."'":"")."
              group by
                tbl_collection.collection_no
               ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    function get_cheque_collections($status = NULL)
    {
        $sql="SELECT
                tbl_client.*,tbl_collection.*,tbl_bank.*,tbl_bank_deposit.deposit_id,tbl_bank_deposit.deposit_status
              FROM
                `tbl_client` inner join tbl_collection using(client_id)
				left join tbl_bank using (bank_id)
				left join tbl_bank_deposit using (collection_id)
              WHERE 1
				and collection_type = 'cheque'
                ".($status!=NULL?" and tbl_collection.status='".$status."'":"")."
               ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    function get_collectionDetails($collectionNo)
    {
        $sql="SELECT
                *
              FROM
                `tbl_client` inner join tbl_collection using(client_id)
				left join tbl_bank using (bank_id)
              WHERE
				tbl_collection.collection_no = '".$collectionNo."'
               ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    function get_collectionrow($collectionId)
    {
        $sql="SELECT
                *
              FROM
                `tbl_client` inner join tbl_collection using(client_id)
				left join tbl_bank using (bank_id)
              WHERE
				tbl_collection.collection_id = '".$collectionId."'
               ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    function approveCollection($collectionNo)
    {
        $this->db->set('status',1);
        $this->db->set('approved_by',$this->session->userdata('username'));
        $this->db->set('approved_date',date('Y-m-d'));
        $this->db->where('collection_no',$collectionNo);

        return $this->db->update('tbl_collection');
    }

    function update_collection($collectionId,$dataArray)
    {
        return $this->db
            ->where('collection_id',$collectionId)
            ->update('tbl_collection', $dataArray );
    }

    function update_invoice_details($invoiceId,$productId,$dataArray)
    {
        return $this->db
            ->where('invoice_id',$invoiceId)
            ->where('product_id',$productId)
            ->update('tbl_invoice_details', $dataArray );
    }

    function update_invoice($invoiceId,$dataArray)
    {
        return $this->db
            ->where('invoice_id',$invoiceId)
            ->update('tbl_invoice', $dataArray );
    }

    function insertEmpCommission($data)
    {
        return $this->db->insert_batch('tbl_emp_sales_commission', $data);
    }

    function createSalesReturn($data)
    {
        return $this->db->insert_batch('tbl_sales_return', $data);
    }

    function create_sales_contact($data)
    {
        return $this->db->insert_batch('tbl_sales_contact', $data);
    }

    function getsalesreturnlist($status=NULL)
    {
        $sql = "SELECT
                    sales_return_number,sales_return_date,client_name,sum(quantity) as totalqty,sum(quantity*rate) as totalamount,tbl_sales_return.status,tbl_sales_return.entry_by
                FROM
                    tbl_sales_return
                    inner join tbl_client using (client_id)
                WHERE 1
                    ".($status!=NULL?" and tbl_sales_return.status='".$status."'":"")."
                group by
                    sales_return_number
                ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    function getsalesreturn($salesReturnNumber)
    {
        $sql = "SELECT
                    sales_return_number,sales_return_date,client_id,client_name,sum(quantity) as totalqty,sum(quantity*rate) as totalamount,tbl_sales_return.status,tbl_sales_return.entry_by
                FROM
                    tbl_sales_return
                    inner join tbl_client using (client_id)
                WHERE
                    sales_return_number=?
                ";
        $query = $this->db->query($sql, array($salesReturnNumber));
        return $query->result_array();
    }

    function updatesalesreturnstatus($salesReturnNumber,$dataArray)
    {
        if($dataArray['status']==1){
             $sql = "insert into tbl_stock_receive(stock_receive_type,referrence_number,stock_receive_date,product_id,quantity,rate,location_id,entry_by) SELECT 'Sales Return' as outtype,sales_return_number,curdate() as outdate, product_id,`quantity`,product_rate,location_id,? FROM `tbl_sales_return` inner join tbl_product using (product_id) where tbl_sales_return.status = 0 and sales_return_number = ? ";

        $query = $this->db->query($sql,array($this->session->userdata('username'),$salesReturnNumber));
        return $this->db
                ->where('sales_return_number',$salesReturnNumber)
                ->update('tbl_sales_return', $dataArray );
        }

    }
}
?>
