<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . '/libraries/REST_Controller.php';


class Usuario extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('usuario_model');

    }

    public function index_get()
    {
        $usuario = $this->usuario_model->get();

        if (!is_null($usuario)) {
            $this->response(array('response' => $usuario), 200);
        } else {
            $this->response(array('error' => 'No hay usuarios en la base de datos...'), 404);
        }
    }
}    