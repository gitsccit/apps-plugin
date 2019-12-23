<?php
declare(strict_types=1);

namespace Apps\Controller;

/**
 * StoreIpMaps Controller
 *
 * @property \Apps\Model\Table\StoreIpMapsTable $StoreIpMaps
 *
 * @method \Apps\Model\Entity\StoreIpMap[]
 */
class StoreIpMapsController extends AppController
{
    public $crud = [
        'fallbackTemplatePath' => 'Admin',
    ];

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Stores', 'Environments'],
        ];
        $storeIpMaps = $this->paginate($this->StoreIpMaps);

        $this->set(compact('storeIpMaps'));
    }

    /**
     * View method
     *
     * @param string|null $id Store Ip Map id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $query = $this->StoreIpMaps->find('all', [
            'contain' => ['Stores', 'Environments'],
            'conditions' => ['StoreIpMaps.id' => $id],
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
        $storeIpMap = $this->StoreIpMaps->newEmptyEntity();
        if ($this->getRequest()->is('post')) {
            $storeIpMap = $this->StoreIpMaps->patchEntity($storeIpMap, $this->getRequest()->getData());
            if ($this->StoreIpMaps->save($storeIpMap)) {
                $this->Flash->success(__('The store ip map has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The store ip map could not be saved. Please, try again.'));
        }
        $stores = $this->StoreIpMaps->Stores->find('list', ['limit' => 200]);
        $environments = $this->StoreIpMaps->Environments->find('list', ['limit' => 200]);
        $this->set(compact('storeIpMap', 'stores', 'environments'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Store Ip Map id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $storeIpMap = $this->StoreIpMaps->get($id, [
            'contain' => [],
        ]);
        if ($this->getRequest()->is(['patch', 'post', 'put'])) {
            $storeIpMap = $this->StoreIpMaps->patchEntity($storeIpMap, $this->getRequest()->getData());
            if ($this->StoreIpMaps->save($storeIpMap)) {
                $this->Flash->success(__('The store ip map has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The store ip map could not be saved. Please, try again.'));
        }
        $stores = $this->StoreIpMaps->Stores->find('list', ['limit' => 200]);
        $environments = $this->StoreIpMaps->Environments->find('list', ['limit' => 200]);
        $this->set(compact('storeIpMap', 'stores', 'environments'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Store Ip Map id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->getRequest()->allowMethod(['post', 'delete']);
        $storeIpMap = $this->StoreIpMaps->get($id);
        if ($this->StoreIpMaps->delete($storeIpMap)) {
            $this->Flash->success(__('The store ip map has been deleted.'));
        } else {
            $this->Flash->error(__('The store ip map could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
