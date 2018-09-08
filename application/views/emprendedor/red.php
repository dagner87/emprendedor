<div class="row bg-title">
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                        <h4 class="page-title">Mi RED</h4> </div>
                    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
                        <a href="javascript: void(0);" target="_blank" class="btn btn-danger pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Buy Admin Now</a>
                        <ol class="breadcrumb">
                            <li><a href="#">Dashboard</a></li>
                            <li class="active">Starter Page</li>
                        </ol>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
 <section class="management-hierarchy">
        
        <br>
       
        <div class="hv-container">
            <div class="hv-wrapper">
               <!-- Emprendedor -->
                <div class="hv-item">
                      <!-- Promotor padre Primer nivel-->    
                    <div class="hv-item-parent">
                        <div class="person">
                            <img src="<?php echo base_url();?>assets/plugins/images/users/genu.jpg" alt="" class="">
                            <p class="name">
                                Dagner Alena <b>/ CEO</b>
                            </p>
                        </div>
                    </div>
                 
                    <!-- asociados 1 nivel-->
                    <div class="hv-item-children">
                        <?php  foreach ($asociados as $key) { ?>

                            <div class="hv-item-child">
                             <!--1 er asociado -->
                            <div class="hv-item">
                                <div class="person">
                                    <img src="<?php echo base_url();?>assets/plugins/images/users/2.jpg" alt="">
                                    <p class="name">
                                        <?= $key->nombre_asoc ;?> <b>/ <?= $key->telefono_asoc; ?></b>
                                    </p>
                                </div>
                           </div>
                            <!--/Key component -->
                        </div>
                        <?php } ?>
                       
                    </div>
                    <!--Fin 2do nivel-->
                </div>
               <!--Fin Primer nivel-->

            </div>
        </div>
        <br>
        <br>
    </section>
