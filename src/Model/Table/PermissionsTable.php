<?php

namespace Apps\Model\Table;

use Cake\Event\Event;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Permissions Model
 *
 * @property \Apps\Model\Table\PermissionGroupsTable|\Cake\ORM\Association\BelongsTo $PermissionGroups
 * @property \Apps\Model\Table\AppLinksTable|\Cake\ORM\Association\HasMany $AppLinks
 * @property \Apps\Model\Table\EnvironmentsTable|\Cake\ORM\Association\HasMany $Environments
 * @property \Apps\Model\Table\RolesTable|\Cake\ORM\Association\BelongsToMany $Roles
 *
 * @method \Apps\Model\Entity\Permission get($primaryKey, $options = [])
 * @method \Apps\Model\Entity\Permission newEntity($data = null, array $options = [])
 * @method \Apps\Model\Entity\Permission[] newEntities(array $data, array $options = [])
 * @method \Apps\Model\Entity\Permission|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Apps\Model\Entity\Permission saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Apps\Model\Entity\Permission patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Apps\Model\Entity\Permission[] patchEntities($entities, array $data, array $options = [])
 * @method \Apps\Model\Entity\Permission findOrCreate($search, callable $callback = null, $options = [])
 */
class PermissionsTable extends Table
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

        $this->setTable('permissions');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->belongsTo('PermissionGroups', [
            'foreignKey' => 'permission_group_id'
        ]);
        $this->hasMany('AppLinks', [
            'foreignKey' => 'permission_id'
        ]);
        $this->hasMany('Environments', [
            'foreignKey' => 'permission_id'
        ]);
        $this->belongsToMany('Roles', [
            'foreignKey' => 'permission_id',
            'targetForeignKey' => 'role_id',
            'joinTable' => 'permissions_roles'
        ]);
    }

    public function beforeMarshal(Event $event, \ArrayObject $data, \ArrayObject $options)
    {
        if (isset($data['name'])) {
            $data['name'] = strtolower($data['name']);
        }
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
            ->maxLength('name', 100)
            ->requirePresence('name', 'create')
            ->notEmptyString('name')
            ->add('name', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('description')
            ->maxLength('description', 100)
            ->allowEmptyString('description');

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
        $rules->add($rules->existsIn(['permission_group_id'], 'PermissionGroups'));

        return $rules;
    }

    public function findPermissionExists(Query $query, $options = [])
    {
        $permission_name = ($options['permission']) ? $options['permission'] : null;
        $query->where(['name' => $permission_name]);

        return !empty($query->first()->name);
    }
}
