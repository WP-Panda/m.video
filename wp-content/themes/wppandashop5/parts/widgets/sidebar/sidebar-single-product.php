<!-- ============================================== SIDEBAR SINGLE PRODUCT ============================================== -->
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
<h3 class="section-title">related product</h3>
<div class="sidebar-single-product">
	<?php foreach($products as $product):?>
		<div class="item category-product">
			<div class="products grid-v2">
				<?php displayProduct($product['product_name'], $product['is_new'],$product['is_sale'],$product['is_hot'],$product['productImageURL']) ; ?>
			</div><!-- /.products -->
		</div><!-- /.item -->
	<?php endforeach;?>
</div><!-- /.fashion-featured -->
<!-- ============================================== SIDEBAR SINGLE PRODUCT : END ============================================== -->
