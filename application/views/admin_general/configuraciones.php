<div class="row bg-title">
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                        <h4 class="page-title">ADMINISTACION DE CONFIGURACIONES</h4> </div>
                    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                        <ol class="breadcrumb">
                            <li><a href="#">Inicio</a></li>
                            <li><a href="#">Configuración</a></li>
                            <li class="active">Adm. Parámetros</li>
                        </ol>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="white-box">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="panel">
                                        <div class="panel-heading">Lista de Parámetros</div>
                                        <div class="table-responsive">
                                         <br>
                                        <table class="table table-striped" id="editable-datatable">
                                                <thead>
                                                    <tr>
                                                      <th>PARAMETRO</th>
                                                      <th>VALOR</th>
                                                      <th>DESCRIPCION</th>
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


  <!-- Editable -->
    <script src="<?php echo base_url();?>assets/plugins/bower_components/jquery-datatables-editable/jquery.dataTables.js"></script>
    <script src="<?php echo base_url();?>assets/plugins/bower_components/datatables/dataTables.bootstrap.js"></script>
    <script src="<?php echo base_url();?>assets/plugins/bower_components/tiny-editable/mindmup-editabletable.js"></script>
    <script src="<?php echo base_url();?>assets/plugins/bower_components/tiny-editable/numeric-input-example.js"></script>
    <script>
    
    
    $(document).ready(function() {
        load_data_cap();


       

     
        
    });//onready

   
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

               table.$('input[type="text"]').on('change', this, function(){
                 var val = $(this).val();
                 var id =  $(this).attr("id").split('_');
                 var cap =  $(this).attr("id");
                 console.log(val+"-"+id[1]+"-"+cap);

                 if (val == ""){
                    $('#valor_'+id[1]).parent().addClass('has-error');
                }else{
                       $('#valor_'+id[1]).parent().parent().removeClass('has-error');
                        $.get( "<?php echo base_url();?>panel_admin/updateParametros",{ 
                               id_conf:id[1],
                               valor:val
                              })
                            .done(function(data) {
                              $('#capa_'+id[1]).html('<i class="fa fa-spinner fa-spin"></i>').fadeIn().delay(2000).fadeOut('slow');
                              });     

                     }
            
             

                }); 

               
            }
        })
    }
    </script>
    