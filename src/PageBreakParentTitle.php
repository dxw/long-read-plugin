<?php

namespace LongReadPlugin;

final class PageBreakParentTitle implements ParentTitleRetrieverInterface
{
	#[\Override]
	public function get(): string
	{
		global $post;
		return get_the_title($post);
	}
}
