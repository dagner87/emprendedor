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
                $output .= ' <tr>
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
                                            ';
                
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
        $result = $this->modelogeneral->insert_emp_asoc($data);
        $msg['comprobador'] = false;
        if($result)
             {
               $msg['comprobador'] = TRUE;
             }
        echo json_encode($msg);
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
