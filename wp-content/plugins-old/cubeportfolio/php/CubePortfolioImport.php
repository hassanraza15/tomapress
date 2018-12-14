<?php

/**
*
*/
class CubePortfolioImport
{

    // wordpress global db
    public $wpdb;

    function __construct()
    {
        global $wpdb;

        // store global db instance
        $this->wpdb = $wpdb;

        $import_data = '';

        //check if this is an ajax request
        if (!isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
            echo 0;
            die();
        }

        if ($_FILES['file']['error'] > 0) {
            echo 0;
            die();
        }else {
            $ext = explode(".", $_FILES['file']['name']);
            $file_ext = strtolower(end($ext));

            if ($file_ext == 'json') {
                $encode_data = file_get_contents($_FILES['file']['tmp_name']);
                $import_data = json_decode($encode_data, true);
            } else {
                echo 0;
                die();
            }
        }

        if (!$import_data) {
            echo 0;
            die();
        }

        $cbp_items = $this->process_cbp_items($import_data['cbp_items']);
        $cbp = $this->process_cbp($import_data['cbp']);


        // update settings
        update_option('cubeportfolio_settings', $import_data['settings']);

        foreach ($cbp as $value) {
            $exist = $this->wpdb->get_var('SELECT id FROM ' . CubePortfolioMain::$table_cbp . ' WHERE id = ' . $value['id']);

            if (!$exist) {
                $this->wpdb->insert(CubePortfolioMain::$table_cbp, $value);
            }

        }

        foreach ($cbp_items as $value) {
            $exist = $this->wpdb->get_var('SELECT id FROM ' . CubePortfolioMain::$table_cbp_items . ' WHERE id = ' . $value['id']);

            if (!$exist) {
                $this->wpdb->insert(CubePortfolioMain::$table_cbp_items, $value);
            }
        }

        echo 1;
        die();

    }

    private function process_cbp_items($items)
    {
        $home_url = get_home_url();

        foreach ($items as $key => $value) {

            preg_match_all("/{{post_id (.*?)}}/", $value['items'], $output_array);

            if (count($output_array)) {

                foreach ($output_array[1] as $key1 => $value1) {
                    $url = '';

                    $id = $output_array[1][$key1];

                    $post = get_post($id);

                    if ($post && $post->post_type == 'attachment') {
                        $url = wp_get_attachment_url($id);
                    } else {
                        if ( $this->is_custom_post_type($post) ) {
                            $url = get_post_permalink($id);
                        } else {
                            $url = get_permalink($id);
                        }
                    }
                    $output_array[1][$key1] = $url;
                }

                $items[$key]['items'] = str_replace($output_array[0], $output_array[1], $value['items']);
                $items[$key]['items'] = str_replace('{{home_url}}', $home_url, $items[$key]['items']);

            }
        }

        return $items;

    }

    private function process_cbp($cbp)
    {
        $home_url = get_home_url();

        foreach ($cbp as $key => $value) {

            preg_match_all("/{{post_id (.*?)}}/", $value['popup'], $output_array);

            if (count($output_array)) {

                foreach ($output_array[1] as $key1 => $value1) {
                    $url = '';

                    $id = $output_array[1][$key1];

                    $post = get_post($id);

                    if ($post && $post->post_type == 'attachment') {
                        $url = wp_get_attachment_url($id);
                    } else {
                        if ( $this->is_custom_post_type($post) ) {
                            $url = get_post_permalink($id);
                        } else {
                            $url = get_permalink($id);
                        }
                    }
                    $output_array[1][$key1] = $url;
                }

                $cbp[$key]['popup'] = str_replace($output_array[0], $output_array[1], $value['popup']);
                $cbp[$key]['popup'] = str_replace('{{home_url}}', $home_url, $cbp[$key]['popup']);

            }
        }

        return $cbp;

    }

    /**
     * Check if a post is a custom post type.
     * @param  mixed $post Post object or ID
     * @return boolean
     */
    function is_custom_post_type( $post = NULL )
    {
        $all_custom_post_types = get_post_types( array ( '_builtin' => FALSE ) );

        // there are no custom post types
        if ( empty ( $all_custom_post_types ) ) {
            return FALSE;
        }

        $custom_types      = array_keys( $all_custom_post_types );
        $current_post_type = get_post_type( $post );

        // could not detect current type
        if ( ! $current_post_type )
            return FALSE;

        return in_array( $current_post_type, $custom_types );
    }



}

