<?php
include_once('../include/funciones.php');
include_once('../valida/usuarios_valida.php');
include_once('../dao/usuarios_dao.php');
include_once('../../head.php');
include_once('../../menu.php');

$connection = null;
    
session_start();
if (isset($_SESSION['email'])) header('Location: login.php');

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
        $email = get_str_request('email');
                  
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
          $usuarioValida->validaDatosContrasenyas($password,$password2,$email);
          // Obtenemos los errores
          $error = $usuarioValida->getErrores();
        
          var_dump($error);
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


              }

                //Lo redirigimos al... ok
                header('Location: ok-cambiar-contrasenya.php');
                die();
            }
              
              
        }; 
            
}
?>


    <!-- El token que recibimos por GET, mételo en un input hidden, 
      vamos a usarlo para identificar al usuario, no vamos a pasarle el email -->
        <section class="h-screen bg-teal-400 m-0 overflow-scroll">
            <h1 class="text-center text-teal-800 m-0 pt-16 leading-snug">Cambiar <br>Contraseña</h1>
            <form action="" method="post">
                <?php if(isset($token)) : ?>
                    <input type="hidden" name="token" value="<?= $token ?>">
                <?php endif; ?>
                <div class="flex justify-center mt-10">
                    <input type="text" class="fuente-medium text-center h-12 w-56 bg-teal-100 placeholder1 border-2 border-teal-100 focus:border-teal-800 focus:text-teal-800" placeholder="Email" name="email">
                </div>

                <!-- Error - No existen usuarios con este email -->
                    <?php if(isset($error['email'])) : ?>
                        <div class="flex justify-center mt-4 mb-4">
                            <p class="fuente-bold text-red-700"><?= $error['email'] ?></p>
                        </div>
                    <?php endif; ?>

                <div class="flex justify-center mt-5">
                    <input type="text" class="fuente-medium text-center h-12 w-56 bg-teal-100 placeholder1 border-2 border-teal-100 focus:border-teal-800 focus:text-teal-800" placeholder="Nueva Contraseña" name="password">
                </div>
                <div class="flex justify-center mt-5">
                    <input type="text" class="fuente-medium text-center h-12 w-56 bg-teal-100 placeholder1 border-2 border-teal-100 focus:border-teal-800 focus:text-teal-800" placeholder="Confirmar Nueva Contraseña" name="password2">
                </div>

                <!-- Error - Las contrasenyas deben ser idénticas -->

                <?php if(isset($error['password2']) && $error['password2'] === 'Las contraseñas no coinciden') :?>
                    <div class="flex justify-center mt-5 mb-4">
                        <p class="fuente-bold text-red-700">Las contraseñas deben ser idénticas</p>
                    </div>
                <?php endif; ?>

                <!-- Error Todos los campos son obligatorios
                <div class="flex justify-center mt-5">
                    <p class="fuente-bold text-red-700">Todos los campos son obligatorios</p>
                </div>-->

                <div class="flex justify-center mt-10">
                    <input type="submit" class="fuente-bold text-center h-12 w-56 bg-teal-800 text-teal-100 hover:bg-teal-200 hover:text-teal-800" value="Cambiar Contraseña">
                </div>
            
            </form>

        </section>
    </div>
</body>
</html>

   



