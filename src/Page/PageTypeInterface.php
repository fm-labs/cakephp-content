<?php

namespace Content\Page;

use Banana\Model\EntityTypeInterface;
use Cake\Controller\Controller;
use Content\Model\Entity\Page;

interface PageTypeInterface extends EntityTypeInterface
{
    public function getUrl();
    public function getAdminUrl();
    public function getChildren();
    public function isPublished();
    public function isHiddenInNav();

    public function execute(Controller &$controller);
}
