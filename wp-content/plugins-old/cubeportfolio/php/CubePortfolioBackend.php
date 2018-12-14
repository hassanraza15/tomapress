<?php

/**
*
*/
class CubePortfolioBackend
{

    // wordpress global db
    public $wpdb;

    private $cubeportfolio_pages = array('cubeportfolio', 'cubeportfolio-settings');

    function __construct()
    {

        global $wpdb;

        // store global db instance
        $this->wpdb = $wpdb;

        add_action( 'admin_menu', array( &$this, 'admin_menu') );

        // add meta boxes
        add_action( 'add_meta_boxes', array( &$this, 'register_meta_boxes') );

        // add action for meta boxes
        add_action('save_post', array( &$this, 'store_meta_boxes'), 10, 2);

        if ( $this->is_cbp_page() ) {

            // register css and js
            $this->register_assets();

            // load css and js
            add_action('admin_enqueue_scripts', array( &$this, 'enqueue_assets') );

        }

        add_action('admin_enqueue_scripts', array( &$this, 'add_meta_box_image_assets') );

        // ajax
        add_action('wp_ajax_listPortfolios', array( &$this, 'list_portfolios') );
        add_action('wp_ajax_deletePortfolio', array( &$this, 'delete_portfolio') );
        add_action('wp_ajax_clonePortfolio', array( &$this, 'clone_portfolio') );
        add_action('wp_ajax_toggleActivePortfolio', array( &$this, 'toggle_active_portfolio') );
        add_action('wp_ajax_getPortfolioById', array( &$this, 'getPortfolioById') );
        add_action('wp_ajax_getSettings', array( &$this, 'get_plugin_settings') );
        add_action('wp_ajax_updateSettings', array( &$this, 'update_settings') );
        add_action('wp_ajax_savePortfolio', array( &$this, 'save_portfolio') );
        add_action('wp_ajax_editPortfolio', array( &$this, 'edit_portfolio') );
        add_action('wp_ajax_setPopupTypeAdmin', array( &$this, 'setPopupTypeAdmin') );
        add_action('wp_ajax_exportCubePosts', array( &$this, 'exportCubePosts') );
        add_action('wp_ajax_importCubePosts', array( &$this, 'importCubePosts') );

        // load more from frontend
        add_action('wp_ajax_getLoadMoreItems', array( &$this, 'getLoadMoreItems') );
        add_action('wp_ajax_nopriv_getLoadMoreItems', array( &$this, 'getLoadMoreItems') );  // for not logged-in users
    }

    public function admin_menu()
    {
        add_menu_page('Cube Portfolio Edit', 'Cube Portfolio', 'publish_posts', 'cubeportfolio/', array( &$this, 'create_home_page' ),  CUBEPORTFOLIO_URL . 'admin/img/icon.png');
        add_submenu_page('cubeportfolio', 'Cube Portfolio Edit', 'Edit Portfolio', 'publish_posts', 'cubeportfolio/', array( &$this, 'create_home_page' ) );
        add_submenu_page('cubeportfolio', 'Cube Portfolio Settings', 'Settings', 'manage_options', 'cubeportfolio#/settings', array( &$this, 'create_settings_page' ) );
        add_submenu_page('cubeportfolio', 'Cube Portfolio Import/Export', 'Import/Export', 'manage_options', 'cubeportfolio#/import-export', array( &$this, 'create_import_export_page' ) );
    }

    public function create_home_page()
    {
        echo '<div id="cbp-app-root"></div>';
    }

    public function create_settings_page()
    {
        // nothing here
    }

    public function create_import_export_page()
    {
        // nothing here
    }

    function is_cbp_page()
    {
        return isset( $_GET['page'] ) && in_array( $_GET['page'], $this->cubeportfolio_pages );
    }

