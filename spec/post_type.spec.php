<?php

use Kahlan\Arg;

describe(\LongReadPlugin\PostType::class, function () {
	beforeEach(function () {
		$this->postType = new \LongReadPlugin\PostType();
	});

	it('is registerable', function () {
		expect($this->postType)->toBeAnInstanceOf(\Dxw\Iguana\Registerable::class);
	});

	describe('->register()', function () {
		it('adds the action and filter', function () {
			allow('add_action')->toBeCalled();
			expect('add_action')->toBeCalled()->once();
			expect('add_action')->toBeCalled()->once()->with('init', [$this->postType, 'registerPostType']);
			allow('add_filter')->toBeCalled();
			expect('add_filter')->toBeCalled()->times(2);
			expect('add_filter')->toBeCalled()->once()->with('use_block_editor_for_post_type', [$this->postType, 'enforceBlockEditor'], 1000, 2);
			expect('add_filter')->toBeCalled()->once()->with('get_user_option_classic-editor-settings', [$this->postType, 'overrideUserEditorSelection'], 10, 1);
			$this->postType->register();
		});
	});

	describe('->registerPostType()', function () {
		it('registers the post type', function () {
			allow('register_post_type')->toBeCalled();
			expect('register_post_type')->toBeCalled()->once()->with(Arg::toBeA('string'), Arg::toBeAn('array'));
			$this->postType->registerPostType();
		});
	});

	describe('->enforceBlockEditor()', function () {
		context('post type is not long-read', function () {
			it('returns the input value', function () {
				$result = $this->postType->enforceBlockEditor(false, 'post');
				expect($result)->toBeA('bool');
				expect($result)->toEqual(false);
			});
		});
		context('post type is long-read', function () {
			it('returns true', function () {
				$result = $this->postType->enforceBlockEditor(false, 'long-read');
				expect($result)->toBeA('boolean');
				expect($result)->toEqual(true);
			});
		});
	});

	describe('->overrideUserEditorSelection()', function () {
		context('the post_type parameter is not set', function () {
			it('returns the input', function () {
				global $_GET;
				$_GET = [];

				$result = $this->postType->overrideUserEditorSelection('foo');

				expect($result)->toEqual('foo');
			});
		});

		context('the post_type parameter is set to something other than long-read', function () {
			it('returns the input', function () {
				global $_GET;
				$_GET = [
					'post_type' => 'post'
				];

				$result = $this->postType->overrideUserEditorSelection('foo');

				expect($result)->toEqual('foo');
			});
		});

		context('the post_type parameter is set to long-read', function () {
			it('returns "block"', function () {
				global $_GET;
				$_GET = [
					'post_type' => 'long-read'
				];

				$result = $this->postType->overrideUserEditorSelection('foo');

				expect($result)->toEqual('block');
			});
		});
	});
});
