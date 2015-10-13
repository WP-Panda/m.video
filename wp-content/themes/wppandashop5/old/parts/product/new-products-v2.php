<!-- ============================================== NEW PRODUCT-V2 ============================================== -->

<?php
$sellerProducts = array(
	array(
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


		),

	
	array(
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

		),

	
	array(
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


			),


		),
	array(
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


		),
	array(
		array(
			'product_name' => 'Product name #01',
			'is_new' => false,
			'is_sale' =>false,
			'is_hot' =>true,
			'productImageURL' => 'assets/images/products/4.jpg'


			),
	
		array(
			'product_name' => 'Product name #01',
			'is_new' => true,
			'is_sale' =>false,
			'is_hot' =>false,
			'productImageURL' => 'assets/images/products/1.jpg'


			),


		),
	array(
		array(
			'product_name' => 'Product name #01',
			'is_new' => false,
			'is_sale' =>true,
			'is_hot' =>false,
			'productImageURL' => 'assets/images/products/2.jpg'


			),
	
		array(
			'product_name' => 'Product name #01',
			'is_new' => true,
			'is_sale' =>false,
			'is_hot' =>false,
			'productImageURL' => 'assets/images/products/3.jpg'


			),


		),

	);

?>



<div class="featured-product home-carousel">
	<?php $delay = 0; ?>
	    <?php foreach ($sellerProducts as $products):?>
		    <div class="item">
		    	<div class="products best-product">
		        	<?php foreach ($products as $product):?>
						<div class="products grid-v2  wow fadeInUp" data-wow-delay="<?php echo (float)($delay/10);?>s"> 
							<?php displayProduct($product['product_name'],$product['is_new'],$product['is_sale'],$product['is_hot'],$product['productImageURL']) ?>
						</div>
		        	<?php endforeach; ?>
		    	</div>
		    </div><!-- /.item -->	
	    <?php $delay++; ?>	
	<?php endforeach; ?>
</div><!-- /.featured-product" -->	
	
<!-- ============================================== NEW PRODUCTS-V2 : END ============================================== -->

  