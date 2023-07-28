<?php

namespace Doublespark\ContaoDoublesparkBundle\Elements;

use Contao\CoreBundle\Controller\ContentElement\AbstractContentElementController;
use Contao\CoreBundle\DependencyInjection\Attribute\AsContentElement;
use Contao\ContentModel;
use Contao\CoreBundle\Image\Studio\Studio;
use Contao\CoreBundle\Twig\FragmentTemplate;
use Contao\Environment;
use Contao\StringUtil;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;

#[AsContentElement(BannerImageElementController::TYPE, category:'media')]
class BannerImageElementController extends AbstractContentElementController
{
    public const TYPE = 'ds_banner_image';

    /**
     * @param Studio $imageStudio
     * @param RequestStack $requestStack
     */
    public function __construct(private readonly Studio $imageStudio, protected RequestStack $requestStack){}

    /**
     * @param FragmentTemplate $template
     * @param ContentModel $model
     * @param Request $request
     * @return Response
     */
    protected function getResponse(FragmentTemplate $template, ContentModel $model, Request $request): Response
    {
        if(!$model->singleSRC)
        {
            return new Response('');
        }

        $figure = $this->imageStudio
            ->createFigureBuilder()
            ->fromUuid($model->singleSRC)
            ->setSize(StringUtil::deserialize($model->size))
            ->setMetadata($model->getOverwriteMetadata())
            ->buildIfResourceExists();

        // If we can't get the image, return empty string
        if(!$figure)
        {
            return new Response('');
        }

        $template->set('image', $figure);

        $arrImage = $figure->getImage()->getImg();

        $path = $arrImage['src'];

        if($this->isBackendScope($request))
        {
            return new Response('<img src="'.$path.'" />');
        }

        $arrStyles[$arrImage['height']] = '#bannerImg'.$model->id.'{height:'.$arrImage['height'].'px;}';

        $arrSources = $figure->getImage()->getSources();

        if(count($arrSources) > 0)
        {
            foreach($arrSources as $arrImage)
            {
                if(isset($arrImage['media']) && $arrImage['media'])
                {
                    $arrStyles[$arrImage['height']] = '@media'.$arrImage['media'].'{#bannerImg'.$model->id.'{height:'.$arrImage['height'].'px;}}';
                }
            }
        }

        $GLOBALS['TL_HEAD'][] = '<style>'.implode('',$arrStyles).'</style>';

        $arrModel = $model->row();

        $template->set('addText', $arrModel['ds_addText'] ?? false);
        $template->set('text', $arrModel['text'] ?? '');

        // Add OG tag for image
        $useOgTag = $arrModel['ds_useOpenGraphImgTag'] ?? false;

        if($useOgTag && !isset($GLOBALS['TL_HEAD']['ogImage']))
        {
            $GLOBALS['TL_HEAD']['ogImage'] = '<meta property="og:image" content="'.Environment::get('url').'/'.$path.'"/>';
        }

        return $template->getResponse();
    }
}