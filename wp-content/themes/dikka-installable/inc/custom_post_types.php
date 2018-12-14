<?php

// Register Custom Post Type
function testimonial_post_type() {

    $labels = array(
        'name'                => _x( 'Testimonials', 'Post Type General Name', 'dikka' ),
        'singular_name'       => _x( 'Testimonial', 'Post Type Singular Name', 'dikka' ),
        'menu_name'           => __( 'Testimonial', 'dikka' ),
        'parent_item_colon'   => __( 'Parent Testimonial:', 'dikka' ),
        'all_items'           => __( 'All Testimonials', 'dikka' ),
        'view_item'           => __( 'View Testimonial', 'dikka' ),
        'add_new_item'        => __( 'Add New Testimonial', 'dikka' ),
        'add_new'             => __( 'Add New', 'dikka' ),
        'edit_item'           => __( 'Edit Testimonial', 'dikka' ),
        'update_item'         => __( 'Update Testimonial', 'dikka' ),
        'search_items'        => __( 'Search Testimonial', 'dikka' ),
        'not_found'           => __( 'Not found', 'dikka' ),
        'not_found_in_trash'  => __( 'Not found in Trash', 'dikka' ),
    );
    $args = array(
        'label'               => __( 'testimonial_type', 'dikka' ),
        'description'         => __( 'You can create testimonials slider from here.', 'dikka' ),
        'labels'              => $labels,
        'supports'            => array( 'title', 'editor', ),
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 60,
        'can_export'          => true,
        'has_archive'         => true,
        'exclude_from_search' => true,
        'publicly_queryable'  => true,
        'capability_type'     => 'page',
    );
    register_post_type( 'testimonial', $args );

}

function testimonial_add_meta_box() {

    $screens = array( 'testimonial');

    foreach ( $screens as $screen ) {

        add_meta_box(
            'testimonial',
            __( 'Testimonial Details', 'dikka' ),
            'testimonial_meta_box_callback',
            $screen
        );
    }
}
add_action( 'add_meta_boxes', 'testimonial_add_meta_box' );

function testimonial_meta_box_callback( $post ) {

    // Add an nonce field so we can check for it later.
    wp_nonce_field( 'testimonial_meta_box', 'testimonial_meta_box_nonce' );

    /*
     * Use get_post_meta() to retrieve an existing value
     * from the database and use the value for the form.
     */
    $value1 = get_post_meta( $post->ID, 'testimonial_person_name', true );
    $value2 = get_post_meta( $post->ID, 'testimonial_person_post', true );
    $value3 = get_post_meta( $post->ID, 'testimonial_person_image', true );
    $value4 = get_post_meta( $post->ID, 'testimonial_person_url', true );

    echo '<label for="testimonial_new_field">';
    _e( 'Name of the client', 'dikka' );
    echo '</label> ';
    echo '<input type="text" id="testimonial_person_name" name="testimonial_person_name" value="' . esc_attr( $value1 ) . '" size="50" />';

    echo '<br><br><label for="testimonial_new_field">';
    _e( 'Post of the client', 'dikka' );
    echo '</label> ';
    echo '<input type="text" id="testimonial_person_post" name="testimonial_person_post" value="' . esc_attr( $value2 ) . '" size="50" />';

     echo '<br><br><label for="testimonial_new_field">';
    _e( 'URL of the client', 'dikka' );
    echo '</label> ';
    echo '<input type="text" id="testimonial_person_url" name="testimonial_person_url" value="' . esc_attr( $value4 ) . '" size="50" />';

    echo '<br><br><label for="testimonial_new_field">';
    _e( 'Image of the client', 'dikka' );
    echo '</label><br> ';
    ?>

<style> .media-upload h2 { font-weight: bold; } </style>

<script>
jQuery(document).ready(function($){
  var _custom_media = true,
      _orig_send_attachment = wp.media.editor.send.attachment;

  $('.uploader .button').click(function(e) {
    var send_attachment_bkp = wp.media.editor.send.attachment;
    var button = $(this);
    var id = button.attr('id').replace('_button', '');
    _custom_media = true;
    wp.media.editor.send.attachment = function(props, attachment){
      if ( _custom_media ) {
        $("#"+id).val(attachment.url);
      } else {
        return _orig_send_attachment.apply( this, [props, attachment] );
      };
    }

    wp.media.editor.open(button);
    return false;
  });

  $('.add_media').on('click', function(){
    _custom_media = false;
  });
});
</script>

<div class="uploader">
  <input type="text" name="testimonial_person_image" id="testimonial_person_image" value="<?php echo esc_attr( $value3 ); ?>" />
  <input class="button" name="testimonial_person_image_button" id="testimonial_person_image_button" value="Upload" />
</div>

<?php 

}

