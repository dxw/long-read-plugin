<?php

namespace LongReadPlugin;

class PageBreakChapterNavigation implements ChapterNavigationInterface
{
	private function getPages(): array
	{
		global $post;
		$fullContent = $post->post_content;
		$pages = explode('<!--nextpage-->', $fullContent);
		return $pages;
	}

	private function addNavigationItem(int $pageIndex, int $currentPage, string $page, string $permalink, int $postId): ?ChapterNavigationItem
	{

		$matches = [];
		preg_match('~<h([1-6])[^>]*>(.*?)</h\1>~is', $page, $matches);
		if (!isset($matches[0]) || !is_string($matches[0]) || trim($matches[0]) === '') {
			return null;
		}

		$chapterPage = $pageIndex + 1;
		$chapterUrl = null;
		if ($chapterPage !== $currentPage) {
			$chapterUrl = $chapterPage === 1 ? $permalink . '/' : $permalink . '/' . $chapterPage . '/';
			if (is_preview()) {
				$previewLink = get_preview_post_link($postId, ['page' => $chapterPage]);
				$chapterUrl = $previewLink ?? $chapterUrl;
			}
		}

		return new ChapterNavigationItem(
			trim(strip_tags($matches[0])),
			apply_filters('long_read_plugin_chapter_url', $chapterUrl, $postId)
		);
	}

	public function getItems(): array
	{
		global $post;
		$chapterNavigationItems = [];
		$currentPage = max(1, (int) get_query_var('page', 1));
		$pages = $this->getPages();
		$permalink = get_permalink($post);
		$whiteSpaceFreePermalink = rtrim((string) $permalink, '/');
		foreach ($pages as $pageIndex => $page) {
			$item = $this->addNavigationItem($pageIndex, $currentPage, $page, $whiteSpaceFreePermalink, $post->ID);
			if ($item) {
				$chapterNavigationItems[] = $item;
			}
		}

		return $chapterNavigationItems;
	}
}
