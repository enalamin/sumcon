<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Locations extends CI_Controller {
    
    public function __construct()
    {
        parent::__construct();
     
        $this->load->database();
        $this->load->model('location_model');
        $currentMenue = array('activeSidebar' => 'inventory');
        $this->session->set_userdata($currentMenue);
    }
	
    public function index()
    {
        if($this->session->has_userdata('username')){
            $data["locationList"] = $products = $this->location_model->getLocations();
            $this->load->view('location_view',$data);
        }
        else
            redirect ("login");
    }
    
    public function createLocation()
    {
        if($this->session->has_userdata('username')){

            //get the posted values
            $locationName = $this->input->post("locationName");
            $incharge = $this->input->post("incharge");
            $locationDescription = $this->input->post("locationDescription");
            $contactNumber = $this->input->post("contactNumber");
            //set validations
            $this->form_validation->set_rules("locationName", "Location Name", "trim|required");
            $this->form_validation->set_rules("incharge", "Location In-Charge", "trim|required");
            

            if ($this->form_validation->run() == FALSE){
                //validation fails
                redirect('locations/index');
                //$this->load->view('login_view');
            }
            else{
                //validation succeeds
                if ($this->input->post('btn_save') == "Save Location"){
                    //check if username and password is correct
                    $locationArray = array(
                                            'location_name' => $locationName,
                                            'location_incharge' => $incharge,
                                            'location_description' => $locationDescription,
                                            'location_contact_no' => $contactNumber,
                                            'entry_by'=>$this->session->userdata('username')
                                        );
                    $locationResult = $this->location_model->createLocation($locationArray);
                    if ($locationResult > 0){
                       redirect('locations/index');

                    }
                    else{
                        $this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">Invalid username and password!</div>');
                        redirect('login/index');
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
}
