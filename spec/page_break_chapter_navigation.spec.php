<?php

describe(\LongReadPlugin\PageBreakChapterNavigation::class, function () {
	beforeEach(function () {
		$this->navigation = new \LongReadPlugin\PageBreakChapterNavigation();
	});
	describe('::getItems()', function () {
		it('returns an array of chapter navigation items', function () {
			$item = new \LongReadPlugin\ChapterNavigationItem('Chapter 1', '/chapter-1');
			allow('apply_filters')->toBeCalled()->andReturn('Chapter 1', '/chapter-1');
			$result = $this->navigation->getItems();

			expect($result)->toEqual([$item]);
		});
	});
});