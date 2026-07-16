<?php

use Kahlan\Plugin\Double;

describe(LongReadPlugin\Navigation::class, function () {
	beforeEach(function () {
	});

	describe('::getItems()', function () {
		it('returns an empty array if an instance of the class does not already exist', function () {
			$result = LongReadPlugin\Navigation::getItems();
			expect($result)->toEqual([]);
		});

		it('returns an array of items where the in page nav is mapped to the subItems property of the current post item in the chapter nav items', function () {
			$this->chapterNavigation = Double::instance(['extends' => '\LongReadPlugin\MultipageChapterNavigation']);
			$this->inPageNavigation = Double::instance(['extends' => '\LongReadPlugin\MultipageInPageNavigation']);
			allow($this->chapterNavigation)->toReceive('getItems')->andReturn([
				(object) [
					'title' => 'Chapter One',
					'url' => 'http://chapter-one'
				],
				(object) [
					'title' => 'Current Chapter',
					'url' => null
				],
				(object) [
					'title' => 'Chapter Three',
					'url' => 'http://chapter-three'
				]
			]);
			allow($this->inPageNavigation)->toReceive('getItems')->andReturn([
				(object) [
					'title' => 'Heading One',
					'id' => 'heading-one'
				],
				(object) [
					'title' => 'Heading Two',
					'id' => 'heading-two'
				]
			]);
			$navigation = new LongReadPlugin\Navigation(
				$this->chapterNavigation,
				$this->inPageNavigation
			);

			$result = LongReadPlugin\Navigation::getItems();

			expect(count($result))->toEqual(3);
			expect($result[0]->title)->toEqual('Chapter One');
			expect($result[0]->url)->toEqual('http://chapter-one');
			expect($result[1]->title)->toEqual('Current Chapter');
			expect(count($result[1]->subItems))->toEqual(2);
			expect($result[1]->subItems[0]->title)->toEqual('Heading One');
			expect($result[1]->subItems[0]->id)->toEqual('heading-one');
			expect($result[1]->subItems[1]->title)->toEqual('Heading Two');
			expect($result[1]->subItems[1]->id)->toEqual('heading-two');
			expect($result[2]->title)->toEqual('Chapter Three');
			expect($result[2]->url)->toEqual('http://chapter-three');
		});

		it('does not include in-page nav items where the first heading we found is being used as the page title', function () {
			$this->chapterNavigation = Double::instance(['extends' => '\LongReadPlugin\MultipageChapterNavigation']);
			$this->inPageNavigation = Double::instance(['extends' => '\LongReadPlugin\MultipageInPageNavigation']);
			allow($this->chapterNavigation)->toReceive('getItems')->andReturn([
				(object) [
					'title' => 'Chapter One',
					'url' => 'http://chapter-one'
				],
				(object) [
					'title' => 'Duplicate Heading',
					'url' => null
				],
				(object) [
					'title' => 'Chapter Three',
					'url' => 'http://chapter-three'
				]
			]);
			allow($this->inPageNavigation)->toReceive('getItems')->andReturn([
				(object) [
					'title' => 'Duplicate Heading',
					'id' => 'heading-one'
				],
				(object) [
					'title' => 'Heading Two',
					'id' => 'heading-two'
				]
			]);
			$navigation = new LongReadPlugin\Navigation(
				$this->chapterNavigation,
				$this->inPageNavigation
			);

			$result = LongReadPlugin\Navigation::getItems();

			expect(count($result))->toEqual(3);
			expect($result[0]->title)->toEqual('Chapter One');
			expect($result[0]->url)->toEqual('http://chapter-one');
			expect($result[1]->title)->toEqual('Duplicate Heading');
			expect(count($result[1]->subItems))->toEqual(1);
			expect($result[1]->subItems[1]->title)->toEqual('Heading Two');
			expect($result[1]->subItems[1]->id)->toEqual('heading-two');
			expect($result[2]->title)->toEqual('Chapter Three');
			expect($result[2]->url)->toEqual('http://chapter-three');
		});
	});
});
