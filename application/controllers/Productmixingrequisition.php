<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Productmixingrequisition extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
     
        $this->load->database();
        $this->load->model('product_model');
        $this->load->model('productmixing_model');
		$this->load->model('location_model');
        $currentMenue = array('activeSidebar' => 'production');
        $this->session->set_userdata($currentMenue);
    }
    public function index()
    {
        if($this->session->has_userdata('username')){
			$data["productMixingList"] = $this->productmixing_model->getMixingRequisitionList('2');
            $this->load->view('requisition_mixing_view',$data);
        }
        else
            redirect ("login");
    }
    public function unapprovemixing()
    {
        if($this->session->has_userdata('username')){
            $data["productMixingList"] = $this->productmixing_model->getMixingRequisitionList('0');
            $data["listTitel"] = "Unapproved Product Mixing Requisition List";
            $this->load->view('requisition_mixing_view',$data);
        }
        else
            redirect ("login");
    }
    
     public function mixingconversion()
    {
        if($this->session->has_userdata('username')){
            $data["productMixingList"] = $this->productmixing_model->getMixingRequisitionList('1');
            $data["listTitel"] = "Mixing Requisition List for conversion";
            $this->load->view('requisition_mixing_view',$data);
        }
        else
            redirect ("login");
    }
    public function mixingRequisitionCreate()
    {
        if($this->session->has_userdata('username')){
            if ($this->input->post('btn_save') == "Save"){
               // print_r($_POST);
                $newProduct = $this->input->post("ckNewProduct");
                $productModel = $this->input->post("productModel");
                $productName = $this->input->post("productName");
                $productDescription = $this->input->post("newProductDescription");
                
                $requisitionNumber = $this->input->post("requisitionNumber");
                $requisitonDate = date('Y-m-d',  strtotime($this->input->post("datemask")));
                $totalItemRow = $this->input->post("totalItemRow");
                $products = $this->input->post("productid");
                $productsQty = $this->input->post("productQty");
                $productsRate = $this->input->post("productRate");
				$stockLocation = $this->input->post("stockLocation");
                $reqForProductId = $this->input->post("productId");
                //set validations
                if($newProduct){
                    $this->form_validation->set_rules("productModel", "Product Model", "trim|required");
                    $this->form_validation->set_rules("productName", "Product Name", "trim|required");
                    $this->form_validation->set_rules("productDescription", "Product Name", "trim|required");
                }else{
                    $this->form_validation->set_rules("productId", "Product ", "trim|required");
                }
                $this->form_validation->set_rules("requisitionNumber", "Requisition Number", "trim|required");
                $this->form_validation->set_rules("stockLocation", "Location", "trim|required");
                $this->form_validation->set_rules("datemask", "Requisition Date", "trim|required");
                
                
                $this->form_validation->set_rules("totalItemRow", "total product", "trim|required");
                if ($this->form_validation->run() == FALSE){
                        //validation fails
                        redirect('productmixingrequisition/mixingRequisitionCreate');
                        //$this->load->view('login_view');
                }
                else{
                     // create new product
                    if($newProduct){
                        $productArray = array(
                                            'product_name' => $productName,
                                            'product_model' => $productModel,
                                            'product_category' => 1,
                                            'product_description' => $productDescription,
                                            'product_unit' => 'KG'
                                        );
                        $reqForProductId = $this->product_model->create_product($productArray);
                    } 
                    for($i=0;$i<$totalItemRow;$i++){
                        $requisitionArray[$i] = array(
                                        'requisition_number' => $requisitionNumber,
                                        'requisition_date' => $requisitonDate,
                                        'product_id' => $products[$i],
                                        'quantity' => $productsQty[$i],
                                        'rate' => $productsRate[$i],
                                        'location_id' => $stockLocation,
										'req_for_product_id' => $reqForProductId,
                                        'entry_by' => $this->session->userdata('username')
                                    );
                    }
                    $loanResult = $this->productmixing_model->createMixingRequisition($requisitionArray);
                    if($loanResult > 0) //active user record is present
                    {
                       redirect('productmixingrequisition');

                    }

                }
            }
            else {
                $data['requisitionNumber'] = $this->productmixing_model->getMixingRequisitionNumber();
				$data["locationList"] = $this->location_model->getLocations();
                $data["productList"] =  $this->product_model->get_product();
                
                $this->load->view('requisition_mixing_entry_view',$data);
            }
        }
        else
            redirect ("login");
    }
    public function getproductrate($productId)
    {
        if($this->session->has_userdata('username')){
            $product = $this->product_model->get_product($productId);
            echo $product[0]["product_rate"];
            //return json_encode($products[0]);
        }
        else
            echo "";
    }

    public function getproductrecipe($productId)
    {
        if($this->session->has_userdata('username')){
            $requirProducts = $this->productmixing_model->getcrecipe($productId);
           echo json_encode($requirProducts);
        }
        else
            echo "";
    }

    function viewsmixingrequisition($requisitionNumber)
    {
        if($this->session->has_userdata('username')){
            $data['requisitionDetails'] = $this->productmixing_model->getMixingRequisition($requisitionNumber);
            $data['conversionDetails'] = $this->productmixing_model->getConvertedProduct($requisitionNumber);
            $this->load->view('requisition_mixing_details_view',$data);
        }  else {
            redirect ("login");
        }
    }
    
    function printmixingrequisition($requisitionNumber)
    {
        if($this->session->has_userdata('username')){
            $data['requisitionDetails'] = $this->productmixing_model->getMixingRequisition($requisitionNumber);
			$data['conversionDetails'] = $this->productmixing_model->getConvertedProduct($requisitionNumber);
            $this->load->view('requisition_mixing_print_view',$data);
        }  else {
            redirect ("login");
        }
    }
    
    function requisitionconversion($requisitionNumber)
    {
        if($this->session->has_userdata('username')){
            if ($this->input->post('btn_save') == "Save"){
                $newProduct = $this->input->post("ckNewProduct");
                $productModel = $this->input->post("productModel");
                $productName = $this->input->post("productName");
                $productDescription = $this->input->post("productDescription");
                $newQty = $this->input->post("newQty");
                $unit = $this->input->post("unit");
                $newRate = $this->input->post("newRate");
                $totalItemRow = $this->input->post("totalItemRow");
                $productId = $this->input->post("productId");
				$stockLocation = $this->input->post("stockLocation");
                //set validations
                if($newProduct){
                    $this->form_validation->set_rules("productModel", "Product Model", "trim|required");
                    $this->form_validation->set_rules("productName", "Product Name", "trim|required");
                    $this->form_validation->set_rules("productDescription", "Product Name", "trim|required");
                }else{
                    $this->form_validation->set_rules("productId", "Product ", "trim|required");
                }
                $this->form_validation->set_rules("stockLocation", "Location", "trim|required");
                $this->form_validation->set_rules("newQty", "Product Name", "trim|required");
                $this->form_validation->set_rules("newRate", "Product Name", "trim|required");
                
               // $this->form_validation->set_rules("totalItemRow", "total product", "trim|required");
                if ($this->form_validation->run() == FALSE){
                  
                    redirect('productmixingrequisition/requisitionconversion/'.$requisitionNumber);
                    //$this->load->view('login_view');
                }
                else{
                    // stock out
                    $this->product_model->stock_out_as_requisition($requisitionNumber);
                       
                    // create new product
                    if($newProduct){
                        $productArray = array(
                                        'product_name' => $productName,
                                        'product_model' => $productModel,
                                        'product_category' => 1,
                                        'product_description' => $productDescription,
                                        'product_unit' => $unit
                                    );
                        $productId = $this->product_model->create_product($productArray);
                    }   
                 
                    // stock recieve
                    if($productId>0){
                        $stockReceiveArray = array(
                            'stock_receive_type' => "Product Conversion",
                            'referrence_number' => $requisitionNumber,
                            'stock_receive_date' => date('Y-m-d'),
                            'product_id'=> $productId,
                            'quantity' => $newQty,
                            'rate' => $newRate,
                            'location_id' => $stockLocation,
                            'entry_by' => $this->session->userdata('username')
                        );
                        $productRate= $newProduct ? $newRate : $this->ratecalculation($productId,$newQty,$newRate);
                        $updateProductRateArray[0] = array('product_id'=> $productId,'product_rate' => $productRate);
                        $this->product_model->product_recipe($requisitionNumber,$productId,$newQty);
                        $receiveId = $this->product_model->stock_receive($stockReceiveArray);
                        $this->product_model->update_product_rate($updateProductRateArray);
                        if($receiveId>0)
                            $this->updaterequisition($requisitionNumber, 2);
                    }
                }
            }
            else{
                $data['requisitionDetails'] = $this->productmixing_model->getMixingRequisition($requisitionNumber);
				$data["locationList"] = $this->location_model->getLocations();
                $data["productList"] =  $this->product_model->get_product();
                $this->load->view('mixing_conversion_view',$data);
            }
        }  else {
            redirect ("login");
        }
    }
    
    function ratecalculation($productId,$currentQty,$currentRate)
    {
        $previousRate = $this->product_model->getrate($productId);
        $totalReceive = $this->product_model->totalReceive($productId);
		$totalOut = $this->product_model->totalOut($productId);
		$balance = $totalReceive - $totalOut; 
		$newRate = $currentRate; 
		if($previousRate>0){
			if($balance>0){
				$newRate = (($currentQty*$currentRate)+ ($balance*$previousRate))/($currentQty+$balance);
			}
		}
		return $newRate;
    }
    
    function updaterequisition($requisitionNumber, $statusValue)
    {
        if($this->session->has_userdata('username')){
            
            $stustUpdateData = array(
                'status'=>$statusValue,
                'approved_by' => $this->session->userdata('username')
            );
            $updateRow = $this->productmixing_model->updateStatus($requisitionNumber,$stustUpdateData);
            //if($updateRow>0)
            redirect('productmixingrequisition/unapprovemixing');
                
        }  else {
            redirect ("login");
        }
    }
	
	public function conversionproduct()
    {
        if($this->session->has_userdata('username')){
            
            $data = array();
             if ($this->input->post('btn_save') == "Show"){
                if($this->input->post("toDate")==''||$this->input->post("fromDate")==''){
                    $data["fromDate"]=$data["toDate"]=$fromDate=$toDate=NULL;
				}else{
					$fromDate = $data["fromDate"] = date('Y-m-d',  strtotime($this->input->post("fromDate")));
					$toDate = $data["toDate"] = date('Y-m-d',  strtotime($this->input->post("toDate")));
				}
				
				$data["transectionData"] = $products = $this->productmixing_model->getconversioninfo($fromDate,$toDate);           
			}
            $this->load->view('product_convertion_report',$data);
        }
        else
            redirect ("login");
    }
    
    

   
}