    public function register_assets()
    {
        // CUBEPORTFOLIO
        
         wp_register_style( 'cubeportfolio-jquery-css', CUBEPORTFOLIO_URL . 'public/css/main.min.css', false, CUBEPORTFOLIO_VERSION, 'all' );

        
         wp_register_script( 'cubeportfolio-jquery-js', CUBEPORTFOLIO_URL . 'public/js/main.min.js', array('jquery'), CUBEPORTFOLIO_VERSION, true );

        // ADMIN
        
         wp_register_style( 'cubeportfolio-admin-css', CUBEPORTFOLIO_URL . 'admin/css/main.min.css', false, CUBEPORTFOLIO_VERSION, 'all' );

        
         wp_register_script( 'cubeportfolio-admin-js', CUBEPORTFOLIO_URL . 'admin/js/main.min.js', array('jquery'), CUBEPORTFOLIO_VERSION, true );

    }

    public function enqueue_assets()
    {

        // CUBEPORTFOLIO
        wp_enqueue_style('cubeportfolio-jquery-css');
        wp_enqueue_script('cubeportfolio-jquery-js');

        // ADMIN
        wp_enqueue_style('cubeportfolio-admin-css');

        wp_localize_script( 'cubeportfolio-admin-js', 'cubeportfolioLocalizeScript', array('CUBEPORTFOLIO_URL' => CUBEPORTFOLIO_URL) );
        wp_enqueue_script( 'cubeportfolio-admin-js');

        wp_localize_script('cubeportfolio-jquery-js', 'cbp_plugin_url', CUBEPORTFOLIO_URL);

        // Enqueues all scripts, styles, settings, and templates necessary to use all media JavaScript APIs.
        wp_enqueue_media();
    }

    public function list_portfolios()
    {
        $table = CubePortfolioMain::$table_cbp;

        $query = $this->wpdb->get_results("SELECT * FROM $table");

        echo json_encode($query);

        exit();
    }

    public function delete_portfolio()
    {
        $table_cbp = CubePortfolioMain::$table_cbp;
        $table_cbp_items = CubePortfolioMain::$table_cbp_items;

        $id = $_POST['id'];

        $sql = $this->wpdb->prepare("DELETE FROM $table_cbp WHERE id = %d", $id);
        $this->wpdb->query($sql);

        $sql = $this->wpdb->prepare("DELETE FROM $table_cbp_items WHERE cubeportfolio_id = %d", $id);
        $this->wpdb->query($sql);

        echo 1;

        exit();
    }

    public function clone_portfolio()
    {
        $table_cbp = CubePortfolioMain::$table_cbp;
        $table_cbp_items = CubePortfolioMain::$table_cbp_items;

        $id = $_POST['id'];

        // clone table_cbp
        $sql = $this->wpdb->prepare("SELECT * FROM $table_cbp WHERE id = %d", $id);
        $record = $this->wpdb->get_results($sql, ARRAY_A);
        $record = $record[0];

        unset($record['id']);
        $this->wpdb->insert(
            $table_cbp,
            $record
        );
        $lastId = $this->wpdb->insert_id;

        $record['name'] = 'copy of `' . $record['name'] . '`';
        $record['filtershtml'] = str_replace('cbpw-filters' . $id, 'cbpw-filters' . $lastId, $record['filtershtml']);
        $record['template'] = str_replace('cbpw-filters' . $id, 'cbpw-filters' . $lastId, $record['template']);
        $record['template'] = str_replace('cbpw-grid' . $id, 'cbpw-grid' . $lastId, $record['template']);
        $record['template'] = str_replace('cbpw-loadMore' . $id, 'cbpw-loadMore' . $lastId, $record['template']);
        $record['template'] = str_replace('cbpw-wrap' . $id, 'cbpw-wrap' . $lastId, $record['template']);
        // custom css
        $record['customcss'] = str_replace('cbpw-wrap' . $id, 'cbpw-wrap' . $lastId, $record['customcss']);
        $record['customcss'] = str_replace('cbpw-filters' . $id, 'cbpw-filters' . $lastId, $record['customcss']);
        $record['customcss'] = str_replace('cbpw-grid' . $id, 'cbpw-grid' . $lastId, $record['customcss']);
        $record['customcss'] = str_replace('cbpw-loadMore' . $id, 'cbpw-loadMore' . $lastId, $record['customcss']);
        $record['customcss'] = str_replace('cbpw-singlePage' . $id, 'cbpw-singlePage' . $lastId, $record['customcss']);


        $this->wpdb->update($table_cbp, $record, array('id' => $lastId));



        // clone table_cbp_items
        $sql = $this->wpdb->prepare("SELECT * FROM $table_cbp_items WHERE cubeportfolio_id = %d", $id);
        $items = $this->wpdb->get_results($sql, ARRAY_A);
        foreach ($items as $key => $value) {
            unset($items[$key]['id']);

            $items[$key]['cubeportfolio_id'] = $lastId;

            $this->wpdb->insert(
                $table_cbp_items,
                $items[$key]
            );

        }

        $record['id'] = $lastId;

        $record['status'] = 1;

        echo json_encode($record);

        exit();
    }

