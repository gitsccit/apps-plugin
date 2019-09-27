<?php

namespace Apps\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * StoreSortFields Model
 *
 * @property \Apps\Model\Table\StoresTable|\Cake\ORM\Association\BelongsTo $Stores
 *
 * @method \Apps\Model\Entity\StoreSortField get($primaryKey, $options = [])
 * @method \Apps\Model\Entity\StoreSortField newEntity($data = null, array $options = [])
 * @method \Apps\Model\Entity\StoreSortField[] newEntities(array $data, array $options = [])
 * @method \Apps\Model\Entity\StoreSortField|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Apps\Model\Entity\StoreSortField saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Apps\Model\Entity\StoreSortField patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Apps\Model\Entity\StoreSortField[] patchEntities($entities, array $data, array $options = [])
 * @method \Apps\Model\Entity\StoreSortField findOrCreate($search, callable $callback = null, $options = [])
 */
class StoreSortFieldsTable extends Table
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

        $this->setTable('store_sort_fields');
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
    public function validationDefault(Validator $validator)
    {
        $validator
            ->nonNegativeInteger('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('sort')
            ->maxLength('sort', 10)
            ->requirePresence('sort', 'create')
            ->notEmptyString('sort');

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
