<?php

namespace Emilia\EcoFriendlyRobotsTxt;

/**
 * Handles the eco-friendly robots.txt modifications.
 */
class Plugin {

	const BACKUP_PATH = ABSPATH . 'robots.txt.eco-friendly-backup';

	/**
	 * The list of allowed crawlers.
	 *
	 * @var string[]
	 */
	public $allowed_spiders;

	/**
	 * The list of blocked paths.
	 *
	 * @var string[]
	 */
	public $blocked_paths;

	/**
	 * The list of allowed paths.
	 *
	 * @var string[]
	 */
	public $allowed_paths;

	/**
	 * Initialize the hooks and filters.
	 */
	public function init() {
		add_filter( 'robots_txt', [ $this, 'modify_robots_txt' ], 100000, 2 ); // Priority 100000 to ensure it runs after Yoast SEO.
		register_activation_hook( __FILE__, [ $this, 'backup_static_robots_txt' ] );
		register_deactivation_hook( __FILE__, [ $this, 'restore_static_robots_txt' ] );
	}

	/**
	 * Backs up the static robots.txt file if it exists.
	 */
	public function backup_static_robots_txt() {
		$robots_path = ABSPATH . 'robots.txt';
		if ( file_exists( $robots_path ) ) {
			// phpcs:ignore Generic.Commenting.Todo.TaskFound
			// @todo Ask for user consent before proceeding.
			// This step will need to be handled via admin notice or a settings page.

			$wp_filesystem = $this->get_filesystem();
			$wp_filesystem::move( $robots_path, self::BACKUP_PATH );
		}
	}

	/**
	 * Restores the static robots.txt file upon plugin deactivation.
	 *
	 * @uses WP_Filesystem
	 */
	public function restore_static_robots_txt() {
		if ( file_exists( self::BACKUP_PATH ) ) {
			$robots_path = ABSPATH . 'robots.txt';

			$wp_filesystem = $this->get_filesystem();
			$wp_filesystem::move( self::BACKUP_PATH, $robots_path );
		}
	}

	/**
	 * Modifies the content of the dynamic robots.txt generated by WordPress.
	 *
	 * @param string $output      The original robots.txt content.
	 * @param bool   $site_public Whether the site is public.
	 *
	 * @return string Modified robots.txt content.
	 */
	public function modify_robots_txt( $output, $site_public ) {
		if ( ! $site_public ) {
			return "User-agent: *\nDisallow: /\n";
		}

		// We only need to do this when we're actually sending a robots.txt, hence here.
		$this->allowed_spiders = $this->get_allowed_spiders();
		$this->blocked_paths   = $this->get_blocked_paths();
		$this->allowed_paths   = $this->get_allowed_paths();

		$robots_txt  = "# This site is very specific about who it allows crawling from.\n";
		$robots_txt .= "# Our default is to not allow crawling:\n";
		$robots_txt .= "User-agent: *\n";
		$robots_txt .= "Disallow: /\n";

		$robots_txt .= "\n# Below are the crawlers that _are_ allowed to crawl this site.\n";
		$robots_txt .= "# Below that list, you'll find paths that are blocked, even for them,\n";
		$robots_txt .= "# and then paths within those blocked paths that are allowed.\n";
		foreach ( $this->allowed_spiders as $crawler => $description ) {
			$robots_txt .= "# $description\n";
			$robots_txt .= "User-agent: $crawler\n";
			$robots_txt .= "Allow: /\n";
			foreach ( $this->blocked_paths as $path ) {
				$robots_txt .= "Disallow: $path\n";
			}

			foreach ( $this->allowed_paths as $path ) {
				$robots_txt .= "Allow: $path\n";
			}
		}

		// Keep existing Sitemap references.
		if ( strpos( $output, 'Sitemap: ' ) !== false ) {
			preg_match_all( '/Sitemap: (.+)/', $output, $matches );
			foreach ( $matches[0] as $sitemap ) {
				$robots_txt .= "\n# XML Sitemap:\n";
				$robots_txt .= "$sitemap\n";
			}
		}

		/**
		 * Filters the output of the robots.txt file.
		 *
		 * @param string $allowed_spiders The list of allowed crawlers.
		 */
		return apply_filters( 'emilia/ecofriendly_robots/output', $robots_txt );
	}

	/**
	 * Retrieves the list of allowed crawlers.
	 *
	 * @return array
	 */
	private function get_allowed_spiders() {
		/**
		 * Filters the list of allowed crawlers.
		 *
		 * @param array $allowed_spiders The list of allowed crawlers.
		 */
		return apply_filters(
			'emilia/ecofriendly_robots/allowed_spiders',
			[
				'AdsBot-Google'        => 'Google Ads',
				'Applebot'             => 'Apple',
				'Baiduspider'          => 'Baidu',
				'Bingbot'              => 'Bing',
				'ChatGPT-User'         => 'ChatGPT user requests',
				'DuckDuckBot'          => 'DuckDuckGo',
				'FacebookExternalHit'  => 'Facebook',
				'GPTBot'               => 'OpenAI models',
				'Googlebot'            => 'Google',
				'LinkedInBot'          => 'LinkedIn',
				'MediaPartners-Google' => 'Google AdSense',
				'OAI-SearchBot'        => 'OpenAI Search',
				'Slurp'                => 'Yahoo',
				'Twitterbot'           => 'X',
				'WhatsApp'             => 'WhatsApp',
				'Yandex'               => 'Yandex',
				'ia_archiver'          => 'Archive.org',
			]
		);
	}

	/**
	 * Retrieves the list of blocked paths.
	 *
	 * @return array
	 */
	private function get_allowed_paths() {
		/**
		 * Filters the list of blocked paths.
		 *
		 * @param array $blocked_paths The list of blocked paths.
		 */
		return apply_filters(
			'emilia/ecofriendly_robots/blocked_paths',
			[
				'/wp-includes/css/',
				'/wp-includes/js/',
			]
		);
	}

	/**
	 * Retrieves the list of allowed paths.
	 *
	 * @return array
	 */
	private function get_blocked_paths() {
		/**
		 * Filters the list of allowed paths.
		 *
		 * @param array $allowed_paths The list of allowed paths.
		 */
		return apply_filters(
			'emilia/ecofriendly_robots/allowed_paths',
			[
				'/wp-json/',
				'/?rest_route=',
				'/wp-admin/',
				'/wp-content/cache/',
				'/wp-content/plugins/',
				'/xmlrpc.php',
				'/wp-includes/',
			]
		);
	}

	/**
	 * Retrieves the WordPress filesystem.
	 *
	 * @return WP_Filesystem
	 */
	private function get_filesystem() {
		global $wp_filesystem;

		require_once ABSPATH . '/wp-admin/includes/file.php';
		WP_Filesystem();
		return $wp_filesystem;
	}
}
