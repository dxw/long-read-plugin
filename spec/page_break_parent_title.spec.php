<?php

describe(LongReadPlugin\PageBreakParentTitle::class, function () {
	beforeEach(function () {
		$this->parentTitleRetriever = new \LongReadPlugin\PageBreakParentTitle();
	});

	it('implements the ParentTitleRetrieverInterface', function () {
		expect($this->parentTitleRetriever)->toBeAnInstanceOf(\LongReadPlugin\ParentTitleRetrieverInterface::class);
	});

	describe('->get()', function () {
		it('returns the title of the parent post', function () {
			global $post;
			$post = (object) [
				'ID' => 123
			];

			allow('get_the_title')->toBeCalled()->andReturn('Current Post Title');
			expect('get_the_title')->toBeCalled()->with($post);

			$result = $this->parentTitleRetriever->get();

			expect($result)->toEqual('Current Post Title');
		});
	});
});