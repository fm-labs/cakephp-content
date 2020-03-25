<?php
declare(strict_types=1);

namespace Content\View\Module;

use Banana\View\ViewModule;
use Banana\View\ViewModuleSchema;

/**
 * Class HtmlModule
 *
 * @package Content\View\Module
 */
class HtmlModule extends ViewModule
{
    public $modelClass = false;

    /**
     * @var string
     */
    public $htmlstr = "";

    protected $_validCellOptions = ['htmlstr'];

    protected function _buildSchema(ViewModuleSchema $schema)
    {
        $schema
            ->addField(
                'htmlstr',
                ['type' => 'text']
            );

        return $schema;
    }

    public static function inputs()
    {
        return ['htmlstr' => ['type' => 'htmleditor']];
    }

    public function display()
    {
        $this->set('htmlstr', $this->htmlstr);
    }
}
