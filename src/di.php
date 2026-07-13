<?php

$longReadTypeClassNames = (new \LongReadPlugin\LongReadType())->getClassNames();

$registrar->addInstance(new \LongReadPlugin\PostType());
$registrar->addInstance(new \LongReadPlugin\HeadingAnchors());
$registrar->addInstance(new \LongReadPlugin\Navigation(
	new $longReadTypeClassNames['ChapterNavigation'](),
	new $longReadTypeClassNames['InPageNavigation']()
));
$registrar->addInstance(new \LongReadPlugin\Options());
$registrar->addInstance(new \LongReadPlugin\Template());
$registrar->addInstance(new \LongReadPlugin\ParentTitle(
	new $longReadTypeClassNames['ParentTitle']()
));
