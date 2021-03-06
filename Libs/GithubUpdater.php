<?php
namespace WordPress\Plugin\EveOnlineTimeZones\Libs;

\defined('ABSPATH') or die();

/**
 * @version 1.6
 * @author Joachim Kudish <info@jkudish.com>
 * @link http://jkudish.com
 * @package WP_GitHub_Updater
 * @license http://www.gnu.org/copyleft/gpl.html GNU Public License
 * @copyright Copyright (c) 2011-2013, Joachim Kudish
 *
 * GNU General Public License, Free Software Foundation
 * <http://creativecommons.org/licenses/GPL/2.0/>
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 */
class GithubUpdater {
	/**
	 * GitHub Updater version
	 */
	const VERSION = 1.6;

	/**
	 * @var $config the config for the updater
	 * @access public
	 */
	var $config;

	/**
	 * @var $missingConfig any config that is missing from the initialization of this instance
	 * @access public
	 */
	var $missingConfig;

	/**
	 * @var $githubData temporiraly store the data fetched from GitHub, allows us to only load the data once per class instance
	 * @access private
	 */
	private $githubData;

	/**
	 * Class Constructor
	 *
	 * @since 1.0
	 * @param array $config the configuration required for the updater to work
	 * @see has_minimum_config()
	 * @return void
	 */
	public function __construct($config = []) {
		$defaults = [
			'slug' => \plugin_basename(__FILE__),
			'proper_folder_name' => \dirname(\plugin_basename(__FILE__)),
			'sslverify' => true,
			'access_token' => '',
		];

		$this->config = \wp_parse_args($config, $defaults);

		// if the minimum config isn't set, issue a warning and bail
		if(!$this->hasMinimumConfig()) {
			$message = \__('The GitHub Updater was initialized without the minimum required configuration, please check the config in your plugin. The following params are missing: ', 'eve-online-time-zones');
			$message .= \implode(',', $this->missingConfig);

			\_doing_it_wrong(__CLASS__, $message, self::VERSION);

			return;
		} // END if(!$this->hasMinimumConfig())

		$this->setDefaults();
		$this->init();
	} // END public function __construct($config = array())

	/**
	 * Fire all WordPress actions
	 */
	public function init() {
		\add_filter('pre_set_site_transient_update_plugins', [$this, 'apiCheck']);

		// Hook into the plugin details screen
		\add_filter('plugins_api', [$this, 'getPluginInfo'], 10, 3);
		\add_filter('upgrader_post_install', [$this, 'upgraderPostInstall'], 10, 3);

		// set timeout
		\add_filter('http_request_timeout', [$this, 'httpRequestTimeout']);

		// set sslverify for zip download
		\add_filter('http_request_args', [$this, 'httpRequestSslVerify'], 10, 2);
	} // END public function init()

	/**
	 * Check if the minimum configuration is given
	 *
	 * @return boolean
	 */
	public function hasMinimumConfig() {
		$this->missingConfig = [];

		$requiredParams = [
			'api_url',
			'raw_url',
			'github_url',
			'zip_url',
			'requires',
			'tested',
			'readme',
		];

		foreach($requiredParams as $requiredParameter) {
			if(empty($this->config[$requiredParameter])) {
				$this->missingConfig[] = $requiredParameter;
			} // END if(empty($this->config[$requiredParameter]))
		} // END foreach($requiredParams as $requiredParameter)

		return (empty($this->missingConfig));
	} // END public function hasMinimumConfig()

	/**
	 * Check wether or not the transients need to be overruled and API needs to be called for every single page load
	 *
	 * @return bool overrule or not
	 */
	public function overruleTransients() {
		return (\defined('\WordPress\Plugin\EveOnlineTimeZones\EveOnlineTimeZones') && \WordPress\Plugin\EveOnlineTimeZones\WP_GITHUB_FORCE_UPDATE);
	} // END public function overruleTransients()

