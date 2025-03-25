<?php

describe(\LongReadPlugin\ParentTitle::class, function () {
	describe('::get', function () {
		context('there is no post parent', function () {
			it('returns null', function () {
				global $post;
				$post = new stdClass();
				allow('get_post_ancestors')->toBeCalled()->andReturn([]);
				$result = \LongReadPlugin\ParentTitle::get();
				expect($result)->toEqual(null);
			});
		});

		context('there is only one post ancestors', function () {
			it('returns the title of that parent', function () {
				global $post;
				$post = new stdClass();
				allow('get_post_ancestors')->toBeCalled()->andReturn([123]);
				allow('get_the_title')->toBeCalled()->andReturn('The parent title');
				expect('get_the_title')->toBeCalled()->once()->with(123);
				$result = \LongReadPlugin\ParentTitle::get();
				expect($result)->toEqual('The parent title');
			});
		});

		context('there is only multiple post ancestors', function () {
			it('returns the title of the top level post ancestor', function () {
				global $post;
				$post = new stdClass();
				allow('get_post_ancestors')->toBeCalled()->andReturn([123, 456, 789]);
				allow('get_the_title')->toBeCalled()->andReturn('The top ancestor title');
				expect('get_the_title')->toBeCalled()->once()->with(789);
				$result = \LongReadPlugin\ParentTitle::get();
				expect($result)->toEqual('The top ancestor title');
			});
		});
	});
});
