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
                        <a href="#" class="dropdown-toggle u-dropdown" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dagner Alena Guerra </a>
                       
                    </div>
                </div>

                 <!--MENU -->
                <ul class="nav" id="side-menu">
                  <li> <a href="<?php echo base_url();?>capacitacion" class="waves-effect"><i class="mdi mdi-calendar-check fa-fw"></i> <span class="hide-menu">MENU</span></a></li>

                    <li> <a href="javascript:void(0)" class="waves-effect"><i class="mdi mdi-rename-box fa-fw"></i> <span class="hide-menu">Capacitación<span class="fa arrow"></span> <span class="label label-rouded label-info pull-right">20</span> </span></a>
                        <ul class="nav nav-second-level">

                            <li><a href="<?php echo base_url();?>capacitacion/modulos"><i class="fa fa-file-video-o fa-fw"></i> <span class="hide-menu">Videos</span></a></li>
                              
                          <li><a href="<?php echo base_url();?>capacitacion/calendario"><i class="fa fa-calendar fa-fw"></i> <span class="hide-menu">Calendario</span></a></li>
                        </ul>
                    </li>
                    <li> <a href="javascript:void(0)" class="waves-effect"><i class="fa fa-users fa-fw"></i> <span class="hide-menu">Asociados<span class="fa arrow"></span><span class="label label-rouded label-warning pull-right">10</span></span></a>
                        <ul class="nav nav-second-level">
                         <li><a href="javascript:void(0)"  data-toggle="modal" data-target="#myModal"><i class="ti-plus fa-fw"></i> <span class="hide-menu">Agregar Asociado</span></a></li>
                          <li><a href="<?php echo base_url();?>capacitacion/mi_red"><i class="ti-layers-alt fa-fw"></i> <span class="hide-menu">Mi Red</span></a></li>
                        </ul>
                    </li>
                    <li><a href="javascript:void(0)" class="waves-effect"><i class="mdi mdi-store fa-fw"></i> <span class="hide-menu">Tienda<span class="fa arrow"></span></span></a>
                        <ul class="nav nav-second-level">
                            <li><a href="<?php echo base_url();?>capacitacion/tienda"><i class="fa fa-shopping-cart fa-fw"></i><span class="hide-menu">Ver Tienda</span></a></li>
                         
                        </ul>
                    </li>

                     <li><a href="javascript:void(0)" class="waves-effect"><i class="ion icon-wallet fa-fw"></i> <span class="hide-menu">Mi cuenta Corriente<span class="fa arrow"></span></span></a>
                        <ul class="nav nav-second-level">
                            <li><a href="carousel.html"><i class="fa fa-tasks fa-fw"></i><span class="hide-menu">Ver Historial</span></a></li>
                         
                        </ul>
                    </li>
                    <li class="devider"></li>
                    <li><a href="salir" class="waves-effect"><i class="mdi mdi-logout fa-fw"></i> <span class="hide-menu">Salir</span></a></li>
                    <li class="devider"></li>
                   
                </ul>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- End Left Sidebar -->
        <!-- ============================================================== -->

        <div id="page-wrapper">
             <div class="container-fluid">

           <!-- .modal for add task -->
                            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                            <h4 class="modal-title">Nuevo Asociado</h4>
                                        </div>
                                        <div class="modal-body">
                                            <form id="add_asoc" action="" method="">
                                        <div class="form-group">
                                            <label for="exampleInputuname">Nombre Completo</label>
                                            <div class="input-group">
                                                <div class="input-group-addon"><i class="ti-user"></i></div>
                                                <input type="text" class="form-control" name="nombre_asoc" id="nombre_asoc" placeholder=" Escriba Nombre Completo"> </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputphone">DNI</label>
                                            <div class="input-group">
                                                <div class="input-group-addon"><i class="ti-credit-card"></i></div>
                                                <input type="tel" class="form-control" name="dni__asoc" id="dni__asoc" placeholder="Escriba DNI"> </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Correo</label>
                                            <div class="input-group">
                                                <div class="input-group-addon"><i class="ti-email"></i></div>
                                                <input type="email" class="form-control"  name="email" id="email" placeholder=" Escriba Email"> </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="exampleInputphone">Telefono</label>
                                            <div class="input-group">
                                                <div class="input-group-addon"><i class="ti-mobile"></i></div>
                                                <input type="tel" class="form-control" name="telefono_asoc" id="telefono_asoc" placeholder="Escriba telefono"> </div>
                                        </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                            <button type="submit" class="btn btn-primary">Agregar</button>
                                        </div>
                                         </form>
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div>
                            <!-- /.modal -->