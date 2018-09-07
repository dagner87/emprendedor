 <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3> Productos Generales <small> </small> </h3>
              </div>

              <div class="title_right">
                <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                  <div class="input-group">
                    <h2>Plan Actual: <a href='<?php echo site_url('panel_admin_tienda/plan_pago_tienda')?>'><small class="label label-success"><?= $tipo_plan;?> </small></a></h2> 
                  </div>
                </div>
              </div>
            </div>

            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12">
                <div class="x_panel">
                    <div class="x_content bs-example-popovers">
                      <?php
                       $Prod_disponible = $cantidad_productosPlan - $cant_prod_selecc ;
                       ?>
                        
                        <?php    
                           if ($cant_prod_selecc == $cantidad_productosPlan){?>
                        
                        <div class="alert alert-danger alert-dismissible fade in" data-spy="affix" data-offset-top="197" role="alert">
                          <strong>Ha alcanzado el máximo de productos que puede seleccionar!</strong> Por favor cambie de plan.<a href='<?php echo site_url('panel_admin_tienda/plan_pago_tienda')?>'><small class="label label-info"> Aquí </small></a>
                        </div>
                            <?php }else{ ?>
                            <div class="alert alert-info alert-dismissible fade in" data-spy="affix" data-offset-top="197" role="alert">
                              <?php if (($cantidad_productosPlan - 3) == 0) { ?>

                               <strong>Solo puede seleccionar hasta  3 productos !!</strong>
                               
                             <?php }else {?>
                              <strong>Solo puede seleccionar hasta <?= $cantidad_productosPlan - 3; ?> productos !!</strong>

                             <?php  } ?>
                             
                           </div>

                           <?php } ?>
                    </div>
                    
                  
                  <div class="x_content">

                    <div class="row">
                      <p>
                        Seleccione de  los Productos Generales los  desee sincronizar, de :<strong><?= $cantidad_prod;?></strong>
                        Disponibles :<strong style="color: red"><?= $Prod_disponible;?></strong>  
                      </p>
                    <!--Paginacion-->    
                    <div class="col-md-12">
                      <nav id="article-nav">
                        <ul class="pagination-list">
                          <?= $pagination ?>
                        </ul>
                      </nav>
                    </div>
                    <!--/Paginacion-->  

                       <?php
                             if(empty($productos)){ ?>

                                 <div class="x_content bs-example-popovers">
                                    <div class="alert alert-danger alert-dismissible fade in" role="alert">
                                      <strong>NO HAY PRODUCTOS PARA ESTA TIENDA!</strong> 
                                    </div>
                                </div>
                            
                            <?php  }else {
                                     foreach ($productos as $fila): 
                                      ?>

                                      <div class="col-md-55">
                                        <div class="thumbnail ui-ribbon-container">
                                          <div class="image view view-first">
                                            <img style="width: 100%; display: block;" src="<?= $fila->imagen;?>" alt="image" />
                                            <?php  if ($fila->stock == 0) {?>
                                             <div class="ui-ribbon-wrapper" >
                                              <div class="ui-ribbon" style="background:red" >
                                                 0 Stock
                                              </div>
                                            </div>
                                           <?php  } ?>
                                            <div class="mask">
                                              <p><?= $fila->nombre_producto;?></p>
                                              <div class="tools tools-bottom">
                                                <a title=" Ver Producto" href="<?= $fila->url;?>" target="_blank"><i class="fa fa-link"></i></a>
                                               
                                              </div>
                                            </div>
                                          </div>
                                          <div class="caption">

                                            <?php    
                                            if ($cant_prod_selecc < $cantidad_productosPlan) {?>

                                              <span class="pull-right" style="">
                                                <button class="btn btn-info btn-xs" type="button"  
                                                data-toggle="tooltip" title data-original-title="<?= 'Selecionar: '.$fila->nombre_producto;?>"
                                                onclick='seleccionar_productos(<?= $fila->id_producto ?>)'>
                                                <i class="fa fa-check-circle"></i></button>
                                              </span>
                        
                                       <?php } ?>
                                              
                                            <p><strong>Precio:</strong> <?= $fila->precio;?></p>
                                           
                                            <?php if ($fila->precio_promo >0) { ?>
                                              <p><strong>Precio de promo:</strong> <span class="btn btn-info btn-xs"><?= $fila->precio_promo;?></span></p>
                                           <?php } ?>

                                             
                                           
                                          </div>
                                        
                                        </div>
                                      </div>
                                  <?php endforeach; 
                                         }  
                                   ?> 


                      
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /page content -->