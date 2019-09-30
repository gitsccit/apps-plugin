<?php

namespace Apps\Controller;

/**
 * Roles Controller
 *
 * @property \Apps\Model\Table\RolesTable $Roles
 *
 * @method \Apps\Model\Entity\Role[]
 */
class RolesController extends AppController
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
            'order' => ['Roles.name' => 'ASC']
        ];
        $roles = $this->paginate($this->Roles);

        $this->set(compact('roles'));
    }

    /**
     * View method
     *
     * @param string|null $id Role id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $query = $this->Roles->find('all', [
            'contain' => ['Permissions', 'Users'],
            'conditions' => ['Roles.id' => $id]
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
        $role = $this->Roles->newEntity();
        if ($this->request->is('post')) {
            $role = $this->Roles->patchEntity($role, $this->request->getData());
            if ($this->Roles->save($role)) {
                $this->Flash->success(__('The role has been saved.'));

                return $this->redirect(['action' => 'edit', $role->id]);
            }
            $this->Flash->error(__('The role could not be saved. Please, try again.'));
        }
        $permissions = $this->Roles->Permissions->find('list', ['limit' => 200]);
        $users = $this->Roles->Users->find('list', ['limit' => 200]);
        $this->set(compact('role', 'permissions', 'users'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Role id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $role = $this->Roles->get($id, [
            'contain' => ['Permissions', 'Users']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();
            $new_permissions = $data['permission'];
            $new_permissions = array_map(function ($p) {
                return (int)$p;
            }, $new_permissions);
            $name = (!empty($data['name'])) ? $data['name'] : $role->name;
            $data = [
                'name' => $name,
                'permissions' => [
                    '_ids' => $new_permissions
                ]
            ];
            $role = $this->Roles->patchEntity($role, $data);
            if ($this->Roles->save($role)) {
                $this->Flash->success(__("The role $name has been Updated."));
                return $this->redirect(['action' => 'edit', $id]);
            }
            $this->Flash->error(__('The role could not be updated. Please, try again.'));
        }
        $this->loadModel('Apps.PermissionGroups');
        $permissionGroups = $this->PermissionGroups->find('all', [
            'contain' => 'permissions'
        ])->toArray();

        $users = $this->Roles->Users->find('list');
        $this->set(compact('role', 'users', 'permissionGroups'));

    }

    /**
     * Delete method
     *
     * @param string|null $id Role id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    /*  public function delete($id = null)
      {
          $this->request->allowMethod(['post', 'delete']);
          $role = $this->Roles->get($id);
          if ($this->Roles->delete($role)) {
              $this->Flash->success(__('The role has been deleted.'));
          } else {
              $this->Flash->error(__('The role could not be deleted. Please, try again.'));
          }

          return $this->redirect(['action' => 'index']);
      }*/
}
