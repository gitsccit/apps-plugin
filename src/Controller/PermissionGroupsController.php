<?php

namespace Apps\Controller;

/**
 * PermissionGroups Controller
 *
 * @property \Apps\Model\Table\PermissionGroupsTable $PermissionGroups
 *
 * @method \Apps\Model\Entity\PermissionGroup[]
 */
class PermissionGroupsController extends AppController
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
        $permissionGroups = $this->paginate($this->PermissionGroups);

        $this->set(compact('permissionGroups'));
    }

    /**
     * View method
     *
     * @param string|null $id Permission Group id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $query = $this->PermissionGroups->find('all', [
            'contain' => ['Permissions'],
            'conditions' => ['PermissionGroups.id' => $id]
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
        $permissionGroup = $this->PermissionGroups->newEntity();
        if ($this->getRequest()->is('post')) {
            $permissionGroup = $this->PermissionGroups->patchEntity($permissionGroup, $this->getRequest()->getData());
            if ($this->PermissionGroups->save($permissionGroup)) {
                $this->Flash->success(__('The permission group has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The permission group could not be saved. Please, try again.'));
        }
        $this->set(compact('permissionGroup'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Permission Group id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $permissionGroup = $this->PermissionGroups->get($id, [
            'contain' => []
        ]);
        if ($this->getRequest()->is(['patch', 'post', 'put'])) {
            $permissionGroup = $this->PermissionGroups->patchEntity($permissionGroup, $this->getRequest()->getData());
            if ($this->PermissionGroups->save($permissionGroup)) {
                $this->Flash->success(__('The permission group has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The permission group could not be saved. Please, try again.'));
        }
        $this->set(compact('permissionGroup'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Permission Group id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->getRequest()->allowMethod(['post', 'delete']);
        $permissionGroup = $this->PermissionGroups->get($id);
        if ($this->PermissionGroups->delete($permissionGroup)) {
            $this->Flash->success(__('The permission group has been deleted.'));
        } else {
            $this->Flash->error(__('The permission group could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