function admin_scripts()
{
   wp_enqueue_script('media-upload');

}
add_action('admin_enqueue_scripts', 'admin_scripts');


function testimonial_save_meta_box_data( $post_id ) {

    /*
     * We need to verify this came from our screen and with proper authorization,
     * because the save_post action can be triggered at other times.
     */

    // Check if our nonce is set.
    if ( ! isset( $_POST['testimonial_meta_box_nonce'] ) ) {
        return;
    }

    // Verify that the nonce is valid.
    if ( ! wp_verify_nonce( $_POST['testimonial_meta_box_nonce'], 'testimonial_meta_box' ) ) {
        return;
    }

    // If this is an autosave, our form has not been submitted, so we don't want to do anything.
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    // Check the user's permissions.
    if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {

        if ( ! current_user_can( 'edit_page', $post_id ) ) {
            return;
        }

    } else {

        if ( ! current_user_can( 'edit_post', $post_id ) ) {
            return;
        }
    }

    /* OK, it's safe for us to save the data now. */
    
    // Sanitize user input.
    $my_data1 = sanitize_text_field( $_POST['testimonial_person_name'] );
    $my_data2 = sanitize_text_field( $_POST['testimonial_person_post'] );
    $my_data3 = sanitize_text_field( $_POST['testimonial_person_image'] );
    $my_data4 = sanitize_text_field( $_POST['testimonial_person_url'] );

    // Update the meta field in the database.
    update_post_meta( $post_id, 'testimonial_person_name', $my_data1 );
    update_post_meta( $post_id, 'testimonial_person_post', $my_data2 );
    update_post_meta( $post_id, 'testimonial_person_image', $my_data3);
    update_post_meta( $post_id, 'testimonial_person_url', $my_data4);
}
add_action( 'save_post', 'testimonial_save_meta_box_data' );


// Hook into the 'init' action
add_action( 'init', 'testimonial_post_type', 0 );


global $metaboxes;
$metaboxes = array(
    'link_url' => array(
        'title' => __('Link Settings', 'dikka'),
        'applicableto' => 'post',
        'location' => 'normal',
        'display_condition' => 'post-format-link',
        'priority' => 'high',
        'fields' => array(
            'l_url' => array(
                'title' => __('link url:', 'dikka'),
                'type' => 'text',
                'description' => '',
                'size' => 60
            )
        )
    ),
    
    'video_code' => array(
        'title' => __('Video Settings', 'dikka'),
        'applicableto' => 'post',
        'location' => 'normal',
        'display_condition' => 'post-format-video',
        'priority' => 'high',
        'fields' => array(
            'video_id' => array(
                'title' => __('Video url:', 'dikka'),
                'type' => 'text',
                'description' => '',
                'size' => 60
            )
        )
    ),
    
    'audio_code' => array(
        'title' => __('Audio Settings', 'dikka'),
        'applicableto' => 'post',
        'location' => 'normal',
        'display_condition' => 'post-format-audio',
        'priority' => 'high',
        'fields' => array(
            'audio_id' => array(
                'title' => __('Audio url:', 'dikka'),
                'type' => 'text',
                'description' => '',
                'size' => 60
            )
        )
    ),

    'quote_author' => array(
        'title' => __('Quote Settings', 'dikka'),
        'applicableto' => 'post',
        'location' => 'normal',
        'display_condition' => 'post-format-quote',
        'priority' => 'high',
        'fields' => array(
            'q_author' => array(
                'title' => __('quote author:', 'dikka'),
                'type' => 'text',
                'description' => '',
                'size' => 20
            )
        )
    )
);

add_action( 'add_meta_boxes', 'dikka_add_post_format_metabox' );
 
function dikka_add_post_format_metabox() {
    global $metaboxes;
 
    if ( ! empty( $metaboxes ) ) {
        foreach ( $metaboxes as $id => $metabox ) {
            add_meta_box( $id, $metabox['title'], 'dikka_show_metaboxes', $metabox['applicableto'], $metabox['location'], $metabox['priority'], $id );
        }
    }
}

