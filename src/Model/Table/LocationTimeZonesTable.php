<?php

namespace Apps\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * LocationTimeZones Model
 *
 * @property \Apps\Model\Table\TimeZonesTable|\Cake\ORM\Association\BelongsTo $TimeZones
 *
 * @method \Apps\Model\Entity\LocationTimeZone get($primaryKey, $options = [])
 * @method \Apps\Model\Entity\LocationTimeZone newEntity($data = null, array $options = [])
 * @method \Apps\Model\Entity\LocationTimeZone[] newEntities(array $data, array $options = [])
 * @method \Apps\Model\Entity\LocationTimeZone|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Apps\Model\Entity\LocationTimeZone saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Apps\Model\Entity\LocationTimeZone patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Apps\Model\Entity\LocationTimeZone[] patchEntities($entities, array $data, array $options = [])
 * @method \Apps\Model\Entity\LocationTimeZone findOrCreate($search, callable $callback = null, $options = [])
 */
class LocationTimeZonesTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('location_time_zones');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('TimeZones', [
            'foreignKey' => 'time_zone_id',
            'joinType' => 'INNER'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->nonNegativeInteger('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('location')
            ->maxLength('location', 50)
            ->allowEmptyString('location');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['time_zone_id'], 'TimeZones'));

        return $rules;
    }

    /**
     * Returns the database connection name to use by default.
     *
     * @return string
     */
    public static function defaultConnectionName()
    {
        return 'apps';
    }
}
