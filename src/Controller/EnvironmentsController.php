<?php

namespace Apps\Controller;

/**
 * Environments Controller
 *
 * @property \Apps\Model\Table\EnvironmentsTable $Environments
 *
 * @method \Apps\Model\Entity\Environment[]
 */
class EnvironmentsController extends AppController
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
            'contain' => ['Permissions'],
            'order' => ['Environments.name' => 'ASC']
        ];
        $environments = $this->paginate($this->Environments);

        $this->set(compact('environments'));
    }

    /**
     * View method
     *
     * @param string|null $id Environment id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $query = $this->Environments->find('all', [
            'contain' => ['Permissions', 'OptionStores', 'StoreIpMaps'],
            'conditions' => ['Environments.id' => $id]
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
        $environment = $this->Environments->newEntity();
        if ($this->getRequest()->is('post')) {
            $environment = $this->Environments->patchEntity($environment, $this->getRequest()->getData());
            if ($this->Environments->save($environment)) {
                $this->Flash->success(__('The environment has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The environment could not be saved. Please, try again.'));
        }
        $permissions = $this->Environments->Permissions->find('list', ['limit' => 200]);
        $this->set(compact('environment', 'permissions'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Environment id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $environment = $this->Environments->get($id, [
            'contain' => []
        ]);
        if ($this->getRequest()->is(['patch', 'post', 'put'])) {
            $environment = $this->Environments->patchEntity($environment, $this->getRequest()->getData());
            if ($this->Environments->save($environment)) {
                $this->Flash->success(__('The environment has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The environment could not be saved. Please, try again.'));
        }
        $permissions = $this->Environments->Permissions->find('list', ['limit' => 200]);
        $this->set(compact('environment', 'permissions'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Environment id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->getRequest()->allowMethod(['post', 'delete']);
        $environment = $this->Environments->get($id);
        if ($this->Environments->delete($environment)) {
            $this->Flash->success(__('The environment has been deleted.'));
        } else {
            $this->Flash->error(__('The environment could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
