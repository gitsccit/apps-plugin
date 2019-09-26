<?php

namespace Apps\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Skeleton\Model\Table\EnumTrait;

/**
 * Users Model
 *
 * @property \Apps\Model\Table\TimeZonesTable|\Cake\ORM\Association\BelongsTo $TimeZones
 * @property \Apps\Model\Table\UsersTable|\Cake\ORM\Association\BelongsTo $Managers
 * @property \Apps\Model\Table\FilesTable|\Cake\ORM\Association\HasMany $Files
 * @property \Apps\Model\Table\UserContactsTable|\Cake\ORM\Association\HasMany $UserContacts
 * @property \Apps\Model\Table\UserLoginsTable|\Cake\ORM\Association\HasMany $UserLogins
 * @property \Apps\Model\Table\RolesTable|\Cake\ORM\Association\BelongsToMany $Roles
 *
 * @method \Apps\Model\Entity\User get($primaryKey, $options = [])
 * @method \Apps\Model\Entity\User newEntity($data = null, array $options = [])
 * @method \Apps\Model\Entity\User[] newEntities(array $data, array $options = [])
 * @method \Apps\Model\Entity\User|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Apps\Model\Entity\User saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Apps\Model\Entity\User patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Apps\Model\Entity\User[] patchEntities($entities, array $data, array $options = [])
 * @method \Apps\Model\Entity\User findOrCreate($search, callable $callback = null, $options = [])
 */
class UsersTable extends Table
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

        $this->setTable('users');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->belongsTo('TimeZones', [
            'foreignKey' => 'time_zone_id'
        ]);
        $this->belongsTo('Managers', [
            'className' => 'Users',
            'foreignKey' => 'manager_id',
        ]);
        $this->hasMany('Files', [
            'foreignKey' => 'user_id'
        ]);
        $this->hasMany('UserContacts', [
            'foreignKey' => 'user_id'
        ]);
        $this->hasMany('UserLogins', [
            'foreignKey' => 'user_id'
        ]);
        $this->belongsToMany('Roles', [
            'foreignKey' => 'user_id',
            'targetForeignKey' => 'role_id',
            'joinTable' => 'roles_users'
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
            ->scalar('ldapid')
            ->maxLength('ldapid', 65)
            ->requirePresence('ldapid', 'create')
            ->notEmptyString('ldapid')
            ->add('ldapid', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('username')
            ->maxLength('username', 30)
            ->requirePresence('username', 'create')
            ->notEmptyString('username');

        $validator
            ->scalar('display_name')
            ->maxLength('display_name', 50)
            ->requirePresence('display_name', 'create')
            ->notEmptyString('display_name');

        $validator
            ->scalar('first_name')
            ->maxLength('first_name', 30)
            ->requirePresence('first_name', 'create')
            ->notEmptyString('first_name');

        $validator
            ->scalar('last_name')
            ->maxLength('last_name', 60)
            ->allowEmptyString('last_name');

        $validator
            ->email('email')
            ->allowEmptyString('email');

        $validator
            ->scalar('title')
            ->maxLength('title', 50)
            ->allowEmptyString('title');

        $validator
            ->scalar('department')
            ->maxLength('department', 50)
            ->allowEmptyString('department');

        $validator
            ->scalar('location')
            ->maxLength('location', 50)
            ->allowEmptyString('location');

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
        $rules->add($rules->isUnique(['username']));
        $rules->add($rules->isUnique(['email']));
        $rules->add($rules->isUnique(['ldapid']));
        $rules->add($rules->existsIn(['time_zone_id'], 'TimeZones'));
        $rules->add($rules->existsIn(['manager_id'], 'Managers'));

        return $rules;
    }
}
