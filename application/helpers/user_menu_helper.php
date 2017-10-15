<?php
/* Begin file user_menu_helper.php */
if(!function_exists('adminMenu'))
{
    /**
     * isAuthorized Function
     *
     * isAuthorized($auth_string, $date='', $method='', $query_string='')
     *
     * $auth_string  : The authorization string from the request
     * $date         : The date from the request
     * $method       : The method from the request
     * $query_string : The query string from the request
     *
     * Returns whether or not the request is authorized to access the service.
     *
     * @access  public
     * @return  array()
     * 
     **/
    function adminMenu()
    {
        $CI =& get_instance();
        $default_db = $CI->load->database('default', TRUE);

        
        $userMenu = array();       
        
        $sql = "SELECT 
                    tbl_menu.id,menu_title,url
                FROM 
                    tbl_menu 
                WHERE 
                    1 
                    and tbl_menu.view_status = 1 
                    and tbl_menu.parent_id=0
                order by 
                    tbl_menu.id
                ";
        $query = $default_db->query($sql);
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
                $subQuery = $default_db->query($sqlSubmenu,array($pMenu["id"]));
               // if($subQuery->num_rows()>0)
                    {
                    $userMenu[$i]['pId']=$pMenu["id"];
                    $userMenu[$i]['pTitle']=$pMenu["menu_title"];
                    $userMenu[$i]['pUrl']=$pMenu["url"];
                    $userMenu[$i]['cMenu']=  array($subQuery->result_array());
                    $i++;
                }
            }
        }
        return $userMenu;
        
    }
}

if(!function_exists('userMenu'))
{
    /**
     * isAuthorized Function
     *
     * isAuthorized($auth_string, $date='', $method='', $query_string='')
     *
     * $auth_string  : The authorization string from the request
     * $date         : The date from the request
     * $method       : The method from the request
     * $query_string : The query string from the request
     *
     * Returns whether or not the request is authorized to access the service.
     *
     * @access  public
     * @return  array()
     * 
     **/
    function userMenu($userId)
    {
        $CI =& get_instance();
        $default_db = $CI->load->database('default', TRUE);
        $userMenu = array();       

        $sql = "SELECT 
                    tbl_menu.id,menu_title,url
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
        $query = $default_db->query($sql,array($userId));
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
                $subQuery = $default_db->query($sqlSubmenu,array($pMenu["id"],$userId));
                if($subQuery->num_rows()>0){
                    $userMenu[$i]['pId']=$pMenu["id"];
                    $userMenu[$i]['pTitle']=$pMenu["menu_title"];
                    $userMenu[$i]['pUrl']=$pMenu["url"];
                    $userMenu[$i]['cMenu']=  array($subQuery->result_array());
                    $i++;
                }
            }
        }
        return $userMenu;
        
    }
}
