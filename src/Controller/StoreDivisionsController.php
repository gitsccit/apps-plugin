<?php
declare(strict_types=1);

namespace Apps\Controller;

/**
 * StoreDivisions Controller
 *
 * @property \Apps\Model\Table\StoreDivisionsTable $StoreDivisions
 *
 * @method \Apps\Model\Entity\StoreDivision[]
 */
class StoreDivisionsController extends AppController
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
            'contain' => ['Stores'],
            'order' => ['Stores.name' => 'ASC'],
        ];
        $storeDivisions = $this->paginate($this->StoreDivisions);

        $this->set(compact('storeDivisions'));
    }

    /**
     * View method
     *
     * @param string|null $id Store Division id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $query = $this->StoreDivisions->find('all', [
            'contain' => ['Stores'],
            'conditions' => ['StoreDivisions.id' => $id],
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
        $storeDivision = $this->StoreDivisions->newEntity();
        if ($this->getRequest()->is('post')) {
            $storeDivision = $this->StoreDivisions->patchEntity($storeDivision, $this->getRequest()->getData());
            if ($this->StoreDivisions->save($storeDivision)) {
                $this->Flash->success(__('The store division has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The store division could not be saved. Please, try again.'));
        }
        $stores = $this->StoreDivisions->Stores->find('list', ['limit' => 200]);
        $this->set(compact('storeDivision', 'stores'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Store Division id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $storeDivision = $this->StoreDivisions->get($id, [
            'contain' => [],
        ]);
        if ($this->getRequest()->is(['patch', 'post', 'put'])) {
            $storeDivision = $this->StoreDivisions->patchEntity($storeDivision, $this->getRequest()->getData());
            if ($this->StoreDivisions->save($storeDivision)) {
                $this->Flash->success(__('The store division has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The store division could not be saved. Please, try again.'));
        }
        $stores = $this->StoreDivisions->Stores->find('list', ['limit' => 200]);
        $this->set(compact('storeDivision', 'stores'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Store Division id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->getRequest()->allowMethod(['post', 'delete']);
        $storeDivision = $this->StoreDivisions->get($id);
        if ($this->StoreDivisions->delete($storeDivision)) {
            $this->Flash->success(__('The store division has been deleted.'));
        } else {
            $this->Flash->error(__('The store division could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
