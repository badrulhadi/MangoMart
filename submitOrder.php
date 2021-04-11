<?php

require_once 'config/bootstrap.php';
require_once ROOT_DIR.'/model/Order.php';
require_once ROOT_DIR.'/model/Cart.php';

session_start();

$userID = 1; //temp hard code

$order = new Order();
$cart = new Cart();

// echo '<pre>';
// print_r($_POST); 
// echo '</pre>';
// die();

if ($_POST) {

    try {
        $order->userID = $userID;
        $order->create();
        
        $cart->userID = $userID;
        $cart->clearCart();

        $_SESSION["alertType"] = "success";
        $_SESSION["alertMessage"] = "Successfully submit order.";

    } catch(Exception $e) {
        $_SESSION["alertType"] = "error";
        $_SESSION["alertMessage"] = "An Error occur. Please try again or contact support.";
    }
}

header("Location: order.php");
exit();