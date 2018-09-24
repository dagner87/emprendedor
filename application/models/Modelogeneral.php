<?php
class Modelogeneral extends CI_Model {
  
  public function __construct() {
      parent::__construct();
      $this->load->database();
   }
   public function insert_emp($data)
  {
      $this->db->insert('emprendedor',$data);
      return $this->db->insert_id();
  }


  public function insert_emp_asoc($data)
  {
      $this->db->insert('emp_asoc',$data);
     if($this->db->affected_rows() > 0){
          return true;
        
        }else{
          return false;
        }
     
  }


  public function check_cliente($data)
  {
    $datos_cliente = $this->datos_cliente($data['id_cliente']);
    if ($datos_cliente) {
      
    }else{
         $this->insert_cliente($data);
        }
     
  }

  /*-----------crud clientes----------------*/

    public function insert_cliente($data)
  {
      $this->db->insert('cliente',$data);
     if($this->db->affected_rows() > 0){
          return true;
        
        }else{
          return false;
        }
  }

  public function listar_clientes()
  {
     $query = $this->db->get('cliente');
      if($query->num_rows() > 0){
        return $query->result();
      }else{
        return false;
      }
  }

   public function update_datosCliente($param)
  {
    $this->db->where('id_cliente',$param['id_cliente']);
    $this->db->update('cliente',$param);
   if($this->db->affected_rows() > 0){
      return true;
       }else{
             return true;
            }
     
  }

   public function listado_pedidosProd($id_pedido){
        $this->db->select('prod.nombre_prod');
        $this->db->where('de_pe.id_pedidos', $id_pedido);
        $this->db->join('productos as prod', 'prod.id_producto = de_pe.id_producto');
        $query = $this->db->get('detalle_pedido as de_pe');
        return $query->result();
       
    }

     public function listado_pedidos($id_cliente){
        $this->db->where('id_cliente', $id_cliente);
        $query = $this->db->get('pedidos');
        return $query->result();
       
    }

    public function listar_datosAlmacen($id_emp){
        $this->db->select('prod.nombre_prod,prod.sku,alm.existencia');
        $this->db->join('productos as prod', 'prod.id_producto = alm.id_producto');
        $this->db->where('alm.id_emp', $id_emp);
        $this->db->where('alm.existencia >',0);
        $query = $this->db->get('almacen_emp as alm');
        return $query->result();
       
    }

   public function datos_cliente($id_cliente) {
   $this->db->where('id_cliente',$id_cliente);
   $query = $this->db->get('cliente');
   return $query-> row();
  
   }


/*----------------------------------**/   

public function getComprobante(){
    $this->db->where("nombre",'no_pedido');
    $resultado = $this->db->get("tipo_comprobante");
    return $resultado->row();
  }   


public function save_Pedido($data){
    return $this->db->insert("pedidos",$data);
  }

  public function save_detallePedido($data){
    return $this->db->insert("detalle_pedido",$data);
  } 

   public function select_provincias()
  {
     $query = $this->db->get('provincias');
      if($query->num_rows() > 0){
        return $query->result();
      }else{
        return false;
      }
  }
    public function select_municipio($id_provincia)
  {
     $this->db->where('id_provincia',$id_provincia);
     $query = $this->db->get('municipios');
      if($query->num_rows() > 0){
        return $query->result();
      }else{
        return false;
      }
  }



  
   





  /* insertar videos */
   public function insert_cap($data)
  {
      $this->db->insert('capacitacion',$data);
     if($this->db->affected_rows() > 0){
          return true;
        
        }else{
          return false;
        }
     
  }

  

  /* insetar evaluacion **/
   public function udpate_evalcap($param)
  {
    $this->db->where('id_emp',$param['id_emp']);
    $this->db->where('id_cap',$param['id_cap']);
    $this->db->update('emp_cap',$param);
   if($this->db->affected_rows() > 0){
      return true;
       }else{
            $this->db->insert('emp_cap',$param);
             return true;
        }
     
  }

  

  /* insetar evaluacion **/
   public function udpate_emp($datos_upd)
  {
    $this->db->where('id_emp',$datos_upd['id_emp']);
    $this->db->update('emprendedor',$datos_upd);
    if($this->db->affected_rows() > 0){
      return true;
       }else{
         return false;
        }
  }

  /*----------tabla de comsiones--------*/

  /*listar*/
   public function listar_rango()
  {
     $query = $this->db->get('tbl_comisiones');
      if($query->num_rows() > 0){
        return $query->result();
      }else{
        return false;
      }
  }
    /* insertar videos */
   public function insert_comisiones($data)
  {
      $this->db->insert('tbl_comisiones',$data);
     if($this->db->affected_rows() > 0){
          return true;
        }else{
          return false;
        }
     
  }

  public function eliminar_rango($id)
    {
     $this->db->where('id_tbl_comisiones',$id);
     $this->db->delete('tbl_comisiones');
     if($this->db->affected_rows() > 0){
        return true;
      }else{
        return false;
      }
  } 
  /*------------------------------------*/

   public function listar_categorias_prod()
  {
     $query = $this->db->get('p_categorias');
      if($query->num_rows() > 0){
        return $query->result();
      }else{
        return false;
      }
  }

    public function selec_categorias_prod()
  {
     $mostarcategorias ="";
      $result_c =$this->listar_categorias_prod(); 
       if(!empty($result_c))
        {
          foreach($result_c as $row):
              $mostarcategorias .='<option value="'.$row->id.'">'.$row->nombre.'</option>';
           endforeach ; 
        } 
     
   return $mostarcategorias;
  }

  /*------------------------------------*/


   public function las_insetCap()
  {
    $this->db->select('id_cap,evaluacion');
    $this->db->order_by("id_cap","desc"); 
    $resultados = $this->db->get('capacitacion');
    return $resultados->row();
  }

   public function insert_toCar($data)
  {
      $this->db->insert('carrito',$data);
     if($this->db->affected_rows() > 0){
          return true;
        }else{
              return false;
             }
  }
  public function update_prodCar($param) {
   $this->db->where('id_car',$param['id_car']);
   $this->db->update('carrito',$param);
   if($this->db->affected_rows() > 0){
      return true;
       }else{
         return false;
        }
   } 
  public function rowCountAsoc($id_emp){
      $this->db->where('emp.estado','1');
      $this->db->where('e_a.id_padre', $id_emp);
      $this->db->join('emprendedor as emp ', 'e_a.id_hijo = emp.id_emp');
      $query = $this->db->get('emp_asoc as e_a');
      if($query->num_rows() > 0){
        return $query->num_rows();
      }else{
        return false;
      }
  }

