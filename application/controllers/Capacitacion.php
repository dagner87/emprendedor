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
        $this->load->library('session');
        $this->load->library('form_validation');
    
    }
     public function index()
    {
      if ($this->session->userdata('perfil') == false || $this->session->userdata('perfil') != 'emprendedor') {
            redirect(base_url() . 'login');
        }   
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
            
           $data['foot']="";
           $data['foot_comisiones'] ="";
           $i=1;
           $total_comision = 0;
            while ($i <= 12):
                 $dato['year'] = date('Y');
                 $dato['mes']= $i;  
                 $dato['id_emp'] = $id_emp;
                 $valores_comisiones = $this->modelogeneral->cantidadVentas($dato); 
                 $data['foot'] .=  '<th class="text-center">'.$valores_comisiones['porciento'].'%</th>';
                 $data['foot_comisiones'] .=  '<th class="text-center">$ '.$valores_comisiones['comision'].'</th>';                
                $i++;
                $total_comision += $valores_comisiones['comision'];
            endwhile;

             $data['total_comision']= $total_comision;            
             $this->load->view("layout/page_content",$data);
            }
       $this->load->view("layout/footer");  
    }


     public function modulos()
    {
      if ($this->session->userdata('perfil') == false || $this->session->userdata('perfil') != 'emprendedor') {
            redirect(base_url() . 'login');
        } 

     $id_emp = $this->session->userdata('id_emp');
     $result = $this->modelogeneral->mostrar_asoc($id_emp);
     $data['asociados']      = $result;
     $data['cant_asoc']      = $this->modelogeneral->rowCountAsoc($id_emp);
     $data['datos_emp']      = $this->modelogeneral->datos_emp($id_emp); 
     $data['ultimo_reg']     = $this->modelogeneral->las_insetCap(); 
     $data['cantidadVideos'] = $this->modelogeneral->rowCount("capacitacion");
     $data['cantidad_prod']  = $this->modelogeneral->count_cantProdCar($id_emp);
    
     $this->load->view("layout/header",$data);
     $this->load->view("layout/side_menu",$data);
     $this->load->view("emprendedor/capacitacion_videos",$data);
     $this->load->view("layout/footer");  
    }


      public function cartera_clientes()
    {
      if ($this->session->userdata('perfil') == false || $this->session->userdata('perfil') != 'emprendedor') {
            redirect(base_url() . 'login');
        } 

     $id_emp                 = $this->session->userdata('id_emp');
     $data['productos']      = $this->modelogeneral->seleccion_productos();
     $data['provincias']     = $this->modelogeneral->select_provincias();  
     $data['cant_asoc']      = $this->modelogeneral->rowCountAsoc($id_emp);
     $data['datos_emp']      = $this->modelogeneral->datos_emp($id_emp); 
     $data['ultimo_reg']     = $this->modelogeneral->las_insetCap(); 
     $data['cantidadVideos'] = $this->modelogeneral->rowCount("capacitacion");
     $data['cantidad_prod']  = $this->modelogeneral->count_cantProdCar($id_emp);
 
     $this->load->view("layout/header",$data);
     $this->load->view("layout/side_menu",$data);
     $this->load->view("emprendedor/cartera_clientes",$data);
     $this->load->view("layout/footer");  
    }

    public function historial_cliente($id_cliente)
    {
      if ($this->session->userdata('perfil') == false || $this->session->userdata('perfil') != 'emprendedor') {
            redirect(base_url() . 'login');
        } 

       
     $data['datos_cliente']  = $this->modelogeneral->datos_cliente($id_cliente);
     
     $id_emp                 = $this->session->userdata('id_emp');
     $data['provincias']     = $this->modelogeneral->select_provincias();  
     $data['cant_asoc']      = $this->modelogeneral->rowCountAsoc($id_emp);
     $data['datos_emp']      = $this->modelogeneral->datos_emp($id_emp); 
     $data['ultimo_reg']     = $this->modelogeneral->las_insetCap(); 
     $data['cantidadVideos'] = $this->modelogeneral->rowCount("capacitacion");
     $data['cantidad_prod']  = $this->modelogeneral->count_cantProdCar($id_emp);
     
     
 
     $this->load->view("layout/header",$data);
     $this->load->view("layout/side_menu",$data);
     $this->load->view("emprendedor/ficha_cliente",$data);
     $this->load->view("layout/footer");  
    }

    function load_dataClientes()
    {
        $result = $this->modelogeneral->listar_clientes();
        $count = 0;
        $output = '';
        if(!empty($result))
        {
          foreach($result as $row)
            {
              $output .= ' <tr>
                         <td>'.$row->dni.'</td>
                         <td>'.$row->nombre_cliente.' '.$row->apellidos.' </td>
                         <td>'.$row->telefono.'</td>
                         <td>'.$row->celular.'</td>
                         <td>'.$row->email.'</td>
                         <td>
                         <button type="button" data="'.$row->id_cliente.'" class="btn btn-info btn-outline btn-circle btn-sm hist-cliente"><i class="fa fa-history"></i></button>
                          </td>
                         </tr>';                                        
            }
        }
    
        echo $output;
    }

      function load_historialCompra()
    {
         $id_cliente         = $this->input->post('id');
        $result = $this->modelogeneral->listado_pedidos($id_cliente);
        $output = '';
        if(!empty($result))
        {
          foreach($result as $row)
            {
              $productos = $this->modelogeneral->listado_pedidosProd($row->id_pedidos);  
              $output .= ' <tr>
                         <td>'.$row->no_pedido.'</td>';
                         $output .= '<td>';
                         foreach($productos as $prod):
                          $output .= '<span class="text-muted">'.$prod->nombre_prod.'</br></span>';
                          endforeach ; 
                         $output .= '</td>
                         <td>'.$row->total.'</td>
                         <td>'.$row->fecha_solicitud.'</td>
                         <td>'.$row->fecha_solicitud.'</td>
                         </tr>';                                        
            }
        }
    
        echo $output;
    }

   function select_municipio()
    {
        $id_provincia = $this->input->post("id");
        $result = $this->modelogeneral->select_municipio($id_provincia);
        $output = '';
        if(!empty($result))
        {
          foreach($result as $row)
            {
             $output .= '<option value="'.$row->id_municipio.'">'.$row->nombre.'</option>';
            }
        }
    
        echo $output;
    }
    public function insert_cliente()
    {
         if ($this->session->userdata('perfil') == false || $this->session->userdata('perfil') != 'emprendedor') {
            redirect(base_url() . 'login');
        } 

        $param['id_emp']            = $this->session->userdata('id_emp');
        $param['nombre_cliente']    = $this->input->post('nombre_cliente');
        $param['apellidos']         = $this->input->post('apellidos');
        $param['dni']               = $this->input->post('dni');
        $param['telefono']          = $this->input->post('telefono');
        $param['email']             = $this->input->post('email');
        $param['celular']           = $this->input->post('celular');
        $param['direccion']         = $this->input->post('direccion');
        $param['fecha_nacimiento']  = $this->input->post('fecha_nacimiento');
        $param['fecha_incio']       = $this->input->post('fecha_incio');
        $param['id_municipio']      = $this->input->post('id_municipio');
        $param['id_provincia']      = $this->input->post('id_provincia');
        $datos_emp                  = $this->modelogeneral->datos_emp($param['id_emp']);
        $param['id_pais']           = $datos_emp->id_pais;
       

        $result = $this->modelogeneral->insert_cliente($param);
        
         $msg['comprobador'] = false;
        if($result)
             {
               $data['id_cliente']      =  $this->modelogeneral->lastID();
               $data['id_emp']          = $this->session->userdata('id_emp');

               $data['no_pedido']       = 'ing-manual-001';
               $data['fecha_solicitud'] = $this->input->post('fecha_incio');
              
               if($this->modelogeneral->save_Pedido($data)){

                 $data['id_pedidos'] =  $this->modelogeneral->lastID();
                 $data['productos']  = $this->input->post('productos');
                 $data['cantidad']   = $this->input->post('cantidades');
                 $this->save_detallePedido($data);
               } 
              $msg['comprobador'] = TRUE;
             }
        echo json_encode($data);
    }

