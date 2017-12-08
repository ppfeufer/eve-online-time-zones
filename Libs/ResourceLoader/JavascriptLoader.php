<?php
/**
 * Copyright (C) 2017 Rounon Dax
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 */

namespace WordPress\Plugin\EveOnlineTimeZones\Libs\ResourceLoader;

\defined('ABSPATH') or die();

/**
 * JavaScript Loader
 */
class JavascriptLoader implements \WordPress\Plugin\EveOnlineTimeZones\Libs\Interfaces\AssetsInterface {
	/**
	 * Initialize the loader
	 */
	public function init() {
		\add_action('wp_enqueue_scripts', [$this, 'enqueue'], 99);
	} // END public function init()

	/**
	 * Load the JavaScript
	 */
	public function enqueue() {
		/**
		 * Only in Frontend
		 */
		if(!\is_admin()) {
			global $template;

			if(\preg_match('/(.*)\/page-eve-time-zones.php/', $template)) {
				\wp_enqueue_script('bootstrap-js', \WP_PLUGIN_URL . '/eve-online-time-zones/bootstrap/js/bootstrap.min.js', ['jquery'], '', true);
				\wp_enqueue_script('bootstrap-toolkit-js', \WP_PLUGIN_URL . '/eve-online-time-zones/bootstrap/bootstrap-toolkit/bootstrap-toolkit.min.js', ['jquery', 'bootstrap-js'], '', true);
				\wp_enqueue_script('clock-timezones-js', \WP_PLUGIN_URL . '/eve-online-time-zones/js/clock-timezones.min.js', ['jquery'], '', true);
				\wp_enqueue_script('moment-js', \WP_PLUGIN_URL . '/eve-online-time-zones/js/moment.min.js', ['jquery'], '', true);
				\wp_enqueue_script('timeago-js', \WP_PLUGIN_URL . '/eve-online-time-zones/js/jquery.timeago.min.js', ['jquery'], '', true);
				\wp_enqueue_script('timezone-data-js', \WP_PLUGIN_URL . '/eve-online-time-zones/js/moment-timezone-with-data-2012-2022.min.js', ['jquery'], '', true);
			} // END if(\preg_match('/(.*)\/page-eve-time-zones.php/', $template))
		} // END if(!\is_admin())
	} // END public function enqueue()
} // END class JavascriptLoader implements \WordPress\Plugin\EveOnlineIntelTool\Libs\Interfaces\AssetsInterface
