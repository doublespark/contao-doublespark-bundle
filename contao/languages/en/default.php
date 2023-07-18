<?php

use Doublespark\ContaoDoublesparkBundle\Elements\BannerImageElementController;
use Doublespark\ContaoDoublesparkBundle\Elements\ContentGridStartElementController;
use Doublespark\ContaoDoublesparkBundle\Elements\ContentGridEndElementController;

$GLOBALS['TL_LANG']['CTE'][BannerImageElementController::TYPE]      = ['Banner Image', 'A banner image with optional text overlay'];
$GLOBALS['TL_LANG']['CTE'][ContentGridStartElementController::TYPE] = ['Content grid start', 'Open a content grid'];
$GLOBALS['TL_LANG']['CTE'][ContentGridEndElementController::TYPE]   = ['Content grid end', 'Close a content grid'];

$GLOBALS['TL_LANG']['CTE']['layout'] = 'Layout elements';