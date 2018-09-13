 <div class="row bg-title">
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                        <h4 class="page-title">Perfil</h4> </div>
                    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                        
                        <ol class="breadcrumb">
                            <li><a href="#">Incio</a></li>
                            <li><a href="#">Perfil</a></li>
                            <li class="active">Datos Personales</li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->
                <!-- .row -->
                <div class="row">
                    <div class="col-md-4 col-xs-12">

                        <div class="white-box">
                            <div class="user-bg"> <img width="100%" alt="user" src="<?php echo base_url();?>assets/plugins/images/large/img1.jpg">
                                <div class="overlay-box">
                                    <div class="user-content">
                                        <img src="<?php echo base_url();?>assets/plugins/images/users/<?= $datos_emp->foto_emp; ?>" class="thumb-lg img-circle" alt="img">
                                        <h4 class="text-white"><?= $datos_emp->nombre_emp; ?></h4>
                                        <h5 class="text-white"><?= $datos_emp->email; ?></h5> 
                                        <!--div class="col-md-12 m-b-20">
                                        <div class="fileupload btn btn-danger btn-rounded waves-effect waves-light"><span><i class="ion-upload m-r-5"></i>Subir Imagen <i id="cargando" class=""></i></span>
                                            <input type="file" class="upload"> </div>
                                        </div>
                                        <br-->
                                    </div>

                                </div>
                            </div>
                          
                        </div>
                    </div>
                    <div class="col-md-8 col-xs-12">
                        <div class="white-box">
                            <ul class="nav nav-tabs tabs customtab">
                                <li class="active tab">
                                    <a href="#settings" data-toggle="tab" aria-expanded="false"> <span class="visible-xs"><i class="fa fa-cog"></i></span> <span class="hidden-xs">Datos Personales</span> </a>
                                </li>
                            </ul>
                            <div class="tab-content">
                               
                                <div class=" active tab-pane" id="settings">
                                    <form id="udate_perfil" action="<?php echo base_url() ?>panel_admin/update_perfil" method="post" class="form-horizontal form-material">
                                        <div class="form-group">
                                            <label class="col-md-12">Nombre Completo</label>
                                            <div class="col-md-12">
                                                <input type="text" name="nombre_emp" value="<?= $datos_emp->nombre_emp; ?>" class="form-control form-control-line"> </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="example-email" class="col-md-12">Correo</label>
                                            <div class="col-md-12">
                                                <input type="email" name="email"  value="<?= $datos_emp->email; ?>" class="form-control form-control-line"  id="example-email"> </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-12">DNI</label>
                                            <div class="col-md-12">
                                                <input type="text" name="dni_emp" value="<?= $datos_emp->dni_emp; ?>" class="form-control form-control-line"> </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label class="col-md-12">Teléfono</label>
                                            <div class="col-md-12">
                                                <input type="text" name="telefono_emp" value="<?= $datos_emp->telefono_emp; ?>" class="form-control form-control-line"> </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-12">Imagen</label>
                                            <div class="col-md-12">
                                                <input type="file" name="url_imagen" id="url_imagen" class=" btn-file form-control form-control-line"> </div>
                                                <input type="hidden" name="foto_emp" id="foto_emp" value="" class="form-control"> 
                                        </div>

                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <button class="btn btn-success">Actualizar Perfil</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.row -->
<script type="text/javascript">
$(document).ready(function() { 

    $('.btn-file').on("change", function(evt){
        var base_url= "<?php echo base_url();?>";
        // declaro la variable formData e instancio el objeto nativo de javascript new FormData
        var formData = new FormData(document.getElementById("udate_perfil"));
       // iniciar el ajax
        $.ajax({
            url: base_url + "panel_admin/subir_imgPerfil",
            // el metodo para enviar los datos es POST
            type: "POST",
            // colocamos la variable formData para el envio de la imagen
            data: formData,
            contentType: false,
            processData: false,
            beforeSend: function(data) 
            {
             $('#cargando').html('<i class="fa fa-spinner fa-spin" style="font-size:24px"></i>');
            },
            success: function(data)
            {
               let objJson = JSON.parse(data);
               console.log(objJson.imagen);
               $('.btn-file').addClass('btn btn-info');
               $('#foto_emp').val(objJson.imagen); //agrego el nombre del archivo subido
               $('#cargando').fadeOut("fast",function(){
               $('#cargando').html('<i class=""> </i>');
                });
               $('#cargando').fadeIn("slow");
            } 
        }); 

    });

    /*----------update Perfil---------*/
    $('#udate_perfil').submit(function(e) {
            e.preventDefault();
            var url = '<?php echo base_url() ?>panel_admin/update_perfil';
            var data = $('#udate_perfil').serialize();
            $.ajax({
                    type: 'ajax',
                    method: 'post',
                    url: url,
                    data: data,
                    dataType: 'json',
                    beforeSend: function() {
                        //sweetalert_proceso();
                        console.log("enviando....");

                      }
                 })
                  .done(function(){
                    console.log(data);
                      $.toast({
                          heading: 'Perfil Actualizado',
                          text: 'Se Actualizado corectamente la información.',
                          position: 'top-right',
                          loaderBg: '#ff6849',
                          icon: 'success',
                          hideAfter: 3500,
                          stack: 6
                      });
                     
                  })
                  .fail(function(){
                     //sweetalertclickerror();
                  }) 
                  .always(function(){
                   
                  });
        });

  });        
</script>