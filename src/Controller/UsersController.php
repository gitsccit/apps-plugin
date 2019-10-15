<?php

namespace Apps\Controller;


/**
 * Users Controller
 *
 * @property \Apps\Model\Table\UsersTable $Users
 * @property \Apps\Model\Table\RolesTable $Roles
 * @property \Apps\Model\Table\PermissionsTable $Permissions
 * @property bool|object TableFilter
 *
 * @method \Apps\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
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
            'contain' => ['Managers', 'UserContacts', 'TimeZones'],
            'order' => ['Users.username' => 'ASC'],
        ];
        $users = $this->paginate($this->Users);

        // declare a boolean canSync:enable Synchronization of user information from Active directory:pass to view current plugin
        $canSynchronizeLDAP = $this->Auth->user()->hasPermission('admin.users.synchronizeLdap');
        $this->set(compact('users', 'canSynchronizeLDAP'));
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $id = ($id !== null) ? $id : $this->getRequest()->getSession()->read('Auth.User.id');
        $user = $this->Users->get($id, ['contain' => ['Managers', 'Roles', 'UserContacts', 'UserLogins', 'TimeZones']]);

        $this->set(compact('user'));

        $canSynchronizeLDAP = $this->Auth->user()->hasPermission('admin.users.synchronizeldap');
        $canLoginAs = $this->Auth->user()->hasPermission('admin.session.loginas');
        $canEditRoles = $this->Auth->user()->hasPermission('admin.users.roles');
        $this->set(compact('canSynchronizeLDAP', 'canEditRoles', 'canLoginAs'));
    }

    /**
     * Role management method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function roles($id = null)
    {
        $id = ($id !== null) ? $id : $this->getRequest()->getSession()->read('Auth.User.id');

        if ($this->getRequest()->is(['patch', 'post', 'put'])) {
            $data = $this->getRequest()->getData();
            $new_roles = $data['role'];
            $new_roles = array_map(function ($role) {
                return (int)$role;
            }, $new_roles);
            $data = [
                'roles' => [
                    '_ids' => $new_roles
                ]
            ];
            $user = $this->Users->get($id);
            $user = $this->Users->patchEntity($user, $data);
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user roles have been updated.'));
            }
        }
        $user = $this->Users->get($id, ['contain' => ['Managers', 'Roles', 'UserContacts', 'UserLogins']]);
        $this->set('user', $user);
        $this->loadModel('Apps.Roles');
        $roles = $this->Roles->find('all');
        $this->set(compact('roles'));
        $this->set('isAdmin', $this->Auth->user()->hasPermission('admin'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    /* public function add()
    {
        $user = $this->Users->newEntity();
        if ($this->getRequest()->is('post')) {
            $user = $this->Users->patchEntity($user, $this->getRequest()->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $users = $this->Users->Users->find('list', ['limit' => 200]);
        $roles = $this->Users->Roles->find('list', ['limit' => 200]);
        $this->set(compact('user', 'users', 'roles'));
    } */

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => ['TimeZones']
        ]);
        if ($this->getRequest()->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->getRequest()->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'view', $user->id]);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }

        $timezones = $this->Users->TimeZones->find('list', ['limit' => 200]);
        $this->set(compact('user', 'timezones'));
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    /*
    public function delete($id = null)
    {
        $this->getRequest()->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    } */

    // fetches and outputs to browser a user's profile image
    public function profileImage($id = null)
    {
        // check etag and lastmodified; we don't actually know but if they exist lets assume they're current
        $response = $this->getResponse();
        $modified = $this->getRequest()->getHeader('If-Modified-Since');
        $match = $this->getRequest()->getHeader('If-None-Match');

        if (!empty($modified[0]) && !empty($match[0])) {
            $response = $response->withCache('-1 minute', '+2 days');
            $response = $response->withEtag($match[0]);
            $response = $response->withModified($modified[0]);
            $response->notModified();
            return $response;
        }

        $result = $this->MSGraph->getProfileImage($id);

        $response = $response->withStringBody($result['content']);
        $response = $response->withType($result['mimetype']);
        $response = $response->withCache('-1 minute', '+2 days');
        $response = $response->withEtag(md5($result['content']));
        $response = $response->withModified('now');

        return $response;
    }

    /**
     * this function will synchronize all user information from the active directory
     * @var string $id
     */
    public function synchronizeLdap($id = null)
    {
        // refresh ALL users if called without a user ID
        if (is_null($id)) {
            $this->MSGraph->updateUsers();
            return $this->redirect(['controller' => 'users']);
        }
        // only update this user
        $user = $this->Users->get($id);
        if ($user && $this->MSGraph) {
            $this->MSGraph->updateUsers([$user->ldapid]);
        }

        return $this->redirect(['controller' => 'users', 'action' => 'view', $id]);
    }

    //  public function isAuthorized($user = null)
    //  {
    //based on controller and action obtain the required permission combination of plugin ,controller and action using the ManagePermissionComponent and pass the value to check if permission exits
//        return !$this->ManagePermissions->permissionExists($this->ManagePermissions->requiredPermission()) ? true : $this->hasPermission($this->ManagePermissions->requiredPermission());

    /*if ($action == "refresh") {
        $this->hasPermission('admin');
    }
    if ((!$isDev) && $action == 'edit') {
        return false;
    }
    return true;*/
    //   }

    public function trackHistory()
    {
        $action = $this->getRequest()->getParam('action');
        if (array_search($action, ['profileImage', 'refresh']) !== false) {
            return false;
        }

        return true;
    }
}
