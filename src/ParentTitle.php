<?php

namespace LongReadPlugin;

class ParentTitle
{
	private static ParentTitleRetrieverInterface $getter;

	public function __construct(ParentTitleRetrieverInterface $getter)
	{
		self::$getter = $getter;
	}

	public static function get(): ?string
	{
		if (!isset(self::$getter)) {
			return null;
		}
		return self::$getter->get();
	}
}
