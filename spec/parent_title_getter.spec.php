<?php

describe(\LongReadPlugin\ParentTitleGetter::class, function () {
	it('defines a get method', function () {
		$reflection = new ReflectionClass(\LongReadPlugin\ParentTitleGetter::class);
		expect($reflection->hasMethod('get'))->toEqual(true);
	});

	it('specifies get returns a nullable string', function () {
		$reflection = new ReflectionClass(\LongReadPlugin\ParentTitleGetter::class);
		$method = $reflection->getMethod('get');
		$returnType = $method->getReturnType();

		expect($returnType)->not->toBeNull();
		expect($returnType->allowsNull())->toEqual(true);
	});
});
