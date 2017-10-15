<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bank extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        $this->load->database();
        $this->load->model('bank_model');
        //$currentMenue = array('activeSidebar' => 'sales');
        //$this->session->set_userdata($currentMenue);
    }

    public function index()
    {
        if($this->session->has_userdata('username')){
            $data["bankList"] = $products = $this->bank_model->get_bank();
            $this->load->view('bank_view',$data);
        } else{
            redirect ("login");
        }
    }

    public function account()
    {
        if($this->session->has_userdata('username')){
            $data["bankList"] = $products = $this->bank_model->get_bank();
            $data["accountList"] = $this->bank_model->get_bank_account();
            $this->load->view('bank_account_view',$data);
        } else{
            redirect ("login");
        }
    }

    public function getaccounts($bankId)
    {
      if($this->session->has_userdata('username')){
          $accountList = $this->bank_model->get_bank_accounts($bankId);
          echo json_encode($accountList);
      } else {
          echo "you need to loging";
      }
    }


    public function create_bank()
    {
        if($this->session->has_userdata('username')){
            //get the posted values
            $bankName = $this->input->post("bankName");
            $address = $this->input->post("officeAddress");
            $branchName = $this->input->post("branchName");
            $contactNo = $this->input->post("contactNo");
            //set validations
            $this->form_validation->set_rules("bankName", "Name", "trim|required");

            if ($this->form_validation->run() == FALSE) {
                //validation fails
                redirect('bank/index');
            } else {
                if($this->input->post('btn_save') == "Save Bank"){
                  //check if username and password is correct
                  $bankArray = array(
  									'bank_name' => $bankName,
  									'branch_name' => $branchName,
  									'branch_address' => $address,
  									'contact_no' => $contactNo
  								);
                  $usr_result = $this->bank_model->create_bank($bankArray);
                  if ($usr_result > 0){
                     redirect('bank/index');
                  } else {
                      $this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">Invalid username and password!</div>');
                      redirect('bank/index');
                  }
                } else {
                    redirect('login/index');
                }
            }
        } else
            redirect ("login");
    }

    public function create_bank_account()
    {
        if($this->session->has_userdata('username')){
            //get the posted values
            $bank = $this->input->post("bank");
            $accoutNumber = $this->input->post("accoutNumber");
            $address = $this->input->post("officeAddress");
            $accountType = $this->input->post("accountType");
            $branchName = $this->input->post("branchName");
            $contactNo = $this->input->post("contactNo");
            //set validations
            $this->form_validation->set_rules("bank", "Bank Name", "trim|required");
            $this->form_validation->set_rules("accoutNumber", "Account Number", "trim|required");
            $this->form_validation->set_rules("accountType", "Account Type", "trim|required");

            if ($this->form_validation->run() == FALSE) {
                //validation fails
                redirect('bank/index');
            } else {
                if($this->input->post('btn_save') == "Save Bank Account"){
                  //check if username and password is correct
                  $bankAccountArray = array(
  									'bank_id' => $bank,
                    'account_no' => $accoutNumber,
                    'account_type' => $accountType,
  									'branch_name' => $branchName,
  									'branch_address' => $address,
  									'contact_no' => $contactNo
  								);
                  $usr_result = $this->bank_model->create_bank_account($bankAccountArray);
                  if ($usr_result > 0){
                     redirect('bank/account');
                  } else {
                      $this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">Invalid username and password!</div>');
                      redirect('bank/account');
                  }
                } else {
                    redirect('login/index');
                }
            }
        } else
            redirect ("login");
    }

}
