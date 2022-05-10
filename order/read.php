<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once 'config/database.php';
include_once 'models/order.php';

$database = new Database();
$db = $database->getConnection();

$order= new Order($db);

$stmt = $order->read();
$num = $stmt->rowCount();

if($num>0){
    $order_arr = array();
    $order_arr["records"] = array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
        $order_item = array(
            "id_order"=>$id_order,
            "date"=>$date,
            "products"=>$products,
            "products_quantity"=>$products_quantity
        );
        array_push($order_arr["records"], $order_item);
    }
    echo json_encode($order_arr);
}else{
    http_response_code(404);
    echo json_encode(array("Response"=> "Nessun ordine trovato."));
}