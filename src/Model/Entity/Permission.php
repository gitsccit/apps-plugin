<?php
declare(strict_types=1);

namespace Apps\Model\Entity;

use Cake\ORM\Entity;

/**
 * Permission Entity
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property int|null $permission_group_id
 *
 * @property \Apps\Model\Entity\PermissionGroup $permission_group
 * @property \Apps\Model\Entity\AppLink[] $app_links
 * @property \Apps\Model\Entity\Environment[] $environments
 * @property \Apps\Model\Entity\Role[] $roles
 */
class Permission extends Entity
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
        'name' => true,
        'description' => true,
        'permission_group_id' => true,
        'permission_group' => true,
        'app_links' => true,
        'environments' => true,
        'roles' => true,
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */
    protected $_hidden = [
        'id',
        'permission_group_id',
    ];

    /**
     * Fields that can be filtered.
     *
     * @var array
     */
    public static $filterable = [
        'name',
        'description',
    ];

    /**
     * The priority of the fields, unspecified fields have the highest priority. Add fields to this list
     * in order of priority from high to low.
     *
     * @var array
     */
    public static $priority = [
        'permission_group',
    ];
}
