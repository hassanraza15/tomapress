<?php

/**
*
*/
class CubePortfolioExport
{

    // wordpress global db
    public $wpdb;

    private $link_href = array();

    private $link_id = array();

    function __construct()
    {
        global $wpdb;

        // store global db instance
        $this->wpdb = $wpdb;

        $cbp = $this->wpdb->get_results( 'SELECT * FROM ' . CubePortfolioMain::$table_cbp );
        $items = $this->wpdb->get_results( 'SELECT * FROM ' . CubePortfolioMain::$table_cbp_items );

        $result = array();
        $result['cbp_items'] = $this->parse_cbp_items($items);
        $result['cbp'] = $this->parse_cbp($cbp);
        $result['settings'] = get_option('cubeportfolio_settings');

        header( 'Content-Type: application/json' );
        header( 'Content-Disposition: attachment;filename=cubeportfolio.json');

        echo json_encode($result);
        die();
    }

    private function parse_cbp_items ($items)
    {

        $dom = new DomDocument();

        foreach ($items as $key => $value) {
            $html_code = $items[$key]->items;
            $dom->loadHTML($html_code); // html code
            $xpath = new DOMXpath($dom);

            // replace images with a custom markup that includes the id from db
            $html_code = $this->replace_img($xpath->query('//img'), $html_code);

            // replace href with a custom markup that includes the id from db
            $html_code = $this->replace_href($xpath->query('//a'), $html_code);

            $items[$key]->items = $html_code;
        }

        return $items;

    }

    private function parse_cbp($cbp)
    {
        foreach ($cbp as $key => $value) {
            $cbp[$key]->popup = str_replace($this->link_href, $this->link_id, $cbp[$key]->popup);
        }

        return $cbp;
    }

    private function replace_img($images, $html_code)
    {
        $img_src = array();
        $img_id = array();

        for ($i = 0; $i < $images->length; $i++) {
            $img = $images->item($i);

            $src = $img->getAttribute('src');
            $id = $this->get_img_id($src);

            if ( $id > 0 ) {
                $img_src[] = $src;
                $img_id[] = '{{post_id ' . $id . '}}';
            }

        }

        return str_replace($img_src, $img_id, $html_code);
    }

    private function replace_href($links, $html_code)
    {

        for ($i = 0; $i < $links->length; $i++) {
            $link = $links->item($i);

            $href = $link->getAttribute('href');
            $id = $this->get_href_id($href);

            if ( $id > 0 ) {
                $this->link_href[] = $href;
                $this->link_id[] = '{{post_id ' . $id . '}}';
            } else if (is_string($id)) {
                $this->link_href[] = $href;
                $this->link_id[] = $id;
            }

        }

        return str_replace($this->link_href, $this->link_id, $html_code);
    }

    private function get_img_id ($src = '') {

        $id = 0;

        // If there is no url, return.
        if ( '' == $src ) {
            return 0;
        }

        // Get the upload directory paths
        $upload_dir_paths = wp_upload_dir();

        // Make sure the upload path base directory exists in the attachment URL, to verify that we're working with a media library image
        if ( false !== strpos( $src, $upload_dir_paths['baseurl'] ) ) {

            // If this is the URL of an auto-generated thumbnail, get the URL of the original image
            $src = preg_replace( '/-\d+x\d+(?=\.(jpg|jpeg|png|gif)$)/i', '', $src );

            // Remove the upload path base directory from the attachment URL
            $src = str_replace( $upload_dir_paths['baseurl'] . '/', '', $src );

            // Finally, run a custom database query to get the attachment ID from the modified attachment URL
            $id = $this->wpdb->get_var( $this->wpdb->prepare( "SELECT wposts.ID FROM " . $this->wpdb->posts . " wposts, " . $this->wpdb->postmeta . " wpostmeta WHERE wposts.ID = wpostmeta.post_id AND wpostmeta.meta_key = '_wp_attached_file' AND wpostmeta.meta_value = '%s' AND wposts.post_type = 'attachment'", $src ) );

        }

        return $id;
    }

    private function get_href_id($href = '')
    {
        // If there is no url, return.
        if ( '' == $href ) {
            return false;
        }

        $id = url_to_postid($href); // 0 or greater then 0

        if ($id == 0) {
            $id = $this->get_img_id($href);
        }

        if ($id == 0) {

            $home_url = get_home_url();

            if (strpos($href, $home_url) !== false) {
                $id = str_replace($home_url, '{{home_url}}', $href);
            }

        }

        return $id;
    }

}

