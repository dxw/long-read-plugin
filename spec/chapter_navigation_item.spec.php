<?php

describe(\LongReadPlugin\ChapterNavigationItem::class, function () {
	describe('constructor', function () {
		it('assigns title and url properties', function () {
			$item = new \LongReadPlugin\ChapterNavigationItem(
				title: 'Chapter One',
				url: 'http://example.com/chapter-one'
			);

			expect($item->title)->toEqual('Chapter One');
			expect($item->url)->toEqual('http://example.com/chapter-one');
		});

		it('allows url to be null for current page', function () {
			$item = new \LongReadPlugin\ChapterNavigationItem(
				title: 'Current Chapter',
				url: null
			);

			expect($item->title)->toEqual('Current Chapter');
			expect($item->url)->toEqual(null);
		});
	});

	describe('properties', function () {
		it('title is a string', function () {
			$item = new \LongReadPlugin\ChapterNavigationItem(
				title: 'Test',
				url: 'http://example.com'
			);

			expect(is_string($item->title))->toEqual(true);
		});

		it('url is either a string or null', function () {
			$itemWithUrl = new \LongReadPlugin\ChapterNavigationItem(
				title: 'Test',
				url: 'http://example.com'
			);
			$itemWithoutUrl = new \LongReadPlugin\ChapterNavigationItem(
				title: 'Test',
				url: null
			);

			expect($itemWithUrl->url === null || is_string($itemWithUrl->url))->toEqual(true);
			expect($itemWithoutUrl->url === null || is_string($itemWithoutUrl->url))->toEqual(true);
		});
	});

	describe('nullable values', function () {
		it('url can be null', function () {
			$item = new \LongReadPlugin\ChapterNavigationItem(
				title: 'Chapter',
				url: null
			);

			expect($item->url)->toBeNull();
		});

		it('url can be an empty string', function () {
			$item = new \LongReadPlugin\ChapterNavigationItem(
				title: 'Chapter',
				url: ''
			);

			expect($item->url)->toEqual('');
		});

		it('title must not be null', function () {
			$attemptNullTitle = function () {
				new \LongReadPlugin\ChapterNavigationItem(
					title: null,
					url: 'http://example.com'
				);
			};

			expect($attemptNullTitle)->toThrow();
		});
	});
});
