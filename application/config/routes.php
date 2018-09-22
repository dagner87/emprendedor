<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$route['default_controller'] = 'Login';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
//-------logusuario--------------------------
$route['logusuario'] = "login/new_user";
//-------usuarios--------------------------
$route['salir'] = "login/salir";
//-------usuarios--------------------------
$route['registro'] = "login/registro";

$route['registro_asociado'] = "login/reg_asociado";



//-------Perfiles--------------------------
$route['MyperfilAdmin'] = "panel_admin/MyperfilAdmin";
$route['my_perfil'] = "capacitacion/Myperfil";

/*-------------------------------------------------*/

$route['ventas_despachos'] = 'C_dashboard/ventas_despachos';
$route['dashboard_consultores'] = 'C_dashboard/dashboard_consultores';
$route['dashboard_consultores_detalles'] = 'C_dashboard/dashboard_consultores_detalles';
$route['dashboard_consultor'] = 'C_dashboard/dashboard_consultor';
$route['ventas_despachos_filtrados'] = 'C_dashboard/ventas_despachos_filtrados';
$route['ventas_despachos_filtrados_pdf/(:any)/(:any)/(:any)'] = 'C_dashboard/ventas_despachos_filtrados_pdf/$1/$2/$3';
$route['obtener_ventas'] = 'C_dashboard/obtener_ventas';
$route['obtener_ventas_pdf'] = 'C_dashboard/obtener_ventas_pdf';
$route['obt_ventas'] = 'C_dashboard/obt_ventas';
$route['respuestas_negativas'] = 'C_dashboard/respuestas_negativas';
$route['respuestas_negativas_pdf'] = 'C_dashboard/respuestas_negativas_pdf';
$route['objetivos_asignados'] = 'C_dashboard/objetivos_asignados';
$route['objetivos_asignados_pdf'] = 'C_dashboard/objetivos_asignados_pdf';
$route['proporcion_venta'] = 'C_dashboard/proporcion_venta';
$route['proporcion_venta_pdf'] = 'C_dashboard/proporcion_venta_pdf';
$route['ventas_resumen'] = 'C_operaciones/ventas_resumen';
$route['ventas_resumen_anno'] = 'C_operaciones/ventas_resumen_anno';
$route['productos_clientes'] = 'C_dashboard/productos_clientes';
$route['productos_clientes_pdf/(:num)'] = 'C_dashboard/productos_clientes_pdf/$1';
$route['productos_anno'] = 'C_dashboard/productos_anno';
$route['productos_vendidos'] = 'C_dashboard/productos_vendidos';
$route['productos_vendidos_pdf/(:num)'] = 'C_dashboard/productos_vendidos_pdf/$1';
$route['productos_vendidos_anno'] = 'C_dashboard/productos_vendidos_anno';
$route['reposicion'] = 'C_dashboard/reposicion';
$route['reposicion_pdf'] = 'C_dashboard/reposicion_pdf';
$route['promociones'] = 'C_dashboard/promociones';
$route['promociones_rev'] = 'C_dashboard/promociones_rev';
$route['obtener_objetivos/(:any)/(:any)'] = 'C_dashboard/obtener_objetivos/$1/$2';
$route['obtener_conversion/(:any)/(:any)'] = 'C_dashboard/obtener_conversion/$1/$2';

$route['reporte_venta_pdf/(:num)'] = 'C_operaciones/reporte_venta_pdf/$1';
$route['cargar_historico/(:num)'] = 'C_operaciones/cargar_historico/$1';
$route['cargar_mision/(:num)'] = 'C_operaciones/cargar_mision/$1';

$route['codigopostal_municipio/(:num)'] = 'C_operaciones/codigopostal_municipio/$1';
$route['zonas_codigopostal/(:num)'] = 'C_operaciones/zonas_codigopostal/$1';
$route['datos_zonas/(:num)'] = 'C_operaciones/datos_zonas/$1';
$route['operativa_tipo_empresa/(:num)'] = 'C_operaciones/operativa_tipo_empresa/$1';
$route['actualizar_pedidos'] = 'C_operaciones/actualizar_pedidos';
$route['eliminar_pedidos'] = 'C_operaciones/eliminar_pedidos';
$route['agregar_pedidos'] = 'C_operaciones/agregar_pedidos';
$route['agregar_pedidos_cambio'] = 'C_operaciones/agregar_pedidos_cambio';
$route['agregar_pedidos_cambio1'] = 'C_operaciones/agregar_pedidos_cambio1';
$route['agregar_pedidos_cambio1_rev'] = 'C_operaciones/agregar_pedidos_cambio1_rev';
$route['ventas_ci/(:num)'] = 'C_operaciones/ventas_ci/$1';
$route['modificar_venta'] = 'C_operaciones/modificar_venta';
$route['eliminar_venta'] = 'C_operaciones/eliminar_venta';
$route['cargar_pack/(:any)'] = 'C_operaciones/cargar_pack/$1';

$route['reporte_ventas'] = 'C_operaciones/reporte_ventas';
$route['productos_mas_vendidos'] = 'C_operaciones/productos_mas_vendidos';
$route['productos_mas_vendidos_filtrado'] = 'C_operaciones/productos_mas_vendidos_filtrado';
$route['clientes_nuevos'] = 'C_operaciones/clientes_nuevos';
$route['reporte_venta_pantalla/(:any)/(:any)/(:any)'] = 'C_operaciones/reporte_venta_pantalla/$1/$2/$3';
$route['reporte_ventas_excell'] = 'C_operaciones/reporte_ventas_excell';
$route['exportar_mail'] = 'C_operaciones/exportar_mail';
$route['calculadora'] = 'C_operaciones/calculadora';
$route['recalcular/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)'] = 'C_operaciones/recalcular/$1/$2/$3/$4/$5/$6/$7';
$route['convenir/(:num)'] = 'C_operaciones/convenir/$1';
$route['definir_despacho/(:num)'] = 'C_operaciones/definir_despacho/$1';

/* LOCALIZACIÓN */
$route['productos_combo/(:any)'] = 'C_configuracion/productos_combo/$1';
$route['municipios_provincia/(:any)'] = 'C_configuracion/municipios_provincia/$1';
$route['municipios_provincia1/(:any)'] = 'C_registro/municipios_provincia1/$1';
$route['provincias_pais/(:any)'] = 'C_registro/provincias_pais/$1';

/* CLIENTES */
$route['clientes'] = 'C_configuracion/clientes';
$route['clientes_consultor'] = 'C_configuracion/clientes_consultor';
$route['clientes_observaciones'] = 'C_configuracion/clientes_observaciones';
$route['clientes_vip'] = 'C_configuracion/clientes_vip';
$route['clientes_filtrados'] = 'C_configuracion/clientes_filtrados';
$route['historial/(:num)'] = 'C_configuracion/historial/$1';
$route['clientes_consultor_filtrados'] = 'C_configuracion/clientes_consultor_filtrados';
$route['clientes_vip_filtrados'] = 'C_configuracion/clientes_vip_filtrados';
$route['nuevo_cliente'] = 'C_configuracion/nuevo_cliente';
$route['nuevo_cliente_vip'] = 'C_configuracion/nuevo_cliente_vip';
$route['editar_cliente/(:num)'] = 'C_configuracion/editar_cliente/$1';
$route['editar_cliente_vip/(:num)'] = 'C_configuracion/editar_cliente_vip/$1';
$route['cfe_cliente/(:num)'] = 'C_configuracion/cfe_cliente/$1';
$route['cfe_cliente_vip/(:num)'] = 'C_configuracion/cfe_cliente_vip/$1';
$route['cancelar_cliente'] = 'C_configuracion/cancelar_cliente';
$route['cancelar_cliente_vip'] = 'C_configuracion/cancelar_cliente_vip';
$route['modificar_cliente/(:num)'] = 'C_configuracion/modificar_cliente/$1';
$route['modificar_cliente_vip/(:num)'] = 'C_configuracion/modificar_cliente_vip/$1';
$route['registrar_cliente'] = 'C_configuracion/registrar_cliente';
$route['obtener_dni/(:any)'] = 'C_operaciones/obtener_dni/$1';
$route['obtener_clientes_filtrados/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)'] = 'C_operaciones/obt_clientes_filtrados/$1/$2/$3/$4/$5/$6';
$route['obtener_clientes_vip_filtrados/(:any)/(:any)/(:any)'] = 'C_operaciones/obt_clientes_vip_filtrados/$1/$2/$3';


/* MISIONES */
$route['misiones'] = 'C_configuracion/misiones';
$route['misiones_seguimientos_filtradas'] = 'C_configuracion/misiones_seguimientos_filtradas';
$route['misiones_propuestas'] = 'C_configuracion/misiones_propuestas';
$route['misiones_propuestas_filtradas'] = 'C_configuracion/misiones_propuestas_filtradas';
$route['misiones_vip'] = 'C_configuracion/misiones_vip';
$route['misiones_propuestas_vip'] = 'C_configuracion/misiones_propuestas_vip';
$route['misiones_propuestas_filtradas_vip'] = 'C_configuracion/misiones_propuestas_filtradas_vip';

