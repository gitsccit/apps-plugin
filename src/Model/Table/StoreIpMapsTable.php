<?php

namespace Apps\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * StoreIpMaps Model
 *
 * @property \Apps\Model\Table\StoresTable|\Cake\ORM\Association\BelongsTo $Stores
 * @property \Apps\Model\Table\EnvironmentsTable|\Cake\ORM\Association\BelongsTo $Environments
 *
 * @method \Apps\Model\Entity\StoreIpMap get($primaryKey, $options = [])
 * @method \Apps\Model\Entity\StoreIpMap newEntity($data = null, array $options = [])
 * @method \Apps\Model\Entity\StoreIpMap[] newEntities(array $data, array $options = [])
 * @method \Apps\Model\Entity\StoreIpMap|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Apps\Model\Entity\StoreIpMap saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Apps\Model\Entity\StoreIpMap patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Apps\Model\Entity\StoreIpMap[] patchEntities($entities, array $data, array $options = [])
 * @method \Apps\Model\Entity\StoreIpMap findOrCreate($search, callable $callback = null, $options = [])
 */
class StoreIpMapsTable extends Table
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

        $this->setTable('store_ip_maps');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Stores', [
            'className' => 'Apps.Stores',
            'foreignKey' => 'store_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Environments', [
            'className' => 'Apps.Environments',
            'foreignKey' => 'environment_id',
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
            ->scalar('ip_address')
            ->maxLength('ip_address', 39)
            ->requirePresence('ip_address', 'create')
            ->notEmptyString('ip_address');

        $validator
            ->requirePresence('port', 'create')
            ->notEmptyString('port');

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
        $rules->add($rules->existsIn(['store_id'], 'Stores'));
        $rules->add($rules->existsIn(['environment_id'], 'Environments'));

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
