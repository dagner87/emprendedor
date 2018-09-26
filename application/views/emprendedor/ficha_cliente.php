<div class="row bg-title">
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title">Historial de Clientes</h4> </div>
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url() ?>">Inicio</a></li>
            <li class="active">Consultas Cartera / Historial de Cliente </li>
        </ol>
    </div>
    <!-- /.col-lg-12 -->
</div>
<div class="row">
    <div class="col-md-12 col-lg-6 col-sm-12">
                        <div class="panel panel-success">
                            <div class="panel-heading"> Ficha cliente.
                                <div class="pull-right"><a href="#" data-perform="panel-collapse"><i class="ti-minus"></i></a> </div>
                            </div>
                            <div class="panel-wrapper collapse in" aria-expanded="true">
                                <div class="panel-body">
                                    <h3 class="box-title"><?= $datos_cliente->nombre_cliente." ".$datos_cliente->apellidos  ?></h3>
                                    <dl>

                                        <dt>DNI:</dt>
                                        <dd><?= $datos_cliente->dni     ?></dd>
                                        <dt>Telefono:</dt>
                                        <dd><?= $datos_cliente->telefono     ?></dd>
                                        <dt>Celular:</dt>
                                        <dd><?= $datos_cliente->celular ?></dd>
                                         <dt>Email:</dt>
                                        <dd><?= $datos_cliente->email ?></dd>
                                        <dt>Dirección:</dt>
                                        <dd><?= $datos_cliente->direccion ?></dd>
                                      
                                        
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>
  
    <div class="col-md-12 col-lg-6 col-sm-12">
                        <div class="panel panel-info">
                            <div class="panel-heading"> Editar datos del cliente:
                                <div class="pull-right"><a href="#" data-perform="panel-collapse"><i class="ti-plus"></i></a> </div>
                            </div>
                            <div class="panel-wrapper collapse" aria-expanded="false">
                                <div class="panel-body">
                        <form  id="add_prod" action="<?php echo base_url() ?>capacitacion/update_datosCliente" method="post" 
                            data-toggle="validator" >
                            <input type="hidden" id="id_cliente" name="id_cliente" value="<?= $datos_cliente->id_cliente ?>">
                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">Nombre</label>
                                         <input type="text" id="nombre_cliente" name="nombre_cliente" class="form-control" placeholder="Escriba nombre" value="<?= $datos_cliente->nombre_cliente ?>"> 
                                         <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">Apellidos</label>
                                         <input type="text" id="apellidos" name="apellidos" class="form-control"   value="<?= $datos_cliente->apellidos     ?>" placeholder="Escriba apellidos"> <span class="help-block">  </span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">No.Identidad</label>
                                         <input type="text" id="dni" name="dni" class="form-control" value="<?= $datos_cliente->dni ?>" placeholder="Escriba dni"> <span class="help-block">  </span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">Teléfono</label>
                                         <input type="text" id="telefono" name="telefono" class="form-control"value="<?= $datos_cliente->telefono ?>"  placeholder="Escriba Telefono "> <span class="help-block">  </span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">Email</label>
                                         <input type="text" id="email" name="email" class="form-control" value="<?= $datos_cliente->email ?>" placeholder="Escriba email"> <span class="help-block">  </span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">Celular</label>
                                         <input type="text" id="celular" name="celular" class="form-control" value="<?= $datos_cliente->celular ?>" placeholder="Escriba celular"> <span class="help-block">  </span>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">Fecha Nacimiento</label>
                                         <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" class="form-control" value="<?= $datos_cliente->fecha_nacimiento ?>" placeholder="Escriba fecha nacimiento "> <span class="help-block">  </span>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">Provincia</label>
                                          <select class="form-control select2"  name="id_provincia" id="id_provincia" data-placeholder="Seleccione">
                                          <?php 
                                          if(!empty($provincias))
                                                  {
                                                    foreach($provincias as $row)
                                                      {
                                                      echo '<option value="'.$row->id_provincia.'">'.$row->nombre.'</option>';
                                                      }
                                                  }

                                                  ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">Comuna</label>
                                         <select class="form-control select2"  name="id_municipio" id="id_municipio" data-placeholder="Seleccione">
                                        </select>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="row">
                              <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label">Dirección:</label>
                                         <textarea type="text" id="direccion" name="direccion" class="form-control"><?= $datos_cliente->direccion ?></textarea><span class="help-block">  </span>
                                    </div>
                                </div>
                            </div>    


                        <div class="form-actions">
                            <button type="submit" class="btn btn-success collapseble"> <i class="fa fa-check"></i> Actualizar</button>
                            
                        </div>
        </form>
                    </div>
                </div>
            </div>
    </div>
