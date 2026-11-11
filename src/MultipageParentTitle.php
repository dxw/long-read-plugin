<?php

namespace LongReadPlugin;

final class MultipageParentTitle implements ParentTitleRetrieverInterface
{
	#[\Override]
	public function get(): ?string
	{
		global $post;
		$ancestors = get_post_ancestors($post);
		$topLevelAncestor = array_pop($ancestors);
		return $topLevelAncestor ? (get_the_title($topLevelAncestor) ?: null) : null;
	}
}
