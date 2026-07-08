<?php

describe(\LongReadPlugin\ParentTitleRetrieverInterface::class, function () {
	it('defines a get method', function () {
		$reflection = new ReflectionClass(\LongReadPlugin\ParentTitleRetrieverInterface::class);
		expect($reflection->hasMethod('get'))->toEqual(true);
	});

	it('specifies get returns a nullable string', function () {
		$reflection = new ReflectionClass(\LongReadPlugin\ParentTitleRetrieverInterface::class);
		$method = $reflection->getMethod('get');
		$returnType = $method->getReturnType();

		expect($returnType)->not->toBeNull();
		expect($returnType->allowsNull())->toEqual(true);
	});
});
