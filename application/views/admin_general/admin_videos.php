<div class="row bg-title">
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                        <h4 class="page-title">ADMINISTACION DE CAPACITACION</h4> </div>
                    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                        <ol class="breadcrumb">
                            <li><a href="#">Inicio</a></li>
                            <li><a href="#">Capacitación</a></li>
                            <li class="active">Adm.Videos</li>
                        </ol>
                    </div>
                    <!-- /.col-lg-12 -->
                  
                </div>

<!-- .modal for add task -->
<div class="modal fade" id="insetcapModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="titulo_invit">Nuevo Video </h4>
            </div>
            <div class="modal-body">
                <form id="add_cap" action="<?php echo base_url() ?>panel_admin/insert_cap" method="post">
            <div class="form-group">
                <label for="exampleInputuname">Titulo</label>
                <div class="input-group">
                    <div class="input-group-addon"><i class="ti-video-clapper"></i></div>
                    <input type="text" class="form-control" name="titulo_video" id="titulo_video" placeholder=" Escriba Titulo Video"> </div>
            </div>
            <div class="form-group">
                <label for="exampleInputphone">Imagen</label>
                <div class="input-group">
                    <div class="input-group-addon"><i id="cargando" class="ti-camera"> </i></div>
                    <input type="file" class="form-control btn-file" name="url_imagen" id="url_imagen" placeholder="Subir Imagen" required> </div>
                     <input type="hidden" id="nombre_archivo" name="nombre_archivo"  value="" class="form-control">

            </div>
            <div class="form-group">
                <label for="exampleInputuname">Descripción</label>
                <div class="input-group">
                    <div class="input-group-addon"><i class="ti-video-clapper"></i></div>
                    <textarea type="text" class="form-control" name="descripcion" id="descripcion" placeholder=" Escriba descripcion"></textarea></div>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">URL </label>
                <div class="input-group">
                    <div class="input-group-addon"><i class="ti-link"></i></div>
                    <input type="url" class="form-control"  name="url_video" id="url_video" placeholder=" Escriba URL"> </div>
            </div>
            <div class="form-group">
                <label for="exampleInputphone">Evaluación</label>
                <div class="input-group">
                    <div class="input-group-addon"><i class="ti-write"></i></div>
                    <input type="tel" class="form-control" name="evaluacion" id="evaluacion" placeholder="Escriba Evaluación"> </div>
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

<div class="row">
<div class="col-lg-12">

    <div class="white-box">
        <h3 class="box-title"><button type="button" class="btn btn-info btn-rounded" data-toggle="modal" data-target="#insetcapModal">Agregar Capacitación</button></h3>

        <table class="table table-hover manage-u-table contact-list" id="editable-datatable">
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

  <!-- Editable -->
    <script src="<?php echo base_url();?>assets/plugins/bower_components/jquery-datatables-editable/jquery.dataTables.js"></script>
    <script src="<?php echo base_url();?>assets/plugins/bower_components/datatables/dataTables.bootstrap.js"></script>
    <script src="<?php echo base_url();?>assets/plugins/bower_components/tiny-editable/mindmup-editabletable.js"></script>
    <script src="<?php echo base_url();?>assets/plugins/bower_components/tiny-editable/numeric-input-example.js"></script>
    <script>
    //$('#mainTable').editableTableWidget().numericInputExample().find('td:first').focus();
    
    $(document).ready(function() {
        load_data_cap();
        $('#add_cap').submit(function(e) {
            e.preventDefault();
            var url = '<?php echo base_url() ?>panel_admin/insert_cap';
            var data = $('#add_cap').serialize();
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
                          heading: 'Video Agregado',
                          text: 'Se agregó corectamente la información.',
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
        
    });//onready
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
               $('#editable-datatable').editableTableWidget().numericInputExample().find('td:first').focus();
            }
        })
    }
    </script>
    <!--Style Switcher -->
    <script src="<?php echo base_url();?>assets/plugins/bower_components/styleswitcher/jQuery.style.switcher.js"></script>