<div class="row bg-title">
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                        <h4 class="page-title">ALMACEN DE PRODUCTOS</h4> </div>
                    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                        <ol class="breadcrumb">
                            <li><a href="#">Inicio</a></li>
                            <li><a href="#">Ventas</a></li>
                            <li class="active">Almacen de Productos</li>
                        </ol>
                    </div>
                    <!-- /.col-lg-12 -->
                  
                </div>

 <!-- .modal for add task -->
                            <div class="modal fade" id="insetprodModal" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                            <h4 class="modal-title" id="titulo_invit">Nuevo Producto </h4>
                                        </div>
                                        <div class="modal-body">
                                            <form id="add_prod" action="" method="post">
                                        
                                        
                                        <div class="row">
                                            <div class="col-md-12">
                                              <div class="form-group">
                                                    <label class="control-label">Productos</label>
                                                    <select class="form-control select2"  name="id_producto" id="id_producto" data-placeholder="Seleccione">
                                                      <?=  $productos ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Existencia</label>
                                            <div class="input-group">
                                                <div class="input-group-addon"><i class="ti-email"></i></div>
                                                <input type="text" class="form-control"  name="existencia" id="existencia" placeholder=" Existencia"> </div>
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
      <h3 class="box-title"><button type="button" class="btn btn-info btn-rounded" data-toggle="modal" data-target="#insetprodModal"><i class="fa fa-plus"></i> Añadir Producto </button> </h3>
      <br>
           <h4 class="modal-title" id="titulo_invit">Listado de mis productos </h4>
        <table class="table table-striped table-bordered color-table info-table table-responsive contact-list " id="editable-datatable">
            <thead>
                <tr>
                    <th>PRODUCTO</th>
                    <th>SKU</th>
                    <th>EXISTENCIA</th>
                </tr>
            </thead>
            <tbody id="contenido_compras">
              
               
            </tbody>
            
        </table>
    </div>
</div>
</div>
    <script>
    
    $(document).ready(function() {
        load_data_cap();
        
        $('#add_prod').submit(function(e) {
            e.preventDefault();
            var url = '<?php echo base_url() ?>capacitacion/insert_prodAlmacen';
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


        
    });//onready

    $(document).on("click",".deletecap-row-btn", function(){
        $(this).closest("tr").remove();
        var id = $(this).attr('data');
        $.ajax({
                type: 'ajax',
                method: 'get',
                url: '<?php echo base_url() ?>panel_admin/eliminar_combo',
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
            url:"<?php echo base_url(); ?>capacitacion/load_dataAlmacen",
            method:"POST",
            success:function(data)
            {
             $('#contenido_compras').html(data);
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

               table.$('input[type="text"]').on('change', this, function(){
                 var val = $(this).val();
                 //var name = $(this).attr("name");
                 var valor =  $(this).attr("id").split('_');
                 console.log(valor[0]+"-"+val+"-"+valor[1]);
            
             $.get( "<?php echo base_url();?>capacitacion/updateTable",{ 
                   id_producto:valor[1],
                   valor:val
                  })
                .done(function(data) {
                  console.log(data);
                 $('#capa_'+valor[0]+valor[1]).html('<i class="fa fa-spinner fa-spin"></i>').fadeIn().delay(2000).fadeOut('slow');
                 //load_data_cap();
                              
                }); 

                }); 



              
              
            }
        })
    }

    </script>
    <!--Style Switcher -->
    <script src="<?php echo base_url();?>assets/plugins/bower_components/styleswitcher/jQuery.style.switcher.js"></script>