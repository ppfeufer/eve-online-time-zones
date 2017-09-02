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

namespace WordPress\Plugin\EveOnlineTimeZones\Libs;

\defined('ABSPATH') or die();

class Template {
	/**
	 * The array of templates that this plugin tracks.
	 */
	protected $templates;

	/**
	 * Initializes the plugin by setting filters and administration functions.
	 */
	public function __construct() {
		// Add your templates to this array.
		$this->templates = [
			'../templates/page-eve-time-zones.php' => 'EVE Time Zones'
		];

		$this->init();
	} // END private function __construct()

	public function init() {
		// Add a filter to the attributes metabox to inject template into the cache.
		if(\version_compare(\floatval(\get_bloginfo('version')), '4.7', '<')) {
			// 4.6 and older
			\add_filter('page_attributes_dropdown_pages_args', [$this, 'registerProjectTemplates']);
		} else {
			// Add a filter to the wp 4.7 version attributes metabox
			\add_filter('theme_page_templates', [$this, 'addNewTemplate']);
		} // END if(\version_compare(\floatval(\get_bloginfo('version')), '4.7', '<'))

		// Add a filter to the save post to inject out template into the page cache
		\add_filter('wp_insert_post_data', [$this, 'registerProjectTemplates']);


		// Add a filter to the template include to determine if the page has our
		// template assigned and return it's path
		\add_filter('template_include', [$this, 'viewProjectTemplate']);
	}

	/**
	 * Adds our template to the page dropdown for v4.7+
	 *
	 * @param array $posts_templates
	 * @return array
	 */
	public function addNewTemplate($posts_templates) {
		$posts_templates = \array_merge($posts_templates, $this->templates);

		return $posts_templates;
	} // END public function addNewTemplate($posts_templates)

	/**
	 * Adds our template to the pages cache in order to trick WordPress
	 * into thinking the template file exists where it doens't really exist.
	 *
	 * @param array $atts
	 * @return array
	 */
	public function registerProjectTemplates($atts) {
		// Create the key used for the themes cache
		$cache_key = 'page_templates-' . \md5(\get_theme_root() . '/' . \get_stylesheet());

		// Retrieve the cache list.
		// If it doesn't exist, or it's empty prepare an array
		$templates = \wp_get_theme()->get_page_templates();

		if(empty($templates)) {
			$templates = [];
		} // END if(empty($templates))

		// New cache, therefore remove the old one
		\wp_cache_delete($cache_key, 'themes');

		// Now add our template to the list of templates by merging our templates
		// with the existing templates array from the cache.
		$templates = \array_merge($templates, $this->templates);

		// Add the modified cache to allow WordPress to pick it up for listing
		// available templates
		\wp_cache_add($cache_key, $templates, 'themes', 1800);

		return $atts;
	} // END public function registerProjectTemplates($atts)

