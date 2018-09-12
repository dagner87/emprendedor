                <div class="row bg-title">
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                        <h4 class="page-title">INICIO</h4> </div>
                    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
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
                    <div class="row">
                    <div class="col-lg-3 col-sm-6 col-xs-12">
                        <div class="white-box">
                            <h3 class="box-title">Nuevos Emprendedores</h3>
                            <div class="text-right"> <span class="text-muted">Ventas</span>
                                <h1><sup><i class="ti-arrow-up text-success"></i></sup> $12,000</h1> </div> <span class="text-success">20%</span>
                            <div class="progress m-b-0">
                                <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:20%;"> <span class="sr-only">20% Complete</span> </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 col-xs-12">
                        <div class="white-box">
                            <h3 class="box-title">Weekly Sales</h3>
                            <div class="text-right"> <span class="text-muted">Weekly Income</span>
                                <h1><sup><i class="ti-arrow-down text-danger"></i></sup> $5,000</h1> </div> <span class="text-danger">30%</span>
                            <div class="progress m-b-0">
                                <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:30%;"> <span class="sr-only">230% Complete</span> </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 col-xs-12">
                        <div class="white-box">
                            <h3 class="box-title">Monthly Sales</h3>
                            <div class="text-right"> <span class="text-muted">Monthly Income</span>
                                <h1><sup><i class="ti-arrow-up text-info"></i></sup> $10,000</h1> </div> <span class="text-info">60%</span>
                            <div class="progress m-b-0">
                                <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:60%;"> <span class="sr-only">20% Complete</span> </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 col-xs-12">
                        <div class="white-box">
                            <h3 class="box-title">Yearly Sales</h3>
                            <div class="text-right"> <span class="text-muted">Yearly Income</span>
                                <h1><sup><i class="ti-arrow-up text-inverse"></i></sup> $9,000</h1> </div> <span class="text-inverse">80%</span>
                            <div class="progress m-b-0">
                                <div class="progress-bar progress-bar-inverse" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:80%;"> <span class="sr-only">230% Complete</span> </div>
                            </div>
                        </div>
                    </div>
                </div>
                </div>

                 <div class="row">
                    <div class="col-md-12">
                        <div class="panel">
                            <div class="panel-heading">ADMINISTAR EMPRENDEDORES</div>
                            <div class="table-responsive">
                                <table class="table table-hover manage-u-table" id="tabla-emp">
                                    <thead>
                                        <tr>
                                            <th class="text-center" style="width: 70px">#</th>
                                            <th>NAME</th>
                                            <th>TELEFONO</th>
                                            <th>EMAIL</th>
                                            <th>FECHA INGRESO</th>
                                            <th style="width: 250px">PERFIL</th>
                                            <!--th style="width: 300px">ACCION</th-->
                                        </tr>
                                    </thead>
                                    <tbody id="contenido">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                
            </div>
            <!-- /.container-fluid -->
<script type="text/javascript">
     $(document).on("change","select", function(){
         //var perfil = $(this).find(':selected')[0];
         var perfil = $(this).val();
        console.log(perfil);

      });
</script>            

