<?php
declare(strict_types=1);

namespace Apps\Model\Entity;

use Cake\ORM\Entity;

/**
 * OptionStore Entity
 *
 * @property int $id
 * @property int $option_id
 * @property int $store_id
 * @property int $environment_id
 * @property string $value
 * @property \Cake\I18n\FrozenTime|null $timestamp
 *
 * @property \Apps\Model\Entity\Option $option
 * @property \Apps\Model\Entity\Store $store
 * @property \Apps\Model\Entity\Environment $environment
 */
class OptionStore extends Entity
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
        'option_id' => true,
        'store_id' => true,
        'environment_id' => true,
        'value' => true,
        'timestamp' => true,
        'option' => true,
        'store' => true,
        'environment' => true
    ];
}
