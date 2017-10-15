<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends CI_Controller {
    
    public function __construct()
    {
        parent::__construct();
     
        $this->load->database();
        $this->load->model('product_model');
        $this->load->model('location_model');
        $this->load->model('client_model');
        $this->load->library('products');
        $currentMenue = array('activeSidebar' => 'inventory');
        $this->session->set_userdata($currentMenue);
    }
	
    public function index()
    {
        if($this->session->has_userdata('username')){
            $data["categoryList"] = $categories = $this->product_model->get_category();
            $data["productList"] = $products = $this->product_model->get_product();
			$data["productDetails"] = "";
            $this->load->view('product_view',$data);
        }
        else
            redirect ("login");
    }
	
	public function editproduct($productId)
    {
        if($this->session->has_userdata('username') && $this->session->userdata('userType')=="admin"){
            $data["categoryList"] = $categories = $this->product_model->get_category();
            $data["productList"] = $products = $this->product_model->get_product();
            $data["productDetails"] = $products = $this->product_model->get_product($productId);
            $this->load->view('product_view',$data);
        }
        else
            redirect ("login");
    }
    
    public function create_product($productId=NULL)
    {
        if($this->session->has_userdata('username')){

            //get the posted values
            $productCategory = $this->input->post("productCategory");
            $productName = $this->input->post("productName");
            $productModel = $this->input->post("productModel");
            $productDescription = $this->input->post("productDescription");
            $productUnit = $this->input->post("productUnit");
            //set validations
            //$this->form_validation->set_rules("productCategory", "Catetory", "trim|required");
            $this->form_validation->set_rules("productName", "Product Name", "trim|required");
            $this->form_validation->set_rules("productModel", "Product Model", "trim|required");

            if ($this->form_validation->run() == FALSE)
            {
                //validation fails
                redirect('product/index');
                //$this->load->view('login_view');
            }
            else
            {
                //validation succeeds
                if ($this->input->post('btn_save') == "Save Product")
                {
                    //check if username and password is correct
                    $productArray = array(
                                            'product_name' => $productName,
                                            'product_model' => $productModel,
                                            'product_category' => $productCategory,
                                            'product_description' => $productDescription,
                                            'product_unit' => $productUnit
                                        );
					if($productId!==NULL){
						if($this->session->userdata('userType')=="admin")
							$productResult = $this->product_model->update_product($productId,$productArray);
						else
							redirect('product/index');
					} else{
						$productResult = $this->product_model->create_product($productArray);
					}
                    if ($productResult > 0) //active user record is present
                    {
                       redirect('product/index');

                    }
                    else
                    {
                        $this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">Invalid username and password!</div>');
                        redirect('login/index');
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
    
    public function stockreport()
    {
        $currentMenue = array('activeSidebar' => 'reports');
        $this->session->set_userdata($currentMenue);
        if($this->session->has_userdata('username')){
           $locationId = $this->session->userdata('locationId');
            if($locationId>0){
                    $currentLocation = $this->location_model->getLocations($locationId);
                    $data["locationName"] = $currentLocation[0]["location_name"];
                }
                else{
                    $data["locationName"] = "";
                }   
            $data["stockData"] = $products = $this->product_model->store_summery_query($locationId);
            $data["locationId"] = $locationId;
            $this->load->view('stock_report',$data);
        }
        else
            redirect ("login");
    }
    public function datestockreport()
    {
        $currentMenue = array('activeSidebar' => 'reports');
		$locationId = 0;
        $this->session->set_userdata($currentMenue);
        if($this->session->has_userdata('username')){
            $data = array();
            if ($this->input->post('btn_save') == "Show Report"){
                if($this->input->post("toDate")==''||$this->input->post("fromDate")==''){
                    $data["fromDate"]=$data["toDate"]=$fromDate=$toDate=NULL;
                }else{
                $fromDate = $data["fromDate"] = date('Y-m-d',  strtotime($this->input->post("fromDate")));
                $toDate = $data["toDate"] = date('Y-m-d',  strtotime($this->input->post("toDate")));
                }
                $locationId  = $this->input->post("stockLocation");
                //set validations
                $this->form_validation->set_rules("fromDate", "Date From", "trim|required");
                $this->form_validation->set_rules("toDate", "Date To", "trim|required");
                
                if($locationId>0){
                    $currentLocation = $this->location_model->getLocations($locationId);
                    $data["locationName"] = $currentLocation[0]["location_name"];
                }
                else{
                        $data["locationName"] = "";
                }
                
               // if ($this->form_validation->run() == TRUE)
                {                    
                    $data["stockData"] = $products = $this->product_model->store_summery_query($locationId,$fromDate,$toDate);
                    foreach ($products as $product) {
                        $productRate[$product['product_id']]=$this->products->getproductavgrate($product['product_id'],$toDate);
                    }
                }
                $data["productRate"]= $productRate;
                
            }
			$data["locationId"] = $locationId;
            $data["locationList"] = $this->location_model->getLocations();
            $this->load->view('date_stock_report',$data);
        }
        else
            redirect ("login");
    }

    public function printstockreport($location=0,$fromDate=NULL,$toDate=NULL)
    {
        if($this->session->has_userdata('username')){
            
            $data["toDate"] = $toDate;
            $data["fromDate"] = $fromDate;
            if($location>0){
                $currentLocation = $this->location_model->getLocations($location);
                $data["locationName"] = $currentLocation[0]["location_name"];
            }
            else{
                    $data["locationName"] = "";
					//$location = ;
            }
            $data["stockData"] = $products = $this->product_model->store_summery_query($location,$fromDate,$toDate);
            foreach ($products as $product) {
                $productRate[$product['product_id']]=$this->products->getproductavgrate($product['product_id'],$toDate);
            }
            $data["productRate"]= $productRate;
            $this->load->view('stock_report_print',$data);
        }  
        else {
            redirect ("login");
        }
    }

    public function producttransectionout()
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

                $data["transectionData"] = $products = $this->product_model->getproducttransection($fromDate, $toDate, $clientId,$productId);


            }
            $this->load->view('product_transection_out_report',$data);
        }
        else
            redirect ("login");
    }
	
	public function productledger()
    {
        if($this->session->has_userdata('username')){
            $currentMenue = array('activeSidebar' => 'reports');
            $this->session->set_userdata($currentMenue);
            $data = array();
            $data["productList"] =  $this->product_model->get_product();
            if ($this->input->post('btn_save') == "Show"){
                $productId = $this->input->post("product");
				$data["productDetails"]=$this->product_model->get_product($productId);
				if($this->input->post("toDate")==''||$this->input->post("fromDate")==''){
                    $data["fromDate"]=$data["toDate"]=$fromDate=$toDate=NULL;
                    $data["openingBalance"] = 0;
					$data["openingBalanceAmount"] = 0;
                }else{
                $fromDate = $data["fromDate"] = date('Y-m-d',  strtotime($this->input->post("fromDate")));
                $toDate = $data["toDate"] = date('Y-m-d',  strtotime($this->input->post("toDate")));
				$productBalance = $this->product_model->productopeningbalance($productId,$fromDate);
                //print_r($productBalance);

                $data["openingBalance"] = $productBalance[0]["openingbalance"];
                $data["openingRate"] = $openingRate = $this->products->getproductavgrate($productId,date('Y-m-d', strtotime('-1 day', strtotime($fromDate))));
				$data["openingBalanceAmount"] = $productBalance[0]["openingbalance"]*$openingRate;
				}
				
				$data["transectionData"] = $products = $this->product_model->productwisetransection($productId,$fromDate,$toDate);           
			}
            $this->load->view('product_ledger_report',$data);
        }
        else
            redirect ("login");
    }

    

}
