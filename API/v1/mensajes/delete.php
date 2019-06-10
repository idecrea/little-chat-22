<?php
$data = [];
$error = [];
include_once("../../../src/valida/mensajes_valida.php");
include_once("../../../src/dao/mensajes_dao.php");

if ($_SERVER['REQUEST_METHOD'] === 'DELETE'){

    //$values = json_decode(file_get_contents('php://input'),True);

    $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : '';

    $connection = new PDO("sqlite:../../../littlechat22test.sqlite", "root", "");
    $mensajesValida = new MensajesValida($connection);
    $mensajeDAO = new MensajesDAO($connection);
    //Hay que llamar al DAO!!


    // Validaciones
    $mensajesValida->validaDatosId($id);
    
    // Obtenemos los errores
    $error = $mensajesValida->getErrores();
    
    
    if( !count($error) ){

        $mensajeDAO->id = $id;
        $mensajeDAO->delete();
           
        $data = array("code"=>"200","msg"=>"Borrado");
            
    } else {
        
        http_response_code(404);
        $data = array("code"=>"404","msg"=>$error);
    }

    
    header('Content-Type: application/json');
    echo json_encode($data,JSON_PRETTY_PRINT);
}