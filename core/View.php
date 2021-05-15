<?php

namespace core;

class View {
	protected $path;
	protected $layout;
	public function __construct($path, $layout = null) {
		if (! file_exists ( $path )) {
			throw new \Exception ( 'View file is not found in path: ' . $path );
		}
		if (! is_null ( $layout ) && ! file_exists ( $layout )) {
			throw new \Exception ( 'Layout file is not found in path: ' . $layout );
		}
		$this->path = $path;
		$this->layout = $layout;
	}
	public function render() {
		if (! empty ( $this->layout ) && $this->layout !== '') {
			Decorator::setBodyPath ( $this->path );
			include ($this->layout);
		} else {
			include ($this->path);
		}
	}
}