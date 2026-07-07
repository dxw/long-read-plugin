<?php

use Kahlan\Plugin\Double;

describe(\LongReadPlugin\ParentTitle::class, function () {
    describe('->get()', function () {
        it('calls the getter instance method and returns its result', function () {
            $mockGetter = Double::instance([
                'implements' => \LongReadPlugin\ParentTitleGetter::class
            ]);
            allow($mockGetter)->toReceive('get')->andReturn('Parent Title');

            $parentTitle = new \LongReadPlugin\ParentTitle($mockGetter);
            $result = $parentTitle->get();

            expect($result)->toEqual('Parent Title');
        });

        it('returns null when getter returns null', function () {
            $mockGetter = Double::instance([
                'implements' => \LongReadPlugin\ParentTitleGetter::class
            ]);
            allow($mockGetter)->toReceive('get')->andReturn(null);

            $parentTitle = new \LongReadPlugin\ParentTitle($mockGetter);
            $result = $parentTitle->get();

            expect($result)->toBeNull();
        });
    });
});