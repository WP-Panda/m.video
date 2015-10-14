<!-- ============================================== SIDEMENU  ============================================== -->
<div class="side-menu">
	<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
		<h3 class="section-title">category</h3>
		<div class="panel panel-default wow fadeIn" data-wow-delay="0.2s">
			<div class="panel-heading" role="tab" id="headingOne">
				<h4 class="panel-title">
					<a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
						Women
					</a>
				</h4>
			</div><!-- /.panel-heading -->
			<div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
				<div class="panel-body">
					<?php get_template_part('templates/components/sidebar/sidebar-category','items'); ?>
				</div><!-- /.panel-body -->
			</div><!-- /.panel-collapse -->
		</div><!-- /.panel -->
		<div class="panel panel-default wow fadeIn" data-wow-delay="0.2s">
			<div class="panel-heading" role="tab" id="headingTwo">
				<h4 class="panel-title">
					<a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
						Men
					</a>
				</h4>
			</div><!-- /.panel-heading -->
			<div id="collapseTwo" class="panel-collapse collapse " role="tabpanel" aria-labelledby="headingTwo">
				<div class="panel-body">
					<?php get_template_part('templates/components/sidebar/sidebar-category','items'); ?>
				</div><!-- /.panel-body -->
			</div><!-- /.panel-collapse -->
		</div><!-- /.panel -->
		<div class="panel panel-default wow fadeIn" data-wow-delay="0.2s">
			<div class="panel-heading" role="tab" id="headingThree">
				<h4 class="panel-title">
					<a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
						Kids
					</a>
				</h4>
			</div><!-- /.panel-heading -->
			<div id="collapseThree" class="panel-collapse collapse " role="tabpanel" aria-labelledby="headingThree">
				<div class="panel-body">
					<?php get_template_part('templates/components/sidebar/sidebar-category','items'); ?>
				</div><!-- /.panel-body -->
			</div><!-- /.panel-collapse -->
		</div><!-- /.panel -->
		<div class="panel panel-default wow fadeIn" data-wow-delay="0.2s">
			<div class="panel-heading" role="tab" id="headingFour">
				<h4 class="panel-title no-items">
					<a class="collapsed" href="#" data-toggle="collapse" data-parent="#accordion">
						Accessories
					</a>
				</h4>
			</div><!-- /.panel-heading -->
		
		</div><!-- /.panel -->
		<div class="panel panel-default wow fadeIn" data-wow-delay="0.2s">
			<div class="panel-heading" role="tab" id="headingFive">
				<h4 class="panel-title">
					<a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
						Dress
					</a>
				</h4>
			</div><!-- /.panel-heading -->
			<div id="collapseFive" class="panel-collapse collapse " role="tabpanel" aria-labelledby="headingFive">
				<div class="panel-body">
					<?php get_template_part('templates/components/sidebar/sidebar-category','items'); ?>
				</div><!-- /.panel-body -->
			</div><!-- /.panel-collapse -->
		</div><!-- /.dropdown -->
		<div class="panel panel-default wow fadeIn" data-wow-delay="0.2s">
			<div class="panel-heading" role="tab" id="headingSix">
				<h4 class="panel-title">
					<a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
						Shoes
					</a>
				</h4>
			</div><!-- /.panel-heading -->
			<div id="collapseSix" class="panel-collapse collapse " role="tabpanel" aria-labelledby="headingSix">
				<div class="panel-body">
					<?php get_template_part('templates/components/sidebar/sidebar-category','items'); ?>
				</div><!-- /.panel-body -->
			</div><!-- /.panel-collapse -->
		</div><!-- /.panel -->
	</div><!-- /.panel-group -->
</div><!-- side-menu" -->
<!-- ============================================== SIDEMENU : END ============================================== -->