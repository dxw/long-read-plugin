<?php

describe(\LongReadPlugin\ParentTitle::class, function () {
	describe('::get()', function () {
		it('calls the getter instance method and returns its result', function () {
			$mockGetter = new class implements \LongReadPlugin\ParentTitleRetrieverInterface {
				public function get(): ?string {
					return 'Parent Title';
				}
			};

			new \LongReadPlugin\ParentTitle($mockGetter);
			$result = \LongReadPlugin\ParentTitle::get();

			expect($result)->toEqual('Parent Title');
		});

		it('returns null when getter returns null', function () {
			$mockGetter = new class implements \LongReadPlugin\ParentTitleRetrieverInterface {
				public function get(): ?string {
					return null;
				}
			};

			new \LongReadPlugin\ParentTitle($mockGetter);
			$result = \LongReadPlugin\ParentTitle::get();

			expect($result)->toBeNull();
		});
	});
});
