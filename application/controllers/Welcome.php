<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        
        $this->load->database();
        
        $this->load->model('login_model');
       
    }
    public function index()
    {
       
        
        if($this->session->has_userdata('username')){
            $data = array();
            if($this->session->has_userdata('userType') && $this->session->userdata('userType')=="admin"){
                //$data["sideMenu"]= $sideMenu = $this->login_model->get_admin_menu();
                                
            }
            elseif ($this->session->has_userdata('userType') && $this->session->userdata('userType')=="general") {
                //$data["sideMenu"]=$this->login_model->get_user_menu($this->session->userdata('userId'));
            }

            $this->load->view('welcome_message',$data);
        }
        else
            redirect ("login");
    }
}
