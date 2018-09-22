<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_seguridad extends CI_Model {
    //*******************************************************************************************************
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
	//*******************************************************************************************************
 	function VerificarUsuario( $usuario, $clave )
	{
	    $texto_consulta = "SELECT u.id_usuario, u.nombre_completo, u.id_grupo, g.nombre as nombre_grupo
		                   FROM usuarios u
						   INNER JOIN grupos g ON (u.id_grupo = g.id_grupo)
		                   WHERE ( u.id_usuario = '$usuario' and u.clave = '$clave');";
						   
						   
		$resultado = $this->db->query($texto_consulta);
		return $resultado;
	}
	//*******************************************************************************************************
	// Verificar que un usuario pertenece al sistema
	function CambiarClave($usuario, $clave, $clave_nueva)
	{
	    $texto_consulta = "update usuarios
		  		           set usuarios.clave = '$clave_nueva'
		                   where (  usuarios.idusuario = '$usuario' );";
		
		$resultado = $this->db->query($texto_consulta);
		return $this->db->affected_rows();
	}
	//*******************************************************************************************************
	// Obtener grupos
	function ObtenerGrupos()
	{
	    $texto_consulta = "select *
		                   from grupos; ";
		
		$resultado = $this->db->query($texto_consulta);
		return $resultado;
	}
	//*******************************************************************************************************
	// Obtener grupos
	function ObtenerUsuarios()
	{
	    $texto_consulta = "select idusuario, nombre, usuarios.idgrupo, grupos.descripcion
		                  from usuarios, grupos
		                  where (usuarios.idgrupo = grupos.idgrupo);";
		$resultado = $this->db->query($texto_consulta);
		return $resultado;
	}
	//*******************************************************************************************************
	// Obtener grupos
	function ObtenerUsuario($idusuario)
	{
	    $texto_consulta = "select *
		                  from usuarios
		                  where (idusuario = '$idusuario');";
						  
		$resultado = $this->db->query($texto_consulta);
	
		return $resultado;
	}
	//*******************************************************************************************************
	// Registrar usuario
	function RegistrarUsuario($idusuario, $nombre, $idgrupo, $clave)
	{
	    $texto_consulta = "insert into usuarios (idusuario, nombre, idgrupo, clave)
		                   values ('$idusuario', '$nombre', '$idgrupo', '$clave') ";

		$resultado = $this->db->query($texto_consulta);
	
		return $this->db->affected_rows();
	}
    //*******************************************************************************************************
}

?>

