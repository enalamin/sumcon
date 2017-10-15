<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Employee extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        $this->load->database();
        $this->load->model('employee_model');
        $this->load->model('client_model');

    }

    public function index()
    {
        if($this->session->has_userdata('username')){
            $data["employeeList"] = $this->employee_model->get_employee();
            $data["clientList"] = $this->client_model->get_client();
            $this->load->view('employee_view',$data);
        } else{
            redirect ("login");
        }
    }


    public function getemployees($companyId)
    {
      if($this->session->has_userdata('username')){
          $employeeList = $this->employee_model->get_company_employee($companyId);
          echo json_encode($employeeList);
      } else {
          echo "you need to loging";
      }
    }


    public function create_employee()
    {
        if($this->session->has_userdata('username')){
            //get the posted values
            $companyId = $this->input->post("company");
            $employeeName = $this->input->post("employeeName");
            $address = $this->input->post("officeAddress");
            $designation = $this->input->post("designation");
            $contactNo = $this->input->post("contactNo");
            $email = $this->input->post("email");
            //set validations
            $this->form_validation->set_rules("employeeName", "Name", "trim|required");
            $this->form_validation->set_rules("company", "Company", "trim|required");
            $this->form_validation->set_rules("contactNo", "Contact No", "trim|required");

            if ($this->form_validation->run() == FALSE) {
                //validation fails
                redirect('bank/index');
            } else {
                if($this->input->post('btn_save') == "Save Employee"){
                  //check if username and password is correct
                  $employeeArray = array(
  									'client_id' => $companyId,
  									'employee_name' => $employeeName,
  									'address' => $address,
  									'contact_no' => $contactNo,
                    'designation' => $designation,
                    'email' => $email,
                    'entry_by' => $this->session->userdata("username")
  								);
                  $usr_result = $this->employee_model->create_employee($employeeArray);
                  if ($usr_result > 0){
                     redirect('employee');
                  } else {
                      $this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">Invalid username and password!</div>');
                      redirect('employee');
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
            $branchName = $this->input->post("branchName");
            $contactNo = $this->input->post("contactNo");
            //set validations
            $this->form_validation->set_rules("bank", "Bank Name", "trim|required");
            $this->form_validation->set_rules("accoutNumber", "Account Number", "trim|required");

            if ($this->form_validation->run() == FALSE) {
                //validation fails
                redirect('bank/index');
            } else {
                if($this->input->post('btn_save') == "Save Bank Account"){
                  //check if username and password is correct
                  $bankAccountArray = array(
  									'bank_id' => $bank,
                    'account_no' => $accoutNumber,
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
