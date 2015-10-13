<!-- ========================================== CATEGORY-V1-GRID ========================================= -->
<?php 
	$products = array(
		array(
			'product_name' => 'Product name #01',
			'is_new' => true,
			'is_sale' =>false,
			'is_hot' =>false,
			'productImageURL' => 'assets/images/products/7.jpg'


			),
		array(
			'product_name' => 'Product name #01',
			'is_new' => false,
			'is_sale' =>true,
			'is_hot' =>false,
			'productImageURL' => 'assets/images/products/8.jpg'



			),
		array(
			'product_name' => 'Product name #01',
			'is_new' => false,
			'is_sale' =>false,
			'is_hot' =>true,
			'productImageURL' => 'assets/images/products/9.jpg'


			),
		array(
			'product_name' => 'Product name #01',
			'is_new' => false,
			'is_sale' =>false,
			'is_hot' =>true,
			'productImageURL' => 'assets/images/products/10.jpg'


			),
		array(
			'product_name' => 'Product name #01',
			'is_new' => false,
			'is_sale' =>true,
			'is_hot' =>false,
			'productImageURL' => 'assets/images/products/12.jpg'


			),
		array(
			'product_name' => 'Product name #01',
			'is_new' => true,
			'is_sale' =>false,
			'is_hot' =>false,
			'productImageURL' => 'assets/images/products/14.jpg'


			),
		array(
			'product_name' => 'Product name #01',
			'is_new' => true,
			'is_sale' =>false,
			'is_hot' =>false,
			'productImageURL' => 'assets/images/products/10.jpg'

			),
		array(
			'product_name' => 'Product name #01',
			'is_new' => false,
			'is_sale' =>true,
			'is_hot' =>false,
			'productImageURL' => 'assets/images/products/8.jpg'



			),
		array(
			'product_name' => 'Product name #01',
			'is_new' => false,
			'is_sale' =>false,
			'is_hot' =>true,
			'productImageURL' => 'assets/images/products/7.jpg'


			),
		array(
			'product_name' => 'Product name #01',
			'is_new' => true,
			'is_sale' =>false,
			'is_hot' =>false,
			'productImageURL' => 'assets/images/products/14.jpg'


			),
		array(
			'product_name' => 'Product name #01',
			'is_new' => false,
			'is_sale' =>true,
			'is_hot' =>false,
			'productImageURL' => 'assets/images/products/12.jpg'



			),
		array(
			'product_name' => 'Product name #01',
			'is_new' => false,
			'is_sale' =>false,
			'is_hot' =>true,
			'productImageURL' => 'assets/images/products/9.jpg'



			),
		array(
			'product_name' => 'Product name #01',
			'is_new' => true,
			'is_sale' =>false,
			'is_hot' =>false,
			'productImageURL' => 'assets/images/products/10.jpg'

			),
		array(
			'product_name' => 'Product name #01',
			'is_new' => true,
			'is_sale' =>false,
			'is_hot' =>false,
			'productImageURL' => 'assets/images/products/8.jpg'

			),
		array(
			'product_name' => 'Product name #01',
			'is_new' => true,
			'is_sale' =>false,
			'is_hot' =>false,
			'productImageURL' => 'assets/images/products/7.jpg'

			),
		array(
			'product_name' => 'Product name #01',
			'is_new' => true,
			'is_sale' =>false,
			'is_hot' =>false,
			'productImageURL' => 'assets/images/products/12.jpg'

			)
		);
    $delay = 0; 
	foreach($products as $product):
		?>

	<div class="col-sm-4 col-md-3 wow fadeInUp" data-wow-delay="<?php echo (float)($delay/10);?>s"> 
		<div class="products grid-v1">
			<?php displayProduct($product['product_name'], $product['is_new'],$product['is_sale'],$product['is_hot'],$product['productImageURL']) ; ?>
		</div><!-- /.products -->
	</div><!-- /.item -->
	<?php $delay++; ?>
<?php endforeach;?>
<!-- ========================================== CATEGORY-V1-GRID : END ========================================= -->