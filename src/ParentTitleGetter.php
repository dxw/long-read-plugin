<?php

namespace LongReadPlugin;

interface ParentTitleGetter
{
	public function get(): ?string;
}