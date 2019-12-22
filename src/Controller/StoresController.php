<?php
declare(strict_types=1);

namespace Apps\Controller;

/**
 * Stores Controller
 *
 * @property \Apps\Model\Table\StoresTable $Stores
 *
 * @method \Apps\Model\Entity\Store[]
 */
class StoresController extends AppController
{
    public $crud = [
        'fallbackTemplatePath' => 'Admin'
    ];

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['ParentStores'],
            'order' => ['Stores.name' => 'ASC']
        ];
        $stores = $this->paginate($this->Stores);

        $this->set(compact('stores'));
    }

    /**
     * View method
     *
     * @param string|null $id Store id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $query = $this->Stores->find('all', [
            'contain' => [
                'ParentStores',
                'OptionStores',
                'StoreDivisions',
                'StoreIpMaps',
                'StoreReturns',
                'StoreSortFields',
                'ChildStores'
            ],
            'conditions' => ['Stores.id' => $id]
        ]);

        $results = $this->Crud->paginateAssociations($query);
        $this->set($results);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $store = $this->Stores->newEntity();
        if ($this->getRequest()->is('post')) {
            $store = $this->Stores->patchEntity($store, $this->getRequest()->getData());
            if ($this->Stores->save($store)) {
                $this->Flash->success(__('The store has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The store could not be saved. Please, try again.'));
        }
        $parentStores = $this->Stores->ParentStores->find('list', ['limit' => 200]);
        $this->set(compact('store', 'parentStores'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Store id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $store = $this->Stores->get($id, [
            'contain' => []
        ]);
        if ($this->getRequest()->is(['patch', 'post', 'put'])) {
            $store = $this->Stores->patchEntity($store, $this->getRequest()->getData());
            if ($this->Stores->save($store)) {
                $this->Flash->success(__('The store has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The store could not be saved. Please, try again.'));
        }
        $parentStores = $this->Stores->ParentStores->find('list', ['limit' => 200]);
        $active = $this->Stores->getEnumOptions('active');
        $this->set(compact('store', 'parentStores', 'active'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Store id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->getRequest()->allowMethod(['post', 'delete']);
        $store = $this->Stores->get($id);
        if ($this->Stores->delete($store)) {
            $this->Flash->success(__('The store has been deleted.'));
        } else {
            $this->Flash->error(__('The store could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