    public function toggle_active_portfolio()
    {
        $table_cbp = CubePortfolioMain::$table_cbp;

        $id = $_POST['id'];
        $active = $_POST['active'];

        $this->wpdb->update(
            $table_cbp,
            array(
                'active' => $active,  // string
            ),
            array('id' => $id),
            array(
                '%d',   // value1
            ),
            array('%d') // where value
        );

        echo 1;

        exit();

    }

    public function getPortfolioById()
    {
        $table_cbp = CubePortfolioMain::$table_cbp;
        $table_cbp_items = CubePortfolioMain::$table_cbp_items;

        $id = $_POST['id'];

        $sql = $this->wpdb->prepare("SELECT * FROM $table_cbp WHERE id = %d", $id);
        $cbp = $this->wpdb->get_results($sql, ARRAY_A);

        // items
        $sql = $this->wpdb->prepare("SELECT * FROM $table_cbp_items WHERE cubeportfolio_id = %d ORDER BY sort", $id);
        $cbp_items = $this->wpdb->get_results($sql, ARRAY_A);

        // build the response
        $response = $cbp[0];
        $response['items'] = $cbp_items;

        echo json_encode($response);

        exit();
    }

    public function get_plugin_settings()
    {

        $response = get_option('cubeportfolio_settings');

        echo json_encode($response);

        exit();

    }

    public function update_settings()
    {

        $preload = $_POST['preload'];

        $settings = get_option('cubeportfolio_settings');

        $settings['preload'] = $preload;

        update_option('cubeportfolio_settings', $settings);

        // send this message to frontend
        echo 1;

        exit();

    }

