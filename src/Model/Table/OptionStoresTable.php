<?php
declare(strict_types=1);

namespace Apps\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * OptionStores Model
 *
 * @property \Apps\Model\Table\OptionsTable|\Cake\ORM\Association\BelongsTo $Options
 * @property \Apps\Model\Table\StoresTable|\Cake\ORM\Association\BelongsTo $Stores
 * @property \Apps\Model\Table\EnvironmentsTable|\Cake\ORM\Association\BelongsTo $Environments
 *
 * @method \Apps\Model\Entity\OptionStore get($primaryKey, $options = [])
 * @method \Apps\Model\Entity\OptionStore newEntity($data = null, array $options = [])
 * @method \Apps\Model\Entity\OptionStore[] newEntities(array $data, array $options = [])
 * @method \Apps\Model\Entity\OptionStore|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Apps\Model\Entity\OptionStore saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Apps\Model\Entity\OptionStore patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Apps\Model\Entity\OptionStore[] patchEntities($entities, array $data, array $options = [])
 * @method \Apps\Model\Entity\OptionStore findOrCreate($search, callable $callback = null, $options = [])
 */
class OptionStoresTable extends Table
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

        $this->setTable('option_stores');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Options', [
            'className' => 'Apps.Options',
            'foreignKey' => 'option_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Stores', [
            'className' => 'Apps.Stores',
            'foreignKey' => 'store_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Environments', [
            'className' => 'Apps.Environments',
            'foreignKey' => 'environment_id',
            'joinType' => 'INNER',
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
            ->scalar('value')
            ->maxLength('value', 120)
            ->requirePresence('value', 'create')
            ->notEmptyString('value');

        $validator
            ->dateTime('timestamp')
            ->allowEmptyDateTime('timestamp');

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
        $rules->add($rules->existsIn(['option_id'], 'Options'));
        $rules->add($rules->existsIn(['store_id'], 'Stores'));
        $rules->add($rules->existsIn(['environment_id'], 'Environments'));

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
