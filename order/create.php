<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
include_once 'config/database.php';
include_once 'models/order.php';

$database = new Database();
$db = $database->getConnection();
$order = new Order($db);
$data = json_decode(file_get_contents("php://input"));

if(
    !empty($data->id_order) &&
    !empty($data->products) &&
    !empty($data->products_quantity) 
){
    $order->id_order = $data->id_order;
    $order->date = date("Y-m-d H:i:s");
    $order->products = $data->products;
    $order->products_quantity = $data->products_quantity;


    if($order->create()){
        http_response_code(201);
        echo json_encode(array("Response"=>"Ordine creato correttamente."));
    }else{
        http_response_code(503);
        echo json_encode(array("Response"=>"Impossibile creare l'ordine."));
    }
}else{
    http_response_code(400);
    echo json_encode(array("Response"=>"Impossibile creare l'ordine, i dati sono incompleti."));
}
