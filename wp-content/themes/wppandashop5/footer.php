<?php global $wps5_option;
if( !empty( $wps5_option['site_layout_mode'] && 'box' === $wps5_option['site_layout_mode']) ) {
    echo '</div><!-- /.wrapper-body-inner -->
        </div><!-- /.wrapper-inner -->
	</div><!-- /.box -->';
}
$header= !empty($wps5_option['footer_layout']) ? $wps5_option['footer_layout'] : 1;
get_template_part( 'templates/footers/footer','v' . $header );
?>
</div><!-- /.box -->
<?php wp_footer(); ?>
</body>
</html>