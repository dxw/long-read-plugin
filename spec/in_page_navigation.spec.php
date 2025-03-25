<?php

describe(LongReadPlugin\InPageNavigation::class, function () {
	beforeEach(function () {
		$this->inPageNavigation = new \LongReadPlugin\InPageNavigation();
	});

	describe('->getItems()', function () {
		it('does not return anything for non-heading blocks', function () {
			global $post;
			$post->post_content = 'Some content';
			$blocks = [
				[
					'blockName' => 'not-heading'
				],
				[
					'blockName' => 'also-not-heading'
				],
			];
			allow('parse_blocks')->toBeCalled()->andReturn($blocks);

			$result = $this->inPageNavigation->getItems();

			expect($result)->toEqual([]);
		});

		it('does not return anything for heading blocks not of level 2', function () {
			global $post;
			$post->post_content = 'Some content';
			$blocks = [
				[
					'blockName' => 'core/heading',
					'attrs' => [
						'level' => 3
					]
				],
				[
					'blockName' => 'core/heading',
					'attrs' => [
						'level' => 4
					]
				],
			];
			allow('parse_blocks')->toBeCalled()->andReturn($blocks);

			$result = $this->inPageNavigation->getItems();

			expect($result)->toEqual([]);
		});

		it('returns items for heading blocks with no level (as level 2 is the default)', function () {
			global $post;
			$post->post_content = 'Some content';
			$blocks = [
				[
					'blockName' => 'core/heading',
					'attrs' => [],
					'innerHTML' => '<h2 id="first-heading">First heading</h2>'
				],
				[
					'blockName' => 'core/heading',
					'attrs' => [],
					'innerHTML' => '<h2 id="second-heading">Second heading</h2>'
				],
			];
			allow('parse_blocks')->toBeCalled()->andReturn($blocks);

			$result = $this->inPageNavigation->getItems();

			expect(count($result))->toEqual(2);
			expect($result[0]->title)->toEqual("First heading");
			expect($result[0]->id)->toEqual('first-heading');
			expect($result[1]->title)->toEqual("Second heading");
			expect($result[1]->id)->toEqual('second-heading');
		});

		it('returns items for heading blocks within block-groups)', function () {
			global $post;
			$post->post_content = 'Some content';
			$blocks = [
				[
					'blockName' => 'core/group',
					'attrs' => [],
					'innerBlocks' => [
						[
							'blockName' => 'core/heading',
							'attrs' => [],
							'innerHTML' => '<h2 id="first-heading">First heading</h2>'
						],
					]
				]
			];
			allow('parse_blocks')->toBeCalled()->andReturn($blocks);

			$result = $this->inPageNavigation->getItems();

			expect(count($result))->toEqual(1);
			expect($result[0]->title)->toEqual("First heading");
			expect($result[0]->id)->toEqual('first-heading');
		});
	});
});
