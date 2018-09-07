  <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Perfil</h3>
              </div>
            </div>
            
            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  
                  <div class="x_content">
                    <div class="col-md-3 col-sm-3 col-xs-12 profile_left">
                      <h3><?= $this->session->userdata('nombre_tienda');?></h3>
                     <ul class="list-unstyled user_data">
                     	<li>
                          <i class="fa fa-barcode "></i> No. de Cliente: <?= $this->session->userdata('no_cliente');?>
                        </li>
                        <li>
                        	<i class="fa fa-shopping-cart"> </i> Identificador de Tienda:  <?= $this->session->userdata('id_tienda');?>
                        </li>
                        <li>
                          <i class="fa fa-user"> </i> Nombre: <?= $nombre_usuario;?>
                        </li>
                        <li>
                          <i class="fa fa-barcode"> </i> DNI: <?= $dni;?>
                        </li>
                        
                        <li>
                          <i class="fa fa-at"></i> Email: <?= $mail;?>
                        </li>

                        <li class="m-top-xs">
                          <i class="fa fa-star"> </i> Plan Actual: <?= $tipo_plan;?>
                        </li>
                      </ul>
                      <br />
                      
                    </div>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <div class="x_panel">
                                <div class="x_title">
                                  <h2>Datos de usuario</h2>
                                  <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
                                
                              <form id="Perfil_form"  class="form-horizontal form-label-left" novalidate method="post">
                                  <input type="hidden" name="id_usuario" value="<?= $this->session->userdata('id_usuario');?>">
                                  <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="nombre_usuario">Nombre y Apellidos <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                      <input id="nombre_usuario" class="form-control col-md-7 col-xs-12"  
                                      name="nombre_usuario" placeholder="" required="required" type="text" data-validate-length-range="6" value="<?= $nombre_usuario;?>">
                                    </div>
                                  </div>
                                  <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="usuario">Usuario <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                      <input id="usuario" class="form-control col-md-7 col-xs-12"  
                                      name="usuario" placeholder="" required="required" type="text" data-validate-length-range="6" value="<?= $usuario;?>">
                                    </div>
                                  </div>
                                  <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="dni">DNI <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                      <input type="number" id="dni" name="dni" required="required" data-validate-length-range="8,12" class="form-control col-md-7 col-xs-12" value="<?= $dni;?>">
                                    </div>
                                </div>
                                  <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="mail">Email <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                      <input type="email" id="mail" name="mail" required="required" class="form-control col-md-7 col-xs-12" value="<?= $mail;?>">
                                    </div>
                                  </div>
                                  <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="pass">Contraseña <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                      <input type="password" id="pass" name="pass" required="required" data-validate-length-range="8,12" class="form-control col-md-7 col-xs-12" value="<?= $pass;?>">
                                    </div>
                                  </div>
                                
                               <div class="ln_solid"></div>
                                <div class="form-group">
                                  <div class="col-md-6 col-md-offset-3">
                                    <button type="reset" class="btn btn-primary">Cancelar</button>
                                    <button id="" type="submit" class="btn btn-success">Actualizar</button>
                                  </div>
                                </div>
                           </form>
                                </div>
                          </div>
                        </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /page content -->