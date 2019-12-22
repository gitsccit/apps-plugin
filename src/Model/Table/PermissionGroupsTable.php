<?php
declare(strict_types=1);

namespace Apps\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * PermissionGroups Model
 *
 * @property \Apps\Model\Table\PermissionsTable|\Cake\ORM\Association\HasMany $Permissions
 *
 * @method \Apps\Model\Entity\PermissionGroup get($primaryKey, $options = [])
 * @method \Apps\Model\Entity\PermissionGroup newEntity($data = null, array $options = [])
 * @method \Apps\Model\Entity\PermissionGroup[] newEntities(array $data, array $options = [])
 * @method \Apps\Model\Entity\PermissionGroup|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Apps\Model\Entity\PermissionGroup saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Apps\Model\Entity\PermissionGroup patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Apps\Model\Entity\PermissionGroup[] patchEntities($entities, array $data, array $options = [])
 * @method \Apps\Model\Entity\PermissionGroup findOrCreate($search, callable $callback = null, $options = [])
 */
class PermissionGroupsTable extends Table
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

        $this->setTable('permission_groups');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->hasMany('Permissions', [
            'className' => 'Apps.Permissions',
            'foreignKey' => 'permission_group_id',
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
            ->scalar('name')
            ->maxLength('name', 30)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        return $validator;
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
