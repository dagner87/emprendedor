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
              
            <?php  


            if (!empty($list_cap)):
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
                                            <div class="panel-group wiz-aco" id="accordion" role="tablist" aria-multiselectable="true">
                            <div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="headingOne">
                                    <h4 class="panel-title">
                      <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        Collapsible Group Item #1
                      </a>
                    </h4> </div>
                                <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                                    <div class="panel-body"> Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS. </div>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="headingTwo">
                                    <h4 class="panel-title">
                      <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        Collapsible Group Item #2
                      </a>
                    </h4> </div>
                                <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                                    <div class="panel-body"> Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS. </div>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="headingThree">
                                    <h4 class="panel-title">
                      <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                        Collapsible Group Item #3
                      </a>
                    </h4> </div>
                                <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                                    <div class="panel-body"> Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS. </div>
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
                 <?php endforeach; ?> 
            <?php endif ?>  
        </div>
    </div>
</div>  


<!-- form itself -->
            <div id="test-form" class="mfp-hide white-popup-block">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-info">
                                <div class="panel-wrapper collapse in" aria-expanded="true">
                                <div class="panel-body">
                                    <form action=""  id="evaluacion_form">
                                        <input type="hidden" name="id_cap" id="id_cap" value="<?= $datos_emp->id_cap  ?>">
                                        <div class="form-body">
                                            <h3 class="box-title">cuestionario</h3>
                                            <hr>
                                            <!--/row-->
                                            <div class="row">
                                                <!--/span-->
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="control-label">Seleccione las gamas de colores de purificadores dvigi:</label>
                                                        <div class="radio-list">
                                                            <label class="radio-inline p-0">
                                                                <div class="checkbox checkbox-info checkbox-circle">
                                                                    <input id="blanco" type="checkbox">
                                                                    <label for="blanco"> Blanco </label>
                                                                </div>
                                                            </label>
                                                            <label class="radio-inline p-0">
                                                                <div class="checkbox checkbox-info checkbox-circle">
                                                                    <input id="plata" type="checkbox">
                                                                    <label for="plata"> Plata </label>
                                                                </div>
                                                            </label>
                                                            <label class="radio-inline p-0">
                                                                <div class="checkbox checkbox-info checkbox-circle">
                                                                    <input id="champagne" type="checkbox">
                                                                    <label for="champagne"> Champagne </label>
                                                                </div>
                                                            </label>
                                                            <label class="radio-inline p-0">
                                                                <div class="checkbox checkbox-info checkbox-circle">
                                                                    <input id="negro" type="checkbox">
                                                                    <label for="negro"> Negro </label>
                                                                </div>
                                                            </label>
                                                            <label class="radio-inline p-0">
                                                                <div class="checkbox checkbox-info checkbox-circle">
                                                                    <input id="azul" type="checkbox">
                                                                    <label for="azul"> Azul </label>
                                                                </div>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--/span-->
                                            </div>
                                            <hr>
                                            <!--/row-->
                                             <div class="row">
                                                <!--/span-->
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="control-label">El cambio de respuesto se debe hacer cada:</label>
                                                        <div class="radio-list">
                                                            <label class="radio-inline p-0">
                                                                <div class="radio radio-info">
                                                                    <input type="radio" name="radio" id="radio1" value="option1">
                                                                    <label for="radio1">3 Meses</label>
                                                                </div>
                                                            </label>
                                                            <label class="radio-inline">
                                                                <div class="radio radio-info">
                                                                    <input type="radio" name="radio" id="radio2" value="option2">
                                                                    <label for="radio2">6 Meses </label>
                                                                </div>
                                                            </label>
                                                            <label class="radio-inline">
                                                                <div class="radio radio-info">
                                                                    <input type="radio" name="radio" id="radio2" value="option2">
                                                                    <label for="radio2">1 Año</label>
                                                                </div>
                                                            </label>
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--/span-->
                                            </div>
                                            <hr>
                                        </div>
                                        <div class="form-actions">
                                            <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Evaluar</button>
                                            <button type="button" class="btn btn-default btn_reset">Cancelar</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
               
            </div>

<script type="text/javascript">
     $(document).ready(function($) {

        $('#evaluacion_form').submit(function(e) {
        e.preventDefault();
        var  evaluacion = 10 ;
        enviar_evaluacion(evaluacion); 
        
        
      });
     
      $('.btn_reset').click(function(e){
            $('#evaluacion_form')[0].reset();
        });
      });

     function enviar_evaluacion(evaluacion){
          var url = '<?php echo base_url() ?>capacitacion/update_evalcap';
          //var data = $('#evaluacion_form').serialize();
          var id_cap = $('#id_cap').val();
          $.ajax({
                    type: 'ajax',
                    method: 'post',
                    url: url,
                    data: {id_cap:id_cap,evaluacion:evaluacion},
                    dataType: 'json',
                    beforeSend: function() {
                        //sweetalert_proceso();
                        console.log("enviando....");
                      }
                 })
                  .done(function(data){
                    console.log(data);
                    swal("Buen Trabajo!!", "Su evaluación es de"+evaluacion+"puntos" , "success")
                    // setTimeout('document.location.reload()',2000);
                  })
                  .fail(function(){
                     //sweetalertclickerror();
                  }) 
                  .always(function(){
                    /* setTimeout(function(){
                      redireccionar();
                     },2000);*/

                  });
        }        
</script>            

           






