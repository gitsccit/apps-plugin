<?php
declare(strict_types=1);

namespace Apps\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * StoreReturns Model
 *
 * @property \Apps\Model\Table\StoresTable|\Cake\ORM\Association\BelongsTo $Stores
 *
 * @method \Apps\Model\Entity\StoreReturn get($primaryKey, $options = [])
 * @method \Apps\Model\Entity\StoreReturn newEntity($data = null, array $options = [])
 * @method \Apps\Model\Entity\StoreReturn[] newEntities(array $data, array $options = [])
 * @method \Apps\Model\Entity\StoreReturn|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Apps\Model\Entity\StoreReturn saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Apps\Model\Entity\StoreReturn patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Apps\Model\Entity\StoreReturn[] patchEntities($entities, array $data, array $options = [])
 * @method \Apps\Model\Entity\StoreReturn findOrCreate($search, callable $callback = null, $options = [])
 */
class StoreReturnsTable extends Table
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

        $this->setTable('store_returns');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Stores', [
            'className' => 'Apps.Stores',
            'foreignKey' => 'store_id'
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
            ->scalar('company_code')
            ->maxLength('company_code', 3)
            ->requirePresence('company_code', 'create')
            ->notEmptyString('company_code');

        $validator
            ->scalar('return_to_address_code')
            ->maxLength('return_to_address_code', 4)
            ->requirePresence('return_to_address_code', 'create')
            ->notEmptyString('return_to_address_code');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn(['store_id'], 'Stores'));

        return $rules;
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
