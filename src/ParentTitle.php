<?php

namespace LongReadPlugin;

class ParentTitle
{

	private static ParentTitleGetter $getter;
	
	public function __construct(ParentTitleGetter $getter)
	{
		self::$getter = $getter;
	}

	public function get(): ?string
	{
		return self::$getter->get();
	}
}
