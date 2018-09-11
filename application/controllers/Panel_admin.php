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

    function load_data_emprendedores()
    {
        $result = $this->csv_import_model->select();
        $count = 0;
        $output = '';
        if($result->num_rows() > 0)
        {
            foreach($result->result() as $row)
            {
                $count = $count + 1;
                $output .= '
                  <tr>
                    <td>'.$row->id_producto.'</td>
                    <td>'.$row->nombre_producto.'</td>
                    <td><input type="text" name="stock[]" id="stock_'.$row->id_producto.'" value="'.$row->stock.'" required>
                     <i id="capa_stock'.$row->id_producto.'"></i></td>
                    <td><input type="text" name="precio[]" id="precio_'.$row->id_producto.'" value="'.$row->precio.'" required> 
                    <i  id="capa_precio'.$row->id_producto.'"></i></td>
                    <td><input type="text" name="preciopromo[]" id="preciopromo_'.$row->id_producto.'" value="'.$row->preciopromo.'" required>
                     <i  id="capa_preciopromo'.$row->id_producto.'"></i></td>
                    <td class="tooltip-prod">';
                 if ($row->estado == 0) { 
                 $output .= ' <button type="button" class="btn btn-success btn-circle" data-toggle="tooltip" data-placement="right" title="Cargado"></button>';
                 }else{
                 $output .= '<button type="button" class="btn btn-warning btn-circle" data-toggle="tooltip" data-placement="right" title="Modificado"></button>';
                 } 
                 $output .= '</td></tr>';
                
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
