<?php

if (defined('DXW_PAGE_BREAK_LONG_READ') && DXW_PAGE_BREAK_LONG_READ === true) {
	$chapterNav = new \LongReadPlugin\PageBreakChapterNavigation();
	$inPageNav = new \LongReadPlugin\PageBreakInPageNavigation();
	$parentTitle = new \LongReadPlugin\PageBreakParentTitle();
} else {
	$chapterNav = new \LongReadPlugin\MultipageChapterNavigation();
	$inPageNav = new \LongReadPlugin\MultipageInPageNavigation();
	$parentTitle = new \LongReadPlugin\MultipageParentTitle();
}

$registrar->addInstance(new \LongReadPlugin\PostType());
$registrar->addInstance(new \LongReadPlugin\HeadingAnchors());
$registrar->addInstance(new \LongReadPlugin\Navigation(
	$chapterNav,
	$inPageNav
));
$registrar->addInstance(new \LongReadPlugin\Options());
$registrar->addInstance(new \LongReadPlugin\Template());
$registrar->addInstance(new \LongReadPlugin\ParentTitle(
	$parentTitle
));