$route['nueva_mision'] = 'C_configuracion/nueva_mision';
$route['nueva_mision_vip'] = 'C_configuracion/nueva_mision_vip';
$route['nueva_mision_propuesta/(:num)/(:num)'] = 'C_configuracion/nueva_mision_propuesta/$1/$2';
$route['nueva_mision_propuesta_vip/(:num)/(:num)'] = 'C_configuracion/nueva_mision_propuesta_vip/$1/$2';
$route['cartera_historial/(:num)'] = 'C_configuracion/cartera_historial/$1';
$route['cartera_historial1/(:num)'] = 'C_configuracion/cartera_historial1/$1';
$route['registrar_mision'] = 'C_configuracion/registrar_mision';
$route['registrar_mision_propuesta'] = 'C_operaciones/registrar_mision_propuesta';
$route['editar_mision/(:num)'] = 'C_configuracion/editar_mision/$1';
$route['modificar_mision/(:num)'] = 'C_configuracion/modificar_mision/$1';
$route['cfe_mision/(:num)'] = 'C_configuracion/cfe_mision/$1';
$route['eliminar_mision'] = 'C_configuracion/eliminar_mision';
$route['cancelar_mision/(:num)'] = 'C_configuracion/cancelar_mision/$1';
$route['obt_mision_seguimiento/(:num)'] = 'C_operaciones/obt_mision_seguimiento/$1';
$route['editar_mision_propuesta/(:num)'] = 'C_operaciones/editar_mision_propuesta/$1';
$route['modificar_mision_propuesta'] = 'C_operaciones/modificar_mision_propuesta';
$route['obtener_misiones/(:num)'] = 'C_operaciones/obtener_misiones/$1';
$route['obtener_productoscomprados/(:num)'] = 'C_operaciones/obtener_productoscomprados/$1';
$route['modificar_cliente_cartera'] = 'C_configuracion/modificar_cliente_cartera';
$route['modificar_cliente_cartera1'] = 'C_configuracion/modificar_cliente_cartera1';
$route['registrar_reclamos'] = 'C_configuracion/registrar_reclamos';
$route['registrar_llamame'] = 'C_configuracion/registrar_llamame';
$route['registrar_inactivo'] = 'C_configuracion/registrar_inactivo';
$route['registrar_notas_clientes'] = 'C_configuracion/registrar_notas_clientes';
$route['registrar_notas_clientes1'] = 'C_configuracion/registrar_notas_clientes1';
$route['registrar_notas_clientes_rev'] = 'C_configuracion/registrar_notas_clientes_rev';
$route['registrar_notas_clientes1_rev'] = 'C_configuracion/registrar_notas_clientes1_rev';
$route['registrar_reclamos1'] = 'C_configuracion/registrar_reclamos1';
$route['modificar_mision_cartera'] = 'C_configuracion/modificar_mision_cartera';
$route['cartera_realizo_cambio/(:num)/(:num)'] = 'C_configuracion/cartera_realizo_cambio/$1/$2';
$route['cartera_adicionar_producto/(:num)'] = 'C_configuracion/cartera_adicionar_producto/$1';
$route['obt_reclamos_seguimiento/(:num)'] = 'C_configuracion/obt_reclamos_seguimiento/$1';
$route['obt_reclamos_seguimiento1/(:num)/(:num)'] = 'C_configuracion/obt_reclamos_seguimiento1/$1/$2';
$route['nueva_nota_reclamo/(:num)'] = 'C_configuracion/nueva_nota_reclamo/$1';
$route['registrar_nota_reclamo'] = 'C_configuracion/registrar_nota_reclamo';
/* PRODUCTOS */
$route['nuevo_producto']            = 'C_configuracion/nuevo_producto';
$route['nuevo_combo']            = 'C_configuracion/nuevo_combo';
$route['productos']                 = 'C_configuracion/obt_productos';
$route['productos_rev']                 = 'C_configuracion/obt_productos_rev';
$route['combos_rev']                 = 'C_configuracion/obt_combos_rev';
$route['cancelar_producto_pais_rev']          = 'C_operaciones/cancelar_producto_pais_rev';
$route['cancelar_combo_pais_rev']          = 'C_operaciones/cancelar_combo_pais_rev';
$route['cancelar_factura_pais_rev']          = 'C_operaciones/cancelar_factura_pais_rev';
$route['agregar_producto_paises_rev']         = 'C_operaciones/agregar_producto_paises_rev';
$route['agregar_combo_paises_rev']         = 'C_operaciones/agregar_combo_paises_rev';
$route['agregar_factura_paises_rev']         = 'C_operaciones/agregar_factura_paises_rev';
$route['cfe_producto_pais_rev/(:num)/(:num)']   = 'C_operaciones/cfe_producto_pais_rev/$1/$2';
$route['cfe_combo_pais_rev/(:num)/(:num)']   = 'C_operaciones/cfe_combo_pais_rev/$1/$2';
$route['cfe_factura_pais_rev/(:num)/(:num)']   = 'C_operaciones/cfe_factura_pais_rev/$1/$2';
$route['obtener_existencia_producto_rev/(:num)']  = 'C_configuracion/obtener_existencia_producto_rev/$1';
$route['editar_producto/(:any)']    = 'C_configuracion/editar_producto/$1';
$route['editar_combo_rev/(:any)']    = 'C_configuracion/editar_combo_rev/$1';
$route['editar_producto_rev/(:any)']    = 'C_configuracion/editar_producto_rev/$1';
$route['cfe_producto/(:num)']       = 'C_configuracion/cfe_producto/$1';
$route['cancelar_producto']         = 'C_configuracion/cancelar_producto';
$route['modificar_producto/(:num)'] = 'C_configuracion/modificar_producto/$1';
$route['modificar_combo/(:num)'] = 'C_configuracion/modificar_combo/$1';
$route['modificar_producto_rev/(:num)'] = 'C_configuracion/modificar_producto_rev/$1';
$route['registrar_producto']        = 'C_configuracion/registrar_producto';
$route['registrar_combo']        = 'C_configuracion/registrar_combo';

$route['obtener_producto/(:num)']   = 'C_configuracion/obtener_producto/$1';
$route['obtener_productoint/(:num)']   = 'C_configuracion/obtener_productoint/$1';
$route['obtener_combo/(:num)']   = 'C_configuracion/obtener_combo/$1';
$route['ventas_locales']            = 'C_configuracion/ventas_locales';
$route['ventas_locales_filtro']     = 'C_configuracion/ventas_locales_filtro';

$route['editar_producto_colores/(:any)'] = 'C_configuracion/editar_producto_colores/$1';
$route['editar_combo_producto/(:any)'] = 'C_configuracion/editar_combo_producto/$1';
$route['eliminar_producto_color/(:num)/(:num)'] = 'C_configuracion/eliminar_producto_color/$1/$2';
$route['cfe_producto_color/(:num)/(:num)'] = 'C_configuracion/cfe_producto_color/$1/$2';
$route['cfe_combo_producto/(:num)/(:num)'] = 'C_configuracion/cfe_combo_producto/$1/$2';
$route['agregar_producto_color'] = 'C_configuracion/agregar_producto_color';
$route['agregar_combo_producto'] = 'C_configuracion/agregar_combo_producto';
$route['cancelar_producto_color'] = 'C_configuracion/cancelar_producto_color';
$route['cancelar_combo_producto'] = 'C_configuracion/cancelar_combo_producto';

$route['editar_producto_repuestos/(:any)'] = 'C_configuracion/editar_producto_repuestos/$1';
$route['eliminar_producto_repuesto/(:num)/(:num)'] = 'C_configuracion/eliminar_producto_repuesto/$1/$2';
$route['cfe_producto_repuesto/(:num)/(:num)'] = 'C_configuracion/cfe_producto_repuesto/$1/$2';
$route['agregar_producto_repuesto'] = 'C_configuracion/agregar_producto_repuesto';
$route['cancelar_producto_repuesto'] = 'C_configuracion/cancelar_producto_repuesto';
/* VENTAS */
$route['nueva_venta'] = 'C_operaciones/nueva_venta';
$route['nueva_venta_mision/(:any)/(:any)'] = 'C_operaciones/nueva_venta_mision/$1/$2';
$route['venta'] = 'C_operaciones/venta';
$route['nueva_venta_showroom'] = 'C_operaciones/nueva_venta_showroom';
$route['venta_showroom'] = 'C_operaciones/venta_showroom';
$route['nueva_venta_terceros'] = 'C_operaciones/nueva_venta_terceros';
$route['venta_terceros'] = 'C_operaciones/venta_terceros';

/* PEDIDOS */
$route['obtener_pedidos'] = 'C_operaciones/obtener_pedidos';
$route['obtener_pedidos_filtrado'] = 'C_operaciones/obtener_pedidos_filtrado';
$route['dashboard_armador_desp_filtro'] = 'C_dashboard/dashboard_armador_desp_filtro';
$route['dashboard_armador_desp_filtro_ok'] = 'C_dashboard/dashboard_armador_desp_filtro_ok';
$route['obtener_pedidos_filtrado_nombre'] = 'C_operaciones/obtener_pedidos_filtrado_nombre';
$route['obtener_pedidos_filtrado_ok'] = 'C_operaciones/obtener_pedidos_filtrado_ok';
$route['obtener_pedidos_pv'] = 'C_operaciones/obtener_pedidos_pv';
$route['obtener_pedidos_filtrado_pv'] = 'C_operaciones/obtener_pedidos_filtrado_pv';
$route['obtener_pedidos_filtrado_locales_pv'] = 'C_operaciones/obtener_pedidos_filtrado_locales_pv';
$route['obtener_pedidos_filtrado_nombre_pv'] = 'C_operaciones/obtener_pedidos_filtrado_nombre_pv';
$route['obtener_pedidos_filtrado_ok_pv'] = 'C_operaciones/obtener_pedidos_filtrado_ok_pv';
$route['pedidos'] = 'C_operaciones/pedidos';
$route['nuevo_pedido'] = 'C_operaciones/nuevo_pedido';
$route['registrar_pedido'] = 'C_operaciones/registrar_pedido';
$route['editar_pedido/(:any)'] = 'C_operaciones/editar_pedido/$1';
$route['modificar_pedido/(:any)'] = 'C_operaciones/modificar_pedido/$1';
$route['cfe_pedido/(:any)'] = 'C_operaciones/cfe_pedido/$1';
$route['cancelar_pedido'] = 'C_operaciones/cancelar_pedido';

