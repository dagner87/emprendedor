<!DOCTYPE html>  
<html lang="es">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">
<link rel="icon" type="image/png" sizes="16x16" href="<?php echo base_url();?>assets/plugins/images/favicon.ico">
<title>Registro</title>
<!-- Bootstrap Core CSS -->
<link href="<?php echo base_url();?>assets/ampleadmin-minimal/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Menu CSS -->
<link href="../plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.css" rel="stylesheet">
<!-- animation CSS -->
<link href="<?php echo base_url();?>assets/ampleadmin-minimal/css/animate.css" rel="stylesheet">
<!-- Custom CSS -->
<link href="<?php echo base_url();?>assets/ampleadmin-minimal/css/style.css" rel="stylesheet">
<!-- color CSS -->
<link href="<?php echo base_url();?>assets/ampleadmin-minimal/css/colors/default.css" id="theme"  rel="stylesheet">
<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->

</head>
<body>
<!-- Preloader -->
<div class="preloader">
  <div class="cssload-speeding-wheel"></div>
</div>
<section id="wrapper" class="new-login-register">
      <div class="lg-info-panel">
              <div class="inner-panel">
                  <div class="lg-content">
                      <h2>BIENVENIDO AL SISTEMA DE  EMPRENDEDORES DVIGI</h2>
                      <p class="text-muted"> </p>
                  </div>
              </div>
      </div>
      <div class="new-login-box">
         <a href="<?php echo base_url();?>" class="p-20 di"><img src="<?php echo base_url();?>assets/plugins/images/admin-text-dark.png" alt="home" class="light-logo" /></a>
                <div class="white-box">
                    <h3 class="box-title m-b-0">Completa el registro</h3>
                            <?php 
                if($this->session->flashdata('usuario_incorrecto'))
                {
                ?>
                <div class="alert alert-danger">
                 <p><?=$this->session->flashdata('usuario_incorrecto')?></p>
                </div>
                <?php
                }
                ?>
                  <form  data-toggle="validator" class="form-horizontal new-lg-form" id="loginform" method="post" action="<?php echo base_url();?>login/update_registro">
                     <?=form_hidden('token',$token)?>
                     <?=form_hidden('id_emp',$id_emp)?>
                     
                    <div class="form-group  m-t-20">
                      <div class="col-xs-12">
                        <label>Nombre y Apellidos</label>
                        <input class="form-control" type="text" required="true" name="nombre_emp" placeholder="Escriba Nombre y Apellidos">
                        <div class="help-block with-errors"></div>
                      </div>
                    </div>
                    <div class="form-group  m-t-20">
                      <div class="col-xs-12">
                        <label>DNI</label>
                        <input class="form-control" type="text" required="true" name="dni_emp" placeholder="Escriba DNI">
                        <div class="help-block with-errors"></div>
                      </div>
                    </div>
                    <div class="form-group  m-t-20">
                      <div class="col-xs-12">
                        <label>Telefono</label>
                        <input class="form-control" type="tel" required="true" name="telefono_emp" placeholder="Escriba Teléfono">
                        <div class="help-block with-errors"></div>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="col-xs-12">
                        <label>CONTRASEÑA</label>
                        <input class="form-control" type="password" id="password" required="true" name="password"  placeholder="Contraseña">
                      <div class="help-block with-errors"></div>
                      </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <input class="form-control" type="password" name="confir_password"  required placeholder="Confirmar Contraseña" data-match="#password" data-match-error="La contraseña no coincide">
                            <div class="help-block with-errors"></div>
                             </div>
                    </div>
                    <div class="form-group text-center m-t-20">
                      <div class="col-xs-12">
                        <button class="btn btn-info btn-lg btn-block btn-rounded text-uppercase waves-effect waves-light" type="submit">Registrar</button>
                      </div>
                    </div>
                    
                  </form>
                  
                </div>
      </div>            
  
  
</section>
<!-- jQuery -->
<script src="<?php echo base_url();?>assets/plugins/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap Core JavaScript -->
<script src="<?php echo base_url();?>assets/ampleadmin-minimal/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- Menu Plugin JavaScript -->
<script src="<?php echo base_url();?>assets/plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.js"></script>

<!--slimscroll JavaScript -->
<script src="<?php echo base_url();?>assets/ampleadmin-minimal/js/jquery.slimscroll.js"></script>
<!--Wave Effects -->
<script src="<?php echo base_url();?>assets/ampleadmin-minimal/js/waves.js"></script>
<!-- Custom Theme JavaScript -->
<script src="<?php echo base_url();?>assets/ampleadmin-minimal/js/custom.min.js"></script>

<script src="<?php echo base_url();?>assets/ampleadmin-minimal/js/validator.js"></script>
<!--Style Switcher -->
<script src="<?php echo base_url();?>assets/plugins/bower_components/styleswitcher/jQuery.style.switcher.js"></script>
</body>
</html>
