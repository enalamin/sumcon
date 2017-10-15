<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?php echo base_url(); ?>dist/img/avatar5.png" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p><?php echo $this->session->userdata('username')?></p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            <li class="header">NAVIGATION</li>
            <li class="active treeview">
                <a href="<?php echo base_url()?>">
                    <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                </a>

            </li>
            <?php
            if($this->session->has_userdata('userType') && $this->session->userdata('userType')=="admin"){
            ?>
                <li class="treeview">
                <a href="#">
                    <i class="fa fa-folder"></i> <span>Setup</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?php echo base_url()?>user"><i class="fa fa-circle-o"></i> User</a></li>
                    <li><a href="<?php echo base_url()?>user/menu"><i class="fa fa-circle-o"></i> Menu</a></li>
                    <li><a href="<?php echo base_url()?>user/menupermission"><i class="fa fa-circle-o"></i> User Permission</a></li>

                </ul>
            </li>
            <?php
			         $sideMenu = adminMenu();
            }else{
				       $sideMenu = userMenu($this->session->userdata('userId'));
            }
            $parentMenu='';

            foreach ($sideMenu as $menu){
                echo '<li class="treeview '.(ucwords($this->session->userdata('activeSidebar'))==$menu['pTitle']?"active":"").'">
                <a href="'.base_url().$menu['pUrl'].'">
                    <i class="fa fa-folder"></i> <span>'.$menu['pTitle'].'</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>';
                if($menu['cMenu']){
                    echo '<ul class="treeview-menu">';
                
                    foreach ($menu['cMenu'] as $cMenu){
                        foreach ($cMenu as $subMenu){
                          echo '<li><a href="'.base_url().$subMenu['url'].'"><i class="fa fa-circle-o"></i> '.$subMenu['menu_title'].'</a></li>';
                        }
                    }
                    if($menu['pTitle']=='Sales' && ($this->session->has_userdata('userType') && $this->session->userdata('userType')=="admin") ){
                        echo '<li><a href="'.base_url().'sales/partyreceivable"><i class="fa fa-circle-o"></i> Adjust Receivable</a></li>';
                    }
                    echo '</ul>';
                }
                echo '</li>';
            }

            ?>
            <?php
            if(($this->session->has_userdata('userType') && $this->session->userdata('userType')=="admin") || in_array($this->session->userdata('username'),array('Iqbal','Rasel'))){
            ?>
            <li class="treeview">
                <a href="<?php echo base_url()?>accounts">
                    <i class="fa fa-folder"></i> <span>Accounts</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
            </li>
          <?php
          }
          if(($this->session->has_userdata('userType') && $this->session->userdata('userType')=="admin")){
          ?>
          <li class="treeview">
              <a href="<?php echo base_url()?>lcmanagement">
                  <i class="fa fa-folder"></i> <span>LC Management</span>
                  <i class="fa fa-angle-left pull-right"></i>
              </a>
          </li>
          <?php
          }
          ?>
            <!--
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-share"></i> <span>Reports</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="#"><i class="fa fa-circle-o"></i> Level One</a></li>
                    <li>
                        <a href="#"><i class="fa fa-circle-o"></i> Level One <i class="fa fa-angle-left pull-right"></i></a>
                        <ul class="treeview-menu">
                            <li><a href="#"><i class="fa fa-circle-o"></i> Level Two</a></li>
                            <li>
                                <a href="#"><i class="fa fa-circle-o"></i> Level Two <i class="fa fa-angle-left pull-right"></i></a>
                                <ul class="treeview-menu">
                                    <li><a href="#"><i class="fa fa-circle-o"></i> Level Three</a></li>
                                    <li><a href="#"><i class="fa fa-circle-o"></i> Level Three</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li><a href="#"><i class="fa fa-circle-o"></i> Level One</a></li>
                </ul>
            </li>
           -->
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
