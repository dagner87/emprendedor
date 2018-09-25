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
                            <div class="panel-heading">Datos del producto</div>
                            <div class="panel-wrapper collapse in">
                                <div class="panel-body">
                                  <div class="alert alert-warning"><p><i class="mdi mdi-alert-outline fa-fw"></i><strong>Pulse el botón para desplegar el formulario </strong> </p></div>
                                    
                                  <div class="m-t-15 collapseblebox dn">
                                        <div class="well">
                                          <div class="panel-wrapper collapse in" aria-expanded="true">
                <div class="panel-body">
                    <form  id="add_prod" action="<?php echo base_url() ?>panel_admin/insert_prod" method="post" data-toggle="validator" >
                        <div class="form-body">
                            <div class="row">
                              <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Categorías</label>
                                        <select class="form-control" data-placeholder="Seleccione una Categoria" tabindex="1" name="id_categoria" id="id_categoria">
                                          <?php if(!empty($categorias))
                                            {
                                              foreach($categorias as $row)
                                                {
                                                 echo '<option value="'.$row->id.'">'.$row->nombre.'</option>';
                                                }
                                            } ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">Detalle</label>
                                        <div class="radio-list">
                                            <label class="radio-inline p-0">
                                                <div class="radio radio-info">
                                                    <input type="radio" name="es_repuesto" value="1" checked="true">
                                                    <label for="radio1">Producto</label>
                                                </div>
                                            </label>
                                            <label class="radio-inline">
                                                <div class="radio radio-info">
                                                    <input type="radio" name="es_repuesto" value="2">
                                                    <label for="radio2">Repuesto </label>
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                </div>
       
                                <div class="col-md-6 col-xs-12 btn-file">
                                    <label for="input-file-now">Subir imagen</label>
                                    <input type="file" id="url_imagen" name="url_imagen" class="dropify " />
                                    <input type="hidden" id="nombre_archivo" name="nombre_archivo"  value="" class="form-control">
                                </div>
                                
                            </div>

                            <!--/row-->
                            <div class="row">
                               <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Nombre</label>
                                        <input type="text" id="nombre_prod" name="nombre_prod" class="form-control" placeholder="Escriba nombre del producto"> <span class="help-block">  </span> </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Precio</label>
                                        <input type="text" id="precio" class="form-control" name="precio" placeholder=""> <span class="help-block"> </span> </div>
                                </div>
                                <!--/span-->
                               
                                <!--/span-->
                            </div>
                            <!--/row-->
                            <div class="row">
                                  <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">Existencia</label>
                                            <input type="text" id="existencia" name="existencia" class="form-control" placeholder=""> <span class="help-block"> </span> </div>
                                    </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Vencimiento</label>
                                        <input type="num" id="vencimiento" name="vencimiento" class="form-control" placeholder=""> <span class="help-block"> </span> </div>
                                </div>
                            </div>
                            <div class="row">
                                  <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">Alto</label>
                                            <input type="text" id="alto" name="alto" class="form-control" placeholder=""> <span class="help-block"> </span> </div>
                                    </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Ancho</label>
                                        <input type="text" id="ancho" name="ancho" class="form-control" placeholder=""> <span class="help-block"> </span> </div>
                                </div>
                            </div>
                            <div class="row">
                                  <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">Largo</label>
                                            <input type="text" id="largo" name="largo" class="form-control" placeholder=""> <span class="help-block"> </span> </div>
                                    </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Peso</label>
                                        <input type="text" id="peso" name="peso" class="form-control" placeholder=""> <span class="help-block"> </span> </div>
                                </div>
                            </div>
                            <div class="row">
                                  <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">SKU</label>
                                            <input type="text" id="sku"  name="sku" class="form-control" placeholder=""> <span class="help-block"> </span> </div>
                                    </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Valor Declarado</label>
                                        <input type="text" id="valor_declarado" name="valor_declarado" class="form-control" placeholder=""> <span class="help-block"> </span> </div>
                                </div>
                            </div>

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
   <div class="col-lg-12">

    <div class="white-box">
        <h3 class="box-title"><button type="button" class="btn btn-info btn-rounded collapseble" >Agregar Producto</button></h3>

        <table class="table table-striped table-bordered table-responsive  contact-list" id="editable-datatable">
            <thead>
                <tr>
                    <th>IMAGEN</th>
                    <th>NOMBRE PRODUCTO</th>
                    <th>EXISTENCIA</th>
                    <th>PRECIO VENTA</th>
                    <th>PRECIO DE TIENDA</th>
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


  <!-- Editable -->
    <script src="<?php echo base_url();?>assets/plugins/bower_components/jquery-datatables-editable/jquery.dataTables.js"></script>
    <script src="<?php echo base_url();?>assets/plugins/bower_components/datatables/dataTables.bootstrap.js"></script>
    <script src="<?php echo base_url();?>assets/plugins/bower_components/tiny-editable/mindmup-editabletable.js"></script>
    <script src="<?php echo base_url();?>assets/plugins/bower_components/tiny-editable/numeric-input-example.js"></script>
    <script>
    
    $(document).ready(function() {
        load_data_cap();
        $('#add_prod').submit(function(e) {
            e.preventDefault();
            var url = '<?php echo base_url() ?>panel_admin/insert_prod';
            var data = $('#add_prod').serialize();
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
                          heading: 'Producto Agregado',
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
                    if ($.fn.DataTable.isDataTable('#editable-datatable')) {
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
        var formData = new FormData(document.getElementById("add_prod"));
       // iniciar el ajax
        $.ajax({
            url: base_url + "panel_admin/subir_img",
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
              var nombre_archivo = $('#nombre_archivo').val(objJson.imagen); //agrego el nombre del archivo subido
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
    $(document).on("click",".deletecap-row-btn", function(){
        $(this).closest("tr").remove();
        var id = $(this).attr('data');
        $.ajax({
                type: 'ajax',
                method: 'get',
                url: '<?php echo base_url() ?>panel_admin/eliminar_prod',
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
            url:"<?php echo base_url(); ?>panel_admin/load_dataProp",
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