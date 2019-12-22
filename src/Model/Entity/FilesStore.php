<?php
declare(strict_types=1);

namespace Apps\Model\Entity;

use Cake\ORM\Entity;

/**
 * FilesStore Entity
 *
 * @property int $file_id
 * @property int $store_id
 *
 * @property \Apps\Model\Entity\File $file
 * @property \Apps\Model\Entity\Store $store
 */
class FilesStore extends Entity
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
        'file' => true,
        'store' => true
    ];
}
