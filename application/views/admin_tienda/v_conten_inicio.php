  <?php 
       
       
       $Prod_disponible = $cantidad_productosPlan - $cant_prod_selecc ; 

       if (empty($en_espera)){

        $porce_aprob  = 0;
        $porce_error  = 0;
       }else {
              $porce_aprob  = round(($aprobado / $en_espera )* 100,2);
              $porce_error  = round(($denegado / $en_espera )* 100,2);
             }
       
	   if($cant_prod_selecc > 0){
		   $porce_selecc = round(($cant_prod_selecc / $cantidad_prod )* 100,2);
		   $porce_sincro = round(($en_espera / $cant_prod_selecc )* 100,2);
	  
     }else{
	        $porce_selecc = 0;
			    $porce_sincro = 0;
	        }
       
       ?>

<!-- page content -->
        <div class="right_col" role="main">
          <!-- top tiles -->
          <div class="row tile_count">
             <!-- Plan -->
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-dollar"></i> Plan Actual</span>
              <div class="count green"><?= $tipo_plan ;?></div>
              <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i><?php if($tipo_plan == "FREE"){echo "3";}else{ echo $cantidad_productosPlan - 3;} ?> </i> Productos a seleccionar</span>
            </div>
             <!-- Total de Productos de la tienda -->
             <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-shopping-cart"></i> Total de Productos Importados</span>
              <div class="count"><?= $cantidad_prod; ?></div>
              <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>100% </i> </span>
            </div>
             <!-- Total de Productos Seleccionado -->
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-shopping-cart"></i> Productos Seleccionados</span>
              <div class="count"><?= $cant_prod_selecc; ?></div>
              <span class="count_bottom"><i class="green"><?= $porce_selecc.'%'; ?> </i> Del total </span>
            </div>
             <!-- Total de Productos Sincronizados -->
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-clock-o"></i> Total Productos Sincronizados</span>
              <div class="count green"><?= $en_espera; ?></div>
              <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i><?= $porce_sincro.'%'; ?></i> De los seleccionados</span>
            </div>
             <!-- Total de Productos con error -->
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-shopping-cart"></i> Total Productos con Error</span>
              <div class="count red"><?= $denegado; ?></div>
              <span class="count_bottom"><i class="red"><i class="fa fa-sort-desc"></i><?= $porce_error.'%'; ?> </i> De los sincronizados</span>
            </div>
             <!-- Total de Productos Aprobados -->
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-shopping-cart"></i> Total Productos Aprobados</span>
              <div class="count"><?= $aprobado; ?></div>
              <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i><?= $porce_aprob.'%'; ?></i> De los sincronizados</span>
            </div>
          </div>
          <!-- /top tiles -->

          <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="dashboard_graph">
                <div class="x_content bs-example-popovers">
                        <?php 
                      if ($plan_solicitado != 0) { ?>
                        
                        <div class="alert alert-warning alert-dismissible fade in" role="alert">
                          <strong>Alerta!!</strong> está pendiente de aprobación su solicitud de Plan 
                        </div>

                      <?php  } 

                      if ($cant_prod_selecc == $cantidad_productosPlan){?>
                       
                        <div class="alert alert-danger alert-dismissible fade in" role="alert">
                          <strong>Ha alcanzado el máximo de de productos que puede seleccionar!</strong> Por favor cambie de plan.<a href='<?php echo site_url('panel_admin_tienda/plan_pago_tienda')?>'><small class="label label-info"> Aquí </small></a>
                        </div>
                            <?php } ?>

                    </div>

                <div class="row x_title">
                  <div class="col-md-6">
                    <h3>Panel de control <small></small></h3>
                  </div>
                  <!--div class="col-md-6">
                    <div id="reportrange" class="pull-right" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc">
                      <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                      <span>December 30, 2014 - January 28, 2015</span> <b class="caret"></b>
                    </div>
                  </div-->
                </div>
                <div class="clearfix"></div>
              </div>
            </div>

          </div>
          <br />
          <div class="row">
              <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="x_panel">
                  <div class="x_content">
                    <canvas id="mybarChart"></canvas>
                  </div>
                </div>
              </div>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="x_panel">
                  <div>
                    <h2>Estado de productos</h2>
                  </div>
                  <div class="x_content">
                    <canvas id="canvasDoughnut"></canvas>
                  </div>
                </div>
              </div>
          </div>
        </div>
        <!-- /page content -->