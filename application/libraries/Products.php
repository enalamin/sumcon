<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 
*/
class Products
{
	private $CI;
	
	public function __construct()
	{
		$this->CI = &get_instance();
        $this->CI->load->helper('url');
        $this->CI->load->library('session');
        $this->CI->config->item('base_url');
        $this->CI->load->database();
	}


	public function closingstock($fromDate,$toDate)
    {
        //recurring discount
        $CI = &get_instance();
        $CI->load->database();
        
        $CI->load->model('product_model');
        
        $productStock = $CI->product_model->store_summery_query(0,$fromDate,$toDate);
        $grandReceive = $grandOut = $grandBalanceQty = $grandAmount = $grandBalanceWithLoan = $grandLoanQty = 0;
        foreach ($productStock as $stock){
           // $receiveTotal = $outTotal=$currentBalance=0;
            $receiveTotal = $stock["conversion"]+$stock["transfer"]+$stock["purchase"]+$stock["salesreturn"]+$stock["loantaken"]+$stock["samplereturn"]+$stock["lc"];
            $outTotal = $stock["conversionout"]+$stock["transferout"]+$stock["sales"]+$stock["loangiven"]+$stock["freesample"];
            $currentBalance = $stock["openingbalance"]+$receiveTotal-$outTotal;

            $receiveTotalAmount = $stock["conversionAmount"]+$stock["transferAmount"]+$stock["purchaseAmount"]+$stock["salesreturnAmount"]+$stock["loantakenAmount"]+$stock["samplereturnAmount"]+$stock["lcAmount"];
            $outTotalAmount = $stock["conversionoutAmount"]+$stock["transferoutAmount"]+$stock["salesAmount"]+$stock["loangivenAmount"]+$stock["freesampleAmount"];
            $currentBalanceAmount = $stock["openingbalanceAmount"]+$receiveTotalAmount-$outTotalAmount;
            $productRate=$this->getproductavgrate($stock['product_id'],$toDate);
            
            
            $loanBalance= $stock["loanbalance"]+$stock["loangiven"]-$stock["loantaken"];
            $loanBalanceAmount= $stock["loanbalanceAmount"]+$stock["loangivenAmount"]-$stock["loantakenAmount"];
            //$currentBalanceWithLoan = $currentBalance + $loanBalance;
            //$currentBalanceAmount = $currentBalanceWithLoan*round($stock["product_rate"],2);
            $currentBalanceWithLoan = $currentBalance + $loanBalance;
            //$currentBalanceAmount = $currentBalanceWithLoan*round($stock["product_rate"],2);
            $currentBalanceAmount = $currentBalanceWithLoan*round($productRate,2);
            //$currentBalanceAmount = $currentBalanceAmount+$loanBalanceAmount;
            if($stock["openingbalance"]==0 && $receiveTotal==0 && $outTotal==0 && $currentBalance==0 && $loanBalance==0){
                continue;
            }
            $grandReceive += $receiveTotal; 
            $grandOut += $outTotal; 
            $grandBalanceQty += $currentBalance; 
            $grandLoanQty += $loanBalance;
            $grandBalanceWithLoan += $currentBalanceWithLoan;
            $grandAmount += $currentBalanceAmount;
        }
        return $grandAmount;
    }

    public function getproductavgrate($productId,$tillDate)
    {
        //recurring discount
        $CI = &get_instance();
        $CI->load->database();
        
        $CI->load->model('product_model');
        $CI->load->model('loan_model');
        
        $transectionData = $CI->product_model->productwisetransection($productId);
        $totalinQty = $totaloutQty = 0;
        $balanceQty = $loanQty = 0 ;
        $balanceAmount = $openingBalance = $loanAmount = 0;
        $balanceRate=0;
        $priviousBalanceQty = $previousBalanceAmount = $balanceRate = $previousRate = 0 ;
        if(!$tillDate)
            $tillDate = date('Y-m-d');
        $i=0;
        foreach ($transectionData as $transection){
            if($i==0)
                $previousRate = $transection['rate'];
            else 
                $previousRate = $balanceRate;

            if(strtotime($transection['trn_date'])>strtotime($tillDate))
                break;
            $loanBalance = $CI->loan_model->loanbalance($productId,$transection['trn_date']);
            if($loanBalance){
                $loanQty = $loanBalance[0]['balance'];
                $loanAmount = $loanQty*$previousRate;
            }
            $totalinQty += $transection["trn_state"]=='in'? $transection['quantity']:0;
            $totaloutQty += $transection["trn_state"]=='out'? $transection['quantity']:0;
            $priviousBalanceQty = $balanceQty;
            $balanceQty = $openingBalance+$totalinQty - $totaloutQty;
            if($priviousBalanceQty<0 && $balanceQty>0){
                $adjustAmount= $priviousBalanceQty*$transection['rate'];
                $balanceAmount=$adjustAmount+($transection["trn_state"]=='in'? ($transection['quantity']*$transection['rate']):0) - ($transection["trn_state"]=='out'? ($transection['quantity']*$transection['rate']):0);
            } else {                            
                $balanceAmount = $balanceAmount+($transection["trn_state"]=='in'? ($transection['quantity']*$transection['rate']):0) - ($transection["trn_state"]=='out'? ($transection['quantity']*$transection['rate']):0);
            }

            $balanceRate = ($balanceQty+$loanQty)>0?round((($balanceAmount+$loanAmount)/($balanceQty+$loanQty)),2):round($transection['rate'],2);
            $i++;
        }
        return abs($balanceRate);

    }

    

}
?>