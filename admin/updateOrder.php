<?php

require_once '../config/bootstrap.php';
require_once ROOT_DIR.'/model/Order.php';

session_start();

$userID = 1; //temp hard code

$order = new Order();

if ($_POST) {

    try {
        $order->updateStatus($_POST["orderID"], $_POST["orderStatus"]);

        $_SESSION["alertType"] = "success";
        $_SESSION["alertMessage"] = "Successfully update order.";
    } catch(Exception $e) {
        $_SESSION["alertType"] = "error";
        $_SESSION["alertMessage"] = "An Error occur. Please try again or contact support.";
    }
}

header("Location: order.php");
exit();