<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Panel_general extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->database();
        $this->load->helper('url');
        $this->load->model('modelogeneral');
        $this->load->library('grocery_CRUD');
        $this->load->library('session');
        $this->load->library('form_validation');
       
    }
     public function index()
    {
        switch ($this->session->userdata('perfil')) {
            case '':
                redirect(base_url() . 'login');
                break;
            case 'admin_general':
                break;
            case false:
                redirect(base_url() . 'login');
                break;                      
        }
        $notificacionNplan  = $this->modelogeneral->count_NuevasSolitudPlan();
        $result_notifNplan  = $this->modelogeneral->getNewNoticaciones();
        

        $datos = array(
                       'notificacionNplan' =>$notificacionNplan,
                       'result_notifNplan' =>$result_notifNplan
                      );

        $this->load->view("layout/header");
        $this->load->view("layout/side_menu");// contiene el menu
        $this->load->view("layout/top_navigation",$datos);
        $this->load->view("layout/page_content");
        $this->load->view("layout/footer");
    }

     public function admin_user_tiendas()
    {
      
        switch ($this->session->userdata('perfil')) {
            case '':
                redirect(base_url() . 'login');
                break;
            case 'admin_general':
                break;
            case false:
                redirect(base_url() . 'login');
                break;                      
        }

        $result             = $this->modelogeneral->getallUsuariosTienda();
        $notificacionNplan  = $this->modelogeneral->count_NuevasSolitudPlan();
        $result_notifNplan  = $this->modelogeneral->getNewNoticaciones();
        

        $datos = array('usuarios_tienda' => $result,
                       'notificacionNplan' =>$notificacionNplan,
                       'result_notifNplan' =>$result_notifNplan
                      );

        $this->load->view("layout/header");
        $this->load->view("layout/side_menu");// contiene el menu
        $this->load->view("layout/top_navigation",$datos);
        $this->load->view("admin_general/v_conten_usuarios_tiendas",$datos);
        $this->load->view("layout/footer");
    }

    
    public function historicos_Usuarios_mensuales()
    {
        switch ($this->session->userdata('perfil')) {
            case '':
                redirect(base_url() . 'login');
                break;
            case 'admin_general':
                break;
            case false:
                redirect(base_url() . 'login');
                break;                      
        }
     
     $resul_histUsuario = $this->modelogeneral->HistoricoUsuariosTienda();
     $notificacionNplan = $this->modelogeneral->count_NuevasSolitudPlan();
     $result_notifNplan = $this->modelogeneral->getNewNoticaciones();
     $datos = array(
                   'notificacionNplan' =>$notificacionNplan,
                   'result_notifNplan' =>$result_notifNplan,
                   'historico_mensual' => $resul_histUsuario
                  );

        $this->load->view("layout/header");
        $this->load->view("layout/side_menu");// contiene el menu
        $this->load->view("layout/top_navigation",$datos);
        $this->load->view("admin_general/v_historico_pagos",$datos);
        $this->load->view("layout/footer");
      
    }


     public function pagos_confirmados()
    {
      
        switch ($this->session->userdata('perfil')) {
            case '':
                redirect(base_url() . 'login');
                break;
            case 'admin_general':
                break;
            case false:
                redirect(base_url() . 'login');
                break;                      
        }

        $result             = $this->modelogeneral->getPagoexitoso();
        $notificacionNplan  = $this->modelogeneral->count_NuevasSolitudPlan();
        $result_notifNplan  = $this->modelogeneral->getNewNoticaciones();
        

        $datos = array('pagos_exitosos' => $result,
                       'notificacionNplan' =>$notificacionNplan,
                       'result_notifNplan' =>$result_notifNplan
                      );

        $this->load->view("layout/header");
        $this->load->view("layout/side_menu");// contiene el menu
        $this->load->view("layout/top_navigation",$datos);
        $this->load->view("admin_general/v_pagos_confirmados",$datos);
        $this->load->view("layout/footer");
    }

     public function pagos_xconfirmar()
    {
      
        switch ($this->session->userdata('perfil')) {
            case '':
                redirect(base_url() . 'login');
                break;
            case 'admin_general':
                break;
            case false:
                redirect(base_url() . 'login');
                break;                      
        }

        $result             = $this->modelogeneral->getPagoxConfirmar();
        $notificacionNplan  = $this->modelogeneral->count_NuevasSolitudPlan();
        $result_notifNplan  = $this->modelogeneral->getNewNoticaciones();
        

        $datos = array('pago_xerror'       =>$result,
                       'notificacionNplan' =>$notificacionNplan,
                       'result_notifNplan' =>$result_notifNplan
                      );

        $this->load->view("layout/header");
        $this->load->view("layout/side_menu");// contiene el menu
        $this->load->view("layout/top_navigation",$datos);
        $this->load->view("admin_general/v_pagosxconfirmar",$datos);
        $this->load->view("layout/footer");
    }


     public function plan_pago()
    {
        switch ($this->session->userdata('perfil')) {
            case '':
                redirect(base_url() . 'login');
                break;
            case 'admin_general':
                break;
            case false:
                redirect(base_url() . 'login');
                break;                      
        }
        $notificacionNplan  = $this->modelogeneral->count_NuevasSolitudPlan();
        $result_notifNplan  = $this->modelogeneral->getNewNoticaciones();
        $result_planes      = $this->modelogeneral->getPlanes();
        

        

        $datos = array(
                       'notificacionNplan' => $notificacionNplan,
                       'result_notifNplan' => $result_notifNplan,
                       'result_planes'     => $result_planes

                      );
        

        $this->load->view("layout/header");
        $this->load->view("layout/side_menu");// contiene el menu
        $this->load->view("layout/top_navigation",$datos);
        $this->load->view("admin_general/v_conten_plan_pago",$datos);
        $this->load->view("layout/footer");
    }

      public function perfil()
    {
        switch ($this->session->userdata('perfil')) {
            case '':
                redirect(base_url() . 'login');
                break;
            case 'admin_general':
                break;
            case false:
                redirect(base_url() . 'login');
                break;                      
        }
        $notificacionNplan  = $this->modelogeneral->count_NuevasSolitudPlan();
        $result_notifNplan  = $this->modelogeneral->getNewNoticaciones();
        

        $datos = array(
                       'notificacionNplan' =>$notificacionNplan,
                       'result_notifNplan' =>$result_notifNplan
                      );
    $this->load->view("layout/header");
    $this->load->view("layout/side_menu");// contiene el menu
    $this->load->view("layout/top_navigation",$datos);
    $this->load->view("layout/v_perfil");
    $this->load->view("layout/footer");
    }


    /*---------------Administrar categorias-----------*/

     public function administrar_categorias()
    {
      
        switch ($this->session->userdata('perfil')) {
            case '':
                redirect(base_url() . 'login');
                break;
            case 'admin_general':
                break;
            case false:
                redirect(base_url() . 'login');
                break;                      
        }

        $result             = $this->modelogeneral->administrar_categorias();
        $notificacionNplan  = $this->modelogeneral->count_NuevasSolitudPlan();
        $result_notifNplan  = $this->modelogeneral->getNewNoticaciones();
        

        $datos = array('categorias'       =>$result,
                       'notificacionNplan' =>$notificacionNplan,
                       'result_notifNplan' =>$result_notifNplan
                      );

        $this->load->view("layout/header");
        $this->load->view("layout/side_menu");// contiene el menu
        $this->load->view("layout/top_navigation",$datos);
        $this->load->view("admin_general/v_administacion_categorias",$datos);
        $this->load->view("layout/footer");
    }


    /*---------solicitud de nuevo plan--------------*/
    public function update_solicitudPlan()
    {
        $plan_sol   = $_GET['nuevo_plan'];
        $id_usuario = $_GET['usuario'];
        $result = $this->modelogeneral->update_planSol($plan_sol,$id_usuario);
        $msg['success'] = false;
       if($result){
         $msg['success'] = true;
        }
       echo json_encode($msg);
    }


    public function eliminar_usuarioTienda()
    {
         $id_usuario = $_GET['id_usuario'];
         $result = $this->modelogeneral->eliminar_usuarioTienda($id_usuario);
         $msg['success'] = false;
        if($result){
          $msg['success'] = true;
        }
        echo json_encode($msg);
    }
    
    public function datos_usuarioT()
    {
     $id_usuario = $_GET['id_usuario'];
     $result = $this->modelogeneral->datos_usuarioT($id_usuario);
      echo json_encode($result);
    }
    
	public function updEvento(){
		$param['id'] = $this->input->post('id');
		$param['fecini'] = $this->input->post('fecini');
		$param['fecfin'] = $this->input->post('fecfin');

		$r = $this->mcalendar->updEvento($param);

		echo $r;
	}




}