    public function save_portfolio()
    {

        $table_cbp = CubePortfolioMain::$table_cbp;
        $table_cbp_items = CubePortfolioMain::$table_cbp_items;


        $_POST = stripslashes_deep( $_POST );

        $insert = array(
            'name' => $_POST['name'],
            'type' => $_POST['type'],
            'filtershtml' => $_POST['filtershtml'],
            'customcss' => $_POST['customcss'],
            'options' => $_POST['options'],
            'loadMorehtml' => $_POST['loadMorehtml'],
            'template' => $_POST['template'],
            'googlefonts' => $_POST['googlefonts'],
            'popup' => $_POST['popup'],
        );

        $this->wpdb->insert($table_cbp, $insert);
        $portfolio_id = $this->wpdb->insert_id;

        if ( !$_POST['name'] ) {

            $name = 'Untitled Portfolio #' . $portfolio_id;

            $this->wpdb->update(
                $table_cbp,
                array(
                    'name' => $name,
                ),
                array('id' => $portfolio_id)
            );
        }

        // change the id with the current id inserted in db
        $insert['filtershtml'] = str_replace('cbpw-filters0', 'cbpw-filters' . $portfolio_id, $insert['filtershtml']);
        $insert['template'] = str_replace('cbpw-filters0', 'cbpw-filters' . $portfolio_id, $insert['template']);
        $insert['template'] = str_replace('cbpw-grid0', 'cbpw-grid' . $portfolio_id, $insert['template']);
        $insert['template'] = str_replace('cbpw-loadMore0', 'cbpw-loadMore' . $portfolio_id, $insert['template']);
        $insert['template'] = str_replace('cbpw-wrap0', 'cbpw-wrap' . $portfolio_id, $insert['template']);
        // css
        $insert['customcss'] = str_replace('cbpw-wrap0', 'cbpw-wrap' . $portfolio_id, $insert['customcss']);
        $insert['customcss'] = str_replace('cbpw-filters0', 'cbpw-filters' . $portfolio_id, $insert['customcss']);
        $insert['customcss'] = str_replace('cbpw-grid0', 'cbpw-grid' . $portfolio_id, $insert['customcss']);
        $insert['customcss'] = str_replace('cbpw-loadMore0', 'cbpw-loadMore' . $portfolio_id, $insert['customcss']);
        $insert['customcss'] = str_replace('cbpw-singlePage0', 'cbpw-singlePage' . $portfolio_id, $insert['customcss']);

        $this->wpdb->update(
            $table_cbp,
            array(
                'filtershtml' => $insert['filtershtml'],
                'customcss' => $insert['customcss'],
                'template' => $insert['template']
            ),
            array('id' => $portfolio_id)
        );


        // items
        $items = $_POST['items'];
        foreach ($items as $key => $value) {
            $insert = array(
                'cubeportfolio_id' => $portfolio_id,
                'sort' => $value['sort'],
                'page' => $value['page'],
                'items' => $value['items'],
                'isLoadMore' => $value['isLoadMore'],
                'isSinglePage' => $value['isSinglePage'],
            );

            $this->wpdb->insert($table_cbp_items, $insert);
        }

        $response['id'] = $portfolio_id;
        $response['status'] = 1;

        echo json_encode($response);

        exit();

    }

    public function edit_portfolio()
    {

        $table_cbp = CubePortfolioMain::$table_cbp;
        $table_cbp_items = CubePortfolioMain::$table_cbp_items;

        $_POST = stripslashes_deep( $_POST );

        $portfolio_id = $_POST['id'];

        $update = array(
            'name' => $_POST['name'],
            'type' => $_POST['type'],
            'filtershtml' => $_POST['filtershtml'],
            'customcss' => $_POST['customcss'],
            'options' => $_POST['options'],
            'loadMorehtml' => $_POST['loadMorehtml'],
            'template' => $_POST['template'],
            'googlefonts' => $_POST['googlefonts'],
            'popup' => $_POST['popup'],
        );

        $where = array('id' => $portfolio_id);

        if ( !$update['name'] ) {
            $update['name'] = 'Untitled Portfolio #' . $portfolio_id;
        }

        $this->wpdb->update($table_cbp, $update, $where);


        $items = $_POST['items'];
        $sql = $this->wpdb->prepare("SELECT * FROM $table_cbp_items WHERE cubeportfolio_id = %d", $portfolio_id);
        $cbp_items = $this->wpdb->get_results($sql, ARRAY_A);

        $response = array($items, $cbp_items);


        foreach ($cbp_items as $key => $value) {

            $notFound = true;
            $where = array('id' => $value['id']);

            foreach ($items as $key1 => $value1) {

                if ( $value['id'] == $value1['id']) {
                    $notFound = false;

                    $update = array(
                        'cubeportfolio_id' => $portfolio_id,
                        'sort' => $value1['sort'],
                        'page' => $value1['page'],
                        'items' => $value1['items'],
                        'isLoadMore' => $value1['isLoadMore'],
                        'isSinglePage' => $value1['isSinglePage'],
                    );

                    $this->wpdb->update($table_cbp_items, $update, $where);

                    unset($items[$key1]);
                }
            }

            if ($notFound) {
                $this->wpdb->delete($table_cbp_items, $where);
            }

        }

        array_push($response, $items);

        foreach ($items as $key => $value) {
            $insert = array(
                'cubeportfolio_id' => $portfolio_id,
                'sort' => $value['sort'],
                'page' => $value['page'],
                'items' => $value['items'],
                'isLoadMore' => $value['isLoadMore'],
                'isSinglePage' => $value['isSinglePage'],
            );

            $this->wpdb->insert($table_cbp_items, $insert);
        }



        $response['id'] = $portfolio_id;
        $response['status'] = 1;

        echo json_encode($response);

        exit();
    }

