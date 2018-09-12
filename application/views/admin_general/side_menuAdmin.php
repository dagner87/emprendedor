    <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav slimscrollsidebar">
                <div class="sidebar-head">
                    <h3><span class="fa-fw open-close"><i class="ti-close ti-menu"></i></span> <span class="hide-menu">Navigation</span></h3> </div>
                <div class="user-profile">
                    <div class="dropdown user-pro-body">
                        <div><img src="<?php echo base_url();?>assets/plugins/images/users/varun.jpg" alt="user-img" class="img-circle"></div>
                        <a href="#" class="dropdown-toggle u-dropdown" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?= $this->session->userdata('nombre');?></a>
                       
                    </div>
                </div>

                 <!--MENU -->
                <ul class="nav" id="side-menu">
                  <li> <a href="<?php echo base_url();?>" class="waves-effect"><i class="mdi mdi-home-variant fa-fw"></i> <span class="hide-menu">MENU</span></a></li>
                  <li><a href="javascript:void(0)"  data-toggle="modal" data-target="#enviarInvitacion"><i class="ti-plus fa-fw"></i> <span class="hide-menu">Enviar invitación</span></a></li>

                    <li> <a href="javascript:void(0)" class="waves-effect"><i class="mdi mdi-rename-box fa-fw"></i> <span class="hide-menu">Capacitación<span class="fa arrow"></span> <span class="label label-rouded label-info pull-right">7</span> </span></a>
                        <ul class="nav nav-second-level">

                            <li><a href="<?php echo base_url();?>panel_admin/admin_capacitacion"><i class="fa fa-file-video-o fa-fw"></i> <span class="hide-menu">Adm. Videos</span></a></li>
                        </ul>
                    </li>
                    <li><a href="javascript:void(0)" class="waves-effect"><i class="mdi mdi-store fa-fw"></i> <span class="hide-menu">Tienda<span class="fa arrow"></span></span></a>
                        <ul class="nav nav-second-level">
                            <li><a href="<?php echo base_url();?>panel_admin/admin_prod"><i class="fa fa-shopping-cart fa-fw"></i><span class="hide-menu">Adm. Productos</span></a></li>
                         
                        </ul>
                    </li>
                  
                    <li class="devider"></li>
                    <li><a href="<?php echo base_url();?>salir" class="waves-effect"><i class="mdi mdi-logout fa-fw"></i> <span class="hide-menu">Salir</span></a></li>
                    <li class="devider"></li>
                   
                </ul>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- End Left Sidebar -->
        <!-- ============================================================== -->

        <div id="page-wrapper">
             <div class="container-fluid">

           