/* DETALLES DE LOS PEDIDOS */
$route['detalles'] = 'C_operaciones/detalles';
$route['nuevo_detalle'] = 'C_operaciones/nuevo_detalle';
$route['registrar_detalle'] = 'C_operaciones/registrar_detalle';
$route['editar_detalle/(:num)/(:any)'] = 'C_operaciones/editar_detalle/$1/$2';
$route['modificar_detalle/(:num)/(:any)'] = 'C_operaciones/modificar_detalle/$1/$2';
$route['cfe_detalle/(:num)/(:any)'] = 'C_operaciones/cfe_detalle/$1/$2';
$route['cancelar_detalle'] = 'C_operaciones/cancelar_detalle';

/* ENTREGAS DIRECTAS */
$route['entregas_directas'] = 'C_operaciones/entregas_directas';
$route['nueva_entrega_directa'] = 'C_operaciones/nueva_entrega_directa';
$route['registrar_entrega_directa'] = 'C_operaciones/registrar_entrega_directa';
$route['editar_entrega_directa/(:num)'] = 'C_operaciones/editar_entrega_directa/$1';
$route['modificar_entrega_directa/(:num)'] = 'C_operaciones/modificar_entrega_directa/$1';
$route['cfe_entrega_directa/(:num)'] = 'C_operaciones/cfe_entrega_directa/$1';
$route['cancelar_entrega_directa'] = 'C_operaciones/cancelar_entrega_directa';

/* ENTREGAS POR TERCEROS */
$route['entregas_terceros'] = 'C_operaciones/entregas_terceros';
$route['entregas_terceros_ok'] = 'C_operaciones/entregas_terceros_ok';
$route['entregas_terceros_despachadores'] = 'C_operaciones/entregas_terceros_despachadores';
$route['nueva_entrega'] = 'C_operaciones/nueva_entrega_tercero';
$route['registrar_entrega_tercero'] = 'C_operaciones/registrar_entrega_tercero';
$route['cancelar_OrdenRetiro/(:any)'] = 'C_operaciones/cancelar_OrdenRetiro/$1';
$route['editar_entrega_tercero/(:any)/(:any)'] = 'C_operaciones/editar_entrega_tercero/$1/$2';
$route['etiqueta_entrega_tercero/(:any)'] = 'C_operaciones/etiqueta_entrega_tercero/$1';
$route['modificar_entrega_tercero'] = 'C_operaciones/modificar_entrega_tercero';
$route['despachar_gestion_pv'] = 'C_operaciones/despachar_gestion_pv';
$route['despachar_gestion'] = 'C_operaciones/despachar_gestion';
$route['cfe_entrega_tercero/(:any)/(:any)'] = 'C_operaciones/cfe_entrega_tercero/$1/$2';
$route['cancelar_entrega_tercero'] = 'C_operaciones/cancelar_entrega_tercero';
$route['dashboard_armador_desp'] = 'C_dashboard/dashboard_armador_desp';
$route['ejecutar_despacho/(:any)'] = 'C_operaciones/ejecutar_despacho/$1';
$route['ejecutar_despacho1'] = 'C_operaciones/ejecutar_despacho1';
$route['ejecutar_despacho1_rev'] = 'C_operaciones/ejecutar_despacho1_rev';
$route['ejecutar_despacho_showroom'] = 'C_operaciones/ejecutar_despacho_showroom';
/* ATENCIÓN */
//$route['v_at_0'] = 'C_configuracion/v_at_0';
//$route['v_at_1'] = 'C_configuracion/v_at_1';
//$route['v_at_2/(:any)'] = 'C_operaciones/v_at_2/$1';
//$route['v_at_3'] = 'C_operaciones/v_at_3';
//$route['registrar_venta'] = 'C_operaciones/registrar_venta';

/* EMPRESAS FLETE */
$route['nuevo_empresa'] = 'C_configuracion/nuevo_empresa';
$route['obt_empresas'] = 'C_configuracion/obt_empresas';
$route['obt_empresa/(:num)'] = 'C_configuracion/obt_empresa/$1';
$route['editar_empresa/(:num)'] = 'C_configuracion/editar_empresa/$1';
$route['cfe_empresa/(:num)'] = 'C_configuracion/cfe_empresa/$1';
$route['cancelar_empresa'] = 'C_configuracion/cancelar_empresa';
$route['modificar_empresa/(:num)'] = 'C_configuracion/modificar_empresa/$1';
$route['registrar_empresa'] = 'C_configuracion/registrar_empresa';

/* REVENDEDORES */
$route['nuevo_revendedor'] = 'C_configuracion/nuevo_revendedor';
$route['obt_revendedores'] = 'C_configuracion/obt_revendedores';
$route['editar_revendedor/(:num)'] = 'C_configuracion/editar_revendedor/$1';
$route['cfe_revendedor/(:any)/(:any)'] = 'C_configuracion/cfe_revendedor/$1/$2';
$route['cancelar_revendedor'] = 'C_configuracion/cancelar_revendedor';
$route['modificar_revendedor/(:num)'] = 'C_configuracion/modificar_revendedor/$1';
$route['registrar_revendedor'] = 'C_configuracion/registrar_revendedor';
$route['registrar_mail_revendedor'] = 'C_operaciones/registrar_mail_revendedor';
$route['solicitar_productos'] = 'C_operaciones/solicitar_productos';
$route['solicitar_productosint'] = 'C_operaciones/solicitar_productosint';
$route['solicitar_productos_desafio'] = 'C_operaciones/solicitar_productos_desafio';
$route['precio_revendedor'] = 'C_operaciones/precio_revendedor';
$route['perfil_rev'] = 'C_operaciones/perfil_rev';
$route['registrar_perfil_revendedor'] = 'C_operaciones/registrar_perfil_revendedor';

/* CONFIGURACIONES */
$route['nuevo_configuracion'] = 'C_configuracion/nuevo_configuracion';
$route['obt_configuraciones'] = 'C_configuracion/obt_configuraciones';
$route['editar_configuracion/(:any)'] = 'C_configuracion/editar_configuracion/$1';
$route['cfe_configuracion/(:any)'] = 'C_configuracion/cfe_configuracion/$1';
$route['cancelar_configuracion'] = 'C_configuracion/cancelar_configuracion';
$route['modificar_configuracion/(:any)'] = 'C_configuracion/modificar_configuracion/$1';
$route['registrar_configuracion'] = 'C_configuracion/registrar_configuracion';

/* CAUSAS DE MISIONES FALLIDAS */
$route['nuevo_causa_falla']             = 'C_configuracion/nuevo_causa_falla';
$route['obt_causa_fallas']              = 'C_configuracion/obt_causa_fallas';
$route['editar_causa_falla/(:any)']     = 'C_configuracion/editar_causa_falla/$1';
$route['cfe_causa_falla/(:any)']        = 'C_configuracion/cfe_causa_falla/$1';
$route['cancelar_causa_falla']          = 'C_configuracion/cancelar_causa_falla';
$route['modificar_causa_falla/(:any)']  = 'C_configuracion/modificar_causa_falla/$1';
$route['registrar_causa_falla']         = 'C_configuracion/registrar_causa_falla';
$route['registrar_mision_fallida']      = 'C_configuracion/registrar_mision_fallida';
$route['registrar_nuevo_hallazgo']      = 'C_configuracion/registrar_nuevo_hallazgo';
$route['hallazgos']                     = 'C_configuracion/hallazgos';

/* COLORES */
$route['nuevo_color']           = 'C_configuracion/nuevo_color';
$route['obt_colores']           = 'C_configuracion/obt_colores';
$route['editar_color/(:num)']   = 'C_configuracion/editar_color/$1';
$route['cfe_color/(:num)']      = 'C_configuracion/cfe_color/$1';
$route['cancelar_color']        = 'C_configuracion/cancelar_color';
$route['modificar_color/(:num)']= 'C_configuracion/modificar_color/$1';
$route['registrar_color']       = 'C_configuracion/registrar_color';

/* COSTOS ENVIO */
$route['nuevo_costo_env']           = 'C_configuracion/nuevo_costo';
$route['costos_env']           = 'C_configuracion/obt_costos';
$route['editar_costo_env/(:num)']   = 'C_configuracion/editar_costo/$1';
$route['cfe_costo_env/(:num)']      = 'C_configuracion/cfe_costo/$1';
$route['cancelar_costo_env']        = 'C_configuracion/cancelar_costo';
$route['modificar_costo_env/(:num)']= 'C_configuracion/modificar_costo/$1';
$route['registrar_costo_env']       = 'C_configuracion/registrar_costo';

