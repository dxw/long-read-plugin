<?php

namespace LongReadPlugin;

class PageBreakChapterNavigation implements ChapterNavigationInterface
{
	private function getPages(\WP_Post $post): array
	{
		$pages = explode('<!--nextpage-->', $post->post_content);
		return $pages;
	}

	private function getChapterTitle(string $page): ?string
	{
		$matches = [];
		preg_match('~<h([1-6])[^>]*>(.*?)</h\1>~is', $page, $matches);
		if (!isset($matches[0]) || !is_string($matches[0]) || trim($matches[0]) === '') {
			return null;
		}
		return trim(strip_tags($matches[0]));
	}

	private function getChapterUrl(int $pageIndex, int $currentPage, string $permalink, int $postId): ?string
	{
		$chapterPage = $pageIndex + 1;
		$chapterUrl = null;
		if ($chapterPage !== $currentPage) {
			$chapterUrl = $chapterPage === 1 ? $permalink . '/' : $permalink . '/' . $chapterPage . '/';
			if (is_preview()) {
				$previewLink = get_preview_post_link($postId, ['page' => $chapterPage]);
				$chapterUrl = $previewLink ?? $chapterUrl;
			}
		}
		return $chapterUrl;
	}

	private function createNavigationItem(int $pageIndex, int $currentPage, string $page, string $permalink, int $postId): ?ChapterNavigationItem
	{
		$title = $this->getChapterTitle($page);
		if ($title === null) {
			return null;
		}

		$url = $this->getChapterUrl($pageIndex, $currentPage, $permalink, $postId);

		return new ChapterNavigationItem(
			$title,
			apply_filters('long_read_plugin_chapter_url', $url, $postId)
		);
	}

	public function getItems(): array
	{
		global $post;
		$chapterNavigationItems = [];
		$currentPage = max(1, (int) get_query_var('page', 1));
		$pages = $this->getPages($post);
		$permalink = get_permalink($post);
		$whiteSpaceFreePermalink = rtrim((string) $permalink, '/');
		foreach ($pages as $pageIndex => $page) {
			$item = $this->createNavigationItem($pageIndex, $currentPage, $page, $whiteSpaceFreePermalink, $post->ID);
			if ($item) {
				$chapterNavigationItems[] = $item;
			}
		}

		return $chapterNavigationItems;
	}
}
