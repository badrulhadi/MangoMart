<?php

require_once 'config/bootstrap.php';
require_once ROOT_DIR.'/model/Order.php';
require_once ROOT_DIR.'/model/Cart.php';

$userID = 1; //temp hard code

$order = new Order();
$cart = new Cart();

// echo '<pre>';
// print_r($_POST); 
// echo '</pre>';
// die();

if ($_POST) {

    $order->userID = $userID;
    $order->create();

    $cart->userID = $userID;
    $cart->clearCart();
}

header("Location: order.php");
exit();