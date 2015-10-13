	<div class="box-wrapper">
		<div class="custom-container">
			<div class="wrapper-body-inner">
				<?php 
					if( $page != 'fashion-v3' && $page != 'fashion-v6'){
						$header_style = isset( $_GET['h'] ) ? $_GET['h'] : 5;
					} else {
						$header_style = 9;
					}
					require RB_ROOT.'/parts/section/header/header-v'.$header_style.'.php';
				?>
					
				<?php require_once RB_ROOT.'/pages/'.$page.'.php'; ?>
			
			</div><!-- /.wrapper-body-inner -->
			<?php 
				$footer_style = isset( $_GET['f'] ) ? $_GET['f'] : 1;
				require RB_ROOT.'/parts/section/footer/footer-v'.$footer_style.'.php';
			?>
		</div><!-- /.wrapper-inner -->
	</div><!-- /.box -->
