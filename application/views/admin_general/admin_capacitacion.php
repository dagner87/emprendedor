<div class="row bg-title">
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                        <h4 class="page-title">ADMINISTACION DE PRODUCTOS</h4> </div>
                    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                        <ol class="breadcrumb">
                            <li><a href="#">Inicio</a></li>
                            <li><a href="#">Tienda</a></li>
                            <li class="active">Adm.Productos</li>
                        </ol>
                    </div>
                    <!-- /.col-lg-12 -->
                  
                </div>

           


<div class="row">
  <div class="col-xs-12">
                        <div class="panel panel-info">
                            <div class="panel-heading">Datos de Capacitación</div>
                            <div class="panel-wrapper collapse in">
                                <div class="panel-body">
                                  <div class="alert alert-warning"><p><i class="mdi mdi-alert-outline fa-fw"></i><strong> Pulse el botón para desplegar el formulario </strong> </p></div>

                                    
                                  <div class="m-t-15 collapseblebox dn">
                                        <div class="well">

                                          <div class="panel-wrapper collapse in" aria-expanded="true">
                <div class="panel-body">
                    <form  id="add_cap" action="" method="post" data-toggle="validator" >
                        <input type="text" name="id_cap" id="id_cap" value="">
                        <input type="text" name="camino" id="camino" value="">
                        <div class="form-body">
                            
                                <div class="form-group">
                                    <label for="titulo_video" class="control-label">Titulo</label>
                                    <input type="text" class="form-control" name="titulo_video" id="titulo_video" placeholder="Escriba Titulo Video"  data-error="Escriba un titulo" required>
                                    <div class="help-block with-errors"></div>
                                </div>
                                <div class="form-group">
                                    <div class="btn-file">
                                        <label for="url_imagen">Subir imagen</label>
                                        <input type="file" id="url_imagen" name="url_imagen" class="dropify" required data-error="Agrege una imagen"/>
                                        <input type="hidden" id="nombre_archivo" name="nombre_archivo"  value="" class="form-control" >
                                    </div>
                                     <div class="help-block with-errors"></div>
                                </div>    
                                <div class="form-group">
                                    <label for="url_video"  class="control-label">URL</label>
                                    <input type="url" class="form-control" id="url_video" name="url_video"  placeholder="Escriba URL" 
                                    data-error="Escriba una url correcta" required>
                                    <div class="help-block with-errors"></div>
                                </div>
                                <div class="form-group">
                                    <label for="descripcion" class="control-label">Descripción</label>
                                    <textarea id="descripcion"  name="descripcion" class="form-control" required></textarea> 
                                    <span class="help-block with-errors"></span> 
                                </div>
                                <div class="form-group">
                                    <label for="evaluacion"  class="control-label">Evaluación</label>
                                    <input type="num" class="form-control" id="evaluacion" name="evaluacion"  placeholder="Escriba Evaluación" 
                                    data-error="Escriba Evaluación correcta" required>
                                    <div class="help-block with-errors"></div>
                                </div>
                                
                            <!--/row--> 
                      
                        <div class="form-actions">
                            <button type="submit" class="btn btn-success collapseble"> <i class="fa fa-check"></i> Guardar</button>
                            <button type="button" class="btn btn-default">Limpiar</button>
                        </div>
                    </form>
                </div>
            </div>
          </div>
     </div>
   </div>

   <div class="row">

                    <div class="col-md-12">
                      <h3 class="box-title"><button type="button" id="btn-agregar" class="btn btn-info btn-rounded collapseble" > <i class="fa fa-plus"></i> Agregar Capacitación</button></h3>

                        <div class="panel">
                            <div class="table-responsive">
                                <table class="table table-hover manage-u-table" id="editable-datatable">
                                    <thead>
                                         <tr>
                                            <th>TITULO VIDEO</th>
                                            <th>URL</th>
                                            <th>VALOR EVALUATIVO</th>
                                            <th>ACCION</th>
                                        </tr>
                                    </thead>
                                    <tbody id="contenido_video">
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
 

</div>
        </div>
    </div>