function dikka_show_metaboxes( $post, $args ) {
    global $metaboxes;
 
    $custom = get_post_custom( $post->ID );
    $fields = $tabs = $metaboxes[$args['id']]['fields'];
 
    /** Nonce **/
    $output = '<input type="hidden" name="post_format_meta_box_nonce" value="' . wp_create_nonce( basename( __FILE__ ) ) . '" />';
 
    if ( sizeof( $fields ) ) {
        foreach ( $fields as $id => $field ) {
            switch ( $field['type'] ) {
                default:
                case "text":
                    if(isset($custom[$id][0])) {
                    $output .= '<label for="' . $id . '">' . $field['title'] . '</label><input id="' . $id . '" type="text" name="' . $id . '" value="' . $custom[$id][0] . '" size="' . $field['size'] . '" />';
                    } else {
                    $output .= '<label for="' . $id . '">' . $field['title'] . '</label><input id="' . $id . '" type="text" name="' . $id . '" value="" size="' . $field['size'] . '" />';
                    }
                    break;
            }
        }
    }
 
    echo $output;
}


add_action( 'save_post', 'dikka_save_metaboxes' );
 
function dikka_save_metaboxes( $post_id ) {
    global $metaboxes;
 
    // verify nonce
    
    if(isset($_POST['post_format_meta_box_nonce'])){
    if ( ! wp_verify_nonce( $_POST['post_format_meta_box_nonce'], basename( __FILE__ ) ) )
        return $post_id;
    }

    // check autosave
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
        return $post_id;
 
    // check permissions
    if ( isset( $_POST['post_type'] ) &&  'page' == $_POST['post_type'] ) {
        if ( ! current_user_can( 'edit_page', $post_id ) )
            return $post_id;
    } elseif ( ! current_user_can( 'edit_post', $post_id ) ) {
        return $post_id;
    }
 
    $post_type = get_post_type();

    // loop through fields and save the data
    foreach ( $metaboxes as $id => $metabox ) {
        // check if metabox is applicable for current post type
        if ( $metabox['applicableto'] == $post_type ) {
            $fields = $metaboxes[$id]['fields'];
 
            foreach ( $fields as $id => $field ) {
                $old = get_post_meta( $post_id, $id, true );
                if(isset($_POST[$id])) {
                    $new = $_POST[$id];
     
                    if ( $new && $new != $old ) {
                        update_post_meta( $post_id, $id, $new );
                    }
                    elseif ( '' == $new && $old || ! isset( $_POST[$id] ) ) {
                        delete_post_meta( $post_id, $id, $old );
                    }
                }
            }
        }
    }
}


add_action( 'admin_print_scripts', 'dikka_display_metaboxes', 1000 );
function dikka_display_metaboxes() {
    global $metaboxes;
    if ( get_post_type() == "post" ) :
        ?>
        <script type="text/javascript">// <![CDATA[
            $ = jQuery;
 
            <?php
            $formats = $ids = array();
            foreach ( $metaboxes as $id => $metabox ) {
                array_push( $formats, "'" . $metabox['display_condition'] . "': '" . $id . "'" );
                array_push( $ids, "#" . $id );
            }
            ?>
 
            var formats = { <?php echo implode( ',', $formats );?> };
            var ids = "<?php echo implode( ',', $ids ); ?>";
             function displayMetaboxes() {
                // Hide all post format metaboxes
                $(ids).hide();
                // Get current post format
                var selectedElt = $("input[name='post_format']:checked").attr("id");
 
                // If exists, fade in current post format metabox
                if ( formats[selectedElt] )
                    $("#" + formats[selectedElt]).fadeIn();
            }
 
            $(function() {
                // Show/hide metaboxes on page load
                displayMetaboxes();
 
                // Show/hide metaboxes on change event
                $("input[name='post_format']").change(function() {
                    displayMetaboxes();
                });
            });
 
        // ]]></script>
        <?php
    endif;
}

function be_attachment_field_credit( $form_fields, $post ) {
    $form_fields['destination_url'] = array(
        'label' => 'Destination',
        'input' => 'text',
        'value' => get_post_meta( $post->ID, 'destination_url', true ),
        'helps' => 'Add destination URL',
    );
    return $form_fields;
}
add_filter( 'attachment_fields_to_edit', 'be_attachment_field_credit', 10, 2 );

function be_attachment_field_credit_save( $post, $attachment ) {
    if( isset( $attachment['destination_url'] ) )
    update_post_meta( $post['ID'], 'destination_url', esc_url( $attachment['destination_url'] ) );
    return $post;
}
add_filter( 'attachment_fields_to_save', 'be_attachment_field_credit_save', 10, 2 );

?>