<?php

namespace Apps\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Skeleton\Model\Table\EnumTrait;

/**
 * Files Model
 *
 * @property \Apps\Model\Table\MimeTypesTable|\Cake\ORM\Association\BelongsTo $MimeType
 * @property \Apps\Model\Table\UsersTable|\Cake\ORM\Association\BelongsTo $Users
 * @property \Apps\Model\Table\AppLinksTable|\Cake\ORM\Association\HasMany $AppLinks
 * @property \Apps\Model\Table\MimeTypesTable|\Cake\ORM\Association\HasMany $MimeTypes
 *
 * @method \Apps\Model\Entity\File get($primaryKey, $options = [])
 * @method \Apps\Model\Entity\File newEntity($data = null, array $options = [])
 * @method \Apps\Model\Entity\File[] newEntities(array $data, array $options = [])
 * @method \Apps\Model\Entity\File|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Apps\Model\Entity\File saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Apps\Model\Entity\File patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Apps\Model\Entity\File[] patchEntities($entities, array $data, array $options = [])
 * @method \Apps\Model\Entity\File findOrCreate($search, callable $callback = null, $options = [])
 */
class FilesTable extends Table
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

        $this->addBehavior('Skeleton.CurrentUser');

        $this->setTable('files');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->belongsTo('MimeType', [
            'className' => 'Apps.MimeTypes',
            'foreignKey' => 'mime_type_id'
        ]);
        $this->belongsTo('Users', [
            'className' => 'Apps.Users',
            'foreignKey' => 'user_id'
        ]);
        $this->hasMany('AppLinks', [
            'className' => 'Apps.AppLinks',
            'foreignKey' => 'file_id'
        ]);
        $this->hasMany('MimeTypes', [
            'className' => 'Apps.MimeTypes',
            'foreignKey' => 'file_id'
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
            ->scalar('src')
            ->requirePresence('src', 'create')
            ->notEmptyString('src');

        $validator
            ->scalar('path')
            ->maxLength('path', 200)
            ->requirePresence('path', 'create')
            ->notEmptyString('path');

        $validator
            ->scalar('name')
            ->maxLength('name', 200)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->nonNegativeInteger('size')
            ->requirePresence('size', 'create')
            ->notEmptyString('size');

        $validator
            ->nonNegativeInteger('width')
            ->allowEmptyString('width');

        $validator
            ->nonNegativeInteger('height')
            ->allowEmptyString('height');

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
        $rules->add($rules->existsIn(['mime_type_id'], 'MimeType'));
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
