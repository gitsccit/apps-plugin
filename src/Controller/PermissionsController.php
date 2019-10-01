<?php

namespace Apps\Controller;

/**
 * Permissions Controller
 *
 * @property \Apps\Model\Table\PermissionsTable $Permissions
 *
 * @method \Apps\Model\Entity\Permission[]
 */
class PermissionsController extends AppController
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
            'contain' => ['PermissionGroups'],
            'order' => ['PermissionGroups.name' => 'ASC', 'Permissions.name' => 'ASC']
        ];
        $permissions = $this->paginate($this->Permissions);

        $this->set(compact('permissions'));
    }

    /**
     * View method
     *
     * @param string|null $id Permission id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $query = $this->Permissions->find('all', [
            'contain' => ['PermissionGroups', 'Roles', 'AppLinks', 'Environments'],
            'conditions' => ['Permissions.id' => $id]
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
        $permission = $this->Permissions->newEntity();
        if ($this->getRequest()->is('post')) {
            $permission = $this->Permissions->patchEntity($permission, $this->getRequest()->getData());
            if ($this->Permissions->save($permission)) {
                $this->Flash->success(__('The permission has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The permission could not be saved. Please, try again.'));
        }
        $permissionGroups = $this->Permissions->PermissionGroups->find('list', ['limit' => 200]);
        $roles = $this->Permissions->Roles->find('list', ['limit' => 200]);
        $this->set(compact('permission', 'permissionGroups', 'roles'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Permission id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $permission = $this->Permissions->get($id, [
            'contain' => ['Roles']
        ]);
        if ($this->getRequest()->is(['patch', 'post', 'put'])) {
            $permission = $this->Permissions->patchEntity($permission, $this->getRequest()->getData());
            if ($this->Permissions->save($permission)) {
                $this->Flash->success(__('The permission has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The permission could not be saved. Please, try again.'));
        }
        $permissionGroups = $this->Permissions->PermissionGroups->find('list', ['limit' => 200]);
        $roles = $this->Permissions->Roles->find('list', ['limit' => 200]);
        $this->set(compact('permission', 'permissionGroups', 'roles'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Permission id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->getRequest()->allowMethod(['post', 'delete']);
        $permission = $this->Permissions->get($id);
        if ($this->Permissions->delete($permission)) {
            $this->Flash->success(__('The permission has been deleted.'));
        } else {
            $this->Flash->error(__('The permission could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