/* TIPO DE CAMPAÑAS */
$route['nuevo_tipo_campana']           = 'C_configuracion/nuevo_tipo_campana';
$route['tipo_campanas']           		= 'C_configuracion/obt_tipo_campanas';
$route['editar_tipo_campana/(:num)']   = 'C_configuracion/editar_tipo_campana/$1';
$route['cfe_tipo_campana/(:num)']      = 'C_configuracion/cfe_tipo_campana/$1';
$route['cancelar_tipo_campana']        = 'C_configuracion/cancelar_tipo_campana';
$route['modificar_tipo_campana/(:num)']= 'C_configuracion/modificar_tipo_campana/$1';
$route['registrar_tipo_campana']       = 'C_configuracion/registrar_tipo_campana';

/* CAMPAÑAS */
$route['nuevo_campana'] = 'C_configuracion/nuevo_campana';
$route['campanas'] = 'C_configuracion/obt_campanas';
$route['editar_campana/(:num)'] = 'C_configuracion/editar_campana/$1';
$route['cfe_campana/(:num)'] = 'C_configuracion/cfe_campana/$1';
$route['cancelar_campana'] = 'C_configuracion/cancelar_campana';
$route['modificar_campana/(:num)'] = 'C_configuracion/modificar_campana/$1';
$route['registrar_campana'] = 'C_configuracion/registrar_campana';

$route['editar_campana_productos/(:any)'] = 'C_configuracion/editar_campana_productos/$1';
$route['eliminar_campana_productos/(:num)/(:num)'] = 'C_configuracion/eliminar_campana_producto/$1/$2';
$route['cfe_campana_producto/(:num)/(:num)'] = 'C_configuracion/cfe_campana_producto/$1/$2';
$route['agregar_campana_producto'] = 'C_configuracion/agregar_campana_producto';
$route['cancelar_campana_producto'] = 'C_configuracion/cancelar_campana_producto';

$route['nuevo_campana_rev'] = 'C_configuracion/nuevo_campana_rev';
$route['nuevo_desafio_mes'] = 'C_configuracion/nuevo_desafio_mes';
$route['campanas_rev'] = 'C_configuracion/obt_campanas_rev';
$route['desafio_mes'] = 'C_configuracion/desafio_mes';
$route['editar_campana_rev/(:num)'] = 'C_configuracion/editar_campana_rev/$1';
$route['editar_desafio_mes/(:num)'] = 'C_configuracion/editar_desafio_mes/$1';
$route['cfe_campana_rev/(:num)'] = 'C_configuracion/cfe_campana_rev/$1';
$route['cfe_desafio_mes/(:num)'] = 'C_configuracion/cfe_desafio_mes/$1';
$route['cancelar_campana_rev'] = 'C_configuracion/cancelar_campana_rev';
$route['cancelar_desafio_mes'] = 'C_configuracion/cancelar_desafio_mes';
$route['modificar_campana_rev/(:num)'] = 'C_configuracion/modificar_campana_rev/$1';
$route['modificar_desafio_mes/(:num)'] = 'C_configuracion/modificar_desafio_mes/$1';
$route['registrar_campana_rev'] = 'C_configuracion/registrar_campana_rev';
$route['registrar_desafio_mes'] = 'C_configuracion/registrar_desafio_mes';

$route['editar_campana_productos_rev/(:any)'] = 'C_configuracion/editar_campana_productos_rev/$1';
$route['editar_productos_precios_rev_int/(:any)'] = 'C_operaciones/editar_productos_precios_rev_int/$1';
$route['editar_combos_precios_rev_int/(:any)'] = 'C_operaciones/editar_combos_precios_rev_int/$1';
$route['eliminar_campana_productos_rev/(:num)/(:num)'] = 'C_configuracion/eliminar_campana_producto_rev/$1/$2';
$route['cfe_campana_producto_rev/(:num)/(:num)'] = 'C_configuracion/cfe_campana_producto_rev/$1/$2';
$route['agregar_campana_producto_rev'] = 'C_configuracion/agregar_campana_producto_rev';
$route['cancelar_campana_producto_rev'] = 'C_configuracion/cancelar_campana_producto_rev';

$route['editar_producto_desafio/(:any)'] = 'C_configuracion/editar_producto_desafio/$1';
$route['eliminar_producto_desafio/(:num)/(:num)'] = 'C_configuracion/producto_desafio/$1/$2';
$route['cfe_producto_desafio/(:num)/(:num)'] = 'C_configuracion/cfe_producto_desafio/$1/$2';
$route['agregar_producto_desafio'] = 'C_configuracion/agregar_producto_desafio';
$route['cancelar_producto_desafio'] = 'C_configuracion/cancelar_producto_desafio';

/* PAISES */
$route['nuevo_pais']           = 'C_configuracion/nuevo_pais';
$route['paises']           = 'C_configuracion/obt_paises';
$route['editar_pais/(:num)']   = 'C_configuracion/editar_pais/$1';
$route['cfe_pais/(:num)']      = 'C_configuracion/cfe_pais/$1';
$route['cancelar_pais']        = 'C_configuracion/cancelar_pais';
$route['modificar_pais/(:num)']= 'C_configuracion/modificar_pais/$1';
$route['registrar_pais']       = 'C_configuracion/registrar_pais';

/* PROVINCIAS */
$route['nuevo_provincia']           = 'C_configuracion/nuevo_provincia';
$route['provincias']           = 'C_configuracion/obt_provincias';
$route['editar_provincia/(:num)']   = 'C_configuracion/editar_provincia/$1';
$route['cfe_provincia/(:num)']      = 'C_configuracion/cfe_provincia/$1';
$route['cancelar_provincia']        = 'C_configuracion/cancelar_provincia';
$route['modificar_provincia/(:num)']= 'C_configuracion/modificar_provincia/$1';
$route['registrar_provincia']       = 'C_configuracion/registrar_provincia';

/* MUNICIPIOS */
$route['municipios/(:num)']           = 'C_configuracion/obt_municipios/$1';
$route['nuevo_municipio/(:num)']           = 'C_configuracion/nuevo_municipio/$1';
$route['registrar_municipio']       = 'C_configuracion/registrar_municipio';
$route['editar_municipio/(:num)']   = 'C_configuracion/editar_municipio/$1';
$route['cfe_municipio/(:num)/(:num)']      = 'C_configuracion/cfe_municipio/$1/$2';
$route['modificar_municipio/(:num)']= 'C_configuracion/modificar_municipio/$1';
$route['cancelar_municipio']        = 'C_configuracion/cancelar_municipio';

/* CARGAS */
$route['producto_colores/(:any)']  		= 'C_operaciones/producto_colores/$1';
$route['producto_campanas/(:any)'] 		= 'C_operaciones/producto_campanas/$1';
$route['producto_campanas_rev/(:any)'] 	= 'C_operaciones/producto_campanas_rev/$1';
$route['obt_color/(:any)']     			= 'C_configuracion/obt_color/$1';
$route['obt_tipo_factura/(:any)']    	= 'C_configuracion/obt_tipo_factura/$1';
$route['obt_campana/(:any)']     		= 'C_configuracion/obt_campana/$1';
$route['obt_campana_rev/(:any)']     		= 'C_configuracion/obt_campana_rev/$1';
$route['obtener_provincia/(:any)']     	= 'C_configuracion/obtener_provincia/$1';
$route['obtener_municipio/(:any)']     	= 'C_configuracion/obtener_municipio/$1';
$route['obtener_canal/(:any)']     		= 'C_configuracion/obtener_canal/$1';
$route['obt_empresa_tipo_empresa/(:any)'] = 'C_configuracion/obt_empresa_tipo_empresa/$1';
$route['obt_tipo_empresa/(:any)'] 		= 'C_configuracion/obt_tipo_empresa/$1';

/* ARMADO */
$route['armado'] = 'C_operaciones/obtener_armado';
$route['modificar_envio'] = 'C_operaciones/modificar_envio';
$route['modificar_envio1'] = 'C_operaciones/modificar_envio1';
$route['modificar_armado/(:any)'] = 'C_operaciones/modificar_armado/$1';
$route['modificar_armado_dash'] = 'C_operaciones/modificar_armado_dash';
$route['modificar_armado_showroom'] = 'C_operaciones/modificar_armado_showroom';
$route['editar_armado/(:any)'] = 'C_operaciones/editar_armado/$1';

/* TIPOS DE FACTURAS */
$route['nuevo_factura']           = 'C_configuracion/nuevo_factura';

$route['facturas']                = 'C_configuracion/obt_facturas';
$route['editar_factura/(:num)']   = 'C_configuracion/editar_factura/$1';
$route['cfe_factura/(:num)']      = 'C_configuracion/cfe_factura/$1';
$route['cancelar_factura']        = 'C_configuracion/cancelar_factura';
$route['modificar_factura/(:num)']= 'C_configuracion/modificar_factura/$1';
$route['registrar_factura']       = 'C_configuracion/registrar_factura';

$route['nuevo_factura_rev']           = 'C_configuracion/nuevo_factura_rev';
$route['editar_factura_rev/(:num)']   = 'C_configuracion/editar_factura_rev/$1';
$route['cfe_factura_rev/(:num)']      = 'C_configuracion/cfe_factura_rev/$1';
$route['cancelar_factura_rev']        = 'C_configuracion/cancelar_factura_rev';
$route['modificar_factura_rev/(:num)']= 'C_configuracion/modificar_factura_rev/$1';
$route['registrar_factura_rev']       = 'C_configuracion/registrar_factura_rev';


