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

        $email = get_str_request('email');

          
        // Validaciones
        $usuarioValida->validaDatosEmail($email);
        
        // Obtenemos los errores
        $error = $usuarioValida->getErrores();

        var_dump($error);

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
                  header('Location: ok-recuperar-contrasenya.php');
                  
                }
              
        }; 
            
}

?>
        <section class="h-screen bg-teal-400 m-0 overflow-scroll">
                <h1 class="text-center text-teal-800 m-0 pt-16 leading-snug">Recuperar <br>Contraseña</h1>
                <form action="" method="post">
                        <div class="flex justify-center mt-10">
                                <input type="text" class="fuente-medium text-center h-12 w-56 bg-teal-100 placeholder1 border-2 border-teal-100 focus:border-teal-800 focus:text-teal-800" placeholder="Introduce tu Email" name="email">
                        </div>

                        <!-- Error - No existe un usuario con este email -->
                        <?php if(isset($error['email'])) : ?>
                                <div class="flex justify-center mt-4">
                                        <p class="fuente-bold text-red-700 text-center"><?= $error['email'] ?></p>
                                </div>
                        <?php endif; ?>

                        <!-- Error Todos los campos son obligatorios
                                <div class="flex justify-center mt-5">
                                        <p class="fuente-bold text-red-700">Todos los campos son obligatorios</p>
                                </div>
                         -->

                        <div class="flex justify-center mt-16">
                                <input type="submit" class="fuente-bold text-center h-12 w-56 bg-teal-800 text-teal-100 hover:bg-teal-200 hover:text-teal-800" value="Enviar">
                        </div>
        
                </form>
        </section>
</div>
</body>
</html>
    
   