     public function setPopupTypeAdmin()
    {
        $table_cbp = CubePortfolioMain::$table_cbp;
        $table_cbp_items = CubePortfolioMain::$table_cbp_items;

        $_POST = stripslashes_deep( $_POST );

        $id = $_POST['id'];
        $popup = $_POST['popup'];

        print_r($popup);

        $sql = $this->wpdb->prepare("SELECT isSinglePage FROM $table_cbp_items WHERE id = %d", $id);

        $this->wpdb->update(
            $table_cbp_items,
            array(
                'isSinglePage' => $popup
            ),
            array('id' => $id)
        );

        exit();
    }

    public function exportCubePosts()
    {
        require_once CUBEPORTFOLIO_PATH . 'php/CubePortfolioExport.php';
        $export = new CubePortfolioExport();
    }

    public function importCubePosts()
    {
        require_once CUBEPORTFOLIO_PATH . 'php/CubePortfolioImport.php';
        $import = new CubePortfolioImport();
    }

    public function getLoadMoreItems()
    {

        $table_cbp = CubePortfolioMain::$table_cbp;
        $table_cbp_items = CubePortfolioMain::$table_cbp_items;

        $_POST = stripslashes_deep( $_POST );

        $id = $_POST['id'];
        $limit = $_POST['limit'];
        $offset = $_POST['offset'];

        // items
        $sql = $this->wpdb->prepare("SELECT * FROM $table_cbp_items WHERE cubeportfolio_id = %d AND isLoadMore = %d ORDER BY sort LIMIT %d OFFSET %d", $id, 1, $limit, $offset);

        $sqlItemsRemain = $this->wpdb->prepare("SELECT COUNT(id) FROM $table_cbp_items WHERE cubeportfolio_id = %d AND isLoadMore = %d", $id, 1);

        $itemsRemain = $this->wpdb->get_var($sqlItemsRemain) - ($limit + $offset);

        $result = array('items' => $this->wpdb->get_results($sql, ARRAY_A),
                        'itemsRemain' => $itemsRemain);

        echo json_encode($result);

        exit();
    }

    public function register_meta_boxes()
    {
        // change the template for the current post type
        add_meta_box('cbp_project_subtitle_meta_box', __('Project Subtitle', CUBEPORTFOLIO_TEXTDOMAIN), array(&$this, 'cbp_project_subtitle_meta_box_callback'), CubePortfolioMain::$post_type, 'normal', 'high');

        // change the template for the current post type
        add_meta_box('cbp_project_page_attr_meta_box', __('Page Attributes', CUBEPORTFOLIO_TEXTDOMAIN), array(&$this, 'cbp_project_page_attr_meta_box_callback'), CubePortfolioMain::$post_type, 'side', 'low');

        // project details meta box
        add_meta_box('cbp_project_details_meta_box', __('Project Details', CUBEPORTFOLIO_TEXTDOMAIN), array(&$this, 'cbp_project_details_meta_box_callback'), CubePortfolioMain::$post_type, 'side', 'low');

        // project link and link target
        add_meta_box('cbp_project_link_meta_box', __('Project Link', CUBEPORTFOLIO_TEXTDOMAIN), array(&$this, 'cbp_project_link_meta_box_callback'), CubePortfolioMain::$post_type, 'normal', 'high');

        // social links
        add_meta_box('cbp_project_social_meta_box', __('Social Links', CUBEPORTFOLIO_TEXTDOMAIN), array(&$this, 'cbp_project_social_meta_box_callback'), CubePortfolioMain::$post_type, 'side', 'low');

        // images gallery
        add_meta_box('cbp_project_images_meta_box', __('Add/Edit Project Media', CUBEPORTFOLIO_TEXTDOMAIN), array(&$this, 'cbp_project_images_meta_box_callback'), CubePortfolioMain::$post_type, 'normal', 'high');

    }

