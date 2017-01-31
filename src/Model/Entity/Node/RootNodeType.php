<?php

namespace Content\Model\Entity\Node;


use Content\Model\Entity\Node;

/**
 * Class RootNodeType
 *
 * @package Content\Model\Entity\Node
 *
 */
class RootNodeType extends DefaultNodeType implements NodeTypeInterface
{
    /**
     * @return mixed
     */
    public function getViewUrl()
    {
        return '/';
    }

}