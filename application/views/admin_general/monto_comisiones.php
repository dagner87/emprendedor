<div class="row bg-title">
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                        <h4 class="page-title">ADMINISTACION DE COMISIONES</h4> </div>
                    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                        <ol class="breadcrumb">
                            <li><a href="#">Inicio</a></li>
                            <li><a href="#">Configuración</a></li>
                            <li class="active">Adm. Rango Comisiones</li>
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
                <h4 class="modal-title" id="titulo_invit">Nuevo Monto </h4>
            </div>
            <div class="modal-body">
                <form id="add_cap" action="" method="post">
                   <input type="text" name="id_monto" id="id_monto" value="">
                   <input type="text" name="camino" id="camino" value="">

            <div class="form-group">
                <label for="monto_minimo">MONTO MINIMO</label>
                <div class="input-group">
                    <div class="input-group-addon"><i class="fa fa-money"></i></div>
                    <input type="text" class="form-control" name="monto_minimo" id="monto_minimo" placeholder=" Escriba monto minimo" required> </div>
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
        <div class="col-md-12">

          <h3 class="box-title"><button type="button"  id="btn-agregar" class="btn btn-info btn-rounded collapseble" data-toggle="modal" data-target="#insetcapModal" ><i class="fa fa-plus"></i> Agregar Monto minimo</button></h3>
            <div class="panel">
                <div class="panel-heading">Lista de Rango de  comisiones</div>
                <div class="table-responsive">
                 <br>
                <table class="table table-hover manage-u-table" id="editable-datatable">
                        <thead>
                            <tr>
                              <th>MONTO MINIMO</th>
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



  <!-- Editable -->
    <script src="<?php echo base_url();?>assets/plugins/bower_components/jquery-datatables-editable/jquery.dataTables.js"></script>
    <script src="<?php echo base_url();?>assets/plugins/bower_components/datatables/dataTables.bootstrap.js"></script>
    <script src="<?php echo base_url();?>assets/plugins/bower_components/tiny-editable/mindmup-editabletable.js"></script>
    <script src="<?php echo base_url();?>assets/plugins/bower_components/tiny-editable/numeric-input-example.js"></script>
    <script>
    
    
    $(document).ready(function() {
        load_data_cap();


        $('#add_cap').submit(function(e) {
            e.preventDefault();
            var url    = '<?php echo base_url() ?>panel_admin/insert_monto';
            var url_up = '<?php echo base_url() ?>panel_admin/update_monto';
            var data   = $('#add_cap').serialize();
            var camino = $('#camino').val();

            if (camino == 'insertar')
              {
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
                              heading: 'Rango de comisión Agregado',
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
                                      heading: 'Rango de comisión Editado',
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

     
        
    });//onready

    $(document).on("click","#btn-agregar", function(){
        $("#add_cap")[0].reset();
        $('#camino').val("insertar");
    });

     $(document).on("click",".edit-row-btn", function(){
        var id = $(this).attr('data');
        $('#camino').val("editar");
        $('#id_monto').val(id);
        $.ajax({
                type: 'ajax',
                method: 'get',
                url: '<?php echo base_url() ?>panel_admin/getdatos_monto',
                data: {id: id},
                async: false,
                dataType: 'json',
                success: function(data){
                   $('#monto_minimo').val(data.monto_minimo);
                   
                 },
                error: function(){
                  alert('No se pudo mostrar');
                }
        });
        
    });  


    $(document).on("click",".deletecap-row-btn", function(){
        $(this).closest("tr").remove();
        var id = $(this).attr('data');
        $.ajax({
                type: 'ajax',
                method: 'get',
                url: '<?php echo base_url() ?>panel_admin/eliminar_monto',
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
            url:"<?php echo base_url(); ?>panel_admin/load_datamonto",
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
    