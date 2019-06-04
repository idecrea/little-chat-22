<?php
include_once('../include/funciones.php');
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
if ($_SERVER['REQUEST_METHOD'] === 'GET') {

        $token = get_str_request('token');
                  
        // Validaciones
        $usuarioValida->validaToken($token);
        
        // Obtenemos los errores
        $error = $usuarioValida->getErrores();


        // Tenemos ambos datos, pasamos a la última validación. 
        if(!count($error)){
            $words = explode('_', $token);
            $token_str = array_pop($words);
            $token_id = implode('_', $words);

            $usuarioDAO->id = $token_id;
            $usuarioDAO->token = $token_str;

            //Buscamos al usuario
            $findByToken = $usuarioDAO->findUsuarioByIdToken();
          
            if($findByToken === false){
                // El token no existe, le enviamos un mensaje falso.
                $error['mensaje'] = "El token ha caducado";               
            } else {
              if( $findByToken['activo'] == 1 ){
                $error['mensaje'] = "Tu cuenta ya estaba activa";
              } else if ( $findByToken['activo'] == 0 ){
                //La cuenta no está activa, vamos a activarla.
                $usuarioDAO->activar();
    
                $error['mensaje'] = "Acabas de confirmar tu cuenta!";

              } else {
                // La cuenta, tiene otro estado (por si implementamos cuentas bloqueadas).
                $error['mensaje'] = "El token ha caducado";

              }
            }
              
              
        }; 
            
}

   



