<?php

namespace LongReadPlugin ;

class ChapterNavigation
{
	public function getItems(): array
	{
		global $post;
		$potentialParent = get_post_parent($post);
		$parentPost = $potentialParent ? $potentialParent : $post;
		$chapterPosts = get_posts([
			'post_parent' => $parentPost->ID,
			'post_type' => 'long-read',
			'posts_per_page' => -1,
			'orderby' => 'menu_order',
			'order' => 'ASC'
		]);
		array_unshift($chapterPosts, $parentPost);
		$chapterNavigationItems = [];
		foreach ($chapterPosts as $chapterPost) {
			$chapterNavigationItems[] = (object) [
				'title' => $chapterPost->post_title,
				'url' => $chapterPost->ID == $post->ID ? null : get_permalink($chapterPost)
			];
		}
		return $chapterNavigationItems;
	}
}
