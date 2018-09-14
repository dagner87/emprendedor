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
      if ($this->session->userdata('perfil') == false || $this->session->userdata('perfil') != 'emprendedor') {
            redirect(base_url() . 'login');
        }   
     $id_emp             = $this->session->userdata('id_emp'); 
     $data['cant_asoc']  = $this->modelogeneral->rowCountAsoc($id_emp);
     $data['result']     = $this->modelogeneral->mostrar_asoc($id_emp);
     $data['datos_emp']  = $this->modelogeneral->datos_emp($id_emp);
     $data['ultimo_reg'] = $this->modelogeneral->las_insetCap(); 
    
    
     $this->load->view("layout/header",$data);
     $this->load->view("layout/side_menu",$data);

     if ($data['datos_emp']->id_cap != $data['ultimo_reg']->id_cap)
      {
        $data['list_cap']   = $this->modelogeneral->listar_data_cap(); 
        $this->load->view("emprendedor/capacitacion_videos",$data);
      }else {
             $this->load->view("layout/page_content");
            }
       $this->load->view("layout/footer");  
    }

   /* Insertar Evaluacion*/
    public function update_evalcap()
    {
        $param['id_emp']           = $this->session->userdata('id_emp');
        $param['evaluacion_video'] = $this->input->post('evaluacion');
        $param['id_cap']           = $this->input->post('id_cap');
        
        $result   = $this->modelogeneral->udpate_evalcap($param);
        $msg['comprobador'] = false;
        $msg['qry'] = $this->db->last_query();
        if($result)
             {
               $msg['comprobador'] = TRUE;
               $datos_upd['id_emp'] = $this->session->userdata('id_emp');
               $datos_upd['id_cap'] = 2 ;
               $msg['updatemp'] = $this->modelogeneral->udpate_emp($datos_upd);
             }
        echo json_encode($msg);
    }  

     

    public function checkout()
    {
      if ($this->session->userdata('perfil') == false || $this->session->userdata('perfil') != 'emprendedor') {
            redirect(base_url() . 'login');
        }   
     $id_emp = $this->session->userdata('id_emp'); 
     $data['cant_asoc']  = $this->modelogeneral->rowCountAsoc($id_emp);
     $data['result']     = $this->modelogeneral->mostrar_asoc($id_emp);
     $data['datos_emp']  = $this->modelogeneral->datos_emp($id_emp);          
     $this->load->view("layout/header",$data);
     $this->load->view("layout/side_menu",$data);
     $this->load->view("emprendedor/checkout");
     $this->load->view("layout/footer");  

    }


    function reporte_asoc()
    {
        if ($this->session->userdata('perfil') == false || $this->session->userdata('perfil') != 'emprendedor') {
            redirect(base_url() . 'login');
        }   
        $id_emp = $this->session->userdata('id_emp');
        $result = $this->modelogeneral->mostrar_asoc($id_emp);
        $count = 0;
        $output = '';
        if(!empty($result))
        {
            foreach($result as $row)
            {
                $count++;
                $output .= '<tr>
                            <td>
                            <a href="contact-detail.html"><img src="'.base_url().'assets/plugins/images/users/genu.jpg" alt="user" class="img-circle" /> '.$row->nombre_emp.'</a>
                            </td>
                            <td>'.$row->nombre_emp.'</td>
                            <td>'.$row->nombre_emp.'</td>
                            <td><span class="label label-danger">'.$row->nombre_emp.'</span></td>
                            <td>'.$row->nombre_emp.'</td>
                            <td>'.$row->nombre_emp.'</td>
                            <td>'.$row->nombre_emp.'</td>
                            <td>'.$row->nombre_emp.'</td>
                            <td>'.$row->nombre_emp.'</td>
                            <td>'.$row->nombre_emp.'</td>
                            <td>'.$row->nombre_emp.'</td>
                            <td>'.$row->nombre_emp.'</td>
                            <td>'.$row->nombre_emp.'</td>
                            <td>'.$row->nombre_emp.'</td>
                            
                        </tr>';
                
            }
        }
    
        echo $output;
    }

    public function mi_red()
    {
     if ($this->session->userdata('perfil') == false || $this->session->userdata('perfil') != 'emprendedor') {
            redirect(base_url() . 'login');
        }   
     $id_emp = $this->session->userdata('id_emp');
     $result = $this->modelogeneral->mostrar_asoc($id_emp);
    
     $data = array('asociados' => $result, 
                   'cant_asoc' => $this->modelogeneral->rowCountAsoc($id_emp),
                   'datos_emp' => $this->modelogeneral->datos_emp($id_emp),
                   );
    $this->load->view("layout/header",$data);
    $this->load->view("layout/side_menu",$data);
    $this->load->view("emprendedor/red",$data);
    $this->load->view("layout/footer");  

    }

    public function carrito()
    {
      if ($this->session->userdata('perfil') == false || $this->session->userdata('perfil') != 'emprendedor') {
            redirect(base_url() . 'login');
        }   
     $id_emp = $this->session->userdata('id_emp');
     $data['cant_asoc']  = $this->modelogeneral->rowCountAsoc($id_emp);
     $data['result']  = $this->modelogeneral->mostrar_carrito($id_emp);
     $data['datos_emp']  = $this->modelogeneral->datos_emp($id_emp);          
    
     $this->load->view("layout/header",$data);
     $this->load->view("layout/side_menu",$data);
     $this->load->view("emprendedor/carrito",$data);
     $this->load->view("layout/footer");  

    }

    public function modulos()
    {
      if ($this->session->userdata('perfil') == false || $this->session->userdata('perfil') != 'emprendedor') {
            redirect(base_url() . 'login');
        } 

     $id_emp = $this->session->userdata('id_emp');
     $result = $this->modelogeneral->mostrar_asoc($id_emp);
     $data['asociados']  = $result;
     $data['cant_asoc']  = $this->modelogeneral->rowCountAsoc($id_emp);
     $data['datos_emp']  = $this->modelogeneral->datos_emp($id_emp); 
     $data['list_cap']   = $this->modelogeneral->listar_data_cap(); 

     $this->load->view("layout/header",$data);
     $this->load->view("layout/side_menu",$data);
     $this->load->view("emprendedor/capacitacion_videos",$data);
     $this->load->view("layout/footer");  
    }

     public function Myperfil()
    {
      if ($this->session->userdata('perfil') == false || $this->session->userdata('perfil') != 'emprendedor') {
            redirect(base_url() . 'login');
        }   
     $id_emp = $this->session->userdata('id_emp');
     $data['cant_asoc']  = $this->modelogeneral->rowCountAsoc($id_emp);
     $data['datos_emp']  = $this->modelogeneral->datos_emp($id_emp);

    
    $this->load->view("layout/header",$data);
    $this->load->view("layout/side_menu",$data);
    $this->load->view("layout/perfil",$data);
    $this->load->view("layout/footer");  
    }

      public function calendario()
    {

     if ($this->session->userdata('perfil') == false || $this->session->userdata('perfil') != 'emprendedor') {
            redirect(base_url() . 'login');
        }   
     $id_emp = $this->session->userdata('id_emp');
     $result = $this->modelogeneral->mostrar_asoc($id_emp);
     $data = array('asociados' => $result);
     $data['cant_asoc']  = $this->modelogeneral->rowCountAsoc($id_emp);
     $data['datos_emp']  = $this->modelogeneral->datos_emp($id_emp);          
     
     $this->load->view("layout/header",$data);
     $this->load->view("layout/side_menu",$data);
     $this->load->view("emprendedor/calendar",$data);
     $this->load->view("layout/footer");  

    }

       public function tienda()
    {
     if ($this->session->userdata('perfil') == false || $this->session->userdata('perfil') != 'emprendedor') {
            redirect(base_url() . 'login');
        }   

     $id_emp = $this->session->userdata('id_emp');
     $result = $this->modelogeneral->mostrar_producto();
     $data   = array('productos' => $result);
     $data['cant_asoc']  = $this->modelogeneral->rowCountAsoc($id_emp);
     $data['datos_emp']  = $this->modelogeneral->datos_emp($id_emp);          
     $this->load->view("layout/header",$data);
     $this->load->view("layout/side_menu",$data);
     $this->load->view("emprendedor/tienda",$data);
     $this->load->view("layout/footer");  

    }
   

    public function add_toCar()
    {
     if ($this->session->userdata('perfil') == false || $this->session->userdata('perfil') != 'emprendedor') {
            redirect(base_url() . 'login');
        }   
        $param['id_emp']          = $this->session->userdata('id_emp');
        $param['id_producto']     = $this->input->post('id_producto');
        $param['cantidad']        = $this->input->post('cantidad');
        $year                     = date('Y');
        $no_orden                 =  $this->modelogeneral->datos_prod($year);
        $param['no_orden']        = $no_orden + 1;
        $param['fecha_car']       = date('Y-m-d');
        //$this->modelogeneral->update_orden_compra($year);
        $row['datos']             = $this->modelogeneral->datos_prod($param['id_producto']);
        $param['precio_car']      = $row['datos']->precio_unitario;
        $param['importe']         = $param['precio_car'] * $param['cantidad'];
        $result = $this->modelogeneral->insert_toCar($param);
        $msg['comprobador'] = false;
        if($result)
             {
               $msg['comprobador'] = TRUE;
             }
        echo json_encode($msg);
    }

     public function update_prodCar()
    {
       
        $param['id_car']    = $this->input->get('id_car');
        $param['cantidad']  = $this->input->get('cantidad');
        $param['importe']   = $this->input->get('importe');
        $result = $this->modelogeneral->update_prodCar($param);
        $msg['comprobador'] = false;
        if($result)
             {
               $msg['comprobador'] = TRUE;
             }
        echo json_encode($msg);
    }



     function carrito_compra()
    {
        if ($this->session->userdata('perfil') == false || $this->session->userdata('perfil') != 'emprendedor') {
            redirect(base_url() . 'login');
        }   

        $id_emp = $this->session->userdata('id_emp');
        $result = $this->modelogeneral->mostrar_carrito($id_emp);
        $count = 0;
        $output = '';
        if(!empty($result))
        {
            foreach($result as $row)
            {
                $count++;
                $output .= '<tr>
                                 <td class="text-center">&nbsp;</td>
                                <td class="text-center">
                                 <a class= "btn-remove-producto" data-toggle="tooltip" data="'.$row->id_car.'" data-original-title="Close"> <i class="fa fa-close text-danger"></i> </a></td>
                                <td>
                                <img src="'.base_url().'assets/uploads/img_productos/'.$row->url_imagen.'" alt="user" class="img-circle" /> '.$row->nombre_prod.'</td>
                                <td class="text-right"> '.$row->precio_car.' </td>
                                <td class="text-center">
                                   <div class="row">
                                    <div class="form-group">
                                     <input id="tch3_22" size="5" type="text" value="'.$row->cantidad.'" name="tch3_22" data-bts-button-down-class="btn btn-default btn-outline" data-bts-button-up-class="btn btn-default btn-outline"> </div> 
                                   </div>
                                </td>
                                <td class="text-right">'.$row->importe.'</td>

                            </tr>';
                
            }
        }
    
        echo $output;
    }
    public function eliminar_prodCar()
    {
        $param['id_car'] = $this->input->get('id_car');
        $param['id_emp'] = $this->session->userdata('id_emp');
        $result  = $this->modelogeneral->eliminar_prodCar($param);
        $msg['comprobador'] = false;
        if($result)
             {
               $msg['comprobador'] = TRUE;
             }
        echo json_encode($msg);
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
