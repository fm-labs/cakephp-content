<?php
namespace Content\Page;

use Cake\Datasource\EntityInterface;

class RootPageType extends AbstractPageType
{
    public function getUrl()
    {
        return '/';
    }
}