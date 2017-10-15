<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Accounts_model extends CI_Model
{
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
		    $this->db->query("SET time_zone='+6:00'");
    }

	  function create_voucher($data)
    {
        $this->db->insert('tbl_voucher', $data);
        return $this->db->insert_id();
    }

    function create_voucher_details($data)
    {
      return $this->db->insert('tbl_voucher_details', $data);
    }

    function create_party_misc_transection($data)
    {
      return $this->db->insert('tbl_party_misc_transection', $data);
    }    

    function update_voucher($voucherId,$dataArray)
    {
        return $this->db
            ->where('voucher_id',$voucherId)
            ->update('tbl_voucher', $dataArray );

    }

    function get_voucher_number($voucherType,$voucherDate=NULL)
    {
        $this->db->select('ifnull(max(voucher_number),0)+1 as voucherNumber');
        $this->db->from('tbl_voucher');
        $this->db->where('voucher_type',$voucherType);
        if($voucherDate){
            $this->db->where('month(voucher_date)',date('m',strtotime($voucherDate)));  
            $this->db->where('year(voucher_date)',date('Y',strtotime($voucherDate)));  
        } else{
            $this->db->where('month(voucher_date)',date('m'));
            $this->db->where('year(voucher_date)',date('Y'));
        }
      
        return $this->db->get()->row()->voucherNumber;
    }

    function get_voucher_list($voucherType=NULL,$voucherDate=NULL,$voucherNumber=NULL)
    {
        if($voucherType==NULL){
            $sql = "SELECT
                        tbl_voucher.voucher_id,tbl_voucher.voucher_number,tbl_voucher.voucher_date,tbl_voucher.voucher_type,tbl_client.client_name
                    FROM
                        tbl_voucher
                        LEFT JOIN tbl_client on tbl_voucher.party_id=tbl_client.client_id
                    WHERE
                        1 
                        ".($voucherDate?" and tbl_voucher.voucher_date='".$voucherDate."'":"")."
                        ".($voucherNumber?" and tbl_voucher.voucher_number='".$voucherNumber."'":"")."
                    ORDER BY
                        tbl_voucher.voucher_date";
          $query = $this->db->query($sql);
        }else {
            $sql = "SELECT
                        tbl_voucher.voucher_id,tbl_voucher.voucher_number,tbl_voucher.voucher_date,tbl_voucher.voucher_type,      tbl_client.client_name
                    FROM
                        tbl_voucher
                        LEFT JOIN tbl_client on tbl_voucher.party_id=tbl_client.client_id
                    WHERE
                        tbl_voucher.voucher_type=?
                        ".($voucherDate?" and tbl_voucher.voucher_date='".$voucherDate."'":"")."
                        ".($voucherNumber?" and tbl_voucher.voucher_number='".$voucherNumber."'":"")."
                    ORDER BY
                        tbl_voucher.voucher_date";
          $query = $this->db->query($sql,array($voucherType));
      }

      return $query->result_array();
    }

    function get_voucher_count($voucherDate)
    {
        $sql = "SELECT
                    voucher_type, count(voucher_number) as numberofvoucher
                FROM
                    tbl_voucher
                WHERE
                    month(voucher_date)=month(?)
                    and year(voucher_date)=year(?)
                GROUP BY
                    voucher_type
                ORDER BY
                    voucher_type";
        $query = $this->db->query($sql, array($voucherDate,$voucherDate));       
        return $query->result_array();
    }

    function get_voucher_for_approve()
    {
        $sql = "SELECT
                  tbl_voucher.voucher_id,tbl_voucher.voucher_number,tbl_voucher.voucher_date,tbl_voucher.voucher_type,
                  tbl_client.client_name
                FROM
                  tbl_voucher
                  LEFT JOIN tbl_client on tbl_voucher.party_id=tbl_client.client_id
                WHERE
                  tbl_voucher.approve_by is NULL";
        $query = $this->db->query($sql);

        return $query->result_array();
    }

    function get_voucher($voucherId)
    {
      $sql = "SELECT
                tbl_voucher.*,
                tbl_client.client_name,
                tbl_voucher_details.*,
                chart_of_accounts.head_name,
                tbl_bank.bank_name,
                toBank.bank_name as to_bank_name,
                tbl_voucher.transection_type as voucherTransectionType,
                tbl_employee.employee_name,
                tbl_car.car_number
              FROM
                tbl_voucher
                INNER JOIN tbl_voucher_details USING(voucher_id)
                INNER JOIN chart_of_accounts USING(accounts_head_id)
                LEFT JOIN tbl_client on tbl_voucher.party_id=tbl_client.client_id
                LEFT JOIN tbl_bank on tbl_voucher.bank_id = tbl_bank.bank_id
                LEFT JOIN tbl_bank as toBank on tbl_voucher.to_bank_id = toBank.bank_id
                LEFT join tbl_employee on tbl_employee.employee_id=tbl_voucher_details.employee_id
                LEFT JOIN tbl_car on tbl_car.car_id=tbl_voucher_details.car_id
              WHERE
                tbl_voucher.voucher_id=?";
      $query = $this->db->query($sql,array($voucherId));
      return $query->result_array();
    }

    function getOpeningBalance($accountsHeadId,$upToDate)
    {
      $sql= "SELECT
                if(chart_of_accounts.transection_type='Debit',(ifnull(sum(if(tbl_voucher_details.transection_type='Dr',tbl_voucher_details.amount,0) - if(tbl_voucher_details.transection_type='Cr',tbl_voucher_details.amount,0)),0)),(ifnull(sum(if(tbl_voucher_details.transection_type='Cr',tbl_voucher_details.amount,0) - if(tbl_voucher_details.transection_type='Dr',tbl_voucher_details.amount,0)),0))) as openingBalance
            FROM
                tbl_voucher
                INNER JOIN tbl_voucher_details using (voucher_id)
                INNER JOIN chart_of_accounts using (accounts_head_id)
            WHERE
                tbl_voucher.approve_by is not NULL
                and tbl_voucher_details.accounts_head_id=?
                and tbl_voucher.voucher_date < ?  ";
        $query = $this->db->query($sql,array($accountsHeadId,$upToDate));
        return $query->row()->openingBalance;
    }

    function getBankOpeningBalance($accountNo,$upToDate)
    {
    //   $sql= "SELECT
    //             ifnull(sum(if(tbl_voucher_details.transection_type='Dr',tbl_voucher_details.amount,0) - if(tbl_voucher_details.transection_type='Cr',tbl_voucher_details.amount,0)),0) as openingBalance
    //         FROM
    //             tbl_voucher
    //             INNER JOIN tbl_voucher_details using (voucher_id)
    //         WHERE
    //             tbl_voucher.approve_by is not NULL
    //             and tbl_voucher_details.accounts_head_id=1
    //             and (tbl_voucher.account_no = ? or tbl_voucher.to_account_no = ?)
    //             and tbl_voucher.voucher_date < ?  ";
    $sql ="SELECT
                ifnull(sum(drAmount-crAmount),0) as openingBalance
            FROM
                (SELECT
                  if(tbl_voucher_details.transection_type='Dr',tbl_voucher_details.amount,0) as drAmount,
                  if(tbl_voucher_details.transection_type='Cr',tbl_voucher_details.amount,0) as crAmount
              FROM
                  tbl_voucher
                  INNER JOIN tbl_voucher_details using (voucher_id)
                  INNER join chart_of_accounts using (accounts_head_id)
                  LEFT JOIN tbl_client on tbl_voucher.party_id=tbl_client.client_id
              WHERE
                  tbl_voucher.approve_by is not NULL
                  and tbl_voucher_details.accounts_head_id=1
                  and tbl_voucher.voucher_type !='transfer'
                  and (tbl_voucher.account_no = ? or tbl_voucher.to_account_no = ?)
                  and tbl_voucher.voucher_date < ?
              union all
              SELECT
                    '0' as drAmount,
                    if(tbl_voucher_details.transection_type='Cr',tbl_voucher_details.amount,0) as crAmount
                FROM
                    tbl_voucher
                    INNER JOIN tbl_voucher_details using (voucher_id)
                    INNER join chart_of_accounts using (accounts_head_id)
                    LEFT JOIN tbl_client on tbl_voucher.party_id=tbl_client.client_id
                WHERE
                    tbl_voucher.approve_by is not NULL
                    and tbl_voucher_details.accounts_head_id=1
                    and tbl_voucher.voucher_type ='transfer'
                    and tbl_voucher.account_no = ?
                    and tbl_voucher.voucher_date < ?
              union all
              SELECT
                    if(tbl_voucher_details.transection_type='Dr',tbl_voucher_details.amount,0) as drAmount,
                    '0' as crAmount
                FROM
                    tbl_voucher
                    INNER JOIN tbl_voucher_details using (voucher_id)
                    INNER join chart_of_accounts using (accounts_head_id)
                    LEFT JOIN tbl_client on tbl_voucher.party_id=tbl_client.client_id
                WHERE
                    tbl_voucher.approve_by is not NULL
                    and tbl_voucher_details.accounts_head_id=1
                    and tbl_voucher.voucher_type ='transfer'
                    and tbl_voucher.to_account_no = ?
                    and tbl_voucher.voucher_date < ?) AS temp
          ";
        $query = $this->db->query($sql,array($accountNo,$accountNo,$upToDate,$accountNo,$upToDate,$accountNo,$upToDate));
        return $query->row()->openingBalance;
    }

    function banksummery($fromDate,$toDate,$accountNo=NULL)
    {
        $sql = "SELECT
                    bank_name,
                    account_no,
                    ifnull(entry_balance,0) as entry_balance,
                    ifnull(sum(opendrAmount-opencrAmount),0) as openingBalance,
                    ifnull(sum(currentdrAmount-currentcrAmount),0) as currentBalance
                FROM
                (SELECT
                    tbl_bank_account.bank_id,
                    tbl_voucher.account_no,
                    tbl_bank_account.entry_balance,
                    sum(if(tbl_voucher.voucher_date < ?,if(tbl_voucher_details.transection_type='Dr',tbl_voucher_details.amount,0),0)) as opendrAmount,
                    sum(if(tbl_voucher.voucher_date < ?,if(tbl_voucher_details.transection_type='Cr',tbl_voucher_details.amount,0),0)) as opencrAmount,
                    sum(if(tbl_voucher.voucher_date between ? and ?,if(tbl_voucher_details.transection_type='Dr',tbl_voucher_details.amount,0),0)) as currentdrAmount,
                    sum(if(tbl_voucher.voucher_date between ? and ?,if(tbl_voucher_details.transection_type='Cr',tbl_voucher_details.amount,0),0)) as currentcrAmount
                FROM
                    tbl_voucher
                    INNER JOIN tbl_voucher_details using (voucher_id)
                    INNER join chart_of_accounts using (accounts_head_id)
                    inner join tbl_bank_account on tbl_bank_account.account_no=tbl_voucher.account_no
                WHERE
                    tbl_voucher.approve_by is not NULL
                    and tbl_voucher_details.accounts_head_id=1
                    and tbl_voucher.voucher_type !='transfer'
                    and tbl_voucher.account_no is not NULL
                group by
                    tbl_voucher.account_no  
                union all
                SELECT
                    tbl_bank_account.bank_id,
                    tbl_voucher.account_no,
                    tbl_bank_account.entry_balance,
                    '0' as opendrAmount,
                    sum(if(tbl_voucher.voucher_date < ?,if(tbl_voucher_details.transection_type='Cr',tbl_voucher_details.amount,0),0)) as opencrAmount,
                    '0' as currentdrAmount,
                    sum(if(tbl_voucher.voucher_date between ? and ?,if(tbl_voucher_details.transection_type='Cr',tbl_voucher_details.amount,0),0)) as currentcrAmount
                FROM
                    tbl_voucher
                    INNER JOIN tbl_voucher_details using (voucher_id)
                    INNER join chart_of_accounts using (accounts_head_id)
                    inner join tbl_bank_account on tbl_bank_account.account_no=tbl_voucher.account_no
                WHERE
                    tbl_voucher.approve_by is not NULL
                    and tbl_voucher_details.accounts_head_id=1
                    and tbl_voucher.voucher_type ='transfer'
                    and tbl_voucher.account_no is not NULL
                group by
                    tbl_voucher.account_no
                union all
                SELECT
                    tbl_bank_account.bank_id,
                    tbl_voucher.to_account_no as account_no,
                    tbl_bank_account.entry_balance,
                    sum(if(tbl_voucher.voucher_date < ?,if(tbl_voucher_details.transection_type='Dr',tbl_voucher_details.amount,0),0)) as opendrAmount,
                    '0' opencrAmount,
                    sum(if(tbl_voucher.voucher_date between ? and ?,if(tbl_voucher_details.transection_type='Dr',tbl_voucher_details.amount,0),0)) as currentdrAmount,
                    '0' as currentcrAmount
                FROM
                    tbl_voucher
                    INNER JOIN tbl_voucher_details using (voucher_id)
                    INNER join chart_of_accounts using (accounts_head_id)
                    inner join tbl_bank_account on tbl_bank_account.account_no=tbl_voucher.to_account_no
                WHERE
                    tbl_voucher.approve_by is not NULL
                    and tbl_voucher_details.accounts_head_id=1
                    and tbl_voucher.voucher_type ='transfer'
                    and tbl_voucher.to_account_no is not NULL
                group by
                    tbl_voucher.to_account_no
                ) AS temp
                inner join tbl_bank using (bank_id)
                WHERE
                    1
                    ".($accountNo?"and account_no='".$accountNo."'":"")."
                group by 
                    account_no";
        $query = $this->db->query($sql,array($fromDate,$fromDate,$fromDate,$toDate,$fromDate,$toDate,$fromDate,$fromDate,$toDate,$fromDate,$fromDate,$toDate));
        return $query->result_array();
    }

    function getClientOpeningBalance($clientId,$accountHeadId='',$upToDate)
    {
      $sql= "SELECT
                ifnull(if(client_type='Debtor',sum(drAmount-crAmount),sum(crAmount-drAmount)),0) as openingBalance
            FROM
                (SELECT
                tbl_voucher.party_id as client_id,
                tbl_voucher.voucher_date,
                tbl_voucher_details.particulers,
                if(tbl_voucher_details.transection_type='Dr',tbl_voucher_details.amount,0) as drAmount,
                if(tbl_voucher_details.transection_type='Cr',tbl_voucher_details.amount,0) as crAmount
            FROM
                tbl_voucher
                INNER JOIN tbl_voucher_details using (voucher_id)
            WHERE
                tbl_voucher.approve_by is not NULL
                and tbl_voucher_details.accounts_head_id ".($accountHeadId?" ='".$accountHeadId."'":" in (3,5,12)")."
                and (tbl_voucher_details.employee_id is null or tbl_voucher_details.employee_id=0)
                and tbl_voucher.party_id = ?
                and tbl_voucher.voucher_date between '2017-05-01' and ? 
                and tbl_voucher.voucher_date!=?
            ) as temp 
                inner join tbl_client using(client_id) ";
        $query = $this->db->query($sql,array($clientId,$upToDate,$upToDate));
        return $query->row()->openingBalance;
    }

    function getBankLoanOpeningBalance($accountsHeadId,$accountNo,$upToDate)
    {
        $sql= "SELECT
                ifnull(sum(if(tbl_voucher_details.transection_type='Dr',tbl_voucher_details.amount,0) - if(tbl_voucher_details.transection_type='Cr',tbl_voucher_details.amount,0)),0) as openingBalance
            FROM
                tbl_voucher
                INNER JOIN tbl_voucher_details using (voucher_id)
            WHERE
                tbl_voucher.approve_by is not NULL
                and tbl_voucher_details.accounts_head_id=?
                and (tbl_voucher.account_no = ? or tbl_voucher.to_account_no = ?)
                and tbl_voucher.voucher_date < ?  ";
        $query = $this->db->query($sql,array($accountsHeadId,$accountNo,$accountNo,$upToDate));
        return $query->row()->openingBalance;
    }

    function getEmployeeOpeningBalance($employeeId,$fromDate)
    {
        $sql= "SELECT
                ifnull((sum(if(tbl_voucher_details.transection_type='Dr',tbl_voucher_details.amount,0)) -
                sum(if(tbl_voucher_details.transection_type='Cr',tbl_voucher_details.amount,0))),0) as openingBalance
            FROM
                tbl_voucher
                INNER JOIN tbl_voucher_details using (voucher_id)
                INNER join chart_of_accounts using (accounts_head_id)
                LEFT JOIN tbl_client on tbl_voucher.party_id=tbl_client.client_id
            WHERE
                tbl_voucher.approve_by is not NULL
                and tbl_voucher_details.employee_id=?
                and tbl_voucher.voucher_date < ? ";
        $query = $this->db->query($sql,array($employeeId,$fromDate));
        return $query->row()->openingBalance; 
    }

    function transectionsData($accountsHeadId,$fromDate,$toDate)
    {
      $sql= "SELECT
                tbl_voucher.voucher_id,
                tbl_voucher.voucher_number,
                tbl_voucher.voucher_date,
                tbl_voucher.voucher_type,
                tbl_client.client_name,
                tbl_voucher_details.particulers,
                if(tbl_voucher_details.transection_type='Dr',tbl_voucher_details.amount,0) as drAmount,
                if(tbl_voucher_details.transection_type='Cr',tbl_voucher_details.amount,0) as crAmount
            FROM
                tbl_voucher
                INNER JOIN tbl_voucher_details using (voucher_id)
                LEFT JOIN tbl_client on tbl_voucher.party_id=tbl_client.client_id
            WHERE
                tbl_voucher.approve_by is not NULL
                and tbl_voucher_details.accounts_head_id=?
                and tbl_voucher.voucher_date between ? and ? 
            order by
                tbl_voucher.voucher_date";
        $query = $this->db->query($sql,array($accountsHeadId,$fromDate,$toDate));
        return $query->result_array();
    }

    function transectionsSubData($partyId,$fromDate,$toDate,$accountHeadId='')
    {
      $sql= "SELECT 
              *
            FROM(
            SELECT
                tbl_voucher.voucher_date,
                tbl_voucher.voucher_id,
                tbl_voucher_details.particulers,
                if(tbl_voucher_details.transection_type='Dr',tbl_voucher_details.amount,0) as drAmount,
                if(tbl_voucher_details.transection_type='Cr',tbl_voucher_details.amount,0) as crAmount
            FROM
                tbl_voucher
                INNER JOIN tbl_voucher_details using (voucher_id)
                LEFT JOIN tbl_client on tbl_voucher.party_id=tbl_client.client_id
            WHERE
                tbl_voucher.approve_by is not NULL
                and tbl_voucher_details.accounts_head_id ".($accountHeadId?" ='".$accountHeadId."'":" in (3,5,12)")."
                and (tbl_voucher_details.employee_id is null or tbl_voucher_details.employee_id=0)
                and tbl_voucher.party_id = ?
                and tbl_voucher.voucher_date between ? and ? ) as temp
            order by 
                voucher_date,voucher_id asc";
        $query = $this->db->query($sql,array($partyId,$fromDate,$toDate));
        return $query->result_array();
    }


    function journalTransectionsData($fromDate,$toDate,$journalType='')
    {
      $sql= "SELECT
                tbl_voucher.voucher_id,
                tbl_voucher.voucher_number,
                tbl_voucher.voucher_date,
                tbl_voucher.voucher_type,
                tbl_client.client_name,
                chart_of_accounts.head_name,
                tbl_voucher_details.particulers,
                if(tbl_voucher_details.transection_type='Dr',tbl_voucher_details.amount,0) as drAmount,
                if(tbl_voucher_details.transection_type='Cr',tbl_voucher_details.amount,0) as crAmount
            FROM
                tbl_voucher
                INNER JOIN tbl_voucher_details using (voucher_id)
                INNER join chart_of_accounts using (accounts_head_id)
                LEFT JOIN tbl_client on tbl_voucher.party_id=tbl_client.client_id
            WHERE
                tbl_voucher.voucher_date between ? and ?
                ".($journalType!=''?" and tbl_voucher.voucher_type='".$journalType."'":"")."
            order by
                tbl_voucher.voucher_id asc , tbl_voucher_details.transection_type desc";
        $query = $this->db->query($sql,array($fromDate,$toDate));
        return $query->result_array();
    }

    function cashBookTransectionsData($fromDate,$toDate)
    {
      $sql= "SELECT
                tbl_voucher.voucher_id,
                tbl_voucher.voucher_number,
                tbl_voucher.voucher_date,
                tbl_voucher.voucher_type,
                tbl_client.client_name,
                COALESCE(tbl_voucher.description,tbl_voucher_details.particulers,chart_of_accounts.head_name) as particulers,
                if(tbl_voucher_details.transection_type='Cr',tbl_voucher_details.amount,0) as drAmount,
                if(tbl_voucher_details.transection_type='Dr',tbl_voucher_details.amount,0) as crAmount
            FROM
                tbl_voucher
                INNER JOIN tbl_voucher_details using (voucher_id)
                INNER join chart_of_accounts using (accounts_head_id)
                LEFT JOIN tbl_client on tbl_voucher.party_id=tbl_client.client_id
            WHERE
                tbl_voucher.approve_by is not NULL
                and tbl_voucher_details.accounts_head_id!=2
                and tbl_voucher.transection_type!='Cheque'
                and tbl_voucher.voucher_type !='journal'
                and tbl_voucher.voucher_date between ? and ?
            union all
            SELECT
                      tbl_voucher.voucher_id,
                      tbl_voucher.voucher_number,
                      tbl_voucher.voucher_date,
                      tbl_voucher.voucher_type,
                      tbl_client.client_name,
                      COALESCE(tbl_voucher_details.particulers,tbl_voucher.description,chart_of_accounts.head_name) as particulers,
                      if(tbl_voucher_details.transection_type='Dr',tbl_voucher_details.amount,0) as drAmount,
                      if(tbl_voucher_details.transection_type='Cr',tbl_voucher_details.amount,0) as crAmount
                  FROM
                      tbl_voucher
                      INNER JOIN tbl_voucher_details using (voucher_id)
                      INNER join chart_of_accounts using (accounts_head_id)
                      LEFT JOIN tbl_client on tbl_voucher.party_id=tbl_client.client_id
                  WHERE
                      tbl_voucher.approve_by is not NULL
                      and tbl_voucher_details.accounts_head_id=2
                      and tbl_voucher.transection_type='Cheque'
                      and tbl_voucher.voucher_type !='journal'
                      and tbl_voucher.voucher_date between ? and ?
            order by voucher_date asc, drAmount desc
            ";
        $query = $this->db->query($sql,array($fromDate,$toDate,$fromDate,$toDate));
        return $query->result_array();
    }

    function receiptandpaymentdata($fromDate,$toDate)
    {
      $sql= "SELECT
                '1' as vieworder,
                concat('Received from ',tbl_client.client_name) as particulers,
                sum(if(tbl_voucher_details.transection_type='Cr',tbl_voucher_details.amount,0)) as drAmount,
                sum(if(tbl_voucher_details.transection_type='Dr',tbl_voucher_details.amount,0)) as crAmount
            FROM
                tbl_voucher
                INNER JOIN tbl_voucher_details using (voucher_id)
                INNER join chart_of_accounts using (accounts_head_id)
                LEFT JOIN tbl_client on tbl_voucher.party_id=tbl_client.client_id
            WHERE
                tbl_voucher.approve_by is not NULL
                and tbl_client.client_id not in (118)
                and tbl_voucher_details.accounts_head_id=2
                and chart_of_accounts.group_id!=8
                and tbl_voucher.transection_type!='Cheque'
                and tbl_voucher.voucher_type ='receipt'
                and tbl_voucher.voucher_date between ? and ?
            group by tbl_client.client_id
            union all
            SELECT                      
              '2' as vieworder,
              concat('Received from ',tbl_bank.bank_name,' A/C# ',tbl_voucher.account_no) as particulers,
              sum(if(tbl_voucher_details.transection_type='Cr',tbl_voucher_details.amount,0)) as drAmount,
              sum(if(tbl_voucher_details.transection_type='Dr',tbl_voucher_details.amount,0)) as crAmount
            FROM
              tbl_voucher
              INNER JOIN tbl_voucher_details using (voucher_id)
              INNER join chart_of_accounts using (accounts_head_id)
              inner join tbl_bank on tbl_bank.bank_id=tbl_voucher.bank_id
              LEFT JOIN tbl_client on tbl_voucher.party_id=tbl_client.client_id
            WHERE
                tbl_voucher.approve_by is not NULL
                and tbl_voucher_details.accounts_head_id=2
                and chart_of_accounts.group_id!=8
                and tbl_voucher.transection_type='Cheque'
                and tbl_voucher.voucher_type ='transfer'
                and tbl_voucher.bank_id is not null
                and tbl_voucher.voucher_date between ? and ?
            group BY tbl_voucher.account_no
            union all
            SELECT
                '2' as vieworder,
                tbl_voucher.description as particulers,
                sum(if(tbl_voucher_details.transection_type='Dr',tbl_voucher_details.amount,0)) as drAmount,
                sum(if(tbl_voucher_details.transection_type='Cr',tbl_voucher_details.amount,0)) as crAmount
            FROM
                tbl_voucher
                INNER JOIN tbl_voucher_details using (voucher_id)
                INNER join chart_of_accounts using (accounts_head_id)
                
            WHERE
                tbl_voucher.approve_by is not NULL
                and tbl_voucher.party_id = 118
                and tbl_voucher_details.accounts_head_id not in(2,103,89,105)
                and chart_of_accounts.group_id!=8
                and tbl_voucher.transection_type!='Cheque'
                and tbl_voucher.voucher_type ='receipt'
                and tbl_voucher.voucher_date between ? and ?
            group by tbl_voucher_details.voucher_id
            union all
            SELECT
                '2' as vieworder,
                chart_of_accounts.head_name as particulers,
                sum(if(tbl_voucher_details.transection_type='Dr',tbl_voucher_details.amount,0)) as drAmount,
                sum(if(tbl_voucher_details.transection_type='Cr',tbl_voucher_details.amount,0)) as crAmount
            FROM
                tbl_voucher
                INNER JOIN tbl_voucher_details using (voucher_id)
                INNER join chart_of_accounts using (accounts_head_id)
                LEFT JOIN tbl_client on tbl_voucher.party_id=tbl_client.client_id
            WHERE
                tbl_voucher.approve_by is not NULL
                and tbl_voucher_details.accounts_head_id in (103,89,105)
                and tbl_voucher.voucher_type ='receipt'
                and tbl_voucher.voucher_date between ? and ?
            group by 
                tbl_voucher_details.accounts_head_id
            union all
            SELECT
                '3' as vieworder,
                concat('Deposited to ',tbl_bank.bank_name,' A/C# ',tbl_voucher.to_account_no) as particulers,
                sum(if(tbl_voucher_details.transection_type='Dr',tbl_voucher_details.amount,0)) as drAmount,
                sum(if(tbl_voucher_details.transection_type='Cr',tbl_voucher_details.amount,0)) as crAmount
            FROM
                tbl_voucher
                INNER JOIN tbl_voucher_details using (voucher_id)
                INNER join chart_of_accounts using (accounts_head_id)
                inner join tbl_bank on tbl_bank.bank_id=tbl_voucher.to_bank_id
                LEFT JOIN tbl_client on tbl_voucher.party_id=tbl_client.client_id
            WHERE
                tbl_voucher.approve_by is not NULL
                and tbl_voucher_details.accounts_head_id!=2
                and chart_of_accounts.group_id!=8
                and tbl_voucher.transection_type!='Cheque'
                and tbl_voucher.voucher_type ='transfer'
                and tbl_voucher.to_bank_id is not null
                and tbl_voucher.voucher_date between ? and ?
            group BY tbl_voucher.to_account_no
            union all
            SELECT
                '4' as vieworder,
                concat('Pay to ',tbl_client.client_name) as particulers,
                sum(if(tbl_voucher_details.transection_type='Dr',tbl_voucher_details.amount,0)) as drAmount,
                sum(if(tbl_voucher_details.transection_type='Cr',tbl_voucher_details.amount,0)) as crAmount
            FROM
                tbl_voucher
                INNER JOIN tbl_voucher_details using (voucher_id)
                INNER join chart_of_accounts using (accounts_head_id)
                LEFT JOIN tbl_client on tbl_voucher.party_id=tbl_client.client_id
            WHERE
                tbl_voucher.approve_by is not NULL
                and tbl_voucher_details.accounts_head_id in (12)
                and tbl_voucher.voucher_type ='payment'
                and tbl_voucher.voucher_date between ? and ?
            group by 
                tbl_client.client_id
            union all
            SELECT
                '4' as vieworder,
                chart_of_accounts.head_name as particulers,
                sum(if(tbl_voucher_details.transection_type='Dr',tbl_voucher_details.amount,0)) as drAmount,
                sum(if(tbl_voucher_details.transection_type='Cr',tbl_voucher_details.amount,0)) as crAmount
            FROM
                tbl_voucher
                INNER JOIN tbl_voucher_details using (voucher_id)
                INNER join chart_of_accounts using (accounts_head_id)
                LEFT JOIN tbl_client on tbl_voucher.party_id=tbl_client.client_id
            WHERE
                tbl_voucher.approve_by is not NULL
                and tbl_voucher_details.accounts_head_id in (103,89,105)
                and tbl_voucher.voucher_type ='payment'
                and tbl_voucher.voucher_date between ? and ?
            group by 
                tbl_voucher_details.accounts_head_id
            union all
            SELECT
                '5' as vieworder,
                concat('Advance to ',tbl_client.client_name) as particulers,
                sum(if(tbl_voucher_details.transection_type='Dr',tbl_voucher_details.amount,0)) as drAmount,
                sum(if(tbl_voucher_details.transection_type='Cr',tbl_voucher_details.amount,0)) as crAmount
            FROM
                tbl_voucher
                INNER JOIN tbl_voucher_details using (voucher_id)
                INNER join chart_of_accounts using (accounts_head_id)
                LEFT JOIN tbl_client on tbl_voucher.party_id=tbl_client.client_id
            WHERE
                tbl_voucher.approve_by is not NULL
                and tbl_voucher_details.accounts_head_id=5
                and tbl_voucher.voucher_type ='payment'
                and tbl_voucher.voucher_date between ? and ?
            group by 
                tbl_client.client_id
            order by vieworder asc

            ";
        $query = $this->db->query($sql,array($fromDate,$toDate,$fromDate,$toDate,$fromDate,$toDate,$fromDate,$toDate,$fromDate,$toDate,$fromDate,$toDate,$fromDate,$toDate,$fromDate,$toDate));
        return $query->result_array();
    }

    function bankBookTransectionsData($accountNo,$fromDate,$toDate)
    {
      $sql= "SELECT
                tbl_voucher.voucher_id,
                tbl_voucher.voucher_number,
                tbl_voucher.voucher_date,
                tbl_voucher.voucher_type,
                tbl_client.client_name,
                COALESCE(tbl_voucher_details.particulers,tbl_voucher.description,chart_of_accounts.head_name) as particulers,
                if(tbl_voucher_details.transection_type='Cr',tbl_voucher_details.amount,0) as drAmount,
                if(tbl_voucher_details.transection_type='Dr',tbl_voucher_details.amount,0) as crAmount
            FROM
                tbl_voucher
                INNER JOIN tbl_voucher_details using (voucher_id)
                INNER join chart_of_accounts using (accounts_head_id)
                LEFT JOIN tbl_client on tbl_voucher.party_id=tbl_client.client_id
            WHERE
                tbl_voucher.approve_by is not NULL
                and tbl_voucher_details.accounts_head_id not in (1,91)
                and tbl_voucher.voucher_type !='transfer'
                and (tbl_voucher.account_no = ? or tbl_voucher.to_account_no = ?)
                and tbl_voucher.voucher_date between ? and ?
            union
            SELECT
                      tbl_voucher.voucher_id,
                      tbl_voucher.voucher_number,
                      tbl_voucher.voucher_date,
                      tbl_voucher.voucher_type,
                      tbl_client.client_name,
                      COALESCE(tbl_voucher_details.particulers,tbl_voucher.description,chart_of_accounts.head_name) as particulers,
                      '0' as drAmount,
                      if(tbl_voucher_details.transection_type='Cr',tbl_voucher_details.amount,0) as crAmount
                  FROM
                      tbl_voucher
                      INNER JOIN tbl_voucher_details using (voucher_id)
                      INNER join chart_of_accounts using (accounts_head_id)
                      LEFT JOIN tbl_client on tbl_voucher.party_id=tbl_client.client_id
                  WHERE
                      tbl_voucher.approve_by is not NULL
                      and tbl_voucher_details.accounts_head_id in (1,91)
                      and tbl_voucher.voucher_type ='transfer'
                      and tbl_voucher.account_no = ?
                      and tbl_voucher.voucher_date between ? and ?
            union
            SELECT
                      tbl_voucher.voucher_id,
                      tbl_voucher.voucher_number,
                      tbl_voucher.voucher_date,
                      tbl_voucher.voucher_type,
                      tbl_client.client_name,
                      COALESCE(tbl_voucher_details.particulers,tbl_voucher.description,chart_of_accounts.head_name) as particulers,
                      if(tbl_voucher_details.transection_type='Dr',tbl_voucher_details.amount,0) as drAmount,
                      '0' as crAmount
                  FROM
                      tbl_voucher
                      INNER JOIN tbl_voucher_details using (voucher_id)
                      INNER join chart_of_accounts using (accounts_head_id)
                      LEFT JOIN tbl_client on tbl_voucher.party_id=tbl_client.client_id
                  WHERE
                      tbl_voucher.approve_by is not NULL
                      and tbl_voucher_details.accounts_head_id in (1,91)
                      and tbl_voucher.voucher_type ='transfer'
                      and tbl_voucher.to_account_no = ?
                      and tbl_voucher.voucher_date between ? and ?
                order by
                    voucher_date asc, drAmount desc
                  ";
        $query = $this->db->query($sql,array($accountNo,$accountNo,$fromDate,$toDate,$accountNo,$fromDate,$toDate,$accountNo,$fromDate,$toDate));
        return $query->result_array();
    }

    function bankLoanTransectionsData($accountsHeadId,$accountNo,$fromDate,$toDate)
    {
      $sql= "SELECT
                tbl_voucher.voucher_id,
                tbl_voucher.voucher_number,
                tbl_voucher.voucher_date,
                tbl_voucher.voucher_type,
                tbl_client.client_name,
                tbl_voucher_details.particulers,
                if(tbl_voucher_details.transection_type='Cr',tbl_voucher_details.amount,0) as crAmount,
                if(tbl_voucher_details.transection_type='Dr',tbl_voucher_details.amount,0) as drAmount
            FROM
                tbl_voucher
                INNER JOIN tbl_voucher_details using (voucher_id)
                INNER join chart_of_accounts using (accounts_head_id)
                LEFT JOIN tbl_client on tbl_voucher.party_id=tbl_client.client_id
            WHERE
                tbl_voucher.approve_by is not NULL
                and tbl_voucher_details.accounts_head_id=?
                and (tbl_voucher.account_no = ? or tbl_voucher.to_account_no = ?)
                and tbl_voucher.voucher_date between ? and ? ";
        $query = $this->db->query($sql,array($accountsHeadId,$accountNo,$accountNo,$fromDate,$toDate));
        return $query->result_array();
    }

    function employeeTransectionsData($employeeId,$fromDate,$toDate)
    {
      $sql= "SELECT
                tbl_voucher.voucher_id,
                tbl_voucher.voucher_number,
                tbl_voucher.voucher_date,
                tbl_voucher.voucher_type,
                tbl_client.client_name,
                tbl_voucher_details.particulers,
                if(tbl_voucher_details.transection_type='Cr',tbl_voucher_details.amount,0) as crAmount,
                if(tbl_voucher_details.transection_type='Dr',tbl_voucher_details.amount,0) as drAmount
            FROM
                tbl_voucher
                INNER JOIN tbl_voucher_details using (voucher_id)
                INNER join chart_of_accounts using (accounts_head_id)
                LEFT JOIN tbl_client on tbl_voucher.party_id=tbl_client.client_id
            WHERE
                tbl_voucher.approve_by is not NULL
                and tbl_voucher_details.employee_id=?
                and tbl_voucher.voucher_date between ? and ? ";
        $query = $this->db->query($sql,array($employeeId,$fromDate,$toDate));
        return $query->result_array();
    }

    function carTransectionsData($carId,$fromDate,$toDate)
    {
      $sql= "SELECT
                tbl_voucher.voucher_id,
                tbl_voucher.voucher_number,
                tbl_voucher.voucher_date,
                tbl_voucher.voucher_type,
                tbl_client.client_name,
                tbl_voucher_details.particulers,
                sum(if(tbl_voucher_details.transection_type='Dr' and tbl_voucher_details.accounts_head_id in (47,109), tbl_voucher_details.amount,0)) as maintenance,
                sum(if(tbl_voucher_details.transection_type='Dr' and tbl_voucher_details.accounts_head_id =108, tbl_voucher_details.amount,0)) as repair,
                sum(if(tbl_voucher_details.transection_type='Dr' and tbl_voucher_details.accounts_head_id=48,tbl_voucher_details.amount,0)) as toll,
                sum(if(tbl_voucher_details.transection_type='Dr' and tbl_voucher_details.accounts_head_id=102,tbl_voucher_details.amount,0)) as octane,
                sum(if(tbl_voucher_details.transection_type='Dr' and tbl_voucher_details.accounts_head_id=74,tbl_voucher_details.amount,0)) as cng
            FROM
                tbl_voucher
                INNER JOIN tbl_voucher_details using (voucher_id)
                INNER join chart_of_accounts using (accounts_head_id)
                LEFT JOIN tbl_client on tbl_voucher.party_id=tbl_client.client_id
            WHERE
                tbl_voucher.approve_by is not NULL
                and tbl_voucher_details.accounts_head_id in (47,48,74,102,108,109)
                and tbl_voucher_details.car_id=?
                and tbl_voucher.voucher_date between ? and ?
            GROUP BY
                tbl_voucher.voucher_date";
        $query = $this->db->query($sql,array($carId,$fromDate,$toDate));
        return $query->result_array();
    }

    function getTrailBalance($fromDate,$toDate)
    {
      $sql= "SELECT
                chart_of_accounts.accounts_head_id,
                chart_of_accounts.head_name,
                chart_of_accounts.group_id,
                chart_of_accounts.sub_group_id,
                chart_of_accounts.transection_type as accounts_type,
                sum(if(tbl_voucher_details.transection_type='Dr' and tbl_voucher.voucher_date < ?,tbl_voucher_details.amount,0)) as openingDrAmount,
                sum(if(tbl_voucher_details.transection_type='Cr' and tbl_voucher.voucher_date < ?,tbl_voucher_details.amount,0)) as openingCrAmount,
                sum(if(tbl_voucher_details.transection_type='Dr' and tbl_voucher.voucher_date between ? and ?,tbl_voucher_details.amount,0)) as drAmount,
                sum(if(tbl_voucher_details.transection_type='Cr' and tbl_voucher.voucher_date between ? and ?,tbl_voucher_details.amount,0)) as crAmount
            FROM
                tbl_voucher
                INNER JOIN tbl_voucher_details using (voucher_id)
                INNER join chart_of_accounts using (accounts_head_id)
            WHERE
                tbl_voucher.approve_by is not NULL

            group by
                chart_of_accounts.accounts_head_id
            order by chart_of_accounts.group_id,chart_of_accounts.sub_group_id,accounts_head_id asc
              ";
              $query = $this->db->query($sql,array($fromDate,$fromDate,$fromDate,$toDate,$fromDate,$toDate));
              return $query->result_array();
    }

    function getGroupSumData($accoutsGroupId,$fromDate,$toDate)
    {
      $sql= "SELECT
                  chart_of_accounts.accounts_head_id,
                  chart_of_accounts.head_name,
                  ifnull(
                    sum(
                      if(
                        chart_of_accounts.transection_type='Debit',
                        (if(tbl_voucher_details.transection_type='Dr',tbl_voucher_details.amount,0) - if(tbl_voucher_details.transection_type='Cr',tbl_voucher_details.amount,0)),
                        (if(tbl_voucher_details.transection_type='Cr',tbl_voucher_details.amount,0) - if(tbl_voucher_details.transection_type='Dr',tbl_voucher_details.amount,0))
                      )),0) as amount
              FROM
                  tbl_voucher
                  INNER JOIN tbl_voucher_details using (voucher_id)
                  INNER JOIN chart_of_accounts using (accounts_head_id)
              WHERE
                  tbl_voucher.approve_by is not NULL
                  and chart_of_accounts.group_id = ?
                  and tbl_voucher.voucher_date between ? and ?
              group by
                  chart_of_accounts.accounts_head_id
                ";
          $query = $this->db->query($sql,array($accoutsGroupId,$fromDate,$toDate));
          return $query->result_array();
    }

    function getGroupSumDataWithoutJV($accoutsGroupId,$fromDate,$toDate)
    {
      $sql= "SELECT
                  chart_of_accounts.accounts_head_id,
                  chart_of_accounts.head_name,
                  ifnull(
                    sum(
                      if(
                        chart_of_accounts.transection_type='Debit',
                        (if(tbl_voucher_details.transection_type='Dr',tbl_voucher_details.amount,0) - if(tbl_voucher_details.transection_type='Cr',tbl_voucher_details.amount,0)),
                        (if(tbl_voucher_details.transection_type='Cr',tbl_voucher_details.amount,0) - if(tbl_voucher_details.transection_type='Dr',tbl_voucher_details.amount,0))
                      )),0) as amount
              FROM
                  tbl_voucher
                  INNER JOIN tbl_voucher_details using (voucher_id)
                  INNER JOIN chart_of_accounts using (accounts_head_id)
              WHERE
                  tbl_voucher.approve_by is not NULL
                  and tbl_voucher.voucher_type != 'journal'
                  and chart_of_accounts.group_id = ?
                  and tbl_voucher.voucher_date between ? and ?
              group by
                  chart_of_accounts.accounts_head_id
                ";
          $query = $this->db->query($sql,array($accoutsGroupId,$fromDate,$toDate));
          return $query->result_array();
    }

    function getSubGroupSumData($accoutsGroupId,$accountsSubGroup,$fromDate,$toDate)
    {
      $sql= "SELECT
                  chart_of_accounts.accounts_head_id,
                  chart_of_accounts.head_name,
                  ifnull(
                    sum(
                      if(
                        chart_of_accounts.transection_type='Debit',
                        (if(tbl_voucher_details.transection_type='Dr',tbl_voucher_details.amount,0) - if(tbl_voucher_details.transection_type='Cr',tbl_voucher_details.amount,0)),
                        (if(tbl_voucher_details.transection_type='Cr',tbl_voucher_details.amount,0) - if(tbl_voucher_details.transection_type='Dr',tbl_voucher_details.amount,0))
                      )),0) as amount
              FROM
                  tbl_voucher
                  INNER JOIN tbl_voucher_details using (voucher_id)
                  INNER JOIN chart_of_accounts using (accounts_head_id)
              WHERE
                  tbl_voucher.approve_by is not NULL
                  and chart_of_accounts.group_id = ?
                  and chart_of_accounts.sub_group_id = ?
                  and tbl_voucher.voucher_date between ? and ?
              group by
                  chart_of_accounts.accounts_head_id
                ";
          $query = $this->db->query($sql,array($accoutsGroupId,$accountsSubGroup,$fromDate,$toDate));
          return $query->result_array();
    }

    function getAccountHeadSumData($accountsHeadId,$fromDate,$toDate)
    {
      $sql= "SELECT
                  chart_of_accounts.accounts_head_id,
                  chart_of_accounts.head_name,
                  ifnull(
                    sum(
                      if(
                        chart_of_accounts.transection_type='Debit',
                        (if(tbl_voucher_details.transection_type='Dr',tbl_voucher_details.amount,0) - if(tbl_voucher_details.transection_type='Cr',tbl_voucher_details.amount,0)),
                        (if(tbl_voucher_details.transection_type='Cr',tbl_voucher_details.amount,0) - if(tbl_voucher_details.transection_type='Dr',tbl_voucher_details.amount,0))
                      )),0) as amount
              FROM
                  tbl_voucher
                  INNER JOIN tbl_voucher_details using (voucher_id)
                  INNER JOIN chart_of_accounts using (accounts_head_id)
              WHERE
                  tbl_voucher.approve_by is not NULL
                  and chart_of_accounts.accounts_head_id = ?
                  and tbl_voucher.voucher_date between ? and ?
              group by
                  chart_of_accounts.accounts_head_id
                ";
          $query = $this->db->query($sql,array($accountsHeadId,$fromDate,$toDate));
          return $query->result_array();
    }

    function getSubGroupSumDataWithoutJV($accoutsGroupId,$accountsSubGroup,$fromDate,$toDate)
    {
      $sql= "SELECT
                  chart_of_accounts.accounts_head_id,
                  chart_of_accounts.head_name,
                  ifnull(
                    sum(
                      if(
                        chart_of_accounts.transection_type='Debit',
                        (if(tbl_voucher_details.transection_type='Dr',tbl_voucher_details.amount,0) - if(tbl_voucher_details.transection_type='Cr',tbl_voucher_details.amount,0)),
                        (if(tbl_voucher_details.transection_type='Cr',tbl_voucher_details.amount,0) - if(tbl_voucher_details.transection_type='Dr',tbl_voucher_details.amount,0))
                      )),0) as amount
              FROM
                  tbl_voucher
                  INNER JOIN tbl_voucher_details using (voucher_id)
                  INNER JOIN chart_of_accounts using (accounts_head_id)
              WHERE
                  tbl_voucher.approve_by is not NULL
                  and tbl_voucher.voucher_type != 'journal'
                  and chart_of_accounts.group_id = ?
                  and chart_of_accounts.sub_group_id = ?
                  and tbl_voucher.voucher_date between ? and ?
              group by
                  chart_of_accounts.accounts_head_id
                ";
          $query = $this->db->query($sql,array($accoutsGroupId,$accountsSubGroup,$fromDate,$toDate));
          return $query->result_array();
    }


}
?>
