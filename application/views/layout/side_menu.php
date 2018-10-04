    <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav slimscrollsidebar">
                <div class="sidebar-head">
                    <h3><span class="fa-fw open-close"><i class="ti-close ti-menu"></i></span> <span class="hide-menu">Navigation</span></h3> </div>
                <div class="user-profile">
                    <div class="dropdown user-pro-body">
                        <div><img src="<?php echo base_url();?>assets/plugins/images/users/<?= $datos_emp->foto_emp; ?>" alt="user-img" class="img-circle"></div>
                        <a href="#" class="dropdown-toggle u-dropdown" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?= $this->session->userdata('nombre');?></a>
                       
                    </div>
                </div>


  <?php if ($datos_emp->id_cap  == $ultimo_reg->id_cap): ?>
 <button id="view_car" class="botonF1 tooltip-demo" title=" Ver Carrito">
  <span><i class="ti-shopping-cart"></i></span>
</button>
 <?php endif; ?> 



                 <!--MENU -->
                <ul class="nav" id="side-menu">
                  <li> <a href="<?php echo base_url();?>" class="waves-effect"><i class="mdi mdi-home-variant fa-fw"></i> <span class="hide-menu">MENU</span></a></li>
                    <li> <a href="javascript:void(0)" class="waves-effect"><i class="mdi mdi-rename-box fa-fw"></i> <span class="hide-menu">Capacitación<span class="fa arrow"></span> <span class="label label-rouded label-info pull-right"><?= $cantidadVideos ?></span> </span></a>
                        <ul class="nav nav-second-level">
                            <li><a href="<?php echo base_url();?>capacitacion/modulos"><i class="fa fa-file-video-o fa-fw"></i> <span class="hide-menu">Videos</span></a></li>
                          <!--li><a href="<?php echo base_url();?>capacitacion/calendario"><i class="fa fa-calendar fa-fw"></i> <span class="hide-menu">Calendario</span></a></li-->
                        </ul>
                    </li>
                    
                     
                    <?php 
                     if ($datos_emp->id_cap  == $ultimo_reg->id_cap): ?>
                       
                    
                    <li><a href="javascript:void(0)" class="waves-effect"><i class="mdi mdi-store fa-fw"></i> <span class="hide-menu">Tienda<span class="fa arrow"></span></span></a>
                        <ul class="nav nav-second-level">
                            <li><a href="<?php echo base_url();?>tienda"><i class="fa fa-shopping-cart fa-fw"></i><span class="hide-menu">Ver Tienda</span></a></li>
                         
                        </ul>
                    </li>
                    
                    <li> <a href="javascript:void(0)" class="waves-effect"><i class="fa fa-users fa-fw"></i> <span class="hide-menu">Asociados<span class="fa arrow"></span><span class="label label-rouded label-warning pull-right"><?= $cant_asoc;?></span></span></a>
                        <ul class="nav nav-second-level">
                          <li><a href="javascript:void(0)"  data-toggle="modal" data-target="#enviarInvitacion"><i class="ti-email fa-fw"></i> <span class="hide-menu">Enviar invitación</span></a></li>
                          <li><a href="<?php echo base_url();?>capacitacion/mi_red"><i class="ti-layers-alt fa-fw"></i> <span class="hide-menu">Mi Red</span></a></li>
                        </ul>
                    </li>
                    

                     <li><a href="javascript:void(0)" class="waves-effect"><i class="mdi mdi-wallet fa-fw"></i> <span class="hide-menu">Mi cuenta Corriente<span class="fa arrow"></span></span></a>
                        <ul class="nav nav-second-level">
                            <li><a href="<?php echo base_url();?>capacitacion/mis_compras"><i class="fa fa-tasks fa-fw"></i><span class="hide-menu">Ver Mis Compras</span></a></li>
<<<<<<< HEAD
                            <li><a href="<?php echo base_url();?>capacitacion/mi_cartera"><i class="mdi mdi-cash-multiple fa-fw"></i><span class="hide-menu">Mi Cartera</span></a></li>
=======
                            <li><a href="<?php echo base_url();?>capacitacion/mi_cartera"><i class="mdi mdi-cash-multiple fa-fw"></i><span class="hide-menu">Mi billetera virtual </span></a></li>
>>>>>>> 9f2d7f1513c0855d5515d7b035f9d882e9e78949
                        </ul>
                    </li>


                     <li><a href="javascript:void(0)" class="waves-effect"><i class="mdi mdi-account-card-details fa-fw"></i> <span class="hide-menu">Consultas Cartera<span class="fa arrow"></span></span></a>
                        <ul class="nav nav-second-level">
                            <li><a href="<?php echo base_url();?>cartera_clientes"><i class="fa fa-flag-checkered fa-fw"></i><span class="hide-menu">Alta de Clientes</span></a></li>
                         
                        </ul>
                    </li>

                    <li><a href="javascript:void(0)" class="waves-effect"><i class="mdi mdi-buffer fa-fw"></i> <span class="hide-menu">Ventas<span class="fa arrow"></span></span></a>
                        <ul class="nav nav-second-level">
                            <li><a href="<?php echo base_url();?>ventas"><i class="fa fa-circle-thin fa-fw"></i><span class="hide-menu">Gestión de Ventas</span></a></li>
                            <li><a href="<?php echo base_url();?>almacen"><i class="fa fa-circle-thin fa-fw"></i><span class="hide-menu">Almacen de productos</span></a></li>
                         
                        </ul>
                    </li>



                     <li><a href="javascript:void(0)" class="waves-effect"><i class="mdi mdi-alarm-multiple fa-fw"></i> <span class="hide-menu">Vencimientos<span class="fa arrow"></span></span></a>
                        <ul class="nav nav-second-level">
                            <li><a href="<?php echo base_url();?>vencimientos"><i class="fa fa-bell-o fa-fw"></i><span class="hide-menu">Venc. de Productos</span></a></li>
                         
                        </ul>
                    </li>
                    
                    



                     <?php endif; ?> 
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
