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
            }              
        }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        
        $token = get_str_request('token');
        $password = get_str_request('password');
        $password2 = get_str_request('password2');
                  
        // Validacion del Token (Por si acaso nos lo cambian...)
        $usuarioValida->validaToken($token);
        
        // Obtenemos los errores
        $error = $usuarioValida->getErrores();


        // Si no hay error en el token, vamos a revisar las contrasenyas
        if(!count($error)){
          $words = explode('_', $token);
          $token_str = array_pop($words);
          $token_id = implode('_', $words);
          
          //Revisamos que las contraseñas coinciden
          $usuarioValida->validaDatosContrasenyas($password,$password2);
          // Obtenemos los errores
          $error = $usuarioValida->getErrores();
          
          // Si no hay error en las contrasenyas, entramos.
          if(!count($error)){
            
            //Buscamos al usuario
              $usuarioDAO->id = $token_id;
              $usuarioDAO->token = $token_str;
              $findByToken = $usuarioDAO->findUsuarioByIdToken();
            
              if($findByToken === false){
                  // El token no existe, le enviamos un mensaje falso.
                  $error['mensaje'] = "El token ha caducado";               
              } else {
                $usuarioDAO->id = $findByToken['id'];
                $usuarioDAO->contrasenya = $password;
                $usuarioDAO->updateCambiaContrasenya();

                //Lo redirigimos al... ok
                header('Location: ../www/ok-cambiar-contrasenya.php');
              }
            }
              
              
        }; 
            
}
?>


<!-- El token que recibimos por GET, mételo en un input hidden, 
      vamos a usarlo para identificar al usuario, no vamos a pasarle el email -->


   



