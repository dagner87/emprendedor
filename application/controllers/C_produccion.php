<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class C_produccion extends CI_Controller {

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
			$this->load->model( 'M_produccion', '', TRUE );
			$this->load->model('upload_model');
		}
    }
	
    public function index()
	{
		
    }
    
    /**********************************************************************************************************/
	//********************** tipo   *******************************************************************
   
	// Listado de tipo
    public function obt_tipos()
	{
        $tipos = $this->M_produccion->get_tipos();
			
        $datos['tipos'] 		= $tipos;        
		$datos['total_tipos'] = count($tipos);
        
		$this->load->view('lte_header', $datos);
		$this->load->view('produccion/v_listado_tipos', $datos);
		$this->load->view('lte_footer', $datos);

	}	
	
	/***********************************************************************************************************/
	public function nuevo_tipo()
	{		
		$datos['notificacion'] = $this->notificacion ? $this->notificacion : "Especifique los datos del nuevo tipo:";
		$datos['notificacion_error'] = $this->notificacion_error;
		$datos['modo_edicion'] = false;		
			
		$this->load->view('lte_header', $datos);
		$this->load->view('produccion/v_tipos', $datos);
		$this->load->view('lte_footer', $datos);	
	}
	/**********************************************************************************************/
	// Registrando un tipo
    public function registrar_tipo()
    {
		 $tipo = $this->input->post('tipo');
		 
		 $this->load->library('form_validation');
		 
		 $this->form_validation->set_rules('tipo', 'Tipo', 'required');
			
		 if ($this->form_validation->run() == true )
		 {
			 $registrado = $this->M_produccion->set_tipo( $tipo);
			 
			 $mensaje = "";
			 if ($registrado == 1)
				 { 
					$this->notificacion = "El nuevo tipo se registró satisfactoriamente.";
		            $this->notificacion_error = false;
					 
				 }
				 else
				 {
					$this->notificacion = "ERROR. No se pudo registrar el nuevo tipo.";
		            $this->notificacion_error = true;
		 }
				 
		 }
		 else
		 {
		     $this->notificacion = validation_errors();
			 $this->notificacion_error = true;
		 
		 }
		 if($this->notificacion_error == true){	
			$datos['tipo'] = $tipo;
			
			$datos['notificacion'] = $this->notificacion ? $this->notificacion : "Error registrando el nuevo tipo.";
          	$datos['notificacion_error'] = $this->notificacion_error;
			$datos['modo_edicion'] = false;
			
			$this->load->view('lte_header', $datos);
			$this->load->view('produccion/v_tipos', $datos);
			$this->load->view('lte_footer', $datos); 
		 
		 }else
			$this->obt_tipos(); 
		 
    }
	/********************************************************************************************************/
	// Editando la tipo
	public function editar_tipo($id_actual)
	{
		$resultado = $this->M_produccion->get_tipos($id_actual);
		
        if (empty($resultado))
        {
            show_404();
        } 
        $id_tipo = $id_actual;		   
        $tipo = $resultado['nombre'];		   
                
        $datos['modo_edicion'] = true;
        $datos['notificacion'] = $this->notificacion ? $this->notificacion : "Modificando el tipo";
        $datos['notificacion_error'] = $this->notificacion_error;		   
        
        $datos['id_actual']  = $id_actual;
        $datos['id_tipo']    = $id_tipo;
        $datos['tipo']  	    = $tipo;
		
		$this->load->view('lte_header', $datos);
 	    $this->load->view('produccion/v_tipos', $datos);
	    $this->load->view('lte_footer', $datos);
	}
	/*********************************************************************************************************/
	// Modificando un tipo
    public function modificar_tipo()
    {
		 $id_actual = $this->input->post('id_actual');
		 $id_tipo = $this->input->post('id_tipo');
		 $tipo = $this->input->post('tipo');
		 		 
		 $this->load->library('form_validation');
		 
		 $this->form_validation->set_rules('tipo', 'tipo', 'required');
		 
		 if (   $this->form_validation->run() == true)
		 {
		 
			 $modificado = $this->M_produccion->upd_tipo($id_actual, $id_tipo,  $tipo);
			 
   		     if ($modificado == 1)
			 { 
				 $this->notificacion = "El tipo se modificó satisfactoriamente.";
		         $this->notificacion_error = false;
			 }
			 else
			 {
				 $this->notificacion = "ERROR. No se pudo modificar el tipo. Verifique los datos especificados.";
		         $this->notificacion_error = true;
		 }
				 
		 }
		 else
		 {
		     $this->notificacion = validation_errors();
			 $this->notificacion_error = true;
			 
		 }
		 if($this->notificacion_error == true){		
			$datos['id_actual'] = $id_actual;
			$datos['id_tipo']   = $id_tipo;
			$datos['tipo'] = $tipo;
			
			$datos['notificacion'] = $this->notificacion ? $this->notificacion : "Error. No se pudo modificar el tipo. Verifique los datos especificados.";
          	$datos['notificacion_error'] = $this->notificacion_error;
			$datos['modo_edicion'] = true;
			
			$this->load->view('lte_header', $datos);
			$this->load->view('produccion/v_tipos', $datos);
			$this->load->view('lte_footer', $datos); 
		 
		 }else
		 
		 $this->obt_tipos();
    }
   
	/***********************************************************************************************************/
	// Confirmar eliminación de un tipo
	public function cfe_tipo($id_tipo)
	{
		$datos['id_tipo'] = $id_tipo;
		
		$this->load->view('lte_header', $datos);
 	    $this->load->view('produccion/vcan_tipos', $datos);
	    $this->load->view('lte_footer', $datos);
	}
	/*******************************************************************************************************/
	// Cancelar tipo
    public function cancelar_tipo()
	{
		$id_tipo = $this->input->post('id_tipo');
		$cancelado = $this->M_produccion->delete_tipo($id_tipo);
		
		if ($cancelado == 1)
	    { 
		   $this->not_fcliente = "Se eliminó el tipo correctamente.";
		}
		else
		{
		   $this->not_fcliente = "ERROR. No se pudo eliminar el tipo. Verifique los datos especificados.";
		}
		
		$this->obt_tipos();

	}
	
	 /**********************************************************************************************************/
	//********************** subtipo   *******************************************************************
	// Listado de tipo
    public function obt_subtipos()
	{
        $subtipos = $this->M_produccion->get_subtipos();
			
        $datos['subtipos'] 		= $subtipos;        
		$datos['total_subtipos'] = count($subtipos);
        
		$this->load->view('lte_header', $datos);
		$this->load->view('produccion/v_listado_subtipos', $datos);
		$this->load->view('lte_footer', $datos);

	}	
	public function nuevo_subtipo()
	{		
		$datos['notificacion'] = $this->notificacion ? $this->notificacion : "Especifique los datos del nuevo tipo:";
		$datos['notificacion_error'] = $this->notificacion_error;
		$datos['modo_edicion'] = false;		
        $tipos = $this->M_produccion->get_tipos();
        $datos['tipos'] = $tipos;		
		$this->load->view('lte_header', $datos);
		$this->load->view('produccion/v_subtipos', $datos);
		$this->load->view('lte_footer', $datos);	
	}
	// Registrando un tipo
    public function registrar_subtipo()
    {
		 $subtipo = $this->input->post('subtipo');
		 $id_tipo = $this->input->post('id_tipo');
		 
		 $this->load->library('form_validation');
		 
		 $this->form_validation->set_rules('subtipo', 'subtipo', 'required');
			
		 if ($this->form_validation->run() == true )
		 {
			 $registrado = $this->M_produccion->set_subtipo( $subtipo, $id_tipo);
			 
			 $mensaje = "";
			 if ($registrado == 1)
				 { 
					$this->notificacion = "El nuevo subtipo se registró satisfactoriamente.";
		            $this->notificacion_error = false;				 
				 }
				 else
				 {
					$this->notificacion = "ERROR. No se pudo registrar el nuevo subtipo.";
		            $this->notificacion_error = true;
		 }
				 
		 }
		 else
		 {
		     $this->notificacion = validation_errors();
			 $this->notificacion_error = true;
		 
		 }
		 if($this->notificacion_error == true){	
			$datos['subtipo'] 	= $subtipo;
			$datos['tipo'] 		= $id_tipo;
			$tipos = $this->M_produccion->get_tipos();
			$datos['tipos'] 		= $tipos;

			$datos['notificacion'] = $this->notificacion ? $this->notificacion : "Error registrando el nuevo subtipo.";
          	$datos['notificacion_error'] = $this->notificacion_error;
			$datos['modo_edicion'] = false;
			
			$this->load->view('lte_header', $datos);
			$this->load->view('produccion/v_subtipos', $datos);
			$this->load->view('lte_footer', $datos); 
		 
		 }else
			$this->obt_subtipos(); 
		 
	}
	/********************************************************************************************************/
	// Editando la tipo
	public function editar_subtipo($id_actual)
	{
		$resultado = $this->M_produccion->get_subtipos($id_actual);
		
        if (empty($resultado))
        {
            show_404();
        } 
        $id_subtipo = $id_actual;		   
        $subtipo = $resultado['nombre'];		   
        $id_tipo = $resultado['id_tipo'];		   
                
        $datos['modo_edicion'] = true;
        $datos['notificacion'] = $this->notificacion ? $this->notificacion : "Modificando el subtipo";
        $datos['notificacion_error'] = $this->notificacion_error;		   
        
        $datos['id_actual']  = $id_actual;
        $datos['id_subtipo'] = $id_subtipo;       
        $datos['subtipo']  	 = $subtipo;
        $datos['tipo']    = $id_tipo;
        $tipos = $this->M_produccion->get_tipos();
        $datos['tipos'] = $tipos; 
		$this->load->view('lte_header', $datos);
 	    $this->load->view('produccion/v_subtipos', $datos);
	    $this->load->view('lte_footer', $datos);
	}
	/*********************************************************************************************************/
	// Modificando un tipo
    public function modificar_subtipo()
    {
		 $id_actual = $this->input->post('id_actual');
		 $id_subtipo = $this->input->post('id_subtipo');		 
		 $subtipo = $this->input->post('subtipo');
         $id_tipo = $this->input->post('id_tipo');
         		 
		 $this->load->library('form_validation');
		 
		 $this->form_validation->set_rules('subtipo', 'Subtipo', 'required');
		 
		 if (   $this->form_validation->run() == true)
		 {
		 
			 $modificado = $this->M_produccion->upd_subtipo($id_actual, $id_subtipo,  $subtipo, $id_tipo);
			 
   		     if ($modificado == 1)
			 { 
				 $this->notificacion = "El tipo se modificó satisfactoriamente.";
		         $this->notificacion_error = false;
			 }
			 else
			 {
				 $this->notificacion = "ERROR. No se pudo modificar el subtipo. Verifique los datos especificados.";
		         $this->notificacion_error = true;
		 	}
				 
		 }
		 else
		 {
		     $this->notificacion = validation_errors();
			 $this->notificacion_error = true;
			 
		 }
		 if($this->notificacion_error == true){		
			$datos['id_actual'] 	= $id_actual;
			$datos['id_subtipo']   	= $id_subtipo;
			$datos['tipo']   		= $id_tipo;
			$datos['subtipo'] 		= $subtipo;
			$tipos = $this->M_produccion->get_tipos();
        	$datos['tipos'] = $tipos;	
			$datos['notificacion'] = $this->notificacion ? $this->notificacion : "Error. No se pudo modificar el subtipo. Verifique los datos especificados.";
          	$datos['notificacion_error'] = $this->notificacion_error;
			$datos['modo_edicion'] = true;
			
			$this->load->view('lte_header', $datos);
			$this->load->view('produccion/v_subtipos', $datos);
			$this->load->view('lte_footer', $datos); 
		 
		 }else		 
		 	$this->obt_subtipos();
    }
	
	/***********************************************************************************************************/
	// Confirmar eliminación de un tipo
	public function cfe_subtipo($id_subtipo)
	{
		$datos['id_subtipo'] = $id_subtipo;
		
		$this->load->view('lte_header', $datos);
 	    $this->load->view('produccion/vcan_subtipos', $datos);
	    $this->load->view('lte_footer', $datos);
	}
	/*******************************************************************************************************/
	// Cancelar tipo
    public function cancelar_subtipo()
	{
		$id_subtipo = $this->input->post('id_subtipo');
		$cancelado = $this->M_produccion->delete_subtipo($id_subtipo);
		
		if ($cancelado == 1)
	    { 
		   $this->not_fcliente = "Se eliminó el subtipo correctamente.";
		}
		else
		{
		   $this->not_fcliente = "ERROR. No se pudo eliminar el subtipo. Verifique los datos especificados.";
		}
		
		$this->obt_subtipos();

	}
	/**********************************************************************************************/
	 /**********************************************************************************************************/
	//********************** Moneda   *******************************************************************
   
	// Listado de tipo
    public function obt_tipocambios()
	{
        $tipocambios = $this->M_produccion->get_tipocambios();
			
        $datos['tipocambios'] 		= $tipocambios;        
		$datos['total_tipocambios'] = count($tipocambios);
        
		$this->load->view('lte_header', $datos);
		$this->load->view('produccion/v_listado_tipocambios', $datos);
		$this->load->view('lte_footer', $datos);

	}	
	
	/***********************************************************************************************************/
	public function nuevo_tipocambio()
	{		
		$datos['notificacion'] = $this->notificacion ? $this->notificacion : "Especifique los datos de la nueva Moneda:";
		$datos['notificacion_error'] = $this->notificacion_error;
		$datos['modo_edicion'] = false;		
			
		$this->load->view('lte_header', $datos);
		$this->load->view('produccion/v_tipocambios', $datos);
		$this->load->view('lte_footer', $datos);	
	}
	/**********************************************************************************************/
	// Registrando un tipo
    public function registrar_tipocambio()
    {
		 $tipocambio = $this->input->post('tipocambio');
		 
		 $this->load->library('form_validation');
		 
		 $this->form_validation->set_rules('tipocambio', 'Moneda', 'required');
			
		 if ($this->form_validation->run() == true )
		 {
			 $registrado = $this->M_produccion->set_tipocambio( $tipocambio);
			 
			 $mensaje = "";
			 if ($registrado == 1)
				 { 
					$this->notificacion = "La nueva Moneda se registró satisfactoriamente.";
		            $this->notificacion_error = false;
					 
				 }
				 else
				 {
					$this->notificacion = "ERROR. No se pudo registrar la nueva Moneda.";
		            $this->notificacion_error = true;
		 }
				 
		 }
		 else
		 {
		     $this->notificacion = validation_errors();
			 $this->notificacion_error = true;
		 
		 }
		 if($this->notificacion_error == true){	
			$datos['tipocambio'] = $tipocambio;
			
			$datos['notificacion'] = $this->notificacion ? $this->notificacion : "Error registrando la nueva Moneda.";
          	$datos['notificacion_error'] = $this->notificacion_error;
			$datos['modo_edicion'] = false;
			
			$this->load->view('lte_header', $datos);
			$this->load->view('produccion/v_tipocambios', $datos);
			$this->load->view('lte_footer', $datos); 
		 
		 }else
			$this->obt_tipocambios(); 
		 
    }
	/********************************************************************************************************/
	// Editando la tipo
	public function editar_tipocambio($id_actual)
	{
		$resultado = $this->M_produccion->get_tipocambios($id_actual);
		
        if (empty($resultado))
        {
            show_404();
        } 
        $id_tipocambio = $id_actual;		   
        $tipocambio = $resultado['nombre'];		   
                
        $datos['modo_edicion'] = true;
        $datos['notificacion'] = $this->notificacion ? $this->notificacion : "Modificando la Moneda";
        $datos['notificacion_error'] = $this->notificacion_error;		   
        
        $datos['id_actual']  = $id_actual;
        $datos['id_tipocambio']    = $id_tipocambio;
        $datos['tipocambio']  	    = $tipocambio;
		
		$this->load->view('lte_header', $datos);
 	    $this->load->view('produccion/v_tipocambios', $datos);
	    $this->load->view('lte_footer', $datos);
	}
	/*********************************************************************************************************/
	// Modificando un tipo
    public function modificar_tipocambio()
    {
		 $id_actual = $this->input->post('id_actual');
		 $id_tipocambio = $this->input->post('id_tipocambio');
		 $tipocambio = $this->input->post('tipocambio');
		 		 
		 $this->load->library('form_validation');
		 
		 $this->form_validation->set_rules('tipocambio', 'Moneda', 'required');
		 
		 if (   $this->form_validation->run() == true)
		 {
		 
			 $modificado = $this->M_produccion->upd_tipocambio($id_actual, $id_tipocambio,  $tipocambio);
			 
   		     if ($modificado == 1)
			 { 
				 $this->notificacion = "La Moneda se modificó satisfactoriamente.";
		         $this->notificacion_error = false;
			 }
			 else
			 {
				 $this->notificacion = "ERROR. No se pudo modificar la Moneda. Verifique los datos especificados.";
		         $this->notificacion_error = true;
		 }
				 
		 }
		 else
		 {
		     $this->notificacion = validation_errors();
			 $this->notificacion_error = true;
			 
		 }
		 if($this->notificacion_error == true){		
			$datos['id_actual'] = $id_actual;
			$datos['id_tipocambio']   = $id_tipocambio;
			$datos['tipocambio'] = $tipocambio;
			
			$datos['notificacion'] = $this->notificacion ? $this->notificacion : "Error. No se pudo modificar la Moneda. Verifique los datos especificados.";
          	$datos['notificacion_error'] = $this->notificacion_error;
			$datos['modo_edicion'] = true;
			
			$this->load->view('lte_header', $datos);
			$this->load->view('produccion/v_tipocambios', $datos);
			$this->load->view('lte_footer', $datos); 
		 
		 }else
		 
		 $this->obt_tipocambios();
    }
   
	/***********************************************************************************************************/
	// Confirmar eliminación de un tipo
	public function cfe_tipocambio($id_tipocambio)
	{
		$datos['id_tipocambio'] = $id_tipocambio;
		
		$this->load->view('lte_header', $datos);
 	    $this->load->view('produccion/vcan_tipocambios', $datos);
	    $this->load->view('lte_footer', $datos);
	}
	/*******************************************************************************************************/
	// Cancelar tipo
    public function cancelar_tipocambio()
	{
		$id_tipocambio = $this->input->post('id_tipocambio');
		$cancelado = $this->M_produccion->delete_tipocambio($id_tipocambio);
		
		if ($cancelado == 1)
	    { 
		   $this->not_fcliente = "Se eliminó la Moneda correctamente.";
		}
		else
		{
		   $this->not_fcliente = "ERROR. No se pudo eliminar la Moneda. Verifique los datos especificados.";
		}
		
		$this->obt_tipocambios();

	}
	
	 /**********************************************************************************************************/
		 /**********************************************************************************************************/
	//********************** Tipo de cambios   *******************************************************************
	// Listado de tipo
    public function obt_detalletipocambios()
	{
		$res = $this->M_produccion->actualizar_costo();
        $detalletipocambios = $this->M_produccion->get_detalletipocambios();
			
        $datos['detalletipocambios'] 		= $detalletipocambios;        
		$datos['total_detalletipocambios'] = count($detalletipocambios);
        
		$this->load->view('lte_header', $datos);
		$this->load->view('produccion/v_listado_detalletipocambios', $datos);
		$this->load->view('lte_footer', $datos);

	}	
	public function nuevo_detalletipocambio()
	{		
		$datos['notificacion'] = $this->notificacion ? $this->notificacion : "Especifique los datos del nuevo tipo:";
		$datos['notificacion_error'] = $this->notificacion_error;
		$datos['modo_edicion'] = false;		
		$monedas = $this->M_produccion->get_tipocambios();
		$annos = $this->M_configuracion->obt_annos();
		$meses = $this->M_configuracion->obt_meses();		
		$datos['annos']  	= $annos;
		$datos['meses']  	= $meses;
		$datos['monedas'] = $monedas;	
			
		$this->load->view('lte_header', $datos);
		$this->load->view('produccion/v_detalletipocambios', $datos);
		$this->load->view('lte_footer', $datos);	
	}
	// Registrando un tipo
    public function registrar_detalletipocambio()
    {
		 $moneda = $this->input->post('sel_moneda');
		 $anno = $this->input->post('sel_anno');
		 $mes = $this->input->post('sel_mes');
		 $valor = $this->input->post('valor');
		 
		 $this->load->library('form_validation');
		 
		 $this->form_validation->set_rules('valor', 'Valor', 'required|numeric');
			
		 if ($this->form_validation->run() == true )
		 {
			 $registrado = $this->M_produccion->set_detalletipocambio( $moneda, $anno, $mes, $valor	);
			 
			 $mensaje = "";
			 if ($registrado == 1)
				 { 
					$this->notificacion = "El nuevo Tipo de cambio se registró satisfactoriamente.";
		            $this->notificacion_error = false;				 
				 }
				 else
				 {
					$this->notificacion = "ERROR. No se pudo registrar el nuevo tipo de cambio.";
		            $this->notificacion_error = true;
		 }
				 
		 }
		 else
		 {
		     $this->notificacion = validation_errors();
			 $this->notificacion_error = true;
		 
		 }
		 if($this->notificacion_error == true){	
			$datos['moneda'] 	= $moneda;
			$datos['anno'] 		= $anno;
			$datos['mes'] 		= $mes;
			$datos['valor'] 	= $valor;
			
			$monedas = $this->M_produccion->get_tipocambios();
			$annos = $this->M_configuracion->obt_annos();
			$meses = $this->M_configuracion->obt_meses();		
			$datos['annos']  	= $annos;
			$datos['meses']  	= $meses;
			$datos['monedas'] = $monedas;

			$datos['notificacion'] = $this->notificacion ? $this->notificacion : "Error registrando el nuevo tipo de cambio.";
          	$datos['notificacion_error'] = $this->notificacion_error;
			$datos['modo_edicion'] = false;
			
			$this->load->view('lte_header', $datos);
			$this->load->view('produccion/v_detalletipocambios', $datos);
			$this->load->view('lte_footer', $datos); 
		 
		 }else
			$this->obt_detalletipocambios(); 
		 
	}
	/********************************************************************************************************/
	// Editando la tipo
	public function editar_detalletipocambio($id_actual)
	{
		$resultado = $this->M_produccion->get_detalletipocambios($id_actual);
		
        if (empty($resultado))
        {
            show_404();
        } 
        $id_detalletipocambio = $id_actual;		   
        $datos['moneda'] 	= $resultado['id_tipo_cambio'];
		$datos['anno'] 		= $resultado['anno'];;
		$datos['mes'] 		= $resultado['mes'];;
		$datos['valor'] 	= $resultado['valor'];;
		
		$monedas = $this->M_produccion->get_tipocambios();
		$annos = $this->M_configuracion->obt_annos();
		$meses = $this->M_configuracion->obt_meses();		
		$datos['annos']  	= $annos;
		$datos['meses']  	= $meses;
		$datos['monedas'] = $monedas;		   
                
        $datos['modo_edicion'] = true;
        $datos['notificacion'] = $this->notificacion ? $this->notificacion : "Modificando el detalletipocambio";
        $datos['notificacion_error'] = $this->notificacion_error;		   
        
        $datos['id_actual']  = $id_actual;
        
		$this->load->view('lte_header', $datos);
 	    $this->load->view('produccion/v_detalletipocambios', $datos);
	    $this->load->view('lte_footer', $datos);
	}
	/*********************************************************************************************************/
	// Modificando un tipo
    public function modificar_detalletipocambio()
    {
		 $id_actual = $this->input->post('id_actual');
		 $id_detalletipocambio = $this->input->post('id_actual');
		 $moneda = $this->input->post('sel_moneda');
		 $anno = $this->input->post('sel_anno');
		 $mes = $this->input->post('sel_mes');
		 $valor = $this->input->post('valor');
         		 
		 $this->load->library('form_validation');
		 
		 $this->form_validation->set_rules('valor', 'Valor', 'required|numeric');
		 
		 if (   $this->form_validation->run() == true)
		 {
		 
			 $modificado = $this->M_produccion->upd_detalletipocambio($id_actual, $id_detalletipocambio, $moneda, $anno, $mes, $valor);
			 
   		     if ($modificado == 1)
			 { 
				 $this->notificacion = "El tipo de cambio se modificó satisfactoriamente.";
		         $this->notificacion_error = false;
			 }
			 else
			 {
				 $this->notificacion = "ERROR. No se pudo modificar el tipo de cambio. Verifique los datos especificados.";
		         $this->notificacion_error = true;
		 	}
				 
		 }
		 else
		 {
		     $this->notificacion = validation_errors();
			 $this->notificacion_error = true;
			 
		 }
		 if($this->notificacion_error == true){		
			$datos['moneda'] 	= $moneda;
			$datos['anno'] 		= $anno;
			$datos['mes'] 		= $mes;
			$datos['valor'] 	= $valor;
			
			$monedas = $this->M_produccion->get_tipocambios();
			$annos = $this->M_configuracion->obt_annos();
			$meses = $this->M_configuracion->obt_meses();		
			$datos['annos']  	= $annos;
			$datos['meses']  	= $meses;
			$datos['monedas'] = $monedas;

			$datos['notificacion'] = $this->notificacion ? $this->notificacion : "Error. No se pudo modificar el tipo de cambio. Verifique los datos especificados.";
          	$datos['notificacion_error'] = $this->notificacion_error;
			$datos['modo_edicion'] = true;
			
			$this->load->view('lte_header', $datos);
			$this->load->view('produccion/v_detalletipocambios', $datos);
			$this->load->view('lte_footer', $datos); 
		 
		 }else		 
		 	$this->obt_detalletipocambios();
    }
	
	/***********************************************************************************************************/
	// Confirmar eliminación de un tipo
	public function cfe_detalletipocambio($id_detalletipocambio)
	{
		$datos['id_detalletipocambio'] = $id_detalletipocambio;
		
		$this->load->view('lte_header', $datos);
 	    $this->load->view('produccion/vcan_detalletipocambios', $datos);
	    $this->load->view('lte_footer', $datos);
	}
	/*******************************************************************************************************/
	// Cancelar tipo
    public function cancelar_detalletipocambio()
	{
		$id_detalletipocambio = $this->input->post('id_detalletipocambio');
		$cancelado = $this->M_produccion->delete_detalletipocambio($id_detalletipocambio);
		
		if ($cancelado == 1)
	    { 
		   $this->not_fcliente = "Se eliminó el tipo de cambio correctamente.";
		}
		else
		{
		   $this->not_fcliente = "ERROR. No se pudo eliminar el tipo de cambio. Verifique los datos especificados.";
		}
		
		$this->obt_detalletipocambios();

	}
	/**********************************************************************************************/
	//********************** Componente   *******************************************************************
	// Listado de tipo
    public function componentes()
	{
		$res = $this->M_produccion->actualizar_costo();
        $componentes = $this->M_produccion->get_componentes();
			
        $datos['componentes'] 		= $componentes;        
		$datos['total_componentes'] = count($componentes);
        
		$this->load->view('lte_header', $datos);
		$this->load->view('produccion/v_listado_componente', $datos);
		$this->load->view('lte_footer', $datos);

	}	
	public function nuevo_componente()
	{		
		$datos['notificacion'] = $this->notificacion ? $this->notificacion : "Especifique los datos del nuevo componente:";
		$datos['notificacion_error'] = $this->notificacion_error;
		$datos['modo_edicion'] = false;		
        $subtipos = $this->M_produccion->get_subtipos();
        $datos['subtipos'] = $subtipos;		
		$this->load->view('lte_header', $datos);
		$this->load->view('produccion/v_componentes', $datos);
		$this->load->view('lte_footer', $datos);	
	}
	// Registrando un tipo
    public function registrar_componente()
    {
		 $componente = $this->input->post('componente');
		 $id_subtipo = $this->input->post('id_subtipo');
		 
		 $this->load->library('form_validation');
		 
		 $this->form_validation->set_rules('componente', 'Componente', 'required');
			
		 if ($this->form_validation->run() == true )
		 {
			 $registrado = $this->M_produccion->set_componente( $componente, $id_subtipo);
			 
			 $mensaje = "";
			 if ($registrado == 1)
				 { 
					$this->notificacion = "El nuevo componente se registró satisfactoriamente.";
		            $this->notificacion_error = false;				 
				 }
				 else
				 {
					$this->notificacion = "ERROR. No se pudo registrar el nuevo componente.";
		            $this->notificacion_error = true;
		 }
				 
		 }
		 else
		 {
		     $this->notificacion = validation_errors();
			 $this->notificacion_error = true;
		 
		 }
		 if($this->notificacion_error == true){	
			$datos['id_subtipo'] 	= $id_subtipo;
			$datos['componente'] 	= $componente;
			$subtipos = $this->M_produccion->get_subtipos();
			$datos['subtipos'] 		= $subtipos;

			$datos['notificacion'] = $this->notificacion ? $this->notificacion : "Error registrando el nuevo componente.";
          	$datos['notificacion_error'] = $this->notificacion_error;
			$datos['modo_edicion'] = false;
			
			$this->load->view('lte_header', $datos);
			$this->load->view('produccion/v_componentes', $datos);
			$this->load->view('lte_footer', $datos); 
		 
		 }else
			$this->componentes(); 
		 
	}
	/********************************************************************************************************/
	// Editando la tipo
	public function editar_componente($id_actual)
	{
		$resultado = $this->M_produccion->get_componentes($id_actual);
		
        if (empty($resultado))
        {
            show_404();
        } 
        $id_componente = $id_actual;		   
        $componente = $resultado['nombre'];		   
        $id_subtipo = $resultado['id_subtipo'];		   
                
        $datos['modo_edicion'] = true;
        $datos['notificacion'] = $this->notificacion ? $this->notificacion : "Modificando el subtipo";
        $datos['notificacion_error'] = $this->notificacion_error;		   
        
        $datos['id_actual']  = $id_actual;
        $datos['id_componente']  = $id_componente;
        $datos['subtipo'] = $id_subtipo;       
        $datos['componente']  	 = $componente;
        
        $subtipos = $this->M_produccion->get_subtipos();
        $datos['subtipos'] = $subtipos; 
		$this->load->view('lte_header', $datos);
 	    $this->load->view('produccion/v_componentes', $datos);
	    $this->load->view('lte_footer', $datos);
	}
	/*********************************************************************************************************/
	// Modificando un tipo
    public function modificar_componente()
    {
		 $id_actual = $this->input->post('id_actual');
		 $id_componente = $this->input->post('id_componente');
		 $componente = $this->input->post('componente');
		 $id_subtipo = $this->input->post('id_subtipo');
         		 
		 $this->load->library('form_validation');
		 
		 $this->form_validation->set_rules('componente', 'Componente', 'required');
		 
		 if (   $this->form_validation->run() == true)
		 {
		 
			 $modificado = $this->M_produccion->upd_componente($id_actual, $id_componente,  $componente, $id_subtipo);
			 
   		     if ($modificado == 1)
			 { 
				 $this->notificacion = "El componente se modificó satisfactoriamente.";
		         $this->notificacion_error = false;
			 }
			 else
			 {
				 $this->notificacion = "ERROR. No se pudo modificar el componente. Verifique los datos especificados.";
		         $this->notificacion_error = true;
		 	}
				 
		 }
		 else
		 {
		     $this->notificacion = validation_errors();
			 $this->notificacion_error = true;
			 
		 }
		 if($this->notificacion_error == true){		
			$datos['id_actual'] 	= $id_actual;
			$datos['id_subtipo'] 	= $id_subtipo;
			$datos['componente'] 	= $componente;
			$subtipos = $this->M_produccion->get_subtipos();
			$datos['subtipos'] 		= $subtipos;
				
			$datos['notificacion'] = $this->notificacion ? $this->notificacion : "Error. No se pudo modificar el componente. Verifique los datos especificados.";
          	$datos['notificacion_error'] = $this->notificacion_error;
			$datos['modo_edicion'] = true;
			
			$this->load->view('lte_header', $datos);
			$this->load->view('produccion/v_componentes', $datos);
			$this->load->view('lte_footer', $datos); 
		 
		 }else		 
		 	$this->componentes();
    }
	
	/***********************************************************************************************************/
	// Confirmar eliminación de un tipo
	public function cfe_componente($id_componente)
	{
		$datos['id_componente'] = $id_componente;
		
		$this->load->view('lte_header', $datos);
 	    $this->load->view('produccion/vcan_componentes', $datos);
	    $this->load->view('lte_footer', $datos);
	}
	/*******************************************************************************************************/
	// Cancelar tipo
    public function cancelar_componente()
	{
		$id_componente = $this->input->post('id_componente');
		$cancelado = $this->M_produccion->delete_componente($id_componente);
		
		if ($cancelado == 1)
	    { 
		   $this->not_fcliente = "Se eliminó el subtipo correctamente.";
		}
		else
		{
		   $this->not_fcliente = "ERROR. No se pudo eliminar el subtipo. Verifique los datos especificados.";
		}
		
		$this->componentes();

	}
	/**********************************************************************************************/	
   //***************** Editando el producto campaña **********************************************/
   	public function editar_componente_compras($id_componente)
   	{
		$resultado = $this->M_produccion->get_componentes($id_componente);
		if (empty($resultado))
        {
            show_404();
        } 
		
		$componente = $resultado['nombre'];		   
        $subtipo = $resultado['subtipo'];		 		 
		$datos['id_componente'] = $id_componente;
		$datos['componente'] = $componente;
		$datos['subtipo'] = $subtipo;

		$monedas = $this->M_produccion->get_tipocambios();
		$annos = $this->M_configuracion->obt_annos();
		$meses = $this->M_configuracion->obt_meses();		
		$datos['annos']  	= $annos;
		$datos['meses']  	= $meses;
		$datos['monedas'] = $monedas;

		$resultado1 = $this->M_produccion->get_componente_compras($id_componente);
		
		$datos['compras'] = $resultado1;
		
		$datos['modo_edicion'] = true;
		$datos['notificacion'] = 'Asignándole compras al componente: '  . $componente;

		$this->load->view('lte_header', $datos);
		$this->load->view('produccion/v_componente_compras', $datos);
		$this->load->view('lte_footer', $datos);
	}

   	public function agregar_componente_compras()
   	{
	   $id_componente= $this->input->post('id_componente');
	   $moneda = $this->input->post('sel_monedas');
	   $anno = $this->input->post('sel_anno');
	   $mes = $this->input->post('sel_mes');
	   $valor = $this->input->post('valor');

		 // validar que no se repita 		
		$comp = $this->M_produccion->get_compras($id_componente,  $anno, $mes);
		if (empty($comp))
        {
			$resultado = $this->M_produccion->set_componente_compras($id_componente, $moneda, $anno, $mes, $valor);
	  		$this->editar_componente_compras($id_componente);
        } else{
			show_error('Ya existe una compra con esa moneda, año y mes');
		}
	  
   	}  	
	
   	public function cfe_componente_compras($id_compra, $id_componente)
   	{
	   	$datos['id_compra'] = $id_compra;
	   	$datos['id_componente'] = $id_componente;
	   
	   	$this->load->view('lte_header', $datos);
		$this->load->view('produccion/vcan_componente_compras', $datos);
	   	$this->load->view('lte_footer', $datos);
   	}
   	public function cancelar_componente_compras()
   	{
	   $id_compra = $this->input->post('id_compra');
	   $id_componente = $this->input->post('id_componente');

	   $cancelado = $this->M_produccion->delete_componente_compras($id_compra);
	   
	   if ($cancelado == 1)
	   { 
		  $this->not_fcliente = "Se eliminó la compra correctamente.";
	   }
	   else
	   {
		  $this->not_fcliente = "ERROR. No se pudo eliminar la compra. Verifique los datos especificados.";
	   }
	   
	   $this->editar_componente_compras($id_componente);

   	}
   	/*******************************************************************************************************/
	//********************** p_categorias   *******************************************************************
   
	// Listado de tipo
    public function p_categorias()
	{
        $categorias = $this->M_produccion->get_p_categorias();
			
        $datos['categorias'] 		= $categorias;        
		$datos['total_categorias'] = count($categorias);
        
		$this->load->view('lte_header', $datos);
		$this->load->view('produccion/v_listado_categorias', $datos);
		$this->load->view('lte_footer', $datos);

	}	
	
	/***********************************************************************************************************/
	public function nuevo_p_categoria()
	{		
		$datos['notificacion'] = $this->notificacion ? $this->notificacion : "Especifique los datos del nueva categoría:";
		$datos['notificacion_error'] = $this->notificacion_error;
		$datos['modo_edicion'] = false;		
			
		$this->load->view('lte_header', $datos);
		$this->load->view('produccion/v_categorias', $datos);
		$this->load->view('lte_footer', $datos);	
	}
	/**********************************************************************************************/
	// Registrando un tipo
    public function registrar_p_categoria()
    {
		 $categoria = $this->input->post('categoria');
		 
		 $this->load->library('form_validation');
		 
		 $this->form_validation->set_rules('categoria', 'Categoría', 'required');
			
		 if ($this->form_validation->run() == true )
		 {
			 $registrado = $this->M_produccion->set_p_categoria( $categoria);
			 
			 $mensaje = "";
			 if ($registrado == 1)
				 { 
					$this->notificacion = "El nuevo categoria se registró satisfactoriamente.";
		            $this->notificacion_error = false;
					 
				 }
				 else
				 {
					$this->notificacion = "ERROR. No se pudo registrar el nuevo categoria.";
		            $this->notificacion_error = true;
		 }
				 
		 }
		 else
		 {
		     $this->notificacion = validation_errors();
			 $this->notificacion_error = true;
		 
		 }
		 if($this->notificacion_error == true){	
			$datos['categoria'] = $categoria;
			
			$datos['notificacion'] = $this->notificacion ? $this->notificacion : "Error registrando el nuevo tipo.";
          	$datos['notificacion_error'] = $this->notificacion_error;
			$datos['modo_edicion'] = false;
			
			$this->load->view('lte_header', $datos);
			$this->load->view('produccion/v_categorias', $datos);
			$this->load->view('lte_footer', $datos); 
		 
		 }else
			$this->p_categorias(); 
		 
    }
	/********************************************************************************************************/
	// Editando la tipo
	public function editar_p_categoria($id_actual)
	{
		$resultado = $this->M_produccion->get_p_categorias($id_actual);
		
        if (empty($resultado))
        {
            show_404();
        } 
        $id_categoria = $id_actual;		   
        $categoria = $resultado['nombre'];		   
                
        $datos['modo_edicion'] = true;
        $datos['notificacion'] = $this->notificacion ? $this->notificacion : "Modificando la categoria";
        $datos['notificacion_error'] = $this->notificacion_error;		   
        
        $datos['id_actual']  = $id_actual;
        $datos['id_categoria']    = $id_categoria;
        $datos['categoria']  	    = $categoria;
		
		$this->load->view('lte_header', $datos);
 	    $this->load->view('produccion/v_categorias', $datos);
	    $this->load->view('lte_footer', $datos);
	}
	/*********************************************************************************************************/
	// Modificando un tipo
    public function modificar_p_categoria()
    {
		 $id_actual = $this->input->post('id_actual');
		 $id_categoria = $this->input->post('id_categoria');
		 $categoria = $this->input->post('categoria');
		 		 
		 $this->load->library('form_validation');
		 
		 $this->form_validation->set_rules('categoria', 'Categoría', 'required');
		 
		 if (   $this->form_validation->run() == true)
		 {
		 
			 $modificado = $this->M_produccion->upd_p_categorias($id_actual, $id_categoria,  $categoria);
			 
   		     if ($modificado == 1)
			 { 
				 $this->notificacion = "La categoria se modificó satisfactoriamente.";
		         $this->notificacion_error = false;
			 }
			 else
			 {
				 $this->notificacion = "ERROR. No se pudo modificar la categoria. Verifique los datos especificados.";
		         $this->notificacion_error = true;
		 }
				 
		 }
		 else
		 {
		     $this->notificacion = validation_errors();
			 $this->notificacion_error = true;
			 
		 }
		 if($this->notificacion_error == true){		
			$datos['id_actual'] = $id_actual;
			$datos['id_categoria']   = $id_categoria;
			$datos['categoria'] = $categoria;
			
			$datos['notificacion'] = $this->notificacion ? $this->notificacion : "Error. No se pudo modificar la categoria. Verifique los datos especificados.";
          	$datos['notificacion_error'] = $this->notificacion_error;
			$datos['modo_edicion'] = true;
			
			$this->load->view('lte_header', $datos);
			$this->load->view('produccion/v_categorias', $datos);
			$this->load->view('lte_footer', $datos); 
		 
		 }else
		 
		 $this->p_categorias();
    }
   
	/***********************************************************************************************************/
	// Confirmar eliminación de un tipo
	public function cfe_p_categoria($id_categoria)
	{
		$datos['id_categoria'] = $id_categoria;
		
		$this->load->view('lte_header', $datos);
 	    $this->load->view('produccion/vcan_categoria', $datos);
	    $this->load->view('lte_footer', $datos);
	}
	/*******************************************************************************************************/
	// Cancelar tipo
    public function cancelar_p_categoria()
	{
		$id_categoria = $this->input->post('id_categoria');
		$cancelado = $this->M_produccion->delete_p_categoria($id_categoria);
		
		if ($cancelado == 1)
	    { 
		   $this->not_fcliente = "Se eliminó la categoría correctamente.";
		}
		else
		{
		   $this->not_fcliente = "ERROR. No se pudo eliminar la categoría. Verifique los datos especificados.";
		}
		
		$this->p_categorias();

	}
	
	 /**********************************************************************************************************/
	//********************** p_producto   *******************************************************************
	// Listado de tipo
    public function p_productos()
	{
        $productos = $this->M_produccion->get_p_productos();
			
        $datos['productos'] 		= $productos;        
		$datos['total_productos'] = count($productos);
        
		$this->load->view('lte_header', $datos);
		$this->load->view('produccion/v_listado_productos', $datos);
		$this->load->view('lte_footer', $datos);

	}	
	public function nuevo_p_producto()
	{		
		$datos['notificacion'] = $this->notificacion ? $this->notificacion : "Especifique los datos del nuevo producto:";
		$datos['notificacion_error'] = $this->notificacion_error;
		$datos['modo_edicion'] = false;		
        $categorias = $this->M_produccion->get_p_categorias();
		$datos['categorias'] = $categorias;
		$productos_ventas = $this->M_configuracion->obt_productos();        		
        $datos['productos_ventas'] = $productos_ventas;		
        $ums = $this->M_produccion->get_ums();
        $datos['ums'] = $ums;		
		$this->load->view('lte_header', $datos);
		$this->load->view('produccion/v_productos', $datos);
		$this->load->view('lte_footer', $datos);	
	}
	// Registrando un tipo
    public function registrar_p_producto()
    {
		 $producto = $this->input->post('producto');
		 $id_um = $this->input->post('sel_um');
		 $pt = $this->input->post('sel_pt');
		 $id_categoria = $this->input->post('sel_categoria');
		 $valor_alarma = $this->input->post('valor_alarma');
		 $prod_venta = $this->input->post('sel_prod_ventas');
		 
		 $this->load->library('form_validation');
		 
		 $this->form_validation->set_rules('producto', 'Producto', 'required');
		 $this->form_validation->set_rules('valor_alarma', 'Valor alarma', 'required|numeric');
			
		 if ($this->form_validation->run() == true )
		 {
			$registrado = $this->M_produccion->set_p_producto($producto, $id_categoria,$valor_alarma, $id_um, $prod_venta, $pt);
			 
			$mensaje = "";
			if ($registrado == 1)
				{ 
					$this->notificacion = "El nuevo producto se registró satisfactoriamente.";
		            $this->notificacion_error = false;				 
				}
				else
				{
					$this->notificacion = "ERROR. No se pudo registrar el nuevo producto.";
		            $this->notificacion_error = true;
		 		}
				 
		 }
		 else
		 {
		     $this->notificacion = validation_errors();
			 $this->notificacion_error = true;
		 
		 }
		 if($this->notificacion_error == true){	
			$datos['producto'] 	= $producto;
			$datos['um'] = $id_um;
			$datos['categoria'] = $id_categoria;
			$datos['valor_alarma'] = $valor_alarma;
			$datos['producto_terminado'] = $pt;
			$categorias = $this->M_produccion->get_p_categorias();
			$datos['categorias'] 		= $categorias;
			$productos_ventas = $this->M_configuracion->obt_productos();        		
        	$datos['productos_ventas'] = $productos_ventas;
			$ums = $this->M_produccion->get_ums();
        	$datos['ums'] = $ums;
			$datos['notificacion'] = $this->notificacion ? $this->notificacion : "Error registrando el nuevo producto.";
          	$datos['notificacion_error'] = $this->notificacion_error;
			$datos['modo_edicion'] = false;
			
			$this->load->view('lte_header', $datos);
			$this->load->view('produccion/v_productos', $datos);
			$this->load->view('lte_footer', $datos); 
		 
		 }else
			$this->p_productos(); 
		 
	}
	/********************************************************************************************************/
	// Editando la tipo
	public function editar_p_producto($id_actual)
	{
		$resultado = $this->M_produccion->get_p_productos($id_actual);
		
        if (empty($resultado))
        {
            show_404();
        } 
        $id_producto = $id_actual;		   
        $producto = $resultado['nombre'];		   
        $id_categoria = $resultado['id_categoria'];		   
        $id_um = $resultado['id_um'];		   
        $valor_alarma = $resultado['valor_alarma'];		   
        $pv = $resultado['id_producto_venta'];		   
        $pt = $resultado['producto_terminado'];		   
                
        $datos['modo_edicion'] = true;
        $datos['notificacion'] = $this->notificacion ? $this->notificacion : "Modificando el producto";
        $datos['notificacion_error'] = $this->notificacion_error;		   
        $productos_ventas = $this->M_configuracion->obt_productos();        		
        $datos['productos_ventas'] = $productos_ventas;	
        $datos['id_actual']  	= $id_actual;
        $datos['id_producto'] 	= $id_producto;       
        $datos['producto']  	= $producto;
        $datos['categoria']    	= $id_categoria;
        $datos['um']    		= $id_um;
        $datos['pv']    		= $pv;
        $datos['pt']    		= $pt;
		$datos['valor_alarma']  = $valor_alarma;		
        $ums = $this->M_produccion->get_ums();
        $datos['ums'] = $ums; 
        $categorias = $this->M_produccion->get_p_categorias();
        $datos['categorias'] = $categorias; 
		$this->load->view('lte_header', $datos);
 	    $this->load->view('produccion/v_productos', $datos);
	    $this->load->view('lte_footer', $datos);
	}
	/*********************************************************************************************************/
	// Modificando un tipo
    public function modificar_p_producto()
    {
		 $id_actual = $this->input->post('id_actual');
		 $id_producto = $this->input->post('id_producto');
		 $producto = $this->input->post('producto');
		 $id_um = $this->input->post('sel_um');
		 $pt = $this->input->post('sel_pt');
		 $id_categoria = $this->input->post('sel_categoria');
		 $valor_alarma = $this->input->post('valor_alarma');
		 $prod_venta = $this->input->post('sel_prod_ventas');
		 		 
		 $this->load->library('form_validation');
		 
		 $this->form_validation->set_rules('producto', 'Producto', 'required');
		 $this->form_validation->set_rules('valor_alarma', 'Valor alarma', 'required|numeric');
		 
		 if (   $this->form_validation->run() == true)
		 {
		 
			 $modificado = $this->M_produccion->upd_p_producto($id_actual, $id_producto, $producto, $id_categoria,$valor_alarma, $id_um, $prod_venta, $pt);
			 
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
			$datos['producto'] 	= $producto;
			$datos['categoria'] = $id_categoria;
			$datos['um'] = $id_um;
			$datos['valor_alarma'] = $valor_alarma;
			$categorias = $this->M_produccion->get_p_categorias();
			$datos['categorias'] 		= $categorias;
			$ums = $this->M_produccion->get_p_ums();
			$datos['ums'] 		= $ums;
			$datos['pt']    		= $pt;
			$productos_ventas = $this->M_configuracion->obt_productos();        		
        	$datos['productos_ventas'] = $productos_ventas;
			$datos['notificacion'] = $this->notificacion ? $this->notificacion : "Error. No se pudo modificar el producto. Verifique los datos especificados.";
          	$datos['notificacion_error'] = $this->notificacion_error;
			$datos['modo_edicion'] = true;
			
			$this->load->view('lte_header', $datos);
			$this->load->view('produccion/v_productos', $datos);
			$this->load->view('lte_footer', $datos); 
		 
		 }else		 
		 	$this->p_productos();
    }
	
	/***********************************************************************************************************/
	// Confirmar eliminación de un tipo
	public function cfe_p_producto($id_producto)
	{
		$datos['id_producto'] = $id_producto;
		
		$this->load->view('lte_header', $datos);
 	    $this->load->view('produccion/vcan_productos', $datos);
	    $this->load->view('lte_footer', $datos);
	}
	/*******************************************************************************************************/
	// Cancelar tipo
    public function cancelar_p_producto()
	{
		$id_producto = $this->input->post('id_producto');
		$cancelado = $this->M_produccion->delete_p_producto($id_producto);
		
		if ($cancelado == 1)
	    { 
		   $this->not_fcliente = "Se eliminó el producto correctamente.";
		}
		else
		{
		   $this->not_fcliente = "ERROR. No se pudo eliminar el producto. Verifique los datos especificados.";
		}
		
		$this->p_productos();

	}
	/**********************************************************************************************/
	/**********************************************************************************************************/
	//********************** almacenes   *******************************************************************
   
	// Listado de tipo
    public function almacenes()
	{
        $almacenes = $this->M_produccion->get_almacenes();
			
        $datos['almacenes'] 		= $almacenes;        
		$datos['total_almacenes'] = count($almacenes);
        
		$this->load->view('lte_header', $datos);
		$this->load->view('produccion/v_listado_almacenes', $datos);
		$this->load->view('lte_footer', $datos);

	}	
	
	/***********************************************************************************************************/
	public function nuevo_almacen()
	{		
		$datos['notificacion'] = $this->notificacion ? $this->notificacion : "Especifique los datos del nuevo almacen:";
		$datos['notificacion_error'] = $this->notificacion_error;
		$datos['modo_edicion'] = false;		
			
		$this->load->view('lte_header', $datos);
		$this->load->view('produccion/v_almacenes', $datos);
		$this->load->view('lte_footer', $datos);	
	}
	/**********************************************************************************************/
	// Registrando un tipo
    public function registrar_almacen()
    {
		 $almacen = $this->input->post('almacen');
		 
		 $this->load->library('form_validation');
		 
		 $this->form_validation->set_rules('almacen', 'Almacén', 'required');
			
		 if ($this->form_validation->run() == true )
		 {
			 $registrado = $this->M_produccion->set_almacen( $almacen);
			 
			 $mensaje = "";
			 if ($registrado == 1)
				 { 
					$this->notificacion = "El nuevo almacen se registró satisfactoriamente.";
		            $this->notificacion_error = false;
					 
				 }
				 else
				 {
					$this->notificacion = "ERROR. No se pudo registrar el nuevo almacen.";
		            $this->notificacion_error = true;
		 }
				 
		 }
		 else
		 {
		     $this->notificacion = validation_errors();
			 $this->notificacion_error = true;
		 
		 }
		 if($this->notificacion_error == true){	
			$datos['almacen'] = $almacen;
			
			$datos['notificacion'] = $this->notificacion ? $this->notificacion : "Error registrando el nuevo almacen.";
          	$datos['notificacion_error'] = $this->notificacion_error;
			$datos['modo_edicion'] = false;
			
			$this->load->view('lte_header', $datos);
			$this->load->view('produccion/v_almacenes', $datos);
			$this->load->view('lte_footer', $datos); 
		 
		 }else
			$this->almacenes(); 
		 
    }
	/********************************************************************************************************/
	// Editando la tipo
	public function editar_almacen($id_actual)
	{
		$resultado = $this->M_produccion->get_almacenes($id_actual);
		
        if (empty($resultado))
        {
            show_404();
        } 
        $id_almacen = $id_actual;		   
        $almacen = $resultado['nombre'];		   
                
        $datos['modo_edicion'] = true;
        $datos['notificacion'] = $this->notificacion ? $this->notificacion : "Modificando el almacen";
        $datos['notificacion_error'] = $this->notificacion_error;		   
        
        $datos['id_actual']  = $id_actual;
        $datos['id_almacen']    = $id_almacen;
        $datos['almacen']  	    = $almacen;
		
		$this->load->view('lte_header', $datos);
 	    $this->load->view('produccion/v_almacenes', $datos);
	    $this->load->view('lte_footer', $datos);
	}
	/*********************************************************************************************************/
	// Modificando un tipo
    public function modificar_almacen()
    {
		 $id_actual = $this->input->post('id_actual');
		 $id_almacen = $this->input->post('id_almacen');
		 $almacen = $this->input->post('almacen');
		 		 
		 $this->load->library('form_validation');
		 
		 $this->form_validation->set_rules('almacen', 'Almacén', 'required');
		 
		 if (   $this->form_validation->run() == true)
		 {
		 
			 $modificado = $this->M_produccion->upd_almacen($id_actual, $id_almacen,  $almacen);
			 
   		     if ($modificado == 1)
			 { 
				 $this->notificacion = "El almacen se modificó satisfactoriamente.";
		         $this->notificacion_error = false;
			 }
			 else
			 {
				 $this->notificacion = "ERROR. No se pudo modificar el almacen. Verifique los datos especificados.";
		         $this->notificacion_error = true;
		 }
				 
		 }
		 else
		 {
		     $this->notificacion = validation_errors();
			 $this->notificacion_error = true;
			 
		 }
		 if($this->notificacion_error == true){		
			$datos['id_actual'] = $id_actual;
			$datos['id_almacen']   = $id_almacen;
			$datos['almacen'] = $almacen;
			
			$datos['notificacion'] = $this->notificacion ? $this->notificacion : "Error. No se pudo modificar el almacen. Verifique los datos especificados.";
          	$datos['notificacion_error'] = $this->notificacion_error;
			$datos['modo_edicion'] = true;
			
			$this->load->view('lte_header', $datos);
			$this->load->view('produccion/v_almacenes', $datos);
			$this->load->view('lte_footer', $datos); 
		 
		 }else
		 
		 $this->almacenes();
    }
   
	/***********************************************************************************************************/
	// Confirmar eliminación de un tipo
	public function cfe_almacen($id_almacen)
	{
		$datos['id_almacen'] = $id_almacen;
		
		$this->load->view('lte_header', $datos);
 	    $this->load->view('produccion/vcan_almacenes', $datos);
	    $this->load->view('lte_footer', $datos);
	}
	/*******************************************************************************************************/
	// Cancelar tipo
    public function cancelar_almacen()
	{
		$id_almacen = $this->input->post('id_almacen');
		$cancelado = $this->M_produccion->delete_almacen($id_almacen);
		
		if ($cancelado == 1)
	    { 
		   $this->not_fcliente = "Se eliminó el almacen correctamente.";
		}
		else
		{
		   $this->not_fcliente = "ERROR. No se pudo eliminar el almacen. Verifique los datos especificados.";
		}
		
		$this->almacenes();

	}
	
	 /**********************************************************************************************************/
	//********************** um   *******************************************************************
   
	// Listado de tipo
    public function ums()
	{
        $ums = $this->M_produccion->get_ums();
			
        $datos['ums'] 		= $ums;        
		$datos['total_ums'] = count($ums);
        
		$this->load->view('lte_header', $datos);
		$this->load->view('produccion/v_listado_ums', $datos);
		$this->load->view('lte_footer', $datos);

	}	
	
	/***********************************************************************************************************/
	public function nuevo_um()
	{		
		$datos['notificacion'] = $this->notificacion ? $this->notificacion : "Especifique los datos del nueva unidad de medida:";
		$datos['notificacion_error'] = $this->notificacion_error;
		$datos['modo_edicion'] = false;		
			
		$this->load->view('lte_header', $datos);
		$this->load->view('produccion/v_ums', $datos);
		$this->load->view('lte_footer', $datos);	
	}
	/**********************************************************************************************/
	// Registrando un tipo
    public function registrar_um()
    {
		 $um = $this->input->post('um');
		 
		 $this->load->library('form_validation');
		 
		 $this->form_validation->set_rules('um', 'Unidad de medida', 'required');
			
		 if ($this->form_validation->run() == true )
		 {
			 $registrado = $this->M_produccion->set_um( $um);
			 
			 $mensaje = "";
			 if ($registrado == 1)
				 { 
					$this->notificacion = "El nueva unidad de medida se registró satisfactoriamente.";
		            $this->notificacion_error = false;
					 
				 }
				 else
				 {
					$this->notificacion = "ERROR. No se pudo registrar el nueva unidad de medida.";
		            $this->notificacion_error = true;
		 }
				 
		 }
		 else
		 {
		     $this->notificacion = validation_errors();
			 $this->notificacion_error = true;
		 
		 }
		 if($this->notificacion_error == true){	
			$datos['um'] = $um;
			
			$datos['notificacion'] = $this->notificacion ? $this->notificacion : "Error registrando el nueva unidad de medida.";
          	$datos['notificacion_error'] = $this->notificacion_error;
			$datos['modo_edicion'] = false;
			
			$this->load->view('lte_header', $datos);
			$this->load->view('produccion/v_ums', $datos);
			$this->load->view('lte_footer', $datos); 
		 
		 }else
			$this->ums(); 
		 
    }
	/********************************************************************************************************/
	// Editando la tipo
	public function editar_um($id_actual)
	{
		$resultado = $this->M_produccion->get_ums($id_actual);
		
        if (empty($resultado))
        {
            show_404();
        } 
        $id_um = $id_actual;		   
        $um = $resultado['nombre'];		   
                
        $datos['modo_edicion'] = true;
        $datos['notificacion'] = $this->notificacion ? $this->notificacion : "Modificando la unidad de medida";
        $datos['notificacion_error'] = $this->notificacion_error;		   
        
        $datos['id_actual']  = $id_actual;
        $datos['id_um']    = $id_um;
        $datos['um']  	    = $um;
		
		$this->load->view('lte_header', $datos);
 	    $this->load->view('produccion/v_ums', $datos);
	    $this->load->view('lte_footer', $datos);
	}
	/*********************************************************************************************************/
	// Modificando un tipo
    public function modificar_um()
    {
		 $id_actual = $this->input->post('id_actual');
		 $id_um = $this->input->post('id_um');
		 $um = $this->input->post('um');
		 		 
		 $this->load->library('form_validation');
		 
		 $this->form_validation->set_rules('um', 'Unidad de medida', 'required');
		 
		 if (   $this->form_validation->run() == true)
		 {
		 
			 $modificado = $this->M_produccion->upd_um($id_actual, $id_um,  $um);
			 
   		     if ($modificado == 1)
			 { 
				 $this->notificacion = "La unidad de medida se modificó satisfactoriamente.";
		         $this->notificacion_error = false;
			 }
			 else
			 {
				 $this->notificacion = "ERROR. No se pudo modificar la unidad de medida. Verifique los datos especificados.";
		         $this->notificacion_error = true;
		 }
				 
		 }
		 else
		 {
		     $this->notificacion = validation_errors();
			 $this->notificacion_error = true;
			 
		 }
		 if($this->notificacion_error == true){		
			$datos['id_actual'] = $id_actual;
			$datos['id_um']   = $id_um;
			$datos['um'] = $um;
			
			$datos['notificacion'] = $this->notificacion ? $this->notificacion : "Error. No se pudo modificar la unidad de medida. Verifique los datos especificados.";
          	$datos['notificacion_error'] = $this->notificacion_error;
			$datos['modo_edicion'] = true;
			
			$this->load->view('lte_header', $datos);
			$this->load->view('produccion/v_ums', $datos);
			$this->load->view('lte_footer', $datos); 
		 
		 }else
		 
		 $this->ums();
    }
   
	/***********************************************************************************************************/
	// Confirmar eliminación de un tipo
	public function cfe_um($id_um)
	{
		$datos['id_um'] = $id_um;
		
		$this->load->view('lte_header', $datos);
 	    $this->load->view('produccion/vcan_ums', $datos);
	    $this->load->view('lte_footer', $datos);
	}
	/*******************************************************************************************************/
	// Cancelar tipo
    public function cancelar_um()
	{
		$id_um = $this->input->post('id_um');
		$cancelado = $this->M_produccion->delete_um($id_um);
		
		if ($cancelado == 1)
	    { 
		   $this->not_fcliente = "Se eliminó la unidad de medida correctamente.";
		}
		else
		{
		   $this->not_fcliente = "ERROR. No se pudo eliminar la unidad de medida. Verifique los datos especificados.";
		}
		
		$this->ums();

	}
	
	 /**********************************************************************************************************/
	  //***************** Editando el producto campaña **********************************************/
	public function editar_producto_asociados($id_producto, $id_categoria)
	{
		$resultado = $this->M_produccion->get_p_productos($id_producto);		
		$resultado1 = $this->M_produccion->get_p_categorias($id_categoria);

	   if (empty($resultado))
	   {
		   show_404();
	   } 
	   
	   	   
	   $datos['id_producto'] = $id_producto;
	   $datos['id_categoria'] = $id_categoria;
	   $producto = $resultado['nombre'];	   
	   $datos['producto'] = $producto;
	   $categoria = $resultado1['nombre'];		 		 
	   $datos['categoria'] = $categoria;
	   

	   $internos 			= $this->M_produccion->get_internos( $id_categoria);
	   $producto_asociados 	= $this->M_produccion->get_producto_asociados($id_producto, $id_categoria);
	   		
	   $datos['internos']  				= $internos;
	   $datos['producto_asociados']  	= $producto_asociados;

	      
	   $datos['modo_edicion'] = true;
	   $datos['notificacion'] = 'Asignándole internos al producto: '  . $producto;

	   $this->load->view('lte_header', $datos);
	   $this->load->view('produccion/v_producto_asociados', $datos);
	   $this->load->view('lte_footer', $datos);
   	}

	public function agregar_producto_asociados()
	{
	  	$id_producto= $this->input->post('id_producto');
	  	$id_categoria = $this->input->post('id_categoria');
	  	$id_interno = $this->input->post('sel_internos');	  
	  	$cantidad = $this->input->post('cantidad');

		// validar que no se repita 		
	   $prod = $this->M_produccion->get_internos_exi($id_producto,  $id_categoria);
	   if (empty($prod))
	   {
		   	$resultado = $this->M_produccion->set_producto_asociados($id_producto, $id_interno, $cantidad);
			$this->editar_producto_asociados($id_producto, $id_categoria);
	   } else{
		   show_error('Ya existe un producto con un interno');
	   }
	 
	}  	
   
	public function cfe_producto_asociados($id_asociado, $id_producto, $id_categoria)
	{
		  $datos['id_asociado'] = $id_asociado;
		  $datos['id_producto'] = $id_producto;
		  $datos['id_categoria'] = $id_categoria;
	  
		  $this->load->view('lte_header', $datos);
	   $this->load->view('produccion/vcan_producto_asociados', $datos);
		  $this->load->view('lte_footer', $datos);
	}
	public function cancelar_producto_asociados()
	{
	  $id_producto = $this->input->post('id_producto');
	  $id_asociado = $this->input->post('id_asociado');
	  $id_categoria = $this->input->post('id_categoria');

	  $cancelado = $this->M_produccion->delete_producto_asociados($id_asociado);
	  
	  if ($cancelado == 1)
	  { 
		 $this->not_fcliente = "Se eliminó la compra correctamente.";
	  }
	  else
	  {
		 $this->not_fcliente = "ERROR. No se pudo eliminar la compra. Verifique los datos especificados.";
	  }
	  
	  $this->editar_producto_asociados($id_producto, $id_categoria);

	}
	/*******************************************************************************************************/
	 //***************** Editando el almacen producto **********************************************/
	public function editar_almacen_productos($id_almacen)
	{
	  $resultado = $this->M_produccion->get_almacenes($id_almacen);
	  if (empty($resultado))
	  {
		  show_404();
	  } 
	  
	  $almacen = $resultado['nombre'];
	  $datos['id_almacen'] = $id_almacen;
	  $datos['almacen'] = $almacen;

	  $productos = $this->M_produccion->get_p_productos();	 
	  $datos['productos'] = $productos;

	  $resultado1 = $this->M_produccion->get_almacen_productos($id_almacen);
	  
	  $datos['almacen_productos'] = $resultado1;
	  
	  $datos['modo_edicion'] = true;
	  $datos['notificacion'] = 'Asignándole compras al almacén: '  . $almacen;

	  $this->load->view('lte_header', $datos);
	  $this->load->view('produccion/v_almacen_productos', $datos);
	  $this->load->view('lte_footer', $datos);
  	}

	public function agregar_almacen_productos()
	{
	 $id_almacen= $this->input->post('id_almacen');
	 $id_producto = $this->input->post('sel_productos');	 
	 $valor = $this->input->post('valor');

	   // validar que no se repita 		
	  $comp = $this->M_produccion->get_inventario($id_almacen,  $id_producto);
	  if (empty($comp))
	  {
		  $resultado = $this->M_produccion->set_almacen_productos($id_almacen, $id_producto, $valor);
			$this->editar_almacen_productos($id_almacen);
	  } else{
		  show_error('Ya existe ese producto en el almacén');
	  }
	
	}  	
  
	public function cfe_almacen_productos($id_inventario, $id_almacen)
	{
		$datos['id_inventario'] = $id_inventario;
		$datos['id_almacen'] = $id_almacen;
	 
		$this->load->view('lte_header', $datos);
		$this->load->view('produccion/vcan_almacen_productos', $datos);
		$this->load->view('lte_footer', $datos);
	}
	public function cancelar_almacen_productos()
	{
	 	$id_inventario = $this->input->post('id_inventario');
	 	$id_almacen = $this->input->post('id_almacen');

	 	$cancelado = $this->M_produccion->delete_almacen_productos($id_inventario);
	 
		if ($cancelado == 1)
		{ 
			$this->not_fcliente = "Se eliminó el producto correctamente.";
		}
		else
		{
			$this->not_fcliente = "ERROR. No se pudo eliminar producto. Verifique los datos especificados.";
		}
	 
	 	$this->editar_almacen_productos($id_almacen);

	}
	 /*******************************************************************************************************/
	 /**********************************************************************************************************/
	//********************** um   *******************************************************************
   
	// Listado de tipo
    public function inventario()
	{
        $inventarios = $this->M_produccion->get_almacen_productos();
		$productos = $this->M_produccion->get_p_productos();

        $datos['inventarios'] 		= $inventarios;        
		$datos['productos'] = $productos;
        
		$this->load->view('lte_header', $datos);
		$this->load->view('produccion/v_listado_inventarios', $datos);
		$this->load->view('lte_footer', $datos);

	}	
	public function movimiento()
	{
		$inventarios = $this->M_produccion->get_almacen_productos();
		$datos['inventarios'] 		= $inventarios;        
		$almacenes = $this->M_produccion->get_almacenes();
		$datos['almacenes'] 		= $almacenes;        
		$productos = $this->M_produccion->get_p_productos();			
		$datos['productos'] 		= $productos; 
		
		$this->load->view('lte_header', $datos);
		$this->load->view('produccion/v_listado_movimiento', $datos);
		$this->load->view('lte_footer', $datos);
	}
	public function mover_producto()
	{
		$id_almacen_des= $this->input->post('sel_almacenes');
		$id_inventario = $this->input->post('id_inventario');	 
		$cantidad = $this->input->post('cantidad');
		$inventario = $this->M_produccion->get_inventario_productos($id_inventario);
		//validar que la cantidad es permitidad
		if($inventario['final'] < $cantidad){
		   show_error('La cantidad a mover sobrepasa la existencia');
		}
		$id_producto = $inventario['id_producto'];
		$id_almacen_ori = $inventario['id_almacen'];
		$salida = $inventario['salida'];
		// mover los productos
		$resultado = $this->M_produccion->set_mov_productos($id_almacen_ori, $id_almacen_des, $id_producto, $cantidad);

		// validar si en el almacen destino ya existe el producto para actualizar sino para insertar.
		$existe = $this->M_produccion->get_existencia_producto($id_producto, $id_almacen_des);
		if (empty($existe))
		{
			$resultado = $this->M_produccion->set_actualizar_productos($id_almacen_ori, $id_almacen_des, $id_producto, $cantidad,$salida,0);			  
		} else{
			$entrada = $existe['entrada'];
			$resultado = $this->M_produccion->upd_actualizar_productos($id_almacen_ori, $id_almacen_des, $id_producto, $cantidad, $salida, $entrada);
		}
		
		redirect('movimiento');
	}
	public function entrar_producto()
	{
		$id_almacen_des= $this->input->post('sel_almacenes');
		$id_producto = $this->input->post('sel_productos');	 
		$cantidad = $this->input->post('cantidad');
		$observacion = $this->input->post('observacion');

		// mover los productos
		$resultado = $this->M_produccion->set_ent_productos($id_almacen_des, $id_producto, $cantidad, $observacion);

		// validar si en el almacen destino ya existe el producto para actualizar sino para insertar.
		$existe = $this->M_produccion->get_existencia_producto($id_producto, $id_almacen_des);
		if (empty($existe))
		{
			$resultado = $this->M_produccion->set_ent_actualizar_productos($id_almacen_des, $id_producto, $cantidad);			  
		} else{
			$entrada = $existe['entrada'];
			$resultado = $this->M_produccion->upd_ent_actualizar_productos($id_almacen_des, $id_producto, $cantidad,$entrada);
		}
		
		redirect('movimiento');
	}
	public function ver_movimientos()
	{
		$movimientos 				= $this->M_produccion->get_movimientos();
		$datos['movimientos'] 		= $movimientos; 
		$this->load->view('lte_header', $datos);
		$this->load->view('produccion/v_ver_movimientos', $datos);
		$this->load->view('lte_footer', $datos);
	}
	public function ensamblar_producto()
	{
		$id_almacen_des= $this->input->post('sel_almacenes');
		$id_producto = $this->input->post('sel_productos');	 
		$cantidad = $this->input->post('cantidad');
		$observacion = $this->input->post('observacion');

		$internos = $this->M_produccion->get_producto_internos($id_producto);
		$existencias = $this->M_produccion->get_almacen_productos(5);
		// validar si hay productos internos suficientes para el ensamblado
		$valido = 1;
		$comentario='';
		for ($i=0; $i <count($internos) ; $i++) {
			$flag = 0; 
			for ($k=0; $k < count($existencias); $k++) { 
				if ($internos[$i]['id_interno'] == $existencias[$k]['id_producto']) {
					$flag = 1; 
					if ($internos[$i]['cantidad']*$cantidad > $existencias[$k]['final']) {
						$valido = 0;
						$comentario = $comentario.' '.$internos[$i]['interno'];
					}
				}
			}
			if($flag == 0){
				$valido = 0;
				$comentario = $comentario.' '.$internos[$i]['interno'];
			}
		}


		if($valido == 0){
			show_error('No existe en cantidad suficientes los productos '. $comentario .' en la fabrica de ensamblaje para armar el producto seleccionado');
		}
		//++++++++++++++++++++++++++++++
		for ($i=0; $i <count($internos) ; $i++) {			
			for ($k=0; $k < count($existencias); $k++) { 
				if ($internos[$i]['id_interno'] == $existencias[$k]['id_producto']) {
					// mover los productos
					$resultado = $this->M_produccion->set_sal_productos($existencias[$k]['id_almacen'], $existencias[$k]['id_producto'],$internos[$i]['cantidad']*$cantidad, 'Ensamble de '.$internos[$i]['producto']);
					// actualizar existencia
					$resultado = $this->M_produccion->upd_sal_actualizar_productos($existencias[$k]['id_almacen'],$existencias[$k]['id_producto'],$internos[$i]['cantidad']*$cantidad,$existencias[$k]['salida']);
				}
			}
			
		}
		// mover los productos
		$resultado = $this->M_produccion->set_ent_productos($id_almacen_des, $id_producto, $cantidad, $observacion);

		// validar si en el almacen destino ya existe el producto para actualizar sino para insertar.
		$existe = $this->M_produccion->get_existencia_producto($id_producto, $id_almacen_des);
		if (empty($existe))
		{
			$resultado = $this->M_produccion->set_ent_actualizar_productos($id_almacen_des, $id_producto, $cantidad);			  
		} else{
			$entrada = $existe['entrada'];
			$resultado = $this->M_produccion->upd_ent_actualizar_productos($id_almacen_des, $id_producto, $cantidad,$entrada);
		}
		
		
		redirect('movimiento');
	}
	/***********************************************************************************************************/
	 /**********************************************************************************************************/
	//********************** costo   *******************************************************************
	// Listado de costo
    public function costos()
	{
		$res = $this->M_produccion->actualizar_costo();
        $costos = $this->M_produccion->get_costos();
			
        $datos['costos'] 		= $costos;        
		$datos['total_costos'] = count($costos);
        
		$this->load->view('lte_header', $datos);
		$this->load->view('produccion/v_listado_costos', $datos);
		$this->load->view('lte_footer', $datos);

	}	
	public function nuevo_costo()
	{		
		/*$datos['notificacion'] = $this->notificacion ? $this->notificacion : "Especifique los datos del nuevo costo:";
		$datos['notificacion_error'] = $this->notificacion_error;
		$datos['modo_edicion'] = false;		
        $productos = $this->M_produccion->get_p_productos();
        $datos['productos'] = $productos;		
		$this->load->view('lte_header', $datos);
		$this->load->view('produccion/v_costos', $datos);
		$this->load->view('lte_footer', $datos);*/
		$re = $this->M_produccion->tipocambio_actual('USD');

		$datos = array(
			"tipocambio" => $re['valor'],
			"productos" => $this->M_produccion->get_p_productos(),
			"componentes" => $this->M_produccion->get_componentes(),
			"modo_edicion" => false
		);
		$this->load->view('lte_header', $datos);
		$this->load->view('produccion/costos_add', $datos);
		$this->load->view('lte_footer', $datos);
			
	}
	// Registrando un tipo
    public function registrar_costo()
    {
		$tipo_cambio 		= $this->input->post('tipocambio_actual');

		$prec_exp 		= $this->input->post('prec_exp');
		$prec_con 		= $this->input->post('prec_con');
		$prec_305		= $this->input->post('prec_305');
		$prec_9015 		= $this->input->post('prec_9015');
		$prec_pvp 		= $this->input->post('prec_pvp');
		$prec_pro 		= $this->input->post('prec_pro');
		
		$m_prec_exp 	= $this->input->post('m_prec_exp');
		$m_prec_con 	= $this->input->post('m_prec_con');
		$m_prec_305		= $this->input->post('m_prec_305');
		$m_prec_9015 	= $this->input->post('m_prec_9015');
		$m_prec_pvp 	= $this->input->post('m_prec_pvp');
		$m_prec_pro 	= $this->input->post('m_prec_pro');

		$id_producto 	= $this->input->post('id_producto');
		
		$id_componentes	= $this->input->post('id_componentes');
		$cantidades		= $this->input->post('cantidades');
		$costos 		= $this->input->post('costos');
		$exportacion 	= $this->input->post('exportacion');
		$nacional 		= $this->input->post('nacional');
		
		$iibb 			= $this->input->post('iibb');
		$com_vtas		= $this->input->post('com_vtas');
		$financ 		= $this->input->post('financ');
		$iigg 			= $this->input->post('iigg');
		
		$subtotal 		= $this->input->post('subtotal');
		$total 			= $this->input->post('total');
		$m_total 		= $this->input->post('m_total');
		 
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('prec_exp', 'precio exportación', 'required|numeric');		
		$this->form_validation->set_rules('prec_con', 'precio contado', 'required|numeric');
		$this->form_validation->set_rules('prec_305', 'precio 30 5%', 'required|numeric');		
		$this->form_validation->set_rules('prec_9015', 'precio 90 15%', 'required|numeric');		
		$this->form_validation->set_rules('prec_pvp', 'precio PVP', 'required|numeric');
		$this->form_validation->set_rules('prec_pro', 'precio promedio', 'required|numeric');
		$this->form_validation->set_rules('m_prec_exp','Multiplicador precio exportación', 'required|numeric');	
		$this->form_validation->set_rules('m_prec_con', 'Multiplicador precio contado', 'required|numeric');
		$this->form_validation->set_rules('m_prec_305', 'Multiplicador precio 30 5%', 'required|numeric');		
		$this->form_validation->set_rules('m_prec_9015', 'Multiplicador precio 90 15%', 'required|numeric');	
		$this->form_validation->set_rules('m_prec_pvp', 'Multiplicador precio PVP', 'required|numeric');
		$this->form_validation->set_rules('m_prec_pro', 'Multiplicador precio promedio', 'required|numeric');
		

		$id_producto 	= $this->input->post('id_producto');

		$this->form_validation->set_rules('iibb', 'iibb', 'required|numeric');
		$this->form_validation->set_rules('com_vtas', 'com_vtas', 'required|numeric');
		$this->form_validation->set_rules('financ', 'financ', 'required|numeric');
		$this->form_validation->set_rules('iigg', 'iigg', 'required|numeric');
		$this->form_validation->set_rules('total', 'Total', 'required|numeric');
		$this->form_validation->set_rules('subtotal', 'Subtotal', 'required|numeric');
		$this->form_validation->set_rules('m_total', 'Multiplicador total', 'required|numeric');
			
		if ($this->form_validation->run() == true )
		{
			$data = array(
				'prec_exportacion' => $prec_exp,
				'prec_contado' => $prec_con,
				'prec_30_5' => $prec_305,
				'prec_90_15' => $prec_9015,
				'prec_pvp' => $prec_pvp,
				'prec_promedio' => $prec_pro,
				'm_prec_exportacion' => $m_prec_exp,
				'm_prec_contado' => $m_prec_con,
				'm_prec_30_5' => $m_prec_305,
				'm_prec_90_15' => $m_prec_9015,
				'm_prec_pvp' => $m_prec_pvp,
				'm_prec_promedio' => $m_prec_pro,
				'tipo_cambio' => $tipo_cambio,
				'id_producto' => $id_producto,
				'iibb' => $iibb,
				'com_vtas' => $com_vtas,
				'financ' => $financ,
				'iigg' => $iigg,
				'subtotal' => $subtotal,
				'total' => $total,
				'm_total' => $m_total
			);
			
	
			if ($this->M_produccion->save_costo($data)) {
				$idcosto = $this->M_produccion->lastID();				
				for ($i=0; $i < count($id_componentes); $i++) { 
					$data  = array(
						'id_costo' => $idcosto, 
						'id_componente' => $id_componentes[$i],
						'cantidad' => $cantidades[$i],
						'costo' => $costos[$i], 
						'exportacion'=> $exportacion[$i],
						'nacional'=> $nacional[$i]
					);
					
					$this->M_produccion->save_detalle($data);
		
				}
				redirect(base_url()."costos");
	
			}else{
				redirect(base_url()."nuevo_costo");
			} 
		}
		else
		{
			$this->notificacion = validation_errors();
			$this->notificacion_error = true;
		 
		}
		if($this->notificacion_error == true)
		{	
			$datos['iibb']		= $iibb;
			$datos['com_vtas'] 	= $com_vtas;
			$datos['financ'] 	= $financ;
			$datos['iigg'] 		= $iigg;
			$datos['producto'] 	= $id_producto;
			$productos 			= $this->M_produccion->get_p_productos();
			$datos['productos'] = $productos;

			$datos['notificacion'] = $this->notificacion ? $this->notificacion : "Error registrando el nuevo costo.";
          	$datos['notificacion_error'] = $this->notificacion_error;
			$datos['modo_edicion'] = false;
			
			$re = $this->M_produccion->tipocambio_actual('USD');

			$datos = array(
				"tipocambio" => $re['valor'],
				"productos" => $this->M_produccion->get_p_productos(),
				"componentes" => $this->M_produccion->get_componentes(),
				'prec_exp' => $prec_exp,
				'prec_con' => $prec_con,
				'prec_305' => $prec_305,
				'prec_9015' => $prec_9015,
				'prec_pvp' => $prec_pvp,
				'prec_pro' => $prec_pro,
				'm_prec_exp' => $m_prec_exp,
				'm_prec_con' => $m_prec_con,
				'm_prem_prec_305c_30_5' => $m_prec_305,
				'm_prec_9015' => $m_prec_9015,
				'm_prec_pvp' => $m_prec_pvp,
				'm_prec_pro' => $m_prec_pro,
				'tipo_cambio' => $tipo_cambio,
				'id_producto' => $id_producto,
				'iibb' => $iibb,
				'com_vtas' => $com_vtas,
				'financ' => $financ,
				'iigg' => $iigg,
				'subtotal' => $subtotal,
				'total' => $total,
				'm_total' => $m_total,
				'modo_edicion' => false
			);
			$this->load->view('lte_header', $datos);
			$this->load->view('produccion/costos_add', $datos);
			$this->load->view('lte_footer', $datos);
			
		}else
			$this->costos(); 
		 
	}
	/********************************************************************************************************/
	// Editando la tipo
	public function editar_costo($id_actual)
	{
		$resultado = $this->M_produccion->get_costos($id_actual);
		
        if (empty($resultado))
        {
            show_404();
        } 
        $id_costo 		= $id_actual;				   
        $id_producto	= $resultado['id_producto'];		   
        $producto		= $resultado['producto'];		   
		$iibb 			= $resultado['iibb'];
		$com_vtas		= $resultado['com_vtas'];
		$financ 		= $resultado['financ'];
		$iigg 			= $resultado['iigg'];
		$tipo_cambio 	= $resultado['tipo_cambio'];
		$prec_exp 		= $resultado['prec_exportacion'];
		$prec_con 		= $resultado['prec_contado'];
		$prec_305 		= $resultado['prec_30_5'];
		$prec_9015 		= $resultado['prec_90_15'];
		$prec_pvp 		= $resultado['prec_pvp'];
		$prec_pro 		= $resultado['prec_promedio'];
		$m_prec_exp 	= $resultado['m_prec_exportacion'];
		$m_prec_con 	= $resultado['m_prec_contado'];
		$m_prec_305 	= $resultado['m_prec_30_5'];
		$m_prec_9015 	= $resultado['m_prec_90_15'];
		$m_prec_pvp 	= $resultado['m_prec_pvp'];
		$m_prec_pro 	= $resultado['m_prec_promedio'];
		$subtotal 		= $resultado['subtotal'];
		$total 			= $resultado['total'];
		$m_total 		= $resultado['m_total'];
				
				

        $datos['modo_edicion'] = true;
        $datos['notificacion'] = $this->notificacion ? $this->notificacion : "Modificando el costo";
        $datos['notificacion_error'] = $this->notificacion_error;		   
        
        $datos['id_actual'] 	= $id_actual;
		$datos['id_costo'] 		= $id_costo;       
        $datos['iibb']  		= $iibb;
        $datos['com_vtas']  	= $com_vtas;
        $datos['financ']  		= $financ;
        $datos['iigg']  		= $iigg;
		$datos['id_producto']   = $id_producto;
		$datos['producto']   	= $producto;
		$datos['tipocambio']   	= $tipo_cambio;
		$datos['prec_exp']   	= $prec_exp;
		$datos['prec_con']   	= $prec_con;
		$datos['prec_305']  	= $prec_305;
		$datos['prec_9015']   	= $prec_9015;
		$datos['prec_pvp']   	= $prec_pvp;
		$datos['prec_pro']   	= $prec_pro;
		$datos['m_prec_exp']   	= $m_prec_exp;
		$datos['m_prec_con']   	= $m_prec_con;
		$datos['m_prec_305']   	= $m_prec_305;
		$datos['m_prec_9015']   = $m_prec_9015;
		$datos['m_prec_pvp']   	= $m_prec_pvp;
		$datos['m_prec_pro']   	= $m_prec_pro;
		$datos['subtotal']  	= $subtotal;
		$datos['total']   		= $total;
		$datos['m_total']   	= $m_total;
        $datos['productos'] 	= $this->M_produccion->get_p_productos();
        $datos['componentes'] 	= $this->M_produccion->get_componentes();
        $datos['detalles_costos'] 	= $this->M_produccion->get_costo_componentes($id_costo);
		$this->load->view('lte_header', $datos);
 	    $this->load->view('produccion/costos_add', $datos);
	    $this->load->view('lte_footer', $datos);
	}
	/*********************************************************************************************************/
	// Modificando un tipo
    public function modificar_costo()
    {
		$id_actual = $this->input->post('id_costo');
		$id_costo = $this->input->post('id_costo');
		$tipo_cambio 		= $this->input->post('tipocambio_actual');

		$prec_exp 		= $this->input->post('prec_exp');
		$prec_con 		= $this->input->post('prec_con');
		$prec_305		= $this->input->post('prec_305');
		$prec_9015 		= $this->input->post('prec_9015');
		$prec_pvp 		= $this->input->post('prec_pvp');
		$prec_pro 		= $this->input->post('prec_pro');
		
		$m_prec_exp 	= $this->input->post('m_prec_exp');
		$m_prec_con 	= $this->input->post('m_prec_con');
		$m_prec_305		= $this->input->post('m_prec_305');
		$m_prec_9015 	= $this->input->post('m_prec_9015');
		$m_prec_pvp 	= $this->input->post('m_prec_pvp');
		$m_prec_pro 	= $this->input->post('m_prec_pro');

		$id_producto 	= $this->input->post('id_producto');
		
		$id_componentes	= $this->input->post('id_componentes');
		$cantidades		= $this->input->post('cantidades');
		$costos 		= $this->input->post('costos');
		$exportacion 	= $this->input->post('exportacion');
		$nacional 		= $this->input->post('nacional');
		
		$iibb 			= $this->input->post('iibb');
		$com_vtas		= $this->input->post('com_vtas');
		$financ 		= $this->input->post('financ');
		$iigg 			= $this->input->post('iigg');
		
		$subtotal 		= $this->input->post('subtotal');
		$total 			= $this->input->post('total');
		$m_total 		= $this->input->post('m_total');
		 
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('prec_exp', 'precio exportación', 'required|numeric');		
		$this->form_validation->set_rules('prec_con', 'precio contado', 'required|numeric');
		$this->form_validation->set_rules('prec_305', 'precio 30 5%', 'required|numeric');		
		$this->form_validation->set_rules('prec_9015', 'precio 90 15%', 'required|numeric');		
		$this->form_validation->set_rules('prec_pvp', 'precio PVP', 'required|numeric');
		$this->form_validation->set_rules('prec_pro', 'precio promedio', 'required|numeric');
		$this->form_validation->set_rules('m_prec_exp','Multiplicador precio exportación', 'required|numeric');	
		$this->form_validation->set_rules('m_prec_con', 'Multiplicador precio contado', 'required|numeric');
		$this->form_validation->set_rules('m_prec_305', 'Multiplicador precio 30 5%', 'required|numeric');		
		$this->form_validation->set_rules('m_prec_9015', 'Multiplicador precio 90 15%', 'required|numeric');	
		$this->form_validation->set_rules('m_prec_pvp', 'Multiplicador precio PVP', 'required|numeric');
		$this->form_validation->set_rules('m_prec_pro', 'Multiplicador precio promedio', 'required|numeric');
		

		$id_producto 	= $this->input->post('id_producto');

		$this->form_validation->set_rules('iibb', 'iibb', 'required|numeric');
		$this->form_validation->set_rules('com_vtas', 'com_vtas', 'required|numeric');
		$this->form_validation->set_rules('financ', 'financ', 'required|numeric');
		$this->form_validation->set_rules('iigg', 'iigg', 'required|numeric');
		$this->form_validation->set_rules('total', 'Total', 'required|numeric');
		$this->form_validation->set_rules('subtotal', 'Subtotal', 'required|numeric');
		$this->form_validation->set_rules('m_total', 'Multiplicador total', 'required|numeric');
			
		if ($this->form_validation->run() == true )
		{
			$data = array(
				'prec_exportacion' => $prec_exp,
				'prec_contado' => $prec_con,
				'prec_30_5' => $prec_305,
				'prec_90_15' => $prec_9015,
				'prec_pvp' => $prec_pvp,
				'prec_promedio' => $prec_pro,
				'm_prec_exportacion' => $m_prec_exp,
				'm_prec_contado' => $m_prec_con,
				'm_prec_30_5' => $m_prec_305,
				'm_prec_90_15' => $m_prec_9015,
				'm_prec_pvp' => $m_prec_pvp,
				'm_prec_promedio' => $m_prec_pro,
				'tipo_cambio' => $tipo_cambio,
				'id_producto' => $id_producto,
				'iibb' => $iibb,
				'com_vtas' => $com_vtas,
				'financ' => $financ,
				'iigg' => $iigg,
				'subtotal' => $subtotal,
				'total' => $total,
				'm_total' => $m_total
			);
		 
			 $modificado = $this->M_produccion->upd_costo($id_actual, $data);
			 $ce = $this->M_produccion->delete_detalles_costo($id_costo);	
			 for ($i=0; $i < count($id_componentes); $i++) { 
				$data  = array(
					'id_costo' => $id_costo, 
					'id_componente' => $id_componentes[$i],
					'cantidad' => $cantidades[$i],
					'costo' => $costos[$i], 
					'exportacion'=> $exportacion[$i],
					'nacional'=> $nacional[$i]
				);
				
				$this->M_produccion->save_detalle($data);
	
			}
			redirect(base_url()."costos");
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
			$datos['id_actual'] 	= $id_actual;
			$datos['id_costo']   	= $id_costo;
			$datos['producto']   	= $id_producto;
			$datos['iibb'] 			= $iibb;
			$datos['com_vtas'] 		= $com_vtas;
			$datos['financ'] 		= $financ;
			$datos['iigg']			= $iigg;
			$productos = $this->M_produccion->get_p_productos();
        	$datos['productos'] = $productos;	
			$datos['notificacion'] = $this->notificacion ? $this->notificacion : "Error. No se pudo modificar el costo. Verifique los datos especificados.";
          	$datos['notificacion_error'] = $this->notificacion_error;
			$datos['modo_edicion'] = true;
			
			$this->load->view('lte_header', $datos);
			$this->load->view('produccion/costos_add', $datos);
			$this->load->view('lte_footer', $datos); 
		 
		}else		 
		 	$this->costos();
    }
	
	/***********************************************************************************************************/
	// Confirmar eliminación de un tipo
	public function cfe_costo($id_costo)
	{
		$datos['id_costo'] = $id_costo;
		
		$this->load->view('lte_header', $datos);
 	    $this->load->view('produccion/vcan_costos', $datos);
	    $this->load->view('lte_footer', $datos);
	}
	/*******************************************************************************************************/
	// Cancelar tipo
    public function cancelar_costo()
	{
		$id_costo = $this->input->post('id_costo');
		$cancelado = $this->M_produccion->delete_costo($id_costo);
		
		if ($cancelado == 1)
	    { 
		   $this->not_fcliente = "Se eliminó el costo correctamente.";
		}
		else
		{
		   $this->not_fcliente = "ERROR. No se pudo eliminar el costo. Verifique los datos especificados.";
		}
		
		$this->costos();

	}
	/**********************************************************************************************/
	//***************** Editando el producto campaña **********************************************/
	public function editar_costo_componentes($id_costo)
	{
		$resultado = $this->M_produccion->get_costos($id_costo);
		if (empty($resultado))
		{
			show_404();
		} 
		
		$producto = $resultado['producto'];		 		 
		$datos['id_costo'] = $id_costo;
		$datos['producto'] = $producto;
		$datos['componentes'] = $this->M_produccion->get_componentes();


		$resultado1 = $this->M_produccion->get_costo_componentes($id_costo);
		
		$datos['detalles'] = $resultado1;
		
		$datos['modo_edicion'] = true;
		$datos['notificacion'] = 'Asignándole componentes al costo de: '  . $producto;

		$this->load->view('lte_header', $datos);
		$this->load->view('produccion/v_costo_componentes', $datos);
		$this->load->view('lte_footer', $datos);
 	}

	public function agregar_costo_componentes()
	{
		$id_costo= $this->input->post('id_costo');
		$id_componente = $this->input->post('sel_componentes');
		$cantidad = $this->input->post('cantidad');

		// validar que no se repita 		
		$comp = $this->M_produccion->get_detalles_costos($id_costo, $id_componente);
		if (empty($comp))
		{
			$resultado = $this->M_produccion->set_costo_componentes($id_costo,$id_componente, $cantidad);
			$this->editar_costo_componentes($id_costo);
		} else{
			show_error('Ya existe producto con ese componente');
		}
   
	}  	
 
	public function cfe_costo_componentes($id_costo, $id_componente)
	{
		$datos['id_costo'] = $id_costo;
		$datos['id_componente'] = $id_componente;
	
		$this->load->view('lte_header', $datos);
	 	$this->load->view('produccion/vcan_costo_componentes', $datos);
		$this->load->view('lte_footer', $datos);
	}
	public function cancelar_costo_componentes()
	{
		$id_costo = $this->input->post('id_costo');
		$id_componente = $this->input->post('id_componente');

		$cancelado = $this->M_produccion->delete_costo_componentes($id_costo,$id_componente);
		
		if ($cancelado == 1)
		{ 
		$this->not_fcliente = "Se eliminó el componente correctamente.";
		}
		else
		{
		$this->not_fcliente = "ERROR. No se pudo eliminar el componente. Verifique los datos especificados.";
		}
		
		$this->editar_costo_componentes($id_costo);

	}
	public function historico()
	{
		
		$res = $this->M_produccion->actualizar_costo();
        $productos = $this->M_produccion->get_costos();
        $historico = $this->M_produccion->get_historico();
			
        $datos['productos'] 		= $productos;        
        $datos['historico'] 		= $historico;        
		        
		$this->load->view('lte_header', $datos);
		$this->load->view('produccion/v_listado_historico', $datos);
		$this->load->view('lte_footer', $datos);

	}
	/*******************************************************************************************************/
	//********************** ML   *******************************************************************
   
	// Listado de tipo
    public function mls()
	{
        $ums = $this->M_produccion->get_mls();
			
        $datos['mls'] 		= $ums;        
		$datos['total_mls'] = count($ums);
        
		$this->load->view('lte_header', $datos);
		$this->load->view('produccion/v_listado_mls', $datos);
		$this->load->view('lte_footer', $datos);

	}	
	
	/***********************************************************************************************************/
	public function nuevo_ml()
	{		
		$res = $this->M_operaciones->obtener_parametro('P_COSTO_VENTA_ML_PREMIUM');
		$row = $res->row();
		$premium_valor = $row->valor_decimal;  		
		$datos['premium_valor'] = $premium_valor;
		
		$res = $this->M_operaciones->obtener_parametro('P_COSTO_VENTA_ML_CLASICA');
		$row = $res->row();
		$clasica_valor = $row->valor_decimal;		
		$datos['clasica_valor'] = $clasica_valor;
		
		$datos['notificacion'] = $this->notificacion ? $this->notificacion : "Especifique los datos del producto de ML:";
		$datos['notificacion_error'] = $this->notificacion_error;
		$datos['modo_edicion'] = false;		
			
		$this->load->view('lte_header', $datos);
		$this->load->view('produccion/v_mls', $datos);
		$this->load->view('lte_footer', $datos);	
	}
	/**********************************************************************************************/
	// Registrando un tipo
    public function registrar_ml()
    {
		 $especificacion = $this->input->post('especificacion');
		 $producto 		= $this->input->post('producto');
		 $sku 			= $this->input->post('sku');
		 $pvp 			= $this->input->post('pvp');
		 $pvp_iva 		= $this->input->post('pvp_iva');
		 $cmv 			= $this->input->post('cmv');
		 $cmv_iva 		= $this->input->post('cmv_iva');
		 $margen_bruto 	= $this->input->post('margen_bruto');
		 $mult_spvp 	= $this->input->post('mult_spvp');
		 $premium 		= $this->input->post('premium');
		 $clasica 		= $this->input->post('clasica');
		 $mercado_envio = $this->input->post('mercado_envio');
		 $costo_total 	= $this->input->post('costo_total');
		 $constribucion = $this->input->post('constribucion');
		 $multiplicador = $this->input->post('multiplicador');
		 
		 $this->load->library('form_validation');
		 
		 $this->form_validation->set_rules('especificacion', 'Especificación', 'required');
		 $this->form_validation->set_rules('producto', 'Producto', 'required');
		 $this->form_validation->set_rules('sku', 'SKU', 'required');
		 $this->form_validation->set_rules('pvp', 'PVP', 'required');
		 $this->form_validation->set_rules('cmv', 'CMV', 'required');
			
		 if ($this->form_validation->run() == true )
		 {
			 $registrado = $this->M_produccion->set_ml( $especificacion,$producto,$sku,$pvp,$pvp_iva,$cmv,$cmv_iva,$margen_bruto,$mult_spvp,$premium,$clasica,$mercado_envio,$costo_total,$constribucion,$multiplicador);
			 
			 $mensaje = "";
			 if ($registrado == 1)
				 { 
					$this->notificacion = "El nuevo producto de ML se registró satisfactoriamente.";
		            $this->notificacion_error = false;
					 
				 }
				 else
				 {
					$this->notificacion = "ERROR. No se pudo registrar el nuevo producto de ML.";
		            $this->notificacion_error = true;
		 }
				 
		 }
		 else
		 {
		     $this->notificacion = validation_errors();
			 $this->notificacion_error = true;
		 
		 }
		 if($this->notificacion_error == true){	
			$datos['especificacion'] = $especificacion;
			$datos['producto'] = $producto;
			$datos['sku'] = $sku;
			$datos['pvp'] = $pvp;
			$datos['pvp_iva'] = $pvp_iva;
			$datos['cmv'] = $cmv;
			$datos['cmv_iva'] = $cmv_iva;
			$datos['margen_bruto'] = $margen_bruto;
			$datos['mult_spvp'] = $mult_spvp;
			$datos['premium'] = $premium;
			$datos['clasica'] = $clasica;
			$datos['mercado_envio'] = $mercado_envio;
			$datos['costo_total'] = $costo_total;
			$datos['constribucion'] = $constribucion;
			$datos['multiplicador'] = $multiplicador;
			
			$res = $this->M_operaciones->obtener_parametro('P_COSTO_VENTA_ML_PREMIUM');
			$row = $res->row();
			$premium_valor = $row->valor_decimal;  		
			$datos['premium_valor'] = $premium_valor;

			$res = $this->M_operaciones->obtener_parametro('P_COSTO_VENTA_ML_CLASICA');
			$row = $res->row();
			$clasica_valor = $row->valor_decimal;		
			$datos['clasica_valor'] = $clasica_valor;

			$datos['notificacion'] = $this->notificacion ? $this->notificacion : "Error registrando el nueva unidad de medida.";
          	$datos['notificacion_error'] = $this->notificacion_error;
			$datos['modo_edicion'] = false;
			
			$this->load->view('lte_header', $datos);
			$this->load->view('produccion/v_mls', $datos);
			$this->load->view('lte_footer', $datos); 
		 
		 }else
			$this->mls(); 
		 
    }
	/********************************************************************************************************/
	// Editando la tipo
	public function editar_ml($id_actual)
	{
		$resultado = $this->M_produccion->get_mls($id_actual);
		
        if (empty($resultado))
        {
            show_404();
        } 
        $id_ml 			= $id_actual;	
		$especificacion = $resultado['especificacion'];
		$producto 		= $resultado['producto'];
		$sku 			= $resultado['sku'];
		$pvp 			= $resultado['pvp'];
		$pvp_iva 		= $resultado['pvp_iva'];
		$cmv 			= $resultado['cmv'];
		$cmv_iva 		= $resultado['cmv_iva'];
		$margen_bruto 	= $resultado['margen_bruto'];
		$mult_spvp 		= $resultado['mult_spvp'];
		$premium 		= $resultado['premium'];
		$clasica 		= $resultado['clasica'];
		$mercado_envio 	= $resultado['mercado_envio'];
		$costo_total 	= $resultado['costo_total'];
		$constribucion 	= $resultado['constribucion'];
		$multiplicador 	= $resultado['multiplicador'];		   
		
		$res = $this->M_operaciones->obtener_parametro('P_COSTO_VENTA_ML_PREMIUM');
		$row = $res->row();
		$premium_valor = $row->valor_decimal;  		
		$datos['premium_valor'] = $premium_valor;

		$res = $this->M_operaciones->obtener_parametro('P_COSTO_VENTA_ML_CLASICA');
		$row = $res->row();
		$clasica_valor = $row->valor_decimal;		
		$datos['clasica_valor'] = $clasica_valor;

        $datos['modo_edicion'] = true;
        $datos['notificacion'] = $this->notificacion ? $this->notificacion : "Modificando la unidad de medida";
        $datos['notificacion_error'] = $this->notificacion_error;		   
        
        $datos['id_actual']  = $id_actual;
        $datos['id_ml']  = $id_actual;
        $datos['especificacion'] = $especificacion;
		$datos['producto'] = $producto;
		$datos['sku'] = $sku;
		$datos['pvp'] = $pvp;
		$datos['pvp_iva'] = $pvp_iva;
		$datos['cmv'] = $cmv;
		$datos['cmv_iva'] = $cmv_iva;
		$datos['margen_bruto'] = $margen_bruto;
		$datos['mult_spvp'] = $mult_spvp;
		$datos['premium'] = $premium;
		$datos['clasica'] = $clasica;
		$datos['mercado_envio'] = $mercado_envio;
		$datos['costo_total'] = $costo_total;
		$datos['constribucion'] = $constribucion;
		$datos['multiplicador'] = $multiplicador;
		
		$this->load->view('lte_header', $datos);
 	    $this->load->view('produccion/v_mls', $datos);
	    $this->load->view('lte_footer', $datos);
	}
	/*********************************************************************************************************/
	// Modificando un tipo
    public function modificar_ml()
    {
		 $id_actual = $this->input->post('id_actual');
		 $id_ml = $this->input->post('id_ml');
		 $especificacion = $this->input->post('especificacion');
		 $producto 		= $this->input->post('producto');
		 $sku 			= $this->input->post('sku');
		 $pvp 			= $this->input->post('pvp');
		 $pvp_iva 		= $this->input->post('pvp_iva');
		 $cmv 			= $this->input->post('cmv');
		 $cmv_iva 		= $this->input->post('cmv_iva');
		 $margen_bruto 	= $this->input->post('margen_bruto');
		 $mult_spvp 	= $this->input->post('mult_spvp');
		 $premium 		= $this->input->post('premium');
		 $clasica 		= $this->input->post('clasica');
		 $mercado_envio = $this->input->post('mercado_envio');
		 $costo_total 	= $this->input->post('costo_total');
		 $constribucion = $this->input->post('constribucion');
		 $multiplicador = $this->input->post('multiplicador');
		 		 
		 $this->load->library('form_validation');
		 
		 $this->form_validation->set_rules('especificacion', 'Especificación', 'required');
		 $this->form_validation->set_rules('producto', 'Producto', 'required');
		 $this->form_validation->set_rules('sku', 'SKU', 'required');
		 $this->form_validation->set_rules('pvp', 'PVP', 'required');
		 $this->form_validation->set_rules('cmv', 'CMV', 'required');
		 
		 if (   $this->form_validation->run() == true)
		 {
		 
			 $modificado = $this->M_produccion->upd_ml($id_actual, $id_ml, $especificacion,$producto,$sku,$pvp,$pvp_iva,$cmv,$cmv_iva,$margen_bruto,$mult_spvp,$premium,$clasica,$mercado_envio,$costo_total,$constribucion,$multiplicador);
			 
   		     if ($modificado == 1)
			 { 
				 $this->notificacion = "La unidad de medida se modificó satisfactoriamente.";
		         $this->notificacion_error = false;
			 }
			 else
			 {
				 $this->notificacion = "ERROR. No se pudo modificar la unidad de medida. Verifique los datos especificados.";
		         $this->notificacion_error = true;
		 }
				 
		 }
		 else
		 {
		     $this->notificacion = validation_errors();
			 $this->notificacion_error = true;
			 
		 }
		 if($this->notificacion_error == true){		
			$datos['id_actual'] = $id_actual;
			$datos['id_um']   = $id_um;
			$datos['especificacion'] = $especificacion;
			$datos['producto'] = $producto;
			$datos['sku'] = $sku;
			$datos['pvp'] = $pvp;
			$datos['pvp_iva'] = $pvp_iva;
			$datos['cmv'] = $cmv;
			$datos['cmv_iva'] = $cmv_iva;
			$datos['margen_bruto'] = $margen_bruto;
			$datos['mult_spvp'] = $mult_spvp;
			$datos['premium'] = $premium;
			$datos['clasica'] = $clasica;
			$datos['mercado_envio'] = $mercado_envio;
			$datos['costo_total'] = $costo_total;
			$datos['constribucion'] = $constribucion;
			$datos['multiplicador'] = $multiplicador;
			$res = $this->M_operaciones->obtener_parametro('P_COSTO_VENTA_ML_PREMIUM');
			$row = $res->row();
			$premium_valor = $row->valor_decimal;  		
			$datos['premium_valor'] = $premium_valor;

			$res = $this->M_operaciones->obtener_parametro('P_COSTO_VENTA_ML_CLASICA');
			$row = $res->row();
			$clasica_valor = $row->valor_decimal;		
			$datos['clasica_valor'] = $clasica_valor;
			$datos['notificacion'] = $this->notificacion ? $this->notificacion : "Error. No se pudo modificar la unidad de medida. Verifique los datos especificados.";
          	$datos['notificacion_error'] = $this->notificacion_error;
			$datos['modo_edicion'] = true;
			
			$this->load->view('lte_header', $datos);
			$this->load->view('produccion/v_mls', $datos);
			$this->load->view('lte_footer', $datos); 
		 
		 }else
		 
		 $this->mls();
    }
   
	/***********************************************************************************************************/
	// Confirmar eliminación de un tipo
	public function cfe_ml($id_ml)
	{
		$datos['id_ml'] = $id_ml;
		
		$this->load->view('lte_header', $datos);
 	    $this->load->view('produccion/vcan_mls', $datos);
	    $this->load->view('lte_footer', $datos);
	}
	/*******************************************************************************************************/
	// Cancelar tipo
    public function cancelar_ml()
	{
		$id_ml = $this->input->post('id_ml');
		$cancelado = $this->M_produccion->delete_ml($id_ml);
		
		if ($cancelado == 1)
	    { 
		   $this->not_fcliente = "Se eliminó el producto correctamente.";
		}
		else
		{
		   $this->not_fcliente = "ERROR. No se pudo eliminar el producto. Verifique los datos especificados.";
		}
		
		$this->mls();

	}
	
	 /**********************************************************************************************************/
	 public function obtener_parametro($nombre)
	 {
		 $par = $this->M_operaciones->obtener_parametro($nombre);
		 $fila = $par->row();
		 return $fila->valor;
	 }
}