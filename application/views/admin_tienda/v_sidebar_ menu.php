 <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
              <h3>Menú</h3>
                <ul class="nav side-menu">
                  <li><a href='<?php echo base_url();?>'><i class="fa fa-home"></i>Inicio</a>
                  <li><a><i class="fa fa-shopping-cart"></i>Productos<span class="fa fa-chevron-down"></span></a>
                     <ul class="nav child_menu">
                      <li><a href='<?php echo site_url('panel_admin_tienda/productos_generales')?>'>Productos Generales</a></li>
                      <li><a href='<?php echo site_url('panel_admin_tienda/productos_seleccionados')?>'>Productos Seleccionados</a></li>
                     </ul>
                  </li>
                  <li><a><i class="fa fa-bar-chart-o"></i> Reportes <span class="fa fa-chevron-down"></span></a>
                    <!--ul class="nav child_menu">
                      <li><a href="chartjs.html">Chart JS</a></li>
                      <li><a href="chartjs2.html">Chart JS2</a></li>
                      <li><a href="morisjs.html">Moris JS</a></li>
                      <li><a href="echarts.html">ECharts</a></li>
                      <li><a href="other_charts.html">Other Charts</a></li>
                    </ul-->
                  </li>
                   <li><a><i class="fa fa-dollar"></i>Facturación <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href='<?php echo site_url('panel_admin_tienda/plan_pago_tienda')?>'>Comprar Plan </a></li>
                      <li><a href='<?php echo site_url('panel_admin_tienda/pagar_plan_mensual')?>'>Pagar Plan actual </a></li>
                    </ul>
                  </li>
                  <li><a href='<?php echo site_url('panel_admin_tienda/soporte_tecnico')?>'><i class="fa fa-support"></i>Contactar a Soporte</a></li>
                  <li><a href="<?php echo site_url('panel_admin_tienda/perfil')?>"><i class="fa fa-male"></i>Perfil</a></li>
                  <li><a href='<?php echo site_url('login/salir')?>'><i class="glyphicon glyphicon-log-out"></i><span> Salir</span></a></li>
                  
                </ul>
              </div>
            

            </div>
            <!-- /sidebar menu -->

            <!-- /menu footer buttons -->
            <div class="sidebar-footer hidden-small">
            </div>
            <!-- /menu footer buttons -->
          </div>
        </div>