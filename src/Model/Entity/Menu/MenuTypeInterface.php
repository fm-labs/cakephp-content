<?php
declare(strict_types=1);

namespace Content\Model\Entity\Menu;

use Banana\Model\EntityTypeInterface;

/**
 * Interface TypeInterface
 *
 * @package Content\Model\Entity\Menu\Type
 */
interface MenuTypeInterface extends EntityTypeInterface
{
    /**
     * @return string
     */
    public function getLabel();

    /**
     * @return mixed
     */
    public function getUrl();

    /**
     * @return mixed
     */
    public function getPermaUrl();

    /**
     * @return bool
     */
    public function isVisibleInMenu();

    /**
     * @return bool
     */
    public function isVisibleInSitemap();

    /**
     * @param int $maxDepth Maximum number of nested menus (Default: 0)
     * @return \Banana\Menu\MenuItem
     */
    public function toMenuItem($maxDepth = 0);
}
