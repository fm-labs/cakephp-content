<?php

namespace Content\Model\Table;

use Cake\ORM\Table;

abstract class BaseTable extends Table
{
    public static $tablePrefix = "content_";
}
