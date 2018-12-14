<?php
/*
 Plugin Name: Spots
 Plugin URI: http://wordpress.org/extend/plugins/spots/
 Description: Spots are a post type that you can use to add static text, html, images and videos etc... anywhere on your site that you don't want appearing in your site map or search results. You can call a spot via a template tag, shortcode or use the widget.
 Author: Robert O'Rourke, James R Whitehead, Tom J Nowell
 Version: 3.0
 Text Domain: spots
 Author URI: http://interconnectit.com
*/

// Check that we're using a version of WordPress that this works with.
global $wp_version;
if ( version_compare( $wp_version, '3.0', 'lt' ) )
	return false;

// Set up the translation domain.
defined( 'SPOTS_DOM' ) || define( 'SPOTS_DOM', 'spots' );
defined( 'SPOTS_DIR' ) || define( 'SPOTS_DIR', dirname( __FILE__ ) );
if ( file_exists( SPOTS_DIR . '/lang/' . SPOTS_DOM . '-' . get_locale( ) . '.mo' ) )
	load_textdomain( SPOTS_DOM, SPOTS_DIR . '/lang/' . SPOTS_DOM . '-' . get_locale( ) . '.mo' );

if ( ! class_exists( 'icit_spots' ) ) {
	require_once( 'includes/icit-plugin.php' );

	icit_register_plugin( 'spots', __FILE__, array(
		'page_title' => __( 'Spots Settings', SPOTS_DOM ),
		'menu_title' => __( 'Settings', SPOTS_DOM ),
		'parent_slug' => 'edit.php?post_type=spot'
	) );

	add_action( 'init', array( 'icit_spots', '_init' ), 1 ); // This creates the main plugin object and the button object.

	// add settings
	add_action( 'admin_init', array( 'icit_spots', 'settings' ) );

	class icit_spots {

		/**
		 * @var icit_spots This object
		 */
		static $instance_spots = null;

		/**
		 * @var icit_spots_mce_button AWWWWWW it's the button
		 */
		protected static $instance_mce_button;


		public function __construct() {
			add_action( 'init', array( $this, 'post_type' ) );
			add_action( 'admin_head', array( $this, 'admin_head' ) );
			add_action( 'admin_init', array( $this, 'do_once' ), 9000 );
			add_action( 'do_once_icit_spots', 'flush_rewrite_rules' );

			add_action( 'save_post', array( $this, 'update_cache' ), 10, 2 );
			add_action( 'delete_post', array( $this, 'clean_cache' ) );
			add_action( 'wp_ajax_find-spot', array( $this, 'ajax_find_spot' ), 10 );
			add_action( 'widgets_init', array( 'Spot_Widget', '_init' ) ); // initialise the widget

			if ( get_option( 'spots_norobots', 1 ) == 1 ) {
				add_action( 'wp_head', array( $this, 'norobots_check' ) );
			}

			// shortcode
			add_filter( 'the_content', array( $this, 'late_shortcode' ), 9996 );

			register_deactivation_hook( __FILE__, array( $this, 'deactivation' ) );
			register_activation_hook( __FILE__, array( $this, 'activation' ) );
		}


		/*
		 Done late enough that the constants can be overridden with the theme.
		*/
		public static function _init( ) {
			global $icit_spots;

			if ( ! defined( 'SPOTS_BASE' ) )
				define( 'SPOTS_BASE', 'SPOTS_widget' );

			if ( ! defined( 'SPOTS_POST_TYPE' ) )
				define( 'SPOTS_POST_TYPE', 'spot' );

			if ( ! defined( 'SPOTS_URL' ) )
				define( 'SPOTS_URL', plugins_url( '', __FILE__ ) );

			if ( ! defined( 'SPOTS_CACHE_TIME' ) )
				define( 'SPOTS_CACHE_TIME', get_option( 'spots_cache_time', ( 365 * 24 * 60 * 60 ) ) );

			if ( ! defined( 'SPOTS_VER' ) )
				define( 'SPOTS_VER', filemtime( __FILE__ ) );

			if ( ! defined( 'SPOTS_ONCE_FREQ' ) )
				define( 'SPOTS_ONCE_FREQ', 0 );

			if ( self::$instance_spots === null )
				$icit_spots = self::$instance_spots = new icit_spots( );

			if ( self::$instance_mce_button === null )
				self::$instance_mce_button = new icit_spots_mce_button( );
		}


		public static function settings() {
			add_settings_field( 'spots_cache_time', __( 'Cache Time (seconds)', SPOTS_DOM ), array( __CLASS__, 'cache_time_field' ), 'spots' );
			add_settings_field( 'spots_norobots', __( 'NoIndex on Single Spot Pages?', SPOTS_DOM ), array( __CLASS__, 'norobots_field' ), 'spots' );
			register_setting( 'spots', 'spots_cache_time', 'intval' );
			register_setting( 'spots', 'spots_norobots', 'intval' );
		}

		function cache_time_field() {
			echo '<input type="text" name="spots_cache_time" value="' . get_option( 'spots_cache_time', SPOTS_CACHE_TIME ) . '" />';
			echo '<p class="description">' . __( 'Enter an amount of time in seconds to cache spots for. Set to 0 to turn the caching off, recommeneded if you use a caching plugin.', SPOTS_DOM ) . '</p>';
		}

		function norobots_field() {
			echo '<input type="checkbox" name="spots_norobots" value="1" ';
			echo checked( get_option( 'spots_norobots', 1 ), 1 ); echo ' />';
			echo '<p class="description">' . __( 'Each Spot has a dedicated page, allow these pages to be indexed by search engines?', SPOTS_DOM ) . '</p>';
		}


		function norobots_check(){
			global $wp_query;
			if ( isset( $wp_query->query['post_type'] ) ) {
				if ( $wp_query->query['post_type'] == 'spot' ) {
					?>
					<meta name="robots" content="noindex, nofollow" />
					<?php
				}
			}


		}


		function ajax_find_spot( ) {

			$q = '';
			if ( isset( $_GET[ 'q' ] ) )
				$q = strtolower( $_GET[ 'q' ] );

			if ( strlen( $q ) < 1 )
				die( );

			$spots = get_posts( array(
										'post_type' => SPOTS_POST_TYPE,
										'suppress_filters' => true,
										'update_post_term_cache' => false,
										'update_post_meta_cache' => false,
										'post_status' => 'publish',
										'order' => 'DESC',
										'orderby' => 'post_date',
										'posts_per_page' => 20,
										'search' => $q,
										's' => $q
									  ) );

			if ( !empty( $spots ) ) {
				$output = array();
				foreach ( $spots as $spot ) {
					$output[] = $spot->post_title . '|' . $spot->ID;
				}
				echo implode( "\n", $output );
			}

			die();
		}


		function post_type( ) {
			$labels = array(
				'name' => _x( 'Spots', 'post type name', SPOTS_DOM ),
				'singular_name' => _x( 'Spot', 'Singular post type name', SPOTS_DOM ),
				'add_new' => _x( 'Add New', 'post type menu to add new item', SPOTS_DOM ),
				'add_new_item' => __( 'Add New Spot', SPOTS_DOM ),
				'edit_item' => __( 'Edit Spot', SPOTS_DOM ),
				'new_item' => __( 'New Spot', SPOTS_DOM ),
				'view_item' => __( 'View Spot', SPOTS_DOM ),
				'search_items' => __( 'Search Spots', SPOTS_DOM ),
				'not_found' => __( 'No Spots found', SPOTS_DOM ),
				'not_found_in_trash' => __( 'No Spots found in Trash', SPOTS_DOM ),
				'parent_item_colon' => '',
				'menu_name' => __( 'Spots', SPOTS_DOM )
			);
			$args = array(
				'labels' => apply_filters( 'spot_post_type_labels', $labels ),
				'public' => true,
				'publicly_queryable' => true,
				'show_ui' => true,
				'show_in_menu' => true,
				'show_in_nav_menus' => false,
				'menu_position' => 58, 			// just above first divider
				'query_var' => true,
				'rewrite' => true,
				'exclude_from_search' => true,
				'capability_type' => 'page',
				'has_archive' => false,
				'hierarchical' => false,
				'supports' => array( 'title', 'editor', 'thumbnail', 'custom-fields', 'revisions' ),
				'taxonomies' => array(),
				'register_meta_box_cb' => array( $this, 'meta_boxes' ),
				'_edit_link' => 'post.php?post=%d&amp;post_type=' . SPOTS_POST_TYPE // generally frowned on but needs some custom CSS
			);
			$args = apply_filters( 'spot_post_type_args', $args );
			register_post_type( SPOTS_POST_TYPE, $args );

			if ( is_admin( ) && isset( $_GET[ 'post_type' ] ) && $_GET[ 'post_type' ] == SPOTS_POST_TYPE ) {
				// hide unecessary page elements
				add_filter( 'admin_body_class', create_function( '$a', 'return " " . SPOTS_POST_TYPE;' ) );
				wp_enqueue_style( 'spots-css', SPOTS_URL.'/assets/spots.css' );
			}

		}


		function do_once( ) {
			// If we're doing an auto task then don't bother with this.
			if ( ( defined( 'DOING_AJAX' ) && DOING_AJAX ) || ( defined( 'DOING_CRON' ) && DOING_CRON ) || ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) )
				return false;

			$results = wp_parse_args( get_option( __CLASS__ . '_setup', array() ), array( 'version' => 0, 'time' => time() ) );

			if ( $results[ 'version' ] != SPOTS_VER ) {
				do_action( 'do_once_' . __CLASS__, __CLASS__ );

				// Update the setup toggle
				$args = array( 'version' => SPOTS_VER, 'time' => time( ) );
				if ( ! update_option( __CLASS__ . '_setup', $args ) )
					add_option( __CLASS__ . '_setup', $args );
			}
		}


		/*
		 Call only on the admin side of things as this can be a little heavy...
		*/
		function get_templates( ) {
			global $wp_version;
			if ( version_compare( $wp_version, '3.4', '>=' ) ) {
				$theme = wp_get_theme();
				$templates = $theme->get_files( 'php' );
			} else {
				$themes = get_themes();
				$theme = get_current_theme();
				$templates = $themes[ $theme ][ 'Template Files' ];
			}

			$spot_templates = array();

			foreach ( $templates as $template ) {
				if ( preg_match( '/' . SPOTS_POST_TYPE . '\-(.+?)\.php/is', basename( $template ), $matches ) ) {
					$spot_templates[ ] = $matches[ 1 ];
				}
			}

			return empty( $spot_templates ) ? false : $spot_templates;
		}


		function meta_boxes( ) {
			remove_meta_box( 'pageparentdiv', SPOTS_POST_TYPE, 'side' );
			remove_meta_box( 'postimagediv', SPOTS_POST_TYPE, 'side' );
			remove_meta_box( 'submitdiv', SPOTS_POST_TYPE, 'side' );

			add_meta_box( 'submitdiv', __( 'Save', SPOTS_DOM ), 'post_submit_meta_box', SPOTS_POST_TYPE, 'side', 'low' );
			add_meta_box( 'pageparentdiv', __( 'Template', SPOTS_DOM ), array( $this, 'attributes_meta_box' ), SPOTS_POST_TYPE, 'side', 'high' );
			add_meta_box( 'postimagediv', __( 'Featured Image', SPOTS_DOM ), 'post_thumbnail_meta_box', SPOTS_POST_TYPE, 'side', 'high' );
		}


		/**
		 * Display attributes form fields.
		 *
		 * @param object $post
		 */
		function attributes_meta_box( $post ) {

			$template = get_post_meta( $post->ID, '_spot_part', true );
			$templates = $this->get_templates( );

			if ( $templates ) {
				?>
				<label class="screen-reader-text" for="page_template"><?php _e( 'Template', SPOTS_DOM ) ?></label>
				<select name="page_template" id="page_template">
					<option value=""><?php _e( 'Default Template', SPOTS_DOM ); ?></option> <?php
					foreach ( $templates as $i => $name ) {
						printf( '<option value="%s" %s>%s</option>', esc_attr( $name ), selected( $name, $template, false ), esc_html( ucfirst( $name ) ) );
					} ?>
				</select>
				<?php
			}
		}


		/**
		 * Late content filter to add, parse and remove the spot shortcode to
		 * prevent  downstream interactions with other plugins
		 *
		 * @param string $content The post content
		 *
		 * @return string
		 */
		function late_shortcode( $content ) {
			global $post;

			if ( $post->post_type == SPOTS_POST_TYPE )
				return $content;

			add_shortcode( 'icitspot', array( $this, 'shortcode' ) );

			// Do the shortcode (only the [icitspot] one is registered)
			$content = shortcode_unautop( $content );
			$content = do_shortcode( $content );

			remove_shortcode( 'icitspot' );

			return $content;
		}


		/**
		 * Shortcode that outputs a spot
		 *
		 * @param string $atts Attribute string to be passed to shortcode_atts
		 *
		 * @return string    Shortcode output
		 */
		function shortcode( $atts ) {
			$atts = shortcode_atts( array(
				'id' => false,
				'template' => ''
			), $atts );

			$spot_id = $atts[ 'id' ];
			$template = $atts[ 'template' ];

			// insanity check
			if ( get_post_type( ) == SPOTS_POST_TYPE )
				return;

			$spot_content = icit_get_spot( $spot_id, $template );

			return $spot_content;
		}


		// keep the cache up to date
		function update_cache( $post_id, $post_obj = '' ) {
			global $post;

			if ( empty( $post_obj->post_type ) || $post_obj->post_type != SPOTS_POST_TYPE )
				return $post_id;

			if ( empty( $post ) ) // Make sure the global post object is populated
				$post = $post_obj;

			// not on autosave
			if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
				return $post_id;

			// perms
			if ( ! current_user_can( 'edit_post', $post_id ) )
				return $post_id;

			// save template
			if ( isset( $_POST[ 'page_template' ] ) ) {
				$template = sanitize_file_name( $_POST[ 'page_template' ] );
				update_post_meta( $post_id, '_spot_part', $template );
			} else {
				$template = get_post_meta( $post->ID, '_spot_part', true );
			}

			// check template
			// $cache_id = 'spot_' . $post_id . ( ! empty( $template ) ? '_' . md5( $template ) : '' );

			// $post = get_post( $post_id );

			// allow cache update on next load for text block
			$this->remove_transients( $post_id );
			// set_transient( $cache_id, array( 'output' => icit_get_spot( $post_id, $template ), 'status' => $post->post_status ), SPOTS_CACHE_TIME );

		}


		// clean up on delete
		function clean_cache( $post_id ) {
			if ( empty( $_POST[ 'post_type' ] ) || $_POST[ 'post_type' ] != SPOTS_POST_TYPE )
				return $post_id;

			// perms
			if ( ! current_user_can( 'delete_post' ) )
				return $post_id;

			// delete all template variations
			$this->remove_transients( $post_id );
		}


		// remove cache for a post
		function remove_transients( $post_id ) {
			global $wpdb;
			$result = $wpdb->query( "DELETE FROM $wpdb->options WHERE option_name LIKE ( '_transient%_spot_" . esc_sql( $post_id ) . "%' )" );
		}


		function activation( ) {
			// Nothing to do at the moment, all done by do_once action
		}


		function deactivation( ) {
			// remove all transient data stored
			global $wpdb;
			$result = $wpdb->query( "DELETE FROM $wpdb->options WHERE option_name LIKE ( '_transient%_spot_%' )" );

			// Clean out the rewrite rules so spots are all deaded.
			flush_rewrite_rules( );
			delete_option( 'spots_do_once_setup' );

			return $result;
		}



		function spot_finder( ) { ?>
			<form id="wp-link" tabindex="-1">
			<?php wp_nonce_field( 'internal-linking', '_ajax_linking_nonce', false ); ?>
			<div id="link-selector">
				<div id="link-options">
					<p class="howto"><?php _e( 'Enter the destination URL', SPOTS_DOM ); ?></p>
					<div>
						<label><span><?php _e( 'URL', SPOTS_DOM ); ?></span><input id="url-field" type="text" tabindex="10" name="href" /></label>
					</div>
					<div>
						<label><span><?php _e( 'Title', SPOTS_DOM ); ?></span><input id="link-title-field" type="text" tabindex="20" name="linktitle" /></label>
					</div>
					<div class="link-target">
						<label><input type="checkbox" id="link-target-checkbox" tabindex="30" /> <?php _e( 'Open link in a new window/tab', SPOTS_DOM ); ?></label>
					</div>
				</div>
				<?php $show_internal = '1' == get_user_setting( 'wplink', '0' ); ?>
				<p class="howto toggle-arrow <?php if ( $show_internal ) echo 'toggle-arrow-active'; ?>" id="internal-toggle"><?php _e( 'Or link to existing content', SPOTS_DOM ); ?></p>
				<div id="search-panel"<?php if ( ! $show_internal ) echo ' style="display:none"'; ?>>
					<div class="link-search-wrapper">
						<label>
							<span><?php _e( 'Search', SPOTS_DOM ); ?></span>
							<input type="text" id="search-field" class="link-search-field" tabindex="60" autocomplete="off" />
							<img class="waiting" src="<?php echo esc_url( admin_url( 'images/wpspin_light.gif' ) ); ?>" alt="" />
						</label>
					</div>
					<div id="search-results" class="query-results">
						<ul></ul>
						<div class="river-waiting">
							<img class="waiting" src="<?php echo esc_url( admin_url( 'images/wpspin_light.gif' ) ); ?>" alt="" />
						</div>
					</div>
					<div id="most-recent-results" class="query-results">
						<div class="query-notice"><em><?php _e( 'No search term specified. Showing recent items.', SPOTS_DOM ); ?></em></div>
						<ul></ul>
						<div class="river-waiting">
							<img class="waiting" src="<?php echo esc_url( admin_url( 'images/wpspin_light.gif' ) ); ?>" alt="" />
						</div>
					</div>
				</div>
			</div>
			<div class="submitbox">
				<div id="wp-link-cancel">
					<a class="submitdelete deletion" href="#"><?php _e( 'Cancel', SPOTS_DOM ); ?></a>
				</div>
				<div id="wp-link-update">
					<?php submit_button( __( 'Update', SPOTS_DOM ), 'primary', 'wp-link-submit', false, array( 'tabindex' => 100 ) ); ?>
				</div>
			</div>
			</form> <?php
		}


		function admin_head( ) {
			global $pagenow, $post;

			if ( ! empty( $post ) && $post->post_type == SPOTS_POST_TYPE && $pagenow == 'post.php' ) {
				remove_editor_styles( );
				add_editor_style( apply_filters( 'spots_editor_css', null ) );
			} ?>

			<style type="text/css">
				#postdivrich .mce-i-addspotbutton,
				#wpbody-content span.mce_addspotbutton,
				#adminmenu #menu-posts-spot div.wp-menu-image,
				#icon-edit.icon32-posts-spot {
					background-image: url( <?php echo esc_url( SPOTS_URL ) ?>/assets/icon.png );
					background-repeat:no-repeat;
					background-color:transparent;
					background-position:0 0;
					background-size: initial;
				}

				@media
		        only screen and (-webkit-min-device-pixel-ratio: 1.5),
		        only screen and (   min--moz-device-pixel-ratio: 1.5),
		        only screen and (     -o-min-device-pixel-ratio: 3/2),
		        only screen and (        min-device-pixel-ratio: 1.5),
		        only screen and (                min-resolution: 1.5dppx) {
					#postdivrich .mce-i-addspotbutton,
					#wpbody-content span.mce_addspotbutton,
					#adminmenu #menu-posts-spot div.wp-menu-image,
					#icon-edit.icon32-posts-spot {
						-webkit-background-size: 85px 56px;
	                	-moz-background-size: 85px 56px;
	                	background-size: 85px 56px;
					}
				}

				#postdivrich .mce-i-addspotbutton:hover,
				#wpbody-content span.mce_addspotbutton:hover	{ background-position: 0 -20px }
				#adminmenu #menu-posts-spot div.wp-menu-image 		{ background-position: -20px 0 }
				#adminmenu #menu-posts-spot:hover div.wp-menu-image{ background-position: -20px -28px }
				#icon-edit.icon32-posts-spot 						{ background-position: -48px 0 }
				.acInput {width: 200px;}
				.acResults {padding: 0px;border: 1px solid WindowFrame;background-color: Window;overflow: hidden;}
				.acResults ul {width: 100%;list-style-position: outside;list-style: none;padding: 0;margin: 0;}
				.acResults li {margin: 0px;padding: 2px 5px;cursor: pointer;display: block;width: 100%;font: menu;font-size: 12px;overflow: hidden;}
				.acLoading {background : url( 'indicator.gif' ) right center no-repeat;}
				.acSelect {background-color: Highlight;color: HighlightText;}
			</style>
			<?php
		}

		public static function edit_link( $spot_id, $echo = true ) {

			$edit_link = '';

			add_action( 'wp_footer', array( 'icit_spots', 'edit_link_style' ) );
			$edit_link = '<div class="icit-spot-edit-link-holder"><a class="icit-spot-edit-link" href="' . get_edit_post_link( $spot_id ) . '">' . __( 'Edit Spot', SPOTS_DOM ) . '</a></div>';

			if ( $echo )
				echo $edit_link;
			return $edit_link;
		}

		public static function edit_link_style() { ?>
			<style>
			.icit-spot-edit-link-holder {
				position: relative;
				height: 0;
				background: transparent;
				z-index: 9999999;
			}
			.icit-spot-edit-link-holder .icit-spot-edit-link {
				display: none !important;
				position: absolute !important;
				top: 0 !important;
				right: 0 !important;
				/* WP button styling */
				text-decoration: none !important;
				font-size: 12px !important;
				line-height: 23px !important;
				height: 24px !important;
				margin: 0 !important;
				padding: 0 10px 1px !important;
				cursor: pointer !important;
				border-width: 1px !important;
				border-style: solid !important;
				-webkit-border-radius: 3px !important;
				-webkit-appearance: none !important;
				border-radius: 3px !important;
				white-space: nowrap !important;
				-webkit-box-sizing: border-box !important;
				-moz-box-sizing:    border-box !important;
				box-sizing:         border-box !important;
			}
			.icit-spot-edit-link-holder .icit-spot-edit-link::-moz-focus-inner {
				border-width: 1px 0 !important;
				border-style: solid none !important;
				border-color: transparent !important;
				padding: 0 !important;
			}
			.icit-spot-edit-link-holder .icit-spot-edit-link:active {
				outline: none !important;
			}
			.icit-spot-edit-link-holder .icit-spot-edit-link {
				background: #f3f3f3;
				background-image: -webkit-gradient(linear, left top, left bottom, from(#fefefe), to(#f4f4f4));
				background-image: -webkit-linear-gradient(top, #fefefe, #f4f4f4);
				background-image:    -moz-linear-gradient(top, #fefefe, #f4f4f4);
				background-image:      -o-linear-gradient(top, #fefefe, #f4f4f4);
				background-image:   linear-gradient(to bottom, #fefefe, #f4f4f4);
				border-color: #bbb;
				color: #333;
				text-shadow: 0 1px 0 #fff;
			}
			.icit-spot-edit-link-holder .icit-spot-edit-link:hover,
			.icit-spot-edit-link-holder .icit-spot-edit-link:focus {
				background: #f3f3f3;
				background-image: -webkit-gradient(linear, left top, left bottom, from(#fff), to(#f3f3f3));
				background-image: -webkit-linear-gradient(top, #fff, #f3f3f3);
				background-image:    -moz-linear-gradient(top, #fff, #f3f3f3);
				background-image:     -ms-linear-gradient(top, #fff, #f3f3f3);
				background-image:      -o-linear-gradient(top, #fff, #f3f3f3);
				background-image:   linear-gradient(to bottom, #fff, #f3f3f3);
				border-color: #999;
				color: #222;
			}
			.icit-spot-edit-link-holder .icit-spot-edit-link:focus {
				-webkit-box-shadow: 1px 1px 1px rgba(0,0,0,.2);
				box-shadow: 1px 1px 1px rgba(0,0,0,.2);
			}
			.icit-spot-edit-link-holder .icit-spot-edit-link:active {
				background: #eee;
				background-image: -webkit-gradient(linear, left top, left bottom, from(#f4f4f4), to(#fefefe));
				background-image: -webkit-linear-gradient(top, #f4f4f4, #fefefe);
				background-image:    -moz-linear-gradient(top, #f4f4f4, #fefefe);
				background-image:     -ms-linear-gradient(top, #f4f4f4, #fefefe);
				background-image:      -o-linear-gradient(top, #f4f4f4, #fefefe);
				background-image:   linear-gradient(to bottom, #f4f4f4, #fefefe);
				border-color: #999;
				color: #333;
				text-shadow: 0 -1px 0 #fff;
				-webkit-box-shadow: inset 0 2px 5px -3px rgba( 0, 0, 0, 0.5 );
				box-shadow: inset 0 2px 5px -3px rgba( 0, 0, 0, 0.5 );
			}
			.icit-spot-content:hover .icit-spot-edit-link-holder .icit-spot-edit-link,
			.spot:hover .icit-spot-edit-link-holder .icit-spot-edit-link {
				display: inline-block !important;
			}
			</style><?php
		}
	}
}


if ( ! class_exists( 'icit_spots_mce_button' ) ) {
	class icit_spots_mce_button {
		public function __construct () {
			add_action( 'admin_init', array( $this, 'the_button' ) );
			add_action( 'wp_ajax_spots_mce_popup', array( $this, 'mce_popup' ) );

			// Register some scripts
			wp_register_script( 'autocomplete', trailingslashit( SPOTS_URL ) . 'assets/js/jquery.autocomplete.js', array( 'jquery' ) );
			wp_register_script( 'icit-finder', trailingslashit( SPOTS_URL ) . 'assets/js/finder.js', array( 'jquery', 'autocomplete' ), 1, true );
			wp_localize_script( 'icit-finder', 'icitFinderL10', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
			wp_register_style( 'icit-finder', trailingslashit( SPOTS_URL ) . 'assets/popup.css' );
		}


		function the_button( ) {
			global $typenow;

			if ( ! ( ! empty( $typenow ) && $typenow == SPOTS_POST_TYPE ) && ( current_user_can( 'edit_posts' ) || current_user_can( 'edit_pages' ) ) && true == get_user_option( 'rich_editing' ) ) {
				add_filter( 'mce_external_plugins', array( $this, 'create_extra_mce_plugin' ) );
				add_filter( 'mce_buttons', array( $this, 'create_extra_mce_button' ) );
			}
		}


		function create_extra_mce_button( $buttons ) {
			array_push( $buttons, 'addspotbutton' );
			return $buttons;
		}


		function create_extra_mce_plugin( $plugins ) {
			$plugins[ 'addspotbutton' ] = SPOTS_URL . '/assets/js/editor_plugin.js';
			return $plugins;
		}


		function mce_popup( ) {
			global $icit_spots;

			?><!DOCTYPE html>
			<html <?php language_attributes( ); ?>>
				<head>
					<meta charset="<?php bloginfo( 'charset' ); ?>" />
					<title><?php _e( 'Insert Spot.', SPOTS_DOM ); ?></title>

					<script language="javascript" type="text/javascript" src="<?php echo set_url_scheme( includes_url( '/js/tinymce/tiny_mce_popup.js' ), is_ssl() ? 'https' : 'http' ) ?>"></script>
					<script language="javascript" type="text/javascript" src="<?php echo set_url_scheme( includes_url( '/js/tinymce/utils/form_utils.js' ), is_ssl() ? 'https' : 'http' ) ?>"></script> <?php
					wp_print_scripts( 'icit-finder' );
					wp_print_styles( 'icit-finder' );?>
				</head>

				<body id="insert_spot" onload="tinyMCEPopup.executeOnLoad( 'tinyMCEPopup.resizeToInnerSize();' );document.body.style.display='';" style="display: none">
					<form action="#"> <?php

						$spots = get_posts( array( 'post_type' => SPOTS_POST_TYPE, 'showposts' => 10 ) );
						$template = ''; //get_post_meta( $post->ID, '_spot_part', true );

						if ( ! empty( $spots ) ) {
							?>

							<div id="current_item">
								<div class="label"><?php _e( 'Current:', SPOTS_DOM )?></div>
								<p id="current_item_title"><?php _e( '(None selected)', SPOTS_DOM ); ?></p>
							</div>

							<div id="spot_selector">
								<div class="query-notice"><em><?php _e( 'Recent Spots.', SPOTS_DOM )?></em></div>
								<ul id="search_results"> <?php
								foreach ( $spots as $i => $spot ) {
									printf( '<li data-value="%s" class="recentspot%s">%s</li>',
										   esc_attr( $spot->ID ),
										   esc_attr( $i % 2 ? '' : ' alternate' ),
										   esc_html( ! empty( $spot->post_title ) ? $spot->post_title : $spot->ID ) );
								} ?>
								</ul>

								<input type="hidden" id="spot_id" />
							</div>

							<div id="spot_search">
								<p class="howto"><?php _e( 'Search for spots', SPOTS_DOM ); ?></p>
								<label for="spot_id_drop_search"><?php _e( 'Search:', SPOTS_DOM ); ?></label>
								<input type="text" id="spot_id_drop_search" />
							</div><?php


							if ( $templates = $icit_spots->get_templates() ) {
								?>
								<div id="spot_templates">
									<p class="howto"><?php _e( 'Choose a template', SPOTS_DOM ); ?></p>

									<label for="spot_template"><?php _e( 'Template:', SPOTS_DOM ) ?></label>
									<select id="spot_template">
										<option value=""><?php _e( 'Default Template', SPOTS_DOM ); ?></option> <?php
										foreach ( $templates as $i => $name ) {
											printf( '<option value="%s" %s>%s</option>', esc_attr( $name ), selected( $name, $template, false ), esc_html( ucfirst( $name ) ) );
										} ?>
									</select>
								</div><?php
							} ?>

							<p><a target="spots" onclick="javascript:var t=setTimeout(function(){tinyMCEPopup.close();},1);" href="./post-new.php?post_type=<?php echo SPOTS_POST_TYPE; ?>"><?php _e( 'Create a new spot.', SPOTS_DOM ) ?></a></p>
							<?php
						} else {
							?>
							<p><?php _e( 'You don\'t have any spots to choose from yet.', SPOTS_DOM ); ?></p>
							<p><a target="spots" onclick="javascript:var t=setTimeout(function(){tinyMCEPopup.close();},1);" href="./post-new.php?post_type=<?php echo SPOTS_POST_TYPE; ?>"><?php _e( 'Create a new spot.', SPOTS_DOM ) ?></a></p>
							<?php
						}
						?>
						<div class="buttons">
							<div class="alignleft">
								<input type="submit" id="insert" name="insert" value="<?php _e( 'Insert', SPOTS_DOM ); ?>"/>
							</div>

							<div class="alignright">
								<input type="button" id="cancel" name="cancel" value="<?php _e( 'Close', SPOTS_DOM ); ?>" onclick="tinyMCEPopup.close();" />
							</div>

						</div>
					</form>

				</body>
			</html><?php

			die( );
		}

	}

}


if ( ! class_exists( 'Spot_Widget' ) ) {
	class Spot_Widget extends WP_Widget {
		/**
		 * For WP<3.3 we need to steal the settings for each instance of TinyMCE
		 */
		var $settings = array();
		var $editor_id = 'spots_mce';


		/**
		 * constructor
		 *
		 * @return Null
		 */
		public function __construct( ) {
			$widget_ops = array( 'classname' => 'spot', 'description' => __( 'Spot widget. Create or choose an existing spot to display.', SPOTS_DOM ) );
			$control_ops = array( 'width' => 550 );
			$this->WP_Widget( SPOTS_POST_TYPE, __( 'Spot', SPOTS_DOM ), $widget_ops, $control_ops );

			add_action( 'admin_init', array( $this, 'admin_init' ), 100 );
			add_action( 'admin_footer', array( $this, 'admin_footer' ), 3001 );
			add_action( 'wp_ajax_set-spot-thumbnail', array( $this, 'set_spot_thumbnail' ) );
		}


		/**
		 * Queue up scripts as needed to the widget edit page.
		 *
		 * @return Null
		 */
		public function admin_init( ) {
			global $pagenow, $wp_version;

			if ( $pagenow != 'widgets.php' )
				return;

			// fix async upload image
			if( isset( $_REQUEST[ 'attachment_id' ] ) )
				$GLOBALS[ 'post' ] = get_post( $_REQUEST[ 'attachment_id' ] );

			// Queue up all the scripts needed.
			wp_enqueue_script( 'spots_script', SPOTS_URL . '/assets/js/spots.js', array( 'jquery' ), '2.0', true );
			wp_enqueue_style( 'spots_style', SPOTS_URL . '/assets/spots.css' );

			if ( version_compare( $wp_version, '3.5', '<' ) ) {
				add_thickbox( );
				wp_enqueue_script( 'media-upload' );
			} else {
				wp_enqueue_media();
			}


			if ( user_can_richedit( ) ) {
				wp_enqueue_script( 'post' );
				wp_enqueue_script( 'editor' );
			}

			wp_localize_script( 'spots_script', 'setPostThumbnailL10n', array(
						'setThumbnail' => __( 'Use as featured image', SPOTS_DOM ),
						'saving' => __( 'Saving...', SPOTS_DOM ),
						'error' => __( 'Could not set that as the thumbnail image. Try a different attachment.', SPOTS_DOM ),
						'done' => __( 'Done', SPOTS_DOM ),
						'l10n_print_after' => 'try{convertEntities(setPostThumbnailL10n);}catch(e){};',
						// Widget MCE stuff
						'basename' => SPOTS_POST_TYPE, // Widget Base name
						'mceid' => $this->editor_id, // Only of use for WP3.3+
						'media' => '.spot-media-buttons', // The class given to the media buttons
						'rich' => user_can_richedit( ) ? 1 : 0
					) );
		}


		/**
		 * Output all the stuff we need into the footer of the widgets page. The
		 * editor output here won't be used but will be spawned as needed by the
		 * javascript this is just here to initialise everything.
		 *
		 * @return Null
		 */
		public function admin_footer( ) {
			global $pagenow, $post;

			if ( $pagenow != 'widgets.php' || !user_can_richedit( ) )
				return;

			if ( empty( $post ) ) // Stops warnings being thrown on the widget page.
				$post = (object) array( 'post_status' => 'publish', 'ID' => -1 );

			add_filter( 'mce_buttons', array( __CLASS__, 'mce_buttons' ) ); // Remove unneeded buttons ?>

			<div class="icit-hidden-editor hidden"><?php

				// The editor, mostly so all the js gets included.
				wp_editor( '', $this->editor_id, array( 'media_buttons' => true, 'dfw' => false, 'tinymce' => array( 'height' => 350 ) ) ); ?>

			</div><?php

			// Delete the filters applied above so they don't cause problems elsewhere
			remove_filter( 'mce_buttons', array( __CLASS__, 'mce_buttons' ) );

		}


		/**
		 * For older version of WordPress I need to grab the settings passed to
		 * TinyMCE so that they can be used again each time we reinit MCE. Wp33+
		 * keeps the settings for each instance in its own object but prior vers
		 * don't. There is a filter here for you to pass in your own editor CSS
		 * for tinyMCE. spots_editor_css
		 *
		 * @param array $initArray Array passed to TinyMCE with all its init
		 * settings
		 *
		 * @return Array    The same array as passing in with no changes.
		 */
		function steal_settings( $initArray = array() ) {
			if ( ! empty( $initArray[ 'icit_id' ] ) && $initArray[ 'icit_id' ] == $this->editor_id ) {
				$this->settings = '';
				$_tmp = $initArray;

				$css = apply_filters( 'spots_editor_css', null );
				$_tmp[ 'content_css' ] = ! empty( $css ) ? get_bloginfo( 'template_url' ) . $css : null;

				foreach ( $_tmp as $k => $v ) {
					if ( is_bool( $v ) ) {
						$val = $v ? 'true' : 'false';
						$this->settings .= $k . ':' . $val . ', ';
						continue;
					} elseif ( !empty( $v ) && is_string( $v ) && ( '{' == $v{0} || '[' == $v{0} ) ) {
						$this->settings .= $k . ':' . $v . ', ';
						continue;
					}

					$this->settings .= $k . ':"' . $v . '", ';
				}

				$this->settings = rtrim( trim( $this->settings ), '\n\r, ' );
			}

			return $initArray;
		}



		// basic button set for widget
		public static function mce_buttons( $buttons ) {
			$buttons = apply_filters( 'spots_mce_buttons', array(
				'bold',
				'italic',
				'|',
				'bullist',
				'numlist',
				'blockquote',
				'|',
				'link',
				'unlink',
				'|',
				'justifyleft',
				'justifycenter',
				'justifyright' ) );

			return $buttons;
		}


		function widget( $args, $instance ) {
			extract( $args );
			$title = apply_filters( 'widget_title', $instance[ 'title' ] );
			$spot_id = intval( $instance[ 'id' ] );
			$template = '';

			if ( empty( $spot_id ) )
				return;

			if( apply_filters( 'spots_show_edit_link', true ) )
				add_action( 'wp_footer', array( 'icit_spots', 'edit_link_style' ) );

			$content = icit_get_spot( ( int )$spot_id, ( ! empty( $template ) ? $template : '' ) );

			if ( empty( $content ) )
				return;

			if ( ! empty( $template ) )
				$before_widget = preg_replace( "/class=\"/", 'class="spot-'. $template .' ', $before_widget );

			echo $before_widget;


				
				echo $content;

			echo $after_widget;
		}


		function update( $new_instance, $old_instance ) {
			$instance = $old_instance;
			$instance[ 'title' ] = strip_tags( $new_instance[ 'title' ] );
			$instance[ 'id' ] = intval( $new_instance[ 'id' ] );
			$instance[ 'template' ] = isset( $new_instance[ 'template' ] ) ? $new_instance[ 'template' ] : false;

			// create spot if doesn't exist and there's a widget title
			if ( ( empty( $instance[ 'id' ] ) || $instance[ 'id' ] == 0 ) && ! empty( $instance[ 'title' ] ) )
				$instance[ 'id' ] = wp_insert_post( array( 'post_title' => $instance[ 'title' ], 'post_type' => SPOTS_POST_TYPE, 'post_status' => 'publish' ) );

			// update spot content if we have it
			if ( isset( $new_instance[ 'content' ] ) && ! empty( $new_instance[ 'content' ] ) )
				wp_update_post( array( 'ID' => $instance[ 'id' ], 'post_content' => $new_instance[ 'content' ] ) );

			// set widget title to spot title if spot not selected previously and widget title not set
			if ( empty( $old_instance[ 'title' ] ) && empty( $new_instance[ 'title' ] ) && !intval( $old_instance[ 'id' ] ) && $instance[ 'id' ] )
				$instance[ 'title' ] = get_the_title( $instance[ 'id' ] );

			return $instance;
		}


		function form( $instance ) {
			global $wp_version;

			extract( wp_parse_args( ( array )$instance, array(
				'title' => '',
				'id' => '',
				'template' => ''
			) ), EXTR_SKIP );

			if ( ! empty( $id ) && intval( $id ) > 0 )
				$spot_post = get_post( $id );

			$spots = get_posts( array( 'numberposts' => -1, 'post_type' => SPOTS_POST_TYPE ) );
			?>
			<p>
				<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', SPOTS_DOM ); ?>
					<input class="widefat title-field" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
				</label>
			</p> <?php

			// once a spot is chosen or created the widget is inexorably bound to that spot - simplifies the UI greatly.
			if ( empty( $id ) || $id == 0 ) { ?>
				<p>
					<a class="button create-spot" href="#"><?php _e( 'Create a new spot', SPOTS_DOM ); ?></a>
					<span class="description"><?php _e( '(You must enter a title first)', SPOTS_DOM ); ?></span>
				</p> <?php
			} else { ?>

				<input class="spot-id" type="hidden" name="<?php echo $this->get_field_name( 'id' ); ?>" value="<?php echo esc_attr( $id ); ?>" /> <?php
			}

			if ( count( $spots ) && ( empty( $id ) || $id == 0 ) ) { ?>
				<p>
					<label for="<?php echo $this->get_field_id( 'id' ); ?>"><?php if ( empty( $id ) ) _e( 'Or select an existing ', SPOTS_DOM ); _e( 'Spot:', SPOTS_DOM ); ?>
						<select name="<?php echo $this->get_field_name( 'id' ); ?>" id="<?php echo $this->get_field_id( 'id' ); ?>" class="widefat spot-select"> <?php
							printf( '<option value="">%s</option>', __( 'None', SPOTS_DOM ) );
							foreach ( $spots as $spot ) {
								printf( '<option value="%s"%s>%s</option>', esc_attr( $spot->ID ), selected( $spot->ID, (int)$id, false ), esc_html( ! empty( $spot->post_title ) ? $spot->post_title : $spot->ID ) );
							} ?>
						</select>
					</label>
				</p> <?php
			}

			if ( isset( $spot_post ) ) { ?>
				
				<?php
				if ( version_compare( $wp_version, '3.5', '<' ) ) {
					?>

				<div class="spot-featured-image">
				<?php
				// show featured image if set
				if ( current_theme_supports( 'post-thumbnails' ) )
					echo $this->_wp_post_thumbnail_html( null, $spot_post->ID ); ?>
				</div>
				<?php
				}
			}
			$templates = icit_spots::$instance_spots->get_templates();
			if ( $templates ) {
				?>

				<p>
					<label for="<?php echo $this->get_field_id( 'template' ); ?>"><?php _e( 'Template', SPOTS_DOM ) ?></label>
					<select class="widefat" name="<?php echo $this->get_field_name( 'template' ); ?>" id="<?php echo $this->get_field_id( 'template' ); ?>">
						<option value=""><?php _e( 'Default Template', SPOTS_DOM ); ?></option> <?php
						foreach ( $templates as $i => $name ) {
							printf( '<option value="%s" %s>%s</option>', esc_attr( $name ), selected( $name, $template, false ), esc_html( ucfirst( $name ) ) );
						} ?>
					</select>
				</p> <?php

			} ?>

			<p><a class="edit-spot-link"<?php echo intval( $id ) ? '' : ' style="display:none;"';?> target="_parent" href="./post.php?post=<?php echo $id; ?>&amp;post_type=<?php echo SPOTS_POST_TYPE; ?>&amp;action=edit"><?php _e( 'Go to the full editor for this spot', SPOTS_DOM ); ?></a></p> <?php
		}


		// alternative spot featured image ajax handler
		function set_spot_thumbnail() {
			$post_ID = intval( $_POST['post_id'] );
			if ( !current_user_can( 'edit_post', $post_ID ) )
				die( '-1' );
			$thumbnail_id = intval( $_POST['thumbnail_id'] );

			check_ajax_referer( "set_spot_thumbnail-$post_ID" );

			if ( $thumbnail_id == '-1' ) {
				delete_post_meta( $post_ID, '_thumbnail_id' );
				die( Spot_Widget::_wp_post_thumbnail_html() );
			}

			if ( set_post_thumbnail( $post_ID, $thumbnail_id ) )
				die( Spot_Widget::_wp_post_thumbnail_html( $thumbnail_id, $post_ID ) );
			die( '0' );
		}


		// alternative spot featured image interface output
		function _wp_post_thumbnail_html( $thumbnail_id = NULL, $post_ID = 0 ) {
			global $content_width, $_wp_additional_image_sizes;
			$set_thumbnail_link = '<p class="hide-if-no-js"><a title="' . esc_attr__( 'Set featured image', SPOTS_DOM ) . '" href="' . esc_url( str_replace( 'post_id=0', "post_id=$post_ID", get_upload_iframe_src( 'image' ) ) ) . '" class="set-post-thumbnail thickbox">%s</a></p>';
			$content = sprintf( $set_thumbnail_link, esc_html__( 'Set featured image', SPOTS_DOM ) );

			if ( ! $thumbnail_id && $post_ID > 0 )
				$thumbnail_id = ( int )get_post_meta( $post_ID, '_thumbnail_id', true );

			if ( $thumbnail_id && get_post( $thumbnail_id ) ) {
				$old_content_width = $content_width;
				$content_width = 266;
				if ( !isset( $_wp_additional_image_sizes['post-thumbnail'] ) )
					$thumbnail_html = wp_get_attachment_image( $thumbnail_id, array( $content_width, $content_width ) );
				else
					$thumbnail_html = wp_get_attachment_image( $thumbnail_id, 'post-thumbnail' );
				if ( !empty( $thumbnail_html ) ) {
					$ajax_nonce = wp_create_nonce( "set_spot_thumbnail-$post_ID" );

					$content = sprintf( $set_thumbnail_link, $thumbnail_html );
					$content .= '<p class="hide-if-no-js"><a href="#" class="remove-post-thumbnail" onclick="WPRemoveThumbnail(\'' . $ajax_nonce . '\', '. $post_ID .' );return false;">' . esc_html__( 'Remove featured image', SPOTS_DOM ) . '</a></p>';
				}
				$content_width = $old_content_width;
			}

			return apply_filters( 'admin_spot_thumbnail_html', $content );
		}

		public static function _init( ) {
			register_widget( __CLASS__ );
		}

	}
}


/**
 * Determine if a post exists based on title, content, and date
 *
 * Copied from wp-admin/includes/post.php line 485 as function is only declared in admin
 *
 * @since 2.0.0
 *
 * @param string $title Post title
 * @param string $content Optional post content
 * @param string $date Optional post date
 * @return int Post ID if post exists, 0 otherwise.
 */
if ( ! function_exists( 'spot_post_exists' ) ) {
	function spot_post_exists( $title, $content = '', $date = '' ) {
		global $wpdb;

		$post_title = stripslashes( sanitize_post_field( 'post_title', $title, 0, 'db' ) );
		$post_slug = sanitize_title( $title );
		$post_content = stripslashes( sanitize_post_field( 'post_content', $content, 0, 'db' ) );
		$post_date = stripslashes( sanitize_post_field( 'post_date', $date, 0, 'db' ) );

		$query = "SELECT ID FROM $wpdb->posts WHERE 1=1 AND post_type = '" . SPOTS_POST_TYPE . "'"; // force checking of spots only
		$args = array();

		if ( !empty ( $date ) ) {
			$query .= ' AND post_date = %s';
			$args[] = $post_date;
		}

		if ( !empty ( $title ) ) {
			$query .= ' AND ( post_title = %s OR post_name = %s )';
			$args[] = $post_title;
			$args[] = $post_slug;
		}

		if ( !empty ( $content ) ) {
			$query .= ' AND post_content = %s';
			$args[] = $post_content;
		}

		if ( !empty ( $args ) )
			return $wpdb->get_var( $wpdb->prepare( $query, $args ) );

		return 0;
	}
}


/**
 * Echo a spot. Can be used directly in a template file
 *
 * @since 0.1
 *
 * @param string|int $spot_id Post ID or name
 * @param string $template Optional template slug eg. 'large' will load spot-large.php from your theme folder if it exists.
 * @return bool false if no spot found or spot is in draft mode and user does not have permission or HTML if spot found.
 */
function icit_spot( $spot_id = false, $template = '' ) {
	icit_get_spot( $spot_id, $template, true );
}

/**
 * Return a spot and optionally echo it automatically. Can be used directly in a template file
 *
 * @since 0.1
 *
 * @param string|int $spot_id Post ID or name
 * @param string $template Optional template slug eg. 'large' will load spot-large.php from your theme folder if it exists.
 * @param bool $echo If set to true the spot will be echoed before it is returned.
 * @return bool False if no spot found or spot is in draft mode and user does not have permission or HTML if spot found.
 */
function icit_get_spot( $spot_id = false, $template = '', $echo = false ) {
	global $post; // So we can set the post var and all the functions like "the_title" pick it up.

	// need to know what we're dealing with, eg. is it a post ID or a name/title
	if ( ! $spot_id )
		return;

	$is_id = false;
	$is_name = false;

	if ( is_numeric( $spot_id ) && $spot_id > 0 ) {
		$is_id = true;
	}
	elseif ( is_string( $spot_id ) ) {
		$is_name = true;
	}
	if ( ! $is_id && ! $is_name ) {
		return;
	}

	// check if we have an existing spot (only when a name is supplied)
	if ( $is_name ) {
		$name = $spot_id;

		// create the spot if it doesn't exist or assign it's post ID to $spot_id
		if ( 0 == ( $spot_id = spot_post_exists( $name ) ) ) {
			// create the spot and some useful place holder text if it doesn't exist
			$new_id = wp_insert_post( array(
				'post_title' => $name,
				'post_type' => SPOTS_POST_TYPE,
				'post_status' => 'draft'
			) );

			$spot_id = wp_update_post( array(
				'ID' => $new_id,
				'post_content' => '<div><a href="'. get_edit_post_link( $new_id ) .'">'. sprintf( __( 'Click here to edit the %s spot.', SPOTS_DOM ), esc_html( $name ) ) .'</a></div>'
			) );
		}
	}

	// allow template override
	if ( empty( $template ) ) {
		$post_template = get_post_meta( $spot_id, '_spot_part', true ); // Get the default for this spot
		if ( ! empty( $post_template ) )
			$template = $post_template;
	}

	// we need a transient pointer - can't be more than 64 chars
	$cache_id = 'spot_' . $spot_id . ( ! empty( $template ) ?  '_' . md5( $template ) : '' );

	// check cache
	$cache = false;
	$show_edit_link = apply_filters( 'spots_show_edit_link',true );
	if ( ! $show_edit_link && ( defined( 'SPOTS_CACHE_TIME' ) && (int) SPOTS_CACHE_TIME > 0 ) )
		$cache = get_transient( $cache_id );


	if ( ! $show_edit_link && $cache && is_array( $cache ) && isset( $cache[ 'output' ] ) ) {
		// set vars for final check
		extract( $cache, EXTR_SKIP );

	} else {
		$output = '';

		// get the content of the widget
		if ( is_numeric( $spot_id ) )
			$post = get_post( $spot_id );

		if ( ! isset( $post ) )
			return;

		setup_postdata( $post );

		// output buffer needed as we want to use "the loop" but need to support shortcode
		ob_start( );



		if ( ! empty( $template ) ) {
			get_template_part( SPOTS_POST_TYPE, $template );
		} elseif ( file_exists( get_stylesheet_directory() . '/' . SPOTS_POST_TYPE . '.php' ) ) {
			get_template_part( SPOTS_POST_TYPE );
		} else {
			the_content( );
		}

	
		$output = ob_get_clean( );
		$status = $post->post_status;

		if ( ( defined( 'SPOTS_CACHE_TIME' ) && (int) SPOTS_CACHE_TIME > 0 ) ) {
			// cache it
			delete_transient( $cache_id );
			if ( ! $show_edit_link )
				set_transient( $cache_id, array( 'output' => $output, 'status' => $status ), SPOTS_CACHE_TIME );
		}

		// resume normal service
		wp_reset_postdata();
	}

	// if unpublished and not an editor/author then don't show
	if ( ( $status != 'publish' && ! current_user_can( 'edit_posts' ) ) )
		return;

	// return or echo output
	if ( $echo )
		echo $output;
	return $output;
}
