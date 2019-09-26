<?php

namespace Apps\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Skeleton\Model\Table\EnumTrait;

/**
 * Stores Model
 *
 * @property \Apps\Model\Table\StoresTable|\Cake\ORM\Association\BelongsTo $ParentStores
 * @property \Apps\Model\Table\OptionStoresTable|\Cake\ORM\Association\HasMany $OptionStores
 * @property \Apps\Model\Table\StoreDivisionsTable|\Cake\ORM\Association\HasMany $StoreDivisions
 * @property \Apps\Model\Table\StoreIpMapsTable|\Cake\ORM\Association\HasMany $StoreIpMaps
 * @property \Apps\Model\Table\StoreReturnsTable|\Cake\ORM\Association\HasMany $StoreReturns
 * @property \Apps\Model\Table\StoreSortFieldsTable|\Cake\ORM\Association\HasMany $StoreSortFields
 * @property \Apps\Model\Table\StoresTable|\Cake\ORM\Association\HasMany $ChildStores
 *
 * @method \Apps\Model\Entity\Store get($primaryKey, $options = [])
 * @method \Apps\Model\Entity\Store newEntity($data = null, array $options = [])
 * @method \Apps\Model\Entity\Store[] newEntities(array $data, array $options = [])
 * @method \Apps\Model\Entity\Store|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Apps\Model\Entity\Store saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Apps\Model\Entity\Store patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Apps\Model\Entity\Store[] patchEntities($entities, array $data, array $options = [])
 * @method \Apps\Model\Entity\Store findOrCreate($search, callable $callback = null, $options = [])
 */
class StoresTable extends Table
{
    use EnumTrait;

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('stores');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->belongsTo('ParentStores', [
            'className' => 'Stores',
            'foreignKey' => 'parent_id'
        ]);
        $this->hasMany('OptionStores', [
            'foreignKey' => 'store_id'
        ]);
        $this->hasMany('StoreDivisions', [
            'foreignKey' => 'store_id'
        ]);
        $this->hasMany('StoreIpMaps', [
            'foreignKey' => 'store_id'
        ]);
        $this->hasMany('StoreReturns', [
            'foreignKey' => 'store_id'
        ]);
        $this->hasMany('StoreSortFields', [
            'foreignKey' => 'store_id'
        ]);
        $this->hasMany('ChildStores', [
            'className' => 'Stores',
            'foreignKey' => 'parent_id'
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
            ->scalar('name')
            ->maxLength('name', 30)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->scalar('active')
            ->requirePresence('active', 'create')
            ->notEmptyString('active');

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
        $rules->add($rules->existsIn(['parent_id'], 'ParentStores'));

        return $rules;
    }
}
