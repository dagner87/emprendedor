<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Crom_mensual extends CI_Controller
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
         
     $id_emp                 = $this->session->userdata('id_emp'); 
     $data['cant_asoc']      = $this->modelogeneral->rowCountAsoc($id_emp);
     $data['result']         = $this->modelogeneral->mostrar_asoc($id_emp);
     $data['datos_emp']      = $this->modelogeneral->datos_emp($id_emp);
     $data['ultimo_reg']     = $this->modelogeneral->las_insetCap(); 
     $data['cantidadVideos'] = $this->modelogeneral->rowCount("capacitacion");
     $data['sumatoriaComp']  = $this->modelogeneral->sumatoriaCompraEmp($id_emp);
     $data['cantidad_prod']  = $this->modelogeneral->count_cantProdCar($id_emp);
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
















}
