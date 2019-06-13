<?php
include_once('../include/funciones.php');
include_once('../include/mailing.php');
include_once('../valida/usuarios_valida.php');
include_once('../dao/usuarios_dao.php');
include_once('../../head.php');
include_once('../../menu.php');

$connection = null;
    
session_start();
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
if ($_SERVER['REQUEST_METHOD'] === 'POST') 
{

    $username = get_str_request('username');
    $password = get_str_request('password');

    var_dump($password);

    // Validaciones
    $usuarioValida->validaDatosLogin($username,$password);
    
    // Obtenemos los errores
    $error = $usuarioValida->getErrores();


    // Tenemos ambos datos, pasamos a la última validación. 
    if(!count($error))
    {
        $usuarioDAO->username = $username;
        //$usuarioDAO->contrasenya = $password;
        
        //Buscamos al usuario
        $findByEmail = $usuarioDAO->findUsuarioByUser();
        
        //No lo hemos encontrado?
        if($findByEmail === false){
            $error['password'] = "El usuario o la contraseña son incorrectos";
            $error['username'] = $error['password'];
        } 
        else 
        {
            var_dump($password);
            //Lo hemos encontrado, pero su contraseña es erronea
            if(!password_verify($password, $findByEmail['contrasenya']))
            {
                $error['password'] = "El usuario o la contraseña son incorrectos";
                $error['username'] = $error['password'];
            } 
            else 
            {
                // Miramos si esta verificado el correo.
                if($findByEmail['activo'] == 1)
                {
                // Iniciamos sesión y le mandamos a narnia
                    $_SESSION['email'] = $findByEmail['email'];
                    header('Location: index.php');
                    die();
                }
                else
                {
                $error['password'] = "Revisa tu correo y activa tu cuenta";
                $error['username'] = $error['password']; 
                }
            } 
        }          
    }       
}

?>

<section class="h-screen bg-teal-400 m-0">
    <form action="" method="post">
        <h1 class="text-center text-teal-800 m-0 pt-16">Login</h1>
        <div class="flex justify-center mt-10">
            <input type="text" class="fuente-medium text-center h-12 w-56 bg-teal-100 placeholder1 border-2 border-teal-100 focus:border-teal-800 focus:text-teal-800" placeholder="Nombre de usuario" name="username">
        </div>
        <div class="flex justify-center mt-5">
            <input type="text" class="fuente-medium text-center h-12 w-56 bg-teal-100 placeholder1 border-2 border-teal-100 focus:border-teal-800 focus:text-teal-800" placeholder="Contraseña" name="password">
        </div>
        
        <!-- Error - El usuario o la contrasenya no son correctos -->

        <?php if(isset($error['username']) || isset($error['password'])) :?>
            <div class="flex justify-center mt-4 mb-2 mx-6 text-center">
                <p class="fuente-bold text-red-700">El usuario o la contraseña no son correctos</p>
            </div>
        <?php endif; ?>

        <!-- Error Todos los campos son obligatorios
            <div class="flex justify-center mt-5">
                <p class="fuente-bold text-red-700">Todos los campos son obligatorios</p>
            </div>
        -->

        <div class="flex justify-center mt-10">
            <input type="submit" class="fuente-bold text-center h-12 w-56 bg-teal-800 text-teal-100 hover:bg-teal-200 hover:text-teal-800" value="Iniciar sesión">
        </div>
    </form>
    <div class="flex justify-center mt-5">
        <a class="text-teal-800 fuente" href="recuperar_contrasenya.php">Recuperar Contraseña</a>
    </div>
    <div class="flex justify-center mt-16">
        <a class=" flex text-teal-100 justify-center items-center h-12 w-56 bg-teal-800 hover:bg-teal-100 hover:text-teal-800 hover:opacity-100" href="registro.php">Registrarse</a>
    </div>
</section>