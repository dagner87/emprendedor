<style type="text/css">
  .detalle {
         width: 810px;
      }
</style>

<div class="row bg-title">
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                        <h4 class="page-title">MI CARTERA</h4> </div>
                    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                        <ol class="breadcrumb">
                            <li><a href="<?php echo base_url();?>">Inicio</a></li>
                            <li><a href="<?php echo base_url();?>">Mi Cuenta Corriente</a></li>
                            <li class="active">Mi Cartera</li>
                        </ol>
                    </div>
                    <!-- /.col-lg-12 -->
                  
                </div>



<div class="row">
  <div class="col-sm-12">
      <div class="white-box">
          <h1 class="text-left text-info m-t-10">Mi Cartera: $ <?= $datos_emp->comision_acumulada  ?> </h1>
          <div class="table-responsive">
              <table class="table color-table info-table" id="editable-datatable">
                  <thead>
                    <tr>
                      <th>FECHA</th>
                      <th>NO COMPRA</th>
                      <th>DESCUENTO</th>
                      <th>SALDO</th>
                    </tr>
                  </thead>
                  <tbody id="contenido_compras">
                     
                  </tbody>
              </table>
          </div>
      </div>
  </div>
</div>

<!-- .modal for add task -->
<div class="modal fade" id="detalleModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content detalle">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="titulo_invit">Detalle de Compra </h4>
            </div>
            <div class="modal-body" id="detalle_compra">
               
            </div>
        <!-- /.modal-content -->
        </div>
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->


  <!-- Editable -->
    <script src="<?php echo base_url();?>assets/plugins/bower_components/jquery-datatables-editable/jquery.dataTables.js"></script>
    <script src="<?php echo base_url();?>assets/plugins/bower_components/datatables/dataTables.bootstrap.js"></script>
    <script src="<?php echo base_url();?>assets/plugins/bower_components/tiny-editable/mindmup-editabletable.js"></script>
    <script src="<?php echo base_url();?>assets/plugins/bower_components/tiny-editable/numeric-input-example.js"></script>
    <script>
    
    $(document).ready(function() {
        load_data_cap();
    });//onready

    var base_url= "<?php echo base_url();?>";

     $(document).on("click",".view-detalle-compra",function(){
        var valor_id = $(this).attr('data');
        //alert(valor_id);
        $.ajax({
            url: base_url + "capacitacion/view_detalleCompra",
            type:"POST",
            dataType:"html",
            data:{id:valor_id},
            success:function(data){
                $("#detalle_compra").html(data);
            }
        });
    }); 
    


       function load_data_cap()
    {
        $.ajax({
            url:"<?php echo base_url(); ?>capacitacion/load_miCartera",
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
              
               console.log(cont.text());
            }
        })
    }
    </script>
    <!--Style Switcher -->
    <script src="<?php echo base_url();?>assets/plugins/bower_components/styleswitcher/jQuery.style.switcher.js"></script>