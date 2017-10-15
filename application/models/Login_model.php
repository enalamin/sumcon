<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login_model extends CI_Model
{
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
		$this->db->query("SET time_zone='+6:00'");
    }

    //get the username & password from tbl_usrs
    function get_user($usr, $pwd)
    {
        $sql = "select * from tbl_user where username = ? and password = ? and status = 'active'";
        $query = $this->db->query($sql,array($usr,md5($pwd)));
        return $query->result_array();
    }
    
    function get_user_menu($userId)
    {
        $userMenu = array();       
        
        $sql = "SELECT 
                    tbl_menu.id,menu_title
                FROM 
                    tbl_menu 
                    inner join tbl_user_menu on (tbl_menu.id=tbl_user_menu.menu_id and tbl_user_menu.view_status=1) 
                WHERE 
                    1 
                    and tbl_menu.view_status = 1 
                    and tbl_menu.parent_id=0
                    and tbl_user_menu.user_id=? 
                order by 
                    tbl_menu.id
                ";
        $query = $this->db->query($sql,array($userId));
        if($query->num_rows()>0){
            $parentMenu=$query->result_array();
            $i=0;
            foreach ($parentMenu as $pMenu){
                $sqlSubmenu="SELECT 
                                tbl_menu.id,menu_title,url
                            FROM 
                                tbl_menu 
                                inner join tbl_user_menu on (tbl_menu.id=tbl_user_menu.menu_id and tbl_user_menu.view_status=1) 
                            WHERE 
                                1 
                                and tbl_menu.view_status = 1 
                                and tbl_menu.parent_id!=0
                                and tbl_menu.parent_id =?
                                and tbl_user_menu.user_id=? 
                            order by 
                                tbl_menu.id
                            ";
                $subQuery = $this->db->query($sqlSubmenu,array($pMenu["id"],$userId));
                if($subQuery->num_rows()>0){
                    $userMenu[$i]['pId']=$pMenu["id"];
                    $userMenu[$i]['pTitle']=$pMenu["menu_title"];
                    $userMenu[$i]['cMenu']=  array($subQuery->result_array());
                    $i++;
                }
            }
        }
        return $userMenu;
    }
    
    function get_admin_menu()
    {      
        
        $userMenu = array();       
        
        $sql = "SELECT 
                    tbl_menu.id,menu_title
                FROM 
                    tbl_menu 
                WHERE 
                    1 
                    and tbl_menu.view_status = 1 
                    and tbl_menu.parent_id=0
                order by 
                    tbl_menu.id
                ";
        $query = $this->db->query($sql);
        if($query->num_rows()>0){
            $i=0;
            $parentMenu=$query->result_array();
            foreach ($parentMenu as $pMenu){
                $sqlSubmenu="SELECT 
                    tbl_menu.id,menu_title,url
                FROM 
                    tbl_menu 
                    
                WHERE 
                    1 
                    and tbl_menu.view_status = 1 
                    and tbl_menu.parent_id!=0
                    and tbl_menu.parent_id =?
                    
                order by 
                    tbl_menu.id
                ";
                $subQuery = $this->db->query($sqlSubmenu,array($pMenu["id"]));
                if($subQuery->num_rows()>0){
                    $userMenu[$i]['pId']=$pMenu["id"];
                    $userMenu[$i]['pTitle']=$pMenu["menu_title"];
                    $userMenu[$i]['cMenu']=  array($subQuery->result_array());
                    $i++;
                }
            }
        }
        return $userMenu;
    }
}
?>