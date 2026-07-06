<?php

namespace LongReadPlugin;

class InPageNavigationItem
{
	public readonly string $title;
	public readonly ?string $id;

	public function __construct(string $title, ?string $id)
	{
		$this->title = $title;
		$this->id = $id;
	}
}
