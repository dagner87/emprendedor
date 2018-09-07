<!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Categorías <small>de Tiendas</small></h3>
              </div>
            </div>
            <div class="row">
                 <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class=""><h2>Lista de Categorías</h2></div>
                  <div class="x_content">
                    <p class="text-muted font-13 m-b-30"></p>
                    <table id="datatable-buttons" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th style="width: 1%">#</th>
                          <th style="">Nombre a mostrar</th>
                          <th>Nombre real </th>
                          <th style="width: 20%">#Accion</th>
                        </tr>
                      </thead>
                     <tbody id="showdataUsuarioTienda">
                        <?php
                             if(empty($categorias)){
                               }else {
                                $contador =0;
                                     foreach ($categorias as $fila): 
                               $contador ++;
                                      ?>
                        <tr>
                          <td><?= $contador;?></td>
                          <td><?= $fila->nombre_categoria;?></td>
                          <td><?= $fila->nombre_real;?></td>
                            <td>
                              <a href="javascript:;" data="<?= $fila->id_categoria; ?>" class="btn btn-primary btn-xs item-view" ><i class="fa fa-eye" ></i> Ver </a>
                              <a href="javascript:;" data="<?= $fila->id_categoria; ?>"  class="btn btn-info btn-xs item-edit" data-toggle="modal" data-target=""><i class="fa fa-pencil"></i> Editar </a>
                              <a href="javascript:;" data="<?= $fila->id_categoria; ?>" class="btn btn-danger btn-xs item-delete"  ><i class="fa fa-trash-o"></i> Eliminar </a>
                            </td>
                        </tr>
                         <?php endforeach; 
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
         

            <div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-hidden="true" id="deleteModal" >
                    <div class="modal-dialog modal-sm">
                      <div class="modal-content">

                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                          </button>
                          <h4 class="modal-title" id="myModalLabel2">Confirmar eliminación</h4>
                        </div>
                        <div class="modal-body">
                          <h4></h4>
                          <p> ¿Estas Seguro de que quieres borrar este registro...?</p>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                          <button type="button" id="btnDelete" class="btn btn-danger" value="">Eliminar</button>
                        </div>

                      </div>
                    </div>
                  </div>
                  <!-- /modals -->  

                  <!-- Editar Usuario --> 
                 <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true" id="editModal">
                    <div class="modal-dialog modal-lg">
                      <div class="modal-content">

                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                          </button>
                          <h4 class="modal-title" id="">Editar Usuario</h4>
                        </div>
                        <div class="modal-body" id="edit_data">
                          <form class="form-horizontal form-label-left" novalidate id="editarUsuarios">
                              <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="nombre_usuario">Nombre y Apellidos  <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                  <input id="nombre_usuario" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" data-validate-words="2" name="nombre_usuario" placeholder="" required="required" type="text">
                                </div>
                              </div>
                              <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="usuario">Usuario  
                                  <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                  <input id="usuario" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" data-validate-words="2" name="usuario" placeholder="" required="required" type="text">
                                </div>
                              </div>
                              <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="mail">Email <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                  <input type="email" id="mail" name="mail" required="required" class="form-control col-md-7 col-xs-12">
                                </div>
                              </div>
                              <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="pass">Contraseña  
                                  <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                  <input id="pass" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" data-validate-words="2" name="pass" placeholder="" required="required" type="text">
                                </div>
                              </div>
                              <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="id_tienda">ID Tienda  
                                  <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                  <input id="id_tienda" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" data-validate-words="2" name="id_tienda" placeholder="" required="required" type="text">
                                </div>
                              </div>
                              <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Plan</label>
                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                      <select class="select2_single form-control" tabindex="-1">
                                        <option></option>
                                        <option value="AK">FREE</option>
                                        <option value="HI">$200</option>
                                        <option value="HI">$500</option>
                                        <option value="HI">$2000</option>
                                      </select>
                                    </div>
                              </div>
                              <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="no_cliente">ID Tienda  
                                  <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                  <input id="no_cliente" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" data-validate-words="2" name="no_cliente" placeholder="" required="required" type="text">
                                </div>
                              </div>
                              </div>
                              <div class="modal-footer">
                                  <button type="button"  id="btnlimpiar" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                  <button id="send" type="submit" class="btn btn-primary">Aceptar</button>
                              </div>
                          </form>
                        </div>
                    </div>
                  </div>
                  <!-- /modals --> 

                  <!-- View detalle de usuario --> 
                 <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true" id="viewModal">
                    <div class="modal-dialog modal-lg">
                      <div class="modal-content">

                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                          </button>
                          <h4 class="modal-title" id="myModalLabel">Detalle de Usuario</h4>
                        </div>
                        <div class="modal-body" id="show_data">
                          <h4>Detalles</h4>
                          <p></p>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                          
                        </div>

                      </div>
                    </div>
                  </div>
                  <!-- // View detalle de usuario --> 