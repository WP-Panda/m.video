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
		
			?>
		<h3 class="section-title">featured</h3>
		<div class="featured-product wow fadeInUp">
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