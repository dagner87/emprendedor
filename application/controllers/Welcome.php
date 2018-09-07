<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	  public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->helper('url');
        $this->load->model('modelogeneral');
        $this->load->library('session');
        
    }


	public function index()
	{
	
	$this->load->view('form_validado');
	}
	public function install_panel(){

    $datos = array( 
      'nombre_usuario'   => $this->input->post('nombre_usuario'), 
      'usuario'          => $this->input->post('usuario'),      
      'mail'             => $this->input->post('mail'),    
      'pass'             => $this->input->post('pass'),
      'usuario'          => $this->input->post('usuario'),
      'id_tienda'        => $this->input->post('id_tienda'),
      'plan'             => $this->input->post('plan'), 
      'comprobador'      => false 

    );
   /* $result = $this->modelogeneral->insert($data,$id_usuario);*/
    $result =true;
       $msg['comprobador'] = false;
       if($result)
         {
          $msg['comprobador'] = TRUE;
         }
    echo json_encode($datos);

   }
}
