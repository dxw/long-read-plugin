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
});
