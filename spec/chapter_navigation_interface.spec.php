<?php

describe(\LongReadPlugin\ChapterNavigationInterface::class, function () {
	it('defines a getItems method', function () {
		$reflection = new ReflectionClass(\LongReadPlugin\ChapterNavigationInterface::class);
		expect($reflection->hasMethod('getItems'))->toEqual(true);
	});

	it('specifies getItems returns an array', function () {
		$reflection = new ReflectionClass(\LongReadPlugin\ChapterNavigationInterface::class);
		$method = $reflection->getMethod('getItems');
		$returnType = $method->getReturnType();

		expect($returnType)->not->toBeNull();
		expect($returnType->getName())->toEqual('array');
	});
});
