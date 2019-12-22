<?php
declare(strict_types=1);

namespace Apps\Model\Entity;

use Cake\ORM\Entity;

/**
 * MimeType Entity
 *
 * @property int $id
 * @property string $name
 * @property string $image
 * @property string $resize
 * @property int|null $file_id
 * @property string|null $handler
 * @property \Cake\I18n\FrozenTime $created_at
 * @property \Cake\I18n\FrozenTime $modified_at
 *
 * @property \Apps\Model\Entity\File $thumbnail
 * @property \Apps\Model\Entity\File[] $files
 */
class MimeType extends Entity
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
        'image' => true,
        'resize' => true,
        'file_id' => true,
        'handler' => true,
        'files' => true
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */
    protected $_hidden = [
        'id',
        'file_id'
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
    public static $priority = [
        'created_at',
        'modified_at',
        'image',
        'thumbnail',
        'handler',
    ];
}
