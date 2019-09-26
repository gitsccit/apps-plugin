<?php

namespace Apps\Model\Entity;

use Cake\ORM\Entity;

/**
 * PermissionsRole Entity
 *
 * @property int $role_id
 * @property int $permission_id
 *
 * @property \Apps\Model\Entity\Role $role
 * @property \Apps\Model\Entity\Permission $permission
 */
class PermissionsRole extends Entity
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
        'role' => true,
        'permission' => true
    ];

    /**
     * Fields that can be filtered.
     *
     * @var array
     */
    //public static $filterable = [];

    /**
     * The priority of the fields, unspecified fields have the highest priority. Add fields to this list
     * in order of priority from high to low.
     *
     * @var array
     */
    //public static $priority = [];
}