/* TIPOS DE OBJETIVOS */
$route['nuevo_tipo_objetivo']           = 'C_configuracion/nuevo_tipo_objetivo';
$route['tipos_objetivos']                = 'C_configuracion/obt_tipo_objetivos';
$route['editar_tipo_objetivo/(:num)']   = 'C_configuracion/editar_tipo_objetivo/$1';
$route['obtener_objetivo_consultor/(:num)']   = 'C_configuracion/obtener_objetivo_consultor/$1';
$route['cfe_tipo_objetivo/(:num)']      = 'C_configuracion/cfe_tipo_objetivo/$1';
$route['cancelar_tipo_objetivo']        = 'C_configuracion/cancelar_tipo_objetivo';
$route['modificar_tipo_objetivo/(:num)']= 'C_configuracion/modificar_tipo_objetivo/$1';
$route['registrar_tipo_objetivo']       = 'C_configuracion/registrar_tipo_objetivo';

/* OBJETIVOS */
$route['nuevo_objetivo']           = 'C_configuracion/nuevo_objetivo';
$route['objetivos']                = 'C_configuracion/obt_objetivos';
$route['editar_objetivo/(:num)']   = 'C_configuracion/editar_objetivo/$1';
$route['cfe_objetivo/(:num)']      = 'C_configuracion/cfe_objetivo/$1';
$route['cancelar_objetivo']        = 'C_configuracion/cancelar_objetivo';
$route['modificar_objetivo/(:num)']= 'C_configuracion/modificar_objetivo/$1';
$route['registrar_objetivo']       = 'C_configuracion/registrar_objetivo';

/* INGRESOS */
$route['mis_ingresos']            = 'C_operaciones/obt_ingresos_por_consultor';
$route['ingresos']                = 'C_operaciones/obt_ingresos_consultores';
$route['ingresos_resumen']        = 'C_operaciones/obt_ingresos_resumen';

/* IVA */
$route['nuevo_iva']           = 'C_configuracion/nuevo_iva';
$route['ivas']                = 'C_configuracion/obt_ivas';
$route['editar_iva/(:num)']   = 'C_configuracion/editar_iva/$1';
$route['cfe_iva/(:num)']      = 'C_configuracion/cfe_iva/$1';
$route['cancelar_iva']        = 'C_configuracion/cancelar_iva';
$route['modificar_iva/(:num)']= 'C_configuracion/modificar_iva/$1';
$route['registrar_iva']       = 'C_configuracion/registrar_iva';

/* CANALES */
$route['nuevo_canal']           = 'C_configuracion/nuevo_canal';
$route['canales']               = 'C_configuracion/obt_canales';
$route['editar_canal/(:num)']   = 'C_configuracion/editar_canal/$1';
$route['cfe_canal/(:num)']      = 'C_configuracion/cfe_canal/$1';
$route['cancelar_canal']        = 'C_configuracion/cancelar_canal';
$route['modificar_canal/(:num)']= 'C_configuracion/modificar_canal/$1';
$route['registrar_canal']       = 'C_configuracion/registrar_canal';

/* CANALES PRINCIPALES*/
$route['nuevo_canal_principal']             = 'C_configuracion/nuevo_canal_principal';
$route['canales_principales']               = 'C_configuracion/obt_canales_principal';
$route['editar_canal_principal/(:num)']     = 'C_configuracion/editar_canal_principal/$1';
$route['cfe_canal_principal/(:num)']        = 'C_configuracion/cfe_canal_principal/$1';
$route['cancelar_canal_principal']          = 'C_configuracion/cancelar_canal_principal';
$route['modificar_canal_principal/(:num)']  = 'C_configuracion/modificar_canal_principal/$1';
$route['registrar_canal_principal']         = 'C_configuracion/registrar_canal_principal';

$route['hallazgos_to_excell']       = 'C_operaciones/hallazgos_to_excell';

/* Niveles VIP */
$route['nuevo_nivel_vip']                   = 'C_configuracion/nuevo_nivel_vip';
$route['obt_nivel_vip']                     = 'C_configuracion/obt_nivel_vip';
$route['editar_nivel_vip/(:num)']           = 'C_configuracion/editar_nivel_vip/$1';
$route['cfe_nivel_vip/(:num)']              = 'C_configuracion/cfe_nivel_vip/$1';
$route['cancelar_nivel_vip']                = 'C_configuracion/cancelar_nivel_vip';
$route['modificar_nivel_vip/(:num)']        = 'C_configuracion/modificar_nivel_vip/$1';
$route['registrar_nivel_vip']               = 'C_configuracion/registrar_nivel_vip';
$route['obtener_nivel/(:num)']              = 'C_configuracion/obtener_nivel/$1';
$route['obtener_descuentovip_producto/(:num)/(:num)']  = 'C_configuracion/obtener_descuentovip_producto/$1/$2';


$route['editar_nivel_productos/(:any)'] = 'C_configuracion/editar_nivel_productos/$1';
$route['eliminar_nivel_productos/(:num)/(:num)'] = 'C_configuracion/eliminar_nivel_productos/$1/$2';
$route['cfe_nivel_productos/(:num)/(:num)'] = 'C_configuracion/cfe_nivel_productos/$1/$2';
$route['agregar_nivel_productos'] = 'C_configuracion/agregar_nivel_productos';
$route['cancelar_nivel_productos'] = 'C_configuracion/cancelar_nivel_productos';

/* OPERATIVAS */
$route['nuevo_operativa']           = 'C_configuracion/nuevo_operativa';
$route['operativas']                = 'C_configuracion/obt_operativas';
$route['obt_operativa/(:num)']          = 'C_configuracion/obt_operativa/$1';
$route['editar_operativa/(:num)']   = 'C_configuracion/editar_operativa/$1';
$route['cfe_operativa/(:num)']      = 'C_configuracion/cfe_operativa/$1';
$route['cancelar_operativa']        = 'C_configuracion/cancelar_operativa';
$route['modificar_operativa/(:num)']= 'C_configuracion/modificar_operativa/$1';
$route['registrar_operativa']       = 'C_configuracion/registrar_operativa';


/* SOLICITUDES DE BAJA */
$route['obt_solicitud_baja']           = 'C_configuracion/obt_solicitud_baja';
$route['edit_solicitud_baja/(:num)']   = 'C_configuracion/edit_solicitud_baja/$1';
$route['modificar_solicitud_baja/(:num)']   = 'C_configuracion/modificar_solicitud_baja/$1';

/* TIPOS DE PACK */
$route['nuevo_pack']           = 'C_configuracion/nuevo_pack';
$route['packs']                = 'C_configuracion/obt_packs';
$route['editar_pack/(:num)']   = 'C_configuracion/editar_pack/$1';
$route['cfe_pack/(:num)']      = 'C_configuracion/cfe_pack/$1';
$route['cancelar_pack']        = 'C_configuracion/cancelar_pack';
$route['modificar_pack/(:num)']= 'C_configuracion/modificar_pack/$1';
$route['registrar_pack']       = 'C_configuracion/registrar_pack';

$route['cantidad_max_paquetes/(:any)/(:any)/(:any)'] = 'C_operaciones/cantidad_max_paquetes/$1/$2/$3';
$route['configurar_paquetes/(:any)/(:any)/(:any)/(:any)'] = 'C_operaciones/configurar_paquetes/$1/$2/$3/$4';
$route['calcularPaquetes/(:any)/(:any)/(:any)/(:any)/(:any)'] = 'C_operaciones/calcularPaquetes/$1/$2/$3/$4/$5';
$route['crear_envio_oca'] = 'C_operaciones/crear_envio_oca';
$route['eliminar_detalles_envio_oca/(:any)'] = 'C_operaciones/eliminar_detalles_envio_oca/$1';
$route['crear_detalles_envio_oca/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)'] = 'C_operaciones/crear_detalles_envio_oca/$1/$2/$3/$4/$5/$6/$7/$8/$9';
$route['buscar_detalles_envio_oca/(:any)'] = 'C_operaciones/buscar_detalles_envio_oca/$1';
$route['cfg_envio_oca'] = 'C_operaciones/cfg_envio_oca';
$route['modificar_cfg_envio_oca'] = 'C_operaciones/modificar_cfg_envio_oca';
$route['recargar_oca/(:num)'] = 'C_operaciones/recargar_oca/$1';

/* FERIADOS */
$route['nuevo_feriado']           = 'C_configuracion/nuevo_feriado';
$route['feriados']               = 'C_configuracion/obt_feriados';
$route['editar_feriado/(:num)']   = 'C_configuracion/editar_feriado/$1';
$route['cfe_feriado/(:num)']      = 'C_configuracion/cfe_feriado/$1';
$route['cancelar_feriado']        = 'C_configuracion/cancelar_feriado';
$route['modificar_feriado/(:num)']= 'C_configuracion/modificar_feriado/$1';
$route['registrar_feriado']       = 'C_configuracion/registrar_feriado';

$route['cargar_fecha']          = 'C_operaciones/cargar_fecha';
$route['consultores_evaluacion']   = 'C_configuracion/consultores_evaluacion';
$route['consultor_evaluacion']   = 'C_configuracion/consultor_evaluacion';
$route['editar_consultor/(:num)']   = 'C_configuracion/editar_consultor/$1';
$route['modificar_consultor']   = 'C_configuracion/modificar_consultor';

