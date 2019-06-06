<?php
$data = [];
$error = [];
include_once("../../../src/valida/mensajes_valida.php");
include_once("../../../src/dao/mensajes_dao.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST'){

    $values = json_decode(file_get_contents('php://input'),True);

    $texto = isset($values['texto']) ? $values['texto'] : '';
    $email = isset($values['email']) ? $values['email'] : '';
    $id_mensaje = isset($values['id_mensaje']) ? $values['id_mensaje'] : '';

    $connection = new PDO("sqlite:../../../littlechat22test.sqlite", "root", "");
    $mensajesValida = new MensajesValida($connection);
    $mensajeDAO = new MensajesDAO($connection);
    //Hay que llamar al DAO!!


    // Validaciones
    $mensajesValida->validaDatos($texto,$email,$id_mensaje);
    
    // Obtenemos los errores
    $error = $mensajesValida->getErrores();
    
    
    if( !count($error) ){

        $consultaUsuario = $connection->prepare('SELECT * FROM Usuarios WHERE email = :email');
        $consultaUsuario->execute(array('email'=>$email));
        $usuario = $consultaUsuario->fetch(PDO::FETCH_ASSOC);


        $mensajeDAO->texto = $texto;
        $mensajeDAO->created_at = date('Y-m-d H:i:s');
        $mensajeDAO->id_usuario = $usuario['id'];
        if(strlen($id_mensaje)>0) $mensajeDAO->id_mensaje = $id_mensaje;
        $mensajeDAO->create();
   
        
        $data = array("code"=>"200","msg"=>"Insertado");
            
    } else {
        
        http_response_code(404);
        $data = array("code"=>"404","msg"=>$error);
    }

    
    header('Content-Type: application/json');
    echo json_encode($data,JSON_PRETTY_PRINT);
}