  public function rowCount($tabla){
    $resultados = $this->db->get($tabla);
    return $resultados->num_rows();
  }
  public function comprobar_email($email,$password){
       $data = array('password' => md5($password));
      $this->db->where('email', $email);
      $this->db->update('password',$password);
      $query = $this->db->get('emprendedor');
      if($query->num_rows() > 0){
        return $query->row();
      }else{
        return false;
      }
  }
  
  public function mostrar_asoc($id_emp)
  {
      $this->db->where('emp.estado','1');
      $this->db->where('e_a.id_padre', $id_emp);
      $this->db->join('emprendedor as emp ', 'e_a.id_hijo = emp.id_emp');
      $query = $this->db->get('emp_asoc as e_a');
      if($query->num_rows() > 0){
        return $query->result();
      }else{
        return false;
      }
  }
  public function mostrar_carrito($id_emp)
  {
      $this->db->select('id_car,car.id_producto,no_orden,url_imagen,nombre_prod,precio_car,cantidad,importe');
      $this->db->where('car.id_emp',$id_emp);
      $this->db->join('producto as prod','prod.id_producto = car.id_producto');
      $query = $this->db->get('carrito as car');
      if($query->num_rows() > 0){
        return $query->result();
      }else{
        return false;
      }
  }

  public function mostrar_detallecarrito($id_emp)
  {
      $this->db->select('url_imagen,nombre_prod,precio_car,cantidad');
      $this->db->where('car.id_emp',$id_emp);
      $this->db->join('producto as prod','prod.id_producto = car.id_producto');
      $query = $this->db->get('carrito as car');
      if($query->num_rows() > 0){
        return $query->result();
      }else{
        return false;
      }
  }

    public function count_cantProdCar($id_emp)
  {
    $this->db->from('carrito');
    $this->db->where('id_emp',$id_emp);
    return $this->db->count_all_results();
  }
 
 /*----------INSERTAR COMPRA ------------------*/
 public function save_compra($data){
    return $this->db->insert("compra",$data);
  }

  public function lastID(){
    return $this->db->insert_id();
  }

  public function save_detalleCompra($data){
    $this->db->insert("detalle_compra",$data);
  }

  public function getDetalleCompra($id_compra){
    $this->db->select("prod.nombre_prod,cantidad_comp,precio_comp,importe");
    $this->db->from("detalle_compra d_c");
    $this->db->where("d_c.id_compra",$id_compra);
    $this->db->join("producto as prod","prod.id_producto = d_c.id_producto");
    $resultados = $this->db->get();
    if ($resultados->num_rows() > 0) {
      return $resultados->result();
    }else 
    {
      return false;
    }
  }

     public function lista_compra($id_emp)
  {
     $this->db->select("DATE_FORMAT(fecha_comp,'%d/%m/%Y') as fecha,no_compra,total_comp,id_compra");
     $this->db->where("id_emp",$id_emp);
     $query = $this->db->get('compra');
      if($query->num_rows() > 0){
        return $query->result();
      }else{
        return false;
      }
  } 

  /*----------mi cartera------------*/
  public function lista_miCartera($id_emp)
  {
     $this->db->select("DATE_FORMAT(fecha,'%d/%m/%Y'),no_compra,gasto_cartera,saldo");
     $this->db->where("id_emp",$id_emp);
     $query = $this->db->get('cartera_comisiones');
      if($query->num_rows() > 0){
        return $query->result();
      }else{
        return false;
      }
  }
    public function getdatosCompra($id_compra)
  {
    $this->db->where('id_compra',$id_compra);
    $query = $this->db->get('compra');
  return  $query-> row();
  } 


   public function get_sumatoriaCompra($id_compra)
  {
    $this->db->where('id_compra',$id_compra);
    $this->db->select_sum('importe');
    $query = $this->db->get('detalle_compra');
  return  $query-> row();
  }

   public function sumatoriaCompraEmp($id_emp)
  {
    $this->db->where('id_emp',$id_emp);
   // $this->db->where("YEAR(fecha_comp)",$data['year']);
    $this->db->select_sum('total_comp');
    $query = $this->db->get('compra');
  return  $query-> row();
  }

   public function sumatoriaCompraEmpMensual($data)//$id_emp,$mes,$año
  {
    $this->db->where('id_emp',$data['id_emp']);
    $this->db->select_sum('total_comp');
    $this->db->where("MONTH(fecha_comp)",$data['mes']);
    $this->db->where("YEAR(fecha_comp)",$data['year']);
    $query = $this->db->get('compra');
    if($query->num_rows() > 0){
        return $query-> row();
      }else{
        return 0;
      }

  }


 public function cantidadVentas($data){    
    $total_plata = 0;
    $porcientos = [];

    $this->db->select("id_hijo, sum(comp.total_comp) as total");
    $this->db->where("e_a.id_padre",$data['id_emp']);
    $this->db->where("MONTH(comp.fecha_comp)",$data['mes']);
    $this->db->where("YEAR(comp.fecha_comp)",$data['year']);
    $this->db->join("compra as comp","e_a.id_hijo = comp.id_emp");
    $this->db->group_by("e_a.id_hijo");
    $query = $this->db->get('emp_asoc as e_a');

    $cantidad_ventas = $query->num_rows();    
    foreach ($query->result() as $row)
      {
        $total_plata += $row->total;              
      }
    $porcientos = $this->obtener_porciento($cantidad_ventas);
    $comision = $this->calcular_porciento($porcientos['porciento'], $total_plata);

    $datos = array('cantidad_ventas' => $cantidad_ventas, 'total_plata' => $total_plata,'porciento' => $porcientos['porciento'], 'categoria' => $porcientos['categoria'], 'comision' => $comision);

    return $datos;
    

  }