protected function updateComprobante($idcomprobante){
        $comprobanteActual = $this->modelogeneral->getComprobante($idcomprobante);
        $data  = array(
            'cantidad' => $comprobanteActual->cantidad + 1, 
        );
        $this->modelogeneral->updateComprobante($idcomprobante,$data);
    }    

protected function save_detallePedido($data){ 
    for ($i=0; $i < count($data['productos']); $i++) { 
      
          $dato_combo = array(
              'id_producto' => $data['productos'][$i], 
              'id_pedidos'    => $data['id_pedidos'],
              'cantidad'    => $data['cantidad'][$i] 
          );
        
        $this->modelogeneral->save_detallePedido($dato_combo);
    
    }
}


public function update_datosCliente()
    {
        $param['id_cliente']        = $this->input->post('id_cliente');
        $param['nombre_cliente']    = $this->input->post('nombre_cliente');
        $param['apellidos']         = $this->input->post('apellidos');
        $param['dni']               = $this->input->post('dni');
        $param['telefono']          = $this->input->post('telefono');
        $param['email']             = $this->input->post('email');
        $param['celular']           = $this->input->post('celular');
        $param['direccion']         = $this->input->post('direccion');
        $param['fecha_nacimiento']  = $this->input->post('fecha_nacimiento');
        $param['fecha_incio']       = $this->input->post('fecha_incio');
        $param['id_municipio']      = $this->input->post('id_municipio');
        $param['id_provincia']      = $this->input->post('id_provincia');

        
        $result   = $this->modelogeneral->update_datosCliente($param);
        $msg['comprobador'] = false;
        if($result)
             {
               $msg['comprobador']  = TRUE;
               
             }
        echo json_encode($param);
    } 




    



    






     public function cron_fin_Mes()
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





    

    public function view_formEval(){

        $id_cap = $this->input->post("id");
        $data = array(
            "id_cap"  =>$id_cap,
            "preguntas" => $this->modelogeneral->listar_preguntas_cap($id_cap),
            
        );
        $this->load->view("emprendedor/formulario_evaluacion",$data);
    }


   /* Insertar Evaluacion*/
    public function update_evalcap()
    {
        $param['id_emp']           = $this->session->userdata('id_emp');
        $param['id_cap']           = $this->input->post('id_cap');
        $param['evaluacion_video'] = $this->input->post('evaluacion');
        
        $result   = $this->modelogeneral->udpate_evalcap($param);
        $msg['comprobador'] = false;
        $id_cap = $param['id_cap']+ 1;
        if($result)
             {
               $msg['comprobador']  = TRUE;
               $datos_upd['id_emp'] = $this->session->userdata('id_emp');
               $datos_upd['id_cap'] = $id_cap;
               $msg['updatemp'] = $this->modelogeneral->udpate_emp($datos_upd);
             }
        echo json_encode($param);
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
            
            $mes= 0;
            foreach($result as $row)
            {
                
                $sumatoriaComp  = $this->modelogeneral->sumatoriaCompraEmp($row->id_emp);
                $data['mes']    = 0;
                $data['year']   = date('Y');
                $data['id_emp'] = $row->id_emp;
                $S_ConsumoMensual  = $this->modelogeneral->sumatoriaCompraEmpMensual($data);
                $output .= '<tr>
                            <td>
                            <strong><img src="'.base_url().'assets/plugins/images/users/'.$row->foto_emp.'" alt="user" class="img-circle" /> '.$row->nombre_emp.'</strong>
                            </td>
                            <td> $ '.$sumatoriaComp->total_comp.'</td>';
                             $data['mes'] ++;
                             $S_ConsumoMensual  = $this->modelogeneral->sumatoriaCompraEmpMensual($data);
                             if ($S_ConsumoMensual->total_comp == 0) {
                                $msg ="error";
                             }else{
                                $msg ="success";
                             }

                             $output .= '<td> <div class="col-md-12">
                                                <div class="form-group has-'.$msg.'">
                                                    <input type="text" id="" readonly class="form-control" value=" $'.$S_ConsumoMensual->total_comp.'"></div>
                                                </div></td>';
                             $data['mes']++;
                             $S_ConsumoMensual  = $this->modelogeneral->sumatoriaCompraEmpMensual($data);
                             if ($S_ConsumoMensual->total_comp == 0) {
                                $msg ="error";
                             }else{
                                $msg ="success";
                             }

                             $output .= '<td> <div class="col-md-12">
                                                <div class="form-group has-'.$msg.'">
                                                    <input type="text" id="" readonly class="form-control" value=" $'.$S_ConsumoMensual->total_comp.'"></div>
                                                </div></td>';
                             $data['mes'] ++;
                             $S_ConsumoMensual  = $this->modelogeneral->sumatoriaCompraEmpMensual($data);
                             if ($S_ConsumoMensual->total_comp == 0) {
                                $msg ="error";
                             }else{
                                $msg ="success";
                             }

                             $output .= '<td> <div class="col-md-12">
                                                <div class="form-group has-'.$msg.'">
                                                    <input type="text" id="" readonly class="form-control" value=" $'.$S_ConsumoMensual->total_comp.'"></div>
                                                </div></td>';
                             $data['mes']++;
                             $S_ConsumoMensual  = $this->modelogeneral->sumatoriaCompraEmpMensual($data);
                             if ($S_ConsumoMensual->total_comp == 0) {
                                $msg ="error";
                             }else{
                                $msg ="success";
                             }

                             $output .= '<td> <div class="col-md-12">
                                                <div class="form-group has-'.$msg.'">
                                                    <input type="text" id="" readonly class="form-control" value=" $'.$S_ConsumoMensual->total_comp.'"></div>
                                                </div></td>';
                             $data['mes']++;
                             $S_ConsumoMensual  = $this->modelogeneral->sumatoriaCompraEmpMensual($data);
                             if ($S_ConsumoMensual->total_comp == 0) {
                                $msg ="error";
                             }else{
                                $msg ="success";
                             }

                             $output .= '<td> <div class="col-md-12">
                                                <div class="form-group has-'.$msg.'">
                                                    <input type="text" id="" readonly class="form-control" value=" $'.$S_ConsumoMensual->total_comp.'"></div>
                                                </div></td>';
                             $data['mes']++;
                             $S_ConsumoMensual  = $this->modelogeneral->sumatoriaCompraEmpMensual($data);
                             if ($S_ConsumoMensual->total_comp == 0) {
                                $msg ="error";
                             }else{
                                $msg ="success";
                             }

                             $output .= '<td> <div class="col-md-12">
                                                <div class="form-group has-'.$msg.'">
                                                    <input type="text" id="" readonly class="form-control" value=" $'.$S_ConsumoMensual->total_comp.'"></div>
                                                </div></td>';
                             $data['mes']++;
                             $S_ConsumoMensual  = $this->modelogeneral->sumatoriaCompraEmpMensual($data);
                             if ($S_ConsumoMensual->total_comp == 0) {
                                $msg ="error";
                             }else{
                                $msg ="success";
                             }

                             $output .= '<td> <div class="col-md-12">
                                                <div class="form-group has-'.$msg.'">
                                                    <input type="text" id="" readonly class="form-control" value=" $'.$S_ConsumoMensual->total_comp.'"></div>
                                                </div></td>';
                             $data['mes']++;
                             $S_ConsumoMensual  = $this->modelogeneral->sumatoriaCompraEmpMensual($data);
                             if ($S_ConsumoMensual->total_comp == 0) {
                                $msg ="error";
                             }else{
                                $msg ="success";
                             }

                             $output .= '<td> <div class="col-md-12">
                                                <div class="form-group has-'.$msg.'">
                                                    <input type="text" id="" readonly class="form-control" value=" $'.$S_ConsumoMensual->total_comp.'"></div>
                                                </div></td>';
                             $data['mes']++;
                             $S_ConsumoMensual  = $this->modelogeneral->sumatoriaCompraEmpMensual($data);
                             if ($S_ConsumoMensual->total_comp == 0) {
                                $msg ="error";
                             }else{
                                $msg ="success";
                             }

                             $output .= '<td> <div class="col-md-12">
                                                <div class="form-group has-'.$msg.'">
                                                    <input type="text" id="" readonly class="form-control" value=" $'.$S_ConsumoMensual->total_comp.'"></div>
                                                </div></td>';
                             $data['mes']++;
                             $S_ConsumoMensual  = $this->modelogeneral->sumatoriaCompraEmpMensual($data);
                             if ($S_ConsumoMensual->total_comp == 0) {
                                $msg ="error";
                             }else{
                                $msg ="success";
                             }

                             $output .= '<td> <div class="col-md-12">
                                                <div class="form-group has-'.$msg.'">
                                                    <input type="text" id="" readonly class="form-control" value=" $'.$S_ConsumoMensual->total_comp.'"></div>
                                                </div></td>';
                             $data['mes']++;
                             $S_ConsumoMensual  = $this->modelogeneral->sumatoriaCompraEmpMensual($data);
                             if ($S_ConsumoMensual->total_comp == 0) {
                                $msg ="error";
                             }else{
                                $msg ="success";
                             }

                             $output .= '<td> <div class="col-md-12">
                                                <div class="form-group has-'.$msg.'">
                                                    <input type="text" id="" readonly class="form-control" value=" $'.$S_ConsumoMensual->total_comp.'"></div>
                                                </div></td>';
                             $data['mes']++;
                             $S_ConsumoMensual  = $this->modelogeneral->sumatoriaCompraEmpMensual($data);
                             if ($S_ConsumoMensual->total_comp == 0) {
                                $msg ="error";
                             }else{
                                $msg ="success";
                             }

                             $output .= '<td> <div class="col-md-12">
                                                <div class="form-group has-'.$msg.'">
                                                    <input  type="text" id="" readonly class="form-control" value=" $'.$S_ConsumoMensual->total_comp.'"></div>
                                                </div></td></tr>';

                      
                
            }
        }
    
        echo $output;
    }

    public function mi_red()
    {
     if ($this->session->userdata('perfil') == false || $this->session->userdata('perfil') != 'emprendedor') {
            redirect(base_url() . 'login');
        }   
     $id_emp                 = $this->session->userdata('id_emp');
     $data['datos_emp']      = $this->modelogeneral->datos_emp($id_emp);
     $data['ultimo_reg']     = $this->modelogeneral->las_insetCap(); 
     $data['cantidadVideos'] = $this->modelogeneral->rowCount("capacitacion");
     $data['asociados']      = $this->modelogeneral->mostrar_asoc($id_emp);
     $data['cant_asoc']      = $this->modelogeneral->rowCountAsoc($id_emp);
     $data['datos_emp']      = $this->modelogeneral->datos_emp($id_emp);
     $data['cantidad_prod']  = $this->modelogeneral->count_cantProdCar($id_emp);
    
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
     $id_emp                 = $this->session->userdata('id_emp');
     $data['cant_asoc']      = $this->modelogeneral->rowCountAsoc($id_emp);
     $data['result']         = $this->modelogeneral->mostrar_carrito($id_emp);
     $data['datos_emp']      = $this->modelogeneral->datos_emp($id_emp);
     $data['ultimo_reg']     = $this->modelogeneral->las_insetCap(); 
     $data['cantidadVideos'] = $this->modelogeneral->rowCount("capacitacion"); 
     $data['cantidad_prod']  = $this->modelogeneral->count_cantProdCar($id_emp);         
    
     $this->load->view("layout/header",$data);
     $this->load->view("layout/side_menu",$data);
     $this->load->view("emprendedor/carrito",$data);
     $this->load->view("layout/footer");  

    }

    public function comprar($id_compra)
    {
      if ($this->session->userdata('perfil') == false || $this->session->userdata('perfil') != 'emprendedor') {
            redirect(base_url() . 'login');
        }   
     $id_emp                 = $this->session->userdata('id_emp');
     $data['cant_asoc']      = $this->modelogeneral->rowCountAsoc($id_emp);
     $data['result']         = $this->modelogeneral->mostrar_carrito($id_emp);
     $data['datos_emp']      = $this->modelogeneral->datos_emp($id_emp);
     $data['ultimo_reg']     = $this->modelogeneral->las_insetCap(); 
     $data['cantidadVideos'] = $this->modelogeneral->rowCount("capacitacion"); 


     $data['detalle']   = $this->modelogeneral->getDetalleCompra($id_compra);
     $data['compra']    = $this->modelogeneral->getdatosCompra($id_compra);
     $data['cantidad_prod']  = $this->modelogeneral->count_cantProdCar($id_emp);    

     $this->load->view("layout/header",$data);
     $this->load->view("layout/side_menu",$data);
     $this->load->view("emprendedor/compra_completada",$data);
     $this->load->view("layout/footer");  

    }



   public function validar_carrito(){

    if ($this->input->post()) 
        {
        
         $this->form_validation->set_rules('cantidades','...', 'callback_verficar_cantidad');
         $this->form_validation->set_rules('sub_total', '...', 'callback_verficar_monto');
         
          if($this->form_validation->run() === TRUE) 
            {

                 $id_emp                 = $this->session->userdata('id_emp');
                 $data['cant_asoc']      = $this->modelogeneral->rowCountAsoc($id_emp);
                 $data['result']         = $this->modelogeneral->mostrar_carrito($id_emp);
                 $data['datos_emp']      = $this->modelogeneral->datos_emp($id_emp);
                 $data['ultimo_reg']     = $this->modelogeneral->las_insetCap(); 
                 $data['cantidadVideos'] = $this->modelogeneral->rowCount("capacitacion"); 


                 $idproductos            = $this->input->post("idproductos");
                 $cantidades             = $this->input->post("cantidades");
                 $precio_comp            = $this->input->post("precios");
                 $importes               = $this->input->post("importes");
                 $micartera              = $this->input->post("micartera");
                 $datos_upd['comision_acumulada'] = $micartera - $data['datos_emp']->comision_acumulada;
                 $datos_upd['id_emp']   = $id_emp;

                 $this->modelogeneral->udpate_emp($datos_upd);
                
                 $param['total_comp']    = $this->input->post("total");
                 $param['fecha_comp']    = date('Y-m-d H:i:s');
                 $param['id_emp']        = $this->session->userdata('id_emp');
                 $year                   = date('Y');
                 $param['no_compra']     = $this->modelogeneral->N_orden_compra($year);



                  if ($this->modelogeneral->save_compra($param)) {
                        $id_compra = $this->modelogeneral->lastID();
                        $this->save_detalleCompra($idproductos,$id_compra,$precio_comp,$cantidades,$importes);
                        $this->modelogeneral->limpiar_carrito($id_emp);
                        $this->modelogeneral->update_orden_compra($year);
                    }

                 /*$data['detalle']   = $this->modelogeneral->getDetalleCompra($id_compra);
                 $data['compra']    = $this->modelogeneral->getdatosCompra($id_compra);     
                 $this->load->view("layout/header",$data);
                 $this->load->view("layout/side_menu",$data);
                 $this->load->view("emprendedor/compra_completada",$data);
                 $this->load->view("layout/footer"); */
                 $this->comprar($id_compra); 

            }else{
                    $this->carrito();
                 
                 }
        }                   
  
  } 


   function verficar_monto() {
    if ($_POST['sub_total'] >= 1000){
        return true;
       }else{
        $this->form_validation->set_message('verficar_monto', 'Por Favor debe comprar un monto mayor a 10000');
        return false;
        }
    }

 public function verficar_cantidad($str)
        {
                if ($_POST['cantidades'] == 0)
                {
                        $this->form_validation->set_message('verficar_cantidad', 'Por Favor debe colocar una cantidad  mayor a 0');
                        return FALSE;
                }
                else
                {
                        return TRUE;
                }
        }     
     

