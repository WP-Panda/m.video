<?php global $wps5_option;
if( !empty( $wps5_option['site_layout_mode'] && 'box' === $wps5_option['site_layout_mode']) ) {
    echo '</div><!-- /.wrapper-body-inner -->
        </div><!-- /.wrapper-inner -->
	</div><!-- /.box -->';

} else {
    echo '</div><!-- /.box -->';
}

wp_footer(); ?>
</body>
</html>