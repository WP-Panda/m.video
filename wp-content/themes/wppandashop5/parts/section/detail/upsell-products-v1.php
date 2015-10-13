<!-- ========================================== UPSELL PRODUCTS-V1 ========================================= -->
<?php 
$products = array(
	array(
		'product_name' => 'Product name #01',
		'is_new' => true,
		'is_sale' =>false,
		'is_hot' =>false,
		'productImageURL' => 'assets/images/products/117.jpg'


		),
	array(
		'product_name' => 'Product name #01',
		'is_new' => false,
		'is_sale' =>true,
		'is_hot' =>false,
		'productImageURL' => 'assets/images/products/118.jpg'



		),
	array(
		'product_name' => 'Product name #01',
		'is_new' => false,
		'is_sale' =>false,
		'is_hot' =>true,
		'productImageURL' => 'assets/images/products/119.jpg'


		),
	array(
		'product_name' => 'Product name #01',
		'is_new' => false,
		'is_sale' =>false,
		'is_hot' =>true,
		'productImageURL' => 'assets/images/products/116.jpg'


		),
	array(
		'product_name' => 'Product name #01',
		'is_new' => false,
		'is_sale' =>true,
		'is_hot' =>false,
		'productImageURL' => 'assets/images/products/115.jpg'


		),
	array(
		'product_name' => 'Product name #01',
		'is_new' => true,
		'is_sale' =>false,
		'is_hot' =>false,
		'productImageURL' => 'assets/images/products/112.jpg'


		),
	array(
		'product_name' => 'Product name #01',
		'is_new' => true,
		'is_sale' =>false,
		'is_hot' =>false,
		'productImageURL' => 'assets/images/products/117.jpg'

		),
	array(
		'product_name' => 'Product name #01',
		'is_new' => false,
		'is_sale' =>true,
		'is_hot' =>false,
		'productImageURL' => 'assets/images/products/118.jpg'



		),
	array(
		'product_name' => 'Product name #01',
		'is_new' => false,
		'is_sale' =>false,
		'is_hot' =>true,
		'productImageURL' => 'assets/images/products/119.jpg'


		),
	array(
		'product_name' => 'Product name #01',
		'is_new' => true,
		'is_sale' =>false,
		'is_hot' =>false,
		'productImageURL' => 'assets/images/products/116.jpg'


		),
	array(
		'product_name' => 'Product name #01',
		'is_new' => false,
		'is_sale' =>true,
		'is_hot' =>false,
		'productImageURL' => 'assets/images/products/115.jpg'



		),
	array(
		'product_name' => 'Product name #01',
		'is_new' => false,
		'is_sale' =>false,
		'is_hot' =>true,
		'productImageURL' => 'assets/images/products/112.jpg'

		)
	
	);

	?>
<h3 class="section-title">Weekly featured</h3>
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
<!-- ========================================== UPSELL PRODUCTS-V1 : END========================================= -->