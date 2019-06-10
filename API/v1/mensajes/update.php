<?php
$data = [];
$error = [];
include_once("../../../src/valida/mensajes_valida.php");
include_once("../../../src/dao/mensajes_dao.php");

if ($_SERVER['REQUEST_METHOD'] === 'PUT'){

    $values = json_decode(file_get_contents('php://input'),True);

    $id = isset($values['id']) ? $values['id'] : '';
    $modo = isset($values['modo']) ? $values['modo'] : '';
    $email = isset($values['email']) ? $values['email'] : '';
    $texto = isset($values['texto']) ? $values['texto'] : '';

    $connection = new PDO("sqlite:../../../littlechat22test.sqlite", "root", "");
    $mensajesValida = new MensajesValida($connection);
    $mensajeDAO = new MensajesDAO($connection);
    //Hay que llamar al DAO!!


    
    if($modo == "edit")
    {
        $mensajesValida->validaDatosEdita($texto,$email,$id);
    }
    else if($modo == "like")
    {
        $mensajesValida->validaDatosLike($email,$id);
    }
    // Obtenemos los errores
    $error = $mensajesValida->getErrores();

    
    
    if( !count($error) ){
        if($modo == "edit"){
            $mensajeDAO->id = (int)$id;
            $mensajeDAO->texto = $texto;
            $mensajeDAO->editMensaje();
            
            $data = array("code"=>"200","msg"=>"Editado");       
        }else if ($modo == "like"){
            $mensajeDAO->id = (int)$id;
            $mensajeDAO->likeMensaje();
            $data = array("code"=>"200","msg"=>"Ok +1");       
        }else{
            http_response_code(404);
            $error['modo'] = "Accion no valida";
            $data = array("code"=>"404","msg"=>$error);
        }
    } else {
        http_response_code(404);
        $data = array("code"=>"404","msg"=>$error);
    }

    
    header('Content-Type: application/json');
    echo json_encode($data,JSON_PRETTY_PRINT);
}