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

//-------Cartera clientes--------------------------
$route['cartera_clientes'] = "capacitacion/cartera_clientes";

//-------Historial cliente--------------------------
$route['historial_cliente'] = "capacitacion/historial_cliente";
$route['historial_cliente/(:num)'] = "capacitacion/historial_cliente/$1";

//-------Almacen--------------------------
$route['almacen'] = "capacitacion/almacen";
$route['almacen/(:num)'] = "capacitacion/almacen/$1";

//-------ventas--------------------------
$route['ventas'] = "capacitacion/ventas";
$route['ventas/(:num)'] = "capacitacion/ventas/$1";

/*-------------------------------------------------*/
