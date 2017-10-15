<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Freesample extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        $this->load->database();
        $this->load->model('product_model');
        $this->load->model('client_model');
        $this->load->model('purchase_model');
        $this->load->model('location_model');
        $this->load->model('sample_model');
        $currentMenue = array('activeSidebar' => 'inventory');
        $this->session->set_userdata($currentMenue);
    }
    public function index()
    {
        if($this->session->has_userdata('username')){
            $data["sampleList"] = $this->sample_model->getSampleList('1');
            $this->load->view('freesample_view',$data);
        }
        else
            redirect ("login");
    }

    public function sampleforreturn()
    {
        if($this->session->has_userdata('username')){
            $data["sampleList"] = $this->sample_model->getSampleList('1');
            $this->load->view('sample_for_return',$data);
        }
        else
            redirect ("login");
    }

    public function samplereturn($sampleNumber)
    {
        if($this->session->has_userdata('username')){
            if ($this->input->post('btn_save') == "Save"){
                print_r($_POST);
                $sampleReturnDate = date('Y-m-d',  strtotime($this->input->post("datemask")));
                $client = $this->input->post("client");
                $totalItemRow = $this->input->post("totalItemRow");
                $products = $this->input->post("productid");
                $usedQuantity = $this->input->post("usedQuantity");
                $returnQuantity = $this->input->post("returnQuantity");
                $remarks = $this->input->post("deliverRemarks");
				$stockLocation = $this->input->post("stockLocation");
                for($i=0;$i<count($products);$i++){
                    $sampleArray = array(
                                    'return_date' => $sampleReturnDate,
                                    'used_quantity' => $usedQuantity[$i],
                                    'return_quantity' => $returnQuantity[$i],
                                    'return_remarks' => $remarks[$i],
                                    'return_entry_by' => $this->session->userdata('username'),
                                    'status' => 2
                                );
                            //    print_r($sampleArray);
                    $this->sample_model->sampleReturn($sampleNumber,$products[$i],$sampleArray);
                }
                redirect('freesample/sampleforreturn');
            } else {
                $data["locationList"] = $this->location_model->getLocations();
                $data['sampleDetails'] = $this->sample_model->getSample($sampleNumber);
                $this->load->view('sample_return_entry_view',$data);
            }
        }  else {
            redirect ("login");
        }
    }
    public function upapprovereturns()
    {
        if($this->session->has_userdata('username')){
            $data["sampleList"] = $this->sample_model->getSampleList('2');
            $this->load->view('unapprove_sample_returns',$data);
        }
        else
            redirect ("login");
    }

    function approvereturn($sampleNumber)
    {
        if($this->session->has_userdata('username')){

            $stustUpdateData = array(
                'status'=>3,
                'return_approved_by' => $this->session->userdata('username')
            );
            $updateRow = $this->sample_model->updateStatus($sampleNumber,$stustUpdateData);
            //if($updateRow>0)
            redirect('freesample/unapprovesample');

        }  else {
            redirect ("login");
        }
    }

    public function unapprovesample()
    {
        if($this->session->has_userdata('username')){
            $data["sampleList"] = $this->sample_model->getSampleList('0');
            $data["listTitel"] = "Unapprove Free Sample List";
            $this->load->view('freesample_view',$data);
        }
        else
            redirect ("login");
    }

    public function sampleCreate()
    {
        if($this->session->has_userdata('username')){
            if ($this->input->post('btn_save') == "Save"){
               // print_r($_POST);
                $sampleNumber = $this->input->post("sampleNumber");
                $sampleDeliveryDate = date('Y-m-d',  strtotime($this->input->post("datemask")));
                $client = $this->input->post("client");
                $totalItemRow = $this->input->post("totalItemRow");
                $products = $this->input->post("productid");
                $productsQty = $this->input->post("productQty");
                $productsPackage = $this->input->post("productPackge");
                $productsRemarks = $this->input->post("productRemarks");
				$stockLocation = $this->input->post("stockLocation");

                //set validations
                $this->form_validation->set_rules("sampleNumber", "Sample Number", "trim|required");
				$this->form_validation->set_rules("stockLocation", "Location", "trim|required");
                $this->form_validation->set_rules("datemask", "Receip Date", "trim|required");
                $this->form_validation->set_rules("client", "Client Name ", "trim|required");

                $this->form_validation->set_rules("totalItemRow", "total product", "trim|required");
                if ($this->form_validation->run() == FALSE){
                    //validation fails
                    redirect('freesample/sampleCreate');
                    //$this->load->view('login_view');
                }
                else{
                    for($i=0;$i<$totalItemRow;$i++){
                        $sampleArray[$i] = array(
                                        'sample_number' => $sampleNumber,
                                        'sample_delivery_date' => $sampleDeliveryDate,
                                        'client_id' => $client,
                                        'product_id' => $products[$i],
                                        'quantity' => $productsQty[$i],
                                        'package' => $productsPackage[$i],
                                        'remarks' => $productsRemarks[$i],
										'location_id' => $stockLocation,
                                        'entry_by' => $this->session->userdata('username')
                                    );
                    }
                    $sampleResult = $this->sample_model->createFreeSample($sampleArray);
                    if($sampleResult > 0) {
                       redirect('freesample/unapprovesample');
                    }
                }
            }
            else {
                $data['sampleNumber'] = $this->sample_model->getSampleNumber();
                $data["clientList"] = $this->client_model->get_client();
                $data["productList"] =  $this->product_model->get_product();
				$data["locationList"] = $this->location_model->getLocations();
                $this->load->view('free_sample_entry_view',$data);
            }
        }
        else
            redirect ("login");
    }

    function viewsfreesample($sampleNumber)
    {
        if($this->session->has_userdata('username')){
            $data['sampleDetails'] = $this->sample_model->getSample($sampleNumber);
            $this->load->view('sample_details_view',$data);
        }  else {
            redirect ("login");
        }
    }

    function viewsfreesamplereturn($sampleNumber)
    {
        if($this->session->has_userdata('username')){
            $data['sampleDetails'] = $this->sample_model->getSample($sampleNumber);
            $this->load->view('sample_return_details_view',$data);
        }  else {
            redirect ("login");
        }
    }

    function printfreesample($sampleNumber)
    {
        if($this->session->has_userdata('username')){
            $data['sampleDetails'] = $this->sample_model->getSample($sampleNumber);
            $this->load->view('sample_print_view',$data);
        }  else {
            redirect ("login");
        }
    }

    function updatefreesample($sampleNumber, $statusValue)
    {
        if($this->session->has_userdata('username')){

            $stustUpdateData = array(
                'status'=>$statusValue,
                'approved_by' => $this->session->userdata('username')
            );
            $updateRow = $this->sample_model->updateStatus($sampleNumber,$stustUpdateData);
            //if($updateRow>0)
            redirect('freesample/unapprovesample');

        }  else {
            redirect ("login");
        }
    }

	public function productwisesample()
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

				$data["transectionData"] = $products = $this->sample_model->productwisesample($fromDate, $toDate, $productId, $clientId);


            }
            $this->load->view('product_sample_report',$data);
        }
        else
            redirect ("login");
    }

	public function datewisesample()
    {
        if($this->session->has_userdata('username')){
            $currentMenue = array('activeSidebar' => 'reports');
            $this->session->set_userdata($currentMenue);
            $data = array();
            $data['clientList'] = $this->client_model->get_client();
            if ($this->input->post('btn_save') == "Show"){
                $clientId = (int)$this->input->post("client");
                if($this->input->post("toDate")==''||$this->input->post("fromDate")==''){
                    $data["fromDate"]=$data["toDate"]=$fromDate=$toDate=NULL;
                }else{
					$fromDate = $data["fromDate"] = date('Y-m-d',  strtotime($this->input->post("fromDate")));
					$toDate = $data["toDate"] = date('Y-m-d',  strtotime($this->input->post("toDate")));
                }

				$data["transectionData"] = $products = $this->sample_model->getdatewiseSample($clientId, $fromDate, $toDate);


            }
            $this->load->view('date_sample_report',$data);
        }
        else
            redirect ("login");
    }


}
