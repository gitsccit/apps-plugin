<?php
declare(strict_types=1);

namespace Apps\Model\Entity;

use Cake\ORM\Entity;

/**
 * UserContact Entity
 *
 * @property int $id
 * @property int $user_id
 * @property string $type
 * @property string $contact
 *
 * @property \Apps\Model\Entity\User $user
 */
class UserContact extends Entity
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
        'user_id' => true,
        'type' => true,
        'contact' => true,
        'user' => true,
    ];
}
