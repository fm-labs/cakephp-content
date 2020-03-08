<?php
namespace Content\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ModulesFixture
 *
 */
class ModulesFixture extends TestFixture
{

    /**
     * Table name
     *
     * @var string
     */
    public $table = 'bc_modules';

    /**
     * Import
     *
     * @var array
     */
    public $import = ['table' => 'bc_modules'];

    /**
     * Records
     *
     * @var array
     */
    public $records = [
        [
            'id' => 3,
            'name' => 'Mod Slider Home',
            'title' => null,
            'path' => 'flexslider',
            'params' => '{"gallery_id":"2"}',
        ],
    ];
}
