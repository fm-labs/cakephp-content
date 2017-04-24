<?php
namespace Content\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ContentModulesFixture
 *
 */
class ContentModulesFixture extends TestFixture
{

    /**
     * Table name
     *
     * @var string
     */
    public $table = 'bc_content_modules';

    /**
     * Import
     *
     * @var array
     */
    public $import = ['table' => 'bc_content_modules'];

    /**
     * Records
     *
     * @var array
     */
    public $records = [
        [
            'id' => 3,
            'refscope' => 'Content.Pages',
            'refid' => 2,
            'module_id' => 3,
            'section' => 'before',
            'template' => '',
            'priority' => 0,
            'cssclass' => null,
            'cssid' => null
        ],
    ];
}
