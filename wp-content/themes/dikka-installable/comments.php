<?php // Exit if accessed directly
if (!defined('ABSPATH')) {echo '<h1>Forbidden</h1>'; exit();} ?>

<?php if (comments_open()) : ?>
<div class="space"></div>
    <section id="comments" class="well well-sm">

        <?php if ( post_password_required() ) : ?>
            <p class="nopassword">
                <?php _e( 'This post is password protected. Enter the password to view any comments.', 'dikka' ); ?>
            </p>
        <?php return; endif; ?>

        <?php
        $ncom = get_comments_number();
        if ($ncom>0) :

            echo '<h3 class="widgettitle">&nbsp;';
            _e('Comments','dikka');
            echo '&nbsp;(';
            if ($ncom==1) _e('1', 'dikka'); else echo sprintf (__('%s','dikka'), $ncom);
            echo ')</h3>';

            if ($ncom >= get_option('comments_per_page') && get_option('page_comments')) : ?>
                <nav id="comment-nav-above">
                    <?php paginate_comments_links(); ?>
                </nav>
            <?php endif; ?>

            <div class="commentlist">
                <?php
                // Comment List
                $args = array (
                    'paged' => true,
                    'avatar_size'       => 70,
                    'callback'=> 'dikka_comment',
                    'style'=> 'div',

                );

                wp_list_comments($args);
                ?>
            </div>

            <?php if ($ncom >= get_option('comments_per_page') && get_option( 'page_comments' ) ) : ?>
                <nav id="comment-nav-below">
                    <?php paginate_comments_links(); ?>
                </nav>
            <?php endif; ?>

        <?php endif; ?>

        <div class="clearfix"></div><br />

        <?php
        // Comment Form
        $aria_req = ( $req ? " aria-required='true'" : '' );
        $fields =  array(
            'author' => '<div class="name"><span>' . ( $req ? '*' : '' ) . __( 'Name', 'dikka' ) . '</span> ',
                        '<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' /></div>',
            'email'  => '<div class="email"><span>' . ( $req ? '*' : '' ) . __( 'Email', 'dikka' ) . '</span> ',
                        '<input id="email" name="email" type="email" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . ' /></div>'
        );
        $args = array (
            'id_submit' => 'comment-submit',
            'comment_field' =>  '<div class="message"><span>' . __( 'Comment', 'dikka' ) .
    '</span><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true">' .
    '</textarea></div>',
    'comment_notes_after' => '<button class="btn-color btn-color-1 btn-color-1d" type="submit" id="submit"><span>'.__('Post Comment').'</span></button>' ,
            'fields' => apply_filters( 'comment_form_default_fields', $fields ),
            'logged_in_as' => '<p class="logged-in-as">' . sprintf( __( 'Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>','dikka'), get_edit_user_link(), $user_identity, wp_logout_url( apply_filters( 'the_permalink', get_permalink($post->ID) ) ) ) . '</p>',
            
        );
        comment_form($args);


        ?>

    </section>

<?php endif; ?>