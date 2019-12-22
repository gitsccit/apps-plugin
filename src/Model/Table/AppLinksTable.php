<?php
declare(strict_types=1);

namespace Apps\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * AppLinks Model
 *
 * @property \Apps\Model\Table\AppsTable|\Cake\ORM\Association\BelongsTo $Apps
 * @property \Apps\Model\Table\AppLinksTable|\Cake\ORM\Association\BelongsTo $ParentLinks
 * @property \Apps\Model\Table\PermissionsTable|\Cake\ORM\Association\BelongsTo $Permissions
 * @property \Apps\Model\Table\FilesTable|\Cake\ORM\Association\BelongsTo $Files
 * @property \Apps\Model\Table\AppLinksTable|\Cake\ORM\Association\HasMany $ChildLinks
 *
 * @method \Apps\Model\Entity\AppLink get($primaryKey, $options = [])
 * @method \Apps\Model\Entity\AppLink newEntity($data = null, array $options = [])
 * @method \Apps\Model\Entity\AppLink[] newEntities(array $data, array $options = [])
 * @method \Apps\Model\Entity\AppLink|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Apps\Model\Entity\AppLink saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Apps\Model\Entity\AppLink patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Apps\Model\Entity\AppLink[] patchEntities($entities, array $data, array $options = [])
 * @method \Apps\Model\Entity\AppLink findOrCreate($search, callable $callback = null, $options = [])
 */
class AppLinksTable extends Table
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

        $this->setTable('app_links');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->belongsTo('Apps', [
            'className' => 'Apps.Apps',
            'foreignKey' => 'app_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('ParentLinks', [
            'className' => 'Apps.AppLinks',
            'foreignKey' => 'app_link_id'
        ]);
        $this->belongsTo('Permissions', [
            'className' => 'Apps.Permissions',
            'foreignKey' => 'permission_id'
        ]);
        $this->belongsTo('Files', [
            'className' => 'Apps.Files',
            'foreignKey' => 'file_id'
        ]);
        $this->hasMany('ChildLinks', [
            'className' => 'Apps.AppLinks',
            'foreignKey' => 'app_link_id'
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
            ->scalar('htmlid')
            ->maxLength('htmlid', 30)
            ->requirePresence('htmlid', 'create')
            ->notEmptyString('htmlid');

        $validator
            ->scalar('title')
            ->maxLength('title', 30)
            ->requirePresence('title', 'create')
            ->notEmptyString('title');

        $validator
            ->scalar('destination')
            ->maxLength('destination', 120)
            ->requirePresence('destination', 'create')
            ->notEmptyString('destination');

        $validator
            ->nonNegativeInteger('sort')
            ->notEmptyString('sort');

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
        $rules->add($rules->existsIn(['app_id'], 'Apps'));
        $rules->add($rules->existsIn(['app_link_id'], 'ParentLinks'));
        $rules->add($rules->existsIn(['permission_id'], 'Permissions'));
        $rules->add($rules->existsIn(['file_id'], 'Files'));

        return $rules;
    }

    /**
     * @param $parent_id
     * @return Query
     */
    public function getLinks($parent_id)
    {
        $query = $this->find()
            ->where(['app_id' => $parent_id])
            ->order(['sort' => 'ASC', 'title' => 'ASC']);
        $links = $query;

        return $links;
    }

    /**
     * @param string $parent_id id of the parent link
     * returns array of child links
     * @return array $links
     */
    public function getChildLinks($parent_id)
    {
        $query = $this->find()
            ->where(['app_link_id' => $parent_id])
            ->order(['sort' => 'ASC', 'title' => 'ASC']);
        $links = $query->toArray();

        return $links;
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