   public function obtener_porciento($cantidad)
    {
      $porciento = 0;
      $categoria = '';
      $this->db->select("valor_comision,categoria");
      $this->db->where('rango_inicial <=',$cantidad);
      $this->db->where('rango_final >=',$cantidad);
      $query = $this->db->get('tbl_comisiones');
      foreach ($query->result() as $row)
        {
          $porciento = $row->valor_comision;
          $categoria = $row->categoria;              
        }
      $datos = array('porciento' => $porciento, 'categoria' => $categoria);  
      return  $datos;
    }

    public function calcular_porciento($porc, $plata)
    {
      $total = ($porc * $plata)/100;  
      return  $total;
    }





  

  /*limpiar carrito*/

 public function limpiar_carrito($id_emp)
    {
     $this->db->where('id_emp',$id_emp);
     $this->db->delete('carrito');
     
  }

/*--------------compra----------------*/  
  

   public function mostrar_producto()
  {
     $query = $this->db->get('producto');
      if($query->num_rows() > 0){
        return $query->result();
      }else{
        return false;
      }
  } 
  /*mostrar lista de  emprendedores */
    public function mostrar_emp($id_emp)
  {
     $this->db->where('id_emp !=',$id_emp);
     $query = $this->db->get('emprendedor');
      if($query->num_rows() > 0){
        return $query->result();
      }else{
        return false;
      }
  }
  /*mostrar datos de emprender especifico*/
  /*-----Devuelve el consecutivo de la orden -----------*/
   public function datos_emp($id_emp) {
   $this->db->where('id_emp',$id_emp);
   $query = $this->db->get('emprendedor');
   return $query-> row();
  
   } 
   public function listar_data_cap()
  {
     $query = $this->db->get('capacitacion');
      if($query->num_rows() > 0){
        return $query->result();
      }else{
        return false;
      }
  }
  /*lista de preguntas por id_cap */
   public function listar_preguntas_cap($id_cap)
  {
     $this->db->where('id_cap',$id_cap);
     $query = $this->db->get('evaluacion');
      if($query->num_rows() > 0){
        return $query->result();
      }else{
        return false;
      }
  }


  public function Total_emp($tabla){
    $resultados = $this->db->get($tabla);
    return $resultados->num_rows();
  }
  /*CRUD PRODUCTOS*/
    public function listar_data_prod()
  {
     $query = $this->db->get('productos');
      if($query->num_rows() > 0){
        return $query->result();
      }else{
        return false;
      }
  }

     public function seleccion_productos()
  {
     $result =$this->listar_categorias_prod(); 
     $mostarcategorias = "";
     foreach($result as  $value):
      $mostarcategorias .='<optgroup label="'.$value->nombre.'">';
      $result_prod =$this->listar_productos(); 
       if(!empty($result_prod))
        {
          $mostarcategorias .='<option value=" " seleted >Seleccione</option>';
            foreach($result_prod as $row):
              $mostarcategorias .='<option value="'.$row->id_producto.'">'.$row->nombre_prod.'</option>';
            endforeach ; 
        } 
      $mostarcategorias .= '</optgroup>';
      endforeach ; 
   return $mostarcategorias;
  }


  public function productos_almacen($data)
  {
    
    $this->db->select('prod.id_producto,prod.nombre_prod,alm.existencia');
    $this->db->join('productos as prod', 'prod.id_producto = alm.id_producto');
    $this->db->where('alm.id_emp', $data['id_emp']);
    $this->db->where('prod.id_categoria', $data['id_categoria']);
    $this->db->where('alm.existencia >',0);
    $query = $this->db->get('almacen_emp as alm');
    return $query->result();

  }

 
  /*Insertar combo*/

     public function insert_combo($data)
  {
      $this->db->insert('combo',$data);
     if($this->db->affected_rows() > 0){
          return true;
        
        }else{
          return false;
        }
     
  }


  public function save_combos($data){
    return $this->db->insert("combo_producto",$data);
  }


  public function eliminar_combo($id)
    {
     $this->db->where('id_combo',$id);
     $this->db->delete('combo');
     if($this->db->affected_rows() > 0){
        return true;
      }else{
        return false;
      }
  } 

  public function prod_delcombo($id_combo){
        $this->db->select('prod.nombre_prod');
        $this->db->where('com_p.id_combo', $id_combo);
        $this->db->join('productos as prod', 'prod.id_producto = com_p.id_producto');
        $query = $this->db->get('combo_producto as com_p');
        return $query->result();
       
    }






  /*---------productos----------*/
     public function listar_productos()
  {
    $this->db->select("id_categoria,id_producto,nombre_prod");
     $query = $this->db->get('productos');
      if($query->num_rows() > 0){
        return $query->result();
      }else{
        return false;
      }
  }
  /*Insertar*/
  
     public function insert_prod($data)
  {
      $this->db->insert('productos',$data);
     if($this->db->affected_rows() > 0){
          return true;
        
        }else{
          return false;
        }
     
  }
  /*Editar*/
  
  /*Eliminar*/
     public function eliminar_prod($id)
    {
     $this->db->where('id_producto',$id);
     $this->db->delete('productos');
     if($this->db->affected_rows() > 0){
        return true;
      }else{
        return false;
      }
  }
  /*----------------*/

    /*CRUD COMBOS*/
    public function listar_data_combos()
  {
     $query = $this->db->get('combo');
      if($query->num_rows() > 0){
        return $query->result();
      }else{
        return false;
      }
  }
   
   /*-----Devuelve el consecutivo de la orden -----------*/
   public function N_orden_compra($year) {
    
   $this->db->where('year',$year);
   $query = $this->db->get('orden_compra');
   $row = $query-> row();
   return $row->no_orden;
  
   } 
      /*-----actualiza consecutivo de la orden -----------*/
   public function update_orden_compra($year) {
   $orden = $this->N_orden_compra($year);
   $i=3;
   $n_orden = str_pad($orden, $i, 0, STR_PAD_LEFT);
   $data = array('no_orden' => $n_orden+1);
   $this->db->where('year',$year);
   $this->db->update('orden_compra',$data);
  
   }
   /*-----actualiza consecutivo de la orden -----------*/
   public function update_datosEmp($data_ins) {
   $data = array('password' => $data_ins['password'],'estado'=> 1);
   $this->db->where('email',$data_ins['email']);
   $this->db->update('emprendedor',$data);
  
   }  
    