protected function save_detalleCompra($productos,$id_compra,$precio_comp,$cantidades,$importes){ 
        for ($i=0; $i < count($productos); $i++) { 
           
                $data  = array(
                    'id_producto'   => $productos[$i], 
                    'id_compra'     => $id_compra,
                    'precio_comp'   => $precio_comp[$i],
                    'cantidad_comp' => $cantidades[$i], 
                    'importe'       => $importes[$i]
                );  
            //$this->updateAlmacen_clientesResta($dato_alcli);        
            $this->modelogeneral->save_detalleCompra($data);
        
        }
}  

public function mis_compras()
    {
      if ($this->session->userdata('perfil') == false || $this->session->userdata('perfil') != 'emprendedor') {
            redirect(base_url() . 'login');
        }   
     $id_emp                 = $this->session->userdata('id_emp');
     $data['cant_asoc']      = $this->modelogeneral->rowCountAsoc($id_emp);
     $data['result']         = $this->modelogeneral->mostrar_carrito($id_emp);
     $data['datos_emp']      = $this->modelogeneral->datos_emp($id_emp);
     $data['ultimo_reg']     = $this->modelogeneral->las_insetCap(); 
     $data['cantidadVideos'] = $this->modelogeneral->rowCount("capacitacion"); 
     $data['cantidad_prod']  = $this->modelogeneral->count_cantProdCar($id_emp);
        
     $this->load->view("layout/header",$data);
     $this->load->view("layout/side_menu",$data);
     $this->load->view("emprendedor/mis_compras",$data);
     $this->load->view("layout/footer"); 
    } 

 function load_misCompras()
    {
       $id_emp  = $this->session->userdata('id_emp');
        $result = $this->modelogeneral->lista_compra($id_emp);
        
        $output = '';
        if(!empty($result))
        {
          foreach($result as $row)
            {
             $output .= '<tr>
                         
                         <td><span class="">'.$row->fecha.'</span></td>
                         <td><span class="">'.$row->no_compra.'</span></td>
                         <td><span class="">'.$row->total_comp.'</span></td>
                         <td><button type="button" class="btn btn-info view-detalle-compra" data-toggle="modal" data-target="#detalleModal" data="'.$row->id_compra.'" class="btn-outline btn-circle btn-lg m-r-5"><i class="ti-eye"></i></button>
                        </tr>';
            }
        }
    
        echo $output;
    }

