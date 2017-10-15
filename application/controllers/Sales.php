<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sales extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model('product_model');
        $this->load->model('client_model');
        $this->load->model('bank_model');
        $this->load->model('sales_model');
        $this->load->model('purchase_model');
        $this->load->model('employee_model');
		$this->load->model('location_model');
        $this->load->model('accounts_model');
        $this->load->model('lc_model');
        $currentMenue = array('activeSidebar' => 'sales');
        $this->session->set_userdata($currentMenue);
    }

    public function index()
    {
        if($this->session->has_userdata('username')){
            $data["invoiceList"] = $this->sales_model->getInvoiceList(1);
            $data["listTitel"] = "Invoice List for Creating Delivery Challan";
            $this->load->view('sales_view',$data);
        }
        else{
            redirect ("login");
        }
    }

    public function invoiceforcommission()
    {
        if($this->session->has_userdata('username')){
            $data["invoiceList"] = '';
            if($this->input->post('btn_save')=='Show'){  
                $clientId=$this->input->post('client');              
                $invoiceNumber= $this->input->post('invoiceNumber');              
                $data["invoiceList"] = $this->sales_model->getInvoiceListForCommission($clientId,$invoiceNumber);
                $data["listTitel"] = "Invoice List for Calculation Sales Commission";
            }
            $data["clientList"]  = $this->client_model->get_client();
            $this->load->view('invoice_commission_view',$data);
        }
        else{
            redirect ("login");
        }
    }

    public function lcforcommission()
    {
        if($this->session->has_userdata('username')){
            $data["lcList"] = $this->lc_model->get_lc_for_commission();
            $this->load->view('lc_list_for_commission',$data);
        }
        else{
            redirect ("login");
        }
    }

    public function salescontactforindenting()
    {
        if($this->session->has_userdata('username')){
            if ($this->input->post('btn_save') == "Save"){
                
                $piNo = $this->input->post("pino");
                $supplierId = $this->input->post("supplier");
                $dollarRate = $this->input->post("dollarRate");
                $piDate = date('Y-m-d',  strtotime($this->input->post("datemask")));
                $commissionDate = date('Y-m-d',  strtotime($this->input->post("commissionDate")));
                $products = $this->input->post("productid");
                $productQty = $this->input->post("productQty");
                $productSaleValuekg = $this->input->post("productSaleValuekg");
                $productActualValuekg = $this->input->post("productActualValuekg");
                $productActualValue = $this->input->post("productSaleValue");
                $productActualValue = $this->input->post("productActualValue");
                $productCommissionPerKg = $this->input->post("productCommissionPerKg");
                $productCommissionPercent = $this->input->post("productCommissionPercent");
                $productCommissionDollarAmount = $this->input->post("productCommissionDollarAmount");
                $productCommissionBdtAmount = $this->input->post("productCommissionBdtAmount");
                $totalCommission = $this->input->post("commissionBdtAmountTotal");
                $totalEmpCommission = $this->input->post("totalEmpCommission");
                $employeeId = $this->input->post("employeeid");
                $empCommRate = $this->input->post("empCommRate");
                $empCommAmount = $this->input->post("empCommAmount");
                $salesContactAarray = array();
                for ($i=0; $i<count($products); $i++){
                    $salesContactAarray[$i] = array(
                        'pi_no'  => $piNo,
                        'party_id'  => $supplierId,
                        'pi_date'  => $piDate,
                        'commission_date'  => $commissionDate,
                        'dollar_conversion_rate'  => $dollarRate,
                        'product_id' => $products[$i],
                        'product_qty' => $productQty[$i],
                        'sale_value_in_kg' => $productSaleValuekg[$i],
                        'actual_value_in_kg' => $productActualValuekg[$i],
                        'employee_id' => $employeeId[$i],
                        'commission_in_kg' => $productCommissionPerKg[$i],
                        'commission_percent' => $productCommissionPercent[$i],
                        'commission_dollar_amount' => $productCommissionDollarAmount[$i],
                        'commission_amount' => $productCommissionBdtAmount[$i],
                        'entry_by'=> $this->session->userdata('username'),
                        'entry_date' => date('Y-m-d')
                    );                    
                }
                if(is_array($salesContactAarray)){
                    $this->sales_model->create_sales_contact($salesContactAarray);
                }
                
                redirect("sales/salescontactforindenting");
            }else {
                $data["clientList"] = $this->client_model->get_client();
                $data["productList"] =  $this->product_model->get_product();
                $data["emplyeeList"] = $this->employee_model->get_employee();
                $this->load->view('sales_contact_indenting',$data);
            }
        }
        else{
            redirect ("login");
        }
    }

    public function clculatelccommission($lcId)
    {
        if($this->session->has_userdata('username')){
            if ($this->input->post('btn_save') == "Save"){
                print_r($_POST);
                //die();
                $commissionDate = date('Y-m-d',  strtotime($this->input->post("commissionDate")));
                $supplierId = $this->input->post('clientId');
                $dollartRate = $this->input->post("dollartRate");
                $products = $this->input->post("comProductid");
                $productQty = $this->input->post("comProductQty");
                $productSaleValuekg = $this->input->post("productSaleValuekg");
                $productCommissionPerKg = $this->input->post("productCommissionPerKg");
                $productCommissionPercent = $this->input->post("productCommissionPercent");
                $productCommissionBdtAmount = $this->input->post("productCommissionBdtAmount");
                $totalCommission = $this->input->post("commissionBdtAmountTotal");
                $employeeId = $this->input->post("comEmployeeid");
                $salesContactAarray = array();
                for ($i=0; $i<count($products); $i++){
                    $salesContactAarray[$i] = array(
                        'lc_id'  => $lcId,
                        'party_id'  => $supplierId,
                        'commission_date'  => $commissionDate,
                        'product_id' => $products[$i],
                        'product_qty' => $productQty[$i],
                        'dollar_conversion_rate' => $dollartRate,
                        'sale_value_in_kg' => $productSaleValuekg[$i],
                        'employee_id' => $employeeId[$i],
                        'commission_in_kg' => $productCommissionPerKg[$i],
                        'commission_percent' => $productCommissionPercent[$i],
                        'commission_amount' => $productCommissionBdtAmount[$i],
                        'entry_by'=> $this->session->userdata('username'),
                        'entry_date' => date('Y-m-d')
                    );                    
                }
                if(is_array($salesContactAarray)){
                    $this->sales_model->create_sales_contact($salesContactAarray);
                }
                $lcArray = array('commission_status' => 1,'total_sales_commission' => $totalCommission);
                $this->lc_model->update_lc($lcId,$lcArray);                

               redirect("sales/lcforcommission");
            } else {
                $data['lcDetails'] = $this->lc_model->get_proforma($lcId);
                $data["clientList"] = $this->client_model->get_client();
                $data['lcProductDetails'] = $this->lc_model->getgGoodsReceive($lcId);
                $data["emplyeeList"] = $this->employee_model->get_employee();
                $this->load->view('lc_commission_calculation',$data);
            }
        }
        else{
            redirect ("login");
        }   
    }


    public function calcualtesalescommission($invoiceId)
    {
        if($this->session->has_userdata('username')){
            if ($this->input->post('btn_save') == "Save"){
                $commissionDate = date('Y-m-d',  strtotime($this->input->post("commissionDate")));
                $supplierId = $this->input->post('clientId');
                $products = $this->input->post("comProductid");
                $productQty = $this->input->post("comProductQty");
                $productSaleValuekg = $this->input->post("productSaleValuekg");
                $productCommissionPerKg = $this->input->post("productCommissionPerKg");
                $productCommissionPercent = $this->input->post("productCommissionPercent");
                $productCommissionBdtAmount = $this->input->post("productCommissionBdtAmount");
                $totalCommission = $this->input->post("commissionBdtAmountTotal");
                $employeeId = $this->input->post("comEmployeeid");
                $salesContactAarray = array();
                for ($i=0; $i<count($products); $i++){
                    $salesContactAarray[$i] = array(
                        'invoice_id'  => $invoiceId,
                        'party_id'  => $supplierId,
                        'commission_date'  => $commissionDate,
                        'product_id' => $products[$i],
                        'product_qty' => $productQty[$i],
                        'sale_value_in_kg' => $productSaleValuekg[$i],
                        'employee_id' => $employeeId[$i],
                        'commission_in_kg' => $productCommissionPerKg[$i],
                        'commission_percent' => $productCommissionPercent[$i],
                        'commission_amount' => $productCommissionBdtAmount[$i],
                        'entry_by'=> $this->session->userdata('username'),
                        'entry_date' => date('Y-m-d')
                    );                    
                }
                if(is_array($salesContactAarray)){
                    $this->sales_model->create_sales_contact($salesContactAarray);
                }

                $invoiceArray = array('commission_status' => 1,'total_sales_commission' => $totalCommission);
                $this->sales_model->update_invoice($invoiceId,$invoiceArray);                

                redirect("sales/invoiceforcommission");
            }
            else {
                $data['challanNo'] = $this->sales_model->getDeliveryNumber();
                $data["clientList"] = $this->client_model->get_client();
                $data['invoiceDetails'] = $invoiceDetails = $this->sales_model->getInvoice($invoiceId);
                $data["emplyeeList"] = $this->employee_model->get_employee();
                $this->load->view('commission_calculation',$data);
            }
        }
        else{
            redirect ("login");
        }
    }

    public function commissionforapprove()
    {
        if($this->session->has_userdata('username')){
            $data["employeeCommissions"] = $this->sales_model->getemployecommissionforapprove();
            $this->load->view('employee_commission_list_view',$data);
        }
        else{
            redirect ("login");
        }   
    }

    public function commissionlist()
    {
        if($this->session->has_userdata('username')){
            $data["employeeCommissions"] = $this->sales_model->getemployecommissions();
            $this->load->view('commission_list_view',$data);
        }
        else{
            redirect ("login");
        }   
    }

    public function empcommissiondetails($refrenceNo,$employeeId)
    {
        if($this->session->has_userdata('username')){
            $data["employeeCommissions"] = $employeeCommissions=$this->sales_model->get_commission_details($refrenceNo,$employeeId);
            $this->load->view('sales_contact_view',$data);
        }
        else{
            redirect ("login");
        }   
    }

    public function empcommissiondetailsprint($refrenceNo,$employeeId)
    {
        if($this->session->has_userdata('username')){
            $data["employeeCommissions"] = $employeeCommissions=$this->sales_model->get_commission_details($refrenceNo,$employeeId);
            $this->load->view('sales_contact_print',$data);
        }
        else{
            redirect ("login");
        }   
    }

    public function approvecommission($payeeId,$refrenceNo)
    {
        if($this->session->has_userdata('username')){
            //
            $voucherNumber = $this->accounts_model->get_voucher_number('journal');
            $commissionDetails = $this->sales_model->getcommission($payeeId,$refrenceNo);
            
            $this->sales_model->update_sales_contact(explode(',',$commissionDetails[0]['contactIds']),array('approve_by' => $this->session->userdata('username'),'approve_date' => date('Y-m-d') ));
            // create voucher
            // master entry
            $voucherArray = array(
                                'voucher_number' => $voucherNumber,
                                'voucher_date' => date('Y-m-d'),
                                'voucher_type' => 'journal',
                                'party_id' => $payeeId,
                                'description' => 'create payable against the sales commission of '.$commissionDetails[0]["client_name"].' for '.$commissionDetails[0]["commission_type"].' '.$commissionDetails[0]["refrenceNo"],
                                'entry_by' => $this->session->userdata('username'),
                                'entry_date' => date('Y-m-d')
                            );
            $voucherId= $this->accounts_model->create_voucher($voucherArray);
            $voucherDetailsArray = array();
            // transectio against payable [Cr.]
            $voucherDetailsArray= array(
                            'voucher_id' => $voucherId,
                            'accounts_head_id' => 12,
                            'particulers' =>'sales commission of '.$commissionDetails[0]["client_name"].' for '.$commissionDetails[0]["commission_type"].' '.$commissionDetails[0]["refrenceNo"],
                            'transection_type' => 'Cr',
                            'amount' => $commissionDetails[0]["commission_amount"],
                            'entry_by' => $this->session->userdata('username'),
                            'entry_date' => date('Y-m-d')
                        );
            $voucherResult = $this->accounts_model->create_voucher_details($voucherDetailsArray);
            // transection against sales commission
            $voucherDetailsArray = array(
                              'voucher_id' => $voucherId,
                              'accounts_head_id' => 92,
                              'particulers' => 'sales commission of '.$commissionDetails[0]["client_name"].' for '.$commissionDetails[0]["commission_type"].' '.$commissionDetails[0]["refrenceNo"],
                              'transection_type' => 'Dr',
                              'amount' => $commissionDetails[0]["commission_amount"],
                              'entry_by' => $this->session->userdata('username'),
                              'entry_date' => date('Y-m-d')
                          );
            $voucherResult = $this->accounts_model->create_voucher_details($voucherDetailsArray);

            //add data for sync in party ledger
            if($payeeId){
                
                $dataArray = array(
                    'party_id' => $payeeId,
                    'transection_desc' => 'sales commission of '.$commissionDetails[0]["client_name"].' for '.$commissionDetails[0]["commission_type"].' '.$commissionDetails[0]["refrenceNo"],
                    'transection_date' => date('Y-m-d'),
                    'dr_amount' => 0,
                    'cr_amount' => $commissionDetails[0]["commission_amount"],
                    'entry_by' => $this->session->userdata('username'),
                    'entry_date' => date('Y-m-d')
                );
                $this->accounts_model->create_party_misc_transection($dataArray);
            }
            redirect("sales/commissionforapprove");
        }
        else{
            redirect ("login");
        }
    }

    public function allinvoices()
    {
        if($this->session->has_userdata('username')){
            $currentMenue = array('activeSidebar' => 'reports');
            $this->session->set_userdata($currentMenue);
            $data["invoiceList"] = $this->sales_model->getInvoiceList();
            $this->load->view('invoice_list_view',$data);
        }
        else{
            redirect ("login");
        }
    }

    public function unapproveinvoice()
    {
        if($this->session->has_userdata('username')){
            $data["invoiceList"] = $this->sales_model->getUnapprovedInvoiceList();
            $data["listTitel"] = "Unapproved Invoice List";
            $this->load->view('sales_view',$data);
        }
        else{
            redirect ("login");
        }
    }

    function approveinvoice($invoiceNumber)
    {
        if($this->session->has_userdata('username')){
            $this->sales_model->approveInvoice($invoiceNumber);
            // create receivable journal for sales
            $voucherNumber = $this->accounts_model->get_voucher_number('journal',$invoiceDetails[0]["invoice_date"]);
            $invoiceDetails = $this->sales_model->getInvoice($invoiceNumber);

            // master entry
            $voucherArray = array(
                                'voucher_number' => $voucherNumber,
                                'voucher_date' => $invoiceDetails[0]["invoice_date"],
                                'voucher_type' => 'journal',
                                'party_id' => $invoiceDetails[0]["client_id"],
                                'description' => 'create receivabl against invoice #'.$invoiceDetails[0]["invoice_no"],
                                'entry_by' => $this->session->userdata('username'),
                                'entry_date' => date('Y-m-d')
                            );
            $voucherId= $this->accounts_model->create_voucher($voucherArray);
            $voucherDetailsArray = array();
            // transectio against sales [Cr.]
            $voucherDetailsArray= array(
                            'voucher_id' => $voucherId,
                            'accounts_head_id' => '23',
                            'particulers' => 'aginst the invoice # '.$invoiceDetails[0]["invoice_no"],
                            'transection_type' => 'Cr',
                            'amount' => $invoiceDetails[0]["net_total"],
                            'entry_by' => $this->session->userdata('username'),
                            'entry_date' => date('Y-m-d')
                        );
            $voucherResult = $this->accounts_model->create_voucher_details($voucherDetailsArray);
            // transection against receivable
              $voucherDetailsArray = array(
                              'voucher_id' => $voucherId,
                              'accounts_head_id' => 3,
                              'particulers' => 'aginst the invoice # '.$invoiceDetails[0]["invoice_no"],
                              'transection_type' => 'Dr',
                              'amount' => $invoiceDetails[0]["net_total"],
                              'entry_by' => $this->session->userdata('username'),
                              'entry_date' => date('Y-m-d')
                          );
              $voucherResult = $this->accounts_model->create_voucher_details($voucherDetailsArray);

          redirect("sales/unapproveinvoice");
        }  else {
            redirect ("login");
        }
    }

    public function invoice()
    {
        if($this->session->has_userdata('username')){
            if ($this->input->post('btn_save') == "Save Invoice"){
               // print_r($_POST);
                $invoiceNumber = $this->input->post("invoiceNumber");
                $invoiceDate = date('Y-m-d',  strtotime($this->input->post("datemask")));
                $client = $this->input->post("client");
                $totalItemRow = $this->input->post("totalItemRow");
                $products = $this->input->post("productid");
                $productsQty = $this->input->post("productQty");
                $productsUnitPrice = $this->input->post("productPrice");
                $invoiceTotal = $this->input->post("invoiceTotal");

                //set validations
                $this->form_validation->set_rules("invoiceNumber", "Invoice Number", "trim|required");
                $this->form_validation->set_rules("datemask", "Invoice Date", "trim|required");
                $this->form_validation->set_rules("client", "Client Name", "trim|required");
                $this->form_validation->set_rules("totalItemRow", "total product", "trim|required");
                if ( $this->form_validation->run() == FALSE ){
                        //validation fails
                        redirect('sales/invoice');
                }else{
                    // master entry
                    $invoiceArray = array(
                                        'invoice_no' => $invoiceNumber,
                                        'invoice_date' => $invoiceDate,
                                        'client_id' => $client,
                                        'invoice_total' => $invoiceTotal,
                                        'net_total' => $invoiceTotal,
                                        'created_by' => $this->session->userdata('username')
                                    );
                    $invoiceId= $this->sales_model->create_invoice_id($invoiceArray);

                    for( $i=0; $i < $totalItemRow; $i++ ){
                        $invoiceDetailsArray[$i] = array(
                                        'invoice_id' => $invoiceId,
                                        'product_id' => $products[$i],
                                        'quantity' => $productsQty[$i],
                                        'unit_price' => $productsUnitPrice[$i]
                                    );

                    }

                    $orderResult = $this->sales_model->create_invoice_details($invoiceDetailsArray);

                    if ( $orderResult > 0 ){
                        redirect('sales/unapproveinvoice');
                    }  else {
                       //fsfdsd
                    }
                }
            }
            else {
                $data['invoiceNumber'] = $this->sales_model->getInvoiceNumber();
                $data["productList"] =  $this->product_model->get_product();
                $data["clientList"]  = $this->client_model->get_client();
                $this->load->view('invoice_entry_view',$data);
            }
        }
        else{
            redirect ("login");
        }
    }

  	public function invoiceasdelivery()
  	{
  		if($this->session->has_userdata('username')){
  			$data['invoiceNumber'] = $this->sales_model->getInvoiceNumber();
  			$data["clientList"]  = $this->client_model->get_client();
  			$this->load->view('invoice_delivery_entry_view',$data);
  		}
  	}

  	public function editinvoice($invoiceNo)
  	{
  		if($this->session->has_userdata('username') && $invoiceNo){
  			$data['invoiceDetails'] = $this->sales_model->getInvoice($invoiceNo);
  			$data["productList"] =  $this->product_model->get_product();
  			$data["clientList"]  = $this->client_model->get_client();
  			$this->load->view('invoice_edit_view',$data);
  		}
  		else {
              redirect ("login");
          }
  	}

    public function viewinvoice($invoiceNo)
    {
        if($this->session->has_userdata('username')){
            $data['invoiceDetails'] = $this->sales_model->getInvoice($invoiceNo);
            $this->load->view('invoice_view',$data);
        }  else {
            redirect ("login");
        }
    }

    public function printinvoice($invoiceNo)
    {
        if($this->session->has_userdata('username')){
            $data['invoiceDetails'] = $this->sales_model->getInvoice($invoiceNo);
            $this->load->view('invoice_print_view',$data);
        }  else {
            redirect ("login");
        }
    }

  	public function newdeliverychallan()
  	{
  		if($this->session->has_userdata('username')){
  			if ($this->input->post('btn_save') == "Save Delivery"){
          $challanNumber = $this->input->post("challanNumber");
          $deliveryDate = date('Y-m-d',  strtotime($this->input->post("datemask")));
          $deliveryAddress = $this->input->post("deliveryAddress");
          $client = $this->input->post("client");
          $products = $this->input->post("productid");
          $productsQty = $this->input->post("productQty");
          //$productsUnitPrice = $this->input->post("productsUnitPrice");
          $deliveryPackage = $this->input->post("productPackge");
          $deliverRemarks = $this->input->post("productRemarks");
          // master entry
          $deliveryArray = array(
                              'challan_no' => $challanNumber,
                              'client_id' => $client,
                              'delivery_address' => $deliveryAddress,
                              'delivery_time' => $deliveryDate,
                              'entry_by' => $this->session->userdata('username')
                          );
          $deliveryId= $this->sales_model->create_delivery_id($deliveryArray);

              for ($i=0; $i<count($products); $i++){
                  if((int)$productsQty[$i] > 0){
                      $deliveryDetailsArray = array(
                                                  'delivery_id' => $deliveryId,
                                                  'product_id' => $products[$i],
                                                  'qty'   => $productsQty[$i],
                                                  'package_info' => $deliveryPackage[$i],
                                                  'remarks' => $deliverRemarks[$i]
                                              );

                      $this->sales_model->delivery_details_create($deliveryDetailsArray);
                  }
              }
              redirect("sales/deliverychallanlist");
          } else {
    				$data['challanNo'] = $this->sales_model->getDeliveryNumber();
    				$data["productList"] =  $this->product_model->get_product();
    				$data["clientList"]  = $this->client_model->get_client();
    				$this->load->view('delivery_chalan_entry_new',$data);
  			}
  		} else {
  			redirect ("login");
  		}
  	}

    public function deliverychallan($invoiceId)
    {
        if($this->session->has_userdata('username')){
            if ($this->input->post('btn_save') == "Save Delivery"){
                $challanNumber = $this->input->post("challanNumber");
                $deliveryDate = date('Y-m-d',  strtotime($this->input->post("datemask")));
                $deliveryAddress = $this->input->post("deliveryAddress");
	            $client = $this->input->post("clientId");
                $products = $this->input->post("productid");
                $productsQty = $this->input->post("deliveryQty");
                $productsUnitPrice = $this->input->post("productsUnitPrice");
                $deliveryPackage = $this->input->post("deliveryPackage");
                $deliverRemarks = $this->input->post("deliverRemarks");
                $stockLocation = $this->input->post("stockLocation");
                $vehicleNo = $this->input->post("vehicleNo");
                $driverName = $this->input->post("driverName");
                $gatePassNo = $this->input->post("gatePassNo");

                // master entry
                $deliveryArray = array(
                                    'challan_no' => $challanNumber,
                                    'invoice_id' => $invoiceId,
                                    'client_id' => $client,
                                    'delivery_address' => $deliveryAddress,
                                    'delivery_time' => $deliveryDate,
                                    'location_id' => $stockLocation,
                                    'vehicle_no' => $vehicleNo,
                                    'driver_name' => $driverName,
                                    'gate_pass_no' => $gatePassNo,
                                    'entry_by' => $this->session->userdata('username')
                                );
                $deliveryId= $this->sales_model->create_delivery_id($deliveryArray);

                for ($i=0; $i<count($products); $i++){
                    if((int)$productsQty[$i] > 0){
                        $deliveryDetailsArray = array(
                            'delivery_id' => $deliveryId,
                            'product_id' => $products[$i],
                            'qty'   => $productsQty[$i],
                            'package_info' => $deliveryPackage[$i],
                            'remarks' => $deliverRemarks[$i]
                        );
                        $stockOutArray[$i] = array(
                            'stock_out_type' => "Sale Delivery",
                            'referrence_number' => $challanNumber,
                            'stock_out_date' => $deliveryDate,
                            'product_id'=> $products[$i],
                            'quantity' => $productsQty[$i],
                            'rate'=> $productsUnitPrice[$i],
                            'location_id' => $stockLocation,
                            'entry_by' => $this->session->userdata('username')
                        );
                        $this->sales_model->create_delivery_details($deliveryDetailsArray,$invoiceId);
                    }
                }
                if(isset($stockOutArray))
                    $this->product_model->stock_outall($stockOutArray);

                redirect("sales/deliverychallanlist");
            }
            else {
                $data['challanNo'] = $this->sales_model->getDeliveryNumber();
                $data['invoiceDetails'] = $this->sales_model->getInvoice($invoiceId);
		        $data["locationList"] = $this->location_model->getLocations();
                $this->load->view('delivery_chalan_entry',$data);
            }
        }
        else{
            redirect ("login");
        }
    }

    public function deliverychallanlist()
    {
        if($this->session->has_userdata('username')){
            $currentMenue = array('activeSidebar' => 'reports');
            $this->session->set_userdata($currentMenue);
            $data["deliveryList"] = $this->sales_model->getDeliveryList();
            $this->load->view('delivery_view',$data);
        }
        else{
            redirect ("login");
        }
    }

  	public function getdeliverylist($clientId)
  	{
  		$deliveryList = $this->sales_model->getClientUninvoicedDeliveryList($clientId);
  		$dataRecored = "";
  		if(count($deliveryList)>0){
  			$dataRecored .= "<table class='table table-bordered' >
  							<tr>
  								<td>Delivery Number</td>
  								<td>Delivery Date</td>
  								<td></td>
  							</tr>";
  			foreach($deliveryList as $delivery){
  				$dataRecored .= "<tr>
  									<td>{$delivery["challan_no"]}</td>
  									<td>{$delivery["delivery_time"]}</td>
  									<td><input type='checkbox' name='ckdelivery[]' value='{$delivery["delivery_id"]}' id='deliver_{$delivery["delivery_id"]}'></td>
  								</tr>";
  			}
  			$dataRecored .= "</table>";
  		}
  		echo $dataRecored;
  	}

    public function uninvoiceddeliveries()
    {
        if($this->session->has_userdata('username')){
            $currentMenue = array('activeSidebar' => 'sales');
            $this->session->set_userdata($currentMenue);
            $data["deliveryList"] = $this->sales_model->getUninvoicedDeliveryList();
            $this->load->view('uninvoice_delivery_view',$data);
        }
        else{
            redirect ("login");
        }
    }

    public function viewdeliverychallan($deliveryId)
    {
        if($this->session->has_userdata('username')){
            $data['deliveryDetails'] = $this->sales_model->getDelivery($deliveryId);
            $this->load->view('delivery_challan_view',$data);
        }
        else {
            redirect ("login");
        }
    }



    public function printdeliverychallan($deliveryId)
    {
        if($this->session->has_userdata('username')){
            $data['deliveryDetails'] = $this->sales_model->getDelivery($deliveryId);
            $this->load->view('delivery_challan_print_view',$data);
        }
        else {
            redirect ("login");
        }
    }

    public function getpass($deliveryId)
    {
        if($this->session->has_userdata('username')){
            $data['deliveryDetails'] = $this->sales_model->getDelivery($deliveryId);
            $this->load->view('gate_pass_view',$data);
        }
        else {
            redirect ("login");
        }
    }

    public function printgetpass($deliveryId)
    {
        if($this->session->has_userdata('username')){
            $data['deliveryDetails'] = $this->sales_model->getDelivery($deliveryId);
            $this->load->view('gate_pass_print_view',$data);
        }
        else {
            redirect ("login");
        }
    }

    public function collection()
    {
         if($this->session->has_userdata('username')){
            $data['clientList'] = $this->client_model->get_client();
            $data['bankList'] = $this->bank_model->get_bank();
            $data['collections'] = $this->sales_model->get_collections();
            $data['collectionNo'] = $this->sales_model->getCollectionNumber();
            $this->load->view('customer_collection_view',$data);
        }
        else {
            redirect ("login");
        }
    }

    public function collectionlist()
    {
         if($this->session->has_userdata('username')){
             $currentMenue = array('activeSidebar' => 'reports');
             $this->session->set_userdata($currentMenue);
             $data['collections'] = $this->sales_model->get_collections();
             $this->load->view('collection_list',$data);
        }
        else {
            redirect ("login");
        }
    }

    public function uapprovecollections()
    {
         if($this->session->has_userdata('username')){
            $data['clientList'] = $this->client_model->get_client();
            $data['collections'] = $this->sales_model->get_collections('0');
            $this->load->view('collection_view',$data);
        }
        else {
            redirect ("login");
        }
    }
    public function approvedcollection($collectionNo)
    {
         if($this->session->has_userdata('username')){
            $this->sales_model->approveCollection($collectionNo);
            $collectionDetatils = $this->sales_model->get_collectionDetails($collectionNo);
            if ($collectionDetatils[0]["collection_type"]=='cash') {
                $voucherNumber= $this->accounts_model->get_voucher_number('receipt',$collectionDetatils[0]["collection_date"]);
                // master entry
                $voucherArray = array(
                                  'voucher_number' => $voucherNumber,
                                  'voucher_date' => $collectionDetatils[0]["collection_date"],
                                  'voucher_type' => 'receipt',
                                  'transection_type' => 'Cash',
                                  'party_id' => $collectionDetatils[0]["client_id"],
                                  'description' => 'Collection against collection #'.$collectionDetatils[0]["collection_no"],
                                  'entry_by' => $this->session->userdata('username'),
                                  'entry_date' => date('Y-m-d')
                              );
                $voucherId= $this->accounts_model->create_voucher($voucherArray);
                $voucherDetailsArray = array();
                // transection to reduce receivable [Cr.]
                $voucherDetailsArray= array(
                              'voucher_id' => $voucherId,
                              'accounts_head_id' => 3,
                              'particulers' => 'aginst collection # '.$collectionDetatils[0]["collection_no"],
                              'transection_type' => 'Cr',
                              'amount' => $collectionDetatils[0]["collection_amount"],
                              'entry_by' => $this->session->userdata('username'),
                              'entry_date' => date('Y-m-d')
                    );
                $voucherResult = $this->accounts_model->create_voucher_details($voucherDetailsArray);
                // transection against cash in hand
                $voucherDetailsArray = array(
                                'voucher_id' => $voucherId,
                                'accounts_head_id' => 2,
                                'particulers' => 'aginst collection # '.$collectionDetatils[0]["collection_no"],
                                'transection_type' => 'Dr',
                                'amount' => $collectionDetatils[0]["collection_amount"],
                                'entry_by' => $this->session->userdata('username'),
                                'entry_date' => date('Y-m-d')
                            );
                $voucherResult = $this->accounts_model->create_voucher_details($voucherDetailsArray);
            } else{
                foreach ($collectionDetatils as $collection) {
                    $voucherNumber= $this->accounts_model->get_voucher_number('journal',$collection["collection_date"]);
                    // master entry
                    $voucherArray = array(
                          'voucher_number' => $voucherNumber,
                          'voucher_date' => $collection["collection_date"],
                          'voucher_type' => 'journal',
                          'party_id' => $collection["client_id"],
                          'description' => 'Collection against collection #'.$collection["collection_no"],
                          'entry_by' => $this->session->userdata('username'),
                          'entry_date' => date('Y-m-d')
                    );
                    $voucherId= $this->accounts_model->create_voucher($voucherArray);
                    $voucherDetailsArray = array();
                    // transection to reduce receivable [Cr.]
                    $voucherDetailsArray= array(
                        'voucher_id' => $voucherId,
                        'accounts_head_id' => 3,
                        'particulers' => 'aginst collection # '.$collection["collection_no"],
                        'transection_type' => 'Cr',
                        'amount' => $collection["collection_amount"],
                        'entry_by' => $this->session->userdata('username'),
                        'entry_date' => date('Y-m-d')
                    );
                    $voucherResult = $this->accounts_model->create_voucher_details($voucherDetailsArray);
                    // transection against cheque in hand
                    $voucherDetailsArray = array(
                        'voucher_id' => $voucherId,
                        'accounts_head_id' => 110,
                        'particulers' => 'aginst collection # '.$collection["collection_no"],
                        'transection_type' => 'Dr',
                        'amount' => $collection["collection_amount"],
                        'entry_by' => $this->session->userdata('username'),
                        'entry_date' => date('Y-m-d')
                    );
                    $voucherResult = $this->accounts_model->create_voucher_details($voucherDetailsArray);
                }
                
            }
          redirect("sales/uapprovecollections");
        }  else {
            redirect ("login");
        }
    }

    public function create_collection()
    {
        if($this->session->has_userdata('username')){
            //get the posted values
            $collectionNumber = $this->input->post("collectionNumber");
            $clientId = $this->input->post("client");
            $collectionDate = date('Y-m-d',  strtotime($this->input->post("datemask")));
            $collectionAmount = $this->input->post("collectionAmount");
            $collectionType = $this->input->post("collectionType");
            $remarks = $this->input->post("remarks");
            $accountof = $this->input->post("accountof");
            $checqueDate = $checqueNo = "";
	          $bankId = 0;

            //set validations
            $this->form_validation->set_rules("collectionNumber", "collectionNumber", "trim|required");
            $this->form_validation->set_rules("client", "Client", "trim|required");
            $this->form_validation->set_rules("datemask", "Collection Date", "trim|required");
            $this->form_validation->set_rules("collectionAmount", "Collection Amount", "trim|required");
      			if($collectionType=="cheque") {
      				//$this->form_validation->set_rules("bank", "Bank Name", "trim|required");
      				//$this->form_validation->set_rules("checqueNo", "Cheque No", "trim|required");
      				//$this->form_validation->set_rules("checqueDate", "Cheque Date", "trim|required");
              $totalItemRow = $this->input->post("totalItemRow");
      				$chequeDates = $this->input->post("chequeDates");
      				$chequeNumbers = $this->input->post("chequeNumbers");
              $chequeAmounts = $this->input->post("chequeAmounts");
      				$bankIds = $this->input->post("bankIds");
      			}

            if ($this->form_validation->run() == FALSE){
                //validation fails
                redirect('sales/collection');
                //$this->load->view('login_view');
            } else {
                if($this->input->post('btn_save') == "Save Collection"){
                    if($collectionType=="cheque") {
                      for($i=0; $i<count($bankIds);$i++ ){
                        $collectionArray = array(
                                                'collection_no' => $collectionNumber,
                                                'client_id' => $clientId,
                                                'on_account_of' => $accountof,
                                                'collection_date' => $collectionDate,
                                                'collection_amount' => $chequeAmounts[$i],
                                                'collection_type' => $collectionType,
                                                'remarks' => $remarks,
                                                'bank_id' => $bankIds[$i],
                                                'checque_no' => $chequeNumbers[$i],
                                                'checque_date' => date('Y-m-d', strtotime($chequeDates[$i])),
                                                'entry_by' => $this->session->userdata('username')
                                            );
                        $collectionResult = $this->sales_model->create_collection($collectionArray);
                      }

                    } else {
                      $collectionArray = array(
                                              'collection_no' => $collectionNumber,
                                              'client_id' => $clientId,
                                              'on_account_of' => $accountof,
                                              'collection_date' => $collectionDate,
                                              'collection_amount' => $collectionAmount,
                                              'collection_type' => $collectionType,
                                              'remarks' => $remarks,
                                              'bank_id' => $bankId,
                                              'checque_no' => $checqueNo,
                                              'checque_date' => $checqueDate,
                                              'entry_by' => $this->session->userdata('username')
                                          );
                      $collectionResult = $this->sales_model->create_collection($collectionArray);
                    }
                    if ($collectionResult > 0){
                       redirect('sales/collection');
                    }
                    else{
                        $this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">Invalid username and password!</div>');
                        redirect('sales/collection');
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

  	public function moneyreceipt($collectionNo)
  	{
  		$data["collectionDetatils"] = $collectionDetatils=$this->sales_model->get_collectionDetails($collectionNo);
      //print_r($collectionDetatils);
  		$this->load->view('money_receipt_view',$data);
  	}

  	public function printmoneyreceipt($collectionNo)
  	{
  		$data["collectionDetatils"] = $this->sales_model->get_collectionDetails($collectionNo);
  		$this->load->view('money_receipt_print_view',$data);
  	}

    public function partyledger()
    {
        if($this->session->has_userdata('username')){
            $currentMenue = array('activeSidebar' => 'reports');
            $this->session->set_userdata($currentMenue);
            $data = array();
            $data["fromDate"] = $data["toDate"] = $data["clientId"] = '';
            $data['clientList'] = $this->client_model->get_client();
            if ($this->input->post('btn_save') == "Show Report"){
                $clientId = $data["clientId"]=$this->input->post("client");
                $data["fromDate"] = $this->input->post("fromDate");
                $data["toDate"] = $this->input->post("toDate");
                $fromDate = date('Y-m-d',  strtotime($data["fromDate"]));
                $toDate =  date('Y-m-d',  strtotime($data["toDate"]));
                //set validations
                $this->form_validation->set_rules("client", "Client", "required");
                $this->form_validation->set_rules("fromDate", "Date From", "trim|required");
                $this->form_validation->set_rules("toDate", "Date To", "trim|required");

                if ($this->form_validation->run() == TRUE)
                {
                    $openingInvoiceTotal = $this->sales_model->clientTotalBill($clientId,$fromDate);
                    $openingCollection = $this->sales_model->clientTotalCollection($clientId,$fromDate);
                    $openingCollected = $this->sales_model->clientTotalCollected($clientId,$fromDate);
                    $openingBounce = 0;//$this->sales_model->clientTotalBounce($clientId,$fromDate);
                    $openingSalesReturn = $this->sales_model->clientTotalSalesReturn($clientId,$fromDate);
                    $openingAdjustment = $this->sales_model->clientTotalReceivableAdustment($clientId,$fromDate);
                    $accountOpening = $this->sales_model->accountopeningabalnce($clientId,$fromDate);
                    $openingUnderInvoice = 0;//$this->sales_model->clientTotalUnderInvoice($clientId,$fromDate);
                    $openingPurchase = 0;//$this->purchase_model->partyTotalBill($clientId,$fromDate);
                    $openingPay = 0;//$this->purchase_model->partyTotalPay($clientId,$fromDate);
                    $data['clientDetails'] = $clitentInfo = $this->client_model->get_client($clientId);
                    //$data["openingBalance"] = ($openingInvoiceTotal+$openingPay+$openingBounce) - ($openingPurchase+$openingUnderInvoice+$openingCollection+$openingSalesReturn+$openingCollected+$openingAdjustment) + $clitentInfo[0]["entry_balance"];
                    $data["openingBalance"] = $accountOpening + $clitentInfo[0]["entry_balance"];
                    $data["transectionData"] = $products = $this->sales_model->transections($clientId,$fromDate,$toDate);
                    

                }

            }
            $this->load->view('party_transection_report',$data);
        }
        else
            redirect ("login");
    }

    public function printpartyledger($clientId=0,$fromDate='',$toDate='')
    {
        if($this->session->has_userdata('username')){

            $data["toDate"] = $toDate;
            $data["fromDate"] = $fromDate;
            $openingInvoiceTotal = $this->sales_model->clientTotalBill($clientId,$fromDate);
            $openingCollection = $this->sales_model->clientTotalCollection($clientId,$fromDate);
            $openingCollected = $this->sales_model->clientTotalCollected($clientId,$fromDate);
            $openingSalesReturn = $this->sales_model->clientTotalSalesReturn($clientId,$fromDate);
            $openingAdjustment = $this->sales_model->clientTotalReceivableAdustment($clientId,$fromDate);
            $openingUnderInvoice = $this->sales_model->clientTotalUnderInvoice($clientId,$fromDate);
            $openingPurchase = $this->purchase_model->partyTotalBill($clientId,$fromDate);
            $openingPay = $this->purchase_model->partyTotalPay($clientId,$fromDate);
            $accountOpening = $this->sales_model->accountopeningabalnce($clientId,$fromDate);
            $openingUnderInvoice = 0;//$this->sales_model->clientTotalUnderInvoice($clientId,$fromDate);
            $openingPurchase = 0;//$this->purchase_model->partyTotalBill($clientId,$fromDate);
            $openingPay = 0;//$this->purchase_model->partyTotalPay($clientId,$fromDate);
            $data['clientDetails'] = $clitentInfo = $this->client_model->get_client($clientId);
            //$data["openingBalance"] = ($openingInvoiceTotal+$openingPay+$openingBounce) - ($openingPurchase+$openingUnderInvoice+$openingCollection+$openingSalesReturn+$openingCollected+$openingAdjustment) + $clitentInfo[0]["entry_balance"];
            $data["openingBalance"] = $accountOpening + $clitentInfo[0]["entry_balance"];
            $data["transectionData"] = $products = $this->sales_model->transections($clientId,$fromDate,$toDate);

  //           $config=array(
  //     'protocol'=>'smtp',
  //     'smtp_host'=>'ssl://smtp.googlemail.com',
  //     'smtp_port'=>465,
  //     'smtp_user'=>'enalamin@gmail.com',
  //     'smtp_pass'=>'adil_2013'
  //   );
  //
  //   $this->load->library("email",$config);
  //
  //   $this->email->set_newline("\r\n");
  //   $this->email->from("enalamin@gmail.com","Your Name");
  //   $this->email->to("alamincse@hotmail.com");
  //   $this->email->subject("Test message!");
  //   $this->email->message("Its working!");
  //
  //   // $path=$_SERVER["DOCUMENT_ROOT"];
  //   // $file=$path."/ci/attachments/info.txt";
  //
  // //  $this->email->attach($file);
  //
  //   if($this->email->send())
  //   {
  //       echo "Mail send successfully!";
  //   }
  //
  //   else
  //   {
  //       show_error($this->email->print_debugger());
  //   }


          //  $this->load->library('Pdf');
            //$html= $this->load->view('party_transection_pdf',$data,true);
            //$pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
            //$this->pdf->generatePdf($html,'D');
            $this->load->view('party_transection_report_print',$data);
        }
        else {
            redirect ("login");
        }
    }

    public function summerypartyledger()
    {
        if($this->session->has_userdata('username')){
            $currentMenue = array('activeSidebar' => 'reports');
            $this->session->set_userdata($currentMenue);
            $data = array();
            if ($this->input->post('btn_save') == "Show Report"){
                $data['balanceType'] = $balanceType=$this->input->post("balanceType");
                $data["transectionData"] = $products = $this->sales_model->partysummery($balanceType);
            }
            $this->load->view('party_summery_report',$data);
        }
        else
            redirect ("login");
    }

    public function printsummerypartyledger($balanceType='')
    {
        if($this->session->has_userdata('username')){
            $data['balanceType'] = $balanceType;
            $data["transectionData"] = $products = $this->sales_model->partysummery($balanceType);
            $this->load->view('party_summery_report_print',$data);
        }
        else
            redirect ("login");
    }

    public function partyreceivable()
    {
        if($this->session->has_userdata('username')){
            $data = array();
            $data['balanceType'] = $this->input->post("balanceType");
            $data["transectionData"] = $products = $this->sales_model->partysummery('Debtor');
            $this->load->view('party_receivable',$data);
        }
        else
            redirect ("login");
    }

    public function adjustreceivable($type)
    {
        //print_r($_POST);
        if($this->session->has_userdata('username') && $type){
            $data = array();
            if($type=='salesdiscount'){
                $adjustmentType = 'Sales Discount';
                $partyId = $this->input->post("partyId");
                $adjustDate = date('Y-m-d',  strtotime($this->input->post("adjustDate")));
                $adjustAmount = $this->input->post("discountAmount");
                $drHeadId= 24;
            }
            if($type=='sourcetax'){
                $adjustmentType = 'Source Tax';
                $partyId = $this->input->post("sourcePartyId");
                $adjustDate = date('Y-m-d',  strtotime($this->input->post("sourceAdjustDate")));
                $adjustAmount = $this->input->post("sourceTaxAmount");
                $drHeadId= 86;
            }

            $dataArray = array(
                'adjustment_type' => $adjustmentType,
                'client_id' => $partyId,
                'adjustment_date' =>  $adjustDate,
                'adjustment_amount' => $adjustAmount,
                'entry_by' => $this->session->userdata("username"),
                'entry_date' => date('Y-m-d h:i:s')
            );
            $result = $this->sales_model->adjustReceivable($dataArray);
            if($result){
                $voucherNumber = $this->accounts_model->get_voucher_number('journal',$adjustDate);

                // master entry
                $voucherArray = array(
                                    'voucher_number' => $voucherNumber,
                                    'voucher_date' => $adjustDate,
                                    'voucher_type' => 'journal',
                                    'party_id' => $partyId,
                                    'description' => 'Adjust receivabl against '.$adjustmentType,
                                    'entry_by' => $this->session->userdata('username'),
                                    'entry_date' => date('Y-m-d')
                                );
                $voucherId= $this->accounts_model->create_voucher($voucherArray);
                $voucherDetailsArray = array();
                // transectio against sales [Cr.]
                $voucherDetailsArray= array(
                                'voucher_id' => $voucherId,
                                'accounts_head_id' => 3,
                                'particulers' => 'Adjust receivabl against '.$adjustmentType,
                                'transection_type' => 'Cr',
                                'amount' => $adjustAmount,
                                'entry_by' => $this->session->userdata('username'),
                                'entry_date' => date('Y-m-d')
                            );
                $voucherResult = $this->accounts_model->create_voucher_details($voucherDetailsArray);
                // transection against receivable
                  $voucherDetailsArray = array(
                                  'voucher_id' => $voucherId,
                                  'accounts_head_id' => $drHeadId,
                                  'particulers' => 'Adjust receivabl against '.$adjustmentType,
                                  'transection_type' => 'Dr',
                                  'amount' => $adjustAmount,
                                  'entry_by' => $this->session->userdata('username'),
                                  'entry_date' => date('Y-m-d')
                              );
                  $voucherResult = $this->accounts_model->create_voucher_details($voucherDetailsArray);
                  echo 1;
            }

        }
        else
            redirect ("login");
    }

    public function productwisesales()
    {
        if($this->session->has_userdata('username')){
            $currentMenue = array('activeSidebar' => 'reports');
            $this->session->set_userdata($currentMenue);
            $data = array();
            $data['clientList'] = $this->client_model->get_client();
            $data["productList"] =  $this->product_model->get_product();
            if ($this->input->post('btn_save') == "Show"){
                $clientId = $this->input->post("client");
                $productId = $this->input->post("product");
                $fromDate = $data["fromDate"] = date('Y-m-d',  strtotime($this->input->post("fromDate")));
                $toDate = $data["toDate"] = date('Y-m-d',  strtotime($this->input->post("toDate")));
		            $data["transectionData"] = $products = $this->sales_model->productwisesales($fromDate, $toDate, $productId, $clientId);
            }
            $this->load->view('product_sales_report',$data);
        }
        else
            redirect ("login");
    }

	  public function datewisesales()
    {
        if($this->session->has_userdata('username')){
            $currentMenue = array('activeSidebar' => 'reports');
            $this->session->set_userdata($currentMenue);
            $data = array();
            $data["fromDate"]=$data["toDate"]=$data["selectedClient"]='';
            $data['clientList'] = $this->client_model->get_client();
            if ($this->input->post('btn_save') == "Show"){
                $clientId = $data["selectedClient"]=(int)$this->input->post("client");
                if($this->input->post("toDate")==''||$this->input->post("fromDate")==''){
                    $data["fromDate"]=$data["toDate"]=$fromDate=$toDate=NULL;
                }else{
                  $data["fromDate"] = $this->input->post("fromDate");
		              $fromDate = date('Y-m-d',  strtotime($data["fromDate"]));
                  $data["toDate"] = $this->input->post("toDate");
			            $toDate = date('Y-m-d',  strtotime($data["toDate"]));
                }

				$data["transectionData"] = $products = $this->sales_model->getsales($clientId, $fromDate, $toDate);


            }
            $this->load->view('date_sales_report',$data);
        }
        else
            redirect ("login");
    }

	  public function datewisecollection()
    {
        if($this->session->has_userdata('username')){
            $currentMenue = array('activeSidebar' => 'reports');
            $this->session->set_userdata($currentMenue);
            $data = array();
            $data['clientList'] = $this->client_model->get_client();
            if ($this->input->post('btn_save') == "Show"){
                $collectionType = $this->input->post("collectionType");
                $clientId = (int)$this->input->post("client");
                if($this->input->post("toDate")==''||$this->input->post("fromDate")==''){
                    $data["fromDate"]=$data["toDate"]=$fromDate=$toDate=NULL;
                }else{
					$fromDate = $data["fromDate"] = date('Y-m-d',  strtotime($this->input->post("fromDate")));
					$toDate = $data["toDate"] = date('Y-m-d',  strtotime($this->input->post("toDate")));
                }

				$data["transectionData"] = $products = $this->sales_model->collectionlist($clientId, $fromDate, $toDate,$collectionType);


            }
            $this->load->view('date_collection_report',$data);
        }
        else
            redirect ("login");
    }

	  public function salesreturn()
    {
        if($this->session->has_userdata('username')){
            if ($this->input->post('btn_save') == "Save"){
                $salesReturnNumber = $this->input->post("salesReturnNumber");
                $salesReturnDate = date('Y-m-d',  strtotime($this->input->post("datemask")));
                $client = $this->input->post("client");
                $totalItemRow = $this->input->post("totalItemRow");
                $products = $this->input->post("productid");
                $productsRate = $this->input->post("productRate");
                $productsQty = $this->input->post("productQty");
                $productsPackage = $this->input->post("productPackge");
                $productsRemarks = $this->input->post("productRemarks");
		            $stockLocation = $this->input->post("stockLocation");
                //set validations
                $this->form_validation->set_rules("salesReturnNumber", "Sales Return Number", "trim|required");
		            $this->form_validation->set_rules("stockLocation", "Location", "trim|required");
                $this->form_validation->set_rules("datemask", "Sales Return Date", "trim|required");
                $this->form_validation->set_rules("client", "Client Name ", "trim|required");

                $this->form_validation->set_rules("totalItemRow", "total product", "trim|required");
                if ($this->form_validation->run() == FALSE){
        					redirect('sales/salesreturn');
        				}else {
	                 for($i=0;$i<$totalItemRow;$i++){
                      $returnArray[$i] = array(
                                    'sales_return_number' => $salesReturnNumber,
                                    'sales_return_date' => $salesReturnDate,
                                    'client_id' => $client,
                                    'product_id' => $products[$i],
                                    'rate' => $productsRate[$i],
                                    'quantity' => $productsQty[$i],
                                    'package' => $productsPackage[$i],
                                    'remarks' => $productsRemarks[$i],
			                              'location_id' => $stockLocation,
                                    'entry_by' => $this->session->userdata('username')
                                );
                    }
                    $loanResult = $this->sales_model->createSalesReturn($returnArray);
                    if($loanResult > 0) {
                       redirect('sales/unapprovesalesreturnList');
                    }
                }
            }else {
                $data['salesReturnNumber'] = $this->sales_model->getSalesReturnNumber();
                $data["clientList"] = $this->client_model->get_client();
                $data["productList"] =  $this->product_model->get_product();
		            $data["locationList"] = $this->location_model->getLocations();
                $this->load->view('sales_return_entry_view',$data);
            }
        }
        else
          redirect ("login");
    }

	  public function unapprovesalesreturnlist()
    {
        if($this->session->has_userdata('username')){
          $data["loanList"] = $this->sales_model->getsalesreturnlist('0');
          $data["listTitel"] = "Unapproved Sale Return List";
          $this->load->view('sales_return_view',$data);
        }
        else
          redirect ("login");
    }

	  function updatesalesreturn($salesReturnNumber, $statusValue)
    {
        if($this->session->has_userdata('username')){
            $stustUpdateData = array(
                'status'=>$statusValue,
                'approved_by' => $this->session->userdata('username')
            );
            $updateRow = $this->sales_model->updatesalesreturnstatus($salesReturnNumber,$stustUpdateData);

            // create  journal for sales return
            $voucherNumber = $this->accounts_model->get_voucher_number('journal',$salesReturnDetails[0]["sales_return_date"]);
            $salesReturnDetails = $this->sales_model->getsalesreturn($salesReturnNumber);

            // master entry
            $voucherArray = array(
                                'voucher_number' => $voucherNumber,
                                'voucher_date' => $salesReturnDetails[0]["sales_return_date"],
                                'voucher_type' => 'journal',
                                'party_id' => $salesReturnDetails[0]["client_id"],
                                'description' => 'create receivabl against Sales Return #'.$salesReturnNumber,
                                'entry_by' => $this->session->userdata('username'),
                                'entry_date' => date('Y-m-d')
                            );
            $voucherId= $this->accounts_model->create_voucher($voucherArray);
            $voucherDetailsArray = array();
            // transectio against sales [Cr.]
            $voucherDetailsArray= array(
                            'voucher_id' => $voucherId,
                            'accounts_head_id' => '23',
                            'particulers' => 'aginst the sales return # '.$salesReturnNumber,
                            'transection_type' => 'Dr',
                            'amount' => $salesReturnDetails[0]["totalamount"],
                            'entry_by' => $this->session->userdata('username'),
                            'entry_date' => date('Y-m-d')
                        );
            $voucherResult = $this->accounts_model->create_voucher_details($voucherDetailsArray);
            // transection against receivable
              $voucherDetailsArray = array(
                              'voucher_id' => $voucherId,
                              'accounts_head_id' => 3,
                              'particulers' => 'aginst the sales return # '.$salesReturnNumber,
                              'transection_type' => 'Cr',
                              'amount' => $salesReturnDetails[0]["totalamount"],
                              'entry_by' => $this->session->userdata('username'),
                              'entry_date' => date('Y-m-d')
                          );
              $voucherResult = $this->accounts_model->create_voucher_details($voucherDetailsArray);


            redirect('sales/unapprovesalesreturnList');

        }  else {
            redirect ("login");
        }
    }
}
