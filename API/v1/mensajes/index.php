<?php 
$data = [];
if ($_SERVER['REQUEST_METHOD'] === 'GET'){
    $hostPDO = "sqlite:../../../littlechat22test.sqlite";
    $miPDO = new PDO($hostPDO);
    header('Content-Type: application/json');

    if(isset($_REQUEST['id'])){
        $id = (int)$_REQUEST['id'];
            if($id>0){
                $miConsulta = $miPDO->prepare('SELECT m.*,u.username FROM mensajes as m, usuarios as u WHERE m.id_usuario=:id and u.id=:id;');
                $miConsulta->execute(array('id'=>$_REQUEST["id"]));
                $data = $miConsulta->fetch(PDO::FETCH_ASSOC);
                echo json_encode(array("code"=>"200","data"=>$data),JSON_PRETTY_PRINT);
            }else{
                http_response_code(404);
                echo json_encode(array("code"=>"404","msg"=>"No hay mensajes",JSON_PRETTY_PRINT));
            }
        

    }else{
        $miConsulta = $miPDO->prepare('SELECT m.*,u.username FROM mensajes as m, usuarios as u WHERE m.id_usuario=u.id;');
        $miConsulta->execute();
        $data = $miConsulta->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode(array("code"=>"200","msg"=>$data),JSON_PRETTY_PRINT);
    }
}
