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

namespace WordPress\Plugins\EveOnlineTimeZones\Libs\Singletons;

\defined('ABSPATH') or die();

abstract class AbstractSingleton {
	protected function __construct() {
		;
	} // END protected function __construct()

	final public static function getInstance() {
		static $instances = [];

		$calledClass = \get_called_class();

		if(!isset($instances[$calledClass])) {
			$instances[$calledClass] = new $calledClass();
		} // END if(!isset($instances[$calledClass]))

		return $instances[$calledClass];
	} // END final public static function getInstance()

	final private function __clone() {
		;
	} // END final private function __clone()
} // END abstract class AbstractSingleton
