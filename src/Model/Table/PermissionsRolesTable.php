<?php
declare(strict_types=1);

namespace Apps\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;

/**
 * PermissionsRoles Model
 *
 * @property \Apps\Model\Table\RolesTable|\Cake\ORM\Association\BelongsTo $Roles
 * @property \Apps\Model\Table\PermissionsTable|\Cake\ORM\Association\BelongsTo $Permissions
 *
 * @method \Apps\Model\Entity\PermissionsRole get($primaryKey, $options = [])
 * @method \Apps\Model\Entity\PermissionsRole newEntity($data = null, array $options = [])
 * @method \Apps\Model\Entity\PermissionsRole[] newEntities(array $data, array $options = [])
 * @method \Apps\Model\Entity\PermissionsRole|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Apps\Model\Entity\PermissionsRole saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Apps\Model\Entity\PermissionsRole patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Apps\Model\Entity\PermissionsRole[] patchEntities($entities, array $data, array $options = [])
 * @method \Apps\Model\Entity\PermissionsRole findOrCreate($search, callable $callback = null, $options = [])
 */
class PermissionsRolesTable extends Table
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

        $this->setTable('permissions_roles');
        $this->setDisplayField('role_id');
        $this->setPrimaryKey(['role_id', 'permission_id']);

        $this->belongsTo('Roles', [
            'className' => 'Apps.Roles',
            'foreignKey' => 'role_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Permissions', [
            'className' => 'Apps.Permissions',
            'foreignKey' => 'permission_id',
            'joinType' => 'INNER',
        ]);
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
        $rules->add($rules->existsIn(['role_id'], 'Roles'));
        $rules->add($rules->existsIn(['permission_id'], 'Permissions'));

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
