<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_configuracion extends CI_Controller {

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

		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->helper('url');
        $this->load->model('modelogeneral');
		$this->load->model( 'M_operaciones', '', TRUE );
		$this->load->model( 'M_configuracion', '', TRUE );
		$this->load->model( 'M_dashboard', '', TRUE );
		$this->load->model('upload_model');
	
			
    }
	
	// ------------------------------------------------------
    public function index()
	{}
	
	
	/*
	 * ------------------------------------------------------
	 *  GESTIÓN CLIENTES
	 * ------------------------------------------------------
	 */
	
	// ------------------------------------------------------
	// Clientes
	
    public function clientes()
	{
		$clientes = $this->M_configuracion->clientes_all();	
        $datos['clientes'] = $clientes;
		$datos['total_clientes'] = $this->M_configuracion->total_clientes();
		$datos['total_clientes_mision'] = $this->M_configuracion->total_clientes_mision();
		$datos['total_clientes_operacion'] = $this->M_configuracion->total_clientes_operacion();
		$datos['total_clientes_cancelados'] = $this->M_configuracion->total_clientes_cancelados();
		$datos['niveles'] = $this->M_configuracion->obt_niveles_vip();

		$this->load->view('lte_header', $datos);
		$this->load->view('v_listado_clientes1', $datos);
		$this->load->view('lte_footer', $datos);
	}
	public function clientes_vip()
	{
		$clientes = $this->M_configuracion->clientes_vip();	
		$datos['clientes'] = $clientes;
		$misiones_activas = $this->M_configuracion->obt_mision_activas();	
        $datos['misiones_activas'] = $misiones_activas;
		$datos['total_clientes'] = $this->M_configuracion->total_clientes_vip();
		$datos['total_clientes_mision'] = $this->M_configuracion->total_clientes_vip_mision();
		$datos['total_clientes_operacion'] = $this->M_configuracion->total_clientes_vip_operacion();
		$datos['total_clientes_cancelados'] = $this->M_configuracion->total_clientes_vip_cancelados();
		
		
		$this->load->view('lte_header', $datos);
		$this->load->view('v_listado_clientes_vip', $datos);
		$this->load->view('lte_footer', $datos);
	}
	 public function clientes_filtrados()
	{
		$dni= $this->input->post('fil_dni');
		$nombre = $this->input->post('fil_nombre');
		$telefono = $this->input->post('fil_telefono');
		$apellidos = $this->input->post('fil_apellidos');
		$email = $this->input->post('fil_email');
		$celular = $this->input->post('fil_celular');

		$dni 		= trim($dni);
		$nombre 	= trim($nombre);
		$telefono 	= trim($telefono);
		$apellidos 	= trim($apellidos);
		$email 		= trim($email);
		$celular 	= trim($celular);

		if($nombre == ''){
			$nombre ='*';
		}
		if($telefono == ''){
			$telefono ='*';
		}
		if($dni == ''){
			$dni ='*';
		}
		if($apellidos ==''){
			$apellidos='*';
		}
		if($email ==''){
			$email='*';
		}
		if($celular ==''){
			$celular='*';
		}
		$clientes = $this->M_configuracion->clientes_all_filtrado($dni, $nombre, $telefono, $apellidos, $email, $celular);	
        $datos['clientes'] = $clientes;
		$datos['total_clientes'] = $this->M_configuracion->total_clientes();
		$datos['total_clientes_mision'] = $this->M_configuracion->total_clientes_mision();
		$datos['total_clientes_operacion'] = $this->M_configuracion->total_clientes_operacion();
		$datos['total_clientes_cancelados'] = $this->M_configuracion->total_clientes_cancelados();
		$misiones_activas = $this->M_configuracion->obt_mision_activas();	
        $datos['misiones_activas'] = $misiones_activas;
		$this->load->view('lte_header', $datos);
		$this->load->view('v_listado_clientes1', $datos);
		$this->load->view('lte_footer', $datos);
	}
	 public function clientes_vip_filtrados()
	{
		$dni= $this->input->post('fil_dni');
		$nombre = $this->input->post('fil_nombre');
		$telefono = $this->input->post('fil_telefono');
		$email = $this->input->post('fil_email');
		$celular = $this->input->post('fil_celular');

		$dni = trim($dni);
		$nombre = trim($nombre);
		$telefono = trim($telefono);
		$email 		= trim($email);
		$celular 	= trim($celular);

		if($nombre == ''){
			$nombre ='*';
		}
		if($telefono == ''){
			$telefono ='*';
		}
		if($dni == ''){
			$dni ='*';
		}
		if($email ==''){
			$email='*';
		}
		if($celular ==''){
			$celular='*';
		}
		$clientes = $this->M_configuracion->clientes_vip_filtrado($dni, $nombre, $telefono, $email, $celular);	
        $datos['clientes'] = $clientes;
		$datos['total_clientes'] = $this->M_configuracion->total_clientes_vip();
		$datos['total_clientes_mision'] = $this->M_configuracion->total_clientes_vip_mision();
		$datos['total_clientes_operacion'] = $this->M_configuracion->total_clientes_vip_operacion();
		$datos['total_clientes_cancelados'] = $this->M_configuracion->total_clientes_vip_cancelados();
		$misiones_activas = $this->M_configuracion->obt_mision_activas();	
        $datos['misiones_activas'] = $misiones_activas;
		$this->load->view('lte_header', $datos);
		$this->load->view('v_listado_clientes_vip', $datos);
		$this->load->view('lte_footer', $datos);
	}
	public function clientes_consultor()
	{
		$clientes = $this->M_configuracion->clientes_all();	
        $datos['clientes'] = $clientes;
		$misiones_activas = $this->M_configuracion->obt_mision_activas();	
        $datos['misiones_activas'] = $misiones_activas;
		$datos['total_clientes'] = $this->M_configuracion->total_clientes();
		$datos['total_clientes_mision'] = $this->M_configuracion->total_clientes_mision();
		$datos['total_clientes_operacion'] = $this->M_configuracion->total_clientes_operacion();
		$datos['total_clientes_cancelados'] = $this->M_configuracion->total_clientes_cancelados();
		$datos['niveles'] = $this->M_configuracion->obt_niveles_vip();

		$this->load->view('lte_header', $datos);
		$this->load->view('v_listado_clientes_consultor', $datos);
		$this->load->view('lte_footer', $datos);
	}
	 public function clientes_consultor_filtrados()
	{
		$dni= $this->input->post('fil_dni');
		$nombre = $this->input->post('fil_nombre');
		$telefono = $this->input->post('fil_telefono');
		$apellidos = $this->input->post('fil_apellidos');
		$email = $this->input->post('fil_email');
		$celular = $this->input->post('fil_celular');

		$dni 		= trim($dni);
		$nombre 	= trim($nombre);
		$telefono 	= trim($telefono);
		$apellidos 	= trim($apellidos);
		$email 		= trim($email);
		$celular 	= trim($celular);
		if($nombre == ''){
			$nombre ='*';
		}
		if($telefono == ''){
			$telefono ='*';
		}
		if($dni == ''){
			$dni ='*';
		}
		if($apellidos ==''){
			$apellidos='*';
		}
		if($email ==''){
			$email='*';
		}
		if($celular ==''){
			$celular='*';
		}
		$clientes = $this->M_configuracion->clientes_all_filtrado($dni, $nombre, $telefono, $apellidos, $email, $celular);	
        $datos['clientes'] = $clientes;
		$datos['total_clientes'] = $this->M_configuracion->total_clientes();
		$datos['total_clientes_mision'] = $this->M_configuracion->total_clientes_mision();
		$datos['total_clientes_operacion'] = $this->M_configuracion->total_clientes_operacion();
		$datos['total_clientes_cancelados'] = $this->M_configuracion->total_clientes_cancelados();
		$misiones_activas = $this->M_configuracion->obt_mision_activas();	
        $datos['misiones_activas'] = $misiones_activas;
		$this->load->view('lte_header', $datos);
		$this->load->view('v_listado_clientes_consultor', $datos);
		$this->load->view('lte_footer', $datos);
	}
	public function clientes_observaciones()
	{
		$clientes = $this->M_configuracion->clientes_observaciones();	
        $datos['clientes'] = $clientes;
		

		$this->load->view('lte_header', $datos);
		$this->load->view('v_listado_clientes_observaciones', $datos);
		$this->load->view('lte_footer', $datos);
	}
	 public function clientes_observaciones_filtrados()
	{
		$dni= $this->input->post('fil_dni');
		$nombre = $this->input->post('fil_nombre');
		$telefono = $this->input->post('fil_telefono');

		$dni 		= trim($dni);
		$nombre  	= trim($nombre);
		$telefono  	= trim($telefono);
		if($nombre == ''){
			$nombre ='*';
		}
		if($telefono == ''){
			$telefono ='*';
		}
		if($dni == ''){
			$dni ='*';
		}

		$clientes = $this->M_configuracion->clientes_observaciones_filtrados($dni, $nombre, $telefono);	
        $datos['clientes'] = $clientes;
		
		
		$this->load->view('lte_header', $datos);
		$this->load->view('v_listado_clientes_observaciones', $datos);
		$this->load->view('lte_footer', $datos);
	}
	public function historial($id_cliente)
	{
		$historial = $this->M_configuracion->historial($id_cliente);
		$historico = $this->M_configuracion->historico($id_cliente);	
		$cliente = $this->M_configuracion->cliente_historico($id_cliente);

		$datos['cliente'] = $cliente;
		$datos['historial'] = $historial;
		$datos['historico'] = $historico;

		$this->load->view('lte_header', $datos);
		$this->load->view('v_historial', $datos);
		$this->load->view('lte_footer', $datos);
	}
	// ------------------------------------------------------
	// Nuevo cliente
	
	public function nuevo_cliente()
	{
		$provincias = $this->M_configuracion->obt_provincias();	
		
		$datos['provincias'] = $provincias;
		$datos['niveles'] = $this->M_configuracion->obt_niveles_vip();
		$datos['notificacion'] = $this->notificacion ? $this->notificacion : "Especifique los datos del nuevo cliente:";
		$datos['notificacion_error'] = $this->notificacion_error;
		$datos['modo_edicion'] = false;
		
		$this->load->view('lte_header', $datos);
		$this->load->view('v_nuevo_cliente', $datos);
		$this->load->view('lte_footer', $datos);	
	}
	
	// ------------------------------------------------------
	// Registrar cliente
	
    public function registrar_cliente()
    {
		 $dni 			= $this->input->post('dni');
		 $id_municipio 	= $this->input->post('id_municipio');
		 $id_provincia 	= $this->input->post('id_provincia');
		 $nombre 		= $this->input->post('nombre');
		 $apellidos 	= $this->input->post('apellidos');
		 $telefono 		= $this->input->post('telefono');
		 $celular 		= $this->input->post('celular');
		 $email 		= $this->input->post('email');
		 $codigo_postal = $this->input->post('codigo_postal');
		 
		 $calle 			= $this->input->post('calle');
		 $nro 				= $this->input->post('nro');
		 $piso 				= $this->input->post('piso');
		 $dpto 				= $this->input->post('dpto');
		 $entrecalle1 		= $this->input->post('entrecalle1');
		 $entrecalle2 		= $this->input->post('entrecalle2');
		 $fecha_nacimiento 	= $this->input->post('fecha_nacimiento');
		 $en_mision 		= $this->input->post('en_mision');
		 $en_operacion 		= $this->input->post('en_operacion');
		 $reg_cancelado 	= $this->input->post('reg_cancelado');
		 $observaciones 	= $this->input->post('observaciones1');
		 $cuit 				= $this->input->post('cuit');

		 if($this->input->post('vip')){
			$vip = 1;
		}else{
			$vip = 0;
		}		 
		 $nivel 			= $this->input->post('nivel');

		 $this->load->library('form_validation');

		  $this->form_validation->set_rules('dni', 'DNI', 'required|min_length[8]|max_length[8]');
		  $this->form_validation->set_rules('nombre', 'Nombre', 'required');
		  $this->form_validation->set_rules('apellidos', 'Apellidos', 'required');
		  $this->form_validation->set_rules('telefono', 'Teléfono', 'required|numeric');
		  $this->form_validation->set_rules('celular', 'Celular', 'numeric');
		  $this->form_validation->set_rules('email', 'Email', 'valid_email');
		  $this->form_validation->set_rules('codigo_postal', 'Código postal', 'required');
		  $this->form_validation->set_rules('calle', 'Calle', 'required');
		  $this->form_validation->set_rules('nro', 'Número', 'required');
		 if ($this->form_validation->run() == true )
		 {
		 
			 $registrado = $this->M_configuracion->registrar_cliente($dni, $id_municipio, $nombre,$apellidos, $telefono,$celular, $email,$codigo_postal, $calle, $nro, $piso, $dpto, $entrecalle1, $entrecalle2, $vip, $nivel, $fecha_nacimiento, $observaciones, $cuit);
			 
			 $mensaje = "";
			 if ($registrado == 1)
				 { 
					 $this->notificacion = "El cliente se registró satisfactoriamente.";
		             $this->notificacion_error = false;
				 }
				 else
				 {
					 $this->notificacion = "ERROR. No se pudo registrar el cliente.";
		             $this->notificacion_error = true;
				 }
		 }
		 else
		 {
			 $this->notificacion = validation_errors();
			 $this->notificacion_error = true;
		 }
		  if($this->notificacion_error == true){
			$provincias = $this->M_configuracion->obt_provincias();
			$datos['provincias'] = $provincias; 
			
			$datos['id_actual'] 		= $id_actual;
			$datos['dni'] 				= $dni;
			$datos['id_municipio'] 		= $id_municipio;
			$datos['id_provincia'] 		= $id_provincia;
			$datos['nombre'] 			= $nombre;
			$datos['apellidos'] 		= $apellidos;
			$datos['telefono'] 			= $telefono;
			$datos['celular'] 			= $celular;
			$datos['email'] 			= $email;
			$datos['codigo_postal'] 	= $codigo_postal;
			$datos['calle'] 			= $calle;
			$datos['nro'] 				= $nro;
			$datos['piso'] 				= $piso;
			$datos['dpto'] 				= $dpto;
			$datos['entrecalle1'] 		= $entrecalle1;
			$datos['entrecalle2'] 		= $entrecalle2;
			$datos['fecha_nacimiento'] 	= $fecha_nacimiento;	
			$datos['en_mision'] 		=$en_mision;
			$datos['en_operacion'] 		=$en_operacion;
		    $datos['reg_cancelado'] 	=$reg_cancelado;
			$datos['vip'] 				=$vip;
		    $datos['nivel'] 			=$nivel;		
			$datos['cuit'] 				=$cuit;
			$datos['observaciones'] 	=$observaciones;
			$datos['notificacion'] 		= $this->notificacion ? $this->notificacion : "Error registrando el perfil del cliente " . $nombre;
          	$datos['notificacion_error']= $this->notificacion_error;
			$datos['modo_edicion'] 		= false;
						
			$this->load->view('lte_header', $datos);
			$this->load->view('v_nuevo_cliente', $datos);
			$this->load->view('lte_footer', $datos);  
		 }else
		 	$this->nuevo_cliente();
		 
    }
	public function registrar_cliente_vip()
    {
		 $dni 			= $this->input->post('dni');
		 $id_municipio 	= $this->input->post('id_municipio');
		 $id_provincia 	= $this->input->post('id_provincia');
		 $nombre 		= $this->input->post('nombre');
		 $apellidos 	= $this->input->post('apellidos');
		 $telefono 		= $this->input->post('telefono');
		 $celular 		= $this->input->post('celular');
		 $email 		= $this->input->post('email');
		 $codigo_postal = $this->input->post('codigo_postal');
		 
		 $calle 			= $this->input->post('calle');
		 $nro 				= $this->input->post('nro');
		 $piso 				= $this->input->post('piso');
		 $dpto 				= $this->input->post('dpto');
		 $entrecalle1 		= $this->input->post('entrecalle1');
		 $entrecalle2 		= $this->input->post('entrecalle2');
		 $fecha_nacimiento 	= $this->input->post('fecha_nacimiento');
		 $en_mision 		= $this->input->post('en_mision');
		 $en_operacion 		= $this->input->post('en_operacion');
		 $reg_cancelado 	= $this->input->post('reg_cancelado');
		 $cuit 	= $this->input->post('cuit');
		 if($this->input->post('vip')){
			$vip = 1;
		}else{
			$vip = 0;
		}		 
		 $nivel 			= $this->input->post('nivel');

		 $this->load->library('form_validation');

		  $this->form_validation->set_rules('dni', 'DNI', 'required|min_length[8]|max_length[8]');
		  $this->form_validation->set_rules('nombre', 'Nombre', 'required');
		  $this->form_validation->set_rules('apellidos', 'Apellidos', 'required');
		  $this->form_validation->set_rules('telefono', 'Teléfono', 'required|numeric');
		  $this->form_validation->set_rules('celular', 'Celular', 'numeric');
		  $this->form_validation->set_rules('email', 'Email', 'valid_email');
		  $this->form_validation->set_rules('codigo_postal', 'Código postal', 'required');
		  $this->form_validation->set_rules('calle', 'Calle', 'required');
		  $this->form_validation->set_rules('nro', 'Número', 'required');
		 if ($this->form_validation->run() == true )
		 {
		 
			 $registrado = $this->M_configuracion->registrar_cliente($dni, $id_municipio, $nombre,$apellidos, $telefono,$celular, $email,$codigo_postal, $calle, $nro, $piso, $dpto, $entrecalle1, $entrecalle2, $vip, $nivel, $fecha_nacimiento);
			 
			 $mensaje = "";
			 if ($registrado == 1)
				 { 
					 $this->notificacion = "El cliente se registró satisfactoriamente.";
		             $this->notificacion_error = false;
				 }
				 else
				 {
					 $this->notificacion = "ERROR. No se pudo registrar el cliente.";
		             $this->notificacion_error = true;
				 }
		 }
		 else
		 {
			 $this->notificacion = validation_errors();
			 $this->notificacion_error = true;
		 }
		  if($this->notificacion_error == true){
			$provincias = $this->M_configuracion->obt_provincias();
			$datos['provincias'] = $provincias; 
			
			$datos['id_actual'] = $id_actual;
			$datos['dni'] = $dni;
			$datos['id_municipio'] = $id_municipio;
			$datos['id_provincia'] = $id_provincia;
			$datos['nombre'] = $nombre;
			$datos['apellidos'] = $apellidos;
			$datos['telefono'] = $telefono;
			$datos['celular'] = $celular;
			$datos['email'] = $email;
			$datos['codigo_postal'] = $codigo_postal;
			$datos['calle'] = $calle;
			$datos['nro'] = $nro;
			$datos['piso'] = $piso;
			$datos['dpto'] = $dpto;
			$datos['entrecalle1'] = $entrecalle1;
			$datos['entrecalle2'] = $entrecalle2;
			$datos['fecha_nacimiento'] = $fecha_nacimiento;	
			$datos['en_mision'] 		=$en_mision;
		    $datos['en_operacion'] 	=$en_operacion;
		    $datos['reg_cancelado'] 	=$reg_cancelado;
			$datos['vip'] 			=$vip;
		    $datos['nivel'] 		=$nivel;		
			$datos['cuit'] 		=$cuit;

			$datos['notificacion'] = $this->notificacion ? $this->notificacion : "Error registrando el perfil del cliente " . $nombre;
          	$datos['notificacion_error'] = $this->notificacion_error;
			$datos['modo_edicion'] = false;
						
			$this->load->view('lte_header', $datos);
			$this->load->view('v_nuevo_cliente_vip', $datos);
			$this->load->view('lte_footer', $datos);  
		 }else
		 	$this->nuevo_cliente();
		 
    }
	// ------------------------------------------------------
	// Editar cliente
	
	public function editar_cliente($id_actual)
	{
		$resultado = $this->M_configuracion->obt_cliente($id_actual);
		$canales = $this->M_configuracion->obt_canales_entrada();	
		$provincias = $this->M_configuracion->obt_provincias();	
		$datos['niveles'] = $this->M_configuracion->obt_niveles_vip();
		$datos['provincias'] = $provincias;
		$solicitud = $this->M_configuracion->solicitud_baja($id_actual);
		
		if($solicitud->num_rows() != 0){
			$sol = $solicitud->row();
			$solicitud_baja=1;
			$observaciones=$sol->observaciones;
			
		}else{
			$solicitud_baja=0;
			$observaciones="";
		}
		$datos['solicitud_baja'] = $solicitud_baja;
		$datos['observaciones'] = $observaciones;
		if ($resultado)
		{
		   $cliente = $resultado->row();

		   $id_cliente 		= $id_actual;
		   $id_municipio 	= $cliente->id_municipio;
		   $id_provincia 	= $cliente->id_provincia;
		   $dni 			= $cliente->dni;
		   $nombre 			= $cliente->nombre;
		   $apellidos 		= $cliente->apellidos;
		   $telefono 		= $cliente->telefono;
		   $celular 		= $cliente->celular;
		   $email 			= $cliente->email;
		   $codigo_postal 	= $cliente->codigo_postal;
		   $calle 			= $cliente->calle;
		   $nro 			= $cliente->nro;
		   $piso 			= $cliente->piso;
		   $dpto 			= $cliente->dpto;
		   $entrecalle1 	= $cliente->entrecalle1;
		   $entrecalle2 	= $cliente->entrecalle2;
		   $fecha_nacimiento= $cliente->fecha_nacimiento;
		   $en_mision 		= $cliente->en_mision;
		   $en_operacion 	= $cliente->en_operacion;
		   $reg_cancelado 	= $cliente->reg_cancelado;
		   $vip  			= $cliente->vip;
		   $nivel  			= $cliente->nivel;
		   $observaciones1  = $cliente->observaciones;
		   $cuit   			= $cliente->cuit;

		   $datos['modo_edicion'] = true;
		   $datos['id_provincia'] = $id_provincia;
		   $datos['id_municipio'] = $id_municipio;

		   $datos['notificacion'] = $this->notificacion ? $this->notificacion : "Modificando el perfil del cliente " . $nombre;
           $datos['notificacion_error'] = $this->notificacion_error;
		   
		   
		   $datos['id_actual'] 		= $id_actual;
		   $datos['dni'] 			= $dni;
		   $datos['id_municipio'] 	= $id_municipio;
		   $datos['nombre'] 		= $nombre;
		   $datos['apellidos'] 		= $apellidos;
		   $datos['telefono'] 		= $telefono;
		   $datos['celular'] 		= $celular;
		   $datos['email'] 			= $email;
		   $datos['codigo_postal'] 	= $codigo_postal;
		   $datos['calle'] 			= $calle;
		   $datos['nro'] 			= $nro;
		   $datos['piso'] 			= $piso;
		   $datos['dpto'] 			= $dpto;
		   $datos['entrecalle1'] 	= $entrecalle1;
		   $datos['entrecalle2'] 	= $entrecalle2;
		   $datos['fecha_nacimiento']=$fecha_nacimiento;
		   $datos['en_mision'] 		=$en_mision;
		   $datos['en_operacion'] 	=$en_operacion;
		   $datos['reg_cancelado'] 	=$reg_cancelado;
		   $datos['vip'] 			=$vip;
		   $datos['nivel'] 			=$nivel;
		   $datos['observaciones1'] =$observaciones1;
		   $datos['cuit']  			=$cuit;
		}
		
		$this->load->view('lte_header', $datos);
 	    $this->load->view('v_nuevo_cliente', $datos);
	    $this->load->view('lte_footer', $datos);
	}
	public function editar_cliente_vip($id_actual)
	{
		$resultado = $this->M_configuracion->obt_cliente($id_actual);
		$canales = $this->M_configuracion->obt_canales_entrada();	
		$provincias = $this->M_configuracion->obt_provincias();	
		$datos['niveles'] = $this->M_configuracion->obt_niveles_vip();
		$datos['provincias'] = $provincias;
		
		if ($resultado)
		{
		   $cliente = $resultado->row();

		   $id_cliente 		= $id_actual;
		   $id_municipio 	= $cliente->id_municipio;
		   $id_provincia 	= $cliente->id_provincia;
		   $dni 			= $cliente->dni;
		   $nombre 			= $cliente->nombre;
		   $apellidos 		= $cliente->apellidos;
		   $telefono 		= $cliente->telefono;
		   $celular 		= $cliente->celular;
		   $email 			= $cliente->email;
		   $codigo_postal 	= $cliente->codigo_postal;
		   $calle 			= $cliente->calle;
		   $nro 			= $cliente->nro;
		   $piso 			= $cliente->piso;
		   $dpto 			= $cliente->dpto;
		   $entrecalle1 	= $cliente->entrecalle1;
		   $entrecalle2 	= $cliente->entrecalle2;
		   $fecha_nacimiento= $cliente->fecha_nacimiento;
		   $en_mision 		= $cliente->en_mision;
		   $en_operacion 	= $cliente->en_operacion;
		   $reg_cancelado 	= $cliente->reg_cancelado;
		   $vip  			= $cliente->vip;
		   $nivel  			= $cliente->nivel;
		   $cuit  			= $cliente->cuit;
		   
		   $datos['modo_edicion'] = true;
		   $datos['id_provincia'] = $id_provincia;
		   $datos['id_municipio'] = $id_municipio;

		   $datos['notificacion'] = $this->notificacion ? $this->notificacion : "Modificando el perfil del cliente " . $nombre;
           $datos['notificacion_error'] = $this->notificacion_error;
		   
		   
		   $datos['id_actual'] 		= $id_actual;
		   $datos['dni'] 			= $dni;
		   $datos['id_municipio'] 	= $id_municipio;
		   $datos['nombre'] 		= $nombre;
		   $datos['apellidos'] 		= $apellidos;
		   $datos['telefono'] 		= $telefono;
		   $datos['celular'] 		= $celular;
		   $datos['email'] 			= $email;
		   $datos['codigo_postal'] 	= $codigo_postal;
		   $datos['calle'] 			= $calle;
		   $datos['nro'] 			= $nro;
		   $datos['piso'] 			= $piso;
		   $datos['dpto'] 			= $dpto;
		   $datos['entrecalle1'] 	= $entrecalle1;
		   $datos['entrecalle2'] 	= $entrecalle2;
		   $datos['fecha_nacimiento']=$fecha_nacimiento;
		   $datos['en_mision'] 		=$en_mision;
		   $datos['en_operacion'] 	=$en_operacion;
		   $datos['reg_cancelado'] 	=$reg_cancelado;
		   $datos['vip'] 			=$vip;
		   $datos['nivel'] 			=$nivel;
		   $datos['cuit'] 			=$cuit;
		}
		
		$this->load->view('lte_header', $datos);
 	    $this->load->view('v_nuevo_cliente_vip', $datos);
	    $this->load->view('lte_footer', $datos);
	}
	// ------------------------------------------------------
	// Modificar cliente
    
	public function modificar_cliente()
    {
		$datos['niveles'] = $this->M_configuracion->obt_niveles_vip();
		 $id_actual 		= $this->input->post('id_actual');
		 $dni 				= $this->input->post('dni');
		 $id_municipio 		= $this->input->post('id_municipio');
		 $id_provincia 		= $this->input->post('id_provincia');
		 $nombre 			= $this->input->post('nombre');
		 $apellidos 		= $this->input->post('apellidos');
		 $telefono 			= $this->input->post('telefono');
		 $celular 			= $this->input->post('celular');
		 $email 			= $this->input->post('email');
		 $codigo_postal 	= $this->input->post('codigo_postal');
		 $calle 			= $this->input->post('calle');
		 $nro 				= $this->input->post('nro');
		 $piso				= $this->input->post('piso');
		 $dpto 				= $this->input->post('dpto');
		 $entrecalle1 		= $this->input->post('entrecalle1');
		 $entrecalle2		= $this->input->post('entrecalle2');
		 $fecha_nacimiento 	= $this->input->post('fecha_nacimiento');
		 $observaciones1 	= $this->input->post('observaciones1');
		$cuit 				= $this->input->post('cuit');
		$observaciones =  $this->input->post('observaciones');

		if($this->input->post('solicitud_baja')){
			$solicitud_baja = 1;
			$observaciones =  $this->input->post('observaciones');
			$opcion_baja =  $this->input->post('opcion_baja');
			if($opcion_baja){
				$fallecido =1;
			}else{
				$fallecido =0;
			}
			$solicitud = $this->M_configuracion->solicitud_baja($id_actual);			
			if($solicitud->num_rows() == 0){				
				$user = $this->ion_auth->user()->row();				
				$resul1 = $this->M_configuracion->registrar_solicitud_baja($user->id, $id_actual, $observaciones,$fallecido);
			}
		}else{
			 $solicitud_baja = 0;
			 $observaciones = "";
			 $solicitud = $this->M_configuracion->solicitud_baja($id_actual);			
			 if($solicitud->num_rows() <> 0){				
				 $user = $this->ion_auth->user()->row();				
				 $resul1 = $this->M_configuracion->cancelar_solicitud_baja($id_actual);
			 }
		}	

		 
		 if($this->input->post('en_mision')){
			 $en_mision = 1;
		 }else{
			  $en_mision = 0;
		 }
		
		 if($this->input->post('en_operacion')){
			 $en_operacion = 1;
		 }else{
			  $en_operacion = 0;
		 }
		 if($this->input->post('reg_cancelado')){
			 $reg_cancelado = 1;
		 }else{
			  $reg_cancelado = 0;
		 }
		 if($this->input->post('vip')){
			$vip = 1;
		}else{
			$vip = 0;
		}		 
		 $nivel 			= $this->input->post('nivel');
		
		 $this->load->library('form_validation');
		 /*if($email ==''){
			$this->form_validation->set_rules('email', 'Email', 'required');
		 }else{
			$this->form_validation->set_rules('dni', 'DNI', 'min_length[6]|max_length[8]');
			$this->form_validation->set_rules('email', 'Email', 'valid_email');
		 }*/
		  
		  //$this->form_validation->set_rules('nombre', 'Nombre', 'required');
		  //$this->form_validation->set_rules('apellidos', 'Apellidos', 'required');
		  $this->form_validation->set_rules('telefono', 'Teléfono', 'numeric');
		  $this->form_validation->set_rules('celular', 'Teléfono', 'numeric');
		  
		 // $this->form_validation->set_rules('codigo_postal', 'Código postal', 'required');
		 // $this->form_validation->set_rules('calle', 'Calle', 'required');
		  //$this->form_validation->set_rules('nro', 'Número', 'required');
		 
		 if (   $this->form_validation->run() == true)
		 {
			
			 $modificado = $this->M_configuracion->modificar_cliente($id_actual, $dni, $id_municipio, $nombre,$apellidos, $telefono,$celular, $email,$codigo_postal, $calle, $nro, $piso, $dpto, $entrecalle1, $entrecalle2, $fecha_nacimiento, $en_mision, $en_operacion, $reg_cancelado, $vip, $nivel, $observaciones1, $cuit);
			 
   		     /*if ($modificado == 1)
			 { */
				 $this->notificacion = "El cliente se modificó satisfactoriamente.";
		         $this->notificacion_error = false;
			 /*}
			 else
			 {
				 $this->notificacion = "ERROR. No se pudo modificar el cliente. Verifique los datos especificados.";
		         $this->notificacion_error = true;
			 }*/
		 }
		 else
		 {
		     $this->notificacion = validation_errors();
			 $this->notificacion_error = true;

		 }
		 if($this->notificacion_error == true){
			$provincias = $this->M_configuracion->obt_provincias();
			$datos['provincias'] = $provincias; 
			
			$datos['id_actual'] 	= $id_actual;
			$datos['dni'] 			= $dni;
			$datos['id_municipio'] 	= $id_municipio;
			$datos['id_provincia'] 	= $id_provincia;
			$datos['nombre'] 		= $nombre;
			$datos['apellidos'] 	= $apellidos;
			$datos['telefono'] 		= $telefono;
			$datos['celular'] 		= $celular;
			$datos['email'] 		= $email;
			$datos['codigo_postal'] = $codigo_postal;
			$datos['calle'] 		= $calle;
			$datos['nro'] 			= $nro;
			$datos['piso'] 			= $piso;
			$datos['dpto'] 			= $dpto;
			$datos['entrecalle1'] 	= $entrecalle1;
			$datos['entrecalle2'] 	= $entrecalle2;
			$datos['fecha_nacimiento'] 	= $fecha_nacimiento;
			$datos['en_mision'] 	=$en_mision;
		    $datos['en_operacion'] 	=$en_operacion;
		    $datos['reg_cancelado'] =$reg_cancelado;
			$datos['vip'] 			=$vip;
		    $datos['nivel'] 		=$nivel;
			$datos['solicitud_baja'] =$solicitud_baja;
		    $datos['observaciones1']  =$observaciones1;
			$datos['observaciones']  =$observaciones;
			$datos['cuit']  =$cuit;

			$datos['notificacion'] = $this->notificacion ? $this->notificacion : "Error modificando el perfil del cliente " . $nombre;
          	$datos['notificacion_error'] = $this->notificacion_error;
			$datos['modo_edicion'] = true;

			$this->load->view('lte_header', $datos);
			$this->load->view('v_nuevo_cliente', $datos);
			$this->load->view('lte_footer', $datos);  
		 }else
		 	$this->clientes();
	}
	public function modificar_cliente_vip()
    {
		$datos['niveles'] = $this->M_configuracion->obt_niveles_vip();
		 $id_actual 		= $this->input->post('id_actual');
		 $dni 				= $this->input->post('dni');
		 $id_municipio 		= $this->input->post('id_municipio');
		 $id_provincia 		= $this->input->post('id_provincia');
		 $nombre 			= $this->input->post('nombre');
		 $apellidos 		= $this->input->post('apellidos');
		 $telefono 			= $this->input->post('telefono');
		 $celular 			= $this->input->post('celular');
		 $email 			= $this->input->post('email');
		 $codigo_postal 	= $this->input->post('codigo_postal');
		 $calle 			= $this->input->post('calle');
		 $nro 				= $this->input->post('nro');
		 $piso				= $this->input->post('piso');
		 $dpto 				= $this->input->post('dpto');
		 $entrecalle1 		= $this->input->post('entrecalle1');
		 $entrecalle2		= $this->input->post('entrecalle2');
		 $fecha_nacimiento 	= $this->input->post('fecha_nacimiento');
		 $observaciones1    = '';
		 $cuit 				=  $this->input->post('cuit');
		 if($this->input->post('en_mision')){
			 $en_mision = 1;
		 }else{
			  $en_mision = 0;
		 }
		
		 if($this->input->post('en_operacion')){
			 $en_operacion = 1;
		 }else{
			  $en_operacion = 0;
		 }
		 if($this->input->post('reg_cancelado')){
			 $reg_cancelado = 1;
		 }else{
			  $reg_cancelado = 0;
		 }
		 if($this->input->post('vip')){
			$vip = 1;
		}else{
			$vip = 0;
		}		 
		 $nivel 			= $this->input->post('nivel');
		
		 $this->load->library('form_validation');

		  /*$this->form_validation->set_rules('dni', 'DNI', 'required|min_length[8]|max_length[8]');
		  $this->form_validation->set_rules('nombre', 'Nombre', 'required');
		  $this->form_validation->set_rules('apellidos', 'Apellidos', 'required');*/
		  $this->form_validation->set_rules('telefono', 'Teléfono', 'numeric');
		  $this->form_validation->set_rules('celular', 'Celular', 'numeric');
		  /*$this->form_validation->set_rules('email', 'Email', 'valid_email');
		  $this->form_validation->set_rules('codigo_postal', 'Código postal', 'required');
		  $this->form_validation->set_rules('calle', 'Calle', 'required');
		  $this->form_validation->set_rules('nro', 'Número', 'required');*/
		 
		 if (   $this->form_validation->run() == true)
		 {
		 
			 $modificado = $this->M_configuracion->modificar_cliente($id_actual, $dni, $id_municipio, $nombre,$apellidos, $telefono,$celular, $email,$codigo_postal, $calle, $nro, $piso, $dpto, $entrecalle1, $entrecalle2, $fecha_nacimiento, $en_mision, $en_operacion, $reg_cancelado, $vip, $nivel, $observaciones1, $cuit);
			 
   		    /*if ($modificado <= 1)
			 { */
				 $this->notificacion = "El cliente se modificó satisfactoriamente.";
		         $this->notificacion_error = false;
			 /*}
			 else
			 {
				 $this->notificacion = "ERROR. No se pudo modificar el cliente. Verifique los datos especificados.";
		         $this->notificacion_error = true;
			 }*/
		 }
		 else
		 {
		     $this->notificacion = validation_errors();
			 $this->notificacion_error = true;

		 }
		 if($this->notificacion_error == true){
			$provincias = $this->M_configuracion->obt_provincias();
			$datos['provincias'] = $provincias; 
			
			$datos['id_actual'] 	= $id_actual;
			$datos['dni'] 			= $dni;
			$datos['id_municipio'] 	= $id_municipio;
			$datos['id_provincia'] 	= $id_provincia;
			$datos['nombre'] 		= $nombre;
			$datos['apellidos'] 	= $apellidos;
			$datos['telefono'] 		= $telefono;
			$datos['celular'] 		= $celular;
			$datos['email'] 		= $email;
			$datos['codigo_postal'] = $codigo_postal;
			$datos['calle'] 		= $calle;
			$datos['nro'] 			= $nro;
			$datos['piso'] 			= $piso;
			$datos['dpto'] 			= $dpto;
			$datos['entrecalle1'] 	= $entrecalle1;
			$datos['entrecalle2'] 	= $entrecalle2;
			$datos['fecha_nacimiento'] 	= $fecha_nacimiento;
			$datos['en_mision'] 	=$en_mision;
		    $datos['en_operacion'] 	=$en_operacion;
		    $datos['reg_cancelado'] =$reg_cancelado;
			$datos['vip'] 			=$vip;
		    $datos['nivel'] 		=$nivel;
			$datos['cuit'] 			=$cuit;

			$datos['notificacion'] = $this->notificacion ? $this->notificacion : "Error modificando el perfil del cliente " . $nombre;
          	$datos['notificacion_error'] = $this->notificacion_error;
			$datos['modo_edicion'] = true;

			$this->load->view('lte_header', $datos);
			$this->load->view('v_nuevo_cliente_vip', $datos);
			$this->load->view('lte_footer', $datos);  
		 }else
		 	$this->clientes_vip();
	}
	// ------------------------------------------------------
	// Confirmar cancelación de un cliente
	
	public function cfe_cliente($id_cliente)
	{
		$datos['id_cliente'] = $id_cliente;
		
		$this->load->view('lte_header', $datos);
 	    $this->load->view('vcan_clientes', $datos);
	    $this->load->view('lte_footer', $datos);
	}
	public function cfe_cliente_vip($id_cliente)
	{
		$datos['id_cliente'] = $id_cliente;
		
		$this->load->view('lte_header', $datos);
 	    $this->load->view('vcan_clientes_vip', $datos);
	    $this->load->view('lte_footer', $datos);
	}
	
	// ------------------------------------------------------
	// Cancelar cliente
	
    public function cancelar_cliente()
	{
		$id_cliente = $this->input->post('id_cliente');
		$cancelado = $this->M_configuracion->cancelar_cliente($id_cliente);
		
		if ($cancelado == 1)
	    { 
		    $this->notificacion = "El cliente se canceló correctamente.";
		    $this->notificacion_error = false;
		}
		else
		{
		    $this->notificacion = "No se pudo eliminar el cliente.";
		    $this->notificacion_error = true;  
		}
		
		$this->clientes();

	}
    public function cancelar_cliente_vip()
	{
		$id_cliente = $this->input->post('id_cliente');
		$cancelado = $this->M_configuracion->cancelar_cliente($id_cliente);
		
		if ($cancelado == 1)
	    { 
		    $this->notificacion = "El cliente se canceló correctamente.";
		    $this->notificacion_error = false;
		}
		else
		{
		    $this->notificacion = "No se pudo eliminar el cliente.";
		    $this->notificacion_error = true;  
		}
		
		$this->clientes_vip();

	}
	
	// ------------------------------------------------------
	// Municipios de una provincia
	
    public function productos_combo($id_combo)
	{
		$productos = $this->M_configuracion->productos_combo($id_combo);	
		foreach ($productos->result() as $mun)
			echo '<option >' . $mun->cantidad. ' '.$mun->nombre . '</option>';
	}

    public function municipios_provincia($id_provincia)
	{
		$municipios = $this->M_configuracion->municipios_provincia($id_provincia);	
		foreach ($municipios->result() as $mun)
			echo '<option value="' . $mun->id_municipio . '">' . $mun->nombre_municipio . '</option>';
	}
	
	/*
	 * ------------------------------------------------------
	 *  GESTIÓN MISIONES
	 * ------------------------------------------------------
	 */
	
	// ------------------------------------------------------
	// Misiones
	
    public function misiones()
	{
		$group = array('Revendedores','ConsultorRV');
		$groupRev = array('Revendedores');

		$user = $this->ion_auth->user()->row();
		if ($this->ion_auth->in_group($group)) { 			
			$revendedor = 'true'; 			

			if($this->ion_auth->in_group($groupRev))
			{	// El usuario es revendedor
				$misiones = $this->M_configuracion->misiones_revendedores($user->id);
			}
			else
			{	// El usuario es consultor revendedor
				$id_rev = $this->M_operaciones->obt_superior($user->id);				
				$misiones = $this->M_configuracion->misiones_revendedores($id_rev);
			}
			
		}else 
		{
			$misiones = $this->M_configuracion->misiones($user->id);	
		}


		
        $datos['filtro2'] = '0';
        $datos['misiones'] = $misiones;
		//$datos['total_misiones'] = $this->M_configuracion->total_misiones();
		//$datos['total_misiones_aceptadas'] = $this->M_configuracion->total_misiones_aceptadas();
		//$datos['total_misiones_rechazadas'] = $this->M_configuracion->total_misiones_rechazadas();
		//$datos['total_clientes_mision'] = $this->M_configuracion->total_clientes_mision();
		
		$this->load->view('lte_header', $datos);
		$this->load->view('v_listado_misiones', $datos);
		$this->load->view('lte_footer', $datos);
	}
    public function misiones_seguimientos_filtradas()
	{
		$fnombre = $this->input->post('fil_nombre'); 
		$fnombre =trim($fnombre); 
		
		$group = array('Revendedores','ConsultorRV');
		$groupRev = array('Revendedores');

		$user = $this->ion_auth->user()->row();
		if ($this->ion_auth->in_group($group)) { 			
			$revendedor = 'true'; 			

			if($this->ion_auth->in_group($groupRev))
			{	// El usuario es revendedor
				$misiones = $this->M_configuracion->misiones_revendedores($user->id);
			}
			else
			{	// El usuario es consultor revendedor
				$id_rev = $this->M_operaciones->obt_superior($user->id);				
				$misiones = $this->M_configuracion->misiones_revendedores($id_rev);
			}
			
		}else 
		{
			$misiones = $this->M_configuracion->misiones_filtrada($user->id,$fnombre);	
		}


		
        $datos['filtro2'] = '1';
        $datos['fnombre'] = $fnombre;
        $datos['misiones'] = $misiones;
		//$datos['total_misiones'] = $this->M_configuracion->total_misiones();
		//$datos['total_misiones_aceptadas'] = $this->M_configuracion->total_misiones_aceptadas();
		//$datos['total_misiones_rechazadas'] = $this->M_configuracion->total_misiones_rechazadas();
		//$datos['total_clientes_mision'] = $this->M_configuracion->total_clientes_mision();
		
		$this->load->view('lte_header', $datos);
		$this->load->view('v_listado_misiones', $datos);
		$this->load->view('lte_footer', $datos);
	}
	
	// ------------------------------------------------------
	// Nueva misión
	
	public function nueva_mision()
	{

		$clientes = $this->M_configuracion->clientes();
		$usuarios = $this->M_configuracion->usuarios();	

		$datos['clientes'] = $clientes;
		$datos['usuarios'] = $usuarios;
		$datos['notificacion'] = $this->notificacion ? $this->notificacion : "Iniciando una misión:";
		$datos['notificacion_error'] = $this->notificacion_error;
		$datos['modo_edicion'] = false;
		
		$this->load->view('lte_header', $datos);
		$this->load->view('v_nueva_mision', $datos);
		$this->load->view('lte_footer', $datos);	
	}
	
	// ------------------------------------------------------
	// Registrar misión
	
    public function registrar_mision()
    {
		 $id_cliente = $this->input->post('id_cliente');
		 $id_usuario = $this->input->post('id_usuario');
		 $exitosa = ($this->input->post('exitosa') == 'on') ? 1 : 0; 
		 $fecha_inicio = $this->input->post('fecha_inicio');
		 $fecha_final = $this->input->post('fecha_final');
		 $notas = $this->input->post('notas');
		 
		 if ( $id_cliente != '' && $fecha_inicio != '' && $fecha_final != '' )
		 {
			 $registrado = $this->M_configuracion->registrar_mision($id_usuario, $id_cliente, $fecha_inicio, $fecha_final, $exitosa, $notas);
			 if ($registrado == 1)
				 { 
					 $this->notificacion = "La misión se registró satisfactoriamente.";
		             $this->notificacion_error = false;
				 }
				 else
				 {
					 $this->notificacion = "ERROR. No se pudo registrar la misión.";
		             $this->notificacion_error = true;
				 }
		 }
		 else
		 {
			 $this->notificacion = "ERROR. No se pudo registrar la misión. Verifique los datos especificados.";
             $this->notificacion_error = true;
		 }
		 
		 $this->nueva_mision();
		 
    }
	
	// ------------------------------------------------------
	// Editar mision
	
	public function editar_mision($id_actual)
	{
		$resultado = $this->M_configuracion->obt_mision($id_actual);
		$clientes = $this->M_configuracion->clientes();
		$usuarios = $this->M_configuracion->usuarios();	

		$datos = array();
		$datos['clientes'] = $clientes;
		$datos['usuarios'] = $usuarios;
		
		if ($resultado)
		{
		   $mision = $resultado->row();

		   $id_actual = $mision->id_mision;
		   $id_cliente = $mision->id_cliente;
		   $id_usuario = $mision->id_usuario;
		   $exitosa = ($mision->exitosa == 1) ? 'checked' : ''; 
		   $fecha_inicio = $mision->fecha_inicio;
		   $fecha_final = $mision->fecha_fin;
		   $notas = $mision->notas;
		   
		   $datos['modo_edicion'] = true;
		   $datos['notificacion'] = $this->notificacion ? $this->notificacion : "Modificando los datos de una misión";
           $datos['notificacion_error'] = $this->notificacion_error;
		   
		   $datos['id_actual'] = $id_actual;
		   $datos['id_cliente'] = $id_cliente;
		   $datos['id_usuario'] = $id_usuario;
		   $datos['exitosa'] = $exitosa;
		   $datos['fecha_inicio'] = $fecha_inicio;
		   $datos['fecha_final'] = $fecha_final;
		   $datos['notas'] = $notas;
		}
		
		$this->load->view('lte_header', $datos);
 	    $this->load->view('v_nueva_mision', $datos);
	    $this->load->view('lte_footer', $datos);
	}
	
	// ------------------------------------------------------
	// Modificar mision
    
	public function modificar_mision()
    {
		 $id_actual = $this->input->post('id_actual');
		 $id_cliente = $this->input->post('id_cliente');
		 $id_usuario = $this->input->post('id_usuario');
		 $exitosa = ($this->input->post('exitosa') == 'on') ? 1 : 0; 
		 $fecha_inicio = $this->input->post('fecha_inicio');
		 $fecha_final = $this->input->post('fecha_final');
		 $notas = $this->input->post('notas');
		 
		 if ($id_cliente != '' && $fecha_inicio != '' && $fecha_final != '')
		 {
		 
			 $modificado = $this->M_configuracion->modificar_mision($id_actual, $id_usuario, $id_cliente, $fecha_inicio, $fecha_final, $exitosa, $notas);
			 
   		     if ($modificado == 1)
			 { 
				 $this->notificacion = "La misión se modificó satisfactoriamente.";
		         $this->notificacion_error = false;
			 }
			 else
			 {
				 $this->notificacion = "ERROR. No se pudo modificar la misión. Verifique los datos especificados.";
		         $this->notificacion_error = true;
			 }
		 }
		 else
		 {
		     $this->notificacion = "ERROR. No se pudo modificar la misión. Verifique los datos especificados.";
			 $this->notificacion_error = true;
		 }
		 
		 $this->editar_mision($id_actual);
	}
	
	// ------------------------------------------------------
	// Confirmar cancelación de una misión
	
	public function cfe_mision($id_mision)
	{
		$datos['id_mision'] = $id_mision;
		
		$this->load->view('lte_header', $datos);
 	    $this->load->view('vcan_mision', $datos);
	    $this->load->view('lte_footer', $datos);
	}
	
	// ------------------------------------------------------
	// Eliminar misión
	
    public function eliminar_mision()
	{
		$id_mision = $this->input->post('id_mision');
		$eliminada = $this->M_configuracion->eliminar_mision($id_mision);
		
		if ($eliminada == 1)
	    { 
		    $this->notificacion = "La misión fue eliminada correctamente.";
		    $this->notificacion_error = false;
		}
		else
		{
		    $this->notificacion = "No se pudo eliminar la misión.";
		    $this->notificacion_error = true;  
		}
		
		$this->misiones();

	}

	
	
	/********************************************************************************************************************/
	//*******************************************************************************************************
    //*******************************************************************************************************
	//     Segunda parte
	//*******************************************************************************************************
    //*******************************************************************************************************
    /********************************************************************************************************************/
	
/********************************************************************************************************************/
	// Editando el producto color
	public function agregar_producto_color()
	{
		$id_producto= $this->input->post('id_producto');
		$id_color = $this->input->post('sel_colores');
		
		$this->load->library('form_validation');
		 
		$this->form_validation->set_rules('sel_colores', 'Nombre', 'required');
		
		if ($this->form_validation->run() == true )
		{
			$resultado = $this->M_configuracion->agregar_producto_color($id_producto,$id_color);
			
		}else{
			
			$this->notificacion = "ERROR. No existen colores.";
			$this->notificacion_error = true;
		}		
		$this->editar_producto_colores($id_producto);
	}
	public function editar_producto_colores($id_producto)
	{
		$resultado = $this->M_configuracion->obt_producto($id_producto);
		
		if ($resultado)
		{
		   $producto = $resultado->row();
		   
		   $nombre = $producto->nombre;
		   $datos['nombre']  = $nombre;
		   $datos['id_producto']  = $id_producto;
		}
		
		$resultado_colores = $this->M_configuracion->obt_colores();		
		$datos['colores'] = $resultado_colores;	
		$producto_colores = $this->M_configuracion->obt_colores_productos($id_producto);
		$datos['producto_colores'] = $producto_colores;

		$datos['modo_edicion'] = true;
		$datos['notificacion'] = 'Modificando los colores del producto: '  . $nombre;
		if($this->notificacion_error == true){
			
			$datos['notificacion'] = $this->notificacion;				
			$datos['notificacion_error'] = $this->notificacion_error;
			$this->load->view('lte_header', $datos);
			$this->load->view('v_productos_colores', $datos);
			$this->load->view('lte_footer', $datos);
			
			return;
		}
		 
		if ($resultado_colores->result())
		{
			$this->notificacion = 'Modificando los colores del producto: ' . $nombre;
			$this->notificacion_error == false;
			
		} else{
			
			$this->notificacion = 'No existen colores registrados, no podrá realizar la operación';
			$this->notificacion_error == true;
		}				

		$datos['notificacion'] = $this->notificacion;
		$datos['notificacion_error'] = $this->notificacion_error;
		$this->load->view('lte_header', $datos);
 	    $this->load->view('v_productos_colores', $datos);
	    $this->load->view('lte_footer', $datos);
	}
	 public function cancelar_producto_color()
	{
		$id_producto = $this->input->post('id_producto');
		$id_color = $this->input->post('id_color');

		$cancelado = $this->M_configuracion->cancelar_producto_color($id_producto, $id_color);
		
		if ($cancelado == 1)
	    { 
		   $this->not_fcliente = "Se eliminó el color correctamente.";
		}
		else
		{
		   $this->not_fcliente = "ERROR. No se pudo eliminar el color. Verifique los datos especificados.";
		}
		
		$this->editar_producto_colores($id_producto);

	}
	public function cfe_producto_color($id_producto, $id_color)
	{
		$datos['id_producto'] = $id_producto;
		$datos['id_color'] = $id_color;
		
		$this->load->view('lte_header', $datos);
 	    $this->load->view('vcan_producto_colores', $datos);
	    $this->load->view('lte_footer', $datos);
	}
	//+++++++++++++++++++++++++++++
	public function agregar_combo_producto()
	{
		$id_combo= $this->input->post('id_combo');
		$cantidad= $this->input->post('cantidad');
		$id_producto = $this->input->post('sel_productos');
		
		$this->load->library('form_validation');
		 
		$this->form_validation->set_rules('sel_productos', 'Nombre', 'required');
		
		if ($this->form_validation->run() == true )
		{
			$resultado = $this->M_configuracion->agregar_combo_producto($id_combo, $id_producto, $cantidad);
			
		}else{
			
			$this->notificacion = "ERROR. No existen colores.";
			$this->notificacion_error = true;
		}		
		$this->editar_combo_producto($id_combo);
	}
	public function editar_combo_producto($id_combo)
	{
		$resultado = $this->M_configuracion->obt_combo($id_combo);
		
		if ($resultado)
		{
		   $producto = $resultado->row();
		   
		   $nombre = $producto->nombre;
		   $datos['nombre']  = $nombre;
		   $datos['id_combo']  = $id_combo;
		   
		}
		
		$resultado_productos = $this->M_configuracion->obt_productos_rev();		
		$datos['productos'] = $resultado_productos;	
		$combo_productos = $this->M_configuracion->obt_combo_productos($id_combo);
		$datos['combo_productos'] = $combo_productos;

		$datos['modo_edicion'] = true;
		$datos['notificacion'] = 'Modificando los productos del combo: '  . $nombre;
		if($this->notificacion_error == true){
			
			$datos['notificacion'] = $this->notificacion;				
			$datos['notificacion_error'] = $this->notificacion_error;
			$this->load->view('lte_header', $datos);
			$this->load->view('v_combo_productos', $datos);
			$this->load->view('lte_footer', $datos);
			
			return;
		}
		 
		if ($resultado_productos->result())
		{
			$this->notificacion = 'Modificando los productos del combo: ' . $nombre;
			$this->notificacion_error == false;
			
		} else{
			
			$this->notificacion = 'No existen productos registrados, no podrá realizar la operación';
			$this->notificacion_error == true;
		}				

		$datos['notificacion'] = $this->notificacion;
		$datos['notificacion_error'] = $this->notificacion_error;
		$this->load->view('lte_header', $datos);
 	    $this->load->view('v_combo_productos', $datos);
	    $this->load->view('lte_footer', $datos);
	}
	 public function cancelar_combo_producto()
	{
		$id_producto = $this->input->post('id_producto');
		$id_combo = $this->input->post('id_combo');

		$cancelado = $this->M_configuracion->cancelar_combo_producto($id_combo, $id_producto);
		
		if ($cancelado == 1)
	    { 
		   $this->not_fcliente = "Se eliminó el producto correctamente.";
		}
		else
		{
		   $this->not_fcliente = "ERROR. No se pudo eliminar el producto. Verifique los datos especificados.";
		}
		
		$this->editar_combo_producto($id_combo);

	}
	public function cfe_combo_producto($id_combo, $id_producto)
	{
		$datos['id_producto'] = $id_producto;
		$datos['id_combo'] = $id_combo;
		
		$this->load->view('lte_header', $datos);
 	    $this->load->view('vcan_combo_productos', $datos);
	    $this->load->view('lte_footer', $datos);
	}
	/********************************************************************************************************************/
	// Editando el producto repuesto
	public function agregar_producto_repuesto()
	{
		$id_producto= $this->input->post('id_producto');
		$id_repuesto = $this->input->post('sel_repuestos');
		$this->load->library('form_validation');
		 
		$this->form_validation->set_rules('sel_repuestos', 'Respuestos', 'required');

		if ($this->form_validation->run() == true )
		{
			$resultado = $this->M_configuracion->agregar_producto_repuesto($id_producto,$id_repuesto);
		}else{
	
			$this->notificacion = "ERROR. No existen respuestos.";
			$this->notificacion_error = true;
		}
		
		$this->editar_producto_repuestos($id_producto);
	}
	public function editar_producto_repuestos($id_producto)
	{
		$resultado = $this->M_configuracion->obt_producto($id_producto);
		if ($resultado)
		{
		   $producto = $resultado->row();
		   $nombre = $producto->nombre;
		   $datos['nombre']  = $nombre;
		   $datos['id_producto']  = $id_producto;
		}
		
		$resultado_respuestos = $this->M_configuracion->obt_repuestos();
		$datos['repuestos'] = $resultado_respuestos;
		$producto_repuestos = $this->M_configuracion->obt_repuestos_productos($id_producto);
		$datos['producto_repuestos'] = $producto_repuestos;

		$datos['modo_edicion'] = true;
		
		if($this->notificacion_error == true){
			
			$datos['notificacion'] = $this->notificacion;				
			$datos['notificacion_error'] = $this->notificacion_error;
			$this->load->view('lte_header', $datos);
			$this->load->view('v_productos_repuestos', $datos);
			$this->load->view('lte_footer', $datos);
			
			return;
		}
		
		if ($resultado_respuestos->result())
		{
			$this->notificacion = 'Modificando los respuestos del producto: ' . $nombre;
			$this->notificacion_error == false;
			
		} else{
			
			$this->notificacion = 'No existen respuestos registrados, no podrá realizar la operación';
			$this->notificacion_error == true;
		}
		
		$datos['notificacion'] = $this->notificacion;
		$datos['notificacion_error'] = $this->notificacion_error;
		$this->load->view('lte_header', $datos);
 	    $this->load->view('v_productos_repuestos', $datos);
	    $this->load->view('lte_footer', $datos);
	}
	 public function cancelar_producto_repuesto()
	{
		$id_producto = $this->input->post('id_producto');
		$id_repuesto = $this->input->post('id_repuesto');

		$cancelado = $this->M_configuracion->cancelar_producto_repuesto($id_producto, $id_repuesto);
		
		if ($cancelado == 1)
	    { 
		   $this->not_fcliente = "Se eliminó el color correctamente.";
		}
		else
		{
		   $this->not_fcliente = "ERROR. No se pudo eliminar el repuesto. Verifique los datos especificados.";
		}
		
		$this->editar_producto_repuestos($id_producto);

	}
	public function cfe_producto_repuesto($id_producto, $id_repuesto)
	{
		$datos['id_producto'] = $id_producto;
		$datos['id_repuesto'] = $id_repuesto;
		
		$this->load->view('lte_header', $datos);
 	    $this->load->view('vcan_producto_repuestos', $datos);
	    $this->load->view('lte_footer', $datos);
	}
	/********************************************************************************************************************/
	// Interfaz para registrar un nuevo producto
	public function nuevo_producto()
	{		
		$categorias = $this->M_configuracion->obt_categorias();	
		$datos['categorias'] = $categorias;

		$datos['notificacion'] = "Especifique los datos del nuevo producto:";
		$datos['modo_edicion'] = false;
		$datos['notificacion_error'] = false;
		
		$this->load->view('lte_header', $datos);
		$this->load->view('v_productos', $datos);
		$this->load->view('lte_footer', $datos);	
	}
	public function nuevo_combo()
	{	
		$categorias = $this->M_configuracion->obt_categorias();	
		$datos['categorias'] = $categorias;
		$datos['notificacion'] = "Especifique los datos del nuevo combo:";
		$datos['modo_edicion'] = false;
		$datos['notificacion_error'] = false;
		$datos['imagen'] = '';
		$datos['id_actual'] = '';
		
		$this->load->view('lte_header', $datos);
		$this->load->view('v_combos', $datos);
		$this->load->view('lte_footer', $datos);	
	}
	/********************************************************************************************************************/
	// Editando el producto
	public function editar_producto($id_actual)
	{
		$categorias = $this->M_configuracion->obt_categorias();	
		$datos['categorias'] = $categorias;
		$resultado = $this->M_configuracion->obt_producto($id_actual);
		
		if ($resultado)
		{
		   $producto = $resultado->row();

		   $id_producto 	= $id_actual;
		   $nombre 			= $producto->nombre;
		   $precio 			= $producto->precio;
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
		   $disponible_a_rev = $producto->disponible_a_rev;
		   		   
		   $datos['modo_edicion'] = true;
		   $datos['notificacion'] = 'Modificando los datos del producto: '  . $nombre;
		   $datos['notificacion_error'] = $this->notificacion_error;
		   
		   $datos['id_actual']    	= $id_actual;
		   $datos['id_producto']  	= $id_producto;
		   $datos['nombre']  		= $nombre;
		   $datos['precio']       	= $precio;
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
		   $datos['disponible_a_rev'] 			= $disponible_a_rev;
		}
		
		$this->load->view('lte_header', $datos);
 	    $this->load->view('v_productos', $datos);
	    $this->load->view('lte_footer', $datos);
	}
	public function editar_combo_rev($id_actual)
	{
		$categorias = $this->M_configuracion->obt_categorias();	
		$datos['categorias'] = $categorias;
		$resultado = $this->M_configuracion->obt_combo($id_actual);
		
		if ($resultado)
		{
		   $producto = $resultado->row();

		   $id_producto 	= $id_actual;
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
		   
		   $datos['id_actual']    	= $id_actual;
		   $datos['id_producto']  	= $id_producto;
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
		   $datos['imagen'] 			= $imagen;
		}
		
		$this->load->view('lte_header', $datos);
 	    $this->load->view('v_combos', $datos);
	    $this->load->view('lte_footer', $datos);
	}
	public function editar_producto_rev($id_actual)
	{
		$categorias = $this->M_configuracion->obt_categorias();	
		$datos['categorias'] = $categorias;
		$resultado = $this->M_configuracion->obt_producto($id_actual);
		
		if ($resultado)
		{
		   $producto = $resultado->row();

		   $id_producto 	= $id_actual;
		   $nombre 			= $producto->nombre;
		   $precio_may		= $producto->precio_mayorista;
		   $precio_rev		= $producto->precio_rev;
		   $min_may			= $producto->cant_min_may;
		   $min_rev			= $producto->cant_min_rev;
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
		   
		   $datos['id_actual']    	= $id_actual;
		   $datos['id_producto']  	= $id_producto;
		   $datos['nombre']  		= $nombre;
		   $datos['precio_may']     = $precio_may;
		   $datos['precio_rev']    	= $precio_rev;
		   $datos['min_may']     	= $min_may;
		   $datos['min_rev']    	= $min_rev;
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
		
		$this->load->view('lte_header', $datos);
 	    $this->load->view('v_productos_rev', $datos);
	    $this->load->view('lte_footer', $datos);
	}

	
	/********************************************************************************************************************/
	// Confirmar eliminación de un producto
	public function cfe_producto($id_producto)
	{
		$datos['id_producto'] = $id_producto;
		
		$this->load->view('lte_header', $datos);
 	    $this->load->view('vcan_productos', $datos);
	    $this->load->view('lte_footer', $datos);
	}
	public function cfe_combo($id_producto)
	{
		$datos['id_producto'] = $id_producto;
		
		$this->load->view('lte_header', $datos);
 	    $this->load->view('vcan_combos', $datos);
	    $this->load->view('lte_footer', $datos);
	}
	/********************************************************************************************************************/
	// Cancelar producto
    public function cancelar_producto()
	{
		$id_producto = $this->input->post('id_producto');
		$cancelado = $this->M_configuracion->cancelar_producto($id_producto);
		
		if ($cancelado == 1)
	    { 
		   $this->not_fcliente = "Se eliminó el producto correctamente.";
		   $this->obt_productos();
		}
		else
		{		
			$datos['notificacion'] = "ERROR. No se pudo eliminar el producto. Verifique los datos especificados.";	
		   	//$this->not_fcliente = "ERROR. No se pudo eliminar el producto. Verifique los datos especificados.";
		   	$this->load->view('lte_header', $datos);
 	    	$this->load->view('alertas', $datos);
	    	$this->load->view('lte_footer', $datos);
		}
	}
    public function cancelar_combo()
	{
		$id_producto = $this->input->post('id_producto');
		$cancelado = $this->M_configuracion->cancelar_combo($id_producto);
		
		if ($cancelado == 1)
	    { 
		   $this->not_fcliente = "Se eliminó el producto correctamente.";
		   $this->obt_combos_rev();
		}
		else
		{		
			$datos['notificacion'] = "ERROR. No se pudo eliminar el producto. Verifique los datos especificados.";	
		   	//$this->not_fcliente = "ERROR. No se pudo eliminar el producto. Verifique los datos especificados.";
		   	$this->load->view('lte_header', $datos);
 	    	$this->load->view('alertas', $datos);
	    	$this->load->view('lte_footer', $datos);
		}
	}
	/********************************************************************************************************************/
	// Listado de productos
    public function obt_productos()
	{
		$productos = $this->M_operaciones->productos();
		
		$productos_sin_color = $this->M_configuracion->obt_productos_sin_colores();
		
		$resultado=$productos_sin_color->result();
	    if(count($resultado)>=1) $valor=1; else $valor=0;
		
        $datos['valor'] = $valor;
        $datos['productos'] = $productos;
		
        $datos['productos_sin_color'] = $productos_sin_color;
		$datos['total_productos'] = $this->M_configuracion->total_productos();
		$datos['total_productos_repuesto'] = $this->M_configuracion->total_productos_repuesto();
		// Actualizar todos los productos que no tengan campaña como sin campaña
		$resultado= $this->M_configuracion->actualizar_sin_campana();
		$this->load->view('lte_header', $datos);
		$this->load->view('v_listado_productos', $datos);
		$this->load->view('lte_footer', $datos);

	}
    public function obt_productos_rev()
	{
		$productos = $this->M_operaciones->productos_rev();
		
		$productos_sin_color = $this->M_configuracion->obt_productos_sin_colores();
		
		$resultado=$productos_sin_color->result();
	    if(count($resultado)>=1) $valor=1; else $valor=0;
		
        $datos['valor'] = $valor;
        $datos['productos'] = $productos;
		
        $datos['productos_sin_color'] = $productos_sin_color;
		$datos['total_productos'] = $this->M_configuracion->total_productos();
		$datos['total_productos_repuesto'] = $this->M_configuracion->total_productos_repuesto();
		// Actualizar todos los productos que no tengan campaña como sin campaña
		$resultado= $this->M_configuracion->actualizar_sin_campana();
		$this->load->view('lte_header', $datos);
		$this->load->view('v_listado_productos_rev', $datos);
		$this->load->view('lte_footer', $datos);

	}
    public function obt_combos_rev()
	{
		$productos = $this->M_operaciones->combos();
		
		$combos_sin_productos = $this->M_configuracion->obt_combos_sin_productos();
		
		$resultado=$combos_sin_productos->result();
	    if(count($resultado)>=1) $valor=1; else $valor=0;
		
        $datos['valor'] = $valor;
        $datos['productos'] = $productos;
		
        $datos['combos_sin_productos'] = $combos_sin_productos;
		$datos['total_productos'] = $productos->num_rows();
		//$datos['total_productos_repuesto'] = $this->M_configuracion->total_productos_repuesto();
		// Actualizar todos los productos que no tengan campaña como sin campaña
		$resultado= $this->M_configuracion->actualizar_sin_campana();
		$this->load->view('lte_header', $datos);
		$this->load->view('v_listado_combos_rev', $datos);
		$this->load->view('lte_footer', $datos);

	}
	public function obtener_producto($id_producto)
	{
		if ($this->session->userdata('perfil') == false || $this->session->userdata('perfil') != 'emprendedor') {
            redirect(base_url() . 'login');
        }

	     $id_emp                 = $this->session->userdata('id_emp'); 
	     $data['cant_asoc']      = $this->modelogeneral->rowCountAsoc($id_emp);
	     $data['result']         = $this->modelogeneral->mostrar_asoc($id_emp);
	     $data['datos_emp']      = $this->modelogeneral->datos_emp($id_emp);
	     $data['ultimo_reg']     = $this->modelogeneral->las_insetCap(); 
	     $data['cantidadVideos'] = $this->modelogeneral->rowCount("capacitacion");
	     $data['sumatoriaComp']  = $this->modelogeneral->sumatoriaCompraEmp($id_emp);
	     $data['cantidad_prod']  = $this->modelogeneral->count_cantProdCar($id_emp); 

	     $prod = $this->M_configuracion->obt_producto($id_producto);
		
		$group = array('ConsultorRVInt'); 
		/*if ($this->ion_auth->in_group($group)){			
			$user = $this->ion_auth->user()->row();
			$id_usuario = $user->id;
			$id_pais= $this->M_operaciones->obt_rev_pais($id_emp);
			
			$prod = $this->M_configuracion->obt_producto_rev_int($id_producto,$id_pais);
		}else{
			$prod = $this->M_configuracion->obt_producto($id_producto);
		}*/
		
        $row = $prod->row_array();
		echo json_encode($row);  
	}
	public function obtener_productoint($id_producto)
	{
		$group = array('ConsultorRVInt'); 
		if ($this->ion_auth->in_group($group)){			
			$user = $this->ion_auth->user()->row();
			$id_usuario = $user->id;
			$id_pais= $this->M_operaciones->obt_rev_pais($id_usuario);
			
			$prod = $this->M_configuracion->obt_producto_rev_int($id_producto,$id_pais);
		}else{
			$prod = $this->M_configuracion->obt_producto($id_producto);
		}
		
        $row = $prod->row_array();
		echo json_encode($row);  
	}
	public function obtener_combo($id_producto)
	{
		$group = array('ConsultorRVInt'); 
		if ($this->ion_auth->in_group($group)){			
			$user = $this->ion_auth->user()->row();
			$id_usuario = $user->id;
			$id_pais= $this->M_operaciones->obt_rev_pais($id_usuario);
			$prod = $this->M_configuracion->obt_combo_rev_int($id_producto,$id_pais);
		}else{
			$prod = $this->M_configuracion->obt_combo($id_producto);
		}
		
        $row = $prod->row_array();
		echo json_encode($row);  
	}
	
	public function obtener_existencia_producto_rev($id_producto)
	{
		$prod = $this->M_configuracion->obt_existencia_producto($id_producto);
        $row = $prod->row_array();
		echo json_encode($row);  
	}
	/********************************************************************************************************************/
	// Registrando un producto
    public function registrar_producto()
    {

		 $nombre = $this->input->post('nombre');
		 $precio = $this->input->post('precio');
		 $existencia = $this->input->post('existencia');
		 $es_repuesto = $this->input->post('es_repuesto');
		 $disponible_a_rev = $this->input->post('disponible_a_rev');
		 $vencimiento = $this->input->post('vencimiento');
		 $alto = $this->input->post('alto');
		 $ancho = $this->input->post('ancho');
		 $largo = $this->input->post('largo');
		 $peso = $this->input->post('peso');
		 $sku = $this->input->post('sku');
		 $codigo_barra = $this->input->post('codigo_barra');
		 $id_categoria = $this->input->post('id_categoria');
		 $valor_declarado = $this->input->post('valor_declarado');
		 $dum14 = $this->input->post('dum14');
		 
		 $this->load->library('form_validation');
		 
		 $this->form_validation->set_rules('nombre', 'Nombre', 'required');
		 $this->form_validation->set_rules('precio', 'Precio', 'required|numeric');
		 $this->form_validation->set_rules('alto', 'Alto', 'required|numeric');
		 $this->form_validation->set_rules('ancho', 'Ancho', 'required|numeric');
		 $this->form_validation->set_rules('largo', 'Largo', 'required|numeric');
		 $this->form_validation->set_rules('peso', 'Peso', 'required|numeric');
		 $this->form_validation->set_rules('existencia', 'existencia', 'required|numeric');
		 $this->form_validation->set_rules('sku', 'SKU', 'required');
		 $this->form_validation->set_rules('codigo_barra', 'Código de barra', 'required');
		 $this->form_validation->set_rules('valor_declarado', 'Valor declarado', 'required|numeric');

		 if ($this->form_validation->run() == true )
		 {		 
			 $registrado = $this->M_configuracion->registrar_producto( $nombre, $precio, $existencia, $es_repuesto, $vencimiento,$alto, $ancho, $largo, $peso, $sku, $codigo_barra,$id_categoria, $valor_declarado, $dum14, $disponible_a_rev);
			 
			 $mensaje = "";
			 if ($registrado == 1)
				 { 
					$this->notificacion = "Se ha registrado un nuevo producto.";
		            $this->notificacion_error = false;					
				 }
				 else
				 { 
					$this->notificacion = "ERROR. No se pudo registrar el producto. Verifique los datos especificados.";
		            $this->notificacion_error = true;					
				 }
				 
		 }
		 else
		 {
		     $this->notificacion = validation_errors();
			 $this->notificacion_error = true;
			 
		 }
		 if($this->notificacion_error == true){
			
			$datos['nombre'] = $nombre;
			$datos['precio'] = $precio;
			$datos['existencia'] = $existencia;			

			$datos['notificacion'] = $this->notificacion ? $this->notificacion : "Error registrando el producto " . $nombre;
          	$datos['notificacion_error'] = $this->notificacion_error;
			$datos['modo_edicion'] = false;

			$this->load->view('lte_header', $datos);
			$this->load->view('v_productos', $datos);
			$this->load->view('lte_footer', $datos);  
		 }else
		 	$this->obt_productos();
		 
		 
    }
    public function registrar_combo()
    {

		 $nombre 		= $this->input->post('nombre');
		 $precio_may 	= $this->input->post('precio_may');
		 $precio_rev 	= $this->input->post('precio_rev');
		 $min_may 		= $this->input->post('min_may');
		 $min_rev 		= $this->input->post('min_rev');
		 $existencia 	= $this->input->post('existencia');		 
		 //$alto 			= $this->input->post('alto');
		 //$ancho 		= $this->input->post('ancho');
		 //$largo 		= $this->input->post('largo');
		 //$peso 			= $this->input->post('peso');
		 //$sku 			= $this->input->post('sku');
		 //$codigo_barra 	= $this->input->post('codigo_barra');
		 //$id_categoria 	= $this->input->post('id_categoria');
		 //$valor_declarado = $this->input->post('valor_declarado');
		 //$dum14 		= $this->input->post('dum14');

		 $imagen ='';
		 
		 $this->load->library('form_validation');
		 
		 $this->form_validation->set_rules('nombre', 'Nombre', 'required');
		 $this->form_validation->set_rules('precio_may', 'Precio Mayorista', 'required|numeric');
		 $this->form_validation->set_rules('precio_rev', 'Precio Revendedor', 'required|numeric');
		 $this->form_validation->set_rules('min_may', 'Q min Mayorista', 'required|numeric');
		 $this->form_validation->set_rules('min_rev', 'Q min Revendedor', 'required|numeric');
		 // $this->form_validation->set_rules('alto', 'Alto', 'required|numeric');
		 // $this->form_validation->set_rules('ancho', 'Ancho', 'required|numeric');
		 // $this->form_validation->set_rules('largo', 'Largo', 'required|numeric');
		 // $this->form_validation->set_rules('peso', 'Peso', 'required|numeric');
		 $this->form_validation->set_rules('existencia', 'existencia', 'required|numeric');
		 //$this->form_validation->set_rules('sku', 'SKU', 'required');
		// $this->form_validation->set_rules('codigo_barra', 'Código de barra', 'required');
		 // $this->form_validation->set_rules('valor_declarado', 'Valor declarado', 'required|numeric');

		 if ($this->form_validation->run() == true )
		 {		 
			 $registrado = $this->M_configuracion->registrar_combo( $nombre, $precio_may,$precio_rev,$min_may,$min_rev, $existencia);
			 
			 $mensaje = "";
			 if ($registrado == 1)
				 { 
					$this->notificacion = "Se ha registrado un nuevo producto.";
		            $this->notificacion_error = false;					
				 }
				 else
				 { 
					$this->notificacion = "ERROR. No se pudo registrar el producto. Verifique los datos especificados.";
		            $this->notificacion_error = true;					
				 }
				 
		 }
		 else
		 {
		     $this->notificacion = validation_errors();
			 $this->notificacion_error = true;
			 
		 }
		 if($this->notificacion_error == true){
				
			$datos['nombre'] = $nombre;
			$datos['precio_may'] = $precio_may;
			$datos['precio_rev'] = $precio_rev;
			$datos['min_may'] = $min_may;
			$datos['min_rev'] = $min_rev;
			$datos['existencia'] = $existencia;			

			$datos['notificacion'] = $this->notificacion ? $this->notificacion : "Error registrando el producto " . $nombre;
          	$datos['notificacion_error'] = $this->notificacion_error;
			$datos['modo_edicion'] = false;

			$this->load->view('lte_header', $datos);
			$this->load->view('v_combos', $datos);
			$this->load->view('lte_footer', $datos);  
		 }else
		 	$this->obt_combos_rev();
		 
		 
    }
	/********************************************************************************************************************/
	// Modificando un producto
    public function modificar_producto()
    {
		$categorias = $this->M_configuracion->obt_categorias();	
		$datos['categorias'] = $categorias;
		 $id_actual = $this->input->post('id_actual');
		 $nombre = $this->input->post('nombre');
		 $precio = $this->input->post('precio');
		 $existencia = $this->input->post('existencia');
		 $es_repuesto = $this->input->post('es_repuesto');
		 $disponible_a_rev = $this->input->post('disponible_a_rev');
		 $vencimiento = $this->input->post('vencimiento');
		 $alto = $this->input->post('alto');
		 $ancho = $this->input->post('ancho');
		 $largo = $this->input->post('largo');
		 $peso = $this->input->post('peso');
		 $sku = $this->input->post('sku');
		 $codigo_barra = $this->input->post('codigo_barra');
		 $id_categoria = $this->input->post('id_categoria');
		 $valor_declarado = $this->input->post('valor_declarado');
		 $dum14 = $this->input->post('dum14');

		 $this->load->library('form_validation');
		 
		 $this->form_validation->set_rules('nombre', 'Nombre', 'required');
		 $this->form_validation->set_rules('precio', 'Precio', 'required');
		 $this->form_validation->set_rules('existencia', 'existencia', 'required|numeric');
		 
		 if ($this->form_validation->run() == true )
		 {
			 $modificado = $this->M_configuracion->modificar_producto($id_actual,  $nombre, $precio, $existencia,$es_repuesto, $vencimiento, $alto, $ancho, $largo, $peso, $sku, $codigo_barra, $id_categoria, $valor_declarado, $dum14,$disponible_a_rev);
			 
   		     if ($modificado == 1)
			 { 
				 $this->notificacion = "El producto se modificó satisfactoriamente.";
				 $this->notificacion_error = false;
			 }
			 else
			 {
				 $this->notificacion = "ERROR. No se pudo modificar el producto. Verifique los datos especificados.";
				 $this->notificacion_error = true;
			 }
				 
		 }
		 else
		 {
		     $this->notificacion = validation_errors();
			 $this->notificacion_error = true;
			 
		 }
		 if($this->notificacion_error == true){
			 
			 $datos['id_actual']    = $id_actual;
		     $datos['nombre']  		= $nombre;
		     $datos['precio']       = $precio;
		     $datos['existencia']   = $existencia;
		     $datos['es_repuesto'] 	= $es_repuesto;
		     $datos['disponible_a_rev'] 	= $disponible_a_rev;
		     $datos['vencimiento']  = $vencimiento;
			 $datos['alto']       	= $alto;
		     $datos['ancho']       	= $ancho;
		     $datos['largo'] 		= $largo;
		     $datos['peso']  		= $peso;
			 $datos['sku']			= $sku;
		     $datos['codigo_barra'] = $codigo_barra;
			 $datos['id_categoria'] = $id_categoria;
			 $datos['valor_declarado'] = $valor_declarado;
			 $datos['dum14'] 		= $dum14;
			 		 
			 $datos['notificacion'] = $this->notificacion ? $this->notificacion : "Error modificando los datos del producto " . $nombre;
			 $datos['modo_edicion'] = true;
			 $datos['notificacion_error'] = $this->notificacion_error;
		    
			$this->load->view('lte_header', $datos);
			$this->load->view('v_productos', $datos);
			$this->load->view('lte_footer', $datos);  
		 
		 }else
	
		 $this->obt_productos();
	}
    public function modificar_combo()
    {
		$categorias = $this->M_configuracion->obt_categorias();	
		$datos['categorias'] = $categorias;
		 $id_actual = $this->input->post('id_actual');
		 $nombre = $this->input->post('nombre');
		 $precio_may = $this->input->post('precio_may');
		 $precio_rev = $this->input->post('precio_rev');
		 $min_may = $this->input->post('min_may');
		 $min_rev = $this->input->post('min_rev');
		 $existencia = $this->input->post('existencia');
		 $alto = $this->input->post('alto');
		 $ancho = $this->input->post('ancho');
		 $largo = $this->input->post('largo');
		 $peso = $this->input->post('peso');
		 $sku = $this->input->post('sku');
		 $codigo_barra = $this->input->post('codigo_barra');
		 $id_categoria = $this->input->post('id_categoria');
		 $valor_declarado = $this->input->post('valor_declarado');
		 $dum14 = $this->input->post('dum14');
		$imagen = '';
		 $this->load->library('form_validation');
		 
		 $this->form_validation->set_rules('nombre', 'Nombre', 'required');
		 $this->form_validation->set_rules('precio_may', 'Precio Mayorista', 'required|numeric');
		 $this->form_validation->set_rules('precio_rev', 'Precio Revendedor', 'required|numeric');
		 $this->form_validation->set_rules('min_may', 'Q min Mayorista', 'required|numeric');
		 $this->form_validation->set_rules('min_rev', 'Q min Revendedor', 'required|numeric');
		 $this->form_validation->set_rules('existencia', 'existencia', 'required|numeric');
		 
		 if ($this->form_validation->run() == true )
		 {
			 $modificado = $this->M_configuracion->modificar_combo($id_actual, $nombre, $precio_may,$precio_rev,$min_may,$min_rev,$existencia, $alto, $ancho, $largo, $peso, $sku, $codigo_barra, $id_categoria, $valor_declarado, $dum14,$imagen);
			 
   		     if ($modificado == 1)
			 { 
				 $this->notificacion = "El producto se modificó satisfactoriamente.";
				 $this->notificacion_error = false;
			 }
			 else
			 {
				 $this->notificacion = "ERROR. No se pudo modificar el producto. Verifique los datos especificados.";
				 $this->notificacion_error = true;
			 }
				 
		 }
		 else
		 {
		     $this->notificacion = validation_errors();
			 $this->notificacion_error = true;
			 
		 }
		 if($this->notificacion_error == true){
			 
			 $datos['id_actual']    = $id_actual;
		     $datos['nombre']  		= $nombre;
		     $datos['precio_may']       = $precio_may;
		     $datos['precio_rev']       = $precio_rev;
		     $datos['min_may']       = $min_may;
		     $datos['min_rev']       = $min_rev;
		     $datos['existencia']   = $existencia;
		     $datos['alto']       	= $alto;
		     $datos['ancho']       	= $ancho;
		     $datos['largo'] 		= $largo;
		     $datos['peso']  		= $peso;
			 $datos['sku']			= $sku;
		     $datos['codigo_barra'] = $codigo_barra;
			 $datos['id_categoria'] = $id_categoria;
			 $datos['valor_declarado'] = $valor_declarado;
			 $datos['dum14'] 		= $dum14;
			 $datos['imagen'] 		= $imagen;
			 		 
			 $datos['notificacion'] = $this->notificacion ? $this->notificacion : "Error modificando los datos del producto " . $nombre;
			 $datos['modo_edicion'] = true;
			 $datos['notificacion_error'] = $this->notificacion_error;
		    
			$this->load->view('lte_header', $datos);
			$this->load->view('v_combos', $datos);
			$this->load->view('lte_footer', $datos);  
		 
		 }else
	
		 $this->obt_combos_rev();
	}
    public function modificar_producto_rev()
    {
		$categorias = $this->M_configuracion->obt_categorias();	
		$datos['categorias'] = $categorias;
		 $id_actual = $this->input->post('id_actual');
		 $nombre = $this->input->post('nombre');
		 $precio_may = $this->input->post('precio_may');
		 $precio_rev = $this->input->post('precio_rev');
		 $existencia = $this->input->post('existencia');
		 $min_may = $this->input->post('min_may');
		 $min_rev = $this->input->post('min_rev');
		 $es_repuesto = $this->input->post('es_repuesto');
		 $vencimiento = $this->input->post('vencimiento');
		 $alto = $this->input->post('alto');
		 $ancho = $this->input->post('ancho');
		 $largo = $this->input->post('largo');
		 $peso = $this->input->post('peso');
		 $sku = $this->input->post('sku');
		 $codigo_barra = $this->input->post('codigo_barra');
		 $id_categoria = $this->input->post('id_categoria');
		 $valor_declarado = $this->input->post('valor_declarado');
		 $dum14 = $this->input->post('dum14');

		 $this->load->library('form_validation');
		 
		 $this->form_validation->set_rules('nombre', 'Nombre', 'required');
		 
		 $this->form_validation->set_rules('existencia', 'existencia', 'required|numeric');
		 
		 if ($this->form_validation->run() == true )
		 {
			 $modificado = $this->M_configuracion->modificar_producto_rev($id_actual,  $nombre, $precio_may,$precio_rev, $existencia,$es_repuesto, $vencimiento, $alto, $ancho, $largo, $peso, $sku, $codigo_barra, $id_categoria, $valor_declarado, $dum14, $min_may, $min_rev);
			 
   		     if ($modificado == 1)
			 { 
				 $this->notificacion = "El producto se modificó satisfactoriamente.";
				 $this->notificacion_error = false;
			 }
			 else
			 {
				 $this->notificacion = "ERROR. No se pudo modificar el producto. Verifique los datos especificados.";
				 $this->notificacion_error = true;
			 }
				 
		 }
		 else
		 {
		     $this->notificacion = validation_errors();
			 $this->notificacion_error = true;
			 
		 }
		 if($this->notificacion_error == true){
			 
			 $datos['id_actual']    = $id_actual;
		     $datos['nombre']  		= $nombre;
		     $datos['precio_may']   = $precio_may;
		     $datos['precio_rev']   = $precio_rev;
		     $datos['min_may']   	= $min_may;
		     $datos['min_rev']   	= $min_rev;
		     $datos['existencia']   = $existencia;
		     $datos['es_repuesto'] 	= $es_repuesto;
		     $datos['vencimiento']  = $vencimiento;
			 $datos['alto']       	= $alto;
		     $datos['ancho']       	= $ancho;
		     $datos['largo'] 		= $largo;
		     $datos['peso']  		= $peso;
			 $datos['sku']			= $sku;
		     $datos['codigo_barra'] = $codigo_barra;
			 $datos['id_categoria'] = $id_categoria;
			 $datos['valor_declarado'] = $valor_declarado;
			 $datos['dum14'] 		= $dum14;
			 		 
			 $datos['notificacion'] = $this->notificacion ? $this->notificacion : "Error modificando los datos del producto " . $nombre;
			 $datos['modo_edicion'] = true;
			 $datos['notificacion_error'] = $this->notificacion_error;
		    
			$this->load->view('lte_header', $datos);
			$this->load->view('v_productos_rev', $datos);
			$this->load->view('lte_footer', $datos);  
		 
		 }else
	
		 $this->obt_productos_rev();
	}
	/********************************************************************************************************************/
   //*******************************************************************************************************
    //*******************************************************************************************************
	//     Gestion de empresas fletes
	//*******************************************************************************************************
    // Interfaz para registrar un nueva empresa
	public function nuevo_empresa()
	{		
		$datos['notificacion'] = "Especifique los datos de la nueva empresa:";
		$datos['modo_edicion'] = false;
		$datos['notificacion_error'] = $this->notificacion_error;
				
		$this->load->view('lte_header', $datos);
		$this->load->view('v_empresas', $datos);
		$this->load->view('lte_footer', $datos);	
	}
	/********************************************************************************************************************/
	// Editando la empresa
	public function obt_empresa_tipo_empresa($id_empresa){
		$resultado = $this->M_configuracion->obt_empresa_tipo_empresa1($id_empresa);
		foreach ($resultado->result() as $mun)
			echo '<option value="' . $mun->id_tipo_empresa . '">' . $mun->nombre . '</option>';
	}
	public function editar_empresa($id_actual)
	{
		$resultado = $this->M_configuracion->obt_empresa($id_actual);
		
		if ($resultado)
		{
		   $empresa = $resultado->row();

		   $id_empresa = $id_actual;
		   $descripcion = $empresa->nombre;
		   $direccion = $empresa->direccion;
		   
		   
		   $telefono = $empresa->telefono;
		   $email = $empresa->email;
		   		   
		   $datos['modo_edicion'] = true;
		   $datos['notificacion'] = 'Modificando los datos de la empresa ' . $id_empresa . ' ' . $descripcion;
		   $datos['notificacion_error'] = $this->notificacion_error;
		   
		   $datos['id_actual']    	= $id_actual;
		   $datos['id_empresa']   	= $id_empresa;
		   $datos['descripcion']  	= $descripcion;
		   $datos['direccion']    	= $direccion;
		   		   
		   $datos['telefono']     = $telefono;
		   $datos['email']        = $email;
		}
		$resultado = $this->M_configuracion->obt_empresa_tipo_empresa($id_empresa);
		$tipo_empresa1 = 0;
		$tipo_empresa2 = 0;
		$tipo_empresa3 = 0;
		if ($resultado)
		{
			
			foreach($resultado->result() as $tipo_empresa){
				
				if($tipo_empresa->id_tipo_empresa == 1){
					 $tipo_empresa1 =1;		 
				}
				if($tipo_empresa->id_tipo_empresa == 2){
					 $tipo_empresa2 =1;		 
				}
				if($tipo_empresa->id_tipo_empresa == 3){
					 $tipo_empresa3 =1;		 
				}
			}
			
		}
		$datos['tipo_empresa1']        = $tipo_empresa1;
		$datos['tipo_empresa2']        = $tipo_empresa2;
		$datos['tipo_empresa3']        = $tipo_empresa3;

		$this->load->view('lte_header', $datos);
 	    $this->load->view('v_empresas', $datos);
	    $this->load->view('lte_footer', $datos);
	}
	
	/********************************************************************************************************************/
	// Confirmar eliminación de un empresa
	public function cfe_empresa($id_empresa)
	{
		$datos['id_empresa'] = $id_empresa;
		
		$this->load->view('lte_header', $datos);
 	    $this->load->view('vcan_empresas', $datos);
	    $this->load->view('lte_footer', $datos);
	}
	/********************************************************************************************************************/
	// Cancelar empresa
    public function cancelar_empresa()
	{
		$id_empresa = $this->input->post('id_empresa');
		$cancelado = $this->M_configuracion->cancelar_empresa($id_empresa);
		
		if ($cancelado == 1)
	    { 
		   $this->not_fcliente = "Se eliminó la empresa correctamente.";
		}
		else
		{
		   $this->not_fcliente = "ERROR. No se pudo eliminar la empresa. Verifique los datos especificados.";
		}
		
		$this->obt_empresas();

	}
	/********************************************************************************************************************/
	// Listado de empresas
    public function obt_empresas()
	{
		$empresas = $this->M_configuracion->obt_empresas();	
        $datos['empresas'] = $empresas;
		$datos['total_empresas'] = $this->M_configuracion->total_empresas();
        
		$this->load->view('lte_header', $datos);
		$this->load->view('v_listado_empresa', $datos);
		$this->load->view('lte_footer', $datos);

	}
	/********************************************************************************************************************/
	// Registrando un empresa
    public function registrar_empresa()
    {
		 $id_empresa = $this->input->post('id_empresa');
		 $descripcion = $this->input->post('descripcion');
		 $direccion = $this->input->post('direccion');
		 		 
		 $telefono = $this->input->post('telefono');
		 $email = $this->input->post('email');		 
		 $tipo_empresa1 =$this->input->post('tipo_empresa1');
		 $tipo_empresa2 =$this->input->post('tipo_empresa2');
		 $tipo_empresa3 =$this->input->post('tipo_empresa3');
		 
		 $this->load->library('form_validation');
		 
		 $this->form_validation->set_rules('descripcion', 'Descripcion', 'required');
		 $this->form_validation->set_rules('direccion', 'Direccion', 'required');
		 $this->form_validation->set_rules('telefono', 'Teléfono', 'required|numeric');
		 $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
		 
		 if ($this->form_validation->run() == true )
		 {		 
			 $registrado = $this->M_configuracion->registrar_empresa( $descripcion, $direccion, $telefono, $email);
			 
			 $mensaje = "";
			 if ($registrado == 1)
				 { 
					 $this->notificacion = "La empresa se registró satisfactoriamente.";
		             $this->notificacion_error = false;
					 $id_empresa = $this->M_configuracion->obt_id_empresa($descripcion, $direccion);
					 if($tipo_empresa1){
						$id_tipo_empresa = 1;
						$registrado = $this->M_configuracion-> registrar_empresa_tipo_empresa( $id_empresa,$id_tipo_empresa);
					}
					if($tipo_empresa2){
						$id_tipo_empresa = 2;
						$registrado = $this->M_configuracion-> registrar_empresa_tipo_empresa( $id_empresa,$id_tipo_empresa);
					}
					if($tipo_empresa3){
						$id_tipo_empresa = 3;
						$registrado = $this->M_configuracion-> registrar_empresa_tipo_empresa( $id_empresa,$id_tipo_empresa);
					}
				 }
				 else
				 {
					 $this->notificacion = "ERROR. No se pudo registrar la empresa.";
		             $this->notificacion_error = true;
				 }
				 
		 }
		 else
		 {
		     $this->notificacion = validation_errors();
			 $this->notificacion_error = true;
			 
		 }
		 if($this->notificacion_error == true){
		   		   
		   $datos['id_empresa']   = $id_empresa;
		   $datos['descripcion']  = $descripcion;
		   $datos['direccion']    = $direccion;
		   $datos['telefono']     = $telefono;
		   $datos['email']        = $email;
		   
		   $datos['tipo_empresa1']        = $tipo_empresa1;
		   $datos['tipo_empresa2']        = $tipo_empresa2;
		   $datos['tipo_empresa3']        = $tipo_empresa3;

			$datos['notificacion'] = $this->notificacion ? $this->notificacion : "Error registrando la empresa";
          	$datos['notificacion_error'] = $this->notificacion_error;
			$datos['modo_edicion'] = false;

			$this->load->view('lte_header', $datos);
			$this->load->view('v_empresas', $datos);
			$this->load->view('lte_footer', $datos);  
		 
		 }else
		 $this->obt_empresas();
		 
		 
    }
	/********************************************************************************************************************/
	// Modificando un empresa
    public function modificar_empresa()
    {
		 $id_actual = $this->input->post('id_actual');
		 $id_empresa = $this->input->post('id_empresa');
		 $descripcion = $this->input->post('descripcion');
		 $direccion = $this->input->post('direccion');
		 
		 $telefono = $this->input->post('telefono');
		 $email = $this->input->post('email');
		 $tipo_empresa1 =$this->input->post('tipo_empresa1');
		 $tipo_empresa2 =$this->input->post('tipo_empresa2');
		 $tipo_empresa3 =$this->input->post('tipo_empresa3');
		 $resultado = $this->M_configuracion-> eliminar_empresa_tipo_empresa( $id_empresa);
		 if($tipo_empresa1){
			$id_tipo_empresa = 1;
			$registrado1 = $this->M_configuracion-> registrar_empresa_tipo_empresa( $id_empresa,$id_tipo_empresa);
		 }
		 if($tipo_empresa2){
			$id_tipo_empresa = 2;
			$registrado2 = $this->M_configuracion-> registrar_empresa_tipo_empresa( $id_empresa,$id_tipo_empresa);
		 }
		 if($tipo_empresa3){
			$id_tipo_empresa = 3;
			$registrado3 = $this->M_configuracion-> registrar_empresa_tipo_empresa( $id_empresa,$id_tipo_empresa);
		 }
	
		 $this->load->library('form_validation');
		 
		 $this->form_validation->set_rules('descripcion', 'Descripcion', 'required');
		 $this->form_validation->set_rules('direccion', 'Direccion', 'required');
		 $this->form_validation->set_rules('telefono', 'Teléfono', 'required|numeric');
		 $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
		 
	
		 if (   $this->form_validation->run() == true)
		 {
		 
			 $modificado = $this->M_configuracion->modificar_empresa($id_actual, $id_empresa, $descripcion, $direccion, $telefono, $email);
			 
   		     if ($modificado == 1 || $registrado1 ==1 || $registrado2 ==1 || $registrado3 ==1 )
			 { 
				 $this->notificacion = "La empresa se modificó satisfactoriamente.";
		         $this->notificacion_error = false;
			 }
			 else
			 {
				 $this->notificacion = "ERROR. No se pudo modificar la empresa. Verifique los datos especificados.";
		         $this->notificacion_error = true;
		 }
				 
		 }
		 else
		 {
		     $this->notificacion = validation_errors();
			 $this->notificacion_error = true;
			 
		 }
		 if($this->notificacion_error == true){
					   
		   $datos['id_actual']    = $id_actual;
		   $datos['id_empresa']   = $id_empresa;
		   $datos['descripcion']  = $descripcion;
		   $datos['direccion']    = $direccion;
		   $datos['telefono']     = $telefono;
		   $datos['email']        = $email;
		   
		   $datos['tipo_empresa1']        = $tipo_empresa1;
		   $datos['tipo_empresa2']        = $tipo_empresa2;
		   $datos['tipo_empresa3']        = $tipo_empresa3;

			$datos['notificacion'] = $this->notificacion ? $this->notificacion : "Error modificando la empresa.";
          	$datos['notificacion_error'] = $this->notificacion_error;
			$datos['modo_edicion'] = true;

			$this->load->view('lte_header', $datos);
			$this->load->view('v_empresas', $datos);
			$this->load->view('lte_footer', $datos); 
		 
		 }else
		 
		 $this->obt_empresas();
	}
	/********************************************************************************************************************/
	 //*******************************************************************************************************
    //*******************************************************************************************************
	//     Gestion de revendedores
	//*******************************************************************************************************
    // Interfaz para registrar un revendedor
	public function nuevo_revendedor()
	{	
        $datos['clientes']= $this->M_configuracion->obt_clientes();
        $datos['usuarios']= $this->M_configuracion->obt_user_revendedor();
		$datos['notificacion'] = "Especifique los datos del nuevo revendedor:";
		$datos['modo_edicion'] = false;
		
		$this->load->view('lte_header', $datos);
		$this->load->view('v_revendedores', $datos);
		$this->load->view('lte_footer', $datos);	
	}
	/********************************************************************************************************************/
	// Editando revendedor
	public function editar_revendedor($id_actual)
	{
		$resultado = $this->M_configuracion->obt_revendedor($id_actual);
		$datos['clientes']= $this->M_configuracion->obt_clientes();
        $datos['usuarios']= $this->M_configuracion->obt_user_revendedor();
        
		if ($resultado)
		{
		   $revendedor = $resultado->row();

		   $id = $id_actual;
		   $id_cliente = $revendedor->id_cliente;
		   $id_usuario = $revendedor->id_usuario;
		  		   		   
		   $datos['modo_edicion'] = true;
		   $datos['notificacion'] = 'Modificando los datos del revendedor' . $id_usuario ;
		   
		   $datos['id_actual']    = $id_actual;
		   $datos['id_usuario']   = $id_usuario;
		   $datos['id_cliente']   = $id_cliente;
		   
		}
		
		$this->load->view('lte_header', $datos);
 	    $this->load->view('v_revendedores', $datos);
	    $this->load->view('lte_footer', $datos);
	}
	
	/********************************************************************************************************************/
	// Confirmar eliminación del revendedor
	public function cfe_revendedor($user,$cliente)
	{
		$datos['user'] = $user;
		$datos['cliente'] = $cliente;
		
		$this->load->view('lte_header', $datos);
 	    $this->load->view('vcan_revendedores', $datos);
	    $this->load->view('lte_footer', $datos);
	}
	/********************************************************************************************************************/
	// Cancelar revendedor
    public function cancelar_revendedor()
	{
		$user = $this->input->post('user');
		$cliente = $this->input->post('cliente');
		$cancelado = $this->M_configuracion->cancelar_revendedor($user,$cliente);
		
		if ($cancelado == 1)
	    { 
		   $this->not_fcliente = "Se eliminó el revendedor correctamente.";
		}
		else
		{
		   $this->not_fcliente = "ERROR. No se pudo eliminar el revendedor. Verifique los datos especificados.";
		}
		
		$this->obt_revendedores();

	}
	/********************************************************************************************************************/
	// Listado de revendedor
    public function obt_revendedores()
	{
		$revendedor = $this->M_configuracion->obt_revendedores();	
        $datos['revendedores'] = $revendedor;
		$datos['total_revendedores'] = $this->M_configuracion->total_revendedores();
		$datos['total_clientes_revendedores'] = $this->M_configuracion->total_clientes_revendedores();
        
		$this->load->view('lte_header', $datos);
		$this->load->view('v_listado_revendedores', $datos);
		$this->load->view('lte_footer', $datos);

	}
	/********************************************************************************************************************/
	// Registrando un revendedor
    public function registrar_revendedor()
    {
		 $id = $this->input->post('id');
		 $id_usuario = $this->input->post('id_usuario');
		 $id_cliente = $this->input->post('id_cliente');
		
		 
		 if ( $id_cliente != ''  )
		 {		 
			 $registrado = $this->M_configuracion->registrar_revendedor($id_usuario, $id_cliente);
			 
			 $mensaje = "";
			 if ($registrado == 1)
				 { 
					 $this->not_fcliente = "Se ha registrado un nuevo revendedor.";
					 
				 }
				 else
				 {
					 $this->not_fcliente = "ERROR. No se pudo registrar al revendedor. Verifique los datos especificados.";
				 }
				 
		 }
		 else
		 {
		     $this->not_fcliente = "ERROR. No se pudo registrar el revendedor. Verifique los datos especificados.";
			 
		 }
		 $this->obt_revendedores();
		 
		 
    }
	/********************************************************************************************************************/
	// Modificando un revendedor
    public function modificar_revendedor()
    {
		 $id_actual = $this->input->post('id_actual');
		 $id = $this->input->post('id');
		 $id_usuario = $this->input->post('id_usuario');
		 $id_cliente = $this->input->post('id_cliente');
		 
		 
		 if ($id_cliente != '' )
		 {
		 
			 $modificado = $this->M_configuracion->modificar_revendedor($id_actual, $id, $id_cliente, $id_usuario);
			 
   		     if ($modificado == 1)
			 { 
				 $this->not_fcliente = "Se ha registrado un revendedor.";
			 }
			 else
			 {
				 $this->not_fcliente = "ERROR. No se pudo modificar el revendedor. Verifique los datos especificados.";
			 }
				 
		 }
		 else
		 {
		     $this->not_fcliente = "ERROR. No se pudo modificar el revendedor. Verifique los datos especificados.";
			 
		 }
		 
		 $this->obt_revendedores();
	}
	/********************************************************************************************************************/
	/********************************************************************************************************************/
	 //*******************************************************************************************************
    //*******************************************************************************************************
	//     Misiones propuestas
	//*******************************************************************************************************
    public function misiones_propuestas()
	{
		$productos = $this->M_configuracion->obt_repuestos_solos();
		$datos['productos'] = $productos;
		$datos['filtro1'] 	= 1;
		$datos['filtro2'] 	= 0;
		$datos['filtro3'] 	= 0;
		$datos['filtro4'] 	= 0;		
		$datos['filtro5'] 	= 0;		
		$datos['filtro6'] 	= 0;		
		$datos['filtro7'] 	= 0;		
		$datos['vencido'] 	= 1;
		$datos['fbaja'] 	= 1;
		$datos['fmcoy'] 	= 0;
		$datos['fvip'] 		= 0;
		$this->chequear_fin_de_mision();
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

					$anterior_cli=$actual_cli;
					$anterior_prod=$actual_prod;
					$anterior_vcto=$actual_vcto;
					
				}
			}			
			
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
		$this->chequear_fin_de_mision();
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
		
		$solicitudes_baja = $this->M_configuracion->baja_pendientes();
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
		$baja  				= array();

		$total_misiones_propuestas 						=0;
		$total_misiones_propuestas_activas 				=0;
		$total_misiones_propuestas_bloqueadas 			=0;
		$total_misiones_activas_no_exitosa	 			=0;

		$contador= 0;
		$bandera = 0;
		foreach ($misiones->result() as $pr){	
			if($bandera==0){				
				$bandera=1;
				$anterior=$pr->id_cliente;
				$actual=$pr->id_cliente;
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
				$actual=$pr->id_cliente;
				if($actual != $anterior){
					$contador++;
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
				}

				$anterior=$pr->id_cliente;
			}
			
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
		$baja[$contador] 				= 0;

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
	
	public function misiones_propuestas_filtradas()
	{
		$tiempo_inicio = $this->M_configuracion->microtime_float();

		$session_filtro1 = $this->session->userdata('filtro1');
		$session_filtro2 = $this->session->userdata('filtro2');
		$session_filtro3 = $this->session->userdata('filtro3');
		$session_filtro4 = $this->session->userdata('filtro4');
		$session_filtro5 = $this->session->userdata('filtro5');
		$session_filtro6 = $this->session->userdata('filtro6');
		$session_filtro7 = $this->session->userdata('filtro7');
		$session_vencido = $this->session->userdata('vencido');
		$session_inactivo = $this->session->userdata('inactivo');
		$session_anno 	 = $this->session->userdata('anno');
		$session_mes     = $this->session->userdata('mes');
		$session_fil_nombre = $this->session->userdata('fil_nombre');
		$session_fil_telefono = $this->session->userdata('fil_telefono');
		$session_fil_dni = $this->session->userdata('fil_dni');
		$session_fil_email = $this->session->userdata('fil_email');
		$session_fil_factura = $this->session->userdata('fil_factura');
		$session_fil_producto = $this->session->userdata('fil_producto');
		$session_fil_fecha = $this->session->userdata('fil_fecha');
		$session_fil_baja = $this->session->userdata('fil_baja');
		$session_fil_mcoy = $this->session->userdata('fil_mcoy');
		$session_fil_vip = $this->session->userdata('fil_vip');

		$session_fil_nombre 	= trim($session_fil_nombre);
		$session_fil_telefono 	= trim($session_fil_telefono);
		$session_fil_dni 		= trim($session_fil_dni);
		$session_fil_email 		= trim($session_fil_email);
		$session_fil_factura 	= trim($session_fil_factura);

		$anno = $this->input->post('anno'); 
		$mes = $this->input->post('mes');
		
		if($anno == '' && $mes == ''  ){
			$por_session =1;
		}else{
			$por_session =0;
		}	

		$productos = $this->M_configuracion->obt_repuestos_solos();
		$datos['productos'] = $productos;
		if($por_session == 1){
			$filtro1 	= $session_filtro1; 
			$filtro2 	= $session_filtro2; 
			$filtro3 	= $session_filtro3; 
			$filtro4 	= $session_filtro4; 
			$filtro5 	= $session_filtro5; 
			$filtro6 	= $session_filtro6; 
			$filtro7 	= $session_filtro7; 
			$anno 		= $session_anno;
			$mes 		= $session_mes;
			$fnombre 	= $session_fil_nombre; 
			$ftelefono 	= $session_fil_telefono;
			$fdni 		= $session_fil_dni ; 
			$femail 	= $session_fil_email;
			$ffactura 	= $session_fil_factura;
			$vencido 	= $session_vencido; 
			$inactivo 	= $session_inactivo; 
			$fproducto 	= $session_fil_producto;	
			$ffecha 	= $session_fil_fecha; 
			$fbaja 		= $session_fil_baja; 
			$fmcoy 		= $session_fil_mcoy; 
			$fvip 		= $session_fil_vip; 
		}else{
			$filtro1 = $this->input->post('filtro1'); 
			$filtro2 = $this->input->post('filtro2'); 
			$filtro3 = $this->input->post('filtro3'); 
			$filtro4 = $this->input->post('filtro4'); 
			$filtro5 = $this->input->post('filtro5');
			$filtro6 = $this->input->post('filtro6');
			$filtro7 = $this->input->post('filtro7');
			$anno = $this->input->post('anno'); 
			$mes = $this->input->post('mes');
			$fnombre = $this->input->post('fil_nombre'); 
			$ftelefono = $this->input->post('fil_telefono');
			$fdni = $this->input->post('fil_dni'); 
			$femail = $this->input->post('fil_email');
			$ffactura = $this->input->post('fil_factura');
			$vencido = $this->input->post('vencido'); 
			$inactivo = $this->input->post('inactivo'); 
			$fproducto = $this->input->post('sel_productos');	
			$ffecha = $this->input->post('fil_fecha'); 
			$fbaja = $this->input->post('baja'); 
			$fmcoy = $this->input->post('mcoy'); 
			$fvip = $this->input->post('vip'); 

			$fnombre 	= trim($fnombre); 
			$ftelefono 	= trim($ftelefono); 
			$fdni		= trim($fdni); 
			$femail 	= trim($femail); 
			$ffactura 	= trim($ffactura); 
		}
		$millares1 = 1;
		$millares2 = 1;
		$millares3 = 1;
		$millares4 = 1;
		$millares5 = 1;
		$millares6 = 1;
		$millares7 = 1;
		if($filtro1){
			$filtro1=1;
			$millar1 = $this->input->post('sel_millar1');
		}else{
			$filtro1=0;
			$millar1=1;
			$millares1 = 1;
		} 
		if($filtro2){
			$filtro2=1;
			$millar2 = $this->input->post('sel_millar2');
		}else{
			$filtro2=0;
			$millar2 = 1;
			$millares2 = 1;
		} 
		if($filtro3){
			$filtro3=1;
			$millar3 = $this->input->post('sel_millar3');
		}else{
			$filtro3=0;
			$millar3 = 1;
			$millares3 = 1;
		} 
		if($filtro4){
			$filtro4=1;
			$millar4 = $this->input->post('sel_millar4');
		}else{
			$filtro4=0;
			$millar4 = 1;
			
		} 
		if($filtro5){
			$filtro5=1;
			$millar5 = $this->input->post('sel_millar5');
		}else{
			$filtro5=0;
			$millar5 = 1;
			
		} 
		if($filtro6){
			$filtro6=1;
			$millar6 = $this->input->post('sel_millar6');
		}else{
			$filtro6=0;
			$millar6 = 1;
			
		} 
		if($filtro7){
			$filtro7=1;
			$millar7 = $this->input->post('sel_millar7');
		}else{
			$filtro7=0;
			$millar7 = 1;
			
		} 
		if($fbaja){
			$fbaja=1;
		}else{
			$fbaja=0;
		} 
		if($fmcoy){
			$fmcoy=1;
		}else{
			$fmcoy=0;
		} 
		if($fvip){
			$fvip=1;
		}else{
			$fvip=0;
		} 
		$datos['filtro1'] 	= $filtro1;
		$datos['filtro2'] 	= $filtro2;
		$datos['filtro3'] 	= $filtro3;
		$datos['filtro4'] 	= $filtro4;
		$datos['filtro5'] 	= $filtro5;
		$datos['filtro6'] 	= $filtro6;
		$datos['filtro7'] 	= $filtro7;
		$datos['fbaja'] 	= $fbaja;
		$datos['fmcoy'] 	= $fmcoy;
		$datos['fvip'] 		= $fvip;
		$datos['millar1'] 	= $millar1;
		$datos['millares1'] = $millares1;
		$datos['millar2'] 	= $millar2;
		$datos['millares2'] = $millares2;
		$datos['millar3'] 	= $millar3;
		$datos['millares3'] = $millares3;
		$datos['millar4'] 	= $millar4;
		$datos['millares4'] = $millares4;
		$datos['millar5'] 	= $millar5;
		$datos['millares5'] = $millares5;
		$datos['millar6'] 	= $millar6;
		$datos['millares6'] = $millares6;
		$datos['millar7'] 	= $millar7;
		$datos['millares7'] = $millares7;
		//$misiones = $this->M_configuracion->misiones_propuestas_filtrada_sf();
		//$vencido = $this->input->post('vencido'); 	
		if($vencido){
			$vencido=1;
		}else{
			$vencido=0;
		}
		$datos['vencido'] 		= $vencido;
		if($inactivo){
			$inactivo=1;
		}else{
			$inactivo=0;
		}
		$datos['inactivo'] 		= $inactivo;
		// Año y mes
		
		$datos['anno'] 	= $anno;
		$datos['mes'] 	= $mes;
		// Datos del cliente
		
					
		$datos['fnombre'] 	= $fnombre;
		$datos['ftelefono'] = $ftelefono;
		$datos['fdni'] 		= $fdni;
		$datos['femail'] 	= $femail;
		$datos['ffactura'] 	= $ffactura;
		if($filtro2 == '1' ){
			# nombre...
		
			if($fnombre == ''){
				$fnombre ='*';
			}
			if($ftelefono == ''){
				$ftelefono ='*';
			}
			if($fdni == ''){
				$fdni ='*';
			}
			if($femail == ''){
				$femail ='*';
			}
			if($ffactura == ''){
				$ffactura ='*';
			}	
			if($fnombre !='*' || $ftelefono !='*' || $fdni !='*' || $femail !='*' || $ffactura !='*'){
				$misiones = $this->M_configuracion->misiones_propuestas_filtrada_cliente($fnombre, $ftelefono, $fdni, $femail, $ffactura, $millar2);
				$cantidad = $this->M_configuracion->misiones_propuestas_filtrada_cliente_cant($fnombre, $ftelefono, $fdni, $femail, $ffactura);
				$datos['millares2'] = round($cantidad/1000,0)+1;
			}

		} else{
			if($filtro1 == '1' ){//año
				$misiones = $this->M_configuracion->misiones_propuestas_filtrada_anno($anno, $mes, $vencido,$inactivo, $millar1);
				$cantidad = $this->M_configuracion->misiones_propuestas_filtrada_anno_cant($anno, $mes, $vencido,$inactivo);
				$datos['millares1'] = round($cantidad/1000,0)+1;
			}else{
				if($filtro3 == '1' ){//baja
					$misiones = $this->M_configuracion->misiones_propuestas_filtrada_baja($vencido,$inactivo, $millar3);
					$cantidad = $this->M_configuracion->misiones_propuestas_filtrada_baja_cant($vencido,$inactivo);
					$datos['millares3'] = round($cantidad/1000,0)+1;
				}else{
					if($filtro4 == '1' ){//producto
						$misiones = $this->M_configuracion->misiones_propuestas_filtrada_producto($fproducto, $vencido,$inactivo, $millar4);
						$cantidad = $this->M_configuracion->misiones_propuestas_filtrada_producto_cant($fproducto, $vencido,$inactivo);
						$datos['millares4'] = round($cantidad/1000,0)+1;
					}else{
						if($filtro5 == '1' ){//fecha
							$misiones = $this->M_configuracion->misiones_propuestas_filtrada_fecha($ffecha, $vencido,$inactivo, $millar5);
							$cantidad = $this->M_configuracion->misiones_propuestas_filtrada_fecha($ffecha, $vencido,$inactivo);
							$datos['millares5'] = round($cantidad/1000,0)+1;
						}else{
							if($filtro6 == '1' ){//mcoy
								$misiones = $this->M_configuracion->misiones_propuestas_filtrada_mcoy($vencido,$inactivo, $millar6);
								$cantidad = $this->M_configuracion->misiones_propuestas_filtrada_mcoy_cant($vencido,$inactivo);
								$datos['millares6'] = round($cantidad/1000,0)+1;
							}else{
								if($filtro7 == '1' ){//vip
									$misiones = $this->M_configuracion->misiones_propuestas_filtrada_vip1($vencido,$inactivo, $millar7);
									$cantidad = $this->M_configuracion->misiones_propuestas_filtrada_vip1_cant($vencido,$inactivo);
									$datos['millares7'] = round($cantidad/1000,0)+1;
								}
							}
						}
					}
				}
			}
		}
		// Clientes con solicitud de baja
				
		// Datos del producto
				 								
		$datos['fproducto'] 	= $fproducto;
		// Por fecha
							
		$datos['ffecha'] 	= $ffecha;
		
		$this->chequear_fin_de_mision();
		/*
			$group = array('Revendedores','ConsultorRV');
			$groupRev = array('Revendedores');                  
			if ($this->ion_auth->in_group($group)) { 			
							
				$user = $this->ion_auth->user()->row();
				if($this->ion_auth->in_group($groupRev))
				{	// El usuario es revendedor
					$misiones = $this->M_configuracion->misiones_propuestas_revendedores_filtrada($user->id,$anno, $mes, $nombre, $telefono, $dni, $email, $factura);
				}
				else
				{	// El usuario es consultor revendedor
					$id_rev = $this->M_operaciones->obt_superior($user->id);				
					$misiones = $this->M_configuracion->misiones_propuestas_revendedores_filtrada($id_rev,$anno, $mes, $nombre, $telefono, $dni, $email, $factura);
				}
				
			}else{
				$misiones = $this->M_configuracion->misiones_propuestas_filtrada($anno, $mes, $nombre, $telefono, $dni, $email, $factura);
			}
		*/
		
		$solicitudes_baja = $this->M_configuracion->baja_pendientes();
		$misiones_activas1 = $this->M_configuracion->obt_mision_activas();

		$id 				= array();
		$no_factura			= array();
		$cliente 			= array();
		$telefono 			= array();
		$celular 			= array();
		$email 				= array();
		$fec_vcto 			= array();
		$id_cliente 		= array();
		$vip				= array();
		$baja  				= array();
		$nota  				= array();
		$estado  			= array();
		
		$total_misiones_propuestas 						=0;
		$total_misiones_propuestas_activas 				=0;
		$total_misiones_propuestas_bloqueadas 			=0;
		$total_misiones_activas_no_exitosa	 			=0;

		$contador= 0;
		$bandera = 0;
		foreach ($misiones->result() as $pr){			
			$id[$contador] 					= $pr->id_cliente;
			$no_factura[$contador] 			= $pr->no_factura;
			$cliente[$contador] 			= $pr->nombre;
			$telefono[$contador] 			= $pr->telefono;
			$celular[$contador] 			= $pr->celular;
			$email[$contador] 				= $pr->email;		
			$fec_vcto[$contador] 			= $pr->fecha_vcto.' </br>';
			$en_mision[$contador] 			= $pr->en_mision;
			$en_operacion[$contador] 		= $pr->en_operacion;
			$id_cliente[$contador] 			= $pr->id_cliente;
			$vip[$contador]					= $pr->vip;
			$baja[$contador] 				= 0;
			$nota[$contador]		= $this->M_configuracion->obtener_notas_clientes_listadas($pr->id_cliente);
			$estado[$contador]		= $this->M_configuracion->obtener_estado_reclamos($pr->id_cliente);
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
			/*if($filtro =='1'){
				if($anno == substr($fec_vcto[$contador],0,4) && $mes == substr($fec_vcto[$contador],5,2) ){
					//print_r('entro');die();
					$contador++;
				}
				
			}else{
				$contador++;
			}	*/	
			$contador++;
						
			
		}
		
		
		$id1 				= array();
		$no_factura1		= array();
		$cliente1 			= array();
		$telefono1 			= array();
		$celular1			= array();
		$email1				= array();
		$fec_vcto1 			= array();
		$en_mision1			= array();
		$en_operacion1 		= array();
		$id_cliente1 		= array();
		$id_pedido1			= array();
		$es_exitosa1		= array();
		$vip1				= array();
		$baja1 				= array();
		$nota1 				= array();
		$estado1 			= array();
			
		$con = 0;
		for ($i=0; $i < count($id); $i++) { 
			if( ($vencido=='1' && ($fec_vcto[$i] <=date("Y-m-d H:i:s"))) || ($vencido=='0' && ($fec_vcto[$i] >date("Y-m-d H:i:s")))
			){	
				$id1[$con] 			= $id[$i];
				$no_factura1[$con]	= $no_factura[$i];
				$cliente1[$con]  	= $cliente[$i];
				$telefono1[$con]  	= $telefono[$i];
				$celular1[$con] 	= $celular[$i];
				$email1[$con] 		= $email[$i];
				$fec_vcto1[$con]  	= $fec_vcto[$i];
				$en_mision1[$con] 	= $en_mision[$i];
				$en_operacion1[$con]= $en_operacion[$i];
				$id_cliente1[$con]  = $id_cliente[$i];
				$es_exitosa1[$con] 	= $es_exitosa[$i];
				$vip1[$con] 		= $vip[$i];
				$baja1[$con]  		= $baja[$i];
				$nota1[$con]		= $nota[$i];
				$estado1[$con]		= $estado[$i];
				$con ++;					
			}		
		}
		$id 			= $id1;
		$no_factura		= $no_factura1;
		$cliente	  	= $cliente1;
		$telefono	  	= $telefono1;
		$celular	 	= $celular1;
		$email	 		= $email1;
		$fec_vcto	  	= $fec_vcto1;
		$en_mision	 	= $en_mision1;
		$en_operacion	= $en_operacion1;
		$id_cliente		= $id_cliente1;
		$id_pedido 		= $id_pedido1;
		$es_exitosa 	= $es_exitosa1;
		$vip 			= $vip1;
		$baja  			= $baja1;
		$nota  			= $nota1;
		$estado  		= $estado1;
			
		
		//vencido final
	
	
		$datos['id'] 				= $id;				
		$datos['no_factura'] 		= $no_factura;
		$datos['cliente'] 			= $cliente;
		$datos['telefono'] 			= $telefono;
		$datos['celular'] 			= $celular;
		$datos['email'] 			= $email;	
		$datos['fec_vcto'] 			= $fec_vcto;
		$datos['en_mision'] 		= $en_mision;
		$datos['en_operacion'] 		= $en_operacion;
		$datos['id_cliente'] 		= $id_cliente;
		$datos['es_exitosa']		= $es_exitosa;
		$datos['vip']				= $vip;
		$datos['baja']				= $baja;
		$datos['nota']				= $nota;
		$datos['estado']			= $estado;
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
		
        
		/*$datos['total_misiones'] = $this->M_configuracion->total_misiones();
		$datos['total_misiones_aceptadas'] = $this->M_configuracion->total_misiones_aceptadas();
		$datos['total_misiones_rechazadas'] = $this->M_configuracion->total_misiones_rechazadas();
		$datos['total_clientes_mision'] = $this->M_configuracion->total_clientes_mision();*/
		
		$annos = $this->M_configuracion->obt_annos();
		$meses = $this->M_configuracion->obt_meses();
		
		$datos['annos']  	= $annos;
		$datos['meses']  	= $meses;
		
		$data = array(
			'filtro1' => $filtro1,
			'filtro2' => $filtro2,
			'filtro3' => $filtro3,
			'filtro4' => $filtro4,
			'filtro5' => $filtro5,
			'filtro6' => $filtro6,
			'filtro7' => $filtro7,
			'vencido' => $vencido,
			'inactivo' => $inactivo,
			'anno' => $anno,
			'mes' => $mes,
			'fil_nombre' => $fnombre,
			'fil_telefono' => $ftelefono,
			'fil_dni' => $fdni,
			'fil_email' => $femail,
			'fil_factura' => $ffactura,
			'fil_producto' => $fproducto,
			'fil_fecha' => $ffecha,			      
			'fil_baja' => $fbaja,			      
			'fil_mcoy' => $fmcoy,			      
			'fil_vip' => $fvip			      
			);		
			
		$this->session->set_userdata($data);
		$tiempo_fin = $this->M_configuracion->microtime_float();
		$tiempo = $tiempo_fin - $tiempo_inicio;
		
		$datos['tiempo'] = $tiempo;	
		$this->load->view('lte_header', $datos);
		$this->load->view('v_listado_misiones_propuestas', $datos);
		$this->load->view('lte_footer', $datos);
	}
	public function misiones_propuestas_filtradas_vip()
	{
		$anno = $this->input->post('anno'); 
		$mes = $this->input->post('mes');
		$nombre = $this->input->post('fil_nombre'); 
		$telefono = $this->input->post('fil_telefono');
		$dni = $this->input->post('fil_dni'); 
		$factura = $this->input->post('fil_factura');

		$nombre 	= trim($nombre); 
		$telefono 	= trim($telefono); 
		$dni 		= trim($nodnimbre); 
		$factura 	= trim($factura); 

		/*if($anno == ''){
			$anno ='*';
		}
		if($mes == ''){
			$mes ='*';
		}*/
		if($nombre != '' || $telefono != '' || $dni != '' || $email != '' || $factura != ''){
			$mes ='*';
			$anno ='*';
		}
		if($nombre == ''){
			$nombre ='*';
		}
		if($telefono == ''){
			$telefono ='*';
		}
		if($dni == ''){
			$dni ='*';
		}
		if($email == ''){
			$email ='*';
		}
		if($factura == ''){
			$factura ='*';
		}
		$this->chequear_fin_de_mision();
		$group = array('Revendedores','ConsultorRV');
		$groupRev = array('Revendedores');                  
		if ($this->ion_auth->in_group($group)) { 			
			 			
			$user = $this->ion_auth->user()->row();
			if($this->ion_auth->in_group($groupRev))
			{	// El usuario es revendedor
				$misiones = $this->M_configuracion->misiones_propuestas_revendedores_filtrada_vip($user->id,$anno, $mes, $nombre, $telefono, $dni, $email, $factura);
			}
			else
			{	// El usuario es consultor revendedor
				$id_rev = $this->M_operaciones->obt_superior($user->id);				
				$misiones = $this->M_configuracion->misiones_propuestas_revendedores_filtrada_vip($id_rev,$anno, $mes, $nombre, $telefono, $dni, $email, $factura);
			}
			
		}else{
			$misiones = $this->M_configuracion->misiones_propuestas_filtrada_vip($anno, $mes, $nombre, $telefono, $dni, $email, $factura);
		}
		
		$solicitudes_baja = $this->M_configuracion->baja_pendientes();
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
		
        
		/*$datos['total_misiones'] = $this->M_configuracion->total_misiones();
		$datos['total_misiones_aceptadas'] = $this->M_configuracion->total_misiones_aceptadas();
		$datos['total_misiones_rechazadas'] = $this->M_configuracion->total_misiones_rechazadas();
		$datos['total_clientes_mision'] = $this->M_configuracion->total_clientes_mision();*/
		
		$annos = $this->M_configuracion->obt_annos();
		$meses = $this->M_configuracion->obt_meses();
		
		$datos['annos']  	= $annos;
		$datos['meses']  	= $meses;
		$datos['anno']  	= $anno;
		$datos['mes']  		= $mes;

		$this->load->view('lte_header', $datos);
		$this->load->view('v_listado_misiones_propuestas_vip', $datos);
		$this->load->view('lte_footer', $datos);
	}
    //***********************************************************
    public function nueva_mision_propuesta($cliente,$pedido)
	{
		$datos['cliente'] 	= $cliente;
		$datos['clientes'] 	= $this->M_configuracion->obt_cliente($cliente);
		$datos['pedido'] 	= $pedido;	
		$provincias 	 	= $this->M_operaciones->provincias();	
		$datos['provincias'] = $provincias;	
		//$municipios 		 = $this->M_operaciones->municipios();
		//$datos['municipios'] = $municipios;
		//$datos['historico'] 	= $this->M_configuracion->historico($cliente);
		/*
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
				$datos['misiones'] = $this->M_configuracion->misiones_propuestas_revendedores($id_rev );
			}
			
		}else
			$datos['misiones'] = $this->M_configuracion->misiones_propuestas_pedido($pedido);
			*/
		$datos['notificacion'] = $this->notificacion ? $this->notificacion : "Iniciando una misión:";
		$datos['notificacion_error'] = $this->notificacion_error;
		$datos['modo_edicion'] = false;
        $dias=$this->M_configuracion->get_configuracion('DIAS_MISION');
        $dias=$dias[0];
		$resultado=$this->M_configuracion->bloquear_cliente($cliente);
        $datos['dias'] = $dias->valor;
		$this->load->view('lte_header', $datos);
		$this->load->view('v_nueva_mision_propuesta', $datos);
		$this->load->view('lte_footer', $datos);	
	}
	public function nueva_mision_propuesta_vip($cliente,$pedido)
	{
		$datos['cliente'] 	= $cliente;
		$datos['clientes'] 	= $this->M_configuracion->obt_cliente($cliente);
		$datos['pedido'] 	= $pedido;	
		$provincias 	 	= $this->M_operaciones->provincias();	
		$datos['provincias'] = $provincias;	
		$municipios 		 = $this->M_operaciones->municipios();
		$datos['municipios'] = $municipios;

		$group = array('Revendedores','ConsultorRV');
		$groupRev = array('Revendedores');                  
		if ($this->ion_auth->in_group($group)) { 			
			$revendedor = 'true'; 			
			$user = $this->ion_auth->user()->row();
			if($this->ion_auth->in_group($groupRev))
			{	// El usuario es revendedor
				$datos['misiones'] = $this->M_configuracion->misiones_propuestas_revendedores_vip($user->id);
			}
			else
			{	// El usuario es consultor revendedor
				$id_rev = $this->M_operaciones->obt_superior($user->id);				
				$datos['misiones'] = $this->M_configuracion->misiones_propuestas_revendedores_vip($id_rev );
			}
			
		}else
			$datos['misiones'] = $this->M_configuracion->misiones_propuestas_vip_pedido($pedido);

		$datos['notificacion'] = $this->notificacion ? $this->notificacion : "Iniciando una misión:";
		$datos['notificacion_error'] = $this->notificacion_error;
		$datos['modo_edicion'] = false;
        $dias=$this->M_configuracion->get_configuracion('DIAS_MISION');
        $dias=$dias[0];
		$resultado=$this->M_configuracion->bloquear_cliente($cliente);
        $datos['dias'] = $dias->valor;
		$this->load->view('lte_header', $datos);
		$this->load->view('v_nueva_mision_propuesta_vip', $datos);
		$this->load->view('lte_footer', $datos);	
	}
	
	
	// Registrar misión fallida
    public function registrar_nuevo_hallazgo()
	{
		$id_mision = $this->input->post('id_mision'); 
		$notas = $this->input->post('descripcion'); 
		$id_clasificacion = $this->input->post('id_causa');
		 
        $registrado = $this->M_configuracion->registrar_nuevo_hallazgo($id_mision, $notas, $id_clasificacion);
	    if ($registrado== 1)
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
	}
	// Chequear fin de mision
    public function chequear_fin_de_mision()
	{
		$misiones = $this->M_configuracion->obt_mision_activas();
		 
        foreach($misiones->result() as $mision){
			
				if($mision->fecha_fin < date('Y-m-d H:i:s')){					
					$resultado = $this->M_configuracion->quitar_cliente_en_mision($mision->id_cliente);
				}else{
					$resultado = $this->M_configuracion->cliente_en_mision($mision->id_cliente);
				}
		}
	}
	// Registrar misión fallida
    public function registrar_mision_fallida()
    {		 
		$id_mision = $this->input->post('id_mision'); 
		$id_causa = $this->input->post('id_causa');
		$clientes = $this->input->post('cliente');
		$id_cliente = $this->input->post('id_cliente');
		$id_pedido = $this->input->post('id_pedido'); 
		$datos['cliente'] = $clientes;  
		$datos['mision'] =$id_mision;
		$datos['hallazgos']= $this->M_configuracion->obt_clasificacion_hallazgo();
		$registrado = $this->M_configuracion->desbloquear_cliente($id_cliente);
		$registrado = $this->M_configuracion->quitar_cliente_en_mision($id_cliente);			
		$registrado = $this->M_configuracion->sellar_mision($id_mision);
		if($id_causa == 5){// ya realizo el cambio
			//mandar a borrar esa mision y actualizar el pedido
			
			
			$productos = $this->M_configuracion->obt_repuestos_solos();
			//$colores = $this->M_configuracion->obt_colores();
			$datos['id_cliente']= $id_cliente;
			$datos['cliente'] 	= $clientes;
			$datos['productos'] = $productos;
			//$datos['colores'] 	= $colores;
			$datos['notificacion'] = 'Agregando nueva venta' ;
			$datos['notificacion_error'] = false ;
			$datos['modo_edicion'] = false;
			$this->load->view('lte_header', $datos);
			$this->load->view('v_agregar_pedidos', $datos);
			$this->load->view('lte_footer', $datos);
			$registrado = 0;
		}else
			$registrado = $this->M_configuracion->registrar_mision_fallida($id_causa, $id_mision);
		 
		       
          
	    if ($registrado== 1)
		{ 
			if($id_causa==1)
			{// es una hallazgo   
				$datos['modo_edicion'] = false;
		    	$datos['notificacion'] = 'Agregando los datos de la causa' ;
		     	$datos['notificacion_error'] = false ;
             
             	$this->notificacion = "La misión se registró satisfactoriamente";
		    	$this->notificacion_error = false;

                $this->load->view('lte_header', $datos);
                $this->load->view('v_nuevo_hallazgo', $datos);
                $this->load->view('lte_footer', $datos);   
             }else	{			 
				$this->notificacion = "La misión se registró satisfactoriamente.";
				$this->notificacion_error = false;
				$this->misiones_propuestas();
			 }
		 }
		 else
		 {
			 $this->notificacion = "ERROR. No se pudo registrar la misión.";
			 $this->notificacion_error = true;
		 }		 
    }
	public function cancelar_mision($id_cliente){
		$registrado = $this->M_configuracion->desbloquear_cliente($id_cliente);
		$this->misiones_propuestas_filtradas();
	}	
	//*******************************************************************************************************
	//*******************************************************************************************************
	//*******************************************************************************************************
	//     Gestion de configuracion
	//*******************************************************************************************************
    // Interfaz para registrar un nueva configuracion
	public function nuevo_configuracion()
	{		
		$datos['notificacion'] = "Especifique los datos de la nueva configuracion:";
		$datos['modo_edicion'] = false;
		$datos['notificacion_error'] = $this->notificacion_error;
		
		$this->load->view('lte_header', $datos);
		$this->load->view('v_configuraciones', $datos);
		$this->load->view('lte_footer', $datos);	
	}
	/********************************************************************************************************************/
	// Editando la configuracion
	public function editar_configuracion($id_actual)
	{
		$resultado = $this->M_configuracion->obt_configuracion($id_actual);
		
		if ($resultado)
		{
		   $configuracion = $resultado->row();

		   $parametro = $id_actual;
		   $valor = $configuracion->valor;
		   $valor_decimal = $configuracion->valor_decimal;
		   $descripcion = $configuracion->descripcion;
		   $es_decimal = $configuracion->es_decimal;
		  
		   $datos['modo_edicion'] = true;
		   $datos['notificacion'] = 'Modificando los datos de la configuracion ' . $valor . ' ' . $descripcion;
		   $datos['notificacion_error'] = $this->notificacion_error;
		   
		   $datos['id_actual']    = $id_actual;
		   $datos['parametro']    = $parametro;
		   $datos['valor']        = $valor;
		   $datos['valor_decimal']= $valor_decimal;
		   $datos['es_decimal']= $es_decimal;
		   $datos['descripcion']  = $descripcion;
		  
		}
		
		$this->load->view('lte_header', $datos);
 	    $this->load->view('v_configuraciones', $datos);
	    $this->load->view('lte_footer', $datos);
	}
	
	/********************************************************************************************************************/
	// Confirmar eliminación de una configuracion
	public function cfe_configuracion($parametro)
	{
		$datos['parametro'] = $parametro;
		
		$this->load->view('lte_header', $datos);
 	    $this->load->view('vcan_configuraciones', $datos);
	    $this->load->view('lte_footer', $datos);
	}
	/********************************************************************************************************************/
	// Cancelar configuracion
    public function cancelar_configuracion()
	{
		$parametro = $this->input->post('parametro');
		$cancelado = $this->M_configuracion->cancelar_configuracion($parametro);
		
		if ($cancelado == 1)
	    { 
		   $this->not_fcliente = "Se eliminó la configuracion correctamente.";
		}
		else
		{
		   $this->not_fcliente = "ERROR. No se pudo eliminar la configuracion. Verifique los datos especificados.";
		}
		
		$this->obt_configuraciones();

	}
	/********************************************************************************************************************/
	// Listado de configuracion
    public function obt_configuraciones()
	{
		$configuraciones = $this->M_configuracion->obt_configuraciones();	
        $datos['configuraciones'] = $configuraciones;
		$datos['total_configuraciones'] = $this->M_configuracion->total_configuraciones();
        
		$this->load->view('lte_header', $datos);
		$this->load->view('v_listado_configuraciones', $datos);
		$this->load->view('lte_footer', $datos);

	}
	/********************************************************************************************************************/
	// Registrando un configuracion
    public function registrar_configuracion()
    {
		 $parametro = $this->input->post('parametro');
		 $valor = $this->input->post('valor');
		 $descripcion = $this->input->post('descripcion');
		 $es_decimal = $this->input->post('es_decimal');
		 		 
		 $this->load->library('form_validation');
		 
		 $this->form_validation->set_rules('parametro', 'Parametro', 'required');
		 $this->form_validation->set_rules('valor', 'Valor', 'required|numeric');
		 $this->form_validation->set_rules('descripcion', 'Descripcion', 'required');
		 
		 if ($this->form_validation->run() == true )
		 {		 
			 $registrado = $this->M_configuracion->registrar_configuracion($parametro, $valor, $descripcion);
			 
			 $mensaje = "";
			 if ($registrado == 1)
				 { 
					 $this->notificacion = "La configuración se registró satisfactoriamente.";
		             $this->notificacion_error = false;
					 
				 }
				 else
				 {
					 $this->notificacion = "ERROR. No se pudo registrar la configuración";
		             $this->notificacion_error = true;
				 }
				 
		 }
		 else
		 {
		     $this->notificacion = validation_errors();
			 $this->notificacion_error = true;
			 
		 }
		 if($this->notificacion_error == true){	
		   
		   $datos['parametro']    = $parametro;
		   $datos['valor']        = $valor;
		   $datos['descripcion']  = $descripcion;
		   $datos['es_decimal']  = $es_decimal;

			$datos['notificacion'] = $this->notificacion ? $this->notificacion : "Error registrando la configuración" . $descripcion;
          	$datos['notificacion_error'] = $this->notificacion_error;
			$datos['modo_edicion'] = false;

			$this->load->view('lte_header', $datos);
			$this->load->view('v_configuraciones', $datos);
			$this->load->view('lte_footer', $datos);  
		 
		 }else
		 $this->nuevo_configuracion();
		 
		 
    }
	/********************************************************************************************************************/
	// Modificando un configuracion
    public function modificar_configuracion()
    {
		 $id_actual = $this->input->post('id_actual');
		 $parametro = $this->input->post('parametro');
		 $valor = $this->input->post('valor');
		 $descripcion = $this->input->post('descripcion');
		 $es_decimal = $this->input->post('es_decimal');
		 $valor_decimal = $this->input->post('valor');
		 
		 $this->load->library('form_validation');
		 
		 $this->form_validation->set_rules('parametro', 'Parametro', 'required');
		 $this->form_validation->set_rules('valor', 'Valor', 'required|numeric');
		 $this->form_validation->set_rules('descripcion', 'Descripcion', 'required');
		 
		 if ($this->form_validation->run() == true )
		 {
		 
			 $modificado = $this->M_configuracion->modificar_configuracion($id_actual, $parametro, $valor, $descripcion, $es_decimal);
			 
   		     if ($modificado == 1)
			 { 
				 $this->notificacion = "La configuración se modificó satisfactoriamente.";
		         $this->notificacion_error = false;
			 }
			 else
			 {
				 $this->notificacion = "ERROR. No se pudo modificar La configuración. Verifique los datos especificados.";
		         $this->notificacion_error = true;
		 }
				 
		 }
		 else
		 {
		     $this->notificacion = validation_errors();
			 $this->notificacion_error = true;
			 
		 }
		 if($this->notificacion_error == true){		
			
			$datos['id_actual']    = $id_actual;
		    $datos['parametro']    = $parametro;
		    $datos['valor']        = $valor;
		    $datos['valor_decimal']        = $valor;
		    $datos['descripcion']  = $descripcion;
		    $datos['es_decimal']  = $es_decimal;
			
			$datos['notificacion'] = $this->notificacion ? $this->notificacion : "Error modificando la configuración" . $parametro;
          	$datos['notificacion_error'] = $this->notificacion_error;
			$datos['modo_edicion'] = true;
			
			$this->load->view('lte_header', $datos);
			$this->load->view('v_configuraciones', $datos);
			$this->load->view('lte_footer', $datos); 
			 
		 }else
		 
		 $this->obt_configuraciones();
	}
	/********************************************************************************************************************/
	
//*******************************************************************************************************
	//*******************************************************************************************************
	//     Gestion de Causas de misiones fallidas
	//*******************************************************************************************************
    // Interfaz para registrar un nueva causa_falla
	public function nuevo_causa_falla()
	{		
		$datos['notificacion'] = "Especifique los datos de la nueva causa de mision fallida:";
		$datos['modo_edicion'] = false;
		$datos['notificacion_error'] = $this->notificacion_error;
		
		$this->load->view('lte_header', $datos);
		$this->load->view('v_causa_fallas', $datos);
		$this->load->view('lte_footer', $datos);	
	}
	/********************************************************************************************************************/
	// Editando la causa_falla
	public function editar_causa_falla($id_actual)
	{
		$resultado = $this->M_configuracion->obt_causa_falla($id_actual);
		
		if ($resultado)
		{
		   $configuracion = $resultado->row();

		   $id_causa = $id_actual;
		   $descripcion = $configuracion->descripcion;
		  
		   $datos['modo_edicion'] = true;
		   $datos['notificacion'] = 'Modificando los datos de la causa de mision falllida '  . $descripcion;
		   
		   $datos['id_actual']    = $id_actual;
		   $datos['id_causa']     = $id_causa;
		   $datos['descripcion']  = $descripcion;
		  
		}
		
		$this->load->view('lte_header', $datos);
 	    $this->load->view('v_causa_fallas', $datos);
	    $this->load->view('lte_footer', $datos);
	}
	
	/********************************************************************************************************************/
	// Confirmar eliminación de una causa_falla
	public function cfe_causa_falla($id_causa)
	{
		$datos['id_causa'] = $id_causa;
		
		$this->load->view('lte_header', $datos);
 	    $this->load->view('vcan_causa_fallas', $datos);
	    $this->load->view('lte_footer', $datos);
	}
	/********************************************************************************************************************/
	// Cancelar configuracion
    public function cancelar_causa_falla()
	{
		$id_causa = $this->input->post('id_causa');
		$cancelado = $this->M_configuracion->cancelar_causa_falla($id_causa);
		
		if ($cancelado == 1)
	    { 
		   $this->not_fcliente = "Se eliminó la causa correctamente.";
		}
		else
		{
		   $this->not_fcliente = "ERROR. No se pudo eliminar la causa. Verifique los datos especificados.";
		}
		
		$this->obt_causa_fallas();

	}
	/********************************************************************************************************************/
	// Listado de configuracion
    public function obt_causa_fallas()
	{
		$causa_fallas = $this->M_configuracion->obt_causa_fallas();	
        $datos['causa_fallas'] = $causa_fallas;
		$datos['total_causa_fallas'] = $this->M_configuracion->total_causa_fallas();
        
		$this->load->view('lte_header', $datos);
		$this->load->view('v_listado_causa_fallas', $datos);
		$this->load->view('lte_footer', $datos);

	}
	/********************************************************************************************************************/
	// Registrando un configuracion
    public function registrar_causa_falla()
    {
		
		 $id_causa = $this->input->post('id_causa');
		 $descripcion = $this->input->post('descripcion');
		 		 
		 $this->load->library('form_validation');
		 
		 $this->form_validation->set_rules('id_causa', 'Código', 'required|numeric');
		 $this->form_validation->set_rules('descripcion', 'Descripción', 'required');
		 
		 if ($this->form_validation->run() == true )
		 {		 
			 $registrado = $this->M_configuracion->registrar_causa_falla($id_causa, $descripcion);
			 
			 $mensaje = "";
			 if ($registrado == 1)
				 { 
					 $this->notificacion = "La causa se registró satisfactoriamente.";
		             $this->notificacion_error = false;
					 
				 }
				 else
				 {
					 $this->notificacion = "ERROR. No se pudo registrar la causa";
		             $this->notificacion_error = true;
		 }
		 }		
	     else
	     {
		     $this->notificacion = validation_errors();
			 $this->notificacion_error = true;
			 
		 }
		 if($this->notificacion_error == true){			
			
		    $datos['id_causa']     = $id_causa;
		    $datos['descripcion']  = $descripcion;
			
			$datos['notificacion'] = $this->notificacion ? $this->notificacion : "Error registrando la causa" . $id_causa;
          	$datos['notificacion_error'] = $this->notificacion_error;
			$datos['modo_edicion'] = false;

			$this->load->view('lte_header', $datos);
			$this->load->view('v_causa_fallas', $datos);
			$this->load->view('lte_footer', $datos);  
		 
		 }else
		 $this->obt_causa_fallas();
		 
		 
    }
	/********************************************************************************************************************/
	// Modificando un configuracion
    public function modificar_causa_falla()
    {
		 $id_actual = $this->input->post('id_actual');
		 $id_causa = $this->input->post('id_causa');
		 $descripcion = $this->input->post('descripcion');
		 
		 $this->load->library('form_validation');
		 
		 $this->form_validation->set_rules('id_causa', 'Código', 'required|numeric');
		 $this->form_validation->set_rules('descripcion', 'Descripción', 'required');
		 
		 if (   $this->form_validation->run() == true)
		 {
		 
			 $modificado = $this->M_configuracion->modificar_causa_falla($id_actual, $id_causa, $descripcion);
			 
   		     if ($modificado == 1)
			 { 
				 $this->notificacion = "La causa se modificó satisfactoriamente.";
		         $this->notificacion_error = false;
			 }
			 else
			 {
				 $this->notificacion = "ERROR. No se pudo modificar la causa. Verifique los datos especificados.";
		         $this->notificacion_error = true;
		 }
				 
		 }
		 else
		 {
		     $this->notificacion = validation_errors();
			 $this->notificacion_error = true;
			 
		 }
		 if($this->notificacion_error == true){
			
			$datos['id_actual']    = $id_actual;
		    $datos['id_causa']     = $id_causa;
		    $datos['descripcion']  = $descripcion;
			
			$datos['notificacion'] = $this->notificacion ? $this->notificacion : "Error modificando la causa" . $id_causa;
          	$datos['notificacion_error'] = $this->notificacion_error;
			$datos['modo_edicion'] = true;

			$this->load->view('lte_header', $datos);
			$this->load->view('v_causa_fallas', $datos);
			$this->load->view('lte_footer', $datos);  
		 
		 }else
		 
		 $this->obt_causa_fallas();
	}
	/********************************************************************************************************************/
	   //*******************************************************************************************************
	//     Gestion de colores
	//*******************************************************************************************************
    // Interfaz para registrar un nuevo color
	public function nuevo_color()
	{		
		$datos['notificacion'] = "Especifique los datos del nuevo color:";
		$datos['modo_edicion'] = false;
		$datos['notificacion_error'] = $this->notificacion_error;
		
		$this->load->view('lte_header', $datos);
		$this->load->view('v_colores', $datos);
		$this->load->view('lte_footer', $datos);	
	}
	/********************************************************************************************************************/
	// Editando la color
	public function editar_color($id_actual)
	{
		$resultado = $this->M_configuracion->obt_color($id_actual);
		
		if ($resultado)
		{
		   $color = $resultado->row();

		   $id_color = $id_actual;
		   $descripcion = $color->nombre;
		   
		   		   
		   $datos['modo_edicion'] = true;
		   $datos['notificacion'] = 'Modificando los datos del color ' . $id_color . ' ' . $descripcion;
		   $datos['notificacion_error'] = $this->notificacion_error;
		   
		   $datos['id_actual']    = $id_actual;
		   $datos['id_color']   = $id_color;
		   $datos['descripcion']  = $descripcion;
		   
		}
		
		$this->load->view('lte_header', $datos);
 	    $this->load->view('v_colores', $datos);
	    $this->load->view('lte_footer', $datos);
	}
	
	/********************************************************************************************************************/
	// Confirmar eliminación de un color
	public function cfe_color($id_color)
	{
		$datos['id_color'] = $id_color;
		
		$productos = $this->M_configuracion->obt_productos_colores($id_color);
		
		if ($productos->row())
	    {			
			$this->notificacion = 'Existen productos asociados al color';
			$this->notificacion_error == true;	
			
		}else{
			$this->notificacion = ' ';
		} 
		
		$datos['notificacion'] = $this->notificacion;
		$this->load->view('lte_header', $datos);
 	    $this->load->view('vcan_colores', $datos);
	    $this->load->view('lte_footer', $datos);
	}
	/********************************************************************************************************************/
	// Cancelar color
    public function cancelar_color()
	{
		$id_color = $this->input->post('id_color');
			
		$cancelado_producto_color = $this->M_configuracion->cancelar_producto_color_idcolor($id_color);
		$cancelado = $this->M_configuracion->cancelar_color($id_color);
		
		if ($cancelado == 1)
	    { 
		   $this->not_fcliente = "Se eliminó el color correctamente.";
		}
		else
		{
		   $this->not_fcliente = "ERROR. No se pudo eliminar el color. Verifique los datos especificados.";
		}
		
		$this->obt_colores();

	}
	/********************************************************************************************************************/
	// Listado de color
    public function obt_colores()
	{
		$colores 				= $this->M_configuracion->obt_colores();	
        $datos['colores'] 		= $colores;
		$datos['total_colores'] = $this->M_configuracion->total_colores();
        
		$this->load->view('lte_header', $datos);
		$this->load->view('v_listado_color', $datos);
		$this->load->view('lte_footer', $datos);

	}
	public function obt_color($id_color){
		$color= $this->M_configuracion->obt_color($id_color);
		$row = $color->row_array();
		echo json_encode($row); 
	}
	public function obt_campana($id_campana){
		$campana= $this->M_configuracion->obt_campana($id_campana);
		$row = $campana->row_array();
		echo json_encode($row); 
	}
	public function obt_campana_rev($id_campana){
		$campana= $this->M_configuracion->obt_campana_rev($id_campana);
		$row = $campana->row_array();
		echo json_encode($row); 
	}
	/********************************************************************************************************************/
	// Registrando un color
    public function registrar_color()
    {
		 
		 $descripcion = $this->input->post('descripcion');
		 
		 $this->load->library('form_validation');
		 
		 $this->form_validation->set_rules('descripcion', 'Descripción', 'required');
		 
		 if ($this->form_validation->run() == true )
		 {		 
			 $registrado = $this->M_configuracion->registrar_color($descripcion);
			 
			 $mensaje = "";
			 if ($registrado == 1)
				 { 
					 $this->notificacion = "El cliente se registró satisfactoriamente.";
		             $this->notificacion_error = false;
				 }
				 else
				 {
					 $this->notificacion = "ERROR. No se pudo registrar el cliente.";
		             $this->notificacion_error = true;
				 }
				 
		 }
		 else
		 {
		     $this->notificacion = validation_errors();
			 $this->notificacion_error = true;
			 
		 }
		 if($this->notificacion_error == true){			
			
		    $datos['descripcion']  = $descripcion;
	
			$datos['notificacion'] = $this->notificacion ? $this->notificacion : "Error registrando el color ";
          	$datos['notificacion_error'] = $this->notificacion_error;
			$datos['modo_edicion'] = false;

			$this->load->view('lte_header', $datos);
			$this->load->view('v_colores', $datos);
			$this->load->view('lte_footer', $datos);  
		 
		 }else
		 $this->obt_colores();
		 
		 
    }
	/********************************************************************************************************************/
	// Modificando un color
    public function modificar_color()
    {
		 $id_actual = $this->input->post('id_actual');
		 $id_color = $this->input->post('id_color');
		 $descripcion = $this->input->post('descripcion');
		 		 
		 $this->load->library('form_validation');
		 
		 $this->form_validation->set_rules('descripcion', 'Descripción', 'required');
		 
		 if ($this->form_validation->run() == true )
		 {
		 
			 $modificado = $this->M_configuracion->modificar_color($id_actual, $id_color, $descripcion);
			 
   		     if ($modificado == 1)
			 { 
				 $this->notificacion = "El color se modificó satisfactoriamente.";
		         $this->notificacion_error = false;
			 }
			 else
			 {
				 $this->notificacion = "ERROR. No se pudo modificar el color. Verifique los datos especificados.";
		         $this->notificacion_error = true;
		 }
				 
		 }
		 else
		 {
		     $this->notificacion = validation_errors();
			 $this->notificacion_error = true;
			 
		 }
		 if($this->notificacion_error == true){
			
		   
		    $datos['id_actual']    = $id_actual;
		    $datos['id_color']   = $id_color;
		    $datos['descripcion']  = $descripcion;
			
			$datos['notificacion'] = $this->notificacion ? $this->notificacion : "Error modificando el perfil del cliente " . $id_color;
          	$datos['notificacion_error'] = $this->notificacion_error;
			$datos['modo_edicion'] = true;

			$this->load->view('lte_header', $datos);
			$this->load->view('v_colores', $datos);
			$this->load->view('lte_footer', $datos);  
		 }else
		 
		 $this->obt_colores();
	}
	/********************************************************************************************************************/
	 //*******************************************************************************************************
	 /********************************************************************************************************************/
	// Interfaz para registrar un nuevo campaña
	public function nuevo_campana()
	{		
		$datos['notificacion'] = $this->notificacion ? $this->notificacion : "Especifique los datos de la nueva campaña:";
		$datos['notificacion_error'] = $this->notificacion_error;
		$datos['modo_edicion'] = false;
		
		$resultado = $this->M_configuracion->obt_tipo_campanas();
		$datos['tipos_campanas'] =$resultado;

		$this->load->view('lte_header', $datos);
		$this->load->view('v_campanas', $datos);
		$this->load->view('lte_footer', $datos);	
	}
	/********************************************************************************************************************/
	// Editando el campana
	public function editar_campana($id_actual)
	{
		$resultado = $this->M_configuracion->obt_campana($id_actual);
		
		if ($resultado)
		{
		   $campana = $resultado->row();

		   $id_campana = $id_actual;
		   $id_tipo_campana = $campana->id_tipo_campana;
		   $fecha_inicio = $campana->fecha_inicio;
		   $fecha_fin = $campana->fecha_fin;
		   $descuento = $campana->descuento;
		   $descripcion = $campana->descripcion;

		   $datos['modo_edicion'] = true;
		   $datos['notificacion'] = $this->notificacion ? $this->notificacion : "Modificando los datos de la campaña:";
		   $datos['notificacion_error'] = $this->notificacion_error;
		   
		   $resultado = $this->M_configuracion->obt_tipo_campanas();
		   $datos['tipos_campanas'] =$resultado;

		   $datos['id_actual']    = $id_actual;
		   $datos['id_campana']  = $id_campana;
		   $datos['id_tipo_campana']  = $id_tipo_campana;
		   $datos['fecha_inicio']       = $fecha_inicio;
		   $datos['fecha_fin'] = $fecha_fin;
		   $datos['descuento']  = $descuento;
		   $datos['descripcion']  = $descripcion;
		}
		
		$this->load->view('lte_header', $datos);
 	    $this->load->view('v_campanas', $datos);
	    $this->load->view('lte_footer', $datos);
	}

	
	/********************************************************************************************************************/
	// Confirmar eliminación de un campana
	public function cfe_campana($id_campana)
	{
		$datos['id_campana'] = $id_campana;
		
		$this->load->view('lte_header', $datos);
 	    $this->load->view('vcan_campanas', $datos);
	    $this->load->view('lte_footer', $datos);
	}
	/********************************************************************************************************************/
	// Cancelar campana
    public function cancelar_campana()
	{
		$id_campana = $this->input->post('id_campana');
		$cancelado = $this->M_configuracion->cancelar_campana($id_campana);
		
		if ($cancelado == 1)
	    { 
		   $this->not_fcliente = "Se eliminó la campaña correctamente.";
		}
		else
		{
		   $this->not_fcliente = "ERROR. No se pudo eliminar la campaña. Verifique los datos especificados.";
		}
		
		$this->obt_campanas();

	}
	/********************************************************************************************************************/
	// Listado de campana
    public function obt_campanas()
	{
		$campanas = $this->M_configuracion->obt_campanas();	
        $datos['campanas'] = $campanas;
		$datos['total_campanas'] = $this->M_configuracion->total_campanas();
		//$datos['total_productos_repuesto'] = $this->M_configuracion->total_productos_repuesto();
		
		$this->load->view('lte_header', $datos);
		$this->load->view('v_listado_campanas', $datos);
		$this->load->view('lte_footer', $datos);

	}
	public function obtener_campana($id_campana)
	{
		$campana = $this->M_configuracion->obt_campana($id_campana);
        $row = $prod->row_array();
		echo json_encode($row);  
	}
	/********************************************************************************************************************/
	// Registrando un campana
    public function registrar_campana()
    {

		 $id_tipo_campana 	= $this->input->post('id_tipo_campana');
		 $fecha_inicio 		= $this->input->post('fecha_inicio');
		 $fecha_fin 		= $this->input->post('fecha_fin');
		 $descuento 		= $this->input->post('descuento');
		 $descripcion 		= $this->input->post('descripcion');
		 
		 $this->load->library('form_validation');
		 
		 $this->form_validation->set_rules('descripcion', 'Descripcion', 'required');
		 $this->form_validation->set_rules('descuento', 'Descuento', 'required');
		 $this->form_validation->set_rules('id_tipo_campana', 'Tipo de campaña', 'required');
		 
		 if (   $this->form_validation->run() == true)
		 {		 
			 $registrado = $this->M_configuracion->registrar_campana( $id_tipo_campana, $fecha_inicio, $fecha_fin, $descuento,$descripcion);
			 
			 $mensaje = "";
			 if ($registrado == 1)
				 { 
					 $this->notificacion = "La campaña se registró satisfactoriamente.";
		             $this->notificacion_error = false;
				 }
				 else
				 {
					 $this->notificacion = "ERROR. No se pudo registrar la campaña.";
		             $this->notificacion_error = true;
				 }
				 
		 }
		 else
		 {
		     $this->notificacion = validation_errors();
			 $this->notificacion_error = true;
			 
		 }
		 if($this->notificacion_error == true){
			
			$datos['notificacion'] = $this->notificacion ? $this->notificacion : "Error registrando la campaña";
          	$datos['notificacion_error'] = $this->notificacion_error;
			$datos['modo_edicion'] = false;
			
			$datos['id_tipo_campana'] 	= $id_tipo_campana;
			$datos['tipos_campanas'] 	=$this->M_configuracion->obt_tipo_campanas();
		    $datos['fecha_inicio']      = $fecha_inicio;
		    $datos['fecha_fin'] 		= $fecha_fin;
		    $datos['descuento']  		= $descuento;		
			$datos['descripcion']  		= $descripcion;

			$this->load->view('lte_header', $datos);
			$this->load->view('v_campanas', $datos);
			$this->load->view('lte_footer', $datos);
		 
		 }else	
		 $this->obt_campanas();
		 
		 
    }
	/********************************************************************************************************************/
	// Modificando un campana
    public function modificar_campana()
    {
		 $id_actual 		= $this->input->post('id_actual');
		 $id_tipo_campana 	= $this->input->post('id_tipo_campana');
		 $fecha_inicio 		= $this->input->post('fecha_inicio');
		 $fecha_fin 		= $this->input->post('fecha_fin');
		 $descuento 		= $this->input->post('descuento');
		 $descripcion 		= $this->input->post('descripcion');
		 
		 $this->load->library('form_validation');

		 $this->form_validation->set_rules('descripcion', 'Descripcion', 'required');
		 $this->form_validation->set_rules('descuento', 'Descuento', 'required');
		 $this->form_validation->set_rules('id_tipo_campana', 'Tipo de campaña', 'required');
		 
		 if (   $this->form_validation->run() == true)
		 {
		 
			 $modificado = $this->M_configuracion->modificar_campana($id_actual,  $id_tipo_campana, $fecha_inicio, $fecha_fin, $descuento, $descripcion);
			 
   		     if ($modificado == 1)
			 { 
				 $this->notificacion = "La campaña se modificó satisfactoriamente.";
		         $this->notificacion_error = false;
			 }
			 else
			 {
				 $this->notificacion = "ERROR. No se pudo modificar la campaña. Verifique los datos especificados.";
		         $this->notificacion_error = true;
			 }
				 
		 }
		 else
		 {
		    $this->notificacion = validation_errors();
			$this->notificacion_error = true;

		 }
		 if($this->notificacion_error == true){
			
			$datos['notificacion'] = $this->notificacion ? $this->notificacion : "Error registrando la campaña";
          	$datos['notificacion_error'] = $this->notificacion_error;
			$datos['modo_edicion'] = true;
			
		    $datos['id_actual']    	= $id_actual;			
		    $datos['id_campana']  	= $id_actual;
		    $datos['id_tipo_campana']= $id_tipo_campana;
		    $datos['tipos_campanas']= $this->M_configuracion->obt_tipo_campanas();
		   	$datos['fecha_inicio']  = $fecha_inicio;
		   	$datos['fecha_fin'] 	= $fecha_fin;
		   	$datos['descuento']  	= $descuento;
			$datos['descripcion']  	= $descripcion;

			$this->load->view('lte_header', $datos);
			$this->load->view('v_campanas', $datos);
			$this->load->view('lte_footer', $datos);
	
		 }
		 
		 $this->obt_campanas();
	}
	/********************************************************************************************************************/
   // Editando el producto campaña
	public function agregar_campana_producto()
	{
		$id_campana= $this->input->post('id_campana');
		$id_producto = $this->input->post('sel_productos');
		$resultado = $this->M_configuracion->agregar_campana_producto($id_campana, $id_producto);
		$this->editar_campana_productos($id_campana);
	}
	public function editar_campana_productos($id_campana)
	{
		$resultado = $this->M_configuracion->obt_campana($id_campana);
		if ($resultado)
		{
		   $campana = $resultado->row();
		   
		   $nombre = $campana->nombre;
		   $datos['nombre']  = $nombre;
		   $datos['fecha_inicio']  = $campana->fecha_inicio;
		   $datos['fecha_fin']  = $campana->fecha_fin;
		   $datos['id_campana']  = $id_campana;
		}
		$resultado = $this->M_configuracion->obt_productos_para_campanas();
		$datos['productos'] = $resultado;
		$campana_productos = $this->M_configuracion->obt_campana_productos($id_campana);
		$datos['campana_productos'] = $campana_productos;

		$datos['modo_edicion'] = true;
		$datos['notificacion'] = 'Asignándole productos a la campaña: '  . $nombre;

		$this->load->view('lte_header', $datos);
 	    $this->load->view('v_campanas_productos', $datos);
	    $this->load->view('lte_footer', $datos);
	}
	 public function cancelar_campana_producto()
	{
		$id_producto = $this->input->post('id_producto');
		$id_campana = $this->input->post('id_campana');

		$cancelado = $this->M_configuracion->cancelar_campana_producto($id_campana, $id_producto);
		
		if ($cancelado == 1)
	    { 
		   $this->not_fcliente = "Se eliminó la campaña correctamente.";
		}
		else
		{
		   $this->not_fcliente = "ERROR. No se pudo eliminar la campaña. Verifique los datos especificados.";
		}
		
		$this->editar_campana_productos($id_campana);

	}
	public function cfe_campana_producto($id_campana, $id_producto)
	{
		$datos['id_producto'] = $id_producto;
		$datos['id_campana'] = $id_campana;
		
		$this->load->view('lte_header', $datos);
 	    $this->load->view('vcan_campana_productos', $datos);
	    $this->load->view('lte_footer', $datos);
	}
///////////////////////////////////////////////////////////////////
	public function nuevo_campana_rev()
	{		
		$datos['notificacion'] = $this->notificacion ? $this->notificacion : "Especifique los datos de la nueva promoción:";
		$datos['notificacion_error'] = $this->notificacion_error;
		$datos['modo_edicion'] = false;
		
		$resultado = $this->M_configuracion->obt_tipo_campanas();
		$datos['tipos_campanas'] =$resultado;

		$this->load->view('lte_header', $datos);
		$this->load->view('v_campanas_rev', $datos);
		$this->load->view('lte_footer', $datos);	
	}
	public function nuevo_desafio_mes()
	{		
		$datos['notificacion'] = $this->notificacion ? $this->notificacion : "Especifique los datos de la nueva promoción:";
		$datos['notificacion_error'] = $this->notificacion_error;
		$datos['modo_edicion'] = false;

		$this->load->view('lte_header', $datos);
		$this->load->view('v_desafio_mes', $datos);
		$this->load->view('lte_footer', $datos);	
	}
	/********************************************************************************************************************/
	// Editando el campana
	public function editar_campana_rev($id_actual)
	{
		$resultado = $this->M_configuracion->obt_campana_rev($id_actual);
		
		if ($resultado)
		{
		   $campana = $resultado->row();

		   $id_campana = $id_actual;
		   $id_tipo_campana = $campana->id_tipo_campana;
		   $fecha_inicio = $campana->fecha_inicio;
		   $fecha_fin = $campana->fecha_fin;
		   $descuento = $campana->descuento;
		   $descripcion = $campana->descripcion;

		   $datos['modo_edicion'] = true;
		   $datos['notificacion'] = $this->notificacion ? $this->notificacion : "Modificando los datos de la campaña:";
		   $datos['notificacion_error'] = $this->notificacion_error;
		   
		   $resultado = $this->M_configuracion->obt_tipo_campanas();
		   $datos['tipos_campanas'] =$resultado;

		   $datos['id_actual']    = $id_actual;
		   $datos['id_campana']  = $id_campana;
		   $datos['id_tipo_campana']  = $id_tipo_campana;
		   $datos['fecha_inicio']       = $fecha_inicio;
		   $datos['fecha_fin'] = $fecha_fin;
		   $datos['descuento']  = $descuento;
		   $datos['descripcion']  = $descripcion;
		}
		
		$this->load->view('lte_header', $datos);
 	    $this->load->view('v_campanas_rev', $datos);
	    $this->load->view('lte_footer', $datos);
	}
	public function editar_desafio_mes($id_actual)
	{
		$resultado = $this->M_configuracion->obt_desafio_mes1($id_actual);
		
		if ($resultado)
		{
		   $desafio = $resultado->row();

		   $id_desafio = $id_actual;
		   $fecha_inicio = $desafio->fecha_inicio;
		   $fecha_fin = $desafio->fecha_fin;
		   $cantidad_promedio = $desafio->cantidad_promedio;
		   $porciento_aumento = $desafio->porciento_aumento;
		   $porciento_descuento = $desafio->porciento_descuento;

		   $datos['modo_edicion'] = true;
		   $datos['notificacion'] = $this->notificacion ? $this->notificacion : "Modificando los datos de la promoción:";
		   $datos['notificacion_error'] = $this->notificacion_error;

		   $datos['id_actual']    = $id_actual;
		   $datos['id_desafio']  = $id_desafio;
		   $datos['fecha_inicio']       = $fecha_inicio;
		   $datos['fecha_fin'] = $fecha_fin;
		   $datos['cantidad_promedio']  = $cantidad_promedio;
		   $datos['porciento_aumento']  = $porciento_aumento;
		   $datos['porciento_descuento']  = $porciento_descuento;
		}
		
		$this->load->view('lte_header', $datos);
 	    $this->load->view('v_desafio_mes', $datos);
	    $this->load->view('lte_footer', $datos);
	}

	
	/********************************************************************************************************************/
	// Confirmar eliminación de un campana
	public function cfe_campana_rev($id_campana)
	{
		$datos['id_campana'] = $id_campana;
		
		$this->load->view('lte_header', $datos);
 	    $this->load->view('vcan_campanas_rev', $datos);
	    $this->load->view('lte_footer', $datos);
	}
	public function cfe_desafio_mes($id_desafio)
	{
		$datos['id_desafio'] = $id_desafio;
		
		$this->load->view('lte_header', $datos);
 	    $this->load->view('vcan_desafio_mes', $datos);
	    $this->load->view('lte_footer', $datos);
	}
	/********************************************************************************************************************/
	// Cancelar campana
    public function cancelar_campana_rev()
	{
		$id_campana = $this->input->post('id_campana');
		$cancelado = $this->M_configuracion->cancelar_campana_rev($id_campana);
		
		if ($cancelado == 1)
	    { 
		   $this->not_fcliente = "Se eliminó la campaña correctamente.";
		}
		else
		{
		   $this->not_fcliente = "ERROR. No se pudo eliminar la campaña. Verifique los datos especificados.";
		}
		
		$this->obt_campanas_rev();

	}
    public function cancelar_desafio_mes()
	{
		$id_desafio = $this->input->post('id_desafio');
		$cancelado = $this->M_configuracion->cancelar_desafio_mes($id_desafio);
		
		if ($cancelado == 1)
	    { 
		   $this->not_fcliente = "Se eliminó la campaña correctamente.";
		}
		else
		{
		   $this->not_fcliente = "ERROR. No se pudo eliminar la campaña. Verifique los datos especificados.";
		}
		
		$this->desafio_mes();

	}
	/********************************************************************************************************************/
	// Listado de campana
    public function obt_campanas_rev()
	{
		$campanas = $this->M_configuracion->obt_campanas_rev();	
        $datos['campanas'] = $campanas;
		$datos['total_campanas'] = $this->M_configuracion->total_campanas_rev();
		//$datos['total_productos_repuesto'] = $this->M_configuracion->total_productos_repuesto();
		
		$this->load->view('lte_header', $datos);
		$this->load->view('v_listado_campanas_rev', $datos);
		$this->load->view('lte_footer', $datos);

	}
    public function desafio_mes()
	{
		$desafios = $this->M_configuracion->obt_desafio_mes();	
        $datos['desafios'] = $desafios;
		$datos['total_desafios'] = $desafios->num_rows();
		//$datos['total_productos_repuesto'] = $this->M_configuracion->total_productos_repuesto();
		
		$this->load->view('lte_header', $datos);
		$this->load->view('v_listado_desafio_mes', $datos);
		$this->load->view('lte_footer', $datos);

	}
	public function obtener_campana_rev($id_campana)
	{
		$campana = $this->M_configuracion->obt_campana_rev($id_campana);
        $row = $prod->row_array();
		echo json_encode($row);  
	}
	/********************************************************************************************************************/
	// Registrando un campana
    public function registrar_campana_rev()
    {

		 $id_tipo_campana 	= $this->input->post('id_tipo_campana');
		 $fecha_inicio 		= $this->input->post('fecha_inicio');
		 $fecha_fin 		= $this->input->post('fecha_fin');
		 $descuento 		= $this->input->post('descuento');
		 $descripcion 		= $this->input->post('descripcion');
		 
		 $this->load->library('form_validation');
		 
		 $this->form_validation->set_rules('descripcion', 'Descripcion', 'required');
		 $this->form_validation->set_rules('descuento', 'Descuento', 'required');
		 $this->form_validation->set_rules('id_tipo_campana', 'Tipo de campaña', 'required');
		 
		 if (   $this->form_validation->run() == true)
		 {		 
			 $registrado = $this->M_configuracion->registrar_campana_rev( $id_tipo_campana, $fecha_inicio, $fecha_fin, $descuento,$descripcion);
			 
			 $mensaje = "";
			 if ($registrado == 1)
				 { 
					 $this->notificacion = "La campaña se registró satisfactoriamente.";
		             $this->notificacion_error = false;
				 }
				 else
				 {
					 $this->notificacion = "ERROR. No se pudo registrar la campaña.";
		             $this->notificacion_error = true;
				 }
				 
		 }
		 else
		 {
		     $this->notificacion = validation_errors();
			 $this->notificacion_error = true;
			 
		 }
		 if($this->notificacion_error == true){
			
			$datos['notificacion'] = $this->notificacion ? $this->notificacion : "Error registrando la campaña";
          	$datos['notificacion_error'] = $this->notificacion_error;
			$datos['modo_edicion'] = false;
			
			$datos['id_tipo_campana'] 	= $id_tipo_campana;
			$datos['tipos_campanas'] 	=$this->M_configuracion->obt_tipo_campanas();
		    $datos['fecha_inicio']      = $fecha_inicio;
		    $datos['fecha_fin'] 		= $fecha_fin;
		    $datos['descuento']  		= $descuento;		
			$datos['descripcion']  		= $descripcion;

			$this->load->view('lte_header', $datos);
			$this->load->view('v_campanas_rev', $datos);
			$this->load->view('lte_footer', $datos);
		 
		 }else	
		 $this->obt_campanas_rev();
		 
		 
    }
    public function registrar_desafio_mes()
    {
		 $fecha_inicio 			= $this->input->post('fecha_inicio');
		 $fecha_fin 			= $this->input->post('fecha_fin');
		 $cantidad_promedio 	= $this->input->post('cantidad_promedio');
		 $porciento_aumento 	= $this->input->post('porciento_aumento');
		 $porciento_descuento 	= $this->input->post('porciento_descuento');
		 
		 $this->load->library('form_validation');
		 
		 $this->form_validation->set_rules('cantidad_promedio', 'Cantidad promedio', 'required');
		 $this->form_validation->set_rules('porciento_aumento', 'Porciento aumento', 'required');
		 $this->form_validation->set_rules('porciento_descuento', 'Porciento descuento', 'required');
		 
		 if (   $this->form_validation->run() == true)
		 {		 
			 $registrado = $this->M_configuracion->registrar_desafio_mes($fecha_inicio, $fecha_fin,$cantidad_promedio, $porciento_aumento, $porciento_descuento);
			 
			 $mensaje = "";
			 if ($registrado == 1)
				 { 
					 $this->notificacion = "La campaña se registró satisfactoriamente.";
		             $this->notificacion_error = false;
				 }
				 else
				 {
					 $this->notificacion = "ERROR. No se pudo registrar la campaña.";
		             $this->notificacion_error = true;
				 }
				 
		 }
		 else
		 {
		     $this->notificacion = validation_errors();
			 $this->notificacion_error = true;
			 
		 }
		 if($this->notificacion_error == true){
			
			$datos['notificacion'] = $this->notificacion ? $this->notificacion : "Error registrando la campaña";
          	$datos['notificacion_error'] = $this->notificacion_error;
			$datos['modo_edicion'] = false;
			
		    $datos['fecha_inicio']      = $fecha_inicio;
		    $datos['fecha_fin'] 		= $fecha_fin;
			$datos['cantidad_promedio']  = $cantidad_promedio;		
			$datos['porciento_aumento']  = $porciento_aumento;
			$datos['porciento_descuento']  = $porciento_descuento;

			$this->load->view('lte_header', $datos);
			$this->load->view('v_desafio_mes', $datos);
			$this->load->view('lte_footer', $datos);
		 
		 }else	
		 $this->desafio_mes();
		 
		 
    }
	/********************************************************************************************************************/
	// Modificando un campana
    public function modificar_campana_rev()
    {
		 $id_actual 		= $this->input->post('id_actual');
		 $id_tipo_campana 	= $this->input->post('id_tipo_campana');
		 $fecha_inicio 		= $this->input->post('fecha_inicio');
		 $fecha_fin 		= $this->input->post('fecha_fin');
		 $descuento 		= $this->input->post('descuento');
		 $descripcion 		= $this->input->post('descripcion');
		 
		 $this->load->library('form_validation');

		 $this->form_validation->set_rules('descripcion', 'Descripcion', 'required');
		 $this->form_validation->set_rules('descuento', 'Descuento', 'required');
		 $this->form_validation->set_rules('id_tipo_campana', 'Tipo de campaña', 'required');
		 
		 if (   $this->form_validation->run() == true)
		 {
		 
			 $modificado = $this->M_configuracion->modificar_campana_rev($id_actual,  $id_tipo_campana, $fecha_inicio, $fecha_fin, $descuento, $descripcion);
			 
   		     if ($modificado == 1)
			 { 
				 $this->notificacion = "La campaña se modificó satisfactoriamente.";
		         $this->notificacion_error = false;
			 }
			 else
			 {
				 $this->notificacion = "ERROR. No se pudo modificar la campaña. Verifique los datos especificados.";
		         $this->notificacion_error = true;
			 }
				 
		 }
		 else
		 {
		    $this->notificacion = validation_errors();
			$this->notificacion_error = true;

		 }
		 if($this->notificacion_error == true){
			
			$datos['notificacion'] = $this->notificacion ? $this->notificacion : "Error registrando la campaña";
          	$datos['notificacion_error'] = $this->notificacion_error;
			$datos['modo_edicion'] = true;
			
		    $datos['id_actual']    	= $id_actual;			
		    $datos['id_campana']  	= $id_actual;
		    $datos['id_tipo_campana']= $id_tipo_campana;
		    $datos['tipos_campanas']= $this->M_configuracion->obt_tipo_campanas();
		   	$datos['fecha_inicio']  = $fecha_inicio;
		   	$datos['fecha_fin'] 	= $fecha_fin;
		   	$datos['descuento']  	= $descuento;
			$datos['descripcion']  	= $descripcion;

			$this->load->view('lte_header', $datos);
			$this->load->view('v_campanas_rev', $datos);
			$this->load->view('lte_footer', $datos);
	
		 }
		 
		 $this->obt_campanas_rev();
	}
    public function modificar_desafio_mes()
    {
		 $id_actual 		= $this->input->post('id_actual');
		 $fecha_inicio 		= $this->input->post('fecha_inicio');
		 $fecha_fin 		= $this->input->post('fecha_fin');
		 $cantidad_promedio 		= $this->input->post('cantidad_promedio');
		 $porciento_aumento 		= $this->input->post('porciento_aumento');
		 $porciento_descuento 		= $this->input->post('porciento_descuento');
		 
		 $this->load->library('form_validation');

		 $this->form_validation->set_rules('cantidad_promedio', 'Cantidad promedio', 'required');
		 $this->form_validation->set_rules('porciento_aumento', 'Porciento aumento', 'required');
		 $this->form_validation->set_rules('porciento_descuento', 'Porciento descuento', 'required');
		 
		 if (   $this->form_validation->run() == true)
		 {
		 
			 $modificado = $this->M_configuracion->modificar_desafio_mes($id_actual, $fecha_inicio, $fecha_fin,$cantidad_promedio, $porciento_aumento, $porciento_descuento);
			 
   		     if ($modificado == 1)
			 { 
				 $this->notificacion = "La campaña se modificó satisfactoriamente.";
		         $this->notificacion_error = false;
			 }
			 else
			 {
				 $this->notificacion = "ERROR. No se pudo modificar la campaña. Verifique los datos especificados.";
		         $this->notificacion_error = true;
			 }
				 
		 }
		 else
		 {
		    $this->notificacion = validation_errors();
			$this->notificacion_error = true;

		 }
		 if($this->notificacion_error == true){
			
			$datos['notificacion'] = $this->notificacion ? $this->notificacion : "Error registrando la campaña";
          	$datos['notificacion_error'] = $this->notificacion_error;
			$datos['modo_edicion'] = true;
			
		    $datos['id_actual']    	= $id_actual;			
		    $datos['id_desafio']  	= $id_actual;
		   	$datos['fecha_inicio']  = $fecha_inicio;
		   	$datos['fecha_fin'] 	= $fecha_fin;
		   	$datos['cantidad_promedio']  	= $cantidad_promedio;
			$datos['porciento_aumento']  	= $porciento_aumento;
			$datos['porciento_descuento']  	= $porciento_descuento;

			$this->load->view('lte_header', $datos);
			$this->load->view('v_desafio_mes', $datos);
			$this->load->view('lte_footer', $datos);
	
		 }
		 
		 $this->desafio_mes();
	}
	/********************************************************************************************************************/
   // Editando el producto campaña
	public function agregar_campana_producto_rev()
	{
		$id_campana= $this->input->post('id_campana');
		//$id_producto = $this->input->post('sel_productos');
		$productos =  $this->input->post('prod_agr');
		$dt_productos		= explode(',',$productos);
		for ($i=0; $i <count($dt_productos) ; $i++) { 
			$resultado = $this->M_configuracion->agregar_campana_producto_rev($id_campana, $dt_productos[$i]);
		}
		
		$this->editar_campana_productos_rev($id_campana);
	}
	public function editar_campana_productos_rev($id_campana)
	{
		$resultado = $this->M_configuracion->obt_campana_rev($id_campana);
		if ($resultado)
		{
		   $campana = $resultado->row();
		   
		   $nombre = $campana->nombre;
		   $datos['nombre']  = $nombre;
		   $datos['fecha_inicio']  = $campana->fecha_inicio;
		   $datos['fecha_fin']  = $campana->fecha_fin;
		   $datos['id_campana']  = $id_campana;
		}
		$resultado = $this->M_configuracion->obt_productos_para_campanas_rev();
		$datos['productos'] = $resultado;
		$campana_productos = $this->M_configuracion->obt_campana_productos_rev($id_campana);
		$datos['campana_productos'] = $campana_productos;

		$datos['modo_edicion'] = true;
		$datos['notificacion'] = 'Asignándole productos a la promoción: '  . $nombre;

		$this->load->view('lte_header', $datos);
 	    $this->load->view('v_campanas_productos_rev', $datos);
	    $this->load->view('lte_footer', $datos);
	}
	 public function cancelar_campana_producto_rev()
	{
		$id_producto = $this->input->post('id_producto');
		$id_campana = $this->input->post('id_campana');

		$cancelado = $this->M_configuracion->cancelar_campana_producto_rev($id_campana, $id_producto);
		
		if ($cancelado == 1)
	    { 
		   $this->not_fcliente = "Se eliminó la campaña correctamente.";
		}
		else
		{
		   $this->not_fcliente = "ERROR. No se pudo eliminar la campaña. Verifique los datos especificados.";
		}
		
		$this->editar_campana_productos_rev($id_campana);

	}
	public function cfe_campana_producto_rev($id_campana, $id_producto)
	{
		$datos['id_producto'] = $id_producto;
		$datos['id_campana'] = $id_campana;
		
		$this->load->view('lte_header', $datos);
 	    $this->load->view('vcan_campana_productos_rev', $datos);
	    $this->load->view('lte_footer', $datos);
	}
	public function agregar_producto_desafio()
	{
		$id_desafio= $this->input->post('id_desafio');
		$id_producto = $this->input->post('sel_productos');
		$resultado = $this->M_configuracion->agregar_desafio_producto($id_desafio, $id_producto);
		$this->editar_producto_desafio($id_desafio);
	}
	public function editar_producto_desafio($id_desafio)
	{
		$resultado = $this->M_configuracion->obt_desafio_mes1($id_desafio);
		if ($resultado)
		{
		   $campana = $resultado->row();
		   
		   $datos['fecha_inicio']  = $campana->fecha_inicio;
		   $datos['fecha_fin']  = $campana->fecha_fin;
		   $datos['id_desafio']  = $id_desafio;
		}
		$resultado = $this->M_configuracion->obt_productos_para_campanas_rev();
		$datos['productos'] = $resultado;
		$desafio_productos = $this->M_configuracion->obt_desafio_productos($id_desafio);
		$datos['desafio_productos'] = $desafio_productos;

		$datos['modo_edicion'] = true;
		$datos['notificacion'] = 'Asignándole productos a la promoción: ' ;

		$this->load->view('lte_header', $datos);
 	    $this->load->view('v_desafio_productos', $datos);
	    $this->load->view('lte_footer', $datos);
	}
	 public function cancelar_producto_desafio()
	{
		$id_producto = $this->input->post('id_producto');
		$id_desafio = $this->input->post('id_desafio');

		$cancelado = $this->M_configuracion->cancelar_desafio_producto($id_desafio, $id_producto);
		
		if ($cancelado == 1)
	    { 
		   $this->not_fcliente = "Se eliminó la campaña correctamente.";
		}
		else
		{
		   $this->not_fcliente = "ERROR. No se pudo eliminar la campaña. Verifique los datos especificados.";
		}
		
		$this->editar_producto_desafio($id_desafio);

	}
	public function cfe_producto_desafio($id_desafio, $id_producto)
	{
		$datos['id_producto'] = $id_producto;
		$datos['id_desafio'] = $id_desafio;
		
		$this->load->view('lte_header', $datos);
 	    $this->load->view('vcan_desafio_productos', $datos);
	    $this->load->view('lte_footer', $datos);
	}
	   //*******************************************************************************************************
	//     Gestion de TIPOS DE CAMPAÑAS
	//*******************************************************************************************************
    // Interfaz para registrar un nuevo color
	public function nuevo_tipo_campana()
	{		
		$datos['notificacion'] = $this->notificacion ? $this->notificacion : "Especifique los datos del nuevo tipo de campaña:";
		$datos['notificacion_error'] = $this->notificacion_error;
		$datos['modo_edicion'] = false;
		
		$this->load->view('lte_header', $datos);
		$this->load->view('v_tipo_campanas', $datos);
		$this->load->view('lte_footer', $datos);	
	}
	/********************************************************************************************************************/
	// Editando la tipo_campana
	public function editar_tipo_campana($id_actual)
	{
		$resultado = $this->M_configuracion->obt_tipo_campana($id_actual);
		
		if ($resultado)
		{
		   $tipo_campana = $resultado->row();

		   $id_tipo_campana = $id_actual;
		   $descripcion = $tipo_campana->nombre;
		   
		   		   
		   $datos['notificacion_error'] = $this->notificacion_error;
		   $datos['notificacion'] = 'Modificando los datos del tipo de campaña ' . $id_tipo_campana . ' ' . $descripcion;
		   $datos['modo_edicion'] = true;
		   
		   $datos['id_actual']    		= $id_actual;
		   $datos['id_tipo_campana']  	= $id_tipo_campana;
		   $datos['descripcion']  		= $descripcion;
		   
		}
		
		$this->load->view('lte_header', $datos);
 	    $this->load->view('v_tipo_campanas', $datos);
	    $this->load->view('lte_footer', $datos);
	}
	
	/********************************************************************************************************************/
	// Confirmar eliminación de un tipo_campana
	public function cfe_tipo_campana($id_tipo_campana)
	{
		$datos['id_tipo_campana'] = $id_tipo_campana;
		
		$this->load->view('lte_header', $datos);
 	    $this->load->view('vcan_tipo_campanas', $datos);
	    $this->load->view('lte_footer', $datos);
	}
	/********************************************************************************************************************/
	// Cancelar tipo_campana
    public function cancelar_tipo_campana()
	{
		$id_tipo_campana = $this->input->post('id_tipo_campana');
		$cancelado = $this->M_configuracion->cancelar_tipo_campana($id_tipo_campana);
		
		if ($cancelado == 1)
	    { 
		   $this->not_fcliente = "Se eliminó el tipo de campaña correctamente.";
		}
		else
		{
		   $this->not_fcliente = "ERROR. No se pudo eliminar el tipo campaña. Verifique los datos especificados.";
		}
		
		$this->obt_tipo_campanas();

	}
	/********************************************************************************************************************/
	// Listado de tipo_campana
    public function obt_tipo_campanas()
	{
		$tipo_campanas 					= $this->M_configuracion->obt_tipo_campanas();	
        $datos['tipo_campanas'] 		= $tipo_campanas;
		$datos['total_tipo_campanas']	= $this->M_configuracion->total_tipo_campanas();
        
		$this->load->view('lte_header', $datos);
		$this->load->view('v_listado_tipo_campana', $datos);
		$this->load->view('lte_footer', $datos);

	}
	/********************************************************************************************************************/
	// Registrando un cotipo_campanalor
    public function registrar_tipo_campana()
    {
		 
		 $descripcion = $this->input->post('descripcion');
		 
		 $this->load->library('form_validation');
			 
		 $this->form_validation->set_rules('descripcion', 'Descripcion', 'required');
		 
		 
		 if ($this->form_validation->run() == true )
		 {		 
			 $registrado = $this->M_configuracion->registrar_tipo_campana($descripcion);
			 
			 $mensaje = "";
			 if ($registrado == 1)
				 { 
					 $this->notificacion = "El nuevo tipo de campaña se registró satisfactoriamente.";
		             $this->notificacion_error = false;
				}
				else
				{
					 $this->notificacion = "ERROR. No se pudo registrar el tipo de campaña.";
		             $this->notificacion_error = true;
				}

		}
		 else
		 {
		     $this->notificacion = validation_errors();
			 $this->notificacion_error = true;
			 
		 }
		 if($this->notificacion_error == true){
		 
		 $datos['notificacion'] = $this->notificacion ? $this->notificacion : "Especifique los datos del nuevo tipo de campaña:";
		 $datos['notificacion_error'] = $this->notificacion_error;
		 $datos['modo_edicion'] = false;
		
		 $this->load->view('lte_header', $datos);
		 $this->load->view('v_tipo_campanas', $datos);
		 $this->load->view('lte_footer', $datos);
		 }else
		 $this->obt_tipo_campanas();
		 
		 
    }
	/********************************************************************************************************************/
	// Modificando un tipo_campana
    public function modificar_tipo_campana()
    {
		 $id_actual = $this->input->post('id_actual');
		 $id_tipo_campana = $this->input->post('id_tipo_campana');
		 $descripcion = $this->input->post('descripcion');
		 		 
		 $this->load->library('form_validation');
			 
		 $this->form_validation->set_rules('descripcion', 'Descripcion', 'required');
		 
		 
		 if ($this->form_validation->run() == true )
		 {		 
		 
			 $modificado = $this->M_configuracion->modificar_tipo_campana($id_actual, $id_tipo_campana, $descripcion);
			 
   		     if ($modificado == 1)
			 { 
				$this->notificacion = "El tipo de campaña se modificó satisfactoriamente.";
		         $this->notificacion_error = false;
			 }
			 else
			 {
				 $this->notificacion = "ERROR. No se pudo modificar el tipo de campaña. Verifique los datos especificados.";
		         $this->notificacion_error = true;
			 }
			 
		 }
		 else
		 {
		     $this->notificacion = validation_errors();
			 $this->notificacion_error = true;

		 }
		 if($this->notificacion_error == true){
			$datos['notificacion'] = $this->notificacion ? $this->notificacion : "Especifique los datos del la campaña:";
			$datos['id_actual']    		= $id_actual;
		    $datos['id_tipo_campana']  	= $id_tipo_campana;
		    $datos['descripcion']  		= $descripcion;
			$datos['modo_edicion'] 		= true;
			
			$this->load->view('lte_header', $datos);
			$this->load->view('v_tipo_campanas', $datos);
			$this->load->view('lte_footer', $datos);
		 }
		 else		 
		 $this->obt_tipo_campanas();
	}
	/********************************************************************************************************************/
	/********************************************************************************************************************/
	//*******************************************************************************************************
	//     Gestion de paises
	//*******************************************************************************************************
    // Interfaz para registrar un nuevo pais
	public function nuevo_pais()
	{		
		$datos['notificacion'] = "Especifique los datos del nuevo pais:";
		$datos['modo_edicion'] = false;
		$datos['notificacion_error'] = $this->notificacion_error;
		
		$this->load->view('lte_header', $datos);
		$this->load->view('v_paises', $datos);
		$this->load->view('lte_footer', $datos);	
	}
	/********************************************************************************************************************/
	// Editando la pais
	public function editar_pais($id_actual)
	{
		$resultado = $this->M_configuracion->obt_pais($id_actual);
		
		if ($resultado)
		{
		   $pais = $resultado->row();

		   $id_pais = $id_actual;
		   $descripcion = $pais->nombre;
		   
		   		   
		   $datos['modo_edicion'] = true;
		   $datos['notificacion'] = 'Modificando los datos del pais ' . $id_pais . ' ' . $descripcion;
		   
		   $datos['id_actual']    = $id_actual;
		   $datos['id_pais']   = $id_pais;
		   $datos['descripcion']  = $descripcion;
		   
		}
		
		$this->load->view('lte_header', $datos);
 	    $this->load->view('v_paises', $datos);
	    $this->load->view('lte_footer', $datos);
	}
	
	/********************************************************************************************************************/
	// Confirmar eliminación de un pais
	public function cfe_pais($id_pais)
	{
		$datos['id_pais'] = $id_pais;
		
		$this->load->view('lte_header', $datos);
 	    $this->load->view('vcan_paises', $datos);
	    $this->load->view('lte_footer', $datos);
	}
	/********************************************************************************************************************/
	// Cancelar pais
    public function cancelar_pais()
	{
		$id_pais = $this->input->post('id_pais');
		$cancelado = $this->M_configuracion->cancelar_pais($id_pais);
		
		if ($cancelado == 1)
	    { 
		   $this->not_fcliente = "Se eliminó el pais correctamente.";
		}
		else
		{
		   $this->not_fcliente = "ERROR. No se pudo eliminar el pais. Verifique los datos especificados.";
		}
		
		$this->obt_paises();

	}
	/********************************************************************************************************************/
	// Listado de pais
    public function obt_paises()
	{
		$paises 				= $this->M_configuracion->obt_paises();	
        $datos['paises'] 		= $paises;
		$datos['total_paises'] = $this->M_configuracion->total_paises();
        
		$this->load->view('lte_header', $datos);
		$this->load->view('v_listado_pais', $datos);
		$this->load->view('lte_footer', $datos);

	}
	/********************************************************************************************************************/
	// Registrando un pais
    public function registrar_pais()
    {
		 
		 $descripcion = $this->input->post('descripcion');
		 
		 $this->load->library('form_validation');
		 
		 $this->form_validation->set_rules('descripcion', 'Descripción', 'required');
		 
		 if ($this->form_validation->run() == true )
		 {		 
			 $registrado = $this->M_configuracion->registrar_pais($descripcion);
			 
			 $mensaje = "";
			 if ($registrado == 1)
				 { 
					 $this->notificacion = "El país se registró satisfactoriamente.";
		             $this->notificacion_error = false;
				 }
				 else
				 {
					 $this->notificacion = "ERROR. No se pudo registrar el país.";
		             $this->notificacion_error = true;
				 }
				 
		 }
		 else
		 {
		     $this->notificacion = validation_errors();
			 $this->notificacion_error = true;
			 
		 }
		 if($this->notificacion_error == true){			
			
		    $datos['descripcion']  = $descripcion;
		   
			$datos['notificacion'] = $this->notificacion ? $this->notificacion : "Error registrando el país" . $descripcion;
          	$datos['notificacion_error'] = $this->notificacion_error;
			$datos['modo_edicion'] = false;

			$this->load->view('lte_header', $datos);
			$this->load->view('v_paises', $datos);
			$this->load->view('lte_footer', $datos);  
		 
		 }else
		 $this->obt_paises();
		 
		 
    }
	/********************************************************************************************************************/
	// Modificando un pais
    public function modificar_pais()
    {
		 $id_actual = $this->input->post('id_actual');
		 $id_pais = $this->input->post('id_pais');
		 $descripcion = $this->input->post('descripcion');
		 		 
		 $this->load->library('form_validation');
		 
		 $this->form_validation->set_rules('descripcion', 'Descripción', 'required');
		 
		 if ($this->form_validation->run() == true )
		 {
		 
			 $modificado = $this->M_configuracion->modificar_pais($id_actual, $id_pais, $descripcion);
			 
   		     if ($modificado == 1)
			 { 
				 $this->notificacion = "El cliente se modificó satisfactoriamente.";
		         $this->notificacion_error = false;
			 }
			 else
			 {
				 $this->notificacion = "ERROR. No se pudo modificar el cliente. Verifique los datos especificados.";
		         $this->notificacion_error = true;
		 }
				 
		 }
		 else
		 {
		     $this->notificacion = validation_errors();
			 $this->notificacion_error = true;
			 
		 }
		 if($this->notificacion_error == true){
			
			$datos['id_actual']    = $id_actual;
		    $datos['id_pais']   = $id_pais;
		    $datos['descripcion']  = $descripcion;
			
			$datos['notificacion'] = $this->notificacion ? $this->notificacion : "Error modificando el país " . $descripcion;
          	$datos['notificacion_error'] = $this->notificacion_error;
			$datos['modo_edicion'] = true;

			$this->load->view('lte_header', $datos);
			$this->load->view('v_paises', $datos);
			$this->load->view('lte_footer', $datos);  
		 }else
		 
		 $this->obt_paises();
	}
	/********************************************************************************************************************/
	/********************************************************************************************************************/
	/********************************************************************************************************************/
	//*******************************************************************************************************
	//     Gestion de provincia
	//*******************************************************************************************************
    // Interfaz para registrar un nuevo provincia
	public function nuevo_provincia()
	{		
		$datos['notificacion'] = "Especifique los datos de la nueva provincia:";
		$datos['modo_edicion'] = false;
		$datos['notificacion_error'] = $this->notificacion_error;
		$datos['paises'] = $this->M_configuracion->obt_paises();

		$this->load->view('lte_header', $datos);
		$this->load->view('v_provincias', $datos);
		$this->load->view('lte_footer', $datos);	
	}
	/********************************************************************************************************************/
	// Editando la pais
	public function editar_provincia($id_actual)
	{
		$resultado = $this->M_configuracion->obt_provincia($id_actual);
		
		if ($resultado)
		{
		   $provincias = $resultado->row();

		   $id_provincia = $id_actual;
		   $descripcion = $provincias->nombre;
		   $id_pais = $provincias->id_pais;
		   		   
		   $datos['modo_edicion'] = true;
		   $datos['notificacion'] = 'Modificando los datos de la provincia ' . $id_provincia . ' ' . $descripcion;
		   $datos['notificacion_error'] = $this->notificacion_error;
		   
		   $datos['id_actual']    = $id_actual;
		   $datos['id_provincia']   = $id_provincia;
		   $datos['descripcion']  = $descripcion;
		   $datos['id_pais'] = $id_pais;
		   
		    $datos['paises'] = $this->M_configuracion->obt_paises();
		}
		
		$this->load->view('lte_header', $datos);
 	    $this->load->view('v_provincias', $datos);
	    $this->load->view('lte_footer', $datos);
	}
	
	/********************************************************************************************************************/
	// Confirmar eliminación de un provincia
	public function cfe_provincia($id_provincia)
	{
		$datos['id_provincia'] = $id_provincia;
		
		$this->load->view('lte_header', $datos);
 	    $this->load->view('vcan_provincias', $datos);
	    $this->load->view('lte_footer', $datos);
	}
	/********************************************************************************************************************/
	// Cancelar provincia
    public function cancelar_provincia()
	{
		$id_provincia = $this->input->post('id_provincia');
		$cancelado = $this->M_configuracion->cancelar_provincia($id_provincia);
		
		if ($cancelado == 1)
	    { 
		   $this->not_fcliente = "Se eliminó la provincia correctamente.";
		}
		else
		{
		   $this->not_fcliente = "ERROR. No se pudo eliminar la provincia. Verifique los datos especificados.";
		}
		
		$this->obt_provincias();

	}
	/********************************************************************************************************************/
	// Listado de provincia
    public function obt_provincias()
	{
		$provincias 				= $this->M_configuracion->obt_provincias();	
        $datos['provincias'] 		= $provincias;
		$datos['total_provincias'] = $this->M_configuracion->total_provincias();
        
		$this->load->view('lte_header', $datos);
		$this->load->view('v_listado_provincia', $datos);
		$this->load->view('lte_footer', $datos);

	}
	/********************************************************************************************************************/
	// Registrando un provincia
    public function registrar_provincia()
    {
		 $descripcion = $this->input->post('descripcion');
		 $id_pais = $this->input->post('id_pais');
		 
		 $this->load->library('form_validation');
		 
		 $this->form_validation->set_rules('descripcion', 'Descripción', 'required');
		 
		 if ($this->form_validation->run() == true )
		 {		 
			 $registrado = $this->M_configuracion->registrar_provincia($descripcion,$id_pais);
			 
			 $mensaje = "";
			 if ($registrado == 1)
				 { 
					 $this->notificacion = "La provincia se registró satisfactoriamente.";
		             $this->notificacion_error = false;					 
				 }
				 else
				 {
					 $this->notificacion = "ERROR. No se pudo registrar la provincia.";
		             $this->notificacion_error = true;
				 }
				 
		 }
		 else
		 {
		     $this->notificacion = validation_errors();
			 $this->notificacion_error = true;
			 
		 }
		 if($this->notificacion_error == true){
			
			$datos['descripcion']  = $descripcion;
		    $datos['id_pais'] = $id_pais;
			$datos['paises'] = $this->M_configuracion->obt_paises();
		
			$datos['notificacion'] = $this->notificacion ? $this->notificacion : "Error registrando la provincia" . $descripcion;
          	$datos['notificacion_error'] = $this->notificacion_error;
			$datos['modo_edicion'] = false;

			$this->load->view('lte_header', $datos);
			$this->load->view('v_provincias', $datos);
			$this->load->view('lte_footer', $datos);  
		 
		 }else
		 $this->obt_provincias();
		 
		 
    }
	/********************************************************************************************************************/
	// Modificando un provincia
    public function modificar_provincia()
    {
		 $id_actual = $this->input->post('id_actual');
		 $id_provincia = $this->input->post('id_provincia');
		 $descripcion = $this->input->post('descripcion');
		 $id_pais = $this->input->post('id_pais');
		 		 
		 $this->load->library('form_validation');
		 
		 $this->form_validation->set_rules('descripcion', 'Descripción', 'required');
		 
		 if ($this->form_validation->run() == true )
		 {
		 
			 $modificado = $this->M_configuracion->modificar_provincia($id_actual, $id_provincia, $descripcion, $id_pais);
			 
   		     if ($modificado == 1)
			 { 
				 $this->notificacion = "La provincia se modificó satisfactoriamente.";
		         $this->notificacion_error = false;
			 }
			 else
			 {
				 $this->notificacion = "ERROR. No se pudo modificar la provincia. Verifique los datos especificados.";
		         $this->notificacion_error = true;
		 }
				 
		 }
		 else
		 {
		     $this->notificacion = validation_errors();
			 $this->notificacion_error = true;
			 
		 }
		 if($this->notificacion_error == true){
			
			$datos['id_actual']    = $id_actual;
		    $datos['id_provincia']   = $id_provincia;
			$datos['descripcion']  = $descripcion;
		    $datos['id_pais'] = $id_pais;
			$datos['paises'] = $this->M_configuracion->obt_paises();

			$datos['notificacion'] = $this->notificacion ? $this->notificacion : "Error modificando la provincia " . $descripcion;
          	$datos['notificacion_error'] = $this->notificacion_error;
			$datos['modo_edicion'] = true;

			$this->load->view('lte_header', $datos);
			$this->load->view('v_provincias', $datos);
			$this->load->view('lte_footer', $datos);  
		 }else
		 
		 $this->obt_provincias();
	}
	/********************************************************************************************************************/
	// Listado de municipios
    public function obt_municipios($id_provincia)
	{
		$resultado 				= $this->M_configuracion->obt_provincia($id_provincia);
		if ($resultado)
		{
		   $provincia = $resultado->row();
		   
		   $descripcion = $provincia->nombre;
		   $id_pais = $provincia->id_pais;
		   $pais = $provincia->pais;

		   $datos['id_provincia'] 	= $id_provincia;
		   $datos['provincia'] 	= $descripcion;
		   $datos['id_pais'] 		= $id_pais;
		   $datos['pais'] 			= $pais;
		}	

        $datos['municipios'] 		= $this->M_configuracion->obt_municipios($id_provincia);
		$datos['total_municipios'] = $this->M_configuracion->total_municipios($id_provincia);
        
		$this->load->view('lte_header', $datos);
		$this->load->view('v_listado_municipio', $datos);
		$this->load->view('lte_footer', $datos);

	}
	// Interfaz para registrar un nuevo municipio
	public function nuevo_municipio($id_provincia)
	{		
		$datos['notificacion'] = "Especifique los datos del nuevo municipio:";
		$datos['modo_edicion'] = false;
		$datos['notificacion_error'] = $this->notificacion_error;
		$datos['id_provincia'] = $id_provincia;

		$this->load->view('lte_header', $datos);
		$this->load->view('v_municipio', $datos);
		$this->load->view('lte_footer', $datos);	
	}
	/********************************************************************************************************************/
	// Registrando un municipio
    public function registrar_municipio()
    {
		 
		 $descripcion = $this->input->post('descripcion');
		 $id_provincia = $this->input->post('id_provincia');
		 
		 $this->load->library('form_validation');
		 
		 $this->form_validation->set_rules('descripcion', 'Descripción', 'required');
		 
		 if ($this->form_validation->run() == true )
		 {		 
			 $registrado = $this->M_configuracion->registrar_municipio($descripcion,$id_provincia);
			 
			 $mensaje = "";
			 if ($registrado == 1)
				 { 
					 $this->notificacion = "El municipio se registró satisfactoriamente.";
		             $this->notificacion_error = false;					 
				 }
				 else
				 {
					 $this->notificacion = "ERROR. No se pudo registrar el municipio.";
		             $this->notificacion_error = true;
				 }
				 
		 }
		 else
		 {
		     $this->notificacion = validation_errors();
			 $this->notificacion_error = true;
			 
		 }
		 if($this->notificacion_error == true){	
			
		   $datos['descripcion']  = $descripcion;
		   $datos['id_provincia'] = $id_provincia;
		
			$datos['notificacion'] = $this->notificacion ? $this->notificacion : "Error registrando el municipio" . $descripcion;
          	$datos['notificacion_error'] = $this->notificacion_error;
			$datos['modo_edicion'] = false;

			$this->load->view('lte_header', $datos);
			$this->load->view('v_municipio', $datos);
			$this->load->view('lte_footer', $datos);  
		 
		 }else
		 $this->obt_municipios($id_provincia);
		 
		 
    }
		/********************************************************************************************************************/
	// Editando la municipio
	public function editar_municipio($id_actual)
	{
		$resultado = $this->M_configuracion->obt_municipio($id_actual);
		
		if ($resultado)
		{
		   $municipio = $resultado->row();

		   $id_municipio = $id_actual;
		   $descripcion = $municipio->nombre_municipio;
		   $id_provincia = $municipio->id_provincia;
		   		   
		   $datos['modo_edicion'] = true;
		   $datos['notificacion'] = 'Modificando los datos de la provincia ' . $id_provincia . ' ' . $descripcion;
		   
		   $datos['id_actual']    = $id_actual;
		   $datos['id_municipio']   = $id_municipio;
		   $datos['descripcion']  = $descripcion;
		   $datos['id_provincia'] = $id_provincia;
		   
		    //$datos['paises'] = $this->M_configuracion->obt_paises();
		}
		
		$this->load->view('lte_header', $datos);
 	    $this->load->view('v_municipio', $datos);
	    $this->load->view('lte_footer', $datos);
	}
	
	/********************************************************************************************************************/
	// Confirmar eliminación de un promunicipiovincia
	public function cfe_municipio($id_municipio, $id_provincia)
	{
		$datos['id_municipio'] = $id_municipio;
		$datos['id_provincia'] = $id_provincia;
		
		$this->load->view('lte_header', $datos);
 	    $this->load->view('vcan_municipio', $datos);
	    $this->load->view('lte_footer', $datos);
	}
	/********************************************************************************************************************/
	// Cancelar municipio
    public function cancelar_municipio()
	{
		$id_municipio = $this->input->post('id_municipio');
		$id_provincia = $this->input->post('id_provincia');
		$cancelado = $this->M_configuracion->cancelar_municipio($id_municipio);
		
		if ($cancelado == 1)
	    { 
		   $this->not_fcliente = "Se eliminó el municipio correctamente.";
		}
		else
		{
		   $this->not_fcliente = "ERROR. No se pudo eliminar el municipio. Verifique los datos especificados.";
		}
		
		$this->obt_municipios($id_provincia);

	}
	/********************************************************************************************************************/
	// Modificando un provincia
    public function modificar_municipio()
    {
		 $id_actual = $this->input->post('id_actual');
		 $id_municipio = $this->input->post('id_municipio');
		 $descripcion = $this->input->post('descripcion');
		 $id_provincia = $this->input->post('id_provincia');
		 		 
		 $this->load->library('form_validation');
		 
		 $this->form_validation->set_rules('descripcion', 'Descripción', 'required');
		 
		 if ($this->form_validation->run() == true )
		 {
		 
			 $modificado = $this->M_configuracion->modificar_municipio($id_actual, $id_municipio, $descripcion, $id_provincia);
			 
   		     if ($modificado == 1)
			 { 
				 $this->notificacion = "El municipio se modificó satisfactoriamente.";
		         $this->notificacion_error = false;
			 }
			 else
			 {
				 $this->notificacion = "ERROR. No se pudo modificar el municipio. Verifique los datos especificados.";
		         $this->notificacion_error = true;
		 }
				 
		 }
		 else
		 {
		     $this->notificacion = validation_errors();
			 $this->notificacion_error = true;
			 
		 }
		 if($this->notificacion_error == true){
			
			$datos['id_actual']    = $id_actual;
		    $datos['id_municipio']   = $id_municipio;
		    $datos['descripcion']  = $descripcion;
		    $datos['id_provincia'] = $id_provincia;

			$datos['notificacion'] = $this->notificacion ? $this->notificacion : "Error modificando el municipio " . $descripcion;
          	$datos['notificacion_error'] = $this->notificacion_error;
			$datos['modo_edicion'] = true;

			$this->load->view('lte_header', $datos);
			$this->load->view('v_municipio', $datos);
			$this->load->view('lte_footer', $datos);  
		 
		 }else
		 
		 $this->obt_municipios($id_provincia);
	}
	
	public function obt_tipo_factura($id_tipo_factura)
	{
		$color= $this->M_configuracion->tipo_factura($id_tipo_factura);
		$row = $color->row_array();
		echo json_encode($row); 
	}
	public function obt_empresa($id_empresa)
	{
		$empresa= $this->M_configuracion->obt_empresa($id_empresa);
		$row = $empresa->row_array();
		echo json_encode($row); 
	}
	public function obt_tipo_empresa($id_tipo_empresa)
	{
		$tipo_empresa= $this->M_configuracion->obt_tipo_empresa($id_tipo_empresa);
		$row = $tipo_empresa->row_array();
		echo json_encode($row); 
	}
	/********************************************************************************************************************/
	   //*******************************************************************************************************
	//     Gestion de costo de envio
	//*******************************************************************************************************
    // Interfaz para registrar un nuevo costo
	public function nuevo_costo()
	{		
		$datos['notificacion'] = $this->notificacion ? $this->notificacion : "Especifique los datos del nuevo costo:";
		$datos['notificacion_error'] = $this->notificacion_error;
		$datos['modo_edicion'] = false;
		
		$annos = $this->M_configuracion->obt_annos();
		$meses = $this->M_configuracion->obt_meses();
		
		$datos['annos']  	= $annos;
		   $datos['meses']  	= $meses;
		
		$this->load->view('lte_header', $datos);
		$this->load->view('v_costos', $datos);
		$this->load->view('lte_footer', $datos);	
	}
	/********************************************************************************************************************/
	// Editando la costo
	public function editar_costo($id_actual)
	{
		$resultado = $this->M_configuracion->obt_costo($id_actual);
		
		if ($resultado)
		{
		   $costo = $resultado->row();

		   $id_costo = $id_actual;
		   $anno = $costo->anno;
		   $mes = $costo->mes;
		   $costo = $costo->costo;
		   $annos = $this->M_configuracion->obt_annos();
		   $meses = $this->M_configuracion->obt_meses();
		   		   
		   $datos['modo_edicion'] = true;
		   $datos['notificacion'] = $this->notificacion ? $this->notificacion : "Modificando el costo";
           $datos['notificacion_error'] = $this->notificacion_error;		   
		   
		   $datos['id_actual']  = $id_actual;
		   $datos['id_costo']   = $id_costo;
		   $datos['anno']  		= $anno;
		   $datos['mes']  		= $mes;
		   $datos['costo']  	= $costo;
		   
           $datos['annos']  	= $annos;
		   $datos['meses']  	= $meses;
		   
		}
		
		$this->load->view('lte_header', $datos);
 	    $this->load->view('v_costos', $datos);
	    $this->load->view('lte_footer', $datos);
	}
	
	/********************************************************************************************************************/
	// Confirmar eliminación de un costo
	public function cfe_costo($id_costo)
	{
		$datos['id_costo'] = $id_costo;
		
		$this->load->view('lte_header', $datos);
 	    $this->load->view('vcan_costos', $datos);
	    $this->load->view('lte_footer', $datos);
	}
	/********************************************************************************************************************/
	// Cancelar costo
    public function cancelar_costo()
	{
		$id_costo = $this->input->post('id_costo');
		$cancelado = $this->M_configuracion->cancelar_costo($id_costo);
		
		if ($cancelado == 1)
	    { 
		   $this->not_fcliente = "Se eliminó el costo correctamente.";
		}
		else
		{
		   $this->not_fcliente = "ERROR. No se pudo eliminar el costo. Verifique los datos especificados.";
		}
		
		$this->obt_costos();

	}
	/********************************************************************************************************************/
	// Listado de costo
    public function obt_costos()
	{
		$costos 				= $this->M_configuracion->obt_costos();	
        $datos['costos'] 		= $costos;
		$datos['total_costos'] = $this->M_configuracion->total_costos();
        
		$this->load->view('lte_header', $datos);
		$this->load->view('v_listado_costo', $datos);
		$this->load->view('lte_footer', $datos);

	}
	
	
	/********************************************************************************************************************/
	// Registrando un costo
    public function registrar_costo()
    {
		 
		 $anno = $this->input->post('anno');
		 $mes = $this->input->post('mes');
		 $costo = $this->input->post('costo');
		 
		 $this->load->library('form_validation');
		 
		 $this->form_validation->set_rules('costo', 'Costo', 'required');
			
		 if ($this->form_validation->run() == true )
		 {
			 $registrado = $this->M_configuracion->registrar_costo($anno,$mes, $costo);
			 
			 $mensaje = "";
			 if ($registrado == 1)
				 { 
					$this->notificacion = "El nuevo costo se registró satisfactoriamente.";
		            $this->notificacion_error = false;
					 
				 }
				 else
				 {
					$this->notificacion = "ERROR. No se pudo registrar el nuevo costo.";
		            $this->notificacion_error = true;
		 }
				 
		 }
		 else
		 {
		     $this->notificacion = validation_errors();
			 $this->notificacion_error = true;
		 
		 }
		 if($this->notificacion_error == true){		
			
			$annos = $this->M_configuracion->obt_annos();
			$meses = $this->M_configuracion->obt_meses();
			
			$datos['annos']  	= $annos;
		    $datos['meses']  	= $meses;
			
			$datos['anno']  = $anno;
			$datos['mes']  	= $mes;
			$datos['costo'] = $costo;
			
			$datos['notificacion'] = $this->notificacion ? $this->notificacion : "Error registrando el nuevo costo.";
          	$datos['notificacion_error'] = $this->notificacion_error;
			$datos['modo_edicion'] = false;
			
			$this->load->view('lte_header', $datos);
			$this->load->view('v_costos', $datos);
			$this->load->view('lte_footer', $datos); 
		 
		 }else
			$this->obt_costos(); 
		 
    }
	/********************************************************************************************************************/
	// Modificando un costo
    public function modificar_costo()
    {
		 $id_actual = $this->input->post('id_actual');
		 $id_costo = $this->input->post('id_costo');
		 $anno = $this->input->post('anno');
		 $mes = $this->input->post('mes');
		 $costo = $this->input->post('costo');
		 		 
		 $this->load->library('form_validation');
		 
		 $this->form_validation->set_rules('costo', 'Costo', 'required');
		 
		 if (   $this->form_validation->run() == true)
		 {
		 
			 $modificado = $this->M_configuracion->modificar_costo($id_actual, $id_costo, $anno, $mes, $costo);
			 
   		     if ($modificado == 1)
			 { 
				 $this->notificacion = "El costo se modificó satisfactoriamente.";
		         $this->notificacion_error = false;
			 }
			 else
			 {
				 $this->notificacion = "ERROR. No se pudo modificar el costo. Verifique los datos especificados.";
		         $this->notificacion_error = true;
		 }
				 
		 }
		 else
		 {
		     $this->notificacion = validation_errors();
			 $this->notificacion_error = true;
			 
		 }
		 if($this->notificacion_error == true){		
			
			$annos = $this->M_configuracion->obt_annos();
			$meses = $this->M_configuracion->obt_meses();
			
			$datos['id_actual'] = $id_actual;
			$datos['id_costo']   = $id_costo;
			$datos['annos']  	= $annos;
		    $datos['meses']  	= $meses;
			
			$datos['anno']  = $anno;
			$datos['mes']  	= $mes;
			$datos['costo'] = $costo;
			
			$datos['notificacion'] = $this->notificacion ? $this->notificacion : "Error. No se pudo modificar el costo. Verifique los datos especificados.";
          	$datos['notificacion_error'] = $this->notificacion_error;
			$datos['modo_edicion'] = true;
			
			$this->load->view('lte_header', $datos);
			$this->load->view('v_costos', $datos);
			$this->load->view('lte_footer', $datos); 
		 
		 }else
		 
		 $this->obt_costos();
	}
	//*****************************************************************************************************
	public function obtener_provincia($id_actual)
	{
		$resultado = $this->M_configuracion->obt_provincia($id_actual);
		
		if ($resultado)
		{
		   $provincia = $resultado->row();
		  echo ($provincia->nombre);
		   
		}
	}
	public function obtener_municipio($id_actual)
	{ 
		$resultado = $this->M_configuracion->obt_municipio($id_actual);
		
		if ($resultado)
		{
		   $municipio = $resultado->row();
		  echo ($municipio->nombre_municipio);
		   
		}
	}
	public function obtener_canal($id_actual)
	{ 
		$resultado = $this->M_configuracion->obt_canal($id_actual);
		
		if ($resultado)
		{
		   $canal = $resultado->row();
		  echo ($canal->nombre);
		   
		}
	}
	/********************************************************************************************************************/
	/********************************************************************************************************************/
	   //*******************************************************************************************************
	//     Gestion de tipo de factura
	//*******************************************************************************************************
    // Interfaz para registrar un nuevo factura
	public function nuevo_factura()
	{		
		$datos['notificacion'] = "Especifique los datos de la nueva factura:";
		$datos['modo_edicion'] = false;
		$datos['notificacion_error'] = $this->notificacion_error;
						
		$this->load->view('lte_header', $datos);
		$this->load->view('v_facturas', $datos);
		$this->load->view('lte_footer', $datos);	
	}
	public function nuevo_factura_rev()
	{		
		$datos['notificacion'] = "Especifique los datos de la nueva factura:";
		$datos['modo_edicion'] = false;
		$datos['notificacion_error'] = $this->notificacion_error;
						
		$this->load->view('lte_header', $datos);
		$this->load->view('v_facturas_rev', $datos);
		$this->load->view('lte_footer', $datos);	
	}
	/********************************************************************************************************************/
	// Editando la factura
	public function editar_factura($id_actual)
	{
		$resultado = $this->M_configuracion->obt_factura($id_actual);
		
		if ($resultado)
		{
		   $factura = $resultado->row();

		   $id_factura = $id_actual;
		   $descripcion = $factura->nombre;
		     		   
		   $datos['modo_edicion'] = true;
		   $datos['notificacion'] = 'Modificando los datos de la factura ' . $id_factura . ' ' . $descripcion;
		   $datos['notificacion_error'] = $this->notificacion_error;
		   
		   $datos['id_actual']  	= $id_actual;
		   $datos['id_factura']   	= $id_factura;
		   $datos['descripcion']  	= $descripcion;
		   		   
		}
		
		$this->load->view('lte_header', $datos);
 	    $this->load->view('v_facturas', $datos);
	    $this->load->view('lte_footer', $datos);
	}
	
	/********************************************************************************************************************/
	// Confirmar eliminación de un factura
	public function cfe_factura($id_factura)
	{
		$datos['id_factura'] = $id_factura;
		
		$this->load->view('lte_header', $datos);
 	    $this->load->view('vcan_facturas', $datos);
	    $this->load->view('lte_footer', $datos);
	}
	/********************************************************************************************************************/
	// Cancelar factura
    public function cancelar_factura()
	{
		$id_factura = $this->input->post('id_factura');
		$cancelado = $this->M_configuracion->cancelar_factura($id_factura);
		
		if ($cancelado == 1)
	    { 
		   $this->not_fcliente = "Se eliminó la factura correctamente.";
		}
		else
		{
		   $this->not_fcliente = "ERROR. No se pudo eliminar la factura. Verifique los datos especificados.";
		}
		
		$this->obt_facturas();

	}
	// Editando la factura
	public function editar_factura_rev($id_actual)
	{
		$resultado = $this->M_configuracion->obt_factura_rev($id_actual);
		
		if ($resultado)
		{
		   $factura = $resultado->row();

		   $id_factura = $id_actual;
		   $descripcion = $factura->nombre;
		     		   
		   $datos['modo_edicion'] = true;
		   $datos['notificacion'] = 'Modificando los datos de la factura ' . $id_factura . ' ' . $descripcion;
		   $datos['notificacion_error'] = $this->notificacion_error;
		   
		   $datos['id_actual']  	= $id_actual;
		   $datos['id_factura']   	= $id_factura;
		   $datos['descripcion']  	= $descripcion;
		   		   
		}
		
		$this->load->view('lte_header', $datos);
 	    $this->load->view('v_facturas_rev', $datos);
	    $this->load->view('lte_footer', $datos);
	}
	
	/********************************************************************************************************************/
	// Confirmar eliminación de un factura
	public function cfe_factura_rev($id_factura)
	{
		$datos['id_factura'] = $id_factura;
		
		$this->load->view('lte_header', $datos);
 	    $this->load->view('vcan_facturas_rev', $datos);
	    $this->load->view('lte_footer', $datos);
	}
	/********************************************************************************************************************/
	// Cancelar factura
    public function cancelar_factura_rev()
	{
		$id_factura = $this->input->post('id_factura');
		$cancelado = $this->M_configuracion->cancelar_factura_rev($id_factura);
		
		if ($cancelado == 1)
	    { 
		   $this->not_fcliente = "Se eliminó la factura correctamente.";
		}
		else
		{
		   $this->not_fcliente = "ERROR. No se pudo eliminar la factura. Verifique los datos especificados.";
		}
		
		redirect('facturas_rev');

	}
	/********************************************************************************************************************/
	// Listado de factura
    public function obt_facturas()
	{
		$facturas 				= $this->M_configuracion->obt_facturas();	
        $datos['facturas'] 		= $facturas;
		$datos['total_facturas'] = $this->M_configuracion->total_facturas();
        
		$this->load->view('lte_header', $datos);
		$this->load->view('v_listado_facturas', $datos);
		$this->load->view('lte_footer', $datos);

	}
	
	
	/********************************************************************************************************************/
	// Registrando un factura
    public function registrar_factura()
    {
		 
		 $descripcion = $this->input->post('descripcion');
		 	 
		 $this->load->library('form_validation');
		 
		 $this->form_validation->set_rules('descripcion', 'Descripción', 'required');		 
		 
		 if ($descripcion != ''  )
		 {		 
			
			 $registrado = $this->M_configuracion->registrar_factura($descripcion);
			 
			 $mensaje = "";
			 if ($registrado == 1)
				 { 
					 $this->notificacion = "La factura se registró satisfactoriamente.";
		             $this->notificacion_error = false;
				 }
				 else
				 {
					 $this->notificacion = "ERROR. No se pudo registrar la factura.";
		             $this->notificacion_error = true;
				 }
				 
		 }
		 else
		 {
		     $this->notificacion = validation_errors();
			 $this->notificacion_error = true;
			 
		 }
		 if($this->notificacion_error == true){			
			
		    $datos['descripcion']  	= $descripcion;
		   
			$datos['notificacion'] = $this->notificacion ? $this->notificacion : "Error registrando la factura " . $descripcion;
          	$datos['notificacion_error'] = $this->notificacion_error;
			$datos['modo_edicion'] = false;

			$this->load->view('lte_header', $datos);
			$this->load->view('v_facturas', $datos);
			$this->load->view('lte_footer', $datos);  
		 
		 }else
		 $this->obt_facturas();
		 
		 
    }
    public function registrar_factura_rev()
    {
		 
		 $descripcion = $this->input->post('descripcion');
		 	 
		 $this->load->library('form_validation');
		 
		 $this->form_validation->set_rules('descripcion', 'Descripción', 'required');		 
		 
		 if ($descripcion != ''  )
		 {		 
			
			 $registrado = $this->M_configuracion->registrar_factura_rev($descripcion);
			 
			 $mensaje = "";
			 if ($registrado == 1)
				 { 
					 $this->notificacion = "La factura se registró satisfactoriamente.";
		             $this->notificacion_error = false;
				 }
				 else
				 {
					 $this->notificacion = "ERROR. No se pudo registrar la factura.";
		             $this->notificacion_error = true;
				 }
				 
		 }
		 else
		 {
		     $this->notificacion = validation_errors();
			 $this->notificacion_error = true;
			 
		 }
		 if($this->notificacion_error == true){			
			
		    $datos['descripcion']  	= $descripcion;
		   
			$datos['notificacion'] = $this->notificacion ? $this->notificacion : "Error registrando la factura " . $descripcion;
          	$datos['notificacion_error'] = $this->notificacion_error;
			$datos['modo_edicion'] = false;

			$this->load->view('lte_header', $datos);
			$this->load->view('v_facturas_rev', $datos);
			$this->load->view('lte_footer', $datos);  
		 
		 }else
		 	redirect('facturas_rev');
		 
		 
    }
	/********************************************************************************************************************/
	// Modificando un factura
    public function modificar_factura()
    {
		 $id_actual = $this->input->post('id_actual');
		 $id_factura = $this->input->post('id_factura');
		 $descripcion = $this->input->post('descripcion');
		 		 		 
		 $this->load->library('form_validation');
		 
		 $this->form_validation->set_rules('descripcion', 'Descripción', 'required');
		
		if (   $this->form_validation->run() == true)
		 {
			 $modificado = $this->M_configuracion->modificar_factura($id_actual, $id_factura, $descripcion);
			 
   		     if ($modificado == 1)
			 { 
				 $this->notificacion = "al factura se modificó satisfactoriamente.";
		         $this->notificacion_error = false;
			 }
			 else
			 {
				 $this->notificacion = "ERROR. No se pudo modificar la factura. Verifique los datos especificados.";
		         $this->notificacion_error = true;
		 }
		 }	
		 else
		 {
		      $this->notificacion = validation_errors();
			  $this->notificacion_error = true;
		 
		 }
		 if($this->notificacion_error == true){
			
			$datos['id_actual']  	= $id_actual;
		    $datos['id_factura']   	= $id_factura;
		    $datos['descripcion']  	= $descripcion;
		   
			$datos['notificacion'] = $this->notificacion ? $this->notificacion : "Error modificando la factura " . $descripcion;
          	$datos['notificacion_error'] = $this->notificacion_error;
			$datos['modo_edicion'] = true;

			$this->load->view('lte_header', $datos);
			$this->load->view('v_facturas', $datos);
			$this->load->view('lte_footer', $datos);  
		 }else
		 $this->obt_facturas();
	}
    public function modificar_factura_rev()
    {
		 $id_actual = $this->input->post('id_actual');
		 $id_factura = $this->input->post('id_factura');
		 $descripcion = $this->input->post('descripcion');
		 		 		 
		 $this->load->library('form_validation');
		 
		 $this->form_validation->set_rules('descripcion', 'Descripción', 'required');
		
		if (   $this->form_validation->run() == true)
		 {
			 $modificado = $this->M_configuracion->modificar_factura_rev($id_actual, $id_factura, $descripcion);
			 
   		     if ($modificado == 1)
			 { 
				 $this->notificacion = "al factura se modificó satisfactoriamente.";
		         $this->notificacion_error = false;
			 }
			 else
			 {
				 $this->notificacion = "ERROR. No se pudo modificar la factura. Verifique los datos especificados.";
		         $this->notificacion_error = true;
		 }
		 }	
		 else
		 {
		      $this->notificacion = validation_errors();
			  $this->notificacion_error = true;
		 
		 }
		 if($this->notificacion_error == true){
			
			$datos['id_actual']  	= $id_actual;
		    $datos['id_factura']   	= $id_factura;
		    $datos['descripcion']  	= $descripcion;
		   
			$datos['notificacion'] = $this->notificacion ? $this->notificacion : "Error modificando la factura " . $descripcion;
          	$datos['notificacion_error'] = $this->notificacion_error;
			$datos['modo_edicion'] = true;

			$this->load->view('lte_header', $datos);
			$this->load->view('v_facturas', $datos);
			$this->load->view('lte_footer', $datos);  
		 }else		
		 	redirect('facturas_rev');
	}
	//*****************************************************************************************************	
	/********************************************************************************************************************/
	//*******************************************************************************************************
	//     Gestion de objetivos
	//*******************************************************************************************************
    // Interfaz para registrar un nuevo objetivo
	public function nuevo_objetivo()
	{		
		$datos['notificacion'] = "Especifique los datos del nuevo objetivo:";
		$datos['modo_edicion'] = false;
		$datos['notificacion_error'] = $this->notificacion_error;
		// Buscar el usuario actual
		$user = $this->ion_auth->user()->row();
		$usuario_act= $user->id;
		
		$annos 			= $this->M_configuracion->obt_annos();
		$meses 			= $this->M_configuracion->obt_meses();
		$consultores 	= $this->M_configuracion->obt_consultores($usuario_act);
		$tipo_objetivos = $this->M_configuracion->obt_tipo_objetivos();
		
		$datos['annos']  		= $annos;
		$datos['meses']  		= $meses;
		$datos['consultores']  	= $consultores;
		$datos['tipo_objetivos']= $tipo_objetivos;
		
		if (!$tipo_objetivos->row() || !$consultores->row())
	    {			
			$this->notificacion = 'Debe revisar los siguientes parámetros antes de realizar esta operación </br>';
			if (!$tipo_objetivos->row()){			
				$this->notificacion = $this->notificacion .' Tipo de objetivo </br>';		
			}

			if (!$consultores->row()){			
				$this->notificacion = $this->notificacion .' Subordinado </br>';		
			}
			
			
			$this->notificacion_error == true;
			
		}else{
			
			$this->notificacion = 'Especifique los datos del nuevo objetivo.';
			$this->notificacion_error == false;
		} 
		$datos['notificacion']  = $this->notificacion;
		$datos['notificacion_error'] = $this->notificacion_error;
		$this->load->view('lte_header', $datos);
		$this->load->view('v_objetivos', $datos);
		$this->load->view('lte_footer', $datos);	
	}
	/********************************************************************************************************************/
	// Editando la objetivo
	public function editar_objetivo($id_actual)
	{
		$resultado = $this->M_configuracion->obt_objetivo($id_actual);
		
		if ($resultado)
		{
		   $objetivos = $resultado->row();

		   $id_objetivo 	= $id_actual;
		   $objetivo 		= $objetivos->objetivo;
		   $anno 			= $objetivos->anno;
		   $mes 			= $objetivos->mes;
		   $id_consultor 	= $objetivos->id_consultor;
		   $id_tipo_objetivo= $objetivos->id_tipo_objetivo;
		   $fecha_asignacion= $objetivos->fecha_asignacion;

		   $user = $this->ion_auth->user()->row();
		   $usuario_act= $user->id;
		   $annos = $this->M_configuracion->obt_annos();
		   $meses = $this->M_configuracion->obt_meses();
		   $consultores = $this->M_configuracion->obt_consultores($usuario_act);
		   $tipo_objetivos = $this->M_configuracion->obt_tipo_objetivos();
		   		   
		   $datos['modo_edicion'] = true;
		   $datos['notificacion_error'] = $this->notificacion_error;
		   $datos['notificacion'] = 'Modificando los datos del objetivo ' . $id_objetivo ;
		   
		   $datos['id_actual']  		= $id_actual;
		   $datos['id_objetivo']   		= $id_objetivo;
		   $datos['objetivo']   		= $objetivo;
		   $datos['anno']  				= $anno;
		   $datos['mes']  				= $mes;
		   $datos['fecha_asignacion']  	= $fecha_asignacion;
		   $datos['id_consultor']  		= $id_consultor;
		   $datos['id_tipo_objetivo']  	= $id_tipo_objetivo;
		   $datos['consultores']  		= $consultores;
		   $datos['tipo_objetivos']  	= $tipo_objetivos;
		   
           $datos['annos']  = $annos;
		   $datos['meses']  = $meses;
		   
		}
		
		$this->load->view('lte_header', $datos);
 	    $this->load->view('v_objetivos', $datos);
	    $this->load->view('lte_footer', $datos);
	}
	
	/********************************************************************************************************************/
	// Confirmar eliminación de un objetivo
	public function cfe_objetivo($id_objetivo)
	{
		$datos['id_objetivo'] = $id_objetivo;
		
		$this->load->view('lte_header', $datos);
 	    $this->load->view('vcan_objetivos', $datos);
	    $this->load->view('lte_footer', $datos);
	}
	/********************************************************************************************************************/
	// Cancelar objetivo
    public function cancelar_objetivo()
	{
		$id_objetivo = $this->input->post('id_objetivo');
		$cancelado = $this->M_configuracion->cancelar_objetivo($id_objetivo);
		
		if ($cancelado == 1)
	    { 
		   $this->not_fcliente = "Se eliminó el objetivo correctamente.";
		}
		else
		{
		   $this->not_fcliente = "ERROR. No se pudo eliminar el objetivo. Verifique los datos especificados.";
		}
		
		$this->obt_objetivos();

	}
	/********************************************************************************************************************/
	// Listado de objetivo
    public function obt_objetivos()
	{
		// Buscar el usuario actual
		$user = $this->ion_auth->user()->row();
		$usuario_act= $user->id;
		$mis_objetivos 				= $this->M_configuracion->obt_mis_objetivos($usuario_act);	
		$objetivos 					= $this->M_configuracion->obt_objetivos($usuario_act);	
		$datos['consultores'] = $this->M_configuracion->usuarios_consultores();
		$contador = 0;
		$objetivo = array();
		
		foreach ($mis_objetivos->result() as $pr){
			$objetivo[$contador] = 0;			
			foreach ($objetivos->result() as $ob){
				$mes = $pr->mes;
				$anno = $pr->anno;
				$tipo = $pr->tipo;	
				
				$mes1 = $ob->mes;
				$anno1 = $ob->anno;
				$tipo1 = $ob->tipo;
				
				if($mes==$mes1 && $anno==$anno1 && $tipo==$tipo1){
					
					$objetivo[$contador] = $objetivo[$contador] + $ob->objetivo;				
					
				}			
			}
			
			$contador = $contador + 1;
			
		}

		
        $datos['mis_objetivos'] 	= $mis_objetivos;
		$datos['objetivos'] 		= $objetivos;
		$datos['objetivos_asignados'] = $objetivo;
		$datos['total_objetivos'] 	= $this->M_configuracion->total_objetivos();
        
		$this->load->view('lte_header', $datos);
		$this->load->view('v_listado_objetivos', $datos);
		$this->load->view('lte_footer', $datos);

	}
	
	
	/********************************************************************************************************************/
	// Registrando un objetivo
    public function registrar_objetivo()
    {
		 
		 $anno 				= $this->input->post('anno');
		 $mes 				= $this->input->post('mes');
		 $objetivo 			= $this->input->post('objetivo');
		 $id_objetivo 		= $this->input->post('id_objetivo');
		 $fecha_asignacion 	= $this->input->post('fecha_asignacion');
		 $id_consultor 		= $this->input->post('id_consultor');
		 $id_tipo_objetivo 	= $this->input->post('id_tipo_objetivo');
		 
		 $this->load->library('form_validation');
		 
		 $this->form_validation->set_rules('objetivo', 'Objetivo', 'required');
	 	 $this->form_validation->set_rules('id_tipo_objetivo', 'Tipo de Objetivo', 'required');
		 $this->form_validation->set_rules('id_consultor', 'Subordinado', 'required');
	
		 if ($this->form_validation->run() == true )
		 {		 
			
			 $registrado = $this->M_configuracion->registrar_objetivo($id_consultor, $id_tipo_objetivo, $objetivo, $fecha_asignacion, $mes, $anno);
			 
			 $mensaje = "";
			 if ($registrado == 1)
				 { 
					 $this->notificacion = "Se ha registrado un nuevo objetivo.";
		             $this->notificacion_error = false;
				 }
				 else
				 {
					 $this->notificacion = "ERROR. No se pudo registrar el objetivo.";
		             $this->notificacion_error = true;
				 }
				 
		 }
		 else
		 {
		     $this->notificacion = validation_errors();
			 $this->notificacion_error = true;
			 
		 }
		 if($this->notificacion_error == true){	   
		              		   
		$tipo_objetivos = $this->M_configuracion->obt_tipo_objetivos();
			$datos['notificacion'] = $this->notificacion ? $this->notificacion : "Error registrando el objetivo " . $objetivo;
          	$datos['notificacion_error'] = $this->notificacion_error;
			$datos['modo_edicion'] = false;

			$user = $this->ion_auth->user()->row();
		    $usuario_act= $user->id;
			$annos = $this->M_configuracion->obt_annos();
			$meses = $this->M_configuracion->obt_meses();
			$consultores = $this->M_configuracion->obt_consultores($usuario_act);
		
			$datos['annos']  			= $annos;
			$datos['meses']  			= $meses;
			
		    $datos['anno']  			= $anno;
		    $datos['mes']  				= $mes;
		    $datos['fecha_asignacion']  = $fecha_asignacion;
		    $datos['id_consultor']  	= $id_consultor;
			$datos['id_tipo_objetivo']  = $id_tipo_objetivo;
			$datos['consultores']  		= $consultores;
	                $datos['id_objetivo']		= $id_objetivo;
			$datos['objetivo']  		= $objetivo;			
			$datos['tipo_objetivos']  	= $tipo_objetivos;
		
		
			$this->load->view('lte_header', $datos);
			$this->load->view('v_objetivos', $datos);
			$this->load->view('lte_footer', $datos); 
		 }else
		 $this->obt_objetivos();
		 
		 
    }
	/********************************************************************************************************************/
	// Modificando un objetivo
    public function modificar_objetivo()
    {
		 $id_actual 		= $this->input->post('id_actual');
		 $id_objetivo 		= $this->input->post('id_objetivo');
		 $anno 				= $this->input->post('anno');
		 $mes 				= $this->input->post('mes');
		 $objetivo 			= $this->input->post('objetivo');
		 $fecha_asignacion 	= $this->input->post('fecha_asignacion');
		 $id_consultor 		= $this->input->post('id_consultor');
		 $id_tipo_objetivo 	= $this->input->post('id_tipo_objetivo');
		 		 
		 $this->load->library('form_validation');
		 
		 $this->form_validation->set_rules('objetivo', 'Objetivo', 'required');
		 if ($this->form_validation->run() == true )
		 {
		 
			 $modificado = $this->M_configuracion->modificar_objetivo($id_actual, $id_objetivo, $id_consultor, $id_tipo_objetivo, $objetivo, $fecha_asignacion, $mes, $anno);
			 
   		     if ($modificado == 1)
			 { 
				 $this->notificacion = "El objetivo se modificó satisfactoriamente.";
		         $this->notificacion_error = false;
			 }
			 else
			 {
				 $this->notificacion = "ERROR. No se pudo modificar el objetivo. Verifique los datos especificados.";
		         $this->notificacion_error = true;
			 }
				 
		 }
		 else
		 {
		     $this->notificacion = validation_errors();
			 $this->notificacion_error = true;
			 
		 }
		 if($this->notificacion_error == true){
			 
			$datos['notificacion'] = $this->notificacion ? $this->notificacion : "Error registrando el objetivo " . $objetivo;
          	$datos['notificacion_error'] = $this->notificacion_error;
			$datos['modo_edicion'] = true;
			$user = $this->ion_auth->user()->row();
		    $usuario_act= $user->id;
			$annos = $this->M_configuracion->obt_annos();
			$meses = $this->M_configuracion->obt_meses();
			$consultores = $this->M_configuracion->obt_consultores($usuario_act);
			$tipo_objetivos = $this->M_configuracion->obt_tipo_objetivos();
		
			$datos['id_actual'] 		= $id_actual;
		    $datos['id_objetivo']		= $id_objetivo;
			$datos['objetivo']  		= $objetivo;
			$datos['annos']  			= $annos;
			$datos['meses']  			= $meses;	
		    $datos['anno']  			= $anno;
		    $datos['mes']  				= $mes;
		    $datos['fecha_asignacion']	= $fecha_asignacion;
		    $datos['id_consultor']  	= $id_consultor;
			$datos['id_tipo_objetivo']  = $id_tipo_objetivo;
			$datos['consultores']  		= $consultores;
			$datos['tipo_objetivos']  	= $tipo_objetivos;
		
			$this->load->view('lte_header', $datos);
			$this->load->view('v_objetivos', $datos);
			$this->load->view('lte_footer', $datos);
			 
			 
		 }else		 
		 $this->obt_objetivos();
	}
	
	/********************************************************************************************************************/
		/********************************************************************************************************************/
	   //*******************************************************************************************************
	//     Gestion de iva
	//*******************************************************************************************************
    // Interfaz para registrar un nuevo iva
	public function nuevo_iva()
	{		
		$datos['notificacion'] = "Especifique los datos del nuevo iva:";
		$datos['modo_edicion'] = false;
		
		$annos = $this->M_configuracion->obt_annos();
		$meses = $this->M_configuracion->obt_meses();
		
		$datos['annos']  	= $annos;
		   $datos['meses']  	= $meses;
		
		$this->load->view('lte_header', $datos);
		$this->load->view('v_ivas', $datos);
		$this->load->view('lte_footer', $datos);	
	}
	/********************************************************************************************************************/
	// Editando la iva
	public function editar_iva($id_actual)
	{
		$resultado = $this->M_configuracion->obt_iva($id_actual);
		
		if ($resultado)
		{
		   $iva = $resultado->row();

		   $id_iva = $id_actual;
		   $anno = $iva->anno;
		   $mes = $iva->mes;
		   $iva = $iva->iva;
		   $annos = $this->M_configuracion->obt_annos();
		   $meses = $this->M_configuracion->obt_meses();
		   		   
		   $datos['modo_edicion'] = true;
		   $datos['notificacion'] = 'Modificando los datos del iva ' . $id_iva . ' ' . $anno;
		   
		   $datos['id_actual']  = $id_actual;
		   $datos['id_iva']   	= $id_iva;
		   $datos['anno']  		= $anno;
		   $datos['mes']  		= $mes;
		   $datos['iva']  		= $iva;
		   
           $datos['annos']  	= $annos;
		   $datos['meses']  	= $meses;
		   
		}
		
		$this->load->view('lte_header', $datos);
 	    $this->load->view('v_ivas', $datos);
	    $this->load->view('lte_footer', $datos);
	}
	
	/********************************************************************************************************************/
	// Confirmar eliminación de un iva
	public function cfe_iva($id_iva)
	{
		$datos['id_iva'] = $id_iva;
		
		$this->load->view('lte_header', $datos);
 	    $this->load->view('vcan_ivas', $datos);
	    $this->load->view('lte_footer', $datos);
	}
	/********************************************************************************************************************/
	// Cancelar iva
    public function cancelar_iva()
	{
		$id_iva = $this->input->post('id_iva');
		$cancelado = $this->M_configuracion->cancelar_iva($id_iva);
		
		if ($cancelado == 1)
	    { 
		   $this->not_fcliente = "Se eliminó el iva correctamente.";
		}
		else
		{
		   $this->not_fcliente = "ERROR. No se pudo eliminar el coivasto. Verifique los datos especificados.";
		}
		
		$this->obt_ivas();

	}
	/********************************************************************************************************************/
	// Listado de iva
    public function obt_ivas()
	{
		$ivas 				= $this->M_configuracion->obt_ivas();	
        $datos['ivas'] 		= $ivas;
		$datos['total_ivas'] = $this->M_configuracion->total_ivas();
        
		$this->load->view('lte_header', $datos);
		$this->load->view('v_listado_iva', $datos);
		$this->load->view('lte_footer', $datos);

	}
	
	
	/********************************************************************************************************************/
	// Registrando un iva
    public function registrar_iva()
    {
		 
		 $anno = $this->input->post('anno');
		 $mes = $this->input->post('mes');
		 $iva = $this->input->post('iva');
		 
		 
		 if ($anno != ''  )
		 {		 
			
			 $registrado = $this->M_configuracion->registrar_iva($anno,$mes, $iva);
			 
			 $mensaje = "";
			 if ($registrado == 1)
				 { 
					 $this->not_fcliente = "Se ha registrado un nuevo iva.";
					 
				 }
				 else
				 {
					 $this->not_fcliente = "ERROR. No se pudo registrar el iva. Verifique los datos especificados.";
				 }
				 
		 }
		 else
		 {
		     $this->not_fcliente = "ERROR. No se pudo registrar el iva. Verifique los datos especificados.";
			 
		 }
		 $this->obt_ivas();
		 
		 
    }
	/********************************************************************************************************************/
	// Modificando un iva
    public function modificar_iva()
    {
		 $id_actual = $this->input->post('id_actual');
		 $id_iva = $this->input->post('id_iva');
		 $anno = $this->input->post('anno');
		 $mes = $this->input->post('mes');
		 $iva = $this->input->post('iva');
		 		 
		 if ($id_iva != '' && $anno != '')
		 {
		 
			 $modificado = $this->M_configuracion->modificar_iva($id_actual, $id_iva, $anno, $mes, $iva);
			 
   		     if ($modificado == 1)
			 { 
				 $this->not_fcliente = "Se ha registrado un nuevo iva.";
			 }
			 else
			 {
				 $this->not_fcliente = "ERROR. No se pudo modificar el iva. Verifique los datos especificados.";
			 }
				 
		 }
		 else
		 {
		     $this->not_fcliente = "ERROR. No se pudo modificar el iva. Verifique los datos especificados.";
			 
		 }
		 
		 $this->obt_ivas();
	}
	//*****************************************************************************************************
	public function hallazgos()
	{
		$hallazgos = $this->M_configuracion->obt_hallazgos();	
        $datos['hallazgos'] = $hallazgos;
		$datos['total_hallazgos'] = $this->M_configuracion->total_hallazgos();
        
		$this->load->view('lte_header', $datos);
		$this->load->view('v_listado_hallazgos', $datos);
		$this->load->view('lte_footer', $datos);

	}
	//*****************************************************************************************************	
	/********************************************************************************************************************/
	//*******************************************************************************************************
	//     Gestion de canales
	//*******************************************************************************************************
    // Interfaz para registrar un nuevo objetivo
	public function nuevo_canal()
	{		
		$datos['notificacion'] = "Especifique los datos del nuevo canal:";
		$datos['modo_edicion'] = false;
		$datos['notificacion_error'] = $this->notificacion_error;
		$canales_principales = $this->M_configuracion->obt_canales_principal();
		$datos['canales_principales']= $canales_principales;
		
		$this->load->view('lte_header', $datos);
		$this->load->view('v_canales', $datos);
		$this->load->view('lte_footer', $datos);	
	}
	/********************************************************************************************************************/
	// Editando la canal
	public function editar_canal($id_actual)
	{
		$resultado = $this->M_configuracion->obt_canal($id_actual);
		$canales_principales = $this->M_configuracion->obt_canales_principal();
		if ($resultado)
		{
		   $canales = $resultado->row();

		   $id_canal 		= $id_actual;
		   $descripcion 	= $canales->nombre;	
		   $principal 		= $canales->id_principal;	   
		   		   		   
		   $datos['modo_edicion'] = true;
		   $datos['notificacion_error'] = $this->notificacion_error;
		   $datos['notificacion'] = 'Modificando los datos del canal ' . $id_canal ;
		   
		   $datos['id_actual']  		= $id_actual;
		   $datos['id_canal']   		= $id_canal;
		   $datos['descripcion']   		= $descripcion;
		   $datos['principal']   		= $principal;
		   $datos['canales_principales']= $canales_principales;		   
        		   
		}
		
		$this->load->view('lte_header', $datos);
 	    $this->load->view('v_canales', $datos);
	    $this->load->view('lte_footer', $datos);
	}
	
	/********************************************************************************************************************/
	// Confirmar eliminación de un canal
	public function cfe_canal($id_canal)
	{
		$datos['id_canal'] = $id_canal;
		
		$this->load->view('lte_header', $datos);
 	    $this->load->view('vcan_canales', $datos);
	    $this->load->view('lte_footer', $datos);
	}
	/********************************************************************************************************************/
	// Cancelar canal
    public function cancelar_canal()
	{
		$id_canal = $this->input->post('id_canal');
		$cancelado = $this->M_configuracion->cancelar_canal($id_canal);
		
		if ($cancelado == 1)
	    { 
		   $this->not_fcliente = "Se eliminó el canal correctamente.";
		}
		else
		{
		   $this->not_fcliente = "ERROR. No se pudo eliminar el canal. Verifique los datos especificados.";
		}
		
		$this->obt_canales();

	}
	/********************************************************************************************************************/
	// Listado de canal
    public function obt_canales()
	{
		$canales 					= $this->M_configuracion->obt_canales();	
        $datos['canales'] 			= $canales;
		$datos['total_canales'] 	= $this->M_configuracion->total_canales();
        
		$this->load->view('lte_header', $datos);
		$this->load->view('v_listado_canal', $datos);
		$this->load->view('lte_footer', $datos);

	}
	
	
	/********************************************************************************************************************/
	// Registrando un canal
    public function registrar_canal()
    {
		 
		 $descripcion 			= $this->input->post('descripcion');
		 $principal 			= $this->input->post('principal');
		 		 
		 $this->load->library('form_validation');
		 
		 $this->form_validation->set_rules('descripcion', 'Descripcion', 'required');
		 if ($this->form_validation->run() == true )
		 {		 
			
			 $registrado = $this->M_configuracion->registrar_canal( $descripcion,$principal );
			 
			 $mensaje = "";
			 if ($registrado == 1)
				 { 
					 $this->notificacion = "Se ha registrado un nuevo canal.";
		             $this->notificacion_error = false;
				 }
				 else
				 {
					 $this->notificacion = "ERROR. No se pudo registrar el canal.";
		             $this->notificacion_error = true;
				 }
				 
		 }
		 else
		 {
		     $this->notificacion = validation_errors();
			 $this->notificacion_error = true;
			 
		 }
		 if($this->notificacion_error == true){	   
		              		   
			$datos['notificacion'] = $this->notificacion ? $this->notificacion : "Error registrando el canal " . $canal;
          	$datos['notificacion_error'] = $this->notificacion_error;
			$datos['modo_edicion'] = false;
						
			$principal 		= $canales->id_principal;
		    $datos['descripcion']  			= $descripcion;
		   		
			$this->load->view('lte_header', $datos);
			$this->load->view('v_canales', $datos);
			$this->load->view('lte_footer', $datos); 
		 }else
		 $this->obt_canales();
		 
		 
    }
	/********************************************************************************************************************/
	// Modificando un canal
    public function modificar_canal()
    {
		 $id_actual 		= $this->input->post('id_actual');
		 $id_canal 			= $this->input->post('id_canal');
		 $descripcion 			= $this->input->post('descripcion');
		 $principal 			= $this->input->post('principal');
		 
		 $this->load->library('form_validation');
		 
		 $this->form_validation->set_rules('descripcion', 'Descripcion', 'required');
		 if ($this->form_validation->run() == true )
		 {
		 
			 $modificado = $this->M_configuracion->modificar_canal($id_actual, $id_canal, $descripcion, $principal);
			 
   		     if ($modificado == 1)
			 { 
				 $this->notificacion = "El canal se modificó satisfactoriamente.";
		         $this->notificacion_error = false;
			 }
			 else
			 {
				 $this->notificacion = "ERROR. No se pudo modificar el canal. Verifique los datos especificados.";
		         $this->notificacion_error = true;
			 }
				 
		 }
		 else
		 {
		     $this->notificacion = validation_errors();
			 $this->notificacion_error = true;
			 
		 }
		 if($this->notificacion_error == true){
			 
			$datos['notificacion'] = $this->notificacion ? $this->notificacion : "Error registrando el canal " . $canal;
          	$datos['notificacion_error'] = $this->notificacion_error;
			$datos['modo_edicion'] = true;

					
			$datos['id_actual'] 		= $id_actual;
		    $datos['id_canal']			= $id_canal;
			$datos['descripcion']  		= $descripcion;
			$datos['principal']  		= $principal;
			$canales_principales = $this->M_configuracion->obt_canales_principal();
			$datos['canales_principales']= $canales_principales;	
					
			$this->load->view('lte_header', $datos);
			$this->load->view('v_canales', $datos);
			$this->load->view('lte_footer', $datos);
			 
			 
		 }else		 
		 $this->obt_canales();
	}
	/********************************************************************************************************************/
	//*******************************************************************************************************
	//     Gestion de Usuarios
	//*******************************************************************************************************
   
	/********************************************************************************************************************/
	// Editando la usuario
	public function editar_usuario($id_actual)
	{
		$resultado = $this->M_configuracion->obt_usuario($id_actual);
		
		if ($resultado)
		{
		   $usuarios = $resultado->row();

		   $id_usuario 		= $id_actual;
		   $nombre 	= $usuarios->nombre;
		   $apellidos 	= $usuarios->nombre;
		   $empresa 	= $usuarios->nombre;
		   $email 	= $usuarios->nombre;		   
		   		   		   
		   $datos['modo_edicion'] = true;
		   $datos['notificacion_error'] = $this->notificacion_error;
		   $datos['notificacion'] = 'Modificando los datos del canal ' . $id_usuario ;
		   
		   $datos['id_actual']  		= $id_actual;
		   $datos['id_usuario']   		= $id_usuario;
		   $datos['descripcion']   		= $descripcion;
		   		   
        		   
		}
		
		$this->load->view('lte_header', $datos);
 	    $this->load->view('v_usuarios', $datos);
	    $this->load->view('lte_footer', $datos);
	}
	
	/********************************************************************************************************************/
	// Confirmar eliminación de un usuario
	public function cfe_usuario($id_usuario)
	{
		$datos['id_usuario'] = $id_usuario;
		
		$this->load->view('lte_header', $datos);
 	    $this->load->view('vcan_usuarios', $datos);
	    $this->load->view('lte_footer', $datos);
	}
	/********************************************************************************************************************/
	// Cancelar canal
    public function cancelar_usuario()
	{
		$id_usuario = $this->input->post('id_usuario');
		$cancelado = $this->M_configuracion->cancelar_usuario($id_usuario);
		
		if ($cancelado == 1)
	    { 
		   $this->not_fcliente = "Se eliminó el usuario correctamente.";
		}
		else
		{
		   $this->not_fcliente = "ERROR. No se pudo eliminar el usuario. Verifique los datos especificados.";
		}
		
		$this->obt_usuarios();

	}
	/********************************************************************************************************************/
	// Listado de canal
    public function obt_usuarios()
	{
		$canales 					= $this->M_configuracion->obt_usuarios();	
        $datos['usuarios'] 			= $usuarios;
		$datos['total_usuarios'] 	= $this->M_configuracion->total_usuarios();
        
		$this->load->view('lte_header', $datos);
		$this->load->view('v_listado_usuario', $datos);
		$this->load->view('lte_footer', $datos);

	}
	
	
	/********************************************************************************************************************/

	/********************************************************************************************************************/
	// Modificando un usuario
    public function modificar_usuario()
    {
		 $id_actual 		= $this->input->post('id_actual');
		 $id_usuario 			= $this->input->post('id_usuario');
		 $descripcion 			= $this->input->post('descripcion');
		 
		 $this->load->library('form_validation');
		 
		 $this->form_validation->set_rules('descripcion', 'Descripcion', 'required');
		 if ($this->form_validation->run() == true )
		 {
		 
			 $modificado = $this->M_configuracion->modificar_usuario($id_actual, $id_canal, $descripcion);
			 
   		     if ($modificado == 1)
			 { 
				 $this->notificacion = "El usuario se modificó satisfactoriamente.";
		         $this->notificacion_error = false;
			 }
			 else
			 {
				 $this->notificacion = "ERROR. No se pudo modificar el usuario. Verifique los datos especificados.";
		         $this->notificacion_error = true;
			 }
				 
		 }
		 else
		 {
		     $this->notificacion = validation_errors();
			 $this->notificacion_error = true;
			 
		 }
		 if($this->notificacion_error == true){
			 
			$datos['notificacion'] = $this->notificacion ? $this->notificacion : "Error registrando el usuario " . $usuario;
          	$datos['notificacion_error'] = $this->notificacion_error;
			$datos['modo_edicion'] = true;

					
			$datos['id_actual'] 		= $id_actual;
		    $datos['id_usuario']			= $id_canal;
			$datos['descripcion']  		= $descripcion;
					
			$this->load->view('lte_header', $datos);
			$this->load->view('v_usuarios', $datos);
			$this->load->view('lte_footer', $datos);
			 
			 
		 }else		 
		 $this->obt_canales();
	}
	
	//*******************************************************************************************************
	//     Gestion de tipo de objetivo
	//*******************************************************************************************************
    // Interfaz para registrar un nuevo tipo de objetivo
	public function nuevo_tipo_objetivo()
	{		
		$datos['notificacion'] = "Especifique los datos del nuevo tipo de objetivo:";
		$datos['modo_edicion'] = false;
		$datos['notificacion_error'] = $this->notificacion_error;
						
		$this->load->view('lte_header', $datos);
		$this->load->view('v_tipo_objetivo', $datos);
		$this->load->view('lte_footer', $datos);	
	}
	/********************************************************************************************************************/
	// Editando el tipo de objetivo
	public function editar_tipo_objetivo($id_actual)
	{
		$resultado = $this->M_configuracion->obt_tipo_objetivo($id_actual);
		
		if ($resultado)
		{
		   $tipo_objetivo = $resultado->row();

		   $id_tipo_objetivo = $id_actual;
		   $tipo = $tipo_objetivo->tipo;
		     		   
		   $datos['modo_edicion'] = true;
		   $datos['notificacion'] = 'Modificando los datos del tipo_objetivo ' . $id_tipo_objetivo . ' ' . $tipo;
		   $datos['notificacion_error'] = $this->notificacion_error;
		   
		   $datos['id_actual']  	   = $id_actual;
		   $datos['id_tipo_objetivo']  = $id_tipo_objetivo;
		   $datos['tipo']  	   = $tipo;
		   		   
		}
		
		$this->load->view('lte_header', $datos);
 	    $this->load->view('v_tipo_objetivo', $datos);
	    $this->load->view('lte_footer', $datos);
	}
	
	/********************************************************************************************************************/
	// Confirmar eliminación de un tipo de objetivo
	public function cfe_tipo_objetivo($id_tipo_objetivo)
	{
		$datos['id_tipo_objetivo'] = $id_tipo_objetivo;
		
		$this->load->view('lte_header', $datos);
 	    $this->load->view('vcan_tipo_objetivo', $datos);
	    $this->load->view('lte_footer', $datos);
	}
	/********************************************************************************************************************/
	// Cancelar objetivo
    public function cancelar_tipo_objetivo()
	{
		$id_tipo_objetivo = $this->input->post('id_tipo_objetivo');
		$cancelado = $this->M_configuracion->cancelar_tipo_objetivo($id_tipo_objetivo);
		
		if ($cancelado == 1)
	    { 
		   $this->not_fcliente = "Se eliminó la factura correctamente.";
		}
		else
		{
		   $this->not_fcliente = "ERROR. No se pudo eliminar la factura. Verifique los datos especificados.";
		}
		
		$this->obt_tipo_objetivos();

	}
	/********************************************************************************************************************/
	// Listado de objetivo
    public function obt_tipo_objetivos()
	{
		$tipo_objetivos 			   = $this->M_configuracion->obt_tipo_objetivos();	
        $datos['tipo_objetivos'] 	   = $tipo_objetivos;
		$datos['total_tipo_objetivos'] = $this->M_configuracion->total_tipo_objetivos();
        
		$this->load->view('lte_header', $datos);
		$this->load->view('v_listado_tipo_objetivos', $datos);
		$this->load->view('lte_footer', $datos);

	}	
	
	/********************************************************************************************************************/
	// Registrando un tipo de objetivo
    public function registrar_tipo_objetivo()
    {
		 
		 $tipo = $this->input->post('tipo');
		 	 
		 $this->load->library('form_validation');
		 
		 $this->form_validation->set_rules('tipo', 'Tipo', 'required');		 
		 
		 if ($tipo != ''  )
		 {		 
			
			 $registrado = $this->M_configuracion->registrar_tipo_objetivo($tipo);
			 
			 $mensaje = "";
			 if ($registrado == 1)
				 { 
					 $this->notificacion = "El tipo de objetivo se registró satisfactoriamente.";
		             $this->notificacion_error = false;
				 }
				 else
				 {
					 $this->notificacion = "ERROR. No se pudo registrar el tipo de objetivo.";
		             $this->notificacion_error = true;
				 }
				 
		 }
		 else
		 {
		     $this->notificacion = validation_errors();
			 $this->notificacion_error = true;
			 
		 }
		 if($this->notificacion_error == true){			
			
		    $datos['tipo']  	= $tipo;
		   
			$datos['notificacion'] = $this->notificacion ? $this->notificacion : "Error registrando el tipo de objetivo " . $tipo;
          	$datos['notificacion_error'] = $this->notificacion_error;
			$datos['modo_edicion'] = false;

			$this->load->view('lte_header', $datos);
			$this->load->view('v_tipo_objetivo', $datos);
			$this->load->view('lte_footer', $datos);  
		 
		 }else
		 $this->obt_tipo_objetivos();
		 
		 
    }
	/********************************************************************************************************************/
	// Modificando un tipo de objetivo
    public function modificar_tipo_objetivo()
    {
		 $id_actual = $this->input->post('id_actual');
		 $id_tipo_objetivo = $this->input->post('id_tipo_objetivo');
		 $tipo = $this->input->post('tipo');
		 		 		 
		 $this->load->library('form_validation');
		 
		 $this->form_validation->set_rules('tipo', 'Tipo', 'required');
		
		if (   $this->form_validation->run() == true)
		 {
			 $modificado = $this->M_configuracion->modificar_tipo_objetivo($id_actual, $id_tipo_objetivo, $tipo);
			 
   		     if ($modificado == 1)
			 { 
				 $this->notificacion = "El tipo de objetivo se modificó satisfactoriamente.";
		         $this->notificacion_error = false;
			 }
			 else
			 {
				 $this->notificacion = "ERROR. No se pudo modificar el tipo de objetivo. Verifique los datos especificados.";
		         $this->notificacion_error = true;
		 }
		 }	
		 else
		 {
		      $this->notificacion = validation_errors();
			  $this->notificacion_error = true;
		 
		 }
		 if($this->notificacion_error == true){
			
			$datos['id_actual']  	= $id_actual;
		    $datos['id_tipo_objetivo'] = $id_tipo_objetivo;
		    $datos['tipo']  	       = $tipo;
		   
			$datos['notificacion'] = $this->notificacion ? $this->notificacion : "Error modificando eltipo de objetivo " . $tipo;
          	$datos['notificacion_error'] = $this->notificacion_error;
			$datos['modo_edicion'] = true;

			$this->load->view('lte_header', $datos);
			$this->load->view('v_tipo_objetivo', $datos);
			$this->load->view('lte_footer', $datos);  
		 }else
		 $this->obt_tipo_objetivos();
	}
	//*****************************************************************************************************	
		/********************************************************************************************************************/
	//*******************************************************************************************************
	//     Gestion de canales principales
	//*******************************************************************************************************
    // Interfaz para registrar un nuevo objetivo
	public function nuevo_canal_principal()
	{		
		$datos['notificacion'] = "Especifique los datos del nuevo canal principal:";
		$datos['modo_edicion'] = false;
		$datos['notificacion_error'] = $this->notificacion_error;
		
				
		$this->load->view('lte_header', $datos);
		$this->load->view('v_canales_principal', $datos);
		$this->load->view('lte_footer', $datos);	
	}
	/********************************************************************************************************************/
	// Editando la canal
	public function editar_canal_principal($id_actual)
	{
		$resultado = $this->M_configuracion->obt_canal_principal($id_actual);
		
		if ($resultado)
		{
		   $canales = $resultado->row();

		   $id_canal 		= $id_actual;
		   $descripcion 	= $canales->nombre;		   
		   		   		   
		   $datos['modo_edicion'] = true;
		   $datos['notificacion_error'] = $this->notificacion_error;
		   $datos['notificacion'] = 'Modificando los datos del canal ' . $id_canal ;
		   
		   $datos['id_actual']  		= $id_actual;
		   $datos['id_canal']   		= $id_canal;
		   $datos['descripcion']   		= $descripcion;
		   		   
        		   
		}
		
		$this->load->view('lte_header', $datos);
 	    $this->load->view('v_canales_principal', $datos);
	    $this->load->view('lte_footer', $datos);
	}
	
	/********************************************************************************************************************/
	// Confirmar eliminación de un canal
	public function cfe_canal_principal($id_canal)
	{
		$datos['id_canal'] = $id_canal;
		
		$this->load->view('lte_header', $datos);
 	    $this->load->view('vcan_canales_principal', $datos);
	    $this->load->view('lte_footer', $datos);
	}
	/********************************************************************************************************************/
	// Cancelar canal
    public function cancelar_canal_principal()
	{
		$id_canal = $this->input->post('id_canal');
		$cancelado = $this->M_configuracion->cancelar_canal_principal($id_canal);
		
		if ($cancelado == 1)
	    { 
		   $this->not_fcliente = "Se eliminó el canal correctamente.";
		}
		else
		{
		   $this->not_fcliente = "ERROR. No se pudo eliminar el canal. Verifique los datos especificados.";
		}
		
		$this->obt_canales_principal();

	}
	/********************************************************************************************************************/
	// Listado de canal
    public function obt_canales_principal()
	{
		$canales 					= $this->M_configuracion->obt_canales_principal();	
        $datos['canales'] 			= $canales;
		$datos['total_canales'] 	= $this->M_configuracion->total_canales_principal();
        
		$this->load->view('lte_header', $datos);
		$this->load->view('v_listado_canal_principal', $datos);
		$this->load->view('lte_footer', $datos);

	}
	
	
	/********************************************************************************************************************/
	// Registrando un canal
    public function registrar_canal_principal()
    {
		 
		 $descripcion 			= $this->input->post('descripcion');
		 		 
		 $this->load->library('form_validation');
		 
		 $this->form_validation->set_rules('descripcion', 'Descripcion', 'required');
		 if ($this->form_validation->run() == true )
		 {		 
			
			 $registrado = $this->M_configuracion->registrar_canal_principal( $descripcion);
			 
			 $mensaje = "";
			 if ($registrado == 1)
				 { 
					 $this->notificacion = "Se ha registrado un nuevo canal.";
		             $this->notificacion_error = false;
				 }
				 else
				 {
					 $this->notificacion = "ERROR. No se pudo registrar el canal.";
		             $this->notificacion_error = true;
				 }
				 
		 }
		 else
		 {
		     $this->notificacion = validation_errors();
			 $this->notificacion_error = true;
			 
		 }
		 if($this->notificacion_error == true){	   
		              		   
			$datos['notificacion'] = $this->notificacion ? $this->notificacion : "Error registrando el canal " . $canal;
          	$datos['notificacion_error'] = $this->notificacion_error;
			$datos['modo_edicion'] = false;
						
		    $datos['descripcion']  			= $descripcion;
		   		
			$this->load->view('lte_header', $datos);
			$this->load->view('v_canales_principal', $datos);
			$this->load->view('lte_footer', $datos); 
		 }else
		 $this->obt_canales_principal();
		 
		 
    }
	/********************************************************************************************************************/
	// Modificando un canal
    public function modificar_canal_principal()
    {
		 $id_actual 		= $this->input->post('id_actual');
		 $id_canal 			= $this->input->post('id_canal');
		 $descripcion 			= $this->input->post('descripcion');
		 
		 $this->load->library('form_validation');
		 
		 $this->form_validation->set_rules('descripcion', 'Descripcion', 'required');
		 if ($this->form_validation->run() == true )
		 {
		 
			 $modificado = $this->M_configuracion->modificar_canal_principal($id_actual, $id_canal, $descripcion);
			 
   		     if ($modificado == 1)
			 { 
				 $this->notificacion = "El canal se modificó satisfactoriamente.";
		         $this->notificacion_error = false;
			 }
			 else
			 {
				 $this->notificacion = "ERROR. No se pudo modificar el canal. Verifique los datos especificados.";
		         $this->notificacion_error = true;
			 }
				 
		 }
		 else
		 {
		     $this->notificacion = validation_errors();
			 $this->notificacion_error = true;
			 
		 }
		 if($this->notificacion_error == true){
			 
			$datos['notificacion'] = $this->notificacion ? $this->notificacion : "Error registrando el canal " . $canal;
          	$datos['notificacion_error'] = $this->notificacion_error;
			$datos['modo_edicion'] = true;

					
			$datos['id_actual'] 		= $id_actual;
		    $datos['id_canal']			= $id_canal;
			$datos['descripcion']  		= $descripcion;
					
			$this->load->view('lte_header', $datos);
			$this->load->view('v_canales_principal', $datos);
			$this->load->view('lte_footer', $datos);
			 
			 
		 }else		 
		 $this->obt_canales_principal();
	}
	/********************************************************************************************************************/
	//*******************************************************************************************************
	//     Gestion de administracion de vip
	//*******************************************************************************************************
    // Interfaz para registrar un nuevo objetivo
	public function nuevo_nivel_vip()
	{		
		$datos['notificacion'] = "Especifique los datos del nuevo nivel vip:";
		$datos['modo_edicion'] = false;
		$datos['notificacion_error'] = $this->notificacion_error;
		
				
		$this->load->view('lte_header', $datos);
		$this->load->view('v_nivel_vip', $datos);
		$this->load->view('lte_footer', $datos);	
	}
	/********************************************************************************************************************/
	// Editando la nivel_vip
	public function editar_nivel_vip($id_actual)
	{
		$resultado = $this->M_configuracion->obt_nivel_vip($id_actual);
		
		if ($resultado)
		{
		   $niveles = $resultado->row();

			$id_canal 				= $id_actual;
		   	$id 					= $niveles->id;
		   	$descuento_producto 	= $niveles->descuento_producto;
		   	$paga_producto 			= $niveles->paga_producto;
		   	$paga_repuesto			= $niveles->paga_repuesto;
		   	$paga_envio 			= $niveles->paga_envio;
			$observaciones 			= $niveles->observaciones;		   
		   		   		   
		   	$datos['modo_edicion'] = true;
		   	$datos['notificacion_error'] = $this->notificacion_error;
		   	$datos['notificacion'] = 'Modificando los datos del canal ' . $id_canal ;
		   
		   	$datos['id']				= $id;
			$datos['observaciones']  	= $observaciones;
			$datos['descuento_producto']= $descuento_producto;
			$datos['paga_producto'] 	= $paga_producto;
		    $datos['paga_repuesto']		= $paga_repuesto;
			$datos['paga_envio']  		= $paga_envio;

		   	$datos['id_actual']  		= $id_actual;
		   	
		   		   
        		   
		}
		
		$this->load->view('lte_header', $datos);
 	    $this->load->view('v_nivel_vip', $datos);
	    $this->load->view('lte_footer', $datos);
	}
	
	/********************************************************************************************************************/
	// Confirmar eliminación de un canal
	public function cfe_nivel_vip($id)
	{
		$datos['id'] = $id;
		
		$this->load->view('lte_header', $datos);
 	    $this->load->view('vcan_nivel_vip', $datos);
	    $this->load->view('lte_footer', $datos);
	}
	/********************************************************************************************************************/
	// Cancelar canal
    public function cancelar_nivel_vip()
	{
		$id = $this->input->post('id');
		$cancelado = $this->M_configuracion->cancelar_nivel_vip($id);
		
		if ($cancelado == 1)
	    { 
		   $this->not_fcliente = "Se eliminó el nivel correctamente.";
		}
		else
		{
		   $this->not_fcliente = "ERROR. No se pudo eliminar el nivel. Verifique los datos especificados.";
		}
		
		$this->obt_nivel_vip();

	}
	/********************************************************************************************************************/
	// Listado de canal
    public function obt_nivel_vip()
	{
		$niveles 					= $this->M_configuracion->obt_niveles_vip();	
        $datos['niveles'] 			= $niveles;
		
        
		$this->load->view('lte_header', $datos);
		$this->load->view('v_listado_nivel_vip', $datos);
		$this->load->view('lte_footer', $datos);

	}
	
	
	/********************************************************************************************************************/
	// Registrando un canal
    public function registrar_nivel_vip()
    {
		$id 			= $this->input->post('id');
		if($this->input->post('descuento_producto')){
			$descuento_producto = 1;
		}else{
			$descuento_producto = 0;
		}
	
		if($this->input->post('paga_producto')){
			$paga_producto = 1;
		}else{
			$paga_producto = 0;
		}
		if($this->input->post('paga_repuesto')){
			$paga_repuesto = 1;
		}else{
			$paga_repuesto = 0;
		}
		if($this->input->post('paga_envio')){
			$paga_envio = 1;
		}else{
			$paga_envio = 0;
		}
		$observaciones 			= $this->input->post('observaciones');
		 		 
		$this->load->library('form_validation');
		$this->form_validation->set_rules('id', 'Nivel', 'required|numeric');
		$this->form_validation->set_rules('observaciones', 'Descripcion', 'required');
		if ($this->form_validation->run() == true )
		{		
			$registrado = $this->M_configuracion->registrar_nivel_vip( $id, $descuento_producto, $paga_producto, $paga_repuesto, $paga_envio, $observaciones);
			
			$mensaje = "";
			if ($registrado == 1)
				{ 
					$this->notificacion = "Se ha registrado un nuevo nivel VIP.";
					$this->notificacion_error = false;
				}
				else
				{
					$this->notificacion = "ERROR. No se pudo registrar el nivel VIP.";
					$this->notificacion_error = true;
				}
				
		}
		else
		 {
		     $this->notificacion = validation_errors();
			 $this->notificacion_error = true;
			 
		 }
		 if($this->notificacion_error == true){	   
		              		   
			$datos['notificacion'] = $this->notificacion ? $this->notificacion : "Error registrando el nivel VIP " . $canal;
          	$datos['notificacion_error'] = $this->notificacion_error;
			$datos['modo_edicion'] = false;
						
		    $datos['descripcion']  			= $descripcion;
		   		
			$this->load->view('lte_header', $datos);
			$this->load->view('v_nivel_vip', $datos);
			$this->load->view('lte_footer', $datos); 
		 }else
		 $this->obt_nivel_vip();
		 
		 
    }
	/********************************************************************************************************************/
	// Modificando un canal
    public function modificar_nivel_vip()
    {
		$id_actual 		= $this->input->post('id_actual');
		$id 			= $this->input->post('id');
		$observaciones 	= $this->input->post('observaciones');
		if($this->input->post('descuento_producto')){
			$descuento_producto = 1;
		}else{
			$descuento_producto = 0;
		}
	
		if($this->input->post('paga_producto')){
			$paga_producto = 1;
		}else{
			$paga_producto = 0;
		}
		if($this->input->post('paga_repuesto')){
			$paga_repuesto = 1;
		}else{
			$paga_repuesto = 0;
		}
		if($this->input->post('paga_envio')){
			$paga_envio = 1;
		}else{
			$paga_envio = 0;
		}

		$this->load->library('form_validation');
		$this->form_validation->set_rules('id', 'Nivel', 'required|numeric');
		$this->form_validation->set_rules('observaciones', 'Descripcion', 'required');
		 if ($this->form_validation->run() == true )
		 {
		 
			 $modificado = $this->M_configuracion->modificar_nivel_vip($id_actual, $id, $descuento_producto, $paga_producto, $paga_repuesto, $paga_envio, $observaciones);
			 
   		     if ($modificado == 1)
			 { 
				 $this->notificacion = "El nivel se modificó satisfactoriamente.";
		         $this->notificacion_error = false;
			 }
			 else
			 {
				 $this->notificacion = "ERROR. No se pudo modificar el nivel. Verifique los datos especificados.";
		         $this->notificacion_error = true;
			 }
				 
		 }
		 else
		 {
		     $this->notificacion = validation_errors();
			 $this->notificacion_error = true;
			 
		 }
		 if($this->notificacion_error == true){
			 
			$datos['notificacion'] = $this->notificacion ? $this->notificacion : "Error registrando el nivel " . $canal;
          	$datos['notificacion_error'] = $this->notificacion_error;
			$datos['modo_edicion'] = true;

					
			$datos['id_actual'] 		= $id_actual;
		    $datos['id']				= $id;
			$datos['observaciones']  	= $observaciones;
			$datos['descuento_producto']= $descuento_producto;
			$datos['paga_producto'] 	= $paga_producto;
		    $datos['paga_repuesto']		= $paga_repuesto;
			$datos['paga_envio']  		= $paga_envio;
					
			$this->load->view('lte_header', $datos);
			$this->load->view('v_nivel_vip', $datos);
			$this->load->view('lte_footer', $datos);
			 
			 
		 }else		 
		 $this->obt_nivel_vip();
	}
	//////////////////////////////////////////////////////////////////////////////////////
	/////////////////////////////////////////////////////////////////////////////////////
	///    nivel_productos
	///////////////////////////////////////////////////////////////////////////////////
	public function agregar_nivel_productos()
	{
		$id_nivel= $this->input->post('id_nivel');
		$id_producto = $this->input->post('sel_productos');
		$descuento= $this->input->post('descuento');
		
		$this->load->library('form_validation');
		 
		$this->form_validation->set_rules('sel_productos', 'producto', 'required');
		$this->form_validation->set_rules('descuento', 'Descuento', 'required');

		if ($this->form_validation->run() == true )
		{
			$resultado = $this->M_configuracion->agregar_nivel_productos($id_nivel, $id_producto,$descuento);
			
		}else{
			
			$this->notificacion = "ERROR. No existen productos.";
			$this->notificacion_error = true;
		}		
		$this->editar_nivel_productos($id_nivel);
	}
	public function editar_nivel_productos($id_nivel)
	{
		$resultado = $this->M_configuracion->obt_nivel_vip($id_nivel);
		
		if ($resultado)
		{
		   $nivel = $resultado->row();
		   
		   $nombre = $nivel->observaciones;
		   $datos['nombre']  = $nombre;
		   $datos['id_nivel']  = $id_nivel;
		}
		
		$resultado_productos = $this->M_configuracion->obt_productos_solos();		
		$datos['productos'] = $resultado_productos;	
		$nivel_productos = $this->M_configuracion->obt_niveles_productos($id_nivel);
		$datos['nivel_productos'] = $nivel_productos;

		$datos['modo_edicion'] = true;
		$datos['notificacion'] = 'Modificando los colores del producto: '  . $nombre;
		if($this->notificacion_error == true){
			
			$datos['notificacion'] = $this->notificacion;				
			$datos['notificacion_error'] = $this->notificacion_error;
			$this->load->view('lte_header', $datos);
			$this->load->view('v_niveles_productos', $datos);
			$this->load->view('lte_footer', $datos);
			
			return;
		}
		 
		if ($resultado_productos->result())
		{
			$this->notificacion = 'Modificando los productos del nivel: ' . $nombre;
			$this->notificacion_error == false;
			
		} else{
			
			$this->notificacion = 'No existen productos registrados, no podrá realizar la operación';
			$this->notificacion_error == true;
		}				

		$datos['notificacion'] = $this->notificacion;
		$datos['notificacion_error'] = $this->notificacion_error;
		$this->load->view('lte_header', $datos);
 	    $this->load->view('v_niveles_productos', $datos);
	    $this->load->view('lte_footer', $datos);
	}
	 public function cancelar_nivel_productos()
	{
		$id_producto = $this->input->post('id_producto');
		$id_nivel = $this->input->post('id_nivel');

		$cancelado = $this->M_configuracion->cancelar_nivel_productos($id_nivel, $id_producto);
		
		if ($cancelado == 1)
	    { 
		   $this->not_fcliente = "Se eliminó el producto correctamente.";
		}
		else
		{
		   $this->not_fcliente = "ERROR. No se pudo eliminar el producto. Verifique los datos especificados.";
		}
		
		$this->editar_nivel_productos($id_nivel);

	}
	public function cfe_nivel_productos($id_nivel, $id_producto)
	{
		$datos['id_producto'] = $id_producto;
		$datos['id_nivel'] = $id_nivel;
		
		$this->load->view('lte_header', $datos);
 	    $this->load->view('vcan_nivel_productos', $datos);
	    $this->load->view('lte_footer', $datos);
	}
	public function obtener_nivel($id_nivel)
	{
		$prod = $this->M_configuracion->obt_nivel_vip($id_nivel);
        $row = $prod->row_array();
		echo json_encode($row);  
	}
	public function obtener_objetivo_consultor($id_consultor)
	{
		$prod = $this->M_configuracion->obt_objetivos_consultor($id_consultor);
        $row = $prod->result();
		echo json_encode($row);  
	}
	public function obtener_descuentovip_producto($id_nivel, $id_producto)
	{
		$prod = $this->M_configuracion->obt_descuentovip_producto($id_nivel, $id_producto);
        $row = $prod->row_array();		
		echo json_encode($row);  
	}
	/********************************************************************************************************************/
	   //*******************************************************************************************************
	//     Gestion de operativas
	//*******************************************************************************************************
    // Interfaz para registrar un nuevo operativa
	public function nuevo_operativa()
	{		
		$datos['notificacion'] = "Especifique los datos de la nueva operativa:";
		$datos['modo_edicion'] = false;
		$datos['notificacion_error'] = $this->notificacion_error;
		
		$this->load->view('lte_header', $datos);
		$this->load->view('v_operativas', $datos);
		$this->load->view('lte_footer', $datos);	
	}
	/********************************************************************************************************************/
	// Editando la operativa
	public function editar_operativa($id_actual)
	{
		$resultado = $this->M_configuracion->obt_operativa($id_actual);
		
		if ($resultado)
		{
		   $operativa = $resultado->row();

		   $id_operativa 	= $id_actual;
		   $nombre			= $operativa->nombre;
		   $descripcion 	= $operativa->descripcion;
		   $grupo 			= $operativa->grupo;
		   		   
		   $datos['modo_edicion'] = true;
		   $datos['notificacion'] = 'Modificando los datos de la operativa ' . $id_operativa . ' ' . $descripcion;
		   $datos['notificacion_error'] = $this->notificacion_error;
		   
		   $datos['id_actual']    	= $id_actual;
		   $datos['id_operativa']   = $id_operativa;
		   $datos['nombre']  		= $nombre;
		   $datos['descripcion']  	= $descripcion;
		   $datos['grupo']  		= $grupo;
		}
		
		$this->load->view('lte_header', $datos);
 	    $this->load->view('v_operativas', $datos);
	    $this->load->view('lte_footer', $datos);
	}
	
	/********************************************************************************************************************/
	// Confirmar eliminación de un operativa
	public function cfe_operativa($id_operativa)
	{
		$datos['id_operativa'] = $id_operativa;
		
		$productos = $this->M_configuracion->obt_operativas($id_operativa);
		
	
		$this->notificacion = ' ';
		
		
		$datos['notificacion'] = $this->notificacion;
		$this->load->view('lte_header', $datos);
 	    $this->load->view('vcan_operativas', $datos);
	    $this->load->view('lte_footer', $datos);
	}
	/********************************************************************************************************************/
	// Cancelar operativa
    public function cancelar_operativa()
	{
		$id_operativa = $this->input->post('id_operativa');
			
		$cancelado = $this->M_configuracion->cancelar_operativa($id_operativa);
		
		if ($cancelado == 1)
	    { 
		   $this->not_fcliente = "Se eliminó la operativa correctamente.";
		}
		else
		{
		   $this->not_fcliente = "ERROR. No se pudo eliminar la operativa. Verifique los datos especificados.";
		}
		
		$this->obt_operativas();

	}
	/********************************************************************************************************************/
	// Listado de operativa
    public function obt_operativas()
	{
		$operativas 				= $this->M_configuracion->obt_operativas();	
        $datos['operativas'] 		= $operativas;
		$datos['total_operativas'] = $this->M_configuracion->total_operativas();
        
		$this->load->view('lte_header', $datos);
		$this->load->view('v_listado_operativas', $datos);
		$this->load->view('lte_footer', $datos);

	}
	public function obt_operativa($id_operativa){
		$operativa= $this->M_configuracion->obt_operativa($id_operativa);
		$row = $operativa->row_array();
		echo json_encode($row); 
	}
	
	/********************************************************************************************************************/
	// Registrando un operativa
    public function registrar_operativa()
    {
		 $nombre 		= $this->input->post('nombre');
		 $descripcion 	= $this->input->post('descripcion');
		 $grupo 		= $this->input->post('grupo');
		 
		 $this->load->library('form_validation');
		  $this->form_validation->set_rules('nombre', 'Nombre', 'required');
		 $this->form_validation->set_rules('descripcion', 'Descripción', 'required');
		 
		 if ($this->form_validation->run() == true )
		 {		 
			 $registrado = $this->M_configuracion->registrar_operativa($nombre, $descripcion, $grupo);
			 
			 $mensaje = "";
			 if ($registrado == 1)
				 { 
					 $this->notificacion = "El cliente se registró satisfactoriamente.";
		             $this->notificacion_error = false;
				 }
				 else
				 {
					 $this->notificacion = "ERROR. No se pudo registrar el cliente.";
		             $this->notificacion_error = true;
				 }
				 
		 }
		 else
		 {
		     $this->notificacion = validation_errors();
			 $this->notificacion_error = true;
			 
		 }
		 if($this->notificacion_error == true){			
			$datos['nombre']  		= $nombre;
			$datos['descripcion']  = $descripcion;
		    $datos['grupo']  = $grupo;
	
			$datos['notificacion'] = $this->notificacion ? $this->notificacion : "Error registrando el color ";
          	$datos['notificacion_error'] = $this->notificacion_error;
			$datos['modo_edicion'] = false;

			$this->load->view('lte_header', $datos);
			$this->load->view('v_operativas', $datos);
			$this->load->view('lte_footer', $datos);  
		 
		 }else
		 $this->obt_operativas();
		 
		 
    }
	/********************************************************************************************************************/
	// Modificando un operativa
    public function modificar_operativa()
    {
		 $id_actual 	= $this->input->post('id_actual');
		 $id_operativa 	= $this->input->post('id_operativa');
		 $nombre 		= $this->input->post('nombre');
		 $descripcion 	= $this->input->post('descripcion');
		 $grupo 		= $this->input->post('grupo');
		 		 
		 $this->load->library('form_validation');
		 
		 $this->form_validation->set_rules('nombre', 'Nombre', 'required');
		 $this->form_validation->set_rules('descripcion', 'Descripción', 'required');
		 if ($this->form_validation->run() == true )
		 {
		 
			 $modificado = $this->M_configuracion->modificar_operativa($id_actual, $id_operativa, $nombre,  $descripcion, $grupo);
			 
   		     if ($modificado == 1)
			 { 
				 $this->notificacion = "la operativa se modificó satisfactoriamente.";
		         $this->notificacion_error = false;
			 }
			 else
			 {
				 $this->notificacion = "ERROR. No se pudo modificar la operativa. Verifique los datos especificados.";
		         $this->notificacion_error = true;
		 }
				 
		 }
		 else
		 {
		     $this->notificacion = validation_errors();
			 $this->notificacion_error = true;
			 
		 }
		 if($this->notificacion_error == true){
			
		   
		    $datos['id_actual']    	= $id_actual;
		    $datos['id_operativa']  = $id_operativa;
		    $datos['nombre']  		= $nombre;
			$datos['descripcion']  	= $descripcion;
			$datos['grupo']  		= $grupo;
			
			$datos['notificacion'] = $this->notificacion ? $this->notificacion : "Error modificando el perfil de la operativa " . $id_operativa;
          	$datos['notificacion_error'] = $this->notificacion_error;
			$datos['modo_edicion'] = true;

			$this->load->view('lte_header', $datos);
			$this->load->view('v_operativas', $datos);
			$this->load->view('lte_footer', $datos);  
		 }else
		 
		 $this->obt_operativas();
	}
	/********************************************************************************************************************/
	 
	  public function obt_solicitud_baja()
	{
		$solicitudes 				= $this->M_configuracion->obt_solicitud_baja();	
        $datos['solicitudes'] 		= $solicitudes;
		$datos['total_solicitudes'] = $this->M_configuracion->total_solicitudes();
        
		$this->load->view('lte_header', $datos);
		$this->load->view('v_listado_solicitud_baja', $datos);
		$this->load->view('lte_footer', $datos);

	}
	// Editando la solicitudes
	public function edit_solicitud_baja($id_actual)
	{
		$resultado = $this->M_configuracion->obte_solicitud_baja($id_actual);
		
		if ($resultado)
		{
		   $solicitud = $resultado->row();

		   $id_solicitud 	= $solicitud->id_cliente;
		   $cliente			= $solicitud->cliente;
		   $usuario 		= $solicitud->usuario;
		   $observaciones 	= $solicitud->observaciones;
		   $fecha 			= $solicitud->fecha_solicitud;
		   $aprobada 		= $solicitud->aprobada;
		   $denegada 		= $solicitud->denegada;
		   		   
		   $datos['modo_edicion'] = true;
		   $datos['notificacion'] = 'Modificando los datos de la solicitud ' . $id_actual . ' ' . $cliente;
		   $datos['notificacion_error'] = $this->notificacion_error;
		   
		   $datos['id_actual']    	= $id_actual;
		   $datos['id_solicitud']   = $id_solicitud;
		   $datos['cliente']  		= $cliente;
		   $datos['usuario']  		= $usuario;
		   $datos['fecha']  		= $fecha;
		   $datos['observaciones']  = $observaciones;
		   $datos['aprobada']  		= $aprobada;
		   $datos['denegada']  		= $denegada;
		   
		}
		
		$this->load->view('lte_header', $datos);
 	    $this->load->view('v_solicitudes', $datos);
	    $this->load->view('lte_footer', $datos);
	}
	 public function modificar_solicitud_baja($id_actual)
    {
		 //$id_actual 	= $this->input->post('id_actual');
		 $id_cliente 	= $this->input->post('id_solicitud');
		 
		if($this->input->post('aprobada')){
			$aprobada = 1;
		 }else{
			 $aprobada = 0;
		 }
		 if($this->input->post('denegada')){
			$denegada = 1;
		 }else{
			 $denegada = 0;
		 }
		 
		 $cliente 		= $this->input->post('cliente');
		 $usuario 		= $this->input->post('usuario');
		 $observaciones = $this->input->post('observaciones');
		 $fecha 		= $this->input->post('fecha');
		 
		 
		 if($aprobada == 1 && $denegada == 1){
			$validacion = false;
		 }else{
			 $validacion = true;
		 }				 
		 if ($validacion)
		 {
			if($aprobada == 1){
				$modificado = $this->M_configuracion->modificar_solicitud_baja($id_actual, $aprobada,  $denegada);
				$modificado = $this->M_configuracion->modificar_estado_cliente($id_cliente);
						 
				if ($modificado == 1)
				{ 
					$this->notificacion = "la operativa se modificó satisfactoriamente.";
					$this->notificacion_error = false;
				}
				else
				{
					$this->notificacion = "ERROR. No se pudo modificar la solicitud. Verifique los datos especificados.";
					$this->notificacion_error = true;
				}
			}else{
				$eliminado = $this->M_configuracion->eliminar_solicitud_baja($id_actual);
			}	 
		 }
		 else
		 {
		     $this->notificacion = 'No puede ser seleccionada las opciones denegada y aceptada a la misma vez';
			 $this->notificacion_error = true;
			 
		 }
		 if($this->notificacion_error == true){
			
		   
		   $datos['id_actual']    	= $id_actual;
		   $datos['id_solicitud']   = $id_cliente;
		   $datos['cliente']  		= $cliente;
		   $datos['usuario']  		= $usuario;
		   $datos['fecha']  		= $fecha;
		   $datos['observaciones']  = $observaciones;
		   $datos['aprobada']  		= $aprobada;
		   $datos['denegada']  		= $denegada;
			
			$datos['notificacion'] = $this->notificacion ? $this->notificacion : "Error modificando el perfil de la operativa " . $id_operativa;
          	$datos['notificacion_error'] = $this->notificacion_error;
			$datos['modo_edicion'] = true;

			$this->load->view('lte_header', $datos);
			$this->load->view('v_solicitudes', $datos);
			$this->load->view('lte_footer', $datos);  
		 }else
		 
		 $this->obt_solicitud_baja();
	}
	 //*******************************************************************************************************
    //*******************************************************************************************************
	//     Gestion de pack secundarios
	//*******************************************************************************************************
    // Interfaz para registrar un pack
	public function nuevo_pack()
	{	
       
		$datos['notificacion'] = "Especifique los datos del nuevo pack:";
		$datos['modo_edicion'] = false;
		$this->notificacion_error = false;
		$datos['notificacion_error'] = $this->notificacion_error;

		$this->load->view('lte_header', $datos);
		$this->load->view('v_packs', $datos);
		$this->load->view('lte_footer', $datos);	
	}
	/********************************************************************************************************************/
	// Editando revendedor
	public function editar_pack($id_actual)
	{
		$resultado = $this->M_configuracion->obt_pack($id_actual);
		
        
		if ($resultado)
		{
		   $pack = $resultado->row();

		   $id = $id_actual;
		   $nombre = $pack->nombre;
		   $largo = $pack->largo;
		   $ancho = $pack->ancho;
		   $alto = $pack->alto;
		  		   		   
		   $datos['modo_edicion'] = true;
		   $datos['notificacion'] = 'Modificando los datos del pack' . $nombre ;
		   $datos['notificacion_error'] = false;

		   $datos['id_actual']  = $id_actual;
		   $datos['id']   		= $id;
		   $datos['nombre']  	= $nombre;
		   $datos['largo']   	= $largo;
		   $datos['ancho']  	= $ancho;
		   $datos['alto']  		= $alto;
		}
		
		$this->load->view('lte_header', $datos);
 	    $this->load->view('v_packs', $datos);
	    $this->load->view('lte_footer', $datos);
	}
	
	/********************************************************************************************************************/
	// Confirmar eliminación del pack
	public function cfe_pack($id_actual)
	{
		$datos['id_actual'] = $id_actual;
		
		
		$this->load->view('lte_header', $datos);
 	    $this->load->view('vcan_packs', $datos);
	    $this->load->view('lte_footer', $datos);
	}
	/********************************************************************************************************************/
	// Cancelar pack
    public function cancelar_pack()
	{
		$id_actual = $this->input->post('id_actual');
		
		$cancelado = $this->M_configuracion->cancelar_pack($id_actual);
		
		if ($cancelado == 1)
	    { 
		   $this->not_fcliente = "Se eliminó el pack correctamente.";
		}
		else
		{
		   $this->not_fcliente = "ERROR. No se pudo eliminar el pack. Verifique los datos especificados.";
		   $datos['notificacion_error'] = true;
		   
		}
		
		$this->obt_packs();

	}
	/********************************************************************************************************************/
	// Listado de pack
    public function obt_packs()
	{
		$pack = $this->M_configuracion->obt_packs();	
        $datos['packs'] = $pack;
		$datos['total_packs'] = $this->M_configuracion->total_packs();
        
		$this->load->view('lte_header', $datos);
		$this->load->view('v_listado_pack', $datos);
		$this->load->view('lte_footer', $datos);

	}
	/********************************************************************************************************************/
	// Registrando un pack
    public function registrar_pack()
    {
		$id = $this->input->post('id');
		$nombre = $this->input->post('nombre');
		$largo 	= $this->input->post('largo');
		$ancho 	= $this->input->post('ancho');
		$alto 	= $this->input->post('alto');
		 
		 if ( $nombre != ''  )
		 {		 
			 $registrado = $this->M_configuracion->registrar_pack($nombre, $largo, $ancho, $alto);
			 
			 $mensaje = "";
			 if ($registrado == 1)
				 { 
					 $this->not_fcliente = "Se ha registrado un nuevo pack.";
					 
				 }
				 else
				 {
					 $this->not_fcliente = "ERROR. No se pudo registrar al pack. Verifique los datos especificados.";
				 }
				 
		 }
		 else
		 {
		     $this->not_fcliente = "ERROR. No se pudo registrar el pack. Verifique los datos especificados.";
			 
		 }
		 $this->obt_packs();
		 
		 
    }
	/********************************************************************************************************************/
	// Modificando un pack
    public function modificar_pack()
    {
		 $id_actual = $this->input->post('id_actual');
		 $id = $this->input->post('id');
		 $nombre = $this->input->post('nombre');
		 $largo = $this->input->post('largo');
		 $ancho = $this->input->post('ancho');
		 $alto = $this->input->post('alto');
		 
		 if ($nombre != '' )
		 {
		 
			 $modificado = $this->M_configuracion->modificar_pack($id_actual, $id, $nombre, $largo, $ancho, $alto);
			 
   		     if ($modificado == 1)
			 { 
				 $this->not_fcliente = "Se ha registrado un pack.";
			 }
			 else
			 {
				 $this->not_fcliente = "ERROR. No se pudo modificar el pack. Verifique los datos especificados.";
			 }
				 
		 }
		 else
		 {
		     $this->not_fcliente = "ERROR. No se pudo modificar el pack. Verifique los datos especificados.";
			 
		 }
		 
		 $this->obt_packs();
	}
	/********************************************************************************************************************/
	/********************************************************************************************************************/
	//*******************************************************************************************************
	//     Gestion de feriados
	//*******************************************************************************************************
    // Interfaz para registrar un nuevo objetivo
	public function nuevo_feriado()
	{		
		$datos['notificacion'] = "Especifique los datos del nuevo canal:";
		$datos['modo_edicion'] = false;
		$datos['notificacion_error'] = $this->notificacion_error;
		
		$this->load->view('lte_header', $datos);
		$this->load->view('v_feriados', $datos);
		$this->load->view('lte_footer', $datos);	
	}
	/********************************************************************************************************************/
	// Editando la feriado
	public function editar_feriado($id_actual)
	{
		$resultado = $this->M_configuracion->obt_feriado($id_actual);
		if ($resultado)
		{
		   $feriados = $resultado->row();

		   $id_feriado 		= $id_actual;
		   $dia 	= $feriados->dia;	
		   		   		   
		   $datos['modo_edicion'] = true;
		   $datos['notificacion_error'] = $this->notificacion_error;
		   $datos['notificacion'] = 'Modificando los datos del feriado ' . $id_feriado ;
		   
		   $datos['id_actual']  		= $id_actual;
		   $datos['id_feriado']   		= $id_feriado;
		   $datos['dia']   				= $dia;   
        		   
		}
		
		$this->load->view('lte_header', $datos);
 	    $this->load->view('v_feriados', $datos);
	    $this->load->view('lte_footer', $datos);
	}
	
	/********************************************************************************************************************/
	// Confirmar eliminación de un feriado
	public function cfe_feriado($id_feriado)
	{
		$datos['id_feriado'] = $id_feriado;
		
		$this->load->view('lte_header', $datos);
 	    $this->load->view('vcan_feriados', $datos);
	    $this->load->view('lte_footer', $datos);
	}
	/********************************************************************************************************************/
	// Cancelar feriado
    public function cancelar_feriado()
	{
		$id_feriado = $this->input->post('id_feriado');
		$cancelado = $this->M_configuracion->cancelar_feriado($id_feriado);
		
		if ($cancelado == 1)
	    { 
		   $this->not_fcliente = "Se eliminó el feriado correctamente.";
		}
		else
		{
		   $this->not_fcliente = "ERROR. No se pudo eliminar el feriado. Verifique los datos especificados.";
		}
		
		$this->obt_feriados();

	}
	/********************************************************************************************************************/
	// Listado de feriado
    public function obt_feriados()
	{
		$feriados 					= $this->M_configuracion->obt_feriados();	
        $datos['feriados'] 			= $feriados;
		$datos['total_feriados'] 	= $this->M_configuracion->total_feriados();
        
		$this->load->view('lte_header', $datos);
		$this->load->view('v_listado_feriado', $datos);
		$this->load->view('lte_footer', $datos);

	}
	
	
	/********************************************************************************************************************/
	// Registrando un feriado
    public function registrar_feriado()
    {
		 
		 $dia 			= $this->input->post('dia');
		 		 
		 $this->load->library('form_validation');
		 
		 $this->form_validation->set_rules('dia', 'Día', 'required');
		 if ($this->form_validation->run() == true )
		 {		 
			
			 $registrado = $this->M_configuracion->registrar_feriado( $dia );
			 
			 $mensaje = "";
			 if ($registrado == 1)
				 { 
					 $this->notificacion = "Se ha registrado un nuevo feriado.";
		             $this->notificacion_error = false;
				 }
				 else
				 {
					 $this->notificacion = "ERROR. No se pudo registrar el feriado.";
		             $this->notificacion_error = true;
				 }
				 
		 }
		 else
		 {
		     $this->notificacion = validation_errors();
			 $this->notificacion_error = true;
			 
		 }
		 if($this->notificacion_error == true){	   
		              		   
			$datos['notificacion'] = $this->notificacion ? $this->notificacion : "Error registrando el feriado " . $feriado;
          	$datos['notificacion_error'] = $this->notificacion_error;
			$datos['modo_edicion'] = false;
						
			
		    $datos['dia']  			= $dia;
		   		
			$this->load->view('lte_header', $datos);
			$this->load->view('v_feriados', $datos);
			$this->load->view('lte_footer', $datos); 
		 }else
		 $this->obt_feriados();
		 
		 
    }
	/********************************************************************************************************************/
	// Modificando un feriado
    public function modificar_feriado()
    {
		 $id_actual 		= $this->input->post('id_actual');
		 $id_feriado 		= $this->input->post('id_feriado');
		 $dia 				= $this->input->post('dia');
		 
		 $this->load->library('form_validation');
		 
		 $this->form_validation->set_rules('dia', 'Día', 'required');
		 if ($this->form_validation->run() == true )
		 {
		 
			 $modificado = $this->M_configuracion->modificar_feriado($id_actual, $id_feriado, $dia);
			 
   		     if ($modificado == 1)
			 { 
				 $this->notificacion = "El feriado se modificó satisfactoriamente.";
		         $this->notificacion_error = false;
			 }
			 else
			 {
				 $this->notificacion = "ERROR. No se pudo modificar el feriado. Verifique los datos especificados.";
		         $this->notificacion_error = true;
			 }
				 
		 }
		 else
		 {
		     $this->notificacion = validation_errors();
			 $this->notificacion_error = true;
			 
		 }
		 if($this->notificacion_error == true){
			 
			$datos['notificacion'] = $this->notificacion ? $this->notificacion : "Error registrando el feriado " . $canal;
          	$datos['notificacion_error'] = $this->notificacion_error;
			$datos['modo_edicion'] = true;

					
			$datos['id_actual'] 	= $id_actual;
		    $datos['id_feriado']	= $id_feriado;
			$datos['dia']  			= $dia;
					
			$this->load->view('lte_header', $datos);
			$this->load->view('v_feriados', $datos);
			$this->load->view('lte_footer', $datos);
			 
			 
		 }else		 
		 $this->obt_feriados();
	}
	/**************************************************************************************************************/// -----------  Misiones -------------------------------------------
	public function modificar_cliente_cartera()
    {
		 $id_actual = $this->input->post('id_cliente');		 
		 $id_cliente = $this->input->post('id_cliente');
		 		 
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
		 $cuit 			= 	 $this->input->post('cuit');	 
		 $codigo_postal	= 	 $this->input->post('codigo_postal');	 
		 $observaciones1 = 	 $this->input->post('observaciones1');
		//////////////////////////////////////////////////////////////////////////
		if($this->input->post('solicitud_baja')){

			$solicitud_baja = 1;
			$observaciones =  $this->input->post('observaciones');
			$opcion_baja =  $this->input->post('opcion_baja');
			if($opcion_baja){
				$fallecido =1;
			}else{
				$fallecido =0;
			}
			$solicitud = $this->M_configuracion->solicitud_baja($id_cliente);			
			if($solicitud->num_rows() == 0){				
				$user = $this->ion_auth->user()->row();				
				$resul1 = $this->M_configuracion->registrar_solicitud_baja($user->id, $id_cliente, $observaciones,$fallecido);
				$observ ='Solicitud de baja';
				$regis = $this->M_operaciones->set_llamadas($user->id,$id_cliente,  $observ);
			}
		}else{
			 $solicitud_baja = 0;
			 $observaciones = "";
			 $solicitud = $this->M_configuracion->solicitud_baja($id_cliente);			
			 if($solicitud->num_rows() <> 0){				
				 $user = $this->ion_auth->user()->row();				
				 $resul1 = $this->M_configuracion->cancelar_solicitud_baja($id_cliente);
			 }
		}		
		
		if($this->input->post('vip')){
		   $vip = 1;
	   }else{
		   $vip = 0;
	   }		 
		$nivel 			= $this->input->post('nivel');	   			
		
		
		/////////////////////////////////////////////////////////////////////////
		$regis = $this->M_configuracion->modificar_cartera_cliente($id_cliente, $dni, $municipio, $nombre,$apellidos, $telefono,$celular, $email, $codigo_postal, $calle, $nro, $piso, $dpto, $entrecalle1, $entrecalle2,  $vip, $nivel, $observaciones1, $cuit);


		$regis = $this->cartera_historial($id_cliente);
	}
	public function registrar_reclamos()
    {		
		 $id_cliente    = $this->input->post('id_cliente_reclamo');
		 
		 $contencion    = $this->input->post('contencion');
		 $causa_text    = $this->input->post('causa');
		 $preventiva    = $this->input->post('preventiva');
		 $costos        = $this->input->post('costos');
		 $resp_costos   = $this->input->post('resp_costos');
		 $ficha   = $this->input->post('ficha');
		 
		 //$causa = $this->input->post('sel_causas');
		 $causa         = 12;
		 $notas         = $this->input->post('notas');
		 $user          = $this->ion_auth->user()->row();
		 $id_usuario    = $user->id;
		 $local         = $user->id_local;				 	 

		$regis = $this->M_configuracion->registrar_reclamos($id_cliente, $causa,$notas, $id_usuario, $local, $contencion, $causa_text, $preventiva, $costos, $resp_costos); 
		if ($ficha==0) {
			# code...
			$this->cartera_historial($id_cliente);
		}else{
			$this->cartera_historial1($id_cliente);
		}
		
	}
	public function registrar_llamame()
    {		
		 $id_cliente = $this->input->post('id_cliente_llamame');
		  
		 //Datos del cliente
		 $fecha = $this->input->post('fecha_llamarme');

		$regis = $this->M_configuracion->registrar_llamame($id_cliente, $fecha); 
		$user = $this->ion_auth->user()->row();
		$id_usuario=$user->id;
		$observ = 'Llamame mas adelante';
		$this->M_operaciones->set_llamadas($user->id,$id_cliente,  $observ);
		$this->cartera_historial($id_cliente);
	}
	public function registrar_inactivo()
    {		
		 $id_cliente = $this->input->post('id_cliente_inactivo');
		 $inactivo = $this->input->post('inactivo');
		  
		 //Datos del cliente
		 if($inactivo==1){
			$valor=0;
		 }else{
			 $valor =1;
		 }
		$regis = $this->M_configuracion->registrar_inactivo($id_cliente, $valor); 

		$this->cartera_historial($id_cliente);
	}
	public function registrar_notas_clientes()
    {		
		 $id_cliente = $this->input->post('id_cliente1');
		 		 
		 //Datos del cliente
		 
		 $notas = $this->input->post('notas');
		 $user = $this->ion_auth->user()->row();
		 $id_usuario=$user->id;				 	 

		$regis = $this->M_configuracion->registrar_notas_clientes($id_cliente, $notas, $id_usuario); 

		$this->cartera_historial($id_cliente);
	}
	public function registrar_notas_clientes1()
    {		
		 $id_cliente = $this->input->post('id_cliente1');
		 		 
		 //Datos del cliente
		 
		 $notas = $this->input->post('notas');
		 $user = $this->ion_auth->user()->row();
		 $id_usuario=$user->id;				 	 

		$regis = $this->M_configuracion->registrar_notas_clientes($id_cliente, $notas, $id_usuario); 

		$this->cartera_historial1($id_cliente);
	}
	public function registrar_notas_clientes_rev()
    {		
		 $id_cliente = $this->input->post('id_cliente1');
		 		 
		 //Datos del cliente
		 
		 $notas = $this->input->post('notas');
		 $user = $this->ion_auth->user()->row();
		 $id_usuario=$user->id;				 	 

		$regis = $this->M_configuracion->registrar_notas_clientes($id_cliente, $notas, $id_usuario); 

		$this->cartera_historial_rev($id_cliente);
	}
	public function registrar_notas_clientes1_rev()
    {		
		 $id_cliente = $this->input->post('id_cliente1');
		 		 
		 //Datos del cliente
		 
		 $notas = $this->input->post('notas');
		 $user = $this->ion_auth->user()->row();
		 $id_usuario=$user->id;				 	 

		$regis = $this->M_configuracion->registrar_notas_clientes($id_cliente, $notas, $id_usuario); 

		$this->cartera_historial1_rev($id_cliente);
	}
	
	public function cartera_historial($cliente)
	{
		//	Desde propuesta de misiones	
		$clientes 	= $this->M_configuracion->obt_cliente($cliente);
		$datos['cliente'] 	= $clientes->result();
		$cliente1 	= $clientes->result();
		$notificacion ="";
		if($cliente1[0]->apellidos==''){
			$notificacion = $notificacion."Datos de los apellidos vacios </br>";
		}
		if($cliente1[0]->email==''){
			$notificacion = $notificacion."Datos del email vacio </br>";
		}
		if($cliente1[0]->nro==''){
			$notificacion = $notificacion."Datos del número vacio </br>";
		}
		if($cliente1[0]->codigo_postal==''){
			$notificacion = $notificacion."Datos del código postal vacio </br>";
		}
		if($cliente1[0]->dni=='' && $cliente1[0]->cuit == ''){
			$notificacion = $notificacion."Datos del DNI y el CUIT vacios </br>";
		}
		if($notificacion != ''){
			$notificacion = '<h4><i class="icon fa fa-warning"></i>Datos importantes del cliente que debe revisar </h4></br>'.$notificacion;
		}
		$datos['notificacion'] = $notificacion;
		$datos['compras']  = $this->M_configuracion->obt_historico_compras($cliente);
		$datos['cod_seguimiento']  = $this->M_configuracion->obt_codigos_seguimientos();
		//print_r($datos['clientes']);die();
		//$datos['pedido'] 	= $pedido;	
		$provincias 	 	= $this->M_operaciones->provincias();	
		$datos['niveles'] = $this->M_configuracion->obt_niveles_vip();		
		$solicitud = $this->M_configuracion->solicitud_baja($cliente);
		if($solicitud->num_rows() != 0){
			$sol = $solicitud->row();
			$solicitud_baja=1;
			$observaciones=$sol->observaciones;
			$fallecido =$sol->fallecimiento;
		}else{
			$solicitud_baja=0;
			$observaciones="";
			$fallecido =0;
		}
		$datos['solicitud_baja'] = $solicitud_baja;
		$datos['observaciones'] = $observaciones;
		$datos['fallecido'] = $fallecido;
		$datos['provincias'] = $provincias;	
		$datos['seguimientos'] = $this->M_configuracion->obt_historico_seguimiento($cliente);	
		$datos['reclamos'] = $this->M_configuracion->obtener_notas_clientes($cliente);
		$cartera_productos = $this->M_configuracion->obt_cartera_productos($cliente);
		$datos['estado'] = $this->M_configuracion->obtener_estado_reclamos($cliente);
		$cp_id_cliente = array();
		$cp_id_producto = array();
		$cp_id_repuesto = array();
		$cp_producto = array();
		$cp_repuesto = array();
		$cp_fecha_vcto = array();
		$cp_fecha_compra = array();
		$cp_no_factura = array();
		$cp_cantidad = array();
		$cp_id_pedido = array();
		$cp_contador = 0;
		$cp_flag =0;
		
		foreach ($cartera_productos->result() as $key) {
			
			# code...
			if($cp_flag ==0){
				$cp_flag = 1;
				$cp_id_repuesto_ant = $key->id_repuesto; 
				$cp_id_cliente[$cp_contador] = $key->id_cliente; 
				$cp_id_producto[$cp_contador] = $key->id_producto; 
				$cp_id_repuesto[$cp_contador] = $key->id_repuesto; 
				$cp_producto[$cp_contador] = $key->producto; 
				$cp_repuesto[$cp_contador] = $key->repuesto; 
				$cp_fecha_vcto[$cp_contador] = $key->fecha_vcto; 
				$cp_fecha_compra[$cp_contador] = $key->fecha_compra; 
				$cp_no_factura[$cp_contador] = $key->no_factura; 
				$cp_cantidad[$cp_contador] = $key->cantidad; 
				$cp_id_pedido[$cp_contador] = $key->id_pedido; 
				$cp_contador++;
			}else{
				if($cp_id_repuesto_ant != $key->id_repuesto){
					$cp_id_cliente[$cp_contador] = $key->id_cliente; 
					$cp_id_producto[$cp_contador] = $key->id_producto; 
					$cp_id_repuesto[$cp_contador] = $key->id_repuesto; 
					$cp_producto[$cp_contador] = $key->producto; 
					$cp_repuesto[$cp_contador] = $key->repuesto; 
					$cp_fecha_vcto[$cp_contador] = $key->fecha_vcto; 
					$cp_fecha_compra[$cp_contador] = $key->fecha_compra; 
					$cp_no_factura[$cp_contador] = $key->no_factura; 
					$cp_cantidad[$cp_contador] = $key->cantidad; 
					$cp_id_pedido[$cp_contador] = $key->id_pedido;
					$cp_id_repuesto_ant = $key->id_repuesto; 
					$cp_contador++;
				}
			}

		}
		
		$datos['cp_id_cliente'] = $cp_id_cliente;
		$datos['cp_id_producto'] = $cp_id_producto;
		$datos['cp_id_repuesto'] = $cp_id_repuesto;
		$datos['cp_producto'] = $cp_producto;
		$datos['cp_repuesto'] = $cp_repuesto;
		$datos['cp_fecha_vcto'] = $cp_fecha_vcto;
		$datos['cp_fecha_compra'] = $cp_fecha_compra;
		$datos['cp_no_factura'] = $cp_no_factura;
		$datos['cp_cantidad'] = $cp_cantidad;
		$datos['cp_id_pedido'] = $cp_id_pedido;

		$datos['causa_reclamos'] = $this->M_configuracion->obt_causa_reclamos();
		$datos['repuesto_productos'] = $this->M_configuracion->obtener_repuestos_productos();
		$datos['opciones'] = $this->M_configuracion->obtener_opciones_seguimiento();
		
		$datos['modo_edicion'] = false;
		$dias=$this->M_configuracion->get_configuracion('DIAS_MISION');
		$dias=$dias[0];
		$resultado=$this->M_configuracion->bloquear_cliente($cliente);
		$datos['dias'] = $dias->valor;

		
		$this->load->view('lte_header', $datos);
		$this->load->view('v_cartera_historial', $datos);
		$this->load->view('lte_footer', $datos);	
	}
	
	public function modificar_mision_cartera()
	{
		$data = array(
			'mision' 	=> 		0     
		);		
		$this->session->set_userdata($data);

		$id_cliente = $this->input->post('id_cliente2'); 
		$contador = $this->input->post('contador');
		 
		$exitosa = $this->input->post('exitosa');
		$opcion = $this->input->post('sel_opciones');
		$notas = $this->input->post('notas');
		$fecha_notificacion = $this->input->post('fecha_notificacion');
		$recuerdame = $this->input->post('recuerdame');
		
		if($recuerdame){

		}else{
			$fecha_notificacion= null;
		}
		$exitosa = $this->input->post('exitosa');
		$pedido = array();
		$repuesto = array();
		$baja = array();
		$compra = array();
		$cantidad = array();
		$descuento = array();
		$va_contador = 0;
		$user = $this->ion_auth->user()->row();
		$id_usuario = $user->id;
		$id_pedido_mision=$this->input->post('pedido1');
		if($exitosa == 2){
			// en seguimiento
			$registrado1 = $this->M_configuracion->desbloquear_cliente($id_cliente);
			$registrado1 = $this->M_configuracion->cliente_en_mision($id_cliente);
			$registrado = $this->M_configuracion->cartera_esta_activo($id_cliente);
			if($registrado == 0){
				//nueva mision y nuevo seguimiento
				$fecha_inicio = date(" Y-m-d H:i:s ");
				$fecha_final = date('Y-m-d H:i:s',mktime(0,0,0,date('m'),date('d' )+5, date('Y')));
				
				$registrado = $this->M_configuracion->registrar_mision($id_usuario, $id_cliente, $fecha_inicio, $fecha_final, $exitosa, $notas, $id_pedido_mision);
				$registrado1 = $this->M_configuracion->cliente_en_mision($id_cliente);
				$mision= $this->M_configuracion->cartera_mision_activa($id_cliente);
				
				$resultado = $this->M_operaciones->registrar_mision_seguimiento1($mision[0]->id_mision, $notas,$fecha_notificacion, $opcion);
			}else{
				//nuevo seguimiento a la mision existente
				$mision= $this->M_configuracion->cartera_mision_activa($id_cliente);
				$resultado = $this->M_operaciones->registrar_mision_seguimiento1($mision[0]->id_mision, $notas,$fecha_notificacion, $opcion);
			}
			$observ = 'Seguimiento';
			$this->M_operaciones->set_llamadas($id_usuario,$id_cliente,  $observ);
			$this->misiones_propuestas_filtradas();
		}else{
			if($exitosa == 1){
				//se va a realizar la compra
				$c=0;
				for ($i=0; $i < $contador; $i++) { 
					# code...
					$conta=$i + 1;
					$va_compra= $this->input->post('compra'.$conta);
					$id_repuesto =  $this->input->post('repuesto'.$conta);
					$id_producto =  $this->input->post('producto'.$conta);
					$va_cantidad =  $this->input->post('cantidad'.$conta);
					$va_descuento =  $this->input->post('descuento'.$conta);
					$va_baja= $this->input->post('baja'.$conta);	
					$va_pedido= $this->input->post('pedido'.$conta);				
					
					if($va_baja){
						$respuesta = $this->M_configuracion->baja_pedido($va_pedido,$id_producto);
					}else{// si no esta de baja pregunto por si es compra
						if($va_compra){
							$repuesto[$c] = $id_repuesto;
							$cantidad[$c] = $va_cantidad;
							$descuento[$c] = $va_descuento;
							$c++;
							$va_contador = $c;
						}
					}
					
				}
				if( $c == 0){
					$this->cartera_historial($id_cliente);
				}else{
					$registrado1 = $this->M_configuracion->desbloquear_cliente($id_cliente);
					$registrado1 = $this->M_configuracion->cliente_en_mision($id_cliente);
					$data = array(
						'mision' 	=> 		1,
						'contador' 	=> 		$va_contador,
						'repuesto'		=>		$repuesto ,
						'cantidad'       => $cantidad       
						);		
					$this->session->set_userdata($data);
					$registrado = $this->M_configuracion->cartera_esta_activo($id_cliente);
					if($registrado == 0){
						//nueva mision y nueva venta
						$fecha_inicio = date(" Y-m-d H:i:s ");
						$fecha_final = date('Y-m-d H:i:s',mktime(0,0,0,date('m'),date('d' )+5, date('Y')));
						$registrado = $this->M_configuracion->registrar_mision($id_usuario, $id_cliente, $fecha_inicio, $fecha_final, $exitosa, $notas, $id_pedido_mision);
		
						$mision= $this->M_configuracion->cartera_mision_activa($id_cliente);
						
						//$resultado = $this->M_operaciones->registrar_mision_seguimiento($mision[0]->id_mision, 'Se comenzó un proceso de venta');
					}else{
						//nuevo seguimiento a la mision existente
						$mision= $this->M_configuracion->cartera_mision_activa($id_cliente);
						//$resultado = $this->M_operaciones->registrar_mision_seguimiento($mision[0]->id_mision, 'Se comenzó un proceso de venta');
					}
		
					header ("Location: ". base_url()."nueva_venta_mision/".$id_cliente."/".$id_pedido_mision);
				}
			}
		} 
        //$registrado = $this->M_configuracion->registrar_nuevo_hallazgo($id_mision, $notas, $id_clasificacion);
	   /* if ($registrado== 1)
		{ 
			$this->notificacion = "La misión se registró satisfactoriamente.";
			 $this->notificacion_error = false;
			 $this->misiones_propuestas();
		 }
		 else
		 {
			 $this->notificacion = "ERROR. No se pudo registrar la misión.";
			 $this->notificacion_error = true;
		 }	*/
		// $this->cartera_historial($id_cliente);
	}
	//*********  Cartera de clientes ++++++++++++++++++++++++++++++++++++++++*/
	public function cartera_historial1($cliente)
	{	$datos['id_cliente']= $cliente;
		//	Desde propuesta de misiones	
		$clientes 	= $this->M_configuracion->obt_cliente($cliente);
		$datos['cliente'] 	= $clientes->result();
		$cliente1 	= $clientes->result();
		$notificacion ="";
		if($cliente1[0]->apellidos==''){
			$notificacion = $notificacion."Datos de los apellidos vacios </br>";
		}
		if($cliente1[0]->email==''){
			$notificacion = $notificacion."Datos del email vacio </br>";
		}
		if($cliente1[0]->nro==''){
			$notificacion = $notificacion."Datos del número vacio </br>";
		}
		if($cliente1[0]->codigo_postal==''){
			$notificacion = $notificacion."Datos del código postal vacio </br>";
		}
		if($cliente1[0]->dni=='' && $cliente1[0]->cuit == ''){
			$notificacion = $notificacion."Datos del DNI y el CUIT vacios </br>";
		}
		if($notificacion != ''){
			$notificacion = '<h4><i class="icon fa fa-warning"></i>Datos importantes del cliente que debe revisar </h4></br>'.$notificacion;
		}
		$datos['notificacion'] = $notificacion;
		$datos['compras']  = $this->M_configuracion->obt_historico_compras($cliente);
		//print_r($datos['clientes']);die();
		//$datos['pedido'] 	= $pedido;	
		$provincias 	 	= $this->M_operaciones->provincias();	
		$datos['niveles'] = $this->M_configuracion->obt_niveles_vip();		
		$solicitud = $this->M_configuracion->solicitud_baja($cliente);
		if($solicitud->num_rows() != 0){
			$sol = $solicitud->row();
			$solicitud_baja=1;
			$observaciones=$sol->observaciones;
			$fallecido=$sol->fallecimiento;
			
		}else{
			$solicitud_baja=0;
			$observaciones="";
			$fallecido=0;
		}
		$datos['solicitud_baja'] = $solicitud_baja;
		$datos['observaciones'] = $observaciones;
		$datos['fallecido'] = $fallecido;
		$datos['provincias'] = $provincias;	
		$datos['seguimientos'] = $this->M_configuracion->obt_historico_seguimiento($cliente);	
		$datos['reclamos'] = $this->M_configuracion->obtener_notas_clientes($cliente);
		$cartera_productos = $this->M_configuracion->obt_cartera_productos($cliente);
		$cp_id_cliente = array();
		$cp_id_producto = array();
		$cp_id_repuesto = array();
		$cp_producto = array();
		$cp_repuesto = array();
		$cp_fecha_vcto = array();
		$cp_fecha_compra = array();
		$cp_no_factura = array();
		$cp_cantidad = array();
		$cp_id_pedido = array();
		$cp_contador = 0;
		$cp_flag =0;
		foreach ($cartera_productos->result() as $key) {
			# code...
			if($cp_flag ==0){
				$cp_flag = 1;
				$cp_id_repuesto_ant = $key->id_repuesto; 
				$cp_id_cliente[$cp_contador] = $key->id_cliente; 
				$cp_id_producto[$cp_contador] = $key->id_producto; 
				$cp_id_repuesto[$cp_contador] = $key->id_repuesto; 
				$cp_producto[$cp_contador] = $key->producto; 
				$cp_repuesto[$cp_contador] = $key->repuesto; 
				$cp_fecha_vcto[$cp_contador] = $key->fecha_vcto; 
				$cp_fecha_compra[$cp_contador] = $key->fecha_compra; 
				$cp_no_factura[$cp_contador] = $key->no_factura; 
				$cp_cantidad[$cp_contador] = $key->cantidad; 
				$cp_id_pedido[$cp_contador] = $key->id_pedido; 
				$cp_contador++;
			}else{
				if($cp_id_repuesto_ant != $key->id_repuesto){
					$cp_id_cliente[$cp_contador] = $key->id_cliente; 
					$cp_id_producto[$cp_contador] = $key->id_producto; 
					$cp_id_repuesto[$cp_contador] = $key->id_repuesto; 
					$cp_producto[$cp_contador] = $key->producto; 
					$cp_repuesto[$cp_contador] = $key->repuesto; 
					$cp_fecha_vcto[$cp_contador] = $key->fecha_vcto; 
					$cp_fecha_compra[$cp_contador] = $key->fecha_compra; 
					$cp_no_factura[$cp_contador] = $key->no_factura; 
					$cp_cantidad[$cp_contador] = $key->cantidad; 
					$cp_id_pedido[$cp_contador] = $key->id_pedido;
					$cp_id_repuesto_ant = $key->id_repuesto; 
					$cp_contador++;
				}
			}

		}
		
		$datos['cp_id_cliente'] = $cp_id_cliente;
		$datos['cp_id_producto'] = $cp_id_producto;
		$datos['cp_id_repuesto'] = $cp_id_repuesto;
		$datos['cp_producto'] = $cp_producto;
		$datos['cp_repuesto'] = $cp_repuesto;
		$datos['cp_fecha_vcto'] = $cp_fecha_vcto;
		$datos['cp_fecha_compra'] = $cp_fecha_compra;
		$datos['cp_no_factura'] = $cp_no_factura;
		$datos['cp_cantidad'] = $cp_cantidad;
		$datos['cp_id_pedido'] = $cp_id_pedido;

		$datos['causa_reclamos'] = $this->M_configuracion->obt_causa_reclamos();
		$datos['repuesto_productos'] = $this->M_configuracion->obtener_repuestos_productos();
		$datos['cod_seguimiento']  = $this->M_configuracion->obt_codigos_seguimientos();
		$datos['modo_edicion'] = false;
		$dias=$this->M_configuracion->get_configuracion('DIAS_MISION');
		$dias=$dias[0];
		//$resultado=$this->M_configuracion->bloquear_cliente($cliente);
		$datos['dias'] = $dias->valor;
		$datos['estado'] = $this->M_configuracion->obtener_estado_reclamos($cliente);

		$this->load->view('lte_header', $datos);
		$this->load->view('v_cartera_historial1', $datos);
		$this->load->view('lte_footer', $datos);	
	}
	public function modificar_cliente_cartera1()
    {
		$id_actual = $this->input->post('id_cliente');		 
		$id_cliente = $this->input->post('id_cliente');
				 
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
		$cuit 			= 	 $this->input->post('cuit');	 
		$codigo_postal	= 	 $this->input->post('codigo_postal');	 
		$observaciones1 = 	 $this->input->post('observaciones1');
	   //////////////////////////////////////////////////////////////////////////
	   if($this->input->post('solicitud_baja')){
		   $solicitud_baja = 1;
		   $observaciones =  $this->input->post('observaciones');
		   $opcion_baja =  $this->input->post('opcion_baja');
			if($opcion_baja){
				$fallecido =1;
			}else{
				$fallecido =0;
			}
		   $solicitud = $this->M_configuracion->solicitud_baja($id_cliente);			
		   if($solicitud->num_rows() == 0){				
			   $user = $this->ion_auth->user()->row();				
			   $resul1 = $this->M_configuracion->registrar_solicitud_baja($user->id, $id_cliente, $observaciones,$fallecido);
		   }
	   }else{
			$solicitud_baja = 0;
			$observaciones = "";
			$solicitud = $this->M_configuracion->solicitud_baja($id_cliente);			
			if($solicitud->num_rows() <> 0){				
				$user = $this->ion_auth->user()->row();				
				$resul1 = $this->M_configuracion->cancelar_solicitud_baja($id_cliente);
			}
	   }		
	   
	   if($this->input->post('vip')){
		  $vip = 1;
	  }else{
		  $vip = 0;
	  }		 
	   $nivel 			= $this->input->post('nivel');	   			
	   
	   
	   /////////////////////////////////////////////////////////////////////////
	   $regis = $this->M_configuracion->modificar_cartera_cliente($id_cliente, $dni, $municipio, $nombre,$apellidos, $telefono,$celular, $email, $codigo_postal, $calle, $nro, $piso, $dpto, $entrecalle1, $entrecalle2,  $vip, $nivel, $observaciones1, $cuit);


		$regis = $this->cartera_historial1($id_cliente);
	}
	public function registrar_reclamos1()
    {		
		$id_cliente = $this->input->post('id_cliente_reclamo');
		 		 
		 //Datos del cliente
		 $causa = $this->input->post('sel_causas');
		 $notas = $this->input->post('notas');
		 $user = $this->ion_auth->user()->row();
		 $id_usuario=$user->id;
				 	 

		$regis = $this->M_configuracion->registrar_reclamos($id_cliente, $causa,$notas, $id_usuario); 

		$this->cartera_historial1($id_cliente);
	}
	public function cartera_realizo_cambio($id_cliente,$id_producto)
	{
		$productos = $this->M_configuracion->obt_repuestos_solos();
		//$colores = $this->M_configuracion->obt_colores();
		$datos['id_cliente']= $id_cliente;
		$clientes 	= $this->M_configuracion->obt_cliente($id_cliente);
		$datos['cliente'] 	= $clientes->result();		
		$datos['productos'] = $productos;
		$datos['id_producto'] = $id_producto;
		//$datos['colores'] 	= $colores;
		$datos['notificacion'] = 'Agregando nueva venta' ;
		$datos['notificacion_error'] = false ;
		$datos['modo_edicion'] = false;
		$this->load->view('lte_header', $datos);
		$this->load->view('v_agregar_pedidos', $datos);
		$this->load->view('lte_footer', $datos);
	}
	public function cartera_adicionar_producto($id_cliente)
	{
		$productos = $this->M_configuracion->obt_repuestos_solos();
		//$colores = $this->M_configuracion->obt_colores();
		$datos['id_cliente']= $id_cliente;
		$clientes 	= $this->M_configuracion->obt_cliente($id_cliente);
		$datos['cliente'] 	= $clientes->result();		
		$datos['productos'] = $productos;
		
		//$datos['colores'] 	= $colores;
		$datos['notificacion'] = 'Agregando nueva venta' ;
		$datos['notificacion_error'] = false ;
		$datos['modo_edicion'] = false;
		$this->load->view('lte_header', $datos);
		$this->load->view('v_agregar_pedidos1', $datos);
		$this->load->view('lte_footer', $datos);
	}
	
	//*******************************************************************************************************
	//     Gestion de locales
	//*******************************************************************************************************
    // Interfaz para registrar un nueva configuracion
	public function nuevo_local()
	{		
		$datos['notificacion'] = "Especifique los datos de la nueva configuracion:";
		$datos['modo_edicion'] = false;
		$datos['notificacion_error'] = $this->notificacion_error;
		
		$this->load->view('lte_header', $datos);
		$this->load->view('v_locales', $datos);
		$this->load->view('lte_footer', $datos);	
	}
	/********************************************************************************************************************/
	// Editando la configuracion
	public function editar_local($id_actual)
	{
		$resultado = $this->M_configuracion->obt_local($id_actual);
		
		if ($resultado)
		{
		   $local = $resultado->row();
		   
		   $id_local = $local->id;
		   $descripcion = $local->nombre;
		  
		   $datos['modo_edicion'] = true;
		   $datos['notificacion'] = 'Modificando los datos de la configuracion ' . $id_local . ' ' . $descripcion;
		   $datos['notificacion_error'] = $this->notificacion_error;
		   
		   $datos['id_actual']    = $id_actual;
		   $datos['id_local']    = $id_local;
		   $datos['descripcion']  = $descripcion;
		  
		}
		
		$this->load->view('lte_header', $datos);
 	    $this->load->view('v_locales', $datos);
	    $this->load->view('lte_footer', $datos);
	}
	
	/********************************************************************************************************************/
	// Confirmar eliminación de una configuracion
	public function cfe_local($parametro)
	{
		$datos['id_local'] = $parametro;
		
		$this->load->view('lte_header', $datos);
 	    $this->load->view('vcan_locales', $datos);
	    $this->load->view('lte_footer', $datos);
	}
	/********************************************************************************************************************/
	// Cancelar configuracion
    public function cancelar_local()
	{
		$parametro = $this->input->post('id_local');
		$cancelado = $this->M_configuracion->cancelar_local($parametro);
		
		if ($cancelado == 1)
	    { 
		   $this->not_fcliente = "Se eliminó la configuracion correctamente.";
		}
		else
		{
		   $this->not_fcliente = "ERROR. No se pudo eliminar la configuracion. Verifique los datos especificados.";
		}
		
		$this->locales();

	}
	/********************************************************************************************************************/
	// Listado de configuracion
    public function locales()
	{
		$locales = $this->M_configuracion->obt_locales();	
        $datos['locales'] = $locales;
		$datos['total_locales'] = $this->M_configuracion->total_locales();
        
		$this->load->view('lte_header', $datos);
		$this->load->view('v_listado_locales', $datos);
		$this->load->view('lte_footer', $datos);

	}
	/********************************************************************************************************************/
	// Registrando un configuracion
    public function registrar_local()
    {
		 
		 $descripcion = $this->input->post('descripcion');
		 		 
		 $this->load->library('form_validation');		 
		 
		 $this->form_validation->set_rules('descripcion', 'Descripcion', 'required');
		 
		 if ($this->form_validation->run() == true )
		 {		 
			 $registrado = $this->M_configuracion->registrar_local( $descripcion);
			 
			 $mensaje = "";
			 if ($registrado == 1)
				 { 
					 $this->notificacion = "El local se registró satisfactoriamente.";
		             $this->notificacion_error = false;
					 
				 }
				 else
				 {
					 $this->notificacion = "ERROR. No se pudo registrar el local";
		             $this->notificacion_error = true;
				 }
				 
		 }
		 else
		 {
		     $this->notificacion = validation_errors();
			 $this->notificacion_error = true;
			 
		 }
		 if($this->notificacion_error == true){	
		   
		   $datos['id_local']    = $id_local;
		   $datos['descripcion']  = $descripcion;

			$datos['notificacion'] = $this->notificacion ? $this->notificacion : "Error registrando el local" . $descripcion;
          	$datos['notificacion_error'] = $this->notificacion_error;
			$datos['modo_edicion'] = false;

			$this->load->view('lte_header', $datos);
			$this->load->view('v_locales', $datos);
			$this->load->view('lte_footer', $datos);  
		 
		 }else
		 $this->locales();
		 
		 
    }
	/********************************************************************************************************************/
	// Modificando un configuracion
    public function modificar_local()
    {
		 $id_actual = $this->input->post('id_actual');		
		 $descripcion = $this->input->post('descripcion');
		 
		 $this->load->library('form_validation');		 
		
		 $this->form_validation->set_rules('descripcion', 'Descripcion', 'required');
		 
		 if ($this->form_validation->run() == true )
		 {
		 
			 $modificado = $this->M_configuracion->modificar_local($id_actual,  $descripcion);
			 
   		     if ($modificado == 1)
			 { 
				 $this->notificacion = "El local se modificó satisfactoriamente.";
		         $this->notificacion_error = false;
			 }
			 else
			 {
				 $this->notificacion = "ERROR. No se pudo modificar el local. Verifique los datos especificados.";
		         $this->notificacion_error = true;
		 }
				 
		 }
		 else
		 {
		     $this->notificacion = validation_errors();
			 $this->notificacion_error = true;
			 
		 }
		 if($this->notificacion_error == true){		
			
			$datos['id_actual']    = $id_actual;
		    $datos['descripcion']  = $descripcion;
			
			$datos['notificacion'] = $this->notificacion ? $this->notificacion : "Error modificando la configuración" . $descripcion;
          	$datos['notificacion_error'] = $this->notificacion_error;
			$datos['modo_edicion'] = true;
			
			$this->load->view('lte_header', $datos);
			$this->load->view('v_locales', $datos);
			$this->load->view('lte_footer', $datos); 
			 
		 }else
		 
		 $this->locales();
	}
	// Listado de configuracion
    public function reclamos()
	{
		$reclamos = $this->M_configuracion->obtener_reclamos();	
        $datos['reclamos'] = $reclamos;
		$datos['total_reclamos'] = $this->M_configuracion->total_reclamos();
		$datos['total_reclamos_abiertos'] = $this->M_configuracion->obtener_reclamos_abiertos();
		$datos['total_reclamos_cerrados'] = $this->M_configuracion->obtener_reclamos_cerrados();
        $datos['ultimo_reclamo'] = $this->M_configuracion->obt_ultimos_reclamos();
		$this->load->view('lte_header', $datos);
		$this->load->view('v_listado_reclamos', $datos);
		$this->load->view('lte_footer', $datos);

	}
    public function obt_reclamos_seguimiento($id_reclamo)
	{
		$notas = $this->M_configuracion->obt_todas_notas_reclamo($id_reclamo);
		$datos['notificaciones'] = $notas;
		
		$datos_cliente = $this->M_configuracion->obt_datos_cliente_reclamo($id_reclamo);
		$datos['datos_cliente'] = $datos_cliente;
		
		$datos['id_reclamo'] = $id_reclamo;
		$datos['total_notificaciones'] = $notas->num_rows();

		$this->load->view('lte_header', $datos);
		$this->load->view('v_listado_reclamo_seguimiento', $datos);
	   $this->load->view('lte_footer', $datos);

	}
    public function obt_reclamos_seguimiento1($id_reclamo, $usuario)
	{
		$notas = $this->M_configuracion->obt_todas_notas_reclamo($id_reclamo);
		$datos['notificaciones'] = $notas;
		
		$datos_cliente = $this->M_configuracion->obt_datos_cliente_reclamo($id_reclamo);
		$datos['datos_cliente'] = $datos_cliente;
		
		$datos['id_reclamo'] = $id_reclamo;
		$datos['usuario'] = $usuario;
		$datos['total_notificaciones'] = $notas->num_rows();

		$this->load->view('lte_header', $datos);
		$this->load->view('v_listado_reclamo_seguimiento1', $datos);
	   $this->load->view('lte_footer', $datos);

	}
    public function nueva_nota_reclamo($id_reclamo)
	{
		$datos['notificacion'] = '';
		$datos['notificacion_error'] = '';
		$datos['modo_edicion'] = false;
		$datos['id_reclamo'] = $id_reclamo;

		$this->load->view('lte_header', $datos);
		$this->load->view('v_nota_reclamo', $datos);
	   $this->load->view('lte_footer', $datos);

	}
	public function registrar_nota_reclamo()
    {		
		$id_reclamo = $this->input->post('id_reclamo');
		$nota = $this->input->post('nota');
		$preventiva = $this->input->post('preventiva');
		$cerrado = $this->input->post('cerrado');
		$user = $this->ion_auth->user()->row(); //usuario registrado
		$userid = $user->id;
		if($cerrado){
			$resu = $this->M_configuracion->cerrar_reclamo($id_reclamo, $userid);
		}
		$resultado = $this->M_configuracion->registrar_nota_reclamo($id_reclamo, $nota, $preventiva, $userid);
		$this->obt_reclamos_seguimiento($id_reclamo);
	}
	// Listado de configuracion
    public function ventas_locales()
	{
		$fecha_inicio = date('Y-m-d H:i:s',mktime(0,0,0,date('m'),1, date('Y')));
		$fecha_final = date(" Y-m-d H:i:s ");
		
		$productos = $this->M_configuracion->obtener_productos_locales($fecha_inicio, $fecha_final);	
		$datos['fecha_inicio'] = $fecha_inicio;
		$datos['fecha_final'] = $fecha_final;
		$datos['productos'] = $productos;
        
		$this->load->view('lte_header', $datos);
		$this->load->view('v_listado_productos_locales', $datos);
		$this->load->view('lte_footer', $datos);

	}
	public function ventas_locales_filtro()
	{
		$fecha_inicio = $this->input->post('fecha_inicio');
		$fecha_final = $this->input->post('fecha_final');
		
		$productos = $this->M_configuracion->obtener_productos_locales($fecha_inicio, $fecha_final);	
		$datos['fecha_inicio'] = $fecha_inicio;
		$datos['fecha_final'] = $fecha_final;
		$datos['productos'] = $productos;
        
		$this->load->view('lte_header', $datos);
		$this->load->view('v_listado_productos_locales', $datos);
		$this->load->view('lte_footer', $datos);

	}
	public function clientes_consultor_rev()
	{

	   if ($this->session->userdata('perfil') == false || $this->session->userdata('perfil') != 'emprendedor') {
            redirect(base_url() . 'login');
        }

	     $id_emp                 = $this->session->userdata('id_emp'); 
	     $data['cant_asoc']      = $this->modelogeneral->rowCountAsoc($id_emp);
	     $data['result']         = $this->modelogeneral->mostrar_asoc($id_emp);
	     $data['datos_emp']      = $this->modelogeneral->datos_emp($id_emp);
	     $data['ultimo_reg']     = $this->modelogeneral->las_insetCap(); 
	     $data['cantidadVideos'] = $this->modelogeneral->rowCount("capacitacion");
	     $data['sumatoriaComp']  = $this->modelogeneral->sumatoriaCompraEmp($id_emp);
	     $data['cantidad_prod']  = $this->modelogeneral->count_cantProdCar($id_emp); 
        
		$datos['notificacion'] = 'vacio';
		$datos['notificacion_error'] = false;
		$clientes = $this->M_configuracion->clientes_revendedores($id_emp);	
        $datos['clientes'] = $clientes;
		$datos['total_clientes'] = $clientes->num_rows();
		$resultado = $this->M_configuracion->obt_paises();
		$datos['paises'] = $resultado;
		$id_pais = $this->M_operaciones->obt_rev_pais($id_emp);		
		$datos['id_pais'] = $id_pais;
		$productos 				= $this->M_operaciones->productos_rev();

		//mis productos dagner
		
		$datos['productos'] = $productos;

		$datos['productos_list'] = $this->modelogeneral->listar_productos();
		
		$this->load->view("layout/header",$data);
	    $this->load->view("layout/side_menu",$data);
	    $this->load->view('v_importadas/v_listado_clientes_consultor_rev', $datos);
	    $this->load->view("layout/footer");  

		
		
		
	}



	public function clientes_consultor_revInt()
	{
		$user = $this->ion_auth->user()->row();			
		$id_usuario = $user->id;
		$datos['id_usuario'] = $user->id;
		$datos['notificacion'] = 'vacio';
		$datos['notificacion_error'] = false;
		$clientes = $this->M_configuracion->clientes_revendedores($user->id);	
        $datos['clientes'] = $clientes;
		$datos['total_clientes'] = $clientes->num_rows();
		/*$datos['total_clientes_mision'] = $this->M_configuracion->total_clientes_mision();
		$datos['total_clientes_operacion'] = $this->M_configuracion->total_clientes_operacion();
		$datos['total_clientes_cancelados'] = $this->M_configuracion->total_clientes_cancelados();
		$datos['niveles'] = $this->M_configuracion->obt_niveles_vip();*/
		$resultado = $this->M_configuracion->obt_paises();
		$datos['paises'] = $resultado;
		$id_pais = $this->M_operaciones->obt_rev_pais($id_usuario);		
		$datos['id_pais'] = $id_pais;
		$productos 				= $this->M_operaciones->productos_rev();
		$datos['productos'] = $productos;
		$this->load->view('lte_header', $datos);
		$this->load->view('v_listado_clientes_consultor_revInt', $datos);
		$this->load->view('lte_footer', $datos);
	}
	public function registrar_cliente_rev()
	{
		# code...
		$municipio		= $this->input->post('sel_municipios');
		$dni			= $this->input->post('dni');
		$nombre 		= $this->input->post('nombre');
		$telefono 		= $this->input->post('telefono');
		$apellidos 		= $this->input->post('apellidos');
		$email 			= $this->input->post('email');
		$celular 		= $this->input->post('celular');
		$calle 			= $this->input->post('calle');
		$dpto 			= "no";//$this->input->post('dpto');
		$entrecalle1 	= "no";//$this->input->post('entrecalle1');
		$entrecalle2 	= "no";//$this->input->post('entrecalle2');
		$nro 			= "no";//$this->input->post('nro');
		$fecha_nacimiento = $this->input->post('fecha_nacimiento');
		$codigo_postal 	= "no";//$this->input->post('codigo_postal');
		$piso 			= "no";//$this->input->post('piso');
		$cuit 			= "no";//$this->input->post('cuit');
		$fecha_compra 	= $this->input->post('fecha_compra');
		$producto 		= $this->input->post('sel_productos');
		$cantidad 		= $this->input->post('cantidad');
	
		
		$this->form_validation->set_rules('sel_municipios', 'Municipio', 'required');
		//$this->form_validation->set_rules('dni', 'DNI', 'required');
		$this->form_validation->set_rules('nombre', 'Nombre', 'required');
		$this->form_validation->set_rules('apellidos', 'Apellidos', 'required');
		//$this->form_validation->set_rules('telefono', 'Telefono', 'required');
		$this->form_validation->set_rules('calle', 'Calle', 'required');
		$this->form_validation->set_rules('sel_productos', 'Productos', 'required');
		$this->form_validation->set_rules('cantidad', 'Cantidad', 'required|numeric');
				
		$consecutivo 			= $this->obtener_parametro('CODIGO_PEDIDO') . '-' . $this->obtener_parametro('CONSECUTIVO_VENTA');
		if ($this->form_validation->run() == true )
		{
			$resultado= $this->M_configuracion->registrar_cliente_rev($municipio,$dni,$nombre,$apellidos, $telefono, $email, $celular, $calle, $dpto, $entrecalle1, $entrecalle2, $nro, $fecha_nacimiento, $codigo_postal, $piso, $cuit, $fecha_compra, $producto, $cantidad,$consecutivo);
			
		}else{
			$notificacion = validation_errors();
			
			$datos['notificacion'] = $notificacion;
			$datos['notificacion_error'] = true;

			$datos['municipio'] = $municipio;
			$datos['dni'] = $dni;
			$datos['nombre'] = $nombre;
			$datos['telefono'] = $telefono;
			$datos['apellidos'] = $apellidos;
			$datos['email'] = $email;
			$datos['celular'] = $celular;
			$datos['calle'] = $calle;
			$datos['dpto'] = $dpto;
			$datos['entrecalle1'] = $entrecalle1;
			$datos['entrecalle2'] = $entrecalle2;
			$datos['nro'] = $nro;
			$datos['fecha_nacimiento'] = $fecha_nacimiento;
			$datos['codigo_postal'] = $codigo_postal;
			$datos['piso'] = $piso;
			$datos['cuit'] = $cuit;
			$datos['fecha_compra'] = $fecha_compra;
			$datos['producto'] = $producto;
			$datos['cantidad'] = $cantidad;

		}
		$this->clientes_consultor_rev();
	}
	public function registrar_cliente_revInt()
	{
		# code...
		$municipio		= $this->input->post('sel_municipios');
		$dni			= $this->input->post('dni');
		$nombre 		= $this->input->post('nombre');
		$telefono 		= $this->input->post('telefono');
		$apellidos 		= $this->input->post('apellidos');
		$email 			= $this->input->post('email');
		$celular 		= $this->input->post('celular');
		$calle 			= $this->input->post('calle');
		$dpto 			= "no";//$this->input->post('dpto');
		$entrecalle1 	= "no";//$this->input->post('entrecalle1');
		$entrecalle2 	= "no";//$this->input->post('entrecalle2');
		$nro 			= "no";//$this->input->post('nro');
		$fecha_nacimiento = $this->input->post('fecha_nacimiento');
		$codigo_postal 	= "no";//$this->input->post('codigo_postal');
		$piso 			= "no";//$this->input->post('piso');
		$cuit 			= "no";//$this->input->post('cuit');
		$fecha_compra 	= $this->input->post('fecha_compra');
		$producto 		= $this->input->post('sel_productos');
		$cantidad 		= $this->input->post('cantidad');

		$this->load->library('form_validation');	 
		
		$this->form_validation->set_rules('sel_municipios', 'Municipio', 'required');
		//$this->form_validation->set_rules('dni', 'DNI', 'required');
		$this->form_validation->set_rules('nombre', 'Nombre', 'required');
		$this->form_validation->set_rules('apellidos', 'Apellidos', 'required');
		//$this->form_validation->set_rules('telefono', 'Telefono', 'required');
		$this->form_validation->set_rules('calle', 'Calle', 'required');
		$this->form_validation->set_rules('sel_productos', 'Productos', 'required');
		$this->form_validation->set_rules('cantidad', 'Cantidad', 'required|numeric');
				
		$consecutivo 			= $this->obtener_parametro('CODIGO_PEDIDO') . '-' . $this->obtener_parametro('CONSECUTIVO_VENTA');
		if ($this->form_validation->run() == true )
		{
			$resultado= $this->M_configuracion->registrar_cliente_revint($municipio,$dni,$nombre,$apellidos, $telefono, $email, $celular, $calle, $dpto, $entrecalle1, $entrecalle2, $nro, $fecha_nacimiento, $codigo_postal, $piso, $cuit, $fecha_compra, $producto, $cantidad,$consecutivo);
			
		}else{
			$notificacion = validation_errors();
			
			$datos['notificacion'] = $notificacion;
			$datos['notificacion_error'] = true;

			$datos['municipio'] = $municipio;
			$datos['dni'] = $dni;
			$datos['nombre'] = $nombre;
			$datos['telefono'] = $telefono;
			$datos['apellidos'] = $apellidos;
			$datos['email'] = $email;
			$datos['celular'] = $celular;
			$datos['calle'] = $calle;
			$datos['dpto'] = $dpto;
			$datos['entrecalle1'] = $entrecalle1;
			$datos['entrecalle2'] = $entrecalle2;
			$datos['nro'] = $nro;
			$datos['fecha_nacimiento'] = $fecha_nacimiento;
			$datos['codigo_postal'] = $codigo_postal;
			$datos['piso'] = $piso;
			$datos['cuit'] = $cuit;
			$datos['fecha_compra'] = $fecha_compra;
			$datos['producto'] = $producto;
			$datos['cantidad'] = $cantidad;

		}
		$this->clientes_consultor_revInt();
	}
	 public function clientes_consultor_revInt_filtrados()
	{
		$user = $this->ion_auth->user()->row();			
		$datos['id_usuario'] = $user->id;
		$id_usuario = $user->id;
		$datos['notificacion'] = 'vacio';
		$datos['notificacion_error'] = false;
		$dni= $this->input->post('fil_dni');
		$nombre = $this->input->post('fil_nombre');
		$telefono = $this->input->post('fil_telefono');
		$apellidos = $this->input->post('fil_apellidos');
		$email = $this->input->post('fil_email');
		$celular = $this->input->post('fil_celular');

		$dni		= trim($dni);
		$nombre 	= trim($nombre);
		$telefono 	= trim($telefono);
		$apellidos 	= trim($apellidos);
		$email 		= trim($email);
		$celular 	= trim($celular);

		if($nombre == ''){
			$nombre ='*';
		}
		if($telefono == ''){
			$telefono ='*';
		}
		if($dni == ''){
			$dni ='*';
		}
		if($apellidos ==''){
			$apellidos='*';
		}
		if($email ==''){
			$email='*';
		}
		if($celular ==''){
			$celular='*';
		}
		$clientes = $this->M_configuracion->clientes_revendedores($user->id);	        
		$datos['total_clientes'] = $clientes->num_rows();

		$clientes = $this->M_configuracion->clientes_rev_filtrado($dni, $nombre, $telefono, $apellidos, $email, $celular);	
        $datos['clientes'] = $clientes;
		
		$datos['total_clientes_mision'] = $this->M_configuracion->total_clientes_mision();
		$datos['total_clientes_operacion'] = $this->M_configuracion->total_clientes_operacion();
		$datos['total_clientes_cancelados'] = $this->M_configuracion->total_clientes_cancelados();
		$resultado = $this->M_configuracion->obt_paises();
		$datos['paises'] = $resultado;
		$id_pais = $this->M_operaciones->obt_rev_pais($id_usuario);		
		$datos['id_pais'] = $id_pais;
		
		$productos 				= $this->M_operaciones->productos_rev();
		$datos['productos'] = $productos;
		$this->load->view('lte_header', $datos);
		$this->load->view('v_listado_clientes_consultor_revInt', $datos);
		$this->load->view('lte_footer', $datos);
	}
	public function misiones_rev()
	{
		$group = array('ConsultorRV', 'ConsultorRVInt');
		
		$user = $this->ion_auth->user()->row();
		if ($this->ion_auth->in_group($group)) { 			
			$revendedor = 'true'; 			
			$misiones = $this->M_configuracion->misiones_revendedores($user->id);
			
			
		}else 
		{
			$misiones = $this->M_configuracion->misiones($user->id);	
		}


		
        $datos['misiones'] = $misiones;
		//$datos['total_misiones'] = $this->M_configuracion->total_misiones();
		//$datos['total_misiones_aceptadas'] = $this->M_configuracion->total_misiones_aceptadas();
		//$datos['total_misiones_rechazadas'] = $this->M_configuracion->total_misiones_rechazadas();
		//$datos['total_clientes_mision'] = $this->M_configuracion->total_clientes_mision();
		
		$this->load->view('lte_header', $datos);
		$this->load->view('v_listado_misiones_rev', $datos);
		$this->load->view('lte_footer', $datos);
	}
	
	public function cartera_historial_rev($cliente)
	{
		//	Desde propuesta de misiones	
		$clientes 	= $this->M_configuracion->obt_cliente($cliente);
		$datos['cliente'] 	= $clientes->result();
		$cliente1 	= $clientes->result();
		$notificacion ="";
		if($cliente1[0]->apellidos==''){
			$notificacion = $notificacion."Datos de los apellidos vacios </br>";
		}
		if($cliente1[0]->email==''){
			$notificacion = $notificacion."Datos del email vacio </br>";
		}
		if($cliente1[0]->nro==''){
			$notificacion = $notificacion."Datos del número vacio </br>";
		}
		if($cliente1[0]->codigo_postal==''){
			$notificacion = $notificacion."Datos del código postal vacio </br>";
		}
		if($cliente1[0]->dni=='' && $cliente1[0]->cuit == ''){
			$notificacion = $notificacion."Datos del DNI y el CUIT vacios </br>";
		}
		if($notificacion != ''){
			$notificacion = '<h4><i class="icon fa fa-warning"></i>Datos importantes del cliente que debe revisar </h4></br>'.$notificacion;
		}
		$datos['notificacion'] = $notificacion;
		$datos['compras']  = $this->M_configuracion->obt_historico_compras($cliente);
		//print_r($datos['clientes']);die();
		//$datos['pedido'] 	= $pedido;	
		$provincias 	 	= $this->M_operaciones->provincias();	
		$datos['niveles'] = $this->M_configuracion->obt_niveles_vip();		
		$solicitud = $this->M_configuracion->solicitud_baja($cliente);
		if($solicitud->num_rows() != 0){
			$sol = $solicitud->row();
			$solicitud_baja=1;
			$observaciones=$sol->observaciones;
			$fallecido=$sol->fallecimiento;
			
		}else{
			$solicitud_baja=0;
			$observaciones="";
			$fallecido=0;
		}
		$datos['solicitud_baja'] = $solicitud_baja;
		$datos['observaciones'] = $observaciones;
		$datos['fallecido'] = $fallecido;
		$datos['provincias'] = $provincias;	
		$datos['seguimientos'] = $this->M_configuracion->obt_historico_seguimiento($cliente);	
		$datos['reclamos'] = $this->M_configuracion->obtener_notas_clientes($cliente);
		$cartera_productos = $this->M_configuracion->obt_cartera_productos($cliente);
		$cp_id_cliente = array();
		$cp_id_producto = array();
		$cp_id_repuesto = array();
		$cp_producto = array();
		$cp_repuesto = array();
		$cp_fecha_vcto = array();
		$cp_fecha_compra = array();
		$cp_no_factura = array();
		$cp_cantidad = array();
		$cp_id_pedido = array();
		$cp_contador = 0;
		$cp_flag =0;
		
		foreach ($cartera_productos->result() as $key) {
			
			# code...
			if($cp_flag ==0){
				$cp_flag = 1;
				$cp_id_repuesto_ant = $key->id_repuesto; 
				$cp_id_cliente[$cp_contador] = $key->id_cliente; 
				$cp_id_producto[$cp_contador] = $key->id_producto; 
				$cp_id_repuesto[$cp_contador] = $key->id_repuesto; 
				$cp_producto[$cp_contador] = $key->producto; 
				$cp_repuesto[$cp_contador] = $key->repuesto; 
				$cp_fecha_vcto[$cp_contador] = $key->fecha_vcto; 
				$cp_fecha_compra[$cp_contador] = $key->fecha_compra; 
				$cp_no_factura[$cp_contador] = $key->no_factura; 
				$cp_cantidad[$cp_contador] = $key->cantidad; 
				$cp_id_pedido[$cp_contador] = $key->id_pedido; 
				$cp_contador++;
			}else{
				if($cp_id_repuesto_ant != $key->id_repuesto){
					$cp_id_cliente[$cp_contador] = $key->id_cliente; 
					$cp_id_producto[$cp_contador] = $key->id_producto; 
					$cp_id_repuesto[$cp_contador] = $key->id_repuesto; 
					$cp_producto[$cp_contador] = $key->producto; 
					$cp_repuesto[$cp_contador] = $key->repuesto; 
					$cp_fecha_vcto[$cp_contador] = $key->fecha_vcto; 
					$cp_fecha_compra[$cp_contador] = $key->fecha_compra; 
					$cp_no_factura[$cp_contador] = $key->no_factura; 
					$cp_cantidad[$cp_contador] = $key->cantidad; 
					$cp_id_pedido[$cp_contador] = $key->id_pedido;
					$cp_id_repuesto_ant = $key->id_repuesto; 
					$cp_contador++;
				}
			}

		}
		
		$datos['cp_id_cliente'] = $cp_id_cliente;
		$datos['cp_id_producto'] = $cp_id_producto;
		$datos['cp_id_repuesto'] = $cp_id_repuesto;
		$datos['cp_producto'] = $cp_producto;
		$datos['cp_repuesto'] = $cp_repuesto;
		$datos['cp_fecha_vcto'] = $cp_fecha_vcto;
		$datos['cp_fecha_compra'] = $cp_fecha_compra;
		$datos['cp_no_factura'] = $cp_no_factura;
		$datos['cp_cantidad'] = $cp_cantidad;
		$datos['cp_id_pedido'] = $cp_id_pedido;

		$datos['causa_reclamos'] = $this->M_configuracion->obt_causa_reclamos();
		$datos['repuesto_productos'] = $this->M_configuracion->obtener_repuestos_productos();
		
		$datos['modo_edicion'] = false;
		$dias=$this->M_configuracion->get_configuracion('DIAS_MISION');
		$dias=$dias[0];
		//$resultado=$this->M_configuracion->bloquear_cliente($cliente);
		$datos['dias'] = $dias->valor;
		$datos['estado'] = $this->M_configuracion->obtener_estado_reclamos($cliente);

		$datos['cod_seguimiento']  = $this->M_configuracion->obt_codigos_seguimientos();
		$this->load->view('lte_header', $datos);
		$this->load->view('v_cartera_historial_rev', $datos);
		$this->load->view('lte_footer', $datos);	
	}
	public function modificar_cliente_cartera_rev()
    {
		 $id_actual = $this->input->post('id_cliente');		 
		 $id_cliente = $this->input->post('id_cliente');
		 		 
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
		 $cuit 			= 	 $this->input->post('cuit');	 
		 $codigo_postal	= 	 $this->input->post('codigo_postal');	 
		 $observaciones1 = 	 $this->input->post('observaciones1');
		//////////////////////////////////////////////////////////////////////////
		if($this->input->post('solicitud_baja')){
			$solicitud_baja = 1;
			$observaciones =  $this->input->post('observaciones');
			$opcion_baja =  $this->input->post('opcion_baja');
			if($opcion_baja){
				$fallecido =1;
			}else{
				$fallecido =0;
			}
			$solicitud = $this->M_configuracion->solicitud_baja($id_cliente);			
			if($solicitud->num_rows() == 0){				
				$user = $this->ion_auth->user()->row();				
				$resul1 = $this->M_configuracion->registrar_solicitud_baja($user->id, $id_cliente, $observaciones, $fallecido);
			}
		}else{
			 $solicitud_baja = 0;
			 $observaciones = "";
			 $solicitud = $this->M_configuracion->solicitud_baja($id_cliente);			
			 if($solicitud->num_rows() <> 0){				
				 $user = $this->ion_auth->user()->row();				
				 $resul1 = $this->M_configuracion->cancelar_solicitud_baja($id_cliente);
			 }
		}		
		
		
		   $vip = 0;
	  	 
		$nivel 			= 0;	   			
		
		
		/////////////////////////////////////////////////////////////////////////
		$regis = $this->M_configuracion->modificar_cartera_cliente($id_cliente, $dni, $municipio, $nombre,$apellidos, $telefono,$celular, $email, $codigo_postal, $calle, $nro, $piso, $dpto, $entrecalle1, $entrecalle2,  $vip, $nivel, $observaciones1, $cuit);


		$regis = $this->cartera_historial_rev($id_cliente);
	}
	public function registrar_reclamos_rev()
    {		
		$id_cliente = $this->input->post('id_cliente_reclamo');
		 		 
		 //Datos del cliente
		 $causa = $this->input->post('sel_causas');
		 $notas = $this->input->post('notas');
		 $user = $this->ion_auth->user()->row();
		 $id_usuario=$user->id;
				 	 

		$regis = $this->M_configuracion->registrar_reclamos($id_cliente, $causa,$notas, $id_usuario); 

		$this->cartera_historial_rev($id_cliente);
	}
	
		
	public function modificar_mision_cartera_rev()
	{
		$data = array(
			'mision' 	=> 		0     
		);		
		$this->session->set_userdata($data);

		$id_cliente = $this->input->post('id_cliente2'); 
		$contador = $this->input->post('contador');
		 
		$exitosa = $this->input->post('exitosa');
		$notas = $this->input->post('notas');
		$exitosa = $this->input->post('exitosa');
		$pedido = array();
		$repuesto = array();
		$baja = array();
		$compra = array();
		$cantidad = array();
		$descuento = array();
		$va_contador = 0;
		$user = $this->ion_auth->user()->row();
		$id_usuario = $user->id;
		$id_pedido_mision=$this->input->post('pedido1');
		if($exitosa == 2){
			// en seguimiento
			$registrado1 = $this->M_configuracion->desbloquear_cliente($id_cliente);
			$registrado1 = $this->M_configuracion->cliente_en_mision($id_cliente);
			$registrado = $this->M_configuracion->cartera_esta_activo($id_cliente);
			if($registrado == 0){
				//nueva mision y nuevo seguimiento
				$fecha_inicio = date(" Y-m-d H:i:s ");
				$fecha_final = date('Y-m-d H:i:s',mktime(0,0,0,date('m'),date('d' )+5, date('Y')));
				
				$registrado = $this->M_configuracion->registrar_mision($id_usuario, $id_cliente, $fecha_inicio, $fecha_final, $exitosa, $notas, $id_pedido_mision);
				$registrado1 = $this->M_configuracion->cliente_en_mision($id_cliente);
				$mision= $this->M_configuracion->cartera_mision_activa($id_cliente);
				
				$resultado = $this->M_operaciones->registrar_mision_seguimiento($mision[0]->id_mision, $notas);
			}else{
				//nuevo seguimiento a la mision existente
				$mision= $this->M_configuracion->cartera_mision_activa($id_cliente);
				$resultado = $this->M_operaciones->registrar_mision_seguimiento($mision[0]->id_mision, $notas);
			}
			$this->misiones_rev();
		}else{
			if($exitosa == 1){
				//se va a realizar la compra
				$c=0;
				for ($i=0; $i < $contador; $i++) { 
					# code...
					$conta=$i + 1;
					$va_compra= $this->input->post('compra'.$conta);
					$id_repuesto =  $this->input->post('repuesto'.$conta);
					$id_producto =  $this->input->post('producto'.$conta);
					$va_cantidad =  $this->input->post('cantidad'.$conta);
					$va_descuento =  $this->input->post('descuento'.$conta);
					$va_baja= $this->input->post('baja'.$conta);	
					$va_pedido= $this->input->post('pedido'.$conta);				
					
					if($va_baja){
						$respuesta = $this->M_configuracion->baja_pedido($va_pedido,$id_producto);
					}else{// si no esta de baja pregunto por si es compra
						if($va_compra){
							$repuesto[$c] = $id_repuesto;
							$cantidad[$c] = $va_cantidad;
							$descuento[$c] = $va_descuento;
							$c++;
							$va_contador = $c;
						}
					}
					
				}
				if( $c == 0){
					$this->cartera_historial_rev($id_cliente);
				}else{
					$registrado1 = $this->M_configuracion->desbloquear_cliente($id_cliente);
					$registrado1 = $this->M_configuracion->cliente_en_mision($id_cliente);
					$data = array(
						'mision' 	=> 		1,
						'contador' 	=> 		$va_contador,
						'repuesto'		=>		$repuesto ,
						'cantidad'       => $cantidad       
						);		
					$this->session->set_userdata($data);
					$registrado = $this->M_configuracion->cartera_esta_activo($id_cliente);
					if($registrado == 0){
						//nueva mision y nueva venta
						$fecha_inicio = date(" Y-m-d H:i:s ");
						$fecha_final = date('Y-m-d H:i:s',mktime(0,0,0,date('m'),date('d' )+5, date('Y')));
						$registrado = $this->M_configuracion->registrar_mision($id_usuario, $id_cliente, $fecha_inicio, $fecha_final, $exitosa, $notas, $id_pedido_mision);
		
						$mision= $this->M_configuracion->cartera_mision_activa($id_cliente);
						
						//$resultado = $this->M_operaciones->registrar_mision_seguimiento($mision[0]->id_mision, 'Se comenzó un proceso de venta');
					}else{
						//nuevo seguimiento a la mision existente
						$mision= $this->M_configuracion->cartera_mision_activa($id_cliente);
						//$resultado = $this->M_operaciones->registrar_mision_seguimiento($mision[0]->id_mision, 'Se comenzó un proceso de venta');
					}
		
					header ("Location: ". base_url()."nueva_venta_mision_rev/".$id_cliente."/".$id_pedido_mision);
				}
			}
		} 
        //$registrado = $this->M_configuracion->registrar_nuevo_hallazgo($id_mision, $notas, $id_clasificacion);
	   /* if ($registrado== 1)
		{ 
			$this->notificacion = "La misión se registró satisfactoriamente.";
			 $this->notificacion_error = false;
			 $this->misiones_propuestas();
		 }
		 else
		 {
			 $this->notificacion = "ERROR. No se pudo registrar la misión.";
			 $this->notificacion_error = true;
		 }	*/
		// $this->cartera_historial($id_cliente);
	}
	//*********  Cartera de clientes ++++++++++++++++++++++++++++++++++++++++*/
	public function cartera_historial1_rev($cliente)
	{
		//	Desde propuesta de misiones	
		$clientes 	= $this->M_configuracion->obt_cliente($cliente);
		$datos['cliente'] 	= $clientes->result();
		$cliente1 	= $clientes->result();
		$notificacion ="";
		if($cliente1[0]->apellidos==''){
			$notificacion = $notificacion."Datos de los apellidos vacios </br>";
		}
		if($cliente1[0]->email==''){
			$notificacion = $notificacion."Datos del email vacio </br>";
		}
		if($cliente1[0]->nro==''){
			$notificacion = $notificacion."Datos del número vacio </br>";
		}
		if($cliente1[0]->codigo_postal==''){
			$notificacion = $notificacion."Datos del código postal vacio </br>";
		}
		if($cliente1[0]->dni=='' && $cliente1[0]->cuit == ''){
			$notificacion = $notificacion."Datos del DNI y el CUIT vacios </br>";
		}
		if($notificacion != ''){
			$notificacion = '<h4><i class="icon fa fa-warning"></i>Datos importantes del cliente que debe revisar </h4></br>'.$notificacion;
		}
		$datos['notificacion'] = $notificacion;
		$datos['compras']  = $this->M_configuracion->obt_historico_compras($cliente);
		//print_r($datos['clientes']);die();
		//$datos['pedido'] 	= $pedido;	
		$provincias 	 	= $this->M_operaciones->provincias();	
		$datos['niveles'] = $this->M_configuracion->obt_niveles_vip();		
		$solicitud = $this->M_configuracion->solicitud_baja($cliente);
		if($solicitud->num_rows() != 0){
			$sol = $solicitud->row();
			$solicitud_baja=1;
			$observaciones=$sol->observaciones;
			$fallecido=$sol->fallecimiento;
			
		}else{
			$solicitud_baja=0;
			$observaciones="";
			$fallecido = 0;
		}
		$datos['solicitud_baja'] = $solicitud_baja;
		$datos['observaciones'] = $observaciones;
		$datos['fallecido'] = $fallecido;
		$datos['provincias'] = $provincias;	
		$datos['seguimientos'] = $this->M_configuracion->obt_historico_seguimiento($cliente);	
		$datos['reclamos'] = $this->M_configuracion->obtener_notas_clientes($cliente);
		$cartera_productos = $this->M_configuracion->obt_cartera_productos($cliente);
		$cp_id_cliente = array();
		$cp_id_producto = array();
		$cp_id_repuesto = array();
		$cp_producto = array();
		$cp_repuesto = array();
		$cp_fecha_vcto = array();
		$cp_fecha_compra = array();
		$cp_no_factura = array();
		$cp_cantidad = array();
		$cp_id_pedido = array();
		$cp_contador = 0;
		$cp_flag =0;
		foreach ($cartera_productos->result() as $key) {
			# code...
			if($cp_flag ==0){
				$cp_flag = 1;
				$cp_id_repuesto_ant = $key->id_repuesto; 
				$cp_id_cliente[$cp_contador] = $key->id_cliente; 
				$cp_id_producto[$cp_contador] = $key->id_producto; 
				$cp_id_repuesto[$cp_contador] = $key->id_repuesto; 
				$cp_producto[$cp_contador] = $key->producto; 
				$cp_repuesto[$cp_contador] = $key->repuesto; 
				$cp_fecha_vcto[$cp_contador] = $key->fecha_vcto; 
				$cp_fecha_compra[$cp_contador] = $key->fecha_compra; 
				$cp_no_factura[$cp_contador] = $key->no_factura; 
				$cp_cantidad[$cp_contador] = $key->cantidad; 
				$cp_id_pedido[$cp_contador] = $key->id_pedido; 
				$cp_contador++;
			}else{
				if($cp_id_repuesto_ant != $key->id_repuesto){
					$cp_id_cliente[$cp_contador] = $key->id_cliente; 
					$cp_id_producto[$cp_contador] = $key->id_producto; 
					$cp_id_repuesto[$cp_contador] = $key->id_repuesto; 
					$cp_producto[$cp_contador] = $key->producto; 
					$cp_repuesto[$cp_contador] = $key->repuesto; 
					$cp_fecha_vcto[$cp_contador] = $key->fecha_vcto; 
					$cp_fecha_compra[$cp_contador] = $key->fecha_compra; 
					$cp_no_factura[$cp_contador] = $key->no_factura; 
					$cp_cantidad[$cp_contador] = $key->cantidad; 
					$cp_id_pedido[$cp_contador] = $key->id_pedido;
					$cp_id_repuesto_ant = $key->id_repuesto; 
					$cp_contador++;
				}
			}

		}
		
		$datos['cp_id_cliente'] = $cp_id_cliente;
		$datos['cp_id_producto'] = $cp_id_producto;
		$datos['cp_id_repuesto'] = $cp_id_repuesto;
		$datos['cp_producto'] = $cp_producto;
		$datos['cp_repuesto'] = $cp_repuesto;
		$datos['cp_fecha_vcto'] = $cp_fecha_vcto;
		$datos['cp_fecha_compra'] = $cp_fecha_compra;
		$datos['cp_no_factura'] = $cp_no_factura;
		$datos['cp_cantidad'] = $cp_cantidad;
		$datos['cp_id_pedido'] = $cp_id_pedido;

		$datos['causa_reclamos'] = $this->M_configuracion->obt_causa_reclamos();
		$datos['repuesto_productos'] = $this->M_configuracion->obtener_repuestos_productos();
		
		$datos['modo_edicion'] = false;
		$dias=$this->M_configuracion->get_configuracion('DIAS_MISION');
		$dias=$dias[0];
		//$resultado=$this->M_configuracion->bloquear_cliente($cliente);
		$datos['dias'] = $dias->valor;
		$datos['cod_seguimiento']  = $this->M_configuracion->obt_codigos_seguimientos();
		$datos['estado'] = $this->M_configuracion->obtener_estado_reclamos($cliente);
		$this->load->view('lte_header', $datos);
		$this->load->view('v_cartera_historial1_rev', $datos);
		$this->load->view('lte_footer', $datos);	
	}
	public function modificar_cliente_cartera1_rev()
    {
		$id_actual = $this->input->post('id_cliente');		 
		$id_cliente = $this->input->post('id_cliente');
				 
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
		$cuit 			= 	 $this->input->post('cuit');	 
		$codigo_postal	= 	 $this->input->post('codigo_postal');	 
		$observaciones1 = 	 $this->input->post('observaciones1');
	   //////////////////////////////////////////////////////////////////////////
	   if($this->input->post('solicitud_baja')){
		   $solicitud_baja = 1;
		   $observaciones =  $this->input->post('observaciones');
		   $opcion_baja =  $this->input->post('opcion_baja');
			if($opcion_baja){
				$fallecido =1;
			}else{
				$fallecido =0;
			}
		   $solicitud = $this->M_configuracion->solicitud_baja($id_cliente);			
		   if($solicitud->num_rows() == 0){				
			   $user = $this->ion_auth->user()->row();				
			   $resul1 = $this->M_configuracion->registrar_solicitud_baja($user->id, $id_cliente, $observaciones, $fallecido);
		   }
	   }else{
			$solicitud_baja = 0;
			$observaciones = "";
			$solicitud = $this->M_configuracion->solicitud_baja($id_cliente);			
			if($solicitud->num_rows() <> 0){				
				$user = $this->ion_auth->user()->row();				
				$resul1 = $this->M_configuracion->cancelar_solicitud_baja($id_cliente);
			}
	   }		
	  
		  $vip = 0;
	  	 
	   $nivel 			= 0;	   			
	   
	   
	   /////////////////////////////////////////////////////////////////////////
	   $regis = $this->M_configuracion->modificar_cartera_cliente($id_cliente, $dni, $municipio, $nombre,$apellidos, $telefono,$celular, $email, $codigo_postal, $calle, $nro, $piso, $dpto, $entrecalle1, $entrecalle2,  $vip, $nivel, $observaciones1, $cuit);


		$regis = $this->cartera_historial1_rev($id_cliente);
	}
	public function registrar_reclamos1_rev()
    {		
		$id_cliente = $this->input->post('id_cliente_reclamo');
		 		 
		 //Datos del cliente
		 $causa = $this->input->post('sel_causas');
		 $notas = $this->input->post('notas');
		 $user = $this->ion_auth->user()->row();
		 $id_usuario=$user->id;
				 	 

		$regis = $this->M_configuracion->registrar_reclamos($id_cliente, $causa,$notas, $id_usuario); 

		$this->cartera_historial1_rev($id_cliente);
	}
	public function cartera_realizo_cambio_rev($id_cliente,$id_producto)
	{
		$productos = $this->M_configuracion->obt_repuestos_solos();
		//$colores = $this->M_configuracion->obt_colores();
		$datos['id_cliente']= $id_cliente;
		$clientes 	= $this->M_configuracion->obt_cliente($id_cliente);
		$datos['cliente'] 	= $clientes->result();		
		$datos['productos'] = $productos;
		$datos['id_producto'] = $id_producto;
		//$datos['colores'] 	= $colores;
		$datos['notificacion'] = 'Agregando nueva venta' ;
		$datos['notificacion_error'] = false ;
		$datos['modo_edicion'] = false;
		$this->load->view('lte_header', $datos);
		$this->load->view('v_agregar_pedidos_rev', $datos);
		$this->load->view('lte_footer', $datos);
	}
	public function cartera_adicionar_producto_rev($id_cliente)
	{		
		$productos = $this->M_configuracion->obt_repuestos_solos();
		//$colores = $this->M_configuracion->obt_colores();
		$datos['id_cliente']= $id_cliente;
		$clientes 	= $this->M_configuracion->obt_cliente($id_cliente);
		$datos['cliente'] 	= $clientes->result();		
		$datos['productos'] = $productos;
		
		//$datos['colores'] 	= $colores;
		$datos['notificacion'] = 'Agregando nueva venta' ;
		$datos['notificacion_error'] = false ;
		$datos['modo_edicion'] = false;
		$this->load->view('lte_header', $datos);
		$this->load->view('v_agregar_pedidos1_rev', $datos);
		$this->load->view('lte_footer', $datos);
	}
	public function misiones_propuestas_rev()
	{		
		$this->chequear_fin_de_mision();
		
		$user = $this->ion_auth->user()->row();
		 			
		$misiones = $this->M_configuracion->misiones_disponibles_revint($user->id);			
					
		$datos['misiones'] 				= $misiones;				
		
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
		$this->load->view('v_listado_misiones_propuestas_rev', $datos);
		$this->load->view('lte_footer', $datos);
	}
	public function misiones_propuestas_revint()
	{
		$this->chequear_fin_de_mision();
		
		$user = $this->ion_auth->user()->row();
		 			
		$misiones = $this->M_configuracion->misiones_disponibles_revint($user->id);			
					
		$datos['misiones'] 				= $misiones;				
		
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
		$this->load->view('v_listado_misiones_propuestas_revint', $datos);
		$this->load->view('lte_footer', $datos);
	}
	public function cancelar_mision_rev($id_cliente){
		$registrado = $this->M_configuracion->desbloquear_cliente($id_cliente);
		$this->misiones_propuestas_rev();
	}
	public function misiones_propuestas_rev_filtradas()
	{
		$user = $this->ion_auth->user()->row();
		$id_usuario= $user->id;

		$anno = $this->input->post('anno'); 
		$mes = $this->input->post('mes');
		$nombre = $this->input->post('fil_nombre'); 
		$telefono = $this->input->post('fil_telefono');
		$dni = $this->input->post('fil_dni'); 
		$email = $this->input->post('fil_email');
		$factura = $this->input->post('fil_factura');

		$nombre 	= trim($nombre); 
		$telefono 	= trim($telefono);
		$dni 		= trim($dni);
		$email 		= trim($email);
		$factura 	= trim($factura);
		
		/*if($anno == ''){
			$anno ='*';
		}
		if($mes == ''){
			$mes ='*';
		}*/
		if($nombre != '' || $telefono != '' || $dni != '' || $email != '' || $factura != ''){
			$mes ='*';
			$anno ='*';
		}

		if($nombre == ''){
			$nombre ='*';
		}
		if($telefono == ''){
			$telefono ='*';
		}
		if($dni == ''){
			$dni ='*';
		}
		if($email == ''){
			$email ='*';
		}
		if($factura == ''){
			$factura ='*';
		}
		$this->chequear_fin_de_mision();
		$group = array('ConsultorRV','ConsultorRVInt');
		         
		if ($this->ion_auth->in_group($group)) {
			
			$misiones = $this->M_configuracion->misiones_propuestas_revendedores_filtrada($id_usuario ,$anno, $mes, $nombre, $telefono, $dni, $email, $factura);
			
		}else{
			$misiones = $this->M_configuracion->misiones_propuestas_filtrada($anno, $mes, $nombre, $telefono, $dni, $email, $factura);
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
				if($anno !='*'){
					if($anno == substr($fec_vcto[$contador],0,4) && $mes == substr($fec_vcto[$contador],5,2) ){
						//print_r('entro');die();
						$contador++;
					}
					
				}else{
					$contador++;
				}		
			}else{//segundo registro en adelante
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
					if($anno !='*'){
						if($anno == substr($fec_vcto[$contador],0,4) && $mes == substr($fec_vcto[$contador],5,2) ){
							//print_r('entro');die();
							$contador++;
						}
						
					}else{
						$contador++;
					}	
					$anterior_cli=$actual_cli;
					$anterior_prod=$actual_prod;
					$anterior_vcto=$actual_vcto;
					
				}
			}			
			
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
		
        
		/*$datos['total_misiones'] = $this->M_configuracion->total_misiones();
		$datos['total_misiones_aceptadas'] = $this->M_configuracion->total_misiones_aceptadas();
		$datos['total_misiones_rechazadas'] = $this->M_configuracion->total_misiones_rechazadas();
		$datos['total_clientes_mision'] = $this->M_configuracion->total_clientes_mision();*/
		
		$annos = $this->M_configuracion->obt_annos();
		$meses = $this->M_configuracion->obt_meses();
		
		$datos['annos']  	= $annos;
		$datos['meses']  	= $meses;
		$datos['anno']  	= $anno;
		$datos['mes']  		= $mes;

		$this->load->view('lte_header', $datos);
		$this->load->view('v_listado_misiones_propuestas_rev', $datos);
		$this->load->view('lte_footer', $datos);
	}
	public function misiones_propuestas_revint_filtradas()
	{
		$user = $this->ion_auth->user()->row();
		$id_usuario= $user->id;

		$anno = $this->input->post('anno'); 
		$mes = $this->input->post('mes');
		$nombre = $this->input->post('fil_nombre'); 
		$telefono = $this->input->post('fil_telefono');
		$dni = $this->input->post('fil_dni'); 
		$email = $this->input->post('fil_email');
		$factura = $this->input->post('fil_factura');

		$nombre 	= trim($nombre); 
		$telefono 	= trim($telefono);
		$dni 		= trim($dni);
		$email 		= trim($email);
		$factura 	= trim($factura);
		
		/*if($anno == ''){
			$anno ='*';
		}
		if($mes == ''){
			$mes ='*';
		}*/
		if($nombre != '' || $telefono != '' || $dni != '' || $email != '' || $factura != ''){
			$mes ='*';
			$anno ='*';
		}

		if($nombre == ''){
			$nombre ='*';
		}
		if($telefono == ''){
			$telefono ='*';
		}
		if($dni == ''){
			$dni ='*';
		}
		if($email == ''){
			$email ='*';
		}
		if($factura == ''){
			$factura ='*';
		}
		$this->chequear_fin_de_mision();
		
			
		$misiones = $this->M_configuracion->misiones_propuestas_revendedoresint_filtrada($id_usuario ,$anno, $mes, $nombre, $telefono, $dni, $email, $factura);
		
		$datos['misiones']  	= $misiones;
		$annos = $this->M_configuracion->obt_annos();
		$meses = $this->M_configuracion->obt_meses();
		
		$datos['annos']  	= $annos;
		$datos['meses']  	= $meses;
		$datos['anno']  	= $anno;
		$datos['mes']  		= $mes;

		$this->load->view('lte_header', $datos);
		$this->load->view('v_listado_misiones_propuestas_revint', $datos);
		$this->load->view('lte_footer', $datos);
	}
	public function consultores_evaluacion()
	{
		$consultores = $this->M_configuracion->obt_consultores_evaluacion();
		//$colores = $this->M_configuracion->obt_colores();
		$datos['consultores']= $consultores;
		

		$this->load->view('lte_header', $datos);
		$this->load->view('v_listado_consultores', $datos);
		$this->load->view('lte_footer', $datos);
	}
	public function consultor_evaluacion()
	{
		$user = $this->ion_auth->user()->row();
		$id_usuario = $user->id;
		$consultores = $this->M_configuracion->obt_consultor_evaluacion($id_usuario);
		//$colores = $this->M_configuracion->obt_colores();
		$datos['consultores']= $consultores;
		

		$this->load->view('lte_header', $datos);
		$this->load->view('v_listado_consultor', $datos);
		$this->load->view('lte_footer', $datos);
	}
	public function editar_consultor($id_actual)
	{
		$consultor = $this->M_configuracion->obt_consultor($id_actual);
		$locales = $this->M_configuracion->obt_locales();
		
		
		$datos['consultor'] = $consultor->result();
		$datos['locales'] = $locales;
		$datos['id_actual'] = $id_actual;
		
		
		
		$this->load->view('lte_header', $datos);
 	    $this->load->view('v_editar_consultor', $datos);
	    $this->load->view('lte_footer', $datos);
	}
	public function modificar_consultor()
    {
		 $id_actual = $this->input->post('id_actual');
		 $local = $this->input->post('sel_local');
		 $modificado = $this->M_configuracion->modificar_consultor($id_actual, $local);		 
		 
		 
		 $this->consultores_locales();
	}
	//************************* */
	public function agregar_evaluacion_consultor()
	{
		$id_consultor= $this->input->post('id_consultor');
		$anno = $this->input->post('anno');
		$mes = $this->input->post('mes');
		$valor1 = $this->input->post('valor1');
		if($valor1 == null){
			$valor1 =0;
		}
		$valor2= $this->input->post('valor2');
		if($valor2 == null){
			$valor2 =0;
		}
		$valor3 = $this->input->post('valor3');
		if($valor3 == null){
			$valor3 =0;
		}
		$valor4 = $this->input->post('valor4');
		if($valor4 == null){
			$valor4 =0;
		}
		$valor5 = $this->input->post('valor5');
		if($valor5 == null){
			$valor5 =0;
		}
		$valor6 = $this->input->post('valor6');
		if($valor6 == null){
			$valor6 =0;
		}
		$evaluacion = ($valor1 + $valor2 + $valor3 + $valor4 + $valor5 + $valor6)/6;
		//$evaluacion = $this->input->post('sel_evaluaciones');
		$notas = $this->input->post('notas');
		
		$resultado = $this->M_configuracion->agregar_evaluacion_consultor($id_consultor,$anno, $mes,$evaluacion, $notas,$valor1,$valor2,$valor3,$valor4,$valor5,$valor6);			
				
		$this->editar_evaluacion_consultor($id_consultor,$anno, $mes);
	}
	public function editar_evaluacion_consultor($id_consultor, $anno, $mes)
	{// para el jefe de area
		$datos['anno']  = $anno;
		$datos['mes']  = $mes;
		$resultado = $this->M_configuracion->obt_consultor($id_consultor);
		$datos['criterios'] = $this->M_configuracion->obt_criterios();
		if ($resultado)
		{
		   $consultor = $resultado->row();
		   
		   $nombre = $consultor->first_name.' '.$consultor->last_name;
		   $datos['nombre']  = $nombre;
		   $datos['id_consultor']  = $id_consultor;
		}
		$llamadas = $this->M_configuracion->obt_llamadas_diaria($id_consultor);
		$llamadas1 =0;
		$llamadas2 =0;
		$llamadas3 =0;
		$llamadas4 =0;
		foreach ($llamadas->result() as $key) {
			# code...
			if($key->mes==1 || $key->mes==2 || $key->mes==3){
				$llamadas1 = $llamadas1 + $key->ingresos;
			}else{
				if($key->mes==4 || $key->mes==5 || $key->mes==6){
					$llamadas2 = $llamadas2 + $key->ingresos;
				}else{
					if($key->mes==7 || $key->mes==8 || $key->mes==9){
						$llamadas3 = $llamadas3 + $key->ingresos;
					}else{
						$llamadas4 = $llamadas4 + $key->ingresos;
					}
				}
			}
		}
		$llamadas = $this->M_dashboard->obtener_llamadas_mision($id_consultor,date('Y'));
		
		foreach ($llamadas->result() as $key) {
			# code...
			if($key->mes==1 || $key->mes==2 || $key->mes==3){
				$llamadas1 = $llamadas1 + $key->ingresos;
			}else{
				if($key->mes==4 || $key->mes==5 || $key->mes==6){
					$llamadas2 = $llamadas2 + $key->ingresos;
				}else{
					if($key->mes==7 || $key->mes==8 || $key->mes==9){
						$llamadas3 = $llamadas3 + $key->ingresos;
					}else{
						$llamadas4 = $llamadas4 + $key->ingresos;
					}
				}
			}
		}
		
		$datos['llamadas1'] = round($llamadas1/90);
		$datos['llamadas2'] = round($llamadas2/90);
		$datos['llamadas3'] = round($llamadas3/90);
		$datos['llamadas4'] = round($llamadas4/90);
		
		$ventas = $this->M_configuracion->obt_ventas_diaria($id_consultor);
		$ventas1 =0;
		$ventas2 =0;
		$ventas3 =0;
		$ventas4 =0;
		$factu1 =0;
		$factu2 =0;
		$factu3 =0;
		$factu4 =0;
		foreach ($ventas->result() as $key) {
			# code...
			if($key->mes==1 || $key->mes==2 || $key->mes==3){
				$ventas1 = $ventas1 + $key->cantidad;
				$factu1 = $factu1 + $key->importe;
			}else{
				if($key->mes==4 || $key->mes==5 || $key->mes==6){
					$ventas2 = $ventas2 + $key->cantidad;
					$factu2 = $factu2 + $key->importe;
				}else{
					if($key->mes==7 || $key->mes==8 || $key->mes==9){
						$ventas3 = $ventas3 + $key->cantidad;
						$factu3 = $factu3 + $key->importe;
					}else{
						$ventas4 = $ventas4 + $key->cantidad;
						$factu4 = $factu4 + $key->importe;
					}
				}
			}
		}
		$datos['ventas1'] = round($ventas1/90);
		$datos['ventas2'] = round($ventas2/90);
		$datos['ventas3'] = round($ventas3/90);
		$datos['ventas4'] = round($ventas4/90);
		$datos['factu1'] = round($factu1/90);
		$datos['factu2'] = round($factu2/90);
		$datos['factu3'] = round($factu3/90);
		$datos['factu4'] = round($factu4/90);

		$reclamos = $this->M_configuracion->obt_reclamos_diaria($id_consultor);
		$abiertos1 =0;
		$abiertos2 =0;
		$abiertos3 =0;
		$abiertos4 =0;
		$cerrados1 =0;
		$cerrados2 =0;
		$cerrados3 =0;
		$cerrados4 =0;
		foreach ($reclamos->result() as $key) {
			# code...
			if($key->mes==1 || $key->mes==2 || $key->mes==3){
				$abiertos1 = $abiertos1 + $key->abiertos;
				$cerrados1 = $cerrados1 + $key->cerrados;
			}else{
				if($key->mes==4 || $key->mes==5 || $key->mes==6){
					$abiertos2 = $abiertos2 + $key->abiertos;
					$cerrados2 = $cerrados2 + $key->cerrados;
				}else{
					if($key->mes==7 || $key->mes==8 || $key->mes==9){
						$abiertos3 = $abiertos3 + $key->abiertos;
						$cerrados3 = $cerrados3 + $key->cerrados;
					}else{
						$abiertos4 = $abiertos4 + $key->abiertos;
						$cerrados4 = $cerrados4 + $key->cerrados;
					}
				}
			}
		}
		$datos['abiertos1'] = $abiertos1;
		$datos['abiertos2'] = $abiertos2;
		$datos['abiertos3'] = $abiertos3;
		$datos['abiertos4'] = $abiertos4;
		$datos['cerrados1'] = $cerrados1;
		$datos['cerrados2'] = $cerrados2;
		$datos['cerrados3'] = $cerrados3;
		$datos['cerrados4'] = $cerrados4;

		$annos = $this->M_configuracion->obt_annos();		
		$datos['annos'] = $annos;	
		$meses = $this->M_configuracion->obt_meses();		
		$datos['meses'] = $meses;	
		$evaluacion_consultor = $this->M_configuracion->obt_evaluacion_consultor($id_consultor);
		$datos['evaluacion_consultor'] = $evaluacion_consultor;
		$datos['evaluacion'] = $this->M_configuracion->obt_evaluacion_usuario($anno, $mes, $id_consultor);

		$datos['modo_edicion'] = true;
		$datos['notificacion'] = 'Registrando la evaluación del consultor: '  . $nombre;
		if($this->notificacion_error == true){
			
			$datos['notificacion'] = $this->notificacion;				
			$datos['notificacion_error'] = $this->notificacion_error;
			$this->load->view('lte_header', $datos);
			$this->load->view('v_evaluacion_consultores', $datos);
			$this->load->view('lte_footer', $datos);
			
			return;
		}
		 
		if ($evaluacion_consultor->result())
		{
			$this->notificacion = 'Registrando la evaluación de: ' . $nombre;
			$this->notificacion_error == false;
			
		} else{
			
			$this->notificacion = 'No hay evaluaciones registradas para el consultor: '. $nombre;
			$this->notificacion_error == true;
		}				

		$datos['notificacion'] = $this->notificacion;
		$datos['notificacion_error'] = $this->notificacion_error;
		$this->load->view('lte_header', $datos);
 	    $this->load->view('v_evaluacion_consultores', $datos);
	    $this->load->view('lte_footer', $datos);
	}
	public function editar_evaluacion_consultor1($id_consultor, $anno, $mes)
	{// para el consultor
		$datos['anno']  = $anno;
		$datos['mes']  = $mes;
		$resultado = $this->M_configuracion->obt_consultor($id_consultor);
		$datos['criterios'] = $this->M_configuracion->obt_criterios();
		if ($resultado)
		{
		   $consultor = $resultado->row();
		   
		   $nombre = $consultor->first_name.' '.$consultor->last_name;
		   $datos['nombre']  = $nombre;
		   $datos['id_consultor']  = $id_consultor;
		}
/*		$llamadas = $this->M_configuracion->obt_llamadas_diaria($id_consultor);
		$llamadas1 =0;
		$llamadas2 =0;
		$llamadas3 =0;
		$llamadas4 =0;
		foreach ($llamadas->result() as $key) {
			# code...
			if($key->mes==1 || $key->mes==2 || $key->mes==3){
				$llamadas1 = $llamadas1 + $key->ingresos;
			}else{
				if($key->mes==4 || $key->mes==5 || $key->mes==6){
					$llamadas2 = $llamadas2 + $key->ingresos;
				}else{
					if($key->mes==7 || $key->mes==8 || $key->mes==9){
						$llamadas3 = $llamadas3 + $key->ingresos;
					}else{
						$llamadas4 = $llamadas4 + $key->ingresos;
					}
				}
			}
		}
		$datos['llamadas1'] = round($llamadas1/90);
		$datos['llamadas2'] = round($llamadas2/90);
		$datos['llamadas3'] = round($llamadas3/90);
		$datos['llamadas4'] = round($llamadas4/90);
		
		$ventas = $this->M_configuracion->obt_ventas_diaria($id_consultor);
		$ventas1 =0;
		$ventas2 =0;
		$ventas3 =0;
		$ventas4 =0;
		$factu1 =0;
		$factu2 =0;
		$factu3 =0;
		$factu4 =0;
		foreach ($ventas->result() as $key) {
			# code...
			if($key->mes==1 || $key->mes==2 || $key->mes==3){
				$ventas1 = $ventas1 + $key->cantidad;
				$factu1 = $factu1 + $key->importe;
			}else{
				if($key->mes==4 || $key->mes==5 || $key->mes==6){
					$ventas2 = $ventas2 + $key->cantidad;
					$factu2 = $factu2 + $key->importe;
				}else{
					if($key->mes==7 || $key->mes==8 || $key->mes==9){
						$ventas3 = $ventas3 + $key->cantidad;
						$factu3 = $factu3 + $key->importe;
					}else{
						$ventas4 = $ventas4 + $key->cantidad;
						$factu4 = $factu4 + $key->importe;
					}
				}
			}
		}
		$datos['ventas1'] = round($ventas1/90);
		$datos['ventas2'] = round($ventas2/90);
		$datos['ventas3'] = round($ventas3/90);
		$datos['ventas4'] = round($ventas4/90);
		$datos['factu1'] = round($factu1/90);
		$datos['factu2'] = round($factu2/90);
		$datos['factu3'] = round($factu3/90);
		$datos['factu4'] = round($factu4/90);

		$reclamos = $this->M_configuracion->obt_reclamos_diaria($id_consultor);
		$abiertos1 =0;
		$abiertos2 =0;
		$abiertos3 =0;
		$abiertos4 =0;
		$cerrados1 =0;
		$cerrados2 =0;
		$cerrados3 =0;
		$cerrados4 =0;
		foreach ($reclamos->result() as $key) {
			# code...
			if($key->mes==1 || $key->mes==2 || $key->mes==3){
				$abiertos1 = $abiertos1 + $key->abiertos;
				$cerrados1 = $cerrados1 + $key->cerrados;
			}else{
				if($key->mes==4 || $key->mes==5 || $key->mes==6){
					$abiertos2 = $abiertos2 + $key->abiertos;
					$cerrados2 = $cerrados2 + $key->cerrados;
				}else{
					if($key->mes==7 || $key->mes==8 || $key->mes==9){
						$abiertos3 = $abiertos3 + $key->abiertos;
						$cerrados3 = $cerrados3 + $key->cerrados;
					}else{
						$abiertos4 = $abiertos4 + $key->abiertos;
						$cerrados4 = $cerrados4 + $key->cerrados;
					}
				}
			}
		}
		$datos['abiertos1'] = $abiertos1;
		$datos['abiertos2'] = $abiertos2;
		$datos['abiertos3'] = $abiertos3;
		$datos['abiertos4'] = $abiertos4;
		$datos['cerrados1'] = $cerrados1;
		$datos['cerrados2'] = $cerrados2;
		$datos['cerrados3'] = $cerrados3;
		$datos['cerrados4'] = $cerrados4;
*/
		$annos = $this->M_configuracion->obt_annos();		
		$datos['annos'] = $annos;	
		$meses = $this->M_configuracion->obt_meses();		
		$datos['meses'] = $meses;	
		$evaluacion_consultor = $this->M_configuracion->obt_evaluacion_consultor($id_consultor);
		$datos['evaluacion_consultor'] = $evaluacion_consultor;
		$datos['evaluacion'] = $this->M_configuracion->obt_evaluacion_usuario($anno, $mes, $id_consultor);

		$datos['obj_misiones'] = $this->M_dashboard->obtener_obj_misiones_ejecucion_usuario($id_consultor);
		$datos['obj_purificadores'] = $this->M_dashboard->obtener_obj_purificadores_ejecucion_usuario($id_consultor);
		$datos['obj_repuesto'] = $this->M_dashboard->obtener_obj_repuesto_ejecucion_usuario($id_consultor);
		$datos['obj_mision_pesos'] = $this->M_dashboard->obtener_obj_mision_pesos_ejecucion_usuario($id_consultor);
		$datos['obj_generales'] = $this->M_dashboard->obtener_obj_generales_ejecucion_usuario($id_consultor);

		$datos['modo_edicion'] = true;
		$datos['notificacion'] = 'Registrando la evaluación del consultor: '  . $nombre;
		if($this->notificacion_error == true){
			
			$datos['notificacion'] = $this->notificacion;				
			$datos['notificacion_error'] = $this->notificacion_error;
			$this->load->view('lte_header', $datos);
			$this->load->view('v_evaluacion_consultores1', $datos);
			$this->load->view('lte_footer', $datos);
			
			return;
		}
		 
		if ($evaluacion_consultor->result())
		{
			$this->notificacion = 'Registrando la evaluación de: ' . $nombre;
			$this->notificacion_error == false;
			
		} else{
			
			$this->notificacion = 'No hay evaluaciones registradas para el consultor: '. $nombre;
			$this->notificacion_error == true;
		}				

		$datos['notificacion'] = $this->notificacion;
		$datos['notificacion_error'] = $this->notificacion_error;
		$this->load->view('lte_header', $datos);
 	    $this->load->view('v_evaluacion_consultores1', $datos);
	    $this->load->view('lte_footer', $datos);
	}
	 public function cancelar_evaluacion_consultor()
	{
		$id_consultor = $this->input->post('id_consultor');
		$id_evaluacion = $this->input->post('id_evaluacion');
		$anno = $this->input->post('anno');
		$mes = $this->input->post('mes');

		$cancelado = $this->M_configuracion->cancelar_evaluacion_consultor($id_consultor, $id_evaluacion);
		
		if ($cancelado == 1)
	    { 
		   $this->not_fcliente = "Se eliminó la evaluación correctamente.";
		}
		else
		{
		   $this->not_fcliente = "ERROR. No se pudo eliminar la evaluación. Verifique los datos especificados.";
		}
		
		$this->editar_evaluacion_consultor($id_consultor,$anno, $mes);

	}
	public function cfe_evaluacion_consultor($id_consultor, $id_evaluacion,$anno, $mes)
	{
		$datos['id_consultor'] = $id_consultor;
		$datos['id_evaluacion'] = $id_evaluacion;
		$datos['anno'] = $anno;
		$datos['mes'] = $mes;
		
		$this->load->view('lte_header', $datos);
 	    $this->load->view('vcan_evaluacion_consultores', $datos);
	    $this->load->view('lte_footer', $datos);
	}
	public function facturas_rev()
	{
		$facturas = $this->M_operaciones->obt_facturas();
		
				
        $datos['facturas'] = $facturas;
        
		
        $datos['facturas'] = $facturas;
		$datos['total_facturas'] = $facturas->num_rows();		
		
		$this->load->view('lte_header', $datos);
		$this->load->view('v_listado_facturas_rev', $datos);
		$this->load->view('lte_footer', $datos);

	}
	public function iva_rev()
	{
		$ivas = $this->M_operaciones->obt_ivas_rev();
		
				
        $datos['ivas'] = $ivas;
        
		
        $datos['ivas'] = $ivas;
		$datos['total_ivas'] = $ivas->num_rows();		
		
		$this->load->view('lte_header', $datos);
		$this->load->view('v_listado_ivas_rev', $datos);
		$this->load->view('lte_footer', $datos);

	}
	public function nuevo_iva_rev()
	{		
		$resultado = $this->M_configuracion->obt_paises();
		$datos['paises'] = $resultado;

		$datos['notificacion'] = "Especifique los datos del nuevo valor de IVA:";
		$datos['modo_edicion'] = false;
		$datos['notificacion_error'] = $this->notificacion_error;
						
		$this->load->view('lte_header', $datos);
		$this->load->view('v_iva_rev', $datos);
		$this->load->view('lte_footer', $datos);	
	}
	public function registrar_iva_rev()
    {
		 
		 $id_pais = $this->input->post('sel_paises');
		 $iva = $this->input->post('iva');
		 	 
		 $this->load->library('form_validation');
		 
		 $this->form_validation->set_rules('iva', 'IVA', 'required');		 
		 
		 if ($this->form_validation->run() == true)
		 {		 
			
			 $registrado = $this->M_configuracion->registrar_iva_rev($id_pais, $iva);
			 
			 $mensaje = "";
			 if ($registrado == 1)
				 { 
					 $this->notificacion = "El país se registró satisfactoriamente.";
		             $this->notificacion_error = false;
				 }
				 else
				 {
					 $this->notificacion = "ERROR. No se pudo registrar al país.";
		             $this->notificacion_error = true;
				 }
				 
		 }
		 else
		 {
		     $this->notificacion = validation_errors();
			 $this->notificacion_error = true;
			 
		 }
		 if($this->notificacion_error == true){			
			
		    $datos['id_pais']  	= $id_pais;
		    $datos['iva']  		= $iva;
			$resultado = $this->M_configuracion->obt_paises();
			$datos['paises'] = $resultado;

			$datos['notificacion'] = $this->notificacion ? $this->notificacion : "Error registrando la factura " . $descripcion;
          	$datos['notificacion_error'] = $this->notificacion_error;
			$datos['modo_edicion'] = false;

			$this->load->view('lte_header', $datos);
			$this->load->view('v_iva_rev', $datos);
			$this->load->view('lte_footer', $datos);  
		 
		 }else
		 	redirect('iva_rev');
		 
		 
	}
	public function editar_iva_rev($id_pais)
	{
		$resultado = $this->M_configuracion->obt_iva_rev($id_pais);
		
		if ($resultado)
		{
		   $iva = $resultado->row();

		   $id_pais 	= $iva->id_pais;
		   $iva 			= $iva->iva;
		   		   
		   $datos['modo_edicion'] = true;
		   $datos['notificacion'] = 'Modificando los datos del país: '  . $id_pais;
		   $datos['notificacion_error'] = $this->notificacion_error;
		   
		   $datos['id_actual']    	= $id_pais;
		   $datos['id_pais']  	= $id_pais;
		   $datos['iva']  		= $iva;
		   
		}


		$resultado = $this->M_configuracion->obt_paises();
		$datos['paises'] = $resultado;
		$pais = $this->M_configuracion->obt_iva_rev($id_pais);
		$datos['pais'] = $pais;

		$datos['modo_edicion'] = true;
		$datos['notificacion'] = 'Editando el valor del IVA: ';

		$this->load->view('lte_header', $datos);
 	    $this->load->view('v_iva_rev', $datos);
	    $this->load->view('lte_footer', $datos);
	}
	public function cfe_iva_rev($id_pais)
	{
		$datos['id_pais'] = $id_pais;
		
		$this->load->view('lte_header', $datos);
 	    $this->load->view('vcan_iva_rev', $datos);
	    $this->load->view('lte_footer', $datos);
	}
	public function cancelar_iva_rev()
	{
		$id_pais = $this->input->post('id_pais');
		$cancelado = $this->M_configuracion->cancelar_iva_rev($id_pais);
		
		if ($cancelado == 1)
	    { 
		   $this->not_fcliente = "Se eliminó la factura correctamente.";
		}
		else
		{
		   $this->not_fcliente = "ERROR. No se pudo eliminar la factura. Verifique los datos especificados.";
		}
		
		redirect('iva_rev');

	}
	public function modificar_iva_rev()
    {
		 $id_actual = $this->input->post('id_actual');
		 $id_pais = $this->input->post('id_pais');
		 $iva = $this->input->post('iva');
		 		 		 
		 $this->load->library('form_validation');
		 
		 $this->form_validation->set_rules('iva', 'IVA', 'required');
		
		if (   $this->form_validation->run() == true)
		 {
			 $modificado = $this->M_configuracion->modificar_iva_rev($id_actual, $id_pais, $iva);
			 
   		     if ($modificado == 1)
			 { 
				 $this->notificacion = "el país se modificó satisfactoriamente.";
		         $this->notificacion_error = false;
			 }
			 else
			 {
				 $this->notificacion = "ERROR. No se pudo modificar al país. Verifique los datos especificados.";
		         $this->notificacion_error = true;
		 }
		 }	
		 else
		 {
		      $this->notificacion = validation_errors();
			  $this->notificacion_error = true;
		 
		 }
		 if($this->notificacion_error == true){
			
			$datos['id_actual']  	= $id_actual;
		    $datos['id_pais']   	= $id_pais;
		    $datos['iva']  	= $iva;
			$resultado = $this->M_configuracion->obt_paises();
			$datos['paises'] = $resultado;
			$datos['notificacion'] = $this->notificacion ? $this->notificacion : "Error modificando al país " . $descripcion;
          	$datos['notificacion_error'] = $this->notificacion_error;
			$datos['modo_edicion'] = true;

			$this->load->view('lte_header', $datos);
			$this->load->view('v_iva_rev', $datos);
			$this->load->view('lte_footer', $datos);  
		 }else		
		 	redirect('iva_rev');
	}
	public function obtener_parametro($nombre)
	{
		$par = $this->M_operaciones->obtener_parametro($nombre);
        $fila = $par->row();
		return $fila->valor;
	}
}