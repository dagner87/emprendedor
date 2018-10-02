<div class="row bg-title">
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                        <h4 class="page-title">ADMINISTACION DE COMBOS</h4> </div>
                    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                        <ol class="breadcrumb">
                            <li><a href="#">Inicio</a></li>
                            <li><a href="#">Tienda</a></li>
                            <li class="active">Adm.Combos</li>
                        </ol>
                    </div>
                    <!-- /.col-lg-12 -->
                  
                </div>


<div class="row">
  <div class="col-xs-12">
                        <div class="panel panel-info">
                            <div class="panel-heading">Datos del Combo</div>
                            <div class="panel-wrapper collapse in">
                                <div class="panel-body">
                                  <div class="alert alert-warning"><p><i class="mdi mdi-alert-outline fa-fw"></i><strong> Pulse el botón para desplegar el formulario </strong> </p></div>
                                    
                                  <div class="m-t-15 collapseblebox dn">
                                        <div class="well">
                                          <div class="panel-wrapper collapse in" aria-expanded="true">
                <div class="panel-body">
                    <form  id="add_prod" action="<?php echo base_url() ?>panel_admin/insert_combo" method="post" data-toggle="validator" >
                         <input type="hidden" name="id_combo" id="id_combo" value="">
                        <input type="hidden" name="camino" id="camino" value="">
                        <div class="form-body">
                            <div class="row">
                              <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Nombre Combo:</label>
                                         <input type="text" id="nombre_combo" name="nombre_combo" class="form-control" placeholder="Escriba nombre del combo"> <span class="help-block">  </span>
                                    </div>

                                    
                                    <div class="form-group">
                                        <label class="control-label">Precio:</label>
                                        <input type="text" id="precio_combo" class="form-control" name="precio_combo" placeholder=""> <span class="help-block"> </span>
                                     </div>

                                      <div class="form-group">
                                        <label class="control-label">Existencia:</label>
                                        <input type="text" id="existencia" class="form-control" name="existencia" placeholder=""> <span class="help-block"> </span> </div>

                                </div>
       
                                <div class="col-md-6 col-xs-12 btn-file">
                                    <label for="input-file-now">Subir imagen:</label>
                                    <input type="file" id="url_imagen" name="url_imagen" class="dropify " />
                                    <input type="hidden" id="nombre_archivo" name="nombre_archivo"  value="" class="form-control">
                                </div>
                                
                            </div>

                            <!--/row-->
                            <div class="row">
                                <div class="col-md-12">
                                  <div class="form-group">
                                        <label class="control-label">Productos:</label>
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
                      <h3 class="box-title"><button type="button" id="btn-agregar" class="btn btn-info btn-rounded collapseble" > <i class="fa fa-plus"></i> Agregar Combo</button></h3>

                        <div class="panel">
                            <div class="table-responsive">
                                <table class="table table-hover manage-u-table contact-list" id="editable-datatable">
                                    <thead>
                                        <tr>
                                            <th>IMAGEN</th>
                                            <th>NOMBRE COMBO</th>
                                            <th>PRODUCTOS</th>
                                            <th>PRECIO VENTA</th>
                                            <th>EXISTENCIA</th>
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

      $('.cantidades').keypress(function(tecla) {
        if(tecla.charCode < 48 || tecla.charCode > 57) return false;
    });


        load_data_cap();
        
        $('#add_prod').submit(function(e) {
            e.preventDefault();
            var url = '<?php echo base_url() ?>panel_admin/insert_combo';
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


        $("#id_producto").on("change",function(){
         $(this).find('select :first').attr("disabled",'true');
         data = $(this).val();
         var option        = $(this).find(':selected')[0];//obtiene el producto seleccionado
         var nombre_prod   =  $('select[name="id_producto"] option:selected').text();
         $(option).attr('disabled', 'disabled'); // y lo desabilita para no volverlo a seleccionar
        
        if (data !='') {
            html = "<tr>";
            html += "<td><input type='hidden' name='productos[]' value='"+data+"'>"+nombre_prod+"</td>";


        /*     html += "<td><input type='text' name='cantidades[]' value='' class='cantidades' required data-parsley-minlength='1'data-error='Solo numeros mayores a cero'><div class='help-block with-errors'></div></td>";*/

             html += "<td><div class=form-group><input type='num' class='form-control cantidades col-xs-2' data-minlength='1' name='cantidades[]' placeholder='cantidades' data-error='escriba una cantidad mayor a cero' required><div class='help-block with-errors'></div></div></td>";





            html += "<td><button type='button' class='btn btn-danger btn-remove-producto'><span class='fa fa-remove'></span></button></td>";
            html += "</tr>";
            $("#tb-combo tbody").append(html);
           
        }else{
            alert("seleccione un producto...");
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

     $(document).on("click","#btn-agregar", function(){
        $("#add_prod")[0].reset();
        $('#camino').val("insertar");
    });

    $(document).on("click",".edit-row-btn", function(){
        var id = $(this).attr('data');
        $('#camino').val("editar");
        $(".collapseblebox").css({'display': "block" });
       
        $.ajax({
                type: 'ajax',
                method: 'get',
                url: '<?php echo base_url() ?>panel_admin/getdatos_prod',
                data: {id: id},
                async: false,
                dataType: 'json',
                success: function(data){
                   
                   $('#id_combo').val(data.id_combo);
                   $('#nombre_combo').val(data.nombre_combo);
                   $('#url_imagen_combo').val(data.url_imagen_combo);
                   $('#precio_combo').val(data.precio_combo);
                   $('#existencia').val(data.existencia);
                   

                   $('select[name=id_categoria]').val(data.id_categoria).attr('selected','selected');
                   $('#valor_declarado').val(data.valor_declarado);
                   
                   $('#nombre_archivo').val(data.url_imagen);
                   var ruta = '<?php echo base_url();?>assets/uploads/img_productos/';
                    $('#url_imagen').attr("data-default-file",ruta+data.url_imagen); 

                    if (data.es_repuesto == 1){
                                $("input[name=es_repuesto][value='1']").prop("checked",true);
                                } else {
                                    $("input[name=es_repuesto][value='2']").prop("checked",true);
                                }
                
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
            url:"<?php echo base_url(); ?>panel_admin/load_dataCombos",
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