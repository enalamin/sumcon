<header class="main-header">

    <a href="<?php echo base_url(); ?>welcome" class="logo">

        <!-- LOGO -->

       

        <img src="<?php echo base_url()."images/sumcon.jpg";?>" style="width: 180px;height: 55px;">

    </a>

    <!-- Header Navbar: style can be found in header.less -->

    <nav class="navbar navbar-static-top" role="navigation">

        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">

            <span class="sr-only">Toggle navigation</span>

            <span class="icon-bar"></span>

            <span class="icon-bar"></span>

            <span class="icon-bar"></span>

          </a>

        <!-- Navbar Right Menu -->

        <div class="navbar-custom-menu">

            <ul class="nav navbar-nav">

               

                <!-- User Account: style can be found in dropdown.less -->

                <li class="dropdown user user-menu">

                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">

                        <img src="<?php echo base_url(); ?>dist/img/avatar5.png" class="user-image" alt="User Image">

                        <span class="hidden-xs"><?php echo $this->session->userdata('username')?></span>

                    </a>

                    <ul class="dropdown-menu">

                        <!-- User image -->

                        <li class="user-header">

                            <img src="<?php echo base_url(); ?>dist/img/avatar5.png" class="img-circle" alt="User Image">

                            <p>

                                <?php echo $this->session->userdata('username');

                                    

                                ?>

                                

                            </p>

                        </li>

                        <!-- Menu Body -->

                       

                        <!-- Menu Footer-->

                        <li class="user-footer">

                            <div class="pull-left">

                                <a href="#" class="btn btn-default btn-flat">Profile</a>

                            </div>

                            <div class="pull-right">

                                <a href="<?php echo base_url(); ?>login/logOut" class="btn btn-default btn-flat">Sign out</a>

                            </div>

                        </li>

                    </ul>

                </li>

            </ul>

        </div>

    </nav>

</header>