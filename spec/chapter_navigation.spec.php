<?php

use Kahlan\Arg;

describe(\LongReadPlugin\ChapterNavigation::class, function () {
	beforeEach(function () {
		$this->chapterNavigation = new \LongReadPlugin\ChapterNavigation();
	});

	describe('->getItems()', function () {
		context('global post is the parent long-read post', function () {
			it('returns an array of items with the first item as the current post, which will have a null url property', function () {
				global $post;
				$post = (object) [
					'ID' => 123,
					'post_title' => 'Chapter One'
				];
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
				expect('get_posts')->toBeCalled()->once()->with([
					'post_parent' => 123,
					'post_type' => 'long-read',
					'posts_per_page' => -1,
					'orderby' => 'menu_order',
					'order' => 'ASC'
				]);
				allow('get_permalink')->toBeCalled()->andReturn('http://chapter-two-link', 'http://chapter-three-link');

				$result = $this->chapterNavigation->getItems();

				expect(count($result))->toEqual(3);
				expect($result[0]->title)->toEqual('Chapter One');
				expect($result[0]->url)->toEqual(null);
				expect($result[1]->title)->toEqual('Chapter Two');
				expect($result[1]->url)->toEqual('http://chapter-two-link');
				expect($result[2]->title)->toEqual('Chapter Three');
				expect($result[2]->url)->toEqual('http://chapter-three-link');
			});
		});

		context('global post is a child long-read post', function () {
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
				allow('get_post_parent')->toBeCalled()->andReturn($parentPost);
				allow('get_posts')->toBeCalled()->andReturn([
					$post = (object) [
						'ID' => 456,
						'post_title' => 'Chapter Two'
					],
					(object) [
						'ID' => 789,
						'post_title' => 'Chapter Three'
					]
				]);
				expect('get_posts')->toBeCalled()->once()->with([
					'post_parent' => 123,
					'post_type' => 'long-read',
					'posts_per_page' => -1,
					'orderby' => 'menu_order',
					'order' => 'ASC'
				]);
				allow('get_permalink')->toBeCalled()->andReturn('http://chapter-one-link', 'http://chapter-three-link');

				$result = $this->chapterNavigation->getItems();

				expect(count($result))->toEqual(3);
				expect($result[0]->title)->toEqual('Chapter One');
				expect($result[0]->url)->toEqual('http://chapter-one-link');
				expect($result[1]->title)->toEqual('Chapter Two');
				expect($result[1]->url)->toEqual(null);
				expect($result[2]->title)->toEqual('Chapter Three');
				expect($result[2]->url)->toEqual('http://chapter-three-link');
			});
		});
	});
});
