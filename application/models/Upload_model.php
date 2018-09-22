<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Upload_model extends CI_Model {

    public function construct() {
        parent::__construct();
    }
    
    //FUNCIÓN PARA INSERTAR LOS DATOS DE LA IMAGEN SUBIDA
    function subir($id_user_foto,$titulo,$imagen)
    {
        $data = array(
		    'id_user_foto' => $id_user_foto,
            'titulo' => $titulo,
            'ruta' => $imagen
        );
        return $this->db->insert('imagenes', $data);
    }
	
	function modificar($id_user_foto,$titulo,$imagen)
    {
        $data = array(
		    'titulo' => $titulo,
            'ruta' => $imagen
        );
		$this->db->where('id_user_foto',$id_user_foto);
        return $this->db->update('imagenes', $data);
    }
	
	function tomar_foto($id_user_foto)
    {
        $this->db->where('id_user_foto',$id_user_foto);
		$query = $this->db->get('imagenes');
		return $query->row();		
    }
}
?>