
    <div class="white-box">
        <div class="row">

            <div class="col-md-10 col-md-offset-2">
                  <h3><b>CARRITO</b> <span class="pull-right">
                    <button type="button" class="btn btn-block btn-outline btn-primary my_wallet"
                   id="btn-micartera" data="<?= $datos_emp->comision_acumulada?>" <?php if($datos_emp->comision_acumulada == 0) echo "disabled" ?> ><i class="mdi mdi-wallet fa-fw"></i> Mi Cartera: $
                   <?= $datos_emp->comision_acumulada  ?></button></span></h3>
                   

             

                <div class="table-responsive" style="clear: both;">
                    <br>
                    <?php if (validation_errors()): ?>
                   <div class="alert alert-danger">
                      <?php echo validation_errors(); ?>
                   </div>
                <?php endif; ?>
                    <table class="table color-table info-table m-t-30 table-hover contact-list"
                     id="carrito" data-page-size="10">
                        <thead>
                            <tr>
                                <th class="text-center">&nbsp;</th>
                                <th class="text-center">&nbsp;</th>
                                <th>Producto</th>
                                <th class="text-right">Precio</th>
                                <th class="text-center">Cantidad</th>
                                <th  colspan=2 class="text-right">Total</th>
                            </tr>
                        </thead>
                        <tbody >
                     <form action="<?php echo base_url() ?>capacitacion/validar_carrito" id="" method="post">       
                        <?php 
                            if(!empty($result)){
                            foreach ($result as $row) : ?>
                              <tr>
                                 <td class="text-center"> <input type="hidden" name="idproductos[]" value="<?= $row->id_producto ?>"></td>
                                <td class="text-center">
                                 <a class= "btn-remove-producto" data-toggle="tooltip" data="<?= $row->id_car ?>" data-original-title="Close"> <i class="fa fa-close text-danger"></i> </a></td>
                                <td>
                                <img src=" <?php echo base_url();?>assets/uploads/img_productos/<?= $row->url_imagen ?>" alt="user" class="img-circle" /><?= $row->nombre_prod ?></td>
                                <td class="text-center"> <?= $row->precio_car ?><input type='hidden' name='precios[]' value='<?= $row->precio_car ?>'></td>
                                <td class="text-right">
                                    <div class="row">
                                    <div class="form-group">
                                            <div class="col-sm-6 col-md-offset-3">
                                              <input type="text" name="cantidades[]" class="form-control input-sm" 
                                                value="<?= $row->cantidad ?>">
                                            </div>
                                        </div>
                                    </div>    
                                </td>
                                <td class="text-right"> <input type='hidden' name='importes[]' value='<?= $row->importe ?>'><p><?= $row->importe ?></p></td>
                            </tr>

                           <?php endforeach; ?>
                            <?php }else{ ?>
                             <tr>
                                <div class="alert alert-warning"> NO HAY PRODUCTOS EN EL CARRITO</div>
                            <?php } ?> 
                            </tr>
                            
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="col-md-8 col-md-offset-4">
                <div class="pull-right m-t-30 text-right">
                    <h3><p> Subtotal: <span id="subtotal"></span></p></h3>
                   <h3><p id="mis_comisiones" style="display: none;"> Mi Cartera: 
                     <span id="descuento"></span></p></h3>
                 
                     <!--div class="col-md-2 col-md-offset-10">

                    <input type="hidden"  name="micartera" id="micartera" value="0.00" class=" form-control" data-bts-button-down-class="btn btn-default btn-outline" data-bts-button-up-class="btn btn-default btn-outline"></div-->
                    <h3><b>Total a Pagar :</b><span id="total_pagar"></span> </h3> </div>
                   <input type="hidden" name="total" id="total" value=""> 
                   <input type="hidden" name="sub_total" id="sub_total" value="">
                   <input type="hidden" name="micartera" id="micartera" value=""> 
                <div class="clearfix"></div>
                <hr>
                <div class="text-right">
                    <a href="<?php echo base_url();?>capacitacion/tienda" class="btn btn-default btn-outline" type="button"> <span><i class="ti-shopping-cart-full"></i> Seguir Comprando</span> </a>
                    <button class="btn btn-outline btn-info" type="submit"> Finalizar Compra </button>
                </div>
            </div>
           </form>
        </div>
    </div>

    <script type="text/javascript">

        $(document).ready(function(){
            //carrito();
            sumar_pro();
            var comision = $(this).attr('data');
          /*  $("input[name='micartera']").TouchSpin({
                min: 0,
                max: comision,
                stepinterval: 50,
                maxboostedstep: comision,
               
            });*/
            
        });

    $(document).on("click",".my_wallet", function(){
              var comision = $(this).attr('data');
              saldo_com = 0;
              sub_total = $('#sub_total').val();

              if (sub_total < comision){
                 comision = sub_total;
                $("input[name='micartera']").attr('readonly','true');
                
            }else{

             /* $("input[name='micartera']").TouchSpin({
                min: 0,
                max: comision,
                stepinterval: 50,
                maxboostedstep: comision,
               
            });*/
            }

             $('#micartera').val(comision);
             $('#btn-micartera').html('<i class="mdi mdi-wallet fa-fw"></i> Mi Cartera: $ '+saldo_com);
             $('#mis_comisiones').show();
             console.log("aqui");
             
           sumar_pro();
          });

     $(document).on("change","#micartera", function(){ 
         descuento = $('#micartera').val();
        console.log(descuento);
        sumar_pro();


     });
 
    $(document).on("keyup","#carrito input", function(){

        cantidad = $(this).val();
        precio = $(this).closest("tr").find("td:eq(3)").text();
        id = $(this).closest("tr").find("td:eq(1)").children("a").attr('data');
        console.log(id);
        importe = cantidad * precio;
        $(this).closest("tr").find("td:eq(5)").children("p").text(importe.toFixed(2));
        $(this).closest("tr").find("td:eq(5)").children("input").val(importe.toFixed(2));
        $.ajax({
                type: 'ajax',
                method: 'get',
                url: '<?php echo base_url() ?>capacitacion/update_prodCar',
                data: {id_car: id,cantidad: cantidad,importe: importe},
                async: false,
                dataType: 'json',
                success: function(data){
                  
                },
                error: function(){
                  alert('No se pudo actualizar');
                }
        });
        sumar_pro();
    });  

    $(document).on("click",".btn-remove-producto", function(){
        $(this).closest("tr").remove();
        var id = $(this).attr('data');
        $.ajax({
                type: 'ajax',
                method: 'get',
                url: '<?php echo base_url() ?>capacitacion/eliminar_prodCar',
                data: {id_car: id},
                async: false,
                dataType: 'json',
                success: function(data){
                  $.toast({
                        heading: 'Producto eliminado ',
                        text: 'El producto a sido eliminado del carrito.',
                        position: 'top-right',
                        loaderBg: '#ff6849',
                        icon: 'error',
                        hideAfter: 3500

                    });
                },
                error: function(){
                  alert('No se pudo eliminar');
                }
        });
        sumar_pro();
    });
   

    function carrito()
    {
        $.ajax({
            url:"<?php echo base_url(); ?>capacitacion/carrito_compra",
            method:"POST",
            success:function(data)
            {
             $('#prod_car').html(data);
            }
        })
    }

    //
   
    function sumar_pro(){
        total = 0;
       descuento = $('#micartera').val();
        console.log(descuento);

        $("#carrito tbody tr").each(function(){
            total = total + Number($(this).find("td:eq(5)").text());
           
            total_pagar = total - descuento;
        });

                 $("#subtotal").text(" "+total.toFixed(2));
                 $("#descuento").text(" "+ descuento);
                 $("#total_pagar").text(" "+total_pagar.toFixed(2));
                 $("#total").val(total_pagar.toFixed(2));
               var sub_total =  $("#sub_total").val(total.toFixed(2));
    
        
   } 

    </script>

