<?php
include_once('../include/funciones.php');
include_once('../include/mailing.php');
include_once('../valida/usuarios_valida.php');
include_once('../dao/usuarios_dao.php');

$connection = null;
    
//session_start();
//if (isset($_SESSION['email'])) header('Location: ../www/index.php');

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

        $username = get_str_request('username');
        $email = get_str_request('email');
        $password = get_str_request('password');
        $password2 = get_str_request('password2');

        $username = "aaaaaaa";
        $email = "user3@email.com";
        $password = "123";
        $password2 = "123";
          
        // Validaciones
        $usuarioValida->validaDatosRegistro($username,$email,$password,$password2);
        
        // Obtenemos los errores
        $error = $usuarioValida->getErrores();

        // Tenemos ambos datos, pasamos a la última validación. 
        if(!count($error)){
            $usuarioDAO->newUsuario($username,$email,$password);
            
            //Buscamos al usuario
            $findByEmail = $usuarioDAO->findUsuarioByEmail($email);
          
            //Preparamos la ruta
            $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
            $url = (str_replace("registro","verificar_cuenta",$actual_link));
            
            //Preparamos las variables del correo.
            $from = "noreply@littlechat.com";
            $to = $findByEmail['email'];
            $to_name = $findByEmail['name'];
            $subject = 'Bienvenid@! Verifica tu correo!';
            $body = '<h1>Hola '. $findByEmail['name'] .'!</h1>'.
                '<p>Pulsa el siguiente enlace para activar tu cuenta:</p>'.
                '<a href="'.$url.'?token='. $findByEmail['id'].'_'. $findByEmail['token'] . '">Enlace</a>';
            
            //Lo enviamos
            enviar_correo($from,$to,$to_name,$body,$subject);
              
              
        }; 
            
}

   



