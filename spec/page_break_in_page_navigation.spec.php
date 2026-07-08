<?php

describe(LongReadPlugin\PageBreakInPageNavigation::class, function () {
	beforeEach(function () {
		$this->inPageNavigation = new \LongReadPlugin\PageBreakInPageNavigation();
	});

	it('implements the InPageNavigationInterface', function () {
		expect($this->inPageNavigation)->toBeAnInstanceOf(\LongReadPlugin\InPageNavigationInterface::class);
	});

	describe('->getItems()', function () {
		beforeEach(function () {
			global $post;
			$post = (object) ['post_content' => 'test content'];
			allow('get_query_var')->toBeCalled()->with('page', 1)->andReturn(1);
		});

		it('returns an empty array when there are no headings on the current page', function () {
			allow('parse_blocks')->toBeCalled()->andRun(function () {
				return [];
			});

			$result = $this->inPageNavigation->getItems();

			expect($result)->toEqual([]);
		});

		it('returns items for level 2 heading blocks', function () {
			$blocks = [
				[
					'blockName' => 'core/heading',
					'attrs' => ['level' => 2],
					'innerHTML' => '<h2 id="first" class="wp-block-heading">First heading</h2>'
				],
				[
					'blockName' => 'core/heading',
					'attrs' => ['level' => 2],
					'innerHTML' => '<h2 id="second" class="wp-block-heading">Second heading</h2>'
				],
			];
			allow('parse_blocks')->toBeCalled()->andRun(function () use ($blocks) {
				return $blocks;
			});

			$result = $this->inPageNavigation->getItems();

			expect(count($result))->toEqual(2);
			expect($result[0])->toBeAnInstanceOf(\LongReadPlugin\InPageNavigationItem::class);
			expect($result[0]->title)->toEqual('First heading');
			expect($result[0]->id)->toEqual('first');
			expect($result[1])->toBeAnInstanceOf(\LongReadPlugin\InPageNavigationItem::class);
			expect($result[1]->title)->toEqual('Second heading');
			expect($result[1]->id)->toEqual('second');
		});

		it('does not return headings with level other than 2', function () {
			$blocks = [
				[
					'blockName' => 'core/heading',
					'attrs' => ['level' => 1],
					'innerHTML' => '<h1 id="title" class="wp-block-heading">Title</h1>'
				],
				[
					'blockName' => 'core/heading',
					'attrs' => ['level' => 3],
					'innerHTML' => '<h3 id="subtitle" class="wp-block-heading">Subtitle</h3>'
				],
			];
			allow('parse_blocks')->toBeCalled()->andRun(function () use ($blocks) {
				return $blocks;
			});

			$result = $this->inPageNavigation->getItems();

			expect($result)->toEqual([]);
		});

		it('does not return empty heading blocks', function () {
			$blocks = [
				[
					'blockName' => 'core/heading',
					'attrs' => ['level' => 2],
					'innerHTML' => '<h2 class="wp-block-heading"></h2>'
				],
			];
			allow('parse_blocks')->toBeCalled()->andRun(function () use ($blocks) {
				return $blocks;
			});

			$result = $this->inPageNavigation->getItems();

			expect($result)->toEqual([]);
		});

		it('returns headings within group blocks', function () {
			$blocks = [
				[
					'blockName' => 'core/group',
					'innerBlocks' => [
						[
							'blockName' => 'core/heading',
							'attrs' => ['level' => 2],
							'innerHTML' => '<h2 id="grouped" class="wp-block-heading">Grouped heading</h2>'
						],
					]
				],
			];
			allow('parse_blocks')->toBeCalled()->andRun(function () use ($blocks) {
				return $blocks;
			});

			$result = $this->inPageNavigation->getItems();

			expect(count($result))->toEqual(1);
			expect($result[0])->toBeAnInstanceOf(\LongReadPlugin\InPageNavigationItem::class);
			expect($result[0]->title)->toEqual('Grouped heading');
			expect($result[0]->id)->toEqual('grouped');
		});

		it('returns headings within acf/group-block', function () {
			$blocks = [
				[
					'blockName' => 'acf/group-block',
					'innerBlocks' => [
						[
							'blockName' => 'core/heading',
							'attrs' => ['level' => 2],
							'innerHTML' => '<h2 id="acf-grouped" class="wp-block-heading">ACF grouped heading</h2>'
						],
					]
				],
			];
			allow('parse_blocks')->toBeCalled()->andRun(function () use ($blocks) {
				return $blocks;
			});

			$result = $this->inPageNavigation->getItems();

			expect(count($result))->toEqual(1);
			expect($result[0])->toBeAnInstanceOf(\LongReadPlugin\InPageNavigationItem::class);
			expect($result[0]->title)->toEqual('ACF grouped heading');
			expect($result[0]->id)->toEqual('acf-grouped');
		});
	});
});
