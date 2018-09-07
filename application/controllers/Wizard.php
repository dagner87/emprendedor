
<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Wizard extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->helper('url');
        $this->load->model('modelogeneral');
        $this->load->library('session');
        
    }

     public function index(){
     
      $this->load->view('wizard_final');
    }


  public function InsertdatosUsuario()
    {
       $param['nombre_usu']  = $this->input->get('nombre');
       $param['usuario']     = $this->input->get('usuario');
       $param['dni']         = $this->input->get('dni');
       $param['mail']        = $this->input->get('mail');
       $param['telefono']    = $this->input->get('telefono');
       $result               = $this->modelogeneral->InsertDatosUsuario($param);
       $msg['success']       = false;
       if($result){
        $msg['success'] = true;
      }
      echo json_encode($msg);

    }

     public function crear_txt(){

        $hoy = date("d-m-y H:i:s");
        $txt= fopen('backup.ini', 'a') or die ('Problemas al crear el archivo');
        $name ='Venton'.$hoy.'.ini';
      $clientCustomerId= '817-601-2690';
      $userAgent='Softcom SAS';
        $data = "[ADWORDS]
        ; Required AdWords API properties. Details can be found at:
        ; https://developers.google.com/adwords/api/docs/guides/basic-concepts#soap_and_xml
        developerToken = \"Ai_hjtr9BFMNx8liaRsifA\"
        clientCustomerId = \"".$clientCustomerId."\"

        ; Optional. Set a friendly application name identifier.
        userAgent = \"".$userAgent."\"

        ; Optional additional AdWords API settings.
        ; endpoint = \"https://adwords.google.com/\"
        ; isPartialFailure = false

        ; Optional setting for utility usage tracking in the user agent in requests.
        ; Defaults to true.
        ; includeUtilitiesInUserAgent = true

        [ADWORDS_REPORTING]
        ; Optional reporting settings.
        ; isSkipReportHeader = false
        ; isSkipColumnHeader = false
        ; isSkipReportSummary = false
        ; isUseRawEnumValues = false

        [OAUTH2]
        ; Required OAuth2 credentials. Uncomment and fill in the values for the
        ; appropriate flow based on your use case. See the README for guidance:
        ; https://github.com/googleads/googleads-php-lib/blob/master/README.md#getting-started

        ; For installed application or web application flow.
        clientId = \"687027528563-8r3j00ghipsr8ir8p8c33sfu1tb28ot4.apps.googleusercontent.com\"
        clientSecret = \"39k5ujRfci7QKyM-qy9Cb49x\"
        refreshToken = \"1/FpbIdI-rjYBwFoJEMiZyiiJ9jT-Q2kOI09fOaA8NHoOFXcB6CfttHDX0llh2jicK\"

        ; For service account flow.
        ; jsonKeyFilePath = \"INSERT_ABSOLUTE_PATH_TO_OAUTH2_JSON_KEY_FILE_HERE\"
        ; scopes = \"https://www.googleapis.com/auth/adwords\"
        ; impersonatedEmail = \"INSERT_EMAIL_OF_ACCOUNT_TO_IMPERSONATE_HERE\"

        [SOAP]
        ; Optional SOAP settings. See SoapSettingsBuilder.php for more information.
        ; compressionLevel = <COMPRESSION_LEVEL>

        [CONNECTION]
        ; Optional proxy settings to be used by requests.
        ; If you don't have username and password, just specify host and port.
        ; proxy = \"protocol://user:pass@host:port\"
        ; Enable transparent HTTP gzip compression for all reporting requests.
        ; enableReportingGzip = false

        [LOGGING]
        ; Optional logging settings.
        ; soapLogFilePath = \"path/to/your/soap.log\"
        ; soapLogLevel = \"INFO\"
        ; reportDownloaderLogFilePath = \"path/to/your/report-downloader.log\"
        ; reportDownloaderLogLevel = \"INFO\"
        ; batchJobsUtilLogFilePath = \"path/to/your/bjutil.log\"
        ; batchJobsUtilLogLevel = \"INFO\"
        ";
            fwrite($txt, $data."\r");
            fclose($txt);
    } 

    public function install_panel(){
    
    $id_merchant     = $this->input->post('id_merchant');
    $str = trim(str_replace("-", "", $id_merchant)); 
    
    $datos = array( 
      'nombre_tienda'    => $this->input->post('name_tienda'), 
      'categoria'        => $this->input->post('categoria'),      
      'id_merchant'      => $this->input->post('id_merchant'),    
      'nombre_usuario'   => $this->input->post('nombre'),
      'usuario'          => $this->input->post('usuario'),
      'dni'              => $this->input->post('dni'),
      'mail'             => $this->input->post('mail'), 
      'pass'             => md5($this->input->post('pass')),
      'id_tienda'        => $this->input->post('store_id'), //Guardar en base de datos
      'access_token'     => $this->input->post('access_token'), //Guardar en base de datos


    );
    
     //$result = $this->modelogeneral->insert($data,$id_usuario);
    $result =true;
       $msg['comprobador'] = false;
       if($result)
         {
          // $msg['comprobador'] = TRUE;
         }
            echo json_encode($str);

   }

}    