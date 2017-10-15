<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stocktransfer extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        $this->load->database();
        $this->load->model('product_model');
        $this->load->model('client_model');
        $this->load->model('purchase_model');
        $this->load->model('location_model');
        $this->load->model('transfer_model');
        $currentMenue = array('activeSidebar' => 'inventory');
        $this->session->set_userdata($currentMenue);
    }
    public function index()
    {
        if($this->session->has_userdata('username')){
            $data["transferList"] = $this->transfer_model->getTransferList('2');
            $this->load->view('transfer_view',$data);
        }
        else
            redirect ("login");
    }
    public function unapprovedtransfer()
    {
        if($this->session->has_userdata('username')){
            $data["transferList"] = $this->transfer_model->getTransferList('0');
            $data["listTitel"] = "Unapproved Stock Transfer List";
            $this->load->view('transfer_view',$data);
        }
        else
            redirect ("login");
    }
    public function receivetransfer()
    {
        if($this->session->has_userdata('username')){
            $data["transferList"] = $this->transfer_model->getTransferList('1');
            $data["listTitel"] = "Receive Stock Transfer from List";
            $this->load->view('transfer_view',$data);
        }
        else
            redirect ("login");
    }
    public function transfer()
    {
        if($this->session->has_userdata('username')){
            if ($this->input->post('btn_save') == "Save"){
               // print_r($_POST);
                $transferNumber = $this->input->post("transferNumber");
                $transferDate = date('Y-m-d',  strtotime($this->input->post("datemask")));
                $toLocation = $this->input->post("toLocation");
                $fromLocation = $this->input->post("fromLocation");
                $totalItemRow = $this->input->post("totalItemRow");
                $products = $this->input->post("productid");
                $productsQty = $this->input->post("productQty");
                $productsPackage = $this->input->post("productPackge");
                $productsRemarks = $this->input->post("productRemarks");
                //set validations
                $this->form_validation->set_rules("transferNumber", "Transfer Number", "trim|required");
                $this->form_validation->set_rules("datemask", "Receip Date", "trim|required");
                $this->form_validation->set_rules("fromLocation", "Transfer From ", "trim|required");
                $this->form_validation->set_rules("toLocation", "Transfer To", "trim|required");
                $this->form_validation->set_rules("totalItemRow", "total product", "trim|required");
                if ($this->form_validation->run() == FALSE){
                        //validation fails
                        redirect('stocktransfer/transfer');
                        //$this->load->view('login_view');
                }
                else{
                        for($i=0;$i<$totalItemRow;$i++){
                        $transferArray[$i] = array(
                                        'transfer_number' => $transferNumber,
                                        'transfer_date' => $transferDate,
                                        'location_from' => $fromLocation,
                                        'location_to' => $toLocation,
                                        'product_id' => $products[$i],
                                        'quantity' => $productsQty[$i],
                                        'package' => $productsPackage[$i],
                                        'remarks' => $productsRemarks[$i],
                                        'entry_by' => $this->session->userdata('username')
                                    );
                        }
                        $orderResult = $this->transfer_model->createStockTransfer($transferArray);
                        if($orderResult > 0) //active user record is present
                        {
                           redirect('stocktransfer/unapprovedtransfer');

                        }

                    }
            }
            else {
                $data['transferNumber'] = $this->transfer_model->getTransferNumber();
                $data["locationList"] = $this->location_model->getLocations();
                $data["productList"] =  $this->product_model->get_product();
                $data["partyList"]  = $this->client_model->get_client();
                $this->load->view('stock_transfer_entry_view',$data);
            }
        }
        else
            redirect ("login");
    }

    function viewstocktransfer($transferNumber)
    {
        if($this->session->has_userdata('username')){
            $data['transferDetails'] = $this->transfer_model->getTransfer($transferNumber);
            $this->load->view('transfer_details_view',$data);
        }  else {
            redirect ("login");
        }
    }

    function printstocktransfer($transferNumber)
    {
        if($this->session->has_userdata('username')){
            $data['transferDetails'] = $this->transfer_model->getTransfer($transferNumber);
            $this->load->view('transfer_print_view',$data);
        }  else {
            redirect ("login");
        }
    }

    function updatestockstransfer($transferNumber, $statusValue)
    {
        if($this->session->has_userdata('username')){

            if($statusValue==1){
                $stustUpdateData = array(
                    'status'=>$statusValue,
                    'approved_by' => $this->session->userdata('username')
                );
            }elseif ($statusValue==2) {
                $stustUpdateData = array(
                    'status'=>$statusValue
                );
            }

            $updateRow = $this->transfer_model->updateStatus($transferNumber,$stustUpdateData);
            if($statusValue==2)
                redirect('stocktransfer/receivetransfer');
            else if($statusValue==1)
                redirect('stocktransfer/unapprovedtransfer');
            else
                redirect('stocktransfer');
        }  else {
            redirect ("login");
        }
    }


}
