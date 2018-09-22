<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_registro extends CI_Controller {

    public function __construct()
    {
		parent::__construct();
		
        $this->load->model( 'M_configuracion', '', TRUE );
       
        		
    }
	
	// ------------------------------------------------------
    public function index()
    {

    }

    public function provincias_pais($id_pais)
	{
		$provincias = $this->M_configuracion->provincias_pais($id_pais);	
		foreach ($provincias->result() as $pro)
			echo '<option value="' . $pro->id_provincia . '">' . $pro->nombre . '</option>';
	}

}