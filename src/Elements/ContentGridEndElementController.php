<?php

namespace Doublespark\ContaoDoublesparkBundle\Elements;

use Contao\BackendTemplate;
use Contao\ContentModel;
use Contao\CoreBundle\Controller\ContentElement\AbstractContentElementController;
use Contao\CoreBundle\DependencyInjection\Attribute\AsContentElement;
use Contao\CoreBundle\Twig\FragmentTemplate;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

#[AsContentElement(ContentGridEndElementController::TYPE, category:'layout',template:'content_element/ds_content_grid')]
class ContentGridEndElementController extends AbstractContentElementController
{
    public const TYPE = 'ds_content_grid_end';

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
            $objTemplate->wildcard = '### GRID END ###';
            $objTemplate->id = $model->id;
            $objTemplate->href = 'contao/main.php?do=themes&amp;table=tl_module&amp;act=edit&amp;id=' . $model->id;

            return $objTemplate->getResponse();
        }

        $template->set('type', $model->type);

        return $template->getResponse();
    }
}