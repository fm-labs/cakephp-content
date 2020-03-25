<?php
declare(strict_types=1);

namespace Content\Model\Entity\Menu;

class LinkType extends BaseType
{
    protected $_defaultConfig = [
        'title' => null,
        'link_url' => null,
    ];

    /**
     * {@inheritDoc}
     */
    public function getLabel()
    {
        return $this->getConfig('title');
    }

    /**
     * {@inheritDoc}
     */
    public function getUrl()
    {
        return $this->getConfig('link_url');
    }

    /**
     * @return mixed
     */
    public function getPermaUrl()
    {
        return false;
    }

    /**
     * @return bool
     */
    public function isVisibleInMenu()
    {
        return true;
    }

    /**
     * @return bool
     */
    public function isVisibleInSitemap()
    {
        return true;
    }
}
