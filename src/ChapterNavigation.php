<?php

namespace LongReadPlugin ;

class ChapterNavigation
{
	public function getItems(): array
	{
		$postStatus = ['publish'];
		if(current_user_can('edit_posts')) {
			array_push($postStatus, 'draft');
		}
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
