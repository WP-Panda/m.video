<!-- ============================================== FOOD FEATURED ============================================== -->
	<?php 
		$products = array(
			array(
				'product_name' => 'Product name #01',
				'is_new' => true,
				'is_sale' =>false,
				'is_hot' =>false,
				'productImageURL' => 'assets/images/products/30.jpg'


				),
			array(
				'product_name' => 'Product name #01',
				'is_new' => false,
				'is_sale' =>true,
				'is_hot' =>false,
				'productImageURL' => 'assets/images/products/31.jpg'



				),
			array(
				'product_name' => 'Product name #01',
				'is_new' => false,
				'is_sale' =>false,
				'is_hot' =>true,
				'productImageURL' => 'assets/images/products/33.jpg'


				),
			array(
				'product_name' => 'Product name #01',
				'is_new' => false,
				'is_sale' =>false,
				'is_hot' =>true,
				'productImageURL' => 'assets/images/products/34.jpg'


				),
			array(
				'product_name' => 'Product name #01',
				'is_new' => false,
				'is_sale' =>true,
				'is_hot' =>false,
				'productImageURL' => 'assets/images/products/35.jpg'


				),
			array(
				'product_name' => 'Product name #01',
				'is_new' => true,
				'is_sale' =>false,
				'is_hot' =>false,
				'productImageURL' => 'assets/images/products/30.jpg'


				),
			array(
				'product_name' => 'Product name #01',
				'is_new' => true,
				'is_sale' =>false,
				'is_hot' =>false,
				'productImageURL' => 'assets/images/products/31.jpg'

				),
			array(
				'product_name' => 'Product name #01',
				'is_new' => false,
				'is_sale' =>true,
				'is_hot' =>false,
				'productImageURL' => 'assets/images/products/32.jpg'



				),
			array(
				'product_name' => 'Product name #01',
				'is_new' => false,
				'is_sale' =>false,
				'is_hot' =>true,
				'productImageURL' => 'assets/images/products/33.jpg'


				),
			array(
				'product_name' => 'Product name #01',
				'is_new' => true,
				'is_sale' =>false,
				'is_hot' =>false,
				'productImageURL' => 'assets/images/products/34.jpg'


				),
			array(
				'product_name' => 'Product name #01',
				'is_new' => false,
				'is_sale' =>true,
				'is_hot' =>false,
				'productImageURL' => 'assets/images/products/35.jpg'



				),
			array(
				'product_name' => 'Product name #01',
				'is_new' => false,
				'is_sale' =>false,
				'is_hot' =>true,
				'productImageURL' => 'assets/images/products/30.jpg'



				)
			
			);
			?>

		<div class="title">
			<h3>hot products</h3>
			<hr>
		</div>
		
		<div class="featured-product">
			<?php $delay = 0; ?>
			<?php foreach($products as $product):?>
				<div class="item category-product">
					<div class="products grid-v2 wow fadeInUp" data-wow-delay="<?php echo (float)($delay/10);?>s"> 
						<?php displayProduct($product['product_name'], $product['is_new'],$product['is_sale'],$product['is_hot'],$product['productImageURL']) ; ?>
					</div><!-- /.products -->
				</div><!-- /.item -->
				<?php $delay++; ?>	
			<?php endforeach;?>
		</div><!-- /.fashion-featured -->
<!-- ============================================== FOOD FEATURED : END ============================================== -->