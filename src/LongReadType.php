<?php

namespace LongReadPlugin;

class LongReadType
{
	private $longReadType = 'multipage';

	public function returnType() {
		if (defined('LONG_READ_TYPE')) {
			$this->longReadType = LONG_READ_TYPE;
		}
		return $this->longReadType;
	}
}