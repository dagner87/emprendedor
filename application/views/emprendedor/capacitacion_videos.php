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
                        $cont = 0;
                        $videoact = $datos_emp->id_cap;
                     foreach ($list_cap as $key): 
                        $cont ++;
                        ?> 

                      <!--pestañas de videos-->    
                      <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingOne">
                        <h4 class="panel-title"> <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne<?= $key->id_cap ?>" aria-expanded="true" aria-controls="collapseOne" class="font-bold">  Video # <?= $cont ?> </a> </h4> </div>
                    <div id="collapseOne<?= $key->id_cap ?>" class="panel-collapse collapse <?php if($key->id_cap == $videoact){ echo "in";}?>" role="tabpanel" aria-labelledby="headingOne">
                        <div class="panel-body"> 
                            <div class="col-md-12">
                                <div class="white-box">
                                    <h3 class="box-title"><?= $key->titulo_video ?></h3>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <a class="popup-youtube btn btn-default" title="Ver Video" href="<?= $key->url_video ?>"><img src="<?php echo base_url();?>assets/videos/<?= $key->imag_portada ?>" class="img-responsive" /></a></div>
                                        <div class="col-sm-9" id="slimtest1">
                                            
                                            <?php if($key->id_cap == $videoact):  ?> 
                                                 <p><a class="popup-with-form btn btn-success btn-view-formEval" href="#test-form" data="<?= $key->id_cap ?>">Formulario de Evaluación #<?= $cont ?></a></p>
                                              <?php endif ?> 
                                            <div class="panel-group wiz-aco" id="accordion" role="tablist" aria-multiselectable="true">
                            <div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="headingOne">
                                    <h4 class="panel-title">
                      <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        Descripcion del Video <?= $cont ?> 
                      </a>
                    </h4> </div>
                                <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                                    <div class="panel-body"> <p><?= $key->descripcion ?> </p> </div>
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
                                <div class="panel-body" id="form_eval">
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
               
            </div>

<script type="text/javascript">
   
     var base_url= "<?php echo base_url();?>";

     $(document).on("click",".btn-view-formEval",function(){
        //valor_id = $(this).val();
        var valor_id = $(this).attr('data');
        //alert(valor_id);
        $.ajax({
            url: base_url + "capacitacion/view_formEval",
            type:"POST",
            dataType:"html",
            data:{id:valor_id},
            success:function(data){
                $("#form_eval").html(data);
            }
        });
    }); 

      
</script>            

           






