<!-- ========================================== CATEGORY-V3-GRID ========================================= -->
	<?php 
		$products = array(
			array(
				'product_name' => 'Product name #01',
				'is_new' => true,
				'is_sale' =>false,
				'is_hot' =>false,
				'productImageURL' => 'assets/images/products/1.jpg'


				),
			array(
				'product_name' => 'Product name #01',
				'is_new' => false,
				'is_sale' =>true,
				'is_hot' =>false,
				'productImageURL' => 'assets/images/products/2.jpg'



				),
			array(
				'product_name' => 'Product name #01',
				'is_new' => false,
				'is_sale' =>false,
				'is_hot' =>true,
				'productImageURL' => 'assets/images/products/3.jpg'


				),
			array(
				'product_name' => 'Product name #01',
				'is_new' => false,
				'is_sale' =>false,
				'is_hot' =>true,
				'productImageURL' => 'assets/images/products/4.jpg'


				),
			array(
				'product_name' => 'Product name #01',
				'is_new' => false,
				'is_sale' =>true,
				'is_hot' =>false,
				'productImageURL' => 'assets/images/products/5.jpg'


				),
			array(
				'product_name' => 'Product name #01',
				'is_new' => true,
				'is_sale' =>false,
				'is_hot' =>false,
				'productImageURL' => 'assets/images/products/6.jpg'


				),
			array(
				'product_name' => 'Product name #01',
				'is_new' => true,
				'is_sale' =>false,
				'is_hot' =>false,
				'productImageURL' => 'assets/images/products/1.jpg'

				),
			array(
				'product_name' => 'Product name #01',
				'is_new' => false,
				'is_sale' =>true,
				'is_hot' =>false,
				'productImageURL' => 'assets/images/products/2.jpg'



				),
			array(
				'product_name' => 'Product name #01',
				'is_new' => false,
				'is_sale' =>false,
				'is_hot' =>true,
				'productImageURL' => 'assets/images/products/3.jpg'


				),
			array(
				'product_name' => 'Product name #01',
				'is_new' => true,
				'is_sale' =>false,
				'is_hot' =>false,
				'productImageURL' => 'assets/images/products/4.jpg'


				),
			array(
				'product_name' => 'Product name #01',
				'is_new' => false,
				'is_sale' =>true,
				'is_hot' =>false,
				'productImageURL' => 'assets/images/products/5.jpg'



				),
			array(
				'product_name' => 'Product name #01',
				'is_new' => false,
				'is_sale' =>false,
				'is_hot' =>true,
				'productImageURL' => 'assets/images/products/6.jpg'



				)
			
			);
        $delay = 0;
		foreach($products as $product):
			?>

			<div class="col-sm-4 col-md-3 wow fadeInUp" data-wow-delay="<?php echo (float)($delay/10);?>s"> 
				<div class="products grid-v2">
					<?php displayProduct($product['product_name'], $product['is_new'],$product['is_sale'],$product['is_hot'],$product['productImageURL']) ; ?>
				</div><!-- /.products -->
			</div><!-- /.item -->
		<?php $delay++; ?>
	<?php endforeach;?>
<!-- ========================================== CATEGORY-V3-GRID : END========================================= -->
	