    public function cbp_project_subtitle_meta_box_callback($post)
    {
        // Retrieve current client and date based on post ID
        $cbp_project_subtitle = get_post_meta( $post->ID, 'cbp_project_subtitle', true );
    ?>
            <table>
                <tr>
                    <td width="200"><label for="cbp_project_subtitle"><?php _e('Subtitle', CUBEPORTFOLIO_TEXTDOMAIN); ?></label></td>
                    <td><input type="text" size="60" name="cbp_project_subtitle" id="cbp_project_subtitle" value="<?php echo $cbp_project_subtitle; ?>" /></td>
                </tr>
            </table>
    <?php
    }

    public function cbp_project_page_attr_meta_box_callback($post)
    {
        // Retrieve current client and date based on post ID
        $cbp_project_page_attr = get_post_meta( $post->ID, 'cbp_project_page_attr', true );
        $template_list = array('single-cbp-singlePage' => __('SinglePage', CUBEPORTFOLIO_TEXTDOMAIN), 'single-cbp-singlePageInline' => __('SinglePageInline', CUBEPORTFOLIO_TEXTDOMAIN));
    ?>
            <table>
                <tr>
                    <td width="72"><label for="cbp_project_page_attr"><?php _e('Template', CUBEPORTFOLIO_TEXTDOMAIN); ?></label></td>
                    <td>
                        <select name="cbp_project_page_attr" id="cbp_project_page_attr">
                        <?php foreach ($template_list as $key => $value) : ?>
                            <option value="<?php echo $key; ?>" <?php echo selected( $cbp_project_page_attr, $key ); ?>><?php echo $value; ?></option>
                        <?php endforeach; ?>
                        </select>
                    </td>
                </tr>
            </table>
    <?php
    }

    public function cbp_project_details_meta_box_callback($post)
    {
        // Retrieve current client and date based on post ID
        $cbp_project_details_client = esc_html( get_post_meta( $post->ID, 'cbp_project_details_client', true ) );
        $cbp_project_details_date = esc_html( get_post_meta( $post->ID, 'cbp_project_details_date', true ) );
    ?>
            <table>
                <tr>
                    <td><label for="cbp_project_details_client"><?php _e('Client Name', CUBEPORTFOLIO_TEXTDOMAIN); ?></label></td>
                    <td><input type="text" size="19" name="cbp_project_details_client" id="cbp_project_details_client" value="<?php echo $cbp_project_details_client; ?>" /></td>
                </tr>
                <tr>
                    <td><label for="cbp_project_details_date "><?php _e('Project Date', CUBEPORTFOLIO_TEXTDOMAIN); ?></label></td>
                    <td><input type="text" size="19" name="cbp_project_details_date" id="cbp_project_details_date" value="<?php echo $cbp_project_details_date; ?>" /></td>
                </tr>
            </table>
    <?php
    }

    public function cbp_project_link_meta_box_callback($post)
    {
        // Retrieve current client and date based on post ID
        $cbp_project_link = esc_html( get_post_meta( $post->ID, 'cbp_project_link', true ) );
        $cbp_project_link_target = get_post_meta( $post->ID, 'cbp_project_link_target', true );

        if ( $cbp_project_link_target == '' ) {
            $cbp_project_link_target = '_blank';
        }
    ?>
            <table>
                <tr>
                    <td width="200"><label for="cbp_project_link"><?php _e('Project Link', CUBEPORTFOLIO_TEXTDOMAIN); ?></label></td>
                    <td><input type="text" size="60" name="cbp_project_link" id="cbp_project_link" value="<?php echo $cbp_project_link; ?>" /></td>
                </tr>
                <tr>
                    <td><label><?php _e('Project Link Target', CUBEPORTFOLIO_TEXTDOMAIN); ?></label></td>
                    <td>
                        <input type="radio" name="cbp_project_link_target" value="_blank" id="cbp_project_link_target_blank" <?php checked( $cbp_project_link_target, '_blank' ); ?> ><label for="cbp_project_link_target_blank"><?php _e('Blank', CUBEPORTFOLIO_TEXTDOMAIN); ?></label> &#160;&#160;&#160;&#160;&#160;
                        <input type="radio" name="cbp_project_link_target" value="_self" id="cbp_project_link_target_self" <?php checked( $cbp_project_link_target, '_self' ); ?> ><label for="cbp_project_link_target_self"><?php _e('Self', CUBEPORTFOLIO_TEXTDOMAIN); ?></label>
                    </td>
                </tr>
            </table>
    <?php
    }


