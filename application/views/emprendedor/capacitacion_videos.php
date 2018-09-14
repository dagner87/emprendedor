<div class="row bg-title">
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                        <h4 class="page-title">CAPACITACION</h4> </div>
                    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                        <ol class="breadcrumb">
                            <li><a href="<?php echo base_url();?>">Inicio</a></li>
                            <li><a href="<?php echo base_url();?>">Capacitación</a></li>
                            <li class="active">Videos</li>
                        </ol>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- .row -->

<div class="row">
    <div class="col-md-12">
        <div class="alert alert-warning"> DEBE COMPLETAR LOS VIDEOS DE CAPACITACION PARA TENER ACCESO A LAS DEMAS PESTAÑAS DEL MENU. </div>
        <div class="panel-group" role="tablist" aria-multiselectable="true">

            <?php  if (!empty($list_cap)):
                        $cont = 1;
                        $videoact = $datos_emp->id_cap;
                     foreach ($list_cap as $key): ?> 
                      <!--pestañas de videos-->    
                      <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingOne">
                        <h4 class="panel-title"> <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne<?= $key->id_cap ?>" aria-expanded="true" aria-controls="collapseOne" class="font-bold">  Video # <?= $cont++ ?> </a> </h4> </div>
                    <div id="collapseOne<?= $key->id_cap ?>" class="panel-collapse collapse <?php if($key->id_cap == $videoact){ echo "in";}?>" role="tabpanel" aria-labelledby="headingOne">
                        <div class="panel-body"> 
                            <div class="col-md-12">
                                <div class="white-box">
                                    <h3 class="box-title"><?= $key->titulo_video ?></h3>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <a class="popup-youtube btn btn-default" title="Ver Video" href="<?= $key->url_video ?>"><img src="<?php echo base_url();?>assets/videos/<?= $key->imag_portada ?>" class="img-responsive" /></a></div>
                                        <div class="col-sm-9" id="slimtest1">
                                            <p><?= $key->descripcion ?> </p>
                                            <?php if($key->id_cap == $videoact):  ?> 
                                                 <p><a class="popup-with-form btn btn-success" href="#test-form">Formulario de Evaluación #<?= $cont++ ?></a></p>


                                           <?php endif ?> 
                                           

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                      </div>
                 <?php endforeach; ?> 
            <?php endif ?>  
        </div>
    </div>
</div>  


<!-- form itself -->
            <form id="test-form" class="mfp-hide white-popup-block">
                <h1>Form</h1>
                <fieldset style="border:0;">
                    <p>Lightbox has an option to automatically focus on the first input. It's strongly recommended to use <code>inline</code> popup type for lightboxes with form instead of <code>ajax</code> (to keep entered data if the user accidentally refreshed the page).</p>
                    <div class="form-group">
                        <label class="control-label" for="inputName">Name</label>
                        <input type="text" class="form-control" id="inputName" name="name" placeholder="Name" required=""> </div>
                    <div class="form-group">
                        <label class="control-label" for="inputEmail">Email</label>
                        <input type="email" class="form-control" id="inputEmail" name="email" placeholder="example@domain.com" required=""> </div>
                    <div class="form-group">
                        <label class="control-label" for="inputPhone">Phone</label>
                        <input type="tel" class="form-control" id="inputPhone" name="phone" placeholder="Eg. +447500000000" required=""> </div>
                    <div class="form-group">
                        <label class="control-label" for="textarea">Textarea</label>
                        <br>
                        <textarea class="form-control" id="textarea">Try to resize me to see how popup CSS-based resizing works.</textarea>
                    </div>
                </fieldset>
            </form>              


