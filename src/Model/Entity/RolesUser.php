<?php
declare(strict_types=1);

namespace Apps\Model\Entity;

use Cake\ORM\Entity;

/**
 * RolesUser Entity
 *
 * @property int $role_id
 * @property int $user_id
 *
 * @property \Apps\Model\Entity\Role $role
 * @property \Apps\Model\Entity\User $user
 */
class RolesUser extends Entity
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
        'user' => true,
    ];
}
