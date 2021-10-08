<?php
/**
 * Plugin Name: EVE Online Time Zone List for WordPress
 * Plugin URI: https://github.com/ppfeufer/eve-online-intel-tool
 * GitHub Plugin URI: https://github.com/ppfeufer/eve-online-intel-tool
 * Description: Quick time zone overview. (Best with a theme running with <a href="http://getbootstrap.com/">Bootstrap</a>)
 * Version: 0.0.5
 * Author: Rounon Dax
 * Author URI: http://yulaifederation.net
 * Text Domain: eve-online-time-zones
 * Domain Path: /l10n
 */

/**
 * Copyright (C) 2017 Rounon Dax
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace WordPress\Plugins\EveOnlineTimeZones;

const WP_GITHUB_FORCE_UPDATE = false;

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
        $this->textDomain = 'eve-online-time-zones';
        $this->pluginDir = \trailingslashit(\WP_PLUGIN_DIR . \dirname(\plugin_basename(__FILE__)));
        $this->localizationDirectory = \basename(\dirname(__FILE__)) . '/l10n';
    }

    /**
     * Initialize the plugin
     */
    public function init() {
        $this->initHooks();

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
                'tested' => '5.0-alpha',
                'readme' => 'README.md',
                'access_token' => '',
            ];

            new Libs\GithubUpdater($githubConfig);
        }
    }

    /**
     * Setting up our text domain for translations
     */
    public function loadTextDomain() {
        if(\function_exists('\load_plugin_textdomain')) {
            \load_plugin_textdomain($this->textDomain, false, $this->localizationDirectory);
        }
    }

    public function initHooks() {
        \add_action('plugins_loaded', [$this, 'loadTextDomain']);
    }
}

/**
 * Start the show ....
 */
function initializePlugin() {
    $plugin = new TimeZones;

    $plugin->init();
}

initializePlugin();
