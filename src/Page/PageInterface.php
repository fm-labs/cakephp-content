<?php
/**
 * Created by PhpStorm.
 * User: flow
 * Date: 5/17/16
 * Time: 10:48 PM
 */

namespace Content\Page;


use Cake\Controller\Controller;
use Cake\Datasource\EntityInterface;

interface PageInterface
{
    //function getPageType(EntityInterface $entity);

    public function getPageId();
    public function getPageType();
    public function getPageTitle();
    public function getPageUrl();
    public function getPageAdminUrl();
    public function getPageChildren();
    public function isPagePublished();
    public function isPageHiddenInNav();
    public function execute(Controller &$controller);
}