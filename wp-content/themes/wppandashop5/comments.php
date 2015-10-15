<?php

if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
    die ('Please do not load this page directly. Thanks!');

if ( post_password_required() ) {
    return;
}
?>

<?php if ( have_comments() ) : ?>
    <div id="comments" class="comments-main">
        <div class="comments-holder main-box">
            <h3 class="comment-title main-box-title"><?php comments_number(__('no_comments'), __('one_comment'), __('comments_number')); ?></h3>

            <div class="main-box-inside content-inside">
                <ul class="comment-list">
                    <?php $args = array(
                        'avatar_size' => 75,
                        'reply_text' => __('reply_comment'),
                        'format' => 'html5'
                    );?>
                    <?php wp_list_comments($args); ?>
                </ul><!--END comment-list-->
            </div>

            <div class="navigation">
                <?php paginate_comments_links(); ?>
            </div>
        </div><!--END comments holder -->
    </div>
<?php endif; ?>

<?php if(comments_open()) : ?>
    <?php

    $commenter = wp_get_current_commenter();
    $req = get_option( 'require_name_email' );
    $aria_req = ( $req ? " aria-required='true'" : '' );

    $comment_form_args = array(
        'comment_notes_after' => '',
        'cancel_reply_link' => __( 'cancel_reply_link' ),
        'label_submit'      => __( 'Send Comment', 'wppandashop5'),
        'submit_button'     =>
            '<div class="col-md-12 outer-bottom-small">'.
            '<input name="%1$s" type="submit" id="%2$s" class="%3$s bbtn-upper btn btn-primary checkout-page-button" value="%4$s" />'.
            '</div>',
        'title_reply' => '<div class="col-md-12"><h4>' . __( 'leave a comment','wppandashop5' ) . '</h4></div>',
        'must_log_in' => '<p class="must-log-in">' . sprintf( __('must log in','wppandashop5'), wp_login_url( apply_filters( 'the_permalink', get_permalink() ) ) ) . '</p>',
        'logged_in_as' => '<p class="logged-in-as">' . sprintf(__( 'logged in as','wppandashop5' ), admin_url( 'profile.php' ), $user_identity, wp_logout_url( apply_filters( 'the_permalink', get_permalink( ) ) ) ) . '</p>',
        'comment_notes_before' => '',
        'comment_notes_after' => '',
        'comment_field' =>
            '<div class="col-md-12">' .
            '<div class="form-group">' .
            '<textarea id="comment" class="form-control" name="comment" cols="45" rows="8" aria-required="true" placeholder="' . __( 'Your Comment','wppandashop5' ) . '"></textarea>'.
            '</div>'.
            '</div>',
        'fields' => apply_filters( 'comment_form_default_fields', array(
                'author' =>
                    '<div class="col-md-4">' .
                    '<div class="form-group">' .
                    '<input id="author" class="form-control text-input" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) .
                    '" size="30"' . $aria_req . ' placeholder="' . __( 'Your Name','wppandashop5' ) . ( $req ? ' *' : '' ) . '"/>'.
                    '</div>' .
                    '</div>',

                'email' =>
                    '<div class="col-md-4">' .
                    '<div class="form-group">' .
                    '<input id="email" class="form-control text-input" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) .
                    '" size="30"' . $aria_req . ' placeholder="' . __( 'Your email','wppandashop5' ) . ( $req ? ' *' : '' ) . '"/></p>'.
                    '</div>' .
                    '</div>',

                'url' =>
                    '<div class="col-md-4">' .
                    '<div class="form-group">' .
                    '<input id="url" class="form-control text-input"  name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) .
                    '" size="30" placeholder="' . __( 'Your website','wppandashop5' ) . '" />' .
                    '</div>' .
                    '</div>',
            )
        ),
    );

    ?>

    <div class="blog-write-comment wow fadeInUp">
        <div class="row">
            <?php comment_form($comment_form_args); ?>
        </div>
    </div>
<?php endif;
