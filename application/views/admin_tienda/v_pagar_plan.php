<!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Planes  <small>pagados mensuales</small></h3>
              </div>
           </div>
           <div class="title_right">
                <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                  <div class="input-group">
                    <h2>Plan Actual: <a href='<?php echo site_url('panel_admin_tienda/plan_pago_tienda')?>'><small class="label label-success"><?= $tipo_plan;?> </small></a></h2> 
                  </div>
                </div>
              </div>
            <div class="row">
                 <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                   <h2>Listado Planes Pagados</h2>
                    <div class="col-md-2">  
                                  <?php 
                                    switch ($id_plan){
                                            case '2': ?>
                                                	 <a mp-mode="dftl" href="https://www.mercadopago.com/mla/checkout/start?pref_id=316126096-d302cfdd-f58d-4cc5-8b91-5991d4ec0ffc" name="MP-payButton" class="btn btn-success"><i class="fa fa-dollar"></i>Pagar</a>
                                          <?php
                                                 break;
                                            case '3': 
                                            ?>
                                                  <a  mp-mode="dftl" href="https://www.mercadopago.com/mla/checkout/start?pref_id=316126096-feb92b85-db91-4a7b-9334-eaf39a67fc5b" name="MP-payButton" class='btn btn-success'><i class="fa fa-dollar"></i>Pagar</a> 

                                           <?php break;
                                            case '4':
                                            ?>
                                                  <a  mp-mode="dftl" href="https://www.mercadopago.com/mla/checkout/start?pref_id=316126096-29296c45-4ef4-47ee-a355-fff54e3514c8" name="MP-payButton" class='btn btn-success'><i class="fa fa-dollar"></i>Pagar</a> 
                                              
                                               <?php  break;
                                              } 
                                              ?>
                    </div>
                   
                  <div class="x_content">
                    <p class="text-muted font-13 m-b-30"></p>
                    <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%" >
                      <thead>
                        <tr>
                          <th>Mes</th>
                          <th>Fecha Pago</th>
                          <th>Pan pagado</th>
                          <th>Fecha vencimiento</th>
                          <th>Importe</th>
                        
                        </tr>
                      </thead>
                     <tbody id="">
                        <?php
                             if(empty($historico_mensual)){
                               }else {
                                     
                                     foreach ($historico_mensual as $fila): 
                                   
                                    switch ($fila->mes){
                                            case '1':
                                                $mes ='Enero';
                                                break;
                                            case '2':
                                                $mes ='Febrero';
                                                break;
                                            case '3':
                                                $mes ='Marzo';
                                                break;
                                            case '4':
                                                $mes ='Abril';
                                                break;
                                            case '5':
                                                $mes ='Mayo';
                                                break;
                                            case '6':
                                                $mes ='Junio';
                                                break;
                                            case '7':
                                                $mes ='Julio';
                                                break;
                                            case '8':
                                                $mes ='Agosto';
                                                break;
                                            case '9':
                                                $mes ='Septiembre';
                                                break;
                                            case '10':
                                                $mes ='Octubre';
                                                break;
                                            case '11':
                                                $mes ='Noviembre';
                                                break;
                                            case '12':
                                                $mes ='Diciembre';
                                                break;                    
                                              }
                                      ?>
                        <tr>
                          <td><?= $mes;?></td>
                         <?php  $fecha_pago =  date("d/m/Y",strtotime($fila->fecha_pago)); ?>
                          <td><?= $fecha_pago; ?></td>
                          <td><?= $fila->plan;?></td>
                          <?php  $fecha_vencimiento =  date("d/m/Y",strtotime($fila->fecha_vencimiento)); ?>
                          <td><?= $fecha_vencimiento;?></td>
                          <td><?= $fila->tipo_plan;?></td>
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

<script type="text/javascript">
   function pagar_plan(id_plan)
   {
    alert(id_plan);
      /*$.get( "<?php echo base_url();?>panel_admin_tienda/GetProducto",{idprod:id_producto})
      .done(function( data ) {
        console.log(data);
        if (data) {
               new PNotify({        
                            title: 'Exito',
                            text: 'Se ha seleccionado correctamente',
                            type: 'success',
                            hide: true,
                            styling: 'bootstrap3'
                            });
          setTimeout('document.location.reload()',100);

             }else{
              new PNotify({    
                              title: 'Ha ocurrido un error',
                              text: 'No se ha podido seleccionar',
                              type: 'error',
                              hide: true,
                              styling: 'bootstrap3'
                            });
             }
        
      }); */

   }
</script>
                