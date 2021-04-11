<?php

require_once ROOT_DIR.'/config/database.php';
require_once ROOT_DIR.'/model/Product.php';

class Cart 
{
    private $conn;
 
    // object properties
    public $userID;
    public $productID;
    public $productName;
    public $quantity;
    public $subTotal;
    public $created;
    public $modified;

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->getConnection();
    }


    /**
     * get all item in cart for a given user id
     */
    public function getAllByUserID($userID)
    {
        $query = "SELECT product_id, product_name, quantity, sub_total FROM carts_items WHERE user_id=:user_id";

        $stmt = $this->conn->prepare( $query );
        $stmt->bindParam(":user_id", $userID);
        $stmt->execute();

        $result = []; 

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

            $product = new Product();
            $item = $product->getOneByID($row["product_id"]);

            $row["price"] = $item->variations[0]->regular_price;
            $row["imgUrl"] = $item->images[0]->src_small;
            
            array_push($result, $row);
        }

        return $result;
    }


    /**
     * get Total price for a cart
     */
    public function getCartTotal()
    {
        $query = "SELECT SUM(sub_total) FROM carts_items WHERE user_id=:user_id";

        $stmt = $this->conn->prepare( $query );
        $stmt->bindParam(":user_id", $this->userID);
        $stmt->execute();

        $rows = $stmt->fetch(PDO::FETCH_NUM);
        
        return $rows[0];
    }


    /**
     * remove all items in cart
     */
    public function clearCart()
    {
        $query = "DELETE FROM carts_items WHERE user_id=:user_id";

        $stmt = $this->conn->prepare( $query );
        $stmt->bindParam(":user_id", $this->userID);
        $stmt->execute();
    }


    /**
     * add item in cart
     */
    public function add()
    {
        if ($this->cartItemExists()) {
            $this->updateItem();
        } else {
            $this->insertNewItem();
        }
    }


    //  ============ PRIVATE methods ================

    /**
     * check if a cart item exists
     */
    private function cartItemExists()
    {
        $query = "SELECT count(*) FROM carts_items 
                WHERE user_id=:user_id AND product_id=:product_id";

        $stmt = $this->conn->prepare( $query );
        $stmt->bindParam(":user_id", $this->userID);
        $stmt->bindParam(":product_id", $this->productID);
        $stmt->execute();

        $rows = $stmt->fetch(PDO::FETCH_NUM);
        
        if ($rows[0] > 0) {
            return true;
        }

        return false;
    }


    /**
     * Create new cart item
     */
    private function insertNewItem()
    {
        $query = "INSERT INTO carts_items (user_id, product_id, product_name, quantity, sub_total, created)
                VALUES (:user_id, :product_id, :product_name, :quantity, :sub_total, NOW())";
    
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":user_id", $this->userID);
        $stmt->bindParam(":product_id", $this->productID);
        $stmt->bindParam(":product_name", $this->productName);
        $stmt->bindParam(":quantity", $this->quantity);
        $stmt->bindParam(":sub_total", $this->subTotal);
        $stmt->execute();
    }


    /**
     * update cart item
     */
    private function updateItem()
    {
        $query = "UPDATE carts_items
                SET quantity = :quantity, sub_total = :sub_total, modified = NOW()
                WHERE user_id = :user_id
                AND product_id = :product_id";
    
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":quantity", $this->quantity);
        $stmt->bindParam(":sub_total", $this->subTotal);
        $stmt->bindParam(":user_id", $this->userID);
        $stmt->bindParam(":product_id", $this->productID);
        $stmt->execute();
    }
}