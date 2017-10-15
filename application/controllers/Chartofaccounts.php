<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Chartofaccounts extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        $this->load->database();
        $this->load->model('chartofaccounts_model');
        $this->load->model('user_model');
        $this->load->model('login_model');
        $currentMenue = array('activeSidebar' => 'accounts');
        $this->session->set_userdata($currentMenue);
    }

    public function index()
    {
        if($this->session->has_userdata('username')){
            $data["chartOfAccountsList"] = $userList = $this->chartofaccounts_model->get_chartofaccounts();
            $data["groupList"] = $this->chartofaccounts_model->get_groups();
			      $data["chartOfAccountsDetails"] = "";
            $this->load->view('chart_of_accounts_view',$data);
        }
        else
            redirect ("login");
    }

    public function getsubgroups($groupId)
    {
      if($this->session->has_userdata('username')){
          $subGroupList = $this->chartofaccounts_model->get_subgroups($groupId);
          echo json_encode($subGroupList);
      } else {
          echo "you need to loging";
      }
    }

    public function listofaccounts()
    {
        $data["chartOfAccountsList"] = $userList = $this->chartofaccounts_model->get_chartofaccounts();
        $this->load->view('chart_of_accounts_list',$data);
    }

    public function printaccountshead()
    {
        $data["chartOfAccountsList"] = $userList = $this->chartofaccounts_model->get_chartofaccounts();
        $this->load->view('chart_of_accounts_print',$data);
    }


	public function edit_chartofaccounts($accountHeadId)
    {
        if($this->session->has_userdata('username') && $this->session->userdata('userType')=="admin"){
          $data["chartOfAccountsList"] = $userList = $this->chartofaccounts_model->get_chartofaccounts();
          $data["groupList"] = $this->chartofaccounts_model->get_groups();
          $data["chartOfAccountsDetails"] = $this->chartofaccounts_model->get_chartofaccounts($accountHeadId);
          $this->load->view('chart_of_accounts_view',$data);
        }
        else
            redirect ("login");
    }

    public function removeuser($accountHeadId)
    {
        if($this->session->has_userdata('username') ){
            return $usr_result = $this->user_model->update_user($userId,array('status' => 'inactive'));
        }
        else
            return "You don't have access to delete user";
    }

    public function create_chartofaccounts($accountHeadId=NULL)
    {
        if($this->session->has_userdata('username') ){
            //get the posted values
            $accountsHeadName = $this->input->post("accountsHeadName");
            $financialStatement = $this->input->post("financialStatement");
            $accountsGroup = $this->input->post("accountsGroup");
            $accountsSubGroup = $this->input->post("accountsSubGroup");
            $accountsType = $this->input->post("accountsType");
            //set validations
            $this->form_validation->set_rules("accountsHeadName", "Accounts Head", "trim|required");
            $this->form_validation->set_rules("financialStatement", "Financial Statement", "trim|required");
            $this->form_validation->set_rules("accountsGroup", "Accounts group", "trim|required");
            $this->form_validation->set_rules("accountsSubGroup", "Accounts sub group", "trim|required");
            $this->form_validation->set_rules("accountsType", "Accounts Type", "trim|required");
            if ($this->form_validation->run() == FALSE){
                //validation fails
                redirect('chartofaccounts');
                //$this->load->view('login_view');
            }
            else {
                if($this->input->post('btn_save') == "Save"){
                  $headArray = array(
                                    'head_name' => $accountsHeadName,
                                    'financial_statement' => $financialStatement,
                                    'group_id' => $accountsGroup,
                                    'sub_group_id' => $accountsSubGroup,
                                    'transection_type' => $accountsType,
                                    'entry_by' => $this->session->userdata('username'),
                                    'entry_date' => date('Y-m-d')
                                );

                    if ($accountHeadId!=NULL) {
                        $usr_result = $this->chartofaccounts_model->update_chartofaccounts($accountHeadId,$headArray);
                    } else {
                        $usr_result = $this->chartofaccounts_model->create_chartofaccounts($headArray);
                    }

                    if ($usr_result > 0){
                       redirect('chartofaccounts');
                    }
                    else{
                        $this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">Invalid username and password!</div>');
                        redirect('chartofaccounts');
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

}
