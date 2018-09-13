 <div class="row bg-title">
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                        <h4 class="page-title">Perfil</h4> </div>
                    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                        
                        <ol class="breadcrumb">
                            <li><a href="#">Incio</a></li>
                            <li><a href="#">Perfil</a></li>
                            <li class="active">Datos Personales</li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->
                <!-- .row -->
                <div class="row">
                    <div class="col-md-4 col-xs-12">

                        <div class="white-box">
                            <div class="user-bg"> <img width="100%" alt="user" src="<?php echo base_url();?>assets/plugins/images/large/img1.jpg">
                                <div class="overlay-box">
                                    <div class="user-content">
                                        <img src="<?php echo base_url();?>assets/plugins/images/users/<?= $datos_emp->foto_emp; ?>" class="thumb-lg img-circle" alt="img">
                                        <h4 class="text-white"><?= $datos_emp->nombre_emp; ?></h4>
                                        <h5 class="text-white"><?= $datos_emp->email; ?></h5> </div>
                                </div>
                            </div>
                          
                        </div>
                    </div>
                    <div class="col-md-8 col-xs-12">
                        <div class="white-box">
                            <ul class="nav nav-tabs tabs customtab">
                                <li class="active tab">
                                    <a href="#settings" data-toggle="tab" aria-expanded="false"> <span class="visible-xs"><i class="fa fa-cog"></i></span> <span class="hidden-xs">Datos Personales</span> </a>
                                </li>
                            </ul>
                            <div class="tab-content">
                               
                                <div class=" active tab-pane" id="settings">
                                    <form class="form-horizontal form-material">
                                        <div class="form-group">
                                            <label class="col-md-12">Nombre Completo</label>
                                            <div class="col-md-12">
                                                <input type="text" value="<?= $datos_emp->nombre_emp; ?>" class="form-control form-control-line"> </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="example-email" class="col-md-12">Correo</label>
                                            <div class="col-md-12">
                                                <input type="email" value="<?= $datos_emp->email; ?>" class="form-control form-control-line" name="example-email" id="example-email"> </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label class="col-md-12">Teléfono</label>
                                            <div class="col-md-12">
                                                <input type="text" value="<?= $datos_emp->telefono_emp; ?>" class="form-control form-control-line"> </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <button class="btn btn-success">Actualizar Perfil</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.row -->