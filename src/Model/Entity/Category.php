<?php
declare(strict_types=1);

namespace Content\Model\Entity;

use Cake\ORM\Entity;

/**
 * Category Entity
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property bool $is_published
 */
class Category extends Entity
{
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

    /**
     * @return array
     */
    public function getViewUrl()
    {
        return ['plugin' => 'Content', 'controller' => 'Categories', 'action' => 'view', $this->id];
    }

    /**
     * @return array
     */
    public function getAdminUrl()
    {
        return ['prefix' => 'admin', 'plugin' => 'Content', 'controller' => 'Categories', 'action' => 'edit', $this->id];
    }

    /**
     * @return bool
     */
    public function isPublished()
    {
        return $this->is_published;
    }
}
