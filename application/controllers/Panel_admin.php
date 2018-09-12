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
    $this->load->view("layout/header");
    $this->load->view("admin_general/side_menuAdmin");
    $this->load->view("admin_general/page_inicioAdmin");
    $this->load->view("layout/footer");  

    }

    function load_dataemp()
    {
        $result = $this->modelogeneral->mostrar_emp();
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
                    <td class="text-center">'.$count.'</td>
                    <td><span class="font-medium">'.$row->nombre_emp.'</span>
                        <br/><span class="text-muted">'.$row->email.'</span></td>
                    <td><span class="text-muted">'.$row->telefono_emp.'</span></td>
                    <td><span class="text-muted">'.$row->email.'</span></td>
                    <td><span class="text-muted">'.$row->fecha_insc.'</span></td>
                    <td>
                        <select class="form-control" id="sel_perfil">
                            <option value ="emprendedor" '.$selected.'>Emprendedor</option>
                            <option value ="administrador" '.$selected.' >Administrador</option>
                        </select>
                    </td>
                    <td>
                          <span class="label label-danger">Registro no completado</span>
                    </td>
                     </tr>';
                
            }
        }
    
        echo $output;
    }
    public function insert_emp()
    {
        $id_emprendedor       = $this->session->userdata('id_emp');
        $param['nombre_emp']   = $this->input->post('nombre_emp');
       // $param['dni_emp']      = $this->input->post('dni_emp');
        $param['email']        = $this->input->post('email');
        $param['telefono_emp'] = $this->input->post('telefono_emp');
        $param['fecha_insc']   = date('Y-m-d');
        $data['id_hijo']      = $this->modelogeneral->insert_emp($param);
        $data['id_padre']     = $this->session->userdata('id_emp');

        $nombre       = $this->session->userdata('nombre');
        
        $asunto = $nombre." te invita";
        $cuerpo_mensaje = "Hola ".$param['nombre_emp']." te invito a que formes parte de nuestro negocio como emprendedor";
        $url = base_url()."registro";
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
                         <td><span class="font-medium">'.$row->nombre_video.'</span>
                         </td>
                        <td><span class="text-muted">'.$row->evaluacion.'</span></td>
                        <td><span class="text-muted">'.$row->nivel.'</span></td>
                        </tr>';
            }
        }
    
        echo $output;
    }

    public function cuerpo_mail($datos)
    {
        $message = '<html><head>';
        $message .='<head>';
        $message .='<meta charset="UTF-8">';
        $message .='<meta http-equiv="X-UA-Compatible" content="IE=edge">';
        $message .='</head>';
        $message = '<html><body>';
        $message .= '<table  style=""  cellpadding="10">';
        $message .= "<tr ><td bgcolor='#1696e0' colspan='2'><div align='center'><h3>Datos de Registro  </h3></div> </td></tr>";
        $message .= "<tr style='background: #eee;'><td><strong>Fecha de registro:</strong> </td><td>" . $datos['fecha']. "</td></tr>";
        $message .= "<tr style='background: #eee;'><td><strong>Usuario:</strong> </td><td>" .$datos['usuario']. "</td></tr>";
        $message .= "<tr style='background: #eee;'><td><strong>Correo:</strong> </td><td>" .$datos['mail']. "</td></tr>";
        $message .= "<tr style='background: #eee;'><td><strong>DNI:</strong> </td><td>" . $datos['dni']. "</td></tr>";
        $message .= "<tr style='background: #eee;'><td><strong>Contrase&ntilde;a:</strong> </td><td>" . $datos['pass']. "</td></tr>";
        $message .= "<tr ><td colspan='2'> <a href='http://panel.shoppingads.com.ar/' target='_blank'>Acceso al Panel</a></td></tr>";
        $message .= "</table>";
    
        return  $message;
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
    $this->load->view("layout/header");
    $this->load->view("admin_general/side_menuAdmin");
    $this->load->view("admin_general/admin_productos");
    $this->load->view("layout/footer");  

    }
     public function admin_capacitacion()
    {
    if ($this->session->userdata('perfil') == false || $this->session->userdata('perfil') != 'administrador') {
            redirect(base_url() . 'login');
        }    
    $this->load->view("layout/header");
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