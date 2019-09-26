<?php

namespace Apps\Controller;

/**
 * StoreSortFields Controller
 *
 * @property \Apps\Model\Table\StoreSortFieldsTable $StoreSortFields
 *
 * @method \Apps\Model\Entity\StoreSortField[]
 */
class StoreSortFieldsController extends AppController
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
        $storeSortFields = $this->paginate($this->StoreSortFields);

        $this->set(compact('storeSortFields'));
    }

    /**
     * View method
     *
     * @param string|null $id Store Sort Field id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $query = $this->StoreSortFields->find('all', [
            'contain' => ['Stores'],
            'conditions' => ['StoreSortFields.id' => $id]
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
        $storeSortField = $this->StoreSortFields->newEntity();
        if ($this->request->is('post')) {
            $storeSortField = $this->StoreSortFields->patchEntity($storeSortField, $this->request->getData());
            if ($this->StoreSortFields->save($storeSortField)) {
                $this->Flash->success(__('The store sort field has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The store sort field could not be saved. Please, try again.'));
        }
        $stores = $this->StoreSortFields->Stores->find('list', ['limit' => 200]);
        $this->set(compact('storeSortField', 'stores'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Store Sort Field id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $storeSortField = $this->StoreSortFields->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $storeSortField = $this->StoreSortFields->patchEntity($storeSortField, $this->request->getData());
            if ($this->StoreSortFields->save($storeSortField)) {
                $this->Flash->success(__('The store sort field has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The store sort field could not be saved. Please, try again.'));
        }
        $stores = $this->StoreSortFields->Stores->find('list', ['limit' => 200]);
        $this->set(compact('storeSortField', 'stores'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Store Sort Field id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $storeSortField = $this->StoreSortFields->get($id);
        if ($this->StoreSortFields->delete($storeSortField)) {
            $this->Flash->success(__('The store sort field has been deleted.'));
        } else {
            $this->Flash->error(__('The store sort field could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
