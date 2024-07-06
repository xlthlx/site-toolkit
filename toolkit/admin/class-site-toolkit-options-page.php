<?php
/**
 * Site Toolkit Options Page.
 *
 * @package Site_Toolkit
 */

/**
 * Class for add the options page and all fields.
 */
class Site_Toolkit_Options_Page {

	/**
	 * A static reference to track the single instance of this class.
	 *
	 * @var Site_Toolkit_Options_Page
	 */
	private static $instance;

	/**
	 * Holds the values to be used in the fields callbacks.
	 *
	 * @var array
	 */
	private $options;

	/**
	 * Holds the default values to be used in the fields callbacks.
	 *
	 * @var array
	 */
	private $defaults;

	/**
	 * WpToolkitOptionsPage constructor.
	 */
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'stk_add_menu_page' ) );
		add_action( 'admin_init', array( $this, 'stk_page_init' ) );
		add_action( 'init', array( $this, 'stk_output_buffer' ) );
	}

	/**
	 * Method used to provide a single instance of this class.
	 * Sets $defaults for the instance.
	 */
	public static function stk_get_instance() {

		if ( null === self::$instance ) {
			self::$instance = new Site_Toolkit_Options_Page();
		}

		global $defaults;
		self::$instance->stk_set_defaults( $defaults );

		return self::$instance;
	}

	/**
	 * Sets the default values for the fields.
	 *
	 * @param array $defaults Default options.
	 *
	 * @return Site_Toolkit_Options_Page
	 */
	public function stk_set_defaults( $defaults ) {
		$this->defaults = $defaults;

		return $this;
	}

	/**
	 * Add menu page.
	 */
	public function stk_add_menu_page() {

		// @codingStandardsIgnoreStart
		add_menu_page(
			__( 'Site Toolkit Options', 'site-toolkit' ),
			__( 'Site Toolkit', 'site-toolkit' ),
			'manage_options',
			'stk-settings',
			array( $this, 'stk_options_display' ),
			'dashicons-hammer'
		);
		// @codingStandardsIgnoreEnd
	}

	/**
	 * Start buffer.
	 *
	 * @return void
	 */
	public function stk_output_buffer() {
		ob_start();
	}

	/**
	 * Save options.
	 *
	 * @param string $option_name Option name.
	 * @param mixed  $value Option value.
	 *
	 * @return void
	 */
	public function stk_save_option( $option_name, $value ) {
		if ( false !== get_option( $option_name ) ) {
			update_option( $option_name, $value );
		} else {
			add_option( $option_name, $value );
		}
	}

	/**
	 * Options page callback.
	 */
	public function stk_options_display() {
		if ( ! empty( $_POST ) && check_admin_referer( 'stk_update', 'stk_update' ) ) {

			if ( isset( $_POST['widgetscontent'] ) ) {
				$widgets_content                                  = sanitize_textarea_field( wp_unslash( $_POST['widgetscontent'] ) );
				$_POST['stk_dashboard']['custom_widgets_content'] = $widgets_content;
			}

			$group = isset( $_POST['option_page'] ) ? sanitize_text_field( wp_unslash( $_POST['option_page'] ) ) : '';

			switch ( $group ) {
				case 'stk_general_group':
					// @codingStandardsIgnoreStart
					$stk_general = isset( $_POST['stk_general'] ) ? $_POST['stk_general'] : array();
					// @codingStandardsIgnoreEnd
					$stk_general = array_map( 'sanitize_text_field', array_map( 'wp_unslash', $stk_general ) );
					$this->stk_save_option( 'stk_general', $stk_general );
					$this->stk_show_message( 'general_options', __( 'Header Options saved.', 'site-toolkit' ), 'message' );
					break;
				case 'stk_seo_group':
					// @codingStandardsIgnoreStart
					$stk_seo = isset( $_POST['stk_seo'] ) ? $_POST['stk_seo'] : array();
					// @codingStandardsIgnoreEnd
					$stk_seo = array_map( 'sanitize_text_field', array_map( 'wp_unslash', $stk_seo ) );
					update_option( 'stk_seo', $stk_seo );
					$this->stk_show_message( 'seo_options', __( 'SEO Options saved.', 'site-toolkit' ), 'message' );
					break;
				case 'stk_archives_group':
					// @codingStandardsIgnoreStart
					$stk_archives = isset( $_POST['stk_archives'] ) ? $_POST['stk_archives'] : array();
					// @codingStandardsIgnoreEnd
					$stk_archives = array_map( 'sanitize_text_field', array_map( 'wp_unslash', $stk_archives ) );
					update_option( 'stk_archives', $stk_archives );
					$this->stk_show_message( 'archives_options', __( 'Archives Options saved.', 'site-toolkit' ), 'message' );
					break;
				case 'stk_dashboard_group':
					// @codingStandardsIgnoreStart
					$stk_dashboard = isset( $_POST['stk_dashboard'] ) ? $_POST['stk_dashboard'] : array();
					// @codingStandardsIgnoreEnd
					$stk_dashboard = array_map( 'sanitize_text_field', array_map( 'wp_unslash', $stk_dashboard ) );
					$this->stk_save_option( 'stk_dashboard', $stk_dashboard );
					$this->stk_show_message( 'dashboard_options', __( 'Dashboard Options saved.', 'site-toolkit' ), 'message' );
					break;
				case 'stk_listing_group':
					// @codingStandardsIgnoreStart
					$stk_listing = isset( $_POST['stk_listing'] ) ? $_POST['stk_listing'] : array();
					// @codingStandardsIgnoreEnd
					$stk_listing = array_map( 'sanitize_text_field', array_map( 'wp_unslash', $stk_listing ) );
					update_option( 'stk_listing', $stk_listing );
					$this->stk_show_message( 'listing_options', __( 'Listing Options saved.', 'site-toolkit' ), 'message' );
					break;
				case 'stk_login_group':
					// @codingStandardsIgnoreStart
					$stk_login = isset( $_POST['stk_login'] ) ? $_POST['stk_login'] : array();
					// @codingStandardsIgnoreEnd
					$stk_login = array_map( 'sanitize_text_field', array_map( 'wp_unslash', $stk_login ) );
					update_option( 'stk_login', $stk_login );
					$this->stk_show_message( 'login_options', __( 'Login Options saved.', 'site-toolkit' ), 'message' );
					break;
				case 'stk_uploads_group':
					// @codingStandardsIgnoreStart
					$stk_uploads = isset( $_POST['stk_uploads'] ) ? $_POST['stk_uploads'] : array();
					// @codingStandardsIgnoreEnd
					$stk_uploads = array_map( 'sanitize_text_field', array_map( 'wp_unslash', $stk_uploads ) );
					update_option( 'stk_uploads', $stk_uploads );
					$this->stk_show_message( 'uploads_options', __( 'Uploads Options saved.', 'site-toolkit' ), 'message' );
					break;
			}
		}

		$active_tab = isset( $_GET['tab'] ) ? sanitize_title( wp_unslash( $_GET['tab'] ) ) : 'general_options';

		echo '<div class="wrap option-stk_options">';

		$text  = '';
		$id    = '';
		$class = '';

		if ( isset( $_REQUEST['message'] ) && ! empty( $_REQUEST['message'] ) ) {
			$text  = sanitize_text_field( wp_unslash( $_REQUEST['message'] ) );
			$id    = 'settings-success';
			$class = 'notice-success';
		}
		if ( isset( $_REQUEST['error'] ) && ! empty( $_REQUEST['error'] ) ) {
			$text  = sanitize_text_field( wp_unslash( $_REQUEST['error'] ) );
			$id    = 'settings-error';
			$class = 'notice-error';
		}

		if ( '' !== $text ) { ?>
			<div id="<?php echo esc_attr( $id ); ?>" class="notice <?php echo esc_attr( $class ); ?> is-dismissible">
				<p><strong><?php echo esc_html( $text ); ?></strong></p>
				<button type="button" class="notice-dismiss">
					<span class="screen-reader-text"><?php esc_attr_e( 'Dismiss this notice.', 'site-toolkit' ); ?></span>
				</button>
			</div>
			<?php
		}
		?>

		<?php
		$label = false;
		switch ( $active_tab ) {
			case 'general_options':
				$label = __( 'Header', 'site-toolkit' );
				break;
			case 'seo_options':
				$label = __( 'SEO', 'site-toolkit' );
				break;
			case 'archives_options':
				$label = __( 'Archives', 'site-toolkit' );
				break;
			case 'dashboard_options':
				$label = __( 'Dashboard', 'site-toolkit' );
				break;
			case 'listing_options':
				$label = __( 'Listing', 'site-toolkit' );
				break;
			case 'login_options':
				$label = __( 'Login', 'site-toolkit' );
				break;
			case 'uploads_options':
				$label = __( 'Uploads', 'site-toolkit' );
				break;
		}
		?>
		<h2 style="margin-bottom:1em">Site Toolkit Options <?php echo ' - ' . esc_html( $label ); ?></h2>
		<h2 class="nav-tab-wrapper">
			<a href="?page=stk-settings&tab=general_options"
			   class="nav-tab <?php echo 'general_options' === $active_tab ? 'nav-tab-active' : ''; ?>"><?php esc_attr_e( 'Header', 'site-toolkit' ); ?></a>
			<a href="?page=stk-settings&tab=seo_options"
			   class="nav-tab <?php echo 'seo_options' === $active_tab ? 'nav-tab-active' : ''; ?>"><?php esc_attr_e( 'SEO', 'site-toolkit' ); ?></a>
			<a href="?page=stk-settings&tab=archives_options"
			   class="nav-tab <?php echo 'archives_options' === $active_tab ? 'nav-tab-active' : ''; ?>"><?php esc_attr_e( 'Archives', 'site-toolkit' ); ?></a>
			<a href="?page=stk-settings&tab=dashboard_options"
			   class="nav-tab <?php echo 'dashboard_options' === $active_tab ? 'nav-tab-active' : ''; ?>"><?php esc_attr_e( 'Dashboard', 'site-toolkit' ); ?></a>
			<a href="?page=stk-settings&tab=listing_options"
			   class="nav-tab <?php echo 'listing_options' === $active_tab ? 'nav-tab-active' : ''; ?>"><?php esc_attr_e( 'Listing', 'site-toolkit' ); ?></a>
			<a href="?page=stk-settings&tab=login_options"
			   class="nav-tab <?php echo 'login_options' === $active_tab ? 'nav-tab-active' : ''; ?>"><?php esc_attr_e( 'Login', 'site-toolkit' ); ?></a>
			<a href="?page=stk-settings&tab=uploads_options"
			   class="nav-tab <?php echo 'uploads_options' === $active_tab ? 'nav-tab-active' : ''; ?>"><?php esc_attr_e( 'Uploads', 'site-toolkit' ); ?></a>

		</h2>

		<?php

		echo '<form method="post">';
		wp_nonce_field( 'stk_update', 'stk_update' );

		global $stk_general, $stk_dashboard, $stk_seo, $stk_archives, $stk_listing, $stk_login, $stk_uploads;

		switch ( $active_tab ) {
			case 'general_options':
				$this->options = $stk_general;
				$this->stk_show_tab_fields( 'stk_general_group', __( 'Header', 'site-toolkit' ) );
				break;
			case 'dashboard_options':
				$this->options = $stk_dashboard;
				$this->stk_show_tab_fields( 'stk_dashboard_group', __( 'Dashboard', 'site-toolkit' ) );
				break;
			case 'seo_options':
				$this->options = $stk_seo;
				$this->stk_show_tab_fields( 'stk_seo_group', __( 'SEO', 'site-toolkit' ) );
				break;
			case 'archives_options':
				$this->options = $stk_archives;
				$this->stk_show_tab_fields( 'stk_archives_group', __( 'Archives', 'site-toolkit' ) );
				break;
			case 'listing_options':
				$this->options = $stk_listing;
				$this->stk_show_tab_fields( 'stk_listing_group', __( 'Listing', 'site-toolkit' ) );
				break;
			case 'login_options':
				$this->options = $stk_login;
				$this->stk_show_tab_fields( 'stk_login_group', __( 'Login', 'site-toolkit' ) );
				break;
			case 'uploads_options':
				$this->options = $stk_uploads;
				$this->stk_show_tab_fields( 'stk_uploads_group', __( 'Uploads', 'site-toolkit' ) );
				break;
		}

		echo '</form></div>';

	}

	/**
	 * Shows message after save.
	 *
	 * @param string $tab Tab name.
	 * @param string $message Message.
	 * @param string $type Type.
	 */
	public function stk_show_message( $tab, $message, $type ) {

		$arr_params = array(
			'page' => 'stk-settings',
			'tab'  => $tab,
			$type  => urlencode( $message ),
		);
		$url        = add_query_arg( $arr_params, admin_url( 'admin.php' ) );

		if ( wp_safe_redirect( $url ) ) {
			die();
		}
	}

	/**
	 * Show tab and submit button.
	 *
	 * @param string $group The labels group.
	 * @param string $label The label.
	 */
	public function stk_show_tab_fields( $group, $label ) {
		settings_fields( $group );
		do_settings_sections( $group );
		submit_button( __( 'Save ', 'site-toolkit' ) . $label . __( ' options', 'site-toolkit' ), 'primary', 'stk-submit' );
	}

	/**
	 * Register and add settings.
	 */
	public function stk_page_init() {

		/**
		 * General
		 */
		register_setting(
			'stk_general_group',
			'stk_general'
		);

		add_settings_section(
			'settings_section',
			'',
			array( $this, 'stk_general_callback' ),
			'stk_general_group'
		);

		add_settings_field(
			'emoji',
			__( 'Disable Emoji Support', 'site-toolkit' ),
			array( $this, 'stk_emoji_callback' ),
			'stk_general_group',
			'settings_section'
		);

		add_settings_field(
			'feeds',
			__( 'Removes RSS Feeds Links', 'site-toolkit' ),
			array( $this, 'stk_feeds_callback' ),
			'stk_general_group',
			'settings_section'
		);

		add_settings_field(
			'rest',
			__( 'Disable Rest API', 'site-toolkit' ),
			array( $this, 'stk_rest_callback' ),
			'stk_general_group',
			'settings_section'
		);

		add_settings_field(
			'links',
			__( 'Remove Header Links', 'site-toolkit' ),
			array( $this, 'stk_links_callback' ),
			'stk_general_group',
			'settings_section'
		);

		add_settings_field(
			'wp_version',
			__( 'Remove WordPress Version', 'site-toolkit' ),
			array( $this, 'stk_wp_callback' ),
			'stk_general_group',
			'settings_section'
		);

		add_settings_field(
			'versions',
			__( 'Change Style/Javascript Version', 'site-toolkit' ),
			array( $this, 'stk_versions_callback' ),
			'stk_general_group',
			'settings_section'
		);

		/**
		 * Dashboard
		 */

		register_setting(
			'stk_dashboard_group',
			'stk_dashboard'
		);

		add_settings_section(
			'header_dash_section',
			'',
			array( $this, 'stk_dash_callback' ),
			'stk_dashboard_group'
		);

		add_settings_field(
			'dashboard',
			__( 'Remove Dashboard Widgets', 'site-toolkit' ),
			array( $this, 'stk_dashboard_callback' ),
			'stk_dashboard_group',
			'header_dash_section'
		);

		add_settings_field(
			'custom_widgets',
			__( 'Custom Dashboard Widget', 'site-toolkit' ),
			array( $this, 'stk_widgets_callback' ),
			'stk_dashboard_group',
			'header_dash_section'
		);

		/**
		 * SEO
		 */

		register_setting(
			'stk_seo_group',
			'stk_seo'
		);

		add_settings_section(
			'seo_section',
			'',
			array( $this, 'stk_seo_callback' ),
			'stk_seo_group'
		);

		add_settings_field(
			'search',
			__( 'Pretty Permalink For Search', 'site-toolkit' ),
			array( $this, 'stk_search_callback' ),
			'stk_seo_group',
			'seo_section'
		);

		add_settings_field(
			'modheader',
			__( 'If-Modified-Since Header', 'site-toolkit' ),
			array( $this, 'stk_header_callback' ),
			'stk_seo_group',
			'seo_section'
		);

		add_settings_field(
			'image_alt',
			__( 'Image Alt Attribute', 'site-toolkit' ),
			array( $this, 'stk_alt_callback' ),
			'stk_seo_group',
			'seo_section'
		);

		/**
		 * Archives
		 */

		register_setting(
			'stk_archives_group',
			'stk_archives'
		);

		add_settings_section(
			'archives_section',
			'',
			array( $this, 'stk_archives_callback' ),
			'stk_archives_group'
		);

		add_settings_field(
			'remove-title',
			__( 'Remove Archive Title Prefix', 'site-toolkit' ),
			array( $this, 'stk_title_callback' ),
			'stk_archives_group',
			'archives_section'
		);

		add_settings_field(
			'redirect',
			__( 'Redirect Archives', 'site-toolkit' ),
			array( $this, 'stk_redirect_callback' ),
			'stk_archives_group',
			'archives_section'
		);

		/**
		 * Listing
		 */

		register_setting(
			'stk_listing_group',
			'stk_listing'
		);

		add_settings_section(
			'header_listing_section',
			'',
			array( $this, 'stk_listing_callback' ),
			'stk_listing_group'
		);

		add_settings_field(
			'posts_columns',
			__( 'Add Thumbnail Column To Posts', 'site-toolkit' ),
			array( $this, 'stk_posts_column_callback' ),
			'stk_listing_group',
			'header_listing_section'
		);

		add_settings_field(
			'pages_columns',
			__( 'Add Template Column To Pages', 'site-toolkit' ),
			array( $this, 'stk_pages_column_callback' ),
			'stk_listing_group',
			'header_listing_section'
		);

		/**
		 * Login
		 */

		register_setting(
			'stk_login_group',
			'stk_login'
		);

		add_settings_section(
			'header_login_section',
			'',
			array( $this, 'stk_login_callback' ),
			'stk_login_group'
		);

		add_settings_field(
			'wt-login',
			__( 'Change Login URL', 'site-toolkit' ),
			array( $this, 'stk_login_input_callback' ),
			'stk_login_group',
			'header_login_section'
		);

		/**
		 * Uploads
		 */

		register_setting(
			'stk_uploads_group',
			'stk_uploads'
		);

		add_settings_section(
			'uploads_section',
			'',
			array( $this, 'stk_uploads_callback' ),
			'stk_uploads_group'
		);

		add_settings_field(
			'clean_names',
			__( 'Clean File Names', 'site-toolkit' ),
			array( $this, 'stk_clean_names_callback' ),
			'stk_uploads_group',
			'uploads_section'
		);
	}

	/**
	 * Callback for general.
	 *
	 * @return void
	 */
	public function stk_general_callback() {
		echo '<h3> </h3>';
	}

	/**
	 * Callback for emoji.
	 *
	 * @return void
	 */
	public function stk_emoji_callback() {
		$this->stk_create_radio( 'stk_general', 'emoji_support', __( 'Removes the extra code to generate emojis in the header.', 'site-toolkit' ) );
	}

	/**
	 * Sets all the callbacks for the fields.
	 *
	 * @param string $group The field group.
	 * @param string $name The field name.
	 * @param string $description The field description.
	 *
	 * @return void
	 */
	public function stk_create_radio( $group, $name, $description ) {
		?>
		<label>
			<input name="<?php echo esc_attr( $group ) . '[' . esc_attr( $name ) . ']'; ?>" type="radio"
				   value="yes" <?php checked( 'yes', esc_attr( $this->options[ $name ] ) ); ?> /> <?php esc_attr_e( 'Yes', 'site-toolkit' ); ?>
		</label>
		<label>
			<input name="<?php echo esc_attr( $group ) . '[' . esc_attr( $name ) . ']'; ?>" type="radio"
				   value="no" <?php checked( 'no', esc_attr( $this->options[ $name ] ) ); ?> /> <?php esc_attr_e( 'No', 'site-toolkit' ); ?>
		</label>
		<br/>
		<p class="description">
			<small><?php echo esc_html( $description ); ?></small>
		</p>
		<?php
	}

	/**
	 * Callback for feeds.
	 *
	 * @return void
	 */
	public function stk_feeds_callback() {
		$this->stk_create_radio( 'stk_general', 'rss_feeds', __( 'Removes RSS feeds links in the header.', 'site-toolkit' ) );
	}

	/**
	 * Callback for rest api.
	 *
	 * @return void
	 */
	public function stk_rest_callback() {
		$this->stk_create_radio( 'stk_general', 'rest_api', __( 'Disables Rest API and removes Rest API links (only for not logged in users).', 'site-toolkit' ) );
	}

	/**
	 * Callback for links.
	 *
	 * @return void
	 */
	public function stk_links_callback() {
		$this->stk_create_radio( 'stk_general', 'links', __( 'Removes RSD link, wlwmanifest Link, shortlink, previous/next post Link in the header.', 'site-toolkit' ) );
	}

	/**
	 * Callback for WordPress.
	 *
	 * @return void
	 */
	public function stk_wp_callback() {
		$this->stk_create_radio( 'stk_general', 'wp_version', __( 'Removes the WordPress version meta in the header.', 'site-toolkit' ) );
	}

	/**
	 * Callback for file versions.
	 *
	 * @return void
	 */
	public function stk_versions_callback() {
		$this->stk_create_radio( 'stk_general', 'versions', __( 'Replaces the style and javascript version with the file version.', 'site-toolkit' ) );
	}

	/**
	 * Callback for dash.
	 *
	 * @return void
	 */
	public function stk_dash_callback() {
		echo '<h3> </h3>';
	}

	/**
	 * Callback for dashboard.
	 *
	 * @return void
	 */
	public function stk_dashboard_callback() {
		$this->stk_create_radio( 'stk_dashboard', 'dashboard_widgets', __( 'Removes all the Dashboard widgets.', 'site-toolkit' ) );
	}

	/**
	 * Callback for custom widgets,
	 *
	 * @return void
	 */
	public function stk_widgets_callback() {
		?>
		<style>#wp-widgetscontent-wrap, .medium {
			width: 40%;
			margin-bottom: 10px;
		  }</style>
		<?php

		printf(
			'<input placeholder="Title" type="text" name="stk_dashboard[custom_widgets_title]" class="medium" value="%s" /><br/>',
			isset( $this->options['custom_widgets_title'] ) ? esc_html( $this->options['custom_widgets_title'] ) : ''
		);

		$settings = array(
			'editor_height'    => 250,
			'teeny'            => true,
			'drag_drop_upload' => true,
		);
		echo '<p>';
		wp_editor( isset( $this->options['custom_widgets_content'] ) ? esc_textarea( $this->options['custom_widgets_content'] ) : __( 'Add the content of your custom widget here.', 'site-toolkit' ), 'widgetscontent', $settings );
		echo '</p><br/>';

		?>
		<p><strong><?php esc_attr_e( 'Context', 'site-toolkit' ); ?></strong>&nbsp;
			<label>
				<input name="stk_dashboard[custom_widgets_context]" type="radio"
					   value="normal" <?php checked( 'normal', esc_attr( $this->options['custom_widgets_context'] ) ); ?> /> <?php esc_attr_e( 'Normal', 'site-toolkit' ); ?>
			</label>
			<label>
				<input name="stk_dashboard[custom_widgets_context]" type="radio"
					   value="side" <?php checked( 'side', esc_attr( $this->options['custom_widgets_context'] ) ); ?> /> <?php esc_attr_e( 'Side', 'site-toolkit' ); ?>
			</label></p>
		<p class="description">
			<small><?php esc_attr_e( 'You can create a custom text Dashboard widget.', 'site-toolkit' ); ?></small>
		</p>
		<?php
	}

	/**
	 * Callback for SEO.
	 *
	 * @return void
	 */
	public function stk_seo_callback() {
		echo '<h3> </h3>';
	}

	/**
	 * Callback for search.
	 *
	 * @return void
	 */
	public function stk_search_callback() {
		$this->stk_create_radio( 'stk_seo', 'pretty_search', __( 'Sets up a pretty permalink for the search functionality.', 'site-toolkit' ) );
	}

	/**
	 * Callback for header.
	 *
	 * @return void
	 */
	public function stk_header_callback() {
		$this->stk_create_radio( 'stk_seo', 'header', __( 'Adds the If-Modified-Since Header into all pages/posts.', 'site-toolkit' ) );
	}

	/**
	 * Callback for image alt text.
	 *
	 * @return void
	 */
	public function stk_alt_callback() {
		$this->stk_create_radio( 'stk_seo', 'images_alt', __( 'Forces all the images to have an alt attribute.', 'site-toolkit' ) );
	}

	/**
	 * Callback for archives.
	 *
	 * @return void
	 */
	public function stk_archives_callback() {
		echo '<h3> </h3>';
	}

	/**
	 * Callback for remove titles.
	 *
	 * @return void
	 */
	public function stk_title_callback() {
		$this->stk_create_radio( 'stk_archives', 'remove_title', __( 'Removes the prefix in the archive title.', 'site-toolkit' ) );
	}

	/**
	 * Callback for redirect.
	 *
	 * @return void
	 */
	public function stk_redirect_callback() {
		?>
		<p>
			<strong><?php esc_attr_e( 'Redirect author', 'site-toolkit' ); ?></strong><br/>
			<label>
				<input name="stk_archives[redirect_author]" type="radio"
					   value="yes" <?php checked( 'yes', esc_attr( $this->options['redirect_author'] ) ); ?> /> <?php esc_attr_e( 'Yes', 'site-toolkit' ); ?>
			</label>
			<label>
				<input name="stk_archives[redirect_author]" type="radio"
					   value="no" <?php checked( 'no', esc_attr( $this->options['redirect_author'] ) ); ?> /> <?php esc_attr_e( 'No', 'site-toolkit' ); ?>
			</label>
		</p>
		<br/>
		<p>
			<strong><?php esc_attr_e( 'Redirect date', 'site-toolkit' ); ?></strong><br/>
			<label>
				<input name="stk_archives[redirect_date]" type="radio"
					   value="yes" <?php checked( 'yes', esc_attr( $this->options['redirect_date'] ) ); ?> /> <?php esc_attr_e( 'Yes', 'site-toolkit' ); ?>
			</label>
			<label>
				<input name="stk_archives[redirect_date]" type="radio"
					   value="no" <?php checked( 'no', esc_attr( $this->options['redirect_date'] ) ); ?> /> <?php esc_attr_e( 'No', 'site-toolkit' ); ?>
			</label>
		</p>
		<br/>
		<p>
			<strong><?php esc_attr_e( 'Redirect tags', 'site-toolkit' ); ?></strong><br/>
			<label>
				<input name="stk_archives[redirect_tag]" type="radio"
					   value="yes" <?php checked( 'yes', esc_attr( $this->options['redirect_tag'] ) ); ?> /> <?php esc_attr_e( 'Yes', 'site-toolkit' ); ?>
			</label>
			<label>
				<input name="stk_archives[redirect_tag]" type="radio"
					   value="no" <?php checked( 'no', esc_attr( $this->options['redirect_tag'] ) ); ?> /> <?php esc_attr_e( 'No', 'site-toolkit' ); ?>
			</label>
		</p>
		<br/>
		<p class="description">
			<small><?php esc_attr_e( 'Redirects authors archive, dates archive, tags archive to the homepage.', 'site-toolkit' ); ?></small>
		</p>
		<?php
	}

	/**
	 * Callback for listing.
	 *
	 * @return void
	 */
	public function stk_listing_callback() {
		echo '<h3> </h3>';
	}

	/**
	 * Callback for posts columns.
	 *
	 * @return void
	 */
	public function stk_posts_column_callback() {
		$this->stk_create_radio( 'stk_listing', 'posts_columns', __( 'Shows the thumbnail in a column in the admin posts listing.', 'site-toolkit' ) );
	}

	/**
	 * Callback for pages columns.
	 *
	 * @return void
	 */
	public function stk_pages_column_callback() {
		$this->stk_create_radio( 'stk_listing', 'pages_columns', __( 'Shows the Page Template name in a column in the admin pages listing.', 'site-toolkit' ) );
	}

	/**
	 * Callback for login.
	 *
	 * @return void
	 */
	public function stk_login_callback() {
		echo '<h3> </h3>';
	}

	/**
	 * Callback for login input.
	 *
	 * @return void
	 */
	public function stk_login_input_callback() {
		echo '<p>';
		if ( get_option( 'permalink_structure' ) ) {
			echo '<code>' . esc_url( trailingslashit( home_url() ) ) . '</code> <input type="text" name="stk_login[stk_login]" value="' . esc_html( $this->options['stk_login'] ) . '">' . ( $this->stk_use_trailing_slashes() ? ' <code>/</code>' : '' );
		} else {
			echo '<code>' . esc_url( trailingslashit( home_url() ) ) . '?</code> <input type="text" name="stk_login[stk_login]" value="' . esc_html( $this->options['stk_login'] ) . '">';
		}
		echo '</p>';
		?>
		<br/>
		<p class="description">
			<small><?php esc_attr_e( 'You can choose your own URL instead of using the default WordPress URL.', 'site-toolkit' ); ?></small>
		</p>
		<?php
	}

	/**
	 * Callback for slashes.
	 *
	 * @return bool
	 */
	public function stk_use_trailing_slashes() {
		return '/' === substr( get_option( 'permalink_structure' ), - 1, 1 );
	}

	/**
	 * Callback for uploads.
	 *
	 * @return void
	 */
	public function stk_uploads_callback() {
		echo '<h3> </h3>';
	}

	/**
	 * Callback for clean names.
	 *
	 * @return void
	 */
	public function stk_clean_names_callback() {
		$this->stk_create_radio( 'stk_uploads', 'clean_names', __( 'Removes all the special chars in the filename when you upload any file.', 'site-toolkit' ) );
	}

}
