<?php

namespace core\utils;

use core\config\LayoutConfig;
use core\libs\DecoratorHelper;

class LayoutUtil {
	public static function getViewInfo($actionInfo, $viewName) {
		if (! isset ( $actionInfo ['results'] )) {
			throw new \Exception ( "No view define for action with controller [" . $actionInfo ['controller'] . "] and method [" . $actionInfo ['method'] . "]." );
		}
		foreach ( $actionInfo ['results'] as $view => $viewInfo ) {
			if ($view === $viewName) {
				return $viewInfo;
			}
		}
		return null;
	}
	public static function getLayout($module, $path) {
		// Ignore get layout if the decorator is not config.
		$decorators = LayoutConfig::getModuleLayoutConfig ( $module );
		if (is_null ( $decorators )) {
			return null;
		}
		// Check if the path is in exclude list.
		$excludes = isset ( $decorators ['excludes'] ) ? $decorators ['excludes'] : null;
		if (! is_null ( $excludes )) {
			foreach ( $excludes as $exclude ) {
				$decoratorHelper = new DecoratorHelper ( $exclude );
				if (preg_match ( $decoratorHelper->getExp (), $path )) {
					return null;
				}
			}
		}
		// Get layout.
		$layouts = isset ( $decorators ['layouts'] ) ? $decorators ['layouts'] : null;
		if (is_null ( $layouts )) {
			return null;
		}
		foreach ( $layouts as $layout ) {
			if (! isset ( $layout ['pattern'] ) || ! isset ( $layout ['layout'] )) {
				throw new \Exception ( "Invalid layout configuration." );
			}
			$decoratorHelper = new DecoratorHelper( $layout ['pattern'] );
			if (! $decoratorHelper->isValid ()) {
				throw new \Exception ( "Invalid layout configuration: the pattern [" . $layout ['pattern'] . "] is wrong." );
			}
			if (preg_match ( $decoratorHelper->getExp (), $path )) {
				return $layout ['layout'];
			}
		}
		return null;
	}
}