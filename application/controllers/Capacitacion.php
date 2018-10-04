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
     $data['list_cap']   = $this->modelogeneral->listar_data_cap(); 
    
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
  /*-------------------------*/
    public function almacen()
    {
      if ($this->session->userdata('perfil') == false || $this->session->userdata('perfil') != 'emprendedor') {
            redirect(base_url() . 'login');
        } 

     $id_emp                 = $this->session->userdata('id_emp');
     $data['productos']      = $this->modelogeneral->listar_productos();
     $data['provincias']     = $this->modelogeneral->select_provincias();  
     $data['cant_asoc']      = $this->modelogeneral->rowCountAsoc($id_emp);
     $data['datos_emp']      = $this->modelogeneral->datos_emp($id_emp); 
     $data['ultimo_reg']     = $this->modelogeneral->las_insetCap(); 
     $data['cantidadVideos'] = $this->modelogeneral->rowCount("capacitacion");
     $data['cantidad_prod']  = $this->modelogeneral->count_cantProdCar($id_emp);
 
     $this->load->view("layout/header",$data);
     $this->load->view("layout/side_menu",$data);
     $this->load->view("emprendedor/almacen",$data);
     $this->load->view("layout/footer");  
    }

    

    function load_dataAlmacen()
    {
       if ($this->session->userdata('perfil') == false || $this->session->userdata('perfil') != 'emprendedor') {
            redirect(base_url() . 'login');
        } 
        $id_emp                 = $this->session->userdata('id_emp');
        $result = $this->modelogeneral->listar_datosAlmacen($id_emp);
        $output = '';
        if(!empty($result))
        {
          foreach($result as $row)
            {
              $output .= ' <tr>
                         <td>'.$row->nombre_prod.'</td>
                         <td>'.$row->sku.'</td>
                         <td><input type="text" name="exitencia[]" id="exitencia_'.$row->id_almacen.'" value="'.$row->existencia.'" required>
                         <i id="capa_stock'.$row->id_almacen.'"></i></td>
                         <td>
                              <button type="button" data="'.$row->id_almacen.'" class="btn btn-danger btn-outline btn-circle  m-r-5 deletecap-row-btn"  data-toggle="tooltip" data-original-title="Eliminar" title ="Eliminar"><i class="icon-trash"></i></button>
                              </td>
                            
                         </tr>';                                        
            }
        }
    
        echo $output;
    }

       public function eliminar_prodAlm()
    {
        $id = $this->input->get('id');
        $result  = $this->modelogeneral->eliminar_prodAlm($id);
        $msg['comprobador'] = false;
        if($result)
             {
               $msg['comprobador'] = TRUE;
             }
        echo json_encode($msg);
    }


      public function updateTable()
    {

        $id_emp      = $this->session->userdata('id_emp');
        $id_producto = $_GET['id_producto'];
        $valor       = $_GET['valor'];

        $param = array('id_almacen' => $id_producto,'existencia' => $valor, 'id_emp'=> $id_emp);
        $result =  $this->modelogeneral->update_tablaAlmacen($param);

      $msg['success'] = false;
       if($result){
        $msg['success'] = true;
      }
      echo json_encode($param);

      
  }
    /*-------------------------------*/
    public function ventas()
    {
      if ($this->session->userdata('perfil') == false || $this->session->userdata('perfil') != 'emprendedor') {
            redirect(base_url() . 'login');
        } 

     $id_emp             = $this->session->userdata('id_emp');
     $data['categorias']  = $this->modelogeneral->selec_categorias_prod();

     $data['provincias']     = $this->modelogeneral->select_provincias();  
     $data['cant_asoc']      = $this->modelogeneral->rowCountAsoc($id_emp);
     $data['datos_emp']      = $this->modelogeneral->datos_emp($id_emp); 
     $data['ultimo_reg']     = $this->modelogeneral->las_insetCap(); 
     $data['cantidadVideos'] = $this->modelogeneral->rowCount("capacitacion");
     $data['cantidad_prod']  = $this->modelogeneral->count_cantProdCar($id_emp);
 
     $this->load->view("layout/header",$data);
     $this->load->view("layout/side_menu",$data);
     $this->load->view("emprendedor/ventas",$data);
     $this->load->view("layout/footer");  
    }

    public function vencimientos()
    {
      if ($this->session->userdata('perfil') == false || $this->session->userdata('perfil') != 'emprendedor') {
            redirect(base_url() . 'login');
        } 

     $id_emp             = $this->session->userdata('id_emp');
     $data['categorias']  = $this->modelogeneral->selec_categorias_prod();

     $data['provincias']     = $this->modelogeneral->select_provincias();  
     $data['cant_asoc']      = $this->modelogeneral->rowCountAsoc($id_emp);
     $data['datos_emp']      = $this->modelogeneral->datos_emp($id_emp); 
     $data['ultimo_reg']     = $this->modelogeneral->las_insetCap(); 
     $data['cantidadVideos'] = $this->modelogeneral->rowCount("capacitacion");
     $data['cantidad_prod']  = $this->modelogeneral->count_cantProdCar($id_emp);
 
     $this->load->view("layout/header",$data);
     $this->load->view("layout/side_menu",$data);
     $this->load->view("emprendedor/vencimientos",$data);
     $this->load->view("layout/footer");  
    }

    

    
    public function productos_almacen()
    {
       if ($this->session->userdata('perfil') == false || $this->session->userdata('perfil') != 'emprendedor') {
           redirect(base_url() . 'login');
       }
       
        $data['id_categoria']  = $this->input->post('id');
        $data['id_emp']      = $this->session->userdata('id_emp');
        $resultado = $this->modelogeneral->productos_almacen($data);
        $mostarprod ="";
        if(!empty($resultado))
        {
            $mostarprod .='<option value="">Seleccione</option>';
            foreach($resultado as $row):
              $mostarprod .='<option value="'.$row->id_producto.'*'.$row->existencia.'">'.$row->nombre_prod.'</option>';
            endforeach ; 
        } 
        echo $mostarprod;
    }

    /*-------------------------------*/
 
    public function datos_cliente()
    {
       if ($this->session->userdata('perfil') == false || $this->session->userdata('perfil') != 'emprendedor') {
           redirect(base_url() . 'login');
       }
        $id_cliente = $this->input->get('id');
        $resultado = $this->modelogeneral->datos_cliente($id_cliente);
        echo json_encode($resultado);
    }


    public function historial_cliente($id_cliente)
    {
      if ($this->session->userdata('perfil') == false || $this->session->userdata('perfil') != 'emprendedor') {
            redirect(base_url() . 'login');
        } 

   
     $id_emp                 = $this->session->userdata('id_emp');
     $data['provincias']     = $this->modelogeneral->select_provincias();  
     $data['cant_asoc']      = $this->modelogeneral->rowCountAsoc($id_emp);
     $data['datos_emp']      = $this->modelogeneral->datos_emp($id_emp); 
     $data['ultimo_reg']     = $this->modelogeneral->las_insetCap(); 
     $data['cantidadVideos'] = $this->modelogeneral->rowCount("capacitacion");
     $data['cantidad_prod']  = $this->modelogeneral->count_cantProdCar($id_emp);
     $data['datos_cliente']  = $this->modelogeneral->datos_cliente($id_cliente);  
     
 
     $this->load->view("layout/header",$data);
     $this->load->view("layout/side_menu",$data);
     $this->load->view("emprendedor/ficha_cliente",$data);
     $this->load->view("layout/footer");  
    }

    function load_dataClientes()
    {
       $id_emp                 = $this->session->userdata('id_emp');
        $result = $this->modelogeneral->listar_clientes($id_emp);
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

    function load_dataClientesVentas()
    {
        $id_emp = $this->session->userdata('id_emp');
        $result = $this->modelogeneral->listar_clientes($id_emp);
        $output = '';
        if(!empty($result))
        {
          foreach($result as $row)
            {
              $output .= ' <tr>
                         <td>
                         <button type="button" data="'.$row->id_cliente.'" class="btn btn-success btn-outline btn-circle btn-sm btn-check"><i class="fa  fa-check"></i></button>
                          </td>   
                         <td>'.$row->dni.'</td>
                         <td>'.$row->nombre_cliente.' '.$row->apellidos.' </td>
                         <td>'.$row->telefono.'</td>
                         <td>'.$row->celular.'</td>
                         <td>'.$row->email.'</td>
                         
                         </tr>';                                        
            }
        }
    
        echo $output;
    }

      function load_data_vencimientos()
    {
        $fecha_vencimiento = date('Y-m-d');
        $id_respuesto_hijo  = 2; 
        $respuestos_v = array('id_respuesto_hijo' =>$id_respuesto_hijo ,'fecha_vencimiento' => $fecha_vencimiento  );

        $result = $this->modelogeneral->buscarProdVencidos($respuestos_v);
        $count = 0;
        $output = '';
        if(!empty($result))
        {
          foreach($result as $row)
            {
              $output .= ' <tr>
                          <td>'.$row->nombre_prod.'</td>
                          <td>'.$row->fecha_vencimiento.' </td>
                          <td> </td>
                          <td><input type="text" name="" value="" id=""> </td>
                          <td><input type="text" name="" value="" id=""> </td>
                          <td></td>
                          <td><button type="button" data="" class="btn btn-success btn-outline btn-circle btn-sm btn-check"><i class="fa  fa-check"></i></button> </td>
                         </tr>';                                        
            }
        }
    
        echo $output;
    }

    function vencimientosRepuestosCli()
    {
        $id_cliente = $this->input->post('id');
        $respuestos_vencicli = array('id_cliente' => $id_cliente );
        $result = $this->modelogeneral->repustosVencidos_cliente($respuestos_vencicli);
        $output = '';
        if(!empty($result))
        {
          foreach($result as $row)
             {
               

              $output .= '<tr>
                          <td>'.$row->nombre_prod.'</td>
                          <td>'.$row->fecha_solicitud.'</td>
                          <td>'.$row->vencimiento.'</td>
                          <td>'.$row->fecha_vencimiento.'</td>
                          <td><span class="label label-warning">Vencido</span></td>
                         </tr>';                                        
            }
        }
    
        echo $output;
    }



     function lista_vencimientos()
    {
        $fecha_vencimiento = date('Y-m-d');
        $id_respuesto_hijo  = 2; 
        $respuestos_v = array('id_respuesto_hijo' =>$id_respuesto_hijo ,'fecha_vencimiento' => $fecha_vencimiento  );

        $result = $this->modelogeneral->buscarProdVencidos($respuestos_v);
        $count = 0;
        $output = '';
        if(!empty($result))
        {
          foreach($result as $row)
            {
              $output .= ' <tr>
                          <td>Marianela </td>
                          <td>'.$row->nombre_prod.'</td>
                          <td>'.$row->fecha_vencimiento.' </td>
                          <td><input type="text" name="" value="" id=""> </td>
                          <td><button type="button" data="" class="btn btn-success btn-outline btn-circle btn-sm btn-check"><i class="fa  fa-check"></i></button> </td>
                         </tr>';                                        
            }
        }
    
        echo $output;
    }


     function clientes_vencimiento()
    {
        
         $id_emp  = $this->session->userdata('id_emp');
        
        $result = $this->modelogeneral->clientes_vencimiento($id_emp);
        $count = 0;
        $output = '';
        if(!empty($result))
        {
          foreach($result as $row)
            {
              $output .= ' <tr>
                          <td>'.$row->nombre_cliente.'</td>
                          <td>'.$row->nombre_prod.' </td>
                          <td>'.$row->fecha_vencimiento.' </td>
                          <td><button type="button" data="'.$row->id_cliente.'" class="btn btn-success btn-outline btn-circle btn-sm btn-select-cli"><i class="fa  fa-check"></i></button> </td>
                         </tr>';                                        
            }
        }
    
        echo $output;
    }

      function Seccion_clientes_venc()
    {
        
        $id_emp     = $this->session->userdata('id_emp');
        $id_cliente = $this->input->post('id');    
        $data = array('id_emp' =>$id_emp,'id_cliente' => $id_cliente);
        $result = $this->modelogeneral->Seccion_clientes_venc($data);

        $output = '';
        if(!empty($result))
        {
          foreach($result as $row)
            {

               $array = array('id_emp' =>$id_emp,'id_producto' => $row->id_producto);
               $existencia = $this->modelogeneral->dame_existencia($array);
               $output .= '<tr class="resingao'.$row->id_prod_vencimiento.'">
                          <td>'.$row->nombre_cliente.' </td> 
                          <td>'.$row->nombre_prod.' </td>
                          <td>'.$row->fecha_vencimiento.' </td>
                          <td><input type="text" name="resp_cantidades[]" value="" class="resp_cantidades" required data-parsley-minlength="1"> </td>
                          <td><input type="text" name="resp_precios[]" value=""  class="resp_precios" required data-parsley-minlength="1"> </td>
                          <td><input type="hidden" name="resp_importes[]" value=" "><p></p></td>

                          <td><input type="hidden" name="reposicion" value="1" id=""><button type="button" data="'.$row->id_prod_vencimiento.'*'.$row->id_producto.'*'.$row->nombre_prod.'*'.$existencia->existencia.'*'.$row->id_cliente.'" class="btn btn-success btn-outline btn-circle btn-sm btn-add-car"><i class="fa  fa-check"></i></button> </td>
                           
                         </tr>';                                        
            }
        }
    
        echo $output;
    }

    

     function lista_vencimientoSugeridos()
    {
        $fecha_vencimiento = date('Y-m-d');
        $respuestos_v = array('fecha_vencimiento' => $fecha_vencimiento );

        $result = $this->modelogeneral->buscarRespuestosVencidos($respuestos_v);
        $count = 0;
        $output = '';
        if(!empty($result))
        {
          foreach($result as $row)
            {
              $output .= ' <tr>
                          <td>Marianela </td>
                          <td>'.$row->nombre_prod.'</td>
                          <td>'.$row->fecha_vencimiento.' </td>
                          <td><input type="text" name="" value="" id=""> </td>
                          <td><button type="button" data="" class="btn btn-success btn-outline btn-circle btn-sm btn-check"><i class="fa  fa-check"></i></button> </td>
                         </tr>';                                        
            }
        }
    
        echo $output;
    }

     //venta de reposiciones 

     public function add_reposicion()
    {
         if ($this->session->userdata('perfil') == false || $this->session->userdata('perfil') != 'emprendedor') {
            redirect(base_url() . 'login');
        } 

        $param['id_emp']            = $this->session->userdata('id_emp');

        // productos en resposicion
         $param['rep_productos']   = $this->input->post('rep_productos');
        
         $param['rep_idproductos'] = $this->input->post('rep_idproductos');
         $param['rep_cantidades']  = $this->input->post('rep_cantidades');
         $param['rep_precios']     = $this->input->post('rep_precios');
         $param['rep_importes']    = $this->input->post('rep_importes');

         //nuevos pedidos
         $data['productos']       = $this->input->post('productos');
         $data['cantidad']        = $this->input->post('cantidades');
         $data['precios']         = $this->input->post('precios');
         $data['importe']         = $this->input->post('importes');
         $data['id_cliente']      = $this->input->post('id_cliente');

         //logica productos en resposicion
         $this->save_detalleReposicion($param);
         //guardo el pedido
         $data_pedidos['id_emp']          = $this->session->userdata('id_emp');
         $data_pedidos['id_cliente']      = $this->input->post('id_cliente');
         $data_pedidos['no_pedido']       =  $this->modelogeneral->getComprobante();
         $data_pedidos['fecha_solicitud'] =  date('Y-m-d');
         $data_pedidos['total']           = $this->input->post('total');

         if($this->modelogeneral->save_Pedido($data_pedidos)){

                 $data['id_pedidos']   =  $this->modelogeneral->lastID();                  

                 $repo_detalle = array('productos' => $param['rep_idproductos'],
                                       'cantidad'  => $param['rep_cantidades'],
                                       'precios'   => $param['rep_precios'],
                                       'importe'   => $param['rep_importes'],
                                       'id_emp'    => $param['id_emp']);
                 
                 $repo_detalle['id_pedidos']  =  $data['id_pedidos'];
                 $repo_detalle['id_cliente']  =  $this->input->post('id_cliente');

                 //guardar_detalle_pedido
                 $this->save_detallePedidoConfirmado($data);
                 $this->save_detallePedidoConfirmado($repo_detalle);               
                 $msg['comprobador'] = TRUE;
               } 
         

        echo json_encode($msg);        
        
    }

    protected function save_detalleReposicion($param){ 
    for ($i=0; $i < count($param['rep_productos']); $i++){ 
          
          $dato_repo = array(
              'id_prod_vencimiento'   => $param['rep_productos'][$i]

          );

          $data = $this->modelogeneral->actualizar_vencimientos($dato_repo);
          
          $rep_cantidades  = $param['rep_cantidades'][$i];
          $meses = $data->vencimiento * $rep_cantidades;
          $fecha_inicial = $data->fecha_vencimiento;
          $fecha_final = date("Y-m-d", strtotime("$fecha_inicial + $meses month"));

          $dato_repo['fecha_vencimiento'] = $fecha_final;
          $this->modelogeneral->update_venc($dato_repo);
        }
    }


    public function add_pedido()
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
        $param['fecha_incio']       =  date('Y-m-d'); //$this->input->post('fecha_incio');
        $param['id_municipio']      = $this->input->post('id_municipio');
        $param['id_provincia']      = $this->input->post('id_provincia');
        $datos_emp                  = $this->modelogeneral->datos_emp($param['id_emp']);
        $param['id_pais']           = $datos_emp->id_pais;
       
        
        $exite_dni   = $this->modelogeneral->check_cliente('dni',$param['dni']);
        $exite_email = $this->modelogeneral->check_cliente('email',$param['email']);
        $msg['comprobador'] = false;    
       
        if ($exite_dni == true || $exite_email==true){
            if ($exite_dni) {
                $id_cliente = $this->modelogeneral->buscar_dnicli($param['dni']);
                $data['id_cliente'] = $id_cliente->id_cliente;  
            } else {
                $id_cliente = $this->modelogeneral->buscar_emailcli($param['email']); 
                $data['id_cliente'] = $id_cliente->id_cliente;
            }
        } else {

               $this->modelogeneral->insert_cliente($param);
               $data['id_cliente']     =  $this->modelogeneral->lastID();
               
              }

               $data['id_emp']          = $this->session->userdata('id_emp');
               $data['no_pedido']       =  $this->modelogeneral->getComprobante();
               $data['fecha_solicitud'] =  date('Y-m-d');
               $data['total']           = $this->input->post('total');
              
               if($this->modelogeneral->save_Pedido($data)){


                 $data['id_pedidos']      =  $this->modelogeneral->lastID();
                 $data['productos']       = $this->input->post('productos');
                 $data['cantidad']        = $this->input->post('cantidades');
                 $data['precios']         = $this->input->post('precios');
                 $data['importe']         = $this->input->post('importes');

                 $test = array();
                 $test = $this->save_detallePedidoConfirmado($data);
                 
               
                 $msg['comprobador'] = TRUE;
               }      
            

        echo json_encode($msg);
    }

    protected function save_detallePedidoConfirmado($data){ 
    for ($i=0; $i < count($data['productos']); $i++) { 
      
          $dato_pedido = array(
              'id_producto'   => $data['productos'][$i], 
              'id_pedidos'    => $data['id_pedidos'],
              'precio_pedido' => $data['precios'][$i], 
              'cantidad'      => $data['cantidad'][$i],
              'importe'       => $data['importe'][$i] 
          );  

         // $test = array();
         // $test['total'] =  count($data['productos']); 
             
            
            //$dato['id_emp'] = $this->session->userdata('id_emp');
            //$this->modelogeneral->resto_almacen($dato);
            
            //pregunto si el producto es repuesto no
            $infoProducto =  $this->modelogeneral->datos_productos($data['productos'][$i]);

            if ($infoProducto->es_repuesto == 0) {
                 
                 $test[$i] =  "es producto"; 
                 // buscamos los respuestos dado el producto
                 $result =  $this->modelogeneral->datos_respuestoPadre($data['productos'][$i]);

                 $arrayVencimientos = [];

                 //inserto en la tabla producto_vencimiento el vencimiento de cada respuesto
                 $rep_cantidades  = $data['cantidad'][$i];
                 $infoRespuesto =  $this->modelogeneral->datos_productos($result->id_respuesto_hijo);                     
                 $meses =  $infoRespuesto->vencimiento * $rep_cantidades;
                 $fecha_actual =  date('Y-m-d');
                 $fecha_final = date("Y-m-d", strtotime("$fecha_actual + $meses month"));                     
                 $venc_resp = array('fecha_vencimiento' => $fecha_final,
                                   'id_cliente' => $data['id_cliente'] ,
                                   'id_respuesto' => $result->id_respuesto_hijo);
                 $this->modelogeneral->insertverfi_vencimiento($venc_resp);
                 $id_prod_vencimiento  =  $this->modelogeneral->lastID();
                 
                 //$arrayVencimientos[] = $id_prod_vencimiento;
                
                 /*foreach ($result as $key):
                    //inserto en la tabla producto_vencimiento el vencimiento de cada respuesto
                         $rep_cantidades  = $data['cantidad'][$i];
                         $infoRespuesto =  $this->modelogeneral->datos_productos($key->id_respuesto_hijo);                     
                         $meses =  $infoRespuesto->vencimiento * $rep_cantidades;
                         $fecha_actual =  date('Y-m-d');
                         $fecha_final = date("Y-m-d", strtotime("$fecha_actual + $meses month"));                     
                         $venc_resp = array('fecha_vencimiento' => $fecha_final,
                                           'id_cliente' => $data['id_cliente'] ,
                                           'id_respuesto' => $key->id_respuesto_hijo);
                         $this->modelogeneral->insertverfi_vencimiento($venc_resp);
                         $id_prod_vencimiento  =  $this->modelogeneral->lastID();
                         $arrayVencimientos[] = $id_prod_vencimiento;
                  endforeach;*/

                     //inserto el respuesto del producto comprado
                     $prod_cliente = array('fecha_compra' => date('Y-m-d'),
                                           'id_producto'   => $data['productos'][$i],
                                           'id_cliente'    =>  $data['id_cliente']);
                     $this->modelogeneral->insert_prod_cliente($prod_cliente);
                     $id_prod_cli  =  $this->modelogeneral->lastID();
                     
                     //Guardo el registro de producto con repuesto del cliente
                     $prod_cli_venc = array('id_prod_vencimiento' => $id_prod_vencimiento,
                                            'id_prod_cli'         => $id_prod_cli);
                     $this->modelogeneral->insert_prod_cli_venc($prod_cli_venc);

                     /*for ($i=0; $i < count($arrayVencimientos) ; $i++) { 
                        $prod_cli_venc = array('id_prod_vencimiento' => $arrayVencimientos[$i],
                                               'id_prod_cli'         => $id_prod_cli);
                        $this->modelogeneral->insert_prod_cli_venc($prod_cli_venc);                      
                     }*/
                            
             } else {
                       //caso 1
                        $verif_resp =  $this->modelogeneral->verificador_vencimiento($data['id_cliente'],$data['productos'][$i]);
                        if ($verif_resp != NULL) {
                            $rep_cantidades  = $data['cantidad'][$i]; 
                            $dato_venc = $this->modelogeneral->buscar_prod($data['productos'][$i]);
                            $meses = $dato_venc->vencimiento * $rep_cantidades;
                            $fecha_actual =  $verif_resp->fecha_vencimiento;
                            $fecha_final = date("Y-m-d", strtotime("$fecha_actual + $meses month")); 

                            $datos_actvenc =  array('id_cliente' => $data['id_cliente'] ,
                                                   'id_producto' => $data['productos'][$i],
                                                    'fecha_vencimiento' =>$fecha_final);
                            $this->modelogeneral->updateverfi_vencimiento($datos_actvenc);                
                        } else {
                            $prod_padre =  $this->modelogeneral->datos_respuestoHijo($data['productos'][$i]);

                            $id_producto = $prod_padre->id_producto;

                            $prod_cliente = array('fecha_compra'   => date('Y-m-d'),
                                                   'id_producto'   => $id_producto,
                                                   'id_cliente'    =>  $data['id_cliente']);

                            $this->modelogeneral->insert_prod_cliente($prod_cliente);
                            $id_prod_cli  =  $this->modelogeneral->lastID();


                            $dato_venc = $this->modelogeneral->buscar_prod($data['productos'][$i]);
                            $rep_cantidades  = $data['cantidad'][$i];
                            $meses = $dato_venc->vencimiento * $rep_cantidades;
                            $fecha_actual =  date('Y-m-d');
                            $fecha_final = date("Y-m-d", strtotime("$fecha_actual + $meses month"));
                            $venc_resp = array('fecha_vencimiento' => $fecha_final,
                                                'id_cliente' => $data['id_cliente'] ,
                                                'id_respuesto' => $data['productos'][$i]);
                            $this->modelogeneral->insertverfi_vencimiento($venc_resp);
                            $id_prod_vencimiento  =  $this->modelogeneral->lastID();

                            $prod_cli_venc = array('id_prod_vencimiento' => $id_prod_vencimiento,
                                                    'id_prod_cli'         => $id_prod_cli);
                            $this->modelogeneral->insert_prod_cli_venc($prod_cli_venc);
                           
                        }                
                    }

        $this->modelogeneral->save_detallePedido($dato_pedido);            
    }
   // return $test;
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

      function listado_DetallepedidosCli()
    {
        $id_cliente         = $this->input->post('id');
        $result = $this->modelogeneral->listado_DetallepedidosCli($id_cliente);
        $output = '';
        if(!empty($result))
        {
          foreach($result as $row)
            {

             $meses =  $row->vencimiento * $row->cantidad;
             $fecha_actual =  $row->fecha_solicitud;
             $fecha_final = date("Y-m-d", strtotime("$fecha_actual + $meses month"));  
                
              $output .= '<tr>
                          <td>'.$row->no_pedido.'</td>
                          <td>'.$row->nombre_prod.'</td>
                          <td>'.$row->total.'</td>
                          <td>'.$row->fecha_solicitud.'</td>
                          <td>'.$fecha_final.'</td>
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

          $infoProducto =  $this->modelogeneral->datos_productos($data['productos'][$i]);

            if ($infoProducto->es_repuesto == 0) {                 
                 
                 // buscamos los respuestos dado el producto
                 $result =  $this->modelogeneral->datos_respuestoPadre($data['productos'][$i]);

                 //$arrayVencimientos = [];

                 //inserto en la tabla producto_vencimiento el vencimiento de cada respuesto
                 $rep_cantidades  = $data['cantidad'][$i];
                 $infoRespuesto =  $this->modelogeneral->datos_productos($result->id_respuesto_hijo);                     
                 $meses =  $infoRespuesto->vencimiento * $rep_cantidades;
                 $fecha_actual =  $data['fecha_solicitud'];
                 $fecha_final = date("Y-m-d", strtotime("$fecha_actual + $meses month"));                     
                 $venc_resp = array('fecha_vencimiento' => $fecha_final,
                                   'id_cliente' => $data['id_cliente'] ,
                                   'id_respuesto' => $result->id_respuesto_hijo);
                 $this->modelogeneral->insertverfi_vencimiento($venc_resp);
                 $id_prod_vencimiento  =  $this->modelogeneral->lastID();
                 
                 //$arrayVencimientos[] = $id_prod_vencimiento;
                
                 /*foreach ($result as $key):
                    //inserto en la tabla producto_vencimiento el vencimiento de cada respuesto
                         $rep_cantidades  = $data['cantidad'][$i];
                         $infoRespuesto =  $this->modelogeneral->datos_productos($key->id_respuesto_hijo);                     
                         $meses =  $infoRespuesto->vencimiento * $rep_cantidades;
                         $fecha_actual =  date('Y-m-d');
                         $fecha_final = date("Y-m-d", strtotime("$fecha_actual + $meses month"));                     
                         $venc_resp = array('fecha_vencimiento' => $fecha_final,
                                           'id_cliente' => $data['id_cliente'] ,
                                           'id_respuesto' => $key->id_respuesto_hijo);
                         $this->modelogeneral->insertverfi_vencimiento($venc_resp);
                         $id_prod_vencimiento  =  $this->modelogeneral->lastID();
                         $arrayVencimientos[] = $id_prod_vencimiento;
                  endforeach;*/

                     //inserto el respuesto del producto comprado
                     $prod_cliente = array('fecha_compra' => date('Y-m-d'),
                                           'id_producto'   => $data['productos'][$i],
                                           'id_cliente'    =>  $data['id_cliente']);
                     $this->modelogeneral->insert_prod_cliente($prod_cliente);
                     $id_prod_cli  =  $this->modelogeneral->lastID();
                     
                     //Guardo el registro de producto con repuesto del cliente
                     $prod_cli_venc = array('id_prod_vencimiento' => $id_prod_vencimiento,
                                            'id_prod_cli'         => $id_prod_cli);
                     $this->modelogeneral->insert_prod_cli_venc($prod_cli_venc);

                     /*for ($i=0; $i < count($arrayVencimientos) ; $i++) { 
                        $prod_cli_venc = array('id_prod_vencimiento' => $arrayVencimientos[$i],
                                               'id_prod_cli'         => $id_prod_cli);
                        $this->modelogeneral->insert_prod_cli_venc($prod_cli_venc);                      
                     }*/
                            
             } else {
                       //caso 1
                        $verif_resp =  $this->modelogeneral->verificador_vencimiento($data['id_cliente'],$data['productos'][$i]);
                        if ($verif_resp != NULL) {
                            $rep_cantidades  = $data['cantidad'][$i]; 
                            $dato_venc = $this->modelogeneral->buscar_prod($data['productos'][$i]);
                            $meses = $dato_venc->vencimiento * $rep_cantidades;
                            $fecha_actual =  $verif_resp->fecha_vencimiento;
                            $fecha_final = date("Y-m-d", strtotime("$fecha_actual + $meses month")); 

                            $datos_actvenc =  array('id_cliente' => $data['id_cliente'] ,
                                                   'id_producto' => $data['productos'][$i],
                                                    'fecha_vencimiento' =>$fecha_final);
                            $this->modelogeneral->updateverfi_vencimiento($datos_actvenc);                
                        } else {
                            $prod_padre =  $this->modelogeneral->datos_respuestoHijo($data['productos'][$i]);

                            $id_producto = $prod_padre->id_producto;

                            $prod_cliente = array('fecha_compra'   => $data['fecha_solicitud'],
                                                   'id_producto'   => $id_producto,
                                                   'id_cliente'    =>  $data['id_cliente']);

                            $this->modelogeneral->insert_prod_cliente($prod_cliente);
                            $id_prod_cli  =  $this->modelogeneral->lastID();


                            $dato_venc = $this->modelogeneral->buscar_prod($data['productos'][$i]);
                            $rep_cantidades  = $data['cantidad'][$i];
                            $meses = $dato_venc->vencimiento * $rep_cantidades;
                            $fecha_actual =  $data['fecha_solicitud'];
                            $fecha_final = date("Y-m-d", strtotime("$fecha_actual + $meses month"));
                            $venc_resp = array('fecha_vencimiento' => $fecha_final,
                                                'id_cliente' => $data['id_cliente'] ,
                                                'id_respuesto' => $data['productos'][$i]);
                            $this->modelogeneral->insertverfi_vencimiento($venc_resp);
                            $id_prod_vencimiento  =  $this->modelogeneral->lastID();

                            $prod_cli_venc = array('id_prod_vencimiento' => $id_prod_vencimiento,
                                                    'id_prod_cli'         => $id_prod_cli);
                            $this->modelogeneral->insert_prod_cli_venc($prod_cli_venc);
                           
                        }                
                    }
        
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

                  redirect(base_url() ."capacitacion/comprar/".$id_compra);
                 

            }else{
                    $this->carrito();
                   // redirect(base_url() . "carrito");
                 
                 }

        }                   
  
  } 


   function verficar_monto() {
    $min = $this->modelogeneral->getValorMont_min();
    if ($_POST['sub_total'] >= $min->valor){
        return true;
       }else{
        $this->form_validation->set_message('verficar_monto', 'Por Favor debe comprar un monto mayor a '.$min->valor);
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
                          <a class="text-center" href="'.base_url().'capacitacion/carrito"> <strong>Ver Carrito </strong> <i class="fa fa-angle-right"></i> </a>
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
     $combos = $this->modelogeneral->listar_data_combos();
     
     $data   = array('productos' => $result,'combos' => $combos );
     
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
        $param['id_producto']     = $this->input->post('id_prod');
        $param['cantidad']        = $this->input->post('cantidad');

        $year                     = date('Y');
        $no_orden                 =  $this->modelogeneral->datos_prod($year);
        $param['no_orden']        = $no_orden + 1;
        $param['fecha_car']       = date('Y-m-d');
        $row['datos']             = $this->modelogeneral->datos_prod($param['id_producto']);
<<<<<<< HEAD
        $param['precio_car']      = $row['datos']->precio;
=======
        $param['precio_car']      = $this->input->post('precio');
>>>>>>> 9f2d7f1513c0855d5515d7b035f9d882e9e78949
        $param['importe']         = $param['precio_car'] * $param['cantidad'];
        $result = $this->modelogeneral->insert_toCar($param);
        $msg['comprobador'] = false;
        if($result)
             {
               $msg['comprobador'] = TRUE;
             }
        echo json_encode($msg);
       // redirect(base_url() . "ventas/add_salida_prodcliente");
    }


    public function insert_prodAlmacen()
    {
     if ($this->session->userdata('perfil') == false || $this->session->userdata('perfil') != 'emprendedor') {
            redirect(base_url() . 'login');
        }   
        $param['id_emp']          = $this->session->userdata('id_emp');
        $param['id_producto']     = $this->input->post('id_producto');
        $param['existencia']      = $this->input->post('existencia');
        
        $result = $this->modelogeneral->insert_prodAlmacen($param);
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
