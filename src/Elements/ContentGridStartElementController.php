<?php

namespace Doublespark\Doublespark\Elements;

use Contao\BackendTemplate;
use Contao\ContentModel;
use Contao\CoreBundle\Controller\ContentElement\AbstractContentElementController;
use Contao\CoreBundle\DependencyInjection\Attribute\AsContentElement;
use Contao\CoreBundle\Twig\FragmentTemplate;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

#[AsContentElement(ContentGridStartElementController::TYPE, category:'layout',template:'content_element/ds_content_grid')]
class ContentGridStartElementController extends AbstractContentElementController
{
    public const TYPE = 'ds_content_grid_start';

    /**
     * @param FragmentTemplate $template
     * @param ContentModel $model
     * @param Request $request
     * @return Response
     */
    protected function getResponse(FragmentTemplate $template, ContentModel $model, Request $request): Response
    {
        if($this->isBackendScope($request))
        {
            $objTemplate = new BackendTemplate('be_wildcard');
            $objTemplate->wildcard = '### GRID START ###';
            $objTemplate->id = $model->id;
            $objTemplate->href = 'contao/main.php?do=themes&amp;table=tl_module&amp;act=edit&amp;id=' . $model->id;

            return $objTemplate->getResponse();
        }

        $template->set('type', $model->type);
        $template->set('columns', $model->ds_gridColumns);

        return $template->getResponse();
    }
}