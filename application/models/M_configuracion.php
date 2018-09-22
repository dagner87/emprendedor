<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_configuracion extends CI_Model {
    
	/*
	 * ------------------------------------------------------
	 *  Atributos
	 * ------------------------------------------------------
	 */
	 
	var $total_clientes;
	var $total_clientes_mision;
	
	/*
	 * ------------------------------------------------------
	 *  Comportamiento
	 * ------------------------------------------------------
	 */

    public function __construct()
    {
        parent::__construct();
    }

    // ------------------------------------------------------
	// Usuarios 
	
	public function usuarios()
	{
		$texto_consulta = "SELECT `id`, `ip_address`, `username`, `password`, `salt`, `email`, `activation_code`, `forgotten_password_code`, `forgotten_password_time`, `remember_code`, `created_on`, `last_login`, `active`, `first_name`, `last_name`, `company`, `phone`, `id_local`, `nombre` FROM view_usuarios;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
			
		return $resultado;
	}
    public function usuarios_esp($id)
	{
		$texto_consulta = "SELECT `id`, `ip_address`, `username`, `password`, `salt`, `email`, `activation_code`, `forgotten_password_code`, `forgotten_password_time`, `remember_code`, `created_on`, `last_login`, `active`, `first_name`, `last_name`, `company`, `phone`, `id_local`, `nombre` FROM view_usuarios where id=$id;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
			
		return $resultado;
	}	
	
	/*
	 * ------------------------------------------------------
	 *  GESTIÓN CLIENTES
	 * ------------------------------------------------------
	 */
	
	// ------------------------------------------------------
	// Clientes
	
	public function clientes()
	{
		$texto_consulta = "SELECT `id_cliente`, `dni`, `municipio`, `provincia`, `nombre`, `telefono`, `email`, `en_operacion`, `en_mision`, `reg_cancelado`, `id_municipio`, `id_provincia`, `apellidos`, `codigo_postal`, `calle`, `nro`, `dpto`, `piso`, `entrecalle1`, `entrecalle2`, `fecha_nacimiento`, `origen`, `vip`, `nivel`, `celular`, `observaciones`, `cuit` FROM view_clientes ;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
			
		return $resultado;
	}
	public function pedido_id($id_pedido)
	{
		$texto_consulta = "SELECT `id_pedido`, `id_cliente`, `nombre_cliente`, `id_canal`, `id_usuario`, `fecha_solicitud`, `first_name`, `no_factura`, `armado`, `apellidos`, `telefono`, `email`, `recargo`, `codigo_postal`, `calle`, `nro`, `piso`, `dpto`, `entrecalle1`, `entrecalle2`, `fecha_nacimiento`, `dni`, `celular`, `canal`, `tipo_factura`, `calle_entrega`, `nro_entrega`, `piso_entrega`, `dpto_entrega`, `entrecalle1_entrega`, `entrecalle2_entrega`, `municipio`, `provincia`, `last_name`, `vip`, `nivel`, `forma_pago`, `acreditado`, `cupon_promo`, `cupon_nro`, `envio_por_coordinar`, `medio_cobranza`, `incluye_seguro` FROM view_pedidos where id_pedido=$id_pedido ;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
			
		return $resultado;
	}
	public function obt_id_pedido($no_factura)
	{
		$texto_consulta = "SELECT id_pedido FROM view_pedidos  where no_factura = '$no_factura';";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		$resultado = $resultado -> result();
		
		return $resultado[0]->id_pedido;
	}
	public function clientes_filtro()
	{
		$texto_consulta = "SELECT `id_cliente`, `dni`, `municipio`, `provincia`, `nombre`, `telefono`, `email`, `en_operacion`, `en_mision`, `reg_cancelado`, `id_municipio`, `id_provincia`, `apellidos`, `codigo_postal`, `calle`, `nro`, `dpto`, `piso`, `entrecalle1`, `entrecalle2`, `fecha_nacimiento`, `origen`, `vip`, `nivel`, `celular`, `observaciones`, `cuit` FROM view_clientes WHERE  nombre like '%$nombre%' and dni like '$dni%' LIMIT 0,100;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
			
		return $resultado;
	}
	public function clientes_all()
	{
		$group = array('Administradores'); 
		if ($this->ion_auth->in_group($group)){
			$texto_consulta = "SELECT HIGH_PRIORITY `c`.`id_cliente`, `c`.`dni`, `m`.`nombre` AS `municipio`, `p`.`nombre` AS `provincia`,  `c`.`nombre`, `c`.`telefono`, `c`.`celular`,  `c`.`email`,  `c`.`en_operacion`,  `c`.`en_mision`,  `c`.`reg_cancelado`,  `c`.`id_municipio`,  `m`.`id_provincia`,  `c`.`apellidos`,  `c`.`codigo_postal`,  `c`.`calle`,  `c`.`nro`,  `c`.`dpto`,  `c`.`piso`,  `c`.`entrecalle1`,  `c`.`entrecalle2`,  `c`.`fecha_nacimiento` FROM  `clientes` `c`  INNER JOIN `municipios` `m` ON (`c`.`id_municipio` = `m`.`id_municipio`)  INNER JOIN `provincias` `p` ON (`m`.`id_provincia` =`p`.`id_provincia`)  LIMIT 0,100 ;";
		}else{
			$texto_consulta = "SELECT `c`.`id_cliente`, `c`.`dni`, `m`.`nombre` AS `municipio`, `p`.`nombre` AS `provincia`,  `c`.`nombre`, `c`.`telefono`, `c`.`celular`,  `c`.`email`,  `c`.`en_operacion`,  `c`.`en_mision`,  `c`.`reg_cancelado`,  `c`.`id_municipio`,  `m`.`id_provincia`,  `c`.`apellidos`,  `c`.`codigo_postal`,  `c`.`calle`,  `c`.`nro`,  `c`.`dpto`,  `c`.`piso`,  `c`.`entrecalle1`,  `c`.`entrecalle2`,  `c`.`fecha_nacimiento` FROM  `clientes` `c`  INNER JOIN `municipios` `m` ON (`c`.`id_municipio` = `m`.`id_municipio`)  INNER JOIN `provincias` `p` ON (`m`.`id_provincia` =`p`.`id_provincia`) WHERE `c`.`id_cliente` not in (select id_cliente from revendedores)  LIMIT 0,100 ;";
		}
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
			
		return $resultado;
	}
	
	public function clientes_all1()
	{
		$texto_consulta = "SELECT HIGH_PRIORITY `c`.`id_cliente` FROM  `clientes` `c`  WHERE `c`.`reg_cancelado` = 0 and `c`.`id_cliente` not in (select id_cliente from revendedores)   ;";
		
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
			
		return $resultado;
	}
	public function clientes_observaciones()
	{
		$texto_consulta = "SELECT `id_cliente`, `dni`, `municipio`, `provincia`, `nombre`, `telefono`, `email`, `en_operacion`, `en_mision`, `reg_cancelado`, `id_municipio`, `id_provincia`, `apellidos`, `codigo_postal`, `calle`, `nro`, `dpto`, `piso`, `entrecalle1`, `entrecalle2`, `fecha_nacimiento`, `origen`, `vip`, `nivel`, `celular`, `observaciones`, `cuit` FROM  `view_clientes`  WHERE `observaciones` <>  ''  LIMIT 0,100;";
		
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
			
		return $resultado;
	}
	public function clientes_observaciones_filtrados($dni, $nombre, $telefono)
	{
		$texto_consulta = "SELECT `id_cliente`, `dni`, `municipio`, `provincia`, `nombre`, `telefono`, `email`, `en_operacion`, `en_mision`, `reg_cancelado`, `id_municipio`, `id_provincia`, `apellidos`, `codigo_postal`, `calle`, `nro`, `dpto`, `piso`, `entrecalle1`, `entrecalle2`, `fecha_nacimiento`, `origen`, `vip`, `nivel`, `celular`, `observaciones`, `cuit` FROM  `view_clientes`  WHERE `observaciones` <> '' ;";
		
		if($nombre != '*'){
			$texto_consulta = $texto_consulta . " and nombre like '%$nombre%'";
		}
		if($telefono != '*'){
			$texto_consulta = $texto_consulta . " and (telefono like '%$telefono%' or celular like '%$telefono%')";
		}
		if($dni != '*'){
			$texto_consulta = $texto_consulta . " and dni like '%$dni%'";
		}

		$texto_consulta = $texto_consulta . " LIMIT 0,100;";

		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
			
		return $resultado;
	}
	public function clientes_vip()
	{
		$group = array('Administradores'); 
		if ($this->ion_auth->in_group($group)){
			$texto_consulta = "SELECT HIGH_PRIORITY `c`.`id_cliente`, `c`.`dni`, `m`.`nombre` AS `municipio`, `p`.`nombre` AS `provincia`,  `c`.`nombre`, `c`.`telefono`, `c`.`celular`,  `c`.`email`,  `c`.`en_operacion`,  `c`.`en_mision`,  `c`.`reg_cancelado`,  `c`.`id_municipio`,  `m`.`id_provincia`,  `c`.`apellidos`,  `c`.`codigo_postal`,  `c`.`calle`,  `c`.`nro`,  `c`.`dpto`,  `c`.`piso`,  `c`.`entrecalle1`,  `c`.`entrecalle2`,  `c`.`fecha_nacimiento`,  `c`.`vip`,  `c`.`nivel` FROM  `clientes` `c`  INNER JOIN `municipios` `m` ON (`c`.`id_municipio` = `m`.`id_municipio`)  INNER JOIN `provincias` `p` ON (`m`.`id_provincia` =`p`.`id_provincia`)  WHERE `c`.`vip` =1 LIMIT 0,100 ;";
		}else{
			$texto_consulta = "SELECT `c`.`id_cliente`, `c`.`dni`, `m`.`nombre` AS `municipio`, `p`.`nombre` AS `provincia`,  `c`.`nombre`, `c`.`telefono`, `c`.`celular`,  `c`.`email`,  `c`.`en_operacion`,  `c`.`en_mision`,  `c`.`reg_cancelado`,  `c`.`id_municipio`,  `m`.`id_provincia`,  `c`.`apellidos`,  `c`.`codigo_postal`,  `c`.`calle`,  `c`.`nro`,  `c`.`dpto`,  `c`.`piso`,  `c`.`entrecalle1`,  `c`.`entrecalle2`,  `c`.`fecha_nacimiento`,  `c`.`vip`,  `c`.`nivel` FROM  `clientes` `c`  INNER JOIN `municipios` `m` ON (`c`.`id_municipio` = `m`.`id_municipio`)  INNER JOIN `provincias` `p` ON (`m`.`id_provincia` =`p`.`id_provincia`) WHERE `c`.`id_cliente` not in (select id_cliente from revendedores) and `c`.`vip` =1 LIMIT 0,100 ;";
		}
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
			
		return $resultado;
	}
	public function clientes_all_filtrado($dni, $nombre, $telefono, $apellidos, $email, $celular)
	{	

		$group = array('Administradores'); 
		if ($this->ion_auth->in_group($group)){
			$texto_consulta = "SELECT HIGH_PRIORITY `c`.`id_cliente`, `c`.`dni`, `m`.`nombre` AS `municipio`, `p`.`nombre` AS `provincia`,  `c`.`nombre`, `c`.`telefono`, `c`.`celular`,  `c`.`email`,  `c`.`en_operacion`,  `c`.`en_mision`,  `c`.`reg_cancelado`,  `c`.`id_municipio`,  `m`.`id_provincia`,  `c`.`apellidos`,  `c`.`codigo_postal`,  `c`.`calle`,  `c`.`nro`,  `c`.`dpto`,  `c`.`piso`,  `c`.`entrecalle1`,  `c`.`entrecalle2`,  `c`.`fecha_nacimiento` FROM  `clientes` `c`  INNER JOIN `municipios` `m` ON (`c`.`id_municipio` = `m`.`id_municipio`)  INNER JOIN `provincias` `p` ON (`m`.`id_provincia` =`p`.`id_provincia`) WHERE 1";
		}else{
			$texto_consulta = "SELECT `c`.`id_cliente`, `c`.`dni`, `m`.`nombre` AS `municipio`, `p`.`nombre` AS `provincia`,  `c`.`nombre`, `c`.`telefono`, `c`.`celular`,  `c`.`email`,  `c`.`en_operacion`,  `c`.`en_mision`,  `c`.`reg_cancelado`,  `c`.`id_municipio`,  `m`.`id_provincia`,  `c`.`apellidos`,  `c`.`codigo_postal`,  `c`.`calle`,  `c`.`nro`,  `c`.`dpto`,  `c`.`piso`,  `c`.`entrecalle1`,  `c`.`entrecalle2`,  `c`.`fecha_nacimiento` FROM  `clientes` `c`  INNER JOIN `municipios` `m` ON (`c`.`id_municipio` = `m`.`id_municipio`)  INNER JOIN `provincias` `p` ON (`m`.`id_provincia` =`p`.`id_provincia`) WHERE `c`.`id_cliente` not in (select id_cliente from revendedores) ";
		}
		if($nombre != '*'){
			$texto_consulta = $texto_consulta . " and c.nombre like '%$nombre%'";
		}
		if($telefono != '*'){
			$texto_consulta = $texto_consulta . " and c.telefono like '%$telefono%'";
		}
		if($dni != '*'){
			$texto_consulta = $texto_consulta . " and dni like '%$dni%'";
		}
		if($apellidos != '*'){
			$texto_consulta = $texto_consulta . " and c.apellidos like '%$apellidos%'";
		}
		if($celular != '*'){
			$texto_consulta = $texto_consulta . " and c.celular like '%$celular%'";
		}
		if($email != '*'){
			$texto_consulta = $texto_consulta . " and c.email like '%$email%'";
		}
		$texto_consulta = $texto_consulta . "  and c.email not in (select email from view_usuarios_clientes) LIMIT 0,100;";

		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
			
		return $resultado;
	}
	public function clientes_rev_filtrado($dni, $nombre, $telefono, $apellidos, $email, $celular)
	{	
		$user = $this->ion_auth->user()->row();			
		$id_usuario = $user->id;

		$texto_consulta = "SELECT `id_cliente`, `dni`, `municipio`, `provincia`, `nombre`, `telefono`, `email`, `en_operacion`, `en_mision`, `reg_cancelado`, `id_municipio`, `id_provincia`, `id_usuario`, `apellidos`, `codigo_postal`, `calle`, `nro`, `piso`, `dpto`, `entrecalle1`, `entrecalle2`, `fecha_nacimiento`, `vip`, `nivel`, `celular`, `observaciones`, `cuit`, `id_pais`, `pais` FROM view_clientes_revendedores where id_usuario= $id_usuario ";

		
		if($nombre != '*'){
			$texto_consulta = $texto_consulta . " and nombre like '%$nombre%'";
		}
		if($telefono != '*'){
			$texto_consulta = $texto_consulta . " and telefono like '%$telefono%'";
		}
		if($dni != '*'){
			$texto_consulta = $texto_consulta . " and dni like '%$dni%'";
		}
		if($apellidos != '*'){
			$texto_consulta = $texto_consulta . " and apellidos like '%$apellidos%'";
		}
		if($celular != '*'){
			$texto_consulta = $texto_consulta . " and celular like '%$celular%'";
		}
		if($email != '*'){
			$texto_consulta = $texto_consulta . " and email like '%$email%'";
		}
		$texto_consulta = $texto_consulta . "  and email not in (select email from view_usuarios_clientes) LIMIT 0,100;";

		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
			
		return $resultado;
	}
	public function clientes_vip_filtrado($dni, $nombre, $telefono,  $email, $celular)
	{	

		$group = array('Administradores'); 
		if ($this->ion_auth->in_group($group)){
			$texto_consulta = "SELECT HIGH_PRIORITY `c`.`id_cliente`, `c`.`dni`, `m`.`nombre` AS `municipio`, `p`.`nombre` AS `provincia`,  `c`.`nombre`, `c`.`telefono`, `c`.`celular`,  `c`.`email`,  `c`.`en_operacion`,  `c`.`en_mision`,  `c`.`reg_cancelado`,  `c`.`id_municipio`,  `m`.`id_provincia`,  `c`.`apellidos`,  `c`.`codigo_postal`,  `c`.`calle`,  `c`.`nro`,  `c`.`dpto`,  `c`.`piso`,  `c`.`entrecalle1`,  `c`.`entrecalle2`,  `c`.`fecha_nacimiento`,  `c`.`vip`,  `c`.`nivel` FROM  `clientes` `c`  INNER JOIN `municipios` `m` ON (`c`.`id_municipio` = `m`.`id_municipio`)  INNER JOIN `provincias` `p` ON (`m`.`id_provincia` =`p`.`id_provincia`) WHERE `c`.`vip` =1";
		}else{
			$texto_consulta = "SELECT `c`.`id_cliente`, `c`.`dni`, `m`.`nombre` AS `municipio`, `p`.`nombre` AS `provincia`,  `c`.`nombre`, `c`.`telefono`, `c`.`celular`,  `c`.`email`,  `c`.`en_operacion`,  `c`.`en_mision`,  `c`.`reg_cancelado`,  `c`.`id_municipio`,  `m`.`id_provincia`,  `c`.`apellidos`,  `c`.`codigo_postal`,  `c`.`calle`,  `c`.`nro`,  `c`.`dpto`,  `c`.`piso`,  `c`.`entrecalle1`,  `c`.`entrecalle2`,  `c`.`fecha_nacimiento`,  `c`.`vip`,  `c`.`nivel` FROM  `clientes` `c`  INNER JOIN `municipios` `m` ON (`c`.`id_municipio` = `m`.`id_municipio`)  INNER JOIN `provincias` `p` ON (`m`.`id_provincia` =`p`.`id_provincia`) WHERE `c`.`id_cliente` not in (select id_cliente from revendedores)and `c`.`vip` =1";
		}
		if($nombre != '*'){
			$texto_consulta = $texto_consulta . " and c.nombre like '%$nombre%'";
		}
		if($telefono != '*'){
			$texto_consulta = $texto_consulta . " and (telefono like '%$telefono%' or celular like '%$telefono%')";
		}
		if($celular != '*'){
			$texto_consulta = $texto_consulta . " and (telefono like '%$celular%' or celular like '%$celular%')";
		}
		if($dni != '*'){
			$texto_consulta = $texto_consulta . " and dni like '%$dni%'";
		}
		if($email != '*'){
			$texto_consulta = $texto_consulta . " and email like '%$email%'";
		}

		$texto_consulta = $texto_consulta . " LIMIT 0,100;";

		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
			
		return $resultado;
	}
	public function clientes_revendedores_filtro($id_usuario, $nombre, $dni, $telefono, $apellidos, $email, $celular)
	{
		$texto_consulta = "SELECT `id_cliente`, `dni`, `municipio`, `provincia`, `nombre`, `telefono`, `email`, `en_operacion`, `en_mision`, `reg_cancelado`, `id_municipio`, `id_provincia`, `id_usuario`, `apellidos`, `codigo_postal`, `calle`, `nro`, `piso`, `dpto`, `entrecalle1`, `entrecalle2`, `fecha_nacimiento`, `vip`, `nivel`, `celular`, `observaciones`, `cuit`, `id_pais`, `pais` FROM view_clientes_revendedores  ";
		if($nombre != '1'){
			$texto_consulta = $texto_consulta."where id_usuario= $id_usuario and nombre like '%$nombre%'";
		}else{
			$nombre='';
			$texto_consulta = $texto_consulta."where id_usuario= $id_usuario and nombre like '%$nombre%'";
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
		$texto_consulta = $texto_consulta."   LIMIT 0,100;";

		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
			
		return $resultado;
	}
	public function clientes_revendedores($id_usuario)
	{
		$texto_consulta = "SELECT `id_cliente`, `dni`, `municipio`, `provincia`, `nombre`, `telefono`, `email`, `en_operacion`, `en_mision`, `reg_cancelado`, `id_municipio`, `id_provincia`, `id_usuario`, `apellidos`, `codigo_postal`, `calle`, `nro`, `piso`, `dpto`, `entrecalle1`, `entrecalle2`, `fecha_nacimiento`, `vip`, `nivel`, `celular`, `observaciones`, `cuit`, `id_pais`, `pais` FROM view_clientes_revendedores where id_usuario= $id_usuario LIMIT 0,1000;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
			
		return $resultado;
	}
	public function clientes_revendedores1($id_usuario, $id_cliente)
	{
		$texto_consulta = "SELECT `id_cliente`, `dni`, `municipio`, `provincia`, `nombre`, `telefono`, `email`, `en_operacion`, `en_mision`, `reg_cancelado`, `id_municipio`, `id_provincia`, `id_usuario`, `apellidos`, `codigo_postal`, `calle`, `nro`, `piso`, `dpto`, `entrecalle1`, `entrecalle2`, `fecha_nacimiento`, `vip`, `nivel`, `celular`, `observaciones`, `cuit`, `id_pais`, `pais` FROM view_clientes_revendedores where id_usuario= $id_usuario and id_cliente = $id_cliente  and email not in (select email from view_usuarios_clientes)  LIMIT 0,1000;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
			
		return $resultado;
	}
	public function clientes_revendedoresint($id_usuario,$id_cliente)
	{
		$texto_consulta = "SELECT `id_cliente`, `dni`, `municipio`, `provincia`, `nombre`, `telefono`, `email`, `en_operacion`, `en_mision`, `reg_cancelado`, `id_municipio`, `id_provincia`, `id_usuario`, `apellidos`, `codigo_postal`, `calle`, `nro`, `piso`, `dpto`, `entrecalle1`, `entrecalle2`, `fecha_nacimiento`, `vip`, `nivel`, `celular`, `observaciones`, `cuit`, `id_pais`, `pais` FROM view_clientes_revendedores where id_usuario= $id_usuario  and id_cliente = $id_cliente and email not in (select email from view_usuarios_clientes)  LIMIT 0,100;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
			
		return $resultado;
	}
	public function clientes_revendedores_mision($id_usuario, $id_cliente)
	{
		$texto_consulta = "SELECT `id_cliente`, `dni`, `municipio`, `provincia`, `nombre`, `telefono`, `email`, `en_operacion`, `en_mision`, `reg_cancelado`, `id_municipio`, `id_provincia`, `id_usuario`, `apellidos`, `codigo_postal`, `calle`, `nro`, `piso`, `dpto`, `entrecalle1`, `entrecalle2`, `fecha_nacimiento`, `vip`, `nivel`, `celular`, `observaciones`, `cuit`, `id_pais`, `pais` FROM view_clientes_revendedores where id_usuario= $id_usuario and id_cliente= $id_cliente;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
			
		return $resultado;
	}
	// ------------------------------------------------------
	// Clientes

	public function clientes_mision()
	{
		$texto_consulta = "SELECT `id_cliente`, `dni`, `municipio`, `provincia`, `nombre`, `telefono`, `email`, `en_operacion`, `en_mision`, `reg_cancelado`, `id_municipio`, `id_provincia`, `apellidos`, `codigo_postal`, `calle`, `nro`, `dpto`, `piso`, `entrecalle1`, `entrecalle2`, `fecha_nacimiento`, `origen`, `vip`, `nivel`, `celular`, `observaciones`, `cuit` FROM view_clientes WHERE (en_mision);";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
			
		return $resultado;
	}
	public function clientes_operacion()
	{
		$texto_consulta = "SELECT `id_cliente`, `dni`, `municipio`, `provincia`, `nombre`, `telefono`, `email`, `en_operacion`, `en_mision`, `reg_cancelado`, `id_municipio`, `id_provincia`, `apellidos`, `codigo_postal`, `calle`, `nro`, `dpto`, `piso`, `entrecalle1`, `entrecalle2`, `fecha_nacimiento`, `origen`, `vip`, `nivel`, `celular`, `observaciones`, `cuit` FROM view_clientes WHERE (en_operacion);";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
			
		return $resultado;
	}
	public function clientes_cancelados()
	{
		$texto_consulta = "SELECT `id_cliente`, `id_municipio`, `dni`, `nombre`, `apellidos`, `direccion`, `telefono`, `email`, `en_operacion`, `en_mision`, `reg_cancelado`, `codigo_postal`, `calle`, `nro`, `piso`, `dpto`, `entrecalle1`, `entrecalle2`, `fecha_nacimiento`, `origen`, `vip`, `nivel`, `celular`, `observaciones`, `cuit` FROM clientes WHERE (reg_cancelado);";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
			
		return $resultado;
	}
	public function clientes_vip_mision()
	{
		$texto_consulta = "SELECT `id_cliente`, `dni`, `municipio`, `provincia`, `nombre`, `telefono`, `email`, `en_operacion`, `en_mision`, `reg_cancelado`, `id_municipio`, `id_provincia`, `apellidos`, `codigo_postal`, `calle`, `nro`, `dpto`, `piso`, `entrecalle1`, `entrecalle2`, `fecha_nacimiento`, `origen`, `vip`, `nivel`, `celular`, `observaciones`, `cuit` FROM view_clientes WHERE (en_mision) and vip;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
			
		return $resultado;
	}
	public function clientes_vip_operacion()
	{
		$texto_consulta = "SELECT `id_cliente`, `dni`, `municipio`, `provincia`, `nombre`, `telefono`, `email`, `en_operacion`, `en_mision`, `reg_cancelado`, `id_municipio`, `id_provincia`, `apellidos`, `codigo_postal`, `calle`, `nro`, `dpto`, `piso`, `entrecalle1`, `entrecalle2`, `fecha_nacimiento`, `origen`, `vip`, `nivel`, `celular`, `observaciones`, `cuit`  FROM view_clientes WHERE (en_operacion) and vip;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
			
		return $resultado;
	}
	public function clientes_vip_cancelados()
	{
		$texto_consulta = "SELECT `id_cliente`, `id_municipio`, `dni`, `nombre`, `apellidos`, `direccion`, `telefono`, `email`, `en_operacion`, `en_mision`, `reg_cancelado`, `codigo_postal`, `calle`, `nro`, `piso`, `dpto`, `entrecalle1`, `entrecalle2`, `fecha_nacimiento`, `origen`, `vip`, `nivel`, `celular`, `observaciones`, `cuit` FROM clientes WHERE (reg_cancelado) and vip;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
			
		return $resultado;
	}
	// ------------------------------------------------------
	// Registrar cliente
	
	public function registrar_cliente($dni, $id_municipio, $nombre, $apellidos, $telefono, $celular, $email, $codigo_postal, $calle, $nro, $piso, $dpto, $entrecalle1, $entrecalle2, $vip, $nivel,$fecha_nacimiento, $observaciones, $cuit )
	{
		$nombre = str_replace("'","´",$nombre);
		$apellidos = str_replace("'","´",$apellidos);

		$texto_consulta =  "INSERT IGNORE INTO clientes (dni, id_municipio, nombre, apellidos, telefono,celular, email, codigo_postal, calle, nro, piso, dpto, entrecalle1, entrecalle2, en_operacion, en_mision, reg_cancelado, vip, nivel, fecha_nacimiento, observaciones, cuit)" 
		                  . " VALUES('$dni', '$id_municipio', '$nombre', '$apellidos', '$telefono', '$celular', '$email', '$codigo_postal', '$calle', '$nro', '$piso', '$dpto', '$entrecalle1', '$entrecalle2', 0, 0, 0, $vip, $nivel, '$fecha_nacimiento', '$observaciones', '$cuit');";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	
	// ------------------------------------------------------
	// Un cliente
	public function obt_id_cliente($dni)
	{
		$texto_consulta = "SELECT id_cliente FROM clientes  where dni = $dni;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		$resultado = $resultado -> result();
		return $resultado[0]->id_cliente;
	}
	//// *******************
	public function obt_cliente($id_actual)
	{
		$texto_consulta = "SELECT c.id_cliente, c.dni, c.id_municipio, m.id_provincia, c.nombre,c.apellidos, c.telefono,c.celular, c.email, c.codigo_postal, c.calle, c.nro, c.piso, c.dpto, c.entrecalle1, c.entrecalle2, c.fecha_nacimiento, c.en_mision, c.en_operacion, c.reg_cancelado, c.vip, c.nivel, c.observaciones, c.cuit, m.nombre as municipio, q.nombre as provincia, c.inactivo				
						   FROM clientes c 
						   inner join municipios m on (c.id_municipio = m.id_municipio) inner join provincias q on (m.id_provincia = q.id_provincia)
						   where c.id_cliente = $id_actual;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	
	// ------------------------------------------------------
	// Modificar cliente
	
	public function modificar_cliente($id_actual, $dni, $id_municipio, $nombre,$apellidos, $telefono,$celular, $email, $codigo_postal, $calle, $nro, $piso, $dpto, $entrecalle1, $entrecalle2, $fecha_nacimiento, $en_mision, $en_operacion, $reg_cancelado, $vip, $nivel, $observaciones, $cuit)
	{
		$nombre = str_replace("'","´",$nombre);
		$apellidos = str_replace("'","´",$apellidos);

		$texto_consulta =  "UPDATE IGNORE clientes SET 
		                    dni='$dni', 
							id_municipio='$id_municipio', 
							nombre='$nombre', 
							apellidos='$apellidos', 
							telefono='$telefono', 
							celular='$celular',
							email='$email', 
							codigo_postal='$codigo_postal',
							calle='$calle',
							nro='$nro',
							piso='$piso',
							dpto='$dpto',
							entrecalle1='$entrecalle1', 
							entrecalle2='$entrecalle2',
							en_mision = $en_mision,
							en_operacion = $en_operacion,
							reg_cancelado = $reg_cancelado,
							fecha_nacimiento = '$fecha_nacimiento',
							vip = $vip,
							nivel = $nivel,
							observaciones= '$observaciones',
							cuit= '$cuit'
							WHERE (id_cliente = $id_actual);"; 
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	
	// ------------------------------------------------------
	// Cancelar cliente
	
	public function cancelar_cliente($id_cliente)
	{
		$texto_consulta =  "UPDATE clientes SET reg_cancelado = 1 WHERE (id_cliente=$id_cliente);"; 
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	
	// ------------------------------------------------------
	// DASHBOARD - clientes
	public function total_clientes() 
	{ 
	    $res = $this->clientes_all1(); 
	    $this->total_clientes = $res->num_rows();
		return $this->total_clientes; 
	}
	public function total_clientes_mision() 
	{ 
	    $res = $this->clientes_mision();
	    $this->total_clientes_mision = $res->num_rows();
		return $this->total_clientes_mision; 
	}
	 public function total_clientes_operacion() 
	{ 
	    $res = $this->clientes_operacion();
	    $this->total_clientes_operacion = $res->num_rows();
		return $this->total_clientes_operacion; 
	}
	public function total_clientes_cancelados() 
	{ 
	    $res = $this->clientes_cancelados();
	    $this->total_clientes_cancelados = $res->num_rows();
		return $this->total_clientes_cancelados; 
	}
	public function total_clientes_vip() 
	{ 
	    $res = $this->clientes_vip(); 
	    $this->total_clientes = $res->num_rows();
		return $this->total_clientes; 
	}
	public function total_clientes_vip_mision() 
	{ 
	    $res = $this->clientes_vip_mision();
	    $this->total_clientes_mision = $res->num_rows();
		return $this->total_clientes_mision; 
	}
	 public function total_clientes_vip_operacion() 
	{ 
	    $res = $this->clientes_vip_operacion();
	    $this->total_clientes_operacion = $res->num_rows();
		return $this->total_clientes_operacion; 
	}
	public function total_clientes_vip_cancelados() 
	{ 
	    $res = $this->clientes_vip_cancelados();
	    $this->total_clientes_cancelados = $res->num_rows();
		return $this->total_clientes_cancelados; 
	}
	// ------------------------------------------------------
	// Canales de entrada
	public function obt_canales_entrada()
	{
		$texto_consulta = "select * from canales;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	
	//*******************************************************************************************************

	
	// ------------------------------------------------------
	// Municipios de una provincia
	public function municipios_provincia($id_provincia)
	{
		$texto_consulta = "SELECT `id_municipio`, `id_provincia`, `nombre_provincia`, `nombre_municipio`, `id_pais`, `nombre_pais`, `codigopostal` FROM view_municipios WHERE id_provincia = '$id_provincia'";
		
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function productos_combo($id_combo)
	{
		$texto_consulta = "SELECT `id_combo`, `id_producto`, `nombre`, `cantidad` FROM `view_combo_productos` WHERE  id_combo = '$id_combo'";
		
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function provincias_pais($id_pais)
	{
		$texto_consulta = "SELECT * FROM provincias WHERE id_pais = '$id_pais'";
		
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	//*******************************************************************************************************
	// Listar clientes
	public function obt_clientes()
	{
		$texto_consulta = "SELECT `id_cliente`, `id_municipio`, `dni`, `nombre`, `apellidos`, `direccion`, `telefono`, `email`, `en_operacion`, `en_mision`, `reg_cancelado`, `codigo_postal`, `calle`, `nro`, `piso`, `dpto`, `entrecalle1`, `entrecalle2`, `fecha_nacimiento`, `origen`, `vip`, `nivel`, `celular`, `observaciones`, `cuit` from clientes;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function obt_clientes_rev($id_usuario)
	{
		$texto_consulta = "SELECT `id_cliente` from revendedores where id_usuario = $id_usuario;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado->num_rows();
	}
	public function obt_clientes_lim()
	{
		$texto_consulta = "SELECT `id_cliente`, `id_municipio`, `dni`, `nombre`, `apellidos`, `direccion`, `telefono`, `email`, `en_operacion`, `en_mision`, `reg_cancelado`, `codigo_postal`, `calle`, `nro`, `piso`, `dpto`, `entrecalle1`, `entrecalle2`, `fecha_nacimiento`, `origen`, `vip`, `nivel`, `celular`, `observaciones`, `cuit` from clientes LIMIT 0,100;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	/*
	 * ------------------------------------------------------
	 *  GESTIÓN MISIONES
	 * ------------------------------------------------------
	 */
	
	// ------------------------------------------------------
	// Misiones
	
	public function misiones($usuario)
	{
		$texto_consulta = "SELECT `id_mision`, `id_cliente`, `fecha_inicio`, `fecha_fin`, `exitosa`, `notas`, `nombre_cliente`, `first_name`, `id_usuario`, `usuario`, `email`, `id_pedido`, `crv` FROM view_misiones Where  `fecha_fin` >= FROM_UNIXTIME(UNIX_TIMESTAMP(), '%Y-%m-%d %H.%i.%s') and  `id_usuario` = $usuario;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
			
		return $resultado;
	}
	public function misiones_filtrada($usuario,$nombre)
	{
		$texto_consulta = "SELECT `id_mision`, `id_cliente`, `fecha_inicio`, `fecha_fin`, `exitosa`, `notas`, `nombre_cliente`, `first_name`, `id_usuario`, `usuario`, `email`, `id_pedido`, `crv` FROM view_misiones Where  `fecha_fin` >= FROM_UNIXTIME(UNIX_TIMESTAMP(), '%Y-%m-%d %H.%i.%s') and nombre_cliente like '%$nombre%';";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
			
		return $resultado;
	}
	public function misiones_revendedores($usuario)
	{
		$texto_consulta = "SELECT `id_mision`, `id_cliente`, `fecha_inicio`, `fecha_fin`, `exitosa`, `notas`, `nombre_cliente`, `first_name`, `usuario`, `email`, `id_pedido`, `id_usuario`, `crv` FROM view_misiones_revendedores Where id_usuario = $usuario;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
			
		return $resultado;
	}
	// ------------------------------------------------------
	// Misiones aceptadas
	
	public function misiones_aceptadas()
	{
		$texto_consulta = "SELECT `id_mision`, `id_cliente`, `fecha_inicio`, `fecha_fin`, `exitosa`, `notas`, `nombre_cliente`, `first_name`, `id_usuario`, `usuario`, `email`, `id_pedido`, `crv` FROM view_misiones WHERE (exitosa=1);";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
			
		return $resultado;
	}
	
	// ------------------------------------------------------
	// Misiones rechazadas
	
	public function misiones_rechazadas()
	{
		$texto_consulta = "SELECT `id_mision`, `id_cliente`, `fecha_inicio`, `fecha_fin`, `exitosa`, `notas`, `nombre_cliente`, `first_name`, `id_usuario`, `usuario`, `email`, `id_pedido`, `crv` FROM view_misiones WHERE (exitosa=0);";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
			
		return $resultado;
	}
	
	// ------------------------------------------------------
	// DASHBOARD - misiones
	public function total_misiones() 
	{ 	$user = $this->ion_auth->user()->row();

	    $res = $this->misiones_cant_usuario($user->id); 
	    return $res->num_rows();
	}
	public function misiones_cant_usuario($usuario)
 	{
		$texto_consulta = "SELECT `id_mision`, `id_cliente`, `fecha_inicio`, `fecha_fin`, `exitosa`, `notas`, `nombre_cliente`, `first_name`, `id_usuario`, `usuario`, `email`, `id_pedido`, `crv` FROM view_misiones Where id_usuario = $usuario and `fecha_fin` >= FROM_UNIXTIME(UNIX_TIMESTAMP(), '%Y-%m-%d %H.%i.%s');";
		$resultado = $this->db->query($texto_consulta);
		if (!$resultado)
			echo $resultado;
		return $resultado;
 	}
	public function total_misiones_aceptadas() 
	{ 
	    $res = $this->misiones_aceptadas(); 
	    return $res->num_rows();
	}
	public function total_misiones_rechazadas() 
	{ 
	    $res = $this->misiones_rechazadas(); 
	    return $res->num_rows();
	}
	
	// ------------------------------------------------------
	// Registrar mision
	
	public function registrar_mision($id_usuario, $id_cliente, $fecha_inicio, $fecha_final, $exitosa, $notas, $id_pedido_mision)
	{
		$texto_consulta =  "INSERT IGNORE INTO misiones (id_usuario, id_cliente, fecha_inicio, fecha_fin, exitosa, notas, id_pedido)" 
		                  . " VALUES('$id_usuario', '$id_cliente', '$fecha_inicio', '$fecha_final', $exitosa, '$notas', $id_pedido_mision);";
		
		$resultado = $this->db->query($texto_consulta);
			    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	
	// ------------------------------------------------------
	// Una misión 
	
	public function obt_mision($id_actual)
	{
		$texto_consulta = "SELECT `id_mision`, `id_cliente`, `fecha_inicio`, `fecha_fin`, `exitosa`, `notas`, `nombre_cliente`, `first_name`, `id_usuario`, `usuario`, `email`, `id_pedido`, `crv` FROM view_misiones WHERE id_mision=$id_actual;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	
	// ------------------------------------------------------
	// Modificar mision
	
	public function modificar_mision_propuesta($id_actual, $exitosa, $notas)
	{
		$texto_consulta =  "UPDATE IGNORE misiones SET 		                     
							exitosa=$exitosa, 
							notas='$notas' 
							WHERE (id_mision = $id_actual);"; 
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	public function modificar_mision($id_actual, $id_usuario, $id_cliente, $fecha_inicio, $fecha_final, $exitosa, $notas)
	{
		$texto_consulta =  "UPDATE IGNORE misiones SET 
		                    id_usuario='$id_usuario', 
							id_cliente='$id_cliente', 
							fecha_inicio='$fecha_inicio', 
							fecha_fin='$fecha_final', 
							exitosa=$exitosa, 
							notas='$notas' 
							WHERE (id_mision = $id_actual);"; 
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	
	// ------------------------------------------------------
	// Eliminar una misión
	
	public function eliminar_mision($id_mision)
	{
		$texto_consulta =  "DELETE from misiones WHERE (id_mision='$id_mision');"; 
		
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
		$texto_consulta = "SELECT `id_producto`, `nombre`, `precio`, `es_repuesto`, `existencia`, `vencimiento`, `reg_cancelado`, `alto`, `ancho`, `largo`, `peso`, `sku`, `codigo_barra`, `id_categoria`, `valor_declarado`, `dum14`, `precio_rev`,precio_mayorista,cant_min_rev,cant_min_may,disponible_a_rev FROM productos where id_producto = '$id_actual';";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	
	public function obt_combo($id_actual)
	{
		$texto_consulta = "SELECT * FROM `combos_rev` where id_producto = '$id_actual';";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function obt_producto_rev_int($id_producto,$id_pais)
	{
		$texto_consulta = "SELECT `id_producto`, `nombre`, `precio`, `es_repuesto`, `existencia`, `vencimiento`, `reg_cancelado`, `alto`, `ancho`, `largo`, `peso`, `sku`, `codigo_barra`, `id_categoria`, `valor_declarado`, `dum14`, `precio` as `precio_rev`,cant_min_revint, cant_min_mayint,precio_mayorista FROM view_productos_paises where id_producto = '$id_producto' and id_pais = $id_pais;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function obt_combo_rev_int($id_producto,$id_pais)
	{
		$texto_consulta = "SELECT * FROM view_combos_paises where id_combo = '$id_producto' and id_pais = $id_pais;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function obt_existencia_producto($id_producto)
	{
		$user = $this->ion_auth->user()->row();
		$usuario_act= $user->id;
		$texto_consulta = "SELECT * FROM `producto_revendedores` where id_producto = $id_producto and id_revendedor=$usuario_act;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	//*******************************************************************************************************
	// Listar productos
	public function obt_productos()
	{
		$texto_consulta = "SELECT `id_producto`, `nombre`, `precio`, `es_repuesto`, `existencia`, `vencimiento`, `reg_cancelado`, `alto`, `ancho`, `largo`, `peso`, `sku`, `codigo_barra`, `id_categoria`, `valor_declarado`, `dum14`, `precio_rev`,disponible_a_rev	FROM productos;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function obt_productos_rev()
	{
		$texto_consulta = "SELECT `id_producto`, `nombre`, `precio`, `es_repuesto`, `existencia`, `vencimiento`, `reg_cancelado`, `alto`, `ancho`, `largo`, `peso`, `sku`, `codigo_barra`, `id_categoria`, `valor_declarado`, `dum14`, `precio_rev`,disponible_a_rev	FROM productos where disponible_a_rev=1;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function obt_categorias()
	{
		$texto_consulta = "SELECT *	FROM categorias;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function obt_productos_solos()
	{
		$texto_consulta = "SELECT `id_producto`, `nombre`, `precio`, `es_repuesto`, `existencia`, `vencimiento`, `reg_cancelado`, `alto`, `ancho`, `largo`, `peso`, `sku`, `codigo_barra`, `id_categoria`, `valor_declarado`, `dum14`	FROM productos where es_repuesto = 0;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function obt_repuestos_solos()
	{
		$texto_consulta = "SELECT `id_producto`, `nombre`, `precio`, `es_repuesto`, `existencia`, `vencimiento`, `reg_cancelado`, `alto`, `ancho`, `largo`, `peso`, `sku`, `codigo_barra`, `id_categoria`, `valor_declarado`, `dum14`, `precio_rev`	FROM productos where es_repuesto = 1;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function obt_productos_sin_colores()
	{
		$texto_consulta = "SELECT `id_producto`, `nombre`	FROM view_productos_sin_colores;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function obt_combos_sin_productos()
	{
		$texto_consulta = "SELECT `id_producto`, `nombre`	FROM view_combos_sin_productos;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function obt_productos_para_campanas()
	{
		$texto_consulta = "SELECT `id_producto`, `nombre`, `precio`, `es_repuesto`, `existencia`, `vencimiento`, `reg_cancelado`, `alto`, `ancho`, `largo`, `peso`, `sku`, `codigo_barra`, `id_categoria`, `valor_declarado`, `dum14`, `precio_rev`	FROM productos where es_repuesto=0;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function obt_productos_para_campanas_rev()
	{
		$texto_consulta = "SELECT `id_producto`, `nombre`, `precio`, `es_repuesto`, `existencia`, `vencimiento`, `reg_cancelado`, `alto`, `ancho`, `largo`, `peso`, `sku`, `codigo_barra`, `id_categoria`, `valor_declarado`, `dum14`, `precio_rev`	FROM productos where  disponible_a_rev=1;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	//*******************************************************************************************************
	// Registrando un producto
	public function registrar_producto( $nombre, $precio, $existencia, $es_repuesto, $vencimiento, $alto, $ancho, $largo, $peso, $sku, $codigo_barra, $id_categoria, $valor_declarado, $dum14, $disponible_a_rev)
	{
		$texto_consulta =  "INSERT INTO productos ( nombre, precio, existencia, es_repuesto, vencimiento,alto, ancho, largo, peso, sku, codigo_barra, id_categoria, valor_declarado, dum14, disponible_a_rev)" 
		                  . " VALUES('$nombre', $precio,$existencia, $es_repuesto, $vencimiento,$alto, $ancho, $largo, $peso, '$sku', '$codigo_barra', $id_categoria, $valor_declarado,'$dum14',$disponible_a_rev);";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	public function registrar_combo( $nombre, $precio_may,$precio_rev,$min_may,$min_rev, $existencia)
	{
		$texto_consulta =  "INSERT INTO `combos_rev`(`nombre`, `existencia`,  `reg_cancelado`, `precio_rev`, `precio_mayorista`, `cant_min_rev`, `cant_min_may`)" 
		                  . " VALUES('$nombre',$existencia, 0,$precio_rev, $precio_may,$min_rev,$min_may);";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	//*******************************************************************************************************
	// Modificando  un producto
	public function modificar_producto($id_actual, $nombre, $precio,$existencia, $es_repuesto, $vencimiento, $alto, $ancho, $largo, $peso, $sku, $codigo_barra, $id_categoria, $valor_declarado, $dum14,$disponible_a_rev)
	{
		$texto_consulta =  "UPDATE IGNORE productos SET 
		                    nombre='$nombre', 
							precio=$precio, 
							existencia= $existencia,
							es_repuesto=$es_repuesto, 
							vencimiento=$vencimiento,
							alto=$alto, 
							ancho= $ancho,
							largo=$largo, 
							peso=$peso,
							sku='$sku',
							codigo_barra='$codigo_barra',
							id_categoria = $id_categoria,
							valor_declarado = $valor_declarado,
							dum14 = '$dum14',
							disponible_a_rev = $disponible_a_rev
							WHERE (id_producto = '$id_actual');"; 
		                    
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	public function modificar_combo($id_actual, $nombre, $precio_may,$precio_rev,$min_may,$min_rev,$existencia, $alto, $ancho, $largo, $peso, $sku, $codigo_barra, $id_categoria, $valor_declarado, $dum14,$imagen)
	{		
		$texto_consulta =  " UPDATE `combos_rev` SET `nombre`='$nombre',
							`existencia`=$existencia,							
							alto=$alto, 
							ancho= $ancho,
							largo=$largo, 
							peso=$peso,
							sku='$sku',
							codigo_barra='$codigo_barra',
							id_categoria = $id_categoria,
							valor_declarado = $valor_declarado,
							dum14 = '$dum14',
							`precio_rev`=$precio_rev,
							`precio_mayorista`=$precio_may,
							`cant_min_rev`=$min_rev,
							`cant_min_may`=$min_may,
							`imagen`='$imagen' 
							WHERE (id_producto = '$id_actual');";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	public function guardar_img_combo($id_actual, $imagen)
	{		
		$texto_consulta =  " UPDATE `combos_rev` SET 
							`imagen`='$imagen' 
							WHERE (id_producto = '$id_actual');";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	public function modificar_producto_rev($id_actual, $nombre, $precio_may,$precio_rev,$existencia, $es_repuesto, $vencimiento, $alto, $ancho, $largo, $peso, $sku, $codigo_barra, $id_categoria, $valor_declarado, $dum14,$min_may,$min_rev)
	{
		$texto_consulta =  "UPDATE IGNORE productos SET 
		                    cant_min_may = $min_may,
							cant_min_rev = $min_rev,
							precio_mayorista=$precio_may,
							precio_rev=$precio_rev
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
		$texto_consulta =  "DELETE FROM productos WHERE (id_producto=$id_producto) and id_producto not in (select id_producto from detalles);"; 
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	public function cancelar_combo($id_producto)
	{
		$texto_consulta =  "DELETE FROM combos_rev WHERE (id_producto=$id_producto) and id_producto not in (select id_combo as id_producto from combo_productos);"; 
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
    // ------------------------------------------------------
	// DASHBOARD - productos
	public function total_productos() 
	{ 
	    $res = $this->obt_productos(); 
	    $this->total_productos = $res->num_rows();
		return $this->total_productos; 
	}
	public function total_productos_repuesto() 
	{ 
	    $res = $this->productos_repuesto();
	    $this->total_productos_repuesto = $res->num_rows();
		return $this->total_productos_repuesto; 
	}
    // Obtener los datos de un producto repuesto
	public function productos_repuesto()
	{
		$texto_consulta = "SELECT `id_producto`, `nombre`, `precio`, `es_repuesto`, `existencia`, `vencimiento`, `reg_cancelado`, `alto`, `ancho`, `largo`, `peso`, `sku`, `codigo_barra`, `id_categoria`, `valor_declarado`, `dum14`, `precio_rev` FROM productos where (es_repuesto);";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	
	// ------------------------------------------------------
    //*******************************************************************************************************
    //*******************************************************************************************************
    //*******************************************************************************************************
	//     Empresa
	//*******************************************************************************************************
    //*******************************************************************************************************
	// Obtener los datos de un empresa
	public function obt_empresa($id_actual)
	{
		$texto_consulta = "SELECT * FROM empresas_flete where id_empresa = '$id_actual';";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	//*******************************************************************************************************
	// Listar empresas
	public function obt_empresas()
	{
		$texto_consulta = "SELECT *	FROM empresas_flete;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	//*******************************************************************************************************
	// Registrando un empresa
	public function registrar_empresa( $descripcion, $direccion,  $telefono, $email)
	{
		$descripcion = str_replace("'","´",$descripcion);
		
		$texto_consulta =  "INSERT IGNORE INTO empresas_flete (nombre, direccion,  telefono, email)" 
		                  . " VALUES('$descripcion', '$direccion',  '$telefono', '$email');";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	//*******************************************************************************************************
	// Modificando  un empresa
	public function modificar_empresa($id_actual, $id_empresa, $descripcion, $direccion, $telefono, $email)
	{
		$descripcion = str_replace("'","´",$descripcion);

		$texto_consulta =  "UPDATE IGNORE empresas_flete SET 
		                    id_empresa='$id_empresa', 
		                    nombre='$descripcion', 
							direccion='$direccion',							
							telefono='$telefono', 
							email='$email'
							WHERE (id_empresa = '$id_actual');"; 
		                    
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	//*******************************************************************************************************
	// Cancelando un empresa
	public function cancelar_empresa($id_empresa)
	{
		$texto_consulta =  "DELETE FROM empresas_flete WHERE (id_empresa='$id_empresa');"; 
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
    //*******************************************************************************************************
    // DASHBOARD - empresas
	public function total_empresas() 
	{ 
	    $res = $this->obt_empresas(); 
	    $this->total_empresas = $res->num_rows();
		return $this->total_empresas; 
	}
        //*******************************************************************************************************
    // Un cliente
	public function obt_id_empresa($descripcion, $direccion)
	{
		$texto_consulta = "SELECT id_empresa FROM empresas_flete  where nombre = '$descripcion'  and direccion= '$direccion' ;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		$resultado = $resultado -> result();
		return $resultado[0]->id_empresa;
	}
	//// *******************
	//*******************************************************************************************************
	//     Revendedor
	//*******************************************************************************************************
    //*******************************************************************************************************
	// Obtener los datos de un revendedor
	public function obt_revendedor($id_actual)
	{
		$texto_consulta = "SELECT * FROM revendedores where id = '$id_actual';";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	//*******************************************************************************************************
	// Listar revendedores
	public function obt_revendedores()
	{
		$texto_consulta = "SELECT m.*,p.nombre, p.apellidos, n.username, n.first_name, n.last_name FROM revendedores m
                            INNER JOIN clientes p ON (m.id_cliente = p.id_cliente)
                            INNER JOIN usuarios n ON (m.id_usuario = n.id);";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
    public function obt_revendedores1()
	{
		$texto_consulta = "SELECT id_usuario FROM revendedores group by id_usuario;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
     public function obt_clientes_revendedores()
	{
		$texto_consulta = "SELECT  id_cliente	FROM revendedores group by id_cliente ;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	//*******************************************************************************************************
	// Registrando un revendedor
	public function registrar_revendedor($id_usuario, $id_cliente)
	{
		$texto_consulta =  "INSERT IGNORE INTO revendedores (id_usuario, id_cliente)" 
		                  . " VALUES($id_usuario,'$id_cliente');";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	//*******************************************************************************************************
	// Modificando  un revendedor
	public function modificar_revendedor($id_actual, $id, $id_usuario, $id_cliente)
	{
		$texto_consulta =  "UPDATE IGNORE revendedores SET 
		                    id=$id, 
		                    id_usuario=$id_usuario, 
							id_cliente='$id_cliente'
							WHERE (id = $id_actual);"; 
		                    
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	//*******************************************************************************************************
	// Cancelando un revendedor
	public function cancelar_revendedor($id_usuario,$id_cliente)
	{
		$texto_consulta =  "DELETE FROM revendedores WHERE (id_usuario='$id_usuario' and id_cliente='$id_cliente');"; 
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	public function eliminar_revendedor($id_usuario)
	{
		$texto_consulta =  "DELETE FROM revendedores WHERE (id_usuario='$id_usuario' );"; 
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	public function eliminar_de_subordinados($id_usuario)
	{
		$texto_consulta =  "DELETE FROM usuario_subordinados WHERE (id_usuario='$id_usuario' or id_subordinado='$id_usuario' );"; 
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
    //*******************************************************************************************************
    // DASHBOARD - revendedores
	public function total_revendedores() 
	{ 
	    $res = $this->obt_revendedores1(); 
	    $this->total_revendedores = $res->num_rows();
		return $this->total_revendedores; 
	}
    public function total_clientes_revendedores() 
	{ 
	    $res = $this->obt_clientes_revendedores(); 
	    $this->total_clientes_revendedores = $res->num_rows();
		return $this->total_clientes_revendedores; 
	}
    // Obtener los datos usarios revendedore
	public function obt_user_revendedor()
	{
		$texto_consulta = "SELECT m.id, m.username, p.group_id 
		                   FROM usuarios m 
						   INNER JOIN usuarios_grupos p ON (m.id = p.user_id)
						   WHERE (p.group_id = 4);";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
    
    /********************************************************************************************************************/
	 //*******************************************************************************************************
    //*******************************************************************************************************
	//     Misiones propuestas
	//*******************************************************************************************************
    public function misiones_propuestas()
	{
		$fecha = date(" Y-m-d H:i:s ");
		$texto_consulta = "SELECT `vip`,`nivel`, `id_pedido`, `no_factura`, `nombre`, `telefono`, `celular`, `email`, `fecha_compra`,id_repuesto,repuesto,`cantidad`,  `fecha_vcto`, `en_operacion`, `en_mision`, `vencimiento`, `id_cliente` FROM view_misiones_listas where id_cliente not in (SELECT distinct id_cliente FROM `misiones` WHERE  '$fecha'>= fecha_inicio and '$fecha' <= fecha_fin and id_nueva_venta=0 ORDER BY id_mision desc )  and en_operacion=0 and en_mision=0 and id_cliente not in (select id_cliente from reclamos) LIMIT 0,500;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
			
		return $resultado;
	}
    public function misiones_propuestas_dvigi()
	{
		$fecha = date(" Y-m-d H:i:s ");
		$texto_consulta = "SELECT `id_cliente`, `dni`, `nombre`, `telefono`, `email`, `celular`, `vip`, `origen`, `en_mision`, `id_repuesto`, `repuesto`, `fecha_vcto`, `no_factura`, `en_operacion`, `llamame` FROM `temp_misiones_listas` WHERE (origen <> 'Macoi' and origen <>'Mcoy_old' and vip=0) and id_cliente not in (SELECT distinct id_cliente FROM `misiones` WHERE  '$fecha'>= fecha_inicio and '$fecha' <= fecha_fin and id_nueva_venta=0 ORDER BY id_mision desc )  and en_operacion=0 and en_mision=0 and id_cliente not in (select id_cliente from reclamos) ;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
			
		return $resultado;
	}
    public function misiones_propuestas_mcoy()
	{
		$fecha = date(" Y-m-d H:i:s ");
		$texto_consulta = "SELECT `id_cliente`, `dni`, `nombre`, `telefono`, `email`, `celular`, `vip`, `origen`, `en_mision`, `id_repuesto`, `repuesto`, `fecha_vcto`, `no_factura`, `en_operacion`, `llamame` FROM `temp_misiones_listas` WHERE (origen = 'Macoi' or origen ='Mcoy_old' and vip=0) and id_cliente not in (SELECT distinct id_cliente FROM `misiones` WHERE  '$fecha'>= fecha_inicio and '$fecha' <= fecha_fin and id_nueva_venta=0 ORDER BY id_mision desc )  and en_operacion=0 and en_mision=0 and id_cliente not in (select id_cliente from reclamos) ;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
			
		return $resultado;
	}
    public function misiones_propuestas_vip1()
	{
		$fecha = date(" Y-m-d H:i:s ");
		$texto_consulta = "SELECT `id_cliente`, `dni`, `nombre`, `telefono`, `email`, `celular`, `vip`, `origen`, `en_mision`, `id_repuesto`, `repuesto`, `fecha_vcto`, `no_factura`, `en_operacion`, `llamame` FROM `temp_misiones_listas` WHERE (origen <> 'Macoi' and origen <>'Mcoy_old' and vip=1) and id_cliente not in (SELECT distinct id_cliente FROM `misiones` WHERE  '$fecha'>= fecha_inicio and '$fecha' <= fecha_fin and id_nueva_venta=0 ORDER BY id_mision desc )  and en_operacion=0 and en_mision=0 and id_cliente not in (select id_cliente from reclamos) ;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
			
		return $resultado;
	}
	public function misiones_propuestas_vip()
	{
		$fecha = date(" Y-m-d H:i:s ");
		$texto_consulta = "SELECT `vip`,`nivel`, `id_pedido`, `no_factura`, `nombre`, `telefono`, `celular`, `email`, `fecha_compra`,id_repuesto,repuesto,`cantidad`,  `fecha_vcto`, `en_operacion`, `en_mision`, `vencimiento`, `id_cliente` FROM view_misiones_listas where vip=1 and id_cliente not in (SELECT distinct id_cliente FROM `misiones` WHERE  '$fecha'>= fecha_inicio and '$fecha' <= fecha_fin and id_nueva_venta=0 ORDER BY id_mision desc )  and en_operacion=0 and en_mision=0  LIMIT 0,500;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
			
		return $resultado;
	}
	public function misiones_propuestas_filtrada($anno, $mes, $nombre, $telefono, $dni, $email, $factura)
	{
		$fecha = date(" Y-m-d H:i:s ");
		$texto_consulta = "SELECT `vip`,`nivel`, `id_pedido`, `no_factura`, `nombre`, `telefono`, `celular`, `email`, `fecha_compra`,id_repuesto,repuesto,`cantidad`,  `fecha_vcto`, `en_operacion`, `en_mision`, `vencimiento`, `id_cliente` FROM view_misiones_listas where id_cliente not in (SELECT distinct id_cliente FROM `misiones` WHERE  '$fecha'>= fecha_inicio and '$fecha' <= fecha_fin and id_nueva_venta=0 ORDER BY id_mision desc )  and en_operacion=0 and en_mision=0 and id_cliente not in (select id_cliente from reclamos) ";
		
		/*if($anno != '*'){
			$texto_consulta = $texto_consulta." and year(fecha_vcto)= $anno";
		}		
		if($mes != '*'){
			$texto_consulta = $texto_consulta." and month(fecha_vcto)=$mes";
		}*/
		if($nombre != '*'){
			$texto_consulta = $texto_consulta." and nombre like '%$nombre%'";
		}
		
		if($telefono != '*'){
			$texto_consulta = $texto_consulta." and (telefono like '%$telefono%' or celular like '%$telefono%')";
		}
		if($dni != '*'){
			$texto_consulta = $texto_consulta." and dni like '%$dni%'";
		}
		if($email != '*'){
			$texto_consulta = $texto_consulta." and email like '%$email%'";
		}
		if($factura != '*'){
			$texto_consulta = $texto_consulta." and no_factura like '%$factura%'";
		}
		//$texto_consulta = $texto_consulta." order by id_cliente, fecha_vcto asc";
		
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
			
		return $resultado;
	}
	public function misiones_propuestas_filtrada_cliente($nombre, $telefono, $dni, $email, $factura, $millar2)
	{
		$va =($millar2*1000);
		$fecha = date(" Y-m-d H:i:s ");
		$texto_consulta = "SELECT `id_cliente`, `dni`, `nombre`, `telefono`, `email`, `celular`, `vip`, `origen`, `en_mision`, `fecha_vcto`, `repuesto`, `no_factura`, `en_operacion`, `llamame` FROM `temp_misiones_listas` WHERE id_cliente not in (SELECT distinct id_cliente FROM `misiones` WHERE  '$fecha'>= fecha_inicio and '$fecha' <= fecha_fin and id_nueva_venta=0 ORDER BY id_mision desc )  and en_operacion=0 and en_mision=0 and llamame=0 ";
		
		
		if($nombre != '*'){
			$texto_consulta = $texto_consulta." and nombre like '%$nombre%'";
		}
		
		if($telefono != '*'){
			$texto_consulta = $texto_consulta." and (telefono like '%$telefono%' or celular like '%$telefono%')";
		}
		if($dni != '*'){
			$texto_consulta = $texto_consulta." and dni like '%$dni%'";
		}
		if($email != '*'){
			$texto_consulta = $texto_consulta." and email like '%$email%'";
		}
		if($factura != '*'){
			$texto_consulta = $texto_consulta." and no_factura like '%$factura%'";
		}
		//$texto_consulta = $texto_consulta." order by id_cliente, fecha_vcto asc";
		$texto_consulta = $texto_consulta." LIMIT $va,1000;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
			
		return $resultado;
	}
	public function misiones_propuestas_filtrada_cliente_cant($nombre, $telefono, $dni, $email, $factura)
	{
		$fecha = date(" Y-m-d H:i:s ");
		$texto_consulta = "SELECT count(`id_cliente`) as cantidad FROM `temp_misiones_listas` WHERE id_cliente not in (SELECT distinct id_cliente FROM `misiones` WHERE  '$fecha'>= fecha_inicio and '$fecha' <= fecha_fin and id_nueva_venta=0 ORDER BY id_mision desc )  and en_operacion=0 and en_mision=0 and llamame=0 ";
		
		 
		if($nombre != '*'){
			$texto_consulta = $texto_consulta." and nombre like '%$nombre%'";
		}
		
		if($telefono != '*'){
			$texto_consulta = $texto_consulta." and (telefono like '%$telefono%' or celular like '%$telefono%')";
		}
		if($dni != '*'){
			$texto_consulta = $texto_consulta." and dni like '%$dni%'";
		}
		if($email != '*'){
			$texto_consulta = $texto_consulta." and email like '%$email%'";
		}
		if($factura != '*'){
			$texto_consulta = $texto_consulta." and no_factura like '%$factura%'";
		}
		//$texto_consulta = $texto_consulta." order by id_cliente, fecha_vcto asc";
		$texto_consulta = $texto_consulta." LIMIT 0,500;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		$resu = $resultado->result();	
		return $resu[0]->cantidad;
	}
	public function misiones_propuestas_filtrada_sf()
	{
		$fecha = date(" Y-m-d H:i:s ");
		$texto_consulta = "SELECT `vip`,`nivel`, `id_pedido`, `no_factura`, `nombre`, `telefono`, `celular`, `email`, `fecha_compra`,id_repuesto,repuesto,`cantidad`,  `fecha_vcto`, `en_operacion`, `en_mision`, `vencimiento`, `id_cliente`,`id_repuesto` FROM view_misiones_listas where id_cliente not in (SELECT distinct id_cliente FROM `misiones` WHERE  '$fecha'>= fecha_inicio and '$fecha' <= fecha_fin and id_nueva_venta=0 ORDER BY id_mision desc )  and en_operacion=0 and en_mision=0 and id_cliente not in (select id_cliente from reclamos) ";
				
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
			
		return $resultado;
	}
	public function misiones_propuestas_filtrada_anno($anno, $mes, $vencido,$inactivo,$millar1)
	{
		$va =($millar1*1000);
		$fecha = date("Y-m-d H:i:s");
		if($vencido==1 ){
			$texto_consulta = "SELECT `id_cliente`, `dni`, `nombre`, `telefono`, `email`, `celular`, `vip`, `origen`, `en_mision`, `fecha_vcto`, `repuesto`, `no_factura`, `en_operacion`, `llamame` FROM `temp_misiones_listas` WHERE fecha_vcto<='$fecha' and inactivo=$inactivo and year(fecha_vcto) =$anno and month(fecha_vcto)=$mes and id_cliente not in (SELECT distinct id_cliente FROM `misiones` WHERE  '$fecha'>= fecha_inicio and '$fecha' <= fecha_fin and id_nueva_venta=0 ORDER BY id_mision desc )  and en_operacion=0 and en_mision=0  and llamame=0  LIMIT $va,1000; ";
		}else{
			$texto_consulta = "SELECT `id_cliente`, `dni`, `nombre`, `telefono`, `email`, `celular`, `vip`, `origen`, `en_mision`, `fecha_vcto`, `repuesto`, `no_factura`, `en_operacion`, `llamame` FROM `temp_misiones_listas` WHERE fecha_vcto>'$fecha' and inactivo=$inactivo and year(fecha_vcto) =$anno and month(fecha_vcto)=$mes and id_cliente not in (SELECT distinct id_cliente FROM `misiones` WHERE  '$fecha'>= fecha_inicio and '$fecha' <= fecha_fin and id_nueva_venta=0 ORDER BY id_mision desc )  and en_operacion=0 and en_mision=0  and llamame=0  LIMIT $va,1000; ";						
		}		
				
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
			
		return $resultado;
	}
	public function misiones_propuestas_filtrada_anno_cant($anno, $mes, $vencido,$inactivo)
	{
		$fecha = date("Y-m-d H:i:s");
		if($vencido==1 ){
			$texto_consulta = "SELECT count(`id_cliente`) as cantidad FROM `temp_misiones_listas` WHERE fecha_vcto<='$fecha' and inactivo=$inactivo and year(fecha_vcto) =$anno and month(fecha_vcto)=$mes and id_cliente not in (SELECT distinct id_cliente FROM `misiones` WHERE  '$fecha'>= fecha_inicio and '$fecha' <= fecha_fin and id_nueva_venta=0 ORDER BY id_mision desc )  and en_operacion=0 and en_mision=0  and llamame=0  LIMIT 0,1000; ";
		}else{
			$texto_consulta = "SELECT count(`id_cliente`) as cantidad FROM `temp_misiones_listas` WHERE fecha_vcto>'$fecha' and inactivo=$inactivo and year(fecha_vcto) =$anno and month(fecha_vcto)=$mes and id_cliente not in (SELECT distinct id_cliente FROM `misiones` WHERE  '$fecha'>= fecha_inicio and '$fecha' <= fecha_fin and id_nueva_venta=0 ORDER BY id_mision desc )  and en_operacion=0 and en_mision=0  and llamame=0  LIMIT 0,1000; ";						
		}		
				
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
			
		$resu = $resultado->result();	
		return $resu[0]->cantidad;
	}
	public function misiones_propuestas_filtrada_producto($fproducto, $vencido,$inactivo, $millar4)
	{	$va =($millar4*1000);
		$fecha = date(" Y-m-d H:i:s ");
		if($vencido==1 ){
			$texto_consulta = "SELECT `id_cliente`, `dni`, `nombre`, `telefono`, `email`, `celular`, `vip`, `origen`, `en_mision`, `fecha_vcto`, `repuesto`, `no_factura`, `en_operacion`, `llamame` FROM `temp_misiones_listas` WHERE fecha_vcto<='$fecha' and inactivo=$inactivo and id_repuesto =$fproducto and id_cliente not in (SELECT distinct id_cliente FROM `misiones` WHERE  '$fecha'>= fecha_inicio and '$fecha' <= fecha_fin and id_nueva_venta=0 ORDER BY id_mision desc )  and en_operacion=0 and en_mision=0  and llamame=0  LIMIT $va,1000; ";
		}else{
			$texto_consulta = "SELECT `id_cliente`, `dni`, `nombre`, `telefono`, `email`, `celular`, `vip`, `origen`, `en_mision`, `fecha_vcto`, `repuesto`, `no_factura`, `en_operacion`, `llamame` FROM `temp_misiones_listas` WHERE fecha_vcto>'$fecha' and inactivo=$inactivo and id_repuesto =$fproducto and id_cliente not in (SELECT distinct id_cliente FROM `misiones` WHERE  '$fecha'>= fecha_inicio and '$fecha' <= fecha_fin and id_nueva_venta=0 ORDER BY id_mision desc )  and en_operacion=0 and en_mision=0  and llamame=0  LIMIT $va,1000; ";						
		}
		
				
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
			
		return $resultado;
	}
	public function misiones_propuestas_filtrada_producto_cant($fproducto, $vencido,$inactivo)
	{
		$fecha = date(" Y-m-d H:i:s ");
		if($vencido==1 ){
			$texto_consulta = "SELECT count(`id_cliente`) as cantidad FROM `temp_misiones_listas` WHERE fecha_vcto<='$fecha' and inactivo=$inactivo and id_repuesto =$fproducto and id_cliente not in (SELECT distinct id_cliente FROM `misiones` WHERE  '$fecha'>= fecha_inicio and '$fecha' <= fecha_fin and id_nueva_venta=0 ORDER BY id_mision desc )  and en_operacion=0 and en_mision=0  and llamame=0  LIMIT 0,1000; ";
		}else{
			$texto_consulta = "SELECT count(`id_cliente`) as cantidad FROM `temp_misiones_listas` WHERE fecha_vcto>'$fecha' and inactivo=$inactivo and id_repuesto =$fproducto and id_cliente not in (SELECT distinct id_cliente FROM `misiones` WHERE  '$fecha'>= fecha_inicio and '$fecha' <= fecha_fin and id_nueva_venta=0 ORDER BY id_mision desc )  and en_operacion=0 and en_mision=0  and llamame=0  LIMIT 0,1000; ";						
		}
		
				
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
			
		$resu = $resultado->result();	
		return $resu[0]->cantidad;
	}
	public function misiones_propuestas_filtrada_fecha($ffecha, $vencido,$inactivo, $millar5)
	{
		$va =($millar5*1000);
		$fecha = date(" Y-m-d H:i:s ");
		if($vencido==1 ){
			$texto_consulta = "SELECT `id_cliente`, `dni`, `nombre`, `telefono`, `email`, `celular`, `vip`, `origen`, `en_mision`, `fecha_vcto`, `repuesto`, `no_factura`, `en_operacion`, `llamame` FROM `temp_misiones_listas` WHERE fecha_vcto<='$fecha' and inactivo=$inactivo and year(fecha_vcto) =year('$ffecha') and month(fecha_vcto)=month('$ffecha') and day(fecha_vcto)=day('$ffecha') and id_cliente not in (SELECT distinct id_cliente FROM `misiones` WHERE  '$fecha'>= fecha_inicio and '$fecha' <= fecha_fin and id_nueva_venta=0 ORDER BY id_mision desc )  and en_operacion=0 and en_mision=0  and llamame=0  LIMIT $va,1000; ";
		}else{
			$texto_consulta = "SELECT `id_cliente`, `dni`, `nombre`, `telefono`, `email`, `celular`, `vip`, `origen`, `en_mision`, `fecha_vcto`, `repuesto`, `no_factura`, `en_operacion`, `llamame` FROM `temp_misiones_listas` WHERE fecha_vcto>'$fecha' and inactivo=$inactivo and year(fecha_vcto) =year('$ffecha') and month(fecha_vcto)=month('$ffecha') and day(fecha_vcto)=day('$ffecha') and id_cliente not in (SELECT distinct id_cliente FROM `misiones` WHERE  '$fecha'>= fecha_inicio and '$fecha' <= fecha_fin and id_nueva_venta=0 ORDER BY id_mision desc )  and en_operacion=0 and en_mision=0  and llamame=0  LIMIT $va,1000; ";						
		}
		
				
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
			
		return $resultado;
	}
	public function misiones_propuestas_filtrada_fecha_cant($ffecha, $vencido,$inactivo)
	{
		$fecha = date(" Y-m-d H:i:s ");
		if($vencido==1 ){
			$texto_consulta = "SELECT count(`id_cliente`) as cantidad FROM `temp_misiones_listas` WHERE fecha_vcto<='$fecha' and inactivo=$inactivo and year(fecha_vcto) =year('$ffecha') and month(fecha_vcto)=month('$ffecha') and day(fecha_vcto)=day('$ffecha') and id_cliente not in (SELECT distinct id_cliente FROM `misiones` WHERE  '$fecha'>= fecha_inicio and '$fecha' <= fecha_fin and id_nueva_venta=0 ORDER BY id_mision desc )  and en_operacion=0 and en_mision=0  and llamame=0  LIMIT 0,1000; ";
		}else{
			$texto_consulta = "SELECT count(`id_cliente`) as cantidad FROM `temp_misiones_listas` WHERE fecha_vcto>'$fecha' and inactivo=$inactivo and year(fecha_vcto) =year('$ffecha') and month(fecha_vcto)=month('$ffecha') and day(fecha_vcto)=day('$ffecha') and id_cliente not in (SELECT distinct id_cliente FROM `misiones` WHERE  '$fecha'>= fecha_inicio and '$fecha' <= fecha_fin and id_nueva_venta=0 ORDER BY id_mision desc )  and en_operacion=0 and en_mision=0  and llamame=0  LIMIT 0,1000; ";						
		}
		
				
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
			
		$resu = $resultado->result();	
		return $resu[0]->cantidad;
	}
	public function misiones_propuestas_filtrada_vip1($vencido,$inactivo, $millar7)
	{
		$va =($millar7*1000);
		$fecha = date(" Y-m-d H:i:s ");
		if($vencido==1 ){
			$texto_consulta = "SELECT `id_cliente`, `dni`, `nombre`, `telefono`, `email`, `celular`, `vip`, `origen`, `en_mision`, `fecha_vcto`, `repuesto`, `no_factura`, `en_operacion`, `llamame` FROM `temp_misiones_listas` WHERE fecha_vcto<='$fecha' and inactivo=$inactivo and vip=1 and id_cliente not in (SELECT distinct id_cliente FROM `misiones` WHERE  '$fecha'>= fecha_inicio and '$fecha' <= fecha_fin and id_nueva_venta=0 ORDER BY id_mision desc )  and en_operacion=0 and en_mision=0  and llamame=0  LIMIT $va,1000; ";
		}else{
			$texto_consulta = "SELECT `id_cliente`, `dni`, `nombre`, `telefono`, `email`, `celular`, `vip`, `origen`, `en_mision`, `fecha_vcto`, `repuesto`, `no_factura`, `en_operacion`, `llamame` FROM `temp_misiones_listas` WHERE fecha_vcto>'$fecha' and inactivo=$inactivo and vip=1 and id_cliente not in (SELECT distinct id_cliente FROM `misiones` WHERE  '$fecha'>= fecha_inicio and '$fecha' <= fecha_fin and id_nueva_venta=0 ORDER BY id_mision desc )  and en_operacion=0 and en_mision=0  and llamame=0  LIMIT $va,1000; ";						
		}
		
				
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
			
		return $resultado;
	}
	public function misiones_propuestas_filtrada_vip1_cant($vencido,$inactivo)
	{
		$fecha = date(" Y-m-d H:i:s ");
		if($vencido==1 ){
			$texto_consulta = "SELECT count(`id_cliente`) as cantidad FROM `temp_misiones_listas` WHERE fecha_vcto<='$fecha' and inactivo=$inactivo and vip=1 and id_cliente not in (SELECT distinct id_cliente FROM `misiones` WHERE  '$fecha'>= fecha_inicio and '$fecha' <= fecha_fin and id_nueva_venta=0 ORDER BY id_mision desc )  and en_operacion=0 and en_mision=0  and llamame=0  LIMIT 0,1000; ";
		}else{
			$texto_consulta = "SELECT count(`id_cliente`) as cantidad FROM `temp_misiones_listas` WHERE fecha_vcto>'$fecha' and inactivo=$inactivo and vip=1 and id_cliente not in (SELECT distinct id_cliente FROM `misiones` WHERE  '$fecha'>= fecha_inicio and '$fecha' <= fecha_fin and id_nueva_venta=0 ORDER BY id_mision desc )  and en_operacion=0 and en_mision=0  and llamame=0  LIMIT 0,1000; ";						
		}
		
				
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
			
		$resu = $resultado->result();	
		return $resu[0]->cantidad;
	}
	public function misiones_propuestas_filtrada_mcoy($vencido,$inactivo, $millar6)
	{
		$va =($millar6*1000);
		$fecha = date(" Y-m-d H:i:s ");
		if($vencido==1 ){
			$texto_consulta = "SELECT `id_cliente`, `dni`, `nombre`, `telefono`, `email`, `celular`, `vip`, `origen`, `en_mision`, `fecha_vcto`, `repuesto`, `no_factura`, `en_operacion`, `llamame` FROM `temp_misiones_listas` WHERE fecha_vcto<='$fecha' and inactivo=$inactivo and origen='Macoi' and id_cliente not in (SELECT distinct id_cliente FROM `misiones` WHERE  '$fecha'>= fecha_inicio and '$fecha' <= fecha_fin and id_nueva_venta=0 ORDER BY id_mision desc )  and en_operacion=0 and en_mision=0  and llamame=0  LIMIT $va,1000; ";
		}else{
			$texto_consulta = "SELECT `id_cliente`, `dni`, `nombre`, `telefono`, `email`, `celular`, `vip`, `origen`, `en_mision`, `fecha_vcto`, `repuesto`, `no_factura`, `en_operacion`, `llamame` FROM `temp_misiones_listas` WHERE fecha_vcto>'$fecha' and inactivo=$inactivo and origen='Macoi' and id_cliente not in (SELECT distinct id_cliente FROM `misiones` WHERE  '$fecha'>= fecha_inicio and '$fecha' <= fecha_fin and id_nueva_venta=0 ORDER BY id_mision desc )  and en_operacion=0 and en_mision=0  and llamame=0  LIMIT $va,1000; ";						
		}
		
				
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
			
		return $resultado;
	}
	public function misiones_propuestas_filtrada_mcoy_cant($vencido,$inactivo)
	{
		$fecha = date(" Y-m-d H:i:s ");
		if($vencido==1 ){
			$texto_consulta = "SELECT count(`id_cliente`) as cantidad FROM `temp_misiones_listas` WHERE fecha_vcto<='$fecha' and inactivo=$inactivo and origen='Macoi' and id_cliente not in (SELECT distinct id_cliente FROM `misiones` WHERE  '$fecha'>= fecha_inicio and '$fecha' <= fecha_fin and id_nueva_venta=0 ORDER BY id_mision desc )  and en_operacion=0 and en_mision=0  and llamame=0  LIMIT 0,1000; ";
		}else{
			$texto_consulta = "SELECT count(`id_cliente`) as cantidad FROM `temp_misiones_listas` WHERE fecha_vcto>'$fecha' and inactivo=$inactivo and origen='Macoi' and id_cliente not in (SELECT distinct id_cliente FROM `misiones` WHERE  '$fecha'>= fecha_inicio and '$fecha' <= fecha_fin and id_nueva_venta=0 ORDER BY id_mision desc )  and en_operacion=0 and en_mision=0  and llamame=0  LIMIT 0,1000; ";						
		}
		
				
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
			
		$resu = $resultado->result();	
		return $resu[0]->cantidad;
	}
	public function misiones_propuestas_filtrada_baja($vencido,$inactivo, $millar3)
	{
		$va =($millar3*1000);
		$fecha = date(" Y-m-d H:i:s ");
		if($vencido==1 ){
			$texto_consulta = "SELECT `id_cliente`, `dni`, `nombre`, `telefono`, `email`, `celular`, `vip`, `origen`, `en_mision`, `fecha_vcto`, `repuesto`, `no_factura`, `en_operacion`, `llamame` FROM `temp_misiones_listas` WHERE fecha_vcto<='$fecha' and inactivo=$inactivo and id_cliente in (select id_cliente from solicitud_baja where aprobada=0 and denegada=0) and id_cliente not in (SELECT distinct id_cliente FROM `misiones` WHERE  '$fecha'>= fecha_inicio and '$fecha' <= fecha_fin and id_nueva_venta=0 ORDER BY id_mision desc )  and en_operacion=0 and en_mision=0  and llamame=0  LIMIT $va,1000; ";
		}else{
			$texto_consulta = "SELECT `id_cliente`, `dni`, `nombre`, `telefono`, `email`, `celular`, `vip`, `origen`, `en_mision`, `fecha_vcto`, `repuesto`, `no_factura`, `en_operacion`, `llamame` FROM `temp_misiones_listas` WHERE fecha_vcto>'$fecha' and inactivo=$inactivo and id_cliente in (select id_cliente from solicitud_baja where aprobada=0 and denegada=0) and id_cliente not in (SELECT distinct id_cliente FROM `misiones` WHERE  '$fecha'>= fecha_inicio and '$fecha' <= fecha_fin and id_nueva_venta=0 ORDER BY id_mision desc )  and en_operacion=0 and en_mision=0  and llamame=0  LIMIT $va,1000; ";						
		}
		
				
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
			
		return $resultado;
	}
	public function misiones_propuestas_filtrada_baja_cant($vencido,$inactivo)
	{
		$fecha = date(" Y-m-d H:i:s ");
		if($vencido==1 ){
			$texto_consulta = "SELECT count(`id_cliente`) as cantidad FROM `temp_misiones_listas` WHERE fecha_vcto<='$fecha' and inactivo=$inactivo and id_cliente in (select id_cliente from solicitud_baja where aprobada=0 and denegada=0) and id_cliente not in (SELECT distinct id_cliente FROM `misiones` WHERE  '$fecha'>= fecha_inicio and '$fecha' <= fecha_fin and id_nueva_venta=0 ORDER BY id_mision desc )  and en_operacion=0 and en_mision=0  and llamame=0  LIMIT 0,1000; ";
		}else{
			$texto_consulta = "SELECT count(`id_cliente`) as cantidad FROM `temp_misiones_listas` WHERE fecha_vcto>'$fecha' and inactivo=$inactivo and id_cliente in (select id_cliente from solicitud_baja where aprobada=0 and denegada=0) and id_cliente not in (SELECT distinct id_cliente FROM `misiones` WHERE  '$fecha'>= fecha_inicio and '$fecha' <= fecha_fin and id_nueva_venta=0 ORDER BY id_mision desc )  and en_operacion=0 and en_mision=0  and llamame=0  LIMIT 0,1000; ";						
		}
		
				
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
			
		$resu = $resultado->result();	
		return $resu[0]->cantidad;
	}
	public function misiones_propuestas_filtrada_vip($anno, $mes, $nombre, $telefono, $dni, $email, $factura)
	{
		$texto_consulta = "SELECT `id_cliente`, `dni`, `nombre`, `telefono`, `email`, `celular`, `vip`, `origen`, `en_mision`, `fecha_vcto`, `repuesto`, `no_factura`, `en_operacion`, `llamame` FROM `temp_misiones_listas` WHERE vip=1 and id_cliente not in (SELECT distinct id_cliente FROM `misiones` WHERE  '$fecha'>= fecha_inicio and '$fecha' <= fecha_fin and id_nueva_venta=0 ORDER BY id_mision desc )  and en_operacion=0 and en_mision=0  ";
		
		/*if($anno != '*'){
			$texto_consulta = $texto_consulta." and year(fecha_vencimiento)= $anno";
		}		
		if($mes != '*'){
			$texto_consulta = $texto_consulta." and month(fecha_vencimiento)=$mes";
		}*/
		if($nombre != '*'){
			$texto_consulta = $texto_consulta." and nombre like '%$nombre%'";
		}
		
		if($telefono != '*'){
			$texto_consulta = $texto_consulta." and (telefono like '%$telefono%' or celular like '%$telefono%')";
		}
		if($dni != '*'){
			$texto_consulta = $texto_consulta." and dni like '%$dni%'";
		}
		if($email != '*'){
			$texto_consulta = $texto_consulta." and email like '%$email%'";
		}
		if($factura != '*'){
			$texto_consulta = $texto_consulta." and no_factura like '%$factura%'";
		}
		
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
			
		return $resultado;
	}
	public function total_misiones_disponibles()
	{
		$texto_consulta = "SELECT `id_cliente`, `dni`, `nombre`, `telefono`, `email`, `celular`, `vip`, `origen`, `en_mision`, `id_repuesto`, `repuesto`, `fecha_vcto`, `no_factura`, `en_operacion`, `llamame` FROM `temp_misiones_listas` WHERE `temp_misiones_listas`.`en_operacion` = 0 and `temp_misiones_listas`.`en_mision` = 0 and `temp_misiones_listas`.`fecha_vcto` <= curdate() and `temp_misiones_listas`.id_cliente not  in (select id_cliente from revendedores);";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;

	    $res = $resultado ;
		return $res->num_rows();
	}
	public function total_misiones_disponibles_rev($id_usuario)
	{
		$texto_consulta = "SELECT `id_cliente` , `id_producto`, `vip`,`nivel`, `id_pedido`, `no_factura`, `nombre`, `telefono`, `celular`, `email`, `fecha_solicitud`,descripcion,`cantidad`, `color`, `fecha_vencimiento`, `en_operacion`, `en_mision`, `vencimiento`, `id_cliente`  FROM  view_misiones_propuestas_m_agrupadas";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;

	    $res = $resultado ;
		return $res->num_rows();
	}
	public function total_misiones_disponibles_revint($id_usuario)
	{
		$texto_consulta = "SELECT *  FROM  view_misiones_listas_revint where id_usuario = $id_usuario and fecha_vcto < curdate()";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;

	    $res = $resultado ;
		return $res->num_rows();
	}
	public function misiones_disponibles_revint($id_usuario)
	{
		$texto_consulta = "SELECT *  FROM  view_misiones_listas_revint where id_usuario = $id_usuario and fecha_vcto < curdate()";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;

	    $res = $resultado ;
		return $resultado;
	}
	
	 public function misiones_propuestas_pedido($id_pedido)
	{
		$texto_consulta = "SELECT `vip`,`nivel`, `id_pedido`, `no_factura`, `nombre`, `telefono`, `celular`, `email`, `fecha_solicitud`,descripcion,`cantidad`, `color`, `fecha_vencimiento`, `en_operacion`, `en_mision`, `vencimiento`, `id_cliente`FROM view_misiones_propuestas where  id_pedido =$id_pedido LIMIT 0,100";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
			
		return $resultado;
	}
	 public function misiones_propuestas_vip_pedido($id_pedido)
	{
		$texto_consulta = "SELECT `vip`,`nivel`, `id_pedido`, `no_factura`, `nombre`, `telefono`, `celular`, `email`, `fecha_solicitud`,descripcion,`cantidad`, `color`, `fecha_vencimiento`, `en_operacion`, `en_mision`, `vencimiento`, `id_cliente` FROM view_misiones_propuestas where  id_pedido =$id_pedido LIMIT 0,100";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
			
		return $resultado;
	}
	public function misiones_propuestas_revendedores($id_usuario)
	{
		$fecha = date(" Y-m-d H:i:s ");
		$texto_consulta = "SELECT `vip`,`nivel`, `id_pedido`, `no_factura`, `nombre`, `telefono`, `celular`, `email`, `fecha_compra`,id_repuesto,repuesto,`cantidad`,  `fecha_vcto`, `en_operacion`, `en_mision`, `vencimiento`, `id_cliente`, `id_usuario` FROM view_misiones_listas_revendedores where id_usuario= $id_usuario and id_cliente not in (SELECT distinct id_cliente FROM `misiones` WHERE  '$fecha'>= fecha_inicio and '$fecha' <= fecha_fin and id_nueva_venta=0 ORDER BY id_mision desc )   and en_mision=0 and id_cliente not in (select id_cliente from reclamos) LIMIT 0,500;";

				
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
			
		return $resultado;
	}
	public function misiones_propuestas_revendedores1($id_usuario)
	{
		$fecha = date(" Y-m-d H:i:s ");
		$texto_consulta = "SELECT `vip`,`nivel`, `id_pedido`, `no_factura`, `nombre`, `telefono`, `celular`, `email`, `fecha_compra`,id_repuesto,repuesto,`cantidad`,  `fecha_vcto`, `en_operacion`, `en_mision`, `vencimiento`, `id_cliente`, `id_usuario` FROM view_misiones_listas_revendedores where id_usuario= $id_usuario and id_cliente not in (SELECT distinct id_cliente FROM `misiones` WHERE  '$fecha'>= fecha_inicio and '$fecha' <= fecha_fin and id_nueva_venta=0 ORDER BY id_mision desc )   and en_mision=0 and id_cliente not in (select id_cliente from reclamos) and email not in (select email from view_usuarios_clientes) LIMIT 0,500;";

				
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
			
		return $resultado;
	}
	public function misiones_propuestas_todos_revendedores()
	{
		$fecha = date(" Y-m-d H:i:s ");
		$texto_consulta = "SELECT `vip`,`nivel`, `id_pedido`, `no_factura`, `nombre`, `telefono`, `celular`, `email`, `fecha_compra`,id_repuesto,repuesto,`cantidad`,  `fecha_vcto`, `en_operacion`, `en_mision`, `vencimiento`, `id_cliente`, `id_usuario` FROM view_misiones_listas_revendedores where  id_cliente not in (SELECT distinct id_cliente FROM `misiones` WHERE  '$fecha'>= fecha_inicio and '$fecha' <= fecha_fin and id_nueva_venta=0 ORDER BY id_mision desc )  and en_operacion=0 and en_mision=0 and id_cliente not in (select id_cliente from reclamos) LIMIT 0,500;";

				
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
			
		return $resultado;
	}
	public function misiones_propuestas_revendedores_vip($id_usuario)
	{
		$texto_consulta = "SELECT `id_cliente`, `nombre`, `id_pedido`, `id_producto`, `cantidad`, `descripcion`, `es_repuesto`, `vencimiento`, `fecha_solicitud`, `en_operacion`, `en_mision`, `id_usuario`, `no_factura`, `referencia`, `telefono`, `email`, `fecha_vencimiento`, `dni`, `fecha_mes_antes`, `calle`, `nro`, `piso`, `dpto`, `entrecalle1`, `entrecalle2`, `color`, `celular`, `vip`, `nivel` FROM view_misiones_propuestas_revendedores where vip=1 and  year(fecha_vencimiento)= year(CURDATE()) and month(fecha_vencimiento)=month(CURDATE()) and (id_usuario = $id_usuario) and (id_pedido not in (select misiones.id_pedido from misiones where misiones.id_nueva_venta<>0)) and (es_repuesto = 1) and en_operacion=0 and en_mision=0 ORDER BY id_pedido ASC LIMIT 0,30;";
				$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
			
		return $resultado;
	}
	
	public function misiones_propuestas_revendedores_filtrada($id_usuario, $anno, $mes, $nombre, $telefono, $dni, $email, $factura)
	{
		
		$fecha = date(" Y-m-d H:i:s ");
		$texto_consulta = "SELECT `vip`,`nivel`, `id_pedido`, `no_factura`, `nombre`, `telefono`, `celular`, `email`, `fecha_compra`,id_repuesto,repuesto,`cantidad`,  `fecha_vcto`, `en_operacion`, `en_mision`, `vencimiento`, `id_cliente`, `id_usuario` FROM view_misiones_listas_revendedores where id_usuario =  $id_usuario and id_cliente not in (SELECT distinct id_cliente FROM `misiones` WHERE  '$fecha'>= fecha_inicio and '$fecha' <= fecha_fin and id_nueva_venta=0 ORDER BY id_mision desc )  and  en_mision=0 and id_cliente not in (select id_cliente from reclamos) and email not in (select email from view_usuarios_clientes) ";
		if($nombre != '*'){
			$texto_consulta = $texto_consulta." and nombre like '%$nombre%'";
		}
		
		if($telefono != '*'){
			$texto_consulta = $texto_consulta." and (telefono like '%$telefono%' or celular like '%$telefono%')";
		}
		if($dni != '*'){
			$texto_consulta = $texto_consulta." and dni like '%$dni%'";
		}
		if($email != '*'){
			$texto_consulta = $texto_consulta." and email like '%$email%'";
		}
		if($factura != '*'){
			$texto_consulta = $texto_consulta." and no_factura like '%$factura%'";
		}
		
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
			
		return $resultado;
	}
	public function misiones_propuestas_revendedoresint_filtrada($id_usuario, $anno, $mes, $nombre, $telefono, $dni, $email, $factura)
	{
		
		$fecha = date(" Y-m-d H:i:s ");
		
		$texto_consulta = "SELECT *  FROM  view_misiones_listas_revint where id_usuario = $id_usuario and fecha_vcto < curdate() ";
		if($nombre != '*'){
			$texto_consulta = $texto_consulta." and nombre like '%$nombre%'";
		}
		
		if($telefono != '*'){
			$texto_consulta = $texto_consulta." and (telefono like '%$telefono%' or celular like '%$telefono%')";
		}
		if($dni != '*'){
			$texto_consulta = $texto_consulta." and dni like '%$dni%'";
		}
		if($email != '*'){
			$texto_consulta = $texto_consulta." and email like '%$email%'";
		}
			
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
			
		return $resultado;
	}
	public function misiones_propuestas_revendedores_filtrada_vip($id_usuario, $anno, $mes, $nombre, $telefono, $dni, $email, $factura)
	{
		$texto_consulta = "SELECT `id_cliente`, `nombre`, `id_pedido`, `id_producto`, `cantidad`, `descripcion`, `es_repuesto`, `vencimiento`, `fecha_solicitud`, `en_operacion`, `en_mision`, `id_usuario`, `no_factura`, `referencia`, `telefono`, `email`, `fecha_vencimiento`, `dni`, `fecha_mes_antes`, `calle`, `nro`, `piso`, `dpto`, `entrecalle1`, `entrecalle2`, `color`, `celular`, `vip`, `nivel` FROM view_misiones_propuestas_revendedores where vip=1 and (id_usuario = $id_usuario) and (id_pedido not in (select misiones.id_pedido from misiones where misiones.id_nueva_venta<>0)) and (es_repuesto = 1) ";
		if($anno != '*'){
			$texto_consulta = $texto_consulta." and year(fecha_vencimiento)= $anno";
		}		
		if($mes != '*'){
			$texto_consulta = $texto_consulta." and month(fecha_vencimiento)=$mes";
		}
		if($nombre != '*'){
			$texto_consulta = $texto_consulta." and nombre like '%$nombre%'";
		}
		if($telefono != '*'){
			$texto_consulta = $texto_consulta." and (telefono like '%$telefono%' or celular like '%$telefono%')";
		}
		if($dni != '*'){
			$texto_consulta = $texto_consulta." and dni like '%$dni%'";
		}
		if($email != '*'){
			$texto_consulta = $texto_consulta." and email like '%$email%'";
		}
		if($factura != '*'){
			$texto_consulta = $texto_consulta." and no_factura like '%$factura%'";
		}
		$texto_consulta = $texto_consulta." ORDER BY id_pedido ASC LIMIT 0,100;";
		
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
			
		return $resultado;
	}
	//total de misiones propuestas
	public function total_misiones_propuestas()
	{
		$texto_consulta = "SELECT `id_cliente`, `nombre`, `id_pedido`, `id_producto`, `cantidad`, `descripcion`, `es_repuesto`, `vencimiento`, `fecha_solicitud`, `en_operacion`, `en_mision`, `telefono`, `email`, `no_factura`, `referencia`, `fecha_vencimiento`, `dni`, `fecha_mes_antes`, `calle`, `nro`, `piso`, `dpto`, `entrecalle1`, `entrecalle2`, `color`, `celular`, `vip`, `nivel`, `id_color` FROM view_misiones_propuestas where year(fecha_vencimiento)= year(CURDATE()) ;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
			
		return $resultado->num_rows();
	}
	public function total_misiones_propuestas_vip()
	{
		$texto_consulta = "SELECT * FROM view_misiones_propuestas where vip=1 and year(fecha_vencimiento)= year(CURDATE()) ;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
			
		return $resultado->num_rows();
	}
	//total de misiones activas
	public function total_misiones_propuestas_activas()
	{
		$texto_consulta = "SELECT `id_cliente`, `nombre`, `id_pedido`, `id_producto`, `cantidad`, `descripcion`, `es_repuesto`, `vencimiento`, `fecha_solicitud`, `en_operacion`, `en_mision`, `telefono`, `email`, `no_factura`, `referencia`, `fecha_vencimiento`, `dni`, `fecha_mes_antes`, `calle`, `nro`, `piso`, `dpto`, `entrecalle1`, `entrecalle2`, `color`, `celular`, `vip`, `nivel`, `id_color` FROM view_misiones_propuestas where year(fecha_vencimiento)= year(CURDATE()) and  (en_mision=1);";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
			
		return $resultado->num_rows();;
	}
	public function total_misiones_propuestas_activas_vip()
	{
		$texto_consulta = "SELECT `id_cliente`, `nombre`, `id_pedido`, `id_producto`, `cantidad`, `descripcion`, `es_repuesto`, `vencimiento`, `fecha_solicitud`, `en_operacion`, `en_mision`, `telefono`, `email`, `no_factura`, `referencia`, `fecha_vencimiento`, `dni`, `fecha_mes_antes`, `calle`, `nro`, `piso`, `dpto`, `entrecalle1`, `entrecalle2`, `color`, `celular`, `vip`, `nivel`, `id_color` FROM view_misiones_propuestas where vip=1 and year(fecha_vencimiento)= year(CURDATE()) and  (en_mision=1);";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
			
		return $resultado->num_rows();;
	}
	//total de misiones bloqueadas
	public function total_misiones_propuestas_bloqueadas()
	{
		$texto_consulta = "SELECT `id_cliente`, `nombre`, `id_pedido`, `id_producto`, `cantidad`, `descripcion`, `es_repuesto`, `vencimiento`, `fecha_solicitud`, `en_operacion`, `en_mision`, `telefono`, `email`, `no_factura`, `referencia`, `fecha_vencimiento`, `dni`, `fecha_mes_antes`, `calle`, `nro`, `piso`, `dpto`, `entrecalle1`, `entrecalle2`, `color`, `celular`, `vip`, `nivel`, `id_color` FROM view_misiones_propuestas where year(fecha_vencimiento)= year(CURDATE()) and  en_operacion=1;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
			
		return $resultado->num_rows();;
	}
	public function total_misiones_propuestas_bloqueadas_vip()
	{
		$texto_consulta = "SELECT `id_cliente`, `nombre`, `id_pedido`, `id_producto`, `cantidad`, `descripcion`, `es_repuesto`, `vencimiento`, `fecha_solicitud`, `en_operacion`, `en_mision`, `telefono`, `email`, `no_factura`, `referencia`, `fecha_vencimiento`, `dni`, `fecha_mes_antes`, `calle`, `nro`, `piso`, `dpto`, `entrecalle1`, `entrecalle2`, `color`, `celular`, `vip`, `nivel`, `id_color` FROM view_misiones_propuestas where vip=1 and year(fecha_vencimiento)= year(CURDATE()) and  en_operacion=1;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
			
		return $resultado->num_rows();;
	}
	 public function misiones_propuestas_clientes($cliente)
	{
		$texto_consulta = "SELECT `id_cliente`, `nombre`, `id_pedido`, `id_producto`, `cantidad`, `descripcion`, `es_repuesto`, `vencimiento`, `fecha_solicitud`, `en_operacion`, `en_mision`, `telefono`, `email`, `no_factura`, `referencia`, `fecha_vencimiento`, `dni`, `fecha_mes_antes`, `calle`, `nro`, `piso`, `dpto`, `entrecalle1`, `entrecalle2`, `color`, `celular`, `vip`, `nivel`, `id_color` FROM view_misiones_propuestas where id_cliente= $cliente  and (id_pedido not in (select misiones.id_pedido from misiones where misiones.id_nueva_venta<>0)) and (es_repuesto = 1) ORDER BY id_pedido ASC LIMIT 0,100;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
			
		return $resultado;
	}
	public function solicitud_baja($cliente)
	{
		$texto_consulta = "SELECT * FROM solicitud_baja where id_cliente= $cliente  ORDER BY fecha_solicitud DESC LIMIT 1;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
			
		return $resultado;
	}
	public function registrar_solicitud_baja($id_usuario, $id_cliente, $observaciones, $fallecido)
	{
		$texto_consulta =  "INSERT IGNORE INTO solicitud_baja (id_usuario, id_cliente,fecha_solicitud,observaciones, fallecimiento)" 
		                  . " VALUES($id_usuario,$id_cliente,FROM_UNIXTIME(UNIX_TIMESTAMP(), '%Y-%m-%d %H.%i.%s'),'$observaciones', $fallecido);";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
    // ------------------------------------------------------
	
	public function get_configuracion($parametro)
	{
		$texto_consulta = "SELECT valor FROM sys_parametros where parametro='$parametro';";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
			
		return $resultado->result();
	}
	 //*******************************************************************************************************
   
	public function upd_configuracion($parametro,$valor)
	{
		$texto_consulta = "UPDATE sys_parametros SET valor = $valor where parametro='$parametro';";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
			
		return $this->db->affected_rows();
	}
	//******************************************************************************************************* 
	//************************* Temp_detalles       **************************************************** 
	//*******************************************************************************************************   
	public function registrar_temp_detalles($id_pedido, $id_producto, $cantidad, $precio)
	{
		$texto_consulta = "INSERT INTO temp_detalles (id_pedido, id_producto, cantidad, precio) values ('$id_pedido', $id_producto, $cantidad, $precio);";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
			
		return $this->db->affected_rows();
	}
	// Cancelando un temp_detalles
	public function cancelar_temp_detalles($id_pedido)
	{
		$texto_consulta =  "DELETE FROM temp_detalles WHERE (id_pedido='$id_pedido');"; 
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	  //Obterner temp_detalles*********************************
    public function obt_temp_detalles($id_pedido)
	{
		$texto_consulta = "SELECT * FROM temp_detalles where id_pedido='$id_pedido';";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
        //$resultado=$resultado->result();			
		return $resultado;
	}
	 //*******************************************************************************************************
	 				
    public function registrar_mision_propuesta($id_usuario, $id_cliente,$id_pedido, $fecha_inicio, $fecha_final, $exitosa, $notas)
	{
		$texto_consulta =  "INSERT IGNORE INTO misiones (id_usuario, id_cliente,id_pedido, fecha_inicio, fecha_fin, exitosa, notas)" 
		                  . " VALUES($id_usuario, $id_cliente, $id_pedido,'$fecha_inicio', '$fecha_final', $exitosa, '$notas');";
		
		$resultado = $this->db->query($texto_consulta);
			    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	public function registrar_mision_propuesta_vip($id_usuario, $id_cliente,$id_pedido, $fecha_inicio, $fecha_final, $exitosa, $notas)
	{
		$texto_consulta =  "INSERT IGNORE INTO misiones (id_usuario, id_cliente,id_pedido, fecha_inicio, fecha_fin, exitosa, notas)" 
		                  . " VALUES($id_usuario, $id_cliente, $id_pedido,'$fecha_inicio', '$fecha_final', $exitosa, '$notas');";
		
		$resultado = $this->db->query($texto_consulta);
			    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
    //*******************************************************************************************************
    public function bloquear_cliente($cliente)
	{
		$texto_consulta = "UPDATE clientes set en_operacion=1 where id_cliente='$cliente';";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
			
		return $resultado;
	}
	  //Obterner misiones activas*********************************
    public function obt_mision_activas()
	{
		/*$texto_consulta = "SELECT `id_cliente`, `fecha_inicio`, `fecha_fin`, `exitosa`, `en_mision`, `id_usuario`, `username`, `nombre`, `apellidos`, `vip`, `id_nueva_venta` FROM view_misiones_activas;";*/

		$texto_consulta = "SELECT `m`.`id_mision`,`m`.`id_cliente`,`m`.`fecha_inicio`,`m`.`fecha_fin`,`m`.`exitosa`,
		`m`.`notas`,`c`.`nombre`, `c`.`apellidos`,	`u`.`first_name`,
		`u`.`id` AS `id_usuario`,	concat(`u`.`first_name`, ' ', `u`.`last_name`) AS `username`,
		`u`.`email`,	`m`.`id_pedido`,	0 AS `crv`,	`c`.`dni`,	`c`.`telefono`,	`c`.`email` AS `email_cliente`,`c`.`celular`,`m`.`id_nueva_venta`, `c`.`en_mision`, `c`.`vip`	  FROM		`misiones` `m`
		INNER JOIN `clientes` `c` ON (`m`.`id_cliente` = `c`.`id_cliente`)
		INNER JOIN `usuarios` `u` ON (`m`.`id_usuario` = `u`.`id`)
	  WHERE
		NOT `m`.`id_cliente` IN (SELECT `revendedores`.`id_cliente` FROM `revendedores`) AND 
		(`m`.`exitosa` = 2 or `m`.`exitosa` = 1) AND 
		`m`.`id_nueva_venta` = 0 and FROM_UNIXTIME(UNIX_TIMESTAMP(), '%Y-%m-%d %H.%i.%s')<=`m`.`fecha_fin` ;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
        //$resultado=$resultado->result();			
		return $resultado;
	}
	public function actualizar_clientes_en_mision_activas()
	{
		$texto_consulta = "UPDATE `clientes` SET `en_mision`=0 WHERE en_mision=1 and id_cliente not in (select id_cliente from misiones where curdate() < `fecha_fin` and id_nueva_venta=0);";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
        //$resultado=$resultado->result();			
		return $this->db->affected_rows();
	}
	
	public function obt_mision_activas_vip()
	{
		$texto_consulta = "SELECT `id_cliente`, `fecha_inicio`, `fecha_fin`, `exitosa`, `en_mision`, `id_usuario`, `username`, `nombre`, `apellidos`, `vip`, `id_nueva_venta` FROM view_misiones_activas where vip=1;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
        //$resultado=$resultado->result();			
		return $resultado;
	}
	  //Obterner misiones activas*********************************
    public function obt_usuario_mision_activas($id_cliente)
	{
		$texto_consulta = "SELECT id_usuario FROM view_misiones_activas where id_cliente=$id_cliente;";
		
		$resultado = $this->db->query($texto_consulta);
	    $resultado=$resultado->result();			
		return $resultado[0]->id_usuario;
	}
     //*******************************************************************************************************
    public function desbloquear_cliente($cliente)
	{
		$texto_consulta = "UPDATE clientes set en_operacion=0 where id_cliente='$cliente';";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
			
		return $resultado;
	}
	 public function sellar_mision($id_mision)
	{
		$texto_consulta = "UPDATE misiones set id_nueva_venta=1 where id_mision=$id_mision;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
			
		return $resultado;
	}
	 //*******************************************************************************************************
    public function quitar_cliente_en_mision($cliente)
	{
		$texto_consulta = "UPDATE clientes set en_mision=0 where id_cliente='$cliente';";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
			
		return $resultado;
	}
      //*******************************************************************************************************
    public function obtener_mision_registrada($usuario,$cliente,$id_pedido)
	{
		$texto_consulta = "SELECT id_mision FROM misiones where id_cliente='$cliente' and id_usuario=$usuario and id_pedido='$id_pedido' order by id_mision DESC;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
        $resultado=$resultado->result();			
		return $resultado[0]->id_mision;
	}
     //*******************************************************************************************************
    public function cliente_en_mision($cliente)
	{
		$texto_consulta = "UPDATE clientes set en_mision=1 where id_cliente=$cliente;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
			
		return $resultado;
	}
    // ------------------------------------------------------
	//*******************************************************************************************************
    //*******************************************************************************************************
	//     Configuración
	//*******************************************************************************************************
    //*******************************************************************************************************
	// Obtener los datos de un configuracion
	public function obt_configuracion($id_actual)
	{
		$texto_consulta = "SELECT * FROM sys_parametros where parametro = '$id_actual';";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	//*******************************************************************************************************
	// Listar configuracion
	public function obt_configuraciones()
	{
		$texto_consulta = "SELECT *	FROM sys_parametros;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	//*******************************************************************************************************
	// Registrando un configuracion
	public function registrar_configuracion($parametro, $valor, $descripcion)
	{
		$texto_consulta =  "INSERT IGNORE INTO sys_parametros (parametro, valor, descripcion)" 
		                  . " VALUES('$parametro',$valor, '$descripcion');";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	//*******************************************************************************************************
	// Modificando  un configuracion
	public function modificar_configuracion($id_actual, $parametro, $valor, $descripcion, $decimal)
	{
		if($decimal){
			$texto_consulta =  "UPDATE IGNORE sys_parametros SET 
		                    parametro='$parametro',  
		                    valor_decimal='$valor', 
		                    descripcion='$descripcion',
							es_decimal = $decimal 
							WHERE (parametro = '$id_actual');"; 
		}else{
			$texto_consulta =  "UPDATE IGNORE sys_parametros SET 
		                    parametro='$parametro', 
		                    valor='$valor', 
		                    descripcion='$descripcion',
							es_decimal = $decimal 
							WHERE (parametro = '$id_actual');"; 
		}
		
		                    
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	//*******************************************************************************************************
	// Cancelando un configuracion
	public function cancelar_configuracion($parametro)
	{
		$texto_consulta =  "DELETE FROM sys_parametros WHERE (parametro='$parametro');"; 
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
    //*******************************************************************************************************
    // DASHBOARD - empresas
	public function total_configuraciones() 
	{ 
	    $res = $this->obt_configuraciones(); 
	    $this->total_configuraciones = $res->num_rows();
		return $this->total_configuraciones; 
	}
        //*******************************************************************************************************
  //*******************************************************************************************************
    //*******************************************************************************************************
	//     Misiones fallidas
	//*******************************************************************************************************
    //*******************************************************************************************************
	// Obtener los datos de un configuracion
	public function obt_causa_falla($id_actual)
	{
		$texto_consulta = "SELECT * FROM causas_m_fallidas where id_causa = '$id_actual';";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	//*******************************************************************************************************
	// Listar causa_falla
	public function obt_causa_fallas()
	{
		$texto_consulta = "SELECT *	FROM causas_m_fallidas;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
    //***************************************
    // Listar clasificacion del hallazgo
	public function obt_clasificacion_hallazgo()
	{
		$texto_consulta = "SELECT *	FROM clasificacion_hallazgo;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	   //***************************************
    // Registro  del hallazgo
	public function registrar_nuevo_hallazgo($id_mision, $notas, $id_clasificacion)
	{
		$texto_consulta = "INSERT IGNORE INTO misiones_f_hallazgos (id_mision, notas, id_clasificacion)"
							."values($id_mision, '$notas', $id_clasificacion);";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}

	//*******************************************************************************************************
	// Registrando un causa_falla
	public function registrar_causa_falla($id_causa, $descripcion)
	{
		$texto_consulta =  "INSERT IGNORE INTO causas_m_fallidas (id_causa,descripcion)" 
		                  . " VALUES($id_causa, '$descripcion');";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
    //*******************************************************************************************************
	// Registrando un mision fallida
	public function registrar_mision_fallida($id_causa, $id_mision)
	{
		$texto_consulta =  "INSERT IGNORE INTO misiones_f (id_causa,id_mision)" 
		                  . " VALUES($id_causa, '$id_mision');";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	//*******************************************************************************************************
	// Modificando  un causa_falla
	public function modificar_causa_falla($id_actual, $id_causa,  $descripcion)
	{
		$texto_consulta =  "UPDATE IGNORE causas_m_fallidas SET 
		                    id_causa='$id_causa',
		                    descripcion='$descripcion'
							WHERE (id_causa = '$id_actual');"; 
		                    
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	//*******************************************************************************************************
	// Cancelando un causa_falla
	public function cancelar_causa_falla($id_causa)
	{
		$texto_consulta =  "DELETE FROM causas_m_fallidas WHERE (id_causa='$id_causa');"; 
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
    //*******************************************************************************************************
    // DASHBOARD - empresas
	public function total_causa_fallas() 
	{ 
	    $res = $this->obt_causa_fallas(); 
	    $this->total_causa_fallas = $res->num_rows();
		return $this->total_causa_fallas; 
	}
        //*******************************************************************************************************
     //*******************************************************************************************************
    //*******************************************************************************************************
	//     Colores
	//*******************************************************************************************************
    //*******************************************************************************************************
	public function obt_colores_productos($id_producto)
	{
		$texto_consulta = "SELECT `id_producto`, `id_color`, `nombre`	FROM view_producto_colores where id_producto=$id_producto;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function obt_combo_productos($id_combo)
	{
		$texto_consulta = "SELECT `id_combo`,`id_producto`,  `nombre`,  `cantidad`	FROM view_combo_productos where id_combo = $id_combo;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function obt_productos_colores($id_color)
	{
		$texto_consulta = "SELECT `id_producto`, `id_color`, `nombre`	FROM view_producto_colores where id_color=$id_color;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function agregar_producto_color($id_producto,$id_color)
	{
		$texto_consulta =  "INSERT IGNORE INTO producto_colores (id_producto,id_color)" 
		                  . " VALUES($id_producto, $id_color);";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	public function agregar_combo_producto($id_combo, $id_producto,$cantidad)
	{
		$texto_consulta =  "INSERT IGNORE INTO combo_productos (id_combo, id_producto,cantidad)" 
		                  . " VALUES($id_combo, $id_producto, $cantidad);";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	public function cancelar_producto_color($id_producto, $id_color)
	{
		$texto_consulta =  "DELETE FROM producto_colores WHERE (id_producto=$id_producto and id_color = $id_color);"; 
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	public function cancelar_producto_color_idcolor($id_color)
	{
		$texto_consulta =  "DELETE FROM producto_colores WHERE id_color = $id_color;"; 
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	public function cancelar_combo_producto($id_combo, $id_producto)
	{
		$texto_consulta =  "DELETE FROM combo_productos WHERE id_combo =$id_combo and id_producto = $id_producto;"; 
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	// Obtener los datos de un color
	public function obt_color($id_actual)
	{
		$texto_consulta = "SELECT * FROM colores where id_color = $id_actual;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	
	//*******************************************************************************************************
	// Listar colores
	public function obt_colores()
	{
		$texto_consulta = "SELECT *	FROM colores;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	
	//*******************************************************************************************************
	// Registrando un color
	public function registrar_color( $descripcion)
	{
		$texto_consulta =  "INSERT IGNORE INTO colores (nombre)" 
		                  . " VALUES('$descripcion');";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	
	//*******************************************************************************************************
	// Modificando  un color
	public function modificar_color($id_actual, $id_color, $descripcion)
	{
		$texto_consulta =  "UPDATE IGNORE colores SET 
		                    id_color= $id_color, 
		                    nombre='$descripcion'
							WHERE (id_color = $id_actual);"; 
		                    
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	//*******************************************************************************************************
	// Cancelando un color
	public function cancelar_color($id_color)
	{
		$texto_consulta =  "DELETE FROM colores WHERE (id_color = $id_color);"; 
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	
    //*******************************************************************************************************
    // DASHBOARD - colores
	public function total_colores() 
	{ 
	    $res = $this->obt_colores(); 
	    $this->total_colores = $res->num_rows();
		return $this->total_colores; 
	}
     //*******************************************************************************************************
	 //*****  repuesto productos
     //*******************************************************************************************************
	 public function obt_repuestos()
	{
		$texto_consulta = "SELECT `id_repuesto`, `nombre`	FROM view_repuestos;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function obt_repuestos_productos($id_producto)
	{
		$texto_consulta = "SELECT `id_producto`, `producto`, `id_repuesto`, `nombre`	FROM view_producto_repuesto where id_producto=$id_producto;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function obtener_repuestos_productos()
	{
		$texto_consulta = "SELECT `id_producto`, `producto`, `id_repuesto`, `nombre`	FROM view_producto_repuesto ;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function agregar_producto_repuesto($id_producto,$id_repuesto)
	{
		$texto_consulta =  "INSERT IGNORE INTO productos_repuestos (id_producto,id_repuesto)" 
		                  . " VALUES($id_producto, $id_repuesto);";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	public function cancelar_producto_repuesto($id_producto, $id_repuesto)
	{
		$texto_consulta =  "DELETE FROM productos_repuestos WHERE (id_producto=$id_producto and id_repuesto = $id_repuesto);"; 
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	//*******************************************************************************************************
	//     Campañas
	//*******************************************************************************************************
    //*******************************************************************************************************
	// Obtener los datos de un campana
	public function obt_campana($id_actual)
	{
		$texto_consulta = "SELECT * FROM view_campanas where id = $id_actual;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function obt_campana_rev($id_actual)
	{
		$texto_consulta = "SELECT * FROM view_campanas_rev where id = $id_actual;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function obt_desafio_mes1($id_actual)
	{
		$texto_consulta = "SELECT * FROM desafio_mes where id = $id_actual;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	//*******************************************************************************************************
	// Listar campana
	public function obt_campanas()
	{
		$texto_consulta = "SELECT *	FROM view_campanas;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function obt_campanas_rev()
	{
		$texto_consulta = "SELECT *	FROM view_campanas_rev;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function obt_desafio_mes()
	{
		$texto_consulta = "SELECT *	FROM desafio_mes;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	//*******************************************************************************************************
	// Registrando un campana
	public function registrar_campana($id_tipo_campana, $fecha_inicio, $fecha_fin,$descuento, $descripcion)
	{
		$texto_consulta =  "INSERT IGNORE INTO campanas (id_tipo_campana, fecha_inicio, fecha_fin,descuento, descripcion)" 
		                  . " VALUES($id_tipo_campana, '$fecha_inicio', '$fecha_fin',$descuento, '$descripcion');";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	public function registrar_campana_rev($id_tipo_campana, $fecha_inicio, $fecha_fin,$descuento, $descripcion)
	{
		$texto_consulta =  "INSERT IGNORE INTO campanas_rev (id_tipo_campana, fecha_inicio, fecha_fin,descuento, descripcion)" 
		                  . " VALUES($id_tipo_campana, '$fecha_inicio', '$fecha_fin',$descuento, '$descripcion');";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	public function registrar_desafio_mes($fecha_inicio, $fecha_fin,$cantidad_promedio, $porciento_aumento, $porciento_descuento)
	{
		$texto_consulta =  "INSERT INTO `desafio_mes`(`fecha_inicio`, `fecha_fin`, `cantidad_promedio`, `porciento_aumento`, `porciento_descuento`) " 
		                  . " VALUES('$fecha_inicio', '$fecha_fin',$cantidad_promedio, $porciento_aumento, $porciento_descuento);";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	//*******************************************************************************************************
	// Modificando  un campana
	public function modificar_campana($id_actual, $id_tipo_campana, $fecha_inicio, $fecha_fin,$descuento, $descripcion)
	{
		$texto_consulta =  "UPDATE IGNORE campanas SET 
		                    id_tipo_campana=$id_tipo_campana, 
		                    fecha_inicio='$fecha_inicio', 
		                    fecha_fin='$fecha_fin',
							descuento = $descuento,
							descripcion ='$descripcion'
							WHERE (id = $id_actual);"; 
		                    
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	public function modificar_campana_rev($id_actual, $id_tipo_campana, $fecha_inicio, $fecha_fin,$descuento, $descripcion)
	{
		$texto_consulta =  "UPDATE IGNORE campanas_rev SET 
		                    id_tipo_campana=$id_tipo_campana, 
		                    fecha_inicio='$fecha_inicio', 
		                    fecha_fin='$fecha_fin',
							descuento = $descuento,
							descripcion ='$descripcion'
							WHERE (id = $id_actual);"; 
		                    
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	public function modificar_desafio_mes($id_actual, $fecha_inicio, $fecha_fin,$cantidad_promedio, $porciento_aumento, $porciento_descuento)
	{
		$texto_consulta =  "UPDATE IGNORE desafio_mes SET 
		                    fecha_inicio='$fecha_inicio', 
		                    fecha_fin='$fecha_fin',
							cantidad_promedio = $cantidad_promedio,
							porciento_aumento =$porciento_aumento,
							porciento_descuento = $porciento_descuento
							WHERE (id = $id_actual);"; 
		                    
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	//*******************************************************************************************************
	// Cancelando un campana
	public function cancelar_campana($id_campana)
	{
		$texto_consulta =  "DELETE FROM campanas WHERE (id=$id_campana);"; 
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	public function cancelar_campana_rev($id_campana)
	{
		$texto_consulta =  "DELETE FROM campanas_rev WHERE (id=$id_campana);"; 
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	public function cancelar_desafio_mes($id_desafio)
	{
		$texto_consulta =  "DELETE FROM desafio_mes WHERE (id=$id_desafio);"; 
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
    //*******************************************************************************************************
    // DASHBOARD - campanas
	public function total_campanas() 
	{ 
	    $res = $this->obt_campanas(); 
	    $this->total_campanas = $res->num_rows();
		return $this->total_campanas; 
	}
	public function total_campanas_rev() 
	{ 
	    $res = $this->obt_campanas_rev(); 
	    $this->total_campanas = $res->num_rows();
		return $this->total_campanas; 
	}
 
	//*******************************************************************************************************
		// Listar campana
	public function obt_campana_productos($id_campana)
	{
		$texto_consulta = "SELECT *	FROM view_campana_producto where id_campana=$id_campana;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function obt_campana_productos_rev($id_campana)
	{
		$texto_consulta = "SELECT *	FROM view_campana_producto_rev where id_campana=$id_campana;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function obt_desafio_productos($id_desafio)
	{
		$texto_consulta = "SELECT *	FROM view_desafio_productos where id_desafio=$id_desafio;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function agregar_campana_producto($id_campana, $id_producto)
	{
		$texto_consulta =  "INSERT IGNORE INTO productos_campanas (id_campana, id_producto)" 
		                  . " VALUES($id_campana, $id_producto);";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	public function agregar_campana_producto_rev($id_campana, $id_producto)
	{
		$texto_consulta =  "INSERT IGNORE INTO productos_campanas_rev (id_campana, id_producto)" 
		                  . " VALUES($id_campana, $id_producto);";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	public function agregar_desafio_producto($id_desafio, $id_producto)
	{
		$texto_consulta =  "INSERT IGNORE INTO productos_desafio (id_desafio, id_producto)" 
		                  . " VALUES($id_desafio, $id_producto);";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	public function cancelar_campana_producto($id_campana, $id_producto)
	{
		$texto_consulta =  "DELETE FROM productos_campanas WHERE (id_producto=$id_producto and id_campana = $id_campana);"; 
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	public function cancelar_campana_producto_rev($id_campana, $id_producto)
	{
		$texto_consulta =  "DELETE FROM productos_campanas_rev WHERE (id_producto=$id_producto and id_campana = $id_campana);"; 
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	public function cancelar_desafio_producto($id_desafio, $id_producto)
	{
		$texto_consulta =  "DELETE FROM productos_desafio WHERE (id_producto=$id_producto and id_desafio = $id_desafio);"; 
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	//*******************************************************************************************************
	//  Tipo de  Campañas
	//*******************************************************************************************************
  
	// Obtener los datos de un tipo_campana
	public function obt_tipo_campana($id_actual)
	{
		$texto_consulta = "SELECT * FROM tipos_campanas where id = $id_actual;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	//*******************************************************************************************************
	// Listar tipo_campana
	public function obt_tipo_campanas()
	{
		$texto_consulta = "SELECT *	FROM tipos_campanas where id<>1;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	
	//*******************************************************************************************************
	// Registrando un tipo_campana
	public function registrar_tipo_campana( $descripcion)
	{
		$texto_consulta =  "INSERT IGNORE INTO tipos_campanas (nombre)" 
		                  . " VALUES('$descripcion');";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	
	//*******************************************************************************************************
	// Modificando  un tipo_campana
	public function modificar_tipo_campana($id_actual, $id_tipo_campana, $descripcion)
	{
		$texto_consulta =  "UPDATE IGNORE tipos_campanas SET 
		                    id= $id_tipo_campana, 
		                    nombre='$descripcion'
							WHERE (id = $id_actual);"; 
		                    
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	//*******************************************************************************************************
	// Cancelando un tipo_campana
	public function cancelar_tipo_campana($id_tipo_campana)
	{
		$texto_consulta =  "DELETE FROM tipos_campanas WHERE (id = $id_tipo_campana);"; 
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	
    //*******************************************************************************************************
    // DASHBOARD - tipo_campana
	public function total_tipo_campanas() 
	{ 
	    $res = $this->obt_tipo_campanas(); 
	    $this->total_tipo_campanas = $res->num_rows();
		return $this->total_tipo_campanas; 
	}
     //*******************************************************************************************************
     //*******************************************************************************************************
	 //****   Gestion de paises
	 //*******************************************************************************************************
	 // Obtener los datos de un pais
	public function obt_pais($id_actual)
	{
		$texto_consulta = "SELECT * FROM paises where id = '$id_actual';";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	//*******************************************************************************************************
	// Listar paises
	public function obt_paises()
	{
		$texto_consulta = "SELECT `id`, `nombre` FROM `paises`;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function obt_tipo_revendedor()
	{
		$texto_consulta = "SELECT *	FROM tipo_revendedor;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	
	//*******************************************************************************************************
	// Registrando un pais
	public function registrar_pais( $descripcion)
	{
		$descripcion = str_replace("'","´",$descripcion);
		$texto_consulta =  "INSERT IGNORE INTO paises (nombre)" 
		                  . " VALUES('$descripcion');";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	
	//*******************************************************************************************************
	// Modificando  un pais
	public function modificar_pais($id_actual, $id_pais, $descripcion)
	{
		$texto_consulta =  "UPDATE IGNORE paises SET 
		                    id= $id_pais, 
		                    nombre='$descripcion'
							WHERE (id = $id_actual);"; 
		                    
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	//*******************************************************************************************************
	// Cancelando un pais
	public function cancelar_pais($id_pais)
	{
		$texto_consulta =  "DELETE FROM paises WHERE (id = $id_pais);"; 
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	
    //*******************************************************************************************************
    // DASHBOARD - paises
	public function total_paises() 
	{ 
	    $res = $this->obt_paises(); 
	    $this->total_paises = $res->num_rows();
		return $this->total_paises; 
	}
     //*******************************************************************************************************
	  //*******************************************************************************************************
     //*******************************************************************************************************
	 //****   Gestion de provincias
	 //*******************************************************************************************************
	 // Obtener los datos de un provincia
	public function obt_provincia($id_actual)
	{
		$texto_consulta = "SELECT * FROM view_provincias where id_provincia = $id_actual;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	//*******************************************************************************************************
	// Listar provincias
	public function obt_provincias()
	{
		$texto_consulta = "SELECT *	FROM view_provincias;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	
	//*******************************************************************************************************
	// Registrando un provincia
	public function registrar_provincia( $descripcion, $id_pais)
	{
		$descripcion = str_replace("'","´",$descripcion);

		$texto_consulta =  "INSERT IGNORE INTO provincias (nombre, id_pais)" 
		                  . " VALUES('$descripcion', $id_pais);";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	
	//*******************************************************************************************************
	// Modificando  un provincia
	public function modificar_provincia($id_actual, $id_provincia, $descripcion, $id_pais)
	{
		$descripcion = str_replace("'","´",$descripcion);
		$texto_consulta =  "UPDATE IGNORE provincias SET 
		                    id_provincia= $id_provincia, 
		                    nombre='$descripcion',
							id_pais = $id_pais
							WHERE (id_provincia = $id_actual);"; 
		                    
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	//*******************************************************************************************************
	// Cancelando un provincia
	public function cancelar_provincia($id_provincia)
	{
		$texto_consulta =  "DELETE FROM provincias WHERE (id_provincia = $id_provincia);"; 
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	
    //*******************************************************************************************************
    // DASHBOARD - provincias
	public function total_provincias() 
	{ 
	    $res = $this->obt_provincias(); 
	    $this->total_provincias = $res->num_rows();
		return $this->total_provincias; 
	}
     //*******************************************************************************************************

	 // ------------------------------------------------------
	// Municipios
	
	public function municipios()
	{
		$texto_consulta = "SELECT `id_municipio`, `id_provincia`, `nombre_provincia`, `nombre_municipio`, `id_pais`, `nombre_pais`, `codigopostal` FROM view_municipios;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function obt_municipio($id_municipio)
	{
		$texto_consulta = "SELECT `id_municipio`, `id_provincia`, `nombre_provincia`, `nombre_municipio`, `id_pais`, `nombre_pais`, `codigopostal` FROM view_municipios where id_municipio = $id_municipio;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function obt_canal($id_canal)
	{
		$texto_consulta = "SELECT nombre, id_principal FROM view_canales where id = $id_canal;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function obt_municipios($id_provincia)
	{
		$texto_consulta = "SELECT `id_municipio`, `id_provincia`, `nombre_provincia`, `nombre_municipio`, `id_pais`, `nombre_pais`, `codigopostal` FROM view_municipios where id_provincia = $id_provincia;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function total_municipios($id_provincia) 
	{ 
	    $res = $this->obt_municipios($id_provincia); 
	    $this->total_municipios = $res->num_rows();
		return $this->total_municipios; 
	}
	// Registrando un municipio
	public function registrar_municipio( $descripcion, $id_provincia)
	{
		$descripcion = str_replace("'","´",$descripcion);
		$texto_consulta =  "INSERT IGNORE INTO municipios (nombre, id_provincia)" 
		                  . " VALUES('$descripcion', $id_provincia);";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
		// Modificando  un municipio
	public function modificar_municipio($id_actual, $id_municipio, $descripcion, $id_provincia)
	{
		$descripcion = str_replace("'","´",$descripcion);
		$texto_consulta =  "UPDATE IGNORE municipios SET 
		                    id_municipio= $id_municipio, 
		                    nombre='$descripcion',
							id_provincia = $id_provincia
							WHERE (id_municipio = $id_actual);"; 
		                    
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
		// Cancelando un municipio
	public function cancelar_municipio($id_municipio)
	{
		$texto_consulta =  "DELETE FROM municipios WHERE (id_municipio = $id_municipio);"; 
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	// Registrando un empresa tipo de empresa
	public function registrar_empresa_tipo_empresa( $id_empresa,$id_tipo_empresa)
	{
		$texto_consulta =  "INSERT IGNORE INTO empresa_tipo_empresa (id_empresa, id_tipo_empresa)" 
		                  . " VALUES($id_empresa, $id_tipo_empresa);";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	public function actualizar_sin_campana(){
		$texto_consulta ="INSERT INTO productos_campanas(id_producto, id_campana) (SELECT id_producto, 1 as id_campana FROM productos WHERE id_producto not in (select id_producto from productos_campanas))";
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	
	public function obt_empresa_tipo_empresa($id_empresa)
	{
		$texto_consulta = "SELECT id_empresa,id_tipo_empresa FROM empresa_tipo_empresa where id_empresa = $id_empresa;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function obt_tipo_empresa($id_tipo_empresa)
	{
		$texto_consulta = "SELECT * FROM tipo_empresa where id = $id_tipo_empresa;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function obt_empresa_tipo_empresa1($id_empresa)
	{
		$texto_consulta = "SELECT * FROM view_empresa_tipo_empresa where id_empresa = $id_empresa;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function eliminar_empresa_tipo_empresa( $id_empresa){
		$texto_consulta =  "DELETE FROM empresa_tipo_empresa where id_empresa = $id_empresa;"; 
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	public function tipo_factura($id_tipo)
	{
	    $consulta = "SELECT * from tipo_factura where id=$id_tipo;";
					
	    $resultado = $this->db->query($consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado; 
	}
	//*******************************************************************************************************
    //*******************************************************************************************************
	//     Costo
	//*******************************************************************************************************
    //*******************************************************************************************************
	
	// Obtener los datos de un costo
	public function obt_costo($id_actual)
	{
		$texto_consulta = "SELECT * FROM costo_envio where id = $id_actual;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	
	//*******************************************************************************************************
	// Listar costos
	public function obt_costos()
	{
		$texto_consulta = "SELECT *	FROM costo_envio;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	
	//*******************************************************************************************************
	// Registrando un costo
	public function registrar_costo( $anno, $mes,$costo)
	{
		$texto_consulta =  "INSERT IGNORE INTO costo_envio (anno,mes,costo)" 
		                  . " VALUES( $anno, $mes,$costo);";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	
	//*******************************************************************************************************
	// Modificando  un costo
	public function modificar_costo($id_actual, $id_costo, $anno, $mes, $costo)
	{
		$texto_consulta =  "UPDATE IGNORE costo_envio SET 
		                    id= $id_costo, 
		                    anno=$anno,
							mes= $mes,
							costo= $costo
							WHERE (id = $id_actual);"; 
		                    
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	//*******************************************************************************************************
	// Cancelando un costo
	public function cancelar_costo($id_costo)
	{
		$texto_consulta =  "DELETE FROM costo_envio WHERE (id = $id_costo);"; 
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	public function total_costos() 
	{ 
	    $res = $this->obt_costos(); 
	    $this->total_costos = $res->num_rows();
		return $this->total_costos; 
	}
    //*******************************************************************************************************
	public function obt_annos()
	{
		$texto_consulta = "SELECT *	FROM annos;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function obt_meses()
	{
		$texto_consulta = "SELECT *	FROM meses order by id;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	 //*******************************************************************************************************
	//     Tipo de factura
	//*******************************************************************************************************
    //*******************************************************************************************************
	
	// Obtener los datos de un factura
	public function obt_factura($id_actual)
	{
		$texto_consulta = "SELECT * FROM tipo_factura where id = $id_actual;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function obt_factura_rev($id_actual)
	{
		$texto_consulta = "SELECT * FROM tipo_factura_internacional where id = $id_actual;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	
	//*******************************************************************************************************
	// Listar factura
	public function obt_facturas()
	{
		$texto_consulta = "SELECT *	FROM tipo_factura;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	
	//*******************************************************************************************************
	// Registrando un factura
	public function registrar_factura( $descripcion)
	{
		$texto_consulta =  "INSERT IGNORE INTO tipo_factura (nombre)" 
		                  . " VALUES( '$descripcion');";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	public function registrar_factura_rev( $descripcion)
	{
		$texto_consulta =  "INSERT IGNORE INTO tipo_factura_internacional (nombre)" 
		                  . " VALUES( '$descripcion');";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	public function registrar_iva_rev( $id_pais, $iva)
	{
		$texto_consulta =  "INSERT IGNORE INTO pais_iva (id_pais, iva)" 
		                  . " VALUES( $id_pais, $iva);";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	
	//*******************************************************************************************************
	// Modificando  un factura
	public function modificar_factura($id_actual, $id_factura, $descripcion)
	{
		$texto_consulta =  "UPDATE IGNORE tipo_factura SET 
		                    id= $id_factura, 
		                    nombre='$descripcion'
							WHERE (id = $id_actual);"; 
		                    
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	public function modificar_factura_rev($id_actual, $id_factura, $descripcion)
	{
		$texto_consulta =  "UPDATE IGNORE tipo_factura_internacional SET 
		                    id= $id_factura, 
		                    nombre='$descripcion'
							WHERE (id = $id_actual);"; 
		                    
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	public function modificar_iva_rev($id_actual, $id_pais, $iva)
	{
		$texto_consulta =  "UPDATE IGNORE pais_iva SET 
		                    id_pais= $id_pais, 
		                    iva=$iva
							WHERE (id_pais = $id_actual);"; 
		                    
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	//*******************************************************************************************************
	// Cancelando un factura
	public function cancelar_factura($id_factura)
	{
		$texto_consulta =  "DELETE FROM tipo_factura WHERE (id = $id_factura);"; 
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	public function cancelar_factura_rev($id_factura)
	{
		$texto_consulta =  "DELETE FROM tipo_factura_internacional WHERE (id = $id_factura);"; 
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	public function cancelar_iva_rev($id_pais)
	{
		$texto_consulta =  "DELETE FROM pais_iva WHERE (id_pais = $id_pais);"; 
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	public function obt_iva_rev($id_actual)
	{
		$texto_consulta = "SELECT * FROM pais_iva where id_pais = $id_actual;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function total_facturas() 
	{ 
	    $res = $this->obt_facturas(); 
	    $this->total_facturas = $res->num_rows();
		return $this->total_facturas; 
	}
    //*******************************************************************************************************
		//*******************************************************************************************************
    //*******************************************************************************************************
	//     Objetivos
	//*******************************************************************************************************
    //*******************************************************************************************************
	
	// Obtener los datos de un objetivo
	public function obt_objetivo($id_actual)
	{
		$texto_consulta = "SELECT * FROM objetivos where id_objetivo = $id_actual;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	
	//*******************************************************************************************************
	// Listar objetivos
	public function obt_objetivos($usuario_act)
	{
		$texto_consulta = "SELECT `username`, `nombre`, `apellidos`, `id_objetivo`, `id_consultor`, `objetivo`, `fecha_asignacion`, `mes`, `anno`, `id_tipo_objetivo`, `tipo`, `id_usuario`	FROM view_objetivos where id_usuario=$usuario_act Order by anno,mes, tipo;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function obt_objetivo1($usuario,$mes,$tipo_ojetivo)
	{
		$anno = date('Y');
		$texto_consulta = "SELECT `objetivo` from objetivos where id_consultor= $usuario and mes = $mes and id_tipo_objetivo = $tipo_ojetivo and anno = $anno;";
		
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		if($resultado->num_rows()>0){
			$re= $resultado->result();
			$valor = $re[0]->objetivo;
		}else{
			$valor = 0;
			$texto_consulta = "INSERT INTO `objetivos`(`id_consultor`, `id_tipo_objetivo`, `objetivo`, `fecha_asignacion`, `mes`, `anno`) VALUES ($usuario,$tipo_ojetivo,0,'curdate()',$mes,$anno);";
			$resultado = $this->db->query($texto_consulta);
		}
			
		return $valor;
	}
	public function upd_objetivo1($usuario,$mes,$tipo_ojetivo,$new_objetivo)
	{
		$anno = date('Y');
		$texto_consulta = "SELECT `objetivo` from objetivos where id_consultor= $usuario and mes = $mes and id_tipo_objetivo = $tipo_ojetivo and anno = $anno;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		if($resultado->num_rows()>0){
			$texto_consulta = "UPDATE `objetivos` SET `objetivo`=$new_objetivo,`fecha_asignacion`=FROM_UNIXTIME(UNIX_TIMESTAMP(), '%Y-%m-%d %H.%i.%s') WHERE id_consultor= $usuario and mes = $mes and id_tipo_objetivo = $tipo_ojetivo and anno = $anno;";
		}else{
			$texto_consulta = "INSERT INTO `objetivos`( `id_consultor`, `id_tipo_objetivo`, `objetivo`, `fecha_asignacion`, `mes`, `anno`) VALUES ($usuario,$tipo_ojetivo,$new_objetivo,FROM_UNIXTIME(UNIX_TIMESTAMP(), '%Y-%m-%d %H.%i.%s'),$mes,$anno);";
		}
		$resultado = $this->db->query($texto_consulta);	
		if (!$resultado)
			echo $resultado;
		return $this->db->affected_rows();
	}
	public function obt_objetivos_consultor($usuario_act)
	{
		$texto_consulta = "SELECT `username`, `nombre`, `apellidos`, `id_objetivo`, `id_consultor`, `objetivo`, `fecha_asignacion`, `mes`, `anno`, `id_tipo_objetivo`, `tipo`, `id_usuario`	FROM view_objetivos where id_consultor=$usuario_act Order by anno,mes, tipo;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function obt_mis_objetivos($usuario_act)
	{
		$texto_consulta = "SELECT `username`, `nombre`, `apellidos`, `id_objetivo`, `id_consultor`, `objetivo`, `fecha_asignacion`, `mes`, `anno`, `id_tipo_objetivo`, `tipo`, `id_usuario`	FROM view_mis_objetivos where id_usuario=$usuario_act;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	//*******************************************************************************************************
	// Registrando un objetivo
	public function registrar_objetivo($id_consultor, $id_tipo_objetivo, $objetivo, $fecha_asignacion, $mes, $anno)
	{
		$texto_consulta =  "INSERT IGNORE INTO objetivos (id_consultor,id_tipo_objetivo, objetivo, fecha_asignacion, mes, anno)" 
		                  . " VALUES( $id_consultor, $id_tipo_objetivo, $objetivo, '$fecha_asignacion', $mes, $anno);";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	
	//*******************************************************************************************************
	// Modificando  un objetivo
	public function modificar_objetivo($id_actual, $id_objetivo, $id_consultor, $id_tipo_objetivo, $objetivo, $fecha_asignacion, $mes, $anno)
	{
		$texto_consulta =  "UPDATE IGNORE objetivos SET 
		                    id_objetivo= $id_objetivo, 
							id_consultor = $id_consultor,
							id_tipo_objetivo = $id_tipo_objetivo,
							objetivo = $objetivo,
		                    anno=$anno,
							mes= $mes,
							fecha_asignacion= '$fecha_asignacion'
							WHERE (id_objetivo = $id_actual);"; 
		                    
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	//*******************************************************************************************************
	// Cancelando un objetivo
	public function cancelar_objetivo($id_objetivo)
	{
		$texto_consulta =  "DELETE FROM objetivos WHERE (id_objetivo = $id_objetivo);"; 
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	public function total_objetivos() 
	{ 	
		// Buscar el usuario actual
		$user = $this->ion_auth->user()->row();
		$usuario_act= $user->id;

	    $res = $this->obt_objetivos($usuario_act); 
	    $this->total_objetivos = $res->num_rows();
		return $this->total_objetivos; 
	}
    //*******************************************************************************************************

// Listar consultores
	public function obt_consultores($usuario_Act)
	{
		$texto_consulta = "SELECT *	FROM view_consultores where id_usuario=$usuario_Act;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
		//*******************************************************************************************************
    //*******************************************************************************************************
	//     iva
	//*******************************************************************************************************
    //*******************************************************************************************************
	
	// Obtener los datos de un iva
	public function obt_iva($id_actual)
	{
		$texto_consulta = "SELECT * FROM iva_envio where id = $id_actual;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	
	//*******************************************************************************************************
	// Listar iva
	public function obt_ivas()
	{
		$texto_consulta = "SELECT *	FROM iva_envio;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	
	//*******************************************************************************************************
	// Registrando un iva
	public function registrar_iva( $anno, $mes,$iva)
	{
		$texto_consulta =  "INSERT IGNORE INTO iva_envio (anno,mes,iva)" 
		                  . " VALUES( $anno, $mes,$iva);";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	
	//*******************************************************************************************************
	// Modificando  un iva
	public function modificar_iva($id_actual, $id_iva, $anno, $mes, $iva)
	{
		$texto_consulta =  "UPDATE IGNORE iva_envio SET 
		                    id= $id_iva, 
		                    anno=$anno,
							mes= $mes,
							iva= $iva
							WHERE (id = $id_actual);"; 
		                    
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	//*******************************************************************************************************
	// Cancelando un iva
	public function cancelar_iva($id_iva)
	{
		$texto_consulta =  "DELETE FROM iva_envio WHERE (id = $id_iva);"; 
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	public function total_ivas() 
	{ 
	    $res = $this->obt_ivas(); 
	    $this->total_ivas = $res->num_rows();
		return $this->total_ivas; 
	}
	public function obtener_iva($anno, $mes)
	{
		$texto_consulta = "SELECT * from iva_envio WHERE (anno = $anno and mes = $mes);";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	// Listar hallazgos
	public function obt_hallazgos()
	{
		$texto_consulta = "SELECT *	FROM view_hallazgos;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	
	public function total_hallazgos() 
	{ 
	    $res = $this->obt_hallazgos(); 
	    $this->total_hallazgos = $res->num_rows();
		return $this->total_hallazgos; 
	}
	
	// Listar tipo objetivos
	public function obt_tipo_objetivos()
	{
		$texto_consulta = "SELECT *	FROM tipo_objetivos;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	 //*******************************************************************************************************
     //*******************************************************************************************************
	 //****   Gestion de canales
	 //*******************************************************************************************************
	 // Obtener los datos de un canal
	/*public function obt_canal($id_actual)
	{
		$texto_consulta = "SELECT * FROM canales where id = '$id_actual';";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}*/
	//*******************************************************************************************************
	// Listar canales
	public function obt_canales()
	{
		$texto_consulta = "SELECT *	FROM view_canales;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	
	//*******************************************************************************************************
	// Registrando un canal
	public function registrar_canal( $descripcion, $principal)
	{
		$texto_consulta =  "INSERT IGNORE INTO canales (nombre, id_principal)" 
		                  . " VALUES('$descripcion', $principal);";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	
	//*******************************************************************************************************
	// Modificando  un canal
	public function modificar_canal($id_actual, $id_canal, $descripcion, $principal)
	{
		$texto_consulta =  "UPDATE IGNORE canales SET 
		                    id= $id_canal, 
		                    nombre='$descripcion',
							id_principal = $principal
							WHERE (id = $id_actual);"; 
		                    
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	//*******************************************************************************************************
	// Cancelando un canal
	public function cancelar_canal($id_canal)
	{
		$texto_consulta =  "DELETE FROM canales WHERE (id = $id_canal);"; 
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	
    //*******************************************************************************************************
    // DASHBOARD - paises
	public function total_canales() 
	{ 
	    $res = $this->obt_canales(); 
	    $this->total_canales = $res->num_rows();
		return $this->total_canales; 
	}
     //*******************************************************************************************************

	 //*******************************************************************************************************
	//     Tipo de objetivo
	//*******************************************************************************************************
    //*******************************************************************************************************
	
	// Obtener los datos de un tipo de objetivo
	public function obt_tipo_objetivo($id_actual)
	{
		$texto_consulta = "SELECT * FROM tipo_objetivos where id = $id_actual;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	
	//*******************************************************************************************************
	// Listar tipos de objetivos
	/*public function obt_tipo_objetivos()
	{
		$texto_consulta = "SELECT *	FROM tipo_objetivos;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}*/
	
	//*******************************************************************************************************
	// Registrando un tipo de objetivo
	public function registrar_tipo_objetivo($tipo)
	{
		$texto_consulta =  "INSERT IGNORE INTO tipo_objetivos (tipo)" 
		                  . " VALUES( '$tipo');";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	
	//*******************************************************************************************************
	// Modificando  un factura
	public function modificar_tipo_objetivo($id_actual, $id_tipo_objetivo, $tipo)
	{
		$texto_consulta =  "UPDATE IGNORE tipo_objetivos SET 
		                    id= $id_tipo_objetivo, 
		                    tipo='$tipo'
							WHERE (id = $id_actual);"; 
		                    
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	//*******************************************************************************************************/
	//Cancelando un factura
	public function cancelar_tipo_objetivo($id_tipo_objetivo)
	{
		$texto_consulta =  "DELETE FROM tipo_objetivos WHERE (id = $id_tipo_objetivo);"; 
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	
	public function total_tipo_objetivos() 
	{ 
	    $res = $this->obt_tipo_objetivos(); 
	    $this->total_tipo_objetivos = $res->num_rows();
		return $this->total_tipo_objetivos; 
	}
    //*******************************************************************************************************/
    /********************************************************************************************************************/
	     //*******************************************************************************************************
	 //****   Gestion de canales principales
	 //*******************************************************************************************************
	 // Obtener los datos de un canal
	public function obt_canal_principal($id_actual)
	{
		$texto_consulta = "SELECT * FROM canales_principales where id = '$id_actual';";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	//*******************************************************************************************************
	// Listar canales
	public function obt_canales_principal()
	{
		$texto_consulta = "SELECT *	FROM canales_principales;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	
	//*******************************************************************************************************
	// Registrando un canal
	public function registrar_canal_principal( $descripcion)
	{
		$texto_consulta =  "INSERT IGNORE INTO canales_principales (nombre)" 
		                  . " VALUES('$descripcion');";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	
	//*******************************************************************************************************
	// Modificando  un canal
	public function modificar_canal_principal($id_actual, $id_canal, $descripcion)
	{
		$texto_consulta =  "UPDATE IGNORE canales_principales SET 
		                    id= $id_canal, 
		                    nombre='$descripcion'
							WHERE (id = $id_actual);"; 
		                    
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	//*******************************************************************************************************
	// Cancelando un canal
	public function cancelar_canal_principal($id_canal)
	{
		$texto_consulta =  "DELETE FROM canales_principales WHERE (id = $id_canal);"; 
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	public function total_canales_principal() 
	{ 
	    $res = $this->obt_canales_principal(); 
	    $this->total_canales = $res->num_rows();
		return $this->total_canales; 
	}
    //*******************************************************************************************************
	//*******************************************************************************************************
	//     Niveles VIP
	//*******************************************************************************************************
    //*******************************************************************************************************
	
	// Obtener los datos de un color
	public function obt_nivel_vip($id_actual)
	{
		$texto_consulta = "SELECT * FROM niveles_vip where id = $id_actual;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	
	//*******************************************************************************************************
	// Listar colores
	public function obt_niveles_vip()
	{
		$texto_consulta = "SELECT *	FROM niveles_vip;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	
	//*******************************************************************************************************
	// Registrando un color
	public function registrar_nivel_vip($id, $descuento_producto, $paga_producto, $paga_repuesto, $paga_envio, $observaciones)
	{
		$texto_consulta =  "INSERT IGNORE INTO niveles_vip (id, descuento_producto, paga_producto, paga_repuesto, paga_envio, observaciones)" 
		                  . " VALUES($id, $descuento_producto, $paga_producto, $paga_repuesto, $paga_envio, '$observaciones');";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	
	//*******************************************************************************************************
	// Modificando  un color
	public function modificar_nivel_vip($id_actual, $id, $descuento_producto, $paga_producto, $paga_repuesto, $paga_envio, $observaciones)
	{
		$texto_consulta =  "UPDATE IGNORE niveles_vip SET 
		                    id = $id, 
		                    descuento_producto = $descuento_producto, 
							paga_producto = $paga_producto, 
							paga_repuesto = $paga_repuesto, 
							paga_envio = $paga_envio, 
							observaciones = '$observaciones'
							WHERE (id = $id_actual);"; 
		                    
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	//*******************************************************************************************************
	// Cancelando un color
	public function cancelar_nivel_vip($id)
	{
		$texto_consulta =  "DELETE FROM niveles_vip WHERE ( id= $id);"; 
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	
    //*******************************************************************************************************
    public function obt_niveles_productos($id_nivel)
	{
		$texto_consulta = "SELECT *	FROM view_niveles_productos where id_nivel=$id_nivel;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function obt_productos_niveles($id_producto)
	{
		$texto_consulta = "SELECT *	FROM view_niveles_productos where id_producto=$id_producto;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function agregar_nivel_productos($id_nivel, $id_producto,$descuento)
	{
		$texto_consulta =  "INSERT IGNORE INTO niveles_productos (id_nivel, id_producto, descuento)" 
		                  . " VALUES($id_nivel, $id_producto, $descuento);";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	public function cancelar_nivel_productos($id_nivel, $id_producto)
	{
		$texto_consulta =  "DELETE FROM niveles_productos WHERE (id_producto=$id_producto and id_nivel = $id_nivel);"; 
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	public function cancelar_producto_nivel($id_nivel)
	{
		$texto_consulta =  "DELETE FROM niveles_productos WHERE id_nivel = $id_nivel;"; 
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	public function obt_descuentovip_producto($id_nivel, $id_producto)
	{
		$texto_consulta = "SELECT descuento	FROM view_niveles_productos where id_nivel=$id_nivel and id_producto=$id_producto;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	
	//*******************************************************************************************************
	//  Tipo de  Operativas
	//*******************************************************************************************************
  
	// Obtener los datos de un operativa
	public function obt_operativa($id_actual)
	{
		$texto_consulta = "SELECT * FROM operativas where id = $id_actual;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	//*******************************************************************************************************
	// Listar operativa
	public function obt_operativas()
	{
		$texto_consulta = "SELECT *	FROM operativas ;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	
	//*******************************************************************************************************
	// Registrando un operativa
	public function registrar_operativa( $nombre, $descripcion, $grupo)
	{
		$texto_consulta =  "INSERT IGNORE INTO operativas (nombre, descripcion, grupo)" 
		                  . " VALUES('$nombre', '$descripcion', $grupo);";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	
	//*******************************************************************************************************
	// Modificando  un operativa
	public function modificar_operativa($id_actual, $id_operativa, $nombre, $descripcion, $grupo)
	{
		$texto_consulta =  "UPDATE IGNORE operativas SET 
		                    id= $id_operativa, 
		                    nombre='$nombre',
							descripcion= '$descripcion',
							grupo= $grupo
							WHERE (id = $id_actual);"; 
		                    
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	//*******************************************************************************************************
	// Cancelando un operativa
	public function cancelar_operativa($id_operativa)
	{
		$texto_consulta =  "DELETE FROM operativas WHERE (id = $id_operativa);"; 
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	
    //*******************************************************************************************************
    // DASHBOARD - operativa
	public function total_operativas() 
	{ 
	    $res = $this->obt_operativas(); 
	    $this->total_operativas = $res->num_rows();
		return $this->total_operativas; 
	}
     //*******************************************************************************************************
    public function obt_solicitud_baja()
	{
		$texto_consulta = "SELECT * FROM view_solicitud_baja WHERE `aprobada` = 0;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
			
		return $resultado;
	}
	 public function baja_pendientes()
	{
		$texto_consulta = "SELECT * FROM view_solicitud_baja where aprobada=0 and denegada=0 ;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
			
		return $resultado;
	}
	public function total_solicitudes() 
	{ 
	    $res = $this->obt_solicitud_baja(); 
	    $this->total_solicitudes = $res->num_rows();
		return $this->total_solicitudes; 
		
	}
	public function obte_solicitud_baja($id)
	{
		$texto_consulta = "SELECT * FROM view_solicitud_baja where id = $id  ;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
			
		return $resultado;
	}
	public function modificar_solicitud_baja($id_actual, $apro,  $den)
	{
		$texto_consulta =  "UPDATE solicitud_baja SET 
								aprobada= $apro, 
								denegada=$den
							WHERE (id = $id_actual);"; 
		                    
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	public function eliminar_solicitud_baja($id_solicitud)
	{
		$texto_consulta =  "DELETE FROM solicitud_baja WHERE (id = $id_solicitud);"; 
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	public function modificar_estado_cliente($id_cliente)
	{
		$texto_consulta =  "UPDATE clientes SET 
								reg_cancelado= 1
							WHERE (id_cliente = $id_cliente);"; 
		                    
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	 //*******************************************************************************************************
    //*******************************************************************************************************
	//     Pack
	//*******************************************************************************************************
    //*******************************************************************************************************
	// Obtener los datos de un pack
	public function obt_pack($id_actual)
	{
		$texto_consulta = "SELECT * FROM pack_secundarios where id_pack = '$id_actual';";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	//*******************************************************************************************************
	// Listar pack
	public function obt_packs()
	{
		$texto_consulta = "SELECT *	FROM pack_secundarios;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	//*******************************************************************************************************
	// Registrando un pack
	public function registrar_pack( $nombre, $largo,  $ancho, $alto)
	{
		$texto_consulta =  "INSERT IGNORE INTO pack_secundarios (nombre, largo,  ancho, alto)" 
		                  . " VALUES('$nombre', $largo,  $ancho, $alto);";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	//*******************************************************************************************************
	// Modificando  un pack
	public function modificar_pack($id_actual, $id, $nombre, $largo, $ancho, $alto)
	{
		$texto_consulta =  "UPDATE IGNORE pack_secundarios SET 
		                    id_pack='$id', 
		                    nombre='$nombre', 
							largo= $largo,							
							ancho= $ancho, 
							alto= $alto
							WHERE (id_pack= $id_actual);"; 
		                    
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	//*******************************************************************************************************
	// Cancelando un pack
	public function cancelar_pack($id)
	{
		$texto_consulta =  "DELETE FROM pack_secundarios WHERE (id_pack=$id);"; 
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
    //*******************************************************************************************************
    // DASHBOARD - empresas
	public function total_packs() 
	{ 
	    $res = $this->obt_packs(); 
	    $this->total_packs = $res->num_rows();
		return $this->total_packs; 
	}
	     //*******************************************************************************************************
	 //****   Gestion de feriados
	 //*******************************************************************************************************
	 
	//*******************************************************************************************************
	// Listar feriados
	public function obt_feriados()
	{
		$texto_consulta = "SELECT *	FROM feriados;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	
	//*******************************************************************************************************
	// Registrando un feriado
	public function registrar_feriado( $dia)
	{
		$texto_consulta =  "INSERT IGNORE INTO feriados (dia)" 
		                  . " VALUES('$dia');";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	
	//*******************************************************************************************************
	// Modificando  un feriado
	public function modificar_feriado($id_actual, $id_feriado, $dia)
	{
		$texto_consulta =  "UPDATE IGNORE feriados SET 
		                    id= $id_feriado, 
		                    dia='$dia'
							WHERE (id = $id_actual);"; 
		                    
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	//*******************************************************************************************************
	// Cancelando un feriado
	public function cancelar_feriado($id_feriado)
	{
		$texto_consulta =  "DELETE FROM feriados WHERE (id = $id_feriado);"; 
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	public function obt_feriado($id_feriado)
	{
		$texto_consulta = "SELECT dia FROM feriados where id = $id_feriado;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
    //*******************************************************************************************************
    // DASHBOARD - paises
	public function total_feriados() 
	{ 
	    $res = $this->obt_feriados(); 
	    $this->total_feriados = $res->num_rows();
		return $this->total_feriados; 
	}
     //*******************************************************************************************************
	 public function historico_all($id_cliente)
	 {
		$texto_consulta = "SELECT fecha,nota, usuario FROM view_historico_union where id_cliente = $id_cliente;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	 }
	 public function historico($id_cliente)
	 {
		$texto_consulta = "SELECT `id_mision_f`, `id_mision`, `id_causa`, `descripcion`, `id_cliente`, `first_name`, `last_name`, `fecha_inicio`, `id_pedido` FROM view_historia where id_cliente = $id_cliente;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	 }
	public function historial($id_cliente)
	 {
		$texto_consulta = "SELECT `id`, `id_pedido`, `no_factura`, `producto`, `importe`, `dni`, `nombre`, `apellidos`, `color`, `id_cliente`, `anno`, `mes`, `id_usuario`, `first_name`, `last_name`, `fecha_vencimiento`, `fecha_mes_antes` FROM view_historial where id_cliente = $id_cliente;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	 }
	 public function cliente_historico($id_cliente)
	{
		$texto_consulta = "SELECT `id_cliente`, `dni`, `municipio`, `provincia`, `nombre`, `telefono`, `email`, `en_operacion`, `en_mision`, `reg_cancelado`, `id_municipio`, `id_provincia`, `apellidos`, `codigo_postal`, `calle`, `nro`, `dpto`, `piso`, `entrecalle1`, `entrecalle2`, `fecha_nacimiento`, `origen`, `vip`, `nivel`, `celular`, `observaciones`, `cuit` FROM view_clientes WHERE id_cliente=$id_cliente;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
			
		return $resultado->result();
	}
	public function format_moneda($valor)
	{
		$texto_consulta = "SELECT money_format($valor) as money_format;";
		
		$resultado = $this->db->query($texto_consulta);
		
	    if (!$resultado)
			echo $resultado;
		
        
		return $resultado->result();
	}
	public function comision_mision($id_pedido)
	{
		$texto_consulta = "SELECT `id_pedido`, `id_usuario`, `first_name`, `last_name` from view_comision_mision where id_pedido = $id_pedido;";
		
		$resultado = $this->db->query($texto_consulta);
		
	    if (!$resultado)
			echo $resultado;		
        if($resultado->num_rows()==0){
			$texto_consulta = "SELECT `pedidos`.`id_pedido`,`pedidos`.`id_usuario`,	`usuarios`.`first_name`,
			`usuarios`.`last_name`  FROM `pedidos` INNER JOIN `usuarios` ON (`pedidos`.`usuario_comisiona` = `usuarios`.`id`)WHERE `pedidos`.`id_pedido`=$id_pedido ";
			$resultado = $this->db->query($texto_consulta);
			if (!$resultado)
			echo $resultado;
		}
		return $resultado;
	}
	public function obt_historico_compras($id_cliente)
	{
		$texto_consulta = "SELECT `entrega`, `id_pedido`, `no_factura`, `producto`, `importe`-descuento-descuento_vip+incremento as importe, `usuario`, `fecha_compra`, `fecha_vencimiento`, `reposicion`, `id_cliente`, `canal`, `id_producto`, `es_repuesto`, `mail` from view_historico_compras where id_cliente = $id_cliente;";
		
		$resultado = $this->db->query($texto_consulta);
		
	    if (!$resultado)
			echo $resultado;		
        
		return $resultado;
	}
	public function obt_historico_seguimiento($id_cliente)
	{
		$texto_consulta = "SELECT * from view_seguimiento where id_cliente = $id_cliente;";
		
		$resultado = $this->db->query($texto_consulta);
		
	    if (!$resultado)
			echo $resultado;		
        
		return $resultado;
	}
	public function obt_reclamos($id_cliente)
	{
		$texto_consulta = "SELECT * from view_reclamos where id_cliente = $id_cliente;";
		
		$resultado = $this->db->query($texto_consulta);
		
	    if (!$resultado)
			echo $resultado;		
        
		return $resultado;
	}
	public function obtener_reclamos()
	{
		$texto_consulta = "SELECT * from view_reclamos ;";
		
		$resultado = $this->db->query($texto_consulta);
		
	    if (!$resultado)
			echo $resultado;		
        
		return $resultado;
	}
	public function obtener_notas_clientes($id_cliente)
	{
		$texto_consulta = "SELECT * from view_notas_clientes where id_cliente = $id_cliente ;";
		
		$resultado = $this->db->query($texto_consulta);
		
	    if (!$resultado)
			echo $resultado;		
        
		return $resultado;
	}
	public function obtener_notas_clientes_listadas($id_cliente)
	{
		$texto_consulta = "SELECT * from view_notas_clientes where id_cliente = $id_cliente ;";
		
		$resultado = $this->db->query($texto_consulta);
		
	    if (!$resultado)
			echo $resultado;
		$notas ='';		
        foreach ($resultado->result() as $key) {
			# code...
			$notas=$notas.'</br>'.$key->observaciones;
		}
		if($notas==''){
			$notas='Sin notas';
		}
		return $notas;
	}
	public function obtener_reclamos_abiertos()
	{
		$texto_consulta = "SELECT * from reclamos where cerrado=0 ;";
		
		$resultado = $this->db->query($texto_consulta);
		
	    if (!$resultado)
			echo $resultado;		
        
		$this->total_reclamos = $resultado->num_rows();
		return $this->total_reclamos;
	}
	public function obtener_reclamos_abiertos_consultor($id_usuario)
	{
		$texto_consulta = "SELECT * from view_reclamos where  id_usuario = $id_usuario;";
		
		$resultado = $this->db->query($texto_consulta);
		
	    if (!$resultado)
			echo $resultado;
		return $resultado;
	}
	public function reclamos_abiertos()
	{
		$user = $this->ion_auth->user()->row(); //usuario registrado
		$userid = $user->id;
		$texto_consulta = "SELECT * from reclamos where cerrado=0 and id_usuario = $userid;";
		
		$resultado = $this->db->query($texto_consulta);
		
	    if (!$resultado)
			echo $resultado;		
        
		$this->total_reclamos = $resultado->num_rows();
		return $this->total_reclamos;
	}
	public function obtener_estado_reclamos($id_cliente)
	{
		$texto_consulta = "SELECT * from reclamos where cerrado=0 and id_cliente=$id_cliente ;";
		
		$resultado = $this->db->query($texto_consulta);
		
	    if (!$resultado)
			echo $resultado;		
        if($resultado->num_rows()>0){
			$estado='abierto';
		}else{
			$estado='cerrado';
		}
		
		return $estado;
	}
	public function obt_datos_cliente_reclamo($id_reclamo)
	{
		$texto_consulta = "SELECT `clientes`.`nombre`, `reclamos`.`observaciones` FROM `reclamos` inner join `clientes` on `reclamos`.`id_cliente` = `clientes`.`id_cliente` WHERE `reclamos`.`id` = $id_reclamo;";
		
		$resultado = $this->db->query($texto_consulta);
		
	    if (!$resultado)
			echo $resultado;	       
		
		return $resultado;
	}
	public function obtener_reclamos_cerrados()
	{
		$texto_consulta = "SELECT * from reclamos where cerrado=1 ;";
		
		$resultado = $this->db->query($texto_consulta);
		
	    if (!$resultado)
			echo $resultado;		
        
		$this->total_reclamos = $resultado->num_rows();
		return $this->total_reclamos;
	}
	public function total_reclamos() 
	{ 
	    $res = $this->obtener_reclamos(); 
	    $this->total_reclamos = $res->num_rows();
		return $this->total_reclamos; 
	}
	public function obt_causa_reclamos()
	{
		$texto_consulta = "SELECT * from causa_reclamo ;";
		
		$resultado = $this->db->query($texto_consulta);
		
	    if (!$resultado)
			echo $resultado;		
        
		return $resultado;
	}
	public function registrar_reclamos($id_cliente, $causa, $notas, $id_usuario, $local, $contencion, $causa_text, $preventiva, $costos, $resp_costos)
	{
		$texto_consulta =  "INSERT  INTO reclamos (fecha, id_causa_reclamo, observaciones,id_cliente, id_usuario, local, contencion, causa, preventiva, costos, resp_costos ,cerrado)" 
		. " VALUES(FROM_UNIXTIME(UNIX_TIMESTAMP(), '%Y-%m-%d %H.%i.%s'),'$causa','$notas', '$id_cliente', '$id_usuario', '$local', '$contencion', '$causa_text', '$preventiva', '$costos', '$resp_costos', 0);";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	public function registrar_llamame($id_cliente, $fecha)
	{
		$texto_consulta =  "UPDATE `clientes` SET `llamame`=1,`llamame_fecha`='$fecha' WHERE id_cliente = $id_cliente;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	public function registrar_inactivo($id_cliente, $valor)
	{
		$texto_consulta =  "UPDATE `clientes` SET `inactivo`=$valor WHERE id_cliente = $id_cliente;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	public function registrar_notas_clientes($id_cliente,$notas, $id_usuario)
	{
		$texto_consulta =  "INSERT IGNORE INTO notas_clientes (fecha,  observaciones, id_usuario, id_cliente)" 
		                  . " VALUES(FROM_UNIXTIME(UNIX_TIMESTAMP(), '%Y-%m-%d %H.%i.%s'),'$notas', $id_usuario,$id_cliente);";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	public function registrar_nota_reclamo($id_reclamo, $nota, $preventiva, $userid)
	{
		$texto_consulta =  "INSERT INTO `reclamo_seguimiento`( `id_reclamo`, `id_usuario`, `nota`, `preventiva`, `fecha`) VALUES ($id_reclamo,$userid,'$nota','$preventiva',FROM_UNIXTIME(UNIX_TIMESTAMP(), '%Y-%m-%d %H.%i.%s'));";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	public function obt_cartera_productos($cliente)
	{
		$texto_consulta = "SELECT distinct id_cliente,id_producto, id_repuesto,producto, repuesto,fecha_vcto, fecha_compra, no_factura, cantidad, id_pedido from view_cartera_productos_ordenados where id_cliente = $cliente   ;";
		
		$resultado = $this->db->query($texto_consulta);
		
	    if (!$resultado)
			echo $resultado;		
        
		return $resultado;
	}
	public function obt_ultimos_reclamos()
	{
		$texto_consulta = "select * from (SELECT 
		`view_reclamo_seguimientos`.`id_reclamo_seguimiento`,
		`view_reclamo_seguimientos`.`id_reclamo`,
		`view_reclamo_seguimientos`.`id_usuario`,
		`view_reclamo_seguimientos`.`nota`,
		`view_reclamo_seguimientos`.`preventiva`,
		`view_reclamo_seguimientos`.`fecha`,
		`view_reclamo_seguimientos`.`usuario`
	  FROM
		`view_reclamo_seguimientos` order by `view_reclamo_seguimientos`.`id_reclamo_seguimiento` DESC) a
		group by   a.`id_reclamo`  ;";
		
		$resultado = $this->db->query($texto_consulta);
		
	    if (!$resultado)
			echo $resultado;		
        
		return $resultado;
	}
	public function cerrar_reclamo($id_reclamo, $userid){
		$texto_consulta = "UPDATE `reclamos` SET `cerrado`=1,`cerrado_por`=$userid WHERE id = $id_reclamo ;";
		
		$resultado = $this->db->query($texto_consulta);
		
	    if (!$resultado)
			echo $resultado;		
	}
	public function pedido_cliente_mision($cliente)
	{
		$texto_consulta = "SELECT `id_mision`, `id_usuario`, `id_cliente`, `fecha_inicio`, `fecha_fin`, `exitosa`, `notas`, `reg_cancelado`, `id_pedido`, `id_nueva_venta`, `id_repuesto` from misiones where id_cliente = $cliente order by id_mision desc limit 1 ;";
		
		$resultado = $this->db->query($texto_consulta);
		
	    if (!$resultado)
			echo $resultado;		
        
		return $resultado;
	}
	public function cartera_esta_activo($cliente)
	{
		$fecha = date(" Y-m-d H:i:s ");
		$texto_consulta = "SELECT id_mision, fecha_inicio,fecha_fin FROM `misiones` WHERE id_cliente= $cliente and  '$fecha'>= fecha_inicio and '$fecha' <= fecha_fin ORDER BY id_mision desc limit 1;";
		
		$resultado = $this->db->query($texto_consulta);
		
	    if (!$resultado)
			echo $resultado;		
        
		return $resultado->num_rows();
	}
	public function cartera_mision_activa($cliente)
	{
		$fecha = date(" Y-m-d H:i:s ");
		$texto_consulta = "SELECT id_mision, fecha_inicio,fecha_fin FROM `misiones` WHERE id_cliente= $cliente and  '$fecha'>= fecha_inicio and '$fecha' <= fecha_fin ORDER BY id_mision desc limit 1;";
		
		$resultado = $this->db->query($texto_consulta);
		
	    if (!$resultado)
			echo $resultado;		
        
		return $resultado->result();
	}
	public function baja_pedido($id_actual, $id_producto)
	{
		$texto_consulta =  "UPDATE IGNORE detalles SET 
		                    reg_cancelado = 1
							WHERE (id_pedido = $id_actual and id_producto = $id_producto);"; 
		                    
		
		$resultado = $this->db->query($texto_consulta);
		$texto_consulta =  "DELETE FROM `temp_cartera_productos` WHERE  (id_pedido = $id_actual and id_producto = $id_producto);"; 
		                    
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	public function modificar_cartera_cliente($id_actual, $dni, $id_municipio, $nombre,$apellidos, $telefono,$celular, $email, $codigo_postal, $calle, $nro, $piso, $dpto, $entrecalle1, $entrecalle2,  $vip, $nivel, $observaciones, $cuit)
	{
		$nombre = str_replace("'","´",$nombre);
		$apellidos = str_replace("'","´",$apellidos);

		$texto_consulta =  "UPDATE IGNORE clientes SET 
		                    dni='$dni', 
							id_municipio='$id_municipio', 
							nombre='$nombre', 
							apellidos='$apellidos', 
							telefono='$telefono', 
							celular='$celular',
							email='$email', 
							codigo_postal='$codigo_postal',
							calle='$calle',
							nro='$nro',
							piso='$piso',
							dpto='$dpto',
							entrecalle1='$entrecalle1', 
							entrecalle2='$entrecalle2',								
							vip = $vip,
							nivel = $nivel,
							observaciones= '$observaciones',
							cuit= '$cuit'
							WHERE (id_cliente = $id_actual);"; 
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	public function cancelar_solicitud_baja($id_cliente)
	{
		$texto_consulta =  "DELETE FROM `solicitud_baja` WHERE  (id_cliente = $id_cliente);"; 
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	public function obt_consultores_evaluacion()
	{
		$texto_consulta = "SELECT *	FROM view_consultores_locales ;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function obt_consultor_evaluacion($id_usuario)
	{
		$texto_consulta = "SELECT *	FROM view_consultores_locales where id = $id_usuario ;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function obt_llamadas_diaria($id_consultor)
	{
		$anno = date('Y');
		$texto_consulta = "SELECT *	FROM view_misiones_diaria where anno = $anno ;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function obt_ventas_diaria($id_consultor)
	{
		$anno = date('Y');
		$texto_consulta = "SELECT *	FROM view_ventas_diaria where anno = $anno ;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function obt_reclamos_diaria($id_consultor)
	{
		$anno = date('Y');
		$texto_consulta = "SELECT *	FROM view_reclamos_diario where anno = $anno ;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function obt_consultor($id_consultor)
	{
		$texto_consulta = "SELECT *	FROM usuarios where id = $id_consultor ;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function obt_locales()
	{
		$texto_consulta = "SELECT *	FROM locales  ;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function obt_local($id_local)
	{
		$texto_consulta = "SELECT *	FROM locales where id= $id_local  ;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function modificar_consultor($id_actual, $local)
	{
		$texto_consulta =  "UPDATE IGNORE usuarios SET 
		                    id_local= $local
							WHERE (id = $id_actual);"; 
		                    
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	public function total_locales() 
	{ 
	    $res = $this->obt_locales(); 
	    $this->total_locales = $res->num_rows();
		return $this->total_locales; 
	}
	public function modificar_local($id_actual, $descripcion)
	{
		$texto_consulta =  "UPDATE IGNORE locales SET 
		                    nombre = '$descripcion'
							WHERE (id = $id_actual);"; 
		                    
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	public function registrar_local( $descripcion)
	{
		$texto_consulta =  "INSERT IGNORE INTO locales (nombre)" 
		                  . " VALUES('$descripcion');";
		
		$resultado = $this->db->query($texto_consulta);
			    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	public function cancelar_local($id_local)
	{
		$texto_consulta =  "DELETE FROM `locales` WHERE  (id = $id_local);"; 
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	public function obtener_productos_locales($fecha_inicio, $fecha_final)
	{
		$texto_consulta =  "SELECT producto, local1, sum(cantidad) as cantidad FROM `view_ventas_locales` WHERE  (fecha_solicitud >= '$fecha_inicio' and fecha_solicitud <= '$fecha_final') group by id_producto, local1;"; 
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}	
	public function cobrado_rev($id_pedido)
	{
		$texto_consulta =  "UPDATE IGNORE pedidos SET 
		                    acreditado = 1
							WHERE (id_pedido = $id_pedido);"; 
		                    
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	public function entregado_rev($id_entrega)
	{
		$texto_consulta =  "UPDATE IGNORE entregas_directas SET 
		                    despachado = 1
							WHERE (id_pedido = $id_entrega);"; 
		                    
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	public function obt_usuarios_jr()
	{
		$texto_consulta = "SELECT `user_id` FROM usuarios_grupos where group_id=4;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
			
		return $resultado;
	}	
	public function obt_usuarios_jrInt()
	{
		$texto_consulta = "SELECT `user_id` FROM usuarios_grupos where group_id=11;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
			
		return $resultado;
	}	
	public function obt_evaluacion_consultor($id_consultor)
	{
		$texto_consulta = "SELECT * FROM evaluaciones where id_subordinado=$id_consultor;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
			
		return $resultado;
	}	
	public function obt_criterios()
	{
		$texto_consulta = "SELECT * FROM criterio_evaluacion ;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
			
		return $resultado;
	}	
	public function obt_evaluacion_usuario($anno, $mes, $id_usuario)
	{
		$texto_consulta = "SELECT * FROM view_evaluacion where anno=$anno and mes = $mes and id_subordinado= $id_usuario ;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
			
		return $resultado;
	}	
	public function agregar_evaluacion_consultor($id_consultor,$anno, $mes,$evaluacion, $notas,$valor1,$valor2,$valor3,$valor4,$valor5,$valor6)
	{
		$user = $this->ion_auth->user()->row();
		$res = $this->misiones_cant_usuario($user->id);		
			
		$texto_consulta =  "DELETE FROM `evaluaciones` WHERE id_subordinado= $id_consultor and anno=$anno and  mes= $mes;";
		
		$resultado = $this->db->query($texto_consulta);
		
		$texto_consulta =  "INSERT IGNORE INTO evaluaciones (id_jefe,id_subordinado,anno, mes,evaluacion, notas)" . " VALUES($user->id, $id_consultor,$anno, $mes,$evaluacion, '$notas');";
		
		$resultado = $this->db->query($texto_consulta);
		$id_eva = $this->db->insert_id();
		
		$texto_consulta =  "INSERT INTO `detalle_evaluacion`(`id_evaluacion`, `id_criterio`, `valor`) VALUES ($id_eva,1,$valor1);";
		$resultado = $this->db->query($texto_consulta);

		$texto_consulta =  "INSERT INTO `detalle_evaluacion`(`id_evaluacion`, `id_criterio`, `valor`) VALUES ($id_eva,2,$valor2);";
		$resultado = $this->db->query($texto_consulta);

		$texto_consulta =  "INSERT INTO `detalle_evaluacion`(`id_evaluacion`, `id_criterio`, `valor`) VALUES ($id_eva,3,$valor3);";
		$resultado = $this->db->query($texto_consulta);

		$texto_consulta =  "INSERT INTO `detalle_evaluacion`(`id_evaluacion`, `id_criterio`, `valor`) VALUES ($id_eva,4,$valor4);";
		$resultado = $this->db->query($texto_consulta);

		$texto_consulta =  "INSERT INTO `detalle_evaluacion`(`id_evaluacion`, `id_criterio`, `valor`) VALUES ($id_eva,5,$valor5);";
		$resultado = $this->db->query($texto_consulta);

		$texto_consulta =  "INSERT INTO `detalle_evaluacion`(`id_evaluacion`, `id_criterio`, `valor`) VALUES ($id_eva,6,$valor6);";
		$resultado = $this->db->query($texto_consulta);
		
		$texto_consulta =  "INSERT IGNORE INTO evaluaciones (id_subordinado,anno, mes,evaluacion, notas)" 
		                  . " VALUES($id_consultor,$anno, $mes,$evaluacion, '$notas');";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	public function cancelar_evaluacion_consultor($id_consultor, $id_evaluacion)
	{
		$texto_consulta =  "DELETE FROM evaluaciones WHERE (id=$id_evaluacion );"; 
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $this->db->affected_rows();
	}
	public function obt_nro_envio($id_pedido)
	{
		$texto_consulta = "SELECT * FROM entregas_envios where id_pedido=$id_pedido;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		if($resultado->num_rows()>0){
			$resu = $resultado->result();
			$valor = $resu[0]->numero_envio;
		}else{
			$valor =0;
		}	
		return $valor;
	}
	public function obt_datos_revendedor($id_usuario)
	{
		$texto_consulta = "INSERT INTO `clientes`(`id_municipio`, `dni`, `nombre`, `apellidos`, `telefono`, `email`, `en_operacion`, `en_mision`, `reg_cancelado`, `codigo_postal`, `calle`, `nro`, `piso`, `dpto`, `entrecalle1`, `entrecalle2`, `fecha_nacimiento`, `celular`, `cuit`) (SELECT  `id_municipio`, `dni`, `nombre`, `apellidos`,  `telefono`, `email`, 0 as en_operacion, 0 as en_mision,0 as reg_cancelado,`codigo_postal`, `calle`, `nro`, `piso`, `dpto`, `entrecalle1`, `entrecalle2`, `fecha_nacimiento`, `celular`, `cuit` FROM `datos_revendedores` WHERE `datos_revendedores`.id_usuario not in (select view_usuarios_clientes.id as id_usuario from view_usuarios_clientes));";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;

		$texto_consulta = "SELECT `id`, `id_cliente`, `id_municipio`, `dni`, `nombre`, `apellidos`, `direccion`, `telefono`, `email`, `en_operacion`, `en_mision`, `codigo_postal`, `calle`, `nro`, `piso`, `dpto`, `entrecalle1`, `entrecalle2`, `fecha_nacimiento`, `origen`, `celular`, `cuit`, `reg_cancelado`,municipio, id_provincia, provincia, id_pais, pais FROM `view_usuarios_clientes` WHERE id=$id_usuario;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function obt_codigos_seguimientos(){
		$texto_consulta = "SELECT * FROM `view_codigos_seguimiento` WHERE numero_envio is not null;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function usuarios_consultores(){
		$texto_consulta = "SELECT 
		`usuarios`.`id`,
		`usuarios`.`username`,
		`usuarios`.`first_name`,
		`usuarios`.`last_name`,
		`usuarios`.`active`,
		`usuarios`.`email`,
		`usuarios_grupos`.`group_id`
	  FROM
		`usuarios`
		INNER JOIN `usuarios_grupos` ON (`usuarios`.`id` = `usuarios_grupos`.`user_id`)
		WHERE `usuarios_grupos`.`group_id`=5 and `usuarios`.`active` =1 and `usuarios`.`id`<> 64;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function microtime_float()
	{
	list($useg, $seg) = explode(" ", microtime());
	return ((float)$useg + (float)$seg);
	}
	public function obt_todas_notas_reclamo($id_reclamo){
		$texto_consulta = "SELECT * FROM `view_reclamo_seguimientos` WHERE id_reclamo = $id_reclamo;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function obtener_opciones_seguimiento()
	{
		$texto_consulta = "SELECT * FROM `opciones_seguimiento`;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function registrar_cliente_rev($municipio,$dni,$nombre,$apellidos, $telefono, $email, $celular, $calle, $dpto, $entrecalle1, $entrecalle2, $nro, $fecha_nacimiento, $codigo_postal, $piso, $cuit, $fecha_compra, $producto, $cantidad, $consecutivo)
	{
		$nombre = str_replace("'","´",$nombre);
		$apellidos = str_replace("'","´",$apellidos);
   
		// Usuario actual
		$us = $this->ion_auth->user()->row();
		$id_usuario = $us->id;
		$canal = 'CARGA INICIAL';
		$id_canal = 13;
		$nuevo_cliente = 'true';
		
		$cliente_nuevo_rev = '';
		// comprobar si el cliente supuestamente nuevo esta en el sistema
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
			$consulta_clientes = "INSERT INTO clientes ( id_municipio, dni, nombre, apellidos, calle, nro, piso, dpto, entrecalle1, entrecalle2, telefono, celular, email, en_operacion, en_mision, reg_cancelado, codigo_postal, fecha_nacimiento, origen, observaciones, cuit ) VALUES ($municipio, '$dni', '$nombre', '$apellidos', '$calle', '$nro', '$piso', '$dpto', '$entrecalle1', '$entrecalle2','$telefono', '$celular', '$email', 0, 0, 0,'$codigo_postal', '$fecha_nacimiento','$canal', '', '$cuit');";
		else{
			$consulta_clientes= "UPDATE clientes SET id_municipio= $municipio, dni = '$dni', nombre = '$nombre', apellidos = '$apellidos', calle = '$calle', nro = '$nro', piso = '$piso', dpto = '$dpto', entrecalle1 = '$entrecalle1', entrecalle2 = '$entrecalle2',telefono = '$telefono', celular= '$celular', email = '$email', en_operacion = 0, en_mision= 0, en_operacion = 0, codigo_postal = '$codigo_postal', fecha_nacimiento = '$fecha_nacimiento', observaciones='' , cuit='$cuit' WHERE id_cliente=$id_cliente_act;";
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
			
			$consulta_pedidos = "INSERT INTO pedidos (no_factura, referencia, id_cliente, id_canal, id_usuario, fecha_solicitud, reg_cancelado, armado, id_tipo_factura, recargo, calle_entrega,nro_entrega, piso_entrega, dpto_entrega, entrecalle1_entrega, entrecalle2_entrega) VALUES ('$consecutivo', '$consecutivo',$id_cliente_act, $id_canal, $id_usuario,  '$fecha_compra', 0,1,1,0, '','', '', '', '', '');";   
			
			
		else{
			
			$consulta_pedidos = "INSERT INTO pedidos ( no_factura, referencia, id_cliente, id_canal, id_usuario,  fecha_solicitud, reg_cancelado, armado, id_tipo_factura, recargo, calle_entrega,nro_entrega, piso_entrega, dpto_entrega, entrecalle1_entrega, entrecalle2_entrega) VALUES ('$consecutivo', '$consecutivo', LAST_INSERT_ID(), $id_canal, $id_usuario, '$fecha_compra', 0,1,1,0, '', '', '', '', '', '');";
		
			
			
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
		$consulta_detalles = '';
		$importe_total = 0;
		
		$consulta_detalles = "INSERT INTO detalles (id_pedido, id_producto, id_campana, id_color, cantidad, precio, descuento, reg_cancelado, descuento_vip, incremento) VALUES (ID_ULTIMO_PED, " . $producto . ", 1, 1, "  . $cantidad. ", 1, 0, 0,0, 0);";
	
		
		// Entrega
		
		
		// Consecutivo
		$consulta_consecutivo = "UPDATE sys_parametros SET valor = valor + 1 WHERE parametro = 'CONSECUTIVO_VENTA'";
		
		
   
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
			
			$this->db->query( str_replace("ID_ULTIMO_PED", $id_ultimo_ped, $consulta_detalles) );	
			
		
			
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
	public function registrar_cliente_revint($municipio,$dni,$nombre,$apellidos, $telefono, $email, $celular, $calle, $dpto, $entrecalle1, $entrecalle2, $nro, $fecha_nacimiento, $codigo_postal, $piso, $cuit, $fecha_compra, $producto, $cantidad, $consecutivo)
	{
		$nombre = str_replace("'","´",$nombre);
		$apellidos = str_replace("'","´",$apellidos);
   
		// Usuario actual
		$us = $this->ion_auth->user()->row();
		$id_usuario = $us->id;
		$canal = 'CARGA INICIAL';
		$id_canal = 13;
		$nuevo_cliente = 'true';
		
		$cliente_nuevo_rev = '';
		// comprobar si el cliente supuestamente nuevo esta en el sistema
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
			$consulta_clientes = "INSERT INTO clientes ( id_municipio, dni, nombre, apellidos, calle, nro, piso, dpto, entrecalle1, entrecalle2, telefono, celular, email, en_operacion, en_mision, reg_cancelado, codigo_postal, fecha_nacimiento, origen, observaciones, cuit ) VALUES ($municipio, '$dni', '$nombre', '$apellidos', '$calle', '$nro', '$piso', '$dpto', '$entrecalle1', '$entrecalle2','$telefono', '$celular', '$email', 0, 0, 0,'$codigo_postal', '$fecha_nacimiento','$canal', '', '$cuit');";
		else{
			$consulta_clientes= "UPDATE clientes SET id_municipio= $municipio, dni = '$dni', nombre = '$nombre', apellidos = '$apellidos', calle = '$calle', nro = '$nro', piso = '$piso', dpto = '$dpto', entrecalle1 = '$entrecalle1', entrecalle2 = '$entrecalle2',telefono = '$telefono', celular= '$celular', email = '$email', en_operacion = 0, en_mision= 0, en_operacion = 0, codigo_postal = '$codigo_postal', fecha_nacimiento = '$fecha_nacimiento', observaciones='' , cuit='$cuit' WHERE id_cliente=$id_cliente_act;";
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
			
			$consulta_pedidos = "INSERT INTO pedidos (no_factura, referencia, id_cliente, id_canal, id_usuario, fecha_solicitud, reg_cancelado, armado, id_tipo_factura, recargo, calle_entrega,nro_entrega, piso_entrega, dpto_entrega, entrecalle1_entrega, entrecalle2_entrega) VALUES ('$consecutivo', '$consecutivo',$id_cliente_act, $id_canal, $id_usuario,  '$fecha_compra', 0,1,1,0, '','', '', '', '', '');";   
			
			
		else{
			
			$consulta_pedidos = "INSERT INTO pedidos ( no_factura, referencia, id_cliente, id_canal, id_usuario,  fecha_solicitud, reg_cancelado, armado, id_tipo_factura, recargo, calle_entrega,nro_entrega, piso_entrega, dpto_entrega, entrecalle1_entrega, entrecalle2_entrega) VALUES ('$consecutivo', '$consecutivo', LAST_INSERT_ID(), $id_canal, $id_usuario, '$fecha_compra', 0,1,1,0, '', '', '', '', '', '');";
		
			
			
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
		$consulta_detalles = '';
		$importe_total = 0;
		
		$consulta_detalles = "INSERT INTO detalles (id_pedido, id_producto, id_campana, id_color, cantidad, precio, descuento, reg_cancelado, descuento_vip, incremento) VALUES (ID_ULTIMO_PED, " . $producto . ", 1, 1, "  . $cantidad. ", 1, 0, 0,0, 0);";
	
		
		// Entrega
		
		
		// Consecutivo
		$consulta_consecutivo = "UPDATE sys_parametros SET valor = valor + 1 WHERE parametro = 'CONSECUTIVO_VENTA'";
		
		
   
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
			
			$this->db->query( str_replace("ID_ULTIMO_PED", $id_ultimo_ped, $consulta_detalles) );	
			
		
			
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
}