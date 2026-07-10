<?php

namespace LongReadPlugin;

class PageBreakChapterNavigation implements ChapterNavigationInterface
{
	
	public function getPages(): array
	{
		global $post;
		$fullContent = apply_filters('the_content', $post->post_content);
		$pages = explode('<!--nextpage-->', $fullContent);
		return $pages;
	}

	public function getItems(): array
	{
		global $post;
		$chapterNavigationItems = [];
		$currentPage = max(1, (int) get_query_var('page', 1));
		$pages = $this->getPages();
		$permalink = get_permalink($post);
		$normalizedPermalink = rtrim((string) $permalink, '/');
		foreach ($pages as $pageIndex => $page) {
			$regexPattern = "~(<h([2-6]))(.*?>(.*)<\/h[2-6]>)~";
			preg_match_all($regexPattern, $page, $matches);
			if (empty($matches[0])) {
				continue;
			}

			$chapterPage = $pageIndex + 1;
			$chapterUrl = null;
			if ($chapterPage !== $currentPage) {
				$chapterUrl = $chapterPage === 1 ? $normalizedPermalink . '/' : $normalizedPermalink . '/' . $chapterPage . '/';
			}

			$chapterNavigationItems[] = new ChapterNavigationItem(
				trim(strip_tags($matches[0][0])),
				apply_filters('long_read_plugin_chapter_url', $chapterUrl, $post->ID)
			);
		}
		
		return $chapterNavigationItems;
	}
}