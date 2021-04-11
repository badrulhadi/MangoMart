<?php 

require_once 'config/bootstrap.php';
require_once ROOT_DIR.'/model/Product.php';

$product = new Product();
$productsList = $product->getAllPaginate(1);

// echo '<pre>';
// print_r($productsList); 
// echo '</pre>';
// die();

include('./template/header.php')
?>

<!-- Begin page content -->
<main role="main" class="flex-shrink-0">
  <div class="container">
    <h1 class="mt-5">Product Catalogue</h1>

    <?php foreach($productsList as $productItem): ?>
      <div class="card my-3" >
        <div class="row no-gutters">
          <div class="col-md-4 text-center">
            <img class="img-fluid" src="<?php echo $productItem->images[0]->src_medium; ?>" alt="<?php echo $productItem->images[0]->alt; ?>">
          </div>
          <div class="col-md-8">
            <div class="card-body">
              <h4 class="card-title"><?php echo $productItem->name; ?></h4>
              <h5 class="card-text">RM <?php echo $productItem->variations[0]->regular_price; ?></h5>

              <form method="POST" action="addCart.php" class="form-inline col-md-5 float-right mb-3">
                <label class="my-1 mr-2" for="quantity">Quantity</label>
                <input type="number" class="form-control col-3 mr-3" id="quantity" name="quantity" value="1" min="0">
                <input type="hidden" name="productID" value="<?php echo $productItem->id; ?>">
                <input type="hidden" name="productName" value="<?php echo $productItem->name; ?>">
                <input type="hidden" name="price" value="<?php echo $productItem->variations[0]->regular_price ?>">
                <button type="submit" class="btn btn-primary my-1">Add to Cart</button>
              </form>

            </div>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</main>

<?php include('./template/footer.php')?>
