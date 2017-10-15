<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Accounts extends CI_Controller {    
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model('bank_model');
        $this->load->model('client_model');
        $this->load->model('sales_model');
        $this->load->model('purchase_model');
        $this->load->model('accounts_model');
        $this->load->model('chartofaccounts_model');
        $this->load->model('car_model');
        $this->load->model('employee_model');
        $this->load->model('product_model');
        $this->load->library('notes');
        $this->load->library('products');
        $currentMenue = array('activeSidebar' => 'accounts');
        $this->session->set_userdata($currentMenue);
    }

    public function index()
    {
        if($this->session->has_userdata('username')){
            $this->load->view('accounts_view');
        }
        else
            redirect ("login");
    }
    
    public function voucher($voucherType)
    {

        if($this->session->has_userdata('username')){
            $data["bankList"] = $products = $this->bank_model->get_bank();
            $data["clientList"]  = $this->client_model->get_client();
            $data["carList"]  = $this->car_model->get_car();
            $data["employeeList"] = $this->employee_model->get_company_employee(118);
            $data["chartOfAccountsList"] = $userList = $this->chartofaccounts_model->get_chartofaccounts();
            if($voucherType === "receipt"){
              	$data['voucherNumber'] = $this->accounts_model->get_voucher_number('receipt');
              	$this->load->view('receipt_voucher_entry_view',$data);
            } else if($voucherType === "payment"){
              	$data['voucherNumber'] = $this->accounts_model->get_voucher_number('payment');
              	$this->load->view('payment_voucher_entry_view',$data);
            } else if($voucherType === "journal"){
              	$data['voucherNumber'] = $this->accounts_model->get_voucher_number('journal');
              	$this->load->view('journal_voucher_entry_view',$data);
            } else if($voucherType === "transfer"){
              	$data['voucherNumber'] = $this->accounts_model->get_voucher_number('transfer');
              	$this->load->view('transfer_voucher_entry_view',$data);
            }
        } else
            redirect ("login");
    }

    public function voucher_save($voucherType)
    {
      if ($this->session->has_userdata('username')) {
        	if ($this->input->post('btn_save') == "Save Voucher"){
	            $voucherNumber = $this->input->post("voucherNumber");
	            $voucherDate = date('Y-m-d',  strtotime($this->input->post("datemask")));
	            $partyId = $this->input->post("party");
	            $voucherDescription = $this->input->post("voucherDescription");
	            $totalItemRow = $this->input->post("totalItemRow");
	            $accountHeadId = $this->input->post("accountHeadId");
	            $particulars = $this->input->post("transectionDescription");
	            $car=$this->input->post("carId");
	            $employee=$this->input->post("employeeId");

	            if($voucherType=="journal"){
    	        	  $transectionDrAmount = $this->input->post("transectionDrAmount");
              		$transectionCrAmount = $this->input->post("transectionCrAmount");
              		$chequeDate = $this->input->post("checqueDate")?date('Y-m-d',  strtotime($this->input->post("checqueDate"))):NULL;
              		$chequeNo = $this->input->post("checqueNo");
              		$accountNo = $this->input->post("accountNo");
              		$bankId = $this->input->post("bank")?$this->input->post("bank"):0;
              		$transectionType = $bankId>0?"Cheque":NULL;
	            } else if($voucherType=="transfer"){
                $voucherAmount = $this->input->post("amount");
                $transferFrom = $this->input->post("transferFrom");
                $transectionType='Cash';
		          	if($transferFrom=='Cheque'){
		                $bankId=$this->input->post("fromBank");
		                $accountNo = $this->input->post("fromAccountNo");
		                $chequeNo = $this->input->post("fromChequeNo");
		                $chequeDate = $this->input->post("fromChequeDate")?date('Y-m-d',  strtotime($this->input->post("fromChequeDate"))):NULL;
		                $transectionType='Cheque';
            		}
            		$transferTo = $this->input->post("transferTo");
            		if($transferTo=='Cheque'){
		                $toBankId=$this->input->post("toBank");
		                $toAccountNo = $this->input->post("toAccountNo");
            		}
          	} else {
                $transectionAmount = $this->input->post("transectionAmount");
              	$transectionType = $this->input->post("transectionType");
              	$voucherTotal = $this->input->post("voucherTotal");
              	$accountsTransectionType = $voucherType=='receipt'?'Cr':'Dr';

              	if($transectionType=='Cheque'){
  		            // $this->form_validation->set_rules("bank", "Bank Name", "trim|required");
          				// $this->form_validation->set_rules("checqueNo", "Cheque No", "trim|required");
          				// $this->form_validation->set_rules("checqueDate", "Cheque Date", "trim|required");
        	   			$chequeDate = $this->input->post("checqueDate")?date('Y-m-d',  strtotime($this->input->post("checqueDate"))):NULL;
                  $chequeNo = $this->input->post("checqueNo");
                  $accountNo = $this->input->post("accountNo");
        		  		$bankId = $this->input->post("bank");
            		}
          	}

	            //set validations
	            $this->form_validation->set_rules("voucherNumber", "Voucher Number", "trim|required");
	            $this->form_validation->set_rules("datemask", "Voucher Date", "trim|required");
            	if($voucherType!='transfer'){
              		$this->form_validation->set_rules("party", "Receive from", "trim|required");
              		$this->form_validation->set_rules("totalItemRow", "total product", "trim|required");
	            }
    	        if ( $this->form_validation->run() == FALSE ){
                    //validation fails
                    redirect('sales/invoice');
                    //$this->load->view('login_view');
            	}else{
                	// master entry
                	$voucherArray = array(
                                    'voucher_number' => $this->accounts_model->get_voucher_number($voucherType,$voucherDate),
                                    'voucher_date' => $voucherDate,
                                    'voucher_type' => $voucherType,
                                    'party_id' => $partyId,
                                    'description' => $voucherDescription,
                                    'transection_type' => $transectionType,
                                    'bank_id' => $bankId,
                                    'account_no' => $accountNo,
                                    'cheque_number' => $chequeNo,
                                    'cheque_date' => $chequeDate,
                                    'to_bank_id' => $toBankId,
                                    'to_account_no' => $toAccountNo,
                                    'entry_by' => $this->session->userdata('username'),
                                    'entry_date' => date('Y-m-d')
                                );
                	//print_r($voucherArray);
                	$voucherId= $this->accounts_model->create_voucher($voucherArray);
                	$voucherDetailsArray = array();
                  $toBankHead=$bankHead=1;
                	if($voucherType=="transfer"){
                    	$bankName=$toBankName='';
                    	if($bankId){
                          $bankDetails=$this->bank_model->get_bank($bankId);
	                        $accountDetails=$this->bank_model->get_bank_account($accountNo);
                          if($accountDetails[0]['account_type']=='Short Term Loan'){
                            $bankHead=91;
                          }

	                        $bankName = $bankDetails[0]['bank_name'];
                    	}

	                    if($toBankId){
	                        $bankDetails=$this->bank_model->get_bank($toBankId);
	                        $toBankName = $bankDetails[0]['bank_name'];
                          $toAccountDetails=$this->bank_model->get_bank_account($toAccountNo);
                          if($toAccountDetails[0]['account_type']=='Short Term Loan'){
                            $toBankHead=91;
                          }
                    	}
                  		// cr transection
                  		$voucherDetailsArray= array(
                                  'voucher_id' => $voucherId,
                                  'accounts_head_id' => ($transferFrom=='Cheque'?$bankHead:2),
                                  'particulers' => ($transferFrom=='Cheque'?($bankHead==91? $voucherDescription:"Transfer To ".$toBankName." Account#".$toAccountNo):"Deposited to ".$toBankName." Account #".$toAccountNo),
                                  'transection_type' => 'Cr',
                                  'amount' => $voucherAmount,
                                  'entry_by' => $this->session->userdata('username'),
                                  'entry_date' => date('Y-m-d')
                              );
                  		$voucherResult = $this->accounts_model->create_voucher_details($voucherDetailsArray);

                  		$voucherDetailsArray= array(
                                'voucher_id' => $voucherId,
                                'accounts_head_id' => ($transferTo=='Cheque'?$toBankHead:2),
                                'particulers' => ($transferTo=='Cheque'?($toBankHead==91?$voucherDescription:"Received from ".$bankName." Account#".$accountNo):"Cash Withdraw from ".$bankName." Account #".$accountNo),
                                'transection_type' => 'Dr',
                                'amount' => $voucherAmount,
                                'entry_by' => $this->session->userdata('username'),
                                'entry_date' => date('Y-m-d')
                              );
                  		$voucherResult = $this->accounts_model->create_voucher_details($voucherDetailsArray);
                	} else {
                		if($totalItemRow>0){
                    		for( $i=0; $i < $totalItemRow; $i++ ){
                        		$voucherDetailsArray= array(
                                        'voucher_id' => $voucherId,
                                        'accounts_head_id' => $accountHeadId[$i],
                                        'particulers' => $particulars[$i],
                                        'car_id' => isset($car)?$car[$i]:NULL,
                                        'employee_id' => isset($employee)?$employee[$i]:NULL,
                                        'transection_type' => $voucherType=='journal'?($transectionDrAmount[$i]>0?'Dr':'Cr'):$accountsTransectionType,
                                        'amount' => $voucherType=='journal'?($transectionDrAmount[$i]>0?$transectionDrAmount[$i]:$transectionCrAmount[$i]):$transectionAmount[$i],
                                        'entry_by' => $this->session->userdata('username'),
                                        'entry_date' => date('Y-m-d')
                                    );
                        		$voucherResult = $this->accounts_model->create_voucher_details($voucherDetailsArray);
                        		//add data for sync in party ledger
                        		if(in_array($accountHeadId[$i], array(3,5,12)) && $partyId && $partyId!='118'){
                          			$drAmount= $voucherType=='journal'?($transectionDrAmount[$i]>0?$transectionDrAmount[$i]:0):($accountsTransectionType=='Dr'?$transectionAmount[$i]:0);
                          			$crAmount= $voucherType=='journal'?($transectionCrAmount[$i]>0?$transectionCrAmount[$i]:0):($accountsTransectionType=='Cr'?$transectionAmount[$i]:0);
                          			$dataArray = array(
			                            'party_id' => $partyId,
			                            'transection_desc' => $particulars[$i],
			                            'transection_date' => $voucherDate,
			                            'dr_amount' => $drAmount,
			                            'cr_amount' => $crAmount,
			                            'entry_by' => $this->session->userdata('username'),
			                            'entry_date' => date('Y-m-d')
			                        );
                          			$this->accounts_model->create_party_misc_transection($dataArray);
                        		}
                    		}
                    		if(is_array($voucherDetailsArray) && count($voucherDetailsArray)>0 && $voucherType!=='journal'){
                      			$voucherDetailsArray = array(
                                      'voucher_id' => $voucherId,
                                      'accounts_head_id' => 2,
                                      'particulers' => $totalItemRow==1?$particulars[0]:NULL,
                                      'transection_type' => $voucherType=='receipt'?'Dr':'Cr',
                                      'amount' => $voucherTotal,
                                      'entry_by' => $this->session->userdata('username'),
                                      'entry_date' => date('Y-m-d')
                                );
                      			$voucherResult = $this->accounts_model->create_voucher_details($voucherDetailsArray);
                    		}
                    		//print_r($voucherDetailsArray);
		                }
                	}
                	if ( $voucherResult > 0 ){
                    	redirect('accounts');
                	}  else {
                   		//fsfdsd
                	}
            	}
          	}
      	} else {
        	redirect("login");
      	}
    }

    public function voucherlist()
    {
      if($this->session->has_userdata('username')){
          $data["voucherList"]=$data["voucherType"]=$data["voucherDate"]=$data["voucherNumber"]='';
          if($this->input->post('btn_save')=='Show'){  
              $data["voucherType"]=$voucherType= $this->input->post('voucherType');
              $data["voucherDate"]=$voucherDate= $this->input->post('voucherDate')?date('Y-m-d', strtotime($this->input->post('voucherDate'))):'';
              $data["voucherNumber"]=$voucherNumber= $this->input->post('voucherNumber');              
              $data["voucherList"] = $this->accounts_model->get_voucher_list($voucherType,$voucherDate,$voucherNumber);
          }
          
          $this->load->view('voucher_list_view',$data);
      }
      else{
          redirect ("login");
      }
    }

    public function voucherapprove()
    {
      if($this->session->has_userdata('username')){
          $data["voucherList"] = $this->accounts_model->get_voucher_for_approve();
          $this->load->view('voucher_approve',$data);
      }
      else{
          redirect ("login");
      }
    }

    public function approvedvoucher($voucherId)
    {
      if($this->session->has_userdata('username')){
          $dataArray = array('approve_by' => $this->session->userdata('username'),'approve_date'=>date('Y-m-d') );
          $this->accounts_model->update_voucher($voucherId,$dataArray);
          redirect('accounts/voucherapprove');
      }
      else{
          redirect ("login");
      }
    }

    public function voucherdetails($voucherId)
    {
      if($this->session->has_userdata('username')){
          $data["voucherDetails"] = $this->accounts_model->get_voucher($voucherId);
          $this->load->view('voucher_details_view',$data);
      }
      else{
          redirect ("login");
      }
    }
    public function voucherdetailsprint($voucherId)
    {
      if($this->session->has_userdata('username')){
          $data["voucherDetails"] = $this->accounts_model->get_voucher($voucherId);
          $this->load->view('voucher_details_print',$data);
      }
      else{
          redirect ("login");
      }
    }

    public function accountsledger()
    {
      if($this->session->has_userdata('username')){
          $data = array();
          $data["chartOfAccountsList"] = $userList = $this->chartofaccounts_model->get_chartofaccounts();
          $data["accountHeadId"] = $data["fromDate"] = $data["toDate"]='';
          if ($this->input->post('btn_save') == "Show Report"){
              $accountHeadId = $data["accountHeadId"]=$this->input->post("accountHeadId");
              $data["fromDate"] = $this->input->post("fromDate");
              $fromDate = date('Y-m-d',  strtotime($data["fromDate"]));
              $data["toDate"] = $this->input->post("toDate");
              $toDate = date('Y-m-d',  strtotime($data["toDate"]));
              //set validations
              $this->form_validation->set_rules("accountHeadId", "Client", "required");
              $this->form_validation->set_rules("fromDate", "Date From", "trim|required");
              $this->form_validation->set_rules("toDate", "Date To", "trim|required");

              if ($this->form_validation->run() == TRUE)
              {
                  // $openingInvoiceTotal = $this->sales_model->clientTotalBill($clientId,$fromDate);
                  // $openingCollection = $this->sales_model->clientTotalCollection($clientId,$fromDate);
                  // $openingSalesReturn = $this->sales_model->clientTotalSalesReturn($clientId,$fromDate);
                  $data['accountHeadDetails'] = $clitentInfo = $this->chartofaccounts_model->get_chartofaccounts($accountHeadId);
                  $data["openingBalance"] = $this->accounts_model->getOpeningBalance($accountHeadId,$fromDate);//$openingInvoiceTotal - ($openingCollection+$openingSalesReturn) + $clitentInfo[0]["entry_balance"];
                  $data["transectionData"] = $products = $this->accounts_model->transectionsData($accountHeadId,$fromDate,$toDate);
                //  print_r($products);

              }

          }
          $this->load->view('accounts_ledger',$data);
      }
      else
          redirect ("login");
    }

    public function printaccountsledger($accountHeadId=0,$fromDate='',$toDate='')
    {
        if($this->session->has_userdata('username')){
            $data["toDate"] = $toDate;
            $data["fromDate"] = $fromDate;
            $data['accountHeadDetails'] = $clitentInfo = $this->chartofaccounts_model->get_chartofaccounts($accountHeadId);
            $data["openingBalance"] = $this->accounts_model->getOpeningBalance($accountHeadId,$fromDate);//$openingInvoiceTotal - ($openingCollection+$openingSalesReturn) + $clitentInfo[0]["entry_balance"];
            $data["transectionData"] = $products = $this->accounts_model->transectionsData($accountHeadId,$fromDate,$toDate);
            $this->load->view('accounts_ledger_print',$data);
        }
        else {
            redirect ("login");
        }
    }

    public function accountssubledger()
    {
      	if($this->session->has_userdata('username')){
          	$data = array();
          	$data["chartOfAccountsList"] = $userList = $this->chartofaccounts_model->get_chartofaccounts();
          	$data["clientList"]  = $this->client_model->get_client();
          	$data["accountHeadId"] = $data["clientId"] = $data["fromDate"] = $data["toDate"]='';
          	if ($this->input->post('btn_save') == "Show Report"){
              	$accountHeadId = $data["accountHeadId"] = $this->input->post("accountHeadId");
              	$clientId = $data["clientId"] = $this->input->post("party");
              	$data["fromDate"] = $this->input->post("fromDate");
              	$fromDate = date('Y-m-d',  strtotime($data["fromDate"]));
              	$data["toDate"] = $this->input->post("toDate");
              	$toDate = date('Y-m-d',  strtotime($data["toDate"]));
              	//set validations

              	$this->form_validation->set_rules("party", "client", "required");
              	$this->form_validation->set_rules("fromDate", "Date From", "trim|required");
              	$this->form_validation->set_rules("toDate", "Date To", "trim|required");

              	if ($this->form_validation->run() == TRUE)
              	{
                	  // $openingInvoiceTotal = $this->sales_model->clientTotalBill($clientId,$fromDate);
                  	// $openingCollection = $this->sales_model->clientTotalCollection($clientId,$fromDate);
                  	// $openingSalesReturn = $this->sales_model->clientTotalSalesReturn($clientId,$fromDate);
                  	if($accountHeadId){
                    	$data['accountHeadDetails'] = $this->chartofaccounts_model->get_chartofaccounts($accountHeadId);
                  	} else{
                    	$data['accountHeadDetails'] = NULL;
                  	}
                  	$openingInvoiceTotal = $this->sales_model->clientTotalBill($clientId,'2017-05-01');
                  	$openingCollection = $this->sales_model->clientTotalCollection($clientId,'2017-05-01');
                  	$openingCollected = $this->sales_model->clientTotalCollected($clientId,'2017-05-01');
            		$openingSalesReturn = $this->sales_model->clientTotalSalesReturn($clientId,'2017-05-01');
                  	$openingUnderInvoice = 0;// $this->sales_model->clientTotalUnderInvoice($clientId,'2017-05-01');
                  	$openingPurchase = 0; // $this->purchase_model->partyTotalBill($clientId,'2017-05-01');
                  	$openingPay = 0; //$this->purchase_model->partyTotalPay($clientId,'2017-05-01');
                  	$accountopeningabalnce = $this->sales_model->accountopeningabalnce($clientId,'2017-05-01');
            		$data['clientDetails'] = $clitentInfo = $this->client_model->get_client($clientId);
            		$data["balanceAcStart"] = $accountopeningabalnce + $clitentInfo[0]["entry_balance"];
                  	$data["openingBalance"] = $this->accounts_model->getClientOpeningBalance($clientId,$accountHeadId,$fromDate);
                  	$data["transectionData"] = $products = $this->accounts_model->transectionsSubData($clientId,$fromDate,$toDate,$accountHeadId);
                //  print_r($products);

              }

          }
          $this->load->view('accounts_sub_ledger',$data);
      }
      else
          redirect ("login");
    }

    public function printaccountssubledger($clientId=0,$fromDate='',$toDate='',$accountHeadId=0)
    {
        if($this->session->has_userdata('username')){
            $data["toDate"] = $toDate;
            $data["fromDate"] = $fromDate;
            if($accountHeadId){
              $data['accountHeadDetails'] = $this->chartofaccounts_model->get_chartofaccounts($accountHeadId);
            } else{
              $data['accountHeadDetails'] = NULL;
            }
            $openingInvoiceTotal = $this->sales_model->clientTotalBill($clientId,'2017-05-01');
            $openingCollection = $this->sales_model->clientTotalCollection($clientId,'2017-05-01');
            $openingCollected = $this->sales_model->clientTotalCollected($clientId,'2017-05-01');
            $openingSalesReturn = $this->sales_model->clientTotalSalesReturn($clientId,'2017-05-01');
            $accountopeningabalnce = $this->sales_model->accountopeningabalnce($clientId,'2017-05-01');
            $data['clientDetails'] = $clitentInfo = $this->client_model->get_client($clientId);
            $data["balanceAcStart"] = $accountopeningabalnce + $clitentInfo[0]["entry_balance"];
            $data["openingBalance"] = $this->accounts_model->getClientOpeningBalance($clientId,$accountHeadId,$fromDate);//$openingInvoiceTotal - ($openingCollection+$openingSalesReturn) + $clitentInfo[0]["entry_balance"];
            $data["transectionData"] = $products = $this->accounts_model->transectionsSubData($clientId,$fromDate,$toDate,$accountHeadId);
            $this->load->view('accounts_sub_ledger_print',$data);
        }
        else {
            redirect ("login");
        }
    }

    public function cashbook()
    {
      if($this->session->has_userdata('username')){
          $data = array();
          $data["fromDate"] = $data["toDate"]='';
          if ($this->input->post('btn_save') == "Show Report"){
              $accountHeadId = 2;
              $data["fromDate"] = $this->input->post("fromDate");
              $fromDate = date('Y-m-d',  strtotime($data["fromDate"]));
              $data["toDate"] = $this->input->post("toDate");
              $toDate = date('Y-m-d',  strtotime($data["toDate"]));
              //set validations

              $this->form_validation->set_rules("fromDate", "Date From", "trim|required");
              $this->form_validation->set_rules("toDate", "Date To", "trim|required");

              if ($this->form_validation->run() == TRUE)
              {
                  $data['accountHeadDetails'] = $clitentInfo = $this->chartofaccounts_model->get_chartofaccounts($accountHeadId);
                  $data["openingBalance"] = $this->accounts_model->getOpeningBalance(2,$fromDate);//$openingInvoiceTotal - ($openingCollection+$openingSalesReturn) + $clitentInfo[0]["entry_balance"];
                  $data["transectionData"] = $products = $this->accounts_model->cashBookTransectionsData($fromDate,$toDate);
                //  print_r($products);

              }

          }

          $this->load->view('cash_book',$data);
      }
      else
          redirect ("login");
    }

    public function printcashbook($fromDate='',$toDate='')
    {
        if($this->session->has_userdata('username')){

            $data["toDate"] = $toDate;
            $data["fromDate"] = $fromDate;
            $data['accountHeadDetails'] = $clitentInfo = $this->chartofaccounts_model->get_chartofaccounts(2);
            $data["openingBalance"] = $this->accounts_model->getOpeningBalance(2,$fromDate);
            $data["transectionData"] = $products = $this->accounts_model->cashBookTransectionsData($fromDate,$toDate);
    //        $html= $this->load->view('test_cash_book',$data,true);
            $this->load->view('cash_book_print',$data);
        }
        else {
            redirect ("login");
        }
    }

    public function bankbook()
    {
      if($this->session->has_userdata('username')){
          $data = array();
          $data["accountList"] = $this->bank_model->get_bank_account();
          $data["fromDate"] = $data["toDate"]='';
          if ($this->input->post('btn_save') == "Show Report"){
              $accountHeadId = 1;
              $accountNo = $this->input->post("bankAccount");
              $data["fromDate"] = $this->input->post("fromDate");
              $fromDate = date('Y-m-d',  strtotime($data["fromDate"]));
              $data["toDate"] = $this->input->post("toDate");
              $toDate = date('Y-m-d',  strtotime($data["toDate"]));
              //set validations

              $this->form_validation->set_rules("fromDate", "Date From", "trim|required");
              $this->form_validation->set_rules("toDate", "Date To", "trim|required");

              if ($this->form_validation->run() == TRUE)
              {
                  $data['accountHeadDetails'] = $clitentInfo = $this->chartofaccounts_model->get_chartofaccounts($accountHeadId);
                  $data['bankAccountDetails'] = $this->bank_model->get_bank_account($accountNo);
                  $data["openingBalance"] = $this->accounts_model->getBankOpeningBalance($accountNo,$fromDate);//$openingInvoiceTotal - ($openingCollection+$openingSalesReturn) + $clitentInfo[0]["entry_balance"];
                  $data["transectionData"] = $products = $this->accounts_model->bankBookTransectionsData($accountNo,$fromDate,$toDate);
              }

          }
          $this->load->view('bank_book',$data);
      }
      else
          redirect ("login");
    }

    public function printbankbook($accountNo,$fromDate='',$toDate='')
    {
        if($this->session->has_userdata('username')){

            $data["toDate"] = $toDate;
            $data["fromDate"] = $fromDate;
            $data['accountHeadDetails'] = $clitentInfo = $this->chartofaccounts_model->get_chartofaccounts(1);
            $data['bankAccountDetails'] = $this->bank_model->get_bank_account($accountNo);
            $data["openingBalance"] = $this->accounts_model->getOpeningBalance(1,$fromDate);
            $data["transectionData"] = $products = $this->accounts_model->bankBookTransectionsData($accountNo,$fromDate,$toDate);
            $this->load->view('bank_book_print',$data);
        }
        else {
            redirect ("login");
        }
    }

    public function employeeexpenses()
    {
      if($this->session->has_userdata('username')){
          $data = array();
          $data["clientList"] = $this->client_model->get_client();
          $data["employeeList"] = $this->employee_model->get_company_employee(118);
          $data["fromDate"] = $data["toDate"]='';
          if ($this->input->post('btn_save') == "Show Report"){
              $employeeId = $this->input->post("employee");
              $data["fromDate"] = $this->input->post("fromDate");
              $fromDate = date('Y-m-d',  strtotime($data["fromDate"]));
              $data["toDate"] = $this->input->post("toDate");
              $toDate = date('Y-m-d',  strtotime($data["toDate"]));
              //set validations

              $this->form_validation->set_rules("fromDate", "Date From", "trim|required");
              $this->form_validation->set_rules("toDate", "Date To", "trim|required");

              if ($this->form_validation->run() == TRUE)
              {
                  $data['employeeDetails'] = $clitentInfo = $this->employee_model->get_employee($employeeId);
                  $data['openingBalance'] = $this->accounts_model->getEmployeeOpeningBalance($employeeId,$fromDate);
                  $data["transectionData"] = $products = $this->accounts_model->employeeTransectionsData($employeeId,$fromDate,$toDate);
              }

          }
          $this->load->view('employee_expenses',$data);
      }
      else
          redirect ("login");
    }

    public function carexpenses()
    {
      if($this->session->has_userdata('username')){
          $data = array();
          $data["carList"] = $this->car_model->get_car();
          $data["fromDate"] = $data["toDate"]='';
          if ($this->input->post('btn_save') == "Show Report"){

              $carId = $this->input->post("car");
              $data["fromDate"] = $this->input->post("fromDate");
              $fromDate = date('Y-m-d',  strtotime($data["fromDate"]));
              $data["toDate"] = $this->input->post("toDate");
              $toDate = date('Y-m-d',  strtotime($data["toDate"]));
              //set validations

              $this->form_validation->set_rules("fromDate", "Date From", "trim|required");
              $this->form_validation->set_rules("toDate", "Date To", "trim|required");

              if ($this->form_validation->run() == TRUE)
              {
                  $data['carDetails'] = $clitentInfo = $this->car_model->get_car($carId);
                  $data["transectionData"] = $products = $this->accounts_model->carTransectionsData($carId,$fromDate,$toDate);
              }

          }
          $this->load->view('car_expenses',$data);
      }
      else
          redirect ("login");
    }

    public function printcarexpenses($carId,$fromDate,$toDate)
    {
        if($this->session->has_userdata('username')){
            $data = array();
            $carId = $carId;
            $data["fromDate"] = $fromDate;
            $data["toDate"] = $toDate;
            $data['carDetails'] = $clitentInfo = $this->car_model->get_car($carId);
            $data["transectionData"] = $products = $this->accounts_model->carTransectionsData($carId,$fromDate,$toDate);
            $this->load->view('print_car_expenses',$data);
        }
        else
            redirect ("login");
    }


    public function bankloan()
    {
      if($this->session->has_userdata('username')){
          $data = array();
          $data["chartOfAccountsList"] = $userList = $this->chartofaccounts_model->get_chartofaccounts();
          $data["accountList"] = $this->bank_model->get_bank_account();
          $data['accountHeadId']=$data["fromDate"] = $data["toDate"]='';
          if ($this->input->post('btn_save') == "Show Report"){
              $accountHeadId = $data['accountHeadId']=$this->input->post("accountHeadId");
              $accountNo = $this->input->post("bankAccount");
              $data["fromDate"] = $this->input->post("fromDate");
              $fromDate = date('Y-m-d',  strtotime($data["fromDate"]));
              $data["toDate"] = $this->input->post("toDate");
              $toDate = date('Y-m-d',  strtotime($data["toDate"]));
              //set validations

              $this->form_validation->set_rules("fromDate", "Date From", "trim|required");
              $this->form_validation->set_rules("toDate", "Date To", "trim|required");

              if ($this->form_validation->run() == TRUE)
              {
                  $data['accountHeadDetails'] = $clitentInfo = $this->chartofaccounts_model->get_chartofaccounts($accountHeadId);
                  $data['bankAccountDetails'] = $this->bank_model->get_bank_account($accountNo);
                  $data["openingBalance"] = $this->accounts_model->getBankLoanOpeningBalance($accountHeadId,$accountNo,$fromDate);//$openingInvoiceTotal - ($openingCollection+$openingSalesReturn) + $clitentInfo[0]["entry_balance"];
                  $data["transectionData"] = $products = $this->accounts_model->bankLoanTransectionsData($accountHeadId,$accountNo,$fromDate,$toDate);

              }

          }
          $this->load->view('bank_loan',$data);
      }
      else
          redirect ("login");
    }

    public function printbankloan($accountHeadId,$accountNo,$fromDate='',$toDate='')
    {
        if($this->session->has_userdata('username')){

            $data["toDate"] = $toDate;
            $data["fromDate"] = $fromDate;
            $data['accountHeadDetails'] = $clitentInfo = $this->chartofaccounts_model->get_chartofaccounts($accountHeadId);
            $data['bankAccountDetails'] = $this->bank_model->get_bank_account($accountNo);
            $data["openingBalance"] = $this->accounts_model->getBankLoanOpeningBalance($accountHeadId,$accountNo,$fromDate);;
            $data["transectionData"] = $products = $this->accounts_model->bankLoanTransectionsData($accountHeadId,$accountNo,$fromDate,$toDate);
            $this->load->view('bank_book_print',$data);
        }
        else {
            redirect ("login");
        }
    }


    public function journal()
    {
      if($this->session->has_userdata('username')){
          $data = array();
          $data["fromDate"] = $data["toDate"]= $data['journalType']='';
          if ($this->input->post('btn_save') == "Show Report"){
              $journalType = $data['journalType'] = $this->input->post("journalType");
              $data["fromDate"] = $this->input->post("fromDate");
              $fromDate = date('Y-m-d',  strtotime($data["fromDate"]));
              $data["toDate"] = $this->input->post("toDate");
              $toDate = date('Y-m-d',  strtotime($data["toDate"]));
              //set validations

              $this->form_validation->set_rules("fromDate", "Date From", "trim|required");
              $this->form_validation->set_rules("toDate", "Date To", "trim|required");

              if ($this->form_validation->run() == TRUE) {
                    $data["transectionData"] = $products = $this->accounts_model->journalTransectionsData($fromDate,$toDate,$journalType);
              }

          }
          $this->load->view('journal',$data);
      }
      else
          redirect ("login");
    }


    public function printjournal($fromDate='',$toDate='', $journalType='')
    {
        if($this->session->has_userdata('username')){

            $data["toDate"] = $toDate;
            $data["fromDate"] = $fromDate;
            $data['journalType'] = $journalType;
            $data["transectionData"] = $products = $this->accounts_model->journalTransectionsData($fromDate,$toDate,$journalType);

            $this->load->view('journal_print',$data);
        }
        else {
            redirect ("login");
        }
    }

    public function trailbalance()
    {
      if($this->session->has_userdata('username')){
          $data = array();
          $data["fromDate"] = $data["toDate"]='';
          if ($this->input->post('btn_save') == "Show Report"){
              $data["fromDate"] = $this->input->post("fromDate");
              $fromDate = date('Y-m-d',  strtotime($data["fromDate"]));
              $data["toDate"] = $this->input->post("toDate");
              $toDate = date('Y-m-d',  strtotime($data["toDate"]));
              //set validations
              $this->form_validation->set_rules("fromDate", "Date From", "trim|required");
              $this->form_validation->set_rules("toDate", "Date To", "trim|required");

              if ($this->form_validation->run() == TRUE){
                  $data["transectionData"] = $products = $this->accounts_model->getTrailBalance($fromDate,$toDate);
              }
          }
          $this->load->view('trail_balance',$data);
      }
      else
          redirect ("login");
    }

    public function printtrailbalance($fromDate,$toDate)
    {
      if($this->session->has_userdata('username')){
        $data = array();
        $data["toDate"] = $toDate;
        $data["fromDate"] = $fromDate;
        $data["transectionData"] = $products = $this->accounts_model->getTrailBalance($fromDate,$toDate);

        $this->load->view('trail_balance_print',$data);
      }
      else
          redirect ("login");
    }

    public function expenses()
    {
      if($this->session->has_userdata('username')){
          $data = array();
          $data["fromDate"] = $data["toDate"]='';
          if ($this->input->post('btn_save') == "Show Report"){
              $data["fromDate"] = $this->input->post("fromDate");
              $fromDate = date('Y-m-d',  strtotime($data["fromDate"]));
              $data["toDate"] = $this->input->post("toDate");
              $toDate = date('Y-m-d',  strtotime($data["toDate"]));
              //set validations
              $this->form_validation->set_rules("fromDate", "Date From", "trim|required");
              $this->form_validation->set_rules("toDate", "Date To", "trim|required");

              if ($this->form_validation->run() == TRUE){
                  $data["transectionData"] = $products =  array_merge($this->accounts_model->getGroupSumData(8,$fromDate,$toDate),$this->accounts_model->getSubGroupSumData(7,13,$fromDate,$toDate));
              }
          }
          $this->load->view('expenses_sum_view',$data);
      }
      else
          redirect ("login");
    }

    public function printexpenses($fromDate,$toDate)
    {
      if($this->session->has_userdata('username')){
          $data = array();
          $data["toDate"] = $toDate;
          $data["fromDate"] = $fromDate;
          $data["transectionData"] = $products =  array_merge($this->accounts_model->getGroupSumData(8,$fromDate,$toDate),$this->accounts_model->getSubGroupSumData(7,13,$fromDate,$toDate));
          $this->load->view('expenses_print',$data);
      }
      else
          redirect ("login");
    }

    public function notes()
    {
        if($this->session->has_userdata('username')){
            $data = array();
            $data["fromDate"] = $data["toDate"]='';
            if ($this->input->post('btn_save') == "Show Report"){
                $data["fromDate"] = $this->input->post("fromDate");
                $fromDate = date('Y-m-d',  strtotime($data["fromDate"]));
                $data["toDate"] = $this->input->post("toDate");
                $toDate = date('Y-m-d',  strtotime($data["toDate"]));
                //set validations
                $this->form_validation->set_rules("fromDate", "Date From", "trim|required");
                $this->form_validation->set_rules("toDate", "Date To", "trim|required");

                if ($this->form_validation->run() == TRUE){
                    
                    $data["notes1"] =  $this->notes->notes1($fromDate,$toDate);
                    $data["notes2"] =  $this->notes->notes2($fromDate,$toDate);
                    $data["notes3"] =  $this->notes->notes3($fromDate,$toDate);
                    $data["notes4"] =  $this->notes->notes4($fromDate,$toDate);
                    $data["notes5"] =  $this->notes->notes5($fromDate,$toDate);
                    $data["notes6"] =  $this->notes->notes6($fromDate,$toDate);
                }
            }
            $this->load->view('notes_view',$data); 
      }
    }
    public function incomestatement()
    {
      if($this->session->has_userdata('username')){
          $data = array();
          $data["fromDate"] = $data["toDate"]='';
          if ($this->input->post('btn_save') == "Show Report"){
              $data["fromDate"] = $this->input->post("fromDate");
              $fromDate = date('Y-m-d',  strtotime($data["fromDate"]));
              $data["toDate"] = $this->input->post("toDate");
              $toDate = date('Y-m-d',  strtotime($data["toDate"]));
              //set validations
              $this->form_validation->set_rules("fromDate", "Date From", "trim|required");
              $this->form_validation->set_rules("toDate", "Date To", "trim|required");

              if ($this->form_validation->run() == TRUE){
                  $data["salesData"] = $products = $this->accounts_model->getSubGroupSumData(6,12,$fromDate,$toDate);
                  $data["costofGoodsSold"] =  $this->notes->notes1sum($fromDate,$toDate);
                  $data["otherInfocomeData"] = $products = $this->accounts_model->getSubGroupSumData(6,20,$fromDate,$toDate);
                  $data["adminExpenses"] = $this->notes->notes2sum($fromDate,$toDate);
                  $data["sellingExpenses"] = $this->notes->notes3sum($fromDate,$toDate);
                  $data["financeExpenses"] = $this->notes->notes4sum($fromDate,$toDate);
                  $data["taxExpensesData"] = $products = $this->accounts_model->getSubGroupSumData(8,19,$fromDate,$toDate);
              }
          }
          $this->load->view('incomestatement',$data);
      }
      else
          redirect ("login");
    }
    public function printincomestatement($fromDate,$toDate)
    {
      if($this->session->has_userdata('username')){
          $data = array();
          $data["toDate"] = $toDate;
          $data["fromDate"] = $fromDate;
          $data["salesData"] = $products = $this->accounts_model->getAccountHeadSumData(23,$fromDate,$toDate);
          $data["costofGoodsSoldData"] = $products = $this->accounts_model->getSubGroupSumData(7,13,$fromDate,$toDate);
          $data["otherInfocomeData"] = $products = $this->accounts_model->getSubGroupSumData(6,20,$fromDate,$toDate);
          $data["adminExpensesData"] = $products = $this->accounts_model->getSubGroupSumData(8,16,$fromDate,$toDate);
          $data["sellingExpensesData"] = $products = $this->accounts_model->getSubGroupSumData(8,15,$fromDate,$toDate);
          $data["financeExpensesData"] = $products = $this->accounts_model->getSubGroupSumData(8,18,$fromDate,$toDate);
          $data["taxExpensesData"] = $products = $this->accounts_model->getSubGroupSumData(8,19,$fromDate,$toDate);
          $this->load->view('incomestatement_print',$data);
      }
      else
          redirect ("login");
    }

    public function balancesheet()
    {
      if($this->session->has_userdata('username')){
          $data = array();
          $data["fromDate"] = $data["toDate"]='';
          if ($this->input->post('btn_save') == "Show Report"){
              $data["fromDate"] = $this->input->post("fromDate");
              $fromDate = date('Y-m-d',  strtotime($data["fromDate"]));
              $data["toDate"] = $this->input->post("toDate");
              $toDate = date('Y-m-d',  strtotime($data["toDate"]));
              //set validations
              $this->form_validation->set_rules("fromDate", "Date From", "trim|required");
              $this->form_validation->set_rules("toDate", "Date To", "trim|required");

              if ($this->form_validation->run() == TRUE){
                  $data["fixedAsset"] = $this->accounts_model->getSubGroupSumData(2,5,$fromDate,$toDate);
                  $data["inventory"] = $this->products->closingstock($fromDate,$toDate);
                  $data["goodsInTransit"] = $this->product_model->goodesIntransit($fromDate,$toDate);
                  $data["advance"] = $this->notes->notes5sum($fromDate,$toDate);
                  $data["cashAndBank"] = $this->notes->notes6sum($fromDate,$toDate);
                  $data["receivable"] = $this->accounts_model->getAccountHeadSumData(3,$fromDate,$toDate);
                  $data["ChequeInHand"] = $this->accounts_model->getAccountHeadSumData(110,$fromDate,$toDate);
                  $data["mdAccount"] = $this->accounts_model->getAccountHeadSumData(89,$fromDate,$toDate);
                  $data["capitalData"] = $this->accounts_model->getSubGroupSumData(5,10,$fromDate,$toDate);
                  $data["profitandLossData"] = $this->accounts_model->getSubGroupSumData(5,11,$fromDate,$toDate);
                  $data["currentYearProfit"] = $this->getNetIncome($fromDate,$toDate);
                  $data["liabilitiesData"] = array_merge($this->accounts_model->getGroupSumData(3,$fromDate,$toDate),$this->accounts_model->getGroupSumData(4,$fromDate,$toDate));
              }
          }
          $this->load->view('balancesheet',$data);
      }
      else
          redirect ("login");
    }

    function getNetIncome($fromDate,$toDate)
    {
      $salesData = $this->accounts_model->getSubGroupSumData(6,12,$fromDate,$toDate);
      $costofGoodsSold =  $this->notes->notes1sum($fromDate,$toDate);
      $otherInfocomeData = $this->accounts_model->getSubGroupSumData(6,20,$fromDate,$toDate);
      $adminExpenses = $this->notes->notes2sum($fromDate,$toDate);
      $sellingExpenses = $this->notes->notes3sum($fromDate,$toDate);
      $financeExpenses = $this->notes->notes4sum($fromDate,$toDate);
      $taxExpensesData = $this->accounts_model->getSubGroupSumData(8,19,$fromDate,$toDate);

      $salesAmount=$netProfit=$tax=0;
      foreach ($salesData as $transection){
        $salesAmount += $transection['amount'];
      }      

      $netProfit=$salesAmount-$costofGoodsSold;

      foreach ($otherInfocomeData as $transection){
        $netProfit += $transection['amount'];
      }

      //exepenses
      
      $totalExpenses = $adminExpenses+$sellingExpenses+$financeExpenses;
      $netProfit -= $totalExpenses;

      foreach ($taxExpensesData as $transection){
        $tax += $transection['amount'];
      }
      $netProfit -= $tax;
      return $netProfit;
    }

    public function receiptandpayment()
    {
      if($this->session->has_userdata('username')){
          $data = array();
          $data["fromDate"] = $data["toDate"]='';

          if ($this->input->post('btn_save') == "Show Report"){
              $data["fromDate"] = $this->input->post("fromDate");
              $fromDate = date('Y-m-d',  strtotime($data["fromDate"]));
              $data["toDate"] = $this->input->post("toDate");
              $toDate = date('Y-m-d',  strtotime($data["toDate"]));

              $this->form_validation->set_rules("fromDate", "Date From", "trim|required");
              $this->form_validation->set_rules("toDate", "Date To", "trim|required");

              if ($this->form_validation->run() == TRUE){
                $data["openingBalance"] = $this->accounts_model->getOpeningBalance(2,$fromDate);
                $data["cashTransectionData"] = $products = $this->accounts_model->receiptandpaymentdata($fromDate,$toDate);
                $data["expensesData"] = $products = array_merge($this->accounts_model->getGroupSumDataWithoutJV(8,$fromDate,$toDate),$this->accounts_model->getSubGroupSumDataWithoutJV(7,13,$fromDate,$toDate));
              }
          }
          $this->load->view('receiptandpayment',$data);
      }
      else
          redirect ("login");
    }

    public function printreceiptandpayment($fromDate,$toDate)
    {
      if($this->session->has_userdata('username')){
          $data = array();
          $data["toDate"] = $toDate;
          $data["fromDate"] = $fromDate;
          $data["openingBalance"] = $this->accounts_model->getOpeningBalance(2,$fromDate);
          $data["cashTransectionData"] = $products = $this->accounts_model->receiptandpaymentdata($fromDate,$toDate);
          $data["expensesData"] = $products = array_merge($this->accounts_model->getGroupSumDataWithoutJV(8,$fromDate,$toDate),$this->accounts_model->getSubGroupSumDataWithoutJV(7,13,$fromDate,$toDate));
          $this->load->view('receiptandpayment_print',$data);
      }
      else
          redirect ("login");
    }

    public function vouchercount()
    {
      if($this->session->has_userdata('username')){
          $data["dataList"]=$data["voucherDate"]='';
          if($this->input->post('btn_save')=='Show'){  
              $data["voucherDate"]=$voucherDate= $this->input->post('voucherDate')?date('Y-m-d', strtotime('01-'.$this->input->post('voucherDate'))):'';
              
              $data["dataList"] = $dataList= $this->accounts_model->get_voucher_count($voucherDate);
              //print_r($dataList);
          }
          
          $this->load->view('voucher_count_view',$data);
      }
      else{
          redirect ("login");
      }
    }

    public function vouchercountdetails($voucherType,$fromDate,$toDate)
    {
      if($this->session->has_userdata('username')){
        $data['journalType'] = $voucherType;
        $data["fromDate"] = $fromDate;
        $data["toDate"] = $toDate;
        $data["transectionData"] = $products = $this->accounts_model->journalTransectionsData($fromDate,$toDate,$voucherType);
        $this->load->view('journal',$data);
      } else{
        redirect ("login");
      }
    }
}