	/**
	 * Checks if the template is assigned to the page
	 *
	 * @global object $post
	 * @param array $template
	 * @return string
	 */
	public function viewProjectTemplate($template) {
		// Get global post
		global $post;

		// Return template if post is empty
		if(!$post) {
			return $template;
		} // END if(!$post)

		// Return default template if we don't have a custom one defined
		if(!isset($this->templates[\get_post_meta($post->ID, '_wp_page_template', true)])) {
			return $template;
		} // END if(!isset($this->templates[\get_post_meta($post->ID, '_wp_page_template', true)]))

		$file = \plugin_dir_path(__FILE__) . \get_post_meta($post->ID, '_wp_page_template', true);

		// Just to be safe, we check if the file exist first
		if(\file_exists($file)) {
			return $file;
		} else {
			echo $file;
		} // END if(\file_exists($file))

		// Return template
		return $template;
	} // END public function viewProjectTemplate($template)


//	public function __construct() {
//		$this->init();
//	}
//
//	public function init() {
//		\add_filter('template_include', [$this, 'templateLoader']);
//		\add_filter('page_template', [$this, 'registerPageTemplate']);
//	}
//
//	/**
//	 * Registering a page template
//	 *
//	 * @param string $pageTemplate
//	 * @return string
//	 */
//	public function registerPageTemplate($pageTemplate) {
//		if(\is_page(self::getPosttypeSlug('intel'))) {
//			$pageTemplate = \WP_PLUGIN_DIR . '/eve-online-time-zones/templates/page-eve-time-zones.php';
//		} // END if(\is_page($this->getPosttypeSlug('intel')))
//
//		return $pageTemplate;
//	} // END public function registerPageTemplate($pageTemplate)
//
//	/**
//	 * Template loader.
//	 *
//	 * The template loader will check if WP is loading a template
//	 * for a specific Post Type and will try to load the template
//	 * from out 'templates' directory.
//	 *
//	 * @since 1.0.0
//	 *
//	 * @param	string	$template	Template file that is being loaded.
//	 * @return	string				Template file that should be loaded.
//	 */
//	public function templateLoader($template) {
//		$templateFile = null;
//
////		if(\is_singular('intel')) {
////			$templateFile = 'single-intel.php';
////		} elseif(\is_archive() && \get_post_type() === 'intel') {
////			$templateFile = 'page-intel.php';
////		} // END if(\is_singular('fitting'))
//
//		$templateFile = 'page-eve-time-zones.php';
//
//
//		if($templateFile !== null) {
//			if(\file_exists($this->locateTemplate($templateFile))) {
//				$template = $this->locateTemplate($templateFile);
//			} // END if(\file_exists(Helper\TemplateHelper::locateTemplate($file)))
//		} // END if($templateFile !== null)
//
//		return $template;
//	} // END function templateLoader($template)
//
//	/**
//	 * Locate template.
//	 *
//	 * Locate the called template.
//	 * Search Order:
//	 * 1. /themes/theme/templates/$template_name
//	 * 2. /themes/theme/$template_name
//	 * 3. /plugins/eve-online-intel-tool/templates/$template_name.
//	 *
//	 * @since 1.0.0
//	 *
//	 * @param 	string 	$template_name			Template to load.
//	 * @param 	string 	$template_path			Path to templates.
//	 * @param 	string	$default_path			Default path to template files.
//	 * @return 	string 							Path to the template file.
//	 */
//	public function locateTemplate($template_name, $template_path = '', $default_path = '') {
//		// Set variable to search in templates folder of theme.
//		if(!$template_path) {
//			$template_path = 'templates/';
//		} // END if(!$template_path)
//
//		// fail safe
//		if(\substr($template_name, -4) !== '.php') {
//			$template_name .= '.php';
//		} // END if(\substr($template_name, -4) !== '.php')
//
//		// Set default plugin templates path.
//		if(!$default_path) {
//			$default_path = PluginHelper::getInstance()->getPluginPath('templates/'); // Path to the template folder
//		} // END if(!$default_path)
//
//		// Search template file in theme folder.
//		$template = \locate_template([
//			$template_path . $template_name,
//			$template_name
//		]);
//
//		// Get plugins template file.
//		if(!$template) {
//			$template = $default_path . $template_name;
//		} // END if(!$template)
//
//		return \apply_filters('eve-online-intel-tool_locate_template', $template, $template_name, $template_path, $default_path);
//	}
//
//	/**
//	 * Get template.
//	 *
//	 * Search for the template and include the file.
//	 *
//	 * @since 1.0.0
//	 *
//	 * @see locateTemplate()
//	 *
//	 * @param string 	$template_name			Template to load.
//	 * @param array 	$args					Args passed for the template file.
//	 * @param string 	$tempate_path			Path to templates.
//	 * @param string	$default_path			Default path to template files.
//	 */
//	public function getTemplate($template_name, $args = [], $tempate_path = '', $default_path = '') {
//		if(\is_array($args) && isset($args)) {
//			\extract($args);
//		} // END if(\is_array($args) && isset($args))
//
//		// fail safe
//		if(\substr($template_name, -4) !== '.php') {
//			$template_name .= '.php';
//		} // END if(\substr($template_name, -4) !== '.php')
//
//		$template_file = self::locateTemplate($template_name, $tempate_path, $default_path);
//
//		if(!\file_exists($template_file)) {
//			\_doing_it_wrong(__FUNCTION__, \sprintf('<code>%s</code> does not exist.', $template_file), '1.0.0');
//
//			return;
//		} // END if(!\file_exists($template_file))
//
//		include $template_file;
//	} // END function getTemplate($template_name, $args = array(), $tempate_path = '', $default_path = '')
}
