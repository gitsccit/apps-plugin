<?php
declare(strict_types=1);

namespace Apps\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * TimeZones Model
 *
 * @property \Apps\Model\Table\LocationTimeZonesTable|\Cake\ORM\Association\HasMany $LocationTimeZones
 * @property \Apps\Model\Table\UsersTable|\Cake\ORM\Association\HasMany $Users
 *
 * @method \Apps\Model\Entity\TimeZone get($primaryKey, $options = [])
 * @method \Apps\Model\Entity\TimeZone newEntity($data = null, array $options = [])
 * @method \Apps\Model\Entity\TimeZone[] newEntities(array $data, array $options = [])
 * @method \Apps\Model\Entity\TimeZone|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Apps\Model\Entity\TimeZone saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Apps\Model\Entity\TimeZone patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Apps\Model\Entity\TimeZone[] patchEntities($entities, array $data, array $options = [])
 * @method \Apps\Model\Entity\TimeZone findOrCreate($search, callable $callback = null, $options = [])
 */
class TimeZonesTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('time_zones');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->hasMany('LocationTimeZones', [
            'className' => 'Apps.LocationTimeZones',
            'foreignKey' => 'time_zone_id'
        ]);
        $this->hasMany('Users', [
            'className' => 'Apps.Users',
            'foreignKey' => 'time_zone_id'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->nonNegativeInteger('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('name')
            ->maxLength('name', 50)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        return $validator;
    }

    /**
     * Returns the database connection name to use by default.
     *
     * @return string
     */
    public static function defaultConnectionName(): string
    {
        return 'apps';
    }
}
