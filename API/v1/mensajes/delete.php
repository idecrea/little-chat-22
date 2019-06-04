<?php 
$values = json_decode(file_get_contents('php://input'),True);
//datos

header('Content-Type: application/json');
echo json_encode($data);