</div>


  <!-- Editable -->
    <script src="<?php echo base_url();?>assets/plugins/bower_components/jquery-datatables-editable/jquery.dataTables.js"></script>
    <script src="<?php echo base_url();?>assets/plugins/bower_components/datatables/dataTables.bootstrap.js"></script>
    <script src="<?php echo base_url();?>assets/plugins/bower_components/tiny-editable/mindmup-editabletable.js"></script>
    <script src="<?php echo base_url();?>assets/plugins/bower_components/tiny-editable/numeric-input-example.js"></script>
    <script>


    
    $(document).ready(function() {
        load_data_cap();

       
    $('#evaluacion').keypress(function(tecla) {
        if(tecla.charCode < 48 || tecla.charCode > 57) return false;
    });

     $('#add_cap').submit(function(e) {

            e.preventDefault();
            var url = '<?php echo base_url() ?>panel_admin/insert_cap';
            var url_up = '<?php echo base_url() ?>panel_admin/update_cap';
            var data = $('#add_cap').serialize();

            var camino = $('#camino').val();

            if (camino == 'insertar')
               {
                console.log("insertar");

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
                          .done(function(data){
                            console.log(data);
                              $.toast({
                                  heading: 'Video Agregado',
                                  text: 'Se agregó correctamente la información.',
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
                            if ($.fn.DataTable.isDataTable( '#editable-datatable' ) ) {
                              table = $('#editable-datatable').DataTable();
                              table.destroy();
                              console.log("estoy dentro el if");
                              load_data_cap();
                              }
                              else {
                                   console.log("estoy en el else");
                                  load_data_cap();
                                  }
                          });



               }else{

                console.log("editar");

                        $.ajax({
                            type: 'ajax',
                            method: 'post',
                            url: url_up,
                            data: data,
                            dataType: 'json',
                            beforeSend: function() {
                                //sweetalert_proceso();
                                console.log("editando....");
                              }
                         })
                          .done(function(data){
                            
                          if (data.comprobador) {

                            $.toast({
                                  heading: 'Video Editado',
                                  text: 'Se ha editado correctamente la información.',
                                  position: 'top-right',
                                  loaderBg: '#ff6849',
                                  icon: 'info',
                                  hideAfter: 3500,
                                  stack: 6
                              });


                          }
                              
                             
                          })
                          .fail(function(){
                             //sweetalertclickerror();
                          }) 
                          .always(function(){
                            if ($.fn.DataTable.isDataTable( '#editable-datatable' ) ) {
                              table = $('#editable-datatable').DataTable();
                              table.destroy();
                              console.log("estoy dentro el if");
                              load_data_cap();
                              }
                              else {
                                   console.log("estoy en el else");
                                  load_data_cap();
                                  }
                          });
                

                    }
           


         
        });
     

    $('.btn-file').on("change", function(evt){
        var base_url= "<?php echo base_url();?>";
        // declaro la variable formData e instancio el objeto nativo de javascript new FormData
        var formData = new FormData(document.getElementById("add_cap"));
       // iniciar el ajax
        $.ajax({
            url: base_url + "panel_admin/subir_imgVideo",
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
               $('#nombre_archivo').val(objJson.imagen); //agrego el nombre del archivo subido
               $('#cargando').fadeOut("fast",function(){
               $('#cargando').html('<i class=""> </i>');
                });
               $('#cargando').fadeIn("slow");
            } 
        }); 
      }); 

       // Basic
        $('.dropify').dropify({
            messages: {
                default: 'No hay archivo seleccionado',
                replace: nombre_archivo ,
                remove: 'Remover',
                error: 'No se pudo mostrar'
            }
        });
       

           
        
    });//onready


    $(document).on("click",".btn-remove-producto", function(){
        $(this).closest("tr").remove();
        sumar();
    });


    $(document).on("click","#btn-agregar", function(){
        $("#add_cap")[0].reset();
        $('#camino').val("insertar");
    });
    
    $(document).on("click",".btn-asociar-respuesto", function(){
        $(this).closest("tr").remove();
        var id = $(this).attr('data');
        $('#id_producto').val(id);
    });

    $(document).on("click",".edit-row-btn", function(){
        var id = $(this).attr('data');
        $('#camino').val("editar");
        $(".collapseblebox").css({'display': "block" });
        $.ajax({
                type: 'ajax',
                method: 'get',
                url: '<?php echo base_url() ?>panel_admin/getdatos_cap',
                data: {id: id},
                async: false,
                dataType: 'json',
                success: function(data){

                   
                   console.log(data);
                    $('#id_cap').val(data.id_cap); 
                    $('#titulo_video').val(data.titulo_video);
                    $('#descripcion').val(data.descripcion);
                    $('#imag_portada').val(data.imag_portada);
                    $('#nombre_archivo').val(data.imag_portada);
                    $('#url_video').val(data.url_video);
                    $('#evaluacion').val(data.evaluacion);                  
                    
                 
                
                },
                error: function(){
                  alert('No se pudo eliminar');
                }
        });
        
    });

    $(document).on("click",".deletecap-row-btn", function(){
        $(this).closest("tr").remove();
        var id = $(this).attr('data');
        $.ajax({
                type: 'ajax',
                method: 'get',
                url: '<?php echo base_url() ?>panel_admin/eliminar_cap',
                data: {id: id},
                async: false,
                dataType: 'json',
                success: function(data){
                  $.toast({
                        heading: 'Video eliminado ',
                        text: 'El video a sido eliminado.',
                        position: 'top-right',
                        loaderBg: '#ff6849',
                        icon: 'error',
                        hideAfter: 2500
                    });
                  if ($.fn.DataTable.isDataTable( '#editable-datatable' ) ) {
                      table = $('#editable-datatable').DataTable();
                      table.destroy();
                      console.log("estoy dentro el if");
                      load_data_cap();
                      }
                      else {
                           console.log("estoy en el else");
                          load_data_cap();
                          }
                },
                error: function(){
                  alert('No se pudo eliminar');
                }
        });
        
    });
       function load_data_cap()
    {
        $.ajax({
            url:"<?php echo base_url(); ?>panel_admin/load_datAdmCap",
            method:"POST",
            success:function(data)
            {
             $('#contenido_video').html(data);
               var table = $('#editable-datatable').DataTable({
                 responsive: true,
                 language: {
                              "lengthMenu": "Mostrar _MENU_ registros por pagina",
                              "zeroRecords": "No se encontraron resultados en su busqueda",
                              "searchPlaceholder": "Buscar registros",
                              "info": "Mostrando  _START_ al _END_ de un total de  _TOTAL_ registros",
                              "infoEmpty": "No existen registros",
                              "infoFiltered": "(filtrado de un total de _MAX_ registros)",
                              "search": "Buscar:",
                              "paginate": {
                                            "first": "Primero",
                                            "last": "Último",
                                            "next": "Siguiente",
                                            "previous": "Anterior"
                                          },
                    }
               });
             
            }
        })
    }

    </script>
    <!--Style Switcher -->
    <script src="<?php echo base_url();?>assets/plugins/bower_components/styleswitcher/jQuery.style.switcher.js"></script>