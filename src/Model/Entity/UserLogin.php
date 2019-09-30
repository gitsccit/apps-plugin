<?php

namespace Apps\Model\Entity;

use Cake\ORM\Entity;

/**
 * UserLogin Entity
 *
 * @property int $id
 * @property int $user_id
 * @property string|null $ip_address
 * @property string|null $browser
 * @property int|null $width
 * @property int|null $height
 * @property \Cake\I18n\FrozenTime|null $timestamp
 *
 * @property \Apps\Model\Entity\User $user
 */
class UserLogin extends Entity
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
        'ip_address' => true,
        'browser' => true,
        'width' => true,
        'height' => true,
        'timestamp' => true,
        'user' => true
    ];
}
