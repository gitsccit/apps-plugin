<?php

namespace Apps\Model\Entity;

use Cake\ORM\Entity;

/**
 * LocationTimeZone Entity
 *
 * @property int $id
 * @property string|null $location
 * @property int $time_zone_id
 *
 * @property \Apps\Model\Entity\TimeZone $time_zone
 */
class LocationTimeZone extends Entity
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
        'location' => true,
        'time_zone_id' => true,
        'time_zone' => true
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */
    protected $_hidden = [
        'id',
        'time_zone_id'
    ];

    /**
     * Fields that can be filtered.
     *
     * @var array
     */
    public static $filterable = [
        'location'
    ];

    /**
     * The priority of the fields, unspecified fields have the highest priority. Add fields to this list
     * in order of priority from high to low.
     *
     * @var array
     */
    //public static $priority = [];
}
