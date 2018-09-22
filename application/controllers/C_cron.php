<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class C_cron extends CI_Controller {

			 
	public function __construct()
    {
		parent::__construct();
		$this->load->library('session');
		$this->load->helper('url','mysql_to_excel_helper');
		$this->load->model( 'M_cron', '', TRUE );
		$this->load->library('class.phpmailer.php');
		$this->load->library('class.pop3.php');
		$this->load->library('class.smtp.php');
		
    }
	/********************************************************************************************************************/
	// 
    public function index()
	{
		
	}
	
    
	public function vencimientos()
	{
		//include(base_url()."api_cron/phpmailer/class.phpmailer.php");
		
		//Datos de API Mandrill y PHPmail
		$mail = new PHPMailer;

		// Configuramos los datos de sesión para conectarnos al servicio SMTP de Mandrill , "finanzas@dvigi.com.ar"
		$mail->IsSMTP(); // Indicamos que vamos a utilizar SMTP
		$mail->Host = 'smtp.mandrillapp.com'; // El Host de Mandrill               
		$mail->Port = 587;  // El puerto que Mandrill nos indica utilizar
		$mail->SMTPAuth = true; // Indicamos que vamos a utilizar auteticación SMTP       
		$mail->Username = 'dvigisistemas'; // Nuestro usuario en Mandrill              
		$mail->Password = 'ihKhAekBJIv5REKPJz-Lxg'; // Key generado por Mandrill 
		$mail->SMTPSecure = 'tls'; // Activamos el cifrado tls (también ssl)
		
		$html = "<div style='text-align: justify;'>
      <a href='https://www.tienda.dvigi.com.ar/repuestos_qO27328244XtOcxSM'><img src='https://dvigi-sistema.com/dvigi/api_cron/img/imagen1.png'></a>
	  <p style='text-align: justify;'><h2>¡Hola! Si recibiste este correo es porque el repuesto de tu purificador está por vencer.</h2>

A diferencia de otros en el mercado, los purificadores Dvigi duran toda la vida. Lo único que tenés que cambiar es el repuesto, una vez que haya cumplido su vida útil indicada en el manual.

<h2 style='text-align: justify;'>¿Cómo cambiarlo?</h2>
Es muy fácil, podés comprar tu repuesto pagando con todos los medios de pago, en hasta 12 cuotas sin interés y recibirlo en la puerta de tu casa a través de nuestro sitio web: <a href='https://www.tienda.dvigi.com.ar/repuestos_qO27328244XtOcxSM'>https://www.tienda.dvigi.com.ar</a> o comunicarte con nosotros al 0810-777-3844 para coordinar la entrega.<br><br>

También podés visitar nuestro showroom en Av. Santa Fe 2380, Martínez, Buenos Aires.<br><br>

Si pensás que hay un error en los datos o ya lo compraste, llamanos o respondé este mail aclarándolo. Tener tu ficha actualizada nos permite mantenerte al tanto de los vencimientos, promociones y descuentos especiales.<br><br>

Dvigi es la forma más práctica y económica de tomar agua pura todos los días de tu vida.</p>
      <a href='https://www.tienda.dvigi.com.ar/repuestos_qO27328244XtOcxSM'><img src='https://dvigi-sistema.com/dvigi/api_cron/img/imagen2.png'></a>
	</div>";
	
		$mail->From = 'webmaster@dvigi-sistema.com '; // Nuestro correo electrónico
		$mail->FromName = 'DVIGI tu agua pura'; // El nombre de nuestro sitio o proyecto
		$mail->IsHTML(true); // Indicamos que el email tiene formato HTML                      
		$mail->Subject = 'Tu Repuesto DVIGI está por vencer'; // El asunto del email
		$mail->Body = $html; // El cuerpo de nuestro mensaje
		/*Fin de la Configuracion*/
		
		//envio un mail
				$email = "rodolvg87@gmail.com";
				if($email != NULL){
					$mail->AddAddress($email); // Cargamos el e-mail destinatario a la clase PHPMailer
					$mail->Send(); // Realiza el envío =)
						if(!$mail->send()){
						 echo "Error Enviando el E-Mail al cliente: ". $mail->ErrorInfo."\n";
						 
						}else{
						 echo "E-Mail enviado con exito.\n";
						 
						}
				    $mail->ClearAddresses();
				}
		
		$vencimientos = $this->M_cron->vencimientos_alertas();	
			
        foreach ($vencimientos->result() as $line):
		 
		    $datetime1 = date_create($line->fecha_vencimiento);
			$datetime2 = date_create(date('Y-m-d H:i:s'));
			$intervalo = date_diff($datetime1, $datetime2);
			
			$verificador = $intervalo->format('%R');
			$dias = $intervalo->format('%a');
			
			//echo $line['id_cliente']."<br>";
			
			/*if($dias == 0)
			{	
				echo "sms enviado"."<br>";
				
			}else{
				if($verificador == "-")
				{
				 if($dias <= 10)
				 {
					echo "mail enviado".$line->email."<br>";
				 }			 
				}
				
			}*/
		
		endforeach;
	}
	
	
}
?>