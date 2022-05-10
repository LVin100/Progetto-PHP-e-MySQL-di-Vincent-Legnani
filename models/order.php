<?php

class Order
{
    private $conn;
    private $table_name = "orders";

    public $id_order;
    public $date;
    public $products;
    public $products_quantity;

    public function __construct($db)
    {
        $this->conn = $db;
    }
    //creare ordine
    function create(){
        $query = "INSERT INTO " . $this->table_name . " SET id_order=:id_order, date =:date, products=:products, products_quantity=:products_quantity";

        $stmt = $this->conn->prepare($query);

        $check_existence = false;

        include_once '../config/database.php';

        $database = new Database();
        $db = $database->getConnection();
        
        $order = new Order($db);
        
        $stmt_check = $order->read();
        $num = $stmt_check->rowCount();
        
        if ($num>0) {
            while ($row = $stmt_check->fetch(PDO::FETCH_ASSOC)){
                extract($row);

                if ($id_order === $this->id_order && $products === $this->products){
                    $check_existence=true;
                    http_response_code(400);
                    echo json_encode(array("Response"=>"Il prodotto inserito è già in un'ordine, se si vuole modificarlo utilizzare la funzione UPDATE."));
                  
                }
        
            }
            
        }

        if($check_existence===false){


        $this->id_order = htmlspecialchars(strip_tags($this->id_order));
        $this->products = htmlspecialchars(strip_tags($this->products));
        $this->produts_quantity = htmlspecialchars(strip_tags($this->products_quantity));

        $stmt->bindParam(":id_order", $this->id_order);
        $stmt->bindParam(":date", $this->date);
        $stmt->bindParam(":products", $this->products); 
        $stmt->bindParam(":products_quantity", $this->products_quantity);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
    }

    //cancella ordine
    function delete(){
        $query = "DELETE FROM " . $this->table_name . " WHERE id_order= ?";

        $stmt = $this->conn->prepare($query);
        $this->id_order=htmlspecialchars(strip_tags($this->id_order));

        $stmt->bindParam(1, $this->id_order);

        if ($stmt->execute()){
            return true;
        }
        return false;

    }
    //read ordini
    function read(){
        $query = "SELECT id_order, date, products, products_quantity FROM {$this->table_name}";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    
    function read_x_prod(){
        $query = "SELECT id_order, date, products, products_quantity FROM {$this->table_name} ORDER BY products ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    function read_x_date($start_date, $end_date){
        $query = "SELECT id_order, date, products, products_quantity FROM {$this->table_name} Where date BETWEEN {$start_date} AND {$end_date} order by date asc";

        $stmt = $this->conn->prepare($query);


        $stmt->execute();
        return $stmt;
    }

    function tot_plastic(){
        $query = "select id_order, products_quantity, kg_riciclati, sum(products_quantity*kg_riciclati) as kg_tot from orders
        left join products on orders.products = products.name
        group by products
        ";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    //aggiorna ordine
    function update() {
        $query = "UPDATE " . $this->table_name . "
        SET 
        products_quantity= :products_quantity
        WHERE
        id_order= :id_order AND
        products= :products";
       

        $stmt = $this->conn->prepare($query);

        $this->id_order = htmlspecialchars(strip_tags($this->id_order));
        $this->products = htmlspecialchars(strip_tags($this->products));
        $this->produts_quantity = htmlspecialchars(strip_tags($this->products_quantity));

        $stmt->bindParam(":id_order", $this->id_order);
        $stmt->bindParam(":products", $this->products); 
        $stmt->bindParam(":products_quantity", $this->products_quantity);
        if ($stmt->execute()){
            return true;
        }
        return false;
    }
}