 <!-- Content Header (Page header) -->
<section class="content-header">
	<h1>Historial de Clientes</h1>
	<ol class="breadcrumb">
	<li><a href="<?php echo base_url();?>"><i class="fa fa-dashboard"></i> Inicio</a></li>
	<li class="active">Historial de cliente</li>
	</ol>
</section>

<!-- Main content -->
<section class="invoice">
<?php 
	if($notificacion != '')
	{
		?>
		<div class="row">
			<div class="alert alert-warning alert-dismissible">
				<?php echo $notificacion; ?>
			</div>			
		</div>
		<?php 
	}
	?>
	<!-- title row -->
	<div class="row">
		<div class="col-xs-12">
			<h2 class="page-header">
				<i class="fa fa-user"></i> Ficha cliente.
				<small class="pull-right"><strong>Hoy: </strong> <?php echo date("d/m/Y"); ?></small>
			</h2>
		</div>
		<!-- /.col -->
	</div>
	<div class="row">
		<div class="col-lg-4 pull-left">
			<!-- About Me Box -->
			<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title"><strong><?php echo $cliente[0]->nombre; ?> <?php echo $cliente[0]->apellidos; ?></strong></h3>
				
			</div>
			<div class="box-body">
				<strong><?php echo 'DNI: '.$cliente[0]->dni; ?> </strong><br>
				<?php if ($cliente[0]->vip==1): 
					switch ($cliente[0]->nivel) {
						case 5:
							?>
							<div class="callout callout-warning">
								<h4>Cliente VIP Nivel 5!!</h4>
								<p>No paga Producto, No paga Repuesto, No paga envío.</p>
							</div>
							<?php															
							break;
						case 4:
							?>
							<div class="callout callout-warning">
								<h4>Cliente VIP Nivel 4!!</h4>
								<p>No paga Producto, No paga Repuesto, Paga Envío.</p>
							</div>
							<?php
							break;
						case 3:
							?>
							<div class="callout callout-warning">
								<h4>Cliente VIP Nivel 3!!</h4>
								<p>No paga Producto, Paga Repuesto y Paga Envío.</p>
							</div>
							<?php
							break;
						case 2:
						?>
						<div class="callout callout-warning">
							<h4>Cliente VIP Nivel 2!!</h4>
							<p>Descuento en producto, Paga Repuesto y Paga Envío.</p>
						</div>
						<?php
						break;
					}
					?>						
				<?php else: ?>
					<div class="callout callout-info">
							<h4>Cliente Normal</h4>
							<p>No tiene descuentos extras.</p>
						</div>
				<?php endif; ?>
			</div>
			<!-- /.box-header -->
			<div class="box-body">
				<strong><i class="fa fa-map-marker margin-r-5"></i><u> Dirección</u></strong>

				<p class="text-muted"><?php echo $cliente[0]->calle.' '.$cliente[0]->nro.' Dpto: '.$cliente[0]->dpto.' Piso: '.$cliente[0]->piso; ?><br>
				<?php echo 'Entre: '.$cliente[0]->entrecalle1.' y '.$cliente[0]->entrecalle2; ?>
				<br>
				<?php echo 'Localidad: '.$cliente[0]->municipio.'  '.$cliente[0]->provincia.' CP: '.$cliente[0]->codigo_postal; ?></p>
				<hr>

				<strong><u>Contacto</u></strong>

				<p>
				<strong><i class="fa fa-phone-square margin-r-5"></i> Teléfono Fijo: </strong> <?php echo $cliente[0]->telefono; ?><br>
				<strong><i class="fa fa-tablet margin-r-5"></i> Celular: </strong> <?php echo $cliente[0]->celular; ?><br>
				<strong><i class="fa fa-envelope margin-r-5"></i> Email: </strong> <?php echo $cliente[0]->email; ?><br>					                
				</p>
			</div>
				<!-- /.box-body -->
		</div>
				<!-- /.box -->
	</div> 
	<div class="col-lg-8 pull-right">
		<div class="box box-widget widget-user-2 box-default collapsed-box box-solid">
			<div class="box-header with-border">
				<div class="user-block">
					<label class="control-label">Editar datos del cliente:</label>						
				</div>						 
				<div class="box-tools">
					<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
					</button>						
				</div>					  
			</div>
					
			<div class="box-footer no-padding">
				<div class="row">
					<div class="col-lg-12"><!-- Columna 1 -->
						<!-- Panel primario Datos del cliente-->
						<div class="panel panel-primary">
							<div class="panel-heading">
								<h3 class="panel-title">Datos del cliente</h3>
							</div>
							<form action="<?php echo base_url().'modificar_cliente_cartera'; ?>" method="post">
							<div class="panel-body">
								<div class="row">
									<div class="col-lg-4"><!-- Columna 1 -->
										<!-- Cliente -->
										<div class="etiquetas_controles">CLIENTE:</div>
										<div class="form-group">
											<input type="hidden" class="form-control" name="id_cliente" id="id_cliente" value="<?php echo $cliente[0]->id_cliente; ?>">
											<input type="text" class="form-control" name="cliente" value="<?php echo $cliente[0]->nombre; ?>" >														
											<input type="hidden" class="form-control" name="id_municipio" id="id_municipio" value="<?php echo $cliente[0]->id_municipio; ?>">													
										</div>
									</div>
									<div class="col-lg-4"><!-- Columna 1 -->
										<!-- Cliente -->
										<div class="etiquetas_controles">APELLIDOS:</div>
										<div class="form-group">
											<input type="hidden" class="form-control" name="id_cliente" value="<?php echo $cliente[0]->id_cliente; ?>">
											<input type="text" class="form-control" name="apellidos" value="<?php echo $cliente[0]->apellidos; ?>" >
										</div>
									</div>	
									<div class="col-lg-4"><!-- Columna 1 -->
									<!-- Cliente -->
									<div class=" etiquetas_controles ">Email:</div>
									<div class="form-group ">												
											<input type="text" class="form-control" name="email" value="<?php echo $cliente[0]->email; ?>" >								
									</div>
								</div>												
							</div>
							<div class="row">									
								<div class="col-lg-4"><!-- Columna 1-->
									<!-- Venta -->
									<div class=" etiquetas_controles ">DNI:</div>
									<div class="form-group ">
										<input type="text " class="form-control " name="dni" value="<?php echo $cliente[0]->dni; ?>" >			

									</div>
									<div class=" etiquetas_controles ">Calle:</div>
									<div class="form-group ">													
											<input type="text" class="form-control" name="calle" value="<?php echo $cliente[0]->calle; ?>">	
									</div>
									<div class=" etiquetas_controles ">Departamento:</div>
									<div class="form-group ">
											<input type="text" class="form-control" name="dpto" value="<?php echo $cliente[0]->dpto; ?>">
									</div>
									<!-- Provincia -->
									<div class="etiquetas_controles">Provincia:</div>
									<div class="form-group">
										<select class="form-control" name="sel_provincias" id="sel_provincias">
											<?php foreach ($provincias->result() as $prov): ?>
												<option value="<?php echo $prov->id_provincia; ?>" <?php if ($prov->id_provincia == $cliente[0]->id_provincia) echo "selected"; ?>>
													<?php echo $prov->nombre; ?>
												</option>
											<?php endforeach; ?>
										</select>
										<input type="hidden" class="form-control" id="provincia">
									</div>
									<div class="form-group">										
										<?php $group = array('Consultores'); if ($this->ion_auth->in_group($group)): ?> 
										<!-- Solicitud de baja de cliente por el consultor -->
											<label class="checkbox-inline">
												<?php if ($solicitud_baja==1): ?>
													<input type="checkbox" name="solicitud_baja"  id="solicitud_baja" checked>Solicitud de baja
												<?php else: ?>
													<input type="checkbox" name="solicitud_baja" id="solicitud_baja"  >Solicitud de baja
												<?php endif; ?>	
											</label>
											<div  id="ver_otras_causas">	
												<div class="form-group" >
													<div class="radio">
														<label>
														<input type="radio"  name="opcion_baja" id="optionsRadiosInlinei" value="1" <?php  if ($fallecido==1):?> checked="checked"
															<?php  else:?> 
															<?php endif; ?>/>Fallecimiento
														</label>
													</div>
													<div class="radio">
														<label>
															<input type="radio" name="opcion_baja" id="optionsRadiosInlineii" value="2"<?php  if ($fallecido==0):?> checked="checked"
															<?php  else:?> 
															<?php endif; ?>/>Otras causas
														</label>
													</div>

												</div>
												<div class="form-group" >
													&nbsp;&nbsp;					
													<div class="etiquetas_controles">Explicación de la solicitud:</div>
													<div class="form-group">											
															<input type="text" class="form-control" id="observaciones" name="observaciones" value="<?php echo $observaciones; ?>">
													</div>	
												</div>	
											</div>	
										<?php endif; ?>
									</div>
								</div>
								<div class="col-lg-4"> <!-- Columna 2 -->											
								<div class=" etiquetas_controles ">Teléfono:</div>
								<div class="form-group ">													
										<input type="text" class="form-control" name="telefono" value="<?php echo $cliente[0]->telefono; ?>" >
								</div>											
								<div class=" etiquetas_controles ">Piso:</div>
								<div class="form-group ">													
										<input type="text" class="form-control" name="piso" value="<?php echo $cliente[0]->piso; ?>">
								</div>
								<div class=" etiquetas_controles ">Entre calles:</div>
								<div class="form-group ">													
										<input type="text" class="form-control" name="entrecalle1" value="<?php echo $cliente[0]->entrecalle1; ?>" >
								</div>															
								<!-- Municipio -->
								<div class="etiquetas_controles">Municipio:</div>
								<div class="form-group">
									<select class="form-control" name="sel_municipios" id="sel_municipios">
									
									</select>
									<input type="hidden" class="form-control" id="municipio">
								</div>
								<div class="etiquetas_controles">Cliente VIP:</div>
								<div class="form-group"> 
									<div class="col-lg-10">
										<label class="checkbox-inline">
											
												<?php if ($cliente[0]->vip==1): ?>
													<input type="checkbox" name="vip"  checked>Es VIP
												<?php else: ?>
													<input type="checkbox" name="vip" >Es VIP
												<?php endif; ?>
																							
										</label>
										<div class="etiquetas_controles">Nivel VIP:</div>
										<div class="form-group">
											<select class="form-control" name="nivel" id="nivel">
												<option value="<?php echo 0; ?>" >
													<?php echo '0- Sin nivel'; ?>
												</option>
												<?php foreach ($niveles->result() as $niv): ?>
													<option value="<?php echo $niv->id; ?>" <?php if ( $niv->id == $cliente[0]->nivel) echo "selected"; ?>>
														<?php echo $niv->id.'- '.$niv->observaciones; ?>
													</option>
												<?php endforeach; ?>
											</select>
										</div>
									</div>
								</div>
								</div>
								<div class="col-lg-4"> <!-- Columna 3 -->
									
									<div class=" etiquetas_controles ">Número:</div>
									<div class="form-group ">												
											<input type="text" class="form-control" name="nro" value="<?php echo $cliente[0]->nro; ?>" >
									</div>
									<div class=" etiquetas_controles ">Y:</div>
									<div class="form-group ">												
											<input type="text" class="form-control" name="entrecalle2" value="<?php echo $cliente[0]->entrecalle2; ?>">
									</div>
									<div class=" etiquetas_controles ">Celular:</div>
									<div class="form-group ">												
											<input type="text" class="form-control" name="celular" value="<?php echo $cliente[0]->celular; ?>" >													
									</div>
									<div class=" etiquetas_controles ">Código postal:</div>
									<div class="form-group ">												
											<input type="text" class="form-control" name="codigo_postal" value="<?php echo $cliente[0]->codigo_postal; ?>" >													
									</div>
									<div class="etiquetas_controles">CUIT:</div>
									<div class="form-group">													
											<input type="text" class="form-control" id="cuit" name="cuit" value="<?php echo $cliente[0]->cuit; ?>">													
									</div>
									<div class="etiquetas_controles">Observaciones:</div>
									<div class="form-group">
										
											<input type="text" class="form-control" id="observaciones1" name="observaciones1" value="<?php echo $cliente[0]->observaciones; ?>">
										
									</div>
								</div>										
							</div>
							<div class="box-footer clearfix">
								<button type="submit" class="pull-right btn btn-default" id="sendForm">Modificar</button>											
							</div>
						</div>
						</form>
						</div>
					</div>										
				</div>  
			</div>
		</div>				
	</div>