$route['nuevo_local']           = 'C_configuracion/nuevo_local';
$route['locales']                = 'C_configuracion/locales';
$route['editar_local/(:num)']   = 'C_configuracion/editar_local/$1';
$route['cfe_local/(:num)']      = 'C_configuracion/cfe_local/$1';
$route['cancelar_local']        = 'C_configuracion/cancelar_local';
$route['modificar_local/(:num)']= 'C_configuracion/modificar_local/$1';
$route['registrar_local']       = 'C_configuracion/registrar_local';

/* SOLICITUDES DE BAJA */

$route['reportes']                      = 'C_dashboard/reportes';
$route['dashboard_revendedores']        = 'C_dashboard/dashboard_revendedores';
$route['dashboard_jefe_revendedores']   = 'C_dashboard/dashboard_jefe_revendedores';
$route['obtener_ventas_mlms/(:num)']    = 'C_dashboard/obtener_ventas_mlms/$1';
$route['obtener_transacciones/(:num)']  = 'C_dashboard/obtener_transacciones/$1';
$route['obtener_cartera_provincia']     = 'C_dashboard/obtener_cartera_provincia';
$route['obtener_cartera_buenos_aires']     = 'C_dashboard/obtener_cartera_buenos_aires';
$route['obtener_reclamos']              = 'C_dashboard/obtener_reclamos';
$route['obtener_detalles_consultores/(:num)'] = 'C_dashboard/obtener_detalles_consultores/$1';
$route['reclamos']                      = 'C_configuracion/reclamos';

/* REVENDEDORES */


$route['registrar_equivocado']            = 'C_operaciones/registrar_equivocado';
$route['registrar_cliente_rev']          = 'C_configuracion/registrar_cliente_rev';
$route['registrar_cliente_revInt']          = 'C_configuracion/registrar_cliente_revInt';
$route['consultor_rev']                     = 'C_operaciones/consultor_rev';

$route['clientes_consultor_rev']            = 'C_configuracion/clientes_consultor_rev';
$route['clientes_consultor_rev_filtrados']  = 'C_configuracion/clientes_consultor_rev_filtrados';
$route['clientes_consultor_revInt']            = 'C_configuracion/clientes_consultor_revInt';
$route['clientes_consultor_revInt_filtrados']  = 'C_configuracion/clientes_consultor_revInt_filtrados';
$route['nueva_venta_rev/(:num)']                   = 'C_operaciones/nueva_venta_rev/$1';
$route['nueva_venta_revint/(:num)']         = 'C_operaciones/nueva_venta_revint/$1';
$route['nueva_venta_mision_rev/(:num)/(:num)'] = 'C_operaciones/nueva_venta_mision_rev/$1/$2';
$route['venta_rev']                         = 'C_operaciones/venta_rev';
$route['venta_revint']                         = 'C_operaciones/venta_revint';
$route['obtener_pedidos_rev']               = 'C_operaciones/obtener_pedidos_rev';
$route['obtener_pedidos_revint']               = 'C_operaciones/obtener_pedidos_revint';
$route['obtener_pedidos_rev_filtrado']      = 'C_operaciones/obtener_pedidos_rev_filtrado';
$route['obtener_pedidos_rev_filtrado_nombre'] = 'C_operaciones/obtener_pedidos_rev_filtrado_nombre';
$route['obtener_pedidos_rev_filtrado_ok']   = 'C_operaciones/obtener_pedidos_rev_filtrado_ok';
$route['misiones_rev']                      = 'C_configuracion/misiones_rev';
$route['misiones_propuestas_rev']           = 'C_configuracion/misiones_propuestas_rev';
$route['misiones_propuestas_revint']           = 'C_configuracion/misiones_propuestas_revint';
$route['misiones_propuestas_rev_filtradas'] = 'C_configuracion/misiones_propuestas_rev_filtradas';
$route['misiones_propuestas_revint_filtradas'] = 'C_configuracion/misiones_propuestas_revint_filtradas';
$route['reportes_rev']                      = 'C_dashboard/reportes_rev';
$route['reportes_consultor']                = 'C_dashboard/reportes_consultor';
$route['reportes_consultores/(:num)']       = 'C_dashboard/reportes_consultores/$1';
$route['buscar_objetivo/(:num)/(:num)']     = 'C_dashboard/buscar_objetivo/$1/$2';
$route['buscar_objetivo1/(:num)/(:num)']     = 'C_dashboard/buscar_objetivo1/$1/$2';
$route['buscar_objetivo_puri/(:num)/(:num)']     = 'C_dashboard/buscar_objetivo_puri/$1/$2';
$route['buscar_objetivo_repu/(:num)/(:num)']     = 'C_dashboard/buscar_objetivo_repu/$1/$2';
$route['buscar_objetivo_aten/(:num)/(:num)']     = 'C_dashboard/buscar_objetivo_aten/$1/$2';
$route['buscar_objetivo_misi/(:num)/(:num)']     = 'C_dashboard/buscar_objetivo_misi/$1/$2';
$route['actualizar_objetivo/(:num)/(:num)/(:num)']     = 'C_dashboard/actualizar_objetivo/$1/$2/$3';
$route['actualizar_objetivo1/(:num)/(:num)/(:num)']     = 'C_dashboard/actualizar_objetivo1/$1/$2/$3';
$route['actualizar_objetivo_puri/(:num)/(:num)/(:num)']     = 'C_dashboard/actualizar_objetivo_puri/$1/$2/$3';
$route['actualizar_objetivo_repu/(:num)/(:num)/(:num)']     = 'C_dashboard/actualizar_objetivo_repu/$1/$2/$3';
$route['actualizar_objetivo_aten/(:num)/(:num)/(:num)']     = 'C_dashboard/actualizar_objetivo_aten/$1/$2/$3';
$route['actualizar_objetivo_misi/(:num)/(:num)/(:num)']     = 'C_dashboard/actualizar_objetivo_misi/$1/$2/$3';
$route['reportes_jrev']                     = 'C_dashboard/reportes_jrev';
$route['cartera_historial_rev/(:num)']      = 'C_configuracion/cartera_historial_rev/$1';
$route['cartera_historial1_rev/(:num)']     = 'C_configuracion/cartera_historial1_rev/$1';
$route['modificar_cliente_cartera_rev']     = 'C_configuracion/modificar_cliente_cartera_rev';
$route['modificar_cliente_cartera1_rev']    = 'C_configuracion/modificar_cliente_cartera1_rev';
$route['registrar_reclamos_rev']            = 'C_configuracion/registrar_reclamos_rev';
$route['registrar_reclamos1_rev']           = 'C_configuracion/registrar_reclamos1_rev';
$route['modificar_mision_cartera_rev']      = 'C_configuracion/modificar_mision_cartera_rev';
$route['cartera_realizo_cambio_rev/(:num)/(:num)'] = 'C_configuracion/cartera_realizo_cambio_rev/$1/$2';
$route['cartera_adicionar_producto_rev/(:num)'] = 'C_configuracion/cartera_adicionar_producto_rev/$1';
$route['obt_mision_seguimiento_rev/(:num)'] = 'C_operaciones/obt_mision_seguimiento_rev/$1';
$route['cancelar_mision_rev/(:num)']        = 'C_configuracion/cancelar_mision_rev/$1';
$route['cobrado_rev/(:num)']                = 'C_operaciones/cobrado_rev/$1';
$route['cobrado_revint']                = 'C_operaciones/cobrado_revint';
$route['entregado_rev/(:num)']              = 'C_operaciones/entregado_rev/$1';
$route['entregado_revint']              = 'C_operaciones/entregado_revint';
$route['obtener_ventas_am/(:num)']          = 'C_dashboard/obtener_ventas_am/$1';
$route['obtener_cartera_provincia_rev']     = 'C_dashboard/obtener_cartera_provincia_rev';
$route['alta_revendedor']                   = 'C_operaciones/alta_revendedor';
$route['ver_perfil_rev/(:num)']             = 'C_operaciones/ver_perfil_rev/$1';
$route['ver_orden/(:num)']             = 'C_operaciones/ver_orden/$1';
$route['ver_ordenint/(:num)']             = 'C_operaciones/ver_ordenint/$1';
$route['stock_rev']             = 'C_operaciones/stock_rev';
$route['stock_revint']             = 'C_operaciones/stock_revint';
$route['modificar_existencia_producto']             = 'C_operaciones/modificar_existencia_producto';
$route['modificar_existencia_productoint']             = 'C_operaciones/modificar_existencia_productoint';
$route['modificar_precio_producto']             = 'C_operaciones/modificar_precio_producto';
$route['seguimiento_oca/(:any)/(:any)']             = 'C_operaciones/seguimiento_oca/$1/$2';

$route['registro_nuevo_revendedor/(:any)/(:any)']  = 'C_registro/registro_nuevo_revendedor/$1/$2';
$route['activacion_revendedor/(:any)/(:any)']      = 'C_registro/activacion_revendedor/$1/$2';
$route['activar_revendedor/(:any)/(:any)']         = 'C_registro/activar_revendedor/$1/$2';
$route['agregar_orden']                            = 'C_operaciones/agregar_orden';
$route['agregar_ordenint']                            = 'C_operaciones/agregar_ordenint';
$route['informacion']                              = 'C_registro/informacion';
$route['ordenes']                                  = 'C_operaciones/obt_ordenes';
$route['ordenesint']                                  = 'C_operaciones/obt_ordenesint';
$route['frecuencia_compras']                       = 'C_dashboard/frecuencia_compras';

