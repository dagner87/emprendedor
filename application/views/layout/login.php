<!DOCTYPE html>  
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">
<link rel="icon" type="image/png" sizes="16x16" href="<?php echo base_url();?>assets/plugins/images/favicon.ico">
<title>login</title>
<!-- Bootstrap Core CSS -->
<link href="<?php echo base_url();?>assets/ampleadmin-minimal/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- animation CSS -->
<link href="<?php echo base_url();?>assets/ampleadmin-minimal/css/animate.css" rel="stylesheet">
<link href="<?php echo base_url();?>assets/plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.css" rel="stylesheet">
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
         <a href="<?php echo base_url();?>" class="p-20 di"><img src="<?php echo base_url();?>assets/plugins/images/admin-text-logo.png" alt="home" class="light-logo" /></a>
                <div class="white-box">
                    <h3 class="box-title m-b-0">Entrada al sistema</h3>
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
                  <form  data-toggle="validator" class="form-horizontal new-lg-form" id="loginform" method="post" action="<?php echo base_url();?>logusuario">
                     <?=form_hidden('token',$token)?>
                    <div class="form-group  m-t-20">
                      <div class="col-xs-12">
                        <label>CORREO</label>
                        <input class="form-control" type="email" required name="email" placeholder="Correo" data-error="Escriba un correo valido">
                        <div class="help-block with-errors"></div>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="col-xs-12">
                        <label>CONTRASEÑA</label>
                        <input  type="password"  data-minlength="6" class="form-control"   name="password"  placeholder="Contraseña" required data-error="Por favor, no escribas menos de 6 caracteres">
                        <div class="help-block with-errors"></div>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="col-md-12">
                        <div class="checkbox checkbox-info pull-left p-t-0">
                          <input id="checkbox-signup" type="checkbox">
                          <label for="checkbox-signup"> Recuérdame</label>
                        </div>
                        <a href="javascript:void(0)" id="to-recover" class="text-dark pull-right"><i class="fa fa-lock m-r-5"></i> Olvidé mi contraseña?</a> </div>
                    </div>
                    <div class="form-group text-center m-t-20">
                      <div class="col-xs-12">
                        <button class="btn btn-info btn-lg btn-block btn-rounded text-uppercase waves-effect waves-light" type="submit">Entrar</button>
                      </div>
                    </div>
                    <div class="form-group m-b-0">
                      <div class="col-sm-12 text-center">
                        <p> No tengo cuenta <a href="registro" class="text-primary m-l-5"><b>Registrate
</b></a></p>
                      </div>
                    </div>
                  </form>

                  <form data-toggle="validator" class="form-horizontal" id="recoverform" 
                  action="<?php echo base_url() ?>panel_admin/forgot_pass" method="post">
                    <div class="form-group ">
                      <div class="col-xs-12">
                        <h3>Recuperar contraseña</h3>
                        <p class="text-muted">¡Ingrese su correo electrónico y le enviaremos las instrucciones!</p>
                      </div>
                    </div>
                    <div class="form-group ">
                      <div class="col-xs-12">
                        <input class="form-control" type="email" id="email_rest" name="email_rest" required placeholder="Correo" 
                        data-error="Escriba un correo valido">
                      <div class="help-block with-errors"></div>
                      </div>
                    </div>
                    <div class="form-group text-center m-t-20">
                      <div class="col-xs-12">
                        <button   type="submit" id="forgot_pass" class="btn btn-primary btn-lg btn-block text-uppercase waves-effect waves-light">Reiniciar</button>
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