</div> 
<div class="row">
	<div class="col-lg-3">
		<?php if($estado == 'cerrado'): ?>
			<button id='registro_oca'  onClick="$('#id_cliente_equivcado').val(<?php echo $cliente[0]->id_cliente; ?>)" type='button' class='no_cargado btn btn-info' data-toggle='modal' data-target='#myModal_equivocado'>Datos de contacto equivocado </button>
		<?php endif;?>
	</div>
</div>
<!-- Table row -->
<div class="row">	        
<div class="col-xs-12 table-responsive">			
	<div class="box">	
	<div class="box-header">
		<h3 class="box-title"><strong>Historial de Compras</strong></h3>
	</div> 
	<div class="box-body">			
		<table id="compras" class="table table-striped">
			<thead>
				<tr>
					<!-- <th>Entrega</th> -->
					<th>No_operación</th>
					<th>Pedidos</th>				  
					<th>Importe</th>
					<th>Vendido por</th>
					<th>Fecha compra</th>
					<th>Garantía</th>
					<!-- <th>Reposición</th> -->
					<th>Canal</th>						
					<th>Cod. seguimiento</th>	
					<th>Mail enviado</th>					
				</tr>
			</thead>
			<tbody>
				<?php foreach ($compras->result() as $cl): ?>
					<tr>						
						<!-- <td><?php echo $cl->entrega; ?></td> -->
						<td><?php echo $cl->no_factura; ?></td>
						<td><?php echo $cl->producto; ?></td>							
						<td><?php echo $cl->importe; ?></td>
						<td><?php echo $cl->usuario; ?></td>
						<td><?php echo $cl->fecha_compra; ?></td>
						<td><?php if($cl->es_repuesto) echo '--'; else echo $cl->fecha_vencimiento; ?></td>
						<!-- <td><?php if($cl->reposicion == 'Si') echo '<span class="label label-success">Si</span>'; else echo '<span class="label label-danger">No</span>'; ?></td> -->
						<td><span class="label label-info"><?php echo $cl->canal; ?></span></td>	
						<td><?php 
						foreach ($cod_seguimiento->result() as $key) {
							# code...
							if($key->id_pedido == $cl->id_pedido){?>
								<a href="<?php echo base_url().'seguimiento_oca/'.$cl->no_factura.'/'.$key->numero_envio; ?>"><?php echo $key->numero_envio; ?></a>
							<?php }
						} 
						?></td>
						<td><?php if($cl->mail==1) echo 'SI'; else echo 'NO'; ?></td>							
					</tr>
				<?php endforeach; ?>					
			</tbody>
		</table>
				
		</div>   
		</div>  
	</div>
	<!-- /.col -->
	</div>
	<!-- /.row -->

      
	<div class="row">
        <div class="col-xs-12 table-responsive">
          <div class="box">	
		    <div class="box-header">
              <h3 class="box-title"><strong>Histórico de seguimientos</strong></h3>
            </div> 
            <div class="box-body">				
			  <table id="ventas" class="table table-striped">
				<thead>
				<tr>
				  <th>Fecha</th>
				  <th>Usuario que llamó</th>
				  <th>Notas</th>				  
				</tr>
				</thead>
				<tbody>
					<?php foreach ($seguimientos->result() as $cl): ?>
						<tr>						
							<td><?php echo $cl->fecha; ?></td>							
							<td><?php echo $cl->usuario; ?></td>							
							<td><?php echo $cl->nota; ?></td>							
						</tr>
					<?php endforeach; ?>				
				</tbody>
			  </table>
			</div>  
		  </div> 
        </div>
        <!-- /.col -->
	</div>
      <!-- /.row -->
	<div class="row">
        <div class="col-xs-8 table-responsive">
          <div class="box">	
		    <div class="box-header">
              <h3 class="box-title"><strong>Notas del cliente</strong></h3>
            </div> 
            <div class="box-body">				
			  <table id="ventas" class="table table-striped">
				<thead>
				<tr>
				  <th>Fecha</th>
				  <th>Usuario</th>
				  <th>Notas</th>				  
				</tr>
				</thead>
				<tbody>
					<?php foreach ($reclamos->result() as $re): ?>
						<tr>						
							<td><?php echo $re->fecha; ?></td>							
							<td><?php echo $re->usuario; ?></td>							
							<td><?php echo $re->observaciones; ?></td>							
						</tr>
					<?php endforeach; ?>				
				</tbody>
			  </table>
			</div>  
		  </div> 
        </div>
		<div class="col-lg-4 pull-right">
			<div class="box box-widget widget-user-2 box-default collapsed-box box-solid">
				<div class="box-header with-border">
					<div class="user-block">
						<label class="control-label">Agregar notas del cliente:</label>						
					</div>						 
					<div class="box-tools">
						<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
						</button>						
					</div>					  
				</div>
				
				<div class="box-footer no-padding">
					<div class="row">
						<div class="col-lg-12"><!-- Columna 1 -->
							<!-- Panel primario Datos del cliente-->
							<div class="panel panel-primary">
								<div class="panel-heading">
									<h3 class="panel-title">Notas del cliente</h3>
								</div>
								<form action="<?php echo base_url().'registrar_notas_clientes'; ?>" method="post">
								<div class="panel-body">
									
									<div class="row">
								
										<div class="col-lg-12"><!-- Columna 1
											<div class="etiquetas_controles">Causa:</div>
											<div class="form-group">
												<select class="form-control" name="sel_causas" id="sel_causas">
													<?php foreach ($causa_reclamos->result() as $cau): ?>
														<option value="<?php echo $cau->id; ?>" >
															<?php echo $cau->nombre; ?>
														</option>
													<?php endforeach; ?>
												</select>													
											</div>-->
											
											<!-- Venta -->
											<div class=" etiquetas_controles ">Notas:</div>
											<div class="form-group ">
												<input type="text" class="form-control " name="notas" value="" >			
												<input type="hidden" class="form-control " name="id_cliente1" value="<?php echo $cliente[0]->id_cliente; ?>" >			
							
											</div>
											
											
											
										</div>
									</div>
									<div class="box-footer clearfix">
										<button type="submit" class="pull-right btn btn-default" id="sendForm">Registrar</button>											
									</div>
								</div>
								</form>
							</div>
						</div>										
					</div>  
				</div>
			</div>					
		</div>
        <!-- /.col -->
	</div>
      <!-- /.row -->
	<div class="row">
		<div class="col-lg-3">
			<?php if($estado == 'cerrado'): ?>
				<button id='registro_oca'  onClick="$('#id_cliente_llamame').val(<?php echo $cliente[0]->id_cliente; ?>)" type='button' class='no_cargado btn btn-info' data-toggle='modal' data-target='#myModal_llamame'>Llamame más adelante </button>
			<?php endif;?>
		</div>
		<div class="col-lg-3">
			<?php if($estado == 'cerrado'): ?>
				<button id='registro_oca'  onClick="$('#id_cliente_inactivo').val(<?php echo $cliente[0]->id_cliente; ?>)" type='button' class='no_cargado btn btn-info' data-toggle='modal' data-target='#myModal_inactivo'><?php if( $cliente[0]->inactivo==1) echo 'Activar al '; else echo 'Desactivar al ' ?> cliente</button>
			<?php endif;?>
		</div>
		
		<div class="col-lg-3">
		<?php if($estado == 'cerrado'): ?>
			<button id='registro_oca'  onClick="$('#id_cliente_reclamo').val(<?php echo $cliente[0]->id_cliente; ?>)" type='button' class='no_cargado btn btn-danger' data-toggle='modal' data-target='#myModal'>Añadir reclamo del cliente </button>
		<?php endif;?>	
		</div>
		<div class="col-lg-3">
			<form action="<?php echo base_url().'cartera_adicionar_producto/'.$cliente[0]->id_cliente ; ?>" method="post">
				<button type="submit" class="pull-right btn btn-primary" id="sendForm">Añadir producto al cliente</button>&nbsp;&nbsp;
			</form>						
		</div>
	</div>
	<br>
	<br>
	<div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="modal-dialog modal-sm" style="width: 600px;">
				<div class="modal-content">

					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
						</button>
						<h4 class="modal-title" id="myModalLabel2">Reclamos del cliente</h4>
					</div>
					<div class="modal-body">
						<div class="box-body">
						
						
						<div class="panel panel-danger">
							<div class="panel-heading">
								<h3 class="panel-title">Formulario de reclamo</h3>
							</div>
							<form action="<?php echo base_url().'registrar_reclamos'; ?>" method="post">
								<div class="panel-body">
									
									<div class="row">
								
										<div class="col-lg-12"><!-- Columna 1-->
											<!-- div class="etiquetas_controles">Causa:</div>
											<div class="form-group">
												<select class="form-control" name="sel_causas" id="sel_causas">
													<?php foreach ($causa_reclamos->result() as $cau): ?>
														<option value="<?php echo $cau->id; ?>" >
															<?php echo $cau->nombre; ?>
														</option>
													<?php endforeach; ?>
												</select>													
											</div -->
											<div class=" etiquetas_controles ">Reclamo:</div>
											<div class="form-group ">
												<input type="text" class="form-control " name="notas" value="" >			
												<input type="hidden" class="form-control " name="id_cliente_reclamo" value="<?php echo $cliente[0]->id_cliente; ?>" >							
											</div>
											<div class=" etiquetas_controles ">Acci&oacute;n de contenci&oacute;n:</div>
											<div class="form-group ">
												<input type="text" class="form-control " name="contencion" value="" >												
											</div>
											<div class=" etiquetas_controles ">An&aacute;lisis de causas:</div>
											<div class="form-group ">
												<input type="text" class="form-control " name="causa" value="" >												
											</div>
											<div class=" etiquetas_controles ">Acci&oacute;n preventiva:</div>
											<div class="form-group ">
												<input type="text" class="form-control " name="preventiva" value="" >												
											</div>
											<div class=" etiquetas_controles ">Costos implicados:</div>
											<div class="form-group ">
												<input type="text" class="form-control " name="costos" value="" >												
											</div>
											<div class=" etiquetas_controles ">Responsable de costos:</div>
											<div class="form-group ">
												<input type="text" class="form-control " name="resp_costos" value="" >												
												<input type="hidden" class="form-control " name="ficha" value="0" >												
											</div>
										</div>
									</div>
									<div class="box-footer clearfix">
										<button type="button" class="btn btn-primary" data-dismiss="modal">Cancelar</button>
										<button type="submit" class="pull-right btn btn-danger" id="sendForm">Registrar</button>											
									</div>
								</div>
							</form>
						</div>	
						
						</div>
					</div>
					<div class="modal-footer">
						
						
						
					</div>
					
				</div>
			</div>
	</div>
	<div id="myModal_equivocado" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="modal-dialog modal-sm">
				<div class="modal-content">

					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
						</button>
						<h4 class="modal-title" id="myModalLabel2">Datos</h4>
					</div>
					<div class="modal-body">
						<div class="box-body">
						
						
						<div class="panel panel-primary">
							<div class="panel-heading">
								<h3 class="panel-title">Contacto equivocado</h3>
							</div>
							<form action="<?php echo base_url().'registrar_equivocado'; ?>" method="post">
								<div class="panel-body">									
									<div class="row">								
										<div class="col-lg-12"><!-- Columna 1-->
											<div class="form-group" >
												<div class="checkbox">
													<label>
														<input type="checkbox" id="tel_equivocado" name="tel_equivocado"> Teléfono equivocado
													</label>
												</div>
												<div class="checkbox" id="ver_email">
													<label>
														<input type="checkbox" id="email_equivocado" name="email_equivocado"> Mail equivocado
													</label>
												</div>

											</div>
											<label for="">***Si selecciona MAIL y teléfono significa que se borrara definitivamnte este cliente de la base de datos</label>	
											<input type="hidden" class="form-control " name="id_cliente_equivocado" value="<?php echo $cliente[0]->id_cliente; ?>" >	
										</div>
									</div>
									<div class="box-footer clearfix">
										<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
										<button type="submit" class="pull-right btn btn-default" id="sendForm">Aceptar</button>											
									</div>
								</div>
							</form>
						</div>	
						
						</div>
					</div>
					<div class="modal-footer">
						
						
						
					</div>
					
				</div>
			</div>
	</div>
	<div id="myModal_llamame" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="modal-dialog modal-sm">
				<div class="modal-content">

					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
						</button>
						<h4 class="modal-title" id="myModalLabel2">Llamarme</h4>
					</div>
					<div class="modal-body">
						<div class="box-body">
						
						
						<div class="panel panel-primary">
							<div class="panel-heading">
								<h3 class="panel-title">Reclamos del cliente</h3>
							</div>
							<form action="<?php echo base_url().'registrar_llamame'; ?>" method="post">
								<div class="panel-body">									
									<div class="row">								
										<div class="col-lg-12"><!-- Columna 1-->
											<div class="form-group" >
												<label>Fecha para llamarme:</label>

												<div class="input-group date">
													<div class="input-group-addon">
														<i class="fa fa-calendar"></i>
													</div>
													<input type="text" class="form-control pull-right" value="<?php echo date('Y-m-d H:i:s'); ?>" name="fecha_llamarme" id="fecha_llamarme">
												</div>
												<!-- /.input group -->
											</div>	
											<input type="hidden" class="form-control " name="id_cliente_llamame" value="<?php echo $cliente[0]->id_cliente; ?>" >	
										</div>
									</div>
									<div class="box-footer clearfix">
										<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
										<button type="submit" class="pull-right btn btn-default" id="sendForm">Registrar</button>											
									</div>
								</div>
							</form>
						</div>	
						
						</div>
					</div>
					<div class="modal-footer">
						
						
						
					</div>
					
				</div>
			</div>
	</div>
	<div id="myModal_inactivo" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="modal-dialog modal-sm">
				<div class="modal-content">

					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
						</button>
						<h4 class="modal-title" id="myModalLabel2">Activar/Desactivar</h4>
					</div>
					<div class="modal-body">
						<div class="box-body">
						
						
						<div class="panel panel-primary">
							<div class="panel-heading">
								<h3 class="panel-title">Modificar el estado del cliente</h3>
							</div>
							<form action="<?php echo base_url().'registrar_inactivo'; ?>" method="post">
								<div class="panel-body">									
									<div class="row">								
										<div class="col-lg-12"><!-- Columna 1-->
											<div class="form-group" >
												<label>Va a cambiar el estado del cliente:</label>

												
												<!-- /.input group -->
											</div>	
											<input type="hidden" class="form-control " name="id_cliente_inactivo" value="<?php echo $cliente[0]->id_cliente; ?>" >	
											<input type="hidden" class="form-control " name="inactivo" value="<?php echo $cliente[0]->inactivo; ?>" >	
										</div>
									</div>
									<div class="box-footer clearfix">
										<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
										<button type="submit" class="pull-right btn btn-default" id="sendForm"><?php if( $cliente[0]->inactivo==1) echo 'Activar'; else echo 'Desactivar' ?></button>											
									</div>
								</div>
							</form>
						</div>	
						
						</div>
					</div>
					<div class="modal-footer">
						
						
						
					</div>
					
				</div>
			</div>
	</div>
	
	<div class="row">
        <div class="col-xs-12 table-responsive">
          <div class="box">	
		    <div class="box-header">
              <h3 class="box-title"><strong>Gestión de Reposición de Unidades Filtrantes</strong></h3>
            </div> 
            <div class="box-body">	
				<form action="<?php echo base_url().'modificar_mision_cartera'; ?>" method="post">
				<input type="hidden" class="form-control " name="id_cliente2" value="<?php echo $cliente[0]->id_cliente; ?>" >
				<table id="cartera" class="table table-striped">
					<thead>
						<tr>
							<!-- <th>Id</th> -->
							<!-- <th>No_factura</th> -->
							<th>Producto</th>
							<th>Repuesto</th>				  
							<!-- <th>Cantidad</th>	--> 			  
							<th>Fecha compra</th>				  
							<th>Fecha Vcto</th>
							<th>Estado</th>
							<th>Dar baja</th>
							<th>A comprar</th>
							<th>Cantidad a comprar</th>
							<th>¿Ya compró?</th>	  
						</tr>
					</thead>
					<tbody>
						<?php $mision_posible =0; $cont=0; for ($i=0; $i < count($cp_id_cliente) ; $i++):   ?>
						<tr>						
							<!-- <td><?php $cont++; echo $cp_id_pedido[$i]; ?></td>	-->						
							<!-- <td><?php echo $cp_no_factura[$i]; ?></td>	-->						
							<td><?php 
								$va= '';
								$te=0;
								foreach ($repuesto_productos->result() as $rep){
									if($rep->id_repuesto== $cp_id_repuesto[$i]){
										foreach ($compras->result() as $com){
											if($com->id_producto == $rep->id_producto && $te==0){
												$va = $com->producto;
												$te =1;
											}
										}
									}									
								}
								if($te == 0){
									foreach ($repuesto_productos->result() as $rep){
										if($rep->id_repuesto== $cp_id_repuesto[$i]){											
											$va = $rep->producto;
											$te =1;												
										}									
									}
								}
								echo $va;
							?></td>							
							<td><?php echo $cp_repuesto[$i]; ?></td>							
							<!-- <td><?php echo $cp_cantidad[$i]; ?></td> -->							
							<td><?php echo $cp_fecha_compra[$i]; ?></td>							
							<td><?php echo $cp_fecha_vcto[$i]; ?></td>
							<td><?php if(date("Y-m-d H:i:s") > $cp_fecha_vcto[$i]): ?><span class="label label-danger"><?php echo 'Vencido'; ?></span><?php else: ?><span class="label label-success"><?php echo 'En tiempo'; ?></span> <?php endif; ?></td>
							<td><input type="checkbox" class="flat" id="baja<?php echo $cont ?>" name="baja<?php echo $cont ?>"></td>
							<td><input type="checkbox" <?php if(date("Y-m-d H:i:s") <= $cp_fecha_vcto[$i]): ?> disabled<?php  endif; ?><?php if(date("Y-m-d H:i:s") > $cp_fecha_vcto[$i]): ?> <?php $mision_posible =1; endif; ?> class="flat" id="compra<?php echo $cont ?>" name="compra<?php echo $cont ?>"></td>
							<td><input type="text" style="width:45px;" class="form-control" name="cantidad<?php echo $cont ?>" id="cantidad<?php echo $cont ?>" value="">
								<input type="hidden" style="width:45px;" class="form-control" name="pedido<?php echo $cont; ?>" id="pedido<?php echo $cont; ?>" value="<?php echo $cp_id_pedido[$i]; ?>">
								<input type="hidden" style="width:45px;" class="form-control" name="repuesto<?php echo $cont; ?>" id="repuesto<?php echo $cont; ?>" value="<?php echo $cp_repuesto[$i]; ?>">
								<input type="hidden" style="width:45px;" class="form-control" name="producto<?php echo $cont; ?>" id="producto<?php echo $cont; ?>" value="<?php echo $cp_id_producto[$i]; ?>">							
							
								<input type="hidden" style="width:45px;" class="form-control" name="descuento<?php echo $cont; ?>" id="descuento<?php echo $cont ?>" value=""></td>	
							<td>
								<a class="btn btn-primary" href="<?php echo base_url().'cartera_realizo_cambio/'.$cliente[0]->id_cliente .'/'.$cp_id_repuesto[$i]; ?>">Ya cambió</a>
							</td>								
						</tr>
						<?php endfor; ?>
						<input type="hidden" class="form-control " name="chequeo_mision" id="chequeo_mision" value="<?php echo $mision_posible; ?>">
										
					</tbody>
				</table>
				<input type="hidden" class="form-control " name="contador" id="contador" value="<?php echo $cont; ?>">
		
             
			</div>  
		  </div> 
        </div>
        <!-- /.col -->
	</div>
	<div class="row" id="mostrar_mision">							
		<div class="col-lg-7"><!-- Columna 2 -->
			<!-- Panel primario datos de la misión-->
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h3 class="panel-title">Misión</h3>
				</div>
				<div class="panel-body">
					<!-- Identificación única del cliente -->
					<div class="form-group">
						<label>¿El cliente va a realizar la compra?</label>
						<label class="radio-inline">
							<input type="radio"  name="exitosa" id="optionsRadiosInline1" value="1" <?php if ($modo_edicion): if ($exitosa!=1):?> checked="checked"
							<?php endif; else:?> checked="checked"
								<?php endif; ?>/>Si
						</label>
						<!--<label class="radio-inline">
							<input type="radio" name="exitosa" id="optionsRadiosInline2" value="0" <?php if ($modo_edicion): if ($exitosa==0):?> checked="checked"
							<?php endif; endif; ?> />No
						</label>-->
						<label class="radio-inline">
							<input type="radio" name="exitosa" id="optionsRadiosInline3" value="2" />En seguimiento
						</label>
					</div>

					<div id="vista_notas">
						<!-- Notas -->
						<div class="etiquetas_controles">NOTAS: *Asegurese de que no este marcada ninguna casilla de compra en los repuestos antes de dejar un seguimiento, escriba una nota y registre los cambios.</div>
						<div>
							<!--div class="etiquetas_controles">Opciones:</div>
							<div class="form-group">
								<select class="form-control" name="sel_opciones" id="sel_opciones">
									<?php foreach ($opciones->result() as $opc): ?>
										<option value="<?php echo $opc->id; ?>">
											<?php echo $opc->nombre; ?>
										</option>
									<?php endforeach; ?>
								</select>
								
							</div-->														
							<textarea id="notas" class="textarea" name="notas" style="width: 100%; height: 125px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
							
						</div>
						<div class="row">
							<div class="col-lg-4">
								<div class="checkbox">
									<label>
										<input type="checkbox" id="recuerdame" name="recuerdame"> Recuerdame esta ficha
									</label>
								</div>
							</div>							
							<div class="col-lg-6">
								<div class="form-group" id="vista_fecha">
									<label>Fecha para notificarme esta ficha:</label>

									<div class="input-group date">
									<div class="input-group-addon">
										<i class="fa fa-calendar"></i>
									</div>
										<input type="text" class="form-control pull-right" value="<?php echo date('Y-m-d H:i:s'); ?>" name="fecha_notificacion" id="fecha_notificacion">
									</div>
									<!-- /.input group -->
								</div>
							</div>
						</div>
						
					</div>
				</div>

			</div>
					
		</div>
	</div>
		
		
		<div class="row">
			<div class="box-footer clearfix">	
					
				<label class="pull-left">*Solamente vuelve al listado de misiones, no guarda cambios.</label>
					
			</div>
        </div>
		<!-- Botón de envío -->
		<div class="row">
			<div class="box-footer clearfix">	
					
				<button type="submit" class="pull-right btn btn-warning" id="sendForm">Registrar Cambios</button>&nbsp;&nbsp;	
				<a class="pull-left btn btn-primary" href="<?php echo base_url().'cancelar_mision/'.$cliente[0]->id_cliente; ?>">Volver a Misiones</a>
					
			</div>
        </div>		
		</div>
		</form>
	  <!-- this row will not appear when printing 
      <div class="row no-print">
        <div class="col-xs-12">
          <a href="invoice-print.html" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> Print</a>
          <button type="button" class="btn btn-success pull-right"><i class="fa fa-credit-card"></i> Submit Payment
          </button>
          <button type="button" class="btn btn-primary pull-right" style="margin-right: 5px;">
            <i class="fa fa-download"></i> Generate PDF
          </button>
        </div>
      </div>-->
    </section>
