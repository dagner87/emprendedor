<!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Configuar  <small>Plan de Pagos</small></h3>
              </div>

              <div class="title_right">
                <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                  <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search for...">
                    <span class="input-group-btn">
                      <button class="btn btn-default" type="button">Go!</button>
                    </span>
                  </div>
                </div>
              </div>
            </div>
            
            <div class="clearfix"></div>
            <div class="row">
                 <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                   <h2>Lista de Planes</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                        <ul class="dropdown-menu" role="menu">
                          <li><a href="#">Settings 1</a>
                          </li>
                          <li><a href="#">Settings 2</a>
                          </li>
                        </ul>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <p class="text-muted font-13 m-b-30">
                         Listado de usuarios inscritos en el sistema
                    </p>

                    <table id="datatable-buttons" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                         
                          <th style="width: 20%">Plan</th>
                          <th>Cantidad de productos</th>
                          <th>Descripción</th>
                          <th>Tiempo de Crom</th>
                          <th style="width: 20%">#Acción</th>
                        </tr>
                      </thead>


                     <tbody>
                        <?php
                             if(empty($result_planes)){
                             
                            
                               }else {
                                     
                                      foreach ($result_planes as $fila): 
                                      ?>
                                      <tr>
                                          <td><?= $fila->tipo_plan;?></td>
                                          <td><?= $fila->cantidad_productos;?></td>
                                          <td><?= $fila->descripcion;?></td>
                                          <td><?= $fila->tiempo_crom; ?></td>
                                          <td>
                                              <a href="#" data="<?= $fila->id_plan?>"  class="btn btn-primary btn-xs plan-view" data-toggle="tooltip"><i class="fa fa-folder"></i> Ver </a>
                                              <a href="#" data="<?= $fila->id_plan?>" data-toggle="tooltip" title="Editar" class="btn btn-info btn-xs plan-edit"><i class="fa fa-pencil"></i> Editar </a>
                                              <a href="#" data="<?= $fila->id_plan?>" data-toggle="tooltip" title="Eliminar" class="btn btn-danger btn-xs plan-del"><i class="fa fa-trash-o"></i> Eliminar </a>
                                          </td>
                                      </tr>
                         <?php 
                                 endforeach; 
                             }  
                          ?> 
                        
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /page content -->