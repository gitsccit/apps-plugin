<?php
declare(strict_types=1);

namespace Apps\Model\Entity;

use Cake\ORM\Entity;

/**
 * Store Entity
 *
 * @property int $id
 * @property string $name
 * @property string $active
 * @property int|null $parent_id
 *
 * @property \Apps\Model\Entity\Store $parent_store
 * @property \Apps\Model\Entity\OptionStore[] $option_stores
 * @property \Apps\Model\Entity\StoreDivision[] $store_divisions
 * @property \Apps\Model\Entity\StoreIpMap[] $store_ip_maps
 * @property \Apps\Model\Entity\StoreReturn[] $store_returns
 * @property \Apps\Model\Entity\StoreSortField[] $store_sort_fields
 * @property \Apps\Model\Entity\Store[] $child_stores
 */
class Store extends Entity
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
        'active' => true,
        'parent_id' => true,
        'parent_store' => true,
        'option_stores' => true,
        'store_divisions' => true,
        'store_ip_maps' => true,
        'store_returns' => true,
        'store_sort_fields' => true,
        'child_stores' => true,
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */
    protected $_hidden = [
        'id',
        'parent_id',
    ];

    /**
     * Fields that can be filtered.
     *
     * @var array
     */
    public static $filterable = [
        'name',
    ];

    /**
     * The priority of the fields, unspecified fields have the highest priority. Add fields to this list
     * in order of priority from high to low.
     *
     * @var array
     */
    public static $priority = [
        'active',
    ];
}