<script type="text/javascript" language="javascript">
	
	$(document).ready(function () {
		$('#vista_fecha').hide();
		CKEDITOR.replace('notas');
		var xOtro=<?php if ($solicitud_baja==1) echo '1'; else echo '0'; ?>	;
		mo_causas();
		var xBandera=false;
		$('#fecha').datepicker({
			autoclose: true, 
			format: 'yyyy-mm-dd 00:00:00'
		});
		$('#fecha_notificacion').datepicker({
			autoclose: true, 
			format: 'yyyy-mm-dd 00:00:00'
		});
		$('#fecha_llamarme').datepicker({
			autoclose: true, 
			format: 'yyyy-mm-dd'
		});
		$(function () {
			$("#compras").DataTable({          
				stateSave: true
			} );
			$("#ventas").DataTable({          
				stateSave: true
			} );
			$("#cartera").DataTable({          
				stateSave: true
			} );
		});
		cargarMunicipios();
		$('#vista_notas').hide();
		if($('#chequeo_mision').val()==1){
			$('#mostrar_mision').show();
		}else{
			$('#mostrar_mision').hide();
		}
		$('#optionsRadiosInline3').change(function () {
			$('#vista_notas').show();
		});
		$('#optionsRadiosInline1').change(function () {
			$('#vista_notas').hide();
		});
		$('#optionsRadiosInline2').change(function () {
			$('#vista_notas').hide();
		});
		$('#solicitud_baja').change(function () {
			mo_causas();
		});
		function mo_causas() {
			
			if (xOtro==1) {
				$('#ver_otras_causas').show();
				xOtro=0;
			}else{
				$('#ver_otras_causas').hide();
				xOtro=1;
			}
		}
		function cargarMunicipios() {
			var id_provincia = $('#sel_provincias').val();
			$.ajax({
				type: "POST",
				url: "<?php echo base_url();?>municipios_provincia/" + id_provincia,
				data: id_provincia,
				success: function (html) {
					
					$('#sel_municipios').html(html);
					if(!xBandera){
						$('#sel_municipios').val($('#id_municipio').val());
						xBandera =true;
					}
					
				}
			});
		};

		$('#sel_provincias').change(function () {
			cargarMunicipios();
		});
		function agregar_arvhivo(){
			$("#agregar_archivo").load("<?php echo base_url();?>yacompro");
		}
		$('#recuerdame').change(function () {
			if ($("#recuerdame").prop("checked") )
				$('#vista_fecha').show();					
			else 
				$('#vista_fecha').hide();
		});
	});
</script>
