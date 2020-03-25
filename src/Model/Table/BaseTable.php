<?php
declare(strict_types=1);

namespace Content\Model\Table;

use Cake\ORM\Table;

abstract class BaseTable extends Table
{
    public static $tablePrefix = "content_";

    public function setTable($name)
    {
        return parent::setTable(self::$tablePrefix . $name);
    }
}
