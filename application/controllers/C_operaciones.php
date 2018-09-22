<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class C_operaciones extends CI_Controller {

	/*
	 * ------------------------------------------------------
	 *  Atributos
	 * ------------------------------------------------------
	 */
	 
	var $notificacion;
	var $notificacion_error;
	
	/*
	 * ------------------------------------------------------
	 *  Comportamiento
	 * ------------------------------------------------------
	 */
	 
	public function __construct()
    {
		parent::__construct();
		$this->load->library('session');
		$this->load->helper('url','mysql_to_excel_helper');
		$this->load->library('oca');

		if (!$this->ion_auth->logged_in())
			redirect('entrada');
		else{
			$this->load->model( 'M_operaciones', '', TRUE );
			$this->load->model( 'M_configuracion', '', TRUE );
			$this->load->model( 'M_dashboard', '', TRUE );
			$this->load->model('upload_model');
		}
    }
	/********************************************************************************************************************/
	// 
    public function index()
	{
		
	}
	
	/*
	 * ------------------------------------------------------
	 *  GESTIÓN PEDIDOS
	 * ------------------------------------------------------
	 */
	 
	// ------------------------------------------------------
	// Pedidos
    
	public function pedidos()
	{
		$clientes = $this->M_operaciones->clientes();	
		$pedidos = $this->M_operaciones->pedidos();	
		$total_pedidos = $this->M_operaciones->total_pedidos();	
        
		$datos['pedidos'] = $pedidos;
		$datos['total_pedidos'] = $total_pedidos;
		
		$this->load->view('lte_header', $datos);
		$this->load->view('v_listado_pedidos', $datos);
		$this->load->view('lte_footer', $datos);
	}
	
	// ------------------------------------------------------
	// Nuevo pedido
	
	public function nuevo_pedido()
	{
		$productos = $this->M_operaciones->productos();
		$canales = $this->M_operaciones->canales();
		$clientes = $this->M_operaciones->clientes();
		$estados = $this->M_operaciones->estados_pedido();
		
		$datos['canales'] = $canales;
		$datos['clientes'] = $clientes;
		$datos['productos'] = $productos;
		
		$user = $this->ion_auth->user()->row();
		
		$datos['id_usuario'] = $user->id;
		$datos['nombre_usuario'] = $user->first_name;
		$datos['estados'] = $estados;
		
		$datos['notificacion'] = $this->notificacion ? $this->notificacion : "2 - DETALLES DE LA VENTA:";
		$datos['notificacion_error'] = $this->notificacion_error;
		$datos['modo_edicion'] = false;
		
		$this->load->view('lte_header', $datos);
		$this->load->view('v_nuevo_pedido', $datos);
		$this->load->view('lte_footer', $datos);	
	}
	
	// ------------------------------------------------------
	// Nuevo pedido (asistente para atención)
	public function sendMailGmail($email_destino,$cuerpo_mensaje)
	{		
		//cargamos la libreria email de ci
		$this->load->library("email");
 
		//configuracion para gmail
		$configGmail = array(
			'protocol' => 'smtp',
			'smtp_host' => 'ssl://smtp.gmail.com',
			'smtp_port' => 465,
			'smtp_user' => 'notificaciones@dvigi.com.ar',
			'smtp_pass' => 'BsAs4587wl#',
			'mailtype' => 'html',
			'charset' => 'utf-8',
			'newline' => "\r\n"
		);    
 
		//cargamos la configuración para enviar con gmail
		$this->email->initialize($configGmail);
 
		$this->email->from('notificaciones@dvigi.com.ar <notificaciones@dvigi.com.ar>', 'Notificaciones Dvigi');
		$this->email->to("$email_destino");
		$this->email->subject('Información de despacho');
		$this->email->message('<h2>Email enviado desde el Sistema DVIGI ,</h2><hr></br>'.  $cuerpo_mensaje);
		$this->email->send();
		//con esto podemos ver el resultado
		//var_dump($this->email->print_debugger());
	}
	public function sendMailMandril($email_destino,$asunto, $cuerpo_mensaje)
	{		
		//cargamos la libreria email de ci
		$this->load->library("email");
 
		//configuracion para gmail
		$configGmail = array(
			'protocol' => 'smtp',
			'smtp_host' => 'smtp.mandrillapp.com',
			'smtp_port' => 587,
			'smtp_user' => 'administracion@dvigi.com.ar',
			'smtp_pass' => 'nt6mBSRsBN-LM9m0y5Lkcw',
			'mailtype' => 'html',
			'charset' => 'utf-8',
			'newline' => "\r\n"
		);    
 
		//cargamos la configuración para enviar con gmail
		$this->email->initialize($configGmail);
 
		$this->email->from('consultas@dvigi.com.ar', 'DVIGI tu agua pura');
		$this->email->to("$email_destino");
		$this->email->subject("$asunto");
		$this->email->message('<h2>Email enviado desde el Sistema DVIGI</h2><hr></br>'.  $cuerpo_mensaje);
		$this->email->send();
		//con esto podemos ver el resultado
		//var_dump($this->email->print_debugger());
		//print_r('entro');die();
	}
	
	// ------------------------------------------------------
	// Registrar pedido
	
    public function registrar_pedido()
    {
		 $id_pedido = $this->input->post('id_pedido');
		 $id_cliente = $this->input->post('id_cliente');
		 $nombre_canal = $this->input->post('id_canal');
		 $id_usuario = $this->input->post('id_usuario');
		 $id_estado = $this->input->post('id_estado');
		 $fecha_solicitud = $this->input->post('fecha_solicitud');
		 $fecha_limite_pago = $this->input->post('fecha_limite_pago');
		 
		 if ($id_pedido != '' && $nombre_canal != '' && $fecha_solicitud != '' && $fecha_limite_pago != '')
		 {
		 
			 $registrado = $this->M_operaciones->registrar_pedido($id_pedido, $id_cliente, $nombre_canal, $id_usuario, $id_estado, $fecha_solicitud, $fecha_limite_pago);
			 
			 $mensaje = "";
			 if ($registrado == 1)
				 { 
					 $this->notificacion = "El pedido se registró satisfactoriamente.";
		             $this->notificacion_error = false;
				 }
				 else
				 {
					 $this->notificacion = "ERROR. No se pudo registrar el pedido.";
		             $this->notificacion_error = true;
				 }
		 }
		 else
		 {
			 $this->notificacion = "ERROR. No se pudo registrar el pedido. Verifique los datos especificados.";
             $this->notificacion_error = true;
		 }
		 
		 $this->nuevo_pedido();
    }
	
	// ------------------------------------------------------
	// Editar pedido
	
	public function editar_pedido($id_actual)
	{
		$resultado = $this->M_operaciones->obt_pedido($id_actual);
        $canales = $this->M_operaciones->canales();
		$clientes = $this->M_operaciones->clientes();
		$estados = $this->M_operaciones->estados_pedido();
		
		if ($resultado)
		{
		   $pedido = $resultado->row();

		   $id_pedido = $pedido->id_pedido;
		   $id_cliente = $pedido->id_cliente;
		   $nombre_canal = $pedido->nombre_canal;
		   $id_usuario = $pedido->id_usuario;
		   $id_estado = $pedido->id_estado;
		   $fecha_solicitud = $pedido->fecha_solicitud;
		   $fecha_limite_pago = $pedido->fecha_limite_pago;
		   
		   $user = $this->ion_auth->user()->row();
		   $datos['nombre_usuario'] = $user->first_name;
		   
		   $datos['modo_edicion'] = true;
		   $datos['id_actual'] = $id_actual;
		   $datos['canales'] = $canales;
		   $datos['clientes'] = $clientes;
		   $datos['estados'] = $estados;

		   $datos['notificacion'] = $this->notificacion ? $this->notificacion : "Modificando el pedido";
           $datos['notificacion_error'] = $this->notificacion_error;
		   
		   $datos['id_pedido'] = $id_pedido;
		   $datos['id_canal'] =  $nombre_canal;
		   $datos['id_cliente'] = $id_cliente;
		   $datos['id_usuario'] = $id_usuario;
		   $datos['id_estado'] = $id_estado;
		   $datos['fecha_solicitud'] = $fecha_solicitud;
		   $datos['fecha_limite_pago'] = $fecha_limite_pago;

		}
		
		$this->load->view('lte_header', $datos);
 	    $this->load->view('v_nuevo_pedido', $datos);
	    $this->load->view('lte_footer', $datos);
	}
	
	// ------------------------------------------------------
	// Modificar pedido
    
	public function modificar_pedido()
    {
		 $id_actual = $this->input->post('id_actual');
		 $id_pedido = $this->input->post('id_pedido');
		 $id_cliente = $this->input->post('id_cliente');
		 $nombre_canal = $this->input->post('id_canal');
		 $id_usuario = $this->input->post('id_usuario');
		 $id_estado = $this->input->post('id_estado');
		 $fecha_solicitud = $this->input->post('fecha_solicitud');
		 $fecha_limite_pago = $this->input->post('fecha_limite_pago');
		 
		 if ($nombre_canal != '' && $fecha_solicitud != '' && $fecha_limite_pago != '')
		    
		 {
		 	 $modificado = $this->M_operaciones->modificar_pedido($id_actual, $id_pedido, $id_cliente, $nombre_canal, $id_usuario, $id_estado, $fecha_solicitud, $fecha_limite_pago);
			 
   		     if ($modificado == 1)
			 { 
				 $this->notificacion = "El pedido se modificó satisfactoriamente.";
		         $this->notificacion_error = false;
			 }
			 else
			 {
				 $this->notificacion = "ERROR. No se pudo modificar el pedido.";
		         $this->notificacion_error = true;
			 }
		 }
		 else
		 {
		     $this->notificacion = "ERROR. No se pudo modificar el pedido. Verifique los datos especificados.";
			 $this->notificacion_error = true;
		 }
		 
		 $this->editar_pedido($id_pedido);
	}
	
	// ------------------------------------------------------
	// Confirmar cancelación de un pedido
	
	public function cfe_pedido($id_pedido)
	{
		$datos['id_pedido'] = $id_pedido;
		
		$this->load->view('lte_header', $datos);
 	    $this->load->view('vcan_pedidos', $datos);
	    $this->load->view('lte_footer', $datos);
	}
	
	// ------------------------------------------------------
	// Cancelar pedido
	
    public function cancelar_pedido()
	{
		$id_pedido = $this->input->post('id_pedido');
		$cancelado = $this->M_operaciones->cancelar_pedido($id_pedido);
		
		if ($cancelado == 1)
	    { 
		    $this->notificacion = "El pedido se elimino correctamente.";
		    $this->notificacion_error = false;
		}
		else
		{
		    $this->notificacion = "No se pudo eliminar el pedido.";
		    $this->notificacion_error = true;  
		}
		
		$this->pedidos();

	}
	
	/*
	 * ------------------------------------------------------
	 *  GESTIÓN DETALLES DE PEDIDOS
	 * ------------------------------------------------------
	 */
	 
	// ------------------------------------------------------
	// Detalles
    
	public function detalles()
	{
		$detalles = $this->M_operaciones->detalles_pedidos();
		$total_detalles = $this->M_operaciones->total_detalles();	
        
		$datos['detalles'] = $detalles;
		$datos['total_detalles'] = $total_detalles;
		
		$this->load->view('lte_header', $datos);
		$this->load->view('v_listado_detalles', $datos);
		$this->load->view('lte_footer', $datos);
	}
	
	// ------------------------------------------------------
	// Nuevo detalle
	
	public function nuevo_detalle()
	{
		$pedidos = $this->M_operaciones->pedidos();
		$productos = $this->M_operaciones->productos();
		
		$datos['pedidos'] = $pedidos;
		$datos['productos'] = $productos;
		
		$datos['notificacion'] = $this->notificacion ? $this->notificacion : "Especifique los datos:";
		$datos['notificacion_error'] = $this->notificacion_error;
		$datos['modo_edicion'] = false;
		
		$this->load->view('lte_header', $datos);
		$this->load->view('v_nuevo_detalle', $datos);
		$this->load->view('lte_footer', $datos);	
	}
	
	// ------------------------------------------------------
	// Registrar detalle
	
    public function registrar_detalle()
    {
		 $id_pedido = $this->input->post('id_pedido');
		 $id_producto = $this->input->post('id_producto');
		 $cantidad = $this->input->post('cantidad');
		 $descuento = $this->input->post('descuento');
		 
		 if ($descuento == '') $descuento = 0.00;
		 
		 if ($cantidad != '')
		 {
		 
			 $registrado = $this->M_operaciones->registrar_detalle($id_pedido, $id_producto, $cantidad, $descuento);
			 
			 $mensaje = "";
			 if ($registrado == 1)
				 { 
					 $this->notificacion = "El detalle se registró satisfactoriamente.";
		             $this->notificacion_error = false;
				 }
				 else
				 {
					 $this->notificacion = "ERROR. No se pudo registrar el detalle.";
		             $this->notificacion_error = true;
				 }
		 }
		 else
		 {
			 $this->notificacion = "ERROR. No se pudo registrar el detalle. Verifique los datos especificados.";
             $this->notificacion_error = true;
		 }
		 
		 $this->nuevo_detalle();
    }
	
	// ------------------------------------------------------
	// Editar detalle
	
	public function editar_detalle($id_pedido, $id_producto)
	{
		$resultado = $this->M_operaciones->obt_detalle($id_pedido, $id_producto);
		$pedidos = $this->M_operaciones->pedidos();
		$productos = $this->M_operaciones->productos();
		
		if ($resultado)
		{
		   $detalle = $resultado->row();

		   $cantidad = $detalle->cantidad;
		   $descuento = $detalle->descuento;
		   
		   $datos['modo_edicion'] = true;
		   $datos['id_pedido_actual'] = $id_pedido;
		   $datos['id_producto_actual'] = $id_producto;
		   $datos['pedidos'] = $pedidos;
		   $datos['productos'] = $productos;

		   $datos['notificacion'] = $this->notificacion ? $this->notificacion : "Modificando el detalle de un pedido";
           $datos['notificacion_error'] = $this->notificacion_error;
		   
		   $datos['cantidad'] = $cantidad;
		   $datos['descuento'] = $descuento;
		}
		
		$this->load->view('lte_header', $datos);
 	    $this->load->view('v_nuevo_detalle', $datos);
	    $this->load->view('lte_footer', $datos);
	}
	
	// ------------------------------------------------------
	// Modificar detalle
    
	public function modificar_detalle()
    {
		 $id_pedido_actual = $this->input->post('id_pedido');
		 $id_producto_actual = $this->input->post('id_producto');
		 $id_pedido = $this->input->post('id_pedido');
		 $id_producto = $this->input->post('id_producto');
		 $cantidad = $this->input->post('cantidad');
		 $descuento = $this->input->post('descuento');
		 
		 if ($cantidad != 0)
		    
		 {
		 
			 $modificado = $this->M_operaciones->modificar_detalle($id_pedido_actual, $id_producto_actual, $id_pedido, $id_producto, $cantidad, $descuento);
			 
   		     if ($modificado == 1)
			 { 
				 $this->notificacion = "El detalle se modificó satisfactoriamente.";
		         $this->notificacion_error = false;
			 }
			 else
			 {
				 $this->notificacion = "ERROR. No se pudo modificar el detalle. Verifique los datos especificados.";
		         $this->notificacion_error = true;
			 }
		 }
		 else
		 {
		     $this->notificacion = "ERROR. No se pudo modificar el detalle. Verifique los datos especificados.";
			 $this->notificacion_error = true;
		 }
		 
		 $this->editar_detalle($id_pedido_actual, $id_producto_actual);
	}
	
	// ------------------------------------------------------
	// Confirmar cancelación de un detalle
	
	public function cfe_detalle($id_pedido, $id_producto)
	{
		$datos['id_pedido'] = $id_pedido;
		$datos['id_producto'] = $id_producto;
		
		$this->load->view('lte_header', $datos);
 	    $this->load->view('vcan_detalles', $datos);
	    $this->load->view('lte_footer', $datos);
	}
	
	// ------------------------------------------------------
	// Cancelar detalle
	
    public function cancelar_detalle()
	{
		$id_pedido = $this->input->post('id_pedido');
		$id_producto = $this->input->post('id_producto');
		
		$cancelado = $this->M_operaciones->cancelar_detalle($id_pedido, $id_producto);
		
		if ($cancelado == 1)
	    { 
		    $this->notificacion = "El detalle se eliminó correctamente.";
		    $this->notificacion_error = false;
		}
		else
		{
		    $this->notificacion = "No se pudo eliminar el detalle.";
		    $this->notificacion_error = true;  
		}
		
		$this->detalles();

	}
	
	/*
	 * ------------------------------------------------------
	 *  GESTIÓN ENTREGAS POR TERCEROS
	 * ------------------------------------------------------
	 */
	 
	// ------------------------------------------------------
	// Entregas por terceros
    
	public function entregas_terceros_despachadores()
	{
		$entregas_terceros = $this->M_operaciones->listado_despachadores();	
		$total_entregas_terceros = $this->M_operaciones->total_entregas_terceros_despachadores();	
		$total_entregas_terceros_despachadas = $this->M_operaciones->total_entregas_terceros_despachadas_despachadores();
        $datos['entregas_terceros'] = $entregas_terceros;
		$datos['total_entregas_terceros'] = $total_entregas_terceros;
		$datos['total_entregas_terceros_despachadas'] = $total_entregas_terceros_despachadas;
		
		$this->load->view('lte_header', $datos);
		$this->load->view('v_listado_entregas_terceros_despachador', $datos);
		$this->load->view('lte_footer', $datos);
	}
	public function entregas_terceros()
	{
		$entregas_terceros = $this->M_operaciones->entregas_para_oca();	
		$total_entregas_terceros_canceladas = $this->M_operaciones->total_entregas_terceros_canceladas();
		$total_entregas_terceros = $this->M_operaciones->total_entregas_terceros();	
		$total_entregas_terceros_despachadas = $this->M_operaciones->total_entregas_terceros_despachadas();
        $datos['entregas_terceros'] = $entregas_terceros;
		$datos['total_entregas_terceros'] = $total_entregas_terceros;
		$datos['total_entregas_terceros_despachadas'] = $total_entregas_terceros_despachadas;
		$datos['total_entregas_terceros_canceladas'] = $total_entregas_terceros_canceladas;
		
		$this->load->view('lte_header', $datos);
		$this->load->view('v_listado_entregas_terceros', $datos);
		$this->load->view('lte_footer', $datos);
	}
	public function entregas_terceros_ok()
	{
		$entregas_terceros = $this->M_operaciones->entregas_para_oca_ok();	
		$total_entregas_terceros_canceladas = $this->M_operaciones->total_entregas_terceros_canceladas();
		$total_entregas_terceros = $this->M_operaciones->total_entregas_terceros();	
		$total_entregas_terceros_despachadas = $this->M_operaciones->total_entregas_terceros_despachadas();
        $datos['entregas_terceros'] = $entregas_terceros;
		$datos['total_entregas_terceros'] = $total_entregas_terceros;
		$datos['total_entregas_terceros_despachadas'] = $total_entregas_terceros_despachadas;
		$datos['total_entregas_terceros_canceladas'] = $total_entregas_terceros_canceladas;
		
		$this->load->view('lte_header', $datos);
		$this->load->view('v_listado_entregas_terceros', $datos);
		$this->load->view('lte_footer', $datos);
	}
	// ------------------------------------------------------
	// Nueva entrega por tercero
	
	public function nueva_entrega_tercero()
	{
		$pedidos = $this->M_operaciones->pedidos();
		$empresas_flete = $this->M_operaciones->empresas_flete();
		$estados_entregas_terceros = $this->M_operaciones->estados_entregas_terceros();
		
		$group = array('JefeArea', 'Administradores');
        if ($this->ion_auth->in_group($group))
			$jefe_area='true';
		else
			$jefe_area='false';

		$datos['jefe_area'] = $jefe_area;
		
		$datos['pedidos'] = $pedidos;
		$datos['empresas_flete'] = $empresas_flete;
		$datos['estados_entregas_terceros'] = $estados_entregas_terceros;
		
		$datos['notificacion'] = $this->notificacion ? $this->notificacion : "3 - FORMA DE ENVIO:";
		$datos['notificacion_error'] = $this->notificacion_error;
		$datos['modo_edicion'] = false;
		
		$this->load->view('lte_header', $datos);
		$this->load->view('v_nueva_entrega_tercero', $datos);
		$this->load->view('lte_footer', $datos);	
	}
	
	
	
	// ------------------------------------------------------
	// Registrar entrega por tecero
	
    public function registrar_entrega_tercero()
    {
		 $id_pedido = $this->input->post('id_pedido');
		 $id_empresa = $this->input->post('id_empresa');
		 $id_estado = $this->input->post('id_estado');
		 $id_envio = $this->input->post('id_envio');
		 $tipo_envio= $this->input->post('tipo_envio');
		 		 
		
		 $fecha = $this->input->post('fecha');
		 
		 if ( $id_envio != '')
		 {
		 
			 $registrado = $this->M_operaciones->registrar_entrega_tercero($id_pedido, $id_empresa, $id_estado, $id_envio, $fecha);
			 
			 $mensaje = "";
			 if ($registrado == 1)
				 { 
					 $this->notificacion = "La entrega se registró satisfactoriamente.";
		             $this->notificacion_error = false;
				 }
				 else
				 {
					 $this->notificacion = "ERROR. No se pudo registrar la entrega.";
		             $this->notificacion_error = true;
				 }
		 }
		 else
		 {
			 $this->notificacion = "ERROR. No se pudo registrar la entrega. Verifique los datos especificados.";
             $this->notificacion_error = true;
		 }
		 
		 $this->nueva_entrega_tercero();
    }
	
	// ------------------------------------------------------
	// Editar entrega por tercero
	
	public function editar_entrega_tercero($id_pedido, $id_empresa)
	{
		
		$pedidos = $this->M_operaciones->pedidos();
		$empresas_flete = $this->M_operaciones->empresas_flete();
		$estados_entregas_terceros = $this->M_operaciones->estados_entregas_terceros();
		$detalles_pedidos_terceros = $this->M_operaciones->detalles_pedidos_terceros($id_pedido);
		
		$datos['pedidos'] 					= $pedidos;
		$datos['empresas_flete'] 			= $empresas_flete;
		$datos['estados_entregas_terceros'] = $estados_entregas_terceros;
		$datos['detalles_pedidos_terceros'] = $detalles_pedidos_terceros;
		
		$resultado = $this->M_operaciones->obt_entrega_tercero($id_pedido, $id_empresa);
		if ($resultado)
		{
		   $entrega_tercero = $resultado->row();
		   
		   $id_pedido 	= $entrega_tercero->id_pedido;
		   
		   $id_empresa 	= $entrega_tercero->id_empresa;
		   $id_estado 	= $entrega_tercero->id_estado;
		   $id_envio 	= $entrega_tercero->id_envio;
		   $fecha 		= $entrega_tercero->fecha;
		   $reg_cancelado= $entrega_tercero->reg_cancelado;
		   
		   $datos['modo_edicion'] 		= true;
		   $datos['notificacion'] 		= $this->notificacion ? $this->notificacion : "Modificando una entrega por tercero";
           $datos['notificacion_error'] = $this->notificacion_error;

		   $datos['id_pedido_actual'] 	= $id_pedido;
		   $datos['id_empresa_actual'] 	= $id_empresa;
		   $datos['id_estado_actual'] 	= $id_estado;
		   $datos['reg_cancelado']		= $reg_cancelado;

		   $datos['id_estado'] 	= $id_estado;
		   $datos['id_envio'] 	= $id_envio;
		   $datos['fecha'] 		= $fecha;
		}
			$group = array('JefeArea', 'GerenteProduccion');
        if ($this->ion_auth->in_group($group))
			$jefe_area='true';
		else
			$jefe_area='false';

		$datos['jefe_area'] = $jefe_area;
		
		$this->load->view('lte_header', $datos);
 	    $this->load->view('v_nueva_entrega_tercero', $datos);
	    $this->load->view('lte_footer', $datos);
	}
	public function cancelar_OrdenRetiro($id_envio){
		$oca 	= new Oca($cuit = '30-69511732-5', 71243);
		$anular_orden = $oca->anularOrdenGenerada($user = "finanzas@dvigi.com.ar", $pass = "Vanina86", $IdOrdenRetiro = $id_envio);
		$IdResult=$anular_orden[0]['IdResult'];
		$datos['IdResult'] = $IdResult;
		$Mensaje=$anular_orden[0]['Mensaje'];
		$datos['Mensaje'] = $Mensaje;

		$cancelar = $this->M_operaciones->cancelar_envio( $id_envio);

		$this->load->view('lte_header', $datos);
 	    $this->load->view('v_cancelar_orden_retiro', $datos);
	    $this->load->view('lte_footer', $datos);
	}
	public function etiqueta_entrega_tercero($id_envio){
		$oca 	= new Oca($cuit = '30-69511732-5', 71243);		
		$etiqueta_html = $oca->getHtmlDeEtiquetasPorOrdenOrNumeroEnvio($IdOrdenRetiro = $id_envio, $NroEnvio = '');
		//Con esto imprimes las etiquetas html que estan en los arreglos
		//$xml=simplexml_load_string($etiqueta_html);
		//print_r($etiqueta_html);die();
		$datos['etiqueta_html'] = $etiqueta_html;
		$marcar_impresion = $this->M_operaciones->marcar_impresion($id_envio);
		//$this->load->view('lte_header', $datos);
 	    $this->load->view('etiqueta', $datos);
	    //$this->load->view('lte_footer', $datos);
	}
	// ------------------------------------------------------
	// Modificar entrega por tercero
    public function ejecutar_despacho($id_pedido){
		$resultado = $this->M_operaciones->despachar_envio( $id_pedido);
		$this->pedidos_gestion_pv();
	}
    public function despachar_gestion_pv(){
		$id_pedido= $this->input->post('id_entrega');
		$id_local= $this->input->post('flocal');
		$resultado = $this->M_operaciones->despachar_directo1( $id_pedido, $id_local);
		$res = $this->registrar_comisiones($id_pedido);
		
		//////////////////////////////
		$this->obtener_pedidos_pv();
	}
    public function despachar_gestion(){
		$id_pedido= $this->input->post('id_entrega');
		$id_local= $this->input->post('flocal');
		$resultado = $this->M_operaciones->despachar_directo1( $id_pedido, $id_local);
		$res = $this->registrar_comisiones($id_pedido);
		$this->obtener_pedidos();
	}
	public function registrar_comisiones($id_pedido){
		//ejecutar comision
		$pedido = $this->M_operaciones->obt_pedido_pedidos($id_pedido);
		$detalles = $this->M_operaciones->obt_detalles_pedidos($id_pedido);
		$importe_total = 0;
		foreach ($detalles->result() as $key) {
			# code...
			$importe_total += $key->PVP * $key->cantidad - $key->descuento - $key->descuento_vip + $key->incremento;
		}
		if($pedido[0]->origen == 'Macoi'){
			$res = $this->M_operaciones->obtener_parametro('COMISION_MCOY');
			$row = $res->row();
			$com_mcoy = $row->valor_decimal;
		}else{
			$com_mcoy = 0;
		}
		

		if($pedido[0]->usuario_comisiona != 0){
			if($pedido[0]->id_canal == 4){//comision atencion
				$existe = $this->M_operaciones->existe_comision_atencion($id_pedido);
				if($existe == 0){
					$res = $this->M_operaciones->obtener_parametro('COMISION_ATENCION');
					$row = $res->row();
					$com_atencion = $row->valor_decimal;
					if($com_mcoy == 0){
						$valor_com = $importe_total * ($com_atencion/100); 
						$res = $this->M_operaciones->registrar_comision_atencion($pedido[0]->usuario_comisiona,$id_pedido,$valor_com);
						
					}						 
					else
						{
							$valor_com = $importe_total * ($com_mcoy/100);
							$res = $this->M_operaciones->registrar_comision_mcoy($pedido[0]->usuario_comisiona,$id_pedido,$valor_com);
							$res = $this->M_operaciones->cambiar_origen_macoi($pedido[0]->id_cliente);
						} 
					
					
				}
			}
			else
				if($pedido[0]->id_canal == 6){//comision mision
					$existe = $this->M_operaciones->existe_comision_mision($id_pedido);
					if($existe == 0){
						$res = $this->M_operaciones->obtener_parametro('COMISION_MISION');
						$row = $res->row();
						$com_mision = $row->valor_decimal;
						
						if($com_mcoy == 0)
							{
								$valor_com = $importe_total * ($com_mision/100);
								$res = $this->M_operaciones->registrar_comision_mision($pedido[0]->usuario_comisiona,$id_pedido,$valor_com);
							} 
						else
							{
								$valor_com = $importe_total * ($com_mcoy/100); 
								$res = $this->M_operaciones->registrar_comision_mcoy($pedido[0]->usuario_comisiona,$id_pedido,$valor_com);
								$res = $this->M_operaciones->cambiar_origen_macoi($pedido[0]->id_cliente);
							}
						
					}
					
				}
				else
					if($pedido[0]->id_canal == 21 || $pedido[0]->id_canal == 22){//comision online
						$res = $this->M_operaciones->obtener_parametro('COMISION_ONLINE');
						$row = $res->row();
						$com_online = $row->valor_decimal;
						
						if($com_mcoy == 0)
							$valor_com = $importe_total * ($com_online/100);  
						else
							$valor_com = $importe_total * ($com_mcoy/100); 
						$res = $this->M_operaciones->registrar_comision_online($pedido[0]->usuario_comisiona,$id_pedido,$valor_com);
					}
					
		}
		return true;
	}
	public function ejecutar_despacho1(){
		$id_pedido = $this->input->post('id_pedido2');
		$id_empresa = $this->M_operaciones->obt_empresa($id_pedido);
		if($id_empresa->num_rows()!=0){
			$id_empresa = $id_empresa->result();
			$id_empresa = $id_empresa[0]->id_empresa;
		}else $id_empresa=0;
		
		//$id_orden = $this->M_operaciones->obt_orden($id_pedido);
		$res = $this->registrar_comisiones($id_pedido);
		
		$resultado = $this->M_operaciones->despachar_envio( $id_pedido);
		if($resultado>0 && $id_empresa == 10){
			$resul=$this->M_configuracion->pedido_id($id_pedido);
			$cliente=$resul->result();
			$nombre = $cliente[0]->nombre_cliente.' '.$cliente[0]->apellidos;
			$email = $cliente[0]->email;
			
			$numero_envio = $this->M_configuracion->obt_nro_envio($id_pedido);
			$fecha = Date('Y-m-d');
			$mensaje = "<p><strong>Hola $nombre;</strong><br>
			<strong><br>
			  Queremos informarte que tu pedido ha sido despachado en el día de la  $fecha.&nbsp;Tu número de guía es: nº $numero_envio, con este número  podrás hacer el seguimiento en la página de OCA de la encomienda.</strong><br>
			<strong><br>
			  Cualquier consulta, podrás llamar a nuestro equipo de Atención al Cliente  marcando +54 11 47925585 o escribirnos a&nbsp;</strong><a href='mailto:consultas@dvigi.com.ar' target='_blank'><strong>consultas@dvigi.com.ar</strong></a><strong><br>
				Saludos.</strong></p>
		  <p><strong>&quot;Disfrutá de  agua pura todos los días con DVIGI&quot;</strong></p>
";
			
		 if($email == ''){
				$email = $this->M_operaciones->email_consultor($id_pedido);
				$mensaje_consultor = "<p><strong>Se le ha hecho el despacho del pedido al cliente $nombre el dia $fecha debe gestionar la información con el cliente.</strong><br></p>";
				$mensaje = $mensaje_consultor + $mensaje;
			}
		 
		  $this->sendMailMandril($email,'Notificaciones DVIGI', $mensaje);
			
		}
			
		redirect('dashboard_armador_desp');
	}
	public function ejecutar_despacho1_rev(){
		$id_pedido = $this->input->post('id_pedido2');
		$id_empresa = $this->M_operaciones->obt_empresa($id_pedido);
		if($id_empresa->num_rows()!=0){
			$id_empresa = $id_empresa->result();
			$id_empresa = $id_empresa[0]->id_empresa;
		}else $id_empresa=0;
		$id_orden = $this->M_operaciones->obt_orden($id_pedido);

		$respu = $this->M_operaciones->entrar_producto_almacen($id_pedido);	
		
		$resultado = $this->M_operaciones->despachar_envio( $id_pedido);
		if($resultado>0 && $id_empresa == 10){
			$resul=$this->M_configuracion->pedido_id($id_pedido);
			$cliente=$resul->result();
			$nombre = $cliente[0]->nombre_cliente.' '.$cliente[0]->apellidos;
			$email = $cliente[0]->email;
			
			$numero_envio = $this->M_configuracion->obt_nro_envio($id_pedido);
			$fecha = Date('Y-m-d');
			$mensaje = "<p><strong><em>Hola $nombre;</em></strong><br>
			<strong><em><br>
			  Queremos informarte que tu pedido ha sido despachado en el día de la  $fecha.&nbsp;Tu número de guía es: nº $numero_envio, con este número  podrás hacer el seguimiento en la página de OCA de la encomienda.</em></strong><br>
			<strong><em><br>
			  Cualquier consulta, podrás llamar a nuestro equipo de Atención al Cliente  marcando +54 1165549839  o escribirnos a&nbsp;</em></strong><a href='mailto:ventas@dvigi.com.ar' target='_blank'><strong><em>ventas@dvigi.com.ar</em></strong></a><strong><em><br>
				Saludos.</em></strong></p>
		  <p><strong><em>&quot;Disfrutá de  agua pura todos los días con DVIGI&quot;</em></strong></p><a href='https://www.tienda.dvigi.com.ar/repuestos_qO27328244XtOcxSM'><img src='https://dvigi-sistema.com/dvigi/api_cron/img/imagen2.png'></a>";
			
		 if($email = ''){
				$email = $this->M_operaciones->email_consultor($id_pedido);
				$mensaje_consultor = "<p><strong>Se le ha hecho el despacho del pedido al cliente $nombre el dia $fecha debe gestionar la información con el cliente.</strong><br></p>";
				$mensaje = $mensaje_consultor + $mensaje;
			}
		 
		  $this->sendMailMandril($email,'Notificaciones DVIGI', $mensaje);
			
		}
		$resu = $this->M_operaciones->guardar_estado_orden($id_orden,8,'Armado de pedidos & control de despachos - ACEPTADO');
		
		$this->control_despachos();
	}
	public function ejecutar_despacho_showroom(){
		$id_pedido = $this->input->post('id_pedidoshowroom1');
		$id_local = $this->input->post('sel_local');
		$id_orden = $this->M_operaciones->obt_orden($id_pedido);		
		$resultado = $this->M_operaciones->despachar_directo1( $id_pedido, $id_local);
		$resu = $this->M_operaciones->guardar_estado_orden($id_orden,8,'Armado de pedidos & control de despachos - ACEPTADO');
		$respu = $this->M_operaciones->entrar_producto_almacen($id_pedido);

		$estado_orden = 'Recibo de remitos firmados por clientes';
		$asunto='Armado de pedidos & control de despachos - ACEPTADO';			
		$resul=$this->M_configuracion->pedido_id($id_pedido);
		$cliente=$resul->result();
		$nombre = $cliente[0]->nombre_cliente.' '.$cliente[0]->apellidos;
		$mensaje = "<p><strong><em>Hola $nombre;</em></strong><br>
		<strong><em><br>
			Queremos informarte que tu pedido ha sido DESPACHADO correctamente. Ahora su pedido esta en $estado_orden.</em></strong><br>
		<strong><em><br>
			Cualquier consulta, podrás llamar a nuestro equipo de Atención al Cliente  marcando +54 1165549839  o escribirnos a&nbsp;</em></strong><a href='mailto:ventas@dvigi.com.ar' target='_blank'><strong><em>ventas@dvigi.com.ar</em></strong></a><strong><em><br>
			Saludos.</em></strong></p>
		<p><strong><em>&quot;Disfrutá de  agua pura todos los días con DVIGI&quot;</em></strong></p><a href='https://www.tienda.dvigi.com.ar/repuestos_qO27328244XtOcxSM'><img src='https://dvigi-sistema.com/dvigi/api_cron/img/imagen2.png'></a>";
		

		$email = $this->M_operaciones->obt_mail_orden($id_orden);
		$this->sendMailMandril($email,'Notificaciones DVIGI', $mensaje);

		$this->control_despachos();
	}
	public function modificar_entrega_tercero()
    {
		
	     $id_pedido_actual = $this->input->post('id_pedido');
		 $id_empresa_actual = $this->input->post('id_empresa');
		 
		 $id_pedido = $id_pedido_actual;
		 $id_empresa = $id_empresa_actual;
		 $id_estado = $this->input->post('id_estado');
		 $id_envio = $this->input->post('id_envio');
		 $tipo_envio = $this->input->post('tipo_envio');
		 $fecha = $this->input->post('fecha');

		 $nombre = $this->input->post('nombre');
		 $email = $this->input->post('email');
		 $pedido = $this->input->post('pedido');

		 
		 $recargo = $this->input->post('recargo');	 
		 $iva = $this->input->post('iva');	 
		 $calle_entrega = $this->input->post('calle');	 
		 $entrecalle1_entrega = $this->input->post('calle1');	 
		 $entrecalle2_entrega = $this->input->post('calle2');	 
		 $dpto_entrega = $this->input->post('dpto');	 
		 $nro_entrega = $this->input->post('nro_entrega');	 
		 $piso_entrega = $this->input->post('piso_entrega'); 
		 

		 $this->load->library('form_validation');
		 
		 $this->form_validation->set_rules('id_envio', 'Identificador de envío', 'required');
		 
		 if($tipo_envio == 1 ){//Si se cambia la forma de envío
			$id_estado =1;
			$despachado =1; 
 			$modificado =  $this->M_operaciones->registrar_entrega_directa($id_pedido, $despachado);
			$modificado = $this->M_operaciones->cancelar_entrega_tercero($id_pedido, $id_empresa);
			$this->entregas_terceros_despachadores(); 
		 }
		 else{

			if (   $this->form_validation->run() == true)
			{
				$modificado = $this->M_operaciones->modificar_entrega_tercero($id_pedido_actual, $id_empresa_actual, $id_pedido, $id_empresa, $id_estado, $id_envio, $fecha);
				
				if ($modificado == 1)
				{ 
					$this->notificacion = "La entrega se modificó satisfactoriamente.";
					$this->notificacion_error = false;

					if($id_estado == 1 || $id_envio !=  ''){// se  realizo el despacho por tercero y se mandará un email
						
					$detalles_pedido_terceros = $this->M_operaciones->entregas_terceros_envio($pedido);
					
					$detalles_pedidos_terceros = $this->M_operaciones->obt_pedido_tercero2($pedido);
					
					$identificador_envio = 0;
					$nombre_empresa = '';
					
					$datos_producto_mensaje = '';
					$importe_total = 0;
					foreach ($detalles_pedido_terceros->result() as $pr){					   
					   
					   $nombre_empresa = $pr->nombre;
					   $identificador_envio = $pr->id_envio;						
					   $nro_factura = $pr->no_factura;						
					}
					
					foreach ($detalles_pedidos_terceros->result() as $pr){					   
					   
					    $iva = $pr->iva;
					    $cantidad = $pr->cantidad;
					    $productos = $pr->producto;
					    $precio = $pr->importe;
						$descuento = $pr->descuento;
						$importe = ($cantidad*$precio)-$descuento;
						$importe_total+=$importe;
								
						$datos_producto_mensaje = $datos_producto_mensaje.
							'<ul>
								<li>PRODUCTO: '.$productos.'</li>
								<li>CANTIDAD: '.$cantidad.'</li>
								<li>PRECIO: $'.$precio.'</li>
								<li>DESCUENTO: '.$descuento.'%</li>
								<li>IMPORTE: $'.$importe.'</li>
							</ul>';							
					}
					
					$cuerpo_mensaje1 = $datos_producto_mensaje;
										
					/*$cuerpo_mensaje = 'Hola '.$nombre.' , ha realizado una compra en DVIGI.
							<p> Los datos de su  compra son los siguientes: 
							</br> Identificador del envío: '.$identificador_envio.'
				            </br> Número de pedido: '.$nro_factura.'
							</br> Empresa: '.$nombre_empresa.'
							</br> Dirección de entrega: calle '.$calle_entrega.' Nro '.$nro_entrega.' Entre '.$entrecalle1_entrega.' y '.$entrecalle2_entrega.' Piso '.$piso_entrega.' Dpto '.$dpto_entrega.'
							</br>'.$cuerpo_mensaje1.'
							</br> COSTO DE ENVÍO:  '.$recargo.'
							</br> IVA: '.$iva.'
							</br> IMPORTE BRUTO: $'.$importe_total.'</p>
							<p> Recibirá el nro. de guía para el seguimiento correspondiente una vez despachada la encomienda.</p>';
							
						$cuerpo_mensaje = $cuerpo_mensaje;*/
						//$this->sendMailGmail($email,$cuerpo_mensaje);				
					}
				}
				else
				{
					$this->notificacion = "ERROR. No se pudo modificar la entrega.";
					$this->notificacion_error = true;
				}
			}
			else
			{
				$this->notificacion = validation_errors();
				$this->notificacion_error = true;
			}
			if($this->notificacion_error == true){
			
			
				$datos['modo_edicion'] 		= true;
				$datos['notificacion'] = $this->notificacion ? $this->notificacion : "Error modificando la entrega por terceros";
				$datos['notificacion_error'] = $this->notificacion_error;
				
			$pedidos = $this->M_operaciones->pedidos();
			$empresas_flete = $this->M_operaciones->empresas_flete();
			$estados_entregas_terceros = $this->M_operaciones->estados_entregas_terceros();
			$detalles_pedidos_terceros = $this->M_operaciones->detalles_pedidos_terceros($id_pedido);
			
			$datos['pedidos'] 					= $pedidos;
			$datos['empresas_flete'] 			= $empresas_flete;
			$datos['estados_entregas_terceros'] = $estados_entregas_terceros;
			$datos['detalles_pedidos_terceros'] = $detalles_pedidos_terceros;
			
			$resultado = $this->M_operaciones->obt_entrega_tercero($id_pedido, $id_empresa);
			
			$entrega_tercero = $resultado->row();
			
			$id_pedido 	= $entrega_tercero->id_pedido;		   
			$id_empresa 	= $entrega_tercero->id_empresa;
			$id_estado 	= $entrega_tercero->id_estado;
			$id_envio 	= $entrega_tercero->id_envio;
			$fecha 		= $entrega_tercero->fecha;
			
				$datos['id_pedido_actual'] 	= $id_pedido;
				$datos['id_empresa_actual'] = $id_empresa;
				$datos['id_estado_actual'] 	= $id_estado;
				
				$datos['id_estado'] 	= $id_estado;
				$datos['id_envio'] 	= $id_envio;
				$datos['fecha'] 		= $fecha;
				
				$group = array('JefeArea', 'Administradores');
				if ($this->ion_auth->in_group($group))
						$jefe_area='true';
				else
						$jefe_area='false';

				$datos['jefe_area'] = $jefe_area;
					
				$this->load->view('lte_header', $datos);
				$this->load->view('v_nueva_entrega_tercero', $datos);
				$this->load->view('lte_footer', $datos);
				
			}else{
				$group = array('Despachadores');
				if ($this->ion_auth->in_group($group)){
					$this->entregas_terceros_despachadores();
				}else{
					$this->entregas_terceros();
				}
			}	
			
		 }
	}
	
	// ------------------------------------------------------
	// Confirmar cancelación de una entrega por tercero
	
	public function cfe_entrega_tercero($id_pedido, $id_empresa)
	{
		$datos['id_pedido'] = $id_pedido;
		$datos['id_empresa'] = $id_empresa;
		
		$this->load->view('lte_header', $datos);
 	    $this->load->view('vcan_entrega_tercero', $datos);
	    $this->load->view('lte_footer', $datos);
	}
	
	// ------------------------------------------------------
	// Cancelar entrega por tercero
	
    public function cancelar_entrega_tercero()
	{
		$id_pedido = $this->input->post('id_pedido');
		$id_empresa = $this->input->post('id_empresa');
		
		$cancelado = $this->M_operaciones->cancelar_entrega_tercero($id_pedido, $id_empresa);
		
		if ($cancelado == 1)
	    { 
		    $this->notificacion = "La entrega se eliminó correctamente.";
		    $this->notificacion_error = false;
		}
		else
		{
		    $this->notificacion = "No se pudo eliminar la entrega.";
		    $this->notificacion_error = true;  
		}
		
		$this->entregas_terceros();

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
		
		$entregas_directas = $this->M_operaciones->entregas_directas();	
        $datos['entregas_directas'] = $entregas_directas;

		$total_entregas_directas = $this->M_operaciones->total_entregas_directas();	
        $datos['total_entregas_directas'] = $total_entregas_directas;

		$total_entregas_directas_despachadas = $this->M_operaciones->total_entregas_directas_despachadas();	
        $datos['total_entregas_directas_despachadas'] = $total_entregas_directas_despachadas;
		
		$this->load->view('lte_header', $datos);
		$this->load->view('v_listado_entregas_directas', $datos);
		$this->load->view('lte_footer', $datos);
	}
	public function obtener_pedidos()
	{
		$fecha = new DateTime();		
		$anno  				= $fecha->format('Y');
		$datos['anno']  	= $anno;
		$mes  				= $fecha->format('m');
		$datos['mes']  		= $mes;
		$user = $this->ion_auth->user()->row();
		$usuario = $user->id;
		$pedidos = $this->M_operaciones->obtener_pedidos($usuario, $anno, $mes);	
        $datos['pedidos'] = $pedidos;		
		$bandera=0;
		
		$id = array();
		$id_pedido = array();
		$id_cliente = array();
		$no_factura = array();
		$producto = array();
		$color = array();
		$importe = array();
		$cobranza = array();
		$OCA = array();
		$armado = array();
		$despachado = array();
		$recargo = array();
		$iva = array();
		$dni = array();
		$convenir = array();
		$nombre_apellidos = array();
		$fecha = array();
		$acreditado = array();
		$mediopago = array();
		$incluye_seguro = array();

		$id_entrega = array();
		$canal = array();
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
					$id[$contador] = $pr->id;
					$id_pedido[$contador] = $pr->id_pedido;
					$id_cliente[$contador] = $pr->id_cliente;
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
					$dni[$contador] = $pr->dni;
					$fecha[$contador] = $pr->fecha_solicitud;
					$acreditado[$contador] = $pr->acreditado;
					$mediopago[$contador] = $pr->id_medio_cobranza;
					$incluye_seguro[$contador] = $pr->incluye_seguro;

					$convenir[$contador] = $pr->envio_por_coordinar;
					if($pr->id_canal == 4 || $pr->id_canal == 6){
						$canal[$contador] = 'ATC';
					}else{
						if($pr->id_canal == 21){
							$canal[$contador] = 'ML';
						}else{
							if($pr->id_canal == 22){
								$canal[$contador] = 'MS';
							}else{
								$canal[$contador] = 'ND';
							}
						}
					}

					$nombre_apellidos[$contador] = $pr->nombre.' '.$pr->apellidos;					
				}else{//es el mismo pedido
					$producto[$contador] = $producto[$contador]. $pr->producto.' '.$pr->color.'</br>';
					$importe[$contador] = $importe[$contador] + $pr->importe;
				}
			}else{//es otro pedido
				$contador = $contador + 1;
				$id[$contador] = $pr->id;
				$id_pedido[$contador] = $pr->id_pedido;
				$id_cliente[$contador] = $pr->id_cliente;
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
				$dni[$contador] = $pr->dni;
				$fecha[$contador] = $pr->fecha_solicitud;
				$acreditado[$contador] = $pr->acreditado;
				$mediopago[$contador] = $pr->id_medio_cobranza;
				$incluye_seguro[$contador] = $pr->incluye_seguro;
				$convenir[$contador] = $pr->envio_por_coordinar;
				if($pr->id_canal == 4 || $pr->id_canal == 6){
						$canal[$contador] = 'ATC';
					}else{
						if($pr->id_canal == 21){
							$canal[$contador] = 'ML';
						}else{
							if($pr->id_canal == 22){
								$canal[$contador] = 'MS';
							}else{
								$canal[$contador] = 'ND';
							}
						}
					}
				$nombre_apellidos[$contador] = $pr->nombre.' '.$pr->apellidos;
				//Sumo el recargo
				$importe[$contador-1] = $importe[$contador-1]+$recargo[$contador-1]+$iva[$contador-1]; 
			}
			$anterior=$pr->no_factura;
		}
		if($bandera == 1 )							
			$importe[$contador] = $importe[$contador]+$recargo[$contador]+$iva[$contador]; 						
		
		$datos['id'] 				=$id;
		$datos['id_pedido'] 		=$id_pedido;
		$datos['id_cliente'] 		=$id_cliente;
		$datos['id_entrega'] 		=$id_entrega;
		$datos['no_factura'] 		=$no_factura;
		$datos['producto'] 			=$producto;
		$datos['importe'] 			=$importe;
		$datos['cobranza'] 			=$cobranza;
		$datos['OCA'] 				=$OCA;
		$datos['armado'] 			=$armado;
		$datos['despachado'] 		=$despachado;
		$datos['dni'] 				=$dni;
		$datos['convenir'] 			=$convenir;
		$datos['nombre_apellidos'] 	=$nombre_apellidos;
		$datos['canal'] 			=$canal;
		$datos['fecha'] 			=$fecha;
		$datos['acreditado'] 		=$acreditado;
		$datos['mediopago'] 		=$mediopago;
		$datos['incluye_seguro'] 		=$incluye_seguro;
		$annos = $this->M_configuracion->obt_annos();
		$meses = $this->M_configuracion->obt_meses();
		
		$datos['annos']  	= $annos;
		$datos['meses']  	= $meses;
		$datos['cod_seguimiento']  = $this->M_configuracion->obt_codigos_seguimientos();
		
		$this->load->view('lte_header', $datos);
		$this->load->view('v_listado_pedidos_gestion', $datos);
		$this->load->view('lte_footer', $datos);
		
	}
	public function obtener_pedidos_filtrado()
	{
		$anno = $this->input->post('anno'); 
		$mes = $this->input->post('mes');
		$datos['anno']  	= $anno;		
		$datos['mes']  		= $mes;
		$user = $this->ion_auth->user()->row();
		$usuario = $user->id;
		$pedidos = $this->M_operaciones->obtener_pedidos($usuario, $anno, $mes);
        $datos['pedidos'] = $pedidos;		
		$bandera=0;
		
		$id = array();
		$id_pedido = array();
		$id_cliente = array();
		$id_entrega = array();
		$no_factura = array();
		$producto = array();
		$color = array();
		$importe = array();
		$cobranza = array();
		$OCA = array();
		$armado = array();
		$despachado = array();
		$recargo = array();
		$iva = array();
		$dni = array();
		$convenir = array();
		$nombre_apellidos = array();
		$fecha = array();
		$acreditado = array();
		$mediopago = array();
		$incluye_seguro = array();
		
		$canal = array();
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
					$id[$contador] = $pr->id;
					$id_pedido[$contador] = $pr->id_pedido;
					$id_cliente[$contador] = $pr->id_cliente;
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
					$dni[$contador] = $pr->dni;
					$convenir[$contador] = $pr->envio_por_coordinar;
					$fecha[$contador] = $pr->fecha_solicitud;
					$acreditado[$contador] = $pr->acreditado;
					$mediopago[$contador] = $pr->id_medio_cobranza;
					$incluye_seguro[$contador] = $pr->incluye_seguro;
					if($pr->id_canal == 4 || $pr->id_canal == 6){
						$canal[$contador] = 'ATC';
					}else{
						if($pr->id_canal == 21){
							$canal[$contador] = 'ML';
						}else{
							if($pr->id_canal == 22){
								$canal[$contador] = 'MS';
							}else{
								$canal[$contador] = 'ND';
							}
						}
					}
					$nombre_apellidos[$contador] = $pr->nombre.' '.$pr->apellidos;					
				}else{//es el mismo pedido
					$producto[$contador] = $producto[$contador]. $pr->producto.' '.$pr->color.'</br>';
					$importe[$contador] = $importe[$contador] + $pr->importe;
				}
			}else{//es otro pedido
				$contador = $contador + 1;
				$id[$contador] = $pr->id;
				$id_pedido[$contador] = $pr->id_pedido;
				$id_cliente[$contador] = $pr->id_cliente;
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
				$dni[$contador] = $pr->dni;
				$convenir[$contador] = $pr->envio_por_coordinar;
				$nombre_apellidos[$contador] = $pr->nombre.' '.$pr->apellidos;
				$fecha[$contador] = $pr->fecha_solicitud;
				$acreditado[$contador] = $pr->acreditado;
				$mediopago[$contador] = $pr->id_medio_cobranza;
				$incluye_seguro[$contador] = $pr->incluye_seguro;
				if($pr->id_canal == 4 || $pr->id_canal == 6){
						$canal[$contador] = 'ATC';
					}else{
						if($pr->id_canal == 21){
							$canal[$contador] = 'ML';
						}else{
							if($pr->id_canal == 22){
								$canal[$contador] = 'MS';
							}else{
								$canal[$contador] = 'ND';
							}
						}
					}
				//Sumo el recargo
				$importe[$contador-1] = $importe[$contador-1]+$recargo[$contador-1]+$iva[$contador-1]; 
			}
			$anterior=$pr->no_factura;
		}
		if($bandera == 1 )							
			$importe[$contador] = $importe[$contador]+$recargo[$contador]+$iva[$contador]; 						
		
		$datos['id'] 				=$id;
		$datos['id_pedido'] 		=$id_pedido;
		$datos['id_cliente'] 		=$id_cliente;
		$datos['id_entrega'] 		=$id_entrega;
		$datos['no_factura'] 		=$no_factura;
		$datos['producto'] 			=$producto;
		$datos['importe'] 			=$importe;
		$datos['cobranza'] 			=$cobranza;
		$datos['OCA'] 				=$OCA;
		$datos['armado'] 			=$armado;
		$datos['despachado'] 		=$despachado;
		$datos['dni'] 				=$dni;
		$datos['convenir'] 			=$convenir;
		$datos['nombre_apellidos'] 	=$nombre_apellidos;
		$datos['canal'] 			=$canal;
		$datos['fecha'] 			=$fecha;
		$datos['acreditado'] 		=$acreditado;
		$datos['mediopago'] 		=$mediopago;
		$datos['incluye_seguro'] 		=$incluye_seguro;
		$annos = $this->M_configuracion->obt_annos();
		$meses = $this->M_configuracion->obt_meses();
		
		$datos['annos']  	= $annos;
		$datos['meses']  	= $meses;
		$datos['cod_seguimiento']  = $this->M_configuracion->obt_codigos_seguimientos();
		
		$this->load->view('lte_header', $datos);
		$this->load->view('v_listado_pedidos_gestion', $datos);
		$this->load->view('lte_footer', $datos);
		
	}
	
	public function obtener_pedidos_filtrado_nombre()
	{
		$fnombre = $this->input->post('fnombre');
		$ftelefono = $this->input->post('ftelefono');
		$femail = $this->input->post('femail');
		$fdni = $this->input->post('fdni');

		$fnombre 	= trim($fnombre);
		$ftelefono 	= trim($ftelefono);
		$femail 	= trim($femail);
		$fdni 		= trim($fdni);

		$anno = $this->input->post('anno'); 
		$mes = $this->input->post('mes');
		$datos['anno']  	= $anno;		
		$datos['mes']  		= $mes;
		$user = $this->ion_auth->user()->row();
		$usuario = $user->id;
		$pedidos = $this->M_operaciones->obtener_pedidos_nombre($usuario, $fnombre, $ftelefono, $femail, $fdni);
        $datos['pedidos'] = $pedidos;		
		$bandera=0;
		
		$id = array();
		$id_pedido = array();
		$id_cliente = array();
		$id_entrega = array();
		$no_factura = array();
		$producto = array();
		$color = array();
		$importe = array();
		$cobranza = array();
		$OCA = array();
		$armado = array();
		$despachado = array();
		$recargo = array();
		$iva = array();
		$dni = array();
		$convenir = array();
		$nombre_apellidos = array();
		$fecha = array();
		$acreditado = array();
		$mediopago = array();
		$incluye_seguro = array();
		
		$canal = array();
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
					$id[$contador] = $pr->id;
					$id_pedido[$contador] = $pr->id_pedido;
					$id_cliente[$contador] = $pr->id_cliente;
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
					$dni[$contador] = $pr->dni;
					$convenir[$contador] = $pr->envio_por_coordinar;
					$fecha[$contador] = $pr->fecha_solicitud;
					$acreditado[$contador] = $pr->acreditado;
					$mediopago[$contador] = $pr->id_medio_cobranza;
					$incluye_seguro[$contador] = $pr->incluye_seguro;
					if($pr->id_canal == 4 || $pr->id_canal == 6){
						$canal[$contador] = 'ATC';
					}else{
						if($pr->id_canal == 21){
							$canal[$contador] = 'ML';
						}else{
							if($pr->id_canal == 22){
								$canal[$contador] = 'MS';
							}else{
								$canal[$contador] = 'ND';
							}
						}
					}
					$nombre_apellidos[$contador] = $pr->nombre.' '.$pr->apellidos;					
				}else{//es el mismo pedido
					$producto[$contador] = $producto[$contador]. $pr->producto.' '.$pr->color.'</br>';
					$importe[$contador] = $importe[$contador] + $pr->importe;
				}
			}else{//es otro pedido
				$contador = $contador + 1;
				$id[$contador] = $pr->id;
				$id_pedido[$contador] = $pr->id_pedido;
				$id_cliente[$contador] = $pr->id_cliente;
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
				$dni[$contador] = $pr->dni;
				$convenir[$contador] = $pr->envio_por_coordinar;
				$nombre_apellidos[$contador] = $pr->nombre.' '.$pr->apellidos;
				$fecha[$contador] = $pr->fecha_solicitud;
				$acreditado[$contador] = $pr->acreditado;
				$mediopago[$contador] = $pr->id_medio_cobranza;
				$incluye_seguro[$contador] = $pr->incluye_seguro;
				if($pr->id_canal == 4 || $pr->id_canal == 6){
						$canal[$contador] = 'ATC';
					}else{
						if($pr->id_canal == 21){
							$canal[$contador] = 'ML';
						}else{
							if($pr->id_canal == 22){
								$canal[$contador] = 'MS';
							}else{
								$canal[$contador] = 'ND';
							}
						}
					}
				//Sumo el recargo
				$importe[$contador-1] = $importe[$contador-1]+$recargo[$contador-1]+$iva[$contador-1]; 
			}
			$anterior=$pr->no_factura;
		}
		if($bandera == 1 )							
			$importe[$contador] = $importe[$contador]+$recargo[$contador]+$iva[$contador]; 						
		
		$datos['id'] 				=$id;
		$datos['id_pedido'] 		=$id_pedido;
		$datos['id_cliente'] 		=$id_cliente;
		$datos['id_entrega'] 		=$id_entrega;
		$datos['no_factura'] 		=$no_factura;
		$datos['producto'] 			=$producto;
		$datos['importe'] 			=$importe;
		$datos['cobranza'] 			=$cobranza;
		$datos['OCA'] 				=$OCA;
		$datos['armado'] 			=$armado;
		$datos['despachado'] 		=$despachado;
		$datos['dni'] 				=$dni;
		$datos['convenir'] 			=$convenir;
		$datos['nombre_apellidos'] 	=$nombre_apellidos;
		$datos['canal'] 			=$canal;
		$datos['fecha'] 			=$fecha;
		$datos['acreditado'] 		=$acreditado;
		$datos['mediopago'] 		=$mediopago;
		$datos['incluye_seguro'] 		=$incluye_seguro;
		$annos = $this->M_configuracion->obt_annos();
		$meses = $this->M_configuracion->obt_meses();
		
		$datos['annos']  	= $annos;
		$datos['meses']  	= $meses;
		$datos['cod_seguimiento']  = $this->M_configuracion->obt_codigos_seguimientos();
		
		$this->load->view('lte_header', $datos);
		$this->load->view('v_listado_pedidos_gestion', $datos);
		$this->load->view('lte_footer', $datos);
		
	}
	//Mostrar pedidos ok
	public function obtener_pedidos_filtrado_ok()
	{
		$fecha = new DateTime();		
		$anno  				= $this->input->post('anno1');;
		$datos['anno']  	= $anno;
		$mes  				= $this->input->post('mes1');;
		$datos['mes']  		= $mes;
		$user = $this->ion_auth->user()->row();
		$usuario = $user->id;
		$pedidos = $this->M_operaciones->obtener_pedidos_ok($usuario,$anno, $mes);	
        $datos['pedidos'] = $pedidos;		
		$bandera=0;
		
		$id = array();
		$id_pedido = array();
		$id_cliente = array();
		$id_entrega = array();
		$no_factura = array();
		$producto = array();
		$color = array();
		$importe = array();
		$cobranza = array();
		$OCA = array();
		$armado = array();
		$despachado = array();
		$recargo = array();
		$iva = array();
		$dni = array();
		$convenir = array();
		$nombre_apellidos = array();
		$fecha = array();
		$acreditado = array();
		$mediopago = array();
		$incluye_seguro = array();

		$canal = array();
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
					$id[$contador] = $pr->id;
					$id_pedido[$contador] = $pr->id_pedido;
					$id_cliente[$contador] = $pr->id_cliente;
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
					$dni[$contador] = $pr->dni;
					$convenir[$contador] = $pr->envio_por_coordinar;
					$nombre_apellidos[$contador] = $pr->nombre.' '.$pr->apellidos;	
					$fecha[$contador] = $pr->fecha_solicitud;
					$acreditado[$contador] = $pr->acreditado;
					$mediopago[$contador] = $pr->id_medio_cobranza;
					$incluye_seguro[$contador] = $pr->incluye_seguro;

					if($pr->id_canal == 4 || $pr->id_canal == 6){
						$canal[$contador] = 'ATC';
					}else{
						if($pr->id_canal == 21){
							$canal[$contador] = 'ML';
						}else{
							if($pr->id_canal == 22){
								$canal[$contador] = 'MS';
							}else{
								$canal[$contador] = 'ND';
							}
						}
					}					
				}else{//es el mismo pedido
					$producto[$contador] = $producto[$contador]. $pr->producto.' '.$pr->color.'</br>';
					$importe[$contador] = $importe[$contador] + $pr->importe;
				}
			}else{//es otro pedido
				$contador = $contador + 1;
				$id[$contador] = $pr->id;
				$id_pedido[$contador] = $pr->id_pedido;
				$id_cliente[$contador] = $pr->id_cliente;
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
				$dni[$contador] = $pr->dni;
				$convenir[$contador] = $pr->envio_por_coordinar;
				$nombre_apellidos[$contador] = $pr->nombre.' '.$pr->apellidos;
				$fecha[$contador] = $pr->fecha_solicitud;
				$acreditado[$contador] = $pr->acreditado;
				$mediopago[$contador] = $pr->id_medio_cobranza;
				$incluye_seguro[$contador] = $pr->incluye_seguro;
				if($pr->id_canal == 4 || $pr->id_canal == 6){
						$canal[$contador] = 'ATC';
					}else{
						if($pr->id_canal == 21){
							$canal[$contador] = 'ML';
						}else{
							if($pr->id_canal == 22){
								$canal[$contador] = 'MS';
							}else{
								$canal[$contador] = 'ND';
							}
						}
					}
				//Sumo el recargo
				$importe[$contador-1] = $importe[$contador-1]+$recargo[$contador-1]+$iva[$contador-1]; 
			}
			$anterior=$pr->no_factura;
		}
		if($bandera == 1 )							
			$importe[$contador] = $importe[$contador]+$recargo[$contador]+$iva[$contador]; 						
		
		$datos['id'] 				=$id;
		$datos['id_pedido'] 		=$id_pedido;
		$datos['id_cliente'] 		=$id_cliente;
		$datos['id_entrega'] 		=$id_entrega;
		$datos['no_factura'] 		=$no_factura;
		$datos['producto'] 			=$producto;
		$datos['importe'] 			=$importe;
		$datos['cobranza'] 			=$cobranza;
		$datos['OCA'] 				=$OCA;
		$datos['armado'] 			=$armado;
		$datos['despachado'] 		=$despachado;
		$datos['dni'] 				=$dni;
		$datos['convenir'] 			=$convenir;
		$datos['nombre_apellidos'] 	=$nombre_apellidos;
		$datos['canal'] 			=$canal;
		$datos['fecha'] 			=$fecha;
		$datos['acreditado'] 		=$acreditado;
		$datos['mediopago'] 		=$mediopago;
		$datos['incluye_seguro'] 		=$incluye_seguro;
		$annos = $this->M_configuracion->obt_annos();
		$meses = $this->M_configuracion->obt_meses();
		
		$datos['annos']  	= $annos;
		$datos['meses']  	= $meses;
		$datos['cod_seguimiento']  = $this->M_configuracion->obt_codigos_seguimientos();
		
		$this->load->view('lte_header', $datos);
		$this->load->view('v_listado_pedidos_gestion', $datos);
		$this->load->view('lte_footer', $datos);
		
	}
	public function obtener_pedidos_pv()
	{
		$fecha = new DateTime();		
		$anno  				= $fecha->format('Y');
		$datos['anno']  	= $anno;
		$mes  				= $fecha->format('m');
		$datos['mes']  		= $mes;
		$user = $this->ion_auth->user()->row();
		$usuario = $user->id;
		$pedidos = $this->M_operaciones->obtener_pedidos_pv( $anno, $mes);	
        $datos['pedidos'] = $pedidos;		
		$bandera=0;
		
		$id = array();
		$id_pedido = array();
		$no_factura = array();
		$producto = array();
		$color = array();
		$importe = array();
		$cobranza = array();
		$OCA = array();
		$armado = array();
		$despachado = array();
		$recargo = array();
		$iva = array();
		$dni = array();
		$convenir = array();
		$nombre_apellidos = array();
		$fecha = array();
		$acreditado = array();
		$mediopago = array();
		$local = array();
		$usuario = array();
		$id_entrega = array();
		$canal = array();
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
					$dni[$contador] = $pr->dni;
					$fecha[$contador] = $pr->fecha_solicitud;
					$acreditado[$contador] = $pr->acreditado;
					$mediopago[$contador] = $pr->id_medio_cobranza;
					$local[$contador] = $pr->local;
					$usuario[$contador] = $pr->usuario;

					$convenir[$contador] = $pr->envio_por_coordinar;
					if($pr->id_canal == 4 || $pr->id_canal == 6){
						$canal[$contador] = 'ATC';
					}else{
						if($pr->id_canal == 21){
							$canal[$contador] = 'ML';
						}else{
							if($pr->id_canal == 22){
								$canal[$contador] = 'MS';
							}else{
								$canal[$contador] = 'ND';
							}
						}
					}

					$nombre_apellidos[$contador] = $pr->nombre.' '.$pr->apellidos;					
				}else{//es el mismo pedido
					$producto[$contador] = $producto[$contador]. $pr->producto.' '.$pr->color.'</br>';
					$importe[$contador] = $importe[$contador] + $pr->importe;
				}
			}else{//es otro pedido
				$contador = $contador + 1;
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
				$dni[$contador] = $pr->dni;
				$fecha[$contador] = $pr->fecha_solicitud;
				$acreditado[$contador] = $pr->acreditado;
				$mediopago[$contador] = $pr->id_medio_cobranza;
				$local[$contador] = $pr->local;
				$usuario[$contador] = $pr->usuario;
				$convenir[$contador] = $pr->envio_por_coordinar;
				if($pr->id_canal == 4 || $pr->id_canal == 6){
						$canal[$contador] = 'ATC';
					}else{
						if($pr->id_canal == 21){
							$canal[$contador] = 'ML';
						}else{
							if($pr->id_canal == 22){
								$canal[$contador] = 'MS';
							}else{
								$canal[$contador] = 'ND';
							}
						}
					}
				$nombre_apellidos[$contador] = $pr->nombre.' '.$pr->apellidos;
				//Sumo el recargo
				$importe[$contador-1] = $importe[$contador-1]+$recargo[$contador-1]+$iva[$contador-1]; 
			}
			$anterior=$pr->no_factura;
		}
		if($bandera == 1 )							
			$importe[$contador] = $importe[$contador]+$recargo[$contador]+$iva[$contador]; 						
		
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
		$datos['convenir'] 			=$convenir;
		$datos['nombre_apellidos'] 	=$nombre_apellidos;
		$datos['canal'] 			=$canal;
		$datos['fecha'] 			=$fecha;
		$datos['acreditado'] 		=$acreditado;
		$datos['mediopago'] 		=$mediopago;
		$datos['local'] 			=$local;
		$datos['usuario'] 			=$usuario;
		$annos = $this->M_configuracion->obt_annos();
		$meses = $this->M_configuracion->obt_meses();
		
		$datos['annos']  	= $annos;
		$datos['meses']  	= $meses;
		
		
		$this->load->view('lte_header', $datos);
		$this->load->view('v_listado_pedidos_gestion_pv', $datos);
		$this->load->view('lte_footer', $datos);
		
	}
	public function obtener_pedidos_filtrado_pv()
	{
		$anno = $this->input->post('anno'); 
		$mes = $this->input->post('mes');
		$datos['anno']  	= $anno;		
		$datos['mes']  		= $mes;
		$user = $this->ion_auth->user()->row();
		$usuario = $user->id;
		$pedidos = $this->M_operaciones->obtener_pedidos_pv( $anno, $mes);
        $datos['pedidos'] = $pedidos;		
		$bandera=0;
		
		$id = array();
		$id_pedido = array();
		$id_entrega = array();
		$no_factura = array();
		$producto = array();
		$color = array();
		$importe = array();
		$cobranza = array();
		$OCA = array();
		$armado = array();
		$despachado = array();
		$recargo = array();
		$iva = array();
		$dni = array();
		$convenir = array();
		$nombre_apellidos = array();
		$fecha = array();
		$acreditado = array();
		$mediopago = array();
		$local = array();
		$usuario = array();
		$canal = array();
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
					$dni[$contador] = $pr->dni;
					$convenir[$contador] = $pr->envio_por_coordinar;
					$fecha[$contador] = $pr->fecha_solicitud;
					$acreditado[$contador] = $pr->acreditado;
					$mediopago[$contador] = $pr->id_medio_cobranza;
					$local[$contador] = $pr->local;
					$usuario[$contador] = $pr->usuario;
					if($pr->id_canal == 4 || $pr->id_canal == 6){
						$canal[$contador] = 'ATC';
					}else{
						if($pr->id_canal == 21){
							$canal[$contador] = 'ML';
						}else{
							if($pr->id_canal == 22){
								$canal[$contador] = 'MS';
							}else{
								$canal[$contador] = 'ND';
							}
						}
					}
					$nombre_apellidos[$contador] = $pr->nombre.' '.$pr->apellidos;					
				}else{//es el mismo pedido
					$producto[$contador] = $producto[$contador]. $pr->producto.' '.$pr->color.'</br>';
					$importe[$contador] = $importe[$contador] + $pr->importe;
				}
			}else{//es otro pedido
				$contador = $contador + 1;
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
				$dni[$contador] = $pr->dni;
				$convenir[$contador] = $pr->envio_por_coordinar;
				$nombre_apellidos[$contador] = $pr->nombre.' '.$pr->apellidos;
				$fecha[$contador] = $pr->fecha_solicitud;
				$acreditado[$contador] = $pr->acreditado;
				$mediopago[$contador] = $pr->id_medio_cobranza;
				$local[$contador] = $pr->local;
				$usuario[$contador] = $pr->usuario;
				if($pr->id_canal == 4 || $pr->id_canal == 6){
						$canal[$contador] = 'ATC';
					}else{
						if($pr->id_canal == 21){
							$canal[$contador] = 'ML';
						}else{
							if($pr->id_canal == 22){
								$canal[$contador] = 'MS';
							}else{
								$canal[$contador] = 'ND';
							}
						}
					}
				//Sumo el recargo
				$importe[$contador-1] = $importe[$contador-1]+$recargo[$contador-1]+$iva[$contador-1]; 
			}
			$anterior=$pr->no_factura;
		}
		if($bandera == 1 )							
			$importe[$contador] = $importe[$contador]+$recargo[$contador]+$iva[$contador]; 						
		
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
		$datos['convenir'] 			=$convenir;
		$datos['nombre_apellidos'] 	=$nombre_apellidos;
		$datos['canal'] 			=$canal;
		$datos['fecha'] 			=$fecha;
		$datos['acreditado'] 		=$acreditado;
		$datos['mediopago'] 		=$mediopago;
		$datos['local'] 		=$local;
		$datos['usuario'] 		=$usuario;
		$annos = $this->M_configuracion->obt_annos();
		$meses = $this->M_configuracion->obt_meses();
		
		$datos['annos']  	= $annos;
		$datos['meses']  	= $meses;
		
		
		$this->load->view('lte_header', $datos);
		$this->load->view('v_listado_pedidos_gestion_pv', $datos);
		$this->load->view('lte_footer', $datos);
		
	}
	public function obtener_pedidos_filtrado_locales_pv()
	{
		$fnombre = $this->input->post('flocal');
		$fnombre = trim($fnombre);
		$anno = $this->input->post('anno'); 
		$mes = $this->input->post('mes');
		$datos['anno']  	= $anno;		
		$datos['mes']  		= $mes;
		$user = $this->ion_auth->user()->row();
		$usuario = $user->id;
		$pedidos = $this->M_operaciones->obtener_pedidos_locales_pv($fnombre);
        $datos['pedidos'] = $pedidos;		
		$bandera=0;
		
		$id = array();
		$id_pedido = array();
		$id_entrega = array();
		$no_factura = array();
		$producto = array();
		$color = array();
		$importe = array();
		$cobranza = array();
		$OCA = array();
		$armado = array();
		$despachado = array();
		$recargo = array();
		$iva = array();
		$dni = array();
		$convenir = array();
		$nombre_apellidos = array();
		$fecha = array();
		$acreditado = array();
		$mediopago = array();
		$local = array();
		$usuario = array();
		
		$canal = array();
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
					$dni[$contador] = $pr->dni;
					$convenir[$contador] = $pr->envio_por_coordinar;
					$fecha[$contador] = $pr->fecha_solicitud;
					$acreditado[$contador] = $pr->acreditado;
					$mediopago[$contador] = $pr->id_medio_cobranza;
					$local[$contador] = $pr->local;
					$usuario[$contador] = $pr->usuario;
					if($pr->id_canal == 4 || $pr->id_canal == 6){
						$canal[$contador] = 'ATC';
					}else{
						if($pr->id_canal == 21){
							$canal[$contador] = 'ML';
						}else{
							if($pr->id_canal == 22){
								$canal[$contador] = 'MS';
							}else{
								$canal[$contador] = 'ND';
							}
						}
					}
					$nombre_apellidos[$contador] = $pr->nombre.' '.$pr->apellidos;					
				}else{//es el mismo pedido
					$producto[$contador] = $producto[$contador]. $pr->producto.' '.$pr->color.'</br>';
					$importe[$contador] = $importe[$contador] + $pr->importe;
				}
			}else{//es otro pedido
				$contador = $contador + 1;
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
				$dni[$contador] = $pr->dni;
				$convenir[$contador] = $pr->envio_por_coordinar;
				$nombre_apellidos[$contador] = $pr->nombre.' '.$pr->apellidos;
				$fecha[$contador] = $pr->fecha_solicitud;
				$acreditado[$contador] = $pr->acreditado;
				$mediopago[$contador] = $pr->id_medio_cobranza;
				$local[$contador] = $pr->local;
				$usuario[$contador] = $pr->usuario;
				if($pr->id_canal == 4 || $pr->id_canal == 6){
						$canal[$contador] = 'ATC';
					}else{
						if($pr->id_canal == 21){
							$canal[$contador] = 'ML';
						}else{
							if($pr->id_canal == 22){
								$canal[$contador] = 'MS';
							}else{
								$canal[$contador] = 'ND';
							}
						}
					}
				//Sumo el recargo
				$importe[$contador-1] = $importe[$contador-1]+$recargo[$contador-1]+$iva[$contador-1]; 
			}
			$anterior=$pr->no_factura;
		}
		if($bandera == 1 )							
			$importe[$contador] = $importe[$contador]+$recargo[$contador]+$iva[$contador]; 						
		
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
		$datos['convenir'] 			=$convenir;
		$datos['nombre_apellidos'] 	=$nombre_apellidos;
		$datos['canal'] 			=$canal;
		$datos['fecha'] 			=$fecha;
		$datos['acreditado'] 		=$acreditado;
		$datos['mediopago'] 		=$mediopago;
		$datos['local'] 		=$local;
		$datos['usuario'] 		=$usuario;
		$annos = $this->M_configuracion->obt_annos();
		$meses = $this->M_configuracion->obt_meses();
		
		$datos['annos']  	= $annos;
		$datos['meses']  	= $meses;
		
		
		$this->load->view('lte_header', $datos);
		$this->load->view('v_listado_pedidos_gestion_pv', $datos);
		$this->load->view('lte_footer', $datos);
		
	}
	public function obtener_pedidos_filtrado_nombre_pv()
	{
		$fnombre = $this->input->post('fnombre');
		$ftelefono = $this->input->post('ftelefono');
		$femail = $this->input->post('femail');
		$fdni = $this->input->post('fdni');

		$fdni 		= trim($fdni);
		$fnombre 	= trim($fnombre);
		$ftelefono 	= trim($ftelefono);
		$femail 	= trim($femail);		

		$anno = $this->input->post('anno'); 
		$mes = $this->input->post('mes');
		$datos['anno']  	= $anno;		
		$datos['mes']  		= $mes;
		$user = $this->ion_auth->user()->row();
		$usuario = $user->id;
		$pedidos = $this->M_operaciones->obtener_pedidos_nombre_pv( $fnombre, $ftelefono, $femail, $fdni);
        $datos['pedidos'] = $pedidos;		
		$bandera=0;
		
		$id = array();
		$id_pedido = array();
		$id_entrega = array();
		$no_factura = array();
		$producto = array();
		$color = array();
		$importe = array();
		$cobranza = array();
		$OCA = array();
		$armado = array();
		$despachado = array();
		$recargo = array();
		$iva = array();
		$dni = array();
		$convenir = array();
		$nombre_apellidos = array();
		$fecha = array();
		$acreditado = array();
		$mediopago = array();
		$local = array();
		$usuario = array();
		
		$canal = array();
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
					$dni[$contador] = $pr->dni;
					$convenir[$contador] = $pr->envio_por_coordinar;
					$fecha[$contador] = $pr->fecha_solicitud;
					$acreditado[$contador] = $pr->acreditado;
					$mediopago[$contador] = $pr->id_medio_cobranza;
					$local[$contador] = $pr->local;
					$usuario[$contador] = $pr->usuario;
					if($pr->id_canal == 4 || $pr->id_canal == 6){
						$canal[$contador] = 'ATC';
					}else{
						if($pr->id_canal == 21){
							$canal[$contador] = 'ML';
						}else{
							if($pr->id_canal == 22){
								$canal[$contador] = 'MS';
							}else{
								$canal[$contador] = 'ND';
							}
						}
					}
					$nombre_apellidos[$contador] = $pr->nombre.' '.$pr->apellidos;					
				}else{//es el mismo pedido
					$producto[$contador] = $producto[$contador]. $pr->producto.' '.$pr->color.'</br>';
					$importe[$contador] = $importe[$contador] + $pr->importe;
				}
			}else{//es otro pedido
				$contador = $contador + 1;
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
				$dni[$contador] = $pr->dni;
				$convenir[$contador] = $pr->envio_por_coordinar;
				$nombre_apellidos[$contador] = $pr->nombre.' '.$pr->apellidos;
				$fecha[$contador] = $pr->fecha_solicitud;
				$acreditado[$contador] = $pr->acreditado;
				$mediopago[$contador] = $pr->id_medio_cobranza;
				$local[$contador] = $pr->local;
				$usuario[$contador] = $pr->usuario;
				if($pr->id_canal == 4 || $pr->id_canal == 6){
						$canal[$contador] = 'ATC';
					}else{
						if($pr->id_canal == 21){
							$canal[$contador] = 'ML';
						}else{
							if($pr->id_canal == 22){
								$canal[$contador] = 'MS';
							}else{
								$canal[$contador] = 'ND';
							}
						}
					}
				//Sumo el recargo
				$importe[$contador-1] = $importe[$contador-1]+$recargo[$contador-1]+$iva[$contador-1]; 
			}
			$anterior=$pr->no_factura;
		}
		if($bandera == 1 )							
			$importe[$contador] = $importe[$contador]+$recargo[$contador]+$iva[$contador]; 						
		
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
		$datos['convenir'] 			=$convenir;
		$datos['nombre_apellidos'] 	=$nombre_apellidos;
		$datos['canal'] 			=$canal;
		$datos['fecha'] 			=$fecha;
		$datos['acreditado'] 		=$acreditado;
		$datos['mediopago'] 		=$mediopago;
		$datos['local'] 		=$local;
		$datos['usuario'] 		=$usuario;
		$annos = $this->M_configuracion->obt_annos();
		$meses = $this->M_configuracion->obt_meses();
		
		$datos['annos']  	= $annos;
		$datos['meses']  	= $meses;
		
		
		$this->load->view('lte_header', $datos);
		$this->load->view('v_listado_pedidos_gestion_pv', $datos);
		$this->load->view('lte_footer', $datos);
		
	}
	//Mostrar pedidos ok
	public function obtener_pedidos_filtrado_ok_pv()
	{
		$fecha = new DateTime();		
		$anno  				= $this->input->post('anno1');;
		$datos['anno']  	= $anno;
		$mes  				= $this->input->post('mes1');;
		$datos['mes']  		= $mes;
		$user = $this->ion_auth->user()->row();
		$usuario = $user->id;
		$pedidos = $this->M_operaciones->obtener_pedidos_ok_pv($anno, $mes);	
        $datos['pedidos'] = $pedidos;		
		$bandera=0;
		
		$id = array();
		$id_pedido = array();
		$id_entrega = array();
		$no_factura = array();
		$producto = array();
		$color = array();
		$importe = array();
		$cobranza = array();
		$OCA = array();
		$armado = array();
		$despachado = array();
		$recargo = array();
		$iva = array();
		$dni = array();
		$convenir = array();
		$nombre_apellidos = array();
		$fecha = array();
		$acreditado = array();
		$mediopago = array();
		$local = array();
		$usuario = array();

		$canal = array();
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
					$dni[$contador] = $pr->dni;
					$convenir[$contador] = $pr->envio_por_coordinar;
					$nombre_apellidos[$contador] = $pr->nombre.' '.$pr->apellidos;	
					$fecha[$contador] = $pr->fecha_solicitud;
					$acreditado[$contador] = $pr->acreditado;
					$mediopago[$contador] = $pr->id_medio_cobranza;
					$local[$contador] = $pr->local;
					$usuario[$contador] = $pr->usuario;

					if($pr->id_canal == 4 || $pr->id_canal == 6){
						$canal[$contador] = 'ATC';
					}else{
						if($pr->id_canal == 21){
							$canal[$contador] = 'ML';
						}else{
							if($pr->id_canal == 22){
								$canal[$contador] = 'MS';
							}else{
								$canal[$contador] = 'ND';
							}
						}
					}					
				}else{//es el mismo pedido
					$producto[$contador] = $producto[$contador]. $pr->producto.' '.$pr->color.'</br>';
					$importe[$contador] = $importe[$contador] + $pr->importe;
				}
			}else{//es otro pedido
				$contador = $contador + 1;
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
				$dni[$contador] = $pr->dni;
				$convenir[$contador] = $pr->envio_por_coordinar;
				$nombre_apellidos[$contador] = $pr->nombre.' '.$pr->apellidos;
				$fecha[$contador] = $pr->fecha_solicitud;
				$acreditado[$contador] = $pr->acreditado;
				$mediopago[$contador] = $pr->id_medio_cobranza;
				$local[$contador] = $pr->local;
				$usuario[$contador] = $pr->usuario;
				if($pr->id_canal == 4 || $pr->id_canal == 6){
						$canal[$contador] = 'ATC';
					}else{
						if($pr->id_canal == 21){
							$canal[$contador] = 'ML';
						}else{
							if($pr->id_canal == 22){
								$canal[$contador] = 'MS';
							}else{
								$canal[$contador] = 'ND';
							}
						}
					}
				//Sumo el recargo
				$importe[$contador-1] = $importe[$contador-1]+$recargo[$contador-1]+$iva[$contador-1]; 
			}
			$anterior=$pr->no_factura;
		}
		if($bandera == 1 )							
			$importe[$contador] = $importe[$contador]+$recargo[$contador]+$iva[$contador]; 						
		
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
		$datos['convenir'] 			=$convenir;
		$datos['nombre_apellidos'] 	=$nombre_apellidos;
		$datos['canal'] 			=$canal;
		$datos['fecha'] 			=$fecha;
		$datos['acreditado'] 		=$acreditado;
		$datos['mediopago'] 		=$mediopago;
		$datos['local'] 		=$local;
		$datos['usuario'] 		=$usuario;
		$annos = $this->M_configuracion->obt_annos();
		$meses = $this->M_configuracion->obt_meses();
		
		$datos['annos']  	= $annos;
		$datos['meses']  	= $meses;
		
		
		$this->load->view('lte_header', $datos);
		$this->load->view('v_listado_pedidos_gestion_pv', $datos);
		$this->load->view('lte_footer', $datos);
		
	}
	
	// ------------------------------------------------------
	// Nueva entrega directa
	
	public function nueva_entrega_directa()
	{
		$pedidos = $this->M_operaciones->pedidos();
		
		$datos['pedidos'] = $pedidos;
		
		$datos['notificacion'] = $this->notificacion ? $this->notificacion : "Especifique los datos de la entrega:";
		$datos['notificacion_error'] = $this->notificacion_error;
		$datos['modo_edicion'] = false;
		
		$this->load->view('lte_header', $datos);
		$this->load->view('v_nueva_entrega_directa', $datos);
		$this->load->view('lte_footer', $datos);	
	}
	
	// ------------------------------------------------------
	// Registrar entrega directa
	
    public function registrar_entrega_directa()
    {
		 $id_pedido = $this->input->post('id_pedido');
		 $despachado = $this->input->post('despachado');
		 
		 if ($despachado == 'on') $despachado = 1; else $despachado = 0;
		 
		 if ($id_pedido != '')
		 {
		 
			 $registrado = $this->M_operaciones->registrar_entrega_directa($id_pedido, $despachado);
			 
			 $mensaje = "";
			 if ($registrado == 1)
				 { 
					 $this->notificacion = "La entrega se registró satisfactoriamente.";
		             $this->notificacion_error = false;
				 }
				 else
				 {
					 $this->notificacion = "ERROR. No se pudo registrar la entrega.";
		             $this->notificacion_error = true;
				 }
		 }
		 else
		 {
			 $this->notificacion = "ERROR. No se pudo registrar la entrega. Verifique los datos especificados.";
             $this->notificacion_error = true;
		 }
		 
		 $this->nueva_entrega_directa();
    }
	
	// ------------------------------------------------------
	// Editar entrega directa
	
	public function editar_entrega_directa($id_entrega)
	{
		$resultado = $this->M_operaciones->obt_entrega_directa($id_entrega);
		
		$detalles_pedidos = $this->M_operaciones->detalles_pedidos1($id_entrega);
		
		if ($resultado)
		{
		   $entrega_directa = $resultado->row();

		   $pedido = $entrega_directa->no_factura;
		   $id_pedido = $entrega_directa->id_pedido;
		   $despachado = $entrega_directa->despachado;
		   
		   $datos['modo_edicion'] = true;
		   $datos['id_entrega'] = $id_entrega;
		   //$datos['pedidos'] = $pedidos;
		   $datos['detalles_pedidos'] = $detalles_pedidos;

		   $datos['notificacion'] = $this->notificacion ? $this->notificacion : "Modificando una entrega directa";
           $datos['notificacion_error'] = $this->notificacion_error;
		   
		   $datos['id_pedido']  = $id_pedido;
		   $datos['pedido'] 	= $pedido;
		   $datos['despachado'] = $despachado;

		}
		
		$this->load->view('lte_header', $datos);
 	    $this->load->view('v_nueva_entrega_directa', $datos);
	    $this->load->view('lte_footer', $datos);
	}
	
	// ------------------------------------------------------
	// Modificar entrega directa
    
	public function modificar_entrega_directa()
    {
	     $id_entrega = $this->input->post('id_entrega');
		 $id_pedido = $this->input->post('id_pedido');
		 $despachado = $this->input->post('despachado');
		 
		 if ($despachado == 'on') $despachado = 1; else $despachado = 0;
		 
		 if ($id_pedido != '')
		    
		 {
		 
			 $modificado = $this->M_operaciones->modificar_entrega_directa($id_entrega, $id_pedido, $despachado);
			 
   		     if ($modificado == 1)
			 { 
				 $this->notificacion = "La entrega se modificó satisfactoriamente.";
		         $this->notificacion_error = false;
			 }
			 else
			 {
				 $this->notificacion = "ERROR. No se pudo modificar la entrega.";
		         $this->notificacion_error = true;
			 }
		 }
		 else
		 {
		     $this->notificacion = "ERROR. No se pudo modificar la entrega. Verifique los datos especificados.";
			 $this->notificacion_error = true;
		 }
		 
		 $this->obtener_pedidos();
	}
	
	// ------------------------------------------------------
	// Confirmar cancelación de una entrega directa
	
	public function cfe_entrega_directa($id_entrega)
	{
		$datos['id_entrega'] = $id_entrega;
		
		$this->load->view('lte_header', $datos);
 	    $this->load->view('vcan_entrega_directa', $datos);
	    $this->load->view('lte_footer', $datos);
	}
	
	// ------------------------------------------------------
	// Cancelar entrega directa
	
    public function cancelar_entrega_directa()
	{
		$id_entrega = $this->input->post('id_entrega');
		
		$cancelado = $this->M_operaciones->cancelar_entrega_directa($id_entrega);
		
		if ($cancelado == 1)
	    { 
		    $this->notificacion = "La entrega se eliminó correctamente.";
		    $this->notificacion_error = false;
		}
		else
		{
		    $this->notificacion = "No se pudo eliminar la entrega.";
		    $this->notificacion_error = true;  
		}
		
		$this->entregas_directas();

	}
	 public function producto_colores($id_producto)
	 {
		 $colores = $this->M_operaciones->producto_colores($id_producto);	
		foreach ($colores->result() as $col)
			echo '<option value="' . $col->id_color . '">' . $col->nombre . '</option>';
	 }
	 public function producto_campanas($id_producto)
	{
		$campanas = $this->M_operaciones->producto_campanas($id_producto);	
		foreach ($campanas->result() as $cam)
			echo '<option value="' . $cam->id_campana . '">' . $cam->campana . '</option>';
	}
	 public function producto_campanas_rev($id_producto)
	{
		$campanas = $this->M_operaciones->producto_campanas_rev($id_producto);	
		foreach ($campanas->result() as $cam)
			echo '<option value="' . $cam->id_campana . '">' . $cam->campana . '</option>';
	}
	// ------------------------------------------------------
	// Nueva venta
	public function nueva_venta()
	{
		$data = array(
			'mision' 	=> 		0     
		);		
		$this->session->set_userdata($data);
		$codigo_postal_empresa 	= $this->obtener_parametro('CODIGO_POSTAL_ORIGEN');
		$oca 	= new Oca($cuit = '30-69511732-5', 71243);
		//Guardar los datos que da OCA en la tabla sucursal
		//$centros_x_cp = $oca->getCentrosImposicion();
		
		//$this->M_operaciones->actSucursal($centros_x_cp);
		
		
		$niveles 				= $this->M_configuracion->obt_niveles_vip();
		$locales 				= $this->M_configuracion->obt_locales();
		$provincias 			= $this->M_operaciones->provincias();		
		$productos 				= $this->M_operaciones->productos();		
		$tipos_factura 			= $this->M_operaciones->tipos_factura();
		$empresas_flete 		= $this->M_operaciones->empresas_flete();
		$misiones_activas     	= $this->M_operaciones->obtener_misiones_activas();
		$pack 					= $this->M_configuracion->obt_packs();		
		
		$cliente_id= 0;
		$pedido_mision=0;

		$costo =0;		
		$anno=date('Y');
		$mes=date('m');
		$res = $this->M_operaciones->obtener_costo($anno, $mes);
		
		$row = $res->row();
		if($row != ''){
			$costo = $row->costo;
		}
		$iva =0;
		$res = $this->M_configuracion->obtener_iva($anno, $mes);
		
		$row = $res->row();
		if($row != ''){
			$iva = $row->iva;
		}	
		$group = array('Revendedores','ConsultorRV');
		$groupRev = array('Revendedores');                  
		if ($this->ion_auth->in_group($group)) { 			
			$revendedor = 'true'; 			
			$user = $this->ion_auth->user()->row();
			if($this->ion_auth->in_group($groupRev))
			{	// El usuario es revendedor
				$clientes = $this->M_configuracion->clientes_revendedores($user->id);
				$datos['misiones'] = $this->M_configuracion->misiones_propuestas_revendedores($user->id);
			}
			else
			{	// El usuario es consultor revendedor
				$id_rev = $this->M_operaciones->obt_superior($user->id);				
				$clientes = $this->M_configuracion->clientes_revendedores($id_rev);
				$datos['misiones'] = $this->M_configuracion->misiones_propuestas_revendedores($id_rev);
			}
			
		}else 
		{
			$clientes = $this->M_operaciones->clientes();
			$revendedor = 'false'; 
			$tiempo_inicio = $this->M_configuracion->microtime_float();
			$datos['misiones'] = $this->M_configuracion->misiones_propuestas();
            $tiempo_fin = $this->M_configuracion->microtime_float();
		}
		$colores 				= $this->M_configuracion->obt_colores();
		$campanas 				= $this->M_configuracion->obt_campanas();

		$canales 				= $this->M_operaciones->canales();
		$consecutivo 			= $this->obtener_parametro('CODIGO_PEDIDO') . '-' . $this->obtener_parametro('CONSECUTIVO_VENTA');
		
        if (!$provincias->row() || !$productos->row() || !$tipos_factura->row() || !$canales->row() || !$campanas->row() || !$colores->row() ||$iva ==0 ||$costo ==0)
	    {
			
			$this->notificacion = 'Debe revisar los siguientes parámetros antes de realizar esta operación </br>';
			if (!$provincias->row()){			
				$this->notificacion = $this->notificacion .' Provincias </br>';		
			}
			if (!$productos->row()){			
				$this->notificacion = $this->notificacion .' Productos </br>';		
			}
			if (!$tipos_factura->row()){			
				$this->notificacion = $this->notificacion .' Tipo de factura </br>';		
			}
			if (!$canales->row()){			
				$this->notificacion = $this->notificacion .' Canales </br>';		
			}
			if (!$campanas->row()){			
				$this->notificacion = $this->notificacion .' Campañas </br>';		
			}
			if (!$colores->row()){			
				$this->notificacion = $this->notificacion .' Colores </br>';		
			}
			if (!$iva){			
				$this->notificacion = $this->notificacion .' IVA </br>';		
			}
			if (!$costo){			
				$this->notificacion = $this->notificacion .' Costo </br>';		
			}
		}else{
			
			$this->notificacion = '';
			
		}
		$datos['codigo_postal_empresa'] = $codigo_postal_empresa;
        $datos['provincias'] 		= $provincias;
		$datos['productos'] 		= $productos;
		$sucursales 				= $this->M_operaciones->sucursales();
		$datos['forma_pagos']		= $this->M_operaciones->obt_formas_pago();
		$datos['sucursales'] 		= $sucursales;
		$lockers 					= $this->M_operaciones->lockers();		
		$datos['lockers'] 			= $lockers;	
		$operativas 				= $this->M_operaciones->operativas();
		$datos['operativas'] 		= $operativas;		
		$datos['tipos_factura'] 	= $tipos_factura;
		$datos['empresas_flete'] 	= $empresas_flete;
		$datos['clientes'] 			= $clientes;
		$datos['revendedor'] 		= $revendedor; 
		$datos['canales'] 			= $canales;
		$datos['costo'] 			= $costo;
		$datos['iva'] 				= $iva;
		$datos['consecutivo'] 		= $consecutivo;
		$datos['misiones_activas'] 	= $misiones_activas;
		$datos['cliente_id']		= $cliente_id;
		$datos['pedido_mision']		= $pedido_mision;
		$datos['niveles']			= $niveles;
		$datos['pack']			= $pack;
		$datos['locales']			= $locales;
		
		if($this->notificacion_error == true){
			
			$this->notificacion = validation_errors();
			$datos['notificacion'] = $this->notificacion;				
			$datos['notificacion_error'] = $this->notificacion_error;
			$this->load->view('lte_header', $datos);
			$this->load->view('v_at', $datos);
			$this->load->view('lte_footer', $datos);
			
			return;
		}
		
		$datos['notificacion'] 		= $this->notificacion;
		
        $tiempo = $tiempo_fin - $tiempo_inicio;
		
		$datos['tiempo'] = $tiempo;
		$this->load->view('lte_header', $datos);
		$this->load->view('v_at', $datos);
		$this->load->view('lte_footer', $datos);	
	}
	
	///*****************************************************
	public function nueva_venta_mision($cliente_id, $id_pedido)
	{		
		$tiempo_inicio = $this->M_configuracion->microtime_float();
			
		$codigo_postal_empresa 	= $this->obtener_parametro('CODIGO_POSTAL_ORIGEN');
		$oca 	= new Oca($cuit = '30-69511732-5', 71243);
		$centros_x_cp = $oca->getCentrosImposicionPorCP($cp = $codigo_postal_empresa);
		//$this->M_operaciones->actSucursal($centros_x_cp);

		$niveles 				= $this->M_configuracion->obt_niveles_vip();
		$provincias 			= $this->M_operaciones->provincias();
		$productos 				= $this->M_operaciones->productos();		
		$tipos_factura 			= $this->M_operaciones->tipos_factura();
		$empresas_flete 		= $this->M_operaciones->empresas_flete();
		$misiones_activas     	= $this->M_operaciones->obtener_misiones_activas();
		$pack 					= $this->M_configuracion->obt_packs();
		$pedido_mision=$id_pedido;
		 $datos['forma_pagos']		= $this->M_operaciones->obt_formas_pago();
		$costo =0;		
		$anno=date('Y');
		$mes=date('m');
		$res = $this->M_operaciones->obtener_costo($anno, $mes);
		
		$row = $res->row();
		if($row != ''){
			$costo = $row->costo;
		}
		$iva =0;
		$res = $this->M_configuracion->obtener_iva($anno, $mes);
		
		$row = $res->row();
		if($row != ''){
			$iva = $row->iva;
		}	
		$group = array('Revendedores','ConsultorRV');
		$groupRev = array('Revendedores');                  
		if ($this->ion_auth->in_group($group)) { 			
			$revendedor = 'true'; 			
			$user = $this->ion_auth->user()->row();
			if($this->ion_auth->in_group($groupRev))
			{	// El usuario es revendedor
				$clientes = $this->M_configuracion->clientes_revendedores_mision($user->id, $cliente_id);
				$datos['misiones'] = $this->M_configuracion->misiones_propuestas_revendedores($user->id);
			}
			else
			{	// El usuario es consultor revendedor
				$id_rev = $this->M_operaciones->obt_superior($user->id);
				$clientes = $this->M_configuracion->clientes_revendedores_mision($id_rev, $cliente_id);
				$datos['misiones'] = $this->M_configuracion->misiones_propuestas_revendedores($id_rev);
			}
			
		}else 
		{
			$clientes = $this->M_operaciones->clientes_mision($cliente_id);
			$revendedor = 'false'; 
			$datos['misiones'] = $this->M_configuracion->misiones_propuestas();
		}
		$colores 				= $this->M_configuracion->obt_colores();
		$campanas 				= $this->M_configuracion->obt_campanas();

		$canales 				= $this->M_operaciones->canales();
		$consecutivo 			= $this->obtener_parametro('CODIGO_PEDIDO') . '-' . $this->obtener_parametro('CONSECUTIVO_VENTA');
		
        if (!$provincias->row() || !$productos->row() || !$tipos_factura->row() || !$canales->row() || !$campanas->row() || !$colores->row() ||$iva ==0 ||$costo ==0)
	    {
			
			$this->notificacion = 'Debe revisar los siguientes parámetros antes de realizar esta operación </br>';
			if (!$provincias->row()){			
				$this->notificacion = $this->notificacion .' Provincias </br>';		
			}
			if (!$productos->row()){			
				$this->notificacion = $this->notificacion .' Productos </br>';		
			}
			if (!$tipos_factura->row()){			
				$this->notificacion = $this->notificacion .' Tipo de factura </br>';		
			}
			if (!$canales->row()){			
				$this->notificacion = $this->notificacion .' Canales </br>';		
			}
			if (!$campanas->row()){			
				$this->notificacion = $this->notificacion .' Campañas </br>';		
			}
			if (!$colores->row()){			
				$this->notificacion = $this->notificacion .' Colores </br>';		
			}
			if (!$iva){			
				$this->notificacion = $this->notificacion .' IVA </br>';		
			}
			if (!$costo){			
				$this->notificacion = $this->notificacion .' Costo </br>';		
			}
		}else{
			
			$this->notificacion = '';
			
		}
		$datos['codigo_postal_empresa'] = $codigo_postal_empresa;
		$datos['provincias'] 		= $provincias;
		$datos['productos'] 		= $productos;		
		$sucursales 				= $this->M_operaciones->sucursales();
		$datos['sucursales'] 		= $sucursales;
		$lockers 					= $this->M_operaciones->lockers();		
		$datos['lockers'] 			= $lockers;	
		$operativas 				= $this->M_operaciones->operativas();
		$datos['operativas'] 		= $operativas;		
		$datos['tipos_factura'] 	= $tipos_factura;
		$datos['empresas_flete'] 	= $empresas_flete;
		$datos['clientes'] 			= $clientes;
		$datos['revendedor'] 		= $revendedor;
		$datos['canales'] 			= $canales;
		$datos['costo'] 			= $costo;
		$datos['iva'] 				= $iva;
		$datos['consecutivo'] 		= $consecutivo;
		$datos['misiones_activas'] 	= $misiones_activas;
		$datos['cliente_id']		= $cliente_id;
		$datos['pedido_mision']		= $pedido_mision;
		$datos['niveles']			= $niveles;
		$datos['pack']			= $pack;
		
		if($this->notificacion_error == true){
			
			$this->notificacion = '';
			$datos['notificacion'] = $this->notificacion;				
			$datos['notificacion_error'] = $this->notificacion_error;
			
			$this->load->view('lte_header', $datos);
			$this->load->view('v_at', $datos);
			$this->load->view('lte_footer', $datos);
			
			return;
		}
		$tiempo_fin = $this->M_configuracion->microtime_float();
		$tiempo = $tiempo_fin - $tiempo_inicio;
		
		$datos['tiempo'] = $tiempo;	
		$datos['notificacion'] 		= $this->notificacion;
		
		$this->load->view('lte_header', $datos);
		$this->load->view('v_at', $datos);
		$this->load->view('lte_footer', $datos);	
	}
	
	// ------------------------------------------------------
	// Registrar venta
	
    public function venta()
    {	
		$data = array(
			'mision' 	=> 		0     
		);		
		$this->session->set_userdata($data);

		$cupon_nro = 	$this->input->post('cupon_nro');
		$cupon_promo = 	$this->input->post('cupon_promo');
		$nro_remito = 	$this->input->post('nro_remito');
		$tx_no_acreditada = 	$this->input->post('tx_no_acreditada');
		$frm_medio = 	$this->input->post('frm_medio');
		 // Cliente
		 $forma_pago = 	$this->input->post('id_forma_pago');	 
		 $revendedor = $this->input->post('frm_revendedor');
		 $nuevo_cliente = $this->input->post('frm_nuevo_cliente');
		 $id_cliente_act = $this->input->post('frm_id_cliente');
		 $pedido_mision = $this->input->post('frm_pedido_mision');
		 $dni = $this->input->post('frm_dni');
		 $nombre = $this->input->post('frm_nombre');
		 $apellidos = $this->input->post('frm_apellidos');
		 $telefono = $this->input->post('frm_telefono');
		 $celular = $this->input->post('frm_celular');
		 $email = $this->input->post('frm_email');
		 $codigo_postal = $this->input->post('frm_codigo_postal');
		 $id_municipio = $this->input->post('frm_id_municipio');		 
		 $calle = $this->input->post('frm_calle');
		 $nro = $this->input->post('frm_nro');
		 $piso = $this->input->post('frm_piso');
		 $dpto = $this->input->post('frm_dpto');
		 $entrecalle1 = $this->input->post('frm_entrecalle1');
		 $entrecalle2 = $this->input->post('frm_entrecalle2');
		 $fecha_nacimiento = $this->input->post('frm_fecha_nacimiento');
		 $observaciones = $this->input->post('frm_observaciones');
		  $cuit = $this->input->post('frm_cuit');
		  $id_local = $this->input->post('frm_id_local');
		  $incluye_seguro = $this->input->post('tx_incluye_seguro');
		 
		 // Venta
		 $id_canal = $this->input->post('frm_id_canal');
		 //$id_pedido = $this->input->post('id_pedido');
		 $no_factura = $this->input->post('frm_factura');
		 $id_transaccion = $this->input->post('frm_transaccion');
		 $fecha_venta = $this->input->post('frm_fecha');
		 $recargo = $this->input->post('frm_recargo');
		 $tipo_factura = $this->input->post('frm_id_tipo_factura');
		 $calle_entrega = $this->input->post('frm_calle_entrega');
		 $nro_entrega = $this->input->post('frm_nro_entrega');
		 $piso_entrega = $this->input->post('frm_piso_entrega');
		 $dpto_entrega = $this->input->post('frm_dpto_entrega');
		 $municipio_entrega = $this->input->post('frm_municipio_entrega');
		 $provincia_entrega = $this->input->post('frm_provincia_entrega');
		 $entrecalle1_entrega = $this->input->post('frm_entrecalle1_entrega');
		 $entrecalle2_entrega = $this->input->post('frm_entrecalle2_entrega');
		 $monto_iva = $this->input->post('frm_monto_iva');
		 $monto_recargo = $this->input->post('frm_monto_recargo');
		 $codigo_postal_entrega=  $this->input->post('frm_codigo_postal_entrega');
		 
		 $envio_inmediato = 'SI';
			
		$id_envio_oca		= $this->input->post('frm_id_envio_oca');	
		
		$dt_productos		= explode(',',$this->input->post('frm_dtProductos'));
		$dt_campanas		= explode(',',$this->input->post('frm_dtCampanas'));
		$dt_colores			= explode(',',$this->input->post('frm_dtColores'));
		$dt_descuentos		= explode(',',$this->input->post('frm_dtDescuentos'));
		$dt_notas			= explode(',',$this->input->post('frm_dtNotas'));
		$dt_descuentos_vip	= explode(',',$this->input->post('frm_dtDescuentos_vip'));
		$dt_incrementos		= explode(',',$this->input->post('frm_dtIncrementos'));
		$dt_precios			= explode(',',$this->input->post('frm_dtPrecios'));		
		$dt_cantidades		= explode(',',$this->input->post('frm_dtCantidades'));		
		$total_productos 	= $this->input->post('frm_TotalProductos');
		$dt_alto			= explode(',',$this->input->post('frm_dtAlto'));
		$dt_ancho			= explode(',',$this->input->post('frm_dtAncho'));
		$dt_largo			= explode(',',$this->input->post('frm_dtLargo'));
		$dt_peso			= explode(',',$this->input->post('frm_dtPeso'));
		// si es mision buscar pedido_mision
		if($id_canal ==6){
			$cli = $this->M_configuracion->pedido_cliente_mision($id_cliente_act);
			$row1 = $cli->row();			
			$pedido_mision = $row1->id_pedido;			
		}
		 

		// Entrega
		 $tipo_envio = $this->input->post('frm_nombre_tipo_envio');		
		 $id_empresa = $this->input->post('frm_id_empresa');
		 $tipo_empresa = $this->input->post('frm_id_tipo_empresa');
		 $id_sucursal = $this->input->post('frm_id_sucursal');
		 $operativa = $this->input->post('frm_operativa');
		 $nombre_sucursal='';
		 if($operativa != ''){			 
		 	$nombre_operativa = $this->M_operaciones->buscar_operativa( $operativa);
		 }else{
			 $nombre_operativa='';
		 }
		 	
		if($tipo_empresa == 1){
			$idci = $id_sucursal;
			
			
		 }else{
			$idci = "0";

		 }
		 if ( $tipo_envio == "Showroom" ){
			$nombre_sucursal='';
			$id_sucursal = 0;
		 }else{
			 if($tipo_empresa == 1){//1- sucursal, 2- locker y 3- domicilio
				$nombre_sucursal = $this->M_operaciones->buscar_sucursal( $id_sucursal);
				
			 }else{
				$nombre_sucursal = '';
				$id_sucursal = 0;
			 }
			 $no_factura = $nro_remito;
		 }
		
		 $res = $this->M_operaciones->obtener_parametro('CONSECUTIVO_VENTA');
		 $cod = $this->M_operaciones->obtener_parametro('CODIGO_PEDIDO');
         $row = $res->row();
         $row_cod = $cod->row();
         $id_pedido = $row_cod->valor . '-' . $row->valor;
         
		//$resultado=$this->M_configuracion->upd_configuracion('CONSECUTIVO_VENTA',$valor_consecutivo);
         $res = $this->M_operaciones->obtener_parametro('COMISION_ATENCION');
         $row = $res->row();
         $com_atencion = $row->valor_decimal;
        
         $res = $this->M_operaciones->obtener_parametro('COMISION_MISION');
         $row = $res->row();
		 $com_mision = $row->valor_decimal;
		 
         $res = $this->M_operaciones->obtener_parametro('COMISION_MCOY');
         $row = $res->row();
         $com_mcoy = $row->valor_decimal;
        
		/*if($recargo == 'SI'){
			$anno=date('Y');
			$mes=date('m');
			$res = $this->M_operaciones->obtener_costo($anno, $mes);
			$row = $res->row();
			$costo = $row->costo;
		}else
			$costo =0;*/
		/*****************Validadion**********************/
		
		$this->load->library('form_validation');	 
		
		$this->form_validation->set_rules('frm_nombre', 'Nombre', 'required');
		$this->form_validation->set_rules('frm_apellidos', 'Apellidos', 'required');
		
		
		$recargo= $monto_recargo;
		if ($this->form_validation->run() == true )
		{
			$registro = $this->M_operaciones->registrar_venta(
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
				$frm_medio,
				$id_local,
				$nombre_operativa,
				$nombre_sucursal,
				$id_sucursal,
				$incluye_seguro

			);
			$this->notificacion_error = false;
			
			//$id_pedido1 = $this->M_configuracion->obt_id_pedido($id_pedido);
			$id_pedido1 =$registro;
			
			$id_cliente_act =  $this->M_operaciones->buscar_cliente_pedido($id_pedido1);
			if( $tipo_envio == "Por tercero"){
				$cfg1 = $this->M_operaciones->obt_conf_envio();
				if ($cfg1)
				{
					$cfg = $cfg1->row();
					$id  = $cfg->id ;   
					$calle_origen = $cfg->calle_origen ;
					$nro_origen = $cfg->nro_origen ; 
					$piso_origen = $cfg->piso_origen ; 
					$depto_origen = $cfg->depto_origen ; 
					$cp_origen = $cfg->cp_origen ; 
					$localidad_origen = $cfg->localidad_origen ; 
					$provincia_origen = $cfg->provincia_origen ;
					$contacto_origen = $cfg->contacto_origen ;
					$email_origen  = $cfg->email_origen ; 
					$solicitante_origen = $cfg->solicitante_origen ; 
					$observaciones_origen = $cfg->observaciones_origen ; 
					$centrocosto_origen = $cfg->centrocosto_origen ; 
					$idfranjahoraria_origen = $cfg->idfranjahoraria_origen ; 
					$idcentroimposicionorigen = $cfg->idcentroimposicionorigen ;
				}

				// crear el xml **********************************************************************
				$oca 	= new Oca($cuit = '30-69511732-5', 71243);
				$centros_x_cp = $oca->getCentrosImposicionPorCP($cp = '$codigo_postal_entrega');
				//------------------------------------------------------------------------------------
				if($idci != "0"){
					$datos_centro_imp =  $this->M_operaciones->buscar_dato_sucursal($idci);
				    $dt_centro_imp = $datos_centro_imp->row();
					
					$localidad = $dt_centro_imp->municipio;
					$provincia = $dt_centro_imp->municipio;
				}else{					
					$datos_municipio_cliente = $this->M_operaciones->datos_muni($id_municipio);
				    $dt_mun_cliente = $datos_municipio_cliente->row();
					
					$datos_prov_munic = $this->M_operaciones->datos_prov_muni_cliente($dt_mun_cliente->id_provincia);
					$dt_prov_cli = $datos_prov_munic->row();
					
					$localidad = $dt_mun_cliente->nombre;
					$provincia = $dt_prov_cli->nombre;
				}
				
				/*if(count($centros_x_cp)>0){
					$localidad = $centros_x_cp[0]['Localidad'];
					$provincia = $centros_x_cp[0]['Provincia'];
					
				}else{
					$localidad = 'CAPITAL FEDERAL';
					$provincia = 'CAPITAL FEDERAL';
				}*/

				$this->load->helper(array('xml','file'));
				//************************* */
				/*if(date('Y-m-d')>='2018-02-08' && date('Y-m-d')<'2018-02-14'){
					$fecha_hoy = '2018-02-14';
				}else*/
				$fecha_hoy = $this->cargar_fecha();
				//********************* */

				$fec = $this->M_operaciones->actu_fecha_envio($id_pedido1, $fecha_hoy);
				$dom = xml_dom();
				$row = xml_add_child($dom, 'ROWS');
				
				$cabecera = xml_add_child($row, 'cabecera');
				xml_add_attribute($cabecera, 'ver', '2.0');
				xml_add_attribute($cabecera, 'nrocuenta', '142852/000');
				$origenes = xml_add_child($row, 'origenes');
				
				$origen = xml_add_child($origenes, 'origen');		
				xml_add_attribute($origen, 'calle', $calle_origen);
				xml_add_attribute($origen, 'nro', $nro_origen);
				xml_add_attribute($origen, 'piso', $piso_origen);
				xml_add_attribute($origen, 'depto', $depto_origen);
				xml_add_attribute($origen, 'cp', $cp_origen);
				xml_add_attribute($origen, 'localidad', $localidad_origen);
				xml_add_attribute($origen, 'provincia', $provincia_origen);
				xml_add_attribute($origen, 'contacto', $contacto_origen);
				xml_add_attribute($origen, 'email', $email_origen);
				xml_add_attribute($origen, 'solicitante', $solicitante_origen);
				xml_add_attribute($origen, 'observaciones', $observaciones_origen);
				xml_add_attribute($origen, 'centrocosto', $centrocosto_origen);
				xml_add_attribute($origen, 'idfranjahoraria', $idfranjahoraria_origen);
				xml_add_attribute($origen, 'idcentroimposicionorigen', $idcentroimposicionorigen);
				xml_add_attribute($origen, 'fecha', $fecha_hoy);
			
				$envios = xml_add_child($origen, 'envios');
				
				$envio = xml_add_child($envios, 'envio');		
				xml_add_attribute($envio, 'idoperativa', $operativa);
				xml_add_attribute($envio, 'nroremito', $nro_remito);

				$destinatario = xml_add_child($envio, 'destinatario');
				xml_add_attribute($destinatario, 'apellido', $apellidos);
				xml_add_attribute($destinatario, 'nombre', $nombre);
				xml_add_attribute($destinatario, 'calle', $calle_entrega);
				xml_add_attribute($destinatario, 'nro', $nro_entrega);
				xml_add_attribute($destinatario, 'piso', $piso_entrega);
				xml_add_attribute($destinatario, 'depto', $dpto_entrega);
				xml_add_attribute($destinatario, 'localidad', $localidad);
				xml_add_attribute($destinatario, 'provincia', $provincia);
				xml_add_attribute($destinatario, 'cp', $codigo_postal_entrega);
				xml_add_attribute($destinatario, 'telefono', $telefono);
				xml_add_attribute($destinatario, 'email', $email);
				xml_add_attribute($destinatario, 'idci', $idci);
				xml_add_attribute($destinatario, 'celular', $celular);
				xml_add_attribute($destinatario, 'observaciones', '');

				$re = $this->M_operaciones->actualizar_envio_oca($id_envio_oca, 
							$id_pedido1, 
							$calle_origen , 
							$nro_origen, 
							$piso_origen, 
							$depto_origen, 
							$cp_origen , 
							$localidad_origen, 
							$provincia_origen , 
							$contacto_origen, 
							$email_origen , 
							$solicitante_origen, 
							$observaciones_origen , 
							$centrocosto_origen, 
							$idfranjahoraria_origen ,
							$idcentroimposicionorigen, 
							$fecha_hoy , 
							$operativa, 
							$no_factura , 
							$apellidos, 
							$nombre, 
							$calle_entrega, 
							$nro_entrega , 
							$piso_entrega, 
							$dpto_entrega , 
							$localidad, 
							$email , 
							$idci, 
							$celular, 
							'', 
							$provincia , 
							$codigo_postal_entrega,
							$telefono);
				$paquetes = xml_add_child($envio, 'paquetes');
				
				$paque1 = $this->M_operaciones->buscar_detalles_envio_oca1($id_envio_oca);
				
				foreach ($paque1->result() as $pa) {
					$paquete = xml_add_child($paquetes, 'paquete');
					xml_add_attribute($paquete, 'alto', $pa->alto_paquete);
					xml_add_attribute($paquete, 'ancho', $pa->ancho_paquete);
					xml_add_attribute($paquete, 'largo', $pa->largo_paquete);
					xml_add_attribute($paquete, 'peso', $pa->peso);
					xml_add_attribute($paquete, 'valor', $pa->valor);
					xml_add_attribute($paquete, 'cant', $pa->cantidad);
				}
				/*for ($i=0; $i<count($dt_productos); $i++ )
				{
					$paquete = xml_add_child($paquetes, 'paquete');
					xml_add_attribute($paquete, 'alto', $dt_alto[$i]);
					xml_add_attribute($paquete, 'ancho', $dt_ancho[$i]);
					xml_add_attribute($paquete, 'largo', $dt_largo[$i]);
					xml_add_attribute($paquete, 'peso', $dt_peso[$i]);
					xml_add_attribute($paquete, 'valor', $dt_precios[$i]);
					xml_add_attribute($paquete, 'cant', $dt_cantidades[$i]);
				}*/
				
				if($envio_inmediato == 'SI'){
					$fichero = './assets/envio.xml';
					if(write_file($fichero, xml_print($dom, $return = TRUE))){
						$this->subir_al_carrito($fichero, $id_pedido1);
					}
				}else{
					// buscar ultimo número de envio almacenado y la primera fecha despues de 3 dias 
					$ultimo_id = $this->M_operaciones->obt_ultimoID();
					$primera_fecha = $this->M_operaciones->obt_primeraFecha();
					
					// almacenar el envio
					$id1 = $ultimo_id + 1;
					$fichero = './assets/envio'.$id1.'.xml';
					if(write_file($fichero, xml_print($dom, $return = TRUE))){
						$res1 = $this->M_operaciones->registrar_carrito( $id1, $id_pedido1, $fecha_venta);
					}	
					$this->subir_a_oca();
					
				}
				
			}
		

		}
		/* if($registro){
			echo $registro;
			 
		 }
		 	else{
				echo 'fallo';
			}*/
		//Preparar el mensaje a enviar por email.		
		
		$tipo_factura;
		$calle_entrega;
		$nro_entrega;
		$piso_entrega;
		$dpto_entrega;
		$entrecalle1_entrega;
		$entrecalle2_entrega;
		$iva = 0;
		$recargo = 0;
		$tipo_entrega ='';
		$importe = 0;
		$cantidad = 0;
		$productos = "";
		$precio = 0;
		$descuento = 0;
		$importe_total = 0;
		
		$datos_producto_mensaje = '';
		$cuerpo_mensaje2="";
		
		if($tipo_envio =="Showroom"){		
			
				$detalles_pedido = $this->M_operaciones->obt_detalle_pedido($id_pedido1);		
				
				foreach ($detalles_pedido->result() as $pr){						   
				
					$tipo_factura = $pr->tipo_factura;
							/*$calle_entrega = $pr->calle_entrega;
					$nro_entrega = $pr->nro_entrega;
					$piso_entrega = $pr->piso_entrega;
					$dpto_entrega = $pr->dpto_entrega;
					$entrecalle1_entrega = $pr->entrecalle1_entrega;
					$entrecalle2_entrega = $pr->entrecalle2_entrega;*/
					$iva = $pr->iva;
					$recargo = $pr->recargo;
					
					$cantidad = $pr->cantidad;
					$productos = $pr->nombre;
					$precio = $pr->precio;
					$descuento = $pr->descuento;
					$importe = ($cantidad*$precio)-$descuento;
					$importe_total+=$importe;
							
					$datos_producto_mensaje = $datos_producto_mensaje.
						'<ul>
							<li>'.$productos.'</li>
							<li>'.$cantidad.'</li>
							<li>'.$precio.'</li>
							<li>'.$descuento.'</li>
							<li>'.$importe.'</li>
						</ul>';
							
				}
		}else{
			
				$detalles_pedido_terceros = $this->M_operaciones->obt_pedido_tercero2($id_pedido1);
				
				$identificador_envio = 0;
				$nombre_empresa = '';
				
				$datos_producto_mensaje = '';
				
				foreach ($detalles_pedido_terceros->result() as $pr){					   
				
					$nombre_empresa = $pr->empresa;
					$tipo_factura = $pr->tipo_factura;
					
					$iva = $pr->iva;
					$recargo = $pr->recargo;
					$tipo_entrega = $pr->tipo_entrega;
					$cantidad = $pr->cantidad;
					$productos = $pr->producto;
					$precio = $pr->precio;
					$descuento = $pr->descuento;
					$importe = ($cantidad*$precio)-$descuento;
					$importe_total+=$importe;
							
					$datos_producto_mensaje = $datos_producto_mensaje.
					'<ul>
						<li>PRODUCTO: '.$productos.'</li>
						<li>CANTIDAD: '.$cantidad.'</li>
						<li>IMPORTE: $'.$importe.'</li>
					</ul>';					
			}
			
			$cuerpo_mensaje2 = '
					</br> Empresa: '.$nombre_empresa;
				
		}
			
		//$detalles_pedido = $this->M_operaciones->obt_detalle_pedido($id_pedido);
		
	   
			
		$importe_total = $importe_total + $recargo+$iva;
		$cuerpo_mensaje1 = $datos_producto_mensaje;
		if($tipo_envio == "Showroom"){
			$cuerpo_mensaje = 'Hola '.$nombre.'. Ha realizado una compra en DVIGI. 
									Los datos de su  compra son los siguientes: 
					</br> Número de pedido: '.$id_pedido.'
					</br> Tipo de factura: '.$tipo_factura.'
					</br> IMPORTE TOTAL: $'.$importe_total.'</p>';
		}
		else{
			$cuerpo_mensaje = 'Hola '.$nombre.'. Ha realizado una compra en DVIGI. 
									Los datos de su  compra son los siguientes:
					</br> Número de pedido: '.$id_pedido.'
					</br> Tipo de factura: '.$tipo_factura.'
					</br> Tipo de entrega: '.$nombre_empresa.' '.$tipo_entrega.'
					</br>'.$cuerpo_mensaje1.'
					</br> COSTO DE ENVÍO: $'.$recargo.'	
					</br> IMPORTE TOTAL: $'.$importe_total.'</p>
					<p> Recibirá el nro. de guía para el seguimiento correspondiente una vez despachada la encomienda.</p>';
		}

		//print_r($cuerpo_mensaje);die();
		
		$this->sendMailMandril($email,'Notificaciones DVIGI',$cuerpo_mensaje);
		
		/*if($id_canal ==6){// Mision
			$cli = $this->M_configuracion->pedido_cliente_mision($id_cliente_act);
			$row1 = $cli->row();			
			$pedido_mision = $row1->id_pedido;			
		}else{
			if($id_canal ==4){// Atención

			}
		}*/
		//$this->reporte_venta_pdf($id_pedido1);
		if($revendedor == 'true')	
			$this->nueva_venta();
		else{
			//$this->obtener_pedidos();
			$datos['canal'] = $id_canal;
			$datos['id_actual'] = $id_cliente_act;
			//$this->load->view('lte_header', $datos);
			$this->load->view('exito', $datos);
			//$this->load->view('lte_footer', $datos);
		}
			
    }
	// ------------------------------------------------------
	public function nueva_venta_showroom()
	{
		$provincias 			= $this->M_operaciones->provincias();
		$productos 				= $this->M_operaciones->productos();		
		$tipos_factura 			= $this->M_operaciones->tipos_factura();
		$empresas_flete 		= $this->M_operaciones->empresas_flete();
		$misiones_activas     	= $this->M_operaciones->obtener_misiones_activas();
		$cliente_id 			= 0;
		$pedido_mision 			= 0;

		$costo =0;		
		$anno=date('Y');
		$mes=date('m');
		$res = $this->M_operaciones->obtener_costo($anno, $mes);
		
		$row = $res->row();
		if($row != ''){
			$costo = $row->costo;
		}	
		$iva =0;
		$res = $this->M_configuracion->obtener_iva($anno, $mes);
		
		$row = $res->row();
		if($row != ''){
			$iva = $row->iva;
		}	
		
		$group = array('Revendedores','ConsultorRV');
        $groupRev = array('Revendedores');                  
		if ($this->ion_auth->in_group($group)) { 			
			$revendedor = 'true'; 			
			$user = $this->ion_auth->user()->row();
			if($this->ion_auth->in_group($groupRev))
			{	// El usuario es revendedor
				$clientes = $this->M_configuracion->clientes_revendedores($user->id);
			}
			else
			{	// El usuario es consultor revendedor
				$id_rev = $this->M_operaciones->obt_superior($user->id);
				$clientes = $this->M_configuracion->clientes_revendedores($id_rev);
			}
			
		}                
		else 
		{
			$clientes = $this->M_operaciones->clientes();
			$revendedor = 'false'; 
			$datos['misiones'] = $this->M_configuracion->misiones_propuestas();
		}
		
		$canales 				= $this->M_operaciones->canales();
		$consecutivo 			= $this->obtener_parametro('CODIGO_PEDIDO') . '-' . $this->obtener_parametro('CONSECUTIVO_VENTA');
		
		$datos['provincias'] 		= $provincias;
		$datos['productos'] 		= $productos;		
		$datos['tipos_factura'] 	= $tipos_factura;
		$datos['empresas_flete'] 	= $empresas_flete;
		$datos['clientes'] 			= $clientes;
		$datos['revendedor'] 		= $revendedor;
		$datos['canales'] 			= $canales;
		$datos['costo'] 			= $costo;
		$datos['iva'] 				= $iva;
		$datos['consecutivo'] 		= $consecutivo;
		$datos['misiones_activas'] 	= $misiones_activas;
		$datos['cliente_id']		= $cliente_id;
		$datos['pedido_mision']		= $pedido_mision;
		
		$this->load->view('lte_header', $datos);
		$this->load->view('v_at_showroom', $datos);
		$this->load->view('lte_footer', $datos);	
	}
	
	// ------------------------------------------------------
	// Registrar venta
	
    public function venta_showroom()
    {		
		 // Cliente
		 		 
		 $revendedor 		= $this->input->post('frm_revendedor');
		 $nuevo_cliente 	= $this->input->post('frm_nuevo_cliente');
		 $id_cliente_act 	= $this->input->post('frm_id_cliente');
		 $dni 				= $this->input->post('frm_dni');
		 $nombre 			= $this->input->post('frm_nombre');
		 $apellidos 		= $this->input->post('frm_apellidos');
		 $telefono 			= $this->input->post('frm_telefono');
		 $celular 			= $this->input->post('frm_celular');
		 $email 			= $this->input->post('frm_email');
		 $codigo_postal 	= $this->input->post('frm_codigo_postal');
		 $id_municipio 		= $this->input->post('frm_id_municipio');
		 $calle 			= $this->input->post('frm_calle');
		 $nro 				= $this->input->post('frm_nro');
		 $piso 				= $this->input->post('frm_piso');
		 $dpto 				= $this->input->post('frm_dpto');
		 $entrecalle1 		= $this->input->post('frm_entrecalle1');
		 $entrecalle2 		= $this->input->post('frm_entrecalle2');
		 $fecha_nacimiento 	= $this->input->post('frm_fecha_nacimiento');
		 
		 // Venta
		 $id_canal = $this->input->post('frm_id_canal');
		 //$id_pedido = $this->input->post('id_pedido');
		 $no_factura = $this->input->post('frm_factura');
		 $id_transaccion = $this->input->post('frm_transaccion');
		 $fecha_venta = $this->input->post('frm_fecha');
		 $recargo = $this->input->post('frm_recargo');
		 $tipo_factura = $this->input->post('frm_id_tipo_factura');
		 $calle_entrega = $this->input->post('frm_calle_entrega');
		 $nro_entrega = $this->input->post('frm_nro_entrega');
		 $piso_entrega = $this->input->post('frm_piso_entrega');
		 $dpto_entrega = $this->input->post('frm_dpto_entrega');
		 $entrecalle1_entrega = $this->input->post('frm_entrecalle1_entrega');
		 $entrecalle2_entrega = $this->input->post('frm_entrecalle2_entrega');
		 $monto_iva = $this->input->post('frm_monto_iva');
		 $monto_recargo = $this->input->post('frm_monto_recargo');
		
		$dt_productos		= explode(',',$this->input->post('frm_dtProductos'));
		$dt_campanas		= explode(',',$this->input->post('frm_dtCampanas'));
		$dt_colores			= explode(',',$this->input->post('frm_dtColores'));
		$dt_descuentos		= explode(',',$this->input->post('frm_dtDescuentos'));
		$dt_precios			= explode(',',$this->input->post('frm_dtPrecios'));		
		$dt_cantidades		= explode(',',$this->input->post('frm_dtCantidades'));		
		$total_productos = $this->input->post('frm_TotalProductos');
		 
		// Entrega
		$tipo_envio = $this->input->post('frm_nombre_tipo_envio');		
		 $id_empresa = $this->input->post('frm_id_empresa');
		 $tipo_empresa = $this->input->post('frm_id_tipo_empresa');
		 
		 $res = $this->M_operaciones->obtener_parametro('CONSECUTIVO_VENTA');
		 $cod = $this->M_operaciones->obtener_parametro('CODIGO_PEDIDO');
         $row = $res->row();
         $row_cod = $cod->row();
         $id_pedido = $row_cod->valor . '-' . $row->valor;
         
		//$resultado=$this->M_configuracion->upd_configuracion('CONSECUTIVO_VENTA',$valor_consecutivo);
         $res = $this->M_operaciones->obtener_parametro('COMISION_ATENCION');
         $row = $res->row();
         $com_atencion = $row->valor_decimal;
        
         $res = $this->M_operaciones->obtener_parametro('COMISION_MISION');
         $row = $res->row();
		 $com_mision = $row->valor_decimal;
		 
         
        
		/*if($recargo == 'SI'){
			$anno=date('Y');
			$mes=date('m');
			$res = $this->M_operaciones->obtener_costo($anno, $mes);
			$row = $res->row();
			$costo = $row->costo;
		}else
			$costo =0;*/
		$recargo= $monto_recargo;
		
         $registro = $this->M_operaciones->registrar_venta(
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
			$dt_descuentos_vip,
			$dt_campanas,
			$dt_colores,
			$total_productos,
			
			$tipo_envio,
			$id_empresa,
			$tipo_empresa,
            $com_atencion,
            $com_mision
		 );
		 if($registro){
			echo $registro;			 
		 }
		 	else{
				echo 'fallo';
			}
		$this->nueva_venta_showroom();
    }
	// ------------------------------------------------------
// Nueva venta
	
	public function nueva_venta_terceros()
	{
		$provincias 			= $this->M_operaciones->provincias();
		$productos 				= $this->M_operaciones->productos();		
		$tipos_factura 			= $this->M_operaciones->tipos_factura();
		$empresas_flete 		= $this->M_operaciones->empresas_flete();
		$misiones_activas     	= $this->M_operaciones->obtener_misiones_activas();
		$cliente_id 			= 0;
		$pedido_mision 			= 0;

		$costo =0;		
		/*$anno=date('Y');
		$mes=date('m');
		$res = $this->M_operaciones->obtener_costo($anno, $mes);
		
		$row = $res->row();
		if($row != ''){
			$costo = $row->costo;
		}*/
		$iva =0;
		/*$res = $this->M_configuracion->obtener_iva($anno, $mes);
		
		$row = $res->row();
		if($row != ''){
			$iva = $row->iva;
		}	*/
		$group = array('Revendedores','ConsultorRV');
        $groupRev = array('Revendedores');                  
		if ($this->ion_auth->in_group($group)) { 			
			$revendedor = 'true'; 			
			$user = $this->ion_auth->user()->row();
			if($this->ion_auth->in_group($groupRev))
			{	// El usuario es revendedor
				$clientes = $this->M_configuracion->clientes_revendedores($user->id);
			}
			else
			{	// El usuario es consultor revendedor
				$id_rev = $this->M_operaciones->obt_superior($user->id);
				$clientes = $this->M_configuracion->clientes_revendedores($id_rev);
			}
			
		} else 
		{
			$clientes = $this->M_operaciones->clientes();
			$revendedor = 'false'; 
		}
		
		$canales 				= $this->M_operaciones->canales_terceros();
		$consecutivo 			= 'EXT-'.$this->obtener_parametro('CODIGO_PEDIDO') . '-' . $this->obtener_parametro('CONSECUTIVO_TERCERO');
		
		$datos['provincias'] 		= $provincias;
		$datos['productos'] 		= $productos;		
		$datos['tipos_factura'] 	= $tipos_factura;
		$datos['empresas_flete'] 	= $empresas_flete;
		$datos['clientes'] 			= $clientes;
		$datos['revendedor'] 		= $revendedor;
		$datos['canales'] 			= $canales;
		$datos['costo'] 			= $costo;
		$datos['iva'] 				= $iva;
		$datos['consecutivo'] 		= $consecutivo;
		$datos['misiones_activas'] 	= $misiones_activas;
		$datos['cliente_id']		= $cliente_id;
		$datos['pedido_mision']		= $pedido_mision;
		
		$this->load->view('lte_header', $datos);
		$this->load->view('v_at_terceros', $datos);
		$this->load->view('lte_footer', $datos);	
	}
	
	// ------------------------------------------------------
	// Registrar venta
	
    public function venta_terceros()
    {
		
		 // Cliente
		 		 
		 $revendedor = $this->input->post('res_revendedor');
		 $nuevo_cliente = $this->input->post('res_nuevo_cliente');
		 $id_cliente_act = $this->input->post('res_id_cliente');
		 $dni = $this->input->post('res_dni');
		 $nombre = $this->input->post('res_nombre');
		 $apellidos = $this->input->post('res_apellidos');
		 $telefono = $this->input->post('res_telefono');
		 $celular = $this->input->post('res_celular');
		 $email = $this->input->post('res_email');
		 $codigo_postal = $this->input->post('res_codigo_postal');
		 $id_municipio = $this->input->post('res_id_municipio');
		 $calle = $this->input->post('res_calle');
		 $nro = $this->input->post('res_nro');
		 $piso = $this->input->post('res_piso');
		 $dpto = $this->input->post('res_dpto');
		 $entrecalle1 = $this->input->post('res_entrecalle1');
		 $entrecalle2 = $this->input->post('res_entrecalle2');
		 $fecha_nacimiento = $this->input->post('res_fecha_nacimiento');
		
		 
		 // Venta
		 $id_canal = $this->input->post('res_id_canal');
		 //$id_pedido = $this->input->post('id_pedido');
		 $no_factura = $this->input->post('res_factura');
		 $id_transaccion = $this->input->post('res_transaccion');
		 $fecha_venta = $this->input->post('res_fecha');
		 $recargo = $this->input->post('res_recargo');
		 $tipo_factura = $this->input->post('res_id_tipo_factura');
		 $calle_entrega = $this->input->post('res_calle_entrega');
		 $nro_entrega = $this->input->post('res_nro_entrega');
		 $piso_entrega = $this->input->post('res_piso_entrega');
		 $dpto_entrega = $this->input->post('res_dpto_entrega');
		 $entrecalle1_entrega = $this->input->post('res_entrecalle1_entrega');
		 $entrecalle2_entrega = $this->input->post('res_entrecalle2_entrega');
		 $monto_iva = $this->input->post('res_monto_iva');
		 $monto_recargo = $this->input->post('monto_recargo');		 

		$dt_productos		= explode(',',$this->input->post('res_dtProductos'));
		$dt_campanas		= explode(',',$this->input->post('res_dtCampanas'));
		$dt_colores			= explode(',',$this->input->post('res_dtColores'));
		$dt_descuentos		= explode(',',$this->input->post('res_dtDescuentos'));
		$dt_precios			= explode(',',$this->input->post('res_dtPrecios'));		
		$dt_cantidades		= explode(',',$this->input->post('res_dtCantidades'));		
		$total_productos = $this->input->post('res_TotalProductos');
		 
		// Entrega
		/*$tipo_envio = $this->input->post('res_nombre_tipo_envio');		
		 $id_empresa = $this->input->post('res_id_empresa');
		 $tipo_empresa = $this->input->post('res_id_tipo_empresa');
		 */
		 $res = $this->M_operaciones->obtener_parametro('CONSECUTIVO_VENTA');
		 $cod = $this->M_operaciones->obtener_parametro('CODIGO_PEDIDO');
         $row = $res->row();
         $row_cod = $cod->row();
         $id_pedido = $row_cod->valor . '-' . $row->valor;
         
		//$resultado=$this->M_configuracion->upd_configuracion('CONSECUTIVO_VENTA',$valor_consecutivo);
         $res = $this->M_operaciones->obtener_parametro('COMISION_ATENCION');
         $row = $res->row();
         $com_atencion = $row->valor_decimal;
        
         $res = $this->M_operaciones->obtener_parametro('COMISION_MISION');
         $row = $res->row();
         $com_mision = $row->valor_decimal;
        
		/*if($recargo == 'SI'){
			$anno=date('Y');
			$mes=date('m');
			$res = $this->M_operaciones->obtener_costo($anno, $mes);
			$row = $res->row();
			$costo = $row->costo;
		}else
			$costo =0;*/
		$recargo= $monto_recargo;
		
         $registro = $this->M_operaciones->registrar_venta_terceros(
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
		 );
		 if($registro){
			echo $registro;
			 
		 }
		 	else{
				echo 'fallo';
			}
		$this->nueva_venta_terceros();
    }
	// ------------------------------------------------------
		
	public function obtener_armado(){
		$pedidos 	= $this->M_operaciones->detalles_pedidos_armar();
		
		$id 		= array();
		$no_factura	= array();
		$cliente 	= array();
		$dni 		= array();
		$producto 	= array();
		$id_envio 	= array();
		$fecha = array();
		$contador= 0;
		$bandera = 0;
		foreach ($pedidos->result() as $pr){			
			if($bandera==0){
				$contador= 0;
				$bandera=1;
				$anterior=$pr->no_factura;
				$actual=$pr->no_factura;
			}else{
				$actual=$pr->no_factura;
			}
			if($anterior == $actual){
				if($contador== 0){//es la primera vez
					$id[$contador] = $pr->id_pedido;
					$no_factura[$contador] = $pr->no_factura;
					$cliente[$contador] = $pr->nombre.' '.$pr->apellidos;
					$dni[$contador] = $pr->dni;
					$producto[$contador] =$pr->producto.'-'.$pr->cantidad.'U '.$pr->color.'</br>';				$fecha[$contador]	 =$pr->fecha;
					$id_envio[$contador]	 =$pr->id_envio;
				}else{
					$producto[$contador] = $producto[$contador]. $pr->producto.'-'.$pr->cantidad.'U '.$pr->color.' </br>';
					
				}
			}else{
				$contador = $contador + 1;
				$id[$contador] = $pr->id_pedido;				
				$no_factura[$contador] = $pr->no_factura;
				$cliente[$contador] = $pr->nombre.' '.$pr->apellidos;
				$dni[$contador] = $pr->dni;
				$fecha[$contador]	 =$pr->fecha;
				$id_envio[$contador]	 =$pr->id_envio;
				$producto[$contador] =$pr->producto.'-'.$pr->cantidad.'U '.$pr->color.' </br>';	 
			}
			$anterior=$pr->no_factura;
		}
		
		 $datos['id'] 		= $id;
		 $datos['codigo'] 	= $no_factura;
		 $datos['cliente'] 	= $cliente;
		 $datos['dni'] 		= $dni;
		 $datos['detalles'] = $producto;
		 $datos['id_envio'] = $id_envio;
		 $datos['fecha'] = $fecha;
		$total_pedidos_a_armar = $this->M_operaciones->total_pedidos_a_armar();	
        $datos['total_a_armar'] = $total_pedidos_a_armar;
		
		$this->load->view('lte_header', $datos);
		$this->load->view('v_listado_armados', $datos);
		$this->load->view('lte_footer', $datos);
		
	}
	public function obtener_parametro($nombre)
	{
		$par = $this->M_operaciones->obtener_parametro($nombre);
        $fila = $par->row();
		return $fila->valor;
	}
  	  // ------------------------------------------------------
	// Editar armado
	
	public function editar_armado($id_pedido)
	{
		$resultado = $this->M_operaciones->obtener_pedido_a_armar($id_pedido);
		$cargados   = $this->M_operaciones->obt_entrega_envios($id_pedido);
		$detalles_envio = $this->M_operaciones->obt_detalles_envio_oca($id_pedido);
		if ($resultado)
		{
		   $pedido = $resultado->row();

		   $armado = $pedido->armado;
		   $pedido = $pedido->no_factura;
		   
			
			$detalles_pedidos = $this->M_operaciones->detalles_pedido_armar($id_pedido);
		
			$datos['armado'] 			= $armado;
			$datos['id_pedido'] 		= $id_pedido;
			$datos['pedido'] 			= $pedido;

			$datos['cargados'] 			= $cargados;
			
			$datos['detalles_pedidos'] 	= $detalles_pedidos;
		   
		   	$datos['modo_edicion'] 		= true;
		   

		   $datos['notificacion'] 		= $this->notificacion ? $this->notificacion : "Modificando el detalle de un pedido";
           $datos['notificacion_error'] = $this->notificacion_error;
		   		   
		}
		$datos['detalles_envio'] 	= $detalles_envio;
		$this->load->view('lte_header', $datos);
 	    $this->load->view('v_nuevo_pedido_armar', $datos);
	    $this->load->view('lte_footer', $datos);
	}
	
	// ------------------------------------------------------
	// Modificar armado
    
	public function modificar_armado($id_pedido)
    {
		 $id_pedido_actual = $id_pedido;
		 /*if($this->input->post('esta_armado') == 'on')
		 	$esta_armado = 1;
		else
			$esta_armado = 0;*/
		 $id_pedido = $id_pedido_actual;
		 $esta_armado = 1;
		 if ($id_pedido != '')
		    
		 {
		 
			 $modificado = $this->M_operaciones->modificar_armado($id_pedido_actual, $id_pedido, $esta_armado);
			 
   		     if ($modificado == 1)
			 { 
				 $this->notificacion = "El armado se modificó satisfactoriamente.";
		         $this->notificacion_error = false;
			 }
			 else
			 {
				 $this->notificacion = "ERROR. No se pudo modificar el armado. Verifique los datos especificados.";
		         $this->notificacion_error = true;
			 }
		 }
		 else
		 {
		     $this->notificacion = "ERROR. No se pudo modificar el armado. Verifique los datos especificados.";
			 $this->notificacion_error = true;
		 }
		 
		 $this->obtener_armado();
	}
	public function modificar_armado_dash()
    {
		 $id_pedido_actual = $this->input->post('id_pedido1');
		 /*if($this->input->post('esta_armado') == 'on')
		 	$esta_armado = 1;
		else
			$esta_armado = 0;*/
		 $id_pedido = $id_pedido_actual;
		 $esta_armado = 1;
		 if ($id_pedido != '')
		    
		 {
		 
			 $modificado = $this->M_operaciones->modificar_armado($id_pedido_actual, $id_pedido, $esta_armado);
			 
   		     if ($modificado == 1)
			 { 
				 $this->notificacion = "El armado se modificó satisfactoriamente.";
		         $this->notificacion_error = false;
			 }
			 else
			 {
				 $this->notificacion = "ERROR. No se pudo modificar el armado. Verifique los datos especificados.";
		         $this->notificacion_error = true;
			 }
		 }
		 else
		 {
		     $this->notificacion = "ERROR. No se pudo modificar el armado. Verifique los datos especificados.";
			 $this->notificacion_error = true;
		 }
		 
		 redirect('dashboard_armador_desp');
	}
	public function modificar_armado_showroom()
    {
		 $id_pedido_actual = $this->input->post('id_pedido_showroom');
		 /*if($this->input->post('esta_armado') == 'on')
		 	$esta_armado = 1;
		else
			$esta_armado = 0;*/
		 $id_pedido = $id_pedido_actual;
		 $esta_armado = 1;
		 if ($id_pedido != '')
		    
		 {
		 
			 $modificado = $this->M_operaciones->modificar_armado($id_pedido_actual, $id_pedido, $esta_armado);
			 
   		     if ($modificado == 1)
			 { 
				 $this->notificacion = "El armado se modificó satisfactoriamente.";
		         $this->notificacion_error = false;
			 }
			 else
			 {
				 $this->notificacion = "ERROR. No se pudo modificar el armado. Verifique los datos especificados.";
		         $this->notificacion_error = true;
			 }
		 }
		 else
		 {
		     $this->notificacion = "ERROR. No se pudo modificar el armado. Verifique los datos especificados.";
			 $this->notificacion_error = true;
		 }
		 
		 $this->control_despachos();
	}
	
	// -----
		// Registrar misión propuesta
	
    public function registrar_mision_propuesta()
    {
		 $id_cliente = $this->input->post('id_cliente');
		 $id_pedido = $this->input->post('id_pedido');
		 $id_usuario = $this->input->post('id_usuario');
		 $exitosa = $this->input->post('exitosa') ; 
		 $fecha_inicio = $this->input->post('fecha_inicio');
		 $fecha_final = $this->input->post('fecha_final');
		 $notas = $this->input->post('notas');

		 //Datos del cliente
		 $nombre = $this->input->post('cliente');
		 $apellidos = $this->input->post('apellidos');
		 $email = $this->input->post('email');
		 $dni = $this->input->post('dni');
		 $calle = $this->input->post('calle');
		 $dpto = $this->input->post('dpto');
		 $telefono = $this->input->post('telefono');
		 $celular = $this->input->post('celular');
		 $piso = $this->input->post('piso');
		 $entrecalle1 = $this->input->post('entrecalle1');
		 $entrecalle2 = $this->input->post('entrecalle2');
		 $nro = $this->input->post('nro');
		 $municipio	= $this->input->post('sel_municipios');
		 $provincia	= $this->input->post('sel_provincias');	 

		$regis = $this->M_operaciones->modificar_cliente($id_cliente, $nombre,$apellidos, $email,$dni,$calle,$dpto,$telefono,$celular, $piso,$entrecalle1,$entrecalle2, $nro, $municipio); 
        
		$registrado = $this->M_configuracion->registrar_mision_propuesta($id_usuario, $id_cliente,$id_pedido, $fecha_inicio, $fecha_final, $exitosa, $notas);
        $registrado1 = $this->M_configuracion->desbloquear_cliente($id_cliente);
        $registrado1 = $this->M_configuracion->cliente_en_mision($id_cliente);
        $mision_agregada= $this->M_configuracion->obtener_mision_registrada($id_usuario, $id_cliente, $id_pedido);
		 $datos['notificacion']="";
		 if ($exitosa==1 )
		 {   
			 if ($registrado> 1)
				 { 
					 $this->notificacion = "La misión se registró satisfactoriamente.";
		             $this->notificacion_error = false;
                     $this->misiones_propuestas();
				 }
				 else
				 {
					 $this->notificacion = "ERROR. No se pudo registrar la misión.";
		             $this->notificacion_error = true;
				 }
				   $this->nueva_venta_mision($id_cliente, $id_pedido); 
		 }
		 else
		 	if($exitosa==0 )
			{
				$datos['modo_edicion'] = false;
				$datos['notificacion'] = 'Agregando los datos de la causa' ;
				$datos['notificacion_error'] = false ;
				
				$this->notificacion = "La misión se registró satisfactoriamente";
				$this->notificacion_error = false;
				
				$productos_pedido= $this->M_configuracion->misiones_propuestas_pedido($id_pedido);
				$datos['productos_pedido']= $productos_pedido;
				
				$datos['clasificacion']= $this->M_configuracion->obt_causa_fallas();
				$datos['mision_agregada'] = $mision_agregada;
		        $clientes = $this->M_configuracion->obt_cliente($id_cliente)->row();
				$datos['cliente'] = $clientes->nombre.' '.$clientes->apellidos;
				$datos['pedido'] = $id_pedido;
				$datos['id_cliente'] = $id_cliente;
				$this->load->view('lte_header', $datos);
				$this->load->view('v_nuevo_mision_fallida', $datos);
				$this->load->view('lte_footer', $datos);
				
			}
			else{

				$registrado = $this->M_operaciones->registrar_mision_seguimiento($mision_agregada, $notas);
				$this->misiones_propuestas();
				//$this->obt_mision_seguimiento($mision_agregada);
			}
    }
	public function registrar_mision_propuesta_vip()
    {
		 $id_cliente = $this->input->post('id_cliente');
		 $id_pedido = $this->input->post('id_pedido');
		 $id_usuario = $this->input->post('id_usuario');
		 $exitosa = $this->input->post('exitosa') ; 
		 $fecha_inicio = $this->input->post('fecha_inicio');
		 $fecha_final = $this->input->post('fecha_final');
		 $notas = $this->input->post('notas');

		 //Datos del cliente
		 $nombre = $this->input->post('cliente');
		 $apellidos = $this->input->post('apellidos');
		 $email = $this->input->post('email');
		 $dni = $this->input->post('dni');
		 $calle = $this->input->post('calle');
		 $dpto = $this->input->post('dpto');
		 $telefono = $this->input->post('telefono');
		 $celular = $this->input->post('celular');
		 $piso = $this->input->post('piso');
		 $entrecalle1 = $this->input->post('entrecalle1');
		 $entrecalle2 = $this->input->post('entrecalle2');
		 $nro = $this->input->post('nro');
		 $municipio	= $this->input->post('sel_municipios');
		 $provincia	= $this->input->post('sel_provincias');	 

		$regis = $this->M_operaciones->modificar_cliente($id_cliente, $nombre,$apellidos, $email,$dni,$calle,$dpto,$telefono, $celular, $piso,$entrecalle1,$entrecalle2, $nro, $municipio); 
        
		$registrado = $this->M_configuracion->registrar_mision_propuesta($id_usuario, $id_cliente,$id_pedido, $fecha_inicio, $fecha_final, $exitosa, $notas);
        $registrado1 = $this->M_configuracion->desbloquear_cliente($id_cliente);
        $registrado1 = $this->M_configuracion->cliente_en_mision($id_cliente);
        $mision_agregada= $this->M_configuracion->obtener_mision_registrada($id_usuario, $id_cliente, $id_pedido);
		 $datos['notificacion']="";
		 if ($exitosa==1 )
		 {   
			 if ($registrado> 1)
				 { 
					 $this->notificacion = "La misión se registró satisfactoriamente.";
		             $this->notificacion_error = false;
                     $this->misiones_propuestas();
				 }
				 else
				 {
					 $this->notificacion = "ERROR. No se pudo registrar la misión.";
		             $this->notificacion_error = true;
				 }
				   $this->nueva_venta_mision($id_cliente, $id_pedido); 
		 }
		 else
		 	if($exitosa==0 )
			{
				$datos['modo_edicion'] = false;
				$datos['notificacion'] = 'Agregando los datos de la causa' ;
				$datos['notificacion_error'] = false ;
				
				$this->notificacion = "La misión se registró satisfactoriamente";
				$this->notificacion_error = false;
				
				$productos_pedido= $this->M_configuracion->misiones_propuestas_pedido($id_pedido);
				$datos['productos_pedido']= $productos_pedido;
				
				$datos['clasificacion']= $this->M_configuracion->obt_causa_fallas();
				$datos['mision_agregada'] = $mision_agregada;
		        $clientes = $this->M_configuracion->obt_cliente($id_cliente)->row();
				$datos['cliente'] = $clientes->nombre.' '.$clientes->apellidos;
				$datos['pedido'] = $id_pedido;
				$datos['id_cliente'] = $id_cliente;
				$this->load->view('lte_header', $datos);
				$this->load->view('v_nuevo_mision_fallida', $datos);
				$this->load->view('lte_footer', $datos);
				
			}
			else{

				$registrado = $this->M_operaciones->registrar_mision_seguimiento($mision_agregada, $notas);
				$this->misiones_propuestas();
				//$this->obt_mision_seguimiento($mision_agregada);
			}
    }	
	public function editar_mision_propuesta($id_actual)
	{
		$resultado = $this->M_configuracion->obt_mision($id_actual);
		if ($resultado)
		{
		   $producto = $resultado->row();
		   $datos['cliente'] = $producto->id_cliente;
		   $cliente= $producto->id_cliente;
		   $datos['pedido'] = $producto->id_pedido;
		   $pedido = $producto->id_pedido;
		   $datos['fecha_inicio'] = $producto->fecha_inicio;
		   $datos['fecha_final'] = $producto->fecha_fin;	
		   $datos['exitosa'] = $producto->exitosa;
		   $provincias 	 	= $this->M_operaciones->provincias();	
			$datos['provincias'] = $provincias;	
			$municipios 		 = $this->M_operaciones->municipios();
			$datos['municipios'] = $municipios;	
		}
		$datos['id_actual'] = $id_actual;
		$datos['clientes'] = $this->M_configuracion->obt_cliente($datos['cliente']);
		$datos['historico'] 	= $this->M_configuracion->historico($cliente);
		
		$group = array('Revendedores','ConsultorRV');	
		 $groupRev = array('Revendedores');                  
		if ($this->ion_auth->in_group($group)) { 			
			$revendedor = 'true'; 			
			$user = $this->ion_auth->user()->row();
			if($this->ion_auth->in_group($groupRev))
			{	// El usuario es revendedor
				$datos['misiones'] = $this->M_configuracion->misiones_propuestas_revendedores($user->id);
			}
			else
			{	// El usuario es consultor revendedor
				$id_rev = $this->M_operaciones->obt_superior($user->id);
				$datos['misiones'] = $this->M_configuracion->misiones_propuestas_revendedores($id_rev);
			}
			
		}else
			$datos['misiones'] = $this->M_configuracion->misiones_propuestas_pedido($pedido);

		$datos['notificacion'] = $this->notificacion ? $this->notificacion : "Iniciando una misión:";
		$datos['notificacion_error'] = $this->notificacion_error;
		$datos['modo_edicion'] = true;
        $dias=$this->M_configuracion->get_configuracion('DIAS_MISION');
        $dias=$dias[0];
		$resultado=$this->M_configuracion->bloquear_cliente($datos['cliente']);
        $datos['dias'] = $dias->valor;
		$this->load->view('lte_header', $datos);
		$this->load->view('v_nueva_mision_propuesta', $datos);
		$this->load->view('lte_footer', $datos);


		
	}
	public function modificar_mision_propuesta()
    {
		 $id_actual = $this->input->post('id_actual');
		 
		 $id_cliente = $this->input->post('id_cliente');
		 $id_pedido = $this->input->post('id_pedido');
		 $id_usuario = $this->input->post('id_usuario');
		 $exitosa = $this->input->post('exitosa') ; 
		 $fecha_inicio = $this->input->post('fecha_inicio');
		 $fecha_final = $this->input->post('fecha_final');
		 $notas = $this->input->post('notas');
		 
		 //Datos del cliente
		 $nombre = $this->input->post('cliente');
		 $apellidos = $this->input->post('apellidos');
		 $email = $this->input->post('email');
		 $dni = $this->input->post('dni');
		 $calle = $this->input->post('calle');
		 $dpto = $this->input->post('dpto');
		 $telefono = $this->input->post('telefono');
		 $celular = $this->input->post('celular');
		 $piso = $this->input->post('piso');
		 $entrecalle1 = $this->input->post('entrecalle1');
		 $entrecalle2 = $this->input->post('entrecalle2');
		 $nro = $this->input->post('nro');
		 $municipio = $this->input->post('sel_municipios');	
		 $operativas 			= $this->M_operaciones->operativas();
		 $datos['operativas'] 		= $operativas;	 

		$regis = $this->M_operaciones->modificar_cliente($id_cliente, $nombre,$apellidos, $email,$dni,$calle,$dpto,$telefono, $celular, $piso,$entrecalle1,$entrecalle2, $nro, $municipio); 
 
		 $modificado = $this->M_configuracion->modificar_mision_propuesta($id_actual, $exitosa, $notas);
		 if ($exitosa==1 )
		 {   
			  $this->nueva_venta_mision($id_cliente,$id_pedido);
			  $registrado1 = $this->M_configuracion->desbloquear_cliente($id_cliente);
        	  $registrado1 = $this->M_configuracion->cliente_en_mision($id_cliente); 
		 }
		 else
		 	if($exitosa==0 )
			{
				$datos['modo_edicion'] = false;
				$datos['notificacion'] = 'Agregando los datos de la causa' ;
				$datos['notificacion_error'] = false ;
				
				$this->notificacion = "La misión se registró satisfactoriamente";
				$this->notificacion_error = false;
				
				$productos_pedido= $this->M_configuracion->misiones_propuestas_pedido($id_pedido);
				$datos['productos_pedido']= $productos_pedido;
				
				$datos['clasificacion']= $this->M_configuracion->obt_causa_fallas();
				$datos['mision_agregada'] = $id_actual;
		        $clientes = $this->M_configuracion->obt_cliente($id_cliente)->row();
				$datos['cliente'] = $clientes->nombre.' '.$clientes->apellidos;
				$datos['pedido'] = $id_pedido;
				$datos['id_cliente'] = $id_cliente;
				$this->load->view('lte_header', $datos);
				$this->load->view('v_nuevo_mision_fallida', $datos);
				$this->load->view('lte_footer', $datos);				
			}
			else{
				$registrado = $this->M_operaciones->registrar_mision_seguimiento($id_actual, $notas);
				$this->obt_mision_seguimiento($id_actual);
			}
	}
	public function obtener_dni($dni)
	{
		$cli = $this->M_operaciones->obt_dni($dni);
        $row = $cli->row_array();		
		echo json_encode($row);  
	}
	public function misiones_propuestas()
	{
		
		$group = array('Revendedores','ConsultorRV');
		$groupRev = array('Revendedores');                  
		if ($this->ion_auth->in_group($group)) { 			
			 			
			$user = $this->ion_auth->user()->row();
			if($this->ion_auth->in_group($groupRev))
			{	// El usuario es revendedor
				$misiones = $this->M_configuracion->misiones_propuestas_revendedores($user->id);
			}
			else
			{	// El usuario es consultor revendedor
				$id_rev = $this->M_operaciones->obt_superior($user->id);				
				$misiones = $this->M_configuracion->misiones_propuestas_revendedores($id_rev);
			}
			
		}else{
			$misiones = $this->M_configuracion->misiones_propuestas();
		}
		
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

		$total_misiones_propuestas 						=0;
		$total_misiones_propuestas_activas 				=0;
		$total_misiones_propuestas_bloqueadas 			=0;
		$total_misiones_activas_no_exitosa	 			=0;

		$contador= 0;
		$bandera = 0;
		foreach ($misiones->result() as $pr){			
			if($bandera==0){
				$contador= 0;
				$bandera=1;
				$anterior=$pr->no_factura;
				$actual=$pr->no_factura;
			}else{
				$actual=$pr->no_factura;
			}
			if($anterior == $actual){// Esta en el mismo pedido
				if($contador== 0){//es la primera vez
					$id[$contador] 					= $pr->id_pedido;
					$no_factura[$contador] 			= $pr->no_factura;
					$cliente[$contador] 			= $pr->nombre;
					$telefono[$contador] 			= $pr->telefono;
					$celular[$contador] 			= $pr->celular;
					$email[$contador] 				= $pr->email;
					$fec_compra[$contador] 			= $pr->fecha_solicitud;
					$producto[$contador] 			= $pr->descripcion.'-'.$pr->cantidad.'U -'.$pr->color.'</br>';		
					$fec_vcto[$contador] 			= $pr->fecha_vencimiento.' </br>';
					$en_mision[$contador] 			= $pr->en_mision;
					$en_operacion[$contador] 		= $pr->en_operacion;
					$vencimiento[$contador]			= $pr->vencimiento;
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
					if($pr->en_operacion){
						$total_misiones_propuestas_bloqueadas = $total_misiones_propuestas_bloqueadas + 1;
					}else{
						if($pr->en_mision){
							$exitosa=1;
							$es_exitosa[$contador]=1;
							foreach ($misiones_activas1->result() as $mi){
								if($mi->id_cliente == $pr->id_cliente){
									$exitosa= $mi->exitosa;
									$es_exitosa[$contador]= $mi->exitosa;
								}
							}
							if($exitosa==1){
								$total_misiones_propuestas_activas = $total_misiones_propuestas_activas  + 1;
							}else{
								$total_misiones_activas_no_exitosa = $total_misiones_activas_no_exitosa +1;
							}
						}
					}		
				}else{
					$producto[$contador] = $producto[$contador]. $pr->descripcion.'-'.$pr->cantidad.'U -'.$pr->color.'</br>';
					$fec_vcto[$contador] = $fec_vcto[$contador]. $pr->fecha_vencimiento.' </br>';
					
				}
			}else{ // Paso al siguiente pedido
				$contador 						= $contador + 1;
				$id[$contador] 					= $pr->id_pedido;				
				$no_factura[$contador] 			= $pr->no_factura;
				$cliente[$contador] 			= $pr->nombre;
				$telefono[$contador] 			= $pr->telefono;
				$celular[$contador] 			= $pr->celular;
				$email[$contador] 				= $pr->email;
				$fec_compra[$contador] 			= $pr->fecha_solicitud;
				$producto[$contador] 			= $pr->descripcion.'-'.$pr->cantidad.'U -'.$pr->color.'</br>';		
				$fec_vcto[$contador] 			= $pr->fecha_vencimiento.' </br>';
				$en_mision[$contador] 			= $pr->en_mision;
				$en_operacion[$contador] 		= $pr->en_operacion;
				$vencimiento[$contador]			= $pr->vencimiento;	 
				$id_cliente[$contador] 			= $pr->id_cliente;
				$id_pedido[$contador]			= $pr->id_pedido;		
				$vip[$contador]					= $pr->vip;
				$es_exitosa[$contador]=1;
				$baja[$contador] 				= 0;
				foreach ($solicitudes_baja->result() as $key) {
					# code...
					if($pr->id_cliente == $key->id_cliente){
						$baja[$contador] 	= 1;							
					}
				}
				if($pr->en_operacion){
					$total_misiones_propuestas_bloqueadas = $total_misiones_propuestas_bloqueadas + 1;
				}else{
					if($pr->en_mision){
						$exitosa=1;
						$es_exitosa[$contador]=1;
						foreach ($misiones_activas1->result() as $mi){
							if($mi->id_cliente == $pr->id_cliente){
								$exitosa= $mi->exitosa;
								$es_exitosa[$contador]= $mi->exitosa;
							}
						}
						if($exitosa==1){
							$total_misiones_propuestas_activas = $total_misiones_propuestas_activas  + 1;
						}else{
							$total_misiones_activas_no_exitosa = $total_misiones_activas_no_exitosa +1;
						}
					}
				}	
			}
			$anterior=$pr->no_factura;
		}	
		$datos['id'] 				= $id;				
		$datos['no_factura'] 		= $no_factura;
		$datos['cliente'] 			= $cliente;
		$datos['telefono'] 			= $telefono;
		$datos['celular'] 			= $celular;
		$datos['email'] 			= $email;
		$datos['fec_compra'] 		= $fec_compra;
		$datos['producto'] 			= $producto;		
		$datos['fec_vcto'] 			= $fec_vcto;
		$datos['en_mision'] 		= $en_mision;
		$datos['en_operacion'] 		= $en_operacion;		
		$datos['vencimiento']		= $vencimiento;
		$datos['id_cliente'] 		= $id_cliente;		
		$datos['id_pedido']			= $id_pedido;
		$datos['es_exitosa']		= $es_exitosa;
		$datos['vip']				= $vip;
		$datos['baja']				= $baja;
		/*
		$datos['total_misiones'] 		     = $this->M_configuracion->total_misiones_propuestas();
		$datos['total_misiones_activas']     = $this->M_configuracion->total_misiones_propuestas_activas();
		$datos['total_misiones_bloqueadas']  = $this->M_configuracion->total_misiones_propuestas_bloqueadas();
		$datos['total_misiones_disponibles'] = $datos['total_misiones'] -$datos['total_misiones_activas'] - $datos['total_misiones_bloqueadas'];	
		*/
		$datos['total_misiones'] 		     = $total_misiones_propuestas;
		$datos['total_misiones_activas']     = $total_misiones_propuestas_activas;
		$datos['total_misiones_bloqueadas']  = $total_misiones_propuestas_bloqueadas;
		$datos['total_misiones_disponibles'] = 0;	
		$datos['total_misiones_activas_no_exitosa'] = $total_misiones_activas_no_exitosa;	
		
		$annos = $this->M_configuracion->obt_annos();
		$meses = $this->M_configuracion->obt_meses();
		
		$datos['annos']  	= $annos;
		$datos['meses']  	= $meses;
		$fecha = new DateTime();		
		$datos['anno']  	= $fecha->format('Y');
		$datos['mes']  		= $fecha->format('m');
        
		/*$datos['total_misiones'] = $this->M_configuracion->total_misiones();
		$datos['total_misiones_aceptadas'] = $this->M_configuracion->total_misiones_aceptadas();
		$datos['total_misiones_rechazadas'] = $this->M_configuracion->total_misiones_rechazadas();
		$datos['total_clientes_mision'] = $this->M_configuracion->total_clientes_mision();*/
		
		$this->load->view('lte_header', $datos);
		$this->load->view('v_listado_misiones_propuestas', $datos);
		$this->load->view('lte_footer', $datos);
	}
	
	public function misiones_propuestas_vip()
	{
		
		$group = array('Revendedores','ConsultorRV');
		$groupRev = array('Revendedores');                  
		if ($this->ion_auth->in_group($group)) { 			
			 			
			$user = $this->ion_auth->user()->row();
			if($this->ion_auth->in_group($groupRev))
			{	// El usuario es revendedor
				$misiones = $this->M_configuracion->misiones_propuestas_revendedores_vip($user->id);
			}
			else
			{	// El usuario es consultor revendedor
				$id_rev = $this->M_operaciones->obt_superior($user->id);				
				$misiones = $this->M_configuracion->misiones_propuestas_revendedores_vip($id_rev);
			}
			
		}else{
			$misiones = $this->M_configuracion->misiones_propuestas_vip();
		}
		
		
		$misiones_activas1 = $this->M_configuracion->obt_mision_activas_vip();

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

		$total_misiones_propuestas 						=0;
		$total_misiones_propuestas_activas 				=0;
		$total_misiones_propuestas_bloqueadas 			=0;
		$total_misiones_activas_no_exitosa	 			=0;

		$contador= 0;
		$bandera = 0;
		foreach ($misiones->result() as $pr){			
			if($bandera==0){
				$contador= 0;
				$bandera=1;
				$anterior=$pr->no_factura;
				$actual=$pr->no_factura;
			}else{
				$actual=$pr->no_factura;
			}
			if($anterior == $actual){// Esta en el mismo pedido
				if($contador== 0){//es la primera vez
					$id[$contador] 					= $pr->id_pedido;
					$no_factura[$contador] 			= $pr->no_factura;
					$cliente[$contador] 			= $pr->nombre;
					$telefono[$contador] 			= $pr->telefono;
					$celular[$contador] 			= $pr->celular;
					$email[$contador] 				= $pr->email;
					$fec_compra[$contador] 			= $pr->fecha_solicitud;
					$producto[$contador] 			= $pr->descripcion.'-'.$pr->cantidad.'U -'.$pr->color.'</br>';		
					$fec_vcto[$contador] 			= $pr->fecha_vencimiento.' </br>';
					$en_mision[$contador] 			= $pr->en_mision;
					$en_operacion[$contador] 		= $pr->en_operacion;
					$vencimiento[$contador]			= $pr->vencimiento;
					$id_cliente[$contador] 			= $pr->id_cliente;
					$id_pedido[$contador]			= $pr->id_pedido;	
					$es_exitosa[$contador]=1;
					if($pr->en_operacion){
						$total_misiones_propuestas_bloqueadas = $total_misiones_propuestas_bloqueadas + 1;
					}else{
						if($pr->en_mision){
							$exitosa=1;
							$es_exitosa[$contador]=1;
							foreach ($misiones_activas1->result() as $mi){
								if($mi->id_cliente == $pr->id_cliente){
									$exitosa= $mi->exitosa;
									$es_exitosa[$contador]= $mi->exitosa;
								}
							}
							if($exitosa==1){
								$total_misiones_propuestas_activas = $total_misiones_propuestas_activas  + 1;
							}else{
								$total_misiones_activas_no_exitosa = $total_misiones_activas_no_exitosa +1;
							}
						}
					}		
				}else{
					$producto[$contador] = $producto[$contador]. $pr->descripcion.'-'.$pr->cantidad.'U -'.$pr->color.'</br>';
					$fec_vcto[$contador] = $fec_vcto[$contador]. $pr->fecha_vencimiento.' </br>';
					
				}
			}else{ // Paso al siguiente pedido
				$contador 						= $contador + 1;
				$id[$contador] 					= $pr->id_pedido;				
				$no_factura[$contador] 			= $pr->no_factura;
				$cliente[$contador] 			= $pr->nombre;
				$telefono[$contador] 			= $pr->telefono;
				$celular[$contador] 			= $pr->celular;
				$email[$contador] 				= $pr->email;
				$fec_compra[$contador] 			= $pr->fecha_solicitud;
				$producto[$contador] 			= $pr->descripcion.'-'.$pr->cantidad.'U -'.$pr->color.'</br>';		
				$fec_vcto[$contador] 			= $pr->fecha_vencimiento.' </br>';
				$en_mision[$contador] 			= $pr->en_mision;
				$en_operacion[$contador] 		= $pr->en_operacion;
				$vencimiento[$contador]			= $pr->vencimiento;	 
				$id_cliente[$contador] 			= $pr->id_cliente;
				$id_pedido[$contador]			= $pr->id_pedido;	
				$es_exitosa[$contador]=1;
				if($pr->en_operacion){
					$total_misiones_propuestas_bloqueadas = $total_misiones_propuestas_bloqueadas + 1;
				}else{
					if($pr->en_mision){
						$exitosa=1;
						$es_exitosa[$contador]=1;
						foreach ($misiones_activas1->result() as $mi){
							if($mi->id_cliente == $pr->id_cliente){
								$exitosa= $mi->exitosa;
								$es_exitosa[$contador]= $mi->exitosa;
							}
						}
						if($exitosa==1){
							$total_misiones_propuestas_activas = $total_misiones_propuestas_activas  + 1;
						}else{
							$total_misiones_activas_no_exitosa = $total_misiones_activas_no_exitosa +1;
						}
					}
				}	
			}
			$anterior=$pr->no_factura;
		}	
		$datos['id'] 				= $id;				
		$datos['no_factura'] 		= $no_factura;
		$datos['cliente'] 			= $cliente;
		$datos['telefono'] 			= $telefono;
		$datos['celular'] 			= $celular;
		$datos['email'] 			= $email;
		$datos['fec_compra'] 		= $fec_compra;
		$datos['producto'] 			= $producto;		
		$datos['fec_vcto'] 			= $fec_vcto;
		$datos['en_mision'] 		= $en_mision;
		$datos['en_operacion'] 		= $en_operacion;		
		$datos['vencimiento']		= $vencimiento;
		$datos['id_cliente'] 		= $id_cliente;		
		$datos['id_pedido']			= $id_pedido;
		$datos['es_exitosa']		= $es_exitosa;
		
		/*
		$datos['total_misiones'] 		     = $this->M_configuracion->total_misiones_propuestas();
		$datos['total_misiones_activas']     = $this->M_configuracion->total_misiones_propuestas_activas();
		$datos['total_misiones_bloqueadas']  = $this->M_configuracion->total_misiones_propuestas_bloqueadas();
		$datos['total_misiones_disponibles'] = $datos['total_misiones'] -$datos['total_misiones_activas'] - $datos['total_misiones_bloqueadas'];	
		*/
		$datos['total_misiones'] 		     = $total_misiones_propuestas;
		$datos['total_misiones_activas']     = $total_misiones_propuestas_activas;
		$datos['total_misiones_bloqueadas']  = $total_misiones_propuestas_bloqueadas;
		$datos['total_misiones_disponibles'] = 0;	
		$datos['total_misiones_activas_no_exitosa'] = $total_misiones_activas_no_exitosa;	
		
		$annos = $this->M_configuracion->obt_annos();
		$meses = $this->M_configuracion->obt_meses();
		
		$datos['annos']  	= $annos;
		$datos['meses']  	= $meses;
		$fecha = new DateTime();		
		$datos['anno']  	= $fecha->format('Y');
		$datos['mes']  		= $fecha->format('m');
        
		/*$datos['total_misiones'] = $this->M_configuracion->total_misiones();
		$datos['total_misiones_aceptadas'] = $this->M_configuracion->total_misiones_aceptadas();
		$datos['total_misiones_rechazadas'] = $this->M_configuracion->total_misiones_rechazadas();
		$datos['total_clientes_mision'] = $this->M_configuracion->total_clientes_mision();*/
		
		$this->load->view('lte_header', $datos);
		$this->load->view('v_listado_misiones_propuestas_vip', $datos);
		$this->load->view('lte_footer', $datos);
	}
	public function obtener_misiones($cliente)
	{
		$cli = $this->M_configuracion->misiones_propuestas_clientes($cliente);
        $row = $cli->result();		
		echo json_encode($row);  
	}
	public function obtener_productoscomprados($cliente)
	{
		$cli = $this->M_operaciones->obt_productoscomprados($cliente);
        $row = $cli->result();		
		echo json_encode($row);  
	}
	// Listado de ingresos de consultores
    public function obt_mision_seguimiento($mision)
	{
		$mision_seguimiento			= $this->M_operaciones->obt_mision_seguimiento($mision);	
        $datos['misiones'] 			= $mision_seguimiento;
		$total_mision 				= $this->M_operaciones->total_mision_seguimiento($mision);	
        $datos['total_mision'] 		= $total_mision;
        
		$this->load->view('lte_header', $datos);
		$this->load->view('v_listado_mision_seguimiento', $datos);
		$this->load->view('lte_footer', $datos);

	}
    public function obt_ingresos_consultores()
	{
		

		$ingresos 					= $this->M_operaciones->obt_ingresos_consultores();	
        $datos['ingresos'] 			= $ingresos;
		$ingresos_resumen 			= $this->M_operaciones->obt_ingresos_resumen();	
        $datos['ingresos_resumen'] 	= $ingresos_resumen;
		$datos['total_ingresos'] 	= $this->M_operaciones->total_ingresos();
        
		$this->load->view('lte_header', $datos);
		$this->load->view('v_listado_ingresos', $datos);
		$this->load->view('lte_footer', $datos);

	}
	 public function obt_ingresos_resumen()
	{
		$ingresos 					= $this->M_operaciones->obt_ingresos_consultores();	
        $datos['ingresos'] 			= $ingresos;
		$ingresos_resumen 			= $this->M_operaciones->obt_ingresos_resumen();	
		$total_comision =0;
		foreach ($ingresos_resumen->result() as $key) {
			# code...
			if(Date('Y')==$key->anno && Date('m')==$key->mes){
				$total_comision = $key->mision + $key->atencion + $key->mcoy;
			}
		}
        $datos['ingresos_resumen'] 	= $ingresos_resumen;
		$datos['total_ingresos'] 	= $this->M_operaciones->total_ingresos();
		$datos['total_comision'] 	= $total_comision;
        
		$this->load->view('lte_header', $datos);
		$this->load->view('v_listado_ingresos_resumen', $datos);
		$this->load->view('lte_footer', $datos);

	}
      public function obt_ingresos_por_consultor()
	{
			
		$user = $this->ion_auth->user()->row(); //usuario registrado
		$userid = $user->id;
					
		$ingresos = $this->M_operaciones->obt_ingresos_por_consultor($userid);
		
		$datos['ingresos'] 			= $ingresos;
		$ingresos_resumen 			= $this->M_operaciones->obt_ingresos_resumen();	
                $datos['ingresos_resumen'] 	= $ingresos_resumen;
		$datos['total_ingresos'] 	= $this->M_operaciones->total_ingresos();
		
		$this->load->view('lte_header', $datos);
		$this->load->view('v_listado_ingresos_consultor', $datos);
		$this->load->view('lte_footer', $datos);

	}
	public function hallazgos_to_excell()
	{		
		to_excel($this->M_operaciones->get_hallazgos(), "Hallazgos");		
	}
	public function exportar_mail()
	{	
		$user = $this->ion_auth->user()->row();
		$nombre_usuario =  $user->first_name.' '. $user->last_name;
		$email_usuario = $user->email;
		$datos['nombre_usuario'] = $nombre_usuario;
		
		
		$clientes= $this->M_operaciones->obt_mail();
		$cuerpo_mensaje= $nombre_usuario." Estos son los mail de todos los clientes registrados en el sistema 
		</br> ";
		foreach($clientes->result() as $cli){
			$cuerpo_mensaje= $cuerpo_mensaje.$cli->email."; " ;
		}
		$datos['cuerpo_mensaje'] = $cuerpo_mensaje;
		//print_r($cuerpo_mensaje);die();
		//$this->sendMailGmail($email_usuario,$cuerpo_mensaje);

		$this->load->view('lte_header', $datos);
		$this->load->view('v_exportar_email', $datos);
		$this->load->view('lte_footer', $datos);
	}
	public function obt_clientes_filtrados($nombre, $dni, $telefono, $apellidos, $email, $celular){		
		$nombre 	= trim($nombre);
		$dni 		= trim($dni);
		$telefono 	= trim($telefono);
		$apellidos 	= trim($apellidos);
		$email 		= trim($email);
		$celular 	= trim($celular);

		$group = array('Revendedores','ConsultorRV');
		$groupRev = array('Revendedores');                  
		if ($this->ion_auth->in_group($group)) { 					
			$user = $this->ion_auth->user()->row();
			if($this->ion_auth->in_group($groupRev))
			{	// El usuario es revendedor
				$clientes = $this->M_configuracion->clientes_revendedores_filtro($user->id, $nombre, $dni, $telefono, $apellidos, $email, $celular);				
			}
			else
			{	// El usuario es consultor revendedor
				$id_rev = $this->M_operaciones->obt_superior($user->id);				
				$clientes = $this->M_configuracion->clientes_revendedores_filtro($id_rev, $nombre, $dni, $telefono, $apellidos, $email, $celular);				
			}
			
		}else 
		{
			$clientes = $this->M_operaciones->clientes_filtro($nombre, $dni, $telefono, $apellidos, $email, $celular);
			
		}
		$row = $clientes->result();		
		echo json_encode($row);
	}
	public function calculadora()
	{		
		
		$provincias 			= $this->M_operaciones->provincias();
		$operativas 			= $this->M_operaciones->operativas();
		$productos 				= $this->M_operaciones->productos();		
		$pack 					= $this->M_configuracion->obt_packs();
		$anno=date('Y');
		$mes=date('m');		
		
		$iva =0;
		$res = $this->M_configuracion->obtener_iva($anno, $mes);
		
		$row = $res->row();
		if($row != ''){
			$iva = $row->iva;
		}
		$res = $iva;
		$datos['iva'] 	= $res;
		$datos['productos'] 	= $productos;
		$datos['provincias'] = $provincias;
		$datos['operativas'] = $operativas;
		$datos['pack'] 		= $pack;

		$this->load->view('lte_header', $datos);
		$this->load->view('v_calculadora', $datos);
		$this->load->view('lte_footer', $datos);		
	}

	public function recalcular($operativa,$pesototal,$volumentotal,$codigopostalO, $codigopostalD, $cantidad, $valor)
	{ 
		$oca 	= new Oca($cuit = '30-69511732-5', $operativa);
		$price 	= $oca->tarifarEnvioCorporativo($pesototal,$volumentotal,$codigopostalO, $codigopostalD, $cantidad, $valor);
		echo json_encode($price);
		die();
	}
	public function codigopostal_municipio($municipio)
	{
		$cli = $this->M_operaciones->obt_codigopostal_municipio($municipio);
        $row = $cli->result();		
		echo json_encode($row);
	}
	public function zonas_codigopostal($codigopostal)
	{
		$oca 	= new Oca($cuit = '30-69511732-5', 71243);
		$centros_x_cp = $oca->getCentrosImposicionPorCP($cp = $codigopostal);		
		
		if(count($centros_x_cp)>0){
			for ($i=0; $i<count($centros_x_cp); $i++ ){
				echo '<option value="' . $centros_x_cp[$i]['idCentroImposicion'] . '">'.$centros_x_cp[$i]['Sigla'] . ' - '.$centros_x_cp[$i]['Descripcion']. '</option>';
			}
		}	
		
	}
	public function datos_zonas($codigopostal)
	{
		$oca 	= new Oca($cuit = '30-69511732-5', 71243);
		$centros_x_cp = $oca->getCentrosImposicionPorCP($cp = $codigopostal);		
		
		
		echo json_encode($centros_x_cp);
	}
	public function operativa_tipo_empresa($tipo_empresa)
	{
		$operativas = $this->M_operaciones->operativas_tipo_empresa($tipo_empresa);
				
		foreach ($operativas->result() as $col)
			echo '<option value="' . $col->id . '">' . $col->nombre . '</option>';	
		
	}
	public function actualizar_pedidos()
	{   				
		$clientes = $this->M_configuracion->obt_clientes_lim();
		$productos = $this->M_configuracion->obt_productos();
		$colores = $this->M_configuracion->obt_colores();

		$datos['clientes'] 	= $clientes;
		$datos['productos'] = $productos;
		$datos['colores'] 	= $colores;

		$this->load->view('lte_header', $datos);
		$this->load->view('v_pedidos_ci', $datos);
		$this->load->view('lte_footer', $datos);

	}
	public function eliminar_pedidos()
	{
		$clientes = $this->M_configuracion->obt_clientes_lim();
		$productos = $this->M_configuracion->obt_productos();
		$colores = $this->M_configuracion->obt_colores();

		$datos['clientes'] 	= $clientes;
		$datos['productos'] = $productos;
		$datos['colores'] 	= $colores;

		$this->load->view('lte_header', $datos);
		$this->load->view('v_pedidos_del', $datos);
		$this->load->view('lte_footer', $datos);

	}
	public function agregar_pedidos()
	{
		$id_cliente = $this->input->post('id_cliente2'); 
		$nombre 	= $this->input->post('nombre2');
		$apellidos 	= $this->input->post('apellidos2');
		$dni 		= $this->input->post('dni2'); 
		$telefono 	= $this->input->post('telefono2');
		$celular 	= $this->input->post('celular2');

		$id_producto= $this->input->post('sel_productos2');
		$id_color 	= $this->input->post('sel_colores2');
		$cantidad 	= $this->input->post('cantidad2');
		$fecha 		= $this->input->post('fecha_solicitud2');
		$consecutivo= 'EXT-' . $this->obtener_parametro('CONSECUTIVO_TERCERO');
		
		$registrado = $this->M_operaciones->agregar_venta(
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
			$consecutivo);

		if ($registrado>0)
		{ 
			$this->notificacion = "La venta se modificó satisfactoriamente.";
			 $this->notificacion_error = false;
			 
		 }
		 else
		 {
			 $this->notificacion = "ERROR. No se pudo registrar la venta.";
			 $this->notificacion_error = true;
		 }
		$clientes = $this->M_configuracion->obt_clientes_lim();
		$productos = $this->M_configuracion->obt_productos();
		$colores = $this->M_configuracion->obt_colores();

		$datos['clientes'] 	= $clientes;
		$datos['productos'] = $productos;
		$datos['colores'] 	= $colores;

		$this->load->view('lte_header', $datos);
		$this->load->view('v_pedidos_ci', $datos);
		$this->load->view('lte_footer', $datos);

	}
	public function agregar_pedidos_cambio()
	{
		$id_cliente = $this->input->post('id_cliente'); 
		$nombre 	= $this->input->post('cliente');
		

		$id_producto= $this->input->post('producto');
		$id_color 	= $this->input->post('color');
		$cantidad 	= $this->input->post('cantidad2');
		$fecha 		= $this->input->post('fecha_solicitud2');
		$consecutivo= $this->obtener_parametro('CODIGO_PEDIDO') . '-' . $this->obtener_parametro('CONSECUTIVO_VENTA');
		
		$registrado = $this->M_operaciones->agregar_venta_cambio(
			$id_cliente, 			
			$id_producto, 			
			$id_color,
			$cantidad,
			$fecha,
			$consecutivo);
		
		if ($registrado>0)
		{ 
			$this->notificacion = "La venta se modificó satisfactoriamente.";
			 $this->notificacion_error = false;
			 
		 }
		 else
		 {
			 $this->notificacion = "ERROR. No se pudo registrar la venta.";
			 $this->notificacion_error = true;
		 }
		$clientes = $this->M_configuracion->obt_clientes_lim();
		$productos = $this->M_configuracion->obt_productos();
		$colores = $this->M_configuracion->obt_colores();
		$user = $this->ion_auth->user()->row();
		$id_usuario=$user->id;
		$observ = 'Ya realizó cambio';
		$this->M_operaciones->set_llamadas($id_usuario,$id_cliente,  $observ);
		$datos['clientes'] 	= $clientes;
		$datos['productos'] = $productos;
		$datos['colores'] 	= $colores;

		header ("Location: ". base_url()."cartera_historial/".$id_cliente);
		

	}
	public function agregar_pedidos_cambio1()
	{
		$id_cliente = $this->input->post('id_cliente'); 
		$nombre 	= $this->input->post('cliente');
		

		$id_producto= $this->input->post('sel_productos2');
		$id_color 	= $this->input->post('sel_colores2');
		$cantidad 	= $this->input->post('cantidad2');
		$fecha 		= $this->input->post('fecha_solicitud2');
		$consecutivo= $this->obtener_parametro('CODIGO_PEDIDO') . '-' . $this->obtener_parametro('CONSECUTIVO_VENTA');
		
		$registrado = $this->M_operaciones->agregar_venta_cambio(
			$id_cliente, 			
			$id_producto, 			
			$id_color,
			$cantidad,
			$fecha,
			$consecutivo);

		if ($registrado>0)
		{ 
			$this->notificacion = "La venta se modificó satisfactoriamente.";
			 $this->notificacion_error = false;
			 
		 }
		 else
		 {
			 $this->notificacion = "ERROR. No se pudo registrar la venta.";
			 $this->notificacion_error = true;
		 }
		$clientes = $this->M_configuracion->obt_clientes_lim();
		$productos = $this->M_configuracion->obt_productos();
		$colores = $this->M_configuracion->obt_colores();

		$datos['clientes'] 	= $clientes;
		$datos['productos'] = $productos;
		$datos['colores'] 	= $colores;

		header ("Location: ". base_url()."cartera_historial/".$id_cliente);
		

	}
	public function agregar_pedidos_cambio1_rev()
	{
		$id_cliente = $this->input->post('id_cliente'); 
		$nombre 	= $this->input->post('cliente');
		

		$id_producto= $this->input->post('sel_productos2');
		$id_color 	= $this->input->post('sel_colores2');
		$cantidad 	= $this->input->post('cantidad2');
		$fecha 		= $this->input->post('fecha_solicitud2');
		$consecutivo= $this->obtener_parametro('CODIGO_PEDIDO') . '-' . $this->obtener_parametro('CONSECUTIVO_VENTA');
		
		$registrado = $this->M_operaciones->agregar_venta_cambio(
			$id_cliente, 			
			$id_producto, 			
			$id_color,
			$cantidad,
			$fecha,
			$consecutivo);

		if ($registrado>0)
		{ 
			$this->notificacion = "La venta se modificó satisfactoriamente.";
			 $this->notificacion_error = false;
			 
		 }
		 else
		 {
			 $this->notificacion = "ERROR. No se pudo registrar la venta.";
			 $this->notificacion_error = true;
		 }
		$clientes = $this->M_configuracion->obt_clientes_lim();
		$productos = $this->M_configuracion->obt_productos();
		$colores = $this->M_configuracion->obt_colores();

		$datos['clientes'] 	= $clientes;
		$datos['productos'] = $productos;
		$datos['colores'] 	= $colores;

		header ("Location: ". base_url()."cartera_historial_rev/".$id_cliente);
		

	}
	public function ventas_ci($cliente)
	{
		$ventas = $this->M_operaciones->obt_ventas_ci($cliente);
		$row = $ventas->result();		
		echo json_encode($row);
	}
	public function modificar_venta()
	{
		$id_cliente = $this->input->post('id_cliente1'); 
		$nombre = $this->input->post('nombre1');
		$apellidos = $this->input->post('apellidos1');
		$dni = $this->input->post('dni1');
		$telefono = $this->input->post('telefono1');
		$celular = $this->input->post('celular');

		$id_producto = $this->input->post('sel_productos');
		$id_producto_ant = $this->input->post('id_producto'); 
		$id_pedido = $this->input->post('id_pedido');
		$id_color = $this->input->post('sel_colores');
		$id_color_ant = $this->input->post('id_color');
		$cantidad = $this->input->post('cantidad');
		$fecha = $this->input->post('fecha_solicitud');
		
        $registrado = $this->M_operaciones->modificar_venta(
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
			$id_producto_ant);

	    if ($registrado>0)
		{ 
			$this->notificacion = "La venta se modificó satisfactoriamente.";
			 $this->notificacion_error = false;
			 
		 }
		 else
		 {
			 $this->notificacion = "ERROR. No se pudo registrar la venta.";
			 $this->notificacion_error = true;
		 }
		 $clientes = $this->M_configuracion->obt_clientes_lim();
		$productos = $this->M_configuracion->obt_productos();
		$colores = $this->M_configuracion->obt_colores();

		$datos['clientes'] 	= $clientes;
		$datos['productos'] = $productos;
		$datos['colores'] 	= $colores;

		$this->load->view('lte_header', $datos);
		$this->load->view('v_pedidos_ci', $datos);
		$this->load->view('lte_footer', $datos);

	}
	public function eliminar_venta()
	{		
		$id_pedido = $this->input->post('id_pedido');
		
        $registrado = $this->M_operaciones->eliminar_venta(	$id_pedido);

	    if ($registrado>0)
		{ 
			$this->notificacion = "La venta se elimino satisfactoriamente.";
			 $this->notificacion_error = false;
			 
		 }
		 else
		 {
			 $this->notificacion = "ERROR. No se pudo eliminar la venta.";
			 $this->notificacion_error = true;
		 }
		$clientes = $this->M_configuracion->obt_clientes_lim();
		$productos = $this->M_configuracion->obt_productos();
		$colores = $this->M_configuracion->obt_colores();

		$datos['clientes'] 	= $clientes;
		$datos['productos'] = $productos;
		$datos['colores'] 	= $colores;

		$this->load->view('lte_header', $datos);
		$this->load->view('v_pedidos_del', $datos);
		$this->load->view('lte_footer', $datos);

	}
	public function reporte_venta_pdf($id_pedido)
	{
		$datos_producto_mensaje = '';
		$cuerpo_mensaje2="";
		$cliente= $this->M_configuracion->pedido_id($id_pedido);
		$envios_oca= $this->M_operaciones->obt_envio_oca($id_pedido);
		$comision_mision = $this->M_configuracion->comision_mision($id_pedido);
		foreach ($cliente->result() as $cli){
			$dni 				= $cli->dni;
			$nombre 			= $cli->nombre_cliente;
			$apellidos 			= $cli->apellidos;
			if($cli->id_canal==6){			
				foreach ($comision_mision->result() as $key) {
					if($key->id_pedido == $id_pedido){
						$usuario=$key->first_name.' '.$key->last_name;
					}
				}
			}else{
				$usuario 			= $cli->first_name.' '.$cli->last_name;
			}
						
			$telefono 			=$cli->telefono;
			$celular 			=$cli->celular;
			$calle 				=$cli->calle;
			$municipio 			=$cli->municipio;
			$provincia 			=$cli->provincia;
			$nro 				=$cli->nro;
			$piso 				=$cli->piso;
			$dpto 				=$cli->dpto;
			$email 				=$cli->email;
			$codigo_postal 		=$cli->codigo_postal;
			$entrecalle1 		=$cli->entrecalle1;
			$entrecalle2 		=$cli->entrecalle2;
			$fecha_nacimiento 	=$cli->fecha_nacimiento;
			$canal 				=$cli->canal;
			$no_factura 		=$cli->no_factura;
			$fecha 				=$cli->fecha_solicitud;
			$calle_entrega 		=$cli->calle_entrega;
			$nro_entrega 		=$cli->nro_entrega;
			$piso_entrega 		=$cli->piso_entrega;
			$dpto_entrega 		=$cli->dpto_entrega;
			$vip 				= $cli->vip;
		    $nivel 				= $cli->nivel;
			$forma_pago 		= $cli->forma_pago;
			$medio_cobranza 	= $cli->medio_cobranza;
			$acreditado 		= $cli->acreditado;
			$cupon_promo 		= $cli->cupon_promo;
			$cupon_nro 			= $cli->cupon_nro;
			$incluye_seguro		= $cli->incluye_seguro;
			//$codigo_postal_entrega 		=$cli->codigo_postal_entrega;
			$entrecalle1_entrega=$cli->entrecalle1_entrega;
			$entrecalle2_entrega=$cli->entrecalle2_entrega;
			$tipo_factura=$cli->tipo_factura;
		}
		$datos['dni'] 				= $dni;
		$datos['usuario'] 			= $usuario;
		$datos['nombre'] 			= $nombre;
		$datos['apellidos'] 		= $apellidos;
		$datos['telefono'] 			= $telefono;
		$datos['celular'] 			= $celular;
		$datos['email'] 			= $email;
		$datos['municipio'] 		= $municipio;
		$datos['provincia'] 		= $provincia;
		$datos['calle'] 			= $calle;
		$datos['nro'] 				= $nro;
		$datos['piso'] 				= $piso;
		$datos['dpto'] 				= $dpto;
		$datos['codigo_postal'] 	= $codigo_postal;
		$datos['entrecalle1'] 		= $entrecalle1;
		$datos['entrecalle2'] 		= $entrecalle2;
		$datos['fecha_nacimiento'] 	= $fecha_nacimiento;
		$datos['canal'] 			= $canal;
		$datos['no_factura'] 		= $no_factura;
		$datos['fecha'] 			= $fecha;
		$datos['calle_entrega'] 	= $calle_entrega;
		$datos['nro_entrega'] 		= $nro_entrega;
		$datos['piso_entrega'] 		= $piso_entrega;
		$datos['dpto_entrega'] 		= $dpto;
		$datos['vip'] 				= $dpto;
		$datos['nivel'] 			= $nivel;
		$datos['forma_pago'] 		= $forma_pago;
		$datos['medio_cobranza'] 	= $medio_cobranza;
		$datos['acreditado'] 		= $acreditado;
		$datos['cupon_promo'] 		= $cupon_promo;
		$datos['cupon_nro'] 		= $cupon_nro;
		$datos['envios_oca'] 		= $envios_oca;
		$datos['incluye_seguro'] 		= $incluye_seguro;
		//$datos['codigo_postal_entrega']	= $codigo_postal_entrega;
		$datos['entrecalle1_entrega'] 	= $entrecalle1_entrega;
		$datos['entrecalle2_entrega'] 	= $entrecalle2_entrega;
		$datos['tipo_factura'] 			= $tipo_factura;
		$datos['id_pedido'] 			= $id_pedido;
		// Por directo
		$detalles_pedido = $this->M_operaciones->obt_detalle_pedido2($id_pedido);		
		$tipo_envio ="Directo";

		$importe_total=0;
		$productos = array();
		$sku = array();
		$cantidad = array();
		$precio = array();
		$precio_base = array();
		$descuento = array();
		$notas = array();
		$incremento = array();
		$importe = array();
		$color = array();
		$sucursal = '';
		$id_sucursal = 0;
		$operativa = '';
		$cont =0;
		$id_local=0;
		$local = '';
		foreach ($detalles_pedido->result() as $pr){						   
			
			$iva = $pr->iva;
			$recargo = $pr->recargo;
			
			$cantidad[$cont] 	= $pr->cantidad;
			$productos[$cont] 	= $pr->nombre;
			$sku[$cont] 		= $pr->sku;
			$precio[$cont] 		= $pr->precio;
			$precio_base[$cont] = $pr->precio_base;
			$color[$cont] 		= $pr->color;
			$descuento[$cont] 	= $pr->descuento;
			$notas[$cont] 		= $pr->notas;
			$incremento[$cont] 	= $pr->incremento;
			$importe[$cont] 	= ($cantidad[$cont]*$precio[$cont])-$descuento[$cont]+ $incremento[$cont];
			$importe_total+=$importe[$cont];
			$id_local=$pr->id_local;
			$local = $pr->local;		
			
			$cont = $cont + 1;	
		}
		// Por tercero
		$detalles_pedido_terceros = $this->M_operaciones->obt_pedido_tercero4($id_pedido);
			
		$identificador_envio = 0;
		$nombre_empresa = '';
		
		$datos_producto_mensaje1 = '';
		$flag1 = 0;
		$cont =0;
		foreach ($detalles_pedido_terceros->result() as $pr){	
			$flag1 = 1;				   
			$tipo_envio ="Tercero";
			$nombre_empresa = $pr->empresa;
			$tipo_factura = $pr->tipo_factura;
			$sucursal = $pr->sucursal;
			$operativa = $pr->operativa;
			$id_sucursal = $pr->id_sucursal;
			$iva = $pr->iva;
			$recargo = $pr->recargo;
			$tipo_entrega = $pr->tipo_entrega;
			$cantidad[$cont] = $pr->cantidad;
			$productos[$cont] = $pr->producto;
			$sku[$cont] = $pr->sku;
			$precio[$cont] = $pr->precio;
			$precio_base[$cont] = $pr->precio_base;
			$color[$cont] = $pr->color;
			$descuento[$cont] = $pr->descuento;
			$notas[$cont] 		= $pr->notas;
			$incremento[$cont] = $pr->incremento;
			$importe[$cont] = ($cantidad[$cont]*$precio[$cont])-$descuento[$cont] + $incremento[$cont];
			$importe_total+=$importe[$cont];
			
			$cont = $cont + 1;				
		}
		$dato_sucursal ='';
		if($flag1 == 1 && $id_sucursal !=0){
			$dato_sucursal = $this->M_operaciones->buscar_dato_sucursal($id_sucursal);
		}

		$datos['dato_sucursal']	= $dato_sucursal;
		$datos['tipo_envio']	= $tipo_envio;
		$datos['cantidad'] 		= $cantidad;
		$datos['productos'] 	= $productos;
		$datos['sku'] 			= $sku;
		$datos['precio'] 		= $precio;
		$datos['precio_base'] 	= $precio_base;
		$datos['color'] 		= $color;
		$datos['descuento'] 	= $descuento;
		$datos['notas'] 		= $notas;
		$datos['incremento'] 	= $incremento;
		$datos['importe'] 		= $importe;
		$datos['id_local'] 		= $id_local;
		$datos['local'] 		= $local;
		$datos['sucursal'] 		= $sucursal;
		$datos['id_sucursal'] 		= $id_sucursal;
		$datos['operativa'] 	= $operativa;
		/*$datos['importe_total'] = $importe_total;
		$datos['iva'] 			= $iva;
		$datos['recargo'] 		= $recargo;*/
		
			
		if($tipo_envio =="Directo"){		
			
		}else{
			$cuerpo_mensaje2 = '
				</br> Empresa: '.$nombre_empresa;	
		}
			
		$importe_total = $importe_total + $recargo+$iva;
		$valor = $this->M_configuracion->format_moneda($importe_total);
		$importe_total = $valor[0]->money_format;
		$cuerpo_mensaje1 = $datos_producto_mensaje;

		$cuerpo_mensaje = '</br></br>'.$cuerpo_mensaje1.'
					</br></br> COSTO DE ENVÍO: $'.$recargo.'					
					</br></br> 					
					</br></br> IMPORTE TOTAL: $'.$importe_total.'</p>';	
	
		$cuerpo_mensaje = $cuerpo_mensaje;
		$datos['cuerpo_mensaje'] = $cuerpo_mensaje;
		$datos['importe_total'] = $importe_total;
		$datos['costo'] = $recargo;
		
		$this->descargar_pdf('reporte_venta','v_reporte_venta', $datos);

		$this->load->view('lte_header', $datos);
		$this->load->view('v_reporte_venta', $datos);
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
	public function cantidad_max_paquetes($largo,$ancho, $alto) 
	{
		$packs = $this->M_configuracion->obt_packs();
		$pack_nombre = array();
		$pack_id 	= array();
		$pack_largo1 = array();
		$pack_ancho1 = array();
		$pack_alto1 = array();
		$c_cant1 = array();
		$c_cant2 = array();
		$c_cant3 = array();
		$c_cant4 = array();
		$c_cant5 = array();
		$c_cant6 = array();

		$cm_cant = array();
		
		$cont=0;
		foreach ($packs->result() as $pr){
			$cm_cant[$cont] =0;
			$pack_nombre[$cont] = $pr->nombre;
			$pack_id[$cont] = $pr->id_pack;
			$pack_largo1[$cont] = $pr->largo;
			$pack_ancho1[$cont] = $pr->ancho;
			$pack_alto1[$cont] = $pr->alto;
			$pack_largo = $pr->largo;
			$pack_ancho = $pr->ancho;
			$pack_alto = $pr->alto;
			
			$c_largo1 = floor($pack_largo/$largo);
			$c_ancho1 = floor($pack_ancho/$ancho);
			$c_alto1 = floor($pack_alto/$alto);
			$c_cant1[$cont] = $c_largo1 * $c_ancho1 * $c_alto1;
			if($c_cant1[$cont] > $cm_cant[$cont]){
				$cm_cant[$cont] = $c_cant1[$cont];
			}
			

			$c_largo2 = floor($pack_largo/$largo);
			$c_ancho2 = floor($pack_ancho/$alto);
			$c_alto2 = floor($pack_alto/$ancho);
			$c_cant2[$cont] = $c_largo2 * $c_ancho2 * $c_alto2;
			if($c_cant2[$cont] > $cm_cant[$cont]){
				$cm_cant[$cont] = $c_cant2[$cont];
			}

			$c_largo3 = floor($pack_largo/$ancho);
			$c_ancho3 = floor($pack_ancho/$largo);
			$c_alto3 = floor($pack_alto/$alto);
			$c_cant3[$cont] = $c_largo3 * $c_ancho3 * $c_alto3;
			if($c_cant3[$cont] > $cm_cant[$cont]){
				$cm_cant[$cont] = $c_cant3[$cont];
			}

			$c_largo4 = floor($pack_largo/$ancho);
			$c_ancho4 = floor($pack_ancho/$alto);
			$c_alto4 = floor($pack_alto/$largo);
			$c_cant4[$cont] = $c_largo4 * $c_ancho4 * $c_alto4;
			if($c_cant4[$cont] > $cm_cant[$cont]){
				$cm_cant[$cont] = $c_cant4[$cont];
			}

			$c_largo5 = floor($pack_largo/$alto);
			$c_ancho5 = floor($pack_ancho/$ancho);
			$c_alto5 = floor($pack_alto/$largo);
			$c_cant5[] = $c_largo5 * $c_ancho5 * $c_alto5;
			if($c_cant5[$cont] > $cm_cant[$cont]){
				$cm_cant[$cont] = $c_cant5[$cont];
			}

			$c_largo6 = floor($pack_largo/$alto);
			$c_ancho6 = floor($pack_ancho/$largo);
			$c_alto6 = floor($pack_alto/$ancho);
			$c_cant6[] = $c_largo6 * $c_ancho6 * $c_alto6;
			if($c_cant6[$cont] > $cm_cant[$cont]){
				$cm_cant[$cont] = $c_cant6[$cont];
			}
			$cont = $cont+1;
		}
		$ret = array();
		$ret['pack']= $pack_nombre;
		$ret['id']= $pack_id;
		$ret['max']= $cm_cant;
		$ret['alto']= $pack_alto1;
		$ret['ancho']= $pack_ancho1;
		$ret['largo']= $pack_largo1;
		//print_r($ret);
		
		//die();
		
		return $ret;
	}
	public function configurar_paquetes($largo,$ancho, $alto, $cantidad)
	{
		$capacidad= $this->cantidad_max_paquetes($largo,$ancho, $alto);
		//print_r($capacidad);
		$ret_pack= array();
		$ret_id= array();
		$ret_alto= array();
		$ret_largo= array();
		$ret_ancho= array();
		$ret_cant= array();
		while($cantidad>0)
		{	
			$bandera_capacidad=0;
			$bandera_indice=0;
			for ($i=0; $i <count($capacidad['max']) ; $i++) { 
				// Si la capacidad de la caja es mayor que la cantidad
				if($capacidad['max'][$i]>0 && $capacidad['max'][$i] >= $cantidad){
					if($bandera_capacidad == 0){
						// Si es la primera capacidad disponible
						$bandera_capacidad = $capacidad['max'][$i];
						$bandera_indice = $i;
					}
					if($capacidad['max'][$i] < $bandera_capacidad){
						// si cabe en una caja de menor tamaño
						$bandera_capacidad = $capacidad['max'][$i];
						$bandera_indice = $i;
					}
				}
			}
			/*for ($i=0; $i <count($capacidad['max']) ; $i++) { 
				if($capacidad['max'][$i]>0 && $capacidad['max'][$i] <= $cantidad){
					if($capacidad['max'][$i] > $bandera_capacidad){
						$bandera_capacidad = $capacidad['max'][$i];
						$bandera_indice = $i;
					}
				}
			}*/
			if($bandera_capacidad > 0){
				$ret_pack[] = $capacidad['pack'][$bandera_indice];
				$ret_id[] 	= $capacidad['id'][$bandera_indice];
				$ret_alto[] = $capacidad['alto'][$bandera_indice];
				$ret_largo[]= $capacidad['largo'][$bandera_indice];
				$ret_ancho[]= $capacidad['ancho'][$bandera_indice];
				$ret_cant[] = $cantidad;
				$cantidad 	= 0;
			}else{
				// es que la capacidad a guardar sobrepasa todas las cajas
				$bandera_capacidad = 0;
				for ($i=0; $i <count($capacidad['max']) ; $i++) { 					
					if($capacidad['max'][$i]>0 && $capacidad['max'][$i] < $cantidad){
						if($bandera_capacidad == 0){
							// Si es la primera capacidad disponible
							$bandera_capacidad = $capacidad['max'][$i];
							$bandera_indice = $i;
						}
						if($capacidad['max'][$i] > $bandera_capacidad){
							// escoger la caja mas grande
							$bandera_capacidad = $capacidad['max'][$i];
							$bandera_indice = $i;
						}
					}
				}
				$ret_pack[] = $capacidad['pack'][$bandera_indice];
				$ret_id[] 	= $capacidad['id'][$bandera_indice];
				$ret_alto[] = $capacidad['alto'][$bandera_indice];
				$ret_largo[]= $capacidad['largo'][$bandera_indice];
				$ret_ancho[]= $capacidad['ancho'][$bandera_indice];
				$ret_cant[] = $bandera_capacidad;
				$cantidad 	= $cantidad - $bandera_capacidad;
			}
			
		}
		$ret = array();
		$ret['pack']= $ret_pack;
		$ret['id']= $ret_id;
		$ret['largo']= $ret_largo;
		$ret['ancho']= $ret_ancho;
		$ret['alto']= $ret_alto;
		$ret['max']= $ret_cant;
		echo json_encode($ret);
	}
	public function subir_al_carrito($fichero, $id_pedido1)
	{
		
		// ************  enviar el carrito   ******************************************************

		$oca 	= new Oca($cuit = '30-69511732-5', 71243);
		$xml_data = file_get_contents($fichero);
		$agregar_carrito = $oca->ingresoORMultiplesRetiros($usuarioEPack= "finanzas@dvigi.com.ar", $passwordEPack= "Vanina86", $xml_data);
		
		
		if(count($agregar_carrito['detalleIngresos']) > 0){
			// si existeconfirmacion automatica se toma la orden de retiro y se actualiza lenio

			$ordenRetiro = $agregar_carrito['detalleIngresos'][0]['OrdenRetiro'];
			$nroenvio = $agregar_carrito['detalleIngresos'][0]['NumeroEnvio'];
			$registro = $this->M_operaciones->modificar_envio($id_pedido1,  $ordenRetiro,$nroenvio);
			
		}
		
	}
	public function subir_a_oca()
	{
		// buscar ultimo número de envio almacenado y la primera fecha despues de 3 dias 
		$ultimo_id = $this->M_operaciones->obt_ultimoID();
		$primera_fecha = $this->M_operaciones->obt_primeraFecha();
		
		
		// si ya hay 5 envios almacenados o ya lleva 3 dias el primero o es viernes	
		
		if($ultimo_id >= 5 || ($primera_fecha <= date('Y-m-d H:i:s')) || date('N')== 5)
		{
			
			$carritos = $this->M_operaciones->obt_carritos();
			foreach ($carritos->result() as $key) {
				$fichero_carro = './assets/envio'.$key->id.'.xml';
				$id_pedido_carro = $key->id_pedido;
				$this->subir_al_carrito($fichero_carro, $id_pedido_carro);
			}
			$res1 = $this->M_operaciones->limpiar_carritos();
		}
		
	}
	public function calcularPaquetes($dtAlto, $dtAncho, $dtLargo, $dtCantidades, $dtValorDeclarado) 
	{
		return $this->configurar_paquetes($dtLargo,$dtAncho, $dtAlto, $dtCantidades);
	}
	public function crear_envio_oca()
	{
		$resultado = $this->M_operaciones->crear_envio_oca();
		echo json_encode($resultado);
	}
	public function crear_detalles_envio_oca($id_envio, $alto, $ancho, $largo, $peso, $valor, $cant, $caja, $observ)
	{
		$observtemp = str_replace('%20',' ',$observ);
		$resultado = $this->M_operaciones->crear_detalles_envio_oca($id_envio, $alto, $ancho, $largo, $peso, $valor, $cant, $caja, $observtemp);
		echo json_encode($resultado);
	}
	public function eliminar_detalles_envio_oca($id_envio)
	{
		$resultado = $this->M_operaciones->eliminar_detalles_envio_oca($id_envio);
		echo json_encode($resultado);
	}
	public function buscar_detalles_envio_oca($id_envio)
	{
		$resultado = $this->M_operaciones->buscar_detalles_envio_oca($id_envio);
		echo json_encode($resultado);
	}
	
	public function obt_detalles_envio_oca($id_pedido)
	{
		$resultado = $this->M_operaciones->obt_detalles_envio_oca($id_envio);
		echo json_encode($resultado);
	}
	public function recargar_oca($id_pedido)
	{
		$this->ejecutar_recarga($id_pedido);

		$this->entregas_terceros();
	}
	public function ejecutar_recarga($id_pedido)
	{
		$envio_inmediato = 'SI';
		$envio = $this->M_operaciones->obt_envio_oca($id_pedido);
		
		foreach ($envio->result() as $key) {
			$cfg1 = $this->M_operaciones->obt_conf_envio();
				if ($cfg1)
				{
					$cfg = $cfg1->row();
					$id  = $cfg->id ;   
					$calle_origen = $cfg->calle_origen ;
					$nro_origen = $cfg->nro_origen ; 
					$piso_origen = $cfg->piso_origen ; 
					$depto_origen = $cfg->depto_origen ; 
					$cp_origen = $cfg->cp_origen ; 
					$localidad_origen = $cfg->localidad_origen ; 
					$provincia_origen = $cfg->provincia_origen ;
					$contacto_origen = $cfg->contacto_origen ;
					$email_origen  = $cfg->email_origen ; 
					$solicitante_origen = $cfg->solicitante_origen ; 
					$observaciones_origen = $cfg->observaciones_origen ; 
					$centrocosto_origen = $cfg->centrocosto_origen ; 
					$idfranjahoraria_origen = $cfg->idfranjahoraria_origen ; 
					$idcentroimposicionorigen = $cfg->idcentroimposicionorigen ;
				}
			// crear el xml **********************************************************************
			$oca 	= new Oca($cuit = '30-69511732-5', 71243);
			$centros_x_cp = $oca->getCentrosImposicionPorCP($cp = '$key->cp_destinatario');
			if(count($centros_x_cp)>0){
				$localidad = $centros_x_cp[0]['Localidad'];
				$provincia = $centros_x_cp[0]['Provincia'];
				
			}else{
				$localidad = 'CAPITAL FEDERAL';
				$provincia = 'CAPITAL FEDERAL';
			}
			$this->load->helper(array('xml','file'));
			//+++*********************
			/*if(date('Y-m-d')>='2018-02-08' && date('Y-m-d')<'2018-02-14'){
				$fecha_hoy = '2018-02-14';
			}else*/
				$fecha_hoy = $this->cargar_fecha();
			//************************************* */
			$dom = xml_dom();
			$row = xml_add_child($dom, 'ROWS');

			$cabecera = xml_add_child($row, 'cabecera');
			xml_add_attribute($cabecera, 'ver', '2.0');
			xml_add_attribute($cabecera, 'nrocuenta', '142852/000');
			$origenes = xml_add_child($row, 'origenes');
			
			$origen = xml_add_child($origenes, 'origen');		
			xml_add_attribute($origen, 'calle', $calle_origen);
			xml_add_attribute($origen, 'nro', $nro_origen);
			xml_add_attribute($origen, 'piso', $piso_origen);
			xml_add_attribute($origen, 'depto', $depto_origen);
			xml_add_attribute($origen, 'cp', $cp_origen);
			xml_add_attribute($origen, 'localidad', $localidad_origen);
			xml_add_attribute($origen, 'provincia', $provincia_origen);
			xml_add_attribute($origen, 'contacto', $contacto_origen);
			xml_add_attribute($origen, 'email', $email_origen);
			xml_add_attribute($origen, 'solicitante', $solicitante_origen);
			xml_add_attribute($origen, 'observaciones', $observaciones_origen);
			xml_add_attribute($origen, 'centrocosto', $centrocosto_origen);
			xml_add_attribute($origen, 'idfranjahoraria', $idfranjahoraria_origen);
			xml_add_attribute($origen, 'idcentroimposicionorigen', $idcentroimposicionorigen);
			xml_add_attribute($origen, 'fecha', $fecha_hoy);
		
			$envios = xml_add_child($origen, 'envios');
			$envio = xml_add_child($envios, 'envio');		
			xml_add_attribute($envio, 'idoperativa', $key->idoperativa_envio);
			xml_add_attribute($envio, 'nroremito', $key->nroremito_envio);

			$destinatario = xml_add_child($envio, 'destinatario');
			xml_add_attribute($destinatario, 'apellido', $key->apellido_destinatario);
			xml_add_attribute($destinatario, 'nombre', $key->nombre_destinatario);
			xml_add_attribute($destinatario, 'calle', $key->calle_dstinatario);
			xml_add_attribute($destinatario, 'nro', $key->nro_destinatario);
			xml_add_attribute($destinatario, 'piso', $key->piso_destinatario);
			xml_add_attribute($destinatario, 'depto', $key->depto_destinatario);
			xml_add_attribute($destinatario, 'localidad', $key->localidad_destinatario);
			xml_add_attribute($destinatario, 'provincia', $key->provincia_destinatario);
			xml_add_attribute($destinatario, 'cp', $key->cp_destinatario);
			xml_add_attribute($destinatario, 'telefono', $key->telefono_destinatario);
			xml_add_attribute($destinatario, 'email', $key->email_destinatario);
			xml_add_attribute($destinatario, 'idci', $key->idci_destinatario);
			xml_add_attribute($destinatario, 'celular', $key->celular_destinatario);
			xml_add_attribute($destinatario, 'observaciones', $key->observaciones_destinatario);

			$paquetes = xml_add_child($envio, 'paquetes');
			$id_envio_oca = $this->M_operaciones->obt_id_envio_oca($id_pedido);

			$paque1 = $this->M_operaciones->buscar_detalles_envio_oca1($id_envio_oca);
			foreach ($paque1->result() as $pa) {
				$paquete = xml_add_child($paquetes, 'paquete');
				xml_add_attribute($paquete, 'alto', $pa->alto_paquete);
				xml_add_attribute($paquete, 'ancho', $pa->ancho_paquete);
				xml_add_attribute($paquete, 'largo', $pa->largo_paquete);
				xml_add_attribute($paquete, 'peso', $pa->peso);
				xml_add_attribute($paquete, 'valor', $pa->valor);
				xml_add_attribute($paquete, 'cant', $pa->cantidad);
			}
			// $registro = $this->M_operaciones->modificar_envio($id_pedido,  $id_envio_oca);
			if($envio_inmediato == 'SI'){
				$fichero = './assets/envio.xml';
				if(write_file($fichero, xml_print($dom, $return = TRUE))){
					
					$this->subir_al_carrito($fichero, $id_pedido);
				}
			}/*else{
				// buscar ultimo número de envio almacenado y la primera fecha despues de 3 dias 
				$ultimo_id = $this->M_operaciones->obt_ultimoID();
				$primera_fecha = $this->M_operaciones->obt_primeraFecha();
				
				// almacenar el envio
				$id1 = $ultimo_id + 1;
				$fichero = './assets/envio'.$id1.'.xml';
				if(write_file($fichero, xml_print($dom, $return = TRUE))){
					$res1 = $this->M_operaciones->registrar_carrito( $id1, $id_pedido, $fecha_venta);
				}	
				$this->subir_a_oca();
				
			}*/
		}// fin del foreach
		//quitar la cancelacion del envio
		$resul = $this->M_operaciones->restaurar_entregas_envios($id_pedido);
	}
	public function cfg_envio_oca()
	{
		$resu = $this->M_operaciones->obt_conf_envio();
		if ($resu)
		{
		   	$cfg = $resu->row();
			$id  = $cfg->id ;   
		   	$calle_origen = $cfg->calle_origen ;
			$nro_origen = $cfg->nro_origen ; 
			$piso_origen = $cfg->piso_origen ; 
			$depto_origen = $cfg->depto_origen ; 
			$cp_origen = $cfg->cp_origen ; 
			$localidad_origen = $cfg->localidad_origen ; 
			$provincia_origen = $cfg->provincia_origen ;
			$contacto_origen = $cfg->contacto_origen ;
			$email_origen  = $cfg->email_origen ; 
			$solicitante_origen = $cfg->solicitante_origen ; 
			$observaciones_origen = $cfg->observaciones_origen ; 
			$centrocosto_origen = $cfg->centrocosto_origen ; 
			$idfranjahoraria_origen = $cfg->idfranjahoraria_origen ; 
			$idcentroimposicionorigen = $cfg->idcentroimposicionorigen ;

		   $datos['id']  						= $id;
		   $datos['calle_origen']  				= $calle_origen;
		   $datos['nro_origen']  				= $nro_origen;
		   $datos['piso_origen']  				= $piso_origen;
		   $datos['depto_origen']  				= $depto_origen;
		   $datos['cp_origen']  				= $cp_origen;
		   $datos['localidad_origen']  			= $localidad_origen;
		   $datos['provincia_origen']  			= $provincia_origen;
		   $datos['contacto_origen']  			= $contacto_origen;
		   $datos['email_origen']  				= $email_origen;
		   $datos['solicitante_origen']  		= $solicitante_origen;
		   $datos['observaciones_origen']  		= $observaciones_origen;
		   $datos['centrocosto_origen'] 		= $centrocosto_origen;
		   $datos['idfranjahoraria_origen']  	= $idfranjahoraria_origen;
		   $datos['idcentroimposicionorigen']  	= $idcentroimposicionorigen;

			$this->load->view('lte_header', $datos);
 	    	$this->load->view('v_nueva_cfg', $datos);
			$this->load->view('lte_footer', $datos);
		}
	}
	public function modificar_cfg_envio_oca()
	{
		$id = $this->input->post('id'); 
		$calle_origen = $this->input->post('calle_origen');
		$nro_origen = $this->input->post('nro_origen');
		$piso_origen  = $this->input->post('piso_origen'); 
		$depto_origen = $this->input->post('depto_origen');
		$cp_origen  = $this->input->post('cp_origen');
		$localidad_origen = $this->input->post('localidad_origen'); 
		$provincia_origen  = $this->input->post('provincia_origen');
		$contacto_origen = $this->input->post('contacto_origen');
		$email_origen  = $this->input->post('email_origen');
		$solicitante_origen = $this->input->post('solicitante_origen'); 
		$observaciones_origen  = $this->input->post('observaciones_origen');
		$centrocosto_origen = $this->input->post('centrocosto_origen');
		$idfranjahoraria_origen  = $this->input->post('idfranjahoraria_origen');
		$idcentroimposicionorigen = $this->input->post('idcentroimposicionorigen');

		$resu = $this->M_operaciones->actualizar_cfg_envio_oca(
			$id, 
			$calle_origen , 
			$nro_origen, 
			$piso_origen , 
			$depto_origen, 
			$cp_origen , 
			$localidad_origen, 
			$provincia_origen , 
			$contacto_origen, 
			$email_origen , 
			$solicitante_origen, 
			$observaciones_origen , 
			$centrocosto_origen, 
			$idfranjahoraria_origen , 
			$idcentroimposicionorigen);

		$resultado = $this->M_dashboard->obt_ventas_canales();
		$datos = array();
		
		$datos['valor']= $this->M_configuracion->obt_paises();

		
		$this->load->view('lte_header', $datos);
		$this->load->view('v_dashboard', $datos);
		$this->load->view('lte_footer', $datos);		
	}
	public function cargar_fecha()
	{
		$feriados =  $this->M_configuracion->obt_feriados();
		$falg=0;
		switch (date('N')) {
			case 1:
				//si es lunes se carga miercoles
				$cant=2;
				break;
			case 2:
				//si es martes se carga miercoles
				$cant=1;
				break;
			case 3:
				//si es miércoles se carga viernes
				$cant=2;
				break;
			case 4:
				//si es jueves se carga viernes
				$cant=1;
				break;
			case 5:
				//si es viernes se carga lunes
				$cant=3;
				break;
			case 6:
				//si es sabado se carga lunes
				$cant=2;
				break;
			default:
				$cant = 1;
				break;
		}
		
		do {
			$lunes = date('Y-m-d',mktime(0, 0, 0, date("m"), date("d")+$cant,   date("Y")));
			$retorno = date('Ymd',mktime(0, 0, 0, date("m"), date("d")+$cant,   date("Y")));
			$flag = 0;
			foreach ($feriados->result() as $va) {					
				if($lunes == $va->dia || date('N',mktime(0, 0, 0, date("m"), date("d")+$cant, date("Y")))== 6 || date('N',mktime(0, 0, 0, date("m"), date("d")+$cant,   date("Y"))) == 7)
				{
					$flag = 1;
					
				}
			}
			if ($flag == 1) {
				$cant = $cant + 1;
			}
		} while ($flag>0);
					
		return $retorno;
	}
	public function ventas_resumen()
	{
		
		$anno  				= $this->input->post('anno');
		$datos['anno']  	= $anno;
		$mes  				= $this->input->post('mes');
		$datos['mes']  		= $mes;

		$comision_atencion = $this->obtener_parametro('COMISION_ATENCION');
		$comision_mision = $this->obtener_parametro('COMISION_MISION');
		$ventas = $this->M_operaciones->obt_ventas_consultores($anno, $mes);
		$vendedores = $this->M_operaciones->obt_ventas_consultores_vendedores($anno, $mes);

		$id_vendedor= array();
		$id_vendedor1= array();
		$vendedor= array();
		$subtotal= array();
		$iva= array();
		$total= array();
		$canal= array();
		$fecha= array();
		$factura= array();
		$cliente= array();

		$cont_cli = 0;
		$cont = 0;		
		
		$sum_iva_ate = 0;
		$sum_importe_ate =0;
		$sum_subtotal_ate = 0;
		
		$sum_iva_mis = 0;
		$sum_importe_mis =0;
		$sum_subtotal_mis = 0;
		
		$sum_iva = 0;
		$sum_importe =0;
		$sum_subtotal = 0;

		foreach ($vendedores->result() as $ve) {
			# code...
			$id_vendedor[$cont_cli] = $ve->id_usuario;
			$vendedor[$cont_cli] = $ve->first_name.' '.$ve->last_name;
			
			$subtotal_ate[$cont_cli] = 0;
			$iva_ate[$cont_cli] =0;
			$total_ate[$cont_cli] = 0;
			
			$subtotal_mis[$cont_cli] = 0;
			$iva_mis[$cont_cli] = 0;
			$total_mis[$cont_cli] = 0;
			foreach ($ventas->result() as $key) {
				# code...
				if($ve->id_usuario == $key->id_usuario){
					$id_vendedor1[$cont] = $key->id_usuario;
					$fecha[$cont] = $key->fecha_solicitud;
					$factura[$cont] = $key->no_factura;
					$subtotal[$cont] = $key->subtotal;
					$cliente[$cont] = $key->nombre.' '.$key->apellidos;
					$iva[$cont] = $key->iva;
					$total[$cont] = $key->subtotal + $key->iva;

					if($key->id_canal == 4){
						$canal[$cont] = 'Atención';
						$subtotal_ate[$cont_cli] = $key->subtotal;
						$iva_ate[$cont_cli] = $key->iva;
						$total_ate[$cont_cli] = $key->subtotal + $key->iva;
					}else{
						$canal[$cont] = 'Misión';
						$subtotal_mis[$cont_cli] = $key->subtotal;
						$iva_mis[$cont_cli] = $key->iva;
						$total_mis[$cont_cli] = $key->subtotal + $key->iva;
					}
					$cont = $cont + 1;
				}				
			}
			$cont_cli = $cont_cli + 1;
		}
		$datos['id_vendedor']  	= $id_vendedor;
		$datos['id_vendedor1']  = $id_vendedor1;
		$datos['vendedor']  	= $vendedor;
		$datos['fecha']  		= $fecha;
		$datos['factura']  		= $factura;
		$datos['subtotal']  	= $subtotal;
		$datos['cliente']  		= $cliente;
		$datos['iva']  			= $iva;
		$datos['total']  		= $total;
		$datos['canal']  		= $canal;
		$datos['subtotal_ate']  = $subtotal_ate;
		$datos['subtotal_mis']  = $subtotal_mis;
		$datos['iva_ate']  		= $iva_ate;
		$datos['iva_mis']  		= $iva_mis;
		$datos['total_ate']  	= $total_ate;
		$datos['total_mis']  	= $total_mis;
		$datos['comision_atencion'] 	= 	$comision_atencion;
		$datos['comision_mision']  	= 	$comision_mision;

		$this->descargar_pdf('ventas_resumen','v_listado_ventas_resumen', $datos);

		$this->load->view('lte_header', $datos);
		$this->load->view('v_listado_ventas_resumen', $datos);
		$this->load->view('lte_footer', $datos);
	}
	public function ventas_resumen_anno(){
		$annos = $this->M_configuracion->obt_annos();
		$meses = $this->M_configuracion->obt_meses();
		$anno = date('Y');
		$mes  = date('m');
		$datos['annos'] = $annos;
		$datos['anno'] = $anno;
		$datos['meses'] = $meses;
		$datos['mes'] = $mes;

		
		$this->load->view('lte_header', $datos);
		$this->load->view('v_ventas_resumen_anno', $datos);
		$this->load->view('lte_footer', $datos);
	}
	public function cargar_historico($id_cliente)
	{
		$cli = $this->M_configuracion->historico_all($id_cliente);
        $row = $cli->result();	
		echo json_encode($row);  
	}
	public function cargar_mision($id_pedido)
	{
		$group = array('Revendedores','ConsultorRV');
		$groupRev = array('Revendedores');                  
		if ($this->ion_auth->in_group($group)) { 			
			$revendedor = 'true'; 			
			$user = $this->ion_auth->user()->row();
			if($this->ion_auth->in_group($groupRev))
			{	// El usuario es revendedor
				$cli = $this->M_configuracion->misiones_propuestas_revendedores($user->id);
			}
			else
			{	// El usuario es consultor revendedor
				$id_rev = $this->M_operaciones->obt_superior($user->id);				
				$cli = $this->M_configuracion->misiones_propuestas_revendedores($id_rev );
			}
			
		}else
			$cli = $this->M_configuracion->misiones_propuestas_pedido($id_pedido);

		
        $row = $cli->result();	
		echo json_encode($row);  
	}
	public function redondeo_ajax($valor)
	{
		$cli = $this->M_configuracion->format_moneda($valor);
        $resultado = $cli[0]->money_format;	
		
		echo $resultado;  
	}
	public function reporte_ventas_excell()
	{		
		

		$desde 			= $this->input->post('fecha_inicial');
		$hasta 			= $this->input->post('fecha_final');
		$canal 			= $this->input->post('sel_canal');
		$salida_reporte	= $this->input->post('salida_reporte');

		if($canal == 1){
			$canal='ATC';
		}else{
			if($canal == 2){
				$canal='ML';
			}else{
				if($canal == 3){
					$canal='MS';
				}
			}
		}
		if($salida_reporte == 0){
			to_excel($this->M_operaciones->get_reporte_ventas($desde, $hasta, $canal), "Reporte sobre ventas");
		}else{
			
			$this->reporte_venta_pantalla($desde, $hasta, $canal );
			
		}
	}
	public function reporte_venta_pantalla($desde, $hasta, $sel_canal )
	{
		$tiempo_inicio = $this->M_configuracion->microtime_float();
		
		if($desde=='a'){
			$desde 			= $this->input->post('desde');
			$hasta 			= $this->input->post('hasta');
			$sel_canal 		= $this->input->post('sel_canal');

			$ckcanal_todos 	= $this->input->post('ckcanal_todos');
			if ($ckcanal_todos == 'on') $ckcanal_todos = 1; else $ckcanal_todos = 0;
			$ckcanal_atc 	= $this->input->post('ckcanal_atc');
			if ($ckcanal_atc == 'on') $ckcanal_atc = 1; else $ckcanal_atc = 0;
			$ckcanal_ml 	= $this->input->post('ckcanal_ml');
			if ($ckcanal_ml == 'on') $ckcanal_ml = 1; else $ckcanal_ml = 0;
			$ckcanal_ms 	= $this->input->post('ckcanal_ms');
			if ($ckcanal_ms == 'on') $ckcanal_ms = 1; else $ckcanal_ms = 0;
			
			$cklocal_todos 	= $this->input->post('cklocal_todos');
			if ($cklocal_todos == 'on') $cklocal_todos = 1; else $cklocal_todos = 0;
			$cklocal_ave 	= $this->input->post('cklocal_ave');
			if ($cklocal_ave == 'on') $cklocal_ave = 1; else $cklocal_ave = 0;
			$cklocal_tor 	= $this->input->post('cklocal_tor');
			if ($cklocal_tor == 'on') $cklocal_tor = 1; else $cklocal_tor = 0;
			$cklocal_mar 	= $this->input->post('cklocal_mar');
			if ($cklocal_mar == 'on') $cklocal_mar = 1; else $cklocal_mar = 0;
			$cklocal_nd 	= $this->input->post('cklocal_nd');
			if ($cklocal_nd == 'on') $cklocal_nd = 1; else $cklocal_nd = 0;
		}else{
			$ckcanal_todos 	= 1;
			$ckcanal_atc 	= 0;
			$ckcanal_ml 	= 0;
			$ckcanal_ms 	= 0;
			
			$cklocal_todos 	= 1;
			$cklocal_ave 	= 0;
			$cklocal_tor 	= 0;
			$cklocal_mar 	= 0;
			$cklocal_nd 	= 0;
		}
		$datos['desde']  	= $desde;
		$datos['hasta']  	= $hasta;
		$datos['sel_canal'] = $sel_canal;

		$datos['ckcanal_todos'] = $ckcanal_todos;
		$datos['ckcanal_atc']  	= $ckcanal_atc;
		$datos['ckcanal_ml']  	= $ckcanal_ml;
		$datos['ckcanal_ms']  	= $ckcanal_ms;
			
		$datos['cklocal_todos'] = $cklocal_todos;
		$datos['cklocal_ave']  	= $cklocal_ave;
		$datos['cklocal_tor']  	= $cklocal_tor;
		$datos['cklocal_mar']  	= $cklocal_mar;
		$datos['cklocal_nd']  	= $cklocal_nd;

		$retorno = $this->M_operaciones->get_reporte_ventas_pantalla($desde, $hasta, $sel_canal);
		
		$datos['notificacion']  	= 'Reporte desde '.$desde.' hasta '.$hasta;

		$cant_canal=0;
		$precio_canal=0;
		$canal_anterior = 0;
		$canal_actual = 0;
		$local_anterior = 0;
		$local_actual = 0;
		$cant_local=0;
		$precio_local=0;
		$flag=0;
		$cont =0;
		$cont_canal =0;
		$cont_local =1;
		$canal = array();
		$local = array();
		$producto = array();
		$cantidad = array();
		$precio = array();
		$fila = array();
			
		foreach ($retorno->result() as $key) {
			# code...
			$valido=0;
			if($ckcanal_todos == 1 && $cklocal_todos == 1){
				$valido = 1;
			}else{
				if($ckcanal_todos == 0){
					if($ckcanal_atc == 1 && $key->canal_venta == 'ATC'){
						if($cklocal_todos == 0){
							if($cklocal_ave == 1 && $key->local_entrega == 'Local Avellaneda'){
								$valido = 1;
							}
							if($cklocal_tor == 1 && $key->local_entrega == 'Local Tortuga'){
								$valido = 1;
							}
							if($cklocal_mar == 1 && $key->local_entrega == 'Local Martínez'){
								$valido = 1;
							}
							if($cklocal_nd == 1 && $key->local_entrega == 'ND'){
								$valido = 1;
							}
						}else{
							$valido = 1;
						}
					}
					if($ckcanal_ml == 1 && $key->canal_venta == 'ML'){
						if($cklocal_todos == 0){
							if($cklocal_ave == 1 && $key->local_entrega == 'Local Avellaneda'){
								$valido = 1;
							}
							if($cklocal_tor == 1 && $key->local_entrega == 'Local Tortuga'){
								$valido = 1;
							}
							if($cklocal_mar == 1 && $key->local_entrega == 'Local Martínez'){
								$valido = 1;
							}
							if($cklocal_nd == 1 && $key->local_entrega == 'ND'){
								$valido = 1;
							}
						}else{
							if($cklocal_todos == 0){
								if($cklocal_ave == 1 && $key->local_entrega == 'Local Avellaneda'){
									$valido = 1;
								}
								if($cklocal_tor == 1 && $key->local_entrega == 'Local Tortuga'){
									$valido = 1;
								}
								if($cklocal_mar == 1 && $key->local_entrega == 'Local Martínez'){
									$valido = 1;
								}
								if($cklocal_nd == 1 && $key->local_entrega == 'ND'){
									$valido = 1;
								}
							}else{
								$valido = 1;
							}
						}
					}
					if($ckcanal_ms == 1 && $key->canal_venta == 'MS'){
						if($cklocal_todos == 0){
							if($cklocal_ave == 1 && $key->local_entrega == 'Local Avellaneda'){
								$valido = 1;
							}
							if($cklocal_tor == 1 && $key->local_entrega == 'Local Tortuga'){
								$valido = 1;
							}
							if($cklocal_mar == 1 && $key->local_entrega == 'Local Martínez'){
								$valido = 1;
							}
							if($cklocal_nd == 1 && $key->local_entrega == 'ND'){
								$valido = 1;
							}
						}else{
							if($cklocal_todos == 0){
								if($cklocal_ave == 1 && $key->local_entrega == 'Local Avellaneda'){
									$valido = 1;
								}
								if($cklocal_tor == 1 && $key->local_entrega == 'Local Tortuga'){
									$valido = 1;
								}
								if($cklocal_mar == 1 && $key->local_entrega == 'Local Martínez'){
									$valido = 1;
								}
								if($cklocal_nd == 1 && $key->local_entrega == 'ND'){
									$valido = 1;
								}
							}else{
								$valido = 1;
							}
						}
					}
				}
				
			}
			if($valido == 1){
				if($flag==0){
					$flag=1;//primer registro
					$canal_anterior = $key->canal_venta;
					$canal_actual = $key->canal_venta;
					$local_anterior = $key->local_entrega;
					$local_actual = $key->local_entrega;
					//resumen canal
					$canal[$cont_canal] = $canal_actual;
					$local[$cont_canal] = '';
					$producto[$cont_canal] = '';
					$cantidad[$cont_canal] = 0;
					$precio[$cont_canal] = 0;
					$fila[$cont_canal] = 0;
					// resumen local
					$canal[$cont_local] = '';
					$local[$cont_local] = $local_actual;
					$producto[$cont_local] = '';
					$cantidad[$cont_local] = 0;
					$precio[$cont_local] = 0;
					$fila[$cont_local] = 1;
					//detalle
					$cont=2;
					$canal[$cont] = '';
					$local[$cont] = '';
					$producto[$cont] = $key->nombre;
					$cantidad[$cont] = $key->cantidad;
					$precio[$cont] = $key->PVP_Neto;
					$fila[$cont] = 2;
					//Actu resumen canal
					$cantidad[$cont_canal] = $cantidad[$cont_canal] + $cantidad[$cont];
					$precio[$cont_canal] = $precio[$cont_canal] + $precio[$cont];
					//Actu resumen local
					$cantidad[$cont_local] = $cantidad[$cont_local] + $cantidad[$cont];
					$precio[$cont_local] = $precio[$cont_local] + $precio[$cont];
					
				}else{
					$canal_anterior = $canal_actual;
					$canal_actual = $key->canal_venta;
					$local_anterior = $local_actual;
					$local_actual = $key->local_entrega;

					if($canal_anterior == $canal_actual ){
						if($local_anterior == $local_actual){
							//mismo canal y local
							$cont= $cont + 1;
							//detalle						
							$canal[$cont] = '';
							$local[$cont] = '';
							$producto[$cont] = $key->nombre;
							$cantidad[$cont] = $key->cantidad;
							$precio[$cont] = $key->PVP_Neto;
							$fila[$cont] = 2;
							//Actu resumen canal
							$cantidad[$cont_canal] = $cantidad[$cont_canal] + $cantidad[$cont];
							$precio[$cont_canal] = $precio[$cont_canal] + $precio[$cont];
							//Actu resumen local
							$cantidad[$cont_local] = $cantidad[$cont_local] + $cantidad[$cont];
							$precio[$cont_local] = $precio[$cont_local] + $precio[$cont];
							
						}else{
							//mismo canal diferente local
							$cont_local= $cont + 1;
							// resumen local
							$canal[$cont_local] = '';
							$local[$cont_local] = $local_actual;
							$producto[$cont_local] = '';
							$cantidad[$cont_local] = 0;
							$precio[$cont_local] = 0;
							$fila[$cont_local] = 1;
							//detalle
							$cont = $cont_local + 1;
							$canal[$cont] = '';
							$local[$cont] = '';
							$producto[$cont] = $key->nombre;
							$cantidad[$cont] = $key->cantidad;
							$precio[$cont] = $key->PVP_Neto;
							$fila[$cont] = 2;
							//Actu resumen canal
							$cantidad[$cont_canal] = $cantidad[$cont_canal] + $cantidad[$cont];
							$precio[$cont_canal] = $precio[$cont_canal] + $precio[$cont];
							//Actu resumen local
							$cantidad[$cont_local] = $cantidad[$cont_local] + $cantidad[$cont];
							$precio[$cont_local] = $precio[$cont_local] + $precio[$cont];
						}
					}else{
						//diferente canal
						
						$cont_canal= $cont + 1;
						$cont_local= $cont + 2;
						// resumen canal
						$canal[$cont_canal] = $canal_actual;
						$local[$cont_canal] = '';
						$producto[$cont_canal] = '';
						$cantidad[$cont_canal] = 0;
						$precio[$cont_canal] = 0;
						$fila[$cont_canal] = 0;
						// resumen local
						$canal[$cont_local] = '';
						$local[$cont_local] = $local_actual;
						$producto[$cont_local] = '';
						$cantidad[$cont_local] = 0;
						$precio[$cont_local] = 0;
						$fila[$cont_local] = 1;
						//detalle
						$cont = $cont_local + 1;
						$canal[$cont] = '';
						$local[$cont] = '';
						$producto[$cont] = $key->nombre;
						$cantidad[$cont] = $key->cantidad;
						$precio[$cont] = $key->PVP_Neto;
						$fila[$cont] = 2;
						//Actu resumen canal
						$cantidad[$cont_canal] = $cantidad[$cont_canal] + $cantidad[$cont];
						$precio[$cont_canal] = $precio[$cont_canal] + $precio[$cont];
						//Actu resumen local
						$cantidad[$cont_local] = $cantidad[$cont_local] + $cantidad[$cont];
						$precio[$cont_local] = $precio[$cont_local] + $precio[$cont];
					}
				}
			}


		}
		$datos['canal']  	= $canal;
		$datos['local']  	= $local;
		$datos['producto']  = $producto;
		$datos['cantidad']  = $cantidad;
		$datos['precio']  	= $precio;
		$datos['fila']  	= $fila;

		$tiempo_fin = $this->M_configuracion->microtime_float();
		$tiempo = $tiempo_fin - $tiempo_inicio;
		$datos['tiempo'] = $tiempo;	

		$this->load->view('lte_header', $datos);
		$this->load->view('reporte_pantalla', $datos);
		$this->load->view('lte_footer', $datos);

	}
	public function reporte_ventas()
	{
		$fecha = new DateTime();		
		$anno  				= $fecha->format('Y');
		$datos['anno']  	= $anno;
		$mes  				= $fecha->format('m');
		$datos['mes']  		= $mes;
		$annos = $this->M_configuracion->obt_annos();
		$meses = $this->M_configuracion->obt_meses();
		
		$datos['annos']  	= $annos;
		$datos['meses']  	= $meses;
		$datos['canal']  	= 0;

		$this->load->view('lte_header', $datos);
		$this->load->view('v_reporte_ventas_filtrados', $datos);
		$this->load->view('lte_footer', $datos);
	}
	
	public function cargar_pack($id_pack)
	{
		$cli = $this->M_configuracion->obt_pack($id_pack);
		
        $row = $cli->result();	
		echo json_encode($row);
	}
	public function convenir($id_pedido)
	{
		$datos['id_pedido']  	= $id_pedido;
		$datos['empresas'] 		= $this->M_configuracion->obt_empresas();
		$datos['locales'] 		= $this->M_configuracion->obt_locales();
		
		$this->load->view('lte_header', $datos);
		$this->load->view('v_convenir_despacho', $datos);
		$this->load->view('lte_footer', $datos);
	}
	
	public function definir_despacho($id_pedido)
	{
		
		$id_empresa 	= $this->input->post('sel_empresa');
		$despacho 		= $this->input->post('despacho');
		$id_local 		= $this->input->post('sel_locales');
		if($despacho ==1){// showroom
			$resultado = $this->M_operaciones->convenir_showroom($id_pedido, $id_local);
		}else{
			$resultado = $this->M_operaciones->convenir_tercero($id_pedido, $id_empresa);
		}
		$resultado = $this->M_operaciones->quitar_convenir($id_pedido);
		$this->obtener_pedidos();
	}
	// Nueva venta
	public function nueva_venta_rev($id_cliente)
	{
		$data = array(
			'mision' 	=> 		0     
		);		
		$this->session->set_userdata($data);
		$codigo_postal_empresa 	= $this->obtener_parametro('CODIGO_POSTAL_ORIGEN');
		$oca 	= new Oca($cuit = '30-69511732-5', 71243);
		
		$centros_x_cp = $oca->getCentrosImposicionPorCP($cp = $codigo_postal_empresa);
		
		//$this->M_operaciones->actSucursal($centros_x_cp);
		
		
		$niveles 				= $this->M_configuracion->obt_niveles_vip();
		$provincias 			= $this->M_operaciones->provincias();		
		$productos 				= $this->M_operaciones->productos_rev();		
		$tipos_factura 			= $this->M_operaciones->tipos_factura();
		$empresas_flete 		= $this->M_operaciones->empresas_flete();
		$misiones_activas     	= $this->M_operaciones->obtener_misiones_activas();
		$pack 					= $this->M_configuracion->obt_packs();		
		$resultado = $this->M_configuracion->obt_paises();
		$datos['paises'] = $resultado;
		$cliente_id= $id_cliente;
		$pedido_mision=0;

		$costo =0;		
		$anno=date('Y');
		$mes=date('m');
		$res = $this->M_operaciones->obtener_costo($anno, $mes);
		
		$row = $res->row();
		if($row != ''){
			$costo = $row->costo;
		}
		$iva =0;
		$res = $this->M_configuracion->obtener_iva($anno, $mes);
		
		$row = $res->row();
		if($row != ''){
			$iva = $row->iva;
		}
		$user = $this->ion_auth->user()->row();		
		$id_usuario = $user->id;
		
		$group = array('ConsultorRVInt'); 
		if ($this->ion_auth->in_group($group)){
			
			$id_pais = $this->M_operaciones->obt_rev_pais($id_usuario);
			$iva = $this->M_operaciones->obt_rev_int_iva($id_pais);
			$tipos_factura 	= $this->M_operaciones->obt_rev_int_facturas($id_pais);
		}	
		$group = array('ConsultorRV','ConsultorRVInt');
							
		if ($this->ion_auth->in_group($group)) { 			
			$revendedor = 'true'; 			
			$user = $this->ion_auth->user()->row();
			// El usuario es consultor revendedor
			$clientes = $this->M_configuracion->clientes_revendedores1($user->id, $id_cliente);
			$datos['misiones'] = $this->M_configuracion->misiones_propuestas_revendedores($user->id);
			
		}else 
		{
			$clientes = $this->M_operaciones->clientes();
			$revendedor = 'false'; 
			$datos['misiones'] = $this->M_configuracion->misiones_propuestas();
		}
		$colores 				= $this->M_configuracion->obt_colores();
		$campanas 				= $this->M_configuracion->obt_campanas();

		$canales 				= $this->M_operaciones->canales();
		$consecutivo 			= $this->obtener_parametro('CODIGO_PEDIDO') . '-' . $this->obtener_parametro('CONSECUTIVO_VENTA');
		
		if (!$provincias->row() || !$productos->row() || !$tipos_factura->row() || !$canales->row() || !$campanas->row() || !$colores->row() ||$iva ==0 ||$costo ==0)
		{
			
			$this->notificacion = 'Debe revisar los siguientes parámetros antes de realizar esta operación </br>';
			if (!$provincias->row()){			
				$this->notificacion = $this->notificacion .' Provincias </br>';		
			}
			if (!$productos->row()){			
				$this->notificacion = $this->notificacion .' Productos </br>';		
			}
			if (!$tipos_factura->row()){			
				$this->notificacion = $this->notificacion .' Tipo de factura </br>';		
			}
			if (!$canales->row()){			
				$this->notificacion = $this->notificacion .' Canales </br>';		
			}
			if (!$campanas->row()){			
				$this->notificacion = $this->notificacion .' Campañas </br>';		
			}
			if (!$colores->row()){			
				$this->notificacion = $this->notificacion .' Colores </br>';		
			}
			if (!$iva){			
				$this->notificacion = $this->notificacion .' IVA </br>';		
			}
			if (!$costo){			
				$this->notificacion = $this->notificacion .' Costo </br>';		
			}
		}else{
			
			$this->notificacion = '';
			
		}
		$datos['codigo_postal_empresa'] = $codigo_postal_empresa;
		$datos['provincias'] 		= $provincias;
		$datos['productos'] 		= $productos;
		$sucursales 				= $this->M_operaciones->sucursales();
		$datos['forma_pagos']		= $this->M_operaciones->obt_formas_pago();
		$datos['sucursales'] 		= $sucursales;
		$lockers 					= $this->M_operaciones->lockers();		
		$datos['lockers'] 			= $lockers;	
		$operativas 				= $this->M_operaciones->operativas();
		$datos['operativas'] 		= $operativas;		
		$datos['tipos_factura'] 	= $tipos_factura;
		$datos['empresas_flete'] 	= $empresas_flete;
		$datos['clientes'] 			= $clientes;
		$datos['revendedor'] 		= $revendedor; 
		$datos['canales'] 			= $canales;
		$datos['costo'] 			= $costo;
		$datos['iva'] 				= $iva;
		$datos['consecutivo'] 		= $consecutivo;
		$datos['misiones_activas'] 	= $misiones_activas;
		$datos['cliente_id']		= $cliente_id;
		$datos['pedido_mision']		= $pedido_mision;
		$datos['niveles']			= $niveles;
		$datos['pack']			= $pack;
		
		if($this->notificacion_error == true){
			
			$this->notificacion = validation_errors();
			$datos['notificacion'] = $this->notificacion;				
			$datos['notificacion_error'] = $this->notificacion_error;
			$this->load->view('lte_header', $datos);
			$this->load->view('v_at_rev', $datos);
			$this->load->view('lte_footer', $datos);
			
			return;
		}
		
		$datos['notificacion'] 		= $this->notificacion;
		
		$this->load->view('lte_header', $datos);
		$this->load->view('v_at_rev', $datos);
		$this->load->view('lte_footer', $datos);	
	}
	public function nueva_venta_revint($id_cliente)
	{
		$data = array(
			'mision' 	=> 		0     
		);		
		$this->session->set_userdata($data);
		$codigo_postal_empresa 	= $this->obtener_parametro('CODIGO_POSTAL_ORIGEN');
		$oca 	= new Oca($cuit = '30-69511732-5', 71243);
		
		//$centros_x_cp = $oca->getCentrosImposicionPorCP($cp = $codigo_postal_empresa);
		
		//$this->M_operaciones->actSucursal($centros_x_cp);
		
		
		$niveles 				= $this->M_configuracion->obt_niveles_vip();
		$provincias 			= $this->M_operaciones->provincias();		
		$productos 				= $this->M_operaciones->productos_rev();		
		$tipos_factura 			= $this->M_operaciones->tipos_factura();
		$empresas_flete 		= $this->M_operaciones->empresas_flete();
		$misiones_activas     	= $this->M_operaciones->obtener_misiones_activas();
		$pack 					= $this->M_configuracion->obt_packs();		
		$resultado = $this->M_configuracion->obt_paises();
		$datos['paises'] = $resultado;
		$cliente_id= $id_cliente;
		$pedido_mision=0;

		$costo =0;		
		$anno=date('Y');
		$mes=date('m');
		$res = $this->M_operaciones->obtener_costo($anno, $mes);
		
		$row = $res->row();
		if($row != ''){
			$costo = $row->costo;
		}
		$iva =0;
		$res = $this->M_configuracion->obtener_iva($anno, $mes);
		
		$row = $res->row();
		if($row != ''){
			$iva = $row->iva;
		}
		$user = $this->ion_auth->user()->row();		
		$id_usuario = $user->id;
		
		$group = array('ConsultorRVInt'); 
		if ($this->ion_auth->in_group($group)){
			
			$id_pais = $this->M_operaciones->obt_rev_pais($id_usuario);
			//$iva = $this->M_operaciones->obt_rev_int_iva($id_pais);
			//$tipos_factura 	= $this->M_operaciones->obt_rev_int_facturas($id_pais);
		}	
		$group = array('ConsultorRV','ConsultorRVInt');
							
		if ($this->ion_auth->in_group($group)) { 			
			$revendedor = 'true'; 			
			$user = $this->ion_auth->user()->row();
			// El usuario es consultor revendedor
			$clientes = $this->M_configuracion->clientes_revendedoresint($user->id,$id_cliente);
			//$datos['misiones'] = $this->M_configuracion->misiones_propuestas_revendedores($user->id);
			
		}else 
		{
			$clientes = $this->M_operaciones->clientes();
			$revendedor = 'false'; 
			$datos['misiones'] = $this->M_configuracion->misiones_propuestas();
		}
		$colores 				= $this->M_configuracion->obt_colores();
		$campanas 				= $this->M_configuracion->obt_campanas();

		$canales 				= $this->M_operaciones->canales();
		$consecutivo 			= $this->obtener_parametro('CODIGO_PEDIDO') . '-' . $this->obtener_parametro('CONSECUTIVO_VENTA');
		
		if (!$provincias->row() || !$productos->row() || !$tipos_factura->row() || !$canales->row() || !$campanas->row() || !$colores->row() ||$iva ==0 ||$costo ==0)
		{
			
			$this->notificacion = 'Debe revisar los siguientes parámetros antes de realizar esta operación </br>';
			if (!$provincias->row()){			
				$this->notificacion = $this->notificacion .' Provincias </br>';		
			}
			if (!$productos->row()){			
				$this->notificacion = $this->notificacion .' Productos </br>';		
			}
			if (!$tipos_factura->row()){			
				$this->notificacion = $this->notificacion .' Tipo de factura </br>';		
			}
			if (!$canales->row()){			
				$this->notificacion = $this->notificacion .' Canales </br>';		
			}
			if (!$campanas->row()){			
				$this->notificacion = $this->notificacion .' Campañas </br>';		
			}
			if (!$colores->row()){			
				$this->notificacion = $this->notificacion .' Colores </br>';		
			}
			if (!$iva){			
				$this->notificacion = $this->notificacion .' IVA </br>';		
			}
			if (!$costo){			
				$this->notificacion = $this->notificacion .' Costo </br>';		
			}
		}else{
			
			$this->notificacion = '';
			
		}
		$datos['codigo_postal_empresa'] = $codigo_postal_empresa;
		$datos['provincias'] 		= $provincias;
		$datos['productos'] 		= $productos;
		$sucursales 				= $this->M_operaciones->sucursales();
		$datos['forma_pagos']		= $this->M_operaciones->obt_formas_pago();
		$datos['sucursales'] 		= $sucursales;
		$lockers 					= $this->M_operaciones->lockers();		
		$datos['lockers'] 			= $lockers;	
		$operativas 				= $this->M_operaciones->operativas();
		$datos['operativas'] 		= $operativas;		
		$datos['tipos_factura'] 	= $tipos_factura;
		$datos['empresas_flete'] 	= $empresas_flete;
		$datos['clientes'] 			= $clientes;
		$datos['revendedor'] 		= $revendedor; 
		$datos['canales'] 			= $canales;
		$datos['costo'] 			= $costo;
		$datos['iva'] 				= $iva;
		$datos['consecutivo'] 		= $consecutivo;
		$datos['misiones_activas'] 	= $misiones_activas;
		$datos['cliente_id']		= $cliente_id;
		$datos['pedido_mision']		= $pedido_mision;
		$datos['niveles']			= $niveles;
		$datos['pack']			= $pack;
		
		if($this->notificacion_error == true){
			
			$this->notificacion = validation_errors();
			$datos['notificacion'] = $this->notificacion;				
			$datos['notificacion_error'] = $this->notificacion_error;
			$this->load->view('lte_header', $datos);
			$this->load->view('v_at_rev', $datos);
			$this->load->view('lte_footer', $datos);
			
			return;
		}
		
		$datos['notificacion'] 		= $this->notificacion;
		
		$this->load->view('lte_header', $datos);
		$this->load->view('v_at_revint', $datos);
		$this->load->view('lte_footer', $datos);	
	}
	
	///*****************************************************
	public function nueva_venta_mision_rev($cliente_id, $id_pedido)
	{		
		$data = array(
			'mision' 	=> 		1     
		);		
		$this->session->set_userdata($data);
		$codigo_postal_empresa 	= $this->obtener_parametro('CODIGO_POSTAL_ORIGEN');
		$oca 	= new Oca($cuit = '30-69511732-5', 71243);
		$centros_x_cp = $oca->getCentrosImposicionPorCP($cp = $codigo_postal_empresa);
		//$this->M_operaciones->actSucursal($centros_x_cp);

		$niveles 				= $this->M_configuracion->obt_niveles_vip();
		$provincias 			= $this->M_operaciones->provincias();
		$productos 				= $this->M_operaciones->productos_rev();		
		$tipos_factura 			= $this->M_operaciones->tipos_factura();
		$empresas_flete 		= $this->M_operaciones->empresas_flete();
		$misiones_activas     	= $this->M_operaciones->obtener_misiones_activas();
		$pack 					= $this->M_configuracion->obt_packs();
		$pedido_mision=$id_pedido;
		$resultado = $this->M_configuracion->obt_paises();
		$datos['paises'] = $resultado;
		$costo =0;		
		$anno=date('Y');
		$mes=date('m');
		$res = $this->M_operaciones->obtener_costo($anno, $mes);
		
		$row = $res->row();
		if($row != ''){
			$costo = $row->costo;
		}
		$iva =0;
		$res = $this->M_configuracion->obtener_iva($anno, $mes);
		
		$row = $res->row();
		if($row != ''){
			$iva = $row->iva;
		}	
		$user = $this->ion_auth->user()->row();		
		$id_usuario = $user->id;
		
		$group = array('ConsultorRVInt'); 
		if ($this->ion_auth->in_group($group)){
			
			$id_pais = $this->M_operaciones->obt_rev_pais($id_usuario);
			$iva = $this->M_operaciones->obt_rev_int_iva($id_pais);
			$tipos_factura 	= $this->M_operaciones->obt_rev_int_facturas($id_pais);
		}	
		$group = array('ConsultorRV','ConsultorRVInt');
		               
		if ($this->ion_auth->in_group($group)) { 			
			$revendedor = 'true'; 			
			$user = $this->ion_auth->user()->row();
			$clientes = $this->M_configuracion->clientes_revendedores_mision($user->id, $cliente_id);
				$datos['misiones'] = $this->M_configuracion->misiones_propuestas_revendedores($user->id);
			
			
		}else 
		{
			$clientes = $this->M_operaciones->clientes_mision($cliente_id);
			$revendedor = 'false'; 
			$datos['misiones'] = $this->M_configuracion->misiones_propuestas();
		}
		$colores 				= $this->M_configuracion->obt_colores();
		$campanas 				= $this->M_configuracion->obt_campanas();

		$canales 				= $this->M_operaciones->canales();
		$consecutivo 			= $this->obtener_parametro('CODIGO_PEDIDO') . '-' . $this->obtener_parametro('CONSECUTIVO_VENTA');
		
		if (!$provincias->row() || !$productos->row() || !$tipos_factura->row() || !$canales->row() || !$campanas->row() || !$colores->row() ||$iva ==0 ||$costo ==0)
		{
			
			$this->notificacion = 'Debe revisar los siguientes parámetros antes de realizar esta operación </br>';
			if (!$provincias->row()){			
				$this->notificacion = $this->notificacion .' Provincias </br>';		
			}
			if (!$productos->row()){			
				$this->notificacion = $this->notificacion .' Productos </br>';		
			}
			if (!$tipos_factura->row()){			
				$this->notificacion = $this->notificacion .' Tipo de factura </br>';		
			}
			if (!$canales->row()){			
				$this->notificacion = $this->notificacion .' Canales </br>';		
			}
			if (!$campanas->row()){			
				$this->notificacion = $this->notificacion .' Campañas </br>';		
			}
			if (!$colores->row()){			
				$this->notificacion = $this->notificacion .' Colores </br>';		
			}
			if (!$iva){			
				$this->notificacion = $this->notificacion .' IVA </br>';		
			}
			if (!$costo){			
				$this->notificacion = $this->notificacion .' Costo </br>';		
			}
		}else{
			
			$this->notificacion = '';
			
		}
		$datos['codigo_postal_empresa'] = $codigo_postal_empresa;
		$datos['provincias'] 		= $provincias;
		$datos['productos'] 		= $productos;		
		$sucursales 				= $this->M_operaciones->sucursales();
		$datos['forma_pagos']		= $this->M_operaciones->obt_formas_pago();
		$datos['sucursales'] 		= $sucursales;
		$lockers 					= $this->M_operaciones->lockers();		
		$datos['lockers'] 			= $lockers;	
		$operativas 				= $this->M_operaciones->operativas();
		$datos['operativas'] 		= $operativas;		
		$datos['tipos_factura'] 	= $tipos_factura;
		$datos['empresas_flete'] 	= $empresas_flete;
		$datos['clientes'] 			= $clientes;
		$datos['revendedor'] 		= $revendedor;
		$datos['canales'] 			= $canales;
		$datos['costo'] 			= $costo;
		$datos['iva'] 				= $iva;
		$datos['consecutivo'] 		= $consecutivo;
		$datos['misiones_activas'] 	= $misiones_activas;
		$datos['cliente_id']		= $cliente_id;
		$datos['pedido_mision']		= $pedido_mision;
		$datos['niveles']			= $niveles;
		$datos['pack']				= $pack;
		
		if($this->notificacion_error == true){
			
			$this->notificacion = '';
			$datos['notificacion'] = $this->notificacion;				
			$datos['notificacion_error'] = $this->notificacion_error;
			
			$this->load->view('lte_header', $datos);
			$this->load->view('v_at_rev', $datos);
			$this->load->view('lte_footer', $datos);
			
			return;
		}
		
		$datos['notificacion'] 		= $this->notificacion;
		
		$this->load->view('lte_header', $datos);
		$this->load->view('v_at_rev', $datos);
		$this->load->view('lte_footer', $datos);	
	}
	
	// ------------------------------------------------------
	// Registrar venta
	
	public function venta_rev()
	{	
		$data = array(
			'mision' 	=> 		0     
		);		
		$this->session->set_userdata($data);

		$cupon_nro = 	$this->input->post('cupon_nro');
		$cupon_promo = 	$this->input->post('cupon_promo');
		$nro_remito = 	$this->input->post('nro_remito');
		$tx_no_acreditada = 0;
		$frm_medio = 	$this->input->post('frm_medio');
			// Cliente
			$forma_pago = 	$this->input->post('id_forma_pago');	 
			$revendedor = $this->input->post('frm_revendedor');
			$nuevo_cliente = $this->input->post('frm_nuevo_cliente');
			$id_cliente_act = $this->input->post('frm_id_cliente');
			$pedido_mision = $this->input->post('frm_pedido_mision');
			$dni = $this->input->post('frm_dni');
			$nombre = $this->input->post('frm_nombre');
			$apellidos = $this->input->post('frm_apellidos');
			$telefono = $this->input->post('frm_telefono');
			$celular = $this->input->post('frm_celular');
			$email = $this->input->post('frm_email');
			$codigo_postal = $this->input->post('frm_codigo_postal');
			$id_municipio = $this->input->post('frm_id_municipio');		 
			$calle = $this->input->post('frm_calle');
			$nro = $this->input->post('frm_nro');
			$piso = $this->input->post('frm_piso');
			$dpto = $this->input->post('frm_dpto');
			$entrecalle1 = $this->input->post('frm_entrecalle1');
			$entrecalle2 = $this->input->post('frm_entrecalle2');
			$fecha_nacimiento = $this->input->post('frm_fecha_nacimiento');
			$observaciones = $this->input->post('frm_observaciones');
			$cuit = $this->input->post('frm_cuit');
			// Venta
			$id_canal = $this->input->post('frm_id_canal');
			//$id_pedido = $this->input->post('id_pedido');
			$no_factura = $this->input->post('frm_factura');
			$id_transaccion = $this->input->post('frm_transaccion');
			$fecha_venta = $this->input->post('frm_fecha');
			$recargo = $this->input->post('frm_recargo');
			$tipo_factura = $this->input->post('frm_id_tipo_factura');
			$calle_entrega = $this->input->post('frm_calle_entrega');
			$nro_entrega = $this->input->post('frm_nro_entrega');
			$piso_entrega = $this->input->post('frm_piso_entrega');
			$dpto_entrega = $this->input->post('frm_dpto_entrega');
			$municipio_entrega = $this->input->post('frm_municipio_entrega');
			$provincia_entrega = $this->input->post('frm_provincia_entrega');
			$entrecalle1_entrega = $this->input->post('frm_entrecalle1_entrega');
			$entrecalle2_entrega = $this->input->post('frm_entrecalle2_entrega');
			$monto_iva = $this->input->post('frm_monto_iva');
			$monto_recargo = $this->input->post('frm_monto_recargo');
			$codigo_postal_entrega=  $this->input->post('frm_codigo_postal_entrega');
			
			$envio_inmediato = 'NO';
			
		$id_envio_oca		= $this->input->post('frm_id_envio_oca');	
		
		$dt_productos		= explode(',',$this->input->post('frm_dtProductos'));
		$dt_campanas		= explode(',',$this->input->post('frm_dtCampanas'));
		$dt_colores			= explode(',',$this->input->post('frm_dtColores'));
		$dt_descuentos		= explode(',',$this->input->post('frm_dtDescuentos'));
		$dt_descuentos_vip	= explode(',',$this->input->post('frm_dtDescuentos_vip'));
		$dt_incrementos		= explode(',',$this->input->post('frm_dtIncrementos'));
		$dt_precios			= explode(',',$this->input->post('frm_dtPrecios'));		
		$dt_cantidades		= explode(',',$this->input->post('frm_dtCantidades'));		
		$total_productos 	= $this->input->post('frm_TotalProductos');
		$dt_alto			= explode(',',$this->input->post('frm_dtAlto'));
		$dt_ancho			= explode(',',$this->input->post('frm_dtAncho'));
		$dt_largo			= explode(',',$this->input->post('frm_dtLargo'));
		$dt_peso			= explode(',',$this->input->post('frm_dtPeso'));
		// si es mision buscar pedido_mision
		if($id_canal ==6){
			$cli = $this->M_configuracion->pedido_cliente_mision($id_cliente_act);
			$row1 = $cli->row();			
			$pedido_mision = $row1->id_pedido;			
		}
			

		// Entrega
			$tipo_envio = $this->input->post('frm_nombre_tipo_envio');		
			$id_empresa = $this->input->post('frm_id_empresa');
			$tipo_empresa = $this->input->post('frm_id_tipo_empresa');
			$id_sucursal = $this->input->post('frm_id_sucursal');
			$operativa = $this->input->post('frm_operativa');
			
			if($tipo_empresa == 1){
			$idci = $id_sucursal;
			}else{
			$idci = "0";
			}
			
			$res = $this->M_operaciones->obtener_parametro('CONSECUTIVO_VENTA');
			$cod = $this->M_operaciones->obtener_parametro('CODIGO_PEDIDO');
			$row = $res->row();
			$row_cod = $cod->row();
			$id_pedido = $row_cod->valor . '-' . $row->valor;
			
		//$resultado=$this->M_configuracion->upd_configuracion('CONSECUTIVO_VENTA',$valor_consecutivo);
			$res = $this->M_operaciones->obtener_parametro('COMISION_ATENCION');
			$row = $res->row();
			$com_atencion = $row->valor_decimal;
		
			$res = $this->M_operaciones->obtener_parametro('COMISION_MISION');
			$row = $res->row();
			$com_mision = $row->valor_decimal;
		
		/*if($recargo == 'SI'){
			$anno=date('Y');
			$mes=date('m');
			$res = $this->M_operaciones->obtener_costo($anno, $mes);
			$row = $res->row();
			$costo = $row->costo;
		}else
			$costo =0;*/
		/*****************Validadion**********************/
		
		$this->load->library('form_validation');	 
		
		$this->form_validation->set_rules('frm_nombre', 'Nombre', 'required');
		$this->form_validation->set_rules('frm_apellidos', 'Apellidos', 'required');
		
		
		$recargo= $monto_recargo;
		if ($this->form_validation->run() == true )
		{
			$registro = $this->M_operaciones->registrar_venta_rev(
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
			);
			$this->notificacion_error = false;
			
			//$id_pedido1 = $this->M_configuracion->obt_id_pedido($id_pedido);
			$id_pedido1 =$registro;
			if( $tipo_envio == "Por tercero"){
				$cfg1 = $this->M_operaciones->obt_conf_envio();
				if ($cfg1)
				{
					$cfg = $cfg1->row();
					$id  = $cfg->id ;   
					$calle_origen = $cfg->calle_origen ;
					$nro_origen = $cfg->nro_origen ; 
					$piso_origen = $cfg->piso_origen ; 
					$depto_origen = $cfg->depto_origen ; 
					$cp_origen = $cfg->cp_origen ; 
					$localidad_origen = $cfg->localidad_origen ; 
					$provincia_origen = $cfg->provincia_origen ;
					$contacto_origen = $cfg->contacto_origen ;
					$email_origen  = $cfg->email_origen ; 
					$solicitante_origen = $cfg->solicitante_origen ; 
					$observaciones_origen = $cfg->observaciones_origen ; 
					$centrocosto_origen = $cfg->centrocosto_origen ; 
					$idfranjahoraria_origen = $cfg->idfranjahoraria_origen ; 
					$idcentroimposicionorigen = $cfg->idcentroimposicionorigen ;
				}

				// crear el xml **********************************************************************
				$oca 	= new Oca($cuit = '30-69511732-5', 71243);
				$centros_x_cp = $oca->getCentrosImposicionPorCP($cp = '$codigo_postal_entrega');
				if(count($centros_x_cp)>0){
					$localidad = $centros_x_cp[0]['Localidad'];
					$provincia = $centros_x_cp[0]['Provincia'];
					
				}else{
					$localidad = 'CAPITAL FEDERAL';
					$provincia = 'CAPITAL FEDERAL';
				}

				$this->load->helper(array('xml','file'));
				//********************** */
				/*if(date('Y-m-d')>='2018-02-08' && date('Y-m-d')<'2018-02-14'){
					$fecha_hoy = '2018-02-14';
				}else*/
					$fecha_hoy = $this->cargar_fecha();
				//****************************** */
				$dom = xml_dom();
				$row = xml_add_child($dom, 'ROWS');
				
				$cabecera = xml_add_child($row, 'cabecera');
				xml_add_attribute($cabecera, 'ver', '2.0');
				xml_add_attribute($cabecera, 'nrocuenta', '142852/000');
				$origenes = xml_add_child($row, 'origenes');
				
				$origen = xml_add_child($origenes, 'origen');		
				xml_add_attribute($origen, 'calle', $calle_origen);
				xml_add_attribute($origen, 'nro', $nro_origen);
				xml_add_attribute($origen, 'piso', $piso_origen);
				xml_add_attribute($origen, 'depto', $depto_origen);
				xml_add_attribute($origen, 'cp', $cp_origen);
				xml_add_attribute($origen, 'localidad', $localidad_origen);
				xml_add_attribute($origen, 'provincia', $provincia_origen);
				xml_add_attribute($origen, 'contacto', $contacto_origen);
				xml_add_attribute($origen, 'email', $email_origen);
				xml_add_attribute($origen, 'solicitante', $solicitante_origen);
				xml_add_attribute($origen, 'observaciones', $observaciones_origen);
				xml_add_attribute($origen, 'centrocosto', $centrocosto_origen);
				xml_add_attribute($origen, 'idfranjahoraria', $idfranjahoraria_origen);
				xml_add_attribute($origen, 'idcentroimposicionorigen', $idcentroimposicionorigen);
				xml_add_attribute($origen, 'fecha', $fecha_hoy);
			
				$envios = xml_add_child($origen, 'envios');
				
				$envio = xml_add_child($envios, 'envio');		
				xml_add_attribute($envio, 'idoperativa', $operativa);
				xml_add_attribute($envio, 'nroremito', $no_factura);

				$destinatario = xml_add_child($envio, 'destinatario');
				xml_add_attribute($destinatario, 'apellido', $apellidos);
				xml_add_attribute($destinatario, 'nombre', $nombre);
				xml_add_attribute($destinatario, 'calle', $calle_entrega);
				xml_add_attribute($destinatario, 'nro', $nro_entrega);
				xml_add_attribute($destinatario, 'piso', $piso_entrega);
				xml_add_attribute($destinatario, 'depto', $dpto_entrega);
				xml_add_attribute($destinatario, 'localidad', $localidad);
				xml_add_attribute($destinatario, 'provincia', $provincia);
				xml_add_attribute($destinatario, 'cp', $codigo_postal_entrega);
				xml_add_attribute($destinatario, 'telefono', $telefono);
				xml_add_attribute($destinatario, 'email', $email);
				xml_add_attribute($destinatario, 'idci', $idci);
				xml_add_attribute($destinatario, 'celular', $celular);
				xml_add_attribute($destinatario, 'observaciones', '');

				$re = $this->M_operaciones->actualizar_envio_oca($id_envio_oca, 
							$id_pedido1, 
							$calle_origen , 
							$nro_origen, 
							$piso_origen, 
							$depto_origen, 
							$cp_origen , 
							$localidad_origen, 
							$provincia_origen , 
							$contacto_origen, 
							$email_origen , 
							$solicitante_origen, 
							$observaciones_origen , 
							$centrocosto_origen, 
							$idfranjahoraria_origen ,
							$idcentroimposicionorigen, 
							$fecha_hoy , 
							$operativa, 
							$no_factura , 
							$apellidos, 
							$nombre, 
							$calle_entrega, 
							$nro_entrega , 
							$piso_entrega, 
							$dpto_entrega , 
							$localidad, 
							$email , 
							$idci, 
							$celular, 
							'', 
							$provincia , 
							$codigo_postal_entrega,
							$telefono);
				$paquetes = xml_add_child($envio, 'paquetes');
				
				$paque1 = $this->M_operaciones->buscar_detalles_envio_oca1($id_envio_oca);
				foreach ($paque1->result() as $pa) {
					$paquete = xml_add_child($paquetes, 'paquete');
					xml_add_attribute($paquete, 'alto', $pa->alto_paquete);
					xml_add_attribute($paquete, 'ancho', $pa->ancho_paquete);
					xml_add_attribute($paquete, 'largo', $pa->largo_paquete);
					xml_add_attribute($paquete, 'peso', $pa->peso);
					xml_add_attribute($paquete, 'valor', $pa->valor);
					xml_add_attribute($paquete, 'cant', $pa->cantidad);
				}
				/*for ($i=0; $i<count($dt_productos); $i++ )
				{
					$paquete = xml_add_child($paquetes, 'paquete');
					xml_add_attribute($paquete, 'alto', $dt_alto[$i]);
					xml_add_attribute($paquete, 'ancho', $dt_ancho[$i]);
					xml_add_attribute($paquete, 'largo', $dt_largo[$i]);
					xml_add_attribute($paquete, 'peso', $dt_peso[$i]);
					xml_add_attribute($paquete, 'valor', $dt_precios[$i]);
					xml_add_attribute($paquete, 'cant', $dt_cantidades[$i]);
				}*/
				/*
				if($envio_inmediato == 'SI'){
					$fichero = './assets/envio.xml';
					if(write_file($fichero, xml_print($dom, $return = TRUE))){
						$this->subir_al_carrito($fichero, $id_pedido1);
					}
				}else{
					// buscar ultimo número de envio almacenado y la primera fecha despues de 3 dias 
					$ultimo_id = $this->M_operaciones->obt_ultimoID();
					$primera_fecha = $this->M_operaciones->obt_primeraFecha();
					
					// almacenar el envio
					$id1 = $ultimo_id + 1;
					$fichero = './assets/envio'.$id1.'.xml';
					if(write_file($fichero, xml_print($dom, $return = TRUE))){
						$res1 = $this->M_operaciones->registrar_carrito( $id1, $id_pedido1, $fecha_venta);
					}	
					$this->subir_a_oca();
					
				}*/
				
			}
			$id_cliente_act =  $this->M_operaciones->buscar_cliente_pedido($id_pedido1);

		}
		/* if($registro){
			echo $registro;
				
			}
				else{
				echo 'fallo';
			}*/
		//Preparar el mensaje a enviar por email.		
		
		$tipo_factura;
		$calle_entrega;
		$nro_entrega;
		$piso_entrega;
		$dpto_entrega;
		$entrecalle1_entrega;
		$entrecalle2_entrega;
		$iva = 0;
		$recargo = 0;
		$tipo_entrega ='';
		$importe = 0;
		$cantidad = 0;
		$productos = "";
		$precio = 0;
		$descuento = 0;
		$importe_total = 0;
		
		$datos_producto_mensaje = '';
		$cuerpo_mensaje2="";
		if($tipo_envio =="Showroom"){		
			
				$detalles_pedido = $this->M_operaciones->obt_detalle_pedido($id_pedido);		
				
				foreach ($detalles_pedido->result() as $pr){						   
				
					$tipo_factura = $pr->tipo_factura;
							/*$calle_entrega = $pr->calle_entrega;
					$nro_entrega = $pr->nro_entrega;
					$piso_entrega = $pr->piso_entrega;
					$dpto_entrega = $pr->dpto_entrega;
					$entrecalle1_entrega = $pr->entrecalle1_entrega;
					$entrecalle2_entrega = $pr->entrecalle2_entrega;*/
					$iva = $pr->iva;
					$recargo = $pr->recargo;
					
					$cantidad = $pr->cantidad;
					$productos = $pr->nombre;
					$precio = $pr->precio;
					$descuento = $pr->descuento;
					$importe = ($cantidad*$precio)-$descuento;
					$importe_total+=$importe;
							
					$datos_producto_mensaje = $datos_producto_mensaje.
						'<ul>
							<li>'.$productos.'</li>
							<li>'.$cantidad.'</li>
							<li>'.$precio.'</li>
							<li>'.$descuento.'</li>
							<li>'.$importe.'</li>
						</ul>';
							
				}
		}else{
			
				$detalles_pedido_terceros = $this->M_operaciones->obt_pedido_tercero2($id_pedido);
				
				$identificador_envio = 0;
				$nombre_empresa = '';
				
				$datos_producto_mensaje = '';
			
				foreach ($detalles_pedido_terceros->result() as $pr){					   
				
					$nombre_empresa = $pr->empresa;
					$tipo_factura = $pr->tipo_factura;
					
					$iva = $pr->iva;
					$recargo = $pr->recargo;
					$tipo_entrega = $pr->tipo_entrega;
					$cantidad = $pr->cantidad;
					$productos = $pr->producto;
					$precio = $pr->precio;
					$descuento = $pr->descuento;
					$importe = ($cantidad*$precio)-$descuento;
					$importe_total+=$importe;
							
					$datos_producto_mensaje = $datos_producto_mensaje.
					'<ul>
						<li>PRODUCTO: '.$productos.'</li>
						<li>CANTIDAD: '.$cantidad.'</li>
						<li>PRECIO: $'.$precio.'</li>
						<li>DESCUENTO: '.$descuento.'%</li>
						<li>IMPORTE: $'.$importe.'</li>
					</ul>';					
			}
			
			$cuerpo_mensaje2 = '
					</br> Empresa: '.$nombre_empresa;
				
		}
			
		//$detalles_pedido = $this->M_operaciones->obt_detalle_pedido($id_pedido);
		
		
			
		$importe_total = $importe_total + $recargo+$iva;
		$cuerpo_mensaje1 = $datos_producto_mensaje;
		if($tipo_envio == "Por tercero"){
			$cuerpo_mensaje = 'Hola '.$nombre.'. Ha realizado una compra en DVIGI. 
									Los datos de su  compra son los siguientes: 
					</br> Tipo de envío: '.$tipo_envio.'
					</br> Número de pedido: '.$id_pedido.'
					</br> Tipo de factura: '.$tipo_factura.'
					</br> Tipo de entrega: '.$nombre_empresa.' '.$tipo_entrega.'
					</br> Dirección de entrega: calle '.$calle_entrega.' Nro '.$nro_entrega.' Entre '.$entrecalle1_entrega.' y '.$entrecalle2_entrega.' Piso '.$piso_entrega.' Dpto '.$dpto_entrega.'
					</br>'.$cuerpo_mensaje1.'
					</br> COSTO DE ENVÍO: $'.$recargo.'					
					</br> IVA: $'.$iva.'					
					</br> IMPORTE TOTAL: $'.$importe_total.'</p>
					<p> Recibirá el nro. de guía para el seguimiento correspondiente una vez despachada la encomienda.</p>';
		}
		else{
			$cuerpo_mensaje = 'Hola '.$nombre.'. Ha realizado una compra en DVIGI. 
									Los datos de su  compra son los siguientes: 
					</br> Tipo de envío: '.$tipo_envio.'
					</br> Número de pedido: '.$id_pedido.'
					</br> Tipo de factura: '.$tipo_factura.'
										
					</br> IVA: $'.$iva.'					
					</br> IMPORTE TOTAL: $'.$importe_total.'</p>';
		}

		
		//print_r($cuerpo_mensaje);die();
		
		//$this->sendMailGmail($email,$cuerpo_mensaje);
		
		/*if($id_canal ==6){// Mision
			$cli = $this->M_configuracion->pedido_cliente_mision($id_cliente_act);
			$row1 = $cli->row();			
			$pedido_mision = $row1->id_pedido;			
		}else{
			if($id_canal ==4){// Atención

			}
		}*/
		//$this->reporte_venta_pdf($id_pedido1);
		if($revendedor == 'true')	{
			$datos['canal'] = $id_canal;
			$datos['id_actual'] = $id_cliente_act;
			//$this->load->view('lte_header', $datos);
			$this->load->view('exito_rev', $datos);
		}else{
			//$this->obtener_pedidos();
			$datos['canal'] = $id_canal;
			$datos['id_actual'] = $id_cliente_act;
			//$this->load->view('lte_header', $datos);
			$this->load->view('exito', $datos);
			//$this->load->view('lte_footer', $datos);
		}
			
	}
	public function venta_revint()
	{	
		$data = array(
			'mision' 	=> 		0     
		);		
		$this->session->set_userdata($data);

		$cupon_nro = 	$this->input->post('cupon_nro');
		$cupon_promo = 	$this->input->post('cupon_promo');
		$nro_remito = 	$this->input->post('nro_remito');
		$tx_no_acreditada = 0;
		$frm_medio = 	$this->input->post('frm_medio');
			// Cliente
			$forma_pago = 	$this->input->post('id_forma_pago');	 
			$revendedor = $this->input->post('frm_revendedor');
			$nuevo_cliente = $this->input->post('frm_nuevo_cliente');
			$id_cliente_act = $this->input->post('frm_id_cliente');
			$pedido_mision = $this->input->post('frm_pedido_mision');
			$dni = $this->input->post('frm_dni');
			$nombre = $this->input->post('frm_nombre');
			$apellidos = $this->input->post('frm_apellidos');
			$telefono = $this->input->post('frm_telefono');
			$celular = $this->input->post('frm_celular');
			$email = $this->input->post('frm_email');
			$codigo_postal = $this->input->post('frm_codigo_postal');
			$id_municipio = $this->input->post('frm_id_municipio');		 
			$calle = $this->input->post('frm_calle');
			$nro = $this->input->post('frm_nro');
			$piso = $this->input->post('frm_piso');
			$dpto = $this->input->post('frm_dpto');
			$entrecalle1 = $this->input->post('frm_entrecalle1');
			$entrecalle2 = $this->input->post('frm_entrecalle2');
			$fecha_nacimiento = $this->input->post('frm_fecha_nacimiento');
			$observaciones = $this->input->post('frm_observaciones');
			$cuit = $this->input->post('frm_cuit');
			// Venta
			$id_canal = $this->input->post('frm_id_canal');
			//$id_pedido = $this->input->post('id_pedido');
			$no_factura = $this->input->post('frm_factura');
			$id_transaccion = $this->input->post('frm_transaccion');
			$fecha_venta = $this->input->post('frm_fecha');
			$recargo = $this->input->post('frm_recargo');
			$tipo_factura = $this->input->post('frm_id_tipo_factura');
			$calle_entrega = $this->input->post('frm_calle_entrega');
			$nro_entrega = $this->input->post('frm_nro_entrega');
			$piso_entrega = $this->input->post('frm_piso_entrega');
			$dpto_entrega = $this->input->post('frm_dpto_entrega');
			$municipio_entrega = $this->input->post('frm_municipio_entrega');
			$provincia_entrega = $this->input->post('frm_provincia_entrega');
			$entrecalle1_entrega = $this->input->post('frm_entrecalle1_entrega');
			$entrecalle2_entrega = $this->input->post('frm_entrecalle2_entrega');
			$monto_iva = $this->input->post('frm_monto_iva');
			$monto_recargo = $this->input->post('frm_monto_recargo');
			$codigo_postal_entrega=  $this->input->post('frm_codigo_postal_entrega');
			
			$envio_inmediato = 'NO';
			
		$id_envio_oca		= $this->input->post('frm_id_envio_oca');	
		
		$dt_productos		= explode(',',$this->input->post('frm_dtProductos'));
		$dt_campanas		= explode(',',$this->input->post('frm_dtCampanas'));
		$dt_colores			= explode(',',$this->input->post('frm_dtColores'));
		$dt_descuentos		= explode(',',$this->input->post('frm_dtDescuentos'));
		$dt_descuentos_vip	= explode(',',$this->input->post('frm_dtDescuentos_vip'));
		$dt_incrementos		= explode(',',$this->input->post('frm_dtIncrementos'));
		$dt_precios			= explode(',',$this->input->post('frm_dtPrecios'));		
		$dt_cantidades		= explode(',',$this->input->post('frm_dtCantidades'));		
		$total_productos 	= $this->input->post('frm_TotalProductos');
		$dt_alto			= explode(',',$this->input->post('frm_dtAlto'));
		$dt_ancho			= explode(',',$this->input->post('frm_dtAncho'));
		$dt_largo			= explode(',',$this->input->post('frm_dtLargo'));
		$dt_peso			= explode(',',$this->input->post('frm_dtPeso'));
		// si es mision buscar pedido_mision
		if($id_canal ==6){
			$cli = $this->M_configuracion->pedido_cliente_mision($id_cliente_act);
			$row1 = $cli->row();			
			$pedido_mision = $row1->id_pedido;			
		}
			

		// Entrega
			$tipo_envio = $this->input->post('frm_nombre_tipo_envio');		
			$id_empresa = $this->input->post('frm_id_empresa');
			$tipo_empresa = $this->input->post('frm_id_tipo_empresa');
			$id_sucursal = $this->input->post('frm_id_sucursal');
			$operativa = $this->input->post('frm_operativa');
			
			if($tipo_empresa == 1){
			$idci = $id_sucursal;
			}else{
			$idci = "0";
			}
			
			$res = $this->M_operaciones->obtener_parametro('CONSECUTIVO_VENTA');
			$cod = $this->M_operaciones->obtener_parametro('CODIGO_PEDIDO');
			$row = $res->row();
			$row_cod = $cod->row();
			$id_pedido = $row_cod->valor . '-' . $row->valor;
			
		//$resultado=$this->M_configuracion->upd_configuracion('CONSECUTIVO_VENTA',$valor_consecutivo);
			$res = $this->M_operaciones->obtener_parametro('COMISION_ATENCION');
			$row = $res->row();
			$com_atencion = $row->valor_decimal;
		
			$res = $this->M_operaciones->obtener_parametro('COMISION_MISION');
			$row = $res->row();
			$com_mision = $row->valor_decimal;
		
		/*if($recargo == 'SI'){
			$anno=date('Y');
			$mes=date('m');
			$res = $this->M_operaciones->obtener_costo($anno, $mes);
			$row = $res->row();
			$costo = $row->costo;
		}else
			$costo =0;*/
		/*****************Validadion**********************/
		
		$this->load->library('form_validation');	 
		
		$this->form_validation->set_rules('frm_nombre', 'Nombre', 'required');
		$this->form_validation->set_rules('frm_apellidos', 'Apellidos', 'required');
		
		
		$recargo= $monto_recargo;
		if ($this->form_validation->run() == true )
		{
			$registro = $this->M_operaciones->registrar_venta_rev(
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
			);
			$this->notificacion_error = false;
			
			//$id_pedido1 = $this->M_configuracion->obt_id_pedido($id_pedido);
			$id_pedido1 =$registro;
			if( $tipo_envio == "Por tercero"){
				$cfg1 = $this->M_operaciones->obt_conf_envio();
				if ($cfg1)
				{
					$cfg = $cfg1->row();
					$id  = $cfg->id ;   
					$calle_origen = $cfg->calle_origen ;
					$nro_origen = $cfg->nro_origen ; 
					$piso_origen = $cfg->piso_origen ; 
					$depto_origen = $cfg->depto_origen ; 
					$cp_origen = $cfg->cp_origen ; 
					$localidad_origen = $cfg->localidad_origen ; 
					$provincia_origen = $cfg->provincia_origen ;
					$contacto_origen = $cfg->contacto_origen ;
					$email_origen  = $cfg->email_origen ; 
					$solicitante_origen = $cfg->solicitante_origen ; 
					$observaciones_origen = $cfg->observaciones_origen ; 
					$centrocosto_origen = $cfg->centrocosto_origen ; 
					$idfranjahoraria_origen = $cfg->idfranjahoraria_origen ; 
					$idcentroimposicionorigen = $cfg->idcentroimposicionorigen ;
				}

				// crear el xml **********************************************************************
				$oca 	= new Oca($cuit = '30-69511732-5', 71243);
				$centros_x_cp = $oca->getCentrosImposicionPorCP($cp = '$codigo_postal_entrega');
				if(count($centros_x_cp)>0){
					$localidad = $centros_x_cp[0]['Localidad'];
					$provincia = $centros_x_cp[0]['Provincia'];
					
				}else{
					$localidad = 'CAPITAL FEDERAL';
					$provincia = 'CAPITAL FEDERAL';
				}

				$this->load->helper(array('xml','file'));
				//********************** */
				/*if(date('Y-m-d')>='2018-02-08' && date('Y-m-d')<'2018-02-14'){
					$fecha_hoy = '2018-02-14';
				}else*/
					$fecha_hoy = $this->cargar_fecha();
				//****************************** */
				$dom = xml_dom();
				$row = xml_add_child($dom, 'ROWS');
				
				$cabecera = xml_add_child($row, 'cabecera');
				xml_add_attribute($cabecera, 'ver', '2.0');
				xml_add_attribute($cabecera, 'nrocuenta', '142852/000');
				$origenes = xml_add_child($row, 'origenes');
				
				$origen = xml_add_child($origenes, 'origen');		
				xml_add_attribute($origen, 'calle', $calle_origen);
				xml_add_attribute($origen, 'nro', $nro_origen);
				xml_add_attribute($origen, 'piso', $piso_origen);
				xml_add_attribute($origen, 'depto', $depto_origen);
				xml_add_attribute($origen, 'cp', $cp_origen);
				xml_add_attribute($origen, 'localidad', $localidad_origen);
				xml_add_attribute($origen, 'provincia', $provincia_origen);
				xml_add_attribute($origen, 'contacto', $contacto_origen);
				xml_add_attribute($origen, 'email', $email_origen);
				xml_add_attribute($origen, 'solicitante', $solicitante_origen);
				xml_add_attribute($origen, 'observaciones', $observaciones_origen);
				xml_add_attribute($origen, 'centrocosto', $centrocosto_origen);
				xml_add_attribute($origen, 'idfranjahoraria', $idfranjahoraria_origen);
				xml_add_attribute($origen, 'idcentroimposicionorigen', $idcentroimposicionorigen);
				xml_add_attribute($origen, 'fecha', $fecha_hoy);
			
				$envios = xml_add_child($origen, 'envios');
				
				$envio = xml_add_child($envios, 'envio');		
				xml_add_attribute($envio, 'idoperativa', $operativa);
				xml_add_attribute($envio, 'nroremito', $no_factura);

				$destinatario = xml_add_child($envio, 'destinatario');
				xml_add_attribute($destinatario, 'apellido', $apellidos);
				xml_add_attribute($destinatario, 'nombre', $nombre);
				xml_add_attribute($destinatario, 'calle', $calle_entrega);
				xml_add_attribute($destinatario, 'nro', $nro_entrega);
				xml_add_attribute($destinatario, 'piso', $piso_entrega);
				xml_add_attribute($destinatario, 'depto', $dpto_entrega);
				xml_add_attribute($destinatario, 'localidad', $localidad);
				xml_add_attribute($destinatario, 'provincia', $provincia);
				xml_add_attribute($destinatario, 'cp', $codigo_postal_entrega);
				xml_add_attribute($destinatario, 'telefono', $telefono);
				xml_add_attribute($destinatario, 'email', $email);
				xml_add_attribute($destinatario, 'idci', $idci);
				xml_add_attribute($destinatario, 'celular', $celular);
				xml_add_attribute($destinatario, 'observaciones', '');

				$re = $this->M_operaciones->actualizar_envio_oca($id_envio_oca, 
							$id_pedido1, 
							$calle_origen , 
							$nro_origen, 
							$piso_origen, 
							$depto_origen, 
							$cp_origen , 
							$localidad_origen, 
							$provincia_origen , 
							$contacto_origen, 
							$email_origen , 
							$solicitante_origen, 
							$observaciones_origen , 
							$centrocosto_origen, 
							$idfranjahoraria_origen ,
							$idcentroimposicionorigen, 
							$fecha_hoy , 
							$operativa, 
							$no_factura , 
							$apellidos, 
							$nombre, 
							$calle_entrega, 
							$nro_entrega , 
							$piso_entrega, 
							$dpto_entrega , 
							$localidad, 
							$email , 
							$idci, 
							$celular, 
							'', 
							$provincia , 
							$codigo_postal_entrega,
							$telefono);
				$paquetes = xml_add_child($envio, 'paquetes');
				
				$paque1 = $this->M_operaciones->buscar_detalles_envio_oca1($id_envio_oca);
				foreach ($paque1->result() as $pa) {
					$paquete = xml_add_child($paquetes, 'paquete');
					xml_add_attribute($paquete, 'alto', $pa->alto_paquete);
					xml_add_attribute($paquete, 'ancho', $pa->ancho_paquete);
					xml_add_attribute($paquete, 'largo', $pa->largo_paquete);
					xml_add_attribute($paquete, 'peso', $pa->peso);
					xml_add_attribute($paquete, 'valor', $pa->valor);
					xml_add_attribute($paquete, 'cant', $pa->cantidad);
				}
				/*for ($i=0; $i<count($dt_productos); $i++ )
				{
					$paquete = xml_add_child($paquetes, 'paquete');
					xml_add_attribute($paquete, 'alto', $dt_alto[$i]);
					xml_add_attribute($paquete, 'ancho', $dt_ancho[$i]);
					xml_add_attribute($paquete, 'largo', $dt_largo[$i]);
					xml_add_attribute($paquete, 'peso', $dt_peso[$i]);
					xml_add_attribute($paquete, 'valor', $dt_precios[$i]);
					xml_add_attribute($paquete, 'cant', $dt_cantidades[$i]);
				}*/
				/*
				if($envio_inmediato == 'SI'){
					$fichero = './assets/envio.xml';
					if(write_file($fichero, xml_print($dom, $return = TRUE))){
						$this->subir_al_carrito($fichero, $id_pedido1);
					}
				}else{
					// buscar ultimo número de envio almacenado y la primera fecha despues de 3 dias 
					$ultimo_id = $this->M_operaciones->obt_ultimoID();
					$primera_fecha = $this->M_operaciones->obt_primeraFecha();
					
					// almacenar el envio
					$id1 = $ultimo_id + 1;
					$fichero = './assets/envio'.$id1.'.xml';
					if(write_file($fichero, xml_print($dom, $return = TRUE))){
						$res1 = $this->M_operaciones->registrar_carrito( $id1, $id_pedido1, $fecha_venta);
					}	
					$this->subir_a_oca();
					
				}*/
				
			}
			$id_cliente_act =  $this->M_operaciones->buscar_cliente_pedido($id_pedido1);

		}
		/* if($registro){
			echo $registro;
				
			}
				else{
				echo 'fallo';
			}*/
		//Preparar el mensaje a enviar por email.		
		
		$tipo_factura;
		$calle_entrega;
		$nro_entrega;
		$piso_entrega;
		$dpto_entrega;
		$entrecalle1_entrega;
		$entrecalle2_entrega;
		$iva = 0;
		$recargo = 0;
		$tipo_entrega ='';
		$importe = 0;
		$cantidad = 0;
		$productos = "";
		$precio = 0;
		$descuento = 0;
		$importe_total = 0;
		
		$datos_producto_mensaje = '';
		$cuerpo_mensaje2="";
		if($tipo_envio =="Showroom"){		
			
				$detalles_pedido = $this->M_operaciones->obt_detalle_pedido($id_pedido);		
				
				foreach ($detalles_pedido->result() as $pr){						   
				
					$tipo_factura = $pr->tipo_factura;
							/*$calle_entrega = $pr->calle_entrega;
					$nro_entrega = $pr->nro_entrega;
					$piso_entrega = $pr->piso_entrega;
					$dpto_entrega = $pr->dpto_entrega;
					$entrecalle1_entrega = $pr->entrecalle1_entrega;
					$entrecalle2_entrega = $pr->entrecalle2_entrega;*/
					$iva = $pr->iva;
					$recargo = $pr->recargo;
					
					$cantidad = $pr->cantidad;
					$productos = $pr->nombre;
					$precio = $pr->precio;
					$descuento = $pr->descuento;
					$importe = ($cantidad*$precio)-$descuento;
					$importe_total+=$importe;
							
					$datos_producto_mensaje = $datos_producto_mensaje.
						'<ul>
							<li>'.$productos.'</li>
							<li>'.$cantidad.'</li>
							<li>'.$precio.'</li>
							<li>'.$descuento.'</li>
							<li>'.$importe.'</li>
						</ul>';
							
				}
		}else{
			
				$detalles_pedido_terceros = $this->M_operaciones->obt_pedido_tercero2($id_pedido);
				
				$identificador_envio = 0;
				$nombre_empresa = '';
				
				$datos_producto_mensaje = '';
			
				foreach ($detalles_pedido_terceros->result() as $pr){					   
				
					$nombre_empresa = $pr->empresa;
					$tipo_factura = $pr->tipo_factura;
					
					$iva = $pr->iva;
					$recargo = $pr->recargo;
					$tipo_entrega = $pr->tipo_entrega;
					$cantidad = $pr->cantidad;
					$productos = $pr->producto;
					$precio = $pr->precio;
					$descuento = $pr->descuento;
					$importe = ($cantidad*$precio)-$descuento;
					$importe_total+=$importe;
							
					$datos_producto_mensaje = $datos_producto_mensaje.
					'<ul>
						<li>PRODUCTO: '.$productos.'</li>
						<li>CANTIDAD: '.$cantidad.'</li>
						<li>PRECIO: $'.$precio.'</li>
						<li>DESCUENTO: '.$descuento.'%</li>
						<li>IMPORTE: $'.$importe.'</li>
					</ul>';					
			}
			
			$cuerpo_mensaje2 = '
					</br> Empresa: '.$nombre_empresa;
				
		}
			
		//$detalles_pedido = $this->M_operaciones->obt_detalle_pedido($id_pedido);
		
		
			
		$importe_total = $importe_total + $recargo+$iva;
		$cuerpo_mensaje1 = $datos_producto_mensaje;
		if($tipo_envio == "Por tercero"){
			$cuerpo_mensaje = 'Hola '.$nombre.'. Ha realizado una compra en DVIGI. 
									Los datos de su  compra son los siguientes: 
					</br> Tipo de envío: '.$tipo_envio.'
					</br> Número de pedido: '.$id_pedido.'
					</br> Tipo de factura: '.$tipo_factura.'
					</br> Tipo de entrega: '.$nombre_empresa.' '.$tipo_entrega.'
					</br> Dirección de entrega: calle '.$calle_entrega.' Nro '.$nro_entrega.' Entre '.$entrecalle1_entrega.' y '.$entrecalle2_entrega.' Piso '.$piso_entrega.' Dpto '.$dpto_entrega.'
					</br>'.$cuerpo_mensaje1.'
					</br> COSTO DE ENVÍO: $'.$recargo.'					
					</br> IVA: $'.$iva.'					
					</br> IMPORTE TOTAL: $'.$importe_total.'</p>
					<p> Recibirá el nro. de guía para el seguimiento correspondiente una vez despachada la encomienda.</p>';
		}
		else{
			$cuerpo_mensaje = 'Hola '.$nombre.'. Ha realizado una compra en DVIGI. 
									Los datos de su  compra son los siguientes: 
					</br> Tipo de envío: '.$tipo_envio.'
					</br> Número de pedido: '.$id_pedido.'
					</br> Tipo de factura: '.$tipo_factura.'
										
					</br> IVA: $'.$iva.'					
					</br> IMPORTE TOTAL: $'.$importe_total.'</p>';
		}

		
		//print_r($cuerpo_mensaje);die();
		
		//$this->sendMailGmail($email,$cuerpo_mensaje);
		
		/*if($id_canal ==6){// Mision
			$cli = $this->M_configuracion->pedido_cliente_mision($id_cliente_act);
			$row1 = $cli->row();			
			$pedido_mision = $row1->id_pedido;			
		}else{
			if($id_canal ==4){// Atención

			}
		}*/
		//$this->reporte_venta_pdf($id_pedido1);
		if($revendedor == 'true')	{
			$datos['canal'] = $id_canal;
			$datos['id_actual'] = $id_cliente_act;
			//$this->load->view('lte_header', $datos);
			$this->load->view('exito_revint', $datos);
		}else{
			//$this->obtener_pedidos();
			$datos['canal'] = $id_canal;
			$datos['id_actual'] = $id_cliente_act;
			//$this->load->view('lte_header', $datos);
			$this->load->view('exito', $datos);
			//$this->load->view('lte_footer', $datos);
		}
			
	}
	public function obtener_pedidos_rev()
	{
		$fecha = new DateTime();		
		$anno  				= $fecha->format('Y');
		$datos['anno']  	= $anno;
		$mes  				= $fecha->format('m');
		$datos['mes']  		= $mes;
		$user = $this->ion_auth->user()->row();
		$usuario = $user->id;
		$pedidos = $this->M_operaciones->obtener_pedidos_rev($usuario, $anno, $mes);	
		$datos['pedidos'] = $pedidos;		
		$bandera=0;
		
		$id = array();
		$id_pedido = array();
		$no_factura = array();
		$producto = array();
		$color = array();
		$importe = array();
		$cobranza = array();
		$OCA = array();
		$armado = array();
		$despachado = array();
		$recargo = array();
		$iva = array();
		$dni = array();
		$convenir = array();
		$nombre_apellidos = array();
		$fecha = array();
		$acreditado = array();
		$mediopago = array();

		$id_entrega = array();
		$canal = array();
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
					$dni[$contador] = $pr->dni;
					$fecha[$contador] = $pr->fecha_solicitud;
					$acreditado[$contador] = $pr->acreditado;
					$mediopago[$contador] = $pr->id_medio_cobranza;

					$convenir[$contador] = $pr->envio_por_coordinar;
					if($pr->id_canal == 4 || $pr->id_canal == 6){
						$canal[$contador] = 'ATC';
					}else{
						if($pr->id_canal == 21){
							$canal[$contador] = 'ML';
						}else{
							if($pr->id_canal == 22){
								$canal[$contador] = 'MS';
							}else{
								$canal[$contador] = 'ND';
							}
						}
					}

					$nombre_apellidos[$contador] = $pr->nombre.' '.$pr->apellidos;					
				}else{//es el mismo pedido
					$producto[$contador] = $producto[$contador]. $pr->producto.' '.$pr->color.'</br>';
					$importe[$contador] = $importe[$contador] + $pr->importe;
				}
			}else{//es otro pedido
				$contador = $contador + 1;
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
				$dni[$contador] = $pr->dni;
				$fecha[$contador] = $pr->fecha_solicitud;
				$acreditado[$contador] = $pr->acreditado;
				$mediopago[$contador] = $pr->id_medio_cobranza;
				$convenir[$contador] = $pr->envio_por_coordinar;
				if($pr->id_canal == 4 || $pr->id_canal == 6){
						$canal[$contador] = 'ATC';
					}else{
						if($pr->id_canal == 21){
							$canal[$contador] = 'ML';
						}else{
							if($pr->id_canal == 22){
								$canal[$contador] = 'MS';
							}else{
								$canal[$contador] = 'ND';
							}
						}
					}
				$nombre_apellidos[$contador] = $pr->nombre.' '.$pr->apellidos;
				//Sumo el recargo
				$importe[$contador-1] = $importe[$contador-1]+$recargo[$contador-1]+$iva[$contador-1]; 
			}
			$anterior=$pr->no_factura;
		}
		if($bandera == 1 )							
			$importe[$contador] = $importe[$contador]+$recargo[$contador]+$iva[$contador]; 						
		
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
		$datos['convenir'] 			=$convenir;
		$datos['nombre_apellidos'] 	=$nombre_apellidos;
		$datos['canal'] 			=$canal;
		$datos['fecha'] 			=$fecha;
		$datos['acreditado'] 		=$acreditado;
		$datos['mediopago'] 		=$mediopago;
		$annos = $this->M_configuracion->obt_annos();
		$meses = $this->M_configuracion->obt_meses();
		
		$datos['annos']  	= $annos;
		$datos['meses']  	= $meses;
		
		
		$this->load->view('lte_header', $datos);
		$this->load->view('v_listado_pedidos_gestion_rev', $datos);
		$this->load->view('lte_footer', $datos);
		
	}
	public function obtener_pedidos_revint()
	{
		$fecha = new DateTime();		
		$anno  				= $fecha->format('Y');
		$datos['anno']  	= $anno;
		$mes  				= $fecha->format('m');
		$datos['mes']  		= $mes;
		$user = $this->ion_auth->user()->row();
		$usuario = $user->id;
		$pedidos = $this->M_operaciones->obtener_pedidos_rev($usuario, $anno, $mes);	
		$datos['pedidos'] = $pedidos;		
		$bandera=0;
		
		$id = array();
		$id_pedido = array();
		$no_factura = array();
		$producto = array();
		$color = array();
		$importe = array();
		$cobranza = array();
		$OCA = array();
		$armado = array();
		$despachado = array();
		$recargo = array();
		$iva = array();
		$dni = array();
		$convenir = array();
		$nombre_apellidos = array();
		$fecha = array();
		$acreditado = array();
		$mediopago = array();

		$id_entrega = array();
		$canal = array();
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
					$dni[$contador] = $pr->dni;
					$fecha[$contador] = $pr->fecha_solicitud;
					$acreditado[$contador] = $pr->acreditado;
					$mediopago[$contador] = $pr->id_medio_cobranza;

					$convenir[$contador] = $pr->envio_por_coordinar;
					if($pr->id_canal == 4 || $pr->id_canal == 6){
						$canal[$contador] = 'ATC';
					}else{
						if($pr->id_canal == 21){
							$canal[$contador] = 'ML';
						}else{
							if($pr->id_canal == 22){
								$canal[$contador] = 'MS';
							}else{
								$canal[$contador] = 'ND';
							}
						}
					}

					$nombre_apellidos[$contador] = $pr->nombre.' '.$pr->apellidos;					
				}else{//es el mismo pedido
					$producto[$contador] = $producto[$contador]. $pr->producto.' '.$pr->color.'</br>';
					$importe[$contador] = $importe[$contador] + $pr->importe;
				}
			}else{//es otro pedido
				$contador = $contador + 1;
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
				$dni[$contador] = $pr->dni;
				$fecha[$contador] = $pr->fecha_solicitud;
				$acreditado[$contador] = $pr->acreditado;
				$mediopago[$contador] = $pr->id_medio_cobranza;
				$convenir[$contador] = $pr->envio_por_coordinar;
				if($pr->id_canal == 4 || $pr->id_canal == 6){
						$canal[$contador] = 'ATC';
					}else{
						if($pr->id_canal == 21){
							$canal[$contador] = 'ML';
						}else{
							if($pr->id_canal == 22){
								$canal[$contador] = 'MS';
							}else{
								$canal[$contador] = 'ND';
							}
						}
					}
				$nombre_apellidos[$contador] = $pr->nombre.' '.$pr->apellidos;
				//Sumo el recargo
				$importe[$contador-1] = $importe[$contador-1]+$recargo[$contador-1]+$iva[$contador-1]; 
			}
			$anterior=$pr->no_factura;
		}
		if($bandera == 1 )							
			$importe[$contador] = $importe[$contador]+$recargo[$contador]+$iva[$contador]; 						
		
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
		$datos['convenir'] 			=$convenir;
		$datos['nombre_apellidos'] 	=$nombre_apellidos;
		$datos['canal'] 			=$canal;
		$datos['fecha'] 			=$fecha;
		$datos['acreditado'] 		=$acreditado;
		$datos['mediopago'] 		=$mediopago;
		$annos = $this->M_configuracion->obt_annos();
		$meses = $this->M_configuracion->obt_meses();
		
		$datos['annos']  	= $annos;
		$datos['meses']  	= $meses;
		
		
		$this->load->view('lte_header', $datos);
		$this->load->view('v_listado_pedidos_gestion_revint', $datos);
		$this->load->view('lte_footer', $datos);
		
	}
	public function obtener_pedidos_rev_filtrado()
	{
		$anno = $this->input->post('anno'); 
		$mes = $this->input->post('mes');
		$datos['anno']  	= $anno;		
		$datos['mes']  		= $mes;
		$user = $this->ion_auth->user()->row();
		$usuario = $user->id;
		$pedidos = $this->M_operaciones->obtener_pedidos_rev($usuario, $anno, $mes);
		$datos['pedidos'] = $pedidos;		
		$bandera=0;
		
		$id = array();
		$id_pedido = array();
		$id_entrega = array();
		$no_factura = array();
		$producto = array();
		$color = array();
		$importe = array();
		$cobranza = array();
		$OCA = array();
		$armado = array();
		$despachado = array();
		$recargo = array();
		$iva = array();
		$dni = array();
		$convenir = array();
		$nombre_apellidos = array();
		$fecha = array();
		$acreditado = array();
		$mediopago = array();
		
		$canal = array();
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
					$dni[$contador] = $pr->dni;
					$convenir[$contador] = $pr->envio_por_coordinar;
					$fecha[$contador] = $pr->fecha_solicitud;
					$acreditado[$contador] = $pr->acreditado;
					$mediopago[$contador] = $pr->id_medio_cobranza;
					if($pr->id_canal == 4 || $pr->id_canal == 6){
						$canal[$contador] = 'ATC';
					}else{
						if($pr->id_canal == 21){
							$canal[$contador] = 'ML';
						}else{
							if($pr->id_canal == 22){
								$canal[$contador] = 'MS';
							}else{
								$canal[$contador] = 'ND';
							}
						}
					}
					$nombre_apellidos[$contador] = $pr->nombre.' '.$pr->apellidos;					
				}else{//es el mismo pedido
					$producto[$contador] = $producto[$contador]. $pr->producto.' '.$pr->color.'</br>';
					$importe[$contador] = $importe[$contador] + $pr->importe;
				}
			}else{//es otro pedido
				$contador = $contador + 1;
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
				$dni[$contador] = $pr->dni;
				$convenir[$contador] = $pr->envio_por_coordinar;
				$nombre_apellidos[$contador] = $pr->nombre.' '.$pr->apellidos;
				$fecha[$contador] = $pr->fecha_solicitud;
				$acreditado[$contador] = $pr->acreditado;
				$mediopago[$contador] = $pr->id_medio_cobranza;
				if($pr->id_canal == 4 || $pr->id_canal == 6){
						$canal[$contador] = 'ATC';
					}else{
						if($pr->id_canal == 21){
							$canal[$contador] = 'ML';
						}else{
							if($pr->id_canal == 22){
								$canal[$contador] = 'MS';
							}else{
								$canal[$contador] = 'ND';
							}
						}
					}
				//Sumo el recargo
				$importe[$contador-1] = $importe[$contador-1]+$recargo[$contador-1]+$iva[$contador-1]; 
			}
			$anterior=$pr->no_factura;
		}
		if($bandera == 1 )							
			$importe[$contador] = $importe[$contador]+$recargo[$contador]+$iva[$contador]; 						
		
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
		$datos['convenir'] 			=$convenir;
		$datos['nombre_apellidos'] 	=$nombre_apellidos;
		$datos['canal'] 			=$canal;
		$datos['fecha'] 			=$fecha;
		$datos['acreditado'] 		=$acreditado;
		$datos['mediopago'] 		=$mediopago;
		$annos = $this->M_configuracion->obt_annos();
		$meses = $this->M_configuracion->obt_meses();
		
		$datos['annos']  	= $annos;
		$datos['meses']  	= $meses;
		
		
		$this->load->view('lte_header', $datos);
		$this->load->view('v_listado_pedidos_gestion_rev', $datos);
		$this->load->view('lte_footer', $datos);
		
	}
	public function obtener_pedidos_rev_filtrado_nombre()
	{
		$fnombre = $this->input->post('fnombre');
		$fnombre = trim($fnombre);
		$anno = $this->input->post('anno'); 
		$mes = $this->input->post('mes');
		$datos['anno']  	= $anno;		
		$datos['mes']  		= $mes;
		$user = $this->ion_auth->user()->row();
		$usuario = $user->id;
		$pedidos = $this->M_operaciones->obtener_pedidos_rev_nombre($usuario, $fnombre);
		$datos['pedidos'] = $pedidos;		
		$bandera=0;
		
		$id = array();
		$id_pedido = array();
		$id_entrega = array();
		$no_factura = array();
		$producto = array();
		$color = array();
		$importe = array();
		$cobranza = array();
		$OCA = array();
		$armado = array();
		$despachado = array();
		$recargo = array();
		$iva = array();
		$dni = array();
		$convenir = array();
		$nombre_apellidos = array();
		$fecha = array();
		$acreditado = array();
		$mediopago = array();
		
		$canal = array();
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
					$dni[$contador] = $pr->dni;
					$convenir[$contador] = $pr->envio_por_coordinar;
					$fecha[$contador] = $pr->fecha_solicitud;
					$acreditado[$contador] = $pr->acreditado;
					$mediopago[$contador] = $pr->id_medio_cobranza;
					if($pr->id_canal == 4 || $pr->id_canal == 6){
						$canal[$contador] = 'ATC';
					}else{
						if($pr->id_canal == 21){
							$canal[$contador] = 'ML';
						}else{
							if($pr->id_canal == 22){
								$canal[$contador] = 'MS';
							}else{
								$canal[$contador] = 'ND';
							}
						}
					}
					$nombre_apellidos[$contador] = $pr->nombre.' '.$pr->apellidos;					
				}else{//es el mismo pedido
					$producto[$contador] = $producto[$contador]. $pr->producto.' '.$pr->color.'</br>';
					$importe[$contador] = $importe[$contador] + $pr->importe;
				}
			}else{//es otro pedido
				$contador = $contador + 1;
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
				$dni[$contador] = $pr->dni;
				$convenir[$contador] = $pr->envio_por_coordinar;
				$nombre_apellidos[$contador] = $pr->nombre.' '.$pr->apellidos;
				$fecha[$contador] = $pr->fecha_solicitud;
				$acreditado[$contador] = $pr->acreditado;
				$mediopago[$contador] = $pr->id_medio_cobranza;
				if($pr->id_canal == 4 || $pr->id_canal == 6){
						$canal[$contador] = 'ATC';
					}else{
						if($pr->id_canal == 21){
							$canal[$contador] = 'ML';
						}else{
							if($pr->id_canal == 22){
								$canal[$contador] = 'MS';
							}else{
								$canal[$contador] = 'ND';
							}
						}
					}
				//Sumo el recargo
				$importe[$contador-1] = $importe[$contador-1]+$recargo[$contador-1]+$iva[$contador-1]; 
			}
			$anterior=$pr->no_factura;
		}
		if($bandera == 1 )							
			$importe[$contador] = $importe[$contador]+$recargo[$contador]+$iva[$contador]; 						
		
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
		$datos['convenir'] 			=$convenir;
		$datos['nombre_apellidos'] 	=$nombre_apellidos;
		$datos['canal'] 			=$canal;
		$datos['fecha'] 			=$fecha;
		$datos['acreditado'] 		=$acreditado;
		$datos['mediopago'] 		=$mediopago;
		$annos = $this->M_configuracion->obt_annos();
		$meses = $this->M_configuracion->obt_meses();
		
		$datos['annos']  	= $annos;
		$datos['meses']  	= $meses;
		
		
		$this->load->view('lte_header', $datos);
		$this->load->view('v_listado_pedidos_gestion_rev', $datos);
		$this->load->view('lte_footer', $datos);
		
	}
	//Mostrar pedidos ok
	public function obtener_pedidos_rev_filtrado_ok()
	{
		$fecha = new DateTime();		
		$anno  				= $this->input->post('anno1');
		$datos['anno']  	= $anno;
		$mes  				= $this->input->post('mes1');
		$datos['mes']  		= $mes;
		$user = $this->ion_auth->user()->row();
		$usuario = $user->id;
		$pedidos = $this->M_operaciones->obtener_pedidos_rev_ok($usuario,$anno, $mes);	
		$datos['pedidos'] = $pedidos;		
		$bandera=0;
		
		$id = array();
		$id_pedido = array();
		$id_entrega = array();
		$no_factura = array();
		$producto = array();
		$color = array();
		$importe = array();
		$cobranza = array();
		$OCA = array();
		$armado = array();
		$despachado = array();
		$recargo = array();
		$iva = array();
		$dni = array();
		$convenir = array();
		$nombre_apellidos = array();
		$fecha = array();
		$acreditado = array();
		$mediopago = array();

		$canal = array();
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
					$dni[$contador] = $pr->dni;
					$convenir[$contador] = $pr->envio_por_coordinar;
					$nombre_apellidos[$contador] = $pr->nombre.' '.$pr->apellidos;	
					$fecha[$contador] = $pr->fecha_solicitud;
					$acreditado[$contador] = $pr->acreditado;
					$mediopago[$contador] = $pr->id_medio_cobranza;

					if($pr->id_canal == 4 || $pr->id_canal == 6){
						$canal[$contador] = 'ATC';
					}else{
						if($pr->id_canal == 21){
							$canal[$contador] = 'ML';
						}else{
							if($pr->id_canal == 22){
								$canal[$contador] = 'MS';
							}else{
								$canal[$contador] = 'ND';
							}
						}
					}					
				}else{//es el mismo pedido
					$producto[$contador] = $producto[$contador]. $pr->producto.' '.$pr->color.'</br>';
					$importe[$contador] = $importe[$contador] + $pr->importe;
				}
			}else{//es otro pedido
				$contador = $contador + 1;
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
				$dni[$contador] = $pr->dni;
				$convenir[$contador] = $pr->envio_por_coordinar;
				$nombre_apellidos[$contador] = $pr->nombre.' '.$pr->apellidos;
				$fecha[$contador] = $pr->fecha_solicitud;
				$acreditado[$contador] = $pr->acreditado;
				$mediopago[$contador] = $pr->id_medio_cobranza;
				if($pr->id_canal == 4 || $pr->id_canal == 6){
						$canal[$contador] = 'ATC';
					}else{
						if($pr->id_canal == 21){
							$canal[$contador] = 'ML';
						}else{
							if($pr->id_canal == 22){
								$canal[$contador] = 'MS';
							}else{
								$canal[$contador] = 'ND';
							}
						}
					}
				//Sumo el recargo
				$importe[$contador-1] = $importe[$contador-1]+$recargo[$contador-1]+$iva[$contador-1]; 
			}
			$anterior=$pr->no_factura;
		}
		if($bandera == 1 )							
			$importe[$contador] = $importe[$contador]+$recargo[$contador]+$iva[$contador]; 						
		
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
		$datos['convenir'] 			=$convenir;
		$datos['nombre_apellidos'] 	=$nombre_apellidos;
		$datos['canal'] 			=$canal;
		$datos['fecha'] 			=$fecha;
		$datos['acreditado'] 		=$acreditado;
		$datos['mediopago'] 		=$mediopago;
		$annos = $this->M_configuracion->obt_annos();
		$meses = $this->M_configuracion->obt_meses();
		
		$datos['annos']  	= $annos;
		$datos['meses']  	= $meses;
		
		
		$this->load->view('lte_header', $datos);
		$this->load->view('v_listado_pedidos_gestion_rev', $datos);
		$this->load->view('lte_footer', $datos);
		
	}
	public function obt_mision_seguimiento_rev($mision)
	{
		$mision_seguimiento			= $this->M_operaciones->obt_mision_seguimiento($mision);	
        $datos['misiones'] 			= $mision_seguimiento;
		$total_mision 				= $this->M_operaciones->total_mision_seguimiento($mision);	
        $datos['total_mision'] 		= $total_mision;
        
		$this->load->view('lte_header', $datos);
		$this->load->view('v_listado_mision_seguimiento_rev', $datos);
		$this->load->view('lte_footer', $datos);

	}
	public function cobrado_rev($id_pedido){
		$registrado = $this->M_configuracion->cobrado_rev($id_pedido);
		$this->obtener_pedidos_rev();
	}
	public function entregado_rev($id_entrega){
		$registrado = $this->M_configuracion->entregado_rev($id_entrega);
		$this->obtener_pedidos_rev();
	}
	public function cobrado_revint(){
		$id_pedido= $this->input->post('id_producto1');
		$registrado = $this->M_configuracion->cobrado_rev($id_pedido);
		$this->obtener_pedidos_revint();
	}
	public function entregado_revint(){
		$id_entrega= $this->input->post('id_producto2');
		$registrado = $this->M_configuracion->entregado_rev($id_entrega);
		$this->obtener_pedidos_revint();
	}
	public function modificar_envio(){
		$id_pedido_actual  				= $this->input->post('id_pedido');
		$id_envio  				= $this->input->post('id_envio');
		$nro_envio  				= $this->input->post('nro_envio');
		$registrado = $this->M_operaciones->modificar_envio($id_pedido_actual,  $id_envio, $nro_envio);
		redirect('dashboard_armador_desp');
	}
	public function modificar_envio1(){
		$id_pedido 		= $this->input->post('id_pedido_recarga');
		
		$this->ejecutar_recarga($id_pedido);
		//$registrado = $this->M_operaciones->modificar_envio($id_pedido_actual,  $id_envio, $nro_envio);
		//$resu = $this->M_operaciones->resetear_armado_despacho($id_pedido_actual);
		redirect('dashboard_armador_desp');
	}
	public function obt_evaluacion(){
		$id_pedido_actual  				= $this->input->post('id_pedido');
		$id_envio  				= $this->input->post('id_envio');
		$registrado = $this->M_operaciones->modificar_envio($id_pedido_actual,  $id_envio);

		$this->load->view('lte_header', $datos);
		$this->load->view('v_listado_valaluacion', $datos);
		$this->load->view('lte_footer', $datos);
	}
	public function solicitar_productos_desafio()
	{
		$id_producto  	= $this->input->post('id_producto');
		$producto  		= $this->input->post('producto');
		$cant_min  		= $this->input->post('cant_min');
		
		$por_descuento  = $this->input->post('por_descuento');
		//$datos['id_producto'] 	= $id_producto;
		//$datos['producto'] 		= $producto;
		$datos['importe_min'] 		= $cant_min;
		$datos['cant_min'] 		= 0;
		$datos['por_descuento'] = $por_descuento;

		$user = $this->ion_auth->user()->row();
		$id_usuario = $user->id;
		$email_user = $user->email;
		$datos['email_user'] 	= $email_user;
		$consultorRV = $this->M_configuracion->obt_datos_revendedor($id_usuario);
		$datos['consultorRV']	= $consultorRV;
		$provincias 			= $this->M_operaciones->provincias();
		$datos['provincias'] 	= $provincias;
		$resultado = $this->M_configuracion->obt_paises();
		$datos['paises'] = $resultado;
		$tipos_factura 			= $this->M_operaciones->tipos_factura();
		
		$productos 				= $this->M_operaciones->productos_rev();
		$datos['productos'] 	= $productos;
		$combos 				= $this->M_operaciones->combos();
		$datos['combos'] 		= $combos;
		$anno=date('Y');
		$mes=date('m');
		$iva =0;
		$res = $this->M_configuracion->obtener_iva($anno, $mes);
		
		$row = $res->row();
		if($row != ''){
			$iva = $row->iva;
		}
		$user = $this->ion_auth->user()->row();		
		$id_usuario = $user->id;					
		
		$group = array('ConsultorRVInt'); 
		if ($this->ion_auth->in_group($group)){
			
			$id_pais = $this->M_operaciones->obt_rev_pais($id_usuario);
			$iva = $this->M_operaciones->obt_rev_int_iva($id_pais);
			$tipos_factura 	= $this->M_operaciones->obt_rev_int_facturas($id_pais);
		}
		$datos['tipos_factura'] = $tipos_factura;
		$datos['iva'] 	= $iva;
		$datos['forma_pagos']		= $this->M_operaciones->obt_formas_pago_rev();
		$datos['medio_cobros']		= $this->M_operaciones->obt_medio_cobro_rev();
		$consecutivo 			= 'ORD-' . $this->obtener_parametro('ORDEN_REVENDEDOR');
		$datos['consecutivo'] 	= $consecutivo;
		$this->load->view('lte_header', $datos);
 	    $this->load->view('orden_compra_desafio', $datos);
	    $this->load->view('lte_footer', $datos);
	}
	
	public function solicitar_productos(){
		$user = $this->ion_auth->user()->row();
		$id_usuario = $user->id;
		$email_user = $user->email;
		$datos['email_user'] 	= $email_user;
		$consultorRV = $this->M_configuracion->obt_datos_revendedor($id_usuario);
		$consultorRV1 = $this->M_operaciones->cargar_perfil($id_usuario);

		$datos['consultorRV']	= $consultorRV;
		$datos['consultorRV1']	= $consultorRV1;
		$provincias 			= $this->M_operaciones->provincias();
		$datos['provincias'] 	= $provincias;
		$resultado = $this->M_configuracion->obt_paises();
		$datos['paises'] = $resultado;
		$tipos_factura 			= $this->M_operaciones->tipos_factura();
		$res = $this->M_operaciones->obtener_parametro('TASA_EFECTIVA');
		$row = $res->row();
		$tasa_efectiva = $row->valor_decimal;
		$datos['tasa_efectiva'] = $tasa_efectiva; 
		$productos 				= $this->M_operaciones->productos_rev();
		$datos['productos'] 	= $productos;
		$combos 				= $this->M_operaciones->combos();
		$datos['combos'] 		= $combos;
		$anno=date('Y');
		$mes=date('m');
		$iva =0;
		$res = $this->M_configuracion->obtener_iva($anno, $mes);
		
		$row = $res->row();
		if($row != ''){
			$iva = $row->iva;
		}
		$user = $this->ion_auth->user()->row();		
		$id_usuario = $user->id;
		
		$group = array('ConsultorRVInt'); 
		if ($this->ion_auth->in_group($group)){
			
			$id_pais = $this->M_operaciones->obt_rev_pais($id_usuario);
			$iva = $this->M_operaciones->obt_rev_int_iva($id_pais);
			$tipos_factura 	= $this->M_operaciones->obt_rev_int_facturas($id_pais);
		}
		$datos['tipos_factura'] = $tipos_factura;
		$datos['iva'] 	= $iva;
		$datos['forma_pagos']		= $this->M_operaciones->obt_formas_pago_rev();
		$datos['medio_cobros']		= $this->M_operaciones->obt_medio_cobro_rev();
		$consecutivo 			= 'ORD-' . $this->obtener_parametro('ORDEN_REVENDEDOR');
		$datos['consecutivo'] 	= $consecutivo;
		$this->load->view('lte_header', $datos);
 	    $this->load->view('orden_compra', $datos);
	    $this->load->view('lte_footer', $datos);
	}
	public function solicitar_productosint(){
		$user = $this->ion_auth->user()->row();
		$id_usuario = $user->id;
		$email_user = $user->email;
		$datos['email_user'] 	= $email_user;
		$consultorRV = $this->M_configuracion->obt_datos_revendedor($id_usuario);
		$consultorRV1 = $this->M_operaciones->cargar_perfil($id_usuario);

		$datos['consultorRV']	= $consultorRV;
		$datos['consultorRV1']	= $consultorRV1;
		$provincias 			= $this->M_operaciones->provincias();
		$datos['provincias'] 	= $provincias;
		$resultado = $this->M_configuracion->obt_paises();
		$datos['paises'] = $resultado;
		$tipos_factura 			= $this->M_operaciones->tipos_factura();
		$res = $this->M_operaciones->obtener_parametro('TASA_EFECTIVA');
		$row = $res->row();
		$tasa_efectiva = $row->valor_decimal;
		$datos['tasa_efectiva'] = $tasa_efectiva; 
		$productos 				= $this->M_operaciones->productos_rev();
		$datos['productos'] 	= $productos;
		$combos 				= $this->M_operaciones->combos();
		$datos['combos'] 		= $combos;
		$anno=date('Y');
		$mes=date('m');
		$iva =0;
		$res = $this->M_configuracion->obtener_iva($anno, $mes);
		
		$row = $res->row();
		if($row != ''){
			$iva = $row->iva;
		}
		$user = $this->ion_auth->user()->row();		
		$id_usuario = $user->id;
		
		$group = array('ConsultorRVInt'); 
		if ($this->ion_auth->in_group($group)){
			
			$id_pais = $this->M_operaciones->obt_rev_pais($id_usuario);
			$iva = $this->M_operaciones->obt_rev_int_iva($id_pais);
			$tipos_factura 	= $this->M_operaciones->obt_rev_int_facturas($id_pais);
		}
		$datos['tipos_factura'] = $tipos_factura;
		$datos['iva'] 	= $iva;
		$datos['forma_pagos']		= $this->M_operaciones->obt_formas_pago_rev();
		$datos['medio_cobros']		= $this->M_operaciones->obt_medio_cobro_rev();
		$consecutivo 			= 'ORD-' . $this->obtener_parametro('ORDEN_REVENDEDOR');
		$datos['consecutivo'] 	= $consecutivo;
		$this->load->view('lte_header', $datos);
 	    $this->load->view('orden_compraint', $datos);
	    $this->load->view('lte_footer', $datos);
	}
	public function agregar_orden(){
		$forma_pago 			= 	$this->input->post('forma_pago');	 
		$tipo_envio 			= 	$this->input->post('nombre_tipo_envio');	 
		
		$lugar_entrega 			= 	$this->input->post('nombre_lugar_entrega');	 
		$nombre_terminal 		= 	$this->input->post('nombre_terminal');	 
		$municipio_terminal 	= 	$this->input->post('municipio_terminal');	 
		$codigo_postal_terminal = 	$this->input->post('codigo_postal_terminal');	 
		$provincia_terminal = 	$this->input->post('provincia_terminal');	 
		
		$nuevo_cliente 			= $this->input->post('nuevo_cliente');
		$id_cliente_act 		= $this->input->post('id_cliente');
		$dni 					= $this->input->post('dni');
		$nombre 				= $this->input->post('nombre');
		$apellidos 				= $this->input->post('apellidos');
		$telefono 				= $this->input->post('telefono');
		$celular 				= $this->input->post('celular');
		//$celular0 				= $this->input->post('celular0');
		//$celular1 				= $this->input->post('celular1');
		$email 					= $this->input->post('email');
		$codigo_postal 			= $this->input->post('codigo_postal');
		$id_municipio 			= $this->input->post('sel_municipios');		 
		$calle 					= $this->input->post('calle');
		$nro 					= $this->input->post('nro');
		$piso 					= $this->input->post('piso');
		$dpto 					= $this->input->post('dpto');
		$entrecalle1 			= $this->input->post('entrecalle1');
		$entrecalle2 			= $this->input->post('entrecalle2');
		$fecha_nacimiento 		= $this->input->post('fecha_nacimiento');
		$observaciones 			= $this->input->post('notas');
		$cuit 					= $this->input->post('cuit');
		$id_local 				= $this->input->post('id_local');
		$nombre_local 			= $this->input->post('nombre_local');
		$frm_medio 				= 	$this->input->post('frm_medio');
		$financiamiento			= 	$this->input->post('ckfinanciamiento');
		$tbMontoFinanciamiento	= 	$this->input->post('tbMonto');

		$tbNoTarjeta	= 	$this->input->post('tbNoTarjeta');
		$tbNombre		= 	$this->input->post('tbNombre');
		$tbDni			= 	$this->input->post('tbDni');
		$tbMes			= 	$this->input->post('tbMes');
		$tbAnno			= 	$this->input->post('tbAnno');
		$tbCodigo		= 	$this->input->post('tbCodigo');


		if ($forma_pago == 3 || $forma_pago == 4 || $financiamiento) {
			# code...
			
			$nombres = $nombre.' '.$apellidos; 
			$mensaje = "<p><strong><em>Hola $nombres;</em></strong><br>
			<strong><em><br>
			  Queremos informarte que estos son los datos de la empresa para que pueda realizar su pago.</em></strong><br>
			<strong><em><br>
				Banco Santander Río</br>
				Cuenta corriente en Pesos</br>
				Nro. 084-7257/7</br>
				Titular: Dvigi S.A.</br>
				Cuit: 30-69511732-5</br>
				CBU: 07200847 20000000725772</br>
				Suc. San Isidro - Bs As</br></br></br>
			  Cualquier consulta, podrás llamar a nuestro equipo de Atención al Cliente  marcando +54 1165549839  o escribirnos a&nbsp;</em></strong><a href='mailto:ventas@dvigi.com.ar' target='_blank'><strong><em>ventas@dvigi.com.ar</em></strong></a><strong><em><br>
				Saludos.</em></strong></p>
		  <p><strong><em>&quot;Disfrutá de  agua pura todos los días con DVIGI&quot;</em></strong></p>";

			$this->sendMailMandril($email,'Notificaciones DVIGI', $mensaje);
		}

		if($financiamiento){
			$financiamiento = 1;
		}else{
			$financiamiento = 0;
		}
		/*if($celular0 !='' && $celular1 != ''){
			$celular = $celular0.$celular1;
		}*/
		// Venta
		$id_canal = 13;
		//$id_pedido = $this->input->post('id_pedido');
		$no_factura 			= $this->input->post('frm_factura');		
		$id_transaccion 		= 'ORD-' . $this->obtener_parametro('ORDEN_REVENDEDOR');
		$fecha_venta 			= $this->input->post('fecha');
		//$recargo = $this->input->post('frm_recargo');
		$tipo_factura 			= $this->input->post('id_tipo_factura');
		$calle_entrega 			= $this->input->post('calle_entrega');
		$nro_entrega 			= $this->input->post('nro_entrega');
		$piso_entrega 			= $this->input->post('piso_entrega');
		$dpto_entrega 			= $this->input->post('dpto_entrega');
		$municipio_entrega 		= $this->input->post('municipio_entrega');
		$provincia_entrega 		= $this->input->post('provincia_entrega');		
		$entrecalle1_entrega 	= $this->input->post('entrecalle1_entrega');
		$entrecalle2_entrega 	= $this->input->post('entrecalle2_entrega');
		$monto_iva 				= $this->input->post('monto_iva');
		//$monto_recargo = $this->input->post('frm_monto_recargo');
		$codigo_postal_entrega	=  $this->input->post('codigo_postal_entrega');
		
		//$envio_inmediato = 'SI';
		   
	  // $id_envio_oca		= $this->input->post('frm_id_envio_oca');	
	   
	   $dt_productos		= explode(',',$this->input->post('frm_dtProductos'));
	   //$dt_campanas		= explode(',',$this->input->post('frm_dtCampanas'));
	   $dt_colores			= explode(',',$this->input->post('frm_dtColores'));
	   $dt_descuentos		= explode(',',$this->input->post('frm_dtDescuentos'));
	   $dt_notas			= explode(',',$this->input->post('frm_dtNotas'));
	   //$dt_descuentos_vip	= explode(',',$this->input->post('frm_dtDescuentos_vip'));
	   $dt_incrementos		= explode(',',$this->input->post('frm_dtIncrementos'));
	   $dt_precios			= explode(',',$this->input->post('frm_dtPrecios'));		
	   $dt_cantidades		= explode(',',$this->input->post('frm_dtCantidades'));		
	   $total_productos 	= $this->input->post('frm_TotalProductos');
	   $dt_alto				= explode(',',$this->input->post('frm_dtAlto'));
	   $dt_ancho			= explode(',',$this->input->post('frm_dtAncho'));
	   $dt_largo			= explode(',',$this->input->post('frm_dtLargo'));
	   $dt_peso				= explode(',',$this->input->post('frm_dtPeso'));
	   $dt_combo			= explode(',',$this->input->post('frm_dtEsCombo'));

	   $registro = $this->M_operaciones->registrar_orden(
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
		);

		$tbNoTarjeta_enc	= 	encrypt($tbNoTarjeta, 'AGKJIU324KHGG4587KJ43243FD99979');
		$tbNombre_enc		= 	encrypt($tbNombre, 'AGKJIU324KHGG4587KJ43243FD99979');
		$tbCodigo_enc		= 	encrypt($tbCodigo, 'AGKJIU324KHGG4587KJ43243FD99979');
		

		$id_orden = $registro;
		if($frm_medio != 0){
			$tarj = $this->M_operaciones->guardar_tarjeta($id_orden, $tbNoTarjeta_enc, $tbNombre_enc, $tbDni, $tbMes, $tbAnno, $tbCodigo_enc);
		}
		$resu = $this->M_operaciones->guardar_estado_orden($id_orden,2,'Solicitud de orden de compra');
		$estado_orden = 'Control de Políticas Comerciales y precios';
		$nombres = $nombre.' '.$apellidos;
		$mensaje = "<p><strong><em>Hola $nombres;</em></strong><br>
			<strong><em><br>
			  Queremos informarte que tu pedido ha sido guardado correctamente en el día de la  $fecha_venta.&nbsp; y a través de esta vía lo mantendremos informado del estado de su pedido. Ahora su pedido esta en $estado_orden.</em></strong><br>
			<strong><em><br>
			  Cualquier consulta, podrás llamar a nuestro equipo de Atención al Cliente  marcando +54 1165549839  o escribirnos a&nbsp;</em></strong><a href='mailto:ventas@dvigi.com.ar' target='_blank'><strong><em>ventas@dvigi.com.ar</em></strong></a><strong><em><br>
				Saludos.</em></strong></p>
		  <p><strong><em>&quot;Disfrutá de  agua pura todos los días con DVIGI&quot;</em></strong></p>";

			$this->sendMailMandril($email,'Notificaciones DVIGI', $mensaje);
			$datos_jefe= $this->M_operaciones->miembrosgrupos('Revendedores');
			foreach ($datos_jefe->result() as $key) {
				
				$this->sendMailMandril($key->email,'Notificaciones DVIGI', $mensaje);
			}
			
		    $this->obt_ordenes();
	
	
	}
	public function agregar_ordenint(){
		$forma_pago 			= 	$this->input->post('forma_pago');	 
		$tipo_envio 			= 	$this->input->post('nombre_tipo_envio');	 
		
		$lugar_entrega 			= 	$this->input->post('nombre_lugar_entrega');	 
		$nombre_terminal 		= 	$this->input->post('nombre_terminal');	 
		$municipio_terminal 	= 	$this->input->post('municipio_terminal');	 
		$codigo_postal_terminal = 	$this->input->post('codigo_postal_terminal');	 
		$provincia_terminal = 	$this->input->post('provincia_terminal');	 
		
		$nuevo_cliente 			= $this->input->post('nuevo_cliente');
		$id_cliente_act 		= $this->input->post('id_cliente');
		$dni 					= $this->input->post('dni');
		$nombre 				= $this->input->post('nombre');
		$apellidos 				= $this->input->post('apellidos');
		$telefono 				= $this->input->post('telefono');
		$celular 				= $this->input->post('celular');
		//$celular0 				= $this->input->post('celular0');
		//$celular1 				= $this->input->post('celular1');
		$email 					= $this->input->post('email');
		$codigo_postal 			= $this->input->post('codigo_postal');
		$id_municipio 			= $this->input->post('sel_municipios');		 
		$calle 					= $this->input->post('calle');
		$nro 					= $this->input->post('nro');
		$piso 					= $this->input->post('piso');
		$dpto 					= $this->input->post('dpto');
		$entrecalle1 			= $this->input->post('entrecalle1');
		$entrecalle2 			= $this->input->post('entrecalle2');
		$fecha_nacimiento 		= $this->input->post('fecha_nacimiento');
		$observaciones 			= $this->input->post('notas');
		$cuit 					= $this->input->post('cuit');
		$id_local 				= $this->input->post('id_local');
		$nombre_local 			= $this->input->post('nombre_local');
		$frm_medio 				= 	$this->input->post('frm_medio');
		$financiamiento			= 	$this->input->post('ckfinanciamiento');
		$tbMontoFinanciamiento	= 	$this->input->post('tbMonto');

		$tbNoTarjeta	= 	$this->input->post('tbNoTarjeta');
		$tbNombre		= 	$this->input->post('tbNombre');
		$tbDni			= 	$this->input->post('tbDni');
		$tbMes			= 	$this->input->post('tbMes');
		$tbAnno			= 	$this->input->post('tbAnno');
		$tbCodigo		= 	$this->input->post('tbCodigo');


		if ($forma_pago == 3 || $forma_pago == 4 || $financiamiento) {
			# code...
			
			$nombres = $nombre.' '.$apellidos; 
			$mensaje = "<p><strong><em>Hola $nombres;</em></strong><br>
			<strong><em><br>
			  Queremos informarte que estos son los datos de la empresa para que pueda realizar su pago.</em></strong><br>
			<strong><em><br>
				Banco Santander Río</br>
				Cuenta corriente en Pesos</br>
				Nro. 084-7257/7</br>
				Titular: Dvigi S.A.</br>
				Cuit: 30-69511732-5</br>
				CBU: 07200847 20000000725772</br>
				Suc. San Isidro - Bs As</br></br></br>
			  Cualquier consulta, podrás llamar a nuestro equipo de Atención al Cliente  marcando +54 1165549839  o escribirnos a&nbsp;</em></strong><a href='mailto:ventas@dvigi.com.ar' target='_blank'><strong><em>ventas@dvigi.com.ar</em></strong></a><strong><em><br>
				Saludos.</em></strong></p>
		  <p><strong><em>&quot;Disfrutá de  agua pura todos los días con DVIGI&quot;</em></strong></p>";

			$this->sendMailMandril($email,'Notificaciones DVIGI', $mensaje);
		}

		if($financiamiento){
			$financiamiento = 1;
		}else{
			$financiamiento = 0;
		}
		/*if($celular0 !='' && $celular1 != ''){
			$celular = $celular0.$celular1;
		}*/
		// Venta
		$id_canal = 13;
		//$id_pedido = $this->input->post('id_pedido');
		$no_factura 			= $this->input->post('frm_factura');		
		$id_transaccion 		= 'ORD-' . $this->obtener_parametro('ORDEN_REVENDEDOR');
		$fecha_venta 			= $this->input->post('fecha');
		//$recargo = $this->input->post('frm_recargo');
		$tipo_factura 			= $this->input->post('id_tipo_factura');
		$calle_entrega 			= $this->input->post('calle_entrega');
		$nro_entrega 			= $this->input->post('nro_entrega');
		$piso_entrega 			= $this->input->post('piso_entrega');
		$dpto_entrega 			= $this->input->post('dpto_entrega');
		$municipio_entrega 		= $this->input->post('municipio_entrega');
		$provincia_entrega 		= $this->input->post('provincia_entrega');		
		$entrecalle1_entrega 	= $this->input->post('entrecalle1_entrega');
		$entrecalle2_entrega 	= $this->input->post('entrecalle2_entrega');
		$monto_iva 				= $this->input->post('monto_iva');
		//$monto_recargo = $this->input->post('frm_monto_recargo');
		$codigo_postal_entrega	=  $this->input->post('codigo_postal_entrega');
		
		//$envio_inmediato = 'SI';
		   
	  // $id_envio_oca		= $this->input->post('frm_id_envio_oca');	
	   
	   $dt_productos		= explode(',',$this->input->post('frm_dtProductos'));
	   //$dt_campanas		= explode(',',$this->input->post('frm_dtCampanas'));
	   $dt_colores			= explode(',',$this->input->post('frm_dtColores'));
	   $dt_descuentos		= explode(',',$this->input->post('frm_dtDescuentos'));
	   $dt_notas			= explode(',',$this->input->post('frm_dtNotas'));
	   //$dt_descuentos_vip	= explode(',',$this->input->post('frm_dtDescuentos_vip'));
	   $dt_incrementos		= explode(',',$this->input->post('frm_dtIncrementos'));
	   $dt_precios			= explode(',',$this->input->post('frm_dtPrecios'));		
	   $dt_cantidades		= explode(',',$this->input->post('frm_dtCantidades'));		
	   $total_productos 	= $this->input->post('frm_TotalProductos');
	   $dt_alto				= explode(',',$this->input->post('frm_dtAlto'));
	   $dt_ancho			= explode(',',$this->input->post('frm_dtAncho'));
	   $dt_largo			= explode(',',$this->input->post('frm_dtLargo'));
	   $dt_peso				= explode(',',$this->input->post('frm_dtPeso'));
	   $dt_combo			= explode(',',$this->input->post('frm_dtEsCombo'));

	   $registro = $this->M_operaciones->registrar_orden(
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
		);

		$tbNoTarjeta_enc	= 	encrypt($tbNoTarjeta, 'AGKJIU324KHGG4587KJ43243FD99979');
		$tbNombre_enc		= 	encrypt($tbNombre, 'AGKJIU324KHGG4587KJ43243FD99979');
		$tbCodigo_enc		= 	encrypt($tbCodigo, 'AGKJIU324KHGG4587KJ43243FD99979');
		

		$id_orden = $registro;
		if($frm_medio != 0){
			$tarj = $this->M_operaciones->guardar_tarjeta($id_orden, $tbNoTarjeta_enc, $tbNombre_enc, $tbDni, $tbMes, $tbAnno, $tbCodigo_enc);
		}
		$resu = $this->M_operaciones->guardar_estado_orden($id_orden,2,'Solicitud de orden de compra');
		$estado_orden = 'Control de Políticas Comerciales y precios';
		$nombres = $nombre.' '.$apellidos;
		$mensaje = "<p><strong><em>Hola $nombres;</em></strong><br>
			<strong><em><br>
			  Queremos informarte que tu pedido ha sido guardado correctamente en el día de la  $fecha_venta.&nbsp; y a través de esta vía lo mantendremos informado del estado de su pedido. Ahora su pedido esta en $estado_orden.</em></strong><br>
			<strong><em><br>
			  Cualquier consulta, podrás llamar a nuestro equipo de Atención al Cliente  marcando +54 1165549839  o escribirnos a&nbsp;</em></strong><a href='mailto:ventas@dvigi.com.ar' target='_blank'><strong><em>ventas@dvigi.com.ar</em></strong></a><strong><em><br>
				Saludos.</em></strong></p>
		  <p><strong><em>&quot;Disfrutá de  agua pura todos los días con DVIGI&quot;</em></strong></p>";

			$this->sendMailMandril($email,'Notificaciones DVIGI', $mensaje);
		    $datos_jefe= $this->M_operaciones->miembrosgrupos('RevendedoresInt');
			foreach ($datos_jefe->result() as $key) {
				
				$this->sendMailMandril($key->email,'Notificaciones DVIGI', $mensaje);
			}
			$datos['id_actual'] = 1;
			//$this->load->view('lte_header', $datos);
			$this->load->view('exito_orden_revint', $datos);
	
	}
	public function politicas_comerciales(){
		$group = array('Revendedores'); 
		if ($this->ion_auth->in_group($group)){
			$resultados 		= $this->M_operaciones->cargar_orden_estado_nac(2);
		}
		$group = array('RevendedoresInt'); 
		if ($this->ion_auth->in_group($group)){
			$resultados 		= $this->M_operaciones->cargar_orden_estado_int(2);
		}
		
		$datos['controles'] = $resultados;
		$datos['total'] 	= $resultados->num_rows();
		
		$this->load->view('lte_header', $datos);
 	    $this->load->view('v_listado_control_politicas', $datos);
	    $this->load->view('lte_footer', $datos);
	}
	public function editar_control_politica($id_orden){
		$orden 				= $this->M_operaciones->cargar_orden_revisar($id_orden);
		$detalles 			= $this->M_operaciones->cargar_orden_revisar_detalle($id_orden);
		$datos['orden'] 	= $orden;
		$datos['detalles'] 	= $detalles;
		$iva =0;
		$anno=date('Y');
		$mes=date('m');
		$res = $this->M_configuracion->obtener_iva($anno, $mes);
		
		$row = $res->row();
		if($row != ''){
			$iva = $row->iva;
		}
		$id_usuario = $this->M_operaciones->obt_usuario_de_orden($id_orden);
		$consultorRV1 = $this->M_operaciones->cargar_perfil($id_usuario);
		$datos['consultorRV1']	= $consultorRV1;
		$group = array('RevendedoresInt'); 
		if ($this->ion_auth->in_group($group)){
			$id_usuario = $this->M_operaciones->obt_usuario_de_orden($id_orden);
			$id_pais = $this->M_operaciones->obt_rev_pais($id_usuario);
			$iva = $this->M_operaciones->obt_rev_int_iva($id_pais);
			
		}
		$datos['iva'] 	= $iva;
		$productos 				= $this->M_operaciones->productos_rev();
		$datos['productos'] 	= $productos;
		$combos 				= $this->M_operaciones->combos();
		$datos['combos'] 		= $combos;
		$this->load->view('lte_header', $datos);
 	    $this->load->view('orden_compra_revisar_politica', $datos);
	    $this->load->view('lte_footer', $datos);
	}
	public function modificar_control_politica(){
		$id_orden 			= $this->input->post('id_actual');
		$evaluacion 		= $this->input->post('evaluacion');
		$notas 				= $this->input->post('notas');
		$nombres 			= $this->input->post('nombre');
		$financiamiento 	= $this->input->post('financiamiento');

		$lugar_entrega 			= 	$this->input->post('nombre_lugar_entrega');	 
		$nombre_terminal 		= 	$this->input->post('nombre_terminal');	 
		$municipio_terminal 	= 	$this->input->post('municipio_terminal');	 
		$codigo_postal_terminal = 	$this->input->post('codigo_postal_terminal');	 
		$provincia_terminal 	= 	$this->input->post('provincia_terminal');
		$calle_entrega 			= 	$this->input->post('calle_entrega');
		$nro_entrega 			= 	$this->input->post('nro_entrega');
		$piso_entrega 			= 	$this->input->post('piso_entrega');
		$dpto_entrega 			= 	$this->input->post('dpto_entrega');
		$municipio_entrega 		= 	$this->input->post('municipio_entrega');
		$provincia_entrega 		= 	$this->input->post('provincia_entrega');		
		$entrecalle1_entrega 	= 	$this->input->post('entrecalle1_entrega');
		$entrecalle2_entrega 	= 	$this->input->post('entrecalle2_entrega');
		$codigo_postal_entrega	=  	$this->input->post('codigo_postal_entrega');

		$devuelto = $this->M_operaciones->actualizar_orden(
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
		);
		$resul = $this->M_operaciones->guardar_notas($id_orden,$notas);
		if($evaluacion == 'aceptado'){
			$dt_productos		= explode(',',$this->input->post('frm_dtProductos'));
			//$dt_campanas		= explode(',',$this->input->post('frm_dtCampanas'));
			$dt_colores			= explode(',',$this->input->post('frm_dtColores'));
			$dt_descuentos		= explode(',',$this->input->post('frm_dtDescuentos'));
			$dt_notas			= explode(',',$this->input->post('frm_dtNotas'));
			//$dt_descuentos_vip	= explode(',',$this->input->post('frm_dtDescuentos_vip'));
			$dt_incrementos		= explode(',',$this->input->post('frm_dtIncrementos'));
			$dt_precios			= explode(',',$this->input->post('frm_dtPrecios'));		
			$dt_cantidades		= explode(',',$this->input->post('frm_dtCantidades'));		
			$total_productos 	= $this->input->post('frm_TotalProductos');
			$dt_alto				= explode(',',$this->input->post('frm_dtAlto'));
			$dt_ancho			= explode(',',$this->input->post('frm_dtAncho'));
			$dt_largo			= explode(',',$this->input->post('frm_dtLargo'));
			$dt_peso				= explode(',',$this->input->post('frm_dtPeso'));
			$dt_combo			= explode(',',$this->input->post('frm_dtEsCombo'));
			$registro = $this->M_operaciones->modificar_orden($id_orden,				
				$dt_productos,
				$dt_precios,
				$dt_cantidades,
				$dt_descuentos,
				$dt_incrementos,
				$dt_colores,
				$dt_combo
			);
			if($financiamiento == '1'){
				$resu = $this->M_operaciones->guardar_estado_orden($id_orden,3,'Control de Políticas Comerciales y precios- ACEPTADO');
				$estado_orden = 'Control crediticio – Sistema Nosis';
				$asunto='Control de Políticas Comerciales y precios- ACEPTADO';
			}else{
				$resu = $this->M_operaciones->guardar_estado_orden($id_orden,4,'Control de Políticas Comerciales y precios- ACEPTADO');
				$estado_orden = 'Control stock';
				$asunto='Control de Políticas Comerciales y precios- ACEPTADO';
			}
			$mensaje = "<p><strong><em>Hola $nombres;</em></strong><br>
			<strong><em><br>
			  Queremos informarte que tu pedido ha sido ACEPTADO correctamente en el Control de Políticas Comerciales y precios; y a través de esta vía lo mantendremos informado del estado de su pedido. Ahora su pedido esta en $estado_orden.</em></strong><br>
			<strong><em><br>
			  Cualquier consulta, podrás llamar a nuestro equipo de Atención al Cliente  marcando +54 1165549839  o escribirnos a&nbsp;</em></strong><a href='mailto:ventas@dvigi.com.ar' target='_blank'><strong><em>ventas@dvigi.com.ar</em></strong></a><strong><em><br>
				Saludos.</em></strong></p>
		  <p><strong><em>&quot;Disfrutá de  agua pura todos los días con DVIGI&quot;</em></strong></p><a href='https://www.tienda.dvigi.com.ar/repuestos_qO27328244XtOcxSM'><img src='https://dvigi-sistema.com/dvigi/api_cron/img/imagen2.png'></a>";
		  $datos_jefe= $this->M_operaciones->miembrosgrupos('Administradores');
		  foreach ($datos_jefe->result() as $key) {
			  
			  $this->sendMailMandril($key->email,'Notificaciones DVIGI', $mensaje);
		  }
		  
		}else{
			$resu = $this->M_operaciones->guardar_estado_orden($id_orden,1,'Control de Políticas Comerciales y precios- RECHAZADO: '.$notas);
			$estado_orden = 'RECHAZADO';
			$asunto='Control de Políticas Comerciales y precios- RECHAZADO';

			$mensaje = "<p><strong><em>Hola $nombres;</em></strong><br>
			<strong><em><br>
			  Queremos informarte que tu pedido ha sido RECHAZADO en el Control de Políticas Comerciales y precios; y a través de esta vía le informamos quela causa del rechazo es: $notas. Ahora su pedido esta en $estado_orden.</em></strong><br>
			<strong><em><br>
			  Cualquier consulta, podrás llamar a nuestro equipo de Atención al Cliente  marcando +54 1165549839  o escribirnos a&nbsp;</em></strong><a href='mailto:ventas@dvigi.com.ar' target='_blank'><strong><em>ventas@dvigi.com.ar</em></strong></a><strong><em><br>
				Saludos.</em></strong></p>
		  <p><strong><em>&quot;Disfrutá de  agua pura todos los días con DVIGI&quot;</em></strong></p><a href='https://www.tienda.dvigi.com.ar/repuestos_qO27328244XtOcxSM'><img src='https://dvigi-sistema.com/dvigi/api_cron/img/imagen2.png'></a>";
		}
			//$email = $this->M_operaciones->obt_mail_orden($id_orden);
			//$this->sendMailMandril($email,'Notificaciones DVIGI', $mensaje);
			$this->politicas_comerciales();

		
	}
	
	public function control_crediticio(){
		
		$resultados 		= $this->M_operaciones->cargar_orden_estado(3);
		$group = array('Revendedores'); 
		if ($this->ion_auth->in_group($group)){
			$resultados 		= $this->M_operaciones->cargar_orden_estado_nac(3);
		}
		$group = array('RevendedoresInt'); 
		if ($this->ion_auth->in_group($group)){
			$resultados 		= $this->M_operaciones->cargar_orden_estado_int(3);
		}
		$datos['controles'] = $resultados;
		$datos['total'] 	= $resultados->num_rows();

		$this->load->view('lte_header', $datos);
 	    $this->load->view('v_listado_control_crediticio', $datos);
	    $this->load->view('lte_footer', $datos);
	}
	public function editar_control_crediticio($id_orden){
		$orden 				= $this->M_operaciones->cargar_orden_revisar($id_orden);
		$detalles 			= $this->M_operaciones->cargar_orden_revisar_detalle($id_orden);
		$datos['orden'] 	= $orden;
		$datos['detalles'] 	= $detalles;
		$id_usuario = $this->M_operaciones->obt_usuario_de_orden($id_orden);
		$consultorRV1 = $this->M_operaciones->cargar_perfil($id_usuario);
		$datos['consultorRV1']	= $consultorRV1;
		$this->load->view('lte_header', $datos);
 	    $this->load->view('orden_compra_revisar_crediticio', $datos);
	    $this->load->view('lte_footer', $datos);
	}
	public function modificar_control_crediticio(){
		$id_orden 			= $this->input->post('id_actual');
		$evaluacion 		= $this->input->post('evaluacion');
		$notas 				= $this->input->post('notas');
		$nombres 			= $this->input->post('nombre');
		$financiamiento 	= $this->input->post('financiamiento');
		if($evaluacion == 'aceptado'){
			
			$resu = $this->M_operaciones->guardar_estado_orden($id_orden,4,'Control crediticio – Sistema Nosis- ACEPTADO');
			$estado_orden = 'Control stock';
			$asunto='Control crediticio – Sistema Nosis- ACEPTADO';
			
			$mensaje = "<p><strong><em>Hola $nombres;</em></strong><br>
			<strong><em><br>
			  Queremos informarte que tu pedido ha sido ACEPTADO correctamente en el Control de Políticas Comerciales y precios; y a través de esta vía lo mantendremos informado del estado de su pedido. Ahora su pedido esta en $estado_orden.</em></strong><br>
			<strong><em><br>
			  Cualquier consulta, podrás llamar a nuestro equipo de Atención al Cliente  marcando +54 1165549839  o escribirnos a&nbsp;</em></strong><a href='mailto:ventas@dvigi.com.ar' target='_blank'><strong><em>ventas@dvigi.com.ar</em></strong></a><strong><em><br>
				Saludos.</em></strong></p>
		  <p><strong><em>&quot;Disfrutá de  agua pura todos los días con DVIGI&quot;</em></strong></p><a href='https://www.tienda.dvigi.com.ar/repuestos_qO27328244XtOcxSM'><img src='https://dvigi-sistema.com/dvigi/api_cron/img/imagen2.png'></a>";


		  	$datos_jefe= $this->M_operaciones->miembrosgrupos('Despachadores');
			foreach ($datos_jefe->result() as $key) {
				
				$this->sendMailMandril($key->email,'Notificaciones DVIGI', $mensaje);
			}
			$datos_jefe= $this->M_operaciones->miembrosgrupos('ResponsableArmado');
			foreach ($datos_jefe->result() as $key) {
				
				$this->sendMailMandril($key->email,'Notificaciones DVIGI', $mensaje);
			}
			$datos_jefe= $this->M_operaciones->miembrosgrupos('GerenteProduccion');
			foreach ($datos_jefe->result() as $key) {
				
				$this->sendMailMandril($key->email,'Notificaciones DVIGI', $mensaje);
			}
		}else{
			$resu = $this->M_operaciones->guardar_estado_orden($id_orden,1,'Control crediticio – Sistema Nosis- RECHAZADO: '.$notas);
			$estado_orden = 'RECHAZADO';
			$asunto='Control crediticio – Sistema Nosis- RECHAZADO';

			$mensaje = "<p><strong><em>Hola $nombres;</em></strong><br>
			<strong><em><br>
			  Queremos informarte que tu pedido ha sido RECHAZADO en el Control de Políticas Comerciales y precios; y a través de esta vía le informamos quela causa del rechazo es: $notas. Ahora su pedido esta en $estado_orden.</em></strong><br>
			<strong><em><br>
			  Cualquier consulta, podrás llamar a nuestro equipo de Atención al Cliente  marcando +54 1165549839  o escribirnos a&nbsp;</em></strong><a href='mailto:ventas@dvigi.com.ar' target='_blank'><strong><em>ventas@dvigi.com.ar</em></strong></a><strong><em><br>
				Saludos.</em></strong></p>
		  <p><strong><em>&quot;Disfrutá de  agua pura todos los días con DVIGI&quot;</em></strong></p><a href='https://www.tienda.dvigi.com.ar/repuestos_qO27328244XtOcxSM'><img src='https://dvigi-sistema.com/dvigi/api_cron/img/imagen2.png'></a>";
		}

		//$email = $this->M_operaciones->obt_mail_orden($id_orden);
		//$this->sendMailMandril($email,'Notificaciones DVIGI', $mensaje);
			$this->control_crediticio();
		
	}
	
	public function control_stock(){
		$resultados 		= $this->M_operaciones->cargar_orden_estado(4);
		$group = array('Revendedores','GerenteProduccion'); 
		if ($this->ion_auth->in_group($group)){
			$resultados 		= $this->M_operaciones->cargar_orden_estado_nac(4);
		}
		$group = array('RevendedoresInt','GerenteProduccion'); 
		if ($this->ion_auth->in_group($group)){
			$resultados 		= $this->M_operaciones->cargar_orden_estado_int(4);
		}
		$datos['controles'] = $resultados;
		$datos['total'] 	= $resultados->num_rows();
		$datos['estado'] 	= $this->M_operaciones->obt_estado_rechazado(0,4);
		$this->load->view('lte_header', $datos);
 	    $this->load->view('v_listado_control_stock', $datos);
	    $this->load->view('lte_footer', $datos);
	}
	public function editar_control_stock($id_orden){
		$orden 				= $this->M_operaciones->cargar_orden_revisar($id_orden);
		$detalles 			= $this->M_operaciones->cargar_orden_revisar_detalle($id_orden);
		$id_usuario = $this->M_operaciones->obt_usuario_de_orden($id_orden);
		$consultorRV1 = $this->M_operaciones->cargar_perfil($id_usuario);
		$datos['consultorRV1']	= $consultorRV1;
		$datos['orden'] 	= $orden;
		$datos['detalles'] 	= $detalles;
		$datos['estado'] 	= $this->M_operaciones->obt_estado_rechazado($id_orden,4);

		$this->load->view('lte_header', $datos);
 	    $this->load->view('orden_compra_revisar_stock', $datos);
	    $this->load->view('lte_footer', $datos);
	}
	public function modificar_control_stock(){
		$id_orden 			= $this->input->post('id_actual');
		$evaluacion 		= $this->input->post('evaluacion');
		$notas 				= $this->input->post('notas');
		$nombres 			= $this->input->post('nombre');
		$financiamiento 	= $this->input->post('financiamiento');
		if($evaluacion == 'aceptado'){
			
			$resu = $this->M_operaciones->guardar_estado_orden($id_orden,5,'Control Stock- ACEPTADO');
			$estado_orden = 'Facturación & Confirmación de Facturación ';
			$asunto='Control stock – Sistema Nosis- ACEPTADO';
			
			$mensaje = "<p><strong><em>Hola $nombres;</em></strong><br>
			<strong><em><br>
			  Queremos informarte que tu pedido ha sido ACEPTADO correctamente en el Control de Políticas Comerciales y precios; y a través de esta vía lo mantendremos informado del estado de su pedido. Ahora su pedido esta en $estado_orden.</em></strong><br>
			<strong><em><br>
			  Cualquier consulta, podrás llamar a nuestro equipo de Atención al Cliente  marcando +54 1165549839  o escribirnos a&nbsp;</em></strong><a href='mailto:ventas@dvigi.com.ar' target='_blank'><strong><em>ventas@dvigi.com.ar</em></strong></a><strong><em><br>
				Saludos.</em></strong></p>
		  <p><strong><em>&quot;Disfrutá de  agua pura todos los días con DVIGI&quot;</em></strong></p><a href='https://www.tienda.dvigi.com.ar/repuestos_qO27328244XtOcxSM'><img src='https://dvigi-sistema.com/dvigi/api_cron/img/imagen2.png'></a>";
		
		  $datos_jefe= $this->M_operaciones->miembrosgrupos('Administradores');
			foreach ($datos_jefe->result() as $key) {
				
				$this->sendMailMandril($key->email,'Notificaciones DVIGI', $mensaje);
			}
		  //$email = $this->M_operaciones->obt_mail_orden($id_orden);
		  //$this->sendMailMandril($email,'Notificaciones DVIGI', $mensaje);
		}else{
			
			$resu = $this->M_operaciones->guardar_estado_rechazado($id_orden,4,$notas);
			/*$estado_orden = 'RECHAZADO';
			$asunto='Control Stock - RECHAZADO';

			$mensaje = "<p><strong><em>Hola $nombres;</em></strong><br>
			<strong><em><br>
			  Queremos informarte que tu pedido ha sido RECHAZADO en el Control de Políticas Comerciales y precios; y a través de esta vía le informamos quela causa del rechazo es: $notas. Ahora su pedido esta en $estado_orden.</em></strong><br>
			<strong><em><br>
			  Cualquier consulta, podrás llamar a nuestro equipo de Atención al Cliente  marcando +54 11 47925585 o escribirnos a&nbsp;</em></strong><a href='mailto:consultas@dvigi.com.ar' target='_blank'><strong><em>consultas@dvigi.com.ar</em></strong></a><strong><em><br>
				Saludos.</em></strong></p>
		  <p><strong><em>&quot;Disfrutá de  agua pura todos los días con DVIGI&quot;</em></strong></p><a href='https://www.tienda.dvigi.com.ar/repuestos_qO27328244XtOcxSM'><img src='https://dvigi-sistema.com/dvigi/api_cron/img/imagen2.png'></a>";*/
		}

			
			$this->control_stock();

		
	}
	
	public function control_facturacion(){
		$resultados 		= $this->M_operaciones->cargar_orden_estado(5);
		$group = array('Revendedores'); 
		if ($this->ion_auth->in_group($group)){
			$resultados 		= $this->M_operaciones->cargar_orden_estado_nac(5);
		}
		$group = array('RevendedoresInt'); 
		if ($this->ion_auth->in_group($group)){
			$resultados 		= $this->M_operaciones->cargar_orden_estado_int(5);
		}
		$datos['controles'] = $resultados;
		$datos['total'] 	= $resultados->num_rows();

		$this->load->view('lte_header', $datos);
 	    $this->load->view('v_listado_control_facturacion', $datos);
	    $this->load->view('lte_footer', $datos);
	}
	public function editar_control_facturacion($id_orden){
		$orden 				= $this->M_operaciones->cargar_orden_revisar($id_orden);
		$detalles 			= $this->M_operaciones->cargar_orden_revisar_detalle($id_orden);
		$datos['orden'] 	= $orden;
		$datos['detalles'] 	= $detalles;
		$id_usuario = $this->M_operaciones->obt_usuario_de_orden($id_orden);
		$consultorRV1 = $this->M_operaciones->cargar_perfil($id_usuario);
		$datos['consultorRV1']	= $consultorRV1;
		$this->load->view('lte_header', $datos);
 	    $this->load->view('orden_compra_revisar_facturacion', $datos);
	    $this->load->view('lte_footer', $datos);
	}
	public function editar_control_facturacion_pdf($id_orden){
		$orden 				= $this->M_operaciones->cargar_orden_revisar($id_orden);
		$detalles 			= $this->M_operaciones->cargar_orden_revisar_detalle($id_orden);
		$datos['orden'] 	= $orden;
		$datos['detalles'] 	= $detalles;
		$id_usuario = $this->M_operaciones->obt_usuario_de_orden($id_orden);
		$consultorRV1 = $this->M_operaciones->cargar_perfil($id_usuario);
		$datos['consultorRV1']	= $consultorRV1;
		$this->descargar_pdf('Orden_compra','orden_compra_pdf', $datos);
		$this->load->view('lte_header', $datos);
 	    $this->load->view('orden_compra_revisar_facturacion', $datos);
	    $this->load->view('lte_footer', $datos);
	}
	public function modificar_control_facturacion(){
		$id_orden 			= $this->input->post('id_actual');
		$evaluacion 		= $this->input->post('evaluacion');
		$notas 				= $this->input->post('notas');
		$nombres 			= $this->input->post('nombre');
		$financiamiento 	= $this->input->post('financiamiento');
		$fecha_facturacion 	= $this->input->post('fecha_facturacion');
		$fecha_confirmacion = $this->input->post('fecha_confirmacion');
		$tipo_envio = $this->input->post('tipo_envio');
		$res = $this->M_operaciones->guardar_fechas_orden($id_orden, $fecha_facturacion,$fecha_confirmacion);

		if($evaluacion == 'aceptado'){
			if($financiamiento == '1'){
				$resu = $this->M_operaciones->guardar_estado_orden($id_orden,7,'Facturación & Confirmación de Facturación - ACEPTADO');
				$estado_orden = 'Armado de pedidos & control de despachos';
				$asunto='Facturación & Confirmación de Facturación - ACEPTADO';
				$flag=0;
			}else{
				$resu = $this->M_operaciones->guardar_estado_orden($id_orden,6,'Facturación & Confirmación de Facturación - ACEPTADO');
				$estado_orden = 'Control de Acreditaciones sin financiación';
				$asunto='Facturación & Confirmación de Facturación - ACEPTADO';
				$flag =1;
			}
			// LLevar a cabo la facturación
			$registro = $this->M_operaciones->registrar_factura($id_orden,$fecha_facturacion, $tipo_envio);
			//*************************** */
			$mensaje = "<p><strong><em>Hola $nombres;</em></strong><br>
			<strong><em><br>
			  Queremos informarte que tu pedido ha sido ACEPTADO correctamente en el Control de Políticas Comerciales y precios; y a través de esta vía lo mantendremos informado del estado de su pedido. Ahora su pedido esta en $estado_orden.</em></strong><br>
			<strong><em><br>
			  Cualquier consulta, podrás llamar a nuestro equipo de Atención al Cliente  marcando +54 1165549839  o escribirnos a&nbsp;</em></strong><a href='mailto:ventas@dvigi.com.ar' target='_blank'><strong><em>ventas@dvigi.com.ar</em></strong></a><strong><em><br>
				Saludos.</em></strong></p>
		  <p><strong><em>&quot;Disfrutá de  agua pura todos los días con DVIGI&quot;</em></strong></p><a href='https://www.tienda.dvigi.com.ar/repuestos_qO27328244XtOcxSM'><img src='https://dvigi-sistema.com/dvigi/api_cron/img/imagen2.png'></a>";

		  if($flag ==0){
			$datos_jefe= $this->M_operaciones->miembrosgrupos('Despachadores');
			foreach ($datos_jefe->result() as $key) {
				
				$this->sendMailMandril($key->email,'Notificaciones DVIGI', $mensaje);
			}
			$datos_jefe= $this->M_operaciones->miembrosgrupos('ResponsableArmado');
			foreach ($datos_jefe->result() as $key) {
				
				$this->sendMailMandril($key->email,'Notificaciones DVIGI', $mensaje);
			}
			$datos_jefe= $this->M_operaciones->miembrosgrupos('GerenteProduccion');
			foreach ($datos_jefe->result() as $key) {
				
				$this->sendMailMandril($key->email,'Notificaciones DVIGI', $mensaje);
			}
		  }else{
			$datos_jefe= $this->M_operaciones->miembrosgrupos('Administradores');
			foreach ($datos_jefe->result() as $key) {
				
				$this->sendMailMandril($key->email,'Notificaciones DVIGI', $mensaje);
			}
		  }
		}else{
			$resu = $this->M_operaciones->guardar_estado_orden($id_orden,1,'Facturación & Confirmación de Facturación - RECHAZADO: '.$notas);
			$estado_orden = 'RECHAZADO';
			$asunto='Control Stock - RECHAZADO';

			$mensaje = "<p><strong><em>Hola $nombres;</em></strong><br>
			<strong><em><br>
			  Queremos informarte que tu pedido ha sido RECHAZADO en el Control de Políticas Comerciales y precios; y a través de esta vía le informamos quela causa del rechazo es: $notas. Ahora su pedido esta en $estado_orden.</em></strong><br>
			<strong><em><br>
			  Cualquier consulta, podrás llamar a nuestro equipo de Atención al Cliente  marcando +54 1165549839  o escribirnos a&nbsp;</em></strong><a href='mailto:ventas@dvigi.com.ar' target='_blank'><strong><em>ventas@dvigi.com.ar</em></strong></a><strong><em><br>
				Saludos.</em></strong></p>
		  <p><strong><em>&quot;Disfrutá de  agua pura todos los días con DVIGI&quot;</em></strong></p><a href='https://www.tienda.dvigi.com.ar/repuestos_qO27328244XtOcxSM'><img src='https://dvigi-sistema.com/dvigi/api_cron/img/imagen2.png'></a>";
		}

		//$email = $this->M_operaciones->obt_mail_orden($id_orden);
		//$this->sendMailMandril($email,'Notificaciones DVIGI', $mensaje);
		$this->control_facturacion();
		
	}
	
	public function control_acreditaciones(){
		$resultados 		= $this->M_operaciones->cargar_orden_estado(6);
		$group = array('Revendedores'); 
		if ($this->ion_auth->in_group($group)){
			$resultados 		= $this->M_operaciones->cargar_orden_estado_nac(6);
		}
		$group = array('RevendedoresInt'); 
		if ($this->ion_auth->in_group($group)){
			$resultados 		= $this->M_operaciones->cargar_orden_estado_int(6);
		}
		$datos['controles'] = $resultados;
		$datos['total'] 	= $resultados->num_rows();

		$this->load->view('lte_header', $datos);
 	    $this->load->view('v_listado_control_acreditaciones', $datos);
	    $this->load->view('lte_footer', $datos);
	}
	public function editar_control_acreditaciones($id_orden){
		$orden 				= $this->M_operaciones->cargar_orden_revisar($id_orden);
		$detalles 			= $this->M_operaciones->cargar_orden_revisar_detalle($id_orden);
		$datos['orden'] 	= $orden;
		$datos['detalles'] 	= $detalles;
		$id_usuario = $this->M_operaciones->obt_usuario_de_orden($id_orden);
		$consultorRV1 = $this->M_operaciones->cargar_perfil($id_usuario);
		$datos['consultorRV1']	= $consultorRV1;
		$tarjeta = $this->M_operaciones->cargar_tarjeta($id_orden);
		$datos['tarjeta']	= $tarjeta;

		$this->load->view('lte_header', $datos);
 	    $this->load->view('orden_compra_revisar_acreditaciones', $datos);
	    $this->load->view('lte_footer', $datos);
	}
	public function modificar_control_acreditaciones(){
		$id_orden 			= $this->input->post('id_actual');
		$evaluacion 		= $this->input->post('evaluacion');
		$notas 				= $this->input->post('notas');
		$nombres 			= $this->input->post('nombre');
		$financiamiento 	= $this->input->post('financiamiento');
		if($evaluacion == 'aceptado'){
			
			$resu = $this->M_operaciones->guardar_estado_orden($id_orden,7,'Control de Acreditaciones sin financiación - ACEPTADO');
			$estado_orden = 'Armado de pedidos & control de despachos';
			$asunto='Control de Acreditaciones sin financiación - ACEPTADO';
			
			$mensaje = "<p><strong><em>Hola $nombres;</em></strong><br>
			<strong><em><br>
			  Queremos informarte que tu pedido ha sido ACEPTADO correctamente en el Control de Políticas Comerciales y precios; y a través de esta vía lo mantendremos informado del estado de su pedido. Ahora su pedido esta en $estado_orden.</em></strong><br>
			<strong><em><br>
			  Cualquier consulta, podrás llamar a nuestro equipo de Atención al Cliente  marcando +54 1165549839  o escribirnos a&nbsp;</em></strong><a href='mailto:ventas@dvigi.com.ar' target='_blank'><strong><em>ventas@dvigi.com.ar</em></strong></a><strong><em><br>
				Saludos.</em></strong></p>
		  <p><strong><em>&quot;Disfrutá de  agua pura todos los días con DVIGI&quot;</em></strong></p><a href='https://www.tienda.dvigi.com.ar/repuestos_qO27328244XtOcxSM'><img src='https://dvigi-sistema.com/dvigi/api_cron/img/imagen2.png'></a>";
		  $datos_jefe= $this->M_operaciones->miembrosgrupos('Administradores');
			foreach ($datos_jefe->result() as $key) {
				
				$this->sendMailMandril($key->email,'Notificaciones DVIGI', $mensaje);
			}
		}else{
			$resu = $this->M_operaciones->guardar_estado_orden($id_orden,1,'Control de Acreditaciones sin financiación - RECHAZADO: '.$notas);
			$estado_orden = 'RECHAZADO';
			$asunto='Control de Acreditaciones sin financiación - RECHAZADO';

			$mensaje = "<p><strong><em>Hola $nombres;</em></strong><br>
			<strong><em><br>
			  Queremos informarte que tu pedido ha sido RECHAZADO en el Control de Políticas Comerciales y precios; y a través de esta vía le informamos quela causa del rechazo es: $notas. Ahora su pedido esta en $estado_orden.</em></strong><br>
			<strong><em><br>
			  Cualquier consulta, podrás llamar a nuestro equipo de Atención al Cliente  marcando +54 1165549839  o escribirnos a&nbsp;</em></strong><a href='mailto:ventas@dvigi.com.ar' target='_blank'><strong><em>ventas@dvigi.com.ar</em></strong></a><strong><em><br>
				Saludos.</em></strong></p>
		  <p><strong><em>&quot;Disfrutá de  agua pura todos los días con DVIGI&quot;</em></strong></p><a href='https://www.tienda.dvigi.com.ar/repuestos_qO27328244XtOcxSM'><img src='https://dvigi-sistema.com/dvigi/api_cron/img/imagen2.png'></a>";
		}

		//$email = $this->M_operaciones->obt_mail_orden($id_orden);
		//$this->sendMailMandril($email,'Notificaciones DVIGI', $mensaje);
		$this->control_acreditaciones();;

		
	}
	
	public function control_despachos(){
		$resultados 		= $this->M_operaciones->cargar_orden_estado(7);
		$group = array('Revendedores'); 
		if ($this->ion_auth->in_group($group)){
			$resultados 		= $this->M_operaciones->cargar_orden_estado_nac(7);
		}
		$group = array('RevendedoresInt'); 
		if ($this->ion_auth->in_group($group)){
			$resultados 		= $this->M_operaciones->cargar_orden_estado_int(7);
		}
		$despachos 			= $this->M_operaciones->cargar_orden_entrega_despacho();
		$datos['controles'] = $resultados;
		$datos['total'] 	= $resultados->num_rows();

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
		$cliente = array();
		$email = array();								
		$id_entrega = array();
		$cargado = array();
		// echo '<option value="' . $mun->id_tipo_empresa . '">' . $mun->nombre . '</option>';
		$contador= 0;
		$bandera=0;
		foreach ($despachos->result() as $pr){			
			if($bandera==0){
				$contador= 0;				
				$anterior=$pr->id_pedido;
				$actual=$pr->id_pedido;
				$importe[$contador] =0;
			}else{
				$actual=$pr->id_pedido;
			}
			if($anterior == $actual){
				if($contador== 0 && $bandera==0){//es la primera vez qe se recorre
					$bandera=1;
					//$id_consultor = $pr->id_usuario;
					//$consultor = $this->M_operaciones->obtener_consultor($id_consultor);
					//$consultores[$contador] = $consultor->first_name;
					$id[$contador] = $pr->id_orden;
					$id_pedido[$contador] = $pr->id_pedido;
					//$id_entrega[$contador] = $pr->id_entrega;
					$no_factura[$contador] = $pr->no_factura;
					$producto[$contador] = $pr->producto.'</br>';
					$importe[$contador] = $pr->cantidad*$pr->precio ;
					//$cobranza[$contador] = '*';
					$OCA[$contador] = $pr->local;
					$armado[$contador] = $pr->armado;
					$despachado[$contador] = $pr->despachado;
					//$recargo[$contador] = $pr->recargo;
					//$iva[$contador] = $pr->iva;
					$fecha[$contador] = $pr->fecha_solicitud;
					$dni[$contador] = $pr->dni;
					$local[$contador] = $pr->id_local;
					//$notas[$contador] = $pr->notas;
					$cliente[$contador] = $pr->cliente;
					$email[$contador] = $pr->email;
					$cargado[$contador] = $pr->cargado;
					//$nombre_apellidos[$contador] = $pr->nombre.' '.$pr->apellidos;					
				}else{//es el mismo pedido
					$producto[$contador] = $producto[$contador]. $pr->producto.'</br>';
					$importe[$contador] = $importe[$contador] + $pr->cantidad*$pr->precio;
				}
			}else{//es otro pedido
				$contador = $contador + 1;
				//$id_consultor = $pr->id_usuario;
					//$consultor = $this->M_operaciones->obtener_consultor($id_consultor);
					//$consultores[$contador] = $consultor->first_name;
					$id[$contador] = $pr->id_orden;
					$id_pedido[$contador] = $pr->id_pedido;
					//$id_entrega[$contador] = $pr->id_entrega;
					$no_factura[$contador] = $pr->no_factura;
					$producto[$contador] = $pr->producto.'</br>';
					$importe[$contador] = $pr->cantidad*$pr->precio ;
					//$cobranza[$contador] = '*';
					$OCA[$contador] = $pr->local;
					$armado[$contador] = $pr->armado;
					$despachado[$contador] = $pr->despachado;
					//$recargo[$contador] = $pr->recargo;
					//$iva[$contador] = $pr->iva;
					$fecha[$contador] = $pr->fecha_solicitud;
					$dni[$contador] = $pr->dni;
					$local[$contador] = $pr->id_local;
					//$notas[$contador] = $pr->notas;
					$cliente[$contador] = $pr->cliente;
					$email[$contador] = $pr->email;
					$cargado[$contador] = $pr->cargado;
					//$nombre_apellidos[$contador] = $pr->nombre.' '.$pr->apellidos;				
				
				//$nombre_apellidos[$contador] = $pr->nombre.' '.$pr->apellidos;
				//Sumo el recargo
				$importe[$contador-1] = $importe[$contador-1]; 
			}
			$anterior=$pr->no_factura;
		}
		if($bandera == 1 )							
			$importe[$contador] = $importe[$contador]; 						
		
		//$datos['consultores'] 		=$consultores;
		$datos['id'] 				=$id;
		$datos['id_pedido'] 		=$id_pedido;
		//$datos['id_entrega'] 		=$id_entrega;
		$datos['no_factura'] 		=$no_factura;
		$datos['producto'] 			=$producto;
		$datos['importe'] 			=$importe;
		//$datos['cobranza'] 			=$cobranza;
		$datos['OCA'] 				=$OCA;
		$datos['armado'] 			=$armado;
		$datos['despachado'] 		=$despachado;
		$datos['dni'] 				=$dni;
		$datos['local'] 			=$local;
		$datos['fecha'] 			=$fecha;
		$datos['notas'] 			=$notas;
		$datos['cliente'] 			=$cliente;
		$datos['email'] 			=$email;
		$datos['cargado'] 			=$cargado;
		//$datos['nombre_apellidos'] 	=$nombre_apellidos;



		$this->load->view('lte_header', $datos);
 	    $this->load->view('v_listado_control_despachos', $datos);
	    $this->load->view('lte_footer', $datos);
	}
	public function editar_control_despachos($id_orden){
		$orden 				= $this->M_operaciones->cargar_orden_revisar($id_orden);
		$detalles 			= $this->M_operaciones->cargar_orden_revisar_detalle($id_orden);
		$datos['orden'] 	= $orden;
		$datos['detalles'] 	= $detalles;
		$id_usuario = $this->M_operaciones->obt_usuario_de_orden($id_orden);
		$consultorRV1 = $this->M_operaciones->cargar_perfil($id_usuario);
		$datos['consultorRV1']	= $consultorRV1;
		$this->load->view('lte_header', $datos);
 	    $this->load->view('orden_compra_revisar_despachos', $datos);
	    $this->load->view('lte_footer', $datos);
	}
	public function modificar_control_despachos(){
		$id_orden 			= $this->input->post('id_actual');
		$evaluacion 		= $this->input->post('evaluacion');
		$notas 				= $this->input->post('notas');
		$nombres 			= $this->input->post('nombre');
		$financiamiento 	= $this->input->post('financiamiento');
		if($evaluacion == 'aceptado'){			
			$resu = $this->M_operaciones->guardar_estado_orden($id_orden,8,'Armado de pedidos & control de despachos - ACEPTADO');
			$estado_orden = 'Recibo de remitos firmados por clientes';
			$asunto='Armado de pedidos & control de despachos - ACEPTADO';			
			
			$mensaje = "<p><strong><em>Hola $nombres;</em></strong><br>
			<strong><em><br>
			  Queremos informarte que tu pedido ha sido ACEPTADO correctamente en el Control de Políticas Comerciales y precios; y a través de esta vía lo mantendremos informado del estado de su pedido. Ahora su pedido esta en $estado_orden.</em></strong><br>
			<strong><em><br>
			  Cualquier consulta, podrás llamar a nuestro equipo de Atención al Cliente  marcando +54 1165549839  o escribirnos a&nbsp;</em></strong><a href='mailto:ventas@dvigi.com.ar' target='_blank'><strong><em>ventas@dvigi.com.ar</em></strong></a><strong><em><br>
				Saludos.</em></strong></p>
		  <p><strong><em>&quot;Disfrutá de  agua pura todos los días con DVIGI&quot;</em></strong></p><a href='https://www.tienda.dvigi.com.ar/repuestos_qO27328244XtOcxSM'><img src='https://dvigi-sistema.com/dvigi/api_cron/img/imagen2.png'></a>";
		  $datos_jefe= $this->M_operaciones->miembrosgrupos('Administradores');
			foreach ($datos_jefe->result() as $key) {
				
				$this->sendMailMandril($key->email,'Notificaciones DVIGI', $mensaje);
			}
		}else{
			$resu = $this->M_operaciones->guardar_estado_orden($id_orden,1,'Armado de pedidos & control de despachos - RECHAZADO: '.$notas);
			$estado_orden = 'RECHAZADO';
			$asunto='Armado de pedidos & control de despachos - RECHAZADO';

			$mensaje = "<p><strong><em>Hola $nombres;</em></strong><br>
			<strong><em><br>
			  Queremos informarte que tu pedido ha sido RECHAZADO en el Control de Políticas Comerciales y precios; y a través de esta vía le informamos quela causa del rechazo es: $notas. Ahora su pedido esta en $estado_orden.</em></strong><br>
			<strong><em><br>
			  Cualquier consulta, podrás llamar a nuestro equipo de Atención al Cliente  marcando +54 1165549839  o escribirnos a&nbsp;</em></strong><a href='mailto:ventas@dvigi.com.ar' target='_blank'><strong><em>ventas@dvigi.com.ar</em></strong></a><strong><em><br>
				Saludos.</em></strong></p>
		  <p><strong><em>&quot;Disfrutá de  agua pura todos los días con DVIGI&quot;</em></strong></p><a href='https://www.tienda.dvigi.com.ar/repuestos_qO27328244XtOcxSM'><img src='https://dvigi-sistema.com/dvigi/api_cron/img/imagen2.png'></a>";
		}

		//$email = $this->M_operaciones->obt_mail_orden($id_orden);
		//$this->sendMailMandril($email,'Notificaciones DVIGI', $mensaje);
		$this->control_despachos();

		
	}
	
	public function control_remitos(){
		$resultados 		= $this->M_operaciones->cargar_orden_estado(8);
		$group = array('Revendedores'); 
		if ($this->ion_auth->in_group($group)){
			$resultados 		= $this->M_operaciones->cargar_orden_estado_nac(8);
		}
		$group = array('RevendedoresInt'); 
		if ($this->ion_auth->in_group($group)){
			$resultados 		= $this->M_operaciones->cargar_orden_estado_int(8);
		}
		$datos['controles'] = $resultados;
		$datos['total'] 	= $resultados->num_rows();

		$this->load->view('lte_header', $datos);
 	    $this->load->view('v_listado_control_remitos', $datos);
	    $this->load->view('lte_footer', $datos);
	}
	public function editar_control_remitos($id_orden){
		$orden 				= $this->M_operaciones->cargar_orden_revisar($id_orden);
		$detalles 			= $this->M_operaciones->cargar_orden_revisar_detalle($id_orden);
		$datos['orden'] 	= $orden;
		$datos['detalles'] 	= $detalles;
		$id_usuario = $this->M_operaciones->obt_usuario_de_orden($id_orden);
		$consultorRV1 = $this->M_operaciones->cargar_perfil($id_usuario);
		$datos['consultorRV1']	= $consultorRV1;
		$this->load->view('lte_header', $datos);
 	    $this->load->view('orden_compra_revisar_remitos', $datos);
	    $this->load->view('lte_footer', $datos);
	}
	public function modificar_control_remitos(){
		$id_orden 			= $this->input->post('id_actual');
		$evaluacion 		= $this->input->post('evaluacion');
		$notas 				= $this->input->post('notas');
		$nombres 			= $this->input->post('nombre');
		$financiamiento 	= $this->input->post('financiamiento');
		if($evaluacion == 'aceptado'){
			$config['upload_path'] = 'uploads/';
		   $config['allowed_types'] = 'gif|jpg|png';
		   $config['max_size'] = '2000';
		   $config['max_width'] = '2024';
		   $config['max_height'] = '2008';
		   		  
			
			$this->load->library('upload', $config);
			//SI LA IMAGEN FALLA AL SUBIR MOSTRAMOS EL ERROR 
			if (!$this->upload->do_upload()) {
				$datos['error'] =  $this->upload->display_errors();
				$this->notificacion = "No se pudo cargar el remito";
				$this->notificacion_error = true;
			} else {
			//EN OTRO CASO SUBIMOS LA IMAGEN, CREAMOS LA MINIATURA Y HACEMOS 
			//ENVÍAMOS LOS DATOS AL MODELO PARA HACER LA INSERCIÓN
				$file_info = $this->upload->data();
				//USAMOS LA FUNCIÓN create_thumbnail Y LE PASAMOS EL NOMBRE DE LA IMAGEN,
				//ASÍ YA TENEMOS LA IMAGEN REDIMENSIONADA
				$this->_create_thumbnail($file_info['file_name']);
				$data = array('upload_data' => $this->upload->data());
				
				$imagen = $file_info['file_name'];
				$comp = $this->M_operaciones->subir_remito($id_orden,$imagen);
				
			}
			if( $financiamiento != 1){
				$resu = $this->M_operaciones->guardar_estado_orden($id_orden,10,'Recibo de remitos firmados por clientes
				- ACEPTADO');
				$estado_orden = 'Backup';
				$asunto='Recibo de remitos firmados por clientes
				- ACEPTADO';
			}else{
				$resu = $this->M_operaciones->guardar_estado_orden($id_orden,9,'Recibo de remitos firmados por clientes - ACEPTADO');
				$estado_orden = 'Pendientes de pago – controles de acreditación clientes financiados';
				$asunto='Recibo de remitos firmados por clientes
				- ACEPTADO';
			}
			
			
			$mensaje = "<p><strong><em>Hola $nombres;</em></strong><br>
			<strong><em><br>
			  Queremos informarte que tu pedido ha sido ACEPTADO correctamente en el Control de Políticas Comerciales y precios; y a través de esta vía lo mantendremos informado del estado de su pedido. Ahora su pedido esta en $estado_orden.</em></strong><br>
			<strong><em><br>
			  Cualquier consulta, podrás llamar a nuestro equipo de Atención al Cliente  marcando +54 1165549839  o escribirnos a&nbsp;</em></strong><a href='mailto:ventas@dvigi.com.ar' target='_blank'><strong><em>ventas@dvigi.com.ar</em></strong></a><strong><em><br>
				Saludos.</em></strong></p>
		  <p><strong><em>&quot;Disfrutá de  agua pura todos los días con DVIGI&quot;</em></strong></p><a href='https://www.tienda.dvigi.com.ar/repuestos_qO27328244XtOcxSM'><img src='https://dvigi-sistema.com/dvigi/api_cron/img/imagen2.png'></a>";
		  $datos_jefe= $this->M_operaciones->miembrosgrupos('Administradores');
			foreach ($datos_jefe->result() as $key) {
				
				$this->sendMailMandril($key->email,'Notificaciones DVIGI', $mensaje);
			}
		}else{
			$resu = $this->M_operaciones->guardar_estado_orden($id_orden,1,'Recibo de remitos firmados por clientes - RECHAZADO: '.$notas);
			$estado_orden = 'RECHAZADO';
			$asunto='Recibo de remitos firmados por clientes - RECHAZADO';

			$mensaje = "<p><strong><em>Hola $nombres;</em></strong><br>
			<strong><em><br>
			  Queremos informarte que tu pedido ha sido RECHAZADO en el Control de Políticas Comerciales y precios; y a través de esta vía le informamos quela causa del rechazo es: $notas. Ahora su pedido esta en $estado_orden.</em></strong><br>
			<strong><em><br>
			  Cualquier consulta, podrás llamar a nuestro equipo de Atención al Cliente  marcando +54 11 47925585 o escribirnos a&nbsp;</em></strong><a href='mailto:consultas@dvigi.com.ar' target='_blank'><strong><em>consultas@dvigi.com.ar</em></strong></a><strong><em><br>
				Saludos.</em></strong></p>
		  <p><strong><em>&quot;Disfrutá de  agua pura todos los días con DVIGI&quot;</em></strong></p><a href='https://www.tienda.dvigi.com.ar/repuestos_qO27328244XtOcxSM'><img src='https://dvigi-sistema.com/dvigi/api_cron/img/imagen2.png'></a>";
		}

		//$email = $this->M_operaciones->obt_mail_orden($id_orden);
		//$this->sendMailMandril($email,'Notificaciones DVIGI', $mensaje);
		$this->control_remitos();

		
	}
	
	public function control_pagos(){
		$resultados 		= $this->M_operaciones->cargar_orden_estado(9);
		$group = array('Revendedores'); 
		if ($this->ion_auth->in_group($group)){
			$resultados 		= $this->M_operaciones->cargar_orden_estado_nac(9);
		}
		$group = array('RevendedoresInt'); 
		if ($this->ion_auth->in_group($group)){
			$resultados 		= $this->M_operaciones->cargar_orden_estado_int(9);
		}
		$datos['controles'] = $resultados;
		$datos['total'] 	= $resultados->num_rows();

		$this->load->view('lte_header', $datos);
 	    $this->load->view('v_listado_control_pagos', $datos);
	    $this->load->view('lte_footer', $datos);
	}
	public function editar_control_pagos($id_orden){
		$orden 				= $this->M_operaciones->cargar_orden_revisar($id_orden);
		$detalles 			= $this->M_operaciones->cargar_orden_revisar_detalle($id_orden);
		$datos['orden'] 	= $orden;
		$datos['detalles'] 	= $detalles;
		$id_usuario = $this->M_operaciones->obt_usuario_de_orden($id_orden);
		$consultorRV1 = $this->M_operaciones->cargar_perfil($id_usuario);
		$datos['consultorRV1']	= $consultorRV1;
		$this->load->view('lte_header', $datos);
 	    $this->load->view('orden_compra_revisar_pagos', $datos);
	    $this->load->view('lte_footer', $datos);
	}
	public function modificar_control_pagos(){
		$id_orden 			= $this->input->post('id_actual');
		$evaluacion 		= $this->input->post('evaluacion');
		$notas 				= $this->input->post('notas');
		$nombres 			= $this->input->post('nombre');
		$financiamiento 	= $this->input->post('financiamiento');
		if($evaluacion == 'aceptado'){
			
			$resu = $this->M_operaciones->guardar_estado_orden($id_orden,10,'Pendientes de pago – controles de acreditación clientes financiados  - ACEPTADO');
			$estado_orden = 'Backup';
			$asunto='Pendientes de pago – controles de acreditación clientes financiados  - ACEPTADO';
			
			$borrar = $this->M_operaciones->borrar_tarjeta($id_orden);
			
			$mensaje = "<p><strong><em>Hola $nombres;</em></strong><br>
			<strong><em><br>
			  Queremos informarte que tu pedido ha sido ACEPTADO correctamente en el Control de Políticas Comerciales y precios; y a través de esta vía lo mantendremos informado del estado de su pedido. Ahora su pedido esta en $estado_orden.</em></strong><br>
			<strong><em><br>
			  Cualquier consulta, podrás llamar a nuestro equipo de Atención al Cliente  marcando +54 1165549839  o escribirnos a&nbsp;</em></strong><a href='mailto:ventas@dvigi.com.ar' target='_blank'><strong><em>ventas@dvigi.com.ar</em></strong></a><strong><em><br>
				Saludos.</em></strong></p>
		  <p><strong><em>&quot;Disfrutá de  agua pura todos los días con DVIGI&quot;</em></strong></p><a href='https://www.tienda.dvigi.com.ar/repuestos_qO27328244XtOcxSM'><img src='https://dvigi-sistema.com/dvigi/api_cron/img/imagen2.png'></a>";
		  $datos_jefe= $this->M_operaciones->miembrosgrupos('Administradores');
			foreach ($datos_jefe->result() as $key) {
				
				$this->sendMailMandril($key->email,'Notificaciones DVIGI', $mensaje);
			}
		}else{
			$resu = $this->M_operaciones->guardar_estado_orden($id_orden,1,'Pendientes de pago – controles de acreditación clientes financiados - RECHAZADO: '.$notas);
			$estado_orden = 'RECHAZADO';
			$asunto='Pendientes de pago – controles de acreditación clientes financiados - RECHAZADO';

			$mensaje = "<p><strong><em>Hola $nombres;</em></strong><br>
			<strong><em><br>
			  Queremos informarte que tu pedido ha sido RECHAZADO en el Control de Políticas Comerciales y precios; y a través de esta vía le informamos quela causa del rechazo es: $notas. Ahora su pedido esta en $estado_orden.</em></strong><br>
			<strong><em><br>
			  Cualquier consulta, podrás llamar a nuestro equipo de Atención al Cliente  marcando +54 1165549839  o escribirnos a&nbsp;</em></strong><a href='mailto:ventas@dvigi.com.ar' target='_blank'><strong><em>ventas@dvigi.com.ar</em></strong></a><strong><em><br>
				Saludos.</em></strong></p>
		  <p><strong><em>&quot;Disfrutá de  agua pura todos los días con DVIGI&quot;</em></strong></p><a href='https://www.tienda.dvigi.com.ar/repuestos_qO27328244XtOcxSM'><img src='https://dvigi-sistema.com/dvigi/api_cron/img/imagen2.png'></a>";
		}

		//$email = $this->M_operaciones->obt_mail_orden($id_orden);
		//$this->sendMailMandril($email,'Notificaciones DVIGI', $mensaje);
		$this->control_pagos();

		
	}

	public function control_backup(){
		$resultados 		= $this->M_operaciones->cargar_orden_estado(10);
		$group = array('Revendedores'); 
		if ($this->ion_auth->in_group($group)){
			$resultados 		= $this->M_operaciones->cargar_orden_estado_nac(10);
		}
		$group = array('RevendedoresInt'); 
		if ($this->ion_auth->in_group($group)){
			$resultados 		= $this->M_operaciones->cargar_orden_estado_int(10);
		}
		$datos['controles'] = $resultados;
		$datos['total'] 	= $resultados->num_rows();

		$this->load->view('lte_header', $datos);
 	    $this->load->view('v_listado_control_backup', $datos);
	    $this->load->view('lte_footer', $datos);
	}
	public function editar_control_backup($id_orden){
		$orden 				= $this->M_operaciones->cargar_orden_revisar($id_orden);
		$detalles 			= $this->M_operaciones->cargar_orden_revisar_detalle($id_orden);
		$datos['orden'] 	= $orden;
		$datos['detalles'] 	= $detalles;
		$id_usuario = $this->M_operaciones->obt_usuario_de_orden($id_orden);
		$consultorRV1 = $this->M_operaciones->cargar_perfil($id_usuario);
		$datos['consultorRV1']	= $consultorRV1;
		$this->load->view('lte_header', $datos);
 	    $this->load->view('orden_compra_revisar_backup', $datos);
	    $this->load->view('lte_footer', $datos);
	}
	public function control_ordenes(){
		$resultados 		= $this->M_operaciones->cargar_ordenes();
		$group = array('Revendedores'); 
		if ($this->ion_auth->in_group($group)){
			$resultados 		= $this->M_operaciones->cargar_ordenes_nac();
		}
		$group = array('RevendedoresInt'); 
		if ($this->ion_auth->in_group($group)){
			$resultados 		= $this->M_operaciones->cargar_ordenes_int();
		}
		$datos['controles'] = $resultados;
		$datos['total'] 	= $resultados->num_rows();

		$this->load->view('lte_header', $datos);
 	    $this->load->view('v_listado_ordenes', $datos);
	    $this->load->view('lte_footer', $datos);
	}
	
	public function control_flujo($id_orden){
		$resultados 		= $this->M_operaciones->cargar_flujo($id_orden);
		$datos['controles'] = $resultados;
		$fechas 			= $this->M_operaciones->cargar_flujo_fechas($id_orden);
		$datos['fechas'] 	= $fechas;

		$this->load->view('lte_header', $datos);
 	    $this->load->view('v_estado_proceso', $datos);
	    $this->load->view('lte_footer', $datos);
	}
	public function control_flujo_fechas($id_orden){
		$resultados 		= $this->M_operaciones->cargar_flujo_fechas($id_orden);
		$datos['controles'] = $resultados;
		

		$this->load->view('lte_header', $datos);
 	    $this->load->view('v_estado_proceso', $datos);
	    $this->load->view('lte_footer', $datos);
	}
	public function obtener_notificaciones($id_usuario)
	{
		$prod = $this->M_operaciones->obt_notificaciones($id_usuario);
        $row = $prod->result();
		echo json_encode($row);  
	}
	public function obtener_notificaciones1()
	{
		$prod = $this->M_configuracion->obt_solicitud_baja();
        $row = $prod->result();
		echo json_encode($row);  
	}
	public function obtener_todas_notificaciones($id_usuario)
	{
		$prod = $this->M_operaciones->obt_todas_notificaciones($id_usuario);
		$datos['notificaciones'] = $prod;
		$datos['total_notificaciones'] = $prod->num_rows();

		$this->load->view('lte_header', $datos);
		$this->load->view('v_listado_notificaciones', $datos);
	   $this->load->view('lte_footer', $datos);
	}
	public function nueva_notificacion()
	{
		$usuarios = $this->M_operaciones->usuarios();
		$datos['usuarios'] = $usuarios;
		$datos['notificacion'] = $this->notificacion ? $this->notificacion : "Especifique los datos:";
		$datos['notificacion_error'] = $this->notificacion_error;
		$datos['modo_edicion'] = false;
		
		$this->load->view('lte_header', $datos);
		$this->load->view('v_nueva_notificacion', $datos);
		$this->load->view('lte_footer', $datos);	
	}
	public function modificar_notificacion($id_notificacion)
    {
		 $id_actual = $this->input->post('id_notificacion');
		 $modificado = $this->M_operaciones->modificar_notificacion($id_notificacion);	
		 $user = $this->ion_auth->user()->row();
		
		$usuario = $user->id;	 
		 $this->obtener_todas_notificaciones($usuario);
		 
		
	}
	public function editar_notificacion($id_notificacion)
    {
		 $resultado = $this->M_operaciones->cargar_notificacion($id_notificacion);
		if ($resultado)
		{
		   $notificacion = $resultado->row();
		   $id_actual =  $notificacion->id;
		   $fecha = $notificacion->fecha;
		   $emisor = $notificacion->origen;
		   $receptor = $notificacion->usuario;
		   $nota = $notificacion->nota;

		   $datos['id_actual']  = $id_actual;
		   $datos['emisor']  	= $emisor;
		   $datos['receptor']  	= $receptor;
		   $datos['fecha']  	= $fecha;
		   $datos['nota']  		= $nota;
		}
		 
		$datos['notificacion'] = $this->notificacion ? $this->notificacion : "Especifique los datos:";
		$datos['notificacion_error'] = $this->notificacion_error;
		$datos['modo_edicion'] = true;
		
		$this->load->view('lte_header', $datos);
		$this->load->view('v_nueva_notificacion', $datos);
		$this->load->view('lte_footer', $datos);
		 
	}
	public function registrar_notificacion()
	{
		$fecha= $this->input->post('fecha');
		$emisor = $this->input->post('emisor');
		$usuarios = $this->input->post('sel_usuarios');
		$nota = $this->input->post('notas');
		
		//print_r($usuarios);die();

		$this->load->library('form_validation');
		 
		$this->form_validation->set_rules('notas', 'Mensaje', 'required');
		$this->form_validation->set_rules('sel_usuarios', 'Destinatario', 'required');
		
		if ($this->form_validation->run() == true )
		{
			$resultado = $this->M_operaciones->agregar_notificacion($usuarios,$fecha,$nota, $emisor);
			
		}else{
			
			$this->notificacion = "ERROR. Faltan datos.";
			$this->notificacion_error = true;
			$usuarios = $this->M_operaciones->usuarios();
			$datos['usuarios'] = $usuarios;
			$this->notificacion = validation_errors();
			$this->notificacion_error = true;
			$datos['notificacion'] = $this->notificacion;
			$datos['notificacion_error'] = $this->notificacion_error;
			$datos['modo_edicion'] = false;
			
			$this->load->view('lte_header', $datos);
			$this->load->view('v_nueva_notificacion', $datos);
			$this->load->view('lte_footer', $datos);
		}		
		$user = $this->ion_auth->user()->row();
		
		$usuario = $user->id;	 
		 $this->obtener_todas_notificaciones($usuario);
	}
	public function alta_revendedor(){
		$datos['notificacion'] = '';
		$datos['notificacion_error'] = false;
		$this->load->view('lte_header', $datos);
		$this->load->view('v_nuevo_revendedor', $datos);
		$this->load->view('lte_footer', $datos);
	}
	public function registrar_mail_revendedor(){
		$email = $this->input->post('email');
		
		$this->load->library('form_validation');
		 
		$this->form_validation->set_rules('email','Email', 'required|valid_email');
		
		if ($this->form_validation->run() == true )
		{
			$valido = $this->M_operaciones->validar_email($email);
			if($valido ==0){
				$pin = mt_rand(100000,999999);
				$resultado = $this->M_operaciones->agregar_mail_revendedor($email,$pin);
				if($resultado==0){
					$this->notificacion = 'Problemas al agregar el usuario';
					$this->notificacion_error = true;
				}else{
					$email1 = str_replace("@","Alt64Al",$email);
					$asunto = 'Alta en sistema DVIGI';
					$cuerpo_mensaje ='Se le ha dado de alta en el sistema de revendedores de DVIGI. Ud deberá entrar en el siguiente <a href='.base_url().'registro_nuevo_revendedor/'.$email1.'/'.$pin.'>link</a> para continuar con su registro en el sistema.';
					
					$this->sendMailMandril($email,$asunto, $cuerpo_mensaje);
					redirect('dashboard_jefe_revendedores');
				}
				
			}else{
				$this->notificacion = 'El correo ya existe en la base de datos';
				$this->notificacion_error = true;
			}
			
		}else{
			
			$this->notificacion = validation_errors();
			$this->notificacion_error = true;
			
		}		
		$datos['notificacion'] = $this->notificacion;
		$datos['notificacion_error'] = $this->notificacion_error;
		$this->load->view('lte_header', $datos);
		$this->load->view('v_nuevo_revendedor', $datos);
		$this->load->view('lte_footer', $datos);
		
	}
	public function activar_revendedor($email,$activation_code)
    {                
        $email1 = str_replace("Alt64Al","@",$email);
        $asunto = 'Activación de cuenta en sistema DVIGI';
		$cuerpo_mensaje ='Para que su cuenta quede activada pinche en el siguiente <a href='.base_url().'activacion_revendedor/'.$email.'/'.$activation_code.'>link</a>';
		
		$this->sendMailMandril($email1,$asunto, $cuerpo_mensaje);
        redirect('informacion');
	}
	public function precio_revendedor(){
		$datos['notificacion'] = '';
		$datos['notificacion_error'] = false;

		$this->load->view('lte_header', $datos);
		$this->load->view('v_productos_rev', $datos);
		$this->load->view('lte_footer', $datos);
	}
	public function obt_ordenes()
	{
		$estado_ordenes 			= $this->M_operaciones->obt_estado_ordenes();	
		$ordenes 					= $this->M_operaciones->obt_ordenes();	
        $datos['estado_ordenes'] 	= $estado_ordenes;
        $datos['ordenes'] 			= $ordenes;
		$datos['total_ordenes'] 	= $ordenes->num_rows();
        
		$this->load->view('lte_header', $datos);
		$this->load->view('v_listado_orden', $datos);
		$this->load->view('lte_footer', $datos);

	}
	public function obt_ordenesint()
	{
		$estado_ordenes 			= $this->M_operaciones->obt_estado_ordenes();	
		$ordenes 					= $this->M_operaciones->obt_ordenes();	
        $datos['estado_ordenes'] 	= $estado_ordenes;
        $datos['ordenes'] 			= $ordenes;
		$datos['total_ordenes'] 	= $ordenes->num_rows();
        
		$this->load->view('lte_header', $datos);
		$this->load->view('v_listado_ordenint', $datos);
		$this->load->view('lte_footer', $datos);

	}
	public function perfil_rev(){
		$datos['notificacion'] = "";
		$datos['notificacion_error'] = false;        
		$datos['provincias'] 		= $this->M_operaciones->provincias();
		$datos['paises'] 			= $this->M_configuracion->obt_paises();
		$datos['municipios'] 			= $this->M_operaciones->municipios();
		$datos['tipo_revendedor'] 		= $this->M_configuracion->obt_tipo_revendedor();
		$user = $this->ion_auth->user()->row();		
		$id_usuario = $user->id;

		$foto = $this->upload_model->tomar_foto($id_usuario);
		if($foto != NULL)
		{
			$datos['foto'] = $foto->ruta;	
		}
		else
		{
			$datos['foto'] = "rodolfo.jpg";	
		}		
		
		$datos['cartera'] = $this->M_operaciones->obt_cartera_revendedor($id_usuario);
		$datos['clientes'] = $this->M_configuracion->obt_clientes_rev($id_usuario);
		$datos['usuario'] = $this->M_operaciones->cargar_perfil($id_usuario);
	  
		// ++++++++++++++
		$misiones = $this->M_configuracion->misiones_propuestas_revendedores($id_usuario);
		$cliente 			= array();		
		$fec_vcto 			= array();
		$en_mision 			= array();
		$en_operacion 		= array();
		$vencimiento 		= array();
		$id_cliente 		= array();		
		

		$total_clientes						= 0;
		$total_clientes_atendidos 			=0;
		$total_misiones_activas 			=0;
		

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
					
				$fec_vcto[$contador] 			= $pr->fecha_vcto;
				$en_mision[$contador] 			= $pr->en_mision;
				$en_operacion[$contador] 		= $pr->en_operacion;
				$vencimiento[$contador]			= $pr->vencimiento*$pr->cantidad;
				$id_cliente[$contador] 			= $pr->id_cliente;
				if($pr->en_mision){
					$total_misiones_activas	= $total_misiones_activas + 1;	
				}
				$total_clientes	= 1;
						
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
								
								
								$fec_vcto[$contador] 			= $pr->fecha_vcto;			
								$vencimiento[$contador]			= $pr->vencimiento;
								
								$anterior_vcto = $actual_vcto;
							}
							
						}
						
					}
					$anterior_prod=$actual_prod;
				}else{// si es otro cliente									
					$contador++;
					$fec_vcto[$contador] 			= $pr->fecha_vcto;
					$en_mision[$contador] 			= $pr->en_mision;
					$en_operacion[$contador] 		= $pr->en_operacion;
					$vencimiento[$contador]			= $pr->vencimiento*$pr->cantidad;
					$id_cliente[$contador] 			= $pr->id_cliente;
					
					$anterior_cli=$actual_cli;
					$anterior_prod=$actual_prod;
					$anterior_vcto=$actual_vcto;
					$total_clientes	= $total_clientes + 1;
					if($pr->en_mision){
						$total_misiones_activas	= $total_misiones_activas + 1;	
					}
				}
			}			
			
		}	
		for ($i=0; $i < count($fec_vcto) ; $i++) { 
			# code...
			
			if($fec_vcto[$i] > date('Y-m-d')){
				$total_clientes_atendidos = $total_clientes_atendidos + 1;
			}
		}
				
		$datos['total_clientes_atendidos'] 	= $total_clientes_atendidos;
		$datos['total_clientes'] 			= $total_clientes;
		$datos['total_misiones_activas'] 	= $total_misiones_activas;
		// +++++++++++++

		$this->load->view('lte_header', $datos);
		$this->load->view('perfil_rev', $datos);
		$this->load->view('lte_footer', $datos);
	}
	public function ver_perfil_rev($id_usuario){
		$datos['notificacion'] = "";
		$datos['notificacion_error'] = false;        
		$datos['provincias'] 		= $this->M_operaciones->provincias();
		$datos['paises'] 			= $this->M_configuracion->obt_paises();
		$datos['municipios'] 			= $this->M_operaciones->municipios();

		$foto = $this->upload_model->tomar_foto($id_usuario);
		if($foto != NULL)
		{
			$datos['foto'] = $foto->ruta;	
		}
		else
		{
			$datos['foto'] = "rodolfo.jpg";	
		}
		$datos['cartera'] = $this->M_operaciones->obt_cartera_revendedor($id_usuario);
		
		$datos['usuario'] = $this->M_operaciones->cargar_perfil($id_usuario);
		$datos['clientes'] = $this->M_operaciones->obt_clientes_rev($id_usuario);
		$datos['tipo_revendedor'] 		= $this->M_configuracion->obt_tipo_revendedor();
		
		// ++++++++++++++
		$misiones = $this->M_configuracion->misiones_propuestas_revendedores($id_usuario);
		$cliente 			= array();		
		$fec_vcto 			= array();
		$en_mision 			= array();
		$en_operacion 		= array();
		$vencimiento 		= array();
		$id_cliente 		= array();		
		

		$total_clientes						= 0;
		$total_clientes_atendidos 			=0;
		$total_misiones_activas 			=0;
		

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
					
				$fec_vcto[$contador] 			= $pr->fecha_vcto;
				$en_mision[$contador] 			= $pr->en_mision;
				$en_operacion[$contador] 		= $pr->en_operacion;
				$vencimiento[$contador]			= $pr->vencimiento*$pr->cantidad;
				$id_cliente[$contador] 			= $pr->id_cliente;
				if($pr->en_mision){
					$total_misiones_activas	= $total_misiones_activas + 1;	
				}
				$total_clientes	= 1;
						
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
								
								
								$fec_vcto[$contador] 			= $pr->fecha_vcto;			
								$vencimiento[$contador]			= $pr->vencimiento;
								
								$anterior_vcto = $actual_vcto;
							}
							
						}
						
					}
					$anterior_prod=$actual_prod;
				}else{// si es otro cliente									
					$contador++;
					$fec_vcto[$contador] 			= $pr->fecha_vcto;
					$en_mision[$contador] 			= $pr->en_mision;
					$en_operacion[$contador] 		= $pr->en_operacion;
					$vencimiento[$contador]			= $pr->vencimiento*$pr->cantidad;
					$id_cliente[$contador] 			= $pr->id_cliente;
					
					$anterior_cli=$actual_cli;
					$anterior_prod=$actual_prod;
					$anterior_vcto=$actual_vcto;
					$total_clientes	= $total_clientes + 1;
					if($pr->en_mision){
						$total_misiones_activas	= $total_misiones_activas + 1;	
					}
				}
			}			
			
		}	
		for ($i=0; $i < count($fec_vcto) ; $i++) { 
			# code...
			
			if($fec_vcto[$i] > date('Y-m-d')){
				$total_clientes_atendidos = $total_clientes_atendidos + 1;
			}
		}
				
		$datos['total_clientes_atendidos'] 	= $total_clientes_atendidos;
		$datos['total_clientes'] 			= $total_clientes;
		$datos['total_misiones_activas'] 	= $total_misiones_activas;
		// +++++++++++++
		
		
		$this->load->view('lte_header', $datos);
		$this->load->view('perfil_rev', $datos);
		$this->load->view('lte_footer', $datos);
	}
	public function registrar_perfil_revendedor(){	
		$user = $this->ion_auth->user()->row();		
		$id_usuario = $user->id;	
		$pin 		    = $this->input->post('pin');
		$nombre 		= $this->input->post('nombre');
		$apellidos 	= $this->input->post('apellidos');
		$empresa 		= 'DVIGI';
		$telefono 		= $this->input->post('telefono');
		$email 		= $this->input->post('email');
		
		$sel_municipios = $this->input->post('sel_municipios');
		$dni 			= $this->input->post('dni');
		$celular 		= $this->input->post('celular');
		$calle 		= $this->input->post('calle');
		$entrecalle1 	= $this->input->post('entrecalle1');
		$entrecalle2 	= $this->input->post('entrecalle2');
		$nro 			= $this->input->post('nro');
		$piso 			= $this->input->post('piso');
		$dpto 			= $this->input->post('dpto');
		$cuit 			= $this->input->post('cuit');
		$codigo_postal = $this->input->post('codigo_postal');

		$sel_tipo_revendedor = $this->input->post('sel_tipo_revendedor');
		$fecha_nacimiento = $this->input->post('fecha_nacimiento');
		$sel_sexo = $this->input->post('sel_sexo');
		$hijos = $this->input->post('hijos');
		
		$this->load->library('form_validation');
		 
		$this->form_validation->set_rules('nombre', 'Nombre', 'required');
		$this->form_validation->set_rules('apellidos', 'Apellidos', 'required');
		$this->form_validation->set_rules('empresa', 'Compañia', 'trim');
		$this->form_validation->set_rules('email', 'email', 'required|valid_email');
		$this->form_validation->set_rules('telefono', 'Teléfono', 'numeric');
		
		$this->form_validation->set_rules('sel_municipios', 'Localidad', 'required');
		$this->form_validation->set_rules('celular', 'Celular', 'numeric');
		$this->form_validation->set_rules('codigo_postal', 'Código Postal', 'required');
		$this->form_validation->set_rules('nro', 'Número', 'required');


		if ($this->form_validation->run() == true )
		{		 
		   
		   $config['upload_path'] = 'uploads/';
		   $config['allowed_types'] = 'gif|jpg|png';
		   $config['max_size'] = '2000';
		   $config['max_width'] = '2024';
		   $config['max_height'] = '2008';
		   		  
			$mensaje = "";
			$result = $this->M_operaciones->act_datos_revendedor($id_usuario, $sel_municipios, $dni, $nombre, $apellidos,  $telefono, $email, $codigo_postal, $calle, $nro, $piso, $dpto, $entrecalle1, $entrecalle2, $fecha_nacimiento, $celular, $cuit,$sel_sexo, $sel_tipo_revendedor, $hijos);
			$result = $this->M_operaciones->act_cliente_revendedor($id_usuario, $sel_municipios, $dni, $nombre, $apellidos,  $telefono, $email, $codigo_postal, $calle, $nro, $piso, $dpto, $entrecalle1, $entrecalle2, $fecha_nacimiento, $celular, $cuit);

			$this->notificacion = "Se ha registrado un nuevo usuario.";
			$this->notificacion_error = false;
			
			
			$this->load->library('upload', $config);
			//SI LA IMAGEN FALLA AL SUBIR MOSTRAMOS EL ERROR 
			if (!$this->upload->do_upload()) {
				$datos['error'] =  $this->upload->display_errors();
				$this->notificacion = "No se pudo cargar la foto";
				$this->notificacion_error = true;
			} else {
			//EN OTRO CASO SUBIMOS LA IMAGEN, CREAMOS LA MINIATURA Y HACEMOS 
			//ENVÍAMOS LOS DATOS AL MODELO PARA HACER LA INSERCIÓN
				$file_info = $this->upload->data();
				//USAMOS LA FUNCIÓN create_thumbnail Y LE PASAMOS EL NOMBRE DE LA IMAGEN,
				//ASÍ YA TENEMOS LA IMAGEN REDIMENSIONADA
				$this->_create_thumbnail($file_info['file_name']);
				$data = array('upload_data' => $this->upload->data());
				$titulo = $this->input->post('nombre');
				$imagen = $file_info['file_name'];
				$comp = $this->upload_model->tomar_foto($id_usuario);
				if(count($comp) > 0){
					$this->upload_model->modificar($id_usuario,$titulo,$imagen);
				}else{
					  $this->upload_model->subir($id_usuario,$titulo,$imagen);
				     }	
			}
				
			redirect('dashboard_revendedores', 'refresh');
			
				
		}
		else
		{
			$this->notificacion = validation_errors();
			$this->notificacion_error = true;
			$datos['notificacion'] = $this->notificacion;
			$datos['notificacion_error'] = $this->notificacion_error;
			$datos['email']  		= $email;
			
		   $datos['provincias'] 		= $this->M_operaciones->provincias();

		   $datos['usuario'] = $this->M_operaciones->cargar_perfil($id_usuario);
        
			$this->load->view('lte_header', $datos);
			$this->load->view('perfil_rev', $datos);
			$this->load->view('lte_footer', $datos);
		}		
		
	}
	function _create_thumbnail($filename){
        $config['image_library'] = 'gd2';
        //CARPETA EN LA QUE ESTÁ LA IMAGEN A REDIMENSIONAR
        $config['source_image'] = 'uploads/'.$filename;
        $config['create_thumb'] = TRUE;
        $config['maintain_ratio'] = TRUE;
        //CARPETA EN LA QUE GUARDAMOS LA MINIATURA
        $config['new_image']='uploads/thumbs/';
        $config['width'] = 150;
        $config['height'] = 150;
        $this->load->library('image_lib', $config); 
        $this->image_lib->resize();
	}
	public function consultor_rev(){
		$group = array('Revendedores'); 
		if ($this->ion_auth->in_group($group)){
			$clientes = $this->M_operaciones->obt_revendedores();
			
		}
		$group = array('RevendedoresInt'); 
		if ($this->ion_auth->in_group($group)){
			$clientes = $this->M_operaciones->obt_revendedores_int();
		}
		
		$total_cartera = $this->M_operaciones->obt_revendedores_cartera();
		$cartera_atendida = $this->M_operaciones->obt_revendedores_cartera_atendida();
		$id_cliente = array();
		$cartera_cliente = array();
		$con=0;
		foreach ($clientes->result() as $key) {
			# code...
			$id_cliente[$con] = $key->id_usuario;
			$cartera_cliente[$con] = 0;
			$total =0;
			$vencido =0;
			
			foreach ($total_cartera->result() as $tot) {
				# code...
				if($key->id_usuario == $tot->id_usuario){
					$total = $tot->total_cartera;
				}
			}
			foreach ($cartera_atendida->result() as $tot) {
				# code...
				if($key->id_usuario == $tot->id_usuario){
					$vencido = $tot->total_cartera_atendida;
				}
			}
			if($total>0){
				$cartera_cliente[$con] = $vencido*100/$total;
			}else{
				$cartera_cliente[$con] =0;
			}
			

			$con=$con + 1;
		}
		
		$datos['clientes'] = $clientes;
		$datos['cartera_cliente'] = $cartera_cliente;
		
		$this->load->view('lte_header', $datos);
		$this->load->view('v_listado_consultor_rev', $datos);
		$this->load->view('lte_footer', $datos);
	}
	
	public function stock_rev(){
		$user = $this->ion_auth->user()->row();		
		$id_usuario = $user->id;
		$datos['id_usuario'] = $user->id;
		$group = array('ConsultorRVInt'); 
		if ($this->ion_auth->in_group($group)){
			
			$id_pais = $this->M_operaciones->obt_rev_pais($id_usuario);
			$datos['precios'] = $this->M_operaciones->obt_rev_int_precios($id_pais);

		}
		$productos = $this->M_operaciones->cargar_stock($id_usuario);
		$productos_all = $this->M_configuracion->obt_productos_rev();
		$datos['productos'] = $productos;
		$datos['productos_all'] = $productos_all;
		$datos['total_productos'] = $productos->num_rows();
		$this->load->view('lte_header', $datos);
		$this->load->view('v_listado_stock', $datos);
		$this->load->view('lte_footer', $datos);
	}
	public function stock_revint(){
		$user = $this->ion_auth->user()->row();		
		$id_usuario = $user->id;
		$datos['id_usuario'] = $user->id;
		$group = array('ConsultorRVInt'); 
		if ($this->ion_auth->in_group($group)){
			
			$id_pais = $this->M_operaciones->obt_rev_pais($id_usuario);
			$datos['precios'] = $this->M_operaciones->obt_rev_int_precios($id_pais);

		}
		$productos = $this->M_operaciones->cargar_stock($id_usuario);
		$productos_all = $this->M_configuracion->obt_productos_rev();
		$datos['productos'] = $productos;
		$datos['productos_all'] = $productos_all;
		$datos['total_productos'] = $productos->num_rows();
		$this->load->view('lte_header', $datos);
		$this->load->view('v_listado_stockint', $datos);
		$this->load->view('lte_footer', $datos);
	}
	public function ver_orden($id_orden){
		$orden 				= $this->M_operaciones->cargar_orden_revisar($id_orden);
		$detalles 			= $this->M_operaciones->cargar_orden_revisar_detalle($id_orden);
		$datos['orden'] 	= $orden;
		$datos['detalles'] 	= $detalles;
		$id_usuario = $this->M_operaciones->obt_usuario_de_orden($id_orden);
		$consultorRV1 = $this->M_operaciones->cargar_perfil($id_usuario);
		$datos['consultorRV1']	= $consultorRV1;
		$this->load->view('lte_header', $datos);
 	    $this->load->view('orden_compra_ver', $datos);
	    $this->load->view('lte_footer', $datos);
	}
	public function ver_ordenint($id_orden){
		$orden 				= $this->M_operaciones->cargar_orden_revisar($id_orden);
		$detalles 			= $this->M_operaciones->cargar_orden_revisar_detalle($id_orden);
		$datos['orden'] 	= $orden;
		$datos['detalles'] 	= $detalles;
		$id_usuario = $this->M_operaciones->obt_usuario_de_orden($id_orden);
		$consultorRV1 = $this->M_operaciones->cargar_perfil($id_usuario);
		$datos['consultorRV1']	= $consultorRV1;
		$this->load->view('lte_header', $datos);
 	    $this->load->view('orden_compra_ver', $datos);
	    $this->load->view('lte_footer', $datos);
	}
	public function editar_productos_precios_rev_int($id_producto)
	{
		$resultado = $this->M_configuracion->obt_producto($id_producto);
		
		if ($resultado)
		{
		   $producto = $resultado->row();

		   $id_producto 	= $id_producto;
		   $nombre 			= $producto->nombre;
		   $precio 			= $producto->precio;
		   $precio_rev		= $producto->precio_rev;
		   $precio_may		= $producto->precio_mayorista;
		   $existencia 		= $producto->existencia;
		   $es_repuesto 	= $producto->es_repuesto;
		   $vencimiento 	= $producto->vencimiento;
		   $alto 			= $producto->alto;
		   $ancho 			= $producto->ancho;
		   $largo 			= $producto->largo;
		   $peso 			= $producto->peso;
		   $sku 			= $producto->sku;
		   $codigo_barra 	= $producto->codigo_barra;
		   $id_categoria   	= $producto->id_categoria;
		   $valor_declarado = $producto->valor_declarado;
		   $dum14 			= $producto->dum14;
		   		   
		   $datos['modo_edicion'] = true;
		   $datos['notificacion'] = 'Modificando los datos del producto: '  . $nombre;
		   $datos['notificacion_error'] = $this->notificacion_error;
		   
		   $datos['id_actual']    	= $id_producto;
		   $datos['id_producto']  	= $id_producto;
		   $datos['nombre']  		= $nombre;
		   $datos['precio']       	= $precio;
		   $datos['precio_rev']    	= $precio_rev;
		   $datos['precio_may']    	= $precio_may;
		   $datos['existencia']     = $existencia;
		   $datos['es_repuesto'] 	= $es_repuesto;
		   $datos['vencimiento']  	= $vencimiento;
		   $datos['alto']       	= $alto;
		   $datos['ancho']       	= $ancho;
		   $datos['largo'] 			= $largo;
		   $datos['peso']  			= $peso;
		   $datos['sku'] 			= $sku;
		   $datos['codigo_barra']  	= $codigo_barra;
		   $datos['id_categoria']  	= $id_categoria;
		   $datos['valor_declarado']= $valor_declarado;
		   $datos['dum14'] 			= $dum14;
		}


		$resultado = $this->M_configuracion->obt_paises();
		$datos['paises'] = $resultado;
		$productos_paises = $this->M_operaciones->obt_productos_paises($id_producto);
		$datos['productos_paises'] = $productos_paises;

		$datos['modo_edicion'] = true;
		$datos['notificacion'] = 'Asignándole precios a los productos por paises: ';

		$this->load->view('lte_header', $datos);
 	    $this->load->view('v_productos_paises_rev', $datos);
	    $this->load->view('lte_footer', $datos);
	}
	public function editar_combos_precios_rev_int($id_combo)
	{
		$resultado = $this->M_configuracion->obt_combo($id_combo);
		
		if ($resultado)
		{
		   $producto = $resultado->row();

		   $id_producto 	= $id_combo;
		   $nombre 			= $producto->nombre;
		   $precio_may 		= $producto->precio_mayorista;
		   $precio_rev 		= $producto->precio_rev;
		   $min_rev 		= $producto->cant_min_rev;
		   $min_may 		= $producto->cant_min_may;
		   $existencia 		= $producto->existencia;
		   $alto 			= $producto->alto;
		   $ancho 			= $producto->ancho;
		   $largo 			= $producto->largo;
		   $peso 			= $producto->peso;
		   $sku 			= $producto->sku;
		   $codigo_barra 	= $producto->codigo_barra;
		   $id_categoria   	= $producto->id_categoria;
		   $valor_declarado = $producto->valor_declarado;
		   $dum14 			= $producto->dum14;
		   $imagen			= $producto->imagen;		   
		   $datos['modo_edicion'] = true;
		   $datos['notificacion'] = 'Modificando los datos del producto: '  . $nombre;
		   $datos['notificacion_error'] = $this->notificacion_error;
		   
		   $datos['id_actual']    	= $id_combo;
		   $datos['id_combo']  	= $id_combo;
		   $datos['nombre']  		= $nombre;
		   $datos['precio_may']     = $precio_may;
		   $datos['precio_rev']     = $precio_rev;
		   $datos['min_rev']     	= $min_rev;
		   $datos['min_may']     	= $min_may;
		   $datos['existencia']     = $existencia;
		   $datos['alto']       	= $alto;
		   $datos['ancho']       	= $ancho;
		   $datos['largo'] 			= $largo;
		   $datos['peso']  			= $peso;
		   $datos['sku'] 			= $sku;
		   $datos['codigo_barra']  	= $codigo_barra;
		   $datos['id_categoria']  	= $id_categoria;
		   $datos['valor_declarado']= $valor_declarado;
		   $datos['dum14'] 			= $dum14;
		   $datos['imagen'] 		= $imagen;
		}


		$resultado = $this->M_configuracion->obt_paises();
		$datos['paises'] = $resultado;
		$combos_paises = $this->M_operaciones->obt_combos_paises($id_combo);
		$datos['combos_paises'] = $combos_paises;

		$datos['modo_edicion'] = true;
		$datos['notificacion'] = 'Asignándole precios a los productos por paises: ';

		$this->load->view('lte_header', $datos);
 	    $this->load->view('v_combos_paises_rev', $datos);
	    $this->load->view('lte_footer', $datos);
	}
	public function editar_factura_rev_int($id_factura)
	{
		$resultado = $this->M_configuracion->obt_factura($id_factura);
		
		if ($resultado)
		{
		   $factura = $resultado->row();

		   $id_factura 	= $factura->id;
		   $nombre 			= $factura->nombre;
		   		   
		   $datos['modo_edicion'] = true;
		   $datos['notificacion'] = 'Modificando los datos del producto: '  . $nombre;
		   $datos['notificacion_error'] = $this->notificacion_error;
		   
		   $datos['id_actual']    	= $id_factura;
		   $datos['id_factura']  	= $id_factura;
		   $datos['nombre']  		= $nombre;
		   
		}


		$resultado = $this->M_configuracion->obt_paises();
		$datos['paises'] = $resultado;
		$facturas_paises = $this->M_operaciones->obt_facturas_paises($id_factura);
		$datos['facturas_paises'] = $facturas_paises;

		$datos['modo_edicion'] = true;
		$datos['notificacion'] = 'Asignando los paises para este tipo de factura: ';

		$this->load->view('lte_header', $datos);
 	    $this->load->view('v_facturas_paises_rev', $datos);
	    $this->load->view('lte_footer', $datos);
	}
	public function agregar_producto_paises_rev()
	{
		$id_producto= $this->input->post('id_producto');
		$id_pais = $this->input->post('sel_paises');
		$precio = $this->input->post('precio');
		$min_rev = $this->input->post('min_rev');
		$precio_may = $this->input->post('precio_may');
		$min_may = $this->input->post('min_may');
		$resultado = $this->M_operaciones->agregar_producto_paises_rev($id_producto,$id_pais,$precio,$precio_may,$min_rev, $min_may);
		$this->editar_productos_precios_rev_int($id_producto);
	}
	public function agregar_combo_paises_rev()
	{
		$id_combo= $this->input->post('id_combo');
		$id_pais = $this->input->post('sel_paises');
		$precio = $this->input->post('precio');
		$min_rev = $this->input->post('min_rev');
		$precio_may = $this->input->post('precio_may');
		$min_may = $this->input->post('min_may');
		$resultado = $this->M_operaciones->agregar_combo_paises_rev($id_combo,$id_pais,$precio, $precio_may,$min_rev, $min_may);
		$this->editar_combos_precios_rev_int($id_combo);
	}
	public function agregar_factura_paises_rev()
	{
		$id_factura= $this->input->post('id_factura');
		$id_pais = $this->input->post('sel_paises');
		$resultado = $this->M_operaciones->agregar_factura_paises_rev($id_factura,$id_pais);
		$this->editar_factura_rev_int($id_factura);
	}
	public function cfe_producto_pais_rev($id_producto, $id_pais)
	{
		$datos['id_producto'] = $id_producto;
		$datos['id_pais'] = $id_pais;
		
		$this->load->view('lte_header', $datos);
 	    $this->load->view('vcan_productos_paises_rev', $datos);
	    $this->load->view('lte_footer', $datos);
	}
	public function cfe_combo_pais_rev($id_combo, $id_pais)
	{
		$datos['id_combo'] = $id_combo;
		$datos['id_pais'] = $id_pais;
		
		$this->load->view('lte_header', $datos);
 	    $this->load->view('vcan_combos_paises_rev', $datos);
	    $this->load->view('lte_footer', $datos);
	}
	public function cfe_factura_pais_rev($id_factura, $id_pais)
	{
		$datos['id_factura'] = $id_factura;
		$datos['id_pais'] = $id_pais;
		
		$this->load->view('lte_header', $datos);
 	    $this->load->view('vcan_facturas_paises_rev', $datos);
	    $this->load->view('lte_footer', $datos);
	}
	public function cancelar_producto_pais_rev()
	{
		$id_producto = $this->input->post('id_producto');
		$id_pais = $this->input->post('id_pais');

		$cancelado = $this->M_operaciones->cancelar_producto_pais_rev($id_producto, $id_pais);
		
		if ($cancelado == 1)
	    { 
		   $this->not_fcliente = "Se eliminó el país correctamente.";
		}
		else
		{
		   $this->not_fcliente = "ERROR. No se pudo eliminar el país. Verifique los datos especificados.";
		}
		
		$this->editar_productos_precios_rev_int($id_producto);

	}
	public function cancelar_combo_pais_rev()
	{
		$id_combo = $this->input->post('id_combo');
		$id_pais = $this->input->post('id_pais');

		$cancelado = $this->M_operaciones->cancelar_combo_pais_rev($id_combo, $id_pais);
		
		if ($cancelado == 1)
	    { 
		   $this->not_fcliente = "Se eliminó el país correctamente.";
		}
		else
		{
		   $this->not_fcliente = "ERROR. No se pudo eliminar el país. Verifique los datos especificados.";
		}
		
		$this->editar_combos_precios_rev_int($id_combo);

	}
	public function cancelar_factura_pais_rev()
	{
		$id_factura = $this->input->post('id_factura');
		$id_pais = $this->input->post('id_pais');

		$cancelado = $this->M_operaciones->cancelar_factura_pais_rev($id_factura, $id_pais);
		
		if ($cancelado == 1)
	    { 
		   $this->not_fcliente = "Se eliminó el país correctamente.";
		}
		else
		{
		   $this->not_fcliente = "ERROR. No se pudo eliminar el país. Verifique los datos especificados.";
		}
		
		$this->editar_factura_rev_int($id_factura);

	}
	public function modificar_existencia_producto(){
		$id_producto = $this->input->post('id_producto1');
		$existencia = $this->input->post('existencia');
		$user = $this->ion_auth->user()->row();		
		$id_usuario = $user->id;

		$resultado = $this->M_operaciones->actualizar_existencia($id_producto, $id_usuario, $existencia);
		$this->stock_rev();
	}
	public function modificar_existencia_productoint(){
		$id_producto = $this->input->post('id_producto1');
		$existencia = $this->input->post('existencia');
		$user = $this->ion_auth->user()->row();		
		$id_usuario = $user->id;

		$resultado = $this->M_operaciones->actualizar_existencia($id_producto, $id_usuario, $existencia);
		$this->stock_revint();
	}
	public function modificar_precio_producto(){
		$id_producto = $this->input->post('id_producto2');
		$precio = $this->input->post('precio');
		$user = $this->ion_auth->user()->row();		
		$id_usuario = $user->id;

		$resultado = $this->M_operaciones->actualizar_precio($id_producto, $id_usuario, $precio);
		$this->stock_rev();
	}
	public function subir_excell(){
		$datos['filtro1']  	= '1';
		$this->load->view('lte_header', $datos);
		$this->load->view('import', $datos);
		$this->load->view('lte_footer', $datos);
		
	}
	public function subir_imagen_combo($id_producto){	
		$datos['id_producto']  	= $id_producto;	
		$this->load->view('lte_header', $datos);
		$this->load->view('import_combo_rev', $datos);
		$this->load->view('lte_footer', $datos);
		
	}
	public function subir_excell_rev(){
		$datos['filtro1']  	= '1';
		$this->load->view('lte_header', $datos);
		$this->load->view('import_rev', $datos);
		$this->load->view('lte_footer', $datos);
		
	}
	public function to_mysql()
	{	
		//obtenemos el archivo subido mediante el formulario
		$file = $_FILES['excel']['name'];
	
		//comprobamos si existe un directorio para subir el excel
		//si no es así, lo creamos
		if(!is_dir("./excel_files/")) 
			mkdir("./excel_files/", 0777);
	
		//comprobamos si el archivo ha subido para poder utilizarlo
		if ($file && copy($_FILES['excel']['tmp_name'],"./excel_files/".$file))
		{
	
			//queremos obtener la extensión del archivo
			$trozos = explode(".", $file);
		
			//solo queremos archivos excel
			if($trozos[1] != "xlsx" && $trozos[1] != "xls") return;
	
			/** archivos necesarios */
			require_once APPPATH . 'libraries/Classes/PHPExcel.php';
			require_once APPPATH . 'libraries/Classes/PHPExcel/Reader/Excel2007.php';
		
			//creamos el objeto que debe leer el excel
			$objReader = new PHPExcel_Reader_Excel2007();
			$objPHPExcel = $objReader->load("./excel_files/".$file);
	
			//número de filas del archivo excel
			$rows = $objPHPExcel->getActiveSheet()->getHighestRow();   
		
			//obtenemos el nombre de la tabla que el usuario quiere insertar el excel
			$table_name = trim($this->security->xss_clean($this->input->post("table")));  
		
			//obtenemos los nombres que el usuario ha introducido en el campo text del formulario,
			//se supone que deben ser los campos de la tabla de la base de datos.
			$fields_table = explode(",", $this->security->xss_clean($this->input->post("fields")));
		
			//inicializamos sql como un array
			$sql = array();
	
			//array con las letras de la cabecera de un archivo excel
			$letras = array(
				"A","B","C","D","E","F","G",
				"H","I","J","Q","L","M","N",
				"O","P","Q","R","S","T","U",
				"V","W","X","Y","Z"
			);
		
			//recorremos el excel y creamos un array para después insertarlo en la base de datos
			for($i = 2;$i <= $rows; $i++)
			{
				//ahora recorremos los campos del formulario para ir creando el array de forma dinámica
				for($z = 0; $z < count($fields_table); $z++)
				{
				$sql[$i][trim($fields_table[$z])] = $objPHPExcel->getActiveSheet()->getCell($letras[$z].$i)->getCalculatedValue();
				}
			}   
	
			/*echo "<pre>";
			var_dump($sql); exit();
			*/
		
			//cargamos el modelo
			
			//insertamos los datos del excel en la base de datos
			$import_excel = $this->M_operaciones->excel($table_name,$sql);
			
			//comprobamos si se ha guardado bien
			if($import_excel == TRUE)
			{
				$notificacion= "El archivo ha sido importado correctamente";
			}else{
				$notificacion= "Ha ocurrido un error";
			}
			$datos['notificacion'] = $notificacion;
			$this->load->view('lte_header', $datos);
 	    	$this->load->view('alertas', $datos);
	    	$this->load->view('lte_footer', $datos);
			//finalmente, eliminamos el archivo pase lo que pase
			unlink("./excel_files/".$file);
	
		}else{
			echo "Debes subir un archivo";
		}
	}
	public function to_combo()
	{	
		$id_actual = $this->input->post('id_producto');
		//obtenemos el archivo subido mediante el formulario
		$file = $_FILES['imagen']['name'];
	
		//comprobamos si existe un directorio para subir el excel
		//si no es así, lo creamos
		if(!is_dir("./combo_files/")) 
			mkdir("./combo_files/", 0777);
	
		//comprobamos si el archivo ha subido para poder utilizarlo
		if ($file && copy($_FILES['imagen']['tmp_name'],"./combo_files/".$file))
		{
			//finalmente, eliminaguardamos  el archivo pase lo que pase
			$path = "combo_files/".$file;
			$res = $this->M_configuracion->guardar_img_combo($id_actual, $path);
			redirect('editar_combo_rev/'.$id_actual);	
	
		}else{
			echo "Debes subir una imagen";
		}
	}
	public function to_mysql_rev()
	{	
		//obtenemos el archivo subido mediante el formulario
		$file = $_FILES['excel']['name'];
	
		//comprobamos si existe un directorio para subir el excel
		//si no es así, lo creamos
		if(!is_dir("./excel_files/")) 
			mkdir("./excel_files/", 0777);
	
		//comprobamos si el archivo ha subido para poder utilizarlo
		if ($file && copy($_FILES['excel']['tmp_name'],"./excel_files/".$file))
		{
	
			//queremos obtener la extensión del archivo
			$trozos = explode(".", $file);
		
			//solo queremos archivos excel
			if($trozos[1] != "xlsx" && $trozos[1] != "xls") return;
	
			/** archivos necesarios */
			require_once APPPATH . 'libraries/Classes/PHPExcel.php';
			require_once APPPATH . 'libraries/Classes/PHPExcel/Reader/Excel2007.php';
		
			//creamos el objeto que debe leer el excel
			$objReader = new PHPExcel_Reader_Excel2007();
			$objPHPExcel = $objReader->load("./excel_files/".$file);
	
			//número de filas del archivo excel
			$rows = $objPHPExcel->getActiveSheet()->getHighestRow();   
		
			//obtenemos el nombre de la tabla que el usuario quiere insertar el excel
			$table_name = trim('clientes');  
		
			//obtenemos los nombres que el usuario ha introducido en el campo text del formulario,
			//se supone que deben ser los campos de la tabla de la base de datos.
			$fields_table = explode(",", 'dni,nombre,apellidos,telefono,email,codigo_postal,calle,nro,piso,dpto,entrecalle1,entrecalle2,celular,observaciones,cuit,
			fecha_venta,producto,cantidad');
		
			//inicializamos sql como un array
			$sql = array();
	
			//array con las letras de la cabecera de un archivo excel
			$letras = array(
				"A","B","C","D","E","F","G",
				"H","I","J","K","L","M","N",
				"O","P","Q","R","S","T","U",
				"V","W","X","Y","Z"
			);
		
			//recorremos el excel y creamos un array para después insertarlo en la base de datos
			for($i = 3;$i <= $rows; $i++)
			{
				//ahora recorremos los campos del formulario para ir creando el array de forma dinámica
				for($z = 0; $z < count($fields_table); $z++)
				{
				$sql[$i][trim($fields_table[$z])] = $objPHPExcel->getActiveSheet()->getCell($letras[$z].$i)->getCalculatedValue();
				}
				//$sql[$i][trim('id_municipio')] = 1
			}   
			$user = $this->ion_auth->user()->row();
			$usuario = $user->id;
			$municipio_rev = $this->M_operaciones->get_municipio($usuario);
			$error = array();
			$con1=0;
			$import_excel = FALSE;
			for ($i=3; $i <count($sql)+3 ; $i++) { 
				# code...
				if($sql[$i]['nombre'] == '') break;
				$nombre = str_replace("'","´",$sql[$i]['nombre']);
				$apellidos = str_replace("'","´",$sql[$i]['apellidos']);
				if($apellidos=='' || $sql[$i]['codigo_postal']=='' || $sql[$i]['dni']=='' || $sql[$i]['calle']=='' || $sql[$i]['nro']=='' || $sql[$i]['fecha_venta']=='' || $sql[$i]['cantidad']==''){
					$error[$con1]='No se insertó el cliente '.$nombre.' '.$apellidos.' pues le falta algunos de estos datos: Nombre,apellido,codigo postal,dni, calle, número,fecha venta o cantidad';
					$con1++;
					
					break;
				}
				$clie = $this->M_operaciones->set_cliente_rev($sql[$i]['dni'],$nombre, $apellidos, $sql[$i]['telefono'],$sql[$i]['email'],$sql[$i]['codigo_postal'],$sql[$i]['calle'],$sql[$i]['nro'],
				$sql[$i]['piso'],$sql[$i]['dpto'],$sql[$i]['entrecalle1'],$sql[$i]['entrecalle2'],$sql[$i]['celular'],$sql[$i]['observaciones'],$sql[$i]['cuit'],$municipio_rev, $usuario);

				$pedido = $this->M_operaciones->set_pedido_rev($clie, $usuario,  $sql[$i]['fecha_venta']); 
					
				$import_excel = $this->M_operaciones->set_detalle_rev($pedido, $sql[$i]['producto'], $sql[$i]['cantidad']);
			}   
	
			
			if($import_excel == TRUE)
			{
				$notificacion= "El archivo ha sido importado correctamente";
			}else{
				$notificacion= "Ha ocurrido un error";
			}

			$datos['error'] = $error;
			$datos['con1'] = $con1;
			$datos['notificacion'] = $notificacion;
			$this->load->view('lte_header', $datos);
 	    	$this->load->view('alertas_carga', $datos);
	    	$this->load->view('lte_footer', $datos);
			//finalmente, eliminamos el archivo pase lo que pase
			unlink("./excel_files/".$file);
	
		}else{
			echo "Debes subir un archivo";
		}
	}
	public function carga_productos(){
		$carga1 = $this->M_operaciones->carga_productos();

		if($carga1 == TRUE)
		{
			$notificacion= "El archivo ha sido importado correctamente";
		}else{
			$notificacion= "Ha ocurrido un error";
		}
		$datos['notificacion'] = $notificacion;
		$this->load->view('lte_header', $datos);
		$this->load->view('alertas', $datos);
		$this->load->view('lte_footer', $datos);
	}
	public function carga_clientes(){
		$carga1 = $this->M_operaciones->carga_clientes();

		if($carga1 == TRUE)
		{
			$notificacion= "El archivo ha sido importado correctamente";
		}else{
			$notificacion= "Ha ocurrido un error";
		}
		$datos['notificacion'] = $notificacion;
		$this->load->view('lte_header', $datos);
		$this->load->view('alertas', $datos);
		$this->load->view('lte_footer', $datos);
	}
	public function clientes_nuevos()
	{
		$clientes = $this->M_operaciones->clientes_nuevos();
		$datos['clientes'] = $clientes;
		$datos['total_clientes'] = $clientes->num_rows();
		$this->load->view('lte_header', $datos);
		$this->load->view('v_clientes_nuevos', $datos);
		$this->load->view('lte_footer', $datos);
	}
	public function productos_mas_vendidos()
	{
		$anno = date('Y');
		$mes = date('m');
		$dia= date('d');
		$productos_hoy = $this->M_operaciones->productos_mas_vendido($anno,$mes,$dia);
		$datos['productos_hoy'] = $productos_hoy;
		$fecha = date('Y-m-d H:i:s');
		$datos['fecha'] = $fecha;
		$productos_fil = $this->M_operaciones->productos_mas_vendido(fechatoAnno($fecha),fechatoMes($fecha),fechatoDia($fecha));
		$datos['productos_fil'] = $productos_fil;
		$this->load->view('lte_header', $datos);
		$this->load->view('v_productos_vendidos', $datos);
		$this->load->view('lte_footer', $datos);
	}
	public function productos_mas_vendidos_filtrado()
	{
		$anno = date('Y');
		$mes = date('m');
		$dia= date('d');
		$productos_hoy = $this->M_operaciones->productos_mas_vendido($anno,$mes,$dia);
		$datos['productos_hoy'] = $productos_hoy;

		$fecha = $this->input->post('fecha');
		$datos['fecha'] = $fecha;		
		$productos_fil = $this->M_operaciones->productos_mas_vendido(fechatoAnno($fecha),fechatoMes($fecha),fechatoDia($fecha));
		$datos['productos_fil'] = $productos_fil;
		
		$this->load->view('lte_header', $datos);
		$this->load->view('v_productos_vendidos', $datos);
		$this->load->view('lte_footer', $datos);
	}
	public function seguimiento_oca($no_factura, $cod_seguimiento){
		$oca 	= new Oca($cuit = '30-69511732-5', 71243);
		$segui = $oca->trackingPieza($pieza = $cod_seguimiento, $nroDocumentoCliente = $no_factura);
		/*$segui=  array(  array( "NumeroEnvio"=>  "3790700000000008466", 
			"Descripcion_Motivo"=>  "Sin Motivo", 
			"Desdcripcion_Estado"=> "En proceso de Retiro - Suc: PLANTA VELEZ SARSFIELD",
			 "SUC"=>  "Suc: PLANTA VELEZ SARSFIELD" ,
			"fecha"=>  "2018-05-12T00:00:00-03:00"),array( "NumeroEnvio"=>  "3790700000000008466", 
			"Descripcion_Motivo"=>  "Sin Motivo", 
			"Desdcripcion_Estado"=> "En proceso de Retiro - Suc: PLANTA VELEZ SARSFIELD",
			 "SUC"=>  "Suc: PLANTA VELEZ SARSFIELD" ,
			"fecha"=>  "2018-05-12T00:00:00-03:00"))	;*/
			$datos['seguimiento'] = $segui;
		
		$this->load->view('lte_header', $datos);
 	    $this->load->view('v_estado_seguimiento', $datos);
	    $this->load->view('lte_footer', $datos);
	}
	public function registrar_equivocado()
	{
		$id_cliente = $this->input->post('id_cliente_equivocado');
		$tel_equivocado = $this->input->post('tel_equivocado');
		$email_equivocado = $this->input->post('email_equivocado');

		$user = $this->ion_auth->user()->row();
		$observ ='Datos de contacto equivocado';
		
		if($email_equivocado && $tel_equivocado){
			$resul= $this->M_operaciones->borrar_cliente($id_cliente);
			redirect('misiones_propuestas_filtradas');
			//header ("Location: ". base_url()."misiones_propuestas_filtradas");
		}else{
			
			if($tel_equivocado && !$email_equivocado){
				$observ ='Datos del teléfono del contacto equivocado';
				$resul= $this->M_operaciones->set_llamadas($user->id,$id_cliente,  $observ);
				$regis = $this->M_configuracion->registrar_notas_clientes($id_cliente, $observ, $user->id);
			}else{
				if(!$tel_equivocado && $email_equivocado){
					$observ ='Datos del mail del contacto equivocado';
					$resul= $this->M_operaciones->set_llamadas($user->id,$id_cliente,  $observ);
					$regis = $this->M_configuracion->registrar_notas_clientes($id_cliente, $observ, $user->id);
				}	
			}
		}
		
		header ("Location: ". base_url()."cartera_historial/".$id_cliente);
		
	}
}
?>