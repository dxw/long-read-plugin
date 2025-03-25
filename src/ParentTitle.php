<?php

namespace LongReadPlugin;

class ParentTitle
{
	/**
	* @return string|null
	*/
	public static function get()
	{
		global $post;
		$ancestors = get_post_ancestors($post);
		$topLevelAncestor = array_pop($ancestors);
		if ($topLevelAncestor) {
			return get_the_title($topLevelAncestor);
		}
	}
}
