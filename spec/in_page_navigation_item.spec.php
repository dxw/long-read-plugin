<?php

describe(\LongReadPlugin\InPageNavigationItem::class, function () {
	describe('constructor', function () {
		it('assigns title and id properties', function () {
			$item = new \LongReadPlugin\InPageNavigationItem(
				title: 'Section One',
				id: 'section-one'
			);

			expect($item->title)->toEqual('Section One');
			expect($item->id)->toEqual('section-one');
		});
	});

	describe('properties', function () {
		it('title is a string', function () {
			$item = new \LongReadPlugin\InPageNavigationItem(
				title: 'Test Section',
				id: 'test-id'
			);

			expect(is_string($item->title))->toEqual(true);
		});

		it('id is a string', function () {
			$item = new \LongReadPlugin\InPageNavigationItem(
				title: 'Test Section',
				id: 'heading-id-123'
			);

			expect(is_string($item->id))->toEqual(true);
		});

		it('both properties are readonly', function () {
			$item = new \LongReadPlugin\InPageNavigationItem(
				title: 'Original Title',
				id: 'original-id'
			);

			// Attempting to set readonly properties should raise an error
			$attemptModifyTitle = function () use ($item) {
				$item->title = 'Modified Title';
			};
			$attemptModifyId = function () use ($item) {
				$item->id = 'modified-id';
			};

			expect($attemptModifyTitle)->toThrow();
			expect($attemptModifyId)->toThrow();
		});
	});

	describe('nullable values', function () {
		it('id can be null', function () {
			$item = new \LongReadPlugin\InPageNavigationItem(
				title: 'Section',
				id: null
			);

			expect($item->id)->toBeNull();
		});

		it('id can be an empty string', function () {
			$item = new \LongReadPlugin\InPageNavigationItem(
				title: 'Section',
				id: ''
			);

			expect($item->id)->toEqual('');
		});

		it('title must not be null', function () {
			$attemptNullTitle = function () {
				new \LongReadPlugin\InPageNavigationItem(
					title: null,
					id: 'section-id'
				);
			};

			expect($attemptNullTitle)->toThrow();
		});
	});
});
