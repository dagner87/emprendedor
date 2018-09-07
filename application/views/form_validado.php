<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <!-- Bootstrap -->
    <link href="<?php echo base_url();?>assets/gentelella-master/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
   

</head>
<body>
	
   <!-- Editar Usuario --> 
                 <div class="" tabindex="-1" role="dialog" aria-hidden="true" id="editModal">
                    <div class="modal-dialog modal-lg">
                      <div class="modal-content">

                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                          </button>
                          <h4 class="modal-title" id="">Editar Usuario</h4>

                        </div>
                        <div class="modal-body" id="edit_data">
                        	 
                          <form class="form-horizontal form-label-left" id="editarUsuarios" novalidate>
                              <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="nombre_usuario">Nombre y Apellidos  <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                  <input id="nombre_usuario" class="form-control col-md-7 col-xs-12"  data-parsley-length="[3,4]" data-parsley-group="block2" name="nombre_usuario" placeholder="" required="required" type="text">
                                </div>
                              </div>
                              <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="usuario">Usuario  
                                  <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                  <input id="usuario" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" data-validate-words="2" name="usuario" placeholder="" required="required" type="text">
                                </div>
                              </div>
                              <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="mail">Email <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                  <input type="email" id="mail" name="mail" required="required" class="form-control col-md-7 col-xs-12">
                                </div>
                              </div>
                              <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="pass">Contraseña  
                                  <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                  <input id="pass" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" name="pass" placeholder="" required="required" type="text">
                                </div>
                              </div>
                              <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="id_tienda">ID Tienda  
                                  <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                  <input id="id_tienda" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" data-validate-words="2" name="id_tienda" placeholder="" required="required" type="text">
                                </div>
                              </div>
                              <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">
                                    	Plan
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                      <select class="select2_single form-control" tabindex="-1" name="plan" required="required">
                                        <option></option>
                                        <option value="AK">FREE</option>
                                        <option value="HI">$200</option>
                                        <option value="HI">$500</option>
                                        <option value="HI">$2000</option>
                                      </select>
                                    </div>
                              </div>
                              
                              </div>
                              <div class="modal-footer">
                                  <button type="button"  id="btnlimpiar" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                  <button id="send" type="submit" class="btn btn-primary validate">Aceptar</button>
                              </div>
                          </form>
                        </div>
                    </div>
                  </div>
                  <!-- /modals --> 
		
    </div>
     <!-- jQuery -->
    <script src="<?php echo base_url();?>assets/gentelella-master/vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
       <!-- validator -->
    <script src="<?php echo base_url();?>assets/gentelella-master/vendors/validator/validator.js"></script>
  

    <script type="text/javascript">

    $(document).ready(function() {
    	$('form')
        .on('blur', 'input[required], input.optional, select.required', validator.checkField)
        .on('change', 'select.required', validator.checkField)
        .on('keypress', 'input[required][pattern]', validator.keypress);

      $('.multi.required').on('keyup blur', 'input', function() {
        validator.checkField.apply($(this).siblings().last()[0]);
      }); 

      $('form').submit(function(e) {
        e.preventDefault();
        var submit = true;

        // evaluate the form using generic validaing
        if (!validator.checkAll($(this))) {
          
          submit = false;
           console.log("submit --->"+submit);

        }

        if (submit){
          console.log("submit ->"+submit);
          //this.submit();
         // enviardatos();
        }
          
        return false;
      });	   
    
     });//fin onready





 function sweetalert_proceso() {
    var url = '<?php echo base_url() ?>assets/ajax-loader-6.gif';
    swal({
      title: "Procesando",
      icon: url,
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

   function enviardatos(){
          var url = '<?php echo base_url() ?>welcome/install_panel';
          var data = $('#editarUsuarios').serialize();
          $.ajax({
                    type: 'ajax',
                    method: 'post',
                    url: url,
                    data: data,
                    dataType: 'json',
                    beforeSend: function() {
                        sweetalert_proceso();
                      }
                 })
                  .done(function(){
                  	console.log(data);
                    sweetalertclick();
                     
                  })
                  .fail(function(){
                     sweetalertclickerror();
                  }) 
                  .always(function(){
                    /* setTimeout(function(){
                      redireccionar();
                     },2000);*/

                  });
        }   

	</script>
</body>
</html>
