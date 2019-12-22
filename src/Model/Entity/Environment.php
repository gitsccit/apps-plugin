<?php
declare(strict_types=1);

namespace Apps\Model\Entity;

use Cake\ORM\Entity;

/**
 * Environment Entity
 *
 * @property int $id
 * @property string $name
 * @property string $path
 * @property int|null $permission_id
 * @property \Cake\I18n\FrozenTime $created_at
 * @property \Cake\I18n\FrozenTime $modified_at
 *
 * @property \Apps\Model\Entity\Permission $permission
 * @property \Apps\Model\Entity\OptionStore[] $option_stores
 * @property \Apps\Model\Entity\StoreIpMap[] $store_ip_maps
 */
class Environment extends Entity
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
        'path' => true,
        'permission_id' => true,
        'permission' => true,
        'option_stores' => true,
        'store_ip_maps' => true
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */
    protected $_hidden = [
        'id',
        'permission_id'
    ];

    /**
     * Fields that can be filtered.
     *
     * @var array
     */
    public static $filterable = [
        'name',
        'path'
    ];

    /**
     * The priority of the fields, unspecified fields have the highest priority. Add fields to this list
     * in order of priority from high to low.
     *
     * @var array
     */
    public static $priority = [
        'path',
        'created_at',
        'modified_at',
        'permission'
    ];
}
