<?php

namespace Apps\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Apis Model
 *
 * @method \Apps\Model\Entity\Api get($primaryKey, $options = [])
 * @method \Apps\Model\Entity\Api newEntity($data = null, array $options = [])
 * @method \Apps\Model\Entity\Api[] newEntities(array $data, array $options = [])
 * @method \Apps\Model\Entity\Api|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Apps\Model\Entity\Api saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Apps\Model\Entity\Api patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Apps\Model\Entity\Api[] patchEntities($entities, array $data, array $options = [])
 * @method \Apps\Model\Entity\Api findOrCreate($search, callable $callback = null, $options = [])
 */
class ApisTable extends Table
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

        $this->setTable('apis');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');
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
            ->maxLength('name', 50)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->scalar('ip_address')
            ->maxLength('ip_address', 39)
            ->requirePresence('ip_address', 'create')
            ->notEmptyString('ip_address');

        $validator
            ->scalar('token')
            ->maxLength('token', 256)
            ->requirePresence('token', 'create')
            ->notEmptyString('token');

        return $validator;
    }
}