function load_detalleCarrito()
    {
       $id_emp  = $this->session->userdata('id_emp');
        $result = $this->modelogeneral->mostrar_detallecarrito($id_emp);
        $cantidad_prod = $this->modelogeneral->count_cantProdCar($id_emp);
        

        
        $output = '';
        if(!empty($result))
        {
          $output = '<div class="drop-title">'.$cantidad_prod.' Productos</div>';
          foreach($result as $row)
            {
             $output .= '<li>
                            <div class="message-center">
                                <a>
                                    <div class="user-img"> <img src="'.base_url().'assets/uploads/img_productos/'.$row->url_imagen.'" alt="producto" class="img-circle"> <span class="profile-status online pull-right"></span> </div>
                                    <div class="mail-contnet">
                                        <h5>'.$row->nombre_prod.'</h5> <span class="mail-desc">'.$row->precio_car.' X $'.$row->cantidad.'</span> </div>
                                </a>
                            </div>
                        </li>';
                            
            }

            $output .= '<li>
                          <a class="text-center" href="'.base_url().'capacitacion/carrito"> <strong>Ver Cesta </strong> <i class="fa fa-angle-right"></i> </a>
                            </li>';
        }
    
        echo $output;
    }    



    /*

  <li>
                               
    */ 

 public function mi_cartera()
    {
      if ($this->session->userdata('perfil') == false || $this->session->userdata('perfil') != 'emprendedor') {
            redirect(base_url() . 'login');
        }   
     $id_emp                 = $this->session->userdata('id_emp');
     $data['cant_asoc']      = $this->modelogeneral->rowCountAsoc($id_emp);
     $data['result']         = $this->modelogeneral->mostrar_carrito($id_emp);
     $data['datos_emp']      = $this->modelogeneral->datos_emp($id_emp);
     $data['ultimo_reg']     = $this->modelogeneral->las_insetCap(); 
     $data['cantidadVideos'] = $this->modelogeneral->rowCount("capacitacion");
     $data['cantidad_prod']  = $this->modelogeneral->count_cantProdCar($id_emp); 
        
     $this->load->view("layout/header",$data);
     $this->load->view("layout/side_menu",$data);
     $this->load->view("emprendedor/mi_cartera",$data);
     $this->load->view("layout/footer"); 
    }

 function load_miCartera()
    {
       $id_emp  = $this->session->userdata('id_emp');
        $result = $this->modelogeneral->lista_miCartera($id_emp);
        
        $output = '';
        if(!empty($result))
        {
          foreach($result as $row)
            {
             $output .= '<tr>
                         
                         <td><span class="">'.$row->fecha.'</span></td>
                         <td><span class="">'.$row->no_compra.'</span></td>
                         <td><span class="">'.$row->gasto_cartera.'</span></td>
                         <td><span class="">'.$row->saldo.'</span></td>
                        </tr>';
            }
        }
    
        echo $output;
    }  
   


     public function view_detalleCompra(){

        $id = $this->input->post("id");
        $data = array(
            "result" => $this->modelogeneral->getDetalleCompra($id),
            "total" => $this->modelogeneral->get_sumatoriaCompra($id)
            
            
        );
        //var_dump($data['total']);
        $this->load->view("emprendedor/detalle_compra",$data);
    }





  

     public function Myperfil()
    {
      if ($this->session->userdata('perfil') == false || $this->session->userdata('perfil') != 'emprendedor') {
            redirect(base_url() . 'login');
        }   
     $id_emp = $this->session->userdata('id_emp');
     $data['cant_asoc']      = $this->modelogeneral->rowCountAsoc($id_emp);
     $data['datos_emp']      = $this->modelogeneral->datos_emp($id_emp);
     $data['ultimo_reg']     = $this->modelogeneral->las_insetCap(); 
     $data['cantidadVideos'] = $this->modelogeneral->rowCount("capacitacion");
     $data['cantidad_prod']  = $this->modelogeneral->count_cantProdCar($id_emp);

    
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
     $data['cant_asoc']      = $this->modelogeneral->rowCountAsoc($id_emp);
     $data['datos_emp']      = $this->modelogeneral->datos_emp($id_emp);
     $data['cantidad_prod']  = $this->modelogeneral->count_cantProdCar($id_emp);          
     
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
     $data['cant_asoc']      = $this->modelogeneral->rowCountAsoc($id_emp);
     $data['datos_emp']      = $this->modelogeneral->datos_emp($id_emp);
     $data['ultimo_reg']     = $this->modelogeneral->las_insetCap(); 
     $data['cantidadVideos'] = $this->modelogeneral->rowCount("capacitacion");
     $data['cantidad_prod']  = $this->modelogeneral->count_cantProdCar($id_emp);
              
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
        $result             = $this->modelogeneral->update_prodCar($param);
        $msg['comprobador'] = false;
        if($result)
             {
               $msg['comprobador'] = TRUE;
             }
        echo json_encode($msg);
    }

     public function prueba()
    {
       
       echo  $param['id_car']    = $this->input->post('id_car');
       
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
