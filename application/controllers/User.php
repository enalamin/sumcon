<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
     
        $this->load->database();
        $this->load->model('user_model');
        $this->load->model('location_model');
        $this->load->model('login_model');
        $currentMenue = array('activeSidebar' => 'Setup');
        $this->session->set_userdata($currentMenue);
    }
    
    public function index()
    {
        if($this->session->has_userdata('username')){
            $data["userList"] = $userList = $this->user_model->get_user();
            $data["locationList"] = $this->location_model->getLocations();
			$data["userDetails"] = "";
            $this->load->view('user_view',$data);
        }
        else
            redirect ("login");
    }
	
	public function edituser($userId)
    {
        if($this->session->has_userdata('username') && $this->session->userdata('userType')=="admin"){
            $data["userList"] = $userList = $this->user_model->get_user();
            $data["locationList"] = $this->location_model->getLocations();
            $data["userDetails"] = $this->user_model->get_user($userId);
            $this->load->view('user_view',$data);
        }
        else
            redirect ("login");
    }

    public function removeuser($userId)
    {
        if($this->session->has_userdata('username') && $this->session->userdata('userType')=="admin"){
            return $usr_result = $this->user_model->update_user($userId,array('status' => 'inactive'));
        }
        else
            return "You don't have access to delete user";
    }

    public function create_user($userId=NULL)
    {
        if($this->session->has_userdata('username') && $this->session->userdata('userType')=="admin"){
            //get the posted values
            $userName = $this->input->post("userName");
            $userPassword = $this->input->post("userPassword");
            $rePassword = $this->input->post("rePassword");
            $userEmail = $this->input->post("userEmail");
            $userLocation = $this->input->post("userLocation");
            $userType = $this->input->post("userType");
            //set validations
            $this->form_validation->set_rules("userName", "Name", "trim|required");
            if($userId==NULL){
                $this->form_validation->set_rules("userPassword", "User Password", "trim|required");
                $this->form_validation->set_rules("userLocation", "User Location", "trim|required");
            }
            $this->form_validation->set_rules("userType", "User Type", "trim|required");
            if ($this->form_validation->run() == FALSE){
                //validation fails
                redirect('user/index');
                //$this->load->view('login_view');
            }
            else {   
                if($this->input->post('btn_save') == "Save User"){
                    //check if username and password is correct
                    if($userId!=NULL){
                        $userDetails=$this->user_model->get_user($userId);
                        $newPassword = !empty($userPassword) ? md5($userPassword) : $userDetails[0]['password'];
                        $userArray = array(
                            'username' => $userName,
                            'password' => $newPassword,
                            'email' => $userEmail,
                            'status' => 'active',
                            'location_id' => $userLocation,
                            'user_type' => $userType
                        );
                        $usr_result = $this->user_model->update_user($userId,$userArray);
                    }else{
                        $userArray = array(
                                                'username' => $userName,
                                                'password' => md5($userPassword),
                                                'email' => $userEmail,
                                                'status' => 'active',
                                                'location_id' => $userLocation,
                                                'user_type' => $userType
                                            );
                        $usr_result = $this->user_model->create_user($userArray);
                    }
                    if ($usr_result > 0){
                       redirect('user/index');
                    }
                    else{
                        $this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">Invalid username and password!</div>');
                        redirect('user/index');
                    }
                }
                else {
                    redirect('login/index');
                }
            }
        }
        else
            redirect ("login");
    }
    
    public function menupermission($userId=NULL)
    {
        if($this->session->has_userdata('username') && $this->session->has_userdata('userType') && $this->session->userdata('userType')=="admin"){
            if($userId){
                $userSideMenu = $this->user_model->usermenuidlist($userId);
				$userSideMenArray = array();
				$i=0;				
				foreach($userSideMenu as $menu){
					$userSideMenArray[$i] = $menu["menu_id"];
					$i++;
				}
                $data["userSideMenu"]= $userSideMenArray;
                $data["userId"]= $userId;
            }
            $data["sideMenu"]= $sideMenu = $this->login_model->get_admin_menu();            
            $data["userList"] = $userList = $this->user_model->get_userList('general');
            $this->load->view('menu_list',$data);           
        }  else {
            error_log("access deny");
        }
        
    }
    
    public function menupermissionsave()
    {
        if($this->session->has_userdata('username') && $this->session->has_userdata('userType') && $this->session->userdata('userType')=="admin"){
            $userMenu = $this->input->post("menu");
			$userId= $this->input->post("userName");
			$userMenuArray = array();
			$i=0;
			foreach($userMenu as $pid => $menu){
				$userMenuArray[$i] = array(
                                'user_id' => $userId,
                                'menu_id' => $pid,
                                'view_status' => '1',
                                'entry_by' => $this->session->userdata('username'),
				'entry_date' => date('Y-m-d')
                            );
                                $i++;
				foreach($menu as $subMenu){
                                    $userMenuArray[$i] = array(
                                        'user_id' => $userId,
                                        'menu_id' => $subMenu,
                                        'view_status' => '1',
                                        'entry_by' => $this->session->userdata('username'),
                                        'entry_date' => date('Y-m-d')
                                    );
                                    $i++;
				}	
				
			}
			if($i>0){
					$this->user_model->deleteusermenu($userId);
					$this->user_model->usermenu($userMenuArray);
				}
			
            $data["sideMenu"]= $sideMenu = $this->login_model->get_admin_menu();
            $data["userList"] = $userList = $this->user_model->get_userList('general');
            $this->load->view('menu_list',$data);           
        }  else {
            error_log("access deny");
        }
        
    }
    
}
