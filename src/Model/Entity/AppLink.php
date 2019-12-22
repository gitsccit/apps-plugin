<?php
declare(strict_types=1);

namespace Apps\Model\Entity;

use Cake\ORM\Entity;

/**
 * AppLink Entity
 *
 * @property int $id
 * @property int $app_id
 * @property int|null $app_link_id
 * @property int|null $permission_id
 * @property string $htmlid
 * @property string $title
 * @property string $destination
 * @property int|null $file_id
 * @property int $sort
 * @property \Cake\I18n\FrozenTime $created_at
 * @property \Cake\I18n\FrozenTime $modified_at
 *
 * @property \Apps\Model\Entity\App $app
 * @property \Apps\Model\Entity\AppLink[] $app_links
 * @property \Apps\Model\Entity\Permission $permission
 * @property \Apps\Model\Entity\File $file
 */
class AppLink extends Entity
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
        'app_id' => true,
        'app_link_id' => true,
        'permission_id' => true,
        'htmlid' => true,
        'title' => true,
        'destination' => true,
        'file_id' => true,
        'sort' => true,
        'app' => true,
        'app_links' => true,
        'permission' => true,
        'file' => true
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */
    protected $_hidden = [
        'id',
        'app_id',
        'app_link_id',
        'permission_id',
        'file_id'
    ];

    /**
     * Fields that can be filtered.
     *
     * @var array
     */
    public static $filterable = [
        'app' => 'name'
    ];

    /**
     * The priority of the fields, unspecified fields have the highest priority. Add fields to this list
     * in order of priority from high to low.
     *
     * @var array
     */
    //public static $priority = [];
}
