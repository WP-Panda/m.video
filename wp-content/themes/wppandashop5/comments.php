<?php

if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
    die ('Please do not load this page directly. Thanks!');

if ( post_password_required() ) {
    return;
}
?>


<?php function mytheme_comment($comment, $args, $depth){
    $GLOBALS['comment'] = $comment;
    switch( $comment->comment_type ) :
        case 'pingback' :
        case 'trackback' : ?>
            <li <?php comment_class('media'); ?> id="comment<?php comment_ID(); ?>">
            <div class="back-link"><?php comment_author_link(); ?></div>
            <?php break;
        default : ?>
            <li <?php comment_class('media'); ?> id="comment-<?php comment_ID(); ?>">
            <article <?php comment_class(); ?> class="comment">

                <div class="media-left">
                    <?php echo get_avatar( $comment, 70 ); ?>
                </div>

                <div class="media-body">
                        <h4 class="author-name media-heading"><?php comment_author(); ?></h4>
                        <div class="comment-action">
                            <ul class="list-inline list-unstyled">
                                <li>
                                    <time <?php comment_time( 'c' ); ?> class="comment-time">
                                        <span class="date">
                                            <?php comment_date(); ?>
                                        </span>
                                        <span class="time">
                                            <?php comment_time(); ?>
                                        </span>
                                </li>
                                <li>
                                    <div class="reply"><?php
                                        comment_reply_link( array_merge( $args, array(
                                            'reply_text' => __('Reply','wppandashop5'),
                                            'depth' => $depth,
                                            'max_depth' => $args['max_depth']
                                        ) ) ); ?>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    <?php comment_text(); ?>
                </div>

            </article>
            <?php
            break;
    endswitch;

} ?>
<?php if ( have_comments() ) : ?>
    <div id="comments" class="blog-comments wow fadeInUp">
            <h3 class="title"><?php comments_number(__('no comments'), __('one comment'), __('% comments')); ?></h3>

            <div class="main-box-inside content-inside">
                <ul class="comment-list">
                    <?php $args = array(
                        'format' => 'html5',
                        'callback' => 'mytheme_comment'
                    );?>
                    <?php wp_list_comments($args); ?>
                </ul>
            </div>

            <div class="navigation">
                <?php paginate_comments_links(); ?>
            </div>

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
        'must_log_in' => '<div class="col-md-12 must-log-in">' . sprintf( __('You must be <a href="%s">logged in</a> to post a comment.','wppandashop5'), wp_login_url( apply_filters( 'the_permalink', get_permalink() ) ) ) . '</div>',
        'logged_in_as' => '<div class="col-md-12 logged-in-as">' . sprintf(__( 'Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>','wppandashop5' ), admin_url( 'profile.php' ), $user_identity, wp_logout_url( apply_filters( 'the_permalink', get_permalink( ) ) ) ) . '</div>',
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
