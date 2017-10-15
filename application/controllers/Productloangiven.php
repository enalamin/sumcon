<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Productloangiven extends CI_Controller {

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
            $data["loanList"] = $this->loan_model->getLoanGivenList('1');
            $this->load->view('loan_given_view',$data);
        }
        else
            redirect ("login");
    }
    public function unapprovegivenloan()
    {
        if($this->session->has_userdata('username')){
            $data["loanList"] = $this->loan_model->getLoanGivenList('0');
            $data["listTitel"] = "Unapproved Loan Given List";
            $this->load->view('loan_given_view',$data);
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
                $loanGivenDate = date('Y-m-d',  strtotime($this->input->post("datemask")));
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
                $this->form_validation->set_rules("datemask", "Loan Given Date", "trim|required");
                $this->form_validation->set_rules("client", "Client Name ", "trim|required");
                
                $this->form_validation->set_rules("totalItemRow", "total product", "trim|required");
                if ($this->form_validation->run() == FALSE){
                        //validation fails
                        redirect('productloangiven/loanCreate');
                        //$this->load->view('login_view');
                }
                else{
                        for($i=0;$i<$totalItemRow;$i++){
                        $loanArray[$i] = array(
                                        'loan_number' => $loanNumber,
                                        'loan_given_date' => $loanGivenDate,
                                        'client_id' => $client,
                                        'product_id' => $products[$i],
                                        'quantity' => $productsQty[$i],
                                        'package' => $productsPackage[$i],
                                        'remarks' => $productsRemarks[$i],
										'location_id' => $stockLocation,
                                        'entry_by' => $this->session->userdata('username')
                                    );
                        }
                        $loanResult = $this->loan_model->createLoanGiven($loanArray);
                        if($loanResult > 0) //active user record is present
                        {
                           redirect('productloangiven');

                        }

                    }
            }
            else {
                $data['loanNumber'] = $this->loan_model->getLoanGivenNumber();
                $data["clientList"] = $this->client_model->get_client();
                $data["productList"] =  $this->product_model->get_product();
				$data["locationList"] = $this->location_model->getLocations();
                $this->load->view('loan_given_entry_view',$data);
            }
        }
        else
            redirect ("login");
    }

    function viewsloangiven($loanNumber)
    {
        if($this->session->has_userdata('username')){
            $data['loanDetails'] = $this->loan_model->getLoanGiven($loanNumber);
            $this->load->view('loan_given_details_view',$data);
		}  else {
            redirect ("login");
        }
    }
    
    function printloangiven($loanNumber)
    {
        if($this->session->has_userdata('username')){
            $data['loanDetails'] = $this->loan_model->getLoanGiven($loanNumber);
            $this->load->view('loan_given_print_view',$data);
        }  else {
            redirect ("login");
        }
    }
    
    function updateloangiven($loanNumber, $statusValue)
    {
        if($this->session->has_userdata('username')){
            
            $stustUpdateData = array(
                'status'=>$statusValue,
                'approved_by' => $this->session->userdata('username')
            );
            $updateRow = $this->loan_model->updateGivenStatus($loanNumber,$stustUpdateData);
            //if($updateRow>0)
            redirect('productloangiven/unapprovegivenloan');
                
        }  else {
            redirect ("login");
        }
    }
	
	public function productloangivendetails()
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
				
				$data["transectionData"] = $products = $this->loan_model->productloangiven($fromDate, $toDate, $productId, $clientId);
            
                
            }
            $this->load->view('product_loan_given_details_report',$data);
        }
        else
            redirect ("login");
    }
	
	public function productloanledger()
    {
        if($this->session->has_userdata('username')){
            $currentMenue = array('activeSidebar' => 'reports');
            $this->session->set_userdata($currentMenue);
            $data = array();
            $data["productList"] =  $this->product_model->get_product();
			$data['clientList'] = $this->client_model->get_client();
            if ($this->input->post('btn_save') == "Show"){
                $productId = $this->input->post("product");
				$clientId = $this->input->post("client");
                $data["productDetails"]=$this->product_model->get_product($productId);
				$data["clientDetails"]=$this->client_model->get_client($clientId);
				if($this->input->post("toDate")==''||$this->input->post("fromDate")==''){
                    $data["fromDate"]=$data["toDate"]=$fromDate=$toDate=NULL;
					$data["openingBalance"] = 0;
                }else{
                $fromDate = $data["fromDate"] = date('Y-m-d',  strtotime($this->input->post("fromDate")));
                $toDate = $data["toDate"] = date('Y-m-d',  strtotime($this->input->post("toDate")));
				$productBalance = $this->loan_model->productloanopeningbalance($productId,$clientId,$fromDate);
				$data["openingBalance"] = $productBalance[0]["openingbalance"];
				}
				$data['clientId'] = $clientId? $clientId:0;
				$data["transectionData"] = $products = $this->loan_model->productwiseloantransection($productId,$clientId,$fromDate,$toDate);           
			}
            $this->load->view('product_loan_ledger_report',$data);
        }
        else
            redirect ("login");
    }
	
    public function productloanledgerprint($clientId,$productId,$fromDate='',$toDate='')
    {
        if($this->session->has_userdata('username')){
            $data = array();
            $data["productDetails"]=$this->product_model->get_product($productId);
            $data["clientDetails"]=$this->client_model->get_client($clientId);
            if($fromDate=='' || $toDate==''){
                $data["fromDate"]=$data["toDate"]=$fromDate=$toDate=NULL;
                $data["openingBalance"] = 0;
            }else{
                $data["fromDate"]=$fromDate = $fromDate;
                $data["toDate"]=$toDate = $toDate;
                $productBalance = $this->loan_model->productloanopeningbalance($productId,$clientId,$fromDate);
                $data["openingBalance"] = $productBalance[0]["openingbalance"];
            }
                
            $data["transectionData"] = $products = $this->loan_model->productwiseloantransection($productId,$clientId,$fromDate,$toDate);           
            $this->load->view('product_loan_ledger_report_print',$data);
        }
        else
            redirect ("login");
    }

	public function productloansummery()
    {
        if($this->session->has_userdata('username')){
            $currentMenue = array('activeSidebar' => 'reports');
            $this->session->set_userdata($currentMenue);
            $data = array();
            $data["productList"] =  $this->product_model->get_product();
			$data['clientList'] = $this->client_model->get_client();
            if ($this->input->post('btn_save') == "Show"){
                $productId = (int) $this->input->post("product");
				$clientId = (int) $this->input->post("client");
				$data["productDetails"]=$this->product_model->get_product($productId);
				$data["clientDetails"]=$this->client_model->get_client($clientId);
				$data["clientId"]=$clientId;
				
				
				$data["transectionData"] = $products = $this->loan_model->productloanbalance($productId,$clientId,date('Y-m-d'));           
			}
            $this->load->view('product_loan_summery_report',$data);
        }
        else
            redirect ("login");
    }

   
}
