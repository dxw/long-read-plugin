<?php

$registrar->addInstance(new \LongReadPlugin\PostType());
$registrar->addInstance(new \LongReadPlugin\HeadingAnchors());
$registrar->addInstance(new \LongReadPlugin\Navigation(
	new \LongReadPlugin\HierarchicalChapterNavigation(),
	new \LongReadPlugin\HierarchicalInPageNavigation()
));
$registrar->addInstance(new \LongReadPlugin\Options());
$registrar->addInstance(new \LongReadPlugin\Template());
$registrar->addInstance(new \LongReadPlugin\ParentTitle(
	new \LongReadPlugin\MultipageParentTitle()
));
