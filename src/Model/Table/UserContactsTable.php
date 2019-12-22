<?php
declare(strict_types=1);

namespace Apps\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Skeleton\Model\Table\EnumTrait;

/**
 * UserContacts Model
 *
 * @property \Apps\Model\Table\UsersTable|\Cake\ORM\Association\BelongsTo $Users
 *
 * @method \Apps\Model\Entity\UserContact get($primaryKey, $options = [])
 * @method \Apps\Model\Entity\UserContact newEntity($data = null, array $options = [])
 * @method \Apps\Model\Entity\UserContact[] newEntities(array $data, array $options = [])
 * @method \Apps\Model\Entity\UserContact|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Apps\Model\Entity\UserContact saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Apps\Model\Entity\UserContact patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Apps\Model\Entity\UserContact[] patchEntities($entities, array $data, array $options = [])
 * @method \Apps\Model\Entity\UserContact findOrCreate($search, callable $callback = null, $options = [])
 */
class UserContactsTable extends Table
{
    use EnumTrait;

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('user_contacts');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Users', [
            'className' => 'Apps.Users',
            'foreignKey' => 'user_id',
            'joinType' => 'INNER'
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
            ->scalar('type')
            ->requirePresence('type', 'create')
            ->notEmptyString('type');

        $validator
            ->scalar('contact')
            ->maxLength('contact', 80)
            ->requirePresence('contact', 'create')
            ->notEmptyString('contact');

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
        $rules->add($rules->existsIn(['user_id'], 'Users'));

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
