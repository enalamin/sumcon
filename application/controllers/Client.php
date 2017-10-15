<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Client extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        $this->load->database();
        $this->load->model('client_model');
        //$currentMenue = array('activeSidebar' => 'sales');
        //$this->session->set_userdata($currentMenue);
    }

    public function index()
    {
        if($this->session->has_userdata('username')){
            $data["clientList"] = $products = $this->client_model->get_client();
            $data["clientDetails"] ='';
            $this->load->view('client_view',$data);
        }
        else
            redirect ("login");
    }

	public function editclient($clientId)
    {
        if($this->session->has_userdata('username') && $this->session->userdata('userType')=="admin"){
            $data["clientList"] =  $this->client_model->get_client();
            $data["clientDetails"] = $this->client_model->get_client($clientId);
            $this->load->view('client_view',$data);
        }
        else
            redirect ("login");
    }

    public function create_client($clientId=NULL)
    {
        if($this->session->has_userdata('username')){

            //get the posted values
            $clientName = $this->input->post("clientName");
            $clientOfficeAddress = $this->input->post("clientOfficeAddress");
            $clientDeliveryAddress = $this->input->post("clientDeliveryAddress");
            $clientContactNo = $this->input->post("clientContactNo");
            $clientEmail = $this->input->post("clientEmail");
            $clientWeb = $this->input->post("clientWeb");
            $clientType = $this->input->post("clientType");
            $clientSection = $this->input->post("clientSection");
            $clientBalance = $this->input->post("clientBalance");
            //set validations
            $this->form_validation->set_rules("clientName", "Name", "trim|required");
            $this->form_validation->set_rules("clientContactNo", "Contact Number", "trim|required");
            $this->form_validation->set_rules("clientOfficeAddress", "office Address", "trim|required");
            $this->form_validation->set_rules("clientType", "Client Type", "trim|required");
            $this->form_validation->set_rules("clientSection", "Client Section", "trim|required");

            if ($this->form_validation->run() == FALSE)
            {
                //validation fails
                redirect('client/index');
                //$this->load->view('login_view');
            }
            else
            {
                if($this->input->post('btn_save') == "Save Client"){
                    //check if username and password is correct
					if($clientId!==NULL){
						$clientArray = array(
												'client_name' => $clientName,
												'client_office_address' => $clientOfficeAddress,
												'client_delivery_address' => $clientDeliveryAddress,
												'client_contact_no' => $clientContactNo,
												'client_email' => $clientEmail,
                                                'client_type' => $clientType,
                                                'client_section' => $clientSection,
												'client_web' => $clientWeb
											);
						if($this->session->userdata('userType')=="admin"){
							$usr_result = $this->client_model->update_client($clientId,$clientArray);
							if ($usr_result > 0){
							   redirect('client/index');
							}
							else
							{
								$this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">Invalid username and password!</div>');
								redirect('client/index');
							}
						}
						else{
							$this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">You don\'t have permission!</div>');
							redirect('product/index');
						}
					} else {
						$clientArray = array(
												'client_name' => $clientName,
												'client_office_address' => $clientOfficeAddress,
												'client_delivery_address' => $clientDeliveryAddress,
												'client_contact_no' => $clientContactNo,
												'client_email' => $clientEmail,
                                                'client_web' => $clientWeb,
                                                'client_type' => $clientType,
												'client_section' => $clientSection,
												'entry_balance' => $clientBalance
											);
						$usr_result = $this->client_model->create_client($clientArray);
						if ($usr_result > 0){
						   redirect('client/index');
						}
						else
						{
							$this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">Invalid username and password!</div>');
							redirect('client/index');
						}
					}
                }
                else
                {
                    redirect('login/index');
                }
            }
        }
        else
            redirect ("login");
    }

    public function getclientaddress($clientId)
    {
        if($this->session->has_userdata('username')){
            $data["clientList"] = $products = $this->client_model->get_client($clientId);
            echo $products[0]["client_office_address"];
            //return json_encode($products[0]);
        }
        else
            echo "";
    }

}
