<?php

namespace Apps\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Apps Model
 *
 * @property \Apps\Model\Table\AppLinksTable|\Cake\ORM\Association\HasMany $AppLinks
 *
 * @method \Apps\Model\Entity\App get($primaryKey, $options = [])
 * @method \Apps\Model\Entity\App newEntity($data = null, array $options = [])
 * @method \Apps\Model\Entity\App[] newEntities(array $data, array $options = [])
 * @method \Apps\Model\Entity\App|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Apps\Model\Entity\App saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Apps\Model\Entity\App patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Apps\Model\Entity\App[] patchEntities($entities, array $data, array $options = [])
 * @method \Apps\Model\Entity\App findOrCreate($search, callable $callback = null, $options = [])
 */
class AppsTable extends Table
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

        $this->setTable('apps');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->hasMany('AppLinks', [
            'foreignKey' => 'app_id',
            'conditions' => ['AppLinks.app_link_id IS' => null],
            'sort' => ['AppLinks.sort' => 'ASC', 'AppLinks.title' => 'ASC']
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
            ->scalar('name')
            ->maxLength('name', 30)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->scalar('cake_plugin')
            ->maxLength('cake_plugin', 20)
            ->allowEmptyString('cake_plugin');

        $validator
            ->scalar('route')
            ->maxLength('route', 80)
            ->allowEmptyString('route');

        $validator
            ->nonNegativeInteger('sort')
            ->notEmptyString('sort');

        return $validator;
    }

    /**
     * Turns the app_links into a one-dimensional array with "indent" values
     *
     * @param $links
     * @param int $indent
     * @return array
     */
    public function flatNavLinks($links, $indent = 0)
    {
        $temp = [];

        if (is_array($links) && !empty($links)) {
            foreach ($links as $link) {
                $link->indent = $indent;
                $temp[] = $link;
                if (isset($link->child_links) && !empty($link->child_links)) {
                    $temp = array_merge($temp, $this->flatNavLinks($link->child_links, $indent + 1));
                }
            }
        }

        return $temp;
    }
}
