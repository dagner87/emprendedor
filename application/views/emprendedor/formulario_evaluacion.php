<form action=""  id="evaluacion_form">
                                        <input type="text" name="id_cap" id="id_cap" value="<?= $id_cap  ?>">
                                        <div class="form-body">
                                            <h3 class="box-title">cuestionario</h3>
                                            <hr>
                                            <!--/row-->
                                            <?php   
                                            if (!empty($preguntas)):
                                                     foreach ($preguntas as $key): 
                                                       
                                             ?>  
                                            <div class="row">
                                                <!--/span-->
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="control-label"><?= $key->pregunta ?></label>
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
                                              <?php endforeach; ?> 
                                            <?php endif ?>    
                                            <!--/row->
                                             <div class="row">
                                                <--/span->
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
                                                <--/span->
                                            </div>
                                            <hr-->
                                        </div>
                                        <div class="form-actions">
                                            <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Evaluar</button>
                                            <button type="button" class="btn btn-default btn_reset">Cancelar</button>
                                        </div>
                                    </form>

 <script type="text/javascript">
     $(document).ready(function($) {

        $('#evaluacion_form').submit(function(e) {
        e.preventDefault();
        var data = $('#evaluacion_form').serialize();
        var  evaluacion = 10 ;
        //alert(data);
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
                    swal("Buen Trabajo!!", "Su evaluación es de "+evaluacion+" puntos" , "success");
                     setTimeout('document.location.reload()',2000);
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