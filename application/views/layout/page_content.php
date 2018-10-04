                <div class="row bg-title">
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                        <h4 class="page-title">INICIO</h4> </div>
                    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                        <a href="<?php echo base_url();?>capacitacion/carrito" class="btn btn-info pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light"><i class="ti-shopping-cart"></i> Carrito de Compra</a>
                        <ol class="breadcrumb">
                            <li class="active">Inicio</li>
                            
                        </ol>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
                <!-- ============================================================== -->
                <!-- Different data widgets -->
                <!-- ============================================================== -->
                <!-- .row -->
                <div class="row">
                    <div class="col-lg-3 col-sm-6 col-xs-12">
                        <div class="white-box analytics-info">
                            <h3 class="box-title">GANANCIAS TOTALES</h3>
                            <ul class="list-inline two-part">
                                <li>
                                    <div id="sparklinedash"></div>
                                </li>
                                <li class="text-right"><i class="ti-arrow-up text-success"></i> <span class="counter text-success">0</span></li>
                            </ul>
                        </div>
                    </div>
                    
                    <div class="col-lg-3 col-sm-6 col-xs-12">
                        <div class="white-box analytics-info">
                            <h3 class="box-title"> MIS COMPRAS</h3>
                            <ul class="list-inline two-part">
                                <li>
                                    <div id="sparklinedash3"></div>
                                </li>
                                <li class="text-right"><i class="ti-arrow-up text-info"></i> <span class="counter text-info"><?= $sumatoriaComp->total_comp  ?></span></li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-lg-3 col-sm-6 col-xs-12">
                        <div class="white-box analytics-info">
                            <h3 class="box-title">MI % COMISION  ACTUAL</h3>
                            <ul class="list-inline two-part">
                                <li>
                                    <div id="sparklinedash4"></div>
                                </li>
                                <li class="text-right"><i class="ti-arrow-down text-danger"></i> <span class="text-danger">1%</span></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 col-xs-12">
                        <div class="white-box analytics-info">
                            <h3 class="box-title"> MI COMISION ACUMULADA</h3>
                            <ul class="list-inline two-part">
                                <li>
                                    <div id="sparklinedash2"></div>
                                </li>
                                <li class="text-right"><i class="ti-arrow-up text-purple"></i> <span class="counter text-purple">0</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!--/.row -->
                <!--row -->
                
                <!-- /.row  col-md-12 col-lg-8 col-sm-12 col-xs-12-->
                  <div class="row">
                    <div class="col-sm-12">
                        <div class="white-box">
                           <!--div class="col-md-3 col-sm-4 col-xs-6 pull-right">
                                <select class="form-control pull-right row b-none">
                                    <option> 2017</option>
                                    <option> 2018</option>
                                </select>
                            </div-->
                            <h3 class="box-title">Reporte de asociados</h3>
                            <div class="row sales-report">
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <h2></h2>
                                    <p></p>
                                </div>
                                <div class="col-md-12 col-sm-12 col-xs-12 ">
                                   <h1 class="text-right text-info m-t-20">Total de Comisión: <strong> $<?= $total_comision ?></strong></h1>
                                </div>
                            </div> <div class="table-responsive">
                                <table id="example23" class="table color-table info-table m-t-30 table-hover contact-list" data-page-size="10"" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>Asociado</th>
                                            <th>Compras</th>
                                            <th class="text-center">Enero</th>
                                            <th class="text-center">Febrero</th>
                                            <th class="text-center">Marzo</th>
                                            <th class="text-center">Abril</th>
                                            <th class="text-center">Mayo</th>
                                            <th class="text-center">Junio</th>
                                            <th class="text-center">Julio</th>
                                            <th class="text-center">Agosto</th>
                                            <th class="text-center">Septiembre</th>
                                            <th class="text-center">Octubre</th>
                                            <th class="text-center">Noviembre</th>
                                            <th class="text-center">Diciembre</th>
                                        </tr>
                                    </thead>
                              
                                  
                                    <tbody>
                        <?php 
                            $count = 0;
                            $output = '';
                            
                            if(!empty($result))
                            {

                            $mes= 0;
                            foreach($result as $row)
                            {

                            $sumatoriaComp  = $this->modelogeneral->sumatoriaCompraEmp($row->id_emp);
                            $data['mes']    = 0;
                            $data['year']   = date('Y');
                            $data['id_emp'] = $row->id_emp;
                            $S_ConsumoMensual  = $this->modelogeneral->sumatoriaCompraEmpMensual($data);
                            $output .= '<tr >
                                    <td>
                                    <strong><img src="'.base_url().'assets/plugins/images/users/'.$row->foto_emp.'" alt="user" class="img-circle" /> '.$row->nombre_emp.'</strong>
                                    </td>
                                    <td> $ '.$sumatoriaComp->total_comp.'</td>';
                                     $data['mes'] ++;
                                     $S_ConsumoMensual  = $this->modelogeneral->sumatoriaCompraEmpMensual($data);
                                     if ($S_ConsumoMensual->total_comp == 0) {
                                        $msg ="error";
                                     }else{
                                        $msg ="success";

                                     }

                                     $output .= '<td> <div class="col-md-12" style ="padding-right: 0;
    padding-left: 0;">
                                                        <div class="form-group has-'.$msg.'">
                                                            <input type="text" id="" readonly class="form-control" value=" $'.$S_ConsumoMensual->total_comp.'"></div>
                                                        </div></td>';
                                    //*ENERO*/

                                     $data['mes']++;
                                     $S_ConsumoMensual          = $this->modelogeneral->sumatoriaCompraEmpMensual($data);
                                     $cantidad_venta['enero']    = $this->modelogeneral->cantidadVentas($data);
                                     if ($S_ConsumoMensual->total_comp == 0) {
                                        $msg ="error";
                                     }else{
                                        $msg ="success";
                                    
                                     }

                                     $output .= '<td> <div class="col-md-12" style ="padding-right: 0;
    padding-left: 0;">
                                                        <div class="form-group has-'.$msg.'">
                                                            <input type="text" id="" readonly class="form-control" value=" $'.$S_ConsumoMensual->total_comp.'"></div>
                                                        </div></td>';
                                     $data['mes'] ++;
                                     $S_ConsumoMensual  = $this->modelogeneral->sumatoriaCompraEmpMensual($data);
                                     if ($S_ConsumoMensual->total_comp == 0) {
                                        $msg ="error";
                                     }else{
                                        $msg ="success";
                                     }

                                     $output .= '<td> <div class="col-md-12" style ="padding-right: 0;
    padding-left: 0;">
                                                        <div class="form-group has-'.$msg.'">
                                                            <input type="text" id="" readonly class="form-control" value=" $'.$S_ConsumoMensual->total_comp.'"></div>
                                                        </div></td>';
                                    /*febrero*/                    
                                     $data['mes']++;
                                     $S_ConsumoMensual  = $this->modelogeneral->sumatoriaCompraEmpMensual($data);
                                    
                                     if ($S_ConsumoMensual->total_comp == 0) {
                                        $msg ="error";
                                     }else{
                                        $msg ="success";
                                     }

                                     $output .= '<td> <div class="col-md-12" style ="padding-right: 0;
    padding-left: 0;">
                                                        <div class="form-group has-'.$msg.'">
                                                            <input type="text" id="" readonly class="form-control" value=" $'.$S_ConsumoMensual->total_comp.'"></div>
                                                        </div></td>';
                                     $data['mes']++;
                                     $S_ConsumoMensual  = $this->modelogeneral->sumatoriaCompraEmpMensual($data);
                                     if ($S_ConsumoMensual->total_comp == 0) {
                                        $msg ="error";
                                     }else{
                                        $msg ="success";
                                     }

                                     $output .= '<td> <div class="col-md-12" style ="padding-right: 0;
    padding-left: 0;">
                                                        <div class="form-group has-'.$msg.'">
                                                            <input type="text" id="" readonly class="form-control" value=" $'.$S_ConsumoMensual->total_comp.'"></div>
                                                        </div></td>';
                                     $data['mes']++;
                                     $S_ConsumoMensual  = $this->modelogeneral->sumatoriaCompraEmpMensual($data);
                                     if ($S_ConsumoMensual->total_comp == 0) {
                                        $msg ="error";
                                     }else{
                                        $msg ="success";
                                     }

                                     $output .= '<td> <div class="col-md-12" style ="padding-right: 0;
    padding-left: 0;">
                                                        <div class="form-group has-'.$msg.'">
                                                            <input type="text" id="" readonly class="form-control" value=" $'.$S_ConsumoMensual->total_comp.'"></div>
                                                        </div></td>';
                                    
                                     $data['mes']++;
                                     $S_ConsumoMensual  = $this->modelogeneral->sumatoriaCompraEmpMensual($data);
                                     if ($S_ConsumoMensual->total_comp == 0) {
                                        $msg ="error";
                                     }else{
                                        $msg ="success";
                                     }

                                     $output .= '<td> <div class="col-md-12" style ="padding-right: 0;
    padding-left: 0;">
                                                        <div class="form-group has-'.$msg.'">
                                                            <input type="text" id="" readonly class="form-control" value=" $'.$S_ConsumoMensual->total_comp.'"></div>
                                                        </div></td>';
                                     $data['mes']++;
                                     $S_ConsumoMensual  = $this->modelogeneral->sumatoriaCompraEmpMensual($data);
                                     if ($S_ConsumoMensual->total_comp == 0) {
                                        $msg ="error";
                                     }else{
                                        $msg ="success";
                                     }

                                     $output .= '<td> <div class="col-md-12" style ="padding-right: 0;
    padding-left: 0;">
                                                        <div class="form-group has-'.$msg.'">
                                                            <input type="text" id="" readonly class="form-control" value=" $'.$S_ConsumoMensual->total_comp.'"></div>
                                                        </div></td>';
                                     $data['mes']++;
                                     $S_ConsumoMensual  = $this->modelogeneral->sumatoriaCompraEmpMensual($data);
                                     if ($S_ConsumoMensual->total_comp == 0) {
                                        $msg ="error";
                                     }else{
                                        $msg ="success";
                                     }

                                     $output .= '<td> <div class="col-md-12" style ="padding-right: 0;
    padding-left: 0;">
                                                        <div class="form-group has-'.$msg.'">
                                                            <input type="text" id="" readonly class="form-control" value=" $'.$S_ConsumoMensual->total_comp.'"></div>
                                                        </div></td>';
                                     $data['mes']++;
                                     $S_ConsumoMensual  = $this->modelogeneral->sumatoriaCompraEmpMensual($data);
                                     if ($S_ConsumoMensual->total_comp == 0) {
                                        $msg ="error";
                                     }else{
                                        $msg ="success";
                                     }

                                     $output .= '<td> <div class="col-md-12" style ="padding-right: 0;
    padding-left: 0;">
                                                        <div class="form-group has-'.$msg.'">
                                                            <input type="text" id="" readonly class="form-control" value=" $'.$S_ConsumoMensual->total_comp.'"></div>
                                                        </div></td>';
                                     $data['mes']++;
                                     $S_ConsumoMensual  = $this->modelogeneral->sumatoriaCompraEmpMensual($data);
                                     if ($S_ConsumoMensual->total_comp == 0) {
                                        $msg ="error";
                                     }else{
                                        $msg ="success";
                                     }

                                     $output .= '<td> <div class="col-md-12"style ="padding-right: 0;
    padding-left: 0;">
                                                        <div class="form-group has-'.$msg.'">
                                                            <input type="text" id="" readonly class="form-control" value=" $'.$S_ConsumoMensual->total_comp.'"></div>
                                                        </div></td>';
                                     $data['mes']++;
                                     $S_ConsumoMensual  = $this->modelogeneral->sumatoriaCompraEmpMensual($data);
                                     if ($S_ConsumoMensual->total_comp == 0) {
                                        $msg ="error";
                                     }else{
                                        $msg ="success";
                                     }

                                     $output .= '<td> <div class="col-md-12" style ="padding-right: 0;
    padding-left: 0;">
                                                        <div class="form-group has-'.$msg.'">
                                                            <input  type="text" id="" readonly class="form-control" value=" $'.$S_ConsumoMensual->total_comp.'"></div>
                                                        </div></td></tr>';
   
                                                   
                            }
                            

                            }
                            echo $output;
                            ?>    

                                        
    </tbody>
           <tfoot >
        <tr>
            <th>Comisión</th>
            <th>-</th>
          
            <?= $foot  ?>
            
        <tr>
            <th>Total</th>
            <th>$ <?= $total_comision ?></th>
             <?= $foot_comisiones  ?>
            
        </tr>
       
    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
               



                                                            
                
