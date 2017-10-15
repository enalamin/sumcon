<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Purchase extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        $this->load->database();
        $this->load->model('product_model');
        $this->load->model('party_model');
        $this->load->model('client_model');
        $this->load->model('purchase_model');
		$this->load->model('location_model');
        $this->load->model('accounts_model');
        $this->load->model('sales_model');
        $this->load->model('bank_model');
        $this->load->model('lc_model');
        $currentMenue = array('activeSidebar' => 'purchase');
        $this->session->set_userdata($currentMenue);
    }
    public function index()
    {
        if($this->session->has_userdata('username')){
            /*$data["invoiceList"] = $this->purchase_model->getInvoiceList();
            $this->load->view('purchase_view',$data);*/
            $data["receiveList"] = $this->purchase_model->get_approved_receiveList();
            $this->load->view('receive_list_view',$data);
        }
        else
            redirect ("login");
    }

    public function unapproveinvoice()
    {
        if($this->session->has_userdata('username')){
            $data["invoiceList"] = $this->purchase_model->getUnapproveInvoiceList();
            $this->load->view('purchase_view',$data);
        }
        else
            redirect ("login");
    }

    public function invoicelist()
    {
        if($this->session->has_userdata('username')){
            $currentMenue = array('activeSidebar' => 'reports');
            $this->session->set_userdata($currentMenue);
            $data["invoiceList"] = $this->purchase_model->getInvoiceList();
            $this->load->view('purchase_view',$data);
        }
        else
            redirect ("login");
    }

    public function purchaseorder()
    {
        if($this->session->has_userdata('username')){
            if ($this->input->post('btn_save') == "Save Order"){
               // print_r($_POST);
                $orderNumber = $this->input->post("orderNumber");
                $orderDate = date('Y-m-d',  strtotime($this->input->post("datemask")));
                $purchaseType = $this->input->post("purchaseType");
                $party = $this->input->post("party");
                $totalItemRow = $this->input->post("totalItemRow");
                $products = $this->input->post("productid");
                $productsQty = $this->input->post("productQty");
                $productsUnitPrice = $this->input->post("productPrice");

                //set validations
                $this->form_validation->set_rules("orderNumber", "Order Number", "trim|required");
                $this->form_validation->set_rules("datemask", "Order Date", "trim|required");
                $this->form_validation->set_rules("party", "Party Name", "trim|required");
                $this->form_validation->set_rules("totalItemRow", "total product", "trim|required");
                if ($this->form_validation->run() == FALSE){
                        //validation fails
                        redirect('purchase/purchaseorder');
                        //$this->load->view('login_view');
                }
                else{
                        for($i=0;$i<$totalItemRow;$i++){
                        $orderArray[$i] = array(
                                        'order_number' => $orderNumber,
                                        'order_date' => $orderDate,
                                        'purchase_type' => $purchaseType,
                                        'party_id' => $party,
                                        'product_id' => $products[$i],
                                        'quantity' => $productsQty[$i],
                                        'unit_price' => $productsUnitPrice[$i]
                                    );
                        }
                        $orderResult = $this->purchase_model->create_purchase_order($orderArray);
                        if ($orderResult > 0) {
                           redirect('purchase');

                        }
                    }
            }
            else {
                $data['orderNumber'] = $this->purchase_model->get_orderNumber();
                $data["productList"] =  $this->product_model->get_product();
                $data["partyList"]  = $this->client_model->get_client();
                $this->load->view('purchase_order_entry_view',$data);
            }
        }
        else
            redirect ("login");
    }

    public function productreceive()
    {
        if($this->session->has_userdata('username')){
            if ($this->input->post('btn_save') == "Save"){
               // print_r($_POST);
                $receiveNumber = $this->input->post("orderNumber");
                $receiveDate = date('Y-m-d',  strtotime($this->input->post("datemask")));
                //$purchaseType = $this->input->post("purchaseType");
                $party = $this->input->post("party");
                $totalItemRow = $this->input->post("totalItemRow");
                $products = $this->input->post("productid");
                $productsQty = $this->input->post("productQty");
                $productsPackage = $this->input->post("productPackge");
                $productsRemarks = $this->input->post("productRemarks");
                $stockLocation = $this->input->post("stockLocation");
                //set validations
                $this->form_validation->set_rules("stockLocation", "Receive Location", "trim|required");
                $this->form_validation->set_rules("orderNumber", "Receive Number", "trim|required");
                $this->form_validation->set_rules("datemask", "Receip Date", "trim|required");
                $this->form_validation->set_rules("party", "Party Name", "trim|required");
                $this->form_validation->set_rules("totalItemRow", "total product", "trim|required");
                if ($this->form_validation->run() == FALSE){
                        //validation fails
                        redirect('purchase/purchaseorder');
                        //$this->load->view('login_view');
                }
                else{
                        for($i=0;$i<$totalItemRow;$i++){
                        $orderArray[$i] = array(
                                        'receive_number' => $receiveNumber,
                                        'receive_date' => $receiveDate,
                                        'party_id' => $party,
                                        'product_id' => $products[$i],
                                        'quantity' => $productsQty[$i],
                                        'package' => $productsPackage[$i],
                                        'remarks' => $productsRemarks[$i],
										'location_id' => $stockLocation,
                                        'entry_by' => $this->session->userdata('username')
                                    );
                        }
                        $orderResult = $this->purchase_model->create_product_receive($orderArray);
                        if ($orderResult > 0) //active user record is present
                        {
                           redirect('purchase/receivelist');

                        }
                    }
            }
            else {
                $data['receiveNumber'] = $this->purchase_model->getReceiveNumber();
                $data["productList"] =  $this->product_model->get_product();
                $data["partyList"]  = $this->client_model->get_client();
		        $data["locationList"] = $this->location_model->getLocations();
                $this->load->view('product_receive_entry_view',$data);
            }
        }
        else
            redirect ("login");
    }

    function receivelist()
    {
        if($this->session->has_userdata('username')){
            $data["receiveList"] = $this->purchase_model->get_unapproved_receiveList();
            $this->load->view('receive_list_view',$data);
        }
        else
            redirect ("login");
    }

    function viewproductreceive($receiveNumber)
    {
        if($this->session->has_userdata('username')){
            $data['receiveDetails'] = $this->purchase_model->getProductsReceive($receiveNumber);
            $this->load->view('receive_details_view',$data);
        }  else {
            redirect ("login");
        }
    }

    function approvepurchasereceive($receiveNumber)
    {
        if($this->session->has_userdata('username')){
            $this->purchase_model->approve_purchase_receive($receiveNumber);
            redirect("purchase/receivelist");
        }  else {
            redirect ("login");
        }
    }

    function createpurchaseinvoice($receiveNumber)
    {
        if($this->session->has_userdata('username')){
            if ($this->input->post('btn_save') == "Save Invoice"){
               // print_r($_POST);
                $invoiceNumber = $this->input->post("invoiceNumber");
                $invoiceDate = date('Y-m-d',strtotime($this->input->post("datemask")));
                $party = $this->input->post("partyId");
                $totalItemRow = $this->input->post("totalItemRow");
                $products = $this->input->post("productid");
                $productsQty = $this->input->post("invoiceQty");
                $productsUnitPrice = $this->input->post("productRate");
                $purchaseType = $this->input->post("purchaseType");
                $invoiceTotal = $this->input->post("invoiceTotal");
		            $stockLocation = $this->input->post("stockLocation");

                //set validations
                $this->form_validation->set_rules("invoiceNumber", "Invoice Number", "trim|required");
                $this->form_validation->set_rules("stockLocation", "Invoice Number", "trim|required");
                $this->form_validation->set_rules("datemask", "Invoice Date", "trim|required");
                //$this->form_validation->set_rules("client", "Client Name", "trim|required");
                $this->form_validation->set_rules("totalItemRow", "total product", "trim|required");
                if ( $this->form_validation->run() == FALSE ){
                        //validation fails
                        redirect('purchase/createpurchaseinvoice/'.$receiveNumber);
                        //$this->load->view('login_view');
                }else{
                    // master entry
                    $invoiceArray = array(
                                        'invoice_no' => $invoiceNumber,
                                        'invoice_date' => $invoiceDate,
                                        'party_id' => $party,
                                        'purchase_type' => $purchaseType,
                                        'invoice_total' => $invoiceTotal,
                                        'net_total' => $invoiceTotal,
										'location_id' => $stockLocation,
                                        'created_by' => $this->session->userdata('username')
                                    );
                    $invoiceId= $this->purchase_model->create_invoice_id($invoiceArray);

                    for( $i=0; $i < $totalItemRow; $i++ ){
                        $invoiceDetailsArray[$i] = array(
                                        'invoice_id' => $invoiceId,
                                        'product_id' => $products[$i],
                                        'quantity' => $productsQty[$i],
                                        'unit_price' => $productsUnitPrice[$i]
                                    );
                        $stockReceiveArray[$i] = array(
                            'stock_receive_type' => "Purchase Invoice",
                            'referrence_number' => $invoiceNumber,
                            'stock_receive_date' => $invoiceDate,
                            'product_id'=> $products[$i],
                            'quantity' => $productsQty[$i],
                            'rate'=> $productsUnitPrice[$i],
                            'location_id' => $stockLocation,
                            'entry_by' => $this->session->userdata('username')
                        );

                    }

                    $orderResult = $this->purchase_model->create_invoice_details($invoiceDetailsArray,$receiveNumber);

                    if ( $orderResult > 0 ){
                        //if($this->product_model->stock_receiveall($stockReceiveArray)>0)
                            redirect('purchase');
                    }  else {
                       //fsfdsd
                    }
                }
            }
            else {
                $data['invoiceNumber'] = $this->purchase_model->getinvoiceNumber();
				$data["locationList"] = $this->location_model->getLocations();
                $data['receiveDetails'] = $receiveDetails = $this->purchase_model->getProductsReceive($receiveNumber);
                if($receiveDetails[0]['receive_status']==1)
                    $this->load->view('purchase_invoice_entry',$data);
                else
                    redirect('purchase');
            }
        }  else {
            redirect ("login");
        }
    }

    function approveinvoice($invoiceId)
    {
        if($this->session->has_userdata('username')){
            $this->purchase_model->approve_purchase_invoice($invoiceId);
            $invoiceDetails = $this->purchase_model->getInvoice($invoiceId);
            $i = 0;
            $stockReceiveArray =array();
            $updateProductRateArray = array();
            foreach ($invoiceDetails as $invoice){
              $stockReceiveArray[$i] = array(
                              'stock_receive_type' => "Purchase Invoice",
                              'referrence_number' => $invoice["invoice_no"],
                              'stock_receive_date' => $invoice["invoice_date"],
                              'product_id'=> $invoice["product_id"],
                              'quantity' => $invoice["quantity"],
                              'rate'=> $invoice["unit_price"],
                              'location_id' => $invoice["location_id"],
                              'entry_by' => $this->session->userdata('username')
                          );
              $productRate = $this->ratecalculation($invoice["product_id"],$invoice["quantity"],$invoice["unit_price"]);
              $updateProductRateArray[$i] = array('product_id'=> $invoice["product_id"],'product_rate' => $productRate);
              $i++;
            }
            $this->product_model->stock_receiveall($stockReceiveArray);
            $this->product_model->update_product_rate($updateProductRateArray);

            $voucherNumber = $this->accounts_model->get_voucher_number('journal',$invoiceDetails[0]["invoice_date"]);
            // master entry
            $voucherArray = array(
                                'voucher_number' => $voucherNumber,
                                'voucher_date' => $invoiceDetails[0]["invoice_date"],
                                'voucher_type' => 'journal',
                                'party_id' => $invoiceDetails[0]["party_id"],
                                'description' => 'create payable against purchase invoice #'.$invoiceDetails[0]["invoice_no"],
                                'entry_by' => $this->session->userdata('username'),
                                'entry_date' => date('Y-m-d')
                            );
            $voucherId= $this->accounts_model->create_voucher($voucherArray);
            $voucherDetailsArray = array();
            // transection against material purchase  [Dr.]
            $voucherDetailsArray= array(
                            'voucher_id' => $voucherId,
                            'accounts_head_id' => 88,
                            'particulers' => 'aginst the purchase invoice # '.$invoiceDetails[0]["invoice_no"],
                            'transection_type' => 'Dr',
                            'amount' => $invoiceDetails[0]["net_total"],
                            'entry_by' => $this->session->userdata('username'),
                            'entry_date' => date('Y-m-d')
                        );
            $voucherResult = $this->accounts_model->create_voucher_details($voucherDetailsArray);
            // transection against accounts payable
              $voucherDetailsArray = array(
                              'voucher_id' => $voucherId,
                              'accounts_head_id' => 12,
                              'particulers' => 'aginst the purchase invoice # '.$invoiceDetails[0]["invoice_no"],
                              'transection_type' => 'Cr',
                              'amount' => $invoiceDetails[0]["net_total"],
                              'entry_by' => $this->session->userdata('username'),
                              'entry_date' => date('Y-m-d')
                          );
              $voucherResult = $this->accounts_model->create_voucher_details($voucherDetailsArray);

            redirect("purchase/unapproveinvoice");
        }  else {
            redirect ("login");
        }
    }

    function ratecalculation($productId,$currentQty,$currentRate)
    {
        $previousRate = $this->product_model->getrate($productId);
        $totalReceive = $this->product_model->totalReceive($productId);
	      $totalOut = $this->product_model->totalOut($productId);
	      $balance = $totalReceive - $totalOut;
	      $newRate = $currentRate;
    		if($previousRate>0){
    			if($balance>0){
    				$newRate = (($currentQty*$currentRate)+ ($balance*$previousRate))/($currentQty+$balance);
    			}
    		}
    		return $newRate;
    }

    function viewinvoice($invoiceNo)
    {
        if($this->session->has_userdata('username')){
            $data['invoiceDetails'] = $this->purchase_model->getInvoice($invoiceNo);
            $this->load->view('purchase_invoice_view',$data);
        }  else {
            redirect ("login");
        }
    }

    function printinvoice($invoiceNo)
    {
        if($this->session->has_userdata('username')){
            $data['invoiceDetails'] = $this->purchase_model->getInvoice($invoiceNo);
            $this->load->view('purchase_invoice_print_view',$data);
        }  else {
            redirect ("login");
        }
    }

    function payment()
    {
         if($this->session->has_userdata('username')){
            $data['partyList'] = $this->client_model->get_client();
            $data['payments'] = $this->purchase_model->getPayments();
            $data['bankList'] = $this->bank_model->get_bank();
            $this->load->view('party_payment_view',$data);
        }  else {
            redirect ("login");
        }
    }

    public function uapprovepayments()
    {
         if($this->session->has_userdata('username')){
            $data['partyList'] = $this->client_model->get_client();
            $data['payments'] = $this->purchase_model->getPayments('0');
            $this->load->view('payment_view',$data);
        }
        else {
            redirect ("login");
        }
    }

    public function approvedpayment($paymentId)
    {
         if($this->session->has_userdata('username')){
            $this->purchase_model->approvePayment($paymentId);
            $voucherNumber= $this->accounts_model->get_voucher_number('payment',$paymentDetails[0]["payment_date"]);
            $paymentDetails = $this->purchase_model->getPayment($paymentId);
            if($paymentDetails[0]['pay_type']=='cheque'){
              $voucherArray = array(
                                  'voucher_number' => $voucherNumber,
                                  'voucher_date' => $paymentDetails[0]["payment_date"],
                                  'voucher_type' => 'payment',
                                  'transection_type' => 'Cheque',
                                  'bank_id' => $paymentDetails[0]["bank_id"],
                                  'account_no' => $paymentDetails[0]["account_no"],
                                  'cheque_number' => $paymentDetails[0]["checque_no"],
                                  'cheque_date' => $paymentDetails[0]["checque_date"],
                                  'party_id' => $paymentDetails[0]["party_id"],
                                  'description' => 'Payment against pay #'.$paymentId,
                                  'entry_by' => $this->session->userdata('username'),
                                  'entry_date' => date('Y-m-d')
                              );
            }else {
              // master entry
              $voucherArray = array(
                                  'voucher_number' => $voucherNumber,
                                  'voucher_date' => $paymentDetails[0]["payment_date"],
                                  'voucher_type' => 'payment',
                                  'transection_type' => 'Cash',
                                  'party_id' => $paymentDetails[0]["party_id"],
                                  'description' => 'Payment against pay #'.$paymentId,
                                  'entry_by' => $this->session->userdata('username'),
                                  'entry_date' => date('Y-m-d')
                              );
            }
            $voucherId= $this->accounts_model->create_voucher($voucherArray);
            $voucherDetailsArray = array();
            // transection to reduce cash/bank [Cr.]

            $voucherDetailsArray= array(
                            'voucher_id' => $voucherId,
                            'accounts_head_id' => ($paymentDetails[0]['pay_type']=='cheque'?1:2),
                            'particulers' => 'aginst pay # '.$paymentId,
                            'transection_type' => 'Cr',
                            'amount' => $paymentDetails[0]["pay_amount"],
                            'entry_by' => $this->session->userdata('username'),
                            'entry_date' => date('Y-m-d')
                        );
            $voucherResult = $this->accounts_model->create_voucher_details($voucherDetailsArray);
            // transection against payable Dr.
              $voucherDetailsArray = array(
                              'voucher_id' => $voucherId,
                              'accounts_head_id' => 12,
                              'particulers' => 'aginst payment # '.$paymentId,
                              'transection_type' => 'Dr',
                              'amount' => $paymentDetails[0]["pay_amount"],
                              'entry_by' => $this->session->userdata('username'),
                              'entry_date' => date('Y-m-d')
                          );
              $voucherResult = $this->accounts_model->create_voucher_details($voucherDetailsArray);

            redirect("purchase/uapprovepayments");
        }  else {
            redirect ("login");
        }
    }

    public function createPayment()
    {
        if($this->session->has_userdata('username')){
            //get the posted values
            $bankId=$accountNo=$chequeNo=$chequeDate=NULL;
            $partyId = $this->input->post("party");
            $payDate = date('Y-m-d',  strtotime($this->input->post("datemask")));
            $payAmount = $this->input->post("payAmount");
            $payType = $this->input->post("payType");
            $remarks = $this->input->post("remarks");
            if($payType=='cheque'){
              $bankId=$this->input->post("bank");
              $accountNo=$this->input->post("accountNo");
              $chequeNo=$this->input->post("chequeNo");
              $chequeDate=$this->input->post("chequeDate");
              $this->form_validation->set_rules("bank", "Bank", "trim|required");
              $this->form_validation->set_rules("accountNo", "Account Number", "trim|required");
              $this->form_validation->set_rules("chequeNo", "Cheque Number", "trim|required");
              $this->form_validation->set_rules("chequeDate", "Cheque Date", "trim|required");
            }

            //set validations
            $this->form_validation->set_rules("party", "Party", "trim|required");
            $this->form_validation->set_rules("datemask", "Pay Date", "trim|required");
            $this->form_validation->set_rules("payAmount", "Pay Amount", "trim|required");

            if ($this->form_validation->run() == FALSE){
                //validation fails
                redirect('purchase/payment');
                //$this->load->view('login_view');
            }
            else{
                if($this->input->post('btn_save') == "Save Payment"){
                    $payArray = array(
                                            'party_id' => $partyId,
                                            'payment_date' => $payDate,
                                            'pay_amount' => $payAmount,
                                            'pay_type' => $payType,
                                            'bank_id' => $bankId,
                                            'account_no' => $accountNo,
                                            'cheque_no' => $chequeNo,
                                            'cheque_date' => $chequeDate,
                                            'remarks' => $remarks,
                                            'entry_by' => $this->session->userdata('username')
                                        );
                    $collectionResult = $this->purchase_model->createPay($payArray);
                    if ($collectionResult > 0){
                       redirect('purchase/payment');
                    }
                    else{
                        $this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">Invalid username and password!</div>');
                        redirect('purchase/payment');
                    }
                }
                else{
                    redirect('login/index');
                }
            }
        }
        else
            redirect ("login");
    }
	public function productwisepurchase()
    {
        if($this->session->has_userdata('username')){
            $currentMenue = array('activeSidebar' => 'reports');
            $this->session->set_userdata($currentMenue);
            $data = array();
            $data['clientList'] = $this->client_model->get_client();
            $data["productList"] =  $this->product_model->get_product();
            if ($this->input->post('btn_save') == "Show"){
                $data["clientId"] = $clientId = $this->input->post("client");
                $data["productId"] = $productId = $this->input->post("product");
                $fromDate = $data["fromDate"] = date('Y-m-d',  strtotime($this->input->post("fromDate")));
                $toDate = $data["toDate"] = date('Y-m-d',  strtotime($this->input->post("toDate")));

				$data["transectionData"] = $products = $this->purchase_model->productwisepurchase($fromDate, $toDate, $productId, $clientId);


            }
            $this->load->view('product_purchase_report',$data);
        }
        else
            redirect ("login");
    }

	public function datewisepurchase()
    {
        if($this->session->has_userdata('username')){
            $currentMenue = array('activeSidebar' => 'reports');
            $this->session->set_userdata($currentMenue);
            $data = array();
            $data['clientList'] = $this->client_model->get_client();
            if ($this->input->post('btn_save') == "Show"){
                $clientId = (int)$this->input->post("client");
                if($this->input->post("toDate")==''||$this->input->post("fromDate")==''){
                    $data["fromDate"]=$data["toDate"]=$fromDate=$toDate=NULL;
                }else{
					$fromDate = $data["fromDate"] = date('Y-m-d',  strtotime($this->input->post("fromDate")));
					$toDate = $data["toDate"] = date('Y-m-d',  strtotime($this->input->post("toDate")));
                }

				$data["transectionData"] = $products = $this->purchase_model->getdatewisepurchase($clientId, $fromDate, $toDate);


            }
            $this->load->view('date_purchase_report',$data);
        }
        else
            redirect ("login");
    }

	public function datewisepayment()
    {
        if($this->session->has_userdata('username')){
            $currentMenue = array('activeSidebar' => 'reports');
            $this->session->set_userdata($currentMenue);
            $data = array();
            $data['clientList'] = $this->client_model->get_client();
            if ($this->input->post('btn_save') == "Show"){
                $paymentType = $this->input->post("paymentType");
                $clientId = (int)$this->input->post("client");
                if($this->input->post("toDate")==''||$this->input->post("fromDate")==''){
                    $data["fromDate"]=$data["toDate"]=$fromDate=$toDate=NULL;
                }else{
					$fromDate = $data["fromDate"] = date('Y-m-d',  strtotime($this->input->post("fromDate")));
					$toDate = $data["toDate"] = date('Y-m-d',  strtotime($this->input->post("toDate")));
                }

				$data["transectionData"] = $products = $this->purchase_model->paymentlist($clientId, $fromDate, $toDate,$paymentType);


            }
            $this->load->view('date_payment_report',$data);
        }
        else
            redirect ("login");
    }
	public function summerypartyledger()
    {
        if($this->session->has_userdata('username')){
            $currentMenue = array('activeSidebar' => 'reports');
            $this->session->set_userdata($currentMenue);
            $data = array();

            if ($this->input->post('btn_save') == "Show Report"){
                $clientId = 0;
				$data['balanceType'] = $this->input->post("balanceType");
                $fromDate = $data["fromDate"] = date('Y-m-d',  strtotime($this->input->post("fromDate")));
                $toDate = $data["toDate"] = date('Y-m-d',  strtotime($this->input->post("toDate")));

				$data["transectionData"] = $products = $this->purchase_model->partysummery($clientId,$fromDate,$toDate);


            }
            $this->load->view('purchase_party_summery_report',$data);
        }
        else
            redirect ("login");
    }

	public function partyledger()
    {
        if($this->session->has_userdata('username')){
            $currentMenue = array('activeSidebar' => 'reports');
            $this->session->set_userdata($currentMenue);
            $data = array();
            $data['partyList'] = $this->client_model->get_client();
            if ($this->input->post('btn_save') == "Show Report"){
                $clientId = $this->input->post("client");
                $fromDate = $data["fromDate"] = date('Y-m-d',  strtotime($this->input->post("fromDate")));
                $toDate = $data["toDate"] = date('Y-m-d',  strtotime($this->input->post("toDate")));
                //set validations
                $this->form_validation->set_rules("client", "Client", "required");
                $this->form_validation->set_rules("fromDate", "Date From", "trim|required");
                $this->form_validation->set_rules("toDate", "Date To", "trim|required");

                if ($this->form_validation->run() == TRUE)
                {
                    $openingInvoiceTotal = $this->purchase_model->partyTotalBill($clientId,$fromDate);
                    $openingUnderInvoice = $this->sales_model->clientTotalUnderInvoice($clientId,$fromDate);
                    $openingPay = $this->purchase_model->partyTotalPay($clientId,$fromDate);
                    $data['clientDetails'] = $clitentInfo = $this->client_model->get_client($clientId);
                    $data["openingBalance"] = $openingInvoiceTotal+$openingUnderInvoice+$clitentInfo[0]['entry_balance'] - $openingPay;
                    $data["transectionData"] = $products = $this->purchase_model->transections($clientId,$fromDate,$toDate);

                }

            }
            $this->load->view('purchase_party_transection_report',$data);
        }
        else
            redirect ("login");
    }

	public function printpartyledger($clientId=0,$fromDate='',$toDate='')
    {
        if($this->session->has_userdata('username')){

            $data["toDate"] = $toDate;
            $data["fromDate"] = $fromDate;
            $openingInvoiceTotal = $this->purchase_model->partyTotalBill($clientId,$fromDate);
            $openingUnderInvoice = $this->sales_model->clientTotalUnderInvoice($clientId,$fromDate);
			$openingPay = $this->purchase_model->partyTotalPay($clientId,$fromDate);
			$data['clientDetails'] = $clitentInfo = $this->client_model->get_client($clientId);
			$data["openingBalance"] = $openingInvoiceTotal+$openingUnderInvoice+$clitentInfo[0]['entry_balance'] - $openingPay;
			$data["transectionData"] = $products = $this->purchase_model->transections($clientId,$fromDate,$toDate);

            $this->load->view('purchase_party_transection_report_print',$data);
        }
        else {
            redirect ("login");
        }
    }

    public function lclistforgoodsreceive()
    {
        if($this->session->has_userdata('username')){
            $data["lcList"] = $this->lc_model->get_lc_for_receive();
            $this->load->view('lc_list_for_receive_goods',$data);
        }
        else{
            redirect ("login");
        }
    }

    public function receivelcgoods($lcId)
    {
        if($this->session->has_userdata('username')){
            if ($this->input->post('btn_save') == "Save"){
                /*print_r($_POST);
                die();*/
                $receiveDate = date('Y-m-d',  strtotime($this->input->post("receiveDate")));
                $stockLocation = $this->input->post("stockLocation");
                $receiveType = $this->input->post("receiveType");
                $products = $this->input->post("productid");
                $receivedQty = $this->input->post("receivedQty");
                $receiveQty = $this->input->post("receiveQty");
                $productunitprice = $this->input->post("productunitprice");
                $remarks = $this->input->post("remarks");
                $lcReceiveBatch= $this->lc_model->get_lc_current_batchno($lcId);
                $lcBatchInfo = $this->lc_model->get_lc_batchinof($lcId,$lcReceiveBatch);
                $lcGoodesReceive = array();
                $j=0;
                for( $i=0; $i < count($products); $i++ ){
                    $lcReceiveArray = array(
                                    'receive_date' => $receiveType=='full' ? $receiveDate:NULL,
                                    'receive_quantity' => ($receivedQty[$i]+$receiveQty[$i]),
                                    'location_id' => $stockLocation,
                                    'remarks' => $remarks[$i],
                                    'receive_by' => $this->session->userdata("username")
                                );
                    $this->lc_model->update_lc_goods($lcId,$products[$i],$lcReceiveArray);
                    if($receiveQty[$i]>0){
                        $lcGoodesReceive[$j] = array(
                            'lc_id' => $lcId,
                            'receive_date' => $receiveDate,
                            'receive_lc_batch' => $lcReceiveBatch,
                            'product_id' => $products[$i],
                            'unit_dollar_price' => $productunitprice[$i],
                            'receive_quantity' => $receiveQty[$i],
                            'dollar_rate' => $lcBatchInfo[0]['dollar_rate'],
                            'location_id' => $stockLocation,
                            'remarks' => $remarks[$i],
                            'receive_by' => $this->session->userdata("username")
                        );
                        $j++;
                    }
                }
                if(count($lcGoodesReceive)>0){
                    $orderResult = $this->lc_model->create_lc_goods_receive($lcGoodesReceive);
                }
                $this->lc_model->update_lc($lcId, array('status'=>'Goods Receive'));
                $dataArray = array(
                  'lc_id' => $lcId,
                  'status' => 'Goods Receive',
                  'description' => 'Lc Goods have been Received',
                  'receive_lc_batch' => $lcReceiveBatch,
                  'event_date' => $receiveDate,
                  'entry_by' => $this->session->userdata('username'),
                  'entry_date' => date('Y-m-d h:i:s')
              );

              $result = $this->lc_model->create_lc_history($dataArray);
              redirect("purchase/lclistforgoodsreceive");
            } else {
                $data['lcDetails'] = $this->lc_model->get_proforma($lcId);
                $data['lcProductDetails'] = $this->lc_model->getgGoodsReceive($lcId);
                $data["locationList"] = $this->location_model->getLocations();
                $this->load->view('lc_goods_receive',$data);
            }
        }
        else{
            redirect ("login");
        }   
    }

    public function lcgoodsreceiveapprove()
    {
        if($this->session->has_userdata('username')){
            $data["lcList"] = $this->lc_model->get_lc_receive_for_approve();
            $this->load->view('lc_list_receive_approve',$data);
        }
        else{
            redirect ("login");
        }
    }

    public function approvelcreceive($lcId,$batchName)
    {
        if($this->session->has_userdata('username')){
            $this->lc_model->approve_lc_receive($lcId,$batchName);
            redirect('purchase/lcgoodsreceiveapprove');
        }
        else{
            redirect ("login");
        }
    }
}
