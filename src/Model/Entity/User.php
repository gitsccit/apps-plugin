<?php

namespace Apps\Model\Entity;

use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;

/**
 * User Entity
 *
 * @property int $id
 * @property string $ldapid
 * @property string $username
 * @property string $display_name
 * @property string $first_name
 * @property string|null $last_name
 * @property string|null $email
 * @property string|null $title
 * @property string|null $department
 * @property string|null $location
 * @property int|null $time_zone_id
 * @property int|null $manager_id
 * @property string $active
 *
 * @property \Apps\Model\Entity\TimeZone $time_zone
 * @property \Apps\Model\Entity\User $manager
 * @property \Apps\Model\Entity\File[] $files
 * @property \Apps\Model\Entity\UserContact[] $user_contacts
 * @property \Apps\Model\Entity\UserLogin[] $user_logins
 * @property \Apps\Model\Entity\Role[] $roles
 */
class User extends Entity
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
        'ldapid' => true,
        'username' => true,
        'display_name' => true,
        'first_name' => true,
        'last_name' => true,
        'email' => true,
        'title' => true,
        'department' => true,
        'location' => true,
        'time_zone_id' => true,
        'manager_id' => true,
        'active' => true,
        'user' => true,
        'files' => true,
        'user_contacts' => true,
        'user_logins' => true,
        'roles' => true
    ];
    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */
    protected $_hidden = [
        'id',
        'time_zone_id',
        'manager_id',
        'ldapid'
    ];

    /**
     * Fields that can be filtered.
     *
     * @var array
     */
    public static $filterable = [
        'username',
        'display_name',
        'title',
        'location',
        'department',
        'manager' => 'display_name'
    ];

    /**
     * The priority of the fields, unspecified fields have the highest priority. Add fields to this list
     * in order of priority from high to low.
     *
     * @var array
     */
    public static $priority = [
        'name',
        'active',
        'extension',
        'location',
        'department',
        'title',
        'email',
        'mobile',
        'manager',
        'timezone',
    ];

    public function hasPermission($permission)
    {
        $permissionsTable = TableRegistry::getTableLocator()->get('Apps.Permissions');
        $permission = strtolower($permission);
        $permissions = [$permission];

        if (($components = explode('.', $permission)) && count($components) === 3) {
            list($plugin, $controller, $action) = $components;
            $permissions = array_merge($permissions, ["$plugin.$controller.*", "$plugin.*.$action"]);
        }

        if (!$permissionsTable->exists(['name IN' => $permissions])) {
            return true;
        }

        $hasPermission = $permissionsTable->find()
            ->innerJoinWith('Roles.Users', function ($q) {
                return $q->where(['Users.id' => $this->id]);
            })->whereInList('Permissions.name', $permissions)
            ->first();

        return !is_null($hasPermission);
    }
}
