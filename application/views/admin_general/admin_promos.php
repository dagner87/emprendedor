<div class="row bg-title">
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                        <h4 class="page-title">ADMINISTRACION DE PROMOCIONES</h4> </div>
                    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                        <ol class="breadcrumb">
                            <li><a href="#">Inicio</a></li>
                            <li><a href="#">Tienda</a></li>
                            <li class="active">Adm.Promociones</li>
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
                <h4 class="modal-title" id="titulo_invit">Nuevo Producto </h4>
            </div>
            <div class="modal-body">
            <form  action="<?php echo base_url() ?>panel_admin/insert_prod" method="post">
            <div class="form-group">
                <label for="exampleInputuname">Nombre producto</label>
                <div class="input-group">
                    <div class="input-group-addon"><i class="ti-layers-alt"></i></div>
                    <input type="text" class="form-control" name="nombre_prod" id="nombre_prod" placeholder=" Escriba Nombre producto" 
                    required data-error="Nombre producto"> 
                    <div class="help-block with-errors"></div>
                </div>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Stock </label>
                <div class="input-group">
                    <div class="input-group-addon"><i class="ti-shopping-cart-full"></i></div>
                    <input type="text" class="form-control"  name="stock" id="stock" placeholder=" Escriba Stock" required> </div>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Precio Tienda </label>
                <div class="input-group">
                    <div class="input-group-addon"><i class="ti-shopping-cart-full"></i></div>
                    <input type="text" class="form-control"  name="precio_original" id="precio_original" placeholder=" Escriba Precio Tienda" required> </div>
            </div>
            <div class="form-group">
                <label for="exampleInputphone">Precio Mayorista</label>
                <div class="input-group">
                    <div class="input-group-addon"><i class="ti-money"></i></div>
                    <input type="text" class="form-control" name="precio_unitario" id="precio_unitario" placeholder="Escriba Precio Unitario" required > </div>
            </div>
            <div class="form-group">
                <label for="exampleInputphone">Imagen</label>
                <div class="input-group">
                    <div class="input-group-addon"><i id="cargando" class="ti-camera"> </i></div>
                    <input type="file" class="form-control btn-file1" name="url_imagen1" id="url_imagen1" placeholder="Subir Imagen" required> </div>
                     <input type="text" id="nombre_archivo" name="nombre_archivo"  value="" class="form-control">
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
  <div class="col-xs-12">
                        <div class="panel panel-info">
                            <div class="panel-heading">Datos de Promociones</div>
                            <div class="panel-wrapper collapse in">
                                <div class="panel-body">
                                  <div class="alert alert-warning"><p><i class="mdi mdi-alert-outline fa-fw"></i><strong>Pulse el botón para desplegar el formulario </strong> </p></div>
                                    
                                  <div class="m-t-15 collapseblebox dn">
                                        <div class="well">
                                          <div class="panel-wrapper collapse in" aria-expanded="true">
                <div class="panel-body">
                    <form  id="add_prod" action="<?php echo base_url() ?>panel_admin/insert_promo" method="post" data-toggle="validator">
                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Nombre de Promoción</label>
                                         <input type="text" id="nombre_promo" name="nombre_promo" class="form-control" placeholder="Escriba nombre " required data-error="Agrege Nombre de Promoción"> 
                                         <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Descuento</label>
                                         <input type="text" id="descuento" name="descuento" class="form-control" placeholder="Escriba descuento " required data-error="Agrege Descuento"> <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Fecha inicio</label>
                                         <input type="date" id="fecha_inicio" name="fecha_inicio" class="form-control" placeholder="Escriba fecha inicio" required data-error="Agrege Fecha inicio"> 
                                         <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Fecha fin</label>
                                         <input type="date" id="fecha_fin" name="fecha_fin" class="form-control" placeholder="Escriba fecha_fin" required data-error="Agrege Fecha fin"> 
                                         <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                
                                
                            </div>
                           
                            <!--/row-->
                            <div class="row">
                                <div class="col-md-12">
                                  <div class="form-group">
                                        <label class="control-label">Productos</label>
                                        <select class="form-control select2"  name="id_producto" id="id_producto" data-placeholder="Seleccione" required data-error="Agrege Productos">
                                          <?=  $productos ?>
                                        </select>
                                         <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                
                            </div>
                            <!--/row-->
                            <div class="row">
                               <div class="col-lg-12">
                                 <table id="tb-combo" class="table table-bordered table-striped table-hover">
                                  <thead>
                                      <tr>
                                          <th>Producto</th>
                                          <th></th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                    
                                  
                                  </tbody>
                              </table>
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
        <div class="col-md-12">
          <h3 class="box-title"><button type="button" class="btn btn-info btn-rounded collapseble" ><i class="fa fa-plus"></i> Agregar Promoción</button></h3>
            <div class="panel">
                <div class="panel-heading">Lista de Promociones</div>
                <div class="table-responsive">
                 <br>
                <table class="table table-hover manage-u-table" id="promo-table">
                        <thead>
                            <tr>
                                <th>Nombre Promocion</th>
                                <th>Productos</th>
                                <th>Fecha inicio</th>
                                <th>Fecha fin</th>
                                <th>Descuento</th>
                                <th>Accion</th>
                            </tr>
                        </thead>
                        <tbody id="contenido_tabla">
                            
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
        // Basic
        $('.dropify').dropify({
            messages: {
                default: 'No hay archivo seleccionado',
                replace: nombre_archivo ,
                remove: 'Remover',
                error: 'No se pudo mostrar'
            }
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
        
        $('#add_prod').submit(function(e) {
            e.preventDefault();
            var url = '<?php echo base_url() ?>panel_admin/insert_promo';
            var data = $('#add_prod').serialize();
            $.ajax({
                    type: 'ajax',
                    method: 'post',
                    url: url,
                    data: data,
                    dataType: 'json',
                    beforeSend: function() {
                        $("#add_prod")[0].reset();
                        console.log("enviando....");
                      }
                 })
                  .done(function(data){

                    console.log(data.comprobador);
                      $.toast({
                          heading: 'Cliente Agregado',
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
                    if ($.fn.DataTable.isDataTable('#promo-table')) {
                      table = $('#promo-table').DataTable();
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


        $("#id_producto").on("change",function(){
         $(this).find('select :first').attr("disabled",'true');
         data = $(this).val();
         var option        = $(this).find(':selected')[0];//obtiene el producto seleccionado
         var nombre_prod   =  $('select[name="id_producto"] option:selected').text();
         $(option).attr('disabled', 'disabled'); // y lo desabilita para no volverlo a seleccionar
        
        if (data !='') {
            html = "<tr>";
            html += "<td><input type='hidden' name='productos[]' value='"+data+"'>"+nombre_prod+"</td>";
            html += "<td><button type='button' class='btn btn-danger btn-remove-producto'><span class='fa fa-remove'></span></button></td>";
            html += "</tr>";
            $("#tb-combo tbody").append(html);
           
        }else{
            alert("seleccione un producto...");
        }
    });

     $('#id_provincia').on("click", function(evt){
          var id = $('#id_provincia').val();
          console.log(id);
          $.ajax({
            type: "POST",
            url: "<?php echo base_url();?>capacitacion/select_municipio",
            data: {id: id},
            success: function (data) {
              $('#id_municipio').html(data);
             }
          });
    }); 

    $(document).on("click",".btn-remove-producto", function(){
        $(this).closest("tr").remove();
        
    });   

        
    });//onready

   
    
    $(document).on("click",".deletecap-row-btn", function(){
        $(this).closest("tr").remove();
        var id = $(this).attr('data');
        $.ajax({
                type: 'ajax',
                method: 'get',
                url: '<?php echo base_url() ?>panel_admin/eliminar_promo',
                data: {id: id},
                async: false,
                dataType: 'json',
                success: function(data){
                  $.toast({
                        heading: 'Promoción eliminada ',
                        text: 'La Promoción a sido eliminada.',
                        position: 'top-right',
                        loaderBg: '#ff6849',
                        icon: 'error',
                        hideAfter: 2500
                    });
                  if ($.fn.DataTable.isDataTable( '#promo-table' ) ) {
                      table = $('#promo-table').DataTable();
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
            url:"<?php echo base_url(); ?>panel_admin/load_dataPromo",
            method:"POST",
            success:function(data)
            {
             $('#contenido_tabla').html(data);
               var table = $('#promo-table').DataTable({
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