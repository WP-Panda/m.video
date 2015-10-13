<!-- ========================================== CATEGORY-V3-LIST ========================================= -->
	<?php 
require RB_ROOT.'/parts/product/product-list-item-v3.php'; 
		$listProducts = array(
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


				)
			
			
			);
		$delay = 0; 
		foreach($listProducts as $product):
			?>

			<div class="category-product-inner wow fadeInUp" data-wow-delay="<?php echo (float)($delay/10);?>s"> 
				<div class="products product-item-list-v2">				
		            <?php displayListProduct($product['product_name'], $product['is_new'],$product['is_sale'],$product['is_hot'],$product['productImageURL']) ; ?>
				</div><!-- /.products -->
			</div><!-- /.category-product-inner -->
		<?php $delay++; ?>
	<?php endforeach;?>
<!-- ========================================== CATEGORY-V3-LIST ========================================= -->
	