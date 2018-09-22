<script type="text/javascript" charset="utf-8">

	
	$(document).ready(function () {
		var dtProductos = [];		
		var dtCantidades = [];
		var dtProductos_nombre = [];

		$('#clientsTable').dataTable({          
			stateSave: true
		} );
		$('#fecha_nacimiento').datepicker({
			autoclose: true, 
			format: 'yyyy-mm-dd 00:00:00'
		});
		$('#fecha_compra').datepicker({
			autoclose: true, 
			format: 'yyyy-mm-dd 00:00:00'
		});
		var xMunicipio=0;
		var xProvincia=0;
		cargarProvincias();

		function cargarProvincias() {
			var id_pais = $('#sel_paises').val();

			$.ajax({
				type: "POST",
				url: "<?php echo base_url();?>provincias_pais/" + id_pais,
				data: id_pais,
				success: function (html) {
					$('#sel_provincias').html(html);
					if(xProvincia != 0){
						$('#sel_provincias').val(xProvincia);
					}
					cargarMunicipios();
				}
			});
		};
		$('#sel_paises').change(function () {

			cargarProvincias(); // si cambia la prvincia se cargan de todos los municipios de dicha provincia
		});
		$('#sel_provincias').change(function () {
			cargarMunicipios(); // si cambia la prvincia se cargan de todos los municipios de dicha provincia
		});
		$('#sel_municipios').change(function () {
			cargarMunicipio();
			cargarCp();
		});
		// Cargar municipios de la provincia seleccionada
		function cargarMunicipios() {
			var id_provincia = $('#sel_provincias').val();
			$.ajax({
				type: "POST",
				url: "<?php echo base_url();?>municipios_provincia/" + id_provincia,
				data: id_provincia,
				success: function (html) {
					$('#sel_municipios').html(html);
					if(xMunicipio != 0){
						$('#sel_municipios').val(xMunicipio);
					}
					
					cargarProvincia();
					cargarMunicipio();
				}
			});
		};
		$('#addProd').click(function () {			
			obtenerProducto();
			
		});
		function obtenerProducto() {
			var id_producto = $('#sel_productos').val();

			$.ajax({
				"url": "<?php echo base_url();?>obtener_producto/" + id_producto,
				"type": "get",
				"dataType": "json",
				"success": function (data) {
					adicionarDetalle(data);					
				}
			});

		};
		var tDetalles = $('#tablaDetalles').DataTable({
			"columnDefs": [
				{
					"targets": [0],
					"visible": false,
					"searchable": true
				}
			],
			stateSave: true
		});
		$('#tablaDetalles tbody').on('click', 'img.icon-delete', function () {
			var idx = $(this).parents('tr');
			var i = idx[0]._DT_RowIndex;
			
			dtProductos.splice(i, 1);
			dtProductos_nombre.splice(i, 1);
			dtCantidades.splice(i, 1);

			tDetalles
				.row($(this).parents('tr'))
				.remove()
				.draw();
			$('#res_dtproducto').val(dtProductos);
			$('#res_dtcantidad').val(dtCantidades);


			$('#cantidad').focus();
		});
		function adicionarDetalle(producto) {
			var col = tDetalles.column(0).data();
			var idx = col.indexOf(producto.id_producto,1);
			if (idx == -1) {
				var cant = $('#cantidad').val();
				
				if (cant > 0) {
					
					tDetalles.row.add(
					[
						producto.id_producto,
						producto.nombre,					
						$('#cantidad').val(),					
						"<tr><a href='#'><img class='icon-delete' src='<?php echo base_url(); ?>assets/img/remove.png'/></a></tr>"
					]
					).draw();

					var dt = {
						"id_producto": producto.id_producto,
						"cantidad": $('#cantidad').val()
					};
						
					dtProductos.push(producto.id_producto);						
					dtProductos_nombre.push(producto.nombre);						
					dtCantidades.push($('#cantidad').val());
					$('#res_dtproducto').val(dtProductos);
					$('#res_dtcantidad').val(dtCantidades);
				}
				$('#cantidad').focus();
			}
			
		};
		
		function cargarProvincia() {
			var id_provincia = $('#sel_provincias').val();

			$.ajax({
				type: "POST",
				url: "<?php echo base_url();?>obtener_provincia/" + id_provincia,
				data: id_provincia,
				success: function (html) {
					$('#provincia').val(html);
					cargarMunicipio();
				}
			});
		};
		tDetalles
				.row($(this).parents('tr'))
				.remove()
				.draw();
		function cargarMunicipio() {

			var id_municipio = $('#sel_municipios').val();

			$.ajax({
				type: "POST",
				url: "<?php echo base_url();?>obtener_municipio/" + id_municipio,
				data: id_municipio,
				success: function (html) {
					$('#municipio').val(html);
					
				}
			});

		};
		$('#vista_excell').hide();
		$('#vista_cliente').hide();
		$('#btManual').click(function () {
			$('#vista_excell').hide();		
			$('#vista_cliente').show();		
		});
		$('#btExcell').click(function () {
			$('#vista_excell').show();		
			$('#vista_cliente').hide();		
		});
	});
