<?php

class CubePortfolioMain {

    // wordpress global db
    public $wpdb;

    // cubeportfolio projects table
    public static $table_cbp = 'cubeportfolio';

    // cubeportfolio items table
    public static $table_cbp_items = 'cubeportfolio_items';

    // name of the post type
    public static $post_type = 'cubeportfolio';

    public $frontendStyle = '';
    // public $publicScripts = array();
    public $googleFonts = array();

    private $settings = array();
    private $preload = 'onPostsPage';
    private $loadAssets = false;

    private $request_from_ajax = false;

    function __construct($main_plugin_file)
    {
        global $wpdb;

        // store global db instance
        $this->wpdb = $wpdb;

        // create table name
        self::$table_cbp = $this->wpdb->prefix . self::$table_cbp;

        self::$table_cbp_items = $this->wpdb->prefix . self::$table_cbp_items;

        // flushing rewrite on activation
        register_activation_hook( $main_plugin_file, array( &$this, 'activate' ) );

        // add action for init
        add_action( 'init', array(&$this, 'init') );

        // add shortcode
        add_shortcode('cubeportfolio', array(&$this, 'add_shortcode'));

        $this->settings = get_option('cubeportfolio_settings');

        if( !$this->settings ) {
            $this->settings = array(
                'preload' => array('onPostsPage', 'onHomePage'),
            );
            update_option('cubeportfolio_settings', $this->settings);
        }

        if( isset( $this->settings['preload'] ) ) {
            $this->preload = $this->settings['preload'];
        }

        // add support for visual composer
        add_action('vc_before_init', array(&$this, 'integrate_cbp_to_vc'));

        // popup request
        $data = stripslashes_deep( $_POST );
        if (isset($data['source']) && $data['source'] == 'cubeportfolio') {
            $this->request_from_ajax = true;
            $this->processFrontendPopup($data);
        }

        // custom posts type and taxonomy
        add_action( 'init', array( &$this, 'register_custom_post_type' ) );

        // add template to cubeportfolio post
        add_filter( 'template_include', array( &$this, 'include_template_function'), 1 );

        // internationalization
        add_action('plugins_loaded', array(&$this, 'add_i18n') );

    }

    public function activate()
    {
        // Flush rewrite rules so that users can access custom post types on the front-end right away
        $this->register_custom_post_type();
        flush_rewrite_rules();
    }

    public function processFrontendPopup($data)
    {
        // get popup values for current cbp id
        $sql = $this->wpdb->prepare('SELECT popup FROM ' . CubePortfolioMain::$table_cbp . ' WHERE id = %d', $data['id']);
        $popup = json_decode($this->wpdb->get_var($sql));
        if (!$popup) return;

        $element = null;

        foreach ($popup as $item) {
            if ($item->link == $data['link'] && $item->type == $data['type']) {
                $element = $item;
            }
        }

        if ($element) {

            if ($element->html) {
                echo $element->html;
                die();
            }

            if ($data['selector'] == 'automatically') {
                add_filter('the_content', array(&$this, 'cbpw_ajax_content_filter'));
            }

        }

    }

    public function cbpw_ajax_content_filter($content)
    {
        return '<div class="cbpw-ajax-block">' . $content . '</div>';
    }


    /**
     * init main app
     */
    public function init ()
    {

        if( is_admin() ) {

            // check if db exists
            $this->check_db();

            // load the backend
            require_once( 'CubePortfolioBackend.php' );
            $this->backend = new CubePortfolioBackend();

        } else { // is frontend

            // register assets
            $this->register_assets();

            // load scripts
            add_action('wp_enqueue_scripts', array(&$this, 'load_core_scripts'));

            // Include the Ajax library on the front end
            add_action( 'wp_head', array( &$this, 'add_ajax_library' ) );

        }

    }


