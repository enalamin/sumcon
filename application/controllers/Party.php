<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Party extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
     
        $this->load->database();
        $this->load->model('party_model');
        $currentMenue = array('activeSidebar' => 'purchase');
        $this->session->set_userdata($currentMenue);
    }
	
    public function index()
    {
        if($this->session->has_userdata('username')){
            $data["partyList"] = $party = $this->party_model->get_party();
			$data["partyDetails"] = '';
            $this->load->view('party_view',$data);
        }
        else
            redirect ("login");
    }
	
	public function editparty($partyId)
    {
        if($this->session->has_userdata('username') && $this->session->userdata('userType')=="admin"){
            $data["partyList"] = $this->party_model->get_party();
            $data["partyDetails"] = $this->party_model->get_party($partyId);
            $this->load->view('party_view',$data);
        }
        else
            redirect ("login");
    }
        
    public function create_party($partyId=NULL)
    {
        if($this->session->has_userdata('username')){

            //get the posted values
            $partyName = $this->input->post("partyName");
            $partyAddress = $this->input->post("partyAddress");
            $partyContactNo = $this->input->post("partyContactNo");
            $partyEmail = $this->input->post("partyEmail");
            $partyWeb = $this->input->post("partyWeb");
            //set validations
            $this->form_validation->set_rules("partyName", "Name", "trim|required");
            $this->form_validation->set_rules("partyContactNo", "Contact Number", "trim|required");
            $this->form_validation->set_rules("partyAddress", "Address", "trim|required");

            if ($this->form_validation->run() == FALSE)
            {
                //validation fails
                redirect('party/index');
                //$this->load->view('login_view');
            }
            else
            {   
                if($this->input->post('btn_save') == "Save Party"){
                    //check if username and password is correct
					$partyArray = array(
												'party_name' => $partyName,
												'party_address' => $partyAddress,
												'party_contact_no' => $partyContactNo,
												'party_email' => $partyEmail,
												'party_web' => $partyWeb
											);
						
					if($partyId!==NULL){
						if($this->session->userdata('userType')=="admin"){
							$usr_result = $this->party_model->update_party($partyId,$partyArray);
							if ($usr_result > 0){
							   redirect('party/index');
							}
						}
						else{
							$this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">You don\'t have permission!</div>');
							redirect('party/index');
						}
					} else {
						$usr_result = $this->party_model->create_party($partyArray);
						if ($usr_result > 0){
						   redirect('party/index');
						}
						else
						{
							$this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">Invalid username and password!</div>');
							redirect('party/index');
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
    
    public function getpartyaddress($clientId)
    {
        if($this->session->has_userdata('username')){
            $party = $this->party_model->get_party($clientId);
            echo $party[0]["party_address"];
            //return json_encode($products[0]);
        }
        else
            echo "";
    }
        
        
        
}