    /*-----Devuelve dato del producto -----------*/
   public function datos_prod($id_producto) {
    
   $this->db->where('id_producto',$id_producto);
   $query = $this->db->get('producto');
   return $query-> row();
  
   }
    public function eliminar_prodCar($param)
    {
     $this->db->where('id_car',$param['id_car']);
     $this->db->where('id_emp',$param['id_emp']);
     $this->db->delete('carrito');
     if($this->db->affected_rows() > 0){
        return true;
      }else{
        return false;
      }
  }
    public function eliminar_cap($id_cap)
    {
     $this->db->where('id_cap',$id_cap);
     $this->db->delete('capacitacion');
     if($this->db->affected_rows() > 0){
        return true;
      }else{
        return false;
      }
  }
  public function eliminar_emp($id_emp)
    {
     $this->db->where('id_emp',$id_emp);
     $this->db->delete('emprendedor');
     if($this->db->affected_rows() > 0){
        return true;
      }else{
        return false;
      }
  }
   /*-----------------------editar Perfil-----------------------*/ 
   
  public function update_perfil($param) 
  {
    $this->db->where('id_emp',$param['id_emp']);
    $this->db->update('emprendedor',$param);
     if($this->db->affected_rows() > 0){
      return true;
       }else{
         return false;
        }
  }
 


























  /*-----Devuelve los datos de una tienda especifica-----------*/
   public function datos_tienda($id_tienda) {
    
   $this->db->where('id_tienda',$id_tienda);
   $query = $this->db->get('tiendas');
   
   return $query-> row();
  
   }
/*-------devuelve los datos del plan------------*/
  public function datos_plan($id_plan) 
  {
     $this->db->where('id_plan',$id_plan);
     $query = $this->db->get('plan_pago');
    return $query-> row();
  }
  /*-------devuelve los datos del usuario------------*/
  public function datos_usuario($id_usuario) 
  {
     $this->db->where('id_usuario',$id_usuario);
     $query = $this->db->get('usuario');
    return $query-> row();
  }
  /*------------devuelve los datos del usuario------------------*/
   public function datos_usuarioT($id_usuario){
      
        $this->db->where('id_usuario', $id_usuario);
        $this->db->join('plan_pago as plan ', 'plan.id_plan = usuario.id_plan');
        $query = $this->db->get('usuario');
        if($query->num_rows() > 0){
          return $query->row();
        }else{
          return false;
        }
    }
  /*-------devuelve los datos del plan------------*/
  public function update_plan($id_plan,$id_usuario) 
  {
      $fecha_solicPlan = date("Y-m-d H:i:s");
      $fecha_vencimiento = date("Y-m-d", strtotime("$fecha_solicPlan +1 month"));
      $data = array('plan_solicitado'   => $id_plan ,
                    'fecha_solicPlan'   => $fecha_solicPlan,
                    'fecha_vencimiento' => $fecha_vencimiento
                  );
      $this->db->where('id_usuario',$id_usuario);
      $this->db->update('usuario',$data);
      
     if($this->db->affected_rows() > 0){
      return true;
       }else{
         return false;
        }
  }
    /*-------actualiza el plan solicitado------------*/
  public function update_planSol($plan_sol,$id_usuario) 
  {
      $data = array('id_plan' => $plan_sol ,'plan_solicitado' => 0 );// el plan solicitado se pone en cero y se actualiza el id_plan
      $this->db->where('id_usuario',$id_usuario);
      $this->db->update('usuario',$data);
      
     if($this->db->affected_rows() > 0){
      return true;
       }else{
         return false;
        }
  }
    //----------------------------
  public function eliminar_usuarioTienda($id_usuario)
    {
     $this->db->where('id_usuario',$id_usuario);
     $this->db->delete('usuario');
     if($this->db->affected_rows() > 0){
        return true;
      }else{
        return false;
      }
  }
  
/*-------update los datos de los productos de una tienda------------*/
   public function update_producto_tienda($id_producto)
  {
     $data = array('seleccionado' => 1 ); // seleccionado 1 significa q esta seleccionado ese producto
     $this->db->where('id_producto',$id_producto);
     $this->db->update('productos_tienda',$data);
     if($this->db->affected_rows() > 0){
      return true;
       }else{
         return false;
        }
   }
/*-------retorna los  productos a productos generales de la  tienda------------*/
   public function retorna_producto_tienda($id_producto)
  {
     $data = array('seleccionado' => 0,'cargado'=> 0,'aprobado'=> 0,'listo' => 0 ); // seleccionado 0 significa que  retorna a la tienda  ese producto
     $this->db->where('id_producto',$id_producto);
     $this->db->update('productos_tienda',$data);
     $this->insertar_eliminacion_prio($id_producto);
    
     if($this->db->affected_rows() > 0){
      return true;
       }else{
         return false;
        }
   }
 public function insertar_eliminacion_prio($id_producto)
  {
   $this->db->select('store_id'); 
   $this->db->where('id_producto',$id_producto);
   $query = $this->db->get('productos_tienda');
   $tienda = $query-> row();
   $dato_prod = array('id_producto' => $id_producto,'store_id' => $tienda->store_id);
   $this->db->insert('eliminacion_prio',$dato_prod); 
  }
  
/*-------insertar consulta de soporte tecnico------------*/
     public function insertar_consulta($data)
  {
      $this->db->insert('consultas_soporte',$data);
     if($this->db->affected_rows() > 0){
          return true;
        
        }else{
          return false;
        }
     
  }
      public function insertar_wizard($data)
  {
      $this->db->insert('usuario',$data);
     if($this->db->affected_rows() > 0){
          return true;
        
        }else{
          return false;
        }
     
  }
  /*------------get datos de producto-------------------*/
  public function editar_producto($id_producto)
  {
    $this->db->where('id_producto',$id_producto);
    $query = $this->db->get('productos_tienda');
    if($query->num_rows() > 0){
      return $query->row();
    }else{
      return false;
    }
  }
  /*------------insertar usuarios registrados--------*/
     public function InsertDatosUsuario($param)
  {
      $this->db->insert('registro_usuario',$param);
     if($this->db->affected_rows() > 0){
          return true;
        
        }else{
          return false;
        }
     
  }
  /*-----------------------update datos de productos---------------------*/
    public function udpdateDatosProd($param)
  {
    
    $campos = array(
                   'descripton'  => $param['descripton'],
                   'id_categoria'=> $param['id_categoria'],
                   'listo'       =>1
                  );
     $this->db->where('id_producto',$param['id_producto']);
     $this->db->update('productos_tienda',$campos);
     if($this->db->affected_rows() > 0){
      return true;
       }else{
         return false;
        }
   } 
   
  
    //-----------------codigo viejo -----------
public function aumentar_valoboleta()
  {
   $datos['valor_inicial'] = $this->getValorInicial();
   $text = $datos['valor_inicial']->valor + 1;
   $data = array('valor' => $text);
   $this->db->where('parametro','bol_inicial');
   $this->db->update('configuracion',$data);
  }
  //--------------actualizar valor_inicial del curso------------------------
  public function aumentar_valor_curso()
  {
   $datos['valor_inicial_curso'] = $this->getValorincialCurso();
   $text = $datos['valor_inicial_curso']->valor + 1;
   $data = array('valor' => $text);
   $this->db->where('parametro','valor_inicialcurso');
   $this->db->update('configuracion',$data);
  }
//----------------------------------------   
 public function count_all()
  {
    $this->db->from('chofer');
    $this->db->where('stado','1');
    return $this->db->count_all_results();
  }
  //--------------contar Productos--------
   public function count_Productos($store_id)
  {
    $this->db->from('productos_tienda');
    $this->db->where('store_id',$store_id); 
    return $this->db->count_all_results();
  }
   public function count_Productos_generales($store_id)
  {
    $this->db->from('productos_tienda');
    $this->db->where('store_id',$store_id);
  $this->db->where('seleccionado',0);
    return $this->db->count_all_results();
  }
  public function count_Productos_seleccionados($store_id)
  {
    $this->db->from('productos_tienda');
    $this->db->where('store_id',$store_id);
  $this->db->where('seleccionado',1);
    return $this->db->count_all_results();
  }
    //--------------contar Productos SELECCIONADO DADO UNA TIENDA--------
   public function count_Productos_Selec($store_id)
  {
    $this->db->from('productos_tienda');
    $this->db->where('store_id',$store_id);
    $this->db->where('seleccionado',1);
    return $this->db->count_all_results();
  }
     //--------------contar Nuevas Solitudes--------
   public function count_NuevasSolitudPlan()
  {
    $this->db->from('usuario');
    $this->db->where('plan_solicitado !=',0);
    return $this->db->count_all_results();
  }
   public function getNewNoticaciones()
  {
   $this->db->select('*');    
   $this->db->from('usuario as us'); 
   $this->db->join('tiendas as tie', 'us.id_tienda = tie.id_tienda');
   $this->db->join('plan_pago as plan', 'us.id_plan = plan.id_plan');
   $this->db->where('plan_solicitado !=',0);
   $query = $this->db->get();
   return $query->result();    
  }
    public function getPlanes()
  {
   $this->db->from('plan_pago');
   $query = $this->db->get();
   return $query->result();    
  }


