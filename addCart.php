<?php
require_once 'config/bootstrap.php';
require_once ROOT_DIR.'/model/Cart.php';

session_start();

$userID = 1; //temp hard code

$cart = new Cart();

if ($_POST) {

    // TODO: validate input

    // TODO: get price from API (the correct and secure way )
    
    try {

        $cart->userID = $userID;
        $cart->productID = $_POST['productID'];
        $cart->productName = $_POST['productName'];
        $cart->quantity = $_POST['quantity'];
        $cart->subTotal = $_POST['price'] * $_POST['quantity'];
        $cart->add();

        $_SESSION["alertType"] = "success";
        $_SESSION["alertMessage"] = "Successfully add {$_POST['productName']} to cart.";

    } catch(Exception $e) {
        $_SESSION["alertType"] = "error";
        $_SESSION["alertMessage"] = "An Error occur. Please try again or contact support.";
    }

}

header("Location: catalogue.php");
exit();