    public function check_db()
    {
        $current_version = get_option('cubeportfolio_version', false);

        if ($current_version != CUBEPORTFOLIO_VERSION) {

            $charset_collate = ( ( !empty($this->wpdb->charset) )? ' DEFAULT CHARACTER SET ' . $this->wpdb->charset : '' ) .
                               ( ( !empty($this->wpdb->collate) )? ' COLLATE ' . $this->wpdb->collate : '');

            $sql = "CREATE TABLE IF NOT EXISTS " . self::$table_cbp . " (
                        id              int(10)       UNSIGNED AUTO_INCREMENT NOT NULL,
                        active          tinyint(1)    UNSIGNED NOT NULL DEFAULT 1,
                        name            varchar(255)  NOT NULL,
                        type            varchar(255)  NOT NULL,
                        customcss       text          NOT NULL,
                        options         text          NOT NULL,
                        loadMorehtml    text,
                        template        text,
                        filtershtml     text,
                        googlefonts     text,
                        popup           text,
                        PRIMARY KEY (id),
                        INDEX(active)
                    ){$charset_collate};";
            $this->wpdb->query($sql);

            $sql = "CREATE TABLE IF NOT EXISTS " . self::$table_cbp_items . " (
                        id                int(10)       UNSIGNED AUTO_INCREMENT NOT NULL,
                        cubeportfolio_id  int(10)       UNSIGNED NOT NULL,
                        sort              tinyint(1)    UNSIGNED NOT NULL DEFAULT 1,
                        page              tinyint(2)    UNSIGNED NOT NULL,
                        items             text          NOT NULL,
                        isLoadMore        text,
                        isSinglePage      text,
                        PRIMARY KEY(id),
                        INDEX(cubeportfolio_id)
                    ){$charset_collate};";
            $this->wpdb->query($sql);

            // add popup field in old versions
            if ( $current_version && version_compare($current_version, '1.2', '<') ) {
                $sql = 'ALTER TABLE ' . self::$table_cbp . ' ADD popup text';
                $this->wpdb->query($sql);
                $sql = 'ALTER TABLE ' . self::$table_cbp . ' DROP COLUMN mainjs';
                $this->wpdb->query($sql);
            }