$route['dashboard_jefe_produccion']             = 'C_dashboard/dashboard_jefe_produccion';
$route['dashboard_jefe_produccion_filtro']      = 'C_dashboard/dashboard_jefe_produccion_filtro';
$route['dashboard_jefe_produccion_filtro_excell']      = 'C_dashboard/dashboard_jefe_produccion_filtro_excell';
$route['dashboard_jefe_produccion_ventas']      = 'C_dashboard/dashboard_jefe_produccion_ventas';
$route['obtener_armado/(:any)/(:any)']          = 'C_dashboard/obtener_armado/$1/$2';
$route['obtener_vt_cantidad/(:any)/(:any)/(:any)']= 'C_dashboard/obtener_vt_cantidad/$1/$2/$3';
$route['obtener_vt_cantidad1/(:any)/(:any)/(:any)']= 'C_dashboard/obtener_vt_cantidad1/$1/$2/$3';
$route['obtener_vt_pesos/(:any)/(:any)']= 'C_dashboard/obtener_vt_pesos/$1/$2';
$route['obtener_misiones_diaria/(:any)/(:any)/(:any)']= 'C_dashboard/obtener_misiones_diaria/$1/$2/$3';
$route['obtener_misiones_diaria_tv/(:any)/(:any)/(:any)']= 'C_dashboard/obtener_misiones_diaria_tv/$1/$2/$3';
$route['obtener_llamadas_atencion/(:any)/(:any)']= 'C_dashboard/obtener_llamadas_atencion/$1/$2';
$route['obtener_llamadas_mision/(:any)/(:any)']  = 'C_dashboard/obtener_llamadas_mision/$1/$2';
$route['obtener_obj_purificadores/(:any)/(:any)']= 'C_dashboard/obtener_obj_purificadores/$1/$2';
$route['obtener_obj_repuestos/(:any)/(:any)']   = 'C_dashboard/obtener_obj_repuestos/$1/$2';
$route['obtener_obj_mision_pesos/(:any)/(:any)']= 'C_dashboard/obtener_obj_mision_pesos/$1/$2';
$route['obtener_llamadas_mision1/(:any)/(:any)']  = 'C_dashboard/obtener_llamadas_mision1/$1/$2';
$route['obtener_obj_purificadores1/(:any)/(:any)']= 'C_dashboard/obtener_obj_purificadores1/$1/$2';
$route['obtener_obj_repuestos1/(:any)/(:any)']   = 'C_dashboard/obtener_obj_repuestos1/$1/$2';
$route['obtener_obj_mision_pesos1/(:any)/(:any)']= 'C_dashboard/obtener_obj_mision_pesos1/$1/$2';
$route['obtener_reclamos_usuario']      = 'C_dashboard/obtener_reclamos_usuario';
$route['obtener_reclamos_usuario_rodo']      = 'C_dashboard/obtener_reclamos_usuario_rodo';
$route['obtener_reclamos_usuario1/(:any)']  = 'C_dashboard/obtener_reclamos_usuario1/$1';
$route['obtener_despacho/(:any)/(:any)']        = 'C_dashboard/obtener_despacho/$1/$2';
$route['obtener_canal_pedido/(:any)/(:any)']    = 'C_dashboard/obtener_canal_pedido/$1/$2';
$route['dashboard_jefe_produccion_ventas_filtro']  = 'C_dashboard/dashboard_jefe_produccion_ventas_filtro';
$route['obt_evaluacion']                        = 'C_operaciones/obt_evaluacion';

$route['editar_evaluacion_consultor/(:any)/(:any)/(:any)'] = 'C_configuracion/editar_evaluacion_consultor/$1/$2/$3';
$route['editar_evaluacion_consultor1/(:any)/(:any)/(:any)'] = 'C_configuracion/editar_evaluacion_consultor1/$1/$2/$3';
$route['cfe_evaluacion_consultor/(:num)/(:num)/(:num)/(:num)'] = 'C_configuracion/cfe_evaluacion_consultor/$1/$2/$3/$4';
$route['agregar_evaluacion_consultor'] = 'C_configuracion/agregar_evaluacion_consultor';
$route['cancelar_evaluacion_consultor'] = 'C_configuracion/cancelar_evaluacion_consultor';
$route['obtener_evaluacion_desempeno/(:any)'] = 'C_dashboard/obtener_evaluacion_desempeno/$1';
$route['obtener_evaluacion_desempeno_ind/(:any)/(:any)'] = 'C_dashboard/obtener_evaluacion_desempeno_ind/$1/$2';

$route['politicas_comerciales']                 = 'C_operaciones/politicas_comerciales';
$route['editar_control_politica/(:any)']        = 'C_operaciones/editar_control_politica/$1';
$route['modificar_control_politica']            = 'C_operaciones/modificar_control_politica';
$route['control_crediticio']                    = 'C_operaciones/control_crediticio';
$route['editar_control_crediticio/(:any)']      = 'C_operaciones/editar_control_crediticio/$1';
$route['modificar_control_crediticio']          = 'C_operaciones/modificar_control_crediticio';
$route['control_stock']                         = 'C_operaciones/control_stock';
$route['editar_control_stock/(:any)']           = 'C_operaciones/editar_control_stock/$1';
$route['modificar_control_stock']               = 'C_operaciones/modificar_control_stock';

$route['control_facturacion']                   = 'C_operaciones/control_facturacion';
$route['editar_control_facturacion/(:any)']     = 'C_operaciones/editar_control_facturacion/$1';
$route['editar_control_facturacion_pdf/(:any)'] = 'C_operaciones/editar_control_facturacion_pdf/$1';
$route['modificar_control_facturacion']         = 'C_operaciones/modificar_control_facturacion';
$route['control_acreditaciones']                = 'C_operaciones/control_acreditaciones';
$route['editar_control_acreditaciones/(:any)']  = 'C_operaciones/editar_control_acreditaciones/$1';
$route['modificar_control_acreditaciones']      = 'C_operaciones/modificar_control_acreditaciones';
$route['control_despachos']                     = 'C_operaciones/control_despachos';
$route['editar_control_despachos/(:any)']       = 'C_operaciones/editar_control_despachos/$1';
$route['modificar_control_despachos']           = 'C_operaciones/modificar_control_despachos';
$route['control_remitos']                       = 'C_operaciones/control_remitos';
$route['editar_control_remitos/(:any)']         = 'C_operaciones/editar_control_remitos/$1';
$route['modificar_control_remitos']             = 'C_operaciones/modificar_control_remitos';
$route['control_pagos']                         = 'C_operaciones/control_pagos';
$route['editar_control_pagos/(:any)']           = 'C_operaciones/editar_control_pagos/$1';
$route['modificar_control_pagos']               = 'C_operaciones/modificar_control_pagos';
$route['control_backup']                        = 'C_operaciones/control_backup';
$route['editar_control_backup/(:any)']           = 'C_operaciones/editar_control_backup/$1';
$route['control_flujo/(:any)']                  = 'C_operaciones/control_flujo/$1';
$route['control_ordenes']                       = 'C_operaciones/control_ordenes';
$route['obtener_notificaciones/(:any)']         = 'C_operaciones/obtener_notificaciones/$1';
$route['obtener_notificaciones1']         = 'C_operaciones/obtener_notificaciones1';
$route['obtener_todas_notificaciones/(:any)']   = 'C_operaciones/obtener_todas_notificaciones/$1';
$route['nueva_notificacion']                    = 'C_operaciones/nueva_notificacion';
$route['registrar_notificacion']                = 'C_operaciones/registrar_notificacion';
$route['modificar_notificacion/(:any)']         = 'C_operaciones/modificar_notificacion/$1';
$route['editar_notificacion/(:any)']            = 'C_operaciones/editar_notificacion/$1';
$route['subir_excell']                          = 'C_operaciones/subir_excell';
$route['subir_imagen_combo/(:any)']                    = 'C_operaciones/subir_imagen_combo/$1';
$route['to_mysql']                              = 'C_operaciones/to_mysql';
$route['subir_excell_rev']                      = 'C_operaciones/subir_excell_rev';
$route['to_mysql_rev']                          = 'C_operaciones/to_mysql_rev';
$route['carga_clientes']                        = 'C_operaciones/carga_clientes';
$route['carga_productos']                       = 'C_operaciones/carga_productos';
$route['chequear_carga_oca']                    = 'C_registro/chequear_carga_oca';

$route['nuevo_iva_rev']                     = 'C_configuracion/nuevo_iva_rev';
$route['iva_rev']                           = 'C_configuracion/iva_rev';
$route['registrar_iva_rev']                 = 'C_configuracion/registrar_iva_rev';
$route['cancelar_iva_rev']                  = 'C_configuracion/cancelar_iva_rev';
$route['facturas_rev']                      = 'C_configuracion/facturas_rev';
$route['editar_iva_rev/(:any)']             = 'C_configuracion/editar_iva_rev/$1';
$route['cfe_iva_rev/(:num)']                = 'C_configuracion/cfe_iva_rev/$1';
$route['modificar_iva_rev/(:num)']          = 'C_configuracion/modificar_iva_rev/$1';

$route['editar_factura_rev_int/(:any)']     = 'C_operaciones/editar_factura_rev_int/$1';

