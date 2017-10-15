<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model('login_model');       
    }

    public function index()
    {
        if($this->session->has_userdata('username'))
            redirect ("welcome");
        //get the posted values
        $username = $this->input->post("txt_username");
        $password = $this->input->post("txt_password");

        //set validations
        $this->form_validation->set_rules("txt_username", "Username", "trim|required");
        $this->form_validation->set_rules("txt_password", "Password", "trim|required");

        if ($this->form_validation->run() == FALSE){
            $this->load->view('login_view');
        }
        else{
            if ($this->input->post('btn_login') == "Login"){
                $usr_result = $this->login_model->get_user($username, $password);
                if (count($usr_result) > 0){
                    $sessiondata = array(
                        'username' => $username,
                        'userId' => $usr_result[0]['id'],
                        'userType' => $usr_result[0]['user_type'],
                        'userEmail' => $usr_result[0]['email'],
                        'locationId' => $usr_result[0]['location_id'],
                        'loginuser' => TRUE
                    );
                    $this->session->set_userdata($sessiondata);
                    redirect("welcome");
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
    
    public function logOut()
    {
        unset($_SESSION);
        $this->session->sess_destroy();
        redirect("login");
    }
}?>