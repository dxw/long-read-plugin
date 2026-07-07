<?php

namespace LongReadPlugin ;

class ChapterNavigation
{
	public function getItems(): array
	{
		$postStatus = apply_filters('long_read_plugin_post_status', ['publish']);

		global $post;
		$potentialParent = get_post_parent($post);
		$parentPost = $potentialParent ? $potentialParent : $post;
		$chapterPosts = get_posts([
			'post_parent' => $parentPost->ID,
			'post_status' => $postStatus,
			'post_type' => 'any',
			'posts_per_page' => -1,
			'orderby' => 'menu_order',
			'order' => 'ASC'
		]);
		array_unshift($chapterPosts, $parentPost);
		$currentPostId = $post->ID;
		$chapterNavigationItems = [];
		foreach ($chapterPosts as $chapterPost) {
			$chapterNavigationItems[] = new ChapterNavigationItem(
				$chapterPost->post_title,
				apply_filters('long_read_plugin_chapter_url', $chapterPost->ID == $currentPostId ? null : get_permalink($chapterPost), $chapterPost->ID)
			);
		}
		return $chapterNavigationItems;
	}
}
