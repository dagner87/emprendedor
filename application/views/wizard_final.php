<!doctype html>
<html lang="es">
<head>
    <title>Instalación Plugins Tienda Nube</title>

   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
   <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.15.0/jquery.validate.min.js"></script>
   <script src="<?php echo base_url();?>assets/wizard/js/jquery.formtowizard.js"></script>
   <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
   <style>
      body {background:#2A3F54; font-family:Lucida Sans, Arial, Helvetica, Sans-Serif; font-size:13px; margin:30px;}
        #main { width:900px; margin: 0px auto; border:solid 1px #b2b3b5; -moz-border-radius:10px; padding:20px; background-color:#f6f6f6;}
        #header { text-align:center; border-bottom:solid 1px #b2b3b5; margin: 0 0 20px 0; }
        .wrap { max-width: 980px; margin: 10px auto 0; }
        #steps { margin: 80px 0 0 0 }
        .commands { overflow: hidden; margin-top: 30px; }
        .prev {float:left}
        .next, .submit {float:right}
        .error { color: #b33; }
        #progress { position: relative; height: 15px; background-color: #eee; margin-bottom: 20px; }
        #progress-complete { border: 0; position: absolute; height: 15px; min-width: 10px; background-color: #337ab7; transition: width .2s ease-in-out; }
        h3{color: #337ab7;}
        .help{
        width: 20px;
        margin-left: 5px;
        margin-bottom: 5px;
        }

        .red-tooltip + .tooltip > .tooltip-inner {background-color: #337AB7;}
        .red-tooltip + .tooltip > .tooltip-arrow { border-bottom-color:#337AB7; }

    </style>
    
</head>

<body>
    <div id="main">
        <div id="header">
            <!-- <img src="logo.jpg" alt="JankoAtWrpSpeed demos" /> -->
            <h3>Por Favor complete el proceso de Instalación</h3>
            <p><a id="" href="https://www.softcom.com.ar/" target="_blank" >Contáctenos si tiene alguna duda</a>
        </div>
<div class="row wrap"><div class="col-lg-12">

    <div id='progress' class="progress progress-striped  active">
        <div id='progress-complete' class="progress-bar" role="progressbar" aria-valuenow="40"
  aria-valuemin="0" aria-valuemax="100" ><span id= "valor"></span></div>
    </div>

    <form id="wizard_form" action="" method="post">
         
         <!--input type="hidden" name="code" value="<?php echo $code ; ?> ">
         <input type="hidden" name="store_id" value="<?php echo $store_id ; ?> ">
         <input type="hidden" name="access_token" value="<?php echo $access_token ; ?> "-->
           <fieldset>
            <legend>Cuenta Google Merchant Center</legend>
            <div id="show_mensaje_merchant"class="alert alert-warning" role="alert" style="display: none;">
            </div> 
            <div class="form-group">
                <label class="radio-inline " style="">
                <input class="" type="radio" name="merchant" value="si_merchant">TENGO CUENTA </label>
                <label class="radio-inline" style="">
                <input class="" type="radio" name="merchant" value="no_merchant" required>CREAR CUENTA MERCHANT </label>
            </div>

             <div class="row" style="display: none;" id="show_merchant">
                <div class="col-xs-6">
                <label for="id_merchant" class="">Id Cuenta Cliente</label>
                <input id="id_merchant" type="text" class="form-control" name="id_merchant" onKeyDown="contar()" onKeyUp="contar()"/>
                </div>
                <label for="" class="">&nbsp;</label>
                <div class="col-xs-6" style="display: none;" id="show_solicitud">
                    <a id="sol_acMerchant" class="btn btn-success" disabled="true"> Permitir Acceso</a>
                   
                    <!--a  href="#" data-toggle="modal" data-target=".bs-example-modal-sm">
                   <img class="help" src="<?php echo base_url();?>assets/img/questionmark.svg">
                    </a-->


                    <a href="#" data-toggle="tooltip" class="red-tooltip" data-placement="top"  title="Necesitamos acceder a su cuentas de Merchant Center.Debe aceptar la solicitud para poder continuar con el proceso de insalación.Consulte este enlacen si no conoce como hacerlo"> <img class="help" src="<?php echo base_url();?>assets/img/questionmark.svg"></a>
                  
                  <div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-sm alert alert-info">
                      <div class="modal-content ">
                        <div class="modal-header ">
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                          </button>
                          <h4 class="modal-title" id="myModalLabel2">Ayuda</h4>
                        </div>
                        <div class="modal-body">
                          <p align="justify"><i class="glyphicon glyphicon-star"></i> <strong> Nota:</strong> Necesitamos acceder a su cuentas de Merchant Center.Debe aceptar la solicitud para poder continuar con el proceso de insalación.Consulte este enlacen si no conoce como hacerlo <a href="#" target="_blank"><u>Autorizar Cuentas</u></a>.</p>
                        </div>
                      </div>
                    </div>
                  </div>

                </div>
             </div>
             
               
          
        </fieldset>

        <!--fieldset>
            <legend>Datos de registro</legend>
             <div class="col-xs-3">
                     <a target="_blank" id="sol_ac1" class="btn btn-success ">Solicitar acceso</a>
                      <button id="sol_ac" class="btn btn-success"> Permitir Acceso</button>
                    </div>
                     <div class="form-group">
                        <label>Nombre y Apellidos</label>
                        <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Nombre y Apellidos" required  minlength="2"/>
                    </div>
                   <div class="form-group">
                        <label>Usuario</label>
                        <input type="text"  name="usuario" id="usuario" class="form-control" placeholder="Nombre de usuario" minlength="4" required />                  
                    </div>
                    <div class="form-group">
                        <label>DNI</label>
                        <input type="text" name="dni" id="dni" class="form-control" placeholder="dni" required  minlength="8"/>                  
                    </div>
                    <div class="form-group">
                        <label>Mail</label>
                        <input type="email" name="mail"  id="mail" class="form-control" placeholder="mail" required/>
                    </div>
                     <div class="form-group">
                        <label for="telefono">Teléfono</label>
                        <input type="number" name="telefono"  id="telefono" class="form-control" placeholder="Teléfono" required minlength="8"/>
                    </div>
                    <div class="form-group">
                        <label>Contraseña</label>
                        <input type="password" name="pass" id="pass" class="form-control" placeholder="Contraseña" required minlength="1"/>
                    </div>
                    <div class="form-group">
                        <label>Repetir Contraseña</label>
                        <input type="password" name="pass_confirm" id="pass_confirm" class="form-control" placeholder="Repetir Contraseña" required/>
                    </div>
        </fieldset-->

        <!--fieldset>
            <legend>Categorías de Productos</legend>
            
            <div class="form-group">
                    <label >Categorías</label>
                        <label class="radio-inline " style="">
                        <input class="" type="radio" name="categoria" value="global" required> Gobal </label>
                        <label class="radio-inline" style="">
                        <input class="" type="radio" name="categoria" value="por_producto" required > Por producto </label>
                     <div class="row" style="display: none;" id="show_categorias">
                     <?php
                        foreach ($categorias as $fila) {    ?>
                        <div class="col-md-4">
                         <label class="radio-inline" style="">
                          <input   type="radio" name="id_categoria" value="<?php echo $fila->id_categoria; ?>" required>
                          <img src="<?php echo base_url();?>assets/img/<?php echo $fila->imagen_categoria; ?>.png"> <?php echo $fila->nombre_categoria; ?>
                        </label>
                         </div>  
                        <?php
                        }
                        ?>
                     </div>
                     <br>
                    <div id="show_mensaje"class="alert alert-info" role="alert" style="display: none;">Usted deberá agregar las categorías posteriormente en el panel</div>  
            </div>
        </fieldset-->

        <!--fieldset>
            <legend>Cuenta Adwords</legend>
            <div class="form-group">
                <label > </label>
                <label class="radio-inline " style="">
                <input class="" type="radio" name="adword" value="si_adword"  disabled>TENGO CUENTA </label>
                <label class="radio-inline" style="">
                <input class="" type="radio" name="adword" value="no_adword" required> CREAR CUENTA ADWORDS </label>
            </div>
           

            <div class="form-group" style="display: none;" id="show_adword">
             <label for="id_adword" class="col-sm-2 control-label">Id Adword</label>
                <div class="col-sm-10">
                 <div class="row">
                   <div class="col-xs-3">
                     <input id="id_adword" type="text" class="form-control" name="id_adword" />
                    </div>
                    <div class="col-xs-3">
                     <a target="_blank" id="sol_ac" class="btn btn-success ">Solicitar acceso</a>
                    </div>
                  </div>
                </div>
                <div id="div_tocken_adword" class="form-group" style="display: none;">
                    <label>Tocken de Acceso</label>
                    <input type="text" name="tocken_adword" id="tocken_adword" value="" 
                     class="form-control" placeholder="" required />
                    </div>
              

            </div>
       </fieldset-->

        <fieldset class="form-horizontal" role="form">
            <legend>Verifique sus datos, haga clic en el botón guardar para crear su cuenta</legend>
            <div class="form-group">
                        <strong>Nombre Tienda Nube: </strong><span id="mos_tienda"></span> 
                    </div>
                    <div class="form-group"> 
                        <strong>Nombre: </strong><span id="mos_nombre"> </span>
                    </div>
                    <div class="form-group">
                        <strong>Usuario: </strong><span id="mos_usuario"> </span>
                    </div> 
                    <div class="form-group">
                        <strong>DNI: </strong><span id="mos_dni"> </span>
                    </div> 
                    <div class="form-group">
                        <strong>Mail: </strong><span id="mos_mail"> </span>
                    </div>
        </fieldset>
        <img src="">
        <a href=""></a>

        <button id="SaveAccount" type="submit" class="btn btn-primary submit">Guardar</button>

    </form>
    </div>
</div>

<script>

    $(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip(); 
});
        $( function() {

             $( "#wizard_form" ).validate( {
                rules: {
                    nombre: {
                        required: true,
                        minlength: 2
                    },
                    usuario: {
                        required: true,
                        minlength: 5
                    },
                    dni:{
                        required: true,
                        minlength:8,
                        number: true

                    },
                    email: {
                        required: true,
                        email: true
                    },
                    telefono:{
                         required: true,
                         minlength: 8

                    },
                    pass: {
                        required: true,
                        minlength: 1
                    },
                    pass_confirm: {
                        required: true,
                        minlength: 1,
                        equalTo: "#pass"
                    },
                    adword:{
                        required: true,
                       },
                    id_merchant:{
                        required: true,
                        minlength:9,
                        maxlength:9
                       }   
                    
                    
                },
                messages: {
                    nombre: {
                        required: "*Este campo es obligatorio.",
                        minlength: "*Por favor, no escribas menos de {0} caracteres."
                    },
                    usuario: {
                        required: "*Este campo es obligatorio.",
                        minlength: "*Por favor, no escribas menos de {0} caracteres."
                    },
                    dni:{
                        digits: "*Por favor, escribe sólo dígitos.</strong>",
                        required: "*Este campo es obligatorio.</strong>",
                        minlength:"*Por favor, no escribas menos de {0} caracteres."

                    },
                    telefono:{
                        digits: "*Por favor, escribe sólo dígitos.</strong>",
                        required: "*Este campo es obligatorio.</strong>",
                        minlength:"*Por favor, no escribas menos de {0} caracteres."

                    },
                    pass: {
                        required: "*Este campo es obligatorio.</strong>",
                        minlength:"*Por favor, no escribas menos de {0} caracteres."
                    },
                    pass_confirm: {
                        required: "*Este campo es obligatorio.</strong>",
                        minlength: "*Por favor, no escribas menos de {0} caracteres.",
                        equalTo: "*No coincide con la contraseña</strong>"
                    },
                    email: {
                        required: "*Este campo es obligatorio.",

                    },
                    adword: {
                        required: "*Este campo es obligatorio.",

                    },
                    id_merchant: {
                        required: "*Este campo es obligatorio.</strong>",
                        minlength: "*Por favor, no escribas menos de {0} caracteres.",
                        maxlength: "*Por favor, no escribas mas de {0} caracteres.",
                        
                    }
                }
        });
        var $signupForm = $('#wizard_form');
            $signupForm.validate({
                errorElement: 'em',
                submitHandler: function (form) { 
                    alert('submitted');
                    form.submit();
                }
            });
            
            $signupForm.formToWizard({
                submitButton: 'SaveAccount',
                nextBtnClass: 'btn btn-primary next',
                prevBtnClass: 'btn btn-default prev',
                buttonTag:    'button',
                validateBeforeNext: function(form, step) {
                    var stepIsValid = true;
                    var validator = form.validate();
                    $(':input', step).each( function(index) {
                        var xy = validator.element(this);
                        stepIsValid = stepIsValid && (typeof xy == 'undefined' || xy);
                    });
                    return stepIsValid;
                },
                progress: function (i, count) {
                    $('#progress-complete').width(''+(i/count*100)+'%');
                    //$('#valor').html((i)+'%');
                }
            });

        });
</script>
<script>
    $(document).ready(function(){
     var base_url  = "http://panel.googleshopping.com.ar/sistema/";
      
     $('#step0Next').on('click', function() {
            var parent_fieldset = $(this).parents('fieldset');
      	    var nombre          = $('input[name=nombre]').val();
		    var usuario         = $('input[name=usuario]').val();
		    var dni             = $('input[name=dni]').val();
		    var mail            = $('input[name=mail]').val();
		    var telefono        = $('input[name=telefono]').val();
		    var form_completado = "";

            parent_fieldset.find('input[type="text"], input[type="password"], input[type="username"], input[type="email"]').each(function() {
                if( $(this).val() == "" ) {
                   console.log("no insertado");
                }
                else {
                     return form_completado = "ok";
                     }
            });

            if (form_completado == "ok"){
            	$.ajax({
    			          url: base_url + "wizard/InsertdatosUsuario",
    			          type:"GET",
    			          data: {nombre:nombre,usuario:usuario,dni:dni,mail:mail,telefono:telefono},
    			          dataType: 'json',
    			          success:function(resp){
    			                console.log(resp);
    			            }
  			           });
            }
        });	

     $('input[name=categoria]').change(function () {
        var cate = $('input[name=categoria]:checked').val();
        if (cate =='global') {

             $('#show_mensaje').hide();
             $('#show_categorias').show();
             
        }else{
             $('#show_categorias').hide();
             $('#show_mensaje').show();
        }
      
     });
    $('input[name=adword]').change(function () {
       var adword = $('input[name=adword]:checked').val();
        if (adword =='si_adword') {
             $('#show_adword').show();
             $('#id_adword').attr('required',true);
             var id_adword = $('#id_adword').val();
          
        }else{
             $('#show_adword').hide();
            }
        });

     $('input[name=merchant]').change(function () {
       var merchant = $('input[name=merchant]:checked').val();
        if (merchant =='si_merchant') {
             var id_adword  = $('input[name=id_adword]').val();
            
              $('#show_merchant').show();
            var mensaje = "<span class='glyphicon glyphicon glyphicon-alert' aria-hidden='true'></span> Es importante que su cuenta de <strong>Google Merchant Center</strong> esté vinculada a la cuenta de <strong>Google Ads # </strong><strong id='mostrar_id_adword'></strong>";
              $('#mostrar_id_adword').html(id_adword);
             $('#show_mensaje_merchant').removeClass()
                        .addClass( "alert alert-warning" );
              $('#show_mensaje_merchant').html(mensaje).show();
              $('#id_merchant').attr('required',true);
              $('#show_solicitud').show();
            


        }else{
              
             $('#show_mensaje_merchant').hide();
             $('#show_merchant').hide();
             $('#show_solicitud').hide();

             }
    });

     /* $('input[name=id_merchant]').change(function () {
        $("#sol_acMerchant").removeAttr("disabled");
       });*/

     /* $('#id_merchant').keyup(function() {
        var mensaje = "<span class='glyphicon glyphicon glyphicon-alert' aria-hidden='true'></span> Debe completar correctamente los datos";
        var chars = $(this).val().length;
        if (chars == 12) {
         $("#sol_acMerchant").removeAttr("disabled");
         $("#mostrar_id_adword").html(chars);
         $('#show_mensaje_merchant').removeClass().hide();   
        }else{
        
         $("#show_mensaje_merchant").removeClass()
                       .addClass("alert alert-danger").html(mensaje);     

        }
       
        
    });
    $('#id_merchant').keydown(function() {
         var mensaje = "<span class='glyphicon glyphicon glyphicon-alert' aria-hidden='true'></span> Debe completar correctamente los datos";
        var chars = $(this).val().length;
         if (!chars == 12) 
         {
            $("#show_mensaje_merchant").removeClass()
                .addClass("alert alert-danger").html(mensaje).show(); 
            $("#show_mensaje_merchant").append(chars);
       
         }
    });
      */


     

  $("#step0Siguiente").click(function(e) {
     // var  obj  = $( "#wizard_form" ).validate({}); 
       
         //$("#wizard_form").valid();

      var $Form1 =  $signupForm.formToWizard({
                        submitButton: 'SaveAccount',
                        nextBtnClass: 'btn btn-primary next',
                        prevBtnClass: 'btn btn-default prev',
                        buttonTag:    'button',
                        validateBeforeNext: function(form, step) {
                            var stepIsValid = true;
                            var validator = form.validate();
                            $(':input', step).each( function(index) {
                                var xy = validator.element(this);
                                stepIsValid = stepIsValid && (typeof xy == 'undefined' || xy);
                            });
                            return stepIsValid;
                        }
                    });
               
      
             
       // var step = $("#wizard_form").validateBeforeNext();
        
     console.log(Form1);

      //console.log(obj.submitted['id_merchant']); 
      //console.log(obj);
      
    /* if(!$("#wizard_form").valid()){
       var signup =  $("#wizard_form").valid();
        
       console.log(signup);
       
     }else{
         var signup =  $("#wizard_form").valid();
        var stepIsValid = false;
      

     }*/

      

     });





     $("#sol_acMerchant").click(function() {

       $('#step0Siguiente').addClass("valid").attr('aria-invalid',false);
      
      var id_adword = $('#id_adword').val();
      var id_merchant ="12233";
      var  url = 'http://panel.googleshopping.com.ar/sistema/shoppings/librerias/acceso_web.php?id_merchant='+id_merchant;
     // window.open(url, "Acceso a cuenta Merchant", "width=490, height=500");
      $('#div_tocken_adword').show();
      $('#tocken_adword').attr('required',true);
     // cerrar();
     
   });

  function cerrar() {
    var ventana = window.self
    ventana.opener = window.self
    ventana.close()
 }   

    $(".next").focus(function() {
            var name_tienda = $('input[name=name_tienda]').val();
            var id_merchant = $('input[name=id_merchant]').val();
            var nombre      = $('input[name=nombre]').val();
            var usuario     = $('input[name=usuario]').val();
            var dni         = $('input[name=dni]').val();
            var mail        = $('input[name=mail]').val();
           
            $('#mos_tienda').html(name_tienda);
            $('#mos_merchant').html(id_merchant);
            $('#mos_nombre').html(nombre);
            $('#mos_usuario').html(usuario);
            $('#mos_dni').html(dni);
            $('#mos_mail').html(mail);
        });


    $("#SaveAccount").click(function (event){

         event.preventDefault();
          var url = '<?php echo base_url() ?>wizard/install_panel';
          var data = $('#wizard_form').serialize();
           $.ajax({
                 type: 'ajax',
                    method: 'post',
                    url: url,
                    data: data,
                    async: false,
                    dataType: 'json',
                  beforeSend: function(data) {
                    sweetalert_proceso();
                  },
                  complete: function(){
                    //sweetalertclick();
                    sweetalert_proceso();
                  }
                });
        });


   
  
        //insertar los datos 
     $('#SaveAccount').click(function(e){
           e.preventDefault();
            var url = '<?php echo base_url() ?>wizard/install_panel';
            var data = $('#wizard_form').serialize();
            sweetalert_proceso();
            var usuario     = $('input[name=usuario]').val();
            var pass     = $('input[name=pass]').val();
            
            $.ajax({
                    type: 'ajax',
                    method: 'post',
                    url: url,
                    data: data,
                    async: false,
                    dataType: 'json',
                    success: function(response){
                        console.log(response);
                        if(response.comprobador){
                         $('#progress-complete').width(''+(100)+'%');
                           sweetalertclick();
                           setTimeout(20000);
                           redireccionar();
                          
                           }else{
                            sweetalertclickerror(); 
                        }
                    },
                    error: function(){
                        sweetalertclick();
                    }
             });

     }); 

    function sweetalert_proceso() {
    swal({
      title: "Procesando",
      icon: "../assets/ajax-loader-6.gif",

       buttons: false,
    });
   } 

    function sweetalertclick() { 
        swal({
          title: "Datos Guardados",
          text: "Exito",
          icon: "success",
           buttons: false,
        });
    }
    function sweetalertclickerror(){
      swal({  title: "Error al Guardar",
           text: "Error",
           icon: "error",
           buttons: false,
     });
  } 

 
   function redireccionar(){
      var usuario  = $('input[name=usuario]').val();
      var pass     = $('input[name=pass]').val();

     /* $.get( "http://panel.googleshopping.com.ar/sistema/wizard/ingreso_panel",
          { usuario: usuario, pass: pass } );*/

       window.location.href = "http://panel.googleshopping.com.ar/sistema/wizard/ingreso_panel?username="+usuario+"&password="+pass;
      
    }





  
    });//fin onready 

//Creamos la Funcion
    function contar() {
      var id_adword  = $('input[name=id_adword]').val();  
      var mensaje = "<span class='glyphicon glyphicon glyphicon-alert'></span> Debe completar correctamente los datos";
        var chars = $("#id_merchant").val().length;
        if (chars == 9) {
         $("#sol_acMerchant").attr("disabled",false);
         $('#mostrar_id_adword').html(id_adword);
          $('#mostrar_id_adword').html(id_adword);
         var mensaje = "<i class='glyphicon glyphicon-info-sign'></i> Es importante que su cuenta de <strong>Google Merchant Center</strong> esté vinculada a la cuenta de <strong>Google Ads # </strong><strong id='mostrar_id_adword'></strong>";
             
             $('#show_mensaje_merchant').removeClass()
                        .addClass("alert alert-warning").html(mensaje).show();
            


        }else{
         $("#sol_acMerchant").attr("disabled",true);   
         $("#show_mensaje_merchant").removeClass()
        .addClass("alert alert-danger").html(mensaje+ chars).show();  
         } 
    } //Aqui termina la Funcion
</script>

</body>
</html>
