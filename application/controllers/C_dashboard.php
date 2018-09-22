<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_dashboard extends CI_Controller {

	// Atributos
	
	
	
	// Comportamiento
	/********************************************************************************************************************/
	public function __construct()
    {
		parent::__construct();
		$this->load->library('session');
		$this->load->helper('url','mysql_to_excel_helper');
		if (!$this->ion_auth->logged_in())
		{
			redirect('entrada');
		}
		else
		{
			$this->load->model( 'M_dashboard', '', TRUE );
			$this->load->model( 'M_configuracion', '', TRUE );
			$this->load->model( 'M_operaciones', '', TRUE );
			$this->load->model('upload_model');
		}
    }
	/********************************************************************************************************************/
	// Dashboard
    public function index()
	{
		$this->chequear_fin_de_mision();
		$group = array('GerenteProduccion');		                
		if ($this->ion_auth->in_group($group)) { 
			$this->dashboard_principal_jefe_produccion();
		}else{
			$group = array('Despachadores','ResponsableArmado');
			if ($this->ion_auth->in_group($group)) {
				$this->dashboard_principal_jefe_produccion();
				//$this->dashboard_armador_desp();
			}else{
				$group = array('ConsultorRV','ConsultorRVInt');
				if($this->ion_auth->in_group($group)){
					$this->dashboard_revendedores();
				}else{
					$group = array('Revendedores','RevendedoresInt');
					if($this->ion_auth->in_group($group)){
						$this->dashboard_jefe_revendedores();
					}else{
						$group = array('Administradores','Consultores','JefeArea');
						
						if($this->ion_auth->in_group($group)){
							$this->dashboard_consultores();
							
						}else		
							
							$this->principal();
					}				
						
				}
			}			
		}

	}
	// Chequear fin de mision
    public function chequear_fin_de_mision()
	{   
		$actualizar = $this->M_configuracion->actualizar_clientes_en_mision_activas();
		$misiones = $this->M_configuracion->obt_mision_activas();
		 
        foreach($misiones->result() as $mision){
			
				if($mision->fecha_fin < date('Y-m-d H:i:s')){					
					$resultado = $this->M_configuracion->quitar_cliente_en_mision($mision->id_cliente);
				}else{
					$resultado = $this->M_configuracion->cliente_en_mision($mision->id_cliente);
				}
		}
	}

	// Dashboard
    public function procedure()
	{
		
		$datos['valor'] = $this->M_configuracion->procedure_modelo();
		echo count($datos['valor']);

	}
	/********************************************************************************************************************/
	// Dashboard
	public function dashboard_armador_desp()
	{
		$fecha = new DateTime();		
		$anno  				= $fecha->format('Y');
		$datos['anno']  	= $anno;
		$mes  				= $fecha->format('m');
		$datos['mes']  		= $mes;
		$user = $this->ion_auth->user()->row();
		$usuario = $user->id;
		$pedidos = $this->M_operaciones->obtener_pedidos_armador_desp($usuario, $anno, $mes);	
		$datos['pedidos'] = $pedidos;
		$despachos = $this->M_operaciones->obtener_despachos();	
        $datos['despachos'] = $despachos;		
		$bandera=0;
		
		$consultores = array();
		$id = array();
		$id_pedido = array();
		$no_factura = array();
		$producto = array();
		$importe = array();
		$cobranza = array();
		$OCA = array();
		$armado = array();
		$despachado = array();
		$recargo = array();
		$iva = array();
		$fecha = array();
		$dni = array();
		$local = array();
		$nombre_apellidos = array();
		$notas = array();
		$usuario = array();
		$fecha_envio = array();
										
		$id_entrega = array();
		// echo '<option value="' . $mun->id_tipo_empresa . '">' . $mun->nombre . '</option>';
		$contador= 0;
		foreach ($pedidos->result() as $pr){			
			if($bandera==0){
				$contador= 0;				
				$anterior=$pr->no_factura;
				$actual=$pr->no_factura;
				$importe[$contador] =0;
			}else{
				$actual=$pr->no_factura;
			}
			if($anterior == $actual){
				if($contador== 0 && $bandera==0){//es la primera vez qe se recorre
					$bandera=1;
					$id_consultor = $pr->id_usuario;
					$consultor = $this->M_operaciones->obtener_consultor($id_consultor);
					$consultores[$contador] = $consultor->first_name;
					$id[$contador] = $pr->id;
					$id_pedido[$contador] = $pr->id_pedido;
					$id_entrega[$contador] = $pr->id_entrega;
					$no_factura[$contador] = $pr->no_factura;
					$producto[$contador] = $pr->producto.' '.$pr->color.'</br>';
					$importe[$contador] = $pr->importe ;
					$cobranza[$contador] = '*';
					$OCA[$contador] = $pr->OCA;
					$armado[$contador] = $pr->armado;
					$despachado[$contador] = $pr->despachado;
					$recargo[$contador] = $pr->recargo;
					$iva[$contador] = $pr->iva;
					$fecha[$contador] = $pr->fecha_solicitud;
					$dni[$contador] = $pr->dni;
					$local[$contador] = $pr->local;
					$notas[$contador] = $pr->notas;
					$usuario[$contador] = $pr->usuario;
					$fecha_envio[$contador] = $pr->fecha_envio;
					$nombre_apellidos[$contador] = $pr->nombre.' '.$pr->apellidos;					
				}else{//es el mismo pedido
					$producto[$contador] = $producto[$contador]. $pr->producto.' '.$pr->color.'</br>';
					$importe[$contador] = $importe[$contador] + $pr->importe;
				}
			}else{//es otro pedido
				$contador = $contador + 1;
				$id_consultor = $pr->id_usuario;
				$consultor = $this->M_operaciones->obtener_consultor($id_consultor);
				$consultores[$contador] = $consultor->first_name;
				$id[$contador] = $pr->id;
				$id_pedido[$contador] = $pr->id_pedido;
				$id_entrega[$contador] = $pr->id_entrega;
				$no_factura[$contador] = $pr->no_factura;
				$producto[$contador] = $pr->producto.' '.$pr->color.'</br>';
				$importe[$contador] = $pr->importe;
				$cobranza[$contador] = '*';
				$OCA[$contador] = $pr->OCA;
				$armado[$contador] = $pr->armado;
				$despachado[$contador] = $pr->despachado;
				$recargo[$contador] = $pr->recargo;
				$iva[$contador] = $pr->iva;
				$fecha[$contador] = $pr->fecha_solicitud;
				$dni[$contador] = $pr->dni;
				$local[$contador] = $pr->local;
				$notas[$contador] = $pr->notas;
				$usuario[$contador] = $pr->usuario;
				$fecha_envio[$contador] = $pr->fecha_envio;
				
				
				$nombre_apellidos[$contador] = $pr->nombre.' '.$pr->apellidos;
				//Sumo el recargo
				$importe[$contador-1] = $importe[$contador-1]+$recargo[$contador-1]+$iva[$contador-1]; 
			}
			$anterior=$pr->no_factura;
		}
		if($bandera == 1 )							
			$importe[$contador] = $importe[$contador]+$recargo[$contador]+$iva[$contador]; 						
		
		$datos['consultores'] 		=$consultores;
		$datos['id'] 				=$id;
		$datos['id_pedido'] 		=$id_pedido;
		$datos['id_entrega'] 		=$id_entrega;
		$datos['no_factura'] 		=$no_factura;
		$datos['producto'] 			=$producto;
		$datos['importe'] 			=$importe;
		$datos['cobranza'] 			=$cobranza;
		$datos['OCA'] 				=$OCA;
		$datos['armado'] 			=$armado;
		$datos['despachado'] 		=$despachado;
		$datos['dni'] 				=$dni;
		$datos['local'] 				=$local;
		$datos['fecha'] 				=$fecha;
		$datos['notas'] 				=$notas;
		$datos['usuario'] 				=$usuario;
		$datos['fecha_envio'] 				=$fecha_envio;
		$datos['nombre_apellidos'] 	=$nombre_apellidos;

		$annos = $this->M_configuracion->obt_annos();
		$meses = $this->M_configuracion->obt_meses();
		
		$datos['annos']  	= $annos;
		$datos['meses']  	= $meses;
		$datos['filtro1']  	= '1';
		$datos['filtro2']  	= '0';
		$datos['filtro3']  	= '0';
		$datos['filtro4']  	= '0';
		$datos['locales']  	= $this->M_configuracion->obt_locales();
		
		$this->load->view('lte_header', $datos);
		$this->load->view('v_listado_pedidos_gestion_ar_desp', $datos);
		$this->load->view('lte_footer', $datos);	
	}
	public function dashboard_armador_desp_filtro()
	{
		$anno = $this->input->post('anno'); 
		$mes = $this->input->post('mes');
		$filtro1 = $this->input->post('filtro1');
		$filtro2 = $this->input->post('filtro2');
		$filtro3 = $this->input->post('filtro3');
		if($filtro1) $filtro1='1'; else $filtro1='0';
		if($filtro2) $filtro2='1'; else $filtro2='0';
		if($filtro3) $filtro3='1'; else $filtro3='0';
		$datos['anno']  	= $anno;		
		$datos['mes']  		= $mes;
		$datos['filtro1']  	= $filtro1;
		$datos['filtro2']  	= $filtro2;
		$datos['filtro3']  	= $filtro3;
		$datos['filtro4']  	= '0';
		$fLocal = $this->input->post('sel_local');
		$fDespacho = $this->input->post('sel_despacho');
		$datos['fLocal']  	= $fLocal;
		$datos['fDespacho'] = $fDespacho;
		/*$fecha = new DateTime();		
		$anno  				= $fecha->format('Y');
		$datos['anno']  	= $anno;
		$mes  				= $fecha->format('m');
		$datos['mes']  		= $mes;*/
		$user = $this->ion_auth->user()->row();
		$usuario = $user->id;
		$pedidos = $this->M_operaciones->obtener_pedidos_armador_desp_sf();	
		
        $datos['pedidos'] = $pedidos;		
			
		$datos['locales']  	= $this->M_configuracion->obt_locales();	
		$despachos = $this->M_operaciones->obtener_despachos();	
        $datos['despachos'] = $despachos;
		$bandera=0;
		
		$consultores = array();
		$id = array();
		$id_pedido = array();
		$no_factura = array();
		$producto = array();
		$importe = array();
		$cobranza = array();
		$OCA = array();
		$armado = array();
		$despachado = array();
		$recargo = array();
		$iva = array();
		$fecha = array();
		$dni = array();
		$local = array();
		$id_local = array();
		$notas = array();
		$usuario = array();
		$fecha_envio = array();
		$nombre_apellidos = array();
		$id_entrega = array();
		// echo '<option value="' . $mun->id_tipo_empresa . '">' . $mun->nombre . '</option>';
		$contador= 0;
		foreach ($pedidos->result() as $pr){			
			if($bandera==0){
				$contador= 0;				
				$anterior=$pr->no_factura;
				$actual=$pr->no_factura;
				$importe[$contador] =0;
			}else{
				$actual=$pr->no_factura;
			}
			if($anterior == $actual){
				if($contador== 0 && $bandera==0){//es la primera vez qe se recorre
					$bandera=1;
					$id_consultor = $pr->id_usuario;
					$consultor = $this->M_operaciones->obtener_consultor($id_consultor);
					$consultores[$contador] = $consultor->first_name;
					$id[$contador] = $pr->id;
					$id_pedido[$contador] = $pr->id_pedido;
					$id_entrega[$contador] = $pr->id_entrega;
					$no_factura[$contador] = $pr->no_factura;
					$producto[$contador] = $pr->producto.' '.$pr->color.'</br>';
					$importe[$contador] = $pr->importe ;
					$cobranza[$contador] = '*';
					$OCA[$contador] = $pr->OCA;
					$armado[$contador] = $pr->armado;
					$despachado[$contador] = $pr->despachado;
					$recargo[$contador] = $pr->recargo;
					$iva[$contador] = $pr->iva;
					$fecha[$contador] = $pr->fecha_solicitud;
					$dni[$contador] = $pr->dni;
					$local[$contador] = $pr->local;
					$id_local[$contador] = $pr->id_local;
					$notas[$contador] = $pr->notas;
					$usuario[$contador] = $pr->usuario;
					$fecha_envio[$contador] = $pr->fecha_envio;
					$nombre_apellidos[$contador] = $pr->nombre.' '.$pr->apellidos;					
				}else{//es el mismo pedido
					$producto[$contador] = $producto[$contador]. $pr->producto.' '.$pr->color.'</br>';
					$importe[$contador] = $importe[$contador] + $pr->importe;
				}
			}else{//es otro pedido
				$contador = $contador + 1;
				$id_consultor = $pr->id_usuario;
				$consultor = $this->M_operaciones->obtener_consultor($id_consultor);
				$consultores[$contador] = $consultor->first_name;
				$id[$contador] = $pr->id;
				$id_pedido[$contador] = $pr->id_pedido;
				$id_entrega[$contador] = $pr->id_entrega;
				$no_factura[$contador] = $pr->no_factura;
				$producto[$contador] = $pr->producto.' '.$pr->color.'</br>';
				$importe[$contador] = $pr->importe;
				$cobranza[$contador] = '*';
				$OCA[$contador] = $pr->OCA;
				$armado[$contador] = $pr->armado;
				$despachado[$contador] = $pr->despachado;
				$recargo[$contador] = $pr->recargo;
				$iva[$contador] = $pr->iva;
				$fecha[$contador] = $pr->fecha_solicitud;
				$dni[$contador] = $pr->dni;
				$id_local[$contador] = $pr->id_local;
				$local[$contador] = $pr->local;
				$notas[$contador] = $pr->notas;
				$usuario[$contador] = $pr->usuario;
				$fecha_envio[$contador] = $pr->fecha_envio;
				$nombre_apellidos[$contador] = $pr->nombre.' '.$pr->apellidos;
				//Sumo el recargo
				$importe[$contador-1] = $importe[$contador-1]+$recargo[$contador-1]+$iva[$contador-1]; 
			}
			$anterior=$pr->no_factura;
		}
		if($bandera == 1 )							
			$importe[$contador] = $importe[$contador]+$recargo[$contador]+$iva[$contador]; 				
		//filtro 1 por año y mes
		if($filtro1 == '1' ){
			$consultores1 = array();
			$id1 = array();
			$id_pedido1 = array();
			$no_factura1 = array();
			$producto1 = array();
			$importe1 = array();
			$cobranza1 = array();
			$OCA1 = array();
			$armado1 = array();
			$despachado1 = array();
			$recargo1 = array();
			$iva1 = array();
			$fecha1 = array();
			$dni1 = array();
			$local1 = array();
			$notas1 = array();
			$usuario1 = array();
			$fecha_envio1 = array();
			$nombre_apellidos1 = array();
			$id_entrega1 = array();
			
			$con = 0;
			for ($i=0; $i < count($id); $i++) { 
				if($filtro1 == '1' && substr($fecha[$i],0,4)   == $anno && $mes == substr($fecha[$i],5,2)  
				){	
					$consultores1[$con] = $consultores[$i];
					$id1[$con] 			= $id[$i];
					$id_pedido1[$con] 	= $id_pedido[$i];
					$no_factura1[$con] 	= $no_factura[$i];
					$producto1[$con] 	= $producto[$i];
					$importe1[$con] 	= $importe[$i];
					$cobranza1[$con] 	= $cobranza[$i];
					$OCA1[$con] 		= $OCA[$i];
					$armado1[$con] 		= $armado[$i];
					$despachado1[$con] 	= $despachado[$i];
					$recargo1[$con]		= $recargo[$i];
					$iva1[$con] 		= $iva[$i];
					$fecha1[$con] 		= $fecha[$i];
					$dni1[$con] 		= $dni[$i];
					$local1[$con] 		= $local[$i];
					$notas1[$con] 		= $notas[$i];
					$usuario1[$con] 	= $usuario[$i];
					$fecha_envio1[$con] 	= $fecha_envio[$i];
					$nombre_apellidos1[$con] = $nombre_apellidos[$i];
					$id_entrega1[$con] 	= $id_entrega[$i];

					
					$con ++;					
				}		
			}
			$consultores 	= $consultores1;
			$id 			= $id1;
			$id_pedido 		= $id_pedido1;
			$no_factura 	= $no_factura1;
			$producto 		= $producto1;
			$importe 		= $importe1;
			$cobranza 		= $cobranza1;
			$OCA 			= $OCA1;
			$armado 		= $armado1;
			$despachado 	= $despachado1;
			$recargo	 	= $recargo1;
			$iva 			= $iva1;
			$fecha 			= $fecha1;
			$dni 			= $dni1;
			$local 			= $local1;
			$notas 			= $notas1;
			$usuario 		= $usuario1;
			$fecha_envio 		= $fecha_envio1;
			$nombre_apellidos = $nombre_apellidos1;
			$id_entrega 	= $id_entrega1;
			
		}		
		//filtro 2 por local
		if($filtro2 == '1' ){
			$consultores1 = array();
			$id1 = array();
			$id_pedido1 = array();
			$no_factura1 = array();
			$producto1 = array();
			$importe1 = array();
			$cobranza1 = array();
			$OCA1 = array();
			$armado1 = array();
			$despachado1 = array();
			$recargo1 = array();
			$iva1 = array();
			$fecha1 = array();
			$dni1 = array();
			$local1 = array();
			$notas1 = array();
			$usuario1 = array();
			$fecha_envio1 = array();
			$nombre_apellidos1 = array();
			$id_entrega1 = array();
			
			$con = 0;
			for ($i=0; $i < count($id); $i++) { 
				if($filtro2 == '1' && $id_local[$i]   == $fLocal )  
				{	
					$consultores1[$con] = $consultores[$i];
					$id1[$con] 			= $id[$i];
					$id_pedido1[$con] 	= $id_pedido[$i];
					$no_factura1[$con] 	= $no_factura[$i];
					$producto1[$con] 	= $producto[$i];
					$importe1[$con] 	= $importe[$i];
					$cobranza1[$con] 	= $cobranza[$i];
					$OCA1[$con] 		= $OCA[$i];
					$armado1[$con] 		= $armado[$i];
					$despachado1[$con] 	= $despachado[$i];
					$recargo1[$con]		= $recargo[$i];
					$iva1[$con] 		= $iva[$i];
					$fecha1[$con] 		= $fecha[$i];
					$dni1[$con] 		= $dni[$i];					
					$local1[$con] 		= $local[$i];
					$notas1[$con] 		= $notas[$i];
					$usuario1[$con] 	= $usuario[$i];
					$fecha_envio1[$con] 	= $fecha_envio[$i];
					$nombre_apellidos1[$con] = $nombre_apellidos[$i];
					$id_entrega1[$con] 	= $id_entrega[$i];

					
					$con ++;					
				}		
			}
			$consultores 	= $consultores1;
			$id 			= $id1;
			$id_pedido 		= $id_pedido1;
			$no_factura 	= $no_factura1;
			$producto 		= $producto1;
			$importe 		= $importe1;
			$cobranza 		= $cobranza1;
			$OCA 			= $OCA1;
			$armado 		= $armado1;
			$despachado 	= $despachado1;
			$recargo	 	= $recargo1;
			$iva 			= $iva1;
			$fecha 			= $fecha1;
			$dni 			= $dni1;
			$local 			= $local1;
			$notas 			= $notas1;
			$usuario 		= $usuario1;
			$fecha_envio 		= $fecha_envio1;
			$nombre_apellidos = $nombre_apellidos1;
			$id_entrega 	= $id_entrega1;
			
		}
		//filtro 3 por despacho
		if($filtro3 == '1' ){
			$consultores1 = array();
			$id1 = array();
			$id_pedido1 = array();
			$no_factura1 = array();
			$producto1 = array();
			$importe1 = array();
			$cobranza1 = array();
			$OCA1 = array();
			$armado1 = array();
			$despachado1 = array();
			$recargo1 = array();
			$iva1 = array();
			$fecha1 = array();
			$dni1 = array();
			$local1 = array();
			$notas1 = array();
			$usuario1 = array();
			$fecha_envio1 = array();
			$nombre_apellidos1 = array();
			$id_entrega1 = array();
			
			$con = 0;
			for ($i=0; $i < count($id); $i++) { 
				if($filtro3 == '1' && $id[$i]   == $fDespacho)
				{	
					$consultores1[$con] = $consultores[$i];
					$id1[$con] 			= $id[$i];
					$id_pedido1[$con] 	= $id_pedido[$i];
					$no_factura1[$con] 	= $no_factura[$i];
					$producto1[$con] 	= $producto[$i];
					$importe1[$con] 	= $importe[$i];
					$cobranza1[$con] 	= $cobranza[$i];
					$OCA1[$con] 		= $OCA[$i];
					$armado1[$con] 		= $armado[$i];
					$despachado1[$con] 	= $despachado[$i];
					$recargo1[$con]		= $recargo[$i];
					$iva1[$con] 		= $iva[$i];
					$fecha1[$con] 		= $fecha[$i];
					$dni1[$con] 		= $dni[$i];
					$local1[$con] 		= $local[$i];
					$notas1[$con] 		= $notas[$i];
					$usuario1[$con] 	= $usuario[$i];
					$fecha_envio1[$con] 	= $fecha_envio[$i];
					$nombre_apellidos1[$con] = $nombre_apellidos[$i];
					$id_entrega1[$con] 	= $id_entrega[$i];

					
					$con ++;					
				}		
			}
			$consultores 	= $consultores1;
			$id 			= $id1;
			$id_pedido 		= $id_pedido1;
			$no_factura 	= $no_factura1;
			$producto 		= $producto1;
			$importe 		= $importe1;
			$cobranza 		= $cobranza1;
			$OCA 			= $OCA1;
			$armado 		= $armado1;
			$despachado 	= $despachado1;
			$recargo	 	= $recargo1;
			$iva 			= $iva1;
			$fecha 			= $fecha1;
			$dni 			= $dni1;
			$local 			= $local1;
			$notas 			= $notas1;
			$usuario 		= $usuario1;
			$fecha_envio 		= $fecha_envio1;
			$nombre_apellidos = $nombre_apellidos1;
			$id_entrega 	= $id_entrega1;
			
		}
			

		$datos['consultores'] 		=$consultores;
		$datos['id'] 				=$id;
		$datos['id_pedido'] 		=$id_pedido;
		$datos['id_entrega'] 		=$id_entrega;
		$datos['no_factura'] 		=$no_factura;
		$datos['producto'] 			=$producto;
		$datos['importe'] 			=$importe;
		$datos['cobranza'] 			=$cobranza;
		$datos['OCA'] 				=$OCA;
		$datos['armado'] 			=$armado;
		$datos['despachado'] 		=$despachado;
		$datos['dni'] 				=$dni;
		$datos['local'] 			=$local;
		$datos['fecha'] 			=$fecha;
		$datos['notas'] 			=$notas;
		$datos['usuario'] 			=$usuario;
		$datos['fecha_envio'] 			=$fecha_envio;
		$datos['nombre_apellidos'] 	=$nombre_apellidos;

		$annos = $this->M_configuracion->obt_annos();
		$meses = $this->M_configuracion->obt_meses();
		
		$datos['annos']  	= $annos;
		$datos['meses']  	= $meses;
		
		
		
		$this->load->view('lte_header', $datos);
		$this->load->view('v_listado_pedidos_gestion_ar_desp', $datos);
		$this->load->view('lte_footer', $datos);	
	}
	public function dashboard_armador_desp_filtro_ok()
	{
		$anno = $this->input->post('anno1'); 
		$mes = $this->input->post('mes1');
		$datos['anno']  	= $anno;		
		$datos['mes']  		= $mes;
		/*$fecha = new DateTime();		
		$anno  				= $fecha->format('Y');
		$datos['anno']  	= $anno;
		$mes  				= $fecha->format('m');
		$datos['mes']  		= $mes;*/
		//$user = $this->ion_auth->user()->row();
		//$usuario = $user->id;
		$pedidos = $this->M_operaciones->obtener_pedidos_armador_desp_ok( $anno, $mes);	
        $datos['pedidos'] = $pedidos;		
		$bandera=0;
		
		$consultores = array();
		$id = array();
		$id_pedido = array();
		$no_factura = array();
		$producto = array();
		$importe = array();
		$cobranza = array();
		$OCA = array();
		$armado = array();
		$despachado = array();
		$recargo = array();
		$iva = array();
		$fecha = array();
		$dni = array();
		$local = array();
		$usuario = array();
		$fecha_envio = array();
		$nombre_apellidos = array();
		$id_entrega = array();
		$notas = array();
		// echo '<option value="' . $mun->id_tipo_empresa . '">' . $mun->nombre . '</option>';
		$contador= 0;
		foreach ($pedidos->result() as $pr){			
			if($bandera==0){
				$contador= 0;				
				$anterior=$pr->no_factura;
				$actual=$pr->no_factura;
				$importe[$contador] =0;
			}else{
				$actual=$pr->no_factura;
			}
			if($anterior == $actual){
				if($contador== 0 && $bandera==0){//es la primera vez qe se recorre
					$bandera=1;
					$id_consultor = $pr->id_usuario;
					$consultor = $this->M_operaciones->obtener_consultor($id_consultor);
					$consultores[$contador] = $consultor->first_name;
					$id[$contador] = $pr->id;
					$id_pedido[$contador] = $pr->id_pedido;
					$id_entrega[$contador] = $pr->id_entrega;
					$no_factura[$contador] = $pr->no_factura;
					$producto[$contador] = $pr->producto.' '.$pr->color.'</br>';
					$importe[$contador] = $pr->importe ;
					$cobranza[$contador] = '*';
					$OCA[$contador] = $pr->OCA;
					$armado[$contador] = $pr->armado;
					$despachado[$contador] = $pr->despachado;
					$recargo[$contador] = $pr->recargo;
					$iva[$contador] = $pr->iva;
					$fecha[$contador] = $pr->fecha_solicitud;
					$dni[$contador] = $pr->dni;
					$local[$contador] = $pr->local;
					$notas[$contador] = $pr->notas;
					$usuario[$contador] = $pr->usuario;
					$fecha_envio[$contador] = $pr->fecha_envio;
					$nombre_apellidos[$contador] = $pr->nombre.' '.$pr->apellidos;					
				}else{//es el mismo pedido
					$producto[$contador] = $producto[$contador]. $pr->producto.' '.$pr->color.'</br>';
					$importe[$contador] = $importe[$contador] + $pr->importe;
				}
			}else{//es otro pedido
				$contador = $contador + 1;
				$id_consultor = $pr->id_usuario;
				$consultor = $this->M_operaciones->obtener_consultor($id_consultor);
				$consultores[$contador] = $consultor->first_name;
				$id[$contador] = $pr->id;
				$id_pedido[$contador] = $pr->id_pedido;
				$id_entrega[$contador] = $pr->id_entrega;
				$no_factura[$contador] = $pr->no_factura;
				$producto[$contador] = $pr->producto.' '.$pr->color.'</br>';
				$importe[$contador] = $pr->importe;
				$cobranza[$contador] = '*';
				$OCA[$contador] = $pr->OCA;
				$armado[$contador] = $pr->armado;
				$despachado[$contador] = $pr->despachado;
				$recargo[$contador] = $pr->recargo;
				$iva[$contador] = $pr->iva;
				$fecha[$contador] = $pr->fecha_solicitud;
				$dni[$contador] = $pr->dni;
				$local[$contador] = $pr->local;
				$notas[$contador] = $pr->notas;
				$usuario[$contador] = $pr->usuario;
				$fecha_envio[$contador] = $pr->fecha_envio;
				$nombre_apellidos[$contador] = $pr->nombre.' '.$pr->apellidos;
				//Sumo el recargo
				$importe[$contador-1] = $importe[$contador-1]+$recargo[$contador-1]+$iva[$contador-1]; 
			}
			$anterior=$pr->no_factura;
		}
		if($bandera == 1 )							
			$importe[$contador] = $importe[$contador]+$recargo[$contador]+$iva[$contador]; 						
		
		$datos['consultores'] 		=$consultores;
		$datos['id'] 				=$id;
		$datos['id_pedido'] 		=$id_pedido;
		$datos['id_entrega'] 		=$id_entrega;
		$datos['no_factura'] 		=$no_factura;
		$datos['producto'] 			=$producto;
		$datos['importe'] 			=$importe;
		$datos['cobranza'] 			=$cobranza;
		$datos['OCA'] 				=$OCA;
		$datos['armado'] 			=$armado;
		$datos['despachado'] 		=$despachado;
		$datos['dni'] 				=$dni;
		$datos['local'] 				=$local;
		$datos['fecha'] 				=$fecha;
		$datos['notas'] 				=$notas;
		$datos['usuario'] 				=$usuario;
		$datos['fecha_envio'] 				=$fecha_envio;
		$datos['nombre_apellidos'] 	=$nombre_apellidos;

		$annos = $this->M_configuracion->obt_annos();
		$meses = $this->M_configuracion->obt_meses();
		$despachos = $this->M_operaciones->obtener_despachos();	
        $datos['despachos'] = $despachos;
		$datos['annos']  	= $annos;
		$datos['meses']  	= $meses;
		$datos['filtro1']  	= '0';
		$datos['filtro2']  	= '0';
		$datos['filtro3']  	= '0';
		$datos['filtro4']  	= '1';
		$datos['locales']  	= $this->M_configuracion->obt_locales();
		
		$this->load->view('lte_header', $datos);
		$this->load->view('v_listado_pedidos_gestion_ar_desp', $datos);
		$this->load->view('lte_footer', $datos);	
	}
	public function principal()
	{
		// Reseteando variables de sesión del asistente
		$resultado = $this->M_dashboard->obt_ventas_canales();
		$datos = array();
		
		$datos['valor']= $this->M_configuracion->obt_paises();

		
		$this->load->view('lte_header', $datos);
		$this->load->view('v_dashboard', $datos);
		$this->load->view('lte_footer', $datos);	
	}
	public function proporcion_venta()
	{
		// Reseteando variables de sesión del asistente
		$resultado = $this->M_dashboard->obt_ventas_canales();
		$datos = array();
		
				
		$this->load->view('lte_header', $datos);
		$this->load->view('v_proporcion_venta', $datos);
		$this->load->view('lte_footer', $datos);	
	}
	public function dashboard_consultores()
	{
		// Reseteando variables de sesión del asistente
		$resultado = $this->M_dashboard->obt_ventas_canales();		
		
		$datos = array();
		
		$group = array('Consultores','JefeArea');						
		if($this->ion_auth->in_group($group)){
		  $datos['total_clientes'] = $this->M_configuracion->total_clientes();
		  
		  $datos['total_misiones'] = $this->M_configuracion->total_misiones_disponibles();
		  
		  $datos['total_ventas_pendientes'] = $this->M_operaciones->total_ventas_pendientes();
		  
		  $datos['total_seguimientos'] = $this->M_configuracion->total_misiones();
		  $datos['total_reclamos'] = $this->M_configuracion->total_reclamos();
		  $datos['reclamos_abiertos'] = $this->M_configuracion->reclamos_abiertos();
		  $datos['total_ventas_pendientes_pv'] = $this->M_operaciones->total_ventas_pendientes_pv();
		  $datos['total_consultores'] = $this->M_configuracion->usuarios_consultores()->num_rows();
		}
		
		$group1 = array('Administradores');						
		if($this->ion_auth->in_group($group1)){
		  $datos['total_clientes'] = $this->M_configuracion->total_clientes();
		  $datos['total_ventas_pendientes_pv'] = $this->M_operaciones->total_ventas_pendientes_pv();		
		  $datos['total_reclamos'] = $this->M_configuracion->total_reclamos();
		  $datos['total_consultores'] = $this->M_configuracion->usuarios_consultores()->num_rows();		
		  $resultados 		= $this->M_operaciones->cargar_orden_estado(3);
		  $datos['total_control_crediticio'] 	= $resultados->num_rows();
		  $resultados 		= $this->M_operaciones->cargar_orden_estado(4);
		  $datos['total_control_stock'] 	= $resultados->num_rows();
		  $resultados 		= $this->M_operaciones->cargar_orden_estado(5);
		  $datos['total_control_facturacion'] 	= $resultados->num_rows();
		  $resultados 		= $this->M_operaciones->cargar_orden_estado(6);
		  $datos['total_control_acreditaciones'] 	= $resultados->num_rows();
		  $resultados 		= $this->M_operaciones->cargar_orden_estado(8);
		  $datos['total_control_remitos'] 	= $resultados->num_rows();
		  $resultados 		= $this->M_operaciones->cargar_orden_estado(9);
		  $datos['total_control_pagos'] 	= $resultados->num_rows();
		  $resultados 		= $this->M_operaciones->cargar_orden_estado(10);
		  $datos['total_control_backup'] 	= $resultados->num_rows();
		
		  $datos['reclamos_abiertos'] = $this->M_configuracion->reclamos_abiertos();			
		}

		$this->load->view('lte_header', $datos);
		$this->load->view('v_consultores', $datos);
		$this->load->view('lte_footer', $datos);	
	}
	public function dashboard_consultores_detalles()
	{
		$datos['anno'] 	= date('Y');
		$datos['consultores'] = $this->M_configuracion->usuarios_consultores();
		$datos['total_clientes'] = $this->M_configuracion->total_clientes();
        $datos['total_misiones'] = $this->M_configuracion->total_misiones_disponibles();
		
		$this->load->view('lte_header', $datos);
		$this->load->view('v_consultores_detalles', $datos);
		$this->load->view('lte_footer', $datos);
	}
	public function dashboard_revendedores()
	{	
		$group = array('ConsultorRV','ConsultorRVInt');
		if ($this->ion_auth->in_group($group)){
			$user = $this->ion_auth->user()->row();		
			$id_usuario = 	$user->id;
			$datos['id_usuario'] = $user->id;
			// Reseteando variables de sesión del asistente
			$resultado = $this->M_dashboard->obt_ventas_canales();
			$clasifica_desafio = $this->M_dashboard->obt_clasifica_desafio($id_usuario);	
			$datos['clasifica_desafio'] = 	$clasifica_desafio;	
			$clientes = $this->M_configuracion->clientes_revendedores($user->id);
						
			$datos['total_clientes'] 		= $clientes->num_rows();;
			$total_misiones			= $this->M_configuracion->total_misiones_disponibles_revint($user->id);
			if($total_misiones != 0){
				$datos['pro_vencido'] =round($total_misiones/$datos['total_clientes'] *100,2);
			}else{
				$datos['pro_vencido'] = 0;
			}			
			$datos['total_misiones'] 			= $total_misiones ;
			$datos['total_ventas_pendientes'] 	= $this->M_operaciones->total_ventas_rev();
			$datos['total_seguimientos'] 		= $this->M_configuracion->total_misiones();
			$datos['total_reclamos'] 			= $this->M_configuracion->total_hallazgos();
			$total_promociones 		= $this->M_dashboard->obt_promociones_rev();
			$datos['total_promociones'] 		= $total_promociones->num_rows()-1;

			$this->load->view('lte_header', $datos);
			$this->load->view('v_dashboard_revendedores', $datos);
			$this->load->view('lte_footer', $datos);
		}
		
	}
	public function dashboard_jefe_revendedores()
	{		
		$user = $this->ion_auth->user()->row();			
		$datos['id_usuario'] = $user->id;
		// Reseteando variables de sesión del asistente
		$resultado = $this->M_dashboard->obt_ventas_canales();
					
		$datos = array();
		
		$group = array('Revendedores'); 
		if ($this->ion_auth->in_group($group)){
			$datos['total_clientes'] 			= $this->M_operaciones->total_revendedores();
		}
		$group = array('RevendedoresInt'); 
		if ($this->ion_auth->in_group($group)){
			$datos['total_clientes'] 			= $this->M_operaciones->total_revendedores_int();
		}
		$datos['total_misiones'] 			= $this->M_configuracion->total_misiones_disponibles();
		$datos['total_ventas_pendientes'] 	= $this->M_operaciones->total_ventas_pendientes();
		$datos['total_seguimientos'] 		= $this->M_configuracion->total_misiones();
		$datos['total_reclamos'] 			= $this->M_configuracion->total_hallazgos();

		$group = array('Revendedores'); 
		if ($this->ion_auth->in_group($group)){
			$resultados 		= $this->M_operaciones->cargar_orden_estado_nac(2);
		}
		$group = array('RevendedoresInt'); 
		if ($this->ion_auth->in_group($group)){
			$resultados 		= $this->M_operaciones->cargar_orden_estado_int(2);
		}
		$datos['total_politicas_comerciales'] 	= $resultados->num_rows();
		$group = array('Revendedores'); 
		if ($this->ion_auth->in_group($group)){
			$resultados 		= $this->M_operaciones->cargar_orden_estado_nac(3);
		}
		$group = array('RevendedoresInt'); 
		if ($this->ion_auth->in_group($group)){
			$resultados 		= $this->M_operaciones->cargar_orden_estado_int(3);
		}
		$datos['total_control_crediticio'] 	= $resultados->num_rows();
		$group = array('Revendedores'); 
		if ($this->ion_auth->in_group($group)){
			$resultados 		= $this->M_operaciones->cargar_orden_estado_nac(4);
		}
		$group = array('RevendedoresInt'); 
		if ($this->ion_auth->in_group($group)){
			$resultados 		= $this->M_operaciones->cargar_orden_estado_int(4);
		}
		$datos['total_control_stock'] 	= $resultados->num_rows();
		$group = array('Revendedores'); 
		if ($this->ion_auth->in_group($group)){
			$resultados 		= $this->M_operaciones->cargar_orden_estado_nac(5);
		}
		$group = array('RevendedoresInt'); 
		if ($this->ion_auth->in_group($group)){
			$resultados 		= $this->M_operaciones->cargar_orden_estado_int(5);
		}
		$datos['total_control_facturacion'] 	= $resultados->num_rows();
		$group = array('Revendedores'); 
		if ($this->ion_auth->in_group($group)){
			$resultados 		= $this->M_operaciones->cargar_orden_estado_nac(6);
		}
		$group = array('RevendedoresInt'); 
		if ($this->ion_auth->in_group($group)){
			$resultados 		= $this->M_operaciones->cargar_orden_estado_int(6);
		}
		$datos['total_control_acreditaciones'] 	= $resultados->num_rows();
		$group = array('Revendedores'); 
		if ($this->ion_auth->in_group($group)){
			$resultados 		= $this->M_operaciones->cargar_orden_estado_nac(7);
		}
		$group = array('RevendedoresInt'); 
		if ($this->ion_auth->in_group($group)){
			$resultados 		= $this->M_operaciones->cargar_orden_estado_int(7);
		}
		$datos['total_control_despachos'] 	= $resultados->num_rows();
		$group = array('Revendedores'); 
		if ($this->ion_auth->in_group($group)){
			$resultados 		= $this->M_operaciones->cargar_orden_estado_nac(8);
		}
		$group = array('RevendedoresInt'); 
		if ($this->ion_auth->in_group($group)){
			$resultados 		= $this->M_operaciones->cargar_orden_estado_int(8);
		}
		$datos['total_control_remitos'] 	= $resultados->num_rows();
		$group = array('Revendedores'); 
		if ($this->ion_auth->in_group($group)){
			$resultados 		= $this->M_operaciones->cargar_orden_estado_nac(9);
		}
		$group = array('RevendedoresInt'); 
		if ($this->ion_auth->in_group($group)){
			$resultados 		= $this->M_operaciones->cargar_orden_estado_int(9);
		}
		$datos['total_control_pagos'] 	= $resultados->num_rows();
		$group = array('Revendedores'); 
		if ($this->ion_auth->in_group($group)){
			$resultados 		= $this->M_operaciones->cargar_orden_estado_nac(10);
		}
		$group = array('RevendedoresInt'); 
		if ($this->ion_auth->in_group($group)){
			$resultados 		= $this->M_operaciones->cargar_orden_estado_int(10);
		}
		$datos['total_control_backup'] 	= $resultados->num_rows();
		
		$group = array('Revendedores'); 
		if ($this->ion_auth->in_group($group)){
			$resultados 		= $this->M_operaciones->cargar_ordenes_nac();
		}
		$group = array('RevendedoresInt'); 
		if ($this->ion_auth->in_group($group)){
			$resultados 		= $this->M_operaciones->cargar_ordenes_int();
		}
		$datos['total_ordenes'] = $resultados->num_rows();

		$this->load->view('lte_header', $datos);
		$this->load->view('v_dashboard_jefe_revendedores', $datos);
		$this->load->view('lte_footer', $datos);
		
	}
	public function dashboard_jefe_produccion()
	{				
		$fecha_inicio=date('Y-m-d H:i:s',mktime(0, 0, 0, date("m"), 1,   date("Y")));
		$fecha_final = $this->M_dashboard->obt_ultimo_dia_mes_actual();
	
		$ventas = $this->M_dashboard->obt_datos_ventas($fecha_inicio,$fecha_final);
					
		$datos['ventas'] 		= $ventas;
		$datos['fecha_inicio'] 	= $fecha_inicio;
		$datos['fecha_final'] 	= $fecha_final;

		$this->load->view('lte_header', $datos);
		$this->load->view('v_listado_datos_ventas', $datos);
		$this->load->view('lte_footer', $datos);
		
	}
	public function dashboard_jefe_produccion_filtro()
	{				
		
		$fecha_inicio=$this->input->post('fecha_inicio');
		$fecha_final = $this->input->post('fecha_final');
	
		$ventas = $this->M_dashboard->obt_datos_ventas($fecha_inicio,$fecha_final);
					
		$datos['ventas'] 		= $ventas;
		$datos['fecha_inicio'] 	= $fecha_inicio;
		$datos['fecha_final'] 	= $fecha_final;

		$this->load->view('lte_header', $datos);
		$this->load->view('v_listado_datos_ventas', $datos);
		$this->load->view('lte_footer', $datos);
		
	}
	public function dashboard_jefe_produccion_filtro_excell()
	{				
		
		$fecha_inicio=$this->input->post('fecha_inicio1');;
		$fecha_final = $this->input->post('fecha_final1');;
	
		//$ventas = $this->M_dashboard->obt_datos_ventas($fecha_inicio,$fecha_final);
		to_excel($this->M_dashboard->obt_datos_ventas_exc($fecha_inicio,$fecha_final), "Reporte sobre ventas");		/*	
		$datos['ventas'] 		= $ventas;
		$datos['fecha_inicio'] 	= $fecha_inicio;
		$datos['fecha_final'] 	= $fecha_final;

		$this->load->view('lte_header', $datos);
		$this->load->view('v_listado_datos_ventas', $datos);
		$this->load->view('lte_footer', $datos);*/
		
	}
	public function dashboard_jefe_produccion_ventas()
	{	
		$fecha_inicio=date('Y-m-d H:i:s',mktime(0, 0, 0, date("m"), 1,   date("Y")));
		$fecha_final = $this->M_dashboard->obt_ultimo_dia_mes_actual();
	
		$ventas = $this->M_dashboard->obt_datos_ventas($fecha_inicio,$fecha_final);
		$ventas_pto_venta = $this->M_dashboard->obt_datos_ventas_pto_vta($fecha_inicio,$fecha_final);
		$ventas_vendedor = $this->M_dashboard->obt_datos_ventas_vendedor($fecha_inicio,$fecha_final);
		$ventas_armado = $this->M_dashboard->obt_datos_gestion_armado($fecha_inicio,$fecha_final);
		$ventas_despacho = $this->M_dashboard->obt_datos_gestion_despacho($fecha_inicio,$fecha_final);
		$ventas_canal_pedidos = $this->M_dashboard->obt_datos_canal_pedidos($fecha_inicio,$fecha_final);
		$ventas_canal_producto = $this->M_dashboard->obt_datos_canal_productos($fecha_inicio,$fecha_final);
		$obt_datos_productos = $this->M_dashboard->obt_datos_productos($fecha_inicio,$fecha_final);
		$obt_datos_vendedores = $this->M_dashboard->obt_datos_vendedores($fecha_inicio,$fecha_final);
					
		$datos['ventas'] 			= $ventas;
		$datos['fecha_inicio'] 		= $fecha_inicio;
		$datos['fecha_final'] 		= $fecha_final;
		$datos['ventas_pto_venta'] 	= $ventas_pto_venta;
		$datos['ventas_vendedor'] 	= $ventas_vendedor;
		$datos['ventas_armado'] 	= $ventas_armado;
		$datos['ventas_despacho'] 	= $ventas_despacho;
		$datos['ventas_canal_pedidos'] 	= $ventas_canal_pedidos;
		$datos['ventas_canal_producto'] = $ventas_canal_producto;
		$datos['obt_datos_productos'] 	= $obt_datos_productos;
		$datos['obt_datos_vendedores'] 	= $obt_datos_vendedores;

		$this->load->view('lte_header', $datos);
		$this->load->view('v_dashboard_datos_ventas', $datos);
		$this->load->view('lte_footer', $datos);
		
	}
	public function dashboard_jefe_produccion_ventas_filtro()
	{				
		
		$fecha_inicio=$this->input->post('fecha_inicio');;
		$fecha_final = $this->input->post('fecha_final');;
	
		$ventas = $this->M_dashboard->obt_datos_ventas($fecha_inicio,$fecha_final);
		$ventas_pto_venta = $this->M_dashboard->obt_datos_ventas_pto_vta($fecha_inicio,$fecha_final);
		$ventas_vendedor = $this->M_dashboard->obt_datos_ventas_vendedor($fecha_inicio,$fecha_final);
		$ventas_armado = $this->M_dashboard->obt_datos_gestion_armado($fecha_inicio,$fecha_final);		
		$ventas_despacho = $this->M_dashboard->obt_datos_gestion_despacho($fecha_inicio,$fecha_final);
		$ventas_canal_pedidos = $this->M_dashboard->obt_datos_canal_pedidos($fecha_inicio,$fecha_final);
		$ventas_canal_producto = $this->M_dashboard->obt_datos_canal_productos($fecha_inicio,$fecha_final);
		$obt_datos_productos = $this->M_dashboard->obt_datos_productos($fecha_inicio,$fecha_final);
		$obt_datos_vendedores = $this->M_dashboard->obt_datos_vendedores($fecha_inicio,$fecha_final);
					
		$datos['ventas'] 			= $ventas;
		$datos['fecha_inicio'] 		= $fecha_inicio;
		$datos['fecha_final'] 		= $fecha_final;
		$datos['ventas_pto_venta'] 	= $ventas_pto_venta;
		$datos['ventas_vendedor'] 	= $ventas_vendedor;
		$datos['ventas_armado'] 	= $ventas_armado;
		$datos['ventas_despacho'] 	= $ventas_despacho;
		$datos['ventas_canal_pedidos'] 	= $ventas_canal_pedidos;
		$datos['ventas_canal_producto'] = $ventas_canal_producto;
		$datos['obt_datos_productos'] 	= $obt_datos_productos;
		$datos['obt_datos_vendedores'] 	= $obt_datos_vendedores;

		$this->load->view('lte_header', $datos);
		$this->load->view('v_dashboard_datos_ventas', $datos);
		$this->load->view('lte_footer', $datos);
		
	}
	public function dashboard_principal_jefe_produccion(){
		// Reseteando variables de sesión del asistente
		$resultado = $this->M_dashboard->obt_ventas_canales();
		

		$datos = array();
		
		$datos['total_clientes'] = $this->M_configuracion->total_clientes();
		$datos['total_misiones'] = $this->M_configuracion->total_misiones_disponibles();
		$datos['total_ventas_pendientes'] = $this->M_operaciones->total_ventas_pendientes();
		$datos['total_ventas_pendientes_pv'] = $this->M_operaciones->total_ventas_pendientes_pv();
		$datos['total_seguimientos'] = $this->M_configuracion->total_misiones();
		$datos['total_reclamos'] = $this->M_configuracion->total_hallazgos();
		$resultados 		= $this->M_operaciones->cargar_orden_estado(3);
		$datos['total_control_crediticio'] 	= $resultados->num_rows();
		$resultados 		= $this->M_operaciones->cargar_orden_estado(4);
		$datos['total_control_stock'] 	= $resultados->num_rows();
		$resultados 		= $this->M_operaciones->cargar_orden_estado(5);
		$datos['total_control_facturacion'] 	= $resultados->num_rows();
		$resultados 		= $this->M_operaciones->cargar_orden_estado(6);
		$datos['total_control_acreditaciones'] 	= $resultados->num_rows();
		$resultados 		= $this->M_operaciones->cargar_orden_estado(7);
		$datos['total_control_despachos'] 	= $resultados->num_rows();
		$resultados 		= $this->M_operaciones->cargar_orden_estado(8);
		$datos['total_control_remitos'] 	= $resultados->num_rows();
		$resultados 		= $this->M_operaciones->cargar_orden_estado(9);
		$datos['total_control_pagos'] 	= $resultados->num_rows();
		$resultados 		= $this->M_operaciones->cargar_orden_estado(10);
		$datos['total_control_backup'] 	= $resultados->num_rows();
		
		$resultados 		= $this->M_operaciones->cargar_ordenes();
		$datos['total_ordenes'] = $resultados->num_rows();
		$this->load->view('lte_header', $datos);
		$this->load->view('v_produccion', $datos);
		$this->load->view('lte_footer', $datos);
	}
	public function dashboard_consultor()
	{
		// Reseteando variables de sesión del asistente
		$resultado = $this->M_dashboard->obt_ventas_canales();
		$datos = array();
		
		$annos = $this->M_configuracion->obt_annos();
		$meses = $this->M_configuracion->obt_meses();
		
		$datos['annos']  	= $annos;
		$datos['meses']  	= $meses;
		$fecha = new DateTime();		
		$datos['anno']  	= $fecha->format('Y');
		$datos['mes']  		= $fecha->format('m');	
			
		$this->load->view('lte_header', $datos);
		$this->load->view('v_consultor', $datos);
		$this->load->view('lte_footer', $datos);	
	}
	public function proporcion_venta_pdf()
	{
		// Reseteando variables de sesión del asistente
		$resultado = $this->M_dashboard->obt_ventas_canales();
		$datos = array();
		
		$this->descargar_pdf('proporcion_venta','v_proporcion_venta', $datos);		
		/*$this->load->view('lte_header', $datos);
		$this->load->view('v_proporcion_venta', $datos);
		$this->load->view('lte_footer', $datos);*/	
	}
	/********************************************************************************************************************/
	public function respuestas_negativas()
	{
		// Reseteando variables de sesión del asistente
		$respuestas = $this->M_dashboard->obt_respuestas_negativas();
		$datos = array();
		
		$datos['respuestas'] 	= $respuestas;
		$datos['total'] 	= $this->M_dashboard->total_respuestas_negativas();

		$this->load->view('lte_header', $datos);
		$this->load->view('v_listado_respuestas_negativas', $datos);
		$this->load->view('lte_footer', $datos);	
	}
	public function respuestas_negativas_pdf()
	{
		// Reseteando variables de sesión del asistente
		$respuestas = $this->M_dashboard->obt_respuestas_negativas();
		$datos = array();
		
		$datos['respuestas'] 	= $respuestas;
		$datos['total'] 	= $this->M_dashboard->total_respuestas_negativas();
		
		$this->descargar_pdf('respuestas_negativas','v_listado_respuestas_negativas', $datos);
		/*$this->load->view('lte_header', $datos);
		$this->load->view('v_listado_respuestas_negativas', $datos);
		$this->load->view('lte_footer', $datos);*/	
	}
	/********************************************************************************************************************/
	public function objetivos_asignados()
	{
		// Reseteando variables de sesión del asistente
		$usuarios = $this->M_dashboard->obt_usuario_con_objetivos();
		

		$ejecucion= $this->M_dashboard->obt_ejecucion();

		$id 		= array();
		$id_usuario	= array();
		$nombre 	= array();
		$objetivos 	= array();
		$ingresos 	= array();
		$superior 	= array();
		$grupo 		= array();
		$canal 		= array();

		$cont = 0;
		//Los consultores
		foreach($usuarios->result() as $us){
			if($us->group_id == 5){//consultor				
				foreach($ejecucion->result() as $eje){
					
					if($us->id_usuario == $eje->id_usuario){
						$id[$cont] = $cont;
						$id_usuario[$cont] = $us->id_usuario;
						$nombre[$cont] = $us->first_name.' '.$us->last_name;
						$objetivos[$cont] = $eje->objetivo;
						$ingresos[$cont] = $eje->ingresos+0;
						$canal[$cont] = $eje->tipo;
						/*if(($eje->id_tipo_objetivo)*1 == 4){							
							$canal[$cont] = 'Atención';
						}else{
							if(($eje->id_tipo_objetivo)*1 == 6){
								$canal[$cont] = 'Misión';
							}else{
								if(($eje->id_tipo_objetivo)*1 == 1){
									$canal[$cont] = 'Misión (Unidades)';
								}else{
									if(($eje->id_tipo_objetivo)*1 == 2){
										$canal[$cont] = 'Purificadores';
									}
								}
							}
							
						}*/						
						$superior[$cont] = $this->M_operaciones->obt_superior($us->id_usuario);;
						$grupo[$cont] = 'Con:';
						$cont = $cont +1;
					}
				}				
				
			}else{				
				if($us->group_id == 6){//Consultor revendedor
					foreach($ejecucion->result() as $eje){
						if($us->id_usuario == $eje->id_usuario){
							$id[$cont] = $cont;
							$id_usuario[$cont] = $us->id_usuario;
							$nombre[$cont] = $us->first_name.' '.$us->last_name;
							$objetivos[$cont] = $eje->objetivo;
							$ingresos[$cont] = $eje->ingresos+0;
							$canal[$cont] = $eje->tipo;
							/*if(($eje->id_tipo_objetivo)*1 == 4){
								$canal[$cont] = 'Atención';
							}else{
								$canal[$cont] = 'Misión';
							}*/
			                         	$var_user = $this->M_operaciones->obt_superior($us->id_usuario);
							$superior[$cont] = $var_user->id_usuario;
							$grupo[$cont] = 'CRev:';
							$cont = $cont +1;
						}
					}
				}	
			}
		}

		
		// Supervisores y revendedores		
		foreach($usuarios->result() as $us){
			if($us->group_id == 7){//Supervisor
				foreach($ejecucion->result() as $eje){
					if($us->id_usuario == $eje->id_usuario){
						$id[$cont] = $cont;
						$id_usuario[$cont] = $us->id_usuario;
						$nombre[$cont] = $us->first_name.' '.$us->last_name;
						$objetivos[$cont] = $eje->objetivo;
						$ingresos[$cont] = 0;
						$canal[$cont] = $eje->tipo;
						for ($i=0; $i<$cont; $i++ ){						
							if($superior[$i] == $us->id_usuario && $canal[$i] == $eje->tipo){
								$ingresos[$cont] = $ingresos[$cont] + $ingresos[$i];
							}
						}
						/*if(($eje->id_tipo_objetivo)*1 == 4){
							
							for ($i=0; $i<$cont; $i++ ){
								if($superior[$i] == $us->id_usuario && $canal[$i] == 'Atención'){
									$ingresos[$cont] = $ingresos[$cont] + $ingresos[$i];
								}
							}
						}else{
							$canal[$cont] = 'Misión';
							for ($i=0; $i<$cont; $i++ ){
								if($superior[$i] == $us->id_usuario && $canal[$i] == 'Misión'){
									$ingresos[$cont] = $ingresos[$cont] + $ingresos[$i];
								}
							}
						}	*/
						$superior[$cont] = $this->M_operaciones->obt_superior($us->id_usuario);;
						$grupo[$cont] = 'Sup:';
						$cont = $cont +1;
					}
				}
			}else{
				if($us->group_id == 4){//Revendedor
					foreach($ejecucion->result() as $eje){
						if($us->id_usuario == $eje->id_usuario){
							$id[$cont] = $cont;
							$id_usuario[$cont] = $us->id_usuario;
							$nombre[$cont] = $us->first_name.' '.$us->last_name;
							$objetivos[$cont] = $eje->objetivo;
							$ingresos[$cont] = 0;
							$canal[$cont] = $eje->tipo;
							for ($i=0; $i<$cont; $i++ ){							
								if($superior[$i] == $us->id_usuario && $canal[$i] == $eje->tipo){
									$ingresos[$cont] = $ingresos[$cont] + $ingresos[$i];
								}
							}
							/*if(($eje->id_tipo_objetivo)*1 == 4){
								$canal[$cont] = 'Atención';
								for ($i=0; $i<$cont; $i++ ){
									if($superior[$i] == $us->id_usuario && $canal[$i] == 'Atención'){
										$ingresos[$cont] = $ingresos[$cont] + $ingresos[$i];
									}
								}
							}else{
								$canal[$cont] = 'Misión';
								for ($i=0; $i<$cont; $i++ ){
									if($superior[$i] == $us->id_usuario && $canal[$i] == 'Misión'){
										$ingresos[$cont] = $ingresos[$cont] + $ingresos[$i];
									}
								}
							}	*/
							$superior[$cont] = $this->M_operaciones->obt_superior($us->id_usuario);;
							$grupo[$cont] = 'Rev:';
							$cont = $cont +1;
						}
					}
				}
			}
		}

		

		// Jefe de area		
		foreach($usuarios->result() as $us){
			if($us->group_id == 8){//Jefe de area
				// 1 Cantidad Llamadas
				$id[$cont] = $cont;
				$id_usuario[$cont] = $us->id_usuario;
				$nombre[$cont] = $us->first_name.' '.$us->last_name;
				$ingresos[$cont] = 0;
				$objetivos[$cont] = 0;
				$canal[$cont] = 'Cantidad Llamadas';
				for ($i=0; $i<$cont; $i++ ){
					if($superior[$i] == $us->id_usuario && $canal[$i] == 'Cantidad Llamadas'){
						$ingresos[$cont] = $ingresos[$cont] + $ingresos[$i];
						$objetivos[$cont] = $objetivos[$cont] + $objetivos[$i];
					}
				}
				$superior[$cont] = $this->M_operaciones->obt_superior($us->id_usuario);
				$grupo[$cont] = 'JÁr:';
				$cont = $cont +1;

				// 2 Cantidades Purificadores
				$id[$cont] = $cont;
				$id_usuario[$cont] = $us->id_usuario;
				$nombre[$cont] = $us->first_name.' '.$us->last_name;
				$ingresos[$cont] = 0;
				$objetivos[$cont] = 0;
				$canal[$cont] = 'Cantidades Purificadores';
				for ($i=0; $i<$cont; $i++ ){
					if($superior[$i] == $us->id_usuario && $canal[$i] == 'Cantidades Purificadores'){
						$ingresos[$cont] = $ingresos[$cont] + $ingresos[$i];
						$objetivos[$cont] = $objetivos[$cont] + $objetivos[$i];
					}
				}
				$superior[$cont] = $this->M_operaciones->obt_superior($us->id_usuario);
				$grupo[$cont] = 'JÁr:';
				$cont = $cont +1;

				// 3 Cantidades de Repuestos
				$id[$cont] = $cont;
				$id_usuario[$cont] = $us->id_usuario;
				$nombre[$cont] = $us->first_name.' '.$us->last_name;
				$ingresos[$cont] = 0;
				$objetivos[$cont] = 0;
				$canal[$cont] = 'Cantidades de Repuestos';
				for ($i=0; $i<$cont; $i++ ){
					if($superior[$i] == $us->id_usuario && $canal[$i] == 'Cantidades de Repuestos'){
						$ingresos[$cont] = $ingresos[$cont] + $ingresos[$i];
						$objetivos[$cont] = $objetivos[$cont] + $objetivos[$i];
					}
				}
				$superior[$cont] = $this->M_operaciones->obt_superior($us->id_usuario);
				$grupo[$cont] = 'JÁr:';
				$cont = $cont +1;

				// 4 Llamada $
				$id[$cont] = $cont;
				$id_usuario[$cont] = $us->id_usuario;
				$nombre[$cont] = $us->first_name.' '.$us->last_name;
				$ingresos[$cont] = 0;
				$objetivos[$cont] = 0;
				$canal[$cont] = 'Llamada $';
				for ($i=0; $i<$cont; $i++ ){
					if($superior[$i] == $us->id_usuario && $canal[$i] == 'Llamada $'){
						$ingresos[$cont] = $ingresos[$cont] + $ingresos[$i];
						$objetivos[$cont] = $objetivos[$cont] + $objetivos[$i];
					}
				}
				$superior[$cont] = $this->M_operaciones->obt_superior($us->id_usuario);
				$grupo[$cont] = 'JÁr:';
				$cont = $cont +1;

				// 6 Mision
				$id[$cont] = $cont;
				$id_usuario[$cont] = $us->id_usuario;
				$nombre[$cont] = $us->first_name.' '.$us->last_name;
				$ingresos[$cont] = 0;
				$objetivos[$cont] = 0;
				$canal[$cont] = 'Misión $';
				for ($i=0; $i<$cont; $i++ ){
					if($superior[$i] == $us->id_usuario && $canal[$i] == 'Misión $'){
						$ingresos[$cont] = $ingresos[$cont] + $ingresos[$i];
						$objetivos[$cont] = $objetivos[$cont] + $objetivos[$i];
					}
				}
				$superior[$cont] = $this->M_operaciones->obt_superior($us->id_usuario);
				$grupo[$cont] = 'JÁr:';
				$cont = $cont +1;
			}
		}

		/*print_r($id);
		print_r($id_usuario);
		print_r($nombre);
		print_r($objetivos);
		print_r($ingresos);
		print_r($superior);
		die();
	*/
		$datos['id'] 		 = $id;
		$datos['id_usuario'] = $id_usuario;
		$datos['nombre'] 	 = $nombre;
		$datos['objetivos']  = $objetivos;
		$datos['ingresos'] 	 = $ingresos;
		$datos['superior'] 	 = $superior;
		$datos['grupo'] 	 = $grupo;
		$datos['canal'] 	 = $canal;

		
		// Usuario actual
		$us = $this->ion_auth->user()->row();
		$usuario_actual = $us->id;

		$subordinados = $this->M_operaciones->obt_subordinados($usuario_actual);
		
		if($subordinados->result()){
			
			$datos['subordinados'] = $subordinados;
		}else{
			$datos['subordinados'] = '';
		}
		
		$datos['usuario_actual'] 	 = $usuario_actual;

		$this->load->view('lte_header', $datos);
		$this->load->view('v_objetivos_asignados', $datos);
		$this->load->view('lte_footer', $datos);	
	}
	public function objetivos_asignados_pdf()
	{
		// Reseteando variables de sesión del asistente
		$usuarios = $this->M_dashboard->obt_usuario_con_objetivos();

		$ejecucion= $this->M_dashboard->obt_ejecucion();

		$id 		= array();
		$id_usuario	= array();
		$nombre 	= array();
		$objetivos 	= array();
		$ingresos 	= array();
		$superior 	= array();
		$grupo 		= array();
		$canal 		= array();

		$cont = 0;
		//Los consultores
		foreach($usuarios->result() as $us){
			if($us->group_id == 5){//consultor				
				foreach($ejecucion->result() as $eje){
					
					if($us->id_usuario == $eje->id_usuario){
						$id[$cont] = $cont;
						$id_usuario[$cont] = $us->id_usuario;
						$nombre[$cont] = $us->first_name.' '.$us->last_name;
						$objetivos[$cont] = $eje->objetivo;
						$ingresos[$cont] = $eje->ingresos+0;
						$canal[$cont] = $eje->tipo;
						/*if(($eje->id_tipo_objetivo)*1 == 4){							
							$canal[$cont] = 'Atención';
						}else{
							if(($eje->id_tipo_objetivo)*1 == 6){
								$canal[$cont] = 'Misión';
							}else{
								if(($eje->id_tipo_objetivo)*1 == 1){
									$canal[$cont] = 'Misión (Unidades)';
								}else{
									if(($eje->id_tipo_objetivo)*1 == 2){
										$canal[$cont] = 'Purificadores';
									}
								}
							}
							
						}*/						
						$superior[$cont] = $this->M_operaciones->obt_superior($us->id_usuario);;
						$grupo[$cont] = 'Con:';
						$cont = $cont +1;
					}
				}				
				
			}else{				
				if($us->group_id == 6){//Consultor revendedor
					foreach($ejecucion->result() as $eje){
						if($us->id_usuario == $eje->id_usuario){
							$id[$cont] = $cont;
							$id_usuario[$cont] = $us->id_usuario;
							$nombre[$cont] = $us->first_name.' '.$us->last_name;
							$objetivos[$cont] = $eje->objetivo;
							$ingresos[$cont] = $eje->ingresos+0;
							$canal[$cont] = $eje->tipo;
							/*if(($eje->id_tipo_objetivo)*1 == 4){
								$canal[$cont] = 'Atención';
							}else{
								$canal[$cont] = 'Misión';
							}*/
							$superior[$cont] = $this->M_operaciones->obt_superior($us->id_usuario);;
							$grupo[$cont] = 'CRev:';
							$cont = $cont +1;
						}
					}
				}	
			}
		}

		
		// Supervisores y revendedores		
		foreach($usuarios->result() as $us){
			if($us->group_id == 7){//Supervisor
				foreach($ejecucion->result() as $eje){
					if($us->id_usuario == $eje->id_usuario){
						$id[$cont] = $cont;
						$id_usuario[$cont] = $us->id_usuario;
						$nombre[$cont] = $us->first_name.' '.$us->last_name;
						$objetivos[$cont] = $eje->objetivo;
						$ingresos[$cont] = 0;
						$canal[$cont] = $eje->tipo;
						for ($i=0; $i<$cont; $i++ ){						
							if($superior[$i] == $us->id_usuario && $canal[$i] == $eje->tipo){
								$ingresos[$cont] = $ingresos[$cont] + $ingresos[$i];
							}
						}
						/*if(($eje->id_tipo_objetivo)*1 == 4){
							
							for ($i=0; $i<$cont; $i++ ){
								if($superior[$i] == $us->id_usuario && $canal[$i] == 'Atención'){
									$ingresos[$cont] = $ingresos[$cont] + $ingresos[$i];
								}
							}
						}else{
							$canal[$cont] = 'Misión';
							for ($i=0; $i<$cont; $i++ ){
								if($superior[$i] == $us->id_usuario && $canal[$i] == 'Misión'){
									$ingresos[$cont] = $ingresos[$cont] + $ingresos[$i];
								}
							}
						}	*/
						$superior[$cont] = $this->M_operaciones->obt_superior($us->id_usuario);;
						$grupo[$cont] = 'Sup:';
						$cont = $cont +1;
					}
				}
			}else{
				if($us->group_id == 4){//Revendedor
					foreach($ejecucion->result() as $eje){
						if($us->id_usuario == $eje->id_usuario){
							$id[$cont] = $cont;
							$id_usuario[$cont] = $us->id_usuario;
							$nombre[$cont] = $us->first_name.' '.$us->last_name;
							$objetivos[$cont] = $eje->objetivo;
							$ingresos[$cont] = 0;
							$canal[$cont] = $eje->tipo;
							for ($i=0; $i<$cont; $i++ ){							
								if($superior[$i] == $us->id_usuario && $canal[$i] == $eje->tipo){
									$ingresos[$cont] = $ingresos[$cont] + $ingresos[$i];
								}
							}
							/*if(($eje->id_tipo_objetivo)*1 == 4){
								$canal[$cont] = 'Atención';
								for ($i=0; $i<$cont; $i++ ){
									if($superior[$i] == $us->id_usuario && $canal[$i] == 'Atención'){
										$ingresos[$cont] = $ingresos[$cont] + $ingresos[$i];
									}
								}
							}else{
								$canal[$cont] = 'Misión';
								for ($i=0; $i<$cont; $i++ ){
									if($superior[$i] == $us->id_usuario && $canal[$i] == 'Misión'){
										$ingresos[$cont] = $ingresos[$cont] + $ingresos[$i];
									}
								}
							}	*/
							$superior[$cont] = $this->M_operaciones->obt_superior($us->id_usuario);;
							$grupo[$cont] = 'Rev:';
							$cont = $cont +1;
						}
					}
				}
			}
		}

		

		// Jefe de area		
		foreach($usuarios->result() as $us){
			if($us->group_id == 8){//Jefe de area
				// 1 Cantidad Llamadas
				$id[$cont] = $cont;
				$id_usuario[$cont] = $us->id_usuario;
				$nombre[$cont] = $us->first_name.' '.$us->last_name;
				$ingresos[$cont] = 0;
				$objetivos[$cont] = 0;
				$canal[$cont] = 'Cantidad Llamadas';
				for ($i=0; $i<$cont; $i++ ){
					if($superior[$i] == $us->id_usuario && $canal[$i] == 'Cantidad Llamadas'){
						$ingresos[$cont] = $ingresos[$cont] + $ingresos[$i];
						$objetivos[$cont] = $objetivos[$cont] + $objetivos[$i];
					}
				}
				$superior[$cont] = $this->M_operaciones->obt_superior($us->id_usuario);
				$grupo[$cont] = 'JÁr:';
				$cont = $cont +1;

				// 2 Cantidades Purificadores
				$id[$cont] = $cont;
				$id_usuario[$cont] = $us->id_usuario;
				$nombre[$cont] = $us->first_name.' '.$us->last_name;
				$ingresos[$cont] = 0;
				$objetivos[$cont] = 0;
				$canal[$cont] = 'Cantidades Purificadores';
				for ($i=0; $i<$cont; $i++ ){
					if($superior[$i] == $us->id_usuario && $canal[$i] == 'Cantidades Purificadores'){
						$ingresos[$cont] = $ingresos[$cont] + $ingresos[$i];
						$objetivos[$cont] = $objetivos[$cont] + $objetivos[$i];
					}
				}
				$superior[$cont] = $this->M_operaciones->obt_superior($us->id_usuario);
				$grupo[$cont] = 'JÁr:';
				$cont = $cont +1;

				// 3 Cantidades de Repuestos
				$id[$cont] = $cont;
				$id_usuario[$cont] = $us->id_usuario;
				$nombre[$cont] = $us->first_name.' '.$us->last_name;
				$ingresos[$cont] = 0;
				$objetivos[$cont] = 0;
				$canal[$cont] = 'Cantidades de Repuestos';
				for ($i=0; $i<$cont; $i++ ){
					if($superior[$i] == $us->id_usuario && $canal[$i] == 'Cantidades de Repuestos'){
						$ingresos[$cont] = $ingresos[$cont] + $ingresos[$i];
						$objetivos[$cont] = $objetivos[$cont] + $objetivos[$i];
					}
				}
				$superior[$cont] = $this->M_operaciones->obt_superior($us->id_usuario);
				$grupo[$cont] = 'JÁr:';
				$cont = $cont +1;

				// 4 Llamada $
				$id[$cont] = $cont;
				$id_usuario[$cont] = $us->id_usuario;
				$nombre[$cont] = $us->first_name.' '.$us->last_name;
				$ingresos[$cont] = 0;
				$objetivos[$cont] = 0;
				$canal[$cont] = 'Llamada $';
				for ($i=0; $i<$cont; $i++ ){
					if($superior[$i] == $us->id_usuario && $canal[$i] == 'Llamada $'){
						$ingresos[$cont] = $ingresos[$cont] + $ingresos[$i];
						$objetivos[$cont] = $objetivos[$cont] + $objetivos[$i];
					}
				}
				$superior[$cont] = $this->M_operaciones->obt_superior($us->id_usuario);
				$grupo[$cont] = 'JÁr:';
				$cont = $cont +1;

				// 6 Mision
				$id[$cont] = $cont;
				$id_usuario[$cont] = $us->id_usuario;
				$nombre[$cont] = $us->first_name.' '.$us->last_name;
				$ingresos[$cont] = 0;
				$objetivos[$cont] = 0;
				$canal[$cont] = 'Misión $';
				for ($i=0; $i<$cont; $i++ ){
					if($superior[$i] == $us->id_usuario && $canal[$i] == 'Misión $'){
						$ingresos[$cont] = $ingresos[$cont] + $ingresos[$i];
						$objetivos[$cont] = $objetivos[$cont] + $objetivos[$i];
					}
				}
				$superior[$cont] = $this->M_operaciones->obt_superior($us->id_usuario);
				$grupo[$cont] = 'JÁr:';
				$cont = $cont +1;
			}
		}

		/*print_r($id);
		print_r($id_usuario);
		print_r($nombre);
		print_r($objetivos);
		print_r($ingresos);
		print_r($superior);
		die();
	*/
		$datos['id'] 		 = $id;
		$datos['id_usuario'] = $id_usuario;
		$datos['nombre'] 	 = $nombre;
		$datos['objetivos']  = $objetivos;
		$datos['ingresos'] 	 = $ingresos;
		$datos['superior'] 	 = $superior;
		$datos['grupo'] 	 = $grupo;
		$datos['canal'] 	 = $canal;

		
		// Usuario actual
		$us = $this->ion_auth->user()->row();
		$usuario_actual = $us->id;

		$subordinados = $this->M_operaciones->obt_subordinados($usuario_actual);
		if($subordinados){
			$datos['subordinados'] = $subordinados;
		}else{
			$datos['subordinados'] = '';
		}
		
		$datos['usuario_actual'] 	 = $usuario_actual;

		$this->descargar_pdf('objetivos_asignados','v_objetivos_asignados', $datos);
		/*$this->load->view('lte_header', $datos);
		$this->load->view('v_objetivos_asignados', $datos);
		$this->load->view('lte_footer', $datos);*/	
	}
	/********************************************************************************************************************/
	public function obtener_ventas()
	{
		//anual
		$pedidos = $this->M_dashboard->obt_ventas_canales();
		$id 		= array();
		$canal 		= array();
		$ingreso	= array();
		$anno 		= array();
		
		$contador= 0;
		$bandera = 0;
		$sistema =0;
		$total = 0;
		foreach ($pedidos->result() as $pr){			
			if($pr->id_canal == 4 || $pr->id_canal == 6 ){
				if($bandera == 0){
					$sistema = $contador;
					$bandera = 1;

					$id[$contador] 		= $contador;
					$anno[$contador] 	= $pr->anno;					
					$canal[$contador] 	= 'SISTEMA';
					$ingreso[$contador] = $pr->importe;

					$total = $total + $ingreso[$contador];
					$contador = $contador + 1;
				}else{
					$id[$sistema] 		= $sistema;
					$anno[$sistema] 	= $pr->anno;					
					$canal[$sistema] 	= 'SISTEMA';
					$ingreso[$sistema] 	= $ingreso[$sistema] + $pr->importe;

					$total = $total + $pr->importe;
				}
				
			}else{
				$id[$contador] 		= $contador;
				$anno[$contador] 	= $pr->anno;				
				$canal[$contador] 	= $pr->nombre;
				$ingreso[$contador] = $pr->importe;

				$total = $total + $ingreso[$contador];
				$contador = $contador + 1;
			}
		}
		/////////////////////// Mensual //////////////////
		$pedidos = $this->M_dashboard->obt_ventas_canales_mes();
		$id1 		= array();
		$canal1		= array();
		$ingreso1	= array();
		$anno1 		= array();
		$mes1 		= array();
		$id_mes1	= array();
		$total1		= array();
		
		$contador= 0;
		$bandera = 0;
		
		$flag = 0;
		
		foreach ($pedidos->result() as $pr){			
			if($bandera==0){
				$contador= 0;
				$bandera=1;
				$anterior=$pr->mes;
				$actual=$pr->mes;
			}else{
				$actual=$pr->mes;
			}
			
			if($anterior == $actual){				
				if($contador== 0){//es la primera vez					
					$total1[$pr->mes]		= $pr->importe;
				}else{
					$total1[$pr->mes]		= $total1[$pr->mes] + $pr->importe;
				}
			}else{				
				$total1[$pr->mes]		= $pr->importe;
				
			}
						
			
			if($anterior != $actual){	
				$flag = 0;	
			}
			if($pr->id_canal == 4 || $pr->id_canal == 6){
				if($flag == 0){
					$id1[$contador] 		= $contador;
					$anno1[$contador] 		= $pr->anno;		
					$id_mes1[$contador] 	= $pr->mes;
					$mes1[$contador] 		= $pr->nombre_mes;	
					$id_contador = $contador;
					$ingreso1[$contador] 	= $pr->importe;
					$canal1[$contador] 		= 'SISTEMA';
					$flag = 1;
					$contador = $contador + 1;
				}else{
					$ingreso1[$id_contador] 	= $ingreso1[$id_contador] + $pr->importe;					
				}
			}else{
				$id1[$contador] 		= $contador;
				$anno1[$contador] 		= $pr->anno;		
				$id_mes1[$contador] 	= $pr->mes;
				$mes1[$contador] 		= $pr->nombre_mes;	
				$canal1[$contador] 		= $pr->nombre;
				$ingreso1[$contador] 	= $pr->importe;
				$contador = $contador + 1;
			}		
			
			$anterior=$pr->mes;
			
		}	
		
		$datos['id1'] 		= $id1;
		$datos['anno1'] 	= $anno1;
		$datos['mes1'] 		= $mes1;
		$datos['id_mes1'] 	= $id_mes1;
		$datos['canal1'] 	= $canal1;
		$datos['ingreso1'] 	= $ingreso1;
		$datos['total1'] 	= $total1;

		///////////////////////////////////////////////////

		$datos['id'] 		= $id;
		$datos['anno'] 		= $anno;
		$datos['canal'] 	= $canal;
		$datos['ingreso'] 	= $ingreso;
		$datos['total'] 	= $total;

		$this->load->view('lte_header', $datos);
		$this->load->view('v_listado_venta_anual', $datos);
		$this->load->view('lte_footer', $datos);
		 
	}
	public function obtener_ventas_pdf()
	{
		//anual
		$pedidos = $this->M_dashboard->obt_ventas_canales();
		$id 		= array();
		$canal 		= array();
		$ingreso	= array();
		$anno 		= array();
		
		$contador= 0;
		$bandera = 0;
		$sistema =0;
		$total = 0;
		foreach ($pedidos->result() as $pr){			
			if($pr->id_canal == 4 || $pr->id_canal == 6 ){
				if($bandera == 0){
					$sistema = $contador;
					$bandera = 1;

					$id[$contador] 		= $contador;
					$anno[$contador] 	= $pr->anno;					
					$canal[$contador] 	= 'SISTEMA';
					$ingreso[$contador] = $pr->importe;

					$total = $total + $ingreso[$contador];
					$contador = $contador + 1;
				}else{
					$id[$sistema] 		= $sistema;
					$anno[$sistema] 	= $pr->anno;					
					$canal[$sistema] 	= 'SISTEMA';
					$ingreso[$sistema] 	= $ingreso[$sistema] + $pr->importe;

					$total = $total + $pr->importe;
				}
				
			}else{
				$id[$contador] 		= $contador;
				$anno[$contador] 	= $pr->anno;				
				$canal[$contador] 	= $pr->nombre;
				$ingreso[$contador] = $pr->importe;

				$total = $total + $ingreso[$contador];
				$contador = $contador + 1;
			}
		}
		/////////////////////// Mensual //////////////////
		$pedidos = $this->M_dashboard->obt_ventas_canales_mes();
		$id1 		= array();
		$canal1		= array();
		$ingreso1	= array();
		$anno1 		= array();
		$mes1 		= array();
		$id_mes1	= array();
		$total1		= array();
		
		$contador= 0;
		$bandera = 0;
		
		$flag = 0;
		
		foreach ($pedidos->result() as $pr){			
			if($bandera==0){
				$contador= 0;
				$bandera=1;
				$anterior=$pr->mes;
				$actual=$pr->mes;
			}else{
				$actual=$pr->mes;
			}
			
			if($anterior == $actual){				
				if($contador== 0){//es la primera vez					
					$total1[$pr->mes]		= $pr->importe;
				}else{
					$total1[$pr->mes]		= $total1[$pr->mes] + $pr->importe;
				}
			}else{				
				$total1[$pr->mes]		= $pr->importe;
				
			}
						
			
			if($anterior != $actual){	
				$flag = 0;	
			}
			if($pr->id_canal == 4 || $pr->id_canal == 6){
				if($flag == 0){
					$id1[$contador] 		= $contador;
					$anno1[$contador] 		= $pr->anno;		
					$id_mes1[$contador] 	= $pr->mes;
					$mes1[$contador] 		= $pr->nombre_mes;	
					$id_contador = $contador;
					$ingreso1[$contador] 	= $pr->importe;
					$canal1[$contador] 		= 'SISTEMA';
					$flag = 1;
					$contador = $contador + 1;
				}else{
					$ingreso1[$id_contador] 	= $ingreso1[$id_contador] + $pr->importe;					
				}
			}else{
				$id1[$contador] 		= $contador;
				$anno1[$contador] 		= $pr->anno;		
				$id_mes1[$contador] 	= $pr->mes;
				$mes1[$contador] 		= $pr->nombre_mes;	
				$canal1[$contador] 		= $pr->nombre;
				$ingreso1[$contador] 	= $pr->importe;
				$contador = $contador + 1;
			}		
			
			$anterior=$pr->mes;
			
		}	
		
		$datos['id1'] 		= $id1;
		$datos['anno1'] 	= $anno1;
		$datos['mes1'] 		= $mes1;
		$datos['id_mes1'] 	= $id_mes1;
		$datos['canal1'] 	= $canal1;
		$datos['ingreso1'] 	= $ingreso1;
		$datos['total1'] 	= $total1;

		///////////////////////////////////////////////////

		$datos['id'] 		= $id;
		$datos['anno'] 		= $anno;
		$datos['canal'] 	= $canal;
		$datos['ingreso'] 	= $ingreso;
		$datos['total'] 	= $total;

		$this->descargar_pdf('venta_anual','v_listado_venta_anual', $datos);
		/*$this->load->view('lte_header', $datos);
		$this->load->view('v_listado_venta_anual', $datos);
		$this->load->view('lte_footer', $datos);*/
		 
	}
	public function obt_ventas()
	{
		$prod = $this->M_dashboard->obt_ventas_canales();
        $row = $prod->result();
		echo json_encode($row);  
	}
	public function productos_anno(){
		$annos = $this->M_configuracion->obt_annos();
		$anno = date('Y');
		$datos['annos'] = $annos;
		$datos['anno'] = $anno;

		$this->load->view('lte_header', $datos);
		$this->load->view('v_reporte_producto_anno', $datos);
		$this->load->view('lte_footer', $datos);
	}
	public function productos_clientes(){
		$total= $this->M_dashboard->total_clientes();
		$annos = $this->M_configuracion->obt_annos();

		$datos['total'] 	= $total;
		$datos['annos'] 	= $annos;
		$anno = $this->input->post('anno');
		$datos['anno'] = $anno;

		$prod = Array();
		$cant = Array();

		$mes1 = Array();
		$mes2 = Array();
		$mes3 = Array();
		$mes4 = Array();
		$mes5 = Array();
		$mes6 = Array();
		$mes7 = Array();
		$mes8 = Array();
		$mes9 = Array();
		$mes10 = Array();
		$mes11 = Array();
		$mes12 = Array();
		//$mes13 = Array();

		$num_mes = Array();
		$mes_proceso =  1;
		for ($i=0; $i<12; $i++ ){
			$num_mes[$i]=$mes_proceso;
			$mes_proceso = $mes_proceso + 1;
			
		}
		
		$datos['num_mes'] 	= $num_mes;
		$cont=0;


		$productos = $this->M_dashboard->obt_productos();
		$productos_clientes = $this->M_dashboard->obt_productos_clientes($anno);

		foreach ($productos->result() as $pr){
			$prod[$cont] = $pr->nombre;
			$cant[$cont] = 0;
			
			$mes1[$cont] = 0;
			$mes2[$cont] = 0;
			$mes3[$cont] = 0;
			$mes4[$cont] = 0;
			$mes5[$cont] = 0;
			$mes6[$cont] = 0;
			$mes7[$cont] = 0;
			$mes8[$cont] = 0;
			$mes9[$cont] = 0;
			$mes10[$cont] = 0;
			$mes11[$cont] = 0;
			$mes12[$cont] = 0;
			//$mes13[$cont] = 0;
			$bandera = false;		
			$mes_proceso = 1;
			$anno_proceso = $anno;
			for ($i=0; $i<12; $i++ ){
				foreach ($productos_clientes->result() as $pc){
					if($pr->id_producto == $pc->id_producto && $pc->anno == $anno_proceso && $pc->mes == $mes_proceso ){
						switch ($i)
						{
							case 0  :
								$mes1[$cont] = $pc->cant_mensual;
								$cant[$cont] = $cant[$cont] + $pc->cant_mensual;
								
								if($mes1[$cont] != 0){
									$bandera = true;
								}
								break;
							case 1  :
								$mes2[$cont] = $pc->cant_mensual;
								$cant[$cont] = $cant[$cont] + $pc->cant_mensual;
								if($mes2[$cont] != 0){
									$bandera = true;
								}
								break;
							case 2  :
								$mes3[$cont] = $pc->cant_mensual;
								$cant[$cont] = $cant[$cont] + $pc->cant_mensual;
								if($mes3[$cont] != 0){
									$bandera = true;
								}
								break;
							case 3  :
								$mes4[$cont] = $pc->cant_mensual;
								$cant[$cont] = $cant[$cont] + $pc->cant_mensual;
								if($mes4[$cont] != 0){
									$bandera = true;
								}
								break;
							case 4  :
								$mes5[$cont] = $pc->cant_mensual;
								$cant[$cont] = $cant[$cont] + $pc->cant_mensual;
								if($mes5[$cont] != 0){
									$bandera = true;
								}
								break;							
							case 5  :
								$mes6[$cont] = $pc->cant_mensual;
								$cant[$cont] = $cant[$cont] + $pc->cant_mensual;
								if($mes6[$cont] != 0){
									$bandera = true;
								}
								break;
							case 6  :
								$mes7[$cont] = $pc->cant_mensual;
								$cant[$cont] = $cant[$cont] + $pc->cant_mensual;
								if($mes7[$cont] != 0){
									$bandera = true;
								}
								break;
							case 7  :
								$mes8[$cont] = $pc->cant_mensual;
								$cant[$cont] = $cant[$cont] + $pc->cant_mensual;
								if($mes8[$cont] != 0){
									$bandera = true;
								}
								break;
							case 8  :
								$mes9[$cont] = $pc->cant_mensual;
								$cant[$cont] = $cant[$cont] + $pc->cant_mensual;
								if($mes9[$cont] != 0){
									$bandera = true;
								}
								break;
							case 9  :
								$mes10[$cont] = $pc->cant_mensual;
								$cant[$cont] = $cant[$cont] + $pc->cant_mensual;
								if($mes10[$cont] != 0){
									$bandera = true;
								}
								break;
							case 10  :
								$mes11[$cont] = $pc->cant_mensual;
								$cant[$cont] = $cant[$cont] + $pc->cant_mensual;
								if($mes11[$cont] != 0){
									$bandera = true;
								}
								break;
							case 11  :
								$mes12[$cont] = $pc->cant_mensual;
								$cant[$cont] = $cant[$cont] + $pc->cant_mensual;
								if($mes12[$cont] != 0){
									$bandera = true;
								}
								break;
							/*case 12  :
								$mes13[$cont] = $pc->cant_mensual;
								if($mes13[$cont] != 0){
									$bandera = true;
								}
								break;*/
						}
					}
				}
				// incremento el mes a analizar
				$mes_proceso = $mes_proceso + 1;
				/*if($mes_proceso == 13){
					$mes_proceso =1;
					$anno_proceso = $anno_proceso+ 1;
				}*/
			}
			if($bandera){
				$cont = $cont + 1;
			}
			
		}
		$datos['prod'] 	= $prod;
		$datos['cant'] 	= $cant;
		$datos['mes1'] 	= $mes1;
		$datos['mes2'] 	= $mes2;
		$datos['mes3'] 	= $mes3;
		$datos['mes4'] 	= $mes4;
		$datos['mes5'] 	= $mes5;
		$datos['mes6'] 	= $mes6;
		$datos['mes7'] 	= $mes7;
		$datos['mes8'] 	= $mes8;
		$datos['mes9'] 	= $mes9;
		$datos['mes10'] = $mes10;
		$datos['mes11'] = $mes11;
		$datos['mes12'] = $mes12;
		//$datos['mes13'] = $mes13;

		$this->load->view('lte_header', $datos);
		$this->load->view('v_reporte_producto_clientes', $datos);
		$this->load->view('lte_footer', $datos);
	}
	public function productos_clientes_pdf($anno){
		$total= $this->M_dashboard->total_clientes();
		$annos = $this->M_configuracion->obt_annos();

		$datos['total'] 	= $total;
		$datos['annos'] 	= $annos;
		//$anno = $this->input->post('anno');
		$datos['anno'] = $anno;

		$prod = Array();
		$cant = Array();

		$mes1 = Array();
		$mes2 = Array();
		$mes3 = Array();
		$mes4 = Array();
		$mes5 = Array();
		$mes6 = Array();
		$mes7 = Array();
		$mes8 = Array();
		$mes9 = Array();
		$mes10 = Array();
		$mes11 = Array();
		$mes12 = Array();
		//$mes13 = Array();

		$num_mes = Array();
		$mes_proceso =  1;
		for ($i=0; $i<12; $i++ ){
			$num_mes[$i]=$mes_proceso;
			$mes_proceso = $mes_proceso + 1;
			
		}
		
		$datos['num_mes'] 	= $num_mes;
		$cont=0;


		$productos = $this->M_dashboard->obt_productos();
		$productos_clientes = $this->M_dashboard->obt_productos_clientes($anno);

		foreach ($productos->result() as $pr){
			$prod[$cont] = $pr->nombre;
			$cant[$cont] = 0;
			
			$mes1[$cont] = 0;
			$mes2[$cont] = 0;
			$mes3[$cont] = 0;
			$mes4[$cont] = 0;
			$mes5[$cont] = 0;
			$mes6[$cont] = 0;
			$mes7[$cont] = 0;
			$mes8[$cont] = 0;
			$mes9[$cont] = 0;
			$mes10[$cont] = 0;
			$mes11[$cont] = 0;
			$mes12[$cont] = 0;
			//$mes13[$cont] = 0;
			$bandera = false;		
			$mes_proceso = 1;
			$anno_proceso = $anno;
			for ($i=0; $i<12; $i++ ){
				foreach ($productos_clientes->result() as $pc){
					if($pr->id_producto == $pc->id_producto && $pc->anno == $anno_proceso && $pc->mes == $mes_proceso ){
						switch ($i)
						{
							case 0  :
								$mes1[$cont] = $pc->cant_mensual;
								$cant[$cont] = $cant[$cont] + $pc->cant_mensual;
								
								if($mes1[$cont] != 0){
									$bandera = true;
								}
								break;
							case 1  :
								$mes2[$cont] = $pc->cant_mensual;
								$cant[$cont] = $cant[$cont] + $pc->cant_mensual;
								if($mes2[$cont] != 0){
									$bandera = true;
								}
								break;
							case 2  :
								$mes3[$cont] = $pc->cant_mensual;
								$cant[$cont] = $cant[$cont] + $pc->cant_mensual;
								if($mes3[$cont] != 0){
									$bandera = true;
								}
								break;
							case 3  :
								$mes4[$cont] = $pc->cant_mensual;
								$cant[$cont] = $cant[$cont] + $pc->cant_mensual;
								if($mes4[$cont] != 0){
									$bandera = true;
								}
								break;
							case 4  :
								$mes5[$cont] = $pc->cant_mensual;
								$cant[$cont] = $cant[$cont] + $pc->cant_mensual;
								if($mes5[$cont] != 0){
									$bandera = true;
								}
								break;							
							case 5  :
								$mes6[$cont] = $pc->cant_mensual;
								$cant[$cont] = $cant[$cont] + $pc->cant_mensual;
								if($mes6[$cont] != 0){
									$bandera = true;
								}
								break;
							case 6  :
								$mes7[$cont] = $pc->cant_mensual;
								$cant[$cont] = $cant[$cont] + $pc->cant_mensual;
								if($mes7[$cont] != 0){
									$bandera = true;
								}
								break;
							case 7  :
								$mes8[$cont] = $pc->cant_mensual;
								$cant[$cont] = $cant[$cont] + $pc->cant_mensual;
								if($mes8[$cont] != 0){
									$bandera = true;
								}
								break;
							case 8  :
								$mes9[$cont] = $pc->cant_mensual;
								$cant[$cont] = $cant[$cont] + $pc->cant_mensual;
								if($mes9[$cont] != 0){
									$bandera = true;
								}
								break;
							case 9  :
								$mes10[$cont] = $pc->cant_mensual;
								$cant[$cont] = $cant[$cont] + $pc->cant_mensual;
								if($mes10[$cont] != 0){
									$bandera = true;
								}
								break;
							case 10  :
								$mes11[$cont] = $pc->cant_mensual;
								$cant[$cont] = $cant[$cont] + $pc->cant_mensual;
								if($mes11[$cont] != 0){
									$bandera = true;
								}
								break;
							case 11  :
								$mes12[$cont] = $pc->cant_mensual;
								$cant[$cont] = $cant[$cont] + $pc->cant_mensual;
								if($mes12[$cont] != 0){
									$bandera = true;
								}
								break;
							/*case 12  :
								$mes13[$cont] = $pc->cant_mensual;
								if($mes13[$cont] != 0){
									$bandera = true;
								}
								break;*/
						}
					}
				}
				// incremento el mes a analizar
				$mes_proceso = $mes_proceso + 1;
				/*if($mes_proceso == 13){
					$mes_proceso =1;
					$anno_proceso = $anno_proceso+ 1;
				}*/
			}
			if($bandera){
				$cont = $cont + 1;
			}
			
		}
		$datos['prod'] 	= $prod;
		$datos['cant'] 	= $cant;
		$datos['mes1'] 	= $mes1;
		$datos['mes2'] 	= $mes2;
		$datos['mes3'] 	= $mes3;
		$datos['mes4'] 	= $mes4;
		$datos['mes5'] 	= $mes5;
		$datos['mes6'] 	= $mes6;
		$datos['mes7'] 	= $mes7;
		$datos['mes8'] 	= $mes8;
		$datos['mes9'] 	= $mes9;
		$datos['mes10'] = $mes10;
		$datos['mes11'] = $mes11;
		$datos['mes12'] = $mes12;
		//$datos['mes13'] = $mes13;

		$this->descargar_pdf('producto_clientes','v_reporte_producto_clientes', $datos);
		/*$this->load->view('lte_header', $datos);
		$this->load->view('v_reporte_producto_clientes', $datos);
		$this->load->view('lte_footer', $datos);*/
	}
	public function productos_vendidos_anno(){
		$annos = $this->M_configuracion->obt_annos();
		$anno = date('Y');
		$datos['annos'] = $annos;
		$datos['anno'] = $anno;

		$this->load->view('lte_header', $datos);
		$this->load->view('v_reporte_producto_vendido_anno', $datos);
		$this->load->view('lte_footer', $datos);
	}
	public function productos_vendidos(){
		$total= $this->M_dashboard->total_clientes();
		$annos = $this->M_configuracion->obt_annos();

		$datos['total'] 	= $total;
		$datos['annos'] 	= $annos;
		$anno = $this->input->post('anno');
		$datos['anno'] = $anno;

		$prod = Array();
		$cant = Array();

		$mes1 = Array();
		$mes2 = Array();
		$mes3 = Array();
		$mes4 = Array();
		$mes5 = Array();
		$mes6 = Array();
		$mes7 = Array();
		$mes8 = Array();
		$mes9 = Array();
		$mes10 = Array();
		$mes11 = Array();
		$mes12 = Array();
		
		$prodr = Array();
		$cantr = Array();

		$mes1r = Array();
		$mes2r = Array();
		$mes3r = Array();
		$mes4r = Array();
		$mes5r = Array();
		$mes6r = Array();
		$mes7r = Array();
		$mes8r = Array();
		$mes9r = Array();
		$mes10r = Array();
		$mes11r = Array();
		$mes12r = Array();

		$num_mes = Array();
		$mes_proceso =  1;
		for ($i=0; $i<12; $i++ ){
			$num_mes[$i]=$mes_proceso;
			$mes_proceso = $mes_proceso + 1;
			
		}
		
		$datos['num_mes'] 	= $num_mes;
		$cont=0;


		$productos = $this->M_dashboard->obt_productos();
		$productos_clientes = $this->M_dashboard->obt_productos_vendidos($anno);
		$repuestos_clientes = $this->M_dashboard->obt_repuestos_vendidos($anno);

		foreach ($productos->result() as $pr){
			$prod[$cont] = $pr->nombre;
			$cant[$cont] = 0;
			
			$mes1[$cont] = 0;
			$mes2[$cont] = 0;
			$mes3[$cont] = 0;
			$mes4[$cont] = 0;
			$mes5[$cont] = 0;
			$mes6[$cont] = 0;
			$mes7[$cont] = 0;
			$mes8[$cont] = 0;
			$mes9[$cont] = 0;
			$mes10[$cont] = 0;
			$mes11[$cont] = 0;
			$mes12[$cont] = 0;
			//$mes13[$cont] = 0;
			$bandera = false;		
			$mes_proceso = 1;
			$anno_proceso = $anno;
			for ($i=0; $i<12; $i++ ){
				foreach ($productos_clientes->result() as $pc){
					if($pr->id_producto == $pc->id_producto && $pc->anno == $anno_proceso && $pc->mes == $mes_proceso ){
						switch ($i)
						{
							case 0  :
								$mes1[$cont] = $pc->cant_mensual;
								$cant[$cont] = $cant[$cont] + $pc->cant_mensual;
								
								if($mes1[$cont] != 0){
									$bandera = true;
								}
								break;
							case 1  :
								$mes2[$cont] = $pc->cant_mensual;
								$cant[$cont] = $cant[$cont] + $pc->cant_mensual;
								if($mes2[$cont] != 0){
									$bandera = true;
								}
								break;
							case 2  :
								$mes3[$cont] = $pc->cant_mensual;
								$cant[$cont] = $cant[$cont] + $pc->cant_mensual;
								if($mes3[$cont] != 0){
									$bandera = true;
								}
								break;
							case 3  :
								$mes4[$cont] = $pc->cant_mensual;
								$cant[$cont] = $cant[$cont] + $pc->cant_mensual;
								if($mes4[$cont] != 0){
									$bandera = true;
								}
								break;
							case 4  :
								$mes5[$cont] = $pc->cant_mensual;
								$cant[$cont] = $cant[$cont] + $pc->cant_mensual;
								if($mes5[$cont] != 0){
									$bandera = true;
								}
								break;							
							case 5  :
								$mes6[$cont] = $pc->cant_mensual;
								$cant[$cont] = $cant[$cont] + $pc->cant_mensual;
								if($mes6[$cont] != 0){
									$bandera = true;
								}
								break;
							case 6  :
								$mes7[$cont] = $pc->cant_mensual;
								$cant[$cont] = $cant[$cont] + $pc->cant_mensual;
								if($mes7[$cont] != 0){
									$bandera = true;
								}
								break;
							case 7  :
								$mes8[$cont] = $pc->cant_mensual;
								$cant[$cont] = $cant[$cont] + $pc->cant_mensual;
								if($mes8[$cont] != 0){
									$bandera = true;
								}
								break;
							case 8  :
								$mes9[$cont] = $pc->cant_mensual;
								$cant[$cont] = $cant[$cont] + $pc->cant_mensual;
								if($mes9[$cont] != 0){
									$bandera = true;
								}
								break;
							case 9  :
								$mes10[$cont] = $pc->cant_mensual;
								$cant[$cont] = $cant[$cont] + $pc->cant_mensual;
								if($mes10[$cont] != 0){
									$bandera = true;
								}
								break;
							case 10  :
								$mes11[$cont] = $pc->cant_mensual;
								$cant[$cont] = $cant[$cont] + $pc->cant_mensual;
								if($mes11[$cont] != 0){
									$bandera = true;
								}
								break;
							case 11  :
								$mes12[$cont] = $pc->cant_mensual;
								$cant[$cont] = $cant[$cont] + $pc->cant_mensual;
								if($mes12[$cont] != 0){
									$bandera = true;
								}
								break;
							/*case 12  :
								$mes13[$cont] = $pc->cant_mensual;
								if($mes13[$cont] != 0){
									$bandera = true;
								}
								break;*/
						}
					}
				}
				// incremento el mes a analizar
				$mes_proceso = $mes_proceso + 1;
				/*if($mes_proceso == 13){
					$mes_proceso =1;
					$anno_proceso = $anno_proceso+ 1;
				}*/
			}
			if($bandera){
				$cont = $cont + 1;
			}
			
		}
		$cont=0;
		$productos = $this->M_dashboard->obt_repuestos();
		foreach ($productos->result() as $pr){
			$prodr[$cont] = $pr->nombre;
			$cantr[$cont] = 0;
			
			$mes1r[$cont] = 0;
			$mes2r[$cont] = 0;
			$mes3r[$cont] = 0;
			$mes4r[$cont] = 0;
			$mes5r[$cont] = 0;
			$mes6r[$cont] = 0;
			$mes7r[$cont] = 0;
			$mes8r[$cont] = 0;
			$mes9r[$cont] = 0;
			$mes10r[$cont] = 0;
			$mes11r[$cont] = 0;
			$mes12r[$cont] = 0;
			//$mes13[$cont] = 0;
			$bandera = false;		
			$mes_proceso = 1;
			$anno_proceso = $anno;
			for ($i=0; $i<12; $i++ ){
				foreach ($repuestos_clientes->result() as $pc){
					if($pr->id_producto == $pc->id_producto && $pc->anno == $anno_proceso && $pc->mes == $mes_proceso ){
						switch ($i)
						{
							case 0  :
								$mes1r[$cont] = $pc->cant_mensual;
								$cantr[$cont] = $cantr[$cont] + $pc->cant_mensual;
								
								if($mes1r[$cont] != 0){
									$bandera = true;
								}
								break;
							case 1  :
								$mes2r[$cont] = $pc->cant_mensual;
								$cantr[$cont] = $cantr[$cont] + $pc->cant_mensual;
								if($mes2r[$cont] != 0){
									$bandera = true;
								}
								break;
							case 2  :
								$mes3r[$cont] = $pc->cant_mensual;
								$cantr[$cont] = $cantr[$cont] + $pc->cant_mensual;
								if($mes3r[$cont] != 0){
									$bandera = true;
								}
								break;
							case 3  :
								$mes4r[$cont] = $pc->cant_mensual;
								$cantr[$cont] = $cantr[$cont] + $pc->cant_mensual;
								if($mes4r[$cont] != 0){
									$bandera = true;
								}
								break;
							case 4  :
								$mes5r[$cont] = $pc->cant_mensual;
								$cantr[$cont] = $cantr[$cont] + $pc->cant_mensual;
								if($mes5r[$cont] != 0){
									$bandera = true;
								}
								break;							
							case 5  :
								$mes6r[$cont] = $pc->cant_mensual;
								$cantr[$cont] = $cantr[$cont] + $pc->cant_mensual;
								if($mes6r[$cont] != 0){
									$bandera = true;
								}
								break;
							case 6  :
								$mes7r[$cont] = $pc->cant_mensual;
								$cantr[$cont] = $cantr[$cont] + $pc->cant_mensual;
								if($mes7r[$cont] != 0){
									$bandera = true;
								}
								break;
							case 7  :
								$mes8r[$cont] = $pc->cant_mensual;
								$cantr[$cont] = $cantr[$cont] + $pc->cant_mensual;
								if($mes8r[$cont] != 0){
									$bandera = true;
								}
								break;
							case 8  :
								$mes9r[$cont] = $pc->cant_mensual;
								$cantr[$cont] = $cantr[$cont] + $pc->cant_mensual;
								if($mes9r[$cont] != 0){
									$bandera = true;
								}
								break;
							case 9  :
								$mes10r[$cont] = $pc->cant_mensual;
								$cantr[$cont] = $cantr[$cont] + $pc->cant_mensual;
								if($mes10r[$cont] != 0){
									$bandera = true;
								}
								break;
							case 10  :
								$mes11r[$cont] = $pc->cant_mensual;
								$cantr[$cont] = $cantr[$cont] + $pc->cant_mensual;
								if($mes11r[$cont] != 0){
									$bandera = true;
								}
								break;
							case 11  :
								$mes12r[$cont] = $pc->cant_mensual;
								$cantr[$cont] = $cantr[$cont] + $pc->cant_mensual;
								if($mes12r[$cont] != 0){
									$bandera = true;
								}
								break;
							/*case 12  :
								$mes13[$cont] = $pc->cant_mensual;
								if($mes13[$cont] != 0){
									$bandera = true;
								}
								break;*/
						}
					}
				}
				// incremento el mes a analizar
				$mes_proceso = $mes_proceso + 1;
				/*if($mes_proceso == 13){
					$mes_proceso =1;
					$anno_proceso = $anno_proceso+ 1;
				}*/
			}
			if($bandera){
				$cont = $cont + 1;
			}
			
		}

		$datos['prod'] 	= $prod;
		$datos['cant'] 	= $cant;
		$datos['mes1'] 	= $mes1;
		$datos['mes2'] 	= $mes2;
		$datos['mes3'] 	= $mes3;
		$datos['mes4'] 	= $mes4;
		$datos['mes5'] 	= $mes5;
		$datos['mes6'] 	= $mes6;
		$datos['mes7'] 	= $mes7;
		$datos['mes8'] 	= $mes8;
		$datos['mes9'] 	= $mes9;
		$datos['mes10'] = $mes10;
		$datos['mes11'] = $mes11;
		$datos['mes12'] = $mes12;
		//$datos['mes13'] = $mes13;
		$datos['prodr'] 	= $prodr;
		$datos['cantr'] 	= $cantr;
		$datos['mes1r'] 	= $mes1r;
		$datos['mes2r'] 	= $mes2r;
		$datos['mes3r'] 	= $mes3r;
		$datos['mes4r'] 	= $mes4r;
		$datos['mes5r'] 	= $mes5r;
		$datos['mes6r'] 	= $mes6r;
		$datos['mes7r'] 	= $mes7r;
		$datos['mes8r'] 	= $mes8r;
		$datos['mes9r'] 	= $mes9r;
		$datos['mes10r'] 	= $mes10r;
		$datos['mes11r'] 	= $mes11r;
		$datos['mes12r'] 	= $mes12r;

		//$this->descargar_pdf('prueba','v_reporte_producto_vendidos', $datos);	

		$this->load->view('lte_header', $datos);
		$this->load->view('v_reporte_producto_vendidos', $datos);
		$this->load->view('lte_footer', $datos);
		
	}
	public function productos_vendidos_pdf($anno){
		$total= $this->M_dashboard->total_clientes();
		$annos = $this->M_configuracion->obt_annos();

		$datos['total'] 	= $total;
		$datos['annos'] 	= $annos;
		//$anno = $this->input->post('anno');
		$datos['anno'] = $anno;

		$prod = Array();
		$cant = Array();

		$mes1 = Array();
		$mes2 = Array();
		$mes3 = Array();
		$mes4 = Array();
		$mes5 = Array();
		$mes6 = Array();
		$mes7 = Array();
		$mes8 = Array();
		$mes9 = Array();
		$mes10 = Array();
		$mes11 = Array();
		$mes12 = Array();
		
		$prodr = Array();
		$cantr = Array();

		$mes1r = Array();
		$mes2r = Array();
		$mes3r = Array();
		$mes4r = Array();
		$mes5r = Array();
		$mes6r = Array();
		$mes7r = Array();
		$mes8r = Array();
		$mes9r = Array();
		$mes10r = Array();
		$mes11r = Array();
		$mes12r = Array();

		$num_mes = Array();
		$mes_proceso =  1;
		for ($i=0; $i<12; $i++ ){
			$num_mes[$i]=$mes_proceso;
			$mes_proceso = $mes_proceso + 1;
			
		}
		
		$datos['num_mes'] 	= $num_mes;
		$cont=0;


		$productos = $this->M_dashboard->obt_productos();
		$productos_clientes = $this->M_dashboard->obt_productos_vendidos($anno);
		$repuestos_clientes = $this->M_dashboard->obt_repuestos_vendidos($anno);

		foreach ($productos->result() as $pr){
			$prod[$cont] = $pr->nombre;
			$cant[$cont] = 0;
			
			$mes1[$cont] = 0;
			$mes2[$cont] = 0;
			$mes3[$cont] = 0;
			$mes4[$cont] = 0;
			$mes5[$cont] = 0;
			$mes6[$cont] = 0;
			$mes7[$cont] = 0;
			$mes8[$cont] = 0;
			$mes9[$cont] = 0;
			$mes10[$cont] = 0;
			$mes11[$cont] = 0;
			$mes12[$cont] = 0;
			//$mes13[$cont] = 0;
			$bandera = false;		
			$mes_proceso = 1;
			$anno_proceso = $anno;
			for ($i=0; $i<12; $i++ ){
				foreach ($productos_clientes->result() as $pc){
					if($pr->id_producto == $pc->id_producto && $pc->anno == $anno_proceso && $pc->mes == $mes_proceso ){
						switch ($i)
						{
							case 0  :
								$mes1[$cont] = $pc->cant_mensual;
								$cant[$cont] = $cant[$cont] + $pc->cant_mensual;
								
								if($mes1[$cont] != 0){
									$bandera = true;
								}
								break;
							case 1  :
								$mes2[$cont] = $pc->cant_mensual;
								$cant[$cont] = $cant[$cont] + $pc->cant_mensual;
								if($mes2[$cont] != 0){
									$bandera = true;
								}
								break;
							case 2  :
								$mes3[$cont] = $pc->cant_mensual;
								$cant[$cont] = $cant[$cont] + $pc->cant_mensual;
								if($mes3[$cont] != 0){
									$bandera = true;
								}
								break;
							case 3  :
								$mes4[$cont] = $pc->cant_mensual;
								$cant[$cont] = $cant[$cont] + $pc->cant_mensual;
								if($mes4[$cont] != 0){
									$bandera = true;
								}
								break;
							case 4  :
								$mes5[$cont] = $pc->cant_mensual;
								$cant[$cont] = $cant[$cont] + $pc->cant_mensual;
								if($mes5[$cont] != 0){
									$bandera = true;
								}
								break;							
							case 5  :
								$mes6[$cont] = $pc->cant_mensual;
								$cant[$cont] = $cant[$cont] + $pc->cant_mensual;
								if($mes6[$cont] != 0){
									$bandera = true;
								}
								break;
							case 6  :
								$mes7[$cont] = $pc->cant_mensual;
								$cant[$cont] = $cant[$cont] + $pc->cant_mensual;
								if($mes7[$cont] != 0){
									$bandera = true;
								}
								break;
							case 7  :
								$mes8[$cont] = $pc->cant_mensual;
								$cant[$cont] = $cant[$cont] + $pc->cant_mensual;
								if($mes8[$cont] != 0){
									$bandera = true;
								}
								break;
							case 8  :
								$mes9[$cont] = $pc->cant_mensual;
								$cant[$cont] = $cant[$cont] + $pc->cant_mensual;
								if($mes9[$cont] != 0){
									$bandera = true;
								}
								break;
							case 9  :
								$mes10[$cont] = $pc->cant_mensual;
								$cant[$cont] = $cant[$cont] + $pc->cant_mensual;
								if($mes10[$cont] != 0){
									$bandera = true;
								}
								break;
							case 10  :
								$mes11[$cont] = $pc->cant_mensual;
								$cant[$cont] = $cant[$cont] + $pc->cant_mensual;
								if($mes11[$cont] != 0){
									$bandera = true;
								}
								break;
							case 11  :
								$mes12[$cont] = $pc->cant_mensual;
								$cant[$cont] = $cant[$cont] + $pc->cant_mensual;
								if($mes12[$cont] != 0){
									$bandera = true;
								}
								break;
							/*case 12  :
								$mes13[$cont] = $pc->cant_mensual;
								if($mes13[$cont] != 0){
									$bandera = true;
								}
								break;*/
						}
					}
				}
				// incremento el mes a analizar
				$mes_proceso = $mes_proceso + 1;
				/*if($mes_proceso == 13){
					$mes_proceso =1;
					$anno_proceso = $anno_proceso+ 1;
				}*/
			}
			if($bandera){
				$cont = $cont + 1;
			}
			
		}
		$cont=0;
		$productos = $this->M_dashboard->obt_repuestos();
		foreach ($productos->result() as $pr){
			$prodr[$cont] = $pr->nombre;
			$cantr[$cont] = 0;
			
			$mes1r[$cont] = 0;
			$mes2r[$cont] = 0;
			$mes3r[$cont] = 0;
			$mes4r[$cont] = 0;
			$mes5r[$cont] = 0;
			$mes6r[$cont] = 0;
			$mes7r[$cont] = 0;
			$mes8r[$cont] = 0;
			$mes9r[$cont] = 0;
			$mes10r[$cont] = 0;
			$mes11r[$cont] = 0;
			$mes12r[$cont] = 0;
			//$mes13[$cont] = 0;
			$bandera = false;		
			$mes_proceso = 1;
			$anno_proceso = $anno;
			for ($i=0; $i<12; $i++ ){
				foreach ($repuestos_clientes->result() as $pc){
					if($pr->id_producto == $pc->id_producto && $pc->anno == $anno_proceso && $pc->mes == $mes_proceso ){
						switch ($i)
						{
							case 0  :
								$mes1r[$cont] = $pc->cant_mensual;
								$cantr[$cont] = $cantr[$cont] + $pc->cant_mensual;
								
								if($mes1r[$cont] != 0){
									$bandera = true;
								}
								break;
							case 1  :
								$mes2r[$cont] = $pc->cant_mensual;
								$cantr[$cont] = $cantr[$cont] + $pc->cant_mensual;
								if($mes2r[$cont] != 0){
									$bandera = true;
								}
								break;
							case 2  :
								$mes3r[$cont] = $pc->cant_mensual;
								$cantr[$cont] = $cantr[$cont] + $pc->cant_mensual;
								if($mes3r[$cont] != 0){
									$bandera = true;
								}
								break;
							case 3  :
								$mes4r[$cont] = $pc->cant_mensual;
								$cantr[$cont] = $cantr[$cont] + $pc->cant_mensual;
								if($mes4r[$cont] != 0){
									$bandera = true;
								}
								break;
							case 4  :
								$mes5r[$cont] = $pc->cant_mensual;
								$cantr[$cont] = $cantr[$cont] + $pc->cant_mensual;
								if($mes5r[$cont] != 0){
									$bandera = true;
								}
								break;							
							case 5  :
								$mes6r[$cont] = $pc->cant_mensual;
								$cantr[$cont] = $cantr[$cont] + $pc->cant_mensual;
								if($mes6r[$cont] != 0){
									$bandera = true;
								}
								break;
							case 6  :
								$mes7r[$cont] = $pc->cant_mensual;
								$cantr[$cont] = $cantr[$cont] + $pc->cant_mensual;
								if($mes7r[$cont] != 0){
									$bandera = true;
								}
								break;
							case 7  :
								$mes8r[$cont] = $pc->cant_mensual;
								$cantr[$cont] = $cantr[$cont] + $pc->cant_mensual;
								if($mes8r[$cont] != 0){
									$bandera = true;
								}
								break;
							case 8  :
								$mes9r[$cont] = $pc->cant_mensual;
								$cantr[$cont] = $cantr[$cont] + $pc->cant_mensual;
								if($mes9r[$cont] != 0){
									$bandera = true;
								}
								break;
							case 9  :
								$mes10r[$cont] = $pc->cant_mensual;
								$cantr[$cont] = $cantr[$cont] + $pc->cant_mensual;
								if($mes10r[$cont] != 0){
									$bandera = true;
								}
								break;
							case 10  :
								$mes11r[$cont] = $pc->cant_mensual;
								$cantr[$cont] = $cantr[$cont] + $pc->cant_mensual;
								if($mes11r[$cont] != 0){
									$bandera = true;
								}
								break;
							case 11  :
								$mes12r[$cont] = $pc->cant_mensual;
								$cantr[$cont] = $cantr[$cont] + $pc->cant_mensual;
								if($mes12r[$cont] != 0){
									$bandera = true;
								}
								break;
							/*case 12  :
								$mes13[$cont] = $pc->cant_mensual;
								if($mes13[$cont] != 0){
									$bandera = true;
								}
								break;*/
						}
					}
				}
				// incremento el mes a analizar
				$mes_proceso = $mes_proceso + 1;
				/*if($mes_proceso == 13){
					$mes_proceso =1;
					$anno_proceso = $anno_proceso+ 1;
				}*/
			}
			if($bandera){
				$cont = $cont + 1;
			}
			
		}

		$datos['prod'] 	= $prod;
		$datos['cant'] 	= $cant;
		$datos['mes1'] 	= $mes1;
		$datos['mes2'] 	= $mes2;
		$datos['mes3'] 	= $mes3;
		$datos['mes4'] 	= $mes4;
		$datos['mes5'] 	= $mes5;
		$datos['mes6'] 	= $mes6;
		$datos['mes7'] 	= $mes7;
		$datos['mes8'] 	= $mes8;
		$datos['mes9'] 	= $mes9;
		$datos['mes10'] = $mes10;
		$datos['mes11'] = $mes11;
		$datos['mes12'] = $mes12;
		//$datos['mes13'] = $mes13;
		$datos['prodr'] 	= $prodr;
		$datos['cantr'] 	= $cantr;
		$datos['mes1r'] 	= $mes1r;
		$datos['mes2r'] 	= $mes2r;
		$datos['mes3r'] 	= $mes3r;
		$datos['mes4r'] 	= $mes4r;
		$datos['mes5r'] 	= $mes5r;
		$datos['mes6r'] 	= $mes6r;
		$datos['mes7r'] 	= $mes7r;
		$datos['mes8r'] 	= $mes8r;
		$datos['mes9r'] 	= $mes9r;
		$datos['mes10r'] 	= $mes10r;
		$datos['mes11r'] 	= $mes11r;
		$datos['mes12r'] 	= $mes12r;

		$this->descargar_pdf('prueba','v_reporte_producto_vendidos', $datos);	

		/*$this->load->view('lte_header', $datos);
		$this->load->view('v_reporte_producto_vendidos', $datos);
		$this->load->view('lte_footer', $datos);*/
		
	}
	public function reposicion(){
		$productos = $this->M_dashboard->obt_productos();
		$total_bd= $this->M_dashboard->total_bd();
		$total_clientes= $this->M_dashboard->total_clientes();
		$reposiciones = $this->M_dashboard->obt_reposiciones();
		$cant_total=0;
		$prod = Array();
		$cant = Array();
		$porc = Array();

		foreach ($reposiciones->result() as $pc){			
				$cant_total = $cant_total + $pc->cantidad;			
		}
		$cont = 0;
		foreach ($productos->result() as $pr){
			$prod[$cont] = $pr->nombre;
			$cant[$cont] = 0;
			$porc[$cont] = 0;
		
			foreach ($reposiciones->result() as $pc){
				if($pr->id_producto == $pc->id_producto ){
					$cant[$cont] = $pc->cantidad;
					$porc[$cont] = round(($pc->cantidad/$cant_total)*100,2);
				}
			}
			if($cant[$cont]>0){
				$cont = $cont + 1;
			}
						
			
		}
		$prod[$cont] = 'TOTAL';
		$cant[$cont] = $cant_total;
		$porc[$cont] = '100% /'. $cant_total;

		$datos['prod'] 			= $prod;
		$datos['cant'] 			= $cant;
		$datos['porc'] 			= $porc;
		$datos['cant_total'] 	= $cant_total;
		$datos['total_bd'] 		= $total_bd;
		$datos['total_clientes'] = $total_clientes;

		$this->load->view('lte_header', $datos);
		$this->load->view('v_reporte_reposicion', $datos);
		$this->load->view('lte_footer', $datos);
	}
	public function reposicion_pdf(){
		$productos = $this->M_dashboard->obt_productos();
		$total_bd= $this->M_dashboard->total_bd();
		$total_clientes= $this->M_dashboard->total_clientes();
		$reposiciones = $this->M_dashboard->obt_reposiciones();
		$cant_total=0;
		$prod = Array();
		$cant = Array();
		$porc = Array();

		foreach ($reposiciones->result() as $pc){			
				$cant_total = $cant_total + $pc->cantidad;			
		}
		$cont = 0;
		foreach ($productos->result() as $pr){
			$prod[$cont] = $pr->nombre;
			$cant[$cont] = 0;
			$porc[$cont] = 0;
		
			foreach ($reposiciones->result() as $pc){
				if($pr->id_producto == $pc->id_producto ){
					$cant[$cont] = $pc->cantidad;
					$porc[$cont] = round(($pc->cantidad/$cant_total)*100,2);
				}
			}
			if($cant[$cont]>0){
				$cont = $cont + 1;
			}
						
			
		}
		$prod[$cont] = 'TOTAL';
		$cant[$cont] = $cant_total;
		$porc[$cont] = '100% /'. $cant_total;

		$datos['prod'] 			= $prod;
		$datos['cant'] 			= $cant;
		$datos['porc'] 			= $porc;
		$datos['cant_total'] 	= $cant_total;
		$datos['total_bd'] 		= $total_bd;
		$datos['total_clientes'] = $total_clientes;

		$this->descargar_pdf('reporte_reposicion','v_reporte_reposicion', $datos);
		/*$this->load->view('lte_header', $datos);
		$this->load->view('v_reporte_reposicion', $datos);
		$this->load->view('lte_footer', $datos);*/
	}
	public function ventas_despachos()
	{		
		$ingresos_resumen 	= $this->M_operaciones->obt_ingresos_resumen();	
		$datos['meses'] 	= $this->M_configuracion->obt_meses();
		$datos['annos'] 	= $this->M_configuracion->obt_annos();
		$mes 				= date('m');
		$datos['mes'] 		= $mes;
		$anno 				= date('Y');
		$datos['anno'] 		= $anno;
		$dia      	 		= 0;
		$datos['dia'] 		= $dia;

		$ventas 			= $this->M_dashboard->obt_ventas_despachos($anno, $mes, $dia);	
        $datos['ventas'] 	= $ventas;

		$this->load->view('lte_header', $datos);
		$this->load->view('v_listado_despachadores', $datos);
		$this->load->view('lte_footer', $datos);

	}
	public function ventas_despachos_filtrados()
	{		
		$ingresos_resumen 	= $this->M_operaciones->obt_ingresos_resumen();	
		$datos['meses'] 	= $this->M_configuracion->obt_meses();
		$datos['annos'] 	= $this->M_configuracion->obt_annos();
		$mes 				= $this->input->post('mes');
		$datos['mes'] 		= $mes;
		$anno 		 		= $this->input->post('anno');
		$datos['anno'] 		= $anno;
		$dia 				= $this->input->post('dia');
		$datos['dia'] 		= $dia;

		$ventas 			= $this->M_dashboard->obt_ventas_despachos($anno, $mes, $dia);	
        $datos['ventas'] 	= $ventas;

		$this->load->view('lte_header', $datos);
		$this->load->view('v_listado_despachadores', $datos);
		$this->load->view('lte_footer', $datos);

	}
	public function ventas_despachos_filtrados_pdf($anno, $mes, $dia)
	{		
		$ingresos_resumen 	= $this->M_operaciones->obt_ingresos_resumen();	
		$datos['meses'] 	= $this->M_configuracion->obt_meses();
		$datos['annos'] 	= $this->M_configuracion->obt_annos();
		//$mes 				= $this->input->post('mes');
		$datos['mes'] 		= $mes;
		//$anno 		 		= $this->input->post('anno');
		$datos['anno'] 		= $anno;
		//$dia 				= $this->input->post('dia');
		$datos['dia'] 		= $dia;

		$ventas 			= $this->M_dashboard->obt_ventas_despachos($anno, $mes, $dia);	
        $datos['ventas'] 	= $ventas;

		$this->descargar_pdf('listado_despachadores','v_listado_despachadores', $datos);
		/*$this->load->view('lte_header', $datos);
		$this->load->view('v_listado_despachadores', $datos);
		$this->load->view('lte_footer', $datos);*/

	}
	public function promociones()
	{
		$promociones 	= $this->M_dashboard->obt_promociones();
		$productos 		= $this->M_dashboard->obt_productos_promociones();
		
		$datos['promociones'] 	= $promociones;
		$datos['productos'] 	= $productos;

		$this->load->view('lte_header', $datos);
		$this->load->view('v_reporte_promocion', $datos);
		$this->load->view('lte_footer', $datos);	
	}
	public function promociones_rev()
	{
		$promociones 	= $this->M_dashboard->obt_promociones_rev();
		$productos 		= $this->M_dashboard->obt_productos_promociones_rev();
		
		$datos['promociones'] 	= $promociones;
		$datos['productos'] 	= $productos;

		$this->load->view('lte_header', $datos);
		$this->load->view('v_reporte_promocion', $datos);
		$this->load->view('lte_footer', $datos);	
	}
	public function descargar_pdf($nombre,$reporte, $datos)    
	{
		$this->load->library('M_pdf');

		$hoy =date("dmyhis");                
		$html =$this->load->view($reporte, $datos,true);        
		$pdfFilePath = $nombre . $hoy .".pdf";        
		//load mPDF library        $this->load->library('M_pdf');
		
    	$mpdf = new mPDF('c', 'A4');        
		$mpdf->WriteHTML($html);
		$mpdf->Output($pdfFilePath, "D");            
	}
	public function obtener_objetivos($anno, $mes)
	{
		$user = $this->ion_auth->user()->row();
		$usuario = $user->id;
		$obj = $this->M_dashboard->obtener_llamadas($usuario, $anno, $mes);
        $row = $obj->result();
		echo json_encode($row); 	
	}
	public function obtener_conversion($anno, $mes)
	{
		$user = $this->ion_auth->user()->row();
		$usuario = $user->id;
		$obj = $this->M_dashboard->obtener_conversion($usuario, $anno, $mes);
        $row = $obj->result();
		echo json_encode($row); 	
	}
	public function reportes()
	{	
		$tiempo_inicio = $this->M_configuracion->microtime_float();
		$datos['anno'] 	= date('Y');
		$clientes_atendidos=0;
		$clientes_no_atendidos=0;
		$clientes_atendidos_mcoy=0;
		$clientes_no_atendidos_mcoy=0;
		$clientes_atendidos_vip=0;
		$clientes_no_atendidos_vip=0;
		$misiones = $this->M_configuracion->misiones_propuestas_dvigi();
		ini_set("memory_limit","512M");
		$misiones_mcoy = $this->M_configuracion->misiones_propuestas_mcoy();
		$misiones_vip = $this->M_configuracion->misiones_propuestas_vip1();
		$solicitudes_baja = $this->M_configuracion->baja_pendientes();
		$misiones_activas1 = $this->M_configuracion->obt_mision_activas();

		
		$total_clientes=$misiones->num_rows();
		foreach ($misiones->result() as $key) {
			# code...
			if($key->fecha_vcto > date('Y-m-d H:i:s')){
				$clientes_atendidos++;
			}else{
				$clientes_no_atendidos++;
			}
		}
		$total_clientes_mcoy=$misiones_mcoy->num_rows();
		foreach ($misiones_mcoy->result() as $key) {
			# code...
			if($key->fecha_vcto > date('Y-m-d H:i:s')){
				$clientes_atendidos_mcoy++;
			}else{
				$clientes_no_atendidos_mcoy++;
			}
		}
		$total_clientes_vip=$misiones_vip->num_rows();
		foreach ($misiones_vip->result() as $key) {
			# code...
			if($key->fecha_vcto > date('Y-m-d H:i:s')){
				$clientes_atendidos_vip++;
			}else{
				$clientes_no_atendidos_vip++;
			}
		}
		/*for ($i=0; $i<count($id); $i++ ){
			if (($fec_compra[$i]) <=date("Y-m-d H:i:s",mktime(0,0,0,date("m")-$vencimiento[$i],date("d"), date("Y")))){
				
				$clientes_no_atendidos++;
			}else{
				$clientes_atendidos++;
			}
		}*/
		$datos['clientes_no_atendidos'] 	= $clientes_no_atendidos;				
		$datos['clientes_atendidos'] 		= $clientes_atendidos;
		$datos['clientes_no_atendidos_mcoy'] = $clientes_no_atendidos_mcoy;				
		$datos['clientes_atendidos_mcoy'] 	= $clientes_atendidos_mcoy;
		$datos['clientes_no_atendidos_vip'] = $clientes_no_atendidos_vip;				
		$datos['clientes_atendidos_vip'] 	= $clientes_atendidos_vip;

		$datos['total_clientes'] 			= $total_clientes;
		$datos['total_clientes_mcoy'] 		= $total_clientes_mcoy;
		$datos['total_clientes_vip'] 		= $total_clientes_vip;

		$rep_detalle_res = $this->M_dashboard->obtener_consultores_res();
		$datos['consultores'] 		= $rep_detalle_res;
		$row= $rep_detalle_res->result();
		$datos['id_usuario'] 		= $row[0]->id_usuario;
		$datos['usuario'] 		= $row[0]->usuario;
		
		$tiempo_fin = $this->M_configuracion->microtime_float();
		$tiempo = $tiempo_fin - $tiempo_inicio;
		
		$datos['tiempo'] = $tiempo;
		$this->load->view('lte_header', $datos);
		$this->load->view('v_reporte', $datos);
		$this->load->view('lte_footer', $datos);	
	}
	public function reportes_consultor()
	{	
		$user = $this->ion_auth->user()->row();
		$usuario = $user->id;
		$anno 	= date('Y');
		$objetivos = $this->M_configuracion->obt_objetivos($usuario);
		$llamadas_ejecucion = $this->M_dashboard->obtener_llamadas_ejecucion($usuario, $anno);

		$datos['anno'] 					= $anno;		
		$datos['llamadas_ejecucion'] 	= $llamadas_ejecucion;				
		$datos['usuario'] 				= $usuario;				
					
		$this->load->view('lte_header', $datos);
		$this->load->view('v_reporte_consultor', $datos);
		$this->load->view('lte_footer', $datos);	
	}
	public function reportes_consultores($usuario)
	{	
		
		$anno 	                        = date('Y');
		$mes = 1;
		$tipo_ojetivo = 4;
		$tipo_ojetivo1 = 7;
		$tipo_ojetivo_puri = 2;
		$tipo_ojetivo_repu = 3;
		$tipo_ojetivo_aten = 1;
		$tipo_ojetivo_misi = 6;
		$objetivo                  = $this->M_configuracion->obt_objetivo1($usuario,$mes,$tipo_ojetivo);
		$objetivo1                 = $this->M_configuracion->obt_objetivo1($usuario,$mes,$tipo_ojetivo1);
		$objetivo_puri             = $this->M_configuracion->obt_objetivo1($usuario,$mes,$tipo_ojetivo_puri);
		$objetivo_repu             = $this->M_configuracion->obt_objetivo1($usuario,$mes,$tipo_ojetivo_repu);
		$objetivo_aten             = $this->M_configuracion->obt_objetivo1($usuario,$mes,$tipo_ojetivo_aten);
		$objetivo_misi             = $this->M_configuracion->obt_objetivo1($usuario,$mes,$tipo_ojetivo_misi);
		$objetivos                      = $this->M_configuracion->obt_objetivos($usuario);
		$llamadas_ejecucion             = $this->M_dashboard->obtener_llamadas_ejecucion($usuario, $anno);
		$datos['reclamos_abiertos']     = $this->M_configuracion->obtener_reclamos_abiertos_consultor($usuario);
		$datos['ultimo_reclamo']        = $this->M_configuracion->obt_ultimos_reclamos();
		$datos['anno'] 					= $anno;		
		$datos['meses'] 				= $this->M_configuracion->obt_meses();	
		$datos['llamadas_ejecucion'] 	= $llamadas_ejecucion;				
		$datos['usuario'] 				= $usuario;
		$datos['objetivo'] 				= round($objetivo/31);
		$datos['objetivo1'] 			= round($objetivo1/31);
		$datos['objetivo_puri']			= round($objetivo_puri);
		$datos['objetivo_repu']			= round($objetivo_repu);
		$datos['objetivo_aten']			= round($objetivo_aten);
		$datos['objetivo_misi']			= round($objetivo_misi);
        $datos_temp                     = $this->M_configuracion->usuarios_esp($usuario);		
        $datos['datos_usuario'] 		= $datos_temp->result();		
					
		$this->load->view('lte_header', $datos);
		$this->load->view('v_reporte_consultores', $datos);
		$this->load->view('lte_footer', $datos);	
	}
	public function buscar_objetivo($usuario,$mes)
	{			
		$anno 	                        = date('Y');
		$tipo_ojetivo = 4;
		$objetivo                      = $this->M_configuracion->obt_objetivo1($usuario,$mes,$tipo_ojetivo);
		echo json_encode($objetivo); 
	}
	public function buscar_objetivo1($usuario,$mes)
	{			
		$anno 	                        = date('Y');		
		$tipo_ojetivo = 7;
		$objetivo                      = $this->M_configuracion->obt_objetivo1($usuario,$mes,$tipo_ojetivo);
		echo json_encode($objetivo); 
	}
	public function buscar_objetivo_puri($usuario,$mes)
	{			
		$anno 	                        = date('Y');		
		$tipo_ojetivo = 2;
		$objetivo                      = $this->M_configuracion->obt_objetivo1($usuario,$mes,$tipo_ojetivo);
		echo json_encode($objetivo); 
	}
	public function buscar_objetivo_repu($usuario,$mes)
	{			
		$anno 	                        = date('Y');		
		$tipo_ojetivo = 3;
		$objetivo                      = $this->M_configuracion->obt_objetivo1($usuario,$mes,$tipo_ojetivo);
		echo json_encode($objetivo); 
	}
	public function buscar_objetivo_aten($usuario,$mes)
	{			
		$anno 	                        = date('Y');		
		$tipo_ojetivo = 4;
		$objetivo                      = $this->M_configuracion->obt_objetivo1($usuario,$mes,$tipo_ojetivo);
		echo json_encode($objetivo); 
	}
	public function buscar_objetivo_misi($usuario,$mes)
	{			
		$anno 	                        = date('Y');		
		$tipo_ojetivo = 6;
		$objetivo                      = $this->M_configuracion->obt_objetivo1($usuario,$mes,$tipo_ojetivo);
		echo json_encode($objetivo); 
	}
	public function actualizar_objetivo($usuario,$mes, $new_objetivo)
	{			
		$anno 	                        = date('Y');
		
		$tipo_ojetivo = 4;
		$objetivo                      = $this->M_configuracion->upd_objetivo1($usuario,$mes,$tipo_ojetivo,$new_objetivo );
		$objetivo = 0;
		echo json_encode($objetivo); 
	}
	public function actualizar_objetivo1($usuario,$mes, $new_objetivo)
	{			
		$anno 	                        = date('Y');
		
		$tipo_ojetivo = 7;
		$objetivo                      = $this->M_configuracion->upd_objetivo1($usuario,$mes,$tipo_ojetivo,$new_objetivo );
		$objetivo = 0;
		echo json_encode($objetivo); 
	}
	public function actualizar_objetivo_puri($usuario,$mes, $new_objetivo)
	{			
		$anno 	                        = date('Y');
		
		$tipo_ojetivo = 2;
		$objetivo                      = $this->M_configuracion->upd_objetivo1($usuario,$mes,$tipo_ojetivo,$new_objetivo );
		$objetivo = 0;
		echo json_encode($objetivo); 
	}
	public function actualizar_objetivo_repu($usuario,$mes, $new_objetivo)
	{			
		$anno 	                        = date('Y');
		
		$tipo_ojetivo = 3;
		$objetivo                      = $this->M_configuracion->upd_objetivo1($usuario,$mes,$tipo_ojetivo,$new_objetivo );
		$objetivo = 0;
		echo json_encode($objetivo); 
	}
	public function actualizar_objetivo_aten($usuario,$mes, $new_objetivo)
	{			
		$anno 	                        = date('Y');
		
		$tipo_ojetivo = 4;
		$objetivo             = $this->M_configuracion->upd_objetivo1($usuario,$mes,$tipo_ojetivo,$new_objetivo );
		$objetivo = 0;
		echo json_encode($objetivo); 
	}
	public function actualizar_objetivo_misi($usuario,$mes, $new_objetivo)
	{			
		$anno 	                        = date('Y');
		
		$tipo_ojetivo = 6;
		$objetivo                      = $this->M_configuracion->upd_objetivo1($usuario,$mes,$tipo_ojetivo,$new_objetivo );
		$objetivo = 0;
		echo json_encode($objetivo); 
	}
	public function obtener_vt_cantidad($anno, $usuario)
	{		
		
		$obj = $this->M_dashboard->obtener_obj_generales_ejecucion($usuario, $anno);
        $row = $obj->result();
		echo json_encode($row); 	
	}
	public function obtener_vt_cantidad1($anno, $usuario,$mes)
	{		
		
		$obj = $this->M_dashboard->obtener_vt_cantidad_diaria($usuario, $anno,$mes);
		$row = $obj->result();
		$obj1 = $this->M_dashboard->obtener_obj_generales_ejecucion_xmes($usuario, $anno, $mes);
		$row1 = $obj1->result();
		$array['misiones'] = $row;
		$array['objetivo'] = $row1;
		echo json_encode($array); 	
	}
	public function obtener_vt_pesos($anno, $usuario)
	{		
		
		$obj = $this->M_dashboard->obtener_vt_pesos($usuario, $anno);
        $row = $obj->result();
		echo json_encode($row); 	
	}
	public function obtener_llamadas_atencion($anno, $usuario)
	{		
		
		$obj = $this->M_dashboard->obtener_llamadas_ejecucion($usuario, $anno);
        $row = $obj->result();
		echo json_encode($row); 	
	}
	public function obtener_misiones_diaria($anno, $mes,$usuario)
	{		
		
		$obj = $this->M_dashboard->obtener_misiones_diaria($usuario, $anno, $mes);
        $row = $obj->result();
		
		
		$obj1 = $this->M_dashboard->obtener_obj_misiones_diarias($usuario, $anno, $mes);
        $row1 = $obj1->result();
		
		$mis_tv = $this->M_dashboard->obtener_misiones_diaria_tv($usuario, $anno, $mes);
		$row2 = $mis_tv->result();
		
		$lla = $this->M_dashboard->obtener_llamadas_diaria($usuario, $anno, $mes);
        $row3 = $lla->result();
		
		$array['misiones'] = $row;
		$array['objetivo'] = $row1;
		$array['mis_tv']   = $row2;
		$array['llamadas']   = $row3;
		
		echo json_encode($array); 	
	}
	public function obtener_misiones_diaria_tv($anno, $mes, $usuario)
	{		
		
		$obj = $this->M_dashboard->obtener_misiones_diaria_tv($usuario, $anno, $mes);
        $row = $obj->result();
		echo json_encode($row); 	
	}
	public function obtener_llamadas_mision($anno, $usuario)
	{		
		$llama = $this->M_dashboard->obtener_llamadas_mision($usuario, $anno);
		$row1 = $llama->result();
		$obj = $this->M_dashboard->obtener_obj_misiones_ejecucion($usuario, $anno);
		$row = $obj->result();
		$array['misiones'] = $row;
		$array['llamadas'] = $row1;
		echo json_encode($array); 	
	}
	public function obtener_obj_purificadores($anno, $usuario)
	{		
		$obj = $this->M_dashboard->obtener_obj_purificadores_ejecucion($usuario, $anno);
        $row = $obj->result();
		echo json_encode($row); 	
	}
	public function obtener_obj_purificadores1($anno, $usuario)
	{	//cumplimiento del mes actual	
		$obj = $this->M_dashboard->obtener_obj_purificadores_ejecucion_mes($usuario, $anno);
        $row = $obj->result();
		echo json_encode($row); 	
	}
	public function obtener_obj_repuestos($anno, $usuario)
	{		
		$obj = $this->M_dashboard->obtener_obj_repuesto_ejecucion($usuario, $anno);
        $row = $obj->result();
		echo json_encode($row); 	
	}
	public function obtener_obj_mision_pesos($anno, $usuario)
	{				
		$obj = $this->M_dashboard->obtener_obj_mision_pesos_ejecucion($usuario, $anno);
        $row = $obj->result();
		echo json_encode($row); 	
	}
	public function obtener_evaluacion_desempeno($anno)
	{		
		$user = $this->ion_auth->user()->row();
		$usuario = $user->id;
		$obj = $this->M_dashboard->obtener_evaluacion_desempeno($usuario, $anno);
        $row = $obj->result();
		echo json_encode($row); 	
	}
	public function obtener_evaluacion_desempeno_ind($anno,$usuario)
	{		
		$obj = $this->M_dashboard->obtener_evaluacion_desempeno($usuario, $anno);
        $row = $obj->result();
		echo json_encode($row); 	
	}
	public function obtener_ventas_mlms($anno)
	{		
		$obj = $this->M_dashboard->obtener_ventas_mlms($anno);
        $row = $obj->result();
		echo json_encode($row); 	
	}
	public function obtener_transacciones($anno)
	{		
		$obj = $this->M_dashboard->obtener_transacciones($anno);
        $row = $obj->result();
		echo json_encode($row); 	
	}
	public function obtener_cartera_provincia()
	{		
		$obj = $this->M_dashboard->obtener_cartera_provincia();
        $row = $obj->result();
		echo json_encode($row); 	
	}
	public function obtener_cartera_buenos_aires()
	{		
		$obj = $this->M_dashboard->obtener_cartera_buenos_aires();
        $row = $obj->result();
		echo json_encode($row); 	
	}
	public function obtener_detalles_consultores($anno)
	{		
		$obj = $this->M_dashboard->obtener_detalles_consultores($anno);
		$row = $obj->result();

		$obj1 = $this->M_dashboard->obtener_consultores();
		$row1 = $obj1->result();
		
		$aa= array(
			'consultores'    => $row1,
			'detalles'      => $row
		);
		echo json_encode($aa); 	
	}
	public function obtener_reclamos()
	{		
		$obj = $this->M_dashboard->obtener_reclamos();
        $row = $obj->result();
		echo json_encode($row); 	
	}
	public function obtener_reclamos_usuario()
	{	
		$anno = Date('Y');	
		$obj = $this->M_dashboard->obtener_reclamos($anno);
        $row = $obj->result();
		echo json_encode($row); 	
	}
	public function obtener_reclamos_usuario_rodo()
	{	
		$anno = Date('Y');	
		$obj = $this->M_dashboard->obtener_reclamos_rodo($anno);
        $row = $obj->result();
		echo json_encode($row); 	
	}
	public function obtener_reclamos_usuario1($id_usuario)
	{	
		$anno = Date('Y');	
		$obj = $this->M_dashboard->obtener_reclamos_usuarios($anno, $id_usuario);
        $row = $obj;
		echo json_encode($row); 	
	}
	public function reportes_rev()
	{	
		$datos['anno'] 	= date('Y');
		$anno 	= date('Y');
		$user = $this->ion_auth->user()->row();
		$id_usuario = $user->id;
		$usuario = $user->first_name.' '.$user->last_name;
		
		$clientes_atendidos=0;
		$clientes_no_atendidos=0;
		$misiones = $this->M_configuracion->misiones_propuestas_revendedores($id_usuario);
		$solicitudes_baja = $this->M_configuracion->baja_pendientes();
		$misiones_activas1 = $this->M_configuracion->obt_mision_activas();

		$id 				= array();
		$no_factura			= array();
		$cliente 			= array();
		$telefono 			= array();
		$celular 			= array();
		$email 				= array();
		$fec_compra 		= array();
		$fec_vcto 			= array();
		$producto 			= array();
		$en_mision 			= array();
		$en_operacion 		= array();
		$vencimiento 		= array();
		$id_cliente 		= array();
		$id_pedido 			= array();
		$es_exitosa			= array();
		$vip				= array();
		$baja  				= array();

		$contador= 0;
		$bandera = 0;
		foreach ($misiones->result() as $pr){			
			if($bandera==0){// primer registro				
				$bandera=1;
				$anterior_cli=$pr->id_cliente;
				$actual_cli=$pr->id_cliente;
				$anterior_prod=$pr->id_repuesto;
				$actual_prod=$pr->id_repuesto;
				$anterior_vcto=$pr->fecha_vcto;
				$actual_vcto=$pr->fecha_vcto;

				$id[$contador] 					= $pr->id_pedido;
				$no_factura[$contador] 			= $pr->no_factura;
				$cliente[$contador] 			= $pr->nombre;
				$telefono[$contador] 			= $pr->telefono;
				$celular[$contador] 			= $pr->celular;
				$email[$contador] 				= $pr->email;
				$fec_compra[$contador] 			= $pr->fecha_compra;
				$producto[$contador] 			= $pr->repuesto.'-'.$pr->cantidad.'U </br>';		
				$fec_vcto[$contador] 			= $pr->fecha_vcto.' </br>';
				$en_mision[$contador] 			= $pr->en_mision;
				$en_operacion[$contador] 		= $pr->en_operacion;
				$vencimiento[$contador]			= $pr->vencimiento*$pr->cantidad;
				$id_cliente[$contador] 			= $pr->id_cliente;
				$id_pedido[$contador]			= $pr->id_pedido;
				$vip[$contador]					= $pr->vip;
				$baja[$contador] 				= 0;
				foreach ($solicitudes_baja->result() as $key) {
					# code...
					if($pr->id_cliente == $key->id_cliente){
						$baja[$contador] 	= 1;
											
					}
				}

				$es_exitosa[$contador]=1;
				
				if($pr->en_mision){
					$exitosa=1;
					$es_exitosa[$contador]=1;
					foreach ($misiones_activas1->result() as $mi){
						if($mi->id_cliente == $pr->id_cliente){
							$exitosa= $mi->exitosa;
							$es_exitosa[$contador]= $mi->exitosa;
						}
					}
					
				}
			
					
			}else{
				$actual_cli=$pr->id_cliente;
				$actual_prod=$pr->id_repuesto;
				$actual_vcto=$pr->fecha_vcto;
				if($anterior_cli == $actual_cli){// si es el mismo cliente
					$actual_prod=$pr->id_repuesto;					
					if($anterior_prod != $actual_prod){//si es otro producto
						$actual_vcto=$pr->fecha_vcto;
						if($anterior_vcto != $actual_vcto){
							
							if($anterior_vcto > $actual_vcto){// si es menor la fecha
								
								$fec_compra[$contador] 			= $pr->fecha_compra;
								$producto[$contador] 			= $pr->repuesto.'-'.$pr->cantidad.'U </br>';
								$fec_vcto[$contador] 			= $pr->fecha_vcto.' </br>';			
								$vencimiento[$contador]			= $pr->vencimiento;
								
								$anterior_vcto = $actual_vcto;
							}
							
						}
						
					}
					$anterior_prod=$actual_prod;
				}else{// si es otro cliente									
					$contador++;
					$id[$contador] 					= $pr->id_pedido;
					$no_factura[$contador] 			= $pr->no_factura;
					$cliente[$contador] 			= $pr->nombre;
					$telefono[$contador] 			= $pr->telefono;
					$celular[$contador] 			= $pr->celular;
					$email[$contador] 				= $pr->email;
					$fec_compra[$contador] 			= $pr->fecha_compra;
					$producto[$contador] 			= $pr->repuesto.'-'.$pr->cantidad.'U </br>';		
					$fec_vcto[$contador] 			= $pr->fecha_vcto.' </br>';
					$en_mision[$contador] 			= $pr->en_mision;
					$en_operacion[$contador] 		= $pr->en_operacion;
					$vencimiento[$contador]			= $pr->vencimiento*$pr->cantidad;
					$id_cliente[$contador] 			= $pr->id_cliente;
					$id_pedido[$contador]			= $pr->id_pedido;
					$vip[$contador]					= $pr->vip;
					$baja[$contador] 				= 0;
					foreach ($solicitudes_baja->result() as $key) {
						# code...
						if($pr->id_cliente == $key->id_cliente){
							$baja[$contador] 	= 1;
												
						}
					}
	
					$es_exitosa[$contador]=1;
					
					if($pr->en_mision){
						$exitosa=1;
						$es_exitosa[$contador]=1;
						foreach ($misiones_activas1->result() as $mi){
							if($mi->id_cliente == $pr->id_cliente){
								$exitosa= $mi->exitosa;
								$es_exitosa[$contador]= $mi->exitosa;
							}
						}						
					}					

					$anterior_cli=$actual_cli;
					$anterior_prod=$actual_prod;
					$anterior_vcto=$actual_vcto;					
				}
			}	
			
		}	
		$total_clientes=count($id);
		for ($i=0; $i<count($id); $i++ ){
			if (($fec_compra[$i]) <=date("Y-m-d H:i:s",mktime(0,0,0,date("m")-$vencimiento[$i],date("d"), date("Y")))){
				
				$clientes_no_atendidos++;
			}else{
				$clientes_atendidos++;
			}
		}
		$datos['clientes_no_atendidos'] = $clientes_no_atendidos;				
		$datos['clientes_atendidos'] 	= $clientes_atendidos;
		$datos['total_clientes'] 		= $total_clientes;

		$rep_detalle_res = $this->M_dashboard->obtener_consultores_res();
		$datos['consultores'] 		= $rep_detalle_res;
		$row= $rep_detalle_res->result();
		$datos['id_usuario'] 		= $id_usuario;
		$datos['usuario'] 		= $usuario;
		
		

		$datos['total_monetario'] = $this->M_dashboard->obtener_ventas_am_mon($anno);
		$datos['total_cantidad'] = $this->M_dashboard->obtener_ventas_am_can($anno);
		$this->load->view('lte_header', $datos);
		$this->load->view('v_reporte_rev', $datos);
		$this->load->view('lte_footer', $datos);	
	}
	public function obtener_ventas_am($anno)
	{		
		$obj = $this->M_dashboard->obtener_ventas_am($anno);
        $row = $obj->result();
		echo json_encode($row); 	
	}
	public function obtener_cartera_provincia_rev()
	{		
		$obj = $this->M_dashboard->obtener_cartera_provincia_rev();
        $row = $obj->result();
		echo json_encode($row); 	
	}
	public function reportes_jrev()
	{	
		$anno 	= date('Y');
		$datos['anno'] 	= $anno;
		$mes 	= date('m');
		$datos['mes'] 	= $mes;
		
		$user = $this->ion_auth->user()->row();
		$id_usuario = $user->id;
		$usuario = $user->first_name.' '.$user->last_name;
		
		$total_clientes_atendidos=0;
		$total_clientes_no_atendidos=0;
		$misiones = $this->M_configuracion->misiones_propuestas_todos_revendedores();
		$solicitudes_baja = $this->M_configuracion->baja_pendientes();
		$misiones_activas1 = $this->M_configuracion->obt_mision_activas();

		$id 				= array();
		$no_factura			= array();
		$cliente 			= array();
		$telefono 			= array();
		$celular 			= array();
		$email 				= array();
		$fec_compra 		= array();
		$fec_vcto 			= array();
		$producto 			= array();
		$en_mision 			= array();
		$en_operacion 		= array();
		$vencimiento 		= array();
		$id_cliente 		= array();
		$id_pedido 			= array();
		$es_exitosa			= array();
		$vip				= array();
		$baja  				= array();
		$no_atendidos		= array();
		$atendidos			= array();
		$id_usuario1 		= array();

		$contador= 0;
		$bandera = 0;
		foreach ($misiones->result() as $pr){			
			if($bandera==0){// primer registro				
				$bandera=1;
				$anterior_cli=$pr->id_cliente;
				$actual_cli=$pr->id_cliente;
				$anterior_prod=$pr->id_repuesto;
				$actual_prod=$pr->id_repuesto;
				$anterior_vcto=$pr->fecha_vcto;
				$actual_vcto=$pr->fecha_vcto;

				$id[$contador] 					= $pr->id_pedido;
				$no_factura[$contador] 			= $pr->no_factura;
				$cliente[$contador] 			= $pr->nombre;
				$telefono[$contador] 			= $pr->telefono;
				$celular[$contador] 			= $pr->celular;
				$email[$contador] 				= $pr->email;
				$fec_compra[$contador] 			= $pr->fecha_compra;
				$producto[$contador] 			= $pr->repuesto.'-'.$pr->cantidad.'U </br>';		
				$fec_vcto[$contador] 			= $pr->fecha_vcto.' </br>';
				$en_mision[$contador] 			= $pr->en_mision;
				$en_operacion[$contador] 		= $pr->en_operacion;
				$vencimiento[$contador]			= $pr->vencimiento*$pr->cantidad;
				$id_cliente[$contador] 			= $pr->id_cliente;
				$id_pedido[$contador]			= $pr->id_pedido;
				$vip[$contador]					= $pr->vip;
				$baja[$contador] 				= 0;
				$id_usuario1[$contador]			= $pr->id_usuario; 
				foreach ($solicitudes_baja->result() as $key) {
					# code...
					if($pr->id_cliente == $key->id_cliente){
						$baja[$contador] 	= 1;
											
					}
				}

				$es_exitosa[$contador]=1;
				
				if($pr->en_mision){
					$exitosa=1;
					$es_exitosa[$contador]=1;
					foreach ($misiones_activas1->result() as $mi){
						if($mi->id_cliente == $pr->id_cliente){
							$exitosa= $mi->exitosa;
							$es_exitosa[$contador]= $mi->exitosa;
						}
					}
					
				}
			
					
			}else{
				$actual_cli=$pr->id_cliente;
				$actual_prod=$pr->id_repuesto;
				$actual_vcto=$pr->fecha_vcto;
				if($anterior_cli == $actual_cli){// si es el mismo cliente
					$actual_prod=$pr->id_repuesto;					
					if($anterior_prod != $actual_prod){//si es otro producto
						$actual_vcto=$pr->fecha_vcto;
						if($anterior_vcto != $actual_vcto){
							
							if($anterior_vcto > $actual_vcto){// si es menor la fecha
								
								$fec_compra[$contador] 			= $pr->fecha_compra;
								$producto[$contador] 			= $pr->repuesto.'-'.$pr->cantidad.'U </br>';
								$fec_vcto[$contador] 			= $pr->fecha_vcto.' </br>';			
								$vencimiento[$contador]			= $pr->vencimiento;
								
								$anterior_vcto = $actual_vcto;
							}
							
						}
						
					}
					$anterior_prod=$actual_prod;
				}else{// si es otro cliente									
					$contador++;
					$id[$contador] 					= $pr->id_pedido;
					$no_factura[$contador] 			= $pr->no_factura;
					$cliente[$contador] 			= $pr->nombre;
					$telefono[$contador] 			= $pr->telefono;
					$celular[$contador] 			= $pr->celular;
					$email[$contador] 				= $pr->email;
					$fec_compra[$contador] 			= $pr->fecha_compra;
					$producto[$contador] 			= $pr->repuesto.'-'.$pr->cantidad.'U </br>';		
					$fec_vcto[$contador] 			= $pr->fecha_vcto.' </br>';
					$en_mision[$contador] 			= $pr->en_mision;
					$en_operacion[$contador] 		= $pr->en_operacion;
					$vencimiento[$contador]			= $pr->vencimiento*$pr->cantidad;
					$id_cliente[$contador] 			= $pr->id_cliente;
					$id_pedido[$contador]			= $pr->id_pedido;
					$vip[$contador]					= $pr->vip;
					$baja[$contador] 				= 0;
					$id_usuario1[$contador]			= $pr->id_usuario; 
					foreach ($solicitudes_baja->result() as $key) {
						# code...
						if($pr->id_cliente == $key->id_cliente){
							$baja[$contador] 	= 1;
												
						}
					}
	
					$es_exitosa[$contador]=1;
					
					if($pr->en_mision){
						$exitosa=1;
						$es_exitosa[$contador]=1;
						foreach ($misiones_activas1->result() as $mi){
							if($mi->id_cliente == $pr->id_cliente){
								$exitosa= $mi->exitosa;
								$es_exitosa[$contador]= $mi->exitosa;
							}
						}						
					}					

					$anterior_cli=$actual_cli;
					$anterior_prod=$actual_prod;
					$anterior_vcto=$actual_vcto;					
				}
			}	
			
		}	
		$total_clientes=count($id);
		for ($i=0; $i<count($id); $i++ ){
			if (($fec_compra[$i]) <=date("Y-m-d H:i:s",mktime(0,0,0,date("m")-$vencimiento[$i],date("d"), date("Y")))){
				$no_atendidos[$i] = 1;	
				$atendidos[$i] = 0;
				$total_clientes_no_atendidos++;
			}else{
				$no_atendidos[$i] = 0;	
				$atendidos[$i] = 1;
				$total_clientes_atendidos++;
			}
		}
		$datos['total_clientes_no_atendidos'] = $total_clientes_no_atendidos;				
		$datos['total_clientes_atendidos'] 	= $total_clientes_atendidos;
		$datos['total_clientes'] 		= $total_clientes_no_atendidos + $total_clientes_atendidos;

		$rep_detalle_res = $this->M_dashboard->obtener_consultores_rev($anno, $mes);
		$datos['consultores'] 		= $rep_detalle_res;
		$datos['usuarios_consultores'] 		= $this->M_dashboard->obtener_consultores_revendedores();
		
		$datos['id_usuario'] 		= $id_usuario;
		
		$datos['usuario'] 			= $usuario;

		$datos['id'] 				= $id;
		$datos['no_atendidos'] 		= $no_atendidos;
		$datos['atendidos'] 		= $atendidos;
		$datos['id_usuario1'] 		= $id_usuario1;
		
		$datos['total_monetario'] = $this->M_dashboard->obtener_ventas_am_mon($anno);
		$datos['total_cantidad'] = $this->M_dashboard->obtener_ventas_am_can($anno);
		$this->load->view('lte_header', $datos);
		$this->load->view('v_reporte_jrev', $datos);
		$this->load->view('lte_footer', $datos);	
	}
	public function obtener_armado($fecha_inicio, $fecha_final)
	{	
		$fecha_ini = substr($fecha_inicio,0,4).'-'.substr($fecha_inicio,5,2).'-'.substr($fecha_inicio,8,2).' 00:00:00';
		$fecha_fin = substr($fecha_final,0,4).'-'.substr($fecha_final,5,2).'-'.substr($fecha_final,8,2).' 00:00:00';
		
		$obj = $this->M_dashboard->obt_datos_gestion_armado($fecha_ini, $fecha_fin);
		
		$row = $obj->result();
		
		echo json_encode($row); 	
	}
	public function obtener_despacho($fecha_inicio, $fecha_final)
	{	
		$fecha_ini = substr($fecha_inicio,0,4).'-'.substr($fecha_inicio,5,2).'-'.substr($fecha_inicio,8,2).' 00:00:00';
		$fecha_fin = substr($fecha_final,0,4).'-'.substr($fecha_final,5,2).'-'.substr($fecha_final,8,2).' 00:00:00';
		
		$obj = $this->M_dashboard->obt_datos_gestion_despacho($fecha_ini, $fecha_fin);
		$row = $obj->result();
		
		echo json_encode($row); 	
	}
	public function obtener_canal_pedido($fecha_inicio, $fecha_final)
	{	
		$fecha_ini = substr($fecha_inicio,0,4).'-'.substr($fecha_inicio,5,2).'-'.substr($fecha_inicio,8,2).' 00:00:00';
		$fecha_fin = substr($fecha_final,0,4).'-'.substr($fecha_final,5,2).'-'.substr($fecha_final,8,2).' 00:00:00';
		$obj = $this->M_dashboard->obt_datos_canal_pedidos($fecha_ini, $fecha_fin);
		$row = $obj->result();
		
		echo json_encode($row); 	
	}
	public function frecuencia_compras()
	{
		$revendedores = $this->M_dashboard->obt_usuarios_rev();
		$frecuencia = $this->M_dashboard->frecuencia();
		$datos['revendedores'] = $revendedores;
		$datos['frecuencia'] = $frecuencia;
		$this->load->view('lte_header', $datos);
		$this->load->view('v_reporte_frecuencia', $datos);
		$this->load->view('lte_footer', $datos);
	}
}

