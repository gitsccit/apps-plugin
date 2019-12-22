<?php
declare(strict_types=1);

namespace Apps\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Skeleton\Model\Table\EnumTrait;

/**
 * MimeTypes Model
 *
 * @property \Apps\Model\Table\FilesTable|\Cake\ORM\Association\BelongsTo $Thumbnail
 * @property \Apps\Model\Table\FilesTable|\Cake\ORM\Association\HasMany $Files
 *
 * @method \Apps\Model\Entity\MimeType get($primaryKey, $options = [])
 * @method \Apps\Model\Entity\MimeType newEntity($data = null, array $options = [])
 * @method \Apps\Model\Entity\MimeType[] newEntities(array $data, array $options = [])
 * @method \Apps\Model\Entity\MimeType|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Apps\Model\Entity\MimeType saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Apps\Model\Entity\MimeType patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Apps\Model\Entity\MimeType[] patchEntities($entities, array $data, array $options = [])
 * @method \Apps\Model\Entity\MimeType findOrCreate($search, callable $callback = null, $options = [])
 */
class MimeTypesTable extends Table
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

        $this->setTable('mime_types');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->belongsTo('Thumbnail', [
            'className' => 'Apps.Files',
            'foreignKey' => 'file_id'
        ]);
        $this->hasMany('Files', [
            'className' => 'Apps.Files',
            'foreignKey' => 'mime_type_id'
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
            ->maxLength('name', 120)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->scalar('image')
            ->requirePresence('image', 'create')
            ->notEmptyFile('image');

        $validator
            ->scalar('resize')
            ->requirePresence('resize', 'create')
            ->notEmptyString('resize');

        $validator
            ->scalar('handler')
            ->allowEmptyString('handler');

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
        $rules->add($rules->existsIn(['file_id'], 'Thumbnail'));

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
