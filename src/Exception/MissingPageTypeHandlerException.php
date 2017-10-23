<?php

namespace Content\Exception;

use Cake\Core\Exception\Exception;

class MissingPageTypeHandlerException extends Exception
{
    protected $_messageTemplate = "No type handler for '%s' registered";
}