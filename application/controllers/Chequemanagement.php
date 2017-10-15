<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Chequemanagement extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        $this->load->database();
        $this->load->model('product_model');
        $this->load->model('client_model');
        $this->load->model('bank_model');
        $this->load->model('sales_model');
        $this->load->model('accounts_model');
		    $this->load->model('location_model');
        $currentMenue = array('activeSidebar' => 'cheque management');
        $this->session->set_userdata($currentMenue);
    }

    public function index()
    {
        if($this->session->has_userdata('username')){
            $data['clientList'] = $this->client_model->get_client();
            $data['collections'] = $this->sales_model->get_cheque_collections('1');
            $this->load->view('cheque_management_view',$data);
        }
        else{
            redirect ("login");
        }
    }

    public function bounchedcheque()
    {
        if($this->session->has_userdata('username')){
            $data['clientList'] = $this->client_model->get_client();
            $data['collections'] = $this->bank_model->get_all_cheque('Bounce');
            $this->load->view('bounce_cheque_view',$data);
        }
        else{
            redirect ("login");
        }
    }

    public function getallcheque()
    {
        if($this->session->has_userdata('username')){
            $data['clientList'] = $this->client_model->get_client();
            $data['collections'] = $this->bank_model->get_all_cheque();
            $this->load->view('all_cheque_view',$data);
        }
        else{
            redirect ("login");
        }
    }

    public function depositedchequeinfo()
    {
        if($this->session->has_userdata('username')){
            $data['clientList'] = $this->client_model->get_client();
            $data['collections'] = $this->bank_model->get_deposited_cheque();
            $this->load->view('cheque_info_view',$data);
        }
        else{
            redirect ("login");
        }
    }

	  public function depositinbank($collectionId)
    {
        if($this->session->has_userdata('username')){
            $data['bankList'] = $this->bank_model->get_bank();
            $data['collectionDetails'] = $this->sales_model->get_collectionrow($collectionId);
            $this->load->view('cheque_deposit_view',$data);
        }
        else{
            redirect ("login");
        }
    }

    public function chequedeposit($collectionId)
    {
        if($this->session->has_userdata('username') && $collectionId){
            //get the posted values
            $bankId = $this->input->post("bank");
            $accountNo = $this->input->post("accountNo");
            $depositDate = date('Y-m-d',  strtotime($this->input->post("datemask")));
            //set validations
            $this->form_validation->set_rules("bank", "Bank", "trim|required");
            $this->form_validation->set_rules("accountNo", "Account Number", "trim|required");
            $this->form_validation->set_rules("datemask", "Deposit Date", "trim|required");

            if ($this->form_validation->run() == FALSE){
                //validation fails
                redirect('Chequemanagement/index');
            }
            else{
                if ($this->input->post('btn_save') == "Save"){
                    $dataArray = array(
                        'collection_id' => $collectionId,
                        'deposit_bank_id' => $bankId,
                        'account_no' => $accountNo,
                        'deposit_date' => $depositDate,
                        'entry_by' => $this->session->userdata('username'),
                        'entry_date' => date('Y-m-d h:i:s')
                    );

                    $result = $this->bank_model->create_bank_deposit($dataArray);

                    if ($result > 0) //active user record is present
                    {
                        $this->sales_model->update_collection($collectionId, array('cheque_status'=>'Deposited'));
                        redirect('Chequemanagement/index');

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

    public function clearcheque($depositId)
    {
        if($this->session->has_userdata('username') && $this->session->userdata('userType')=="admin"){
            $collectionId = $this->input->get("collection_id");
            $depositDetails = $this->bank_model->get_deposited_cheque($collectionId);
            if ($depositDetails[0]["collection_type"]=='cheque') {
              $voucherNumber= $this->accounts_model->get_voucher_number('journal',$depositDetails[0]["deposit_date"]);
              // master entry
              $voucherArray = array(
                                  'voucher_number' => $voucherNumber,
                                  'voucher_date' => $depositDetails[0]["deposit_date"],
                                  'voucher_type' => 'journal',
                                  'transection_type' => 'Cheque',
                                  'party_id' => $depositDetails[0]["client_id"],
                                  'description' => 'Collected By Cheque no.'.$depositDetails[0]["checque_no"].' of collection #'.$depositDetails[0]["collection_no"],
                                  'bank_id' => $depositDetails[0]["deposit_bank_id"],
                                  'account_no' => $depositDetails[0]["account_no"],
                                  'cheque_number' => $depositDetails[0]["checque_no"],
                                  'cheque_date' => $depositDetails[0]["checque_date"],
                                  'entry_by' => $this->session->userdata('username'),
                                  'entry_date' => date('Y-m-d')
                              );
              $voucherId= $this->accounts_model->create_voucher($voucherArray);
              $voucherDetailsArray = array();
              // transection to reduce Cheque in hand / Receivable [Cr.]
              $adjustHead= $this->bank_model->get_cheque_bounce_id($collectionId)?3:110;

              $voucherDetailsArray= array(
                              'voucher_id' => $voucherId,
                              'accounts_head_id' => $adjustHead,
                              'particulers' => 'Collected By Cheque no.'.$depositDetails[0]["checque_no"].' of collection #'.$depositDetails[0]["collection_no"],
                              'transection_type' => 'Cr',
                              'amount' => $depositDetails[0]["collection_amount"],
                              'entry_by' => $this->session->userdata('username'),
                              'entry_date' => date('Y-m-d')
                          );
              $voucherResult = $this->accounts_model->create_voucher_details($voucherDetailsArray);
              // transection against cash in hand
                $voucherDetailsArray = array(
                                'voucher_id' => $voucherId,
                                'accounts_head_id' => 1,
                                'particulers' => 'Collected By Cheque no.'.$depositDetails[0]["checque_no"].' of collection #'.$depositDetails[0]["collection_no"],
                                'transection_type' => 'Dr',
                                'amount' => $depositDetails[0]["collection_amount"],
                                'entry_by' => $this->session->userdata('username'),
                                'entry_date' => date('Y-m-d')
                            );
                $voucherResult = $this->accounts_model->create_voucher_details($voucherDetailsArray);
            }
            $user_result = $this->bank_model->update_deposit($depositId,array('deposit_status' => 'clear'));
            if($user_result){
                $this->sales_model->update_collection($collectionId, array('cheque_status'=>'Clear'));
                return 0;
            }
        }
        else
            return "You don't have access to clear the check";
    }

    public function bouncecheque($depositId)
    {
        if($this->session->has_userdata('username') && $this->session->userdata('userType')=="admin"){
            $collectionId = $this->input->get("collection_id");
            $depositDetails = $this->bank_model->get_deposited_cheque($collectionId);
            if ($depositDetails[0]["collection_type"]=='cheque') {
              $voucherNumber= $this->accounts_model->get_voucher_number('journal',$depositDetails[0]["deposit_date"]);
              // master entry
              $voucherArray = array(
                                  'voucher_number' => $voucherNumber,
                                  'voucher_date' => $depositDetails[0]["deposit_date"],
                                  'voucher_type' => 'journal',
                                  'transection_type' => 'Cheque',
                                  'party_id' => $depositDetails[0]["client_id"],
                                  'description' => 'Bounce the cheque no. '.$depositDetails[0]["checque_no"].' of collection #'.$depositDetails[0]["collection_no"],
                                  'bank_id' => $depositDetails[0]["deposit_bank_id"],
                                  'account_no' => $depositDetails[0]["account_no"],
                                  'cheque_number' => $depositDetails[0]["checque_no"],
                                  'cheque_date' => $depositDetails[0]["checque_date"],
                                  'entry_by' => $this->session->userdata('username'),
                                  'entry_date' => date('Y-m-d')
                              );
              $voucherId= $this->accounts_model->create_voucher($voucherArray);
              $voucherDetailsArray = array();
              // transection to reduce Cheque in hand [Cr.]
              $voucherDetailsArray= array(
                              'voucher_id' => $voucherId,
                              'accounts_head_id' => 110,
                              'particulers' => 'Bounce the cheque no. '.$depositDetails[0]["checque_no"].' of collection #'.$depositDetails[0]["collection_no"],
                              'transection_type' => 'Cr',
                              'amount' => $depositDetails[0]["collection_amount"],
                              'entry_by' => $this->session->userdata('username'),
                              'entry_date' => date('Y-m-d')
                          );
              $voucherResult = $this->accounts_model->create_voucher_details($voucherDetailsArray);
              // transection against receivable
                $voucherDetailsArray = array(
                                'voucher_id' => $voucherId,
                                'accounts_head_id' => 3,
                                'particulers' => 'Bounce the cheque no. '.$depositDetails[0]["checque_no"].' of collection #'.$depositDetails[0]["collection_no"],
                                'transection_type' => 'Dr',
                                'amount' => $depositDetails[0]["collection_amount"],
                                'entry_by' => $this->session->userdata('username'),
                                'entry_date' => date('Y-m-d')
                            );
                $voucherResult = $this->accounts_model->create_voucher_details($voucherDetailsArray);
            }
            $user_result = $this->bank_model->update_deposit($depositId,array('deposit_status' => 'bounce'));
            if($user_result){
                $this->sales_model->update_collection($collectionId, array('cheque_status'=>'Bounce'));
                return 0;
            }
        }
        else
            return "You don't have access to bounce the check";
    }

    public function chequecollection()
    {
        if($this->session->has_userdata('username')){
           $data = array();
            $data['clientList'] = $this->client_model->get_client();
            if ($this->input->post('btn_save') == "Show"){
                $collectionType = $this->input->post("cheque_status");
                $clientId = (int)$this->input->post("client");
                if($this->input->post("toDate")==''||$this->input->post("fromDate")==''){
                    $data["fromDate"]=$data["toDate"]=$fromDate=$toDate=NULL;
                }else{
                    $fromDate = $data["fromDate"] = date('Y-m-d',  strtotime($this->input->post("fromDate")));
                    $toDate = $data["toDate"] = date('Y-m-d',  strtotime($this->input->post("toDate")));
                }
                $data["transectionData"] = $products = $this->bank_model->get_cheque_collections($clientId,$collectionType, $fromDate, $toDate);
            }

            $this->load->view('cheque_collection_report',$data);
        }
        else
            redirect ("login");
    }


}
