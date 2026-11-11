<?php

namespace LongReadPlugin;

/** @api */
interface ParentTitleRetrieverInterface
{
	public function get(): ?string;
}
