<?php
namespace Content\View;

use Cake\Core\Configure;
use Cake\Log\Log;
use Cake\Network\Request;
use Cake\Network\Response;
use Cake\Event\EventManager;
use Cake\Utility\Inflector;
use Cake\View\Exception\MissingCellException;
use Cake\Core\Exception\Exception;
use Cake\View\View;
use Content\View\Helper\BreadcrumbsHelper;

/**
 * Class FrontendView
 *
 * @package App\View
 *
 * @property BreadcrumbsHelper $Breadcrumbs
 */
class ContentView extends View
{
    //use ModuleTrait;

    /**
     * @param Request $request
     * @param Response $response
     * @param EventManager $eventManager
     * @param array $viewOptions
     */
    public function __construct(
        Request $request = null,
        Response $response = null,
        EventManager $eventManager = null,
        array $viewOptions = []
    ) {
        parent::__construct($request, $response, $eventManager, $viewOptions);

    }

    public function initialize()
    {
        $this->loadHelper('Content.Breadcrumbs');
        $this->loadHelper('Content.Content');
        $this->loadHelper('Form', [
            'className' => 'Bootstrap\View\Helper\FormHelper',
        ]);
    }

    public function section($name, $cellData = [], $cellOptions = [])
    {
        // a view block with contents will be preferred
        $content = $this->fetch($name);
        if ($content) {
            return $content;
        }

        $cellOptions += [
            'section' => $name,
            'refscope' => $this->get('refscope'),
            'refid' => $this->get('refid'),
        ];

        return $this->cell('Content.Section', $cellData, $cellOptions);
    }

    public function render($view = null, $layout = null)
    {
        return parent::render($view, $layout);
    }

}
