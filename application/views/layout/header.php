<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo base_url();?>assets/plugins/images/favicon.ico">
    <title>Emprendedores DVIGI</title> 

    <!-- Bootstrap Core CSS -->
    <link href="<?php echo base_url();?>assets/ampleadmin-minimal/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
     <!-- Footable CSS -->
    <link href="<?php echo base_url();?>assets/plugins/bower_components/footable/css/footable.core.css" rel="stylesheet">
    <!-- Editable CSS -->
    <link rel="stylesheet" href="<?php echo base_url();?>assets/plugins/bower_components/jquery-datatables-editable/datatables.css" />
    
     <link href="<?php echo base_url();?>assets/plugins/bower_components/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
    <link href="https://cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />
     <!-- Wizard CSS -->
    <link href="<?php echo base_url();?>assets/plugins/bower_components/jquery-wizard-master/css/wizard.css" rel="stylesheet">

    <link href="<?php echo base_url();?>assets/plugins/bower_components/register-steps/steps.css" rel="stylesheet">
     
    <!-- Menu CSS -->
    <link href="<?php echo base_url();?>assets/plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/plugins/bower_components/dropify/dist/css/dropify.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/plugins/bower_components/gallery/css/animated-masonry-gallery.css" />

    <!--My admin Custom CSS -->
    <link href="<?php echo base_url();?>assets/plugins/bower_components/owl.carousel/owl.carousel.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url();?>assets/plugins/bower_components/owl.carousel/owl.theme.default.css" rel="stylesheet" type="text/css" />

    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/plugins/bower_components/fancybox/ekko-lightbox.min.css" />
    <link href="<?php echo base_url();?>assets/plugins/bower_components/calendar/dist/fullcalendar.css" rel="stylesheet" />
     <!-- Date picker plugins css -->
    <link href="<?php echo base_url();?>assets/plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
     <!-- page CSS -->
    <link href="<?php echo base_url();?>assets/plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url();?>assets/plugins/bower_components/custom-select/custom-select.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url();?>assets/plugins/bower_components/switchery/dist/switchery.min.css" rel="stylesheet" />

    <link href="<?php echo base_url();?>assets/plugins/bower_components/bootstrap-select/bootstrap-select.min.css" rel="stylesheet" />
    <link href="<?php echo base_url();?>assets/plugins/bower_components/bootstrap-tagsinput/dist/bootstrap-tagsinput.css" rel="stylesheet" />
    <link href="<?php echo base_url();?>assets/plugins/bower_components/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.css" rel="stylesheet" />
     <link href="<?php echo base_url();?>assets/plugins/bower_components/multiselect/css/multi-select.css" rel="stylesheet" type="text/css" />

    <!-- Popup CSS -->
    <link href="<?php echo base_url();?>assets/plugins/bower_components/Magnific-Popup-master/dist/magnific-popup.css" rel="stylesheet">

    <link href="<?php echo base_url();?>assets/plugins/bower_components/sweetalert/sweetalert.css" rel="stylesheet" type="text/css">
    <!-- toast CSS -->
    <link href="<?php echo base_url();?>assets/plugins/bower_components/toast-master/css/jquery.toast.css" rel="stylesheet">

    <!-- morris CSS -->
    <link href="<?php echo base_url();?>assets/plugins/bower_components/morrisjs/morris.css" rel="stylesheet">
    <!-- chartist CSS -->
    <link href="<?php echo base_url();?>assets/plugins/bower_components/chartist-js/dist/chartist.min.css" rel="stylesheet">
    <link href="<?php echo base_url();?>assets/plugins/bower_components/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.css" rel="stylesheet">
    <!-- Calendar CSS -->
    <link href="<?php echo base_url();?>assets/plugins/bower_components/calendar/dist/fullcalendar.css" rel="stylesheet" />
   
    <!-- Custom CSS -->
    <link href="<?php echo base_url();?>assets/ampleadmin-minimal/css/style.css" rel="stylesheet">
      <!-- animation CSS -->
    <link href="<?php echo base_url();?>assets/ampleadmin-minimal/css/animate.css" rel="stylesheet">
    <!-- color CSS -->
    <link href="<?php echo base_url();?>assets/ampleadmin-minimal/css/colors/default.css" id="theme" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
