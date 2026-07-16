<?php

describe(\LongReadPlugin\PageBreakChapterNavigation::class, function () {
	beforeEach(function () {
		$this->navigation = new \LongReadPlugin\PageBreakChapterNavigation();
	});

	it('implements the ChapterNavigationInterface', function () {
		expect($this->navigation)->toBeAnInstanceOf(\LongReadPlugin\ChapterNavigationInterface::class);
	});

	describe('::getItems()', function () {
		beforeEach(function () {
			global $post;
			$post = (object) [
				'ID' => 123,
				'post_content' => '<h2>Chapter 1</h2><!--nextpage--><h2>Chapter 2</h2>'
			];

			allow('apply_filters')->toBeCalled()->andRun(function ($filterName, $value) {
				return $value;
			});
			allow('get_permalink')->toBeCalled()->andReturn('/long-read/');
			allow('is_preview')->toBeCalled()->andReturn(false);
		});

		it('returns an array of chapter navigation items', function () {
			$item = new \LongReadPlugin\ChapterNavigationItem('Chapter 1', null);
			allow('get_query_var')->toBeCalled()->with('page', 1)->andReturn(1);
			$result = $this->navigation->getItems();

			expect($result[0])->toEqual($item);
		});
		it('returns an empty array when no chapters are found', function () {
			global $post;
			$post->post_content = '';
			allow('get_query_var')->toBeCalled()->with('page', 1)->andReturn(1);
			$result = $this->navigation->getItems();

			expect($result)->toEqual([]);
		});
		it('returns an array with multiple chapters when multiple page breaks are found', function () {
			$chapter1 = new \LongReadPlugin\ChapterNavigationItem('Chapter 1', null);
			$chapter2 = new \LongReadPlugin\ChapterNavigationItem('Chapter 2', '/long-read/2/');
			allow('get_query_var')->toBeCalled()->with('page', 1)->andReturn(1);
			expect('apply_filters')->toBeCalled()->times(2);
			expect('apply_filters')->toBeCalled()->with('long_read_plugin_chapter_url', null, 123);
			expect('apply_filters')->toBeCalled()->with('long_read_plugin_chapter_url', '/long-read/2/', 123);
			$result = $this->navigation->getItems();

			expect($result)->toEqual([$chapter1, $chapter2]);
		});

		it('sets current chapter url to null', function () {
			allow('get_query_var')->toBeCalled()->with('page', 1)->andReturn(2);

			$result = $this->navigation->getItems();

			expect(count($result))->toEqual(2);
			expect($result[0]->url)->toEqual('/long-read/');
			expect($result[1]->url)->toBeNull();
		});

		context('view is a preview', function () {
			it('returns preview URLs', function () {
				$chapter1 = new \LongReadPlugin\ChapterNavigationItem('Chapter 1', null);
				$chapter2 = new \LongReadPlugin\ChapterNavigationItem('Chapter 2', 'http://localhost/preview/2');
				allow('get_query_var')->toBeCalled()->with('page', 1)->andReturn(1);
				allow('is_preview')->toBeCalled()->andReturn(true);
				allow('get_preview_post_link')->toBeCalled()->andRun(function ($postId, $args) {
					return 'http://localhost/preview/' . $args['page'];
				});

				$result = $this->navigation->getItems();
				expect($result)->toEqual([$chapter1, $chapter2]);
			});
			it('returns standard URLs if preview link is null', function () {
				$chapter1 = new \LongReadPlugin\ChapterNavigationItem('Chapter 1', null);
				$chapter2 = new \LongReadPlugin\ChapterNavigationItem('Chapter 2', '/long-read/2/');
				allow('get_query_var')->toBeCalled()->with('page', 1)->andReturn(1);
				allow('is_preview')->toBeCalled()->andReturn(true);
				allow('get_preview_post_link')->toBeCalled()->andReturn(null);

				$result = $this->navigation->getItems();
				expect($result)->toEqual([$chapter1, $chapter2]);
			});
		});
	});
});