	/**
	 * Set defaults
	 *
	 * @since 1.2
	 * @return void
	 */
	public function setDefaults() {
		if(!empty($this->config['access_token'])) {
			// See Downloading a zipball (private repo) https://help.github.com/articles/downloading-files-from-the-command-line
			$parsedUrl = \parse_url($this->config['zip_url']); // $scheme, $host, $path

			$zipUrl = $parsedUrl['scheme'] . '://api.github.com/repos' . $parsedUrl['path'];
			$zipUrl = \add_query_arg(['access_token' => $this->config['access_token']], $zipUrl);

			$this->config['zip_url'] = $zipUrl;
		} // END if(!empty($this->config['access_token']))

		if(!isset($this->config['new_version'])) {
			$this->config['new_version'] = $this->getNewVersion();
		} // END if(!isset($this->config['new_version']))

		if(!isset($this->config['last_updated'])) {
			$this->config['last_updated'] = $this->getDate();
		} // END if(!isset($this->config['last_updated']))

		if(!isset($this->config['description'])) {
			$this->config['description'] = $this->getDescription();
		} // END if(!isset($this->config['description']))

		$pluginData = $this->getPluginData();
		if(!isset($this->config['plugin_name'])) {
			$this->config['plugin_name'] = $pluginData['Name'];
		} // END if(!isset($this->config['plugin_name']))

		if(!isset($this->config['version'])) {
			$this->config['version'] = $pluginData['Version'];
		} // END if(!isset($this->config['version']))

		if(!isset($this->config['author'])) {
			$this->config['author'] = $pluginData['Author'];
		} // END if(!isset($this->config['author']))

		if(!isset($this->config['homepage'])) {
			$this->config['homepage'] = $pluginData['PluginURI'];
		} // END if(!isset($this->config['homepage']))

		if(!isset($this->config['readme'])) {
			$this->config['readme'] = 'README.md';
		} // END if(!isset($this->config['readme']))
	} // END public function setDefaults()

	/**
	 * Callback fn for the http_request_timeout filter
	 *
	 * @since 1.0
	 * @return int timeout value
	 */
	public function httpRequestTimeout() {
		return 2;
	} // END public function httpRequestTimeout()

	/**
	 * Callback fn for the http_request_args filter
	 *
	 * @param array $args
	 * @param string $url
	 *
	 * @return array
	 */
	public function httpRequestSslVerify($args, $url) {
		if($this->config['zip_url'] == $url) {
			$args['sslverify'] = $this->config['sslverify'];
		} // END if($this->config['zip_url'] == $url)

		return $args;
	} // END public function httpRequestSslVerify($args, $url)

	/**
	 * Get New Version from GitHub
	 *
	 * @since 1.0
	 * @return int $version the version number
	 */
	public function getNewVersion() {
		$version = \get_site_transient(\md5($this->config['slug']) . '_new_version');

		if($this->overruleTransients() || (!isset($version) || !$version || $version === '')) {
			$rawResponse = $this->remoteGet(\trailingslashit($this->config['raw_url']) . \basename($this->config['slug']));

			if(\is_wp_error($rawResponse)) {
				$version = false;
			} // END if(\is_wp_error($rawResponse))

			if(\is_array($rawResponse)) {
				if(!empty($rawResponse['body'])) {
					\preg_match('/.*Version\:\s*(.*)$/mi', $rawResponse['body'], $matches);
				} // END if(!empty($rawResponse['body']))
			} // END if(\is_array($rawResponse))

			$version = false;
			if(!empty($matches[1])) {
				$version = $matches[1];
			} // END if(!empty($matches[1]))

			/**
			 * back compat for older readme version handling
			 * only done when there is no version found in file name
			 */
			if($version === false) {
				$rawResponse = $this->remoteGet(\trailingslashit($this->config['raw_url']) . $this->config['readme']);

				if(\is_wp_error($rawResponse)) {
					return $version;
				} // END if(\is_wp_error($rawResponse))

				\preg_match('#^\s*`*~Current Version\:\s*([^~]*)~#im', $rawResponse['body'], $__version);

				if(isset($__version[1])) {
					$version_readme = $__version[1];

					if(\version_compare($version, $version_readme) === -1) {
						$version = $version_readme;
					} // END if(\version_compare($version, $version_readme) === -1)
				} // END if(isset($__version[1]))
			} // END if($version === false)

			// refresh every 6 hours
			if($version !== false) {
				\set_site_transient(\md5($this->config['slug']) . '_new_version', $version, 60 * 60 * 6);
			}
		} // END if($this->overruleTransients() || (!isset($version) || !$version || $version === ''))

		return $version;
	} // END public function getNewVersion()

	/**
	 * Interact with GitHub
	 *
	 * @param string $query
	 *
	 * @since 1.6
	 * @return mixed
	 */
	public function remoteGet($query) {
		if(!empty($this->config['access_token'])) {
			$query = \add_query_arg(['access_token' => $this->config['access_token']], $query);
		} // END if(!empty($this->config['access_token']))

		$rawResponse = \wp_remote_get($query, [
			'sslverify' => $this->config['sslverify']
		]);

		return $rawResponse;
	} // END public function remoteGet($query)

