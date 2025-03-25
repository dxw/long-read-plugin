<?php

describe(\LongReadPlugin\Template::class, function () {
	beforeEach(function () {
		$this->template = new \LongReadPlugin\Template();
	});

	it('is registerable', function () {
		expect($this->template)->toBeAnInstanceOf(\Dxw\Iguana\Registerable::class);
	});

	describe('->register()', function () {
		it('adds the filter', function () {
			allow('add_filter')->toBeCalled();
			expect('add_filter')->toBeCalled()->once();
			expect('add_filter')->toBeCalled()->once()->with('single_template', [$this->template, 'useDefault'], 99);

			$this->template->register();
		});
	});

	describe('->useDefault()', function () {
		context('the post type is not long-read', function () {
			it('returns the input', function () {
				global $post;
				$post = (object) [
					'post_type' => 'post'
				];

				$result = $this->template->useDefault('standard-post-template');

				expect($result)->toEqual('standard-post-template');
			});
		});

		context('ACF is not activated', function () {
			it('returns the input', function () {
				global $post;
				$post = (object) [
					'post_type' => 'long-read'
				];
				allow('function_exists')->toBeCalled()->andReturn(false);

				$result = $this->template->useDefault('standard-post-template');

				expect($result)->toEqual('standard-post-template');
			});
		});

		context('the option to use the plugin default template is not checked', function () {
			it('returns the input', function () {
				global $post;
				$post = (object) [
					'post_type' => 'long-read'
				];
				allow('function_exists')->toBeCalled()->andReturn(true);
				allow('get_field')->toBeCalled()->andReturn(false);

				$result = $this->template->useDefault('standard-post-template');

				expect($result)->toEqual('standard-post-template');
			});
		});

		context('the option to use the plugin default template is checked', function () {
			context('but the template file does not exist', function () {
				it('returns the input', function () {
					global $post;
					$post = (object) [
						'post_type' => 'long-read'
					];
					allow('function_exists')->toBeCalled()->andReturn(true);
					allow('get_field')->toBeCalled()->andReturn(1);
					allow('file_exists')->toBeCalled()->andReturn(false);
					allow('plugin_dir_path')->toBeCalled()->andReturn('the/plugin/path');
					allow('dirname')->toBeCalled()->andReturn('the/plugin');

					$result = $this->template->useDefault('standard-post-template');

					expect($result)->toEqual('standard-post-template');
				});
			});

			it('returns the path to the plugin template', function () {
				global $post;
				$post = (object) [
					'post_type' => 'long-read'
				];
				allow('function_exists')->toBeCalled()->andReturn(true);
				allow('get_field')->toBeCalled()->andReturn(1);
				allow('file_exists')->toBeCalled()->andReturn(true);
				allow('plugin_dir_path')->toBeCalled()->andReturn('the/plugin/path');
				allow('dirname')->toBeCalled()->andReturn('the/plugin');

				$result = $this->template->useDefault('standard-post-template');

				expect($result)->toEqual('the/plugin/template/' . \LongReadPlugin\Template::TEMPLATE_FILE);
			});
		});
	});
});
