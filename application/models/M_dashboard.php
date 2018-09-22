<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_dashboard extends CI_Model {
    
    public function __construct()
    {
        parent::__construct();
    }
    public function obt_ventas_canales()
	{
		$texto_consulta = "SELECT anno, id_canal, nombre, count(importe) as importe 
                    FROM view_ventas_canales                    
                    where anno = year(curdate())
                    group by anno, id_canal  ;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function obt_ventas_canales_mes()
	{
		$texto_consulta = "SELECT anno, mes,id_canal, nombre, count(importe) as importe, nombre_mes 
                    FROM view_ventas_canales                    
                    where anno = year(curdate())
                    group by anno,mes, id_canal  ;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
    public function obt_respuestas_negativas()
	{
		$texto_consulta = "SELECT * FROM view_respuestas_negativas;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	 public function obt_usuario_con_objetivos()
	{
		$texto_consulta = "SELECT * FROM view_usuario_con_objetivos;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	 public function obt_ejecucion()
	{
		$texto_consulta = "SELECT id_usuario, nombre, apellidos, anno, id_tipo_objetivo,sum(objetivo) as objetivo, sum(ingresos) as ingresos, tipo 
			FROM view_ejecucion  where (mes <= month(curdate()) and anno = year(curdate())) group by id_usuario, anno, id_tipo_objetivo order by id_usuario, anno, id_tipo_objetivo ;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
    public function total_respuestas_negativas() 
	{ 
        $texto_consulta = "SELECT sum(cantidad) as total FROM view_respuestas_negativas;";
		
		$resultado = $this->db->query($texto_consulta); 
		if($resultado->num_rows()>0){
			$res = $resultado->result();
			$total =$res[0]->total;
		}else{			
			$total =0;
		} 
		return $total;
	}
	public function obt_objetivos_asignados()
	{
		$texto_consulta = "SELECT * FROM view_ejecucion;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function total_objetivos_asignados() 
	{ 
        $texto_consulta = "SELECT sum(cantidad) as total FROM view_respuestas_negativas;";
		
		$resultado = $this->db->query($texto_consulta); 

	    if($resultado->num_rows()>0){
			$res = $resultado->result();
			$total =$res[0]->total;
		}else{			
			$total =0;
		} 
		return $total;
	}
	public function obt_productos()
	{
		$texto_consulta = "SELECT DISTINCT id_producto, nombre FROM view_clientes_por_productos;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function obt_repuestos()
	{
		$texto_consulta = "SELECT DISTINCT id_producto, nombre FROM view_clientes_por_repuesto;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function obt_productos_clientes($anno)
	{
		$texto_consulta = "SELECT `id_producto`,`anno`, `mes`, `cant_mensual` FROM view_reporte_productos WHERE anno = $anno order by `id_producto`,  `anno`, `mes`;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function obt_productos_vendidos($anno)
	{
		$texto_consulta = "SELECT `id_producto`,`anno`, `mes`, `cant_mensual` FROM view_productos_vendidos WHERE anno = $anno order by `id_producto`,  `anno`, `mes`;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function obt_repuestos_vendidos($anno)
	{
		$texto_consulta = "SELECT `id_producto`,`anno`, `mes`, `cant_mensual` FROM view_repuestos_vendidos WHERE anno = $anno order by `id_producto`,  `anno`, `mes`;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function total_clientes() 
	{ 
        $texto_consulta = "SELECT count(id_cliente) as total FROM clientes where id_cliente IN (SELECT id_cliente FROM pedidos);";
		
		$resultado = $this->db->query($texto_consulta); 

	    if($resultado->num_rows()>0){
			$res = $resultado->result();
			$total =$res[0]->total;
		}else{			
			$total =0;
		} 
		return $total;
	}
	public function total_bd() 
	{ 
        $texto_consulta = "SELECT count(id_cliente) as total FROM clientes ;";
		
		$resultado = $this->db->query($texto_consulta); 

	    if($resultado->num_rows()>0){
			$res = $resultado->result();
			$total =$res[0]->total;
		}else{			
			$total =0;
		} 
		return $total;
	}
	public function obt_reposiciones()
	{
		$texto_consulta = "SELECT `id_producto`, sum(`cant_mensual`) as cantidad FROM view_reporte_productos WHERE anno > 2015 and (anno = year(curdate()) and mes <= month(curdate())) group by `id_producto` order by `id_producto`;";
		
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	 public function obt_ventas_despachos($anno, $mes, $dia)
	{
		if($dia == 0){
			$texto_consulta = "SELECT * FROM view_despachador WHERE year(fecha_solicitud) = $anno and month(fecha_solicitud) = $mes;";
		}else{
			$texto_consulta = "SELECT * FROM view_despachador WHERE year(fecha_solicitud) = $anno and month(fecha_solicitud) = $mes and day(fecha_solicitud) = $dia;";
		}
				
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function obt_promociones()
	{
		$texto_consulta = "SELECT * FROM view_promociones WHERE fecha_inicio <= FROM_UNIXTIME(UNIX_TIMESTAMP(), '%Y-%m-%d %H.%i.%s') and fecha_fin >= FROM_UNIXTIME(UNIX_TIMESTAMP(), '%Y-%m-%d %H.%i.%s') order by nombre;";
						
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function obt_promociones_rev()
	{
		$texto_consulta = "SELECT * FROM view_promociones_rev WHERE fecha_inicio <= FROM_UNIXTIME(UNIX_TIMESTAMP(), '%Y-%m-%d %H.%i.%s') and fecha_fin >= FROM_UNIXTIME(UNIX_TIMESTAMP(), '%Y-%m-%d %H.%i.%s') order by nombre;";
						
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function obt_productos_promociones()
	{
		$texto_consulta = "SELECT * FROM view_productos_promocion WHERE fecha_inicio <= FROM_UNIXTIME(UNIX_TIMESTAMP(), '%Y-%m-%d %H.%i.%s') and fecha_fin >= FROM_UNIXTIME(UNIX_TIMESTAMP(), '%Y-%m-%d %H.%i.%s') order by id;";
						
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function obt_productos_promociones_rev()
	{
		$texto_consulta = "SELECT * FROM view_productos_promocion_rev WHERE fecha_inicio <= FROM_UNIXTIME(UNIX_TIMESTAMP(), '%Y-%m-%d %H.%i.%s') and fecha_fin >= FROM_UNIXTIME(UNIX_TIMESTAMP(), '%Y-%m-%d %H.%i.%s') order by id;";
						
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function obtener_llamadas($usuario,$anno, $mes)
	{
		$texto_consulta = "SELECT * FROM view_objetivos_llamadas1 WHERE anno = $anno and mes = $mes and id_usuario=$usuario order by anno,mes,dia;";
						
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function obtener_vt_cantidad($usuario,$anno)
	{
		$texto_consulta = "SELECT `id_usuario`, anno,mes, sum(`pedidos`) as pedidos, sum(`cantidad`) as cantidad FROM `view_pedidos_vt` WHERE anno = $anno and id_usuario=$usuario group by  id_usuario, anno,mes ;";
						
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function obtener_vt_cantidad_diaria($usuario,$anno,$mes)
	{
		$texto_consulta = "SELECT `id_usuario`, anno,mes,dia, sum(`pedidos`) as pedidos, sum(`cantidad`) as cantidad FROM `view_pedidos_vt` WHERE anno = $anno and mes = $mes and id_usuario=$usuario group by  id_usuario, anno,mes,dia ;";
						
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function obtener_vt_pesos($usuario,$anno)
	{
		$texto_consulta = "SELECT `id_usuario`, anno,mes, sum(`pedidos`) as pedidos, sum(`importe`) as importe FROM `view_pedidos_vt` WHERE anno = $anno and id_usuario=$usuario group by  id_usuario, anno,mes ;";
						
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function obtener_llamadas_ejecucion($usuario,$anno)
	{
		$texto_consulta = "SELECT `id_usuario`, `first_name`, `last_name`, `anno`, `mes`,`id_canal`,sum( `ingresos`) as ingresos, `objetivo` FROM `view_objetivos_llamadas1` WHERE anno = $anno and id_usuario=$usuario group by  id_usuario,id_canal, anno,mes ;";
						
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function obtener_obj_misiones_ejecucion($usuario,$anno)
	{
		$texto_consulta = "SELECT `id_usuario`, `first_name`, `last_name`, `anno`, `mes`,`id_canal`,sum( `ingresos`) as ingresos, `objetivo` FROM `view_obj_mision_u1` WHERE anno = $anno and id_usuario=$usuario group by  id_usuario,id_canal, anno,mes ;";
						
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function obtener_llamadas_mision($usuario,$anno)
	{
		$texto_consulta = "SELECT `id_usuario`, `first_name`, `last_name`, `anno`, `mes`,count( `id_usuario`) as ingresos FROM `view_llamadas_mision` WHERE anno = $anno and id_usuario=$usuario group by  id_usuario, anno,mes ;";
						
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function obtener_obj_misiones_ejecucion_mes($usuario,$anno)
	{
		$mes = Date('m');
		$texto_consulta = "SELECT `id_usuario`, `first_name`, `last_name`, `anno`, `mes`,`id_canal`,sum( `ingresos`) as ingresos, `objetivo` FROM `view_obj_mision_u1` WHERE anno = $anno and mes = $mes and id_usuario=$usuario group by  id_usuario,id_canal, anno,mes ;";
						
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		if($resultado->num_rows()>0){
			$res = $resultado->result();
			$obje =$res[0]->objetivo;
			$real =$res[0]->ingresos;
		}else{			
			$obje =0;
			$real =0;
		}
		$texto_consulta = "SELECT count(`id_usuario`) as ingresos FROM `view_llamadas_mision` WHERE anno = $anno and mes = $mes and id_usuario=$usuario group by  id_usuario, anno,mes ;";
						
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		$real1=0;
		if($resultado->num_rows()>0){
			$res = $resultado->result();
			
			$real1 =$res[0]->ingresos;
		}		
		
		$real = $real +$real1;
		
		return array('obj_puri' => $obje, 'real_puri'=> $real);
	}
	public function obtener_obj_misiones_ejecucion_usuario($usuario)
	{		
		$texto_consulta = "SELECT `id_usuario`, `first_name`, `last_name`, `anno`, `mes`,`id_canal`,sum( `ingresos`) as ingresos, `objetivo` FROM `view_obj_mision_u1` WHERE id_usuario=$usuario group by  id_usuario,id_canal, anno,mes ;";
						
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		
		return $resultado;
	}
	public function obtener_obj_misiones_diarias($usuario,$anno,$mes)
	{
		$texto_consulta = "SELECT `id_usuario`, `first_name`, `last_name`, `anno`, `mes`,`id_canal`,sum( `ingresos`) as ingresos, `objetivo` FROM `view_obj_mision_u1` WHERE anno = $anno and id_usuario=$usuario and mes=$mes group by  id_usuario,id_canal, anno,mes ;";
						
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function obtener_misiones_diaria($usuario,$anno,$mes)
	{
		$texto_consulta = "SELECT `id_usuario`, `first_name`, `last_name`, `anno`, `mes`, `dia`,sum( `ingresos`) as ingresos FROM `view_misiones_diaria` WHERE anno = $anno and mes =$mes and id_usuario=$usuario group by  id_usuario, anno,mes,dia ;";
						
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function obtener_llamadas_diaria($usuario,$anno,$mes)
	{
		$texto_consulta = "SELECT `id_usuario`, `first_name`, `last_name`, `anno`, `mes`, `dia`,count( `id_usuario`) as ingresos FROM `view_llamadas_mision` WHERE anno = $anno and mes =$mes and id_usuario=$usuario group by  id_usuario, anno,mes,dia ;";
						
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	
	public function obtener_misiones_diaria_tv($usuario,$anno,$mes)
	{
		$texto_consulta = "SELECT `id_usuario`, `first_name`, `last_name`, `anno`, `mes`, `dia`,sum( `ingresos`) as ingresos FROM `view_misiones_diaria` WHERE anno = $anno and mes =$mes and id_usuario=$usuario and exitosa = 1 group by  id_usuario, anno,mes,dia ;";
						
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function obtener_obj_generales_ejecucion($usuario,$anno)
	{
		$texto_consulta = "SELECT `id_usuario`, `first_name`, `last_name`, `anno`, `mes`,`id_canal`,sum( `ingresos`) as ingresos, `objetivo` FROM `view_obj_ventas_generales1` WHERE anno = $anno and id_usuario=$usuario group by  id_usuario,id_canal, anno,mes ;";
						
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function obtener_obj_generales_ejecucion_xmes($usuario,$anno, $mes)
	{
		$texto_consulta = "SELECT `id_usuario`, `first_name`, `last_name`, `anno`, `mes`,`id_canal`,sum( `ingresos`) as ingresos, `objetivo` FROM `view_obj_ventas_generales1` WHERE anno = $anno and mes=$mes and id_usuario=$usuario group by  id_usuario,id_canal, anno,mes ;";
						
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function obtener_obj_generales_ejecucion_mes($usuario,$anno)
	{	
		$mes = Date('m');
		$texto_consulta = "SELECT `id_usuario`, `first_name`, `last_name`, `anno`, `mes`,`id_canal`,sum( `ingresos`) as ingresos, `objetivo` FROM `view_obj_ventas_generales1` WHERE anno = $anno and mes = $mes and id_usuario=$usuario group by  id_usuario,id_canal, anno,mes ;";
						
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		if($resultado->num_rows()>0){
			$res = $resultado->result();
			$obje =$res[0]->objetivo;
			$real =$res[0]->ingresos;
		}else{
			
			$obje =0;
			$real =0;
		}
		
		return array('obj_puri' => $obje, 'real_puri'=> $real);
	}
	public function obtener_obj_generales_ejecucion_usuario($usuario)
	{	
		$texto_consulta = "SELECT `id_usuario`, `first_name`, `last_name`, `anno`, `mes`,`id_canal`,sum( `ingresos`) as ingresos, `objetivo` FROM `view_obj_ventas_generales1` WHERE id_usuario=$usuario group by  id_usuario,id_canal, anno,mes ;";
						
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		return $resultado;
	}
	public function obtener_obj_purificadores_ejecucion($usuario,$anno)
	{
		$texto_consulta = "SELECT `id_usuario`, `first_name`, `last_name`, `anno`, `mes`,`id_canal`,sum( `ingresos`) as ingresos, `objetivo` FROM `view_obj_purificadores1` WHERE anno = $anno and id_usuario=$usuario group by  id_usuario,id_canal, anno,mes ;";
						
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function obtener_obj_purificadores_ejecucion_mes($usuario,$anno)
	{	
		$mes = Date('m');
		$texto_consulta = "SELECT `id_usuario`, `first_name`, `last_name`, `anno`, `mes`,`id_canal`,sum( `ingresos`) as ingresos, `objetivo` FROM `view_obj_purificadores1` WHERE anno = $anno and mes = $mes and id_usuario=$usuario group by  id_usuario,id_canal, anno,mes ;";
						
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		if($resultado->num_rows()>0){
			$res = $resultado->result();
			$obje =$res[0]->objetivo;
			$real =$res[0]->ingresos;
		}else{			
			$obje =0;
			$real =0;
		}	
		
		return array('obj_puri' => $obje, 'real_puri'=> $real);
	}
	public function obtener_obj_purificadores_ejecucion_usuario($usuario)
	{	
		
		$texto_consulta = "SELECT `id_usuario`, `first_name`, `last_name`, `anno`, `mes`,`id_canal`,sum( `ingresos`) as ingresos, `objetivo` FROM `view_obj_purificadores1` WHERE id_usuario=$usuario group by  id_usuario,id_canal, anno,mes ;";
						
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		return $resultado;
	}
	public function obtener_obj_mision_pesos_ejecucion($usuario,$anno)
	{
		$texto_consulta = "SELECT `id_usuario`, `first_name`, `last_name`, `anno`, `mes`,`id_canal`,sum( `ingresos`) as ingresos, `objetivo` FROM `view_obj_mision_p1` WHERE anno = $anno and id_usuario=$usuario group by  id_usuario,id_canal, anno,mes ;";
						
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function obtener_obj_mision_pesos_ejecucion_mes($usuario,$anno)
	{
		$mes = Date('m');
		$texto_consulta = "SELECT `id_usuario`, `first_name`, `last_name`, `anno`, `mes`,`id_canal`,sum( `ingresos`) as ingresos, `objetivo` FROM `view_obj_mision_p1` WHERE anno = $anno and mes = $mes and id_usuario=$usuario group by  id_usuario,id_canal, anno,mes ;";
						
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		if($resultado->num_rows()>0){
			$res = $resultado->result();
			$obje =$res[0]->objetivo;
			$real =$res[0]->ingresos;
		}else{			
			$obje =0;
			$real =0;
		}
		return array('obj_puri' => $obje, 'real_puri'=> $real);
	}
	public function obtener_obj_mision_pesos_ejecucion_usuario($usuario)
	{
		$texto_consulta = "SELECT `id_usuario`, `first_name`, `last_name`, `anno`, `mes`,`id_canal`,sum( `ingresos`) as ingresos, `objetivo` FROM `view_obj_mision_p1` WHERE id_usuario=$usuario group by  id_usuario,id_canal, anno,mes ;";
						
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		return $resultado;
	}
	public function obtener_obj_repuesto_ejecucion($usuario,$anno)
	{
		$texto_consulta = "SELECT `id_usuario`, `first_name`, `last_name`, `anno`, `mes`,`id_canal`,sum( `ingresos`) as ingresos, `objetivo` FROM `view_obj_repuestos1` WHERE anno = $anno and id_usuario=$usuario group by  id_usuario,id_canal, anno,mes ;";
						
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function obtener_obj_repuesto_ejecucion_mes($usuario,$anno)
	{
		$mes = Date('m');
		$texto_consulta = "SELECT `id_usuario`, `first_name`, `last_name`, `anno`, `mes`,`id_canal`,sum( `ingresos`) as ingresos, `objetivo` FROM `view_obj_repuestos1` WHERE anno = $anno and mes = $mes and id_usuario=$usuario group by  id_usuario,id_canal, anno,mes ;";
						
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		if($resultado->num_rows()>0){
			$res = $resultado->result();
			$obje =$res[0]->objetivo;
			$real =$res[0]->ingresos;
		}else{			
			$obje =0;
			$real =0;
		}
		return array('obj_puri' => $obje, 'real_puri'=> $real);
	}
	public function obtener_obj_repuesto_ejecucion_usuario($usuario)
	{		
		$texto_consulta = "SELECT `id_usuario`, `first_name`, `last_name`, `anno`, `mes`,`id_canal`,sum( `ingresos`) as ingresos, `objetivo` FROM `view_obj_repuestos1` WHERE id_usuario=$usuario group by  id_usuario,id_canal, anno,mes ;";
						
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		return $resultado;
	}

	public function obtener_conversion($usuario,$anno, $mes)
	{
		$texto_consulta = "SELECT * FROM view_objetivos_conversion1 WHERE anno = $anno and mes = $mes and id_usuario=$usuario order by anno,mes,dia;";
						
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function obtener_ventas_mlms($anno)
	{
		$texto_consulta = "SELECT * FROM view_rep_venta_canales WHERE anno = $anno ;";
						
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function obtener_transacciones($anno)
	{
		$texto_consulta = "SELECT * FROM view_transacciones WHERE anno = $anno ;";
						
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function obtener_cartera_provincia()
	{
		$texto_consulta = "SELECT * FROM view_rep_cartera_provincia where id_pais=1 ;";
						
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function obtener_cartera_buenos_aires()
	{
		$texto_consulta = "SELECT * FROM view_rep_cartera_municipio where id_pais=1 and id_provincia=1 order by cantidad desc limit 0,24;";
						
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function obtener_detalles_consultores($anno)
	{
		$texto_consulta = "SELECT * FROM view_rep_detalle_venta WHERE anno = $anno AND active =1 and id_usuario<>64 ;";
						
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function obtener_consultores()
	{
		$texto_consulta = "SELECT id_usuario,usuario FROM view_rep_detalle_venta where active =1 AND id_usuario not in ( select id_usuario from revendedores) and id_usuario<>64  group by id_usuario  ;";
						
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function obtener_consultores_revendedores()
	{
		$texto_consulta = "SELECT id_usuario,usuario FROM view_rep_detalle_venta where id_usuario not in ( select id_usuario from revendedores) group by id_usuario  ;";
						
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function obtener_consultores_res()
	{
		$anno = date('Y');
		$texto_consulta = "SELECT  id_usuario, usuario,foto, sum(cantidad) as cantidad, sum(monetario) as monetario FROM view_rep_detalle_venta where active =1 AND anno= $anno  and id_usuario not in ( select id_usuario from revendedores) and id_usuario<>64 group by id_usuario, anno  ;";
						
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function obtener_consultores_rev($anno, $mes)
	{
		
		$texto_consulta = "SELECT  id_usuario, usuario,foto, sum(cantidad) as cantidad, sum(monetario) as monetario FROM view_rep_detalle_venta where anno= $anno and mes = $mes and id_usuario in ( select id_usuario from revendedores) group by id_usuario, anno  ;";
						
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function obtener_reclamos()
	{		
		$texto_consulta = "SELECT  count(id) as total FROM reclamos ;";
						
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function obtener_reclamos_rodo()
	{		
		$user = $this->ion_auth->user()->row();
		$id_usuario = $user->id;
		$texto_consulta = "SELECT  count(id) as total FROM reclamos WHERE id_usuario = $id_usuario;";
						
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function obtener_reclamos_usuarios($anno, $id_usuario)
	{		
		//$user = $this->ion_auth->user()->row();
		//$id_usuario = $user->id;
		$texto_consulta = "SELECT id FROM `reclamos` WHERE id_usuario = $id_usuario and year(`fecha`)= $anno and cerrado =1 ;";
						
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;		
		$cerrado = $resultado->num_rows();
		$texto_consulta = "SELECT id FROM `reclamos` WHERE id_usuario = $id_usuario and year(`fecha`)= $anno and cerrado =0 ;";
						
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;		
		$abierto = $resultado->num_rows();

		return array("abierto" => $abierto, "cerrado" => $cerrado);
	}
	public function obtener_ventas_am($anno)
	{
		$user = $this->ion_auth->user()->row();
		$id_usuario = $user->id;
		$texto_consulta = "SELECT * FROM view_reporte_rev_am WHERE id_usuario= $id_usuario and anno = $anno and (id_canal = 4 or id_canal = 6) ;";
						
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function obtener_ventas_am_can($anno)
	{
		$user = $this->ion_auth->user()->row();
		$id_usuario = $user->id;
		$texto_consulta = "SELECT sum(cantidad) as cantidad FROM view_reporte_rev_am WHERE id_usuario= $id_usuario and anno = $anno and (id_canal = 4 or id_canal = 6) group by id_usuario,anno;";
						
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		$result = $resultado->result();
		
		if(count($result) ==0){
			$retorno=0;
		}else
			$retorno=$result[0]->cantidad;

		return $retorno;
	}
	public function obtener_ventas_am_mon($anno)
	{
		$user = $this->ion_auth->user()->row();
		$id_usuario = $user->id;
		$texto_consulta = "SELECT sum(monetario) as monetario FROM view_reporte_rev_am WHERE id_usuario= $id_usuario and anno = $anno and (id_canal = 4 or id_canal = 6) group by id_usuario,anno;";
						
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
			$result = $resultado->result();
			
			if(count($result) ==0){
				$retorno=0;
			}else
				$retorno=$result[0]->monetario;

			return $retorno;
	}
	public function obtener_cartera_provincia_rev()
	{
		$user = $this->ion_auth->user()->row();
		$id_usuario = $user->id;
		$texto_consulta = "SELECT * FROM view_rep_cartera_provincia_rev where id_usuario= $id_usuario  ;";
						
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function obt_datos_ventas($fecha_inicio, $fecha_final)
	{
		
		$texto_consulta = "SELECT * FROM view_jefe_produccion where fecha_solicitud>='$fecha_inicio' and fecha_solicitud<= '$fecha_final'  ;";
						
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function obt_datos_ventas_pto_vta($fecha_inicio, $fecha_final)
	{
		
		$texto_consulta = "SELECT `punto_venta`, `producto`, sum(`cantidad`) as cantidad FROM `view_jefe_produccion` where fecha_solicitud>='$fecha_inicio' and fecha_solicitud<= '$fecha_final' group by  `punto_venta`, `producto`  order by  `punto_venta`, `producto` ;";
						
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function obt_datos_ventas_vendedor($fecha_inicio, $fecha_final)
	{
		
		$texto_consulta = "SELECT `punto_venta`, `vendedor`, sum(`cantidad`) as cantidad FROM `view_jefe_produccion` where fecha_solicitud>='$fecha_inicio' and fecha_solicitud<= '$fecha_final' group by `punto_venta`, `vendedor`     ;";
						
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function obt_datos_gestion_armado($fecha_inicio, $fecha_final)
	{
		
		$texto_consulta = "SELECT `gestion_armado`, count(`id_pedido`) as cantidad FROM `view_jefe_produccion` where fecha_solicitud>='$fecha_inicio' and fecha_solicitud<= '$fecha_final' group by  `gestion_armado`  ;";
						
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function obt_datos_gestion_despacho($fecha_inicio, $fecha_final)
	{
		
		$texto_consulta = "SELECT `gestion_despacho`, count(`id_pedido`) as cantidad FROM `view_jefe_produccion` WHERE  fecha_solicitud>='$fecha_inicio' and fecha_solicitud<= '$fecha_final' group by  `gestion_despacho`;";
						
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function obt_datos_canal_pedidos($fecha_inicio, $fecha_final)
	{
		
		$texto_consulta = "SELECT `canal`, count(`id_pedido`) as cantidad FROM `view_jefe_produccion` WHERE  fecha_solicitud>='$fecha_inicio' and fecha_solicitud<= '$fecha_final' group by  `canal`;";
						
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function obt_datos_canal_productos($fecha_inicio, $fecha_final)
	{
		
		$texto_consulta = "SELECT `producto`,`canal`, sum(`cantidad`) as cantidad FROM `view_jefe_produccion` WHERE  fecha_solicitud>='$fecha_inicio' and fecha_solicitud<= '$fecha_final' group by  `producto`,`canal`; ";
						
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function obt_datos_productos($fecha_inicio, $fecha_final)
	{
		
		$texto_consulta = "SELECT `producto`,sum(`cantidad`) as cantidad FROM `view_jefe_produccion` WHERE  fecha_solicitud>='$fecha_inicio' and fecha_solicitud<= '$fecha_final' group by  `producto` order by producto; ";
						
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function obt_datos_vendedores($fecha_inicio, $fecha_final)
	{
		
		$texto_consulta = "SELECT `vendedor` FROM `view_jefe_produccion` WHERE  fecha_solicitud>='$fecha_inicio' and fecha_solicitud<= '$fecha_final' group by  `vendedor`; ";
						
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	
	public function obt_datos_ventas_exc($fecha_inicio, $fecha_final)
	{		
		$fields = $this->db->field_data('view_jefe_produccion');
		$this->db->where('fecha_solicitud>=', $fecha_inicio);
		$this->db->where('fecha_solicitud<=', $fecha_final);
				
		$query = $this->db->select('*')->get('view_jefe_produccion');
		return array("fields" => $fields, "query" => $query);
	}
	public function obt_ultimo_dia_mes_actual()
	{
		if(date("m") == '01'){
			$ultimo=31;
		}
		if(date("m") == '02'){
			$ultimo=28;
		}
		if(date("m") == '03'){
			$ultimo=31;
		}
		if(date("m") == '04'){
			$ultimo=30;
		}
		if(date("m") == '05'){
			$ultimo=31;
		}
		if(date("m") == '06'){
			$ultimo=30;
		}
		if(date("m") == '07'){
			$ultimo=31;
		}
		if(date("m") == '08'){
			$ultimo=31;
		}
		if(date("m") == '09'){
			$ultimo=30;
		}
		if(date("m") == '10'){
			$ultimo=31;
		}
		if(date("m") == '11'){
			$ultimo=30;
		}
		if(date("m") == '12'){
			$ultimo=31;
		}
		
		
		
		$fin = date('Y-m-d H:i:s',mktime(0, 0, 0, date("m"),$ultimo, date("Y")));
		return $fin;
	}
	public function obtener_evaluacion_desempeno($usuario, $anno)
	{
		$texto_consulta = "SELECT * FROM `evaluaciones` WHERE anno = $anno and id_subordinado=$usuario group by  id_subordinado, anno,mes ;";
						
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function obt_clasifica_desafio($id_usuario)
	{
		$resul = 0;
		$fecha_hoy = date('Y-m-d');
		$texto_consulta = "SELECT `id`, `fecha_inicio`, `fecha_fin`, `cantidad_promedio`, `porciento_aumento`, `porciento_descuento` FROM `desafio_mes` WHERE fecha_inicio<='$fecha_hoy' and fecha_fin>='$fecha_hoy' ;";
		$resultado1 =false;				
		$resultado = $this->db->query($texto_consulta);
		if($resultado->num_rows()>0){
			// recorrer las promociones desafios activas
			foreach ($resultado->result() as $key) {
				# code...
				$texto_consulta1 = "SELECT 
				`view_promedio_venta`.`id_usuario`,
				`view_promedio_venta`.`id_producto`,
				`view_promedio_venta`.`producto`,
				`view_promedio_venta`.`cantidad`
				FROM
				`view_promedio_venta` WHERE `view_promedio_venta`.`id_usuario`= $id_usuario ;";
						
				$resultado1 = $this->db->query($texto_consulta1);
				if($resultado1->num_rows()>0){
					
					$resul = 1;
				}else{
					$resul = 0;
					
				}
			}
		}
		return array("desafios" => $resultado, "ventas" => $resultado1, "resul" => $resul);
	}
	public function obt_usuarios_rev()
	{
		$grupo =0;
		$group = array('Revendedores'); 
		if ($this->ion_auth->in_group($group)){
			$grupo =6;
		}else{
			$group = array('RevendedoresInt'); 
			if ($this->ion_auth->in_group($group)){
				$grupo =12;
			}
		}
		$texto_consulta1 = "SELECT 	`usuarios`.`id` AS `id_usuario`,CONCAT(`usuarios`.`first_name`, ' ', `usuarios`.`last_name`) AS `nombre`,	`usuarios_grupos`.`group_id`,
		`grupos`.`name`	  FROM
		`usuarios`	INNER JOIN `usuarios_grupos` ON (`usuarios`.`id` = `usuarios_grupos`.`user_id`)
		INNER JOIN `grupos` ON (`usuarios_grupos`.`group_id` = `grupos`.`id`)
 		 where  (`usuarios_grupos`.`group_id` = $grupo);  ";
						
		$resultado = $this->db->query($texto_consulta1);
		if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	public function frecuencia()
	{
		$texto_consulta1 = "SELECT * FROM `view_venta_directa_revendedores` WHERE 1 order by id_usuario, anno, mes;";
						
		$resultado = $this->db->query($texto_consulta1);
		if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
}