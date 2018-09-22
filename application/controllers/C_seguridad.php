<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_seguridad extends CI_Controller
{

	/********************************************************************************************************************/
	// Constructor de la clase
	public function __construct()
    {
		parent::__construct();
	
		
		$this->load->model('M_seguridad', '', TRUE);
    }
	/********************************************************************************************************************/
	// Solicitando la entrada al sistema
    public function cerrar()
    {
		 $this->ion_auth->logout();
		 redirect('entrada');
		 
    }
	/********************************************************************************************************************/
	// Solicitando la modificación de un usuario
    public function modificar($idusuario)
    {
         $this->mensaje = "";
		 $this->nombre_usuario_actual = $this->session->userdata('nombre_real');
		 $datos['nombre_real'] = $this->session->userdata('nombre_real');
		 $this->tipo_mensaje = "ok";
		 $datos['tipo_mensaje'] = $this->tipo_mensaje;
		 $datos['mensaje'] = $this->mensaje;
		 
		 $usuario = $this->M_seguridad->ObtenerUsuario($idusuario);
		 $datos['usuario'] = $usuario;
		 
		 $this->load->view('v_mod_usuario', $datos);
    }
	/********************************************************************************************************************/
	// Solicitando la modificación de usuarios del sistema
    public function usuarios()
    {
         $this->nombre_usuario_actual = $this->session->userdata('nombre_real');
		 $this->tipo_mensaje = "ok";

		 $datos['nombre_real'] = $this->nombre_usuario_actual;
		 $datos['mensaje'] = $this->mensaje;
		 $datos['tipo_mensaje'] = $this->tipo_mensaje;

		 $resultado_grupos = $this->M_seguridad->ObtenerGrupos();
		 $datos['grupos'] = $resultado_grupos;
		 $resultado_usuarios = $this->M_seguridad->ObtenerUsuarios();
		 $datos['usuarios'] = $resultado_usuarios;
	      
		 
		 $this->load->view('v_usuarios', $datos);
    }
	/********************************************************************************************************************/
	// Registrando un usuario en el sistema
    public function registrar_usuario()
    {
         $datos['nombre_real'] = $this->session->userdata('nombre_real');
		 
		 $idusuario = $this->input->post('idusuario');
		 $nombre = $this->input->post('nombre');
		 $clave = $this->input->post('clave');
		 $idgrupo = $this->input->post('idgrupo');
		
		 $registrado = 0;
		 if ( strlen($idusuario) <> 0 &&  strlen($nombre) <> 0 && strlen($clave) <> 0 )
		     $registrado = $this->M_seguridad->RegistrarUsuario($idusuario, $nombre, $idgrupo, $clave);
		 
		 
		 $this->nombre_usuario_actual = $this->session->userdata('nombre_real');
		 $this->mensaje = "Registrar un nuevo usuario en el sistema.";
		 $this->tipo_mensaje = "ok";

		 if ( $registrado == 1)
		 {
		      $this->mensaje = "Registrar un nuevo usuario en el sistema.";
		      $this->tipo_mensaje = "ok";
			 
		 }
		 else
		 {
		     $this->mensaje = "No se pudo registrar el usuario en el sistema. Rectifique los datos.";
		     $this->tipo_mensaje = "error";
		 }
		  
		 $this->usuarios();
    }
	/********************************************************************************************************************/
	// Solicitando la validación de un usuario
    public function validar_usuario()
    {
		 $usuario = $this->input->post('usuario');
		 $clave = $this->input->post('clave');
		 
		 $notificacion = "";
		 
		 if ( strlen($usuario) <> 0 && strlen($clave) <> 0 )
		 {
			  $resultado = $this->M_seguridad->VerificarUsuario($usuario, $clave);
			  
			  if ( $resultado->num_rows() == 1 )
			  {
				  $this->session->set_userdata( 'id_sesion', session_id() );
				  //$this->session->set_userdata('nombre_usuario', $usuario);
				  //$this->session->set_userdata('nombre_real', $fila->nombre_completo);
				  //$this->session->set_userdata('grupo', $fila->id_grupo);
				  $datos['notificacion'] = "";
		
				  $this->load->view('lte_header', $datos);
				  $this->load->view('v_dashboard', $datos);
				  $this->load->view('lte_footer', $datos);
			  }
			  else
			  {
			      $notificacion = "Acceso denegado. Rectifique las credenciales.";
				  $datos['notificacion'] = $notificacion;
		          $this->load->view('v_login', $datos);
			  }
	     }
    }
	/********************************************************************************************************************/
	// Solicitando cambio de clave de acceso
    public function solicitar_cambio_clave()
    {
         $idsesion = $this->session->userdata('session_id');
		 if ( isset( $idsesion ) && ( $idsesion ==  $this->session->userdata('idsesion') ) )
		 {
			 $datos['nombre_real'] = $this->session->userdata('nombre_real');
			 $datos['tipo_mensaje'] = "ok";
			 $datos['mensaje'] = "Cambiando la clave de acceso al sistema";
			 $this->load->view('v_cambio_clave', $datos);
		 }
		 else
		 {
			redirect('c_seguridad/entrada');
		 }
    }
	/********************************************************************************************************************/
	// Cambiando la clave
	public function cambiar_clave()
	{
		$usuario = $this->input->post('usuario');
		$clave = $this->input->post('clave');
		$clave_nueva1 = $this->input->post('clave_nueva1');
		$clave_nueva2 = $this->input->post('clave_nueva2');
		
		if ( strlen($usuario) <> 0 && strlen($clave) <> 0 && strlen($clave_nueva1) <> 0 && strlen($clave_nueva2) <> 0 && $clave_nueva1 = $clave_nueva2)
		{
			
			$modificada = $this->M_seguridad->CambiarClave($usuario, $clave, $clave_nueva1);
		    
			if ( $modificada == 1)
			{
				 $datos['tipo_mensaje'] = "ok";
				 $datos['mensaje'] = "Se modificó la clave correctamente.";
			}
			else
			{
				 $datos['tipo_mensaje'] = "error";
				 $datos['mensaje'] = "No se pudo modificar la clave. Verifique los datos";
			}
			
		}
		else
		{
			 $datos['tipo_mensaje'] = "error";
			 $this->mensaje = "No se puede cambiar la clave. Rectifique los datos.";
		}

		$datos['nombre_real'] = $this->session->userdata('nombre_real');
		$this->load->view('v_cambio_clave', $datos);
		    
	}
	
    /********************************************************************************************************************/
}
?>