<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once './config/database.php';

$database = new Database();
$conn = $database->getConnection();



$data = json_decode(file_get_contents("php://input"));
$product_searched = $data->product_searched;


function read_x_date($conn, $product_searched){
    $query = "SELECT id_order, date, products, products_quantity FROM orders WHERE products = '{$product_searched}'";
    $stmt = $conn->prepare($query);


    $stmt->execute();
    return $stmt;
}




$stmt =read_x_date($conn, $product_searched);
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