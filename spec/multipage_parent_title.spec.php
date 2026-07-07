<?php

describe(\LongReadPlugin\MultipageParentTitle::class, function () {
	describe('->get()', function () {
		it('returns null when post has no ancestors', function () {
			global $post;
			$post = (object) [
				'ID' => 123
			];

			allow('get_post_ancestors')->toBeCalled()->andReturn([]);

			$getter = new \LongReadPlugin\MultipageParentTitle();
			$result = $getter->get();

			expect($result)->toBeNull();
		});

		it('returns the top-level ancestor title', function () {
			global $post;
			$post = (object) [
				'ID' => 789
			];

			allow('get_post_ancestors')->toBeCalled()->andReturn([456, 123]);
			allow('get_the_title')->toBeCalled()->andReturn('Top Level Post');

			$getter = new \LongReadPlugin\MultipageParentTitle();
			$result = $getter->get();

			expect($result)->toEqual('Top Level Post');
		});

		it('returns null when get_the_title returns false', function () {
			global $post;
			$post = (object) [
				'ID' => 789
			];

			allow('get_post_ancestors')->toBeCalled()->andReturn([456, 123]);
			allow('get_the_title')->toBeCalled()->andReturn(false);

			$getter = new \LongReadPlugin\MultipageParentTitle();
			$result = $getter->get();

			expect($result)->toBeNull();
		});

		it('handles single-level hierarchy', function () {
			global $post;
			$post = (object) [
				'ID' => 456
			];

			allow('get_post_ancestors')->toBeCalled()->andReturn([123]);
			allow('get_the_title')->toBeCalled()->andReturn('Parent Post');

			$getter = new \LongReadPlugin\MultipageParentTitle();
			$result = $getter->get();

			expect($result)->toEqual('Parent Post');
		});
	});
});