  //------------------ contar alumnos inscritos curso----

   public function count_alumnoInscritosC($idEvento)
  {
    $this->db->where('idEvento',$idEvento);
    $this->db->from('alumno');
    return $this->db->count_all_results();
  }


    public function count_recibosTotal()
  {
    $this->db->from('recibo_boleta');
    return $this->db->count_all_results();
  }

   public function count_Nincripciones()
  {
    $this->db->where('stado','0');
    $this->db->from('chofer');
    return $this->db->count_all_results();
  }


	public function get_sumatoriaventa()
	{
    $this->db->where('stado','1');
	  $this->db->select_sum('precio');
   // $this->db->as('total');
    $this->db->from('chofer');
    //$this->db->join('chofer', 'curso.id_curso = chofer.id_curso', 'inner');
    $query = $this->db->get();
         
    return  $query-> row();
	}
  public function get_sumatoriaCentro($id_centro)
  {
    $this->db->where('id_centro',$id_centro);
    $this->db->select_sum('importe_curso');
   // $this->db->as('total');
    $this->db->from('recibo_boleta');
    $query = $this->db->get();
  return  $query-> row();
  }

    public function get_sumatoriaTotal()
  {
    $this->db->select_sum('importe_curso');
    $this->db->from('recibo_boleta');
    $query = $this->db->get();
  return  $query-> row();
  }
	
	public function getdatosregion($id_region)
  {
    $this->db->where('id_region',$id_region);
    $query = $this->db->get('region');
    return $query->row();
 }

public function getdatosChofer($dni)
  {
    $this->db->where('dni',$dni);
    $query = $this->db->get('chofer');
    return $query->row();
 }

 public function getdatosChofer_codigo($codigo_barra)
  {
    $this->db->where('codigo_barra',$codigo_barra);
    $query = $this->db->get('chofer');
    return $query->row();
 }



public function datosChofer(){
        $codigo_barra = $this->input->get('codigo_barra');
        $this->db->where('codigo_barra', $codigo_barra);
        $query = $this->db->get('chofer');
        if($query->num_rows() > 0){
          return $query->row();
        }else{
          return false;
        }
    } 


 

public function getdatosChofer_recibo($codigo_barra)
  {
    $this->db->where('codigo_barra',$codigo_barra);
    $query = $this->db->get('recibo_boleta');
    return $query->row();
 }

 

 public function insertar_recibo_bol($campos)
  {
    $this->db->insert('recibo_boleta',$campos);
   
 }
  //-------------devuelve la fila bol_inicial--------
  public function getValorInicial()
  {
    $this->db->where('parametro','bol_inicial');
    $query = $this->db->get('configuracion');
    return $query->row();
 }

   public function getValorInicialInscrip($id_centro)
  {
    $this->db->where('id_centro',$id_centro);
    $query = $this->db->get('recibo_unidad');
    return $query->row();
 }


   public function getValorInicialInscrip_centro($id_centro)
  {
    $this->db->where('id_centro',$id_centro);
    $query = $this->db->get('inscripcion_centro');
    return $query->row();
 }

  public function mod_ValorInicialInscrip_centro($id_centro,$valor_inscripcion)
    {
      $datos  = array('valor' => $valor_inscripcion);

      $this->db->where('id_centro',$id_centro);
      $this->db->update('inscripcion_centro',$datos);

    }

