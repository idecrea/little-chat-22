<?php
include_once('../include/funciones.php');
include_once('../include/mailing.php');
include_once('../valida/usuarios_valida.php');
include_once('../dao/usuarios_dao.php');
include_once('../../head.php');

$connection = null;
    
//session_start();
//if (isset($_SESSION['email'])) header('Location: ../www/narnia.php');

//-----------------------------------------------------
// Logica
//-----------------------------------------------------
$connection = new PDO("sqlite:../../littlechat22test.sqlite", "root", "");
$usuarioValida = new UsuariosValida($connection);
$usuarioDAO = new UsuariosDAO($connection);

//-----------------------------------------------------
// Variables
//-----------------------------------------------------

$error = [];

//Obtención de modo
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $email = get_str_request('email');

          
        // Validaciones
        $usuarioValida->validaDatosEmail($email);
        
        // Obtenemos los errores
        $error = $usuarioValida->getErrores();


        // Tenemos ambos datos, pasamos a la última validación. 
        if(!count($error)){
            $usuarioDAO->email = $email;

            
            //Buscamos al usuario
            $findByEmail = $usuarioDAO->findUsuarioByEmail();

            if($findByEmail !== false){
                  //Preparamos el usuario
                  $usuarioDAO->id = $findByEmail['id'];
                  $usuarioDAO->token = bin2hex(openssl_random_pseudo_bytes(16));
                  //Le añadimos un token
                  $usuarioDAO->updateToken();
                  
                  //Preparamos la ruta
                  $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
                  $url = (str_replace("recuperar_contrasenya","cambiar_contrasenya",$actual_link));
                  
                  //Preparamos las variables del correo.
                  $from = "noreply@littlechat.com";
                  $to = $findByEmail['email'];
                  $to_name = $findByEmail['username'];
                  $subject = 'Tu solicitud de cambio de contraseña!';
                  $body = '<h1>Hola '. $findByEmail['username'] .'!</h1>'.
                  '<p>Pulsa el siguiente enlace para cambiar tu contraseña:</p>'.
                  '<a href="'.$url.'?token='. $findByEmail['id'].'_'. $findByEmail['token'] . '">Enlace</a>';
                  
                  //Lo enviamos
                  enviar_correo($from,$to,$to_name,$body,$subject);

                  //Lo redirigimos al... ok
                  header('Location: ../www/ok-recuperar-contrasenya.php');
                  
                }
              
        }; 
            
}

?>
    
   



