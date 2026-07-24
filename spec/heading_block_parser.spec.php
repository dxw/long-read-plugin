<?php

describe(\LongReadPlugin\HeadingBlockParser::class, function () {
	beforeEach(function () {
		$this->parser = new \LongReadPlugin\HeadingBlockParser();
	});

	describe('->parseHeading()', function () {
		it('parses heading title and id', function () {
			$item = $this->parser->parseHeading('<h2 id="first-heading">First heading</h2>');

			expect($item)->toBeAnInstanceOf(\LongReadPlugin\InPageNavigationItem::class);
			expect($item->title)->toEqual('First heading');
			expect($item->id)->toEqual('first-heading');
		});

		it('sets id to null when no id attribute exists', function () {
			$item = $this->parser->parseHeading('<h2>First heading</h2>');

			expect($item->title)->toEqual('First heading');
			expect($item->id)->toBeNull();
		});
	});

	describe('->collectHeadingItems()', function () {
		it('returns empty array when no level-2 headings exist', function () {
			$items = $this->parser->collectHeadingItems([
				[
					'blockName' => 'core/paragraph',
				],
				[
					'blockName' => 'core/heading',
					'attrs' => ['level' => 3],
					'innerHTML' => '<h3 id="h3">Heading 3</h3>'
				],
			]);

			expect($items)->toEqual([]);
		});

		it('collects level-2 headings including default level', function () {
			$items = $this->parser->collectHeadingItems([
				[
					'blockName' => 'core/heading',
					'attrs' => ['level' => 2],
					'innerHTML' => '<h2 id="explicit">Explicit heading</h2>'
				],
				[
					'blockName' => 'core/heading',
					'attrs' => [],
					'innerHTML' => '<h2 id="default">Default heading</h2>'
				],
			]);

			expect(count($items))->toEqual(2);
			expect($items[0]->title)->toEqual('Explicit heading');
			expect($items[0]->id)->toEqual('explicit');
			expect($items[1]->title)->toEqual('Default heading');
			expect($items[1]->id)->toEqual('default');
		});

		it('collects headings recursively from group blocks', function () {
			$items = $this->parser->collectHeadingItems([
				[
					'blockName' => 'core/group',
					'innerBlocks' => [
						[
							'blockName' => 'acf/group-block',
							'innerBlocks' => [
								[
									'blockName' => 'core/heading',
									'attrs' => ['level' => 2],
									'innerHTML' => '<h2 id="nested">Nested heading</h2>'
								]
							]
						]
					]
				]
			]);

			expect(count($items))->toEqual(1);
			expect($items[0]->title)->toEqual('Nested heading');
			expect($items[0]->id)->toEqual('nested');
		});

		it('ignores empty heading content', function () {
			$items = $this->parser->collectHeadingItems([
				[
					'blockName' => 'core/heading',
					'attrs' => ['level' => 2],
					'innerHTML' => '<h2 class="wp-block-heading"></h2>'
				],
			]);

			expect($items)->toEqual([]);
		});
	});
});
