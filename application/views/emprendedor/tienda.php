         
                <div class="row bg-title">
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                        <h4 class="page-title">Tienda</h4> </div>
                    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                        <a href="<?php echo base_url();?>capacitacion/carrito" class="btn btn-info pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light"><i class="ti-shopping-cart"></i> Carrito de Compra</a>
                        <ol class="breadcrumb">
                            <li><a href="#">Inicio</a></li>
                            <li><a href="#">Tienda</a></li>
                            <li class="active">Productos</li>
                        </ol>
                    </div>
                </div>


                <!-- .modal for add task -->
<div class="modal fade" id="insetcapModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="titulo_invit">Cantidad a Comprar </h4>
            </div>
            <div class="modal-body">
              <div class="alert alert-danger" id="mensaje" style="display: none;"></div>
                <form id="add_cap" action="<?php echo base_url() ?>capacitacion/add_toCar" method="post">
                   <input class="" type="hidden" name="id_prod" value="" id="id_prod">
                  <input class="" type="hidden" name="existencia" value="" id="existencia">
                  <div class="form-group">
                      <label for="cantidad" class="control-label">Cantidad</label>
                      <input type="text" class="form-control"  name="cantidad" id="cantidad" placeholder="Cantidad" 
                      data-error="Escriba numero mayor a cero" required>
                      <div class="help-block with-errors"></div>
                  </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-reset" data-dismiss="modal">Cerrar</button>
                <button type="submit" id="guardar" class="btn btn-success">Agregar</button>
            </div>
             </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

 <!-- ============================================================== -->
<!-- Blog-component -->
<!-- ============================================================== -->
                <div class="row">
             <?php  if (!empty($productos)):?> 
                          <?php foreach ($productos as $key): ?> 
                            <div class="col-md-6 col-lg-3 col-xs-12 col-sm-6"> <img class="img-responsive" alt="user" src="<?php echo base_url();?>assets/uploads/img_productos/<?= $key->url_imagen;?>">
                                <div class="white-box">
                                    <h3 class="m-t-20 m-b-20"><strong><span style=""><?=  $key->nombre_prod;?></span></strong></h3>
                                     <div class="text-muted"><a style="color:#3ec457" class="text-muted m-l-10" href="#">
                                      <i class=""></i> <?=  $key->existencia;?> disponibles</a></div>
                                    <p> <span style="color:#2ea3f2">P + IVA 21 %:<?= " $<s>".$key->costo;?></s></span>
                                      <strong><span style="color:#2ea3f2" >C + IVA 21 %:<?= " $".$key->precio;?></span></strong>
                                      <span style="color:#2ea3f2">M:<?= " $".$key->costo;?></span>

                                    </p>
                                    <div class="text-center">
                                      <button data-toggle="modal" data-target="#insetcapModal"  value="<?=  $key->id_producto."*".$key->existencia;?>" class="btn btn-outline btn-info btn-sm btn-car"><i class="ti-shopping-cart"></i> Añadir al Carrito</button>
                                      &nbsp;
                                     </div>
                                </div>
                            </div>
                    <?php endforeach; ?> 
                    <?php endif ?> 

                </div>
                <!-- ============================================================== -->
                <!-- chats, message & profile widgets -->
                <!-- ============================================================== -->
                <!-- /.row -->
                 
<script type="text/javascript">

   $(document).ready(function() {

   $('#add_cap').submit(function(e) {
            e.preventDefault();
           
                $.ajax({
                        type: 'ajax',
                        method: 'post',
                        url: '<?php echo base_url() ?>capacitacion/add_toCar',
                        data: $('#add_cap').serialize(),
                        dataType: 'json',
                        beforeSend: function() {
                            //sweetalert_proceso();
                            console.log("editando....");

                          }
                     })
                      .done(function(data){
                        console.log(data);
                      if (data.comprobador) {

                        $.toast({
                              heading: 'Producto agregado ',
                              text: 'Se agregó al carrito.',
                              position: 'top-right',
                              loaderBg: '#ff6849',
                              icon: 'success',
                              hideAfter: 3500,
                              stack: 6
                          });
                        $('#insetcapModal').modal('hide');
                         $("#add_cap")[0].reset();

                      }
                          
                         
                      })
                      .fail(function(){
                         alert("No se pudo agregar el carrito");
                           $('#insetcapModal').modal('hide');
                           $("#add_cap")[0].reset();
                      }) 
                      .always(function(){
                        
                      });
                

                                  
        });
 


   });// fin onready

$(document).on("click",".btn-reset",function(){  $("#add_cap")[0].reset(); });

$(document).on("click",".btn-car",function(){
        datos = $(this).val();
        var infoproducto = datos.split("*");
        $('#id_prod').val(infoproducto[0]); // id del producto
        $('#existencia').val(infoproducto[1]); // existencia
        var stock = $('#existencia').val();
        if (stock == 0){
           $("input[name='cantidad']").attr('disabled',true);
  
        }else{
          $("input[name='cantidad']").TouchSpin({
                min: 1,
                max:stock ,
                stepinterval: 50,
                maxboostedstep:stock,
               
            });

        }
      
        


 
});

$(document).on("change","#cantidad",function(){
    var stock = $('#existencia').val();
    var valor = $(this).val();
    if(valor <= 0 || valor > stock){
      $("#guardar").attr("disabled",true);
      $('#mensaje').html("El valor debe ser inferior o igual a "+stock).show().fadeIn().delay(5000).fadeOut('slow');

     
    } else {
            $("#guardar").removeAttr("disabled");

          }


  });



</script>