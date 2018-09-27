<div class="row bg-title">
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                        <h4 class="page-title">Consultas Cartera</h4> </div>
                    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                        <ol class="breadcrumb">
                            <li><a href="#">Inicio</a></li>
                            <li><a href="#">Consultas Cartera</a></li>
                            <li class="active">Alta de Clientes</li>
                        </ol>
                    </div>
                    <!-- /.col-lg-12 -->
                  
                </div>


<div class="row">
  <div class="col-xs-12">
                        <div class="panel panel-info">
                            <div class="panel-heading">Alta Cliente</div>
                            <div class="panel-wrapper collapse in">
                                <div class="panel-body">
                                  <div class="alert alert-warning"><p><i class="mdi mdi-alert-outline fa-fw"></i><strong>Pulse el botón para desplegar el formulario </strong> </p></div>
                                    
                                  <div class="m-t-15 collapseblebox dn">
                                        <div class="well">
                                          <div class="panel-wrapper collapse in" aria-expanded="true">
                <div class="panel-body">
                    <form  id="add_prod" action="<?php echo base_url() ?>capacitacion/insert_cliente" method="post" data-toggle="validator" >
                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">Nombre</label>
                                         <input type="text" id="nombre_cliente" name="nombre_cliente" class="form-control" placeholder="Escriba nombre "> <span class="help-block">  </span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">Apellidos</label>
                                         <input type="text" id="apellidos" name="apellidos" class="form-control" placeholder="Escriba apellidos"> <span class="help-block">  </span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">No.Identidad</label>
                                         <input type="text" id="dni" name="dni" class="form-control" placeholder="Escriba dni"> <span class="help-block">  </span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">Teléfono</label>
                                         <input type="text" id="telefono" name="telefono" class="form-control" placeholder="Escriba Telefono "> <span class="help-block">  </span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">Email</label>
                                         <input type="text" id="email" name="email" class="form-control" placeholder="Escriba email"> <span class="help-block">  </span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">Celular</label>
                                         <input type="text" id="celular" name="celular" class="form-control" placeholder="Escriba celular"> <span class="help-block">  </span>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">Fecha Nacimiento</label>
                                         <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" class="form-control" placeholder="Escriba fecha nacimiento "> <span class="help-block">  </span>
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
                                         <textarea type="text" id="direccion" name="direccion" class="form-control" placeholder="Escriba Dirección compra "> </textarea><span class="help-block">  </span>
                                    </div>
                                </div>
                            </div>    

                            <!--/row-->
                            <div class="row">
                              <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">Fecha compra:</label>
                                         <input type="date" id="fecha_incio" name="fecha_incio" class="form-control" placeholder="Escriba fecha compra "> <span class="help-block">  </span>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                  <div class="form-group">
                                        <label class="control-label">Productos</label>
                                        <select class="form-control select2"  name="id_producto" id="id_producto" data-placeholder="Seleccione">
                                          <?=  $productos ?>
                                        </select>
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
                                          <th>Cantidad</th>
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
                      <h3 class="box-title"><button type="button" class="btn btn-info btn-rounded collapseble" >Alta Manual</button></h3>
                        <div class="panel">
                            <div class="panel-heading">Cartera de clientes</div>
                            <div class="table-responsive">
<br>
                                <table class="table table-hover manage-u-table" id="editable-datatable">
                                    <thead>
                                        <tr>
                                            <th>No.Identidad</th>
                                            <th>Cliente</th>
                                            <th>Teléfono</th>
                                            <th>Celular</th>
                                            <th width="250">Email</th>
                                            <th width="300">Historial</th>
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
        
        $('#add_prod').submit(function(e) {
            e.preventDefault();
            var url = '<?php echo base_url() ?>capacitacion/insert_cliente';
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

                    console.log(data);
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


        $("#id_producto").on("change",function(){
         $(this).find('select :first').attr("disabled",'true');
         data = $(this).val();
         var option        = $(this).find(':selected')[0];//obtiene el producto seleccionado
         var nombre_prod   =  $('select[name="id_producto"] option:selected').text();
         $(option).attr('disabled', 'disabled'); // y lo desabilita para no volverlo a seleccionar
        
        if (data !='') {
            html = "<tr>";
            html += "<td><input type='hidden' name='productos[]' value='"+data+"'>"+nombre_prod+"</td>";
            html += "<td><input type='text' name='cantidades[]' value='' class='cantidades' required data-parsley-minlength='2'></td>";
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
        sumar();
    });    

     

   

    
        
           
        
    });//onready

    $(document).on("click",".hist-cliente", function(){
           var id = $(this).attr('data');
            window.location.href = "<?php echo base_url();?>historial_cliente/"+id;
        });

    
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
            url:"<?php echo base_url(); ?>capacitacion/load_dataClientes",
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