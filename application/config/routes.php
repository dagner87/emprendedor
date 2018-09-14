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
//-------Perfiles--------------------------
$route['MyperfilAdmin'] = "panel_admin/MyperfilAdmin";
$route['my_perfil'] = "capacitacion/Myperfil";