  public function insert_ValorInicialInscrip_centro($id_centro)
    {

      $datos  = array('id_centro' => $id_centro,'valor' => 1);
      $this->db->insert('inscripcion_centro',$datos);

    }
  


 

 public function mod_ValorInicialInscrip($id_centro,$valor_inscripcion)
    {
      $datos  = array('valor' => $valor_inscripcion);

      $this->db->where('id_centro',$id_centro);
      $this->db->update('recibo_unidad',$datos);

    }

    public function insert_ValorInicialInscrip($id_centro)
    {

      $datos  = array('id_centro' => $id_centro,'valor' => 1);
      $this->db->insert('recibo_unidad',$datos);

    }

    

 public function aumentar_valor_no_recibo($aumento)
    {

     $this->db->where('parametro','no_recibo');
     $this->db->update('recibo_unidad',$aumento);

    }

 //-------------aumentar el valor_pedido------------
  public function aumentar_valor_no_inscripcion($aumento)
    {
     $data = array('valor' => $aumento);
     $this->db->where('parametro','n_inscripcion');
     $this->db->update('configuracion',$data);

    }

 public function getdatosrecibo_bol($id_recibo)
  {
    $this->db->where('id_recibo',$id_recibo);
    $query = $this->db->get('recibo_boleta');
    return $query->row();
 }
 
 
  public function getdatosCentro($id_centro)
  {
    $this->db->where('id_centro',$id_centro);
    $query = $this->db->get('centro_inscripcion');
    return $query->row();
 }

  public function getdatosAlumnoInscrito($id_inscripcion)
  {
    $this->db->where('id_inscripcion',$id_inscripcion);
    $query = $this->db->get('inscripcion');
    return $query->row();
 }
  public function getdatosAlumno($id_alumno)
  {
    $this->db->where('id_alumno',$id_alumno);
    $query = $this->db->get('alumno');
    return $query->row();
 }
 
  public function getdatosAula($id_unidad)
  {
    $this->db->where('id_unidad',$id_unidad);
    $query = $this->db->get('aula');
    return $query->row();
 }

   public function aula($id_aula)
  {
    $this->db->where('id_aula',$id_aula);
    $query = $this->db->get('aula');
    return $query->row();
 }

  public function getdatosprofesor($idEvento)
  {
    $this->db->where('idEvento',$idEvento);
    $query = $this->db->get('profesor');
    if($query->num_rows() > 0){
          return $query->row();
        }else{
          return false;
        }
   
 }

 public function ver_siexitprofesor($idEvento)
  {
    $this->db->from('profesor');
    $this->db->where('idEvento',$idEvento);
    return $this->db->count_all_results();
 }

 

 public function getdatosprofesorCBO($idEvento,$dia)
  {
    $this->db->where('idEvento',$idEvento);
    $this->db->where('dia',$dia);
    $query = $this->db->get('profesor');
    if($query->num_rows() > 0){
          return $query->row();
        }else{
          return false;
        }
   
 }
 

   public function getValorconvenio()
  {
    $this->db->where('parametro','convenio_bancario');
    $query = $this->db->get('configuracion');
    return $query->row();
 }
   public function getValorincialCurso()
  {
    $this->db->where('parametro','valor_inicialcurso');
    $query = $this->db->get('configuracion');
    return $query->row();
 }

 public function getallUsuariosTienda()
  {
   $this->db->select('*');    
   $this->db->from('usuario as us'); 

   $this->db->join('tiendas as tie', 'us.id_tienda = tie.id_tienda');
   $this->db->join('plan_pago as plan', 'us.id_plan = plan.id_plan');
   $query = $this->db->get();
   return $query->result();    
  }
 public function getPagoexitoso()
  {
   $this->db->select('*');
   $this->db->from('notificaciones_pagoexitoso as noti_pago'); 
   $this->db->join('usuario as us','us.id_usuario = noti_pago.id_usuario');
   $this->db->join('plan_pago as plan', 'us.id_plan = plan.id_plan');
   $query = $this->db->get();
   return $query->result();    
  }
  /*--------------devolver historico de usuario de planes------------*/  

  public function getHistoricoUsuariosTienda($id_usuario)
  {
   $this->db->select('*');    
   $this->db->from('historico_pago as hist_pago'); 
   $this->db->where('hist_pago.id_usuario',$id_usuario);
   $this->db->join('usuario as us','us.id_usuario = hist_pago.id_usuario');
   $this->db->join('plan_pago as plan', 'hist_pago.id_plan = plan.id_plan');
   $query = $this->db->get();
   return $query->result();    
  }

    /*--------------devolver historico de usuario Admin------------*/  

  public function HistoricoUsuariosTienda()
  {
   $this->db->select('*');    
   $this->db->from('historico_pago as hist_pago'); 
   $this->db->join('usuario as us','us.id_usuario = hist_pago.id_usuario');
   $this->db->join('plan_pago as plan', 'hist_pago.id_plan = plan.id_plan');
   $query = $this->db->get();
   return $query->result();    
  }  

   public function getPagoxConfirmar()
  {
   $this->db->select('*');
   $this->db->from('notificaciones_error_pago as noti_error'); 
   $query = $this->db->get();
   return $query->result();    
  }  
  /*-------administrar categorias---*/

   public function administrar_categorias()
  {
   $this->db->select('*');
   $this->db->from('categorias'); 
   $query = $this->db->get();
   return $query->result();    
  } 

  public function getPlanSolicitado($id_usuario)
  {
   $this->db->where('id_usuario',$id_usuario);
    $query = $this->db->get('usuario');
    return $query->row();    
  }

   public function getProd_Tienda($store_id,$number_per_page)
  {
   $this->db->select('*');    
   $this->db->from('productos_tienda'); 
   $this->db->where('store_id',$store_id);
   $this->db->where('seleccionado',0);
  $this->db->limit($number_per_page,$this->uri->segment(3));
   $query = $this->db->get();
   return $query->result();    
  }

/*MUESTRA LOS PRODUCTOS SELECCIONADOS DADO UNA TIENDA*/
   public function getProd_Tienda_Selec($store_id,$number_per_page)
  {
   $this->db->select('*');    
   $this->db->from('productos_tienda'); 
   $this->db->where('store_id',$store_id);
   $this->db->where('seleccionado',1);
   $this->db->limit($number_per_page,$this->uri->segment(3));
   $query = $this->db->get();
   return $query->result();    
  }



