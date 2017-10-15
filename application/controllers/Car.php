<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Car extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        $this->load->database();
        $this->load->model('car_model');
    }

    public function index()
    {
        if($this->session->has_userdata('username')){
            $data["carList"] = $products = $this->car_model->get_car();
            $this->load->view('car_view',$data);
        } else{
            redirect ("login");
        }
    }

    public function create_car()
    {
        if($this->session->has_userdata('username')){
            //get the posted values
            $carNumber = $this->input->post("carNumber");
            $address = $this->input->post("officeAddress");
            $carName = $this->input->post("carName");
            $contactNo = $this->input->post("contactNo");
            //set validations
            $this->form_validation->set_rules("carNumber", "Number", "trim|required");
            $this->form_validation->set_rules("carName", "Name", "trim|required");

            if ($this->form_validation->run() == FALSE) {
                //validation fails
                redirect('bank/index');
            } else {
                if($this->input->post('btn_save') == "Save Car"){
                  //check if username and password is correct
                  $carArray = array(
  									'car_number' => $carNumber,
  									'car_name' => $carName,
  									'address' => $address,
  									'contact_no' => $contactNo,
                    'entry_by' => $this->session->userdata('username')
  								);
                  $usr_result = $this->car_model->create_car($carArray);
                  if ($usr_result > 0){
                     redirect('car');
                  } else {
                      $this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">Invalid username and password!</div>');
                      redirect('car');
                  }
                } else {
                    redirect('login/index');
                }
            }
        } else
            redirect ("login");
    }



}