//Produccion
$route['tipos']                             = 'C_produccion/obt_tipos';
$route['nuevo_tipo']                        = 'C_produccion/nuevo_tipo';
$route['cancelar_tipo']                     = 'C_produccion/cancelar_tipo';
$route['registrar_tipo']                    = 'C_produccion/registrar_tipo';
$route['modificar_tipo/(:num)']             = 'C_produccion/modificar_tipo/$1';
$route['editar_tipo/(:num)']                = 'C_produccion/editar_tipo/$1';
$route['cfe_tipo/(:num)']                   = 'C_produccion/cfe_tipo/$1';

$route['subtipos']                             = 'C_produccion/obt_subtipos';
$route['nuevo_subtipo']                        = 'C_produccion/nuevo_subtipo';
$route['cancelar_subtipo']                     = 'C_produccion/cancelar_subtipo';
$route['registrar_subtipo']                    = 'C_produccion/registrar_subtipo';
$route['modificar_subtipo/(:num)']             = 'C_produccion/modificar_subtipo/$1';
$route['editar_subtipo/(:num)']                = 'C_produccion/editar_subtipo/$1';
$route['cfe_subtipo/(:num)']                   = 'C_produccion/cfe_subtipo/$1';

$route['tipocambios']                             = 'C_produccion/obt_tipocambios';
$route['nuevo_tipocambio']                        = 'C_produccion/nuevo_tipocambio';
$route['cancelar_tipocambio']                     = 'C_produccion/cancelar_tipocambio';
$route['registrar_tipocambio']                    = 'C_produccion/registrar_tipocambio';
$route['modificar_tipocambio/(:num)']             = 'C_produccion/modificar_tipocambio/$1';
$route['editar_tipocambio/(:num)']                = 'C_produccion/editar_tipocambio/$1';
$route['cfe_tipocambio/(:num)']                   = 'C_produccion/cfe_tipocambio/$1';

$route['detalletipocambios']                             = 'C_produccion/obt_detalletipocambios';
$route['nuevo_detalletipocambio']                        = 'C_produccion/nuevo_detalletipocambio';
$route['cancelar_detalletipocambio']                     = 'C_produccion/cancelar_detalletipocambio';
$route['registrar_detalletipocambio']                    = 'C_produccion/registrar_detalletipocambio';
$route['modificar_detalletipocambio/(:num)']             = 'C_produccion/modificar_detalletipocambio/$1';
$route['editar_detalletipocambio/(:num)']                = 'C_produccion/editar_detalletipocambio/$1';
$route['cfe_detalletipocambio/(:num)']                   = 'C_produccion/cfe_detalletipocambio/$1';

$route['detalletipocambios']                             = 'C_produccion/obt_detalletipocambios';
$route['nuevo_detalletipocambio']                        = 'C_produccion/nuevo_detalletipocambio';
$route['cancelar_detalletipocambio']                     = 'C_produccion/cancelar_detalletipocambio';
$route['registrar_detalletipocambio']                    = 'C_produccion/registrar_detalletipocambio';
$route['modificar_detalletipocambio/(:num)']             = 'C_produccion/modificar_detalletipocambio/$1';
$route['editar_detalletipocambio/(:num)']                = 'C_produccion/editar_detalletipocambio/$1';
$route['cfe_detalletipocambio/(:num)']                   = 'C_produccion/cfe_detalletipocambio/$1';

$route['componentes']                                   = 'C_produccion/componentes';
$route['nuevo_componente']                              = 'C_produccion/nuevo_componente';
$route['cancelar_componente']                           = 'C_produccion/cancelar_componente';
$route['registrar_componente']                          = 'C_produccion/registrar_componente';
$route['modificar_componente/(:num)']                   = 'C_produccion/modificar_componente/$1';
$route['editar_componente/(:num)']                      = 'C_produccion/editar_componente/$1';
$route['cfe_componente/(:num)']                         = 'C_produccion/cfe_componente/$1';

$route['editar_componente_compras/(:num)']                = 'C_produccion/editar_componente_compras/$1';
$route['agregar_componente_compras']                      = 'C_produccion/agregar_componente_compras';
$route['cfe_componente_compras/(:num)/(:num)']            = 'C_produccion/cfe_componente_compras/$1/$2';
$route['cancelar_componente_compras']                     = 'C_produccion/cancelar_componente_compras';

$route['p_categorias']                             = 'C_produccion/p_categorias';
$route['nuevo_p_categoria']                        = 'C_produccion/nuevo_p_categoria';
$route['cancelar_p_categoria']                     = 'C_produccion/cancelar_p_categoria';
$route['registrar_p_categoria']                    = 'C_produccion/registrar_p_categoria';
$route['modificar_p_categoria/(:num)']             = 'C_produccion/modificar_p_categoria/$1';
$route['editar_p_categoria/(:num)']                = 'C_produccion/editar_p_categoria/$1';
$route['cfe_p_categoria/(:num)']                   = 'C_produccion/cfe_p_categoria/$1';

$route['p_productos']                             = 'C_produccion/p_productos';
$route['nuevo_p_producto']                        = 'C_produccion/nuevo_p_producto';
$route['cancelar_p_producto']                     = 'C_produccion/cancelar_p_producto';
$route['registrar_p_producto']                    = 'C_produccion/registrar_p_producto';
$route['modificar_p_producto/(:num)']             = 'C_produccion/modificar_p_producto/$1';
$route['editar_p_producto/(:num)']                = 'C_produccion/editar_p_producto/$1';
$route['cfe_p_producto/(:num)']                   = 'C_produccion/cfe_p_producto/$1';

$route['almacenes']                            = 'C_produccion/almacenes';
$route['nuevo_almacen']                        = 'C_produccion/nuevo_almacen';
$route['cancelar_almacen']                     = 'C_produccion/cancelar_almacen';
$route['registrar_almacen']                    = 'C_produccion/registrar_almacen';
$route['modificar_almacen/(:num)']             = 'C_produccion/modificar_almacen/$1';
$route['editar_almacen/(:num)']                = 'C_produccion/editar_almacen/$1';
$route['cfe_almacen/(:num)']                   = 'C_produccion/cfe_almacen/$1';

$route['ums']                               = 'C_produccion/ums';
$route['nuevo_um']                          = 'C_produccion/nuevo_um';
$route['cancelar_um']                       = 'C_produccion/cancelar_um';
$route['registrar_um']                      = 'C_produccion/registrar_um';
$route['modificar_um/(:num)']               = 'C_produccion/modificar_um/$1';
$route['editar_um/(:num)']                  = 'C_produccion/editar_um/$1';
$route['cfe_um/(:num)']                     = 'C_produccion/cfe_um/$1';

$route['editar_producto_asociados/(:num)/(:num)']     = 'C_produccion/editar_producto_asociados/$1/$2';
$route['agregar_producto_asociados']                  = 'C_produccion/agregar_producto_asociados';
$route['cfe_producto_asociados/(:num)/(:num)/(:num)']        = 'C_produccion/cfe_producto_asociados/$1/$2/$3';
$route['cancelar_producto_asociados']                 = 'C_produccion/cancelar_producto_asociados';

$route['editar_almacen_productos/(:num)']                = 'C_produccion/editar_almacen_productos/$1';
$route['agregar_almacen_productos']                      = 'C_produccion/agregar_almacen_productos';
$route['cfe_almacen_productos/(:num)/(:num)']            = 'C_produccion/cfe_almacen_productos/$1/$2';
$route['cancelar_almacen_productos']                     = 'C_produccion/cancelar_almacen_productos';

$route['inventario']                            = 'C_produccion/inventario';
$route['movimiento']                            = 'C_produccion/movimiento';
$route['mover_producto']                        = 'C_produccion/mover_producto';
$route['entrar_producto']                       = 'C_produccion/entrar_producto';
$route['ensamblar_producto']                    = 'C_produccion/ensamblar_producto';
$route['ver_movimientos']                       = 'C_produccion/ver_movimientos';

$route['costos']                             = 'C_produccion/costos';
$route['nuevo_costo']                        = 'C_produccion/nuevo_costo';
$route['cancelar_costo']                     = 'C_produccion/cancelar_costo';
$route['registrar_costo']                    = 'C_produccion/registrar_costo';
$route['modificar_costo']             = 'C_produccion/modificar_costo';
$route['editar_costo/(:num)']                = 'C_produccion/editar_costo/$1';
$route['cfe_costo/(:num)']                   = 'C_produccion/cfe_costo/$1';

$route['editar_costo_componentes/(:num)']      = 'C_produccion/editar_costo_componentes/$1';
$route['agregar_costo_componentes']            = 'C_produccion/agregar_costo_componentes';
$route['cfe_costo_componentes/(:num)/(:num)']  = 'C_produccion/cfe_costo_componentes/$1/$2';
$route['cancelar_costo_componentes']           = 'C_produccion/cancelar_costo_componentes';

$route['mls']                               = 'C_produccion/mls';
$route['nuevo_ml']                          = 'C_produccion/nuevo_ml';
$route['cancelar_ml']                       = 'C_produccion/cancelar_ml';
$route['registrar_ml']                      = 'C_produccion/registrar_ml';
$route['modificar_ml/(:num)']               = 'C_produccion/modificar_ml/$1';
$route['editar_ml/(:num)']                  = 'C_produccion/editar_ml/$1';
$route['cfe_ml/(:num)']                     = 'C_produccion/cfe_ml/$1';

$route['historico']                              = 'C_produccion/historico';