  //----------getProvincia-----

  public function getProvincia()
  {
   
   $this->db->select('*');    
   $this->db->from('provincia'); 
   return $query = $this->db->get();
       
  }

  //--------------obtener el precio unitario de los productos--------------
    public function datosunidad(){
        $id_provincia = $this->input->get('id_provincia');
        $this->db->where('id_provincia',$id_provincia);
        $query = $this->db->get('unidad_academica');
        if($query->num_rows() > 0){
          return $query->result();
        }else{
          return false;
        }
    }
  //----------------obtener datos de recibo_boleta
    public function datosrecibo_boleta(){
        
        $id_unidad = $this->input->get('id_unidad');
        $this->session->set_flashdata("id_unidad_flash", $id_unidad);
        $this->db->where('id_unidad',$id_unidad);
        $query = $this->db->get('recibo_boleta');
        if($query->num_rows() > 0){
          return $query->result();
        }else{
          return false;
        }
    }  

     public function mostrar_rep($id_unidad){
       
       $this->db->where('id_unidad',$id_unidad);
       $query = $this->db->get('recibo_boleta');
       return $query->result();
       
    } 
 


   public function listardatosunidad()
   {
    $query = $this->db->get('unidad_academica');
    return $query->result();
   }


   public function listardatos_correos_ins($mes,$id_unidad,$id_curso)
   {
    $this->db->select('mail,nombre_alumno,apellido_alunmo,numero_doc,sku,nombre_curso');
    $this->db->from('alumno as al');
    $this->db->join('eventos as ev', 'al.idEvento = ev.idEvento'); 
    $this->db->join('unidad_academica  as ua', 'ua.id_unidad = ev.id_unidad');
    $this->db->join('curso  as cur', 'ev.id_curso = cur.id_curso');    
    
    $this->db->where('ua.id_unidad',$id_unidad);
    $this->db->where('cur.id_curso',$id_curso);
    $this->db->where('MONTH(ev.fecInicio)',$mes);
   // $this->db->where('YEAR(CURDATE())'); //NOTA TENGO Q BUSCAR EL PARMETRO PARA SACARLE EL AÑO
    $this->db->where('al.estado',3);
    $query = $this->db->get();
    return $query->result();
   }

   public function listarcapacitadorC($id_centro,$id_curso)
   {
     $this->db->where('id_centro',$id_centro);
     $this->db->where('id_curso',$id_curso);
     $query = $this->db->get('capacitador');
     return $query->result();
   }

   public function listarcapacitador()
   {
     
     $query = $this->db->get('capacitador');
     return $query->result();
   }


     public function update_pagoRecibo()
  {
    $id = $this->input->post('id_recibo');
    $field = array(
                  'fecha_entrega'=>$this->input->post('fecha_entrega'), 
                  'estado_entregado'  =>'PAGADO'
                  
                  );
    $this->db->where('id_recibo', $id);
    $this->db->update('recibo_boleta', $field);
    if($this->db->affected_rows() > 0){
      return true;
    }else{
      return false;
    }
  }

    public function buscar_chofer($dni){
       
       $this->db->where('dni',$dni);
       $query = $this->db->get('chofer');
       return $query->result();
       
    }

     public function eliminar_recib()
  {
    $id            = $this->input->post('id_recibo');
    $usuario       = $this->input->post('usuario');
    $motivo        = $this->input->post('motivo');
    $row['recibo'] = $this ->getdatosrecibo_bol($id);
    $fecha_log     = date('Y-m-d H:i:s');
     
    $data = array(
                   'no_recibo_boleta'   => $row['recibo']->no_recibo_boleta,
                   'id_centro'          => $row['recibo']->id_centro,
                   'id_unidad'          => $row['recibo']->id_unidad,
                   'codigo_barra'       => $row['recibo']->codigo_barra,
                   'n_boleta'           => $row['recibo']->n_boleta,
                   'nombre'             => $row['recibo']->nombre,
                   'apellidos'          => $row['recibo']->apellidos,
                   'dni'                => $row['recibo']->dni,
                   'id_curso'           => $row['recibo']->id_curso,
                   'importe_curso'      => $row['recibo']->importe_curso,
                   'fecha_recibo'       => $row['recibo']->fecha_recibo,
                   'estado_entregado'   => $row['recibo']->estado_entregado,
                   'fecha_entrega'      => $row['recibo']->fecha_entrega,
                   'id_unidad_registro' => $row['recibo']->id_unidad_registro,
                   'motivo'             => $motivo,
                   'usuario'            => $usuario,
                   'fecha_log'          => $fecha_log
                   
                   );
        $this->db->insert('backup_registros',$data);
        
         if($this->db->affected_rows() > 0){
            $dni = $row['recibo']->dni;
            $resultado = $this->buscar_chofer($dni);
            
            foreach ($resultado as  $value):
              $this->db->where('dni',$dni);
              $this->db->delete('chofer');
            endforeach ;
           
          $this->db->where('id_recibo', $id);
          $this->db->delete('recibo_boleta');
        return true;
        }else{
          return false;
        }

  }

  ///--------------------recibo_por centro academico-------------------------------------

   public function showRecibo_centro($id_centro,$fecha_inicial,$fecha_final)
   {

      $this->db->where('id_centro',$id_centro);
      $this->db->where('fecha_recibo >= "'.$fecha_inicial.'"');
      $this->db->where('fecha_recibo <="'.$fecha_final.'"' );
      $query = $this->db->get('recibo_boleta');
      if($this->db->affected_rows() > 0){
       
       return $query->result();
      
      }else{
        return false;
      }
    
  }


   public function showallRecibo($fecha_inicial,$fecha_final)
   {

      $this->db->where('fecha_recibo >=',$fecha_inicial);
      $this->db->where('fecha_recibo <=',$fecha_final);
      $query = $this->db->get('recibo_boleta');
      if($this->db->affected_rows() > 0){
       
       return $query->result();
      
      }else{
        return false;
      }
    
  }

  
   public function showdatoschofer($dni)
  {
   $this->db->where('dni',$dni);
   $query = $this->db->get('chofer'); 
  return $query-> row();
  }

