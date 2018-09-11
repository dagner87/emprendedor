<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by JetBrains PhpStorm.
 * User: isra
 * Date: 19/01/13
 * Time: 18:51
 * To change this template use File | Settings | File Templates.
 */
class Login extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
		$this->load->model('Login_model');
		$this->load->model('modelogeneral');
		$this->load->library(array('session','form_validation'));
		$this->load->helper(array('url','form'));
		$this->load->database();
    }
	
	public function index()
	{	
		$this->output->set_header('Expires: Sat, 26 Jul 2000 05:00:00 GMT');
        $this->output->set_header('Cache-Control: no-cache, no-store, must-revalidate, max-age=0');
        $this->output->set_header('Cache-Control: post-check=0, pre-check=0', FALSE);
        $this->output->set_header('Pragma: no-cache');
        
		switch ($this->session->userdata('perfil')) {
			case '':
				$data['token'] = $this->token();
				$this->load->view('layout/login',$data);
				break;
			case 'administrador':
			    redirect(base_url().'panel_admin_tienda');
				break;
			case 'admin_general':
			    redirect(base_url().'panel_general');
				break;
					
		    default:		
				$data['token'] = $this->token();
				$this->load->view('layout/login',$data);
				break;		
		}
	}
	
	public function token()
	{
		$token = md5(uniqid(rand(),true));
		$this->session->set_userdata('token',$token);
		return $token;
	}
	
	public function new_user()
	{
		$this->output->set_header('Expires: Sat, 26 Jul 2000 05:00:00 GMT');
        $this->output->set_header('Cache-Control: no-cache, no-store, must-revalidate, max-age=0');
        $this->output->set_header('Cache-Control: post-check=0, pre-check=0', FALSE);
        $this->output->set_header('Pragma: no-cache');

		if($this->input->post('token') == $this->session->userdata('token'))
		{
            $this->form_validation->set_rules('username', 'nombre de usuario', 'required|trim|min_length[2]|max_length[150]');
            $this->form_validation->set_rules('password', 'password', 'required|trim|min_length[6]|max_length[150]');
 
            //lanzamos mensajes de error si es que los hay
            $this->form_validation->set_message('required', 'El %s es requerido');
            $this->form_validation->set_message('min_length', 'El %s debe tener al menos %s carácteres');
            $this->form_validation->set_message('max_length', 'El %s debe tener al menos %s carácteres');
			if($this->form_validation->run() == FALSE)
			{
				$this->index();
			}else{
				$username = $this->input->post('username');
				$password = md5($this->input->post('password'));
				$check_user = $this->Login_model->login_user($username,$password);
				
				if($check_user == TRUE)
				{
			    	$nombre_tienda = $this->modelogeneral->datos_tienda($check_user->id_tienda);
			    	$datos_plan     = $this->modelogeneral->datos_plan($check_user->id_plan);
	
					$data = array(
						'is_logued_in' 	      =>  TRUE,
	                    'id_usuario' 	      =>  $check_user->id_usuario,
		                'perfil'		      =>  $check_user->perfil,
		                'username' 		      =>  $check_user->usuario,
		                'id_tienda' 	      =>  $check_user->id_tienda,
		                'nombre_tienda'       =>  $nombre_tienda->nombre_tienda,
		                'nombre' 	          =>  $check_user->nombre_usuario,
		                'no_cliente' 	      =>  $check_user->no_cliente 
		                );
	                                      	                
            				
					$this->session->set_userdata($data);
					$this->index();
				}


			}
		}else{
			redirect(base_url().'login');
		}
	}

	public function salir()
	{
		$this->output->set_header('Expires: Sat, 26 Jul 2000 05:00:00 GMT');
        $this->output->set_header('Cache-Control: no-cache, no-store, must-revalidate, max-age=0');
        $this->output->set_header('Cache-Control: post-check=0, pre-check=0', FALSE);
        $this->output->set_header('Pragma: no-cache');

		$this->session->sess_destroy();
		redirect(base_url());
	}
}
