<?php

describe(\LongReadPlugin\ParentTitle::class, function () {
	describe('::get()', function () {
		it('calls the getter instance method and returns its result', function () {
			$mockGetter = \Kahlan\Plugin\Double::instance([
				'implements' => \LongReadPlugin\ParentTitleRetrieverInterface::class
			]);
			allow($mockGetter)->toReceive('get')->andReturn('Parent Title');

			new \LongReadPlugin\ParentTitle($mockGetter);
			$result = \LongReadPlugin\ParentTitle::get();

			expect($result)->toEqual('Parent Title');
		});

		it('returns null when getter returns null', function () {
			$mockGetter = \Kahlan\Plugin\Double::instance([
				'implements' => \LongReadPlugin\ParentTitleRetrieverInterface::class
			]);
			allow($mockGetter)->toReceive('get')->andReturn(null);

			new \LongReadPlugin\ParentTitle($mockGetter);
			$result = \LongReadPlugin\ParentTitle::get();

			expect($result)->toBeNull();
		});
	});
});