            update_option('cubeportfolio_version', CUBEPORTFOLIO_VERSION);

        }
    }


    function add_shortcode($atts, $content = null)
    {
        $shortcode_atts = shortcode_atts(array(
            'id' => -1
        ), $atts);

        return $this->generate_cbp( (int)$shortcode_atts['id'] );
    }


    public function generate_cbp($id)
    {
        $db_data = $this->get_data_from_db($id);

        if (count($db_data) === 0) {
            return CubePortfolioMain::frontend_error('Incorrect cubeportfolio ID in shortcode or problem with query. 1001');
        }

        // generate frontend html and scripts based on $db_data
        require_once('CubePortfolioFrontend.php');
        $portfolio = new CubePortfolioFrontend($db_data, $id);

        // add google fonts to googleFonts array
        $this->populateGoogleFonts($portfolio);

        return $portfolio->style . $portfolio->html . $portfolio->script;
    }

    // add more google fonts based on what came from db
    public function populateGoogleFonts($portfolio)
    {

        $fontsArray = $portfolio->googleFonts;

        foreach ($fontsArray as $font) {
            $add = true;

            foreach ($this->googleFonts as $localFont) {
                if ($localFont->name == $font->name && $localFont->weightStyle == $font->weightStyle) {
                    $add = false;
                    break;
                }
            }

            if ($add) {
                array_push($this->googleFonts, $font);
                $portfolio->style .= '<link rel="stylesheet" href="//fonts.googleapis.com/css?family=' . $font->slug . ':'. $font->weightStyle . '" type="text/css" media="all" />';
            }

        }

    }


    public function get_data_from_db($id)
    {
        $cbp = self::$table_cbp;
        $items = self::$table_cbp_items;

        $sql = $this->wpdb->prepare("SELECT * FROM  $cbp INNER JOIN  $items  ON {$cbp}.id = {$items}.cubeportfolio_id AND {$cbp}.id = %d AND {$items}.isLoadMore = 0 ORDER BY {$items}.sort", $id);

        return $this->wpdb->get_results($sql, ARRAY_A);

    }


    public static function frontend_error($message)
    {
        return '<p><strong>' . $message . '</strong></p>';
    }

    public function integrate_cbp_to_vc()
    {
        vc_map( array(
            'name' => 'Cube Portfolio',
            'base' => 'cubeportfolio',
            'class' => '',
            'category' => 'Content',
            'description' => 'Responsive WordPress Grid Plugin',
            'params' => array(
                    array(
                        'type' => 'dropdown',
                        'heading' => 'Cube Portfolio',
                        'param_name' => 'id',
                        'value' => $this->get_cbp_items_for_vc(),
                        'admin_label' => true,
                        'description' => 'Select your Cube Portfolio'
                    )
            )
        ) );
    }

    public function get_cbp_items_for_vc()
    {
        $cbp = self::$table_cbp;
        $result = array();

        $sql = $this->wpdb->prepare("SELECT id, name FROM  $cbp WHERE active = %d", 1);
        $cbps = $this->wpdb->get_results($sql);

        foreach($cbps as $cbp){
            $value = $cbp->id;
            $text = $cbp->name . ' (id=' . $value . ')';

            $result[$text] = $value;
        }

        return $result;
    }


    public function load_core_scripts()
    {

        global $posts;

        if ( in_array('onAllPages', $this->preload) ) {
            $this->loadAssets = true;
        }

        if ( in_array('onHomePage', $this->preload) ) {
            if ( is_front_page() ) {
                $this->loadAssets = true;
            }
        }

        if ( in_array('onPostsPage', $this->preload) ) {

            // find shortcode in current post
            if (isset($posts) && !empty($posts)) {

                foreach($posts as $post) {
                    if ( preg_match_all("/cubeportfolio/s", $post ->post_content, $matches) ) {
                        $this->loadAssets = true;
                    }
                }

            }

        }

        if ($this->loadAssets) {
            $this->enqueue_assets();
        }

    }

    public function register_assets()
    {
        // css
        
         wp_register_style( 'cubeportfolio-jquery-css', CUBEPORTFOLIO_URL . 'public/css/main.min.css', false, CUBEPORTFOLIO_VERSION, 'all' );

        // js
        
         wp_register_script( 'cubeportfolio-jquery-js', CUBEPORTFOLIO_URL . 'public/js/main.min.js', array('jquery'), CUBEPORTFOLIO_VERSION, false );

    }

    public function enqueue_assets()
    {

        // CUBEPORTFOLIO main plugin
        wp_enqueue_style('cubeportfolio-jquery-css');
        wp_enqueue_script('cubeportfolio-jquery-js');

        // visual composer workaround
        wp_enqueue_script('wpb_composer_front_js');

    }


    /**
     * Add the WordPress Ajax Library to the frontend.
     */
    public function add_ajax_library() {
        echo '<script type="text/javascript">if (typeof ajaxurl === "undefined") {var ajaxurl = "' . admin_url( 'admin-ajax.php' ) . '"}</script>';
    }

    /**
     * Register Custom Post Type & Taxonomy
     */
    public function register_custom_post_type() {
        $taxonomy = self::$post_type . '_category';

        $tax_args = array(
            'hierarchical' => true,
            'label' => 'Custom Categories',
            'singular_label' => 'Custom Categorie',
            'rewrite' => true,
            'public' => true,
            'show_admin_column' => true,
        );


        $args = array(
            'label' => 'Cube Posts',
            'singular_label' => 'Cube Post',
            'public' => true,
            'capability_type' => 'post',
            'hierarchical' => false,
            'show_ui' => true,
            'show_in_menu' => true,
            'supports' => array('title', 'editor'),
            'show_in_admin_bar' => false,
            'taxonomies' => array($taxonomy),
            'rewrite' => array('slug' => self::$post_type, 'with_front' => true),
        );

        register_taxonomy($taxonomy, array(self::$post_type), $tax_args);

        register_post_type(self::$post_type, $args);

    }

    public function include_template_function($template_path) {

        if ( get_post_type() == CubePortfolioMain::$post_type && is_single()) {

            // trigger the slider only when you are not from ajax
            if (!$this->request_from_ajax) {
                add_action('wp_footer', array( &$this, 'init_standalone_cbp_post') );

                // load assest for
                wp_enqueue_style('cubeportfolio-jquery-css');
                wp_enqueue_script('cubeportfolio-jquery-js');
            }

            $template = get_metadata( 'post', get_the_ID(), 'cbp_project_page_attr', true);

            // checks if the file exists in the theme first, otherwise serve the file from the plugin
            if ( $theme_file = locate_template( array ( $template . '.php' ) ) ) {
                $template_path = $theme_file;
            } else {
                $template_path = CUBEPORTFOLIO_PATH . 'public/partials/' . $template . '.php';
            }
        }

        return $template_path;

    }

    public function init_standalone_cbp_post()
    {
        echo '<div id="cbpw-init-lightbox"></div><script type="text/javascript">jQuery(".cbp-slider").find(".cbp-slider-item").addClass("cbp-item");jQuery(".cbp-slider").cubeportfolio({layoutMode: "slider", mediaQueries: [{width: 1, cols: 1 }], gapHorizontal: 0, gapVertical: 0, caption: ""});</script>';
    }

    public function add_i18n() {

        load_plugin_textdomain(CUBEPORTFOLIO_TEXTDOMAIN, false, CUBEPORTFOLIO_DIRNAME . '/languages/');

    }

}
