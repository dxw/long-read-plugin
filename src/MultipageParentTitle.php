<?php

namespace LongReadPlugin;

class MultipageParentTitle implements ParentTitleGetter
{
	public function get(): string | null
	{
		global $post;
		$ancestors = get_post_ancestors($post);
		$topLevelAncestor = array_pop($ancestors);
		return $topLevelAncestor ? get_the_title($topLevelAncestor) ?: null : null;
	}
}
