<!DOCTYPE html>
<html lang="es">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Panel Administración</title>

    <!-- Bootstrap -->
    <link href="<?php echo base_url();?>/assets/gentelella-master/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="<?php echo base_url();?>/assets/gentelella-master/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="<?php echo base_url();?>/assets/gentelella-master/vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- Animate.css -->
    <link href="<?php echo base_url();?>/assets/gentelella-master/vendors/animate.css/animate.min.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="<?php echo base_url();?>/assets/gentelella-master/build/css/custom.min.css" rel="stylesheet">
      <!-- The fav icon -->
    <link rel="shortcut icon" href="<?php echo base_url();?>assets/gentelella-master/production/images/favicon-16x16.png">
  </head>

  <body class="login">
    <div>
      <a class="hiddenanchor" id="signup"></a>
      <a class="hiddenanchor" id="signin"></a>

      <div class="login_wrapper">
        <div class="animate form login_form">
          <section class="login_content">
              <?php
              $username = array('name' => 'username', 'placeholder' => 'Nombre de usuario','class' =>'form-control','type' => 'text');
              $password = array('name' => 'password', 'placeholder' => 'introduce tu password','class' =>'form-control');
              $submit = array('name' => 'submit', 'value' => 'Iniciar sesión', 'title' => 'Iniciar sesión','class' => 'btn btn-primary');
                       
            $attributes = array('class' => 'form-horizontal');
            ?>

             <?=form_open(base_url().'login/new_user', $attributes)?>
             
              <h1>Entrada al Sistema</h1>
              <div>
                  <?=form_input($username)?><p><?=form_error('username')?></p>
              </div>
              <div>
               <?=form_password($password)?><p><?=form_error('password')?></p>
              </div>
              <div>
                <?=form_hidden('token',$token)?>
                <?=form_submit($submit)?> 
               
                
              </div>

              <div class="clearfix"></div>

              <div class="separator">
                <div class="clearfix"></div>
                <br />

                <div>
                   <img src="<?php echo base_url();?>/assets/gentelella-master/production/images/softcom-sas.png" alt="..." class="img-rounded profile_img">
                  <p>©2018 Creado por <a href="https://www.softcom.com.ar/" target="_blank" class="to_register">SOFTCOM </a></p>
                </div>
              </div>
               <?=form_close()?>

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

          </section>
        </div>

        
      </div>
    </div>
  </body>
</html>
