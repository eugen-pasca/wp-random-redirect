<?php


class WpRandomRedirectAdmin {
	private $wp_random_redirect_options;

	public function __construct() {
		add_action( 'admin_menu', array( $this, 'wp_random_redirect_add_plugin_page' ) );
		add_action( 'admin_init', array( $this, 'wp_random_redirect_page_init' ) );
	}

	public function wp_random_redirect_add_plugin_page() {
		add_menu_page(
			'Random Redirect', // page_title
			'Random Redirect', // menu_title
			'manage_options', // capability
			'wp-random-redirect', // menu_slug
			array( $this, 'wp_random_redirect_create_admin_page' ), // function
			'dashicons-randomize', // icon_url
			77  // position
		);
	}

	public function wp_random_redirect_create_admin_page() {
		$this->wp_random_redirect_options = get_option( 'wp_random_redirect_option_name' ); ?>

        <div class="wrap">
            <h2>Random Redirect</h2>
            <p></p>
			<?php settings_errors(); ?>

            <form method="post" action="options.php">
				<?php
				settings_fields( 'wp_random_redirect_option_group' );
				do_settings_sections( 'random-redirect-admin' );
				submit_button();
				?>
            </form>
        </div>
	<?php }

	public function wp_random_redirect_page_init() {
		register_setting(
			'wp_random_redirect_option_group', // option_group
			'wp_random_redirect_option_name', // option_name
			array( $this, 'wp_random_redirect_sanitize' ) // sanitize_callback
		);

		add_settings_section(
			'wp_random_redirect_setting_section', // id
			'Settings', // title
			array( $this, 'wp_random_redirect_section_info' ), // callback
			'random-redirect-admin' // page
		);

		add_settings_field(
			'url_path', // id
			'Url Path', // title
			array( $this, 'urlPathCallback' ), // callback
			'random-redirect-admin', // page
			'wp_random_redirect_setting_section' // section
		);

		add_settings_field(
			'url_suffix', // id
			'Url Suffix', // title
			array( $this, 'urlSuffixCallback' ), // callback
			'random-redirect-admin', // page
			'wp_random_redirect_setting_section' // section
		);
	}

	public function wp_random_redirect_sanitize( $input ) {
		$sanitary_values = array();
		if ( isset( $input['url_path'] ) ) {
			$sanitary_values['url_path'] = sanitize_text_field( $input['url_path'] );
		}
		if ( isset( $input['url_suffix'] ) ) {
			$sanitary_values['url_suffix'] = sanitize_text_field( $input['url_suffix'] );
		}

		return $sanitary_values;
	}

	public function wp_random_redirect_section_info() {

	}

	public function urlPathCallback() {
		printf(
			'<input class="regular-text" type="text" name="wp_random_redirect_option_name[url_path]" id="url_path" value="%s" placeholder="/random">',
			isset( $this->wp_random_redirect_options['url_path'] ) ? esc_attr( $this->wp_random_redirect_options['url_path'] ) : ''
		);
	}
	public function urlSuffixCallback() {
		printf(
			'<input class="regular-text" type="text" name="wp_random_redirect_option_name[url_suffix]" id="url_suffix" value="%s" placeholder="">',
			isset( $this->wp_random_redirect_options['url_suffix'] ) ? esc_attr( $this->wp_random_redirect_options['url_suffix'] ) : ''
		);
	}

}

if ( is_admin() ) {
	$random_redirect = new WpRandomRedirectAdmin;
}
