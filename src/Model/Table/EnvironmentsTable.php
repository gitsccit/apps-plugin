<?php
declare(strict_types=1);

namespace Apps\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Environments Model
 *
 * @property \Apps\Model\Table\PermissionsTable|\Cake\ORM\Association\BelongsTo $Permissions
 * @property \Apps\Model\Table\OptionStoresTable|\Cake\ORM\Association\HasMany $OptionStores
 * @property \Apps\Model\Table\StoreIpMapsTable|\Cake\ORM\Association\HasMany $StoreIpMaps
 *
 * @method \Apps\Model\Entity\Environment get($primaryKey, $options = [])
 * @method \Apps\Model\Entity\Environment newEntity($data = null, array $options = [])
 * @method \Apps\Model\Entity\Environment[] newEntities(array $data, array $options = [])
 * @method \Apps\Model\Entity\Environment|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Apps\Model\Entity\Environment saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Apps\Model\Entity\Environment patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Apps\Model\Entity\Environment[] patchEntities($entities, array $data, array $options = [])
 * @method \Apps\Model\Entity\Environment findOrCreate($search, callable $callback = null, $options = [])
 */
class EnvironmentsTable extends Table
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

        $this->setTable('environments');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->belongsTo('Permissions', [
            'className' => 'Apps.Permissions',
            'foreignKey' => 'permission_id'
        ]);
        $this->hasMany('OptionStores', [
            'className' => 'Apps.OptionStores',
            'foreignKey' => 'environment_id'
        ]);
        $this->hasMany('StoreIpMaps', [
            'className' => 'Apps.StoreIpMaps',
            'foreignKey' => 'environment_id'
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
            ->maxLength('name', 50)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->scalar('path')
            ->maxLength('path', 100)
            ->requirePresence('path', 'create')
            ->notEmptyString('path');

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
