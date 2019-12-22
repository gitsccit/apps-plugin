<?php
declare(strict_types=1);

namespace Apps\Model\Entity;

use Cake\ORM\Entity;

/**
 * StoreIpMap Entity
 *
 * @property int $id
 * @property int $store_id
 * @property int $environment_id
 * @property string $ip_address
 * @property int $port
 *
 * @property \Apps\Model\Entity\Store $store
 * @property \Apps\Model\Entity\Environment $environment
 */
class StoreIpMap extends Entity
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
        'store_id' => true,
        'environment_id' => true,
        'ip_address' => true,
        'port' => true,
        'store' => true,
        'environment' => true,
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */
    protected $_hidden = [
        'id',
        'store_id',
        'environment_id',
    ];

    /**
     * Fields that can be filtered.
     *
     * @var array
     */
    public static $filterable = [
        'store' => 'name',
        'environment' => 'name',
    ];

    /**
     * The priority of the fields, unspecified fields have the highest priority. Add fields to this list
     * in order of priority from high to low.
     *
     * @var array
     */
    public static $priority = [
        'store',
    ];
}
