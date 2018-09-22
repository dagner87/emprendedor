<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_cron extends CI_Model {
    
		
    public function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
	
	public function vencimientos_alertas(){		
		$texto_consulta = "select * from view_misiones_propuestas_agrupadas where id_cliente not in (select id_cliente from envios_mail where fecha_envio=curdate());";
		$resultado = $this->db->query($texto_consulta);
	    if (!$resultado)
			echo $resultado;
		
		return $resultado;
	}
	
	
	
}
?>