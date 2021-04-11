<?php 

require_once 'config/bootstrap.php';
require_once ROOT_DIR.'/model/Order.php';

$userID = 1; //temp hard code

$order = new Order();
$ordersList = $order->getAllByUserID($userID);


// echo '<pre>';
// print_r($ordersList); 
// echo '</pre>';
// die();

include('./template/header.php')
?>

<main role="main" class="flex-shrink-0">

<div class="container mb-4">
  <h1 class="mt-5">Order</h1>

  <div class="row">
    <div class="col-12">
      <div class="table-responsive">
        <table class="table table-striped mt-4">
          <thead>
            <tr>
              <th scope="col">Order ID</th>
              <th scope="col">Item</th>
              <th scope="col" class="text-center">Total Price</th>
              <th scope="col" class="text-center">Status</th>
            </tr>
          </thead>
          <tbody>

            <?php foreach($ordersList as $orderItem): ?>
              <tr>
                <td><?php echo $orderItem["order_id"]; ?></td>
                <td class="text-left">
                  <?php foreach($orderItem["items"] as $item): ?>
                    <span><?php echo $item["product_name"]; ?></span> 
                    <span>x<?php echo $item["quantity"]; ?></span>
                    <br>
                  <?php endforeach; ?>
                </td>
                <td class="text-center">RM <?php echo number_format($orderItem["total_price"], 2); ?></td>
                <td class="text-center">
                  <?php if ($orderItem["status"] == 1): ?>
                    <span class="badge badge-warning">PENDING</span>
                  <?php elseif ($orderItem["status"] == 2): ?>
                    <span class="badge badge-primary">PROCESSING</span>
                  <?php elseif ($orderItem["status"] == 3): ?>
                    <span class="badge badge-success">COMPLETED</span>
                  <?php endif; ?>
                </td>
              </tr>
            <?php endforeach; ?>

          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
</main>

<?php include('./template/footer.php')?>
