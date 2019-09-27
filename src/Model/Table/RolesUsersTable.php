<?php
namespace Apps\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * RolesUsers Model
 *
 * @property \Apps\Model\Table\RolesTable|\Cake\ORM\Association\BelongsTo $Roles
 * @property \Apps\Model\Table\UsersTable|\Cake\ORM\Association\BelongsTo $Users
 *
 * @method \Apps\Model\Entity\RolesUser get($primaryKey, $options = [])
 * @method \Apps\Model\Entity\RolesUser newEntity($data = null, array $options = [])
 * @method \Apps\Model\Entity\RolesUser[] newEntities(array $data, array $options = [])
 * @method \Apps\Model\Entity\RolesUser|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Apps\Model\Entity\RolesUser saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Apps\Model\Entity\RolesUser patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Apps\Model\Entity\RolesUser[] patchEntities($entities, array $data, array $options = [])
 * @method \Apps\Model\Entity\RolesUser findOrCreate($search, callable $callback = null, $options = [])
 */
class RolesUsersTable extends Table
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

        $this->setTable('roles_users');
        $this->setDisplayField('role_id');
        $this->setPrimaryKey(['role_id', 'user_id']);

        $this->belongsTo('Roles', [
            'foreignKey' => 'role_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER'
        ]);
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
        $rules->add($rules->existsIn(['role_id'], 'Roles'));
        $rules->add($rules->existsIn(['user_id'], 'Users'));

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
