<?php
namespace Content\Model\Entity;

use Banana\Model\EntityTypeHandlerInterface;
use Banana\Model\EntityTypeHandlerTrait;
use Cake\ORM\Entity;
use Content\Lib\ContentManager;
use Content\Model\Entity\Node\NodeTypeInterface;

/**
 * Node Entity.
 *
 * @property int $id
 * @property int $site_id
 * @property \Content\Model\Entity\Menu $menu
 * @property int $lft
 * @property int $rght
 * @property int $level
 * @property int $parent_id
 * @property \Content\Model\Entity\ParentNode $parent_node
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
 * @property \Content\Model\Entity\ChildNode[] $child_nodes
 */
class Node extends Entity implements EntityTypeHandlerInterface
{

    use EntityTypeHandlerTrait {
        EntityTypeHandlerTrait::handler as typeHandler;
    }


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
     * @return NodeTypeInterface
     * @throws \Exception
     */
    public function handler()
    {
        return $this->typeHandler();
    }

    protected function _getHandlerNamespace()
    {
        return 'NodeType';
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function getViewUrl()
    {
        $url = $this->handler()->getViewUrl();

        // inject menuitem reference to url
        if (is_array($url)) {
            $url['_mref'] = $this->id;
        } elseif (strrpos($url, '?') !== false) {
            $url .= '&_mref=' . $this->id;
        } elseif (strpos($url, '://') === false) {
            $url .= '?_mref=' . $this->id;
        }
        return $url;
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