	/**
	 * Get GitHub Data from the specified repository
	 *
	 * @since 1.0
	 * @return array $github_data the data
	 */
	public function getGithubData() {
		$githubData = null;

		if(isset($this->githubData) && !empty($this->githubData)) {
			$githubData = $this->githubData;
		} // END if(isset($this->githubData) && !empty($this->githubData))

		if($githubData === null) {
			$githubData = \get_site_transient(\md5($this->config['slug']) . '_github_data');

			if($this->overruleTransients() || (!isset($githubData) || !$githubData || $githubData === '')) {
				$githubRemoteData = $this->remoteGet($this->config['api_url']);

				if(\is_wp_error($githubRemoteData)) {
					return false;
				} // END if(\is_wp_error($githubRemoteData))

				$githubData = \json_decode($githubRemoteData['body']);

				// refresh every 6 hours
				\set_site_transient(\md5($this->config['slug']) . '_github_data', $githubData, 60 * 60 * 6);
			} // END if($this->overruleTransients() || (!isset($githubData) || !$githubData || $githubData === ''))

			// Store the data in this class instance for future calls
			$this->githubData = $githubData;
		} // END if($githubData === null)

		return $githubData;
	} // END public function getGithubData()

	/**
	 * Get update date
	 *
	 * @since 1.0
	 * @return string $date the date
	 */
	public function getDate() {
		$githubData = $this->getGithubData();

		return (!empty($githubData->updated_at)) ? date('Y-m-d', strtotime($githubData->updated_at)) : false;
	} // END public function getDate()

	/**
	 * Get plugin description
	 *
	 * @since 1.0
	 * @return string $description the description
	 */
	public function getDescription() {
		$githubData = $this->getGithubData();

		return (!empty($githubData->description)) ? $githubData->description : false;
	} // END public function getDescription()

	/**
	 * Get Plugin data
	 *
	 * @since 1.0
	 * @return object $data the data
	 */
	public function getPluginData() {
		include_once(ABSPATH . '/wp-admin/includes/plugin.php');

		$data = \get_plugin_data(\WP_PLUGIN_DIR . '/' . $this->config['slug']);

		return $data;
	} // END public function getPluginData()

	/**
	 * Hook into the plugin update check and connect to GitHub
	 *
	 * @since 1.0
	 * @param object $transient the plugin data transient
	 * @return object $transient updated plugin data transient
	 */
	public function apiCheck($transient) {
		/**
		 * Check if the transient contains the 'checked' information
		 * If not, just return its value without hacking it
		 */
		if(empty($transient->checked)) {
			return $transient;
		} // END if(empty($transient->checked))

		// check the version and decide if it's new
		$update = \version_compare($this->config['new_version'], $this->config['version']);

		if($update === 1) {
			$response = new \stdClass;
			$response->new_version = $this->config['new_version'];
			$response->slug = $this->config['proper_folder_name'];
			$response->url = \add_query_arg(['access_token' => $this->config['access_token']], $this->config['github_url']);
			$response->package = $this->config['zip_url'];

			// If response is false, don't alter the transient
			if($response !== false) {
				$transient->response[$this->config['slug']] = $response;
			} // END if($response !== false)
		} // END if($update === 1)

		return $transient;
	} // END public function apiCheck($transient)

	/**
	 * Get Plugin info
	 *
	 * @since 1.0
	 * @param bool $false always false
	 * @param string $action the API function being performed
	 * @param object $response
	 * @return object
	 */
	public function getPluginInfo($false, $action, $response) {
		// Check if this call API is for the right plugin
		if(!isset($response->slug) || $response->slug != $this->config['slug']) {
			return false;
		} // END if(!isset($response->slug) || $response->slug != $this->config['slug'])

		$response->slug = $this->config['slug'];
		$response->plugin_name = $this->config['plugin_name'];
		$response->version = $this->config['new_version'];
		$response->author = $this->config['author'];
		$response->homepage = $this->config['homepage'];
		$response->requires = $this->config['requires'];
		$response->tested = $this->config['tested'];
		$response->downloaded = 0;
		$response->last_updated = $this->config['last_updated'];
		$response->sections = ['description' => $this->config['description']];
		$response->download_link = $this->config['zip_url'];

		return $response;
	} // END public function getPluginInfo($false, $action, $response)

	/**
	 * Upgrader/Updater
	 * Move & activate the plugin, echo the update message
	 *
	 * @since 1.0
	 * @param boolean $true always true
	 * @param mixed $hookExtra not used
	 * @param array $result the result of the move
	 * @return array $result the result of the move
	 */
	public function upgraderPostInstall($true, $hookExtra, $result) {
		global $wp_filesystem;

		// Move & Activate
		$proper_destination = \WP_PLUGIN_DIR . '/' . $this->config['proper_folder_name'];
		$wp_filesystem->move($result['destination'], $proper_destination);
		$result['destination'] = $proper_destination;
		$activate = \activate_plugin(\WP_PLUGIN_DIR . '/' . $this->config['slug']);

		// Output the update message
		$fail = \__('The plugin has been updated, but could not be reactivated. Please reactivate it manually.', 'eve-online-time-zones');
		$success = \__('Plugin reactivated successfully.', 'eve-online-time-zones');

		echo \is_wp_error($activate) ? $fail : $success;

		return $result;
	} // END public function upgraderPostInstall($true, $hookExtra, $result)
} // END class GithubUpdater
