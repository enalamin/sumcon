<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 
*/
class Notes
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


	
    public function notes1($fromDate,$toDate)
    {
        //recurring discount
        $CI = &get_instance();
        $CI->load->database();
        $CI->load->model('accounts_model');
        $CI->load->model('product_model');
        $CI->load->library('products');
        $i=0;
        $openingStockData=$CI->accounts_model->getAccountHeadSumData(4,$fromDate,$toDate);
        $data[$i]['head_name']='Opening Stock Of Raw materials';
        $data[$i]['amount']=$openingStock=$openingStockData[0]['amount'];
        $i++;
        $purchaseMaterialsData=$CI->accounts_model->getAccountHeadSumData(88,$fromDate,$toDate);
        $data[$i]['head_name']='Add: Purchase of Raw Materials';
        $data[$i]['amount']=$purchaseMaterials=$purchaseMaterialsData[0]['amount'];
        $i++;
        $data[$i]['head_name']='Raw Material available for use';
        $data[$i]['amount']=$materialsAvailable=$openingStock+$purchaseMaterials;
        $i++;
        //stock as of 30-06
        $closingStock = $CI->products->closingstock($fromDate,$toDate);
        $goodsInTransit = $CI->product_model->goodesIntransit($fromDate,$toDate);
        $closingStock += $goodsInTransit[0]['amount'];
        $data[$i]['head_name']='Less: Raw materials  as on '.$toDate;
        $data[$i]['amount']=$closingStock;
        $i++;
        $materialsUsed = $materialsAvailable - $closingStock;
        $data[$i]['amount'] = $materialsUsed; 
        $data[$i]['head_name']='Add: Raw Material  Used';
        $i++;

        // labour
        $labourChargeData = $CI->accounts_model->getAccountHeadSumData(32,$fromDate,$toDate);
        $transportChargeData = $CI->accounts_model->getAccountHeadSumData(73,$fromDate,$toDate);
        $labourAndTransport = $labourChargeData[0]['amount']+$transportChargeData[0]['amount'];
        $data[$i]['head_name']='Labour and Carrying';
        $data[$i]['amount']=$labourAndTransport;        
        $i++;
        $data[$i]['head_name']='<b>Cost Of Goods Sold in BDT.</b>';
        $data[$i]['amount']=($labourAndTransport+$materialsUsed);
        $i++;
        return $data;
    }

    public function notes1sum($fromDate,$toDate)
    {
        $notes1Data = $this->notes1($fromDate,$toDate);
        //print_r($notes1Data);
        $lastIndex = count($notes1Data);
        return $notes1Data[6]['amount'];
    }

    public function notes2($fromDate,$toDate)
    {
        $CI = &get_instance();
        $CI->load->database();
        $CI->load->model('accounts_model');
        return $notesData = $CI->accounts_model->getSubGroupSumData(8,16,$fromDate,$toDate);
    }

    public function notes2sum($fromDate,$toDate)
    {
        $data = $this->notes2($fromDate,$toDate);
        $totalAmount = 0;
        foreach ($data as $transection){
          $totalAmount += $transection['amount'];
        }
        return $totalAmount;
    }

    public function notes3($fromDate,$toDate)
    {
        $CI = &get_instance();
        $CI->load->database();
        $CI->load->model('accounts_model');
        return $notesData = $CI->accounts_model->getSubGroupSumData(8,15,$fromDate,$toDate);
    }

    public function notes3sum($fromDate,$toDate)
    {
        $data = $this->notes3($fromDate,$toDate);
        $totalAmount = 0;
        foreach ($data as $transection){
          $totalAmount += $transection['amount'];
        }
        return $totalAmount;
    }

    public function notes4($fromDate,$toDate)
    {
        $CI = &get_instance();
        $CI->load->database();
        $CI->load->model('accounts_model');
        return $notesData = $CI->accounts_model->getSubGroupSumData(8,18,$fromDate,$toDate);
    }

    public function notes4sum($fromDate,$toDate)
    {
        $data = $this->notes4($fromDate,$toDate);
        
        $totalAmount = 0;
        foreach ($data as $transection){
          $totalAmount += $transection['amount'];
        }
        return $totalAmount;
    }

    
    public function notes5($fromDate,$toDate)
    {
        $CI = &get_instance();
        $CI->load->database();
        $CI->load->model('accounts_model');
        $bankDeposit = $CI->accounts_model->banksummery($fromDate,$toDate,'50321003916') ;
        $total = 0;
        $i=0;
        $data[$i]['head_name'] = $bankDeposit[0]['bank_name'].' Feixed Deposit 50321003916';  
        $data[$i]['amount'] = ($bankDeposit[0]['entry_balance']+$bankDeposit[0]['openingBalance']+$bankDeposit[0]['currentBalance']);
        $i++; 
        $sql = "SELECT
                    accounts_head_id,
                    ifnull(sum(opendrAmount-opencrAmount),0) as openingBalance,
                    ifnull(sum(currentdrAmount-currentcrAmount),0) as currentBalance
                FROM
                (SELECT
                    accounts_head_id,
                    sum(if(tbl_voucher.voucher_date < ? ,if(tbl_voucher_details.transection_type='Dr',tbl_voucher_details.amount,0),0)) as opendrAmount,
                    sum(if(tbl_voucher.voucher_date < ? ,if(tbl_voucher_details.transection_type='Cr',tbl_voucher_details.amount,0),0)) as opencrAmount,
                    sum(if(tbl_voucher.voucher_date between ? and ?,if(tbl_voucher_details.transection_type='Dr',tbl_voucher_details.amount,0),0)) as currentdrAmount,
                    sum(if(tbl_voucher.voucher_date between ? and ?,if(tbl_voucher_details.transection_type='Cr',tbl_voucher_details.amount,0),0)) as currentcrAmount
                FROM
                    tbl_voucher
                    INNER JOIN tbl_voucher_details using (voucher_id)
                    /*INNER join tbl_client on tbl_client.client_id=tbl_voucher.party_id*/
                WHERE
                    tbl_voucher.approve_by is not NULL
                    and tbl_voucher_details.accounts_head_id in (5,100)
                GROUP BY 
                    accounts_head_id
                ) AS temp
                WHERE
                    1 
                GROUP BY
                    accounts_head_id";
        $result = $this->CI->db->query($sql,array($fromDate,$fromDate,$fromDate,$toDate,$fromDate,$toDate));
        $resultSet = $result->result_array();
        if(is_array($resultSet) && count($resultSet)>0){
            foreach($resultSet as $row){
                $data[$i]['head_name'] = $row['accounts_head_id']==5?'Advance Deposit & prepayment':'Bank Asia Margin A/C';
                $data[$i]['amount'] = abs($row['openingBalance']+$row['currentBalance']);
                $i++;
            }                
        } 
        return $data;
    }

    public function notes5sum($fromDate,$toDate)
    {
        $data = $this->notes5($fromDate,$toDate);
        
        $totalAmount = 0;
        foreach ($data as $transection){
          $totalAmount += $transection['amount'];
        }
        return $totalAmount;
    }

    public function notes6($fromDate,$toDate)
    {
        $CI = &get_instance();
        $CI->load->database();
        $CI->load->model('accounts_model');
        $notesData = $CI->accounts_model->getAccountHeadSumData(2,$fromDate,$toDate);
        $i=0;
        $data[$i]['head_name'] = $notesData[0]['head_name'];  
        $data[$i]['amount'] = $notesData[0]['amount'];
        $i++; 
        
        $bankDepositData = $CI->accounts_model->banksummery($fromDate,$toDate) ;
        if(is_array($bankDepositData) && count($bankDepositData)>0){
            foreach($bankDepositData as $row){
                if($row['account_no']=='50321003916')
                    continue;

                $data[$i]['head_name'] = $row['bank_name'].' - '.$row['account_no'];
                $data[$i]['amount'] = abs($row['entry_balance']+$row['openingBalance']+$row['currentBalance']);
                $i++;
            }                
        } 
        return $data;
    }

    public function notes6sum($fromDate,$toDate)
    {
        $data = $this->notes6($fromDate,$toDate);
        
        $totalAmount = 0;
        foreach ($data as $transection){
          $totalAmount += $transection['amount'];
        }
        return $totalAmount;
    }


}
?>