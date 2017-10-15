<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Productloantaken extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
     
        $this->load->database();
        $this->load->model('product_model');
        $this->load->model('client_model');
        $this->load->model('purchase_model');
        $this->load->model('location_model');
        $this->load->model('loan_model');
        $currentMenue = array('activeSidebar' => 'inventory');
        $this->session->set_userdata($currentMenue);
    }
    public function index()
    {
        if($this->session->has_userdata('username')){
            $data["loanList"] = $this->loan_model->getLoanTakenList('1');
            $this->load->view('loan_taken_view',$data);
        }
        else
            redirect ("login");
    }
    public function unapprovetakenloan()
    {
        if($this->session->has_userdata('username')){
            $data["loanList"] = $this->loan_model->getLoanTakenList('0');
            $data["listTitel"] = "Unapproved Loan Taken List";
            $this->load->view('loan_taken_view',$data);
        }
        else
            redirect ("login");
    }
    public function loanCreate()
    {
        if($this->session->has_userdata('username')){
            if ($this->input->post('btn_save') == "Save"){
               // print_r($_POST);
                $loanNumber = $this->input->post("loanNumber");
                $loanTakenDate = date('Y-m-d',  strtotime($this->input->post("datemask")));
                $client = $this->input->post("client");
                $totalItemRow = $this->input->post("totalItemRow");
                $products = $this->input->post("productid");
                $productsQty = $this->input->post("productQty");
                $productsPackage = $this->input->post("productPackge");
                $productsRemarks = $this->input->post("productRemarks");
				$stockLocation = $this->input->post("stockLocation");
                //set validations
                $this->form_validation->set_rules("loanNumber", "Loan Number", "trim|required");
				$this->form_validation->set_rules("stockLocation", "Location", "trim|required");
                $this->form_validation->set_rules("datemask", "Loan Taken Date", "trim|required");
                $this->form_validation->set_rules("client", "Client Name ", "trim|required");
                
                $this->form_validation->set_rules("totalItemRow", "total product", "trim|required");
                if ($this->form_validation->run() == FALSE){
                        //validation fails
                        redirect('productloantaken/loanCreate');
                        //$this->load->view('login_view');
                }
                else{
                        for($i=0;$i<$totalItemRow;$i++){
                        $loanArray[$i] = array(
                                        'loan_number' => $loanNumber,
                                        'loan_taken_date' => $loanTakenDate,
                                        'client_id' => $client,
                                        'product_id' => $products[$i],
                                        'quantity' => $productsQty[$i],
                                        'package' => $productsPackage[$i],
                                        'remarks' => $productsRemarks[$i],
										'location_id' => $stockLocation,
                                        'entry_by' => $this->session->userdata('username')
                                    );
                        }
                        $loanResult = $this->loan_model->createLoanTaken($loanArray);
                        if($loanResult > 0) //active user record is present
                        {
                           redirect('productloantaken');

                        }

                    }
            }
            else {
                $data['loanNumber'] = $this->loan_model->getLoanTakenNumber();
                $data["clientList"] = $this->client_model->get_client();
                $data["productList"] =  $this->product_model->get_product();
				$data["locationList"] = $this->location_model->getLocations();
                $this->load->view('loan_taken_entry_view',$data);
            }
        }
        else
            redirect ("login");
    }

    function viewsloantaken($loanNumber)
    {
        if($this->session->has_userdata('username')){
            $data['loanDetails'] = $this->loan_model->getLoanTaken($loanNumber);
            $this->load->view('loan_taken_details_view',$data);
        }  else {
            redirect ("login");
        }
    }
    
    function printloantaken($loanNumber)
    {
        if($this->session->has_userdata('username')){
            $data['loanDetails'] = $this->loan_model->getLoanTaken($loanNumber);
            $this->load->view('loan_taken_print_view',$data);
        }  else {
            redirect ("login");
        }
    }
    
    function updateloantaken($loanNumber, $statusValue)
    {
        if($this->session->has_userdata('username')){
            
            $stustUpdateData = array(
                'status'=>$statusValue,
                'approved_by' => $this->session->userdata('username')
            );
            $updateRow = $this->loan_model->updateTakenStatus($loanNumber,$stustUpdateData);
            //if($updateRow>0)
            redirect('productloantaken/unapprovetakenloan');
                
        }  else {
            redirect ("login");
        }
    }
	
	public function productloanreceivedetails()
    {
        if($this->session->has_userdata('username')){
            $currentMenue = array('activeSidebar' => 'reports');
            $this->session->set_userdata($currentMenue);
            $data = array();
            $data['clientList'] = $this->client_model->get_client();
			$data["productList"] =  $this->product_model->get_product();
            if ($this->input->post('btn_save') == "Show"){
                $clientId = $this->input->post("client");
                $productId = $this->input->post("product");
                $fromDate = $data["fromDate"] = date('Y-m-d',  strtotime($this->input->post("fromDate")));
                $toDate = $data["toDate"] = date('Y-m-d',  strtotime($this->input->post("toDate")));
				
				$data["transectionData"] = $products = $this->loan_model->productloanreceive($fromDate, $toDate, $productId, $clientId);
            
                
            }
            $this->load->view('product_loan_taken_details_report',$data);
        }
        else
            redirect ("login");
    }

   
}