    public function cbp_project_social_meta_box_callback($post)
    {
        // Retrieve current client and date based on post ID
        $cbp_project_social_fb = get_post_meta( $post->ID, 'cbp_project_social_fb', true );
        $cbp_project_social_twitter = get_post_meta( $post->ID, 'cbp_project_social_twitter', true );
        $cbp_project_social_google = get_post_meta( $post->ID, 'cbp_project_social_google', true );
    ?>
            <table>
                <tr>
                    <td><input type="checkbox" name="cbp_project_social_fb" id="cbp_project_social_fb" <?php checked($cbp_project_social_fb, 'on'); ?> /></td>
                    <td><label for="cbp_project_social_fb"><?php _e('Facebook', CUBEPORTFOLIO_TEXTDOMAIN); ?></label></td>
                </tr>
                <tr>
                    <td><input type="checkbox" name="cbp_project_social_twitter" id="cbp_project_social_twitter" <?php checked($cbp_project_social_twitter, 'on'); ?> /></td>
                    <td><label for="cbp_project_social_twitter"><?php _e('Twitter', CUBEPORTFOLIO_TEXTDOMAIN); ?></label></td>
                </tr>
                <tr>
                    <td><input type="checkbox" name="cbp_project_social_google" id="cbp_project_social_google" <?php checked($cbp_project_social_google, 'on'); ?> /></td>
                    <td><label for="cbp_project_social_google"><?php _e('Google+', CUBEPORTFOLIO_TEXTDOMAIN); ?></label></td>
                </tr>
            </table>
    <?php
    }


    public function cbp_project_images_meta_box_callback($post)
    {
        $cbp_project_images = get_post_meta( $post->ID, 'cbp_project_images', true );
        $cbp_project_images_slider = get_post_meta( $post->ID, 'cbp_project_images_slider', true );
        $cbp_project_images_lightbox = get_post_meta( $post->ID, 'cbp_project_images_lightbox', true );

        if ( $cbp_project_images_slider == '' ) {
            $cbp_project_images_slider = 'on';
        }
        if ( $cbp_project_images_lightbox == '' ) {
            $cbp_project_images_lightbox = 'on';
        }

        $images = json_decode( $cbp_project_images);
        if ( count($images) ) {
            $images_arr = array();
            foreach ($images as $value) {
                array_push($images_arr, array('url' => wp_get_attachment_url($value->id), 'id' => $value->id ));
            }
            $cbp_project_images = json_encode($images_arr);
        } else {
            $cbp_project_images = '';
        }
    ?>
            <div><a href="" id="meta-box-remove-cbpw"><?php _e('remove images', CUBEPORTFOLIO_TEXTDOMAIN); ?></a></div>
            <br>
            <input type="hidden" name="cbp_project_images" id="cbp_project_images" value='<?php echo $cbp_project_images; ?>' />
            <div id="meta-box-image-cbpw"></div>
            <br>
            <button class="button" id="meta-box-button-cbpw"><?php _e('Edit/Select Images', CUBEPORTFOLIO_TEXTDOMAIN); ?></button>

            <br><br>
            <div>
                <input type="checkbox" name="cbp_project_images_slider" id="cbp_project_images_slider" <?php checked($cbp_project_images_slider, 'on'); ?> />
                <label for="cbp_project_images_slider"><?php _e('Wrap images in a slider', CUBEPORTFOLIO_TEXTDOMAIN); ?></label>
            </div>
            <div>
                <input type="checkbox" name="cbp_project_images_lightbox" id="cbp_project_images_lightbox" <?php checked($cbp_project_images_lightbox, 'on'); ?> />
                <label for="cbp_project_images_lightbox"><?php _e('Add support for Lightbox Gallery', CUBEPORTFOLIO_TEXTDOMAIN); ?></label>
            </div>

    <?php
    }

