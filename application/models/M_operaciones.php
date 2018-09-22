<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_operaciones extends CI_Model {
    
	/*
	 * ------------------------------------------------------
	 *  Atributos
	 * ------------------------------------------------------
	 */
	 
	 /*
	 * ------------------------------------------------------
	 *  Comportamiento
	 * ------------------------------------------------------
	 */
	
    public function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
	
	/*
	 * ------------------------------------------------------
	 *  GESTIÓN PEDIDOS
	 * ------------------------------------------------------
	 */
	 
	
	// ------------------------------------------------------
	// Pedidos
	public function obtener_pedidos_armador_desp($usuario, $anno, $mes){		
		$texto_consulta = "SELECT `id`, `id_pedido`, `no_factura`, `producto`, `importe`, `recargo`, `OCA`, `armado`, `despachado`, `dni`, `nombre`, `apellidos`, `color`, `id_cliente`, `iva`, `anno`, `mes`, `id_usuario`, `id_entrega`, `precio_base`, `sku`, `id_canal`, `canal`, `envio_por_coordinar`, `fecha_solicitud`, `acreditado`, `id_medio_cobranza`, `id_local`, `local`, `notas` , `usuario`,fecha_envio FROM `view_pedidos_union` where despachado = 0 and id <> 'Otras entregas' and id <> 'SHOWROOM' order by id_pedido;";
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function obtener_pedidos_armador_desp_sf(){		
		$texto_consulta = "SELECT `id`, `id_pedido`, `no_factura`, `producto`, `importe`, `recargo`, `OCA`, `armado`, `despachado`, `dni`, `nombre`, `apellidos`, `color`, `id_cliente`, `iva`, `anno`, `mes`, `id_usuario`, `id_entrega`, `precio_base`, `sku`, `id_canal`, `canal`, `envio_por_coordinar`, `fecha_solicitud`, `acreditado`, `id_medio_cobranza`, `id_local`, `local`, `notas` , `usuario`,fecha_envio FROM `view_pedidos_union` where despachado = 0 order by id_pedido;";
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function obtener_despachos(){		
		$texto_consulta = "SELECT `id` FROM `view_pedidos_union` group by id;";
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function obt_empresa($id_pedido){		
		$texto_consulta = "SELECT `id_empresa` FROM `entregas_envios` where id_pedido= $id_pedido;";
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function obtener_pedidos_armador_desp_ok( $anno, $mes){		
		$texto_consulta = "SELECT `id`, `id_pedido`, `no_factura`, `producto`, `importe`, `recargo`, `OCA`, `armado`, `despachado`, `dni`, `nombre`, `apellidos`, `color`, `id_cliente`, `iva`, `anno`, `mes`, `id_usuario`, `id_entrega`, `precio_base`, `sku`, `id_canal`, `canal`, `envio_por_coordinar`, `fecha_solicitud`, `acreditado`, `id_medio_cobranza`, `id_local`, `local`, `notas`, `usuario`,fecha_envio FROM `view_pedidos_union` where anno = $anno and mes = $mes and despachado = 1 order by id_pedido;";
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function obtener_consultor($id_consultor){		
		$texto_consulta = "SELECT * FROM `usuarios` where id = $id_consultor;";
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado->row();
	}
	public function pedidos()
	{
	    $consulta = "SELECT `id_pedido`, `id_cliente`, `nombre_cliente`, `id_canal`, `id_usuario`, `fecha_solicitud`, `first_name`, `no_factura`, `armado`, `apellidos`, `telefono`, `email`, `recargo`, `codigo_postal`, `calle`, `nro`, `piso`, `dpto`, `entrecalle1`, `entrecalle2`, `fecha_nacimiento`, `dni`, `celular`, `canal`, `tipo_factura`, `calle_entrega`, `nro_entrega`, `piso_entrega`, `dpto_entrega`, `entrecalle1_entrega`, `entrecalle2_entrega`, `municipio`, `provincia`, `last_name`, `vip`, `nivel`, `forma_pago`, `acreditado`, `cupon_promo`, `cupon_nro`, `envio_por_coordinar`, `medio_cobranza` from view_pedidos;";
					
	    $resultado = $this->db->query($consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado; 
	}
	public function detalles_pedidos1($id_entrega)
	{
	    $consulta = "SELECT `id_pedido`, `id_producto`, `cantidad`, `nombre`, `reg_cancelado`, `id_entrega`, `dni`, `nombre_cliente`, `apellidos`, `telefono`, `email`, `codigo_postal`, `calle`, `nro`, `piso`, `dpto`, `entrecalle1`, `entrecalle2`, `no_factura`, `recargo`, `calle_entrega`, `nro_entrega`, `piso_entrega`, `dpto_entrega`, `entrecalle1_entrega`, `entrecalle2_entrega`, `iva`, `tipo_factura`, `precio`, `descuento`, `celular`, `id_color`, `color`, `precio_base`, `sku` from view_detalles_pedidos where id_entrega = $id_entrega;";
					
	    $resultado = $this->db->query($consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado; 
	}
	public function detalles_pedidos_terceros($id_pedido)
	{
	    $consulta = "SELECT `nombre`, `cantidad`, `id_pedido`, `id_color`, `color` from view_detalles_pedidos_terceros where id_pedido = $id_pedido;";
					
	    $resultado = $this->db->query($consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado; 
	}
	
	public function total_ventas_pendientes()
	{
		$fecha = new DateTime();		
		$anno  				= $fecha->format('Y');
		$datos['anno']  	= $anno;
		$mes  				= $fecha->format('m');
		$datos['mes']  		= $mes;
		$user = $this->ion_auth->user()->row();
		$usuario = $user->id;
		$pedidos = $this->obtener_pedidos_rodo($usuario, $anno, $mes);
	    $res = $pedidos;
		return $res->num_rows();
	}
	public function total_ventas_rev()
	{
		$fecha = new DateTime();		
		$anno  				= $fecha->format('Y');
		$datos['anno']  	= $anno;
		$mes  				= $fecha->format('m');
		$datos['mes']  		= $mes;
		$user = $this->ion_auth->user()->row();
		$usuario = $user->id;
		$texto_consulta = "SELECT `id_pedido` FROM `view_pedido_directo_revendedor` where  id_usuario= $usuario and email not in (select email from view_usuarios_clientes) group by id_pedido;";
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;

	    $res = $resultado;
		return $res->num_rows();
	}
	public function total_ventas_pendientes_pv()
	{
		$user = $this->ion_auth->user()->row();
		$usuario = $user->id;
		$fecha = new DateTime();		
		$anno  				= $fecha->format('Y');
		$datos['anno']  	= $anno;
		$mes  				= $fecha->format('m');
		$datos['mes']  		= $mes;
		$texto_consulta = "SELECT distinct id_pedido FROM `view_pedidos_union` where   despachado = 0 and id = 'SHOWROOM'";
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;

	    $res = $resultado;
		return $res->num_rows();
	}
		


	public function total_pedidos()
	{
	    $res = $this->pedidos();
		return $res->num_rows();
	}
	// ------------------------------------------------------
	// Un pedido
	
	public function obt_pedido($id_actual)
	{
		$texto_consulta = "SELECT `id_pedido`, `id_cliente`, `nombre_cliente`, `id_canal`, `id_usuario`, `fecha_solicitud`, `first_name`, `no_factura`, `armado`, `apellidos`, `telefono`, `email`, `recargo`, `codigo_postal`, `calle`, `nro`, `piso`, `dpto`, `entrecalle1`, `entrecalle2`, `fecha_nacimiento`, `dni`, `celular`, `canal`, `tipo_factura`, `calle_entrega`, `nro_entrega`, `piso_entrega`, `dpto_entrega`, `entrecalle1_entrega`, `entrecalle2_entrega`, `municipio`, `provincia`, `last_name`, `vip`, `nivel`, `forma_pago`, `acreditado`, `cupon_promo`, `cupon_nro`, `envio_por_coordinar`, `medio_cobranza` from view_pedidos WHERE (id_pedido = '$id_actual');";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function obt_pedido_tercero($id_actual)
	{
		$texto_consulta = "SELECT `id`, `id_pedido`, `no_factura`, `producto`, `importe`, `recargo`, `OCA`, `armado`, `despachado`, `dni`, `nombre`, `apellidos`, `color`, `id_cliente`, `iva`, `anno`, `mes`, `id_usuario`, `id_entrega`, `precio_base`, `sku`, `id_canal`, `canal`, `envio_por_coordinar`, `fecha_solicitud`, `acreditado`, `id_medio_cobranza` from view_pedido_tercero WHERE (no_factura = '$id_actual');";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function obt_pedido_tercero2($id_actual)
	{
		$texto_consulta = "SELECT `id`, `id_pedido`, `no_factura`, `producto`, `importe`, `recargo`, `OCA`, `armado`, `despachado`, `dni`, `nombre`, `apellidos`, `color`, `id_cliente`, `iva`, `anno`, `mes`, `id_usuario`, `id_entrega`, `precio_base`, `sku`, `id_canal`, `canal`, `envio_por_coordinar`, `precio`, `descuento`, `cantidad`, `empresa`, `tipo_factura`, `tipo_entrega`,sucursal, operativa from view_pedido_tercero1 WHERE (id_pedido = '$id_actual');";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}

	public function obt_pedido_tercero1($id_actual)
	{
		$texto_consulta = "SELECT `id`, `id_pedido`, `no_factura`, `producto`, `importe`, `recargo`, `OCA`, `armado`, `despachado`, `dni`, `nombre`, `apellidos`, `color`, `id_cliente`, `iva`, `anno`, `mes`, `id_usuario`, `id_entrega`, `precio_base`, `sku`, `id_canal`, `canal`, `envio_por_coordinar`, `fecha_solicitud`, `acreditado`, `id_medio_cobranza` from view_pedido_tercero WHERE (id_pedido = '$id_actual');";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function obt_pedido_tercero4($id_actual)
	{
		$texto_consulta = "SELECT `id`, `id_pedido`, `no_factura`, `producto`, `importe`, `recargo`, `OCA`, `armado`, `despachado`, `dni`, `nombre`, `apellidos`, `color`, `id_cliente`, `iva`, `anno`, `mes`, `id_usuario`, `id_entrega`, `precio_base`, `sku`, `id_canal`, `canal`, `envio_por_coordinar`, `precio`, `descuento`, `cantidad`, `empresa`, `tipo_factura`, `tipo_entrega`, `incremento`, notas,sucursal, operativa, id_sucursal from view_pedido_tercero1 WHERE (id_pedido = '$id_actual');";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function obt_id_pedido($id_actual)
	{
		$texto_consulta = "SELECT id_pedido from pedidos WHERE (no_factura = '$id_actual');";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		$resultado = $resultado->result();
		return $resultado[0]->id_pedido;
	}
	// ------------------------------------------------------
	// Registrar pedido
	
	public function registrar_pedido($no_factura, $referencia, $id_cliente, $id_canal, $id_usuario, $fecha_solicitud)
	{
		$texto_consulta =  "INSERT IGNORE INTO pedidos (no_factura, referencia, id_cliente, id_canal, id_usuario,fecha_solicitud)" 
		                  . " VALUES('$no_factura', '$referencia', $id_cliente, $id_canal, $id_usuario,'$fecha_solicitud');";
		
		$resultado = $this->db->query($texto_consulta);
		
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}

	// ------------------------------------------------------
	// Modificar pedido
	
	public function modificar_pedido($id_actual, $id_pedido, $id_cliente, $nombre_canal, $id_usuario, $id_estado, $fecha_solicitud, $fecha_limite_pago)
	{
		$texto_consulta = "UPDATE IGNORE pedidos SET id_pedido='$id_pedido', id_cliente='$id_cliente', nombre_canal='$nombre_canal', id_usuario=$id_usuario, id_estado=$id_estado, fecha_solicitud='$fecha_solicitud', fecha_limite_pago='$fecha_limite_pago' WHERE (id_pedido = '$id_actual');"; 
							
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	public function registrar_comision_pedido($id_pedido,$id_usuario_comisiona, $comision)
	{
		$texto_consulta = "UPDATE IGNORE pedidos SET id_usuario_comisiona = $id_usuario_comisiona, comision = $comision WHERE (id_pedido = $id_pedido);"; 
							
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	// ------------------------------------------------------
	// Cancelar pedido
	
	public function cancelar_pedido($id_pedido)
	{
		$texto_consulta =  "DELETE from pedidos WHERE (id_pedido='$id_pedido');"; 
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	
	
	// ------------------------------------------------------
	// Usuarios 
	
	public function usuarios()
	{
		$texto_consulta = "SELECT * FROM view_usuarios;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
			
		return $resultado;
	}
	
	// ------------------------------------------------------
	// Productos
	
	public function productos()
	{
		$consulta = "SELECT * from view_productos;";
	    
					
	    $resultado = $this->db->query($consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado; 
	}
	public function productos_rev()
	{
		$consulta = "SELECT * from view_productos where disponible_a_rev=1;";
	    
					
	    $resultado = $this->db->query($consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado; 
	}
	public function productos_revint($id_pais)
	{
		$consulta = "SELECT `id_producto`, `nombre`, `precio`, `es_repuesto`, `existencia`, `vencimiento`, `reg_cancelado`, `alto`, `ancho`, `largo`, `peso`, `sku`, `codigo_barra`, `id_categoria`, `valor_declarado`, `dum14`, `precio` as `precio_rev`,cant_min_revint, cant_min_mayint,precio_mayorista FROM view_productos_paises where  id_pais = 3;";
	    
					
	    $resultado = $this->db->query($consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado; 
	}
	public function combos()
	{
		$consulta = "SELECT * from combos_rev;";
	    
					
	    $resultado = $this->db->query($consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado; 
	}
	public function obt_ordenes()
	{	
		$us = $this->ion_auth->user()->row();
		$id_usuario = $us->id;
	    $consulta = "SELECT * from view_orden_compra where id_usuario= $id_usuario;";
					
	    $resultado = $this->db->query($consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado; 
	}
	public function obt_estado_ordenes()
	{	
		$us = $this->ion_auth->user()->row();
		$id_usuario = $us->id;
	    $consulta = "SELECT * from view_estados_orden ;";
					
	    $resultado = $this->db->query($consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado; 
	}
	public function productos_colores()
	{
	    $consulta = "SELECT * from view_producto_colores;";
					
	    $resultado = $this->db->query($consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado; 
	}
	public function producto_colores($id_producto)
	{
	    $consulta = "SELECT id_color,nombre from view_producto_colores where id_producto=$id_producto;";
					
	    $resultado = $this->db->query($consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado; 
	}
	public function productos_campanas()
	{
	    $consulta = "SELECT * from view_campana_producto;";
					
	    $resultado = $this->db->query($consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado; 
	}
	public function producto_campanas($id_producto)
	{
	    $consulta = "SELECT id_campana,campana from view_campana_producto where id_producto = $id_producto and curdate() <= fecha_fin;";
					
	    $resultado = $this->db->query($consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado; 
	}
	public function producto_campanas_rev($id_producto)
	{
	    $consulta = "SELECT id_campana,campana from view_campana_producto_rev where id_producto = $id_producto and curdate() <= fecha_fin;";
					
	    $resultado = $this->db->query($consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado; 
	}
	public function tipos_factura()
	{
	    $consulta = "SELECT * from tipo_factura;";
					
	    $resultado = $this->db->query($consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado; 
	}
	
	// ------------------------------------------------------
	// Clientes
	
	public function clientes()
	{
		$texto_consulta = "SELECT `id_cliente`, `dni`, `municipio`, `provincia`, `nombre`, `telefono`, `email`, `en_operacion`, `en_mision`, `reg_cancelado`, `id_municipio`, `id_provincia`, `apellidos`, `codigo_postal`, `calle`, `nro`, `dpto`, `piso`, `entrecalle1`, `entrecalle2`, `fecha_nacimiento`, `origen`, `vip`, `nivel`, `celular`, `observaciones`, `cuit` FROM view_clientes LIMIT 0,100;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
			
		return $resultado;
	}
	public function clientes_filtro($nombre, $dni, $telefono, $apellidos, $email, $celular)
	{
		$texto_consulta = "SELECT `id_cliente`, `dni`, `municipio`, `provincia`, `nombre`, `telefono`, `email`, `en_operacion`, `en_mision`, `reg_cancelado`, `id_municipio`, `id_provincia`, `apellidos`, `codigo_postal`, `calle`, `nro`, `dpto`, `piso`, `entrecalle1`, `entrecalle2`, `fecha_nacimiento`, `origen`, `vip`, `nivel`, `celular`, `observaciones`, `cuit` FROM view_clientes ";
		if($nombre != '1'){
			$texto_consulta = $texto_consulta."where nombre like '%$nombre%'";
		}else{
			$nombre='';
			$texto_consulta = $texto_consulta."where nombre like '%$nombre%'";
		}
		if( $dni !='a'){
			$texto_consulta = $texto_consulta." and dni like '%$dni%'";	
		}
		if( $apellidos !='1'){
			$texto_consulta = $texto_consulta." and apellidos like '%$apellidos%'";	
		}
		if( $email !='1'){
			$texto_consulta = $texto_consulta." and email like '%$email%'";	
		}
		if( $telefono !='a'){
			$texto_consulta = $texto_consulta." and telefono like '%$telefono%'";	
		}
		if( $celular !='a'){
			$texto_consulta = $texto_consulta." and  celular like '%$celular%'";	
		}
		$texto_consulta = $texto_consulta." LIMIT 0,100;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
			
		return $resultado;
	}
	public function clientes_mision($id_cliente)
	{
		$texto_consulta = "SELECT `id_cliente`, `dni`, `municipio`, `provincia`, `nombre`, `telefono`, `email`, `en_operacion`, `en_mision`, `reg_cancelado`, `id_municipio`, `id_provincia`, `apellidos`, `codigo_postal`, `calle`, `nro`, `dpto`, `piso`, `entrecalle1`, `entrecalle2`, `fecha_nacimiento`, `origen`, `vip`, `nivel`, `celular`, `observaciones`, `cuit` FROM view_clientes where id_cliente=$id_cliente LIMIT 0,10;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
			
		return $resultado;
	}
	public function clientes_revendedores()
	{
		$texto_consulta = "SELECT `id_cliente`, `dni`, `municipio`, `provincia`, `nombre`, `telefono`, `email`, `en_operacion`, `en_mision`, `reg_cancelado`, `id_municipio`, `id_provincia`, `id_usuario`, `apellidos`, `codigo_postal`, `calle`, `nro`, `piso`, `dpto`, `entrecalle1`, `entrecalle2`, `fecha_nacimiento`, `vip`, `nivel`, `celular`, `observaciones`, `cuit` FROM view_clientes_revendedores;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
			
		return $resultado;
	}
	// ------------------------------------------------------
	// Canales de entrada
	public function canales()
	{
		$texto_consulta = "select * from canales;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function canales_terceros()
	{
		$texto_consulta = "select * from canales where id<>4 and id<>6 and id<>5;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	// ------------------------------------------------------
	// Estados de un pedido
	public function estados_pedido()
	{
		$texto_consulta = "select * from estados_pedido;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	
	/*
	 * ------------------------------------------------------
	 *  GESTIÓN DETALLES PEDIDOS
	 * ------------------------------------------------------
	 */
	 
	// ------------------------------------------------------
	// Detalles
	public function suma_pedido($id_pedido)
	{
	    $consulta = "SELECT suma from view_suma_pedidos where id_pedido = $id_pedido;";
					
	    $resultado = $this->db->query($consulta);
	    if (!$resultado)
			echo $resultado;
		if($resultado->num_rows()>0){
			$res = $resultado->result();
			$suma =$res[0]->suma;
			
		}else{			
			$suma =0;
			
		}
		
		return $suma;
	}
	public function detalles_pedidos()
	{
	    $consulta = "SELECT `id_pedido`, `id_producto`, `cantidad`, `nombre`, `reg_cancelado`, `id_entrega`, `dni`, `nombre_cliente`, `apellidos`, `telefono`, `email`, `codigo_postal`, `calle`, `nro`, `piso`, `dpto`, `entrecalle1`, `entrecalle2`, `no_factura`, `recargo`, `calle_entrega`, `nro_entrega`, `piso_entrega`, `dpto_entrega`, `entrecalle1_entrega`, `entrecalle2_entrega`, `iva`, `tipo_factura`, `precio`, `descuento`, `celular`, `id_color`, `color`, `precio_base`, `sku` from view_detalles_pedidos;";
					
	    $resultado = $this->db->query($consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado; 
	}
	
	public function total_detalles()
	{
	    $res = $this->detalles_pedidos(); 
		return $res->num_rows();
	}
	
	
	
	// ------------------------------------------------------
	// Un detalle
	
	public function obt_detalle($id_pedido, $id_producto)
	{
		$texto_consulta = "SELECT `id_pedido`, `id_producto`, `cantidad`, `nombre`, `reg_cancelado`, `id_entrega`, `dni`, `nombre_cliente`, `apellidos`, `telefono`, `email`, `codigo_postal`, `calle`, `nro`, `piso`, `dpto`, `entrecalle1`, `entrecalle2`, `no_factura`, `recargo`, `calle_entrega`, `nro_entrega`, `piso_entrega`, `dpto_entrega`, `entrecalle1_entrega`, `entrecalle2_entrega`, `iva`, `tipo_factura`, `precio`, `descuento`, `celular`, `id_color`, `color`, `precio_base`, `sku` from view_detalles_pedidos WHERE (id_pedido = '$id_pedido' and id_producto = '$id_producto');";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	
	public function obt_detalle_pedido($id_pedido)
	{
		$texto_consulta = "SELECT `id_pedido`, `id_producto`, `cantidad`, `nombre`, `reg_cancelado`, `id_entrega`, `dni`, `nombre_cliente`, `apellidos`, `telefono`, `email`, `codigo_postal`, `calle`, `nro`, `piso`, `dpto`, `entrecalle1`, `entrecalle2`, `no_factura`, `recargo`, `calle_entrega`, `nro_entrega`, `piso_entrega`, `dpto_entrega`, `entrecalle1_entrega`, `entrecalle2_entrega`, `iva`, `tipo_factura`, `precio`, `descuento`, `celular`, `id_color`, `color`, `precio_base`, `sku`,`incremento` from view_detalles_pedidos WHERE id_pedido = '$id_pedido';";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function obt_detalle_pedido2($id_pedido)
	{
		$texto_consulta = "SELECT `id_pedido`, `id_producto`, `cantidad`, `nombre`, `reg_cancelado`, `id_entrega`, `dni`, `nombre_cliente`, `apellidos`, `telefono`, `email`, `codigo_postal`, `calle`, `nro`, `piso`, `dpto`, `entrecalle1`, `entrecalle2`, `no_factura`, `recargo`, `calle_entrega`, `nro_entrega`, `piso_entrega`, `dpto_entrega`, `entrecalle1_entrega`, `entrecalle2_entrega`, `iva`, `tipo_factura`, `precio`, `descuento`, `celular`, `id_color`, `color`, `precio_base`, `sku`,`incremento`, `id_local`,`local` ,`notas` from view_detalles_pedidos WHERE id_pedido = '$id_pedido';";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	// ------------------------------------------------------
	// Registrar detalle
	
	public function registrar_detalle($id_pedido, $id_producto, $cantidad)
	{
		$texto_consulta =  "INSERT IGNORE INTO detalles (id_pedido, id_producto, cantidad)" 
		                  . " VALUES ('$id_pedido', '$id_producto', $cantidad);";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}

	// ------------------------------------------------------
	// Modificar detalle
	
	public function modificar_detalle($id_pedido_actual, $id_producto_actual, $id_pedido, $id_producto, $cantidad, $descuento)
	{
		$texto_consulta =  "UPDATE IGNORE detalles SET 
							id_pedido=$id_pedido,
							id_producto='$id_producto',
							cantidad=$cantidad,
							descuento='$descuento' 
							WHERE (id_pedido = id_pedido_actual and id_producto = '$id_producto_actual');"; 
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	
	// ------------------------------------------------------
	// Cancelar detalle
	
	public function cancelar_detalle($id_pedido, $id_producto)
	{
		$texto_consulta =  "DELETE from detalles WHERE (id_pedido = '$id_pedido' and id_producto = '$id_producto');"; 
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	
	/*
	 * ------------------------------------------------------
	 *  GESTIÓN ENTREGAS POR TERCEROS
	 * ------------------------------------------------------
	 */
	 
	// ------------------------------------------------------
	// Entregas por terceros
	public function listado_despachadores()
	{
	    $consulta = "SELECT * from view_pedidos_despachar where id_envio<>'';";
					
	    $resultado = $this->db->query($consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado; 
	}
	public function entregas_terceros_despachadores()
	{
	    $consulta = "SELECT * from view_entregas_terceros where armado=1 and id_envio<>'';";
					
	    $resultado = $this->db->query($consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado; 
	}
	public function total_entregas_terceros_despachadores()
	{
	    $consulta = "SELECT * from view_entregas_terceros where armado=1 and id_envio<>'';";
					
	    $resultado = $this->db->query($consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado->num_rows(); 
	}
	public function total_entregas_terceros_despachadas_despachadores()
	{
	    $consulta = "SELECT * from view_entregas_terceros where armado=1 and id_envio<>'' and id_estado=1;";
					
	    $resultado = $this->db->query($consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado->num_rows(); 
	}
	public function entregas_para_oca()
	{
	    $consulta = "SELECT * from view_pedidos_para_oca where id_empresa=10 and id_envio='';";
					
	    $resultado = $this->db->query($consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado; 
	}
	public function entregas_para_oca_ok()
	{
	    $consulta = "SELECT * from view_pedidos_para_oca where id_empresa=10;";
					
	    $resultado = $this->db->query($consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado; 
	}
	public function entregas_terceros()
	{
	    $consulta = "SELECT * from view_entregas_terceros;";
					
	    $resultado = $this->db->query($consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado; 
	}
	public function entregas_terceros_envio($id_prdido)
	{
	    $consulta = "SELECT * from view_entregas_terceros where no_factura='$id_prdido';";
					
	    $resultado = $this->db->query($consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado; 
	}
	public function total_entregas_terceros_despachadas()
	{
	    $consulta = "SELECT * from view_entregas_terceros where id_estado=1;";
					
	    $resultado = $this->db->query($consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado->num_rows(); 
	}
	public function total_entregas_terceros_canceladas()
	{
	    $consulta = "SELECT * from view_entregas_terceros where reg_cancelado=1;";
					
	    $resultado = $this->db->query($consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado->num_rows(); 
	}
	public function total_entregas_terceros()
	{
	    $res = $this->entregas_terceros();
		return $res->num_rows(); 
	}
	// ------------------------------------------------------
	// Posibles estados de los envíos
	
	public function estados_entregas_terceros()
	{
	    $consulta = "SELECT * from estados_envios;";
					
	    $resultado = $this->db->query($consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado; 
	}
	
	// ------------------------------------------------------
	// Empresas que prestan servicios de flete
	
	public function empresas_flete()
	{
	    $consulta = "SELECT * from empresas_flete;";
					
	    $resultado = $this->db->query($consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado; 
	}
	
	// ------------------------------------------------------
	// Una entrega por tercero
	
	public function obt_entrega_tercero($id_pedido, $id_empresa)
	{
		$texto_consulta = "SELECT * from view_entregas_terceros WHERE (id_pedido = $id_pedido and id_empresa = '$id_empresa');";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function obt_entrega_envios($id_pedido)
	{
		$texto_consulta = "SELECT id_pedido,id_envio,reg_cancelado from entregas_envios where id_pedido=$id_pedido;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	// ------------------------------------------------------
	// Registrar entrega por tercero
	
	public function registrar_entrega_tercero($id_pedido, $id_empresa, $id_estado, $id_envio, $fecha)
	{
		$texto_consulta =  "INSERT IGNORE INTO entregas_envios (id_pedido, id_empresa, id_estado, id_envio, fecha) " 
		                  . " VALUES ('$id_pedido', '$id_empresa', $id_estado, '$id_envio', '$fecha');";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}

	// ------------------------------------------------------
	// Modificar entrega por tercero
	
	public function modificar_entrega_tercero($id_pedido_actual, $id_empresa_actual, $id_pedido, $id_empresa, $id_estado, $id_envio, $fecha)
	{
		$texto_consulta =  "UPDATE IGNORE entregas_envios SET 
							id_pedido=$id_pedido,
							id_empresa='$id_empresa',
							id_estado=$id_estado,
							id_envio='$id_envio',
							fecha='$fecha' 
							WHERE (id_pedido = $id_pedido_actual and id_empresa = $id_empresa_actual);"; 
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	public function modificar_envio($id_pedido_actual,  $id_envio,$numero_envio)
	{
		$texto_consulta =  "UPDATE IGNORE entregas_envios SET 							
							id_envio='$id_envio', notas='1', numero_envio = '$numero_envio'
							WHERE (id_pedido = $id_pedido_actual );"; 
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	public function modificar_fecha_retiro($id_pedido_actual,$fecha_retiro)
	{
		$texto_consulta =  "UPDATE IGNORE entregas_envios SET fecha_envio = '$fecha_retiro'	WHERE (id_pedido = $id_pedido_actual );"; 
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	public function actu_fecha_envio($id_pedido_actual, $fecha_hoy)
	{
		$texto_consulta =  "UPDATE IGNORE entregas_envios SET 							
							 fecha_envio='$fecha_hoy'
							WHERE (id_pedido = $id_pedido_actual );"; 
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	// ------------------------------------------------------
	// Cancelar entrega por tercero
	public function cancelar_envio( $id_envio)
	{
		$texto_consulta =  "UPDATE IGNORE entregas_envios SET 							
							reg_cancelado=1, id_envio=''
							WHERE (id_envio = $id_envio );"; 
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	public function cancelar_entrega_tercero($id_pedido, $id_empresa)
	{
		$texto_consulta =  "DELETE from entregas_envios WHERE (id_pedido='$id_pedido' and id_empresa = '$id_empresa');"; 
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	
	/*
	 * ------------------------------------------------------
	 *  GESTIÓN ENTREGAS DIRECTAS
	 * ------------------------------------------------------
	 */
	 
	// ------------------------------------------------------
	// Entregas directas
	
	public function entregas_directas()
	{
	    $consulta = "SELECT * from view_entregas_directas;";
					
	    $resultado = $this->db->query($consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado; 
	}
	public function total_entregas_directas()
	{
	    $consulta = "SELECT * from view_entregas_directas;";
					
	    $resultado = $this->db->query($consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado->num_rows();
	}
	public function chequear_envio()
	{
	    $consulta = "SELECT `id_pedido`, `id_empresa`, `id_estado`, `id_envio`, `fecha`, `reg_cancelado`, `notas`, `id_tipo_empresa`, `numero_envio`, `sucursal`, `operativa`, `id_sucursal`, `fecha_envio` FROM `entregas_envios` WHERE `id_empresa`=10 and `id_envio`='';";
					
	    $resultado = $this->db->query($consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function total_entregas_directas_despachadas()
	{
	    $consulta = "SELECT * from view_entregas_directas where despachado =1;";
					
	    $resultado = $this->db->query($consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado->num_rows();
	}
	// ------------------------------------------------------
	// Una entrega directa
	
	public function obt_entrega_directa($id_entrega)
	{
		$texto_consulta = "SELECT * from view_entregas_directas WHERE (id_entrega = $id_entrega);";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	
	// ------------------------------------------------------
	// Registrar entrega directa
	
	public function registrar_entrega_directa($id_pedido, $despachado)
	{
		$texto_consulta =  "INSERT IGNORE INTO entregas_directas (id_pedido, despachado)" 
		                  . " VALUES('$id_pedido', $despachado);";
		
		//echo $texto_consulta; exit(); 
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}

	// ------------------------------------------------------
	// Modificar entrega directa
	
	public function modificar_entrega_directa($id_entrega, $id_pedido, $despachado)
	{
		$texto_consulta =  "UPDATE IGNORE entregas_directas SET 
							id_pedido='$id_pedido',
							despachado=$despachado
							WHERE (id_entrega = $id_entrega);"; 
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	
	// ------------------------------------------------------
	// Cancelar entrega directa
	
	public function cancelar_entrega_directa($id_entrega)
	{
		$texto_consulta =  "DELETE from entregas_directas WHERE (id_entrega=$id_entrega);"; 
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	
	
	//*******************************************************************************************************
    //*******************************************************************************************************
	//     Segunda parte
	//*******************************************************************************************************
    //*******************************************************************************************************
	// Obtener los datos de un producto
	public function obt_producto($id_actual)
	{
		$texto_consulta = "SELECT * FROM productos where id_producto = '$id_actual';";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	//*******************************************************************************************************
	// Listar productos
	public function obt_productos()
	{
		$texto_consulta = "SELECT *	FROM productos;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	//*******************************************************************************************************
	// Registrando un producto
	public function registrar_producto($id_producto, $descripcion, $precio, $es_repuesto, $vencimiento)
	{
		$texto_consulta =  "INSERT IGNORE INTO productos (id_producto, descripcion, precio, es_repuesto, vencimiento)" 
		                  . " VALUES('$id_producto',' $descripcion', $precio, '$es_repuesto', $vencimiento);";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	//*******************************************************************************************************
	// Modificando  un producto
	public function modificar_producto($id_actual, $id_producto, $descripcion, $precio, $es_repuesto, $vencimiento)
	{
		$texto_consulta =  "UPDATE IGNORE productos SET 
		                    id_producto='$id_producto', 
		                    descripcion='$descripcion', 
							precio=$precio, 
							es_repuesto='$es_repuesto', 
							vencimiento=$vencimiento
							WHERE (id_producto = '$id_actual');"; 
		                    
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	//*******************************************************************************************************
	// Cancelando un producto
	public function cancelar_producto($id_producto)
	{
		$texto_consulta =  "DELETE FROM productos WHERE (id_producto='$id_producto');"; 
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	public function obt_nombre_canal($id_canal)
	{
		$texto_consulta = "SELECT nombre FROM canales where id = $id_canal;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		$resultado=$resultado->result();
		return $resultado[0]->nombre;
	}
   //*******************************************************************************************************
    // Registrar venta
	
	public function registrar_venta(
	   	$nuevo_cliente,
		$id_cliente_act,
		$id_municipio, 
		$dni, 
		$nombre, 
		$apellidos, 
		$telefono,
		$celular, 
		$codigo_postal, 
		$calle, 
		$nro, 
		$piso, 
		$dpto, 
		$entrecalle1, 
		$entrecalle2, 
		$email,
		$revendedor,
		$fecha_nacimiento,
		$id_canal,
		$no_factura,
		$id_transaccion,
		$fecha_venta,
		 $recargo,
		 $monto_iva,
		 $tipo_factura,
		 $calle_entrega,
		 $nro_entrega,
		 $piso_entrega,
		 $dpto_entrega,
		 $entrecalle1_entrega,
		 $entrecalle2_entrega,
		$municipio_entrega,
		$provincia_entrega,
		$dt_productos,
		$dt_precios,
		$dt_cantidades,
		$dt_descuentos,
		$dt_notas,
		$dt_descuentos_vip,
		$dt_incrementos,
		$dt_campanas,
		$dt_colores,
		$total_productos,
		$pedido_mision,
		$tipo_envio,
		$id_empresa,
		$tipo_empresa,
		$com_atencion,
		$com_mision, 
		$com_mcoy, 
		$forma_pago,
		$observaciones,
		$cuit,
		$cupon_nro,
		$cupon_promo,
		$nro_remito,
		$tx_no_acreditada,
		$frm_medio ,
		$id_local,
		$nombre_operativa,
		$nombre_sucursal,
		$id_sucursal,
		$incluye_seguro  
	)
	{
		$nombre = str_replace("'","´",$nombre);
		$apellidos = str_replace("'","´",$apellidos);
		$calle = str_replace("'","´",$calle);
		$calle_entrega = str_replace("'","´",$calle_entrega);
		$entrecalle1 = str_replace("'","´",$entrecalle1);
		$entrecalle2 = str_replace("'","´",$entrecalle2);
		$entrecalle1_entrega = str_replace("'","´",$entrecalle1_entrega);
		$entrecalle2_entrega = str_replace("'","´",$entrecalle2_entrega);
		$par1 = $this->obtener_parametro('CODIGO_PEDIDO');
        $fila1 = $par1->row();
		$consec1 = $fila1->valor;
		$par2 = $this->obtener_parametro('CONSECUTIVO_VENTA');
        $fila2 = $par2->row();
		$consec2 = $fila2->valor;
		$consecutivo 			=$consec1. '-' .$consec2;
		
		$no_factura = $consecutivo;
		$id_transaccion = $consecutivo;
		// Usuario actual
		$us = $this->ion_auth->user()->row();
		$id_usuario = $us->id;
		$canal = $this->obt_nombre_canal($id_canal);
		if($id_canal == 4 || $id_canal == 6) $canal = 'SISTEMA DVIGI';
		if($id_cliente_act == ''){
			$nuevo_cliente = 'true';
		}
		// Clientes
		$consulta_clientes = "";
		if ( $nuevo_cliente == 'true' )
		    $consulta_clientes = "INSERT INTO clientes ( id_municipio, dni, nombre, apellidos, calle, nro, piso, dpto, entrecalle1, entrecalle2, telefono, celular, email, en_operacion, en_mision, reg_cancelado, codigo_postal, fecha_nacimiento, origen, observaciones, cuit ) VALUES ($id_municipio, '$dni', '$nombre', '$apellidos', '$calle', '$nro', '$piso', '$dpto', '$entrecalle1', '$entrecalle2','$telefono', '$celular', '$email', 0, 0, 0,'$codigo_postal', '$fecha_nacimiento','$canal', '$observaciones', '$cuit');";
		else{
			$consulta_clientes= "UPDATE clientes SET id_municipio= $id_municipio, dni = '$dni', nombre = '$nombre', apellidos = '$apellidos', calle = '$calle', nro = '$nro', piso = '$piso', dpto = '$dpto', entrecalle1 = '$entrecalle1', entrecalle2 = '$entrecalle2',telefono = '$telefono', celular= '$celular', email = '$email', en_operacion = 0, en_mision= 0, en_operacion = 0, codigo_postal = '$codigo_postal', fecha_nacimiento = '$fecha_nacimiento', observaciones='$observaciones' , cuit='$cuit' WHERE id_cliente=$id_cliente_act;";
		}	
		if($tx_no_acreditada==1){
			$tx_no_acreditada =0;
		}else{
			$tx_no_acreditada=1;
		}
		if ( $id_canal == 4 )
        {
			$us = $this->ion_auth->user()->row();
			$usuario_comisiona = $us->id;
           
        }
		if ( $id_canal == 6 )
        {
			$us = $this->ion_auth->user()->row();
			$usuario_comisiona = $us->id;

			$resultado= $this->db->query("(SELECT DISTINCT view_misiones_activas.id_usuario from view_misiones_activas WHERE ( view_misiones_activas.id_cliente = $id_cliente_act ));");  
		 	if (!$resultado)
				echo $resultado;
			if($resultado->num_rows()>0){
				$resultado = $resultado ->result();
				$usuario_comisiona= $resultado[0]->id_usuario;
			}
		}
		// Pedidos
		$consulta_pedidos = "";   
		$consulta_revendedor = ""; 
		if ($nuevo_cliente == 'false')
			if ( $tipo_envio == "Showroom" ){
				$consulta_pedidos = "INSERT INTO pedidos (no_factura, referencia, id_cliente, id_canal, id_usuario, fecha_solicitud, reg_cancelado, armado, id_tipo_factura, recargo, calle_entrega,nro_entrega, piso_entrega, dpto_entrega, entrecalle1_entrega, entrecalle2_entrega, iva, forma_pago, provincia_entrega, municipio_entrega,acreditado,cupon_nro,cupon_promo,id_medio_cobranza,usuario_comisiona,incluye_seguro) VALUES ('$no_factura', '$id_transaccion',$id_cliente_act, $id_canal, $id_usuario,  FROM_UNIXTIME(UNIX_TIMESTAMP(), '%Y-%m-%d %H.%i.%s'), 0,1,$tipo_factura,$recargo, '$calle_entrega','$nro_entrega', '$piso_entrega', '$dpto_entrega', '$entrecalle1_entrega', '$entrecalle2_entrega',$monto_iva, $forma_pago, '', '',$tx_no_acreditada,'$cupon_nro',
				'$cupon_promo',$frm_medio,$usuario_comisiona,$incluye_seguro);";   
			}else{
				$consulta_pedidos = "INSERT INTO pedidos (no_factura, referencia, id_cliente, id_canal, id_usuario, fecha_solicitud, reg_cancelado, armado, id_tipo_factura, recargo, calle_entrega,nro_entrega, piso_entrega, dpto_entrega, entrecalle1_entrega, entrecalle2_entrega, iva, forma_pago, provincia_entrega, municipio_entrega,acreditado,cupon_nro,cupon_promo,id_medio_cobranza,usuario_comisiona,incluye_seguro) VALUES ('$nro_remito', '$id_transaccion',$id_cliente_act, $id_canal, $id_usuario,  FROM_UNIXTIME(UNIX_TIMESTAMP(), '%Y-%m-%d %H.%i.%s'), 0,0,$tipo_factura,$recargo, '$calle_entrega','$nro_entrega', '$piso_entrega', '$dpto_entrega', '$entrecalle1_entrega', '$entrecalle2_entrega',$monto_iva, $forma_pago, '$provincia_entrega', '$municipio_entrega',$tx_no_acreditada,'$cupon_nro',
				'$cupon_promo',$frm_medio, $usuario_comisiona,$incluye_seguro);";   
			}
		    
	    else{
			if ( $tipo_envio == "Showroom" ){
				$consulta_pedidos = "INSERT INTO pedidos ( no_factura, referencia, id_cliente, id_canal, id_usuario,  fecha_solicitud, reg_cancelado, armado, id_tipo_factura, recargo, calle_entrega,nro_entrega, piso_entrega, dpto_entrega, entrecalle1_entrega, entrecalle2_entrega,iva, forma_pago, provincia_entrega, municipio_entrega,acreditado,cupon_nro,cupon_promo,id_medio_cobranza,usuario_comisiona,incluye_seguro) VALUES ('$no_factura', '$id_transaccion', LAST_INSERT_ID(), $id_canal, $id_usuario, FROM_UNIXTIME(UNIX_TIMESTAMP(), '%Y-%m-%d %H.%i.%s'), 0,1,$tipo_factura,$recargo, '$calle_entrega', '$nro_entrega', '$piso_entrega', '$dpto_entrega', '$entrecalle1_entrega', '$entrecalle2_entrega',$monto_iva, $forma_pago, '', '', $tx_no_acreditada,'$cupon_nro',
				'$cupon_promo',$frm_medio, $usuario_comisiona,$incluye_seguro);";
			}else{
				$consulta_pedidos = "INSERT INTO pedidos ( no_factura, referencia, id_cliente, id_canal, id_usuario,  fecha_solicitud, reg_cancelado, armado, id_tipo_factura, recargo, calle_entrega,nro_entrega, piso_entrega, dpto_entrega, entrecalle1_entrega, entrecalle2_entrega,iva, forma_pago, provincia_entrega, municipio_entrega,acreditado,cupon_nro,cupon_promo,id_medio_cobranza,usuario_comisiona,incluye_seguro) VALUES ('$nro_remito', '$id_transaccion', LAST_INSERT_ID(), $id_canal, $id_usuario, FROM_UNIXTIME(UNIX_TIMESTAMP(), '%Y-%m-%d %H.%i.%s'), 0,0,$tipo_factura,$recargo, '$calle_entrega', '$nro_entrega', '$piso_entrega', '$dpto_entrega', '$entrecalle1_entrega', '$entrecalle2_entrega',$monto_iva, $forma_pago, '$provincia_entrega', '$municipio_entrega', $tx_no_acreditada,'$cupon_nro',
				'$cupon_promo',$frm_medio, $usuario_comisiona,$incluye_seguro);";
			}
		    
			if ($revendedor == 'true'){
				$groupRev = array('ConsultorRV');
				if($this->ion_auth->in_group($groupRev)){
					$id_rev = $this->M_operaciones->obt_superior($id_usuario);
					$consulta_revendedor = "INSERT INTO revendedores(id_usuario, id_cliente) VALUES ($id_rev, ID_ULTIMO_CLI);";
				}else
			$consulta_revendedor = "INSERT INTO revendedores(id_usuario, id_cliente) VALUES ($id_usuario, ID_ULTIMO_CLI);";
			}
		}
		
		// Detalles y productos
		$consulta_detalles = array();
		$consulta_productos = array();
        $importe_total = 0;
		for ($i=0; $i<count($dt_productos); $i++ )
		{
		   $consulta_detalles[$i] = "INSERT INTO detalles (id_pedido, id_producto, id_campana, id_color, cantidad, precio, descuento, reg_cancelado, descuento_vip, incremento, notas) VALUES (ID_ULTIMO_PED, " . $dt_productos[$i] . ", " . $dt_campanas[$i] . ", ". $dt_colores[$i] . ", "  . $dt_cantidades[$i]. ", " . $dt_precios[$i] . ", " . $dt_descuentos[$i]  . ", 0,".$dt_descuentos_vip[$i].", " . $dt_incrementos[$i].", '". $dt_notas[$i]."');";
           $importe_total += $dt_precios[$i] * $dt_cantidades[$i]-$dt_descuentos[$i]-$dt_descuentos_vip[$i]+$dt_incrementos[$i];

			$consulta_productos[$i]  ="UPDATE productos SET existencia= existencia-".$dt_cantidades[$i]." WHERE id_producto=".$dt_productos[$i];     
		}
		
		// Entrega
		$consulta_entrega = "";
		if ( $tipo_envio == "Showroom" )
 	       $consulta_entrega = "INSERT INTO entregas_directas (id_pedido, despachado, reg_cancelado,id_local) VALUES (ID_ULTIMO_PED, 0, 0, $id_local);";
		else
		   $consulta_entrega = "INSERT INTO entregas_envios (id_pedido, id_empresa, id_estado, id_envio, fecha, reg_cancelado, id_tipo_empresa,sucursal, operativa,id_sucursal) VALUES (ID_ULTIMO_PED, $id_empresa, 0, '', FROM_UNIXTIME(UNIX_TIMESTAMP(), '%Y-%m-%d %H.%i.%s'), 0,$tipo_empresa, '$nombre_sucursal',' $nombre_operativa',$id_sucursal);";
        
        // Consecutivo
        $consulta_consecutivo = "UPDATE sys_parametros SET valor = valor + 1 WHERE parametro = 'CONSECUTIVO_VENTA'";
        
        // Comisiones
        $consulta_comision = "";
		$consulta_mision = "";
		$consulta_cliente_mision = "";
        if ( $id_canal == 4 )
        {
           $valor_com = $importe_total * ($com_atencion/100);
		    //$valor = $this->M_configuracion->format_moneda($valor_com);
		   // $valor_com = $valor[0]->money_format; 
           /*$consulta_comision = "INSERT INTO comisiones_atencion(id_usuario, id_pedido, fecha, valor, reg_cancelado) VALUES ($id_usuario, ID_ULTIMO_PED, FROM_UNIXTIME(UNIX_TIMESTAMP(), '%Y-%m-%d %H.%i.%s'), $valor_com, 0)";*/
        }
        
        if ( $id_canal == 6 )
        {
			$us = $this->ion_auth->user()->row();
			$id_user = $us->id;

			$resultado= $this->db->query("(SELECT DISTINCT view_misiones_activas.id_usuario from view_misiones_activas WHERE ( view_misiones_activas.id_cliente = $id_cliente_act ));");  
		 	if (!$resultado)
				echo $resultado;
			if($resultado->num_rows()>0){
				$resultado = $resultado ->result();
				$user_mision= $resultado[0]->id_usuario;
			}	else{
				$user_mision=$id_user;
			}
			
		 	
          $valor_com = $importe_total * ($com_mision/100); 		  
		   
		 // $valor = $this->M_configuracion->format_moneda($valor_com);
		  //$valor_com = $valor[0]->money_format;

		  /*$consulta_comision = "INSERT INTO `comisiones_mision`(`id_usuario`, `id_pedido`, `fecha`, `valor`, `reg_cancelado`) VALUES ($user_mision,ID_ULTIMO_PED,FROM_UNIXTIME(UNIX_TIMESTAMP(), '%Y-%m-%d %H.%i.%s'),$valor_com,0)";*/
		  
		   // Como es una mision
		   if($pedido_mision != ''){
				$consulta_mision = "UPDATE `misiones` SET `id_nueva_venta`=ID_ULTIMO_PED, exitosa=1 WHERE id_pedido=$pedido_mision";
		   }
		   
		   $consulta_cliente_mision = "UPDATE `clientes` SET `en_mision`= 0 WHERE id_cliente = $id_cliente_act";
		}
		

		// Inicio de la transacción
		$this->db->trans_begin();

		    if ($nuevo_cliente == 'true')
			{				
		        $this->db->query($consulta_clientes);
				$id_ultimo_cli = $this->db->insert_id();
				//$id_ultimo_cli=$id_ultimo_cli-1;
			}else{
				$this->db->query($consulta_clientes);
			}
		   
            $this->db->query($consulta_pedidos);
            $id_ultimo_ped = $this->db->insert_id();
        	
            if ($consulta_comision != "")
               $this->db->query( str_replace("ID_ULTIMO_PED", $id_ultimo_ped, $consulta_comision) );
        
            for ($i=0; $i<count($consulta_detalles); $i++ ){
                $this->db->query( str_replace("ID_ULTIMO_PED", $id_ultimo_ped, $consulta_detalles[$i]) );				
			}

			for ($i=0; $i<count($consulta_productos); $i++ ){
                $this->db->query($consulta_productos[$i]);
			}
            $this->db->query(str_replace("ID_ULTIMO_PED", $id_ultimo_ped, $consulta_entrega));
			
			if ($consulta_mision != "")
               $this->db->query( str_replace("ID_ULTIMO_PED", $id_ultimo_ped, $consulta_mision) );
			if ($consulta_cliente_mision != "")
               $this->db->query(  $consulta_cliente_mision );

		if ($consulta_revendedor != "")
            	$this->db->query(str_replace("ID_ULTIMO_CLI", $id_ultimo_cli, $consulta_revendedor));
            
            $this->db->query($consulta_consecutivo);
		
			

		$this->db->trans_complete();
		// Fin de transacción
		
		if ($this->db->trans_status() === FALSE){

	       $this->db->trans_rollback();
		  
		}
		else
		   $this->db->trans_commit();
		
		return $id_ultimo_ped;
		
	}
	public function registrar_venta_rev(
		$nuevo_cliente,
		$id_cliente_act,
		$id_municipio, 
		$dni, 
		$nombre, 
		$apellidos, 
		$telefono,
		$celular, 
		$codigo_postal, 
		$calle, 
		$nro, 
		$piso, 
		$dpto, 
		$entrecalle1, 
		$entrecalle2, 
		$email,
		$revendedor,
		$fecha_nacimiento,
		$id_canal,
		$no_factura,
		$id_transaccion,
		$fecha_venta,
		$recargo,
		$monto_iva,
		$tipo_factura,
		$calle_entrega,
		$nro_entrega,
		$piso_entrega,
		$dpto_entrega,
		$entrecalle1_entrega,
		$entrecalle2_entrega,
		$municipio_entrega,
		$provincia_entrega,
		$dt_productos,
		$dt_precios,
		$dt_cantidades,
		$dt_descuentos,
		$dt_descuentos_vip,
		$dt_incrementos,
		$dt_campanas,
		$dt_colores,
		$total_productos,
		$pedido_mision,
		$tipo_envio,
		$id_empresa,
		$tipo_empresa,
		$com_atencion,
		$com_mision, 
		$forma_pago,
		$observaciones,
		$cuit,
		$cupon_nro,
		$cupon_promo,
		$nro_remito,
		$tx_no_acreditada,
		$frm_medio 
 )
 {
	 $nombre = str_replace("'","´",$nombre);
	 $apellidos = str_replace("'","´",$apellidos);

	 // Usuario actual
	 $us = $this->ion_auth->user()->row();
	 $id_usuario = $us->id;
	 $canal = $this->obt_nombre_canal($id_canal);
	 if($id_canal == 4 || $id_canal == 6) $canal = 'SISTEMA DVIGI';
	 if($id_cliente_act == ''){
		 $nuevo_cliente = 'true';
	 }
	 $cliente_nuevo_rev = '';
	 // comprobar si el cleinte supuestamentenuevo esta en el sistema
	 if ( $nuevo_cliente == 'true' ){
		
		 $consulta_ak="select id_cliente from clientes where dni='$dni' or email = '$email'";
		 $resultado = $this->db->query($consulta_ak);
		if (!$resultado)
			echo $resultado;
		foreach ($resultado->result() as $key) {
			# code...
			$nuevo_cliente = 'false';
			$id_cliente_act = $key->id_cliente;
			$cliente_nuevo_rev = $key->id_cliente;
		}
	 }
	 // Clientes
	 $consulta_clientes = "";
	 if ( $nuevo_cliente == 'true' )
		 $consulta_clientes = "INSERT INTO clientes ( id_municipio, dni, nombre, apellidos, calle, nro, piso, dpto, entrecalle1, entrecalle2, telefono, celular, email, en_operacion, en_mision, reg_cancelado, codigo_postal, fecha_nacimiento, origen, observaciones, cuit ) VALUES ($id_municipio, '$dni', '$nombre', '$apellidos', '$calle', '$nro', '$piso', '$dpto', '$entrecalle1', '$entrecalle2','$telefono', '$celular', '$email', 0, 0, 0,'$codigo_postal', '$fecha_nacimiento','$canal', '$observaciones', '$cuit');";
	 else{
		 $consulta_clientes= "UPDATE clientes SET id_municipio= $id_municipio, dni = '$dni', nombre = '$nombre', apellidos = '$apellidos', calle = '$calle', nro = '$nro', piso = '$piso', dpto = '$dpto', entrecalle1 = '$entrecalle1', entrecalle2 = '$entrecalle2',telefono = '$telefono', celular= '$celular', email = '$email', en_operacion = 0, en_mision= 0, en_operacion = 0, codigo_postal = '$codigo_postal', fecha_nacimiento = '$fecha_nacimiento', observaciones='$observaciones' , cuit='$cuit' WHERE id_cliente=$id_cliente_act;";
	 }	
	/* if($tx_no_acreditada==1){
		 $tx_no_acreditada =0;
	 }else{
		 $tx_no_acreditada=1;
	 }*/
	 
	 // Pedidos
	 $consulta_pedidos = "";   
	 $consulta_revendedor = ""; 
	 if ($nuevo_cliente == 'false')
		 if ( $tipo_envio == "Showroom" ){
			 $consulta_pedidos = "INSERT INTO pedidos (no_factura, referencia, id_cliente, id_canal, id_usuario, fecha_solicitud, reg_cancelado, armado, id_tipo_factura, recargo, calle_entrega,nro_entrega, piso_entrega, dpto_entrega, entrecalle1_entrega, entrecalle2_entrega, iva, forma_pago, provincia_entrega, municipio_entrega,acreditado,cupon_nro,cupon_promo,id_medio_cobranza) VALUES ('$no_factura', '$id_transaccion',$id_cliente_act, $id_canal, $id_usuario,  FROM_UNIXTIME(UNIX_TIMESTAMP(), '%Y-%m-%d %H.%i.%s'), 0,1,$tipo_factura,$recargo, '$calle_entrega','$nro_entrega', '$piso_entrega', '$dpto_entrega', '$entrecalle1_entrega', '$entrecalle2_entrega',$monto_iva, $forma_pago, '', '',$tx_no_acreditada,'$cupon_nro',
			 '$cupon_promo',$frm_medio);";   
		 }else{
			 $consulta_pedidos = "INSERT INTO pedidos (no_factura, referencia, id_cliente, id_canal, id_usuario, fecha_solicitud, reg_cancelado, armado, id_tipo_factura, recargo, calle_entrega,nro_entrega, piso_entrega, dpto_entrega, entrecalle1_entrega, entrecalle2_entrega, iva, forma_pago, provincia_entrega, municipio_entrega,acreditado,cupon_nro,cupon_promo,id_medio_cobranza) VALUES ('$nro_remito', '$id_transaccion',$id_cliente_act, $id_canal, $id_usuario,  FROM_UNIXTIME(UNIX_TIMESTAMP(), '%Y-%m-%d %H.%i.%s'), 0,0,$tipo_factura,$recargo, '$calle_entrega','$nro_entrega', '$piso_entrega', '$dpto_entrega', '$entrecalle1_entrega', '$entrecalle2_entrega',$monto_iva, $forma_pago, '$provincia_entrega', '$municipio_entrega',$tx_no_acreditada,'$cupon_nro',
			 '$cupon_promo',$frm_medio);";   
		 }
		 
	 else{
		 if ( $tipo_envio == "Showroom" ){
			 $consulta_pedidos = "INSERT INTO pedidos ( no_factura, referencia, id_cliente, id_canal, id_usuario,  fecha_solicitud, reg_cancelado, armado, id_tipo_factura, recargo, calle_entrega,nro_entrega, piso_entrega, dpto_entrega, entrecalle1_entrega, entrecalle2_entrega,iva, forma_pago, provincia_entrega, municipio_entrega,acreditado,cupon_nro,cupon_promo,id_medio_cobranza) VALUES ('$no_factura', '$id_transaccion', LAST_INSERT_ID(), $id_canal, $id_usuario, FROM_UNIXTIME(UNIX_TIMESTAMP(), '%Y-%m-%d %H.%i.%s'), 0,1,$tipo_factura,$recargo, '$calle_entrega', '$nro_entrega', '$piso_entrega', '$dpto_entrega', '$entrecalle1_entrega', '$entrecalle2_entrega',$monto_iva, $forma_pago, '', '', $tx_no_acreditada,'$cupon_nro',
			 '$cupon_promo',$frm_medio);";
		 }else{
			 $consulta_pedidos = "INSERT INTO pedidos ( no_factura, referencia, id_cliente, id_canal, id_usuario,  fecha_solicitud, reg_cancelado, armado, id_tipo_factura, recargo, calle_entrega,nro_entrega, piso_entrega, dpto_entrega, entrecalle1_entrega, entrecalle2_entrega,iva, forma_pago, provincia_entrega, municipio_entrega,acreditado,cupon_nro,cupon_promo,id_medio_cobranza) VALUES ('$nro_remito', '$id_transaccion', LAST_INSERT_ID(), $id_canal, $id_usuario, FROM_UNIXTIME(UNIX_TIMESTAMP(), '%Y-%m-%d %H.%i.%s'), 0,0,$tipo_factura,$recargo, '$calle_entrega', '$nro_entrega', '$piso_entrega', '$dpto_entrega', '$entrecalle1_entrega', '$entrecalle2_entrega',$monto_iva, $forma_pago, '$provincia_entrega', '$municipio_entrega', $tx_no_acreditada,'$cupon_nro',
			 '$cupon_promo',$frm_medio);";
		 }
		 
		 
	 }
	 //if ($revendedor == 'true'){
		$groupRev = array('ConsultorRV','ConsultorRVInt');
		if ( $nuevo_cliente == 'true' )
			$consulta_revendedor = "INSERT INTO revendedores(id_usuario, id_cliente) VALUES ($id_usuario, ID_ULTIMO_CLI) ;";
		else{
			if($cliente_nuevo_rev != '')
			 	$consulta_revendedor = "INSERT INTO revendedores(id_usuario, id_cliente) VALUES ($id_usuario, $id_cliente_act) ;";
		}
			
	//}
	 // Detalles y productos
	 $consulta_detalles = array();
	 $consulta_productos = array();
	 $importe_total = 0;
	 for ($i=0; $i<count($dt_productos); $i++ )
	 {
		$consulta_detalles[$i] = "INSERT INTO detalles (id_pedido, id_producto, id_campana, id_color, cantidad, precio, descuento, reg_cancelado, descuento_vip, incremento) VALUES (ID_ULTIMO_PED, " . $dt_productos[$i] . ", " . $dt_campanas[$i] . ", ". $dt_colores[$i] . ", "  . $dt_cantidades[$i]. ", " . $dt_precios[$i] . ", " . $dt_descuentos[$i]  . ", 0,".$dt_descuentos_vip[$i].", " . $dt_incrementos[$i].");";
		$importe_total += $dt_precios[$i] * $dt_cantidades[$i]-$dt_descuentos[$i]-$dt_descuentos_vip[$i]+$dt_incrementos[$i];

		 $consulta_productos[$i]  ="UPDATE producto_revendedores SET existencia= existencia-".$dt_cantidades[$i]." WHERE id_producto=".$dt_productos[$i]." and id_revendedor=".$id_usuario ;     
	 }
	 
	 // Entrega
	 $consulta_entrega = "";
	 if ( $tipo_envio == "Showroom" )
		 $consulta_entrega = "INSERT INTO entregas_directas (id_pedido, despachado, reg_cancelado) VALUES (ID_ULTIMO_PED, 0, 0);";
	 else
		$consulta_entrega = "INSERT INTO entregas_envios (id_pedido, id_empresa, id_estado, id_envio, fecha, reg_cancelado, id_tipo_empresa) VALUES (ID_ULTIMO_PED, $id_empresa, 0, '', FROM_UNIXTIME(UNIX_TIMESTAMP(), '%Y-%m-%d %H.%i.%s'), 0,$tipo_empresa);";
	 
	 // Consecutivo
	 $consulta_consecutivo = "UPDATE sys_parametros SET valor = valor + 1 WHERE parametro = 'CONSECUTIVO_VENTA'";
	 
	 // Comisiones
	 $consulta_comision = "";
	 $consulta_mision = "";
	 $consulta_cliente_mision = "";
	/* if ( $id_canal == 4 )
	 {
		$valor_com = $importe_total * ($com_atencion/100);
		 //$valor = $this->M_configuracion->format_moneda($valor_com);
		// $valor_com = $valor[0]->money_format; 
		$consulta_comision = "INSERT INTO comisiones_atencion(id_usuario, id_pedido, fecha, valor, reg_cancelado) VALUES ($id_usuario, ID_ULTIMO_PED, FROM_UNIXTIME(UNIX_TIMESTAMP(), '%Y-%m-%d %H.%i.%s'), $valor_com, 0)";
	 }*/
	 
	 if ( $id_canal == 6 )
	 {
		 $resultado= $this->db->query("(SELECT DISTINCT view_misiones_activas.id_usuario from view_misiones_activas WHERE ( view_misiones_activas.id_cliente = $id_cliente_act ));");  
		  if (!$resultado)
			 echo $resultado;
		 $resultado = $resultado -> result();
		 $user_mision= $resultado[0]->id_usuario;

	   $valor_com = $importe_total * ($com_mision/100); 		  
		
	  // $valor = $this->M_configuracion->format_moneda($valor_com);
	   //$valor_com = $valor[0]->money_format;

	  /* $consulta_comision = "INSERT INTO `comisiones_mision`(`id_usuario`, `id_pedido`, `fecha`, `valor`, `reg_cancelado`) VALUES ($user_mision,ID_ULTIMO_PED,FROM_UNIXTIME(UNIX_TIMESTAMP(), '%Y-%m-%d %H.%i.%s'),$valor_com,0)";*/
	   
		// Como es una mision
		if($pedido_mision != ''){
			 $consulta_mision = "UPDATE `misiones` SET `id_nueva_venta`=ID_ULTIMO_PED, exitosa=1 WHERE id_pedido=$pedido_mision";
		}
		
		$consulta_cliente_mision = "UPDATE `clientes` SET `en_mision`= 0 WHERE id_cliente = $id_cliente_act";
	 }
	

	 // Inicio de la transacción
	 $this->db->trans_begin();

		 if ($nuevo_cliente == 'true')
		 {				
			 $this->db->query($consulta_clientes);
			 $id_ultimo_cli = $this->db->insert_id();
			 //$id_ultimo_cli=$id_ultimo_cli-1;
			 if ($consulta_revendedor != "")
			 	$this->db->query(str_replace("ID_ULTIMO_CLI", $id_ultimo_cli, $consulta_revendedor));
		 }else{
			 $this->db->query($consulta_clientes);
			 if ($consulta_revendedor != "")
			 	$this->db->query( $consulta_revendedor);
		 }
		
		 $this->db->query($consulta_pedidos);
		 $id_ultimo_ped = $this->db->insert_id();
		 
		 if ($consulta_comision != "")
			$this->db->query( str_replace("ID_ULTIMO_PED", $id_ultimo_ped, $consulta_comision) );
	 
		 for ($i=0; $i<count($consulta_detalles); $i++ ){
			 $this->db->query( str_replace("ID_ULTIMO_PED", $id_ultimo_ped, $consulta_detalles[$i]) );				
		 }

		 for ($i=0; $i<count($consulta_productos); $i++ ){
			 $this->db->query($consulta_productos[$i]);
		 }
		 $this->db->query(str_replace("ID_ULTIMO_PED", $id_ultimo_ped, $consulta_entrega));
		 
		 if ($consulta_mision != "")
			$this->db->query( str_replace("ID_ULTIMO_PED", $id_ultimo_ped, $consulta_mision) );
		 if ($consulta_cliente_mision != "")
			$this->db->query(  $consulta_cliente_mision );

	
		 
		 $this->db->query($consulta_consecutivo);
		

	 $this->db->trans_complete();
	 // Fin de transacción
	 
	 if ($this->db->trans_status() === FALSE){

		$this->db->trans_rollback();
	   
	 }
	 else
		$this->db->trans_commit();
	 
	 return $id_ultimo_ped;
	 
 }
	public function registrar_venta_terceros(
	   	$nuevo_cliente,
		$id_cliente_act,
		$id_municipio, 
		$dni, 
		$nombre, 
		$apellidos, 
		$telefono, 
		$celular,
		$codigo_postal, 
		$calle, 
		$nro, 
		$piso, 
		$dpto, 
		$entrecalle1, 
		$entrecalle2, 
		$email,
		$revendedor,
		$fecha_nacimiento,
		$id_canal,
		$no_factura,
		$id_transaccion,
		$fecha_venta,
		 $recargo,
		 $monto_iva,
		 $tipo_factura,
		 $calle_entrega,
		 $nro_entrega,
		 $piso_entrega,
		 $dpto_entrega,
		 $entrecalle1_entrega,
		 $entrecalle2_entrega,
		$dt_productos,
		$dt_precios,
		$dt_cantidades,
		$dt_descuentos,
		$dt_campanas,
		$dt_colores,
		$total_productos,
		
		$com_atencion,
		$com_mision 
		
	)
	{
		$nombre = str_replace("'","´",$nombre);
		$apellidos = str_replace("'","´",$apellidos);

		// Usuario actual
		$us = $this->ion_auth->user()->row();
		//$id_usuario = $us->id;
		$id_usuario = 1;
		$canal = $this->obt_nombre_canal($id_canal);
		if($id_canal == 4 || $id_canal == 6) $canal = 'SISTEMA DVIGI';

		// Clientes
		$consulta_clientes = "";
		if ( $nuevo_cliente == 'true' )
		    $consulta_clientes = "INSERT INTO clientes ( id_municipio, dni, nombre, apellidos, calle, nro, piso, dpto, entrecalle1, entrecalle2, telefono, celular, email, en_operacion, en_mision, reg_cancelado, codigo_postal, fecha_nacimiento, origen ) VALUES ($id_municipio, '$dni', '$nombre', '$apellidos', '$calle', '$nro', '$piso', '$dpto', '$entrecalle1', '$entrecalle2','$telefono', '$celular', '$email', 0, 0, 0,'$codigo_postal', '$fecha_nacimiento', '$canal')";
		else{
			$consulta_clientes= "UPDATE clientes SET id_municipio= $id_municipio, dni = '$dni', nombre = '$nombre', apellidos = '$apellidos', calle = '$calle', nro = '$nro', piso = '$piso', dpto = '$dpto', entrecalle1 = '$entrecalle1', entrecalle2 = '$entrecalle2',telefono = '$telefono', celular = '$celular', email = '$email', en_operacion = 0, en_mision= 0, en_operacion = 0, codigo_postal = '$codigo_postal', fecha_nacimiento = '$fecha_nacimiento' WHERE id_cliente=$id_cliente_act";
		}	
		// Pedidos
		$consulta_pedidos = "";   
		$consulta_revendedor = "";   
		
		if ($nuevo_cliente == 'false')
		    $consulta_pedidos = "INSERT INTO pedidos (no_factura, referencia, id_cliente, id_canal, id_usuario, fecha_solicitud, reg_cancelado, armado, id_tipo_factura, recargo, calle_entrega,nro_entrega, piso_entrega, dpto_entrega, entrecalle1_entrega, entrecalle2_entrega,iva) VALUES ('$no_factura','$id_transaccion',$id_cliente_act, $id_canal, $id_usuario,  '$fecha_venta', 0,1,1,0,'', '', '','', '', '', 0);";   
	    else{
		    $consulta_pedidos = "INSERT INTO pedidos ( no_factura, referencia, id_cliente, id_canal, id_usuario,  fecha_solicitud, reg_cancelado, armado, id_tipo_factura, recargo,calle_entrega,nro_entrega, piso_entrega, dpto_entrega, entrecalle1_entrega, entrecalle2_entrega, iva) VALUES ('$no_factura', '$id_transaccion', LAST_INSERT_ID(), $id_canal, $id_usuario, '$fecha_venta', 0,1,1,0,'', '', '','', '', '', 0);";
			if ($revendedor == 'true')
				$consulta_revendedor = "INSERT INTO revendedores(id_usuario, id_cliente) VALUES ($id_usuario, ID_ULTIMO_CLI);";
			}
		
		// Detalles
		$consulta_detalles = array();
        $importe_total = 0;
		for ($i=0; $i<count($dt_productos); $i++ )
		{
		   $consulta_detalles[$i] = "INSERT INTO detalles (id_pedido, id_producto, id_campana, id_color, cantidad, precio, descuento, reg_cancelado) VALUES (ID_ULTIMO_PED, " . $dt_productos[$i] . ", 1, ". $dt_colores[$i] . ", "  . $dt_cantidades[$i]. ", 0, 0, 0);";
           $importe_total += 0;    
		}
		
		// Entrega
		/*$consulta_entrega = "";
		if ( $tipo_envio == "Directo" )
 	       $consulta_entrega = "INSERT INTO entregas_directas (id_pedido, despachado, reg_cancelado) VALUES (ID_ULTIMO_PED, 0, 0);";
		else
		   $consulta_entrega = "INSERT INTO entregas_envios (id_pedido, id_empresa, id_estado, id_envio, fecha, reg_cancelado) VALUES (ID_ULTIMO_PED, $id_empresa, 1, '', curdate(), 0);";
        */
        // Consecutivo
        $consulta_consecutivo = "UPDATE sys_parametros SET valor = valor + 1 WHERE parametro = 'CONSECUTIVO_TERCERO'";
		
		
		$this->db->trans_begin();

		    if ( $nuevo_cliente == 'true' )
			{
		        $this->db->query($consulta_clientes);
				$id_ultimo_cli = $this->db->insert_id();
				$id_ultimo_cli=$id_ultimo_cli-1;
			}else{
				$this->db->query($consulta_clientes);
			}
		   
            $this->db->query($consulta_pedidos);
            $id_ultimo_ped = $this->db->insert_id();
        	
            /*if ($consulta_comision != "")
               $this->db->query( str_replace("ID_ULTIMO_PED", $id_ultimo_ped, $consulta_comision) );
        */
            for ($i=0; $i<count($consulta_detalles); $i++ )
                $this->db->query( str_replace("ID_ULTIMO_PED", $id_ultimo_ped, $consulta_detalles[$i]) );
        
            //$this->db->query(str_replace("ID_ULTIMO_PED", $id_ultimo_ped, $consulta_entrega));
			
		if ($consulta_revendedor != "")
            	$this->db->query(str_replace("ID_ULTIMO_CLI", $id_ultimo_ped, $consulta_revendedor));
            
            $this->db->query($consulta_consecutivo);
		
		
		$this->db->trans_complete();
		// Fin de transacción
		
		if ($this->db->trans_status() === FALSE)
	       $this->db->trans_rollback();
		else
		   $this->db->trans_commit();
		
		return $this->db->trans_status();
		
	}
	public function obtener_misiones_activas(){		
		$texto_consulta = "SELECT * FROM `view_misiones_activas`;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function obtener_pedidos($usuario, $anno, $mes){		
		$texto_consulta = "SELECT `id`, `id_pedido`, `no_factura`, `producto`, `importe`, `recargo`, `OCA`, `armado`, `despachado`, `dni`, `nombre`, `apellidos`, `color`, `id_cliente`, `iva`, `anno`, `mes`, `id_usuario`, `id_entrega`, `precio_base`, `sku`, `id_canal`, `canal`, `envio_por_coordinar`, `fecha_solicitud`, `acreditado`, `id_medio_cobranza`, `incluye_seguro` FROM `view_pedidos_union` where id_usuario= $usuario and despachado = 0 order by id_pedido;";
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function obtener_pedidos_rodo($usuario, $anno, $mes){		
		$texto_consulta = "SELECT `id`, `id_pedido`, `no_factura`, `producto`, `importe`, `recargo`, `OCA`, `armado`, `despachado`, `dni`, `nombre`, `apellidos`, `color`, `id_cliente`, `iva`, `anno`, `mes`, `id_usuario`, `id_entrega`, `precio_base`, `sku`, `id_canal`, `canal`, `envio_por_coordinar`, `fecha_solicitud`, `acreditado`, `id_medio_cobranza` FROM `view_pedidos_union` where id_usuario= $usuario and despachado = 0 group by id_pedido;";
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function obtener_pedidos_rev($usuario, $anno, $mes){		
		$texto_consulta = "SELECT `id`, `id_pedido`, `no_factura`, `producto`, `importe`, `recargo`, `OCA`, `armado`, `despachado`, `dni`, `nombre`, `apellidos`, `color`, `id_cliente`, `iva`, `anno`, `mes`, `id_usuario`, `id_entrega`, `precio_base`, `sku`, `id_canal`, `canal`, `envio_por_coordinar`, `fecha_solicitud`, `acreditado`, `id_medio_cobranza` FROM `view_pedido_directo_revendedor` where  id_usuario= $usuario and email not in (select email from view_usuarios_clientes) order by id_pedido;";
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function obtener_pedidos_nombre($usuario, $fnombre, $ftelefono, $femail, $fdni){		
		$texto_consulta = "SELECT `id`, `id_pedido`, `no_factura`, `producto`, `importe`, `recargo`, `OCA`, `armado`, `despachado`, `dni`, `nombre`, `apellidos`, `color`, `id_cliente`, `iva`, `anno`, `mes`, `id_usuario`, `id_entrega`, `precio_base`, `sku`, `id_canal`, `canal`, `envio_por_coordinar`, `fecha_solicitud`, `acreditado`, `id_medio_cobranza`, `incluye_seguro` FROM `view_pedidos_union` where id_usuario= $usuario and despachado = 0 ";
		if($fnombre != ''){
			$texto_consulta = $texto_consulta." and (nombre like '%$fnombre%' or apellidos like '%$fnombre%')";
		}
		if($ftelefono != ''){
			$texto_consulta = $texto_consulta." and (telefono like '%$ftelefono%' or celular like '%$ftelefono%')";
		}
		if($femail != ''){
			$texto_consulta = $texto_consulta." and email like '%$femail%'";
		}
		if($fdni != ''){
			$texto_consulta = $texto_consulta." and dni like '%$fdni%'";
		}
		$texto_consulta = $texto_consulta."  order by id_pedido;";
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function obtener_pedidos_rev_nombre($usuario, $fnombre){		
		$texto_consulta = "SELECT `id`, `id_pedido`, `no_factura`, `producto`, `importe`, `recargo`, `OCA`, `armado`, `despachado`, `dni`, `nombre`, `apellidos`, `color`, `id_cliente`, `iva`, `anno`, `mes`, `id_usuario`, `id_entrega`, `precio_base`, `sku`, `id_canal`, `canal`, `envio_por_coordinar`, `fecha_solicitud`, `acreditado`, `id_medio_cobranza` FROM `view_pedido_directo_revendedor` where (nombre like '%$fnombre%' or apellidos like '%$fnombre%') and id_usuario= $usuario and despachado = 0 and email not in (select email from view_usuarios_clientes) order by id_pedido;";
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado; 
		
		return $resultado;
	}
	public function obtener_pedidos_ok($usuario,$anno, $mes){			
		$texto_consulta = "SELECT `id`, `id_pedido`, `no_factura`, `producto`, `importe`, `recargo`, `OCA`, `armado`, `despachado`, `dni`, `nombre`, `apellidos`, `color`, `id_cliente`, `iva`, `anno`, `mes`, `id_usuario`, `id_entrega`, `precio_base`, `sku`, `id_canal`, `canal`, `envio_por_coordinar`, `fecha_solicitud`, `acreditado`, `id_medio_cobranza`,`incluye_seguro` FROM `view_pedidos_union` where id_usuario= $usuario and despachado = 1 and anno=$anno and mes=$mes and importe <>0 order by id_pedido;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function obtener_pedidos_rev_ok($usuario,$anno, $mes){			
		$texto_consulta = "SELECT `id`, `id_pedido`, `no_factura`, `producto`, `importe`, `recargo`, `OCA`, `armado`, `despachado`, `dni`, `nombre`, `apellidos`, `color`, `id_cliente`, `iva`, `anno`, `mes`, `id_usuario`, `id_entrega`, `precio_base`, `sku`, `id_canal`, `canal`, `envio_por_coordinar`, `fecha_solicitud`, `acreditado`, `id_medio_cobranza` FROM `view_pedido_directo_revendedor` where id_usuario= $usuario and despachado = 1 and anno=$anno and mes=$mes and importe <>0 and email not in (select email from view_usuarios_clientes) order by id_pedido;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function obtener_pedidos_pv( $anno, $mes){		
		$texto_consulta = "SELECT `id`, `id_pedido`, `no_factura`, `producto`, `importe`, `recargo`, `OCA`, `armado`, `despachado`, `dni`, `nombre`, `apellidos`, `color`, `id_cliente`, `iva`, `anno`, `mes`, `id_usuario`, `id_entrega`, `precio_base`, `sku`, `id_canal`, `canal`, `envio_por_coordinar`, `fecha_solicitud`, `acreditado`, `id_medio_cobranza`,`id_local`, `local`, usuario FROM `view_pedidos_union` where id= 'SHOWROOM' and  despachado = 0  order by id_pedido;";
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function obtener_pedidos_nombre_pv( $fnombre, $ftelefono, $femail, $fdni){		
		$texto_consulta = "SELECT `id`, `id_pedido`, `no_factura`, `producto`, `importe`, `recargo`, `OCA`, `armado`, `despachado`, `dni`, `nombre`, `apellidos`, `color`, `id_cliente`, `iva`, `anno`, `mes`, `id_usuario`, `id_entrega`, `precio_base`, `sku`, `id_canal`, `canal`, `envio_por_coordinar`, `fecha_solicitud`, `acreditado`, `id_medio_cobranza`,`id_local`, `local`, usuario FROM `view_pedidos_union_cliente` where id= 'SHOWROOM' and despachado = 0  ";
		
		if($fnombre != ''){
			$texto_consulta = $texto_consulta." and (nombre like '%$fnombre%' or apellidos like '%$fnombre%')";
		}
		if($ftelefono != ''){
			$texto_consulta = $texto_consulta." and (telefono like '%$ftelefono%' or celular like '%$ftelefono%')";
		}
		if($femail != ''){
			$texto_consulta = $texto_consulta." and email like '%$femail%'";
		}
		if($fdni != ''){
			$texto_consulta = $texto_consulta." and dni like '%$fdni%'";
		}
		$texto_consulta = $texto_consulta."  order by id_pedido;";
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function obtener_pedidos_locales_pv( $flocal){		
		$texto_consulta = "SELECT `id`, `id_pedido`, `no_factura`, `producto`, `importe`, `recargo`, `OCA`, `armado`, `despachado`, `dni`, `nombre`, `apellidos`, `color`, `id_cliente`, `iva`, `anno`, `mes`, `id_usuario`, `id_entrega`, `precio_base`, `sku`, `id_canal`, `canal`, `envio_por_coordinar`, `fecha_solicitud`, `acreditado`, `id_medio_cobranza`,`id_local`, `local`, usuario FROM `view_pedidos_union` where id= 'SHOWROOM' and id_local=$flocal and despachado = 0 order by id_pedido;";
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function obtener_pedidos_ok_pv($anno, $mes){			
		$texto_consulta = "SELECT `id`, `id_pedido`, `no_factura`, `producto`, `importe`, `recargo`, `OCA`, `armado`, `despachado`, `dni`, `nombre`, `apellidos`, `color`, `id_cliente`, `iva`, `anno`, `mes`, `id_usuario`, `id_entrega`, `precio_base`, `sku`, `id_canal`, `canal`, `envio_por_coordinar`, `fecha_solicitud`, `acreditado`, `id_medio_cobranza`,`id_local`, `local`, usuario FROM `view_pedidos_union` where  id= 'SHOWROOM' and despachado = 1 and anno=$anno and mes=$mes and importe <>0 order by id_pedido;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function obtener_productos_pedidos($id_pedido){		
		$texto_consulta = "SELECT `id`, `id_pedido`, `no_factura`, `producto`, `importe`, `recargo`, `OCA`, `armado`, `despachado`, `dni`, `nombre`, `apellidos`, `color`, `id_cliente`, `iva`, `anno`, `mes`, `id_usuario`, `id_entrega`, `precio_base`, `sku`, `id_canal`, `canal`, `envio_por_coordinar`, `fecha_solicitud`, `acreditado`, `id_medio_cobranza` FROM `view_pedidos_union` WHERE id_pedido=$id_pedido;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function provincias()
	{
		$texto_consulta = "SELECT * FROM provincias;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function municipios()
	{
		$texto_consulta = "SELECT * FROM municipios;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function obtener_parametro($nombre)
	{
		$texto_consulta = "SELECT * from sys_parametros WHERE (parametro = '$nombre');";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function obtener_costo($anno, $mes)
	{
		$texto_consulta = "SELECT * from costo_envio WHERE (anno = $anno and mes = $mes);";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function registrar_historico($consulta)
	{
		$texto_consulta =  "INSERT IGNORE INTO historico (consulta, fecha)" 
		                  . " VALUES('$consulta',now());";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	public function obtener_pedidos_a_armar()
	{
		$texto_consulta = "SELECT `id_pedido`, `id_cliente`, `nombre_cliente`, `id_canal`, `id_usuario`, `fecha_solicitud`, `first_name`, `no_factura`, `armado`, `apellidos`, `telefono`, `email`, `recargo`, `codigo_postal`, `calle`, `nro`, `piso`, `dpto`, `entrecalle1`, `entrecalle2`, `fecha_nacimiento`, `dni`, `celular`, `canal`, `tipo_factura`, `calle_entrega`, `nro_entrega`, `piso_entrega`, `dpto_entrega`, `entrecalle1_entrega`, `entrecalle2_entrega`, `municipio`, `provincia`, `last_name`, `vip`, `nivel`, `forma_pago`, `acreditado`, `cupon_promo`, `cupon_nro`, `envio_por_coordinar`, `medio_cobranza` from view_pedidos WHERE armado=0;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function total_pedidos_a_armar(){
		 $res = $this->obtener_pedidos_a_armar();
		return $res->num_rows();
	}
	public function obtener_pedido_a_armar($pedido)
	{
		$texto_consulta = "SELECT `id_pedido`, `id_cliente`, `nombre_cliente`, `id_canal`, `id_usuario`, `fecha_solicitud`, `first_name`, `no_factura`, `armado`, `apellidos`, `telefono`, `email`, `recargo`, `codigo_postal`, `calle`, `nro`, `piso`, `dpto`, `entrecalle1`, `entrecalle2`, `fecha_nacimiento`, `dni`, `celular`, `canal`, `tipo_factura`, `calle_entrega`, `nro_entrega`, `piso_entrega`, `dpto_entrega`, `entrecalle1_entrega`, `entrecalle2_entrega`, `municipio`, `provincia`, `last_name`, `vip`, `nivel`, `forma_pago`, `acreditado`, `cupon_promo`, `cupon_nro`, `envio_por_coordinar`, `medio_cobranza` from view_pedidos WHERE armado=0 and id_pedido=$pedido;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function detalles_pedidos_armar()
	{
		$texto_consulta = "SELECT `id_pedido`, `no_factura`, `dni`, `nombre`, `apellidos`, `producto`, `cantidad`, `telefono`, `email`, `recargo`, `codigo_postal`, `calle`, `nro`, `piso`, `dpto`, `entrecalle1`, `entrecalle2`, `celular`, `color`, `id_color`, `fecha`, `id_envio` from view_detalles_pedidos_armar where  id_pedido not in (select id_pedido from view_pedidos_no_cargados) order by id_pedido,producto,color;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function detalles_pedido_armar($id_pedido)
	{
		$texto_consulta = "SELECT `id_pedido`, `no_factura`, `dni`, `nombre`, `apellidos`, `producto`, `cantidad`, `telefono`, `email`, `recargo`, `codigo_postal`, `calle`, `nro`, `piso`, `dpto`, `entrecalle1`, `entrecalle2`, `celular`, `color`, `id_color`, `fecha`, `id_envio` from view_detalles_pedidos_armar WHERE id_pedido=$id_pedido ;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function modificar_armado($id_pedido_actual, $id_pedido, $esta_armado)
	{
		$texto_consulta =  "UPDATE pedidos SET 
		                    
		                    armado=$esta_armado
							
							WHERE (id_pedido = $id_pedido_actual);"; 
		                    
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	public function obt_dni($dni)
	{
		$texto_consulta = "SELECT dni from clientes WHERE dni=$dni;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	// Listar ingresos consultores
	public function obt_ingresos_consultores()
	{
		$user = $this->ion_auth->user()->row(); //usuario registrado
		$userid = $user->id;

		$texto_consulta = "SELECT `id_usuario`, `username`, `first_name`, `last_name`, `id_pedido`, `no_factura`, `fecha_solicitud`, `canal`, `ingresos`, `recargo`, `mision`, `atencion`, `iva`, `id_canal`	FROM view_ingresos_consultores WHERE year(fecha_solicitud)=year(CURDATE()) and month(fecha_solicitud)=month(CURDATE()) and (view_ingresos_consultores.id_usuario = $userid) 
						or (view_ingresos_consultores.id_usuario IN 
						(SELECT usuario_subordinados.id_subordinado 
						From usuario_subordinados 
						WHERE usuario_subordinados.id_usuario = $userid) );";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function obt_ingresos_por_consultor($id_user)
	{
		$texto_consulta = "SELECT `id_usuario`, `username`, `first_name`, `last_name`, `id_pedido`, `no_factura`, `fecha_solicitud`, `canal`, `ingresos`, `recargo`, `mision`, `atencion`, `iva`, `id_canal`	FROM view_ingresos_consultores WHERE id_usuario=$id_user and year(fecha_solicitud)=year(CURDATE());";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function total_ingresos() 
	{ 
	    $res = $this->obt_ingresos_consultores(); 
	    $this->total_ingresos = $res->num_rows();
		return $this->total_ingresos; 
	}
	public function obt_ingresos_resumen()
	{
		$user = $this->ion_auth->user()->row(); //usuario registrado
		$userid = $user->id;
		$texto_consulta = "SELECT *	FROM view_resumen_ingresos WHERE (view_resumen_ingresos.id_usuario = $userid) 
						or (view_resumen_ingresos.id_usuario IN 
						(SELECT usuario_subordinados.id_subordinado 
						From usuario_subordinados 
						WHERE usuario_subordinados.id_usuario = $userid) );";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function registrar_mision_seguimiento1($id_mision, $nota,$fecha_notificacion, $opcion)
	{
		$texto_consulta =  "INSERT IGNORE INTO mision_seguimiento (id_mision, nota, fecha, fecha_notificacion,id_opciones)" 
		                  . " VALUES($id_mision,'$nota',now(),'$fecha_notificacion','1');";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	public function registrar_mision_seguimiento($id_mision, $nota, $opcion)
	{
		$texto_consulta =  "INSERT IGNORE INTO mision_seguimiento (id_mision, nota, fecha)" 
		                  . " VALUES($id_mision,'$nota',now(), $opcion);";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	public function obt_mision_seguimiento($mision)
	{
		$texto_consulta = "SELECT *	FROM view_mision_seguimiento WHERE id_mision=$mision;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function total_mision_seguimiento($mision) 
	{ 
	    $res = $this->obt_mision_seguimiento($mision);
	    $this->total_mision = $res->num_rows();
		return $this->total_mision; 
	}
	public function modificar_cliente($id_cliente, $nombre,$apellidos, $email,$dni,$calle,$dpto,$telefono, $celular, $piso,$entrecalle1,$entrecalle2, $nro, $municipio)
	{
		$nombre = str_replace("'","´",$nombre);
		$apellidos = str_replace("'","´",$apellidos);

		$texto_consulta =  "UPDATE clientes SET dni = '$dni', nombre = '$nombre',apellidos = '$apellidos', calle = '$calle', nro = '$nro', piso = '$piso', dpto = '$dpto', entrecalle1 = '$entrecalle1', entrecalle2 = '$entrecalle2',telefono = '$telefono', celular = '$celular', email = '$email',id_municipio = '$municipio' WHERE id_cliente=$id_cliente;"; 
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	public function get_hallazgos()
	{
		$fields = $this->db->field_data('view_exportar_hallazgos');
		$query = $this->db->select('*')->get('view_exportar_hallazgos');
		return array("fields" => $fields, "query" => $query);
	}	
	public function obt_superior($id_usuario)
	{
		$texto_consulta = "SELECT DISTINCT id_usuario	FROM usuario_subordinados where id_subordinado=$id_usuario;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		$resultado = $resultado->row();
		return $resultado;
	}
	public function obt_subordinados($id_usuario)
	{
		$texto_consulta = "SELECT  id_subordinado	FROM usuario_subordinados where id_usuario=$id_usuario;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function obt_mail()
	{
		$texto_consulta = "SELECT  nombre, apellidos, email	FROM view_clientes;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function operativas()
	{
		$texto_consulta = "SELECT  *	FROM operativas;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function operativas_tipo_empresa($tipo_empresa)
	{
		$texto_consulta = "SELECT  * FROM operativas where grupo= $tipo_empresa;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function sucursales()
	{
		$texto_consulta = "SELECT  *	FROM sucursales;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function lockers()
	{
		$texto_consulta = "SELECT  * FROM lockers;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function actSucursal($arreglo){
		if(count($arreglo)){
			$texto_consulta = "DELETE FROM `sucursales` WHERE 1";
			$resultado = $this->db->query($texto_consulta);
			for ($i=0; $i<count($arreglo); $i++ ){
				//print_r($arreglo[$i]['idCentroImposicion']);
				//print_r($arreglo[$i]['Sigla']);
				//die();
				$texto_consulta =  "INSERT INTO sucursales (id_sucursal, codigo, nombre, calle, nro,municipio)" 
		                  . " VALUES(". $arreglo[$i]['idCentroImposicion'] . ",'" . $arreglo[$i]['Sigla']. "', '" .$arreglo[$i]['Descripcion'] ."', '". $arreglo[$i]['Calle'] ."', '". $arreglo[$i]['Numero']."','".$arreglo[$i]['Localidad']."');";
		
				$resultado = $this->db->query($texto_consulta);
			}
		}
	}
	public function obt_codigopostal_municipio($municipio)
	{
		$texto_consulta = "SELECT  codigopostal FROM municipios where id_municipio=$municipio;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function actualizar_pedidos()
	{
	    $consulta = "SELECT * from view_productos;";
					
	    $resultado = $this->db->query($consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado; 
	}
	public function obt_ventas_ci($cliente)
	{
	    $consulta = "SELECT * from view_ventas_ci WHERE id_cliente = $cliente;";
					
	    $resultado = $this->db->query($consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado; 
	}
	public function modificar_venta(
			$id_cliente, 
			$nombre, 
			$apellidos, 
			$dni, 
			$telefono,
			$celular, 
			$id_producto, 
			$id_pedido,
			$id_color,
			$cantidad,
			$fecha,			
			$id_color_ant,
			$id_producto_ant)
	{
		$nombre = str_replace("'","´",$nombre);
		$apellidos = str_replace("'","´",$apellidos);

		$texto_consulta = "UPDATE clientes SET  nombre='$nombre', apellidos = '$apellidos', dni = '$dni', telefono = '$telefono', celular = '$celular' WHERE (id_cliente = $id_cliente);"; 
							
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;

		$texto_consulta = "UPDATE pedidos SET fecha_solicitud='$fecha' WHERE (id_pedido = $id_pedido);"; 
							
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;

		$texto_consulta = "UPDATE detalles SET id_producto = $id_producto, id_color = $id_color, cantidad = $cantidad  WHERE (id_pedido = $id_pedido and id_color = $id_color_ant and id_producto = $id_producto_ant);"; 
							
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;

		return $this->db->affected_rows();
	}
	public function agregar_venta(
			$id_cliente, 
			$nombre, 
			$apellidos, 
			$dni, 
			$telefono,
			$celular, 
			$id_producto, 			
			$id_color,
			$cantidad,
			$fecha,
			$conseutivo	
			)
	{
		$nombre = str_replace("'","´",$nombre);
		$apellidos = str_replace("'","´",$apellidos);
		$user = $this->ion_auth->user()->row();
		$texto_consulta = "UPDATE clientes SET  nombre='$nombre', apellidos = '$apellidos', dni = '$dni', telefono = '$telefono', celular = '$celular' WHERE (id_cliente = $id_cliente);"; 
							
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;

		$texto_consulta = "INSERT INTO `pedidos`(`no_factura`, `referencia`, `id_cliente`, `id_canal`, `id_usuario`, `fecha_solicitud`, `reg_cancelado`, `armado`, `id_tipo_factura`, `recargo`, `calle_entrega`, `nro_entrega`, `piso_entrega`, `dpto_entrega`, `entrecalle1_entrega`, `entrecalle2_entrega`, `iva`) 
						VALUES ('$conseutivo','$conseutivo',$id_cliente,1,$user->id,'$fecha',0,1,1,0,'','','','','','',0);"; 
							
		$this->db->query($texto_consulta);
	    $id_ultimo_ped = $this->db->insert_id();		

		$texto_consulta = "INSERT INTO detalles (id_pedido, id_producto,id_campana,id_color, cantidad, precio, descuento, reg_cancelado) 
							VALUES (LAST_ID_PEDIDO,$id_producto, 0, $id_color, $cantidad, 1,0,0);"; 
							
		$this->db->query(str_replace("LAST_ID_PEDIDO", $id_ultimo_ped, $texto_consulta));	
		// Consecutivo
        $consulta_consecutivo = "UPDATE sys_parametros SET valor = valor + 1 WHERE parametro = 'CONSECUTIVO_VENTA'";
		$this->db->query($consulta_consecutivo);

		

		return 1;
	}
	public function agregar_venta_cambio(
			$id_cliente, 			
			$id_producto, 			
			$id_color,
			$cantidad,
			$fecha,
			$conseutivo	
			)
	{
		$texto_consulta = "INSERT INTO `pedidos`(`no_factura`, `referencia`, `id_cliente`, `id_canal`, `id_usuario`, `fecha_solicitud`, `reg_cancelado`, `armado`, `id_tipo_factura`, `recargo`, `calle_entrega`, `nro_entrega`, `piso_entrega`, `dpto_entrega`, `entrecalle1_entrega`, `entrecalle2_entrega`, `iva`) 
			VALUES ('$conseutivo','$conseutivo',$id_cliente,1,1,'$fecha',0,1,1,0,'','','','','','',0);"; 
							
		$this->db->query($texto_consulta);
	    $id_ultimo_ped = $this->db->insert_id();
		

		$texto_consulta = "INSERT INTO detalles (id_pedido, id_producto,id_campana,id_color, cantidad, precio, descuento, reg_cancelado) 
							VALUES (LAST_ID_PEDIDO,$id_producto, 0, $id_color, $cantidad, 1,0,0);"; 
							
		$this->db->query(str_replace("LAST_ID_PEDIDO", $id_ultimo_ped, $texto_consulta));	
		// Consecutivo
        $consulta_consecutivo = "UPDATE sys_parametros SET valor = valor + 1 WHERE parametro = 'CONSECUTIVO_VENTA'";
		$this->db->query($consulta_consecutivo);
		
		
		return 1;
	}
	public function obt_productoscomprados($cliente){		
		$texto_consulta = "SELECT * FROM `view_produtos_comprados` where id_cliente=$cliente;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	//*****************************************************************
	//*****************   Carrito  *************************************
	//*******************************************************************
	// Registrando un carrio
	public function registrar_carrito( $id, $id_pedido, $fecha_pedido)
	{
		$texto_consulta = "DELETE FROM carrito WHERE id=0 ;"; 
		
		$resultado = $this->db->query($texto_consulta);

		$texto_consulta =  "INSERT INTO carrito ( id, id_pedido, fecha_pedido)" 
		                  . " VALUES($id, $id_pedido, FROM_UNIXTIME(UNIX_TIMESTAMP(), '%Y-%m-%d %H.%i.%s'));";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	public function obt_ultimoID()
	{
		$texto_consulta = "SELECT id FROM `carrito` order by id desc limit 1;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		$resultado = $resultado -> result();
		
		return $resultado[0]->id;
	}
	public function obt_primeraFecha()
	{
		$texto_consulta = "SELECT (fecha_pedido + interval (3) day) AS `fecha_vencimiento` FROM `carrito` order by id asc limit 1;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		$resultado = $resultado -> result();
		
		return $resultado[0]->fecha_vencimiento;
	}
	public function obt_carritos(){		
		$texto_consulta = "SELECT * FROM `carrito` ;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function limpiar_carritos(){	
		$texto_consulta = "DELETE FROM carrito WHERE 1;"; 
		
		$resultado = $this->db->query($texto_consulta);

		$texto_consulta =  "INSERT INTO carrito ( id, id_pedido, fecha_pedido)" 
		                  . " VALUES(0, 0, curdate()+ interval (300) day);";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	public function crear_envio_oca()
	{
		$texto_consulta =  "INSERT INTO envios_oca ( id_pedido)" 
		                  . " VALUES(0);";
		
		$resultado = $this->db->query($texto_consulta);
		$texto_consulta = "SELECT id FROM `envios_oca` order by id desc limit 1;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		$resultado = $resultado -> result();
		
		return $resultado[0]->id;
	}
	public function actualizar_envio_oca($id, $id_pedido, $calle_origen , $nro_origen, $piso_origen , $depto_origen, $cp_origen , $localidad_origen, 
					$provincia_origen , $contacto_origen, $email_origen , $solicitante_origen, $observaciones_origen , $centrocosto_origen, 
					$idfranjahoraria_origen , $idcentroimposicionorigen, $fecha_origen , $idoperativa_envio, $nroremito_envio , $apellido_destinatario, 
					$nombre_destinatario , $calle_dstinatario, $nro_destinatario , $piso_destinatario, $depto_destinatario , $localidad_destinatario, 
					$email_destinatario , $idci_destinatario, $celular_destinatario , $observaciones_destinatario, $provincia_destinatario , 
					$cp_destinatario,$telefono_destinatario )
	{
		$nombre_destinatario = str_replace("'","´",$nombre_destinatario);
		$apellido_destinatario = str_replace("'","´",$apellido_destinatario);
		$calle_dstinatario = str_replace("'","´",$calle_dstinatario);
		$observaciones_destinatario = str_replace("'","´",$observaciones_destinatario);

		$texto_consulta =  "UPDATE `envios_oca` 
							SET `id_pedido`=$id_pedido,
							`calle_origen`='$calle_origen',
							`nro_origen`='$nro_origen',
							`piso_origen`='$piso_origen',
							`depto_origen`='$depto_origen',
							`cp_origen`='$cp_origen',
							`localidad_origen`='$localidad_origen',
							`provincia_origen`='$provincia_origen',
							`contacto_origen`='$contacto_origen',
							`email_origen`='$email_origen',
							`solicitante_origen`='$solicitante_origen',
							`observaciones_origen`='$observaciones_origen',
							`centrocosto_origen`='$centrocosto_origen',
							`idfranjahoraria_origen`='$idfranjahoraria_origen',
							`idcentroimposicionorigen`='$idcentroimposicionorigen',
							`fecha_origen`='$fecha_origen',
							`idoperativa_envio`='$idoperativa_envio',
							`nroremito_envio`='$nroremito_envio',
							`apellido_destinatario`='$apellido_destinatario',
							`nombre_destinatario`='$nombre_destinatario',
							`calle_dstinatario`='$calle_dstinatario',
							`nro_destinatario`='$nro_destinatario',
							`piso_destinatario`='$piso_destinatario',
							`depto_destinatario`='$depto_destinatario',
							`localidad_destinatario`='$localidad_destinatario',
							`email_destinatario`='$email_destinatario',
							`idci_destinatario`='$idci_destinatario',
							`celular_destinatario`='$celular_destinatario',
							`observaciones_destinatario`='$observaciones_destinatario',
							`provincia_destinatario`='$provincia_destinatario',
							`cp_destinatario`='$cp_destinatario',
							`telefono_destinatario`='$telefono_destinatario' 
							 WHERE id= $id"; 
		                    
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	public function eliminar_detalles_envio_oca($id_envio)
	{
		$texto_consulta = "DELETE FROM detalles_envio_oca WHERE id_envio_oca = $id_envio;"; 
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	public function crear_detalles_envio_oca($id_envio, $alto, $ancho, $largo, $peso, $valor, $cant, $caja, $observ)
	{
		$texto_consulta =  "INSERT INTO detalles_envio_oca ( id_envio_oca, alto_paquete, ancho_paquete, largo_paquete, peso_paquete, valor_paquete, cant_paquetes, caja, observaciones)" 
		                  . " VALUES($id_envio,'$alto', '$ancho', '$largo', '$peso', '$valor', '$cant', '$caja', '$observ');";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	public function eliminar_venta($id_pedido)
	{
		$texto_consulta = "DELETE FROM `comisiones_atencion` WHERE id_pedido = $id_pedido;";
		$resultado = $this->db->query($texto_consulta);
		
		$texto_consulta = "DELETE FROM `comisiones_mision` WHERE id_pedido = $id_pedido;";
		$resultado = $this->db->query($texto_consulta);

		$texto_consulta = "DELETE FROM `comisiones_online` WHERE id_pedido = $id_pedido;";
		$resultado = $this->db->query($texto_consulta);
		
		$texto_consulta = "DELETE FROM `entregas_directas` WHERE id_pedido = $id_pedido;";
		$resultado = $this->db->query($texto_consulta);
		
		$texto_consulta = "DELETE FROM `entregas_envios` WHERE id_pedido = $id_pedido;";
		$resultado = $this->db->query($texto_consulta);
		
		$texto_consulta = "DELETE FROM `detalles` WHERE id_pedido = $id_pedido;";
		$resultado = $this->db->query($texto_consulta);
		
		$texto_consulta = "DELETE FROM pedidos WHERE id_pedido = $id_pedido;"; 		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	public function buscar_detalles_envio_oca($id_envio){		
		$texto_consulta = "SELECT `id_envio_oca`, `alto_paquete`, `ancho_paquete`, `largo_paquete`, `caja`, `peso`, `valor`, `cantidad` FROM `view_detalles_envio_oca_resumido` where id_envio_oca=$id_envio;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado->result();
	}
	public function buscar_detalles_envio_oca1($id_envio){		
		$texto_consulta = "SELECT `id_envio_oca`, `alto_paquete`, `ancho_paquete`, `largo_paquete`, `caja`, `peso`, `valor`, `cantidad` FROM `view_detalles_envio_oca_resumido` where id_envio_oca=$id_envio;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function obt_detalles_envio_oca($id_pedido){		
		$texto_consulta = "SELECT `id_pedido`, `id_envio_oca`, `alto_paquete`, `ancho_paquete`, `largo_paquete`, `peso_paquete`, `valor_paquete`, `cant_paquetes`, `caja`, `observaciones`, `id` FROM `view_detalles_envio_oca` where id_pedido=$id_pedido;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function obt_envio_oca($id_pedido){		
		$texto_consulta = "SELECT * FROM `envios_oca` where id_pedido=$id_pedido;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function chequear_email($email)
	{
		$texto_consulta = "SELECT id_cliente FROM `clientes` where email=$email;";
		$resultado = $this->db->query($texto_consulta);
		if (!$resultado)
			echo $resultado;
		$id =0;
		foreach ($resultado->result() as $key) {
			$id= $key->id_cliente;
		}
		return $id;
	}
	public function insertar_cliente($nombre_cliente, $apellido_cliente, $numero_telefono_completo, $email, $canal)
	{
		$nombre = str_replace("'","´",$nombre);
		$apellidos = str_replace("'","´",$apellidos);

		$consulta_clientes = "INSERT INTO clientes (nombre, apellidos,  telefono,  email,  origen ) VALUES ('$nombre', '$apellidos', '$telefono', '$email','$canal');";
				
	    $this->db->query($consulta_clientes);
		$id_ultimo_cli = $this->db->insert_id();
		
		return $id_ultimo_cli;
	}
	public function obt_id_envio_oca($id_pedido)
	{		
		$texto_consulta = "SELECT id FROM `envios_oca` where id_pedido= $id_pedido;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		$resultado = $resultado -> result();
		
		return $resultado[0]->id;
	}
	public function restaurar_entregas_envios($id_pedido)
	{
		$texto_consulta = "UPDATE entregas_envios SET  reg_cancelado=0 WHERE (id_pedido = $id_pedido);"; 
							
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	public function marcar_impresion($id_envio)
	{
		$texto_consulta = "UPDATE entregas_envios SET  notas='' WHERE (id_envio = $id_envio);"; 
							
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	public function obt_conf_envio()
	{
		$texto_consulta = "SELECT * FROM `cfg_envios_oca` ;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
				
		return $resultado;
	}
	public function actualizar_cfg_envio_oca($id, $calle_origen , $nro_origen, $piso_origen , $depto_origen, $cp_origen , $localidad_origen, 
					$provincia_origen , $contacto_origen, $email_origen , $solicitante_origen, $observaciones_origen , $centrocosto_origen, 
					$idfranjahoraria_origen , $idcentroimposicionorigen)
	{
		$texto_consulta =  "UPDATE `cfg_envios_oca` 
							SET `calle_origen`='$calle_origen',
							`nro_origen`='$nro_origen',
							`piso_origen`='$piso_origen',
							`depto_origen`='$depto_origen',
							`cp_origen`='$cp_origen',
							`localidad_origen`='$localidad_origen',
							`provincia_origen`='$provincia_origen',
							`contacto_origen`='$contacto_origen',
							`email_origen`='$email_origen',
							`solicitante_origen`='$solicitante_origen',
							`observaciones_origen`='$observaciones_origen',
							`centrocosto_origen`='$centrocosto_origen',
							`idfranjahoraria_origen`='$idfranjahoraria_origen',
							`idcentroimposicionorigen`='$idcentroimposicionorigen'
							 WHERE id= $id"; 
		                    
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	public function obt_ventas_consultores($anno, $mes)
	{
		$texto_consulta = "SELECT `first_name`, `last_name`, `no_factura`, `fecha_solicitud`, `id_usuario`, `precio`, `cantidad`, `id_cliente`, `nombre`, `apellidos`, `dni`, `anno`, `mes`, `recargo`, `descuento`, `descuento_vip`, `id_canal`, `canal`, `precio_base`, `subtotal`, `iva`	FROM view_ventas_consultores_detalles where anno= $anno and mes = $mes;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function obt_ventas_consultores_vendedores($anno, $mes)
	{
		$texto_consulta = "SELECT distinct id_usuario, first_name, last_name	FROM view_ventas_consultores_detalles where anno= $anno and mes = $mes;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function obt_formas_pago()
	{
		$texto_consulta = "SELECT *	FROM forma_pagos ORDER BY `id` DESC;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function obt_formas_pago_rev()
	{
		$texto_consulta = "SELECT *	FROM forma_pagos_rev ORDER BY `id` DESC;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function obt_medio_cobro_rev()
	{
		$texto_consulta = "SELECT *	FROM medios_cobranza where id<>4 ORDER BY `id` DESC;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function get_reporte_ventas($desde, $hasta, $canal)
	{
		$user = $this->ion_auth->user()->row();
		$usuario = $user->id;

		$query = "DELETE FROM `temp_reporte` WHERE id_usuario = 1 and DAYOFMONTH(fecha_solicitud) = DAYOFMONTH(curdate())  and month(fecha_solicitud) = month(curdate()) and year(fecha_solicitud)=year(curdate()); ";
		$resultado = $this->db->query($query);

		$query1= "INSERT INTO temp_reporte SELECT 
		`view_venta_reporte_directo`.`id_pedido`,
		`view_venta_reporte_directo`.`no_factura`,
		`view_venta_reporte_directo`.`fecha_solicitud`,
		`view_venta_reporte_directo`.`canal_venta`,
		`view_venta_reporte_directo`.`acreditado`,
		`view_venta_reporte_directo`.`nombre`,
		`view_venta_reporte_directo`.`color`,
		round((`view_venta_reporte_directo`.`precio` / 1.21), 0) AS `PVP_Neto`,
		`view_venta_reporte_directo`.`precio` AS `Precio C/Iva`,
		`view_venta_reporte_directo`.`cantidad`,
		`view_venta_reporte_directo`.`descuento`,
		`view_venta_reporte_directo`.`costo` AS `Costo_envio`,
		`view_venta_reporte_directo`.`subtotal` AS `Total`,
		`view_venta_reporte_directo`.`cupon_promo`,
		`view_venta_reporte_directo`.`cupon_nro`,
		`view_venta_reporte_directo`.`sku`,
		`view_venta_reporte_directo`.`dni`,
		`view_venta_reporte_directo`.`email`,
		`view_venta_reporte_directo`.`telefono`,
		`view_venta_reporte_directo`.`celular`,
		`view_venta_reporte_directo`.`municipio`,
		`view_venta_reporte_directo`.`provincia`,
		`view_venta_reporte_directo`.`tipo_venta`,
		`view_venta_reporte_directo`.`tipo_factura`,
		`view_venta_reporte_directo`.`codigo_postal`,
		`view_venta_reporte_directo`.`tipo_envio`,
		`view_venta_reporte_directo`.`metodo_envio`,
		`view_venta_reporte_directo`.`consultor`,
		`view_venta_reporte_directo`.`provincia_entrega`,
		`view_venta_reporte_directo`.`municipio_entrega`,
		`view_venta_reporte_directo`.`despachado`,
		`view_venta_reporte_directo`.`local_entrega`,
		`view_venta_reporte_directo`.`forma_pago`,
		`view_venta_reporte_directo`.`medio_cobro`,
		`view_venta_reporte_directo`.`origen`,		
		if(`view_venta_reporte_directo`.`vip`=1,'SI','NO') as vip,
		`view_venta_reporte_directo`.`campana`,
		1 as id_usuario
	  FROM
		`view_venta_reporte_directo`
		WHERE DAYOFMONTH(fecha_solicitud) = DAYOFMONTH(curdate())  and month(fecha_solicitud) = month(curdate()) and year(fecha_solicitud)=year(curdate());";

		$resultado = $this->db->query($query1);
		$query1= "INSERT INTO temp_reporte SELECT 
			`view_venta_reporte_tercero`.`id_pedido`,
			`view_venta_reporte_tercero`.`no_factura`,
			`view_venta_reporte_tercero`.`fecha_solicitud`,
			`view_venta_reporte_tercero`.`canal_venta`,
			`view_venta_reporte_tercero`.`acreditado`,
			`view_venta_reporte_tercero`.`nombre`,
			`view_venta_reporte_tercero`.`color`,
			round((`view_venta_reporte_tercero`.`precio` / 1.21), 0) AS `PVP_Neto`,
			`view_venta_reporte_tercero`.`precio` AS `Precio C/Iva`,
			`view_venta_reporte_tercero`.`cantidad`,
			`view_venta_reporte_tercero`.`descuento`,
			`view_venta_reporte_tercero`.`costo` AS `Costo_envio`,
			`view_venta_reporte_tercero`.`subtotal` AS `Total`,
			`view_venta_reporte_tercero`.`cupon_promo`,
			`view_venta_reporte_tercero`.`cupon_nro`,
			`view_venta_reporte_tercero`.`sku`,
			`view_venta_reporte_tercero`.`dni`,
			`view_venta_reporte_tercero`.`email`,
			`view_venta_reporte_tercero`.`telefono`,
			`view_venta_reporte_tercero`.`celular`,
			`view_venta_reporte_tercero`.`municipio`,
			`view_venta_reporte_tercero`.`provincia`,
			`view_venta_reporte_tercero`.`tipo_venta`,
			`view_venta_reporte_tercero`.`tipo_factura`,
			`view_venta_reporte_tercero`.`codigo_postal`,
			`view_venta_reporte_tercero`.`tipo_envio`,
			`view_venta_reporte_tercero`.`metodo_envio`,
			`view_venta_reporte_tercero`.`consultor`,
			`view_venta_reporte_tercero`.`provincia_entrega`,
			`view_venta_reporte_tercero`.`municipio_entrega`,
			`view_venta_reporte_tercero`.`despachado`,
			`view_venta_reporte_tercero`.`local_entrega`,
			`view_venta_reporte_tercero`.`forma_pago`,
			`view_venta_reporte_tercero`.`medio_cobro`,
			`view_venta_reporte_tercero`.`origen`,			
			if(`view_venta_reporte_tercero`.`vip`=1,'SI','NO') as vip,
			`view_venta_reporte_tercero`.`campana`,
			1 as id_usuario
			FROM
			`view_venta_reporte_tercero`
			WHERE DAYOFMONTH(fecha_solicitud) = DAYOFMONTH(curdate())  and month(fecha_solicitud) = month(curdate()) and year(fecha_solicitud)=year(curdate());";
		$resultado = $this->db->query($query1);
		
		$query1= "INSERT INTO temp_reporte SELECT 
			  `view_ventas_reporte`.`id_pedido`,
			  `view_ventas_reporte`.`no_factura`,
			  `view_ventas_reporte`.`fecha_solicitud`,
			  `view_ventas_reporte`.`canal_venta`,
			  `view_ventas_reporte`.`acreditado`,			  
			  `view_ventas_reporte`.`nombre`,
			  `view_ventas_reporte`.`color`,
			  round((`view_ventas_reporte`.`precio` / 1.21), 0) AS `PVP_Neto`,
			  `view_ventas_reporte`.`precio` AS `Precio C/Iva`,
			  `view_ventas_reporte`.`cantidad`,
			  `view_ventas_reporte`.`descuento`,
			  `view_ventas_reporte`.`costo` AS `Costo_envio`,
			  `view_ventas_reporte`.`subtotal` AS `Total`,
			  `view_ventas_reporte`.`cupon_promo`,
			  `view_ventas_reporte`.`cupon_nro`,
			  `view_ventas_reporte`.`sku`,
			  `view_ventas_reporte`.`dni`,
			  `view_ventas_reporte`.`email`,
			  `view_ventas_reporte`.`telefono`,
			  `view_ventas_reporte`.`celular`,
			  `view_ventas_reporte`.`municipio`,
			  `view_ventas_reporte`.`provincia`,
			  `view_ventas_reporte`.`tipo_venta`,
			  `view_ventas_reporte`.`tipo_factura`,
			  `view_ventas_reporte`.`codigo_postal`,
			  'No definido' AS `tipo_envio`,
			  'No definido' AS `metodo_envio`,
			  `view_ventas_reporte`.`consultor`,
			  `view_ventas_reporte`.`provincia_entrega`,
			  `view_ventas_reporte`.`municipio_entrega`,
			  'No definido' AS `despachado`,
			  'ND' AS `local_entrega`,
			  `view_ventas_reporte`.`forma_pago`,
			  `view_ventas_reporte`.`medio_cobro`,
			  `view_ventas_reporte`.`origen`,
			  if(`view_ventas_reporte`.`vip`=1,'SI','NO') as vip,
			  `view_ventas_reporte`.`campana`,
				1 as id_usuario
			FROM
			`view_ventas_reporte`
			WHERE DAYOFMONTH(fecha_solicitud) = DAYOFMONTH(curdate())  and month(fecha_solicitud) = month(curdate()) and year(fecha_solicitud)=year(curdate()) and `view_ventas_reporte`.`id_pedido` not in (select temp_reporte.id_pedido from temp_reporte where temp_reporte.id_usuario=1 );";
			
			$resultado = $this->db->query($query1);


		$fields = $this->db->field_data('view_venta_reporte_union');
		$this->db->where('fecha_solicitud>=', $desde);
		$this->db->where('fecha_solicitud<=', $hasta);
		$this->db->where('id_usuario =', 1);
		
		if($canal != '0'){
			$this->db->where('canal_venta', $canal);
			
		}else{
			$this->db->where('canal_venta !=', 'ND');
		}

		$query = $this->db->select('*')->get('temp_reporte');
		return array("fields" => $fields, "query" => $query);
	}
	public function get_reporte_ventas_pantalla($desde, $hasta, $canal)
	{
		$user = $this->ion_auth->user()->row();
		$usuario = $user->id;

		$query = "DELETE FROM `temp_reporte` WHERE id_usuario = 1 and  DAYOFMONTH(fecha_solicitud) = DAYOFMONTH(curdate())  and month(fecha_solicitud) = month(curdate()) and year(fecha_solicitud)=year(curdate()) ;";
		$resultado = $this->db->query($query);

		$query1= "INSERT INTO temp_reporte SELECT 
		`view_venta_reporte_directo`.`id_pedido`,
		`view_venta_reporte_directo`.`no_factura`,
		`view_venta_reporte_directo`.`fecha_solicitud`,
		`view_venta_reporte_directo`.`canal_venta`,
		`view_venta_reporte_directo`.`acreditado`,
		`view_venta_reporte_directo`.`nombre`,
		`view_venta_reporte_directo`.`color`,
		round((`view_venta_reporte_directo`.`precio` / 1.21), 0) AS `PVP_Neto`,
		`view_venta_reporte_directo`.`precio` AS `Precio C/Iva`,
		`view_venta_reporte_directo`.`cantidad`,
		`view_venta_reporte_directo`.`descuento`,
		`view_venta_reporte_directo`.`costo` AS `Costo_envio`,
		`view_venta_reporte_directo`.`subtotal` AS `Total`,
		`view_venta_reporte_directo`.`cupon_promo`,
		`view_venta_reporte_directo`.`cupon_nro`,
		`view_venta_reporte_directo`.`sku`,
		`view_venta_reporte_directo`.`dni`,
		`view_venta_reporte_directo`.`email`,
		`view_venta_reporte_directo`.`telefono`,
		`view_venta_reporte_directo`.`celular`,
		`view_venta_reporte_directo`.`municipio`,
		`view_venta_reporte_directo`.`provincia`,
		`view_venta_reporte_directo`.`tipo_venta`,
		`view_venta_reporte_directo`.`tipo_factura`,
		`view_venta_reporte_directo`.`codigo_postal`,
		`view_venta_reporte_directo`.`tipo_envio`,
		`view_venta_reporte_directo`.`metodo_envio`,
		`view_venta_reporte_directo`.`consultor`,
		`view_venta_reporte_directo`.`provincia_entrega`,
		`view_venta_reporte_directo`.`municipio_entrega`,
		`view_venta_reporte_directo`.`despachado`,
		`view_venta_reporte_directo`.`local_entrega`,
		`view_venta_reporte_directo`.`forma_pago`,
		`view_venta_reporte_directo`.`medio_cobro`,
		`view_venta_reporte_directo`.`origen`,
		if(`view_venta_reporte_directo`.`vip`=1,'SI','NO') as vip,
		`view_venta_reporte_directo`.`campana`,
		1 as id_usuario
	  FROM
		`view_venta_reporte_directo`
		WHERE DAYOFMONTH(fecha_solicitud) = DAYOFMONTH(curdate())  and month(fecha_solicitud) = month(curdate()) and year(fecha_solicitud)=year(curdate());";

		$resultado = $this->db->query($query1);
		$query1= "INSERT INTO temp_reporte SELECT 
			`view_venta_reporte_tercero`.`id_pedido`,
			`view_venta_reporte_tercero`.`no_factura`,
			`view_venta_reporte_tercero`.`fecha_solicitud`,
			`view_venta_reporte_tercero`.`canal_venta`,
			`view_venta_reporte_tercero`.`acreditado`,
			`view_venta_reporte_tercero`.`nombre`,
			`view_venta_reporte_tercero`.`color`,
			round((`view_venta_reporte_tercero`.`precio` / 1.21), 0) AS `PVP_Neto`,
			`view_venta_reporte_tercero`.`precio` AS `Precio C/Iva`,
			`view_venta_reporte_tercero`.`cantidad`,
			`view_venta_reporte_tercero`.`descuento`,
			`view_venta_reporte_tercero`.`costo` AS `Costo_envio`,
			`view_venta_reporte_tercero`.`subtotal` AS `Total`,
			`view_venta_reporte_tercero`.`cupon_promo`,
			`view_venta_reporte_tercero`.`cupon_nro`,
			`view_venta_reporte_tercero`.`sku`,
			`view_venta_reporte_tercero`.`dni`,
			`view_venta_reporte_tercero`.`email`,
			`view_venta_reporte_tercero`.`telefono`,
			`view_venta_reporte_tercero`.`celular`,
			`view_venta_reporte_tercero`.`municipio`,
			`view_venta_reporte_tercero`.`provincia`,
			`view_venta_reporte_tercero`.`tipo_venta`,
			`view_venta_reporte_tercero`.`tipo_factura`,
			`view_venta_reporte_tercero`.`codigo_postal`,
			`view_venta_reporte_tercero`.`tipo_envio`,
			`view_venta_reporte_tercero`.`metodo_envio`,
			`view_venta_reporte_tercero`.`consultor`,
			`view_venta_reporte_tercero`.`provincia_entrega`,
			`view_venta_reporte_tercero`.`municipio_entrega`,
			`view_venta_reporte_tercero`.`despachado`,
			`view_venta_reporte_tercero`.`local_entrega`,
			`view_venta_reporte_tercero`.`forma_pago`,
			`view_venta_reporte_tercero`.`medio_cobro`,
			`view_venta_reporte_tercero`.`origen`,
			if(`view_venta_reporte_tercero`.`vip`=1,'SI','NO') as vip,
			`view_venta_reporte_tercero`.`campana`,
			1 as id_usuario
			FROM
			`view_venta_reporte_tercero`
			WHERE DAYOFMONTH(fecha_solicitud) = DAYOFMONTH(curdate())  and month(fecha_solicitud) = month(curdate()) and year(fecha_solicitud)=year(curdate());";
		$resultado = $this->db->query($query1);
		
		$query1= "INSERT INTO temp_reporte SELECT 
			`view_venta_reporte_otros`.`id_pedido`,
			`view_venta_reporte_otros`.`no_factura`,
			`view_venta_reporte_otros`.`fecha_solicitud`,
			`view_venta_reporte_otros`.`canal_venta`,
			`view_venta_reporte_otros`.`acreditado`,
			`view_venta_reporte_otros`.`nombre`,
			`view_venta_reporte_otros`.`color`,
			round((`view_venta_reporte_otros`.`precio` / 1.21), 0) AS `PVP_Neto`,
			`view_venta_reporte_otros`.`precio` AS `Precio C/Iva`,
			`view_venta_reporte_otros`.`cantidad`,
			`view_venta_reporte_otros`.`descuento`,
			`view_venta_reporte_otros`.`costo` AS `Costo_envio`,
			`view_venta_reporte_otros`.`subtotal` AS `Total`,
			`view_venta_reporte_otros`.`cupon_promo`,
			`view_venta_reporte_otros`.`cupon_nro`,
			`view_venta_reporte_otros`.`sku`,
			`view_venta_reporte_otros`.`dni`,
			`view_venta_reporte_otros`.`email`,
			`view_venta_reporte_otros`.`telefono`,
			`view_venta_reporte_otros`.`celular`,
			`view_venta_reporte_otros`.`municipio`,
			`view_venta_reporte_otros`.`provincia`,
			`view_venta_reporte_otros`.`tipo_venta`,
			`view_venta_reporte_otros`.`tipo_factura`,
			`view_venta_reporte_otros`.`codigo_postal`,
			`view_venta_reporte_otros`.`tipo_envio`,
			`view_venta_reporte_otros`.`metodo_envio`,
			`view_venta_reporte_otros`.`consultor`,
			`view_venta_reporte_otros`.`provincia_entrega`,
			`view_venta_reporte_otros`.`municipio_entrega`,
			`view_venta_reporte_otros`.`despachado`,
			`view_venta_reporte_otros`.`local_entrega`,
			`view_venta_reporte_otros`.`forma_pago`,
			`view_venta_reporte_otros`.`medio_cobro`,
			`view_venta_reporte_otros`.`origen`,
			if(`view_venta_reporte_otros`.`vip`=1,'SI','NO') as vip,
			`view_venta_reporte_otros`.`campana`,
			1 as id_usuario
			FROM
			`view_venta_reporte_otros`
			WHERE DAYOFMONTH(fecha_solicitud) = DAYOFMONTH(curdate())  and month(fecha_solicitud) = month(curdate()) and year(fecha_solicitud)=year(curdate());";
			
			$resultado = $this->db->query($query1);


		//$fields = $this->db->field_data('view_venta_reporte_union');
		
		$texto_consulta =  "select 
		`temp_reporte`.`id_usuario` AS `id_usuario`,
		`temp_reporte`.`canal_venta` AS `canal_venta`,
		`temp_reporte`.`local_entrega` AS `local_entrega`,
		`temp_reporte`.`nombre` AS `nombre`,
		sum(`temp_reporte`.`cantidad`) AS `cantidad`,
		sum(`temp_reporte`.`PVP_Neto`) AS `PVP_Neto` 
	  from 
		`temp_reporte`
	 Where id_usuario=1 
	  group by 
		`temp_reporte`.`id_usuario`,`temp_reporte`.`canal_venta`,`temp_reporte`.`local_entrega`,`temp_reporte`.`nombre` 
	  order by 
		`temp_reporte`.`id_usuario`,`temp_reporte`.`canal_venta`,`temp_reporte`.`local_entrega`,`temp_reporte`.`nombre`;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;

		return $resultado;
	}
	public function convenir_showroom($id_pedido, $id_local)
	{
		$texto_consulta =  "INSERT INTO entregas_directas ( id_pedido, despachado, reg_cancelado, id_local)" 
		                  . " VALUES($id_pedido,0, 0,$id_local);";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	public function convenir_tercero($id_pedido, $id_empresa)
	{
		$texto_consulta =  "INSERT INTO entregas_envios ( id_pedido, id_empresa, id_estado, fecha, reg_cancelado, id_tipo_empresa)" 
		                  . " VALUES($id_pedido,$id_empresa, 0, FROM_UNIXTIME(UNIX_TIMESTAMP(), '%Y-%m-%d %H.%i.%s'),0,3);";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	public function quitar_convenir($id_pedido)
	{
		$texto_consulta = "UPDATE pedidos SET  envio_por_coordinar=0 WHERE (id_pedido = $id_pedido);"; 
		
		$resultado = $this->db->query($texto_consulta);
		if (!$resultado)
		echo $resultado;

		return $this->db->affected_rows();
	}
	public function despachar_envio($id_pedido)
	{
		$texto_consulta =  "UPDATE entregas_envios SET 
		                    
		                    id_estado=1
							
							WHERE (id_pedido = $id_pedido);"; 
		                    
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	public function despachar_directo($id_pedido)
	{
		$texto_consulta =  "UPDATE entregas_directas SET 
		                    
		                    despachado=1
							
							WHERE (id_pedido = $id_pedido);"; 
		                    
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	public function despachar_directo1($id_pedido,$id_local)
	{
		$texto_consulta =  "UPDATE entregas_directas SET 
		                    
		                    despachado=1,
							id_local = $id_local
							
							WHERE (id_pedido = $id_pedido);"; 
		                    
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	public function entrar_producto_almacen($id_pedido){
		$texto_consulta = "SELECT id_cliente FROM pedidos where id_pedido = $id_pedido;";		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		$resul= $resultado->result();
		$id_cliente = $resul[0]->id_cliente;

		$texto_consulta = "SELECT email FROM clientes where id_cliente = $id_cliente;";		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		$resul= $resultado->result();
		$email = $resul[0]->email;

		$texto_consulta = "SELECT id FROM usuarios where email = '$email';";		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		$resul= $resultado->result();
		$id_revendedor = $resul[0]->id;

		$texto_consulta = "SELECT * FROM detalles where id_pedido = $id_pedido;";	
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		$resul_detalles= $resultado;
		foreach ($resul_detalles->result() as $key) {
			# code...
			$id_producto = $key->id_producto;
			$cantidad = $key->cantidad;

			$texto_consulta = "SELECT * FROM `producto_revendedores` where id_revendedor = $id_revendedor and id_producto = $id_producto;";		
			$resultado = $this->db->query($texto_consulta);
	    	if (!$resultado)
				echo $resultado;
			if($resultado->num_rows()>0){//actualizacion
				$texto_consulta =  "UPDATE `producto_revendedores` SET `existencia`=existencia + $cantidad where id_revendedor = $id_revendedor and id_producto = $id_producto;";	                    
		
				$resultado1 = $this->db->query($texto_consulta);
				if (!$resultado1)
					echo $resultado1;	
			}else{// inserción				
				$texto_consulta =  "INSERT INTO `producto_revendedores`(`id_producto`, `id_revendedor`, `existencia`) VALUES ($id_producto, $id_revendedor, $cantidad) ;";	                    
		
				$resultado1 = $this->db->query($texto_consulta);
				if (!$resultado1)
					echo $resultado1;
			}
		}
		return 1;
	}
	public function buscar_cliente_pedido($id_pedido)
	{
		$texto_consulta = "SELECT id_cliente FROM pedidos where id_pedido = $id_pedido;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		$resul= $resultado->result();
		return $resul[0]->id_cliente;
	}
	public function get_notificaciones()
	{
		$user = $this->ion_auth->user()->row();
		$usuario = $user->id;

		$texto_consulta = "SELECT count(id) as total FROM notificaciones where id_usuario = $id_usuario and activa=1;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
			$resul= $resultado->result();		
		$total_notificaciones = $resul[0]->total;

		$texto_consulta = "SELECT * FROM notificaciones where id_usuario = $id_usuario and activa=1;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		$notificaciones = $resultado;
		return array("total" => $total_notificaciones, "notificaciones" => $notificaciones);
	}
	public function registrar_orden(
		$nuevo_cliente,
		$id_cliente_act,
		$id_municipio, 
		$dni, 
		$nombre, 
		$apellidos, 
		$telefono,
		$celular, 
		$codigo_postal, 
		$calle, 
		$nro, 
		$piso, 
		$dpto, 
		$entrecalle1, 
		$entrecalle2, 
		$email,
		$fecha_nacimiento,
		$id_canal,
		$id_transaccion,
		$fecha_venta,
		$monto_iva,
		$tipo_factura,
		$calle_entrega,
		$nro_entrega,
		$piso_entrega,
		$dpto_entrega,
		$entrecalle1_entrega,
		$entrecalle2_entrega,
		$municipio_entrega,
		$provincia_entrega,
		$codigo_postal_entrega,
		$dt_productos,
		$dt_precios,
		$dt_cantidades,
		$dt_descuentos,
		$dt_incrementos,
		$dt_colores,
		$dt_combo,
		$total_productos,
		$tipo_envio,
		$forma_pago,
		$observaciones,
		$cuit,
		$frm_medio,
		$financiamiento,
		$tbMontoFinanciamiento,
		$id_local,
		$nombre_local,
		$lugar_entrega,
		$nombre_terminal,
		$municipio_terminal, 
		$codigo_postal_terminal,
		$provincia_terminal  
 	)
 	{
		$nombre = str_replace("'","´",$nombre);
		$apellidos = str_replace("'","´",$apellidos);
		
		// Usuario actual
		$us = $this->ion_auth->user()->row();
		$id_usuario = $us->id;
		$canal = $this->obt_nombre_canal($id_canal);
		// Clientes
		$consulta_clientes = "";
		if ( $nuevo_cliente == '1' )
			$consulta_clientes = "INSERT INTO clientes ( id_municipio, dni, nombre, apellidos, calle, nro, piso, dpto, entrecalle1, entrecalle2, telefono, celular, email, en_operacion, en_mision, reg_cancelado, codigo_postal, fecha_nacimiento, origen, observaciones, cuit ) VALUES ($id_municipio, '$dni', '$nombre', '$apellidos', '$calle', '$nro', '$piso', '$dpto', '$entrecalle1', '$entrecalle2','$telefono', '$celular', '$email', 0, 0, 0,'$codigo_postal', '$fecha_nacimiento','$canal', '', '$cuit');";
		else{
			$consulta_clientes= "UPDATE clientes SET  dni = '$dni', nombre = '$nombre', apellidos = '$apellidos', calle = '$calle', nro = '$nro', piso = '$piso', dpto = '$dpto', entrecalle1 = '$entrecalle1', entrecalle2 = '$entrecalle2',telefono = '$telefono', celular= '$celular', email = '$email', en_operacion = 0, en_mision= 0, en_operacion = 0, codigo_postal = '$codigo_postal', fecha_nacimiento = '$fecha_nacimiento', observaciones='' , cuit='$cuit' WHERE id_cliente=$id_cliente_act;";
		}	
		/* if($tx_no_acreditada==1){
			$tx_no_acreditada =0;
		}else{
			$tx_no_acreditada=1;
		}*/
		
		// Pedidos
		
		$consulta_pedidos = "";   
		$consulta_revendedor = ""; 
		if ($nuevo_cliente == 0)
			if ( $tipo_envio == "Showroom" ){
				$consulta_pedidos = "INSERT INTO pedidos_orden (no_factura, referencia, id_cliente, id_canal, id_usuario, fecha_solicitud, reg_cancelado, armado, id_tipo_factura, recargo, calle_entrega,nro_entrega, piso_entrega, dpto_entrega, entrecalle1_entrega, entrecalle2_entrega, iva, forma_pago, provincia_entrega, municipio_entrega,codigo_postal_entrega, id_medio_cobranza,tipo_envio,financiamiento,acreditado,`id_local`, `local`, observaciones,lugar_entrega,nombre_terminal, municipio_terminal,codigo_postal_terminal,provincia_terminal, monto_financiamiento  ) VALUES ('$id_transaccion', '$id_transaccion',$id_cliente_act, $id_canal, $id_usuario,  FROM_UNIXTIME(UNIX_TIMESTAMP(), '%Y-%m-%d %H.%i.%s'), 0,0,$tipo_factura,0, '$calle_entrega','$nro_entrega', '$piso_entrega', '$dpto_entrega', '$entrecalle1_entrega', '$entrecalle2_entrega',$monto_iva, $forma_pago, '', '','$codigo_postal_entrega',$frm_medio,'$tipo_envio',$financiamiento, 0,$id_local,'$nombre_local','$observaciones','$lugar_entrega','$nombre_terminal','$municipio_terminal', 	'$codigo_postal_terminal','$provincia_terminal',$tbMontoFinanciamiento );";   
			}else{
				$consulta_pedidos = "INSERT INTO pedidos_orden (no_factura, referencia, id_cliente, id_canal, id_usuario, fecha_solicitud, reg_cancelado, armado, id_tipo_factura, recargo, calle_entrega,nro_entrega, piso_entrega, dpto_entrega, entrecalle1_entrega, entrecalle2_entrega, iva, forma_pago, provincia_entrega, municipio_entrega,codigo_postal_entrega,id_medio_cobranza,tipo_envio,financiamiento,acreditado,`id_local`, `local`, observaciones,lugar_entrega,nombre_terminal, municipio_terminal,codigo_postal_terminal,provincia_terminal, monto_financiamiento ) VALUES ('$id_transaccion', '$id_transaccion',$id_cliente_act, $id_canal, $id_usuario,  FROM_UNIXTIME(UNIX_TIMESTAMP(), '%Y-%m-%d %H.%i.%s'), 0,0,$tipo_factura,0, '$calle_entrega','$nro_entrega', '$piso_entrega', '$dpto_entrega', '$entrecalle1_entrega', '$entrecalle2_entrega',$monto_iva, $forma_pago, '$provincia_entrega', '$municipio_entrega','$codigo_postal_entrega',$frm_medio,'$tipo_envio',$financiamiento, 0,$id_local,'$nombre_local','$observaciones','$lugar_entrega','$nombre_terminal','$municipio_terminal', 	'$codigo_postal_terminal','$provincia_terminal',$tbMontoFinanciamiento );";   
			}
			
		else{
			if ( $tipo_envio == "Showroom" ){
				$consulta_pedidos = "INSERT INTO pedidos_orden ( no_factura, referencia, id_cliente, id_canal, id_usuario,  fecha_solicitud, reg_cancelado, armado, id_tipo_factura, recargo, calle_entrega,nro_entrega, piso_entrega, dpto_entrega, entrecalle1_entrega, entrecalle2_entrega,iva, forma_pago, provincia_entrega, municipio_entrega,codigo_postal_entrega, id_medio_cobranza,tipo_envio,financiamiento,acreditado,`id_local`, `local`, observaciones,lugar_entrega,nombre_terminal, municipio_terminal,codigo_postal_terminal,provincia_terminal, monto_financiamiento ) VALUES ('$id_transaccion', '$id_transaccion', LAST_INSERT_ID(), $id_canal, $id_usuario, FROM_UNIXTIME(UNIX_TIMESTAMP(), '%Y-%m-%d %H.%i.%s'), 0,0,$tipo_factura,0, '$calle_entrega', '$nro_entrega', '$piso_entrega', '$dpto_entrega', '$entrecalle1_entrega', '$entrecalle2_entrega',$monto_iva, $forma_pago, '', '','$codigo_postal_entrega', $frm_medio,'$tipo_envio',$financiamiento, 0,$id_local,'$nombre_local','$observaciones','$lugar_entrega','$nombre_terminal','$municipio_terminal', 	'$codigo_postal_terminal','$provincia_terminal',$tbMontoFinanciamiento );";
			}else{
				$consulta_pedidos = "INSERT INTO pedidos_orden ( no_factura, referencia, id_cliente, id_canal, id_usuario,  fecha_solicitud, reg_cancelado, armado, id_tipo_factura, recargo, calle_entrega,nro_entrega, piso_entrega, dpto_entrega, entrecalle1_entrega, entrecalle2_entrega,iva, forma_pago, provincia_entrega, municipio_entrega,codigo_postal_entrega,id_medio_cobranza,tipo_envio,financiamiento,acreditado,`id_local`, `local`, observaciones,lugar_entrega,nombre_terminal, municipio_terminal,codigo_postal_terminal,provincia_terminal, monto_financiamiento ) VALUES ('$id_transaccion', '$id_transaccion', LAST_INSERT_ID(), $id_canal, $id_usuario, FROM_UNIXTIME(UNIX_TIMESTAMP(), '%Y-%m-%d %H.%i.%s'), 0,0,$tipo_factura,0, '$calle_entrega', '$nro_entrega', '$piso_entrega', '$dpto_entrega', '$entrecalle1_entrega', '$entrecalle2_entrega',$monto_iva, $forma_pago, '$provincia_entrega', '$municipio_entrega','$codigo_postal_entrega', $frm_medio,'$tipo_envio',$financiamiento, 0,$id_local,'$nombre_local','$observaciones','$lugar_entrega','$nombre_terminal','$municipio_terminal', 	'$codigo_postal_terminal','$provincia_terminal',$tbMontoFinanciamiento );";
			}
		}
		
		if ( $nuevo_cliente == 1 )
			$consulta_revendedor = "INSERT INTO revendedores(id_usuario, id_cliente) VALUES ($id_usuario, ID_ULTIMO_CLI) ;";
		
				
		
		// Detalles y productos
		$consulta_detalles = array();
		$consulta_productos = array();
		$importe_total = 0;
		for ($i=0; $i<count($dt_productos); $i++ )
		{
			$consulta_detalles[$i] = "INSERT INTO detalles_orden (id_orden, id_producto, id_campana, id_color, cantidad, precio, descuento, reg_cancelado,  incremento,es_combo) VALUES (ID_ULTIMO_PED, " . $dt_productos[$i] . ", 0, 1, "  . $dt_cantidades[$i]. ", " . $dt_precios[$i] . ", " . $dt_descuentos[$i]  . ",0, " . $dt_incrementos[$i].", " . $dt_combo[$i] .");";
			$importe_total += $dt_precios[$i] * $dt_cantidades[$i]-$dt_descuentos[$i]+$dt_incrementos[$i];

				
		}
		
		
		
		// Consecutivo
		$consulta_consecutivo = "UPDATE sys_parametros SET valor = valor + 1 WHERE parametro = 'ORDEN_REVENDEDOR'";
		

		

		// Inicio de la transacción
		$this->db->trans_begin();
		if($consulta_clientes != ''){
			if ($nuevo_cliente ==1)
			{				
				$this->db->query($consulta_clientes);
				$id_ultimo_cli = $this->db->insert_id();
				//$id_ultimo_cli=$id_ultimo_cli-1;
				if ($consulta_revendedor != "")
					$this->db->query(str_replace("ID_ULTIMO_CLI", $id_ultimo_cli, $consulta_revendedor));
			}else{
				$this->db->query($consulta_clientes);
				if ($consulta_revendedor != "")
					$this->db->query( $consulta_revendedor);
			}
		}
			
			
			$this->db->query($consulta_pedidos);
			$id_ultimo_ped = $this->db->insert_id();
			
			
		
			for ($i=0; $i<count($consulta_detalles); $i++ ){
				$this->db->query( str_replace("ID_ULTIMO_PED", $id_ultimo_ped, $consulta_detalles[$i]) );				
			}

			for ($i=0; $i<count($consulta_productos); $i++ ){
				$this->db->query($consulta_productos[$i]);
			}
			
			$this->db->query($consulta_consecutivo);
		
		$this->db->trans_complete();
		// Fin de transacción
		
		if ($this->db->trans_status() === FALSE){

			$this->db->trans_rollback();
		
		}
		else
			$this->db->trans_commit();
		
		return $id_ultimo_ped;
		
	 }
	 public function guardar_notas($id_orden,$notas){
		$texto_consulta =  "UPDATE pedidos_orden SET notas = '$notas' WHERE (id_orden=$id_orden);"; 
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		return $this->db->affected_rows();
	 }
	public function modificar_orden($id_orden,$dt_productos,$dt_precios,$dt_cantidades,$dt_descuentos,$dt_incrementos,$dt_colores	, $dt_combo){
		$texto_consulta =  "DELETE FROM `detalles_orden` WHERE id_orden = $id_orden;"; 		
		$resultado = $this->db->query($texto_consulta);

		// Detalles y productos
		$consulta_detalles = array();
		$consulta_productos = array();
		$importe_total = 0;
		for ($i=0; $i<count($dt_productos); $i++ )
		{
			$consulta_detalles[$i] = "INSERT INTO detalles_orden (id_orden, id_producto, id_campana, id_color, cantidad, precio, descuento, reg_cancelado,  incremento, es_combo) VALUES ($id_orden, " . $dt_productos[$i] . ", 0, ". $dt_colores[$i] . ", "  . $dt_cantidades[$i]. ", " . $dt_precios[$i] . ", " . $dt_descuentos[$i]  . ",0, " . $dt_incrementos[$i].", " . $dt_combo[$i] .");";
			$importe_total += $dt_precios[$i] * $dt_cantidades[$i]-$dt_descuentos[$i]+$dt_incrementos[$i];
			$resultado = $this->db->query($consulta_detalles[$i]);
				
		} 
		
		
	    if (!$resultado)
			echo $resultado;
		return $this->db->affected_rows();		
	}
 	public function guardar_estado_orden($id_orden,$id_estado,$observaciones){		
		$texto_consulta =  "UPDATE estados_pedidos_orden SET completado = 1 WHERE (id_orden=$id_orden);"; 
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;

		$user = $this->ion_auth->user()->row();
	    $usuario = $user->id;
		$texto_consulta =  "INSERT  INTO estados_pedidos_orden (id_orden, id_estado, fecha,observaciones, id_usuario, completado)" 
		. " VALUES($id_orden,$id_estado,FROM_UNIXTIME(UNIX_TIMESTAMP(), '%Y-%m-%d %H.%i.%s'), '$observaciones',$usuario,0);";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	
	 }
 	public function guardar_estado_rechazado($id_orden,$id_estado,$observaciones){		
		$texto_consulta =  "UPDATE estados_pedidos_orden SET rechazado = 1, observaciones = '$observaciones' WHERE (id_orden=$id_orden and id_estado=$id_estado);"; 
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;

				
		return $this->db->affected_rows();
	
	 }
 	public function obt_estado_rechazado($id_orden,$id_estado){	
		 if($id_orden == 0){
			$texto_consulta =  "SELECT * FROM  estados_pedidos_orden  WHERE ( id_estado = $id_estado);";
		 }else	
			$texto_consulta =  "SELECT * FROM  estados_pedidos_orden  WHERE (id_orden = $id_orden and id_estado = $id_estado);"; 
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
				
		return $resultado;
	
	 }
	 public function cargar_orden_estado($id_estado)
	{
		$texto_consulta = "SELECT * FROM view_estados_orden where id_estado = $id_estado and completado=0;";
		
		$resultado = $this->db->query($texto_consulta);
		if (!$resultado)
			echo $resultado;
		$resul= $resultado;
		return $resul;
	}
	 public function cargar_orden_estado_nac($id_estado)
	{
		$texto_consulta = "SELECT * FROM view_estados_orden_nac where id_estado = $id_estado and completado=0;";
		
		$resultado = $this->db->query($texto_consulta);
		if (!$resultado)
			echo $resultado;
		$resul= $resultado;
		return $resul;
	}
	 public function cargar_orden_estado_int($id_estado)
	{
		$texto_consulta = "SELECT * FROM view_estados_orden_int where id_estado = $id_estado and completado=0;";
		
		$resultado = $this->db->query($texto_consulta);
		if (!$resultado)
			echo $resultado;
		$resul= $resultado;
		return $resul;
	}
	public function cargar_orden_entrega_despacho()
	{
		$texto_consulta = "SELECT * FROM view_entrega_union ;";
		
		$resultado = $this->db->query($texto_consulta);
		if (!$resultado)
			echo $resultado;
		$resul= $resultado;
		return $resul;
	}
	public function cargar_orden_revisar($id_orden)
	{
		$texto_consulta = "SELECT * FROM view_orden_compra where id_orden = $id_orden;";
		
		$resultado = $this->db->query($texto_consulta);
		if (!$resultado)
			echo $resultado;
		$resul= $resultado;
		return $resul;
	}
	public function cargar_orden_revisar_detalle($id_orden)
	{
		$texto_consulta = "SELECT * FROM view_orden_compra_detalles where id_orden = $id_orden;";
		
		$resultado = $this->db->query($texto_consulta);
		if (!$resultado)
			echo $resultado;
		$resul= $resultado;
		return $resul;
	}
	public function registrar_factura(	$id_orden,$fecha_facturacion, $tipo_envio 	)
 	{
		// Usuario actual
		$us = $this->ion_auth->user()->row();
		$id_usuario = $us->id;
						
		// Pedidos
		$consulta_pedidos = "";   
		$consulta_revendedor = ""; 

		$consulta_pedidos = "INSERT INTO `pedidos`( `no_factura`, `referencia`, `id_cliente`, `id_canal`, `id_usuario`, `fecha_solicitud`, `reg_cancelado`, `armado`, `id_tipo_factura`, `recargo`, `calle_entrega`, `nro_entrega`, `piso_entrega`, `dpto_entrega`, `entrecalle1_entrega`, `entrecalle2_entrega`, `iva`, `forma_pago`, `acreditado`, `cupon_promo`, `cupon_nro`, `envio_por_coordinar`, `provincia_entrega`, `municipio_entrega`, `id_medio_cobranza`)
				(SELECT  `no_factura`, `referencia`, `id_cliente`, `id_canal`, $id_usuario as id_usuario, `fecha_factura`, `reg_cancelado`, `armado`, `id_tipo_factura`, `recargo`, `calle_entrega`, `nro_entrega`, `piso_entrega`, `dpto_entrega`, `entrecalle1_entrega`, `entrecalle2_entrega`, `iva`, `forma_pago`, `acreditado`, `cupon_promo`, `cupon_nro`, `envio_por_coordinar`, `provincia_entrega`, `municipio_entrega`, `id_medio_cobranza` FROM `pedidos_orden` WHERE `id_orden` = $id_orden);";  
		
			
		$consulta_detalles ="";
		$consulta_detalles = "INSERT INTO `detalles`(`id_pedido`, `id_producto`, `id_campana`, `id_color`, `cantidad`, `precio`, `descuento`, `reg_cancelado`, `descuento_vip`, `incremento`, `notas`, `es_combo`)  (SELECT ID_ULTIMO_PED as id_pedido, `id_producto`, `id_campana`, `id_color`, `cantidad`, `precio`, `descuento`, `reg_cancelado`, `descuento_vip`, `incremento`, `notas`, `es_combo` FROM `detalles_orden` WHERE id_orden = $id_orden);";	
		
		
		$consulta_entrega = "";
		if ( $tipo_envio == "Showroom" )
 	       $consulta_entrega = "INSERT INTO entregas_directas (id_pedido, despachado, reg_cancelado,id_local) VALUES (ID_ULTIMO_PED, 0, 0, 1);";
		else
		   $consulta_entrega = "INSERT INTO entregas_envios (id_pedido, id_empresa, id_estado, id_envio, fecha, reg_cancelado, id_tipo_empresa) VALUES (ID_ULTIMO_PED, 10, 0, '', FROM_UNIXTIME(UNIX_TIMESTAMP(), '%Y-%m-%d %H.%i.%s'), 0,1);";
		
		$this->db->trans_begin();

		   $this->db->query($consulta_pedidos);
			$id_ultimo_ped = $this->db->insert_id();
					   
			if ($consulta_detalles != "")
				$this->db->query( str_replace("ID_ULTIMO_PED", $id_ultimo_ped, $consulta_detalles) );   
			if ($consulta_entrega != "")
				$this->db->query( str_replace("ID_ULTIMO_PED", $id_ultimo_ped, $consulta_entrega) );   
				
		$this->db->trans_complete();
		// Fin de transacción
		
		if ($this->db->trans_status() === FALSE){

			$this->db->trans_rollback();
		
		}
		else
			$this->db->trans_commit();
		
		return $id_ultimo_ped;
		
	 }
	 
	 public function guardar_fechas_orden($id_orden, $fecha_factura,$fecha_conformidad){
		$texto_consulta = "UPDATE  pedidos_orden SET fecha_factura='$fecha_factura', fecha_conformidad='$fecha_conformidad' WHERE (id_orden = '$id_orden');"; 
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	 }
	 public function cargar_flujo($id_orden)
	 {
		 $texto_consulta = "SELECT *,substr(`fecha`,1,10) as fecha1 FROM view_estados_orden where id_orden = $id_orden;";
		 
		 $resultado = $this->db->query($texto_consulta);
		 if (!$resultado)
			 echo $resultado;
		 $resul= $resultado;
		 return $resul;
	 }
	 public function cargar_flujo_fechas($id_orden)
	 {
		 $texto_consulta = "SELECT id_orden, substr(`fecha`,1,10) as fecha FROM `view_estados_orden` where id_orden = $id_orden group by id_orden, substr(`fecha`,1,10) ;";
		 
		 $resultado = $this->db->query($texto_consulta);
		 if (!$resultado)
			 echo $resultado;
		 $resul= $resultado;
		 return $resul;
	 }
	 public function cargar_ordenes()
	{
		$texto_consulta = "SELECT * FROM view_estados_orden where completado=0;";
		
		$resultado = $this->db->query($texto_consulta);
		if (!$resultado)
			echo $resultado;
		$resul= $resultado;
		return $resul;
	}
	public function cargar_ordenes_nac()
	{
		$texto_consulta = "SELECT * FROM view_estados_orden_nac where completado=0;";
		
		$resultado = $this->db->query($texto_consulta);
		if (!$resultado)
			echo $resultado;
		$resul= $resultado;
		return $resul;
	}
	public function cargar_ordenes_int()
	{
		$texto_consulta = "SELECT * FROM view_estados_orden_int where completado=0;";
		
		$resultado = $this->db->query($texto_consulta);
		if (!$resultado)
			echo $resultado;
		$resul= $resultado;
		return $resul;
	}
	public function obt_notificaciones($id_usuario)
	{
		$texto_consulta = "SELECT * FROM notificaciones where id_usuario=$id_usuario and activa = 1;";
		
		$resultado = $this->db->query($texto_consulta);
		if (!$resultado)
			echo $resultado;
		$resul= $resultado;
		return $resul;
	}
	public function obt_todas_notificaciones($id_usuario)
	{
		$texto_consulta = "SELECT * FROM view_notificacion where id_usuario=$id_usuario;";
		
		$resultado = $this->db->query($texto_consulta);
		if (!$resultado)
			echo $resultado;
		$resul= $resultado;
		return $resul;
	}
	public function cargar_notificacion($id_notificacion)
	{
		$texto_consulta = "SELECT * FROM view_notificacion where id=$id_notificacion;";
		
		$resultado = $this->db->query($texto_consulta);
		if (!$resultado)
			echo $resultado;
		$resul= $resultado;
		return $resul;
	}
	public function email_consultor($id_pedido)
	{
		$texto_consulta = "SELECT `usuarios`.`email`  FROM 	`pedidos`
		INNER JOIN `usuarios` ON (`pedidos`.`id_usuario` = `usuarios`.`id`) where `pedidos`.`id_pedido`=$id_pedido;";
		
		$resultado = $this->db->query($texto_consulta);
		if (!$resultado)
			echo $resultado;
		$resul= $resultado->result();
		return $resul[0]->email;
	}
	public function modificar_notificacion($id_notificacion){
		$texto_consulta = "UPDATE  notificaciones SET activa=0 WHERE (id = $id_notificacion);"; 
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	 }
	public function subir_remito($id_orden,$remito){
		$texto_consulta = "UPDATE  pedidos_orden SET remito='$remito' WHERE (id_orden = $id_orden);"; 
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	 }
	public function resetear_armado_despacho($id_pedido){
		$texto_consulta = "UPDATE  pedidos SET armado=0 WHERE (id_pedido = $id_pedido);"; 
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
			$texto_consulta = "UPDATE `entregas_envios` SET `id_estado`=0, `notas`='1'  WHERE (id_pedido = $id_pedido);"; 
		
			$resultado = $this->db->query($texto_consulta);
			if (!$resultado)
				echo $resultado;
		
		return $this->db->affected_rows();
	 }
	 public function agregar_notificacion($id_usuario,$fecha,$nota, $origen){		
		
		$texto_consulta =  "INSERT INTO `notificaciones`( `id_usuario`, `fecha`, `nota`, `activa`, `id_tipo_notificacion`, `origen`) VALUES ($id_usuario,'$fecha','$nota',1,3,'$origen');";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	
	 }
	 public function agregar_mail_revendedor($email,$pin){		
		
		$texto_consulta =  "INSERT INTO `usuarios`( `email`, `pin`, `active`) VALUES ('$email','$pin',0);";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	
	 }
	 public function buscar_sucursal( $id_sucursal){
		$texto_consulta = "SELECT nombre  FROM 	`sucursales`where id_sucursal=$id_sucursal;";
		
		$resultado = $this->db->query($texto_consulta);
		if (!$resultado)
			echo $resultado;
		$resul= $resultado->result();
		return $resul[0]->nombre;
	 }
	 public function buscar_operativa( $id_operativa){
		$texto_consulta = "SELECT nombre  FROM 	`operativas`where id=$id_operativa;";
		
		$resultado = $this->db->query($texto_consulta);
		if (!$resultado)
			echo $resultado;
		$resul= $resultado->result();
		return $resul[0]->nombre;
	 }
	 public function buscar_dato_sucursal($id_sucursal){
		$texto_consulta = "SELECT *  FROM 	`sucursales` where id_sucursal=$id_sucursal;";
		
		$resultado = $this->db->query($texto_consulta);
		if (!$resultado)
			echo $resultado;
		
		return $resultado;
	 }
	 public function validar_email($email){
		$texto_consulta = "SELECT email  FROM `usuarios` where email='$email';";
		
		$resultado = $this->db->query($texto_consulta);
		if (!$resultado)
			echo $resultado;
		
		return $resultado->num_rows();
	 }
	 public function validar_revendedor($email,$pin){
		$texto_consulta = "SELECT email  FROM `usuarios` where email='$email' and pin = '$pin';";
		
		$resultado = $this->db->query($texto_consulta);
		if (!$resultado)
			echo $resultado;
		
		return $resultado->num_rows();
	 }
	 public function reg_datos_revendedor($id_usuario, $id_municipio, $dni, $nombre, $apellidos,  $telefono, $email, $codigo_postal, $calle, $nro, $piso, $dpto, $entrecalle1, $entrecalle2, $fecha_nacimiento, $celular, $cuit,$sel_tipo_revendedor,$sel_sexo,$hijos){		
		
		$texto_consulta =  "INSERT IGNORE INTO `datos_revendedores`(`id_usuario`, `id_municipio`, `dni`, `nombre`, `apellidos`,  `telefono`, `email`, `codigo_postal`, `calle`, `nro`, `piso`, `dpto`, `entrecalle1`, `entrecalle2`, `fecha_nacimiento`, `celular`, `cuit`, `id_tipo_revendedor`, `sexo`, `hijos`) VALUES ($id_usuario, $id_municipio, '$dni', '$nombre', '$apellidos',  '$telefono', '$email', '$codigo_postal', '$calle', '$nro', '$piso', '$dpto', '$entrecalle1', '$entrecalle2', '$fecha_nacimiento', '$celular', '$cuit',$sel_tipo_revendedor,'$sel_sexo',$hijos);";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	
	 }
	 public function act_datos_revendedor($id_usuario, $id_municipio, $dni, $nombre, $apellidos,  $telefono, $email, $codigo_postal, $calle, $nro, $piso, $dpto, $entrecalle1, $entrecalle2, $fecha_nacimiento, $celular, $cuit,$sel_sexo, $sel_tipo_revendedor, $hijos){		
		
		$texto_consulta =  "UPDATE `datos_revendedores` SET `id_municipio` = $id_municipio,  `dni`='$dni',`nombre`= '$nombre', `apellidos`='$apellidos',  `telefono`='$telefono', `codigo_postal`='$codigo_postal', `calle`='$calle', `nro`='$nro', `piso`='$piso', `dpto`='$dpto', `entrecalle1`='$entrecalle1', `entrecalle2`='$entrecalle2', `fecha_nacimiento`='$fecha_nacimiento', `celular`='$celular', `cuit`='$cuit',`sexo`='$sel_sexo',`hijos`=$hijos,`id_tipo_revendedor`=$sel_tipo_revendedor WHERE id_usuario= $id_usuario;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	
	 }
	 public function activar_revendedor($email,$activation_code){
		$texto_consulta = "UPDATE  usuarios SET active=1, pin=0  WHERE (email = '$email' and activation_code='$activation_code');"; 
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	 }
	 //*******************************************************************************
	 public function datos_muni($id_muni){
		$texto_consulta = "SELECT *  FROM  `municipios` where id_municipio=$id_muni;";
		
		$resultado = $this->db->query($texto_consulta);
		if (!$resultado)
			echo $resultado;
		
		return $resultado;
	 }
	 public function datos_prov_muni_cliente($id_prov){
		$texto_consulta = "SELECT *  FROM  `provincias` where id_provincia=$id_prov;";
		
		$resultado = $this->db->query($texto_consulta);
		if (!$resultado)
			echo $resultado;
		
		return $resultado;
	 }
	 public function cargar_perfil($id_usuario){
		$texto_consulta = "SELECT 
  `usuarios`.`id`,
  `datos_revendedores`.`id_usuario`,
  `datos_revendedores`.`id_municipio`,
  `datos_revendedores`.`dni`,
  `datos_revendedores`.`nombre`,
  `datos_revendedores`.`apellidos`,
  `datos_revendedores`.`direccion`,
  `datos_revendedores`.`telefono`,
  `datos_revendedores`.`email`,
  `datos_revendedores`.`codigo_postal`,
  `datos_revendedores`.`calle`,
  `datos_revendedores`.`nro`,
  `datos_revendedores`.`piso`,
  `datos_revendedores`.`dpto`,
  `datos_revendedores`.`entrecalle1`,
  `datos_revendedores`.`entrecalle2`,
  `datos_revendedores`.`fecha_nacimiento`,
  `datos_revendedores`.`celular`,
  `datos_revendedores`.`cuit`,
  `datos_revendedores`.`sexo`,
  if(`datos_revendedores`.`sexo`='M','Masculino','Femenino') as sexo1,
  `datos_revendedores`.`hijos`,
  if(`datos_revendedores`.`hijos`=1,'SI','NO') as hijos1,
  `datos_revendedores`.`id_tipo_revendedor`,
  `municipios`.`nombre` AS `municipio`,
  `provincias`.`id_pais`,
  `provincias`.`id_provincia`,
  `provincias`.`nombre` as provincia,
  `paises`.`nombre` as pais,
  `tipo_revendedor`.`nombre` AS `tipo_revendedor`
FROM
  `usuarios`
  INNER JOIN `datos_revendedores` ON (`usuarios`.`id` = `datos_revendedores`.`id_usuario`)
  INNER JOIN `municipios` ON (`datos_revendedores`.`id_municipio` = `municipios`.`id_municipio`)
  INNER JOIN `provincias` ON (`municipios`.`id_provincia` = `provincias`.`id_provincia`)
  INNER JOIN `paises` ON (`provincias`.`id_pais` = `paises`.`id`)
  INNER JOIN `tipo_revendedor` ON (`datos_revendedores`.`id_tipo_revendedor` = `tipo_revendedor`.`id`) where id_usuario=$id_usuario;";
		
		$resultado = $this->db->query($texto_consulta);
		if (!$resultado)
			echo $resultado;
		
		return $resultado;
	 }	 
	 public function act_cliente_revendedor($id_usuario, $id_municipio, $dni, $nombre, $apellidos,  $telefono, $email, $codigo_postal, $calle, $nro, $piso, $dpto, $entrecalle1, $entrecalle2, $fecha_nacimiento, $celular, $cuit){		
		
		$texto_consulta =  "UPDATE `clientes` SET `id_municipio` = $id_municipio,  `dni`='$dni',`nombre`= '$nombre', `apellidos`='$apellidos',  `telefono`='$telefono', `codigo_postal`='$codigo_postal', `calle`='$calle', `nro`='$nro', `piso`='$piso', `dpto`='$dpto', `entrecalle1`='$entrecalle1', `entrecalle2`='$entrecalle2', `fecha_nacimiento`='$fecha_nacimiento', `celular`='$celular', `cuit`='$cuit' WHERE email= '$email';";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	
	 }
	 public function obt_revendedores(){
		$texto_consulta = "SELECT * FROM `view_datos_revendedores` ;";
		
		$resultado = $this->db->query($texto_consulta);
		if (!$resultado)
			echo $resultado;
		
		return $resultado;
	 }	
	 public function obt_revendedores_cartera(){
		$texto_consulta = "SELECT id_usuario,count(*) as total_cartera FROM `view_misiones_listas_revendedores1` group by id_usuario;";
		
		$resultado = $this->db->query($texto_consulta);
		if (!$resultado)
			echo $resultado;
		
		return $resultado;
	 }	
	 public function obt_cartera_revendedor($id_usuario){
		$texto_consulta = "SELECT * FROM `view_misiones_listas_revendedores1` where  id_usuario = $id_usuario;";
		
		$resultado = $this->db->query($texto_consulta);
		if (!$resultado)
			echo $resultado;
		
		return $resultado;
	 }	
	 public function obt_revendedores_cartera_atendida(){
		$texto_consulta = "SELECT id_usuario,count(*) as total_cartera_atendida FROM `view_misiones_listas_revendedores1` where curdate()<fecha_vcto group by id_usuario;";
		
		$resultado = $this->db->query($texto_consulta);
		if (!$resultado)
			echo $resultado;
		
		return $resultado;
	 }	
	 public function obt_revendedores_int(){
		$texto_consulta = "SELECT * FROM `view_datos_revendedores_int` ;";
		
		$resultado = $this->db->query($texto_consulta);
		if (!$resultado)
			echo $resultado;
		
		return $resultado;
	 }	
	 public function cargar_stock($id_usuario){
		$texto_consulta = "SELECT * FROM `view_stock_rev` where id_revendedor = $id_usuario ;";
		
		$resultado = $this->db->query($texto_consulta);
		if (!$resultado)
			echo $resultado;
		
		return $resultado;
	 }	
	 public function total_revendedores() 
	{ 
	    $res = $this->obt_revendedores(); 
	    $this->total_revendedores = $res->num_rows();
		return $this->total_revendedores; 
	}
	 public function total_revendedores_int() 
	{ 
	    $res = $this->obt_revendedores_int(); 
	    $this->total_revendedores = $res->num_rows();
		return $this->total_revendedores; 
	}
	public function obt_orden($id_pedido){
		$texto_consulta = "SELECT id_orden FROM `view_entrega_union` where id_pedido = $id_pedido ;";
		
		$resultado = $this->db->query($texto_consulta);
		if (!$resultado)
			echo $resultado;
		$resu= $resultado->result();
		return $resu[0]->id_orden;
	}
	public function obt_mail_orden($id_orden){
		$texto_consulta = "SELECT `pedidos_orden`.`id_orden`,`usuarios`.`email`	  FROM
		`pedidos_orden`	INNER JOIN `usuarios` ON (`pedidos_orden`.`id_usuario` = `usuarios`.`id`) WHERE id_orden = $id_orden;";
		
		$resultado = $this->db->query($texto_consulta);
		if (!$resultado)
			echo $resultado;
		$resu= $resultado->result();
		return $resu[0]->email;
		
	}
	public function obt_detalles_pedidos($id_pedido){
		$texto_consulta = "SELECT * FROM `view_detalles` where id_pedido = $id_pedido ;";
		
		$resultado = $this->db->query($texto_consulta);
		if (!$resultado)
			echo $resultado;
		
		return $resultado;
	 }
	public function obt_pedido_pedidos($id_pedido){
		$texto_consulta = "SELECT 
		`pedidos`.`id_pedido`,
		`pedidos`.`id_canal`,
		`pedidos`.`usuario_comisiona`,
		`clientes`.`origen`,
		`pedidos`.`id_cliente`
	  FROM
		`pedidos`
		LEFT OUTER JOIN `clientes` ON (`pedidos`.`id_cliente` = `clientes`.`id_cliente`) where `pedidos`.`id_pedido` = $id_pedido ;";
		
		$resultado = $this->db->query($texto_consulta);
		if (!$resultado)
			echo $resultado;
		
		return $resultado->result();
	 }
	 public function existe_comision_atencion($id_pedido){		
		$texto_consulta = "SELECT * FROM `comisiones_atencion` where id_pedido=$id_pedido;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado->num_rows();
	}
	 public function existe_comision_mision($id_pedido){		
		$texto_consulta = "SELECT * FROM `comisiones_mision` where id_pedido=$id_pedido;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado->num_rows();
	}
	 public function existe_comision_online($id_pedido){		
		$texto_consulta = "SELECT * FROM `comisiones_online` where id_pedido=$id_pedido;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado->num_rows();
	}
	public function cambiar_origen_macoi($id_cliente){
		
		$texto_consulta =  "UPDATE `clientes` SET `origen`='Mcoy_old' WHERE `id_cliente`=$id_cliente";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	public function registrar_comision_atencion($id_usuario,$id_pedido,$valor_com){		
		
		$texto_consulta =  "INSERT INTO comisiones_atencion(id_usuario, id_pedido, fecha, valor, reg_cancelado) VALUES ($id_usuario, $id_pedido, FROM_UNIXTIME(UNIX_TIMESTAMP(), '%Y-%m-%d %H.%i.%s'), $valor_com, 0)";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	
	 }
	public function registrar_comision_mcoy($id_usuario,$id_pedido,$valor_com){		
		
		$texto_consulta =  "INSERT INTO comisiones_mcoy(id_usuario, id_pedido, fecha, valor, reg_cancelado) VALUES ($id_usuario, $id_pedido, FROM_UNIXTIME(UNIX_TIMESTAMP(), '%Y-%m-%d %H.%i.%s'), $valor_com, 0)";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	
	 }
	public function registrar_comision_mision($id_usuario,$id_pedido,$valor_com){		
		
		$texto_consulta =  "INSERT INTO comisiones_mision(id_usuario, id_pedido, fecha, valor, reg_cancelado) VALUES ($id_usuario, $id_pedido, FROM_UNIXTIME(UNIX_TIMESTAMP(), '%Y-%m-%d %H.%i.%s'), $valor_com, 0)";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	
	 }
	public function registrar_comision_online($id_usuario,$id_pedido,$valor_com){		
		
		$texto_consulta =  "INSERT INTO comisiones_online(id_usuario, id_pedido, fecha, valor, reg_cancelado) VALUES ($id_usuario, $id_pedido, FROM_UNIXTIME(UNIX_TIMESTAMP(), '%Y-%m-%d %H.%i.%s'), $valor_com, 0)";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	
	 }
	 public function actualizar_orden(
		$id_orden,
		$lugar_entrega,
		$nombre_terminal,
		$municipio_terminal, 
		$codigo_postal_terminal,	 
		$provincia_terminal,
		$calle_entrega,
		$nro_entrega,
		$piso_entrega,
		$dpto_entrega,
		$municipio_entrega,
		$provincia_entrega,	
		$entrecalle1_entrega,
		$entrecalle2_entrega,
		$codigo_postal_entrega
	){
		$texto_consulta =  "UPDATE `pedidos_orden` SET `lugar_entrega` = '$lugar_entrega',  `nombre_terminal`='$nombre_terminal',`municipio_terminal`= '$municipio_terminal', `codigo_postal_terminal`='$codigo_postal_terminal',  `provincia_terminal`='$provincia_terminal', `calle_entrega`='$calle_entrega', `nro_entrega`='$nro_entrega', `piso_entrega`='$piso_entrega', `dpto_entrega`='$dpto_entrega', `municipio_entrega`='$municipio_entrega', `entrecalle1_entrega`='$entrecalle1_entrega',`entrecalle2_entrega`='$entrecalle2_entrega', `provincia_entrega`='$provincia_entrega',  `codigo_postal_entrega`='$codigo_postal_entrega' WHERE id_orden= $id_orden;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	public function obt_clientes_rev($id_usuario){
		
		$texto_consulta = "SELECT * FROM `view_cantidad_clientes_rev` where id_usuario=$id_usuario;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado->num_rows();
	}
	public function obt_productos_paises($id_producto){
		
		$texto_consulta = "SELECT * FROM `view_productos_paises` where id_producto=$id_producto;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	
	public function obt_combos_paises($id_combo){
		$texto_consulta = "SELECT * FROM `view_combos_paises` where id_combo=$id_combo;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function obt_facturas_paises($id_factura){
		
		$texto_consulta = "SELECT * FROM `view_factura_paises` where id_factura=$id_factura;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function cancelar_producto_pais_rev($id_producto, $id_pais)
	{
		$texto_consulta =  "DELETE from precios_internacionales WHERE (id_producto=$id_producto and id_pais = $id_pais);";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	public function cancelar_combo_pais_rev($id_combo, $id_pais)
	{
		$texto_consulta =  "DELETE from combos_internacionales WHERE (id_combo=$id_combo and id_pais = $id_pais);";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	public function cancelar_factura_pais_rev($id_factura, $id_pais)
	{
		$texto_consulta =  "DELETE from factura_paises WHERE (id_factura=$id_factura and id_pais = $id_pais);";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	public function agregar_producto_paises_rev($id_producto,$id_pais,$precio, $precio_may,$min_rev, $min_may)
	{
		$texto_consulta =  "DELETE from precios_internacionales WHERE (id_producto=$id_producto and id_pais = $id_pais);";
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		$texto_consulta =  "INSERT INTO precios_internacionales(id_producto, id_pais, precio, precio_mayorista,cant_min_rev, cant_min_may) VALUES ($id_producto, $id_pais,  $precio, $precio_may,$min_rev, $min_may)";

		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	public function agregar_combo_paises_rev($id_combo,$id_pais,$precio, $precio_may,$min_rev, $min_may)
	{
		$texto_consulta =  "DELETE from combos_internacionales WHERE (id_combo=$id_combo and id_pais = $id_pais);";
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		$texto_consulta =  "INSERT INTO combos_internacionales(id_combo, id_pais, precio, precio_mayorista,cant_min_rev, cant_min_may) VALUES ($id_combo, $id_pais,  $precio, $precio_may,$min_rev, $min_may)";

		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	public function agregar_factura_paises_rev($id_factura,$id_pais)
	{
		$texto_consulta =  "DELETE from factura_paises WHERE (id_factura=$id_factura and id_pais = $id_pais);";
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;

		$texto_consulta =  "INSERT INTO factura_paises(id_factura, id_pais) VALUES ($id_factura, $id_pais)";

		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	public function actualizar_existencia($id_producto, $id_usuario, $existencia)
	{
		$texto_consulta =  "SELECT * from producto_revendedores WHERE (id_producto=$id_producto and id_revendedor = $id_usuario);";
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		if($resultado->num_rows()==0){
			$texto_consulta =  "INSERT INTO producto_revendedores(id_producto, id_revendedor, existencia) VALUES ($id_producto, $id_usuario,  $existencia)";
		}else{
			$texto_consulta =  "UPDATE `producto_revendedores` SET `existencia`=$existencia WHERE (id_producto=$id_producto and id_revendedor = $id_usuario);";
		}	
		

		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	public function actualizar_precio($id_producto, $id_usuario, $precio)
	{
		$texto_consulta =  "SELECT * from producto_revendedores WHERE (id_producto=$id_producto and id_revendedor = $id_usuario);";
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		if($resultado->num_rows()==0){
			$texto_consulta =  "INSERT INTO producto_revendedores(id_producto, id_revendedor, mi_precio) VALUES ($id_producto, $id_usuario,  $precio)";
		}else{
			$texto_consulta =  "UPDATE `producto_revendedores` SET `mi_precio`=$precio WHERE (id_producto=$id_producto and id_revendedor = $id_usuario);";
		}	
		

		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	public function obt_rev_pais($id_usuario){
		$texto_consulta =  "SELECT id_pais from view_rev_int_pais WHERE id_usuario=$id_usuario ;";
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		$resu = $resultado->result();
		if($resultado->num_rows()==0){
			$re1 =0;
		}	else
		$re1 =$resu[0]->id_pais;
		return $re1;
	}
	public function obt_rev_int_precios($id_pais){
		$texto_consulta =  "SELECT * from precios_internacionales WHERE id_pais=$id_pais ;";
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		return $resultado;
	}
	public function excel_rev($table_name,$sql)
	{ 
		$us = $this->ion_auth->user()->row();
		$id_usuario = $us->id;
		//si existe la tabla
		if ($this->db->table_exists("$table_name"))
		{
			//si es un array y no está vacio
			if(!empty($sql) && is_array($sql))
			{
				
				for ($i=0; $i < count($sql); $i++) { 
					# code...
					$val = $i+2;
					$texto_consulta =  "INSERT INTO `clientes`(dni,nombre,apellidos,telefono,email,codigo_postal,calle,nro,piso,dpto,entrecalle1,entrecalle2,celular,observaciones,cuit,id_municipio) VALUES ('".$sql[$val]['dni']."','".$sql[$val]['nombre']."','".$sql[$val]['apellidos']."','".$sql[$val]['telefono']."','".$sql[$val]['email']."','".$sql[$val]['codigo_postal']."','".$sql[$val]['calle']."','".$sql[$val]['nro']."','".$sql[$val]['piso']."','".$sql[$val]['dpto']."','".$sql[$val]['entrecalle1']."','".$sql[$val]['entrecalle2']."','".$sql[$val]['celular']."','".$sql[$val]['observaciones']."','".$sql[$val]['cuit']."',".$sql[$val]['id_municipio'].")";
					$resultado = $this->db->query($texto_consulta);
					$id_ultimo_cliente = $this->db->insert_id();

					$texto_consulta1 =  "INSERT INTO `revendedores`(`id_usuario`, `id_cliente`) VALUES ($id_usuario,$id_ultimo_cliente)";
					$resultado1 = $this->db->query($texto_consulta1);
				}
				
				//si se lleva a cabo la inserción
				/*if($this->db->insert_batch("$table_name", $sql))
				{
					return TRUE;
				}else{
					return FALSE;
				}*/
				return TRUE;
			}
		}
	}
	public function excel($table_name,$sql)
	{ 
		//si existe la tabla
		if ($this->db->table_exists("$table_name"))
		{
			//si es un array y no está vacio
			if(!empty($sql) && is_array($sql))
			{
				//si se lleva a cabo la inserción
				if($this->db->insert_batch("$table_name", $sql))
				{
					return TRUE;
				}else{
					return FALSE;
				}
			}
		}
	}
	public function obt_facturas(){		
		$texto_consulta = "SELECT * FROM `tipo_factura_internacional` ;";
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function clientes_nuevos(){		
		$texto_consulta = "SELECT 
		`view_clientes_nuevos`.`anno`,
		`view_clientes_nuevos`.`mes`,
		`meses`.`nombre`,
		`view_clientes_nuevos`.`cantidad`
	  FROM
		`meses`
		INNER JOIN `view_clientes_nuevos` ON (`meses`.`id` = `view_clientes_nuevos`.`mes`)
		where anno>=year(curdate())-1
		order by  `view_clientes_nuevos`.`anno`,
		`view_clientes_nuevos`.`mes` asc;";
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function obt_ivas_rev(){		
		$texto_consulta = "SELECT * FROM `view_pais_iva` ;";
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function obt_factura($id_factura){		
		$texto_consulta = "SELECT * FROM `tipo_factura_internacional` where id = $id_factura;";
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function obt_rev_int_iva($id_pais){		
		$texto_consulta = "SELECT iva FROM `pais_iva` where id_pais = $id_pais;";
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		if($resultado->num_rows()==0)
			$ret1=0;
		else {
			$resultado = $resultado->result();
			$ret1 = $resultado[0]->iva;
		}
		
		
		return $ret1;
	}
	public function obt_rev_int_facturas($id_pais){
		$texto_consulta =  "SELECT id_factura as id, factura as nombre from view_factura_paises WHERE id_pais=$id_pais ;";
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		return $resultado;
	}
	public function carga_productos(){
		//$this->db->trans_begin();
			$texto_consulta1 =  "SELECT `puri` FROM `carga1` group by `puri`;";
			$productos = $this->db->query($texto_consulta1);	
			
			foreach ($productos->result() as $key) {
				# code...
				// insertar un producto
				$texto_consulta2 =  "INSERT INTO `productos`( `nombre`, `precio`, `es_repuesto`, `existencia`, `vencimiento`, `reg_cancelado`, `id_categoria`) VALUES ('$key->puri',0,0,0,1,0,1);";
				$productos_i = $this->db->query($texto_consulta2);	
				$id_ultimo_producto = $this->db->insert_id();
				
				// actualizo en carga1 los id de los productos insertados
				$texto_consulta3 =  "UPDATE `carga1` SET `id_producto`=$id_ultimo_producto WHERE puri = '$key->puri';";
				$productos_id = $this->db->query($texto_consulta3);

				$texto_consulta4 =  "INSERT INTO `producto_colores`(`id_producto`, `id_color`) VALUES ($id_ultimo_producto,1);";
				$colores = $this->db->query($texto_consulta4);	
			}
			
		//$this->db->trans_complete();
		// Fin de transacción
		$ret = true;
		/*if ($this->db->trans_status() === FALSE){

	       $this->db->trans_rollback();
		   $ret = false;
		}
		else
		   $this->db->trans_commit();*/
		
		return $ret;
	}
	public function carga_clientes(){
		//$this->db->trans_begin();
			
			$texto_consulta5 =  "SELECT `id`, `numero`, `codigo`, `cliente`, `domicilio`, `codpost`, `telefono`, `puri`, `cantpuri`, `repu`, `id_producto` FROM `carga1` Limit 0,1000;";
			$clientes = $this->db->query($texto_consulta5);
			$contador =0;	
			foreach ($clientes->result() as $key) {
				$contador = $contador + 1;
				# cliente...
				$cliente_1  = str_replace("'","´",$key->cliente);
				$calle_1 = str_replace("'","´",$key->domicilio);
				$tele_1 = str_replace("'","´",$key->telefono);
				
				$texto_consulta6 = "INSERT INTO `clientes`(`id_municipio`, `dni`, `nombre`, `apellidos`, `telefono`, `email`, `en_operacion`, `en_mision`, `reg_cancelado`, `codigo_postal`, `calle`, `nro`, `piso`, `dpto`, `entrecalle1`, `entrecalle2`,  `origen`) VALUES (1,'-','$cliente_1','-','$tele_1','-',0,0,0,'$key->codpost','$calle_1','-','-','-','-','-','Macoi');";
				$clie = $this->db->query($texto_consulta6);
				$id_ultimo_cliente = $this->db->insert_id();

				# pedido...
				$texto_consulta7 = "INSERT INTO `pedidos`(`no_factura`, `referencia`, `id_cliente`, `id_canal`, `id_usuario`, `fecha_solicitud`, `reg_cancelado`, `armado`, `id_tipo_factura`, `recargo`, `calle_entrega`, `nro_entrega`, `piso_entrega`, `dpto_entrega`, `entrecalle1_entrega`, `entrecalle2_entrega`, `iva`, `forma_pago`, `acreditado`, `cupon_promo`, `cupon_nro`, `envio_por_coordinar`, `provincia_entrega`, `municipio_entrega` ) VALUES ('MAC-$contador','MAC-$contador',$id_ultimo_cliente,23,63,'2015-04-07 00:00:00',0,1,1,0,'','','','','','',0,1,1,'','',0,'','');";
				$pedi = $this->db->query($texto_consulta7);
				$id_ultimo_pedido = $this->db->insert_id();

				# detalles...
				$texto_consulta8 = "INSERT INTO `detalles`(`id_pedido`, `id_producto`, `id_campana`, `id_color`, `cantidad`, `precio`, `descuento`, `reg_cancelado`, `descuento_vip`, `incremento`, `notas`, `mail`) VALUES ($id_ultimo_pedido,$key->id_producto,0,1,1,1,0,0,0,0,'','');";
				$deta = $this->db->query($texto_consulta8);
				

			}
		//$this->db->trans_complete();
		// Fin de transacción
		$ret = true;
		/*if ($this->db->trans_status() === FALSE){

	       $this->db->trans_rollback();
		   $ret = false;
		}
		else
		   $this->db->trans_commit();*/
		
		return $ret;
	}
	public function productos_mas_vendido($anno,$mes,$dia)
	{
		$texto_consulta_a = "SELECT `anno`, `id_producto`, `nombre`, max(`cantidad`) as cantidad FROM `view_producto_mas_vendido_anno` WHERE anno = $anno  group by `anno`;";
		$texto_consulta_m = "SELECT `anno`, `mes`, `id_producto`, `nombre`, max(`cantidad`) as cantidad FROM `view_producto_mas_vendido_mes` WHERE anno = $anno and mes = $mes  group by `anno`, `mes`;";
		$texto_consulta_d = "SELECT `anno`, `mes`, `dia`, `id_producto`, `nombre`, max(`cantidad`) as cantidad FROM `view_producto_mas_vendido` WHERE anno = $anno and mes = $mes and dia = $dia group by `anno`, `mes`, `dia`;";

		$resultado_a = $this->db->query($texto_consulta_a);
	    if (!$resultado_a)
			echo $resultado_a;
		$resultado_m = $this->db->query($texto_consulta_m);
	    if (!$resultado_m)
			echo $resultado_m;
		$resultado_d = $this->db->query($texto_consulta_d);
	    if (!$resultado_d)
			echo $resultado_d;
		if($resultado_a->num_rows()>0){
			$po= $resultado_a->result();
			$anno_p=$po[0]->nombre;
			$anno=$po[0]->cantidad;
		}else{
			$anno_p='';
			$anno=0;
		}
		if($resultado_d->num_rows()>0){
			$po= $resultado_d->result();
			$dia_p=$po[0]->nombre;
			$dia=$po[0]->cantidad;
		}else{
			$dia_p='';
			$dia=0;
		}
		if($resultado_m->num_rows()>0){
			$po= $resultado_m->result();
			$mes_p=$po[0]->nombre;
			$mes=$po[0]->cantidad;
		}else{
			$mes_p='';
			$mes=0;
		}
		
		return array("anno_p" => $anno_p,"anno" => $anno, "mes_p" => $mes_p,"mes" => $mes, "dia_p" => $dia_p, "dia" => $dia);
	}
	public function obt_usuario_de_orden($id_orden)
	{
		$texto_consulta =  "SELECT `id_usuario` FROM `pedidos_orden` WHERE id_orden = $id_orden ;";
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		$resu = $resultado->result();
		return $resu[0]->id_usuario;
	}
	public function guardar_tarjeta($id_orden, $tbNoTarjeta, $tbNombre, $tbDni, $tbMes, $tbAnno, $tbCodigo)
	{		
		$texto_consulta =  "INSERT INTO `tarjeta_credito`(`id_orden`, `numero`, `nombre`, `dni`, `hasta_mes`, `hasta_anno`, `codigo`) VALUES ($id_orden,'$tbNoTarjeta','$tbNombre','$tbDni','$tbMes','$tbAnno','$tbCodigo')";

		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	public function cargar_tarjeta($id_orden)
	{
		$texto_consulta =  "SELECT * FROM `tarjeta_credito` WHERE  id_orden = $id_orden ;";
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		return $resultado;
	}
	public function borrar_tarjeta($id_orden)
	{
		$texto_consulta =  "DELETE FROM `tarjeta_credito` WHERE  id_orden = $id_orden ;";
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	public function borrar_cliente($id_cliente)
	{	
		$texto_consulta =  "DELETE FROM `envios_mail` WHERE `id_cliente`=$id_cliente;";
		$resultado = $this->db->query($texto_consulta);
		$texto_consulta =  "DELETE FROM `llamadas_mision` WHERE `id_cliente`=$id_cliente;";
		$resultado = $this->db->query($texto_consulta);
		$texto_consulta =  "DELETE FROM `envios_oca` WHERE id_pedido in (select id_pedido from pedidos where id_cliente=$id_cliente);";
		$resultado = $this->db->query($texto_consulta);
		$texto_consulta =  "DELETE FROM `comisiones_atencion` WHERE id_pedido in (select id_pedido from pedidos where id_cliente=$id_cliente);";
		$resultado = $this->db->query($texto_consulta);
		$texto_consulta =  "DELETE FROM `comisiones_mcoy` WHERE id_pedido in (select id_pedido from pedidos where id_cliente=$id_cliente);";
		$resultado = $this->db->query($texto_consulta);
		$texto_consulta =  "DELETE FROM `comisiones_mision` WHERE id_pedido in (select id_pedido from pedidos where id_cliente=$id_cliente);";
		$resultado = $this->db->query($texto_consulta);
		$texto_consulta =  "DELETE FROM `comisiones_online` WHERE id_pedido in (select id_pedido from pedidos where id_cliente=$id_cliente);";
		$resultado = $this->db->query($texto_consulta);
		$texto_consulta =  "DELETE FROM `entregas_directas` WHERE  id_pedido in (select id_pedido from pedidos where id_cliente=$id_cliente);";
		$resultado = $this->db->query($texto_consulta);
		$texto_consulta =  "DELETE FROM `entregas_envios` WHERE  id_pedido in (select id_pedido from pedidos where id_cliente=$id_cliente);";
		$resultado = $this->db->query($texto_consulta);
		$texto_consulta =  "DELETE FROM `temp_reporte` WHERE  id_pedido in (select id_pedido from pedidos where id_cliente=$id_cliente);";
		$resultado = $this->db->query($texto_consulta);
		$texto_consulta =  "DELETE FROM `notas_clientes` WHERE `id_cliente`=$id_cliente;";
		$resultado = $this->db->query($texto_consulta);
		$texto_consulta =  "DELETE FROM `solicitud_baja` WHERE `id_cliente`=$id_cliente;";
		$resultado = $this->db->query($texto_consulta);
		$texto_consulta =  "DELETE FROM `temp_cartera_productos` WHERE `id_cliente`=$id_cliente;";
		$resultado = $this->db->query($texto_consulta);
		$texto_consulta =  "DELETE FROM `temp_misiones_listas` WHERE `id_cliente`=$id_cliente;";
		$resultado = $this->db->query($texto_consulta);
		$texto_consulta =  "DELETE FROM `reclamo_seguimiento` WHERE  id_reclamo in (select id_reclamo from reclamos where id_cliente=$id_cliente);";
		$resultado = $this->db->query($texto_consulta);
		$texto_consulta =  "DELETE FROM `reclamos` WHERE `id_cliente`=$id_cliente;";
		$resultado = $this->db->query($texto_consulta);
		$texto_consulta =  "DELETE FROM `misiones_f` WHERE  id_mision in (select id_mision from misiones where id_cliente=$id_cliente);";
		$resultado = $this->db->query($texto_consulta);
		$texto_consulta =  "DELETE FROM `misiones_f_hallazgos` WHERE  id_mision in (select id_mision from misiones where id_cliente=$id_cliente);";
		$resultado = $this->db->query($texto_consulta);
		$texto_consulta =  "DELETE FROM `mision_seguimiento` WHERE  id_mision in (select id_mision from misiones where id_cliente=$id_cliente);";
		$resultado = $this->db->query($texto_consulta);
		$texto_consulta =  "DELETE FROM `misiones` WHERE `id_cliente`=$id_cliente;";
		$resultado = $this->db->query($texto_consulta);
		$texto_consulta =  "DELETE FROM  `detalles` WHERE id_pedido in (select id_pedido from pedidos where id_cliente=$id_cliente);";
		$resultado = $this->db->query($texto_consulta);
		$texto_consulta =  "DELETE FROM `pedidos` WHERE `id_cliente`=$id_cliente;";
		$resultado = $this->db->query($texto_consulta);
		$texto_consulta =  "DELETE FROM `clientes` WHERE `id_cliente`=$id_cliente;";
		$resultado = $this->db->query($texto_consulta);
		
		
		
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	public function set_llamadas($id_usuario, $id_cliente, $observ)
	{		
		$this->db->set('id_usuario', $id_usuario);
		$this->db->set('id_cliente', $id_cliente);
		$this->db->set('fecha', date('Y-m-d H:i:s'));
		$this->db->set('observaciones', $observ);
		$query =$this->db->insert('llamadas_mision');
				
		return $query;
	}
	public function get_llamadas( $id_usuario= FALSE)
	{
		if ($id_usuario === FALSE)
		{
			$query = $this->db->get('view_llamadas_mision');
			return $query->result_array();
		}
		$query = $this->db->get_where('view_llamadas_mision', array('id_usuario' => $id_usuario));
		return $query->result_array();
	}
	public function set_cliente_rev($dni,$nombre,$apellidos,$telefono,$email,$codigo_postal,$calle,$nro,
	$piso,$dpto,$entrecalle1,$entrecalle2,$celular,$observaciones,$cuit,$municipio,$usuario)
	{		

		$query = $this->db->get_where('clientes', array('email' => $email));
		$cli = $query->row_array();
		
		if($cli != null){
			//update
			return $cli['id_cliente'];
			
		}else{
			// insert
			$this->db->set('dni', $dni);
			$this->db->set('nombre', $nombre);
			$this->db->set('apellidos', $apellidos);
			$this->db->set('id_municipio', $municipio);
			$this->db->set('telefono', $telefono);
			$this->db->set('email', $email);
			$this->db->set('codigo_postal', $codigo_postal);
			$this->db->set('calle', $calle);
			$this->db->set('nro', $nro);
			$this->db->set('piso', $piso);
			$this->db->set('dpto', $dpto);
			$this->db->set('entrecalle1', $entrecalle1);
			$this->db->set('entrecalle2', $entrecalle2);
			$this->db->set('celular', $celular);
			$this->db->set('observaciones', $observaciones);
			$query =$this->db->insert('clientes');
			$id_ultimo_cli = $this->db->insert_id();

			$texto_consulta1 =  "INSERT INTO `revendedores`(`id_usuario`, `id_cliente`) VALUES ($usuario,$id_ultimo_cli)";
			$resultado1 = $this->db->query($texto_consulta1);
			return $id_ultimo_cli;
		}
	}
	public function set_pedido_rev($clie, $usuario,  $fecha_compra)
	{		
		$par1 = $this->obtener_parametro('CODIGO_PEDIDO');
        $fila1 = $par1->row();
		$consec1 = $fila1->valor;
		$par2 = $this->obtener_parametro('CONSECUTIVO_VENTA');
        $fila2 = $par2->row();
		$consec2 = $fila2->valor;
		$consecutivo 			=$consec1. '-' .$consec2;
		//$consecutivo 			= $this->obtener_parametro('CODIGO_PEDIDO') . '-' . $this->obtener_parametro('CONSECUTIVO_VENTA');
					
		$canal = 'CARGA INICIAL';
		$id_canal = 13;
		$consulta_pedidos = "INSERT INTO pedidos (no_factura, referencia, id_cliente, id_canal, id_usuario, fecha_solicitud, 
		reg_cancelado, armado, id_tipo_factura, recargo, calle_entrega,nro_entrega, piso_entrega, dpto_entrega, 
		entrecalle1_entrega, entrecalle2_entrega) VALUES ('$consecutivo', '$consecutivo',$clie, $id_canal, $usuario,  
		'$fecha_compra', 0,1,1,0, '','', '', '', '', '');";  
		$resultado1 = $this->db->query($consulta_pedidos);
		
		$id_ultimo_ped = $this->db->insert_id();

		$consulta_consecutivo = "UPDATE sys_parametros SET valor = valor + 1 WHERE parametro = 'CONSECUTIVO_VENTA'";
		$resultado1 = $this->db->query($consulta_consecutivo);

		return $id_ultimo_ped;	
	}
	public function set_detalle_rev($id_pedido, $producto,  $cantidad)
	{		
		$pro = "select id_producto from productos Where nombre = '$producto';";
		$res = $this->db->query($pro);
		
		$produ = $res->num_rows();
		
		if($produ > 0){
			$pro = $res->result();
			$id_producto = $pro[0]->id_producto;
			
			$consulta_detalles = "INSERT INTO detalles (id_pedido, id_producto, id_campana, id_color, cantidad, precio, descuento, 
					reg_cancelado, descuento_vip, incremento) VALUES ($id_pedido, " . $id_producto . ", 1, 1, "  . $cantidad. ", 1, 0, 0,0, 0);"; 
			$resultado1 = $this->db->query($consulta_detalles);

			return TRUE;
		}else
		 	return FALSE;
		
	}
	public function get_municipio($usuario)
	{
		$query = $this->db->get_where('datos_revendedores', array('id_usuario' => $usuario));
		$res= $query->row_array();
		
		if(count($res) !=0){
			$muni = $res['id_municipio'];
			
			return $muni;
		}
		return false;
	}
	public function miembrosgrupos($grupo)
	{
		$consulta_detalles = "SELECT * FROM `view_grupo_usuarios` WHERE grupo = '$grupo';"; 
		$resultado = $this->db->query($consulta_detalles);
		if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
}
?>