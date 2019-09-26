<?php

namespace Apps\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Skeleton\Model\Table\EnumTrait;

/**
 * Options Model
 *
 * @property \Apps\Model\Table\OptionStoresTable|\Cake\ORM\Association\HasMany $OptionStores
 *
 * @method \Apps\Model\Entity\Option get($primaryKey, $options = [])
 * @method \Apps\Model\Entity\Option newEntity($data = null, array $options = [])
 * @method \Apps\Model\Entity\Option[] newEntities(array $data, array $options = [])
 * @method \Apps\Model\Entity\Option|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Apps\Model\Entity\Option saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Apps\Model\Entity\Option patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Apps\Model\Entity\Option[] patchEntities($entities, array $data, array $options = [])
 * @method \Apps\Model\Entity\Option findOrCreate($search, callable $callback = null, $options = [])
 */
class OptionsTable extends Table
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

        $this->setTable('options');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->hasMany('OptionStores', [
            'foreignKey' => 'option_id'
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
            ->maxLength('name', 60)
            ->requirePresence('name', 'create')
            ->notEmptyString('name')
            ->add('name', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('type')
            ->requirePresence('type', 'create')
            ->notEmptyString('type');

        $validator
            ->scalar('value')
            ->maxLength('value', 120)
            ->allowEmptyString('value');

        $validator
            ->dateTime('timestamp')
            ->notEmptyDateTime('timestamp');

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
        $rules->add($rules->isUnique(['name']));

        return $rules;
    }


    public function getStoreEnvironmentValues(int $id)
    {
        $results = $this->find()
            ->select([
                'id',
                'option_stores.value',
                'timestamp',
                'stores.id',
                'stores.name',
                'environments.id',
                'environments.name'
            ])
            ->join(['stores', 'environments'])
            ->leftJoin('option_stores', [
                'stores.id = option_stores.store_id',
                'environments.id = option_stores.environment_id',
                'option_stores.option_id = Options.id'
            ])
            ->where(['Options.id' => $id])
            ->order('stores.name ASC,environments.id ASC')
            ->all();

        return $results;
    }
}
