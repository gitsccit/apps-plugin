<?php
declare(strict_types=1);

namespace Apps\Controller;

/**
 * AppLinks Controller
 *
 * @property \Apps\Model\Table\AppLinksTable $AppLinks
 *
 * @method \Apps\Model\Entity\AppLink[]
 */
class AppLinksController extends AppController
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
            'contain' => ['Apps', 'ParentLinks', 'Permissions', 'Files'],
            'order' => ['sort' => 'ASC']
        ];
        $appLinks = $this->paginate($this->AppLinks);

        $this->set(compact('appLinks'));
    }

    /**
     * View method
     *
     * @param string|null $id App Link id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $query = $this->AppLinks->find('all', [
            'contain' => ['Apps', 'ParentLinks', 'Permissions', 'Files', 'ChildLinks'],
            'conditions' => ['AppLinks.id' => $id]
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
        $appLink = $this->AppLinks->newEntity();
        if ($this->getRequest()->is('post')) {
            $appLink = $this->AppLinks->patchEntity($appLink, $this->getRequest()->getData());
            if ($this->AppLinks->save($appLink)) {
                $this->Flash->success(__('The app link has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The app link could not be saved. Please, try again.'));
        }
        $apps = $this->AppLinks->Apps->find('list', ['limit' => 200]);
        $parentLinks = $this->AppLinks->ParentLinks->find('list', ['limit' => 200]);
        $permissions = $this->AppLinks->Permissions->find('list', ['limit' => 200]);
        $files = $this->AppLinks->Files->find('list', ['limit' => 200]);
        $this->set(compact('appLink', 'apps', 'parentLinks', 'permissions', 'files'));
    }

    /**
     * Edit method
     *
     * @param string|null $id App Link id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $appLink = $this->AppLinks->get($id, [
            'contain' => []
        ]);
        if ($this->getRequest()->is(['patch', 'post', 'put'])) {
            $appLink = $this->AppLinks->patchEntity($appLink, $this->getRequest()->getData());
            if ($this->AppLinks->save($appLink)) {
                $this->Flash->success(__('The app link has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The app link could not be saved. Please, try again.'));
        }
        $apps = $this->AppLinks->Apps->find('list', ['limit' => 200]);
        $parentLinks = $this->AppLinks->ParentLinks->find('list', ['limit' => 200]);
        $permissions = $this->AppLinks->Permissions->find('list', ['limit' => 200]);
        $files = $this->AppLinks->Files->find('list', ['limit' => 200]);
        $this->set(compact('appLink', 'apps', 'parentLinks', 'permissions', 'files'));
    }

    /**
     * Delete method
     *
     * @param string|null $id App Link id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->getRequest()->allowMethod(['post', 'delete']);
        $appLink = $this->AppLinks->get($id);
        if ($this->AppLinks->delete($appLink)) {
            $this->Flash->success(__('The app link has been deleted.'));
        } else {
            $this->Flash->error(__('The app link could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
