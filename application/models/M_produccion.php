<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_produccion extends CI_Model {
    
		
    public function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
	// Tipo ********************************+
	public function get_tipos($id = FALSE){		
		if ($id === FALSE)
		{
			$query = $this->db->get('p_tipo');
			return $query->result_array();
		}
		$query = $this->db->get_where('p_tipo', array('id' => $id));
		return $query->row_array();
	}
	public function delete_tipo( $id_tipo = null)
	{
		# code...
		$query = $this->db->delete('p_tipo', array('id' => $id_tipo));
		return $query;
	}
	public function set_tipo( $tipo = null)
	{
		# code...
		$this->db->set('nombre', $tipo);
		$query =$this->db->insert('p_tipo');
		return $query;
	}
	public function upd_tipo($id_actual, $id_tipo, $tipo)
	{
		# code...
		$data = array(
			'id' => $id_tipo,
			'nombre' => $tipo
			);
		$this->db->where('id', $id_actual);
		$query =$this->db->update('p_tipo', $data);
		
		return $query;
	}
	//************************* */
	// Subtipo ********************************+
	public function get_subtipos($id = FALSE){		
		if ($id === FALSE)
		{
			$query = $this->db->get('p_view_subtipo');
			return $query->result_array();
		}
		$query = $this->db->get_where('p_view_subtipo', array('id' => $id));
		return $query->row_array();
	}
	public function delete_subtipo( $id_subtipo = null)
	{
		# code...
		$query = $this->db->delete('p_subtipo', array('id' => $id_subtipo));
		return $query;
	}
	public function set_subtipo( $subtipo, $id_tipo)
	{
		# code...
		$this->db->set('nombre', $subtipo);
		$this->db->set('id_tipo', $id_tipo);
		$query =$this->db->insert('p_subtipo');
		return $query;
	}
	public function upd_subtipo($id_actual, $id_subtipo, $subtipo, $id_tipo)
	{
		# code...
		$data = array(
			'id' => $id_subtipo,
			'nombre' => $subtipo,
			'id_tipo' =>  $id_tipo
			);
		$this->db->where('id', $id_actual);
		$query =$this->db->update('p_subtipo', $data);
		
		return $query;
	}
	//************************* */
	// Moneda ********************************+
	public function get_tipocambios($id = FALSE){		
		if ($id === FALSE)
		{
			$query = $this->db->get('p_nom_tipo_cambio');
			return $query->result_array();
		}
		$query = $this->db->get_where('p_nom_tipo_cambio', array('id' => $id));
		return $query->row_array();
	}
	public function delete_tipocambio( $id_tipocambio = null)
	{
		# code...
		$query = $this->db->delete('p_nom_tipo_cambio', array('id' => $id_tipocambio));
		return $query;
	}
	public function set_tipocambio( $tipocambio = null)
	{
		# code...
		$this->db->set('nombre', $tipocambio);
		$query =$this->db->insert('p_nom_tipo_cambio');
		return $query;
	}
	public function upd_tipocambio($id_actual, $id_tipocambio, $tipocambio)
	{
		# code...
		$data = array(
			'id' => $id_tipocambio,
			'nombre' => $tipocambio
			);
		$this->db->where('id', $id_actual);
		$query =$this->db->update('p_nom_tipo_cambio', $data);
		
		return $query;
	}
	//************************* */
	// Tipo de cambio ********************************+
	public function get_detalletipocambios($id = FALSE){		
		if ($id === FALSE)
		{
			$query = $this->db->get('p_view_tipo_cambio');
			return $query->result_array();
		}
		$query = $this->db->get_where('p_view_tipo_cambio', array('id' => $id));
		return $query->row_array();
	}
	public function delete_detalletipocambio( $id_tipocambio = null)
	{
		# code...
		$query = $this->db->delete('p_tipo_cambios', array('id' => $id_tipocambio));
		return $query;
	}
	public function set_detalletipocambio( $moneda, $anno, $mes, $valor	)
	{
		
		$this->db->set('id_tipo_cambio', $moneda);
		$this->db->set('anno', $anno);
		$this->db->set('mes', $mes);
		$this->db->set('valor', $valor);
		$query =$this->db->insert('p_tipo_cambios');
		return $query;
	}
	public function upd_detalletipocambio($id_actual, $id_detalletipocambio, $id_tipocambio, $anno, $mes, $valor)
	{
		# code...
		$data = array(
			'id' => $id_detalletipocambio,
			'id_tipo_cambio' => $id_tipocambio,
			'anno' => $anno,
			'mes' => $mes,
			'valor' => $valor
			);
		$this->db->where('id', $id_actual);
		$query =$this->db->update('p_tipo_cambios', $data);
		
		return $query;
	}
	//****************************************************************************************** */
	//******************** componente ********************************+
	public function get_componentes($id = FALSE){		
		if ($id === FALSE)
		{
			$query = $this->db->get('p_view_componentes');
			return $query->result_array();
		}
		$query = $this->db->get_where('p_view_componentes', array('id' => $id));
		return $query->row_array();
	}
	public function delete_componente( $id_subtipo = null)
	{
		# code...
		$query = $this->db->delete('p_componentes', array('id' => $id_subtipo));
		return $query;
	}
	public function set_componente( $componente, $id_subtipo)
	{
		# code...
		$this->db->set('nombre', $componente);
		$this->db->set('id_subtipo', $id_subtipo);
		$query =$this->db->insert('p_componentes');
		return $query;
	}
	public function upd_componente($id_actual, $id_componente,  $componente, $id_subtipo)
	{
		# code...
		$data = array(
			'id' => $id_componente,
			'nombre' => $componente,
			'id_subtipo' =>  $id_subtipo
			);
		$this->db->where('id', $id_actual);
		$query =$this->db->update('p_componentes', $data);
		
		return $query;
	}
	//******************************************************************************************** */
	//****************************************************************************************** */
	//******************** componente ********************************+
	public function get_componente_compras($id = FALSE)
	{		
		if ($id === FALSE)
		{
			$query = $this->db->get('p_view_compras');
			return $query->result_array();
		}
		$query = $this->db->get_where('p_view_compras', array('id_componente' => $id));
		return $query->result_array();
	}
	public function delete_componente_compras( $id_compra = null)
	{
		# code...
		$query = $this->db->delete('p_compras', array('id' => $id_compra));
		return $query;
	}
	public function set_componente_compras($id_componente, $moneda, $anno, $mes, $valor)
	{	
		$query = $this->db->get_where('p_nom_tipo_cambio', array('id' => $moneda));
		$ca = $query->row_array();
		
		$mo =$ca['nombre'];
		// buscar el tipo de cambio actual para esa moneda
		$consulta = "SELECT `valor` FROM `p_view_tipo_cambio` Where moneda= '$mo' order by moneda,anno desc,mes desc limit 1;"; 
		$re = $this->db->query($consulta);
		$re = $re->row_array();
		
		$this->db->set('id_componente', $id_componente);
		$this->db->set('id_tipocambio', $moneda);
		$this->db->set('anno', $anno);
		$this->db->set('mes', $mes);
		$this->db->set('tipo_cambio', $re['valor']);
		$this->db->set('valor', $valor);
		$this->db->set('valor_final', $valor*$re['valor']);
		$query =$this->db->insert('p_compras');
				
		return $query;
	}
		
	public function get_compras($id_componente,  $anno, $mes)
	{	
		
		$query = $this->db->get_where('p_compras', array('id_componente' => $id_componente, 'anno' => $anno, 'mes' => $mes));
		return $query->result_array();
	} 
	//******************************************************************************************** */
	// p_categorias ********************************+
	public function get_p_categorias($id = FALSE){		
		if ($id === FALSE)
		{
			$query = $this->db->get('p_categorias');
			return $query->result_array();
		}
		$query = $this->db->get_where('p_categorias', array('id' => $id));
		return $query->row_array();
	}
	public function delete_p_categoria( $id_tipo = null)
	{
		# code...
		$query = $this->db->delete('p_categorias', array('id' => $id_tipo));
		return $query;
	}
	public function set_p_categoria( $tipo = null)
	{
		# code...
		$this->db->set('nombre', $tipo);
		$query =$this->db->insert('p_categorias');
		return $query;
	}
	public function upd_p_categorias($id_actual, $id_tipo, $tipo)
	{
		# code...
		$data = array(
			'id' => $id_tipo,
			'nombre' => $tipo
			);
		$this->db->where('id', $id_actual);
		$query =$this->db->update('p_categorias', $data);
		
		return $query;
	}
	//************************* */
	// p_producto ********************************+
	public function get_p_productos($id = FALSE){		
		if ($id === FALSE)
		{
			$query = $this->db->get('p_view_productos');
			return $query->result_array();
		}
		$query = $this->db->get_where('p_view_productos', array('id' => $id));
		return $query->row_array();
	}
	public function delete_p_producto( $id_producto = null)
	{
		# code...
		$query = $this->db->delete('p_productos', array('id' => $id_producto));
		return $query;
	}
	public function set_p_producto($producto, $id_categoria,$valor_alarma, $id_um, $prod_venta, $pt)
	{
		# code...
		$this->db->set('nombre', $producto);
		$this->db->set('id_categoria', $id_categoria);
		$this->db->set('id_um', $id_um);
		$this->db->set('valor_alarma', $valor_alarma);
		$this->db->set('id_producto_venta', $prod_venta);
		$this->db->set('producto_terminado', $pt);
		$query =$this->db->insert('p_productos');
		return $query;
	}
	public function upd_p_producto($id_actual, $id_producto, $producto, $id_categoria,$valor_alarma, $id_um, $prod_venta, $pt)
	{
		# code...
		$data = array(
			'id' => $id_producto,
			'nombre' => $producto,
			'id_um' =>  $id_um,
			'id_categoria' =>  $id_categoria,
			'valor_alarma' =>  $valor_alarma,
			'id_producto_venta' =>  $prod_venta,
			'producto_terminado' =>  $pt
			);
		$this->db->where('id', $id_actual);
		$query =$this->db->update('p_productos', $data);
		
		return $query;
	}
	//************************* */
	// Almacenes ********************************+
	public function get_almacenes($id = FALSE){		
		if ($id === FALSE)
		{
			$query = $this->db->get('p_almacenes');
			return $query->result_array();
		}
		$query = $this->db->get_where('p_almacenes', array('id' => $id));
		return $query->row_array();
	}
	public function delete_almacen( $id_almacen = null)
	{
		# code...
		$query = $this->db->delete('p_almacenes', array('id' => $id_almacen));
		return $query;
	}
	public function set_almacen( $almacen = null)
	{
		
		# code...
		$this->db->set('nombre', $almacen);
		$query =$this->db->insert('p_almacenes');
		return $query;
	}
	public function upd_almacen($id_actual, $id_almacen, $almacen)
	{
		# code...
		$data = array(
			'id' => $id_almacen,
			'nombre' => $almacen
			);
		$this->db->where('id', $id_actual);
		$query =$this->db->update('p_almacenes', $data);
		
		return $query;
	}
	//************************* */
	// UM ********************************+
	public function get_ums($id = FALSE){		
		if ($id === FALSE)
		{
			$query = $this->db->get('p_um');
			return $query->result_array();
		}
		$query = $this->db->get_where('p_um', array('id' => $id));
		return $query->row_array();
	}
	public function delete_um( $id_um = null)
	{
		# code...
		$query = $this->db->delete('p_um', array('id' => $id_um));
		return $query;
	}
	public function set_um( $um = null)
	{
		
		# code...
		$this->db->set('nombre', $um);
		$query =$this->db->insert('p_um');
		return $query;
	}
	public function upd_um($id_actual, $id_um, $um)
	{
		# code...
		$data = array(
			'id' => $id_um,
			'nombre' => $um
			);
		$this->db->where('id', $id_actual);
		$query =$this->db->update('p_um', $data);
		
		return $query;
	}
	//************************* */
	// ******  Productos asociados
	public function get_producto_asociados($id_producto , $id_categoria )
	{
		if ($id_producto === FALSE)
		{
			$query = $this->db->get('p_view_producto_interno');
			return $query->result_array();
		}
		$query = $this->db->get_where('p_view_producto_interno', array('id_producto' => $id_producto, 'id_categoria' => $id_categoria));
		return $query->result_array();
	}
	public function get_internos( $id_categoria)
	{
		if ($id_categoria === FALSE)
		{
			$query = $this->db->get('p_view_productos');
			return $query->result_array();
		}
		$query = $this->db->get_where('p_view_productos', array('id_categoria' => $id_categoria));
		return $query->result_array();
	}
	public function get_internos_exi($id_producto,  $id_categoria)
	{	
		
		$query = $this->db->get_where('p_view_producto_interno', array('id_producto' => $id_producto, 'id_categoria' => $id_categoria));
		return $query->result_array();
	} 
	public function set_producto_asociados($id_producto, $id_interno, $cantidad)
	{
		
		$this->db->set('id_producto', $id_producto);
		$this->db->set('id_interno', $id_interno);
		$this->db->set('cantidad', $cantidad);
		$query =$this->db->insert('p_producto_interno');
				
		return $query;
	}
	public function delete_producto_asociados( $id_asociado = null)
	{
		# code...
		$query = $this->db->delete('p_producto_interno', array('id' => $id_asociado));
		return $query;
	}
	//************************************************* */
	public function get_almacen_productos($id = FALSE)
	{		
		if ($id === FALSE)
		{
			$query = $this->db->get('p_view_almacen_productos');
			return $query->result_array();
		}
		$query = $this->db->get_where('p_view_almacen_productos', array('id_almacen' => $id));
		return $query->result_array();
	}
	public function get_inventario_productos($id = FALSE)
	{		
		if ($id === FALSE)
		{
			$query = $this->db->get('p_view_almacen_productos');
			return $query->result_array();
		}
		$query = $this->db->get_where('p_view_almacen_productos', array('id' => $id));
		return $query->row_array();
	}
	public function delete_almacen_productos( $id_inventario = null)
	{
		# code...
		$query = $this->db->delete('p_inventario', array('id' => $id_inventario));
		return $query;
	}
	public function set_almacen_productos($id_almacen, $id_producto, $valor)
	{		
		$this->db->set('id_almacen', $id_almacen);
		$this->db->set('id_producto', $id_producto);
		$this->db->set('inicial', $valor);
		$query =$this->db->insert('p_inventario');
				
		return $query;
	}
	public function get_inventario($id_almacen,  $id_producto)
	{			
		$query = $this->db->get_where('p_inventario', array('id_almacen' => $id_almacen, 'id_producto' => $id_producto));
		return $query->result_array();
	}	
	public function get_existencia_producto($id_producto, $id_almacen)
	{				
		$query = $this->db->get_where('p_view_almacen_productos', array('id_almacen' => $id_almacen, 'id_producto' => $id_producto));
		return $query->row_array();
	}	
	public function set_mov_productos($id_almacen_ori, $id_almacen_des, $id_producto, $cantidad)
	{
		//poner la salida
		$this->db->set('fecha', date('Y-m-d H:i:s'));
		$this->db->set('id_almacen', $id_almacen_ori);
		$this->db->set('id_producto', $id_producto);
		$this->db->set('valor', $cantidad);
		$this->db->set('movimiento', 'S');
		$this->db->set('observaciones', 'Mov');
		$query =$this->db->insert('p_movimiento_productos');
		//poner la entrada
		$this->db->set('fecha', date('Y-m-d H:i:s'));
		$this->db->set('id_almacen', $id_almacen_des);
		$this->db->set('id_producto', $id_producto);
		$this->db->set('valor', $cantidad);
		$this->db->set('movimiento', 'E');
		$this->db->set('observaciones', 'Mov');
		$query =$this->db->insert('p_movimiento_productos');
				
		return $query;
	}
	public function set_ent_productos($id_almacen_des, $id_producto, $cantidad, $observ)
	{		
		//poner la entrada
		$this->db->set('fecha', date('Y-m-d H:i:s'));
		$this->db->set('id_almacen', $id_almacen_des);
		$this->db->set('id_producto', $id_producto);
		$this->db->set('valor', $cantidad);
		$this->db->set('movimiento', 'E');
		$this->db->set('observaciones', $observ);
		$query =$this->db->insert('p_movimiento_productos');
				
		return $query;
	}
	public function set_sal_productos($id_almacen_ori, $id_producto, $cantidad, $observ)
	{		
		//poner la entrada
		$this->db->set('fecha', date('Y-m-d H:i:s'));
		$this->db->set('id_almacen', $id_almacen_ori);
		$this->db->set('id_producto', $id_producto);
		$this->db->set('valor', $cantidad);
		$this->db->set('movimiento', 'S');
		$this->db->set('observaciones', $observ);
		$query =$this->db->insert('p_movimiento_productos');
				
		return $query;
	}
	public function set_actualizar_productos($id_almacen_ori, $id_almacen_des, $id_producto, $cantidad,$salida,$entrada)
	{
		//poner la salida		
		$data = array(
			'salida' => $salida+$cantidad
			);
		$this->db->where('id_almacen', $id_almacen_ori);
		$this->db->where('id_producto', $id_producto);
		$query =$this->db->update('p_inventario', $data);

		
		//poner la entrada
		
		$this->db->set('id_almacen', $id_almacen_des);
		$this->db->set('id_producto', $id_producto);
		$this->db->set('inicial', 0);
		$this->db->set('entrada', $cantidad);
		$this->db->set('salida', 0);
		$query =$this->db->insert('p_inventario');
				
		return $query;
	}
	public function upd_actualizar_productos($id_almacen_ori, $id_almacen_des, $id_producto, $cantidad,$salida,$entrada)
	{
		//poner la salida		
		
		$data = array(
			'salida' => $salida+$cantidad
			);
		$this->db->where('id_almacen', $id_almacen_ori);
		$this->db->where('id_producto', $id_producto);
		$query =$this->db->update('p_inventario', $data);
		//poner la entrada
		$data = array(
			'entrada' => $entrada+$cantidad
			);
		$this->db->where('id_almacen', $id_almacen_des);
		$this->db->where('id_producto', $id_producto);
		$query =$this->db->update('p_inventario', $data);
				
		return $query;
	}
	public function set_ent_actualizar_productos($id_almacen_des, $id_producto, $cantidad)
	{
		//poner la entrada
		
		$this->db->set('id_almacen', $id_almacen_des);
		$this->db->set('id_producto', $id_producto);
		$this->db->set('inicial', 0);
		$this->db->set('entrada', $cantidad);
		$this->db->set('salida', 0);
		$query =$this->db->insert('p_inventario');
				
		return $query;
	}
	public function upd_ent_actualizar_productos($id_almacen_des, $id_producto, $cantidad,$entrada)
	{
		//poner la entrada
		$data = array(
			'entrada' => $entrada+$cantidad
			);
		$this->db->where('id_almacen', $id_almacen_des);
		$this->db->where('id_producto', $id_producto);
		$query =$this->db->update('p_inventario', $data);
				
		return $query;
	}
	
	public function upd_sal_actualizar_productos($id_almacen_ori, $id_producto, $cantidad,$salida)
	{
		//poner la entrada
		$data = array(
			'salida' => $salidad+$cantidad
			);
		$this->db->where('id_almacen', $id_almacen_ori);
		$this->db->where('id_producto', $id_producto);
		$query =$this->db->update('p_inventario', $data);
				
		return $query;
	}
	public function get_movimientos()
	{
		$query = $this->db->get('p_view_movimiento_productos');
		return $query->result_array();
	}
	public function get_producto_internos($id_producto = FALSE)
	{			
		if ($id_producto === FALSE)
		{
			$query = $this->db->get('p_view_producto_interno');
			return $query->result_array();
		}
		$query = $this->db->get_where('p_view_producto_interno', array('id_producto' => $id_producto));
		return $query->result_array();		
	}
	// Costo ********************************+
	public function get_costos($id = FALSE){		
		if ($id === FALSE)
		{
			$query = $this->db->get('p_view_costo');
			return $query->result_array();
		}
		$query = $this->db->get_where('p_view_costo', array('id' => $id));
		return $query->row_array();
	}
	public function delete_costo( $id_costo = null)
	{
		# code...
		$query = $this->db->delete('p_costo', array('id' => $id_costo));
		$query = $this->db->delete('p_detalles_costo', array('id_costo' => $id_costo));
		return $query;
	}
	public function delete_detalles_costo( $id_costo = null)
	{
		# code...
		$query = $this->db->delete('p_detalles_costo', array('id_costo' => $id_costo));
		return $query;
	}
	public function set_costo( $id_producto,$iibb, $com_vtas, $financ, $iigg )
	{
		# code...
		$this->db->set('iibb', $iibb);
		$this->db->set('com_vtas', $com_vtas);
		$this->db->set('financ', $financ);
		$this->db->set('iigg', $iigg);
		$this->db->set('id_producto', $id_producto);
		$query =$this->db->insert('p_costo');
		return $query;
	}
	public function upd_costo($id_actual, $data)
	{
		# code...
		
		$this->db->where('id', $id_actual);
		$query =$this->db->update('p_costo', $data);
		
		return $query;
	}
	//************************* */
	//******************** componente ********************************+
	public function get_costo_componentes($id = FALSE)
	{		
		if ($id === FALSE)
		{
			$query = $this->db->get('p_view_detalle_costos');
			return $query->result_array();
		}
		$query = $this->db->get_where('p_view_detalle_costos', array('id_costo' => $id));
		return $query->result_array();
	}
	public function delete_costo_componentes( $id_costo, $id_componente)
	{
		# code...
		$query = $this->db->delete('p_detalles_costo', array('id_costo' => $id_costo,'id_componente' => $id_componente));
		return $query;
	}
	public function set_costo_componentes($id_costo,$id_componente, $cantidad)
	{
		
		$this->db->set('id_componente', $id_componente);
		$this->db->set('id_costo', $id_costo);
		$this->db->set('cantidad', $cantidad);
		$query =$this->db->insert('p_detalles_costo');
				
		return $query;
	}
		
	public function get_detalles_costos($id_costo, $id_componente)
	{			
		$query = $this->db->get_where('p_detalles_costo', array('id_componente' => $id_componente, 'id_costo' => $id_costo));
		return $query->result_array();
	} 
	//******************************************************************************************** */
	public function tipocambio_actual($moneda)
	{
		$query = "SELECT `valor` FROM `p_view_tipo_cambio` where moneda='$moneda' order by moneda,anno desc,mes desc limit 1;";
		$resu1 = $this->db->query($query);
		return $resu1->row_array();
	}
	public function save_costo($data){
		return $this->db->insert("p_costo",$data);
	}

	public function lastID(){
		return $this->db->insert_id();
	}
	public function save_detalle($data){
		$this->db->insert("p_detalles_costo",$data);
	}
	public function actualizar_costo()
	{
		/*$consulta = "SELECT * FROM `p_view_tipocambio_actual`;"; 					
	    $tipo_cambio = $this->db->query($consulta);
	    if (!$tipo_cambio)
			echo $tipo_cambio;*/
		$tipo_cambio=	$this->tipocambio_actual('USD');
		
		$tipo_cambio = $tipo_cambio['valor'];

		$consulta = "SELECT * FROM `p_view_componentes`;"; 					
	    $componentes = $this->db->query($consulta);
	    if (!$componentes)
			echo $componentes;

		$consulta = "SELECT * FROM `p_detalles_costo`;"; 					
	    $detalles = $this->db->query($consulta);
	    if (!$detalles)
			echo $detalles;

		$consulta = "SELECT * FROM `p_costo`;"; 					
	    $costos = $this->db->query($consulta);
	    if (!$costos)
			echo $costos;
		
		foreach ($costos->result() as $key) {
			$subtotal = 0;
			foreach ($detalles->result() as $co) {
				if($key->id == $co->id_costo){
					$consulta = "SELECT * FROM `p_view_componentes` where id=$co->id_componente;"; 			
					$componentes = $this->db->query($consulta);
					$componentes = $componentes ->row_array();

					$costo1 = $componentes['valor'];
					$cantidad = $co->cantidad;
					$export1 = $costo1 * $cantidad/$tipo_cambio; 
					$nacio1 = $costo1 * $cantidad;
					$consulta1 = "UPDATE `p_detalles_costo` SET `cantidad`= $cantidad,`costo`=$costo1,`exportacion`= $export1,`nacional`= $nacio1 WHERE `id_costo`=$co->id_costo and`id_componente`= $co->id_componente;"; 					
					$resu1 = $this->db->query($consulta1);
										
					$subtotal = $subtotal + $nacio1;
				}
				$prec_promedio = $key->prec_promedio;
			}
			$id_costo = $key->id;
			$id_componente = $co->id_componente;
			$total= $subtotal + $prec_promedio*3/100 + $prec_promedio*2.5/100 + $prec_promedio*2/100 + $prec_promedio*5/100;
			
			$consulta1 = "UPDATE `p_costo` SET `tipo_cambio`= $tipo_cambio,`subtotal`=$subtotal,`total` = $total WHERE `id`=$id_costo;";								
			$resu1 = $this->db->query($consulta1);

			// comprobar si el mes actual existe en el historico
			$anno = date('Y');
			$mes = date('m');
			$consulta2 = "SELECT * FROM `p_historico` WHERE `id_producto`=$key->id_producto and anno=$anno and mes = $mes;";								
			$resu2 = $this->db->query($consulta2);
			if($resu2->num_rows()!=0){
				$consulta3 = "UPDATE `p_historico` SET `precio`= $subtotal WHERE `id_producto`=$key->id_producto and anno=$anno and mes = $mes;";							
				$resu1 = $this->db->query($consulta3);
			}else{
				$consulta3 = "INSERT INTO `p_historico`( `id_producto`, `anno`, `mes`, `precio`) VALUES ($key->id_producto,$anno,$mes,$subtotal);";							
				$resu1 = $this->db->query($consulta3);
			}
		}
		return true;
	}
	public function get_historico($id = FALSE){		
		if ($id === FALSE)
		{
			$mes = date('m');
			$anno = date('Y');
			$consulta3 = "SELECT * FROM `p_historico` where (anno=$anno-1 and mes>=$mes) or (anno=$anno and mes<=$mes);";							
			$resu1 = $this->db->query($consulta3);
			if (!$resu1)
				echo $resu1;
			
			return $resu1 ;
		}
		$query = $this->db->get_where('p_historico', array('id_producto' => $id));
		return $query->row_array();
	}
		// ML ********************************+
		public function get_mls($id = FALSE){		
			if ($id === FALSE)
			{
				$query = $this->db->get('p_ml');
				return $query->result_array();
			}
			$query = $this->db->get_where('p_ml', array('id' => $id));
			return $query->row_array();
		}
		public function delete_ml( $id_um = null)
		{
			# code...
			$query = $this->db->delete('p_ml', array('id' => $id_um));
			return $query;
		}
		public function set_ml( $especificacion,$producto,$sku,$pvp,$pvp_iva,$cmv,$cmv_iva,$margen_bruto,$mult_spvp,$premium,$clasica,$mercado_envio,$costo_total,$constribucion,$multiplicador)
		{			
			# code...
			$this->db->set('especificacion', $especificacion);
			$this->db->set('producto', $producto);
			$this->db->set('sku', $sku);
			$this->db->set('pvp', $pvp);
			$this->db->set('pvp_iva', $pvp_iva);
			$this->db->set('cmv', $cmv);
			$this->db->set('cmv_iva', $cmv_iva);
			$this->db->set('margen_bruto', $margen_bruto);
			$this->db->set('mult_spvp', $mult_spvp);
			$this->db->set('premium', $premium);
			$this->db->set('clasica', $clasica);
			$this->db->set('mercado_envio', $mercado_envio);
			$this->db->set('costo_total', $costo_total);
			$this->db->set('constribucion', $constribucion);
			$this->db->set('multiplicador', $multiplicador);
			$query =$this->db->insert('p_ml');
			return $query;
		}
		public function upd_ml($id_actual, $id_ml, $especificacion,$producto,$sku,$pvp,$pvp_iva,$cmv,$cmv_iva,$margen_bruto,$mult_spvp,$premium,$clasica,$mercado_envio,$costo_total,$constribucion,$multiplicador)
		{
			# code...
			$data = array(
				'id' => $id_ml,
				'especificacion' => $especificacion,
				'producto' => $producto,
				'sku' => $sku,
				'pvp' => $pvp,
				'pvp_iva' => $pvp_iva,
				'cmv' => $cmv,
				'cmv_iva' => $cmv_iva,
				'margen_bruto' => $margen_bruto,
				'mult_spvp' => $mult_spvp,
				'premium' => $premium,
				'clasica' => $clasica,
				'mercado_envio' => $mercado_envio,
				'costo_total' => $costo_total,
				'constribucion' => $constribucion,
				'multiplicador' => $multiplicador
			);
			$this->db->where('id', $id_actual);
			$query =$this->db->update('p_ml', $data);
			
			return $query;
		}
		//************************* */
}
?>