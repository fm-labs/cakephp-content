<?php
namespace Content\View\Cell;

use Cake\Event\EventDispatcherInterface;
use Cake\Event\EventListenerInterface;
use Cake\Event\EventManager;
use Cake\Log\Log;
use Cake\Network\Request;
use Cake\Network\Response;
use Cake\View\Cell;

abstract class ModuleCell extends Cell implements EventListenerInterface
{
    public static $defaultParams = [];

    public $section;

    public $refscope;

    public $refid;

    public $module;

    public $params = [];

    protected $_validCellOptions = ['module', 'params', 'section', 'refscope', 'refid'];

    public static function defaults()
    {
        return static::$defaultParams;
    }

    public static function inputs()
    {
        $inputs = [];
        array_walk(static::$defaultParams, function ($val, $idx) use (&$inputs) {
            $inputs[$idx] = ['default' => $val];
        });
        return $inputs;
    }

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

        $this->params = ($this->module)
            ? array_merge(static::$defaultParams, $this->params, $this->module->params_arr)
            : array_merge(static::$defaultParams, $this->params);

        $this->eventManager()->on($this);

    }

    public function render($template = null)
    {
        $this->viewBuilder()
            ->className('Content.Content');

        try {
            $rendered = parent::render($template);
            return $rendered;
        } catch (\Exception $ex) {
            Log::error('ModuleCell: ' . get_class($this) . ': ' . $ex->getMessage());
            throw $ex;
        }
    }

    public function display()
    {
        $this->set('params', $this->params);
        //$this->set('module', $this->module);
    }

    public function implementedEvents()
    {
        return [];
    }
}