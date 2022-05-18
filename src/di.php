<?php

$registrar->addInstance(new \LongReadPlugin\PostType());
$registrar->addInstance(new \LongReadPlugin\HeadingAnchors());
$registrar->addInstance(new \LongReadPlugin\Navigation(
    new LongReadPlugin\ChapterNavigation(),
    new LongReadPlugin\InPageNavigation()
));
$registrar->addInstance(new \LongReadPlugin\Options());
