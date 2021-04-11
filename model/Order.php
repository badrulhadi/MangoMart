<?php

require_once ROOT_DIR.'/config/database.php';
require_once ROOT_DIR.'/model/Product.php';
require_once ROOT_DIR.'/model/Cart.php';

class Order 
{
    private $conn;

    // object properties
    public $orderID;
    public $userID;
    public $quantity;
    public $totalPrice;
    public $created;
    public $modified;

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->getConnection();
    }


    /**
     * Creating new order
     */
    public function create()
    {
        $statusPending = 1;

        $cart = new Cart();
        $cart->userID = $this->userID;
        $totalPrice = $cart->getCartTotal();
        
        $query = "INSERT INTO orders (user_id, total_price, status, created)
                VALUES (:user_id, :total_price, :status, NOW())";

        $stmt = $this->conn->prepare( $query );
        $stmt->bindParam(":user_id", $this->userID);
        $stmt->bindParam(":total_price", $totalPrice);
        $stmt->bindParam(":status", $statusPending);
        $stmt->execute();

        $orderID = $this->conn->lastInsertId();
        $this->insertOrderItem($orderID);
    }


    /**
     * get all order for a given user id
     */
    public function getAllByUserID($userID)
    {
        $query = "SELECT order_id, total_price, status FROM orders WHERE user_id=:user_id";

        $stmt = $this->conn->prepare( $query );
        $stmt->bindParam(":user_id", $userID);
        $stmt->execute();

        $result = []; 

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

            $items = $this->getOrderItems($row["order_id"]);
            $row["items"] = $items;

            array_push($result, $row);
        }

        return $result;
    }


    /**
     * update order status
     */
    public function updateStatus($orderID, $status)
    {
        $query = "UPDATE orders
                SET status = :status, modified = NOW()
                WHERE order_id = :order_id";
    
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":status", $status);
        $stmt->bindParam(":order_id", $orderID);
        $stmt->execute();
    }


    //  ============ PRIVATE methods ================

    /**
     * get order items for given order id
     */
    private function getOrderItems($orderID)
    {
        $query = "SELECT product_id, product_name, quantity FROM orders_items WHERE order_id=:order_id";

        $stmt = $this->conn->prepare( $query );
        $stmt->bindParam(":order_id", $orderID);
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }


    /**
     * insert order Items
     */
    private function insertOrderItem($orderID)
    {
        $query = "INSERT INTO orders_items (order_id, product_id, product_name, quantity, sub_total, created)
                SELECT :order_id, product_id, product_name, quantity, sub_total, NOW() FROM carts_items
                WHERE user_id=:user_id";

        $stmt = $this->conn->prepare( $query );
        $stmt->bindParam(":order_id", $orderID);
        $stmt->bindParam(":user_id", $this->userID);
        $stmt->execute();
    }
}