<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lcmanagement extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model('bank_model');
        $this->load->model('client_model');
        $this->load->model('sales_model');
        $this->load->model('purchase_model');
        $this->load->model('location_model');
        $this->load->model('accounts_model');
        $this->load->model('chartofaccounts_model');
        $this->load->model('lc_model');
        $this->load->model('loan_model');
        $this->load->model('product_model');
        $this->load->model('employee_model');
        $currentMenue = array('activeSidebar' => 'lcmanagement');
        $this->session->set_userdata($currentMenue);
    }

    public function index()
    {
        if($this->session->has_userdata('username')){
            $this->load->view('lcmanagement_view');
        }
        else{
            redirect ("login");
        }
    }

    public function pientry()
    {
        if($this->session->has_userdata('username')){
            $data["clientList"] = $this->client_model->get_client();
            $data["productList"] =  $this->product_model->get_product();
            $this->load->view('pi_entry_view',$data);
        }
        else{
            redirect ("login");
        }
    }

    public function pilist()
    {
        if($this->session->has_userdata('username')){
            $data["lcList"] = $this->lc_model->get_proforma();
            $this->load->view('pi_list_view',$data);
        }
        else{
            redirect ("login");
        }
    }

    public function lclist()
    {
        if($this->session->has_userdata('username')){
            $data["lcList"] = $this->lc_model->get_lc();
            $this->load->view('lc_list_view',$data);
        }
        else{
            redirect ("login");
        }
    }

    public function closelclist()
    {
        if($this->session->has_userdata('username')){
            $data["lcList"] = $this->lc_model->get_lc_batch();
            $this->load->view('close_lc_list_view',$data);
        }
        else{
            redirect ("login");
        }
    }

    public function lcdetails($lcId,$batchName=NULL)
    {
        if($this->session->has_userdata('username')){

            $data['bankList'] = $this->bank_model->get_bank();
            $data["productList"] =  $this->product_model->get_product();
            $data["locationList"] = $this->location_model->getLocations();
            $data['lcDetails'] = $lcDetails = $this->lc_model->get_proforma($lcId);
            $data['lcHistory'] = $this->lc_model->get_lc_history($lcId);
            $data['lcCosting'] = $this->lc_model->get_lc_costing($lcId);
            
            $lcReceiveBatch= !empty($batchName)?$batchName:$this->lc_model->get_lc_current_batchno($lcId);
            $data['lcReceiveProductDetails'] = $this->lc_model->getgGoodsReceive($lcId,$lcReceiveBatch);
            $data['lcCostingSummery'] = $this->lc_model->get_lc_costing_summery($lcId,$lcReceiveBatch);
            $data['lcBatchDetails'] = $batchInfo = $this->lc_model->get_lc_batchinof($lcId,$lcReceiveBatch);
            if($lcDetails[0]['status']=='LC Close'){
                //echo $lcReceiveBatch;
                $data['lcProductDetails'] = $this->lc_model->getgGoodsReceive($lcId,$lcReceiveBatch);
                //print_r($data['lcProductDetails']);
                $this->load->view('lc_costing_details',$data);
            } else{
                if($batchInfo && $batchInfo[0]['status']==1 && !empty($batchName)){
                    $data['lcProductDetails'] = $this->lc_model->getgGoodsReceive($lcId,$lcReceiveBatch);
                    //print_r($data['lcProductDetails']);
                    $this->load->view('lc_costing_details',$data);
                }else{
                    $data['lcProductDetails'] = $this->lc_model->getgGoodsReceive($lcId,'');
                    $this->load->view('lc_details',$data);
                }
            } 
              
        }
        else{
            redirect ("login");
        }
    }

    public function pidetails($lcId)
    {
        if($this->session->has_userdata('username')){

            $data['lcDetails'] = $lcDetails = $this->lc_model->get_proforma($lcId);
            $data['lcProductDetails'] = $this->lc_model->getgGoodsReceive($lcId);
            $this->load->view('pi_details',$data);
              
        }
        else{
            redirect ("login");
        }
    }

    public function pidetailsedit($lcId)
    {
        if($this->session->has_userdata('username')){
            $data['lcDetails'] = $lcDetails = $this->lc_model->get_proforma($lcId);
            $data["productList"] =  $this->product_model->get_product();
            $data['lcProductDetails'] = $this->lc_model->getgGoodsReceive($lcId);
            $response = $this->load->view('pi_details_edit',$data,true);
            echo $response;              
        }
        else{
            redirect ("login");
        }
    }

    public function updatepi($lcId)
    {
        if($this->session->has_userdata('username') && $lcId){
            $totalItemRow = $this->input->post("totalItemRow");
            $products = $this->input->post("productid");
            $productsQty = $this->input->post("product_qty");
            $productsUnitPrice = $this->input->post("product_rate");
            $productsPackage = $this->input->post("product_package");
            $invoiceTotal = $this->input->post("grandTotal");
            for( $i=0; $i < $totalItemRow; $i++ ){
                $lcDetailsArray[$i] = array(
                                'lc_id' => $lcId,
                                'product_id' => $products[$i],
                                'lc_quantity' => $productsQty[$i],
                                'unit_dollar_price' => $productsUnitPrice[$i],
                                'package' => $productsPackage[$i]
                            );
            }
            if(is_array($lcDetailsArray)){
                $this->lc_model->delete_lc_goods($lcId); 
                $this->lc_model->create_lc_goods($lcDetailsArray); 
                $this->lc_model->update_lc($lcId, array('invoice_amount'=>$invoiceTotal));
                echo "1";
            }else{
                echo "0";
            }
            
        }
        else{
            echo "2";
        }
    }

    public function printlccosting($lcId,$batchName=NULL)
    {
        if($this->session->has_userdata('username')){

            $data['bankList'] = $this->bank_model->get_bank();
            $data["productList"] =  $this->product_model->get_product();
            $data["locationList"] = $this->location_model->getLocations();
            $data['lcDetails'] = $lcDetails = $this->lc_model->get_proforma($lcId);
            $data['lcHistory'] = $this->lc_model->get_lc_history($lcId);
            $data['lcCosting'] = $this->lc_model->get_lc_costing($lcId);
            $data['lcProductDetails'] = $this->lc_model->getgGoodsReceive($lcId);

            $lcReceiveBatch= !empty($batchName)?$batchName:$this->lc_model->get_lc_current_batchno($lcId);
            $data['lcReceiveProductDetails'] = $this->lc_model->getgGoodsReceive($lcId,$lcReceiveBatch);
            $data['lcCostingSummery'] = $this->lc_model->get_lc_costing_summery($lcId,$lcReceiveBatch);
            $data['lcBatchDetails'] = $batchInfo = $this->lc_model->get_lc_batchinof($lcId,$lcReceiveBatch);
            $this->load->view('lc_costing_details_print',$data);
             
              
        }
        else{
            redirect ("login");
        }
    }

    public function senttobank($lcId)
    {
        if($this->session->has_userdata('username')){
            $data['bankList'] = $this->bank_model->get_bank();
            $data['proformaDetails'] = $this->lc_model->get_proforma($lcId);
            $this->load->view('proforma_sent_bank',$data);
        }
        else{
            redirect ("login");
        }
    }

    public function lcopen($lcId)
    {
        if($this->session->has_userdata('username')){
            $data['bankList'] = $this->bank_model->get_bank();
            $data['proformaDetails'] = $this->lc_model->get_proforma($lcId);
            $this->load->view('lc_open',$data);
        }
        else{
            redirect ("login");
        }
    }

    public function lcsenttobank($lcId)
    {
        if($this->session->has_userdata('username') && $lcId){
            //get the posted values
            $bankId = $this->input->post("bank");
            $accountNo = $this->input->post("accountNo");
            $sentDate = date('Y-m-d',  strtotime($this->input->post("datemask")));
            //set validations
            $this->form_validation->set_rules("bank", "Bank", "trim|required");
            $this->form_validation->set_rules("accountNo", "Account Number", "trim|required");
            $this->form_validation->set_rules("datemask", "Deposit Date", "trim|required");

            if ($this->form_validation->run() == FALSE){
                //validation fails
                redirect('lcmanagement/pilist');
            }
            else{
                if ($this->input->post('btn_save') == "Save"){
                    $dataArray = array(
                        'lc_id' => $lcId,
                        'status' => 'Sent to Bank',
                        'description' => 'proform invoice sent to bank['.$accountNo.']',
                        'event_date' => $sentDate,
                        'entry_by' => $this->session->userdata('username'),
                        'entry_date' => date('Y-m-d h:i:s')
                    );

                    $result = $this->lc_model->create_lc_history($dataArray);

                    if ($result > 0) //active user record is present
                    {
                        $this->lc_model->update_lc($lcId, array('status'=>'Sent to Bank','bank_id'=>$bankId,'account_no'=>$accountNo));
                        redirect('lcmanagement/pilist');

                    }
                    else
                    {
                        $this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">Invalid username and password!</div>');
                        redirect('login/index');
                    }
                }
                else
                {
                    redirect('login/index');
                }
            }
        }
        else{
            redirect ("login");
        }
    }

    public function openlc($lcId)
    {
        if($this->session->has_userdata('username') && $lcId){
            //get the posted values
            $bankId = $this->input->post("bank");
            $lcNo = $this->input->post("lcNo");
            //$bankChargeDollar = $this->input->post('bankChargeDollar');
            //$bankChargeDollarRate = $this->input->post('bankChargeDollarRate');
            $bankChargeAmount = $this->input->post("bankChargeAmount");

            //$lcMarginDollar = $this->input->post('lcMarginDollar');
            //$lcMarginDollarRate = $this->input->post('lcMarginDollarRate');
            $lcMarginAmount = $this->input->post("lcMarginAmount");

            //$premiumDollar = $this->input->post('premiumDollar');
            //$premiumDollarRate = $this->input->post('premiumDollarRate');
            $premiumAmount = $this->input->post("premiumAmount");


            $openDate = date('Y-m-d',  strtotime($this->input->post("datemask")));
            //set validations
            $this->form_validation->set_rules("lcNo", "LC Number ", "trim|required");
            $this->form_validation->set_rules("datemask", "Deposit Date", "trim|required");

            if ($this->form_validation->run() == FALSE){
                //validation fails
                redirect('lcmanagement/pilist');
            }
            else{
                $lcDetails = $this->lc_model->get_lc($lcId);
                if ($this->input->post('btn_save') == "Save"){
                    $dataArray = array(
                        'lc_id' => $lcId,
                        'status' => 'LC Open',
                        'description' => 'lc has been open with respective charge',
                        'event_date' => $openDate,
                        'entry_by' => $this->session->userdata('username'),
                        'entry_date' => date('Y-m-d h:i:s')
                    );

                    $result = $this->lc_model->create_lc_history($dataArray);

                    if ($result > 0) //active user record is present
                    {
                        $this->lc_model->update_lc($lcId, array('status'=>'LC Open','lc_no'=>$lcNo));
                        // lc costing
                        if($bankChargeAmount && $bankChargeAmount>0){
                          $costArray = array(
                              'lc_id' => $lcId,
                              'costing_head' => 'Bank Charges',
                              'amount' => $bankChargeAmount,
                              'cost_date' => $openDate,
                              'distribution_base' => 'amount',
                              'entry_by' => $this->session->userdata('username'),
                              'entry_date' => date('Y-m-d h:i:s')
                          );
                          $result = $this->lc_model->create_lc_cost($costArray);
                        }

                        if($lcMarginAmount && $lcMarginAmount>0){
                          $costArray = array(
                              'lc_id' => $lcId,
                              'costing_head' => 'LC Margin',
                              'amount' => $lcMarginAmount,
                              'cost_date' => $openDate,
                              'distribution_base' => 'amount',
                              'entry_by' => $this->session->userdata('username'),
                              'entry_date' => date('Y-m-d h:i:s')
                          );
                          $result = $this->lc_model->create_lc_cost($costArray);
                        }

                        if($premiumAmount && $premiumAmount>0){
                          $costArray = array(
                              'lc_id' => $lcId,
                              'costing_head' => 'Insurance Premium',
                              'amount' => $premiumAmount,
                              'cost_date' => $openDate,
                              'distribution_base' => 'amount',
                              'entry_by' => $this->session->userdata('username'),
                              'entry_date' => date('Y-m-d h:i:s')
                          );
                          $result = $this->lc_model->create_lc_cost($costArray);
                        }

                        $voucherNumber = $this->accounts_model->get_voucher_number('journal',$openDate);
                        // create voucher
                        // master entry
                        $voucherArray = array(
                                'voucher_number' => $voucherNumber,
                                'voucher_date' => $openDate,
                                'voucher_type' => 'journal',
                                'party_id' => '',
                                'transection_type' => 'Cheque',
                                'bank_id' => $lcDetails[0]['bank_id'],
                                'account_no' => $lcDetails[0]['account_no'],
                                'description' => 'LC Opeing with different charges for LC #'.$lcNo.', Open Date:'.$openDate.' and LC Amount $'.$lcDetails[0]['invoice_amount'],
                                'entry_by' => $this->session->userdata('username'),
                                'entry_date' => date('Y-m-d')
                            );
                        $voucherId= $this->accounts_model->create_voucher($voucherArray);
                        $voucherDetalsArray = array();
                        // transection against LC Margin
                        $voucherDetailsArray = array(
                              'voucher_id' => $voucherId,
                              'accounts_head_id' => 101,
                              'particulers' => 'LC Marging for LC #'.$lcNo,
                              'transection_type' => 'Dr',
                              'amount' => $lcMarginAmount,
                              'entry_by' => $this->session->userdata('username'),
                              'entry_date' => date('Y-m-d')
                          );
                        $voucherResult = $this->accounts_model->create_voucher_details($voucherDetailsArray);
                        // transectio against Bankd Charge [Dr.]
                        $voucherDetailsArray= array(
                            'voucher_id' => $voucherId,
                            'accounts_head_id' => 66,
                            'particulers' =>'Bank Charge for LC #'.$lcNo,
                            'transection_type' => 'Dr',
                            'amount' => $bankChargeAmount,
                            'entry_by' => $this->session->userdata('username'),
                            'entry_date' => date('Y-m-d')
                        );
                        $voucherResult = $this->accounts_model->create_voucher_details($voucherDetailsArray);
                        
                        // transection against Bank Account
                        $voucherDetailsArray = array(
                              'voucher_id' => $voucherId,
                              'accounts_head_id' => 1,
                              'particulers' => 'charge for Lc Marging and bank charges for LC #'.$lcNo,
                              'transection_type' => 'Cr',
                              'amount' => ($lcMarginAmount+$bankChargeAmount),
                              'entry_by' => $this->session->userdata('username'),
                              'entry_date' => date('Y-m-d')
                          );
                        $voucherResult = $this->accounts_model->create_voucher_details($voucherDetailsArray);
                        
                        redirect('lcmanagement/pilist');

                    }
                    else
                    {
                        $this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">Invalid username and password!</div>');
                        redirect('login/index');
                    }
                }
                else
                {
                    redirect('login/index');
                }
            }
        }
        else{
            redirect ("login");
        }
    }


    public function createpi()
    {
        if($this->session->has_userdata('username')){
            //get the posted values
            $supplier = $this->input->post("supplier");
            $proformaDate = date('Y-m-d',  strtotime($this->input->post("datemask")));
            $piNo = $this->input->post("pino");
            $bankInfo = $this->input->post("bankInfo");
            $remarks = $this->input->post("remarks");
            $totalItemRow = $this->input->post("totalItemRow");
            $products = $this->input->post("productid");
            $productsQty = $this->input->post("productQty");
            $productsUnitPrice = $this->input->post("productPrice");
            $productsPackage = $this->input->post("productPackge");
            $invoiceTotal = $this->input->post("invoiceTotal");
            //set validations
            $this->form_validation->set_rules("supplier", "Select supplier", "trim|required");
            $this->form_validation->set_rules("pino", "Proforma Invoice", "trim|required");
            $this->form_validation->set_rules("invoiceTotal", "Invoice Amount", "trim|required");

            if ($this->form_validation->run() == FALSE) {
                //validation fails
                redirect('bank/index');
            } else {
                if($this->input->post('btn_save') == "Save"){
                    //check if username and password is correct
                    $lcArray = array(
    					'supplier_id' => $supplier,
    					'pi_no' => $piNo,
                        'pi_date' => $proformaDate,
    					'invoice_amount' => $invoiceTotal,
                        'bank_info' => $bankInfo,
    					'remarks' => $remarks,
                        'entry_by' => $this->session->userdata("username"),
                        'entry_date' => date('Y-m-d')
					);
                  $lcId = $this->lc_model->create_lc($lcArray);
                  if ($lcId > 0){
                    $lcDetailsArray = NULL;
                    for( $i=0; $i < $totalItemRow; $i++ ){
                        $lcDetailsArray[$i] = array(
                                        'lc_id' => $lcId,
                                        'product_id' => $products[$i],
                                        'lc_quantity' => $productsQty[$i],
                                        'unit_dollar_price' => $productsUnitPrice[$i],
                                        'package' => $productsPackage[$i]
                                    );
                    }
                    if(is_array($lcDetailsArray)){
                      $this->lc_model->create_lc_goods($lcDetailsArray); 
                    }
                    
                    $dataArray = array(
                        'lc_id' => $lcId,
                        'status' => 'Not Ready',
                        'description' => 'Just got the proforma Invoice',
                        'event_date' => $proformaDate,
                        'entry_by' => $this->session->userdata('username'),
                        'entry_date' => date('Y-m-d h:i:s')
                    );

                    $result = $this->lc_model->create_lc_history($dataArray);

                     redirect('lcmanagement');
                  } else {
                      $this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">Invalid username and password!</div>');
                      redirect('lcmanagement');
                  }
                } else {
                    redirect('login/index');
                }
            }
        } else
            redirect ("login");
    }

    public function documentrelease($lcId)
    {
      //print_r($_POST);
      if($this->session->has_userdata('username') && $lcId){
          $lcNo = $this->input->post("lcNumber");
          $dollarRate = $this->input->post('dollarRate');
          $bankChargeAmount = $this->input->post("bankChargeAmount");
          $lcValue = $this->input->post("lcValue");
          $docsValue = $this->input->post("docsValue");


          //$ltrDollar = $this->input->post('ltrDollar');
          //$ltrDollarRate = $this->input->post('ltrDollarRate');
          $ltrAmount = $this->input->post("ltrAmount");
          $ltrAccount = $this->input->post("ltrAccount");

          //$additonalDollar = $this->input->post('additonalDollar');
          //$additonalDollarRate = $this->input->post('additonalDollarRate');
          $additonalAmount = $this->input->post("additonalAmount");
          $cashRetairmentAmount = $this->input->post("cashRetairmentAmount");


          $releaseDate = date('Y-m-d',  strtotime($this->input->post("releaseDate")));
          $ltrMaturityDate = $this->input->post("ltrMaturityDate")?date('Y-m-d',  strtotime($this->input->post("ltrMaturityDate"))):NULL;
          //set validations
          $this->form_validation->set_rules("lcNumber", "LC Number ", "trim|required");
          $this->form_validation->set_rules("releaseDate", "Deposit Date", "trim|required");
          //$this->form_validation->set_rules("ltrAccount", "LTR Number", "trim|required");

          if ($this->form_validation->run() == FALSE){
              //validation fails
              redirect('lcmanagement/pilist');
          }
          else{
            $lcDetails = $this->lc_model->get_lc($lcId);
            $lcCosting=$this->lc_model->get_lc_costing($lcId);
            $lcReceiveBatch = $this->lc_model->get_lc_batchno($lcId);
            $lcMarginAmount = 0;
            foreach ($lcCosting as $costing) {
                if($costing['costing_head']=='LC Margin'){
                    $lcMarginAmount = $costing['amount'];
                }
            }
            // insert into lc batch
            $lcBatch = array(
                'lc_id' => $lcId ,
                'batch_name' => $lcReceiveBatch,
                'doc_release_value' => $docsValue,
                'dollar_rate' => $dollarRate
            );
            $batchResult = $this->lc_model->create_lc_recive_batch($lcBatch);

            // create lc history
            $dataArray = array(
                'lc_id' => $lcId,
                'status' => 'Document Release',
                'description' => 'LC Documents have been released with respective charge',
                'event_date' => $releaseDate,
                'entry_by' => $this->session->userdata('username'),
                'entry_date' => date('Y-m-d h:i:s')
            );
            $result = $this->lc_model->create_lc_history($dataArray);

            if ($result > 0){
                // lc costing
                if($bankChargeAmount && $bankChargeAmount>0){
                    $costArray = array(
                        'lc_id' => $lcId,
                        'costing_head' => 'Bank Charges',
                        'amount' => $bankChargeAmount,
                        'cost_date' => $releaseDate,
                        'distribution_base' => 'amount',
                        'receive_lc_batch' => $lcReceiveBatch,
                        'entry_by' => $this->session->userdata('username'),
                        'entry_date' => date('Y-m-d h:i:s')
                    );
                    $result = $this->lc_model->create_lc_cost($costArray);
                }

                if($ltrAmount && $ltrAmount>0){
                    $costArray = array(
                        'lc_id' => $lcId,
                        'costing_head' => 'LTR',
                        'amount' => $ltrAmount,
                        'cost_date' => $releaseDate,
                        'distribution_base' => 'amount',
                        'receive_lc_batch' => $lcReceiveBatch,
                        'entry_by' => $this->session->userdata('username'),
                        'entry_date' => date('Y-m-d h:i:s')
                    );
                    $result = $this->lc_model->create_lc_cost($costArray);
                    $bankAccountArray = array(
                                'bank_id' => $lcDetails[0]['bank_id'],
                                'account_no' => $ltrAccount,
                                'account_type' => 'Short Term Loan'
                            );
                    $accountId = $this->bank_model->create_bank_account($bankAccountArray);
                    // update lc with ltr no
                    $this->lc_model->update_lc_receive_batch($lcId,$lcReceiveBatch, array('ltr_no' => $ltrAccount,'ltr_maturity_date' => $ltrMaturityDate));
                }

                if($additonalAmount && $additonalAmount>0){
                    $costArray = array(
                        'lc_id' => $lcId,
                        'costing_head' => 'Additional Charges',
                        'amount' => $additonalAmount,
                        'cost_date' => $releaseDate,
                        'distribution_base' => 'amount',
                        'receive_lc_batch' => $lcReceiveBatch,
                        'entry_by' => $this->session->userdata('username'),
                        'entry_date' => date('Y-m-d h:i:s')
                    );
                    $result = $this->lc_model->create_lc_cost($costArray);
                }

                if($cashRetairmentAmount && $cashRetairmentAmount>0){
                    $costArray = array(
                        'lc_id' => $lcId,
                        'costing_head' => 'Cash Retairment Amount',
                        'amount' => $cashRetairmentAmount,
                        'cost_date' => $releaseDate,
                        'distribution_base' => 'amount',
                        'receive_lc_batch' => $lcReceiveBatch,
                        'entry_by' => $this->session->userdata('username'),
                        'entry_date' => date('Y-m-d h:i:s')
                    );
                    $result = $this->lc_model->create_lc_cost($costArray);
                }
                // update lc status and dollar rate
                $this->lc_model->update_lc($lcId, array('status'=>'Document Release','dollar_rate' => $dollarRate));
                

                $voucherNumber = $this->accounts_model->get_voucher_number('journal',$releaseDate);
                // create voucher
                // master entry
                $voucherArray = array(
                    'voucher_number' => $voucherNumber,
                    'voucher_date' => $releaseDate,
                    'voucher_type' => 'journal',
                    'party_id' => '',
                    'transection_type' => 'Cheque',
                    'bank_id' => $lcDetails[0]['bank_id'],
                    'account_no' => $lcDetails[0]['account_no'],
                    'description' => 'LC Document release with different charges for LC #'.$lcNo.', on Date:'.$releaseDate.' and document value $'.$docsValue,
                    'entry_by' => $this->session->userdata('username'),
                    'entry_date' => date('Y-m-d')
                );
                
                $voucherId= $this->accounts_model->create_voucher($voucherArray);
                $voucherDetalsArray = array();
                // transectio against Bankd Charge [Dr.]
                $voucherDetailsArray= array(
                    'voucher_id' => $voucherId,
                    'accounts_head_id' => 66,
                    'particulers' =>'Bank Charge with additional charges for LC #'.$lcNo,
                    'transection_type' => 'Dr',
                    'amount' => ($bankChargeAmount+$additonalAmount),
                    'entry_by' => $this->session->userdata('username'),
                    'entry_date' => date('Y-m-d')
                );
                $voucherResult = $this->accounts_model->create_voucher_details($voucherDetailsArray);
                        
                // transection against Bank Account
                $voucherDetailsArray = array(
                      'voucher_id' => $voucherId,
                      'accounts_head_id' => 1,
                      'particulers' => 'Bank Charge with additional charges for LC #'.$lcNo,
                      'transection_type' => 'Cr',
                      'amount' => ($bankChargeAmount+$additonalAmount),
                      'entry_by' => $this->session->userdata('username'),
                      'entry_date' => date('Y-m-d')
                );
                $voucherResult = $this->accounts_model->create_voucher_details($voucherDetailsArray);

                // voucher  create for ltr
                if($ltrAmount>0){
                    $ltrVoucherNumber = $this->accounts_model->get_voucher_number('journal',$releaseDate);
                    $voucherArray = array(
                            'voucher_number' => $ltrVoucherNumber,
                            'voucher_date' => $releaseDate,
                            'voucher_type' => 'journal',
                            'party_id' => '',
                            'bank_id' => $lcDetails[0]['bank_id'],
                            'account_no' => $ltrAccount,
                            'description' => 'LTR charges for LC #'.$lcNo.' on date '.$releaseDate.' and document value $'.$docsValue,
                            'entry_by' => $this->session->userdata('username'),
                            'entry_date' => date('Y-m-d')
                        );
                    $voucherId= $this->accounts_model->create_voucher($voucherArray);
                    $voucherDetalsArray = array();
                    // transectio against purchase and import [Dr.]
                    $voucherDetailsArray= array(
                        'voucher_id' => $voucherId,
                        'accounts_head_id' => 88,
                        'particulers' =>'LTR  for LC #'.$lcNo,
                        'transection_type' => 'Dr',
                        'amount' => $ltrAmount,
                        'entry_by' => $this->session->userdata('username'),
                        'entry_date' => date('Y-m-d')
                    );
                    $voucherResult = $this->accounts_model->create_voucher_details($voucherDetailsArray);
                    
                    // transection against ltr account
                    $voucherDetailsArray = array(
                          'voucher_id' => $voucherId,
                          'accounts_head_id' => 91,
                          'particulers' => 'LTR create for LC #'.$lcNo,
                          'transection_type' => 'Cr',
                          'amount' => $ltrAmount,
                          'entry_by' => $this->session->userdata('username'),
                          'entry_date' => date('Y-m-d')
                    );
                    $voucherResult = $this->accounts_model->create_voucher_details($voucherDetailsArray);
                }

                // voucher  create for Cash retairment 
                if($cashRetairmentAmount>0){
                    $ltrVoucherNumber = $this->accounts_model->get_voucher_number('journal',$releaseDate);
                    $voucherArray = array(
                            'voucher_number' => $ltrVoucherNumber,
                            'voucher_date' => $releaseDate,
                            'voucher_type' => 'journal',
                            'party_id' => '',
                            'bank_id' => $lcDetails[0]['bank_id'],
                            'account_no' => $lcDetails[0]['account_no'],
                            'description' => 'Cash Retairment for LC #'.$lcNo.' on Date:'.$releaseDate.' with document value $'.$docsValue,
                            'entry_by' => $this->session->userdata('username'),
                            'entry_date' => date('Y-m-d')
                        );
                    $voucherId= $this->accounts_model->create_voucher($voucherArray);
                    $voucherDetalsArray = array();
                    // transectio against purchase and import [Dr.]
                    $voucherDetailsArray= array(
                        'voucher_id' => $voucherId,
                        'accounts_head_id' => 88,
                        'particulers' =>'Cash Retairment for LC #'.$lcNo,
                        'transection_type' => 'Dr',
                        'amount' => $cashRetairmentAmount,
                        'entry_by' => $this->session->userdata('username'),
                        'entry_date' => date('Y-m-d')
                    );
                    $voucherResult = $this->accounts_model->create_voucher_details($voucherDetailsArray);
                    
                    // transection against bank account
                    $voucherDetailsArray = array(
                          'voucher_id' => $voucherId,
                          'accounts_head_id' => 1,
                          'particulers' => 'Cash Retairment for LC #'.$lcNo,
                          'transection_type' => 'Cr',
                          'amount' => $cashRetairmentAmount,
                          'entry_by' => $this->session->userdata('username'),
                          'entry_date' => date('Y-m-d')
                    );
                    $voucherResult = $this->accounts_model->create_voucher_details($voucherDetailsArray);
                }

                if($lcReceiveBatch=='Batch-1'){
                    // voucher  create for LC margin & Purchase/import
                    $lcMarginVoucherNumber = $this->accounts_model->get_voucher_number('journal',$releaseDate);
                    $voucherArray = array(
                            'voucher_number' => $lcMarginVoucherNumber,
                            'voucher_date' => $releaseDate,
                            'voucher_type' => 'journal',
                            'party_id' => '',
                            'description' => 'Transfer LC Marging to purchase and import for LC #'.$lcNo.' and LC Amount $'.$lcDetails[0]['invoice_amount'],
                            'entry_by' => $this->session->userdata('username'),
                            'entry_date' => date('Y-m-d')
                        );
                    $voucherId= $this->accounts_model->create_voucher($voucherArray);
                    $voucherDetalsArray = array();
                    // transectio against purchase and import [Dr.]
                    $voucherDetailsArray= array(
                        'voucher_id' => $voucherId,
                        'accounts_head_id' => 88,
                        'particulers' =>'LTR for LC #'.$lcNo,
                        'transection_type' => 'Dr',
                        'amount' => $lcMarginAmount,
                        'entry_by' => $this->session->userdata('username'),
                        'entry_date' => date('Y-m-d')
                    );
                    $voucherResult = $this->accounts_model->create_voucher_details($voucherDetailsArray);
                    
                    // transection against LC Margin
                    $voucherDetailsArray = array(
                          'voucher_id' => $voucherId,
                          'accounts_head_id' => 101,
                          'particulers' => 'Transfer LC against puarchas and import for LC #'.$lcNo,
                          'transection_type' => 'Cr',
                          'amount' => $lcMarginAmount,
                          'entry_by' => $this->session->userdata('username'),
                          'entry_date' => date('Y-m-d')
                      );
                    $voucherResult = $this->accounts_model->create_voucher_details($voucherDetailsArray);
                }
                echo "1";

              }else{
                  echo '0';
              }
          }
      } else{
          echo '2';
      }
    }

    public function lcbankamenment($lcId)
    {
      //print_r($_POST);
        if($this->session->has_userdata('username') && $lcId){
            $lcNo = $this->input->post("amenmentlcNumber");
            $bankChargeAmount = $this->input->post("bankAmenmentAmount");
            $marginAmount = $this->input->post("marginAmenmentAmount");
            $amenmentDate = date('Y-m-d',  strtotime($this->input->post("amenmentDate")));
            //set validations
            $this->form_validation->set_rules("amenmentlcNumber", "LC Number ", "trim|required");
            $this->form_validation->set_rules("amenmentDate", "Deposit Date", "trim|required");
          
            if ($this->form_validation->run() == FALSE){
                //validation fails
                redirect('lcmanagement/pilist');
            }
            else{
                $lcDetails = $this->lc_model->get_lc($lcId);
                  
                $dataArray = array(
                    'lc_id' => $lcId,
                    'status' => 'LC Amenment at bank',
                    'description' => 'LC Amenment at Bank with the Bank Charge',
                    'event_date' => $amenmentDate,
                    'entry_by' => $this->session->userdata('username'),
                    'entry_date' => date('Y-m-d h:i:s')
                );
                $result = $this->lc_model->create_lc_history($dataArray);

                
                if ($result > 0) //active user record is present
                {
                    if($bankChargeAmount && $bankChargeAmount>0){
                        $costArray = array(
                            'lc_id' => $lcId,
                            'costing_head' => 'Bank Charges',
                            'amount' => $bankChargeAmount,
                            'cost_date' => $amenmentDate,
                            'distribution_base' => 'amount',
                            'entry_by' => $this->session->userdata('username'),
                            'entry_date' => date('Y-m-d h:i:s')
                        );
                        $result = $this->lc_model->create_lc_cost($costArray);
                    }

                    if($marginAmount && $marginAmount>0){
                        $costArray = array(
                            'lc_id' => $lcId,
                            'costing_head' => 'LC Margin',
                            'amount' => $marginAmount,
                            'cost_date' => $amenmentDate,
                            'distribution_base' => 'amount',
                            'entry_by' => $this->session->userdata('username'),
                            'entry_date' => date('Y-m-d h:i:s')
                        );
                        $result = $this->lc_model->create_lc_cost($costArray);
                    }


                    $voucherNumber = $this->accounts_model->get_voucher_number('journal',$amenmentDate);
                    // create voucher
                    // master entry
                    $voucherArray = array(
                        'voucher_number' => $voucherNumber,
                        'voucher_date' => $amenmentDate,
                        'voucher_type' => 'journal',
                        'party_id' => '',
                        'transection_type' => 'Cheque',
                        'bank_id' => $lcDetails[0]['bank_id'],
                        'account_no' => $lcDetails[0]['account_no'],
                        'description' => 'LC Amenment for LC #'.$lcNo.', Open Date:'.$openDate.' and LC Amount $'.$lcDetails[0]['invoice_amount'],
                        'entry_by' => $this->session->userdata('username'),
                        'entry_date' => date('Y-m-d')
                    );
                    $voucherId= $this->accounts_model->create_voucher($voucherArray);
                    $voucherDetalsArray = array();
                    // transectio against Bankd Charge [Dr.]
                    $voucherDetailsArray= array(
                        'voucher_id' => $voucherId,
                        'accounts_head_id' => 66,
                        'particulers' =>'Bank Charge Amenment for LC #'.$lcNo,
                        'transection_type' => 'Dr',
                        'amount' => ($bankChargeAmount),
                        'entry_by' => $this->session->userdata('username'),
                        'entry_date' => date('Y-m-d')
                    );
                    $voucherResult = $this->accounts_model->create_voucher_details($voucherDetailsArray);
                    // transection against LC Margin
                    $voucherDetailsArray = array(
                          'voucher_id' => $voucherId,
                          'accounts_head_id' => 101,
                          'particulers' => 'LC Margin Amenment for LC #'.$lcNo,
                          'transection_type' => 'Dr',
                          'amount' => $marginAmount,
                          'entry_by' => $this->session->userdata('username'),
                          'entry_date' => date('Y-m-d')
                      );
                    $voucherResult = $this->accounts_model->create_voucher_details($voucherDetailsArray);       
                    // transection against Bank Account
                    $voucherDetailsArray = array(
                        'voucher_id' => $voucherId,
                        'accounts_head_id' => 1,
                        'particulers' => 'LC Amenment for LC #'.$lcNo,
                        'transection_type' => 'Cr',
                        'amount' => ($bankChargeAmount+$marginAmount),
                        'entry_by' => $this->session->userdata('username'),
                        'entry_date' => date('Y-m-d')
                    );
                    $voucherResult = $this->accounts_model->create_voucher_details($voucherDetailsArray);
                    echo "1";
                } else{
                    echo '0';
                }
            }
        } else{
            echo '2';
        }
    }

    public function candfagent($lcId)
    {
      //print_r($_POST);
        if($this->session->has_userdata('username') && $lcId){
            $lcNo = $this->input->post("lcNo");
            $candfAmount = $this->input->post("candfAmount");
            $candfDate = date('Y-m-d',  strtotime($this->input->post("candfDate")));
            //set validations
            $this->form_validation->set_rules("lcNo", "LC Number ", "trim|required");
            $this->form_validation->set_rules("candfDate", "C & F Date", "trim|required");

            if ($this->form_validation->run() == FALSE){
                //validation fails
                echo "4";
            }
            else{
                $lcReceiveBatch= $this->lc_model->get_lc_current_batchno($lcId);
                $dataArray = array(
                    'lc_id' => $lcId,
                    'status' => 'C&F Agent',
                    'description' => 'C&F Agent expenses',
                    'event_date' => $candfDate,
                    'receive_lc_batch' => $lcReceiveBatch,
                    'entry_by' => $this->session->userdata('username'),
                    'entry_date' => date('Y-m-d h:i:s')
                );

                $result = $this->lc_model->create_lc_history($dataArray);

                if ($result > 0) //active user record is present
                {
                    $this->lc_model->update_lc($lcId, array('status'=>'C&F Agent'));
                    // lc costing
                    if($candfAmount && $candfAmount>0){
                        $costArray = array(
                            'lc_id' => $lcId,
                            'costing_head' => 'C&F Agent expenses',
                            'amount' => $candfAmount,
                            'cost_date' => $candfDate,
                            'distribution_base' => 'amount',
                            'receive_lc_batch' => $lcReceiveBatch,
                            'entry_by' => $this->session->userdata('username'),
                            'entry_date' => date('Y-m-d h:i:s')
                        );
                        $result = $this->lc_model->create_lc_cost($costArray);
                    }
                    echo "1";
                }else{
                    echo '0';
                }
            }
        } else{
            echo '2';
        }
    }

    public function allexpenses($lcId)
    {
      //print_r($_POST);
        if($this->session->has_userdata('username') && $lcId){
            $lcNo = $this->input->post("expLcNo");
            $headName = $this->input->post("headName");
            $headAmount = $this->input->post("headAmount");
            $distributionBase = $this->input->post("distributionBase");
            $expensesDate = date('Y-m-d',  strtotime($this->input->post("expensesDate")));
            //set validations
            $this->form_validation->set_rules("expLcNo", "LC Number ", "trim|required");
            $this->form_validation->set_rules("expensesDate", "C & F Date", "trim|required");
            $this->form_validation->set_rules("headName", "C & F Date", "trim|required");
            $this->form_validation->set_rules("headAmount", "C & F Date", "trim|required");

            if ($this->form_validation->run() == FALSE){
                //validation fails
                echo "4";
            }
            else{
                $lcReceiveBatch= $this->lc_model->get_lc_current_batchno($lcId);
                $dataArray = array(
                    'lc_id' => $lcId,
                    'status' => $headName,
                    'description' => $headName,
                    'receive_lc_batch' => $lcReceiveBatch,
                    'event_date' => $expensesDate,
                    'entry_by' => $this->session->userdata('username'),
                    'entry_date' => date('Y-m-d h:i:s')
                );
                $result = $this->lc_model->create_lc_history($dataArray);

                if ($result > 0){
                    // lc costing
                    if($headAmount && $headAmount>0){
                        $costArray = array(
                            'lc_id' => $lcId,
                            'costing_head' => $headName,
                            'amount' => $headAmount,
                            'receive_lc_batch' => $lcReceiveBatch,
                            'cost_date' => $expensesDate,
                            'distribution_base' => $distributionBase,
                            'entry_by' => $this->session->userdata('username'),
                            'entry_date' => date('Y-m-d h:i:s')
                        );
                        $result = $this->lc_model->create_lc_cost($costArray);
                    }
                    echo "1";
                }else{
                    echo '0';
                }
            }
        } else{
            echo '2';
        }
    }

    public function lcrateupdate($lcId)
    {
        if($this->session->has_userdata('username') && $lcId){        
            $products = $this->input->post("costProductId");
            $productRate = $this->input->post("productUnitPrice");
            $productQty = $this->input->post("costProductQty");
            $lcClosedType = $this->input->post("lcClosedType");
            $updateProductRateArray = array();
            if (is_array($products)){
                $lcReceiveBatch= $this->lc_model->get_lc_current_batchno($lcId);
                for($i=0;$i<count($products);$i++){
                    $newRate = $this->ratecalculation($products[$i],$productQty[$i],$productRate[$i]);
                    $this->lc_model->lc_stock_receive($lcId,$products[$i],$productRate[$i],$lcReceiveBatch);
                    $updateProductRateArray[$i] = array('product_id'=> $products[$i],'product_rate' => $newRate);
                }
                $this->product_model->update_product_rate($updateProductRateArray);
                $dataArray = array(
                    'lc_id' => $lcId,
                    'status' => 'LC Cost finalized for '.$lcReceiveBatch,
                    'description' => 'All the costing have been finalized.',
                    'receive_lc_batch' => $lcReceiveBatch,
                    'event_date' => date('Y-m-d'),
                    'entry_by' => $this->session->userdata('username'),
                    'entry_date' => date('Y-m-d h:i:s')
                );
                $result = $this->lc_model->create_lc_history($dataArray);
                $resultupdatebatch = $this->lc_model->update_lc_receive_batch($lcId,$lcReceiveBatch,array('status'=>1,'closed_date'=>date('Y-m-d')));
                if($lcClosedType=='full')
                    $this->lc_model->update_lc($lcId, array('status'=>'LC Close'));
                else
                    $this->lc_model->update_lc($lcId, array('status'=>'LC Partially Received'));
                echo "1";              
            }
        }else{
            echo '2';
        }
    }

    function ratecalculation($productId,$currentQty,$currentRate)
    {
        $previousRate = $this->product_model->getrate($productId);
        $totalReceive = $this->product_model->totalReceive($productId);
        $totalOut = $this->product_model->totalOut($productId);
        $loanBalance = $this->loan_model->loanbalance($productId,date('Y-m-d'));
        $balance = $totalReceive - $totalOut+$loanBalance[0]['balance']; 
        $newRate = $currentRate; 
        if($previousRate>0){
            if($balance>0){
                $newRate = (($currentQty*$currentRate)+ ($balance*$previousRate))/($currentQty+$balance);
            }
        }
        return $newRate;
    }

    public function savebillofentry($lcId)
    {

        if($this->session->has_userdata('username') && $lcId){
            $billLcNo = $this->input->post("billLcNo");
            $billofEntryDate = date('Y-m-d',  strtotime($this->input->post("billofEntryDate")));
            $products = $this->input->post("billofEntryProductid");
            $billofEntryAmount = $this->input->post("billofEntryAmount");
            $totalBillofEntry = 0;
            //set validations
          
            $this->form_validation->set_rules("billLcNo", "LC Number", "trim|required");
            $this->form_validation->set_rules("billofEntryDate", "Receip Date", "trim|required");
          
            if ($this->form_validation->run() == FALSE){
                //validation fails
                redirect('lcmanagement/lcdetails/'.$lcId);
            } else{
                $lcReceiveBatch= $this->lc_model->get_lc_current_batchno($lcId);
                for($i=0;$i<count($products);$i++){
                    $goodsArray[$i] = array(
                        'lc_id' => $lcId,
                        'receive_lc_batch' => $lcReceiveBatch,
                        'bill_of_entry_date' => $billofEntryDate,
                        'product_id' => $products[$i],
                        'amount' => $billofEntryAmount[$i],
                        'entry_by' => $this->session->userdata('username'),
                        'entry_date' => date('Y-m-d h:i:s')
                    );
                    $totalBillofEntry += $billofEntryAmount[$i];
                }
                $orderResult = $this->lc_model->create_lc_bill_of_entry($goodsArray);
                if ($orderResult > 0) {
                    $costArray = array(
                        'lc_id' => $lcId,
                        'costing_head' => 'Bill of Enrty',
                        'amount' => $totalBillofEntry,
                        'receive_lc_batch' => $lcReceiveBatch,
                        'cost_date' => $billofEntryDate,
                        'distribution_base' => '',
                        'entry_by' => $this->session->userdata('username'),
                        'entry_date' => date('Y-m-d h:i:s')
                    );
                    $result = $this->lc_model->create_lc_cost($costArray);
                    $dataArray = array(
                        'lc_id' => $lcId,
                        'status' => 'Bill of Entry',
                        'description' => 'Bill of Enrty',
                        'receive_lc_batch' => $lcReceiveBatch,
                        'event_date' => $billofEntryDate,                  
                        'entry_by' => $this->session->userdata('username'),
                        'entry_date' => date('Y-m-d h:i:s')
                    );
                    $this->lc_model->create_lc_history($dataArray);
                    echo "1";
                }
            }
        }else{
            echo '2';
        }
    }

    public function saveUnderInvoice($lcId)
    {

        if($this->session->has_userdata('username') && $lcId){
            $lcNumber = $this->input->post("underLcNo");
            $underInvoiceDate = date('Y-m-d',  strtotime($this->input->post("underInvoiceDate")));
            $underInvoiceNumber = $this->input->post("underInvoiceNumber");
            $underInvoiceDollarRate = $this->input->post("underInvoiceDollarRate");
            $products = $this->input->post("invoiceProductid");
            $invoiceRate = $this->input->post("invoiceRate");
            $invoiceAmountBdt = $this->input->post("invoiceAmountBdt");
            $invoiceAmountDollar = $this->input->post("invoiceAmountDollar");
            //set validations
            $this->form_validation->set_rules("underInvoiceNumber", "Receive Location", "trim|required");
            $this->form_validation->set_rules("underLcNo", "LC Number", "trim|required");
            $this->form_validation->set_rules("underInvoiceDate", "Receip Date", "trim|required");
            $this->form_validation->set_rules("underInvoiceDollarRate", "total product", "trim|required");
            if ($this->form_validation->run() == FALSE){
                //validation fails
                redirect('lcmanagement/lcdetails/'.$lcId);
            } else{
                $totalInvoiceAmount = $totalDollarAmount = 0;
                $lcReceiveBatch = $this->lc_model->get_lc_current_batchno($lcId);
                for($i=0;$i<count($products);$i++){
                    $goodsArray[$i] = array(
                        'invoice_no' => $underInvoiceNumber,
                        'invoice_date' => $underInvoiceDate,
                        'lc_id' => $lcId,
                        'receive_lc_batch' => $lcReceiveBatch,
                        'product_id' => $products[$i],
                        'dollar_unit_price' => $invoiceRate[$i],
                        'dollar_conversion_rate' => $underInvoiceDollarRate,
                        'invoice_amount' => $invoiceAmountBdt[$i],
                        'dollar_amount' => $invoiceAmountDollar[$i],
                        'entry_by' => $this->session->userdata('username'),
                        'entry_date' => date('Y-m-d h:i:s')
                    );
                    $totalInvoiceAmount += $invoiceAmountBdt[$i];
                    $totalDollarAmount += $invoiceAmountDollar[$i];
                }
                $orderResult = $this->lc_model->create_lc_under_invoice($goodsArray);
                if ($orderResult > 0) {
                    $costArray = array(
                        'lc_id' => $lcId,
                        'costing_head' => 'Under Invoice',
                        'dollar_amount' => $totalDollarAmount,
                        'dollar_rate' => $underInvoiceDollarRate,
                        'amount' => $totalInvoiceAmount,
                        'receive_lc_batch' => $lcReceiveBatch,
                        'cost_date' => $underInvoiceDate,
                        'distribution_base' => '',
                        'entry_by' => $this->session->userdata('username'),
                        'entry_date' => date('Y-m-d h:i:s')
                    );
                    $result = $this->lc_model->create_lc_cost($costArray);
                    $dataArray = array(
                        'lc_id' => $lcId,
                        'status' => 'Under Invoice',
                        'description' => 'Inder Invoice',
                        'receive_lc_batch' => $lcReceiveBatch,
                        'event_date' => $underInvoiceDate,                  
                        'entry_by' => $this->session->userdata('username'),
                        'entry_date' => date('Y-m-d h:i:s')
                    );
                    $this->lc_model->create_lc_history($dataArray);
                    $lcDetails = $this->lc_model->get_lc($lcId);
                    // voucher  create for LC margin & Purchase/import
                    $voucherNumber = $this->accounts_model->get_voucher_number('journal',$underInvoiceDate);
                    $voucherArray = array(
                        'voucher_number' => $voucherNumber,
                        'voucher_date' => $underInvoiceDate,
                        'voucher_type' => 'journal',
                        'party_id' => $lcDetails[0]['supplier_id'],
                        'description' => 'Balance amount under PI #'.$lcDetails[0]['pi_no'],
                        'entry_by' => $this->session->userdata('username'),
                        'entry_date' => date('Y-m-d')
                    );
                    $voucherId= $this->accounts_model->create_voucher($voucherArray);
                    $voucherDetalsArray = array();
                    // transectio against purchase and import [Dr.]
                    $voucherDetailsArray= array(
                        'voucher_id' => $voucherId,
                        'accounts_head_id' => 88,
                        'particulers' =>'Balance amount under PI #'.$lcDetails[0]['pi_no'],
                        'transection_type' => 'Dr',
                        'amount' => $totalInvoiceAmount,
                        'entry_by' => $this->session->userdata('username'),
                        'entry_date' => date('Y-m-d')
                    );
                    $voucherResult = $this->accounts_model->create_voucher_details($voucherDetailsArray);
                        
                    // transection against accounts payable
                    $voucherDetailsArray = array(
                        'voucher_id' => $voucherId,
                        'accounts_head_id' => 12,
                        'particulers' => 'Balance amount under PI #'.$lcDetails[0]['pi_no'],
                        'transection_type' => 'Cr',
                        'amount' => $totalInvoiceAmount,
                        'entry_by' => $this->session->userdata('username'),
                        'entry_date' => date('Y-m-d')
                    );
                    $voucherResult = $this->accounts_model->create_voucher_details($voucherDetailsArray);
                    echo "1";
                }
            }
        }else{
            echo '2';
        }
    }
}