    public function store_meta_boxes($id, $post)
    {

        // if this is an autosave, our form has not been submitted, so we don't want to do anything.
        if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;

        // Check post type for cubeportfolio type
        if ( $post->post_type == CubePortfolioMain::$post_type ) {

            // page attributes
            if ( isset( $_POST['cbp_project_subtitle'] ) ) {
                update_post_meta( $id, 'cbp_project_subtitle', $_POST['cbp_project_subtitle'] );
            }
            // page attributes
            if ( isset( $_POST['cbp_project_page_attr'] ) && $_POST['cbp_project_page_attr'] != '' ) {
                update_post_meta( $id, 'cbp_project_page_attr', $_POST['cbp_project_page_attr'] );
            }

            // project details
            if ( isset( $_POST['cbp_project_details_client'] ) ) {
                update_post_meta( $id, 'cbp_project_details_client', $_POST['cbp_project_details_client'] );
            }
            if ( isset( $_POST['cbp_project_details_date'] ) ) {
                update_post_meta( $id, 'cbp_project_details_date', $_POST['cbp_project_details_date'] );
            }


            // project link
            if ( isset( $_POST['cbp_project_link'] ) ) {
                update_post_meta( $id, 'cbp_project_link', $_POST['cbp_project_link'] );
            }
            if ( isset( $_POST['cbp_project_link_target'] ) ) {
                update_post_meta( $id, 'cbp_project_link_target', $_POST['cbp_project_link_target'] );
            }

            // social link
            $checkbox_value = isset( $_POST['cbp_project_social_fb'] ) && $_POST['cbp_project_social_fb'] ? 'on' : 'off';
            update_post_meta( $id, 'cbp_project_social_fb', $checkbox_value );

            $checkbox_value = isset( $_POST['cbp_project_social_twitter'] ) && $_POST['cbp_project_social_twitter'] ? 'on' : 'off';
            update_post_meta( $id, 'cbp_project_social_twitter', $checkbox_value );

            $checkbox_value = isset( $_POST['cbp_project_social_google'] ) && $_POST['cbp_project_social_google'] ? 'on' : 'off';
            update_post_meta( $id, 'cbp_project_social_google', $checkbox_value );

            // project images
            $img = ( isset($_POST['cbp_project_images']) )? $_POST['cbp_project_images'] : '';
            $images = json_decode(stripslashes($img));
            if ($images) {
                foreach ($images as $key => $value) {
                    unset($images[$key]->url);
                }
            }
            update_post_meta( $id, 'cbp_project_images',  json_encode($images) );

            $checkbox_value = isset( $_POST['cbp_project_images_slider'] ) && $_POST['cbp_project_images_slider'] ? 'on' : 'off';
            update_post_meta( $id, 'cbp_project_images_slider', $checkbox_value );
            $checkbox_value = isset( $_POST['cbp_project_images_lightbox'] ) && $_POST['cbp_project_images_lightbox'] ? 'on' : 'off';
            update_post_meta( $id, 'cbp_project_images_lightbox', $checkbox_value );

        }
    }

    public function add_meta_box_image_assets()
    {

        if( get_post_type() == CubePortfolioMain::$post_type ) {
            wp_enqueue_media();

            // Registers and enqueues the required javascript.
            wp_register_script( 'cbp-meta-box-image', CUBEPORTFOLIO_URL . 'public/js/meta-box-image.js', array( 'jquery' ), CUBEPORTFOLIO_VERSION, true  );
            wp_enqueue_script( 'cbp-meta-box-image' );
        }

    }

}
