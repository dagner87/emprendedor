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
                $count++;
                $output .= ' <tr>
                    <td class="text-center">'.$count.'</td>
                                            <td><span class="font-medium">'.$row->nombre_emp.'</span>
                                                <br/><span class="text-muted">'.$row->email.'</span></td>
                                            <td>Visual Designer
                                                <br/><span class="text-muted">'.$row->telefono_emp.'</span></td>
                                            <td>daniel@website.com
                                                <br/><span class="text-muted">'.$row->estado_pago.'</span></td>
                                            <td><span class="text-muted">'.$row->fecha_insc.'</span></td>
                                            <td>
                                                <select class="form-control">
                                                    <option>Modulator</option>
                                                    <option>Admin</option>
                                                    <option>User</option>
                                                    <option>Subscriber</option>
                                                </select>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-info btn-outline btn-circle btn-lg m-r-5"><i class="ti-key"></i></button>
                                                <button type="button" class="btn btn-info btn-outline btn-circle btn-lg m-r-5"><i class="icon-trash"></i></button>
                                                <button type="button" class="btn btn-info btn-outline btn-circle btn-lg m-r-5"><i class="ti-pencil-alt"></i></button>
                                                <button type="button" class="btn btn-info btn-outline btn-circle btn-lg m-r-20"><i class="ti-upload"></i></button>
                                            </td>';
                
            }
        }
    
        echo $output;
    }
    
   

    public function insert_emp()
    {
        $id_emprendedor = 1 ;//viene por la seccion
        $param['nombre_emp']   = $this->input->post('nombre_emp');
       // $param['dni_emp']      = $this->input->post('dni_emp');
        $param['email']        = $this->input->post('email');
        $param['telefono_emp'] = $this->input->post('telefono_emp');
        $param['fecha_insc']   = date('Y-m-d');
       
        $data['id_hijo']      = $this->modelogeneral->insert_emp($param);
        $data['id_padre']     = 1; //viene por la seccion
       
        $result = $this->modelogeneral->insert_emp_asoc($data);
        $msg['comprobador'] = false;
        if($result)
             {
               $msg['comprobador'] = TRUE;
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
