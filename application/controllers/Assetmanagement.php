<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Assetmanagement extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model('bank_model');
        $this->load->model('client_model');
        $this->load->model('sales_model');
        $this->load->model('purchase_model');
        $this->load->model('location_model');
        $this->load->model('accounts_model');
        $this->load->model('chartofaccounts_model');
        $this->load->model('lc_model');
        $this->load->model('product_model');
        $this->load->model('asset_model');
        $currentMenue = array('activeSidebar' => 'Asset Mamanagement');
        $this->session->set_userdata($currentMenue);
    }

    public function index()
    {
        if($this->session->has_userdata('username')){
            $this->load->view('assetmanagement_view');
        }
        else{
            redirect ("login");
        }
    }

    public function assetentry()
    {
        if($this->session->has_userdata('username')){
            if($this->input->post('btn_save') == "Save Asset"){
                $assetType = $this->input->post("assetType");
                $assetName = $this->input->post("assetName");
                $purchaseDate = date('Y-m-d',  strtotime($this->input->post("purchaseDate")));
                $purchaseValue = $this->input->post("purchaseValue");
                $currentValue = $this->input->post("currentValue");
                $depreciationRate = $this->input->post("depreciationRate");
                
                //set validations
                $this->form_validation->set_rules("assetType", "Number", "trim|required");
                $this->form_validation->set_rules("assetName", "Name", "trim|required");
                $this->form_validation->set_rules("purchaseValue", "Name", "trim|required");
                $this->form_validation->set_rules("currentValue", "Name", "trim|required");
                $this->form_validation->set_rules("depreciationRate", "Name", "trim|required");
                $this->form_validation->set_rules("purchaseDate", "Name", "trim|required");

                if ($this->form_validation->run() == FALSE) {
                    //validation fails
                    redirect('assetmanagement/assetentry');
                } else {
                    $assetArray = array(
                                'asset_type' => $assetType,
                                'asset_name' => $assetName,
                                'purchase_date' => $purchaseDate,
                                'purchase_value' => $purchaseValue,
                                'current_value' => $currentValue,
                                'depreciation_rate' => $depreciationRate,
                                'entry_by' => $this->session->userdata('username'),
                                'entry_date' => date('Y-m-d') 
                            );
                    $this->asset_model->create_asset($assetArray);
                    redirect('assetmanagement/assetentry');
                }

            } else {
                $data['assetList'] = $this->asset_model->get_asset();
                $this->load->view('asset_entry_view',$data);
            }
            
        }
        else{
            redirect ("login");
        }
    }

    public function assetlist()
    {
        if($this->session->has_userdata('username')){
            $data['assetList'] = $this->asset_model->get_asset();
            $this->load->view('asset_list_view',$data);
        }
    }

    public function getassetdetails($assetId)
    {
        if($this->session->has_userdata('username')){
            $assetdetails = $this->asset_model->get_asset($assetId);
            echo json_encode($assetdetails);
        }
    }

    public function addexpense()
    {
        if($this->session->has_userdata('username')){
            $assetId = $this->input->post("modAssetId");
            $expDescription = $this->input->post("expDescription");
            $expensesAmount = $this->input->post("expensesAmount");
            $expensesDate = date('Y-m-d',  strtotime($this->input->post("expensesDate")));
            //set validations
            $this->form_validation->set_rules("modAssetId", "Asset ID", "trim|required");
            $this->form_validation->set_rules("expDescription", "Expenses Description", "trim|required");
            $this->form_validation->set_rules("expensesAmount", "Expenses Amount", "trim|required");
            $this->form_validation->set_rules("expensesDate", "Expenses Date", "trim|required");

            if ($this->form_validation->run() == FALSE){
                //validation fails
                echo "4";
            }
            else{
                  
                if($expensesAmount && $expensesAmount>0){
                    $dataArray = array(
                        'asset_id' => $assetId,
                        'expenses_date' => $expensesDate,
                        'expenses_description' => $expDescription,
                        'expenses_amount' => $expensesAmount,
                        'entry_by' => $this->session->userdata('username'),
                        'entry_date' => date('Y-m-d h:i:s')
                    );
                    $result = $this->asset_model->additional_expenses($dataArray);
                    
                    echo "1";
                }else{
                    echo '0';
                }
            }
        } else{
            echo '2';
        }
    }

    public function calculatedepreciation()
    {
        if($this->session->has_userdata('username')){
            $data['assetType']=$assetType = $this->input->post("assetType");
            $data['assetList'] =array();
            if ($this->input->post('btn_save') == "Show Report"){
                $data['assetList'] = $this->asset_model->get_asset_by_type($assetType);
                
            }
            $this->load->view('asset_depreciation_calculation_view',$data);
        }
    }

    public function savedepreciation()
    {
        if($this->session->has_userdata('username')){
            
            if ($this->input->post('btn_save_dep') == "Save"){
                print_r($_POST);
                $depreciationAsset = $this->input->post("depreciationAsset");
                $assetId = $this->input->post("assetId");
                $assetQty = $this->input->post("assetQty");
                $currentValue = $this->input->post("currentValue");
                $additionalValue = $this->input->post("additionalValue");
                $balanceforDepreciation = $this->input->post("balanceforDepreciation");
                $depreciationRate = $this->input->post("depreciationRate");
                $depreciation = $this->input->post("depreciation");
                $balanceAfterDepreciaton = $this->input->post("balanceAfterDepreciaton");
                $totalTypeDepreciation = $this->input->post("totalTypeDepreciation");
                $totalTypeBalanceAfter = $this->input->post("totalTypeBalanceAfter");
                for($i=0;$i<count($assetId);$i++){
                    $assetDepreciation = array(
                        'depreciation_year' => date('Y'),
                        'asset_id' => $assetId[$i],
                        'asset_qty' => $assetQty[$i],
                        'current_value' => $currentValue[$i],
                        'additional_value' => $additionalValue[$i],
                        'balance_before_depreciation' => $balanceforDepreciation[$i],
                        'depreciation_rate' => $depreciationRate[$i],
                        'depreciation' => $depreciation[$i],
                        'balance_after_depreciation' => $balanceAfterDepreciaton[$i],
                        'entry_by' => $this->session->userdata('username'),
                        'entry_date' => date('Y-m-d')
                    );
                    //save asset depreciation
                    $this->asset_model->asset_depreciation($assetDepreciation);
                }

                $drHeadId = '';
                $crHeadId = '';

                if($depreciationAsset=='Vehicle'){
                    $drHeadId = 111;
                    $crHeadId = 95;
                } else if($depreciationAsset=='Office Equipments'){
                    $drHeadId = 11;
                    $crHeadId = 10;
                } else if($depreciationAsset=='Electrical Equipments'){
                    $drHeadId = 9;
                    $crHeadId = 8;
                } else if($depreciationAsset=='Office Decoration'){
                    $drHeadId = 112;
                    $crHeadId = 87;
                } else if($depreciationAsset=='Furniture & Fixture'){
                    $drHeadId = 113;
                    $crHeadId = 99;
                }
                //create depreciation voucher
                $voucherDate = date('Y').'-06-30';
                $voucherNumber = $this->accounts_model->get_voucher_number('journal',$voucherDate );
                // master entry
                $voucherArray = array(
                        'voucher_number' => $voucherNumber,
                        'voucher_date' => $voucherDate ,
                        'voucher_type' => 'journal',
                        'party_id' => '118',
                        'description' => 'Depreciaton for '. $depreciationAsset,
                        'entry_by' => $this->session->userdata('username'),
                        'entry_date' => date('Y-m-d')
                    );
                $voucherId= $this->accounts_model->create_voucher($voucherArray);
                $voucherDetalsArray = array();
                // transection depreciation [Dr.]
                $voucherDetailsArray = array(
                      'voucher_id' => $voucherId,
                      'accounts_head_id' => $drHeadId,
                      'particulers' => 'Depreciaton for '. $depreciationAsset,
                      'transection_type' => 'Dr',
                      'amount' => $totalTypeDepreciation,
                      'entry_by' => $this->session->userdata('username'),
                      'entry_date' => date('Y-m-d')
                  );
                $voucherResult = $this->accounts_model->create_voucher_details($voucherDetailsArray);
                // transectio against asset [cr.]
                $voucherDetailsArray= array(
                    'voucher_id' => $voucherId,
                    'accounts_head_id' => $crHeadId,
                    'particulers' =>'Depreciaton for '. $depreciationAsset,
                    'transection_type' => 'Cr',
                    'amount' => $totalTypeDepreciation,
                    'entry_by' => $this->session->userdata('username'),
                    'entry_date' => date('Y-m-d')
                );
                $voucherResult = $this->accounts_model->create_voucher_details($voucherDetailsArray);
                redirect('assetmanagement/calculatedepreciation');
            }
            
        }
    }

    public function depreciation()
    {
        if($this->session->has_userdata('username')){
            $data['assetType']=$assetType = $this->input->post("assetType");
            $data['depreceationYear']=$depreceationYear= $this->input->post("depreceationYear");
            $data['assetList'] =array();
            if ($this->input->post('btn_save') == "Show Report"){
                $data['assetList'] = $this->asset_model->get_asset_depreciation($depreceationYear,$assetType);                
            }
            $this->load->view('asset_depreciation_view',$data);
        }
    }
    public function depreciationprint($assetType,$depreceationYear)
    {
        if($this->session->has_userdata('username')){
            $data['assetType'] = urldecode($assetType);
            $data['depreceationYear'] = $depreceationYear;
            $data['assetList'] = $this->asset_model->get_asset_depreciation($depreceationYear,urldecode($assetType));
            $this->load->view('asset_depreciation_print_view',$data);
        }
    }

    public function depreciationsummery()
    {
        if($this->session->has_userdata('username')){
            $data['depreceationYear']=$depreceationYear= $this->input->post("depreceationYear");
            $data['assetList'] =array();
            if ($this->input->post('btn_save') == "Show Report"){
                $data['assetList'] = $this->asset_model->get_asset_depreciation($depreceationYear);
            }
            $this->load->view('asset_depreciation_summery_view',$data);
        }
    }

    public function depreciationsummeryprint($depreceationYear)
    {
        if($this->session->has_userdata('username')){
            $data['depreceationYear'] = $depreceationYear;
            $data['assetList'] = $this->asset_model->get_asset_depreciation($depreceationYear);
            $this->load->view('asset_depreciation_summery_print_view',$data);
        }
    }
}
