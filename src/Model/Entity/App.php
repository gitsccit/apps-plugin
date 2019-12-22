<?php
declare(strict_types=1);

namespace Apps\Model\Entity;

use Cake\ORM\Entity;

/**
 * App Entity
 *
 * @property int $id
 * @property string $name
 * @property string|null $cake_plugin
 * @property string|null $route
 * @property int $sort
 *
 * @property \Apps\Model\Entity\AppLink[] $app_links
 */
class App extends Entity
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
        'cake_plugin' => true,
        'route' => true,
        'sort' => true,
        'app_links' => true
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
        'name',
        'cake_plugin'
    ];

    /**
     * The priority of the fields, unspecified fields have the highest priority. Add fields to this list
     * in order of priority from high to low.
     *
     * @var array
     */
    public static $priority = [
        'cake_plugin',
        'route'
    ];
}
