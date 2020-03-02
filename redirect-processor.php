<?php


class WpRandomRedirectProcessor {
	public $redirectOptions;
	public function __construct() {
		$this->redirectOptions = get_option( 'wp_random_redirect_option_name' );
		add_action( 'template_redirect', [ $this, 'template_redirect' ] );
	}

	public function template_redirect() {
		$path       = $this->getCurrentUrlPath();
		$randomPath = $this->getRandomUrlPath();
		if ( $path != '' && $path == $randomPath ) {
			wp_redirect(
				$this->getRandomPostUrl() . 
				$this->getSuffix()
			);
			die;
		}
	}

	public function getCurrentUrlPath() {
		return $this->clearPath(
			WpRandomRedirectHelper::getRequest()
		);
	}
	
	public function clearPath( $path ) {
		return trim( $path, '/' );
	}

	public function getRandomUrlPath() {
		
		if ( isset( $this->redirectOptions['url_path'] ) ) {
			return $this->clearPath( $this->redirectOptions['url_path'] );
		}
		return '';
	}

	public function getRandomPostUrl() {
		$args = array(
			'post_type'      => 'post',
			'orderby'        => 'rand',
			'posts_per_page' => 1,
		);

		$the_query = new WP_Query( $args );
		$url = get_home_url();
		if ( $the_query->have_posts() ) {
			while ( $the_query->have_posts() ) {
				$the_query->the_post();
				$url = get_permalink();
			}
			wp_reset_postdata();
		}

		return $url;
	}

	public function getSuffix() {
		return $this->redirectOptions['url_suffix'];
	}
}

new WpRandomRedirectProcessor;