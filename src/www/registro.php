<?php
include_once('../include/funciones.php');
include_once('../include/mailing.php');
include_once('../valida/usuarios_valida.php');
include_once('../dao/usuarios_dao.php');
include_once('../../head.php');
include_once('../../menu.php');

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

        $username = get_str_request('username');
        $email = get_str_request('email');
        $password = get_str_request('password');
        $password2 = get_str_request('password2');

        /*$username = "aaa4";
        $email = "user4@email.com";
        $password = "123";
        $password2 = "123";*/
          
        // Validaciones
        $usuarioValida->validaDatosRegistro($username,$email,$password,$password2);
        
        // Obtenemos los errores
        $error = $usuarioValida->getErrores();


        // Tenemos ambos datos, pasamos a la última validación. 
        if(!count($error)){
            $usuarioDAO->username = $username;
            $usuarioDAO->contrasenya = $password;
            $usuarioDAO->email = $email;
            $usuarioDAO->created_at = date('Y-m-d H:i:s');
            $usuarioDAO->token = bin2hex(openssl_random_pseudo_bytes(16));
            $usuarioDAO->create();
            
            //Buscamos al usuario
            $findByEmail = $usuarioDAO->findUsuarioByEmail();
          
            //Preparamos la ruta
            $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
            $url = (str_replace("registro","verificar_cuenta",$actual_link));
            
            //Preparamos las variables del correo.
            $from = "noreply@littlechat.com";
            $to = $findByEmail['email'];
            $to_name = $findByEmail['username'];
            $subject = 'Bienvenid@! Verifica tu correo!';
            $body = '<h1>Hola '. $findByEmail['username'] .'!</h1>'.
                '<p>Pulsa el siguiente enlace para activar tu cuenta:</p>'.
                '<a href="'.$url.'?token='. $findByEmail['id'].'_'. $findByEmail['token'] . '">Enlace</a>';
            
            //Lo enviamos
            enviar_correo($from,$to,$to_name,$body,$subject);
            
            //Redireccionamos a registro completo
            header('Location: http://localhost:8000/src/www/registro-completo.php');

            die();
              
        }; 
            
}

?>
    <div id="app" class="fuente-bold">
        <form method="post" action="" class="h-screen bg-teal-400 m-0">
            <h1 class="text-center text-teal-800 m-0 pt-16">Registro</h1>
            <div class="flex justify-center mt-10">
                <input type="text" class="fuente-medium text-center h-12 w-56 bg-teal-100 placeholder1 border-2 border-teal-100 focus:border-teal-800 focus:text-teal-800" placeholder="Nombre de usuario" name="username">
            </div>

                <!-- Error - El username ya está escogido -->

                <?php if(isset($error['username'])) : ?>
                    <div class="flex justify-center mt-4 mb-4">
                        <p class="fuente-bold text-red-700"><?= $error['username'] ?></p>
                    </div>
                <?php endif; ?>

            <div class="flex justify-center mt-5">
                <input type="text" class="fuente-medium text-center h-12 w-56 bg-teal-100 placeholder1 border-2 border-teal-100 focus:border-teal-800 focus:text-teal-800" placeholder="Email" name="email">
            </div>

                <!-- Error - El email debe ser valido -->

                <?php if(isset($error['email'])) : ?>

                    <div class="flex justify-center mt-4 mb-4">
                        <p class="fuente-bold text-red-700"><?= $error['email'] ?></p>
                    </div>

                <?php endif; ?>


            <div class="flex justify-center mt-5">
                <input type="password" class="fuente-medium text-center h-12 w-56 bg-teal-100 placeholder1 border-2 border-teal-100 focus:border-teal-800 focus:text-teal-800" placeholder="Contraseña" name="password">
            </div>
            <div class="flex justify-center mt-5">
                <input type="password" class="fuente-medium text-center h-12 w-56 bg-teal-100 placeholder1 border-2 border-teal-100 focus:border-teal-800 focus:text-teal-800" placeholder="Confirmar Contraseña" name="password2">
            </div>
                <!-- Error - Las contrasenyas deben ser idénticas -->

                <?php if(isset($error['password2'])) : ?>
                    <div class="flex justify-center mt-5 mb-4">
                        <p class="fuente-bold text-red-700"><?= $error['password2'] ?></p>
                    </div>
                <?php endif; ?>

                <!-- Error Todos los campos son obligatorios -->

                <?php if(isset($error['username']) && isset($error['password']) && isset($error['email']) && isset($error['password2'])) : ?>
                    <div class="flex justify-center mt-5">
                        <p class="fuente-bold text-red-700">Todos los campos son obligatorios</p>
                    </div>
                <?php endif; ?>

            <div class="flex justify-center mt-10">
                <input type="submit" class="fuente-bold text-center h-12 w-56 bg-teal-800 text-teal-100 hover:bg-teal-200 hover:text-teal-800" value="Regístrate">
            </div>
        </form>
    </div>

   



