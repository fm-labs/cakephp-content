<?php
namespace Content\View\Cell;

use Cake\Event\EventDispatcherInterface;
use Cake\Event\EventListenerInterface;
use Cake\Event\EventManager;
use Cake\Log\Log;
use Cake\Http\ServerRequest as Request;
use Cake\Http\Response;
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
     * @param \Cake\Http\ServerRequest $request The request to use in the cell.
     * @param \Cake\Http\Response $response The response to use in the cell.
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

        $this->getEventManager()->on($this);
    }

    public function render($template = null)
    {
        $this->viewBuilder()
            ->setClassName('Content.Content');

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

    public function implementedEvents(): array
    {
        return [];
    }
}
