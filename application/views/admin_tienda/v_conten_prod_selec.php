<!-- page content -->
<div class="right_col" role="main">
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3> Productos Seleccionados <small> </small> </h3>
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
               	 <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                    </button>  
                 <strong>Ha alcanzado el máximo de productos que puede seleccionar!</strong> Por favor cambie de plan.<a href='<?php echo site_url('panel_admin_tienda/plan_pago_tienda')?>'><small class="label label-info"> Aquí </small></a>
                
                </div>
                    <?php }else{ ?>
                                <div class="alert alert-info alert-dismissible fade in"  data-spy="affix" data-offset-top="197" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                               </button> 	
                                  <?php if (($cantidad_productosPlan - 3) == 0) { ?>

                                   <strong>Solo puede seleccionar hasta  3 productos !!</strong>
                                   
                                 <?php }else {?>
                                  <strong>Solo puede seleccionar hasta <?= $cantidad_productosPlan - 3; ?> productos !!</strong>

                                 <?php  } ?>
                               </div>
                            <?php } ?>
                <!--Paginacion-->
                <div class="pull-left">
                  <nav id="article-nav">
                    <ul class="pagination-list">
                      <?= $pagination ?>
                    </ul>
                  </nav>
                </div> 

                <!--/Paginacion-->             

              <div class="pull-right">
                <h2>Leyenda</h2>
                <ul class="list-inline prod_color">
                  <li>
                    <!--Completar datos-->
                      <p>Completar datos</p>
                     <div class="color bg-white" ></div>
                  </li>
                  <li>
                     <!--Pendiente-->
                    <p>Pendiente</p>
                    <div class="color bg-blue"></div>
                  </li>
                  <!--En Espera-->
                  <li>
                    <p>En Espera</p>
                    <div class="color bg-orange"></div>
                  </li>
                  <!--Aprobado-->
                  <li>
                    <p>Aprobado</p>
                    <div class="color bg-green"></div>
                  </li>
                  <!--Denegado-->
                  <li>
                    <p>Denegado</p>
                    <div class="color bg-red"></div>
                  </li>
                </ul>
              </div>
              <br>     
            </div>
          <div class="x_content">
            <div class="row">
              <p>Productos Seleccionados :<strong><?= $cant_prod_selecc;?></strong> </p>

               <?php
                     if(empty($productos_sel)){ ?>

                         <div class="x_content bs-example-popovers">
                            <div class="alert alert-danger alert-dismissible fade in" role="alert">
                              <strong>NO HAY PRODUCTOS SELECCIONADOS!!</strong> 
                            </div>
                        </div>
                    
                    <?php  }else {
                             foreach ($productos_sel as $fila): 
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
                                        <a title=" Ver Producto " href="<?= $fila->url;?>" target="_blank"><i class="fa fa-link"></i></a>
                                        <a title="Eliminar de los selecionados " onclick='deseleccionar_productos(<?= $fila->id_producto ?>)'>
                                          <i class="fa fa-times"></i></a>
                                            <?php if ($fila->seleccionado == 1 AND $fila->listo == 0) {?>
                                        <a href="javascript:;" data="<?= $fila->id_producto; ?>"  class="btn btn-success btn-xs item-adddatos" data-toggle="modal" data-toggle="tooltip" title data-original-title="Pulse para completar  datos"><i class="fa fa-check-circle"></i> </a>
                                          <?php  } ?>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="caption">
                                    <div class="pull-right">
                                          <ul class="list-inline prod_color">
                                            <li>
                                               <!--Completar datos-->
                                              <?php if ($fila->seleccionado == 1 AND $fila->listo == 0) {?>
                                              <div class="color bg-white" data-toggle="tooltip" title data-original-title="Debe completar  datos para ser sincronizados" ></div>
                                             <?php  } ?>
                                              <!--Pendiente-->
                                             <?php if ($fila->seleccionado == 1 AND $fila->cargado == 0  AND $fila->aprobado == 0 AND $fila->listo == 1 ) {?>
                                                <div class="color bg-blue" data-toggle="tooltip" title data-original-title="Pendiente de sincrozacion a Google Shooping"></div>
                                             <?php  } ?>
                                             <!--En espera-->
                                             <?php if ($fila->seleccionado == 1 AND $fila->cargado == 1  AND $fila->aprobado == 0) {?>
                                              <div class="color bg-orange"  data-toggle="tooltip" title data-original-title="En espera de respuesta Google Shooping"></div>
                                             <?php  } ?>
                                             <!--Aprobado-->
                                             <?php if ($fila->seleccionado == 1 AND $fila->cargado == 1 AND $fila->aprobado == 1) {?>
                                                 <div class="color bg-green" data-toggle="tooltip" title data-original-title="Producto Aprobado en Google Shooping"></div>
                                             <?php  } ?>
                                             <!--Denegado-->
                                             <?php if ($fila->seleccionado == 1 AND $fila->cargado == 1  AND $fila->aprobado == 2) {?>
                                              <div class="color bg-red" data-toggle="tooltip" title data-original-title=" Producto Denegado en Google Shooping"></div>
                                             <?php  } ?>
                                          
                                           </li>
                                            
                                          </ul>
                                        </div>
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
<!-- Agregar datos al producto --> 
<div class="modal fade bs-example-modal-lg affix1" tabindex="-1" role="dialog" aria-hidden="true" id="add_datosprod">
<div class="modal-dialog modal-lg">
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
<h4 class="modal-title" id="addProd">Agregar datos del producto</h4>
</div>
<div class="modal-body" id="">
<form class="form-horizontal form-label-left" novalidate  method="post" id="form_add_datosProd">
<input type="hidden" name="id_producto" id="id_producto" value="">

<div class="form-group" id="show_categorias_div" style="display: none;">
<label class="control-label col-md-3 col-sm-3 col-xs-12" for="id_categoria">  Seleccione una Categoría <span class="required">*</span>
</label>
<div class="col-md-12 col-sm-12 col-xs-12" style="" id="show_categorias">
	    <input type="text" name="id_categoria" value="">
	</div>
</div>

<div class="item form-group">
<label class="control-label col-md-3 col-sm-3 col-xs-12" for="descripton">Descripción <span class="required">*</span>
</label>
<div class="col-md-6 col-sm-6 col-xs-12">
<textarea id="descripton" required="required" name="descripton" data-validate-length-range="8,200" class="form-control col-md-7 col-xs-12"></textarea>
</div>
</div>
<div class="modal-footer">
<button type="button"  id="btnlimpiar" class="btn btn-default" data-dismiss="modal">Cerrar</button>
<button id="send_add" type="submit" class="btn btn-primary">Aceptar</button>
</div>
</form>
</div>
</div>
</div>
</div>  
<!-- /modals --> 
