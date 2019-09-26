<?php

namespace Apps\Model\Entity;

use Cake\ORM\Entity;

/**
 * TimeZone Entity
 *
 * @property int $id
 * @property string $name
 *
 * @property \Apps\Model\Entity\LocationTimeZone[] $location_time_zones
 * @property \Apps\Model\Entity\User[] $users
 */
class TimeZone extends Entity
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
        'location_time_zones' => true,
        'users' => true
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */
    protected $_hidden = [
        'id'
    ];

    /**
     * Fields that can be filtered.
     *
     * @var array
     */
    public static $filterable = [
        'name'
    ];

    /**
     * The priority of the fields, unspecified fields have the highest priority. Add fields to this list
     * in order of priority from high to low.
     *
     * @var array
     */
    //public static $priority = [];
}