<link rel="stylesheet" href="<?php echo base_url();?>assets/plugins/css/hierarchy-view.css">
 <script src="<?php echo base_url();?>assets/plugins/bower_components/jquery/dist/jquery.min.js"></script>

<style type="text/css"> 
    .hv-item-parent p {
  font-weight: bold;
  color: #DE5454; }
    .management-hierarchy {
     background-color: #fff; }/*color de fondo*/
    .management-hierarchy > h1 {
    color: #2ea3f2; }
    .management-hierarchy .person {
    text-align: center; }
    .management-hierarchy .person > img {
      height: 90px;
      border: 5px solid #2ea3f2; /*color de circulo padre*/
      border-radius: 50%;
      overflow: hidden;
      background-color: #2ea3f2; } /* color guia  del padre*/
    .management-hierarchy .person > p.name {
      background-color: #2ea3f2; /*color del cuadro del nombre*/
      padding: 5px 10px;
      border-radius: 5px;
      font-size: 12px;
      font-weight: normal;
      color: #fff;  /*color de la letra */
      margin: 0;
      position: relative; }
      
      .management-hierarchy .person > p.name:before {
        content: '';
        position: absolute;
        width: 2px;
        height: 5px; /*largo del palito corto*/
        background-color: #2ea3f2;   /*color de linea pequeña hijos*/
        left: 50%;
        top: 0;

        transform: translateY(-100%); } 
        .botonF1{
              width:70px;
              height:70px;
              border-radius:80%;
              background:#2ea3f2;
              right:0;
              bottom:0;
              position:absolute;
              margin-right:16px;
              margin-bottom:16px;
              border:none;
              outline:none;
              color:#FFF;
              font-size:36px;
              box-shadow: 0 3px 6px rgba(0,0,0,0.16), 0 3px 6px rgba(0,0,0,0.23);
              transition:.3s;
              z-index: 1;  
            }
            .botonF1:active{
              transform:scale(1.1);
            } 


     


</style>

    


  
</head>

<body class="fix-header">
    <!-- ============================================================== -->
    <!-- Preloader -->
    <!-- ============================================================== -->
    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" />
        </svg>
    </div>
    <!-- ============================================================== -->
    <!-- Wrapper -->
    <!-- ============================================================== -->
    <div id="wrapper">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <nav class="navbar navbar-default navbar-static-top m-b-0">
            <div class="navbar-header">
                <div class="top-left-part">
                    <!-- Logo -->
                    <a class="logo" href="<?php echo base_url();?>">
                        <!-- Logo icon image, you can use font-icon also --><b>
                        <!--This is dark logo icon-->
                        <img src="<?php echo base_url();?>assets/plugins/images/admin-logo-dark.png" alt="home" class="light-logo">
                     </b>
                        <!-- Logo text image you can use text also -->
                        <span class="hidden-xs">
                         <!--This is light logo text-->
                        <img src="<?php echo base_url();?>assets/plugins/images/admin-text-dark.png" alt="home" class="light-logo" />
                     </span> </a>
                </div>
                <!-- /Logo --> 

                <!-- Search input and Toggle icon -->
                <ul class="nav navbar-top-links navbar-left">
                    <li><a href="javascript:void(0)" class="open-close waves-effect waves-light"><i class="ti-menu"></i></a></li>
                    <?php if ($this->session->userdata('perfil')!="administrador"):?>
                    <?php if ($cantidad_prod > 0): ?>
                      <li class="dropdown">
                        <a class="dropdown-toggle waves-effect waves-light detalle_carrito" data-toggle="dropdown"> <i class="  ti-shopping-cart"> </i>
                            <div class="notify"> <span class="heartbit"></span> <span class="point"></span> </div>
                        </a>
                        <ul class="dropdown-menu mailbox animated bounceInDown" id="cesta">
                          
                        </ul>
                        <!-- /.dropdown-messages -->
                    </li>
                      
                    <?php endif ?>
                    <?php endif ?>
                     
                   
                   
                </ul>
                <ul class="nav navbar-top-links navbar-right pull-right">

                    <li class="dropdown">
                        <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#"> <img src="<?php echo base_url();?>assets/plugins/images/users/<?= $datos_emp->foto_emp; ?>" alt="user-img" width="36" class="img-circle"><b class="hidden-xs"><?= $this->session->userdata('email');?></b><span class="caret"></span> </a>
                        <ul class="dropdown-menu dropdown-user animated flipInY">
                            <li>
                                <div class="dw-user-box">
                                    <div class="u-img"><img src="<?php echo base_url();?>assets/plugins/images/users/<?= $datos_emp->foto_emp; ?>" alt="user" /></div> 
                                    <div class="u-text">
                                        <br>
                                        <h4><?= $this->session->userdata('nombre');?></h4>
                                        <p class="text-muted"><?= $this->session->userdata('perfil');?></p>
                                        <!--a href="profile.html" class="btn btn-rounded btn-danger btn-sm">Ver Perfil</a--></div>
                                </div>
                            </li>
                            <li role="separator" class="divider"></li>
                             <?php  if ($this->session->userdata('perfil')!="administrador") {?>
                                <li><a href="#"><i class="ti-wallet"></i> Mi Balance</a></li>
                                <li role="separator" class="divider"></li>
                              <li><a href="<?php echo base_url();?>my_perfil"><i class="ti-settings"></i> Mi Perfil</a></li>  
                             <li role="separator" class="divider"></li>
                            <?php }else{  ?>
                              <li><a href="<?php echo base_url();?>MyperfilAdmin"><i class="ti-settings"></i> Mi Perfil</a></li>
                             
                             <li role="separator" class="divider"></li>
                            <?php }  ?>
                            <li><a href="<?php echo base_url();?>salir"><i class="fa fa-power-off"></i> Salir</a></li>
                        </ul>
                        <!-- /.dropdown-user -->
                    </li>
                    <!-- /.dropdown -->
                </ul>
            </div>
            <!-- /.navbar-header -->
            <!-- /.navbar-top-links -->
            <!-- /.navbar-static-side -->
        </nav> 
        <!-- End Top Navigation -->
        <!-- .modal for add task -->
                            <div class="modal fade" id="enviarInvitacion" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                            <h4 class="modal-title" id="titulo_invit">Nuevo patrocinado </h4>
                                        </div>
                                        <div class="modal-body">
                                            <form id="add_emp" action="<?php echo base_url() ?>panel_admin/insert_emp" method="post">
                                        
                                        
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Correo</label>
                                            <div class="input-group">
                                                <div class="input-group-addon"><i class="ti-email"></i></div>
                                                <input type="email" class="form-control"  name="email" id="email" placeholder=" Escriba Email"> </div>
                                        </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                            <button type="submit" class="btn btn-success">Agregar</button>
                                        </div>
                                         </form>
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div>
                            <!-- /.modal -->
                <!--/.row -->

<!-- sample modal content -->

 <div class="modal fade" id="modal_bienvenido" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                             <h4 class="modal-title" id="titulo_invit">BIENVENIDO  AL SISTEMA DE EMPRENDEDORES </h4>
                                        </div>
                                        <div class="modal-body">
                                         
                                          <!-- START carousel-->
                                          <div id="carousel-example-captions-1" data-ride="carousel" class="carousel slide">
                                              <ol class="carousel-indicators">
                                                  <li data-target="#carousel-example-captions-1" data-slide-to="0" class="active"></li>
                                                  <li data-target="#carousel-example-captions-1" data-slide-to="1"></li>
                                                  <li data-target="#carousel-example-captions-1" data-slide-to="2"></li>
                                              </ol>
                                              <div role="listbox" class="carousel-inner">
                                                  <div class="item active"> <img src="<?php echo base_url();?>assets/plugins/images/big/img4.jpg" alt="First slide image"> </div>
                                                  <div class="item"> <img src="<?php echo base_url();?>assets/plugins/images/big/img5.jpg" alt="Second slide image"> </div>
                                                  <div class="item"> <img src="<?php echo base_url();?>assets/plugins/images/big/img6.jpg" alt="Third slide image"> </div>
                                              </div>
                                          </div>
                                          <!-- END carousel-->
                                                  
                                          
                                        </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div>
   </div>  


        
        <!-- /.modal -->              
  <script type="text/javascript">



    $(document).on("click",".detalle_carrito", function(){
       $.ajax({
            url:"<?php echo base_url(); ?>capacitacion/load_detalleCarrito",
            method:"get",
            success:function(data)
            {
             $('#cesta').html(data);
            }
        })
    });
    
  </script>     