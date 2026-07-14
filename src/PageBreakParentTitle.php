<?php

namespace LongReadPlugin;

class PageBreakParentTitle implements ParentTitleRetrieverInterface
{
	public function get(): ?string
	{
		global $post;
		return get_the_title($post);
	}
}
