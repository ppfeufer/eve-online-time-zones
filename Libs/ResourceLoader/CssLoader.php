<?php

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

namespace WordPress\Plugins\EveOnlineTimeZones\Libs\ResourceLoader;

\defined('ABSPATH') or die();

/**
 * CSS Loader
 */
class CssLoader implements \WordPress\Plugins\EveOnlineTimeZones\Libs\Interfaces\AssetsInterface {
	/**
	 * Initialize the loader
	 */
	public function init() {
		\add_action('wp_enqueue_scripts', [$this, 'enqueue'], 99);
	} // END public function init()

	/**
	 * Load the styles
	 */
	public function enqueue() {
		/**
		 * Only in Frontend
		 */
		if(!\is_admin()) {
			/**
			 * load only when needed
			 */
			global $template;

			if(\preg_match('/(.*)\/page-eve-time-zones.php/', $template)) {
				\wp_enqueue_style('bootstrap', \WP_PLUGIN_URL . '/eve-online-time-zones/bootstrap/css/bootstrap.min.css');
				\wp_enqueue_style('weather-icons', \WP_PLUGIN_URL . '/eve-online-time-zones/css/weather-icons/css/weather-icons.min.css');
				\wp_enqueue_style('eve-online-time-zones', \WP_PLUGIN_URL . '/eve-online-time-zones/css/eve-online-time-zones.min.css');
			} // END if(\preg_match('/(.*)\/page-eve-time-zones.php/', $template))
		} // END if(!\is_admin())
	} // END public function enqueue()
} // END class CssLoader implements \WordPress\Plugin\EveOnlineIntelTool\Libs\Interfaces\AssetsInterface
