
    <div class="white-box">
   <!-- /.row -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="white-box printableArea">
                            <h3><b>NO COMPRA</b> <span class="pull-right"># <?= $compra->no_compra ?> </span></h3>
                            <hr>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="pull-left">
                                        <address>
                                            <h3><img src=""> &nbsp;<b class="text-info">DVIGI</b></h3>
                                            <p class="text-muted m-l-5">
                                                <br/> Av. Santa Fe 2380, Martinez + 54 11 4792-5585,
                                                <br/>Shopping Tortugas Open Mall TOM +54 11 2152-4682
                                                <br/> Shopping Alto Avellaneda.  +54 11 4265-4596</p>
                                        </address>
                                    </div>
                                    <div class="pull-right text-right">
                                        <address>
                                            <h3>To,</h3>
                                            <h4 class="font-bold"><?= $datos_emp->nombre_emp  ?></h4>
                                            <p class="text-muted m-l-30">DNI:<?= $datos_emp->dni_emp  ?>
                                                <br/> Correo:<?= $datos_emp->email  ?>
                                                <br/> Telefono:<?= $datos_emp->telefono_emp  ?>
                                            </p>
                                            <p class="m-t-30"><b>Invoice Date :</b> <i class="fa fa-calendar"></i> 23rd Jan 2016</p>
                                            <p><b>Due Date :</b> <i class="fa fa-calendar"></i> 25th Jan 2016</p>
                                        </address>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="table-responsive m-t-40" style="clear: both;">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">#</th>
                                                    <th class="text-right">PRODUCTO</th>
                                                    <th class="text-right">CANTIDAD</th>
                                                    <th class="text-right">PRECIO</th>
                                                    <th class="text-right">IMPORTE</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                               
                                               <?php 
                                                if(!empty($detalle)):
                                                 $cont=1;   
                                                foreach ($detalle as $row) :

                                                 ?>
                                            <tr>
                                                <td class="text-center"><?= $cont++?></td>
                                                <td class="text-right"><?= $row->nombre_prod ?></td>
                                                <td class="text-right"><?= $row->cantidad_comp ?></td>
                                                <td class="text-right"><?= $row->precio_comp ?></td>
                                                <td class="text-right"><?= $row->importe ?></td>
                                            </tr>
                                              <?php endforeach; ?>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="pull-right m-t-30 text-right">
                                        <p>Sub - Total amount: $13,848</p>
                                        <p>vat (10%) : $138 </p>
                                        <hr>
                                        <h3><b>Total :</b> $<?= $compra->total_comp ?></h3> </div>
                                    <div class="clearfix"></div>
                                    <hr>
                                    <div class="text-right">
                                        <button class="btn btn-danger" type="submit"> Proceed to payment </button>
                                        <button id="print" class="btn btn-default btn-outline btn-print" type="button"> <span><i class="fa fa-print"></i> Print</span> </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- .row -->
    </div>
 <script>

     $(document).on("click",".btn-print",function(){
        $("#printableArea").print({
            title:"Comprobante de Venta"
        });
    });
    /*$(document).ready(function() {
        $("#print").click(function() {
            var mode = 'iframe'; //popup
            var close = mode == "popup";
            var options = {
                mode: mode,
                popClose: close
            };
            $("div.printableArea").printArea(options);
        });
    });*/
    </script>

