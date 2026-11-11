<?php

namespace LongReadPlugin;

/** @api */
interface InPageNavigationInterface
{
	/** @return InPageNavigationItem[] */
	public function getItems(): array;
}