<script type="text/javascript">

    $(document).ready(function(){
     //reporte_asoc();

   
      
      });
   

     function reporte_asoc()
    {
        $.ajax({
            url:"<?php echo base_url(); ?>capacitacion/reporte_asoc",
            method:"POST",
            success:function(data)
            {
             //$('#reporte_asoc').html(data);
              $('#example23 tbody').html(data);
              $('#reporte tbody').html(data);
              var table = $('#example23').DataTable({
                 responsive: true,
                 language: {
                              "lengthMenu": "Mostrar _MENU_ registros por pagina",
                              "zeroRecords": "No se encontraron resultados en su busqueda",
                              "searchPlaceholder": "Buscar registros",
                              "info": "Mostrando  _START_ al _END_ de un total de  _TOTAL_ registros",
                              "infoEmpty": "No existen registros",
                              "infoFiltered": "(filtrado de un total de _MAX_ registros)",
                              "search": "Buscar:",
                              "paginate": {
                                            "first": "Primero",
                                            "last": "Último",
                                            "next": "Siguiente",
                                            "previous": "Anterior"
                                          },
                    }
               });
              var reporte = $('#example').DataTable({
                "columnDefs": [{
                    "visible": false,
                    "targets": 2
                }],
                "order": [
                    [2, 'asc']
                ],
                "displayLength": 25,
                "drawCallback": function(settings) {
                    var api = this.api();
                    var rows = api.rows({
                        page: 'current'
                    }).nodes();
                    var last = null;
                    api.column(2, {
                        page: 'current'
                    }).data().each(function(group, i) {
                        if (last !== group) {
                            $(rows).eq(i).before('<tr class="group"><td colspan="5">' + group + '</td></tr>');
                            last = group;
                        }
                    });
                }
            });
             
             
            }
        })
    }

</script>  
