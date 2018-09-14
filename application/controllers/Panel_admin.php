<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
class Panel_admin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->helper('url');
        $this->load->model('modelogeneral');
        $this->load->library('session');
        $this->load->library('form_validation');
       
    }
       public function index()
    {
    if ($this->session->userdata('perfil') == false || $this->session->userdata('perfil') != 'administrador') {
            redirect(base_url() . 'login');
        }
     $id_emp = $this->session->userdata('id_emp');
     $data['datos_emp']  = $this->modelogeneral->datos_emp($id_emp); 
     $data['total_emp']  = $this->modelogeneral->Total_emp("emprendedor");       
     
     $this->load->view("layout/header",$data);
     $this->load->view("admin_general/side_menuAdmin");
     $this->load->view("admin_general/page_inicioAdmin",$data);
     $this->load->view("layout/footer");  
    }
       public function MyperfilAdmin()
    {
      if ($this->session->userdata('perfil') == false || $this->session->userdata('perfil') != 'administrador') {
            redirect(base_url() . 'login');
        }   
     $id_emp = $this->session->userdata('id_emp');
     $data['cant_asoc']  = $this->modelogeneral->rowCountAsoc($id_emp);
     $data['datos_emp']  = $this->modelogeneral->datos_emp($id_emp);
    
    $this->load->view("layout/header",$data);
    $this->load->view("admin_general/side_menuAdmin");
    $this->load->view("layout/perfil",$data);
    $this->load->view("layout/footer");  
    }
    function load_dataemp()
    {
        $id_emp = $this->session->userdata('id_emp');
        $result = $this->modelogeneral->mostrar_emp($id_emp);
        $count = 0;
        $output = '';
        if(!empty($result))
        {
            foreach($result as $row)
            {
                if ($row->perfil == 'administrador' ) {
                    $selected = 'selected';
                }else{
                    $selected = '';
                }
                $count++;
                $output .= '<tr>
                              <td><span class="font-medium">'.$row->nombre_emp.'</span>
                                  <br/><span class="text-muted">'.$row->email.'</span></td>
                              <td>--</td>
                              <td><span class="text-muted">'.$row->telefono_emp.'</span></td>
                             
                              <td>
                                  <select class="form-control" id="sel_perfil">
                                      <option value ="emprendedor" '.$selected.'>Emprendedor</option>
                                      <option value ="administrador" '.$selected.' >Administrador</option>
                                  </select>
                              </td>
                              <td>
                                 <span class="label label-danger">Registro no completado</span>
                              </td>
                              <td>
                              <button type="button" data="'.$row->id_emp.'" class="btn btn-sm btn-icon btn-pure btn-outline delete-row-btn" data-toggle="tooltip" data-original-title="Delete"><i class="ti-close" aria-hidden="true"></i></button>
                              </td>
                            </tr>';
            }
        }
    
        echo $output;
    }
     
      public function eliminar_emp()
    {
        $id_emp = $this->input->get('id_emp');
        $result  = $this->modelogeneral->eliminar_emp($id_emp);
        $msg['comprobador'] = false;
        if($result)
             {
               $msg['comprobador'] = TRUE;
             }
        echo json_encode($msg);
    }
    public function insert_emp()
    {
        $id_emprendedor        = $this->session->userdata('id_emp');
       // $param['nombre_emp']   = $this->input->post('nombre_emp');
        $param['foto_emp']     = 'no_img.jpg';
        $param['email']        = $this->input->post('email');
       // $param['telefono_emp'] = $this->input->post('telefono_emp');
        $param['fecha_insc']   = date('Y-m-d');
        
        $data['id_hijo']       = $this->modelogeneral->insert_emp($param);
        $data['id_padre']      = $this->session->userdata('id_emp');
        $nombre       = $this->session->userdata('nombre');
        
        $asunto = $nombre." te invita";
        $cuerpo_mensaje = "Hola te invito a que formes parte de nuestro negocio como emprendedor";
        $url = base_url()."registro?id=".$data['id_hijo'];
        $cuerpo_mensaje .= "<a href='".$url."' target='_blank'> Completar Registro</a>";
        $this->sendMailMandril($param['email'],$asunto, $cuerpo_mensaje);
        $result = $this->modelogeneral->insert_emp_asoc($data);
        $msg['comprobador'] = false;
        if($result)
             {
               $msg['comprobador'] = TRUE;
             }
        echo json_encode($msg);
    }
     function load_datAdmCap()
    {
        $result = $this->modelogeneral->listar_data_cap();
        $count = 0;
        $output = '';
        if(!empty($result))
        {
          foreach($result as $row)
            {
             $output .= '<tr>
                         <td><span class="font-medium">'.$row->nombre_video.'</span></td>
                         <td><span class="text-muted">'.$row->url_video.'</span></td>
                        <td><span class="text-muted">'.$row->evaluacion.'</span></td>
                        <td><span class="text-muted"> <button type="button" data="'.$row->id_cap.'" class="btn btn-sm btn-icon btn-pure btn-outline deletecap-row-btn" data-toggle="tooltip" data-original-title="Delete"><i class="ti-close" aria-hidden="true"></i></button></span></td>
                        </tr>';
            }
        }
    
        echo $output;
    }
    /* Insertar videos*/
    public function insert_cap()
    {
       
        $param['nombre_video']   = $this->input->post('nombre_video');
        $param['evaluacion']     = $this->input->post('evaluacion');
        $param['url_video']      = $this->input->post('url_video');
        $param['nivel']          = $this->input->post('nivel');
        $result                  = $this->modelogeneral->insert_cap($param);
        $msg['comprobador'] = false;
        if($result)
             {
               $msg['comprobador'] = TRUE;
             }
        echo json_encode($msg);
    }
     /* eliminar videos de capacitacion */
      public function eliminar_cap()
    {
        $id_cap = $this->input->get('id');
        $result  = $this->modelogeneral->eliminar_cap($id_cap);
        $msg['comprobador'] = false;
        if($result)
             {
               $msg['comprobador'] = TRUE;
             }
        echo json_encode($msg);
    }
 /*----------- CRUD PRODUCTO-----------------------*/ 
     function load_dataProp()
    {
        $result = $this->modelogeneral->listar_data_prod();
        $count = 0;
        $output = '';
        if(!empty($result))
        {
          foreach($result as $row)
            {
             $output .= '<tr>
                         <td><span class="text-muted"><img src="'.base_url().'assets/uploads/img_productos/'.$row->url_imagen.'" alt="user" class="img-circle" /></td>
                         <td><span class="font-medium">'.$row->nombre_prod.'</span></td>
                         <td><span class="text-muted">'.$row->stock.'</span></td>
                         <td><span class="text-muted">'.$row->precio_unitario.'</span></td>
                         <td><span class="text-muted"> <button type="button" data="'.$row->id_producto.'" class="btn btn-sm btn-icon btn-pure btn-outline deletecap-row-btn" data-toggle="tooltip" data-original-title="Delete"><i class="ti-close" aria-hidden="true"></i></button></span></td>
                        </tr>';
            }
        }
    
        echo $output;
    }
       /* Insertar producto*/
    public function insert_prod()
    {
       
        $param['nombre_prod']     = $this->input->post('nombre_prod');
        $param['stock']           = $this->input->post('stock');
        $param['precio_unitario'] = $this->input->post('precio_unitario');
        $param['url_imagen']      = $this->input->post('nombre_archivo');
        
        $result = $this->modelogeneral->insert_prod($param);
        $msg['comprobador'] = false;
        if($result)
             {
               $msg['comprobador'] = TRUE;
             }
        echo json_encode($msg);
    }
     /* eliminar producto */
      public function eliminar_prod()
    {
        $id = $this->input->get('id');
        $result  = $this->modelogeneral->eliminar_prod($id);
        $msg['comprobador'] = false;
        if($result)
             {
               $msg['comprobador'] = TRUE;
             }
        echo json_encode($msg);
    }
 /*-----------./ CRUD PRODUCTO-----------------------*/ 
 /* subir imagen*/
 public function subir_img()
    {
        $config['upload_path'] = 'assets/uploads/img_productos';
        $config['allowed_types'] = 'pdf|jpg|png|jpeg';
        $config['max_size'] = 4048;
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload('url_imagen')) { #Aquí me refiero a "foto", el nombre que pusimos en FormData
            $error = array('error' => $this->upload->display_errors());
            echo json_encode($error);
        } else {
          $datos_img = array('upload_data' =>$this->upload->data());
          $msg['imagen'] = $datos_img['upload_data']['file_name'];
           echo json_encode($msg);
        }
    }
  public function subir_imgPerfil()
    {
        $config['upload_path'] = 'assets/plugins/images/users';
        $config['allowed_types'] = 'pdf|jpg|png|jpeg';
        $config['max_size'] = 4048;
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload('url_imagen')) { #Aquí me refiero a "foto", el nombre que pusimos en FormData
            $error = array('error' => $this->upload->display_errors());
            echo json_encode($error);
        } else {
          $datos_img = array('upload_data' =>$this->upload->data());
          $msg['imagen'] = $datos_img['upload_data']['file_name'];
           echo json_encode($msg);
        }
    }
    
 /*------update perfil--------*/
 public function update_perfil()
    {
        $param['id_emp']       = $this->session->userdata('id_emp');
        $param['nombre_emp']   = $this->input->post('nombre_emp');
        $param['foto_emp']     = $this->input->post('foto_emp');
        $param['email']        = $this->input->post('email');
        $param['dni_emp']      = $this->input->post('dni_emp');
        $param['telefono_emp'] = $this->input->post('telefono_emp');
        
        $result = $this->modelogeneral->update_perfil($param);
        $msg['comprobador'] = false;
        if($result)
             {
               $msg['comprobador'] = TRUE;
             }
        echo json_encode($msg);
    }
 /*-----------------------------*/  
    public function forgot_pass()
    {
         $email  = $this->input->post('email_rest');
          $pass = '1234';
         $result = $this->modelogeneral->comprobar_email($email,$password);
        
         $msg['comprobador'] = false;
        if($result)
             {
               $msg['comprobador'] = TRUE;
               $asunto = "Olvidó su contraseña";
               $cuerpo_mensaje = "Nueva Contraseña es :".$pass;
               $url = base_url()."login";
               $cuerpo_mensaje .= "<a href='".$url."' target='_blank'> Ingresar</a>";
              $this->sendMailMandril($email,$asunto, $cuerpo_mensaje);
             }
       
        echo json_encode($pass);
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
    public function admin_prod()
    {
    if ($this->session->userdata('perfil') == false || $this->session->userdata('perfil') != 'administrador') {
            redirect(base_url() . 'login');
        }
    $id_emp = $this->session->userdata('id_emp');
    $data['datos_emp']  = $this->modelogeneral->datos_emp($id_emp);          
    $this->load->view("layout/header",$data);
    $this->load->view("admin_general/side_menuAdmin");
    $this->load->view("admin_general/admin_productos");
    $this->load->view("layout/footer");  
    }
     public function admin_capacitacion()
    {
    if ($this->session->userdata('perfil') == false || $this->session->userdata('perfil') != 'administrador') {
            redirect(base_url() . 'login');
        }
    $id_emp = $this->session->userdata('id_emp');
    $data['datos_emp']  = $this->modelogeneral->datos_emp($id_emp);          
    $this->load->view("layout/header",$data);
    $this->load->view("admin_general/side_menuAdmin");
    $this->load->view("admin_general/admin_videos");
    $this->load->view("layout/footer");  
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
