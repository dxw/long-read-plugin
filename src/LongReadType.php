<?php

namespace LongReadPlugin;

class LongReadType
{
	private $longReadType = 'Multipage';
	private $longReadTypeArgs = [ 'ChapterNavigation', 'InPageNavigation', 'ParentTitle' ];

	private function getType() {
		if (defined('PAGE_BREAK_LONG_READ_TYPE')) {
			$this->longReadType = 'PageBreak';
		}
		return $this->longReadType;
	}

	public function getClassNames() {
		$classNames = [];
		foreach ($this->longReadTypeArgs as $arg) {
			 $classNames[$arg] = '\LongReadPlugin\\' . $this->getType() . $arg;
		}
		return $classNames;
	}
}