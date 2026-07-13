<?php

describe('LongReadType', function() {
	beforeEach(function () {
		$this->type = new \LongReadPlugin\LongReadType();
	});

	context('when LONG_READ_TYPE is not defined', function() {
		it('should return the default type', function() {
			expect($this->type->returnType())->toBe('multipage');
		});
	});
	context('when LONG_READ_TYPE is defined', function() {
		it('should return the type defined by LONG_READ_TYPE', function() {
			define('LONG_READ_TYPE', 'hierarchical');
			$this->type = new \LongReadPlugin\LongReadType();
			expect($this->type->returnType())->toBe('hierarchical');
		});
	});
});
