<?php
namespace Content\Model\Entity;

use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;
use Content\Lib\ContentManager;
use Content\Menu\BaseMenuHandler;
use Content\Menu\MenuHandlerInterface;
use Content\Post\PostHandlerEntityTrait;

/**
 * MenuItem Entity.
 *
 * @property int $id
 * @property int $menu_id
 * @property \Content\Model\Entity\Menu $menu
 * @property int $lft
 * @property int $rght
 * @property int $level
 * @property int $parent_id
 * @property \Content\Model\Entity\ParentMenuItem $parent_menu_item
 * @property string $title
 * @property string $type
 * @property string $typeid
 * @property string $type_params
 * @property string $cssid
 * @property string $cssclass
 * @property bool $hide_in_nav
 * @property bool $hide_in_sitemap
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property \Content\Model\Entity\ChildMenuItem[] $child_menu_items
 */
class MenuItem extends Entity
{

    //use PostHandlerEntityTrait;

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        '*' => true,
        'id' => false,
    ];

    protected $_virtual = [
        'view_url'
    ];

    /**
     * @return MenuHandlerInterface
     * @throws \Exception
     */
    public function handler()
    {
        if ($this->_handler === null) {

            if (!$this->type) {
                throw new \Exception(sprintf('Menu Handler can not be attached without type'));
            }

            $this->_handler = ContentManager::getMenuHandlerInstance($this);
            if (!$this->_handler) {
                throw new \Exception(sprintf('Menu Handler not found for type %s', $this->type));
            }
        }
        return $this->_handler;
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function getViewUrl()
    {
        return $this->handler()->getViewUrl();
    }

    protected function _getViewUrl()
    {
        return $this->getViewUrl();
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function getAdminUrl()
    {
        return $this->handler()->getAdminUrl();
    }

    protected function _getAdminUrl()
    {
        return $this->getAdminUrl();
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function getLabel()
    {
        return $this->handler()->getLabel();
    }

    protected function _getLabel()
    {
        return $this->getLabel();
    }

    /**
     * @return \Cake\ORM\Query
     * @throws \Exception
     */
    public function getChildren()
    {
        return $this->handler()->getChildren();
    }

    protected function _getChildren()
    {
        return $this->getChildren()->all()->toArray();
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function isHiddenInNav()
    {
        return $this->handler()->isHiddenInNav();
    }

    protected function _isHiddenInNav()
    {
        return $this->isHiddenInNav();
    }

}