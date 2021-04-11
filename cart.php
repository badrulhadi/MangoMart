<?php 

require_once 'config/bootstrap.php';
require_once ROOT_DIR.'/model/Cart.php';

session_start();

$userID = 1; //temp hard code
$cart = new Cart();

$cartsList = $cart->getAllByUserID($userID);
$totalAmount = 0;

include('./template/header.php')
?>

<main role="main" class="flex-shrink-0">

<div class="container mb-4">
  <h1 class="mt-5">Cart</h1>

  <?php include('./template/message.php'); ?>

  <div class="row">
    <div class="col-12">
      <div class="table-responsive">
        <table class="table table-striped mt-4">
          <thead>
            <tr>
              <th scope="col"> </th>
              <th scope="col">Product</th>
              <th scope="col">Price</th>
              <th scope="col" class="text-center">Quantity</th>
              <th scope="col" class="text-right">SubTotal</th>
              <th scope="col" class="text-center"> </th>
            </tr>
          </thead>
          <tbody>

            <?php foreach($cartsList as $cartItem): ?>
              <tr>
                <td><img src="<?php echo $cartItem["imgUrl"]; ?>" height="100" width="100"/> </td>
                <td><?php echo $cartItem["product_name"]; ?></td>
                <td class="text-left">RM <?php echo $cartItem["price"]; ?></td>
                <td><input class="form-control col-3 mx-auto" type="number" value="<?php echo $cartItem["quantity"]; ?>" /></td>
                <td class="text-left">RM <?php echo number_format($cartItem["sub_total"], 2); ?></td>
                <td class="text-right"><button class="btn btn-sm btn-danger">remove </button> </td>
              </tr>
              <?php $totalAmount += $cartItem["sub_total"] ?>
            <?php endforeach; ?>

            <tr>
              <td></td>
              <td></td>
              <td></td>
              <td><strong>Total</strong></td>
              <td class="text-left"><strong>RM <?php echo number_format($totalAmount, 2) ?></strong></td>
              <td></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <div class="col mb-2">
      <div class="row">
        <div class="col-sm-12  col-md-6">
          <a href="catalogue.php" class="btn btn-block btn-light">Continue Shopping</a>
        </div>
        <div class="col-sm-12 col-md-6 text-right">
          <form method="POST" action="submitOrder.php">
            <input type="submit" name="submitOrder" class="btn btn-block btn-success text-uppercase" value="Submit Order">
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
</main>

<?php include('./template/footer.php')?>
