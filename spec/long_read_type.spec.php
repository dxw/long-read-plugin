<?php

describe('LongReadType', function() {
	beforeEach(function () {
		$this->type = new \LongReadPlugin\LongReadType();
	});

	context('when LONG_READ_TYPE is not defined', function () {
		it('returns an array of Multipage long read type classes', function () {
			expect($this->type->getClassNames())->toEqual([ 
				'ChapterNavigation' => '\LongReadPlugin\MultipageChapterNavigation', 
				'InPageNavigation' => '\LongReadPlugin\MultipageInPageNavigation', 
				'ParentTitle' => '\LongReadPlugin\MultipageParentTitle' ]);
		});
	});

	context('when PAGE_BREAK_LONG_READ_TYPE is defined', function () {
		beforeEach(function () {
			define('PAGE_BREAK_LONG_READ_TYPE', 'true');
		});

		it('returns an array of PageBreak long read type classes', function () {
			expect($this->type->getClassNames())->toEqual([ 
				'ChapterNavigation' => '\LongReadPlugin\PageBreakChapterNavigation', 
				'InPageNavigation' => '\LongReadPlugin\PageBreakInPageNavigation', 
				'ParentTitle' => '\LongReadPlugin\PageBreakParentTitle' ]);
		});
	});
});
