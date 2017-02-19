<?php
namespace Content\View\Cell;

use Cake\View\Cell;
use Cake\Network\Request;
use Cake\Network\Response;
use Cake\Event\EventManager;
use Content\Model\Table\ContentModulesTable;

/**
 * Class SectionCell
 *
 * @package App\View\Cell
 *
 * @property ContentModulesTable $ContentModules
 */
class SectionCell extends Cell
{
    protected $_validCellOptions = ['section', 'refscope', 'refid'];

    public $section;

    public $refscope = 'Content.Pages';

    public $refid;

    protected $_layoutModules = [];

    protected $_pageModules = [];

    /**
     * Constructor.
     *
     * @param \Cake\Network\Request $request The request to use in the cell.
     * @param \Cake\Network\Response $response The response to use in the cell.
     * @param \Cake\Event\EventManager $eventManager The eventManager to bind events to.
     * @param array $cellOptions Cell options to apply.
     */
    public function __construct(
        Request $request = null,
        Response $response = null,
        EventManager $eventManager = null,
        array $cellOptions = []
    ) {
        parent::__construct($request, $response, $eventManager, $cellOptions);

    }

    public function display($tag = 'section', $attrs = [])
    {
        $this->loadModel('Content.ContentModules');

        $this->_loadPageModules();
        if (count($this->_pageModules) < 1) {
            $this->_loadLayoutModules();
        }

        $this->set('refscope', $this->refscope);
        $this->set('refid', $this->refid);
        $this->set('section', $this->section);
        $this->set('sectionTag', $tag);
        $this->set('sectionAttrs', $attrs);
        $this->set('layout_modules', $this->_layoutModules);
        $this->set('page_modules', $this->_pageModules);
    }

    protected function _loadPageModules()
    {
        if (!isset($this->refid)) {
            //debug("ContentModules skipped for section " . $this->section . ": No refid set");
            $this->_pageModules = [];
            return;
        }

        $this->_pageModules = $this->ContentModules->find()
            ->where(['section' => $this->section, 'refscope' => $this->refscope, 'refid' => $this->refid])
            ->contain(['Modules'])
            ->all();
    }

    protected function _loadLayoutModules()
    {
        $this->_layoutModules = $this->ContentModules->find()
            ->where(['section' => $this->section, 'refid IS NULL', 'or' => ['refscope' => $this->refscope, 'refscope IS NULL']])
            ->contain(['Modules'])
            ->all();
    }


}

