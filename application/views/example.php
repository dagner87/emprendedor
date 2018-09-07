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
                                  <input id="nombre_usuario" class="form-control col-md-7 col-xs-12"  data-parsley-length="[8, 40]" data-parsley-group="block2" name="nombre_usuario" placeholder="" required="required" type="text">
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
                                  <input id="pass" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" data-validate-words="2" name="pass" placeholder="" required="required" type="text">
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
                                      <select class="select2_single form-control" tabindex="-1">
                                        <option></option>
                                        <option value="AK">FREE</option>
                                        <option value="HI">$200</option>
                                        <option value="HI">$500</option>
                                        <option value="HI">$2000</option>
                                      </select>
                                    </div>
                              </div>
                              <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="no_cliente">ID Tienda  
                                  <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                  <input id="no_cliente" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" data-validate-words="2" name="no_cliente" placeholder="" required="required" type="text">
                                </div>
                              </div>
                              <div class="invalid-form-error-message"></div>
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
     <script src="<?php echo base_url();?>assets/gentelella-master/vendors/parsleyjs/dist/parsley.min.js"></script>
  

    <script type="text/javascript">

    $(document).ready(function() {
    	// $('#editarUsuarios').parsley();
    	






  	   
    
     });

$(function () {
  $('#editarUsuarios').parsley().on('form:validate', function (formInstance) {
  	 formInstance.preventDefault();
    var ok = formInstance.isValid({group: 'block2', force: true});
    console.log(ok);
    $('.invalid-form-error-message').html(ok ? '' : '¡Debe llenar correctamente * al menos uno de estos dos bloques!')
      .toggleClass('filled', !ok);
    if (!ok){
    	formInstance.validationResult = false;
    	console.log("estoy aqui --"+ok);
    }else{

    	console.log("estoy aqui>>>>"+ok);

    	
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

   function enviardatos(event){
       event.preventDefault();
          var url = '<?php echo base_url() ?>welcome/install_panel';
          var data = $('#editarUsuarios').serialize();
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
                    sweetalert_proceso();
                  }
                });
        }   

	</script>
</body>
</html>
