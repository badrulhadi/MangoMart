<?php
require_once 'config/bootstrap.php';
require_once ROOT_DIR.'/model/Cart.php';

$userID = 1; //temp hard code

$cart = new Cart();

// echo '<pre>';
// print_r($_POST); 
// echo '</pre>';
// die();

if ($_POST) {

    // TODO: validate input

    // TODO: get price from API (the correct and secure way )
  
    $cart->userID = $userID;
    $cart->productID = $_POST['productID'];
    $cart->productName = $_POST['productName'];
    $cart->quantity = $_POST['quantity'];
    $cart->subTotal = $_POST['price'] * $_POST['quantity'];
    $cart->add();
}

header("Location: catalogue.php");
exit();