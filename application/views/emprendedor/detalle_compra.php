
<div class="row">
    <div class="col-md-12 col-lg-12 col-sm-12">
        <div class="white-box">
            <div class="row sales-report">
                <div class="col-md-6 col-sm-6 col-xs-6">
                </div>
                <div class="col-md-6 col-sm-6 col-xs-6 ">
                    <h1 class="text-right text-info m-t-20">Total: $ <?= $total->importe ?></h1> </div>
            </div>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>PRODUCTO</th>
                            <th>CANTIDAD</th>
                            <th>PRECIO</th>
                            <th>IMPORTE</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            if(!empty($result)):
                             $cont=1;   
                            foreach ($result as $row) :

                             ?>
                        <tr>
                            <td> <?= $cont++?></td>
                            <td class="txt-oflo"><?= $row->nombre_prod ?></td>
                            <td class="txt-oflo"><?= $row->cantidad_comp ?></td>
                            <td><span class="text-right"><?= $row->precio_comp ?></span> </td>
                            <td><span class="text-right"><?= $row->importe ?></span></td>
                        </tr>
                          <?php endforeach; ?>
                            <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>                    