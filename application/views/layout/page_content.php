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
                            <h3 class="box-title">GANACIAS TOTALES</h3>
                            <ul class="list-inline two-part">
                                <li>
                                    <div id="sparklinedash"></div>
                                </li>
                                <li class="text-right"><i class="ti-arrow-up text-success"></i> <span class="counter text-success">659</span></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 col-xs-12">
                        <div class="white-box analytics-info">
                            <h3 class="box-title">COMISION ACUMULADA</h3>
                            <ul class="list-inline two-part">
                                <li>
                                    <div id="sparklinedash2"></div>
                                </li>
                                <li class="text-right"><i class="ti-arrow-up text-purple"></i> <span class="counter text-purple">869</span></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 col-xs-12">
                        <div class="white-box analytics-info">
                            <h3 class="box-title">COMPRAS</h3>
                            <ul class="list-inline two-part">
                                <li>
                                    <div id="sparklinedash3"></div>
                                </li>
                                <li class="text-right"><i class="ti-arrow-up text-info"></i> <span class="counter text-info">911</span></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 col-xs-12">
                        <div class="white-box analytics-info">
                            <h3 class="box-title">COMISION  ACTUAL</h3>
                            <ul class="list-inline two-part">
                                <li>
                                    <div id="sparklinedash4"></div>
                                </li>
                                <li class="text-right"><i class="ti-arrow-down text-danger"></i> <span class="text-danger">1%</span></li>
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
                           <div class="col-md-3 col-sm-4 col-xs-6 pull-right">
                                <select class="form-control pull-right row b-none">
                                    <option> 2017</option>
                                    <option> 2018</option>
                                </select>
                            </div>
                            <h3 class="box-title">Reporte de asociados</h3>
                            <div class="row sales-report">
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <h2><?= date("F j, Y");?></h2>
                                    <p></p>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-6 ">
                                   <h1 class="text-right text-info m-t-20">$3,690</h1>
                                </div>
                            </div> <div class="table-responsive">
                                <table id="example23" class="display nowrap table m-t-30 table-hover contact-list" data-page-size="10"" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>Asociado</th>
                                            <th>Compras</th>
                                            <th>Enero</th>
                                            <th>Febrero</th>
                                            <th>Marzo</th>
                                            <th>Abril</th>
                                            <th>Mayo</th>
                                            <th>Junio</th>
                                            <th>Julio</th>
                                            <th>Agosto</th>
                                            <th>Septiembre</th>
                                            <th>Octubre</th>
                                            <th>Noviembre</th>
                                            <th>Diciembre</th>
                                        </tr>
                                    </thead>
                                  
                                    <tbody>
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>



                                                            
                
<script type="text/javascript">

    $(document).ready(function(){
      reporte_asoc();
   
      
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
             $('#example23').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy','excel', 'pdf', 'print'
                ]
            });
             
             
            }
        })
    }

</script>  
