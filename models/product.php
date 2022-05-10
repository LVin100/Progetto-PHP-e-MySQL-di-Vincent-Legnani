<?php
class Product {
    private $conn;
    private $table_name = "products";
    //proprietà di un prodotto
    public $id;
    public $name;
    public $kg_riciclati;

    public function __construct($db) {
        $this->conn = $db;
    }
    //read products
    function read()
    {
        $query = "SELECT id, name, kg_riciclati
        FROM  {$this->table_name}";
        $stmt = $this->conn->prepare($query);

        $stmt->execute();
        return($stmt);
    }
    //creare un prodotto
    function create() {
        $query = "INSERT INTO {$this->table_name} SET name= :name, kg_riciclati= :kg_riciclati;";
        $stmt = $this->conn->prepare($query);

        $check_existence = false;

        include_once '../config/database.php';

        
        $database = new Database();
        $db = $database->getConnection();
        
        $product = new Product($db);
        
        $stmt_check = $product->read();
        $num = $stmt_check->rowCount();
        
        if ($num>0) {
            while ($row = $stmt_check->fetch(PDO::FETCH_ASSOC)){
                extract($row);

                if ($name === $this->name){
                    http_response_code(400);
                    echo json_encode(array("Response"=>"Il prodotto digitato è già esistente."));
                    $check_existence=true;
                }
            }
        }

        if($check_existence===false){
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->kg_riciclati = htmlspecialchars(strip_tags($this->kg_riciclati));

        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":kg_riciclati", $this->kg_riciclati);
    
        if($stmt->execute()){
            return true;
        }
        return false;
    }

}





    //eliminare un prodotto
    function delete(){
        $query = "DELETE FROM {$this->table_name} WHERE id= ?";

        $stmt = $this->conn->prepare($query);
        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(1, $this->id);

        if ($stmt->execute()){
            return true;
        }
        return false;
    }
    //aggiornare un prodotto
    function update() {
        $query = "UPDATE " . $this->table_name . "
        SET name= :name,
        kg_riciclati= :kg_riciclati
        WHERE
        id= :id";
       

        $stmt = $this->conn->prepare($query);

        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->kg_riciclati = htmlspecialchars(strip_tags($this->kg_riciclati));

        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":kg_riciclati", $this->kg_riciclati);

        if ($stmt->execute()){
            return true;
        }
        return false;
    }
}