<?php
declare(strict_types=1);

namespace Apps\Controller;

/**
 * StoreReturns Controller
 *
 * @property \Apps\Model\Table\StoreReturnsTable $StoreReturns
 *
 * @method \Apps\Model\Entity\StoreReturn[]
 */
class StoreReturnsController extends AppController
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
            'contain' => ['Stores']
        ];
        $storeReturns = $this->paginate($this->StoreReturns);

        $this->set(compact('storeReturns'));
    }

    /**
     * View method
     *
     * @param string|null $id Store Return id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $query = $this->StoreReturns->find('all', [
            'contain' => ['Stores'],
            'conditions' => ['StoreReturns.id' => $id]
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
        $storeReturn = $this->StoreReturns->newEntity();
        if ($this->getRequest()->is('post')) {
            $storeReturn = $this->StoreReturns->patchEntity($storeReturn, $this->getRequest()->getData());
            if ($this->StoreReturns->save($storeReturn)) {
                $this->Flash->success(__('The store return has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The store return could not be saved. Please, try again.'));
        }
        $stores = $this->StoreReturns->Stores->find('list', ['limit' => 200]);
        $this->set(compact('storeReturn', 'stores'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Store Return id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $storeReturn = $this->StoreReturns->get($id, [
            'contain' => []
        ]);
        if ($this->getRequest()->is(['patch', 'post', 'put'])) {
            $storeReturn = $this->StoreReturns->patchEntity($storeReturn, $this->getRequest()->getData());
            if ($this->StoreReturns->save($storeReturn)) {
                $this->Flash->success(__('The store return has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The store return could not be saved. Please, try again.'));
        }
        $stores = $this->StoreReturns->Stores->find('list', ['limit' => 200]);
        $this->set(compact('storeReturn', 'stores'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Store Return id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->getRequest()->allowMethod(['post', 'delete']);
        $storeReturn = $this->StoreReturns->get($id);
        if ($this->StoreReturns->delete($storeReturn)) {
            $this->Flash->success(__('The store return has been deleted.'));
        } else {
            $this->Flash->error(__('The store return could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