</div>

<div class="row">
   <div class="col-md-12">
    <h4 class="box-title m-b-20"></h4>
    <div class="panel-group" role="tablist" aria-multiselectable="true">
        <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingOne">
                <h4 class="panel-title"> <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne" class="font-bold"> Historial de Compras</a> </h4> </div>
            <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                <div class="panel-body">
                    <div class="row">
                            <div class="col-md-12">
                            <div class="panel panel-info">
                                <div class="table-responsive">
                            <br>
                                    <table class="table table-hover manage-u-table" id="editable-datatable">
                                        <thead>
                                            <tr>
                                                <th>No.operación</th>
                                                <th>Pedidos</th>
                                                <th>Importe</th>
                                                <th>Fecha compra</th>
                                                <th>Garantía</th>
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
        <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingFour"> <a class="collapsed font-bold panel-title" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="false" aria-controls="collapseFour"> Gestión de Reposición de Unidades Filtrantes </a> </div>
            <div id="collapseFour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFour">
                <div class="panel-body"> 
                    <div class="row">
                            <div class="col-md-12">
                            <div class="panel panel-info">
                                <div class="table-responsive">
                            <br>
                                    <table id="tb-exist_resp" class="table table-bordered table-striped table-hover">
                                  <thead>
                                      <tr>
                                          <th>Producto</th>
                                          <th>Vencimiento</th>
                                          <th></th>
                                      </tr>
                                  </thead>
                                  <tbody id="contenido_vencimientos">
                                    
                                  
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
    </div>
</div>
      <script>
    
    $(document).ready(function() {
        load_data_cap();
        load_data_vencimientos();
     
        $('#add_prod').submit(function(e) {
                e.preventDefault();
                var url = '<?php echo base_url() ?>capacitacion/update_datosCliente';
                var data = $('#add_prod').serialize();
                $.ajax({
                        type: 'ajax',
                        method: 'post',
                        url: url,
                        data: data,
                        dataType: 'json',
                        beforeSend: function() {
                            
                            console.log("enviando....");
                          }
                     })
                      .done(function(data){

                        console.log(data);
                          $.toast({
                              heading: 'Cliente Actualizado',
                              text: 'Se actualizó correctamente la información.',
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

        
           
        
    });//onready


   
    function load_data_cap()
    {
        id = $('#id_cliente').val();
        $.ajax({
            url:"<?php echo base_url(); ?>capacitacion/load_historialCompra",
            method:"post",
            data:{id:id},
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

        function load_data_rep_cli()
    {
        $.ajax({
            url:"<?php echo base_url(); ?>capacitacion/load_data_rep_cli",
            method:"POST",
            success:function(data)
            {
             
             $('#contenido_filtros').html(data);

              var table = $('#datatable-contenido_filtros').DataTable({
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

    function load_data_vencimientos()
    {
        $.ajax({
            url:"<?php echo base_url(); ?>capacitacion/load_data_vencimientos",
            method:"POST",
            success:function(data)
            {
             $('#contenido_vencimientos').html(data);
               var table = $('#tb-exist_resp').DataTable({
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
              // var cont = $('#editable-datatable').editableTableWidget().numericInputExample().find('td:first').focus();
              // console.log(cont.text());
            }
        })
    }

    </script>            