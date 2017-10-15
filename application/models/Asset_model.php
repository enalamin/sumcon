<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Asset_model extends CI_Model
{
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
		    $this->db->query("SET time_zone='+6:00'");
    }


    function get_asset($assetId=NULL)
    {
        if($assetId==NULL){
            $sql = "select 
                        tbl_asset.*,ifnull(sum(expenses_amount),0) as additional_expenses 
                    from 
                        tbl_asset
                        left join tbl_asset_additional_expenses using(asset_id)
                    group by
                        asset_id
                    order by
                        tbl_asset.asset_type,tbl_asset.asset_name asc";
            $query = $this->db->query($sql);
        }else {
            $sql = "select 
                        tbl_asset.*,ifnull(sum(expenses_amount),0) as additional_expenses 
                    from 
                        tbl_asset
                        left join tbl_asset_additional_expenses using(asset_id)
                    where 
                        1 and asset_id=?";
            $query = $this->db->query($sql,array($assetId));
        }

        return $query->result_array();
    }

    function get_asset_by_type($assetType)
    {
        $sql = "select 
                        tbl_asset.*,ifnull(sum(expenses_amount),0) as additional_expenses 
                    from 
                        tbl_asset
                        left join tbl_asset_additional_expenses on (tbl_asset.asset_id=tbl_asset_additional_expenses.asset_id and tbl_asset_additional_expenses.expenses_date between '".(date('Y')-1).'-07-01'."' and '".date('Y').'-06-30'."')
                    where
                        tbl_asset.asset_type=?
                    group by
                        asset_id
                    order by
                        tbl_asset.asset_type,tbl_asset.asset_name asc";
        $query = $this->db->query($sql,array($assetType));
        
        return $query->result_array();
    }

    function create_asset($data)
    {
        return $this->db->insert('tbl_asset', $data);
    }

    function additional_expenses($data)
    {
        return $this->db->insert('tbl_asset_additional_expenses', $data);
    }

    function asset_depreciation($data)
    {
        return $this->db->replace('tbl_asset_depreciation',$data);
    }

    function get_asset_depreciation($depreciationYear,$assetType = NULL)
    {
        if($assetType){
            $sql = "select 
                            tbl_asset.asset_name,tbl_asset.asset_type,purchase_value,purchase_date,tbl_asset_depreciation.* 
                        from 
                            tbl_asset
                            inner join tbl_asset_depreciation on (tbl_asset.asset_id=tbl_asset_depreciation.asset_id and tbl_asset_depreciation.depreciation_year=?)
                        where
                            tbl_asset.asset_type=?
                        order by
                            tbl_asset.asset_type,tbl_asset.asset_name asc";
            $query = $this->db->query($sql,array($depreciationYear,$assetType));
        } else {
            $sql = "select 
                            tbl_asset.asset_name,tbl_asset.asset_type,purchase_value,purchase_date,tbl_asset_depreciation.* 
                        from 
                            tbl_asset
                            inner join tbl_asset_depreciation on (tbl_asset.asset_id=tbl_asset_depreciation.asset_id and tbl_asset_depreciation.depreciation_year=?)
                        order by
                            tbl_asset.asset_type,tbl_asset.asset_name asc";
            $query = $this->db->query($sql,array($depreciationYear));
        }
        
        return $query->result_array();
    }



}
?>
