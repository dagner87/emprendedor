         
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
                <!-- /.row -->
                 <div class="row">
                    <!-- .col -->
                    <div class="col-sm-12">
                        <div class="white-box">
                            <h3 class="box-title m-b-0">Productos</h3>
                            <?php  if (!empty($productos)):?> 
                           
                             <div id="image-popups" class="row">                                
                               <!--producto-->  
                                <?php foreach ($productos as $key): ?> 
                                <div class="col-sm-4">
                                    <br>
                                    <a href="<?php echo base_url();?>assets/plugins/images/big/<?= $key->url_imagen;?>" data-effect="mfp-zoom-in"><img src="<?php echo base_url();?>assets/uploads/img_productos/<?= $key->url_imagen;?>" class="img-responsive" />
                                    <br/><?=  $key->nombre_prod;?></a><br/>
                                    &nbsp; <?= " $".$key->precio_unitario;?>
                                    <br/>

                                     <div class="col-md-4 col-md-offset-4">
                                     <div class="form-group item-prod">
                                            <input class="vertical-spin" type="text" data-bts-button-down-class="btn btn-default btn-outline" data-bts-button-up-class="btn btn-default btn-outline" value="" id="cantidad<?=  $key->id_producto;?>"> </div>
                                   <div class="pull-left">
                                    <button value="<?=  $key->id_producto;?>" class="btn btn-outline btn-info btn-sm btn-car"><i class="ti-shopping-cart"></i> Añadir al Carrito</button>
                                    &nbsp;
                                   </div>
                               </div>
                                     <br/>
                                </div>
                               <!--/producto--> 
                              <?php endforeach; ?> 
                               </div> 

                            <?php endif ?>  
                           
                        </div>
                    </div>
                    <!-- .col -->
                </div>
                <!-- .row -->
                <!-- /.row -->
                <!-- ============================================================== -->
                <!-- Right sidebar -->
                <!-- ============================================================== -->
                <!-- .right-sidebar -->
 