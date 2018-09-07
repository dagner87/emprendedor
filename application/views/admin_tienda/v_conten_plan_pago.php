<!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Planes de Pago</h3>
              </div>
                   

              <div class="title_right">
                <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                  <div class="input-group">
                    <h2>Plan Actual: <a href='<?php echo site_url('panel_admin_tienda/plan_pago_tienda')?>'><small class="label label-success"><?= $tipo_plan;?> </small></a></h2> 
                  </div>
                </div>
              </div>
            </div>
             <div class="x_content bs-example-popovers">
                        <?php 
                      if ($plan_solicitado != 0) { ?>
                        
                        <div class="alert alert-warning alert-dismissible fade in" role="alert">
                          <strong>Alerta!!</strong> está pendiente de aprobación su solicitud de Plan 
                        </div>

                      <?php  } ?>
                    </div>

            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel" style="height:600px;">
                  <div class="x_title">
                    <h2>Seleccione un Plan de Pago Mensual</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>

                  <div class="x_content">
                    <div class="row">

                      <div class="col-md-12">

                        <!-- price element -->
                        <div class="col-md-3 col-sm-6 col-xs-12">
                          <div class="pricing">
                            <div class="title">
                              <h2>Plan </h2>
                              <h1>FREE</h1>
                            </div>
                            <div class="x_content">
                              <div class="">
                                <div class="pricing_features">
                                  <ul class="list-unstyled text-left">
                                    <li><i class="fa fa-times text-danger"></i> <strong>Productos </strong> Ilimitados</li>
                                    <li><i class="fa fa-times text-danger"></i> <strong>Soporte de Instalación</strong> </li>
                                    <li><i class="fa fa-check text-success"></i> Limitado a<strong> 3 productos</strong></li>
                                    <li><i class="fa fa-check text-success"></i> <strong>Sincronización de Productos  </strong> 1  vez por semana</li>
                                    <li><i class="fa fa-check text-success"></i> <strong>Soporte Técnico </strong> </li>
                                     <li><i class="fa fa-times text-danger"></i> <strong>Chat Online </strong> </li>
                                   </ul>
                                </div>
                              </div>
                              <div class="pricing_footer">
                                <a href="javascript:void(0);" disabled="disabled" class="btn btn-success btn-block" role="button">Pagar <span></span></a>
                                <p>
                                  <br>
                                </p>
                              </div>
                            </div>
                          </div>
                        </div>
                        <!-- price element -->

                        <!-- plan $200 -->
                        <div class="col-md-3 col-sm-6 col-xs-12">
                          <div class="pricing">
                            <div class="title">
                              <h2>Plan Standart</h2>
                              <h1>$200</h1>
                            </div>
                            <div class="x_content">
                              <div class="">
                                <div class="pricing_features">
                                  <ul class="list-unstyled text-left">
                                    <li><i class="fa fa-times text-danger"></i> <strong>Productos </strong> Ilimitados</li>
                                    <li><i class="fa fa-times text-danger"></i> <strong>Soporte de Instalación</strong> </li>
                                    <li><i class="fa fa-check text-success"></i> Limitado a<strong> 20 productos</strong></li>
                                    <li><i class="fa fa-check text-success"></i> <strong>Sincronización de Productos  </strong> 2  veces a la semana</li>
                                    <li><i class="fa fa-check text-success"></i> <strong>Soporte Técnico </strong> </li>
                                    <li><i class="fa fa-check text-success"></i> <strong>Chat Online </strong> </li>
                                   </ul>
                                </div>
                              </div>
                              <div class="pricing_footer">
                                  <?php
                                  if ($plan_solicitado == 0) {
                                     if($id_plan >= 2){
                                      ?>
                                        <button class="btn btn-success btn-block" type="button" id="plan2" disabled>
                                          Pagar
                                        </button>                                        
                                      <?php    
                                     }else{
                                       ?>
                                       <a onclick='solicitud_plan(2)' mp-mode="dftl" href="https://www.mercadopago.com/mla/checkout/start?pref_id=316126096-d302cfdd-f58d-4cc5-8b91-5991d4ec0ffc" name="MP-payButton" class="btn btn-success btn-block">Pagar</a> 
                                      <?php
                                     }
                                  }else{
                                        if($plan_solicitado >= 2){
                                         ?>
                                          <button class="btn btn-success btn-block" type="button" id="plan2" disabled> Pagar</button>                                        
                                        <?php
                                        }
                                       }
                                  ?>                                   
                                  <p>
                                  <br>
                                </p>
                              </div>
                            </div>
                          </div>
                        </div>
                        <!-- Plan $500 -->
                        <div class="col-md-3 col-sm-6 col-xs-12">
                          <div class="pricing ui-ribbon-container">
                            <div class="ui-ribbon-wrapper">
                              <div class="ui-ribbon">
                                + Popular
                              </div>
                            </div>
                            <div class="title">
                              <h2>Plan Premium </h2>
                              <h1>$500</h1>
                            </div>
                            <div class="x_content">
                              <div class="">
                                <div class="pricing_features">
                                  <ul class="list-unstyled text-left">
                                   <li><i class="fa fa-times text-danger"></i> <strong>Productos </strong> Ilimitados</li>
                                    <li><i class="fa fa-check text-success"></i> <strong>Soporte de Instalación</strong> </li>
                                    <li><i class="fa fa-check text-success"></i> Limitado a <strong> 100 productos</strong></li>
                                    <li><i class="fa fa-check text-success"></i> <strong>Sincronización de Productos </strong> 3  veces a la semana</li>
                                    <li><i class="fa fa-check text-success"></i> <strong>Soporte Técnico </strong> </li>
                                    <li><i class="fa fa-check text-success"></i> <strong>Chat Online </strong> </li>
                                   </ul>
                                </div>
                              </div>
                              <div class="pricing_footer">
                               
                               <?php
                                  if ($plan_solicitado == 0) {
                                     if($id_plan >= 3){
                                      ?>
                                        <button class="btn btn-primary btn-block" type="button" id="plan3" disabled>
                                          Pagar
                                        </button>                                        
                                      <?php    
                                     }else{
                                       ?>
                                        <a onclick='solicitud_plan(3)' mp-mode="dftl" href="https://www.mercadopago.com/mla/checkout/start?pref_id=316126096-feb92b85-db91-4a7b-9334-eaf39a67fc5b" name="MP-payButton" class='btn btn-primary btn-block'>Pagar</a> 
                                      <?php
                                     }
                                  }else{
                                        if($plan_solicitado >= 3){
                                         ?>
                                          <button class="btn btn-primary btn-block" type="button" id="plan3" disabled>
                                            Pagar
                                          </button>                                        
                                        <?php
                                        }else{
                                           ?>
                                            <a onclick='solicitud_plan(3)' mp-mode="dftl" href="https://www.mercadopago.com/mla/checkout/start?pref_id=316126096-feb92b85-db91-4a7b-9334-eaf39a67fc5b" name="MP-payButton" class='btn btn-primary btn-block'>Pagar</a>
                                          <?php
                                         }
                                       }
                                  ?>


                                <p>
                                  <br>
                                </p>
                              </div>
                            </div>
                          </div>
                        </div>
                       
                        <!-- plan $2000 -->
                        <div class="col-md-3 col-sm-6 col-xs-12">
                          <div class="pricing">
                            <div class="title">
                              <h2>Plan Ultimate </h2>
                              <h1>$2000</h1>
                            </div>
                            <div class="x_content">
                              <div class="">
                                <div class="pricing_features">
                                  <ul class="list-unstyled text-left">
                                    <li><i class="fa fa-check text-success"></i> <strong>Productos Ilimitados </strong></li>
                                    <li><i class="fa fa-check text-success"></i> <strong>Soporte de Instalación</strong> </li>
                                    <li><i class="fa fa-check text-success"></i> <strong>Sincronización de Productos  </strong> 3  veces a la semana</li>
                                    <li><i class="fa fa-check text-success"></i> <strong>Soporte Técnico </strong> </li>
                                    <li><i class="fa fa-check text-success"></i> <strong>Chat Online </strong> </li>
                                   </ul>
                                </div>
                              </div>
                              <div class="pricing_footer">                               
                                 <?php
                                  if ($plan_solicitado == 0) {
                                     if($id_plan >= 4){
                                      ?>
                                        <button class="btn btn-primary btn-block" type="button" id="plan4" disabled>
                                          Pagar
                                        </button>                                        
                                      <?php    
                                     }else{
                                       ?>
                                        <a onclick='solicitud_plan(4)' mp-mode="dftl" href="https://www.mercadopago.com/mla/checkout/start?pref_id=316126096-29296c45-4ef4-47ee-a355-fff54e3514c8" name="MP-payButton" class='btn btn-success btn-block'>Pagar</a> 
                                      <?php
                                     }
                                  }else{
                                        if($plan_solicitado >= 4){
                                         ?>
                                          <button class="btn btn-success btn-block" type="button" id="plan4" disabled>
                                            Pagar
                                          </button>                                        
                                        <?php
                                        }else{
                                           ?>
                                            <a onclick='solicitud_plan(4)' mp-mode="dftl" href="https://www.mercadopago.com/mla/checkout/start?pref_id=316126096-29296c45-4ef4-47ee-a355-fff54e3514c8" name="MP-payButton" class='btn btn-success btn-block'>Pagar</a>
                                          <?php
                                         }
                                       }
                                  ?>                                 
                                  <br>
                                </p>
                              </div>
                            </div>
                          </div>
                        </div>
                        <!-- price element -->
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /page content -->




