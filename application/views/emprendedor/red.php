<div class="row bg-title">
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                        <h4 class="page-title">Mi RED</h4> </div>
                    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                        <ol class="breadcrumb">
                            <li><a href="#">Inicio</a></li>
                            <li class="active">Mi Red</li>
                        </ol>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>


 <div class="row">
  <div class="col-sm-12">
      <div class="white-box">
<<<<<<< HEAD
          <h3 class="box-title">MI red</h3>
=======
          <h3 class="box-title">Mis Patrocinados</h3>
>>>>>>> 9f2d7f1513c0855d5515d7b035f9d882e9e78949
          <div class="table-responsive management-hierarchy contact-list">
         <br>
        <div class="hv-container">
            <div class="hv-wrapper">
               <!-- Emprendedor -->
                <div class="hv-item">

                      <!-- Promotor padre Primer nivel-->    
                    <div class="hv-item-parent">
                        <div class="person">
                            <img src="<?php echo base_url();?>assets/plugins/images/users/<?= $datos_emp->foto_emp ?>" alt="" class="">
                            <p class="name">

                                <?= $this->session->userdata('nombre') ; ?>
                            </p>
                        </div>
                    </div>
                        <?php 
                       if (!empty($asociados)):?>
                          <!-- asociados 1 nivel-->
                    <div class="hv-item-children">

                        <?php foreach ($asociados as $key) { ?>
                            <div class="hv-item-child">
                             <!--1 er asociado -->
                            <div class="hv-item">
                                <div class="person">
                                    <img src="<?php echo base_url();?>assets/plugins/images/users/<?= $key->foto_emp ?>" alt="">
                                    <p class="name ">
                                        <?= $key->nombre_emp ;?> <b> <span class=" fa fa-circle text-success m-r-10"></span></b>

                                        

                                    </p>
                                </div>
                           </div>
                            <!--/Key component -->
                        </div>
                        <?php }  ?>   
                     </div>
                 <?php endif ?>   
                 
                </div>
               <!--Fin Primer nivel-->

            </div>
        </div>
        <br>
        <br>

              
          </div>
      </div>
  </div>
</div>               

 
