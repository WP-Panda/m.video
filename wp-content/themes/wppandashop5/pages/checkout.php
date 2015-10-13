<!-- ========================================= CONTENT ========================================= -->
<div class="breadcrumb">
	<div class="container">
		<div class="breadcrumb-inner">
			<ul class="list-inline list-unstyled">
				<li><a href="#">Home</a></li>
				<li class='active'>Checkout</li>
			</ul>
		</div><!-- /.breadcrumb-inner -->
	</div><!-- /.container -->
</div><!-- /.breadcrumb -->

<div class="body-content">
	<div class="container">
		<div class="row checkout outer-bottom-sm wow fadeInUp">
			<div class="col-md-9 checkout-steps">
				<div class="panel-group" id="accordion-checkout" role="tablist" aria-multiselectable="true">
					<h3 class="checkout-title">checkout</h3>

					<div class="panel panel-default">
						<div class="panel-heading" role="tab" id="headingOne">
							<h4 class="panel-title">
								<a data-toggle="collapse" data-parent="#accordion-checkout" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
									<span class="step">1</span>Checkout Method
								</a>
							</h4>
						</div><!-- /.panel-heading -->

						<div id="collapseOne" class="panel-collapse collapse " role="tabpanel" aria-labelledby="headingOne">
							<div class="panel-body">
								<?php require RB_ROOT.'/parts/section/checkout/checkout-method.php' ?>
							</div>
						</div><!-- /.panel-collapse -->
					</div><!-- /.panel -->


					<div class="panel panel-default">
						<div class="panel-heading" role="tab" id="headingTwo">
							<h4 class="panel-title">
								<a class="collapsed" data-toggle="collapse" data-parent="#accordion-checkout" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
									<span class="step">2</span>Billing Information
								</a>
							</h4>
						</div><!-- /.panel-heading -->

						<div id="collapseTwo" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingTwo">
							<div class="panel-body">
								<?php require RB_ROOT.'/parts/section/checkout/checkout-billing.php' ?>

							</div>
						</div><!-- /.panel-collapse -->
					</div><!-- /.panel -->


					<div class="panel panel-default">
						<div class="panel-heading" role="tab" id="headingThree">
							<h4 class="panel-title">
								<a class="collapsed" data-toggle="collapse" data-parent="#accordion-checkout" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
									<span class="step">3</span>Shipping Information
								</a>
							</h4>
						</div><!-- /.panel-heading -->
						<div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
							<div class="panel-body">
								<?php require RB_ROOT.'/parts/section/checkout/checkout-shipping.php' ?>

							</div>
						</div><!-- /.panel-collapse -->
					</div><!-- /.panel -->


					<div class="panel panel-default">
						<div class="panel-heading" role="tab" id="headingFour">
							<h4 class="panel-title">
								<a class="collapsed" data-toggle="collapse" data-parent="#accordion-checkout" href="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
									<span class="step">4</span>Shipping Method
								</a>
							</h4>
						</div><!-- /.panel-heading -->
						<div id="collapseFour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFour">
							<div class="panel-body">
								<?php require RB_ROOT.'/parts/section/checkout/checkout-shipping-method.php' ?>

							</div>
						</div><!-- /.panel-collapse -->
					</div><!-- /.panel -->


					<div class="panel panel-default">
						<div class="panel-heading" role="tab" id="headingFive">
							<h4 class="panel-title">
								<a class="collapsed" data-toggle="collapse" data-parent="#accordion-checkout" href="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
									<span class="step">5</span>Payment Information
								</a>
							</h4>
						</div><!-- /.panel-heading -->
						<div id="collapseFive" class="panel-collapse collapse " role="tabpanel" aria-labelledby="headingFive">
							<div class="panel-body">
								Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.

							</div>
						</div><!-- /.panel-collapse -->
					</div><!-- /.panel -->


					<div class="panel panel-default">
						<div class="panel-heading" role="tab" id="headingSix">
							<h4 class="panel-title">
								<a class="collapsed" data-toggle="collapse" data-parent="#accordion-checkout" href="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
									<span class="step">6</span>Order Review
								</a>
							</h4>
						</div><!-- /.panel-heading -->
						<div id="collapseSix" class="panel-collapse collapse " role="tabpanel" aria-labelledby="headingSix">
							<div class="panel-body">
								Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.

							</div>
						</div><!-- /.panel-collapse -->
					</div><!-- /.panel -->
				</div><!-- /.panel-group -->
			</div><!-- /.col -->

			<div class="col-md-3 checkout-sidebar">
				<div class="panel-group">
					<h3 class="checkout-title">categories</h3>
					<div class="panel panel-default">
						<div class="panel-body">
							<ul class="nav nav-checkout-progress list-unstyled">
								<li><a href="#">Billing Address</a></li>
								<li><a href="#">Shipping Address</a></li>
								<li><a href="#">Shipping Method</a></li>
								<li><a href="#">Payment Method</a></li>
							</ul><!-- /.nav-checkout-progress -->
						</div><!-- /.panel-body -->
					</div><!-- /.panel -->
				</div><!-- /.panel-group -->
			</div><!-- /.checkout-sidebar -->
		</div><!-- /.row -->
	</div><!-- /.container -->
</div><!-- /.body-content -->
<!-- ========================================= CONTENT : END========================================= -->
