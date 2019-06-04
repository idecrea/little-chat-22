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
if ($_SERVER['REQUEST_METHOD'] === 'POST') 
{

    $username = get_str_request('username');
    $password = get_str_request('password');

        
    // Validaciones
    $usuarioValida->validaDatosLogin($username,$password);
    
    // Obtenemos los errores
    $error = $usuarioValida->getErrores();


    // Tenemos ambos datos, pasamos a la última validación. 
    if(!count($error))
    {
        $usuarioDAO->username = $username;
        $usuarioDAO->contrasenya = $password;
        
        //Buscamos al usuario
        $findByEmail = $usuarioDAO->findUsuarioByUserPassword();
        
        //No lo hemos encontrado?
        if($findByEmail === false){
            $error['password'] = "El usuario o la contraseña son incorrectos";
            $error['username'] = $error['password'];
        } 
        else 
        {
            //Lo hemos encontrado, pero su contraseña es erronea
            if(!password_verify($password, $findByEmail['password']))
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
                    header('Location: ../www/narnia.php');
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