<?php

describe(\LongReadPlugin\Options::class, function () {
    beforeEach(function () {
        $this->options = new \LongReadPlugin\Options();
    });

    it('is registerable', function () {
        expect($this->options)->toBeAnInstanceOf(\Dxw\Iguana\Registerable::class);
    });

    describe('->register()', function () {
        it('adds the action', function () {
            allow('add_action')->toBeCalled();
            expect('add_action')->toBeCalled()->times(2);
            expect('add_action')->toBeCalled()->once()->with('acf/init', [$this->options, 'addOptionsPage']);
            expect('add_action')->toBeCalled()->once()->with('acf/init', [$this->options, 'addOptions']);

            $this->options->register();
        });
    });

    describe('->addOptionsPage()', function () {
        context('ACF is not activated', function () {
            it('does nothing', function () {
                allow('function_exists')->toBeCalled()->andReturn(false);

                $this->options->addOptionsPage();
            });
        });

        context('ACF is activated', function () {
            it('adds the options page', function () {
                allow('function_exists')->toBeCalled()->andReturn(true);
                allow('acf_add_options_page')->toBeCalled();
                expect('acf_add_options_page')->toBeCalled()->once()->with(\Kahlan\Arg::toBeAn('array'));

                $this->options->addOptionsPage();
            });
        });
    });

    describe('->addOptions()', function () {
        context('ACF is not activated', function () {
            it('does nothing', function () {
                allow('function_exists')->toBeCalled()->andReturn(false);

                $this->options->addOptionsPage();
            });
        });

        context('ACF is activated', function () {
            it('adds the options page', function () {
                allow('function_exists')->toBeCalled()->andReturn(true);
                allow('acf_add_local_field_group')->toBeCalled();
                expect('acf_add_local_field_group')->toBeCalled()->once()->with(\Kahlan\Arg::toBeAn('array'));

                $this->options->addOptions();
            });
        });
    });
});
