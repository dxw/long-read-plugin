<?php

describe(\LongReadPlugin\MultipageChapterNavigation::class, function () {
	beforeEach(function () {
		$this->chapterNavigation = new \LongReadPlugin\MultipageChapterNavigation();
	});

	describe('->getItems()', function () {
		context('global post is a parent post', function () {
			it('returns an array of items with the first item as the current post, which will have a null url property', function () {
				global $post;
				$post = (object) [
					'ID' => 123,
					'post_title' => 'Chapter One'
				];
				$chapterUrlCallArgs = [];
				allow('apply_filters')->toBeCalled()->andRun(function (string $filterName, $value, $chapterPostId = null) use (&$chapterUrlCallArgs) {
					if ($filterName === 'long_read_plugin_post_status') {
						return ['publish'];
					}

					if ($filterName === 'long_read_plugin_chapter_url') {
						$chapterUrlCallArgs[] = $chapterPostId;
					}

					return $value;
				});
				allow('get_post_parent')->toBeCalled()->andReturn(false);
				allow('get_posts')->toBeCalled()->andReturn([
					(object) [
						'ID' => 456,
						'post_title' => 'Chapter Two'
					],
					(object) [
						'ID' => 789,
						'post_title' => 'Chapter Three'
					],
				]);
				expect('apply_filters')->toBeCalled()->once()->with('long_read_plugin_post_status', ['publish']);
				expect('get_posts')->toBeCalled()->once()->with([
					'post_parent' => 123,
					'post_status' => ['publish'],
					'post_type' => 'any',
					'posts_per_page' => -1,
					'orderby' => 'menu_order',
					'order' => 'ASC'
				]);
				allow('get_permalink')->toBeCalled()->andReturn('http://chapter-two-link', 'http://chapter-three-link');

				$result = $this->chapterNavigation->getItems();
				expect($chapterUrlCallArgs[0])->toEqual(123);
				expect($chapterUrlCallArgs[1])->toEqual(456);
				expect($chapterUrlCallArgs[2])->toEqual(789);

				expect(count($result))->toEqual(3);
				expect($result[0])->toBeAnInstanceOf(\LongReadPlugin\ChapterNavigationItem::class);
				expect($result[0]->title)->toEqual('Chapter One');
				expect($result[0]->url)->toEqual(null);
				expect($result[1])->toBeAnInstanceOf(\LongReadPlugin\ChapterNavigationItem::class);
				expect($result[1]->title)->toEqual('Chapter Two');
				expect($result[1]->url)->toEqual('http://chapter-two-link');
				expect($result[2])->toBeAnInstanceOf(\LongReadPlugin\ChapterNavigationItem::class);
				expect($result[2]->title)->toEqual('Chapter Three');
				expect($result[2]->url)->toEqual('http://chapter-three-link');
			});
		});

		context('global post is a child post', function () {
			it('returns an array of items with the current post in the appropriate place, and with a null url property', function () {
				global $post;
				$post = (object) [
					'ID' => 456,
					'post_title' => 'Chapter Two'
				];
				$parentPost = (object) [
					'ID' => 123,
					'post_title' => 'Chapter One'
				];
				$chapterUrlCallArgs = [];
				allow('apply_filters')->toBeCalled()->andRun(function (string $filterName, $value, $chapterPostId = null) use (&$chapterUrlCallArgs) {
					if ($filterName === 'long_read_plugin_post_status') {
						return ['publish'];
					}

					if ($filterName === 'long_read_plugin_chapter_url') {
						$chapterUrlCallArgs[] = $chapterPostId;
					}

					return $value;
				});
				allow('get_post_parent')->toBeCalled()->andReturn($parentPost);
				allow('get_posts')->toBeCalled()->andReturn([
					(object) [
						'ID' => 456,
						'post_title' => 'Chapter Two'
					],
					(object) [
						'ID' => 789,
						'post_title' => 'Chapter Three'
					]
				]);
				expect('apply_filters')->toBeCalled()->once()->with('long_read_plugin_post_status', ['publish']);
				expect('get_posts')->toBeCalled()->once()->with([
					'post_parent' => 123,
					'post_status' => ['publish'],
					'post_type' => 'any',
					'posts_per_page' => -1,
					'orderby' => 'menu_order',
					'order' => 'ASC'
				]);
				allow('get_permalink')->toBeCalled()->andReturn('http://chapter-one-link', 'http://chapter-three-link');

				$result = $this->chapterNavigation->getItems();
				expect($chapterUrlCallArgs[0])->toEqual(123);
				expect($chapterUrlCallArgs[1])->toEqual(456);
				expect($chapterUrlCallArgs[2])->toEqual(789);

				expect(count($result))->toEqual(3);
				expect($result[0])->toBeAnInstanceOf(\LongReadPlugin\ChapterNavigationItem::class);
				expect($result[0]->title)->toEqual('Chapter One');
				expect($result[0]->url)->toEqual('http://chapter-one-link');
				expect($result[1])->toBeAnInstanceOf(\LongReadPlugin\ChapterNavigationItem::class);
				expect($result[1]->title)->toEqual('Chapter Two');
				expect($result[1]->url)->toEqual(null);
				expect($result[2])->toBeAnInstanceOf(\LongReadPlugin\ChapterNavigationItem::class);
				expect($result[2]->title)->toEqual('Chapter Three');
				expect($result[2]->url)->toEqual('http://chapter-three-link');
			});
		});

		context('when long read post status filter includes drafts', function () {
			it('queries with filtered post statuses and returns those posts', function () {
				global $post;
				$post = (object) [
					'ID' => 1011,
					'post_title' => 'Chapter Four'
				];
				$parentPost = (object) [
					'ID' => 123,
					'post_title' => 'Chapter One',
					'post_status' => 'publish'
				];
				allow('apply_filters')->toBeCalled()->andRun(function (string $filterName, $value) {
					if ($filterName === 'long_read_plugin_post_status') {
						return ['publish', 'draft'];
					}

					return $value;
				});
				allow('get_post_parent')->toBeCalled()->andReturn($parentPost);
				allow('get_posts')->toBeCalled()->andReturn([
					(object) [
						'ID' => 456,
						'post_title' => 'Chapter Two',
						'post_status' => 'publish'
					],
					(object) [
						'ID' => 789,
						'post_title' => 'Chapter Three',
						'post_status' => 'draft'
					]
				]);
				expect('apply_filters')->toBeCalled()->once()->with('long_read_plugin_post_status', ['publish']);
				expect('get_posts')->toBeCalled()->once()->with([
					'post_parent' => 123,
					'post_status' => ['publish', 'draft'],
					'post_type' => 'any',
					'posts_per_page' => -1,
					'orderby' => 'menu_order',
					'order' => 'ASC'
				]);
				allow('get_permalink')->toBeCalled();

				$result = $this->chapterNavigation->getItems();

				expect(count($result))->toEqual(3);
			});
		});

		context('when long read chapter URL filter changes an item URL', function () {
			it('returns the filtered chapter URL in the navigation item', function () {
				global $post;
				$post = (object) [
					'ID' => 123,
					'post_title' => 'Chapter One'
				];
				allow('apply_filters')->toBeCalled()->andRun(function (string $filterName, $value, $chapterPostId = null) {
					if ($filterName === 'long_read_plugin_post_status') {
						return ['publish'];
					}

					if (
						$filterName === 'long_read_plugin_chapter_url'
						&& $chapterPostId === 456
					) {
						return 'http://filtered-chapter-two-link';
					}

					return $value;
				});
				allow('get_post_parent')->toBeCalled()->andReturn(false);
				allow('get_posts')->toBeCalled()->andReturn([
					(object) [
						'ID' => 456,
						'post_title' => 'Chapter Two'
					]
				]);
				allow('get_permalink')->toBeCalled()->andReturn('http://chapter-two-link');

				$result = $this->chapterNavigation->getItems();

				expect($result[1]->url)->toEqual('http://filtered-chapter-two-link');
			});
		});
	});
});
