<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Capacitacion extends CI_Controller
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
    $this->load->view("layout/header");
    $this->load->view("layout/side_menu");
    $this->load->view("layout/page_content");
    $this->load->view("layout/footer");  

    }

    public function mi_red()
    {
     $id_emp = 1;     // obtener id_empresa por la seccion
     $result = $this->modelogeneral->mostrar_asoc($id_emp);
     $data = array('asociados' => $result);
    
    $this->load->view("layout/header");
    $this->load->view("layout/side_menu");
    $this->load->view("emprendedor/red",$data);
    $this->load->view("layout/footer");  

    }

    public function modulos()
    {
     $id_emp = 1;     // obtener id_empresa por la seccion
     $result = $this->modelogeneral->mostrar_asoc($id_emp);
     $data = array('asociados' => $result);
    
    $this->load->view("layout/header");
    $this->load->view("layout/side_menu");
    $this->load->view("emprendedor/capacitacion_videos",$data);
    $this->load->view("layout/footer");  

    }
     public function index1()
    {
        
    $this->load->view("layout/inicio");
    
    }

     public function insert_add_asoc()
    {
        $param['id_emp']          = 1;     // obtener id_empresa por la seccion
        $param['nombre_asoc']     = $this->input->post('nombre_asoc');
        $param['dni__asoc']       = $this->input->post('dni__asoc');
        $param['email']           = $this->input->post('email');
        $param['telefono_asoc']   = $this->input->post('telefono_asoc');
       //$param['estado_asoc']     = 1;
        $param['fecha_insc_asoc'] = date('Y-m-d');
       
       
        $result = $this->modelogeneral->insert_add_asoc($param);
        $msg['comprobador'] = false;
        if($result)
             {
               $msg['comprobador'] = TRUE;
             }
        echo json_encode($msg);
    }















    /*---------------------------------*/


	public function carga_de_grafica_general()
    {
        switch ($this->session->userdata('perfil')) {
            case '':
                redirect(base_url() . 'login');
                break;
            case 'administrador':
                break;
            case false:
                redirect(base_url() . 'login');
                break;                      
        }
        $store_id       = $this->session->userdata('id_tienda');
        $id_usuario     = $this->session->userdata('id_usuario');
        $datos_usuario  = $this->modelogeneral->datos_usuario($id_usuario);
        $datos_plan     = $this->modelogeneral->datos_plan($datos_usuario->id_plan);
        $datos = array(
                       'cantidad_prod'          => $this->modelogeneral->count_Productos($store_id),
                       'cant_prod_selecc'       => $this->modelogeneral->count_Productos_Selec($store_id),
                       'pendiente'              => $this->modelogeneral->rowCount(1,0,0),
                       'en_espera'              => $this->modelogeneral->rowCount(1,1,0),
                       'aprobado'               => $this->modelogeneral->rowCount(1,1,1),
                       'denegado'               => $this->modelogeneral->rowCount(1,1,2),
                       'id_plan'                =>  $datos_usuario->id_plan,
                       'plan_solicitado'        =>  $datos_usuario->plan_solicitado,
                       'tipo_plan'              =>  $datos_plan->tipo_plan,
                       'cantidad_productosPlan' =>  $datos_plan->cantidad_productos
                      );


        echo json_encode($datos);
    }

     public function productos_generales()
    {
     switch ($this->session->userdata('perfil')) {
            case '':
                redirect(base_url() . 'login');
                break;
            case 'administrador':
                break;
            case false:
                redirect(base_url() . 'login');
                break;                      
        }
         $this->load->library('pagination');
        $store_id             = $this->session->userdata('id_tienda');     
        $id_usuario           = $this->session->userdata('id_usuario');
        
        $config['base_url'] =  base_url().'panel_admin_tienda/productos_generales'; 
        $config['total_rows'] = $this->modelogeneral->count_Productos_generales($store_id);
        $config['per_page'] = 10;    // cantidad de articulos por pagina 
        $config['uri_segment'] = 3;
        $config['num_links'] = 5;
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['first_link'] = 'Inicio';
        $config['last_link'] = 'Fin';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['prev_link'] = '&laquo';
        $config['prev_tag_open'] = '<li class="prev">';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = '&raquo';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';

        $this->pagination->initialize($config); 

       
        $result               = $this->modelogeneral->getProd_Tienda($store_id,$config['per_page']);
        $cantidad_prod        = $this->modelogeneral->count_Productos_generales($store_id);
        $cantidad_prod_selecc = $this->modelogeneral->count_Productos_seleccionados($store_id);
        $datos_usuario        = $this->modelogeneral->datos_usuario($id_usuario);
        $datos_plan           = $this->modelogeneral->datos_plan($datos_usuario->id_plan);
       
        
        $datos = array( 'productos'              => $result,
                        'cantidad_prod'          => $cantidad_prod,
                        'cant_prod_selecc'       => $cantidad_prod_selecc,
                        'id_plan'                => $datos_usuario->id_plan,
                        'plan_solicitado'        => $datos_usuario->plan_solicitado,
                        'tipo_plan'              => $datos_plan->tipo_plan,
                        'cantidad_productosPlan' => $datos_plan->cantidad_productos
                     );
        $datos['pagination']= $this->pagination->create_links();

    $this->load->view("layout/header",$datos);
    $this->load->view("admin_tienda/v_sidebar_ menu");
    $this->load->view("layout/top_navigation");
    $this->load->view("admin_tienda/v_conten_productos",$datos);
    $this->load->view("layout/footer");
    }

      public function productos_seleccionados()
    {
        switch ($this->session->userdata('perfil')) {
            case '':
                redirect(base_url() . 'login');
                break;
            case 'administrador':
                break;
            case false:
                redirect(base_url() . 'login');
                break;                      
        }
        $this->load->library('pagination');
       
        $store_id             = $this->session->userdata('id_tienda');
        $id_usuario           = $this->session->userdata('id_usuario');

        $config['base_url'] =  base_url().'panel_admin_tienda/productos_seleccionados'; 
        $config['total_rows'] = $this->modelogeneral->count_Productos_seleccionados($store_id);
        $config['per_page'] = 10;    // cantidad de articulos por pagina 
        $config['uri_segment'] = 3;
        $config['num_links'] = 5;
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['first_link'] = false;
        $config['last_link'] = false;
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['prev_link'] = '&laquo';
        $config['prev_tag_open'] = '<li class="prev">';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = '&raquo';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        
        $this->pagination->initialize($config); 
        
        $result               = $this->modelogeneral->getProd_Tienda_Selec($store_id,$config['per_page']);
        $result_categorias    = $this->modelogeneral->administrar_categorias();
        $cantidad_prod        = $this->modelogeneral->count_Productos_generales($store_id);
        $cantidad_prod_selecc = $this->modelogeneral->count_Productos_seleccionados($store_id);
        $datos_usuario        = $this->modelogeneral->datos_usuario($id_usuario);
        $datos_plan           = $this->modelogeneral->datos_plan($datos_usuario->id_plan);
        $datos_sel = array(
                           'productos_sel'          => $result,
                           'categorias'             => $result_categorias,
                           'cantidad_prod'          => $cantidad_prod,
                           'cant_prod_selecc'       => $cantidad_prod_selecc,
                           'id_plan'                => $datos_usuario->id_plan,
                           'plan_solicitado'        => $datos_usuario->plan_solicitado,
                           'tipo_plan'              => $datos_plan->tipo_plan,
                           'cantidad_productosPlan' => $datos_plan->cantidad_productos
                         );
        $datos_sel['pagination']= $this->pagination->create_links();
        
        $this->load->view("layout/header",$datos_sel);
        $this->load->view("admin_tienda/v_sidebar_ menu");
        $this->load->view("layout/top_navigation");
        $this->load->view("admin_tienda/v_conten_prod_selec",$datos_sel);
        $this->load->view("layout/footer");
    }

    public function plan_pago_tienda()
    {
        switch ($this->session->userdata('perfil')) {
            case '':
                redirect(base_url() . 'login');
                break;
            case 'administrador':
                break;
            case false:
                redirect(base_url() . 'login');
                break;                      
        }
     $id_usuario     = $this->session->userdata('id_usuario');
     $datos_usuario  = $this->modelogeneral->datos_usuario($id_usuario);
     $datos_plan     = $this->modelogeneral->datos_plan($datos_usuario->id_plan);
     $datos = array(
                     'id_plan'          => $datos_usuario->id_plan,
                     'plan_solicitado'  => $datos_usuario->plan_solicitado,
                     'id_plan'          => $datos_usuario->id_plan,
                     'plan_solicitado'  => $datos_usuario->plan_solicitado,
                     'tipo_plan'        => $datos_plan->tipo_plan
                    );   

    $this->load->view("layout/header",$datos);
    $this->load->view("admin_tienda/v_sidebar_ menu");
    $this->load->view("layout/top_navigation");
    $this->load->view("admin_tienda/v_conten_plan_pago",$datos);
    $this->load->view("layout/footer");
    }

     public function pagar_plan_mensual()
    {
        switch ($this->session->userdata('perfil')) {
            case '':
                redirect(base_url() . 'login');
                break;
            case 'administrador':
                break;
            case false:
                redirect(base_url() . 'login');
                break;                      
        }
     $id_usuario        = $this->session->userdata('id_usuario');
     $datos_usuario     = $this->modelogeneral->datos_usuario($id_usuario);
     $datos_plan        = $this->modelogeneral->datos_plan($datos_usuario->id_plan);
     $resul_histUsuario = $this->modelogeneral->getHistoricoUsuariosTienda($id_usuario );
     
     $datos = array(
                     'id_plan'           => $datos_usuario->id_plan,
                     'plan_solicitado'   => $datos_usuario->plan_solicitado,
                     'id_plan'           => $datos_usuario->id_plan,
                     'plan_solicitado'   => $datos_usuario->plan_solicitado,
                     'tipo_plan'         => $datos_plan->tipo_plan,
                     'historico_mensual' => $resul_histUsuario
                    );
    
    $this->load->view("layout/header",$datos);
    $this->load->view("admin_tienda/v_sidebar_ menu");
    $this->load->view("layout/top_navigation");
    $this->load->view("admin_tienda/v_pagar_plan",$datos);
    $this->load->view("layout/footer");
    }


    public function soporte_tecnico()
    {
        switch ($this->session->userdata('perfil')) {
            case '':
                redirect(base_url() . 'login');
                break;
            case 'administrador':
                break;
            case false:
                redirect(base_url() . 'login');
                break;                      
        }
     $id_usuario     = $this->session->userdata('id_usuario');
     $datos_usuario  = $this->modelogeneral->datos_usuario($id_usuario);
     $datos_plan     = $this->modelogeneral->datos_plan($datos_usuario->id_plan);
     $datos = array(
                     'id_plan'          => $datos_usuario->id_plan,
                     'plan_solicitado'  => $datos_usuario->plan_solicitado,
                     'id_plan'          => $datos_usuario->id_plan,
                     'plan_solicitado'  => $datos_usuario->plan_solicitado,
                     'tipo_plan'        => $datos_plan->tipo_plan
                    );     
    $this->load->view("layout/header",$datos);
    $this->load->view("admin_tienda/v_sidebar_ menu");
    $this->load->view("layout/top_navigation");
    $this->load->view("admin_tienda/v_conten_soporte");
    $this->load->view("layout/footer");
    }

     public function perfil()
    {
        switch ($this->session->userdata('perfil')) {
            case '':
                redirect(base_url() . 'login');
                break;
            case 'administrador':
                break;
            case false:
                redirect(base_url() . 'login');
                break;                      
        }
    $id_usuario     = $this->session->userdata('id_usuario');
    $datos_usuario  = $this->modelogeneral->datos_usuario($id_usuario);
    $datos_plan     = $this->modelogeneral->datos_plan($datos_usuario->id_plan);
    $datos = array(
                     
                     'nombre_usuario'  => $datos_usuario->nombre_usuario,
                     'usuario'         => $datos_usuario->usuario,
                     'dni'             => $datos_usuario->dni,
                     'id_tienda'       => $datos_usuario->id_tienda,
                     'mail'            => $datos_usuario->mail,
                     'pass'            => $datos_usuario->pass,
                     'plan_solicitado' => $datos_usuario->plan_solicitado,
                     'tipo_plan'       => $datos_plan->tipo_plan
                    );
    $this->load->view("layout/header",$datos);
    $this->load->view("admin_tienda/v_sidebar_ menu");
    $this->load->view("layout/top_navigation");
    $this->load->view("layout/v_perfil",$datos);
    $this->load->view("layout/footer");
    }

 public function pago_exitoso()
    {
        switch ($this->session->userdata('perfil')) {
            case '':
                redirect(base_url() . 'login');
                break;
            case 'administrador':
                break;
            case false:
                redirect(base_url() . 'login');
                break;                      
        }
    
    $this->load->view("admin_tienda/v_pagoexitoso");
  
    }

  public function pago_en_proceso()
    {
        switch ($this->session->userdata('perfil')) {
            case '':
                redirect(base_url() . 'login');
                break;
            case 'administrador':
                break;
            case false:
                redirect(base_url() . 'login');
                break;                      
        }
  
    $this->load->view("admin_tienda/v_pagoenproceso");
  
    }


    /*-----------------------*/

       public function udpdateDatosProd()
    {
       $param['id_producto']  = $this->input->post('id_producto');
       $param['id_categoria'] = $this->input->post('id_categoria');
       $param['descripton']   = $this->input->post('descripton');
       $result                = $this->modelogeneral->udpdateDatosProd($param);
       $msg['success']        = false;
       if($result){
        $msg['success'] = true;
      }
      echo json_encode($msg);

    }

  /*---------------get datos del producto---------------*/

     public function editar_producto(){
        $id_producto = $this->input->get('id_producto');
        $resultado = $this->modelogeneral->editar_producto($id_producto);
        echo json_encode($resultado);
    }


    

    public function show_categorias()
    {
       $result = $this->modelogeneral->administrar_categorias();
       echo json_encode($result);
    }


    

    
	public function GetProducto()
    {
        $id_producto = $_GET['idprod'];
        $result = $this->modelogeneral->update_producto_tienda($id_producto);
        $msg['success'] = false;
       if($result){
         $msg['success'] = true;
        }
       echo json_encode($msg);
	}


	

	public function RetornarProducto()
    {
        $id_producto = $_GET['idprod'];
        $result = $this->modelogeneral->retorna_producto_tienda($id_producto);
        $msg['success'] = false;
       if($result){
         $msg['success'] = true;
        }
       echo json_encode($msg);
	}

    /*---------solicitud de nuevo plan--------------*/
    public function Solicitud_plan()
    {
        $id_plan = $_GET['plan'];
        $usuario = $this->session->userdata('id_usuario');
        $result = $this->modelogeneral->update_plan($id_plan,$usuario);
        $msg['success'] = false;
       if($result){
         $msg['success'] = true;
        }
       echo json_encode($msg);
    }


    
      public function contactar_soporte()
    {
        
      if($this->input->is_ajax_request()) 
        {
                   
                  $data = array(
                               
                                'asunto'   => $this->input->post('asunto'),
                                'email'    => $this->input->post('email'),
                                'telefono' => $this->input->post('telefono'),
                                'mensaje'  => $this->input->post('mensaje'),
                                'fecha'    =>  date('Y-m-d H:i:s'),
                                'usuario'  => $this->input->post('usuario')
                                 );
                    
                   $result = $this->modelogeneral->insertar_consulta($data);
                   $msg['comprobador'] = false;
                   if($result)
                     {
                       $msg['comprobador'] = TRUE;
                     }
                    echo json_encode($msg);

          
        }       
       

           
    } // fin insertar consulta a soporte

      public function udpate_perfil()
    {
        $data = array(
                   
                    'nombre_usuario' => $this->input->post('nombre_usuario'),
                    'usuario'        => $this->input->post('usuario'),
                    'mail'           => $this->input->post('mail'),
                    'pass'           => md5($this->input->post('pass')),
                    'id_tienda'      => $this->input->post('id_tienda')
                     );
        $id_usuario     = $this->input->post('id_usuario'); 

       $result = $this->modelogeneral->update_perfil($data,$id_usuario);
       $msg['comprobador'] = false;
       if($result)
         {
           $msg['comprobador'] = TRUE;
         }
            echo json_encode($msg);
       
           
    } // fin update perfil




}
