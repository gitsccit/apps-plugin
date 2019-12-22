<?php
declare(strict_types=1);

namespace Apps\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;

/**
 * FilesStores Model
 *
 * @property \Apps\Model\Table\FilesTable&\Cake\ORM\Association\BelongsTo $Files
 * @property \Apps\Model\Table\StoresTable&\Cake\ORM\Association\BelongsTo $Stores
 *
 * @method \Apps\Model\Entity\FilesStore get($primaryKey, $options = [])
 * @method \Apps\Model\Entity\FilesStore newEntity($data = null, array $options = [])
 * @method \Apps\Model\Entity\FilesStore[] newEntities(array $data, array $options = [])
 * @method \Apps\Model\Entity\FilesStore|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Apps\Model\Entity\FilesStore saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Apps\Model\Entity\FilesStore patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Apps\Model\Entity\FilesStore[] patchEntities($entities, array $data, array $options = [])
 * @method \Apps\Model\Entity\FilesStore findOrCreate($search, callable $callback = null, $options = [])
 */
class FilesStoresTable extends Table
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

        $this->setTable('files_stores');
        $this->setDisplayField('file_id');
        $this->setPrimaryKey(['file_id', 'store_id']);

        $this->belongsTo('Files', [
            'className' => 'Apps.Files',
            'foreignKey' => 'file_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Stores', [
            'className' => 'Apps.Stores',
            'foreignKey' => 'store_id',
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
        $rules->add($rules->existsIn(['file_id'], 'Files'));
        $rules->add($rules->existsIn(['store_id'], 'Stores'));

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
