<?php
declare(strict_types=1);

namespace Content\Model\Entity\Page;

use Cake\Datasource\EntityInterface;

abstract class AbstractType implements TypeInterface
{
    /**
     * @var \Content\Model\Entity\Page
     */
    protected $page;

    public function __construct(EntityInterface $entity)
    {
        $this->page = $entity;
    }
}
