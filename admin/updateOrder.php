<?php

require_once '../config/bootstrap.php';
require_once ROOT_DIR.'/model/Order.php';

$userID = 1; //temp hard code

$order = new Order();

// echo '<pre>';
// print_r($_POST); 
// echo '</pre>';
// die();

if ($_POST) {

    $order->updateStatus($_POST["orderID"], $_POST["orderStatus"]);
}

header("Location: order.php");
exit();