<!-- ============================================== DIGITAL NEW PRODUCTS ============================================== -->
	<?php 
		$products = array(
			array(
				'product_name' => 'Product name #01',
				'is_new' => true,
				'is_sale' =>false,
				'is_hot' =>false,
				'productImageURL' => 'assets/images/products/42.jpg'


				),
			array(
				'product_name' => 'Product name #01',
				'is_new' => false,
				'is_sale' =>true,
				'is_hot' =>false,
				'productImageURL' => 'assets/images/products/41.jpg'



				),
			array(
				'product_name' => 'Product name #01',
				'is_new' => false,
				'is_sale' =>false,
				'is_hot' =>true,
				'productImageURL' => 'assets/images/products/40.jpg'


				),
			array(
				'product_name' => 'Product name #01',
				'is_new' => false,
				'is_sale' =>false,
				'is_hot' =>true,
				'productImageURL' => 'assets/images/products/43.jpg'


				),
			array(
				'product_name' => 'Product name #01',
				'is_new' => false,
				'is_sale' =>true,
				'is_hot' =>false,
				'productImageURL' => 'assets/images/products/44.jpg'


				),
			array(
				'product_name' => 'Product name #01',
				'is_new' => true,
				'is_sale' =>false,
				'is_hot' =>false,
				'productImageURL' => 'assets/images/products/40.jpg'


				),
			array(
				'product_name' => 'Product name #01',
				'is_new' => true,
				'is_sale' =>false,
				'is_hot' =>false,
				'productImageURL' => 'assets/images/products/41.jpg'

				),
			array(
				'product_name' => 'Product name #01',
				'is_new' => false,
				'is_sale' =>true,
				'is_hot' =>false,
				'productImageURL' => 'assets/images/products/42.jpg'



				),
			array(
				'product_name' => 'Product name #01',
				'is_new' => false,
				'is_sale' =>false,
				'is_hot' =>true,
				'productImageURL' => 'assets/images/products/43.jpg'


				),
			array(
				'product_name' => 'Product name #01',
				'is_new' => true,
				'is_sale' =>false,
				'is_hot' =>false,
				'productImageURL' => 'assets/images/products/44.jpg'


				),
			array(
				'product_name' => 'Product name #01',
				'is_new' => false,
				'is_sale' =>true,
				'is_hot' =>false,
				'productImageURL' => 'assets/images/products/40.jpg'



				),
			array(
				'product_name' => 'Product name #01',
				'is_new' => false,
				'is_sale' =>false,
				'is_hot' =>true,
				'productImageURL' => 'assets/images/products/41.jpg'
				)
			
			);
			?>

		
		<div class="digital-featured">
			<?php $delay = 0; ?>
			<?php foreach($products as $product):?>
				<div class="item category-product">
					<div class="products grid-v1 wow fadeInUp" data-wow-delay="<?php echo (float)($delay/10);?>s"> 
						<?php displayProduct($product['product_name'], $product['is_new'],$product['is_sale'],$product['is_hot'],$product['productImageURL']) ; ?>
					</div><!-- /.products -->
				</div><!-- /.item -->
				<?php $delay++; ?>	
			<?php endforeach;?>
		</div><!-- /.fashion-featured -->
<!-- ============================================== DIGITAL NEW PRODUCTS : END ============================================== -->