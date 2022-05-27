<?php

namespace LongReadPlugin;

describe(HeadingAnchors::class, function () {
    beforeEach(function () {
        $this->headingAnchors = new HeadingAnchors();
    });

    it('is registrable', function () {
        expect($this->headingAnchors)->toBeAnInstanceOf(\Dxw\Iguana\Registerable::class);
    });

    describe('->register()', function () {
        it('adds the filter', function () {
            allow('add_filter')->toBeCalled();
            expect('add_filter')->toBeCalled()->once();
            expect('add_filter')->toBeCalled()->with('block_editor_settings_all', [$this->headingAnchors, 'enforceAnchors']);
            $this->headingAnchors->register();
        });
    });

    describe('->enforceAnchors', function () {
        it('sets __experimentalGenerateAnchors to true', function () {
            $settings = [];
            $result = $this->headingAnchors->enforceAnchors($settings);
            expect($result['__experimentalGenerateAnchors'])->toEqual(true);
            expect($result['generateAnchors'])->toEqual(true);
        });
    });
});