  public function datosChoferDNI(){
        $dni = $this->input->get('dni');
        $this->db->where('dni', $dni);
        $query = $this->db->get('chofer');
        if($query->num_rows() > 0){
          return $query->row();
        }else{
          return false;
        }
    }


   public function showdatosunidadA($id_unidad)
  {
   $this->db->where('id_unidad',$id_unidad);
   $query = $this->db->get('unidad_academica'); 
  return $query-> row();
  }

    public function showdatosProvincia($id_provincia)
  {
   $this->db->where('id_provincia',$id_provincia);
   $query = $this->db->get('provincia'); 
  return $query-> row();
  }
  public function showdatosDistrito($id_distrito)
  {
   $this->db->where('id_distrito',$id_distrito);
   $query = $this->db->get('distrito_academico'); 
  return $query-> row();
  }




//----------------devuelve todos los cursos----------------------
   public function getCursos()
  {
   $this->db->select('*');    
   $this->db->from('curso'); 
     return $query = $this->db->get();
   }

//----------devuelve los datos del curso especifico---------------
  public function getCurso($id)
  {
   $this->db->select('*'); 
   $this->db->where('id_curso',$id);
   $this->db->from('curso'); 
   $query = $this->db->get(); 

     return $query-> row();
  }
  //-----------tabla  inscripcion curso-------------
   public function getinscripcion_curso($id)
  {
   $this->db->where('id_inscripcion',$id);
   $query = $this->db->get('inscripcion_curso'); 
  return $query-> row();
  }
 
  
  public function getunidad($id)
  {
   $this->db->where('id_unidad',$id);
   $query = $this->db->get('unidad_academica'); 
   return $query-> row();
  }


  public function get_existencia($id_producto)
    {
      
       $this->db->where('id_producto',$id_producto);
       $query = $this->db->get('existencia');
       
       return $query-> row();
       
    }
    


  public function get_CategoriaxAlmacen($id_almacen)
  {
    
     $this->db->where('id_almacen',$id_almacen);
     $query = $this->db->get('categoria');
     
     return $query-> row();
     
  }

  public function get_usuario($id_usuario)
  {
    
     $this->db->where('id_usuario',$id_usuario);
     $query = $this->db->get('usuario');
     
     return $query-> row();
     
  }

  public  function suma($id_centro) 
  {    
    $this->db->select_sum('importe_curso');
    $this->db->as('total_recibo_boleta');
    $this->db->where('id_centro',$id_centro); 
    $query=$this->db->get('recibo_boleta');    
  return $query-> row();
  }

public function update_cantidad_final($cantidad_existente,$id_producto)
  {
    $this->db->where('id_producto',$id_producto);   
   
    return $this->db->update('entrada_producto', $cantidad_existente );  
  }


  public function getVentas($id_producto)
  {
    
     $this->db->select('cantidad_articulo,fecha_venta');
     $this->db->where("id_producto", $id_producto);
     $this->db->order_by("fecha_venta", "asc");
     $query = $this->db->get('venta');
          
     return $query->result_array();
     
  }
    public function getVentasxProducto()
  {
    
    $this->db->select('nombre_producto, cantidad_articulo,fecha_venta');
    $this->db->from('venta'); 
    $this->db->order_by("cantidad_articulo", "asc"); 
    $this->db->join('producto','producto.id_producto = venta.id_producto', 'inner');
       
    $query = $this->db->get();
    
    return $query-> row();
     
  }
   public function devolver_nombre_Producto($id_producto)
    {
     $this->db->select('nombre_producto');   
     $this->db->where('id_producto',$id_producto);
     $query = $this->db->get('producto');
     
     return $query-> row();
     
    }



    public function devolver_datos_almacen($id_almacen)
    {
        
     $this->db->where('id_almacen',$id_almacen);
     $query = $this->db->get('almacen');
     
     return $query-> row();
     
    }

    public function comprobar_ext($id_almacen,$id_categoria,$id_producto,$fecha)
    {
        
     $porciones = explode("/",$fecha);
     $mes = $porciones[1];
     $ano = $porciones[2];
     $this->db->where('id_almacen',$id_almacen);
     $this->db->where('id_categoria',$id_categoria);
     $this->db->where('id_producto',$id_producto);
     $this->db->where('mes',$mes);
     $this->db->where('ano',$ano);
     
     $query = $this->db->get('existencia');
     
     return $query-> row();
     
    }

     public function comprobar_existencia_venta($id_almacen,$id_categoria,$id_producto)
    {
 
     $this->db->where('id_almacen',$id_almacen);
     $this->db->where('id_categoria',$id_categoria);
     $this->db->where('id_producto',$id_producto);
        
     $query = $this->db->get('existencia');
     
     return $query-> row();
     
    }


    public function insertar_ext($id_almacen,$id_categoria,$id_producto,$fecha,$cantidad_inicial)
    {
        
     $porciones = explode("/",$fecha);
     $mes = $porciones[1];
     $ano = $porciones[2];
     
      $data = array(
        'id_almacen' => $id_almacen,
        'id_categoria' => $id_categoria,
        'id_producto' => $id_producto,
        'cantidad_existente' => $cantidad_inicial,
        'mes' => $mes,
        'ano' => $ano);

        $this->db->insert('existencia',$data);

        return true;
     
    }

    public function update_ext($id_almacen,$id_categoria,$id_producto,$fecha,$sumatoria)
    {
        
     $porciones = explode("/",$fecha);
     $mes = $porciones[1];
     $ano = $porciones[2];
     
      $data = array(
        'cantidad_existente' => $sumatoria);

         $this->db->where('id_almacen',$id_almacen);
         $this->db->where('id_categoria',$id_categoria);
         $this->db->where('id_producto',$id_producto);
         $this->db->where('mes',$mes);
         $this->db->where('ano',$ano);
         $this->db->update('existencia',$data);

         return true;
     
    }

    public function update_extente_venta($id_almacen,$id_categoria,$id_producto,$resultado_existente)
    {
        
     
      $data = array(
        'cantidad_existente' => $resultado_existente);

         $this->db->where('id_almacen',$id_almacen);
         $this->db->where('id_categoria',$id_categoria);
         $this->db->where('id_producto',$id_producto);
         $this->db->update('existencia',$data);

         return true;
     
    }

}


