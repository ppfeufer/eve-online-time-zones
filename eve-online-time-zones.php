<?php
/**
 * Plugin Name: EVE Online Time Zone List for WordPress
 * Plugin URI: https://github.com/ppfeufer/eve-online-intel-tool
 * GitHub Plugin URI: https://github.com/ppfeufer/eve-online-intel-tool
 * Description: Quick time zone overview. (Best with a theme running with <a href="http://getbootstrap.com/">Bootstrap</a>)
 * Version: 0.0.2
 * Author: Rounon Dax
 * Author URI: http://yulaifederation.net
 * Text Domain: eve-online-time-zones
 * Domain Path: /l10n
 */

namespace WordPress\Plugin\EveOnlineTimeZones;
const WP_GITHUB_FORCE_UPDATE = true;

// Include the autoloader so we can dynamically include the rest of the classes.
require_once(\trailingslashit(\dirname(__FILE__)) . 'inc/autoloader.php');

class TimeZones {
	/**
	 * Plugins text domain for translations
	 *
	 * @var string
	 */
	private $textDomain = null;

	/**
	 * Plugin Directory
	 *
	 * @var string
	 */
	private $pluginDir = null;

	/**
	 * Directory for translation files
	 *
	 * @var string
	 */
	private $localizationDirectory = null;

	/**
	 * Constructor
	 */
	public function __construct() {
		$this->textDomain = 'eve-online-intel-tool';
		$this->pluginDir = \trailingslashit(\WP_PLUGIN_DIR . \dirname(\plugin_basename(__FILE__)));
		$this->localizationDirectory = $this->pluginDir . 'l10n/';
	} // END public function __construct()

	/**
	 * Initialize the plugin
	 */
	public function init() {
		$jsLoader = new Libs\ResourceLoader\JavascriptLoader;
		$jsLoader->init();

		$cssLoader = new Libs\ResourceLoader\CssLoader;
		$cssLoader->init();
		new Libs\Template;

		if(\is_admin()) {
			/**
			 * Check Github for updates
			 */
			$githubConfig = [
				'slug' => \plugin_basename(__FILE__),
				'proper_folder_name' => \dirname(\plugin_basename(__FILE__)),
				'api_url' => 'https://api.github.com/repos/ppfeufer/eve-online-time-zones',
				'raw_url' => 'https://raw.github.com/ppfeufer/eve-online-time-zones/master',
				'github_url' => 'https://github.com/ppfeufer/eve-online-time-zones',
				'zip_url' => 'https://github.com/ppfeufer/eve-online-time-zones/archive/master.zip',
				'sslverify' => true,
				'requires' => '4.7',
				'tested' => '4.9-alpha',
				'readme' => 'README.md',
				'access_token' => '',
			];

			new Libs\GithubUpdater($githubConfig);
		} // END if(\is_admin())
	} // END public function init()

	/**
	 * Setting up our text domain for translations
	 */
	public function loadTextDomain() {
		if(\function_exists('\load_plugin_textdomain')) {
			\load_plugin_textdomain($this->textDomain, false, $this->localizationDirectory);
		} // END if(function_exists('\load_plugin_textdomain'))
	} // END public function addTextDomain()
} // END class TimeZones

/**
 * Start the show ....
 */
function initializePlugin() {
	$plugin = new TimeZones;

	/**
	 * Initialize the plugin
	 *
	 * @todo https://premium.wpmudev.org/blog/activate-deactivate-uninstall-hooks/
	 */
	$plugin->init();
} // END function initializePlugin()

// Start the show
\add_action('plugins_loaded', 'WordPress\Plugin\EveOnlineTimeZones\initializePlugin');