</script>
 

    <div class="row bg-title">
	    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
	        <h4 class="page-title">Consultas y Altas de Clientes</h4> </div>
	    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
	        <ol class="breadcrumb">
	            <li><a href="#">Inicio</a></li>
	            <li class="active">Clientes</li>
	        </ol>
	    </div>
	    <!-- /.col-lg-12 -->
    </div>


<div class="row">
    <div class="col-md-12">
        <div class="white-box">
            <h3 class="box-title">Clientes Registrados: <?php echo $total_clientes; ?> </h3></div>
	
	<form action="<?php echo base_url().'registrar_cliente_rev'; ?>" method="post">
		<?php if($notificacion != "vacio"){ ?>
		<div class="alert alert-danger">
			<?php echo $notificacion; ?>
			
		</div>
		<?php }?>
	<div class="panel panel-info">		
		<div class="panel-heading">
			<h3 class="panel-title">Alta cliente:</h3>
		</div>
		<div class="panel-body">
			<div class="row" >
				<div class="col-xs-12">
                    <p>
					  <button id="btManual" type="button" class="btn btn-facebook waves-effect waves-light">Alta Manual</button>
					  <button id="btExcell" type="button" class="btn btn-facebook waves-effect waves-light">Importar Excel</button>						
					</p> 					
				</div>
			</div>
			<div id="vista_cliente" >						
				<!-- LOCALIZACION-->
				<div class="panel panel-info">
					<div class="panel-heading">
						<h3 class="panel-title">LOCALIZACIÓN</h3>
					</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-lg-4">
								<div class="form-group has-feedback">
									<div class="etiquetas_controles">País:</div>
									<div class="form-group">
										<select class="form-control" name="sel_paises" id="sel_paises">
											<?php foreach ($paises->result() as $pa): ?>
												<option value="<?php echo $pa->id; ?>" <?php if($id_pais == $pa->id) echo "selected"; ?>>
													<?php echo $pa->nombre; ?>
												</option>
											<?php endforeach; ?>
										</select>
										
									</div>
								</div>
							</div>					
							<div class="col-lg-4">		
								<!-- Provincia -->
								<div class="etiquetas_controles">Provincia:</div>
								<div class="form-group">
									<select class="form-control" name="sel_provincias" id="sel_provincias">
										
									</select>
									<input type="hidden" class="form-control" id="provincia">
								</div>	
							</div>
							<div class="col-lg-4">		
								<!-- Municipio -->
								<div class="etiquetas_controles">Comuna:</div>
								<div class="form-group">
									<select required class="form-control" name="sel_municipios" id="sel_municipios">
									</select>
									<input type="hidden" class="form-control" id="municipio">
								</div>
							</div>
						</div>	
					</div>
				</div>
				<!-- FIN LOCALIZACION-->



				<!-- CREDENCIALES-->
				<div class="panel panel-info">
					<div class="panel-heading">
						<h3 class="panel-title">CREDENCIALES</h3>
					</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-lg-4">		
								<!-- Identificación única -->
								<div class="etiquetas_controles">Nro. Identidad:</div>
								<div class="form-group">
									<input type="text" class="form-control" id="dni" name="dni">
								</div>	
								<!-- Teléfono -->
								<div class="etiquetas_controles">Teléfono:</div>
								<div class="form-group">
									<input type="tel" class="form-control" name="telefono" id="telefono">
								</div>
										
								<!-- Dirección -->
								<div class="etiquetas_controles">Dirección:</div>
								<div class="form-group">
									<input type="text" class="form-control" id="calle" name="calle">
								</div>
								
							</div>
							<div class="col-lg-4">		
								<!-- Nombres -->
								<div class="etiquetas_controles">Nombre:</div>
								<div class="form-group">
									<input type="text" required autofocus class="form-control" id="nombre" name="nombre">
								</div>
								<!-- Email -->
								<div class="etiquetas_controles">Email:</div>
								<div class="form-group">
									<input type="email" placeholder="me@example.com" required class="form-control" id="email" name="email">
								</div>
																		
								<div class="form-group">
									<label>Fecha nacimiento:</label>

									<div class="input-group date">
									<div class="input-group-addon">
										<i class="fa fa-calendar"></i>
									</div>
										<input type="text" class="form-control pull-right" value="<?php echo date('Y-m-d H:i:s'); ?>" name="fecha_nacimiento" id="fecha_nacimiento">
									</div>
									<!-- /.input group -->
								</div>
				 
								
							</div>
							<div class="col-lg-4">		
								<!-- Apellidos -->
								<div class="etiquetas_controles">Apellidos:</div>
								<div class="form-group">
									<input type="text" required class="form-control" id="apellidos" name="apellidos">
								</div>
								<div class="etiquetas_controles">Celular:</div>
								<div class="form-group">
									<input type="int" class="form-control" required id="celular" name="celular">			
								</div>
								<div class="form-group">
									<input type="hidden" class="form-control" id="observaciones" name="observaciones">
								</div>
								
							</div>
						</div>
						
						
						<h3>Productos comprados por el cliente</h3>
						<div class="row">
							<div class="col-lg-3">
							    <div class="form-group">
									<label>Fecha compra:</label>

									<div class="input-group date">
									<div class="input-group-addon">
										<i class="fa fa-calendar"></i>
									</div>
										<input type="text" class="form-control pull-right" value="<?php echo date('Y-m-d H:i:s'); ?>" name="fecha_compra" id="fecha_compra">
									</div>
									<!-- /.input group -->
						        </div>
							</div>
						</div>							
						<div class="form-group">
							<input type="hidden" class="form-control" id="res_dtcantidad" name="res_dtcantidad">
							<input type="hidden" class="form-control" id="res_dtproducto" name="res_dtproducto">
							<div class="table-responsive">
								<table style="font-size: small;" width="100%" class="table table-striped table-bordered table-hover" id="productosTable">
									<thead>
										<tr>
											<th>Producto</th>
											<th>Cantidad</th>
											<th></th>
										</tr>
									</thead>
									<tbody id="productosTable1">
										<tr>
											
											<th>												
												<!--div class="form-group">
													<select class="form-control" name="sel_productos" id="sel_productos">
														<?php foreach ($productos->result() as $pro): ?>
															<option value="<?php echo $pro->id_producto; ?>">
																<?php echo $pro->nombre; ?>
															</option>
														<?php endforeach; ?>
													</select>
										
												</div-->
												<div class="form-group">
													<select class="form-control" name="sel_productos" id="sel_productos">
														<?php foreach ($productos_list as $pro): ?>
															<option value="<?php echo $pro->id_producto; ?>">
																<?php echo $pro->nombre; ?>
															</option>
														<?php endforeach; ?>
													</select>
										
												</div>
											</th>

											<th>
												<input type="text" class="form-control" id="cantidad" name="cantidad">
											</th>
											<td>
												<a href="#" id="addProd"><img src="<?php echo base_url(); ?>assets/plugins/images/add.png" width="32" height="32" alt=""/></a>
											</td>
										</tr>
									</tbody>
								</table>
							</div>

						</div>
						<div class="form-group">
							<div class="table-responsive">
								<table style="font-size: small;" width="100%" class="table table-striped table-bordered table-hover" id="tablaDetalles">
									<thead>
										<tr>
											<th>id_producto</th>
											<th>Producto</th>
											<th>Cantidad</th>
											<th></th>
										</tr>
									</thead>
									<tbody></tbody>
								</table>
							</div>

						</div>
					</div>
				</div>
					<!-- Botones del asistente -->
					<div class="box-footer clearfix">
					<button type="submit" class="pull-right btn btn-info" id="sendForm">Registrar</button>
					</div>
					<div>&nbsp;</div>
					<!-- FIN CREDENCIALES-->
			</div>
			<div class="row" id="vista_excell">
				<div class="col-xs-12">
					<p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
					   <a href="<?php echo base_url();?>assets/uploads/clientes_rev.xlsx"  class="fcbtn btn btn-outline btn-primary btn-1f"><i class="fa fa-download"></i> Descargar plantilla excel</a>
					   <a href="<?php echo base_url();?>subir_excell_rev"  class="fcbtn btn btn-outline btn-success btn-1f"><i class="fa  fa-file-excel-o"></i> Importar clientes</a>	
					</p>					          
				</div>				
			</div>
		</div>		
	</div>
	</form>
	<form action="<?php echo base_url().'clientes_consultor_rev_filtrados'; ?>" method="post">
	<div class="panel panel-info">
		
		<div class="panel-heading">
			<h3 class="panel-title">Buscar cliente:</h3>
		</div>
		<div class="panel-body">
			<div class="row">
				<div class="col-lg-1">
					<div class="etiquetas_controles"> Nombre:</div>
				</div>
				<div class="col-lg-2">	
					<div class="form-group">	
						<input type="text" class="form-control" name="fil_nombre" id="fil_nombre">										
					</div>
				</div>
				<div class="col-lg-1">
					<div class="etiquetas_controles"> Apellidos:</div>
				</div>
				<div class="col-lg-2">	
					<div class="form-group">	
						<input type="text" class="form-control" name="fil_apellidos" id="fil_apellidos">
					</div>
				</div>
				<div class="col-lg-1">
					<div class="etiquetas_controles"> Nro. Identidad:</div>
				</div>
				<div class="col-lg-2">	
					<div class="form-group">	
						<input type="text" class="form-control" name="fil_dni" id="fil_dni">										
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-1">
					<div class="etiquetas_controles"> EMAIL:</div>
				</div>
				<div class="col-lg-2">	
					<div class="form-group">	
						<input type="text" class="form-control" name="fil_email" id="fil_email">										
					</div>
				</div>
				
				<div class="col-lg-1">
					<div class="etiquetas_controles"> Teléfono:</div>
				</div>
				<div class="col-lg-2">	
					<div class="form-group">	
						<input type="text" class="form-control" name="fil_telefono" id="fil_telefono">										
					</div>
				</div>
				<div class="col-lg-1">
					<div class="etiquetas_controles"> Celular:</div>
				</div>
				<div class="col-lg-2">	
					<div class="form-group">	
						<input type="text" class="form-control" name="fil_celular" id="fil_celular">										
					</div>
				</div>
				<div class="col-lg-1">				
					
					<button type="submit" class="pull-right btn btn-info" id="sendForm">Buscar</button>
				</div>
			</div>
		</div>		
	</div>
	
	</form>
	
    <br>	
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-info">
				<div class="panel-heading">
					Cartera de clientes
				</div>
				<!-- /.panel-heading -->
				<div class="panel-body">
				<div class="table-responsive">
					<table style="font-size: small;" width="100%" class="table table-striped table-bordered table-hover" id="clientsTable">
						<thead>
							<tr>
								<th>Nro. Identidad</th>
								<th>Cliente</th>								
								<th>Teléfono</th>
								<th>Celular</th>
								<th>Email</th>
								<th>Historial</th>								
							</tr>
						</thead>
						<tbody>
							<?php foreach ($clientes->result() as $cl): ?>
								<?php if ($cl->en_mision == true): ?>
									<tr style="color:#333333;" class="fila_verde">
								<?php else: ?>
									<?php if ($cl->en_operacion == true): ?>
										<tr style="color:#333333;" class="fila_amarilla">
									<?php else: ?>
										<?php if ($cl->reg_cancelado == true): ?>
											<tr style="color:#333333;" class="fila_roja">
										<?php else: ?>
											<tr>
										<?php endif; ?>
									<?php endif; ?>
								<?php endif; ?>
										<td>
											<?php echo $cl->dni; ?>
										</td>
										<td>
											<?php echo $cl->nombre.' '.$cl->apellidos; ?>
										</td>
										<td>
											<?php echo $cl->telefono; ?>
										</td>
										<td>
											<?php echo $cl->celular; ?>
										</td>
										<td>
											<?php echo $cl->email; ?>
										</td>
										<td>
											<a href="<?php echo base_url();?>cartera_historial1_rev/<?php echo $cl->id_cliente; ?>"><i class="fa fa-history"></i></a>
										</td>
										
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
					<!-- /.table-responsive -->

				</div>
				<!-- /.panel-body -->
			</div>
			<!-- /.panel -->
		</div>
		<!-- /.col-lg-12 -->
	

    </div>
</div>
<!-- Main content -->
