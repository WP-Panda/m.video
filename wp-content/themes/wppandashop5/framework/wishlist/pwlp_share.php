<div class="pwlp_share">
    <h4 class="pwlp_title"><?php echo (isset($tit_social_net) && !empty($tit_social_net))? $tit_social_net:'Share On:';  ?></h4>
    <ul>
        <?php if( $share_fb==1): ?>
            <li style="list-style-type: none; display: inline-block;">
                <a href="#" class="facebook" data-social='{"type":"facebook", "url":"<?php echo get_site_url(); ?>", "text": "<?php echo $pwlp_msg_text; ?>"}' title="<?php// echo $pcp_social_net_text;?>"><img src="<?php echo plugin_dir_url( __FILE__ ).'images/facebook.png';?>"></a>
            </li>
        <?php endif; ?>

        <?php if( $share_twt==1 ): ?>
            <li style="list-style-type: none; display: inline-block;">
                <a href="#" class="twitter" data-social='{"type":"twitter", "url":"<?php echo get_site_url(); ?>", "text": "<?php echo $pwlp_msg_text; ?>"}' title="<?php echo $pcp_social_net_text;?>"><img src="<?php echo plugin_dir_url( __FILE__ ).'images/Twitter.png';?>"></a>
            </li>
        <?php endif; ?>

        <?php if($share_pin==1): ?>
            <li style="list-style-type: none; display: inline-block;">
                <a href="#" class="pinterest" data-social='{"type":"pinterest", "url":"<?php echo get_site_url(); ?>", "text": "<?php echo $pwlp_msg_text; ?>"}' title="<?php echo $pcp_social_net_text;?>"><img src="<?php echo plugin_dir_url( __FILE__ ).'images/pinterest.png';?>"></a>
            </li>
        <?php endif; ?>

        <?php if( $share_gp==1 ): ?>
            <li style="list-style-type: none; display: inline-block;">
                <a href="#" class="plusone" data-social='{"type":"plusone", "url":"<?php echo get_site_url(); ?>", "text": "<?php echo $pwlp_msg_text; ?>"}' title="<?php echo $pcp_social_net_text;?>"><img src="<?php echo plugin_dir_url( __FILE__ ).'images/google_plus.png';?>"></a>
            </li>
        <?php endif; ?>

    </ul>
</div>